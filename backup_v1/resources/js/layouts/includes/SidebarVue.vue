<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <router-link :to="{ name: 'Dashboard' }" class="brand-link">
            <img :src="adminLogo" alt="Store Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AIRE Control</span>
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <!-- ========================================== -->
                    <!-- 1. MAIN OVERVIEW                           -->
                    <!-- ========================================== -->
                    <li class="nav-header">MAIN</li>

                    <!-- Dashboard -->
                    <li class="nav-item">
                        <router-link :to="{ name: 'Dashboard' }" class="nav-link"
                            :class="{ active: $route.name === 'Dashboard' }">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </router-link>
                    </li>

                    <!-- ========================================== -->
                    <!-- 2. SALES & COMMERCE                        -->
                    <!-- ========================================== -->
                    <li class="nav-header"
                        v-if="authStore.hasPermission('view-orders') || authStore.hasPermission('view-customers') || authStore.hasPermission('view-payment-methods') || authStore.hasPermission('view-shipping-methods') || (authStore.hasPermission('view-coupons') && authStore.isModuleEnabled('coupon')) || (authStore.hasPermission('view-offers') && authStore.isModuleEnabled('offer'))">
                        COMMERCE
                    </li>

                    <!-- Orders -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-orders')">
                        <router-link :to="{ name: 'Orders' }" class="nav-link"
                            :class="{ active: ['Orders', 'OrderView'].includes($route.name) }">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Orders</p>
                        </router-link>
                    </li>

                    <!-- Customers -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-customers')"
                        :class="{ 'menu-open': isOpen('customers') }">
                        <a href="#" class="nav-link" @click.prevent="toggle('customers')">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Customers <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview" v-show="isOpen('customers')">
                            <li class="nav-item">
                                <router-link :to="{ name: 'Customers' }" class="nav-link"
                                    :class="{ active: ['Customers', 'UpdateCustomer', 'CustomerLedger'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Customer List</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('create-customers')">
                                <router-link :to="{ name: 'CreateCustomer' }" class="nav-link"
                                    :class="{ active: $route.name === 'CreateCustomer' }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Customer</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <!-- Coupons (Module & Permission Togglable) -->
                    <li class="nav-item" :class="{ 'menu-open': isOpen('coupon') }"
                        v-if="authStore.hasPermission('view-coupons') && authStore.isModuleEnabled('coupon')">
                        <a href="#" class="nav-link" @click.prevent="toggle('coupon')">
                            <i class="nav-icon fas fa-ticket-alt"></i>
                            <p>Coupons <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview" v-show="isOpen('coupon')">
                            <li class="nav-item">
                                <router-link :to="{ name: 'Coupons' }" class="nav-link"
                                    :class="{ active: ['Coupons', 'UpdateCoupon'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Coupons List</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('create-coupons')">
                                <router-link :to="{ name: 'CreateCoupon' }" class="nav-link"
                                    :class="{ active: $route.name === 'CreateCoupon' }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Coupon</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <!-- Offers (Module & Permission Togglable) -->
                    <li class="nav-item" :class="{ 'menu-open': isOpen('offer') }"
                        v-if="authStore.hasPermission('view-offers') && (authStore.isModuleEnabled('offer') || authStore.isModuleEnabled('offers'))">
                        <a href="#" class="nav-link" @click.prevent="toggle('offer')">
                            <i class="nav-icon fas fa-percentage"></i>
                            <p>Special Offers <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview" v-show="isOpen('offer')">
                            <li class="nav-item">
                                <router-link :to="{ name: 'Offers' }" class="nav-link"
                                    :class="{ active: ['Offers', 'UpdateOffer'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Offers List</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('create-offers')">
                                <router-link :to="{ name: 'CreateOffer' }" class="nav-link"
                                    :class="{ active: $route.name === 'CreateOffer' }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Offer</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <!-- Shipping Methods -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-shipping-methods')">
                        <router-link :to="{ name: 'ShippingList' }" class="nav-link"
                            :class="{ active: ['ShippingList', 'ShippingSettings'].includes($route.name) }">
                            <i class="nav-icon fas fa-shipping-fast"></i>
                            <p>Shipping Methods</p>
                        </router-link>
                    </li>

                    <!-- Payment Methods -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-payment-methods')">
                        <router-link :to="{ name: 'PaymentList' }" class="nav-link"
                            :class="{ active: ['PaymentList', 'PaymentSettings'].includes($route.name) }">
                            <i class="nav-icon fas fa-credit-card"></i>
                            <p>Payment Methods</p>
                        </router-link>
                    </li>

                    <!-- ========================================== -->
                    <!-- 3. CATALOG MANAGEMENT                      -->
                    <!-- ========================================== -->
                    <li class="nav-header">CATALOG</li>

                    <!-- Products Dropdown -->
                    <li class="nav-item" :class="{ 'menu-open': isOpen('products') }">
                        <a href="#" class="nav-link" @click.prevent="toggle('products')">
                            <i class="nav-icon fas fa-box-open"></i>
                            <p>Products <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview" v-show="isOpen('products')">
                            <li class="nav-item">
                                <router-link :to="{ name: 'Products' }" class="nav-link"
                                    :class="{ active: ['Products', 'UpdateProduct'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product List</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('create-products')">
                                <router-link :to="{ name: 'CreateProduct' }" class="nav-link"
                                    :class="{ active: $route.name === 'CreateProduct' }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New Product</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{ name: 'AdvancedProducts' }" class="nav-link"
                                    :class="{ active: $route.name === 'AdvancedProducts' }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Advanced Manager</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <!-- Product Categories -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-categories')"
                        :class="{ 'menu-open': isOpen('product-categories') }">
                        <a href="#" class="nav-link" @click.prevent="toggle('product-categories')">
                            <i class="nav-icon fas fa-folder-tree"></i>
                            <p>Categories <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview" v-show="isOpen('product-categories')">
                            <li class="nav-item">
                                <router-link :to="{ name: 'ProductCategories' }" class="nav-link"
                                    :class="{ active: ['ProductCategories', 'UpdateProductCategory', 'ShowProductCategory'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Category List</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('create-categories')">
                                <router-link :to="{ name: 'CreateProductCategory' }" class="nav-link"
                                    :class="{ active: $route.name === 'CreateProductCategory' }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Category</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <!-- Brands -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-brands')"
                        :class="{ 'menu-open': isOpen('brands') }">
                        <a href="#" class="nav-link" @click.prevent="toggle('brands')">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Brands <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview" v-show="isOpen('brands')">
                            <li class="nav-item">
                                <router-link :to="{ name: 'Brands' }" class="nav-link"
                                    :class="{ active: ['Brands', 'UpdateBrand', 'ShowBrand'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Brand List</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('create-brands')">
                                <router-link :to="{ name: 'CreateBrand' }" class="nav-link"
                                    :class="{ active: $route.name === 'CreateBrand' }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Brand</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <!-- Attribute Groups -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-attribute-groups')">
                        <router-link :to="{ name: 'AttributeGroups' }" class="nav-link"
                            :class="{ active: $route.name === 'AttributeGroups' }">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>Attribute Groups</p>
                        </router-link>
                    </li>

                    <!-- Options / Variants -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-options')">
                        <router-link :to="{ name: 'Options' }" class="nav-link"
                            :class="{ active: $route.name === 'Options' }">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Product Options</p>
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="authStore.hasPermission('view-options')">
                        <router-link :to="{ name: 'FilterOptions' }" class="nav-link"
                            :class="{ active: $route.name === 'FilterOptions' }">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Filter Options</p>
                        </router-link>
                    </li>

                    <!-- Color Families -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-color-families')">
                        <router-link :to="{ name: 'ColorFamilyList' }" class="nav-link"
                            :class="{ active: $route.name === 'ColorFamilyList' }">
                            <i class="nav-icon fas fa-palette"></i>
                            <p>Color Families</p>
                        </router-link>
                    </li>

                    <!-- Reviews (Module & Permission Togglable) -->
                    <li class="nav-item"
                        v-if="authStore.hasPermission('view-reviews') && authStore.isModuleEnabled('review')">
                        <router-link :to="{ name: 'Reviews' }" class="nav-link"
                            :class="{ active: $route.name === 'Reviews' }">
                            <i class="nav-icon fas fa-star"></i>
                            <p>Product Reviews</p>
                        </router-link>
                    </li>

                    <!-- ========================================== -->
                    <!-- 4. CONTENT & MARKETING                     -->
                    <!-- ========================================== -->
                    <li class="nav-header">CONTENT</li>

                    <!-- Pages -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-pages')"
                        :class="{ 'menu-open': isOpen('pages') }">
                        <a href="#" class="nav-link" @click.prevent="toggle('pages')">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Pages <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview" v-show="isOpen('pages')">
                            <li class="nav-item">
                                <router-link :to="{ name: 'Pages' }" class="nav-link"
                                    :class="{ active: ['Pages', 'UpdatePages', 'ShowPage'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Page List</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('create-pages')">
                                <router-link :to="{ name: 'CreatePage' }" class="nav-link"
                                    :class="{ active: $route.name === 'CreatePage' }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Page</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <!--  Posts -->
                    <!-- <li class="nav-item" v-if="authStore.hasPermission('view-posts')"
                        :class="{ 'menu-open': isOpen('posts') }">
                        <a href="#" class="nav-link" @click.prevent="toggle('posts')">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>Posts <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview" v-show="isOpen('posts')">
                            <li class="nav-item">
                                <router-link :to="{ name: 'Posts' }" class="nav-link"
                                    :class="{ active: ['Posts', 'UpdatePost', 'ShowPost'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Posts</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('create-posts')">
                                <router-link :to="{ name: 'CreatePost' }" class="nav-link"
                                    :class="{ active: $route.name === 'CreatePost' }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Post</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('view-categories')">
                                <router-link :to="{ name: 'CategoryIndex' }" class="nav-link"
                                    :class="{ active: ['CategoryIndex', 'UpdateCategory', 'CreateCategory', 'CategoryShow'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Post Categories</p>
                                </router-link>
                            </li>
                        </ul>
                    </li> -->

                    <!-- Newsletters -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-newsletters')">
                        <router-link :to="{ name: 'NewsletterList' }" class="nav-link"
                            :class="{ active: ['NewsletterList', 'EmailSend', 'EmailCampaigns'].includes($route.name) }">
                            <i class="nav-icon fas fa-envelope-open-text"></i>
                            <p>Newsletters</p>
                        </router-link>
                    </li>

                    <!-- ========================================== -->
                    <!-- 5. STOREFRONT & APPEARANCE                 -->
                    <!-- ========================================== -->
                    <li class="nav-header">STOREFRONT</li>



                    <!-- Frontend (Sliders & Sections) -->
                    <li class="nav-item"
                        v-if="authStore.hasPermission('view-sliders') || authStore.hasPermission('view-sections')"
                        :class="{ 'menu-open': isOpen('frontend') }">
                        <a href="#" class="nav-link" @click.prevent="toggle('frontend')">
                            <i class="nav-icon fas fa-desktop"></i>
                            <p>Appearance <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview" v-show="isOpen('frontend')">
                            <li class="nav-item" v-if="authStore.hasPermission('view-sliders')">
                                <router-link :to="{ name: 'Sliders' }" class="nav-link"
                                    :class="{ active: ['Sliders', 'CreateSlider', 'UpdateSlider', 'ShowSlider'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sliders & Ads</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('view-sections')">
                                <router-link :to="{ name: 'HomeSections' }" class="nav-link"
                                    :class="{ active: ['HomeSections'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Home Sections</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('view-sections')">
                                <router-link :to="{ name: 'TestimonialsSection' }" class="nav-link"
                                    :class="{ active: ['TestimonialsSection'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Client Testimonials</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('view-sections')">
                                <router-link :to="{ name: 'Section' }" class="nav-link"
                                    :class="{ active: ['Section', 'CreateSection', 'UpdateSection', 'ShowSection'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sections</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <!-- ========================================== -->
                    <!-- 6. USERS & SYSTEM                          -->
                    <!-- ========================================== -->
                    <li class="nav-header">ADMINISTRATION</li>

                    <!-- Manage Users -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-users')"
                        :class="{ 'menu-open': isOpen('users') }">
                        <a href="#" class="nav-link" @click.prevent="toggle('users')">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>User Management <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview" v-show="isOpen('users')">
                            <li class="nav-item">
                                <router-link :to="{ name: 'RolePermission' }" class="nav-link"
                                    :class="{ active: ['RolePermission', 'AdminUserUpdate'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Admin Users</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('update-user-role')">
                                <router-link :to="{ name: 'RolePermissionManager' }" class="nav-link"
                                    :class="{ active: $route.name === 'RolePermissionManager' }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles & Permissions</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <!-- System Settings -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-settings')"
                        :class="{ 'menu-open': isOpen('settings') }">
                        <a href="#" class="nav-link" @click.prevent="toggle('settings')">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>System Settings <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview" v-show="isOpen('settings')">
                            <li class="nav-item">
                                <router-link :to="{ name: 'GeneralSettings' }" class="nav-link"
                                    :class="{ active: $route.name === 'GeneralSettings' }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>General Settings</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('view-geo-zones')">
                                <router-link :to="{ name: 'GeoZones' }" class="nav-link"
                                    :class="{ active: ['GeoZones', 'CreateGeoZone', 'UpdateGeoZone'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Geo Zones & Shipping</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('update-settings')">
                                <router-link :to="{ name: 'MenuManager' }" class="nav-link"
                                    :class="{ active: ['MenuManager', 'ShowMenu'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Menu Settings</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="authStore.hasPermission('view-modules')">
                                <router-link :to="{ name: 'Modules' }" class="nav-link"
                                    :class="{ active: ['Modules', 'ModuleSettings'].includes($route.name) }">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>System Modules</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { useAuthStore } from '../../store/auth'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'
import adminLogo from '@/assets/dist/img/store_logo.png'

const authStore = useAuthStore()
const router = useRouter()
const route = useRoute()

// Track which sidebar sub-menus are currently open
const openMenus = ref({})

/**
 * Toggle the open/closed state of a specific menu
 */
const toggle = (menu) => {
    openMenus.value[menu] = !openMenus.value[menu]
}

/**
 * Check if a specific menu is currently open
 */
const isOpen = (menu) => {
    return !!openMenus.value[menu]
}

/**
 * Automatically open parent menus based on the current route name
 */
const openParentMenus = () => {
    const map = {
        // Products
        'Products': ['products'],
        'CreateProduct': ['products'],
        'UpdateProduct': ['products'],
        'AdvancedProducts': ['products'],

        // Product Categories
        'ProductCategories': ['product-categories'],
        'CreateProductCategory': ['product-categories'],
        'UpdateProductCategory': ['product-categories'],
        'ShowProductCategory': ['product-categories'],

        // Brands
        'Brands': ['brands'],
        'CreateBrand': ['brands'],
        'UpdateBrand': ['brands'],
        'ShowBrand': ['brands'],

        // Customers
        'Customers': ['customers'],
        'CreateCustomer': ['customers'],
        'UpdateCustomer': ['customers'],
        'CustomerLedger': ['customers'],

        // Coupons
        'Coupons': ['coupon'],
        'CreateCoupon': ['coupon'],
        'UpdateCoupon': ['coupon'],

        // Offers
        'Offers': ['offer'],
        'CreateOffer': ['offer'],
        'UpdateOffer': ['offer'],

        // Pages
        'Pages': ['pages'],
        'CreatePage': ['pages'],
        'UpdatePages': ['pages'],
        'ShowPage': ['pages'],

        //Posts
        'Posts': ['posts'],
        'CreatePost': ['posts'],
        'ShowPost': ['posts'],
        'UpdatePost': ['posts'],
        'CategoryIndex': ['posts'],
        'UpdateCategory': ['posts'],
        'CreateCategory': ['posts'],
        'CategoryShow': ['posts'],

        // Newsletters
        'NewsletterList': ['newsletter'],
        'EmailSend': ['newsletter'],

        // Appearance / Frontend
        'Sliders': ['frontend'],
        'CreateSlider': ['frontend'],
        'ShowSlider': ['frontend'],
        'UpdateSlider': ['frontend'],
        'HomeSections': ['frontend'],
        'Section': ['frontend'],
        'CreateSection': ['frontend'],
        'ShowSection': ['frontend'],
        'UpdateSection': ['frontend'],

        // Users / Roles
        'RolePermission': ['users'],
        'RolePermissionManager': ['users'],
        'AdminUserUpdate': ['users'],

        // Settings
        'GeneralSettings': ['settings'],
        'MenuManager': ['settings'],
        'GeoZones': ['settings'],
        'CreateGeoZone': ['settings'],
        'UpdateGeoZone': ['settings'],
        'ShowMenu': ['settings'],
        'Modules': ['settings'],
        'ModuleSettings': ['settings'],
    }

    const current = route.name
    if (map[current]) {
        map[current].forEach(menu => {
            openMenus.value[menu] = true
        })
    }
}

// Open correct menus on initial load and when route changes
onMounted(openParentMenus)
watch(() => route.name, openParentMenus)

/**
 * Handle admin logout: clear auth data and redirect to login
 */
const logout = async () => {
    await axios.post('/api/admin/logout')
    localStorage.clear()
    delete axios.defaults.headers.common['Authorization']
    router.push({ name: 'AdminLogin' })
}
</script>

<style scoped>
.main-sidebar {
    z-index: 100 !important;
}

.nav-header {
    font-size: 0.72rem;
    font-weight: 700;
    color: #6c757d;
    padding: 0.75rem 1rem 0.25rem 1rem;
    letter-spacing: 0.75px;
}
</style>