<template>
    <DashboardHeader title="Update Post" />

    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Edit Post</h3>
                    </div>

                    <form @submit.prevent="updatePost">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Title & Slug -->
                                    <div class="form-group">
                                        <label>Post Title</label>
                                        <input v-model="form.post_title"
                                            @input="form.slug = generateSlug(form.post_title)" type="text"
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

                                    <!-- Image Upload -->
                                    <div class="form-group">
                                        <label>Upload Banner Image</label>
                                        <Vue3Dropzone v-model="imageFile" v-model:previews="previews" mode="edit"
                                            :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended: 1140 × 375px</small>
                                    </div>
                                    <!-- Featured Image Upload -->
                                    <div class="form-group">
                                        <label>Upload Featured Image</label>
                                        <Vue3Dropzone v-model="fImageFile" v-model:previews="f_previews" mode="edit"
                                            :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended: 262 × 230px</small>
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
                                    <div class="">
                                        <button type="submit" class="btn btn-success btn-block">
                                            Update
                                        </button>
                                        <RouterLink :to="{ name: 'Posts' }" class="btn btn-secondary btn-block mt-2">
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
import { computed, onMounted, reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import DashboardHeader from "@/components/DashboardHeader.vue";
import { useToast } from "@/composables/useToast";
import { getImageUrl } from "@/layouts/helpers/helpers";
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import "@jaxtheprime/vue3-dropzone/dist/style.css";
import RichTextEditor from "../../../components/RichTextEditor.vue";
import { generateSlug } from "../../../layouts/helpers/helpers";

const toast = useToast();
const route = useRoute();
const router = useRouter();
const postId = route.params.id;
const previews = ref([]);
const f_previews = ref([]);

const form = reactive({
    post_title: "",
    slug: "",
    short_des: "",
    description: "",
    image: "",
    f_image: "",
    alt_name: "",
    publish_date: "",
    status: "1",
    meta_title: "",
    meta_keyword: "",
    meta_description: "",
    createdBy: 1,
    updatedBy: null,
    categories: [],
});

const imageFile = ref(null);
const fImageFile = ref(null);

const fetchPost = async () => {
    try {
        const res = await axios.get(`/api/posts/${postId}`); // your post show API
        Object.assign(form, res.data.data);

        form.categories = res.data.data.categories.map((c) => c.id);
        if (form.image) {
            previews.value = [getImageUrl(form.image)];
        }
        f_previews.value = [getImageUrl(form.f_image)];
    } catch (err) {
        toast.error("Failed to load post");
        console.error(err);
    }
};

const categories = ref([]);

const fetchCategories = async () => {
    try {
        const res = await axios.get("/api/categories?all=1"); // your category index API
        categories.value = res.data.data;
    } catch (err) {
        toast.error("Failed to load categories");
    }
};

const updatePost = async () => {
    const payload = new FormData();

    if (!f_previews.value[0]) {
        payload.append("remove_f_image", 1);
    }
    if (!previews.value[0]) {
        payload.append("remove_image", 1);
    }
    // Append all non-file fields
    for (const key in form) {
        if (key !== "image" && key !== "f_image") {
            payload.append(key, form[key] ?? "");
        }
    }

    // Append image only if a new file is selected
    if (imageFile.value?.[0]?.file) {
        payload.append("image", imageFile.value[0].file);
    }

    // Append f_image only if a new file is selected
    if (fImageFile.value?.[0]?.file) {
        payload.append("f_image", fImageFile.value[0].file);
    }

    // Append categories
    form.categories.forEach((catId) => {
        payload.append("categories[]", catId);
    });

    try {
        await axios.post(`/api/posts/${form.id}?_method=PUT`, payload, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        router.push({ name: "Posts", query: { toast: "Post updated successfully" } });
    } catch (err) {
        toast.validationError(err);
    }
};

const formattedDate = computed({
    get: () => form.publish_date?.slice(0, 10) || "",
    set: (val) => (form.publish_date = val),
});

defineProps({
    id: {
        type: [Number, String],
        required: false,
    },
});

onMounted(() => {
    fetchCategories();
    fetchPost();
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
