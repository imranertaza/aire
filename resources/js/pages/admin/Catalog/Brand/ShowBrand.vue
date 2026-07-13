<template>
    <DashboardHeader :title="brand?.name || 'Brand Details'" :back="true" @back="goBack()" />

    <section class="content-header">
        <div class="container-fluid">
            <div v-if="brand" class="card shadow-sm">
                <!-- Brand image preview -->
                <img v-if="brand.image" height="300" :src="getImageUrl(brand.image)"
                    class="card-img-top object-fit-cover" loading="lazy" :alt="brand.name" />
                <div class="card-body">
                    <h5 class="card-title mb-3"><strong>Name:</strong> {{ brand.name }}</h5>
                    <p class="card-text"><strong>Alternative Name:</strong> {{ brand.alt_name || 'N/A' }}</p>
                    <p class="card-text"><strong>Sort Order:</strong> {{ brand.sort_order }}</p>
                    <p class="card-text"><strong>Status:</strong> 
                        <span :class="brand.status == 1 ? 'badge badge-success' : 'badge badge-secondary'">
                            {{ brand.status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>
            </div>
            <div v-else class="alert alert-warning">Loading brand...</div>
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
const brand = ref(null);
import { useNavigation } from '@/composables/useNavigation';
const { goBack } = useNavigation();

onMounted(async () => {
    try {
        const response = await axios.get(`/api/brands/${route.params.id}`);
        brand.value = response.data.data;
    } catch (error) {
        console.error('Error fetching brand:', error);
    }
});

defineProps({
    id: {
        type: [String, Number],
    }
});
</script>
