<template>
  <DashboardHeader title="Page Layouts &amp; Dynamic Section Pipeline">
    <div class="header-toolbar d-flex align-items-center">
      <!-- Create Block Button -->
      <router-link
        :to="{ name: 'CreateSectionBuilder' }"
        class="btn btn-sm btn-primary shadow-sm mr-2 d-inline-flex align-items-center"
        title="Create New Visual Block Section"
      >
        <i class="fas fa-plus mr-1"></i>
        <span>Create Block Section</span>
      </router-link>

      <!-- Manage All Sections Button -->
      <router-link
        :to="{ name: 'Section' }"
        class="btn btn-sm btn-outline-secondary shadow-sm d-inline-flex align-items-center"
        title="View All Standard &amp; Builder Sections"
      >
        <i class="fas fa-cubes mr-1"></i>
        <span>All Saved Blocks</span>
      </router-link>
    </div>
  </DashboardHeader>

  <section class="content pb-5">
    <div class="container-fluid">
      <!-- Filters, Search & View Switcher Toolbar -->
      <div class="card filter-toolbar-card border-0 shadow-sm mb-4">
        <div class="card-body py-3 px-4">
          <div class="row align-items-center">
            <!-- Category Filter Pills (with generous margins) -->
            <div class="col-xl-7 col-lg-6 mb-3 mb-lg-0">
              <div class="d-flex flex-wrap align-items-center">
                <button
                  type="button"
                  class="btn btn-sm category-filter-btn mr-2 mb-2"
                  :class="selectedCategory === 'all' ? 'btn-primary' : 'btn-light border'"
                  @click="selectedCategory = 'all'"
                >
                  All Pages <span class="badge badge-light ml-1 text-dark">{{ pages.length }}</span>
                </button>
                <button
                  type="button"
                  class="btn btn-sm category-filter-btn mr-2 mb-2"
                  :class="selectedCategory === 'core' ? 'btn-primary' : 'btn-light border'"
                  @click="selectedCategory = 'core'"
                >
                  Core &amp; Company <span class="badge badge-light ml-1 text-dark">{{ countByCategory('core') }}</span>
                </button>
                <button
                  type="button"
                  class="btn btn-sm category-filter-btn mr-2 mb-2"
                  :class="selectedCategory === 'shop' ? 'btn-primary' : 'btn-light border'"
                  @click="selectedCategory = 'shop'"
                >
                  Shop &amp; Products <span class="badge badge-light ml-1 text-dark">{{ countByCategory('shop') }}</span>
                </button>
                <button
                  type="button"
                  class="btn btn-sm category-filter-btn mr-2 mb-2"
                  :class="selectedCategory === 'content' ? 'btn-primary' : 'btn-light border'"
                  @click="selectedCategory = 'content'"
                >
                  Editorial &amp; Media <span class="badge badge-light ml-1 text-dark">{{ countByCategory('content') }}</span>
                </button>
                <button
                  type="button"
                  class="btn btn-sm category-filter-btn mb-2"
                  :class="selectedCategory === 'checkout' ? 'btn-primary' : 'btn-light border'"
                  @click="selectedCategory = 'checkout'"
                >
                  Cart &amp; Conversion <span class="badge badge-light ml-1 text-dark">{{ countByCategory('checkout') }}</span>
                </button>
              </div>
            </div>

            <!-- Search Input & View Switcher (with generous gaps) -->
            <div class="col-xl-5 col-lg-6">
              <div class="d-flex align-items-center">
                <!-- Search Input -->
                <div class="input-group search-input-group flex-grow-1 mr-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0 text-muted px-3">
                      <i class="fas fa-search"></i>
                    </span>
                  </div>
                  <input
                    v-model="searchQuery"
                    type="text"
                    class="form-control border-left-0 shadow-none font-14 py-2"
                    placeholder="Search pages by title or path..."
                  />
                  <div class="input-group-append" v-if="searchQuery">
                    <button
                      class="btn btn-outline-secondary border-left-0 bg-white border"
                      type="button"
                      @click="searchQuery = ''"
                    >
                      <i class="fas fa-times text-muted"></i>
                    </button>
                  </div>
                </div>

                <!-- View Switcher (List vs Grid) with clear separation -->
                <div class="view-switcher-wrap flex-shrink-0 d-flex align-items-center">
                  <button
                    type="button"
                    class="btn btn-sm view-switch-btn mr-1 d-inline-flex align-items-center px-3 py-2"
                    :class="viewMode === 'list' ? 'btn-primary font-weight-bold shadow-sm' : 'btn-light border text-muted'"
                    @click="setViewMode('list')"
                    title="List View (Default)"
                  >
                    <i class="fas fa-list mr-2"></i>
                    <span>List</span>
                  </button>
                  <button
                    type="button"
                    class="btn btn-sm view-switch-btn d-inline-flex align-items-center px-3 py-2"
                    :class="viewMode === 'grid' ? 'btn-primary font-weight-bold shadow-sm' : 'btn-light border text-muted'"
                    @click="setViewMode('grid')"
                    title="Grid View (Compact Cards)"
                  >
                    <i class="fas fa-th-large mr-2"></i>
                    <span>Grid</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ============================================================== -->
      <!-- VIEW 1: BEAUTIFUL SPACED LIST VIEW (DEFAULT)                  -->
      <!-- ============================================================== -->
      <div v-if="viewMode === 'list' && filteredPages.length > 0" class="hub-list-container mb-4">
        <div
          v-for="page in filteredPages"
          :key="page.id"
          class="card hub-row-card border-0 shadow-sm rounded-4 p-3 p-md-4 mb-3 transition-all"
          :style="{ '--accent-color': page.iconColor }"
        >
          <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
            <!-- Left Block: Icon + Title + Category + Route -->
            <div class="d-flex align-items-center mr-lg-4 mb-3 mb-lg-0 hub-left-block">
              <div
                class="page-icon-wrapper-list flex-shrink-0 shadow-2xs mr-3"
                :style="{ backgroundColor: page.iconBg, color: page.iconColor }"
              >
                <i :class="page.icon"></i>
              </div>
              <div class="overflow-hidden">
                <div class="d-flex align-items-center flex-wrap mb-1">
                  <h5 class="font-weight-bold text-dark mb-0 font-15 mr-2 text-truncate" :title="page.title">
                    {{ page.title }}
                  </h5>
                  <span class="badge badge-light border text-secondary font-weight-bold px-2 py-1 font-11">
                    {{ page.categoryLabel }}
                  </span>
                </div>
                <div>
                  <span class="route-pill font-11 font-monospace px-2 py-1 rounded bg-light border text-muted d-inline-flex align-items-center">
                    <i class="fas fa-link mr-1 text-primary font-10"></i>
                    <span class="text-truncate">{{ page.routePath }}</span>
                  </span>
                </div>
              </div>
            </div>

            <!-- Middle Block: Description with spacious margins -->
            <div class="flex-grow-1 px-lg-4 mb-3 mb-lg-0 hub-desc-block">
              <p class="text-muted font-13 mb-0 line-clamp-2 lh-base">
                {{ page.description }}
              </p>
            </div>

            <!-- Right Block: Action Buttons -->
            <div class="d-flex align-items-center justify-content-between justify-content-lg-end flex-shrink-0 hub-actions-block">
              <!-- Action Buttons -->
              <div class="d-flex align-items-center">
                <a
                  :href="page.liveUrl"
                  target="_blank"
                  class="btn btn-light border text-muted px-3 py-2 mr-2 shadow-2xs live-preview-btn rounded-lg"
                  title="Preview Live Page on Storefront"
                >
                  <i class="fas fa-external-link-alt"></i>
                </a>
                <router-link
                  :to="{ name: page.routeName }"
                  class="btn btn-primary px-3 py-2 font-weight-bold shadow-sm d-inline-flex align-items-center configure-btn rounded-lg"
                >
                  <i class="fas fa-sliders-h mr-2 font-12"></i>
                  <span>Configure</span>
                  <i class="fas fa-arrow-right ml-2 font-11 opacity-75"></i>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ============================================================== -->
      <!-- VIEW 2: COMPACT GRID VIEW                                      -->
      <!-- ============================================================== -->
      <div v-else-if="viewMode === 'grid' && filteredPages.length > 0" class="row mb-4">
        <div
          v-for="page in filteredPages"
          :key="page.id"
          class="col-sm-6 col-lg-4 col-xl-3 d-flex mb-3"
        >
          <div
            class="card page-hub-card-compact w-100 border-0 shadow-sm d-flex flex-column rounded-4"
            :style="{ '--accent-color': page.iconColor }"
          >
            <div class="card-body p-3 d-flex flex-column">
              <!-- Top Row: Icon, Category Badge & External Link -->
              <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="page-icon-wrapper-compact" :style="{ backgroundColor: page.iconBg, color: page.iconColor }">
                  <i :class="page.icon"></i>
                </div>
                <div class="d-flex align-items-center">
                  <span class="badge badge-light text-muted font-weight-normal border px-2 py-1 font-11 mr-1">
                    {{ page.categoryLabel }}
                  </span>
                  <a
                    :href="page.liveUrl"
                    target="_blank"
                    class="btn btn-xs btn-light border text-muted"
                    title="Preview Live Page on Storefront"
                  >
                    <i class="fas fa-external-link-alt"></i>
                  </a>
                </div>
              </div>

              <!-- Page Title & URL -->
              <div class="mb-2">
                <h6 class="font-weight-bold text-dark mb-1 font-14 text-truncate" :title="page.title">
                  {{ page.title }}
                </h6>
                <div class="text-muted font-11 font-monospace text-truncate bg-light border px-2 py-0 rounded d-inline-block mw-100">
                  {{ page.routePath }}
                </div>
              </div>

              <!-- Description (2 lines clamp) -->
              <p class="text-muted font-12 flex-grow-1 mb-3 line-clamp-2 lh-base">
                {{ page.description }}
              </p>

              <!-- Action Button -->
              <router-link
                :to="{ name: page.routeName }"
                class="btn btn-primary btn-sm btn-block font-weight-bold shadow-2xs font-12 py-2 mt-auto d-inline-flex align-items-center justify-content-center"
              >
                <i class="fas fa-sliders-h mr-2 font-11"></i>
                <span>Configure Sections</span>
              </router-link>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty Filter State -->
      <div v-if="filteredPages.length === 0" class="card border-0 shadow-sm p-5 text-center my-4 rounded-4">
        <i class="fas fa-search fa-3x text-muted opacity-50 mb-3"></i>
        <h5 class="font-weight-bold text-dark">No matching pages found</h5>
        <p class="text-muted font-14">Try adjusting your search query or switching to "All Pages".</p>
        <div>
          <button type="button" class="btn btn-sm btn-outline-primary px-3 rounded-pill" @click="resetFilters">
            Reset Filters
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue';
import DashboardHeader from '@/components/DashboardHeader.vue';

// View mode: 'list' (default) or 'grid' (compact cards)
const viewMode = ref(localStorage.getItem('aire_page_layouts_view_mode') || 'list');

function setViewMode(mode) {
  viewMode.value = mode;
  try {
    localStorage.setItem('aire_page_layouts_view_mode', mode);
  } catch (e) {
    // ignore storage error
  }
}

const selectedCategory = ref('all');
const searchQuery = ref('');

// The 13 Supported Pages in AIRE Layout Pipeline
const pages = [
  {
    id: 'home',
    title: 'Homepage',
    routePath: '/',
    liveUrl: '/',
    routeName: 'HomeSections',
    category: 'core',
    categoryLabel: 'Core',
    icon: 'fas fa-home',
    iconBg: '#eff6ff',
    iconColor: '#2563eb',
    nativeCount: '11',
    slotsCount: '12 Slots',
    description: 'Hero slider, category grid, lifestyle showcases, product carousels, customer favorites, and video showcases.'
  },
  {
    id: 'about',
    title: 'About Us Page',
    routePath: '/about',
    liveUrl: '/about',
    routeName: 'AboutSections',
    category: 'core',
    categoryLabel: 'Core',
    icon: 'fas fa-info-circle',
    iconBg: '#f0fdf4',
    iconColor: '#16a34a',
    nativeCount: '8',
    slotsCount: '9 Slots',
    description: 'Corporate narrative, innovation highlights, leadership team profiles, and brand commitments.'
  },
  {
    id: 'contact',
    title: 'Contact Us Page',
    routePath: '/contact',
    liveUrl: '/contact',
    routeName: 'ContactSections',
    category: 'core',
    categoryLabel: 'Core',
    icon: 'fas fa-envelope',
    iconBg: '#ecfeff',
    iconColor: '#0891b2',
    nativeCount: '3',
    slotsCount: '4 Slots',
    description: 'Interactive contact form, technical support hub, enterprise inquiry toolbar, and company locations.'
  },
  {
    id: 'product',
    title: 'Product Details (PDP)',
    routePath: '/products/{slug}',
    liveUrl: '/products/filter',
    routeName: 'ProductSections',
    category: 'shop',
    categoryLabel: 'Shop',
    icon: 'fas fa-cube',
    iconBg: '#fef3c7',
    iconColor: '#d97706',
    nativeCount: '9',
    slotsCount: '10 Slots',
    description: 'Product gallery, technical specs table, in-the-box accessories, applications, and related models.'
  },
  {
    id: 'category',
    title: 'Category & Shop Catalog',
    routePath: '/categories, /products',
    liveUrl: '/categories',
    routeName: 'CategorySections',
    category: 'shop',
    categoryLabel: 'Shop',
    icon: 'fas fa-th-large',
    iconBg: '#fae8ff',
    iconColor: '#a855f7',
    nativeCount: '3',
    slotsCount: '4 Slots',
    description: 'Category collections showcase, catalog product filter grid, promotional hero strips, and brand carousels.'
  },
  {
    id: 'compare',
    title: 'Product Comparison',
    routePath: '/compare',
    liveUrl: '/compare',
    routeName: 'CompareSections',
    category: 'shop',
    categoryLabel: 'Shop',
    icon: 'fas fa-balance-scale',
    iconBg: '#eef2ff',
    iconColor: '#4f46e5',
    nativeCount: '4',
    slotsCount: '4 Slots',
    description: 'Side-by-side technical specs matrix, comparison sidebar anchors, expert consultation banner, and trust badges.'
  },
  {
    id: 'news',
    title: 'Newsroom / Blog Hub',
    routePath: '/news',
    liveUrl: '/news',
    routeName: 'NewsSections',
    category: 'content',
    categoryLabel: 'Editorial',
    icon: 'fas fa-newspaper',
    iconBg: '#fff7ed',
    iconColor: '#ea580c',
    nativeCount: '4',
    slotsCount: '5 Slots',
    description: 'Editorial spotlight, categorized article feed, newsletter subscription cards, and press media contact.'
  },
  {
    id: 'news_detail',
    title: 'Article Details (Single Post)',
    routePath: '/news/{slug}',
    liveUrl: '/news',
    routeName: 'NewsDetailSections',
    category: 'content',
    categoryLabel: 'Editorial',
    icon: 'fas fa-file-alt',
    iconBg: '#fefce8',
    iconColor: '#ca8a04',
    nativeCount: '4',
    slotsCount: '5 Slots',
    description: 'Editorial article body, social share bar, author credentials, tags, and related corporate stories.'
  },
  {
    id: 'resources',
    title: 'Resources / Documentation Hub',
    routePath: '/resources',
    liveUrl: '/resources',
    routeName: 'ResourceSections',
    category: 'content',
    categoryLabel: 'Editorial',
    icon: 'fas fa-book-open',
    iconBg: '#eff6ff',
    iconColor: '#2563eb',
    nativeCount: '3',
    slotsCount: '4 Slots',
    description: 'Engineering brochures, CAD drawings, video tutorials, installation manuals, and technical specifications library.'
  },
  {
    id: 'cart',
    title: 'Shopping Basket / Cart',
    routePath: '/cart',
    liveUrl: '/cart',
    routeName: 'CartSections',
    category: 'checkout',
    categoryLabel: 'Conversion',
    icon: 'fas fa-shopping-cart',
    iconBg: '#eff6ff',
    iconColor: '#2563eb',
    nativeCount: '4',
    slotsCount: '6 Slots',
    description: 'Basket item table, order summary checkout card, saved-for-later items, and free shipping notices.'
  },
  {
    id: 'order_confirm',
    title: 'Order Confirmation',
    routePath: '/order-confirm',
    liveUrl: '/order-confirm',
    routeName: 'OrderConfirmSections',
    category: 'checkout',
    categoryLabel: 'Conversion',
    icon: 'fas fa-check-circle',
    iconBg: '#f0fdf4',
    iconColor: '#16a34a',
    nativeCount: '5',
    slotsCount: '7 Slots',
    description: 'Post-purchase thank you banner, 4-step delivery progress timeline, filter auto-ship upsells, and support CTA.'
  },
  {
    id: 'favorite',
    title: 'My Favorites (Wishlist)',
    routePath: '/favorite',
    liveUrl: '/favorite',
    routeName: 'FavoriteSections',
    category: 'checkout',
    categoryLabel: 'Conversion',
    icon: 'fas fa-heart',
    iconBg: '#fff1f2',
    iconColor: '#e11d48',
    nativeCount: '2',
    slotsCount: '4 Slots',
    description: 'Customer saved wishlist product grid, recommended companions, and promotional discount prompts.'
  },
  {
    id: 'not_found',
    title: '404 Not Found Page',
    routePath: '404.blade.php',
    liveUrl: '/404-preview',
    routeName: 'NotFoundSections',
    category: 'core',
    categoryLabel: 'Core',
    icon: 'fas fa-exclamation-triangle',
    iconBg: '#fffbeb',
    iconColor: '#d97706',
    nativeCount: '2',
    slotsCount: '4 Slots',
    description: 'Error recovery screen, search input box, quick portal pills, and bestselling purifiers carousel.'
  }
];

function countByCategory(cat) {
  return pages.filter(p => p.category === cat).length;
}

const filteredPages = computed(() => {
  return pages.filter(page => {
    const matchesCat = selectedCategory.value === 'all' || page.category === selectedCategory.value;
    const query = searchQuery.value.trim().toLowerCase();
    const matchesQuery = !query ||
      page.title.toLowerCase().includes(query) ||
      page.routePath.toLowerCase().includes(query) ||
      page.description.toLowerCase().includes(query);
    return matchesCat && matchesQuery;
  });
});

function resetFilters() {
  selectedCategory.value = 'all';
  searchQuery.value = '';
}
</script>

<style scoped>
.filter-toolbar-card {
  border-radius: 14px;
}

.category-filter-btn {
  border-radius: 8px;
  font-weight: 500;
  transition: all 0.15s ease;
  padding: 0.35rem 0.75rem;
}

.search-input-group .form-control {
  border-radius: 0 8px 8px 0;
}

.search-input-group .input-group-text {
  border-radius: 8px 0 0 8px;
}

.view-switch-btn {
  border-radius: 8px !important;
}

/* ========================================================= */
/* Modern Spaced Floating Row Card (List View)               */
/* ========================================================= */
.hub-row-card {
  background: #ffffff;
  border-radius: 14px !important;
  border: 1px solid #eef2f6 !important;
  border-left: 4px solid var(--accent-color, #2563eb) !important;
  transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s ease, border-color 0.2s ease;
}

.hub-row-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 28px -10px rgba(15, 23, 42, 0.12) !important;
  border-color: #cbd5e1 !important;
}

.hub-left-block {
  min-width: 320px;
  max-width: 360px;
}

.page-icon-wrapper-list {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
}

.route-pill {
  border-radius: 6px;
}

.live-preview-btn {
  border-radius: 8px;
  transition: all 0.15s ease;
}

.live-preview-btn:hover {
  background-color: #e2e8f0;
  color: #0f172a !important;
}

.configure-btn {
  border-radius: 8px;
  transition: all 0.15s ease;
}

.configure-btn:hover {
  transform: translateY(-1px);
}

.rounded-lg {
  border-radius: 8px !important;
}

/* ========================================================= */
/* Compact Grid View Card Styling                            */
/* ========================================================= */
.page-hub-card-compact {
  border-radius: 14px;
  border: 1px solid #eef2f6 !important;
  border-top: 3px solid var(--accent-color, #2563eb) !important;
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  background: #ffffff;
}

.page-hub-card-compact:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 24px -10px rgba(15, 23, 42, 0.12) !important;
  border-color: #cbd5e1 !important;
}

.page-icon-wrapper-compact {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
}

/* ========================================================= */
/* Utilities & Controls                                      */
/* ========================================================= */
.shadow-2xs {
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.font-10 {
  font-size: 10px;
}

.font-11 {
  font-size: 11px;
}

.font-12 {
  font-size: 12px;
}

.font-13 {
  font-size: 13px;
  line-height: 1.5;
}

.font-14 {
  font-size: 14px;
}

.font-15 {
  font-size: 15px;
}

.font-16 {
  font-size: 16px;
}

.btn-xs {
  padding: 0.18rem 0.45rem;
  font-size: 0.72rem;
  line-height: 1.2;
  border-radius: 0.25rem;
}
</style>
