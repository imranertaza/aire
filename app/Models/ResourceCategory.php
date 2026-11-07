<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class ResourceCategory extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'status'     => 'integer',
        'sort_order' => 'integer',
    ];

    public const CACHE_KEY = 'storefront_resources_v1';

    protected static function booted(): void
    {
        static::saved(function () {
            static::clearCache();
        });

        static::deleted(function () {
            static::clearCache();
        });
    }

    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget(self::CACHE_KEY . '_list');
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 1)->orderBy('sort_order', 'asc');
    }

    /**
     * Get the resources for the category.
     */
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class)->orderBy('sort_order', 'asc');
    }

    /**
     * Get active resources for the category.
     */
    public function activeResources(): HasMany
    {
        return $this->hasMany(Resource::class)
            ->where('status', 1)
            ->orderBy('sort_order', 'asc');
    }
}
