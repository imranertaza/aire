<template>
    <DashboardHeader title="Manage Geo Zones">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" class="mr-2" />
            <router-link v-if="authStore.hasPermission('create-geo-zones')" to="/admin/geo-zones/create" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Add New
            </router-link>
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
                
                <div v-else-if="geoZones?.data?.length === 0" class="alert alert-info">No geo zones found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Sort Order</th>
                                    <th v-if="authStore.hasPermission('edit-geo-zones')">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(zone, index) in geoZones?.data" :key="zone.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ zone.geo_zone_name }}</td>
                                    <td class="align-middle">{{ zone.geo_zone_description }}</td>
                                    <td class="align-middle">{{ zone.sort_order }}</td>
                                    <td v-if="authStore.hasPermission('edit-geo-zones')" class="align-middle">
                                        <BootstrapSwitch 
                                            :modelValue="zone.status === 1"
                                            @update:modelValue="toggleStatus(zone)"
                                        />
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link v-if="authStore.hasPermission('edit-geo-zones')"
                                                :to="{ name: 'UpdateGeoZone', params: { id: zone.id } }"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>
                                            <button v-if="authStore.hasPermission('delete-geo-zones')"
                                                class="ml-2 btn btn-sm btn-outline-danger"
                                                @click="confirmDelete(zone)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="geoZones" @page-change="fetchPage" />
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
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';
import BootstrapSwitch from '@/components/BootstrapSwitch.vue';

const router = useRouter();
const route = useRoute();
const geoZones = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
const perPage = ref(10);
const isLoading = ref(false);

const fetchPage = async (page = 1) => {
    isLoading.value = true;
    try {
        const res = await axios.get(`/api/geo-zones?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        geoZones.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load geo zones.');
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
    if (route.query.toast) {
        toast.success(route.query.toast);
        setTimeout(() => {
            const q = { ...route.query };
            delete q.toast;
            router.replace({ query: q });
        }, 2000);
    }
});

const toggleStatus = async (zone) => {
    try {
        const response = await axios.patch(`/api/geo-zones/${zone.id}/status`);
        zone.status = response.data.data.status;
        if (zone.status == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

const confirmDelete = async (zone) => {
    const result = await $swal({
        title: `Delete "${zone.geo_zone_name}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/geo-zones/${zone.id}`);
            toast.success('Geo Zone deleted successfully!');
            fetchPage();
        } catch (error) {
            toast.error(error.response?.data?.message || 'Failed to delete geo zone');
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
