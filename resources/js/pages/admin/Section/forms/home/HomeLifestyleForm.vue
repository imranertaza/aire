<template>
    <div class="home-lifestyle-form">
        <div class="card card-primary card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-couch mr-1"></i> Lifestyle Showcase Section Settings
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Section Badge / Tagline <span class="text-danger">*</span></label>
                            <input v-model="form.badge" type="text" class="form-control"
                                placeholder="e.g. LIFESTYLE" required />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold">Section Title <span class="text-danger">*</span></label>
                            <input v-model="form.title" type="text" class="form-control"
                                placeholder="e.g. Seamless Living, Cleaner Air" required />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Section Subtitle <span class="text-danger">*</span></label>
                            <textarea v-model="form.subtitle" class="form-control" rows="2"
                                placeholder="Write section subtitle here..." required></textarea>
                        </div>
                    </div>
                </div>

                <!-- Lifestyle Items Repeater -->
                <h4 class="mt-4 mb-3 font-weight-bold text-dark border-bottom pb-2">
                    <i class="fas fa-th-list mr-1 text-primary"></i> Lifestyle Showcase Items ({{ form.items?.length || 0 }})
                </h4>

                <div v-for="(item, index) in form.items" :key="index" class="card mb-3 border shadow-sm">
                    <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                        <span class="font-weight-bold text-dark">
                            <i class="fas fa-layer-group text-primary mr-1"></i> Item #{{ index + 1 }}
                            <small class="badge badge-secondary ml-2 font-weight-normal">
                                {{ index % 2 === 0 ? 'Layout: Text Left, Image Right' : 'Layout: Image Left, Text Right' }}
                            </small>
                        </span>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool btn-xs" :disabled="index === 0"
                                @click="moveLifestyleItem(index, -1)" title="Move Up">
                                <i class="fas fa-arrow-up"></i>
                            </button>
                            <button type="button" class="btn btn-tool btn-xs"
                                :disabled="index === form.items.length - 1"
                                @click="moveLifestyleItem(index, 1)" title="Move Down">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                            <button type="button" class="btn btn-tool btn-xs text-danger"
                                :disabled="form.items.length <= 1" @click="removeLifestyleItem(index)"
                                title="Remove Item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label class="small font-weight-bold">Item Title <span class="text-danger">*</span></label>
                                    <input v-model="item.title" type="text" class="form-control"
                                        placeholder="e.g. Bedroom Serenity" required />
                                </div>
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">Item Description <span class="text-danger">*</span></label>
                                    <textarea v-model="item.description" rows="3" class="form-control"
                                        placeholder="Write description..." required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">Item Image <span class="text-danger">*</span></label>
                                    <Vue3Dropzone v-model="item.dropzoneFile" v-model:previews="item.previews"
                                        mode="edit" :allowSelectOnPreview="true" :maxFiles="1" />
                                    <div class="mt-1 small text-muted">
                                        Recommended: <strong>856 × 385px</strong> or <strong>1200 × 540px</strong> (Wide Landscape ~2.2:1)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-outline-success mt-2" @click="addLifestyleItem">
                    <i class="fas fa-plus mr-1"></i> Add Another Lifestyle Item
                </button>
            </div>

            <div class="card-footer d-flex justify-content-between align-items-center">
                <span class="text-muted small">Items automatically alternate image and text alignment on the homepage.</span>
                <div>
                    <router-link :to="{ name: 'Section' }" class="btn btn-secondary mr-2">
                        Cancel
                    </router-link>
                    <button type="button" @click="$emit('save')" class="btn btn-primary" :disabled="saving">
                        <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save & Update Lifestyle' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';
import '@jaxtheprime/vue3-dropzone/dist/style.css';

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

const addLifestyleItem = () => {
    if (!props.form.items) props.form.items = [];
    props.form.items.push({
        title: "New Lifestyle Space",
        description: "Describe this space...",
        image: "",
        dropzoneFile: null,
        previews: []
    });
};

const removeLifestyleItem = (index) => {
    if (props.form.items && props.form.items.length > 1) {
        props.form.items.splice(index, 1);
    }
};

const moveLifestyleItem = (index, delta) => {
    if (!props.form.items) return;
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= props.form.items.length) return;
    const item = props.form.items.splice(index, 1)[0];
    props.form.items.splice(newIndex, 0, item);
};
</script>
