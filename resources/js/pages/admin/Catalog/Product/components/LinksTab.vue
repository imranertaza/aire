<template>
    <div class="tab-pane fade" id="custom-tabs-links" role="tabpanel"
        aria-labelledby="tab-links">
        <div class="row">
            <div class="col-md-6 form-group">
                <label>Product Featured</label>
                <select class="form-control" v-model="formData.featured">
                    <option :value="1">Yes</option>
                    <option :value="0">No</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label>Free Delivery</label>
                <select class="form-control" v-model="formData.product_free_delivery">
                    <option :value="1">Yes</option>
                    <option :value="0">No</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label>Brand</label>
                <select class="form-control" v-model="formData.brand_id">
                    <option value="">-- Select Brand --</option>
                    <option v-for="b in brands" :key="b.id" :value="b.id">{{ b.name }}</option>
                </select>
            </div>

            <!-- Multiple Categories Dropdown -->
            <div class="col-md-6 form-group">
                <label>Category <span class="text-danger">*</span></label>
                <Multiselect v-model="formData.category_ids" :options="categoriesOptions"
                    mode="tags" placeholder="Select Category" searchable
                    class="multiselect-custom" />
            </div>

            <!-- Related Products -->
            <div class="col-md-6 form-group">
                <label>Related Product</label>
                <Multiselect v-model="formData.related_ids" :options="productsOptions"
                    mode="tags" placeholder="Select Related Product" searchable
                    class="multiselect-custom" />
            </div>

            <!-- Bought Together Products -->
            <div class="col-md-6 form-group">
                <label>Bought Together Products</label>
                <Multiselect v-model="formData.bought_together_ids" :options="productsOptions"
                    mode="tags" placeholder="Select Bought Together Products" searchable
                    class="multiselect-custom" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';

const props = defineProps({
    modelValue: {
        type: Object,
        default: null
    },
    form: {
        type: Object,
        default: null
    },
    brands: {
        type: Array,
        default: () => []
    },
    categoriesOptions: {
        type: Array,
        default: () => []
    },
    productsOptions: {
        type: Array,
        default: () => []
    }
});

const formData = computed(() => props.form || props.modelValue || {});
</script>

<style>
.multiselect-custom {
    --ms-border-color: #ced4da;
    --ms-border-width: 1px;
    --ms-radius: 4px;
    --ms-bg: #ffffff;
    --ms-tag-bg: #f1f2f6;
    --ms-tag-color: #2f3542;
    --ms-tag-radius: 4px;
}

.multiselect-custom .multiselect-tags-search {
    background-color: transparent !important;
}
</style>
