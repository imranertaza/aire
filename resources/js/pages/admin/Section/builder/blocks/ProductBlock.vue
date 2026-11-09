<template>
  <div
    :id="s.customId || undefined"
    class="block-render-products"
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
    <!-- Dynamic Source Info Bar in Editor -->
    <div class="product-grid-badge mb-3 d-flex align-items-center justify-content-between p-2 rounded-3 bg-light border">
      <div class="d-flex align-items-center small">
        <i class="fas fa-shopping-bag text-primary mr-2"></i>
        <strong class="text-dark mr-1">Dynamic Product Catalog:</strong>
        <span class="badge badge-primary text-capitalize px-2 mr-2">{{ s.source || 'latest' }}</span>
        <span class="text-muted small">({{ s.limit || 4 }} items &bull; {{ s.columns_desktop || 'col-lg-3' }})</span>
      </div>
      <span class="badge badge-light border text-muted small"><i class="fas fa-sync-alt mr-1"></i> Live DB Source</span>
    </div>

    <!-- Product Grid Preview -->
    <div class="row g-3">
      <div
        v-for="idx in previewCount"
        :key="idx"
        class="col-md-6 mb-3 d-flex"
        :class="[s.columns_mobile || 'col-6', s.columns_desktop || 'col-lg-3']"
      >
        <div class="mockup-product-card card border rounded-3 p-2 bg-white w-100 shadow-2xs position-relative">
          <!-- Mock Badge -->
          <span v-if="s.show_badge !== false" class="badge badge-primary position-absolute font-weight-bold" style="top: 8px; left: 8px; font-size: 0.65rem;">
            {{ idx === 1 ? 'FEATURED' : 'AIR PRO' }}
          </span>

          <!-- Mock Image Container -->
          <div class="mockup-prod-img bg-light rounded-2 d-flex align-items-center justify-content-center mb-2" style="height: 140px;">
            <i class="fas fa-wind fa-2x text-primary opacity-50"></i>
          </div>

          <!-- Mock Info -->
          <div class="p-1 flex-grow-1 d-flex flex-column">
            <span class="text-muted text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">HEPA Purifier</span>
            <h6 class="font-weight-bold text-dark mb-1 text-truncate" style="font-size: 0.85rem;">
              {{ idx === 1 ? 'Aire Pure Pro Max' : (idx === 2 ? 'Aire Living Ultra' : 'Aire Slim Compact') }}
            </h6>

            <!-- Rating Stars -->
            <div class="text-warning small mb-2" style="font-size: 0.7rem;">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
            </div>

            <!-- Price & Button -->
            <div class="mt-auto d-flex align-items-center justify-content-between pt-2 border-top">
              <span v-if="s.show_price !== false" class="font-weight-bold text-dark" style="font-size: 0.9rem;">
                $349.00
              </span>
              <button
                v-if="s.show_action_buttons !== false"
                type="button"
                class="btn btn-xs btn-primary px-2 py-1 rounded-pill font-weight-bold"
                style="font-size: 0.7rem;"
              >
                <i class="fas fa-cart-plus mr-1"></i> Add
              </button>
            </div>
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

const s = computed(() => props.block.settings || props.block);

const previewCount = computed(() => {
  const limit = parseInt(s.value.limit, 10);
  return isNaN(limit) || limit <= 0 ? 4 : Math.min(limit, 8);
});

const wrapperStyles = computed(() => {
  const styles = {};
  if (s.value.marginTop) styles.marginTop = s.value.marginTop;
  if (s.value.marginBottom) styles.marginBottom = s.value.marginBottom;
  return styles;
});
</script>

<style scoped>
.mockup-product-card {
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.mockup-product-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}
.shadow-2xs {
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}
.g-3 {
  margin-left: -8px;
  margin-right: -8px;
}
.g-3 > [class*="col"] {
  padding-left: 8px;
  padding-right: 8px;
}
</style>
