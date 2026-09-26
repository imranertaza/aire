<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class StorefrontController extends Controller
{
    /**
     * Display storefront homepage.
     */
    public function index()
    {
        $heroSlides = \App\Models\Slider::getByPlacement('banner_section');

        // Batch resolve and cache all homepage product sections in a single consolidated operation
        $homeProductSections = Cache::remember(Product::HOME_SECTIONS_CACHE_KEY, 3600, function () {
            $bestSellingSection = getSection('home_best_selling') ?? (getSection('best_selling') ?? []);
            $newArrivalSection = getSection('home_new_arrival') ?? (getSection('new_arrival') ?? []);
            $customerFavoritesSection = getSection('home_customer_favorites') ?? (getSection('customer_favorites') ?? (getSection('home_customer_fav') ?? []));
            $livingHeroSection = getSection('home_living_hero') ?? (getSection('living_hero') ?? []);

            $bestSellingIds = is_array($bestSellingSection['product_ids'] ?? null) ? $bestSellingSection['product_ids'] : [];
            $newArrivalIds = is_array($newArrivalSection['product_ids'] ?? null) ? $newArrivalSection['product_ids'] : [];
            $favIds = is_array($customerFavoritesSection['product_ids'] ?? null) ? $customerFavoritesSection['product_ids'] : [];
            $livingId = $livingHeroSection['product_id'] ?? null;

            // Collect all unique product IDs configured across all 4 sections
            $allConfiguredIds = array_values(array_filter(array_unique(array_merge(
                $bestSellingIds,
                $newArrivalIds,
                $favIds,
                $livingId ? [$livingId] : []
            ))));

            $relations = [
                'categories',
                'images',
                'special',
                'freeDelivery',
                'description:id,product_id,description',
                'productLanding:id,product_id,status'
            ];

            // 1. Single batch query for all explicitly configured products across all sections
            $loadedProducts = !empty($allConfiguredIds)
                ? Product::with($relations)->whereIn('id', $allConfiguredIds)->where('status', 1)->get()->keyBy('id')
                : collect();

            // 2. Map Best Selling products (or fallback to latest)
            $bestSellingProducts = collect($bestSellingIds)->map(fn($id) => $loadedProducts->get($id))->filter()->values();
            if ($bestSellingProducts->isEmpty()) {
                $bestSellingProducts = Product::with($relations)->where('status', 1)->latest('id')->take(4)->get();
            }

            // 3. Map New Arrival products (or fallback to latest)
            $newArrivalProducts = collect($newArrivalIds)->map(fn($id) => $loadedProducts->get($id))->filter()->values();
            if ($newArrivalProducts->isEmpty()) {
                $newArrivalProducts = Product::with($relations)->where('status', 1)->latest('id')->take(3)->get();
            }

            // 4. Map Customer Favorites products (or fallback to offset latest)
            $customerFavoritesProducts = collect($favIds)->map(fn($id) => $loadedProducts->get($id))->filter()->values();
            if ($customerFavoritesProducts->isEmpty()) {
                $customerFavoritesProducts = Product::with($relations)->where('status', 1)->skip(3)->take(3)->get();
            }

            // 5. Map Living Hero product (or fallback to latest bottom featured)
            $livingProduct = $livingId ? $loadedProducts->get($livingId) : null;
            if (!$livingProduct) {
                $livingProduct = Product::where('status', 1)->with($relations)->latest('id')->first();
            }

            return [
                'bestSellingProducts'       => $bestSellingProducts,
                'newArrivalProducts'        => $newArrivalProducts,
                'customerFavoritesProducts' => $customerFavoritesProducts,
                'livingProduct'             => $livingProduct,
                'bottomFeaturedProduct'     => $livingProduct,
            ];
        });

        return \theme_view('home', array_merge([
            'heroSlides' => $heroSlides,
        ], $homeProductSections));
    }

    public function categories(Request $request)
    {
        $categories = Cache::remember('catalog_parent_categories_tree', 3600, function () {
            return \App\Models\ProductCategory::active()
                ->whereNull('parent_id')
                ->with([
                    'icon',
                    'children' => function ($q) {
                        $q->active();
                    },
                    'featuredTopProducts.images',
                    'featuredBottomProducts.images'
                ])->get();
        });

        return \theme_view('products.category.index', compact('categories'));
    }

    /**
     * Display solutions page.
     */
    public function solutions()
    {
        return \theme_view('solutions');
    }

    /**
     * Display about page.
     */
    public function about()
    {
        $aboutAds = Cache::remember('storefront_about_ads_v1', 3600, function () {
            return \App\Models\Slider::getByPlacement('about_us');
        });

        return \theme_view('about', compact('aboutAds'));
    }

    /**
     * Display docs page.
     */
    public function docs()
    {
        return \theme_view('docs');
    }

    /**
     * Display contact page.
     */
    public function contact()
    {
        return \theme_view('about');
    }

    /**
     * Handle storefront newsletter subscription with rate limiting & anti-spam security.
     */
    public function subscribeNewsletter(Request $request)
    {
        // 1. Rate Limiting: Max 5 attempts per minute per IP
        $throttleKey = 'newsletter:' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'success' => false,
                'message' => "Too many subscription attempts. Please try again in {$seconds} seconds.",
            ], 429);
        }

        // 2. Honeypot check for bots
        if (!empty($request->input('b_extra_field'))) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing to our newsletter!',
            ]);
        }

        // 3. Strict Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email:filter|max:150',
        ], [
            'email.required' => 'Please provide your email address.',
            'email.email'    => 'Please enter a valid email address.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first('email'),
            ], 422);
        }

        RateLimiter::hit($throttleKey, 60);

        // 4. Sanitize
        $email = Str::lower(strip_tags(trim($request->email)));

        // 5. Existing subscription check
        $existing = Newsletter::where('email', $email)->first();
        if ($existing) {
            if ($existing->status == 0) {
                $existing->update(['status' => 1]);
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you! Your newsletter subscription has been reactivated.',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'You are already subscribed to our newsletter.',
            ]);
        }

        // 6. Secure Database Insertion
        $customerId = auth('customer')->id() ?? null;

        Newsletter::create([
            'email'       => $email,
            'status'      => 1,
            'customer_id' => $customerId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for subscribing to our newsletter!',
        ]);
    }
}
