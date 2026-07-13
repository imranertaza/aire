<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    protected $guarded = ['id'];


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductCategory::class,
            'coupon_categories',
            'coupon_id',
            'prod_cat_id'
        );
    }

    public function shippingMethods(): BelongsToMany
    {
        return $this->belongsToMany(
            ShippingMethod::class,
            'coupon_shippings',
            'coupon_id',
            'shipping_method_id'
        );
    }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'coupon_products',
            'coupon_id',
            'product_id'
        )->withTimestamps();
    }
}
