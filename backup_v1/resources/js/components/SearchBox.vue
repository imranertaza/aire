<template>
  <!-- Search input group with customizable width and styles -->
  <div class="input-group" :class="sizeClass" :style="{ width }">
    <!-- Search input field -->
    <input
      v-model="query"
      @keyup.enter="emitSearch"
      type="text"
      class="form-control"
      :placeholder="placeholder"
    />
    <!-- Search button append -->
    <div class="input-group-append">
      <button :class="['btn', btnClass, btnSize]" @click="emitSearch">
        <i class="fas fa-search"></i> {{ btnText }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

/**
 * Props for customizing the search component
 */
const props = defineProps({
  width: { type: String, default: '250px' },              // Overall width of the input group
  btnClass: { type: String, default: 'btn-default' },     // Button style class (e.g., btn-primary)
  btnSize: { type: String, default: '' },                 // Button size class (btn-sm, btn-lg)
  btnText: { type: String, default: 'Search' },           // Text shown on the button
  size: { type: String, default: '' },                    // Input group size (sm, lg → input-group-sm/lg)
  placeholder: { type: String, default: 'Search...' }     // Placeholder text for input
})

// Local search query value
const query = ref('')

// Emit custom 'search' event
const emit = defineEmits(['search'])

/**
 * Emit the current query when search is triggered (button click or Enter key)
 */
const emitSearch = () => {
  emit('search', query.value)
}

/**
 * Compute input-group size class (e.g., input-group-sm or input-group-lg)
 */
const sizeClass = computed(() => {
  return props.size ? `input-group-${props.size}` : ''
})
</script>
