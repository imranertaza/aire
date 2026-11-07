<template>
  <Teleport to="body">
    <div
      v-if="modelValue"
      class="v3-gallery-modal-backdrop"
      @click="handleBackdropClick"
    >
      <div class="v3-gallery-modal-dialog" @click.stop>
        <!-- Top Navigation / Header Bar -->
        <div class="v3-gallery-modal-header">
          <div class="d-flex align-items-center text-truncate mr-2">
            <span v-if="activeItem?.isYouTube" class="v3-modal-badge v3-badge-youtube mr-2">
              <i class="fab fa-youtube mr-1"></i> YouTube
            </span>
            <span v-else-if="activeItem?.isVimeo" class="v3-modal-badge v3-badge-vimeo mr-2">
              <i class="fab fa-vimeo-v mr-1"></i> Vimeo
            </span>
            <span v-else-if="activeItem?.isVideo" class="v3-modal-badge v3-badge-video mr-2">
              <i class="fas fa-video mr-1"></i> Video
            </span>
            <span v-else class="v3-modal-badge v3-badge-image mr-2">
              <i class="fas fa-image mr-1"></i> Image
            </span>

            <strong class="v3-gallery-modal-title text-truncate" :title="activeItem?.title">
              {{ activeItem?.title || 'Media Preview' }}
            </strong>

            <span v-if="normalizedItems.length > 1" class="v3-gallery-counter-badge ml-2">
              {{ currentIndex + 1 }} / {{ normalizedItems.length }}
            </span>
          </div>

          <!-- Controls Toolbar -->
          <div class="d-flex align-items-center">
            <!-- Zoom Controls (Only for Images) -->
            <div v-if="activeItem && !activeItem.isVideo" class="v3-zoom-controls mr-2">
              <button
                type="button"
                class="v3-zoom-btn"
                @click="zoomOut"
                :disabled="zoomScale <= MIN_ZOOM"
                title="Zoom Out (-)"
              >
                <i class="fas fa-search-minus"></i>
              </button>
              <button
                type="button"
                class="v3-zoom-indicator"
                @click="resetZoom"
                title="Click to reset 100%"
              >
                {{ Math.round(zoomScale * 100) }}%
              </button>
              <button
                type="button"
                class="v3-zoom-btn"
                @click="zoomIn"
                :disabled="zoomScale >= MAX_ZOOM"
                title="Zoom In (+)"
              >
                <i class="fas fa-search-plus"></i>
              </button>
              <button
                type="button"
                class="v3-zoom-btn ml-1"
                @click="resetZoom"
                title="Reset Zoom (0)"
              >
                <i class="fas fa-undo"></i>
              </button>
            </div>

            <!-- Open Original File in New Tab -->
            <a
              v-if="activeItem?.originalUrl"
              :href="activeItem.originalUrl"
              target="_blank"
              rel="noopener noreferrer"
              class="v3-btn-original mr-2 shadow-sm"
              title="Open full resolution in new tab"
            >
              <i class="fas fa-external-link-alt mr-1"></i>
              <span class="d-none d-sm-inline">Original</span>
            </a>

            <!-- Close Modal Button -->
            <button
              type="button"
              class="v3-modal-close-btn"
              @click="closeModal"
              title="Close (Esc)"
            >
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>

        <!-- Main Media Body with Floating Chevrons -->
        <div class="v3-gallery-modal-body">
          <!-- Left Chevron Arrow -->
          <button
            v-if="normalizedItems.length > 1"
            type="button"
            class="v3-gallery-nav v3-gallery-prev"
            @click.stop="prevMedia"
            title="Previous (Left Arrow or Swipe Right)"
          >
            <i class="fas fa-chevron-left"></i>
          </button>

          <!-- 1. YouTube / Vimeo Embed Player -->
          <div v-if="activeItem?.isEmbed" class="v3-embed-responsive">
            <iframe
              :key="activeItem.embedUrl"
              :src="activeItem.embedUrl"
              class="v3-embed-iframe"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen
            ></iframe>
          </div>

          <!-- 2. Direct HTML5 Video Player -->
          <video
            v-else-if="activeItem?.isVideo"
            :key="activeItem.src"
            :src="activeItem.src"
            controls
            autoplay
            playsinline
            class="v3-modal-video"
          ></video>

          <!-- 3. Full Image View with Zoom, Pan, Drag & Mobile Touch Gestures -->
          <div
            v-else-if="activeItem"
            class="v3-modal-image-wrapper"
            @wheel.prevent="handleWheel"
            @mousedown="startDrag"
            @mousemove="onDrag"
            @mouseup="endDrag"
            @mouseleave="endDrag"
            @touchstart="onTouchStart"
            @touchmove="onTouchMove"
            @touchend="onTouchEnd"
            @dblclick="toggleZoom"
          >
            <img
              :key="activeItem.src"
              :src="activeItem.src"
              :alt="activeItem.title"
              :style="imageTransformStyle"
              @error="handleImageError"
              draggable="false"
            />
          </div>

          <!-- Right Chevron Arrow -->
          <button
            v-if="normalizedItems.length > 1"
            type="button"
            class="v3-gallery-nav v3-gallery-next"
            @click.stop="nextMedia"
            title="Next (Right Arrow or Swipe Left)"
          >
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>

        <!-- Bottom Footer with Gestures Hint & Navigation Dots -->
        <div class="v3-gallery-modal-footer">
          <div class="v3-footer-hint text-truncate">
            <span class="d-none d-md-inline">
              <i class="fas fa-keyboard mr-1"></i> ← / → to navigate • Scroll to zoom • Drag to pan • Esc to close
            </span>
            <span class="d-md-none">
              <i class="fas fa-hand-point-right mr-1"></i> Swipe left/right • Double tap to zoom
            </span>
          </div>

          <!-- Clickable Navigation Dots (up to 15 items) -->
          <div v-if="normalizedItems.length > 1 && normalizedItems.length <= 15" class="v3-gallery-dots">
            <span
              v-for="(_, dotIdx) in normalizedItems"
              :key="dotIdx"
              class="v3-gallery-dot"
              :class="{ 'v3-gallery-dot--active': dotIdx === currentIndex }"
              @click="goToIndex(dotIdx)"
              :title="`Item ${dotIdx + 1}`"
            ></span>
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false
  },
  items: {
    type: Array,
    default: () => []
  },
  initialIndex: {
    type: Number,
    default: 0
  },
  closeOnBackdrop: {
    type: Boolean,
    default: true
  }
});

const emit = defineEmits(['update:modelValue', 'close', 'change']);

import {
  extractYouTubeId,
  extractVimeoId,
  getRealFullImageUrl,
  getMediaCanonicalKey as getCanonicalKey
} from '@/helpers/mediaGalleryHelper';

// Normalize Item Object
const normalizeMediaItem = (item) => {
  if (!item) return null;

  // 1. If it's a string URL
  if (typeof item === 'string') {
    const raw = item.trim();
    if (!raw) return null;
    const ytId = extractYouTubeId(raw);
    const vmId = extractVimeoId(raw);
    const isDirVid = /\.(mp4|webm|mov|ogg|mkv|avi|wmv|flv|m4v|3gp)(\?.*)?$/i.test(raw);
    const isVid = Boolean(ytId || vmId || isDirVid);

    let displaySrc = raw;
    let embedUrl = '';
    if (ytId) {
      displaySrc = `https://img.youtube.com/vi/${ytId}/hqdefault.jpg`;
      embedUrl = `https://www.youtube-nocookie.com/embed/${ytId}?autoplay=1&rel=0`;
    } else if (vmId) {
      displaySrc = `https://vumbnail.com/${vmId}.jpg`;
      embedUrl = `https://player.vimeo.com/video/${vmId}?autoplay=1`;
    }

    return {
      isEmbed: Boolean(ytId || vmId),
      isYouTube: Boolean(ytId),
      isVimeo: Boolean(vmId),
      isVideo: isVid,
      src: isVid ? (ytId || vmId ? displaySrc : raw) : getRealFullImageUrl(raw),
      fallbackSrc: raw,
      originalUrl: raw,
      embedUrl: embedUrl,
      title: ytId ? 'YouTube Video' : (vmId ? 'Vimeo Video' : (isVid ? 'Video Player' : 'Image Preview'))
    };
  }

  // 2. If it's a File instance
  if (item instanceof File || item.file instanceof File) {
    const fileObj = item instanceof File ? item : item.file;
    const isVid = fileObj.type.startsWith('video/') || /\.(mp4|webm|mov|ogg|mkv)$/i.test(fileObj.name);
    const blobUrl = item.src || URL.createObjectURL(fileObj);
    return {
      isEmbed: false,
      isYouTube: false,
      isVimeo: false,
      isVideo: isVid,
      src: blobUrl,
      fallbackSrc: blobUrl,
      originalUrl: blobUrl,
      embedUrl: '',
      title: fileObj.name || (isVid ? 'Video File' : 'Image File')
    };
  }

  // 3. If it's an object (from dropzone slot, sequence cards, or API)
  const candidateUrl = item.rawUrl || item.videoUrl || item.embedUrl || item.url || item.image || item.src || item.previewUrl || '';
  const title = item.name || item.title || item.alt_name || item.file?.name || 'Media Preview';

  // Extract YouTube ID from all possible candidate fields
  let ytId = extractYouTubeId(item.rawUrl)
          || extractYouTubeId(item.videoUrl)
          || extractYouTubeId(item.embedUrl)
          || extractYouTubeId(item.url)
          || extractYouTubeId(item.image)
          || extractYouTubeId(item.src)
          || extractYouTubeId(item.previewUrl)
          || (typeof item.youtubeId === 'string' ? item.youtubeId : null);

  if (!ytId && (item.file_type === 'youtube' || item.videoType === 'youtube')) {
    ytId = extractYouTubeId(candidateUrl) 
        || (typeof item.id === 'string' && /^[a-zA-Z0-9_-]{11}$/.test(item.id) ? item.id : null);
  }

  // Extract Vimeo ID from all possible candidate fields
  let vmId = extractVimeoId(item.rawUrl)
          || extractVimeoId(item.videoUrl)
          || extractVimeoId(item.embedUrl)
          || extractVimeoId(item.url)
          || extractVimeoId(item.image)
          || extractVimeoId(item.src)
          || extractVimeoId(item.previewUrl)
          || (typeof item.vimeoId === 'string' ? item.vimeoId : null);

  if (!vmId && (item.file_type === 'vimeo' || item.videoType === 'vimeo')) {
    vmId = extractVimeoId(candidateUrl) 
        || (typeof item.id === 'string' && /^\d+$/.test(item.id) ? item.id : null);
  }

  const isEmbed = Boolean(ytId || vmId || item.isEmbed || item.file_type === 'youtube' || item.file_type === 'vimeo' || item.videoType === 'youtube' || item.videoType === 'vimeo');
  const isDirVid = Boolean((item.isVideo || item.file_type === 'video' || item.videoType === 'video') && !isEmbed) 
                || /\.(mp4|webm|mov|ogg|mkv|avi|wmv|flv|m4v|3gp)(\?.*)?$/i.test(candidateUrl);
  const isVid = isEmbed || isDirVid || Boolean(item.isVideo);

  let fullSrc = candidateUrl;
  let embedUrl = item.embedUrl || '';
  if (ytId) {
    embedUrl = `https://www.youtube-nocookie.com/embed/${ytId}?autoplay=1&rel=0`;
    fullSrc = item.previewUrl || `https://img.youtube.com/vi/${ytId}/hqdefault.jpg`;
  } else if (vmId) {
    embedUrl = `https://player.vimeo.com/video/${vmId}?autoplay=1`;
    fullSrc = item.previewUrl || `https://vumbnail.com/${vmId}.jpg`;
  } else if (isEmbed && !embedUrl) {
    embedUrl = item.videoUrl || item.url || candidateUrl;
  } else if (!isVid) {
    fullSrc = getRealFullImageUrl(candidateUrl);
  }

  return {
    isEmbed: isEmbed,
    isYouTube: Boolean(ytId || item.file_type === 'youtube' || item.videoType === 'youtube'),
    isVimeo: Boolean(vmId || item.file_type === 'vimeo' || item.videoType === 'vimeo'),
    isVideo: isVid,
    src: fullSrc || embedUrl || candidateUrl,
    fallbackSrc: candidateUrl,
    originalUrl: candidateUrl,
    embedUrl: embedUrl,
    title: ytId ? `YouTube (${ytId})` : (vmId ? `Vimeo (${vmId})` : title)
  };
};

// Deduplicated & Normalized Items List
const normalizedItems = computed(() => {
  if (!Array.isArray(props.items) || props.items.length === 0) return [];
  const result = [];
  const seenKeys = new Set();

  for (const raw of props.items) {
    const key = getCanonicalKey(raw);
    if (!key || seenKeys.has(key)) continue;
    seenKeys.add(key);
    const media = normalizeMediaItem(raw);
    if (media && media.src) {
      result.push(media);
    }
  }

  return result;
});

// Active Gallery Index & Current Item
const currentIndex = ref(0);
const activeItem = computed(() => {
  if (normalizedItems.value.length === 0) return null;
  return normalizedItems.value[currentIndex.value] || normalizedItems.value[0];
});

// Zoom & Pan State
const zoomScale = ref(1);
const panX = ref(0);
const panY = ref(0);
const isDragging = ref(false);
const dragStartX = ref(0);
const dragStartY = ref(0);

const MIN_ZOOM = 0.5;
const MAX_ZOOM = 4.0;
const ZOOM_STEP = 0.25;

const resetZoom = () => {
  zoomScale.value = 1;
  panX.value = 0;
  panY.value = 0;
  isDragging.value = false;
};

const zoomIn = () => {
  if (activeItem.value?.isVideo) return;
  zoomScale.value = Math.min(MAX_ZOOM, Number((zoomScale.value + ZOOM_STEP).toFixed(2)));
};

const zoomOut = () => {
  if (activeItem.value?.isVideo) return;
  const newScale = Math.max(MIN_ZOOM, Number((zoomScale.value - ZOOM_STEP).toFixed(2)));
  zoomScale.value = newScale;
  if (newScale <= 1) {
    panX.value = 0;
    panY.value = 0;
  }
};

const toggleZoom = () => {
  if (activeItem.value?.isVideo) return;
  if (zoomScale.value === 1) {
    zoomScale.value = 2;
  } else {
    resetZoom();
  }
};

const handleWheel = (e) => {
  if (activeItem.value?.isVideo) return;
  e.preventDefault();
  const delta = e.deltaY < 0 ? ZOOM_STEP : -ZOOM_STEP;
  const newScale = Math.min(MAX_ZOOM, Math.max(MIN_ZOOM, Number((zoomScale.value + delta).toFixed(2))));
  zoomScale.value = newScale;
  if (newScale <= 1) {
    panX.value = 0;
    panY.value = 0;
  }
};

const startDrag = (e) => {
  if (zoomScale.value <= 1) return;
  isDragging.value = true;
  dragStartX.value = e.clientX - panX.value;
  dragStartY.value = e.clientY - panY.value;
};

const onDrag = (e) => {
  if (!isDragging.value || zoomScale.value <= 1) return;
  panX.value = e.clientX - dragStartX.value;
  panY.value = e.clientY - dragStartY.value;
};

const endDrag = () => {
  isDragging.value = false;
};

// Touch Gestures (Mobile Swipe Navigation & Pinch/Touch Pan)
const touchStartX = ref(0);
const touchStartY = ref(0);
const touchDeltaX = ref(0);
const touchDeltaY = ref(0);
const isTouching = ref(false);

const onTouchStart = (e) => {
  if (!e.touches || e.touches.length !== 1) return;
  touchStartX.value = e.touches[0].clientX;
  touchStartY.value = e.touches[0].clientY;
  touchDeltaX.value = 0;
  touchDeltaY.value = 0;
  isTouching.value = true;

  if (zoomScale.value > 1) {
    dragStartX.value = e.touches[0].clientX - panX.value;
    dragStartY.value = e.touches[0].clientY - panY.value;
    isDragging.value = true;
  }
};

const onTouchMove = (e) => {
  if (!isTouching.value || !e.touches || e.touches.length !== 1) return;
  const currentX = e.touches[0].clientX;
  const currentY = e.touches[0].clientY;
  touchDeltaX.value = currentX - touchStartX.value;
  touchDeltaY.value = currentY - touchStartY.value;

  if (zoomScale.value > 1 && isDragging.value) {
    if (e.cancelable) e.preventDefault();
    panX.value = currentX - dragStartX.value;
    panY.value = currentY - dragStartY.value;
  }
};

const onTouchEnd = () => {
  if (!isTouching.value) return;
  isTouching.value = false;
  isDragging.value = false;

  if (zoomScale.value === 1) {
    const absX = Math.abs(touchDeltaX.value);
    const absY = Math.abs(touchDeltaY.value);
    if (absX > 40 && absX > absY * 1.2) {
      if (touchDeltaX.value < 0) {
        nextMedia();
      } else {
        prevMedia();
      }
    }
  }
  touchDeltaX.value = 0;
  touchDeltaY.value = 0;
};

// Navigation
const goToIndex = (index) => {
  if (normalizedItems.value.length === 0) return;
  const total = normalizedItems.value.length;
  currentIndex.value = (index + total) % total;
  resetZoom();
  emit('change', currentIndex.value, activeItem.value);
};

const nextMedia = () => {
  if (normalizedItems.value.length <= 1) return;
  goToIndex(currentIndex.value + 1);
};

const prevMedia = () => {
  if (normalizedItems.value.length <= 1) return;
  goToIndex(currentIndex.value - 1);
};

const closeModal = () => {
  emit('update:modelValue', false);
  emit('close');
  resetZoom();
  unlockBodyScroll();
};

const handleBackdropClick = () => {
  if (props.closeOnBackdrop) {
    closeModal();
  }
};

const handleImageError = (e) => {
  if (activeItem.value?.fallbackSrc && e.target.src !== activeItem.value.fallbackSrc) {
    e.target.src = activeItem.value.fallbackSrc;
  }
};

// Body Scroll Locking (Guarantees zero scrollbar on page)
const lockBodyScroll = () => {
  document.body.style.overflow = 'hidden';
};

const unlockBodyScroll = () => {
  document.body.style.overflow = '';
};

// Keyboard Shortcuts
const handleKeydown = (e) => {
  if (!props.modelValue) return;
  if (e.key === 'Escape') {
    closeModal();
  } else if (e.key === 'ArrowRight') {
    nextMedia();
  } else if (e.key === 'ArrowLeft') {
    prevMedia();
  } else if (e.key === '+' || e.key === '=') {
    zoomIn();
  } else if (e.key === '-' || e.key === '_') {
    zoomOut();
  } else if (e.key === '0') {
    resetZoom();
  }
};

// Watch modal state & initial index
watch(() => props.modelValue, (isOpen) => {
  if (isOpen) {
    currentIndex.value = Math.max(0, Math.min(props.initialIndex, normalizedItems.value.length - 1));
    resetZoom();
    lockBodyScroll();
  } else {
    resetZoom();
    unlockBodyScroll();
  }
});

watch(() => props.initialIndex, (newIdx) => {
  if (props.modelValue && newIdx >= 0 && newIdx < normalizedItems.value.length) {
    currentIndex.value = newIdx;
    resetZoom();
  }
});

onMounted(() => {
  window.addEventListener('keydown', handleKeydown);
  if (props.modelValue) {
    lockBodyScroll();
  }
});

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown);
  unlockBodyScroll();
});

const imageTransformStyle = computed(() => {
  return {
    transform: `translate(${panX.value}px, ${panY.value}px) scale(${zoomScale.value})`,
    transformOrigin: 'center center',
    cursor: zoomScale.value > 1 ? (isDragging.value ? 'grabbing' : 'grab') : 'zoom-in',
    transition: isDragging.value ? 'none' : 'transform 0.16s ease-out',
    maxWidth: '100%',
    maxHeight: '100%',
    objectFit: 'contain',
    display: 'block',
    userSelect: 'none',
    WebkitUserDrag: 'none'
  };
});
</script>

<style scoped>
/* Fullscreen Lightbox Backdrop - Zero Scrollbars */
.v3-gallery-modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(10, 15, 29, 0.94);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  z-index: 999999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 16px;
  box-sizing: border-box;
  overflow: hidden !important;
  user-select: none;
  animation: v3FadeIn 0.2s ease-out;
}

.v3-gallery-modal-dialog {
  background: #0f172a;
  border: 1px solid rgba(255, 255, 255, 0.15);
  border-radius: 12px;
  overflow: hidden !important;
  width: 95vw;
  max-width: 1100px;
  height: 90vh;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.85);
  position: relative;
  animation: v3SlideUp 0.22s cubic-bezier(0.16, 1, 0.3, 1);
}

.v3-gallery-modal-header {
  padding: 10px 16px;
  background: #1e293b;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-shrink: 0;
  z-index: 10;
}

.v3-gallery-modal-title {
  color: #f1f5f9;
  font-size: 13px;
  font-weight: 600;
  max-width: 320px;
}

.v3-modal-badge {
  font-size: 10px;
  font-weight: 700;
  padding: 3px 8px;
  border-radius: 4px;
  color: #fff;
  letter-spacing: 0.5px;
  text-transform: uppercase;
}

.v3-badge-youtube {
  background: #e11d48 !important;
}

.v3-badge-vimeo {
  background: #0284c7 !important;
}

.v3-badge-video {
  background: #f59e0b !important;
  color: #0f172a !important;
}

.v3-badge-image {
  background: #64748b !important;
}

.v3-gallery-counter-badge {
  background: rgba(255, 255, 255, 0.12);
  color: #38bdf8;
  font-size: 11px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 12px;
  border: 1px solid rgba(56, 189, 248, 0.3);
  letter-spacing: 0.5px;
}

/* Zoom Controls Bar */
.v3-zoom-controls {
  display: inline-flex;
  align-items: center;
  background: rgba(15, 23, 42, 0.85);
  border: 1px solid rgba(255, 255, 255, 0.15);
  border-radius: 6px;
  padding: 2px 4px;
}

.v3-zoom-btn {
  background: transparent;
  border: none;
  color: #94a3b8;
  width: 26px;
  height: 26px;
  border-radius: 4px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  transition: all 0.15s ease;
  padding: 0;
}
.v3-zoom-btn:hover:not(:disabled) {
  background: rgba(255, 255, 255, 0.15);
  color: #ffffff;
}
.v3-zoom-btn:disabled {
  opacity: 0.35;
  cursor: not-allowed;
}

.v3-zoom-indicator {
  background: transparent;
  border: none;
  color: #38bdf8;
  font-size: 11px;
  font-weight: 700;
  padding: 0 6px;
  cursor: pointer;
  min-width: 44px;
  text-align: center;
  font-family: monospace;
}
.v3-zoom-indicator:hover {
  text-decoration: underline;
}

.v3-btn-original {
  background: rgba(56, 189, 248, 0.1);
  color: #38bdf8;
  border: 1px solid rgba(56, 189, 248, 0.3);
  font-size: 11px;
  font-weight: 600;
  padding: 4px 10px;
  border-radius: 6px;
  display: inline-flex;
  align-items: center;
  text-decoration: none;
  transition: all 0.15s ease;
}
.v3-btn-original:hover {
  background: #38bdf8;
  color: #0f172a;
  text-decoration: none;
}

.v3-modal-close-btn {
  background: rgba(255, 255, 255, 0.1);
  border: none;
  color: #e2e8f0;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  transition: all 0.2s ease;
  padding: 0;
}
.v3-modal-close-btn:hover {
  background: #ef4444;
  color: #fff;
  transform: scale(1.08);
}

/* Modal Body */
.v3-gallery-modal-body {
  padding: 0;
  background: #000;
  display: flex;
  align-items: center;
  justify-content: center;
  flex: 1;
  min-height: 0;
  overflow: hidden !important;
  position: relative;
  width: 100%;
}

/* Floating Navigation Arrows */
.v3-gallery-nav {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: rgba(15, 23, 42, 0.78);
  border: 1px solid rgba(255, 255, 255, 0.25);
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  cursor: pointer;
  z-index: 25;
  transition: all 0.2s ease;
  padding: 0;
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
}
.v3-gallery-nav:hover {
  background: rgba(2, 132, 199, 0.95);
  border-color: #38bdf8;
  color: #ffffff;
  transform: translateY(-50%) scale(1.12);
  box-shadow: 0 6px 20px rgba(2, 132, 199, 0.5);
}
.v3-gallery-nav:active {
  transform: translateY(-50%) scale(0.95);
}
.v3-gallery-prev {
  left: 18px;
}
.v3-gallery-next {
  right: 18px;
}

/* Video & Embed Players */
.v3-embed-responsive {
  position: relative;
  width: 100%;
  height: 100%;
  max-width: 100%;
  max-height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.v3-embed-iframe {
  width: 100%;
  height: 100%;
  max-height: 100%;
  border: 0;
}
.v3-modal-video {
  width: 100%;
  max-height: 100%;
  object-fit: contain;
  outline: none;
  background: #000;
}

/* Image Wrapper with Zero Scrollbars */
.v3-modal-image-wrapper {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden !important;
  background: radial-gradient(circle at center, #1e293b 0%, #090d16 100%);
  user-select: none;
  touch-action: none;
}

/* Footer Bar */
.v3-gallery-modal-footer {
  padding: 8px 16px;
  background: #1e293b;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-shrink: 0;
  z-index: 10;
}
.v3-footer-hint {
  font-size: 11px;
  color: #94a3b8;
}

.v3-gallery-dots {
  display: flex;
  align-items: center;
  gap: 6px;
}
.v3-gallery-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.25);
  cursor: pointer;
  transition: all 0.2s ease;
}
.v3-gallery-dot:hover {
  background: rgba(255, 255, 255, 0.6);
  transform: scale(1.2);
}
.v3-gallery-dot--active {
  background: #38bdf8;
  width: 20px;
  border-radius: 4px;
}

/* Mobile Responsive Styles (<= 768px) */
@media (max-width: 768px) {
  .v3-gallery-modal-backdrop {
    padding: 0;
  }
  .v3-gallery-modal-dialog {
    width: 100vw;
    height: 100vh;
    max-width: 100vw;
    max-height: 100vh;
    border-radius: 0;
    border: none;
  }
  .v3-gallery-modal-header {
    padding: 8px 10px;
  }
  .v3-gallery-modal-title {
    max-width: 140px;
    font-size: 12px;
  }
  .v3-gallery-nav {
    width: 40px;
    height: 40px;
    font-size: 15px;
    background: rgba(15, 23, 42, 0.85);
  }
  .v3-gallery-prev {
    left: 8px;
  }
  .v3-gallery-next {
    right: 8px;
  }
  .v3-zoom-controls {
    padding: 1px 2px;
  }
  .v3-zoom-btn {
    width: 22px;
    height: 22px;
    font-size: 10px;
  }
  .v3-zoom-indicator {
    min-width: 36px;
    font-size: 10px;
    padding: 0 3px;
  }
  .v3-gallery-modal-footer {
    padding: 6px 10px;
  }
}

@keyframes v3FadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes v3SlideUp {
  from { opacity: 0; transform: translateY(20px) scale(0.97); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}
</style>
