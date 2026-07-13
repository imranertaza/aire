<template>
    <DashboardHeader title="Create Page" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Create Page</h3>
                    </div>

                    <form @submit.prevent="submitPage">
                        <div class="card-body">
                            <!-- Title & Slug -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Page Title</label>
                                        <input v-model="form.page_title"
                                            @input="form.slug = generateSlug(form.page_title)" type="text"
                                            class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input v-model="form.slug" type="text" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Breadcrumb</label>
                                        <input v-model="form.breadcrumb" type="text" class="form-control" required />
                                    </div>
                                    <!-- Short Description -->
                                    <div class="form-group">
                                        <label>Short Description</label>
                                        <input v-model="form.short_des" type="text" class="form-control" />
                                    </div>

                                    <!-- Description (Summernote) -->
                                    <div class="form-group">
                                        <label>Description</label>
                                        <RichTextEditor v-model="form.page_description"
                                            placeholder="Write your amazing post here..." class="editor">
                                        </RichTextEditor>
                                    </div>
                                    <!-- SEO Meta -->
                                    <div class="form-group">
                                        <label>Meta Title</label>
                                        <input v-model="form.meta_title" type="text" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <input v-model="form.meta_keyword" type="text" class="form-control"
                                            placeholder="comma, separated, keywords" />
                                    </div>
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea v-model="form.meta_description" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Image-->
                                    <div class="form-group">
                                        <label>Upload Image</label>
                                        <Vue3Dropzone v-model="imageFile" :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended: 1140 × 375px</small>
                                    </div>

                                    <!-- Page Type -->
                                    <div class="form-group">
                                        <label>Select Template</label>
                                        <select v-model="form.temp" class="custom-select" required>
                                            <option class="text-capitalize" v-for="template in templates"
                                                :key="template" :value="template">{{
                                                    template }}</option>
                                        </select>
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select v-model="form.status" class="custom-select">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block">Create Page</button>
                                        <RouterLink :to="{ name: 'Pages' }" class="btn btn-secondary btn-block mt-2">
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
import { useToast } from '@/composables/useToast';
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import axios from 'axios';
import { reactive, ref } from 'vue';
import RichTextEditor from '../../../components/RichTextEditor.vue';
import { onMounted } from 'vue';
import { generateSlug } from '../../../layouts/helpers/helpers';

const toast = useToast();
const imageFile = ref(null);
const templates = ref([])
const form = reactive({
    page_title: '',
    slug: '',
    short_des: '',
    page_description: '',
    f_image: null,
    status: 'Active',
    meta_title: '',
    meta_keyword: '',
    meta_description: '',
    breadcrumb: '',
    temp: 'default'
});

const submitPage = async () => {

    const payload = new FormData();

    // Append form fields
    for (const key in form) {
        if (key !== 'f_image') {
            payload.append(key, form[key]);
        }
    }
    // Append image file from Dropzone
    if (imageFile.value && imageFile.value[0]) {
        payload.append('f_image', imageFile.value[0].file);
    }

    try {
        await axios.post('/api/pages', payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        toast.success('Page created successfully!');
    } catch (error) {
        toast.validationError(error);
    }
};

onMounted(async () => {
    try {
        const response = await axios.get('/api/templates');
        templates.value = response.data;
    } catch (error) {
        toast.error('Failed to load templates.');
    }
});
</script>
