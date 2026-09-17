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
            <router-link v-if="authStore.hasPermission('create-product-categories')"
                :to="{ name: 'CreateProductCategory' }" class="btn btn-primary ml-2 text-nowrap">
                <i class="fas fa-plus"></i> Add Category
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
                    <div class="col-md-3 col-sm-6 py-1">
                        <select v-model="selectedLevel1" @change="onLevel1Change" class="custom-select custom-select-sm">
                            <option value="">All Parent Categories</option>
                            <option v-for="cat in level1Categories" :key="cat.id" :value="cat.id">
                                {{ cat.category_name }}
                            </option>
                        </select>
                    </div>

                    <!-- Level 2: Sub Category -->
                    <div class="col-md-3 col-sm-6 py-1">
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
                    <div class="col-md-3 col-sm-6 py-1">
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
                        <button @click="resetCategoryFilters" class="btn btn-sm btn-outline-danger" title="Clear All Category Filters">
                            <i class="fas fa-times mr-1"></i> Clear
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div v-if="categories?.data?.length === 0" class="alert alert-info">
                    No product categories found.
                    <span v-if="selectedLevel1 || selectedLevel2 || selectedLevel3">
                        Try <a href="javascript:void(0)" @click="resetCategoryFilters" class="font-weight-bold alert-link">resetting your category filter</a>.
                    </span>
                </div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Parent Category</th>
                                    <th class="text-nowrap">Sort Order</th>
                                    <th v-if="authStore.hasPermission('edit-product-categories')">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(category, index) in categories?.data" :key="category.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle text-center">
                                        <img v-if="category.image" :src="getImageCacheUrl(category.image)" height="50"
                                            class="rounded object-fit-cover" :alt="category.category_name" />
                                        <span v-else class="text-muted small">No Image</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <span v-if="category.parent && category.parent.parent"
                                                class="badge badge-secondary mr-2 px-2 py-1" style="font-size: 10px;" title="3rd Level (Child Category)">
                                                Child
                                            </span>
                                            <span v-else-if="category.parent"
                                                class="badge badge-info mr-2 px-2 py-1" style="font-size: 10px;" title="2nd Level (Sub Category)">
                                                Sub
                                            </span>
                                            <span v-else
                                                class="badge badge-primary mr-2 px-2 py-1" style="font-size: 10px;" title="1st Level (Parent Category)">
                                                Parent
                                            </span>
                                            <span class="font-weight-bold">{{ category.category_name }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <span v-if="category.parent">
                                            <span v-if="category.parent.parent" class="text-muted small">
                                                {{ category.parent.parent.category_name }} &gt;
                                            </span>
                                            <span>{{ category.parent.category_name }}</span>
                                        </span>
                                        <span v-else class="badge badge-light border text-muted">Top Level</span>
                                    </td>
                                    <td class="align-middle">{{ category.sort_order }}</td>
                                   
                                    <td v-if="authStore.hasPermission('edit-product-categories')" class="align-middle">
                                        <select v-model="category.status" @change="updateStatus(category)"
                                            class="custom-select custom-select-sm"
                                            :class="category.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link v-if="authStore.hasPermission('view-product-categories')"
                                                :to="{ name: 'ShowProductCategory', params: { id: category.id } }"
                                                class="btn btn-sm btn-outline-dark" title="View Category">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link v-if="authStore.hasPermission('edit-product-categories')"
                                                :to="{ name: 'UpdateProductCategory', params: { id: category.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info" title="Edit Category">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>
                                            <button v-if="authStore.hasPermission('delete-product-categories')"
                                                class="ml-2 btn btn-sm btn-outline-danger" title="Delete Category"
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
import { inject, onMounted, ref, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';
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

// Selected category objects for the active path chips
const selectedLevel1Obj = computed(() => {
    if (!selectedLevel1.value) return null;
    return allCategoryList.value.find(c => c.id == selectedLevel1.value) || null;
});

const selectedLevel2Obj = computed(() => {
    if (!selectedLevel2.value) return null;
    return allCategoryList.value.find(c => c.id == selectedLevel2.value) || null;
});

const selectedLevel3Obj = computed(() => {
    if (!selectedLevel3.value) return null;
    return allCategoryList.value.find(c => c.id == selectedLevel3.value) || null;
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

const resetToLevel = (level) => {
    if (level === 0) {
        selectedLevel1.value = '';
        selectedLevel2.value = '';
        selectedLevel3.value = '';
    } else if (level === 1) {
        selectedLevel2.value = '';
        selectedLevel3.value = '';
    } else if (level === 2) {
        selectedLevel3.value = '';
    }
    fetchPage(1);
};

// Fetch categories with pagination + search + per_page + 3-level filters
const fetchPage = async (page = 1) => {
    try {
        let url = `/api/product-categories?page=${page}&search=${encodeURIComponent(currentSearchTerm.value)}&per_page=${perPage.value}`;
        if (selectedLevel3.value) {
            url += `&level3_id=${selectedLevel3.value}`;
        } else if (selectedLevel2.value) {
            url += `&level2_id=${selectedLevel2.value}`;
        } else if (selectedLevel1.value) {
            url += `&level1_id=${selectedLevel1.value}`;
        }

        const res = await axios.get(url);
        categories.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load categories.');
    }
};

const onSearch = async (term) => {
    currentSearchTerm.value = term;
    fetchPage(1);
};

const onPerPageChange = () => {
    fetchPage(1);
};

onMounted(async () => {
    await fetchAllCategories();
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

// Update category show in filter
const updateShowInFilter = async (category) => {
    try {
        const response = await axios.patch(`/api/product-categories/${category.id}/toggle-show-in-filter`);
        category.show_in_filter = response.data.data.show_in_filter;
        if (category.show_in_filter == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update show in filter');
        console.error(error);
    }
};

// Delete category
const confirmDelete = async (category) => {
    const result = await $swal({
        title: `Delete "${category.category_name}"?`,
        text: 'This action cannot be undone and will delete child subcategories if any.',
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
            fetchAllCategories(); // Refresh dropdown options
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>

<style scoped>
.custom-select-sm {
    border-radius: 6px;
    font-size: 13px;
    height: calc(1.8125rem + 6px);
}
</style>
