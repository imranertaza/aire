<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Offer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function ($offer) {
            Cache::forget('all_offers');
        });

        static::deleted(function ($offer) {
            Cache::forget('all_offers');
        });
    }

    protected $casts = [
        'start_date' => 'datetime',
        'expire_date' => 'datetime',
    ];

    /**
     * Scope a query to only include offers of a given type (key).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('key', $type);
    }

    public function discount()
    {
        return $this->hasOne(OfferDiscount::class, 'offer_id');
    }

    public function discounts()
    {
        return $this->hasMany(OfferDiscount::class, 'offer_id');
    }

    public function products()
    {
        return $this->hasMany(OfferOnProduct::class, 'offer_id')->whereNotNull('product_id');
    }

    public function categories()
    {
        return $this->hasMany(OfferOnProduct::class, 'offer_id')->whereNotNull('prod_cat_id');
    }

    public function brands()
    {
        return $this->hasMany(OfferOnProduct::class, 'offer_id')->whereNotNull('brand_id');
    }

    public function targetItems()
    {
        return $this->hasMany(OfferOnProduct::class, 'offer_id');
    }
}
