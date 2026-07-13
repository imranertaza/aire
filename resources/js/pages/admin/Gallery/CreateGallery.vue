<template>
    <DashboardHeader title="Create Gallery" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Create Gallery</h3>
                    </div>

                    <form @submit.prevent="submitGallery">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <!-- Gallery Name -->
                                    <div class="form-group">
                                        <label>Gallery Name</label>
                                        <input v-model="form.name" type="text" class="form-control" required />
                                    </div>

                                    <!-- Alt Name -->
                                    <div class="form-group">
                                        <label>Alt Name</label>
                                        <input v-model="form.alt_name" type="text" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label>Scope</label>
                                        <select v-model="form.scope" class="custom-select">
                                            <option value="0">National</option>
                                            <option value="1">International</option>
                                            <option value="2">National Non-Sports</option>
                                        </select>
                                    </div>
                                    <!-- Sort Order -->
                                    <div class="form-group">
                                        <label>Sort Order</label>
                                        <input v-model="form.sort_order" type="number" class="form-control" />
                                    </div>


                                    <!-- Buttons -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-success btn-block">Create
                                                    Gallery</button>
                                            </div>
                                            <div class="col-md-6">
                                                <RouterLink :to="{ name: 'Gallery' }"
                                                    class="btn btn-secondary btn-block">Cancel
                                                </RouterLink>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <!-- Thumb Image -->
                                    <div class="form-group">
                                        <label>Upload Thumbnail</label>
                                        <Vue3Dropzone v-model="imageFile" :allowSelectOnPreview="true" />
                                        <small class="text-muted">Recommended:262 × 230px</small>
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

// Toast notifications
const toast = useToast();

// Dropzone reference for thumbnail upload
const imageFile = ref(null);

// Reactive form state
const initialForm = { name: '', alt_name: '', sort_order: 0, thumb: null, scope: 0 }
const form = reactive({ ...initialForm })
/**
 * Submit gallery item creation
 */
const submitGallery = async () => {
    const payload = new FormData();

    // Append text fields
    for (const key in form) {
        if (key !== 'thumb') {
            payload.append(key, form[key]);
        }
    }

    // Append thumbnail image if uploaded
    if (imageFile.value && imageFile.value[0]) {
        payload.append('thumb', imageFile.value[0].file);
    }

    try {
        await axios.post('/api/gallery', payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        Object.assign(form, initialForm)
        imageFile.value = null;
        toast.success('Gallery created successfully!');
    } catch (error) {
        toast.validationError(error);
    }
};
</script>
