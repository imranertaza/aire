<template>
    <DashboardHeader title="Payment Methods">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" class="mr-2" />
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div v-if="methods?.data?.length === 0" class="alert alert-info">No payment methods found.</div>
                        <div v-else class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">Sl</th>
                                        <th style="width: 15%">Image</th>
                                        <th style="width: 25%">Name</th>
                                        <th style="width: 20%">Code</th>
                                        <th style="width: 15%">Status</th>
                                        <th style="width: 20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(method, index) in methods?.data" :key="method.id">
                                        <td class="align-middle">{{ index + 1 }}</td>
                                        <td class="align-middle text-center">
                                            <img v-if="method.image" :src="`/images/payment/${method.image}`" alt="Payment logo" style="max-height: 40px; max-width: 80px; object-fit: contain;">
                                            <span v-else class="text-muted">N/A</span>
                                        </td>
                                        <td class="align-middle">{{ method.name }}</td>
                                        <td class="align-middle">
                                            <span class="badge badge-secondary">{{ method.code }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <BootstrapSwitch 
                                                :modelValue="method.status === 1"
                                                @update:modelValue="val => toggleStatus(method.id)"
                                                :disabled="!authStore.hasPermission('edit-payment-methods')"
                                            />
                                        </td>
                                        <td class="align-middle">
                                            <router-link v-if="authStore.hasPermission('view-payment-methods')"
                                                :to="{ name: 'PaymentSettings', params: { id: method.id } }"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-cogs"></i> Settings
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-3" v-if="methods?.data?.length > 0">
                            <Pagination :pData="methods" @page-change="fetchPage" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { onMounted, ref } from 'vue';
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';
import BootstrapSwitch from '@/components/BootstrapSwitch.vue';

const methods = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const currentSearchTerm = ref('');
const perPage = ref(10);

const fetchPage = async (page = 1) => {
    try {
        const res = await axios.get(`/api/payment-methods?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        methods.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load payment methods.');
    }
};

const onSearch = (term) => {
    currentSearchTerm.value = term;
    fetchPage();
};

const onPerPageChange = () => {
    fetchPage(1);
};

const toggleStatus = async (id) => {
    try {
        await axios.patch(`/api/payment-methods/${id}/status`);
        toast.success('Status updated successfully');
        fetchPage(methods.value.current_page);
    } catch (error) {
        toast.error('Failed to update status');
        fetchPage(methods.value.current_page); // Revert switch if failed
    }
};

onMounted(() => {
    fetchPage();
});
</script>
