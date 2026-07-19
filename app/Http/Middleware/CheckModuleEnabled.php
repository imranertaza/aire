<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $moduleKey
     */
    public function handle(Request $request, Closure $next, string $moduleKey): Response
    {
        $module = DB::table('modules')->where('module_key', $moduleKey)->first();

        // If the module exists and its status is disabled (0), deny access
        if ($module && $module->status == 0) {
            return response()->json([
                'success' => false,
                'message' => 'This feature is currently disabled.'
            ], 403);
        }

        return $next($request);
    }
}
