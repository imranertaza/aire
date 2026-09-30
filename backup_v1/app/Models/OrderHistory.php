<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderHistory extends Model
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
     * Get status of this history log.
     */
    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    /**
     * Get the order.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
