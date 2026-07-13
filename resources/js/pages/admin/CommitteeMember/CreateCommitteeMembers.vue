<template>
    <DashboardHeader title="Create Committee Member" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Create Committee Member</h3>
                    </div>

                    <form @submit.prevent="submitMember">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input v-model="form.name" @input="form.slug = generateSlug(form.name)" type="text" class="form-control" required />
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

                                    <!-- Description () -->
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
                                        <Vue3Dropzone v-model="fileUpload" :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended:265 × 379px</small>
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
                                        <button type="submit" class="btn btn-success btn-block">Submit</button>
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
import DashboardHeader from '@/components/DashboardHeader.vue';
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import axios from 'axios';
import { reactive, ref } from 'vue';
import { useToast } from '@/composables/useToast';
import RichTextEditor from '../../../components/RichTextEditor.vue';
import { generateSlug } from '../../../layouts/helpers/helpers';

// Toast notifications
const toast = useToast();

// Dropzone reference for member image upload
const fileUpload = ref(null);

// Reactive form state for new committee member
const form = reactive({
    name: '',
    slug: '',
    designation: '',
    description: '',
    order: 1,                 // Display/sort order
    status: '1',              // '1' = active, '0' = inactive
    image: null               // Preview URL (not sent to server)
});

/**
 * Submit the committee member creation form
 * Builds FormData payload including optional image
 */
const submitMember = async () => {
    const payload = new FormData();

    // Append all text fields
    for (const key in form) {
        if (key !== 'image') {
            payload.append(key, form[key] ?? '');
        }
    }

    // Append image file if uploaded via Dropzone
    if (fileUpload.value && fileUpload.value[0]) {
        payload.append('image', fileUpload.value[0].file);
    }

    try {
        await axios.post('/api/committee-members', payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });

        toast.success('Committee member created successfully!');

        Object.assign(form, { name: '', designation: '', slug: '', description: '', order: 1, status: '1', image: null });
        fileUpload.value = null;
    } catch (error) {
        toast.validationError(error); // Better handling for validation (422) errors
    }
};
</script>
