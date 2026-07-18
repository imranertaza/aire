<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guard = 'user';

        // 🧩 Define roles
        $roles = ['super-admin', 'admin', 'editor', 'viewer'];

        // 🧩 Define permissions (expanded)
        $permissions = [
            // Dashboard
            'view-dashboard',

            // User management
            'view-users',
            'create-users',
            'update-users',
            'delete-users',
            'update-user-role',

            // Posts CRUD
            'view-posts',
            'create-posts',
            'edit-posts',
            'delete-posts',
            'publish-posts',

            // Pages CRUD
            'view-pages',
            'create-pages',
            'edit-pages',
            'delete-pages',
            'publish-pages',

            // Categories CRUD
            'view-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',

            // ✅ News Categories CRUD
            'view-news-categories',
            'create-news-categories',
            'edit-news-categories',
            'delete-news-categories',


            // ✅ Blog Categories CRUD
            'view-blog-categories',
            'create-blog-categories',
            'edit-blog-categories',
            'delete-blog-categories',

            // ✅ Galleries CRUD
            'view-galleries',
            'create-galleries',
            'edit-galleries',
            'delete-galleries',
            'publish-galleries',

            // ✅ Events CRUD
            'view-events',
            'create-events',
            'edit-events',
            'delete-events',

            // ✅ Event Categories CRUD
            'view-events-categories',
            'create-events-categories',
            'edit-events-categories',
            'delete-events-categories',

            // ✅ Notices CRUD
            'view-notices',
            'create-notices',
            'edit-notices',
            'delete-notices',

            // ✅ Players CRUD
            // View-players
            'view-players',
            // Create-players
            'create-players',
            // Edit-players
            'edit-players',
            // Delete-players
            'delete-players',

            // ✅ Results CRUD
            'view-results',
            'create-results',
            'edit-results',
            'delete-results',

            // ✅ Brands CRUD
            'view-brands',
            'create-brands',
            'edit-brands',
            'delete-brands',

            // ✅ Product Categories CRUD
            'view-product-categories',
            'create-product-categories',
            'edit-product-categories',
            'delete-product-categories',

            // ✅ Product Attribute Groups CRUD
            'view-attribute-groups',
            'create-attribute-groups',
            'edit-attribute-groups',
            'delete-attribute-groups',

            // ✅ Options CRUD
            'view-options',
            'create-options',
            'edit-options',
            'delete-options',

            // ✅ Products CRUD
            'view-products',
            'create-products',
            'edit-products',
            'delete-products',

            // ✅ Coupons CRUD
            'view-coupons',
            'create-coupons',
            'edit-coupons',
            'delete-coupons',

            // ✅ Customers CRUD
            'view-customers',
            'create-customers',
            'edit-customers',
            'delete-customers',

            // ✅ Orders CRUD
            'view-orders',
            'edit-orders',
            'delete-orders',

            // ✅ Offers CRUD
            'view-offers',
            'create-offers',
            'edit-offers',
            'delete-offers',

            // ✅ Reviews CRUD
            'view-reviews',
            'edit-reviews',
            'delete-reviews',

            // ✅ Shipping Methods
            'view-shipping-methods',
            'edit-shipping-methods',

            // ✅ Payment Methods
            'view-payment-methods',
            'edit-payment-methods',


            // ✅ News
            'view-news',
            'create-news',
            'edit-news',
            'delete-news',
            'publish-news',

            // ✅ Blog
            'view-blog',
            'create-blog',
            'edit-blog',
            'delete-blog',
            'publish-blog',

            // Settings
            'view-settings',
            'update-settings',

            // Section
            'manage-frontend',
            'manage-committee-members',

            'manage-menus',

            // Permissions management
            'update-permissions',
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
                    // Full access
                    $role->syncPermissions(Permission::where('guard_name', $guard)->pluck('name'));
                    break;

                case 'admin':
                    $role->syncPermissions([
                        'view-dashboard',

                        // User management
                        'view-users',
                        'create-users',
                        'update-users',
                        'delete-users',
                        'update-user-role',

                        // Posts
                        'view-posts',
                        'create-posts',
                        'edit-posts',
                        'delete-posts',
                        'publish-posts',

                        // Pages
                        'view-pages',
                        'create-pages',
                        'edit-pages',
                        'delete-pages',
                        'publish-pages',

                        // Post Categories
                        'view-categories',
                        'create-categories',
                        'edit-categories',
                        'delete-categories',

                        // ✅ News Categories CRUD
                        'view-news-categories',
                        'create-news-categories',
                        'edit-news-categories',
                        'delete-news-categories',

                        // ✅ News Categories CRUD
                        'view-blog-categories',
                        'create-blog-categories',
                        'edit-blog-categories',
                        'delete-blog-categories',

                        // ✅ Results CRUD
                        'view-results',
                        'create-results',
                        'edit-results',
                        'delete-results',

                        // ✅ Brands CRUD
                        'view-brands',
                        'create-brands',
                        'edit-brands',
                        'delete-brands',

                        // ✅ Product Categories CRUD
                        'view-product-categories',
                        'create-product-categories',
                        'edit-product-categories',
                        'delete-product-categories',

                        // ✅ Product Attribute Groups CRUD
                        'view-attribute-groups',
                        'create-attribute-groups',
                        'edit-attribute-groups',
                        'delete-attribute-groups',

                        // ✅ Options CRUD
                        'view-options',
                        'create-options',
                        'edit-options',
                        'delete-options',

                        // ✅ Products CRUD
                        'view-products',
                        'create-products',
                        'edit-products',
                        'delete-products',

                        // ✅ Coupons CRUD
                        'view-coupons',
                        'create-coupons',
                        'edit-coupons',
                        'delete-coupons',

                        // ✅ Customers CRUD
                        'view-customers',
                        'create-customers',
                        'edit-customers',
                        'delete-customers',

                        // ✅ Orders CRUD
                        'view-orders',
                        'edit-orders',
                        'delete-orders',

                        // ✅ Offers CRUD
                        'view-offers',
                        'create-offers',
                        'edit-offers',
                        'delete-offers',

                        // ✅ Reviews CRUD
                        'view-reviews',
                        'edit-reviews',
                        'delete-reviews',

                        // ✅ Shipping Methods
                        'view-shipping-methods',
                        'edit-shipping-methods',

            // ✅ Payment Methods
            'view-payment-methods',
            'edit-payment-methods',


                        // ✅ Galleries CRUD
                        'view-galleries',
                        'create-galleries',
                        'edit-galleries',
                        'delete-galleries',
                        'publish-galleries',

                        // ✅ Events CRUD
                        'view-events',
                        'create-events',
                        'edit-events',
                        'delete-events',

                        // ✅ Event Categories CRUD
                        'view-events-categories',
                        'create-events-categories',
                        'edit-events-categories',
                        'delete-events-categories',

                        // ✅ Notices CRUD
                        'view-notices',
                        'create-notices',
                        'edit-notices',
                        'delete-notices',

                        // ✅ News
                        'view-news',
                        'create-news',
                        'edit-news',
                        'delete-news',
                        'publish-news',

                        // ✅ News
                        'view-blog',
                        'create-blog',
                        'edit-blog',
                        'delete-blog',
                        'publish-blog',


                        'manage-frontend',
                        'manage-committee-members',

                        // Players CRUD
                        'view-players',
                        'create-players',
                        'edit-players',
                        'delete-players',

                        // Settings
                        'view-settings',
                        'update-settings',
                        'update-permissions',
                        'manage-menus',

                    ]);
                    break;

                case 'editor':
                    $role->syncPermissions([
                        'view-dashboard',

                        // Posts
                        'view-posts',
                        'create-posts',
                        'edit-posts',
                        'publish-posts',

                        // Pages
                        'view-pages',
                        'create-pages',
                        'edit-pages',
                        'publish-pages',

                        // Categories
                        'view-categories',
                        'create-categories',
                        'edit-categories',

                        // ✅ News Categories (editor can manage but not delete)
                        'view-news-categories',
                        'create-news-categories',
                        'edit-news-categories',

                        // ✅ News Categories (editor can manage but not delete)
                        'view-blog-categories',
                        'create-blog-categories',
                        'edit-blog-categories',

                        // ✅ Galleries (editor can manage but not delete)
                        'view-galleries',
                        'create-galleries',
                        'edit-galleries',
                        'publish-galleries',

                        // ✅ Events CRUD
                        'view-events',
                        'create-events',
                        'edit-events',

                        // ✅ Event Categories CRUD
                        'view-events-categories',
                        'create-events-categories',
                        'edit-events-categories',

                        // ✅ Notices CRUD
                        'view-notices',
                        'create-notices',
                        'edit-notices',

                        // ✅ News
                        'view-news',
                        'create-news',
                        'edit-news',
                        'delete-news',

                        // ✅ News
                        'view-blog',
                        'create-blog',
                        'edit-blog',
                        'delete-blog',

                        // ✅ Results CRUD
                        'view-results',
                        'create-results',
                        'edit-results',

                        // ✅ Brands CRUD
                        'view-brands',
                        'create-brands',
                        'edit-brands',

                        // ✅ Product Categories CRUD
                        'view-product-categories',
                        'create-product-categories',
                        'edit-product-categories',

                        // ✅ Product Attribute Groups CRUD
                        'view-attribute-groups',
                        'create-attribute-groups',
                        'edit-attribute-groups',

                        // ✅ Options CRUD
                        'view-options',
                        'create-options',
                        'edit-options',

                        // ✅ Products CRUD
                        'view-products',
                        'create-products',
                        'edit-products',

                        // ✅ Coupons CRUD
                        'view-coupons',
                        'create-coupons',
                        'edit-coupons',

                        // ✅ Customers CRUD
                        'view-customers',
                        'create-customers',
                        'edit-customers',

                        // ✅ Orders CRUD
                        'view-orders',
                        'edit-orders',

                        // ✅ Offers CRUD
                        'view-offers',
                        'create-offers',
                        'edit-offers',

                        // ✅ Reviews CRUD
                        'view-reviews',
                        'edit-reviews',
                        
                        // ✅ Shipping Methods
                        'view-shipping-methods',
                        'edit-shipping-methods',

            // ✅ Payment Methods
            'view-payment-methods',
            'edit-payment-methods',
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

                        'view-product-categories',
                        'view-attribute-groups',
                        'view-options',
                        'view-products',
                        'view-coupons',
                        'view-offers',
                        'view-reviews',
                        'view-customers',
                        'view-orders',
                        'view-shipping-methods',

                        'view-news-categories',
                        'view-blog-categories',

                        'view-galleries',

                        // ✅ Events
                        'view-events',
                        'view-events-categories',

                        // ✅ Notices CRUD
                        'view-notices',

                        // ✅ News
                        'view-news',
                        // ✅ Blog
                        'view-blog',

                        // ✅ Results CRUD
                        'view-results',

                        // ✅ Brands CRUD
                        'view-brands',

                        // ✅ Product Categories CRUD
                        'view-product-categories',

                        // ✅ Product Attribute Groups CRUD
                        'view-attribute-groups',
                    ]);
                    break;
            }
        }
    }
}
