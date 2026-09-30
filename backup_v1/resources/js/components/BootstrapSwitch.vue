<template>
  <div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate"
      :class="[modelValue ? 'bootstrap-switch-on' : 'bootstrap-switch-off', { 'bootstrap-switch-disabled': disabled }]"
      @click="toggle"
      style="width: 86px; cursor: pointer; display: inline-block;">
    <div class="bootstrap-switch-container" 
         style="width: 126px; transition: margin-left 0.2s ease-in-out;" 
         :style="{ marginLeft: modelValue ? '0px' : '-42px' }">
      <span class="bootstrap-switch-handle-on" :class="onClass" style="width: 42px;">{{ onText }}</span>
      <span class="bootstrap-switch-label" style="width: 42px;">&nbsp;</span>
      <span class="bootstrap-switch-handle-off" :class="offClass" style="width: 42px;">{{ offText }}</span>
      <input type="checkbox" :checked="modelValue" style="display: none;" :disabled="disabled">
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  },
  onText: {
    type: String,
    default: 'ON'
  },
  offText: {
    type: String,
    default: 'OFF'
  },
  onClass: {
    type: String,
    default: 'bootstrap-switch-primary'
  },
  offClass: {
    type: String,
    default: 'bootstrap-switch-default'
  }
});

const emit = defineEmits(['update:modelValue', 'change']);

const toggle = () => {
  if (props.disabled) return;
  emit('update:modelValue', !props.modelValue);
  emit('change', !props.modelValue);
};
</script>
