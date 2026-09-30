<?php

namespace App\Services\Cart;

use App\Models\Product;
use App\Models\ProductFreeDelivery;
use App\Services\Coupon\CouponService;

class CartService
{
    public function __construct(
        protected CouponService $couponService
    ) {}

    /**
     * Get current cart from session.
     */
    public function getCart(): array
    {
        return session()->get('cart', []);
    }

    /**
     * Get items saved for later from session.
     */
    public function getSavedForLater(): array
    {
        return session()->get('saved_for_later', []);
    }

    /**
     * Get total quantity count of all items in cart.
     */
    public function getCartCount(): int
    {
        return (int) collect($this->getCart())->sum('quantity');
    }

    /**
     * Eager-load and batch refresh all product prices in cart (solves N+1 query problem).
     */
    public function syncAndRefreshCart(): array
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            return [];
        }

        $productIds = collect($cart)->pluck('id')->filter()->unique()->values();
        $products = Product::with(['special', 'freeDelivery'])
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $updated = false;
        foreach ($cart as $key => &$item) {
            $product = $products->get($item['id']);
            if ($product && $product->status == 1) {
                $optDiff        = (float) ($item['option_price_diff'] ?? 0);
                $effectivePrice = max(0, (float) $product->final_price + $optDiff);
                $originalPrice  = max(0, (float) $product->price + $optDiff);
                $specialPrice   = $product->special_price !== null ? max(0, (float) $product->special_price + $optDiff) : null;
                $isFree         = (bool) $product->freeDelivery;

                if (!isset($item['price']) || (float) $item['price'] !== $effectivePrice
                    || !isset($item['free_delivery']) || $item['free_delivery'] !== $isFree
                    || !isset($item['original_price']) || (float) $item['original_price'] !== $originalPrice) {
                    $item['price']          = $effectivePrice;
                    $item['original_price'] = $originalPrice;
                    $item['special_price']  = $specialPrice;
                    $item['free_delivery']  = $isFree;
                    $updated = true;
                }
            }
        }
        unset($item);

        if ($updated) {
            session()->put('cart', $cart);
        }

        return $cart;
    }

    /**
     * Add product to cart with option variations, pricing calculation, and stock validation.
     */
    public function addToCart(int $productId, int $quantity = 1, ?array $optionsInput = null): array
    {
        $product = Product::with(['special', 'productOptions.option', 'productOptions.optionValue', 'freeDelivery'])
            ->find($productId);

        if (!$product) {
            return [
                'success'     => false,
                'message'     => 'Product not found.',
                'status_code' => 404,
            ];
        }

        if ($product->status != 1) {
            return [
                'success'     => false,
                'message'     => 'This product is currently unavailable.',
                'status_code' => 400,
            ];
        }

        if ($product->quantity <= 0) {
            return [
                'success'     => false,
                'message'     => 'Product is currently out of stock.',
                'status_code' => 400,
            ];
        }

        $hasAvailableOptions = $product->productOptions && $product->productOptions->count() > 0;

        if ($hasAvailableOptions && (empty($optionsInput) || !is_array($optionsInput))) {
            return [
                'success'     => false,
                'has_options' => true,
                'redirect'    => route('products.detail', $product->slug ?: $product->id),
                'message'     => 'Please select product options.',
                'status_code' => 200,
            ];
        }

        $quantity = max(1, $quantity);
        $options = [];
        $optionPriceDiff = 0.0;

        if ($hasAvailableOptions && is_array($optionsInput)) {
            foreach ($optionsInput as $valueId => $optData) {
                if (is_array($optData)) {
                    $valId = (int) $valueId;
                    $po = $product->productOptions->firstWhere('option_value_id', $valId);
                    if ($po) {
                        $priceMod = (float) ($po->price ?? 0);
                        $prefix   = in_array($po->price_prefix, ['+', '-']) ? $po->price_prefix : '+';
                        if ($prefix === '-') {
                            $optionPriceDiff -= $priceMod;
                        } else {
                            $optionPriceDiff += $priceMod;
                        }

                        $options[$valId] = [
                            'option_id'    => (int) $po->option_id,
                            'value_id'     => $valId,
                            'name'         => trim($optData['name'] ?? ($po->option->name ?? 'Option')),
                            'value'        => trim($optData['value'] ?? ($po->optionValue->name ?? '')),
                            'price'        => $priceMod,
                            'price_prefix' => $prefix,
                        ];
                    }
                }
            }
        }

        ksort($options);

        $cartKey = (string) $product->id;
        if (!empty($options)) {
            $optionKey = implode('_', array_keys($options));
            $cartKey   = $product->id . '_' . $optionKey;
        }

        $cart = $this->getCart();
        $currentCartQty = isset($cart[$cartKey]) ? (int) $cart[$cartKey]['quantity'] : 0;

        if ($currentCartQty + $quantity > $product->quantity) {
            $availableToAdd = max(0, $product->quantity - $currentCartQty);
            $msg = $availableToAdd > 0
                ? "You already have {$currentCartQty} in your cart. Only {$availableToAdd} more can be added."
                : "You already have all available stock ({$product->quantity}) in your cart.";

            return [
                'success'     => false,
                'message'     => $msg,
                'status_code' => 400,
            ];
        }

        $effectivePrice = max(0, (float) $product->final_price + $optionPriceDiff);
        $originalPrice  = max(0, (float) $product->price + $optionPriceDiff);
        $specialPrice   = $product->special_price !== null ? max(0, (float) $product->special_price + $optionPriceDiff) : null;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']          += $quantity;
            $cart[$cartKey]['price']              = $effectivePrice;
            $cart[$cartKey]['original_price']     = $originalPrice;
            $cart[$cartKey]['special_price']      = $specialPrice;
            $cart[$cartKey]['option_price_diff']  = $optionPriceDiff;
            $cart[$cartKey]['free_delivery']      = (bool) $product->freeDelivery;
        } else {
            $cart[$cartKey] = [
                'id'                => $product->id,
                'name'              => $product->name,
                'quantity'          => $quantity,
                'price'             => $effectivePrice,
                'original_price'    => $originalPrice,
                'special_price'     => $specialPrice,
                'option_price_diff' => $optionPriceDiff,
                'image'             => $product->main_image ? getImageUrl($product->main_image) : theme_asset('img/Air-Purify.png'),
                'model'             => $product->model,
                'options'           => $options,
                'free_delivery'     => (bool) $product->freeDelivery,
            ];
        }

        session()->put('cart', $cart);

        return [
            'success'     => true,
            'message'     => 'Product added to cart successfully!',
            'cart_count'  => $this->getCartCount(),
            'cart'        => $cart,
            'status_code' => 200,
        ];
    }

    /**
     * Update item quantity in shopping cart.
     */
    public function updateQuantity(string $cartKey, int $quantity): array
    {
        $cart = $this->getCart();

        if (!isset($cart[$cartKey])) {
            return [
                'success'     => false,
                'message'     => 'Item not found in cart.',
                'status_code' => 404,
            ];
        }

        // If quantity is 0 or negative, remove the item safely
        if ($quantity <= 0) {
            unset($cart[$cartKey]);
            if (empty($cart)) {
                $this->couponService->remove();
            }
            session()->put('cart', $cart);

            $subtotal = $this->getSubtotal($cart);
            $discount = $this->couponService->calculateDiscount($subtotal, 0.00);

            return [
                'success'       => true,
                'message'       => 'Item removed from cart.',
                'cart_count'    => $this->getCartCount(),
                'subtotal'      => number_format($subtotal, 2),
                'item_subtotal' => '0.00',
                'discount'      => number_format($discount, 2),
                'cart_empty'    => empty($cart),
                'status_code'   => 200,
            ];
        }

        // Verify requested quantity against database stock
        $productId = $cart[$cartKey]['id'];
        $product = Product::find($productId);
        if ($product && $quantity > $product->quantity) {
            return [
                'success'     => false,
                'message'     => "Only {$product->quantity} items available in stock.",
                'status_code' => 400,
            ];
        }

        $cart[$cartKey]['quantity'] = $quantity;
        session()->put('cart', $cart);

        $subtotal     = $this->getSubtotal($cart);
        $itemSubtotal = $cart[$cartKey]['price'] * $cart[$cartKey]['quantity'];
        $discount     = $this->couponService->calculateDiscount($subtotal, 0.00);

        return [
            'success'       => true,
            'message'       => 'Cart updated successfully!',
            'cart_count'    => $this->getCartCount(),
            'subtotal'      => number_format($subtotal, 2),
            'item_subtotal' => number_format($itemSubtotal, 2),
            'discount'      => number_format($discount, 2),
            'status_code'   => 200,
        ];
    }

    /**
     * Remove item from cart by cart key or fallback product_id.
     */
    public function removeFromCart(string $identifier): array
    {
        $cart = $this->getCart();
        $removed = false;

        if (isset($cart[$identifier])) {
            unset($cart[$identifier]);
            $removed = true;
        } else {
            foreach ($cart as $key => $item) {
                if ((string) ($item['id'] ?? '') === $identifier) {
                    unset($cart[$key]);
                    $removed = true;
                }
            }
        }

        if ($removed) {
            session()->put('cart', $cart);
        }

        if (empty($cart)) {
            $this->couponService->remove();
        }

        $subtotal = $this->getSubtotal($cart);
        $discount = $this->couponService->calculateDiscount($subtotal, 0.00);

        return [
            'success'     => true,
            'message'     => 'Product removed from cart successfully!',
            'cart_count'  => $this->getCartCount(),
            'subtotal'    => number_format($subtotal, 2),
            'discount'    => number_format($discount, 2),
            'cart_empty'  => empty($cart),
            'status_code' => 200,
        ];
    }

    /**
     * Save an item from the cart to Saved for Later.
     */
    public function saveForLater(string $cartKey): array
    {
        $cart = $this->getCart();
        $saved = $this->getSavedForLater();

        if (!isset($cart[$cartKey])) {
            return [
                'success'     => false,
                'message'     => 'Item not found in cart.',
                'status_code' => 404,
            ];
        }

        $saved[$cartKey] = $cart[$cartKey];
        unset($cart[$cartKey]);

        session()->put('cart', $cart);
        session()->put('saved_for_later', $saved);

        if (empty($cart)) {
            $this->couponService->remove();
        }

        $subtotal = $this->getSubtotal($cart);
        $discount = $this->couponService->calculateDiscount($subtotal, 0.00);

        return [
            'success'     => true,
            'message'     => 'Product saved for later successfully!',
            'cart_count'  => $this->getCartCount(),
            'subtotal'    => number_format($subtotal, 2),
            'discount'    => number_format($discount, 2),
            'saved_count' => count($saved),
            'status_code' => 200,
        ];
    }

    /**
     * Move an item from Saved for Later back to Cart.
     */
    public function moveToCart(string $cartKey): array
    {
        $cart = $this->getCart();
        $saved = $this->getSavedForLater();

        if (!isset($saved[$cartKey])) {
            return [
                'success'     => false,
                'message'     => 'Item not found in saved list.',
                'status_code' => 404,
            ];
        }

        $savedItem = $saved[$cartKey];
        $product = Product::with(['special', 'freeDelivery'])->find($savedItem['id']);

        if (!$product || $product->status != 1) {
            return [
                'success'     => false,
                'message'     => 'This product is no longer available.',
                'status_code' => 400,
            ];
        }

        // Refresh price with current active pricing
        $optDiff               = (float) ($savedItem['option_price_diff'] ?? 0);
        $effectivePrice        = max(0, (float) $product->final_price + $optDiff);
        $savedItem['price']          = $effectivePrice;
        $savedItem['original_price'] = max(0, (float) $product->price + $optDiff);
        $savedItem['special_price']  = $product->special_price !== null ? max(0, (float) $product->special_price + $optDiff) : null;
        $savedItem['free_delivery']  = (bool) $product->freeDelivery;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += (int) $savedItem['quantity'];
            $cart[$cartKey]['price']     = $effectivePrice;
        } else {
            $cart[$cartKey] = $savedItem;
        }

        unset($saved[$cartKey]);

        session()->put('cart', $cart);
        session()->put('saved_for_later', $saved);

        $subtotal = $this->getSubtotal($cart);
        $discount = $this->couponService->calculateDiscount($subtotal, 0.00);

        return [
            'success'     => true,
            'message'     => 'Product moved to cart successfully!',
            'cart_count'  => $this->getCartCount(),
            'subtotal'    => number_format($subtotal, 2),
            'discount'    => number_format($discount, 2),
            'status_code' => 200,
        ];
    }

    /**
     * Remove an item from Saved for Later list.
     */
    public function removeSaved(string $cartKey): array
    {
        $saved = $this->getSavedForLater();
        if (isset($saved[$cartKey])) {
            unset($saved[$cartKey]);
            session()->put('saved_for_later', $saved);
        }

        return [
            'success'     => true,
            'message'     => 'Saved product removed successfully!',
            'status_code' => 200,
        ];
    }

    /**
     * Calculate subtotal of cart items.
     */
    public function getSubtotal(?array $cart = null): float
    {
        $cart = $cart ?? $this->getCart();

        return (float) collect($cart)->sum(function ($item) {
            return ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        });
    }

    /**
     * Check if cart qualifies for free delivery.
     */
    public function isFreeDelivery(?array $cart = null): bool
    {
        $cart = $cart ?? $this->getCart();

        if (empty($cart)) {
            return false;
        }

        foreach ($cart as $item) {
            if (!empty($item['free_delivery'])) {
                return true;
            }
        }

        $productIds = collect($cart)->pluck('id')->filter()->unique()->toArray();
        if (!empty($productIds)) {
            return ProductFreeDelivery::whereIn('product_id', $productIds)->exists();
        }

        return false;
    }

    /**
     * Clear cart and applied coupon from session.
     */
    public function clear(): void
    {
        session()->forget(['cart', 'applied_coupon']);
    }
}
