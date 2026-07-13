<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    protected $guarded = ['id'];


    public function children()
    {
        return $this->hasMany(EventCategory::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(EventCategory::class, 'parent_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'category_id');
    }
}
