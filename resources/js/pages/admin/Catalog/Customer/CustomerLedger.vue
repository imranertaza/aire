<template>
    <DashboardHeader :title="'Customer Ledger: ' + customerName">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <RouterLink :to="{ name: 'Customers' }" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Customers
            </RouterLink>
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="ledgerData?.data?.length === 0" class="alert alert-info">No ledger records found for this customer.</div>

                <div v-else class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr class="align-middle">
                                        <th style="width: 10px">#</th>
                                        <th>Date</th>
                                        <th>Particulars</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Rest Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(record, index) in ledgerData?.data" :key="record.id">
                                        <td class="align-middle">{{ index + 1 }}</td>
                                        <td class="align-middle">{{ formatDate(record.created_at) }}</td>
                                        <td class="align-middle">{{ record.particulars }}</td>
                                        <td class="align-middle">
                                            <span class="badge" 
                                                :class="record.transaction_type === 'Cr.' ? 'badge-success' : 'badge-danger'">
                                                {{ record.transaction_type }}
                                            </span>
                                        </td>
                                        <td class="align-middle">{{ record.amount }}</td>
                                        <td class="align-middle">{{ record.rest_balance }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <Pagination :pData="ledgerData" :showPage="perPage" @page-change="fetchLedger" />
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
import { useRoute } from 'vue-router';
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';

const route = useRoute();
const toast = useToast();
const ledgerData = ref([]);
const customerName = ref('Loading...');
const perPage = ref(10);

const fetchCustomer = async () => {
    try {
        const res = await axios.get(`/api/customers/${route.params.id}`);
        customerName.value = `${res.data.data.firstname} ${res.data.data.lastname}`;
    } catch (error) {
        console.error(error);
    }
};

const fetchLedger = async (page = 1) => {
    try {
        const res = await axios.get(`/api/customers/${route.params.id}/ledger?page=${page}&per_page=${perPage.value}`);
        ledgerData.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load ledger records.');
    }
};

const onPerPageChange = () => {
    fetchLedger(1);
};

onMounted(() => {
    fetchCustomer();
    fetchLedger();
});

const formatDate = (dateStr) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>
