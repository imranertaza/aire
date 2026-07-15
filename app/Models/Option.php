<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $guarded = ['id'];

    public function optionValues()
    {
        return $this->hasMany(OptionValue::class)->orderBy('sort_order');
    }
}
