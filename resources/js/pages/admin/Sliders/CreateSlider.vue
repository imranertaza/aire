<template>
    <DashboardHeader title="Create Slider / Ad" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Create Slider / Ad</h3>
                    </div>

                    <form @submit.prevent="submitSlide">
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
                                        <small class="text-muted">Choose where this slide/ad will appear across the
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
                                            placeholder="Write slide description or campaign details here..."></textarea>
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
                                        <Vue3Dropzone v-model="fileUpload" :allowSelectOnPreview="true" :maxFiles="1" />
                                        <small class="text-muted d-block mt-1">
                                            Recommended: <strong>400 × 260px</strong> or <strong>600 × 400px</strong>
                                            (JPG/PNG/WebP)
                                        </small>
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-success btn-block">Submit</button>
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
import DashboardHeader from '@/components/DashboardHeader.vue';
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
import axios from 'axios';
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from '@/composables/useToast';

const router = useRouter();
const toast = useToast();
const fileUpload = ref(null);

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
    keys: ['category_sidebar'],
    subtitle: '',
    title: '',
    description: '',
    button_text: 'VIEW PRODUCTS',
    link: '/products',
    order: 1,
    enabled: 1,
});

/* Submit new slide */
const submitSlide = async () => {
    if (!fileUpload.value || !fileUpload.value[0]?.file) {
        toast.error('Please upload an image for the slide.');
        return;
    }

    const payload = new FormData();

    for (const key in form) {
        if (key === 'keys') {
            form.keys.forEach(k => payload.append('keys[]', k));
        } else {
            payload.append(key, form[key] ?? '');
        }
    }

    if (fileUpload.value && fileUpload.value[0]?.file) {
        payload.append('image', fileUpload.value[0].file);
    }

    try {
        await axios.post('/api/sliders', payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        toast.success('Slide created successfully!');
        router.push({ name: 'Sliders', query: { toast: 'Slide created successfully!' } });
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
