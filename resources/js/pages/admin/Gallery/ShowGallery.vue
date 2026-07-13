<template>
    <DashboardHeader :title="gallery?.name || 'Gallery Details'" :back="true" @back="goBack()" />

    <section class="content-header">
        <div class="container-fluid">
            <div v-if="gallery" class="card shadow-sm">
                <!-- Gallery Thumbnail -->
                <img v-if="gallery.thumb" height="300" :src="getImageCacheUrl(gallery.thumb, 300, 300)"
                    class="card-img-top object-fit-cover" loading="lazy" :alt="gallery.alt_name || gallery.name" />

                <div class="card-body">
                    <h5 class="card-title">{{ gallery.name }}</h5>
                    <p class="card-text text-muted" v-if="gallery.alt_name">{{ gallery.alt_name }}</p>
                    <p class="card-text"><strong>Sort Order:</strong> {{ gallery.sort_order }}</p>
                </div>

                <!-- Gallery Details (images inside gallery) -->
                <div class="card-body">
                    <h6 class="mb-3">Gallery Images</h6>
                    <div v-if="gallery.details?.length > 0" class="row">
                        <div v-for="detail in gallery.details" :key="detail.id" class="col-md-3 mb-3">
                            <img v-if="detail.image" :src="getImageCacheUrl(detail.image, 400, 300)"
                                :alt="detail.alt_name || gallery.name" class="img-fluid rounded shadow-sm" />
                            <small class="d-block text-muted mt-1">{{ detail.alt_name }}</small>
                        </div>

                    </div>
                    <div v-else class="col-12">
                        <div class="alert alert-info">No images found in this gallery.</div>
                    </div>
                </div>
            </div>

            <div v-else class="alert alert-warning">Loading gallery...</div>
        </div>
    </section>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { getImageCacheUrl } from '@/layouts/helpers/helpers';

// Current route (to get gallery ID from params)
const route = useRoute();

// Single gallery item data
const gallery = ref(null);

import { useNavigation } from '@/composables/useNavigation';
const { goBack } = useNavigation();
/**
 * Fetch the gallery item by ID on mount
 */
onMounted(async () => {
    try {
        const response = await axios.get(`/api/gallery/${route.params.id}`);
        gallery.value = response.data.data;
    } catch (error) {
        console.error('Error loading gallery:', error);
    }
});

// Props (kept for flexibility, though ID is taken from route)
defineProps({
    id: {
        type: [String, Number],
        required: true
    }
});
</script>
