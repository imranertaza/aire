<template>
  <DashboardHeader title="Manage Sections">
    <div class="d-flex justify-content-end">
      <SearchBox @search="onSearch" />
    </div>
  </DashboardHeader>

  <section>
    <div class="row">
      <div class="col-md-12">
        <!-- Empty State -->
        <div v-if="!sections || sections?.data?.length === 0" class="alert alert-info">
          No sections found.
        </div>

        <!-- Table -->
        <div v-else>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="thead-light">
                <tr class="align-middle">
                  <th style="width: 10px">#</th>
                  <th>Section Name</th>
                  <th>Title</th>
                  <th>Has Image</th>
                  <th>Preview</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(section, index) in sections?.data" :key="section.id">
                  <td class="align-middle">{{ index + 1 + (sections.current_page - 1) * sections.per_page }}</td>
                  <td class="align-middle">
                    <code class="bg-light px-2 py-1 rounded">{{ section.name }}</code>
                  </td>
                  <td class="align-middle">
                    {{ truncateText(section.data.title || '—', 40) }}
                  </td>
                  <td class="align-middle text-center">
                    <i :class="section.data.image ? 'fas fa-check text-success' : 'fas fa-times text-danger'"></i>
                  </td>
                  <td class="align-middle">
                    <button v-if="section.data.image" @click="previewImage(getImageUrl(section.data.image))"
                      class="btn btn-sm btn-outline-primary">
                      <i class="fas fa-image"></i> Preview
                    </button>
                    <span v-else class="text-muted">—</span>
                  </td>
                  <td class="align-middle">
                    <div class="d-flex gap-2">
                      <!-- Edit Sliders -->

                      <router-link v-if="authStore.hasPermission('manage-frontend') && section.name != 'banner_section'"
                        :to="{ name: 'UpdateSection', params: { id: section.id } }" class="btn btn-sm btn-outline-info"
                        title="Edit">
                        <i class="fas fa-eye"></i>
                      </router-link>

                      <!-- Edit Sliders -->
                      <router-link v-if="authStore.hasPermission('manage-frontend') && section.name == 'banner_section'"
                        :to="{ name: 'UpdateSectionSliders', params: { id: section.id } }" class="btn btn-sm btn-outline-info"
                        title="Edit Sliders">
                        <i class="fas fa-eye"></i>
                      </router-link>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <Pagination :pData="sections" @page-change="fetchPage" />
        </div>
      </div>
    </div>
  </section>

  <!-- Image Preview Modal -->
  <div v-if="previewUrl" class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.8);">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Image Preview</h5>
          <button type="button" class="close" @click="previewUrl = null">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <img :src="previewUrl" class="img-fluid" style="max-height: 80vh;" alt="Preview" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';

import DashboardHeader from '@/components/DashboardHeader.vue';
import SearchBox from '@/components/SearchBox.vue';
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';
import { getImageUrl, truncateText } from '@/layouts/helpers/helpers';
import { useAuthStore } from '@/store/auth';


const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();
const toast = useToast();

// Reactive state
const sections = ref([]);        // Array of section records
const previewUrl = ref(null);    // URL of image currently being previewed (for modal/lightbox)

// Fetch all sections from API
const fetchPage = async (page = 1, term = '') => {
  try {
    const res = await axios.get(`/api/sections`);
    sections.value = res.data.data;
  } catch (error) {
    console.error('Error fetching sections:', error);
    toast.error('Failed to load sections.');
  }
};

// Handle search input from SearchBox component
const onSearch = (term) => {
  fetchPage(1, term);
};

// Open image preview (used by clicking on images in section preview)
const previewImage = (url) => {
  previewUrl.value = url;
};

// Lifecycle: fetch data on component mount
onMounted(() => {
  fetchPage();

  // Show success toast if redirected with a message (e.g., after update)
  if (route.query.toast) {
    toast.success(route.query.toast);

    // Clean up query param after showing toast
    setTimeout(() => {
      const q = { ...route.query };
      delete q.toast;
      router.replace({ query: q });
    }, 2000);
  }
});
</script>

<style scoped>
code {
  font-size: 0.85em;
}

.modal {
  display: block;
}
</style>
