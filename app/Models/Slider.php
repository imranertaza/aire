<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Slider extends Model
{
    protected $guarded = ['id'];

    /**
     * Get resolved image URL for the slider ($slider->image_url).
     */
    public function getImageUrlAttribute(): string
    {
        return getImageUrl($this->image);
    }

    /**
     * Boot model events for automatic cache invalidation.
     */
    protected static function booted()
    {
        static::saved(function ($slider) {
            static::clearCache($slider);
        });

        static::deleted(function ($slider) {
            static::clearCache($slider);
        });
    }

    /**
     * Clear all slider cache keys.
     */
    public static function clearCache(?Slider $slider = null): void
    {
        Cache::forget('sliders_all_active');
        Cache::forget('filter_ad_sliders');
        Cache::forget('storefront_about_ads_v1');

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

        if ($slider && !empty($slider->key)) {
            $keys = explode(',', $slider->key);
            foreach ($keys as $k) {
                $k = trim($k);
                if ($k) {
                    $placements[] = $k;
                }
            }
        }

        foreach (array_unique($placements) as $p) {
            Cache::forget("sliders_placement_{$p}");
            Cache::forget("sliders_{$p}");
        }
    }

    // ========================================
    // Scopes
    // ========================================

    public function scopeActive($query)
    {
        return $query->where('enabled', 1);
    }

    public function scopePlacement($query, string $placement)
    {
        return $query->where(function ($q) use ($placement) {
            $q->where('key', $placement)
                ->orWhere('key', 'like', "%{$placement}%");
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('id', 'desc');
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
            return static::active()
                ->placement($placement)
                ->ordered()
                ->get();
        });
    }
}
