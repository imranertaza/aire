<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Authenticatable
{
    use Notifiable;
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
