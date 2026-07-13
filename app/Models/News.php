<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = ['id'];
    protected $casts   = [
        'status' => 'integer',
    ];
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
