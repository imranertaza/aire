<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $guarded = ['id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->with('children')->orderBy('order'); // recursion
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }


    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function getUrlAttribute()
    {
        switch ($this->link_type) {
            case 'page':
                return $this->page ? route('page.details', $this->page->slug) : '#';
            case 'category':
                // return '';
                return $this->category ? route('post-categories', $this->category->slug) : '#';
            case 'url':
            default:
                return $this->attributes['url'] ?? '#';
        }
    }
}
