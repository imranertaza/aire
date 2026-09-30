<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerPointHistory extends Model
{
    protected $table = 'customer_point_histories';
    protected $guarded = ['id'];

    /**
     * Get the customer associated with this point history.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
