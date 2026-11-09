<template>
  <div
    :id="s.customId || undefined"
    class="block-render-news"
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
    <div class="news-grid-badge mb-3 d-flex align-items-center justify-content-between p-2 rounded-3 bg-light border">
      <div class="d-flex align-items-center small">
        <i class="fas fa-newspaper text-info mr-2"></i>
        <strong class="text-dark mr-1">Dynamic Articles / News:</strong>
        <span class="badge badge-info px-2 mr-2">Published</span>
        <span class="text-muted small">({{ s.limit || 3 }} posts &bull; {{ s.columns_desktop || 'col-lg-4' }})</span>
      </div>
      <span class="badge badge-light border text-muted small"><i class="fas fa-sync-alt mr-1"></i> Live Articles</span>
    </div>

    <!-- News Grid Preview -->
    <div class="row g-3">
      <div
        v-for="idx in previewCount"
        :key="idx"
        class="col-md-6 mb-3 d-flex"
        :class="[s.columns_mobile || 'col-12', s.columns_desktop || 'col-lg-4']"
      >
        <div class="card border rounded-3 overflow-hidden bg-white w-100 shadow-2xs d-flex flex-column">
          <div class="bg-light position-relative d-flex align-items-center justify-content-center" style="height: 130px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);">
            <i class="fas fa-file-alt fa-2x text-secondary opacity-50"></i>
            <span class="badge badge-light position-absolute font-weight-bold" style="top: 8px; left: 8px; font-size: 0.65rem;">
              {{ idx === 1 ? 'PRESS RELEASE' : (idx === 2 ? 'INNOVATION' : 'CLEAN AIR') }}
            </span>
          </div>
          <div class="p-3 flex-grow-1 d-flex flex-column">
            <div class="text-muted small mb-1" style="font-size: 0.7rem;">
              <i class="far fa-calendar-alt mr-1"></i> Nov 08, 2026 &bull; 3 min read
            </div>
            <h6 class="font-weight-bold text-dark mb-1" style="font-size: 0.88rem; line-height: 1.3;">
              {{ mockTitles[idx - 1] || 'Latest Clean Air Technology & Indoor Quality Innovations' }}
            </h6>
            <p class="text-muted small mb-3 flex-grow-1" style="font-size: 0.75rem; line-height: 1.4;">
              Discover how advanced multi-stage HEPA filtration improves wellness and eliminates microscopic allergens...
            </p>
            <div class="pt-2 border-top d-flex align-items-center justify-content-between">
              <span class="text-primary font-weight-bold small" style="font-size: 0.75rem;">
                Read Article <i class="fas fa-arrow-right ml-1"></i>
              </span>
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

const s = computed(() => props.block.settings || {});

const previewCount = computed(() => {
  const l = parseInt(s.value.limit || 3, 10);
  return isNaN(l) || l < 1 ? 3 : Math.min(l, 6);
});

const mockTitles = [
  'AIRE Launches Revolutionary Laser-Guided Air Quality System',
  'Clinical Study Confirms 99.97% Airborne Pathogen Elimination',
  '5 Simple Steps to Safeguard Indoor Spaces During Pollen Seasons',
  'Next-Gen HEPA Architecture: The Science Behind Whisper-Quiet Operation',
  'Smart Living: Integrating AI Sensors for Automated Clean Atmosphere',
  'Sustainable Manufacturing: Zero Carbon Purifier Filtration Filters'
];

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

