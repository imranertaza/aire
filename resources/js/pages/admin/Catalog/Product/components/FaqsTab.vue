<template>
    <div class="tab-pane fade" id="custom-tabs-faqs" role="tabpanel"
        aria-labelledby="tab-faqs">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Product Frequently Asked Questions</h5>
            <button type="button" class="btn btn-primary btn-sm" @click="addFaq">
                <i class="fas fa-plus mr-1"></i> Add FAQ
            </button>
        </div>
        <div v-if="!formData.faqs || formData.faqs.length === 0" class="alert alert-light border text-center py-4">
            <i class="fas fa-question-circle fa-2x text-muted mb-2"></i>
            <p class="text-muted mb-0">No FAQs added for this product yet. Click "Add FAQ" above to add one.</p>
        </div>
        <div v-else class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 35%;">Question <span class="text-danger">*</span></th>
                        <th style="width: 45%;">Answer <span class="text-danger">*</span></th>
                        <th style="width: 10%;">Sort Order</th>
                        <th style="width: 5%;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(faq, index) in formData.faqs" :key="index">
                        <td class="text-center font-weight-bold">{{ index + 1 }}</td>
                        <td>
                            <input type="text" class="form-control" v-model="faq.question" placeholder="e.g. How long do filters last?" />
                        </td>
                        <td>
                            <textarea class="form-control" rows="2" v-model="faq.answer" placeholder="Enter detailed answer..."></textarea>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control" v-model.number="faq.sort_order" />
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm" @click="removeFaq(index)" title="Remove FAQ">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
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
    }
});

const emit = defineEmits(['faqAdded', 'faqRemoved']);

const formData = computed(() => props.form || props.modelValue || {});

const addFaq = () => {
    if (!formData.value.faqs) {
        formData.value.faqs = [];
    }
    const newFaq = {
        question: '',
        answer: '',
        sort_order: formData.value.faqs.length
    };
    formData.value.faqs.push(newFaq);
    emit('faqAdded', newFaq);
};

const removeFaq = (index) => {
    if (formData.value.faqs) {
        formData.value.faqs.splice(index, 1);
        emit('faqRemoved', index);
    }
};
</script>
