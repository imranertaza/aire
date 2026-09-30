<template>
    <DashboardHeader title="Manage Blog Categories">
        <div class="d-flex justify-content-end">
            <SearchBox @search="onSearch" />
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="categories?.data?.length === 0" class="alert alert-info">
                    No blog categories found.
                </div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Parent</th>
                                    <th>Description</th>
                                    <th v-if="authStore.hasPermission('edit-blog-categories')">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(cat, index) in categories?.data" :key="cat.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ truncateText(cat.category_name, 25) }}</td>
                                    <td class="align-middle">
                                        {{ cat.parent ? cat.parent.category_name : '-' }}
                                    </td>
                                    <td class="align-middle">{{ truncateText(cat.description, 50) }}</td>

                                    <!-- Status dropdown -->
                                    <td v-if="authStore.hasPermission('edit-blog-categories')" class="align-middle">
                                        <select v-model="cat.status" @change="updateStatus(cat)" class="custom-select"
                                            :class="cat.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>

                                    <!-- Actions -->
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link v-if="authStore.hasPermission('view-blog-categories')"
                                                :to="{ name: 'BlogCategoryShow', params: { id: cat.id } }"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fas fa-eye"></i>
                                            </router-link>

                                            <router-link v-if="authStore.hasPermission('edit-blog-categories')"
                                                :to="{ name: 'UpdateBlogCategory', params: { id: cat.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>

                                            <button v-if="authStore.hasPermission('delete-blog-categories')"
                                                class="ml-2 btn btn-sm btn-outline-danger" @click="confirmDelete(cat)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="categories" @page-change="fetchCategory" />
                </div>
            </div>
        </div>
    </section>
</template>
<script setup>
import axios from 'axios';
import { inject, onMounted, ref } from 'vue';
import DashboardHeader from '@/components/DashboardHeader.vue';
import Pagination from '@/components/Paginations/Pagination.vue';
import { truncateText } from '@/layouts/helpers/helpers';
import { useAuthStore } from '@/store/auth';
import { useToast } from '@/composables/useToast';
import SearchBox from '@/components/SearchBox.vue';

// Toast notifications
const toast = useToast();

// Reactive list of blog categories (from paginated response)
const categories = ref([]);

// Auth store (if needed for user/role checks)
const authStore = useAuthStore();

// SweetAlert2 instance (injected from main.js/app setup)
const $swal = inject('$swal');
const currentSearchTerm = ref("");
/**
 * Fetch blog categories with pagination and optional search
 * @param {number} page - Page number (default: 1)
 * @param {string} searchTerm - Search query (default: empty)
 */
const fetchCategory = async (page = 1) => {
    try {
        const res = await axios.get(`/api/blog-categories?page=${page}&search=${currentSearchTerm.value}`);
        categories.value = res.data.data; // Full paginated response (data + meta/links)
    } catch (error) {
        toast.error('Failed to load categories');
    }
};

/**
 * Handle search input - reset to page 1 with the search term
 */
const onSearch = (term) => {
    currentSearchTerm.value = term;
    fetchCategory();
};

// Load categories on component mount
onMounted(async () => {
    await fetchCategory();
});

/**
 * Toggle category status (active ↔ inactive)
 */
const updateStatus = async (cat) => {
    try {
        await axios.patch(`/api/blog-categories/${cat.id}`, {
            status: cat.status
        });

        if (cat.status == 1) {
            toast.success('Category activated');
        } else {
            toast.info('Category deactivated');
        }
    } catch (error) {
        toast.validationError(error);
        console.error('Status update failed:', error);
    }
};

/**
 * Confirm and delete a blog category
 */
const confirmDelete = async (cat) => {
    const result = await $swal({
        title: `Delete "${cat.category_name}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
    });

    if (result?.isConfirmed) {
        try {
            await axios.delete(`/api/blog-categories/${cat.id}`);
            toast.success('Category deleted successfully!');

            // Refresh current page (preserves pagination)
            fetchCategory(categories.value?.current_page || 1);
        } catch (error) {
            toast.validationError(error);
            console.error('Delete failed:', error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
