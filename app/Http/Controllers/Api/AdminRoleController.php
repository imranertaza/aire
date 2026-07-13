<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * API Controller for managing admin users, roles, and permissions.
 *
 * Provides full CRUD for admin users (with role assiglnment),
 * role/permission management, and safe guards for super-admin.
 */
class AdminRoleController extends Controller
{
    /**
     * Retrieve a list of all admin users with their current role.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $admins = User::with('roles')->get()->map(function ($admin) {
            return [
                'id'    => $admin->id,
                'name'  => $admin->name,
                'email' => $admin->email,
                'role'  => $admin->roles->pluck('name')->first() ?? 'none',
            ];
        });

        return ApiResponse::success($admins, 'User list retrieved successfully');
    }

    /**
     * Retrieve details of a specific admin user.
     *
     * @param User $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $admin)
    {
        $admin->load('roles');

        return ApiResponse::success([
            'id'    => $admin->id,
            'name'  => $admin->name,
            'email' => $admin->email,
            'role'  => $admin->roles->pluck('name')->first() ?? 'none',
        ], 'User fetched successfully');
    }

    /**
     * List all available roles (for user guard).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function roles()
    {
        $roles = Role::where('guard_name', 'user')->pluck('name');

        return ApiResponse::success($roles, 'Available roles retrieved successfully');
    }

    /**
     * Create a new admin user with role assignment.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|string|exists:roles,name,guard_name,user',
        ]);

        $admin = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $admin->assignRole($validated['role']);

        return ApiResponse::success([
            'id'    => $admin->id,
            'name'  => $admin->name,
            'email' => $admin->email,
            'role'  => $validated['role'],
        ], 'User created successfully', 201);
    }

    /**
     * Update an existing admin user (name, email, password, role).
     *
     * Password update revokes all existing tokens.
     *
     * @param Request $request
     * @param User $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request, User $admin)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:6',
            'role'     => 'required|string|exists:roles,name,guard_name,user',
        ]);

        // Prevent changes to super-admin
        if ($admin->hasRole('super-admin')) {
            return ApiResponse::error('Cannot modify a super-admin user', 403);
        }

        $admin->name  = $validated['name'];
        $admin->email = $validated['email'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
            $admin->tokens()->delete(); // Revoke all sessions on password change
        }

        $admin->save();

        $admin->syncRoles([$validated['role']]);

        return ApiResponse::success($admin->fresh('roles'), 'User updated successfully');
    }

    /**
     * Update only the role of an admin user.
     *
     * @param Request $request
     * @param User $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserRole(Request $request, User $admin)
    {
        $validated = $request->validate([
            'role' => 'required|string|exists:roles,name,guard_name,user',
        ]);

        if ($admin->hasRole('super-admin')) {
            return ApiResponse::error('Cannot modify role of a super-admin', 403);
        }

        $admin->syncRoles([$validated['role']]);

        return ApiResponse::success([
            'id'   => $admin->id,
            'role' => $validated['role'],
        ], 'User role updated successfully');
    }

    /**
     * List all roles with their assigned permissions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function rolesWithPermissions()
    {
        $roles = Role::with('permissions')
            ->where('guard_name', 'user')
            ->get()
            ->map(function ($role) {
                return [
                    'name'        => $role->name,
                    'permissions' => $role->permissions->pluck('name'),
                ];
            });

        return ApiResponse::success($roles, 'Roles with permissions retrieved successfully');
    }

    /**
     * Update permissions for a specific role (except super-admin).
     *
     * @param Request $request
     * @param string $role
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function updatePermissions(Request $request, $role)
    {
        $roleModel = Role::where('name', $role)
            ->where('guard_name', 'user')
            ->firstOrFail();

        if ($roleModel->name === 'super-admin') {
            return ApiResponse::error('Cannot update permissions for super-admin role', 403);
        }

        $validated = $request->validate([
            'permissions'   => 'required|array',
            'permissions.*' => 'string|exists:permissions,name,guard_name,user',
        ]);

        $roleModel->syncPermissions($validated['permissions']);

        return ApiResponse::success([
            'role'        => $roleModel->name,
            'permissions' => $roleModel->permissions->pluck('name'),
        ], 'Permissions updated successfully');
    }

    /**
     * List all available permissions (for user guard).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function permissions()
    {
        $permissions = Permission::where('guard_name', 'user')->pluck('name');

        return ApiResponse::success($permissions, 'Available permissions retrieved successfully');
    }

    /**
     * Delete an admin user (super-admin protected).
     *
     * @param User $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $admin)
    {
        if ($admin->hasRole('super-admin')) {
            return ApiResponse::error('Cannot delete a super-admin user', 403);
        }

        $admin->delete();

        return ApiResponse::success(['id' => $admin->id], 'User deleted successfully');
    }
}
