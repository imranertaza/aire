<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\OrderCardDetail;
use App\Models\OrderHistory;
use App\Models\OrderOption;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Display checkout page.
     */

    public function checkout()
    {
        $customer = null;
        if (Auth::guard('customer')->check()) {
            $customer = Customer::find(Auth::guard('customer')->id());
        }
        $cart = session()->get('cart', []);

        $zoneRateService = app(\App\Services\Shipping\ZoneRateShippingService::class);
        $zoneService     = app(\App\Services\Shipping\ZoneShippingService::class);
        $flatService     = app(\App\Services\Shipping\FlatShippingService::class);
        $weightService   = app(\App\Services\Shipping\WeightShippingService::class);

        $shippingMethods = \App\Models\ShippingMethod::where('status', 1)->get()->map(function ($method) use ($zoneRateService, $zoneService, $flatService, $weightService) {
            if ($method->code === 'zone_rate') {
                $method->cost = $zoneRateService->getSettings(null, 223)->calculateShipping();
                $method->description = 'Zone Rate delivery calculated based on weight, item count, or location price.';
            } else if ($method->code === 'zone') {
                $method->cost = $zoneService->getSettings()->calculateShipping();
                $method->description = 'Zone Based Shipping (Inside Dhaka vs Outside Dhaka).';
            } else if ($method->code === 'flat') {
                $method->cost = $flatService->getSettings()->calculateShipping();
                $method->description = 'Flat Rate Shipping for standard delivery.';
            } else if ($method->code === 'weight') {
                $method->cost = $weightService->getSettings()->calculateShipping();
                $method->description = 'Weight Based Shipping for item packages.';
            } else {
                $setting = \App\Models\ShippingSetting::where('shipping_method_id', $method->id)->first();
                $method->cost = $setting ? (float)$setting->value : 0.00;
                $method->description = 'Standard shipping delivery service.';
            }
            return $method;
        });

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        $defaultShippingCost = count($shippingMethods) > 0 ? $shippingMethods[0]->cost : 0.00;
        $discount = $this->calculateDiscount($subtotal, $defaultShippingCost);

        $paymentMethods = \App\Models\PaymentMethod::active()->orderBy('id')->get();
        $countries = \App\Models\Country::active()->orderBy('name')->get();

        return \theme_view('checkout.index', compact('customer', 'cart', 'shippingMethods', 'discount', 'paymentMethods', 'countries'));
    }

    /**
     * Handle order submission checkout.
     */

    public function postCheckout(Request $request, \App\Services\Shipping\ZoneRateShippingService $zoneRateService, \App\Services\Shipping\FlatShippingService $flatService, \App\Services\Shipping\WeightShippingService $weightService, \App\Services\Shipping\ZoneShippingService $zoneService)
    {
        $rules = [
            'email'              => 'required|email|max:96',
            'phone'              => 'required|string|max:32',
            'payment_country_id' => 'required|integer',
            'payment_city'       => 'required|string|max:128',
            'address_1'          => 'required|string|max:128',
            'address_2'          => 'nullable|string|max:128',
            'zip'                => 'required|string|max:10',
            'shippingMethod'     => 'required|string',
            'payment_method'     => 'nullable|string',
        ];

        if ($request->has('payment_firstname') && $request->has('payment_lastname')) {
            $rules['payment_firstname'] = 'required|string|max:32';
            $rules['payment_lastname']  = 'required|string|max:32';
        } else {
            $rules['full_name'] = 'required|string|max:64';
        }

        if ($request->filled('new_acc_create')) {
            $rules['password'] = 'required|string|min:6';
        }

        if ($request->filled('shipping_else')) {
            $rules['shipping_firstname']  = 'required|string|max:32';
            $rules['shipping_lastname']   = 'required|string|max:32';
            $rules['shipping_phone']      = 'required|string|max:32';
            $rules['shipping_country_id'] = 'required|integer';
            $rules['shipping_city']       = 'required|string|max:128';
            $rules['shipping_address_1']  = 'required|string|max:128';
            $rules['shipping_postcode']   = 'required|string|max:10';
        }

        $request->validate($rules);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->withErrors(['cart' => 'Your cart is empty.']);
        }

        // Account creation if requested and user is guest
        if ($request->filled('new_acc_create') && !Auth::guard('customer')->check()) {
            if ($request->filled('payment_firstname')) {
                $cFirst = $request->payment_firstname;
                $cLast  = $request->payment_lastname;
            } else {
                $parts = explode(' ', trim($request->full_name), 2);
                $cFirst = $parts[0];
                $cLast  = $parts[1] ?? '';
            }

            $existingCustomer = Customer::where('email', $request->email)->first();
            if (!$existingCustomer) {
                $customer = Customer::create([
                    'firstname'  => $cFirst,
                    'lastname'   => $cLast,
                    'email'      => $request->email,
                    'phone'      => $request->phone,
                    'password'   => Hash::make($request->password),
                    'salt'       => substr(md5(uniqid()), 0, 9),
                    'ip'         => $request->ip(),
                    'status'     => 1,
                ]);

                Auth::guard('customer')->login($customer);
                session()->put('customer_id', $customer->id);
                session()->put('customer_name', $customer->firstname . ' ' . $customer->lastname);
                session()->put('customer_email', $customer->email);
            }
        }

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        if ($request->filled('payment_firstname')) {
            $firstname = $request->payment_firstname;
            $lastname  = $request->payment_lastname;
        } else {
            $parts = explode(' ', trim($request->full_name), 2);
            $firstname = $parts[0];
            $lastname  = $parts[1] ?? '';
        }

        $paymentCountry = \App\Models\Country::find($request->payment_country_id);
        $paymentCountryName = $paymentCountry ? $paymentCountry->name : 'United States';

        // Shipping address determination
        if ($request->filled('shipping_else')) {
            $shipFirst       = $request->shipping_firstname;
            $shipLast        = $request->shipping_lastname;
            $shipPhone       = $request->shipping_phone;
            $shipCountryId   = $request->shipping_country_id;
            $shipCountryObj  = \App\Models\Country::find($shipCountryId);
            $shipCountryName = $shipCountryObj ? $shipCountryObj->name : $paymentCountryName;
            $shipAddr1       = $request->shipping_address_1;
            $shipAddr2       = $request->shipping_address_2 ?? '';
            $shipCity        = $request->shipping_city;
            $shipZip         = $request->shipping_postcode;
        } else {
            $shipFirst       = $firstname;
            $shipLast        = $lastname;
            $shipPhone       = $request->phone;
            $shipCountryId   = $request->payment_country_id;
            $shipCountryName = $paymentCountryName;
            $shipAddr1       = $request->address_1;
            $shipAddr2       = $request->address_2 ?? '';
            $shipCity        = $request->payment_city;
            $shipZip         = $request->zip;
        }

        $shippingMethodCode = strtolower($request->shippingMethod);
        $shippingCharge = 0.00;
        $shippingMethodName = 'Standard Shipping';

        $shippingMethod = \App\Models\ShippingMethod::where('code', $shippingMethodCode)->first();
        if ($shippingMethod) {
            $shippingMethodName = $shippingMethod->name;
        }

        if ($shippingMethodCode === 'flat') {
            $shippingCharge = $flatService->getSettings()->calculateShipping();
        } else if ($shippingMethodCode === 'zone') {
            $shippingCharge = $zoneService->getSettings()->calculateShipping($shipCity);
        } else if ($shippingMethodCode === 'weight') {
            $shippingCharge = $weightService->getSettings()->calculateShipping();
        } else if ($shippingMethodCode === 'zone_rate') {
            $shippingCharge = $zoneRateService->getSettings($shipCity, $shipCountryId)->calculateShipping();
        } else {
            $shippingCharge = $shippingMethod ? (float) $shippingMethod->cost : 0.00;
        }

        $discount = $this->calculateDiscount($subtotal, $shippingCharge);
        $finalAmount = max(0, $subtotal + $shippingCharge - $discount);

        // Wallet Balance check matching cCart reference
        $paymentMethodSelected = $request->payment_method ?? 'Credit Card';
        $payMethodModel = \App\Models\PaymentMethod::where('name', $paymentMethodSelected)
            ->orWhere('code', $paymentMethodSelected)
            ->first();
        $isWalletPayment = ($payMethodModel && strtolower($payMethodModel->code) === 'u_wallet')
            || strtolower($paymentMethodSelected) === 'u_wallet';

        if ($isWalletPayment) {
            if (!Auth::guard('customer')->check()) {
                return back()->withErrors(['payment_method' => 'Please login to pay using your wallet.'])->withInput();
            }
            $customerRecord = \App\Models\Customer::find(Auth::guard('customer')->id());
            if (!$customerRecord || $customerRecord->balance < $finalAmount) {
                return back()->withErrors(['payment_method' => 'Not enough balance'])->withInput();
            }
        }

        $coupon = session()->get('applied_coupon');
        $couponCode = $coupon ? $coupon->code : '';

        if ($coupon) {
            $coupon->increment('total_used');
        }

        $order = null;

        DB::transaction(function () use (
            $request, $cart,
            $firstname, $lastname, $paymentCountryName,
            $shipFirst, $shipLast, $shipAddr1, $shipAddr2, $shipCity, $shipZip,
            $shipCountryName, $shipCountryId, $shipPhone,
            $shippingMethodName, $shippingCharge,
            $subtotal, $discount, $finalAmount, $couponCode,
            &$order
        ) {
            // --- Create the Order ---
            $order = \App\Models\Order::create([
                'invoice_no'           => rand(100000, 999999),
                'store_id'             => 1,
                'customer_id'          => Auth::guard('customer')->id(),
                'firstname'            => $firstname,
                'lastname'             => $lastname,
                'email'                => $request->email,
                'telephone'            => $request->phone,
                'payment_firstname'    => $firstname,
                'payment_lastname'     => $lastname,
                'payment_address_1'    => $request->address_1,
                'payment_address_2'    => $request->address_2 ?? '',
                'payment_city'         => $request->payment_city,
                'payment_postcode'     => $request->zip,
                'payment_country'      => $paymentCountryName,
                'payment_country_id'   => $request->payment_country_id,
                'payment_phone'        => $request->phone,
                'payment_email'        => $request->email,
                'payment_method'       => $request->payment_method ?? 'Credit Card',
                'shipping_firstname'   => $shipFirst,
                'shipping_lastname'    => $shipLast,
                'shipping_address_1'   => $shipAddr1,
                'shipping_address_2'   => $shipAddr2,
                'shipping_city'        => $shipCity,
                'shipping_postcode'    => $shipZip,
                'shipping_country'     => $shipCountryName,
                'shipping_country_id'  => $shipCountryId,
                'shipping_phone'       => $shipPhone,
                'shipping_method'      => $shippingMethodName,
                'shipping_charge'      => $shippingCharge,
                'total'                => $subtotal,
                'vat'                  => 0,
                'discount'             => $discount,
                'final_amount'         => $finalAmount,
                'status'               => 1,
                'payment_status'       => 'Pending',
                'ip'                   => $request->ip(),
                'comment'              => $couponCode ? 'Coupon: ' . $couponCode : '',
            ]);

            // --- Log initial Order History (Pending status) ---
            OrderHistory::create([
                'order_id'        => $order->id,
                'order_status_id' => 1, // 1 = Pending
                'notify'          => 0,
                'comment'         => 'Order placed successfully.',
            ]);

            // --- Log Card Details if card payment info provided ---
            if ($request->filled('card_number')) {
                OrderCardDetail::create([
                    'order_id'          => $order->id,
                    'payment_method_id' => 0,
                    'card_name'         => $request->card_name ?? '',
                    'card_number'       => (int) preg_replace('/\D/', '', $request->card_number),
                    'card_expiration'   => $request->card_expiration ?? '',
                    'card_cvc'          => (int) ($request->card_cvc ?? 0),
                ]);
            }

            // --- Create Order Items, deduct stock, and save Options ---
            foreach ($cart as $cartKey => $item) {
                $orderItem = \App\Models\OrderItem::create([
                    'order_id'    => $order->id,
                    'product_id'  => $item['id'],
                    'price'       => $item['price'],
                    'quantity'    => $item['quantity'],
                    'total_price' => $item['price'] * $item['quantity'],
                    'final_price' => $item['price'] * $item['quantity'],
                ]);

                // Deduct product stock quantity (matching cCart reference)
                Product::where('id', $item['id'])->decrement('quantity', $item['quantity']);

                // Persist selected options for this order item (matching cCart cc_order_option)
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
        });

        // Clear Cart & Coupon
        session()->forget(['cart', 'applied_coupon']);
        session()->put('last_order', $order);

        // Process payment via PaymentManager service (Matching cCart Payment Libraries)
        $paymentManager = app(\App\Services\Payment\PaymentManager::class);
        return $paymentManager->process($order, $finalAmount, $request);
    }

    /**
     * AJAX endpoint to compute dynamic shipping charge matching cCart reference.
     */

    public function getShippingRate(Request $request, \App\Services\Shipping\ZoneRateShippingService $zoneRateService, \App\Services\Shipping\FlatShippingService $flatService, \App\Services\Shipping\WeightShippingService $weightService, \App\Services\Shipping\ZoneShippingService $zoneService, \App\Services\Offer\OfferCalculateService $offerService)
    {
        try {
            $cityId    = $request->input('city_id', $request->input('shipCityId'));
            $countryId = $request->input('country_id', $request->input('payment_country_id'));
            $paymethod = strtolower($request->input('paymethod', $request->input('shipping_method', 'zone_rate')));

            $charge = 0.00;

            if ($paymethod === 'flat') {
                $charge = $flatService->getSettings()->calculateShipping();
            } else if ($paymethod === 'zone') {
                $charge = $zoneService->getSettings()->calculateShipping($cityId);
            } else if ($paymethod === 'weight') {
                $charge = $weightService->getSettings()->calculateShipping();
            } else if ($paymethod === 'zone_rate') {
                $charge = $zoneRateService->getSettings($cityId, $countryId)->calculateShipping();
            } else {
                $shippingMethod = \App\Models\ShippingMethod::where('code', $paymethod)->orWhere('name', 'like', '%' . $paymethod . '%')->first();
                $charge = $shippingMethod ? (float) $shippingMethod->cost : 0.00;
            }

            $cart = session()->get('cart', []);
            $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

            // Calculate coupon discount
            $couponDiscount = $this->calculateDiscount($subtotal, $charge);

            // Calculate offer & promo discount matching cCart Offer_calculate library
            $geoZoneId = $zoneRateService->getGeoZoneId($countryId, $cityId);
            $offerResult = $offerService->calculateOfferDiscount($cart, $charge, $geoZoneId);

            $totalDiscount = $couponDiscount + ($offerResult['total_offer_discount'] ?? 0);
            $grandTotal = max(0, $subtotal + $charge - $totalDiscount);

            return response()->json([
                'success'            => true,
                'charge'             => $charge,
                'formatted_charge'   => '$' . number_format($charge, 2),
                'discount'           => $totalDiscount,
                'formatted_discount' => '$' . number_format($totalDiscount, 2),
                'subtotal'           => $subtotal,
                'formatted_subtotal' => '$' . number_format($subtotal, 2),
                'grand_total'        => $grandTotal,
                'formatted_total'    => '$' . number_format($grandTotal, 2),
            ]);
        } catch (\Throwable $e) {
            Log::error('getShippingRate error: ' . $e->getMessage());
            return response()->json([
                'success'            => true,
                'charge'             => 0.00,
                'formatted_charge'   => 'Free',
                'discount'           => 0.00,
                'formatted_discount' => '$0.00',
                'subtotal'           => 0.00,
                'formatted_subtotal' => '$0.00',
                'grand_total'        => 0.00,
                'formatted_total'    => '$0.00',
            ]);
        }
    }

    /**
     * Apply coupon discount.
     */

    public function applyCoupon(Request $request)
    {
        $code = trim($request->input('coupon_code', $request->input('code', '')));

        if (empty($code)) {
            return response()->json(['success' => false, 'message' => 'Please enter a valid coupon code.'], 400);
        }

        $coupon = Coupon::where('code', $code)
            ->where('status', 1)
            ->where(function ($q) {
                $today = date('Y-m-d');
                $q->whereNull('date_start')->orWhere('date_start', '<=', $today);
            })
            ->where(function ($q) {
                $today = date('Y-m-d');
                $q->whereNull('date_end')->orWhere('date_end', '>=', $today);
            })
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon code.']);
        }

        if ($coupon->total_useable !== null && $coupon->total_used >= $coupon->total_useable) {
            return response()->json(['success' => false, 'message' => 'This coupon has reached its usage limit.']);
        }

        if ($coupon->for_registered_user == 1 && !Auth::guard('customer')->check()) {
            return response()->json(['success' => false, 'message' => 'This coupon requires a registered customer account.']);
        }

        if (Auth::guard('customer')->check()) {
            $alreadyUsed = \App\Models\Order::where('customer_id', Auth::guard('customer')->id())
                ->where('comment', 'like', '%Coupon: ' . $request->coupon_code . '%')
                ->exists();
            if ($alreadyUsed) {
                return response()->json(['success' => false, 'message' => 'You have already used this coupon code.']);
            }
        }

        session()->put('applied_coupon', $coupon);

        // Fetch cart subtotal and calculate discount value
        $cart = session()->get('cart', []);
        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $discount = $this->calculateDiscount($subtotal, 0.00);

        return response()->json([
            'success' => true,
            'message' => 'Coupon code applied successfully!',
            'discount' => $discount,
            'coupon' => $coupon
        ]);
    }

    /**
     * Remove applied coupon from session.
     */

    public function removeCoupon()
    {
        session()->forget('applied_coupon');

        $cart = session()->get('cart', []);
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return response()->json([
            'success'  => true,
            'message'  => 'Coupon removed successfully.',
            'subtotal' => $subtotal,
        ]);
    }

    /**
     * Helper to compute coupon discount.
     */

    private function calculateDiscount($subtotal, $shippingCharge)
    {
        $discount = 0.00;
        if (session()->has('applied_coupon')) {
            $coupon = session()->get('applied_coupon');
            if ($coupon->discount_on == 1) { // Product
                if ($coupon->discount_type == 1) { // Percentage
                    $discount = $subtotal * ($coupon->discount / 100);
                } else { // Flat
                    $discount = (float)$coupon->discount;
                }
            } else { // Shipping
                if ($coupon->discount_type == 1) {
                    $discount = $shippingCharge * ($coupon->discount / 100);
                } else {
                    $discount = (float)$coupon->discount;
                }
                if ($discount > $shippingCharge) {
                    $discount = $shippingCharge;
                }
            }
        }
        return min($discount, $subtotal + $shippingCharge);
    }

    /**
     * Display order confirmation page.
     */

    public function orderConfirm(Request $request)
    {
        $order = null;
        if ($request->has('order_id')) {
            $order = \App\Models\Order::find($request->order_id);
            if ($order) {
                if ($request->get('payment') === 'success' || $request->has('tx')) {
                    $order->payment_status = 'Paid';
                    $order->status = 2; // Complete
                    $order->save();
                }
                session()->put('last_order', $order);
            }
        }
        if (!$order) {
            $order = session()->get('last_order');
        }
        return \theme_view('order-confirm', compact('order'));
    }

    /**
     * Fetch zones by country_id for checkout dropdown via AJAX.
     */

    public function getZones(Request $request)
    {
        $countryId = $request->input('country_id');
        if (!$countryId) {
            return response()->json(['success' => true, 'zones' => []]);
        }
        $zones = \App\Models\Zone::where('country_id', $countryId)->orderBy('name')->get();
        return response()->json(['success' => true, 'zones' => $zones]);
    }
}
