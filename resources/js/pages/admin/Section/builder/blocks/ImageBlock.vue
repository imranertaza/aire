<template>
  <div
    :id="s.custom_id || undefined"
    class="block-render-image"
    :class="[s.align || 'text-center', s.marginTop, s.marginBottom, s.custom_class]"
  >
    <div
      v-if="s.url"
      class="position-relative d-inline-block"
      :class="[s.fullWidth ? 'w-100' : '', s.hoverEffect]"
      :style="{ maxWidth: s.maxWidth || '100%' }"
    >
      <img
        :src="imageUrl"
        :alt="s.alt || ''"
        class="img-fluid"
        :class="[s.rounded || 'rounded-3', s.shadow || '']"
        :style="imageStyles"
      />
      <div v-if="s.caption" class="small text-muted mt-2 text-center">{{ s.caption }}</div>
    </div>
    <div v-else class="p-5 border-2 border-dashed rounded-3 text-center bg-light text-muted">
      <i class="fas fa-image fa-2x mb-2 text-primary opacity-50"></i>
      <div class="font-weight-bold small">No Image Selected</div>
      <div class="small">Add an image URL or upload from the Inspector panel</div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { getImageUrl } from '@/layouts/helpers/helpers';

const props = defineProps({
  block: {
    type: Object,
    required: true
  }
});

const s = computed(() => props.block.settings || {});

const imageUrl = computed(() => {
  if (!s.value.url) return '';
  return getImageUrl(s.value.url);
});

const imageStyles = computed(() => {
  const styles = {
    maxHeight: '520px',
    width: s.value.fullWidth ? '100%' : 'auto',
    objectFit: s.value.objectFit || 'cover'
  };
  if (s.value.aspectRatio && s.value.aspectRatio !== 'auto') {
    styles.aspectRatio = s.value.aspectRatio;
  }
  return styles;
});
</script>

<style scoped>
.border-dashed {
  border: 2px dashed #cbd5e1 !important;
}
.hover-lift {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
  transform: translateY(-4px);
}
.hover-zoom img {
  transition: transform 0.3s ease;
}
.hover-zoom:hover img {
  transform: scale(1.03);
}
.hover-glow {
  transition: filter 0.2s ease;
}
.hover-glow:hover {
  filter: drop-shadow(0 10px 20px rgba(0, 149, 218, 0.25));
}
</style>
