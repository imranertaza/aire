<template>
    <DashboardHeader :title="notice?.title || 'Notice Details'" :back="true" @back="goBack()" />

    <section class="content-header">
        <div class="container-fluid">
            <div v-if="notice" class="card shadow-sm">
                <!-- Notice file preview -->
                <img v-if="notice.file && isImage(notice.file)" height="300" :src="getImageUrl(notice.file)"
                    class="card-img-top object-fit-cover" loading="lazy" :alt="notice.title" />
                <div class="card-body">
                    <h5 class="card-title">{{ notice.title }}</h5>
                    <p class="card-text" v-html="notice.description"></p>

                    <!-- If file is not an image, show download link -->
                    <div v-if="notice.file && !isImage(notice.file)" class="mt-3">
                        <a :href="getImageUrl(notice.file)" target="_blank" class="btn btn-sm btn-outline-primary">
                            Download File
                        </a>
                    </div>
                </div>
            </div>
            <div v-else class="alert alert-warning">Loading notice...</div>
        </div>
    </section>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { getImageUrl } from '@/layouts/helpers/helpers';

const route = useRoute();
const notice = ref(null);
import { useNavigation } from '@/composables/useNavigation';
const { goBack } = useNavigation();
// helper to check if file is an image
const isImage = (filePath) => {
    return /\.(jpg|jpeg|png|gif)$/i.test(filePath);
};

onMounted(async () => {
    try {
        const response = await axios.get(`/api/notices/${route.params.id}`);
        notice.value = response.data.data;
    } catch (error) {
        console.error('Error fetching notice:', error);
    }
});

defineProps({
    id: {
        type: [String, Number],
    }
});
</script>
