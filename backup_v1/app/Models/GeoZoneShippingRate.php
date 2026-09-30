<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeoZoneShippingRate extends Model
{
    protected $guarded = ['id'];

    public function geoZone()
    {
        return $this->belongsTo(GeoZone::class, 'geo_zone_id');
    }
}
