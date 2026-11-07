<template>
    <DashboardHeader title="Resource Details">
        <div class="d-flex" style="gap: 10px;">
            <router-link :to="{ name: 'Resources' }" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </router-link>
            <router-link v-if="resource" :to="{ name: 'UpdateResource', params: { id: resource.id } }" class="btn btn-info text-white">
                <i class="fas fa-edit mr-1"></i> Edit Resource
            </router-link>
        </div>
    </DashboardHeader>

    <section class="content">
        <div class="container-fluid">
            <div v-if="loading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading resource...</span>
                </div>
            </div>

            <div v-else-if="resource" class="row">
                <!-- Left: Preview & Badges Card -->
                <div class="col-md-4">
                    <div class="card card-purple card-outline shadow-sm">
                        <div class="card-body box-profile text-center">
                            <div class="mb-3">
                                <img v-if="resource.thumbnail" :src="getImageCacheUrl(resource.thumbnail, 400, 300)"
                                    class="img-fluid rounded border shadow-sm" style="max-height: 180px; object-fit: cover;" alt="Resource Thumbnail" />
                                <div v-else class="rounded d-inline-flex align-items-center justify-content-center bg-light text-secondary border shadow-sm"
                                    style="width: 100px; height: 100px; font-size: 42px;">
                                    <i :class="getFileIcon(resource.file_type)"></i>
                                </div>
                            </div>

                            <h4 class="profile-username font-weight-bold mb-1">{{ resource.title }}</h4>
                            <p class="text-muted mb-2 font-italic">
                                <code>{{ resource.slug }}</code>
                            </p>

                            <div class="d-flex justify-content-center mb-3" style="gap: 6px;">
                                <span v-if="resource.badge_text" class="badge badge-warning text-dark px-2 py-1">
                                    <i v-if="resource.badge_icon" :class="resource.badge_icon" class="mr-1"></i>
                                    {{ resource.badge_text }}
                                </span>
                                <span v-if="resource.is_featured === 1" class="badge badge-primary px-2 py-1">
                                    <i class="fas fa-star mr-1"></i> Featured
                                </span>
                            </div>

                            <ul class="list-group list-group-unbordered mb-3 text-left">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Status</b>
                                    <span class="badge" :class="resource.status === 1 ? 'badge-success' : 'badge-secondary'">
                                        {{ resource.status === 1 ? 'Active' : 'Inactive' }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>File Type</b>
                                    <span class="badge badge-info">
                                        {{ (resource.file_type || 'file').toUpperCase() }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>File Size</b>
                                    <span>{{ resource.file_size || '—' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Sort Order</b>
                                    <span class="font-weight-bold">{{ resource.sort_order }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Created At</b>
                                    <span class="text-muted small">{{ formatDate(resource.created_at) }}</span>
                                </li>
                            </ul>

                            <!-- Download or Open Button -->
                            <div class="mt-3">
                                <a v-if="resource.file_path" :href="getFileUrl(resource.file_path)" target="_blank"
                                    class="btn btn-primary btn-block">
                                    <i class="fas fa-download mr-1"></i> Download File
                                </a>
                                <a v-else-if="resource.external_url" :href="resource.external_url" target="_blank"
                                    class="btn btn-info btn-block text-white">
                                    <i class="fas fa-external-link-alt mr-1"></i> Open External URL
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Content & Associations Card -->
                <div class="col-md-8">
                    <div class="card card-purple card-outline shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-info-circle mr-1 text-purple"></i> Resource Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4 font-weight-bold text-muted">Resource Category:</div>
                                <div class="col-sm-8">
                                    <span v-if="resource.category" class="badge badge-light border text-dark font-weight-bold px-2 py-1">
                                        <i :class="resource.category.icon || 'bi bi-folder2'" class="mr-1 text-primary"></i>
                                        {{ resource.category.name }}
                                    </span>
                                    <span v-else class="text-muted">—</span>
                                </div>
                            </div>
                            <hr class="my-2">

                            <div class="row mb-3" v-if="resource.product">
                                <div class="col-sm-4 font-weight-bold text-muted">Associated Product:</div>
                                <div class="col-sm-8">
                                    <strong>{{ resource.product.name }}</strong>
                                    <span v-if="resource.product.model" class="text-muted ml-1">({{ resource.product.model }})</span>
                                </div>
                            </div>
                            <hr class="my-2" v-if="resource.product">

                            <div class="row mb-3" v-if="resource.product_category">
                                <div class="col-sm-4 font-weight-bold text-muted">Product Category:</div>
                                <div class="col-sm-8">
                                    {{ resource.product_category.category_name }}
                                </div>
                            </div>
                            <hr class="my-2" v-if="resource.product_category">

                            <div class="row mb-3">
                                <div class="col-sm-4 font-weight-bold text-muted">Description:</div>
                                <div class="col-sm-8">
                                    <p class="mb-0 text-dark">{{ resource.description || 'No description provided.' }}</p>
                                </div>
                            </div>
                            <div class="row mb-3" v-if="resource.metadata?.graphic_icon">
                                <div class="col-sm-4 font-weight-bold text-muted">Graphic Icon:</div>
                                <div class="col-sm-8">
                                    <i :class="resource.metadata.graphic_icon" class="mr-1"></i>
                                    <code>{{ resource.metadata.graphic_icon }}</code>
                                </div>
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
import { getImageCacheUrl } from '@/layouts/helpers/helpers';

const route = useRoute();
const resource = ref(null);
const loading = ref(true);

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

const getFileUrl = (path) => {
    if (!path) return '#';
    if (/^https?:\/\//i.test(path)) return path;
    const clean = path.replace(/^\/+/, '');
    return `/${clean}`;
};

const formatDate = (dateStr) => {
    if (!dateStr) return '—';
    return new Date(dateStr).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

const fetchResource = async () => {
    loading.value = true;
    try {
        const res = await axios.get(`/api/resources/${route.params.id}`);
        resource.value = res.data.data;
    } catch (error) {
        console.error('Error fetching resource:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchResource();
});
</script>
