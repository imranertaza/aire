<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Page extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
    ];

    protected static function booted()
    {
        static::saved(function ($page) {
            \Illuminate\Support\Facades\Cache::forget("cms_page_{$page->slug}");
            \Illuminate\Support\Facades\Cache::forget("page_{$page->id}");
            \Illuminate\Support\Facades\Cache::forget("active_legal_sidebar_pages_v1");
        });

        static::deleted(function ($page) {
            \Illuminate\Support\Facades\Cache::forget("cms_page_{$page->slug}");
            \Illuminate\Support\Facades\Cache::forget("page_{$page->id}");
            \Illuminate\Support\Facades\Cache::forget("active_legal_sidebar_pages_v1");
        });
    }

    /**
     * Scope a query to only include active pages.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 1);
    }

    /**
     * Scope a query to only include inactive pages.
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', 0);
    }
}
