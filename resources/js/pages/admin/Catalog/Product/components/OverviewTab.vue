<template>
    <div class="tab-pane fade" id="custom-tabs-overview" role="tabpanel"
        aria-labelledby="tab-overview">
        <div class="card card-outline card-primary mb-3">
            <div class="card-header py-2">
                <h6 class="card-title font-weight-bold mb-0">Overview Banner & Narrative (Section 1)</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Overview Title</label>
                        <input type="text" class="form-control" v-model="formData.overview_title"
                            placeholder="e.g. Versatility Without Compromise" />
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Overview Narrative / Description</label>
                        <textarea class="form-control" rows="3" v-model="formData.overview_description"
                            placeholder="Detailed narrative description for the overview section..."></textarea>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Overview Banner / Parallax Image</label>
                        <Vue3Dropzone 
                            v-model="overviewImage"
                            v-model:previews="overviewPreviews"
                            :mode="mode"
                            :allowSelectOnPreview="true"
                            @previewRemoved="onPreviewRemoved" />
                        <small class="text-muted d-block mt-1">Recommended: 800 × 600px or 1000 × 700px (Landscape ~4:3)</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-outline card-secondary mb-3">
            <div class="card-header py-2">
                <h6 class="card-title font-weight-bold mb-0">Overview Feature Cards (Section 1)</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Feature Card 1 -->
                    <div class="col-md-6 border-right pr-md-4">
                        <h6 class="font-weight-bold text-primary mb-3"><i class="bi bi-shield-check mr-1"></i> Feature Card 01</h6>
                        <div class="form-group">
                            <label>Card 1 Icon (Bootstrap Icon Class)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i :class="formData.overview_feature1_icon || 'bi bi-shield-check'"></i></span>
                                </div>
                                <input type="text" class="form-control" v-model="formData.overview_feature1_icon" placeholder="bi bi-shield-check" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Card 1 Title</label>
                            <input type="text" class="form-control" v-model="formData.overview_feature1_title" placeholder="e.g. CRITICAL ENVIRONMENTS" />
                        </div>
                        <div class="form-group">
                            <label>Card 1 Description</label>
                            <textarea class="form-control" rows="3" v-model="formData.overview_feature1_desc" placeholder="e.g. Engineered for cleanrooms, laboratories, and precision fabrication facilities."></textarea>
                        </div>
                    </div>

                    <!-- Feature Card 2 -->
                    <div class="col-md-6 pl-md-4">
                        <h6 class="font-weight-bold text-primary mb-3"><i class="bi bi-buildings mr-1"></i> Feature Card 02</h6>
                        <div class="form-group">
                            <label>Card 2 Icon (Bootstrap Icon Class)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i :class="formData.overview_feature2_icon || 'bi bi-buildings'"></i></span>
                                </div>
                                <input type="text" class="form-control" v-model="formData.overview_feature2_icon" placeholder="bi bi-buildings" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Card 2 Title</label>
                            <input type="text" class="form-control" v-model="formData.overview_feature2_title" placeholder="e.g. URBAN RESILIENCE" />
                        </div>
                        <div class="form-group">
                            <label>Card 2 Description</label>
                            <textarea class="form-control" rows="3" v-model="formData.overview_feature2_desc" placeholder="e.g. Protection against high-density metropolitan particulate and allergens."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const overviewImage = defineModel('overviewImage', { default: null });
const overviewPreviews = defineModel('overviewPreviews', { default: () => [] });

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
        default: undefined
    }
});

const emit = defineEmits(['previewRemoved']);

const formData = computed(() => props.form || props.modelValue || {});

const onPreviewRemoved = (preview) => {
    emit('previewRemoved', preview);
};
</script>
