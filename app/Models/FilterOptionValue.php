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
            Cache::forget('filter_all_option_values_v1');
            Cache::forget('filter_budget_option_v1');
            Cache::forget('filter_active_db_options');
            Cache::forget('filter_steps_data_v9');
        });

        static::deleted(function ($optionValue) {
            Cache::forget('all_filter_options');
            Cache::forget('filter_all_option_values_v1');
            Cache::forget('filter_budget_option_v1');
            Cache::forget('filter_active_db_options');
            Cache::forget('filter_steps_data_v9');
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
