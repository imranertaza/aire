<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeoZoneDetail extends Model
{
    protected $guarded = ['id'];

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
