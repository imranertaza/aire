<template>
    <div class="card card-primary card-outline shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                <i class="fas fa-heading mr-1"></i> About Page Top Header
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Subheading Badge <span class="text-danger">*</span></label>
                        <input v-model="form.badge" type="text" class="form-control" placeholder="e.g. OUR STORY" required />
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="font-weight-bold">Main Heading Title <span class="text-danger">*</span></label>
                        <input v-model="form.title" type="text" class="form-control" placeholder="e.g. A Cleaner Tomorrow Starts Here" required />
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Lead Paragraph / Subtitle <span class="text-danger">*</span></label>
                        <textarea v-model="form.subtitle" rows="3" class="form-control" placeholder="Enter introductory lead text..." required></textarea>
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
