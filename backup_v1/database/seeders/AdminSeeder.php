<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        try {
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        } catch (\Throwable $e) {
            // Ignored
        }

        // ✅ Guarantee User with ID=1 exists for all foreign key relations
        if (!\Illuminate\Support\Facades\DB::table('users')->where('id', 1)->exists()) {
            \Illuminate\Support\Facades\DB::table('users')->insertOrIgnore([
                'id'         => 1,
                'name'       => 'Super Admin',
                'email'      => 'super@gmail.com',
                'password'   => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $superAdmin = User::firstOrCreate(
            ['email' => 'super@gmail.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('12345678')]
        );

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin', 'password' => Hash::make('12345678')]
        );

        $editor = User::firstOrCreate(
            ['email' => 'editor@gmail.com'],
            ['name' => 'Editor', 'password' => Hash::make('12345678')]
        );

        $viewer = User::firstOrCreate(
            ['email' => 'viewer@gmail.com'],
            ['name' => 'Viewer', 'password' => Hash::make('12345678')]
        );

        // 🧩 Define roles & permissions
        $guard = 'user';
        $roles = ['super-admin', 'admin', 'editor', 'viewer'];

        $permissions = [
            'view-dashboard',
            'view-users','create-users','update-users','delete-users','update-user-role',
            'view-posts','create-posts','edit-posts','delete-posts','publish-posts',
            'view-pages','create-pages','edit-pages','delete-pages','publish-pages',
            'view-categories','create-categories','edit-categories','delete-categories',
            'view-settings','update-settings',
        ];

        // ✅ Create permissions
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => $guard]);
        }

        // ✅ Create roles and assign permissions
        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => $guard]);

            switch ($roleName) {
                case 'super-admin':
                    $role->syncPermissions(Permission::where('guard_name', $guard)->pluck('name'));
                    break;

                case 'admin':
                    $role->syncPermissions([
                        'view-dashboard',
                        'view-users','create-users','update-users','delete-users','update-user-role',
                        'view-posts','create-posts','edit-posts','delete-posts','publish-posts',
                        'view-pages','create-pages','edit-pages','delete-pages','publish-pages',
                        'view-categories','create-categories','edit-categories','delete-categories',
                        'view-settings','update-settings',
                    ]);
                    break;

                case 'editor':
                    $role->syncPermissions([
                        'view-dashboard',
                        'view-posts','create-posts','edit-posts','publish-posts',
                        'view-pages','create-pages','edit-pages','publish-pages',
                        'view-categories','create-categories','edit-categories',
                    ]);
                    break;

                case 'viewer':
                    $role->syncPermissions([
                        'view-dashboard',
                        'view-users',
                        'view-posts',
                        'view-pages',
                        'view-categories',
                        'view-settings',
                    ]);
                    break;
            }
        }

        // Assign roles
        try {
            $superAdmin->assignRole('super-admin');
            $admin->assignRole('admin');
            $editor->assignRole('editor');
            $viewer->assignRole('viewer');
        } catch (\Throwable $e) {
            // Ignored if roles already assigned
        }
    }
}
