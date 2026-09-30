<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $guarded = ['id'];

    /**
     * Get settings for this module.
     */
    public function settings(): HasMany
    {
        return $this->hasMany(ModuleSetting::class, 'module_id');
    }
}
