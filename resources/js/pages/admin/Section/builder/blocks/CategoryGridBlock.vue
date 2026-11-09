<template>
  <div
    :id="s.customId || undefined"
    class="block-render-categories"
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
    <div class="category-grid-badge mb-3 d-flex align-items-center justify-content-between p-2 rounded-3 bg-light border">
      <div class="d-flex align-items-center small">
        <i class="fas fa-th-large text-warning mr-2"></i>
        <strong class="text-dark mr-1">Dynamic Product Categories:</strong>
        <span class="badge badge-warning px-2 mr-2">Top Categories</span>
        <span class="text-muted small">({{ s.limit || 6 }} categories &bull; {{ s.columns_desktop || 'col-lg-2' }})</span>
      </div>
      <span class="badge badge-light border text-muted small"><i class="fas fa-layer-group mr-1"></i> Live Categories</span>
    </div>

    <!-- Category Grid Preview -->
    <div class="row g-3">
      <div
        v-for="(cat, idx) in previewCategories"
        :key="idx"
        class="col-md-4 mb-3 d-flex"
        :class="[s.columns_mobile || 'col-6', s.columns_desktop || 'col-lg-2']"
      >
        <div class="card border-0 rounded-4 p-3 text-center w-100 shadow-2xs d-flex flex-column align-items-center" style="background-color: #f8fafc;">
          <div class="rounded-circle bg-white d-flex align-items-center justify-content-center shadow-2xs mb-2" style="width: 58px; height: 58px;">
            <i :class="cat.icon" class="text-primary" style="font-size: 1.3rem;"></i>
          </div>
          <span class="font-weight-bold text-dark text-truncate w-100" style="font-size: 0.82rem;">
            {{ cat.name }}
          </span>
          <span v-if="s.show_count !== false" class="text-muted small mt-1" style="font-size: 0.7rem;">
            {{ cat.count }} Products
          </span>
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

const mockCats = [
  { name: 'Air Purifiers', icon: 'fas fa-wind', count: 18 },
  { name: 'HEPA Filters', icon: 'fas fa-filter', count: 12 },
  { name: 'Air Monitors', icon: 'fas fa-chart-line', count: 6 },
  { name: 'Dehumidifiers', icon: 'fas fa-tint', count: 9 },
  { name: 'Masks & PPE', icon: 'fas fa-head-side-mask', count: 14 },
  { name: 'Smart IoT Sensors', icon: 'fas fa-wifi', count: 8 },
  { name: 'Commercial Units', icon: 'fas fa-building', count: 5 },
  { name: 'Accessories', icon: 'fas fa-tools', count: 11 }
];

const previewCategories = computed(() => {
  const l = parseInt(s.value.limit || 6, 10);
  const count = isNaN(l) || l < 1 ? 6 : Math.min(l, 8);
  return mockCats.slice(0, count);
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

