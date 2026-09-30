<template>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-md-4 mb-2 ">
        <h3 class="mb-3 mb-md-0">{{ title }}</h3>
        <div class="d-flex align-items-center">
            <div class="d-flex gap-3">
                <slot />
            </div>
            <!-- Back button only if back=true -->
            <button v-if="back" type="button" class="btn btn-sm btn-outline-secondary ml-2" @click="$emit('back')">
                ← Back
            </button>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true
    },
    back: {
        type: Boolean,
        default: false
    }
});
defineEmits(['back']);
</script>
