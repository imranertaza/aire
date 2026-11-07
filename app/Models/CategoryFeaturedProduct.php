<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class CategoryFeaturedProduct extends Model
{
    protected $table = 'category_featured_products';

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function ($item) {
            ProductCategory::clearCategoryCache();
            if (!empty($item->category_id)) {
                $category = ProductCategory::find($item->category_id);
                if ($category && !empty($category->slug)) {
                    Cache::forget("catalog_category_slug_v4_{$category->slug}");
                }
            }
        });

        static::deleted(function ($item) {
            ProductCategory::clearCategoryCache();
            if (!empty($item->category_id)) {
                $category = ProductCategory::find($item->category_id);
                if ($category && !empty($category->slug)) {
                    Cache::forget("catalog_category_slug_v4_{$category->slug}");
                }
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
