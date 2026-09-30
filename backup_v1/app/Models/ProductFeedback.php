<?php

namespace App\Models;

use App\Models\Concerns\InvalidatesDashboardCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFeedback extends Model
{
    use InvalidatesDashboardCache;

    protected $table = 'product_feedbacks';
    protected $guarded = ['id'];

    /**
     * Get the product associated with this feedback.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the customer associated with this feedback.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Scope a query to only include pending reviews (status = 0).
     */
    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Scope a query to only include approved reviews (status = 1).
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 1);
    }
}
