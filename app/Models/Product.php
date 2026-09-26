<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Product extends Model
{
    public const HOME_SECTIONS_CACHE_KEY = 'storefront_home_product_sections_v2';

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
                $baseSlug = Str::slug($product->name);
                $slug = $baseSlug;
                $count = 1;
                while (static::where('slug', $slug)->where('id', '!=', $product->id ?? 0)->exists()) {
                    $slug = $baseSlug . '-' . $count;
                    $count++;
                }
                $product->slug = $slug;
            }
        });

        static::saved(function ($product) {
            static::clearProductCache($product);
        });

        static::deleted(function ($product) {
            static::clearProductCache($product);
        });
    }

    /**
     * Invalidate all storefront, catalog, and product caches.
     */
    public static function clearProductCache(?Product $product = null): void
    {
        // 1. Homepage consolidated & fallback sections
        Cache::forget(self::HOME_SECTIONS_CACHE_KEY);
        Cache::forget('site_default_featured_products');
        Cache::forget('total_active_products_count');
        Cache::forget('filter_steps_data_v9');

        // Legacy individual section keys for backward compatibility
        Cache::forget('home_best_selling_products');
        Cache::forget('home_new_arrival_products');
        Cache::forget('home_customer_fav_products');
        Cache::forget('home_top_featured_product');
        Cache::forget('home_bottom_featured_product');
        Cache::forget('home_living_hero_product');

        // 2. Specific product item caches
        if ($product) {
            if (!empty($product->slug)) {
                Cache::forget("product_detail_{$product->slug}");
                Cache::forget("product_landing_{$product->slug}");
            }
            if (!empty($product->id)) {
                Cache::forget("product_detail_{$product->id}");
                Cache::forget("product_landing_{$product->id}");
                Cache::forget("product_related_{$product->id}");
            }
        }
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

    public function special()
    {
        $today = now()->toDateString();
        return $this->hasOne(ProductSpecial::class)
            ->where(function ($q) use ($today) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', $today)
                    ->orWhere('start_date', '0000-00-00');
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', $today)
                    ->orWhere('end_date', '0000-00-00');
            })
            ->orderBy('special_price', 'asc');
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
        return $this->hasMany(ProductOption::class, 'product_id');
    }

    public function productFilterOptions()
    {
        return $this->hasMany(ProductFilterOption::class, 'product_id');
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

    public function productLanding()
    {
        return $this->hasOne(ProductLanding::class, 'product_id');
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

    public function getMainImageUrlAttribute(): string
    {
        $raw = !empty($this->main_image) ? $this->main_image : (!empty($this->image) ? $this->image : null);
        return getImageUrl($raw);
    }

    public function getSpecialPriceAttribute(): ?float
    {
        $special = $this->relationLoaded('special') ? $this->special : $this->special()->first();

        if ($special && is_numeric($special->special_price)) {
            $sp = (float) $special->special_price;
            if ($sp > 0 && $sp < (float) $this->price) {
                return $sp;
            }
        }

        return null;
    }

    public function getFinalPriceAttribute(): float
    {
        return $this->special_price !== null ? (float) $this->special_price : (float) $this->price;
    }

    public function getIsFreeDeliveryAttribute(): bool
    {
        return $this->relationLoaded('freeDelivery')
            ? $this->freeDelivery !== null
            : $this->freeDelivery()->exists();
    }
}
