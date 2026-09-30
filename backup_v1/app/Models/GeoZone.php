<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeoZone extends Model
{
    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function details()
    {
        return $this->hasMany(GeoZoneDetail::class, 'geo_zone_id');
    }
}
