<template>
  <DashboardHeader title="Home Page Sections">
    <div class="header-toolbar d-flex align-items-center">
      <!-- Search -->
      <div class="header-search-wrap input-group input-group-sm">
        <input
          v-model="searchQuery"
          type="text"
          class="form-control"
          placeholder="Filter home sections..."
        />
        <div class="input-group-append">
          <span class="input-group-text">
            <i class="fas fa-search text-muted"></i>
          </span>
        </div>
      </div>

      <!-- View Switcher -->
      <div class="view-toggle-group btn-group btn-group-sm" role="group" aria-label="View toggle">
        <button
          type="button"
          class="btn view-toggle-btn"
          :class="viewMode === 'grid' ? 'btn-primary active' : 'btn-outline-secondary'"
          @click="viewMode = 'grid'"
          title="Grid Card View"
        >
          <i class="fas fa-th-large"></i>
          <span>Cards</span>
        </button>
        <button
          type="button"
          class="btn view-toggle-btn"
          :class="viewMode === 'table' ? 'btn-primary active' : 'btn-outline-secondary'"
          @click="viewMode = 'table'"
          title="Table List View"
        >
          <i class="fas fa-list"></i>
          <span>Table</span>
        </button>
      </div>

      <!-- Live Homepage Link -->
      <a
        href="/"
        target="_blank"
        class="btn btn-sm btn-outline-primary header-live-btn shadow-sm"
        title="Open Live Storefront"
      >
        <i class="fas fa-external-link-alt"></i>
        <span>Live Site</span>
      </a>
    </div>
  </DashboardHeader>

  <section class="content pb-5">
    <div class="container-fluid">
      <!-- Hero Overview Banner -->
      <div class="card home-overview-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
              <span class="badge badge-light px-3 py-1 font-weight-bold text-uppercase mb-2 text-primary">
                Storefront Index
              </span>
              <h4 class="font-weight-bold text-white mb-1">
                <i class="fas fa-home mr-2 text-warning"></i> Homepage Layout & Content Modules
              </h4>
              <p class="text-white-50 mb-0 small">
                Manage all dynamic sections displayed on the homepage.
              </p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
              <router-link :to="{ name: 'Sliders' }" class="btn btn-sm btn-light text-primary font-weight-bold px-3">
                <i class="fas fa-images mr-1"></i> Manage Hero Sliders
              </router-link>
              <router-link :to="{ name: 'Section' }" class="btn btn-sm btn-outline-light px-3">
                <i class="fas fa-th-list mr-1"></i> All Site Sections
              </router-link>
            </div>
          </div>

          <!-- Quick Stats Pills -->
          <div class="row mt-4 pt-2 border-top border-white-10">
            <div class="col-6 col-md-3 mb-2 mb-md-0">
              <div class="d-flex align-items-center text-white">
                <div class="stat-icon-wrap bg-white-15 rounded p-2 mr-3 text-center">
                  <i class="fas fa-layer-group text-warning fa-lg"></i>
                </div>
                <div>
                  <div class="h5 font-weight-bold mb-0 text-white">{{ filteredSections.length + 1 }}</div>
                  <div class="small text-white-50">Active Modules</div>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3 mb-2 mb-md-0">
              <div class="d-flex align-items-center text-white">
                <div class="stat-icon-wrap bg-white-15 rounded p-2 mr-3 text-center">
                  <i class="fas fa-shopping-bag text-info fa-lg"></i>
                </div>
                <div>
                  <div class="h5 font-weight-bold mb-0 text-white">3</div>
                  <div class="small text-white-50">Product Showcases</div>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="d-flex align-items-center text-white">
                <div class="stat-icon-wrap bg-white-15 rounded p-2 mr-3 text-center">
                  <i class="fas fa-sliders-h text-success fa-lg"></i>
                </div>
                <div>
                  <div class="h5 font-weight-bold mb-0 text-white">Interactive</div>
                  <div class="small text-white-50">GSAP & Video</div>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="d-flex align-items-center text-white">
                <div class="stat-icon-wrap bg-white-15 rounded p-2 mr-3 text-center">
                  <i class="fas fa-question-circle text-danger fa-lg"></i>
                </div>
                <div>
                  <div class="h5 font-weight-bold mb-0 text-white">Content & FAQ</div>
                  <div class="small text-white-50">Support & Benefits</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-primary" role="status"></div>
        <div class="text-muted mt-2">Loading home sections...</div>
      </div>

      <!-- Empty Filter State -->
      <div v-else-if="filteredSections.length === 0" class="card border-0 shadow-sm py-5 text-center">
        <div class="card-body">
          <i class="fas fa-search fa-3x text-muted mb-3"></i>
          <h5 class="font-weight-bold text-dark">No matching homepage sections found</h5>
          <p class="text-muted mb-3">Try clearing your search term "{{ searchQuery }}".</p>
          <button type="button" class="btn btn-sm btn-primary" @click="searchQuery = ''">
            Clear Search
          </button>
        </div>
      </div>

      <!-- 1. GRID / CARDS VIEW (Default) -->
      <div v-else-if="viewMode === 'grid'" class="row">
        <!-- Hero Slider Card -->
        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
          <div class="card h-100 border-0 shadow-sm section-module-card border-top-accent-primary">
            <div class="card-header bg-white border-bottom-0 pt-3 px-3 d-flex justify-content-between align-items-center">
              <span class="badge badge-primary px-2 py-1 font-weight-bold">
                <i class="fas fa-images mr-1"></i> Hero Slider
              </span>
              <span class="badge badge-light border text-muted px-2 py-1">Top Banner</span>
            </div>
            <div class="card-body px-3 pt-2 pb-3 d-flex flex-column justify-content-between">
              <div>
                <div class="d-flex align-items-center mb-2">
                  <div class="section-avatar bg-primary-light text-primary mr-2">
                    <i class="fas fa-images"></i>
                  </div>
                  <div>
                    <h5 class="font-weight-bold text-dark mb-0">Hero Banner Sliders</h5>
                    <code class="small text-muted">slider_section</code>
                  </div>
                </div>
                <p class="text-muted small mb-3">
                  The primary visual showcase at the top of the homepage with interactive sliding banners and CTA buttons.
                </p>
                <div class="module-stat-pill bg-light rounded px-3 py-2 mb-3 d-flex justify-content-between align-items-center">
                  <span class="small font-weight-600 text-dark">
                    <i class="fas fa-sliders-h text-primary mr-1"></i> Full Banner Slides
                  </span>
                  <span class="badge badge-success">Dynamic Hero</span>
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                <span class="small text-muted">Appearance &gt; Sliders</span>
                <router-link :to="{ name: 'Sliders' }" class="btn btn-sm btn-outline-primary px-3">
                  <i class="fas fa-edit mr-1"></i> Manage Sliders
                </router-link>
              </div>
            </div>
          </div>
        </div>

        <!-- Dynamic Homepage Sections -->
        <div
          v-for="sec in filteredSections"
          :key="sec.id"
          class="col-xl-4 col-lg-6 col-md-6 mb-4"
        >
          <div
            class="card h-100 border-0 shadow-sm section-module-card"
            :class="'border-top-accent-' + getMeta(sec.name).color"
          >
            <div class="card-header bg-white border-bottom-0 pt-3 px-3 d-flex justify-content-between align-items-center">
              <span :class="['badge', getSectionBadgeClass(sec.name), 'px-2 py-1 font-weight-bold']">
                <i :class="getMeta(sec.name).icon" class="mr-1"></i> {{ getSectionTypeBadge(sec) }}
              </span>
              <span class="badge badge-light border text-muted px-2 py-1">
                {{ getSectionCategory(sec.name) }}
              </span>
            </div>

            <div class="card-body px-3 pt-2 pb-3 d-flex flex-column justify-content-between">
              <div>
                <div class="d-flex align-items-center mb-2">
                  <div
                    :class="'bg-' + getMeta(sec.name).color + '-light text-' + getMeta(sec.name).color"
                    class="section-avatar mr-2"
                  >
                    <i :class="getMeta(sec.name).icon"></i>
                  </div>
                  <div>
                    <h5 class="font-weight-bold text-dark mb-0">
                      {{ sec.data?.title || getMeta(sec.name).title }}
                    </h5>
                    <code class="small text-muted">{{ sec.name }}</code>
                  </div>
                </div>

                <p class="text-muted small mb-3 card-description-clamp">
                  {{ sec.data?.subtitle || getMeta(sec.name).description }}
                </p>

                <!-- Dynamic Content Statistics Pill -->
                <div class="module-stat-pill bg-light rounded px-3 py-2 mb-3 d-flex justify-content-between align-items-center">
                  <span class="small font-weight-600 text-dark">
                    <i :class="[getMeta(sec.name).icon, 'text-' + getMeta(sec.name).color]" class="mr-1"></i>
                    {{ getItemSummary(sec) }}
                  </span>
                  <span v-if="sec.data?.badge" class="badge badge-secondary badge-pill">
                    Tag: "{{ sec.data.badge }}"
                  </span>
                  <span v-else class="badge badge-light border text-muted">
                    Configured
                  </span>
                </div>
              </div>

              <!-- Action Footer -->
              <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                <div>
                  <button
                    v-if="sec.data?.image"
                    type="button"
                    class="btn btn-xs btn-outline-secondary mr-1"
                    @click="previewImage(getImageUrl(sec.data.image))"
                    title="Preview Section Media"
                  >
                    <i class="fas fa-image mr-1"></i> Image
                  </button>
                </div>

                <router-link
                  :to="{ name: 'UpdateSection', params: { id: sec.id } }"
                  class="btn btn-sm btn-outline-primary px-3"
                >
                  <i class="fas fa-edit mr-1"></i> Edit Section
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 2. TABLE VIEW -->
      <div v-else class="card border-0 shadow-sm">
        <div class="table-responsive">
          <table class="table table-hover table-striped mb-0 align-middle">
            <thead class="thead-light">
              <tr>
                <th>Section Identifier</th>
                <th>Section Title</th>
                <th>Display Tag / Subtitle</th>
                <th class="text-center" style="width: 170px;">Module Content</th>
                <th class="text-center" style="width: 110px;">Media</th>
                <th class="text-center" style="width: 120px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Sliders Row -->
              <tr>
                <td>
                  <code class="bg-light text-primary px-2 py-1 rounded font-weight-bold">slider_section</code>
                </td>
                <td>
                  <span class="font-weight-bold text-dark">Hero Banner Sliders</span>
                </td>
                <td>
                  <span class="text-muted small">Top of homepage banner carousel with call-to-actions</span>
                </td>
                <td class="text-center">
                  <span class="badge badge-primary">Hero Slides</span>
                </td>
                <td class="text-center">
                  <span class="badge badge-light border">Sliders</span>
                </td>
                <td class="text-center">
                  <router-link :to="{ name: 'Sliders' }" class="btn btn-xs btn-primary">
                    <i class="fas fa-edit mr-1"></i> Manage
                  </router-link>
                </td>
              </tr>

              <!-- Dynamic Sections Rows -->
              <tr v-for="sec in filteredSections" :key="'table-sec-' + sec.id">
                <td>
                  <code class="bg-light text-primary px-2 py-1 rounded font-weight-bold">{{ sec.name }}</code>
                  <span class="d-block small text-muted mt-1">ID: {{ sec.id }}</span>
                </td>
                <td>
                  <span class="font-weight-bold text-dark">{{ sec.data?.title || getMeta(sec.name).title }}</span>
                  <div v-if="sec.data?.badge" class="mt-1">
                    <span class="badge badge-secondary badge-pill">{{ sec.data.badge }}</span>
                  </div>
                </td>
                <td>
                  <span class="text-muted small card-description-clamp">
                    {{ sec.data?.subtitle || getMeta(sec.name).description }}
                  </span>
                </td>
                <td class="text-center">
                  <span :class="'badge badge-' + getMeta(sec.name).color" class="px-2 py-1">
                    <i :class="getMeta(sec.name).icon" class="mr-1"></i> {{ getItemSummary(sec) }}
                  </span>
                </td>
                <td class="text-center">
                  <button
                    v-if="sec.data?.image"
                    type="button"
                    class="btn btn-xs btn-outline-primary"
                    @click="previewImage(getImageUrl(sec.data.image))"
                  >
                    <i class="fas fa-image mr-1"></i> Preview
                  </button>
                  <span v-else class="text-muted">—</span>
                </td>
                <td class="text-center">
                  <router-link
                    :to="{ name: 'UpdateSection', params: { id: sec.id } }"
                    class="btn btn-xs btn-info text-white"
                  >
                    <i class="fas fa-edit mr-1"></i> Edit
                  </router-link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- Image Preview Modal -->
  <div v-if="previewUrl" class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.75);">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header py-2 bg-light">
          <h5 class="modal-title font-weight-bold text-dark">Section Media Preview</h5>
          <button type="button" class="close" @click="previewUrl = null">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body text-center p-3">
          <img :src="previewUrl" class="img-fluid rounded shadow-sm" style="max-height: 520px; object-fit: contain;" alt="Preview" />
        </div>
        <div class="modal-footer py-2">
          <button type="button" class="btn btn-sm btn-secondary" @click="previewUrl = null">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';

const homeSections = ref([]);
const loading = ref(false);
const viewMode = ref('grid'); // 'grid' | 'table'
const searchQuery = ref('');
const previewUrl = ref(null);

/**
 * Metadata definitions for homepage sections
 */
const metaRegistry = {
  'home_benefits': {
    title: 'Pure Air, Healthy Living',
    badge: 'Benefits Showcase',
    color: 'info',
    icon: 'fas fa-layer-group',
    description: 'Parallax feature benefits highlighting allergen capture, quiet operation, and smart sensor displays.'
  },
  'home_best_selling': {
    title: 'Best Selling Product',
    badge: 'Best Sellers Showcase',
    color: 'warning',
    icon: 'fas fa-star',
    description: 'Top-selling AIRE air purifiers selected directly from product catalog.'
  },
  'home_lifestyle': {
    title: 'Designed for Real Life',
    badge: 'Lifestyle Showcase',
    color: 'purple',
    icon: 'fas fa-couch',
    description: 'Interactive room and lifestyle spaces showcasing purifiers in real homes.'
  },
  'home_new_arrival': {
    title: 'Freshly Launched Models',
    badge: 'New Arrivals Showcase',
    color: 'info',
    icon: 'fas fa-box-open',
    description: 'Latest purifiers and new technology releases featured on the homepage.'
  },
  'why_choose_aire': {
    title: 'Why Choose AIRE?',
    badge: 'GSAP Pinned Deck',
    color: 'dark',
    icon: 'fas fa-columns',
    description: 'Interactive stacked pinned cards highlighting engineering, precision and filtration.'
  },
  'home_customer_favorites': {
    title: 'Loved by Our Community',
    badge: 'Customer Favorites',
    color: 'primary',
    icon: 'fas fa-heart',
    description: 'Curated products with highest customer ratings and community preference.'
  },
  'home_video': {
    title: 'Engineering Architecture & Video',
    badge: 'Video Banner',
    color: 'danger',
    icon: 'fas fa-video',
    description: 'Technical video banner with playable MP4 / YouTube preview of purifier architecture.'
  },
  'home_living_hero': {
    title: 'The Future of Pure Living',
    badge: 'Living Hero Showcase',
    color: 'teal',
    icon: 'fas fa-wind',
    description: 'Animated living room hero showcase with GSAP scroll-down product flight and Buy button.'
  },
  'home_faq': {
    title: 'Frequently Asked Questions',
    badge: 'FAQ Accordion',
    color: 'success',
    icon: 'fas fa-question-circle',
    description: 'Customer help and support accordion with common product inquiries.'
  }
};

const getMeta = (name) => {
  return metaRegistry[name] || {
    title: name,
    badge: 'Custom Module',
    color: 'secondary',
    icon: 'fas fa-th-large',
    description: 'Homepage content module.'
  };
};

const getSectionCategory = (name) => {
  const map = {
    'slider_section': 'Hero Banner',
    'home_benefits': 'Benefits Showcase',
    'home_best_selling': 'Product Showcase',
    'home_lifestyle': 'Lifestyle Showcase',
    'home_new_arrival': 'Product Showcase',
    'why_choose_aire': 'GSAP Interactive',
    'home_customer_favorites': 'Product Showcase',
    'home_video': 'Video Architecture',
    'home_living_hero': 'Featured Product Hero',
    'home_faq': 'Support FAQ',
  };
  return map[name] || 'Storefront Module';
};

const getSectionTypeBadge = (sec) => {
  const meta = getMeta(sec.name);
  return sec.data?.badge || meta.badge;
};

const getSectionBadgeClass = (name) => {
  const color = getMeta(name).color;
  return 'badge-' + color;
};

const getItemSummary = (sec) => {
  const d = sec.data || {};
  if (['home_best_selling', 'best_selling', 'home_new_arrival', 'new_arrival', 'home_customer_favorites', 'customer_favorites'].includes(sec.name)) {
    const pCount = Array.isArray(d.product_ids) ? d.product_ids.length : 0;
    return `${pCount} Products Selected`;
  }
  if (['home_living_hero', 'living_hero'].includes(sec.name)) {
    return d.product_id ? 'Featured Product Set' : 'Latest Product Fallback';
  }
  if (['home_benefits', 'benefits'].includes(sec.name)) {
    return `${d.cards?.length || 6} Benefit Cards`;
  }
  if (['home_lifestyle', 'lifestyle'].includes(sec.name)) {
    return `${d.items?.length || 4} Lifestyle Spaces`;
  }
  if (['why_choose_aire'].includes(sec.name)) {
    return `${d.cards?.length || 4} Stacked Cards`;
  }
  if (['home_faq', 'faq'].includes(sec.name)) {
    return `${d.items?.length || 5} Questions`;
  }
  if (['home_video', 'video'].includes(sec.name)) {
    return d.video_file ? 'Local MP4 Video' : 'Video Player Banner';
  }
  return 'Active Section';
};

const fetchHomeSections = async () => {
  try {
    loading.value = true;
    const res = await axios.get('/api/sections/home-sections');
    homeSections.value = res.data.data || [];
  } catch (error) {
    console.error('Error fetching home sections:', error);
  } finally {
    loading.value = false;
  }
};

const getImageUrl = (imagePath) => {
  if (!imagePath) return '';
  if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
    return imagePath;
  }
  return '/' + imagePath.replace(/^\/+/, '');
};

const filteredSections = computed(() => {
  if (!searchQuery.value.trim()) {
    return homeSections.value;
  }
  const q = searchQuery.value.toLowerCase().trim();
  return homeSections.value.filter(sec => {
    const title = (sec.data?.title || getMeta(sec.name).title || '').toLowerCase();
    const name = (sec.name || '').toLowerCase();
    const desc = (sec.data?.subtitle || getMeta(sec.name).description || '').toLowerCase();
    return title.includes(q) || name.includes(q) || desc.includes(q);
  });
});

const previewImage = (url) => {
  previewUrl.value = url;
};

onMounted(() => {
  fetchHomeSections();
});
</script>

<style scoped>
.home-overview-card {
  background: linear-gradient(135deg, #1e1b4b 0%, #0f172a 100%);
  border-radius: 16px;
  overflow: hidden;
}

.bg-white-15 {
  background-color: rgba(255, 255, 255, 0.15);
}

.border-white-10 {
  border-color: rgba(255, 255, 255, 0.1) !important;
}

.section-module-card {
  border-radius: 14px;
  transition: transform 0.22s ease, box-shadow 0.22s ease;
  border-top: 4px solid #cbd5e1;
}

.section-module-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 24px rgba(15, 23, 42, 0.09) !important;
}

.border-top-accent-primary {
  border-top-color: #0066cc !important;
}
.border-top-accent-info {
  border-top-color: #17a2b8 !important;
}
.border-top-accent-warning {
  border-top-color: #ffc107 !important;
}
.border-top-accent-success {
  border-top-color: #28a745 !important;
}
.border-top-accent-purple {
  border-top-color: #6f42c1 !important;
}
.border-top-accent-danger {
  border-top-color: #dc3545 !important;
}
.border-top-accent-dark {
  border-top-color: #343a40 !important;
}
.border-top-accent-secondary {
  border-top-color: #6c757d !important;
}

.section-avatar {
  width: 42px;
  height: 42px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.1rem;
}

.bg-primary-light {
  background-color: rgba(0, 102, 204, 0.12);
}
.bg-info-light {
  background-color: rgba(23, 162, 184, 0.12);
}
.bg-warning-light {
  background-color: rgba(255, 193, 7, 0.16);
}
.bg-success-light {
  background-color: rgba(40, 167, 69, 0.12);
}
.bg-purple-light {
  background-color: rgba(111, 66, 193, 0.12);
}
.bg-danger-light {
  background-color: rgba(220, 53, 69, 0.12);
}
.bg-dark-light {
  background-color: rgba(52, 58, 64, 0.12);
}

.card-description-clamp {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  min-height: 38px;
}

.badge-purple {
  background-color: #6f42c1;
  color: #fff;
}

/* Header Toolbar Controls */
.header-toolbar {
  display: flex;
  align-items: center;
  gap: 10px;
}

.header-search-wrap {
  width: 240px;
  margin-right: 2px;
}

.header-search-wrap .form-control {
  height: 34px !important;
  font-size: 0.84rem;
  border-radius: 6px 0 0 6px !important;
  border: 1px solid #d1d5db;
  border-right: none;
  background-color: #fff;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

.header-search-wrap .form-control:focus {
  border-color: #0066cc;
  box-shadow: 0 0 0 2px rgba(0, 102, 204, 0.15);
}

.header-search-wrap .input-group-append .input-group-text {
  height: 34px !important;
  background-color: #fff;
  border-radius: 0 6px 6px 0 !important;
  border: 1px solid #d1d5db;
  border-left: none;
  padding: 0 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.view-toggle-group {
  display: inline-flex;
  align-items: center;
  border-radius: 6px;
  overflow: hidden;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
}

.view-toggle-btn {
  display: inline-flex !important;
  flex-direction: row !important;
  align-items: center !important;
  justify-content: center !important;
  white-space: nowrap !important;
  height: 34px !important;
  padding: 0 12px !important;
  font-size: 0.82rem !important;
  font-weight: 600 !important;
  line-height: 1 !important;
  gap: 6px !important;
  border: 1px solid #d1d5db !important;
}

.view-toggle-btn i {
  font-size: 0.8rem !important;
  margin: 0 !important;
}

.view-toggle-btn span {
  display: inline-block;
  line-height: 1;
}

.view-toggle-btn:first-child {
  border-radius: 6px 0 0 6px !important;
  border-right: none !important;
}

.view-toggle-btn:last-child {
  border-radius: 0 6px 6px 0 !important;
}

.view-toggle-btn.btn-primary {
  background-color: #0066cc !important;
  border-color: #0066cc !important;
  color: #ffffff !important;
}

.view-toggle-btn.btn-outline-secondary {
  background-color: #ffffff !important;
  color: #4b5563 !important;
  border-color: #d1d5db !important;
}

.view-toggle-btn.btn-outline-secondary:hover {
  background-color: #f8fafc !important;
  color: #1e293b !important;
}

.header-live-btn {
  display: inline-flex !important;
  flex-direction: row !important;
  align-items: center !important;
  justify-content: center !important;
  white-space: nowrap !important;
  height: 34px !important;
  padding: 0 12px !important;
  font-size: 0.82rem !important;
  font-weight: 600 !important;
  line-height: 1 !important;
  border-radius: 6px !important;
  gap: 6px !important;
}

.header-live-btn i {
  font-size: 0.78rem !important;
  margin: 0 !important;
}

@media (max-width: 768px) {
  .header-toolbar {
    flex-wrap: wrap;
    gap: 8px;
  }
  .header-search-wrap {
    width: 100%;
    margin-right: 0;
  }
}
</style>
