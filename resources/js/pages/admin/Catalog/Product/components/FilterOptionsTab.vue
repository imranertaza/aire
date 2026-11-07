<template>
    <div class="tab-pane fade" id="custom-tabs-filter-options" role="tabpanel"
        aria-labelledby="tab-filter-options">
        
        <!-- Two Distinct Dropdown Pickers: Catalog Filters & Guided Finder Steps -->
        <div class="row mb-3">
            <!-- 1. Storefront Catalog Filters -->
            <div class="col-md-6 mb-3">
                <div class="card card-outline card-primary h-100 shadow-none border">
                    <div class="card-header py-2 d-flex align-items-center justify-content-between bg-light">
                        <span class="font-weight-bold text-primary" style="font-size: 13px;">
                            <i class="fas fa-sliders-h mr-1"></i> Add Storefront Catalog Filter
                        </span>
                        <span class="badge badge-primary">{{ catalogFilterOptions.length }} Available</span>
                    </div>
                    <div class="card-body p-3">
                        <label class="small text-muted mb-1 d-block">Shown in storefront sidebar on /products-filter</label>
                        <select class="form-control" v-model="selectedCatalogOptionIdToAdd"
                            @change="addCatalogFilterOptionRow">
                            <option value="">-- Select Catalog Filter Option --</option>
                            <option v-for="opt in catalogFilterOptions" :key="opt.id" :value="opt.id">
                                {{ opt.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- 2. Guided Product Finder Steps -->
            <div class="col-md-6 mb-3">
                <div class="card card-outline card-info h-100 shadow-none border">
                    <div class="card-header py-2 d-flex align-items-center justify-content-between bg-light">
                        <span class="font-weight-bold text-info" style="font-size: 13px;">
                            <i class="fas fa-magic mr-1"></i> Add Guided Product Finder Option
                        </span>
                        <span class="badge badge-info">{{ guidedFilterOptions.length }} Available</span>
                    </div>
                    <div class="card-body p-3">
                        <label class="small text-muted mb-1 d-block">Shown in 10-step wizard journey on /product-finder</label>
                        <select class="form-control" v-model="selectedGuidedOptionIdToAdd"
                            @change="addGuidedFilterOptionRow">
                            <option value="">-- Select Guided Finder Step --</option>
                            <option v-for="opt in guidedFilterOptions" :key="opt.id" :value="opt.id">
                                Step {{ opt.guided_step_number || '•' }}: {{ opt.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter View Pills (All / Catalog Only / Guided Only) -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2" v-if="formData.filter_options && formData.filter_options.length > 0">
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn" :class="filterViewMode === 'all' ? 'btn-secondary active' : 'btn-outline-secondary'"
                    @click="filterViewMode = 'all'">
                    All Filter Options ({{ formData.filter_options.length }})
                </button>
                <button type="button" class="btn" :class="filterViewMode === 'catalog' ? 'btn-primary active' : 'btn-outline-primary'"
                    @click="filterViewMode = 'catalog'">
                    Catalog Filters ({{ catalogAddedCount }})
                </button>
                <button type="button" class="btn" :class="filterViewMode === 'guided' ? 'btn-info active' : 'btn-outline-info'"
                    @click="filterViewMode = 'guided'">
                    Guided Finder Steps ({{ guidedAddedCount }})
                </button>
            </div>
            <span class="text-muted small">Total Assigned: {{ formData.filter_options.length }}</span>
        </div>

        <!-- Filter Options Table -->
        <div class="table-responsive" v-if="formData.filter_options && formData.filter_options.length > 0">
            <table class="table table-bordered table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 35%;">Filter Option</th>
                        <th style="width: 50%;">Filter Option Value</th>
                        <th style="width: 15%;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="fOpt in filteredRows" :key="fOpt._originalIndex">
                        <td>
                            <div class="d-flex align-items-center">
                                <span v-if="isGuidedOption(fOpt)" class="badge badge-info text-uppercase mr-2 px-2 py-1">
                                    <i class="fas fa-magic mr-1"></i> Step {{ getStepNumber(fOpt) || '•' }}
                                </span>
                                <span v-else class="badge badge-primary text-uppercase mr-2 px-2 py-1">
                                    <i class="fas fa-filter mr-1"></i> Catalog
                                </span>
                                <span class="font-weight-bold">{{ fOpt.filter_option_name }}</span>
                            </div>
                        </td>
                        <td>
                            <select class="form-control" v-model="fOpt.filter_option_value_id" required>
                                <option value="">-- Select Value --</option>
                                <option v-for="val in fOpt.available_values" :key="val.id" :value="val.id">
                                    {{ val.name }}
                                </option>
                            </select>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger"
                                @click="removeFilterOptionRow(fOpt._originalIndex)"
                                title="Remove Filter Option">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="alert alert-info py-3 text-center">
            <i class="fas fa-info-circle mr-1"></i> No filter options added yet. Select from the dropdowns above to assign options to this product.
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: Object,
        default: null
    },
    form: {
        type: Object,
        default: null
    },
    availableFilterOptions: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['filterOptionAdded', 'filterOptionRemoved']);

const selectedCatalogOptionIdToAdd = ref("");
const selectedGuidedOptionIdToAdd = ref("");
const filterViewMode = ref("all");

const formData = computed(() => props.form || props.modelValue || {});

// 1. Catalog Filter Options (excluding guided finder)
const catalogFilterOptions = computed(() => {
    return (props.availableFilterOptions || [])
        .filter(o => !o.show_in_guided_finder || o.show_in_catalog == 1)
        .sort((a, b) => (a.sort_order ?? 0) - (b.sort_order ?? 0));
});

// 2. Guided Product Finder Steps (Steps 1 to 7)
const guidedFilterOptions = computed(() => {
    return (props.availableFilterOptions || [])
        .filter(o => o.show_in_guided_finder == 1 && (!o.guided_step_number || o.guided_step_number <= 7))
        .sort((a, b) => (a.guided_step_number || 99) - (b.guided_step_number || 99));
});

// Helper to look up an option in availableFilterOptions
const findOption = (fOptId) => {
    return (props.availableFilterOptions || []).find(o => Number(o.id) === Number(fOptId));
};

const isGuidedOption = (fOpt) => {
    const opt = findOption(fOpt.filter_option_id);
    return Boolean(opt && opt.show_in_guided_finder == 1);
};

const getStepNumber = (fOpt) => {
    const opt = findOption(fOpt.filter_option_id);
    return opt ? opt.guided_step_number : null;
};

// Add Catalog Filter
const addCatalogFilterOptionRow = () => {
    if (!selectedCatalogOptionIdToAdd.value) return;
    addOptionById(selectedCatalogOptionIdToAdd.value);
    selectedCatalogOptionIdToAdd.value = "";
};

// Add Guided Filter
const addGuidedFilterOptionRow = () => {
    if (!selectedGuidedOptionIdToAdd.value) return;
    addOptionById(selectedGuidedOptionIdToAdd.value);
    selectedGuidedOptionIdToAdd.value = "";
};

const addOptionById = (val) => {
    if (!formData.value.filter_options) {
        formData.value.filter_options = [];
    }

    const opt = (typeof val === 'object' && val !== null)
        ? val
        : (props.availableFilterOptions || []).find(o => Number(o.id) === Number(val));

    if (!opt) return;

    formData.value.filter_options.push({
        filter_option_id: Number(opt.id),
        filter_option_name: opt.name,
        filter_option_value_id: '',
        available_values: opt.option_values || opt.optionValues || []
    });

    emit('filterOptionAdded', opt);
};

const removeFilterOptionRow = (index) => {
    if (formData.value.filter_options && formData.value.filter_options[index] !== undefined) {
        formData.value.filter_options.splice(index, 1);
        emit('filterOptionRemoved', index);
    }
};

// Counters
const catalogAddedCount = computed(() => {
    return (formData.value.filter_options || []).filter(f => !isGuidedOption(f)).length;
});

const guidedAddedCount = computed(() => {
    return (formData.value.filter_options || []).filter(f => isGuidedOption(f)).length;
});

// Filtered rows for display
const filteredRows = computed(() => {
    const all = (formData.value.filter_options || []).map((f, i) => ({ ...f, _originalIndex: i }));
    if (filterViewMode.value === 'catalog') {
        return all.filter(f => !isGuidedOption(f));
    }
    if (filterViewMode.value === 'guided') {
        return all.filter(f => isGuidedOption(f));
    }
    return all;
});
</script>
