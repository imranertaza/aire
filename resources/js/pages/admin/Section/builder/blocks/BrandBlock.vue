<template>
  <div
    :id="s.customId || undefined"
    class="block-render-brands"
    :class="[
      s.customClass,
      {
        'd-none d-md-block': s.hideMobile,
        'd-md-none d-lg-block': s.hideTablet,
        'd-lg-none': s.hideDesktop
      }
    ]"
    :style="wrapperStyles"
  >
    <!-- Editor Info Badge -->
    <div class="brand-grid-badge mb-3 d-flex align-items-center justify-content-between p-2 rounded-3 bg-light border">
      <div class="d-flex align-items-center small">
        <i class="fas fa-certificate text-success mr-2"></i>
        <strong class="text-dark mr-1">Dynamic Brand Partners:</strong>
        <span class="badge badge-success px-2 mr-2">Active Brands</span>
        <span class="text-muted small">({{ s.limit || 6 }} brands &bull; {{ s.columns_desktop || 'col-lg-2' }})</span>
      </div>
      <span class="badge badge-light border text-muted small"><i class="fas fa-handshake mr-1"></i> Live Brands</span>
    </div>

    <!-- Brands Grid Preview -->
    <div class="row g-3 align-items-center">
      <div
        v-for="(brand, idx) in previewBrands"
        :key="idx"
        class="col-md-3 mb-3 text-center"
        :class="[s.columns_mobile || 'col-4', s.columns_desktop || 'col-lg-2']"
      >
        <div
          class="p-2 d-flex align-items-center justify-content-center transition-all"
          :class="[
            s.boxed !== false ? (s.card_rounded || 'rounded-3') : '',
            s.boxed !== false ? (s.card_shadow || 'shadow-2xs') : '',
            s.boxed !== false ? 'border' : ''
          ]"
          :style="{
            backgroundColor: s.boxed !== false ? (s.card_bg || '#ffffff') : 'transparent',
            borderColor: s.card_border_color || undefined,
            height: s.card_height || '72px'
          }"
        >
          <div
            class="d-flex align-items-center justify-content-center w-100"
            :style="{
              filter: s.grayscale !== false ? 'grayscale(100%)' : 'none',
              opacity: s.grayscale !== false ? (s.opacity || '0.65') : '1'
            }"
          >
            <i class="fas fa-shield-alt text-primary mr-1" style="font-size: 1.1rem;"></i>
            <strong class="text-dark font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">{{ brand.name }}</strong>
          </div>
        </div>
      </div>
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

const mockBrands = [
  { name: 'PHILIPS' },
  { name: 'DYSON' },
  { name: 'XIAOMI' },
  { name: 'LEVOIT' },
  { name: 'BLUEAIR' },
  { name: 'HONEYWELL' },
  { name: 'SHARP' },
  { name: 'DAIKIN' }
];

const previewBrands = computed(() => {
  const l = parseInt(s.value.limit || 6, 10);
  const count = isNaN(l) || l < 1 ? 6 : Math.min(l, 8);
  return mockBrands.slice(0, count);
});

const wrapperStyles = computed(() => {
  const styles = {};
  if (s.value.marginTop) styles.marginTop = s.value.marginTop;
  if (s.value.marginBottom) styles.marginBottom = s.value.marginBottom;
  return styles;
});
</script>

<style scoped>
.shadow-2xs {
  box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
</style>

