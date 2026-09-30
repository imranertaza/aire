<template>
  <DashboardHeader title="Manage Sections">
    <div class="d-flex justify-content-end">
      <SearchBox @search="onSearch" />
    </div>
  </DashboardHeader>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-th-list mr-1"></i> Sections List
              </h3>
            </div>

            <div class="card-body p-0">
              <!-- Empty State -->
              <div v-if="!sections || sections?.data?.length === 0" class="p-4 text-center text-muted">
                <i class="fas fa-info-circle fa-2x mb-2 text-info"></i>
                <p class="mb-0">No sections found.</p>
              </div>

              <!-- Table -->
              <div v-else class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0">
                  <thead class="thead-light">
                    <tr class="align-middle">
                      <th style="width: 50px" class="text-center">#</th>
                      <th>Section Identifier</th>
                      <th>Title</th>
                      <th class="text-center" style="width: 120px">Image / Type</th>
                      <th class="text-center" style="width: 120px">Preview</th>
                      <th class="text-center" style="width: 100px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(section, index) in sections?.data" :key="section.id">
                      <td class="align-middle text-center">
                        {{ index + 1 + (sections.current_page - 1) * sections.per_page }}
                      </td>
                      <td class="align-middle">
                        <code class="bg-light px-2 py-1 rounded text-primary font-weight-bold">{{ section.name }}</code>
                      </td>
                      <td class="align-middle">
                        <span class="font-weight-600">{{ truncateText(section.data?.title || section.name, 45) }}</span>
                        <span v-if="section.name === 'why_choose_aire'" class="badge badge-info ml-2">Stacked Deck</span>
                        <span v-else-if="section.name === 'trust_badges'" class="badge badge-warning ml-2">Grid Layout</span>
                        <span v-else-if="section.name === 'home_benefits' || section.name === 'benefits'" class="badge badge-info ml-2">Benefits Parallax</span>
                        <span v-else-if="section.name === 'home_faq' || section.name === 'faq'" class="badge badge-success ml-2">FAQ Accordion</span>
                          <span v-else-if="section.name === 'home_lifestyle' || section.name === 'lifestyle'" class="badge badge-purple ml-2">Lifestyle Showcase</span>
                        <span v-else-if="section.name === 'home_video' || section.name === 'video'" class="badge badge-danger ml-2">Video Banner</span>
                        <span v-else-if="section.name === 'home_best_selling' || section.name === 'best_selling'" class="badge badge-warning ml-2">Best Selling Products</span>
                        <span v-else-if="section.name === 'home_new_arrival' || section.name === 'new_arrival'" class="badge badge-info ml-2">New Arrivals</span>
                        <span v-else-if="section.name === 'home_customer_favorites' || section.name === 'customer_favorites'" class="badge badge-primary ml-2">Customer Favorites</span>
                        <span v-else-if="section.name === 'home_living_hero' || section.name === 'living_hero'" class="badge badge-teal ml-2">Living Hero</span>
                        <span v-else-if="section.name === 'client_testimonials'" class="badge badge-success ml-2">Testimonials Slider</span>
                      </td>
                      <td class="align-middle text-center">
                        <span v-if="section.name === 'why_choose_aire'" class="badge badge-purple">
                          <i class="fas fa-layer-group mr-1"></i> {{ section.data?.cards?.length || 4 }} Cards
                        </span>
                        <span v-else-if="section.name === 'trust_badges'" class="badge badge-success">
                          <i class="fas fa-shield-alt mr-1"></i> {{ section.data?.badges?.length || 5 }} Badges
                        </span>
                        <span v-else-if="section.name === 'home_benefits' || section.name === 'benefits'" class="badge badge-info">
                          <i class="fas fa-layer-group mr-1"></i> {{ section.data?.cards?.length || 6 }} Cards
                        </span>
                        <span v-else-if="section.name === 'home_lifestyle' || section.name === 'lifestyle'" class="badge badge-purple">
                          <i class="fas fa-couch mr-1"></i> {{ section.data?.items?.length || 4 }} Items
                        </span>
                        <span v-else-if="section.name === 'home_video' || section.name === 'video'" class="badge badge-danger">
                          <i class="fas fa-video mr-1"></i> Video Player
                        </span>
                        <span v-else-if="section.name === 'home_best_selling' || section.name === 'best_selling'" class="badge badge-warning">
                          <i class="fas fa-shopping-bag mr-1"></i> {{ section.data?.product_ids?.length || 0 }} Products
                        </span>
                        <span v-else-if="section.name === 'home_new_arrival' || section.name === 'new_arrival'" class="badge badge-info">
                          <i class="fas fa-box-open mr-1"></i> {{ section.data?.product_ids?.length || 0 }} Products
                        </span>
                        <span v-else-if="section.name === 'home_customer_favorites' || section.name === 'customer_favorites'" class="badge badge-primary">
                          <i class="fas fa-heart mr-1"></i> {{ section.data?.product_ids?.length || 0 }} Products
                        </span>
                        <span v-else-if="section.name === 'home_living_hero' || section.name === 'living_hero'" class="badge badge-teal text-white">
                          <i class="fas fa-wind mr-1"></i> {{ section.data?.product_id ? 'Featured Product' : 'Hero Showcase' }}
                        </span>
                        <span v-else-if="section.name === 'home_faq' || section.name === 'faq'" class="badge badge-success">
                          <i class="fas fa-question-circle mr-1"></i> {{ section.data?.items?.length || 5 }} FAQs
                        </span>
                        <span v-else-if="section.name === 'client_testimonials'" class="badge badge-primary">
                          <i class="fas fa-quote-left mr-1"></i> {{ section.data?.items?.length || 4 }} Slides
                        </span>
                        <span v-else>
                          <i :class="section.data?.image ? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-muted'"></i>
                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <button v-if="section.data?.image" @click="previewImage(getImageUrl(section.data.image))" class="btn btn-xs btn-outline-primary">
                          <i class="fas fa-image mr-1"></i> Preview
                        </button>
                        <span v-else class="text-muted">—</span>
                      </td>
                      <td class="align-middle text-center">
                        <div class="d-flex justify-content-center gap-1">
                          <router-link
                            v-if="(authStore.hasPermission('manage-frontend') || authStore.hasPermission('edit-sections') || authStore.hasPermission('view-sections')) && section.name === 'client_testimonials'"
                            :to="{ name: 'TestimonialsSection' }"
                            class="btn btn-sm btn-primary"
                            title="Manage Testimonials Slider"
                          >
                            <i class="fas fa-quote-left"></i>
                          </router-link>

                          <router-link
                            v-else-if="(authStore.hasPermission('manage-frontend') || authStore.hasPermission('edit-sections') || authStore.hasPermission('view-sections')) && section.name != 'banner_section'"
                            :to="{ name: 'UpdateSection', params: { id: section.id } }"
                            class="btn btn-sm btn-info"
                            title="Edit Section"
                          >
                            <i class="fas fa-edit"></i>
                          </router-link>

                          <router-link
                            v-if="(authStore.hasPermission('manage-frontend') || authStore.hasPermission('edit-sections') || authStore.hasPermission('view-sections')) && section.name == 'banner_section'"
                            :to="{ name: 'UpdateSectionSliders', params: { id: section.id } }"
                            class="btn btn-sm btn-info"
                            title="Edit Sliders"
                          >
                            <i class="fas fa-images"></i>
                          </router-link>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Card Footer / Pagination -->
            <div class="card-footer clearfix" v-if="sections && sections?.data?.length > 0">
              <Pagination :pData="sections" @page-change="fetchPage" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Image Preview Modal -->
  <div v-if="previewUrl" class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.7);">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header py-2">
          <h5 class="modal-title">Image Preview</h5>
          <button type="button" class="close" @click="previewUrl = null">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body text-center p-3">
          <img :src="previewUrl" class="img-fluid rounded" style="max-height: 75vh;" alt="Preview" />
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
const sections = ref([]);
const previewUrl = ref(null);

// Fetch all sections from API
const fetchPage = async (page = 1, term = '') => {
  try {
    const res = await axios.get('/api/sections', {
      params: {
        page,
        search: term,
      },
    });
    sections.value = res.data.data;
  } catch (err) {
    toast.error('Failed to load sections');
  }
};

// Search handling
const onSearch = (term) => {
  fetchPage(1, term);
};

// Preview image in modal
const previewImage = (url) => {
  previewUrl.value = url;
};

onMounted(() => {
  fetchPage();
});
</script>

<style scoped>
.badge-purple {
  background-color: #6f42c1;
  color: #fff;
}
.badge-teal {
  background-color: #0d9488;
  color: #fff;
}
.font-weight-600 {
  font-weight: 600;
}
</style>