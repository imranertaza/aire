<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $guarded = ['id'];

    public function categories()
    {
        return $this->belongsToMany(
            BlogCategory::class,
            'blog_category_maps',
            'blog_id',
            'blog_category_id'
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
        return $query->where('status', '1');
    }

    public function syncCategories(array $categoryIds)
    {
        $this->categories()->sync($categoryIds);
    }

    public static function getGamesNews()
    {
        return self::whereHas('categories', function ($query) {
            $query->where('category_name', 'like', '%game%');
        })->paginate(10);
    }
}
