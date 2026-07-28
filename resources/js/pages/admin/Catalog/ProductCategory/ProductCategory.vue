<template>
    <DashboardHeader title="Manage Product Categories">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" />
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="categories?.data?.length === 0" class="alert alert-info">No product categories found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Parent Category</th>
                                    <th>Sort Order</th>
                                    <th v-if="authStore.hasPermission('edit-product-categories')">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(category, index) in categories?.data" :key="category.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">
                                        <img v-if="category.image" :src="getImageCacheUrl(category.image)" height="50"
                                            class="rounded object-fit-cover" :alt="category.category_name" />
                                        <span v-else>No Image</span>
                                    </td>
                                    <td class="align-middle">{{ category.category_name }}</td>
                                    <td class="align-middle">
                                        <span v-if="category.parent">{{ category.parent.category_name }}</span>
                                        <span v-else class="text-muted">None</span>
                                    </td>
                                    <td class="align-middle">{{ category.sort_order }}</td>
                                    <td v-if="authStore.hasPermission('edit-product-categories')" class="align-middle">
                                        <select v-model="category.status" @change="updateStatus(category)"
                                            class="custom-select"
                                            :class="category.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link v-if="authStore.hasPermission('view-product-categories')"
                                                :to="{ name: 'ShowProductCategory', params: { id: category.id } }"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link v-if="authStore.hasPermission('edit-product-categories')"
                                                :to="{ name: 'UpdateProductCategory', params: { id: category.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>
                                            <button v-if="authStore.hasPermission('delete-product-categories')"
                                                class="ml-2 btn btn-sm btn-outline-danger"
                                                @click="confirmDelete(category)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="categories" @page-change="fetchPage" />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { inject, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';
import { getImageUrl } from '@/layouts/helpers/helpers';
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';
import { getImageCacheUrl } from '../../../../layouts/helpers/helpers';

const router = useRouter();
const route = useRoute();
const categories = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
const perPage = ref(10);

// Fetch categories with pagination + search + per_page
const fetchPage = async (page = 1, term = "") => {
    try {
        const res = await axios.get(`/api/product-categories?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        categories.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load categories.');
    }
};

const onSearch = async (term) => {
    currentSearchTerm.value = term;
    fetchPage();
};

const onPerPageChange = () => {
    fetchPage(1);
};

onMounted(() => {
    fetchPage();
    if (route.query.toast) {
        toast.success(route.query.toast);
        setTimeout(() => {
            const q = { ...route.query };
            delete q.toast;
            router.replace({ query: q });
        }, 2000);
    }
});

// Update category status
const updateStatus = async (category) => {
    try {
        const response = await axios.patch(`/api/product-categories/${category.id}/toggle-status`);
        category.status = response.data.data.status;
        if (category.status == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

// Delete category
const confirmDelete = async (category) => {
    const result = await $swal({
        title: `Delete "${category.category_name}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/product-categories/${category.id}`);
            toast.success('Category deleted successfully!');
            categories.value.data = categories.value.data.filter(b => b.id !== category.id);
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
