<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Option extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function ($option) {
            Cache::forget('all_options');
        });

        static::deleted(function ($option) {
            Cache::forget('all_options');
        });
    }

    public function optionValues()
    {
        return $this->hasMany(OptionValue::class)->orderBy('sort_order');
    }
}
