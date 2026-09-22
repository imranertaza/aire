<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Coupon;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
        $topFeaturedProduct = Cache::remember('home_top_featured_product', 3600, function () {
            return Product::where('status', 1)->where('featured', 1)->with(['categories', 'images', 'special'])->latest()->first();
        });

        $bottomFeaturedProduct = Cache::remember('home_bottom_featured_product', 3600, function () {
            return Product::where('status', 1)->with(['categories', 'images', 'special'])->latest()->first();
        });

        $products = Product::with('special')->latest()->paginate(50)->withQueryString();
        $heroSlides = \App\Models\Slider::getByPlacement('banner_section');

        return \theme_view('home', compact('products', 'topFeaturedProduct', 'bottomFeaturedProduct', 'heroSlides'));
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
        $aboutAds = \App\Models\Slider::getByPlacement('about_us');

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
