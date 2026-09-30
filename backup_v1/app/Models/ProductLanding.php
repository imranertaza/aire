<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductLanding extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products_landing';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'product_id'       => 'integer',
        'status'           => 'integer',
        'science_features' => 'array',
        'specs_groups'     => 'array',
    ];

    /**
     * Get the product that owns this landing configuration.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
