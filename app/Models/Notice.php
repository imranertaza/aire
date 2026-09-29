<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $guarded = ['id'];

    /**
     * Scope a query to only include general notices (type = 0).
     */
    public function scopeNotices($query)
    {
        return $query->where('type', 0);
    }

    /**
     * Scope a query to only include fixtures (type = 1).
     */
    public function scopeFixtures($query)
    {
        return $query->where('type', 1);
    }
}
