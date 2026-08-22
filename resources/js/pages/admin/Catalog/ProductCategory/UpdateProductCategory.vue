<template>
    <DashboardHeader title="Update Product Category" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Update Product Category</h3>
                    </div>

                    <form @submit.prevent="updateCategory">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Category Name <span class="text-danger">*</span></label>
                                        <input v-model="form.category_name" type="text" class="form-control" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Alt Name</label>
                                        <input v-model="form.alt_name" type="text" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label>Badge Background Color</label>
                                        <div class="d-flex align-items-center">
                                            <input v-model="form.bg_color" type="color" class="form-control" style="width: 48px; height: 38px; padding: 2px; cursor: pointer; flex-shrink: 0;" />
                                            <input v-model="form.bg_color" type="text" class="form-control ml-2" placeholder="#00c853" style="max-width: 130px;" />
                                            <div class="d-flex ml-3 align-items-center" style="gap: 6px;">
                                                <button type="button" class="btn rounded-circle border p-0" style="width: 24px; height: 24px; background-color: #00c853;" title="Green (Hospital/Health)" @click="form.bg_color = '#00c853'"></button>
                                                <button type="button" class="btn rounded-circle border p-0" style="width: 24px; height: 24px; background-color: #0066cc;" title="Blue (Residential)" @click="form.bg_color = '#0066cc'"></button>
                                                <button type="button" class="btn rounded-circle border p-0" style="width: 24px; height: 24px; background-color: #7c3aed;" title="Purple (Commercial)" @click="form.bg_color = '#7c3aed'"></button>
                                                <button type="button" class="btn rounded-circle border p-0" style="width: 24px; height: 24px; background-color: #f59e0b;" title="Amber (Industrial)" @click="form.bg_color = '#f59e0b'"></button>
                                                <button type="button" class="btn rounded-circle border p-0" style="width: 24px; height: 24px; background-color: #0d9488;" title="Teal (Education)" @click="form.bg_color = '#0d9488'"></button>
                                                <button type="button" class="btn rounded-circle border p-0" style="width: 24px; height: 24px; background-color: #06b6d4;" title="Cyan (Cleanroom)" @click="form.bg_color = '#06b6d4'"></button>
                                                <button type="button" class="btn rounded-circle border p-0" style="width: 24px; height: 24px; background-color: #ef4444;" title="Red (Critical)" @click="form.bg_color = '#ef4444'"></button>
                                            </div>
                                        </div>
                                        <small class="text-muted">Color of the badge pill shown on product cards (e.g. #00c853 for green).</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Parent Category</label>
                                        <select v-model="form.parent_id" class="form-control">
                                            <option :value="null">None (Top Level)</option>
                                            <option v-for="cat in parentCategories" :key="cat.id" :value="cat.id"
                                                :disabled="cat.id === categoryId">
                                                {{ cat.category_name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea v-model="form.description" class="form-control" rows="3"></textarea>
                                    </div>

                                    <!-- Category Feature Badges / Highlights Repeater -->
                                    <div class="card card-outline card-primary mt-4">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h3 class="card-title font-weight-bold">
                                                <i class="fas fa-layer-group mr-2 text-primary"></i> Category Features (Highlight Badges)
                                            </h3>
                                            <button type="button" class="btn btn-sm btn-outline-primary ml-auto" @click="addFeature">
                                                <i class="fas fa-plus mr-1"></i> Add Feature
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted small mb-3">
                                                Add custom benefit/feature cards for this category (e.g. Cost Savings, Allergen Reduction, Intelligent Sensors). These display under the category title on the storefront.
                                            </p>
                                            <div v-if="form.features && form.features.length" class="row">
                                                <div v-for="(feat, idx) in form.features" :key="idx" class="col-md-6 mb-3">
                                                    <div class="p-3 border rounded bg-light position-relative shadow-sm">
                                                        <button type="button" class="btn btn-sm btn-danger position-absolute" style="top: 8px; right: 8px; padding: 2px 6px;" title="Remove Feature" @click="removeFeature(idx)">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <div class="form-group mb-2">
                                                            <label class="small font-weight-bold">Icon Class (Bootstrap Icon)</label>
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i :class="'bi ' + (feat.icon || 'bi-box')"></i></span>
                                                                </div>
                                                                <input v-model="feat.icon" type="text" class="form-control" placeholder="e.g. bi-shield-check, bi-cpu, bi-wind" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label class="small font-weight-bold">Title</label>
                                                            <input v-model="feat.title" type="text" class="form-control form-control-sm" placeholder="e.g. Cost Savings" />
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <label class="small font-weight-bold">Description</label>
                                                            <textarea v-model="feat.desc" rows="2" class="form-control form-control-sm" placeholder="e.g. Lower utility bills and operational costs."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else class="text-center py-4 text-muted border border-dashed rounded bg-white">
                                                <i class="fas fa-icons fa-2x mb-2 d-block text-secondary"></i>
                                                <span>No custom features added yet. Click <strong>Add Feature</strong> to add tailored highlight badges.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="mt-4">SEO Meta Data</h5>
                                    <hr />
                                    <div class="form-group">
                                        <label>Meta Title</label>
                                        <input v-model="form.meta_title" type="text" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea v-model="form.meta_description" class="form-control"
                                            rows="2"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <input v-model="form.meta_keyword" type="text" class="form-control" />
                                    </div>

                                    <h5 class="mt-4">Featured Category Products</h5>
                                    <hr />
                                    <div class="form-group mb-3">
                                        <label class="form-label">Featured Top Product (1 Product at Category Top)</label>
                                        <Multiselect
                                            v-model="form.featured_top_product_id"
                                            :options="productsOptions"
                                            :searchable="true"
                                            :canClear="true"
                                            placeholder="Type to search & select top product..."
                                        />
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Featured Middle Product (1 Product at Category Middle)</label>
                                        <Multiselect
                                            v-model="form.featured_middle_product_id"
                                            :options="productsOptions"
                                            :searchable="true"
                                            :canClear="true"
                                            placeholder="Type to search & select middle product..."
                                        />
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Featured Bottom Product (1 Product at Category Bottom)</label>
                                        <Multiselect
                                            v-model="form.featured_bottom_product_id"
                                            :options="productsOptions"
                                            :searchable="true"
                                            :canClear="true"
                                            placeholder="Type to search & select bottom product..."
                                        />
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <!-- File Upload -->
                                    <div class="form-group">
                                        <label>Upload Image</label>
                                        <Vue3Dropzone v-model="fileUpload" v-model:previews="previews" mode="edit"
                                            :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended: 1140 × 586px</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Icon Type</label>
                                        <div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="iconTypeClass" class="custom-control-input"
                                                    value="class" v-model="form.icon_type">
                                                <label class="custom-control-label" for="iconTypeClass">Icon Class</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="iconTypeModel" class="custom-control-input"
                                                    value="model" v-model="form.icon_type">
                                                <label class="custom-control-label" for="iconTypeModel">Custom Icon</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" v-if="form.icon_type === 'class'">
                                        <label>Icon Class</label>
                                        <IconPicker v-model="form.icon_class" />
                                        <small class="text-muted">FontAwesome or Bootstrap icon class</small>
                                    </div>

                                    <div class="form-group" v-if="form.icon_type === 'model'">
                                        <label>Select Custom Icon</label>
                                        <div class="d-flex flex-wrap border p-2 rounded"
                                            style="max-height: 200px; overflow-y: auto;">
                                            <div v-for="iconItem in icons" :key="iconItem.id"
                                                class="m-1 p-2 border rounded text-center"
                                                :class="{ 'border-primary bg-light shadow-sm': form.icon_id === iconItem.id }"
                                                @click="form.icon_id = iconItem.id"
                                                style="width: 50px; height: 50px; cursor: pointer;">
                                                <div v-html="iconItem.code"
                                                    style="width: 30px; height: 30px; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-muted" v-if="!form.icon_id">Please select an icon.</small>
                                    </div>

                                    <!-- Sort Order -->
                                    <div class="form-group">
                                        <label>Sort Order</label>
                                        <input min="0" v-model="form.sort_order" type="number" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label>Header Menu</label>
                                        <select v-model="form.header_menu" class="custom-select">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Side Menu</label>
                                        <select v-model="form.side_menu" class="custom-select">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select v-model="form.status" class="custom-select">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-info btn-block">Update</button>
                                        </div>
                                        <div class="col-md-6">
                                            <RouterLink :to="{ name: 'ProductCategories' }"
                                                class="btn btn-secondary btn-block">Cancel</RouterLink>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import IconPicker from '@/components/IconPicker.vue';
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
import axios from 'axios';
import { reactive, ref, onMounted, computed } from 'vue';
import { useToast } from '@/composables/useToast';
import { useRoute, useRouter } from 'vue-router';
import { getImageUrl, getImageCacheUrl } from '@/layouts/helpers/helpers';

const toast = useToast();
const route = useRoute();
const router = useRouter();

const categoryId = route.params.id;
const fileUpload = ref(null);
const previews = ref([]);
const parentCategories = ref([]);
const icons = ref([]);
const productsList = ref([]);

const form = reactive({
    category_name: '',
    alt_name: '',
    bg_color: '#00c853',
    parent_id: null,
    description: '',
    meta_title: '',
    meta_description: '',
    meta_keyword: '',
    icon_type: 'class',
    icon_class: '',
    icon_id: null,
    sort_order: 0,
    header_menu: 0,
    side_menu: 0,
    status: 1,
    remove_image: 0,
    featured_top_product_id: null,
    featured_middle_product_id: null,
    featured_bottom_product_id: null,
    features: [],
});

const addFeature = () => {
    form.features.push({
        icon: 'bi-shield-check',
        title: '',
        desc: ''
    });
};

const removeFeature = (index) => {
    form.features.splice(index, 1);
};

const productsOptions = computed(() => {
    return productsList.value.map((prod) => ({
        label: `${prod.name} (${prod.model || 'SKU'})`,
        value: prod.id,
    }));
});

onMounted(async () => {
    try {
        // Fetch category details, parent categories, icons, and products list concurrently
        const [res, parentsRes, iconsRes, prodsRes] = await Promise.all([
            axios.get(`/api/product-categories/${categoryId}`),
            axios.get('/api/product-categories/all'),
            axios.get('/api/icons'),
            axios.get('/api/products/all-dropdown', { params: { category_id: categoryId } })
        ]);

        const data = res.data.data;
        parentCategories.value = parentsRes.data.data;
        icons.value = iconsRes.data.data;
        
        let prods = prodsRes.data.data || [];
        if (prods.length === 0) {
            const fallbackProds = await axios.get('/api/products/all-dropdown');
            prods = fallbackProds.data.data || [];
        }
        productsList.value = prods;

        form.category_name = data.category_name;
        form.alt_name = data.alt_name;
        form.bg_color = data.bg_color || '#00c853';
        form.parent_id = data.parent_id;
        form.description = data.description || '';
        form.meta_title = data.meta_title || '';
        form.meta_description = data.meta_description || '';
        form.meta_keyword = data.meta_keyword || '';

        form.icon_id = data.icon_id || null;
        form.icon_class = data.icon_class || '';
        form.icon_type = data.icon_id ? 'model' : (data.icon_class ? 'class' : 'class');

        form.sort_order = data.sort_order;
        form.header_menu = data.header_menu;
        form.side_menu = data.side_menu;
        form.status = data.status;

        form.features = Array.isArray(data.features) ? data.features : (typeof data.features === 'string' ? JSON.parse(data.features) : []);

        form.featured_top_product_id = data.featured_top_product_id || (data.featured_top_product_ids ? data.featured_top_product_ids[0] : null);
        form.featured_middle_product_id = data.featured_middle_product_id || (data.featured_middle_product_ids ? data.featured_middle_product_ids[0] : null);
        form.featured_bottom_product_id = data.featured_bottom_product_id || (data.featured_bottom_product_ids ? data.featured_bottom_product_ids[0] : null);

        if (data.image) {
            previews.value = [getImageCacheUrl(data.image)];
        }

    } catch (error) {
        toast.error('Failed to load category data.');
        console.error(error);
    }
});

const updateCategory = async () => {
    const payload = new FormData();

    if (!previews.value[0]) {
        form.remove_image = 1;
    } else {
        form.remove_image = 0;
    }

    for (const key in form) {
        if (key === 'icon_type') continue;
        if (key === 'featured_top_product_id' || key === 'featured_middle_product_id' || key === 'featured_bottom_product_id') {
            if (form[key]) {
                payload.append(key, form[key]);
            } else {
                payload.append(key, '');
            }
            continue;
        }

        if (key === 'features') {
            if (form.features && form.features.length) {
                payload.append('features', JSON.stringify(form.features));
            } else {
                payload.append('features', JSON.stringify([]));
            }
            continue;
        }

        let value = form[key];

        // Nullify the unselected icon field
        if (key === 'icon_class' && form.icon_type !== 'class') value = '';
        if (key === 'icon_id' && form.icon_type !== 'model') value = '';

        if (value !== null && value !== undefined) {
            payload.append(key, value);
        }
    }

    if (fileUpload.value && fileUpload.value[0] && fileUpload.value[0].file) {
        payload.append('image', fileUpload.value[0].file);
    }

    payload.append('_method', 'put');

    try {
        await axios.post(`/api/product-categories/${categoryId}`, payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        toast.success('Category updated successfully!');
        router.push({ name: 'ProductCategories' });
    } catch (error) {
        toast.validationError(error);
    }
};
</script>
