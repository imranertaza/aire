<template>
  <DashboardHeader title="Newsroom &amp; Blog Hub Sections">
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

      <!-- View Newsroom on Storefront -->
      <a
        href="/news"
        target="_blank"
        class="btn btn-sm btn-outline-primary header-live-btn shadow-sm"
        title="View Live Newsroom on Storefront"
      >
        <i class="fas fa-external-link-alt mr-1"></i>
        <span>Live Newsroom</span>
      </a>
    </div>
  </DashboardHeader>

  <section class="content pb-5">
    <div class="container-fluid">
      <!-- Hero Overview Banner -->
      <div class="card news-overview-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
              <span class="badge badge-light px-3 py-1 font-weight-bold text-uppercase mb-2 text-primary">
                Storefront &gt; Newsroom &amp; Editorial Hub
              </span>
              <h4 class="font-weight-bold text-dark mb-1">
                Visual Flow &amp; Slot Injections for Newsroom
              </h4>
              <p class="text-muted mb-0 font-14">
                Insert newsletter subscription blocks, featured clean air whitepapers, breaking announcement banners, or spotlight product cards around native editorial modules.
              </p>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="badge badge-info p-2 font-13 shadow-sm">
                <i class="fas fa-layer-group mr-1"></i> 4 Native Modules + 5 Slot Zones
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Unified Layout Pipeline Component -->
      <PageSectionPipeline
        page-key="news"
        page-title="Newsroom &amp; Blog Flow"
        page-subtitle="Configure where custom block builder sections appear across the newsroom and editorial hub."
        :native-list="newsNativeList"
        first-slot-key="before:header_bar"
        @saved="onPipelineSaved"
      />

      <!-- Native Modules Reference Card -->
      <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom py-3">
          <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-info-circle text-primary mr-2"></i>
            Native Newsroom Modules Reference Guide
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
                <tr v-for="(mod, idx) in newsNativeList" :key="mod.key">
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

// 4 Native modules of AIRE's Newsroom & Editorial Hub
const newsNativeList = [
  {
    key: 'header_bar',
    title: 'Newsroom Header & Category Filters',
    icon: 'fas fa-newspaper',
    badge: 'Header & Search',
    desc: 'Breadcrumb navigation, editorial page title, live keyword search input, and dynamic category pill track.'
  },
  {
    key: 'featured_spotlight',
    title: 'Lead Editorial Story Spotlight',
    icon: 'fas fa-star',
    badge: 'Featured Spotlight',
    desc: 'High-impact editorial hero card displaying lead story image, reading time, published date, category tag, and read link.'
  },
  {
    key: 'articles_grid',
    title: 'Newsroom Articles Grid & Pagination',
    icon: 'fas fa-th-large',
    badge: 'Publications Grid',
    desc: 'Responsive 3-column articles grid with article thumbnail, publication date, author tag, brief description, and pagination.'
  },
  {
    key: 'media_cta',
    title: 'Media Relations & Press CTA',
    icon: 'fas fa-bullhorn',
    badge: 'Media Contact',
    desc: 'Bottom CTA card linking journalists and media inquiries to direct communications desks.'
  }
];

function onPipelineSaved() {
  console.log('Newsroom layout pipeline updated and cached.');
}
</script>

<style scoped>
.news-overview-card {
  background: linear-gradient(135deg, #fdf4ff 0%, #f0f9ff 100%);
  border-left: 4px solid #9333ea !important;
  border-radius: 12px;
}

.mod-icon-pill {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #f1f5f9;
  color: #9333ea;
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

