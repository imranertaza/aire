<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAuthService
{
    /**
     * Attempt admin authentication and return result with token/user details.
     *
     * @param Request $request
     * @return array ['success' => bool, 'message' => string, 'data' => ?array]
     */
    public function attemptLogin(array $credentials, Request $request): array
    {
        $isHttpOnly = (bool) config('auth.is_httponly', false);

        if ($isHttpOnly) {
            if (Auth::guard('web')->attempt($credentials, $request->boolean('remember', false))) {
                /** @var User $admin */
                $admin = Auth::guard('web')->user();
                $request->session()->regenerate();

                return [
                    'success' => true,
                    'message' => 'Login successful',
                    'data'    => [
                        'admin' => $admin,
                    ],
                ];
            }

            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'data'    => null,
            ];
        }

        /** @var User|null $admin */
        $admin = User::query()->where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'data'    => null,
            ];
        }

        $token = $admin->createToken('admin-token', ['*'])->plainTextToken;

        return [
            'success' => true,
            'message' => 'Login successful',
            'data'    => [
                'admin' => $admin,
                'token' => $token,
            ],
        ];
    }

    /**
     * Get cached role, permissions, and active modules for the admin.
     *
     * @param User $admin
     * @return array
     */
    public function getAdminPermissionsAndModules(User $admin): array
    {
        return Cache::remember("admin_me_{$admin->id}", 3600, function () use ($admin) {
            $modules = DB::table('modules')
                ->where('status', 1)
                ->pluck('module_key');

            return [
                'role'        => $admin->roles->pluck('name')->first(),
                'permissions' => $admin->getAllPermissions()->pluck('name'),
                'modules'     => $modules,
            ];
        });
    }

    /**
     * Clear cached admin permissions and modules.
     *
     * @param int $adminId
     * @return void
     */
    public function clearAdminPermissionsCache(int $adminId): void
    {
        Cache::forget("admin_me_{$adminId}");
    }

    /**
     * Log the admin out by revoking tokens or invalidating the web session.
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request): void
    {
        $isHttpOnly = (bool) config('auth.is_httponly', false);

        if ($isHttpOnly) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } else {
            $user = $request->user();
            if ($user && method_exists($user, 'tokens')) {
                $user->tokens()->delete();
            }
        }
    }
}
