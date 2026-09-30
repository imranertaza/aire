<template>
    <DashboardHeader :title="news?.news_title || 'News Details'" :back="true" @back="goBack()" />

    <section class="content-header">
        <div class="container-fluid">
            <div v-if="news" class="card shadow-sm">

                <!-- News image preview -->
                <img v-if="news.image && !isVideo(news?.image)" height="300" :src="getImageUrl(news.image)"
                    class="card-img-top object-fit-cover" loading="lazy" :alt="news.alt_name || news.news_title" />
                <video controls="true" v-if="news.image && isVideo(news?.image)" :src="getImageUrl(news.image)"></video>
                <div class="card-body">
                    <h5 class="card-title">{{ news.news_title }}</h5>
                    <p class="card-text" v-html="news.description"></p>

                    <!-- Categories -->
                    <div v-if="news.categories && news.categories.length" class="mt-3">
                        <h6 class="font-weight-bold">Categories</h6>
                        <a href="#" v-for="cat in news.categories" :key="cat.id">
                            <span class="badge border ml-2">{{ cat.parent?.category_name ? cat.parent.category_name +
                                '>' : ''}}{{ cat.category_name }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div v-else class="alert alert-warning">Loading news...</div>
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
const { goBack } = useNavigation();
// Current route (to access slug param)
const route = useRoute();

// Single news item data
const news = ref(null);

/**
 * Check if the file is a video based on extension
 */
const isVideo = (file) => {
    if (!file) return false;

    // Extract extension from path or URL (ignore query params)
    const ext = file.split("?")[0].split(".").pop().toLowerCase();

    const videoExts = ["mp4", "avi", "mov", "wmv", "webm", "mkv"];
    return videoExts.includes(ext);
};

/**
 * Fetch the news detail by slug on component mount
 */
onMounted(async () => {
    try {
        const response = await axios.get(`/api/news/${route.params.id}`);
        news.value = response.data.data;
    } catch (error) {
        console.error('Error fetching news:', error);
    }
});

// Optional props (kept for flexibility, slug primarily from route)
defineProps({
    id: {
        type: [String, Number],
    }
});
</script>
