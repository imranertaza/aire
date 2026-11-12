<template>
  <div class="spacer-inspector">
    <!-- CONTENT TAB -->
    <div v-if="activeTab === 'content'">
      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Height</label>
        <select v-model="settings.height" class="form-control form-control-sm">
          <option value="16px">Tiny (16px)</option>
          <option value="32px">Small (32px)</option>
          <option value="48px">Medium (48px)</option>
          <option value="72px">Large (72px)</option>
          <option value="100px">Extra Large (100px)</option>
        </select>
      </div>

      <div class="custom-control custom-switch mb-2">
        <input
          type="checkbox"
          v-model="settings.isDivider"
          class="custom-control-input"
          :id="'spacerIsDividerSwitch_' + block.id"
        />
        <label class="custom-control-label small font-weight-bold" :for="'spacerIsDividerSwitch_' + block.id">
          Horizontal Divider Line
        </label>
      </div>

      <div class="form-group mb-2" v-if="settings.isDivider">
        <label class="small font-weight-bold text-dark">Divider Style</label>
        <select v-model="settings.dividerStyle" class="form-control form-control-sm">
          <option value="solid">Solid Line</option>
          <option value="dashed">Dashed Line</option>
          <option value="dotted">Dotted Line</option>
        </select>
      </div>
    </div>

    <!-- STYLE TAB -->
    <div v-else-if="activeTab === 'style'">
      <div class="alert alert-light border small text-muted text-center py-3">
        <i class="fas fa-info-circle mr-1 text-primary"></i>
        Spacer block does not require styling options. Adjust height and divider under Content.
      </div>
    </div>
  </div>
</template>

<script setup>
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
