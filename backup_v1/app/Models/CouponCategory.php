<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CouponCategory extends Model
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
}
