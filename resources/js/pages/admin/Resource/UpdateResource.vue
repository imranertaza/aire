<template>
    <ResourceForm :is-edit="true" :resource-id="id || route.params.id" />
</template>

<script setup>
import { useRoute } from 'vue-router';
import ResourceForm from './ResourceForm.vue';

const props = defineProps({
    id: {
        type: [String, Number],
        default: null
    }
});

const route = useRoute();
</script>
