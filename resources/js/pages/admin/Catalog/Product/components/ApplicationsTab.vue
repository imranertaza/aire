<template>
    <div class="tab-pane fade" id="custom-tabs-applications" role="tabpanel"
        aria-labelledby="tab-applications">
        <div class="card card-outline card-info mb-3">
            <div class="card-header py-2">
                <h6 class="card-title font-weight-bold mb-0">Applications Section Header</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Section Title</label>
                        <input type="text" class="form-control" v-model="formData.applications_title"
                            placeholder="e.g. Industrial Excellence, Personal Comfort" />
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Section Description</label>
                        <textarea class="form-control" rows="2" v-model="formData.applications_description"
                            placeholder="Engineered to exceed safety standards in the most demanding environments..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Application Cards Grid</h5>
            <button type="button" class="btn btn-primary btn-sm" @click="addApplication">
                <i class="fas fa-plus mr-1"></i> Add Application
            </button>
        </div>
        <div v-if="!formData.applications || formData.applications.length === 0"
            class="alert alert-light border text-center py-4">
            <i class="fas fa-layer-group fa-2x text-muted mb-2"></i>
            <p class="text-muted mb-0">No application environments added yet. Click "Add Application" above to configure use-case cards.</p>
        </div>
        <div v-else class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 4%;">#</th>
                        <th style="width: 18%;">Title <span class="text-danger">*</span></th>
                        <th style="width: 20%;">Description</th>
                        <th style="width: 12%;">Badge / Tag</th>
                        <th style="width: 22%; min-width: 170px;">Background Image</th>
                        <th style="width: 12%;">Layout Width</th>
                        <th style="width: 7%;">Sort Order</th>
                        <th style="width: 5%;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(appItem, index) in formData.applications" :key="index">
                        <td class="text-center font-weight-bold">{{ index + 1 }}</td>
                        <td>
                            <input type="text" class="form-control" v-model="appItem.title"
                                placeholder="e.g. R&D Laboratories" />
                        </td>
                        <td>
                            <textarea class="form-control" rows="2"
                                v-model="appItem.description"
                                placeholder="Application description..."></textarea>
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="appItem.badge"
                                placeholder="e.g. OPTIMIZED FOR DAILY COMMUTE" />
                        </td>
                        <td>
                            <div style="min-width: 150px;">
                                <Vue3Dropzone 
                                    v-model="appItem.bg_image_file"
                                    v-model:previews="appItem.bg_image_previews"
                                    :mode="mode" 
                                    :allowSelectOnPreview="true"
                                    @previewRemoved="() => onAppImageRemoved(appItem)" />
                                <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Recommended: 800 × 400px or 1200 × 500px</small>
                            </div>
                        </td>
                        <td>
                            <select class="form-control" v-model="appItem.grid_width">
                                <option value="col-lg-8">2/3 Width (col-lg-8)</option>
                                <option value="col-lg-4">1/3 Width (col-lg-4)</option>
                                <option value="col-12">Full Width (col-12)</option>
                                <option value="col-lg-6">Half Width (col-lg-6)</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control"
                                v-model.number="appItem.sort_order" />
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm"
                                @click="removeApplication(index)"
                                title="Remove Application">
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
    },
    mode: {
        type: String,
        default: undefined
    }
});

const emit = defineEmits(['appImageRemoved', 'addApplication', 'removeApplication']);

const formData = computed(() => props.form || props.modelValue || {});

const addApplication = () => {
    if (!formData.value.applications) formData.value.applications = [];
    const len = formData.value.applications.length;
    formData.value.applications.push({
        title: '',
        description: '',
        badge: '',
        bg_image: '',
        image: '',
        bg_image_file: null,
        bg_image_previews: [],
        grid_width: len === 0 ? 'col-lg-8' : (len === 1 ? 'col-lg-4' : 'col-12'),
        sort_order: len
    });
    emit('addApplication');
};

const removeApplication = (index) => {
    if (formData.value.applications) {
        formData.value.applications.splice(index, 1);
        emit('removeApplication', index);
    }
};

const onAppImageRemoved = (appItem) => {
    appItem.bg_image = '';
    appItem.image = '';
    emit('appImageRemoved', appItem);
};
</script>
