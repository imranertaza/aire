<template>
    <div class="tab-pane fade" id="custom-tabs-attributes" role="tabpanel"
        aria-labelledby="tab-attributes">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th>Attribute Group</th>
                        <th>Attribute Name</th>
                        <th>Details / Text</th>
                        <th>Sort Order</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(attr, index) in formData.attributes" :key="index">
                        <td>
                            <select class="form-control" v-model="attr.attribute_group_id"
                                required>
                                <option value="">-- Select Group --</option>
                                <option v-for="g in attributeGroups" :key="g.id"
                                    :value="g.id">{{ g.name }}</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="attr.name"
                                required />
                        </td>
                        <td>
                            <textarea class="form-control" v-model="attr.details"
                                rows="2"></textarea>
                        </td>
                        <td>
                            <input min="0" type="number" class="form-control"
                                v-model="attr.sort_order" />
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger"
                                @click="removeAttributeRow(index)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                @click="addAttributeRow">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
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
    },
    attributeGroups: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['attributeAdded', 'attributeRemoved']);

const formData = computed(() => props.form || props.modelValue || {});

const addAttributeRow = () => {
    if (!formData.value.attributes) {
        formData.value.attributes = [];
    }

    const newAttr = {
        attribute_group_id: '',
        name: '',
        details: '',
        sort_order: 0
    };

    formData.value.attributes.push(newAttr);
    emit('attributeAdded', newAttr);
};

const removeAttributeRow = (index) => {
    if (formData.value.attributes) {
        formData.value.attributes.splice(index, 1);
        emit('attributeRemoved', index);
    }
};
</script>
