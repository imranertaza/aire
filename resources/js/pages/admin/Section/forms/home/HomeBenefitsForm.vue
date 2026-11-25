<template>
    <div class="home-benefits-form">
        <div class="card card-primary card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-layer-group mr-1 text-primary"></i> Benefits Parallax Section Settings
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Section Badge / Tagline <span class="text-danger">*</span></label>
                            <input v-model="form.badge" type="text" class="form-control"
                                placeholder="e.g. BENEFITS" required />
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Section Title <span class="text-danger">*</span></label>
                            <input v-model="form.title" type="text" class="form-control"
                                placeholder="e.g. Pure Air, Healthy Living" required />
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Section Subtitle <span class="text-danger">*</span></label>
                            <textarea v-model="form.subtitle" class="form-control" rows="3"
                                placeholder="e.g. Get authentic products, fast delivery, and trusted local service — only from us."
                                required></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Parallax Background Banner Image <span class="text-danger">*</span></label>
                            <Vue3Dropzone :model-value="fileUpload" @update:model-value="$emit('update:fileUpload', $event)"
                                :previews="previews" @update:previews="$emit('update:previews', $event)"
                                mode="edit" :allowSelectOnPreview="true" :maxFiles="1" />
                            <div class="mt-2 p-2 bg-light border rounded small">
                                <i class="fas fa-info-circle text-primary mr-1"></i>
                                Recommended: <strong>1920 × 800px</strong> or <strong>1400 × 700px</strong> (Panoramic landscape banner)
                            </div>
                            <div v-if="previews && previews.length && previews[0]" class="mt-2">
                                <img :src="previews[0]" class="img-thumbnail" style="max-height: 100px;" alt="Banner preview" />
                            </div>
                            <div v-else-if="form.image" class="mt-2 d-flex align-items-center">
                                <img :src="getImageUrl(form.image)" class="img-thumbnail mr-2" style="max-height: 60px;" alt="Current image" />
                                <small class="text-muted font-monospace">{{ form.image }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Benefit Cards Repeater -->
                <h4 class="mt-4 mb-3 font-weight-bold text-dark border-bottom pb-2">
                    <i class="fas fa-th-large mr-1 text-primary"></i> Benefit Cards ({{ form.cards?.length || 0 }})
                </h4>

                <div class="row">
                    <div v-for="(card, index) in form.cards" :key="index" class="col-md-4 mb-3">
                        <div class="card h-100 shadow-sm border">
                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold text-primary small">Card #{{ index + 1 }}</span>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool btn-xs" :disabled="index === 0"
                                        @click="moveCard(index, -1)" title="Move Left / Up">
                                        <i class="fas fa-arrow-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool btn-xs"
                                        :disabled="index === form.cards.length - 1"
                                        @click="moveCard(index, 1)" title="Move Right / Down">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body py-2">
                                <div class="form-group mb-2">
                                    <label class="small font-weight-bold">Title <span class="text-danger">*</span></label>
                                    <input v-model="card.title" type="text" class="form-control form-control-sm"
                                        placeholder="e.g. Authentic Products" required />
                                </div>
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">Description <span class="text-danger">*</span></label>
                                    <textarea v-model="card.description" rows="2" class="form-control form-control-sm"
                                        placeholder="Card description..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between align-items-center">
                <span class="text-muted small">All changes take effect immediately on the homepage.</span>
                <div>
                    <router-link :to="{ name: 'Section' }" class="btn btn-secondary mr-2">
                        Cancel
                    </router-link>
                    <button type="button" @click="$emit('save')" class="btn btn-primary" :disabled="saving">
                        <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save & Update Benefits' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import { getImageUrl } from '@/layouts/helpers/helpers';

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    saving: {
        type: Boolean,
        default: false,
    },
    fileUpload: {
        type: Array,
        default: () => [],
    },
    previews: {
        type: Array,
        default: () => [],
    },
});

defineEmits(['save', 'update:fileUpload', 'update:previews']);

const moveCard = (index, delta) => {
    if (!props.form.cards) return;
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= props.form.cards.length) return;
    const item = props.form.cards.splice(index, 1)[0];
    props.form.cards.splice(newIndex, 0, item);
};
</script>
