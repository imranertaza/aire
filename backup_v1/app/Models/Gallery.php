<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $guarded = ['id'];
    protected $table = "gallery";


    public function details()
    {
        return $this->hasMany(GalleryDetail::class, 'gallery_id');
    }
}
