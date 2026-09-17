<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FilterOption extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function ($option) {
            Cache::forget('all_filter_options');
        });

        static::deleted(function ($option) {
            Cache::forget('all_filter_options');
        });
    }

    public function optionValues()
    {
        return $this->hasMany(FilterOptionValue::class, 'filter_option_id')->orderBy('sort_order');
    }

    public function scopeShowInFilter($query)
    {
        return $query->where('show_in_filter', 1);
    }
}
