<template>
  <div class="category-grid-inspector">
    <!-- CONTENT TAB -->
    <div v-if="activeTab === 'content'">
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-th-large mr-1 text-primary"></i> Categories Source
        </h6>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Categories Limit</label>
          <select v-model.number="settings.limit" class="form-control form-control-sm">
            <option :value="4">4 Categories</option>
            <option :value="6">6 Categories (Standard)</option>
            <option :value="8">8 Categories</option>
            <option :value="12">12 Categories</option>
          </select>
        </div>

        <div class="custom-control custom-switch mb-0">
          <input
            type="checkbox"
            v-model="settings.show_count"
            class="custom-control-input"
            :id="'catShowCountSwitch_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'catShowCountSwitch_' + block.id">
            Show Product Count Badge
          </label>
        </div>
      </div>

      <div class="card border rounded-3 p-3 mb-2 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-columns mr-1 text-primary"></i> Grid Columns
        </h6>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Desktop Columns</label>
          <select v-model="settings.columns_desktop" class="form-control form-control-sm">
            <option value="col-lg-2">6 Columns (col-lg-2)</option>
            <option value="col-lg-3">4 Columns (col-lg-3)</option>
            <option value="col-lg-4">3 Columns (col-lg-4)</option>
          </select>
        </div>

        <div class="form-group mb-0">
          <label class="small font-weight-bold text-dark">Mobile Columns</label>
          <select v-model="settings.columns_mobile" class="form-control form-control-sm">
            <option value="col-6">2 Columns (col-6)</option>
            <option value="col-4">3 Columns (col-4)</option>
            <option value="col-12">1 Column (col-12)</option>
          </select>
        </div>
      </div>
    </div>

    <!-- STYLE TAB -->
    <div v-else-if="activeTab === 'style'">
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-th-large mr-1 text-primary"></i> Categories Card Appearance
        </h6>

        <ColorPickerControl
          label="Card Background"
          v-model="settings.card_bg"
          placeholder="#ffffff or inherit"
          default-picker-color="#ffffff"
        />

        <div class="row">
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Corner Radius</label>
              <select v-model="settings.card_rounded" class="form-control form-control-sm">
                <option value="rounded-2">Subtle (6px)</option>
                <option value="rounded-3">Rounded (12px)</option>
                <option value="rounded-4">Soft (16px)</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Shadow</label>
              <select v-model="settings.card_shadow" class="form-control form-control-sm">
                <option value="">None</option>
                <option value="shadow-sm">Soft (sm)</option>
                <option value="shadow">Medium</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import ColorPickerControl from '../common/ColorPickerControl.vue';

defineProps({
  block: {
    type: Object,
    required: true
  },
  settings: {
    type: Object,
    required: true
  },
  activeTab: {
    type: String,
    default: 'content'
  }
});
</script>

