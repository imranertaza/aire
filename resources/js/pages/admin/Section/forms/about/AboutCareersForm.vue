<template>
    <div class="about-careers-form">
        <div class="card card-purple card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-briefcase mr-1"></i> Careers Section Settings
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
                            <label class="font-weight-bold">Accordion Title <span class="text-danger">*</span></label>
                            <input v-model="form.title" type="text" class="form-control" placeholder="e.g. Careers" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Accordion Subtitle</label>
                            <input v-model="form.subtitle" type="text" class="form-control" placeholder="e.g. Join our team and help shape a healthier world." />
                        </div>
                    </div>
                </div>

                <hr />
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Card Title <span class="text-danger">*</span></label>
                            <input v-model="form.card_title" type="text" class="form-control" placeholder="e.g. Build the Future of Clean Air" required />
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Card Description <span class="text-danger">*</span></label>
                            <textarea v-model="form.card_desc" rows="3" class="form-control" placeholder="Describe the career opportunity..." required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold">Button Text</label>
                                    <input v-model="form.button_text" type="text" class="form-control" placeholder="e.g. View Open Positions" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold">Button Target Link</label>
                                    <input v-model="form.button_link" type="text" class="form-control" placeholder="e.g. /contact-us" />
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
defineProps({
    form: {
        type: Object,
        required: true,
    },
});
</script>
