<template>
    <DashboardHeader title="Manage Brands">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" class="mr-2" />
            <router-link v-if="authStore.hasPermission('create-attribute-groups')" :to="{ name: 'CreateBrand' }"
                class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Brand
            </router-link>
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="brands?.data?.length === 0" class="alert alert-info">No brands found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Sort Order</th>
                                    <th v-if="authStore.hasPermission('edit-brands')">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(brand, index) in brands?.data" :key="brand.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">
                                        <img v-if="brand.image" :src="getImageCacheUrl(brand.image)" width="100"
                                            class="rounded object-fit-cover" :alt="brand.name" />
                                        <span v-else>No Image</span>
                                    </td>
                                    <td class="align-middle">{{ brand.name }}</td>
                                    <td class="align-middle">{{ brand.sort_order }}</td>
                                    <td v-if="authStore.hasPermission('edit-brands')" class="align-middle">
                                        <select v-model="brand.status" @change="updateStatus(brand)"
                                            class="custom-select"
                                            :class="brand.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link v-if="authStore.hasPermission('view-brands')"
                                                :to="{ name: 'ShowBrand', params: { id: brand.id } }"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link v-if="authStore.hasPermission('edit-brands')"
                                                :to="{ name: 'UpdateBrand', params: { id: brand.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>
                                            <button v-if="authStore.hasPermission('delete-brands')"
                                                class="ml-2 btn btn-sm btn-outline-danger"
                                                @click="confirmDelete(brand)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="brands" @page-change="fetchPage" />
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
const brands = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
const perPage = ref(10);

// Fetch brands with pagination + search + per_page
const fetchPage = async (page = 1, term = "") => {
    try {
        const res = await axios.get(`/api/brands?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        brands.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load brands.');
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

// Update brand status
const updateStatus = async (brand) => {
    try {
        const response = await axios.patch(`/api/brands/${brand.id}/toggle-status`);
        brand.status = response.data.data.status;
        if (brand.status == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

// Delete brand
const confirmDelete = async (brand) => {
    const result = await $swal({
        title: `Delete "${brand.name}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/brands/${brand.id}`);
            toast.success('Brand deleted successfully!');
            brands.value.data = brands.value.data.filter(b => b.id !== brand.id);
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
