<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class ProductCategory extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'features' => 'array',
    ];

    protected static function booted()
    {
        static::saved(function ($category) {
            Cache::forget('all_categories');
        });

        static::deleted(function ($category) {
            Cache::forget('all_categories');
        });
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
}
