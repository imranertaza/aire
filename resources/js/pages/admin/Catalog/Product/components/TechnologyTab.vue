<template>
    <div class="tab-pane fade" id="custom-tabs-technology" role="tabpanel"
        aria-labelledby="tab-technology">
        <div class="card card-outline card-primary mb-3">
            <div class="card-header py-2">
                <h6 class="card-title font-weight-bold mb-0">Header & Parallax Banner</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Badge / Tag</label>
                        <input type="text" class="form-control" v-model="formData.technology_badge"
                            placeholder="e.g. TECHNOLOGY" />
                    </div>
                    <div class="col-md-8 form-group">
                        <label>Main Title</label>
                        <input type="text" class="form-control" v-model="formData.technology_title"
                            placeholder="e.g. The Physics of Pure Air" />
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Main Description</label>
                        <textarea class="form-control" rows="2" v-model="formData.technology_description"
                            placeholder="Beyond simple filtration..."></textarea>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Technology Parallax Background Image</label>
                        <Vue3Dropzone 
                            v-model="technologyImage"
                            v-model:previews="technologyPreviews"
                            :mode="mode"
                            :allowSelectOnPreview="true"
                            @previewRemoved="onPreviewRemoved" />
                        <small class="text-muted d-block mt-1">Recommended: 1400 × 700px or 1200 × 600px (Wide landscape banner)</small>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Parallax Glassmorphism Card Title</label>
                            <input type="text" class="form-control" v-model="formData.technology_card_title"
                                placeholder="e.g. ACTIVE POSITIVE PRESSURE" />
                        </div>
                        <div class="form-group">
                            <label>Parallax Glassmorphism Card Description</label>
                            <textarea class="form-control" rows="2" v-model="formData.technology_card_description"
                                placeholder="Smart sensors detect inhalation resistance..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-outline card-secondary mb-3">
            <div class="card-header py-2">
                <h6 class="card-title font-weight-bold mb-0">3-Column Numbered Features Grid</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- 01 Feature -->
                    <div class="col-md-4 border-right">
                        <h6 class="font-weight-bold text-primary mb-2">01 Feature</h6>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" v-model="formData.tech_feature1_title"
                                placeholder="e.g. TURBULENT FLOW CONTROL" />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="2" v-model="formData.tech_feature1_desc"
                                placeholder="Internal ducting is modeled using..."></textarea>
                        </div>
                    </div>

                    <!-- 02 Feature -->
                    <div class="col-md-4 border-right">
                        <h6 class="font-weight-bold text-primary mb-2">02 Feature</h6>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" v-model="formData.tech_feature2_title"
                                placeholder="e.g. PARTICULATE SENSING" />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="2" v-model="formData.tech_feature2_desc"
                                placeholder="Integrated laser-based sensors scan..."></textarea>
                        </div>
                    </div>

                    <!-- 03 Feature -->
                    <div class="col-md-4">
                        <h6 class="font-weight-bold text-primary mb-2">03 Feature</h6>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" v-model="formData.tech_feature3_title"
                                placeholder="e.g. BIO-MECHANICAL FIT" />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="2" v-model="formData.tech_feature3_desc"
                                placeholder="The structural chassis is crafted from..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const technologyImage = defineModel('technologyImage', { default: null });
const technologyPreviews = defineModel('technologyPreviews', { default: () => [] });

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
