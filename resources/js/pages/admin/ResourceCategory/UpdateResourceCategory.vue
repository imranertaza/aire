<template>
    <ResourceCategoryForm :is-edit="true" :category-id="id || route.params.id" />
</template>

<script setup>
import { useRoute } from 'vue-router';
import ResourceCategoryForm from './ResourceCategoryForm.vue';

const props = defineProps({
    id: {
        type: [String, Number],
        default: null
    }
});

const route = useRoute();
</script>
