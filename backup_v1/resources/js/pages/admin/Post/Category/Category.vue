<template>
    <DashboardHeader title="Manage Categories">
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
                                    <th v-if="authStore.hasPermission('edit-categories')">Status</th>
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
                                    <td v-if="authStore.hasPermission('edit-categories')" class="align-middle">
                                        <select v-model="cat.status" @change="updateStatus(cat)" class="custom-select"
                                            :class="cat.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>

                                    <!-- Actions -->
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link v-if="authStore.hasPermission('view-categories')"
                                                :to="{ name: 'CategoryShow', params: { id: cat.id } }"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fas fa-eye"></i>
                                            </router-link>

                                            <router-link v-if="authStore.hasPermission('edit-categories')"
                                                :to="{ name: 'UpdateCategory', params: { id: cat.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>

                                            <button v-if="authStore.hasPermission('delete-categories')"
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

const toast = useToast();
const categories = ref([]);
const authStore = useAuthStore();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
const fetchCategory = async (page = 1) => {
    try {
        const res = await axios.get(`/api/categories?page=${page}&search=${currentSearchTerm.value}`);
        categories.value = res.data.data;
    } catch (error) {
        console.error(error);
    }
};
const onSearch = (term) => {
    currentSearchTerm.value = term;
    fetchCategory();
};
// Fetch categories
onMounted(async () => {
    try {
        fetchCategory();
    } catch (error) {
        toast.validationError(error);
    }
});

// Update status
const updateStatus = async (cat) => {
    try {
        const response = await axios.patch(`/api/categories/${cat.id}`, {
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

// Delete category
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
            await axios.delete(`/api/categories/${cat.id}`);
            toast.success('Category deleted successfully!');
            fetchCategory(categories?.value?.current_page);
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
