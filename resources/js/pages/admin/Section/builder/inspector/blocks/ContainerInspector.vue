<template>
  <div class="container-inspector">
    <!-- CONTENT TAB -->
    <div v-if="activeTab === 'content'">
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <label class="small font-weight-bold text-dark mb-0">Total Columns</label>
          <div class="btn-group btn-group-sm shadow-2xs">
            <button
              type="button"
              class="btn btn-outline-secondary px-2"
              :disabled="containerColsCount <= 1"
              @click="removeContainerColumn"
              title="Remove column"
            >
              <i class="fas fa-minus"></i>
            </button>
            <span class="btn btn-white disabled font-weight-bold px-3 text-dark">
              {{ containerColsCount }} Columns
            </span>
            <button
              type="button"
              class="btn btn-outline-primary px-2"
              :disabled="containerColsCount >= 6"
              @click="addContainerColumn"
              title="Add column (up to 6)"
            >
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>

        <div class="form-group mb-0">
          <label class="small font-weight-bold text-dark">Column Layout Preset</label>
          <select v-model="containerLayout" class="form-control form-control-sm">
            <option value="col-lg-12">1 Column (100% full width)</option>
            <option value="col-lg-6">2 Columns (50% / 50% split)</option>
            <option value="custom_1_2">2 Columns (1/3 Left + 2/3 Right)</option>
            <option value="custom_2_1">2 Columns (2/3 Left + 1/3 Right)</option>
            <option value="custom_1_3">2 Columns (1/4 Left + 3/4 Right)</option>
            <option value="custom_3_1">2 Columns (3/4 Left + 1/4 Right)</option>
            <option value="col-lg-4">3 Columns (33% / 33% / 33%)</option>
            <option value="col-lg-3">4 Columns (25% / 25% / 25% / 25%)</option>
            <option value="col-lg">5 Columns (Equal 5 Columns)</option>
            <option value="col-lg-2">6 Columns (16.6% × 6 Columns)</option>
          </select>
        </div>
      </div>

      <!-- Mobile Stack Order Override -->
      <div class="form-group p-2 bg-light rounded-3 border mb-2">
        <label class="small font-weight-bold text-dark d-flex align-items-center mb-1">
          <i class="fas fa-mobile-alt mr-1 text-primary"></i> Mobile Stack Order
        </label>
        <select v-model="settings.stackOrderMobile" class="form-control form-control-sm">
          <option value="default">Default (Col 1 on top, Col 2 on bottom)</option>
          <option value="reverse">Reverse (Col 2 on top, Col 1 on bottom)</option>
        </select>
        <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Ideal when placing image on right on desktop, but want image on top on mobile.</small>
      </div>

      <div class="row">
        <div class="col-6">
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Gap</label>
            <select v-model="containerGap" class="form-control form-control-sm">
              <option value="g-2">Compact (8px)</option>
              <option value="g-3">Standard (16px)</option>
              <option value="g-4">Large (24px)</option>
              <option value="g-5">Extra Large (48px)</option>
            </select>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Vertical Align</label>
            <select v-model="settings.verticalAlign" class="form-control form-control-sm">
              <option value="align-items-center">Middle</option>
              <option value="align-items-start">Top</option>
              <option value="align-items-end">Bottom</option>
              <option value="align-items-stretch">Stretch</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- STYLE TAB -->
    <div v-else-if="activeTab === 'style'">
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-brush mr-1 text-primary"></i> Wrapper Styling
        </h6>

        <ColorPickerControl
          label="Background Color"
          v-model="settings.bgColor"
          placeholder="transparent or #f8fafc"
          default-picker-color="#f8fafc"
        />

        <div class="row">
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Internal Padding</label>
              <select v-model="settings.padding" class="form-control form-control-sm">
                <option value="">None</option>
                <option value="p-2">Small (p-2)</option>
                <option value="p-3">Medium (p-3)</option>
                <option value="p-4">Large (p-4)</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Corner Radius</label>
              <select v-model="settings.rounded" class="form-control form-control-sm">
                <option value="">None</option>
                <option value="rounded-3">Rounded (12px)</option>
                <option value="rounded-4">Soft (16px)</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import ColorPickerControl from '../common/ColorPickerControl.vue';

const props = defineProps({
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
  }
});

const containerColsCount = computed(() => {
  return Array.isArray(props.block?.columns) ? props.block.columns.length : 2;
});

function addContainerColumn() {
  if (!props.block) return;
  if (!Array.isArray(props.block.columns)) {
    props.block.columns = [[], []];
  }
  if (props.block.columns.length < 6) {
    props.block.columns.push([]);
    syncContainerColumns(props.block.columns.length);
  }
}

function removeContainerColumn() {
  if (!props.block) return;
  if (Array.isArray(props.block.columns) && props.block.columns.length > 1) {
    props.block.columns.pop();
    syncContainerColumns(props.block.columns.length);
  }
}

function syncContainerColumns(count) {
  let desktop = 'col-lg-6';
  if (count === 1) desktop = 'col-lg-12';
  else if (count === 2) desktop = 'col-lg-6';
  else if (count === 3) desktop = 'col-lg-4';
  else if (count === 4) desktop = 'col-lg-3';
  else if (count === 5) desktop = 'col-lg';
  else if (count === 6) desktop = 'col-lg-2';

  if (!props.settings.layout) props.settings.layout = {};
  props.settings.layout.desktop = desktop;
  props.settings.layout.tablet = count >= 4 ? 'col-md-4' : 'col-md-6';
  props.settings.layout.mobile = count >= 4 ? 'col-6' : 'col-12';
  props.settings.columnsCount = count;
  props.settings.columnClasses = [];
}

const containerLayout = computed({
  get() {
    if (Array.isArray(props.settings.columnClasses) && props.settings.columnClasses.length === 2) {
      const c = props.settings.columnClasses;
      if (c[0] === 'col-lg-4' && c[1] === 'col-lg-8') return 'custom_1_2';
      if (c[0] === 'col-lg-8' && c[1] === 'col-lg-4') return 'custom_2_1';
      if (c[0] === 'col-lg-3' && c[1] === 'col-lg-9') return 'custom_1_3';
      if (c[0] === 'col-lg-9' && c[1] === 'col-lg-3') return 'custom_3_1';
    }
    if (!props.settings.layout) {
      props.settings.layout = { desktop: 'col-lg-6', tablet: 'col-md-6', mobile: 'col-12' };
    }
    return typeof props.settings.layout === 'object' ? props.settings.layout.desktop : props.settings.layout;
  },
  set(val) {
    if (!props.block) return;
    if (typeof props.settings.layout !== 'object' || props.settings.layout === null) {
      props.settings.layout = { desktop: 'col-lg-6', tablet: 'col-md-6', mobile: 'col-12' };
    }

    if (!Array.isArray(props.block.columns)) {
      props.block.columns = [[], []];
    }

    if (val === 'custom_1_2') {
      props.settings.columnClasses = ['col-lg-4', 'col-lg-8'];
      ensureColumnCount(2);
      props.settings.layout.desktop = 'col-lg-6';
    } else if (val === 'custom_2_1') {
      props.settings.columnClasses = ['col-lg-8', 'col-lg-4'];
      ensureColumnCount(2);
      props.settings.layout.desktop = 'col-lg-6';
    } else if (val === 'custom_1_3') {
      props.settings.columnClasses = ['col-lg-3', 'col-lg-9'];
      ensureColumnCount(2);
      props.settings.layout.desktop = 'col-lg-6';
    } else if (val === 'custom_3_1') {
      props.settings.columnClasses = ['col-lg-9', 'col-lg-3'];
      ensureColumnCount(2);
      props.settings.layout.desktop = 'col-lg-6';
    } else {
      props.settings.columnClasses = [];
      props.settings.layout.desktop = val;
      if (val === 'col-lg-12') ensureColumnCount(1);
      else if (val === 'col-lg-6') ensureColumnCount(2);
      else if (val === 'col-lg-4') ensureColumnCount(3);
      else if (val === 'col-lg-3') ensureColumnCount(4);
      else if (val === 'col-lg') ensureColumnCount(5);
      else if (val === 'col-lg-2') ensureColumnCount(6);
    }
  }
});

function ensureColumnCount(target) {
  if (!props.block) return;
  if (!Array.isArray(props.block.columns)) props.block.columns = [];
  while (props.block.columns.length < target) {
    props.block.columns.push([]);
  }
  while (props.block.columns.length > target) {
    props.block.columns.pop();
  }
  props.settings.columnsCount = target;
}

const containerGap = computed({
  get() {
    if (!props.settings.gap) {
      props.settings.gap = { desktop: 'g-4', mobile: 'g-3' };
    }
    return typeof props.settings.gap === 'object' ? props.settings.gap.desktop : props.settings.gap;
  },
  set(val) {
    if (typeof props.settings.gap !== 'object' || props.settings.gap === null) {
      props.settings.gap = { desktop: 'g-4', mobile: 'g-3' };
    }
    props.settings.gap.desktop = val;
  }
});
</script>
