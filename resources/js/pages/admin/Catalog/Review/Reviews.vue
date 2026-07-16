<template>
    <DashboardHeader title="Manage Reviews">
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
                <div v-if="reviews?.data?.length === 0" class="alert alert-info">No reviews found.</div>

                <div v-else class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr class="align-middle">
                                        <th style="width: 10px">#</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Rating</th>
                                        <th>Feedback</th>
                                        <th>Date</th>
                                        <th v-if="authStore.hasPermission('edit-reviews')">Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(review, index) in reviews?.data" :key="review.id">
                                        <td class="align-middle">{{ index + 1 }}</td>
                                        <td class="align-middle">
                                            <span v-if="review.customer">
                                                {{ review.customer.firstname }} {{ review.customer.lastname }}
                                            </span>
                                            <span v-else class="text-muted">Guest / Unknown</span>
                                        </td>
                                        <td class="align-middle">
                                            <span v-if="review.product">{{ review.product.name }}</span>
                                            <span v-else class="text-muted">Product Deleted</span>
                                        </td>
                                        <td class="align-middle text-nowrap">
                                            <i v-for="star in 5" :key="star" 
                                                class="fa-star mr-1"
                                                :class="star <= review.feedback_star ? 'fas text-warning' : 'far text-muted'"
                                            ></i>
                                        </td>
                                        <td class="align-middle">{{ review.feedback_text }}</td>
                                        <td class="align-middle">{{ formatDate(review.created_at) }}</td>
                                        <td v-if="authStore.hasPermission('edit-reviews')" class="align-middle">
                                            <select v-model="review.status" @change="updateStatus(review)"
                                                class="custom-select"
                                                :class="review.status === 1 ? 'bg-success text-white' : 'bg-warning text-dark'">
                                                <option :value="1">Active</option>
                                                <option :value="0">Inactive</option>
                                            </select>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex">
                                                <button v-if="authStore.hasPermission('delete-reviews')"
                                                    class="btn btn-sm btn-outline-danger"
                                                    @click="confirmDelete(review)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <Pagination :pData="reviews" :showPage="perPage" @page-change="fetchPage" />
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
const reviews = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
const perPage = ref(10);

const fetchPage = async (page = 1) => {
    try {
        const res = await axios.get(`/api/reviews?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        reviews.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load reviews.');
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

const updateStatus = async (review) => {
    try {
        const response = await axios.patch(`/api/reviews/${review.id}/toggle-status`);
        review.status = response.data.data.status;
        toast.success(response.data.message);
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

const confirmDelete = async (review) => {
    const result = await $swal({
        title: `Delete this review?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/reviews/${review.id}`);
            toast.success('Review deleted successfully!');
            reviews.value.data = reviews.value.data.filter(r => r.id !== review.id);
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};

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
