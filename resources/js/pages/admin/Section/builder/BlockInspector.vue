<template>
  <div class="block-inspector bg-white h-100 d-flex flex-column" :class="{ 'border-left shadow-sm': !hideHeader }">
    <!-- Inspector Header -->
    <div v-if="!hideHeader" class="inspector-header px-3 py-3 border-bottom d-flex align-items-center justify-content-between bg-light">
      <div class="d-flex align-items-center">
        <span class="badge badge-primary text-uppercase font-weight-bold px-2 py-1 mr-2" style="font-size: 0.7rem;">
          {{ selectedBlock?.type || 'Block' }}
        </span>
        <h6 class="mb-0 font-weight-bold text-dark" style="font-size: 0.9rem;">Block Settings</h6>
      </div>
      <button type="button" class="btn btn-sm btn-light border-0 text-muted p-1" @click="$emit('close')">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Inspector Navigation Tabs (Content, Style, Advanced) -->
    <div class="inspector-tabs px-2 pt-2 bg-light border-bottom">
      <ul class="nav nav-pills nav-fill inspector-pills">
        <li class="nav-item">
          <a
            class="nav-link font-weight-bold py-1 px-2"
            :class="{ active: activeTab === 'content' }"
            href="#"
            @click.prevent="activeTab = 'content'"
          >
            <i class="fas fa-pen mr-1"></i> Content
          </a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link font-weight-bold py-1 px-2"
            :class="{ active: activeTab === 'style' }"
            href="#"
            @click.prevent="activeTab = 'style'"
          >
            <i class="fas fa-paint-brush mr-1"></i> Style
          </a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link font-weight-bold py-1 px-2"
            :class="{ active: activeTab === 'advanced' }"
            href="#"
            @click.prevent="activeTab = 'advanced'"
          >
            <i class="fas fa-cog mr-1"></i> Advanced
          </a>
        </li>
      </ul>
    </div>

    <!-- Inspector Body -->
    <div class="inspector-body p-3 flex-grow-1 overflow-auto" v-if="selectedBlock">
      <!-- Device Scope Toggle (Available on Content tab) -->
      <DeviceScopeToggle
        v-if="activeTab === 'content' && ['heading', 'paragraph', 'button'].includes(selectedBlock.type)"
        v-model="scopeMode"
      />

      <!-- Content & Style Tabs: Delegated to Focused Block Inspectors -->
      <component
        v-if="['content', 'style'].includes(activeTab) && currentInspector"
        :is="currentInspector"
        :block="selectedBlock"
        :settings="s"
        :active-tab="activeTab"
        :scope-mode="scopeMode"
        @open-media="openMediaModalFor"
      />

      <!-- Fallback if a block has no custom inspector -->
      <div v-else-if="['content', 'style'].includes(activeTab)" class="alert alert-light border small text-muted text-center py-3">
        <i class="fas fa-info-circle mr-1 text-primary"></i>
        No specific settings for this block.
      </div>

      <!-- Advanced Tab: Universal across all blocks -->
      <AdvancedTab
        v-if="activeTab === 'advanced'"
        :settings="s"
        :block-id="selectedBlock.id"
      />
    </div>

    <!-- Empty state when no block is selected -->
    <div v-else class="h-100 d-flex flex-column align-items-center justify-content-center text-center p-4 text-muted">
      <div class="mb-3 text-secondary opacity-50" style="font-size: 2.5rem;">
        <i class="fas fa-mouse-pointer"></i>
      </div>
      <h6 class="font-weight-bold text-dark mb-1">No Block Selected</h6>
      <p class="small mb-0">Click on any block on the canvas to inspect and customize its settings.</p>
    </div>

    <!-- Media Library Modal Integration -->
    <MediaLibraryModal
      :show="showMediaModal"
      :current-value="mediaTargetValue"
      @close="showMediaModal = false"
      @select="onMediaSelect"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

// Common Inspector Controls
import DeviceScopeToggle from './inspector/common/DeviceScopeToggle.vue';
import AdvancedTab from './inspector/common/AdvancedTab.vue';
import MediaLibraryModal from './MediaLibraryModal.vue';

// Modular Block Inspectors
import HeadingInspector from './inspector/blocks/HeadingInspector.vue';
import ParagraphInspector from './inspector/blocks/ParagraphInspector.vue';
import ImageInspector from './inspector/blocks/ImageInspector.vue';
import VideoInspector from './inspector/blocks/VideoInspector.vue';
import ButtonInspector from './inspector/blocks/ButtonInspector.vue';
import CardInspector from './inspector/blocks/CardInspector.vue';
import ContainerInspector from './inspector/blocks/ContainerInspector.vue';
import SpacerInspector from './inspector/blocks/SpacerInspector.vue';
import ProductInspector from './inspector/blocks/ProductInspector.vue';
import AccordionInspector from './inspector/blocks/AccordionInspector.vue';
import NewsInspector from './inspector/blocks/NewsInspector.vue';
import CategoryGridInspector from './inspector/blocks/CategoryGridInspector.vue';
import BrandInspector from './inspector/blocks/BrandInspector.vue';

const props = defineProps({
  selectedBlock: {
    type: Object,
    default: null
  },
  hideHeader: {
    type: Boolean,
    default: false
  }
});

defineEmits(['close']);

const activeTab = ref('content');
const scopeMode = ref('desktop');
const showMediaModal = ref(false);
const mediaTargetField = ref('url');

const inspectorMap = {
  heading: HeadingInspector,
  paragraph: ParagraphInspector,
  image: ImageInspector,
  video: VideoInspector,
  button: ButtonInspector,
  card: CardInspector,
  container: ContainerInspector,
  spacer: SpacerInspector,
  products: ProductInspector,
  accordion: AccordionInspector,
  news: NewsInspector,
  categories: CategoryGridInspector,
  brands: BrandInspector
};

const currentInspector = computed(() => {
  const type = props.selectedBlock?.type;
  return inspectorMap[type] || null;
});

const s = computed(() => {
  if (!props.selectedBlock) return {};
  if (!props.selectedBlock.settings) {
    props.selectedBlock.settings = {};
  }
  return props.selectedBlock.settings;
});

const mediaTargetValue = computed(() => {
  if (mediaTargetField.value === 'poster') {
    return s.value.poster || '';
  }
  return s.value.url || '';
});

function openMediaModalFor(field = 'url') {
  mediaTargetField.value = field;
  showMediaModal.value = true;
}

function onMediaSelect(file) {
  const chosenPath = file.path ? (file.path.startsWith('storage/') ? file.path : 'storage/' + file.path) : file.url;
  if (mediaTargetField.value === 'poster') {
    s.value.poster = chosenPath;
  } else {
    s.value.url = chosenPath;
    if (!s.value.alt && file.name) {
      const cleanName = file.name.replace(/\.[^/.]+$/, '').replace(/[-_]/g, ' ');
      s.value.alt = cleanName;
    }
  }
}
</script>

<style scoped>
.block-inspector {
  width: 340px;
  min-width: 340px;
}

/* Inspector Tab Pills */
.inspector-pills .nav-link {
  color: #64748b;
  font-size: 12px;
  border-radius: 6px;
  transition: all 0.2s ease;
}
.inspector-pills .nav-link:hover {
  color: #0095DA;
  background: #f1f5f9;
}
.inspector-pills .nav-link.active {
  background: #0095DA !important;
  color: #ffffff !important;
  box-shadow: 0 2px 4px rgba(0, 149, 218, 0.25);
}

.inspector-body::-webkit-scrollbar {
  width: 5px;
}
.inspector-body::-webkit-scrollbar-track {
  background: #f8fafc;
}
.inspector-body::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}
.inspector-body::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>
