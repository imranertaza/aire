<template>
  <div
    :id="s.custom_id || undefined"
    class="block-render-button"
    :class="[alignClass, s.marginTop, s.marginBottom, s.custom_class]"
  >
    <button
      type="button"
      class="btn font-weight-bold d-inline-flex align-items-center justify-content-center"
      :class="[
        s.size || 'btn-md',
        s.customBgColor ? '' : (s.variant || 'btn-primary'),
        s.rounded || 'rounded-2',
        s.shadow || 'shadow-sm',
        s.hoverEffect,
        deviceMode === 'mobile' && s.fullWidthMobile ? 'w-100' : ''
      ]"
      :style="buttonStyles"
    >
      <!-- Icon Left -->
      <i v-if="s.icon && s.iconPos === 'left'" :class="[s.icon, 'mr-2 small']"></i>
      <span>{{ s.text || 'Action Button' }}</span>
      <!-- Icon Right (Default) -->
      <i v-if="s.icon && (s.iconPos || 'right') === 'right'" :class="[s.icon, 'ml-2 small']"></i>
    </button>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  block: {
    type: Object,
    required: true
  },
  deviceMode: {
    type: String,
    default: 'desktop'
  }
});

const s = computed(() => props.block.settings || {});

const alignClass = computed(() => {
  const a = s.value.align;
  if (!a) return 'text-left';
  if (typeof a === 'string') return a === 'text-start' ? 'text-left' : (a === 'text-end' ? 'text-right' : a);
  const raw = props.deviceMode === 'mobile' ? (a.mobile || 'text-center') : (a.desktop || 'text-left');
  if (raw === 'text-start') return 'text-left';
  if (raw === 'text-end') return 'text-right';
  return raw;
});

const buttonStyles = computed(() => {
  const styles = {};
  if (s.value.customBgColor) {
    styles.backgroundColor = s.value.customBgColor;
    styles.borderColor = s.value.customBgColor;
  }
  if (s.value.customTextColor) {
    styles.color = s.value.customTextColor;
  }
  return styles;
});
</script>

<style scoped>
.hover-lift {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15) !important;
}
</style>
