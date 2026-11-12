<template>
  <div class="product-inspector">
    <!-- CONTENT TAB -->
    <div v-if="activeTab === 'content'">
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-database mr-1 text-primary"></i> Data Source
        </h6>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Product Source</label>
          <select v-model="settings.source" class="form-control form-control-sm">
            <option value="latest">Latest Published Products</option>
            <option value="featured">Featured Products (Star/Highlight)</option>
            <option value="category">Specific Category</option>
          </select>
        </div>

        <!-- Category selector if source === 'category' -->
        <div class="form-group mb-2" v-if="settings.source === 'category'">
          <label class="small font-weight-bold text-dark">Select Category</label>
          <select v-model="settings.category_id" class="form-control form-control-sm">
            <option :value="null">-- Select a Category --</option>
            <option v-for="cat in categoriesList" :key="cat.id" :value="cat.id">
              {{ cat.category_name }}
            </option>
          </select>
        </div>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Items Limit</label>
          <select v-model.number="settings.limit" class="form-control form-control-sm">
            <option :value="2">2 Products</option>
            <option :value="3">3 Products</option>
            <option :value="4">4 Products (Standard)</option>
            <option :value="6">6 Products (2 Rows)</option>
            <option :value="8">8 Products (Double Row)</option>
            <option :value="12">12 Products</option>
          </select>
        </div>
      </div>

      <!-- Grid Columns Layout -->
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-th-large mr-1 text-primary"></i> Grid Columns
        </h6>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Desktop Columns</label>
          <select v-model="settings.columns_desktop" class="form-control form-control-sm">
            <option value="col-lg-3">4 Columns (col-lg-3)</option>
            <option value="col-lg-4">3 Columns (col-lg-4)</option>
            <option value="col-lg-6">2 Columns (col-lg-6)</option>
          </select>
        </div>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Mobile Columns</label>
          <select v-model="settings.columns_mobile" class="form-control form-control-sm">
            <option value="col-6">2 Columns Side-by-Side (col-6)</option>
            <option value="col-12">1 Column Full Width (col-12)</option>
          </select>
        </div>
      </div>

      <!-- Card Elements Toggles -->
      <div class="card border rounded-3 p-3 mb-2 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-sliders-h mr-1 text-primary"></i> Card Elements
        </h6>

        <div class="custom-control custom-switch mb-2">
          <input
            type="checkbox"
            v-model="settings.show_badge"
            class="custom-control-input"
            :id="'prodShowBadgeSwitch_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'prodShowBadgeSwitch_' + block.id">
            Show Promotional Badges
          </label>
        </div>

        <div class="custom-control custom-switch mb-2">
          <input
            type="checkbox"
            v-model="settings.show_price"
            class="custom-control-input"
            :id="'prodShowPriceSwitch_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'prodShowPriceSwitch_' + block.id">
            Show Price & Special Offers
          </label>
        </div>

        <div class="custom-control custom-switch mb-0">
          <input
            type="checkbox"
            v-model="settings.show_action_buttons"
            class="custom-control-input"
            :id="'prodShowActionSwitch_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'prodShowActionSwitch_' + block.id">
            Show Add to Cart Button
          </label>
        </div>
      </div>
    </div>

    <!-- STYLE TAB -->
    <div v-else-if="activeTab === 'style'">
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-box-open mr-1 text-primary"></i> Product Grid Appearance
        </h6>

        <div class="row">
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Card Shadow</label>
              <select v-model="settings.card_shadow" class="form-control form-control-sm">
                <option value="">None</option>
                <option value="shadow-sm">Soft (sm)</option>
                <option value="shadow">Medium</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Hover Effect</label>
              <select v-model="settings.hover_effect" class="form-control form-control-sm">
                <option value="lift">Hover Lift Up</option>
                <option value="none">None</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
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
  },
  productCategories: {
    type: Array,
    default: () => []
  }
});

const localCategories = ref([]);

const categoriesList = ref([]);

async function loadCategories() {
  if (props.productCategories && props.productCategories.length > 0) {
    categoriesList.value = props.productCategories;
    return;
  }
  try {
    const { data } = await axios.get('/api/product-categories/all');
    categoriesList.value = data.data || [];
  } catch (err) {
    console.error('Failed to load product categories', err);
  }
}

onMounted(() => {
  loadCategories();
});
</script>

