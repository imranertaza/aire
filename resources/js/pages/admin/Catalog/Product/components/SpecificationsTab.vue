<template>
    <div class="tab-pane fade" id="custom-tabs-specifications" role="tabpanel"
        aria-labelledby="tab-specifications">
        <div class="card card-outline card-primary mb-3">
            <div class="card-header py-2">
                <h6 class="card-title font-weight-bold mb-0">Header & Exploded Technical Banner (Section 2)</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Badge / Tag</label>
                        <input type="text" class="form-control" v-model="formData.specs_badge"
                            placeholder="e.g. SPECIFICATIONS" />
                    </div>
                    <div class="col-md-8 form-group">
                        <label>Main Title</label>
                        <input type="text" class="form-control" v-model="formData.specs_title"
                            placeholder="e.g. Technical Specifications" />
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Main Description</label>
                        <textarea class="form-control" rows="2" v-model="formData.specs_description"
                            placeholder="Laboratory-validated performance metrics..."></textarea>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Exploded View Parallax Background Image</label>
                        <Vue3Dropzone 
                            v-model="specsImage"
                            v-model:previews="specsPreviews"
                            :mode="mode"
                            :allowSelectOnPreview="true"
                            @previewRemoved="onPreviewRemoved" />
                        <small class="text-muted d-block mt-1">Recommended: 1200 × 600px or 1024 × 686px (Technical diagram / exploded view)</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-outline card-secondary mb-3">
            <div class="card-header py-2">
                <h6 class="card-title font-weight-bold mb-0">4-Column Stats Grid (Section 2)</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Stat 1 -->
                    <div class="col-md-3 border-right">
                        <h6 class="font-weight-bold text-primary mb-2">Stat 01</h6>
                        <div class="form-group">
                            <label>Icon Class</label>
                            <input type="text" class="form-control" v-model="formData.spec1_icon" placeholder="bi bi-shield-check" />
                        </div>
                        <div class="form-group">
                            <label>Badge / Top Label</label>
                            <input type="text" class="form-control" v-model="formData.spec1_badge" placeholder="e.g. FILTRATION" />
                        </div>
                        <div class="form-group">
                            <label>Value</label>
                            <input type="text" class="form-control" v-model="formData.spec1_value" placeholder="e.g. 99.97%" />
                        </div>
                        <div class="form-group">
                            <label>Unit Suffix</label>
                            <input type="text" class="form-control" v-model="formData.spec1_unit" placeholder="e.g. %" />
                        </div>
                        <div class="form-group">
                            <label>Bottom Description</label>
                            <input type="text" class="form-control" v-model="formData.spec1_desc" placeholder="e.g. @ 0.3MM EFFICIENCY" />
                        </div>
                    </div>

                    <!-- Stat 2 -->
                    <div class="col-md-3 border-right">
                        <h6 class="font-weight-bold text-primary mb-2">Stat 02</h6>
                        <div class="form-group">
                            <label>Icon Class</label>
                            <input type="text" class="form-control" v-model="formData.spec2_icon" placeholder="bi bi-wind" />
                        </div>
                        <div class="form-group">
                            <label>Badge / Top Label</label>
                            <input type="text" class="form-control" v-model="formData.spec2_badge" placeholder="e.g. VELOCITY" />
                        </div>
                        <div class="form-group">
                            <label>Value</label>
                            <input type="text" class="form-control" v-model="formData.spec2_value" placeholder="e.g. 4.2" />
                        </div>
                        <div class="form-group">
                            <label>Unit Suffix</label>
                            <input type="text" class="form-control" v-model="formData.spec2_unit" placeholder="e.g. L/sec" />
                        </div>
                        <div class="form-group">
                            <label>Bottom Description</label>
                            <input type="text" class="form-control" v-model="formData.spec2_desc" placeholder="e.g. MAX AIRFLOW RATE" />
                        </div>
                    </div>

                    <!-- Stat 3 -->
                    <div class="col-md-3 border-right">
                        <h6 class="font-weight-bold text-primary mb-2">Stat 03</h6>
                        <div class="form-group">
                            <label>Icon Class</label>
                            <input type="text" class="form-control" v-model="formData.spec3_icon" placeholder="bi bi-battery-charging" />
                        </div>
                        <div class="form-group">
                            <label>Badge / Top Label</label>
                            <input type="text" class="form-control" v-model="formData.spec3_badge" placeholder="e.g. ENDURANCE" />
                        </div>
                        <div class="form-group">
                            <label>Value</label>
                            <input type="text" class="form-control" v-model="formData.spec3_value" placeholder="e.g. 12" />
                        </div>
                        <div class="form-group">
                            <label>Unit Suffix</label>
                            <input type="text" class="form-control" v-model="formData.spec3_unit" placeholder="e.g. Hours" />
                        </div>
                        <div class="form-group">
                            <label>Bottom Description</label>
                            <input type="text" class="form-control" v-model="formData.spec3_desc" placeholder="e.g. CONTINUOUS OPERATION" />
                        </div>
                    </div>

                    <!-- Stat 4 -->
                    <div class="col-md-3">
                        <h6 class="font-weight-bold text-primary mb-2">Stat 04</h6>
                        <div class="form-group">
                            <label>Icon Class</label>
                            <input type="text" class="form-control" v-model="formData.spec4_icon" placeholder="bi bi-box-seam" />
                        </div>
                        <div class="form-group">
                            <label>Badge / Top Label</label>
                            <input type="text" class="form-control" v-model="formData.spec4_badge" placeholder="e.g. MASS" />
                        </div>
                        <div class="form-group">
                            <label>Value</label>
                            <input type="text" class="form-control" v-model="formData.spec4_value" placeholder="e.g. 185" />
                        </div>
                        <div class="form-group">
                            <label>Unit Suffix</label>
                            <input type="text" class="form-control" v-model="formData.spec4_unit" placeholder="e.g. Grams" />
                        </div>
                        <div class="form-group">
                            <label>Bottom Description</label>
                            <input type="text" class="form-control" v-model="formData.spec4_desc" placeholder="e.g. TOTAL SYSTEM WEIGHT" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

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
        default: undefined
    }
});

const emit = defineEmits(['previewRemoved']);

const formData = computed(() => props.form || props.modelValue || {});

const onPreviewRemoved = (preview) => {
    emit('previewRemoved', preview);
};
</script>
