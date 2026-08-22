<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $guarded = ['id'];

    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }

    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class, 'option_value_id');
    }
}
