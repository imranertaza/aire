<template>
  <div class="video-inspector">
    <!-- CONTENT TAB -->
    <div v-if="activeTab === 'content'">
      <!-- Video Source Selector -->
      <div class="form-group mb-3">
        <label class="small font-weight-bold text-dark">Video Source</label>
        <div class="btn-group btn-group-sm w-100" role="group">
          <button
            type="button"
            class="btn font-weight-bold"
            :class="(!settings.source || settings.source === 'youtube') ? 'btn-danger text-white' : 'btn-outline-secondary bg-white'"
            @click="settings.source = 'youtube'"
          >
            <i class="fab fa-youtube mr-1"></i> YouTube
          </button>
          <button
            type="button"
            class="btn font-weight-bold"
            :class="settings.source === 'vimeo' ? 'btn-info text-white' : 'btn-outline-secondary bg-white'"
            @click="settings.source = 'vimeo'"
          >
            <i class="fab fa-vimeo-v mr-1"></i> Vimeo
          </button>
          <button
            type="button"
            class="btn font-weight-bold"
            :class="settings.source === 'html5' ? 'btn-primary text-white' : 'btn-outline-secondary bg-white'"
            @click="settings.source = 'html5'"
          >
            <i class="fas fa-file-video mr-1"></i> MP4 Video
          </button>
        </div>
      </div>

      <!-- Video URL / ID Input -->
      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark d-flex align-items-center justify-content-between mb-1">
          <span>
            {{ settings.source === 'youtube' ? 'YouTube URL or Video ID' : (settings.source === 'vimeo' ? 'Vimeo URL or Video ID' : 'Direct Video URL (.mp4 / storage)') }}
          </span>
          <button
            v-if="settings.source === 'html5'"
            type="button"
            class="btn btn-xs btn-outline-primary"
            @click="$emit('open-media', 'url')"
          >
            <i class="fas fa-folder-open mr-1"></i> Media Library
          </button>
        </label>
        <input
          v-model="settings.url"
          type="text"
          class="form-control form-control-sm"
          :placeholder="settings.source === 'youtube' ? 'https://www.youtube.com/watch?v=... or ID' : (settings.source === 'vimeo' ? 'https://vimeo.com/... or ID' : '/storage/uploads/video.mp4')"
        />
        <small class="form-text text-muted" style="font-size: 0.72rem;">
          <i class="fas fa-info-circle mr-1"></i>
          {{ settings.source === 'youtube' ? 'Supports full watch, share, shorts, or 11-char ID.' : (settings.source === 'vimeo' ? 'Supports Vimeo link or numeric video ID.' : 'Direct link to MP4 or WebM video file.') }}
        </small>
      </div>

      <!-- Poster Image (for HTML5) -->
      <div class="form-group mb-2" v-if="settings.source === 'html5'">
        <label class="small font-weight-bold text-dark d-flex align-items-center justify-content-between mb-1">
          <span>Poster Thumbnail Image (Optional)</span>
          <button type="button" class="btn btn-xs btn-outline-secondary" @click="$emit('open-media', 'poster')">
            <i class="fas fa-image mr-1"></i> Browse
          </button>
        </label>
        <input
          v-model="settings.poster"
          type="text"
          class="form-control form-control-sm"
          placeholder="storage/uploads/...jpg"
        />
      </div>

      <!-- Caption -->
      <div class="form-group mb-3">
        <label class="small font-weight-bold text-dark">Video Caption (Optional)</label>
        <input
          v-model="settings.caption"
          type="text"
          class="form-control form-control-sm"
          placeholder="e.g. AIRE Airflow Dynamics in Laboratory"
        />
      </div>

      <!-- Playback Controls Card -->
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-sliders-h mr-1 text-primary"></i> Playback Settings
        </h6>

        <!-- Autoplay Switch -->
        <div class="custom-control custom-switch mb-2">
          <input
            type="checkbox"
            v-model="settings.autoplay"
            class="custom-control-input"
            :id="'vidAutoplayCheck_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'vidAutoplayCheck_' + block.id">
            Autoplay Video
          </label>
          <small class="text-muted d-block" style="font-size: 0.7rem;">Browser policy automatically mutes autoplaying videos.</small>
        </div>

        <!-- Loop Switch -->
        <div class="custom-control custom-switch mb-2">
          <input
            type="checkbox"
            v-model="settings.loop"
            class="custom-control-input"
            :id="'vidLoopCheck_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'vidLoopCheck_' + block.id">
            Loop Video (Replay continuously)
          </label>
        </div>

        <!-- Controls Switch -->
        <div class="custom-control custom-switch mb-2">
          <input
            type="checkbox"
            v-model="settings.controls"
            class="custom-control-input"
            :id="'vidControlsCheck_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'vidControlsCheck_' + block.id">
            Show Player Controls (Play / Pause / Volume)
          </label>
        </div>

        <!-- Muted Switch -->
        <div class="custom-control custom-switch mb-0">
          <input
            type="checkbox"
            v-model="settings.muted"
            class="custom-control-input"
            :id="'vidMutedCheck_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'vidMutedCheck_' + block.id">
            Start Muted
          </label>
        </div>
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
            <option value="900px">Wide (900px)</option>
            <option value="800px">Standard Video (800px)</option>
            <option value="650px">Medium (650px)</option>
            <option value="500px">Compact (500px)</option>
          </select>
        </div>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Aspect Ratio</label>
          <select v-model="settings.aspectRatio" class="form-control form-control-sm">
            <option value="16:9">16:9 (Standard Widescreen HD)</option>
            <option value="4:3">4:3 (Classic TV)</option>
            <option value="1:1">1:1 (Square / Reel)</option>
            <option value="21:9">21:9 (Cinematic Ultra-Wide)</option>
            <option value="auto">Auto / Natural</option>
          </select>
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
                <option value="rounded-5">Large (24px)</option>
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
