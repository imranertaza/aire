<template>
  <DashboardHeader title="Order Confirmation Page Sections">
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

      <!-- View Order Confirm on Storefront -->
      <a
        href="/order-confirm"
        target="_blank"
        class="btn btn-sm btn-outline-primary header-live-btn shadow-sm"
        title="View Order Confirmation on Storefront"
      >
        <i class="fas fa-external-link-alt mr-1"></i>
        <span>Live Order Confirm</span>
      </a>
    </div>
  </DashboardHeader>

  <section class="content pb-5">
    <div class="container-fluid">
      <!-- Hero Overview Banner -->
      <div class="card order-overview-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
              <span class="badge badge-light px-3 py-1 font-weight-bold text-uppercase mb-2 text-success">
                Storefront &gt; Order Confirmation / Thank You
              </span>
              <h4 class="font-weight-bold text-dark mb-1">
                Visual Flow &amp; Post-Purchase Slot Injections
              </h4>
              <p class="text-muted mb-0 font-14">
                Drive post-purchase engagement by inserting replacement filter subscriptions, warranty extensions, VIP membership invites, or cross-sell accessories directly into the customer thank-you journey.
              </p>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="badge badge-success p-2 font-13 shadow-sm">
                <i class="fas fa-layer-group mr-1"></i> 5 Native Modules + 7 Slot Zones
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Unified Layout Pipeline Component -->
      <PageSectionPipeline
        page-key="order_confirm"
        page-title="Order Confirmation Flow"
        page-subtitle="Configure where custom block builder sections appear across the order confirmation page."
        :native-list="orderConfirmNativeList"
        first-slot-key="before:order_confirmation"
        @saved="onPipelineSaved"
      />

      <!-- Native Modules Reference Card -->
      <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom py-3">
          <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-info-circle text-success mr-2"></i>
            Native Order Confirmation Modules Reference Guide
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
                  <th style="width: 220px;">Boundary Slots</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(mod, idx) in orderConfirmNativeList" :key="mod.key">
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

// 5 Native modules of AIRE's Order Confirmation Page
const orderConfirmNativeList = [
  {
    key: 'order_summary',
    title: 'Order Summary & Estimated Delivery',
    icon: 'fas fa-receipt',
    badge: 'Sidebar',
    desc: 'Left column with item thumbnail list, breakdown totals (Subtotal, Shipping, Tax, Total), and estimated delivery date range.'
  },
  {
    key: 'hero_card',
    title: 'Order Confirmation Hero Card',
    icon: 'fas fa-check-circle',
    badge: 'Hero Card',
    desc: 'Congratulatory success checkmark, confirmation email notice, and formatted AIRE Order Number pill.'
  },
  {
    key: 'timeline',
    title: 'What Happens Next Timeline',
    icon: 'fas fa-tasks',
    badge: 'Status Timeline',
    desc: 'Step-by-step progress tracking: Confirmed, Processing, Shipping, and Delivered.'
  },
  {
    key: 'order_details',
    title: 'Order Details & Shipping Address',
    icon: 'fas fa-shipping-fast',
    badge: 'Order & Shipping',
    desc: 'Order date, payment method, payment status badge, and recipient delivery address.'
  },
  {
    key: 'support_card',
    title: 'Customer Support Assistance Card',
    icon: 'fas fa-headset',
    badge: 'Support CTA',
    desc: 'Direct contact support action buttons and direct email links for order assistance.'
  }
];

function onPipelineSaved() {
  console.log('Order confirmation layout pipeline updated and cached.');
}
</script>

<style scoped>
.order-overview-card {
  background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
  border-left: 4px solid #16a34a !important;
  border-radius: 12px;
}

.mod-icon-pill {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #f1f5f9;
  color: #16a34a;
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

