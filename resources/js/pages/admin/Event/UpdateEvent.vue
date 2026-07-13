<template>
    <DashboardHeader title="Update Event" />

    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Edit Event</h3>
                    </div>

                    <form @submit.prevent="updateEvent">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <!-- Event Title -->
                                    <div class="form-group">
                                        <label>Event Title</label>
                                        <input v-model="form.title" @input="form.slug = generateSlug(form.title)"
                                            type="text" class="form-control" required />
                                    </div>

                                    <!-- Slug -->
                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input v-model="form.slug" type="text" class="form-control" required />
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label>Description</label>
                                        <RichTextEditor v-model="form.description"
                                            placeholder="Write event details here..." class="editor" />
                                    </div>

                                    <!-- Category -->
                                    <div class="form-group">
                                        <label>Event Category</label>
                                        <Multiselect v-model="form.event_category_id" :options="categoriesOptions"
                                            :reduce="option => option.value" placeholder="Select Event category"
                                            searchable allow-empty />
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <!-- File Upload -->
                                    <div class="form-group">
                                        <label>Upload Featured Image</label>
                                        <Vue3Dropzone v-model="imageUpload" v-model:previews="previewsImage" mode="edit"
                                            :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended: Running (262 x 230px) | Upcoming(252
                                            x515px)</small>

                                    </div>
                                    <!-- File Upload -->
                                    <div class="form-group">
                                        <label>Upload Banner Image</label>
                                        <Vue3Dropzone v-model="fileUpload" v-model:previews="previews" mode="edit"
                                            :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended: 1140 × 375px</small>

                                    </div>
                                    <!-- Type -->
                                    <div class="form-group">
                                        <label>Event Type</label>
                                        <select v-model="form.type" class="custom-select">
                                            <option value="0">Running</option>
                                            <option value="1">Upcoming</option>
                                            <option value="2">Previous</option>
                                        </select>
                                    </div>
                                    <!-- Scope -->
                                    <div class="form-group">
                                        <label>Event Scope</label>
                                        <select v-model="form.event_scope" class="custom-select">
                                            <option value="0">National</option>
                                            <option value="1">International</option>
                                            <option value="2">National Non-Sports</option>
                                        </select>
                                    </div>
                                    <!-- Status -->
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select v-model="form.status" class="custom-select">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-success btn-block">Update</button>
                                        <RouterLink :to="{ name: 'Events' }" class="btn btn-secondary btn-block mt-2">
                                            Cancel</RouterLink>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import axios from 'axios';
import { computed, onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { useToast } from '@/composables/useToast';
import { getImageUrl } from '@/layouts/helpers/helpers';
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import RichTextEditor from '@/components/RichTextEditor.vue';
import Multiselect from '@vueform/multiselect';
import { generateSlug } from '../../../layouts/helpers/helpers';

// Toast notifications
const toast = useToast();

// Route & router
const route = useRoute();
const router = useRouter();

// Dropzone previews
const previews = ref([]);          // Banner image preview (existing + new)
const previewsImage = ref([]);     // Featured image preview (existing + new)

// Dropzone file references for new uploads
const fileUpload = ref(null);      // New banner image
const imageUpload = ref(null);     // New featured image

// Available event categories
const categories = ref([]);

// Helper to detect PDF files (if needed in template)
const isPdf = (filename) => /\.pdf$/i.test(filename);

// Reactive form state for editing event
const form = reactive({
    id: null,
    title: '',
    slug: '',
    description: '',
    banner_image: '',         // Existing path (preview only)
    featured_image: '',       // Existing path (preview only)
    event_category_id: '',
    status: '1',              // '1' = active/published
    createdBy: 1,
    type: 0,
    event_scope: 0,
    updatedBy: null
});

/**
 * Computed options for event category select/multiselect
 * Includes "-- None --" as root option
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
 * Fetch the event data for editing
 */
const fetchEvent = async () => {
    try {
        const res = await axios.get(`/api/events/${route.params.id}`);
        const event = res.data.data;

        // Populate form
        Object.assign(form, event);

        // Set existing image previews for Dropzone
        if (event.banner_image) {
            previews.value = [getImageUrl(event.banner_image)];
        }
        if (event.featured_image) {
            previewsImage.value = [getImageUrl(event.featured_image)];
        }
    } catch (err) {
        toast.error('Failed to load event');
        console.error('Fetch event error:', err);
    }
};

/**
 * Load all event categories for the dropdown
 */
const fetchCategories = async () => {
    try {
        const res = await axios.get('/api/events-categories?all=1');
        categories.value = res.data.data;
    } catch (err) {
        toast.error('Failed to load categories');
        console.error('Fetch categories error:', err);
    }
};

/**
 * Update the event
 * Uses FormData + spoofed PUT via _method=PUT
 */
const updateEvent = async () => {
    const payload = new FormData();
    if (!previewsImage.value[0]) {
        payload.append("remove_f_image", 1);
    }
    if (!previews.value[0]) {
        payload.append("remove_image", 1);
    }
    // Append all fields except image placeholders
    for (const key in form) {
        if (key !== 'banner_image' && key !== 'featured_image') {
            payload.append(key, form[key] ?? '');
        }
    }

    // Append new banner image if uploaded
    if (fileUpload.value && fileUpload.value[0]) {
        payload.append('banner_image', fileUpload.value[0].file);
    }

    // Append new featured image if uploaded
    if (imageUpload.value && imageUpload.value[0]) {
        payload.append('featured_image', imageUpload.value[0].file);
    }

    try {
        await axios.post(`/api/events/${form.id}?_method=PUT`, payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });

        // Redirect to events list with success message
        router.push({
            name: 'Events',
            query: { toast: 'Event updated successfully' }
        });
    } catch (err) {
        toast.validationError(err); // Handles Laravel validation errors
    }
};

// Optional props (kept for compatibility, ID comes from route)
defineProps({
    id: {
        type: [String, Number],
    }
});

// Load data on component mount
onMounted(() => {
    fetchEvent();
    fetchCategories();
});
</script>
