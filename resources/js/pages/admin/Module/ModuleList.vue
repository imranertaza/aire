<template>
    <DashboardHeader title="System Modules">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" />
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="isLoading" class="text-center p-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                <div v-else-if="modules?.data?.length === 0" class="alert alert-info">No modules found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Module Name</th>
                                    <th>Module Key</th>
                                    <th v-if="authStore.hasPermission('edit-modules')" class="text-right"
                                        style="width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(module, index) in modules?.data" :key="module.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ module.name }}</td>
                                    <td class="align-middle"><code>{{ module.module_key }}</code></td>
                                    <td v-if="authStore.hasPermission('edit-modules')" class="align-middle text-right">
                                        <div class="d-flex justify-content-start align-items-center" style="gap: 15px;">
                                            <BootstrapSwitch :modelValue="module.status === 1"
                                                @update:modelValue="toggleStatus(module)" />
                                            <router-link v-if="module.settings_exists"
                                                :to="{ name: 'ModuleSettings', params: { id: module.id } }"
                                                class="btn btn-sm btn-outline-info" title="Configure">
                                                <i class="fas fa-cog"></i>
                                            </router-link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="modules" @page-change="fetchPage" />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';
import BootstrapSwitch from '@/components/BootstrapSwitch.vue';

const router = useRouter();
const route = useRoute();
const modules = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const currentSearchTerm = ref("");
const perPage = ref(10);
const isLoading = ref(false);

const fetchPage = async (page = 1) => {
    isLoading.value = true;
    try {
        const res = await axios.get(`/api/modules?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        modules.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load modules.');
    } finally {
        isLoading.value = false;
    }
};

const onSearch = async (term) => {
    currentSearchTerm.value = term;
    fetchPage();
};

const onPerPageChange = () => {
    fetchPage(1);
};

onMounted(() => {
    fetchPage();
});

const toggleStatus = async (module) => {
    try {
        const response = await axios.patch(`/api/modules/${module.id}/status`);
        module.status = response.data.data.status;
        if (module.status == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};
</script>
