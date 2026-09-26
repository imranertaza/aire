<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Services\ProductFilterService;

class ProductController extends Controller
{
    public function __construct(
        protected ProductFilterService $filterService
    ) {}

    /**
     * Display product catalog listing by category.
     */
    public function categoriesDetails(Request $request, $slug_or_id = null)
    {
        $catParam = $slug_or_id ?: $request->input('category_id');
        $search = trim((string) $request->input('search', ''));

        $currentCategory = $this->filterService->resolveCategory($catParam);
        $featured = $this->filterService->resolveCategoryFeatured($currentCategory);
        $topFeaturedProduct = $featured['top'];
        $middleFeaturedProduct = $featured['middle'];
        $bottomFeaturedProduct = $featured['bottom'];

        // Optimized eager loading: exclude heavy unused relations
        $query = Product::with([
            'categories',
            'images',
            'special',
            'freeDelivery',
            'productLanding:id,product_id,status',
            'description:id,product_id,description'
        ])->where('status', 1);

        if ($currentCategory) {
            $catIds = $this->filterService->getCategoryWithDescendantIds([$currentCategory->id]);
            if (!empty($catIds)) {
                $query->whereHas('categories', fn($q) => $q->whereIn('product_categories.id', $catIds));
            }
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%")
                    ->orWhereHas('categories', fn($cq) => $cq->where('category_name', 'like', "%{$search}%"))
                    ->orWhereHas('description', function ($dq) use ($search) {
                        $dq->where('tag', 'like', "%{$search}%")
                            ->orWhere('meta_title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
            });
        }

        $products = $query->latest()->paginate(50)->withQueryString();
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

    public function categories(Request $request, $slug = null)
    {
        $allCategories = Cache::remember('catalog_categories_tree_v1', 3600, function () {
            return \App\Models\ProductCategory::active()
                ->where(function ($q) {
                    $q->whereNull('parent_id')->orWhere('parent_id', 0);
                })
                ->with([
                    'icon',
                    'children' => function ($q) {
                        $q->active();
                    },
                    'children.children' => function ($q) {
                        $q->active();
                    },
                    'featuredTopProducts.images',
                    'featuredBottomProducts.images'
                ])->get();
        });

        $adSliders = Cache::remember('category_sidebar_sliders', 3600, function () {
            return \App\Models\Slider::where('enabled', 1)
                ->where(function ($q) {
                    $q->where('key', 'category_sidebar')
                        ->orWhere('key', 'like', '%category_sidebar%')
                        ->orWhere('key', 'featured_ad')
                        ->orWhere('key', 'like', '%featured_ad%');
                })
                ->orderBy('order', 'asc')
                ->get();
        });

        if ($slug) {
            $categories = Cache::remember("catalog_category_slug_{$slug}", 3600, function () use ($slug) {
                return \App\Models\ProductCategory::active()
                    ->where('slug', $slug)
                    ->orWhere('category_name', 'like', str_replace('-', ' ', $slug))
                    ->with([
                        'icon',
                        'children' => function ($q) {
                            $q->active();
                        },
                        'children.children' => function ($q) {
                            $q->active();
                        },
                        'featuredTopProducts.images',
                        'featuredBottomProducts.images'
                    ])->first();
            });

            if (!$categories) {
                return abort(404);
            }

            return \theme_view('products.category.index', compact('categories', 'allCategories', 'adSliders'));
        }

        $categories = $allCategories;
        return \theme_view('products.category.index', compact('categories', 'allCategories', 'adSliders'));
    }

    /**
     * Display product detail page.
     */
    public function productDetail($slug)
    {
        $product = Cache::remember("product_detail_{$slug}", 3600, function () use ($slug) {
            return Product::where('slug', $slug)
                ->orWhere('id', is_numeric($slug) ? $slug : 0)
                ->with([
                    'categories',
                    'brand',
                    'images',
                    'description',
                    'overview',
                    'productAttributes.attributeGroup',
                    'productOptions.option',
                    'productOptions.optionValue',
                    'faqs',
                    'applications',
                    'special',
                    'freeDelivery',
                    'relatedProducts.categories',
                    'relatedProducts.images',
                    'relatedProducts.special',
                    'relatedProducts.freeDelivery',
                ])->first();
        });

        if (!$product) {
            abort(404);
        }

        // Canonical 301 redirect if accessed via ID or mismatched slug
        if (!empty($product->slug) && (string) $slug !== (string) $product->slug) {
            return redirect()->route('products.detail', $product->slug, 301);
        }

        $relatedProducts = Cache::remember("product_related_{$product->id}", 3600, function () use ($product) {
            $related = $product->relatedProducts;
            if ($related->isEmpty()) {
                $catId = $product->categories->first()?->id;
                $relatedQuery = Product::where('status', 1)->where('id', '!=', $product->id)->with(['categories', 'images', 'special']);
                if ($catId) {
                    $relatedQuery->whereHas('categories', function ($q) use ($catId) {
                        $q->where('product_categories.id', $catId);
                    });
                }
                $related = $relatedQuery->take(6)->get();
                if ($related->isEmpty()) {
                    $related = Product::where('status', 1)->where('id', '!=', $product->id)->with(['categories', 'images', 'special'])->take(6)->get();
                }
            }
            return $related;
        });

        return \theme_view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Display product landing page.
     */
    public function productLanding($slug = null)
    {
        if (!$slug) {
            abort(404);
        }

        $cacheKey = "product_landing_{$slug}";
        $data = Cache::remember($cacheKey, 3600, function () use ($slug) {
            $product = Product::where('status', 1)
                ->where(function ($q) use ($slug) {
                    $q->where('slug', $slug)
                        ->orWhere('id', is_numeric($slug) ? $slug : 0);
                })
                ->with([
                    'categories',
                    'brand',
                    'images',
                    'description',
                    'overview',
                    'productAttributes.attributeGroup',
                    'productOptions.option',
                    'productOptions.optionValue',
                    'faqs',
                    'applications',
                    'special',
                    'relatedProducts.categories',
                    'relatedProducts.images',
                    'productLanding',
                ])->first();

            if (!$product) {
                return null;
            }

            $landing = $product->productLanding;
            if (!$landing || (isset($landing->status) && (int) $landing->status === 0)) {
                return null;
            }

            $relatedProducts = $product->relatedProducts ?? collect();

            return compact('product', 'relatedProducts', 'landing');
        });

        if (!$data) {
            abort(404);
        }

        return \theme_view('products.landing', $data);
    }

    /**
     * Retrieve list of products and categories for live dropdown search with caching.
     */
    public function dropdownList(Request $request)
    {
        $search = trim($request->query('search', ''));
        $categoryId = $request->query('category_id');
        $limit = (int) $request->query('limit', 8);

        $cacheKey = 'search_dd_' . md5(json_encode([$search, $categoryId, $limit]));

        $payload = Cache::remember($cacheKey, 300, function () use ($search, $categoryId, $limit) {
            $query = Product::where('status', 1)->with(['categories', 'description', 'brand', 'productFilterOptions.filterOptionValue', 'applications']);

            if ($categoryId) {
                $query->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('product_categories.id', $categoryId);
                });
            }

            if (!empty($search)) {
                // Sanitize special boolean operators
                $cleanSearch = trim(preg_replace('/[+\-><\(\)~*\"@]+/', ' ', $search));

                if (mb_strlen($cleanSearch) >= 3) {
                    $words = array_filter(explode(' ', $cleanSearch), fn($w) => mb_strlen(trim($w)) >= 2);
                    $booleanQuery = !empty($words)
                        ? implode(' ', array_map(fn($w) => '+' . trim($w) . '*', $words))
                        : "+{$cleanSearch}*";

                    $query->where(function ($q) use ($cleanSearch, $booleanQuery) {
                        $q->whereRaw("MATCH(name, model, product_code) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery])
                            ->orWhereHas('categories', function ($cq) use ($cleanSearch) {
                                $cq->where('category_name', 'LIKE', "%{$cleanSearch}%");
                            })
                            ->orWhereHas('description', function ($dq) use ($cleanSearch) {
                                $dq->where('tag', 'LIKE', "%{$cleanSearch}%")
                                    ->orWhere('meta_title', 'LIKE', "%{$cleanSearch}%");
                            });
                    });

                    // Order by FULLTEXT relevance match
                    $query->orderByRaw("MATCH(name, model, product_code) AGAINST(? IN BOOLEAN MODE) DESC", [$booleanQuery]);
                } else {
                    // Fast B-Tree index prefix matching for short 1-2 character queries
                    $query->where(function ($q) use ($cleanSearch) {
                        $q->where('name', 'LIKE', "{$cleanSearch}%")
                            ->orWhere('model', 'LIKE', "{$cleanSearch}%")
                            ->orWhere('product_code', 'LIKE', "{$cleanSearch}%")
                            ->orWhereHas('categories', function ($cq) use ($cleanSearch) {
                                $cq->where('category_name', 'LIKE', "{$cleanSearch}%");
                            });
                    });
                }
            }

            $products = $query->latest('id')->take($limit)->get()->map(function ($p) {
                $firstCategory = $p->categories->first();
                return [
                    'id'          => $p->id,
                    'name'        => $p->name,
                    'slug'        => $p->slug,
                    'model'       => $p->model ?? '',
                    'price'       => number_format((float) $p->price, 2),
                    'raw_price'   => (float) $p->price,
                    'image'       => $p->main_image ? getImageCacheUrl($p->main_image, 160, 160, 'webp') : asset('themes/default/assets/img/Air-Purify.png'),
                    'url'         => route('products.detail', $p->slug ?: $p->id),
                    'category'    => $firstCategory?->category_name ?? 'Air Care',
                    'category_bg' => $firstCategory?->bg_color ?: '#0066cc',
                    'tag'         => $p->description?->tag ?? '',
                ];
            });

            // Also search matching categories if search query provided
            $categories = [];
            if (!empty($search)) {
                $categories = \App\Models\ProductCategory::active()
                    ->where('category_name', 'LIKE', "%{$search}%")
                    ->take(4)
                    ->get()
                    ->map(function ($c) {
                        return [
                            'id'   => $c->id,
                            'name' => $c->category_name,
                            'slug' => $c->slug,
                            'url'  => route('products.filter', $c->slug ?: $c->id),
                        ];
                    });
            }

            // Search matching requirement / application filter tags
            $matchingTags = [];
            if (!empty($search)) {
                $matchingTags = \App\Models\FilterOptionValue::with('filterOption:id,name')
                    ->where('name', 'LIKE', "%{$search}%")
                    ->take(4)
                    ->get()
                    ->map(function ($fov) {
                        return [
                            'id'    => $fov->id,
                            'name'  => $fov->name,
                            'group' => $fov->filterOption?->name ?? 'Filter',
                            'url'   => route('products.filter') . '?search=' . urlencode($fov->name),
                        ];
                    });
            }

            return [
                'status'        => true,
                'data'          => $products,
                'products'      => $products,
                'categories'    => $categories,
                'matching_tags' => $matchingTags,
                'total'         => $products->count(),
            ];
        });

        return response()->json($payload);
    }

    /**
     * Display product filter page.
     */
    public function productFilter(Request $request, $slug_or_id = null)
    {
        $search = trim((string) $request->input('search', ''));

        // 1. Categories Filter Parameter (First filter)
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
            'brand:id,name'
        ])->where('status', 1);

        $query = $this->filterService->applyFilters($query, $filterParams);

        $products = $query->latest()->paginate(50)->withQueryString();

        // Clean parameters (omit 'any', 'all', and empty values)
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
    public function filter(Request $request)
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
     * API endpoint for dynamic wizard filtering, real-time matching, and progressive cascading options.
     */
    public function filterStepApi(Request $request)
    {
        $categorySlugs = (array) $request->input('category_slugs', []);

        $params = [
            'category'        => $request->input('category') ?: ($request->input('industry') ?: ($categorySlugs[0] ?? null)),
            'building_type'   => $request->input('building_type') ?: ($request->input('building') ?: ($categorySlugs[1] ?? null)),
            'room_type'       => $request->input('room_type') ?: ($request->input('room') ?: ($categorySlugs[2] ?? null)),
            'area_range'      => $request->input('area_range') ?: ($request->input('coverage') ?: ($categorySlugs[3] ?? null)),
            'occupancy'       => $request->input('occupancy') ?: ($categorySlugs[4] ?? null),
            'health_concern'  => (array) ($request->input('health_concern') ?: ($request->input('health') ?: ($categorySlugs[5] ?? []))),
            'problem'         => (array) ($request->input('problem') ?: ($categorySlugs[6] ?? [])),
            'solution_needed' => (array) ($request->input('solution_needed') ?: ($request->input('solution') ?: ($categorySlugs[7] ?? []))),
            'budget'          => $request->input('budget') ?: ($categorySlugs[8] ?? null),
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

    public function favorite()
    {
        $favoriteIds = session()->get('favorites', []);
        $products = Product::whereIn('id', $favoriteIds)
            ->where('status', 1)
            ->with(['categories', 'images', 'special', 'freeDelivery', 'productLanding:id,product_id,status', 'description:id,product_id,description'])
            ->get();

        $adSliders = Cache::remember('favorite_ad_sliders', 3600, function () {
            return \App\Models\Slider::where('enabled', 1)
                ->where(function ($q) {
                    $q->where('key', 'favorite')->orWhere('key', 'like', '%favorite%');
                })
                ->orderBy('order', 'asc')
                ->get();
        });

        return \theme_view('favorite', compact('products', 'adSliders'));
    }

    /**
     * Toggle item favorite/wishlist status.
     */

    public function toggleFavorite(Request $request)
    {
        $productId = (int)$request->product_id;
        $favorites = session()->get('favorites', []);

        if (in_array($productId, $favorites)) {
            $favorites = array_values(array_diff($favorites, [$productId]));
            $isFavorite = false;
            $message = 'Product removed from favorites.';
        } else {
            $favorites[] = $productId;
            $isFavorite = true;
            $message = 'Product added to favorites.';
        }

        session()->put('favorites', $favorites);

        return response()->json([
            'success' => true,
            'is_favorite' => $isFavorite,
            'message' => $message,
            'count' => count($favorites),
            'favorites_count' => count($favorites),
            'favorite_count' => count($favorites)
        ]);
    }

    /**
     * Toggle a product in/out of the customer's wishlist (DB column).
     * Falls back to session-based list for guests.
     */

    public function toggleWishlist(Request $request)
    {
        $productId = (int) $request->product_id;
        if (!$productId) {
            return response()->json(['success' => false, 'message' => 'Invalid product.'], 400);
        }

        if (Auth::guard('customer')->check()) {
            // Persist in DB wishlist column
            $customer = Auth::guard('customer')->user();
            $list = json_decode($customer->wishlist ?? '[]', true);

            if (in_array($productId, $list)) {
                $list = array_values(array_diff($list, [$productId]));
                $added = false;
                $msg   = 'Removed from wishlist.';
            } else {
                $list[] = $productId;
                $added  = true;
                $msg    = 'Added to wishlist!';
            }

            $customer->wishlist = json_encode($list);
            $customer->save();
        } else {
            // Guest: session-based
            $list = session()->get('favorites', []);
            if (in_array($productId, $list)) {
                $list  = array_values(array_diff($list, [$productId]));
                $added = false;
                $msg   = 'Removed from wishlist.';
            } else {
                $list[] = $productId;
                $added  = true;
                $msg    = 'Added to wishlist!';
            }
            session()->put('favorites', $list);
        }

        return response()->json([
            'success'    => true,
            'added'      => $added,
            'message'    => $msg,
            'wish_count' => count($list),
        ]);
    }

    /**
     * Display product comparison page.
     */

    public function compare()
    {
        $compareIds = session()->get('compare', []);
        $comparedProducts = Product::with(['categories', 'brand', 'images', 'productAttributes'])->whereIn('id', $compareIds)->get();

        $adSliders = \App\Models\Slider::where('enabled', 1)
            ->where(function ($q) {
                $q->where('key', 'compare')
                    ->orWhere('key', 'like', '%compare%');
            })
            ->orderBy('order', 'asc')
            ->get();

        return \theme_view('compare', compact('comparedProducts', 'adSliders'));
    }

    /**
     * Add product to compare session (works for both guests and authenticated customers).
     */
    public function addToCompare(Request $request)
    {
        $productId = (int) ($request->input('product_id') ?? $request->json('product_id'));
        if (!$productId) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a valid product.'
            ], 400);
        }

        $product = Product::where('id', $productId)->where('status', 1)->first();
        if (!$product) {
            $currentCompare = session()->get('compare', []);
            return response()->json([
                'success' => false,
                'message' => 'Product is currently unavailable or inactive.',
                'count'   => count($currentCompare),
                'compare_count' => count($currentCompare)
            ]);
        }

        $compare = session()->get('compare', []);

        if (in_array($productId, $compare)) {
            return response()->json([
                'success' => false,
                'already_added' => true,
                'message' => 'Product is already in your comparison list!',
                'count'   => count($compare),
                'compare_count' => count($compare)
            ]);
        }

        if (count($compare) >= 3) {
            return response()->json([
                'success' => false,
                'limit_reached' => true,
                'message' => 'You can compare up to 3 products at a time. Please remove one first.',
                'count'   => count($compare),
                'compare_count' => count($compare)
            ]);
        }

        $compare[] = $productId;
        session()->put('compare', $compare);
        session()->put('compare_products', $compare);

        return response()->json([
            'success' => true,
            'message' => 'Product added to comparison list!',
            'count'   => count($compare),
            'compare_count' => count($compare),
            'product' => [
                'id'   => $product->id,
                'name' => $product->name
            ]
        ]);
    }

    /**
     * Remove product from compare session.
     */
    public function removeFromCompare(Request $request)
    {
        $productId = (int) ($request->input('product_id') ?? $request->json('product_id'));
        $compare = session()->get('compare', []);

        $compare = array_values(array_filter($compare, fn($id) => (int)$id !== $productId));
        session()->put('compare', $compare);
        session()->put('compare_products', $compare);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from comparison list!',
            'count'   => count($compare),
            'compare_count' => count($compare)
        ]);
    }

    /**
     * Clear all compared products.
     */
    public function clearCompare()
    {
        session()->forget('compare');
        session()->forget('compare_products');

        return response()->json([
            'success' => true,
            'message' => 'Comparison list cleared!',
            'count'   => 0,
            'compare_count' => 0
        ]);
    }
}
