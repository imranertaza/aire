<template>
  <teleport to="body">
    <div v-if="show" class="builder-media-backdrop" @click.self="close">
      <div class="builder-media-dialog modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">
          
          <!-- Modal Header -->
          <div class="modal-header bg-white px-4 py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
            <div class="d-flex align-items-center">
              <i class="fas fa-photo-video text-primary mr-2" style="font-size: 1.25rem;"></i>
              <h5 class="modal-title font-weight-bold mb-0 text-dark">Media Library</h5>
              <span class="badge badge-light border ml-2 text-muted px-2 py-1">{{ filteredFiles.length }} Files</span>
            </div>

            <!-- Search, Filter & Folder Controls in Header -->
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
              <!-- Type Filter Pills -->
              <div class="btn-group btn-group-sm" role="group">
                <button
                  type="button"
                  class="btn btn-sm"
                  :class="activeTypeFilter === 'all' ? 'btn-primary font-weight-bold' : 'btn-outline-secondary bg-white'"
                  @click="activeTypeFilter = 'all'"
                >
                  All ({{ counts.all }})
                </button>
                <button
                  type="button"
                  class="btn btn-sm"
                  :class="activeTypeFilter === 'image' ? 'btn-primary font-weight-bold' : 'btn-outline-secondary bg-white'"
                  @click="activeTypeFilter = 'image'"
                >
                  <i class="fas fa-image mr-1"></i>Images ({{ counts.image }})
                </button>
                <button
                  type="button"
                  class="btn btn-sm"
                  :class="activeTypeFilter === 'video' ? 'btn-primary font-weight-bold' : 'btn-outline-secondary bg-white'"
                  @click="activeTypeFilter = 'video'"
                >
                  <i class="fas fa-video mr-1"></i>Videos ({{ counts.video }})
                </button>
                <button
                  type="button"
                  class="btn btn-sm"
                  :class="activeTypeFilter === 'document' ? 'btn-primary font-weight-bold' : 'btn-outline-secondary bg-white'"
                  @click="activeTypeFilter = 'document'"
                >
                  <i class="fas fa-file-alt mr-1"></i>Docs ({{ counts.document }})
                </button>
              </div>

              <!-- Search -->
              <div class="input-group input-group-sm" style="width: 180px;">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-light border-right-0"><i class="fas fa-search text-muted"></i></span>
                </div>
                <input
                  v-model="searchQuery"
                  type="text"
                  class="form-control border-left-0 bg-light"
                  placeholder="Search files..."
                />
              </div>

              <!-- Folder Select -->
              <select v-model="currentFolder" @change="loadFiles" class="custom-select custom-select-sm" style="width: 140px;">
                <option value="uploads">storage/uploads</option>
                <option value="sections/builder">storage/sections</option>
              </select>

              <button type="button" class="close text-muted ml-1" @click="close" style="line-height: 1; outline: none; font-size: 1.5rem;">
                <span>&times;</span>
              </button>
            </div>
          </div>

          <!-- Modal Body -->
          <div class="modal-body p-0 d-flex flex-column" style="height: 68vh; min-height: 480px; max-height: 650px;">
            
            <!-- Upload Drop Area Container -->
            <div class="px-4 py-3 bg-white border-bottom">
              <div
                class="builder-drop-area p-3 rounded-3 text-center transition-all"
                :class="{ 'drop-active': isDragging }"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="handleFileDrop"
              >
                <input
                  type="file"
                  ref="fileInputRef"
                  id="builder-media-file-input"
                  class="d-none"
                  accept="image/*,video/*,audio/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.rtf,.zip,.rar,.7z"
                  multiple
                  @change="handleFileInput"
                />
                <label for="builder-media-file-input" class="mb-0 cursor-pointer d-flex align-items-center justify-content-center flex-column py-1">
                  <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-1"></i>
                  <span class="small font-weight-bold text-dark">Drag & drop files here, or <span class="text-primary text-decoration-underline">Browse</span></span>
                  <span class="text-muted" style="font-size: 0.75rem;">Supports Images (JPG, PNG, WEBP, SVG), Videos (MP4, WEBM, MOV), PDFs, Docs, Sheets & Archives up to 500MB</span>
                </label>

                <!-- Uploading progress feedback -->
                <div v-if="isUploading" class="mt-2 text-center">
                  <span class="spinner-border spinner-border-sm text-primary mr-1" role="status"></span>
                  <span class="small font-weight-bold text-primary">{{ uploadStatusMessage }}</span>
                </div>
              </div>
            </div>

            <!-- Loading State -->
            <div v-if="loadingFiles" class="flex-grow-1 d-flex align-items-center justify-content-center flex-column py-5">
              <div class="spinner-border text-primary mb-2" role="status"></div>
              <span class="text-muted small">Loading media library...</span>
            </div>

            <!-- Empty State -->
            <div v-else-if="filteredFiles.length === 0" class="flex-grow-1 d-flex align-items-center justify-content-center flex-column py-5 text-muted">
              <i class="far fa-folder-open fa-3x mb-2 opacity-50"></i>
              <p class="mb-1 font-weight-bold">No files found in this folder</p>
              <small>Upload files using the box above to get started.</small>
            </div>

            <!-- Files Grid -->
            <div v-else class="builder-media-grid p-4 flex-grow-1 overflow-auto">
              <div
                v-for="file in filteredFiles"
                :key="file.path"
                class="builder-media-card position-relative rounded-3 border overflow-hidden"
                :class="{ 'card-selected': selectedFile?.path === file.path }"
                @click="selectedFile = file"
                @dblclick="confirmSelect(file)"
              >
                <!-- Thumbnail wrapper -->
                <div class="media-thumb-wrapper bg-light d-flex align-items-center justify-content-center position-relative">
                  
                  <!-- 1. IMAGE -->
                  <img
                    v-if="file.category === 'image'"
                    :src="file.url"
                    :alt="file.name"
                    class="media-thumb-img"
                    loading="lazy"
                    @error="onImageError($event)"
                  />

                  <!-- 2. VIDEO -->
                  <div v-else-if="file.category === 'video'" class="media-thumb-video-wrapper w-100 h-100 position-relative bg-dark d-flex align-items-center justify-content-center">
                    <video :src="file.url" preload="metadata" muted class="media-thumb-video"></video>
                    <div class="video-play-overlay">
                      <i class="fas fa-play-circle text-white fa-2x" style="opacity: 0.9;"></i>
                    </div>
                    <span class="badge badge-danger position-absolute" style="top: 6px; left: 6px; font-size: 9px; letter-spacing: 0.5px;">
                      <i class="fas fa-video mr-1"></i>{{ file.type.toUpperCase() }}
                    </span>
                  </div>

                  <!-- 3. DOCUMENT -->
                  <div v-else-if="file.category === 'document'" class="media-doc-wrapper bg-light d-flex flex-column align-items-center justify-content-center p-2 text-center w-100 h-100">
                    <i v-if="file.type === 'pdf'" class="fas fa-file-pdf text-danger fa-3x mb-2"></i>
                    <i v-else-if="['doc', 'docx'].includes(file.type)" class="fas fa-file-word text-primary fa-3x mb-2"></i>
                    <i v-else-if="['xls', 'xlsx', 'csv'].includes(file.type)" class="fas fa-file-excel text-success fa-3x mb-2"></i>
                    <i v-else-if="['ppt', 'pptx'].includes(file.type)" class="fas fa-file-powerpoint text-warning fa-3x mb-2"></i>
                    <i v-else class="fas fa-file-alt text-info fa-3x mb-2"></i>
                    <span class="badge" :class="getDocBadgeClass(file.type)" style="font-size: 9px;">{{ file.type.toUpperCase() }}</span>
                  </div>

                  <!-- 4. AUDIO -->
                  <div v-else-if="file.category === 'audio'" class="media-doc-wrapper bg-light d-flex flex-column align-items-center justify-content-center p-2 text-center w-100 h-100">
                    <i class="fas fa-file-audio text-warning fa-3x mb-2"></i>
                    <span class="badge badge-warning" style="font-size: 9px;">AUDIO</span>
                  </div>

                  <!-- 5. ARCHIVES & OTHER -->
                  <div v-else class="media-doc-wrapper bg-light d-flex flex-column align-items-center justify-content-center p-2 text-center w-100 h-100">
                    <i v-if="['zip', 'rar', '7z', 'tar', 'gz'].includes(file.type)" class="fas fa-file-archive text-secondary fa-3x mb-2"></i>
                    <i v-else class="fas fa-file text-muted fa-3x mb-2"></i>
                    <span class="badge badge-secondary" style="font-size: 9px;">{{ file.type.toUpperCase() }}</span>
                  </div>
                  
                  <!-- Selected Badge Checkmark -->
                  <div v-if="selectedFile?.path === file.path" class="selected-badge shadow-sm">
                    <i class="fas fa-check"></i>
                  </div>
                </div>

                <!-- File Info Footer -->
                <div class="media-card-info p-2 bg-white d-flex align-items-center justify-content-between">
                  <div class="text-truncate mr-1 text-dark" style="font-size: 0.72rem; font-weight: 500;" :title="file.name">
                    {{ file.name }}
                  </div>
                  <button
                    type="button"
                    class="btn btn-xs btn-link text-danger p-0 delete-btn"
                    @click.stop="deleteMediaFile(file)"
                    title="Delete permanently"
                  >
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="modal-footer bg-white px-4 py-3 border-top d-flex align-items-center justify-content-between">
            <div class="small text-truncate" style="max-width: 480px;">
              <span v-if="selectedFile" class="text-dark font-weight-bold d-inline-flex align-items-center">
                <i class="fas fa-check-circle text-success mr-1"></i>
                Selected: <span class="text-primary ml-1 text-truncate" style="max-width: 320px;">{{ selectedFile.name }}</span>
                <span class="badge badge-secondary ml-2" style="font-size: 10px;">{{ selectedFile.type?.toUpperCase() }}</span>
              </span>
              <span v-else class="text-muted">
                <i class="fas fa-info-circle mr-1"></i> Select a file from the library or upload a new one.
              </span>
            </div>

            <div class="d-flex align-items-center">
              <button type="button" class="btn btn-sm btn-light border px-3 mr-2" @click="close">
                Cancel
              </button>
              <button
                type="button"
                class="btn btn-sm btn-primary px-4 shadow-sm font-weight-bold"
                :disabled="!selectedFile"
                @click="confirmSelect(selectedFile)"
              >
                <i class="fas fa-check mr-1"></i> Insert File
              </button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </teleport>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import axios from 'axios';
import { getImageUrl } from '@/layouts/helpers/helpers';
import { useToast } from '@/composables/useToast';

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  currentValue: {
    type: String,
    default: ''
  }
});

const emit = defineEmits(['close', 'select']);
const toast = useToast();

const fileItems = ref([]);
const currentFolder = ref('uploads');
const searchQuery = ref('');
const activeTypeFilter = ref('all');
const selectedFile = ref(null);
const loadingFiles = ref(false);
const isUploading = ref(false);
const isDragging = ref(false);
const uploadStatusMessage = ref('');
const fileInputRef = ref(null);

// Supported Extension Sets
const IMAGE_EXTS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico', 'tiff', 'avif'];
const VIDEO_EXTS = ['mp4', 'mov', 'avi', 'mkv', 'webm', 'ogg', 'wmv', 'flv', 'm4v', '3gp'];
const AUDIO_EXTS = ['mp3', 'wav', 'm4a', 'aac', 'flac', 'ogg'];
const DOC_EXTS = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'rtf', 'odt', 'ods', 'odp'];

function getFileCategory(ext) {
  if (IMAGE_EXTS.includes(ext)) return 'image';
  if (VIDEO_EXTS.includes(ext)) return 'video';
  if (AUDIO_EXTS.includes(ext)) return 'audio';
  if (DOC_EXTS.includes(ext)) return 'document';
  return 'other';
}

function getDocBadgeClass(ext) {
  if (ext === 'pdf') return 'badge-danger';
  if (['doc', 'docx'].includes(ext)) return 'badge-primary';
  if (['xls', 'xlsx', 'csv'].includes(ext)) return 'badge-success';
  if (['ppt', 'pptx'].includes(ext)) return 'badge-warning';
  return 'badge-info';
}

// Counts per category
const counts = computed(() => {
  const c = { all: fileItems.value.length, image: 0, video: 0, document: 0, audio: 0, other: 0 };
  fileItems.value.forEach(f => {
    if (c[f.category] !== undefined) c[f.category]++;
    else c.other++;
  });
  return c;
});

// Filter by search query and category
const filteredFiles = computed(() => {
  let list = fileItems.value;
  if (activeTypeFilter.value !== 'all') {
    list = list.filter(f => f.category === activeTypeFilter.value);
  }
  if (searchQuery.value) {
    const q = searchQuery.value.toLowerCase().trim();
    list = list.filter(f => f.name.toLowerCase().includes(q));
  }
  return list;
});

// Watch when modal opens to load files
watch(() => props.show, (newVal) => {
  if (newVal) {
    loadFiles();
  } else {
    selectedFile.value = null;
    searchQuery.value = '';
    activeTypeFilter.value = 'all';
  }
});

// Load media files from API
async function loadFiles() {
  loadingFiles.value = true;
  try {
    const { data } = await axios.get('/api/media', {
      params: { folder: currentFolder.value }
    });

    const files = data.files || [];
    fileItems.value = files.map(path => {
      const name = path.split('/').pop();
      const ext = name.split('.').pop().toLowerCase();
      return {
        name,
        path,
        url: getImageUrl(path),
        type: ext,
        category: getFileCategory(ext)
      };
    });

    // If currentValue was passed, attempt to match it
    if (props.currentValue) {
      const matched = fileItems.value.find(f => props.currentValue.includes(f.name) || props.currentValue === f.url || props.currentValue === f.path);
      if (matched) selectedFile.value = matched;
    }
  } catch (error) {
    console.error('Failed to load media items', error);
  } finally {
    loadingFiles.value = false;
  }
}

// Handle single / multiple file uploads
async function uploadFiles(files) {
  if (!files || !files.length) return;

  isUploading.value = true;
  uploadStatusMessage.value = `Uploading ${files.length} file(s)...`;

  try {
    for (const file of files) {
      const formData = new FormData();
      formData.append('file', file);
      formData.append('folder', currentFolder.value);

      const { data } = await axios.post('/api/media/upload', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });

      const ext = (data.type || file.name.split('.').pop()).toLowerCase();
      const newFileObj = {
        name: data.path.split('/').pop(),
        path: data.path,
        url: data.url || getImageUrl(data.path),
        type: ext,
        category: getFileCategory(ext)
      };

      fileItems.value.unshift(newFileObj);
      selectedFile.value = newFileObj;
    }

    toast.success('File uploaded successfully!');
  } catch (error) {
    console.error('Upload error', error);
    const errorMsg = error.response?.data?.message || 'Failed to upload file. Please try again.';
    toast.error(errorMsg);
  } finally {
    isUploading.value = false;
    isDragging.value = false;
    if (fileInputRef.value) fileInputRef.value.value = '';
  }
}

function handleFileInput(e) {
  uploadFiles(e.target.files);
}

function handleFileDrop(e) {
  isDragging.value = false;
  uploadFiles(e.dataTransfer.files);
}

// Delete media file
async function deleteMediaFile(file) {
  if (!confirm(`Are you sure you want to permanently delete "${file.name}"?`)) return;

  try {
    await axios.delete('/api/media/file', { data: { path: file.path } });
    fileItems.value = fileItems.value.filter(f => f.path !== file.path);
    if (selectedFile.value?.path === file.path) {
      selectedFile.value = null;
    }
    toast.info('File deleted from storage');
  } catch (error) {
    console.error('Failed to delete file', error);
    toast.error('Could not delete file');
  }
}

// Confirm Selection
function confirmSelect(file) {
  if (!file) return;
  emit('select', {
    url: file.url,
    path: file.path,
    name: file.name,
    type: file.type,
    category: file.category
  });
  close();
}

function close() {
  emit('close');
}

function onImageError(e) {
  e.target.src = '/themes/default/assets/img/photograph.webp';
}
</script>

<style scoped>
.builder-media-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.7);
  backdrop-filter: blur(4px);
  z-index: 1060;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: fadeIn 0.15s ease-out;
}

.builder-media-dialog {
  width: 95%;
  max-width: 1140px;
  margin: 0;
}

.builder-drop-area {
  border: 2px dashed #cbd5e1;
  background-color: #f8fafc;
  cursor: pointer;
}

.builder-drop-area:hover,
.builder-drop-area.drop-active {
  border-color: #0095DA;
  background-color: #f0f9ff;
}

.cursor-pointer {
  cursor: pointer;
}

.builder-media-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
  gap: 12px;
  align-content: start;
}

.builder-media-grid::-webkit-scrollbar {
  width: 6px;
}
.builder-media-grid::-webkit-scrollbar-track {
  background: #f8fafc;
}
.builder-media-grid::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}
.builder-media-grid::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

.builder-media-card {
  cursor: pointer;
  display: flex;
  flex-direction: column;
  height: auto !important;
  max-height: max-content !important;
  align-self: start !important;
  transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
  background: #ffffff;
}

.builder-media-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  border-color: #94a3b8 !important;
}

.builder-media-card.card-selected {
  border-color: #0095DA !important;
  box-shadow: 0 0 0 2px rgba(0, 149, 218, 0.4) !important;
}

.media-thumb-wrapper {
  height: 120px;
  width: 100%;
  position: relative;
  overflow: hidden;
  background: #f8fafc;
  display: flex;
  align-items: center;
  justify-content: center;
}

.media-thumb-img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  padding: 6px;
  transition: transform 0.2s ease;
}

.builder-media-card:hover .media-thumb-img {
  transform: scale(1.05);
}

.media-thumb-video-wrapper {
  width: 100%;
  height: 100%;
  background: #0f172a;
}

.media-thumb-video {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.video-play-overlay {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 0, 0, 0.25);
  transition: background 0.2s ease;
}

.builder-media-card:hover .video-play-overlay {
  background: rgba(0, 0, 0, 0.4);
}

.media-doc-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  width: 100%;
  padding: 8px;
}

.selected-badge {
  position: absolute;
  top: 6px;
  right: 6px;
  width: 22px;
  height: 22px;
  border-radius: 50%;
  background: #0095DA;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  z-index: 5;
}

.delete-btn {
  opacity: 0.4;
  transition: opacity 0.15s ease;
}

.builder-media-card:hover .delete-btn {
  opacity: 1;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>
