<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Slider extends Model
{
    protected $guarded = ['id'];

    /**
     * Boot model events for automatic cache invalidation.
     */
    protected static function booted()
    {
        static::saved(function ($slider) {
            static::clearCache();
        });

        static::deleted(function ($slider) {
            static::clearCache();
        });
    }

    /**
     * Clear all slider cache keys.
     */
    public static function clearCache(): void
    {
        Cache::forget('sliders_all_active');
        $placements = [
            'banner_section',
            'home_hero',
            'home_slider',
            'category_sidebar',
            'featured_ad',
            'about_us',
            'products',
            'filter',
            'compare',
            'favorite',
        ];
        foreach ($placements as $p) {
            Cache::forget("sliders_placement_{$p}");
        }
    }

    /**
     * Get active sliders for a specific placement with caching.
     *
     * @param string $placement
     * @param int $ttl Seconds to cache (default 24h = 86400)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByPlacement(string $placement = 'banner_section', int $ttl = 86400)
    {
        return Cache::remember("sliders_placement_{$placement}", $ttl, function () use ($placement) {
            return static::where('enabled', 1)
                ->where(function ($q) use ($placement) {
                    $q->where('key', $placement)
                      ->orWhere('key', 'like', "%{$placement}%");
                })
                ->orderBy('order', 'asc')
                ->orderBy('id', 'desc')
                ->get();
        });
    }
}
