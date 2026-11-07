<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\DropdownSearchRequest;
use App\Http\Requests\Product\ProductActionRequest;
use App\Http\Requests\Product\WizardFilterRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\Product\ProductFilterService;
use App\Services\Product\ProductCompareService;
use App\Services\Product\ProductSearchService;
use App\Services\Product\ProductService;
use App\Services\Product\WishlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductFilterService $filterService,
        protected ProductService $productService,
        protected ProductSearchService $searchService,
        protected WishlistService $wishlistService,
        protected ProductCompareService $compareService
    ) {}

    /**
     * Display product catalog listing by category (Dedicated View All).
     */
    public function categoriesDetails(Request $request, ?string $slug_or_id = null): mixed
    {
        $catParam = $slug_or_id ?: $request->input('category_id');
        $search = trim((string) $request->input('search', ''));

        $currentCategory = $this->filterService->resolveCategory($catParam);

        if (!$currentCategory) {
            abort(404);
        }

        $allCategories = $this->productService->getCategoryTree();
        $adSliders = $this->filterService->getSidebarAdSliders();

        $catIds = $this->filterService->getCategoryWithDescendantIds([$currentCategory->id]);

        $products = Product::active()
            ->withCatalogRelations()
            ->inCategories($catIds)
            ->search($search)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest' || $request->input('ajax') == '1') {
            return response()->json([
                'status' => true,
                'total'  => $products->total(),
                'html'   => \theme_view('products.partials.product_grid', compact('products', 'search', 'currentCategory', 'adSliders'))->render(),
            ]);
        }

        return \theme_view('products.category.view_all', compact(
            'products',
            'currentCategory',
            'allCategories',
            'adSliders',
            'search'
        ));
    }

    /**
     * Display product catalog listing.
     */
    public function categories(Request $request, ?string $slug = null): View
    {
        $allCategories = $this->productService->getCategoryTree();
        $adSliders = $this->filterService->getSidebarAdSliders();

        if ($slug) {
            $categories = $this->productService->getCategoryBySlug($slug);

            if (!$categories) {
                abort(404);
            }
            return \theme_view('products.category.index', compact('categories', 'allCategories', 'adSliders'));
        }

        $categories = $allCategories;
        return \theme_view('products.category.index', compact('categories', 'allCategories', 'adSliders'));
    }

    /**
     * Display product detail page.
     */
    public function productDetail(string $slug): mixed
    {
        $data = $this->productService->getProductDetail($slug);

        if (!$data || !$data['product']) {
            abort(404);
        }

        $product = $data['product'];
        $relatedProducts = $data['relatedProducts'];

        // Canonical 301 redirect if accessed via ID or mismatched slug
        if (!empty($product->slug) && (string) $slug !== (string) $product->slug) {
            return redirect()->route('products.detail', $product->slug, 301);
        }

        return \theme_view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Display product landing page.
     */
    public function productLanding(?string $slug = null, ?Request $request = null): View
    {
        if (!$slug) {
            abort(404);
        }

        $data = $this->productService->getProductLanding($slug);

        if (!$data) {
            abort(404);
        }

        $product = $data['product'];
        $previousUrl = url()->previous();
        $prevPath = parse_url($previousUrl, PHP_URL_PATH) ?? '';

        $catSlug = null;
        if (preg_match('~/category(?:/details)?/([^/]+)~i', $prevPath, $matches)) {
            $catSlug = trim($matches[1]);
        } elseif (request()->query('cat') || request()->query('category')) {
            $catSlug = trim((string) (request()->query('cat') ?: request()->query('category')));
        }

        $breadcrumbName = null;
        $breadcrumbUrl = null;
        $matched = null;
        $fallbackCat = null;

        if ($catSlug) {
            $matched = $product->categories?->first(function ($c) use ($catSlug) {
                return (string) ($c->slug ?? '') === (string) $catSlug || (string) ($c->id ?? '') === (string) $catSlug;
            });

            if (!$matched) {
                $matched = ProductCategory::where('slug', $catSlug)
                    ->orWhere('id', is_numeric($catSlug) ? (int) $catSlug : 0)
                    ->first();
            }

            if ($matched) {
                $breadcrumbName = $matched->category_name;
                $breadcrumbUrl = route('category.show', $matched->slug ?? $matched->id);
            } else {
                $breadcrumbName = ucwords(str_replace(['-', '_'], ' ', $catSlug));
                $breadcrumbUrl = $previousUrl ?: url('/category/' . $catSlug);
            }

            // Remember in session so reloading (F5) preserves this category for the current product
            session([
                'landing_ref_product_id' => $product->id,
                'landing_ref_cat_name'   => $breadcrumbName,
                'landing_ref_cat_url'    => $breadcrumbUrl,
            ]);
        } elseif ($previousUrl && str_contains($previousUrl, '/products')) {
            $breadcrumbName = 'Products';
            $breadcrumbUrl = route('products.filter');
            session([
                'landing_ref_product_id' => $product->id,
                'landing_ref_cat_name'   => $breadcrumbName,
                'landing_ref_cat_url'    => $breadcrumbUrl,
            ]);
        } elseif (session('landing_ref_product_id') === $product->id && session()->has('landing_ref_cat_name')) {
            // Preserved across page reloads (F5)
            $breadcrumbName = session('landing_ref_cat_name');
            $breadcrumbUrl  = session('landing_ref_cat_url');
        } else {
            // Direct / SEO Fallback
            $fallbackCat = $product->categories?->first();
            if ($fallbackCat) {
                $breadcrumbName = $fallbackCat->category_name;
                $breadcrumbUrl = route('category.show', $fallbackCat->slug ?? $fallbackCat->id);
            } else {
                $breadcrumbName = 'Products';
                $breadcrumbUrl = route('products.index');
            }
        }

        $data['breadcrumb'] = [
            'name' => $breadcrumbName,
            'url'  => $breadcrumbUrl,
        ];
        $data['category'] = $matched ?? ($fallbackCat ?? $product->categories?->first());

        return \theme_view('products.landing', $data);
    }

    /**
     * Retrieve list of products and categories for live dropdown search with caching.
     */
    public function dropdownList(DropdownSearchRequest $request): JsonResponse
    {
        $payload = $this->searchService->searchDropdown(
            (string) $request->input('search', ''),
            $request->input('category_id') ? (int) $request->input('category_id') : null,
            (int) $request->input('limit', 8)
        );

        return response()->json($payload);
    }

    /**
     * Display product filter page.
     */
    public function productFilter(Request $request, ?string $slug_or_id = null): mixed
    {
        $search = trim((string) $request->input('search', ''));

        // 1. Categories Filter Parameter
        $categoryFilter = $request->input('category') ?: ($slug_or_id ?: $request->input('category_id'));
        $cleanCategories = array_filter((array) $categoryFilter, fn($v) => $v !== 'any' && $v !== 'all' && !empty($v));

        $firstCat = !empty($cleanCategories) ? reset($cleanCategories) : null;
        $currentCategory = $this->filterService->resolveCategory($firstCat);

        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest' || $request->input('ajax') == '1';
        $featured = $this->filterService->resolveCategoryFeatured($currentCategory, $isAjax);
        $topFeaturedProduct = $featured['top'];
        $middleFeaturedProduct = $featured['middle'];
        $bottomFeaturedProduct = $featured['bottom'];

        $filterParams = array_merge($request->query(), [
            'search'          => $search,
            'category'        => $cleanCategories,
            'currentCategory' => $currentCategory,
            'application'     => $request->input('application') ?: $request->input('application_environment'),
            'building_type'   => $request->input('building_type') ?: $request->input('building'),
            'room_type'       => $request->input('room_type') ?: $request->input('room'),
            'area_range'      => $request->input('area_range') ?: $request->input('coverage'),
            'airflow'         => $request->input('airflow') ?: $request->input('airflow_requirement'),
            'occupancy'       => $request->input('occupancy'),
            'health_concern'  => $request->input('health_concern') ?: $request->input('health', []),
            'problem'         => $request->input('problem', []),
            'solution_needed' => $request->input('solution_needed') ?: $request->input('solution', []),
            'installation'    => $request->input('installation') ?: $request->input('installation_requirements'),
            'budget'          => $request->input('budget'),
        ]);

        $query = Product::with([
            'categories',
            'description:product_id,description,meta_title,tag',
            'images',
            'brand:id,name',
            'special',
            'freeDelivery',
            'productLanding:id,product_id,status',
        ])->where('status', 1);

        $query = $this->filterService->applyFilters($query, $filterParams);
        $products = $query->latest()->paginate(50)->withQueryString();

        $cleanParams = array_filter($request->query(), function ($val) {
            if (is_array($val)) {
                $val = array_filter($val, fn($v) => !empty($v) && $v !== 'any' && $v !== 'all');
                return !empty($val);
            }
            return !empty($val) && $val !== 'any' && $val !== 'all';
        });

        $cleanUrl = url()->current() . (!empty($cleanParams) ? ('?' . http_build_query($cleanParams)) : '');
        $isFiltered = !empty($cleanParams);

        $sidebarData = $this->filterService->buildCatalogFilterSections($request, $cleanCategories, $currentCategory);
        $adSliders = $this->filterService->getSidebarAdSliders();

        extract($sidebarData);

        if ($isAjax) {
            return response()->json([
                'status'       => true,
                'total'        => $products->total(),
                'html'         => \theme_view('products.partials.product_grid', compact('products', 'topFeaturedProduct', 'search', 'currentCategory', 'isFiltered', 'adSliders'))->render(),
                'sidebar_html' => \theme_view('products.partials.filter_sidebar', compact(
                    'filterOptionTypes',
                    'filterCategories',
                    'dynamicFilterSections',
                    'filterBuildingTypes',
                    'filterRoomTypes',
                    'filterAreaRanges',
                    'filterOccupancies',
                    'filterHealthConcerns',
                    'filterProblems',
                    'filterSolutions',
                    'filterBudgets',
                    'currentCategory'
                ))->render(),
                'url'          => $cleanUrl,
            ]);
        }

        return \theme_view('products.filter', compact(
            'isFiltered',
            'dbOptions',
            'filterOptionTypes',
            'filterCategories',
            'dynamicFilterSections',
            'filterBuildingTypes',
            'filterRoomTypes',
            'filterAreaRanges',
            'filterOccupancies',
            'filterHealthConcerns',
            'filterProblems',
            'filterSolutions',
            'filterBudgets',
            'products',
            'currentCategory',
            'topFeaturedProduct',
            'middleFeaturedProduct',
            'bottomFeaturedProduct',
            'search',
            'adSliders'
        ));
    }

    /**
     * Display multi-step product filter wizard page.
     */
    public function filter(Request $request): View
    {
        $stepsData = $this->filterService->getFilterStepsData();

        $totalProductsCount = Cache::remember('total_active_products_count', 300, function () {
            return Product::where('status', 1)->count();
        });

        $featured = $this->filterService->resolveCategoryFeatured();
        $featuredSolution = $featured['top'];
        $adSliders = $this->filterService->getSidebarAdSliders();

        return \theme_view('products.filter-step', compact('stepsData', 'totalProductsCount', 'featuredSolution', 'adSliders'));
    }

    /**
     * API endpoint for dynamic wizard filtering and progressive cascading options.
     */
    public function filterStepApi(WizardFilterRequest $request): JsonResponse
    {
        $params = [
            'category'        => $request->input('category'),
            'building_type'   => $request->input('building_type'),
            'room_type'       => $request->input('room_type'),
            'area_range'      => $request->input('area_range'),
            'occupancy'       => $request->input('occupancy'),
            'health_concern'  => (array) $request->input('health_concern', []),
            'problem'         => (array) $request->input('problem', []),
            'solution_needed' => (array) $request->input('solution_needed', []),
            'budget'          => $request->input('budget'),
        ];

        $query = Product::where('status', 1)
            ->with(['categories', 'images', 'brand', 'productAttributes', 'description', 'productFilterOptions.filterOption', 'productFilterOptions.filterOptionValue']);

        $query = $this->filterService->applyWizardFilters($query, $params);

        try {
            $matchedProducts = $query->orderBy('sort_order', 'asc')->get();
        } catch (\Throwable $e) {
            $matchedProducts = collect();
        }

        $totalCount = $matchedProducts->count();
        $bestProduct = $matchedProducts->first();
        $otherMatchedProducts = $matchedProducts->slice(1);

        if ($bestProduct) {
            $bestProduct->loadMissing(['categories', 'images', 'brand', 'productAttributes', 'description', 'productFilterOptions.filterOption', 'productFilterOptions.filterOptionValue']);
        }

        $bestProductData = $bestProduct ? $this->filterService->formatWizardProduct($bestProduct) : null;
        $otherProductsData = $otherMatchedProducts->map(fn($item) => $this->filterService->formatWizardProduct($item))->values()->all();

        $matchingProductIds = $matchedProducts->pluck('id')->toArray();
        $availableOptions = $this->filterService->computeWizardAvailableOptions($matchingProductIds);

        $allProducts = [];
        if ($bestProductData) {
            $allProducts[] = $bestProductData;
        }
        foreach ($otherProductsData as $op) {
            $allProducts[] = $op;
        }

        return response()->json([
            'status'            => true,
            'count'             => $totalCount,
            'total'             => $totalCount,
            'available_options' => $availableOptions,
            'best_product'      => $bestProductData,
            'other_products'    => $otherProductsData,
            'related_products'  => $otherProductsData,
            'products'          => $allProducts,
        ]);
    }

    /**
     * Display user wishlist / favorites.
     */
    public function favorite(): View
    {
        $products = $this->wishlistService->getWishlistProducts();
        $adSliders = $this->productService->getSliders('favorite');

        return \theme_view('favorite', compact('products', 'adSliders'));
    }

    /**
     * Toggle item favorite/wishlist status.
     */
    public function toggleFavorite(ProductActionRequest $request): JsonResponse
    {
        $result = $this->wishlistService->toggle((int) $request->validated('product_id'));

        return response()->json($result);
    }

    /**
     * Toggle a product in/out of the customer's wishlist (DB column or session).
     */
    public function toggleWishlist(ProductActionRequest $request): JsonResponse
    {
        $result = $this->wishlistService->toggle((int) $request->validated('product_id'));

        return response()->json($result);
    }

    /**
     * Display product comparison page.
     */
    public function compare(): View
    {
        $comparedProducts = $this->compareService->getComparedProducts();
        $adSliders = $this->productService->getSliders('compare');

        return \theme_view('compare', compact('comparedProducts', 'adSliders'));
    }

    /**
     * Add product to compare session.
     */
    public function addToCompare(ProductActionRequest $request): JsonResponse
    {
        $result = $this->compareService->add((int) $request->validated('product_id'));

        return response()->json($result, $result['success'] ? 200 : ($result['limit_reached'] ?? false ? 200 : 400));
    }

    /**
     * Remove product from compare session.
     */
    public function removeFromCompare(ProductActionRequest $request): JsonResponse
    {
        $result = $this->compareService->remove((int) $request->validated('product_id'));

        return response()->json($result);
    }

    /**
     * Clear all compared products.
     */
    public function clearCompare(): JsonResponse
    {
        $result = $this->compareService->clear();

        return response()->json($result);
    }
}
