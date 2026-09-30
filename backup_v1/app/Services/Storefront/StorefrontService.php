<?php

namespace App\Services\Storefront;

use App\Models\Customer;
use App\Models\Newsletter;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class StorefrontService
{
    /**
     * Batch resolve and cache all homepage product sections.
     */
    public function getHomeProductSections(): array
    {
        return Cache::remember(Product::HOME_SECTIONS_CACHE_KEY, 3600, function () {
            $bestSellingSection = getSection('home_best_selling') ?? (getSection('best_selling') ?? []);
            $newArrivalSection  = getSection('home_new_arrival') ?? (getSection('new_arrival') ?? []);
            $customerFavSection = getSection('home_customer_favorites') ?? (getSection('customer_favorites') ?? (getSection('home_customer_fav') ?? []));
            $livingHeroSection  = getSection('home_living_hero') ?? (getSection('living_hero') ?? []);

            $bestSellingIds = is_array($bestSellingSection['product_ids'] ?? null) ? $bestSellingSection['product_ids'] : [];
            $newArrivalIds  = is_array($newArrivalSection['product_ids'] ?? null) ? $newArrivalSection['product_ids'] : [];
            $favIds         = is_array($customerFavSection['product_ids'] ?? null) ? $customerFavSection['product_ids'] : [];
            $livingId       = $livingHeroSection['product_id'] ?? null;

            // Collect all unique configured product IDs
            $allConfiguredIds = array_values(array_filter(array_unique(array_merge(
                $bestSellingIds,
                $newArrivalIds,
                $favIds,
                $livingId ? [$livingId] : []
            ))));

            // 1. Single batch query for all configured products using reusable scopes
            $loadedProducts = !empty($allConfiguredIds)
                ? Product::withCatalogRelations()
                    ->active()
                    ->whereIn('id', $allConfiguredIds)
                    ->get()
                    ->keyBy('id')
                : collect();

            // 2. Map Best Selling products (or fallback via scope)
            $bestSellingProducts = collect($bestSellingIds)->map(fn($id) => $loadedProducts->get($id))->filter()->values();
            if ($bestSellingProducts->isEmpty()) {
                $bestSellingProducts = Product::bestSellingFallback(4)->get();
            }

            // 3. Map New Arrival products (or fallback via scope)
            $newArrivalProducts = collect($newArrivalIds)->map(fn($id) => $loadedProducts->get($id))->filter()->values();
            if ($newArrivalProducts->isEmpty()) {
                $newArrivalProducts = Product::newArrivalsFallback(3)->get();
            }

            // 4. Map Customer Favorites products (or fallback via scope)
            $customerFavoritesProducts = collect($favIds)->map(fn($id) => $loadedProducts->get($id))->filter()->values();
            if ($customerFavoritesProducts->isEmpty()) {
                $customerFavoritesProducts = Product::customerFavoritesFallback(3, 3)->get();
            }

            // 5. Map Living Hero product (or fallback via scope)
            $livingProduct = $livingId ? $loadedProducts->get($livingId) : null;
            if (!$livingProduct) {
                $livingProduct = Product::bestSellingFallback(1)->first();
            }

            return [
                'bestSellingProducts'       => $bestSellingProducts,
                'newArrivalProducts'        => $newArrivalProducts,
                'customerFavoritesProducts' => $customerFavoritesProducts,
                'livingProduct'             => $livingProduct,
                'bottomFeaturedProduct'     => $livingProduct,
            ];
        });
    }

    /**
     * Get banner slides for homepage hero.
     */
    public function getHeroSlides()
    {
        return Slider::getByPlacement('banner_section');
    }

    /**
     * Get promotional sliders for About page.
     */
    public function getAboutAds(): Collection
    {
        return Cache::remember('storefront_about_ads_v1', 3600, function () {
            return Slider::getByPlacement('about_us');
        });
    }

    /**
     * Process newsletter subscription.
     */
    public function subscribe(string $email, ?int $customerId = null): array
    {
        $existing = Newsletter::where('email', $email)->first();

        if ($existing) {
            $updates = ['status' => 1, 'unsubscribed_at' => null];
            if (empty($existing->unsubscribe_token)) {
                $updates['unsubscribe_token'] = Str::random(64);
            }
            if ($customerId) {
                $updates['customer_id'] = $customerId;
            }

            $existing->update($updates);

            return [
                'success' => true,
                'message' => 'Thank you! Your newsletter subscription has been confirmed.',
            ];
        }

        Newsletter::create([
            'email'             => $email,
            'status'            => 1,
            'customer_id'       => $customerId,
            'unsubscribe_token' => Str::random(64),
            'unsubscribed_at'   => null,
        ]);

        return [
            'success' => true,
            'message' => 'Thank you for subscribing to our newsletter!',
        ];
    }

    /**
     * Process 1-Click Unsubscribe via secure token.
     */
    public function unsubscribeByToken(string $token): array
    {
        if (empty($token) || strlen($token) < 16) {
            return [
                'success' => false,
                'message' => 'Invalid or expired unsubscribe link.',
                'email'   => null,
            ];
        }

        // 1. Check in Newsletter table
        $subscriber = Newsletter::where('unsubscribe_token', $token)->first();
        if ($subscriber) {
            $subscriber->update([
                'status'          => 0,
                'unsubscribed_at' => now(),
            ]);

            return [
                'success' => true,
                'message' => 'You have been successfully unsubscribed from our newsletter.',
                'email'   => $subscriber->email,
                'token'   => $token,
            ];
        }

        // 2. Check in Customer table
        $customer = Customer::where('unsubscribe_token', $token)->first();
        if ($customer) {
            $customer->update([
                'newsletter'      => 0,
                'is_subscribed'   => 0,
                'unsubscribed_at' => now(),
            ]);

            return [
                'success' => true,
                'message' => 'You have been successfully unsubscribed from our promotional emails.',
                'email'   => $customer->email,
                'token'   => $token,
            ];
        }

        return [
            'success' => false,
            'message' => 'We could not find an active subscription associated with this link.',
            'email'   => null,
        ];
    }

    /**
     * Process 1-Click Re-subscribe (undo accidental unsubscribe).
     */
    public function resubscribeByToken(string $token): array
    {
        if (empty($token)) {
            return [
                'success' => false,
                'message' => 'Invalid or expired token.',
            ];
        }

        $subscriber = Newsletter::where('unsubscribe_token', $token)->first();
        if ($subscriber) {
            $subscriber->update([
                'status'          => 1,
                'unsubscribed_at' => null,
            ]);

            return [
                'success' => true,
                'message' => 'Your newsletter subscription has been successfully reactivated!',
                'email'   => $subscriber->email,
            ];
        }

        $customer = Customer::where('unsubscribe_token', $token)->first();
        if ($customer) {
            $customer->update([
                'newsletter'      => 1,
                'is_subscribed'   => 1,
                'unsubscribed_at' => null,
            ]);

            return [
                'success' => true,
                'message' => 'Your email subscription has been successfully reactivated!',
                'email'   => $customer->email,
            ];
        }

        return [
            'success' => false,
            'message' => 'Unable to find subscription to reactivate.',
        ];
    }
}
