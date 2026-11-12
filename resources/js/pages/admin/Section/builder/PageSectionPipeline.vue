<template>
  <div class="page-section-pipeline-wrap">
    <!-- Top Action / Status Bar -->
    <div class="card border-0 shadow-sm mb-4 bg-white rounded-3">
      <div class="card-body p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
          <h6 class="font-weight-bold text-dark mb-1 d-flex align-items-center">
            <i class="fas fa-stream text-primary mr-2"></i>
            {{ pageTitle || 'Page' }} Section Pipeline & Injections
          </h6>
          <p class="small text-muted mb-0">
            Control the exact top-to-bottom layout flow. Insert your Visual Builder Block Sections before, between, or after native sections.
          </p>
        </div>

        <div class="d-flex align-items-center gap-2">
          <span v-if="hasChanges" class="badge badge-warning text-dark font-weight-bold px-2 py-1 mr-2 animate-pulse">
            <i class="fas fa-exclamation-circle mr-1"></i> Unsaved Changes
          </span>
          <span v-else-if="lastSavedTime" class="small text-muted mr-2">
            <i class="fas fa-check-circle text-success mr-1"></i> Saved {{ lastSavedTime }}
          </span>

          <button
            type="button"
            class="btn btn-sm btn-primary px-3 shadow-sm font-weight-bold d-inline-flex align-items-center"
            :disabled="saving || !hasChanges"
            @click="saveLayout"
          >
            <i v-if="saving" class="fas fa-spinner fa-spin mr-1"></i>
            <i v-else class="fas fa-save mr-1"></i>
            {{ saving ? 'Saving Layout...' : 'Save Pipeline Flow' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status"></div>
      <div class="text-muted small mt-2">Loading pipeline sequence...</div>
    </div>

    <!-- Pipeline Timeline Container -->
    <div v-else class="pipeline-timeline">
      <!-- 0. Top Insertion Point (Before First Section) -->
      <div class="pipeline-insert-zone text-center my-2 position-relative">
        <button
          type="button"
          class="btn btn-xs btn-outline-primary rounded-pill px-3 shadow-2xs font-weight-bold insert-btn"
          @click="openPickerModal(effectiveFirstSlotKey)"
        >
          <i class="fas fa-plus mr-1"></i> Insert Section at Very Top
        </button>
      </div>

      <!-- Injected Sections at Top Slot -->
      <div v-if="slots[effectiveFirstSlotKey] && slots[effectiveFirstSlotKey].length > 0" class="injected-sections-group mb-3">
        <div
          v-for="(sec, idx) in slots[effectiveFirstSlotKey]"
          :key="sec.key + '_' + idx"
          class="injected-section-card card border-primary-light shadow-sm rounded-3 p-3 mb-2"
        >
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center">
              <span class="badge badge-primary px-2 py-1 mr-2 font-weight-bold text-uppercase" style="font-size: 0.7rem;">
                <i class="fas fa-magic mr-1"></i> Visual Block Section
              </span>
              <div>
                <h6 class="font-weight-bold text-dark mb-0">{{ sec.name || sec.key }}</h6>
                <code class="small text-muted">{{ sec.key }}</code>
              </div>
            </div>

            <div class="d-flex align-items-center gap-2">
              <!-- Visibility Switch -->
              <div class="custom-control custom-switch mr-2">
                <input
                  type="checkbox"
                  class="custom-control-input"
                  :id="'switch_' + effectiveFirstSlotKey + '_' + idx"
                  v-model="sec.enabled"
                  @change="markDirty"
                />
                <label class="custom-control-label small font-weight-bold" :for="'switch_' + effectiveFirstSlotKey + '_' + idx">
                  {{ sec.enabled ? 'Active' : 'Hidden' }}
                </label>
              </div>

              <!-- Reorder Buttons -->
              <button
                type="button"
                class="btn btn-xs btn-light border mr-1"
                :disabled="idx === 0"
                @click="moveInjected(effectiveFirstSlotKey, idx, -1)"
                title="Move Up"
              >
                <i class="fas fa-arrow-up"></i>
              </button>
              <button
                type="button"
                class="btn btn-xs btn-light border mr-2"
                :disabled="idx === slots[effectiveFirstSlotKey].length - 1"
                @click="moveInjected(effectiveFirstSlotKey, idx, 1)"
                title="Move Down"
              >
                <i class="fas fa-arrow-down"></i>
              </button>

              <!-- Remove Button -->
              <button
                type="button"
                class="btn btn-xs btn-outline-danger p-1 px-2"
                @click="removeInjected(effectiveFirstSlotKey, idx)"
                title="Remove from Page"
              >
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Native Sections Loop -->
      <div
        v-for="(nativeSec, nIdx) in effectiveNativeList"
        :key="nativeSec.key"
        class="pipeline-step-node mb-3"
      >
        <!-- Native Section Row -->
        <div class="card border rounded-3 p-3 shadow-sm bg-white native-section-card transition-all">
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center">
              <div class="step-number-badge mr-3 bg-light border text-muted font-weight-bold">
                {{ nIdx + 1 }}
              </div>
              <div class="section-avatar bg-light border text-primary rounded-circle mr-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                <i :class="nativeSec.icon || 'fas fa-th-large'"></i>
              </div>
              <div>
                <div class="d-flex align-items-center">
                  <h6 class="font-weight-bold text-dark mb-0 mr-2">{{ nativeSec.title }}</h6>
                  <span class="badge badge-light border text-secondary font-weight-bold" style="font-size: 0.68rem;">
                    {{ nativeSec.badge || 'Native Section' }}
                  </span>
                </div>
                <code class="small text-muted">{{ nativeSec.key }}</code>
              </div>
            </div>

            <!-- Optional Native Edit / Status -->
            <div class="d-flex align-items-center gap-2">
              <router-link
                v-if="nativeSec.editRoute"
                :to="nativeSec.editRoute"
                class="btn btn-xs btn-light border text-dark font-weight-bold"
                title="Edit Native Section Settings"
              >
                <i class="fas fa-cog mr-1 text-muted"></i> Configure
              </router-link>
              <span class="badge badge-success px-2 py-1 font-weight-normal">
                <i class="fas fa-check-circle mr-1"></i> Core Module
              </span>
            </div>
          </div>
        </div>

        <!-- Injected Sections for this boundary (after:nativeSec.key) -->
        <div v-if="slots['after:' + nativeSec.key] && slots['after:' + nativeSec.key].length > 0" class="injected-sections-group mt-2 pl-4 border-left-dashed ml-3">
          <div
            v-for="(sec, idx) in slots['after:' + nativeSec.key]"
            :key="sec.key + '_' + idx"
            class="injected-section-card card border-primary-light shadow-sm rounded-3 p-3 mb-2 bg-gradient-light"
          >
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
              <div class="d-flex align-items-center">
                <span class="badge badge-primary px-2 py-1 mr-2 font-weight-bold text-uppercase" style="font-size: 0.7rem;">
                  <i class="fas fa-magic mr-1"></i> Visual Block Section
                </span>
                <div>
                  <h6 class="font-weight-bold text-dark mb-0">{{ sec.name || sec.key }}</h6>
                  <code class="small text-muted">{{ sec.key }}</code>
                </div>
              </div>

              <div class="d-flex align-items-center gap-2">
                <!-- Visibility Switch -->
                <div class="custom-control custom-switch mr-2">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    :id="'switch_' + nativeSec.key + '_' + idx"
                    v-model="sec.enabled"
                    @change="markDirty"
                  />
                  <label class="custom-control-label small font-weight-bold" :for="'switch_' + nativeSec.key + '_' + idx">
                    {{ sec.enabled ? 'Active' : 'Hidden' }}
                  </label>
                </div>

                <!-- Reorder Buttons -->
                <button
                  type="button"
                  class="btn btn-xs btn-light border mr-1"
                  :disabled="idx === 0"
                  @click="moveInjected('after:' + nativeSec.key, idx, -1)"
                  title="Move Up"
                >
                  <i class="fas fa-arrow-up"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-xs btn-light border mr-2"
                  :disabled="idx === slots['after:' + nativeSec.key].length - 1"
                  @click="moveInjected('after:' + nativeSec.key, idx, 1)"
                  title="Move Down"
                >
                  <i class="fas fa-arrow-down"></i>
                </button>

                <!-- Remove Button -->
                <button
                  type="button"
                  class="btn btn-xs btn-outline-danger p-1 px-2"
                  @click="removeInjected('after:' + nativeSec.key, idx)"
                  title="Remove from Page"
                >
                  <i class="fas fa-trash-alt"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Insertion Zone Between Sections -->
        <div class="pipeline-insert-zone text-center my-3 position-relative">
          <div class="insert-divider-line"></div>
          <button
            type="button"
            class="btn btn-xs btn-outline-primary rounded-pill px-3 shadow-2xs font-weight-bold insert-btn"
            @click="openPickerModal('after:' + nativeSec.key)"
          >
            <i class="fas fa-plus mr-1"></i> Insert Block Section Here
          </button>
        </div>
      </div>
    </div>

    <!-- Modal: Block Section Picker -->
    <teleport to="body">
      <div v-if="showPickerModal" class="modal fade show d-block" tabindex="-1" style="background: rgba(15, 23, 42, 0.65); z-index: 1070;" @click.self="showPickerModal = false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-white px-4 py-3 border-bottom d-flex align-items-center justify-content-between">
              <div>
                <h5 class="modal-title font-weight-bold mb-0 text-dark">
                  <i class="fas fa-layer-group text-primary mr-2"></i> Choose a Visual Block Section
                </h5>
                <small class="text-muted">Insert into slot: <code>{{ targetSlot }}</code></small>
              </div>
              <button type="button" class="close text-muted" @click="showPickerModal = false" style="outline: none;">
                <span>&times;</span>
              </button>
            </div>

            <div class="modal-body p-4 bg-light overflow-auto" style="max-height: 60vh;">
              <!-- Search Bar -->
              <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                </div>
                <input
                  v-model="pickerSearch"
                  type="text"
                  class="form-control border-left-0"
                  placeholder="Search available block sections by name or title..."
                />
              </div>

              <!-- Available Sections Grid -->
              <div v-if="filteredAvailableBlocks.length === 0" class="text-center py-5 bg-white rounded-3 border">
                <i class="fas fa-box-open fa-3x text-muted mb-2 opacity-50"></i>
                <h6 class="font-weight-bold text-dark">No matching block sections found</h6>
                <p class="small text-muted mb-3">Create one in the Visual Section Builder to use it on your pages.</p>
                <router-link :to="{ name: 'CreateSectionBuilder' }" class="btn btn-sm btn-primary" @click="showPickerModal = false">
                  <i class="fas fa-plus mr-1"></i> Create New Block Section
                </router-link>
                
              </div>

              <div v-else class="row g-2">
                <div
                  v-for="block in filteredAvailableBlocks"
                  :key="block.id"
                  class="col-md-6 mb-2"
                >
                  <div class="card border rounded-3 p-3 h-100 bg-white shadow-2xs hover-border-primary transition-all">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <span class="badge badge-light border text-primary font-weight-bold px-2 py-1" style="font-size: 0.68rem;">
                        {{ block.category || 'Visual Builder' }}
                      </span>
                      <span class="small text-muted" style="font-size: 0.72rem;">
                        <i class="fas fa-cubes mr-1"></i> {{ block.block_count }} Blocks
                      </span>
                    </div>

                    <h6 class="font-weight-bold text-dark mb-1">{{ block.title || block.name }}</h6>
                    <code class="small text-muted mb-3 d-block">{{ block.name }}</code>

                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                      <span class="small text-muted" style="font-size: 0.72rem;">
                        {{ block.updated_at || 'Recently' }}
                      </span>
                      <button
                        type="button"
                        class="btn btn-xs btn-primary px-3 font-weight-bold"
                        @click="selectAndInsertBlock(block)"
                      >
                        <i class="fas fa-plus mr-1"></i> Select & Insert
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer bg-white px-4 py-2 border-top d-flex justify-content-between align-items-center">
              <router-link :to="{ name: 'CreateSectionBuilder' }" class="btn btn-sm btn-outline-secondary" @click="showPickerModal = false">
                <i class="fas fa-magic mr-1"></i> Open Section Builder
              </router-link>
              <button type="button" class="btn btn-sm btn-light border" @click="showPickerModal = false">
                Cancel
              </button>
            </div>
          </div>
        </div>
      </div>
    </teleport>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from '@/composables/useToast';

const props = defineProps({
  pageKey: {
    type: String,
    required: true,
  },
  pageTitle: {
    type: String,
    default: 'Page',
  },
  nativeList: {
    type: Array,
    default: () => [],
  },
  nativeSections: {
    type: Array,
    default: () => [],
  },
  firstSlotKey: {
    type: String,
    default: '',
  },
});

const emit = defineEmits(['saved']);
const toast = useToast();

const effectiveNativeList = computed(() => {
  if (Array.isArray(props.nativeList) && props.nativeList.length > 0) {
    return props.nativeList;
  }
  if (Array.isArray(props.nativeSections) && props.nativeSections.length > 0) {
    return props.nativeSections;
  }
  return [];
});

const effectiveFirstSlotKey = computed(() => {
  if (props.firstSlotKey) {
    return props.firstSlotKey;
  }
  if (effectiveNativeList.value.length > 0) {
    return 'before:' + effectiveNativeList.value[0].key;
  }
  return 'before:top';
});

const loading = ref(false);
const saving = ref(false);
const hasChanges = ref(false);
const lastSavedTime = ref('');
const slots = ref({});
const availableBlocks = ref([]);
const showPickerModal = ref(false);
const targetSlot = ref('');
const pickerSearch = ref('');

const fetchLayout = async () => {
  try {
    loading.value = true;
    const res = await axios.get(`/api/sections/layout/${props.pageKey}`);
    slots.value = res.data.data?.slots || {};
    hasChanges.value = false;
  } catch (error) {
    console.error(`Failed to fetch ${props.pageKey} layout:`, error);
  } finally {
    loading.value = false;
  }
};

const fetchAvailableBlocks = async () => {
  try {
    const res = await axios.get('/api/sections/available-blocks');
    availableBlocks.value = res.data.data || [];
  } catch (error) {
    console.error('Failed to fetch available block sections:', error);
  }
};

const filteredAvailableBlocks = computed(() => {
  if (!pickerSearch.value.trim()) return availableBlocks.value;
  const q = pickerSearch.value.toLowerCase().trim();
  return availableBlocks.value.filter(b => {
    return (b.title || '').toLowerCase().includes(q) || (b.name || '').toLowerCase().includes(q);
  });
});

const markDirty = () => {
  hasChanges.value = true;
};

const openPickerModal = (slotKey) => {
  targetSlot.value = slotKey;
  pickerSearch.value = '';
  showPickerModal.value = true;
  if (availableBlocks.value.length === 0) {
    fetchAvailableBlocks();
  }
};

const selectAndInsertBlock = (block) => {
  if (!slots.value[targetSlot.value]) {
    slots.value[targetSlot.value] = [];
  }
  slots.value[targetSlot.value].push({
    key: block.name,
    name: block.title || block.name,
    enabled: true,
  });
  slots.value = { ...slots.value };
  hasChanges.value = true;
  showPickerModal.value = false;
  toast.info(`"${block.title || block.name}" inserted. Click "Save Pipeline Flow" to save.`);
};

const moveInjected = (slotKey, index, direction) => {
  const list = slots.value[slotKey];
  if (!list) return;
  const targetIndex = index + direction;
  if (targetIndex < 0 || targetIndex >= list.length) return;
  const temp = list[index];
  list[index] = list[targetIndex];
  list[targetIndex] = temp;
  slots.value = { ...slots.value };
  hasChanges.value = true;
};

const removeInjected = (slotKey, index) => {
  if (!slots.value[slotKey]) return;
  slots.value[slotKey].splice(index, 1);
  slots.value = { ...slots.value };
  hasChanges.value = true;
};

const saveLayout = async () => {
  try {
    saving.value = true;
    const response = await axios.post(`/api/sections/layout/${props.pageKey}`, {
      slots: slots.value,
    });
    hasChanges.value = false;
    lastSavedTime.value = new Date().toLocaleTimeString();
    toast.success(`${props.pageTitle} layout flow saved successfully!`);
    emit('saved', response.data?.data?.slots || slots.value);
  } catch (error) {
    console.error(`Failed to save ${props.pageKey} layout:`, error);
    const msg = error.response?.data?.message || 'Failed to save layout pipeline.';
    toast.error(msg);
  } finally {
    saving.value = false;
  }
};

onMounted(() => {
  fetchLayout();
  fetchAvailableBlocks();
});
</script>

<style scoped>
.page-section-pipeline-wrap {
  position: relative;
}

.pipeline-timeline {
  max-width: 900px;
  margin: 0 auto;
}

.native-section-card {
  border-left: 4px solid #0095da !important;
}

.step-number-badge {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem;
}

.injected-section-card {
  background: #f0fdf4;
  border: 1.5px dashed #10b981 !important;
}

.border-left-dashed {
  border-left: 2px dashed #cbd5e1;
}

.pipeline-insert-zone {
  display: flex;
  align-items: center;
  justify-content: center;
}

.insert-divider-line {
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  height: 1px;
  background-color: #e2e8f0;
  z-index: 1;
}

.insert-btn {
  position: relative;
  z-index: 2;
  background-color: #ffffff;
  transition: all 0.2s ease;
}

.insert-btn:hover {
  background-color: #0095da;
  color: #ffffff;
  transform: translateY(-1px);
}

.hover-border-primary:hover {
  border-color: #0095da !important;
  box-shadow: 0 4px 12px rgba(0, 149, 218, 0.12) !important;
}

.shadow-2xs {
  box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.6; }
}
</style>

