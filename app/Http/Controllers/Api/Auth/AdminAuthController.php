<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * API Controller for admin authentication.
 *
 * Handles admin login, profile retrieval, current user role/permissions,
 * and logout using Laravel Sanctum with Spatie permissions integration.
 */
class AdminAuthController extends Controller
{
    /**
     * Authenticate an admin user and issue a Sanctum token.
     *
     * Revokes all existing tokens before issuing a new one.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);

        $isHttpOnly = filter_var(env('IS_HTTPONLY', false), FILTER_VALIDATE_BOOLEAN);

        if ($isHttpOnly) {
            if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
                $admin = Auth::guard('web')->user();
                $request->session()->regenerate();
                return ApiResponse::success(['admin' => $admin], 'Login successful');
            }
            return response()->json(['message' => 'Invalid credentials'], 401);
        } else {
            $admin = User::where('email', $request->email)->first();
            if (!$admin || !Hash::check($request->password, $admin->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            // $admin->tokens()->delete(); --- IGNORE ---
            $token = $admin->createToken('admin-token', ['*'])->plainTextToken;
            return ApiResponse::success(['admin' => $admin, 'token' => $token], 'Login successful');
        }
    }

    /**
     * Get the authenticated admin user's full profile.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Get the current authenticated admin's role and permissions.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $admin = $request->user();
        $data = Cache::remember("admin_me_{$admin->id}", 3600, function () use ($admin) {
            $modules = DB::table('modules')
                ->where('status', 1)
                ->pluck('module_key');

            return [
                'role' => $admin->roles->pluck('name')->first(),
                'permissions' => $admin->getAllPermissions()->pluck('name'),
                'modules' => $modules,
            ];
        });

        return response()->json($data);
    }

    /**
     * Logout the authenticated admin by revoking all tokens.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $isHttpOnly = filter_var(env('IS_HTTPONLY', false), FILTER_VALIDATE_BOOLEAN);

        if ($isHttpOnly) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } else {
            $request->user()->tokens()->delete();
        }

        return response()->json(['message' => 'Logged out']);
    }
}
