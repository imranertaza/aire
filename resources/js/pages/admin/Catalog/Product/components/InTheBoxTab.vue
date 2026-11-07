<template>
    <div class="tab-pane fade" id="custom-tabs-in-the-box" role="tabpanel"
        aria-labelledby="tab-in-the-box">
        <!-- Section Header Card -->
        <div class="card card-outline card-primary mb-3">
            <div class="card-header py-2">
                <h6 class="card-title font-weight-bold mb-0">In The Box - Header Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Badge / Tag</label>
                        <input type="text" class="form-control" v-model="formData.in_the_box_badge"
                            placeholder="e.g. PACKAGE CONTENTS" />
                    </div>
                    <div class="col-md-8 form-group">
                        <label>Main Title</label>
                        <input type="text" class="form-control" v-model="formData.in_the_box_title"
                            placeholder="e.g. What's in the Box" />
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Main Description</label>
                        <textarea class="form-control" rows="2" v-model="formData.in_the_box_description"
                            placeholder="e.g. Everything you need for rapid deployment and continuous fresh air right out of the package."></textarea>
                    </div>
                    <div class="col-md-12 form-group mb-0">
                        <label>In The Box Banner Background Image</label>
                        <input type="text" class="form-control" v-model="formData.in_the_box_image"
                            placeholder="e.g. storage/products/box_bg.webp or upload banner image" />
                        <small class="text-muted d-block mt-1">Recommended: 1400 × 700px or wide landscape banner. If omitted, product image is used automatically.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Box Items Repeater Card -->
        <div class="card card-outline card-secondary mb-3">
            <div class="card-header py-2 d-flex justify-content-between align-items-center">
                <h6 class="card-title font-weight-bold mb-0">Dynamic Box Items</h6>
                <button type="button" class="btn btn-primary btn-sm" @click="addItem">
                    <i class="fas fa-plus mr-1"></i> Add Box Item
                </button>
            </div>
            <div class="card-body">
                <div v-if="!formData.in_the_box_items || formData.in_the_box_items.length === 0" class="alert alert-light border text-center py-4 mb-0">
                    <i class="fas fa-box-open fa-2x text-muted mb-2 d-block"></i>
                    <p class="text-muted mb-0">No package items added yet. Click <strong>"Add Box Item"</strong> above to add package contents.</p>
                </div>
                <div v-else class="table-responsive">
                    <table class="table table-bordered table-striped align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 8%;" class="text-center">#</th>
                                <th style="width: 35%;">Item Title</th>
                                <th style="width: 47%;">Description</th>
                                <th style="width: 10%;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in formData.in_the_box_items" :key="index">
                                <td class="text-center font-weight-bold text-primary align-middle" style="font-size: 1.1rem;">
                                    {{ String(index + 1).padStart(2, '0') }}
                                </td>
                                <td>
                                    <input type="text" class="form-control" v-model="item.title"
                                        placeholder="e.g. Main Ventilator Unit" />
                                </td>
                                <td>
                                    <textarea class="form-control" rows="2" v-model="item.description"
                                        placeholder="e.g. Factory-calibrated chassis with pre-fitted acoustic dampening."></textarea>
                                </td>
                                <td class="text-center align-middle">
                                    <button type="button" class="btn btn-danger btn-sm" @click="removeItem(index)" title="Remove Item">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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

const emit = defineEmits(['itemAdded', 'itemRemoved']);

const formData = computed(() => props.form || props.modelValue || {});

const addItem = () => {
    if (!formData.value.in_the_box_items) {
        formData.value.in_the_box_items = [];
    }
    const newItem = {
        title: '',
        description: ''
    };
    formData.value.in_the_box_items.push(newItem);
    emit('itemAdded', newItem);
};

const removeItem = (index) => {
    if (formData.value.in_the_box_items) {
        formData.value.in_the_box_items.splice(index, 1);
        emit('itemRemoved', index);
    }
};
</script>

