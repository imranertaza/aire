<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GeoZoneDetail extends Model
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

    public function geoZone()
    {
        return $this->belongsTo(GeoZone::class, 'geo_zone_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }
}
