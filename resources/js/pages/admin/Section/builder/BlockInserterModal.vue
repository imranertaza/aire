<template>
  <div v-if="show" class="modal fade show d-block" tabindex="-1" style="background: rgba(15, 23, 42, 0.65); z-index: 1060;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="modal-header bg-white px-4 py-3 border-bottom d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <span class="badge badge-primary px-2 py-1"><i class="fas fa-cube mr-1"></i> Library</span>
            <h5 class="modal-title font-weight-bold mb-0 text-dark">Add New Block</h5>
          </div>
          <button type="button" class="close text-muted" @click="$emit('close')" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body p-4 bg-light" style="max-height: 70vh; overflow-y: auto;">
          <!-- Search filter -->
          <div class="mb-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
              </div>
              <input
                v-model="searchQuery"
                type="text"
                class="form-control border-left-0"
                placeholder="Search blocks (heading, image, columns, card, button)..."
              />
            </div>
          </div>

          <!-- Basic Elements -->
          <div v-if="filteredBasics.length" class="mb-4">
            <div class="text-uppercase text-muted font-weight-bold small mb-2" style="letter-spacing: 1px;">
              <i class="fas fa-font mr-1 text-primary"></i> Basic Typography & Content
            </div>
            <div class="row g-3">
              <div v-for="item in filteredBasics" :key="item.type" class="col-md-6 col-lg-4 mb-3">
                <div class="block-select-card card h-100 border rounded-3 p-3 bg-white" @click="selectBlock(item.type)">
                  <div class="d-flex align-items-center mb-2">
                    <div class="block-icon-pill" :class="item.bgClass">
                      <i :class="item.icon"></i>
                    </div>
                    <span class="font-weight-bold ml-2 text-dark">{{ item.title }}</span>
                  </div>
                  <p class="small text-muted mb-0">{{ item.desc }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Media & Graphics -->
          <div v-if="filteredMedia.length" class="mb-4">
            <div class="text-uppercase text-muted font-weight-bold small mb-2" style="letter-spacing: 1px;">
              <i class="fas fa-photo-video mr-1 text-info"></i> Media & Visuals
            </div>
            <div class="row g-3">
              <div v-for="item in filteredMedia" :key="item.type" class="col-md-6 col-lg-4 mb-3">
                <div class="block-select-card card h-100 border rounded-3 p-3 bg-white" @click="selectBlock(item.type)">
                  <div class="d-flex align-items-center mb-2">
                    <div class="block-icon-pill" :class="item.bgClass">
                      <i :class="item.icon"></i>
                    </div>
                    <span class="font-weight-bold ml-2 text-dark">{{ item.title }}</span>
                  </div>
                  <p class="small text-muted mb-0">{{ item.desc }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Layout & Containers -->
          <div v-if="filteredLayout.length" class="mb-4">
            <div class="text-uppercase text-muted font-weight-bold small mb-2" style="letter-spacing: 1px;">
              <i class="fas fa-columns mr-1 text-warning"></i> Multi-Column Layout (Div)
            </div>
            <div class="row g-3">
              <div v-for="item in filteredLayout" :key="item.title" class="col-md-6 col-lg-4 mb-3">
                <div class="block-select-card card h-100 border rounded-3 p-3 bg-white" @click="selectBlock(item.type, item.columnsCount, item.extra)">
                  <div class="d-flex align-items-center mb-2">
                    <div class="block-icon-pill" :class="item.bgClass">
                      <i :class="item.icon"></i>
                    </div>
                    <span class="font-weight-bold ml-2 text-dark">{{ item.title }}</span>
                  </div>
                  <p class="small text-muted mb-0">{{ item.desc }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Interactive Components -->
          <div v-if="filteredComponents.length">
            <div class="text-uppercase text-muted font-weight-bold small mb-2" style="letter-spacing: 1px;">
              <i class="fas fa-cubes mr-1 text-success"></i> Components & Cards
            </div>
            <div class="row g-3">
              <div v-for="item in filteredComponents" :key="item.type" class="col-md-6 col-lg-4 mb-3">
                <div class="block-select-card card h-100 border rounded-3 p-3 bg-white" @click="selectBlock(item.type, null, item.extra)">
                  <div class="d-flex align-items-center mb-2">
                    <div class="block-icon-pill" :class="item.bgClass">
                      <i :class="item.icon"></i>
                    </div>
                    <span class="font-weight-bold ml-2 text-dark">{{ item.title }}</span>
                  </div>
                  <p class="small text-muted mb-0">{{ item.desc }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['close', 'select']);

const searchQuery = ref('');

const basics = [
  { type: 'heading', title: 'Heading', icon: 'fas fa-heading', bgClass: 'bg-primary-soft text-primary', desc: 'H1 to H6 headings with responsive size & alignment' },
  { type: 'paragraph', title: 'Paragraph', icon: 'fas fa-paragraph', bgClass: 'bg-secondary-soft text-secondary', desc: 'Lead text, body paragraphs, and descriptions' },
  { type: 'button', title: 'Button / CTA', icon: 'fas fa-mouse-pointer', bgClass: 'bg-success-soft text-success', desc: 'Call to action button linking to internal or external pages' },
  { type: 'spacer', title: 'Spacer / Divider', icon: 'fas fa-arrows-alt-v', bgClass: 'bg-info-soft text-info', desc: 'Vertical spacing gap or horizontal divider line' }
];

const media = [
  { type: 'image', title: 'Image', icon: 'fas fa-image', bgClass: 'bg-info-soft text-info', desc: 'Responsive graphic with rounded corners, captions, & shadow' }
];

const layout = [
  { type: 'container', columnsCount: 1, title: '1 Column (100% Full Width)', icon: 'fas fa-square', bgClass: 'bg-warning-soft text-warning', desc: 'Single full-width content container with custom padding and gap' },
  { type: 'container', columnsCount: 2, title: '2 Columns (50 / 50)', icon: 'fas fa-columns', bgClass: 'bg-warning-soft text-warning', desc: 'Two equal columns that stack to 1 column on mobile' },
  { type: 'container', columnsCount: 3, title: '3 Columns (33 / 33 / 33)', icon: 'fas fa-th-large', bgClass: 'bg-warning-soft text-warning', desc: 'Three responsive columns for feature listings' },
  { type: 'container', columnsCount: 4, title: '4 Columns (25 / 25 / 25 / 25)', icon: 'fas fa-th', bgClass: 'bg-warning-soft text-warning', desc: 'Four columns for specs, cards, or metric tiles' },
  { type: 'container', columnsCount: 5, title: '5 Columns (Equal 5)', icon: 'fas fa-grip-horizontal', bgClass: 'bg-warning-soft text-warning', desc: 'Five flexible columns for partner tiles or multi-feature grids' },
  { type: 'container', columnsCount: 6, title: '6 Columns (16.6% × 6)', icon: 'fas fa-th-list', bgClass: 'bg-warning-soft text-warning', desc: 'Six compact columns for brand logos, quick tiles, or micro-cards' },
  { type: 'container', columnsCount: 2, extra: { customCols: ['col-lg-4', 'col-lg-8'] }, title: '1/3 + 2/3 (Sidebar Left)', icon: 'fas fa-columns', bgClass: 'bg-info-soft text-info', desc: 'Narrow left column for sidebar/menu + wide right column for content' },
  { type: 'container', columnsCount: 2, extra: { customCols: ['col-lg-8', 'col-lg-4'] }, title: '2/3 + 1/3 (Sidebar Right)', icon: 'fas fa-columns', bgClass: 'bg-info-soft text-info', desc: 'Wide left column for main content + narrow right column for highlights' }
];

const components = [
  { type: 'card', extra: { isGlass: false }, title: 'Solid Card', icon: 'fas fa-square', bgClass: 'bg-purple-soft text-purple', desc: 'White card with subtle shadow and border' },
  { type: 'card', extra: { isGlass: true }, title: 'Glass Card', icon: 'fas fa-cube', bgClass: 'bg-primary-soft text-primary', desc: 'Frosted glassmorphism card with ambient glow' },
  { type: 'products', title: 'Dynamic Products Grid', icon: 'fas fa-shopping-bag', bgClass: 'bg-danger-soft text-danger', desc: 'Live catalog products (Featured, Latest, or by Category) with prices and add-to-cart' },
  { type: 'news', title: 'Dynamic News & Articles', icon: 'fas fa-newspaper', bgClass: 'bg-info-soft text-info', desc: 'Latest or category-filtered press releases, articles, and blog stories' },
  { type: 'categories', title: 'Product Categories Grid', icon: 'fas fa-th-large', bgClass: 'bg-warning-soft text-warning', desc: 'Product category tiles with category badges, counts, and quick navigation' },
  { type: 'brands', title: 'Brand Partners & Logos', icon: 'fas fa-certificate', bgClass: 'bg-success-soft text-success', desc: 'Showcase trusted brands, manufacturer logos, and certifications with grayscale hover' },
  { type: 'accordion', title: 'FAQ Accordion', icon: 'fas fa-question-circle', bgClass: 'bg-info-soft text-info', desc: 'Collapsible accordion questions and answers with smooth expand/collapse' }
];

const filterList = (list) => {
  if (!searchQuery.value) return list;
  const q = searchQuery.value.toLowerCase();
  return list.filter(item => item.title.toLowerCase().includes(q) || item.desc.toLowerCase().includes(q) || item.type.toLowerCase().includes(q));
};

const filteredBasics = computed(() => filterList(basics));
const filteredMedia = computed(() => filterList(media));
const filteredLayout = computed(() => filterList(layout));
const filteredComponents = computed(() => filterList(components));

function selectBlock(type, columnsCount = null, extra = {}) {
  emit('select', { type, columnsCount, extra });
  emit('close');
}
</script>

<style scoped>
.block-select-card {
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.block-select-card:hover {
  transform: translateY(-3px);
  border-color: #0095DA !important;
  box-shadow: 0 8px 24px rgba(0, 149, 218, 0.15) !important;
}
.block-icon-pill {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.1rem;
}
.bg-primary-soft { background: #e0f2fe; }
.bg-secondary-soft { background: #f1f5f9; }
.bg-info-soft { background: #e0f7fa; }
.bg-warning-soft { background: #fef3c7; }
.bg-success-soft { background: #dcfce7; }
.bg-purple-soft { background: #f3e8ff; color: #9333ea; }
.gap-1 { gap: 0.25rem !important; }
.gap-2 { gap: 0.5rem !important; }
.gap-3 { gap: 1rem !important; }
.rounded-4 { border-radius: 16px !important; }
.rounded-3 { border-radius: 12px !important; }
.row.g-3 { margin-right: -8px; margin-left: -8px; }
.row.g-3 > [class*="col"] { padding-right: 8px; padding-left: 8px; }
</style>
