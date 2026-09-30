<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Player extends Model
{
    protected $guarded = ['id'];

    public function getAgeAttribute()
    {
        return $this->birthdate ? Carbon::parse($this->birthdate)->age : null;
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($player) {
            $player->slug = Str::slug(
                $player->name . '-' . $player->position . '-' . $player->sport . '-' . $player->age
            );
        });

        static::updating(function ($player) {
            $player->slug = Str::slug(
                $player->name . '-' . $player->position . '-' . $player->sport . '-' . $player->age
            );
        });

    }
}
