<template>
    <nav class="main-header navbar navbar-expand navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <router-link :to="{ name: 'Dashboard' }" class="nav-link">Home</router-link>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <router-link :to="{ name: 'adminProfile' }" class="nav-link">My Profile</router-link>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item">
                <div class="">
                    <button @click="logout" class="btn btn-sm btn-danger nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script setup>
import axios from 'axios';
import { useRouter } from 'vue-router';
const router = useRouter();
/**
 * Handle admin logout process
 */
const logout = async () => {
    await axios.post('/api/admin/logout')
    localStorage.clear()
    delete axios.defaults.headers.common['Authorization']
    router.push({ name: 'AdminLogin' })
}
</script>
<style scoped>
.navbar-dark {
    z-index: 100 !important;
}
</style>
