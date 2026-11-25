<template>
    <div class="home-faq-form">
        <div class="card card-primary card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-question-circle mr-1 text-primary"></i> FAQ Section Settings
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Section Badge</label>
                            <input v-model="form.badge" type="text" class="form-control"
                                placeholder="e.g. SUPPORT" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Section Title <span class="text-danger">*</span></label>
                            <input v-model="form.title" type="text" class="form-control"
                                placeholder="e.g. Frequently Asked Questions" required />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Subtitle / Supporting Text</label>
                            <input v-model="form.subtitle" type="text" class="form-control"
                                placeholder="Optional supporting tagline" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Items Repeater -->
        <div class="card card-info card-outline shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-list-ol mr-1 text-info"></i> Questions & Answers ({{ form.items?.length || 0 }})
                </h3>
                <div class="card-tools ml-auto">
                    <button type="button" class="btn btn-sm btn-success" @click="addFaqItem">
                        <i class="fas fa-plus mr-1"></i> Add New Question
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div v-if="!form.items || form.items.length === 0" class="alert alert-light text-center py-4">
                    <i class="fas fa-question-circle fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-2">No FAQ items defined yet.</p>
                    <button type="button" class="btn btn-sm btn-primary" @click="addFaqItem">
                        <i class="fas fa-plus mr-1"></i> Add Your First FAQ
                    </button>
                </div>

                <div v-for="(item, index) in form.items" :key="'faq-' + index"
                    class="card card-light mb-3 border">
                    <div class="card-header d-flex justify-content-between align-items-center py-2 bg-light">
                        <div class="font-weight-bold">
                            <span class="badge badge-secondary mr-2">Q{{ index + 1 }}</span>
                            {{ item.question ? (item.question.length > 70 ? item.question.substring(0, 70) + '...' : item.question) : 'Untitled Question' }}
                        </div>
                        <div class="card-tools ml-auto">
                            <button type="button" class="btn btn-tool btn-xs" :disabled="index === 0"
                                @click="moveFaqItem(index, -1)" title="Move Up">
                                <i class="fas fa-arrow-up"></i>
                            </button>
                            <button type="button" class="btn btn-tool btn-xs"
                                :disabled="index === form.items.length - 1"
                                @click="moveFaqItem(index, 1)" title="Move Down">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                            <button type="button" class="btn btn-tool btn-xs text-danger"
                                :disabled="form.items.length <= 1" @click="removeFaqItem(index)"
                                title="Remove Question">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">Question <span class="text-danger">*</span></label>
                            <input v-model="item.question" type="text" class="form-control"
                                placeholder="e.g. How long do the filters last?" required />
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold">Answer <span class="text-danger">*</span></label>
                            <textarea v-model="item.answer" class="form-control" rows="3"
                                placeholder="Enter the detailed answer..." required></textarea>
                        </div>
                    </div>
                </div>

                <div v-if="form.items && form.items.length > 0" class="text-center mt-3">
                    <button type="button" class="btn btn-outline-success" @click="addFaqItem">
                        <i class="fas fa-plus mr-1"></i> Add Another Question
                    </button>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end align-items-center">
                <router-link :to="{ name: 'Section' }" class="btn btn-secondary mr-2">
                    Cancel
                </router-link>
                <button type="button" @click="$emit('save')" class="btn btn-primary" :disabled="saving">
                    <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save FAQ Section' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    saving: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['save']);

const addFaqItem = () => {
    if (!props.form.items) props.form.items = [];
    props.form.items.push({
        question: "",
        answer: "",
    });
};

const removeFaqItem = (index) => {
    if (props.form.items && props.form.items.length > 1) {
        props.form.items.splice(index, 1);
    }
};

const moveFaqItem = (index, delta) => {
    if (!props.form.items) return;
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= props.form.items.length) return;
    const item = props.form.items.splice(index, 1)[0];
    props.form.items.splice(newIndex, 0, item);
};
</script>
