<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\DropdownSearchRequest;
use App\Http\Requests\Product\ProductActionRequest;
use App\Http\Requests\Product\WizardFilterRequest;
use App\Models\Product;
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
     * Display product catalog listing by category.
     */
    public function categoriesDetails(Request $request, ?string $slug_or_id = null): mixed
    {
        $catParam = $slug_or_id ?: $request->input('category_id');
        $search = trim((string) $request->input('search', ''));

        $currentCategory = $this->filterService->resolveCategory($catParam);
        $featured = $this->filterService->resolveCategoryFeatured($currentCategory);
        $topFeaturedProduct = $featured['top'];
        $middleFeaturedProduct = $featured['middle'];
        $bottomFeaturedProduct = $featured['bottom'];

        $catIds = $currentCategory
            ? $this->filterService->getCategoryWithDescendantIds([$currentCategory->id])
            : [];

        $products = Product::active()
            ->withCatalogRelations()
            ->inCategories($catIds)
            ->search($search)
            ->latest()
            ->paginate(50)
            ->withQueryString();

        $adSliders = $this->filterService->getSidebarAdSliders();

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest' || $request->input('ajax') == '1') {
            return response()->json([
                'status' => true,
                'total'  => $products->total(),
                'html'   => \theme_view('products.partials.product_grid', compact('products', 'topFeaturedProduct', 'search', 'currentCategory', 'adSliders'))->render(),
            ]);
        }

        return \theme_view('products.category.category', compact(
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
    public function productLanding(?string $slug = null): View
    {
        if (!$slug) {
            abort(404);
        }

        $data = $this->productService->getProductLanding($slug);

        if (!$data) {
            abort(404);
        }

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

        $filterParams = [
            'search'          => $search,
            'category'        => $cleanCategories,
            'currentCategory' => $currentCategory,
            'building_type'   => $request->input('building_type') ?: $request->input('building'),
            'room_type'       => $request->input('room_type') ?: $request->input('room'),
            'area_range'      => $request->input('area_range') ?: $request->input('coverage'),
            'occupancy'       => $request->input('occupancy'),
            'health_concern'  => $request->input('health_concern') ?: $request->input('health', []),
            'problem'         => $request->input('problem', []),
            'solution_needed' => $request->input('solution_needed') ?: $request->input('solution', []),
            'budget'          => $request->input('budget'),
        ];

        $query = Product::with([
            'categories:id,category_name,slug',
            'description:product_id,description,meta_title,tag',
            'images',
            'brand:id,name',
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
            ->with(['categories', 'images', 'brand', 'productAttributes', 'description']);

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
            $bestProduct->loadMissing(['categories', 'images', 'brand', 'productAttributes', 'description']);
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
