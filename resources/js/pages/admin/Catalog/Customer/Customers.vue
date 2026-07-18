<template>
    <DashboardHeader title="Manage Customers">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" class="mr-2" />
            <router-link v-if="authStore.hasPermission('create-customers')" :to="{ name: 'CreateCustomer' }"
                class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Customer
            </router-link>
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="customers?.data?.length === 0" class="alert alert-info">No customers found.</div>

                <div v-else class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr class="align-middle">
                                        <th style="width: 10px">#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Balance</th>
                                        <th>Point</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(customer, index) in customers?.data" :key="customer.id">
                                        <td class="align-middle">{{ index + 1 }}</td>
                                        <td class="align-middle">{{ customer.firstname }}</td>
                                        <td class="align-middle">{{ customer.lastname }}</td>
                                        <td class="align-middle">{{ customer.email }}</td>
                                        <td class="align-middle">{{ customer.phone }}</td>
                                        <td class="align-middle">{{ customer.balance ?? '0.00' }}</td>
                                        <td class="align-middle">{{ customer.point ?? 0 }}</td>
                                        <td class="align-middle">
                                            <div class="d-flex flex-wrap" style="gap:4px">

                                                <router-link
                                                    :to="{ name: 'CustomerPointHistory', params: { id: customer.id } }"
                                                    class="btn btn-xs btn-success text-nowrap">
                                                    <i class="fas fa-book"></i> Point
                                                </router-link>

                                                <router-link
                                                    :to="{ name: 'CustomerLedger', params: { id: customer.id } }"
                                                    class="btn btn-xs btn-info text-nowrap">
                                                    <i class="fas fa-book"></i> Ledger
                                                </router-link>

                                                <router-link v-if="authStore.hasPermission('edit-customers')"
                                                    :to="{ name: 'UpdateCustomer', params: { id: customer.id } }"
                                                    class="btn btn-xs btn-primary text-nowrap">
                                                    <i class="fas fa-pencil-alt"></i> Update
                                                </router-link>

                                                <button v-if="authStore.hasPermission('delete-customers')"
                                                    class="btn btn-xs btn-danger text-nowrap"
                                                    @click="confirmDelete(customer)">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <Pagination :pData="customers" :showPage="perPage" @page-change="fetchPage" />
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

const customers = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
const perPage = ref(10);

const fetchPage = async (page = 1) => {
    try {
        const res = await axios.get(`/api/customers?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        customers.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load customers.');
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

const confirmDelete = async (customer) => {
    const result = await $swal({
        title: `Delete customer "${customer.firstname} ${customer.lastname}"?`,
        text: 'This action cannot be undone and will delete all their history.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/customers/${customer.id}`);
            toast.success('Customer deleted successfully!');
            fetchPage();
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
