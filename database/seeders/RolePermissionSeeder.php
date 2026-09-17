<?php

namespace Database\Seeders;

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

        // 🧩 Comprehensive permissions list
        $permissions = [
            // 1. Dashboard
            'view-dashboard',

            // 2. User Management
            'view-users',
            'create-users',
            'update-users',
            'delete-users',
            'update-user-role',
            'update-permissions',

            // 3. Orders & Commerce
            'view-orders',
            'edit-orders',
            'delete-orders',

            // 4. Customers
            'view-customers',
            'create-customers',
            'edit-customers',
            'delete-customers',

            // 5. Coupons
            'view-coupons',
            'create-coupons',
            'edit-coupons',
            'delete-coupons',

            // 6. Offers
            'view-offers',
            'create-offers',
            'edit-offers',
            'delete-offers',

            // 7. Products
            'view-products',
            'create-products',
            'edit-products',
            'delete-products',

            // 8. Product Categories
            'view-product-categories',
            'create-product-categories',
            'edit-product-categories',
            'delete-product-categories',

            // 9. Brands
            'view-brands',
            'create-brands',
            'edit-brands',
            'delete-brands',

            // 10. Attribute Groups
            'view-attribute-groups',
            'create-attribute-groups',
            'edit-attribute-groups',
            'delete-attribute-groups',

            // 11. Options / Variants
            'view-options',
            'create-options',
            'edit-options',
            'delete-options',

            // 12. Color Families
            'view-color-families',
            'create-color-families',
            'edit-color-families',
            'delete-color-families',

            // 13. Reviews
            'view-reviews',
            'create-reviews',
            'edit-reviews',
            'delete-reviews',

            // 14. Pages CRUD
            'view-pages',
            'create-pages',
            'edit-pages',
            'delete-pages',
            'publish-pages',

            // 15. Blog / Posts CRUD
            'view-posts',
            'create-posts',
            'edit-posts',
            'delete-posts',
            'publish-posts',

            // 16. Post Categories CRUD
            'view-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',

            // 17. Newsletters & Emails
            'view-newsletters',
            'send-emails',
            'delete-newsletters',

            // 18. Storefront & Theme Builder
            'theme-builder',
            'manage-frontend',

            // 19. Sliders & Ads
            'view-sliders',
            'create-sliders',
            'edit-sliders',
            'delete-sliders',

            // 20. Homepage Sections
            'view-sections',
            'create-sections',
            'edit-sections',
            'delete-sections',

            // 21. Shipping Methods
            'view-shipping-methods',
            'create-shipping-methods',
            'edit-shipping-methods',
            'delete-shipping-methods',

            // 22. Geo Zones
            'view-geo-zones',
            'create-geo-zones',
            'edit-geo-zones',
            'delete-geo-zones',

            // 23. Payment Methods
            'view-payment-methods',
            'create-payment-methods',
            'edit-payment-methods',
            'delete-payment-methods',

            // 24. System Settings & Menus
            'view-settings',
            'update-settings',
            'manage-menus',

            // 25. Modules
            'view-modules',
            'edit-modules',

            // 26. Additional legacy / pluggable items
            'view-blog',
            'create-blog',
            'edit-blog',
            'delete-blog',
            'publish-blog',
            'view-blog-categories',
            'create-blog-categories',
            'edit-blog-categories',
            'delete-blog-categories',
            'view-news',
            'create-news',
            'edit-news',
            'delete-news',
            'publish-news',
            'view-news-categories',
            'create-news-categories',
            'edit-news-categories',
            'delete-news-categories',
            'view-galleries',
            'create-galleries',
            'edit-galleries',
            'delete-galleries',
            'publish-galleries',
            'view-events',
            'create-events',
            'edit-events',
            'delete-events',
            'view-events-categories',
            'create-events-categories',
            'edit-events-categories',
            'delete-events-categories',
            'view-notices',
            'create-notices',
            'edit-notices',
            'delete-notices',
            'view-players',
            'create-players',
            'edit-players',
            'delete-players',
            'view-results',
            'create-results',
            'edit-results',
            'delete-results',
            'manage-committee-members',
            'view-fund-requests',
        ];

        // ✅ Create all permissions in database
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => $guard]);
        }

        // ✅ Assign permissions to roles
        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => $guard]);

            switch ($roleName) {
                case 'super-admin':
                    // Full access to every permission
                    $role->syncPermissions(Permission::where('guard_name', $guard)->pluck('name'));
                    break;

                case 'admin':
                    // Full management rights
                    $role->syncPermissions([
                        'view-dashboard',

                        // Users
                        'view-users',
                        'create-users',
                        'update-users',
                        'delete-users',
                        'update-user-role',

                        // Commerce
                        'view-orders',
                        'edit-orders',
                        'delete-orders',
                        'view-customers',
                        'create-customers',
                        'edit-customers',
                        'delete-customers',
                        'view-coupons',
                        'create-coupons',
                        'edit-coupons',
                        'delete-coupons',
                        'view-offers',
                        'create-offers',
                        'edit-offers',
                        'delete-offers',
                        'view-shipping-methods',
                        'create-shipping-methods',
                        'edit-shipping-methods',
                        'delete-shipping-methods',
                        'view-payment-methods',
                        'create-payment-methods',
                        'edit-payment-methods',

                        // Catalog
                        'view-products',
                        'create-products',
                        'edit-products',
                        'delete-products',
                        'view-product-categories',
                        'create-product-categories',
                        'edit-product-categories',
                        'delete-product-categories',
                        'view-brands',
                        'create-brands',
                        'edit-brands',
                        'delete-brands',
                        'view-attribute-groups',
                        'create-attribute-groups',
                        'edit-attribute-groups',
                        'delete-attribute-groups',
                        'view-options',
                        'create-options',
                        'edit-options',
                        'delete-options',
                        'view-color-families',
                        'create-color-families',
                        'edit-color-families',
                        'delete-color-families',
                        'view-reviews',
                        'create-reviews',
                        'edit-reviews',
                        'delete-reviews',

                        // Content
                        'view-pages',
                        'create-pages',
                        'edit-pages',
                        'delete-pages',
                        'publish-pages',
                        'view-posts',
                        'create-posts',
                        'edit-posts',
                        'delete-posts',
                        'publish-posts',
                        'view-categories',
                        'create-categories',
                        'edit-categories',
                        'delete-categories',
                        'view-newsletters',
                        'send-emails',

                        // Storefront & Design
                        'theme-builder',
                        'manage-frontend',
                        'view-sliders',
                        'create-sliders',
                        'edit-sliders',
                        'delete-sliders',
                        'view-sections',
                        'create-sections',
                        'edit-sections',
                        'delete-sections',

                        // System Settings
                        'view-settings',
                        'update-settings',
                        'manage-menus',
                        'view-geo-zones',
                        'create-geo-zones',
                        'edit-geo-zones',
                        'delete-geo-zones',
                        'view-modules',
                        'edit-modules',
                    ]);
                    break;

                case 'editor':
                    $role->syncPermissions([
                        'view-dashboard',

                        // Commerce
                        'view-orders',
                        'edit-orders',
                        'view-customers',
                        'create-customers',
                        'edit-customers',
                        'view-coupons',
                        'create-coupons',
                        'edit-coupons',
                        'view-offers',
                        'create-offers',
                        'edit-offers',
                        'view-shipping-methods',
                        'view-payment-methods',

                        // Catalog
                        'view-products',
                        'create-products',
                        'edit-products',
                        'view-product-categories',
                        'create-product-categories',
                        'edit-product-categories',
                        'view-brands',
                        'create-brands',
                        'edit-brands',
                        'view-attribute-groups',
                        'create-attribute-groups',
                        'edit-attribute-groups',
                        'view-options',
                        'create-options',
                        'edit-options',
                        'view-color-families',
                        'create-color-families',
                        'edit-color-families',
                        'view-reviews',
                        'edit-reviews',

                        // Content
                        'view-pages',
                        'create-pages',
                        'edit-pages',
                        'publish-pages',
                        'view-posts',
                        'create-posts',
                        'edit-posts',
                        'publish-posts',
                        'view-categories',
                        'create-categories',
                        'edit-categories',
                        'view-newsletters',
                        'send-emails',

                        // Storefront & Design
                        'view-sliders',
                        'create-sliders',
                        'edit-sliders',
                        'view-sections',
                        'create-sections',
                        'edit-sections',
                    ]);
                    break;

                case 'viewer':
                    $role->syncPermissions([
                        'view-dashboard',
                        'view-orders',
                        'view-customers',
                        'view-coupons',
                        'view-offers',
                        'view-products',
                        'view-product-categories',
                        'view-brands',
                        'view-attribute-groups',
                        'view-options',
                        'view-color-families',
                        'view-reviews',
                        'view-pages',
                        'view-posts',
                        'view-categories',
                        'view-newsletters',
                        'view-sliders',
                        'view-sections',
                        'view-settings',
                    ]);
                    break;
            }
        }
    }
}