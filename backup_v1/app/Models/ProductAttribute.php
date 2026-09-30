<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $guarded = ['id'];

    public function attributeGroup()
    {
        return $this->belongsTo(ProductAttributeGroup::class, 'attribute_group_id');
    }
}
