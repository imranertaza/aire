<template>
  <div class="advanced-tab">
    <!-- BLOCK SPACING (MARGINS) -->
    <div class="card border rounded-3 p-3 mb-3 bg-light">
      <h6 class="small font-weight-bold text-dark mb-2">
        <i class="fas fa-arrows-alt-v mr-1 text-primary"></i> Margin & Spacing
      </h6>

      <div class="row">
        <div class="col-6">
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Margin Top</label>
            <select v-model="settings.marginTop" class="form-control form-control-sm">
              <option value="">None (0)</option>
              <option value="mt-1">Tiny (mt-1)</option>
              <option value="mt-2">Small (mt-2)</option>
              <option value="mt-3">Standard (mt-3)</option>
              <option value="mt-4">Large (mt-4)</option>
              <option value="mt-5">Extra Large (mt-5)</option>
            </select>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Margin Bottom</label>
            <select v-model="settings.marginBottom" class="form-control form-control-sm">
              <option value="">Default</option>
              <option value="mb-0">Zero (mb-0)</option>
              <option value="mb-1">Tiny (mb-1)</option>
              <option value="mb-2">Small (mb-2)</option>
              <option value="mb-3">Standard (mb-3)</option>
              <option value="mb-4">Large (mb-4)</option>
              <option value="mb-5">Extra Large (mb-5)</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- HOVER & INTERACTION EFFECTS -->
    <div class="card border rounded-3 p-3 mb-3 bg-light">
      <h6 class="small font-weight-bold text-dark mb-2">
        <i class="fas fa-magic mr-1 text-primary"></i> Hover & Animation Effects
      </h6>

      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Hover Animation</label>
        <select v-model="settings.hoverEffect" class="form-control form-control-sm">
          <option value="">None</option>
          <option value="hover-lift">Hover Lift (Floats up subtly)</option>
          <option value="hover-zoom">Hover Zoom (Slight expansion)</option>
          <option value="hover-glow">Hover Glow (Soft drop shadow)</option>
        </select>
      </div>

      <!-- Scroll Entrance Animation -->
      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Scroll Entrance Animation</label>
        <select v-model="settings.scrollAnimation" class="form-control form-control-sm">
          <option value="">None (Static)</option>
          <option value="fade-up">Fade Up (↑)</option>
          <option value="fade-down">Fade Down (↓)</option>
          <option value="fade-left">Fade Left (←)</option>
          <option value="fade-right">Fade Right (→)</option>
          <option value="zoom-in">Zoom In</option>
          <option value="flip-up">Flip Up</option>
        </select>
      </div>

      <div class="row" v-if="settings.scrollAnimation">
        <div class="col-6">
          <div class="form-group mb-0">
            <label class="small font-weight-bold text-dark">Delay</label>
            <select v-model="settings.animationDelay" class="form-control form-control-sm">
              <option :value="0">0ms (Instant)</option>
              <option :value="100">100ms</option>
              <option :value="200">200ms</option>
              <option :value="300">300ms</option>
              <option :value="500">500ms</option>
            </select>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group mb-0">
            <label class="small font-weight-bold text-dark">Duration</label>
            <select v-model="settings.animationDuration" class="form-control form-control-sm">
              <option :value="300">Fast (0.3s)</option>
              <option :value="600">Standard (0.6s)</option>
              <option :value="1000">Slow (1.0s)</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- DEVICE VISIBILITY (Available on all blocks) -->
    <div class="card border rounded-3 p-3 mb-3 bg-light">
      <h6 class="small font-weight-bold text-dark mb-2">
        <i class="fas fa-eye mr-1 text-primary"></i> Responsive Visibility
      </h6>

      <div class="custom-control custom-checkbox mb-2">
        <input
          type="checkbox"
          v-model="vis.hideOnMobile"
          class="custom-control-input"
          :id="'hideMobileCheck_' + blockId"
        />
        <label class="custom-control-label small text-muted" :for="'hideMobileCheck_' + blockId">
          Hide on Mobile (&lt; 768px)
        </label>
      </div>

      <div class="custom-control custom-checkbox mb-2">
        <input
          type="checkbox"
          v-model="vis.hideOnTablet"
          class="custom-control-input"
          :id="'hideTabletCheck_' + blockId"
        />
        <label class="custom-control-label small text-muted" :for="'hideTabletCheck_' + blockId">
          Hide on Tablet (768px – 991px)
        </label>
      </div>

      <div class="custom-control custom-checkbox">
        <input
          type="checkbox"
          v-model="vis.hideOnDesktop"
          class="custom-control-input"
          :id="'hideDesktopCheck_' + blockId"
        />
        <label class="custom-control-label small text-muted" :for="'hideDesktopCheck_' + blockId">
          Hide on Desktop (&gt;= 992px)
        </label>
      </div>
    </div>

    <!-- CUSTOM CSS & DEVELOPER ATTRIBUTES -->
    <div class="card border rounded-3 p-3 bg-light">
      <h6 class="small font-weight-bold text-dark mb-2">
        <i class="fas fa-code mr-1 text-primary"></i> Developer Attributes
      </h6>

      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Custom HTML ID</label>
        <input
          v-model="settings.custom_id"
          type="text"
          class="form-control form-control-sm"
          placeholder="e.g. hero-main-heading"
        />
        <small class="text-muted" style="font-size: 0.7rem;">For CSS targeting or anchor scroll navigation.</small>
      </div>

      <div class="form-group mb-0">
        <label class="small font-weight-bold text-dark">Extra CSS Classes</label>
        <input
          v-model="settings.custom_class"
          type="text"
          class="form-control form-control-sm"
          placeholder="e.g. text-gradient shadow-2xs"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  settings: {
    type: Object,
    required: true
  },
  blockId: {
    type: [String, Number],
    default: 'blk'
  }
});

const vis = computed(() => {
  if (!props.settings.visibility) {
    props.settings.visibility = { hideOnMobile: false, hideOnTablet: false, hideOnDesktop: false };
  }
  return props.settings.visibility;
});
</script>
