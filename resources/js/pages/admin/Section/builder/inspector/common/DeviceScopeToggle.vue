<template>
  <div class="mb-3 p-2 bg-light rounded-3 d-flex align-items-center justify-content-between border">
    <div class="small font-weight-bold text-muted">
      <i class="fas fa-sliders-h mr-1 text-primary"></i> Device Scope:
    </div>
    <div class="btn-group btn-group-sm" role="group">
      <button
        type="button"
        class="btn px-2 py-1"
        :class="modelValue === 'desktop' ? 'btn-primary' : 'btn-outline-secondary'"
        @click="$emit('update:modelValue', 'desktop')"
        title="Desktop Settings"
      >
        <i class="fas fa-desktop mr-1"></i> Desktop
      </button>
      <button
        type="button"
        class="btn px-2 py-1"
        :class="modelValue === 'mobile' ? 'btn-primary' : 'btn-outline-secondary'"
        @click="$emit('update:modelValue', 'mobile')"
        title="Mobile Settings"
      >
        <i class="fas fa-mobile-alt mr-1"></i> Mobile
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  modelValue: {
    type: String,
    default: 'desktop'
  }
});

defineEmits(['update:modelValue']);
</script>
