<template>
    <DashboardHeader title="Manage Resources">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" class="mr-2" />
            <router-link :to="{ name: 'CreateResource' }" class="btn btn-primary text-nowrap">
                <i class="fas fa-plus mr-1"></i> Add Resource
            </router-link>
        </div>
    </DashboardHeader>

    <section class="content">
        <!-- Filter Bar -->
        <div class="card shadow-sm border-0 mb-3 bg-light">
            <div class="card-body py-2 px-3">
                <div class="form-row align-items-center">
                    <div class="col-auto d-flex align-items-center text-muted py-1">
                        <i class="fas fa-filter text-primary mr-2"></i>
                        <span class="small font-weight-bold">Filter:</span>
                    </div>

                    <!-- Category Filter -->
                    <div class="col-md-3 col-sm-6 py-1">
                        <select v-model="selectedCategory" @change="onFilterChange" class="custom-select custom-select-sm">
                            <option value="">All Resource Categories</option>
                            <option v-for="cat in categoriesList" :key="cat.id" :value="cat.id">
                                {{ cat.name }}
                            </option>
                        </select>
                    </div>

                    <!-- File Type Filter -->
                    <div class="col-md-2 col-sm-6 py-1">
                        <select v-model="selectedFileType" @change="onFilterChange" class="custom-select custom-select-sm">
                            <option value="">All Types</option>
                            <option value="pdf">Pdf</option>
                            <option value="video">Video</option>
                            <option value="zip">Zip</option>
                            <option value="doc">Document</option>
                            <option value="faq">FAQ</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-2 col-sm-6 py-1">
                        <select v-model="selectedStatus" @change="onFilterChange" class="custom-select custom-select-sm">
                            <option value="">All Statuses</option>
                            <option :value="1">Active</option>
                            <option :value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- Reset Filters Button -->
                    <div class="col-auto py-1" v-if="selectedCategory || selectedFileType || selectedStatus !== ''">
                        <button @click="resetFilters" class="btn btn-sm btn-outline-danger text-nowrap" title="Clear Filters">
                            <i class="fas fa-times mr-1"></i> Clear
                        </button>
                    </div>

                    <!-- Result Count Badge -->
                    <div class="col-auto ml-auto py-1 text-right text-nowrap" v-if="resources?.total !== undefined">
                        <span class="badge badge-light border text-dark px-2 py-1 shadow-sm" style="font-size: 12px; line-height: 1.5;">
                            <i class="fas fa-layer-group text-primary mr-1"></i>
                            <span v-if="selectedCategory || selectedFileType || selectedStatus !== '' || currentSearchTerm">
                                Found: <strong class="text-primary">{{ resources.total }}</strong> {{ resources.total === 1 ? 'Resource' : 'Resources' }}
                            </span>
                            <span v-else>
                                Total: <strong class="text-primary">{{ resources.total }}</strong> {{ resources.total === 1 ? 'Resource' : 'Resources' }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div v-if="resources?.data?.length === 0" class="alert alert-info">
                    No resources found.
                    <span v-if="selectedCategory || selectedFileType || selectedStatus !== '' || currentSearchTerm">
                        Try <a href="javascript:void(0)" @click="resetFilters" class="font-weight-bold alert-link">resetting your filters</a>.
                    </span>
                </div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover bg-white shadow-sm">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th style="width: 70px" class="text-center">Preview</th>
                                    <th>Title & Info</th>
                                    <th>Category</th>
                                    <th>File / Link</th>
                                    <th class="text-center" style="width: 80px">Sort</th>
                                    <th style="width: 110px">Status</th>
                                    <th style="width: 130px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in resources?.data" :key="item.id">
                                    <td class="align-middle text-muted">{{ index + 1 }}</td>
                                    
                                    <!-- Thumbnail or Icon preview -->
                                    <td class="align-middle text-center p-1">
                                        <img v-if="item.thumbnail" :src="getImageCacheUrl(item.thumbnail, 80, 80)"
                                            draggable="false"
                                            class="img-thumbnail rounded"
                                            style="width: 50px; height: 50px; object-fit: cover;"
                                            alt="Thumbnail" />
                                        <div v-else class="rounded d-inline-flex align-items-center justify-content-center bg-light text-secondary border"
                                            style="width: 50px; height: 50px; font-size: 20px;">
                                            <i :class="getFileIcon(item.file_type)"></i>
                                        </div>
                                    </td>

                                    <!-- Title & Description -->
                                    <td class="align-middle">
                                        <div class="font-weight-bold text-dark">{{ item.title }}</div>
                                        <div class="d-flex align-items-center mt-1" style="gap: 6px;">
                                            <span v-if="item.badge_text" class="badge badge-warning text-dark font-weight-normal px-2">
                                                <i v-if="item.badge_icon" :class="item.badge_icon" class="mr-1"></i>
                                                {{ item.badge_text }}
                                            </span>
                                            <span v-if="item.is_featured === 1" class="badge badge-primary font-weight-normal px-2">
                                                <i class="fas fa-star mr-1"></i> Featured
                                            </span>
                                            <small v-if="item.product" class="text-muted">
                                                Product: <strong>{{ item.product.name }}</strong>
                                            </small>
                                        </div>
                                        <small v-if="item.description" class="text-muted d-block text-truncate mt-1" style="max-width: 380px;">
                                            {{ item.description }}
                                        </small>
                                    </td>

                                    <!-- Category Badge -->
                                    <td class="align-middle">
                                        <span v-if="item.category" class="badge badge-light border text-dark px-2 py-1">
                                            <i :class="item.category.icon || 'bi bi-folder2'" class="text-primary mr-1"></i>
                                            {{ item.category.name }}
                                        </span>
                                        <span v-else class="text-muted small">None</span>
                                    </td>

                                    <!-- File / Link details -->
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center" style="gap: 6px;">
                                            <span class="badge" :class="getFileBadgeClass(item.file_type)">
                                                {{ (item.file_type || 'file').toUpperCase() }}
                                            </span>
                                            <small v-if="item.file_size" class="text-muted">
                                                {{ item.file_size }}
                                            </small>
                                        </div>
                                        <div class="mt-1 d-flex align-items-center" style="">
                                            <a v-if="item.file_path" :href="getFileUrl(item.file_path)" target="_blank"
                                                class="btn btn-xs d-flex btn-outline-primary" title="Download File">
                                                <i class="fas fa-download mr-1"></i> Download
                                            </a>
                                            <a v-else-if="item.external_url" :href="item.external_url" target="_blank"
                                                class="btn btn-xs d-flex btn-outline-info" title="Open External Link">
                                                <i class="fas fa-external-link-alt mr-1"></i> Open Link
                                            </a>
                                            <span v-else class="text-muted small">—</span>
                                        </div>
                                    </td>

                                    <!-- Sort Order -->
                                    <td class="align-middle text-center font-weight-bold">{{ item.sort_order }}</td>

                                    <!-- Status Toggle -->
                                    <td class="align-middle">
                                        <select v-model="item.status" @change="updateStatus(item)"
                                            class="custom-select custom-select-sm"
                                            :class="item.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>

                                    <!-- Actions -->
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link :to="{ name: 'ShowResource', params: { id: item.id } }"
                                                class="btn btn-sm btn-outline-dark" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link :to="{ name: 'UpdateResource', params: { id: item.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info" title="Edit Resource">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>
                                            <button class="ml-2 btn btn-sm btn-outline-danger" title="Delete Resource"
                                                @click="confirmDelete(item)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="resources" @page-change="fetchPage" />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { inject, onMounted, ref } from 'vue';
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';
import SearchBox from '@/components/SearchBox.vue';
import { getImageCacheUrl } from '@/layouts/helpers/helpers';

const toast = useToast();
const $swal = inject('$swal');

const resources = ref([]);
const categoriesList = ref([]);
const currentSearchTerm = ref("");
const perPage = ref(10);

// Filter states
const selectedCategory = ref("");
const selectedFileType = ref("");
const selectedStatus = ref("");

const getFileIcon = (type) => {
    const map = {
        'pdf': 'bi bi-file-earmark-pdf text-danger',
        'video': 'bi bi-play-circle text-danger',
        'zip': 'bi bi-file-earmark-zip text-warning',
        'doc': 'bi bi-file-earmark-word text-primary',
        'docx': 'bi bi-file-earmark-word text-primary',
        'faq': 'bi bi-question-circle text-info'
    };
    return map[type] || 'bi bi-file-earmark text-secondary';
};

const getFileBadgeClass = (type) => {
    const map = {
        'pdf': 'badge-danger',
        'video': 'badge-danger',
        'zip': 'badge-warning text-dark',
        'doc': 'badge-primary',
        'docx': 'badge-primary',
        'faq': 'badge-info'
    };
    return map[type] || 'badge-secondary';
};

const getFileUrl = (path) => {
    if (!path) return '#';
    if (/^https?:\/\//i.test(path)) return path;
    const clean = path.replace(/^\/+/, '');
    return `/${clean}`;
};

const fetchCategories = async () => {
    try {
        const res = await axios.get('/api/resource-categories', { params: { all: 1 } });
        categoriesList.value = res.data.data || [];
    } catch (error) {
        console.error('Failed to load resource categories:', error);
    }
};

const fetchPage = async (page = 1) => {
    try {
        let url = `/api/resources?page=${page}&per_page=${perPage.value}`;

        if (currentSearchTerm.value) {
            url += `&search=${encodeURIComponent(currentSearchTerm.value)}`;
        }
        if (selectedCategory.value) {
            url += `&resource_category_id=${encodeURIComponent(selectedCategory.value)}`;
        }
        if (selectedFileType.value) {
            url += `&file_type=${encodeURIComponent(selectedFileType.value)}`;
        }
        if (selectedStatus.value !== "") {
            url += `&status=${selectedStatus.value}`;
        }

        const res = await axios.get(url);
        resources.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load resources.');
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
    selectedCategory.value = "";
    selectedFileType.value = "";
    selectedStatus.value = "";
    currentSearchTerm.value = "";
    fetchPage(1);
};

const updateStatus = async (item) => {
    try {
        const response = await axios.post(`/api/resources/${item.id}/toggle`);
        item.status = response.data.data.status;
        if (item.status == 1) {
            toast.success('Resource activated successfully');
        } else {
            toast.info('Resource deactivated successfully');
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

const confirmDelete = async (item) => {
    const result = await $swal({
        title: `Delete "${item.title}"?`,
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        confirmButtonColor: '#d33'
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/resources/${item.id}`);
            toast.success('Resource deleted successfully!');
            fetchPage(resources.value?.current_page || 1);
        } catch (error) {
            toast.error(error?.response?.data?.message || 'Failed to delete resource.');
        }
    }
};

onMounted(() => {
    fetchCategories();
    fetchPage(1);
});
</script>

<style scoped>
.custom-select-sm {
    border-radius: 6px;
    font-size: 13px;
    height: calc(1.8125rem + 6px);
}
</style>
