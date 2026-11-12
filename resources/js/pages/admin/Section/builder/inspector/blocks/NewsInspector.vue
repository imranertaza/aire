<template>
  <div class="news-inspector">
    <!-- CONTENT TAB -->
    <div v-if="activeTab === 'content'">
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-newspaper mr-1 text-primary"></i> News / Articles Source
        </h6>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Articles Limit</label>
          <select v-model.number="settings.limit" class="form-control form-control-sm">
            <option :value="3">3 Articles (Standard 1 Row)</option>
            <option :value="4">4 Articles</option>
            <option :value="6">6 Articles (2 Rows)</option>
            <option :value="9">9 Articles (3 Rows)</option>
          </select>
        </div>
      </div>

      <div class="card border rounded-3 p-3 mb-2 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-th-large mr-1 text-primary"></i> Grid Columns
        </h6>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Desktop Columns</label>
          <select v-model="settings.columns_desktop" class="form-control form-control-sm">
            <option value="col-lg-4">3 Columns (col-lg-4)</option>
            <option value="col-lg-3">4 Columns (col-lg-3)</option>
            <option value="col-lg-6">2 Columns (col-lg-6)</option>
          </select>
        </div>

        <div class="form-group mb-0">
          <label class="small font-weight-bold text-dark">Mobile Columns</label>
          <select v-model="settings.columns_mobile" class="form-control form-control-sm">
            <option value="col-12">1 Column Full Width (col-12)</option>
            <option value="col-6">2 Columns (col-6)</option>
          </select>
        </div>
      </div>
    </div>

    <!-- STYLE TAB -->
    <div v-else-if="activeTab === 'style'">
      <div class="alert alert-light border small text-muted text-center py-3">
        <i class="fas fa-info-circle mr-1 text-primary"></i>
        News cards automatically adopt the global theme styling and responsive layout.
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  block: {
    type: Object,
    required: true
  },
  settings: {
    type: Object,
    required: true
  },
  activeTab: {
    type: String,
    default: 'content'
  }
});
</script>

