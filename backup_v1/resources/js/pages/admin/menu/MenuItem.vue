<template>
  <MenuItemRecursive
    :item="item"
    :toggleStatus="toggleStatus"
    :addSubmenu="addSubmenu"
    :openEditPanel="openEditPanel"
    :deleteItem="deleteItem"
    :updateName="updateName"
    :onChildrenReorder="onChildrenReorder" />
</template>

<script setup>
import MenuItemRecursive from './MenuItemRecursive.vue'

defineProps({
  item: Object,
  toggleStatus: Function,
  addSubmenu: Function,
  openEditPanel: Function,
  deleteItem: Function,
  updateName: Function,
  onChildrenReorder: Function,
})
</script>
