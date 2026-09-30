<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryMap extends Model
{
    protected $table = "category_maps";
    protected $guarded = ['id'];
    /**
     * Relationship: belongs to a single News item
     */
    public function news()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /**
     * Relationship: belongs to a single NewsCategory
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
