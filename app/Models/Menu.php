<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Menu extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function () {
            self::flushMenuCache();
        });

        static::deleted(function () {
            self::flushMenuCache();
        });
    }

    public static function flushMenuCache(): void
    {
        Cache::forget('layout_main_header_menu_v1');
        Cache::forget('layout_footer_menus_v1');
        Cache::forget('layout_footer_legal_menu_v1');
        Cache::forget('layout_legal_pages_menu_v1');
    }

    public function menus()
    {
        return $this->hasMany(MenuItem::class)->where('parent_id', null)->orderBy('order');
    }
}
