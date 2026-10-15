<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class OptionValue extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('all_options');
            Cache::forget('filter_all_option_values_v1');
            Cache::forget('filter_budget_option_v1');
            Cache::forget('filter_active_db_options');
            Cache::forget('filter_steps_data_v9');
        });

        static::deleted(function () {
            Cache::forget('all_options');
            Cache::forget('filter_all_option_values_v1');
            Cache::forget('filter_budget_option_v1');
            Cache::forget('filter_active_db_options');
            Cache::forget('filter_steps_data_v9');
        });
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
