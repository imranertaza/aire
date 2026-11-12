<template>
  <div
    :id="s.custom_id || undefined"
    class="block-render-video"
    :class="[s.align || 'text-center', s.marginTop, s.marginBottom, s.custom_class]"
  >
    <div
      v-if="hasVideo"
      class="position-relative d-inline-block w-100"
      :style="{ maxWidth: s.maxWidth || '100%' }"
    >
      <!-- Aspect Ratio Container -->
      <div
        class="ratio position-relative overflow-hidden"
        :class="[ratioClass, s.rounded || 'rounded-3', s.shadow || 'shadow-sm']"
        :style="customRatioStyle"
      >
        <!-- YouTube / Vimeo Embed -->
        <iframe
          v-if="embedUrl"
          :src="embedUrl"
          class="w-100 h-100 border-0"
          title="Video player preview"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
        ></iframe>

        <!-- HTML5 Video Preview -->
        <video
          v-else-if="html5Src"
          class="w-100 h-100 object-fit-cover"
          :controls="s.controls !== false"
          :poster="posterUrl || undefined"
          preload="metadata"
        >
          <source :src="html5Src" type="video/mp4" />
        </video>
      </div>

      <!-- Caption -->
      <div v-if="s.caption" class="small text-muted mt-2 text-center">{{ s.caption }}</div>
    </div>

    <!-- Empty State Placeholder -->
    <div v-else class="p-5 border-2 border-dashed rounded-3 text-center bg-light text-muted">
      <div class="video-placeholder-icon mb-2 mx-auto d-inline-flex align-items-center justify-content-center rounded-circle bg-danger-soft text-danger" style="width: 54px; height: 54px;">
        <i class="fas fa-play-circle fa-2x"></i>
      </div>
      <div class="font-weight-bold small text-dark">No Video Configured</div>
      <div class="small text-muted">Paste a YouTube, Vimeo, or MP4 video URL in the Inspector panel</div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { getImageUrl } from '@/layouts/helpers/helpers';

const props = defineProps({
  block: {
    type: Object,
    required: true
  }
});

const s = computed(() => props.block.settings || {});

const rawUrl = computed(() => (s.value.url || '').trim());

// Auto-detect source
const videoSource = computed(() => {
  const url = rawUrl.value;
  if (!url) return s.value.source || 'youtube';
  if (url.includes('youtube.com') || url.includes('youtu.be') || /^[\w-]{11}$/.test(url)) {
    return 'youtube';
  }
  if (url.includes('vimeo.com')) {
    return 'vimeo';
  }
  if (/\.(mp4|webm|ogg|mov)($|\?)/i.test(url) || url.includes('storage/')) {
    return 'html5';
  }
  return s.value.source || 'youtube';
});

// Extract YouTube ID
const youtubeId = computed(() => {
  const url = rawUrl.value;
  if (!url || videoSource.value !== 'youtube') return null;

  if (/^[\w-]{11}$/.test(url)) return url;

  const match = url.match(/(?:youtu\.be\/|(?:www\.|m\.)?youtube(?:-nocookie)?\.com\/(?:.*[?&]v=|(?:v|e(?:mbed)?|shorts)\/))([\w-]{11})/i);
  return match && match[1] ? match[1] : null;
});

// Extract Vimeo ID
const vimeoId = computed(() => {
  const url = rawUrl.value;
  if (!url || videoSource.value !== 'vimeo') return null;

  if (/^\d+$/.test(url)) return url;

  const match = url.match(/(?:vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+))/i);
  return match && match[1] ? match[1] : null;
});

// Compute Embed URL
const embedUrl = computed(() => {
  if (videoSource.value === 'youtube' && youtubeId.value) {
    const params = new URLSearchParams({ rel: '0', enablejsapi: '1' });
    if (s.value.autoplay) {
      params.set('autoplay', '1');
      params.set('mute', '1');
    }
    if (s.value.loop) {
      params.set('loop', '1');
      params.set('playlist', youtubeId.value);
    }
    if (s.value.controls === false) {
      params.set('controls', '0');
    }
    return `https://www.youtube-nocookie.com/embed/${youtubeId.value}?${params.toString()}`;
  }

  if (videoSource.value === 'vimeo' && vimeoId.value) {
    const params = new URLSearchParams({ dnt: '1' });
    if (s.value.autoplay) {
      params.set('autoplay', '1');
      params.set('muted', '1');
    }
    if (s.value.loop) {
      params.set('loop', '1');
    }
    if (s.value.controls === false) {
      params.set('controls', '0');
    }
    return `https://player.vimeo.com/video/${vimeoId.value}?${params.toString()}`;
  }

  return '';
});

// HTML5 source
const html5Src = computed(() => {
  if (videoSource.value !== 'html5' || !rawUrl.value) return '';
  return getImageUrl(rawUrl.value);
});

const posterUrl = computed(() => {
  if (!s.value.poster) return '';
  return getImageUrl(s.value.poster);
});

const hasVideo = computed(() => Boolean(embedUrl.value || html5Src.value));

// Aspect ratio classes & styles
const ratioClass = computed(() => {
  const r = s.value.aspectRatio || '16:9';
  if (r === '16:9') return 'ratio-16x9';
  if (r === '4:3') return 'ratio-4x3';
  if (r === '1:1') return 'ratio-1x1';
  if (r === '21:9') return 'ratio-21x9';
  return '';
});

const customRatioStyle = computed(() => {
  const r = s.value.aspectRatio;
  if (!r || r === '16:9' || r === '4:3' || r === '1:1' || r === '21:9' || r === 'auto') {
    return {};
  }
  return { aspectRatio: r };
});
</script>

<style scoped>
.border-dashed {
  border: 2px dashed #cbd5e1 !important;
}
.bg-danger-soft {
  background: #fee2e2;
}
.ratio {
  position: relative;
  width: 100%;
}
.ratio::before {
  display: block;
  padding-top: var(--bs-aspect-ratio, 56.25%);
  content: "";
}
.ratio-16x9::before {
  padding-top: 56.25%;
}
.ratio-4x3::before {
  padding-top: 75%;
}
.ratio-1x1::before {
  padding-top: 100%;
}
.ratio-21x9::before {
  padding-top: 42.857%;
}
.ratio > * {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
</style>
