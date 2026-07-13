<template>
  <div class="menu-item">
    <div class="">
      <div class="d-flex align-items-center justify-content-between g-3">
        <div class="d-flex align-items-center g-3">
          <div class="form-check icheck-success">
            <input type="checkbox" v-model="item.enabled" :id="`enabled-${item.id}`" class="form-check-input"
              @click="toggleStatus(item.id)" />
            <label :for="`enabled-${item.id}`"></label>
          </div>
          <h6 class="m-0">{{ item?.name }}</h6>
        </div>
        <div class="d-flex g-3">
          <div v-if="submenuInput" class="d-flex gap-2">
            <div class="input-group input-group-sm">
              <input v-model="item._newChildName" class="form-control form-control-sm submenu-input"
                placeholder="Submenu name" @keyup.enter="addSubmenu(item),toggleSubmenuInput()" />

              <!-- Add Submenu button: solid primary -->
              <div class="input-group-append">
                <button class="btn btn-success btn-sm text-nowrap" @click="addSubmenu(item),toggleSubmenuInput()">
                  <i class="fas fa-plus mr-1"></i> Add Submenu
                </button>
              </div>
            </div>
          </div>

          <!-- Toggle button: outline when closed, danger when cancel -->
          <button class="btn btn-sm text-nowrap" :class="submenuInput ? 'btn-outline-danger' : 'btn-outline-primary'"
            @click="toggleSubmenuInput">
            <i :class="submenuInput ? 'fas fa-times mr-1' : 'fas fa-plus mr-1'"></i>
            {{ submenuInput ? 'Cancel' : 'Submenu' }}
          </button>

          <button class="btn btn-outline-secondary btn-sm d-inline text-nowrap" @click="openEditPanel(item)"><i
              class="fas fa-edit"></i></button>
          <button class="btn btn-outline-danger btn-sm d-inline text-nowrap"
            @click="deleteItem(item.id, item.name)">Delete</button>
        </div>
      </div>

    </div>

    <!-- Recursive children -->
    <draggable v-model="item.elements" item-key="id" :animation="150" group="menu" class="submenu-list mt-2"
      @end="() => onChildrenReorder(item)">
      <template #item="{ element }">
        <MenuItemRecursive :item="element" :toggleStatus="toggleStatus" :addSubmenu="addSubmenu"
          :openEditPanel="openEditPanel" :deleteItem="deleteItem" :updateName="updateName"
          :onChildrenReorder="onChildrenReorder" />
      </template>
    </draggable>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import MenuItemRecursive from './MenuItemRecursive.vue'
import draggable from 'vuedraggable'

const submenuInput = ref(false)

/**
 * Toggle the submenu input field visibility
 */
const toggleSubmenuInput = () => {
  submenuInput.value = !submenuInput.value
}

// Props passed from parent component
defineProps({
  item: {
    type: Object,
    required: true,
  },
  toggleStatus: {
    type: Function,
    required: true,
  },
  addSubmenu: {
    type: Function,
    required: true,
  },
  openEditPanel: {
    type: Function,
    required: true,
  },
  deleteItem: {
    type: Function,
    required: true,
  },
  updateName: {
    type: Function,
    required: true,
  },
  onChildrenReorder: {
    type: Function,
    required: true,
  },
})
</script>

<style scoped>
.menu-item {
  border-left: 2px solid #ddd;
  padding-left: 1rem;
  margin-top: 0.5rem;
}

.submenu-list {
  margin-left: 0.5rem;
  margin-top: 0.5rem;
}

.g-3 {
  gap: 0.5rem;
}

.badge-success {
  background-color: #28a745;
}

.badge-secondary {
  background-color: #6c757d;
}
</style>
