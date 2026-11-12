<template>
  <div class="mb-3">
    <label v-if="label" class="form-label small font-weight-bold text-secondary mb-1">{{ label }}</label>
    <div class="d-flex align-items-center mb-1">
      <input
        type="color"
        class="form-control form-control-color mr-2"
        :value="modelValue || defaultPickerColor"
        @input="$emit('update:modelValue', $event.target.value)"
        style="width: 42px; height: 31px;"
      />
      <input
        type="text"
        class="form-control form-control-sm font-monospace"
        :value="modelValue"
        :placeholder="placeholder"
        @input="$emit('update:modelValue', $event.target.value)"
      />
      <button
        v-if="modelValue"
        type="button"
        class="btn btn-sm btn-light border ml-1 px-2"
        @click="$emit('update:modelValue', '')"
        title="Reset"
      >
        <i class="fas fa-times text-muted"></i>
      </button>
    </div>
    <div class="color-swatches-row mt-1">
      <button
        v-for="swatch in brandSwatches"
        :key="swatch"
        type="button"
        class="color-swatch-dot border"
        :style="{ backgroundColor: swatch }"
        :title="swatch"
        @click="$emit('update:modelValue', swatch)"
      ></button>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  label: {
    type: String,
    default: ''
  },
  modelValue: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: '#000000'
  },
  defaultPickerColor: {
    type: String,
    default: '#000000'
  }
});

defineEmits(['update:modelValue']);

const brandSwatches = [
  '#0095DA',
  '#0D1B2A',
  '#1E293B',
  '#64748B',
  '#10B981',
  '#EF4444',
  '#F59E0B',
  '#F8FAFC',
  '#FFFFFF'
];
</script>

<style scoped>
.form-control-color {
  height: 31px;
}
.color-swatches-row {
  display: flex;
  flex-wrap: wrap;
  gap: 4px;
}
.color-swatch-dot {
  width: 18px;
  height: 18px;
  border-radius: 4px;
  padding: 0;
  cursor: pointer;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.color-swatch-dot:hover {
  transform: scale(1.25);
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
  z-index: 2;
}
</style>
