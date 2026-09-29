<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $guarded = ['id'];


    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    /**
     * Scope a query to only include running events (type = 0).
     */
    public function scopeRunning($query)
    {
        return $query->where('type', 0);
    }

    /**
     * Scope a query to only include upcoming events (type = 1).
     */
    public function scopeUpcoming($query)
    {
        return $query->where('type', 1);
    }
}
