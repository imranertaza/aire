<template>
  <aside class="document-tree-navigator d-flex flex-column bg-white h-100" :class="{ 'border-right shadow-sm': !hideHeader }">
    <!-- Navigator Header -->
    <div v-if="!hideHeader" class="navigator-header px-3 py-2 border-bottom d-flex align-items-center justify-content-between bg-light">
      <div class="d-flex align-items-center">
        <i class="fas fa-sitemap text-primary mr-2" style="font-size: 0.9rem;"></i>
        <strong class="text-dark small mb-0">Document Layers ({{ totalBlockCount }})</strong>
      </div>
      <button type="button" class="btn btn-xs btn-light text-muted p-1" @click="$emit('close')" title="Close Layers Panel">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Tree Items List with Drag & Drop Sorting -->
    <div class="navigator-body flex-grow-1 p-2 overflow-auto">
      <div v-if="!blocks || blocks.length === 0" class="text-center py-4 text-muted small">
        <i class="fas fa-cubes mb-2 opacity-50 fa-2x"></i>
        <div>No blocks yet.</div>
      </div>

      <draggable
        v-else
        :list="blocks"
        item-key="id"
        handle=".drag-tree-handle"
        :animation="150"
        ghost-class="ghost-tree-node"
        class="tree-list"
        @end="$emit('reorder')"
      >
        <template #item="{ element: block, index: bIdx }">
          <div class="tree-node mb-1">
            <!-- Root Block Row -->
            <div
              class="tree-node-row d-flex align-items-center justify-content-between px-2 py-1 rounded transition-all"
              :class="{
                'active-node': selectedId === block.id,
                'bg-light': selectedId !== block.id
              }"
              @click.stop="$emit('select', block)"
            >
              <div class="d-flex align-items-center text-truncate mr-2">
                <!-- Drag Grip Handle -->
                <i
                  class="fas fa-grip-vertical drag-tree-handle text-muted mr-1"
                  style="cursor: grab; font-size: 0.75rem;"
                  title="Drag to reorder block in layers"
                ></i>

                <!-- Expand/Collapse for container -->
                <button
                  v-if="block.type === 'container'"
                  type="button"
                  class="btn btn-xs text-muted p-0 mr-1"
                  @click.stop="toggleExpand(block.id)"
                >
                  <i :class="isExpanded(block.id) ? 'fas fa-chevron-down' : 'fas fa-chevron-right'" style="font-size: 0.65rem;"></i>
                </button>

                <i :class="getBlockIcon(block.type)" class="mr-2" :style="{ color: getBlockColor(block.type), fontSize: '0.8rem' }"></i>
                <span class="small font-weight-bold text-dark text-truncate" style="font-size: 0.8rem;">
                  {{ getBlockLabel(block) }}
                </span>
              </div>

              <!-- Quick Action Buttons -->
              <div class="node-actions d-flex align-items-center">
                <span class="badge badge-light border text-muted mr-1" style="font-size: 0.65rem;">
                  {{ block.type }}
                </span>
                <button
                  type="button"
                  class="btn btn-xs btn-light text-secondary p-1"
                  @click.stop="$emit('duplicate', block.id)"
                  title="Duplicate"
                >
                  <i class="fas fa-copy" style="font-size: 0.7rem;"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-xs btn-light text-danger p-1 ml-1"
                  @click.stop="$emit('delete', block.id)"
                  title="Delete"
                >
                  <i class="fas fa-trash-alt" style="font-size: 0.7rem;"></i>
                </button>
              </div>
            </div>

            <!-- Nested Container Columns & Sub-blocks with Nested Drag & Drop -->
            <div
              v-if="block.type === 'container' && isExpanded(block.id) && Array.isArray(block.columns)"
              class="pl-3 mt-1 border-left ml-2"
            >
              <div
                v-for="(col, cIdx) in block.columns"
                :key="cIdx"
                class="tree-col-node mb-1"
              >
                <div class="small text-muted py-1 d-flex align-items-center justify-content-between" style="font-size: 0.72rem;">
                  <span>
                    <i class="fas fa-columns mr-1 text-secondary"></i> Column {{ cIdx + 1 }} ({{ col.length }})
                  </span>
                  <button
                    type="button"
                    class="btn btn-xs btn-link text-primary p-0"
                    @click.stop="$emit('add-to-col', { block, colIdx: cIdx })"
                    title="Add block in this column"
                  >
                    <i class="fas fa-plus"></i>
                  </button>
                </div>

                <!-- Children blocks inside column (Draggable within or between columns) -->
                <draggable
                  v-if="col"
                  :list="col"
                  item-key="id"
                  handle=".drag-sub-handle"
                  :animation="150"
                  ghost-class="ghost-sub-node"
                  group="nested-tree-col"
                  class="pl-2"
                  @end="$emit('reorder')"
                >
                  <template #item="{ element: subBlock, index: sIdx }">
                    <div
                      class="tree-node-row sub-node d-flex align-items-center justify-content-between px-2 py-1 rounded mb-1 transition-all"
                      :class="{
                        'active-node': selectedId === subBlock.id,
                        'bg-white border': selectedId !== subBlock.id
                      }"
                      @click.stop="$emit('select', subBlock)"
                    >
                      <div class="d-flex align-items-center text-truncate mr-2">
                        <!-- Sub Drag Grip Handle -->
                        <i
                          class="fas fa-grip-vertical drag-sub-handle text-muted mr-1"
                          style="cursor: grab; font-size: 0.7rem;"
                          title="Drag to reorder sub-block"
                        ></i>
                        <i :class="getBlockIcon(subBlock.type)" class="mr-2" :style="{ color: getBlockColor(subBlock.type), fontSize: '0.75rem' }"></i>
                        <span class="small text-dark text-truncate font-weight-500" style="font-size: 0.75rem;">
                          {{ getBlockLabel(subBlock) }}
                        </span>
                      </div>
                      <button
                        type="button"
                        class="btn btn-xs btn-light text-danger p-0 px-1"
                        @click.stop="$emit('delete-sub', { col, sIdx })"
                        title="Delete sub-block"
                      >
                        <i class="fas fa-times" style="font-size: 0.65rem;"></i>
                      </button>
                    </div>
                  </template>
                </draggable>
              </div>
            </div>
          </div>
        </template>
      </draggable>
    </div>
  </aside>
</template>

<script setup>
import { ref, computed } from 'vue';
import draggable from 'vuedraggable';

const props = defineProps({
  blocks: {
    type: Array,
    default: () => []
  },
  selectedId: {
    type: String,
    default: ''
  },
  hideHeader: {
    type: Boolean,
    default: false
  }
});

defineEmits(['select', 'delete', 'duplicate', 'close', 'add-to-col', 'delete-sub', 'reorder']);

const expandedNodes = ref(new Set());

function isExpanded(id) {
  // By default, containers are expanded
  return !expandedNodes.value.has(id);
}

function toggleExpand(id) {
  if (expandedNodes.value.has(id)) {
    expandedNodes.value.delete(id);
  } else {
    expandedNodes.value.add(id);
  }
}

const totalBlockCount = computed(() => {
  let count = 0;
  props.blocks.forEach(b => {
    count++;
    if (b.type === 'container' && Array.isArray(b.columns)) {
      b.columns.forEach(col => {
        if (Array.isArray(col)) count += col.length;
      });
    }
  });
  return count;
});

function getBlockIcon(type) {
  const map = {
    heading: 'fas fa-heading',
    paragraph: 'fas fa-paragraph',
    image: 'fas fa-image',
    container: 'fas fa-columns',
    card: 'fas fa-square',
    button: 'fas fa-mouse-pointer',
    spacer: 'fas fa-arrows-alt-v',
    products: 'fas fa-shopping-bag',
    news: 'fas fa-newspaper',
    categories: 'fas fa-th-large',
    brands: 'fas fa-certificate',
    accordion: 'fas fa-question-circle'
  };
  return map[type] || 'fas fa-cube';
}

function getBlockColor(type) {
  const map = {
    heading: '#0095DA',
    paragraph: '#64748b',
    image: '#0ea5e9',
    container: '#f59e0b',
    card: '#8b5cf6',
    button: '#10b981',
    spacer: '#94a3b8',
    products: '#ef4444',
    news: '#06b6d4',
    categories: '#f97316',
    brands: '#10b981',
    accordion: '#6366f1'
  };
  return map[type] || '#64748b';
}

function getBlockLabel(block) {
  const s = block.settings || {};
  if (block.type === 'heading') return s.text ? s.text.substring(0, 24) : 'Heading';
  if (block.type === 'paragraph') return s.text ? s.text.substring(0, 24) : 'Paragraph';
  if (block.type === 'container') return `Container (${block.columns?.length || 2} Cols)`;
  if (block.type === 'card') return s.title ? s.title.substring(0, 24) : 'Feature Card';
  if (block.type === 'button') return s.text || 'CTA Button';
  if (block.type === 'image') return s.alt || 'Image Block';
  if (block.type === 'products') return `Products (${s.source || 'Latest'})`;
  if (block.type === 'news') return `News Articles (${s.limit || 3})`;
  if (block.type === 'categories') return `Categories Grid (${s.limit || 6})`;
  if (block.type === 'brands') return `Brand Logos (${s.limit || 6})`;
  if (block.type === 'accordion') return `FAQ (${s.items?.length || 0} Items)`;
  return block.type;
}
</script>

<style scoped>
.document-tree-navigator {
  width: 280px;
  min-width: 280px;
  max-width: 320px;
  z-index: 1030;
  transition: width 0.2s ease;
}
.tree-node-row {
  cursor: pointer;
  border: 1px solid transparent;
}
.tree-node-row:hover {
  background-color: #f1f5f9 !important;
  border-color: #cbd5e1;
}
.active-node {
  background-color: #e0f2fe !important;
  border-color: #0095DA !important;
}
.active-node span {
  color: #0095DA !important;
}
.node-actions {
  opacity: 0.6;
  transition: opacity 0.15s ease;
}
.tree-node-row:hover .node-actions {
  opacity: 1;
}
.transition-all {
  transition: all 0.15s ease-in-out;
}
.ghost-tree-node,
.ghost-sub-node {
  opacity: 0.45;
  background-color: #e0f2fe !important;
  border: 1px dashed #0095da !important;
  border-radius: 6px;
}
.drag-tree-handle,
.drag-sub-handle {
  opacity: 0.4;
  transition: opacity 0.15s ease;
}
.tree-node-row:hover .drag-tree-handle,
.tree-node-row:hover .drag-sub-handle {
  opacity: 1;
}
.drag-tree-handle:active,
.drag-sub-handle:active {
  cursor: grabbing !important;
}
</style>

