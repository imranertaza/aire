<template>
    <DashboardHeader title="Manage Coupons">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" class="mr-2" />
            <router-link v-if="authStore.hasPermission('create-coupons')" 
                :to="{ name: 'CreateCoupon' }" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Coupon
            </router-link>
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div v-if="coupons?.data?.length === 0" class="alert alert-info">No coupons found.</div>
                        <div v-else class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr class="align-middle">
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Discount</th>
                                        <th>Total Used</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th v-if="authStore.hasPermission('edit-coupons')">Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(coupon, index) in coupons?.data" :key="coupon.id">
                                        <td class="align-middle">{{ index + 1 }}</td>
                                        <td class="align-middle">{{ coupon.name }}</td>
                                        <td class="align-middle"><span class="badge badge-info">{{ coupon.code }}</span></td>
                                        <td class="align-middle">
                                            {{ coupon.discount }} {{ coupon.discount_type == 1 ? '%' : 'Flat' }}
                                        </td>
                                        <td class="align-middle">{{ coupon.total_used }} / {{ coupon.total_useable }}</td>
                                        <td class="align-middle">{{ coupon.date_start }}</td>
                                        <td class="align-middle">{{ coupon.date_end }}</td>
                                        <td v-if="authStore.hasPermission('edit-coupons')" class="align-middle">
                                            <select v-model="coupon.status" @change="updateStatus(coupon)"
                                                class="custom-select"
                                                :class="coupon.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                                <option :value="1">Active</option>
                                                <option :value="0">Inactive</option>
                                            </select>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex">
                                                <router-link v-if="authStore.hasPermission('edit-coupons')"
                                                    :to="{ name: 'UpdateCoupon', params: { id: coupon.id } }"
                                                    class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </router-link>
                                                <button v-if="authStore.hasPermission('delete-coupons')"
                                                    class="ml-2 btn btn-sm btn-outline-danger"
                                                    @click="confirmDelete(coupon)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-3" v-if="coupons?.data?.length > 0">
                            <Pagination :pData="coupons" @page-change="fetchPage" />
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
import { inject, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';

const router = useRouter();
const route = useRoute();
const coupons = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
const perPage = ref(10);

const fetchPage = async (page = 1, term = "") => {
    try {
        const res = await axios.get(`/api/coupons?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        coupons.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load coupons.');
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

const updateStatus = async (coupon) => {
    try {
        const response = await axios.patch(`/api/coupons/${coupon.id}/toggle-status`);
        coupon.status = response.data.data.status;
        if (coupon.status == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

const confirmDelete = async (coupon) => {
    const result = await $swal({
        title: `Delete "${coupon.name}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/coupons/${coupon.id}`);
            toast.success('Coupon deleted successfully!');
            fetchPage();
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
