<template>
    <DashboardHeader title="Update News" />

    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Edit News</h3>
                    </div>

                    <form @submit.prevent="updateNews">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Title & Slug -->
                                    <div class="form-group">
                                        <label>News Title</label>
                                        <input v-model="form.news_title"
                                            @input="form.slug = generateSlug(form.news_title)" type="text"
                                            class="form-control" required />
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
                                            placeholder="Write your news details here..." class="editor">
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
                                                class="icheck-primary category-item border-bottom">
                                                <!-- Parent Category -->
                                                <input type="checkbox" class="form-check-input" :id="'cat-' + cat.id"
                                                    :value="cat.id" v-model="form.categories" />
                                                <label class="form-check-label d-block mb-3" :for="'cat-' + cat.id">
                                                    {{ cat.category_name }}
                                                </label>

                                                <!-- Child Categories -->
                                                <div v-if="cat.children && cat.children.length" class="ml-2 mt-1">
                                                    <div v-for="child in cat.children" :key="child.id"
                                                        class="icheck-primary form-check category-child">
                                                        <input type="checkbox" class="form-check-input"
                                                            :id="'cat-' + child.id" :value="child.id"
                                                            v-model="form.categories" />
                                                        <label class="form-check-label d-block mb-2"
                                                            :for="'cat-' + child.id">
                                                            {{ child.category_name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Featured</label>

                                        <div class="icheck-primary">
                                            <input type="radio" class="form-radio-input" id="yes" :value="1"
                                                v-model="form.featured" />
                                            <label class="form-check-label" for="yes">Yes</label>
                                        </div>

                                        <div class="icheck-primary">
                                            <input type="radio" class="form-radio-input" id="no" :value="0"
                                                v-model="form.featured" />
                                            <label class="form-check-label" for="no">No</label>
                                        </div>
                                    </div>

                                    <!-- Banner Image Upload -->
                                    <div class="form-group">
                                        <label>Upload Banner Image or Video (Max 500MB)</label>
                                        <Vue3Dropzone acceptedFiles="image/*,video/*" :maxFileSize="500"
                                            v-model="imageFile" v-model:previews="previews" mode="edit"
                                            :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended: 1140 × 375px</small>

                                        <!-- Banner Preview -->
                                        <div v-if="previews && previews.length" class="mt">
                                            <template v-for="(file, index) in previews" :key="index">
                                                <video v-if="isVideo(file)" :src="file" controls class="rounded mb-2"
                                                    height="100"></video>
                                                <img v-else :src="file" alt="Preview" class="rounded mb-2"
                                                    height="100" />
                                            </template>
                                        </div>
                                    </div>
                                    <!-- Featured Image Upload -->
                                    <div class="form-group">
                                        <label>Upload Featured Image</label>
                                        <Vue3Dropzone v-model="f_imageFile" v-model:previews="f_previews" mode="edit"
                                            :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended: 548 × 340px</small>
                                    </div>

                                    <!-- Alt Name -->
                                    <div class="form-group">
                                        <label>Alt Name</label>
                                        <input v-model="form.alt_name" type="text" class="form-control" />
                                    </div>

                                    <!-- Publish Date -->
                                    <div class="form-group">
                                        <p>
                                            <b>Publish Date</b> <br />
                                            <span>{{ form.publish_date }}</span>
                                        </p>
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
                                        <RouterLink :to="{ name: 'News' }" class="btn btn-secondary btn-block mt-2">
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
import RichTextEditor from "../../../components/RichTextEditor.vue";
import { generateSlug } from "../../../layouts/helpers/helpers";

// Toast notifications
const toast = useToast();

// Route & router
const route = useRoute();
const router = useRouter();

// News ID from route params
const newsId = route.params.id;

// Dropzone previews for existing images
const previews = ref([]);      // Main image preview
const f_previews = ref([]);    // Featured image preview

// Dropzone file references for new uploads
const imageFile = ref(null);   // New main image
const f_imageFile = ref(null); // New featured image

// Helper to detect video files by extension
const isVideo = (file) => {
    const ext = file.split("?")[0].split(".").pop().toLowerCase();
    return ["mp4", "avi", "mov", "wmv", "webm", "mkv"].includes(ext);
};

// Reactive form state for editing news
const form = reactive({
    news_title: "",
    slug: "",
    short_des: "",
    description: "",
    image: "",               // Existing image path (preview only)
    f_image: "",             // Existing featured image path (preview only)
    alt_name: "",
    featured: 0,
    publish_date: "",
    status: "1",
    meta_title: "",
    meta_keyword: "",
    meta_description: "",
    createdBy: 1,
    updatedBy: null,
    categories: [],          // Selected category IDs
    id: null                 // Filled from API response
});

// Available news categories for selection
const categories = ref([]);

/**
 * Fetch the news item for editing
 */
const fetchNews = async () => {
    try {
        const res = await axios.get(`/api/news/${newsId}`);
        const news = res.data.data;
        // Populate form
        Object.assign(form, news);

        // Extract category IDs
        form.categories = news.categories?.map((c) => c.id) || [];

        // Set existing image previews
        if (news.image) {
            previews.value = [getImageUrl(news.image)];
        }
        if (news.f_image) {
            f_previews.value = [getImageUrl(news.f_image)];
        }
    } catch (err) {
        toast.error("Failed to load news");
        console.error(err);
    }
};

/**
 * Update the news item
 * Uses FormData + spoofed PUT via _method=PUT
 */
const updateNews = async () => {
    const payload = new FormData();

    if (!f_previews.value[0]) {
        payload.append("remove_f_image", 1);
    }
    if (!previews.value[0]) {
        payload.append("remove_image", 1);
    }
    // Append all fields except image placeholders
    for (const key in form) {
        if (key !== "image" && key !== "f_image") {
            payload.append(key, form[key] ?? "");
        }
    }

    // Append new main image if uploaded
    if (imageFile.value && imageFile.value[0]) {
        payload.append("image", imageFile.value[0].file);
    }

    // Append new featured image if uploaded
    if (f_imageFile.value && f_imageFile.value[0]) {
        payload.append("f_image", f_imageFile.value[0].file);
    }

    // Append categories as array
    form.categories.forEach((catId) => {
        payload.append("categories[]", catId);
    });

    try {
        await axios.post(`/api/news/${form.id}?_method=PUT`, payload, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        router.push({ name: "News", query: { toast: "News updated successfully" } });
    } catch (err) {
        toast.validationError(err);
    }
};

/**
 * Load all news categories for selection
 */
const fetchCategories = async () => {
    try {
        const res = await axios.get("/api/news-categories?all=1");
        categories.value = res.data.data;
    } catch (err) {
        toast.error("Failed to load categories");
    }
};


// Optional props (kept for compatibility)
defineProps({
    id: {
        type: [Number, String],
        required: false,
    },
});

// Load data on mount
onMounted(() => {
    fetchCategories();
    fetchNews();
});
</script>
<style scoped>
.category-list {
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 6px;
    background: #f9f9f9;
    max-height: 350px;
    overflow-y: auto;
}

.category-item {
    margin-bottom: 6px;
}
</style>
