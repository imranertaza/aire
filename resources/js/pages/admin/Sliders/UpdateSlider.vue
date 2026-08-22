<template>
    <DashboardHeader title="Update Slider / Ad" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Edit Slider / Ad</h3>
                    </div>

                    <form @submit.prevent="updateSlide">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <!-- Placement Key Multiselect -->
                                    <div class="form-group">
                                        <label>Placement / Section (Multi-Select)</label>
                                        <Multiselect v-model="form.keys" mode="tags" :options="placementOptions"
                                            :close-on-select="false" :searchable="true" :create-option="true"
                                            placeholder="Select one or more placements / sections"
                                            class="multiselect-custom" />
                                        <small class="text-muted">Choose where this slide/ad appears across the
                                            storefront.</small>
                                    </div>

                                    <!-- Subtitle / Badge -->
                                    <div class="form-group">
                                        <label>Badge / Tagline</label>
                                        <input v-model="form.subtitle" type="text" class="form-control"
                                            placeholder="e.g. Featured Solution, New Arrival, Commercial" />
                                    </div>

                                    <!-- Title -->
                                    <div class="form-group">
                                        <label>Slide Title</label>
                                        <input v-model="form.title" type="text" class="form-control"
                                            placeholder="e.g. The Future of Pure Living" required />
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea v-model="form.description" class="form-control" rows="4"
                                            placeholder="Write slide description here..."></textarea>
                                    </div>

                                    <!-- Button Text -->
                                    <div class="form-group">
                                        <label>Button CTA Text</label>
                                        <input v-model="form.button_text" type="text" class="form-control"
                                            placeholder="e.g. VIEW PRODUCTS, LEARN MORE, GET A QUOTE" />
                                    </div>

                                    <!-- Link -->
                                    <div class="form-group">
                                        <label>Target URL / Route Link</label>
                                        <input v-model="form.link" type="text" class="form-control"
                                            placeholder="e.g. /products, /category/solutions, https://..." />
                                    </div>

                                    <!-- Order -->
                                    <div class="form-group">
                                        <label>Order</label>
                                        <input v-model="form.order" type="number" class="form-control" min="1" />
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select v-model="form.enabled" class="custom-select"
                                            :class="form.enabled == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <!-- File Upload -->
                                    <div class="form-group">
                                        <label>Upload Slide Image</label>
                                        <Vue3Dropzone v-model="fileUpload" v-model:previews="previews" mode="edit"
                                            :allowSelectOnPreview="true" :maxFiles="1" />
                                        <small class="text-muted d-block mt-1">
                                            Recommended: <strong>400 × 260px</strong> or <strong>600 × 400px</strong>
                                        </small>

                                        <div v-if="previews && previews.length && previews[0]" class="mt-2 text-center">
                                            <img :src="previews[0]" alt="Preview" class="img-thumbnail"
                                                style="max-height: 120px;" />
                                        </div>
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-success btn-block">
                                            Update
                                        </button>
                                        <RouterLink :to="{ name: 'Sliders' }" class="btn btn-secondary btn-block mt-2">
                                            Cancel
                                        </RouterLink>
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
import DashboardHeader from "@/components/DashboardHeader.vue";
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import "@jaxtheprime/vue3-dropzone/dist/style.css";
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import { useToast } from "@/composables/useToast";
import { useRoute, useRouter } from "vue-router";
import { getImageUrl } from "../../../layouts/helpers/helpers";

const toast = useToast();
const route = useRoute();
const router = useRouter();
const fileUpload = ref(null);
const previews = ref([]);

const placementOptions = [
    { value: 'category_sidebar', label: 'Category Sidebar Ads' },
    { value: 'featured_ad', label: 'Featured Ad Card' },
    { value: 'about_us', label: 'About Us Ads' },
    { value: 'products', label: 'Products Ads' },
    { value: 'filter', label: 'Filter Products Ads' },
    { value: 'compare', label: 'Compare Page Ads' },
    { value: 'favorite', label: 'Wishlist / Favorite Page Ads' },
];

const form = reactive({
    id: "",
    keys: ['category_sidebar'],
    subtitle: "",
    title: "",
    description: "",
    button_text: "",
    link: "",
    order: 1,
    enabled: 1,
    image: "",
});

/* Load slide data on mount */
onMounted(() => {
    form.id = route.params.id;
    getSlider();
});

/* Fetch existing slide details */
const getSlider = async () => {
    try {
        const response = await axios.get(`/api/sliders/${form.id}/show`);
        const data = response.data.data;
        Object.assign(form, data);

        if (data.keys && Array.isArray(data.keys)) {
            form.keys = data.keys;
        } else if (data.key) {
            form.keys = data.key.split(',').map(k => k.trim()).filter(Boolean);
        }

        if (form.image) {
            previews.value = [getImageUrl(form.image)];
        }
    } catch (error) {
        toast.error("Failed to fetch slide details");
    }
};

/* Update slide */
const updateSlide = async () => {
    const payload = new FormData();

    if (!previews.value[0]) {
        payload.append('remove_image', 1);
    }

    for (const key in form) {
        if (key === 'keys') {
            form.keys.forEach(k => payload.append('keys[]', k));
        } else if (key !== "image") {
            payload.append(key, String(form[key] ?? ""));
        }
    }

    if (fileUpload.value && fileUpload.value[0]?.file) {
        payload.append("image", fileUpload.value[0].file);
    }

    try {
        await axios.post(`/api/sliders/${form.id}`, payload, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        toast.success("Slide updated successfully!");
        router.push({ name: 'Sliders', query: { toast: 'Slide updated successfully!' } });
    } catch (error) {
        toast.validationError(error);
    }
};
</script>

<style scoped>
.multiselect-custom {
    --ms-tag-bg: #6f42c1;
    --ms-tag-color: #ffffff;
    --ms-ring-color: rgba(111, 66, 193, 0.25);
    --ms-border-color-active: #6f42c1;
}
</style>
