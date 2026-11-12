<template>
  <div class="image-inspector">
    <!-- CONTENT TAB -->
    <div v-if="activeTab === 'content'">
      <!-- Image Preview Card -->
      <div v-if="settings.url" class="mb-3 p-2 bg-light border rounded-3 text-center position-relative">
        <img
          :src="getImageUrl(settings.url)"
          class="img-fluid rounded mb-2 shadow-2xs"
          style="max-height: 120px; object-fit: contain;"
        />
        <div class="d-flex justify-content-center">
          <button
            type="button"
            class="btn btn-xs btn-outline-primary font-weight-bold mr-1"
            @click="$emit('open-media', 'url')"
          >
            <i class="fas fa-sync-alt mr-1"></i> Change Image
          </button>
          <button
            type="button"
            class="btn btn-xs btn-outline-danger"
            @click="settings.url = ''"
          >
            <i class="fas fa-trash-alt mr-1"></i> Remove
          </button>
        </div>
      </div>

      <!-- Open Media Library & Upload Modal -->
      <div class="form-group mb-3">
        <button
          type="button"
          class="btn btn-sm btn-primary btn-block shadow-sm font-weight-bold py-2"
          @click="$emit('open-media', 'url')"
        >
          <i class="fas fa-photo-video mr-1"></i> Select from Storage / Upload
        </button>
      </div>

      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Image URL or Storage Path</label>
        <input
          v-model="settings.url"
          type="text"
          class="form-control form-control-sm"
          placeholder="storage/uploads/... or themes/..."
        />
      </div>

      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark d-flex align-items-center justify-content-between mb-1">
          <span>
            <i class="fas fa-tag text-muted mr-1"></i> Alt Name / Alt Text
          </span>
          <span class="badge badge-light border text-muted font-weight-normal px-2 py-0" style="font-size: 0.65rem;">
            Optional
          </span>
        </label>
        <input
          v-model="settings.alt"
          type="text"
          class="form-control form-control-sm"
          placeholder="e.g. Hero banner image, product preview..."
        />
        <small class="form-text text-muted" style="font-size: 0.72rem;">
          <i class="fas fa-info-circle mr-1"></i> Optional: Alternative text for accessibility (screen readers) and SEO.
        </small>
      </div>

      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Caption (Optional)</label>
        <input
          v-model="settings.caption"
          type="text"
          class="form-control form-control-sm"
          placeholder="Displayed under the image"
        />
      </div>

      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Clickable Link URL (Optional)</label>
        <input
          v-model="settings.link_url"
          type="text"
          class="form-control form-control-sm"
          placeholder="e.g. /products/air-mask"
        />
      </div>

      <div class="custom-control custom-checkbox mb-2" v-if="settings.link_url">
        <input
          type="checkbox"
          v-model="settings.target_blank"
          class="custom-control-input"
          :id="'imgTargetBlankCheck_' + block.id"
        />
        <label class="custom-control-label small" :for="'imgTargetBlankCheck_' + block.id">
          Open link in new window
        </label>
      </div>
    </div>

    <!-- STYLE TAB -->
    <div v-else-if="activeTab === 'style'">
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-shapes mr-1 text-primary"></i> Dimensions & Ratio
        </h6>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Max Width</label>
          <select v-model="settings.maxWidth" class="form-control form-control-sm">
            <option value="100%">100% Full Column</option>
            <option value="85%">85% Column Width</option>
            <option value="70%">70% Column Width</option>
            <option value="50%">50% Column Width</option>
            <option value="420px">Medium Fixed (420px)</option>
            <option value="300px">Compact Fixed (300px)</option>
          </select>
        </div>

        <div class="row">
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Aspect Ratio</label>
              <select v-model="settings.aspectRatio" class="form-control form-control-sm">
                <option value="auto">Auto (Natural)</option>
                <option value="1/1">1:1 Square</option>
                <option value="16/9">16:9 Widescreen</option>
                <option value="4/3">4:3 Classic</option>
                <option value="3/2">3:2 Standard</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Object Fit</label>
              <select v-model="settings.objectFit" class="form-control form-control-sm">
                <option value="cover">Cover (Crop)</option>
                <option value="contain">Contain (Fit)</option>
                <option value="fill">Fill</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Border Radius</label>
              <select v-model="settings.rounded" class="form-control form-control-sm">
                <option value="rounded-0">Square (0)</option>
                <option value="rounded-2">Subtle (6px)</option>
                <option value="rounded-3">Rounded (12px)</option>
                <option value="rounded-4">Soft (16px)</option>
                <option value="rounded-circle">Circle</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Shadow</label>
              <select v-model="settings.shadow" class="form-control form-control-sm">
                <option value="">None</option>
                <option value="shadow-sm">Small</option>
                <option value="shadow">Medium</option>
                <option value="shadow-lg">Large</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { getImageUrl } from '@/layouts/helpers/helpers';

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
  }
});

defineEmits(['open-media']);
</script>
