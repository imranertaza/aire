<template>
    <DashboardHeader title="Update Brand" />

    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Edit Brand</h3>
                    </div>

                    <form @submit.prevent="updateBrand">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label>Brand Name</label>
                                        <input v-model="form.name" type="text" class="form-control" required />
                                    </div>
                                    
                                    <!-- Alt Name -->
                                    <div class="form-group">
                                        <label>Alt Name</label>
                                        <input v-model="form.alt_name" type="text" class="form-control" />
                                    </div>
                                    
                                    <!-- Sort Order -->
                                    <div class="form-group">
                                        <label>Sort Order</label>
                                        <input min="0" v-model="form.sort_order" type="number" class="form-control" />
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <!-- File Upload -->
                                    <div class="form-group">
                                        <label>Upload Image</label>
                                        <Vue3Dropzone v-model="fileUpload" v-model:previews="previews" mode="edit"
                                            :allowSelectOnPreview="true" />
                                        <small class="text-muted">Maximum File Size: 4MB (Image only)</small>
                                        
                                        <!-- Custom Preview -->
                                        <div v-if="previews && previews.length" class="mt-3">
                                            <div v-for="(preview, idx) in previews" :key="idx">
                                                <img :src="preview" alt="Preview"
                                                    class="img-fluid rounded border" style="max-height:120px" />
                                            </div>
                                        </div>
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
                                        <button type="submit" class="btn btn-success btn-block">Update</button>
                                        <RouterLink :to="{ name: 'Brands' }" class="btn btn-secondary btn-block mt-2">
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
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { useToast } from '@/composables/useToast';
import { getImageCacheUrl } from '@/layouts/helpers/helpers';
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';
import '@jaxtheprime/vue3-dropzone/dist/style.css';

const toast = useToast();
const route = useRoute();
const router = useRouter();
const previews = ref([]);

const form = reactive({
    id: null,
    name: '',
    alt_name: '',
    sort_order: 0,
    status: '1',
    image: '',
});

const fileUpload = ref(null);

// Fetch brand
const fetchBrand = async () => {
    try {
        const res = await axios.get(`/api/brands/${route.params.id}`);
        Object.assign(form, res.data.data);
        if (form.image) {
            previews.value = [getImageCacheUrl(form.image)];
        }
    } catch (err) {
        toast.error('Failed to load brand');
        console.error(err);
    }
};

// Update brand
const updateBrand = async () => {
    const payload = new FormData();
    if (!previews.value[0]) {
        payload.append('remove_image', 1);
    }
    
    for (const key in form) {
        if (key !== 'image') {
            payload.append(key, form[key]);
        }
    }
    
    if (fileUpload.value && fileUpload.value[0]) {
        payload.append('image', fileUpload.value[0].file);
    }

    try {
        await axios.post(`/api/brands/${form.id}?_method=PUT`, payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        router.push({ name: 'Brands', query: { toast: 'Brand updated successfully' } });
    } catch (err) {
        toast.validationError(err);
    }
};

defineProps({
    id: {
        type: [String, Number],
    }
});

onMounted(() => {
    fetchBrand();
});
</script>
