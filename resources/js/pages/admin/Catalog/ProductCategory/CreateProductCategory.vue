<template>
    <DashboardHeader title="Create Product Category" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Create Product Category</h3>
                    </div>

                    <form @submit.prevent="submitCategory">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Category Name <span class="text-danger">*</span></label>
                                        <input v-model="form.category_name" type="text" class="form-control" required />
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Alt Name</label>
                                        <input v-model="form.alt_name" type="text" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label>Parent Category</label>
                                        <select v-model="form.parent_id" class="form-control">
                                            <option :value="null">None (Top Level)</option>
                                            <option v-for="cat in parentCategories" :key="cat.id" :value="cat.id">
                                                {{ cat.category_name }}
                                            </option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea v-model="form.description" class="form-control" rows="3"></textarea>
                                    </div>

                                    <h5 class="mt-4">SEO Meta Data</h5>
                                    <hr />
                                    <div class="form-group">
                                        <label>Meta Title</label>
                                        <input v-model="form.meta_title" type="text" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea v-model="form.meta_description" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <input v-model="form.meta_keyword" type="text" class="form-control" />
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

                                    <div class="form-group">
                                        <label>Icon Type</label>
                                        <div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="iconTypeClass" class="custom-control-input" value="class" v-model="form.icon_type">
                                                <label class="custom-control-label" for="iconTypeClass">Icon Class</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="iconTypeModel" class="custom-control-input" value="model" v-model="form.icon_type">
                                                <label class="custom-control-label" for="iconTypeModel">Custom Icon</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" v-if="form.icon_type === 'class'">
                                        <label>Icon Class</label>
                                        <IconPicker v-model="form.icon_class" />
                                        <small class="text-muted">FontAwesome or Bootstrap icon class</small>
                                    </div>
                                    
                                    <div class="form-group" v-if="form.icon_type === 'model'">
                                        <label>Select Custom Icon</label>
                                        <div class="d-flex flex-wrap border p-2 rounded" style="max-height: 200px; overflow-y: auto;">
                                            <div v-for="iconItem in icons" :key="iconItem.id" class="m-1 p-2 border rounded text-center" 
                                                :class="{'border-primary bg-light shadow-sm': form.icon_id === iconItem.id}" 
                                                @click="form.icon_id = iconItem.id" style="width: 50px; height: 50px; cursor: pointer;">
                                                <div v-html="iconItem.code" style="width: 30px; height: 30px; margin: 0 auto; display: flex; align-items: center; justify-content: center;"></div>
                                            </div>
                                        </div>
                                        <small class="text-muted" v-if="!form.icon_id">Please select an icon.</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Sort Order</label>
                                        <input min="0" v-model="form.sort_order" type="number" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label>Header Menu</label>
                                        <select v-model="form.header_menu" class="custom-select">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Side Menu</label>
                                        <select v-model="form.side_menu" class="custom-select">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select v-model="form.status" class="custom-select" required>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-success btn-block">Submit</button>
                                        <RouterLink :to="{ name: 'ProductCategories' }" class="btn btn-secondary btn-block mt-2">
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
import IconPicker from '@/components/IconPicker.vue';
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import axios from 'axios';
import { reactive, ref, onMounted } from 'vue';
import { useToast } from '@/composables/useToast';
import { useRouter } from 'vue-router';

const toast = useToast();
const router = useRouter();
const fileUpload = ref(null);
const parentCategories = ref([]);
const icons = ref([]);

const form = reactive({
    category_name: '',
    alt_name: '',
    parent_id: null,
    description: '',
    meta_title: '',
    meta_description: '',
    meta_keyword: '',
    icon_type: 'class',
    icon_class: '',
    icon_id: null,
    sort_order: 0,
    header_menu: 0,
    side_menu: 0,
    status: 1,
});

onMounted(async () => {
    try {
        const [catRes, iconRes] = await Promise.all([
            axios.get('/api/product-categories/all'),
            axios.get('/api/icons')
        ]);
        parentCategories.value = catRes.data.data;
        icons.value = iconRes.data.data;
    } catch (error) {
        console.error('Failed to load data:', error);
    }
});

const submitCategory = async () => {
    const payload = new FormData();

    for (const key in form) {
        if (key === 'icon_type') continue; // Don't send icon_type to backend
        
        let value = form[key];
        
        // Nullify the unselected icon field
        if (key === 'icon_class' && form.icon_type !== 'class') value = '';
        if (key === 'icon_id' && form.icon_type !== 'model') value = '';
        
        if (value !== null && value !== undefined) {
            payload.append(key, value);
        }
    }

    if (fileUpload.value && fileUpload.value[0]) {
        payload.append('image', fileUpload.value[0].file);
    }

    try {
        await axios.post('/api/product-categories', payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        toast.success('Category created successfully!');
        router.push({ name: 'ProductCategories' });
    } catch (error) {
        toast.validationError(error);
    }
};
</script>
