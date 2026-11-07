<template>
    <div class="resource-category-form-wrapper">
        <DashboardHeader :title="isEdit ? 'Update Resource Category' : 'Create Resource Category'" />
        <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">{{ isEdit ? 'Update Resource Category' : 'Create Resource Category' }}</h3>
                    </div>

                    <!-- Fetching Spinner for Edit Mode -->
                    <div v-if="fetching" class="card-body text-center py-5">
                        <div class="spinner-border text-purple" role="status">
                            <span class="sr-only">Loading category details...</span>
                        </div>
                        <p class="text-muted mt-2">Loading category information...</p>
                    </div>

                    <form v-else @submit.prevent="handleSubmit">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column (col-md-8) -->
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Category Name <span class="text-danger">*</span></label>
                                        <input v-model="form.name" @input="onNameInput" type="text"
                                            class="form-control" :class="{ 'is-invalid': errors.name }"
                                            placeholder="e.g. Brochures & Catalogs" required />
                                        <div class="invalid-feedback" v-if="errors.name">{{ errors.name[0] }}</div>
                                    </div>

                                    <div class="form-group">
                                        <label>Slug <span class="text-danger">*</span></label>
                                        <input v-model="form.slug" @input="clearError('slug')" type="text"
                                            class="form-control" :class="{ 'is-invalid': errors.slug }"
                                            placeholder="auto-generated-from-name" required />
                                        <div class="invalid-feedback" v-if="errors.slug">{{ errors.slug[0] }}</div>
                                        <small class="text-muted" v-else>Used for scrollspy section anchor (#cat-slug).</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Sidebar Subtitle / Short Description</label>
                                        <input v-model="form.short_desc" @input="clearError('short_desc')" type="text"
                                            class="form-control" :class="{ 'is-invalid': errors.short_desc }"
                                            placeholder="e.g. Download brochures, specifications and catalogs" />
                                        <div class="invalid-feedback" v-if="errors.short_desc">{{ errors.short_desc[0] }}</div>
                                        <small class="text-muted" v-else>Displayed under the category title in the storefront resources sidebar.</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Section Search Placeholder</label>
                                        <input v-model="form.search_placeholder" @input="clearError('search_placeholder')" type="text"
                                            class="form-control" :class="{ 'is-invalid': errors.search_placeholder }"
                                            placeholder="e.g. Search with model No/ Name" />
                                        <div class="invalid-feedback" v-if="errors.search_placeholder">{{ errors.search_placeholder[0] }}</div>
                                        <small class="text-muted" v-else>Placeholder text shown inside this category's filter search box.</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Section Description</label>
                                        <textarea v-model="form.description" @input="clearError('description')" class="form-control"
                                            :class="{ 'is-invalid': errors.description }" rows="4"
                                            placeholder="Detailed description or overview shown at the top of this category's section."></textarea>
                                        <div class="invalid-feedback" v-if="errors.description">{{ errors.description[0] }}</div>
                                    </div>

                                    <!-- SEO & Social Meta Configuration -->
                                    <div class="card card-outline card-info mt-3 shadow-none border">
                                        <div class="card-header py-2 bg-light">
                                            <h3 class="card-title text-sm font-weight-bold mb-0">
                                                <i class="fas fa-search mr-1 text-info"></i> SEO & Search Engine Optimization
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="mb-1 font-weight-bold small">Meta Title</label>
                                                    <small class="text-muted">{{ (form.meta_title || '').length }} / 60</small>
                                                </div>
                                                <input v-model="form.meta_title" @input="clearError('meta_title')" type="text"
                                                    class="form-control form-control-sm" :class="{ 'is-invalid': errors.meta_title }"
                                                    placeholder="e.g. Brochures & Catalogs | AIRE Clean Air Systems" />
                                                <div class="invalid-feedback" v-if="errors.meta_title">{{ errors.meta_title[0] }}</div>
                                                <small class="text-muted font-italic">Default: Category name + site title if left empty.</small>
                                            </div>

                                            <div class="form-group">
                                                <label class="mb-1 font-weight-bold small">Meta Keywords</label>
                                                <input v-model="form.meta_keywords" @input="clearError('meta_keywords')" type="text"
                                                    class="form-control form-control-sm" :class="{ 'is-invalid': errors.meta_keywords }"
                                                    placeholder="e.g. aire brochures, hvac catalog, air purifier specs" />
                                                <div class="invalid-feedback" v-if="errors.meta_keywords">{{ errors.meta_keywords[0] }}</div>
                                                <small class="text-muted font-italic">Comma-separated keywords.</small>
                                            </div>

                                            <div class="form-group mb-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="mb-1 font-weight-bold small">Meta Description</label>
                                                    <small class="text-muted">{{ (form.meta_description || '').length }} / 160</small>
                                                </div>
                                                <textarea v-model="form.meta_description" @input="clearError('meta_description')"
                                                    class="form-control form-control-sm" :class="{ 'is-invalid': errors.meta_description }" rows="3"
                                                    placeholder="Snippet shown in Google and social shares (recommended 150-160 characters)."></textarea>
                                                <div class="invalid-feedback" v-if="errors.meta_description">{{ errors.meta_description[0] }}</div>
                                                <small class="text-muted font-italic">Default: Section description if left empty.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column (col-md-4) -->
                                <div class="col-md-4">
                                    <!-- Layout Type -->
                                    <div class="form-group">
                                        <label>Layout Type <span class="text-danger">*</span></label>
                                        <select v-model="form.layout_type" class="custom-select"
                                            :class="{ 'is-invalid': errors.layout_type }"
                                            @change="clearError('layout_type')" required>
                                            <option value="brochure_card">Brochures & Catalogs (brochure_card)</option>
                                            <option value="video_card">Videos (video_card)</option>
                                            <option value="thumb_card">Thumbnails & Docs (thumb_card)</option>
                                            <option value="faq_card">FAQ Accordions (faq_card)</option>
                                        </select>
                                        <div class="invalid-feedback" v-if="errors.layout_type">{{ errors.layout_type[0] }}</div>
                                        <small class="text-muted" v-else>Defines how cards and downloads are structured in this section.</small>
                                    </div>

                                    <!-- Icon Selection -->
                                    <div class="form-group">
                                        <label>Category Icon</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white">
                                                    <i :class="form.icon || 'bi bi-folder2'" style="font-size: 18px; width: 22px; text-align: center;"></i>
                                                </span>
                                            </div>
                                            <input v-model="form.icon" @input="clearError('icon')" type="text"
                                                class="form-control" :class="{ 'is-invalid': errors.icon }"
                                                placeholder="e.g. bi bi-book" />
                                            <div class="invalid-feedback" v-if="errors.icon">{{ errors.icon[0] }}</div>
                                        </div>
                                        <small class="text-muted d-block mt-1">Bootstrap or FontAwesome icon class.</small>

                                        <!-- Quick Icon Presets -->
                                        <div class="d-flex flex-wrap mt-2" style="gap: 5px;">
                                            <button v-for="ic in quickIcons" :key="ic" type="button"
                                                class="btn btn-xs"
                                                :class="form.icon === ic ? 'btn-primary text-white' : 'btn-outline-secondary'"
                                                @click="form.icon = ic">
                                                <i :class="ic"></i> {{ ic.replace('bi bi-', '') }}
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Sort Order -->
                                    <div class="mb-3">
                                        <label class="form-label">Sort Order</label>
                                        <input min="0" v-model.number="form.sort_order" @input="clearError('sort_order')"
                                            type="number" class="form-control" :class="{ 'is-invalid': errors.sort_order }" />
                                        <div class="invalid-feedback" v-if="errors.sort_order">{{ errors.sort_order[0] }}</div>
                                        <small class="text-muted" v-else>Lower order appears first on the resources page.</small>
                                    </div>

                                    <!-- Status -->
                                    <div class="mb-3">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select v-model.number="form.status" class="custom-select"
                                            :class="{ 'is-invalid': errors.status }"
                                            @change="clearError('status')" required>
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                        <div class="invalid-feedback" v-if="errors.status">{{ errors.status[0] }}</div>
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
                                            <RouterLink :to="{ name: 'ResourceCategories' }"
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
import axios from 'axios';
import { reactive, ref, computed, onMounted } from 'vue';
import { useToast } from '@/composables/useToast';
import { useRouter, RouterLink } from 'vue-router';
import { generateSlug } from '@/layouts/helpers/helpers';

const props = defineProps({
    isEdit: {
        type: Boolean,
        default: false
    },
    categoryId: {
        type: [String, Number],
        default: null
    },
    id: {
        type: [String, Number],
        default: null
    }
});

const currentCategoryId = computed(() => props.categoryId || props.id);

const toast = useToast();
const router = useRouter();

const loading = ref(false);
const fetching = ref(false);
const errors = ref({});

const quickIcons = [
    'bi bi-book',
    'bi bi-journal-text',
    'bi bi-tools',
    'bi bi-file-earmark-text',
    'bi bi-play-circle',
    'bi bi-chat-left-text',
    'bi bi-gear',
    'bi bi-buildings',
    'bi bi-shield-check',
    'bi bi-question-circle',
    'bi bi-headset'
];

const form = reactive({
    name: '',
    slug: '',
    icon: 'bi bi-folder2',
    short_desc: '',
    description: '',
    search_placeholder: 'Search with model No/ Name',
    layout_type: 'brochure_card',
    sort_order: 0,
    status: 1,
    meta_title: '',
    meta_keywords: '',
    meta_description: '',
});

const clearError = (field) => {
    if (errors.value && errors.value[field]) {
        delete errors.value[field];
    }
};

const onNameInput = () => {
    form.slug = generateSlug(form.name);
    clearError('name');
    clearError('slug');
};

const validateCategoryForm = () => {
    const errs = {};
    if (!form.name || !form.name.trim()) {
        errs.name = ['Category name is required.'];
    } else if (form.name.trim().length < 2) {
        errs.name = ['Category name must be at least 2 characters.'];
    }

    if (!form.slug || !form.slug.trim()) {
        errs.slug = ['Slug is required.'];
    }

    if (!form.layout_type) {
        errs.layout_type = ['Layout type is required.'];
    }

    if (form.status === null || form.status === undefined || form.status === '') {
        errs.status = ['Status is required.'];
    }

    return errs;
};

const fetchCategory = async () => {
    if (!props.isEdit || !currentCategoryId.value) return;
    fetching.value = true;
    try {
        const res = await axios.get(`/api/resource-categories/${currentCategoryId.value}`);
        const data = res.data.data;
        form.name = data.name || '';
        form.slug = data.slug || (data.name ? generateSlug(data.name) : '');
        form.icon = data.icon || 'bi bi-folder2';
        form.short_desc = data.short_desc || '';
        form.description = data.description || '';
        form.search_placeholder = data.search_placeholder || 'Search with model No/ Name';
        form.layout_type = data.layout_type || 'brochure_card';
        form.sort_order = data.sort_order ?? 0;
        form.status = data.status ?? 1;
        form.meta_title = data.meta_title || '';
        form.meta_keywords = data.meta_keywords || '';
        form.meta_description = data.meta_description || '';
    } catch (error) {
        console.error(error);
        toast.error('Failed to load category details.');
        router.push({ name: 'ResourceCategories' });
    } finally {
        fetching.value = false;
    }
};

const handleSubmit = async () => {
    errors.value = {};
    const clientErrors = validateCategoryForm();
    if (Object.keys(clientErrors).length > 0) {
        errors.value = clientErrors;
        const firstMsg = Object.values(clientErrors)[0][0];
        toast.error(firstMsg || 'Please correct the highlighted validation errors.');
        return;
    }

    loading.value = true;
    try {
        if (props.isEdit) {
            await axios.put(`/api/resource-categories/${currentCategoryId.value}`, form);
            toast.success('Resource category updated successfully!');
        } else {
            await axios.post('/api/resource-categories', form);
            toast.success('Resource category created successfully!');
        }
        router.push({ name: 'ResourceCategories' });
    } catch (error) {
        console.error(error);
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors || {};
            const firstMsg = Object.values(errors.value)[0]?.[0] || error.response.data.message;
            toast.error(firstMsg || 'Validation failed. Please review the form.');
        } else {
            toast.error(error?.response?.data?.message || `Failed to ${props.isEdit ? 'update' : 'create'} resource category.`);
        }
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    if (props.isEdit) {
        fetchCategory();
    }
});
</script>
