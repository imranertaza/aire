<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['status_name'];

    /**
     * Fallback Status Name accessor.
     */
    public function getStatusNameAttribute(): string
    {
        return $this->orderStatus->name ?? 'Unknown';
    }

    /**
     * Get the status associated with the order.
     */
    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'status');
    }

    /**
     * Get the customer associated with the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get items of the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Get options of the order.
     */
    public function options(): HasMany
    {
        return $this->hasMany(OrderOption::class, 'order_id');
    }

    /**
     * Get history records of the order.
     */
    public function histories(): HasMany
    {
        return $this->hasMany(OrderHistory::class, 'order_id');
    }

    /**
     * Get card log details of the order.
     */
    public function cardDetail(): HasOne
    {
        return $this->hasOne(OrderCardDetail::class, 'order_id');
    }
}
