<template>
    <DashboardHeader title="Create Blog" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Create Blog</h3>
                    </div>

                    <form @submit.prevent="submitNews">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">

                                    <!-- Title & Slug -->
                                    <div class="form-group">
                                        <label>Blog Title</label>
                                        <input v-model="form.title" @input="form.slug = generateSlug(form.title)"
                                            type="text" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input v-model="form.slug" type="text" class="form-control" required />
                                    </div>

                                    <!-- Short Description -->
                                    <div class="form-group">
                                        <label>Short Description</label>
                                        <input v-model="form.short_des" type="text" class="form-control" required />
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label>Description</label>
                                        <RichTextEditor v-model="form.description"
                                            placeholder="Write your blog details here..." class="editor">
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
                                    <!-- Category Selector -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Categories</label>
                                        <div class="category-list">
                                            <div v-for="cat in categories" :key="cat.id"
                                                class="icheck-primary form-check category-item border-bottom">
                                                <!-- Parent Category -->
                                                <input type="checkbox" class="form-check-input" :id="'cat-' + cat.id"
                                                    :value="cat.id" v-model="form.categories" />
                                                <label class="form-check-label d-block mb-4" :for="'cat-' + cat.id">
                                                    {{ cat.category_name }}
                                                </label>

                                                <!-- Child Categories -->
                                                <div v-if="cat.children && cat.children.length" class="ml-2 mt-1">
                                                    <div v-for="child in cat.children" :key="child.id"
                                                        class="form-check icheck-primary category-child">
                                                        <input type="checkbox" class="form-check-input"
                                                            :id="'cat-' + child.id" :value="child.id"
                                                            v-model="form.categories" />
                                                        <label class="form-check-label d-block mb-3"
                                                            :for="'cat-' + child.id">
                                                            {{ child.category_name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- Image & Alt -->
                                    <div class="form-group">
                                        <label>Upload Banner Image</label>
                                        <Vue3Dropzone v-model="imageFile" :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended: 1140 × 375px</small>

                                    </div>
                                    <!-- Featured Image & Alt -->
                                    <div class="form-group">
                                        <label>Upload Featured Image</label>
                                        <Vue3Dropzone v-model="fImageFile" :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended: 358 × 226px</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Alt Name</label>
                                        <input v-model="form.alt_name" type="text" class="form-control" />
                                    </div>
                                    <!-- Status -->
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select v-model="form.status" class="custom-select">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="">
                                        <button type="submit" class="btn btn-success btn-block">Submit</button>
                                        <RouterLink :to="{ name: 'Blog' }" class="btn btn-secondary btn-block mt-2">
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
import { onMounted, reactive, ref } from 'vue';
import { useToast } from '@/composables/useToast';
import RichTextEditor from '../../../components/RichTextEditor.vue';
import { generateSlug } from '../../../layouts/helpers/helpers';

// Toast notifications
const toast = useToast();

// Dropzone file references (main image)
const imageFile = ref(null);

// Dropzone file references (featured image)
const fImageFile = ref(null);

// Reactive form state
const form = reactive({
    title: '',
    slug: '',
    short_des: '',
    description: '',
    alt_name: '',
    publish_date: '',
    status: '1',              // 1 = published, 0 = draft
    meta_title: '',
    meta_keyword: '',
    meta_description: '',
    image: null,              // preview URL (not sent)
    f_image: null,            // preview URL (not sent)
    categories: []            // array of selected category IDs
});

// Available blog categories for multi-select
const categories = ref([]);

/**
 * Fetch all blog categories on mount (per_page=0 to get all)
 */
const fetchCategories = async () => {
    try {
        const res = await axios.get('/api/blog-categories?per_page=0');
        categories.value = res.data.data;
    } catch (err) {
        toast.validationError(err);
    }
};

onMounted(() => {
    fetchCategories();
});

/**
 * Handle blog creation form submission
 */
const submitNews = async () => {
    const payload = new FormData();

    // Append all text fields
    for (const key in form) {
        if (key !== 'image' && key !== 'f_image') {
            payload.append(key, form[key] || '');
        }
    }

    // Append main image from Dropzone
    if (imageFile.value && imageFile.value[0]) {
        payload.append('image', imageFile.value[0].file);
    }

    // Append featured image from Dropzone
    if (fImageFile.value && fImageFile.value[0]) {
        payload.append('f_image', fImageFile.value[0].file);
    }

    // Append categories as categories[]
    form.categories.forEach(catId => {
        payload.append('categories[]', catId);
    });

    try {
        await axios.post('/api/blogs', payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        toast.success('Blog created successfully!');
        // Optional: redirect or reset form here
    } catch (error) {
        toast.validationError(error); // handles 422 validation errors nicely
        console.error('Blog creation failed:', error);
    }
};

</script>
<style scoped>
.category-list {
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 6px;
    background: #f9f9f9;
    max-height: 410px;
    overflow-y: auto;
}

.category-item {
    margin-bottom: 6px;
}
</style>
