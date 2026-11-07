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
        <!-- Compact 3-Level Category Filter Bar -->
        <div class="card shadow-sm border-0 mb-3 bg-light">
            <div class="card-body py-2 px-3">
                <div class="form-row align-items-center">
                    <div class="col-auto d-flex align-items-center text-muted py-1">
                        <i class="fas fa-filter text-primary mr-2"></i>
                        <span class="small font-weight-bold">Filter:</span>
                    </div>

                    <!-- Level 1: Parent Category -->
                    <div class="col-md col-sm-6 py-1">
                        <select v-model="selectedLevel1" @change="onLevel1Change" class="custom-select custom-select-sm">
                            <option value="">All Parent Categories</option>
                            <option v-for="cat in level1Categories" :key="cat.id" :value="cat.id">
                                {{ cat.category_name }}
                            </option>
                        </select>
                    </div>

                    <!-- Level 2: Sub Category -->
                    <div class="col-md col-sm-6 py-1">
                        <select v-model="selectedLevel2" @change="onLevel2Change" class="custom-select custom-select-sm"
                            :disabled="!selectedLevel1 || level2Categories.length === 0">
                            <option value="">
                                {{ !selectedLevel1 ? 'Select Parent First' : (level2Categories.length ? 'All Sub Categories' : 'No Sub Categories') }}
                            </option>
                            <option v-for="cat in level2Categories" :key="cat.id" :value="cat.id">
                                {{ cat.category_name }}
                            </option>
                        </select>
                    </div>

                    <!-- Level 3: That Sub / Child Category -->
                    <div class="col-md col-sm-6 py-1">
                        <select v-model="selectedLevel3" @change="onLevel3Change" class="custom-select custom-select-sm"
                            :disabled="!selectedLevel2 || level3Categories.length === 0">
                            <option value="">
                                {{ !selectedLevel2 ? 'Select Sub First' : (level3Categories.length ? 'All Child Categories' : 'No Child Categories') }}
                            </option>
                            <option v-for="cat in level3Categories" :key="cat.id" :value="cat.id">
                                {{ cat.category_name }}
                            </option>
                        </select>
                    </div>

                    <!-- Reset Filter Button -->
                    <div class="col-auto py-1" v-if="selectedLevel1 || selectedLevel2 || selectedLevel3">
                        <button @click="resetCategoryFilters" class="btn btn-sm btn-outline-danger text-nowrap" title="Clear All Category Filters">
                            <i class="fas fa-times mr-1"></i> Clear
                        </button>
                    </div>

                    <!-- Result Count Badge (Single Row Inline Placement) -->
                    <div class="col-auto ml-auto py-1 text-right text-nowrap" v-if="products?.total !== undefined">
                        <span class="badge badge-light border text-dark px-2 py-1 shadow-sm" style="font-size: 12px; line-height: 1.5;">
                            <i class="fas fa-layer-group text-primary mr-1"></i>
                            <span v-if="selectedLevel1 || selectedLevel2 || selectedLevel3 || currentSearchTerm">
                                Found: <strong class="text-primary">{{ products.total }}</strong> {{ products.total === 1 ? 'Product' : 'Products' }}
                            </span>
                            <span v-else>
                                Total: <strong class="text-primary">{{ products.total }}</strong> {{ products.total === 1 ? 'Product' : 'Products' }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div v-if="products?.data?.length === 0" class="alert alert-info">
                            No products found.
                            <span v-if="selectedLevel1 || selectedLevel2 || selectedLevel3">
                                Try <a href="javascript:void(0)" @click="resetCategoryFilters" class="font-weight-bold alert-link">resetting your category filter</a>.
                            </span>
                        </div>
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
                                        <td class="align-middle">
                                            <div class="font-weight-bold">{{ product.name }}</div>
                                            <div v-if="product.categories && product.categories.length" class="mt-1">
                                                <span v-for="cat in product.categories" :key="cat.id" class="badge badge-light border text-muted mr-1" style="font-size: 11px;">
                                                    <i class="fas fa-folder text-warning mr-1"></i>{{ cat.category_name }}
                                                </span>
                                            </div>
                                        </td>
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
                                                <a :href="`/products/${product.slug || product.id}`" target="_blank"
                                                    class="btn btn-sm btn-outline-dark mr-2" title="View Product">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a :href="`/product-landing/${product.slug || product.id}`" target="_blank"
                                                    class="btn btn-sm btn-outline-primary mr-2" title="View Landing Page">
                                                    <i class="fas fa-rocket"></i>
                                                </a>
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

                        <!-- Table Footer / Bulk Actions & Pagination -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 pt-3 border-top" style="gap: 12px;">
                            <!-- Bulk Actions (visible when items selected) -->
                            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                                <span v-if="selectedProducts.length === 0 && products?.total !== undefined" class="text-muted small">
                                    Showing {{ products.from || 0 }} to {{ products.to || 0 }} of <strong>{{ products.total }}</strong> products
                                </span>
                                <template v-else-if="selectedProducts.length > 0">
                                    <span class="badge badge-light border px-2 py-1 text-muted d-inline-flex align-items-center mr-1" style="font-size: 0.85rem; height: 31px;">
                                        <strong class="text-primary mr-1">{{ selectedProducts.length }}</strong> selected
                                    </span>

                                    <button v-if="authStore.hasPermission('create-products')"
                                        type="button"
                                        class="btn btn-sm btn-outline-primary d-inline-flex align-items-center"
                                        style="white-space: nowrap; height: 31px; font-weight: 500;"
                                        title="Copy Selected"
                                        @click="copySelected">
                                        <i class="fas fa-copy mr-1"></i> Copy
                                    </button>

                                    <button v-if="authStore.hasPermission('delete-products')"
                                        type="button"
                                        class="btn btn-sm btn-outline-danger d-inline-flex align-items-center"
                                        style="white-space: nowrap; height: 31px; font-weight: 500;"
                                        title="Delete Selected"
                                        @click="deleteSelected">
                                        <i class="fas fa-trash-alt mr-1"></i> Delete
                                    </button>

                                    <div v-if="authStore.hasPermission('edit-products')"
                                        class="input-group input-group-sm" style="width: 220px; flex-shrink: 0;">
                                        <select v-model="bulkStatus" class="custom-select" style="min-width: 140px;">
                                            <option value="" disabled>Update Status</option>
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary px-2" type="button"
                                                @click="updateSelectedStatus">Apply</button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Pagination -->
                            <div class="ml-auto">
                                <Pagination :pData="products" :show-info="false" @page-change="fetchPage" />
                            </div>
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
import { computed, inject, onMounted, ref } from 'vue';
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

// 3-Level Category Filter state
const allCategoryList = ref([]);
const selectedLevel1 = ref('');
const selectedLevel2 = ref('');
const selectedLevel3 = ref('');

// Computed category lists for each level
const level1Categories = computed(() => {
    return allCategoryList.value.filter(c => !c.parent_id || c.parent_id == 0);
});

const level2Categories = computed(() => {
    if (!selectedLevel1.value) return [];
    return allCategoryList.value.filter(c => c.parent_id == selectedLevel1.value);
});

const level3Categories = computed(() => {
    if (!selectedLevel2.value) return [];
    return allCategoryList.value.filter(c => c.parent_id == selectedLevel2.value);
});

// Load full category list for dropdown hierarchy
const fetchAllCategories = async () => {
    try {
        const res = await axios.get('/api/product-categories/all');
        allCategoryList.value = res.data.data || [];
    } catch (error) {
        console.error('Failed to load all categories for filter:', error);
    }
};

// Filter change handlers
const onLevel1Change = () => {
    selectedLevel2.value = '';
    selectedLevel3.value = '';
    fetchPage(1);
};

const onLevel2Change = () => {
    selectedLevel3.value = '';
    fetchPage(1);
};

const onLevel3Change = () => {
    fetchPage(1);
};

const resetCategoryFilters = () => {
    selectedLevel1.value = '';
    selectedLevel2.value = '';
    selectedLevel3.value = '';
    fetchPage(1);
};

const selectAll = () => {
    if (allSelected.value) {
        selectedProducts.value = products.value.data.map(p => p.id);
    } else {
        selectedProducts.value = [];
    }
};

const fetchPage = async (page = 1, term = "") => {
    try {
        let url = `/api/products?page=${page}&search=${encodeURIComponent(currentSearchTerm.value)}&per_page=${perPage.value}`;
        if (selectedLevel3.value) {
            url += `&level3_id=${selectedLevel3.value}`;
        } else if (selectedLevel2.value) {
            url += `&level2_id=${selectedLevel2.value}`;
        } else if (selectedLevel1.value) {
            url += `&level1_id=${selectedLevel1.value}`;
        }

        const res = await axios.get(url);
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
    fetchPage(1);
};

const onPerPageChange = () => {
    fetchPage(1);
};

onMounted(() => {
    fetchAllCategories();
    fetchPage(1);
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
