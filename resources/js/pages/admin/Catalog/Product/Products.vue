<template>
    <DashboardHeader title="Manage Products">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" class="mr-2" />
            <router-link v-if="authStore.hasPermission('create-products')" :to="{ name: 'CreateProduct' }"
                class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Product
            </router-link>
            <router-link v-if="authStore.isModuleEnabled('bulk_edit_products')" :to="{ name: 'AdvancedProducts' }"
                class="btn btn-success ml-2">
                <i class="fas fa-edit"></i> Advanced Editor
            </router-link>
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div v-if="products?.data?.length === 0" class="alert alert-info">No products found.</div>
                        <div v-else class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr class="align-middle">
                                        <th style="width: 10px">
                                            <input type="checkbox" @change="selectAll" v-model="allSelected" />
                                        </th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Model</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th v-if="authStore.hasPermission('edit-products')">Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="product in products?.data" :key="product.id">
                                        <td class="align-middle">
                                            <input type="checkbox" :value="product.id" v-model="selectedProducts" />
                                        </td>
                                        <td class="align-middle text-center">
                                            <img :src="product.main_image ? getImageCacheUrl(product.main_image, 60, 60, 'webp') : '/images/no-image.jpg'"
                                                class="img-thumbnail"
                                                style="width: 60px; height: 60px; object-fit: cover;"
                                                alt="Product Image" />
                                        </td>
                                        <td class="align-middle">{{ product.name }}</td>
                                        <td class="align-middle">{{ product.model }}</td>
                                        <td class="align-middle">{{ product.price }}</td>
                                        <td class="align-middle">
                                            <span
                                                :class="{ 'badge bg-danger': product.quantity <= 0, 'badge bg-success': product.quantity > 0 }">
                                                {{ product.quantity }}
                                            </span>
                                        </td>
                                        <td v-if="authStore.hasPermission('edit-products')" class="align-middle">
                                            <select v-model="product.status" @change="updateStatus(product)"
                                                class="custom-select"
                                                :class="product.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                                <option :value="1">Active</option>
                                                <option :value="0">Inactive</option>
                                            </select>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex">
                                                <router-link v-if="authStore.hasPermission('edit-products')"
                                                    :to="{ name: 'UpdateProduct', params: { id: product.id } }"
                                                    class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </router-link>
                                                <button v-if="authStore.hasPermission('delete-products')"
                                                    class="ml-2 btn btn-sm btn-outline-danger"
                                                    @click="confirmDelete(product)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="d-flex align-items-center">
                                <button v-if="authStore.hasPermission('create-products') && selectedProducts.length > 0"
                                    class="btn btn-sm btn-outline-primary mr-2" @click="copySelected">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                                <button v-if="authStore.hasPermission('delete-products') && selectedProducts.length > 0"
                                    class="btn btn-sm btn-outline-danger mr-2" @click="deleteSelected">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                                <div v-if="authStore.hasPermission('edit-products') && selectedProducts.length > 0"
                                    class="input-group input-group-sm" style="width: auto;">
                                    <select v-model="bulkStatus" class="custom-select">
                                        <option value="" disabled>Update Status</option>
                                        <option :value="1">Active</option>
                                        <option :value="0">Inactive</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"
                                            @click="updateSelectedStatus">Apply</button>
                                    </div>
                                </div>
                            </div>
                            <Pagination :pData="products" @page-change="fetchPage" />
                        </div>
                    </div>
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
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';
import { getImageCacheUrl } from '../../../../layouts/helpers/helpers';

const router = useRouter();
const route = useRoute();
const products = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
const perPage = ref(10);
const selectedProducts = ref([]);
const allSelected = ref(false);
const bulkStatus = ref("");

const selectAll = () => {
    if (allSelected.value) {
        selectedProducts.value = products.value.data.map(p => p.id);
    } else {
        selectedProducts.value = [];
    }
};

const fetchPage = async (page = 1, term = "") => {
    try {
        const res = await axios.get(`/api/products?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        const pData = res.data.data;
        if (pData && pData.data) {
            pData.data.forEach(p => {
                p.status = parseInt(p.status);
            });
        }
        products.value = pData;
        selectedProducts.value = [];
        allSelected.value = false;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load products.');
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

const updateStatus = async (product) => {
    try {
        const response = await axios.patch(`/api/products/${product.id}/toggle-status`);
        product.status = response.data.data.status;
        if (product.status == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

const confirmDelete = async (product) => {
    const result = await $swal({
        title: `Delete "${product.name}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/products/${product.id}`);
            toast.success('Product deleted successfully!');
            fetchPage();
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};

const copySelected = async () => {
    if (selectedProducts.value.length === 0) return;

    try {
        await axios.post('/api/products/copy', { product_ids: selectedProducts.value });
        toast.success('Selected products copied successfully!');
        fetchPage();
    } catch (error) {
        toast.validationError(error);
    }
};

const deleteSelected = async () => {
    if (selectedProducts.value.length === 0) return;

    const result = await $swal({
        title: `Delete ${selectedProducts.value.length} products?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete all',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete('/api/products/bulk-delete', { data: { product_ids: selectedProducts.value } });
            toast.success('Selected products deleted successfully!');
            fetchPage();
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Bulk deletion cancelled.');
    }
};

const updateSelectedStatus = async () => {
    if (selectedProducts.value.length === 0 || bulkStatus.value === "") return;

    try {
        await axios.post('/api/products/bulk-status', {
            product_ids: selectedProducts.value,
            status: bulkStatus.value
        });
        toast.success('Status updated for selected products!');
        bulkStatus.value = "";
        fetchPage();
    } catch (error) {
        toast.validationError(error);
    }
};
</script>
