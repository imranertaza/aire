<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Service class handling business logic for Admin Users, Roles, and Permissions.
 *
 * Adheres to SOLID (Single Responsibility, Dependency Injection) and DRY principles.
 */
class AdminRoleService
{
    public const CACHE_ROLES_LIST = 'all_roles_list';
    public const CACHE_PERMISSIONS_LIST = 'all_permissions_list';
    public const CACHE_ROLES_WITH_PERMISSIONS = 'all_roles_with_permissions_list';

    /**
     * Retrieve all admin users with their assigned roles.
     *
     * @return array
     */
    public function getAllAdmins(): array
    {
        return User::with('roles')
            ->latest('id')
            ->get()
            ->map(fn(User $admin) => $this->formatUser($admin))
            ->toArray();
    }

    /**
     * Format a single admin user object consistently for API output.
     *
     * @param User $admin
     * @return array
     */
    public function formatUser(User $admin): array
    {
        return [
            'id'    => $admin->id,
            'name'  => $admin->name,
            'email' => $admin->email,
            'role'  => $admin->roles->pluck('name')->first() ?? 'none',
        ];
    }

    /**
     * Get all available user guard roles (cached).
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllRoles()
    {
        return Cache::rememberForever(self::CACHE_ROLES_LIST, function () {
            return Role::where('guard_name', 'user')->pluck('name');
        });
    }

    /**
     * Get all available permissions (cached).
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllPermissions()
    {
        return Cache::rememberForever(self::CACHE_PERMISSIONS_LIST, function () {
            return Permission::where('guard_name', 'user')->pluck('name');
        });
    }

    /**
     * Get all roles along with their respective permissions (cached).
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRolesWithPermissions()
    {
        return Cache::rememberForever(self::CACHE_ROLES_WITH_PERMISSIONS, function () {
            return Role::with('permissions')
                ->where('guard_name', 'user')
                ->get()
                ->map(function ($role) {
                    return [
                        'name'        => $role->name,
                        'permissions' => $role->permissions->pluck('name'),
                    ];
                });
        });
    }

    /**
     * Create a new admin user and assign the specified role.
     *
     * @param array $data
     * @return User
     */
    public function createAdmin(array $data): User
    {
        $admin = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (!empty($data['role'])) {
            $admin->assignRole($data['role']);
        }

        $this->invalidateUserCache($admin->id);

        return $admin->load('roles');
    }

    /**
     * Update an existing admin user's details and role.
     *
     * @param User $admin
     * @param array $data
     * @return User
     * @throws ValidationException
     */
    public function updateAdmin(User $admin, array $data): User
    {
        $this->ensureNotSuperAdmin($admin, 'Cannot modify a super-admin user');

        $admin->name  = $data['name'];
        $admin->email = $data['email'];

        if (!empty($data['password'])) {
            $admin->password = Hash::make($data['password']);
            $admin->tokens()->delete(); // Revoke existing API sessions
        }

        $admin->save();

        if (!empty($data['role'])) {
            $admin->syncRoles([$data['role']]);
        }

        $this->invalidateUserCache($admin->id);

        return $admin->load('roles');
    }

    /**
     * Update only the role of an admin user.
     *
     * @param User $admin
     * @param string $role
     * @return User
     * @throws ValidationException
     */
    public function updateAdminRole(User $admin, string $role): User
    {
        $this->ensureNotSuperAdmin($admin, 'Cannot modify role of a super-admin');

        $admin->syncRoles([$role]);
        $this->invalidateUserCache($admin->id);

        return $admin->load('roles');
    }

    /**
     * Update permissions for a specific role and flush dependent caches.
     *
     * @param string $roleName
     * @param array $permissions
     * @return array
     * @throws ValidationException
     */
    public function updateRolePermissions(string $roleName, array $permissions): array
    {
        $roleModel = Role::where('name', $roleName)
            ->where('guard_name', 'user')
            ->firstOrFail();

        if ($roleModel->name === 'super-admin') {
            throw ValidationException::withMessages([
                'role' => ['Cannot update permissions for super-admin role.'],
            ]);
        }

        $roleModel->syncPermissions($permissions);

        // Invalidate cache for all users who hold this role
        $users = User::role($roleModel->name)->get(['id']);
        foreach ($users as $user) {
            $this->invalidateUserCache($user->id);
        }

        $this->invalidateRoleCache();

        return [
            'role'        => $roleModel->name,
            'permissions' => $roleModel->fresh('permissions')->permissions->pluck('name'),
        ];
    }

    /**
     * Delete an admin user with safety guard against super-admin.
     *
     * @param User $admin
     * @return void
     * @throws ValidationException
     */
    public function deleteAdmin(User $admin): void
    {
        $this->ensureNotSuperAdmin($admin, 'Cannot delete a super-admin user');

        $userId = $admin->id;
        $admin->tokens()->delete();
        $admin->delete();

        $this->invalidateUserCache($userId);
    }

    /**
     * Ensure the given user is not a protected super-admin.
     *
     * @param User $admin
     * @param string $errorMessage
     * @return void
     * @throws ValidationException
     */
    public function ensureNotSuperAdmin(User $admin, string $errorMessage): void
    {
        if ($admin->hasRole('super-admin')) {
            throw ValidationException::withMessages([
                'user' => [$errorMessage],
            ]);
        }
    }

    /**
     * Invalidate caches associated with an admin user.
     *
     * @param int $userId
     * @return void
     */
    public function invalidateUserCache(int $userId): void
    {
        Cache::forget("admin_me_{$userId}");
        Cache::forget("user_{$userId}");
        Cache::forget(AdminDashboardService::CACHE_KEY);
    }

    /**
     * Invalidate role and permission catalog caches.
     *
     * @return void
     */
    public function invalidateRoleCache(): void
    {
        Cache::forget(self::CACHE_ROLES_LIST);
        Cache::forget(self::CACHE_PERMISSIONS_LIST);
        Cache::forget(self::CACHE_ROLES_WITH_PERMISSIONS);
    }
}
