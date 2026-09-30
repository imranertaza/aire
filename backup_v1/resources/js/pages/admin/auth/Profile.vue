<template>
    <DashboardHeader title="Admin Profile" />

    <section class="">
        <div class="row container-fluid">
            <div v-if="user">
                <h4>Welcome, {{ user?.name }}</h4>
                <p>Email: {{ user?.email }}</p>
                <button class="btn btn-danger" @click="logout">Logout</button>
            </div>
        </div>
    </section>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { useToast } from '../../../composables/useToast';

// Currently authenticated admin user data
const user = ref(null);

// Router instance for navigation
const router = useRouter();

// Toast helper for success/error notifications
const toast = useToast();

/**
 * Fetch the authenticated admin profile on component mount
 */
onMounted(async () => {
    try {
        const { data } = await axios.get('/api/admin/profile');
        user.value = data; // Typically { id, name, email, ... }
    } catch (error) {
        toast.validationError(error);
    }
});

/**
 * Handle admin logout
 * Clears auth data and redirects to login page
 */
const logout = async () => {
    try {
        await axios.post('/api/admin/logout');

        // Clear local authentication state
        localStorage.removeItem('token');
        localStorage.removeItem('role');
        delete axios.defaults.headers.common['Authorization'];

        // Redirect to admin login
        router.push({ name: 'AdminLogin' });
    } catch (error) {
        toast.validationError(error);
    }
};
</script>
