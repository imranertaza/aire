<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class OrderStatus extends Model
{
    protected $table = 'order_statuses';
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('all_order_statuses');
        });

        static::deleted(function () {
            Cache::forget('all_order_statuses');
        });
    }
}
