<template>
    <div class="" :class="$attrs.class">
        <ckeditor v-model="internalValue" :editor="ClassicEditor" :config="config" @ready="onEditorReady" />
        <teleport to="body">
            <div v-if="show" class="fm-backdrop" @click.self="show = false">
                <div class="fm-modal">
                    <header class="fm-header">
                        <h2>Media Library</h2>
                        <button class="fm-close" @click="show = false" title="Close">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                            </svg>
                        </button>
                    </header>

                    <!-- Upload zone -->
                    <div class="fm-upload-zone">
                        <input type="file" multiple @change="handleUpload" accept="image/*,video/*,application/pdf"
                            id="fm-upload" />
                        <label for="fm-upload" class="fm-upload-label">
                            <svg viewBox="0 0 24 24" class="upload-icon">
                                <path
                                    d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z" />
                                <path d="M13 9h-2v3H8l4 4 4-4h-3V9z" />
                            </svg>
                            <span>Drop files here or click to upload</span>
                        </label>

                        <!-- Progress feedback -->
                        <div v-if="isUploading" class="fm-progress">
                            <p>{{ uploadMessage }}</p>
                            <!-- <progress :value="uploadProgress" max="100"></progress> -->
                        </div>
                    </div>

                    <!-- File grid -->
                    <div class="fm-grid">
                        <div v-for="file in fileItems" :key="file.path" class="fm-item rounded">
                            <div class="fm-thumb-wrapper border overflow-hidden rounded" style="width: 100%;" @click="selectFile(file)">
                                <!-- Image -->
                                <span v-if="['mp4', 'mov', 'avi', 'mkv'].includes(file.type)" class="badge badge-video">Video</span>
                                <img style="width: 100%;"
                                    v-if="['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(file.type)" :src="file.url"
                                    alt="" class="fm-thumb" />

                                <!-- Video -->
                                <video v-else-if="['mp4', 'mov', 'avi', 'mkv'].includes(file.type)" controls
                                    style="width: 100%;">
                                    <source :src="file.url" :type="'video/' + file.type" />
                                </video>

                                <!-- PDF -->
                                <div v-else-if="file.type === 'pdf'" class="fm-pdf">
                                    <span class="badge badge-video">Pdf</span>
                                     <span class="text-wrap">📄{{ file.name }}</span>
                                </div>

                                <!-- Unknown -->
                                <div v-else class="fm-unknown">
                                    ❓ {{ file.name }}
                                </div>

                                <div class="fm-check">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="fm-name">{{ file.name }}</p>
                            <div class="fm-actions">
                                <button @click.stop="deleteFile(file.path)" title="Delete">🗑️</button>
                            </div>
                        </div>
                    </div>

                    <footer class="fm-footer">
                        <button class="fm-btn-secondary" @click="show = false">Cancel</button>
                    </footer>
                </div>
            </div>
        </teleport>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import axios from 'axios';
import { getImageUrl } from '@/layouts/helpers/helpers';

import {
    ClassicEditor,
    Essentials,
    Paragraph,
    Bold,
    Italic,
    Heading,
    Link,
    List,
    Image,
    ImageCaption,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
    Table,
    TableToolbar,
    BlockQuote,
    MediaEmbed,
    SourceEditing,
    PictureEditing,
    FontColor,
    FontBackgroundColor,
    Underline,
    Strikethrough,
    Alignment,
    Indent,
    IndentBlock,
    Font,
    RemoveFormat,
    Autoformat
} from 'ckeditor5';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import FileManagerPlugin from '../plugins/FileManagerPlugin';
import 'ckeditor5/ckeditor5.css';

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: { type: String, default: '', readonly: false },
    placeholder: { type: String, default: 'Start typing...', readonly: false }
})
const internalValue = ref(props.modelValue)
watch(() => props.modelValue, (v) => internalValue.value = v)
watch(internalValue, (v) => emit('update:modelValue', v))

const show = ref(false);
const editorInstance = ref(null);
const fileItems = ref([]);
const currentFolder = ref('uploads');

// NEW: progress state
const uploadProgress = ref(0);
const uploadMessage = ref('');
const isUploading = ref(false);

// Load files from backend
const loadFiles = async () => {
    const { data } = await axios.get('/api/media', { params: { folder: currentFolder.value } });
    fileItems.value = data.files.map(path => {
        const name = path.split('/').pop();
        const ext = name.split('.').pop().toLowerCase();
        return {
            name,
            path,
            url: getImageUrl(path),
            type: ext
        };
    });
};

// Upload file with progress
const handleUpload = async (event) => {
  const files = event.target.files;
  if (!files || !files.length) return;

  for (const file of files) {
    const formData = new FormData();
    formData.append('file', file);
    formData.append('folder', currentFolder.value);

    try {
      isUploading.value = true;
      uploadMessage.value = "Uploading…";

      const { data } = await axios.post('/api/media/upload', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          'Accept': 'application/json'
        }
      });

      // Add uploaded file to grid
      fileItems.value.push({
        name: data.path.split('/').pop(),
        path: data.path,
        url: data.url,
        type: file.name.split('.').pop().toLowerCase()
      });

      // ✅ Success
      uploadMessage.value = "Upload complete!";
      isUploading.value = false;

      selectFile(fileItems.value[fileItems.value.length - 1]);
      show.value = false; // close modal
    } catch (error) {
      console.error(`Upload failed for ${file.name}`, error);
      uploadMessage.value = "Something went wrong, try again later.";
      isUploading.value = false;
    }
  }

  // Reset input so same files can be reselected later
  event.target.value = '';
};


// Delete file
const deleteFile = async (path) => {
    await axios.delete('/api/media/file', { data: { path } });
    await loadFiles();
};

const selectFile = (file) => {
    if (!editorInstance.value) return;
    const baseUrl = import.meta.env.VITE_APP_URL;
    editorInstance.value.model.change(writer => {
        let element;

        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(file.type)) {
            element = writer.createElement('imageBlock', { src: file.url });
            editorInstance.value.model.insertObject(element, editorInstance.value.model.document.selection);
        }
        else if (['mp4', 'mov', 'avi', 'mkv'].includes(file.type)) {
            element = writer.createElement('media', { url: `${baseUrl}${file.url}` });
            editorInstance.value.model.insertObject(element, editorInstance.value.model.document.selection);
        }
        else if (file.type === 'pdf') {
            const insertPosition = editorInstance.value.model.document.selection.getFirstPosition();
            const pdfName = file.name || 'PDF file';
            const pdfUrl = `${baseUrl}${file.url}`;

            const linkText = writer.createText(`📄 PDF: ${pdfName}`, { linkHref: pdfUrl });
            editorInstance.value.model.insertContent(linkText, insertPosition);
        }
        else {
            element = writer.createElement('paragraph', {});
            writer.insertText(`📁 File: ${file.url}`, element, 'end');
            editorInstance.value.model.insertContent(element, editorInstance.value.model.document.selection);
        }
    });

    show.value = false;
};

// CKEditor config
const config = computed(() => ({
    licenseKey: 'GPL',
    plugins: [
        Essentials, Paragraph, Bold, Italic, Underline, Strikethrough,
        Heading, Link, List, Font, FontColor, FontBackgroundColor,
        Alignment, Indent, IndentBlock,
        Image, ImageCaption, ImageResize, ImageStyle, ImageToolbar,
        ImageUpload, Table, TableToolbar, BlockQuote, MediaEmbed,
        SourceEditing, FileManagerPlugin, PictureEditing,
        RemoveFormat, Autoformat
    ],
    toolbar: [
        'undo', 'redo', '|',
        'sourceEditing', '|',
        'heading', '|',
        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
        'bold', 'italic', 'underline', 'strikethrough', '|',
        'alignment', '|',
        'link', 'fileManager', '|',
        'insertTable', 'blockQuote', 'mediaEmbed', '|',
        'numberedList', 'bulletedList', 'outdent', 'indent', '|',
        'removeFormat'
    ],
    // Add the link configuration here
    link: {
        decorators: {
            openInNewTab: {
                mode: 'manual',
                label: 'Open in a new tab',
                attributes: {
                    target: '_blank',
                    rel: 'noopener noreferrer'
                }
            }
        }
    },
    image: {
        insert: { integrations: ['upload', 'url'] },
        toolbar: [
            'imageStyle:inline',
            'imageStyle:block',
            'imageStyle:side',
            '|',
            'toggleImageCaption',
            'imageTextAlternative'
        ]
    },
    mediaEmbed: {
        previewsInData: true,
        extraProviders: [
            {
                name: 'directVideo',
                url: /\.(mp4|mov|avi|mkv)(\?.*)?$/i,
                html: match => {
                    const url = match.input;
                    return `<div style="padding-bottom: 20px;">
                        <video controls style="width: 100%; height: 100%;">
                            <source src="${url}" type="video/mp4">
                        </video>
                    </div>`;
                }
            }
        ]
    }
}));

const showFileManager = async () => {
    show.value = true;
    await loadFiles();
};

const onEditorReady = (editor) => {
    editorInstance.value = editor;
};

onMounted(() => {
    window._openFileManager = showFileManager;
    loadFiles();
});
</script>

<style scoped>
/* Backdrop */
.fm-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999;
    animation: fadeIn 0.2s ease-out;
}

.editor {
    border-radius: 0px !important;
}

/* Modal */
.fm-modal {
    width: 92%;
    max-width: 960px;
    max-height: 90vh;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    display: flex;
    flex-direction: column;
    animation: slideUp 0.3s ease-out;
}

/* Header */
.fm-header {
    padding: 20px 24px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8f9fa;
}

.fm-header h2 {
    margin: 0;
    font-size: 1.35rem;
    font-weight: 600;
    color: #1a1a1a;
}

.fm-close {
    width: 36px;
    height: 36px;
    border: none;
    background: transparent;
    cursor: pointer;
    opacity: 0.6;
}

.fm-close:hover {
    opacity: 1;
}

.fm-close svg {
    width: 20px;
    height: 20px;
    fill: currentColor;
}

/* Upload Zone */
.fm-upload-zone {
    padding: 24px;
}

.fm-upload-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    height: 120px;
    border: 3px dashed #ccc;
    border-radius: 12px;
    background: #fafafa;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 1rem;
    color: #555;
}

.fm-upload-label:hover {
    border-color: #007bff;
    background: #f0f8ff;
}

.upload-icon {
    width: 42px;
    height: 42px;
    fill: #007bff;
}

#fm-upload {
    display: none;
}

/* Grid */
.fm-grid {
    flex: 1;
    overflow-y: auto;
    padding: 20px 24px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 20px;
}

/* Item */
.fm-item {
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.2s;
    cursor: pointer;
    position: relative;
    width: 100%;
    min-height: 80px;
}

.fm-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.fm-thumb-wrapper {
    position: relative;
    height: 80px;
    overflow: hidden;
}

.fm-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.fm-item:hover .fm-thumb {
    transform: scale(1);
}

.fm-check {
    position: absolute;
    inset: 0;
    background: rgba(0, 123, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s;
}

.fm-item:hover .fm-check {
    opacity: 1;
}

.fm-check svg {
    width: 36px;
    height: 36px;
    fill: white;
}

.fm-name {
    padding: 10px 8px;
    font-size: 13px;
    margin-bottom: 0;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    background: #f8f9fa;
}

/* Actions */
.fm-actions {
    position: absolute;
    top: 8px;
    right: 8px;
    display: flex;
    gap: 6px;
    opacity: 0;
    transition: opacity 0.2s;
}

.fm-item:hover .fm-actions {
    opacity: 1;
}

.fm-actions button {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.9);
    cursor: pointer;
    backdrop-filter: blur(4px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.fm-actions svg {
    width: 16px;
    height: 16px;
    fill: #333;
}

/* Footer */
.fm-footer {
    padding: 16px 24px;
    border-top: 1px solid #eee;
    text-align: right;
    background: #f8f9fa;
}

.fm-btn-secondary {
    padding: 10px 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: white;
    cursor: pointer;
    font-weight: 500;
}

.fm-btn-secondary:hover {
    background: #f0f0f0;
}

.badge-video {
  position: absolute;
  bottom: 10px;
  left: 10px;
  background-color: #0A6847;
  color: #fff;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 12px;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes slideUp {
    from {
        transform: translateY(40px);
        opacity: 0;
    }

    to {
        transform: none;
        opacity: 1;
    }
}
</style>
