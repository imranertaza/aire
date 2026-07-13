<template>
    <DashboardHeader title="Update Page" />

    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Edit Page</h3>
                    </div>

                    <form @submit.prevent="updatePage">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Title & Slug -->
                                    <div class="form-group">
                                        <label>Page Title</label>
                                        <input v-model="form.page_title" type="text" class="form-control" required />
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

                                    <!-- Description -->
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
                                    <!-- Image Upload -->
                                    <div class="form-group">
                                        <label>Upload Image</label>
                                        <Vue3Dropzone v-model="imageFile" v-model:previews="previews" mode="edit"
                                            :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended: 1140 × 375px</small>
                                    </div>

                                    <!-- Page Type -->
                                    <div class="form-group">
                                        <label>Select Template</label>
                                        <select v-model="form.temp" class="custom-select" required>
                                            <option class="text-capitalize" v-for="template in templates"
                                                :key="template" :selected="form.temp === template" :value="template">{{
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
                                    <button type="submit" class="btn btn-success btn-block">Update</button>
                                    <button type="button" class="btn btn-secondary btn-block"
                                        @click="router.push({ name: 'Pages' })">Cancel</button>
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
import { ref, reactive, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { getImageUrl } from '@/layouts/helpers/helpers';
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import { useToast } from '@/composables/useToast';
import RichTextEditor from '../../../components/RichTextEditor.vue';

const toast = useToast();
const previews = ref([]);
const route = useRoute();
const router = useRouter();
const templates = ref([])

const form = reactive({
    page_title: '',
    slug: '',
    short_des: '',
    page_description: '',
    f_image: '',
    status: 'Active',
    meta_title: '',
    meta_keyword: '',
    meta_description: '',
    temp: 'default',
    createdBy: 1,
    breadcrumb: '',
    updatedBy: null
});

const imageFile = ref(null);


const fetchPage = async () => {
    try {
        const res = await axios.get(`/api/pages/${route.params.id}`);
        const normalized = Object.fromEntries(Object.entries(res.data.data).map(([key, value]) => [key, value ?? ""]));
        Object.assign(form, normalized);
        if (form.f_image) {
            previews.value = [getImageUrl(form.f_image)];
        }
    } catch (err) {
        console.error(err);
    }
};

const updatePage = async () => {
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
    if (!previews.value[0]) {
        payload.append('remove_f_image', 1);
    }

    try {
        await axios.post(`/api/pages/${form.id}?_method=PUT`, payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        router.push({ name: 'Pages', query: { toast: 'Page updated successfully!' } });
    } catch (err) {
        toast.validationError(err);
    }
};

onMounted(async () => {
    fetchPage();
    try {
        const response = await axios.get('/api/templates');
        templates.value = response.data;
    } catch (error) {
        toast.error('Failed to load templates.');
    }
});

defineProps({
    id: {
        type: [String, Number],
    }
})
</script>
