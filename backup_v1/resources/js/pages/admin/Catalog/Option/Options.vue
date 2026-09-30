<template>
    <DashboardHeader title="Manage Options">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" class="mr-2" />
            <button v-if="authStore.hasPermission('create-options')" 
                class="btn btn-primary" data-toggle="modal" data-target="#optionModal" @click="openCreateModal">
                <i class="fas fa-plus"></i> Add Option
            </button>
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="options?.data?.length === 0" class="alert alert-info">No options found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Sort Order</th>
                                    <th v-if="authStore.hasPermission('edit-options')">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(option, index) in options?.data" :key="option.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ option.name }}</td>
                                    <td class="align-middle">{{ option.type }}</td>
                                    <td class="align-middle">{{ option.sort_order }}</td>
                                    <td v-if="authStore.hasPermission('edit-options')" class="align-middle">
                                        <select v-model="option.status" @change="updateStatus(option)"
                                            class="custom-select"
                                            :class="option.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <button v-if="authStore.hasPermission('edit-options')"
                                                @click="openEditModal(option)"
                                                data-toggle="modal" data-target="#optionModal"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button v-if="authStore.hasPermission('delete-options')"
                                                class="ml-2 btn btn-sm btn-outline-danger"
                                                @click="confirmDelete(option)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="options" @page-change="fetchPage" />
                </div>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <div class="modal fade" id="optionModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form @submit.prevent="submitForm">
                        <div class="modal-header bg-purple">
                            <h5 class="modal-title">{{ isEditing ? 'Edit Option' : 'Create Option' }}</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click="closeModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Option Name <span class="text-danger">*</span></label>
                                    <input v-model="form.name" type="text" class="form-control" required />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Type <span class="text-danger">*</span></label>
                                    <select v-model="form.type" class="custom-select" required>
                                        <option value="select">Select</option>
                                        <option value="radio">Radio</option>
                                        <option value="checkbox">Checkbox</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Sort Order</label>
                                    <input min="0" v-model="form.sort_order" type="number" class="form-control" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select v-model="form.status" class="custom-select" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                            <hr />
                            
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5>Option Values</h5>
                                <button type="button" class="btn btn-sm btn-primary" @click="addOptionValue">
                                    <i class="fas fa-plus"></i> Add Value
                                </button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Value Name <span class="text-danger">*</span></th>
                                            <th style="width: 150px">Sort Order</th>
                                            <th style="width: 80px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(val, index) in form.option_values" :key="index">
                                            <td>
                                                <input v-model="val.name" type="text" class="form-control form-control-sm" required />
                                            </td>
                                            <td>
                                                <input min="0" v-model="val.sort_order" type="number" class="form-control form-control-sm" />
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-danger" @click="removeOptionValue(index)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr v-if="form.option_values.length === 0">
                                            <td colspan="3" class="text-center text-muted">No option values added yet.</td>
                                        </tr>
                                    </tbody>
                                </table>
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
const options = ref([]);
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
    type: 'select',
    sort_order: 0,
    status: 1,
    option_values: []
});

const resetForm = () => {
    form.id = null;
    form.name = '';
    form.type = 'select';
    form.sort_order = 0;
    form.status = 1;
    form.option_values = [];
    isEditing.value = false;
};

const addOptionValue = () => {
    form.option_values.push({
        id: null,
        name: '',
        sort_order: form.option_values.length
    });
};

const removeOptionValue = (index) => {
    form.option_values.splice(index, 1);
};

const openCreateModal = () => {
    resetForm();
};

const openEditModal = (option) => {
    form.id = option.id;
    form.name = option.name;
    form.type = option.type;
    form.sort_order = option.sort_order;
    form.status = option.status;
    form.option_values = option.option_values ? JSON.parse(JSON.stringify(option.option_values)) : [];
    isEditing.value = true;
};

const closeModal = () => {
    // Close modal manually via vanilla JS to avoid jQuery issues
    const modal = document.getElementById('optionModal');
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
            await axios.put(`/api/options/${form.id}`, form);
            toast.success('Option updated successfully!');
        } else {
            await axios.post('/api/options', form);
            toast.success('Option created successfully!');
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
        const res = await axios.get(`/api/options?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        options.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load options.');
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

const updateStatus = async (option) => {
    try {
        const response = await axios.patch(`/api/options/${option.id}/toggle-status`);
        option.status = response.data.data.status;
        if (option.status == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

const confirmDelete = async (option) => {
    const result = await $swal({
        title: `Delete "${option.name}"?`,
        text: 'This action cannot be undone and will delete all associated values.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/options/${option.id}`);
            toast.success('Option deleted successfully!');
            fetchPage();
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
