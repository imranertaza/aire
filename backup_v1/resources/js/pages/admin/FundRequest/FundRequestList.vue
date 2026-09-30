<template>
    <DashboardHeader title="Fund Requests">
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

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div v-if="requests?.data?.length === 0" class="alert alert-info">No fund requests found.</div>

                <div v-else>
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Card Details</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(request, index) in requests?.data" :key="request.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">
                                        <div v-if="request.customer">
                                            <strong>{{ request.customer.firstname }} {{ request.customer.lastname }}</strong><br>
                                            <small class="text-muted">{{ request.customer.email }}</small>
                                        </div>
                                        <div v-else class="text-muted">Unknown Customer</div>
                                    </td>
                                    <td class="align-middle font-weight-bold text-success">
                                        ${{ parseFloat(request.amount).toFixed(2) }}
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-info" v-if="request.payment_method">{{ request.payment_method.name }}</span>
                                        <span class="text-muted" v-else>N/A</span>
                                    </td>
                                    <td class="align-middle">
                                        <div v-if="request.card_name">
                                            <small>
                                                <strong>Name:</strong> {{ request.card_name }}<br>
                                                <strong>Card:</strong> **** **** **** {{ request.card_number ? request.card_number.slice(-4) : '****' }}<br>
                                                <strong>Exp:</strong> {{ request.card_expiration }}
                                            </small>
                                        </div>
                                        <div v-else class="text-muted"><small>No Card Details</small></div>
                                    </td>
                                    <td class="align-middle">
                                        <select v-model="request.status" @change="updateStatus(request)"
                                            class="custom-select custom-select-sm"
                                            :class="{
                                                'bg-success text-white': request.status === 'Complete',
                                                'bg-warning text-dark': request.status === 'Pending',
                                                'bg-danger text-white': request.status === 'Canceled'
                                            }">
                                            <option value="Pending">Pending</option>
                                            <option value="Complete">Complete</option>
                                            <option value="Canceled">Canceled</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <small>{{ new Date(request.created_at).toLocaleString() }}</small>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button @click="deleteRequest(request)" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                            <Pagination :pData="requests" @page-change="fetchPage" class="mt-3 px-3" />
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import axios from 'axios';
import { inject, onMounted, ref } from 'vue';
import DashboardHeader from '@/components/DashboardHeader.vue';
import Pagination from '@/components/Paginations/Pagination.vue';
import SearchBox from '@/components/SearchBox.vue';
import { useToast } from '@/composables/useToast';

const toast = useToast();
const $swal = inject('$swal');

const requests = ref([]);
const currentSearchTerm = ref("");
const perPage = ref(10);

const fetchPage = async (page = 1) => {
    try {
        const res = await axios.get(`/api/fund-requests?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        requests.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load fund requests');
    }
};

const onSearch = async (term) => {
    currentSearchTerm.value = term;
    fetchPage();
};

const onPerPageChange = () => {
    fetchPage(1);
};

const updateStatus = async (request) => {
    try {
        await axios.put(`/api/fund-requests/${request.id}`, { status: request.status });
        toast.success(`Request marked as ${request.status}`);
    } catch (error) {
        // Revert UI on error
        fetchPage();
        toast.error('Failed to update status');
    }
};

const deleteRequest = async (request) => {
    const result = await $swal({
        title: `Delete Fund Request?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/fund-requests/${request.id}`);
            toast.success('Fund request deleted successfully!');
            requests.value.data = requests.value.data.filter(r => r.id !== request.id);
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};

onMounted(() => {
    fetchPage();
});
</script>
