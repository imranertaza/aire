<template>
    <div class="tab-pane fade" id="custom-tabs-others" role="tabpanel"
        aria-labelledby="tab-others">
        <div class="row">
            <div class="col-md-12 form-group">
                <label>Video Embedded Code</label>
                <input type="text" class="form-control" v-model="formData.video"
                    placeholder="Video code" />
            </div>
            <div class="col-md-6 form-group">
                <label>Documentation Pdf</label>
                <Vue3Dropzone 
                    v-model="docPdf" 
                    v-model:previews="docPdfPreviews" 
                    :mode="mode" 
                    :allowSelectOnPreview="true" 
                    @previewRemoved="() => onPreviewRemoved('documentation_pdf')" 
                />
            </div>
            <div class="col-md-6 form-group">
                <label>Safety Pdf</label>
                <Vue3Dropzone 
                    v-model="safetyPdf" 
                    v-model:previews="safetyPdfPreviews" 
                    :mode="mode" 
                    :allowSelectOnPreview="true" 
                    @previewRemoved="() => onPreviewRemoved('safety_pdf')" 
                />
            </div>
            <div class="col-md-6 form-group">
                <label>Instructions Pdf</label>
                <Vue3Dropzone 
                    v-model="instPdf" 
                    v-model:previews="instPdfPreviews" 
                    :mode="mode" 
                    :allowSelectOnPreview="true" 
                    @previewRemoved="() => onPreviewRemoved('instructions_pdf')" 
                />
            </div>
            <div class="col-md-6 form-group">
                <label>Description Image</label>
                <Vue3Dropzone 
                    v-model="descImage" 
                    v-model:previews="descImagePreviews" 
                    :mode="mode" 
                    :allowSelectOnPreview="true" 
                    @previewRemoved="() => onPreviewRemoved('description_image')" 
                />
                <small class="text-muted d-block mt-1">Recommended: 800 × 600px or 1200 × 800px</small>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';

const docPdf = defineModel('docPdf', { default: null });
const docPdfPreviews = defineModel('docPdfPreviews', { default: () => [] });
const safetyPdf = defineModel('safetyPdf', { default: null });
const safetyPdfPreviews = defineModel('safetyPdfPreviews', { default: () => [] });
const instPdf = defineModel('instPdf', { default: null });
const instPdfPreviews = defineModel('instPdfPreviews', { default: () => [] });
const descImage = defineModel('descImage', { default: null });
const descImagePreviews = defineModel('descImagePreviews', { default: () => [] });

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

const onPreviewRemoved = (field) => {
    emit('previewRemoved', field);
};
</script>
