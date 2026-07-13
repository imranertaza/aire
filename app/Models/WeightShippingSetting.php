<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeightShippingSetting extends Model
{
    protected $guarded = ['id'];

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
    }
}
