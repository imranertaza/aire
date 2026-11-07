<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductShowcase extends Model
{
    protected $guarded = ['id'];
    protected $touches = ['product'];

    protected $casts = [
        'feature_pills'    => 'array',
        'spec_highlights'  => 'array',
        'matched_features' => 'array',
        'health_tags'      => 'array',
    ];

    protected static function booted()
    {
        static::saved(function ($showcase) {
            if (!empty($showcase->product_id)) {
                $product = $showcase->product ?? Product::find($showcase->product_id);
                if ($product) {
                    Product::clearProductCache($product);
                    return;
                }
            }
            Product::clearProductCache();
        });

        static::deleted(function ($showcase) {
            if (!empty($showcase->product_id)) {
                $product = $showcase->product ?? Product::find($showcase->product_id);
                if ($product) {
                    Product::clearProductCache($product);
                    return;
                }
            }
            Product::clearProductCache();
        });
    }

    /**
     * Get the product that owns the showcase details.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
