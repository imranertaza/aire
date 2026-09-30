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
