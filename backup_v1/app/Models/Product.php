<?php

namespace App\Models;

use Carbon\Carbon;
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
            if (empty($product->store_id)) {
                $product->store_id = 1;
            }

            if (empty($product->model)) {
                $product->model = Str::slug($product->name ?? 'item');
            }

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
        Cache::forget(\App\Services\Admin\AdminDashboardService::CACHE_KEY);

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
        $today = Carbon::now()->toDateString();
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

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope a query to only include inactive products.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    /**
     * Scope a query to only include in-stock products.
     */
    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    /**
     * Scope a query to only include low stock products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $threshold
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLowStock($query, int $threshold = 5)
    {
        return $query->where('quantity', '<=', $threshold);
    }

    /**
     * Scope a query to filter by specific category IDs.
     */
    public function scopeInCategories($query, array $categoryIds)
    {
        if (empty($categoryIds)) {
            return $query;
        }

        return $query->whereHas('categories', fn($q) => $q->whereIn('product_categories.id', $categoryIds));
    }

    /**
     * Scope a query to search products by name, model, code, tags, or description.
     */
    public function scopeSearch($query, ?string $search)
    {
        $search = trim((string) $search);
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('model', 'like', "%{$search}%")
                ->orWhere('product_code', 'like', "%{$search}%")
                ->orWhereHas('categories', fn($cq) => $cq->where('category_name', 'like', "%{$search}%"))
                ->orWhereHas('description', function ($dq) use ($search) {
                    $dq->where('tag', 'like', "%{$search}%")
                        ->orWhere('meta_title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
        });
    }

    /**
     * Scope a query with standard catalog relations eager loaded.
     */
    public function scopeWithCatalogRelations($query)
    {
        return $query->with([
            'categories',
            'images',
            'special',
            'freeDelivery',
            'productLanding:id,product_id,status',
            'description:id,product_id,description',
        ]);
    }

    /**
     * Scope a query for latest active catalog products with relations.
     */
    public function scopeLatestCatalog($query, int $limit = 4, int $skip = 0)
    {
        $q = $query->active()->withCatalogRelations()->latest('id');
        if ($skip > 0) {
            $q->skip($skip);
        }
        return $q->take($limit);
    }

    /**
     * Fallback scope for best selling showcase products.
     */
    public function scopeBestSellingFallback($query, int $limit = 4)
    {
        return $query->latestCatalog($limit);
    }

    /**
     * Fallback scope for new arrivals showcase products.
     */
    public function scopeNewArrivalsFallback($query, int $limit = 3)
    {
        return $query->latestCatalog($limit);
    }

    /**
     * Fallback scope for customer favorites showcase products.
     */
    public function scopeCustomerFavoritesFallback($query, int $limit = 3, int $skip = 3)
    {
        return $query->latestCatalog($limit, $skip);
    }

    // ========================================
    // Accessors & Mutators
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
