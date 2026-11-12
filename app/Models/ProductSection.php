<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSection extends Model
{
    use HasFactory;

    protected $table = 'product_sections';

    protected $guarded = ['id'];

    protected $casts = [
        'is_enabled' => 'boolean',
        'sort_order' => 'integer',
        'product_id' => 'integer',
    ];

    /**
     * Booted lifecycle hooks for automatic cache busting.
     */
    protected static function booted()
    {
        static::saved(function ($section) {
            \Illuminate\Support\Facades\Cache::forget("product_sections_{$section->product_id}");
        });

        static::deleted(function ($section) {
            \Illuminate\Support\Facades\Cache::forget("product_sections_{$section->product_id}");
        });
    }

    /**
     * Parent product relation.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Linked visual section relation (by section_name).
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_name', 'name');
    }
}
