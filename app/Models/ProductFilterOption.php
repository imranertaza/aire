<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFilterOption extends Model
{
    protected $guarded = ['id'];

    public function filterOption()
    {
        return $this->belongsTo(FilterOption::class, 'filter_option_id');
    }

    public function filterOptionValue()
    {
        return $this->belongsTo(FilterOptionValue::class, 'filter_option_value_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
