<template>
  <div
    :id="s.custom_id || undefined"
    class="block-render-spacer"
    :class="[s.marginTop, s.marginBottom, s.custom_class]"
  >
    <hr
      v-if="s.isDivider"
      class="my-3"
      :style="{
        borderTopStyle: s.dividerStyle || 'solid',
        borderTopWidth: '1px',
        borderTopColor: 'rgba(0, 0, 0, 0.12)'
      }"
    />
    <div
      v-else
      :style="{ height: s.height || '32px' }"
      class="d-flex align-items-center justify-content-center border-dashed rounded text-muted small bg-light"
      style="opacity: 0.7;"
    >
      <i class="fas fa-arrows-alt-v mr-1"></i> Spacer ({{ s.height || '32px' }})
    </div>
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
</script>

<style scoped>
.border-dashed {
  border: 1px dashed #cbd5e1;
}
</style>
