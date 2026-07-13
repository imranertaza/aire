<template>
    <DashboardHeader :title="result?.title || 'Result Details'" :back="true" @back="goBack()" />

    <section class="content-header">
        <div class="container-fluid">
            <div v-if="result" class="card shadow-sm">
                <!-- Result file preview -->
                <img v-if="result.file && isImage(result.file)" height="300" :src="getImageUrl(result.file)"
                    class="card-img-top object-fit-cover" loading="lazy" :alt="result.title" />
                <div class="card-body">
                    <h5 class="card-title">{{ result.title }}</h5>
                    <p class="card-text" v-html="result.description"></p>

                    <!-- If file is not an image, show download link -->
                    <div v-if="result.file && !isImage(result.file)" class="mt-3">
                        <a :href="getImageUrl(result.file)" target="_blank" class="btn btn-sm btn-outline-primary">
                            Download File
                        </a>
                    </div>
                </div>
            </div>
            <div v-else class="alert alert-warning">Loading result...</div>
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

const route = useRoute();
const result = ref(null);

// helper to check if file is an image
const isImage = (filePath) => {
    return /\.(jpg|jpeg|png|gif)$/i.test(filePath);
};

onMounted(async () => {
    try {
        const response = await axios.get(`/api/results/${route.params.id}`);
        result.value = response.data.data;
    } catch (error) {
        console.error('Error fetching result:', error);
    }
});

defineProps({
    id: {
        type: [String, Number],
    }
});
</script>
