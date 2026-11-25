<template>
    <div class="form-group section-image-uploader mb-3">
        <label v-if="label" class="font-weight-bold">
            {{ label }}
            <span v-if="required" class="text-danger">*</span>
        </label>

        <Vue3Dropzone
            v-model="fileList"
            v-model:previews="previews"
            mode="edit"
            :allowSelectOnPreview="true"
            :maxFiles="1"
        />

        <small v-if="recommendedSize" class="text-muted d-block mt-1">
            <i class="fas fa-info-circle mr-1"></i> Recommended: {{ recommendedSize }}
        </small>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import { getImageUrl } from '@/layouts/helpers/helpers';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    label: {
        type: String,
        default: 'Image',
    },
    placeholder: {
        type: String,
        default: '',
    },
    required: {
        type: Boolean,
        default: false,
    },
    recommendedSize: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['update:modelValue', 'fileChange']);

const fileList = ref([]);
const previews = ref([]);

// Keep dropzone previews in sync with modelValue (initial load and async fetch)
watch(
    () => props.modelValue,
    (newVal) => {
        if (!fileList.value || !fileList.value.length) {
            if (newVal && typeof newVal === 'string' && newVal.trim() !== '') {
                previews.value = [getImageUrl(newVal)];
            } else {
                previews.value = [];
            }
        }
    },
    { immediate: true }
);

// When user selects or drops a new file
watch(
    () => fileList.value,
    (newVal) => {
        const file = newVal?.[0]?.file || (newVal?.[0] instanceof File ? newVal[0] : null);
        emit('fileChange', file);
        // If file was removed and original modelValue still exists, restore original preview
        if (!file && props.modelValue) {
            previews.value = [getImageUrl(props.modelValue)];
        }
    },
    { deep: true }
);

// When user removes the preview inside Dropzone
watch(
    () => previews.value,
    (newPreviews) => {
        if ((!newPreviews || !newPreviews.length) && (!fileList.value || !fileList.value.length)) {
            emit('update:modelValue', '');
            emit('fileChange', null);
        }
    },
    { deep: true }
);
</script>
