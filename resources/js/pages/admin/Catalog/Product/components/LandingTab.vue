<template>
    <div class="tab-pane fade" id="custom-tabs-landing" role="tabpanel"
        aria-labelledby="tab-landing">
        <!-- Enable Toggle Header -->
        <div class="card mb-4 border-primary">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="toggleLanding"
                            v-model="formData.landing_enabled">
                        <label class="custom-control-label font-weight-bold fs-5 text-dark" for="toggleLanding">
                            Enable Dedicated Landing Page
                        </label>
                    </div>
                    <small class="text-muted d-block mt-1">
                        When enabled, a high-converting, animated showcase page is activated at
                        <code>/product-landing/{{ formData.slug || productId }}</code>.
                        The Bottom CTA automatically synchronizes with the Hero section.
                    </small>
                </div>
                <div v-if="formData.landing_enabled" class="d-flex align-items-center">
                    <a :href="`/product-landing/${formData.slug || productId}`" target="_blank"
                        class="btn btn-outline-primary btn-sm px-3 py-2 font-weight-bold text-nowrap">
                        <i class="fas fa-external-link-alt mr-1"></i> View Live Landing Page
                    </a>
                </div>
            </div>
        </div>

        <div v-show="formData.landing_enabled">
            <!-- 1. HERO SECTION -->
            <div class="card card-outline card-secondary mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-flag-checkered text-primary mr-2"></i> 1. Hero Section (Reused by Bottom CTA)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Model Tag / Badge</label>
                            <input type="text" class="form-control" v-model="formData.landing_hero_tag"
                                placeholder="e.g. AIRE Pro S1" />
                        </div>
                        <div class="col-md-8 form-group">
                            <label>Hero Title / Main Heading</label>
                            <input type="text" class="form-control" v-model="formData.landing_hero_title"
                                placeholder="e.g. Atmospheric Mastery." />
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Hero Subtitle / Description</label>
                            <textarea class="form-control" rows="3" v-model="formData.landing_hero_description"
                                placeholder="Experience revolutionary synthesis technology designed to purify every molecule..."></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Action Button Text</label>
                            <input type="text" class="form-control" v-model="formData.landing_hero_button_text"
                                placeholder="e.g. More Details -" />
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Action Button URL</label>
                            <input type="text" class="form-control" v-model="formData.landing_hero_button_url"
                                placeholder="e.g. /products/... or leave blank for default" />
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Hero & Bottom CTA Image</label>
                            <Vue3Dropzone v-model="heroImage" v-model:previews="heroPreviews"
                                :mode="mode" :allowSelectOnPreview="true"
                                @previewRemoved="() => onPreviewRemoved('landing_hero_image')" />
                            <small class="text-muted d-block mt-1">Recommended: PNG with transparent background (1000 × 1000px)</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. SCIENCE OF SYNTHESIS SECTION -->
            <div class="card card-outline card-secondary mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-atom text-info mr-2"></i> 2. Science of Synthesis Section
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Section Tag</label>
                            <input type="text" class="form-control" v-model="formData.landing_science_tag"
                                placeholder="e.g. SCIENCE OF SYNTHESIS" />
                        </div>
                        <div class="col-md-8 form-group">
                            <label>Section Title (Line breaks supported)</label>
                            <textarea rows="2" class="form-control" v-model="formData.landing_science_title"
                                placeholder="e.g. Extraordinary&#10;from within."></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Section Description</label>
                            <textarea class="form-control" rows="3" v-model="formData.landing_science_description"
                                placeholder="Every layer is engineered for peak performance..."></textarea>
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Stat 1 Value</label>
                            <input type="text" class="form-control" v-model="formData.landing_science_stat1_value"
                                placeholder="e.g. 99.99%" />
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Stat 1 Label</label>
                            <input type="text" class="form-control" v-model="formData.landing_science_stat1_label"
                                placeholder="e.g. PARTICLE REMOVAL" />
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Stat 2 Value</label>
                            <input type="text" class="form-control" v-model="formData.landing_science_stat2_value"
                                placeholder="e.g. UV-C" />
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Stat 2 Label</label>
                            <input type="text" class="form-control" v-model="formData.landing_science_stat2_label"
                                placeholder="e.g. STERILIZATION" />
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Science Card Internal Image</label>
                            <Vue3Dropzone v-model="scienceImage" v-model:previews="sciencePreviews"
                                :mode="mode" :allowSelectOnPreview="true"
                                @previewRemoved="() => onPreviewRemoved('landing_science_image')" />
                        </div>
                    </div>

                    <!-- Science Feature Highlights -->
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="font-weight-bold mb-0">Feature Highlights List</label>
                            <button type="button" class="btn btn-sm btn-outline-primary" @click="addScienceFeature">
                                <i class="fas fa-plus mr-1"></i> Add Highlight
                            </button>
                        </div>
                        <div v-for="(feat, fIdx) in formData.landing_science_features" :key="fIdx"
                            class="border rounded p-3 mb-2 bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-4 form-group mb-md-0">
                                    <input type="text" class="form-control" v-model="feat.title"
                                        placeholder="Highlight Title" />
                                </div>
                                <div class="col-md-7 form-group mb-md-0">
                                    <input type="text" class="form-control" v-model="feat.desc"
                                        placeholder="Highlight Description" />
                                </div>
                                <div class="col-md-1 text-center">
                                    <button type="button" class="btn btn-sm btn-danger"
                                        @click="removeScienceFeature(fIdx)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. LIFESTYLE INTEGRATION SECTION -->
            <div class="card card-outline card-secondary mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-couch text-success mr-2"></i> 3. Lifestyle Integration Section
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Section Tag</label>
                            <input type="text" class="form-control" v-model="formData.landing_lifestyle_tag"
                                placeholder="e.g. LIFESTYLE" />
                        </div>
                        <div class="col-md-8 form-group">
                            <label>Section Title (Line breaks supported)</label>
                            <textarea rows="2" class="form-control" v-model="formData.landing_lifestyle_title"
                                placeholder="e.g. Seamless&#10;Integration."></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="3" v-model="formData.landing_lifestyle_description"
                                placeholder="Designed for your life, not just your air..."></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Button Text</label>
                            <input type="text" class="form-control" v-model="formData.landing_lifestyle_button_text"
                                placeholder="e.g. More Details &rarr;" />
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Button URL</label>
                            <input type="text" class="form-control" v-model="formData.landing_lifestyle_button_url"
                                placeholder="e.g. /category/... or #" />
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Lifestyle Wide Background Image</label>
                            <Vue3Dropzone v-model="lifestyleImage" v-model:previews="lifestylePreviews"
                                :mode="mode" :allowSelectOnPreview="true"
                                @previewRemoved="() => onPreviewRemoved('landing_lifestyle_image')" />
                            <small class="text-muted d-block mt-1">Recommended: Wide Banner (1920 × 900px)</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. MEDICAL-GRADE PRECISION FILTER SECTION -->
            <div class="card card-outline card-secondary mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-shield-virus text-warning mr-2"></i> 4. Medical-Grade Precision Filter Tech Section
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Section Heading</label>
                            <input type="text" class="form-control" v-model="formData.landing_filter_tech_title"
                                placeholder="e.g. Medical-grade Precision." />
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Badge Overlay Text</label>
                            <input type="text" class="form-control" v-model="formData.landing_filter_tech_badge_text"
                                placeholder="e.g. Advanced micro-fiber weaving..." />
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Section Subtitle / Description</label>
                            <textarea class="form-control" rows="2" v-model="formData.landing_filter_tech_description"
                                placeholder="HEPA H13 Filter Technology. From microscopic particles..."></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Macro Filter Image</label>
                            <Vue3Dropzone v-model="filterImage" v-model:previews="filterPreviews"
                                :mode="mode" :allowSelectOnPreview="true"
                                @previewRemoved="() => onPreviewRemoved('landing_filter_tech_image')" />
                            <small class="text-muted d-block mt-1">Recommended: 1400 × 600px</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. PRECISION ENGINEERING SPECS SECTION -->
            <div class="card card-outline card-secondary mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-sliders-h text-danger mr-2"></i> 5. Precision Engineering Specs Section
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Section Heading</label>
                            <input type="text" class="form-control" v-model="formData.landing_specs_title"
                                placeholder="e.g. Precision Engineering." />
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Section Subtitle</label>
                            <input type="text" class="form-control" v-model="formData.landing_specs_subtitle"
                                placeholder="e.g. The definitive standard for air purification." />
                        </div>
                        <div class="col-md-6 form-group">
                            <label>More Details Link Text</label>
                            <input type="text" class="form-control" v-model="formData.landing_specs_button_text"
                                placeholder="e.g. More Details &rarr;" />
                        </div>
                        <div class="col-md-6 form-group">
                            <label>More Details Link URL</label>
                            <input type="text" class="form-control" v-model="formData.landing_specs_button_url"
                                placeholder="e.g. /products/... or #" />
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Default Exploded 3D Image</label>
                            <Vue3Dropzone v-model="specsImage" v-model:previews="specsPreviews"
                                :mode="mode" :allowSelectOnPreview="true"
                                @previewRemoved="() => onPreviewRemoved('landing_specs_image')" />
                            <small class="text-muted d-block mt-1">Recommended: 600 × 600px square image</small>
                        </div>
                    </div>

                    <!-- Interactive Spec Groups Builder -->
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="font-weight-bold mb-0">Interactive Spec Groups (Scroll Image Swapper)</h6>
                            <button type="button" class="btn btn-sm btn-primary" @click="addSpecGroup">
                                <i class="fas fa-plus mr-1"></i> Add Spec Group
                            </button>
                        </div>

                        <div v-for="(group, gIdx) in formData.landing_specs_groups" :key="gIdx"
                            class="border rounded p-3 mb-4 bg-white shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                <h6 class="font-weight-bold text-dark mb-0">
                                    Group #{{ gIdx + 1 }}: {{ group.title || 'Untitled Group' }}
                                </h6>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    @click="removeSpecGroup(gIdx)">
                                    <i class="fas fa-trash-alt mr-1"></i> Remove Group
                                </button>
                            </div>

                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label>Group Tag</label>
                                    <input type="text" class="form-control" v-model="group.tag"
                                        placeholder="e.g. 01 / FILTRATION" />
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Group Title</label>
                                    <input type="text" class="form-control" v-model="group.title"
                                        placeholder="e.g. Multi-Stage Synthesis" />
                                </div>
                                <div class="col-md-5 form-group">
                                    <label>Dynamic Scroll Image</label>
                                    <Vue3Dropzone v-model="group.image_file"
                                        v-model:previews="group.image_previews"
                                        :mode="mode" :allowSelectOnPreview="true"
                                        @previewRemoved="() => { group.image = ''; }" />
                                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Recommended: 500 × 500px transparent PNG / WebP for 3D swap</small>
                                </div>
                            </div>

                            <!-- Spec Key-Value Table -->
                            <label class="font-weight-bold mt-2">Specification Rows:</label>
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 45%;">Specification Label</th>
                                        <th style="width: 45%;">Value</th>
                                        <th style="width: 10%; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, rIdx) in group.items" :key="rIdx">
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                v-model="item.label" placeholder="e.g. CADR (Smoke)" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                v-model="item.value" placeholder="e.g. 580 m³/h" />
                                        </td>
                                        <td class="text-center align-middle">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                @click="removeSpecRow(gIdx, rIdx)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                @click="addSpecRow(gIdx)">
                                                <i class="fas fa-plus mr-1"></i> Add Spec Row
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';

const heroImage = defineModel('heroImage', { default: null });
const heroPreviews = defineModel('heroPreviews', { default: () => [] });
const scienceImage = defineModel('scienceImage', { default: null });
const sciencePreviews = defineModel('sciencePreviews', { default: () => [] });
const lifestyleImage = defineModel('lifestyleImage', { default: null });
const lifestylePreviews = defineModel('lifestylePreviews', { default: () => [] });
const filterImage = defineModel('filterImage', { default: null });
const filterPreviews = defineModel('filterPreviews', { default: () => [] });
const specsImage = defineModel('specsImage', { default: null });
const specsPreviews = defineModel('specsPreviews', { default: () => [] });

const props = defineProps({
    modelValue: {
        type: Object,
        default: null
    },
    form: {
        type: Object,
        default: null
    },
    mode: {
        type: String,
        default: 'edit'
    },
    productId: {
        type: [String, Number],
        default: ''
    }
});

const emit = defineEmits([
    'previewRemoved',
    'scienceFeatureAdded',
    'scienceFeatureRemoved',
    'specGroupAdded',
    'specGroupRemoved',
    'specRowAdded',
    'specRowRemoved'
]);

const formData = computed(() => props.form || props.modelValue || {});

const onPreviewRemoved = (field) => {
    if (formData.value && formData.value[field] !== undefined) {
        formData.value[field] = '';
    }
    emit('previewRemoved', field);
};

const addScienceFeature = () => {
    if (!formData.value.landing_science_features) formData.value.landing_science_features = [];
    const item = { title: '', desc: '' };
    formData.value.landing_science_features.push(item);
    emit('scienceFeatureAdded', item);
};

const removeScienceFeature = (index) => {
    if (formData.value.landing_science_features) {
        formData.value.landing_science_features.splice(index, 1);
        emit('scienceFeatureRemoved', index);
    }
};

const addSpecGroup = () => {
    if (!formData.value.landing_specs_groups) formData.value.landing_specs_groups = [];
    const num = String(formData.value.landing_specs_groups.length + 1).padStart(2, '0');
    const group = {
        tag: `${num} / SPEC`,
        title: 'New Specification Group',
        image: '',
        image_file: null,
        image_previews: [],
        items: [{ label: '', value: '' }]
    };
    formData.value.landing_specs_groups.push(group);
    emit('specGroupAdded', group);
};

const removeSpecGroup = (index) => {
    if (formData.value.landing_specs_groups) {
        formData.value.landing_specs_groups.splice(index, 1);
        emit('specGroupRemoved', index);
    }
};

const addSpecRow = (groupIndex) => {
    if (formData.value.landing_specs_groups && formData.value.landing_specs_groups[groupIndex]) {
        if (!formData.value.landing_specs_groups[groupIndex].items) {
            formData.value.landing_specs_groups[groupIndex].items = [];
        }
        const item = { label: '', value: '' };
        formData.value.landing_specs_groups[groupIndex].items.push(item);
        emit('specRowAdded', { groupIndex, item });
    }
};

const removeSpecRow = (groupIndex, rowIndex) => {
    if (formData.value.landing_specs_groups && 
        formData.value.landing_specs_groups[groupIndex] && 
        formData.value.landing_specs_groups[groupIndex].items) {
        formData.value.landing_specs_groups[groupIndex].items.splice(rowIndex, 1);
        emit('specRowRemoved', { groupIndex, rowIndex });
    }
};
</script>
