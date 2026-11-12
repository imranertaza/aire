<template>
  <DashboardHeader title="Article Details (Single Post) Sections">
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

      <!-- View News on Storefront -->
      <a
        href="/news"
        target="_blank"
        class="btn btn-sm btn-outline-primary header-live-btn shadow-sm"
        title="View Newsroom on Storefront"
      >
        <i class="fas fa-external-link-alt mr-1"></i>
        <span>Newsroom Hub</span>
      </a>
    </div>
  </DashboardHeader>

  <section class="content pb-5">
    <div class="container-fluid">
      <!-- Hero Overview Banner -->
      <div class="card article-overview-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
              <span class="badge badge-light px-3 py-1 font-weight-bold text-uppercase mb-2 text-primary">
                Storefront &gt; Single News Article Details
              </span>
              <h4 class="font-weight-bold text-dark mb-1">
                Visual Flow &amp; Slot Injections for Article Pages
              </h4>
              <p class="text-muted mb-0 font-14">
                Insert relevant product recommendation cards (Products Block), newsletter subscription boxes, author bio highlights, or whitepaper download CTAs directly under the article narrative.
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
        page-key="news_detail"
        page-title="Article Details Flow"
        page-subtitle="Configure where custom block builder sections appear across single article detail pages."
        :native-list="newsDetailNativeList"
        first-slot-key="before:article_header"
        @saved="onPipelineSaved"
      />

      <!-- Native Modules Reference Card -->
      <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom py-3">
          <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-info-circle text-primary mr-2"></i>
            Native Article Modules Reference Guide
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
                <tr v-for="(mod, idx) in newsDetailNativeList" :key="mod.key">
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

// 4 Native modules of AIRE's Single News Article Details Page
const newsDetailNativeList = [
  {
    key: 'article_header',
    title: 'Article Header, Category & Social Share Bar',
    icon: 'fas fa-heading',
    badge: 'Header & Share',
    desc: 'Breadcrumb trail, category pill, editorial headline, lead summary, publication timestamp, reading duration, and social share links.'
  },
  {
    key: 'article_body',
    title: 'Featured Image Banner & Article Body',
    icon: 'fas fa-newspaper',
    badge: 'Core Content',
    desc: 'High-resolution editorial hero photography and full rich-text article narrative content.'
  },
  {
    key: 'article_footer',
    title: 'Article Tags & Editorial Back Navigation',
    icon: 'fas fa-tags',
    badge: 'Tags & Nav',
    desc: 'Category hashtags and return link to all news & media publications.'
  },
  {
    key: 'related_stories',
    title: 'Related Recent Stories Showcase',
    icon: 'fas fa-cubes',
    badge: 'Related Grid',
    desc: 'Card showcase presenting related corporate announcements, research whitepapers, and air quality initiatives.'
  }
];

function onPipelineSaved() {
  console.log('Article details layout pipeline updated and cached.');
}
</script>

<style scoped>
.article-overview-card {
  background: linear-gradient(135deg, #fefce8 0%, #f0fdf4 100%);
  border-left: 4px solid #ca8a04 !important;
  border-radius: 12px;
}

.mod-icon-pill {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #f1f5f9;
  color: #ca8a04;
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

