<template>
  <teleport to="body">
    <div v-if="show" class="template-modal-backdrop" @click.self="close">
      <div class="template-modal-dialog modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">
          
          <!-- Modal Header -->
          <div class="modal-header bg-white px-4 py-2 border-bottom d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
              <i class="fas fa-layer-group text-primary mr-2" style="font-size: 1.25rem;"></i>
              <div>
                <h5 class="modal-title font-weight-bold mb-0 text-dark" style="font-size: 1.05rem;">Section Template Library</h5>
                <span class="small text-muted" style="font-size: 0.75rem;">Insert professionally crafted pre-built section layouts with one click</span>
              </div>
            </div>

            <!-- Search & Filter Input -->
            <div class="d-flex align-items-center">
              <div class="input-group input-group-sm mr-3" style="width: 200px;">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-light border-right-0"><i class="fas fa-search text-muted"></i></span>
                </div>
                <input
                  v-model="searchQuery"
                  type="text"
                  class="form-control border-left-0 bg-light"
                  placeholder="Search templates..."
                />
              </div>

              <button type="button" class="close text-muted" @click="close" style="line-height: 1; outline: none; font-size: 1.4rem;">
                <span>&times;</span>
              </button>
            </div>
          </div>

          <!-- Category Navigation Pills -->
          <div class="bg-light px-4 py-1 border-bottom d-flex align-items-center justify-content-between">
            <div class="btn-group btn-group-sm">
              <button
                v-for="cat in categories"
                :key="cat"
                type="button"
                class="btn font-weight-bold px-2 py-1"
                :class="selectedCategory === cat ? 'btn-primary' : 'btn-light text-secondary border-0'"
                @click="selectedCategory = cat"
                style="font-size: 0.78rem;"
              >
                {{ cat }}
              </button>
            </div>

            <span class="small text-muted font-weight-bold" style="font-size: 0.72rem;">
              Showing {{ filteredTemplates.length }} templates
            </span>
          </div>

          <!-- Modal Body: Template Grid -->
          <div class="modal-body p-3 bg-light overflow-auto" style="max-height: 54vh; min-height: 250px;">
            <div v-if="filteredTemplates.length === 0" class="text-center py-5 text-muted">
              <i class="fas fa-search fa-3x mb-3 opacity-50"></i>
              <h6 class="font-weight-bold">No templates match your search</h6>
              <p class="small">Try a different keyword or select "All" categories.</p>
            </div>

            <div v-else class="row g-3">
              <div
                v-for="tpl in filteredTemplates"
                :key="tpl.id"
                class="col-md-6 col-lg-4 d-flex"
              >
                <div class="template-card bg-white border rounded-4 p-3 shadow-sm d-flex flex-column w-100 position-relative transition-all">
                  <!-- Category Badge & Optional Popular Tag -->
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge badge-light border text-primary font-weight-bold px-2 py-1" style="font-size: 0.7rem;">
                      {{ tpl.category }}
                    </span>
                    <div class="d-flex align-items-center">
                      <span v-if="tpl.isCustom" class="badge badge-success text-white font-weight-bold px-2 py-1 mr-1" style="font-size: 0.68rem;">
                        <i class="fas fa-user-check mr-1"></i> My Template
                      </span>
                      <button
                        v-if="tpl.isCustom"
                        type="button"
                        class="btn btn-xs btn-light text-danger p-0 px-1 border-0"
                        @click.stop="deleteCustomTemplate(tpl.id)"
                        title="Delete this template"
                      >
                        <i class="fas fa-trash-alt" style="font-size: 0.7rem;"></i>
                      </button>
                      <span v-else-if="tpl.badge" class="badge badge-warning text-dark font-weight-bold px-2 py-1" style="font-size: 0.68rem;">
                        <i class="fas fa-star mr-1"></i> {{ tpl.badge }}
                      </span>
                    </div>
                  </div>

                  <!-- Template Schematic Blueprint Box -->
                  <div class="template-blueprint-box mb-2 rounded-3 p-2 bg-light d-flex align-items-center justify-content-center flex-column text-muted border">
                    <i :class="tpl.icon" class="fa-lg mb-1 text-primary opacity-75"></i>
                    <!-- Mini visual wireframe representation -->
                    <div class="wireframe-lines w-100">
                      <div class="wireframe-bar w-75 mx-auto mb-1"></div>
                      <div class="wireframe-bar w-50 mx-auto"></div>
                    </div>
                  </div>

                  <!-- Title & Description -->
                  <h6 class="font-weight-bold text-dark mb-1" style="font-size: 0.92rem;">
                    {{ tpl.name }}
                  </h6>
                  <p class="small text-muted flex-grow-1 mb-2" style="font-size: 0.75rem; line-height: 1.45;">
                    {{ tpl.description }}
                  </p>

                  <!-- Action Buttons -->
                  <div class="template-actions pt-2 border-top d-flex align-items-center justify-content-between">
                    <button
                      type="button"
                      class="btn btn-xs btn-outline-secondary font-weight-bold px-2 py-1"
                      @click="insertTemplate(tpl, 'append')"
                      title="Add blocks to the end of your canvas without replacing current content"
                    >
                      <i class="fas fa-plus mr-1"></i> Append
                    </button>

                    <button
                      type="button"
                      class="btn btn-sm btn-primary shadow-sm font-weight-bold px-3 py-1"
                      @click="insertTemplate(tpl, 'replace')"
                      title="Load entire template layout (replaces current blocks and section header)"
                      style="font-size: 0.8rem;"
                    >
                      <i class="fas fa-check mr-1"></i> Use Template
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="modal-footer bg-white px-4 py-2 border-top d-flex align-items-center justify-content-between">
            <span class="small text-muted" style="font-size: 0.75rem;">
              <i class="fas fa-info-circle mr-1"></i> <strong>Tip:</strong> "Use Template" replaces current section settings and blocks, while "Append" adds new blocks below your existing ones.
            </span>
            <button type="button" class="btn btn-sm btn-light border px-4 font-weight-bold" @click="close">
              Close
            </button>
          </div>

        </div>
      </div>
    </div>
  </teleport>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { SECTION_TEMPLATES } from './templates/sectionTemplates';

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['close', 'select']);

const searchQuery = ref('');
const selectedCategory = ref('All');
const customTemplates = ref([]);

function loadCustomTemplates() {
  try {
    const raw = localStorage.getItem('aire_custom_templates');
    if (raw) {
      customTemplates.value = JSON.parse(raw);
    } else {
      customTemplates.value = [];
    }
  } catch (e) {
    customTemplates.value = [];
  }
}

watch(() => props.show, (newVal) => {
  if (newVal) {
    loadCustomTemplates();
  }
});

onMounted(() => {
  loadCustomTemplates();
});

const allTemplates = computed(() => {
  return [...customTemplates.value, ...SECTION_TEMPLATES];
});

const categories = computed(() => {
  const cats = new Set(allTemplates.value.map(t => t.category).filter(Boolean));
  return ['All', ...Array.from(cats)];
});

const filteredTemplates = computed(() => {
  return allTemplates.value.filter(tpl => {
    const matchesCat = selectedCategory.value === 'All' || tpl.category === selectedCategory.value;
    const q = searchQuery.value.trim().toLowerCase();
    const matchesQuery = !q || tpl.name.toLowerCase().includes(q) || tpl.description.toLowerCase().includes(q);
    return matchesCat && matchesQuery;
  });
});

function deleteCustomTemplate(tplId) {
  if (confirm('Are you sure you want to delete this custom template?')) {
    customTemplates.value = customTemplates.value.filter(t => t.id !== tplId);
    localStorage.setItem('aire_custom_templates', JSON.stringify(customTemplates.value));
  }
}

function insertTemplate(template, mode) {
  // If template blocks are stored as a direct array (custom template)
  let tplToPass = template;
  if (template.blocks && !template.generateBlocks) {
    tplToPass = {
      ...template,
      generateBlocks: () => JSON.parse(JSON.stringify(template.blocks))
    };
  }
  emit('select', { template: tplToPass, mode });
  emit('close');
}

function close() {
  emit('close');
}
</script>

<style scoped>
.template-modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.7);
  backdrop-filter: blur(4px);
  z-index: 1060;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px 16px;
  overflow-y: auto;
  animation: fadeIn 0.15s ease-out;
}

.template-modal-dialog {
  width: 94%;
  max-width: 1080px;
  max-height: calc(100vh - 40px);
  margin: auto;
}

.template-card {
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.template-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08) !important;
  border-color: #0095DA !important;
}

.template-blueprint-box {
  height: 65px;
  background: #f1f5f9;
}

.wireframe-bar {
  height: 3px;
  background: #cbd5e1;
  border-radius: 2px;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>

