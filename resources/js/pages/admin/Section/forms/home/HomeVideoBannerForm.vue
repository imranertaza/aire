<template>
    <div class="home-video-banner-form video-editor-wrapper">
        <div class="card video-master-card border-0 shadow-sm mb-4">
            <!-- Premium Header -->
            <div class="card-header video-editor-header py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="video-header-badge mr-3">
                        <i class="fas fa-film"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 font-weight-bold text-dark">Homepage Video Banner</h4>
                        <p class="text-muted small mb-0">Manage headline, video media stream, local uploads, and poster artwork</p>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge badge-pill badge-light-danger border text-danger mr-3 px-3 py-2 font-weight-bold d-none d-md-inline-flex align-items-center">
                        <i class="fas fa-circle mr-1 small text-danger pulse-dot"></i> Live on Storefront
                    </span>
                    <button type="button" @click="$emit('save')" class="btn btn-primary px-4 shadow-sm font-weight-bold" :disabled="saving">
                        <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving Changes...' : 'Save Video Section' }}
                    </button>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row">
                    <!-- Left Column: Controls (7 Cols) -->
                    <div class="col-xl-7 col-lg-6 col-md-12">
                        <!-- Card 1: Headline -->
                        <div class="card setting-card mb-4 border shadow-none">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="setting-step-num mr-2">1</div>
                                    <label class="font-weight-bold text-dark mb-0">Headline & Section Title <span class="text-danger">*</span></label>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0 text-muted">
                                            <i class="fas fa-heading"></i>
                                        </span>
                                    </div>
                                    <input v-model="form.title" type="text" class="form-control border-left-0 pl-0 font-weight-500"
                                        placeholder="e.g. AIRE Pro S1 — Engineering Architecture & Air Purification" required />
                                </div>
                                <small class="form-text text-muted mt-1">This title is displayed on the homepage right above the video frame.</small>
                            </div>
                        </div>

                        <!-- Card 2: Video Source Switcher -->
                        <div class="card setting-card mb-4 border shadow-none">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="setting-step-num mr-2">2</div>
                                        <label class="font-weight-bold text-dark mb-0">Video Media Source <span class="text-danger">*</span></label>
                                    </div>
                                    <!-- Pill Tab Switcher -->
                                    <div class="video-tab-switcher p-1 bg-light rounded-pill border d-inline-flex">
                                        <button type="button" class="btn btn-xs rounded-pill px-3 py-1 font-weight-bold transition-all"
                                            :class="videoSourceMode === 'url' ? 'btn-white shadow-sm text-primary' : 'text-muted border-0 bg-transparent'"
                                            @click="videoSourceMode = 'url'">
                                            <i class="fas fa-link mr-1"></i> Direct URL / Path
                                        </button>
                                        <button type="button" class="btn btn-xs rounded-pill px-3 py-1 font-weight-bold transition-all"
                                            :class="videoSourceMode === 'upload' ? 'btn-white shadow-sm text-primary' : 'text-muted border-0 bg-transparent'"
                                            @click="videoSourceMode = 'upload'">
                                            <i class="fas fa-cloud-upload-alt mr-1"></i> Upload Video File
                                        </button>
                                    </div>
                                </div>

                                <!-- Sub-view A: URL / Path Input -->
                                <div v-show="videoSourceMode === 'url'" class="source-panel p-3 rounded bg-light border">
                                    <label class="small font-weight-bold text-muted mb-2 text-uppercase">Relative Storage Path or External Link</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0 text-muted">
                                                <i class="fas fa-globe"></i>
                                            </span>
                                        </div>
                                        <input v-model="form.video_url" type="text" class="form-control border-left-0 pl-0 font-monospace"
                                            placeholder="storage/home/home-video.mp4 or https://cdn.example.com/video.mp4" />
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" title="Reset to default local path"
                                                @click="form.video_url = 'storage/home/home-video.mp4'">
                                                <i class="fas fa-undo mr-1"></i> Default
                                            </button>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Enter a storage path (e.g. <code>storage/home/home-video.mp4</code>) or direct HTTPS URL.</small>
                                        <span class="badge badge-light border text-muted">Direct Stream</span>
                                    </div>
                                </div>

                                <!-- Sub-view B: File Drag & Drop Upload Zone -->
                                <div v-show="videoSourceMode === 'upload'" class="source-panel">
                                    <input type="file" ref="videoFileInput" accept="video/mp4,video/webm,video/ogg,video/quicktime"
                                        @change="handleVideoFileChange" class="d-none" />

                                    <div class="video-drop-area text-center p-4 rounded"
                                        :class="{ 'is-dragging': isDraggingVideo, 'has-file': videoFile }"
                                        @dragover.prevent="isDraggingVideo = true"
                                        @dragleave.prevent="isDraggingVideo = false"
                                        @drop.prevent="handleVideoDrop"
                                        @click="triggerVideoBrowse">

                                        <div v-if="videoFile" class="file-chosen-box">
                                            <div class="video-icon-circle bg-success-light text-success mx-auto mb-2">
                                                <i class="fas fa-check-circle fa-2x"></i>
                                            </div>
                                            <h6 class="font-weight-bold text-dark mb-1">{{ videoFile.name }}</h6>
                                            <p class="text-muted small mb-2">
                                                File size: <strong>{{ (videoFile.size / (1024 * 1024)).toFixed(2) }} MB</strong> • Ready to upload on save
                                            </p>
                                            <div class="d-inline-flex gap-2">
                                                <button type="button" class="btn btn-xs btn-outline-primary mr-2" @click.stop="triggerVideoBrowse">
                                                    <i class="fas fa-sync-alt mr-1"></i> Choose Different Video
                                                </button>
                                                <button type="button" class="btn btn-xs btn-outline-danger" @click.stop="cancelVideoFile">
                                                    <i class="fas fa-times mr-1"></i> Remove
                                                </button>
                                            </div>
                                        </div>

                                        <div v-else-if="form.video_file" class="server-file-box">
                                            <div class="video-icon-circle bg-primary-light text-primary mx-auto mb-2">
                                                <i class="fas fa-file-video fa-2x"></i>
                                            </div>
                                            <h6 class="font-weight-bold text-dark mb-1">Server Video Active</h6>
                                            <code class="small text-muted d-block mb-3 font-monospace">{{ form.video_file }}</code>
                                            <div class="d-inline-flex gap-2">
                                                <button type="button" class="btn btn-xs btn-outline-primary mr-2" @click.stop="triggerVideoBrowse">
                                                    <i class="fas fa-upload mr-1"></i> Replace With New Video
                                                </button>
                                                <button type="button" class="btn btn-xs btn-outline-danger" @click.stop="removeServerVideo">
                                                    <i class="fas fa-trash-alt mr-1"></i> Remove Server Video
                                                </button>
                                            </div>
                                        </div>

                                        <div v-else class="drop-prompt-box">
                                            <div class="video-icon-circle bg-light text-muted mx-auto mb-2">
                                                <i class="fas fa-cloud-upload-alt fa-2x"></i>
                                            </div>
                                            <h6 class="font-weight-bold text-dark mb-1">Drag & Drop Your Video Here</h6>
                                            <p class="text-muted small mb-2">Supports MP4, WebM, OGG up to 100MB</p>
                                            <button type="button" class="btn btn-sm btn-outline-primary" @click.stop="triggerVideoBrowse">
                                                <i class="fas fa-folder-open mr-1"></i> Browse Local File
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Video Poster Image -->
                        <div class="card setting-card mb-4 border shadow-none">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="setting-step-num mr-2">3</div>
                                    <label class="font-weight-bold text-dark mb-0">Video Cover Poster Artwork <span class="text-danger">*</span></label>
                                </div>
                                <Vue3Dropzone :model-value="posterFile" @update:model-value="$emit('update:posterFile', $event)"
                                    :previews="posterPreviews" @update:previews="$emit('update:posterPreviews', $event)"
                                    mode="edit" :allowSelectOnPreview="true" :maxFiles="1" />
                                <small class="form-text text-muted mt-1">Recommended: 1920 × 1080px (16:9 Landscape Artwork). Displays prior to video playback.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Live Video Monitor Preview (5 Cols) -->
                    <div class="col-xl-5 col-lg-6 col-md-12">
                        <div class="cinema-monitor-card sticky-top shadow-lg rounded-xl overflow-hidden border" style="top: 20px;">
                            <div class="cinema-top-bar px-3 py-2 bg-dark d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="cinema-dot bg-danger mr-1"></span>
                                    <span class="cinema-dot bg-warning mr-1"></span>
                                    <span class="cinema-dot bg-success mr-2"></span>
                                    <span class="small font-weight-bold text-white-50 text-uppercase tracking-wider">Live Video Stream</span>
                                </div>
                                <span class="badge badge-light-danger px-2 py-0 font-weight-bold text-xs">
                                    HD 1080p
                                </span>
                            </div>

                            <div class="cinema-screen-box position-relative bg-black">
                                <video :src="previewVideoUrl" :poster="previewPosterUrl"
                                    controls preload="metadata" class="w-100 d-block video-player-element" style="max-height: 280px; object-fit: cover;">
                                </video>
                                <div class="cinema-title-overlay">
                                    <span class="badge badge-dark bg-black-alpha border border-white-10 text-white font-weight-normal px-2 py-1">
                                        <i class="fas fa-eye mr-1 text-primary"></i> {{ form.title || 'Untitled Section' }}
                                    </span>
                                </div>
                            </div>

                            <div class="cinema-footer p-3 bg-dark-slate text-white-50">
                                <div class="row text-center text-xs">
                                    <div class="col-4 border-right border-secondary">
                                        <div class="text-muted text-uppercase mb-1">Source</div>
                                        <div class="text-white font-weight-bold text-truncate" :title="activeSourceLabel">
                                            {{ activeSourceLabel }}
                                        </div>
                                    </div>
                                    <div class="col-4 border-right border-secondary">
                                        <div class="text-muted text-uppercase mb-1">Cover Poster</div>
                                        <div class="text-white font-weight-bold text-truncate">
                                            {{ posterPreviews && posterPreviews[0] ? 'Custom' : 'Default' }}
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-muted text-uppercase mb-1">Ratio</div>
                                        <div class="text-white font-weight-bold">16 : 9 Cinema</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0 shadow-none mt-3 p-3 text-muted small rounded-lg">
                            <div class="d-flex">
                                <i class="fas fa-lightbulb text-warning fa-lg mr-2 mt-1"></i>
                                <div>
                                    <strong>Design Tip:</strong> On the storefront, the video features custom sound/mute and play/pause controls, autoplay with intersection observer, and smooth zoom overlay on hover.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Action Bar -->
            <div class="card-footer bg-light px-4 py-3 d-flex justify-content-between align-items-center">
                <router-link :to="{ name: 'Section' }" class="btn btn-outline-secondary px-3">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Sections
                </router-link>
                <div class="d-flex align-items-center">
                    <span v-if="saving" class="text-muted small mr-3">
                        <i class="fas fa-spinner fa-spin mr-1"></i> Updating section...
                    </span>
                    <button type="button" @click="$emit('save')" class="btn btn-primary px-4 shadow-sm" :disabled="saving">
                        <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving Changes...' : 'Save & Publish Video' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import { useToast } from '@/composables/useToast';
import { getImageUrl } from '@/layouts/helpers/helpers';

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    saving: {
        type: Boolean,
        default: false,
    },
    videoFile: {
        type: [File, Object, null],
        default: null,
    },
    posterFile: {
        type: Array,
        default: () => [],
    },
    posterPreviews: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(['save', 'update:videoFile', 'update:removeVideo', 'update:posterFile', 'update:posterPreviews']);
const toast = useToast();

const videoSourceMode = ref(props.form.video_file ? 'upload' : 'url');
const isDraggingVideo = ref(false);
const videoFileInput = ref(null);

const triggerVideoBrowse = () => {
    videoFileInput.value?.click();
};

const handleVideoFileChange = (e) => {
    const file = e.target.files?.[0];
    if (file) {
        emit('update:videoFile', file);
        emit('update:removeVideo', false);
    }
};

const handleVideoDrop = (e) => {
    isDraggingVideo.value = false;
    const file = e.dataTransfer?.files?.[0];
    if (file && /\.(mp4|webm|ogg|mov)$/i.test(file.name)) {
        emit('update:videoFile', file);
        emit('update:removeVideo', false);
    } else if (file) {
        toast.error('Please drop a valid video file (.mp4, .webm, .ogg, .mov)');
    }
};

const cancelVideoFile = () => {
    emit('update:videoFile', null);
    if (videoFileInput.value) {
        videoFileInput.value.value = "";
    }
};

const removeServerVideo = () => {
    props.form.video_file = '';
    emit('update:removeVideo', true);
};

const activeSourceLabel = computed(() => {
    if (props.videoFile) {
        return 'Local ' + props.videoFile.name;
    }
    if (props.form.video_file) {
        return 'Server Video';
    }
    if (props.form.video_url) {
        return props.form.video_url.startsWith('http') ? 'External Stream' : 'Local Path';
    }
    return 'Default MP4';
});

const previewPosterUrl = computed(() => {
    if (props.posterPreviews && props.posterPreviews[0]) {
        return props.posterPreviews[0];
    }
    if (props.form.image) {
        return getImageUrl(props.form.image);
    }
    return getImageUrl('home/video_thumb.png');
});

const previewVideoUrl = computed(() => {
    if (props.videoFile) {
        return URL.createObjectURL(props.videoFile);
    }
    if (props.form.video_file) {
        const v = props.form.video_file;
        return v.startsWith('http') ? v : (v.startsWith('/storage') ? v : '/storage/' + v.replace(/^\//, ''));
    }
    if (props.form.video_url) {
        const u = props.form.video_url;
        if (u.startsWith('http')) return u;
        return u.startsWith('/') ? u : '/' + u;
    }
    return '/storage/home/home-video.mp4';
});
</script>
