<template>
  <div class="heading-inspector">
    <!-- CONTENT TAB -->
    <div v-if="activeTab === 'content'">
      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Eyebrow / Badge (Optional)</label>
        <input
          v-model="settings.badge"
          type="text"
          class="form-control form-control-sm"
          placeholder="e.g. INNOVATION or FEATURES"
        />
        <small class="text-muted" style="font-size: 0.7rem;">Small text pill displayed directly above the heading.</small>
      </div>

      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Heading Text</label>
        <textarea
          v-model="settings.text"
          class="form-control form-control-sm"
          rows="3"
          placeholder="Enter heading text..."
        ></textarea>
      </div>

      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">HTML Tag</label>
        <select v-model="settings.tag" class="form-control form-control-sm">
          <option value="h1">H1 — Main Page Hero Title</option>
          <option value="h2">H2 — Standard Section Title</option>
          <option value="h3">H3 — Sub-Section Title</option>
          <option value="h4">H4 — Card or Subsection Header</option>
          <option value="h5">H5 — Small Header</option>
          <option value="h6">H6 — Tiny Header</option>
        </select>
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
