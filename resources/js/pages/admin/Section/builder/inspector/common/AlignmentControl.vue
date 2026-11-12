<template>
  <div class="mb-3">
    <div class="d-flex align-items-center justify-content-between mb-1">
      <label class="form-label small font-weight-bold text-secondary mb-0">
        <span>Alignment ({{ scopeMode }})</span>
      </label>
      <span class="badge badge-secondary">{{ scopeMode }}</span>
    </div>
    <div class="btn-group w-100 btn-group-sm" role="group">
      <button
        type="button"
        class="btn"
        :class="currentAlign === 'text-start' ? 'btn-primary' : 'btn-outline-secondary'"
        @click="setAlign('text-start')"
      >
        <i class="fas fa-align-left"></i> Left
      </button>
      <button
        type="button"
        class="btn"
        :class="currentAlign === 'text-center' ? 'btn-primary' : 'btn-outline-secondary'"
        @click="setAlign('text-center')"
      >
        <i class="fas fa-align-center"></i> Center
      </button>
      <button
        type="button"
        class="btn"
        :class="currentAlign === 'text-end' ? 'btn-primary' : 'btn-outline-secondary'"
        @click="setAlign('text-end')"
      >
        <i class="fas fa-align-right"></i> Right
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  settings: {
    type: Object,
    required: true
  },
  scopeMode: {
    type: String,
    default: 'desktop'
  }
});

const currentAlign = computed(() => {
  if (!props.settings.align) {
    props.settings.align = { desktop: 'text-start', mobile: 'text-center' };
  }
  if (typeof props.settings.align === 'string') {
    return props.settings.align;
  }
  return props.settings.align[props.scopeMode] || 'text-start';
});

function setAlign(val) {
  if (typeof props.settings.align !== 'object' || props.settings.align === null) {
    props.settings.align = { desktop: props.settings.align || 'text-start', mobile: 'text-center' };
  }
  props.settings.align[props.scopeMode] = val;
}
</script>
