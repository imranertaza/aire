<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Zone extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function ($zone) {
            if ($zone->country_id) {
                Cache::forget("zones_by_country_{$zone->country_id}");
            }
            if ($zone->isDirty('country_id') && $zone->getOriginal('country_id')) {
                Cache::forget("zones_by_country_{$zone->getOriginal('country_id')}");
            }
        });

        static::deleted(function ($zone) {
            if ($zone->country_id) {
                Cache::forget("zones_by_country_{$zone->country_id}");
            }
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function geoZone()
    {
        return $this->belongsTo(GeoZone::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
