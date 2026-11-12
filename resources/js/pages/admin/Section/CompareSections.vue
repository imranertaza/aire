<template>
  <DashboardHeader title="Product Comparison Page Sections">
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

      <!-- View Compare on Storefront -->
      <a
        href="/compare"
        target="_blank"
        class="btn btn-sm btn-outline-primary header-live-btn shadow-sm"
        title="View Product Comparison on Storefront"
      >
        <i class="fas fa-external-link-alt mr-1"></i>
        <span>Live Compare Page</span>
      </a>
    </div>
  </DashboardHeader>

  <section class="content pb-5">
    <div class="container-fluid">
      <!-- Hero Overview Banner -->
      <div class="card comp-overview-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
              <span class="badge badge-light px-3 py-1 font-weight-bold text-uppercase mb-2 text-indigo">
                Storefront &gt; Product Comparison Matrix
              </span>
              <h4 class="font-weight-bold text-dark mb-1">
                Visual Flow &amp; Comparison Slot Injections
              </h4>
              <p class="text-muted mb-0 font-14">
                Help customers evaluate models with confidence by inserting technical explanation guides, filter compatibility tables, or accessory cross-sells directly alongside the comparison matrix.
              </p>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="badge badge-info p-2 font-13 shadow-sm">
                <i class="fas fa-layer-group mr-1"></i> 4 Native Modules + 4 Slot Zones
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Unified Layout Pipeline Component -->
      <PageSectionPipeline
        page-key="compare"
        page-title="Compare Page Flow"
        page-subtitle="Configure where custom block builder sections appear across the product comparison page."
        :native-list="compareNativeList"
        first-slot-key="before:compare_content"
        @saved="onPipelineSaved"
      />

      <!-- Native Modules Reference Card -->
      <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom py-3">
          <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-info-circle text-info mr-2"></i>
            Native Comparison Modules Reference Guide
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
                <tr v-for="(mod, idx) in compareNativeList" :key="mod.key">
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

// 4 Native modules of AIRE's Compare Page
const compareNativeList = [
  {
    key: 'compare_sidebar',
    title: 'Products to Compare Sidebar & Spec Labels',
    icon: 'fas fa-columns',
    badge: 'Sidebar Labels',
    desc: 'Breadcrumb nav, comparison items thumbnail list with quick remove triggers, add product modal button, and spec row label anchors.'
  },
  {
    key: 'compare_matrix',
    title: 'Product Comparison Matrix Table',
    icon: 'fas fa-table',
    badge: 'Comparison Matrix',
    desc: 'Side-by-side columns comparing product photos, prices, category badges, technical specs, coverage areas, and Add to Basket actions.'
  },
  {
    key: 'advice_banner',
    title: 'Expert Advice Consultation Banner',
    icon: 'fas fa-question-circle',
    badge: 'Advice Banner',
    desc: '"Not sure which one to choose?" expert guidance prompt with direct link to contact support.'
  },
  {
    key: 'trust_badges',
    title: 'Trust Badges & Security Assurance Grid',
    icon: 'fas fa-shield-alt',
    badge: 'Trust Strip',
    desc: 'Customer assurance feature grid: Secure Payments, Free Shipping, 30-Day Returns, 1 Year Warranty, and Dedicated Support.'
  }
];

function onPipelineSaved() {
  console.log('Compare layout pipeline updated and cached.');
}
</script>

<style scoped>
.comp-overview-card {
  background: linear-gradient(135deg, #eef2ff 0%, #f0fdf4 100%);
  border-left: 4px solid #4f46e5 !important;
  border-radius: 12px;
}

.text-indigo {
  color: #4f46e5 !important;
}

.mod-icon-pill {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #f1f5f9;
  color: #4f46e5;
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

