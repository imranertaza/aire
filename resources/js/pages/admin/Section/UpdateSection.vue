<template>
    <DashboardHeader title="Update Section" />

    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Edit Section - {{ form.key }}</h3>
                    </div>

                    <form @submit.prevent="updateSections">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <!-- Notice Title -->
                                    <div class="form-group">
                                        <label>Section Title</label>
                                        <input v-model="form.title" @input="form.name = generateSlug(form.title)"
                                            type="text" class="form-control" required />
                                    </div>
                                    <!-- Description -->
                                    <div class="form-group">
                                        <label>Section Content</label>
                                        <RichTextEditor v-model="form.content"
                                            placeholder="Write notice details here..." class="editor" />
                                    </div>
                                    <div v-if="form.home_content && form.key == 'about_mission_vision'"
                                        class="form-group">
                                        <label>Home Page Content </label>
                                        <RichTextEditor v-model="form.home_content"
                                            placeholder="Write notice details here..." class="editor" />
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <!-- File Upload -->
                                    <div class="form-group">
                                        <label>Upload Image</label>
                                        <Vue3Dropzone v-model="fileUpload" v-model:previews="previews" mode="edit"
                                            :allowSelectOnPreview="true" />
                                        <small v-if="form.key == 'history_history'" class="text-muted">Recommended: 520
                                            × 705px</small>
                                        <small v-else class="text-muted">Recommended: 448 × 375px</small>

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
                                        <button type="submit" class="btn btn-success btn-block">
                                            Update
                                        </button>
                                        <RouterLink :to="{ name: 'Section' }" class="btn btn-secondary btn-block mt-2">
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
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";

import DashboardHeader from "@/components/DashboardHeader.vue";
import { useToast } from "@/composables/useToast";
import { getImageUrl } from "@/layouts/helpers/helpers";
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import "@jaxtheprime/vue3-dropzone/dist/style.css";
import RichTextEditor from "@/components/RichTextEditor.vue";
import { generateSlug } from "../../../layouts/helpers/helpers";

/**
 * Edit Section Page
 *
 * Allows editing of dynamic content sections (e.g., About Us, Mission/Vision, Banner).
 * Supports rich text editing, image/PDF upload, and conditional fields based on section key.
 */

const toast = useToast();
const route = useRoute();
const router = useRouter();

// Reactive form state
const form = reactive({
    id: null,              // Section ID
    title: "",             // Section title (for some sections)
    key: "",               // Section identifier (e.g., 'about_us', 'banner_section')
    content: "",           // Main rich text content
    home_content: "",      // Optional home page variant content
    file: "",              // Stored file path (image or PDF)
    image: "",             // Stored image path (alias for file in some contexts)
    status: "1",           // Publication status
    createdBy: 1,          // Creator user ID
    updatedBy: null,       // Updater user ID
});

// File upload handling
const fileUpload = ref([]);      // Holds uploaded file from dropzone
const previews = ref([]);        // Preview URLs for images
const previewsPdf = ref([]);     // Preview URLs for PDFs (not defined in original — see note below)

// Utility: Check if filename is a PDF
const isPdf = (filename) => /\.pdf$/i.test(filename);

// Fetch existing section data on mount
const fetchSections = async () => {
    try {
        const res = await axios.get(`/api/sections/${route.params.id}`);
        const sectionData = res.data.data;

        // Populate form with section data
        Object.assign(form, sectionData.data);
        form.key = sectionData.name;
        form.id = sectionData.id;

        // Set image preview if exists
        if (form.image) {
            previews.value = [getImageUrl(form.image)];
        } else if (form.file && isPdf(form.file)) {
            // Note: previewsPdf is referenced but not declared — likely a bug in original
            // Assuming it should use previews.value for consistency
            previews.value = [getImageUrl(form.file)];
        }
    } catch (err) {
        toast.error("Failed to load section data");
    }
};

// Submit updated section
const updateSections = async () => {
    let data = {};

    // Conditional payload based on section type
    if (form.key !== "banner_section") {
        data = {
            title: form.title,
            content: form.content,
            home_content: form.home_content || null,
            image: form.image || null,
        };
    }

    const payload = new FormData();
    if (!previews.value[0]) {
        payload.append('remove_image', 1);
    }
    payload.append("data", JSON.stringify(data));

    // Append new uploaded file if present
    if (fileUpload.value && fileUpload.value[0]) {
        payload.append("image", fileUpload.value[0].file);
    }

    try {
        await axios.post(`/api/sections/${form.id}?_method=PUT`, payload, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        // Redirect with success toast message
        router.push({
            name: "Section",
            query: { toast: "Section updated successfully" },
        });
    } catch (err) {
        toast.validationError(err);
    }
};

// Props definition (likely used by parent or route)
defineProps({
    id: {
        type: [String, Number],
        required: true,
    },
});

// Load section data when component mounts
onMounted(() => {
    fetchSections();
});
</script>
