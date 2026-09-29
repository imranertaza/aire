<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\AdminRoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * API Controller for managing admin users, roles, and permissions.
 *
 * Adheres to SOLID (Single Responsibility, Dependency Inversion) and DRY principles
 * by delegating business logic and cache management to AdminRoleService.
 */
class AdminRoleController extends Controller
{
    /**
     * @param AdminRoleService $roleService
     */
    public function __construct(
        protected AdminRoleService $roleService
    ) {}

    /**
     * Retrieve a list of all admin users with their current role.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $admins = $this->roleService->getAllAdmins();
        return ApiResponse::success($admins, 'User list retrieved successfully');
    }

    /**
     * Retrieve details of a specific admin user.
     *
     * @param User $admin
     * @return JsonResponse
     */
    public function show(User $admin): JsonResponse
    {
        $admin->load('roles');
        return ApiResponse::success($this->roleService->formatUser($admin), 'User fetched successfully');
    }

    /**
     * List all available roles (for user guard).
     *
     * @return JsonResponse
     */
    public function roles(): JsonResponse
    {
        $roles = $this->roleService->getAllRoles();
        return ApiResponse::success($roles, 'Available roles retrieved successfully');
    }

    /**
     * Create a new admin user with role assignment.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|string|exists:roles,name,guard_name,user',
        ]);

        $admin = $this->roleService->createAdmin($validated);

        return ApiResponse::success(
            $this->roleService->formatUser($admin),
            'User created successfully',
            201
        );
    }

    /**
     * Update an existing admin user (name, email, password, role).
     *
     * @param Request $request
     * @param User $admin
     * @return JsonResponse
     */
    public function updateUser(Request $request, User $admin): JsonResponse
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:6',
            'role'     => 'required|string|exists:roles,name,guard_name,user',
        ]);

        try {
            $updatedAdmin = $this->roleService->updateAdmin($admin, $validated);
            return ApiResponse::success(
                $this->roleService->formatUser($updatedAdmin),
                'User updated successfully'
            );
        } catch (ValidationException $e) {
            return ApiResponse::error($e->getMessage(), 403);
        }
    }

    /**
     * Update only the role of an admin user.
     *
     * @param Request $request
     * @param User $admin
     * @return JsonResponse
     */
    public function updateUserRole(Request $request, User $admin): JsonResponse
    {
        $validated = $request->validate([
            'role' => 'required|string|exists:roles,name,guard_name,user',
        ]);

        try {
            $updatedAdmin = $this->roleService->updateAdminRole($admin, $validated['role']);
            return ApiResponse::success(
                $this->roleService->formatUser($updatedAdmin),
                'User role updated successfully'
            );
        } catch (ValidationException $e) {
            return ApiResponse::error($e->getMessage(), 403);
        }
    }

    /**
     * List all roles with their assigned permissions.
     *
     * @return JsonResponse
     */
    public function rolesWithPermissions(): JsonResponse
    {
        $roles = $this->roleService->getRolesWithPermissions();
        return ApiResponse::success($roles, 'Roles with permissions retrieved successfully');
    }

    /**
     * Update permissions for a specific role (except super-admin).
     *
     * @param Request $request
     * @param string $role
     * @return JsonResponse
     */
    public function updatePermissions(Request $request, string $role): JsonResponse
    {
        $validated = $request->validate([
            'permissions'   => 'required|array',
            'permissions.*' => 'string|exists:permissions,name,guard_name,user',
        ]);

        try {
            $result = $this->roleService->updateRolePermissions($role, $validated['permissions']);
            return ApiResponse::success($result, 'Permissions updated successfully');
        } catch (ValidationException $e) {
            return ApiResponse::error($e->getMessage(), 403);
        }
    }

    /**
     * List all available permissions (for user guard).
     *
     * @return JsonResponse
     */
    public function permissions(): JsonResponse
    {
        $permissions = $this->roleService->getAllPermissions();
        return ApiResponse::success($permissions, 'Available permissions retrieved successfully');
    }

    /**
     * Delete an admin user (super-admin protected).
     *
     * @param User $admin
     * @return JsonResponse
     */
    public function destroy(User $admin): JsonResponse
    {
        try {
            $this->roleService->deleteAdmin($admin);
            return ApiResponse::success(['id' => $admin->id], 'User deleted successfully');
        } catch (ValidationException $e) {
            return ApiResponse::error($e->getMessage(), 403);
        }
    }
}
