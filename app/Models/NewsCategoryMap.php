<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategoryMap extends Model
{
    protected $table = "news_category_maps";
    protected $guarded = ['id'];
    /**
     * Relationship: belongs to a single News item
     */
    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }

    /**
     * Relationship: belongs to a single NewsCategory
     */
    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }
}
