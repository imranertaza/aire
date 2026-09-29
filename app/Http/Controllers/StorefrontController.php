<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storefront\SubscribeNewsletterRequest;
use App\Models\Page;
use App\Services\Product\ProductService;
use App\Services\Storefront\StorefrontService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function __construct(
        protected StorefrontService $storefrontService,
        protected ProductService $productService
    ) {}

    /**
     * Display storefront homepage.
     */
    public function index(): View
    {
        $heroSlides = $this->storefrontService->getHeroSlides();
        $homeProductSections = $this->storefrontService->getHomeProductSections();

        return \theme_view('home', array_merge([
            'heroSlides' => $heroSlides,
        ], $homeProductSections));
    }

    /**
     * Display parent categories catalog.
     */
    public function categories(): View
    {
        $categories = $this->productService->getCategoryTree();

        return \theme_view('products.category.index', compact('categories'));
    }


    /**
     * Display about page.
     */
    public function about(): View
    {
        $aboutAds = $this->storefrontService->getAboutAds();

        return \theme_view('about', compact('aboutAds'));
    }

    /**
     * Display docs page.
     */
    public function docs(): View
    {
        return \theme_view('docs');
    }

    /** 
     * Display solutions page.
     */
    public function solutions(): View
    {
        if (ViewFacade::exists('themes.' . active_theme() . '.solutions')) {
            return \theme_view('solutions');
        }

        return \theme_view('solutions__');
    }

    /**
     * Display contact page.
     */
    public function contact(): View
    {
        $page = (object) [
            'page_title'       => 'Contact Us',
            'breadcrumb'       => 'Contact Us',
            'meta_description' => 'Contact Aire Indoor Air Quality Solutions',
            'meta_keywords'    => 'contact, air quality, aire',
            'meta_title'       => 'Contact Us | Aire',
        ];

        return \theme_view('contact', compact('page'));
    }

    /**
     * Handle storefront newsletter subscription with rate limiting & anti-spam security.
     */
    public function subscribeNewsletter(SubscribeNewsletterRequest $request): JsonResponse
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

        // 2. Honeypot check for spam bots
        if ($request->filled('b_extra_field')) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing to our newsletter!',
            ]);
        }

        RateLimiter::hit($throttleKey, 60);

        $email = (string) $request->validated('email');
        $customerId = Auth::guard('customer')->id();

        $result = $this->storefrontService->subscribe($email, $customerId);

        return response()->json($result);
    }

    /**
     * Handle 1-Click Unsubscribe (supports both browser GET and RFC 8058 HTTP POST).
     */
    public function unsubscribe(\Illuminate\Http\Request $request, string $token): \Illuminate\Http\Response|\Illuminate\View\View|\Illuminate\Http\JsonResponse
    {
        $result = $this->storefrontService->unsubscribeByToken($token);

        // If automated RFC 8058 POST request from email clients (Gmail, Apple Mail, Yahoo)
        if ($request->isMethod('POST') || $request->wantsJson()) {
            return response()->json([
                'success' => $result['success'],
                'message' => $result['message'],
            ], $result['success'] ? 200 : 404);
        }

        $page = (object) [
            'page_title'       => 'Unsubscribe | ' . config('app.name', 'Aire'),
            'breadcrumb'       => 'Unsubscribe',
            'meta_description' => 'Unsubscribe from newsletter',
            'meta_keywords'    => 'unsubscribe, newsletter',
            'meta_title'       => 'Unsubscribe | ' . config('app.name', 'Aire'),
        ];

        return \theme_view('newsletter.unsubscribe', compact('result', 'page', 'token'));
    }

    /**
     * Handle 1-Click Re-subscribe (undo accidental unsubscribe).
     */
    public function resubscribe(Request $request, string $token): RedirectResponse|JsonResponse
    {
        $result = $this->storefrontService->resubscribeByToken($token);

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return Redirect::back()->with('success_message', $result['message']);
        }

        return Redirect::back()->with('error_message', $result['message']);
    }

    /**
     * Display a dynamic CMS page.
     */
    public function pageDetails(string $slug): View
    {
        if ($slug === 'contact-us' || $slug === 'contact') {
            return $this->contact();
        }

        if ($slug === 'about-us' || $slug === 'about') {
            return $this->about();
        }

        $page = Page::query()
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Related or other active pages for quick navigation
        $otherPages = Page::query()
            ->where('id', '!=', $page->id)
            ->active()
            ->orderBy('id', 'asc')
            ->limit(6)
            ->get(['id', 'page_title', 'slug', 'breadcrumb']);

        return \theme_view('page', compact('page', 'otherPages'));
    }
}
