<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSpecial extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'special_price' => 'decimal:2',
        'start_date'    => 'date',
        'end_date'      => 'date',
    ];

    public function scopeActive($query)
    {
        $today = now()->toDateString();
        return $query->where(function ($q) use ($today) {
            $q->whereNull('start_date')
                ->orWhere('start_date', '<=', $today)
                ->orWhere('start_date', '0000-00-00');
        })->where(function ($q) use ($today) {
            $q->whereNull('end_date')
                ->orWhere('end_date', '>=', $today)
                ->orWhere('end_date', '0000-00-00');
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
