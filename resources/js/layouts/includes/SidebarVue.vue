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

                    <!-- Catalog -->
                    <li class="nav-item" :class="{ 'menu-open': isOpen('catalog') }">
                        <a href="#" class="nav-link" @click.prevent="toggle('catalog')">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Catalog <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview" v-show="isOpen('catalog')">
                            <!-- Products -->
                            <li class="nav-item" v-if="authStore.hasPermission('view-products')">
                                <router-link :to="{ name: 'Products' }" class="nav-link"
                                    :class="{ active: ['Products', 'CreateProduct', 'UpdateProduct', 'AdvancedProducts'].includes($route.name) }">
                                    <i class="fas fa-box-open nav-icon"></i>
                                    <p>Product List</p>
                                </router-link>
                            </li>
                            <!-- Product Category -->
                            <li class="nav-item" v-if="authStore.hasPermission('view-product-categories')">
                                <router-link :to="{ name: 'ProductCategories' }" class="nav-link"
                                    :class="{ active: $route.name === 'ProductCategories' }">
                                    <i class="fas fa-tags nav-icon"></i>
                                    <p>Product Category</p>
                                </router-link>
                            </li>
                            <!-- Brand -->
                            <li class="nav-item" v-if="authStore.hasPermission('view-brands')">
                                <router-link :to="{ name: 'Brands' }" class="nav-link"
                                    :class="{ active: $route.name === 'Brands' }">
                                    <i class="fas fa-trademark nav-icon"></i>
                                    <p>Brand</p>
                                </router-link>
                            </li>
                            <!-- Attribute Groups -->
                            <li class="nav-item" v-if="authStore.hasPermission('view-attribute-groups')">
                                <router-link :to="{ name: 'AttributeGroups' }" class="nav-link"
                                    :class="{ active: $route.name === 'AttributeGroups' }">
                                    <i class="fas fa-layer-group nav-icon"></i>
                                    <p>Attribute Groups</p>
                                </router-link>
                            </li>
                            <!-- Options -->
                            <li class="nav-item" v-if="authStore.hasPermission('view-options')">
                                <router-link :to="{ name: 'Options' }" class="nav-link"
                                    :class="{ active: $route.name === 'Options' }">
                                    <i class="fas fa-cogs nav-icon"></i>
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
        'Brands': ['catalog'],
        'CreateBrand': ['catalog'],
        'UpdateBrand': ['catalog'],
        'ShowBrand': ['catalog'],
        'ProductCategories': ['catalog'],
        'CreateProductCategory': ['catalog'],
        'UpdateProductCategory': ['catalog'],
        'ShowProductCategory': ['catalog'],
        'AttributeGroups': ['catalog'],
        'Options': ['catalog'],
        'Products': ['catalog'],
        'CreateProduct': ['catalog'],
        'UpdateProduct': ['catalog'],
        'AdvancedProducts': ['catalog'],
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
    
    const isHttpOnly = import.meta.env.VITE_IS_HTTPONLY === 'true';
    if (!isHttpOnly) {
        delete axios.defaults.headers.common['Authorization']
    }
    
    router.push({ name: 'AdminLogin' })
}
</script>
<style scoped>
.main-sidebar {
    z-index: 100 !important;
}
</style>
