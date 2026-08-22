<template>
  <DashboardHeader title="Manage Sliders & Ads">
    <div class="d-flex align-items-center justify-content-end">
      <div class="mr-2">
        <select v-model="selectedKey" @change="onFilterChange" class="custom-select" style="min-width: 220px;">
          <option value="all">All Placements / Sections</option>
          <option value="category_sidebar">Category Sidebar Ads</option>
          <option value="banner_section">Homepage Main Banners</option>
          <option value="featured_ad">Featured Ads</option>
        </select>
      </div>

      <SearchBox @search="onSearch" />

      <router-link v-if="authStore.hasPermission('manage-frontend')" :to="{ name: 'CreateSlider' }"
        class="btn btn-primary ml-2 d-flex align-items-center">
        <i class="fas fa-plus mr-1"></i> Create Slider / Ad
      </router-link>
    </div>
  </DashboardHeader>

  <section class="">
    <div class="row">
      <div class="col-md-12">
        <div v-if="notices?.data?.length === 0" class="alert alert-info">No sliders or ads found.</div>

        <div v-else>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="thead-light">
                <tr class="align-middle">
                  <th style="width: 10px">#</th>
                  <th>Image</th>
                  <th>Title</th>
                  <th>Subtitle / Badge</th>
                  <th>Placement</th>
                  <th>Link</th>
                  <th style="width: 60px">Order</th>
                  <th v-if="authStore.hasPermission('manage-frontend')">Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(notice, index) in notices?.data" :key="notice.id">
                  <td class="align-middle">{{ (notices.current_page - 1) * notices.per_page + index + 1 }}</td>
                  <td class="align-middle">
                    <img v-if="notice.image" draggable="false"
                      :src="getImageCacheUrl(notice.image, 100, 100)" alt="Slider Image" height="45"
                      class="rounded border bg-light" />
                  </td>
                  <td class="align-middle">
                    <div class="font-weight-bold">{{ notice.title }}</div>
                    <small class="text-muted d-block">{{ truncateText(notice.description, 45) }}</small>
                  </td>
                  <td class="align-middle">
                    <span class="badge badge-secondary" v-if="notice.subtitle">{{ notice.subtitle }}</span>
                    <span class="text-muted" v-else>-</span>
                  </td>
                  <td class="align-middle">
                    <div class="d-flex flex-wrap gap-1">
                      <span v-for="k in parseKeys(notice.key)" :key="k" class="badge mr-1" :class="getPlacementBadge(k)">
                        {{ getPlacementLabel(k) }}
                      </span>
                    </div>
                  </td>
                  <td class="align-middle">
                    <small class="text-primary font-monospace" v-if="notice.link">{{ notice.link }}</small>
                    <span class="text-muted" v-else>-</span>
                  </td>
                  <td class="align-middle text-center">{{ notice.order }}</td>

                  <td v-if="authStore.hasPermission('manage-frontend')" class="align-middle">
                    <select v-model="notice.enabled" @change="toggleStatus(notice)" class="custom-select"
                      :class="notice.enabled == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                      <option :value="1">Active</option>
                      <option :value="0">Inactive</option>
                    </select>
                  </td>
                  <td class="align-middle">
                    <div class="d-flex">
                      <router-link v-if="authStore.hasPermission('manage-frontend')"
                        :to="{ name: 'UpdateSlider', params: { id: notice.id } }"
                        class="btn btn-sm btn-outline-info" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                      </router-link>
                      <button v-if="authStore.hasPermission('manage-frontend')"
                        class="ml-2 btn btn-sm btn-outline-danger" @click="confirmDelete(notice)" title="Delete">
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
import { getImageCacheUrl, truncateText } from '@/layouts/helpers/helpers';
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');

const notices = ref({});
const selectedKey = ref('all');
const currentSearch = ref('');

const parseKeys = (key) => {
  if (!key) return ['category_sidebar'];
  if (Array.isArray(key)) return key;
  if (key.startsWith('[') && key.endsWith(']')) {
    try { return JSON.parse(key); } catch (e) {}
  }
  return key.split(',').map(k => k.trim()).filter(Boolean);
};

const getPlacementLabel = (key) => {
  switch (key) {
    case 'category_sidebar':
      return 'Category Sidebar Ad';
    case 'banner_section':
      return 'Homepage Banner';
    case 'featured_ad':
      return 'Featured Ad';
    default:
      return key || 'General';
  }
};

const getPlacementBadge = (key) => {
  switch (key) {
    case 'category_sidebar':
      return 'badge-info';
    case 'banner_section':
      return 'badge-primary';
    case 'featured_ad':
      return 'badge-warning';
    default:
      return 'badge-secondary';
  }
};

/* Fetch sliders */
const fetchPage = async (page = 1, term = "") => {
  try {
    currentSearch.value = term;
    const res = await axios.get(`/api/sliders/${selectedKey.value}`, {
      params: {
        page,
        term: currentSearch.value,
      }
    });
    notices.value = res.data.data;
  } catch (error) {
    console.error(error);
    toast.error('Failed to load sliders list.');
  }
};

const onFilterChange = () => {
  fetchPage(1, currentSearch.value);
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
      if (notices.value && notices.value.data) {
        notices.value.data = notices.value.data.filter(n => n.id !== notice.id);
      }
    } catch (error) {
      toast.validationError(error);
    }
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
