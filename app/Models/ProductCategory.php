<?php

namespace App\Models;

use App\Models\Concerns\InvalidatesDashboardCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use InvalidatesDashboardCache;

    protected $guarded = ['id'];

    protected $casts = [
        'features' => 'array',
    ];

    protected static function booted()
    {
        static::saving(function ($category) {
            if (empty($category->slug) && !empty($category->category_name)) {
                $category->slug = Str::slug($category->category_name);
            }
        });

        static::saved(function ($category) {
            static::clearCategoryCache($category);
        });

        static::deleted(function ($category) {
            static::clearCategoryCache($category);
        });
    }

    /**
     * Clear all category-related caches including trees and single category slugs.
     */
    public static function clearCategoryCache(?ProductCategory $category = null): void
    {
        Cache::forget('all_categories');
        Cache::forget('catalog_parent_categories_tree');
        Cache::forget('catalog_categories_tree_v4');
        Cache::forget('catalog_category_pairs_v1');
        Cache::forget('filter_active_categories');
        Cache::forget('filter_steps_data_v9');
        Cache::forget('catalog_category_slug_v4_products');
        Cache::forget('layout_main_header_menu_v2');
        Cache::forget('layout_header_megamenu_categories_v2');

        if ($category) {
            $slugsToClear = collect(['products']);

            $curr = $category;
            while ($curr) {
                if (!empty($curr->slug)) {
                    $slugsToClear->push($curr->slug);
                }
                if ($curr->isDirty('slug') && $curr->getOriginal('slug')) {
                    $slugsToClear->push($curr->getOriginal('slug'));
                }
                if (!empty($curr->id)) {
                    $slugsToClear->push((string) $curr->id);
                }
                $curr = $curr->parent ?? ($curr->parent_id ? static::find($curr->parent_id) : null);
            }

            // Also invalidate children if category has children
            try {
                if ($category->children && $category->children->isNotEmpty()) {
                    foreach ($category->children as $child) {
                        if (!empty($child->slug)) {
                            $slugsToClear->push($child->slug);
                        }
                    }
                }
            } catch (\Throwable $e) {}

            foreach ($slugsToClear->unique() as $slug) {
                Cache::forget("catalog_category_slug_v4_{$slug}");
            }
        } else {
            try {
                $categories = static::select('id', 'slug')->get();
                foreach ($categories as $cat) {
                    if (!empty($cat->slug)) {
                        Cache::forget("catalog_category_slug_v4_{$cat->slug}");
                    }
                    if (!empty($cat->id)) {
                        Cache::forget("catalog_category_slug_v4_{$cat->id}");
                    }
                }
            } catch (\Throwable $e) {}
        }
    }

    /**
     * Get category slug, with auto-fallback to category_name or ID if empty.
     */
    public function getSlugAttribute($value): string
    {
        if (!empty($value)) {
            return $value;
        }

        if (!empty($this->category_name)) {
            return Str::slug($this->category_name);
        }

        return (string) ($this->id ?? '');
    }

    /**
     * Parent Category (Self-referential)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    /**
     * Child Categories
     */
    public function children(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope for header menu
     */
    public function scopeHeaderMenu($query)
    {
        return $query->where('header_menu', 1);
    }

    /**
     * Scope for side menu
     */
    public function scopeSideMenu($query)
    {
        return $query->where('side_menu', 1);
    }

    /**
     * Scope for show in filter
     */
    public function scopeShowInFilter($query)
    {
        return $query->where('show_in_filter', 1);
    }

    /**
     * Get all children recursively (nested categories)
     */
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Custom Icon
     */
    public function icon(): BelongsTo
    {
        return $this->belongsTo(Icon::class, 'icon_id');
    }

    /**
     * Render category icon HTML (SVG, font-icon class, custom icon relation, or fallback).
     */
    public function renderIcon(string $fallback = 'bi bi-box'): string
    {
        if (!empty($this->icon_class) && str_contains($this->icon_class, '<svg')) {
            return $this->icon_class;
        }

        if (!empty($this->icon_class)) {
            return '<i class="' . e($this->icon_class) . '"></i>';
        }

        if (!empty($this->icon?->code)) {
            return $this->icon->code;
        }

        return '<i class="' . e($fallback) . '"></i>';
    }

    /**
     * Accessor for rendered icon HTML ($category->rendered_icon)
     */
    public function getRenderedIconAttribute(): string
    {
        return $this->renderIcon();
    }

    /**
     * Category Featured Products Pivot Entries
     */
    public function categoryFeaturedProducts(): HasMany
    {
        return $this->hasMany(CategoryFeaturedProduct::class, 'category_id');
    }

    /**
     * Featured Top Products
     */
    public function featuredTopProducts()
    {
        return $this->belongsToMany(Product::class, 'category_featured_products', 'category_id', 'product_id')
            ->wherePivot('position', 'top')
            ->withPivot('sort_order')
            ->orderBy('category_featured_products.sort_order');
    }

    /**
     * Featured Middle Products
     */
    public function featuredMiddleProducts()
    {
        return $this->belongsToMany(Product::class, 'category_featured_products', 'category_id', 'product_id')
            ->wherePivot('position', 'middle')
            ->withPivot('sort_order')
            ->orderBy('category_featured_products.sort_order');
    }

    /**
     * Featured Bottom Products
     */
    public function featuredBottomProducts()
    {
        return $this->belongsToMany(Product::class, 'category_featured_products', 'category_id', 'product_id')
            ->wherePivot('position', 'bottom')
            ->withPivot('sort_order')
            ->orderBy('category_featured_products.sort_order');
    }
    /**
     * Associated Products
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_to_categories', 'category_id', 'product_id');
    }

    /**
     * Helper to get a category ID and all its descendant IDs recursively.
     */
    public static function getCategoryAndDescendantIds($categoryId, $allCategories = null): array
    {
        if ($allCategories === null) {
            $allCategories = Cache::rememberForever('catalog_category_pairs_v1', function () {
                return static::select('id', 'parent_id')->get();
            });
        }

        $ids = [(int) $categoryId];
        $children = $allCategories->where('parent_id', (int) $categoryId);

        foreach ($children as $child) {
            $ids = array_merge($ids, static::getCategoryAndDescendantIds($child->id, $allCategories));
        }

        return array_values(array_unique($ids));
    }
}

