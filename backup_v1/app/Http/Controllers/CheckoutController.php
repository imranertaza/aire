<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkout\ApplyCouponRequest;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Http\Requests\Checkout\ShippingRateRequest;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Zone;
use App\Services\Cart\CartService;
use App\Services\Coupon\CouponService;
use App\Services\Order\OrderCreationService;
use App\Services\Payment\PaymentManager;
use App\Services\Shipping\ShippingCalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected ShippingCalculatorService $shippingService,
        protected CouponService $couponService,
        protected OrderCreationService $orderCreationService,
        protected PaymentManager $paymentManager
    ) {}

    /**
     * Display checkout page.
     */
    public function checkout(): View
    {
        $customer = Auth::guard('customer')->check()
            ? Customer::find(Auth::guard('customer')->id())
            : null;

        $cart = $this->cartService->syncAndRefreshCart();
        $subtotal = $this->cartService->getSubtotal($cart);
        $isCartFreeDelivery = $this->cartService->isFreeDelivery($cart);

        $shippingMethods = $this->shippingService->getAvailableMethods($isCartFreeDelivery);
        $defaultShippingCost = $shippingMethods->first()?->cost ?? 0.00;
        $discount = $this->couponService->calculateDiscount($subtotal, $defaultShippingCost);

        $paymentMethods = PaymentMethod::active()->orderBy('id')->get();
        $countries = Country::active()->orderBy('name')->get();

        return \theme_view('checkout.index', compact(
            'customer',
            'cart',
            'shippingMethods',
            'discount',
            'paymentMethods',
            'countries',
            'isCartFreeDelivery',
            'defaultShippingCost',
            'subtotal'
        ));
    }

    /**
     * Handle order submission checkout.
     */
    public function postCheckout(CheckoutRequest $request): mixed
    {
        $cart = $this->cartService->getCart();
        if (empty($cart)) {
            return Redirect::route('cart')->withErrors(['cart' => 'Your cart is empty.']);
        }

        $order = $this->orderCreationService->createFromCheckout($request);

        return $this->paymentManager->process($order, $order->final_amount, $request);
    }

    /**
     * AJAX endpoint to compute dynamic shipping charge and totals.
     */
    public function getShippingRate(ShippingRateRequest $request): JsonResponse
    {
        try {
            $cityId    = (string) $request->input('city_id', '');
            $countryId = (int) $request->input('country_id', 0);
            $paymethod = (string) $request->input('paymethod', 'zone_rate');

            $cart = $this->cartService->getCart();
            $isFreeDelivery = $this->cartService->isFreeDelivery($cart);
            $subtotal = $this->cartService->getSubtotal($cart);

            $charge = $this->shippingService->calculateCharge($paymethod, $isFreeDelivery, $cityId, $countryId);
            $couponDiscount = $this->couponService->calculateDiscount($subtotal, $charge);

            $summary = $this->shippingService->calculateRateSummary(
                $cart,
                $paymethod,
                $isFreeDelivery,
                $cityId,
                $countryId,
                $couponDiscount
            );

            return response()->json(array_merge(['success' => true], $summary));
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
    public function applyCoupon(ApplyCouponRequest $request): JsonResponse
    {
        $code = (string) $request->input('coupon_code');
        $subtotal = $this->cartService->getSubtotal();

        $result = $this->couponService->validateAndApply($code, $subtotal);

        if (!$result['success']) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    }

    /**
     * Remove applied coupon from session.
     */
    public function removeCoupon(): JsonResponse
    {
        $this->couponService->remove();
        $subtotal = $this->cartService->getSubtotal();

        return response()->json([
            'success'  => true,
            'message'  => 'Coupon removed successfully.',
            'subtotal' => $subtotal,
        ]);
    }

    /**
     * Display order confirmation page.
     */
    public function orderConfirm(Request $request): View
    {
        $order = null;

        if ($request->filled('order_id')) {
            $order = Order::find($request->order_id);
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
    public function getZones(Request $request): JsonResponse
    {
        $countryId = $request->input('country_id');
        if (!$countryId) {
            return response()->json(['success' => true, 'zones' => []]);
        }

        $zones = Zone::where('country_id', $countryId)->orderBy('name')->get();

        return response()->json(['success' => true, 'zones' => $zones]);
    }
}
