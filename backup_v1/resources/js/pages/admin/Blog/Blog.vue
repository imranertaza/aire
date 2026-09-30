<template>
    <DashboardHeader title="Manage Blogs">
        <div class="d-flex justify-content-end">
            <SearchBox @search="onSearch" />
        </div>
    </DashboardHeader>

    <section class="">
        <div class="row">
            <div class="col-md-12">
                <div v-if="news?.data?.length === 0" class="alert alert-info">No blogs found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th v-if="authStore.hasPermission('publish-blog')">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in news?.data" :key="item.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ truncateText(item.title, 20) }}</td>
                                    <td class="align-middle">{{ truncateText(item.short_des, 50) }}</td>
                                    <td class="align-middle">
                                        <img v-if="item.image" draggable="false"
                                            :src="getImageCacheUrl(item.f_image, 100, 100)" alt="Blog Image" height="50"
                                            class="rounded" />
                                    </td>
                                    <td v-if="authStore.hasPermission('publish-blog')" class="align-middle">
                                        <select v-model="item.status" @change="updateStatus(item)" class="custom-select"
                                            :class="item.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex ">
                                            <router-link v-if="authStore.hasPermission('view-blog')"
                                                :to="{ name: 'ShowBlog', params: { id: item.id } }"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link v-if="authStore.hasPermission('edit-blog')"
                                                :to="{ name: 'UpdateBlog', params: { id: item.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>
                                            <button v-if="authStore.hasPermission('delete-blog')"
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
import { getImageCacheUrl, truncateText } from '@/layouts/helpers/helpers';
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';

// Router & route instances
const router = useRouter();
const route = useRoute();

// Reactive list of blogs (from paginated API response)
const news = ref([]);

// Auth store (if needed for user/role checks)
const authStore = useAuthStore();

// Toast notifications
const toast = useToast();

// SweetAlert2 instance injected from main.js
const $swal = inject('$swal');
const currentSearchTerm = ref("");
/**
 * Fetch blogs with optional pagination and search term
 * @param {number} page - Page number (default: 1)
 * @param {string} term - Search query (default: empty)
 */
const fetchPage = async (page = 1) => {
    try {
        const res = await axios.get(`/api/blogs?page=${page}&search=${currentSearchTerm.value}`);
        news.value = res.data.data; // Full paginated response (data + pagination meta)
    } catch (error) {
        console.error(error);
        toast.error('Failed to load blogs.');
    }
};

/**
 * Trigger search - resets to page 1 with the given term
 */
const onSearch = async (term) => {
    currentSearchTerm.value = term;
    fetchPage();
};

// Load initial data on component mount
onMounted(async () => {
    await fetchPage();

    // Show success toast from query param (e.g., after create/update)
    if (route.query.toast) {
        toast.success(route.query.toast);
        // Clean up query param after showing toast
        setTimeout(() => {
            const q = { ...route.query };
            delete q.toast;
            router.replace({ query: q });
        }, 2000);
    }
});

/**
 * Toggle blog publish status (published ↔ draft)
 */
const updateStatus = async (item) => {
    try {
        const response = await axios.patch(`/api/blogs/${item.id}/status`, {
            status: item.status
        });

        if (response.data.data.status == 1) {
            toast.success('Blog published');
        } else {
            toast.info('Blog set to draft');
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

/**
 * Confirm and delete a blog post
 */
const confirmDelete = async (item) => {
    const result = await $swal({
        title: `Delete "${item.title}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/blogs/${item.id}`);
            toast.success('Blog deleted successfully!');

            // Remove deleted item from local list (optimistic update)
            news.value.data = news.value.data.filter(n => n.id !== item.id);
        } catch (error) {
            toast.error('Failed to delete blog.');
            console.error(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
