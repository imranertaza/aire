<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class WishlistService
{
    /**
     * Retrieve all wishlist / favorite product IDs for the current user (authenticated or guest).
     */
    public function getWishlistIds(): array
    {
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            $list = json_decode($customer->wishlist ?? '[]', true);
            $ids = is_array($list) ? array_map('intval', $list) : [];

            // Keep session in sync with authenticated customer's DB wishlist
            session()->put('favorites', $ids);

            return $ids;
        }

        $favorites = session()->get('favorites', []);
        return is_array($favorites) ? array_map('intval', $favorites) : [];
    }

    /**
     * Retrieve active Product models in user's wishlist/favorites.
     */
    public function getWishlistProducts(): Collection
    {
        $ids = $this->getWishlistIds();

        if (empty($ids)) {
            return new Collection();
        }

        return Product::whereIn('id', $ids)
            ->where('status', 1)
            ->with([
                'categories',
                'images',
                'special',
                'freeDelivery',
                'productLanding:id,product_id,status',
                'description:id,product_id,description',
            ])
            ->get();
    }

    /**
     * Toggle product in/out of wishlist or favorites.
     */
    public function toggle(int $productId): array
    {
        $list = $this->getWishlistIds();
        $isAdded = false;

        if (in_array($productId, $list, true)) {
            $list = array_values(array_diff($list, [$productId]));
            $message = 'Product removed from favorites.';
        } else {
            $list[] = $productId;
            $isAdded = true;
            $message = 'Product added to favorites.';
        }

        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            $customer->wishlist = json_encode($list);
            $customer->save();
        }

        // Always sync session
        session()->put('favorites', $list);

        $count = count($list);

        return [
            'success'         => true,
            'is_favorite'     => $isAdded,
            'added'           => $isAdded,
            'message'         => $message,
            'count'           => $count,
            'favorites_count' => $count,
            'favorite_count'  => $count,
            'wish_count'      => $count,
        ];
    }
}
