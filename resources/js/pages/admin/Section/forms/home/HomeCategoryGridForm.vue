<template>
    <div class="home-category-grid-form">
        <!-- Top Action / CTA Bar Settings -->
        <div class="card card-primary card-outline shadow-sm mb-4">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold text-dark">
                    <i class="fas fa-bullhorn text-primary mr-2"></i> Section Action Buttons (Top & Bottom CTA)
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label class="font-weight-600">Button Label Text</label>
                            <input v-model="form.action_text" type="text" class="form-control"
                                placeholder="e.g. Find Your Solutions" />
                            <small class="text-muted">Displays on the top and bottom lightbulb pill button.</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label class="font-weight-600">Target Link URL</label>
                            <input v-model="form.action_url" type="text" class="form-control"
                                placeholder="e.g. /category/products or custom link" />
                            <small class="text-muted">Destination page when user clicks the CTA button.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Row: 4 Bento Category Cards -->
        <div class="card card-outline card-info shadow-sm mb-4">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold text-dark">
                    <i class="fas fa-th-large text-info mr-2"></i> Top Row: 4 Bento Category Cards
                </h3>
                <div class="card-tools">
                    <span class="badge badge-info px-2 py-1">50% Left / 50% Right Cluster</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Card 1: Fresh Air Unit (Left Large Tile) -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border bg-light">
                            <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-wind text-primary mr-1"></i> Slot 1: Left Large Card (Fresh Air)</span>
                                <span class="badge badge-primary">50% Width</span>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Link to Product Category</label>
                                    <Multiselect
                                        v-model="form.fresh_air_category_id"
                                        :options="categorySelectOptions"
                                        :searchable="true"
                                        placeholder="-- Choose Category (Auto-fills Title & URL) --"
                                        class="multiselect-custom"
                                        @select="() => onCategorySelect('fresh_air')"
                                        @clear="() => onCategoryClear('fresh_air')"
                                    />
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Badge Title <span class="text-danger">*</span></label>
                                            <input v-model="form.fresh_air_title" type="text" class="form-control form-control-sm" placeholder="Fresh Air Unit" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Target Link URL</label>
                                            <input v-model="form.fresh_air_url" type="text" class="form-control form-control-sm" placeholder="/category/..." />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">Card Background Image</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="border rounded p-1 bg-white" style="width: 80px; height: 60px; overflow: hidden; flex-shrink: 0;">
                                            <img :src="gridPreviews.fresh_air_image || getImageUrl(form.fresh_air_image)" class="w-100 h-100" style="object-fit: cover;" alt="Preview" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" accept="image/*" class="form-control-file form-control-sm" @change="(e) => handleFileChange(e, 'fresh_air_image')" />
                                            <small class="text-muted d-block mt-1">Recommended: 4:3 ratio</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Air Pro Mask (Middle Top Tile) -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border bg-light">
                            <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-head-side-mask text-info mr-1"></i> Slot 2: Middle Top Card (Masks)</span>
                                <span class="badge badge-light border">25% Width</span>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Link to Product Category</label>
                                    <Multiselect
                                        v-model="form.mask_category_id"
                                        :options="categorySelectOptions"
                                        :searchable="true"
                                        placeholder="-- Choose Category --"
                                        class="multiselect-custom"
                                        @select="() => onCategorySelect('mask')"
                                        @clear="() => onCategoryClear('mask')"
                                    />
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Badge Title <span class="text-danger">*</span></label>
                                            <input v-model="form.mask_title" type="text" class="form-control form-control-sm" placeholder="Air Pro Mask" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Target Link URL</label>
                                            <input v-model="form.mask_url" type="text" class="form-control form-control-sm" placeholder="/category/..." />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">Card Background Image</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="border rounded p-1 bg-white" style="width: 80px; height: 60px; overflow: hidden; flex-shrink: 0;">
                                            <img :src="gridPreviews.mask_image || getImageUrl(form.mask_image)" class="w-100 h-100" style="object-fit: cover;" alt="Preview" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" accept="image/*" class="form-control-file form-control-sm" @change="(e) => handleFileChange(e, 'mask_image')" />
                                            <small class="text-muted d-block mt-1">Recommended: 1:1 or 4:3 ratio</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Accessories (Middle Bottom Tile) -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border bg-light">
                            <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-tools text-warning mr-1"></i> Slot 3: Middle Bottom Card (Accessories)</span>
                                <span class="badge badge-light border">25% Width</span>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Link to Product Category</label>
                                    <Multiselect
                                        v-model="form.accessories_category_id"
                                        :options="categorySelectOptions"
                                        :searchable="true"
                                        placeholder="-- Choose Category --"
                                        class="multiselect-custom"
                                        @select="() => onCategorySelect('accessories')"
                                        @clear="() => onCategoryClear('accessories')"
                                    />
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Badge Title <span class="text-danger">*</span></label>
                                            <input v-model="form.accessories_title" type="text" class="form-control form-control-sm" placeholder="Accessories" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Target Link URL</label>
                                            <input v-model="form.accessories_url" type="text" class="form-control form-control-sm" placeholder="/category/..." />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">Card Background Image</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="border rounded p-1 bg-white" style="width: 80px; height: 60px; overflow: hidden; flex-shrink: 0;">
                                            <img :src="gridPreviews.accessories_image || getImageUrl(form.accessories_image)" class="w-100 h-100" style="object-fit: cover;" alt="Preview" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" accept="image/*" class="form-control-file form-control-sm" @change="(e) => handleFileChange(e, 'accessories_image')" />
                                            <small class="text-muted d-block mt-1">Recommended: 1:1 or 4:3 ratio</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Air Purifiers (Right Tall Tile) -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border bg-light">
                            <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-fan text-success mr-1"></i> Slot 4: Right Tall Card (Purifiers)</span>
                                <span class="badge badge-success">25% Width Full Height</span>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Link to Product Category</label>
                                    <Multiselect
                                        v-model="form.purifier_category_id"
                                        :options="categorySelectOptions"
                                        :searchable="true"
                                        placeholder="-- Choose Category --"
                                        class="multiselect-custom"
                                        @select="() => onCategorySelect('purifier')"
                                        @clear="() => onCategoryClear('purifier')"
                                    />
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Badge Title <span class="text-danger">*</span></label>
                                            <input v-model="form.purifier_title" type="text" class="form-control form-control-sm" placeholder="Air Purifiers" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Target Link URL</label>
                                            <input v-model="form.purifier_url" type="text" class="form-control form-control-sm" placeholder="/category/..." />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">Card Background Image</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="border rounded p-1 bg-white" style="width: 80px; height: 60px; overflow: hidden; flex-shrink: 0;">
                                            <img :src="gridPreviews.purifier_image || getImageUrl(form.purifier_image)" class="w-100 h-100" style="object-fit: cover;" alt="Preview" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" accept="image/*" class="form-control-file form-control-sm" @change="(e) => handleFileChange(e, 'purifier_image')" />
                                            <small class="text-muted d-block mt-1">Recommended: 3:4 portrait ratio (e.g. 800x1067)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Row: 2 Solutions Banners (50% / 50%) -->
        <div class="card card-outline card-purple shadow-sm mb-4">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold text-dark">
                    <i class="fas fa-layer-group text-purple mr-2"></i> Bottom Row: 2 Solutions Banners (50% / 50%)
                </h3>
                <div class="card-tools">
                    <span class="badge badge-purple px-2 py-1">Full Width Half-Half</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Banner 5: Solutions for Home -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border bg-light">
                            <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-home text-primary mr-1"></i> Slot 5: Solutions for Home</span>
                                <span class="badge badge-primary">50% Width Banner</span>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Link to Product Category</label>
                                    <Multiselect
                                        v-model="form.home_solutions_category_id"
                                        :options="categorySelectOptions"
                                        :searchable="true"
                                        placeholder="-- Choose Category --"
                                        class="multiselect-custom"
                                        @select="() => onCategorySelect('home_solutions')"
                                        @clear="() => onCategoryClear('home_solutions')"
                                    />
                                </div>
                                <div class="form-group">
                                    <label class="small font-weight-bold">Banner Headline <span class="text-danger">*</span></label>
                                    <input v-model="form.home_solutions_title" type="text" class="form-control form-control-sm" placeholder="Solutions for Home" />
                                </div>
                                <div class="form-group">
                                    <label class="small font-weight-bold">Subtitle / Description</label>
                                    <input v-model="form.home_solutions_sub" type="text" class="form-control form-control-sm" placeholder="Ventilation and Filtration Solution" />
                                </div>
                                <div class="form-group">
                                    <label class="small font-weight-bold">Target Link URL</label>
                                    <input v-model="form.home_solutions_url" type="text" class="form-control form-control-sm" placeholder="/category/..." />
                                </div>
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">Banner Background Image</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="border rounded p-1 bg-white" style="width: 100px; height: 60px; overflow: hidden; flex-shrink: 0;">
                                            <img :src="gridPreviews.home_solutions_image || getImageUrl(form.home_solutions_image)" class="w-100 h-100" style="object-fit: cover;" alt="Preview" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" accept="image/*" class="form-control-file form-control-sm" @change="(e) => handleFileChange(e, 'home_solutions_image')" />
                                            <small class="text-muted d-block mt-1">Recommended: 16:9 landscape ratio (e.g. 1400x780)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Banner 6: Solutions for Business -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border bg-light">
                            <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-building text-info mr-1"></i> Slot 6: Solutions for Business</span>
                                <span class="badge badge-info">50% Width Banner</span>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Link to Product Category</label>
                                    <Multiselect
                                        v-model="form.biz_solutions_category_id"
                                        :options="categorySelectOptions"
                                        :searchable="true"
                                        placeholder="-- Choose Category --"
                                        class="multiselect-custom"
                                        @select="() => onCategorySelect('biz_solutions')"
                                        @clear="() => onCategoryClear('biz_solutions')"
                                    />
                                </div>
                                <div class="form-group">
                                    <label class="small font-weight-bold">Banner Headline <span class="text-danger">*</span></label>
                                    <input v-model="form.biz_solutions_title" type="text" class="form-control form-control-sm" placeholder="Solutions for Business" />
                                </div>
                                <div class="form-group">
                                    <label class="small font-weight-bold">Subtitle / Description</label>
                                    <input v-model="form.biz_solutions_sub" type="text" class="form-control form-control-sm" placeholder="Air Disinfection & Air Monitoring" />
                                </div>
                                <div class="form-group">
                                    <label class="small font-weight-bold">Target Link URL</label>
                                    <input v-model="form.biz_solutions_url" type="text" class="form-control form-control-sm" placeholder="/category/..." />
                                </div>
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">Banner Background Image</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="border rounded p-1 bg-white" style="width: 100px; height: 60px; overflow: hidden; flex-shrink: 0;">
                                            <img :src="gridPreviews.biz_solutions_image || getImageUrl(form.biz_solutions_image)" class="w-100 h-100" style="object-fit: cover;" alt="Preview" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" accept="image/*" class="form-control-file form-control-sm" @change="(e) => handleFileChange(e, 'biz_solutions_image')" />
                                            <small class="text-muted d-block mt-1">Recommended: 16:9 landscape ratio (e.g. 1400x780)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="d-flex justify-content-end align-items-center mb-5">
            <router-link :to="{ name: 'Section' }" class="btn btn-secondary mr-2">
                <i class="fas fa-times mr-1"></i> Cancel
            </router-link>
            <button type="button" @click="$emit('save')" class="btn btn-primary" :disabled="saving">
                <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save & Update Category Grid' }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, reactive, onMounted } from 'vue';
import axios from 'axios';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
import { getImageUrl } from '@/layouts/helpers/helpers';

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    saving: {
        type: Boolean,
        default: false,
    },
    gridFiles: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(['save', 'fileChange']);

const allCategories = ref([]);
const loadingCategories = ref(false);

const gridPreviews = reactive({
    fresh_air_image: '',
    mask_image: '',
    accessories_image: '',
    purifier_image: '',
    home_solutions_image: '',
    biz_solutions_image: '',
});

const loadCategories = async () => {
    try {
        loadingCategories.value = true;
        const res = await axios.get('/api/product-categories/all');
        allCategories.value = res.data.data || [];
    } catch (err) {
        console.error('Failed to load categories dropdown', err);
    } finally {
        loadingCategories.value = false;
    }
};

const categorySelectOptions = computed(() => {
    return allCategories.value.map((c) => ({
        value: c.id,
        label: c.category_name,
        slug: c.slug,
        image: c.image,
    }));
});

const onCategorySelect = (slotPrefix) => {
    const catId = props.form[`${slotPrefix}_category_id`];
    if (!catId) return;
    const cat = allCategories.value.find((c) => Number(c.id) === Number(catId));
    if (cat) {
        if (!props.form[`${slotPrefix}_title`] || props.form[`${slotPrefix}_title`] === 'Untitled') {
            props.form[`${slotPrefix}_title`] = cat.category_name;
        }
        props.form[`${slotPrefix}_url`] = `/category/${cat.slug}`;
    }
};

const onCategoryClear = (slotPrefix) => {
    props.form[`${slotPrefix}_category_id`] = null;
};

const handleFileChange = (e, key) => {
    const file = e.target.files?.[0];
    if (file) {
        gridPreviews[key] = URL.createObjectURL(file);
        if (props.gridFiles) {
            props.gridFiles[`${key}_file`] = file;
        }
        emit('fileChange', `${key}_file`, file);
    }
};

onMounted(() => {
    loadCategories();
});
</script>
