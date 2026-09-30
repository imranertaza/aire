<template>
    <DashboardHeader title="Manage Result">
        <div class="d-flex justify-content-end">
            <SearchBox @search="onSearch" />
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="results?.data?.length === 0" class="alert alert-info">No results found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Title</th>
                                    <th>File</th>
                                    <th>Type</th>
                                    <th v-if="authStore.hasPermission('edit-results')">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(result, index) in results?.data" :key="result.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ truncateText(result.title, 20) }}</td>
                                    <td class="align-middle">
                                        <a v-if="result.file" :href="getImageUrl(result.file)" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                            View File
                                        </a>
                                    </td>
                                    <td class="align-middle">{{ result.type == 1 ? 'National' : 'International' }}</td>

                                    <td v-if="authStore.hasPermission('edit-results')" class="align-middle">
                                        <select v-model="result.status" @change="updateStatus(result)"
                                            class="custom-select"
                                            :class="result.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link v-if="authStore.hasPermission('view-results')"
                                                :to="{ name: 'ShowResult', params: { id: result.id } }"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link v-if="authStore.hasPermission('edit-results')"
                                                :to="{ name: 'UpdateResult', params: { id: result.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>
                                            <button v-if="authStore.hasPermission('delete-results')"
                                                class="ml-2 btn btn-sm btn-outline-danger"
                                                @click="confirmDelete(result)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="results" @page-change="fetchPage" />
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
const results = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
// Fetch results with pagination + search
const fetchPage = async (page = 1) => {
    try {
        const res = await axios.get(`/api/results?page=${page}&search=${currentSearchTerm.value}`);
        results.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load results.');
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

// Update result status
const updateStatus = async (result) => {
    try {
        const response = await axios.patch(`/api/results/${result.id}/toggle-status`);
        result.status = response?.data?.data?.status;
        if (result.status == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

// Delete result
const confirmDelete = async (result) => {
    const resultConfirm = await $swal({
        title: `Delete "${result.title}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (resultConfirm.isConfirmed) {
        try {
            await axios.delete(`/api/results/${result.id}`);
            toast.success('Result deleted successfully!');
            results.value.data = results.value.data.filter(r => r.id !== result.id);
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
