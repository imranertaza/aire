<template>
    <DashboardHeader title="Manage Players">
        <div class="d-flex justify-content-end">
            <SearchBox @search="onSearch" />
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="players?.data?.length === 0" class="alert alert-info">No players found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Sport</th>
                                    <th>Position</th>
                                    <th>Team</th>
                                    <th>Age</th>
                                    <th>Image</th>
                                    <th v-if="authStore.hasPermission('edit-players')">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(player, index) in players?.data" :key="player.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ truncateText(player.name, 20) }}</td>
                                    <td class="align-middle">{{ player.sport }}</td>
                                    <td class="align-middle">{{ player.position }}</td>
                                    <td class="align-middle">{{ player.team }}</td>
                                    <td class="align-middle">{{ player.age }}</td>
                                    <td class="align-middle">
                                        <button v-if="player.image" @click="openImageModal(player.image)"
                                            class="text-nowrap btn btn-sm btn-outline-primary">
                                            View Image
                                        </button>
                                    </td>
                                    <td v-if="authStore.hasPermission('edit-players')" class="align-middle">
                                        <select v-model="player.status" @change="updateStatus(player)"
                                            class="custom-select"
                                            :class="player.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link v-if="authStore.hasPermission('view-players')"
                                                :to="{ name: 'ShowPlayer', params: { id: player.id } }"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link v-if="authStore.hasPermission('edit-players')"
                                                :to="{ name: 'UpdatePlayer', params: { id: player.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>
                                            <button v-if="authStore.hasPermission('delete-players')"
                                                class="ml-2 btn btn-sm btn-outline-danger"
                                                @click="confirmDelete(player)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="players" @page-change="fetchPage" />
                </div>
            </div>
        </div>

        <!-- Image Modal -->
        <div v-if="showModal" class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document" @click.stop>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Player Image</h5>
                        <button type="button" class="close" @click="closeImageModal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center" style="max-height:75vh; overflow-y: auto;">
                        <img :src="modalImage" alt="Player" class="img-fluid rounded border" />
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="modal-backdrop fade show" @click="closeImageModal"></div>
    </section>
</template>

<script setup>
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { inject, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';
import { getImageUrl, truncateText } from '@/layouts/helpers/helpers';
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';

const router = useRouter();
const route = useRoute();
const players = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');

const showModal = ref(false);
const modalImage = ref('');
const currentSearchTerm = ref("");
const openImageModal = (imagePath) => {
    modalImage.value = getImageUrl(imagePath);
    showModal.value = true;
};
const closeImageModal = () => {
    showModal.value = false;
    modalImage.value = '';
};

// Fetch players with pagination + search
const fetchPage = async (page = 1, term = "") => {
    try {
        const res = await axios.get(`/api/players?page=${page}&search=${currentSearchTerm.value}`);
        players.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load players.');
    }
};

const onSearch = async (term) => {
    currentSearchTerm.value = term;
    fetchPage();
};

onMounted(() => {
    fetchPage();
    if (route.query.toast) {
        toast.success(route.query.toast);
        setTimeout(() => {
            const q = { ...route.query };
            delete q.toast;
            router.replace({ query: q });
        }, 2000);
    }
});

// Update player status
const updateStatus = async (player) => {
    try {
        const response = await axios.patch(`/api/players/${player.id}/toggle-status`);
        player.status = response.data.data.status;
        toast.success(response.data.message);
    } catch (error) {
        toast.error('Failed to update status');
        console.error(error);
    }
};

// Delete player
const confirmDelete = async (player) => {
    const result = await $swal({
        title: `Delete "${player.name}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/players/${player.id}`);
            toast.success('Player deleted successfully!');
            players.value.data = players.value.data.filter(p => p.id !== player.id);
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
