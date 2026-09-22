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
            if (str_starts_with($section->name, 'home_') || in_array($section->name, ['best_selling', 'new_arrival', 'customer_favorites', 'lifestyle', 'living_hero'])) {
                Cache::forget('home_best_selling_products');
                Cache::forget('home_new_arrival_products');
                Cache::forget('home_customer_fav_products');
                Cache::forget('home_living_hero_product');
            }
        });

        static::deleted(function ($section) {
            Cache::forget("section_{$section->name}");
            Cache::forget('all_sections');
            if (str_starts_with($section->name, 'home_') || in_array($section->name, ['best_selling', 'new_arrival', 'customer_favorites', 'lifestyle', 'living_hero'])) {
                Cache::forget('home_best_selling_products');
                Cache::forget('home_new_arrival_products');
                Cache::forget('home_customer_fav_products');
                Cache::forget('home_living_hero_product');
            }
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
