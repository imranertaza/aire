<?php

namespace App\Models\Concerns;

use App\Services\Admin\AdminDashboardService;
use Illuminate\Support\Facades\Cache;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @method static void saved(\Closure|string|array $callback)
 * @method static void deleted(\Closure|string|array $callback)
 */
trait InvalidatesDashboardCache
{
    /**
     * Boot the trait to automatically invalidate admin dashboard cache on model changes.
     */
    protected static function bootInvalidatesDashboardCache(): void
    {
        static::saved(function () {
            Cache::forget(AdminDashboardService::CACHE_KEY);
        });

        static::deleted(function () {
            Cache::forget(AdminDashboardService::CACHE_KEY);
        });
    }
}
