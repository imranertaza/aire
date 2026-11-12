<template>
  <DashboardHeader title="Shopping Cart Page Sections">
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

      <!-- View Cart on Storefront -->
      <a
        href="/cart"
        target="_blank"
        class="btn btn-sm btn-outline-primary header-live-btn shadow-sm"
        title="View Shopping Cart on Storefront"
      >
        <i class="fas fa-external-link-alt mr-1"></i>
        <span>Live Shopping Cart</span>
      </a>
    </div>
  </DashboardHeader>

  <section class="content pb-5">
    <div class="container-fluid">
      <!-- Hero Overview Banner -->
      <div class="card cart-overview-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
              <span class="badge badge-light px-3 py-1 font-weight-bold text-uppercase mb-2 text-primary">
                Storefront &gt; Shopping Basket / Cart
              </span>
              <h4 class="font-weight-bold text-dark mb-1">
                Visual Flow &amp; Conversion Slot Injections
              </h4>
              <p class="text-muted mb-0 font-14">
                Boost average order value and checkout conversions by injecting free shipping progress notices, payment security seals, or cross-sell accessories directly into the cart timeline.
              </p>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="badge badge-primary p-2 font-13 shadow-sm">
                <i class="fas fa-layer-group mr-1"></i> 4 Native Modules + 6 Slot Zones
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Unified Layout Pipeline Component -->
      <PageSectionPipeline
        page-key="cart"
        page-title="Shopping Cart Flow"
        page-subtitle="Configure where custom block builder sections appear across the shopping basket page."
        :native-list="cartNativeList"
        first-slot-key="before:cart_content"
        @saved="onPipelineSaved"
      />

      <!-- Native Modules Reference Card -->
      <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom py-3">
          <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-info-circle text-primary mr-2"></i>
            Native Shopping Cart Modules Reference Guide
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
                <tr v-for="(mod, idx) in cartNativeList" :key="mod.key">
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

// 4 Native modules of AIRE's Shopping Cart Page
const cartNativeList = [
  {
    key: 'order_summary',
    title: 'Order Summary & Checkout Box',
    icon: 'fas fa-calculator',
    badge: 'Sidebar Summary',
    desc: 'Sticky sidebar with item subtotal, discount codes, estimated total, Proceed to Checkout button, secure packaging note, and guarantee badge.'
  },
  {
    key: 'cart_items',
    title: 'My Basket Items & Quantity Controls',
    icon: 'fas fa-shopping-basket',
    badge: 'Cart Table',
    desc: 'List of basket items with image thumbnails, titles, variant options, quantity increment/decrement buttons, price subtotals, and Continue Shopping link.'
  },
  {
    key: 'saved_later',
    title: 'Saved For Later Showcase',
    icon: 'fas fa-bookmark',
    badge: 'Saved Items',
    desc: 'Customer bookmarked items card grid with Move to Basket and Remove action buttons.'
  },
  {
    key: 'trust_features',
    title: 'Trust Badges & Security Strip',
    icon: 'fas fa-shield-alt',
    badge: 'Trust Strip',
    desc: '4-column assurance strip highlighting Secure Payments, Free Shipping threshold, 30-Day Returns, and 1 Year Warranty.'
  }
];

function onPipelineSaved() {
  console.log('Shopping cart layout pipeline updated and cached.');
}
</script>

<style scoped>
.cart-overview-card {
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

