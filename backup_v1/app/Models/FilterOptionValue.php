<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FilterOptionValue extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function ($optionValue) {
            Cache::forget('all_filter_options');
        });

        static::deleted(function ($optionValue) {
            Cache::forget('all_filter_options');
        });
    }

    public function filterOption()
    {
        return $this->belongsTo(FilterOption::class, 'filter_option_id');
    }

    public function productFilterOptions()
    {
        return $this->hasMany(ProductFilterOption::class, 'filter_option_value_id');
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, ProductFilterOption::class, 'filter_option_value_id', 'id', 'id', 'product_id');
    }
}
