<template>
  <div class="brand-inspector">
    <!-- CONTENT TAB -->
    <div v-if="activeTab === 'content'">
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-certificate mr-1 text-primary"></i> Brand Showcase
        </h6>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Brand Limit</label>
          <select v-model.number="settings.limit" class="form-control form-control-sm">
            <option :value="4">4 Brands</option>
            <option :value="6">6 Brands (Standard)</option>
            <option :value="8">8 Brands</option>
            <option :value="12">12 Brands</option>
          </select>
        </div>

        <div class="custom-control custom-switch mb-2">
          <input
            type="checkbox"
            v-model="settings.grayscale"
            class="custom-control-input"
            :id="'brandGrayscaleSwitch_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'brandGrayscaleSwitch_' + block.id">
            Monochrome with Hover Color
          </label>
        </div>

        <div class="custom-control custom-switch mb-0">
          <input
            type="checkbox"
            v-model="settings.boxed"
            class="custom-control-input"
            :id="'brandBoxedSwitch_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'brandBoxedSwitch_' + block.id">
            White Card Container Box
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
            <option value="col-4">3 Columns (col-4)</option>
            <option value="col-6">2 Columns (col-6)</option>
          </select>
        </div>
      </div>
    </div>

    <!-- STYLE TAB -->
    <div v-else-if="activeTab === 'style'">
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-certificate mr-1 text-primary"></i> Brand Card Appearance
        </h6>

        <!-- Boxed Card vs Minimal -->
        <div class="custom-control custom-switch mb-3">
          <input
            type="checkbox"
            v-model="settings.boxed"
            class="custom-control-input"
            :id="'styleBrandBoxedSwitch_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'styleBrandBoxedSwitch_' + block.id">
            Boxed Card Container
          </label>
        </div>

        <!-- Card Background Color (when boxed) -->
        <div v-if="settings.boxed !== false">
          <ColorPickerControl
            label="Card Background"
            v-model="settings.card_bg"
            placeholder="#ffffff"
            default-picker-color="#ffffff"
          />

          <ColorPickerControl
            label="Border Color"
            v-model="settings.card_border_color"
            placeholder="#e2e8f0"
            default-picker-color="#e2e8f0"
          />
        </div>

        <div v-if="settings.boxed !== false" class="row">
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Corner Radius</label>
              <select v-model="settings.card_rounded" class="form-control form-control-sm">
                <option value="rounded-0">Square (0)</option>
                <option value="rounded-2">Subtle (6px)</option>
                <option value="rounded-3">Rounded (12px)</option>
                <option value="rounded-4">Soft (16px)</option>
                <option value="rounded-pill">Pill</option>
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
                <option value="shadow-lg">Floating (lg)</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Card Height</label>
              <select v-model="settings.card_height" class="form-control form-control-sm">
                <option value="72px">Compact (72px)</option>
                <option value="90px">Standard (90px)</option>
                <option value="110px">Spacious (110px)</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Logo Max Height</label>
              <select v-model="settings.logo_height" class="form-control form-control-sm">
                <option value="40px">Small (40px)</option>
                <option value="55px">Standard (55px)</option>
                <option value="70px">Large (70px)</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Logo Effects -->
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-magic mr-1 text-primary"></i> Logo Effects & Hover
        </h6>

        <div class="custom-control custom-switch mb-2">
          <input
            type="checkbox"
            v-model="settings.grayscale"
            class="custom-control-input"
            :id="'styleBrandGrayscaleSwitch_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'styleBrandGrayscaleSwitch_' + block.id">
            Monochrome with Hover Color
          </label>
        </div>

        <div v-if="settings.grayscale !== false" class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Inactive Logo Opacity</label>
          <select v-model="settings.opacity" class="form-control form-control-sm">
            <option value="0.5">50% Subtle</option>
            <option value="0.65">65% Standard</option>
            <option value="0.8">80% Prominent</option>
            <option value="1">100% Full</option>
          </select>
        </div>

        <div class="form-group mb-0">
          <label class="small font-weight-bold text-dark">Hover Interaction</label>
          <select v-model="settings.hover_effect" class="form-control form-control-sm">
            <option value="lift">Lift Up & Primary Border</option>
            <option value="zoom">Zoom Scale (1.04x)</option>
            <option value="border">Border Highlight Only</option>
            <option value="none">None</option>
          </select>
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

