<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Section extends Model
{
    protected $guarded = ['id'];

    // Cast JSON column to array automatically
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Booted lifecycle hooks for automatic cache busting.
     */
    protected static function booted()
    {
        static::saved(function ($section) {
            static::clearSectionCache($section);
        });

        static::deleted(function ($section) {
            static::clearSectionCache($section);
        });
    }

    /**
     * Clear all section-related caches including aliases.
     */
    public static function clearSectionCache(?Section $section = null): void
    {
        Cache::forget('all_sections');
        Cache::forget('default_home_sections_ensured_v1');
        Cache::forget('storefront_about_sections_v1');
        Product::clearProductCache();

        if ($section && !empty($section->name)) {
            Cache::forget("section_{$section->name}");
            if (str_starts_with($section->name, 'home_')) {
                $alt = substr($section->name, 5);
                Cache::forget("section_{$alt}");
            } else {
                Cache::forget("section_home_{$section->name}");
            }
        }
    }

    /**
     * Helper to get a value by key.
     */
    public function getValue(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Helper to set a value by key.
     */
    public function setValue(string $key, $value): void
    {
        $data = $this->data ?? [];
        $data[$key] = $value;
        $this->data = $data;
        $this->save();
    }
}
