<template>
    <DashboardHeader title="Advanced Products Editor">
        <div class="d-flex align-items-center flex-wrap gap-2">
            <button @click="openBulkStatusModal" class="btn btn-sm btn-warning" :disabled="selectedProductIds.length === 0">
                <i class="fas fa-toggle-on mr-1"></i> Bulk Status
            </button>
            <button @click="openBulkCategoriesModal" class="btn btn-sm btn-info" :disabled="selectedProductIds.length === 0">
                <i class="fas fa-tags mr-1"></i> Bulk Categories
            </button>
            <button @click="openBulkOptionsModal" class="btn btn-sm btn-success" :disabled="selectedProductIds.length === 0">
                <i class="fas fa-cog mr-1"></i> Bulk Options
            </button>
            <button @click="openBulkAttributesModal" class="btn btn-sm btn-primary" :disabled="selectedProductIds.length === 0">
                <i class="fas fa-list-alt mr-1"></i> Bulk Attributes
            </button>
            <router-link :to="{ name: 'Products' }" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </router-link>
        </div>
    </DashboardHeader>

    <section class="content">
        <div class="card shadow-sm border-0">
            <!-- Card Header / Search -->
            <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between flex-wrap" style="gap:10px;">
                <div style="min-width:260px; max-width:380px; flex:1;">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light border-right-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control border-left-0" placeholder="Search by name or model..." v-model="searchQuery" @input="debouncedSearch" />
                    </div>
                </div>
                <div class="d-flex align-items-center" style="gap:10px;">
                    <span class="small text-muted"><i class="fas fa-info-circle mr-1"></i>Click any cell to edit</span>
                    <span v-if="selectedProductIds.length > 0" class="badge badge-pill badge-primary px-3 py-2" style="font-size:13px;">
                        <i class="fas fa-check-square mr-1"></i>{{ selectedProductIds.length }} selected
                    </span>
                </div>
            </div>

            <!-- Table -->
            <div class="card-body p-0" style="overflow-x: auto;">
                <table class="table table-hover table-sm mb-0 advanced-table">
                    <thead>
                        <tr>
                            <th class="text-center" >
                                <input type="checkbox" @change="toggleSelectAll" :checked="isAllSelected" />
                            </th>
                            <th >#</th>
                            <th >Img</th>
                            <th >Name</th>
                            <th >Model</th>
                            <th >Price</th>
                            <th >Qty</th>
                            <th >Status</th>
                            <th >Featured</th>
                            <th class="text-center" >Categories</th>
                            <th class="text-center" >Options</th>
                            <th class="text-center" >Attrs</th>
                            <th class="text-center" >SEO</th>
                            <th class="text-center action-col" >Save</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" :key="product.id" :class="{ 'row-editing': isRowEditing(product.id) }">
                            <td class="text-center align-middle">
                                <input type="checkbox" :value="product.id" v-model="selectedProductIds" />
                            </td>
                            <td class="align-middle text-muted small">{{ product.id }}</td>
                            <td class="align-middle">
                                <img :src="product.main_image ? getImageCacheUrl(product.main_image, 80, 80, 'webp') : '/images/no-image.jpg'"
                                     class="product-thumb" />
                            </td>

                            <!-- Name — click to edit -->
                            <td class="align-middle editable-cell" @click="startEdit(product.id, 'name')">
                                <template v-if="isEditing(product.id, 'name')">
                                    <input
                                        type="text"
                                        class="form-control form-control-sm cell-input"
                                        v-model="product.name"
                                        @blur="stopEdit"
                                        @keyup.enter="stopEdit"
                                        @keyup.escape="stopEdit"
                                        v-focus
                                    />
                                </template>
                                <template v-else>
                                    <span class="cell-value">{{ product.name || '—' }}</span>
                                    <i class="fas fa-pencil-alt cell-edit-icon"></i>
                                </template>
                            </td>

                            <!-- Model — click to edit -->
                            <td class="align-middle editable-cell" @click="startEdit(product.id, 'model')">
                                <template v-if="isEditing(product.id, 'model')">
                                    <input
                                        type="text"
                                        class="form-control form-control-sm cell-input"
                                        v-model="product.model"
                                        @blur="stopEdit"
                                        @keyup.enter="stopEdit"
                                        @keyup.escape="stopEdit"
                                        v-focus
                                    />
                                </template>
                                <template v-else>
                                    <span class="cell-value code-value">{{ product.model || '—' }}</span>
                                    <i class="fas fa-pencil-alt cell-edit-icon"></i>
                                </template>
                            </td>

                            <!-- Price — click to edit -->
                            <td class="align-middle editable-cell" @click="startEdit(product.id, 'price')">
                                <template v-if="isEditing(product.id, 'price')">
                                    <input min="0" type="number"
                                        step="0.01"
                                        class="form-control form-control-sm cell-input text-right"
                                        v-model="product.price"
                                        @blur="stopEdit"
                                        @keyup.enter="stopEdit"
                                        @keyup.escape="stopEdit"
                                        v-focus
                                    />
                                </template>
                                <template v-else>
                                    <span class="cell-value">{{ formatPrice(product.price) }}</span>
                                    <i class="fas fa-pencil-alt cell-edit-icon"></i>
                                </template>
                            </td>

                            <!-- Quantity — click to edit -->
                            <td class="align-middle editable-cell text-center" @click="startEdit(product.id, 'quantity')">
                                <template v-if="isEditing(product.id, 'quantity')">
                                    <input min="0" type="number"
                                        class="form-control form-control-sm cell-input text-center"
                                        v-model="product.quantity"
                                        @blur="stopEdit"
                                        @keyup.enter="stopEdit"
                                        @keyup.escape="stopEdit"
                                        v-focus
                                    />
                                </template>
                                <template v-else>
                                    <span class="cell-value">{{ product.quantity }}</span>
                                    <i class="fas fa-pencil-alt cell-edit-icon"></i>
                                </template>
                            </td>

                            <!-- Status — inline select (always visible, auto-saves) -->
                            <td class="align-middle">
                                <select class="form-control form-control-sm" v-model="product.status"
                                    @change="updateSingleField(product.id, 'status', product.status)">
                                    <option :value="1">Active</option>
                                    <option :value="0">Inactive</option>
                                </select>
                            </td>

                            <!-- Featured — inline select (always visible, auto-saves) -->
                            <td class="align-middle">
                                <select class="form-control form-control-sm" v-model="product.featured"
                                    @change="updateSingleField(product.id, 'featured', product.featured)">
                                    <option :value="1">Yes</option>
                                    <option :value="0">No</option>
                                </select>
                            </td>

                            <!-- Categories -->
                            <td class="align-middle text-center">
                                <button class="btn btn-xs btn-outline-info" @click="openCategoriesModal(product)">
                                    <i class="fas fa-pencil-alt mr-1"></i>{{ product.categories?.length || 0 }}
                                </button>
                            </td>

                            <!-- Options -->
                            <td class="align-middle text-center">
                                <button class="btn btn-xs btn-outline-success" @click="openOptionsModal(product)">
                                    <i class="fas fa-cog mr-1"></i>{{ product.product_options?.length || 0 }}
                                </button>
                            </td>

                            <!-- Attributes -->
                            <td class="align-middle text-center">
                                <button class="btn btn-xs btn-outline-primary text-nowrap" @click="openAttributesModal(product)">
                                    <i class="fas fa-list mr-1"></i>{{ product.product_attributes?.length || 0 }}
                                </button>
                            </td>

                            <!-- SEO -->
                            <td class="align-middle text-center">
                                <button class="btn btn-xs btn-outline-secondary" @click="openSeoModal(product)" title="Edit SEO">
                                    <i class="fas fa-search"></i>
                                </button>
                            </td>

                            <!-- Save -->
                            <td class="align-middle text-center action-col">
                                <button class="btn btn-xs btn-primary" @click="saveProductRow(product)" title="Save row">
                                    <i class="fas fa-save"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="products.length === 0">
                            <td colspan="14" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-2x mb-2 d-block"></i>No products found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer bg-white border-top clearfix">
                <Pagination :pData="pagination" @page-change="loadProducts" />
            </div>
        </div>
    </section>

    <!-- ==================== MODALS ==================== -->

    <!-- Bulk / Single Categories Modal -->
    <div class="ap-modal-backdrop" v-if="showCategoriesModal" @click.self="showCategoriesModal = false">
        <div class="ap-modal">
            <div class="ap-modal-header">
                <h6><i class="fas fa-tags text-info mr-2"></i>{{ isBulkAction ? 'Bulk Edit Categories' : 'Edit Categories' }}</h6>
                <button class="ap-close" @click="showCategoriesModal = false">&times;</button>
            </div>
            <div class="ap-modal-body">
                <p class="text-muted small mb-2">
                    Select one or more categories. Hierarchy is shown as <strong>Parent &gt; Child</strong>.
                </p>
                <Multiselect
                    v-model="bulkForm.category_ids"
                    :options="categoriesOptions"
                    mode="tags"
                    placeholder="Search and select categories..."
                    searchable
                    class="multiselect-custom"
                />
            </div>
            <div class="ap-modal-footer">
                <button class="btn btn-sm btn-secondary" @click="showCategoriesModal = false">Cancel</button>
                <button class="btn btn-sm btn-info" @click="submitBulkCategories" :disabled="bulkForm.category_ids.length === 0">
                    <i class="fas fa-check mr-1"></i>Apply Categories
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Status Modal -->
    <div class="ap-modal-backdrop" v-if="showStatusModal" @click.self="showStatusModal = false">
        <div class="ap-modal" style="max-width:420px;">
            <div class="ap-modal-header">
                <h6><i class="fas fa-toggle-on text-warning mr-2"></i>Bulk Update Status / Featured</h6>
                <button class="ap-close" @click="showStatusModal = false">&times;</button>
            </div>
            <div class="ap-modal-body">
                <div class="form-group mb-3">
                    <label class="form-label small font-weight-bold">Update Field</label>
                    <select class="form-control form-control-sm" v-model="bulkForm.statusField">
                        <option value="status">Status (Active/Inactive)</option>
                        <option value="featured">Featured (Yes/No)</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label small font-weight-bold">Set Value</label>
                    <select class="form-control form-control-sm" v-model="bulkForm.statusValue">
                        <option :value="1">Active / Yes</option>
                        <option :value="0">Inactive / No</option>
                    </select>
                </div>
            </div>
            <div class="ap-modal-footer">
                <button class="btn btn-sm btn-secondary" @click="showStatusModal = false">Cancel</button>
                <button class="btn btn-sm btn-warning" @click="submitBulkStatus">
                    <i class="fas fa-check mr-1"></i>Apply Status
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Options Modal -->
    <div class="ap-modal-backdrop" v-if="showOptionsModal" @click.self="showOptionsModal = false">
        <div class="ap-modal ap-modal-lg">
            <div class="ap-modal-header">
                <h6><i class="fas fa-cog text-success mr-2"></i>{{ isBulkAction ? 'Bulk Edit Options' : 'Edit Options' }}</h6>
                <button class="ap-close" @click="showOptionsModal = false">&times;</button>
            </div>
            <div class="ap-modal-body">
                <div class="form-group mb-3">
                    <label class="form-label small font-weight-bold">Add Option</label>
                    <select class="form-control form-control-sm" v-model="selectedOptionToAdd" @change="addOptionRow">
                        <option value="">-- Select Option to Add --</option>
                        <option v-for="opt in availableOptions" :key="opt.id" :value="opt">{{ opt.name }}</option>
                    </select>
                </div>
                <div class="table-responsive" v-if="bulkForm.options.length > 0">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Option</th>
                                <th>Value</th>
                                <th>Qty</th>
                                <th>Subtract</th>
                                <th>Prefix</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(prodOpt, index) in bulkForm.options" :key="index">
                                <td class="align-middle small">{{ prodOpt.option_name }}</td>
                                <td>
                                    <select class="form-control form-control-sm" v-model="prodOpt.option_value_id">
                                        <option value="">-- Select --</option>
                                        <option v-for="val in prodOpt.available_values" :key="val.id" :value="val.id">{{ val.name }}</option>
                                    </select>
                                </td>
                                <td><input min="0" type="number" class="form-control form-control-sm" v-model="prodOpt.quantity" style="width:70px;" /></td>
                                <td>
                                    <select class="form-control form-control-sm" v-model="prodOpt.subtract" style="width:70px;">
                                        <option :value="1">Yes</option>
                                        <option :value="0">No</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control form-control-sm" v-model="prodOpt.price_prefix" style="width:60px;">
                                        <option value="+">+</option>
                                        <option value="-">-</option>
                                    </select>
                                </td>
                                <td><input min="0" type="number" step="0.01" class="form-control form-control-sm" v-model="prodOpt.price" style="width:80px;" /></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-xs btn-danger" @click="removeOptionRow(index)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="alert alert-light border text-muted small mb-0">
                    <i class="fas fa-info-circle mr-1"></i>No options added yet. Select an option above.
                </div>
            </div>
            <div class="ap-modal-footer">
                <button class="btn btn-sm btn-secondary" @click="showOptionsModal = false">Cancel</button>
                <button class="btn btn-sm btn-success" @click="submitBulkOptions" :disabled="bulkForm.options.length === 0">
                    <i class="fas fa-check mr-1"></i>Apply Options
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Attributes Modal -->
    <div class="ap-modal-backdrop" v-if="showAttributesModal" @click.self="showAttributesModal = false">
        <div class="ap-modal ap-modal-lg">
            <div class="ap-modal-header">
                <h6><i class="fas fa-list-alt text-primary mr-2"></i>{{ isBulkAction ? 'Bulk Edit Attributes' : 'Edit Attributes' }}</h6>
                <button class="ap-close" @click="showAttributesModal = false">&times;</button>
            </div>
            <div class="ap-modal-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Attribute Group</th>
                                <th>Name</th>
                                <th>Details</th>
                                <th style="width:80px;">Sort</th>
                                <th style="width:50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(attr, index) in bulkForm.attributes" :key="index">
                                <td>
                                    <select class="form-control form-control-sm" v-model="attr.attribute_group_id">
                                        <option value="">-- Group --</option>
                                        <option v-for="g in attributeGroups" :key="g.id" :value="g.id">{{ g.name }}</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control form-control-sm" v-model="attr.name" /></td>
                                <td><textarea class="form-control form-control-sm" v-model="attr.details" rows="1"></textarea></td>
                                <td><input min="0" type="number" class="form-control form-control-sm text-center" v-model="attr.sort_order" /></td>
                                <td class="text-center align-middle">
                                    <button type="button" class="btn btn-xs btn-danger" @click="removeAttributeRow(index)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="bulkForm.attributes.length === 0">
                                <td colspan="5" class="text-center text-muted small py-3">
                                    <i class="fas fa-info-circle mr-1"></i>No attributes yet. Click Add below.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" @click="addAttributeRow">
                        <i class="fas fa-plus mr-1"></i>Add Row
                    </button>
                </div>
            </div>
            <div class="ap-modal-footer">
                <button class="btn btn-sm btn-secondary" @click="showAttributesModal = false">Cancel</button>
                <button class="btn btn-sm btn-primary" @click="submitBulkAttributes" :disabled="bulkForm.attributes.length === 0">
                    <i class="fas fa-check mr-1"></i>Apply Attributes
                </button>
            </div>
        </div>
    </div>

    <!-- SEO Modal -->
    <div class="ap-modal-backdrop" v-if="showSeoModal" @click.self="showSeoModal = false">
        <div class="ap-modal" style="max-width:500px;">
            <div class="ap-modal-header">
                <h6><i class="fas fa-search-plus text-info mr-2"></i>Edit SEO Meta Details</h6>
                <button class="ap-close" @click="showSeoModal = false">&times;</button>
            </div>
            <div class="ap-modal-body">
                <div class="form-group mb-3">
                    <label class="form-label small font-weight-bold">Meta Title</label>
                    <input type="text" class="form-control form-control-sm" v-model="seoForm.meta_title" placeholder="Meta title" />
                </div>
                <div class="form-group mb-3">
                    <label class="form-label small font-weight-bold">Meta Description</label>
                    <textarea class="form-control form-control-sm" v-model="seoForm.meta_description" rows="3" placeholder="Meta description"></textarea>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label small font-weight-bold">Meta Keywords</label>
                    <input type="text" class="form-control form-control-sm" v-model="seoForm.meta_keyword" placeholder="keyword1, keyword2, ..." />
                </div>
            </div>
            <div class="ap-modal-footer">
                <button class="btn btn-sm btn-secondary" @click="showSeoModal = false">Cancel</button>
                <button class="btn btn-sm btn-info" @click="submitSeoForm">
                    <i class="fas fa-save mr-1"></i>Save SEO
                </button>
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { getImageCacheUrl } from '@/layouts/helpers/helpers';
import { useToast } from '@/composables/useToast';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
import Pagination from '@/components/Paginations/Pagination.vue';

const toast = useToast();

// ---- State ----
const products = ref([]);
const categories = ref([]);
const attributeGroups = ref([]);
const availableOptions = ref([]);
const selectedOptionToAdd = ref("");

const searchQuery = ref("");
const selectedProductIds = ref([]);
const pagination = ref({ current_page: 1, last_page: 1, data: [] });

// Click-to-edit: track which cell is active
const editingCell = ref(null); // { productId, field }

// Modals
const showCategoriesModal = ref(false);
const showStatusModal = ref(false);
const showOptionsModal = ref(false);
const showAttributesModal = ref(false);
const showSeoModal = ref(false);

const isBulkAction = ref(true);
const currentEditProductId = ref(null);

const seoForm = ref({ product_id: null, meta_title: '', meta_description: '', meta_keyword: '' });

const bulkForm = ref({
    category_ids: [],
    statusField: 'status',
    statusValue: 1,
    options: [],
    attributes: []
});

let debounceTimer = null;

// ---- Custom directive: auto-focus ----
const vFocus = {
    mounted(el) { el.focus(); }
};

// ---- Category helpers ----
/**
 * Build "Parent > Child > Grandchild" path for a category
 */
const getCategoryPath = (cat, allCats) => {
    const path = [];
    let current = cat;
    while (current) {
        path.unshift(current.category_name);
        current = current.parent_id ? allCats.find(c => c.id === current.parent_id) : null;
    }
    return path.join(' > ');
};

/**
 * Short display: only the last segment (leaf name) for table badges
 */
const getCategoryPathShort = (cat, allCats) => {
    return cat.category_name;
};

/**
 * Computed options for @vueform/multiselect — value: id, label: path
 */
const categoriesOptions = computed(() =>
    categories.value.map(cat => ({
        value: cat.id,
        label: getCategoryPath(cat, categories.value)
    }))
);

// ---- Price formatter ----
const formatPrice = (val) => {
    const n = parseFloat(val);
    return isNaN(n) ? val : n.toFixed(2);
};

// ---- Click-to-edit helpers ----
const isEditing = (productId, field) => {
    return editingCell.value?.productId === productId && editingCell.value?.field === field;
};

const isRowEditing = (productId) => {
    return editingCell.value?.productId === productId;
};

const startEdit = (productId, field) => {
    editingCell.value = { productId, field };
};

const stopEdit = () => {
    editingCell.value = null;
};

// ---- Lifecycle ----
onMounted(() => {
    loadProducts();
    loadDependencies();
});

// ---- Data loading ----
const loadProducts = async (page = 1) => {
    try {
        const response = await axios.get('/api/advanced-products', {
            params: { page, search: searchQuery.value, per_page: 10 }
        });
        products.value = response.data.data.data;
        pagination.value = response.data.data;
    } catch (error) {
        toast.error("Failed to load products.");
    }
};

const loadDependencies = async () => {
    try {
        const [resCats, resGroups, resOpts] = await Promise.all([
            axios.get('/api/product-categories/all'),
            axios.get('/api/product-attribute-groups/all'),
            axios.get('/api/options/all')
        ]);
        categories.value = resCats.data.data;
        attributeGroups.value = resGroups.data.data;
        availableOptions.value = resOpts.data.data;
    } catch (error) {
        console.error("Dependency loading failed", error);
    }
};

const debouncedSearch = () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => loadProducts(1), 500);
};

// ---- Selection ----
const isAllSelected = computed(() =>
    products.value.length > 0 && products.value.every(p => selectedProductIds.value.includes(p.id))
);

const toggleSelectAll = (e) => {
    if (e.target.checked) {
        products.value.forEach(p => {
            if (!selectedProductIds.value.includes(p.id)) selectedProductIds.value.push(p.id);
        });
    } else {
        products.value.forEach(p => {
            const idx = selectedProductIds.value.indexOf(p.id);
            if (idx > -1) selectedProductIds.value.splice(idx, 1);
        });
    }
};

// ---- Inline save ----
const updateSingleField = async (productId, field, value) => {
    try {
        await axios.post('/api/advanced-products/update-field', { id: productId, field, value });
        toast.success(`"${field}" updated.`);
    } catch {
        toast.error("Failed to update field.");
    }
};

const saveProductRow = async (product) => {
    try {
        await axios.post('/api/advanced-products/update-row', {
            id: product.id,
            name: product.name,
            model: product.model,
            price: product.price,
            quantity: product.quantity
        });
        toast.success("Product saved!");
    } catch {
        toast.error("Failed to save product.");
    }
};

// ---- Modal openers ----
const openBulkCategoriesModal = () => {
    isBulkAction.value = true;
    bulkForm.value.category_ids = [];
    showCategoriesModal.value = true;
};

const openBulkStatusModal = () => {
    isBulkAction.value = true;
    bulkForm.value.statusField = 'status';
    bulkForm.value.statusValue = 1;
    showStatusModal.value = true;
};

const openBulkOptionsModal = () => {
    isBulkAction.value = true;
    bulkForm.value.options = [];
    selectedOptionToAdd.value = "";
    showOptionsModal.value = true;
};

const openBulkAttributesModal = () => {
    isBulkAction.value = true;
    bulkForm.value.attributes = [];
    showAttributesModal.value = true;
};

const openCategoriesModal = (product) => {
    isBulkAction.value = false;
    currentEditProductId.value = product.id;
    bulkForm.value.category_ids = product.categories ? product.categories.map(c => c.id) : [];
    showCategoriesModal.value = true;
};

const openOptionsModal = (product) => {
    isBulkAction.value = false;
    currentEditProductId.value = product.id;
    bulkForm.value.options = product.product_options ? product.product_options.map(opt => {
        const parentOpt = availableOptions.value.find(o => o.id === opt.option_id);
        return {
            option_id: opt.option_id,
            option_name: parentOpt ? parentOpt.name : '',
            option_value_id: opt.option_value_id,
            quantity: opt.quantity,
            subtract: opt.subtract,
            price_prefix: opt.price_prefix || '+',
            price: opt.price,
            available_values: parentOpt ? parentOpt.option_values : []
        };
    }) : [];
    selectedOptionToAdd.value = "";
    showOptionsModal.value = true;
};

const openAttributesModal = (product) => {
    isBulkAction.value = false;
    currentEditProductId.value = product.id;
    bulkForm.value.attributes = product.product_attributes ? product.product_attributes.map(attr => ({
        attribute_group_id: attr.attribute_group_id,
        name: attr.name,
        details: attr.details,
        sort_order: attr.sort_order
    })) : [];
    showAttributesModal.value = true;
};

const openSeoModal = (product) => {
    seoForm.value = {
        product_id: product.id,
        meta_title: product.description?.meta_title || '',
        meta_description: product.description?.meta_description || '',
        meta_keyword: product.description?.meta_keyword || '',
    };
    showSeoModal.value = true;
};

// ---- Options/Attributes row management ----
const addOptionRow = () => {
    if (!selectedOptionToAdd.value) return;
    bulkForm.value.options.push({
        option_id: selectedOptionToAdd.value.id,
        option_name: selectedOptionToAdd.value.name,
        option_value_id: '',
        quantity: 0,
        subtract: 1,
        price_prefix: '+',
        price: 0,
        available_values: selectedOptionToAdd.value.option_values || []
    });
    selectedOptionToAdd.value = "";
};

const removeOptionRow = (index) => bulkForm.value.options.splice(index, 1);

const addAttributeRow = () => {
    bulkForm.value.attributes.push({ attribute_group_id: '', name: '', details: '', sort_order: 0 });
};

const removeAttributeRow = (index) => bulkForm.value.attributes.splice(index, 1);

// ---- Submit actions ----
const submitBulkCategories = async () => {
    try {
        const productIds = isBulkAction.value ? selectedProductIds.value : [currentEditProductId.value];
        await axios.post('/api/advanced-products/bulk/categories', {
            product_ids: productIds,
            category_ids: bulkForm.value.category_ids
        });
        toast.success(isBulkAction.value ? "Bulk categories applied!" : "Categories updated!");
        showCategoriesModal.value = false;
        if (isBulkAction.value) selectedProductIds.value = [];
        loadProducts(pagination.value.current_page);
    } catch {
        toast.error("Failed to apply categories.");
    }
};

const submitBulkStatus = async () => {
    try {
        await axios.post('/api/advanced-products/bulk/status', {
            product_ids: selectedProductIds.value,
            field: bulkForm.value.statusField,
            value: bulkForm.value.statusValue
        });
        toast.success("Bulk status applied!");
        showStatusModal.value = false;
        selectedProductIds.value = [];
        loadProducts(pagination.value.current_page);
    } catch {
        toast.error("Failed to apply bulk status.");
    }
};

const submitBulkOptions = async () => {
    try {
        const productIds = isBulkAction.value ? selectedProductIds.value : [currentEditProductId.value];
        await axios.post('/api/advanced-products/bulk/options', {
            product_ids: productIds,
            options: bulkForm.value.options
        });
        toast.success(isBulkAction.value ? "Bulk options applied!" : "Options updated!");
        showOptionsModal.value = false;
        if (isBulkAction.value) selectedProductIds.value = [];
        loadProducts(pagination.value.current_page);
    } catch {
        toast.error("Failed to apply options.");
    }
};

const submitBulkAttributes = async () => {
    try {
        const productIds = isBulkAction.value ? selectedProductIds.value : [currentEditProductId.value];
        await axios.post('/api/advanced-products/bulk/attributes', {
            product_ids: productIds,
            attributes: bulkForm.value.attributes
        });
        toast.success(isBulkAction.value ? "Bulk attributes applied!" : "Attributes updated!");
        showAttributesModal.value = false;
        if (isBulkAction.value) selectedProductIds.value = [];
        loadProducts(pagination.value.current_page);
    } catch {
        toast.error("Failed to apply attributes.");
    }
};

const submitSeoForm = async () => {
    try {
        await axios.post('/api/advanced-products/update-description', seoForm.value);
        toast.success("SEO details saved!");
        showSeoModal.value = false;
        loadProducts(pagination.value.current_page);
    } catch {
        toast.error("Failed to save SEO details.");
    }
};
</script>

<style scoped>
/* ---- Table ---- */
.advanced-table thead th {
    background: #2c3e50;
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
    vertical-align: middle;
    border-bottom: none;
    padding: 10px 8px;
}
.advanced-table tbody tr {
    transition: background 0.1s;
}
.advanced-table tbody tr.row-editing {
    background: #fffbe6 !important;
}
.advanced-table tbody tr:hover {
    background: #f0f6ff;
}
.advanced-table tbody td {
    vertical-align: middle;
    font-size: 13px;
    padding: 6px 8px;
}
.product-thumb {
    width: 46px;
    height: 46px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #dee2e6;
}

/* ---- Click-to-edit cells ---- */
.editable-cell {
    cursor: pointer;
    position: relative;
}
.editable-cell:hover {
    background: #e8f4fd !important;
}
.cell-value {
    display: inline-block;
    max-width: 100%;
    word-break: break-word;
}
.code-value {
    font-family: monospace;
    font-size: 12px;
    color: #6c757d;
}
.cell-edit-icon {
    font-size: 9px;
    color: #adb5bd;
    margin-left: 5px;
    opacity: 0;
    transition: opacity 0.15s;
}
.editable-cell:hover .cell-edit-icon {
    opacity: 1;
}
.cell-input {
    min-width: 80px;
}

/* ---- Category badges ---- */
.cat-badge {
    font-size: 10px;
    padding: 3px 6px;
    border-radius: 4px;
    background: #f1f3f5;
    color: #495057;
    border: 1px solid #dee2e6 !important;
    white-space: nowrap;
    max-width: 130px;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ---- Custom Modals ---- */
.ap-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1060;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    min-height: 60vh !important;
}
.ap-modal {
    background: #fff;
    border-radius: 10px;
    width: 100%;
    max-width: 560px;
    max-height: 90vh;
    min-height: 60vh !important;
    display: flex;
    flex-direction: column;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    overflow: hidden;
}
.ap-modal-lg { max-width: 820px; }
.ap-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    border-bottom: 1px solid #dee2e6;
    background: #f8f9fa;
}
.ap-modal-header h6 {
    margin: 0;
    font-weight: 700;
    font-size: 14px;
    color: #343a40;
}
.ap-close {
    background: none;
    border: none;
    font-size: 22px;
    line-height: 1;
    color: #6c757d;
    cursor: pointer;
    padding: 0 4px;
}
.ap-close:hover { color: #343a40; }
.ap-modal-body {
    padding: 18px;
    overflow-y: auto;
    flex: 1;
}
.ap-modal-footer {
    padding: 12px 18px;
    border-top: 1px solid #dee2e6;
    background: #f8f9fa;
    display: flex;
    gap: 8px;
    justify-content: flex-end;
}

/* ---- Sticky save column ---- */
.action-col {
    position: sticky;
    right: 0;
    background: #fff;
    box-shadow: -2px 0 4px rgba(0,0,0,0.05);
}

/* ---- Utility ---- */
.btn-xs {
    padding: 3px 8px;
    font-size: 11px;
    border-radius: 4px;
}
</style>

<style>
/* @vueform/multiselect Bootstrap-compatible overrides (non-scoped so it affects the component) */
.multiselect-custom {
    --ms-border-color: #ced4da;
    --ms-border-width: 1px;
    --ms-radius: 4px;
    --ms-bg: #ffffff;
    --ms-tag-bg: #e3f0ff;
    --ms-tag-color: #1a5276;
    --ms-tag-radius: 4px;
    --ms-font-size: 13px;
    --ms-py: 6px;
    --ms-px: 10px;
}
.multiselect-custom .multiselect-tags-search {
    background-color: transparent !important;
}
.multiselect-custom .multiselect-option.is-selected {
    background: #2980b9;
}
.multiselect-custom .multiselect-tag {
    font-size: 12px;
    padding: 2px 8px;
}
</style>
