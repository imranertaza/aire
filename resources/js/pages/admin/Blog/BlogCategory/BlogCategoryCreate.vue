<template>
    <DashboardHeader title="Create Blog Category" />

    <section class="mt-3">
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="createCategory">
                    <!-- Category Name -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input v-model="form.category_name" type="text" class="form-control" required />
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
                                    :reduce="option => option.value" placeholder="Select parent category" searchable />
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

                        <div class="col-md-4">
                            <!-- Image -->
                            <div class="mb-3">
                                <label class="form-label">Category Image</label>
                                <Vue3Dropzone v-model="imageFile" :allowSelectOnPreview="true" />
                                <small class="text-muted">Recommended: 1140 × 375px</small>
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
                                    <button type="submit" class="btn btn-success btn-block">Create</button>

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
import { reactive, ref, onMounted, computed } from 'vue';
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
import { useToast } from '@/composables/useToast';

// Toast notifications
const toast = useToast();

// Dropzone reference for category image upload
const imageFile = ref(null);

// Reactive form state for new category
const form = reactive({
    category_name: '',
    description: '',
    parent_id: '',            // '' = no parent (root category)
    meta_title: '',
    meta_description: '',
    meta_keyword: '',
    image: null,              // Preview URL (not sent)
    alt_name: '',
    sort_order: 0,
    status: 1                 // 1 = active, 0 = inactive
});

// List of all existing categories (for parent selection)
const categories = ref([]);

/**
 * Fetch all categories for parent dropdown (all=1 returns flat list)
 */
const fetchCategories = async () => {
    try {
        const res = await axios.get('/api/blog-categories?all=1');
        categories.value = res.data.data;
    } catch (error) {
        toast.error('Failed to load categories');
        console.error(error);
    }
};

/**
 * Create a new blog category
 * Builds FormData payload with image support
 */
const createCategory = async () => {
    const payload = new FormData();

    // Append all form fields except image placeholder
    for (const key in form) {
        if (key !== 'image') {
            payload.append(key, form[key] ?? '');
        }
    }

    // Append image file if selected via Dropzone
    if (imageFile.value && imageFile.value[0]) {
        payload.append('image', imageFile.value[0].file);
    }

    try {
        await axios.post('/api/blog-categories', payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });

        toast.success('Category created successfully!');

        // Reset form to initial state
        Object.assign(form, {
            category_name: '',
            description: '',
            parent_id: '',
            meta_title: '',
            meta_description: '',
            meta_keyword: '',
            image: null,
            alt_name: '',
            sort_order: 0,
            status: 1,
        });

        // Clear Dropzone preview/upload
        imageFile.value = null;
    } catch (error) {
        toast.validationError(error); // Handles Laravel 422 validation nicely
    }
};

/**
 * Options for parent category multiselect/dropdown
 * Includes '-- None --' as first option
 */
const categoriesOptions = computed(() => {
    return [
        { label: '-- None --', value: '' },
        ...categories.value.map(cat => ({
            label: cat.category_name,
            value: cat.id
        }))
    ];
});

// Load categories when component mounts
onMounted(fetchCategories);
</script>
<style>
.v-select {
    background-color: white;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

.v-select .vs__dropdown-toggle {
    padding: 0.375rem 0.75rem;
    border: none;
}

.v-select .vs__selected-options {
    padding: 0;
}

.v-select .vs__search {
    padding: 0;
}
</style>
