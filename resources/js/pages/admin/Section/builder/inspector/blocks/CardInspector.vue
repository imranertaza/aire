<template>
  <div class="card-inspector">
    <!-- CONTENT TAB -->
    <div v-if="activeTab === 'content'">
      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Card Title</label>
        <input
          v-model="settings.title"
          type="text"
          class="form-control form-control-sm"
          placeholder="Card Title"
        />
      </div>

      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Card Description</label>
        <textarea
          v-model="settings.description"
          class="form-control form-control-sm"
          rows="3"
          placeholder="Card text..."
        ></textarea>
      </div>

      <!-- Accent Type: None, Number, Badge, Icon -->
      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Card Accent Type</label>
        <select v-model="settings.accentType" class="form-control form-control-sm">
          <option value="none">None</option>
          <option value="number">Numeric Step (e.g. 01)</option>
          <option value="badge">Badge Pill (e.g. PRO / NEW)</option>
          <option value="icon">FontAwesome Icon</option>
        </select>
      </div>

      <div class="form-group mb-2" v-if="settings.accentType === 'number'">
        <label class="small font-weight-bold text-dark">Step Number</label>
        <input
          v-model="settings.number"
          type="text"
          class="form-control form-control-sm"
          placeholder="01"
        />
      </div>

      <div class="form-group mb-2" v-else-if="settings.accentType === 'badge'">
        <label class="small font-weight-bold text-dark">Badge Label</label>
        <input
          v-model="settings.badge"
          type="text"
          class="form-control form-control-sm"
          placeholder="FEATURED"
        />
      </div>

      <div class="form-group mb-2" v-else-if="settings.accentType === 'icon'">
        <label class="small font-weight-bold text-dark">Icon Class</label>
        <div class="input-group input-group-sm">
          <select v-model="settings.icon" class="form-control form-control-sm">
            <option value="fas fa-shield-alt">Shield / Security</option>
            <option value="fas fa-leaf">Eco / Pure</option>
            <option value="fas fa-bolt">High Performance</option>
            <option value="fas fa-wind">Airflow</option>
            <option value="fas fa-heart">Health</option>
            <option value="fas fa-star">Premium</option>
            <option value="fas fa-certificate">Official Certification</option>
            <option value="fas fa-cog">Settings / Custom</option>
          </select>
          <div class="input-group-append">
            <span class="input-group-text bg-light"><i :class="settings.icon || 'fas fa-shield-alt'"></i></span>
          </div>
        </div>
      </div>

      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Clickable Card Link (Optional)</label>
        <input
          v-model="settings.link_url"
          type="text"
          class="form-control form-control-sm"
          placeholder="e.g. /products or /about"
        />
        <small class="text-muted" style="font-size: 0.7rem;">Turns the entire card into an interactive link.</small>
      </div>
    </div>

    <!-- STYLE TAB -->
    <div v-else-if="activeTab === 'style'">
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-layer-group mr-1 text-primary"></i> Card Styling & Theme
        </h6>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Theme Preset</label>
          <select v-model="settings.cardStylePreset" class="form-control form-control-sm">
            <option value="white">Clean White (Standard)</option>
            <option value="glass">Frosted Glassmorphism</option>
            <option value="dark">Modern Dark</option>
            <option value="light">Soft Light Gray</option>
            <option value="custom">Custom Color Palette</option>
          </select>
        </div>

        <!-- Custom Background & Border Color when custom preset chosen -->
        <div v-if="settings.cardStylePreset === 'custom'">
          <ColorPickerControl
            label="Card Background"
            v-model="settings.customBgColor"
            placeholder="#ffffff"
            default-picker-color="#ffffff"
          />

          <ColorPickerControl
            label="Card Border Color"
            v-model="settings.customBorderColor"
            placeholder="#e2e8f0"
            default-picker-color="#e2e8f0"
          />
        </div>

        <div class="row">
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Padding</label>
              <select v-model="settings.padding" class="form-control form-control-sm">
                <option value="p-3">Compact (p-3)</option>
                <option value="p-4">Standard (p-4)</option>
                <option value="p-5">Spacious (p-5)</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Corner Radius</label>
              <select v-model="settings.rounded" class="form-control form-control-sm">
                <option value="rounded-2">Subtle (6px)</option>
                <option value="rounded-3">Rounded (12px)</option>
                <option value="rounded-4">Soft (16px)</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group mb-0">
          <label class="small font-weight-bold text-dark">Shadow</label>
          <select v-model="settings.shadow" class="form-control form-control-sm">
            <option value="">None</option>
            <option value="shadow-sm">Soft Shadow</option>
            <option value="shadow">Medium Shadow</option>
            <option value="shadow-lg">Elevated Shadow</option>
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
