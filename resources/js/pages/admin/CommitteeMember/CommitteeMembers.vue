<template>
    <DashboardHeader title="Manage Committee Members">
        <div class="d-flex justify-content-end">
            <SearchBox @search="onSearch" />
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="members?.data?.length === 0" class="alert alert-info">No committee members found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Image</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(member, index) in members?.data" :key="member.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ truncateText(member.name, 20) }}</td>
                                    <td class="align-middle">{{ truncateText(member.designation, 20) }}</td>
                                    <td class="align-middle">
                                        <button v-if="member.image" @click="openImageModal(member.image)"
                                            class="btn btn-sm btn-outline-primary">
                                            View Image
                                        </button>
                                    </td>
                                    <td class="align-middle">{{ member.order }}</td>
                                    <td class="align-middle">
                                        <select v-model="member.status" @change="updateStatus(member)"
                                            class="custom-select"
                                            :class="member.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link
                                                :to="{ name: 'UpdateCommitteeMembers', params: { id: member.id } }"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>
                                            <button class="ml-2 btn btn-sm btn-outline-danger"
                                                @click="confirmDelete(member)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="members" @page-change="fetchPage" />
                </div>
            </div>
        </div>

        <!-- Image Modal -->
        <div v-if="showModal" @click="closeImageModal" class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document" @click.stop>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Committee Member Image</h5>
                        <button type="button" class="close" @click="closeImageModal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img :src="modalImage" alt="Committee Member" class="img-fluid rounded border" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Backdrop -->
        <div v-if="showModal" class="modal-backdrop fade show"></div>

    </section>
</template>

<script setup>
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { inject, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';
import { getImageUrl, truncateText } from '@/layouts/helpers/helpers';
import SearchBox from '@/components/SearchBox.vue';

// Router & route instances
const router = useRouter();
const route = useRoute();

// Reactive list of committee members (paginated response)
const members = ref([]);

// Toast notifications
const toast = useToast();

// SweetAlert2 instance (injected from app setup)
const $swal = inject('$swal');

// Image modal state
const showModal = ref(false);
const modalImage = ref('');
const currentSearchTerm = ref("");
/**
 * Fetch committee members with pagination and optional search
 * @param {number} page - Page number (default: 1)
 * @param {string} term - Search term (default: empty)
 */
const fetchPage = async (page = 1) => {
    try {
        const res = await axios.get(`/api/committee-members?page=${page}&search=${currentSearchTerm.value}`);
        members.value = res.data.data;
    } catch (error) {
        console.error('Failed to fetch members:', error);
        toast.error('Failed to load committee members.');
    }
};

/**
 * Handle search - reset to page 1 with the search term
 */
const onSearch = async (term) => {
    currentSearchTerm.value = term;
    fetchPage();
};

/**
 * Open full-size image modal
 */
const openImageModal = (imagePath) => {
    modalImage.value = getImageUrl(imagePath);
    showModal.value = true;
};

/**
 * Close image modal
 */
const closeImageModal = () => {
    showModal.value = false;
    modalImage.value = '';
};

// Load initial data on mount
onMounted(() => {
    fetchPage();

    // Show success toast from query param (e.g., after create/update)
    if (route.query.toast) {
        toast.success(route.query.toast);
        // Clean up toast query param after display
        setTimeout(() => {
            const q = { ...route.query };
            delete q.toast;
            router.replace({ query: q });
        }, 2000);
    }
});

/**
 * Toggle member status (active ↔ inactive)
 */
const updateStatus = async (member) => {
    try {
        const response = await axios.patch(`/api/committee-members/${member.id}/toggle-status`);
        member.status = response.data.data.status;

        // Use message from backend if available
        if (member.status == 1) {
            toast.success(response.data.message || 'Member activated');
        } else {
            toast.info(response.data.message || 'Member deactivated');
        }
    } catch (error) {
        toast.validationError(error);
        console.error('Status update failed:', error);
    }
};

/**
 * Confirm and delete a committee member
 */
const confirmDelete = async (member) => {
    const result = await $swal({
        title: `Delete "${member.name}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/committee-members/${member.id}`);
            toast.success('Committee member deleted successfully!');

            // Optimistic update: remove from local list
            members.value.data = members.value.data.filter(m => m.id !== member.id);
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
