<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Cache;

class CachedUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return Cache::remember("user_{$identifier}", 3600, function () use ($identifier) {
            $model = $this->createModel();

            return $model->newQuery()
                ->where($model->getAuthIdentifierName(), $identifier)
                ->with(['roles', 'permissions']) // Eager-load Spatie relations to prevent N+1 later
                ->first();
        });
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $model = Cache::remember("user_{$identifier}", 3600, function () use ($identifier) {
            $model = $this->createModel();

            return $model->newQuery()
                ->where($model->getAuthIdentifierName(), $identifier)
                ->with(['roles', 'permissions'])
                ->first();
        });

        if (! $model) {
            return null;
        }

        $rememberToken = $model->getRememberToken();

        return $rememberToken && hash_equals($rememberToken, $token) ? $model : null;
    }
}
