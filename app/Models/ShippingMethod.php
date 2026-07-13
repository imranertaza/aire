<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ShippingMethod extends Model
{
    protected $guarded = ['id'];

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
