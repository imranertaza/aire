<template>
  <div class="menu-manager">
    <DashboardHeader title="Menu Manager" :back="true" @back="goBack()">
      <div class="input-group input-group-sm" style="max-width: 360px;">
        <input v-model="newMenuName" class="form-control form-control-sm" placeholder="New menu name"
          @keyup.enter="addMenu" />
        <div class="input-group-append">
          <button class="btn btn-block btn-info btn-sm" @click="addMenu">Add Menu</button>
        </div>
      </div>
    </DashboardHeader>


    <section>
      <div class="row">
        <div class="col-md-12">
          <div v-if="menuItems?.length === 0" class="alert alert-info">
            No menu item found.
          </div>
          <draggable v-else v-model="menuItems" item-key="id" :animation="150" group="menu" @end="onReorder">
            <template #item="{ element }">
              <MenuItem :item="element" :toggleStatus="toggleStatus" :updateName="updateName" :addSubmenu="addSubmenu"
                :openEditPanel="openEditPanel" :deleteItem="deleteItem" :onChildrenReorder="onReorder" />
            </template>
          </draggable>

        </div>
      </div>
    </section>
    <!-- Edit Modal -->
    <div v-if="editModal.open" class="modal fade show" tabindex="-1" role="dialog"
      style="display: block; background: rgba(0,0,0,0.5);" @click.self="closeEditPanel">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Menu Item</h5>
            <button type="button" class="close" @click="closeEditPanel">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form @submit.prevent>
              <!-- Name -->
              <div class="form-group">
                <label for="edit-name">Name</label>
                <input id="edit-name" v-model="editForm.name" type="text" class="form-control form-control-sm"
                  placeholder="Enter menu name" />
              </div>

              <!-- Icon -->
              <div class="form-group">
                <label for="edit-icon">Icon (FontAwesome)</label>
                <input id="edit-icon" v-model="editForm.icon" type="text" class="form-control form-control-sm"
                  placeholder="e.g. fas fa-home" />
                <small v-if="editForm.icon" class="form-text text-muted d-flex align-items-center mt-1">
                  <i :class="editForm.icon" class="mr-1"></i> Preview
                </small>
              </div>

              <!-- Link Type -->
              <div class="form-group">
                <label for="edit-link-type">Link Type</label>
                <select id="edit-link-type" v-model="editForm.link_type" class="form-control form-control-sm">
                  <option value="">-- Select Type --</option>
                  <option value="page">Page</option>
                  <option value="category">Post Category</option>
                  <option value="url">URL</option>
                </select>
              </div>

              <!-- Conditional fields -->
              <div v-if="editForm.link_type === 'page'" class="form-group">
                <label for="edit-page">Page</label>
                <Multiselect v-model="editForm.page_id" :options="pagesOptions" :reduce="option => option.value"
                  placeholder="Select page" searchable />
              </div>

              <div v-if="editForm.link_type === 'category'" class="form-group">
                <label for="edit-category">Category</label>
                <Multiselect v-model="editForm.category_id" :options="categoriesOptions"
                  :reduce="option => option.value" placeholder="Select category" searchable />
              </div>

              <div v-if="editForm.link_type === 'url'" class="form-group">
                <label for="edit-url">URL</label>
                <input id="edit-url" v-model="editForm.url" type="text" class="form-control form-control-sm"
                  placeholder="https://example.com" />
              </div>

              <!-- Enabled -->
              <div class="icheck-success mt-2">
                <input id="edit-enabled" v-model="editForm.enabled" type="checkbox" class="form-check-input" />
                <label for="edit-enabled" class="form-check-label">Enabled</label>
              </div>
            </form>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" @click="closeEditPanel">Cancel</button>
            <button type="button" class="btn btn-primary btn-sm" @click="applyEdit">
              <i class="fas fa-save mr-1"></i> Save
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import axios from 'axios';
import { computed, inject, onMounted, ref } from 'vue'
import draggable from 'vuedraggable'
import DashboardHeader from '@/components/DashboardHeader.vue';
import { useToast } from '@/composables/useToast';

// New top-level menu name input
const newMenuName = ref('');

// Categories for link_type = category
const categories = ref([]);

// Toast notifications
const toast = useToast()

// Pages for link_type = page
const pages = ref([]);

// SweetAlert2 instance
const $swal = inject('$swal');

import { useRoute } from 'vue-router'
import MenuItem from './MenuItem.vue';
import Multiselect from '@vueform/multiselect';

// Current route & menu ID from URL
const route = useRoute()
const menuId = route.params.id

import { useNavigation } from '@/composables/useNavigation';
const { goBack } = useNavigation();
// Hierarchical menu items
const menuItems = ref([]);

/**
 * Fetch menu items for the current menu
 */
const fetchMenuItems = async (menuId = 1) => {
  try {
    const { data } = await axios.get('/api/menu-items', {
      params: { menu_id: menuId }
    })
    return data.data
  } catch (err) {
    console.error('Error fetching menu items', err)
    return []
  }
}

/**
 * Recursively find a menu item by ID
 */
const findItemById = (nodes, id) => {
  for (const node of nodes) {
    if (node.id === id) return node
    if (node.elements && node.elements.length) {
      const found = findItemById(node.elements, id)
      if (found) return found
    }
  }
  return null
}

/**
 * Update menu item name, icon, link details, etc.
 */
const updateName = async (item) => {
  try {
    const payload = {
      name: item.name,
      icon: item.icon,
      link_type: item.link_type,
      page_id: item.page_id || null,
      category_id: item.category_id || null,
      url: item.url || null,
      enabled: item.enabled
    }

    const { data } = await axios.put(`/api/menu-items/${item.id}`, payload)
    Object.assign(item, data.data)
    toast.success(`Menu item "${item.name}" updated successfully!`)
  } catch (err) {
    toast.error(`Failed to update menu item "${item.name}".`)
  }
}

/**
 * Toggle enabled/disabled status of a menu item
 */
const toggleStatus = async (menuId) => {
  const item = findItemById(menuItems.value, menuId)
  if (!item) return

  // Optimistic UI update
  item.enabled = !item.enabled

  try {
    const { data } = await axios.put(`/api/menu-items/${menuId}`, {
      enabled: item.enabled
    })
    Object.assign(item, data.data)
    toast.success(`Menu item "${item.name}" is now ${item.enabled ? 'enabled' : 'disabled'}.`)
  } catch (err) {
    toast.error(`Failed to update status for "${item.name}".`)
    // Rollback on failure
    item.enabled = !item.enabled
  }
}

/**
 * Build flat payload for reordering (with order & parent_id)
 */
const buildReorderPayload = (nodes, parentId = null) => {
  return nodes.flatMap((node, index) => {
    const current = {
      id: node.id,
      order: index + 1,
      parent_id: parentId
    }
    const children = buildReorderPayload(node.elements || [], node.id)
    return [current, ...children]
  })
}

/**
 * Send reordered items to backend
 */
const onReorder = async () => {
  try {
    const items = buildReorderPayload(menuItems.value)

    await axios.post('/api/menu-items/reorder', {
      menu_id: menuId,
      items
    })
    toast.success('Menu order updated successfully!')
  } catch (err) {
    toast.error('Failed to update menu order.')
  }
}

/**
 * Fetch categories for dropdown
 */
const fetchCategories = async () => {
  try {
    const res = await axios.get('/api/categories?all=1');
    categories.value = res.data.data;
  } catch (error) {
    toast.error('Failed to load categories');
  }
};

/**
 * Category options for multiselect
 */
const categoriesOptions = computed(() => {
  return [
    { label: '-- None --', value: '' },
    ...categories.value.map(cat => ({
      label: cat.category_name,
      value: cat.id
    }))
  ];
});

/**
 * Fetch pages for dropdown
 */
const fetchPages = async (page = 1, searchTerm = "") => {
  try {
    const res = await axios.get(`/api/pages?all=1`);
    pages.value = res.data.data;
  } catch (error) {
    console.error(error);
  }
};

/**
 * Page options for multiselect
 */
const pagesOptions = computed(() => {
  return [
    { label: '-- None --', value: '' },
    ...pages.value.map(page => ({
      label: page.page_title,
      value: page.id
    }))
  ];
});

/**
 * Load initial data on mount
 */
onMounted(async () => {
  menuItems.value = await fetchMenuItems(menuId)
  fetchCategories()
  fetchPages()
})

// Edit modal state
const editModal = ref({ open: false, target: null })
const editForm = ref({
  name: '',
  icon: '',
  url: '',
  link_type: '',
  page_id: '',
  category_id: '',
  enabled: true
})

/**
 * Add new top-level menu item
 */
const addMenu = async () => {
  const name = newMenuName.value.trim()
  if (!name) return

  try {
    const payload = {
      menu_id: menuId,
      parent_id: null,
      name,
      icon: '',
      link_type: 'url',
      url: '/',
      enabled: true
    }

    const { data } = await axios.post('/api/menu-items', payload)

    menuItems.value.unshift({
      ...data.data,
      _newChildName: '',
      elements: []
    })
    newMenuName.value = ''
    toast.success(`Menu "${name}" added successfully!`)
  } catch (err) {
    toast.error('Failed to add menu.')
  }
}

/**
 * Add submenu under a parent item
 */
const addSubmenu = async (parent) => {
  const name = (parent._newChildName || '').trim()
  if (!name) return

  try {
    const payload = {
      menu_id: parent.menu_id || 1,
      parent_id: parent.id,
      name,
      icon: '',
      link_type: 'url',
      url: '/',
      enabled: true
    }

    const { data } = await axios.post('/api/menu-items', payload)

    parent.elements.push({
      ...data.data,
      _newChildName: '',
      elements: []
    })

    parent._newChildName = ''
    toast.success(`Submenu "${name}" added successfully!`)
  } catch (err) {
    toast.error('Failed to add submenu.')
  }
}

/**
 * Delete menu item with confirmation
 */
const deleteItem = async (id, name = 'this item') => {
  const result = await $swal({
    title: `Delete "${name}"?`,
    text: 'This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete',
    cancelButtonText: 'Cancel',
    reverseButtons: true
  });

  if (result.isConfirmed) {
    try {
      await axios.delete(`/api/menu-items/${id}`);

      const removeNode = (nodes) => {
        const idx = nodes.findIndex(n => n.id === id);
        if (idx !== -1) {
          nodes.splice(idx, 1);
          return true;
        }
        for (const n of nodes) {
          if (n.elements && removeNode(n.elements)) return true;
        }
        return false;
      };

      removeNode(menuItems.value);

      toast.success('Menu item deleted successfully!');
    } catch (error) {
      console.error('Error deleting menu item', error);
      toast.validationError(error);
    }
  } else {
    toast.info('Deletion cancelled.');
  }
};

/**
 * Open edit modal and populate form
 */
const openEditPanel = (item) => {
  editModal.value.open = true
  editModal.value.target = item
  editForm.value = {
    name: item.name || '',
    icon: item.icon || '',
    link_type: item.link_type || '',
    url: item.url || '',
    category_id: item.category_id || '',
    page_id: item.page_id || '',
    enabled: item.enabled !== false
  }
}

/**
 * Close edit modal
 */
const closeEditPanel = () => {
  editModal.value.open = false
  editModal.value.target = null
}

/**
 * Apply changes from edit modal
 */
const applyEdit = async () => {
  const target = editModal.value.target
  if (!target) return
  try {
    const payload = {
      name: editForm.value.name,
      icon: editForm.value.icon,
      link_type: editForm.value.link_type,
      page_id: editForm.value.page_id || null,
      category_id: editForm.value.category_id || null,
      url: editForm.value.url || null,
      enabled: editForm.value.enabled
    }
    const { data } = await axios.put(`/api/menu-items/${target.id}`, payload)

    Object.assign(target, data.data)

    toast.success('Menu item updated successfully!')
    closeEditPanel()
  } catch (err) {
    toast.validationError(err)
  }
}
</script>
<style>
.menu-item {
  background: #f9f9f9;
  border: 1px solid #dee2e6;
  border-radius: 6px;
  padding: 1rem;
  margin-bottom: 1rem;
}

.name-input {
  flex-grow: 1;
  min-width: 180px;
}
</style>
