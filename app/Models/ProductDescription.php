<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDescription extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'in_the_box_items' => 'array',
    ];

    protected static function booted()
    {
        static::saved(function ($description) {
            if (!empty($description->product_id)) {
                $product = $description->product ?? Product::find($description->product_id);
                if ($product) {
                    Product::clearProductCache($product);
                    return;
                }
            }
            Product::clearProductCache();
        });

        static::deleted(function ($description) {
            if (!empty($description->product_id)) {
                $product = $description->product ?? Product::find($description->product_id);
                if ($product) {
                    Product::clearProductCache($product);
                    return;
                }
            }
            Product::clearProductCache();
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
