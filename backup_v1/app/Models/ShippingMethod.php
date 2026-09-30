<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class ShippingMethod extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function ($method) {
            Cache::forget('all_shipping_methods');
        });

        static::deleted(function ($method) {
            Cache::forget('all_shipping_methods');
        });
    }

    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(
            Coupon::class,
            'coupon_shippings',
            'shipping_method_id',
            'coupon_id'
        );
    }
}
