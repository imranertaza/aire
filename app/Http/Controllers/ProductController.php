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

class ProductController extends Controller
{
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
        $product = Product::where('slug', $slug)
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
                'relatedProducts.categories',
                'relatedProducts.images',
            ])->firstOrFail();

        $relatedProducts = $product->relatedProducts;
        if ($relatedProducts->isEmpty()) {
            $catId = $product->categories->first()?->id;
            $relatedQuery = Product::where('status', 1)->where('id', '!=', $product->id)->with(['categories', 'images']);
            if ($catId) {
                $relatedQuery->whereHas('categories', function ($q) use ($catId) {
                    $q->where('product_categories.id', $catId);
                });
            }
            $relatedProducts = $relatedQuery->take(6)->get();
            if ($relatedProducts->isEmpty()) {
                $relatedProducts = Product::where('status', 1)->where('id', '!=', $product->id)->with(['categories', 'images'])->take(6)->get();
            }
        }

        return \theme_view('products.show', compact('product', 'relatedProducts'));
    }


    /**
     * Retrieve list of products and categories for live dropdown search.
     */
    public function dropdownList(Request $request)
    {
        $search = trim($request->query('search', ''));
        $categoryId = $request->query('category_id');

        $query = Product::where('status', 1)->with(['categories', 'description', 'brand']);

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('product_categories.id', $categoryId);
            });
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('model', 'LIKE', "%{$search}%")
                    ->orWhere('product_code', 'LIKE', "%{$search}%")
                    ->orWhereHas('categories', function ($cq) use ($search) {
                        $cq->where('category_name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('description', function ($dq) use ($search) {
                        $dq->where('tag', 'LIKE', "%{$search}%")
                            ->orWhere('meta_title', 'LIKE', "%{$search}%");
                    });
            });
        }

        $limit = (int) $request->query('limit', 8);
        $products = $query->latest('id')->take($limit)->get()->map(function ($p) {
            $firstCategory = $p->categories->first();
            return [
                'id'          => $p->id,
                'name'        => $p->name,
                'slug'        => $p->slug,
                'model'       => $p->model ?? '',
                'price'       => number_format((float) $p->price, 2),
                'raw_price'   => (float) $p->price,
                'image'       => $p->main_image ? getImageUrl($p->main_image) : asset('themes/default/assets/img/Air-Purify.png'),
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

        return response()->json([
            'status'     => true,
            'data'       => $products,
            'products'   => $products,
            'categories' => $categories,
            'total'      => $products->count(),
        ]);
    }

    /**
     * Display product filter page.
     */
    public function productFilter(Request $request, $slug_or_id = null)
    {
        $catParam = $slug_or_id ?: $request->input('category_id');
        $search = trim($request->input('search', ''));
        $industry = $request->input('industry');

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

        $query = Product::with(['categories', 'productAttributes', 'description'])->where('status', 1);

        if ($currentCategory) {
            $catIds = [$currentCategory->id];
            if ($currentCategory->children && $currentCategory->children->count() > 0) {
                $catIds = array_merge($catIds, $currentCategory->children->pluck('id')->toArray());
            }
            $query->whereHas('categories', function ($q) use ($catIds) {
                $q->whereIn('product_categories.id', $catIds);
            });
        }

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

        if (!empty($industry)) {
            $query->where(function ($q) use ($industry) {
                $q->whereHas('categories', function ($cq) use ($industry) {
                    $cq->where('category_name', 'like', "%{$industry}%")
                        ->orWhere('slug', 'like', "%{$industry}%");
                })->orWhereHas('description', function ($dq) use ($industry) {
                    $dq->where('tag', 'like', "%{$industry}%");
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

        return \theme_view('products.filter', compact(
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
     * Display product landing page.
     */

    public function productLanding(Request $request)
    {
        return \theme_view('products.landing');
    }

    /**
     * Display step-by-step filter wizard page.
     */

    public function filter(Request $request)
    {
        // 1. Fetch Industries categories for Step 1
        $industriesCat = \App\Models\ProductCategory::active()
            ->where('slug', 'industries')
            ->with(['children' => function ($q) {
                $q->active();
            }])->first();

        $industryOptions = [];
        if ($industriesCat && $industriesCat->children) {
            foreach ($industriesCat->children as $child) {
                $industryOptions[] = [
                    'label' => $child->category_name,
                    'icon'  => $child->icon_class ?: 'bi-building',
                    'val'   => $child->slug,
                    'id'    => $child->id,
                ];
            }
        } else {
            $industryOptions = [
                ['label' => 'Residential', 'icon' => 'bi-house', 'val' => 'residential-solutions'],
                ['label' => 'Commercial', 'icon' => 'bi-building', 'val' => 'commercial-solutions'],
                ['label' => 'Healthcare', 'icon' => 'bi-hospital', 'val' => 'healthcare-solutions'],
                ['label' => 'Education', 'icon' => 'bi-mortarboard', 'val' => 'education-solutions'],
                ['label' => 'Transportation', 'icon' => 'bi-train-front', 'val' => 'transportation-solutions'],
                ['label' => 'Industrial', 'icon' => 'bi-cone-striped', 'val' => 'industrial-solutions'],
            ];
        }

        // 2. Fetch Solutions categories for Step 3
        $solutionsCat = \App\Models\ProductCategory::active()
            ->where('slug', 'solutions')
            ->with(['children' => function ($q) {
                $q->active();
            }])->first();

        $solutionOptions = [];
        if ($solutionsCat && $solutionsCat->children) {
            foreach ($solutionsCat->children as $child) {
                $solutionOptions[] = [
                    'label' => $child->category_name,
                    'icon'  => $child->icon_class ?: 'bi-shield-check',
                    'val'   => $child->slug,
                    'id'    => $child->id,
                ];
            }
        }

        // 3. Fetch Products categories for Step 4
        $productsCat = \App\Models\ProductCategory::active()
            ->where('slug', 'products')
            ->with(['children' => function ($q) {
                $q->active();
            }])->first();

        $productTypeOptions = [];
        if ($productsCat && $productsCat->children) {
            foreach ($productsCat->children as $child) {
                $productTypeOptions[] = [
                    'label' => $child->category_name,
                    'icon'  => $child->icon_class ?: 'bi-box-seam',
                    'val'   => $child->slug,
                    'id'    => $child->id,
                ];
            }
        }

        $stepsData = [
            [
                'stepNum'     => 1,
                'stepId'      => 'industry',
                'stepName'    => 'INDUSTRY',
                'stepTitle'   => 'Select Sector / Industry',
                'stepTag'     => 'PROTOCOL INIT',
                'stepCount'   => 'STEP 1 / 9',
                'progressPct' => 11,
                'options'     => $industryOptions,
            ],
            [
                'stepNum'     => 2,
                'stepId'      => 'building',
                'stepName'    => 'BUILDING TYPE',
                'stepTitle'   => 'Building / Facility Type',
                'stepTag'     => 'FACILITY TYPE',
                'stepCount'   => 'STEP 2 / 9',
                'progressPct' => 22,
                'options'     => [
                    ['label' => 'Apartments', 'icon' => 'bi-building', 'val' => 'apartments'],
                    ['label' => 'Villas & Homes', 'icon' => 'bi-house-heart', 'val' => 'villas'],
                    ['label' => 'Offices', 'icon' => 'bi-laptop', 'val' => 'offices'],
                    ['label' => 'Retail Centers', 'icon' => 'bi-shop', 'val' => 'retail-centers'],
                    ['label' => 'Hospitals & Clinics', 'icon' => 'bi-hospital', 'val' => 'hospitals'],
                    ['label' => 'Schools & Universities', 'icon' => 'bi-book', 'val' => 'schools'],
                ],
            ],
            [
                'stepNum'     => 3,
                'stepId'      => 'solution',
                'stepName'    => 'PRIMARY OBJECTIVE',
                'stepTitle'   => 'Air Quality Solution Needed',
                'stepTag'     => 'SOLUTION GOAL',
                'stepCount'   => 'STEP 3 / 9',
                'progressPct' => 33,
                'options'     => $solutionOptions,
            ],
            [
                'stepNum'     => 4,
                'stepId'      => 'product_type',
                'stepName'    => 'SYSTEM TYPE',
                'stepTitle'   => 'Product System Category',
                'stepTag'     => 'SYSTEM CATEGORY',
                'stepCount'   => 'STEP 4 / 9',
                'progressPct' => 44,
                'options'     => $productTypeOptions,
            ],
            [
                'stepNum'     => 5,
                'stepId'      => 'area_size',
                'stepName'    => 'COVERAGE AREA',
                'stepTitle'   => 'Required Room / Coverage Area',
                'stepTag'     => 'COVERAGE SIZE',
                'stepCount'   => 'STEP 5 / 9',
                'progressPct' => 55,
                'options'     => [
                    ['label' => 'Small (< 300 sq.ft)', 'icon' => 'bi-aspect-ratio', 'val' => 'small'],
                    ['label' => 'Medium (300-600 sq.ft)', 'icon' => 'bi-bounding-box-circles', 'val' => 'medium'],
                    ['label' => 'Large (600-1200 sq.ft)', 'icon' => 'bi-arrows-angle-expand', 'val' => 'large'],
                    ['label' => 'Whole Floor (1200-3000 sq.ft)', 'icon' => 'bi-grid-3x3', 'val' => 'floor'],
                    ['label' => 'Commercial Facility (> 3000 sq.ft)', 'icon' => 'bi-building-up', 'val' => 'facility'],
                ],
            ],
            [
                'stepNum'     => 6,
                'stepId'      => 'filtration',
                'stepName'    => 'FILTRATION GRADE',
                'stepTitle'   => 'Required Air Filtration Standard',
                'stepTag'     => 'FILTRATION GRADE',
                'stepCount'   => 'STEP 6 / 9',
                'progressPct' => 66,
                'options'     => [
                    ['label' => 'True HEPA H13 (99.97%)', 'icon' => 'bi-funnel-fill', 'val' => 'hepa-h13'],
                    ['label' => 'Medical HEPA H14 (99.995%)', 'icon' => 'bi-shield-plus', 'val' => 'hepa-h14'],
                    ['label' => 'Activated Carbon Bed', 'icon' => 'bi-fire', 'val' => 'carbon'],
                    ['label' => 'UV-C Pathogen Sterilization', 'icon' => 'bi-brightness-high', 'val' => 'uvc'],
                ],
            ],
            [
                'stepNum'     => 7,
                'stepId'      => 'control_mode',
                'stepName'    => 'CONTROL SYSTEM',
                'stepTitle'   => 'Control & Automation Mode',
                'stepTag'     => 'SMART CONTROLS',
                'stepCount'   => 'STEP 7 / 9',
                'progressPct' => 77,
                'options'     => [
                    ['label' => 'AIRE Mobile App (Wi-Fi/IoT)', 'icon' => 'bi-phone', 'val' => 'app'],
                    ['label' => 'AI Smart Sensor Mode', 'icon' => 'bi-cpu', 'val' => 'auto-ai'],
                    ['label' => 'BACnet / BMS Building Integration', 'icon' => 'bi-diagram-3', 'val' => 'bms'],
                    ['label' => 'Manual On-Device Touch Control', 'icon' => 'bi-sliders', 'val' => 'manual'],
                ],
            ],
            [
                'stepNum'     => 8,
                'stepId'      => 'installation',
                'stepName'    => 'INSTALLATION',
                'stepTitle'   => 'Installation Form Factor',
                'stepTag'     => 'FORM FACTOR',
                'stepCount'   => 'STEP 8 / 9',
                'progressPct' => 88,
                'options'     => [
                    ['label' => 'Portable / Freestanding Tower', 'icon' => 'bi-box-seam', 'val' => 'freestanding'],
                    ['label' => 'Ceiling ERV / Duct System', 'icon' => 'bi-wind', 'val' => 'ceiling-duct'],
                    ['label' => 'Wall Mounted Unit', 'icon' => 'bi-layout-sidebar', 'val' => 'wall-mount'],
                    ['label' => 'Desktop / Personal Purifier', 'icon' => 'bi-display', 'val' => 'desktop'],
                ],
            ],
            [
                'stepNum'     => 9,
                'stepId'      => 'priority',
                'stepName'    => 'PRIORITY GOAL',
                'stepTitle'   => 'Primary Operational Priority',
                'stepTag'     => 'FINAL PROTOCOL',
                'stepCount'   => 'STEP 9 / 9',
                'progressPct' => 100,
                'options'     => [
                    ['label' => 'Maximum PM2.5 & Smog Removal', 'icon' => 'bi-snow', 'val' => 'pm25-max'],
                    ['label' => 'Ultra-Quiet Night Mode (<25dB)', 'icon' => 'bi-moon-stars', 'val' => 'quiet'],
                    ['label' => 'Energy Saving (EC Motor)', 'icon' => 'bi-lightning-charge', 'val' => 'energy'],
                    ['label' => 'Pathogen & Infection Control', 'icon' => 'bi-shield-virus', 'val' => 'infection'],
                ],
            ],
        ];

        // Total products count
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
        $selectedCatSlugs = array_filter((array)$request->input('category_slugs', []));

        $query = \App\Models\Product::where('status', 1)
            ->with(['categories', 'images', 'brand', 'productAttributes', 'description']);

        if (!empty($selectedCatSlugs)) {
            $query->whereHas('categories', function ($q) use ($selectedCatSlugs) {
                $q->whereIn('slug', $selectedCatSlugs);
            });
        }

        $page = (int)$request->input('page', 1);
        $perPage = (int)$request->input('per_page', 20);
        $paginated = $query->orderBy('sort_order', 'asc')->paginate($perPage, ['*'], 'page', $page);

        $paginated->getCollection()->transform(function ($p) {
            $firstCategory = $p->categories->first();
            $subCategory = $p->categories->skip(1)->first();
            $categoryName = $firstCategory?->category_name;
            $categoryBgColor = $firstCategory?->bg_color ?: '#00c853';
            $subtitle = $p->description?->tag ?: ($subCategory?->category_name ?: ($firstCategory?->alt_name ?: 'ENTERPRISE FILTRATION'));

            $cadr = $p->productAttributes->first(fn($a) => stripos($a->name, 'CADR') !== false)?->details ?? '550 m³/h';
            $grade = $p->productAttributes->first(fn($a) => stripos($a->name, 'Grade') !== false || stripos($a->name, 'Filter') !== false)?->details ?? 'HEPA H13';

            return [
                'id'                => $p->id,
                'name'              => $p->name,
                'model'             => $p->model ?? '',
                'brand'             => $p->brand->name ?? 'AIRE',
                'price'             => number_format($p->price, 2),
                'raw_price'         => (float)$p->price,
                'main_image'        => getImageUrl($p->main_image),
                'slug'              => $p->slug,
                'url'               => route('products.detail', $p->slug ?: $p->id),
                'category'          => $categoryName ?? 'Air Purifier',
                'category_bg_color' => $categoryBgColor,
                'subtitle'          => strtoupper($subtitle),
                'cadr'              => $cadr,
                'filter_grade'      => $grade,
                'quantity'          => $p->quantity,
            ];
        });

        return response()->json([
            'status'       => true,
            'count'        => $paginated->total(),
            'total'        => $paginated->total(),
            'current_page' => $paginated->currentPage(),
            'last_page'    => $paginated->lastPage(),
            'per_page'     => $paginated->perPage(),
            'products'     => $paginated->items(),
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
