<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relationship: News items under this category.
     */
    public function posts()
    {
        return $this->belongsToMany(
            Post::class,
            'category_maps',
            'category_id',
            'post_id'
        );
    }


    /**
     * Scope: Active categories only.
     */
    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
}
