<template>
  <DashboardHeader title="404 Not Found Page Sections">
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

      <!-- View 404 on Storefront -->
      <a
        href="/404-preview-test"
        target="_blank"
        class="btn btn-sm btn-outline-primary header-live-btn shadow-sm"
        title="Preview 404 Page on Storefront"
      >
        <i class="fas fa-external-link-alt mr-1"></i>
        <span>Preview 404 Page</span>
      </a>
    </div>
  </DashboardHeader>

  <section class="content pb-5">
    <div class="container-fluid">
      <!-- Hero Overview Banner -->
      <div class="card notfound-overview-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
              <span class="badge badge-light px-3 py-1 font-weight-bold text-uppercase mb-2 text-warning">
                Storefront &gt; 404 Not Found / Error Recovery
              </span>
              <h4 class="font-weight-bold text-dark mb-1">
                Visual Flow &amp; Visitor Retention Injections
              </h4>
              <p class="text-muted mb-0 font-14">
                Retain visitors who land on broken or outdated links by showcasing best-selling air purifiers, trending categories, or an interactive FAQ accordion directly below the 404 message.
              </p>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="badge badge-warning p-2 font-13 shadow-sm text-dark">
                <i class="fas fa-layer-group mr-1"></i> 2 Native Modules + 4 Slot Zones
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Unified Layout Pipeline Component -->
      <PageSectionPipeline
        page-key="not_found"
        page-title="404 Page Flow"
        page-subtitle="Configure where custom block builder sections appear across the 404 error page."
        :native-list="notFoundNativeList"
        first-slot-key="before:error_content"
        @saved="onPipelineSaved"
      />

      <!-- Native Modules Reference Card -->
      <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom py-3">
          <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-info-circle text-warning mr-2"></i>
            Native 404 Error Modules Reference Guide
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
                <tr v-for="(mod, idx) in notFoundNativeList" :key="mod.key">
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

// 2 Native modules of AIRE's 404 Page
const notFoundNativeList = [
  {
    key: 'search_box',
    title: '404 Hero & Search Bar',
    icon: 'fas fa-search',
    badge: 'Error Card',
    desc: 'ATMOSPHERIC CALIBRATION pulse badge, bold 404 code, "Lost in the Air Current" headline, explanation, and live search bar.'
  },
  {
    key: 'error_card',
    title: 'Navigation Actions & Quick Portals',
    icon: 'fas fa-compass',
    badge: 'Actions & Portals',
    desc: 'Action buttons (Return Home, Explore Catalog, Precision Wizard) and quick portal pills (Enterprise, Residential, Commercial, Support).'
  }
];

function onPipelineSaved() {
  console.log('404 error page layout pipeline updated and cached.');
}
</script>

<style scoped>
.notfound-overview-card {
  background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
  border-left: 4px solid #f59e0b !important;
  border-radius: 12px;
}

.mod-icon-pill {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #f1f5f9;
  color: #d97706;
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

