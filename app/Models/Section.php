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
            Cache::forget("section_{$section->name}");
            Cache::forget('all_sections');
            Cache::forget('default_home_sections_ensured_v1');
            Cache::forget('storefront_about_sections_v1');
            Product::clearProductCache();
        });

        static::deleted(function ($section) {
            Cache::forget("section_{$section->name}");
            Cache::forget('all_sections');
            Cache::forget('default_home_sections_ensured_v1');
            Cache::forget('storefront_about_sections_v1');
            Product::clearProductCache();
        });
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
