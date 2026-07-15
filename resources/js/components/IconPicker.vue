<template>
    <div class="icon-picker-wrapper">
        <Vue3IconPicker 
            v-model="internalValue" 
            valueType="class"
            iconLibrary="fa"
            placeholder="Select icon"
        />
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Vue3IconPicker } from 'vue3-icon-picker';
import 'vue3-icon-picker/dist/style.css';

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    }
});

const emit = defineEmits(['update:modelValue']);

const internalValue = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val)
});
</script>

<style scoped>
.icon-picker-wrapper {
    width: 100%;
}
</style>
