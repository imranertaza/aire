<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProductAttributeGroup extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function ($group) {
            Cache::forget('all_attribute_groups');
        });

        static::deleted(function ($group) {
            Cache::forget('all_attribute_groups');
        });
    }
}
