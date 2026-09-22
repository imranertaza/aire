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

class ProductController extends Controller
{
    /**
     * Display product catalog listing.
     */

    public function categoriesDetails(Request $request, $slug_or_id = null)
    {
        $catParam = $slug_or_id ?: $request->input('category_id');
        $search = trim($request->input('search', ''));

        $currentCategory = null;
        $topFeaturedProduct = null;
        $middleFeaturedProduct = null;
        $bottomFeaturedProduct = null;

        if ($catParam) {
            if (is_numeric($catParam)) {
                $currentCategory = \App\Models\ProductCategory::with([
                    'featuredTopProducts.images',
                    'featuredMiddleProducts.images',
                    'featuredBottomProducts.images'
                ])->find($catParam);
            } else {
                $currentCategory = \App\Models\ProductCategory::with([
                    'featuredTopProducts.images',
                    'featuredMiddleProducts.images',
                    'featuredBottomProducts.images'
                ])->where('slug', $catParam)
                    ->orWhere('category_name', 'like', str_replace('-', ' ', $catParam))
                    ->first();
            }

            if ($currentCategory) {
                $topFeaturedProduct = $currentCategory->featuredTopProducts->first();
                $middleFeaturedProduct = $currentCategory->featuredMiddleProducts->first();
                $bottomFeaturedProduct = $currentCategory->featuredBottomProducts->first();
            }
        }

        // Fallbacks if not set on specific category
        if (!$topFeaturedProduct) {
            $topFeaturedProduct = Product::where('status', 1)->where('featured', 1)->with(['categories', 'images'])->latest()->first();
        }
        if (!$middleFeaturedProduct) {
            $middleFeaturedProduct = Product::where('status', 1)->where('featured', 1)->with(['categories', 'images'])->skip(1)->first()
                ?: $topFeaturedProduct;
        }
        if (!$bottomFeaturedProduct) {
            $bottomFeaturedProduct = Product::where('status', 1)->where('featured', 1)->with(['categories', 'images'])->oldest()->first();
        }

        $query = Product::with(['categories', 'productAttributes', 'description', 'images', 'brand', 'productOptions.optionValue', 'special', 'freeDelivery'])->where('status', 1);

        if ($currentCategory) {
            $catIds = [$currentCategory->id];
            if ($currentCategory->children && $currentCategory->children->count() > 0) {
                $catIds = array_merge($catIds, $currentCategory->children->pluck('id')->toArray());
            }
            $query->whereHas('categories', function ($q) use ($catIds) {
                $q->whereIn('product_categories.id', $catIds);
            });
        }

        // Search text filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%")
                    ->orWhereHas('categories', function ($cq) use ($search) {
                        $cq->where('category_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('description', function ($dq) use ($search) {
                        $dq->where('tag', 'like', "%{$search}%")
                            ->orWhere('meta_title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
            });
        }

        $products = $query->latest()->paginate(50)->withQueryString();

        $adSliders = \App\Models\Slider::where('enabled', 1)
            ->where(function ($q) {
                $q->where('key', 'filter')
                    ->orWhere('key', 'like', '%filter%')
                    ->orWhere('key', 'category_sidebar')
                    ->orWhere('key', 'like', '%category_sidebar%');
            })
            ->orderBy('order', 'asc')
            ->get();

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
        $allCategories = \App\Models\ProductCategory::active()
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

        $adSliders = \App\Models\Slider::where('enabled', 1)
            ->where(function ($q) {
                $q->where('key', 'category_sidebar')
                    ->orWhere('key', 'like', '%category_sidebar%')
                    ->orWhere('key', 'featured_ad')
                    ->orWhere('key', 'like', '%featured_ad%');
            })
            ->orderBy('order', 'asc')
            ->get();

        if ($slug) {
            $categories = \App\Models\ProductCategory::active()
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
                $keywords = array_filter(explode(' ', $search), fn($k) => mb_strlen(trim($k)) >= 3);

                $query->where(function ($q) use ($search, $keywords) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('model', 'LIKE', "%{$search}%")
                        ->orWhere('product_code', 'LIKE', "%{$search}%")
                        ->orWhereHas('categories', function ($cq) use ($search) {
                            $cq->where('category_name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('description', function ($dq) use ($search) {
                            $dq->where('tag', 'LIKE', "%{$search}%")
                                ->orWhere('meta_title', 'LIKE', "%{$search}%")
                                ->orWhere('meta_description', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('productFilterOptions.filterOptionValue', function ($foq) use ($search) {
                            $foq->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('applications', function ($aq) use ($search) {
                            $aq->where('title', 'LIKE', "%{$search}%")
                                ->orWhere('description', 'LIKE', "%{$search}%");
                        });

                    if (!empty($keywords) && count($keywords) > 1) {
                        foreach ($keywords as $kw) {
                            $kw = trim($kw);
                            if (in_array(strtolower($kw), ['for', 'the', 'and', 'with', 'air', 'all'])) continue;
                            $q->orWhere('name', 'LIKE', "%{$kw}%")
                                ->orWhere('model', 'LIKE', "%{$kw}%")
                                ->orWhereHas('productFilterOptions.filterOptionValue', fn($foq) => $foq->where('name', 'LIKE', "%{$kw}%"))
                                ->orWhereHas('applications', fn($aq) => $aq->where('title', 'LIKE', "%{$kw}%"));
                        }
                    }
                });
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
        $search = trim($request->input('search', ''));

        // 1. Categories Filter Parameter (First filter)
        $categoryFilter = $request->input('category') ?: ($slug_or_id ?: $request->input('category_id'));
        $cleanCategories = array_filter((array) $categoryFilter, fn($v) => $v !== 'any' && $v !== 'all' && !empty($v));

        // 8 Other Filter Parameters
        $buildingType = $request->input('building_type') ?: $request->input('building');
        $roomType = $request->input('room_type') ?: $request->input('room');
        $areaRange = $request->input('area_range') ?: $request->input('coverage');
        $occupancy = $request->input('occupancy');
        $healthConcerns = (array) ($request->input('health_concern') ?: $request->input('health', []));
        $problems = (array) $request->input('problem', []);
        $solutionsNeeded = (array) ($request->input('solution_needed') ?: $request->input('solution', []));
        $budget = $request->input('budget');

        $currentCategory = null;
        $topFeaturedProduct = null;
        $middleFeaturedProduct = null;
        $bottomFeaturedProduct = null;

        if (!empty($cleanCategories)) {
            $firstCat = reset($cleanCategories);
            if (is_numeric($firstCat)) {
                $currentCategory = \App\Models\ProductCategory::with([
                    'featuredTopProducts.images',
                    'featuredMiddleProducts.images',
                    'featuredBottomProducts.images',
                    'children'
                ])->find($firstCat);
            } else {
                $slugKeyword = str_replace('_', '-', $firstCat);
                $nameKeyword = str_replace(['_', '-'], ' ', $firstCat);
                $currentCategory = \App\Models\ProductCategory::with([
                    'featuredTopProducts.images',
                    'featuredMiddleProducts.images',
                    'featuredBottomProducts.images',
                    'children'
                ])->where('slug', $slugKeyword)
                    ->orWhere('slug', $firstCat)
                    ->orWhere('category_name', $nameKeyword)
                    ->orWhere('category_name', $firstCat)
                    ->first();
            }

            if ($currentCategory) {
                $topFeaturedProduct = $currentCategory->featuredTopProducts->first();
                $middleFeaturedProduct = $currentCategory->featuredMiddleProducts->first();
                $bottomFeaturedProduct = $currentCategory->featuredBottomProducts->first();
            }
        }

        // Fallbacks if not set on specific category
        if (!$topFeaturedProduct) {
            $topFeaturedProduct = Product::where('status', 1)->where('featured', 1)->with(['categories', 'images'])->latest()->first();
        }
        if (!$middleFeaturedProduct) {
            $middleFeaturedProduct = Product::where('status', 1)->where('featured', 1)->with(['categories', 'images'])->skip(1)->first()
                ?: $topFeaturedProduct;
        }
        if (!$bottomFeaturedProduct) {
            $bottomFeaturedProduct = Product::where('status', 1)->where('featured', 1)->with(['categories', 'images'])->oldest()->first();
        }

        $cleanHealth = array_filter($healthConcerns, fn($v) => $v !== 'any' && $v !== 'all' && !empty($v));
        $cleanProblems = array_filter($problems, fn($v) => $v !== 'any' && $v !== 'all' && !empty($v));
        $cleanSolutions = array_filter($solutionsNeeded, fn($v) => $v !== 'any' && $v !== 'all' && !empty($v));

        // Generic budget parser helper for range matching
        $parseBudget = function ($val) {
            if (empty($val) || $val === 'any' || $val === 'all') {
                return null;
            }
            $str = strtolower(trim((string)$val));
            $clean = str_replace(['$', '€', '£', ',', ' '], '', $str);

            // 1. Under / Below / Less than / 0 to X / Entry
            if (
                strpos($str, 'under') !== false ||
                strpos($str, 'below') !== false ||
                strpos($str, 'upto') !== false ||
                strpos($str, 'less') !== false ||
                strpos($str, 'entry') !== false ||
                strpos($str, '0_') === 0 ||
                strpos($str, '0-') === 0
            ) {
                if (preg_match('/(\d+)/', $clean, $m)) {
                    return ['min' => 0, 'max' => (float)$m[1]];
                }
            }

            // 2. Over / Above / Plus / + / Enterprise / Over 2500 / 3000+
            if (
                strpos($str, 'over') !== false ||
                strpos($str, 'above') !== false ||
                strpos($str, 'more') !== false ||
                strpos($str, 'greater') !== false ||
                strpos($str, '+') !== false ||
                strpos($str, 'plus') !== false ||
                strpos($str, 'enterprise') !== false
            ) {
                if (preg_match('/(\d+)/', $clean, $m)) {
                    return ['min' => (float)$m[1], 'max' => null];
                }
            }

            // 3. Between min and max: "500_1000", "1000_2500", "500-1000", "500_to_1000"
            if (preg_match('/(\d+)(?:-|–|_to_|to|_)(\d+)/', $clean, $m)) {
                return ['min' => (float)$m[1], 'max' => (float)$m[2]];
            }

            // 4. Fallback keywords
            if ($str === 'medium') return ['min' => 500, 'max' => 1000];
            if ($str === 'commercial') return ['min' => 1000, 'max' => 2500];
            if ($str === 'premium') return ['min' => 2500, 'max' => 5000];
            if ($str === 'industrial') return ['min' => 2000, 'max' => 3000];

            return null;
        };

        // In-memory category hierarchy resolver (0 recursive DB queries)
        $allCategoryPairs = \App\Models\ProductCategory::select('id', 'parent_id', 'slug', 'category_name')->get();
        $categoriesByParent = [];
        foreach ($allCategoryPairs as $c) {
            $categoriesByParent[$c->parent_id][] = $c->id;
        }
        $getCategoryWithDescendantIds = function ($catIds) use ($categoriesByParent) {
            $catIds = (array) $catIds;
            $allIds = $catIds;
            $queue = $catIds;
            while (!empty($queue)) {
                $nextQueue = [];
                foreach ($queue as $pId) {
                    if (!empty($categoriesByParent[$pId])) {
                        foreach ($categoriesByParent[$pId] as $childId) {
                            $allIds[] = $childId;
                            $nextQueue[] = $childId;
                        }
                    }
                }
                $queue = $nextQueue;
            }
            return array_unique($allIds);
        };

        // Helper to resolve request values to exact FilterOptionValue IDs (0 N+1 lazy loading queries)
        $allDbOptionValues = \App\Models\FilterOptionValue::with('filterOption:id,name')->get();
        $resolveOptionValueIds = function ($reqValues, $optionNameKeyword = null) use ($allDbOptionValues) {
            $reqList = array_map('strval', (array)$reqValues);
            return $allDbOptionValues->filter(function ($ov) use ($reqList, $optionNameKeyword) {
                if ($optionNameKeyword) {
                    $opt = $ov->filterOption;
                    if ($opt && stripos($opt->name, $optionNameKeyword) === false) {
                        return false;
                    }
                }
                $slug = \Illuminate\Support\Str::slug($ov->name, '_');
                return in_array($slug, $reqList, true)
                    || in_array((string)$ov->id, $reqList, true)
                    || in_array(strtolower($ov->name), array_map('strtolower', $reqList), true);
            })->pluck('id')->toArray();
        };

        // Track which filters are actively selected
        $activeFiltersMap = [
            'category' => !empty($cleanCategories) || !empty($currentCategory),
            'building_type' => !empty($buildingType) && $buildingType !== 'any' && $buildingType !== 'all',
            'room_type' => !empty($roomType) && $roomType !== 'any' && $roomType !== 'all',
            'area_range' => !empty($areaRange) && $areaRange !== 'any' && $areaRange !== 'all',
            'occupancy' => !empty($occupancy) && $occupancy !== 'any' && $occupancy !== 'all',
            'health_concern' => !empty($cleanHealth),
            'problem' => !empty($cleanProblems),
            'solution_needed' => !empty($cleanSolutions),
            'budget' => !empty($budget) && $budget !== 'any' && $budget !== 'all',
            'search' => !empty($search),
        ];

        // Filter closures for progressive dynamic narrowing
        $filterAppliers = [
            'category' => function ($q) use ($cleanCategories, $currentCategory, $allCategoryPairs, $getCategoryWithDescendantIds) {
                if (!empty($cleanCategories)) {
                    $baseCatIds = [];
                    foreach ($cleanCategories as $cVal) {
                        $slugKeyword = str_replace('_', '-', $cVal);
                        $nameKeyword = str_replace(['_', '-'], ' ', $cVal);
                        $found = $allCategoryPairs->first(function ($cat) use ($cVal, $slugKeyword, $nameKeyword) {
                            return (string)$cat->id === (string)$cVal
                                || $cat->slug === $slugKeyword
                                || $cat->slug === $cVal
                                || strcasecmp($cat->category_name, $nameKeyword) === 0
                                || strcasecmp($cat->category_name, $cVal) === 0;
                        });
                        if ($found) $baseCatIds[] = $found->id;
                    }
                    $allCatIds = $getCategoryWithDescendantIds($baseCatIds);
                    if (!empty($allCatIds)) {
                        $q->whereHas('categories', fn($cq) => $cq->whereIn('product_categories.id', $allCatIds));
                    }
                } elseif ($currentCategory) {
                    $allCatIds = $getCategoryWithDescendantIds([$currentCategory->id]);
                    $q->whereHas('categories', fn($cq) => $cq->whereIn('product_categories.id', $allCatIds));
                }
            },
            'building_type' => function ($q) use ($buildingType, $resolveOptionValueIds) {
                if (!empty($buildingType) && $buildingType !== 'any' && $buildingType !== 'all') {
                    $valIds = $resolveOptionValueIds($buildingType, 'Building');
                    if (!empty($valIds)) {
                        $q->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $valIds));
                    }
                }
            },
            'room_type' => function ($q) use ($roomType, $resolveOptionValueIds) {
                if (!empty($roomType) && $roomType !== 'any' && $roomType !== 'all') {
                    $valIds = $resolveOptionValueIds($roomType, 'Room');
                    if (!empty($valIds)) {
                        $q->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $valIds));
                    }
                }
            },
            'area_range' => function ($q) use ($areaRange, $resolveOptionValueIds) {
                if (!empty($areaRange) && $areaRange !== 'any' && $areaRange !== 'all') {
                    $valIds = $resolveOptionValueIds($areaRange, 'Area');
                    if (!empty($valIds)) {
                        $q->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $valIds));
                    }
                }
            },
            'occupancy' => function ($q) use ($occupancy, $resolveOptionValueIds) {
                if (!empty($occupancy) && $occupancy !== 'any' && $occupancy !== 'all') {
                    $valIds = $resolveOptionValueIds($occupancy, 'Occupancy');
                    if (!empty($valIds)) {
                        $q->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $valIds));
                    }
                }
            },
            'health_concern' => function ($q) use ($cleanHealth, $resolveOptionValueIds) {
                if (!empty($cleanHealth)) {
                    $valIds = $resolveOptionValueIds($cleanHealth, 'Health');
                    if (!empty($valIds)) {
                        $q->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $valIds));
                    }
                }
            },
            'problem' => function ($q) use ($cleanProblems, $resolveOptionValueIds) {
                if (!empty($cleanProblems)) {
                    $valIds = $resolveOptionValueIds($cleanProblems, 'Problem');
                    if (!empty($valIds)) {
                        $q->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $valIds));
                    }
                }
            },
            'solution_needed' => function ($q) use ($cleanSolutions, $resolveOptionValueIds) {
                if (!empty($cleanSolutions)) {
                    $valIds = $resolveOptionValueIds($cleanSolutions, 'Solution');
                    if (!empty($valIds)) {
                        $q->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $valIds));
                    }
                }
            },
            'budget' => function ($q) use ($budget, $parseBudget) {
                if (!empty($budget) && $budget !== 'any' && $budget !== 'all') {
                    $budgetList = is_array($budget) ? $budget : [$budget];
                    $ranges = [];
                    foreach ($budgetList as $bItem) {
                        $parsed = $parseBudget($bItem);
                        if ($parsed) {
                            $ranges[] = $parsed;
                        }
                    }

                    if (!empty($ranges)) {
                        $q->where(function ($bq) use ($ranges) {
                            foreach ($ranges as $idx => $r) {
                                if ($r['max'] === null) {
                                    if ($idx === 0) {
                                        $bq->where('price', '>=', $r['min']);
                                    } else {
                                        $bq->orWhere('price', '>=', $r['min']);
                                    }
                                } elseif ($r['min'] <= 0) {
                                    if ($idx === 0) {
                                        $bq->where('price', '<=', $r['max']);
                                    } else {
                                        $bq->orWhere('price', '<=', $r['max']);
                                    }
                                } else {
                                    if ($idx === 0) {
                                        $bq->whereBetween('price', [$r['min'], $r['max']]);
                                    } else {
                                        $bq->orWhereBetween('price', [$r['min'], $r['max']]);
                                    }
                                }
                            }
                        });
                    }
                }
            },
            'search' => function ($q) use ($search) {
                if (!empty($search)) {
                    $keywords = array_filter(explode(' ', $search), fn($k) => mb_strlen(trim($k)) >= 3);
                    $q->where(function ($sq) use ($search, $keywords) {
                        $sq->where('name', 'like', "%{$search}%")
                            ->orWhere('model', 'like', "%{$search}%")
                            ->orWhere('product_code', 'like', "%{$search}%")
                            ->orWhereHas('categories', fn($cq) => $cq->where('category_name', 'like', "%{$search}%"))
                            ->orWhereHas('description', function ($dq) use ($search) {
                                $dq->where('tag', 'like', "%{$search}%")
                                    ->orWhere('meta_title', 'like', "%{$search}%")
                                    ->orWhere('description', 'like', "%{$search}%");
                            })
                            ->orWhereHas('productFilterOptions.filterOptionValue', function ($foq) use ($search) {
                                $foq->where('name', 'like', "%{$search}%");
                            })
                            ->orWhereHas('applications', function ($aq) use ($search) {
                                $aq->where('title', 'like', "%{$search}%")
                                    ->orWhere('description', 'like', "%{$search}%");
                            });

                        if (!empty($keywords) && count($keywords) > 1) {
                            foreach ($keywords as $kw) {
                                $kw = trim($kw);
                                if (in_array(strtolower($kw), ['for', 'the', 'and', 'with', 'air', 'all'])) continue;
                                $sq->orWhere('name', 'like', "%{$kw}%")
                                    ->orWhere('model', 'like', "%{$kw}%")
                                    ->orWhereHas('productFilterOptions.filterOptionValue', fn($foq) => $foq->where('name', 'like', "%{$kw}%"))
                                    ->orWhereHas('applications', fn($aq) => $aq->where('title', 'like', "%{$kw}%"));
                            }
                        }
                    });
                }
            },
        ];

        // 1. Build Main Filtered Query (Optimized eager loading)
        $query = Product::with([
            'categories:id,category_name,slug',
            'description:product_id,description,meta_title,tag',
            'images',
            'brand:id,name'
        ])->where('status', 1);

        foreach ($filterAppliers as $applier) {
            $applier($query);
        }

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

        $adSliders = \App\Models\Slider::where('enabled', 1)
            ->where(function ($q) {
                $q->where('key', 'filter')
                    ->orWhere('key', 'like', '%filter%')
                    ->orWhere('key', 'category_sidebar')
                    ->orWhere('key', 'like', '%category_sidebar%');
            })
            ->orderBy('order', 'asc')
            ->get();

        // 2. Fetch Active Filter Options from DB
        $dbOptions = \App\Models\FilterOption::with(['optionValues' => function ($q) {
            $q->where('status', 1)
                ->orderBy('sort_order');
        }])
            ->where('status', 1)
            ->where('show_in_filter', 1)
            ->whereNotIn('name', ['Color', 'Size', 'Material'])
            ->orderBy('sort_order')
            ->get();

        // 3. Category Filter Options (Always shows all active categories where show_in_filter = 1)
        $allCategories = [];
        $dbFilterCategories = \App\Models\ProductCategory::active()
            ->where('show_in_filter', 1)
            ->orderBy('sort_order')
            ->get();

        foreach ($dbFilterCategories as $cat) {
            $key = $cat->slug ?: $cat->id;
            $allCategories[$key] = $cat->category_name;
        }
        $filterCategories = $allCategories; // Categories never shrink or vanish!

        // Map option names to input types (radio vs checkbox)
        $filterOptionTypes = [];
        foreach ($dbOptions as $opt) {
            $filterOptionTypes[$opt->name] = $opt->type ?? 'radio';
        }

        // 4. Build Dynamic Filter Sections with Progressive Option Refetching (Optimized & Memoized)
        $paramKeyMap = [
            'building type' => 'building_type',
            'room / area type' => 'room_type',
            'room type' => 'room_type',
            'area range (m²)' => 'area_range',
            'area range' => 'area_range',
            'occupancy' => 'occupancy',
            'health concern' => 'health_concern',
            'problem' => 'problem',
            'solution needed' => 'solution_needed',
            'budget range' => 'budget',
            'budget' => 'budget',
        ];

        $unselectedProductIds = null;
        $unselectedOptValueIds = null;
        $unselectedPrices = null;

        $dynamicFilterSections = [];
        $filterBuildingTypes = [];
        $filterRoomTypes = [];
        $filterAreaRanges = [];
        $filterOccupancies = [];
        $filterHealthConcerns = [];
        $filterProblems = [];
        $filterSolutions = [];
        $filterBudgets = [];

        foreach ($dbOptions as $opt) {
            $optNameLower = strtolower(trim($opt->name));
            $paramKey = $paramKeyMap[$optNameLower] ?? \Illuminate\Support\Str::slug($opt->name, '_');
            $isCheckbox = ($opt->type === 'checkbox');
            $inputName = $isCheckbox ? ($paramKey . '[]') : $paramKey;
            $reqValues = (array) $request->input($paramKey, []);
            $activeRadioVal = $request->input($paramKey, 'any');
            $isFilterActive = !empty($activeFiltersMap[$paramKey]);

            // Memoized Candidate Query for this section
            if (!$isFilterActive && $unselectedProductIds !== null) {
                $sectionProductIds = $unselectedProductIds;
            } else {
                $sectionQuery = Product::where('status', 1);
                foreach ($filterAppliers as $fKey => $applier) {
                    if ($fKey === $paramKey || ($fKey === 'category' && $paramKey === 'categories')) {
                        continue; // Keep this group's options selectable
                    }
                    $applier($sectionQuery);
                }
                $sectionProductIds = $sectionQuery->pluck('id')->toArray();
                if (!$isFilterActive) {
                    $unselectedProductIds = $sectionProductIds;
                }
            }

            $sectionOptValueIds = [];
            $sectionPrices = [];
            if (!empty($sectionProductIds)) {
                if ($paramKey === 'budget' || stripos($opt->name, 'budget') !== false) {
                    if (!$isFilterActive && $unselectedPrices !== null) {
                        $sectionPrices = $unselectedPrices;
                    } else {
                        $sectionPrices = \Illuminate\Support\Facades\DB::table('products')->whereIn('id', $sectionProductIds)->pluck('price')->map(fn($p) => (float)$p)->toArray();
                        if (!$isFilterActive) $unselectedPrices = $sectionPrices;
                    }
                } else {
                    if (!$isFilterActive && $unselectedOptValueIds !== null) {
                        $sectionOptValueIds = $unselectedOptValueIds;
                    } else {
                        $sectionOptValueIds = \Illuminate\Support\Facades\DB::table('product_filter_options')
                            ->whereIn('product_id', $sectionProductIds)
                            ->pluck('filter_option_value_id')
                            ->unique()
                            ->toArray();
                        if (!$isFilterActive) $unselectedOptValueIds = $sectionOptValueIds;
                    }
                }
            }

            $sectionOptions = [];
            $hasChecked = false;

            if ($paramKey === 'budget' || stripos($opt->name, 'budget') !== false) {
                foreach ($opt->optionValues as $ov) {
                    if (strtolower($ov->name) === 'any') continue;
                    $val = \Illuminate\Support\Str::slug($ov->name, '_') ?: $ov->name;
                    $label = $ov->name;
                    $isChecked = $isCheckbox ? in_array($val, $reqValues) : ($activeRadioVal === $val);
                    if ($isChecked) $hasChecked = true;

                    $parsedRange = $parseBudget($val) ?: $parseBudget($label);
                    $hasBudgetMatch = false;

                    if ($parsedRange && !empty($sectionPrices)) {
                        foreach ($sectionPrices as $pPrice) {
                            if ($parsedRange['max'] === null) {
                                if ($pPrice >= $parsedRange['min']) {
                                    $hasBudgetMatch = true;
                                    break;
                                }
                            } elseif ($parsedRange['min'] <= 0) {
                                if ($pPrice <= $parsedRange['max']) {
                                    $hasBudgetMatch = true;
                                    break;
                                }
                            } else {
                                if ($pPrice >= $parsedRange['min'] && $pPrice <= $parsedRange['max']) {
                                    $hasBudgetMatch = true;
                                    break;
                                }
                            }
                        }
                    }

                    if ($isChecked || $hasBudgetMatch) {
                        $sectionOptions[$val] = [
                            'label' => $label,
                            'is_checked' => $isChecked,
                        ];
                        $filterBudgets[$val] = $label;
                    }
                }
            } else {
                foreach ($opt->optionValues as $ov) {
                    if (strtolower($ov->name) === 'any') continue;
                    $val = \Illuminate\Support\Str::slug($ov->name, '_') ?: $ov->name;
                    $label = $ov->name;
                    $isChecked = $isCheckbox ? in_array($val, $reqValues) : ($activeRadioVal === $val);
                    if ($isChecked) $hasChecked = true;

                    $hasMatch = in_array((int)$ov->id, $sectionOptValueIds, true);

                    if ($isChecked || $hasMatch) {
                        $sectionOptions[$val] = [
                            'label' => $label,
                            'is_checked' => $isChecked,
                        ];
                        if ($paramKey === 'building_type') $filterBuildingTypes[$val] = $label;
                        elseif ($paramKey === 'room_type') $filterRoomTypes[$val] = $label;
                        elseif ($paramKey === 'area_range') $filterAreaRanges[$val] = $label;
                        elseif ($paramKey === 'occupancy') $filterOccupancies[$val] = $label;
                        elseif ($paramKey === 'health_concern') $filterHealthConcerns[$val] = $label;
                        elseif ($paramKey === 'problem') $filterProblems[$val] = $label;
                        elseif ($paramKey === 'solution_needed') $filterSolutions[$val] = $label;
                    }
                }
            }

            if (!empty($sectionOptions)) {
                $dynamicFilterSections[] = [
                    'id' => $opt->id,
                    'name' => $opt->name,
                    'param_key' => $paramKey,
                    'input_name' => $inputName,
                    'type' => $opt->type ?? 'radio',
                    'is_checkbox' => $isCheckbox,
                    'has_checked' => $hasChecked,
                    'options' => $sectionOptions,
                    'sort_order' => $opt->sort_order,
                ];
            }
        }

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest' || $request->input('ajax') == '1') {
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

    public function filter(Request $request)
    {
        // 1. Dynamic Options from DB
        $dbOptions = \App\Models\FilterOption::with(['optionValues' => function ($q) {
            $q->where('status', 1)->orderBy('sort_order');
        }])
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        $getOptListWithIcons = function ($optName, $iconMap = [], $defaultIcon = 'bi-check-circle', $valueKeySuffix = '') use ($dbOptions) {
            $found = $dbOptions->first(function ($item) use ($optName) {
                return strcasecmp($item->name, $optName) === 0 || stripos($item->name, $optName) !== false;
            });
            $options = [];
            if ($found && $found->optionValues && $found->optionValues->count() > 0) {
                foreach ($found->optionValues as $ov) {
                    if (strtolower($ov->name) === 'any') continue;
                    $val = \Illuminate\Support\Str::slug($ov->name, '_');
                    $options[] = [
                        'label' => $ov->name . $valueKeySuffix,
                        'icon'  => $iconMap[$ov->name] ?? ($iconMap[$val] ?? $defaultIcon),
                        'val'   => $val,
                    ];
                }
            }
            $options[] = ['label' => 'Any', 'icon' => 'bi-grid', 'val' => 'any'];
            return $options;
        };

        // 1. Dynamic Options from DB, Cached for 24 hours (86400 seconds)
        $stepsData = \Illuminate\Support\Facades\Cache::remember('filter_steps_data_v9', 86400, function () {
            $data = [];
            $stepNum = 1;

            // 1. STEP 1: Categories (First filter section, matching catalog filter)
            $filterCategories = \App\Models\ProductCategory::active()
                ->where('show_in_filter', 1)
                ->orderBy('sort_order')
                ->get();

            if ($filterCategories->count() > 0) {
                $options = [];
                foreach ($filterCategories as $cat) {
                    $catSlug = $cat->slug ?: \Illuminate\Support\Str::slug($cat->category_name, '_');
                    $catNameLower = strtolower($cat->category_name);

                    $icon = 'bi-grid';
                    if (str_contains($catNameLower, 'solution')) $icon = 'bi-box-seam';
                    elseif (str_contains($catNameLower, 'industry')) $icon = 'bi-building';
                    elseif (str_contains($catNameLower, 'tech')) $icon = 'bi-cpu';
                    elseif (str_contains($catNameLower, 'commercial')) $icon = 'bi-buildings';
                    elseif (str_contains($catNameLower, 'residential')) $icon = 'bi-house';

                    $options[] = [
                        'label' => $cat->category_name,
                        'icon'  => $icon,
                        'val'   => $catSlug,
                    ];
                }
                $options[] = ['label' => 'Any', 'icon' => 'bi-grid', 'val' => 'any'];

                $data[] = [
                    'stepNum'     => $stepNum,
                    'stepId'      => 'category',
                    'type'        => 'radio',
                    'stepType'    => 'radio',
                    'stepName'    => $stepNum . '. CATEGORIES',
                    'stepTitle'   => 'Select Category',
                    'stepTag'     => 'CATEGORY SELECTION',
                    'options'     => $options,
                ];
                $stepNum++;
            }

            // 2. Dynamic Filter Options from DB (Ordered by sort_order)
            $dbOptions = \App\Models\FilterOption::with(['optionValues' => function ($q) {
                $q->where('status', 1)->orderBy('sort_order');
            }])
                ->where('status', 1)
                ->where('show_in_filter', 1)
                ->whereNotIn('name', ['Color', 'Size', 'Material'])
                ->orderBy('sort_order')
                ->get();

            foreach ($dbOptions as $opt) {
                $options = [];
                $defaultIcon = $opt->icon ?: 'bi-check-circle';

                // Fallback default icons if $opt->icon is null based on the category name
                if (!$opt->icon) {
                    $optNameLower = strtolower($opt->name);
                    if (str_contains($optNameLower, 'industry')) $defaultIcon = 'bi-building';
                    elseif (str_contains($optNameLower, 'building')) $defaultIcon = 'bi-building';
                    elseif (str_contains($optNameLower, 'room') || str_contains($optNameLower, 'area type')) $defaultIcon = 'bi-door-closed';
                    elseif (str_contains($optNameLower, 'area range')) $defaultIcon = 'bi-aspect-ratio';
                    elseif (str_contains($optNameLower, 'occupancy')) $defaultIcon = 'bi-people';
                    elseif (str_contains($optNameLower, 'health')) $defaultIcon = 'bi-shield-check';
                    elseif (str_contains($optNameLower, 'problem')) $defaultIcon = 'bi-exclamation-triangle';
                    elseif (str_contains($optNameLower, 'solution')) $defaultIcon = 'bi-box-seam';
                    elseif (str_contains($optNameLower, 'budget')) $defaultIcon = 'bi-cash-stack';
                }

                if ($opt->optionValues && $opt->optionValues->count() > 0) {
                    foreach ($opt->optionValues as $ov) {
                        if (strtolower($ov->name) === 'any') continue;

                        $valSlug = \Illuminate\Support\Str::slug($ov->name, '_');
                        $label = $ov->name;
                        $optNameLower = strtolower($opt->name);

                        // Add suffixes based on option type only if not already present
                        if (str_contains($optNameLower, 'area range') && !str_contains(strtolower($ov->name), 'm²') && !str_contains(strtolower($ov->name), 'm2') && !str_contains(strtolower($ov->name), 'sq')) {
                            $label .= ' m²';
                        }
                        if (str_contains($optNameLower, 'occupancy') && !str_contains(strtolower($ov->name), 'person')) {
                            $label .= ($ov->name === '1' ? ' Person' : ' Persons');
                        }

                        // Use specific option value icon, or fallback to the default icon
                        $icon = $ov->icon ?: $defaultIcon;

                        $options[] = [
                            'label' => $label,
                            'icon'  => $icon,
                            'val'   => $valSlug,
                        ];
                    }
                }
                $options[] = ['label' => 'Any', 'icon' => 'bi-grid', 'val' => 'any'];

                $data[] = [
                    'stepNum'     => $stepNum,
                    'stepId'      => \Illuminate\Support\Str::slug($opt->name, '_'),
                    'type'        => $opt->type ?: 'radio',
                    'stepType'    => $opt->type ?: 'radio',
                    'stepName'    => $stepNum . '. ' . strtoupper($opt->name),
                    'stepTitle'   => 'Select ' . $opt->name,
                    'stepTag'     => strtoupper($opt->name),
                    'options'     => $options,
                ];

                $stepNum++;
            }

            // Finally, populate stepCount and progressPct dynamically for all items
            $totalSteps = count($data);
            if ($totalSteps === 0) $totalSteps = 1;
            foreach ($data as $index => $stepItem) {
                $num = $stepItem['stepNum'];
                $data[$index]['stepCount'] = 'STEP ' . $num . ' / ' . $totalSteps;
                $data[$index]['progressPct'] = round(($num / $totalSteps) * 100);
            }

            return $data;
        });

        $totalProductsCount = \App\Models\Product::where('status', 1)->count();
        $featuredSolution = \App\Models\Product::where('status', 1)->where('featured', 1)->with(['categories'])->first();

        $adSliders = \App\Models\Slider::where('enabled', 1)
            ->where(function ($q) {
                $q->where('key', 'filter')
                    ->orWhere('key', 'like', '%filter%')
                    ->orWhere('key', 'category_sidebar')
                    ->orWhere('key', 'like', '%category_sidebar%');
            })
            ->orderBy('order', 'asc')
            ->get();

        return \theme_view('products.filter-step', compact('stepsData', 'totalProductsCount', 'featuredSolution', 'adSliders'));
    }

    public function filterStepApi(Request $request)
    {
        $categorySlugs = (array) $request->input('category_slugs', []);

        $category = $request->input('category') ?: ($request->input('industry') ?: ($categorySlugs[0] ?? null));
        $buildingType = $request->input('building_type') ?: ($request->input('building') ?: ($categorySlugs[1] ?? null));
        $roomType = $request->input('room_type') ?: ($request->input('room') ?: ($categorySlugs[2] ?? null));
        $areaRange = $request->input('area_range') ?: ($request->input('coverage') ?: ($categorySlugs[3] ?? null));
        $occupancy = $request->input('occupancy') ?: ($categorySlugs[4] ?? null);
        $healthConcerns = (array) ($request->input('health_concern') ?: ($request->input('health') ?: ($categorySlugs[5] ?? [])));
        $problems = (array) ($request->input('problem') ?: ($categorySlugs[6] ?? []));
        $solutionsNeeded = (array) ($request->input('solution_needed') ?: ($request->input('solution') ?: ($categorySlugs[7] ?? [])));
        $budget = $request->input('budget') ?: ($categorySlugs[8] ?? null);

        $query = \App\Models\Product::where('status', 1)
            ->with(['categories', 'images', 'brand', 'productAttributes', 'description']);

        $allDbOptionValues = \App\Models\FilterOptionValue::with('filterOption:id,name')->get();
        $resolveOptionValueIds = function ($reqValues, $optionNameKeyword = null) use ($allDbOptionValues) {
            $reqList = array_map('strval', (array)$reqValues);
            return $allDbOptionValues->filter(function ($ov) use ($reqList, $optionNameKeyword) {
                if ($optionNameKeyword) {
                    $opt = $ov->filterOption;
                    if ($opt && stripos($opt->name, $optionNameKeyword) === false) {
                        return false;
                    }
                }
                $slug = \Illuminate\Support\Str::slug($ov->name, '_');
                return in_array($slug, $reqList, true)
                    || in_array((string)$ov->id, $reqList, true)
                    || in_array(strtolower($ov->name), array_map('strtolower', $reqList), true);
            })->pluck('id')->toArray();
        };

        $parseBudget = function ($raw) {
            if (empty($raw) || $raw === 'any' || $raw === 'all') return null;
            $str = strtolower(trim((string)$raw));
            $clean = str_replace([',', ' ', '$', '€', '£'], '', $str);
            if (preg_match('/(?:under|less_than|below|up_to|<|max_?)_?(\d+)/', $clean, $m)) {
                return ['min' => 0, 'max' => (float)$m[1]];
            }
            if (preg_match('/(?:over|above|more_than|greater_than|>|min_?)_?(\d+)/', $clean, $m) || preg_match('/(\d+)\+/', $clean, $m)) {
                return ['min' => (float)$m[1], 'max' => null];
            }
            if (preg_match('/(\d+)(?:-|–|_to_|to|_)(\d+)/', $clean, $m)) {
                return ['min' => (float)$m[1], 'max' => (float)$m[2]];
            }
            if ($str === 'entry' || $str === '0-500') return ['min' => 0, 'max' => 500];
            if ($str === 'medium' || $str === '500-1000') return ['min' => 500, 'max' => 1000];
            if ($str === 'commercial' || $str === '1000-1500') return ['min' => 1000, 'max' => 1500];
            if ($str === 'premium' || $str === '1500-2000') return ['min' => 1500, 'max' => 2000];
            if ($str === 'industrial' || $str === '2000-3000') return ['min' => 2000, 'max' => 3000];
            if ($str === 'enterprise' || $str === '3000+') return ['min' => 3000, 'max' => null];
            return null;
        };

        // 1. Category Filter
        if (!empty($category) && $category !== 'any' && $category !== 'all') {
            $slugKeyword = str_replace('_', '-', $category);
            $nameKeyword = str_replace(['_', '-'], ' ', $category);

            $targetCategory = \App\Models\ProductCategory::where(function ($cq) use ($category, $slugKeyword, $nameKeyword) {
                $cq->where('slug', $slugKeyword)
                    ->orWhere('slug', $category)
                    ->orWhere('category_name', $nameKeyword)
                    ->orWhere('category_name', $category);
            })->first();

            $catValIds = $resolveOptionValueIds($category, 'Category');

            $query->where(function ($q) use ($targetCategory, $catValIds) {
                if ($targetCategory) {
                    $catIds = [$targetCategory->id];
                    if ($targetCategory->children && $targetCategory->children->count() > 0) {
                        $catIds = array_merge($catIds, $targetCategory->children->pluck('id')->toArray());
                    }
                    $q->whereHas('categories', fn($cq) => $cq->whereIn('product_categories.id', $catIds));
                }
                if (!empty($catValIds)) {
                    $q->orWhereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $catValIds));
                }
            });
        }

        // 2. Building Type Filter
        if (!empty($buildingType) && $buildingType !== 'any' && $buildingType !== 'all') {
            $bValIds = $resolveOptionValueIds($buildingType, 'Building');
            if (!empty($bValIds)) {
                $query->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $bValIds));
            }
        }

        // 3. Room Type Filter
        if (!empty($roomType) && $roomType !== 'any' && $roomType !== 'all') {
            $rValIds = $resolveOptionValueIds($roomType, 'Room');
            if (!empty($rValIds)) {
                $query->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $rValIds));
            }
        }

        // 4. Area Range Filter
        if (!empty($areaRange) && $areaRange !== 'any' && $areaRange !== 'all') {
            $arValIds = $resolveOptionValueIds($areaRange, 'Area');
            if (!empty($arValIds)) {
                $query->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $arValIds));
            }
        }

        // 5. Occupancy Filter
        if (!empty($occupancy) && $occupancy !== 'any' && $occupancy !== 'all') {
            $occValIds = $resolveOptionValueIds($occupancy, 'Occupancy');
            if (!empty($occValIds)) {
                $query->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $occValIds));
            }
        }

        // 6. Health Concern Filter
        $cleanHealth = array_filter($healthConcerns, fn($v) => $v !== 'any' && $v !== 'all' && !empty($v));
        if (!empty($cleanHealth)) {
            $hcValIds = $resolveOptionValueIds($cleanHealth, 'Health');
            if (!empty($hcValIds)) {
                $query->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $hcValIds));
            }
        }

        // 7. Problem Filter
        $cleanProblems = array_filter($problems, fn($v) => $v !== 'any' && $v !== 'all' && !empty($v));
        if (!empty($cleanProblems)) {
            $pValIds = $resolveOptionValueIds($cleanProblems, 'Problem');
            if (!empty($pValIds)) {
                $query->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $pValIds));
            }
        }

        // 8. Solution Filter
        $cleanSolutions = array_filter($solutionsNeeded, fn($v) => $v !== 'any' && $v !== 'all' && !empty($v));
        if (!empty($cleanSolutions)) {
            $sValIds = $resolveOptionValueIds($cleanSolutions, 'Solution');
            if (!empty($sValIds)) {
                $query->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $sValIds));
            }
        }

        // 9. Budget Filter
        if ($budget && $budget !== 'any' && $budget !== 'all') {
            $parsedBudget = $parseBudget($budget);
            if ($parsedBudget) {
                if ($parsedBudget['max'] === null) {
                    $query->where('price', '>=', $parsedBudget['min']);
                } elseif ($parsedBudget['min'] <= 0) {
                    $query->where('price', '<=', $parsedBudget['max']);
                } else {
                    $query->whereBetween('price', [$parsedBudget['min'], $parsedBudget['max']]);
                }
            }
        }

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

        $formatProduct = function ($p) {
            $firstCategory = $p->categories->first();
            $subCategory = $p->categories->skip(1)->first();
            $categoryName = $firstCategory?->category_name;
            $categoryBgColor = $firstCategory?->bg_color ?: '#00c853';
            $subtitle = $p->description?->tag ?: ($subCategory?->category_name ?: ($firstCategory?->alt_name ?: 'ENTERPRISE FILTRATION'));

            $cadr = $p->productAttributes->first(fn($a) => stripos($a->name, 'CADR') !== false)?->details ?? '550 m³/h';
            $grade = $p->productAttributes->first(fn($a) => stripos($a->name, 'Grade') !== false || stripos($a->name, 'Filter') !== false)?->details ?? 'HEPA H13';
            $desc = function_exists('getLimitedText') ? \getLimitedText(strip_tags($p->description?->description ?? ''), 140) : '';

            return [
                'id'                => $p->id,
                'name'              => $p->name,
                'model'             => $p->model ?? '',
                'brand'             => $p->brand->name ?? 'AIRE',
                'price'             => number_format((float) ($p->price ?? 0), 2),
                'raw_price'         => (float) ($p->price ?? 0),
                'main_image'        => function_exists('getImageUrl') ? getImageUrl($p->main_image) : ($p->main_image ?? ''),
                'slug'              => $p->slug ?: $p->id,
                'url'               => route('products.detail', $p->slug ?: $p->id),
                'category'          => $categoryName ?? 'Air Purifier',
                'category_bg_color' => $categoryBgColor,
                'subtitle'          => strtoupper($subtitle),
                'description'       => $desc,
                'cadr'              => $cadr,
                'filter_grade'      => $grade,
                'quantity'          => (int) ($p->quantity ?? 0),
            ];
        };

        $bestProductData = $bestProduct ? $formatProduct($bestProduct) : null;
        $otherProductsData = $otherMatchedProducts->map(function ($item) use ($formatProduct) {
            return $formatProduct($item);
        })->values()->all();

        // Compute available options for progressive cascading steps
        $matchingProductIds = $matchedProducts->pluck('id')->toArray();
        $availableOptions = [];

        if (!empty($matchingProductIds)) {
            $validOptValueIds = \Illuminate\Support\Facades\DB::table('product_filter_options')
                ->whereIn('product_id', $matchingProductIds)
                ->pluck('filter_option_value_id')
                ->unique()
                ->toArray();

            foreach ($allDbOptionValues as $ov) {
                if (in_array((int)$ov->id, $validOptValueIds, true) && $ov->filterOption) {
                    $optSlug = \Illuminate\Support\Str::slug($ov->filterOption->name, '_');
                    $valSlug = \Illuminate\Support\Str::slug($ov->name, '_');
                    $availableOptions[$optSlug][] = $valSlug;
                }
            }

            // Budget options
            $matchingPrices = \Illuminate\Support\Facades\DB::table('products')
                ->whereIn('id', $matchingProductIds)
                ->pluck('price')
                ->map(fn($p) => (float)$p)
                ->toArray();

            $budgetOpt = \App\Models\FilterOption::with('optionValues')->where('status', 1)->where('name', 'like', '%budget%')->first();
            if ($budgetOpt) {
                $bSlug = \Illuminate\Support\Str::slug($budgetOpt->name, '_');
                foreach ($budgetOpt->optionValues as $bVal) {
                    if (strtolower($bVal->name) === 'any') continue;
                    $bValSlug = \Illuminate\Support\Str::slug($bVal->name, '_') ?: $bVal->name;
                    $parsedRange = $parseBudget($bValSlug) ?: $parseBudget($bVal->name);
                    if ($parsedRange) {
                        foreach ($matchingPrices as $pPrice) {
                            if ($parsedRange['max'] === null && $pPrice >= $parsedRange['min']) {
                                $availableOptions[$bSlug][] = $bValSlug;
                                break;
                            } elseif ($parsedRange['min'] <= 0 && $pPrice <= $parsedRange['max']) {
                                $availableOptions[$bSlug][] = $bValSlug;
                                break;
                            } elseif ($pPrice >= $parsedRange['min'] && $pPrice <= $parsedRange['max']) {
                                $availableOptions[$bSlug][] = $bValSlug;
                                break;
                            }
                        }
                    }
                }
            }
        }

        // Build combined array (all searched matching products)
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
        $products = Product::whereIn('id', $favoriteIds)->where('status', 1)->get();

        $adSliders = \App\Models\Slider::where('enabled', 1)
            ->where(function ($q) {
                $q->where('key', 'favorite')->orWhere('key', 'like', '%favorite%');
            })
            ->orderBy('order', 'asc')
            ->get();

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

        return response()->json([
            'success' => true,
            'message' => 'Comparison list cleared!',
            'count'   => 0,
            'compare_count' => 0
        ]);
    }
}
