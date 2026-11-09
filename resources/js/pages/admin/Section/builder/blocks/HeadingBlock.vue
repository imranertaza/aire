<template>
  <div
    :id="s.custom_id || undefined"
    class="block-render-heading"
    :class="[alignClass, s.marginTop, s.marginBottom, s.custom_class, s.hoverEffect]"
  >
    <!-- Eyebrow Badge -->
    <div v-if="s.badge" class="mb-2">
      <span class="badge badge-light border text-primary text-uppercase px-2 py-1 font-weight-bold" style="letter-spacing: 1px; font-size: 0.7rem;">
        {{ s.badge }}
      </span>
    </div>

    <!-- Main Heading Component with Direct Inline Editing -->
    <component
      :is="s.tag || 'h2'"
      class="mb-0 inline-editable-text"
      :class="[!s.fontSizeCustom && (s.fontSize || 'title-2')]"
      :style="headingStyles"
      :contenteditable="!isPreviewMode"
      spellcheck="false"
      @blur="onTextBlur"
      @keydown.enter.prevent="$event.target.blur()"
    >
      {{ s.text || (!isPreviewMode ? 'Click to edit heading text...' : '') }}
    </component>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  block: {
    type: Object,
    required: true
  },
  deviceMode: {
    type: String,
    default: 'desktop'
  },
  isPreviewMode: {
    type: Boolean,
    default: false
  }
});

const s = computed(() => props.block.settings || {});

function onTextBlur(e) {
  if (props.isPreviewMode) return;
  if (!props.block.settings) props.block.settings = {};
  const newText = e.target.innerText.trim();
  props.block.settings.text = newText;
}

const alignClass = computed(() => {
  const a = s.value.align;
  if (!a) return 'text-left';
  if (typeof a === 'string') return a === 'text-start' ? 'text-left' : (a === 'text-end' ? 'text-right' : a);
  const raw = props.deviceMode === 'mobile' ? (a.mobile || 'text-center') : (a.desktop || 'text-left');
  if (raw === 'text-start') return 'text-left';
  if (raw === 'text-end') return 'text-right';
  return raw;
});

const headingStyles = computed(() => {
  const styles = {
    color: s.value.color || 'inherit',
    fontWeight: s.value.fontWeight || '700',
    letterSpacing: s.value.letterSpacing || '-0.5px'
  };
  if (s.value.fontSizeCustom) {
    styles.fontSize = s.value.fontSizeCustom;
  }
  if (s.value.textTransform) {
    styles.textTransform = s.value.textTransform;
  }
  if (s.value.lineHeight) {
    styles.lineHeight = s.value.lineHeight;
  }
  return styles;
});
</script>

<style scoped>
.text-start { text-align: left !important; }
.text-end { text-align: right !important; }
.hover-lift {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
  transform: translateY(-3px);
}
.hover-zoom {
  transition: transform 0.2s ease;
}
.hover-zoom:hover {
  transform: scale(1.02);
}
.inline-editable-text[contenteditable="true"] {
  cursor: text;
  border-radius: 4px;
  transition: background-color 0.15s ease, outline 0.15s ease;
}
.inline-editable-text[contenteditable="true"]:hover {
  background-color: rgba(0, 149, 218, 0.04);
}
.inline-editable-text[contenteditable="true"]:focus {
  outline: 2px dashed #0095da !important;
  outline-offset: 3px;
  background-color: rgba(0, 149, 218, 0.06);
}
</style>
