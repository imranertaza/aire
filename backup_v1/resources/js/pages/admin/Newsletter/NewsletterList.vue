<template>
    <DashboardHeader title="Newsletters">
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
                    <div v-if="newsletters?.data?.length === 0" class="alert alert-info">No subscribers found.</div>

                    <div v-else>
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                        <tr class="align-middle">
                                            <th style="width: 10px">#</th>
                                            <th>Email</th>
                                            <th>Customer Details</th>
                                            <th>Subscribed At</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(newsletter, index) in newsletters?.data" :key="newsletter.id">
                                            <td class="align-middle">{{ index + 1 }}</td>
                                            <td class="align-middle">{{ newsletter.email }}</td>
                                            <td class="align-middle">
                                                <span v-if="newsletter.customer">
                                                    {{ newsletter.customer.firstname }} {{ newsletter.customer.lastname }}
                                                </span>
                                                <span v-else class="text-muted">Guest / Unknown</span>
                                            </td>
                                            <td class="align-middle">{{ new Date(newsletter.created_at).toLocaleDateString() }}</td>
                                            <td class="align-middle">
                                                <select v-model="newsletter.status" @change="toggleStatus(newsletter)"
                                                    class="custom-select custom-select-sm"
                                                    :class="newsletter.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                                    <option :value="1">Active</option>
                                                    <option :value="0">Inactive</option>
                                                </select>
                                            </td>
                                            <td class="align-middle text-center">
                                                <button @click="deleteSubscriber(newsletter)" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <Pagination :pData="newsletters" @page-change="fetchPage" class="mt-3 px-3" />
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, inject } from 'vue';
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import Pagination from '@/components/Paginations/Pagination.vue';
import SearchBox from '@/components/SearchBox.vue';
import { useToast } from '@/composables/useToast';

const toast = useToast();
const $swal = inject('$swal');

const newsletters = ref([]);
const currentSearchTerm = ref("");
const perPage = ref(10);

const fetchPage = async (page = 1) => {
    try {
        const res = await axios.get(`/api/newsletters?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        newsletters.value = res.data.data;
    } catch (error) {
        toast.error('Failed to load newsletters');
    }
};

const onSearch = async (term) => {
    currentSearchTerm.value = term;
    fetchPage();
};

const onPerPageChange = () => {
    fetchPage(1);
};

const toggleStatus = async (newsletter) => {
    try {
        await axios.post(`/api/newsletters/${newsletter.id}/toggle`);
        toast.success('Status updated successfully');
    } catch (error) {
        // Revert on failure
        newsletter.status = newsletter.status == 1 ? 0 : 1;
        toast.error('Failed to update status');
    }
};

const deleteSubscriber = async (newsletter) => {
    const result = await $swal({
        title: `Delete Subscriber?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/newsletters/${newsletter.id}`);
            toast.success('Subscriber deleted successfully');
            newsletters.value.data = newsletters.value.data.filter(n => n.id !== newsletter.id);
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
