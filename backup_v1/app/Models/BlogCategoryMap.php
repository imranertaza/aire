<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategoryMap extends Model
{
    protected $table = "blog_category_maps";
    protected $guarded = ['id'];
    /**
     * Relationship: belongs to a single News item
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    /**
     * Relationship: belongs to a single BlogCategory
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
}
