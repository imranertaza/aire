<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StorefrontController extends Controller
{
    /**
     * Display storefront homepage.
     */

    public function index()
    {
        // return \theme_view('index');
        return redirect()->route('category.show', ['solutions']);
    }
    public function categories(Request $request)
    {
        $categories = \App\Models\ProductCategory::active()
            ->whereNull('parent_id')
            ->with([
                'icon',
                'children' => function ($q) {
                    $q->active();
                },
                'featuredTopProducts.images',
                'featuredBottomProducts.images'
            ])->get();

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
        $aboutAds = \App\Models\Slider::where('enabled', 1)
            ->where(function ($q) {
                $q->where('key', 'about_us')
                  ->orWhere('key', 'like', '%about_us%');
            })
            ->orderBy('order', 'asc')
            ->get();

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
}
