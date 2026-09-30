<template>
    <DashboardHeader title="Manage News Categories">
        <div class="d-flex justify-content-end">
            <SearchBox @search="onSearch" />
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="categories?.data?.length === 0" class="alert alert-info">
                    No categories found.
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
                                    <th v-if="authStore.hasPermission('edit-news-categories')">Status</th>
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
                                    <td v-if="authStore.hasPermission('edit-news-categories')" class="align-middle">
                                        <select v-model="cat.status" @change="updateStatus(cat)" class="custom-select"
                                            :class="cat.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>

                                    <!-- Actions -->
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link v-if="authStore.hasPermission('view-news-categories')"
                                                :to="{ name: 'NewsCategoryShow', params: { id: cat.id } }"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fas fa-eye"></i>
                                            </router-link>

                                            <router-link v-if="authStore.hasPermission('edit-news-categories')"
                                                :to="{ name: 'UpdateNewsCategory', params: { id: cat.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>

                                            <button v-if="authStore.hasPermission('delete-news-categories')"
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

// Reactive list of news categories (paginated)
const categories = ref([]);

// Auth store (if needed for permissions)
const authStore = useAuthStore();
const currentSearchTerm = ref("");
// SweetAlert2 instance
const $swal = inject('$swal');

/**
 * Fetch news categories with pagination and optional search
 */
const fetchCategory = async (page = 1) => {
    try {
        const res = await axios.get(`/api/news-categories?page=${page}&search=${currentSearchTerm.value}`);
        categories.value = res.data.data;
    } catch (error) {
        console.error(error);
    }
};

/**
 * Handle search - reset to first page
 */
const onSearch = (term) => {
    currentSearchTerm.value = term;
    fetchCategory();
};

// Load categories on component mount
onMounted(async () => {
    try {
        fetchCategory();
    } catch (error) {
        toast.validationError(error);
    }
});

/**
 * Toggle category status (active ↔ inactive)
 */
const updateStatus = async (cat) => {
    try {
        const response = await axios.patch(`/api/news-categories/${cat.id}`, {
            status: cat.status,
        });
        if (cat.status == 1) {
            toast.success('Category activated');
        } else {
            toast.info('Category deactivated');
        }
    } catch (error) {
        toast.error('Something went wrong.');
    }
};

/**
 * Confirm and delete a news category
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
            await axios.delete(`/api/news-categories/${cat.id}`);
            toast.success('Category deleted successfully!');
            // Refresh current page to keep pagination consistent
            fetchCategory(categories?.value?.current_page);
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
