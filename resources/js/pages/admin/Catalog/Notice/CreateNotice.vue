<template>
    <DashboardHeader title="Create Notice" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Create Notice</h3>
                    </div>

                    <form @submit.prevent="submitNotice">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <!-- Title & Slug -->
                                    <div class="form-group">
                                        <label>Notice Title</label>
                                        <input v-model="form.title" @input="form.slug = generateSlug(form.title)"
                                            type="text" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input v-model="form.slug" type="text" class="form-control" required />
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label>Description</label>
                                        <RichTextEditor v-model="form.description"
                                            placeholder="Write notice details here..." class="editor"></RichTextEditor>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <!-- File Upload -->
                                    <div class="form-group">
                                        <label>Upload File (Image/PDF)</label>
                                        <Vue3Dropzone v-model="fileUpload" :allowSelectOnPreview="true" />
                                        <small class="text-muted">Maximum File Size: 4MB</small>
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select v-model="form.status" class="custom-select">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <!-- Type -->
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select v-model="form.type" class="custom-select">
                                            <option value="0">Notice</option>
                                            <option value="1">Match Fixtures</option>
                                        </select>
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-success btn-block">Submit</button>
                                        <RouterLink :to="{ name: 'Notices' }" class="btn btn-secondary btn-block mt-2">
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
import DashboardHeader from '@/components/DashboardHeader.vue';
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import axios from 'axios';
import { reactive, ref } from 'vue';
import { useToast } from '@/composables/useToast';
import RichTextEditor from '@/components/RichTextEditor.vue';
import { generateSlug } from '../../../layouts/helpers/helpers';

const toast = useToast();
const fileUpload = ref(null);

const form = reactive({
    title: '',
    slug: '',
    type: '0',
    description: '',
    status: '1',
    file: null
});


const submitNotice = async () => {
    const payload = new FormData();

    for (const key in form) {
        if (key !== 'file') {
            payload.append(key, form[key]);
        }
    }

    if (fileUpload.value && fileUpload.value[0]) {
        payload.append('file', fileUpload.value[0].file);
    }

    try {
        await axios.post('/api/notices', payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        toast.success('Notice created successfully!');
    } catch (error) {
        toast.validationError(error);
    }
};
</script>
