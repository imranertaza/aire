<template>
    <div class="tab-pane fade" id="custom-tabs-specials" role="tabpanel"
        aria-labelledby="tab-specials">
        <div class="row">
            <div class="col-md-4 form-group">
                <label>Special Price</label>
                <input min="0" type="number" step="0.01" class="form-control"
                    v-model="formData.special_price" placeholder="Special Price" />
            </div>
            <div class="col-md-4 form-group">
                <label>Start Date</label>
                <input type="date" class="form-control" v-model="formData.special_start_date" />
            </div>
            <div class="col-md-4 form-group">
                <label>End Date</label>
                <input type="date" class="form-control" v-model="formData.special_end_date" />
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
