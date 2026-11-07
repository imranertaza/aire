<template>
  <div class="dropzone-wrapper-container position-relative">
    <!-- If there are previews, show the view link overlaid in the top left (only for single file/image or when explicitly enabled) -->
    <div v-if="shouldShowViewFile" class="dropzone-view-overlay"
      style="position: absolute; top: 10px; left: 10px; z-index: 10;">
      <a :href="fileUrl" target="_blank" class="btn btn-xs btn-info shadow-sm" title="View Current File"
        rel="noopener noreferrer">
        <i class="fas fa-eye"></i> View File
      </a>
    </div>

    <!-- The actual Vue3Dropzone component -->
    <Vue3Dropzone
      v-bind="$attrs"
      :multiple="isMultiple"
      :model-value="modelValue"
      @update:model-value="val => $emit('update:modelValue', val)"
      :previews="previews"
      @update:previews="val => $emit('update:previews', val)"
    >
      <!-- Smart Custom Preview Slot that supports Video, Image, and Document Previews -->
      <template #preview="slotProps">
        <slot name="preview" v-bind="slotProps">
          <div
            class="v3-custom-preview"
            :data-slot-item="trackSlotItem(slotProps.data)"
            :class="{
              'v3-custom-preview--multiple': isMultiple,
              'v3-custom-preview--video': isMediaVideo(slotProps.data),
              'v3-custom-preview--file': !isMediaImage(slotProps.data) && !isMediaVideo(slotProps.data)
            }"
            @click.stop="onPreviewClick(slotProps.data)"
            :title="isMediaVideo(slotProps.data) ? 'Click to Play Video' : (isMediaImage(slotProps.data) ? 'Click to View Large' : '')"
          >
            <!-- 1. EMBED VIDEO (YouTube / Vimeo) -->
            <template v-if="isEmbedVideo(slotProps.data)">
              <img
                :src="getMediaDisplaySrc(slotProps.data)"
                :alt="slotProps.data.name || slotProps.data.file?.name || 'Video Preview'"
                class="v3-custom-media"
                loading="lazy"
              />
              <div v-if="isYouTubeMedia(slotProps.data)" class="v3-video-badge v3-badge-youtube">
                <i class="fab fa-youtube mr-1"></i> YOUTUBE
              </div>
              <div v-else-if="isVimeoMedia(slotProps.data)" class="v3-video-badge v3-badge-vimeo">
                <i class="fab fa-vimeo-v mr-1"></i> VIMEO
              </div>
              <div v-else class="v3-video-badge">
                <i class="fas fa-video mr-1"></i> VIDEO
              </div>
              <div class="v3-video-play-hint" title="Play Video">
                <i class="fas fa-play"></i>
              </div>
            </template>

            <!-- 2. DIRECT HTML5 VIDEO PREVIEW (Handles both uploaded File and URL video) -->
            <template v-else-if="isDirectVideo(slotProps.data)">
              <video
                :src="slotProps.data.src"
                class="v3-custom-media"
                muted
                playsinline
                preload="metadata"
                @loadeddata="onVideoLoaded"
              ></video>
              <div class="v3-video-badge">
                <i class="fas fa-video mr-1"></i> VIDEO
              </div>
              <div class="v3-video-play-hint" title="Play Video">
                <i class="fas fa-play"></i>
              </div>
            </template>

            <!-- 3. IMAGE PREVIEW -->
            <template v-else-if="isMediaImage(slotProps.data)">
              <img
                :src="slotProps.data.src"
                :alt="slotProps.data.name || slotProps.data.file?.name || 'Preview'"
                class="v3-custom-media"
              />
            </template>

            <!-- 4. DOCUMENT / OTHER FILE PREVIEW (PDF, Doc, Excel, etc.) -->
            <template v-else>
              <div class="v3-doc-preview">
                <i :class="getDocIcon(slotProps.data)" class="v3-doc-icon"></i>
                <span class="v3-doc-ext">{{ getFileExtension(slotProps.data) }}</span>
              </div>
            </template>

            <!-- Remove Button -->
            <button
              type="button"
              class="v3-remove-btn"
              @click.stop="handleRemove(slotProps.removeFile, slotProps.data)"
              title="Remove"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M18 6l-12 12" />
                <path d="M6 6l12 12" />
              </svg>
            </button>

            <!-- Hover Details Overlay (File Name & Size) -->
            <div class="v3-details-overlay">
              <h6 class="v3-details-name" :title="slotProps.data.name || slotProps.data.file?.name">
                {{ slotProps.data.name || slotProps.data.file?.name }}
              </h6>
              <span v-if="slotProps.data.size || slotProps.data.file?.size" class="v3-details-size">
                {{ slotProps.formatSize ? slotProps.formatSize(slotProps.data.size || slotProps.data.file?.size) : '' }}
              </span>
            </div>

            <!-- Upload Progress Bar (if in progress) -->
            <div
              v-if="slotProps.data.type === 'file' && (slotProps.data.status === 'pending' || slotProps.data.status === 'uploading')"
              class="v3-progress-container"
            >
              <div class="v3-progress-bar" :style="{ width: `${slotProps.data.progress || 0}%` }"></div>
            </div>
          </div>
        </slot>
      </template>

      <!-- Forward any other slots -->
      <template v-for="(_, slotName) in forwardSlots" #[slotName]="slotProps">
        <slot :name="slotName" v-bind="slotProps" />
      </template>
    </Vue3Dropzone>

    <!-- Reusable Media Gallery Lightbox & Video Player Modal -->
    <MediaGalleryModal
      v-model="isGalleryModalOpen"
      :items="galleryItems"
      :initial-index="activeMediaIndex"
      @close="isGalleryModalOpen = false"
    />
  </div>
</template>

<script setup>
import { computed, useAttrs, useSlots, ref, watch } from 'vue';
import Vue3Dropzone from '../../../node_modules/@jaxtheprime/vue3-dropzone/dist/Vue3Dropzone.es.js';
import MediaGalleryModal from './MediaGalleryModal.vue';
import {
  extractYouTubeId,
  extractVimeoId,
  isYouTubeMedia,
  isVimeoMedia,
  getYouTubeThumb,
  getVimeoThumb,
  getRealFullImageUrl,
  getMediaCanonicalKey
} from '@/helpers/mediaGalleryHelper';

const props = defineProps({
  modelValue: {
    type: [Array, Object, null],
    default: null
  },
  previews: {
    type: Array,
    default: () => []
  },
  multiple: {
    type: [Boolean, String],
    default: false
  },
  showViewFile: {
    type: Boolean,
    default: null
  }
});

const emit = defineEmits(['update:modelValue', 'update:previews']);
const attrs = useAttrs();
const slots = useSlots();

const isGalleryModalOpen = ref(false);
const activeMediaIndex = ref(0);
const galleryItems = ref([]);
const trackedRawSlotItems = [];

const trackSlotItem = (data) => {
  if (!data) return null;
  const key = getMediaCanonicalKey(data);
  if (!key) return null;
  const exists = trackedRawSlotItems.some(it => getMediaCanonicalKey(it) === key);
  if (!exists) {
    trackedRawSlotItems.push(data);
  }
  return null;
};

// Reset slot tracking if external previews or files change
watch([() => props.previews, () => props.modelValue], () => {
  trackedRawSlotItems.length = 0;
}, { deep: true });

const forwardSlots = computed(() => {
  const result = {};
  for (const name in slots) {
    if (name !== 'preview') {
      result[name] = slots[name];
    }
  }
  return result;
});

const isMultiple = computed(() => {
  if (props.multiple === true || props.multiple === 'true' || props.multiple === '') {
    return true;
  }
  if (attrs.multiple === true || attrs.multiple === 'true' || attrs.multiple === '') {
    return true;
  }
  return false;
});

const shouldShowViewFile = computed(() => {
  const hasPreview = props.previews && props.previews.length > 0 && Boolean(props.previews[0]);
  if (!hasPreview) return false;

  // If explicitly overridden via showViewFile prop, respect it
  if (props.showViewFile !== null) {
    return props.showViewFile;
  }

  // When multiple is true, do not show the single "View File" overlay
  if (isMultiple.value) {
    return false;
  }

  // Single file/image mode -> show View File link
  return true;
});

const fileUrl = computed(() => {
  if (!props.previews || !props.previews.length || !props.previews[0]) return '#';
  const first = props.previews[0];
  if (typeof first === 'string') return first;
  if (typeof first === 'object' && first !== null) {
    return first.src || first.url || '#';
  }
  return '#';
});

// Media type detection helpers
const isEmbedVideo = (item) => isYouTubeMedia(item) || isVimeoMedia(item);

const isDirectVideo = (item) => {
  if (!item) return false;
  if (isEmbedVideo(item)) return false;
  if (item.file && item.file.type && item.file.type.startsWith('video/')) {
    return true;
  }
  if (item.file_type === 'video' || item.videoType === 'video') return true;
  const target = (item.src || item.url || item.name || item.file?.name || '').toLowerCase();
  return /\.(mp4|webm|mov|ogg|mkv|avi|wmv|flv|m4v|3gp)(\?.*)?$/i.test(target);
};

const isMediaVideo = (item) => isEmbedVideo(item) || isDirectVideo(item);

const isMediaDoc = (item) => {
  if (!item) return false;
  if (isMediaVideo(item)) return false;
  const target = (item.src || item.url || item.name || item.file?.name || '').toLowerCase();
  return /\.(pdf|doc|docx|xls|xlsx|csv|txt|ppt|pptx|zip|rar)(\?.*)?$/i.test(target);
};

const isMediaImage = (item) => {
  if (!item) return false;
  if (isMediaVideo(item)) return false;
  if (isMediaDoc(item)) return false;
  return true;
};

const getMediaDisplaySrc = (item) => {
  if (!item) return '';
  const raw = item.src || item.url || '';
  if (typeof raw !== 'string') return '';

  if (isYouTubeMedia(item)) {
    if (raw.includes('img.youtube.com') || raw.includes('i.ytimg.com')) return raw;
    return getYouTubeThumb(raw);
  }

  if (isVimeoMedia(item)) {
    if (raw.includes('vumbnail.com') || raw.includes('vimeocdn.com')) return raw;
    return getVimeoThumb(raw);
  }

  return raw;
};

const collectAllGalleryItems = (clickedItem) => {
  const result = [];
  const seenKeys = new Set();

  const pushItem = (raw) => {
    if (!raw) return;
    const key = getMediaCanonicalKey(raw);
    if (!key || seenKeys.has(key)) return;
    seenKeys.add(key);
    result.push(raw);
  };

  // 1. From tracked slot items rendered in Vue3Dropzone
  if (trackedRawSlotItems.length > 0) {
    trackedRawSlotItems.forEach(pushItem);
  }

  // 2. From props.previews
  if (Array.isArray(props.previews) && props.previews.length > 0) {
    props.previews.forEach(pushItem);
  } else if (props.previews && typeof props.previews === 'string') {
    pushItem(props.previews);
  }

  // 3. From props.modelValue
  if (Array.isArray(props.modelValue) && props.modelValue.length > 0) {
    props.modelValue.forEach(pushItem);
  } else if (props.modelValue && props.modelValue instanceof File) {
    pushItem(props.modelValue);
  }

  // 4. Ensure clickedItem is present
  if (clickedItem) {
    pushItem(clickedItem);
  }

  return result;
};

const onPreviewClick = (item) => {
  if (!item) return;

  const allItems = collectAllGalleryItems(item);
  galleryItems.value = allItems;

  const clickedKey = getMediaCanonicalKey(item);
  let foundIndex = allItems.findIndex(it => {
    return getMediaCanonicalKey(it) === clickedKey;
  });

  if (foundIndex === -1) {
    foundIndex = 0;
  }

  activeMediaIndex.value = foundIndex;
  isGalleryModalOpen.value = true;
};

const getFileExtension = (item) => {
  const target = (item.name || item.file?.name || item.src || '').split('?')[0];
  const parts = target.split('.');
  return parts.length > 1 ? parts.pop().toUpperCase() : 'FILE';
};

const getDocIcon = (item) => {
  const ext = getFileExtension(item).toLowerCase();
  if (ext === 'pdf') return 'fas fa-file-pdf text-danger';
  if (['xls', 'xlsx', 'csv'].includes(ext)) return 'fas fa-file-excel text-success';
  if (['doc', 'docx'].includes(ext)) return 'fas fa-file-word text-primary';
  if (['zip', 'rar'].includes(ext)) return 'fas fa-file-archive text-warning';
  return 'fas fa-file-alt text-secondary';
};

const onVideoLoaded = (e) => {
  try {
    const video = e.target;
    if (video && video.duration > 0) {
      video.currentTime = Math.min(0.5, video.duration / 2);
    }
  } catch (err) {
    // ignore seek errors
  }
};

const handleRemove = (removeFn, item) => {
  if (item) {
    const key = getMediaCanonicalKey(item);
    const idx = trackedRawSlotItems.findIndex(it => getMediaCanonicalKey(it) === key);
    if (idx !== -1) {
      trackedRawSlotItems.splice(idx, 1);
    }
  }
  if (typeof removeFn === 'function') {
    removeFn(item);
  }
};
</script>

<style scoped>
.v3-custom-preview {
  width: 100%;
  height: 100%;
  min-height: 140px;
  border-radius: 8px;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: #1e293b;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
  cursor: pointer;
}

.v3-custom-preview--multiple {
  width: 150px !important;
  height: 150px !important;
  flex-shrink: 0;
}

.v3-custom-media {
  width: 100%;
  height: 100%;
  border-radius: 8px;
  object-fit: cover;
  background: #0f172a;
  display: block;
}

/* Video Badge */
.v3-video-badge {
  position: absolute;
  top: 8px;
  left: 8px;
  background: rgba(225, 29, 72, 0.95);
  color: #fff;
  font-size: 10px;
  font-weight: 700;
  padding: 3px 8px;
  border-radius: 4px;
  z-index: 5;
  letter-spacing: 0.5px;
  pointer-events: none;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.35);
  display: inline-flex;
  align-items: center;
}

.v3-badge-youtube {
  background: #e11d48 !important; /* YouTube Red */
}

.v3-badge-vimeo {
  background: #0284c7 !important; /* Vimeo Blue */
}

.v3-badge-video {
  background: #f59e0b !important;
  color: #0f172a !important;
}

.v3-badge-image {
  background: #64748b !important;
}

/* Center Play Hint on Video */
.v3-video-play-hint {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: rgba(0, 0, 0, 0.72);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  pointer-events: none;
  z-index: 5;
  border: 2px solid rgba(255, 255, 255, 0.92);
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.45);
}

.v3-custom-preview:hover .v3-video-play-hint {
  background: #e11d48;
  transform: translate(-50%, -50%) scale(1.18);
  border-color: #ffffff;
  box-shadow: 0 6px 20px rgba(225, 29, 72, 0.6);
}

.v3-video-play-hint i {
  margin-left: 2px;
}

/* Document Preview */
.v3-doc-preview {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 10px;
  text-align: center;
}
.v3-doc-icon {
  font-size: 44px;
  margin-bottom: 6px;
}
.v3-doc-ext {
  font-size: 12px;
  font-weight: 700;
  color: #94a3b8;
  text-transform: uppercase;
}

/* Remove Button */
.v3-remove-btn {
  position: absolute;
  top: 8px;
  right: 8px;
  width: 26px;
  height: 26px;
  border-radius: 50%;
  background: rgba(239, 68, 68, 0.9);
  border: none;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 10;
  opacity: 0;
  transition: opacity 0.2s ease, transform 0.15s ease, background 0.2s ease;
  padding: 0;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}
.v3-custom-preview:hover .v3-remove-btn {
  opacity: 1;
}
.v3-remove-btn:hover {
  background: #dc2626;
  transform: scale(1.1);
}
.v3-remove-btn:active {
  transform: scale(0.95);
}

/* Hover Details Overlay */
.v3-details-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.7) 70%, transparent 100%);
  padding: 16px 8px 6px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-end;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.2s ease, visibility 0.2s ease;
  z-index: 6;
  pointer-events: none;
  box-sizing: border-box;
}
.v3-custom-preview:hover .v3-details-overlay {
  opacity: 1;
  visibility: visible;
}
.v3-details-name {
  font-size: 11px;
  font-weight: 600;
  color: #ffffff;
  margin: 0;
  max-width: 90%;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  text-align: center;
}
.v3-details-size {
  font-size: 10px;
  color: #94a3b8;
  margin-top: 2px;
}

/* Upload Progress */
.v3-progress-container {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 6px;
  background: rgba(0, 0, 0, 0.5);
  z-index: 8;
}
.v3-progress-bar {
  height: 100%;
  background: #3b82f6;
  transition: width 0.3s ease;
}

</style>
