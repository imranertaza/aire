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
        'status'  => 'integer',
        'menu_id' => 'integer',
    ];

    protected static function booted()
    {
        // Invalidate old slug cache before the model is saved when slug changes
        static::updating(function ($page) {
            if ($page->isDirty('slug') && $page->getOriginal('slug')) {
                $orig = strtolower(trim($page->getOriginal('slug')));
                \Illuminate\Support\Facades\Cache::forget("cms_page_{$orig}");
                \Illuminate\Support\Facades\Cache::forget("cms_page_{$page->getOriginal('slug')}");
            }
        });

        static::saved(function ($page) {
            static::clearPageCache($page);
        });

        static::deleted(function ($page) {
            static::clearPageCache($page);
        });
    }

    /**
     * Always normalize slug to lowercase.
     */
    public function setSlugAttribute($value): void
    {
        $this->attributes['slug'] = !empty($value) ? strtolower(trim($value)) : $value;
    }

    /**
     * Invalidate all page and legal menu caches.
     */
    public static function clearPageCache(?Page $page = null, ?string $oldSlug = null): void
    {
        \Illuminate\Support\Facades\Cache::forget('active_legal_sidebar_pages_v1');
        \Illuminate\Support\Facades\Cache::forget('layout_legal_pages_menu_v1');
        \Illuminate\Support\Facades\Cache::forget('layout_main_header_menu_v1');
        \Illuminate\Support\Facades\Cache::forget('layout_footer_menus_v1');
        \Illuminate\Support\Facades\Cache::forget('layout_footer_legal_menu_v1');

        if (class_exists(\App\Services\Common\SitemapService::class)) {
            \Illuminate\Support\Facades\Cache::forget(\App\Services\Common\SitemapService::CACHE_KEY);
        }

        if ($page) {
            if (!empty($page->slug)) {
                $slug = strtolower(trim($page->slug));
                \Illuminate\Support\Facades\Cache::forget("cms_page_{$slug}");
                \Illuminate\Support\Facades\Cache::forget("cms_page_{$page->slug}");
            }
            if (!empty($oldSlug)) {
                $old = strtolower(trim($oldSlug));
                \Illuminate\Support\Facades\Cache::forget("cms_page_{$old}");
                \Illuminate\Support\Facades\Cache::forget("cms_page_{$oldSlug}");
            }
            if ($page->wasChanged('slug') && $page->getOriginal('slug')) {
                $orig = strtolower(trim($page->getOriginal('slug')));
                \Illuminate\Support\Facades\Cache::forget("cms_page_{$orig}");
                \Illuminate\Support\Facades\Cache::forget("cms_page_{$page->getOriginal('slug')}");
            }
            if (!empty($page->id)) {
                \Illuminate\Support\Facades\Cache::forget("page_{$page->id}");
            }
            if (!empty($page->menu_id)) {
                \Illuminate\Support\Facades\Cache::forget("page_associated_menu_{$page->menu_id}");
            }
            if ($page->isDirty('menu_id') && $page->getOriginal('menu_id')) {
                \Illuminate\Support\Facades\Cache::forget("page_associated_menu_{$page->getOriginal('menu_id')}");
            }
        }
    }

    /**
     * Get the associated sidebar menu for this page.
     */
    public function menu(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
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
