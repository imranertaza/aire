<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * Scope a query to only include active customers.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 1);
    }

    /**
     * Scope a query to only include deactivated customers.
     */
    public function scopeDeactivated(Builder $query): Builder
    {
        return $query->where('status', 0);
    }

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'salt',
    ];

    protected static function booted(): void
    {
        static::saving(function ($customer) {
            if ($customer->salt === null) {
                $customer->salt = '';
            }
            if (empty($customer->ip)) {
                $customer->ip = request()?->ip() ?? '127.0.0.1';
            }
            if (empty($customer->unsubscribe_token)) {
                $customer->unsubscribe_token = \Illuminate\Support\Str::random(64);
            }
        });

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget(\App\Services\Admin\AdminDashboardService::CACHE_KEY);
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget(\App\Services\Admin\AdminDashboardService::CACHE_KEY);
        });
    }

    /**
     * Get or generate a secure unsubscribe token.
     */
    public function getOrCreateUnsubscribeToken(): string
    {
        if (empty($this->unsubscribe_token)) {
            $this->update(['unsubscribe_token' => \Illuminate\Support\Str::random(64)]);
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status'     => 'boolean',
            'balance'    => 'decimal:2',
            'point'      => 'integer',
            'newsletter' => 'boolean',
        ];
    }

    /**
     * Get the customer's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim(($this->firstname ?? '') . ' ' . ($this->lastname ?? ''));
    }

    /**
     * Get the orders placed by the customer.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    /**
     * Get the fund deposit requests submitted by the customer.
     */
    public function fundRequests(): HasMany
    {
        return $this->hasMany(FundRequest::class, 'customer_id');
    }

    /**
     * Get the ledger records for the customer.
     */
    public function ledgers(): HasMany
    {
        return $this->hasMany(CustomerLedger::class, 'customer_id');
    }

    /**
     * Get the point history for the customer.
     */
    public function points(): HasMany
    {
        return $this->hasMany(CustomerPointHistory::class, 'customer_id');
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $this->email]);
        \Illuminate\Support\Facades\Mail::to($this->email)->send(
            new \App\Mail\CustomerResetPasswordMail($this, $resetUrl, $token)
        );
    }
}
