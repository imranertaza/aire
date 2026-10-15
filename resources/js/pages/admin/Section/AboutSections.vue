<template>
  <DashboardHeader title="About Us Page Sections">
    <div class="header-toolbar d-flex align-items-center">
      <!-- Search -->
      <div class="header-search-wrap input-group input-group-sm">
        <input
          v-model="searchQuery"
          type="text"
          class="form-control"
          placeholder="Filter about sections..."
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

      <!-- Live About Page Link -->
      <a
        href="/about-us"
        target="_blank"
        class="btn btn-sm btn-outline-primary header-live-btn shadow-sm"
        title="Open Live About Us Page"
      >
        <i class="fas fa-external-link-alt"></i>
        <span>Live Page</span>
      </a>
    </div>
  </DashboardHeader>

  <section class="content pb-5">
    <div class="container-fluid">
      <!-- Hero Overview Banner -->
      <div class="card about-overview-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
              <span class="badge badge-light px-3 py-1 font-weight-bold text-uppercase mb-2 text-primary">
                Storefront &gt; About Us
              </span>
              <h4 class="font-weight-bold text-white mb-1">
                <i class="fas fa-info-circle mr-2 text-info"></i> About Page Sections & Content Modules
              </h4>
              <p class="text-white-50 mb-0 small">
                Manage all dynamic sections displayed on the About Us page — from company milestones to leadership team and global certifications.
              </p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
              <router-link :to="{ name: 'Sliders' }" class="btn btn-sm btn-light text-primary font-weight-bold px-3">
                <i class="fas fa-images mr-1"></i> About Sidebar Ads
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
                  <div class="h5 font-weight-bold mb-0 text-white">{{ aboutSections.length }}</div>
                  <div class="small text-white-50">Active Modules</div>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3 mb-2 mb-md-0">
              <div class="d-flex align-items-center text-white">
                <div class="stat-icon-wrap bg-white-15 rounded p-2 mr-3 text-center">
                  <i class="fas fa-history text-info fa-lg"></i>
                </div>
                <div>
                  <div class="h5 font-weight-bold mb-0 text-white">Timeline & Stats</div>
                  <div class="small text-white-50">Milestones & Impact</div>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="d-flex align-items-center text-white">
                <div class="stat-icon-wrap bg-white-15 rounded p-2 mr-3 text-center">
                  <i class="fas fa-users text-success fa-lg"></i>
                </div>
                <div>
                  <div class="h5 font-weight-bold mb-0 text-white">Leadership</div>
                  <div class="small text-white-50">Executive Team</div>
                </div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="d-flex align-items-center text-white">
                <div class="stat-icon-wrap bg-white-15 rounded p-2 mr-3 text-center">
                  <i class="fas fa-globe text-primary fa-lg"></i>
                </div>
                <div>
                  <div class="h5 font-weight-bold mb-0 text-white">Global Reach</div>
                  <div class="small text-white-50">Patents & Certifications</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-primary" role="status"></div>
        <div class="text-muted mt-2">Loading about sections...</div>
      </div>

      <!-- Empty Filter State -->
      <div v-else-if="filteredSections.length === 0" class="card border-0 shadow-sm py-5 text-center">
        <div class="card-body">
          <i class="fas fa-search fa-3x text-muted mb-3"></i>
          <h5 class="font-weight-bold text-dark">No matching about page sections found</h5>
          <p class="text-muted mb-3">Try clearing your search term "{{ searchQuery }}".</p>
          <button type="button" class="btn btn-sm btn-primary" @click="searchQuery = ''">
            Clear Search
          </button>
        </div>
      </div>

      <!-- 1. GRID / CARDS VIEW (Default) -->
      <div v-else-if="viewMode === 'grid'" class="row">
        <!-- Sidebar Ads Card -->
        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
          <div class="card h-100 border-0 shadow-sm section-module-card border-top-accent-purple">
            <div class="card-header bg-white border-bottom-0 pt-3 px-3 d-flex justify-content-between align-items-center">
              <span class="badge badge-purple px-2 py-1 font-weight-bold">
                <i class="fas fa-ad mr-1"></i> Sidebar Showcase
              </span>
              <span class="badge badge-light border text-muted px-2 py-1">Right Sidebar</span>
            </div>
            <div class="card-body px-3 pt-2 pb-3 d-flex flex-column justify-content-between">
              <div>
                <div class="d-flex align-items-center mb-2">
                  <div class="section-avatar bg-purple-light text-purple mr-2">
                    <i class="fas fa-rectangle-ad"></i>
                  </div>
                  <div>
                    <h5 class="font-weight-bold text-dark mb-0">About Sidebar Ads</h5>
                    <code class="small text-muted">about_us slider</code>
                  </div>
                </div>
                <p class="text-muted small mb-3">
                  Right-hand sticky promotional slider carousel displaying featured product banners and special solution ads on the About page.
                </p>
                <div class="module-stat-pill bg-light rounded px-3 py-2 mb-3 d-flex justify-content-between align-items-center">
                  <span class="small font-weight-600 text-dark">
                    <i class="fas fa-images text-purple mr-1"></i> Sticky Ads Carousel
                  </span>
                  <span class="badge badge-success">Promotional</span>
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                <span class="small text-muted">Sliders &gt; Placement "about_us"</span>
                <router-link :to="{ name: 'Sliders' }" class="btn btn-sm btn-outline-primary px-3">
                  <i class="fas fa-edit mr-1"></i> Manage Ads
                </router-link>
              </div>
            </div>
          </div>
        </div>

        <!-- Dynamic About Page Sections -->
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
                      {{ sec.data?.title || sec.data?.hero_title || getMeta(sec.name).title }}
                    </h5>
                    <code class="small text-muted">{{ sec.name }}</code>
                  </div>
                </div>

                <p class="text-muted small mb-3 card-description-clamp">
                  {{ sec.data?.subtitle || sec.data?.hero_desc || getMeta(sec.name).description }}
                </p>

                <!-- Dynamic Content Statistics Pill -->
                <div class="module-stat-pill bg-light rounded px-3 py-2 mb-3 d-flex justify-content-between align-items-center">
                  <span class="small font-weight-600 text-dark">
                    <i :class="[getMeta(sec.name).icon, 'text-' + getMeta(sec.name).color]" class="mr-1"></i>
                    {{ getItemSummary(sec) }}
                  </span>
                  <span v-if="sec.data?.badge || sec.data?.banner_badge" class="badge badge-secondary badge-pill">
                    Tag: "{{ sec.data?.badge || sec.data?.banner_badge }}"
                  </span>
                  <span v-else-if="sec.data?.number" class="badge badge-primary badge-pill">
                    Section #{{ sec.data.number }}
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
                    v-if="sec.data?.image || sec.data?.hero_image || sec.data?.purpose_image || sec.data?.banner_image"
                    type="button"
                    class="btn btn-xs btn-outline-secondary mr-1"
                    @click="previewImage(getImageUrl(sec.data?.image || sec.data?.hero_image || sec.data?.purpose_image || sec.data?.banner_image))"
                    title="Preview Section Media"
                  >
                    <i class="fas fa-image mr-1"></i> Media
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
                <th style="width: 220px;">Section Identifier</th>
                <th>Section Title</th>
                <th>Display Tag / Subtitle</th>
                <th class="text-center" style="width: 180px;">Module Content</th>
                <th class="text-center" style="width: 110px;">Media</th>
                <th class="text-center" style="width: 120px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Dynamic Sections Rows -->
              <tr v-for="sec in filteredSections" :key="'table-sec-' + sec.id">
                <td>
                  <code class="bg-light text-primary px-2 py-1 rounded font-weight-bold">{{ sec.name }}</code>
                  <span class="d-block small text-muted mt-1">ID: {{ sec.id }} &bull; Sec #{{ sec.data?.number || '—' }}</span>
                </td>
                <td>
                  <span class="font-weight-bold text-dark">{{ sec.data?.title || sec.data?.hero_title || getMeta(sec.name).title }}</span>
                  <div v-if="sec.data?.badge || sec.data?.banner_badge" class="mt-1">
                    <span class="badge badge-secondary badge-pill">{{ sec.data.badge || sec.data.banner_badge }}</span>
                  </div>
                </td>
                <td>
                  <span class="text-muted small card-description-clamp">
                    {{ sec.data?.subtitle || sec.data?.hero_desc || getMeta(sec.name).description }}
                  </span>
                </td>
                <td class="text-center">
                  <span :class="'badge badge-' + getMeta(sec.name).color" class="px-2 py-1">
                    <i :class="getMeta(sec.name).icon" class="mr-1"></i> {{ getItemSummary(sec) }}
                  </span>
                </td>
                <td class="text-center">
                  <button
                    v-if="sec.data?.image || sec.data?.hero_image || sec.data?.purpose_image || sec.data?.banner_image"
                    type="button"
                    class="btn btn-xs btn-outline-primary"
                    @click="previewImage(getImageUrl(sec.data?.image || sec.data?.hero_image || sec.data?.purpose_image || sec.data?.banner_image))"
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
  <div
    v-if="modalImage"
    class="modal fade show d-block"
    tabindex="-1"
    style="background: rgba(0, 0, 0, 0.65); z-index: 1050;"
    @click.self="modalImage = null"
  >
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 shadow">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title font-weight-bold">Section Media Preview</h5>
          <button type="button" class="close" @click="modalImage = null">&times;</button>
        </div>
        <div class="modal-body text-center p-4">
          <img :src="modalImage" class="img-fluid rounded shadow-sm max-h-500" alt="Preview" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';

const aboutSections = ref([]);
const loading = ref(true);
const searchQuery = ref('');
const viewMode = ref('grid');
const modalImage = ref(null);

const metaRegistry = {
  'about_hero': {
    title: 'Top Page Header',
    badge: 'Page Header & Hero',
    color: 'primary',
    icon: 'fas fa-heading',
    description: 'Header title, subtitle, and lead text introducing the AIRE brand story.'
  },
  'about_story': {
    title: 'Our Story & Milestones',
    badge: 'Timeline & Impact',
    color: 'info',
    icon: 'fas fa-clock',
    description: 'Brand journey hero banner, historical timeline milestones, and worldwide impact statistics.'
  },
  'about_mission_vision': {
    title: 'Mission & Vision',
    badge: 'Purpose & Values',
    color: 'success',
    icon: 'fas fa-bullseye',
    description: 'Core purpose banner, Mission & Vision dual pillars, and 4 fundamental core value cards.'
  },
  'about_leadership': {
    title: 'Leadership Team',
    badge: 'Executive Team',
    color: 'teal',
    icon: 'fas fa-users',
    description: 'Leadership showcase banner, team mission quote, and executive member cards with bios and avatars.'
  },
  'about_innovation': {
    title: 'Innovation & Patents',
    badge: 'Patents & AI',
    color: 'indigo',
    icon: 'fas fa-shield-alt',
    description: 'Proprietary ionization technologies, worldwide patents, and smart sensor calibration showcase.'
  },
  'about_quality': {
    title: 'Quality & Certifications',
    badge: 'ISO & CADR',
    color: 'warning',
    icon: 'fas fa-award',
    description: 'International manufacturing compliance standards, ISO 9001/14001, and AHAM CADR lab verifications.'
  },
  'about_careers': {
    title: 'Careers & Culture',
    badge: 'Careers CTA',
    color: 'purple',
    icon: 'fas fa-briefcase',
    description: 'Talent recruitment call-to-action inviting engineers and researchers to join AIRE.'
  },
  'about_news': {
    title: 'News & Media Center',
    badge: 'Press & Media',
    color: 'danger',
    icon: 'fas fa-newspaper',
    description: 'Official press room highlight banner and media inquiry contact link.'
  },
  'about_global': {
    title: 'Global Presence',
    badge: 'Global Footprint',
    color: 'primary',
    icon: 'fas fa-globe',
    description: 'Worldwide distribution hubs, regional headquarters, and 100+ country coverage network.'
  }
};

const getMeta = (name) => {
  return metaRegistry[name] || {
    title: name,
    badge: 'About Module',
    color: 'secondary',
    icon: 'fas fa-th-large',
    description: 'Dynamic about page module.'
  };
};

const getSectionCategory = (name) => {
  const map = {
    'about_hero': 'Page Intro',
    'about_story': 'Brand Journey',
    'about_mission_vision': 'Mission & Vision',
    'about_leadership': 'Executive Team',
    'about_innovation': 'Engineering & IP',
    'about_quality': 'Certifications',
    'about_careers': 'Careers & Talent',
    'about_news': 'Media Center',
    'about_global': 'Global Reach',
  };
  return map[name] || 'About Section';
};

const getSectionTypeBadge = (sec) => {
  const meta = getMeta(sec.name);
  return meta.badge;
};

const getSectionBadgeClass = (name) => {
  const color = getMeta(name).color;
  return 'badge-' + color;
};

const getItemSummary = (sec) => {
  const d = sec.data || {};
  if (sec.name === 'about_story') {
    const mCount = d.milestones?.length || 6;
    const sCount = d.stats?.length || 4;
    return `${mCount} Milestones, ${sCount} Stats`;
  }
  if (sec.name === 'about_mission_vision') {
    const vCount = d.values?.length || 4;
    return `2 Pillars, ${vCount} Core Values`;
  }
  if (sec.name === 'about_leadership') {
    const memCount = d.members?.length || 4;
    return `${memCount} Executive Members`;
  }
  if (sec.name === 'about_innovation' || sec.name === 'about_quality' || sec.name === 'about_global') {
    return `${d.items?.length || 2} Key Cards`;
  }
  if (sec.name === 'about_careers' || sec.name === 'about_news') {
    return 'CTA Action Banner';
  }
  if (sec.name === 'about_hero') {
    return 'Main Headline & Lead';
  }
  return 'Active Section';
};

const fetchAboutSections = async () => {
  try {
    loading.value = true;
    const res = await axios.get('/api/sections/about-sections');
    aboutSections.value = res.data.data || [];
  } catch (error) {
    console.error('Error fetching about sections:', error);
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
    return aboutSections.value;
  }
  const q = searchQuery.value.toLowerCase();
  return aboutSections.value.filter(sec => {
    const meta = getMeta(sec.name);
    return (
      sec.name.toLowerCase().includes(q) ||
      (sec.data?.title && sec.data.title.toLowerCase().includes(q)) ||
      (sec.data?.hero_title && sec.data.hero_title.toLowerCase().includes(q)) ||
      meta.title.toLowerCase().includes(q) ||
      meta.badge.toLowerCase().includes(q) ||
      meta.description.toLowerCase().includes(q)
    );
  });
});

const previewImage = (url) => {
  modalImage.value = url;
};

onMounted(() => {
  fetchAboutSections();
});
</script>

<style scoped>
.about-overview-card {
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0369a1 100%);
  border-radius: 12px;
  color: #fff;
}
.border-white-10 {
  border-color: rgba(255, 255, 255, 0.12) !important;
}
.bg-white-15 {
  background: rgba(255, 255, 255, 0.15);
}
.section-module-card {
  border-radius: 10px;
  transition: all 0.2s ease-in-out;
  border-top: 4px solid transparent;
}
.section-module-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08) !important;
}
.border-top-accent-primary { border-top-color: #0d6efd !important; }
.border-top-accent-info { border-top-color: #0dcaf0 !important; }
.border-top-accent-success { border-top-color: #198754 !important; }
.border-top-accent-warning { border-top-color: #ffc107 !important; }
.border-top-accent-danger { border-top-color: #dc3545 !important; }
.border-top-accent-teal { border-top-color: #20c997 !important; }
.border-top-accent-purple { border-top-color: #6f42c1 !important; }
.border-top-accent-indigo { border-top-color: #6610f2 !important; }

.section-avatar {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.15rem;
}
.bg-primary-light { background: #e7f1ff; }
.bg-info-light { background: #cff4fc; }
.bg-success-light { background: #d1e7dd; }
.bg-warning-light { background: #fff3cd; }
.bg-danger-light { background: #f8d7da; }
.bg-teal-light { background: #d2f4ea; }
.bg-purple-light { background: #e2d9f3; }
.bg-indigo-light { background: #e0d5fa; }

.badge-purple { background-color: #6f42c1; color: #fff; }
.badge-teal { background-color: #20c997; color: #fff; }
.badge-indigo { background-color: #6610f2; color: #fff; }
.text-purple { color: #6f42c1 !important; }
.text-teal { color: #20c997 !important; }
.text-indigo { color: #6610f2 !important; }

.card-description-clamp {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  min-height: 38px;
}
.header-toolbar {
  gap: 8px;
}
.header-search-wrap {
  width: 220px;
}
.view-toggle-btn {
  display: inline-flex;
  align-items: center;
  gap: 5px;
}
.header-live-btn {
  display: inline-flex;
  align-items: center;
  gap: 5px;
}
.max-h-500 {
  max-height: 500px;
  object-fit: contain;
}
</style>
