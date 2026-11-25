<template>
    <div class="about-features-form">
        <div class="card card-primary card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-layer-group mr-1"></i> {{ form.title || form.key }} Settings
                </h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="font-weight-bold">Section #</label>
                            <input v-model="form.number" type="number" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Title <span class="text-danger">*</span></label>
                            <input v-model="form.title" type="text" class="form-control" placeholder="Section Title" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Subtitle</label>
                            <input v-model="form.subtitle" type="text" class="form-control" placeholder="Section Subtitle" />
                        </div>
                    </div>
                </div>

                <hr />
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-weight-bold text-dark mb-0"><i class="fas fa-th-list text-primary mr-1"></i> Feature Cards ({{ form.items?.length || 0 }})</h5>
                    <button type="button" class="btn btn-sm btn-success" @click="addGenericItem">
                        <i class="fas fa-plus mr-1"></i> Add Card
                    </button>
                </div>

                <div class="row">
                    <div v-for="(item, idx) in form.items" :key="'item-' + idx" class="col-md-6 mb-3">
                        <div class="card border p-3 h-100 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge badge-primary">Card #{{ idx + 1 }}</span>
                                <button type="button" class="btn btn-xs btn-link text-danger p-0" :disabled="form.items.length <= 1" @click="removeGenericItem(idx)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="small font-weight-bold">Icon Class</label>
                                    <input v-model="item.icon" type="text" class="form-control form-control-sm font-monospace" placeholder="bi bi-award" />
                                </div>
                                <div class="col-8">
                                    <label class="small font-weight-bold">Card Title <span class="text-danger">*</span></label>
                                    <input v-model="item.title" type="text" class="form-control form-control-sm" placeholder="e.g. ISO 9001 & 14001" required />
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="small font-weight-bold">Description <span class="text-danger">*</span></label>
                                    <textarea v-model="item.desc" rows="2" class="form-control form-control-sm" placeholder="Card description..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
});

const addGenericItem = () => {
    if (!props.form.items) props.form.items = [];
    props.form.items.push({
        icon: "bi bi-star",
        title: "",
        desc: "",
    });
};

const removeGenericItem = (index) => {
    if (props.form.items && props.form.items.length > 1) {
        props.form.items.splice(index, 1);
    }
};
</script>
