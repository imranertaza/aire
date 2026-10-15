<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GeoZone extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('all_active_geo_zones');
        });

        static::deleted(function () {
            Cache::forget('all_active_geo_zones');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function details()
    {
        return $this->hasMany(GeoZoneDetail::class, 'geo_zone_id');
    }
}
