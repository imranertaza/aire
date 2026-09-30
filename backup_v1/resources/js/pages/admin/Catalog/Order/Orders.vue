<template>
    <DashboardHeader title="Manage Orders">
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
                <div v-if="orders?.data?.length === 0" class="alert alert-info">No orders found.</div>

                <div v-else class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr class="align-middle text-center">
                                        <th style="width: 10px">#</th>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Payment Method</th>
                                        <th>Total</th>
                                        <th>Payment Status</th>
                                        <th>Order Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(order, index) in orders?.data" :key="order.id" class="text-center">
                                        <td class="align-middle">{{ index + 1 }}</td>
                                        <td class="align-middle font-weight-bold">#{{ order.id }}</td>
                                        <td class="align-middle text-left">
                                            {{ order.payment_firstname }} {{ order.payment_lastname }}
                                        </td>
                                        <td class="align-middle">{{ order.payment_method }}</td>
                                        <td class="align-middle font-weight-bold">{{ order.final_amount }}</td>
                                        <td class="align-middle">
                                            <span class="badge" 
                                                :class="{
                                                    'badge-success': order.payment_status === 'Paid',
                                                    'badge-warning': order.payment_status === 'Pending',
                                                    'badge-danger': order.payment_status === 'Failed'
                                                }">
                                                {{ order.payment_status }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-info">
                                                {{ order.order_status?.name || 'Unknown' }}
                                            </span>
                                        </td>
                                        <td class="align-middle small">{{ formatDate(order.created_at) }}</td>
                                        <td class="align-middle">
                                            <div class="d-flex justify-content-center gap-1">
                                                <router-link 
                                                    :to="{ name: 'OrderView', params: { id: order.id } }"
                                                    class="btn btn-xs btn-primary mr-1">
                                                    <i class="fas fa-eye"></i> View
                                                </router-link>
                                                <button v-if="authStore.hasPermission('delete-orders')"
                                                    class="btn btn-xs btn-danger"
                                                    @click="confirmDelete(order)">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <Pagination :pData="orders" :showPage="perPage" @page-change="fetchPage" />
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
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';

const orders = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
const perPage = ref(10);

const fetchPage = async (page = 1) => {
    try {
        const res = await axios.get(`/api/orders?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        orders.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load orders.');
    }
};

const onSearch = async (term) => {
    currentSearchTerm.value = term;
    fetchPage(1);
};

const onPerPageChange = () => {
    fetchPage(1);
};

onMounted(() => {
    fetchPage();
});

const formatDate = (dateStr) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

const confirmDelete = async (order) => {
    const result = await $swal({
        title: `Delete order #${order.id}?`,
        text: 'This will delete the items, options, card details, and history associated with this order.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/orders/${order.id}`);
            toast.success('Order deleted successfully!');
            fetchPage();
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
