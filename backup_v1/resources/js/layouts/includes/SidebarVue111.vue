<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4 z-50">
        <!-- Brand Logo -->
        <router-link :to="{ name: 'Dashboard' }" class="brand-link">
            <img :src="adminLogo" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AIRE</span>
        </router-link>

        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu">

                    <!-- Dashboard -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-dashboard')">
                        <router-link :to="{ name: 'Dashboard' }" class="nav-link"
                            :class="{ active: $route.name === 'Dashboard' }">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <p>Dashboard</p>
                        </router-link>
                    </li>

                    <!-- Catalog -->
                    <li class="nav-item" v-if="authStore.hasPermission('view-brands')"
                        :class="{ 'menu-open': isOpen('catalog') }">
                        <a href="#" class="nav-link" @click.prevent="toggle('catalog')">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Catalog <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview" v-show="isOpen('catalog')">
                            <!-- Products -->
                            <li class="nav-item" v-if="authStore.hasPermission('view-products')">
                                <router-link :to="{ name: 'Products' }" class="nav-link"
                                    :class="{ active: ['Products', 'CreateProduct', 'UpdateProduct', 'AdvancedProducts'].includes($route.name) }">
                                    <i class="fas fa-box nav-icon"></i>
                                    <p>Products</p>
                                </router-link>
                            </li>
                            <!-- Nested: Manage Product Category -->
                            <li class="nav-item" :class="{ 'menu-open': isOpen('product-category') }"
                                v-if="authStore.hasPermission('view-product-categories')">
                                <a href="#" class="nav-link" @click.prevent="toggle('product-category')">
                                    <i class="nav-icon fas fa-tags"></i>
                                    <p>Product Category <i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview" v-show="isOpen('product-category')">
                                    <li class="nav-item">
                                        <router-link :to="{ name: 'ProductCategories' }" class="nav-link"
                                            :class="{ active: $route.name === 'ProductCategories' }">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Category List</p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item" v-if="authStore.hasPermission('create-product-categories')">
                                        <router-link :to="{ name: 'CreateProductCategory' }" class="nav-link"
                                            :class="{ active: $route.name === 'CreateProductCategory' }">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Create Category</p>
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                            <!-- Nested: Manage Brand -->
                            <li class="nav-item" :class="{ 'menu-open': isOpen('brand') }"
                                v-if="authStore.hasPermission('view-brands')">
                                <a href="#" class="nav-link" @click.prevent="toggle('brand')">
                                    <i class="nav-icon fas fa-folder"></i>
                                    <p>Brand <i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview" v-show="isOpen('brand')">
                                    <li class="nav-item">
                                        <router-link :to="{ name: 'Brands' }" class="nav-link"
                                            :class="{ active: $route.name === 'Brands' }">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Brands List</p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item" v-if="authStore.hasPermission('create-brands')">
                                        <router-link :to="{ name: 'CreateBrand' }" class="nav-link"
                                            :class="{ active: $route.name === 'CreateBrand' }">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Create Brand</p>
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                            <!-- Attribute Group -->
                            <li class="nav-item" v-if="authStore.hasPermission('view-attribute-groups')">
                                <router-link :to="{ name: 'AttributeGroups' }" class="nav-link"
                                    :class="{ active: $route.name === 'AttributeGroups' }">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Attribute Groups</p>
                                </router-link>
                            </li>
                            <!-- Options -->
                            <li class="nav-item" v-if="authStore.hasPermission('view-options')">
                                <router-link :to="{ name: 'Options' }" class="nav-link"
                                    :class="{ active: $route.name === 'Options' }">
                                    <i class="fas fa-sliders-h nav-icon"></i>
                                    <p>Options</p>
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

// Track which sidebar sub-menus are currently open (allows multiple)
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
        // Catalog
        'Brands': ['catalog', 'brand'],
        'CreateBrand': ['catalog', 'brand'],
        'UpdateBrand': ['catalog', 'brand'],
        'ShowBrand': ['catalog', 'brand'],

        // Product Categories
        'ProductCategories': ['catalog', 'product-category'],
        'CreateProductCategory': ['catalog', 'product-category'],
        'UpdateProductCategory': ['catalog', 'product-category'],
        'ShowProductCategory': ['catalog', 'product-category'],

        // Attribute Groups
        'AttributeGroups': ['catalog'],

        // Options
        'Options': ['catalog'],

        // Products
        'Products': ['catalog'],
        'CreateProduct': ['catalog'],
        'UpdateProduct': ['catalog'],
        'AdvancedProducts': ['catalog'],

        // Coupons
        'Coupons': ['catalog', 'coupon'],
        'CreateCoupon': ['catalog', 'coupon'],
        'UpdateCoupon': ['catalog', 'coupon'],

        // Offers
        'Offers': ['catalog', 'offer'],
        'CreateOffer': ['catalog', 'offer'],
        'UpdateOffer': ['catalog', 'offer'],

        // Reviews
        'Reviews': ['catalog'],

        // Customers
        'Customers': ['catalog'],
        'CreateCustomer': ['catalog'],
        'UpdateCustomer': ['catalog'],
        'CustomerLedger': ['catalog'],
        'CustomerPointHistory': ['catalog'],

        // Orders
        'Orders': ['catalog'],
        'OrderView': ['catalog'],

        // Pages
        'Pages': ['pages'],
        'CreatePage': ['pages'],
        'UpdatePages': ['pages'],
        'ShowPage': ['pages'],

        // Posts
        'Posts': ['posts'],
        'CreatePost': ['posts'],
        'ShowPost': ['posts'],
        'UpdatePost': ['posts'],

        // Post Categories
        'CategoryIndex': ['posts', 'categories'],
        'UpdateCategory': ['posts', 'categories'],
        'CreateCategory': ['posts', 'categories'],
        'CategoryShow': ['posts', 'categories'],

        // News
        'News': ['news'],
        'CreateNews': ['news'],
        'ShowNews': ['news'],
        'UpdateNews': ['news'],

        // News Categories (nested under News)
        'NewsCategoryIndex': ['news', 'newsCategories'],
        'NewsCategoryCreate': ['news', 'newsCategories'],
        'UpdateNewsCategory': ['news', 'newsCategories'],
        'NewsCategoryShow': ['news', 'newsCategories'],

        // Blogs
        'Blog': ['blog'],
        'CreateBlog': ['blog'],
        'ShowBlog': ['blog'],
        'UpdateBlog': ['blog'],

        // Sliders
        'Sliders': ['frontend', 'sliders'],
        'CreateSlider': ['frontend', 'sliders'],
        'ShowSlider': ['frontend', 'sliders'],
        'UpdateSlider': ['frontend', 'sliders'],
        'Section': ['frontend', 'sections'],
        'CreateSection': ['frontend', 'sections'],
        'ShowSection': ['frontend', 'sections'],
        'UpdateSection': ['frontend', 'sections'],

        // Blog Categories (nested under Blogs)
        'BlogCategoryIndex': ['blog', 'blogCategories'],
        'BlogCategoryCreate': ['blog', 'blogCategories'],
        'UpdateBlogCategory': ['blog', 'blogCategories'],
        'BlogCategoryShow': ['blog', 'blogCategories'],

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

        // Galleries
        'Gallery': ['galleries'],
        'CreateGallery': ['galleries'],
        'ShowGallery': ['galleries'],

        // Events
        'Events': ['events'],
        'CreateEvent': ['events'],
        'ShowEvent': ['events'],
        'UpdateEvent': ['events'],

        // Event Categories
        'EventCategoryIndex': ['events', 'event-categories'],
        'EventCategoryCreate': ['events', 'event-categories'],
        'UpdateEventCategory': ['events', 'event-categories'],
        'EventCategoryShow': ['events', 'event-categories'],

        // Notices
        'Notices': ['notices'],
        'CreateNotice': ['notices'],
        'ShowNotice': ['notices'],
        'UpdateNotice': ['notices'],

        // Player
        'Players': ['players'],
        'CreatePlayer': ['players'],
        'ShowPlayer': ['players'],
        'UpdatePlayer': ['players'],

        // Committee Members
        'CommitteeMembers': ['committee-members'],
        'CreateCommitteeMembers': ['committee-members'],
        'ShowCommitteeMembers': ['committee-members'],
        'UpdateCommitteeMembers': ['committee-members'],

        // Results
        'Results': ['results'],
        'CreateResult': ['results'],
        'ShowResult': ['results'],
        'UpdateResult': ['results'],
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
</style>
