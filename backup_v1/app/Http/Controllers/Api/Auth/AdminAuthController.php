<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Services\Auth\AdminAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * API Controller for admin authentication.
 *
 * Handles admin login, profile retrieval, current user role/permissions,
 * and logout using Laravel Sanctum with Spatie permissions integration.
 */
class AdminAuthController extends Controller
{
    /**
     * AdminAuthController constructor.
     *
     * @param AdminAuthService $authService
     */
    public function __construct(
        protected AdminAuthService $authService
    ) {}

    /**
     * Authenticate an admin user and issue a token or session.
     *
     * @param AdminLoginRequest $request
     * @return JsonResponse
     */
    public function login(AdminLoginRequest $request): JsonResponse
    {
        $request->ensureIsNotRateLimited();

        $result = $this->authService->attemptLogin(
            $request->only('email', 'password'),
            $request
        );

        if (!$result['success']) {
            $request->hitRateLimiter();
            return response()->json(['message' => $result['message']], 401);
        }

        $request->clearRateLimiter();

        return ApiResponse::success($result['data'], $result['message']);
    }

    /**
     * Get the authenticated admin user's full profile.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    /**
     * Get the current authenticated admin's role, permissions, and active modules.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        $data = $this->authService->getAdminPermissionsAndModules($request->user());

        return response()->json($data);
    }

    /**
     * Logout the authenticated admin.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request);

        return response()->json(['message' => 'Logged out']);
    }
}
