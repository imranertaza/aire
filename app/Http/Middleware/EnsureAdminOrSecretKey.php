<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminOrSecretKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Allow local development and automated testing environments
        if (app()->isLocal() || app()->environment('testing')) {
            return $next($request);
        }

        // 2. Allow authenticated admin (User model via web or sanctum user guard)
        if (auth('web')->check() || auth('user')->check()) {
            return $next($request);
        }

        // 3. Allow secret key from query parameter (?key=... / ?secret=...) or header (X-Maintenance-Secret)
        $configuredKey = config('app.maintenance_secret', env('ADMIN_MAINTENANCE_KEY', 'aire_admin_secret_2026'));
        $providedKey = $request->query('key') ?: ($request->query('secret') ?: $request->header('X-Maintenance-Secret'));

        if (!empty($configuredKey) && !empty($providedKey) && hash_equals((string) $configuredKey, (string) $providedKey)) {
            return $next($request);
        }

        abort(403, 'Unauthorized. Admin authentication or valid maintenance key is required.');
    }
}
