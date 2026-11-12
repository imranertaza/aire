<template>
  <DashboardHeader title="Product Page (PDP) Sections">
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

      <!-- View Catalog on Storefront -->
      <a
        href="/products"
        target="_blank"
        class="btn btn-sm btn-outline-primary header-live-btn shadow-sm"
        title="Browse Products on Storefront"
      >
        <i class="fas fa-external-link-alt mr-1"></i>
        <span>View Storefront PDP</span>
      </a>
    </div>
  </DashboardHeader>

  <section class="content pb-5">
    <div class="container-fluid">
      <!-- Hero Overview Banner -->
      <div class="card pdp-overview-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
              <span class="badge badge-light px-3 py-1 font-weight-bold text-uppercase mb-2 text-primary">
                Storefront &gt; Product Detail Page (PDP)
              </span>
              <h4 class="font-weight-bold text-dark mb-1">
                Visual Flow &amp; Slot Injections for Product Pages
              </h4>
              <p class="text-muted mb-0 font-14">
                Insert promotional banners, comparison matrices, trust badges, customer reviews, or brand blocks between native product sections without altering any core Blade logic.
              </p>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="badge badge-info p-2 font-13 shadow-sm">
                <i class="fas fa-layer-group mr-1"></i> 9 Native Modules + 10 Slot Zones
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Unified Layout Pipeline Component -->
      <PageSectionPipeline
        page-key="product"
        page-title="Product Detail Page Flow"
        page-subtitle="Configure where custom block builder sections appear across all product detail pages."
        :native-list="productNativeList"
        first-slot-key="before:product_top"
        @saved="onPipelineSaved"
      />

      <!-- Native Modules Reference Card -->
      <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom py-3">
          <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-info-circle text-primary mr-2"></i>
            Native Product Modules Reference Guide
          </h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="thead-light">
                <tr>
                  <th style="width: 60px;">#</th>
                  <th style="width: 220px;">Native Module</th>
                  <th>Description</th>
                  <th style="width: 180px;">Boundary Slots</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(mod, idx) in productNativeList" :key="mod.key">
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

// 9 Native modules of AIRE's Product Detail Page
const productNativeList = [
  {
    key: 'product_top',
    title: 'Product Buy Box, Gallery & Pricing',
    icon: 'fas fa-shopping-bag',
    badge: 'Core PDP',
    desc: 'Breadcrumb navigation, product image gallery, variant selector, pricing, Add-to-Cart and action buttons.'
  },
  {
    key: 'overview',
    title: 'Product Overview & Highlights',
    icon: 'fas fa-info-circle',
    badge: 'Overview',
    desc: 'Editorial product overview title, long description, key feature cards, and parallax hero visualization.'
  },
  {
    key: 'specs',
    title: 'Technical Specifications',
    icon: 'fas fa-sliders-h',
    badge: 'Specs',
    desc: 'Four technical performance spec meters (CADR, filter grade, quiet acoustics, power efficiency).'
  },
  {
    key: 'features',
    title: 'Feature Grid & Capabilities',
    icon: 'fas fa-star',
    badge: 'Features',
    desc: 'Detailed capabilities matrix showcasing sensors, connectivity, filtration mechanics, and design.'
  },
  {
    key: 'tech',
    title: 'Engineering & Core Technology',
    icon: 'fas fa-microchip',
    badge: 'Technology',
    desc: 'Deep-dive technology card with aerodynamic engineering illustrations and airflow diagrams.'
  },
  {
    key: 'in_the_box',
    title: 'In The Box (Unboxing Items)',
    icon: 'fas fa-box-open',
    badge: 'In The Box',
    desc: 'Glassmorphism cards itemizing components, replacement filters, adapters, and documentation.'
  },
  {
    key: 'applications',
    title: 'Applications & Environments',
    icon: 'fas fa-building',
    badge: 'Applications',
    desc: 'Showcase of application spaces: cleanrooms, laboratories, urban offices, and residential rooms.'
  },
  {
    key: 'related_products',
    title: 'Related Products Showcase',
    icon: 'fas fa-cubes',
    badge: 'Related',
    desc: 'Carousel/grid of related models, compatible accessories, and replacement filters.'
  },
  {
    key: 'faq',
    title: 'Frequently Asked Questions (FAQ)',
    icon: 'fas fa-question-circle',
    badge: 'Support',
    desc: 'Product-specific FAQ accordion addressing maintenance, filter replacement, and warranty coverage.'
  }
];

function onPipelineSaved() {
  console.log('Product page layout pipeline updated and cached.');
}
</script>

<style scoped>
.pdp-overview-card {
  background: linear-gradient(135deg, #f0f7ff 0%, #e0f2fe 100%);
  border-left: 4px solid #0284c7 !important;
  border-radius: 12px;
}

.mod-icon-pill {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #f1f5f9;
  color: #0284c7;
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
