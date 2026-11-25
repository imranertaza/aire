<template>
    <div class="about-story-form">
        <!-- Section Meta Header -->
        <div class="card card-info card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-clock mr-1"></i> Section 1: Our Story Header
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
                            <label class="font-weight-bold">Accordion Title <span class="text-danger">*</span></label>
                            <input v-model="form.title" type="text" class="form-control" placeholder="e.g. Our Journey" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Accordion Subtitle</label>
                            <input v-model="form.subtitle" type="text" class="form-control" placeholder="Brief subtitle..." />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Journey Hero Banner Card -->
        <div class="card card-primary card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-image mr-1"></i> Journey Hero Card
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Hero Card Title <span class="text-danger">*</span></label>
                            <input v-model="form.hero_title" type="text" class="form-control" placeholder="e.g. Our Journey" />
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Hero Description</label>
                            <textarea v-model="form.hero_desc" rows="4" class="form-control" placeholder="Describe the company journey..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">Button Text</label>
                                    <input v-model="form.button_text" type="text" class="form-control form-control-sm" placeholder="e.g. Explore Our History" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">Button Target Link</label>
                                    <input v-model="form.button_link" type="text" class="form-control form-control-sm" placeholder="e.g. #milestones" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <SectionImageUploader
                            v-model="form.hero_image"
                            label="Banner Image"
                            placeholder="themes/default/assets/img/about/mountains.jpg"
                            recommended-size="1200 × 750px"
                            @file-change="(f) => $emit('fileChange', 'hero_image', f)"
                        />
                        <div class="form-group mb-0">
                            <label class="font-weight-bold">Image Badge Overlay Text <small class="text-muted">(Supports line breaks)</small></label>
                            <textarea v-model="form.hero_badge" rows="3" class="form-control" placeholder="CLEANER AIR&#10;BRIGHTER SPACES&#10;A HEALTHIER TOMORROW"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Milestones Timeline Manager -->
        <div class="card card-purple card-outline shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-history mr-1"></i> Historical Milestones Timeline ({{ form.milestones?.length || 0 }})
                </h3>
                <div class="card-tools ml-auto">
                    <button type="button" class="btn btn-sm btn-success" @click="addMilestone">
                        <i class="fas fa-plus mr-1"></i> Add Milestone
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div v-for="(m, index) in form.milestones" :key="'milestone-' + index" class="card border mb-3">
                    <div class="card-header py-2 bg-light d-flex justify-content-between align-items-center">
                        <span class="font-weight-bold text-primary">
                            <i class="fas fa-flag mr-1"></i> Milestone #{{ index + 1 }} &mdash; <strong>{{ m.year || 'Year' }}</strong>: {{ m.title || 'Untitled' }}
                        </span>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" :disabled="index === 0" @click="moveMilestone(index, -1)" title="Move Up">
                                <i class="fas fa-arrow-up"></i>
                            </button>
                            <button type="button" class="btn btn-tool" :disabled="index === form.milestones.length - 1" @click="moveMilestone(index, 1)" title="Move Down">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                            <button type="button" class="btn btn-tool text-danger" :disabled="form.milestones.length <= 1" @click="removeMilestone(index)" title="Remove">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label class="small font-weight-bold">Year / Era <span class="text-danger">*</span></label>
                                    <input v-model="m.year" type="text" class="form-control form-control-sm" placeholder="e.g. 1988 or Today" required />
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group mb-2">
                                    <label class="small font-weight-bold">Milestone Title <span class="text-danger">*</span></label>
                                    <input v-model="m.title" type="text" class="form-control form-control-sm" placeholder="e.g. The Beginning" required />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold">Description <span class="text-danger">*</span></label>
                                    <textarea v-model="m.desc" rows="2" class="form-control form-control-sm" placeholder="Describe the milestone event..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Impact & Statistics -->
        <div class="card card-success card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-chart-line mr-1"></i> Impact Banner & Worldwide Statistics
                </h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Impact Title</label>
                            <input v-model="form.impact_title" type="text" class="form-control" placeholder="e.g. A Healthier World Through Cleaner Air" />
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Impact Description</label>
                            <textarea v-model="form.impact_desc" rows="3" class="form-control" placeholder="Describe global impact..."></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <SectionImageUploader
                            v-model="form.impact_image"
                            label="Impact Image"
                            placeholder="themes/default/assets/img/apartments.jpg"
                            recommended-size="1200 × 750px"
                            @file-change="(f) => $emit('fileChange', 'impact_image', f)"
                        />
                        <div class="form-group">
                            <label class="font-weight-bold">Impact Badge Overlay</label>
                            <textarea v-model="form.impact_badge" rows="2" class="form-control" placeholder="CLEANER AIR&#10;BRIGHTER SPACES&#10;A HEALTHIER TOMORROW"></textarea>
                        </div>
                    </div>
                </div>

                <hr />
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="font-weight-bold mb-0">Impact Stat Cards ({{ form.stats?.length || 0 }})</label>
                    <button type="button" class="btn btn-xs btn-outline-success" @click="addStat">
                        <i class="fas fa-plus mr-1"></i> Add Stat Card
                    </button>
                </div>
                <div class="row">
                    <div v-for="(st, idx) in form.stats" :key="'stat-' + idx" class="col-md-6 mb-3">
                        <div class="card border p-3 h-100 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge badge-success">Stat #{{ idx + 1 }}</span>
                                <button type="button" class="btn btn-xs btn-link text-danger p-0" :disabled="form.stats.length <= 1" @click="removeStat(idx)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label class="small font-weight-bold">Icon Class</label>
                                    <input v-model="st.icon" type="text" class="form-control form-control-sm font-monospace" placeholder="bi bi-globe" />
                                </div>
                                <div class="col-8">
                                    <label class="small font-weight-bold">Stat Title</label>
                                    <input v-model="st.title" type="text" class="form-control form-control-sm" placeholder="e.g. 100+ Countries" />
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="small font-weight-bold">Description</label>
                                    <textarea v-model="st.desc" rows="2" class="form-control form-control-sm" placeholder="Stat description..."></textarea>
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
                            <input v-model="form.quote" type="text" class="form-control" placeholder="e.g. Real change happens when cleaner air becomes a right for everyone..." />
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

const addMilestone = () => {
    if (!props.form.milestones) props.form.milestones = [];
    props.form.milestones.push({
        year: "",
        title: "",
        desc: "",
    });
};

const removeMilestone = (index) => {
    if (props.form.milestones && props.form.milestones.length > 1) {
        props.form.milestones.splice(index, 1);
    }
};

const moveMilestone = (index, delta) => {
    if (!props.form.milestones) return;
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= props.form.milestones.length) return;
    const item = props.form.milestones.splice(index, 1)[0];
    props.form.milestones.splice(newIndex, 0, item);
};

const addStat = () => {
    if (!props.form.stats) props.form.stats = [];
    props.form.stats.push({
        icon: "bi bi-graph-up",
        title: "",
        desc: "",
    });
};

const removeStat = (index) => {
    if (props.form.stats && props.form.stats.length > 1) {
        props.form.stats.splice(index, 1);
    }
};
</script>
