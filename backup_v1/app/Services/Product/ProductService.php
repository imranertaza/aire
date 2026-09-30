<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    /**
     * Retrieve hierarchical categories tree with caching.
     */
    public function getCategoryTree(): Collection
    {
        return Cache::remember('catalog_categories_tree_v1', 3600, function () {
            return ProductCategory::active()
                ->where(function ($q) {
                    $q->whereNull('parent_id')->orWhere('parent_id', 0);
                })
                ->with([
                    'icon',
                    'children' => fn($q) => $q->active(),
                    'children.children' => fn($q) => $q->active(),
                    'featuredTopProducts.images',
                    'featuredBottomProducts.images',
                ])
                ->get();
        });
    }

    /**
     * Retrieve single category with its subtrees by slug.
     */
    public function getCategoryBySlug(string $slug): ?ProductCategory
    {
        return Cache::remember("catalog_category_slug_{$slug}", 3600, function () use ($slug) {
            return ProductCategory::active()
                ->where('slug', $slug)
                ->orWhere('category_name', 'like', str_replace('-', ' ', $slug))
                ->with([
                    'icon',
                    'children' => fn($q) => $q->active(),
                    'children.children' => fn($q) => $q->active(),
                    'featuredTopProducts.images',
                    'featuredBottomProducts.images',
                ])
                ->first();
        });
    }

    /**
     * Retrieve product details and related products with caching.
     */
    public function getProductDetail(string $slug): ?array
    {
        $product = Cache::remember("product_detail_{$slug}", 3600, function () use ($slug) {
            return Product::where('status', 1)
                ->where(function ($q) use ($slug) {
                    $q->where('slug', $slug)
                        ->orWhere('id', is_numeric($slug) ? (int) $slug : 0);
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
                    'freeDelivery',
                    'relatedProducts.categories',
                    'relatedProducts.images',
                    'relatedProducts.special',
                    'relatedProducts.freeDelivery',
                ])
                ->first();
        });

        if (!$product) {
            return null;
        }

        $relatedProducts = Cache::remember("product_related_{$product->id}", 3600, function () use ($product) {
            $related = $product->relatedProducts;

            if ($related->isEmpty()) {
                $catId = $product->categories->first()?->id;
                $query = Product::where('status', 1)
                    ->where('id', '!=', $product->id)
                    ->with(['categories', 'images', 'special']);

                if ($catId) {
                    $query->whereHas('categories', fn($q) => $q->where('product_categories.id', $catId));
                }

                $related = $query->take(6)->get();

                if ($related->isEmpty()) {
                    $related = Product::where('status', 1)
                        ->where('id', '!=', $product->id)
                        ->with(['categories', 'images', 'special'])
                        ->take(6)
                        ->get();
                }
            }

            return $related;
        });

        return [
            'product'         => $product,
            'relatedProducts' => $relatedProducts,
        ];
    }

    /**
     * Retrieve landing page data for a given product.
     */
    public function getProductLanding(string $slug): ?array
    {
        return Cache::remember("product_landing_{$slug}", 3600, function () use ($slug) {
            $product = Product::where('status', 1)
                ->where(function ($q) use ($slug) {
                    $q->where('slug', $slug)
                        ->orWhere('id', is_numeric($slug) ? (int) $slug : 0);
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
                ])
                ->first();

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
    }

    /**
     * Retrieve active promotional sliders for specified key.
     */
    public function getSliders(string $key): Collection
    {
        return Cache::remember("sliders_{$key}", 3600, function () use ($key) {
            return Slider::where('enabled', 1)
                ->where(function ($q) use ($key) {
                    $q->where('key', $key)
                        ->orWhere('key', 'like', "%{$key}%");
                })
                ->orderBy('order', 'asc')
                ->get();
        });
    }
}
