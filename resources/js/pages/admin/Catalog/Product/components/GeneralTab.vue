<template>
    <div class="tab-pane fade show active" id="custom-tabs-general" role="tabpanel"
        aria-labelledby="tab-general">
        <div class="row">
            <div class="col-md-6 form-group">
                <label>Product Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" v-model="formData.name"
                    @input="onNameInput" required />
            </div>
            <div class="col-md-6 form-group">
                <label>Slug <span class="text-danger">*</span></label>
                <input type="text" class="form-control" v-model="formData.slug" required />
            </div>
            <div class="col-md-12 form-group">
                <label>Description</label>
                <!-- <RichTextEditor v-model="formData.description" /> -->
                <textarea class="form-control" v-model="formData.description"></textarea>
            </div>
            <div class="col-md-12 form-group">
                <label>Tags</label>
                <input type="text" class="form-control" v-model="formData.tag"
                    placeholder="Separate tags with commas" />
            </div>
            <div class="col-md-12 form-group">
                <label>Meta Title</label>
                <input type="text" class="form-control" v-model="formData.meta_title" />
            </div>
            <div class="col-md-12 form-group">
                <label>Meta Description</label>
                <textarea class="form-control" rows="3"
                    v-model="formData.meta_description"></textarea>
            </div>
            <div class="col-md-12 form-group">
                <label>Meta Keywords</label>
                <input type="text" class="form-control" v-model="formData.meta_keyword" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { generateSlug } from '@/layouts/helpers/helpers';

const props = defineProps({
    modelValue: {
        type: Object,
        default: null
    },
    form: {
        type: Object,
        default: null
    }
});

const formData = computed(() => props.form || props.modelValue || {});

const onNameInput = () => {
    formData.value.slug = generateSlug(formData.value.name || '');
};
</script>
