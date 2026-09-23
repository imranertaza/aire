<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display shopping cart.
     */

    public function cart()
    {
        $cart = session()->get('cart', []);
        $savedForLater = session()->get('saved_for_later', []);

        // Eager-load all products in cart in a single query (resolving N+1 query problem)
        $productIds = collect($cart)->pluck('id')->filter()->unique()->values();
        $products = Product::with(['special', 'freeDelivery'])
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $updated = false;
        foreach ($cart as $key => &$item) {
            $product = $products->get($item['id']);
            if ($product && $product->status == 1) {
                $optDiff = (float) ($item['option_price_diff'] ?? 0);
                $effectivePrice = max(0, (float) $product->final_price + $optDiff);
                $originalPrice = max(0, (float) $product->price + $optDiff);
                $specialPrice = $product->special_price !== null ? max(0, (float) $product->special_price + $optDiff) : null;
                $isFree = (bool) $product->freeDelivery;

                if (!isset($item['price']) || (float)$item['price'] != $effectivePrice
                    || !isset($item['free_delivery']) || $item['free_delivery'] !== $isFree
                    || !isset($item['original_price']) || (float)$item['original_price'] != $originalPrice) {
                    $item['price'] = $effectivePrice;
                    $item['original_price'] = $originalPrice;
                    $item['special_price'] = $specialPrice;
                    $item['free_delivery'] = $isFree;
                    $updated = true;
                }
            }
        }
        unset($item);

        if ($updated) {
            session()->put('cart', $cart);
        }

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        $discount = $this->calculateDiscount($subtotal, 0.00);

        return \theme_view('cart.index', compact('cart', 'savedForLater', 'discount'));
    }

    /**
     * Add product to cart.
     */

    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        if (!$productId) {
            return response()->json(['success' => false, 'message' => 'Product ID is required.'], 400);
        }

        $product = Product::with(['special', 'productOptions.option', 'productOptions.optionValue', 'freeDelivery'])->find($productId);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }

        // Active status verification
        if ($product->status != 1) {
            return response()->json(['success' => false, 'message' => 'This product is currently unavailable.'], 400);
        }

        // Stock availability verification
        if ($product->quantity <= 0) {
            return response()->json(['success' => false, 'message' => 'Product is currently out of stock.'], 400);
        }

        // If product has options but none were provided (e.g., quick add from catalog grid), prompt to choose options
        $hasAvailableOptions = $product->productOptions && $product->productOptions->count() > 0;
        $optionsInput = $request->input('options');

        if ($hasAvailableOptions && (empty($optionsInput) || !is_array($optionsInput))) {
            return response()->json([
                'success'     => false,
                'has_options' => true,
                'redirect'    => route('products.detail', $product->slug ?: $product->id),
                'message'     => 'Please select product options.',
            ]);
        }

        $cart = session()->get('cart', []);
        $quantity = max(1, (int)$request->input('quantity', 1));

        // Collect selected options and calculate price adjustments
        $options = [];
        $optionPriceDiff = 0.0;

        if ($hasAvailableOptions && is_array($optionsInput)) {
            foreach ($optionsInput as $valueId => $optData) {
                if (is_array($optData)) {
                    $valId = (int) $valueId;
                    $po = $product->productOptions->firstWhere('option_value_id', $valId);
                    if ($po) {
                        $priceMod = (float) ($po->price ?? 0);
                        // Fix prefix: default to '+' (subtract column in Laravel is stock subtraction, not price reduction)
                        $prefix = in_array($po->price_prefix, ['+', '-']) ? $po->price_prefix : '+';
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

        // Sort options by key for deterministic cart key generation
        ksort($options);

        // Build a unique cart key based on product + selected option combination
        $cartKey = (string) $product->id;
        if (!empty($options)) {
            $optionKey = implode('_', array_keys($options));
            $cartKey   = $product->id . '_' . $optionKey;
        }

        // Check if existing quantity in cart + requested quantity exceeds stock
        $currentCartQty = isset($cart[$cartKey]) ? (int)$cart[$cartKey]['quantity'] : 0;
        if ($currentCartQty + $quantity > $product->quantity) {
            $availableToAdd = max(0, $product->quantity - $currentCartQty);
            $msg = $availableToAdd > 0
                ? "You already have {$currentCartQty} in your cart. Only {$availableToAdd} more can be added."
                : "You already have all available stock ({$product->quantity}) in your cart.";
            return response()->json(['success' => false, 'message' => $msg], 400);
        }

        $effectivePrice = max(0, (float) $product->final_price + $optionPriceDiff);
        $originalPrice = max(0, (float) $product->price + $optionPriceDiff);
        $specialPrice = $product->special_price !== null ? max(0, (float) $product->special_price + $optionPriceDiff) : null;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
            $cart[$cartKey]['price'] = $effectivePrice;
            $cart[$cartKey]['original_price'] = $originalPrice;
            $cart[$cartKey]['special_price'] = $specialPrice;
            $cart[$cartKey]['option_price_diff'] = $optionPriceDiff;
            $cart[$cartKey]['free_delivery'] = (bool) $product->freeDelivery;
        } else {
            $cart[$cartKey] = [
                "id"                => $product->id,
                "name"              => $product->name,
                "quantity"          => $quantity,
                "price"             => $effectivePrice,
                "original_price"    => $originalPrice,
                "special_price"     => $specialPrice,
                "option_price_diff" => $optionPriceDiff,
                "image"             => $product->main_image ? getImageUrl($product->main_image) : theme_asset('img/Air-Purify.png'),
                "model"             => $product->model,
                "options"           => $options,
                "free_delivery"     => (bool) $product->freeDelivery,
            ];
        }

        session()->put('cart', $cart);
        $totalItems = collect($cart)->sum('quantity');

        return response()->json([
            'success'    => true,
            'message'    => 'Product added to cart successfully!',
            'cart_count' => $totalItems,
            'cart'       => $cart
        ]);
    }

    /**
     * Update cart items quantity.
     */

    public function updateCart(Request $request)
    {
        $cartKey = (string) $request->input('product_id');
        if (!$cartKey) {
            return response()->json(['success' => false, 'message' => 'Invalid product identifier.'], 400);
        }

        $cart = session()->get('cart', []);
        if (!isset($cart[$cartKey])) {
            return response()->json(['success' => false, 'message' => 'Item not found in cart.'], 404);
        }

        $rawQty = $request->input('quantity');
        if (!is_numeric($rawQty)) {
            return response()->json(['success' => false, 'message' => 'Invalid quantity.'], 400);
        }

        $quantity = (int) $rawQty;

        // If quantity is 0 or negative, remove the item safely
        if ($quantity <= 0) {
            unset($cart[$cartKey]);
            if (empty($cart)) {
                session()->forget('applied_coupon');
            }
            session()->put('cart', $cart);

            $totalItems = collect($cart)->sum('quantity');
            $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
            $discount = $this->calculateDiscount($subtotal, 0.00);

            return response()->json([
                'success'       => true,
                'message'       => 'Item removed from cart.',
                'cart_count'    => $totalItems,
                'subtotal'      => number_format($subtotal, 2),
                'item_subtotal' => '0.00',
                'discount'      => number_format($discount, 2),
                'cart_empty'    => empty($cart),
            ]);
        }

        // Verify requested quantity against database stock
        $productId = $cart[$cartKey]['id'];
        $product = Product::find($productId);
        if ($product && $quantity > $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => "Only {$product->quantity} items available in stock.",
            ], 400);
        }

        $cart[$cartKey]["quantity"] = $quantity;
        session()->put('cart', $cart);

        $totalItems = collect($cart)->sum('quantity');
        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        $itemSubtotal = $cart[$cartKey]['price'] * $cart[$cartKey]['quantity'];
        $discount = $this->calculateDiscount($subtotal, 0.00);

        return response()->json([
            'success'       => true,
            'message'       => 'Cart updated successfully!',
            'cart_count'    => $totalItems,
            'subtotal'      => number_format($subtotal, 2),
            'item_subtotal' => number_format($itemSubtotal, 2),
            'discount'      => number_format($discount, 2),
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function removeFromCart(Request $request)
    {
        $identifier = (string) $request->input('product_id');
        if (!$identifier) {
            return response()->json(['success' => false, 'message' => 'Invalid product identifier.'], 400);
        }

        $cart = session()->get('cart', []);
        $removed = false;

        // Check direct cartKey match first
        if (isset($cart[$identifier])) {
            unset($cart[$identifier]);
            $removed = true;
        } else {
            // Fallback: match by product id (for quick remove toggles from catalog/home cards)
            foreach ($cart as $key => $item) {
                if ((string)($item['id'] ?? '') === $identifier) {
                    unset($cart[$key]);
                    $removed = true;
                }
            }
        }

        if ($removed) {
            session()->put('cart', $cart);
        }

        // Clear coupon if cart is now empty
        if (empty($cart)) {
            session()->forget('applied_coupon');
        }

        $totalItems = collect($cart)->sum('quantity');
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $discount = $this->calculateDiscount($subtotal, 0.00);

        return response()->json([
            'success'    => true,
            'message'    => 'Product removed from cart successfully!',
            'cart_count' => $totalItems,
            'subtotal'   => number_format($subtotal, 2),
            'discount'   => number_format($discount, 2),
            'cart_empty' => empty($cart),
        ]);
    }

    /**
     * Alias for removeFromCart method.
     */
    public function removeCart(Request $request)
    {
        return $this->removeFromCart($request);
    }

    /**
     * Save an item from the cart to Saved for Later.
     */
    public function saveForLater(Request $request)
    {
        $cartKey = (string) $request->input('product_id');
        if (!$cartKey) {
            return response()->json(['success' => false, 'message' => 'Invalid product identifier.'], 400);
        }

        $cart = session()->get('cart', []);
        $saved = session()->get('saved_for_later', []);

        if (!isset($cart[$cartKey])) {
            return response()->json(['success' => false, 'message' => 'Item not found in cart.'], 404);
        }

        $saved[$cartKey] = $cart[$cartKey];
        unset($cart[$cartKey]);

        session()->put('cart', $cart);
        session()->put('saved_for_later', $saved);

        // Forget coupon if cart is now empty
        if (empty($cart)) {
            session()->forget('applied_coupon');
        }

        $totalItems = collect($cart)->sum('quantity');
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $discount = $this->calculateDiscount($subtotal, 0.00);

        return response()->json([
            'success'     => true,
            'message'     => 'Product saved for later successfully!',
            'cart_count'  => $totalItems,
            'subtotal'    => number_format($subtotal, 2),
            'discount'    => number_format($discount, 2),
            'saved_count' => count($saved),
        ]);
    }

    /**
     * Move an item from Saved for Later back to Cart.
     */
    public function moveToCart(Request $request)
    {
        $cartKey = (string) $request->input('product_id');
        if (!$cartKey) {
            return response()->json(['success' => false, 'message' => 'Invalid product identifier.'], 400);
        }

        $cart = session()->get('cart', []);
        $saved = session()->get('saved_for_later', []);

        if (!isset($saved[$cartKey])) {
            return response()->json(['success' => false, 'message' => 'Item not found in saved list.'], 404);
        }

        $savedItem = $saved[$cartKey];
        $product = Product::with(['special', 'freeDelivery'])->find($savedItem['id']);

        if (!$product || $product->status != 1) {
            return response()->json(['success' => false, 'message' => 'This product is no longer available.'], 400);
        }

        // Refresh price with current active pricing
        $optDiff = (float) ($savedItem['option_price_diff'] ?? 0);
        $effectivePrice = max(0, (float) $product->final_price + $optDiff);
        $savedItem['price'] = $effectivePrice;
        $savedItem['original_price'] = max(0, (float) $product->price + $optDiff);
        $savedItem['special_price'] = $product->special_price !== null ? max(0, (float) $product->special_price + $optDiff) : null;
        $savedItem['free_delivery'] = (bool) $product->freeDelivery;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += (int) $savedItem['quantity'];
            $cart[$cartKey]['price'] = $effectivePrice;
        } else {
            $cart[$cartKey] = $savedItem;
        }

        unset($saved[$cartKey]);

        session()->put('cart', $cart);
        session()->put('saved_for_later', $saved);

        $totalItems = collect($cart)->sum('quantity');
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $discount = $this->calculateDiscount($subtotal, 0.00);

        return response()->json([
            'success'    => true,
            'message'    => 'Product moved to cart successfully!',
            'cart_count' => $totalItems,
            'subtotal'   => number_format($subtotal, 2),
            'discount'   => number_format($discount, 2),
        ]);
    }

    /**
     * Remove an item from Saved for Later list.
     */
    public function removeSaved(Request $request)
    {
        $cartKey = (string) $request->input('product_id');
        if (!$cartKey) {
            return response()->json(['success' => false, 'message' => 'Invalid product identifier.'], 400);
        }

        $saved = session()->get('saved_for_later', []);
        if (isset($saved[$cartKey])) {
            unset($saved[$cartKey]);
            session()->put('saved_for_later', $saved);
        }

        return response()->json([
            'success' => true,
            'message' => 'Saved product removed successfully!'
        ]);
    }

    /**
     * Get total items in cart.
     */

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $totalItems = collect($cart)->sum('quantity');
        return response()->json(['cart_count' => $totalItems]);
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
}
