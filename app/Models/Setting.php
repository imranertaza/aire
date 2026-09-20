<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('settings');
            Cache::forget('aire_popular_searches_list');
        });
        static::deleted(function () {
            Cache::forget('settings');
            Cache::forget('aire_popular_searches_list');
        });
    }

    public static function allCached()
    {
        try {
            return Cache::rememberForever('settings', fn() => static::pluck('value', 'label')->toArray());
        } catch (\Exception $e) {
            // Table not found or other DB issue
            return [];
        }
    }

    public static function get(string $key, $default = null)
    {
        return static::allCached()[$key] ?? $default;
    }
}
