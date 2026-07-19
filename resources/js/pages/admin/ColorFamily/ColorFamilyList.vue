<template>
    <DashboardHeader title="Color Families">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" class="mr-2" />
            <button class="btn btn-primary" @click="showAddModal">
                <i class="fas fa-plus"></i> Add New
            </button>
        </div>
    </DashboardHeader>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div v-if="colorFamilies?.data?.length === 0" class="alert alert-info">No color families found.</div>

                <div v-else>
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Color Name</th>
                                    <th>Color Code</th>
                                    <th>Preview</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(color, index) in colorFamilies?.data" :key="color.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ color.color_name }}</td>
                                    <td class="align-middle">{{ color.code }}</td>
                                    <td class="align-middle">
                                        <div :style="{ backgroundColor: color.code, width: '30px', height: '30px', borderRadius: '4px', border: '1px solid #ddd' }"></div>
                                    </td>
                                    <td class="align-middle">{{ new Date(color.created_at).toLocaleDateString() }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <button @click="showEditModal(color)" class="btn btn-sm btn-outline-info" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button @click="deleteColor(color)" class="ml-2 btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                            <Pagination :pData="colorFamilies" @page-change="fetchPage" class="mt-3 px-3" />
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <button ref="modalToggleBtn" class="d-none" data-toggle="modal" data-target="#colorModal"></button>

    <!-- Modal -->
    <div class="modal fade" id="colorModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="saveColor">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ editMode ? 'Edit Color' : 'Add New Color' }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="color_name">Color Name <span class="text-danger">*</span></label>
                            <input type="text" v-model="form.color_name" class="form-control" id="color_name" placeholder="e.g. Red" required :class="{'is-invalid': errors.color_name}">
                            <div class="invalid-feedback" v-if="errors.color_name">{{ errors.color_name[0] }}</div>
                        </div>
                        <div class="form-group">
                            <label for="code">Color Code <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" v-model="form.code" class="form-control" id="code" placeholder="e.g. #FF0000" required :class="{'is-invalid': errors.code}">
                                <div class="input-group-append">
                                    <input type="color" v-model="form.code" class="form-control p-1" style="width: 40px; height: 38px;">
                                </div>
                                <div class="invalid-feedback" v-if="errors.code">{{ errors.code[0] }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" :disabled="saving">
                            <span v-if="saving" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
const modalToggleBtn = ref(null);

const colorFamilies = ref([]);
const currentSearchTerm = ref("");
const perPage = ref(10);

const saving = ref(false);
const editMode = ref(false);
const errors = ref({});

const form = ref({
    id: null,
    color_name: '',
    code: '#000000'
});

const fetchPage = async (page = 1) => {
    try {
        const res = await axios.get(`/api/color-families?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`);
        colorFamilies.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load color families');
    }
};

const onSearch = async (term) => {
    currentSearchTerm.value = term;
    fetchPage();
};

const onPerPageChange = () => {
    fetchPage(1);
};

const showAddModal = () => {
    editMode.value = false;
    form.value = { id: null, color_name: '', code: '#000000' };
    errors.value = {};
    modalToggleBtn.value.click();
};

const showEditModal = (color) => {
    editMode.value = true;
    form.value = { ...color };
    errors.value = {};
    modalToggleBtn.value.click();
};

const saveColor = async () => {
    saving.value = true;
    errors.value = {};
    
    try {
        if (editMode.value) {
            await axios.put(`/api/color-families/${form.value.id}`, form.value);
            toast.success('Color updated successfully');
        } else {
            await axios.post('/api/color-families', form.value);
            toast.success('Color added successfully');
        }
        document.querySelector('#colorModal .close').click();
        fetchPage();
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
            toast.error('Please check the form for errors');
        } else {
            toast.error('Failed to save color');
        }
    } finally {
        saving.value = false;
    }
};

const deleteColor = async (color) => {
    const result = await $swal({
        title: `Delete "${color.color_name}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/color-families/${color.id}`);
            toast.success('Color deleted successfully!');
            colorFamilies.value.data = colorFamilies.value.data.filter(c => c.id !== color.id);
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
