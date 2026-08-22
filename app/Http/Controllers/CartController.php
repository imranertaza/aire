<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }

        $cart = session()->get('cart', []);
        $quantity = (int)$request->input('quantity', 1);

        // Collect selected options from request (array: [value_id => {option_id, name, value}])
        $options = [];
        if ($request->has('options') && is_array($request->input('options'))) {
            foreach ($request->input('options') as $valueId => $optData) {
                if (is_array($optData)) {
                    $options[(int) $valueId] = [
                        'option_id' => (int) ($optData['option_id'] ?? 0),
                        'value_id'  => (int) $valueId,
                        'name'      => trim($optData['name'] ?? ''),
                        'value'     => trim($optData['value'] ?? ''),
                    ];
                }
            }
        }

        // Build a unique cart key based on product + selected option combination
        $cartKey = $product->id;
        if (!empty($options)) {
            $optionKey = implode('_', array_keys($options));
            $cartKey   = $product->id . '_' . $optionKey;
        }

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                "id"       => $product->id,
                "name"     => $product->name,
                "quantity" => $quantity,
                "price"    => $product->price,
                "image"    => $product->main_image ? getImageUrl($product->main_image) : theme_asset('img/Air-Purify.png'),
                "model"    => $product->model,
                "options"  => $options,
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
