<template>
    <DashboardHeader title="Manage News">
        <div class="d-flex justify-content-end">
            <SearchBox @search="onSearch" />
        </div>
    </DashboardHeader>

    <section class="">
        <div class="row">
            <div class="col-md-12">
                <div v-if="news?.data?.length === 0" class="alert alert-info">No news found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th v-if="authStore.hasPermission('publish-news')">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in news?.data" :key="item.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ truncateText(item.news_title, 20) }}</td>
                                    <td class="align-middle">{{ truncateText(item.short_des, 50) }}</td>
                                    <td class="align-middle">
                                        <img draggable="false" :src="getImageCacheUrl(item.f_image, 100, 100)"
                                            alt="News Image" height="50" class="rounded" />
                                    </td>

                                    <td v-if="authStore.hasPermission('publish-news')" class="align-middle">
                                        <select v-model="item.status" @change="updateStatus(item)" class="custom-select"
                                            :class="item.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex ">
                                            <router-link v-if="authStore.hasPermission('view-news')"
                                                :to="{ name: 'ShowNews', params: { id: item.id } }"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link v-if="authStore.hasPermission('edit-news')"
                                                :to="{ name: 'UpdateNews', params: { id: item.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>
                                            <button v-if="authStore.hasPermission('delete-news')"
                                                class="ml-2 btn btn-sm btn-outline-danger" @click="confirmDelete(item)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="news" @page-change="fetchPage" />
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
import { getImageUrl, truncateText, getImageCacheUrl } from '@/layouts/helpers/helpers';
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';
const currentSearchTerm = ref("");
// Router & route
const router = useRouter();
const route = useRoute();

// News list (paginated response)
const news = ref([]);

// Auth store (if needed for permissions)
const authStore = useAuthStore();

// Toast notifications
const toast = useToast();

// SweetAlert2 instance
const $swal = inject('$swal');

/**
 * Fetch news with pagination and optional search
 */
const fetchPage = async (page = 1) => {
    try {
        const res = await axios.get(`/api/news?page=${page}&search=${currentSearchTerm.value}`);
        news.value = res.data.data; // Full paginated response
    } catch (error) {
        console.error(error);
        toast.error('Failed to load news.');
    }
};

/**
 * Handle search - reset to page 1
 */
const onSearch = async (term) => {
    currentSearchTerm.value = term;
    fetchPage();
};

// Load initial data + handle toast query param
onMounted(async () => {
    await fetchPage();

    if (route.query.toast) {
        toast.success(route.query.toast);
        setTimeout(() => {
            const q = { ...route.query };
            delete q.toast;
            router.replace({ query: q });
        }, 2000);
    }
});

/**
 * Toggle news publish status (published ↔ draft)
 */
const updateStatus = async (item) => {
    try {
        const response = await axios.patch(`/api/news/${item.id}/status`, {
            status: item.status
        });

        if (response.data.data.status == 1) {
            toast.success('News published');
        } else {
            toast.info('News set to draft');
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

/**
 * Confirm and delete a news item
 */
const confirmDelete = async (item) => {
    const result = await $swal({
        title: `Delete "${item.news_title}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/news/${item.id}`);
            toast.success('News deleted successfully!');
            // Optimistic update
            news.value.data = news.value.data.filter(n => n.id !== item.id);
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
