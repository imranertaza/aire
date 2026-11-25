<template>
    <div class="about-news-form">
        <div class="card card-danger card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-newspaper mr-1"></i> News & Media Section Settings
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
                            <input v-model="form.title" type="text" class="form-control" placeholder="e.g. News & Media" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Accordion Subtitle</label>
                            <input v-model="form.subtitle" type="text" class="form-control" placeholder="e.g. Latest news, press releases and media coverage." />
                        </div>
                    </div>
                </div>

                <hr />
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Media Center Banner Title</label>
                            <input v-model="form.banner_title" type="text" class="form-control" placeholder="e.g. Official Press & Media Center" />
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Media Center Banner Description</label>
                            <textarea v-model="form.banner_desc" rows="2" class="form-control" placeholder="Stay informed with our latest announcements..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold">Button Text</label>
                                    <input v-model="form.button_text" type="text" class="form-control" placeholder="e.g. Media Inquiries" />
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
