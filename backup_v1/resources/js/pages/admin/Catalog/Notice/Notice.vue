<template>
    <DashboardHeader title="Manage Notice">
        <div class="d-flex justify-content-end">
            <SearchBox @search="onSearch" />
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="notices?.data?.length === 0" class="alert alert-info">No notices found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Title</th>
                                    <th>File</th>
                                    <th v-if="authStore.hasPermission('edit-notices')">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(notice, index) in notices?.data" :key="notice.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ truncateText(notice.title, 20) }}</td>
                                    <td class="align-middle">
                                        <a v-if="notice.file" :href="getImageUrl(notice.file)" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            View File
                                        </a>
                                    </td>
                                    <td v-if="authStore.hasPermission('edit-notices')" class="align-middle">
                                        <select v-model="notice.status" @change="updateStatus(notice)"
                                            class="custom-select"
                                            :class="notice.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link v-if="authStore.hasPermission('view-notices')"
                                                :to="{ name: 'ShowNotice', params: { id: notice.id } }"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link v-if="authStore.hasPermission('edit-notices')"
                                                :to="{ name: 'UpdateNotice', params: { id: notice.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>
                                            <button v-if="authStore.hasPermission('delete-notices')"
                                                class="ml-2 btn btn-sm btn-outline-danger"
                                                @click="confirmDelete(notice)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="notices" @page-change="fetchPage" />
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
import { getImageUrl, truncateText } from '@/layouts/helpers/helpers';
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';

const router = useRouter();
const route = useRoute();
const notices = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
// Fetch notices with pagination + search
const fetchPage = async (page = 1, term = "") => {
    try {
        const res = await axios.get(`/api/notices?page=${page}&search=${currentSearchTerm.value}`);
        notices.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load notices.');
    }
};

const onSearch = async (term) => {
    currentSearchTerm.value = term;
    fetchPage();
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

// Update notice status
const updateStatus = async (notice) => {
    try {
        const response = await axios.patch(`/api/notices/${notice.id}/toggle-status`);
        notice.status = response.data.data.status;
        if (notice.status == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

// Delete notice
const confirmDelete = async (notice) => {
    const result = await $swal({
        title: `Delete "${notice.title}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/notices/${notice.id}`);
            toast.success('Notice deleted successfully!');
            notices.value.data = notices.value.data.filter(n => n.id !== notice.id);
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
