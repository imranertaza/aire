<template>
  <div
    :id="s.custom_id || undefined"
    class="block-render-card h-100 transition-all"
    :class="[cardClasses, s.hoverEffect, s.marginTop, s.marginBottom, s.custom_class]"
    :style="cardStyles"
  >
    <!-- Accent: Number -->
    <div v-if="s.accentType === 'number' || (!s.accentType && s.number)" class="d-flex align-items-center justify-content-between mb-2">
      <span class="box-card-num font-weight-bold" :class="isDarkOrGlass ? 'text-white' : 'text-primary'" style="font-size: 1.5rem;">
        {{ s.number || '01' }}
      </span>
    </div>

    <!-- Accent: Badge -->
    <div v-else-if="s.accentType === 'badge' || (!s.accentType && s.badge)" class="mb-2">
      <span class="badge badge-primary px-2 py-1 font-weight-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">
        {{ s.badge }}
      </span>
    </div>

    <!-- Accent: Icon -->
    <div v-else-if="s.accentType === 'icon' && s.icon" class="mb-3">
      <div
        class="card-accent-icon-wrap rounded-circle d-inline-flex align-items-center justify-content-center"
        :class="isDarkOrGlass ? 'bg-white text-dark' : 'bg-primary text-white'"
        style="width: 44px; height: 44px; font-size: 1.15rem;"
      >
        <i :class="s.icon"></i>
      </div>
    </div>

    <!-- Card Title -->
    <h4
      class="font-weight-bold mb-2"
      :class="isDarkOrGlass ? 'text-white' : 'text-dark'"
      style="font-size: 1.1rem; letter-spacing: -0.3px;"
    >
      {{ s.title || 'Feature Card Title' }}
    </h4>

    <!-- Card Description -->
    <p
      class="small mb-0 opacity-90"
      :class="isDarkOrGlass ? 'text-light' : 'text-secondary'"
      style="line-height: 1.6;"
    >
      {{ s.description || 'Feature card description and supporting explanation goes here.' }}
    </p>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  block: {
    type: Object,
    required: true
  }
});

const s = computed(() => props.block.settings || {});

const isDarkOrGlass = computed(() => {
  return s.value.cardStylePreset === 'glass' || s.value.isGlass || s.value.cardStylePreset === 'dark';
});

const cardClasses = computed(() => {
  const pad = s.value.padding || 'p-4';
  const rad = s.value.rounded || 'rounded-4';
  const shad = s.value.shadow || 'shadow-sm';
  const preset = s.value.cardStylePreset || (s.value.isGlass ? 'glass' : 'white');

  if (preset === 'glass') {
    return `${rad} ${pad}`;
  }
  if (preset === 'dark') {
    return `bg-dark text-white border-0 ${rad} ${pad} ${shad}`;
  }
  if (preset === 'light') {
    return `bg-light text-dark border ${rad} ${pad}`;
  }
  if (preset === 'custom') {
    return `${rad} ${pad} ${shad}`;
  }
  return `bg-white border ${rad} ${pad} ${shad} text-dark`;
});

const cardStyles = computed(() => {
  const preset = s.value.cardStylePreset || (s.value.isGlass ? 'glass' : 'white');
  if (preset === 'glass') {
    return {
      background: 'rgba(255, 255, 255, 0.15)',
      backdropFilter: 'blur(14px)',
      WebkitBackdropFilter: 'blur(14px)',
      border: '1px solid rgba(255, 255, 255, 0.3)',
      boxShadow: '0 8px 32px rgba(0, 0, 0, 0.25)',
      color: '#ffffff'
    };
  }
  if (preset === 'custom') {
    return {
      backgroundColor: s.value.customBgColor || '#ffffff',
      borderColor: s.value.customBorderColor || '#e2e8f0',
      borderWidth: '1px',
      borderStyle: 'solid'
    };
  }
  return {};
});
</script>

<style scoped>
.hover-lift {
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.hover-lift:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12) !important;
}
.hover-glow:hover {
  box-shadow: 0 0 20px rgba(0, 149, 218, 0.35) !important;
}
</style>
