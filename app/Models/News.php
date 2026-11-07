<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class News extends Model
{
    protected $guarded = ['id'];
    protected $casts   = [
        'status' => 'integer',
    ];

    protected static function booted()
    {
        static::saved(function ($news) {
            static::clearNewsCache($news);
        });

        static::deleted(function ($news) {
            static::clearNewsCache($news);
        });
    }

    /**
     * Clear all news-related caches.
     */
    public static function clearNewsCache(?News $news = null): void
    {
        Cache::forget('storefront_about_news_v1');
        Cache::forget('storefront_news_featured_v1');
        Cache::forget('storefront_news_categories_v1');

        if ($news) {
            if (!empty($news->slug)) {
                Cache::forget("storefront_news_detail_{$news->slug}");
            }
            if ($news->isDirty('slug') && $news->getOriginal('slug')) {
                Cache::forget("storefront_news_detail_{$news->getOriginal('slug')}");
            }
            if (!empty($news->id)) {
                Cache::forget("storefront_news_detail_{$news->id}");
                Cache::forget("storefront_news_related_{$news->id}");
            }
        }
    }
    /**
     * Relationship: A news item can belong to many categories.
     */
    public function categories()
    {
        return $this->belongsToMany(
            NewsCategory::class,
            'news_category_maps',
            'news_id',
            'news_category_id'
        );
    }

    /**
     * Creator relationship.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }

    /**
     * Updater relationship.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updatedBy');
    }

    /**
     * Scope: Published news only.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Helper: Sync categories.
     */
    public function syncCategories(array $categoryIds)
    {
        $this->categories()->sync($categoryIds);
    }

    public static function getGamesNews()
    {
        return self::where('status', 1)->whereHas('categories', function ($query) {
            $query->where('category_name', 'like', '%game%');
        })->paginate(10);
    }
    public static function getSpotlightNews()
    {
        return self::where('status', 1)->whereHas('categories', function ($query) {
            $query->where('category_name', 'like', '%spotlight%');
        })->paginate(10);
    }
     public static function getFeaturedNews()
    {
        return self::where('status', 1)->whereHas('categories', function ($query) {
            $query->where('category_name', 'like', '%featured%');
        })->paginate(5);
    }
}
