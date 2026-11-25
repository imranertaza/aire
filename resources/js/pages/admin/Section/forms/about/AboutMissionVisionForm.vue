<template>
    <div class="about-mission-vision-form">
        <div class="card card-success card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-bullseye mr-1"></i> Section 2: Mission & Vision Settings
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="font-weight-bold">Section #</label>
                            <input v-model="form.number" type="number" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Title <span class="text-danger">*</span></label>
                            <input v-model="form.title" type="text" class="form-control" placeholder="e.g. Mission & Vision" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Subtitle</label>
                            <input v-model="form.subtitle" type="text" class="form-control" placeholder="e.g. Our purpose, values and commitment..." />
                        </div>
                    </div>
                </div>

                <hr />
                <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-compass text-primary mr-1"></i> Purpose Banner</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Purpose Title</label>
                            <input v-model="form.purpose_title" type="text" class="form-control" placeholder="e.g. Our Purpose" />
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Purpose Description</label>
                            <textarea v-model="form.purpose_desc" rows="3" class="form-control" placeholder="Describe the core purpose..."></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <SectionImageUploader
                            v-model="form.purpose_image"
                            label="Purpose Image"
                            placeholder="themes/default/assets/img/about/earth_purpose.jpg"
                            recommended-size="1200 × 750px"
                            @file-change="(f) => $emit('fileChange', 'purpose_image', f)"
                        />
                        <div class="form-group">
                            <label class="font-weight-bold">Purpose Badge Overlay</label>
                            <textarea v-model="form.purpose_badge" rows="2" class="form-control" placeholder="CLEANER AIR&#10;BRIGHTER SPACES&#10;A HEALTHIER TOMORROW"></textarea>
                        </div>
                    </div>
                </div>

                <hr />
                <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-columns text-info mr-1"></i> Mission & Vision Pillars</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="card p-3 border">
                            <label class="font-weight-bold text-primary">Mission Title</label>
                            <input v-model="form.mission_title" type="text" class="form-control mb-2" placeholder="e.g. Our Mission" />
                            <label class="font-weight-bold">Mission Statement</label>
                            <textarea v-model="form.mission_desc" rows="3" class="form-control" placeholder="Mission details..."></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3 border">
                            <label class="font-weight-bold text-info">Vision Title</label>
                            <input v-model="form.vision_title" type="text" class="form-control mb-2" placeholder="e.g. Our Vision" />
                            <label class="font-weight-bold">Vision Statement</label>
                            <textarea v-model="form.vision_desc" rows="3" class="form-control" placeholder="Vision details..."></textarea>
                        </div>
                    </div>
                </div>

                <hr />
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="font-weight-bold text-dark mb-0"><i class="fas fa-heart text-danger mr-1"></i> Core Values ({{ form.values?.length || 0 }})</h5>
                    <button type="button" class="btn btn-xs btn-outline-success" @click="addValue">
                        <i class="fas fa-plus mr-1"></i> Add Core Value
                    </button>
                </div>
                <div class="row">
                    <div v-for="(val, idx) in form.values" :key="'val-' + idx" class="col-md-6 mb-3">
                        <div class="card border p-3 h-100 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge badge-success">Value #{{ idx + 1 }}</span>
                                <button type="button" class="btn btn-xs btn-link text-danger p-0" :disabled="form.values.length <= 1" @click="removeValue(idx)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="small font-weight-bold">Icon Class</label>
                                    <input v-model="val.icon" type="text" class="form-control form-control-sm font-monospace" placeholder="bi bi-heart" />
                                </div>
                                <div class="col-8">
                                    <label class="small font-weight-bold">Value Title</label>
                                    <input v-model="val.title" type="text" class="form-control form-control-sm" placeholder="e.g. People First" />
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="small font-weight-bold">Description</label>
                                    <textarea v-model="val.desc" rows="2" class="form-control form-control-sm" placeholder="Value explanation..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr />
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-0">
                            <label class="font-weight-bold">Section Quote</label>
                            <input v-model="form.quote" type="text" class="form-control" placeholder="e.g. Clean air empowers people, strengthens communities..." />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label class="font-weight-bold">Quote Brand Subtext</label>
                            <input v-model="form.quote_brand" type="text" class="form-control" placeholder="CLEANER AIR | BRIGHTER SPACES" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import SectionImageUploader from '@/pages/admin/Section/components/SectionImageUploader.vue';

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
});

defineEmits(['fileChange']);

const addValue = () => {
    if (!props.form.values) props.form.values = [];
    props.form.values.push({
        icon: "bi bi-heart",
        title: "",
        desc: "",
    });
};

const removeValue = (index) => {
    if (props.form.values && props.form.values.length > 1) {
        props.form.values.splice(index, 1);
    }
};
</script>
