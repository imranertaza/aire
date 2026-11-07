<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FilterOption extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'show_in_filter'        => 'integer',
        'show_in_catalog'       => 'integer',
        'show_in_guided_finder' => 'integer',
        'has_unknown_option'    => 'integer',
        'guided_step_number'    => 'integer',
        'sort_order'            => 'integer',
        'status'                => 'integer',
    ];

    protected static function booted()
    {
        static::saved(function ($option) {
            Cache::forget('all_filter_options');
            Cache::forget('filter_all_option_values_v1');
            Cache::forget('filter_budget_option_v1');
            Cache::forget('filter_active_db_options');
            Cache::forget('filter_steps_data_v9');
            Cache::forget('guided_finder_steps_data_v1');
        });

        static::deleted(function ($option) {
            Cache::forget('all_filter_options');
            Cache::forget('filter_all_option_values_v1');
            Cache::forget('filter_budget_option_v1');
            Cache::forget('filter_active_db_options');
            Cache::forget('filter_steps_data_v9');
            Cache::forget('guided_finder_steps_data_v1');
        });
    }

    public function optionValues()
    {
        return $this->hasMany(FilterOptionValue::class, 'filter_option_id')->orderBy('sort_order');
    }

    public function scopeShowInFilter($query)
    {
        return $query->where(function ($q) {
            $q->where('show_in_catalog', 1)->orWhere('show_in_filter', 1);
        });
    }

    public function scopeCatalogFilter($query)
    {
        return $query->where('status', 1)->where('show_in_catalog', 1);
    }

    public function scopeGuidedFinder($query)
    {
        return $query->where('status', 1)
            ->where('show_in_guided_finder', 1)
            ->orderBy('guided_step_number', 'asc')
            ->orderBy('sort_order', 'asc');
    }
}
