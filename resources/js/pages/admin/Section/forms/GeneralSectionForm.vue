<template>
    <div class="general-section-form">
        <div class="card card-primary card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-edit mr-1"></i> General Section Content
                </h3>
            </div>
            <form @submit.prevent="$emit('save')">
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="font-weight-bold">Section Title <span class="text-danger">*</span></label>
                                <input v-model="form.title" type="text" class="form-control"
                                    placeholder="Enter section title..." required />
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Section Content</label>
                                <RichTextEditor v-model="form.content"
                                    placeholder="Write section details here..." class="editor" />
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Upload Image</label>
                                <Vue3Dropzone :model-value="fileUpload" @update:model-value="$emit('update:fileUpload', $event)"
                                    :previews="previews" @update:previews="$emit('update:previews', $event)" mode="edit"
                                    :allowSelectOnPreview="true" />
                                <small class="form-text text-muted">Recommended: 600 × 400px or 800 × 500px (Landscape)</small>
                                <div v-if="previews && previews.length && previews[0]" class="mt-2">
                                    <img :src="previews[0]" class="img-thumbnail" style="max-height: 100px;" alt="Uploaded preview" />
                                </div>
                                <div v-else-if="form.image" class="mt-2 d-flex align-items-center">
                                    <img :src="getImageUrl(form.image)" class="img-thumbnail mr-2" style="max-height: 60px;" alt="Current image" />
                                    <small class="text-muted font-monospace">{{ form.image }}</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
                                <select v-model="form.status" class="custom-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="mt-4 pt-2">
                                <button type="submit" class="btn btn-primary btn-block font-weight-bold" :disabled="saving">
                                    <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Update Section' }}
                                </button>
                                <router-link :to="{ name: 'Section' }" class="btn btn-secondary btn-block mt-2">
                                    Cancel
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import RichTextEditor from '@/components/RichTextEditor.vue';
import { getImageUrl } from '@/layouts/helpers/helpers';

defineProps({
    form: {
        type: Object,
        required: true,
    },
    saving: {
        type: Boolean,
        default: false,
    },
    fileUpload: {
        type: Array,
        default: () => [],
    },
    previews: {
        type: Array,
        default: () => [],
    },
});

defineEmits(['save', 'update:fileUpload', 'update:previews']);
</script>
