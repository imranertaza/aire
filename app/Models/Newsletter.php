<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['id'];

    /**
     * Get the customer associated with the newsletter subscription.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
