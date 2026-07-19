<template>
  <div class="dropzone-wrapper-container position-relative">
    <!-- If there are previews, show the view link overlaid in the top left -->
    <div v-if="previews && previews.length > 0 && previews[0]" class="dropzone-view-overlay"
      style="position: absolute; top: 10px; left: 10px; z-index: 10;">
      <a :href="previews[0]" target="_blank" class="btn btn-xs btn-info shadow-sm" title="View Current File"
        rel="noopener noreferrer">
        <i class="fas fa-eye"></i> View File
      </a>
    </div>

    <!-- The actual Vue3Dropzone component -->
    <Vue3Dropzone v-bind="$attrs" :model-value="modelValue" @update:model-value="val => $emit('update:modelValue', val)"
      :previews="previews" @update:previews="val => $emit('update:previews', val)" />
  </div>
</template>

<script setup>
import Vue3Dropzone from '../../../node_modules/@jaxtheprime/vue3-dropzone/dist/Vue3Dropzone.es.js';

const props = defineProps({
  modelValue: {
    type: [Array, Object, null],
    default: null
  },
  previews: {
    type: Array,
    default: () => []
  }
});

defineEmits(['update:modelValue', 'update:previews']);
</script>
