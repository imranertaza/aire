<template>
    <DashboardHeader :title="event?.title || 'Event Details'" :back="true" @back="goBack()" />

    <section class="content-header">
        <div class="container-fluid">
            <div v-if="event" class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ event.title }}</h5>
                    <p class="card-text" v-html="event.description"></p>
                    <div v-if="event.featured_image" class="">
                        <h6>Featured Image</h6>
                        <img v-if="event.featured_image" height="300"
                            :src="getImageCacheUrl(event.featured_image, 300, 300)"
                            class="card-img-top object-fit-cover" loading="lazy" :alt="event.title + ' Featured'" />
                    </div>
                    <div v-if="event.banner_image" class="">
                        <h6>Banner Image</h6>
                        <img v-if="event.banner_image" height="300"
                            :src="getImageCacheUrl(event.banner_image, 300, 300)" class="card-img-top object-fit-cover"
                            loading="lazy" :alt="event.title + ' Banner'" />
                    </div>

                </div>
            </div>
            <div v-else class="alert alert-warning">Loading event...</div>
        </div>
    </section>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { getImageUrl } from '@/layouts/helpers/helpers';
import { useNavigation } from '@/composables/useNavigation';
import { getImageCacheUrl } from '../../../layouts/helpers/helpers';
const { goBack } = useNavigation();
// Current route instance (to access slug param)
const route = useRoute();

// Single event data (fetched from API)
const event = ref(null);

/**
 * Helper: Check if a file path is an image (based on extension)
 * @param {string} filePath - Path or URL of the file
 * @returns {boolean}
 */
const isImage = (filePath) => {
    return /\.(jpg|jpeg|png|gif|webp)$/i.test(filePath);
};

/**
 * Fetch the individual event by slug on component mount
 */
onMounted(async () => {
    try {
        const response = await axios.get(`/api/events/${route.params.id}`);
        event.value = response.data.data; // Expected: { title, description, banner_image, featured_image, ... }
    } catch (error) {
        console.error('Error fetching event:', error);
        // Optional: show toast or redirect in production
    }
});

// Optional props (kept for flexibility, though slug is primarily from route)
defineProps({
    id: {
        type: [String, Number],
    }
});
</script>
