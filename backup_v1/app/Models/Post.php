<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @method static void saved(\Closure|string|array $callback)
 * @method static void deleted(\Closure|string|array $callback)
 */
class Post extends Model
{
    protected $guarded = ['id'];

    /**
     * Relationship: A news item can belong to many categories.
     */
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'category_maps',
            'post_id',
            'category_id'
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



    /**
     * Helper: Sync categories.
     */
    public function syncCategories(array $categoryIds)
    {
        $this->categories()->sync($categoryIds);
    }
}
