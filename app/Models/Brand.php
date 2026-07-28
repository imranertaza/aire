<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Brand extends Model
{
    protected $guarded=['id'];

    protected static function booted()
    {
        static::saved(function ($brand) {
            Cache::forget('all_brands');
        });

        static::deleted(function ($brand) {
            Cache::forget('all_brands');
        });
    }
}
