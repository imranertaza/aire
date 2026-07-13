import { defineStore } from 'pinia'
import { ref } from 'vue'

/**
 * Pinia store for managing nested hierarchical data (e.g., menu items, categories).
 *
 * Provides a reactive array of elements with nested children and a method to update it.
 */
export const useNestedStore = defineStore('nested', () => {
  /**
   * Reactive nested structure of elements.
   * Each item can have an `elements` array for children (recursive structure).
   */
  const elements = ref([
    { id: 1, name: 'Item A', elements: [{ id: 11, name: 'Sub A1', elements: [] }] },
    { id: 2, name: 'Item B', elements: [] }
  ])

  /**
   * Replace the entire elements array with a new value.
   *
   * @param {Array} value - New nested elements array
   */
  const updateElements = (value) => {
    elements.value = value
  }

  return { elements, updateElements }
})
