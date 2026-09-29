<?php

namespace App\Models;

use App\Services\Admin\AdminDashboardService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;

class Order extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['status_name', 'order_number'];

    protected static function booted()
    {
        static::saving(function ($order) {
            $order->store_id = $order->store_id ?? 1;
            $order->payment_firstname = $order->payment_firstname ?? $order->shipping_firstname ?? 'Guest';
            $order->payment_lastname = $order->payment_lastname ?? $order->shipping_lastname ?? 'Customer';
            $order->payment_address_1 = $order->payment_address_1 ?? $order->shipping_address_1 ?? 'Address';
            $order->payment_address_2 = $order->payment_address_2 ?? '';
            $order->payment_city = $order->payment_city ?? $order->shipping_city ?? 'City';
            $order->payment_postcode = $order->payment_postcode ?? '0000';
            $order->payment_country_id = $order->payment_country_id ?? 1;
            $order->payment_phone = $order->payment_phone ?? $order->telephone ?? '01700000000';
            $order->payment_email = $order->payment_email ?? $order->email ?? 'guest@example.com';
            $order->payment_method = $order->payment_method ?? 'cod';
            $order->vat = $order->vat ?? 0;
            $order->final_amount = $order->final_amount ?? $order->total ?? 0;
            $order->ip = $order->ip ?? request()?->ip() ?? '127.0.0.1';
        });

        static::saved(function () {
            Cache::forget(AdminDashboardService::CACHE_KEY);
        });

        static::deleted(function () {
            Cache::forget(AdminDashboardService::CACHE_KEY);
        });
    }

    /**
     * Formatted professional order reference code (e.g. AIR-000105).
     */
    public function getOrderNumberAttribute(): string
    {
        return 'AIR-' . str_pad((string) $this->id, 6, '0', STR_PAD_LEFT);
    }

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

    // ========================================
    // Scopes
    // ========================================

    /**
     * Scope a query to only include pending or processing orders.
     */
    public function scopePendingOrProcessing($query)
    {
        return $query->whereIn('status', [1, 2]);
    }

    /**
     * Scope a query to only include paid orders.
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'Paid');
    }

    /**
     * Scope a query to only include fulfilled orders.
     */
    public function scopeFulfilled($query)
    {
        return $query->where(function ($q) {
            $q->whereIn('status', [3, 5])
              ->orWhere('payment_status', 'Paid');
        });
    }

    /**
     * Scope a query to only include returned or canceled orders.
     */
    public function scopeReturned($query)
    {
        return $query->whereIn('status', [7, 8, 10, 11]);
    }
}
