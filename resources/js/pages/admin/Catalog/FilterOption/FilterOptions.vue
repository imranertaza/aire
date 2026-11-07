<template>
    <DashboardHeader title="Manage Filter & Guided Finder Options">
        <div class="d-flex justify-content-end align-items-center flex-wrap">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2 mb-2 mb-md-0" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <SearchBox @search="onSearch" class="mr-2 mb-2 mb-md-0" />
            <button v-if="authStore.hasPermission('create-options')" 
                class="btn btn-primary mb-2 mb-md-0" data-toggle="modal" data-target="#filterOptionModal" @click="openCreateModal">
                <i class="fas fa-plus"></i> Add Filter Option
            </button>
        </div>
    </DashboardHeader>

    <section>
        <!-- Filter Tabs / Mode Switcher -->
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-body py-2 px-3">
                <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item mr-1">
                        <a class="nav-link font-weight-bold" :class="{ 'active bg-primary text-white': activeView === 'all' }" href="#" @click.prevent="setView('all')">
                            <i class="fas fa-list mr-1"></i> All Filter Options
                        </a>
                    </li>
                    <li class="nav-item mr-1">
                        <a class="nav-link font-weight-bold" :class="{ 'active bg-info text-white': activeView === 'catalog' }" href="#" @click.prevent="setView('catalog')">
                            <i class="fas fa-filter mr-1"></i> Catalog Sidebar Filters
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" :class="{ 'active bg-success text-white': activeView === 'guided_finder' }" href="#" @click.prevent="setView('guided_finder')">
                            <i class="fas fa-magic mr-1"></i> Guided Product Finder Steps
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Guided Finder Info Banner when guided_finder tab is selected -->
        <div v-if="activeView === 'guided_finder'" class="alert alert-light border border-success mb-3 d-flex align-items-center">
            <div class="mr-3 text-success" style="font-size: 2rem;">
                <i class="fas fa-route"></i>
            </div>
            <div>
                <strong class="text-success">Guided Product Finder Wizard (10-Step Interactive Journey)</strong>
                <p class="mb-0 text-muted small">
                    Filter options configured here serve as the step-by-step interactive questions for the customer storefront wizard (e.g., Environment, System Type, Space Size, Airflow, Air Quality, Installation, Budget). 
                    Each option value includes an explanation for the dynamic "Answer So Far" card.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div v-if="filterOptions?.data?.length === 0" class="alert alert-info">No filter options found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover bg-white shadow-sm">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Option Name</th>
                                    <th class="text-center" style="width: 60px;">Icon</th>
                                    <th style="width: 90px;">Type</th>
                                    <th class="text-center" style="width: 130px;">Catalog Sidebar</th>
                                    <th class="text-center" style="width: 160px;">Guided Finder</th>
                                    <th class="text-center" style="width: 90px;">Sort Order</th>
                                    <th v-if="authStore.hasPermission('edit-options')" style="width: 110px;">Status</th>
                                    <th style="width: 100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(option, index) in filterOptions?.data" :key="option.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">
                                        <div class="font-weight-bold">{{ option.name }}</div>
                                        <div v-if="option.show_in_guided_finder && option.guided_question" class="small text-muted mt-1">
                                            <i class="fas fa-question-circle text-success mr-1"></i>{{ option.guided_question }}
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <i v-if="option.icon" :class="['bi', option.icon, 'text-primary']" style="font-size: 1.2rem;" :title="option.icon"></i>
                                        <span v-else class="text-muted small">—</span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-light border text-uppercase">{{ option.type }}</span>
                                    </td>
                                    <!-- Catalog Sidebar Toggle -->
                                    <td class="align-middle text-center">
                                        <button v-if="authStore.hasPermission('edit-options')"
                                            type="button"
                                            class="btn btn-xs font-weight-bold px-2 py-1"
                                            :class="option.show_in_catalog == 1 ? 'btn-success' : 'btn-outline-secondary'"
                                            @click="updateShowInCatalog(option)"
                                            title="Click to toggle in Catalog Sidebar">
                                            <i :class="option.show_in_catalog == 1 ? 'fas fa-check-circle' : 'far fa-circle'"></i>
                                            {{ option.show_in_catalog == 1 ? ' Enabled' : ' Disabled' }}
                                        </button>
                                        <span v-else class="badge" :class="option.show_in_catalog == 1 ? 'badge-success' : 'badge-secondary'">
                                            {{ option.show_in_catalog == 1 ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <!-- Guided Finder Toggle & Step -->
                                    <td class="align-middle text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <button v-if="authStore.hasPermission('edit-options')"
                                                type="button"
                                                class="btn btn-xs font-weight-bold px-2 py-1 mr-1"
                                                :class="option.show_in_guided_finder == 1 ? 'btn-info text-white' : 'btn-outline-secondary'"
                                                @click="updateShowInGuidedFinder(option)"
                                                title="Click to toggle in Guided Finder">
                                                <i :class="option.show_in_guided_finder == 1 ? 'fas fa-compass' : 'far fa-circle'"></i>
                                                {{ option.show_in_guided_finder == 1 ? ' Step' : ' Disabled' }}
                                            </button>
                                            <span v-if="option.show_in_guided_finder == 1" class="badge badge-primary">
                                                #{{ option.guided_step_number || '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">{{ option.sort_order }}</td>
                                    <td v-if="authStore.hasPermission('edit-options')" class="align-middle">
                                        <select v-model="option.status" @change="updateStatus(option)"
                                            class="custom-select custom-select-sm"
                                            :class="option.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <button v-if="authStore.hasPermission('edit-options')"
                                                @click="openEditModal(option)"
                                                data-toggle="modal" data-target="#filterOptionModal"
                                                class="btn btn-sm btn-outline-info"
                                                title="Edit Option & Values">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button v-if="authStore.hasPermission('delete-options')"
                                                class="ml-2 btn btn-sm btn-outline-danger"
                                                @click="confirmDelete(option)"
                                                title="Delete Option">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="filterOptions" @page-change="fetchPage" />
                </div>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <div class="modal fade" id="filterOptionModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form @submit.prevent="submitForm">
                        <div class="modal-header bg-purple text-white">
                            <h5 class="modal-title font-weight-bold">
                                <i class="fas fa-sliders-h mr-2"></i>
                                {{ isEditing ? 'Edit Filter Option' : 'Create Filter Option' }}
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" @click="closeModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Basic Config Card -->
                            <div class="card card-outline card-secondary mb-3">
                                <div class="card-header py-2 font-weight-bold">
                                    <i class="fas fa-cog mr-1"></i> Basic Option Settings
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>Filter Option Name <span class="text-danger">*</span></label>
                                            <input v-model="form.name" type="text" class="form-control" placeholder="e.g. Application / Environment" required />
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Input Type <span class="text-danger">*</span></label>
                                            <select v-model="form.type" class="custom-select" required>
                                                <option value="radio">Radio (Single Choice)</option>
                                                <option value="checkbox">Checkbox (Multi Choice)</option>
                                                <option value="select">Dropdown Select</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Sort Order</label>
                                            <input min="0" v-model="form.sort_order" type="number" class="form-control" />
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Icon (CSS Class)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i :class="['bi', form.icon || 'bi-list']"></i></span>
                                                </div>
                                                <input v-model="form.icon" type="text" class="form-control" placeholder="e.g. bi-building" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Show in Catalog Sidebar <span class="text-danger">*</span></label>
                                            <select v-model="form.show_in_catalog" class="custom-select" required>
                                                <option :value="1">Yes (Visible in Filter Sidebar)</option>
                                                <option :value="0">No (Hidden from Filter Sidebar)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select v-model="form.status" class="custom-select" required>
                                                <option :value="1">Active</option>
                                                <option :value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Guided Product Finder Card -->
                            <div class="card border-info mb-3">
                                <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold text-info">
                                        <i class="fas fa-magic mr-1"></i> Guided Product Finder Wizard Configuration
                                    </span>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="guidedFinderSwitch" v-model="form.show_in_guided_finder" :true-value="1" :false-value="0">
                                        <label class="custom-control-label font-weight-bold" for="guidedFinderSwitch">
                                            {{ form.show_in_guided_finder == 1 ? 'Enabled for Guided Finder' : 'Disabled for Guided Finder' }}
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body" v-if="form.show_in_guided_finder == 1">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>Finder Step Number <span class="text-danger">*</span></label>
                                            <input v-model="form.guided_step_number" type="number" min="1" max="20" class="form-control" placeholder="e.g. 1" required />
                                            <small class="text-muted">Order of appearance in the 10-step wizard</small>
                                        </div>
                                        <div class="col-md-9 form-group">
                                            <label>Step Question Title <span class="text-danger">*</span></label>
                                            <input v-model="form.guided_question" type="text" class="form-control" placeholder="e.g. 01 WHERE WILL YOU USE IT?" required />
                                            <small class="text-muted">Prominent heading shown to customers</small>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Question Subtitle / Guidance</label>
                                            <input v-model="form.guided_subtitle" type="text" class="form-control" placeholder="e.g. Select your primary installation environment" />
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Allow "I don't know" Option</label>
                                            <select v-model="form.has_unknown_option" class="custom-select">
                                                <option :value="1">Yes (Allow Skip/Unsure)</option>
                                                <option :value="0">No (Must pick an option)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group" v-if="form.has_unknown_option == 1">
                                            <label>Unknown Option Label</label>
                                            <input v-model="form.unknown_option_label" type="text" class="form-control" placeholder="I don't know / Not sure" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Option Values Section -->
                            <div class="card card-outline card-primary">
                                <div class="card-header py-2 d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 font-weight-bold">
                                        <i class="fas fa-list-ul mr-1"></i> Filter Option Values & Wizard Explanations
                                    </h6>
                                    <button type="button" class="btn btn-sm btn-primary" @click="addOptionValue">
                                        <i class="fas fa-plus"></i> Add Value
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 25%;">Value Name <span class="text-danger">*</span></th>
                                                    <th style="width: 20%;">Icon (CSS Class)</th>
                                                    <th style="width: 40%;">
                                                        Explanation / Reason 
                                                        <small class="text-muted d-block">(Shown in "Answer So Far" card on finder)</small>
                                                    </th>
                                                    <th style="width: 90px;" class="text-center">Sort Order</th>
                                                    <th style="width: 60px;" class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(val, index) in form.option_values" :key="index">
                                                    <td>
                                                        <input v-model="val.name" type="text" class="form-control form-control-sm" placeholder="e.g. Residential / Home" required />
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i :class="['bi', val.icon || 'bi-check-circle']"></i></span>
                                                            </div>
                                                            <input v-model="val.icon" type="text" class="form-control form-control-sm" placeholder="e.g. bi-house-door" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <textarea v-model="val.explanation" rows="2" class="form-control form-control-sm" placeholder="e.g. Selected: Residential. Routes user to home-friendly low noise solutions."></textarea>
                                                    </td>
                                                    <td>
                                                        <input min="0" v-model="val.sort_order" type="number" class="form-control form-control-sm text-center" />
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button type="button" class="btn btn-sm btn-outline-danger" @click="removeOptionValue(index)" title="Remove value">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr v-if="form.option_values.length === 0">
                                                    <td colspan="5" class="text-center text-muted py-3">No values added yet. Click "+ Add Value" to add one.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">Close</button>
                            <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
                                <i class="fas fa-spinner fa-spin mr-1" v-if="isSubmitting"></i>
                                {{ isEditing ? 'Update Option' : 'Create Option' }}
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
const filterOptions = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref("");
const perPage = ref(10);
const activeView = ref('all'); // 'all', 'catalog', 'guided_finder'

// Modal state
const isEditing = ref(false);
const isSubmitting = ref(false);
const form = reactive({
    id: null,
    name: '',
    icon: '',
    type: 'radio',
    sort_order: 0,
    show_in_filter: 1,
    show_in_catalog: 1,
    show_in_guided_finder: 0,
    guided_step_number: null,
    guided_question: '',
    guided_subtitle: '',
    has_unknown_option: 1,
    unknown_option_label: "I don't know",
    status: 1,
    option_values: []
});

const setView = (view) => {
    activeView.value = view;
    fetchPage(1);
};

const resetForm = () => {
    form.id = null;
    form.name = '';
    form.icon = '';
    form.type = 'radio';
    form.sort_order = 0;
    form.show_in_filter = 1;
    form.show_in_catalog = 1;
    form.show_in_guided_finder = 0;
    form.guided_step_number = null;
    form.guided_question = '';
    form.guided_subtitle = '';
    form.has_unknown_option = 1;
    form.unknown_option_label = "I don't know";
    form.status = 1;
    form.option_values = [];
    isEditing.value = false;
};

const addOptionValue = () => {
    form.option_values.push({
        id: null,
        name: '',
        icon: '',
        explanation: '',
        sort_order: form.option_values.length
    });
};

const removeOptionValue = (index) => {
    form.option_values.splice(index, 1);
};

const openCreateModal = () => {
    resetForm();
    if (activeView.value === 'guided_finder') {
        form.show_in_guided_finder = 1;
    }
};

const openEditModal = (option) => {
    form.id = option.id;
    form.name = option.name;
    form.icon = option.icon || '';
    form.type = option.type;
    form.sort_order = option.sort_order;
    form.show_in_filter = option.show_in_filter ?? 1;
    form.show_in_catalog = option.show_in_catalog ?? option.show_in_filter ?? 1;
    form.show_in_guided_finder = option.show_in_guided_finder ? 1 : 0;
    form.guided_step_number = option.guided_step_number ?? null;
    form.guided_question = option.guided_question || '';
    form.guided_subtitle = option.guided_subtitle || '';
    form.has_unknown_option = option.has_unknown_option !== undefined ? (option.has_unknown_option ? 1 : 0) : 1;
    form.unknown_option_label = option.unknown_option_label || "I don't know";
    form.status = option.status;
    form.option_values = option.option_values ? JSON.parse(JSON.stringify(option.option_values)) : [];
    isEditing.value = true;
};

const closeModal = () => {
    const modal = document.getElementById('filterOptionModal');
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
            await axios.put(`/api/filter-options/${form.id}`, form);
            toast.success('Filter Option updated successfully!');
        } else {
            await axios.post('/api/filter-options', form);
            toast.success('Filter Option created successfully!');
        }
        closeModal();
        fetchPage();
    } catch (error) {
        toast.validationError(error);
    } finally {
        isSubmitting.value = false;
    }
};

const fetchPage = async (page = 1) => {
    try {
        let url = `/api/filter-options?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}`;
        if (activeView.value !== 'all') {
            url += `&view=${activeView.value}`;
        }
        const res = await axios.get(url);
        filterOptions.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load filter options.');
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
        const response = await axios.patch(`/api/filter-options/${option.id}/toggle-status`);
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

const updateShowInCatalog = async (option) => {
    try {
        const response = await axios.patch(`/api/filter-options/${option.id}/toggle-show-in-catalog`);
        option.show_in_catalog = response.data.data.show_in_catalog;
        option.show_in_filter = response.data.data.show_in_filter;
        if (option.show_in_catalog == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update catalog filter toggle');
        console.error(error);
    }
};

const updateShowInGuidedFinder = async (option) => {
    try {
        const response = await axios.patch(`/api/filter-options/${option.id}/toggle-show-in-guided-finder`);
        option.show_in_guided_finder = response.data.data.show_in_guided_finder;
        if (option.show_in_guided_finder == 1) {
            toast.success(response.data.message);
        } else {
            toast.info(response.data.message);
        }
    } catch (error) {
        toast.error('Failed to update guided finder toggle');
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
            await axios.delete(`/api/filter-options/${option.id}`);
            toast.success('Filter Option deleted successfully!');
            fetchPage();
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
