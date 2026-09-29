<?php

namespace App\Services\Order;

use App\Events\OrderPlaced;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderCardDetail;
use App\Models\OrderHistory;
use App\Models\OrderItem;
use App\Models\OrderOption;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Services\Cart\CartService;
use App\Services\Coupon\CouponService;
use App\Services\Shipping\ShippingCalculatorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class OrderCreationService
{
    public function __construct(
        protected CartService $cartService,
        protected ShippingCalculatorService $shippingService,
        protected CouponService $couponService
    ) {}

    /**
     * Process checkout submission, create order, and return created order model.
     *
     * @throws ValidationException
     */
    public function createFromCheckout(CheckoutRequest $request): Order
    {
        $cart = $this->cartService->syncAndRefreshCart();
        if (empty($cart)) {
            throw ValidationException::withMessages(['cart' => 'Your cart is empty.']);
        }

        // 1. Handle auto-registration if requested for guest user
        $this->handleGuestRegistration($request);

        // 2. Parse billing & shipping names and addresses
        $billingNames   = $this->extractNames($request, 'payment');
        $paymentCountry = Country::find($request->payment_country_id);
        $paymentCountryName = $paymentCountry ? $paymentCountry->name : 'United States';

        $shippingData = $this->resolveShippingAddress($request, $billingNames, $paymentCountryName);

        // 3. Compute totals, shipping, and discounts
        $subtotal = $this->cartService->getSubtotal($cart);
        $isFreeDelivery = $this->cartService->isFreeDelivery($cart);

        $shippingMethodCode = strtolower((string) $request->shippingMethod);
        $shippingMethod = ShippingMethod::where('code', $shippingMethodCode)->first();
        $shippingMethodName = $shippingMethod ? $shippingMethod->name : 'Standard Shipping';

        $shippingCharge = $this->shippingService->calculateCharge(
            $shippingMethodCode,
            $isFreeDelivery,
            $shippingData['city'],
            $shippingData['country_id']
        );

        if ($isFreeDelivery) {
            $shippingMethodName .= ' (Free Delivery)';
        }

        $discount = $this->couponService->calculateDiscount($subtotal, $shippingCharge);
        $finalAmount = max(0, $subtotal + $shippingCharge - $discount);

        // 4. Validate Wallet Balance if paying with wallet
        $this->validateWalletPayment($request->payment_method, $finalAmount);

        $appliedCoupon = $this->couponService->getAppliedCoupon();
        $couponCode = $appliedCoupon ? $appliedCoupon->code : '';

        // 5. Run Database Transaction
        /** @var Order $order */
        $order = DB::transaction(function () use (
            $request,
            $cart,
            $billingNames,
            $paymentCountryName,
            $shippingData,
            $shippingMethodName,
            $shippingCharge,
            $subtotal,
            $discount,
            $finalAmount,
            $couponCode
        ) {
            $order = Order::create([
                'invoice_no'          => rand(100000, 999999),
                'store_id'            => 1,
                'customer_id'         => Auth::guard('customer')->id(),
                'firstname'           => $billingNames['firstname'],
                'lastname'            => $billingNames['lastname'],
                'email'               => $request->email,
                'telephone'           => $request->phone,
                'payment_firstname'   => $billingNames['firstname'],
                'payment_lastname'    => $billingNames['lastname'],
                'payment_address_1'   => $request->address_1,
                'payment_address_2'   => $request->address_2 ?? '',
                'payment_city'        => $request->payment_city,
                'payment_postcode'    => $request->zip,
                'payment_country'     => $paymentCountryName,
                'payment_country_id'  => $request->payment_country_id,
                'payment_phone'       => $request->phone,
                'payment_email'       => $request->email,
                'payment_method'      => $request->payment_method ?? 'Credit Card',
                'shipping_firstname'  => $shippingData['firstname'],
                'shipping_lastname'   => $shippingData['lastname'],
                'shipping_address_1'  => $shippingData['address_1'],
                'shipping_address_2'  => $shippingData['address_2'],
                'shipping_city'       => $shippingData['city'],
                'shipping_postcode'   => $shippingData['postcode'],
                'shipping_country'    => $shippingData['country_name'],
                'shipping_country_id' => $shippingData['country_id'],
                'shipping_phone'      => $shippingData['phone'],
                'shipping_method'     => $shippingMethodName,
                'shipping_charge'     => $shippingCharge,
                'total'               => $subtotal,
                'vat'                 => 0,
                'discount'            => $discount,
                'final_amount'        => $finalAmount,
                'status'              => 1,
                'payment_status'      => 'Pending',
                'ip'                  => $request->ip(),
                'comment'             => $couponCode ? 'Coupon: ' . $couponCode : '',
            ]);

            // Initial Order History
            OrderHistory::create([
                'order_id'        => $order->id,
                'order_status_id' => 1, // Pending
                'notify'          => 0,
                'comment'         => 'Order placed successfully.',
            ]);

            // Card Details if provided
            if ($request->filled('card_number')) {
                OrderCardDetail::create([
                    'order_id'          => $order->id,
                    'payment_method_id' => 0,
                    'card_name'         => $request->card_name ?? '',
                    'card_number'       => (int) preg_replace('/\D/', '', (string) $request->card_number),
                    'card_expiration'   => $request->card_expiration ?? '',
                    'card_cvc'          => (int) ($request->card_cvc ?? 0),
                ]);
            }

            // Create Order Items & Deduct Stock with Pessimistic Locking
            foreach ($cart as $item) {
                // Lock the product row for update to prevent concurrent race condition / overselling
                $product = Product::where('id', $item['id'])->lockForUpdate()->first();

                if (!$product || $product->quantity < (int) $item['quantity']) {
                    $productName = $item['name'] ?? ($product?->name ?? 'Product');
                    throw ValidationException::withMessages([
                        'cart' => "Sorry, '{$productName}' is currently out of stock or has insufficient quantity available.",
                    ]);
                }

                $orderItem = OrderItem::create([
                    'order_id'    => $order->id,
                    'product_id'  => $item['id'],
                    'price'       => $item['price'],
                    'quantity'    => $item['quantity'],
                    'total_price' => $item['price'] * $item['quantity'],
                    'final_price' => $item['price'] * $item['quantity'],
                ]);

                $product->decrement('quantity', (int) $item['quantity']);

                if (!empty($item['options']) && is_array($item['options'])) {
                    foreach ($item['options'] as $optionValueId => $optionData) {
                        OrderOption::create([
                            'order_id'        => $order->id,
                            'order_item_id'   => $orderItem->id,
                            'product_id'      => $item['id'],
                            'option_id'       => $optionData['option_id'] ?? 0,
                            'option_value_id' => (int) $optionValueId,
                            'name'            => $optionData['name'] ?? '',
                            'value'           => $optionData['value'] ?? '',
                        ]);
                    }
                }
            }

            return $order;
        });

        // 6. Post-order actions
        $this->couponService->incrementUsage();
        $this->cartService->clear();
        session()->put('last_order', $order);

        OrderPlaced::dispatch($order);

        return $order;
    }

    /**
     * Auto register guest customer if requested.
     */
    protected function handleGuestRegistration(CheckoutRequest $request): void
    {
        if ($request->filled('new_acc_create') && !Auth::guard('customer')->check()) {
            $names = $this->extractNames($request, 'payment');

            $existingCustomer = Customer::where('email', $request->email)->first();
            if (!$existingCustomer) {
                $customer = Customer::create([
                    'firstname' => $names['firstname'],
                    'lastname'  => $names['lastname'],
                    'email'     => $request->email,
                    'phone'     => $request->phone,
                    'password'  => Hash::make($request->password),
                    'salt'      => substr(md5(uniqid()), 0, 9),
                    'ip'        => $request->ip(),
                    'status'    => 1,
                ]);

                Auth::guard('customer')->login($customer);
            }
        }
    }

    /**
     * Extract firstname and lastname from request inputs.
     */
    protected function extractNames(CheckoutRequest $request, string $prefix): array
    {
        if ($request->filled("{$prefix}_firstname")) {
            return [
                'firstname' => $request->input("{$prefix}_firstname"),
                'lastname'  => $request->input("{$prefix}_lastname", ''),
            ];
        }

        $fullName = trim((string) $request->input('full_name', ''));
        $parts = explode(' ', $fullName, 2);

        return [
            'firstname' => $parts[0] ?? '',
            'lastname'  => $parts[1] ?? '',
        ];
    }

    /**
     * Resolve shipping address details.
     */
    protected function resolveShippingAddress(
        CheckoutRequest $request,
        array $billingNames,
        string $paymentCountryName
    ): array {
        if ($request->filled('shipping_else')) {
            $shipCountryId  = (int) $request->shipping_country_id;
            $shipCountryObj = Country::find($shipCountryId);

            return [
                'firstname'    => $request->shipping_firstname,
                'lastname'     => $request->shipping_lastname,
                'phone'        => $request->shipping_phone,
                'country_id'   => $shipCountryId,
                'country_name' => $shipCountryObj ? $shipCountryObj->name : $paymentCountryName,
                'address_1'    => $request->shipping_address_1,
                'address_2'    => $request->shipping_address_2 ?? '',
                'city'         => $request->shipping_city,
                'postcode'     => $request->shipping_postcode,
            ];
        }

        return [
            'firstname'    => $billingNames['firstname'],
            'lastname'     => $billingNames['lastname'],
            'phone'        => $request->phone,
            'country_id'   => (int) $request->payment_country_id,
            'country_name' => $paymentCountryName,
            'address_1'    => $request->address_1,
            'address_2'    => $request->address_2 ?? '',
            'city'         => $request->payment_city,
            'postcode'     => $request->zip,
        ];
    }

    /**
     * Validate customer wallet balance.
     *
     * @throws ValidationException
     */
    protected function validateWalletPayment(?string $paymentMethodSelected, float $finalAmount): void
    {
        $selected = $paymentMethodSelected ?? 'Credit Card';
        $payMethodModel = PaymentMethod::where('name', $selected)
            ->orWhere('code', $selected)
            ->first();

        $isWallet = ($payMethodModel && strtolower($payMethodModel->code) === 'u_wallet')
            || strtolower($selected) === 'u_wallet';

        if ($isWallet) {
            if (!Auth::guard('customer')->check()) {
                throw ValidationException::withMessages([
                    'payment_method' => 'Please login to pay using your wallet.',
                ]);
            }

            $customerRecord = Customer::find(Auth::guard('customer')->id());
            if (!$customerRecord || $customerRecord->balance < $finalAmount) {
                throw ValidationException::withMessages([
                    'payment_method' => 'Not enough balance in your wallet.',
                ]);
            }
        }
    }
}
