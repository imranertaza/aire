<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductShowcase extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'feature_pills'    => 'array',
        'spec_highlights'  => 'array',
        'matched_features' => 'array',
        'health_tags'      => 'array',
    ];

    /**
     * Get the product that owns the showcase details.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
