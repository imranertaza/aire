<template>
    <div class="home-trust-badges-form">
        <div class="card card-info card-outline shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-shield-alt mr-1 text-info"></i> Trust Badges ({{ form.badges?.length || 0 }})
                </h3>
                <div class="card-tools ml-auto">
                    <button type="button" class="btn btn-sm btn-success" @click="addBadge">
                        <i class="fas fa-plus mr-1"></i> Add New Badge
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3" v-for="(badge, index) in form.badges" :key="index">
                        <div class="card card-outline card-info h-100 shadow-none border">
                            <div class="card-header py-2 bg-light d-flex justify-content-between align-items-center">
                                <h3 class="card-title font-weight-bold" style="font-size: 0.95rem;">
                                    <i :class="badge.icon" class="mr-1 text-info"></i>
                                    <span class="ml-1">{{ badge.title || 'Untitled Badge' }}</span>
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" :disabled="index === 0"
                                        @click="moveBadge(index, -1)" title="Move Up">
                                        <i class="fas fa-arrow-up"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool"
                                        :disabled="index === form.badges.length - 1"
                                        @click="moveBadge(index, 1)" title="Move Down">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool text-danger"
                                        :disabled="form.badges.length <= 1" @click="removeBadge(index)"
                                        title="Remove Badge">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body py-3">
                                <div class="form-group mb-2">
                                    <label class="small font-weight-bold">Badge Title <span class="text-danger">*</span></label>
                                    <input v-model="badge.title" type="text"
                                        class="form-control form-control-sm" placeholder="e.g. SECURE PAYMENTS"
                                        required />
                                </div>

                                <div class="form-group mb-2">
                                    <label class="small font-weight-bold">Icon Class <span class="text-danger">*</span> <small
                                            class="text-muted">(Bootstrap Icons)</small></label>
                                    <input v-model="badge.icon" type="text" class="form-control form-control-sm font-monospace"
                                        placeholder="e.g. bi-shield-check" required />
                                    <small class="d-block mt-1">
                                        <a href="https://icons.getbootstrap.com/" target="_blank" rel="noopener">Browse Bootstrap Icons <i class="fas fa-external-link-alt ml-1" style="font-size: 10px;"></i></a>
                                    </small>
                                </div>

                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">Description <span class="text-danger">*</span></label>
                                    <textarea v-model="badge.description" rows="2"
                                        class="form-control form-control-sm"
                                        placeholder="Write badge description here..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-success" @click="addBadge">
                    <i class="fas fa-plus mr-1"></i> Add Another Badge
                </button>
                <div>
                    <router-link :to="{ name: 'Section' }" class="btn btn-secondary mr-2">
                        Cancel
                    </router-link>
                    <button type="button" @click="$emit('save')" class="btn btn-primary" :disabled="saving">
                        <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save & Update Badges' }}
                    </button>
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
    saving: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['save']);

const addBadge = () => {
    if (!props.form.badges) props.form.badges = [];
    props.form.badges.push({
        icon: "bi-shield-check",
        title: "New Badge",
        description: "Describe this badge.",
    });
};

const removeBadge = (index) => {
    if (props.form.badges && props.form.badges.length > 1) {
        props.form.badges.splice(index, 1);
    }
};

const moveBadge = (index, delta) => {
    if (!props.form.badges) return;
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= props.form.badges.length) return;
    const item = props.form.badges.splice(index, 1)[0];
    props.form.badges.splice(newIndex, 0, item);
};
</script>
