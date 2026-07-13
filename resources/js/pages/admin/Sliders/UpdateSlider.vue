<template>
    <DashboardHeader title="Update Slider" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Edit Slider</h3>
                    </div>

                    <form @submit.prevent="updateSlide">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <!-- Title -->
                                    <div class="form-group">
                                        <label>Slide Title</label>
                                        <input v-model="form.title" type="text" class="form-control" required />
                                    </div>

                                    <!-- Link -->
                                    <div class="form-group">
                                        <label>Link</label>
                                        <input v-model="form.link" type="text" class="form-control" />
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea v-model="form.description" class="form-control" rows="5"
                                            placeholder="Write slide description here..."></textarea>
                                    </div>

                                    <!-- Order -->
                                    <div class="form-group">
                                        <label>Order</label>
                                        <input v-model="form.order" type="number" class="form-control" min="1" />
                                    </div>

                                    <!-- Enabled -->
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select v-model="form.enabled" class="custom-select">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <!-- File Upload -->
                                    <div class="form-group">
                                        <label>Upload Image</label>
                                        <Vue3Dropzone v-model="fileUpload" v-model:previews="previews" mode="edit"
                                            :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended:1400 × 528px</small>
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-success btn-block">
                                            Update
                                        </button>
                                        <RouterLink :to="{ name: 'Sliders' }" class="btn btn-secondary btn-block mt-2">
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
import DashboardHeader from "@/components/DashboardHeader.vue";
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import "@jaxtheprime/vue3-dropzone/dist/style.css";
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import { useToast } from "@/composables/useToast";
import { useRoute } from "vue-router";
import { getImageUrl } from "../../../layouts/helpers/helpers";

/* Edit Banner Slide Page */

const toast = useToast();
const fileUpload = ref(null); // new uploaded image
const previews = ref([]);     // current image preview

const form = reactive({
    id: "",
    key: "banner_section",
    title: "",
    description: "",
    link: "",
    order: 1,
    enabled: 1,
    image: "",
});

const route = useRoute();

/* Load slide data on mount */
onMounted(() => {
    form.id = route.params.id;
    getSlider();
});

/* Fetch existing slide details */
const getSlider = async () => {
    try {
        const response = await axios.get(`/api/sliders/${form.id}/show`);
        Object.assign(form, response.data.data);

        previews.value = [getImageUrl(form.image)];
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
        if (key !== "image") {
            payload.append(key, String(form[key] ?? ""));
        }
    }

    if (fileUpload.value && fileUpload.value[0]) {
        payload.append("image", fileUpload.value[0].file);
    }

    try {
        await axios.post(`/api/sliders/${form.id}`, payload, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        toast.success("Slide updated successfully!");
    } catch (error) {
        toast.validationError(error);
    }
};

defineProps({
    id: {
        type: [String, Number],
        required: true,
    },
});
</script>
