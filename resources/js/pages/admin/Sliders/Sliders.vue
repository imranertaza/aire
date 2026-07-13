<template>
  <DashboardHeader title="Manage Sliders">
    <div class="d-flex justify-content-end">
      <SearchBox @search="onSearch" />
    </div>
  </DashboardHeader>

  <section>
    <div class="row">
      <div class="col-md-12">
        <div v-if="notices?.data?.length === 0" class="alert alert-info">No notices found.</div>

        <div v-else>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="thead-light">
                <tr class="align-middle">
                  <th style="width: 10px">#</th>
                  <th>Title</th>
                  <th v-if="authStore.hasPermission('manage-frontend')">Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(notice, index) in notices?.data" :key="notice.id">
                  <td class="align-middle">{{ index + 1 }}</td>
                  <td class="align-middle">{{ truncateText(notice.title, 20) }}</td>

                  <td v-if="authStore.hasPermission('manage-frontend')" class="align-middle">
                    <select v-model="notice.enabled" @change="toggleStatus(notice)" class="custom-select"
                      :class="notice.enabled == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                      <option :value="1">Active</option>
                      <option :value="0">Inactive</option>
                    </select>
                  </td>
                  <td class="align-middle">
                    <div class="d-flex">
                      <!-- <router-link v-if="authStore.hasPermission('edit-sections')"
                        :to="{ name: 'ShowSliders', params: { id: notice.id } }" class="btn btn-sm btn-outline-dark">
                        <i class="fas fa-eye"></i>
                      </router-link> -->
                      <router-link v-if="authStore.hasPermission('manage-frontend')"
                        :to="{ name: 'UpdateSlider', params: { id: notice.id } }"
                        class="ml-2 btn btn-sm btn-outline-info">
                        <i class="fas fa-pencil-alt"></i>
                      </router-link>
                      <button v-if="authStore.hasPermission('manage-frontend')"
                        class="ml-2 btn btn-sm btn-outline-danger" @click="confirmDelete(notice)">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <Pagination :pData="notices" @page-change="fetchPage" />
        </div>
      </div>
    </div>
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

/* Banner Slides Management Page */

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');

const notices = ref([]); // banner slides list

/* Fetch banner slides */
const fetchPage = async (page = 1, term = "") => {
  try {
    const res = await axios.get(`/api/sliders/banner_section`);
    notices.value = res.data.data;
  } catch (error) {
    console.error(error);
    toast.error('Failed to load banner section.');
  }
};

/* Handle search */
const onSearch = async (term) => {
  fetchPage(1, term);
};

/* Toggle slide enabled/disabled */
const toggleStatus = async (notice) => {
  try {
    const response = await axios.patch(`/api/sliders/${notice.id}/toggle`);
    notice.enabled = response.data.data.enabled;
    toast.success(response.data.message);
  } catch (error) {
    toast.error('Failed to toggle status');
    console.error(error);
  }
};

/* Confirm and delete slide */
const confirmDelete = async (notice) => {
  const result = await $swal({
    title: `Delete "${notice.title}"?`,
    text: 'This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete',
    cancelButtonText: 'Cancel',
    reverseButtons: true
  });

  if (result.isConfirmed) {
    try {
      await axios.delete(`/api/sliders/${notice.id}`);
      toast.success('Slider deleted successfully!');
      notices.value.data = notices.value.data.filter(n => n.id !== notice.id);
    } catch (error) {
      toast.validationError(error);
    }
  } else {
    toast.info('Deletion cancelled.');
  }
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
</script>
