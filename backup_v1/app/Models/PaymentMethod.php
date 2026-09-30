<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PaymentMethod extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function ($method) {
            Cache::forget('all_payment_methods');
        });

        static::deleted(function ($method) {
            Cache::forget('all_payment_methods');
        });
    }

    protected $casts = [
        'settings' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
