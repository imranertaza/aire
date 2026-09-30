<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $guarded = ['id'];

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
