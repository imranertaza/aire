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
}
