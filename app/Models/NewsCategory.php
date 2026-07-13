<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $guarded = ['id'];
    public function children()
    {
        return $this->hasMany(NewsCategory::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(NewsCategory::class, 'parent_id');
    }

    /**
     * Relationship: News items under this category.
     */
    public function news()
    {
        return $this->belongsToMany(
            News::class,
            'news_category_maps',
            'news_category_id',
            'news_id'
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
