<template>
  <div
    :id="s.custom_id || undefined"
    class="block-render-container rounded-3 border-dashed"
    :class="[s.padding || 'p-2', s.rounded, s.marginTop, s.marginBottom, s.custom_class]"
    :style="{ backgroundColor: s.bgColor || 'transparent' }"
  >
    <div class="small text-muted font-weight-bold mb-2 d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-2">
        <span><i class="fas fa-columns mr-1 text-primary"></i> Multi-Column Layout ({{ cols.length }} Columns)</span>
        <button
          v-if="cols.length < 6"
          type="button"
          class="btn btn-xs btn-outline-primary py-0 px-2 ml-2"
          @click.stop="addColumn"
          title="Add another column (up to 6 columns)"
        >
          <i class="fas fa-plus mr-1"></i> Add Column
        </button>
      </div>
      <span v-if="deviceMode === 'mobile' && s.stackOrderMobile === 'reverse'" class="badge badge-warning">
        <i class="fas fa-sort mr-1"></i> Mobile: Reverse Order
      </span>
    </div>

    <div class="row" :class="[gapClass, s.verticalAlign || 'align-items-center', flexOrderClass]">
      <div
        v-for="(colBlocks, colIdx) in cols"
        :key="colIdx"
        :class="getColClass(colIdx)"
        class="builder-column-slot"
      >
        <div class="p-3 bg-light rounded-3 border h-100 min-vh-20 position-relative">
          <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom">
            <span class="badge badge-secondary" style="font-size: 0.65rem;">Col {{ colIdx + 1 }}</span>
            <div class="d-flex align-items-center gap-1">
              <button
                type="button"
                class="btn btn-xs btn-outline-primary py-0 px-2"
                @click="$emit('add-to-col', { block, colIdx })"
                title="Add block inside this column"
              >
                <i class="fas fa-plus mr-1"></i> Add
              </button>
              <button
                v-if="cols.length > 1"
                type="button"
                class="btn btn-xs btn-outline-danger py-0 px-1 ml-1"
                @click.stop="removeColumn(colIdx)"
                title="Remove this column"
              >
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </div>

          <!-- Nested Draggable inside Column -->
          <draggable
            :list="colBlocks"
            group="blocks-group"
            item-key="id"
            handle=".drag-sub-handle"
            :animation="150"
            ghost-class="ghost-sub-block"
            class="nested-column-canvas"
          >
            <template #item="{ element: subBlock, index: subIdx }">
              <div
                class="sub-block-item mb-2 p-2 bg-white rounded border position-relative"
                :class="{ 'active-sub-block': subBlock.id === selectedId }"
                @click.stop="$emit('select-sub-block', subBlock)"
              >
                <!-- Sub-block quick toolbar -->
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <div class="d-flex align-items-center">
                    <i class="fas fa-grip-vertical drag-sub-handle text-muted mr-1" style="cursor: grab; font-size: 0.75rem;"></i>
                    <span class="badge badge-light text-uppercase border" style="font-size: 0.65rem;">{{ subBlock.type }}</span>
                  </div>
                  <button
                    type="button"
                    class="btn btn-xs btn-light text-danger py-0 px-1"
                    @click.stop="removeSubBlock(colIdx, subIdx)"
                  >
                    <i class="fas fa-times"></i>
                  </button>
                </div>

                <!-- Sub-block Render Preview -->
                <component
                  :is="resolveSubComponent(subBlock.type)"
                  :block="subBlock"
                  :device-mode="deviceMode"
                />
              </div>
            </template>
          </draggable>

          <div v-if="!colBlocks || colBlocks.length === 0" class="text-center py-4 text-muted small">
            <i class="fas fa-plus-circle mb-1 text-primary opacity-50"></i>
            <div>Empty Column</div>
            <button
              type="button"
              class="btn btn-xs btn-link text-primary mt-1"
              @click="$emit('add-to-col', { block, colIdx })"
            >
              + Add block
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import draggable from 'vuedraggable';

import HeadingBlock from './HeadingBlock.vue';
import ParagraphBlock from './ParagraphBlock.vue';
import ImageBlock from './ImageBlock.vue';
import VideoBlock from './VideoBlock.vue';
import CardBlock from './CardBlock.vue';
import ButtonBlock from './ButtonBlock.vue';
import SpacerBlock from './SpacerBlock.vue';

const props = defineProps({
  block: {
    type: Object,
    required: true
  },
  deviceMode: {
    type: String,
    default: 'desktop'
  },
  selectedId: {
    type: String,
    default: ''
  }
});

const emit = defineEmits(['add-to-col', 'select-sub-block', 'update-block']);

const s = computed(() => props.block.settings || {});
const cols = computed(() => {
  if (!props.block.columns) {
    props.block.columns = [[], []];
  }
  return props.block.columns;
});

const getColClass = (colIdx) => {
  if (Array.isArray(s.value.columnClasses) && s.value.columnClasses[colIdx]) {
    return s.value.columnClasses[colIdx];
  }
  if (props.deviceMode === 'mobile') {
    return cols.value.length >= 4 ? 'col-6 mb-3' : 'col-12 mb-3';
  }
  if (props.deviceMode === 'tablet') {
    return cols.value.length >= 4 ? 'col-6 mb-3' : (cols.value.length === 3 ? 'col-4 mb-3' : 'col-6 mb-3');
  }
  // Desktop
  if (cols.value.length === 1) return 'col-12';
  if (cols.value.length === 2) return 'col-6';
  if (cols.value.length === 3) return 'col-4';
  if (cols.value.length === 4) return 'col-3';
  if (cols.value.length === 5) return 'col';
  if (cols.value.length === 6) return 'col-2';
  return 'col';
};

function addColumn() {
  if (cols.value.length < 6) {
    cols.value.push([]);
    syncLayout();
  }
}

function removeColumn(colIdx) {
  if (cols.value.length > 1) {
    cols.value.splice(colIdx, 1);
    syncLayout();
  }
}

function syncLayout() {
  const count = cols.value.length;
  let desktop = 'col-lg-6';
  if (count === 1) desktop = 'col-lg-12';
  else if (count === 2) desktop = 'col-lg-6';
  else if (count === 3) desktop = 'col-lg-4';
  else if (count === 4) desktop = 'col-lg-3';
  else if (count === 5) desktop = 'col-lg';
  else if (count === 6) desktop = 'col-lg-2';

  if (!props.block.settings) props.block.settings = {};
  if (!props.block.settings.layout) props.block.settings.layout = {};
  props.block.settings.layout.desktop = desktop;
  props.block.settings.columnsCount = count;
  props.block.settings.columnClasses = [];
}

const gapClass = computed(() => {
  const g = s.value.gap;
  if (!g) return 'g-3';
  if (typeof g === 'string') return g;
  return props.deviceMode === 'mobile' ? (g.mobile || 'g-3') : (g.desktop || 'g-4');
});

const flexOrderClass = computed(() => {
  if (props.deviceMode === 'mobile' && s.value.stackOrderMobile === 'reverse') {
    return 'flex-column-reverse';
  }
  return '';
});

function resolveSubComponent(type) {
  switch (type) {
    case 'heading': return HeadingBlock;
    case 'paragraph': return ParagraphBlock;
    case 'image': return ImageBlock;
    case 'video': return VideoBlock;
    case 'card': return CardBlock;
    case 'button': return ButtonBlock;
    case 'spacer': return SpacerBlock;
    default: return ParagraphBlock;
  }
}

function removeSubBlock(colIdx, subIdx) {
  cols.value[colIdx].splice(subIdx, 1);
}
</script>

<style scoped>
.border-dashed {
  border: 1px dashed #cbd5e1;
}
.nested-column-canvas {
  min-height: 40px;
}
.sub-block-item {
  cursor: pointer;
  transition: all 0.2s ease;
}
.sub-block-item:hover {
  border-color: #0095DA !important;
}
.active-sub-block {
  border: 2px solid #0095DA !important;
  box-shadow: 0 0 0 2px rgba(0, 149, 218, 0.2);
}
.ghost-sub-block {
  opacity: 0.4;
  background: #e0f2fe;
}
.row.g-2 { margin-right: -6px; margin-left: -6px; }
.row.g-2 > [class*="col"] { padding-right: 6px; padding-left: 6px; }
.row.g-3 { margin-right: -10px; margin-left: -10px; }
.row.g-3 > [class*="col"] { padding-right: 10px; padding-left: 10px; }
.row.g-4 { margin-right: -15px; margin-left: -15px; }
.row.g-4 > [class*="col"] { padding-right: 15px; padding-left: 15px; }
.rounded-3 { border-radius: 12px !important; }
.gap-1 { gap: 0.25rem !important; }
.gap-2 { gap: 0.5rem !important; }
</style>
