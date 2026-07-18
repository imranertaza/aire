<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the ledger records for the customer.
     */
    public function ledgers(): HasMany
    {
        return $this->hasMany(CustomerLedger::class, 'customer_id');
    }

    /**
     * Get the point history for the customer.
     */
    public function points(): HasMany
    {
        return $this->hasMany(CustomerPointHistory::class, 'customer_id');
    }
}
