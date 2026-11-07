<template>
    <div class="tab-pane fade" id="custom-tabs-options" role="tabpanel"
        aria-labelledby="tab-options">
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Add Option</label>
                <select class="form-control" v-model="selectedOptionIdToAdd"
                    @change="addOptionRow">
                    <option value="">-- Select Option to Add --</option>
                    <option v-for="opt in availableOptions" :key="opt.id" :value="opt.id">{{
                        opt.name }}</option>
                </select>
            </div>
        </div>
        <div class="table-responsive" v-if="formData.options && formData.options.length > 0">
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th>Option</th>
                        <th>Option Value</th>
                        <th>Quantity</th>
                        <th>Subtract</th>
                        <th>Price Prefix</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(prodOpt, index) in formData.options" :key="index">
                        <td>{{ prodOpt.option_name }}</td>
                        <td>
                            <select class="form-control" v-model="prodOpt.option_value_id"
                                required>
                                <option value="">-- Select Value --</option>
                                <option v-for="val in prodOpt.available_values"
                                    :key="val.id" :value="val.id">{{ val.name }}</option>
                            </select>
                        </td>
                        <td>
                            <input min="0" type="number" class="form-control"
                                v-model="prodOpt.quantity" required />
                        </td>
                        <td>
                            <select class="form-control" v-model="prodOpt.subtract">
                                <option :value="1">Yes</option>
                                <option :value="0">No</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" v-model="prodOpt.price_prefix">
                                <option value="+">+</option>
                                <option value="-">-</option>
                            </select>
                        </td>
                        <td>
                            <input min="0" type="number" step="0.01" class="form-control"
                                v-model="prodOpt.price" />
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger"
                                @click="removeOptionRow(index)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="alert alert-info">No options added yet.</div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: Object,
        default: null
    },
    form: {
        type: Object,
        default: null
    },
    availableOptions: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['optionAdded', 'optionRemoved']);

const selectedOptionIdToAdd = ref("");

const formData = computed(() => props.form || props.modelValue || {});

const addOptionRow = () => {
    if (!selectedOptionIdToAdd.value) return;

    if (!formData.value.options) {
        formData.value.options = [];
    }

    const val = selectedOptionIdToAdd.value;
    const opt = (typeof val === 'object' && val !== null) 
        ? val 
        : (props.availableOptions || []).find(o => Number(o.id) === Number(val));

    if (!opt) return;

    formData.value.options.push({
        option_id: Number(opt.id),
        option_name: opt.name,
        option_value_id: '',
        quantity: 0,
        subtract: 1,
        price_prefix: '+',
        price: 0,
        available_values: opt.option_values || opt.optionValues || []
    });

    emit('optionAdded', opt);
    selectedOptionIdToAdd.value = "";
};

const removeOptionRow = (index) => {
    if (formData.value.options) {
        formData.value.options.splice(index, 1);
        emit('optionRemoved', index);
    }
};
</script>
