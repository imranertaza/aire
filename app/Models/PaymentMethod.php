<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
