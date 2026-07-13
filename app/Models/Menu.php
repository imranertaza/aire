<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = ['id'];

    public function menus()
    {
        return $this->hasMany(MenuItem::class)->where('parent_id', null)->orderBy('order');
    }
}
