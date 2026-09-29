<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\CartItemActionRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Services\Cart\CartService;
use App\Services\Coupon\CouponService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected CouponService $couponService
    ) {}

    /**
     * Display shopping cart.
     */
    public function cart()
    {
        $cart          = $this->cartService->syncAndRefreshCart();
        $savedForLater = $this->cartService->getSavedForLater();
        $subtotal      = $this->cartService->getSubtotal($cart);
        $discount      = $this->couponService->calculateDiscount($subtotal, 0.00);

        return \theme_view('cart.index', compact('cart', 'savedForLater', 'discount'));
    }

    /**
     * Add product to cart.
     */
    public function addToCart(AddToCartRequest $request): JsonResponse
    {
        $result = $this->cartService->addToCart(
            (int) $request->validated('product_id'),
            (int) $request->input('quantity', 1),
            $request->input('options')
        );

        $statusCode = $result['status_code'] ?? 200;
        unset($result['status_code']);

        return response()->json($result, $statusCode);
    }

    /**
     * Update cart items quantity.
     */
    public function updateCart(UpdateCartRequest $request): JsonResponse
    {
        $result = $this->cartService->updateQuantity(
            (string) $request->validated('product_id'),
            (int) $request->validated('quantity')
        );

        $statusCode = $result['status_code'] ?? 200;
        unset($result['status_code']);

        return response()->json($result, $statusCode);
    }

    /**
     * Remove item from cart.
     */
    public function removeFromCart(CartItemActionRequest $request): JsonResponse
    {
        $result = $this->cartService->removeFromCart(
            (string) $request->validated('product_id')
        );

        $statusCode = $result['status_code'] ?? 200;
        unset($result['status_code']);

        return response()->json($result, $statusCode);
    }

    /**
     * Alias for removeFromCart method.
     */
    public function removeCart(CartItemActionRequest $request): JsonResponse
    {
        return $this->removeFromCart($request);
    }

    /**
     * Save an item from the cart to Saved for Later.
     */
    public function saveForLater(CartItemActionRequest $request): JsonResponse
    {
        $result = $this->cartService->saveForLater(
            (string) $request->validated('product_id')
        );

        $statusCode = $result['status_code'] ?? 200;
        unset($result['status_code']);

        return response()->json($result, $statusCode);
    }

    /**
     * Move an item from Saved for Later back to Cart.
     */
    public function moveToCart(CartItemActionRequest $request): JsonResponse
    {
        $result = $this->cartService->moveToCart(
            (string) $request->validated('product_id')
        );

        $statusCode = $result['status_code'] ?? 200;
        unset($result['status_code']);

        return response()->json($result, $statusCode);
    }

    /**
     * Remove an item from Saved for Later list.
     */
    public function removeSaved(CartItemActionRequest $request): JsonResponse
    {
        $result = $this->cartService->removeSaved(
            (string) $request->validated('product_id')
        );

        $statusCode = $result['status_code'] ?? 200;
        unset($result['status_code']);

        return response()->json($result, $statusCode);
    }

    /**
     * Get total items in cart.
     */
    public function getCartCount(): JsonResponse
    {
        return response()->json([
            'cart_count' => $this->cartService->getCartCount(),
        ]);
    }
}
