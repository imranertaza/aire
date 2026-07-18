<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferOnProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'prod_cat_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
