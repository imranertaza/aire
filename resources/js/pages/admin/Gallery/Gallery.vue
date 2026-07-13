<template>
    <DashboardHeader title="Manage Galleries">
        <div class="d-flex justify-content-end">
            <SearchBox @search="onSearch" />
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="galleries?.data?.length === 0" class="alert alert-info">No galleries found.</div>
                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Thumb</th>
                                    <th>Alt Name</th>
                                    <th>Sort Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(gallery, index) in galleries?.data" :key="gallery.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ truncateText(gallery.name, 25) }}</td>
                                    <td class="align-middle">
                                        <img v-if="gallery.thumb" :src="getImageCacheUrl(gallery.thumb, 100, 100)"
                                            alt="Gallery Thumb" height="50" class="rounded" />
                                    </td>
                                    <td class="align-middle">{{ truncateText(gallery.alt_name, 40) }}</td>
                                    <td class="align-middle">{{ gallery.sort_order }}</td>
                                    <td v-if="authStore.hasPermission('edit-galleries')" class="align-middle">
                                        <select v-model="gallery.status" @change="updateStatus(gallery)"
                                            class="custom-select"
                                            :class="gallery.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link v-if="authStore.hasPermission('view-galleries')"
                                                :to="{ name: 'ShowGallery', params: { id: gallery.id } }"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link v-if="authStore.hasPermission('edit-galleries')"
                                                :to="{ name: 'UpdateGallery', params: { id: gallery.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>
                                            <button v-if="authStore.hasPermission('delete-galleries')"
                                                class="ml-2 btn btn-sm btn-outline-danger"
                                                @click="confirmDelete(gallery)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="galleries" @page-change="fetchGalleries" />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';
import { getImageCacheUrl, truncateText } from '@/layouts/helpers/helpers';
import { useAuthStore } from '@/store/auth';
import axios from 'axios';
import { inject, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import SearchBox from '@/components/SearchBox.vue';

// Toast notifications
const toast = useToast();

// Auth store
const authStore = useAuthStore();

// Route & router
const route = useRoute();
const router = useRouter();

// Gallery list (paginated)
const galleries = ref([]);
const currentSearchTerm = ref("");
// SweetAlert2 instance
const $swal = inject('$swal');

/**
 * Fetch galleries with pagination and search
 */
const fetchGalleries = async (page = 1) => {
    try {
        const res = await axios.get(`/api/gallery?page=${page}&search=${currentSearchTerm.value}`);
        galleries.value = res.data.data; // Full paginated response
    } catch (error) {
        console.error(error);
    }
};

/**
 * Handle search - reset to page 1
 */
const onSearch = (term) => {
    currentSearchTerm.value = term;
    fetchGalleries();
};

/**
 * Toggle gallery status
 */
const updateStatus = async (gallery) => {
    try {
        const response = await axios.patch(`/api/gallery/${gallery.id}/toggle-status`);
        gallery.status = response.data.data.status;
        if (gallery.status == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

/**
 * Delete gallery with confirmation
 */
const confirmDelete = async (gallery) => {
    const result = await $swal({
        title: `Delete "${gallery.name}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/gallery/${gallery.id}`);
            toast.success('Gallery deleted successfully!');
            galleries.value.data = galleries.value?.data.filter(g => g.id !== gallery.id);
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};

// Load data on mount + handle toast query param
onMounted(async () => {
    fetchGalleries();

    if (route.query.toast) {
        toast.success(route.query.toast);
        setTimeout(() => {
            const q = { ...route.query };
            delete q.toast;
            router.replace({ query: q });
        }, 2000);
    }
});
</script>
