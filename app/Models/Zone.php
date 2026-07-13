<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $guarded = ['id'];

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
