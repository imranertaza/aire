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

        // Refresh cart items with current active pricing/specials + preserved option price adjustments
        $updated = false;
        foreach ($cart as $key => &$item) {
            $product = Product::with(['special', 'freeDelivery'])->find($item['id']);
            if ($product) {
                $optDiff = (float) ($item['option_price_diff'] ?? 0);
                $effectivePrice = max(0, (float) $product->final_price + $optDiff);
                $originalPrice = max(0, (float) $product->price + $optDiff);
                $specialPrice = $product->special_price !== null ? max(0, (float) $product->special_price + $optDiff) : null;
                $isFree = (bool) $product->freeDelivery;

                if (!isset($item['price']) || (float)$item['price'] != $effectivePrice || !isset($item['free_delivery']) || $item['free_delivery'] !== $isFree) {
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
        $product = Product::with(['special', 'productOptions.option', 'productOptions.optionValue', 'freeDelivery'])->find($request->product_id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
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
                        $prefix = $po->price_prefix ?: ($po->subtract == 1 ? '-' : '+');
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

        // Build a unique cart key based on product + selected option combination
        $cartKey = $product->id;
        if (!empty($options)) {
            $optionKey = implode('_', array_keys($options));
            $cartKey   = $product->id . '_' . $optionKey;
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
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => $totalItems,
            'cart' => $cart
        ]);
    }

    /**
     * Update cart items quantity.
     */

    public function updateCart(Request $request)
    {
        if ($request->product_id && $request->quantity) {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]["quantity"] = (int)$request->quantity;
                session()->put('cart', $cart);
            }
            $totalItems = collect($cart)->sum('quantity');
            $subtotal = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!',
                'cart_count' => $totalItems,
                'subtotal' => number_format($subtotal, 2),
                'item_subtotal' => number_format($cart[$request->product_id]['price'] * $cart[$request->product_id]['quantity'], 2)
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid data.'], 400);
    }

    /**
     * Remove item from cart.
     */

    public function removeFromCart(Request $request)
    {
        if ($request->product_id) {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->product_id])) {
                unset($cart[$request->product_id]);
                session()->put('cart', $cart);
            }
            // Clear coupon if cart is now empty
            if (empty($cart)) {
                session()->forget('applied_coupon');
            }
            $totalItems = collect($cart)->sum('quantity');
            $subtotal = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });
            return response()->json([
                'success'    => true,
                'message'    => 'Product removed from cart successfully!',
                'cart_count' => $totalItems,
                'subtotal'   => number_format($subtotal, 2),
                'cart_empty' => empty($cart),
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid data.'], 400);
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
        if ($request->product_id) {
            $cart = session()->get('cart', []);
            $saved = session()->get('saved_for_later', []);

            if (isset($cart[$request->product_id])) {
                $saved[$request->product_id] = $cart[$request->product_id];
                unset($cart[$request->product_id]);

                session()->put('cart', $cart);
                session()->put('saved_for_later', $saved);
            }

            $totalItems = collect($cart)->sum('quantity');
            $subtotal = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            return response()->json([
                'success' => true,
                'message' => 'Product saved for later successfully!',
                'cart_count' => $totalItems,
                'subtotal' => number_format($subtotal, 2)
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid data.'], 400);
    }

    /**
     * Move an item from Saved for Later back to Cart.
     */

    public function moveToCart(Request $request)
    {
        if ($request->product_id) {
            $cart = session()->get('cart', []);
            $saved = session()->get('saved_for_later', []);

            if (isset($saved[$request->product_id])) {
                $cart[$request->product_id] = $saved[$request->product_id];
                unset($saved[$request->product_id]);

                session()->put('cart', $cart);
                session()->put('saved_for_later', $saved);
            }

            $totalItems = collect($cart)->sum('quantity');
            $subtotal = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            return response()->json([
                'success' => true,
                'message' => 'Product moved to cart successfully!',
                'cart_count' => $totalItems,
                'subtotal' => number_format($subtotal, 2)
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid data.'], 400);
    }

    /**
     * Remove an item from Saved for Later list.
     */

    public function removeSaved(Request $request)
    {
        if ($request->product_id) {
            $saved = session()->get('saved_for_later', []);
            if (isset($saved[$request->product_id])) {
                unset($saved[$request->product_id]);
                session()->put('saved_for_later', $saved);
            }
            return response()->json([
                'success' => true,
                'message' => 'Saved product removed successfully!'
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid data.'], 400);
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
