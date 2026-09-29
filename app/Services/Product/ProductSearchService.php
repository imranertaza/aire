<?php

namespace App\Services\Product;

use App\Models\FilterOptionValue;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Cache;

class ProductSearchService
{
    /**
     * Retrieve list of products, categories, and matching tags for live dropdown search with caching.
     */
    public function searchDropdown(string $search = '', ?int $categoryId = null, int $limit = 8): array
    {
        $search = trim($search);
        $cacheKey = 'search_dd_' . md5(json_encode([$search, $categoryId, $limit]));

        return Cache::remember($cacheKey, 300, function () use ($search, $categoryId, $limit) {
            $query = Product::where('status', 1)
                ->with(['categories', 'description', 'brand', 'productFilterOptions.filterOptionValue', 'applications']);

            if ($categoryId) {
                $query->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('product_categories.id', $categoryId);
                });
            }

            if (!empty($search)) {
                $cleanSearch = trim(preg_replace('/[+\-><\(\)~*\"@]+/', ' ', $search));

                $isSqlite = \Illuminate\Support\Facades\DB::getDriverName() === 'sqlite';

                if (!$isSqlite && mb_strlen($cleanSearch) >= 3) {
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
                    // Fast prefix/substring matching for SQLite or short queries
                    $query->where(function ($q) use ($cleanSearch) {
                        $q->where('name', 'LIKE', "%{$cleanSearch}%")
                            ->orWhere('model', 'LIKE', "%{$cleanSearch}%")
                            ->orWhere('product_code', 'LIKE', "%{$cleanSearch}%")
                            ->orWhereHas('categories', function ($cq) use ($cleanSearch) {
                                $cq->where('category_name', 'LIKE', "%{$cleanSearch}%");
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
                $categories = ProductCategory::active()
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
                $matchingTags = FilterOptionValue::with('filterOption:id,name')
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
    }
}
