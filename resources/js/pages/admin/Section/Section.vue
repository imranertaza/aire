<template>
  <DashboardHeader title="Manage Sections">
    <div class="d-flex justify-content-end align-items-center">
      <router-link :to="{ name: 'CreateSectionBuilder' }" class="btn btn-sm btn-primary shadow-sm font-weight-bold mr-2">
        <i class="fas fa-magic mr-1"></i> Visual Section Builder
      </router-link>
      <SearchBox @search="onSearch" />
    </div>
  </DashboardHeader>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary card-outline shadow-sm">
            <!-- Filter & Navigation Toolbar Header -->
            <div class="card-header border-bottom bg-white py-3">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <!-- Left: Quick Filter Pills -->
                <div class="btn-group btn-group-sm p-1 bg-light rounded-pill border">
                  <button
                    type="button"
                    class="btn rounded-pill font-weight-bold px-3 transition-all"
                    :class="activeQuickFilter === 'all' ? 'btn-primary shadow-sm' : 'btn-light text-secondary border-0'"
                    @click="setQuickFilter('all')"
                  >
                    <i class="fas fa-th-list mr-1"></i> All
                  </button>
                  <button
                    type="button"
                    class="btn rounded-pill font-weight-bold px-3 transition-all"
                    :class="activeQuickFilter === 'block' ? 'btn-primary shadow-sm' : 'btn-light text-secondary border-0'"
                    @click="setQuickFilter('block')"
                  >
                    <i class="fas fa-cubes mr-1 text-info"></i> Block Sections
                  </button>
                  <button
                    type="button"
                    class="btn rounded-pill font-weight-bold px-3 transition-all"
                    :class="activeQuickFilter === 'home' ? 'btn-primary shadow-sm' : 'btn-light text-secondary border-0'"
                    @click="setQuickFilter('home')"
                  >
                    <i class="fas fa-home mr-1 text-success"></i> Homepage
                  </button>
                  <button
                    type="button"
                    class="btn rounded-pill font-weight-bold px-3 transition-all"
                    :class="activeQuickFilter === 'about' ? 'btn-primary shadow-sm' : 'btn-light text-secondary border-0'"
                    @click="setQuickFilter('about')"
                  >
                    <i class="fas fa-info-circle mr-1 text-primary"></i> About Page
                  </button>
                  <button
                    type="button"
                    class="btn rounded-pill font-weight-bold px-3 transition-all"
                    :class="activeQuickFilter === 'custom' ? 'btn-primary shadow-sm' : 'btn-light text-secondary border-0'"
                    @click="setQuickFilter('custom')"
                  >
                    <i class="fas fa-star mr-1 text-warning"></i> Custom
                  </button>
                </div>

                <!-- Right: Detailed Filter Dropdowns & Reset -->
                <div class="d-flex align-items-center flex-wrap gap-2">
                  <!-- Type Filter Dropdown -->
                  <div class="d-flex align-items-center">
                    <span class="small text-muted font-weight-bold mr-1 d-none d-lg-inline">Type:</span>
                    <select v-model="filterType" @change="onDropdownFilterChange" class="custom-select custom-select-sm" style="width: auto;">
                      <option value="">All Types</option>
                      <option value="block">Block Sections (Visual Builder)</option>
                      <option value="standard">Standard Form Sections</option>
                    </select>
                  </div>

                  <!-- Page Group Dropdown -->
                  <div class="d-flex align-items-center">
                    <span class="small text-muted font-weight-bold mr-1 d-none d-lg-inline">Group:</span>
                    <select v-model="filterGroup" @change="onDropdownFilterChange" class="custom-select custom-select-sm" style="width: auto;">
                      <option value="">All Groups</option>
                      <option value="home">Homepage Sections</option>
                      <option value="about">About Page Sections</option>
                      <option value="custom">Custom Sections</option>
                    </select>
                  </div>

                  <!-- Sort Order Dropdown -->
                  <select v-model="sortBy" @change="fetchPage(1)" class="custom-select custom-select-sm" style="width: auto;">
                    <option value="desc">Newest First</option>
                    <option value="asc">Oldest First</option>
                  </select>

                  <!-- Per Page Dropdown -->
                  <select v-model.number="perPage" @change="fetchPage(1)" class="custom-select custom-select-sm" style="width: auto;">
                    <option :value="15">15 / page</option>
                    <option :value="25">25 / page</option>
                    <option :value="50">50 / page</option>
                    <option :value="100">100 / page</option>
                  </select>

                  <!-- Reset Filters Button -->
                  <button
                    v-if="hasActiveFilters"
                    type="button"
                    class="btn btn-sm btn-outline-danger font-weight-bold"
                    @click="resetFilters"
                    title="Clear and reset all filters"
                  >
                    <i class="fas fa-undo-alt mr-1"></i> Reset
                  </button>
                </div>
              </div>
            </div>

            <div class="card-body p-0 position-relative">
              <!-- Loading overlay -->
              <div v-if="loading" class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center bg-white bg-opacity-75 z-index-10" style="z-index: 10;">
                <div class="spinner-border text-primary spinner-border-sm mr-2" role="status"></div>
                <span class="small text-muted font-weight-bold">Filtering sections...</span>
              </div>

              <!-- Empty State -->
              <div v-if="!sections || sections?.data?.length === 0" class="p-5 text-center text-muted">
                <i class="fas fa-filter fa-2x mb-3 text-secondary opacity-50"></i>
                <h6 class="font-weight-bold text-dark">No sections match your filter criteria</h6>
                <p class="small text-muted mb-3">Try choosing a different filter tab, clearing the search keyword, or resetting all filters.</p>
                <button v-if="hasActiveFilters" type="button" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm font-weight-bold" @click="resetFilters">
                  <i class="fas fa-sync-alt mr-1"></i> Reset All Filters
                </button>
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
                        <span v-if="isBlockSection(section)" class="badge badge-primary ml-2">
                          <i class="fas fa-cubes mr-1"></i> Block Section
                        </span>
                        <span v-else-if="section.name === 'why_choose_aire'" class="badge badge-info ml-2">Stacked Deck</span>
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
                        <span v-else-if="section.name === 'about_hero'" class="badge badge-primary ml-2">About Header</span>
                        <span v-else-if="section.name === 'about_story'" class="badge badge-info ml-2">About Story & Milestones</span>
                        <span v-else-if="section.name === 'about_mission_vision'" class="badge badge-success ml-2">About Mission & Vision</span>
                        <span v-else-if="section.name === 'about_leadership'" class="badge badge-teal ml-2">About Leadership</span>
                        <span v-else-if="section.name === 'about_innovation'" class="badge badge-indigo ml-2">About Innovation</span>
                        <span v-else-if="section.name === 'about_quality'" class="badge badge-warning ml-2">About Quality</span>
                        <span v-else-if="section.name === 'about_careers'" class="badge badge-purple ml-2">About Careers</span>
                        <span v-else-if="section.name === 'about_news'" class="badge badge-danger ml-2">About Media</span>
                        <span v-else-if="section.name === 'about_global'" class="badge badge-primary ml-2">About Global</span>
                      </td>
                      <td class="align-middle text-center">
                        <span v-if="isBlockSection(section)" class="badge badge-primary">
                          <i class="fas fa-cubes mr-1"></i> {{ section.data?.blocks?.length || 0 }} Blocks
                        </span>
                        <span v-else-if="section.name === 'why_choose_aire'" class="badge badge-purple">
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
                        <span v-else-if="section.name === 'about_story'" class="badge badge-info">
                          <i class="fas fa-clock mr-1"></i> {{ section.data?.milestones?.length || 6 }} Milestones
                        </span>
                        <span v-else-if="section.name === 'about_mission_vision'" class="badge badge-success">
                          <i class="fas fa-bullseye mr-1"></i> {{ section.data?.values?.length || 4 }} Values
                        </span>
                        <span v-else-if="section.name === 'about_leadership'" class="badge badge-teal">
                          <i class="fas fa-users mr-1"></i> {{ section.data?.members?.length || 4 }} Members
                        </span>
                        <span v-else-if="section.name === 'about_innovation' || section.name === 'about_quality' || section.name === 'about_global'" class="badge badge-primary">
                          <i class="fas fa-layer-group mr-1"></i> {{ section.data?.items?.length || 2 }} Items
                        </span>
                        <span v-else>
                          <i :class="(section.data?.image || section.data?.hero_image || section.data?.purpose_image || section.data?.banner_image) ? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-muted'"></i>
                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <button v-if="section.data?.image || section.data?.hero_image || section.data?.purpose_image || section.data?.banner_image" @click="previewImage(getImageUrl(section.data?.image || section.data?.hero_image || section.data?.purpose_image || section.data?.banner_image))" class="btn btn-xs btn-outline-primary">
                          <i class="fas fa-image mr-1"></i> Preview
                        </button>
                        <span v-else class="text-muted">—</span>
                      </td>
                      <td class="align-middle text-center">
                        <div class="d-flex justify-content-center align-items-center">
                          <!-- 1. Block Section: Show Edit + Copy Directive button -->
                          <router-link
                            v-if="isBlockSection(section) && (authStore.hasPermission('manage-frontend') || authStore.hasPermission('edit-sections') || authStore.hasPermission('view-sections'))"
                            :to="{ name: 'EditSectionBuilder', params: { id: section.id } }"
                            class="btn btn-sm btn-primary mr-2"
                            title="Edit Block Section (Visual Section Builder)"
                          >
                            <i class="fas fa-edit"></i>
                          </router-link>
                          <button
                            v-if="isBlockSection(section)"
                            type="button"
                            class="btn btn-sm btn-light border text-dark"
                            @click="copyBladeDirective(section.name)"
                            title="Copy Blade Directive: @renderSection('...')"
                          >
                            <i class="fas fa-copy"></i>
                          </button>

                          <!-- 2. Testimonials Slider -->
                          <router-link
                            v-else-if="section.name === 'client_testimonials' && (authStore.hasPermission('manage-frontend') || authStore.hasPermission('edit-sections') || authStore.hasPermission('view-sections'))"
                            :to="{ name: 'TestimonialsSection' }"
                            class="btn btn-sm btn-primary"
                            title="Manage Testimonials Slider"
                          >
                            <i class="fas fa-quote-left"></i>
                          </router-link>

                          <!-- 3. Banner Section Sliders -->
                          <router-link
                            v-else-if="section.name === 'banner_section' && (authStore.hasPermission('manage-frontend') || authStore.hasPermission('edit-sections') || authStore.hasPermission('view-sections'))"
                            :to="{ name: 'UpdateSectionSliders', params: { id: section.id } }"
                            class="btn btn-sm btn-info"
                            title="Edit Sliders"
                          >
                            <i class="fas fa-images"></i>
                          </router-link>

                          <!-- 4. Standard / Legacy Section -->
                          <router-link
                            v-else-if="authStore.hasPermission('manage-frontend') || authStore.hasPermission('edit-sections') || authStore.hasPermission('view-sections')"
                            :to="{ name: 'UpdateSection', params: { id: section.id } }"
                            class="btn btn-sm btn-info"
                            title="Edit Section"
                          >
                            <i class="fas fa-edit"></i>
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
import { ref, computed, onMounted } from 'vue';
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
const loading = ref(false);

// Filter states
const filterType = ref(''); // '', 'block', 'standard'
const filterGroup = ref(''); // '', 'home', 'about', 'custom'
const searchTerm = ref('');
const perPage = ref(15);
const sortBy = ref('desc'); // 'desc', 'asc'
const activeQuickFilter = ref('all'); // 'all', 'block', 'home', 'about', 'custom'

const hasActiveFilters = computed(() => {
  return !!(filterType.value || filterGroup.value || searchTerm.value || activeQuickFilter.value !== 'all');
});

// Fetch all sections from API with full filter parameters
const fetchPage = async (page = 1, term = null) => {
  if (term !== null) {
    searchTerm.value = term;
  }
  loading.value = true;
  try {
    const res = await axios.get('/api/sections', {
      params: {
        page,
        search: searchTerm.value,
        type: filterType.value,
        group: filterGroup.value,
        per_page: perPage.value,
        sort: sortBy.value,
      },
    });
    sections.value = res.data.data;
  } catch (err) {
    toast.error('Failed to load sections');
  } finally {
    loading.value = false;
  }
};

const setQuickFilter = (tab) => {
  activeQuickFilter.value = tab;
  if (tab === 'all') {
    filterType.value = '';
    filterGroup.value = '';
  } else if (tab === 'block') {
    filterType.value = 'block';
    filterGroup.value = '';
  } else if (tab === 'home') {
    filterType.value = '';
    filterGroup.value = 'home';
  } else if (tab === 'about') {
    filterType.value = '';
    filterGroup.value = 'about';
  } else if (tab === 'custom') {
    filterType.value = '';
    filterGroup.value = 'custom';
  }
  fetchPage(1);
};

const onDropdownFilterChange = () => {
  activeQuickFilter.value = '';
  fetchPage(1);
};

const resetFilters = () => {
  filterType.value = '';
  filterGroup.value = '';
  searchTerm.value = '';
  activeQuickFilter.value = 'all';
  sortBy.value = 'desc';
  perPage.value = 15;
  fetchPage(1);
};

// Search handling
const onSearch = (term) => {
  fetchPage(1, term);
};

// Preview image in modal
const previewImage = (url) => {
  previewUrl.value = url;
};

// Check if section is built with the visual block builder
const isBlockSection = (section) => {
  if (!section) return false;
  if (Array.isArray(section.data?.blocks)) return true;
  if (section.data?.is_builder === true) return true;
  if (typeof section.name === 'string' && (section.name.startsWith('custom_') || section.name.startsWith('builder_'))) return true;
  return false;
};

const copyBladeDirective = (name) => {
  const code = `@renderSection('${name}')`;
  if (navigator.clipboard) {
    navigator.clipboard.writeText(code).then(() => {
      if (window.toastr) {
        window.toastr.success(`Copied: ${code}`);
      }
    }).catch(() => {});
  }
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
.gap-1 {
  gap: 0.35rem !important;
}
.gap-2 {
  gap: 0.5rem !important;
}
.gap-3 {
  gap: 1rem !important;
}
.transition-all {
  transition: all 0.2s ease-in-out;
}
.btn-white {
  background-color: #fff !important;
  border-color: #dee2e6 !important;
}
</style>