<template>
    <DashboardHeader title="Create Brand" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Create Brand</h3>
                    </div>

                    <form @submit.prevent="submitBrand">
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
                                        <input v-model="form.sort_order" type="number" class="form-control" />
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <!-- File Upload -->
                                    <div class="form-group">
                                        <label>Upload Image</label>
                                        <Vue3Dropzone v-model="fileUpload" :allowSelectOnPreview="true" />
                                        <small class="text-muted">Maximum File Size: 4MB (Image only)</small>
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
                                        <button type="submit" class="btn btn-success btn-block">Submit</button>
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
import DashboardHeader from '@/components/DashboardHeader.vue';
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import axios from 'axios';
import { reactive, ref } from 'vue';
import { useToast } from '@/composables/useToast';
import { useRouter } from 'vue-router';

const toast = useToast();
const router = useRouter();
const fileUpload = ref(null);

const form = reactive({
    name: '',
    alt_name: '',
    sort_order: 0,
    status: '1',
});

const submitBrand = async () => {
    const payload = new FormData();

    for (const key in form) {
        payload.append(key, form[key]);
    }

    if (fileUpload.value && fileUpload.value[0]) {
        payload.append('image', fileUpload.value[0].file);
    }

    try {
        await axios.post('/api/brands', payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        toast.success('Brand created successfully!');
        router.push({ name: 'Brands' });
    } catch (error) {
        toast.validationError(error);
    }
};
</script>
