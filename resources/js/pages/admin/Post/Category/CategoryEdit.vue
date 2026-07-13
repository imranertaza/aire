<template>
    <DashboardHeader title="Edit Category" />

    <section class="mt-3">
        <div class="card">
            <div class="card-body">
                <form v-if="form" @submit.prevent="updateCategory">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">
                            <!-- Category Name -->
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input v-model="form.category_name" type="text" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Breadcrumb</label>
                                <input v-model="form.breadcrumb" type="text" class="form-control" required />
                            </div>
                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea v-model="form.description" class="form-control"></textarea>
                            </div>

                            <!-- Parent Category -->
                            <div class="mb-3">
                                <label class="form-label">Parent Category</label>
                                <Multiselect v-model="form.parent_id" :options="categoriesOptions"
                                    :reduce="(option) => option.value" placeholder="Select parent category" searchable
                                    allow-empty />
                            </div>

                            <!-- Meta Title -->
                            <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input v-model="form.meta_title" type="text" class="form-control" />
                            </div>

                            <!-- Meta Description -->
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <input v-model="form.meta_description" type="text" class="form-control" />
                            </div>

                            <!-- Meta Keyword -->
                            <div class="mb-3">
                                <label class="form-label">Meta Keyword</label>
                                <input v-model="form.meta_keyword" type="text" class="form-control" />
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4">
                            <!-- Image Upload -->
                            <div class="mb-3">
                                <label class="form-label">Category Image</label>
                                <!-- Existing image preview -->
                                <Vue3Dropzone v-model="imageFile" v-model:previews="previews" mode="edit"
                                    :allowSelectOnPreview="true" />
                                <small class="text-muted">Recommended: 1140 × 586px</small>
                            </div>

                            <!-- Alt Name -->
                            <div class="mb-3">
                                <label class="form-label">Alt Name</label>
                                <input v-model="form.alt_name" type="text" class="form-control" />
                            </div>

                            <!-- Sort Order -->
                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <input v-model="form.sort_order" type="number" class="form-control" />
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select v-model="form.status" class="custom-select">
                                    <option :value="1">Active</option>
                                    <option :value="0">Inactive</option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                                </div>
                                <div class="col-md-6">
                                    <router-link :to="{ name: 'CategoryIndex' }"
                                        class="btn btn-secondary btn-block">Cancel</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useRoute } from "vue-router";
import DashboardHeader from "@/components/DashboardHeader.vue";
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import "@jaxtheprime/vue3-dropzone/dist/style.css";
import { getImageUrl } from "@/layouts/helpers/helpers";
import { useToast } from "@/composables/useToast";
import Multiselect from "@vueform/multiselect";
const toast = useToast();
const route = useRoute();
const form = ref(null);
const categories = ref([]);
const imageFile = ref(null);
const previews = ref([]);

const fetchCategory = async () => {
    try {
        const res = await axios.get(`/api/categories/${route.params.id}`);
        form.value = res.data.data;
        if (form.value.image) {
            previews.value = [getImageUrl(form.value.image)];
        }
    } catch (error) {
        toast.error("Failed to load category");
    }
};

const fetchCategories = async () => {
    try {
        const res = await axios.get("/api/categories?all=1");
        categories.value = res.data.data;
    } catch (error) {
        toast.error("Failed to load categories");
    }
};
const categoriesOptions = computed(() => {
    return [
        { label: "-- None --", value: "" },
        ...categories.value.map((cat) => ({
            label: cat.category_name,
            value: cat.id,
        })),
    ];
});
const updateCategory = async () => {
    const payload = new FormData();

    for (const key in form.value) {
        if (key !== "image") {
            payload.append(key, form.value[key] ?? "");
        }
    }

    if (imageFile.value && imageFile.value[0]) {
        payload.append("image", imageFile.value[0].file);
    }

    if (!previews.value[0]) {
        payload.append("remove_image", 1);
    }

    try {
        const res = await axios.post(
            `/api/categories/${route.params.id}?_method=PUT`,
            payload,
            {
                headers: { "Content-Type": "multipart/form-data" },
            }
        );
        form.value = res.data.data;
        toast.success("Category updated successfully!");
    } catch (error) {
        toast.validationError(error);
    }
};

defineProps({
    id: {
        type: [String, Number],
    },
});
onMounted(() => {
    fetchCategory();
    fetchCategories();
});
</script>
