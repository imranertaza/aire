<template>
  <DashboardHeader title="Category &amp; Shop Catalog Sections">
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

      <!-- View Products on Storefront -->
      <a
        href="/products"
        target="_blank"
        class="btn btn-sm btn-outline-primary header-live-btn shadow-sm"
        title="View Live Catalog on Storefront"
      >
        <i class="fas fa-external-link-alt mr-1"></i>
        <span>Live Catalog</span>
      </a>
    </div>
  </DashboardHeader>

  <section class="content pb-5">
    <div class="container-fluid">
      <!-- Hero Overview Banner -->
      <div class="card catalog-overview-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
              <span class="badge badge-light px-3 py-1 font-weight-bold text-uppercase mb-2 text-primary">
                Storefront &gt; Categories &amp; Shop Catalog
              </span>
              <h4 class="font-weight-bold text-dark mb-1">
                Visual Flow &amp; Slot Injections for Product Catalog
              </h4>
              <p class="text-muted mb-0 font-14">
                Insert seasonal clearance banners, brand logo showcases (Brands Block), buyer's guide FAQs (Accordion Block), or trust badges before and after product solution grids.
              </p>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="badge badge-info p-2 font-13 shadow-sm">
                <i class="fas fa-layer-group mr-1"></i> 3 Native Modules + 4 Slot Zones
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Unified Layout Pipeline Component -->
      <PageSectionPipeline
        page-key="category"
        page-title="Category &amp; Shop Catalog Flow"
        page-subtitle="Configure where custom block builder sections appear across product categories and catalog listing pages."
        :native-list="categoryNativeList"
        first-slot-key="before:catalog_content"
        @saved="onPipelineSaved"
      />

      <!-- Native Modules Reference Card -->
      <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom py-3">
          <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-info-circle text-primary mr-2"></i>
            Native Catalog Modules Reference Guide
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
                <tr v-for="(mod, idx) in categoryNativeList" :key="mod.key">
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

// Native modules of AIRE's Category & Shop Catalog Page
const categoryNativeList = [
  {
    key: 'catalog_header',
    title: 'Catalog Header & Breadcrumbs',
    icon: 'fas fa-compass',
    badge: 'Navigation & Breadcrumbs',
    desc: 'Breadcrumb navigation trail, active category title, solution counts, and mobile horizontal category scrollbar.'
  },
  {
    key: 'product_grid',
    title: 'Product Showcase & Solution Cards',
    icon: 'fas fa-th-large',
    badge: 'Core Solutions Grid',
    desc: 'Ductless feature cards displaying CADR performance ratings, filtration badges, engineering specs, and direct Add-to-Cart actions.'
  },
  {
    key: 'catalog_content',
    title: 'Pagination & Promotional Sidebar',
    icon: 'fas fa-file-alt',
    badge: 'Footer Controls',
    desc: 'Pagination controls and optional right-sidebar promotional banner sliders.'
  }
];

function onPipelineSaved() {
  console.log('Category & shop catalog layout pipeline updated and cached.');
}
</script>

<style scoped>
.catalog-overview-card {
  background: linear-gradient(135deg, #f0fdfa 0%, #e0f2fe 100%);
  border-left: 4px solid #0d9488 !important;
  border-radius: 12px;
}

.mod-icon-pill {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #f1f5f9;
  color: #0d9488;
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

