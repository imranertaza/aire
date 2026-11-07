<template>
    <div class="tab-pane fade" id="custom-tabs-features" role="tabpanel"
        aria-labelledby="tab-features">
        <div class="card card-outline card-primary mb-3">
            <div class="card-header py-2">
                <h6 class="card-title font-weight-bold mb-0">Header & Parallax Banner (Section 3)</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Badge / Tag</label>
                        <input type="text" class="form-control" v-model="formData.features_badge"
                            placeholder="e.g. FEATURES" />
                    </div>
                    <div class="col-md-8 form-group">
                        <label>Main Title</label>
                        <input type="text" class="form-control" v-model="formData.features_title"
                            placeholder="e.g. Precision Engineered Details" />
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Main Description</label>
                        <textarea class="form-control" rows="2" v-model="formData.features_description"
                            placeholder="The product is a masterclass in industrial design..."></textarea>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Features Parallax Background Image</label>
                        <Vue3Dropzone 
                            v-model="featuresImage"
                            v-model:previews="featuresPreviews"
                            :mode="mode"
                            :allowSelectOnPreview="true"
                            @previewRemoved="onPreviewRemoved" />
                        <small class="text-muted d-block mt-1">Recommended: 1400 × 600px or 1200 × 500px (Panoramic wide banner)</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-outline card-secondary mb-3">
            <div class="card-header py-2">
                <h6 class="card-title font-weight-bold mb-0">3-Column Glassmorphism Feature Cards</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Card 01 -->
                    <div class="col-md-4 border-right">
                        <h6 class="font-weight-bold text-primary mb-2">Card 01</h6>
                        <div class="form-group">
                            <label>Icon Class (e.g. bi bi-shield-lock)</label>
                            <input type="text" class="form-control" v-model="formData.feature1_icon"
                                placeholder="bi bi-shield-lock" />
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" v-model="formData.feature1_title"
                                placeholder="e.g. Medical-Grade Facial Seal" />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="3" v-model="formData.feature1_desc"
                                placeholder="Hypoallergenic LSR silicone ensures..."></textarea>
                        </div>
                    </div>

                    <!-- Card 02 -->
                    <div class="col-md-4 border-right">
                        <h6 class="font-weight-bold text-primary mb-2">Card 02</h6>
                        <div class="form-group">
                            <label>Icon Class (e.g. bi bi-lightbulb)</label>
                            <input type="text" class="form-control" v-model="formData.feature2_icon"
                                placeholder="bi bi-lightbulb" />
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" v-model="formData.feature2_title"
                                placeholder="e.g. Active Feedback Ring" />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="3" v-model="formData.feature2_desc"
                                placeholder="Integrated LED halo provides..."></textarea>
                        </div>
                    </div>

                    <!-- Card 03 -->
                    <div class="col-md-4">
                        <h6 class="font-weight-bold text-primary mb-2">Card 03</h6>
                        <div class="form-group">
                            <label>Icon Class (e.g. bi bi-funnel)</label>
                            <input type="text" class="form-control" v-model="formData.feature3_icon"
                                placeholder="bi bi-funnel" />
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" v-model="formData.feature3_title"
                                placeholder="e.g. Advanced HEPA Filtration" />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="3" v-model="formData.feature3_desc"
                                placeholder="Dual H13 Industrial filters capture..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const featuresImage = defineModel('featuresImage', { default: null });
const featuresPreviews = defineModel('featuresPreviews', { default: () => [] });

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
