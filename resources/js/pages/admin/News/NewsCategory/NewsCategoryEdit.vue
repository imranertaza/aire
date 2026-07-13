<template>
    <DashboardHeader title="Edit News Category" />

    <section class="mt-3">
        <div class="card">
            <div class="card-body">
                <form v-if="form" @submit.prevent="updateCategory">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input v-model="form.category_name" type="text" class="form-control" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea v-model="form.description" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Parent Category</label>
                                <Multiselect v-model="form.parent_id" :options="categoriesOptions"
                                    :reduce="option => option.value" placeholder="Select parent category" searchable
                                    allow-empty />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input v-model="form.meta_title" type="text" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <input v-model="form.meta_description" type="text" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Meta Keyword</label>
                                <input v-model="form.meta_keyword" type="text" class="form-control" />
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Category Image</label>
                                <Vue3Dropzone v-model="imageFile" v-model:previews="previews" mode="edit"
                                    :allowSelectOnPreview="true" />
                                <small class="text-muted">Recommended: 1140 × 375px</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alt Name</label>
                                <input v-model="form.alt_name" type="text" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <input v-model="form.sort_order" type="number" class="form-control" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select v-model="form.status" class="custom-select">
                                    <option :value="1">Active</option>
                                    <option :value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                                </div>
                                <div class="col-md-6">
                                    <router-link :to="{ name: 'NewsCategoryIndex' }"
                                        class="btn btn-secondary btn-block">Cancel</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';
import DashboardHeader from '@/components/DashboardHeader.vue';
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import { getImageUrl } from '@/layouts/helpers/helpers';
import { useToast } from '@/composables/useToast';
import Multiselect from '@vueform/multiselect';

// Toast notifications
const toast = useToast();

// Current route (to get category ID)
const route = useRoute();

// Category data being edited
const form = ref(null);

// Dropzone reference for new image upload
const imageFile = ref(null);
const previews = ref([]);

// All categories (for parent selection)
const categories = ref([]);

/**
 * Fetch the news category to edit
 */
const fetchCategory = async () => {
    try {
        const res = await axios.get(`/api/news-categories/${route.params.id}`);
        form.value = res.data.data;
        if (form.value.image) {
            previews.value = [getImageUrl(form.value.image)];
        }
    } catch (error) {
        toast.error('Failed to load category');
    }
};

/**
 * Fetch all categories for parent dropdown
 */
const fetchCategories = async () => {
    try {
        const res = await axios.get('/api/news-categories?all=1');
        categories.value = res.data.data;
    } catch (error) {
        toast.error('Failed to load categories');
    }
};

/**
 * Options for parent category select
 */
const categoriesOptions = computed(() => {
    return [
        { label: '-- None --', value: '' },
        ...categories.value.map(cat => ({
            label: cat.category_name,
            value: cat.id
        }))
    ];
});

/**
 * Update the news category (PUT spoofed with POST + _method=PUT)
 */
const updateCategory = async () => {
    const payload = new FormData();

    // Append all fields except image placeholder
    for (const key in form.value) {
        if (key !== 'image') {
            payload.append(key, form.value[key] ?? '');
        }
    }

    // Append new image if uploaded
    if (imageFile.value && imageFile.value[0]) {
        payload.append('image', imageFile.value[0].file);
    }
    if (previews.value.length === 0) { payload.append('remove_f_image', 1); }
    try {
        const res = await axios.post(`/api/news-categories/${route.params.id}?_method=PUT`, payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        form.value = res.data.data;
        toast.success('Category updated successfully!');
    } catch (error) {
        toast.validationError(error);
    }
};

// Optional props (kept for compatibility)
defineProps({
    id: {
        type: [Number, String],
        required: false
    }
});

// Load data on mount
onMounted(() => {
    fetchCategory();
    fetchCategories();
});
</script>
