<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Newsletter extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'unsubscribed_at' => 'datetime',
        'status'          => 'integer',
    ];

    /**
     * Bootstrap the model and its traits.
     */
    protected static function booted(): void
    {
        static::creating(function (Newsletter $newsletter) {
            if (empty($newsletter->unsubscribe_token)) {
                $newsletter->unsubscribe_token = Str::random(64);
            }
        });
    }

    /**
     * Get or generate a secure unsubscribe token.
     */
    public function getOrCreateUnsubscribeToken(): string
    {
        if (empty($this->unsubscribe_token)) {
            $this->update(['unsubscribe_token' => Str::random(64)]);
        }

        return $this->unsubscribe_token;
    }

    /**
     * Get the full unsubscribe URL.
     */
    public function getUnsubscribeUrl(): string
    {
        return route('newsletter.unsubscribe', ['token' => $this->getOrCreateUnsubscribeToken()]);
    }

    /**
     * Get the customer associated with the newsletter subscription.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }
}
