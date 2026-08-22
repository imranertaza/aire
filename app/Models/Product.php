<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'price'            => 'decimal:2',
        'weight'           => 'decimal:4',
        'length'           => 'decimal:4',
        'width'            => 'decimal:4',
        'height'           => 'decimal:4',
        'featured'         => 'integer',
        'status'           => 'integer',           // 1 = Active, 0 = Inactive
        'date_available'   => 'date',
        'average_feedback' => 'integer',
    ];

    protected static function booted()
    {
        static::saving(function ($product) {
            if (empty($product->slug) && !empty($product->name)) {
                $baseSlug = \Illuminate\Support\Str::slug($product->name);
                $slug = $baseSlug;
                $count = 1;
                while (static::where('slug', $slug)->where('id', '!=', $product->id ?? 0)->exists()) {
                    $slug = $baseSlug . '-' . $count;
                    $count++;
                }
                $product->slug = $slug;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // ========================================
    // Relationships
    // ========================================

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'product_to_categories', 'product_id', 'category_id')->withTimestamps();
    }

    public function description()
    {
        return $this->hasOne(ProductDescription::class);
    }

    public function overview()
    {
        return $this->hasOne(ProductOverview::class);
    }

    public function freeDelivery()
    {
        return $this->hasOne(ProductFreeDelivery::class);
    }

    public function specials()
    {
        return $this->hasMany(ProductSpecial::class);
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'product_related', 'product_id', 'related_id')->withTimestamps();
    }

    public function boughtTogether()
    {
        return $this->belongsToMany(Product::class, 'product_bought_together', 'product_id', 'related_id')->withTimestamps();
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_product', 'product_id', 'coupon_id')->withTimestamps();
    }

    public function productOptions()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function applications()
    {
        return $this->hasMany(ProductApplication::class)->orderBy('sort_order');
    }

    public function faqs()
    {
        return $this->hasMany(ProductFaq::class)->orderBy('sort_order');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    // ========================================
    // Scopes
    // ========================================

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('quantity', '<=', $threshold);
    }

    // ========================================
    // Accessors
    // ========================================

    public function getStatusTextAttribute(): string
    {
        return $this->status === 1 ? 'Active' : 'Inactive';
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->status === 1
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Inactive</span>';
    }

    public function getMainImageUrlAttribute()
    {
        return $this->main_image
            ? asset('storage/' . $this->main_image)
            : asset('images/no-image.jpg');
    }
}
