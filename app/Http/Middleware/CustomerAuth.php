<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('signin')->withErrors(['email' => 'Please sign in to access this page.']);
        }

        return $next($request);
    }
}
