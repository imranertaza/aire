<template>
    <div class="resource-form-wrapper">
        <DashboardHeader :title="isEdit ? 'Update Resource' : 'Create Resource'" />
        <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">{{ isEdit ? 'Update Resource' : 'Create Resource' }}</h3>
                    </div>

                    <!-- Fetching Spinner for Edit Mode -->
                    <div v-if="fetching" class="card-body text-center py-5">
                        <div class="spinner-border text-purple" role="status">
                            <span class="sr-only">Loading resource details...</span>
                        </div>
                        <p class="text-muted mt-2">Loading resource information...</p>
                    </div>

                    <form v-else @submit.prevent="handleSubmit">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column (col-md-8) -->
                                <div class="col-md-8">
                                    <!-- Resource Category -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Resource Category <span class="text-danger">*</span></label>
                                        <select v-model="form.resource_category_id" class="custom-select"
                                            :class="{ 'is-invalid': errors.resource_category_id }"
                                            @change="onCategoryChange" required>
                                            <option value="" disabled>Select Resource Category</option>
                                            <option v-for="cat in categoriesList" :key="cat.id" :value="cat.id">
                                                {{ cat.name }} ({{ cat.layout_type }})
                                            </option>
                                        </select>
                                        <div class="invalid-feedback" v-if="errors.resource_category_id">
                                            {{ errors.resource_category_id[0] }}
                                        </div>
                                        <small class="text-muted" v-else>Determines in which section on the storefront this item is placed.</small>
                                    </div>

                                    <!-- Title -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Title <span class="text-danger">*</span></label>
                                        <input v-model="form.title" @input="onTitleInput" type="text"
                                            class="form-control" :class="{ 'is-invalid': errors.title }"
                                            placeholder="e.g. AirPro V3 Brochure & Spec Sheet" required />
                                        <div class="invalid-feedback" v-if="errors.title">
                                            {{ errors.title[0] }}
                                        </div>
                                    </div>

                                    <!-- Slug -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Slug <span class="text-danger">*</span></label>
                                        <input v-model="form.slug" @input="clearError('slug')" type="text"
                                            class="form-control" :class="{ 'is-invalid': errors.slug }"
                                            placeholder="auto-generated-from-title" required />
                                        <div class="invalid-feedback" v-if="errors.slug">
                                            {{ errors.slug[0] }}
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Short Description / Subtitle</label>
                                        <textarea v-model="form.description" @input="clearError('description')"
                                            class="form-control" :class="{ 'is-invalid': errors.description }" rows="3"
                                            placeholder="Brief summary or card subtitle for this resource item."></textarea>
                                        <div class="invalid-feedback" v-if="errors.description">
                                            {{ errors.description[0] }}
                                        </div>
                                    </div>

                                    <!-- File Type -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">File / Resource Type <span class="text-danger">*</span></label>
                                        <select v-model="form.file_type" class="custom-select"
                                            :class="{ 'is-invalid': errors.file_type }"
                                            @change="clearError('file_type')" required>
                                            <option value="pdf">PDF Document (Brochure / Manual)</option>
                                            <option value="video">Video (MP4 / YouTube / Vimeo)</option>
                                            <option value="zip">ZIP Archive (Software / CAD / Drivers)</option>
                                            <option value="doc">Word / Text Document</option>
                                            <option value="faq">FAQ Resource Card</option>
                                        </select>
                                        <div class="invalid-feedback" v-if="errors.file_type">
                                            {{ errors.file_type[0] }}
                                        </div>
                                    </div>

                                    <!-- FAQ info alert -->
                                    <div v-if="isFaq || form.file_type === 'faq'" class="alert alert-info py-2 px-3 small mb-3">
                                        <i class="bi bi-info-circle mr-1"></i>
                                        <strong>FAQ Card:</strong> You can upload a document/file (PDF, ZIP, DOC), provide an external link, or configure a card graphic icon.
                                    </div>

                                    <!-- Upload Document / File with Vue3Dropzone -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Upload Resource File (PDF, ZIP, DOC, MP4, etc.)</label>
                                        <Vue3Dropzone
                                            v-if="isEdit"
                                            v-model="fileUpload"
                                            v-model:previews="filePreviews"
                                            mode="edit"
                                            :allowSelectOnPreview="true"
                                            :maxFiles="1"
                                            :maxFileSize="500"
                                            @change="clearError('file')"
                                        />
                                        <Vue3Dropzone
                                            v-else
                                            v-model="fileUpload"
                                            :allowSelectOnPreview="true"
                                            :maxFiles="1"
                                            :maxFileSize="500"
                                            @change="clearError('file')"
                                        />
                                        <div v-if="errors.file" class="text-danger small mt-2 d-flex align-items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i> {{ errors.file[0] }}
                                        </div>
                                        <div v-if="form.file_path && !fileUpload?.[0]" class="mt-2 small d-flex align-items-center">
                                            <span class="badge badge-light border text-muted mr-1">Current File:</span>
                                            <a :href="getFileUrl(form.file_path)" target="_blank" class="text-truncate d-inline-block" style="max-width: 350px;">
                                                {{ form.file_path }}
                                            </a>
                                            <span v-if="form.file_size" class="badge badge-light border ml-1">{{ form.file_size }}</span>
                                        </div>
                                        <small class="text-muted d-block mt-1">Accepted: PDF, ZIP, Word docs, MP4 (Max 500MB)</small>
                                    </div>

                                    <!-- External URL -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">External URL / Video Link</label>
                                        <input v-model="form.external_url" @input="clearError('external_url')" type="text"
                                            class="form-control" :class="{ 'is-invalid': errors.external_url }"
                                            placeholder="https://youtu.be/... or /contact" />
                                        <div class="invalid-feedback" v-if="errors.external_url">
                                            {{ errors.external_url[0] }}
                                        </div>
                                        <small class="text-muted" v-else>Optional external link for this card.</small>
                                    </div>

                                    <!-- Card Graphic Icon (shown for FAQ or items with graphic icon) -->
                                    <div class="form-group" v-if="isFaq || form.metadata?.graphic_icon">
                                        <label class="font-weight-bold">
                                            Card Graphic Icon <span class="text-muted font-weight-normal">(Optional)</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend" v-if="form.metadata?.graphic_icon">
                                                <span class="input-group-text"><i :class="form.metadata.graphic_icon"></i></span>
                                            </div>
                                            <input v-model="form.metadata.graphic_icon"
                                                type="text"
                                                class="form-control"
                                                placeholder="e.g. bi bi-chat-square-quote, bi bi-tools, bi bi-gear-fill" />
                                        </div>
                                        <small class="form-text text-muted">
                                            Bootstrap icon class displayed inside the upper card box (e.g. <code>bi bi-chat-square-quote</code>).
                                        </small>
                                    </div>
                                </div>

                                <!-- Right Column (col-md-4) -->
                                <div class="col-md-4">

                                    <!-- Thumbnail Upload with Vue3Dropzone -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Thumbnail / Poster Image <span class="text-danger">*</span></label>
                                        <Vue3Dropzone
                                            v-if="isEdit"
                                            v-model="thumbUpload"
                                            v-model:previews="thumbPreviews"
                                            mode="edit"
                                            acceptedFiles="image/*"
                                            :allowSelectOnPreview="true"
                                            :maxFiles="1"
                                            :maxFileSize="10"
                                            @change="clearError('thumbnail_file'); clearError('thumbnail')"
                                        />
                                        <Vue3Dropzone
                                            v-else
                                            v-model="thumbUpload"
                                            acceptedFiles="image/*"
                                            :allowSelectOnPreview="true"
                                            :maxFiles="1"
                                            :maxFileSize="10"
                                            @change="clearError('thumbnail_file'); clearError('thumbnail')"
                                        />
                                        <div v-if="errors.thumbnail_file || errors.thumbnail" class="text-danger small mt-2 d-flex align-items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i> {{ (errors.thumbnail_file || errors.thumbnail)[0] }}
                                        </div>
                                        <small class="text-muted d-block mt-1">Recommended: 600 × 400px or 800 × 500px (~16:9)</small>
                                    </div>

                                    <!-- Badge Row -->
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Badge Text</label>
                                                <input v-model="form.badge_text" @input="clearError('badge_text')" type="text"
                                                    class="form-control form-control-sm" :class="{ 'is-invalid': errors.badge_text }"
                                                    placeholder="e.g. NEW, UPDATED" />
                                                <div class="invalid-feedback" v-if="errors.badge_text">
                                                    {{ errors.badge_text[0] }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Badge Icon</label>
                                                <input v-model="form.badge_icon" @input="clearError('badge_icon')" type="text"
                                                    class="form-control form-control-sm" :class="{ 'is-invalid': errors.badge_icon }"
                                                    placeholder="e.g. bi bi-star" />
                                                <div class="invalid-feedback" v-if="errors.badge_icon">
                                                    {{ errors.badge_icon[0] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sort Order -->
                                    <div class="mb-3">
                                        <label class="font-weight-bold">Sort Order</label>
                                        <input min="0" v-model.number="form.sort_order" @input="clearError('sort_order')"
                                            type="number" class="form-control" :class="{ 'is-invalid': errors.sort_order }" />
                                        <div class="invalid-feedback" v-if="errors.sort_order">
                                            {{ errors.sort_order[0] }}
                                        </div>
                                    </div>

                                    <!-- Featured Toggle -->
                                    <!-- <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="featuredSwitch"
                                                v-model="form.is_featured" :true-value="1" :false-value="0">
                                            <label class="custom-control-label font-weight-bold" for="featuredSwitch">
                                                Featured Resource (Highlight on Storefront)
                                            </label>
                                        </div>
                                    </div> -->

                                    <!-- Status -->
                                    <div class="mb-3">
                                        <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
                                        <select v-model.number="form.status" class="custom-select"
                                            :class="{ 'is-invalid': errors.status }"
                                            @change="clearError('status')" required>
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                        <div class="invalid-feedback" v-if="errors.status">
                                            {{ errors.status[0] }}
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success btn-block" :disabled="loading">
                                                <i v-if="loading" class="fas fa-spinner fa-spin mr-1"></i>
                                                <span v-else>{{ isEdit ? 'Update' : 'Create' }}</span>
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <RouterLink :to="{ name: 'Resources' }"
                                                class="btn btn-secondary btn-block">Cancel</RouterLink>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    </div>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import axios from 'axios';
import { reactive, ref, computed, onMounted, watch } from 'vue';
import { useToast } from '@/composables/useToast';
import { useRouter, RouterLink } from 'vue-router';
import { generateSlug, getImageUrl } from '@/layouts/helpers/helpers';

const props = defineProps({
    isEdit: {
        type: Boolean,
        default: false
    },
    resourceId: {
        type: [String, Number],
        default: null
    },
    id: {
        type: [String, Number],
        default: null
    }
});

const currentResourceId = computed(() => props.resourceId || props.id);

const toast = useToast();
const router = useRouter();

const loading = ref(false);
const fetching = ref(false);
const errors = ref({});

const categoriesList = ref([]);
const productCategoriesList = ref([]);
const productsList = ref([]);

// Vue3Dropzone file and thumbnail refs
const fileUpload = ref(null);
const filePreviews = ref([]);

const thumbUpload = ref(null);
const thumbPreviews = ref([]);

const form = reactive({
    resource_category_id: '',
    product_category_id: null,
    product_id: null,
    title: '',
    slug: '',
    description: '',
    file_type: 'pdf',
    file_path: '',
    file_size: '',
    thumbnail: '',
    external_url: '',
    badge_text: '',
    badge_icon: '',
    metadata: {
        graphic_icon: ''
    },
    sort_order: 0,
    is_featured: 0,
    status: 1
});

const isFaq = computed(() => {
    const selectedCat = categoriesList.value.find(c => c.id === form.resource_category_id);
    return form.file_type === 'faq' || selectedCat?.layout_type === 'faq_card';
});

const onCategoryChange = () => {
    clearError('resource_category_id');
    const selectedCat = categoriesList.value.find(c => c.id === form.resource_category_id);
    if (selectedCat?.layout_type === 'faq_card' && form.file_type !== 'faq') {
        form.file_type = 'faq';
    }
};

const getFileUrl = (path) => {
    if (!path) return '#';
    if (/^https?:\/\//i.test(path)) return path;
    const clean = path.replace(/^\/+/, '');
    return `/${clean}`;
};

const clearError = (field) => {
    if (errors.value && errors.value[field]) {
        delete errors.value[field];
    }
};

const onTitleInput = () => {
    form.slug = generateSlug(form.title);
    clearError('title');
    clearError('slug');
};

const validateForm = () => {
    const errs = {};

    if (!form.resource_category_id) {
        errs.resource_category_id = ['Please select a resource category.'];
    }

    if (!form.title || !form.title.trim()) {
        errs.title = ['Resource title is required.'];
    } else if (form.title.trim().length < 2) {
        errs.title = ['Title must be at least 2 characters.'];
    }

    if (!form.slug || !form.slug.trim()) {
        errs.slug = ['Slug is required.'];
    }

    if (!form.file_type) {
        errs.file_type = ['Please select a file / resource type.'];
    }

    const hasNewThumb = thumbUpload.value && thumbUpload.value[0] && thumbUpload.value[0].file;
    const hasExistingThumb = props.isEdit && thumbPreviews.value && thumbPreviews.value.length > 0 && thumbPreviews.value[0];
    if (!hasNewThumb && !hasExistingThumb) {
        errs.thumbnail_file = ['Thumbnail / Poster image is required.'];
    }

    if (form.status === null || form.status === undefined || form.status === '') {
        errs.status = ['Status is required.'];
    }

    if (form.sort_order !== null && form.sort_order !== undefined && Number(form.sort_order) < 0) {
        errs.sort_order = ['Sort order must be 0 or greater.'];
    }

    return errs;
};

// Automatically adjust file_type when a file is selected in dropzone
watch(fileUpload, (newVal) => {
    if (newVal && newVal[0] && newVal[0].file) {
        const file = newVal[0].file;
        const ext = file.name.split('.').pop().toLowerCase();
        const videoExts = ['mp4', 'webm', 'mov', 'ogg', 'mkv', 'avi'];
        if (videoExts.includes(ext)) {
            form.file_type = 'video';
        } else if (['pdf', 'zip', 'doc', 'docx'].includes(ext)) {
            form.file_type = ext;
        }
        clearError('file');
    }
});

watch(thumbUpload, (newVal) => {
    if (newVal && newVal[0] && newVal[0].file) {
        clearError('thumbnail');
        clearError('thumbnail_file');
    }
});

const loadDropdowns = async () => {
    try {
        const [catRes, pcatRes, prodRes] = await Promise.all([
            axios.get('/api/resource-categories', { params: { all: 1 } }),
            axios.get('/api/product-categories/all').catch(() => ({ data: { data: [] } })),
            axios.get('/api/products/all-dropdown').catch(() => ({ data: { data: [] } }))
        ]);
        categoriesList.value = catRes.data.data || [];
        productCategoriesList.value = pcatRes.data.data || [];
        productsList.value = prodRes.data.data || [];
    } catch (error) {
        console.error('Failed to load form dropdown data:', error);
    }
};

const fetchResource = async () => {
    if (!props.isEdit || !currentResourceId.value) return;
    fetching.value = true;
    try {
        const res = await axios.get(`/api/resources/${currentResourceId.value}`);
        const data = res.data.data;
        form.resource_category_id = data.resource_category_id || '';
        form.product_category_id = data.product_category_id || null;
        form.product_id = data.product_id || null;
        form.title = data.title || '';
        form.slug = data.slug || (data.title ? generateSlug(data.title) : '');
        form.description = data.description || '';
        form.file_type = data.file_type || 'pdf';
        form.file_path = data.file_path || '';
        form.file_size = data.file_size || '';
        form.thumbnail = data.thumbnail || '';
        form.external_url = data.external_url || '';
        form.badge_text = data.badge_text || '';
        form.badge_icon = data.badge_icon || '';
        form.metadata = (data.metadata && typeof data.metadata === 'object') ? {
            graphic_icon: data.metadata.graphic_icon || '',
            ...data.metadata
        } : {
            graphic_icon: ''
        };
        form.sort_order = data.sort_order ?? 0;
        form.is_featured = data.is_featured ?? 0;
        form.status = data.status ?? 1;

        if (data.file_path) {
            filePreviews.value = [getFileUrl(data.file_path)];
        }
        if (data.thumbnail) {
            thumbPreviews.value = [getImageUrl(data.thumbnail)];
        }
    } catch (error) {
        console.error(error);
        toast.error('Failed to load resource details.');
        router.push({ name: 'Resources' });
    } finally {
        fetching.value = false;
    }
};

const handleSubmit = async () => {
    errors.value = {};
    const clientErrors = validateForm();
    if (Object.keys(clientErrors).length > 0) {
        errors.value = clientErrors;
        const firstMsg = Object.values(clientErrors)[0][0];
        toast.error(firstMsg || 'Please correct the highlighted validation errors.');
        return;
    }

    loading.value = true;
    const formData = new FormData();

    for (const key in form) {
        if (key === 'metadata') {
            formData.append('metadata', JSON.stringify(form.metadata || {}));
            continue;
        }
        if (key === 'product_id' || key === 'product_category_id') {
            if (form[key]) {
                formData.append(key, form[key]);
            }
            continue;
        }
        if (key === 'thumbnail' || key === 'file_path' || key === 'file_size') {
            continue;
        }
        if (form[key] !== null && form[key] !== undefined) {
            formData.append(key, form[key]);
        }
    }

    if (fileUpload.value && fileUpload.value[0] && fileUpload.value[0].file) {
        formData.append('file', fileUpload.value[0].file);
    } else if (props.isEdit && (!filePreviews.value || filePreviews.value.length === 0 || !filePreviews.value[0])) {
        formData.append('remove_file', 1);
    }

    if (thumbUpload.value && thumbUpload.value[0] && thumbUpload.value[0].file) {
        formData.append('thumbnail_file', thumbUpload.value[0].file);
    } else if (props.isEdit && (!thumbPreviews.value || thumbPreviews.value.length === 0 || !thumbPreviews.value[0])) {
        formData.append('remove_thumbnail', 1);
    }

    try {
        if (props.isEdit) {
            formData.append('_method', 'PUT');
            await axios.post(`/api/resources/${currentResourceId.value}`, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            toast.success('Resource updated successfully!');
        } else {
            await axios.post('/api/resources', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            toast.success('Resource created successfully!');
        }
        router.push({ name: 'Resources' });
    } catch (error) {
        console.error(error);
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors || {};
            const firstMsg = Object.values(errors.value)[0]?.[0] || error.response.data.message;
            toast.error(firstMsg || 'Validation failed. Please review the form.');
        } else {
            toast.error(error?.response?.data?.message || `Failed to ${props.isEdit ? 'update' : 'create'} resource.`);
        }
    } finally {
        loading.value = false;
    }
};

onMounted(async () => {
    await loadDropdowns();
    if (props.isEdit) {
        await fetchResource();
    }
});
</script>
