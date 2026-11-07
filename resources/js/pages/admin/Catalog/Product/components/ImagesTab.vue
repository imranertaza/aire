<template>
    <div class="tab-pane fade" id="custom-tabs-images" role="tabpanel"
        aria-labelledby="tab-images">
        <div class="row">
            <div class="col-md-4 form-group">
                <label>Default Main Image <span class="text-danger">*</span></label>
                <Vue3Dropzone 
                    :key="dropzoneKey ? `main-dropzone-${dropzoneKey}` : undefined"
                    v-model="mainImage" 
                    v-model:previews="mainPreviews"
                    :mode="mode" 
                    :allowSelectOnPreview="true" 
                    :maxFileSize="10"
                    @previewRemoved="onMainPreviewRemoved" />
                <small class="text-muted d-block mt-1">Recommended: 800 × 800px or 1000 × 1000px (1:1 Square, clean/transparent background for interactive zoom)</small>
            </div>
            <div class="col-md-8 form-group">
                <label>Multiple Gallery Images</label>
                <Vue3Dropzone 
                    :key="dropzoneKey ? `gallery-dropzone-${dropzoneKey}` : undefined"
                    v-model="galleryImages" 
                    v-model:previews="galleryPreviews"
                    :mode="mode" 
                    :multiple="true" 
                    :allowSelectOnPreview="true" 
                    selectFileStrategy="merge" 
                    :maxFileSize="10"
                    @previewRemoved="onGalleryPreviewRemoved" />
                <small class="text-muted d-block mt-1">Recommended: 800 × 800px or 1000 × 1000px (1:1 Square, matching main image)</small>
            </div>
        </div>
    </div>
</template>

<script setup>
const mainImage = defineModel('mainImage', { default: null });
const galleryImages = defineModel('galleryImages', { default: null });
const mainPreviews = defineModel('mainPreviews', { default: () => [] });
const galleryPreviews = defineModel('galleryPreviews', { default: () => [] });

const props = defineProps({
    mode: {
        type: String,
        default: undefined
    },
    dropzoneKey: {
        type: [Number, String],
        default: ''
    }
});

const emit = defineEmits(['mainImageRemoved', 'galleryPreviewRemoved']);

const onMainPreviewRemoved = (preview) => {
    emit('mainImageRemoved', preview);
};

const onGalleryPreviewRemoved = (preview) => {
    emit('galleryPreviewRemoved', preview);
};
</script>
