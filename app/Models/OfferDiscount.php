<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferDiscount extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
}
