<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storefront\SubscribeNewsletterRequest;
use App\Mail\ContactInquiryMail;
use App\Models\Menu;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Page;
use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\Setting;
use App\Services\Product\ProductService;
use App\Services\Storefront\StorefrontService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $aboutSections = $this->storefrontService->getAboutSections();
        $latestNews = Cache::remember('storefront_about_news_v1', 3600, function () {
            return News::query()
                ->published()
                ->with(['categories'])
                ->latest('publish_date')
                ->take(6)
                ->get();
        });

        return \theme_view('about', compact('aboutAds', 'aboutSections', 'latestNews'));
    }

    /**
     * Display dedicated news & media index/listing page.
     */
    public function newsIndex(Request $request): View
    {
        $selectedCategory = $request->query('category');
        $searchQuery = $request->query('q');

        $query = News::query()
            ->published()
            ->with(['categories', 'creator'])
            ->latest('publish_date');

        if (!empty($selectedCategory)) {
            $query->whereHas('categories', function ($q) use ($selectedCategory) {
                $q->where('category_name', $selectedCategory)
                    ->orWhere('id', is_numeric($selectedCategory) ? (int) $selectedCategory : 0);
            });
        }

        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('news_title', 'like', "%{$searchQuery}%")
                    ->orWhere('short_des', 'like', "%{$searchQuery}%")
                    ->orWhere('description', 'like', "%{$searchQuery}%");
            });
        }

        $newsList = $query->paginate(9)->withQueryString();

        $featuredNews = Cache::remember('storefront_news_featured_v1', 3600, function () {
            return News::query()
                ->published()
                ->where('featured', 1)
                ->with(['categories'])
                ->latest('publish_date')
                ->take(3)
                ->get();
        });

        if ($featuredNews->isEmpty()) {
            $featuredNews = News::query()
                ->published()
                ->with(['categories'])
                ->latest('publish_date')
                ->take(3)
                ->get();
        }

        $newsCategories = Cache::remember('storefront_news_categories_v1', 3600, function () {
            return NewsCategory::active()
                ->withCount(['news' => function ($q) {
                    $q->where('status', 1);
                }])
                ->get();
        });

        return \theme_view('news.index', compact('newsList', 'featuredNews', 'newsCategories', 'selectedCategory', 'searchQuery'));
    }

    /**
     * Display single news details page.
     */
    public function newsDetails(string $slug): View
    {
        $news = Cache::remember("storefront_news_detail_{$slug}", 3600, function () use ($slug) {
            return News::query()
                ->where('slug', $slug)
                ->orWhere('id', is_numeric($slug) ? (int) $slug : 0)
                ->published()
                ->with(['categories', 'creator'])
                ->first();
        });

        if (!$news) {
            abort(404);
        }

        $relatedNews = Cache::remember("storefront_news_related_{$news->id}", 3600, function () use ($news) {
            $categoryIds = $news->categories->pluck('id')->toArray();

            return News::query()
                ->where('id', '!=', $news->id)
                ->published()
                ->where(function ($q) use ($categoryIds) {
                    if (!empty($categoryIds)) {
                        $q->whereHas('categories', function ($cq) use ($categoryIds) {
                            $cq->whereIn('news_categories.id', $categoryIds);
                        });
                    }
                })
                ->latest('publish_date')
                ->take(3)
                ->get();
        });

        $newsCategories = Cache::remember('storefront_news_categories_v1', 3600, function () {
            return NewsCategory::active()
                ->withCount(['news' => function ($q) {
                    $q->where('status', 1);
                }])
                ->get();
        });

        return \theme_view('news.show', compact('news', 'relatedNews', 'newsCategories'));
    }

    /**
     * Display resources page.
     */
    public function resources(): View
    {
        $resourceCategories = Cache::remember(ResourceCategory::CACHE_KEY, 86400, function () {
            return ResourceCategory::query()
                ->active()
                ->with(['activeResources'])
                ->get();
        });

        return \theme_view('resources', compact('resourceCategories'));
    }

    /**
     * Display dedicated resource category page with pagination and search.
     */
    public function resourceCategory(Request $request, string $slug): View
    {
        $category = ResourceCategory::query()
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        $allCategories = Cache::remember(ResourceCategory::CACHE_KEY . '_list', 86400, function () {
            return ResourceCategory::query()
                ->active()
                ->withCount('activeResources')
                ->get();
        });

        $query = $category->activeResources();

        if ($search = trim((string) $request->query('search', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $resources = $query->paginate(12)->withQueryString();

        return \theme_view('resource_category', compact('category', 'allCategories', 'resources', 'search'));
    }

    /**
     * Download or redirect to the requested resource file.
     */
    public function downloadResource(int $id): BinaryFileResponse|StreamedResponse|RedirectResponse
    {
        $resource = Resource::query()->active()->findOrFail($id);

        // 1. External URL (e.g. external link, CDN, Google Drive)
        if (!empty($resource->external_url) && filter_var($resource->external_url, FILTER_VALIDATE_URL)) {
            return redirect()->away($resource->external_url);
        }

        // 2. Direct remote URL stored in file_path
        if (!empty($resource->file_path) && filter_var($resource->file_path, FILTER_VALIDATE_URL)) {
            return redirect()->away($resource->file_path);
        }

        // 3. Local file stored in public storage or public_html
        if (!empty($resource->file_path)) {
            $cleanPath = ltrim($resource->file_path, '/\\');
            $cleanPath = preg_replace('#^(public/)?storage/#i', '', $cleanPath);

            $extension = pathinfo($cleanPath, PATHINFO_EXTENSION) ?: ($resource->file_type ?: 'pdf');
            $downloadFilename = Str::slug($resource->title) . '.' . strtolower($extension);

            // Check Storage public disk (storage/app/public)
            if (Storage::disk('public')->exists($cleanPath)) {
                return Storage::disk('public')->download($cleanPath, $downloadFilename);
            }

            // Check absolute storage path
            $storageAbsolutePath = storage_path('app/public/' . $cleanPath);
            if (file_exists($storageAbsolutePath) && is_file($storageAbsolutePath)) {
                return response()->download($storageAbsolutePath, $downloadFilename);
            }

            // Check public_html path
            $publicPath = public_path($resource->file_path);
            if (file_exists($publicPath) && is_file($publicPath)) {
                return response()->download($publicPath, $downloadFilename);
            }
        }

        return redirect()->back()->with('error', 'The requested resource file is currently unavailable for download.');
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
     * Handle storefront contact form submission with validation, honeypot, and rate limiting.
     */
    public function submitContact(Request $request): RedirectResponse|JsonResponse
    {
        $successMessage = 'Thank you for reaching out! Your message has been sent successfully. Our team will get back to you shortly.';

        // 1. Honeypot Anti-Spam Check (Silently drop automated spam bots)
        if (!empty($request->input('b_extra_field'))) {
            return $request->wantsJson()
                ? response()->json(['success' => true, 'message' => $successMessage])
                : Redirect::back()->with('success', $successMessage);
        }

        // 2. Validate input fields
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // 3. IP-based Rate Limiting (5 submissions per minute)
        $throttleKey = 'contact_submit:' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $msg = "Too many contact submissions. Please try again in {$seconds} seconds.";
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 429);
            }
            return Redirect::back()->withInput()->withErrors(['message' => $msg]);
        }

        RateLimiter::hit($throttleKey, 60);

        // 4. Send Email Notification to Admin (using cached Setting fallback and Queueable Mailable)
        try {
            $adminEmail = Setting::get('email', config('mail.from.address') ?: 'info@aire.test');

            Mail::to($adminEmail)->send(new ContactInquiryMail($validated));
        } catch (\Throwable $e) {
            Log::warning('Failed to send contact email notification: ' . $e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage,
            ]);
        }

        return Redirect::back()->with('success', $successMessage);
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
    public function pageDetails(string $slug): View|RedirectResponse
    {
        $normalizedSlug = strtolower(trim($slug));

        // 301 Canonical Redirect to lowercase for SEO and avoiding duplicate case-sensitive caches
        if ($slug !== $normalizedSlug) {
            $currentUri = request()->getRequestUri();
            $targetUri = str_replace($slug, $normalizedSlug, $currentUri);
            return redirect($targetUri, 301);
        }

        $cacheKey = "cms_page_{$normalizedSlug}";
        $data = Cache::get($cacheKey);

        if (!$data) {
            $page = Page::query()
                ->where('slug', $normalizedSlug)
                ->active()
                ->first();

            if ($page) {
                $data = compact('page');
                Cache::put($cacheKey, $data, 86400);
            }
        }

        if (!$data) {
            // Built-in fallback views if no active CMS page is in the database
            if ($normalizedSlug === 'contact-us' || $normalizedSlug === 'contact') {
                return $this->contact();
            }

            if ($normalizedSlug === 'about-us' || $normalizedSlug === 'about') {
                return $this->about();
            }

            abort(404);
        }

        $rawTemp = strtolower(trim($data['page']->temp ?? ''));
        $normalizedTemp = str_replace(['_', ' '], '-', $rawTemp);

        // If the page has an associated menu, load it dynamically
        if (!empty($data['page']->menu_id)) {
            $associatedMenu = Cache::remember("page_associated_menu_{$data['page']->menu_id}", 86400, function () use ($data) {
                return Menu::query()
                    ->where('id', $data['page']->menu_id)
                    ->where('enabled', 1)
                    ->with([
                        'menus' => function ($q) {
                            $q->where('enabled', 1)
                                ->whereNull('parent_id')
                                ->with('page')
                                ->orderBy('order', 'asc')
                                ->orderBy('id', 'asc');
                        }
                    ])
                    ->first();
            });

            if ($associatedMenu) {
                $data['sidebarMenu'] = $associatedMenu;
                $data['legalPages'] = $associatedMenu;
            }
        }

        if ($normalizedTemp === 'legal') {
            if (!isset($data['legalPages'])) {
                $data['legalPages'] = Cache::remember('layout_legal_pages_menu_v1', 86400, function () {
                    return Menu::query()
                        ->where('name', 'LIKE', '%POLICIES & LEGAL%')
                        ->where('enabled', 1)
                        ->with([
                            'menus' => function ($q) {
                                $q->where('enabled', 1)
                                    ->whereNull('parent_id')
                                    ->with('page')
                                    ->orderBy('order', 'asc')
                                    ->orderBy('id', 'asc');
                            }
                        ])
                        ->first();
                });
            }

            return \theme_view('page', $data);
        }
        return \theme_view('page', $data);
    }
}
