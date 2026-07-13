<template>
    <DashboardHeader :title="news?.title || 'Blog Details'" :back="true" @back="goBack()" />

    <section class="content-header">
        <div class="container-fluid">
            <div v-if="news" class="card shadow-sm">
                <!-- News image preview -->
                <div class="card-body">
                    <h6 class="font-weight-bold" v-if="news.image"> Banner Image</h6>
                    <img v-if="news.image"  :src="getImageUrl(news.image)"
                        class="card-img-top img-fluid" loading="lazy" :alt="news.alt_name || news.title" />
                    <h6 v-if="news.f_image" class="font-weight-bold mt-3"> Featured Image</h6>
                    <img v-if="news.f_image"  :src="getImageUrl(news.f_image)"
                        class="card-img-top img-fluid" loading="lazy" :alt="news.alt_name || news.title" />

                    <h5 class="card-title mt-3">{{ news.title }}</h5>
                    <p class="card-text" v-html="news.description"></p>

                    <!-- Categories -->
                    <div v-if="news.categories && news.categories.length" class="mt-3">
                        <h6 class="font-weight-bold">Categories</h6>
                        <a href="#" v-for="cat in news.categories" :key="cat.id">
                            <span class="badge border ml-2">{{ cat.parent?.category_name ? cat.parent.category_name + '>': ''}}{{ cat.category_name }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div v-else class="alert alert-warning">Loading blog...</div>
        </div>
    </section>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { getImageUrl } from '@/layouts/helpers/helpers';

// Current route instance (to access slug param)
const route = useRoute();

// Single blog post data
const news = ref(null);
import { useNavigation } from '@/composables/useNavigation';
const { goBack } = useNavigation();
/**
 * Fetch the individual blog post by slug on component mount
 */
onMounted(async () => {
    try {
        const response = await axios.get(`/api/blogs/${route.params.id}`);
        news.value = response.data.data; // Expected: { title, description, image, ... }
    } catch (error) {
        console.error('Error fetching blog:', error);
        // Optional: redirect or show toast error in production
    }
});

// Props (optional - kept for potential future use, though slug is read from route)
// If you prefer props over route params, use props.slug instead of route.params.slug
defineProps({
    id: {
        type: [String, Number],
    }
});
</script>
