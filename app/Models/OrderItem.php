<?php

namespace App\Models;

use App\Models\Concerns\InvalidatesDashboardCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use InvalidatesDashboardCache;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saving(function ($item) {
            $item->total_price = $item->total_price ?? ($item->price * $item->quantity);
            $item->final_price = $item->final_price ?? $item->total_price;
        });
    }

    /**
     * Get the order.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get options for this item.
     */
    public function options(): HasMany
    {
        return $this->hasMany(OrderOption::class, 'order_item_id');
    }

    /**
     * Accessor for item total.
     */
    public function getTotalAttribute(): float
    {
        return (float) ($this->final_price ?? ($this->total_price ?? ($this->price * $this->quantity)));
    }

    /**
     * Accessor for product name fallback.
     */
    public function getNameAttribute($value): ?string
    {
        return $value ?: ($this->product->name ?? null);
    }

    /**
     * Accessor for product model fallback.
     */
    public function getModelAttribute($value): ?string
    {
        return $value ?: ($this->product->model ?? 'Standard');
    }
}
