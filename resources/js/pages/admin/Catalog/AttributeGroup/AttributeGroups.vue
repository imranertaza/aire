<template>
    <DashboardHeader title="Manage Attribute Groups">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" class="mr-2" />
            <button v-if="authStore.hasPermission('create-attribute-groups')" 
                class="btn btn-primary" data-toggle="modal" data-target="#attributeGroupModal" @click="openCreateModal">
                <i class="fas fa-plus"></i> Add Group
            </button>
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="groups?.data?.length === 0" class="alert alert-info">No attribute groups found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Sort Order</th>
                                    <th v-if="authStore.hasPermission('edit-attribute-groups')">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(group, index) in groups?.data" :key="group.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ group.name }}</td>
                                    <td class="align-middle">{{ group.sort_order }}</td>
                                    <td v-if="authStore.hasPermission('edit-attribute-groups')" class="align-middle">
                                        <select v-model="group.status" @change="updateStatus(group)"
                                            class="custom-select"
                                            :class="group.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <button v-if="authStore.hasPermission('edit-attribute-groups')"
                                                @click="openEditModal(group)"
                                                data-toggle="modal" data-target="#attributeGroupModal"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button v-if="authStore.hasPermission('delete-attribute-groups')"
                                                class="ml-2 btn btn-sm btn-outline-danger"
                                                @click="confirmDelete(group)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="groups" @page-change="fetchPage" />
                </div>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <div class="modal fade" id="attributeGroupModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="submitForm">
                        <div class="modal-header bg-purple">
                            <h5 class="modal-title">{{ isEditing ? 'Edit Attribute Group' : 'Create Attribute Group' }}</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click="closeModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Group Name <span class="text-danger">*</span></label>
                                <input v-model="form.name" type="text" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Sort Order</label>
                                <input min="0" v-model="form.sort_order" type="number" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select v-model="form.status" class="custom-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">Close</button>
                            <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
                                <i class="fas fa-spinner fa-spin mr-1" v-if="isSubmitting"></i>
                                {{ isEditing ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { inject, onMounted, ref, reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';

const router = useRouter();
const route = useRoute();
const groups = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
const perPage = ref(10);

// Modal state
const isEditing = ref(false);
const isSubmitting = ref(false);
const form = reactive({
    id: null,
    name: '',
    sort_order: 0,
    status: 1
});

const resetForm = () => {
    form.id = null;
    form.name = '';
    form.sort_order = 0;
    form.status = 1;
    isEditing.value = false;
};

const openCreateModal = () => {
    resetForm();
};

const openEditModal = (group) => {
    form.id = group.id;
    form.name = group.name;
    form.sort_order = group.sort_order;
    form.status = group.status;
    isEditing.value = true;
};

const closeModal = () => {
    // Close modal manually via vanilla JS to avoid jQuery issues
    const modal = document.getElementById('attributeGroupModal');
    if (modal) {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        modal.setAttribute('style', 'display: none');
    }
    document.body.classList.remove('modal-open');
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
    resetForm();
};

const submitForm = async () => {
    isSubmitting.value = true;
    try {
        if (isEditing.value) {
            await axios.put(`/api/product-attribute-groups/${form.id}`, form);
            toast.success('Attribute group updated successfully!');
        } else {
            await axios.post('/api/product-attribute-groups', form);
            toast.success('Attribute group created successfully!');
        }
        closeModal();
        fetchPage();
    } catch (error) {
        toast.validationError(error);
    } finally {
        isSubmitting.value = false;
    }
};

const fetchPage = async (page = 1, term = "") => {
    try {
        const res = await axios.get(`/api/product-attribute-groups?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        groups.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load attribute groups.');
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

const updateStatus = async (group) => {
    try {
        const response = await axios.patch(`/api/product-attribute-groups/${group.id}/toggle-status`);
        group.status = response.data.data.status;
        if (group.status == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

const confirmDelete = async (group) => {
    const result = await $swal({
        title: `Delete "${group.name}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/product-attribute-groups/${group.id}`);
            toast.success('Attribute group deleted successfully!');
            fetchPage();
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
