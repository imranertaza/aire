<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $guarded = ['id'];
    public function children()
    {
        return $this->hasMany(BlogCategory::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id');
    }

    /**
     * Relationship: News items under this category.
     */
    public function blogs()
    {
        return $this->belongsToMany(
            Blog::class,
            'blog_category_maps',
            'blog_category_id',
            'blog_id'
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
