<template>
  <DashboardHeader title="Favorite (Wishlist) Page Sections">
    <div class="header-toolbar d-flex align-items-center">
      <!-- Create Block Button -->
      <router-link
        :to="{ name: 'CreateSectionBuilder' }"
        class="btn btn-sm btn-primary shadow-sm mr-2"
        title="Create New Visual Block Section"
      >
        <i class="fas fa-plus mr-1"></i>
        <span>Create Block Section</span>
      </router-link>

      <!-- View Favorites on Storefront -->
      <a
        href="/favorite"
        target="_blank"
        class="btn btn-sm btn-outline-primary header-live-btn shadow-sm"
        title="View Wishlist on Storefront"
      >
        <i class="fas fa-external-link-alt mr-1"></i>
        <span>Live Wishlist</span>
      </a>
    </div>
  </DashboardHeader>

  <section class="content pb-5">
    <div class="container-fluid">
      <!-- Hero Overview Banner -->
      <div class="card fav-overview-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
              <span class="badge badge-light px-3 py-1 font-weight-bold text-uppercase mb-2 text-danger">
                Storefront &gt; Customer Wishlist / Favorites
              </span>
              <h4 class="font-weight-bold text-dark mb-1">
                Visual Flow &amp; Wishlist Slot Injections
              </h4>
              <p class="text-muted mb-0 font-14">
                Inspire shopping momentum on the favorites page by inserting curated product recommendations, trending collections, or promotional discount banners around the user's saved wishlist items.
              </p>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="badge badge-danger p-2 font-13 shadow-sm">
                <i class="fas fa-layer-group mr-1"></i> 2 Native Modules + 4 Slot Zones
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Unified Layout Pipeline Component -->
      <PageSectionPipeline
        page-key="favorite"
        page-title="Favorites Page Flow"
        page-subtitle="Configure where custom block builder sections appear across the customer favorites page."
        :native-list="favoriteNativeList"
        first-slot-key="before:favorite_content"
        @saved="onPipelineSaved"
      />

      <!-- Native Modules Reference Card -->
      <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom py-3">
          <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-info-circle text-danger mr-2"></i>
            Native Wishlist Modules Reference Guide
          </h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="thead-light">
                <tr>
                  <th style="width: 60px;">#</th>
                  <th style="width: 250px;">Native Module</th>
                  <th>Description</th>
                  <th style="width: 200px;">Boundary Slots</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(mod, idx) in favoriteNativeList" :key="mod.key">
                  <td class="font-weight-bold text-muted">{{ idx + 1 }}</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="mod-icon-pill mr-2">
                        <i :class="mod.icon"></i>
                      </div>
                      <span class="font-weight-bold text-dark">{{ mod.title }}</span>
                    </div>
                  </td>
                  <td class="text-muted font-13">{{ mod.desc }}</td>
                  <td>
                    <span class="badge badge-secondary font-weight-normal py-1 px-2">
                      after:{{ mod.key }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';
import DashboardHeader from '@/components/DashboardHeader.vue';
import PageSectionPipeline from './builder/PageSectionPipeline.vue';

// 2 Native modules of AIRE's Favorite Page
const favoriteNativeList = [
  {
    key: 'breadcrumb',
    title: 'Left Column Breadcrumb Navigation',
    icon: 'fas fa-folder-open',
    badge: 'Sidebar Nav',
    desc: 'Breadcrumb trail navigating to the full products catalog.'
  },
  {
    key: 'favorite_grid',
    title: 'My Favorite Products Grid',
    icon: 'fas fa-heart',
    badge: 'Product Feed',
    desc: 'Responsive product card grid showing saved items, heart toggle actions, item count badge, and empty state prompt.'
  }
];

function onPipelineSaved() {
  console.log('Favorites layout pipeline updated and cached.');
}
</script>

<style scoped>
.fav-overview-card {
  background: linear-gradient(135deg, #fff1f2 0%, #fdf2f8 100%);
  border-left: 4px solid #e11d48 !important;
  border-radius: 12px;
}

.mod-icon-pill {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #f1f5f9;
  color: #e11d48;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
}

.font-13 {
  font-size: 13px;
}

.font-14 {
  font-size: 14px;
}
</style>

