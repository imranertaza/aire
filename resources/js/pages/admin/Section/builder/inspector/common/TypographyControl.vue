<template>
  <div class="card border rounded-3 p-3 mb-3 bg-light">
    <h6 class="small font-weight-bold text-dark mb-2">
      <i class="fas fa-font mr-1 text-primary"></i> Typography
    </h6>

    <!-- Font Size Preset -->
    <div class="form-group mb-2">
      <label class="small font-weight-bold text-dark">Font Size Preset</label>
      <select v-model="settings.fontSize" class="form-control form-control-sm">
        <option value="display-3 font-weight-bold">Display 3 (Extra Large Hero)</option>
        <option value="display-4 font-weight-bold">Display 4 (Large Hero)</option>
        <option value="title-2">Title 2 (Standard Section Header)</option>
        <option value="h2">H2 (2rem / 32px)</option>
        <option value="h3">H3 (1.75rem / 28px)</option>
        <option value="h4">H4 (1.5rem / 24px)</option>
        <option value="fs-18">Medium (18px)</option>
        <option value="lead">Lead (1.25rem)</option>
        <option value="small">Small Body (14px)</option>
      </select>
    </div>

    <!-- Custom Font Size Input -->
    <div class="form-group mb-2">
      <label class="small text-muted mb-1">Custom Font Size (e.g. 42px or 2.2rem)</label>
      <input
        v-model="settings.fontSizeCustom"
        type="text"
        class="form-control form-control-sm"
        placeholder="Leave empty for preset"
      />
    </div>

    <div class="row">
      <div class="col-6">
        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Weight</label>
          <select v-model="settings.fontWeight" class="form-control form-control-sm">
            <option value="">Default</option>
            <option value="300">Light (300)</option>
            <option value="400">Regular (400)</option>
            <option value="500">Medium (500)</option>
            <option value="600">Semi-Bold (600)</option>
            <option value="700">Bold (700)</option>
            <option value="800">Extra Bold (800)</option>
          </select>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Transform</label>
          <select v-model="settings.textTransform" class="form-control form-control-sm">
            <option value="">None</option>
            <option value="uppercase">UPPERCASE</option>
            <option value="capitalize">Capitalize</option>
            <option value="lowercase">lowercase</option>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-6">
        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Letter Spacing</label>
          <select v-model="settings.letterSpacing" class="form-control form-control-sm">
            <option value="">Default</option>
            <option value="-1px">Tight (-1px)</option>
            <option value="-0.5px">Semi-Tight (-0.5px)</option>
            <option value="0">Normal (0)</option>
            <option value="1px">Wide (1px)</option>
            <option value="2px">Extra Wide (2px)</option>
          </select>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Line Height</label>
          <select v-model="settings.lineHeight" class="form-control form-control-sm">
            <option value="">Default</option>
            <option value="1.1">Tight (1.1)</option>
            <option value="1.3">Snug (1.3)</option>
            <option value="1.5">Normal (1.5)</option>
            <option value="1.8">Relaxed (1.8)</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Text Color -->
    <ColorPickerControl
      label="Text Color"
      v-model="settings.color"
      placeholder="#0d1b2a or rgb(...)"
    />
  </div>
</template>

<script setup>
import ColorPickerControl from './ColorPickerControl.vue';

defineProps({
  settings: {
    type: Object,
    required: true
  }
});
</script>
