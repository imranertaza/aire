<template>
    <div class="tab-pane fade" id="custom-tabs-data" role="tabpanel"
        aria-labelledby="tab-data">
        <div class="row">
            <div class="col-md-6 form-group">
                <label>Model <span class="text-danger">*</span></label>
                <input type="text" class="form-control" v-model="formData.model" required />
            </div>
            <div class="col-md-6 form-group">
                <label>Product Code / SKU</label>
                <input type="text" class="form-control" v-model="formData.product_code" />
            </div>
            <div class="col-md-6 form-group">
                <label>Price <span class="text-danger">*</span></label>
                <input min="0" type="number" step="0.01" class="form-control"
                    v-model="formData.price" required />
            </div>
            <div class="col-md-6 form-group">
                <label>Quantity <span class="text-danger">*</span></label>
                <input min="0" type="number" class="form-control" v-model="formData.quantity"
                    required />
            </div>
            <div class="col-md-3 form-group">
                <label>Weight</label>
                <input min="0" type="number" step="0.0001" class="form-control"
                    v-model="formData.weight" />
            </div>
            <div class="col-md-3 form-group">
                <label>Length</label>
                <input min="0" type="number" step="0.0001" class="form-control"
                    v-model="formData.length" />
            </div>
            <div class="col-md-3 form-group">
                <label>Width</label>
                <input min="0" type="number" step="0.0001" class="form-control"
                    v-model="formData.width" />
            </div>
            <div class="col-md-3 form-group">
                <label>Height</label>
                <input min="0" type="number" step="0.0001" class="form-control"
                    v-model="formData.height" />
            </div>
            <div class="col-md-4 form-group">
                <label>Date Available</label>
                <input type="date" class="form-control" v-model="formData.date_available" />
            </div>
            <div class="col-md-4 form-group">
                <label>Sort Order</label>
                <input min="0" type="number" class="form-control"
                    v-model="formData.sort_order" />
            </div>
            <div class="col-md-4 form-group">
                <label>Status</label>
                <select class="form-control" v-model="formData.status">
                    <option :value="1">Active</option>
                    <option :value="0">Inactive</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: Object,
        default: null
    },
    form: {
        type: Object,
        default: null
    }
});

const formData = computed(() => props.form || props.modelValue || {});
</script>
