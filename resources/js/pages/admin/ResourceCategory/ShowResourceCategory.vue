<template>
    <DashboardHeader title="Resource Category Details">
        <div class="d-flex" style="gap: 10px;">
            <router-link :to="{ name: 'ResourceCategories' }" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </router-link>
            <router-link v-if="category" :to="{ name: 'UpdateResourceCategory', params: { id: category.id } }" class="btn btn-info text-white">
                <i class="fas fa-edit mr-1"></i> Edit Category
            </router-link>
        </div>
    </DashboardHeader>

    <section class="content">
        <div class="container-fluid">
            <div v-if="loading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading category details...</span>
                </div>
            </div>

            <div v-else-if="category" class="row">
                <!-- Left: Profile & Key Meta -->
                <div class="col-md-4">
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-body box-profile text-center">
                            <div class="mb-3">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light border shadow-sm"
                                    style="width: 80px; height: 80px; font-size: 36px; color: #007bff;">
                                    <i :class="category.icon || 'bi bi-folder2'"></i>
                                </span>
                            </div>

                            <h4 class="profile-username font-weight-bold mb-1">{{ category.name }}</h4>
                            <p class="text-muted mb-3 font-italic">
                                <code>#cat-{{ category.slug }}</code>
                            </p>

                            <ul class="list-group list-group-unbordered mb-3 text-left">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Status</b>
                                    <span class="badge" :class="category.status === 1 ? 'badge-success' : 'badge-secondary'">
                                        {{ category.status === 1 ? 'Active' : 'Inactive' }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Layout Style</b>
                                    <span class="badge badge-info">
                                        {{ formatLayout(category.layout_type) }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Sort Order</b>
                                    <span class="font-weight-bold">{{ category.sort_order }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Total Resources</b>
                                    <span class="badge badge-primary badge-pill">
                                        {{ category.resources ? category.resources.length : 0 }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Created At</b>
                                    <span class="text-muted small">{{ formatDate(category.created_at) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Right: Details & Resources List -->
                <div class="col-md-8">
                    <!-- Info Card -->
                    <div class="card card-outline card-secondary shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-info-circle mr-1 text-secondary"></i> Display Settings
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4 font-weight-bold text-muted">Sidebar Subtitle:</div>
                                <div class="col-sm-8">{{ category.short_desc || '—' }}</div>
                            </div>
                            <hr class="my-2">
                            <div class="row mb-3">
                                <div class="col-sm-4 font-weight-bold text-muted">Section Search Placeholder:</div>
                                <div class="col-sm-8"><code>{{ category.search_placeholder || 'Search with model No/ Name' }}</code></div>
                            </div>
                            <hr class="my-2">
                            <div class="row mb-2">
                                <div class="col-sm-4 font-weight-bold text-muted">Section Description:</div>
                                <div class="col-sm-8">
                                    <p class="mb-0 text-dark">{{ category.description || 'No custom section description set.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resources in Category -->
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-file-alt mr-1 text-primary"></i> Resources in this Category
                            </h3>
                            <span class="badge badge-light border">
                                {{ category.resources ? category.resources.length : 0 }} items
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>Title</th>
                                            <th>Type / Model</th>
                                            <th>File / Link</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, idx) in (category.resources || [])" :key="item.id">
                                            <td>{{ idx + 1 }}</td>
                                            <td>
                                                <div class="font-weight-bold text-dark">{{ item.title }}</div>
                                                <small v-if="item.description" class="text-muted d-block text-truncate" style="max-width: 250px;">
                                                    {{ item.description }}
                                                </small>
                                            </td>
                                            <td>
                                                <span v-if="item.file_type" class="badge badge-light border mr-1">
                                                    {{ item.file_type.toUpperCase() }}
                                                </span>
                                                <small v-if="item.model_no" class="text-muted">
                                                    Model: {{ item.model_no }}
                                                </small>
                                            </td>
                                            <td>
                                                <a v-if="item.file_url" :href="item.file_url" target="_blank" class="btn btn-xs btn-outline-primary">
                                                    <i class="fas fa-download mr-1"></i> File
                                                </a>
                                                <a v-else-if="item.external_url" :href="item.external_url" target="_blank" class="btn btn-xs btn-outline-info">
                                                    <i class="fas fa-external-link-alt mr-1"></i> Link
                                                </a>
                                                <span v-else class="text-muted small">—</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge" :class="item.status === 1 ? 'badge-success' : 'badge-secondary'">
                                                    {{ item.status === 1 ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr v-if="!category.resources || category.resources.length === 0">
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                <i class="fas fa-folder-open fa-2x mb-2 d-block text-secondary"></i>
                                                No resources uploaded for this category yet.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import DashboardHeader from '@/components/DashboardHeader.vue';

const route = useRoute();
const category = ref(null);
const loading = ref(true);

const formatLayout = (layout) => {
    const map = {
        'brochure_card': 'Brochures & Catalogs (Tall Card)',
        'video_card': 'Videos (16:9 Thumbnail + Modal)',
        'thumb_card': 'Thumbnails & Docs (Techdocs/Certs)',
        'faq_card': 'FAQ (Accordion Cards)'
    };
    return map[layout] || layout || 'Brochures';
};

const formatDate = (dateStr) => {
    if (!dateStr) return '—';
    return new Date(dateStr).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

const fetchCategory = async () => {
    loading.value = true;
    try {
        const res = await axios.get(`/api/resource-categories/${route.params.id}`);
        category.value = res.data.data;
    } catch (error) {
        console.error('Error fetching resource category:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchCategory();
});
</script>
