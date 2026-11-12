<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Country extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('all_active_countries');
        });

        static::deleted(function ($country) {
            Cache::forget('all_active_countries');
            if ($country->id) {
                Cache::forget("zones_by_country_{$country->id}");
            }
        });
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
