<template>
  <div class="paragraph-inspector">
    <!-- CONTENT TAB -->
    <div v-if="activeTab === 'content'">
      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Paragraph Text</label>
        <textarea
          v-model="settings.text"
          class="form-control form-control-sm"
          rows="5"
          placeholder="Enter paragraph content..."
        ></textarea>
      </div>

      <div class="custom-control custom-switch mb-3">
        <input
          type="checkbox"
          v-model="settings.isLead"
          class="custom-control-input"
          :id="'leadParaSwitch_' + block.id"
        />
        <label class="custom-control-label small font-weight-bold" :for="'leadParaSwitch_' + block.id">
          Lead Paragraph Style (Slightly larger, prominent text)
        </label>
      </div>

      <!-- Scope-specific alignment -->
      <AlignmentControl :settings="settings" :scope-mode="scopeMode" />
    </div>

    <!-- STYLE TAB -->
    <div v-else-if="activeTab === 'style'">
      <TypographyControl :settings="settings" />
    </div>
  </div>
</template>

<script setup>
import AlignmentControl from '../common/AlignmentControl.vue';
import TypographyControl from '../common/TypographyControl.vue';

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
  },
  scopeMode: {
    type: String,
    default: 'desktop'
  }
});
</script>
