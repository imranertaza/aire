<template>
    <DashboardHeader title="Create Player" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Create Player</h3>
                    </div>

                    <form @submit.prevent="submitPlayer">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label>Player Name</label>
                                        <input v-model="form.name" type="text" class="form-control" required />
                                    </div>

                                    <!-- Sport -->
                                    <div class="form-group">
                                        <label>Sport</label>
                                        <input v-model="form.sport" type="text" class="form-control" required />
                                    </div>

                                    <!-- Position -->
                                    <div class="form-group">
                                        <label>Position</label>
                                        <input v-model="form.position" type="text" class="form-control" required />
                                    </div>

                                    <!-- Team -->
                                    <div class="form-group">
                                        <label>Team</label>
                                        <input v-model="form.team" type="text" class="form-control" required />
                                    </div>

                                    <!-- Country -->
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input v-model="form.country" type="text" class="form-control" />
                                    </div>

                                    <!-- Birthdate -->
                                    <div class="form-group">
                                        <label>Birthdate</label>
                                        <input v-model="form.birthdate" type="date" class="form-control" required />
                                    </div>

                                    <!-- Height -->
                                    <div class="form-group">
                                        <label>Height (cm)</label>
                                        <input v-model="form.height" type="text" class="form-control" />
                                    </div>

                                    <!-- Weight -->
                                    <div class="form-group">
                                        <label>Weight (kg)</label>
                                        <input v-model="form.weight" type="text" class="form-control" />
                                    </div>

                                    <!-- Hometown -->
                                    <div class="form-group">
                                        <label>Hometown</label>
                                        <input v-model="form.hometown" type="text" class="form-control" />
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4">
                                    <!-- Image Upload -->
                                    <div class="form-group">
                                        <label>Upload Image</label>
                                        <Vue3Dropzone v-model="fileUpload" :allowSelectOnPreview="true" required />
                                        <small class="text-muted">Recommended: 262 × 225px</small>
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
                                        <RouterLink :to="{ name: 'Players' }" class="btn btn-secondary btn-block mt-2">
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
import axios from 'axios';
import { reactive, ref } from 'vue';
import { useToast } from '@/composables/useToast';

const toast = useToast();
const fileUpload = ref(null);

const form = reactive({
    name: '',
    sport: '',
    position: '',
    team: '',
    country: '',
    birthdate: '',
    height: '',
    weight: '',
    hometown: '',
    status: '1',
    image: null
});

const submitPlayer = async () => {
    const payload = new FormData();

    for (const key in form) {
        if (key !== 'image') {
            payload.append(key, form[key]);
        }
    }

    if (fileUpload.value && fileUpload.value[0]) {
        payload.append('image', fileUpload.value[0].file);
    }

    try {
        await axios.post('/api/players', payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        toast.success('Player created successfully!');
    } catch (error) {
        toast.validationError(error);
    }
};
</script>
