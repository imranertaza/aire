<template>
    <div class="about-leadership-form">
        <div class="card card-teal card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-users mr-1"></i> Section 3: Leadership Team Settings
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
                            <input v-model="form.title" type="text" class="form-control" placeholder="e.g. Leadership" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Subtitle</label>
                            <input v-model="form.subtitle" type="text" class="form-control" placeholder="e.g. Meet the people driving innovation..." />
                        </div>
                    </div>
                </div>

                <hr />
                <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-id-badge text-teal mr-1"></i> Leadership Banner Showcase</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Banner Badge</label>
                            <input v-model="form.banner_badge" type="text" class="form-control" placeholder="e.g. OUR LEADERSHIP" />
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Banner Title</label>
                            <input v-model="form.banner_title" type="text" class="form-control" placeholder="e.g. People with Purpose" />
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Banner Description</label>
                            <textarea v-model="form.banner_desc" rows="3" class="form-control" placeholder="Describe the leadership commitment..."></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <SectionImageUploader
                            v-model="form.banner_image"
                            label="Banner Image"
                            placeholder="themes/default/assets/img/about/leadership.jpg"
                            recommended-size="1200 × 750px"
                            @file-change="(f) => $emit('fileChange', 'banner_image', f)"
                        />
                        <div class="form-group mb-0">
                            <label class="font-weight-bold">Banner Badge Overlay</label>
                            <textarea v-model="form.banner_badge_text" rows="2" class="form-control" placeholder="CLEANER AIR&#10;BRIGHTER SPACES&#10;A HEALTHIER TOMORROW"></textarea>
                        </div>
                    </div>
                </div>

                <hr />
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Team Grid Heading</label>
                            <input v-model="form.team_heading" type="text" class="form-control" placeholder="e.g. Meet Our Leadership Team" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Team Grid Subtitle</label>
                            <input v-model="form.team_subheading" type="text" class="form-control" placeholder="A diverse group of visionaries..." />
                        </div>
                    </div>
                </div>

                <hr />
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-weight-bold text-dark mb-0"><i class="fas fa-user-tie text-primary mr-1"></i> Executive Members ({{ form.members?.length || 0 }})</h5>
                    <button type="button" class="btn btn-sm btn-success" @click="addMember">
                        <i class="fas fa-plus mr-1"></i> Add Member
                    </button>
                </div>

                <div class="row">
                    <div v-for="(mem, idx) in form.members" :key="'member-' + idx" class="col-md-6 mb-3">
                        <div class="card border shadow-none h-100">
                            <div class="card-header py-2 bg-light d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold text-dark">
                                    <i class="fas fa-user mr-1 text-teal"></i> {{ mem.name || 'Member Name' }} &mdash; <small class="text-muted">{{ mem.role || 'Role' }}</small>
                                </span>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" :disabled="idx === 0" @click="moveMember(idx, -1)" title="Move Up">
                                        <i class="fas fa-arrow-up"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" :disabled="idx === form.members.length - 1" @click="moveMember(idx, 1)" title="Move Down">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool text-danger" :disabled="form.members.length <= 1" @click="removeMember(idx)" title="Remove">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body py-2">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mb-2">
                                            <label class="small font-weight-bold">Full Name <span class="text-danger">*</span></label>
                                            <input v-model="mem.name" type="text" class="form-control form-control-sm" placeholder="e.g. Dr. James Liu" required />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-2">
                                            <label class="small font-weight-bold">Designation / Role <span class="text-danger">*</span></label>
                                            <input v-model="mem.role" type="text" class="form-control form-control-sm" placeholder="e.g. Chief Executive Officer" required />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-2">
                                            <label class="small font-weight-bold">Short Bio <span class="text-danger">*</span></label>
                                            <textarea v-model="mem.bio" rows="2" class="form-control form-control-sm" placeholder="Short biographical sentence..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-0">
                                            <label class="small font-weight-bold">Photo URL / Path <small class="text-muted">(Leave blank for icon placeholder)</small></label>
                                            <div class="d-flex align-items-center">
                                                <input v-model="mem.image" type="text" class="form-control form-control-sm font-monospace mr-2" placeholder="themes/default/assets/img/team/member1.jpg" />
                                                <div v-if="mem.image" class="border rounded p-1 bg-light" style="width: 36px; height: 36px; overflow: hidden; flex-shrink: 0;">
                                                    <img :src="getImageUrl(mem.image)" alt="Member" style="width: 100%; height: 100%; object-fit: cover;" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                            <input v-model="form.quote" type="text" class="form-control" placeholder="e.g. Great things happen when passionate people work together..." />
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
import { getImageUrl } from '@/layouts/helpers/helpers';

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
});

defineEmits(['fileChange']);

const addMember = () => {
    if (!props.form.members) props.form.members = [];
    props.form.members.push({
        name: "",
        role: "",
        bio: "",
        image: "",
    });
};

const removeMember = (index) => {
    if (props.form.members && props.form.members.length > 1) {
        props.form.members.splice(index, 1);
    }
};

const moveMember = (index, delta) => {
    if (!props.form.members) return;
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= props.form.members.length) return;
    const item = props.form.members.splice(index, 1)[0];
    props.form.members.splice(newIndex, 0, item);
};
</script>
