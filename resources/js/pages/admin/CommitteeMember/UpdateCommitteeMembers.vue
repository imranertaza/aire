<template>
    <DashboardHeader title="Update Committee Member" />

    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Edit Committee Member</h3>
                    </div>

                    <form @submit.prevent="updateMember">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input v-model="form.name" @input="form.slug = generateSlug(form.name)"
                                            type="text" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input v-model="form.slug" type="text" class="form-control" required />
                                    </div>
                                    <!-- Designation -->
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <input v-model="form.designation" type="text" class="form-control" required />
                                    </div>
                                    <!-- Description -->
                                    <div class="form-group">
                                        <label>Description</label>
                                        <RichTextEditor v-model="form.description"
                                            placeholder="Write your amazing post here..." class="editor">
                                        </RichTextEditor>
                                    </div>
                                    <!-- Order -->
                                    <div class="form-group">
                                        <label>Order</label>
                                        <input v-model="form.order" type="number" class="form-control" min="1" />
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <!-- Image Upload -->
                                    <div class="form-group">
                                        <label>Upload Image</label>
                                        <Vue3Dropzone v-model="fileUpload" v-model:previews="previews" mode="edit"
                                            :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended:265 × 379px</small>

                                        <!-- Preview -->
                                        <div v-if="previews && previews.length" class="mt-3">
                                            <div v-for="(preview, idx) in previews" :key="idx">
                                                <img :src="preview" alt="Preview" class="img-fluid rounded border"
                                                    style="max-height:120px" />
                                            </div>
                                        </div>
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
                                        <RouterLink :to="{ name: 'CommitteeMembers' }"
                                            class="btn btn-secondary btn-block mt-2">Cancel</RouterLink>
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
import { onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { useToast } from '@/composables/useToast';
import { getImageUrl } from '@/layouts/helpers/helpers';
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import RichTextEditor from '../../../components/RichTextEditor.vue';
import { generateSlug, getImageCacheUrl } from '../../../layouts/helpers/helpers';

// Toast notifications
const toast = useToast();

// Route & router
const route = useRoute();
const router = useRouter();

// Dropzone preview for existing image
const previews = ref([]);

// Dropzone reference for new image upload
const fileUpload = ref(null);

// Reactive form state for editing committee member
const form = reactive({
    id: null,
    name: '',
    slug: '',
    designation: '',
    description: '',
    image: '',      // Existing image path (used only for preview)
    order: 1,       // Display/sort order
    status: '1'     // '1' = active, '0' = inactive
});

/**
 * Fetch the committee member data for editing
 */
const fetchMember = async () => {
    try {
        const res = await axios.get(`/api/committee-members/${route.params.id}`);
        const member = res.data.data;

        // Normalize description: if null/undefined, set to empty string
        member.description = member.description ?? '';

        // Populate form with fetched data
        Object.assign(form, member);

        // Show existing image in Dropzone preview if present
        if (member.image) {
            previews.value = [getImageCacheUrl(member.image)];
        }
    } catch (err) {
        toast.error('Failed to load committee member');
        console.error('Fetch member error:', err);
    }
};

/**
 * Update the committee member
 * Uses FormData + spoofed PUT method via _method=PUT
 */
const updateMember = async () => {
    const payload = new FormData();
    if (!previews.value[0]) {
        payload.append('remove_image', 1);
    }
    // Append all fields except image placeholder
    for (const key in form) {
        if (key !== 'image') {
            payload.append(key, form[key] ?? '');
        }
    }

    // Append new image if uploaded
    if (fileUpload.value && fileUpload.value[0]) {
        payload.append('image', fileUpload.value[0].file);
    }

    try {
        await axios.post(`/api/committee-members/${form.id}?_method=PUT`, payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });

        // Redirect to index with success toast
        router.push({
            name: 'CommitteeMembers',
            query: { toast: 'Committee member updated successfully' }
        });
    } catch (err) {
        toast.validationError(err); // Handles Laravel validation errors nicely
    }
};

// Load member data on mount
onMounted(() => {
    form.id = route.params.id;
    fetchMember();
});
defineProps({
    id: {
        type: [String, Number], // accepts both string and number
        required: true
    }
})
</script>
