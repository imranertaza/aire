<template>
  <DashboardHeader title="Resources &amp; Documentation Sections">
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

      <!-- View Resources on Storefront -->
      <a
        href="/resources"
        target="_blank"
        class="btn btn-sm btn-outline-primary header-live-btn shadow-sm"
        title="View Live Resources on Storefront"
      >
        <i class="fas fa-external-link-alt mr-1"></i>
        <span>Live Resources</span>
      </a>
    </div>
  </DashboardHeader>

  <section class="content pb-5">
    <div class="container-fluid">
      <!-- Hero Overview Banner -->
      <div class="card resources-overview-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
              <span class="badge badge-light px-3 py-1 font-weight-bold text-uppercase mb-2 text-primary">
                Storefront &gt; Resources &amp; Documentation Hub
              </span>
              <h4 class="font-weight-bold text-dark mb-1">
                Visual Flow &amp; Slot Injections for Technical Documentation
              </h4>
              <p class="text-muted mb-0 font-14">
                Enhance your resources portal by inserting enterprise consultation banners, featured warranty guides, interactive video spotlights, or customer assistance blocks around native catalogs and downloads.
              </p>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="badge badge-primary p-2 font-13 shadow-sm">
                <i class="fas fa-layer-group mr-1"></i> 3 Native Modules + 4 Slot Zones
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Unified Layout Pipeline Component -->
      <PageSectionPipeline
        page-key="resources"
        page-title="Resources &amp; Documentation Flow"
        page-subtitle="Configure where custom block builder sections appear across technical brochures, catalogs, video guides, and manual downloads."
        :native-list="resourceNativeList"
        first-slot-key="before:resource_content"
        @saved="onPipelineSaved"
      />

      <!-- Native Modules Reference Card -->
      <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom py-3">
          <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-info-circle text-primary mr-2"></i>
            Native Resources Modules Reference Guide
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
                <tr v-for="(mod, idx) in resourceNativeList" :key="mod.key">
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

// 3 Native modules of AIRE's Resources & Documentation Page
const resourceNativeList = [
  {
    key: 'sidebar_nav',
    title: 'Left Sticky Category Sidebar',
    icon: 'fas fa-folder-open',
    badge: 'Category Index',
    desc: 'Desktop sticky category navigation menu and mobile horizontal category pill track with 24/7 technical support link.'
  },
  {
    key: 'resource_header',
    title: 'Header & Global Search Toolbar',
    icon: 'fas fa-search',
    badge: 'Header & Search',
    desc: 'Breadcrumb navigation trail, main Resources title, narrative description, and real-time keyword search input.'
  },
  {
    key: 'catalog',
    title: 'Resource Category Cards & File Grid',
    icon: 'fas fa-book-open',
    badge: 'Resource Content Grid',
    desc: 'Categorized sections featuring downloadable PDF brochures, user manuals, video modal tutorials, and FAQ accordion cards.'
  }
];

function onPipelineSaved() {
  console.log('Resources layout pipeline updated and cached.');
}
</script>

<style scoped>
.resources-overview-card {
  background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);
  border-left: 4px solid #2563eb !important;
  border-radius: 12px;
}

.mod-icon-pill {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #f1f5f9;
  color: #2563eb;
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

