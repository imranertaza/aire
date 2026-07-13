<template>
  <DashboardHeader :title="player?.name || 'Player Details'" :back="true" @back="goBack()" />

  <section class="content-header">
    <div class="container-fluid">
      <div v-if="player" class="card shadow-sm">
        <!-- Player image preview -->
        <div>
          <img
            v-if="player.image"
            height="300"
            :src="getImageUrl(player.image)"
            class="img-fluid rounded"
            loading="lazy"
            :alt="player.name"
          />
        </div>

        <div class="card-body">
          <h5 class="card-title">{{ player.name }}</h5>
          <p class="card-text">
            <strong>Sport:</strong> {{ player.sport }} <br />
            <strong>Position:</strong> {{ player.position || '-' }} <br />
            <strong>Team:</strong> {{ player.team || '-' }} <br />
            <strong>Country:</strong> {{ player.country || '-' }} <br />
            <strong>Birthdate:</strong>
            {{ player.birthdate ? new Date(player.birthdate).toLocaleDateString() : '-' }} <br />
            <strong>Age:</strong> {{ player.age ?? '-' }} <br />
            <strong>Height:</strong> {{ player.height || '-' }} <br />
            <strong>Weight:</strong> {{ player.weight || '-' }} <br />
            <strong>Hometown:</strong> {{ player.hometown || '-' }} <br />
            <strong>Asian Ranking:</strong> {{ player.asian_ranking || '-' }} <br />
            <strong>National Ranking:</strong> {{ player.national_ranking || '-' }} <br />
            <strong>Status:</strong>
            <span :class="player.status == 1 ? 'text-success' : 'text-danger'">
              {{ player.status == 1 ? 'Active' : 'Inactive' }}
            </span>
          </p>
        </div>
      </div>
      <div v-else class="alert alert-warning">Loading player...</div>
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
const player = ref(null);

onMounted(async () => {
  try {
    const response = await axios.get(`/api/players/${route.params.id}`);
    player.value = response.data.data;
  } catch (error) {
    console.error('Error fetching player:', error);
  }
});

defineProps({
  id: {
    type: [String, Number],
  },
});
</script>
