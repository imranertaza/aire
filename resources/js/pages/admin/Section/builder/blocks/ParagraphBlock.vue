<template>
  <div
    :id="s.custom_id || undefined"
    class="block-render-paragraph"
    :class="[alignClass, s.marginTop, s.marginBottom, s.custom_class]"
    :style="wrapperStyles"
  >
    <p
      class="mb-0 inline-editable-text"
      :class="[
        s.isLead ? 'lead font-weight-normal' : (!s.fontSizeCustom && (s.fontSize || 'small')),
        !s.color ? 'text-secondary' : ''
      ]"
      :style="textStyles"
      :contenteditable="!isPreviewMode"
      spellcheck="false"
      @blur="onTextBlur"
    >
      {{ s.text || (!isPreviewMode ? 'Enter paragraph content or description...' : '') }}
    </p>
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

const wrapperStyles = computed(() => {
  const styles = {};
  if (s.value.maxWidth) {
    styles.maxWidth = s.value.maxWidth;
    styles.marginLeft = 'auto';
    styles.marginRight = 'auto';
  }
  return styles;
});

const textStyles = computed(() => {
  const styles = {
    whiteSpace: 'pre-line'
  };
  if (s.value.color) styles.color = s.value.color;
  if (s.value.fontSizeCustom) styles.fontSize = s.value.fontSizeCustom;
  if (s.value.fontWeight) styles.fontWeight = s.value.fontWeight;
  if (s.value.lineHeight) styles.lineHeight = s.value.lineHeight;
  if (s.value.textTransform) styles.textTransform = s.value.textTransform;
  if (s.value.letterSpacing) styles.letterSpacing = s.value.letterSpacing;
  return styles;
});
</script>

<style scoped>
.text-start { text-align: left !important; }
.text-end { text-align: right !important; }
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
