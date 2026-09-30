<template>
    <DashboardHeader :title="`Configure ${formData.name || 'Module'}`" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div v-if="isLoading" class="text-center p-4 w-100">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                
                <div v-else class="card card-purple w-100">
                    <div class="card-header">
                        <h3 class="card-title">{{ formData.name }} Settings</h3>
                    </div>
                    
                    <form @submit.prevent="submitForm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div v-if="formData.settings.length === 0" class="alert alert-info">
                                        There are no configurable settings for this module.
                                    </div>
                                    
                                    <div v-for="(setting, index) in formData.settings" :key="index" class="form-group mb-4">
                                        <label>{{ setting.title }}</label>
                                        <input type="text" class="form-control" v-model="setting.value"
                                            :placeholder="`Enter ${setting.title}`">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer" v-if="formData.settings.length > 0">
                            <button type="submit" class="btn btn-success" :disabled="isSubmitting">
                                <span v-if="isSubmitting" class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                                Save Settings
                            </button>
                            <RouterLink :to="{ name: 'Modules' }" class="btn btn-secondary ml-2">
                                Cancel
                            </RouterLink>
                        </div>
                        <div class="card-footer" v-else>
                            <RouterLink :to="{ name: 'Modules' }" class="btn btn-secondary">
                                Back to Modules
                            </RouterLink>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useToast } from '@/composables/useToast';
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';

const router = useRouter();
const route = useRoute();
const toast = useToast();
const id = route.params.id;

const formData = ref({
    name: '',
    settings: []
});

const isSubmitting = ref(false);
const isLoading = ref(true);

const fetchModule = async () => {
    try {
        const response = await axios.get(`/api/modules/${id}`);
        const data = response.data.data;
        formData.value = {
            name: data.name,
            settings: data.settings || []
        };
    } catch (error) {
        toast.error('Failed to load module settings');
        router.push({ name: 'Modules' });
    } finally {
        isLoading.value = false;
    }
};

const submitForm = async () => {
    isSubmitting.value = true;
    try {
        await axios.put(`/api/modules/${id}/settings`, {
            settings: formData.value.settings
        });
        toast.success('Module Settings updated successfully!');
        router.push({ name: 'Modules' });
    } catch (error) {
        toast.error(error.response?.data?.message || 'Failed to update settings');
    } finally {
        isSubmitting.value = false;
    }
};

onMounted(() => {
    fetchModule();
});
</script>
