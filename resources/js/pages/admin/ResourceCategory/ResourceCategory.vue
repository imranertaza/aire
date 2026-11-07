<template>
    <DashboardHeader title="Manage Resource Categories">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" />
            <router-link v-if="canCreate"
                :to="{ name: 'CreateResourceCategory' }" class="btn btn-primary ml-2 text-nowrap">
                <i class="fas fa-plus"></i> Add Category
            </router-link>
        </div>
    </DashboardHeader>

    <section>
        <!-- Filter Bar matching ProductCategory.vue -->
        <div class="card shadow-sm border-0 mb-3 bg-light">
            <div class="card-body py-2 px-3">
                <div class="form-row align-items-center">
                    <div class="col-auto d-flex align-items-center text-muted py-1">
                        <i class="fas fa-filter text-primary mr-2"></i>
                        <span class="small font-weight-bold">Filter:</span>
                    </div>

                    <!-- Filter: Layout Type -->
                    <div class="col-md-3 col-sm-6 py-1">
                        <select v-model="selectedLayout" @change="onFilterChange" class="custom-select custom-select-sm">
                            <option value="">All Layout Types</option>
                            <option value="brochure_card">Brochures & Catalogs (brochure_card)</option>
                            <option value="video_card">Videos (video_card)</option>
                            <option value="thumb_card">Thumbnails & Docs (thumb_card)</option>
                            <option value="faq_card">FAQ Accordions (faq_card)</option>
                        </select>
                    </div>

                    <!-- Filter: Status -->
                    <div class="col-md-3 col-sm-6 py-1">
                        <select v-model="selectedStatus" @change="onFilterChange" class="custom-select custom-select-sm">
                            <option value="">All Statuses</option>
                            <option :value="1">Active</option>
                            <option :value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- Reset Filter Button -->
                    <div class="col-auto py-1" v-if="selectedLayout || selectedStatus !== ''">
                        <button @click="resetFilters" class="btn btn-sm btn-outline-danger text-nowrap" title="Clear All Filters">
                            <i class="fas fa-times mr-1"></i> Clear
                        </button>
                    </div>

                    <!-- Result Count Badge (Single Row Inline Placement matching ProductCategory.vue) -->
                    <div class="col-auto ml-auto py-1 text-right text-nowrap" v-if="categories?.total !== undefined">
                        <span class="badge badge-light border text-dark px-2 py-1 shadow-sm" style="font-size: 12px; line-height: 1.5;">
                            <i class="fas fa-layer-group text-primary mr-1"></i>
                            <span v-if="selectedLayout || selectedStatus !== '' || currentSearchTerm">
                                Found: <strong class="text-primary">{{ categories.total }}</strong> {{ categories.total === 1 ? 'Category' : 'Categories' }}
                            </span>
                            <span v-else>
                                Total: <strong class="text-primary">{{ categories.total }}</strong> {{ categories.total === 1 ? 'Category' : 'Categories' }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div v-if="categories?.data?.length === 0" class="alert alert-info">
                    No resource categories found.
                    <span v-if="selectedLayout || selectedStatus !== '' || currentSearchTerm">
                        Try <a href="javascript:void(0)" @click="resetFilters" class="font-weight-bold alert-link">resetting your filters</a>.
                    </span>
                </div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th style="width: 60px" class="text-center">Icon</th>
                                    <th>Category Name</th>
                                    <th>Slug</th>
                                    <th>Layout Type</th>
                                    <th class="text-center">Resources</th>
                                    <th class="text-nowrap text-center" style="width: 90px">Sort Order</th>
                                    <th style="width: 110px">Status</th>
                                    <th style="width: 130px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(category, index) in categories?.data" :key="category.id">
                                    <td class="align-middle text-muted">{{ index + 1 }}</td>
                                    <td class="align-middle text-center">
                                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center bg-light text-primary border"
                                            style="width: 40px; height: 40px; font-size: 18px;">
                                            <i :class="category.icon || 'bi bi-folder2'"></i>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="font-weight-bold text-dark">{{ category.name }}</div>
                                        <small class="text-muted d-block" v-if="category.short_desc">{{ category.short_desc }}</small>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-light border text-muted">#cat-{{ category.slug }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <span v-if="category.layout_type === 'brochure_card'" class="badge badge-primary px-2 py-1">
                                            <i class="bi bi-book mr-1"></i> Brochure Card
                                        </span>
                                        <span v-else-if="category.layout_type === 'video_card'" class="badge badge-danger px-2 py-1">
                                            <i class="bi bi-play-circle mr-1"></i> Video Card
                                        </span>
                                        <span v-else-if="category.layout_type === 'faq_card'" class="badge badge-warning text-dark px-2 py-1">
                                            <i class="bi bi-question-circle mr-1"></i> FAQ Card
                                        </span>
                                        <span v-else class="badge badge-info px-2 py-1">
                                            <i class="bi bi-grid mr-1"></i> Thumb Card
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-secondary px-2 py-1" style="font-size: 11px;">
                                            {{ category.resources_count || 0 }} items
                                        </span>
                                    </td>
                                    <td class="align-middle text-center font-weight-bold">{{ category.sort_order }}</td>
                                    <td class="align-middle">
                                        <select v-model="category.status" @change="updateStatus(category)"
                                            class="custom-select custom-select-sm"
                                            :class="category.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link :to="{ name: 'ShowResourceCategory', params: { id: category.id } }"
                                                class="btn btn-sm btn-outline-dark" title="View Category">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link :to="{ name: 'UpdateResourceCategory', params: { id: category.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info" title="Edit Category">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>
                                            <button class="ml-2 btn btn-sm btn-outline-danger" title="Delete Category"
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

const router = useRouter();
const route = useRoute();
const categories = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
const perPage = ref(10);

// Filter states
const selectedLayout = ref("");
const selectedStatus = ref("");

const canCreate = computed(() => {
    return !authStore.hasPermission || authStore.hasPermission('create-resource-categories') || true;
});

// Fetch categories with pagination + search + per_page + filters
const fetchPage = async (page = 1) => {
    try {
        let url = `/api/resource-categories?page=${page}&per_page=${perPage.value}`;

        if (currentSearchTerm.value) {
            url += `&search=${encodeURIComponent(currentSearchTerm.value)}`;
        }
        if (selectedLayout.value) {
            url += `&layout_type=${encodeURIComponent(selectedLayout.value)}`;
        }
        if (selectedStatus.value !== "") {
            url += `&status=${selectedStatus.value}`;
        }

        const res = await axios.get(url);
        categories.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load resource categories.');
    }
};

const onSearch = async (term) => {
    currentSearchTerm.value = term;
    fetchPage(1);
};

const onPerPageChange = () => {
    fetchPage(1);
};

const onFilterChange = () => {
    fetchPage(1);
};

const resetFilters = () => {
    selectedLayout.value = "";
    selectedStatus.value = "";
    currentSearchTerm.value = "";
    fetchPage(1);
};

onMounted(() => {
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
        const response = await axios.post(`/api/resource-categories/${category.id}/toggle`);
        category.status = response.data.data.status;
        if (category.status == 1) {
            toast.success('Category activated successfully');
        } else {
            toast.info('Category deactivated successfully');
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

// Delete category with SweetAlert
const confirmDelete = async (category) => {
    const result = await $swal({
        title: `Delete "${category.name}"?`,
        text: 'This action cannot be undone and will delete all resources within this category!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        confirmButtonColor: '#d33'
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/resource-categories/${category.id}`);
            toast.success('Resource category deleted successfully!');
            fetchPage(categories.value?.current_page || 1);
        } catch (error) {
            toast.error(error?.response?.data?.message || 'Failed to delete category.');
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
