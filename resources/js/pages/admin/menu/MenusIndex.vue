<template>
    <DashboardHeader title="Manage Menus">
        <div class="d-flex justify-content-end">
            <button class="btn btn-sm btn-primary" @click="openAddModal">
                <i class="fas fa-plus mr-1"></i> Add New Menu
            </button>
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="menus.length === 0" class="alert alert-info">No menus found.</div>

                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                    <th style="width: 200px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(menu, index) in menus" :key="menu.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ menu.name }}</td>
                                    <td class="align-middle">{{ menu.position }}</td>
                                    <td class="align-middle">
                                        <span class="badge" :class="menu.enabled ? 'badge-success' : 'badge-secondary'">
                                            {{ menu.enabled ? 'Enabled' : 'Disabled' }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link :to="{ name: 'ShowMenu', params: { id: menu.id } }"
                                                class="btn btn-sm btn-dark">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <button class="ml-2 btn btn-sm btn-dark" @click="openEditModal(menu)">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button class="ml-2 btn btn-sm btn-danger" @click="confirmDelete(menu)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Menu Modal -->
    <div v-if="addModal" class="modal fade show" tabindex="-1" role="dialog"
        style="display:block; background:rgba(0,0,0,0.5);" @click.self="closeAddModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Menu</h5>
                    <button type="button" class="close" @click="closeAddModal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="addMenu">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="newMenu.name" class="form-control form-control-sm" />
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <select v-model="newMenu.position" class="form-control custom-select form-control-sm">
                                <option value="Header">Header</option>
                                <option value="Top">Top</option>
                                <option value="Footer">Footer</option>
                                <option value="Right Sidebar">Right Sidebar</option>
                                <option value="Floating Top">Floating Top</option>
                            </select>
                        </div>
                        <div class="form-check icheck-success">
                            <input type="checkbox" v-model="newMenu.enabled" class="form-check-input"
                                id="newMenuEnabled" />
                            <label for="newMenuEnabled" class="form-check-label">Enabled</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" @click="closeAddModal">Cancel</button>
                    <button class="btn btn-primary btn-sm" @click="addMenu"><i class="fas fa-save mr-1"></i>
                        Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Menu Modal -->
    <div v-if="editModal.open" class="modal fade show" tabindex="-1" role="dialog"
        style="display:block; background:rgba(0,0,0,0.5);" @click.self="closeEditModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Menu</h5>
                    <button type="button" class="close" @click="closeEditModal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="applyEdit">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="editForm.name" class="form-control form-control-sm" />
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <select v-model="editForm.position" class="form-control form-control-sm">
                                <option value="header">Header</option>
                                <option value="top">Top</option>
                                <option value="footer">Footer</option>
                                <option value="right_sidebar">Right Sidebar</option>
                                <option value="floating_top">Floating Top</option>
                            </select>
                        </div>
                        <div class="form-check icheck-success">
                            <input type="checkbox" v-model="editForm.enabled" class="form-check-input"
                                id="editMenuEnabled" />
                            <label for="editMenuEnabled" class="form-check-label">Enabled</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" @click="closeEditModal">Cancel</button>
                    <button class="btn btn-primary btn-sm" @click="applyEdit"><i class="fas fa-save mr-1"></i>
                        Save</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, inject } from 'vue'
import axios from 'axios'
import DashboardHeader from '@/components/DashboardHeader.vue'
import { useToast } from '@/composables/useToast';

// Toast notifications
const toast = useToast()

// SweetAlert2 instance
const $swal = inject('$swal');

// List of menus
const menus = ref([])

// Add modal state
const addModal = ref(false)
const newMenu = ref({
    name: '',
    position: 'header',
    enabled: true
})

// Edit modal state
const editModal = ref({ open: false, target: null })
const editForm = ref({
    name: '',
    position: 'header',
    enabled: true,
})

/**
 * Fetch all menus from API
 */
const fetchMenus = async () => {
    try {
        const { data } = await axios.get('/api/menus')
        menus.value = data.data.data
    } catch (err) {
        console.error('Error fetching menus', err)
    }
}

/**
 * Add a new menu
 */
const addMenu = async () => {
    if (!newMenu.value.name.trim()) return
    try {
        const { data } = await axios.post('/api/menus', newMenu.value)
        menus.value.push(data.data)
        newMenu.value = { name: '', position: 'Header', enabled: true }
        closeAddModal()
        toast.success('Menu added successfully!')
    } catch (err) {
        toast.validationError(err)
    }
}

/**
 * Apply changes from edit modal
 */
const applyEdit = async () => {
    const target = editModal.value.target
    if (!target) return
    try {
        const { data } = await axios.put(`/api/menus/${target.id}`, editForm.value)
        Object.assign(target, data.data)
        closeEditModal()
        toast.success('Menu updated successfully!')
    } catch (err) {
        toast.validationError(err)
    }
}

/**
 * Confirm and delete a menu
 */
const confirmDelete = async (menu) => {
    const result = await $swal({
        title: `Delete "${menu.name}"?`,
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/menus/${menu.id}`);

            menus.value = menus.value.filter(m => m.id !== menu.id);

            toast.success('Menu deleted successfully!');
        } catch (err) {
            console.error('Error deleting menu', err);
            toast.validationError(err);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};

// Modal control helpers
const openAddModal = () => { addModal.value = true }
const closeAddModal = () => { addModal.value = false }

const openEditModal = (menu) => {
    editModal.value.open = true
    editModal.value.target = menu
    editForm.value = { ...menu, enabled: !!menu.enabled }
}
const closeEditModal = () => {
    editModal.value.open = false
    editModal.value.target = null
}

// Load menus on component mount
onMounted(fetchMenus)
</script>



<style scoped>
.badge-success {
    background-color: #28a745;
    color: #fff;
}

.badge-secondary {
    background-color: #6c757d;
    color: #fff;
}

.modal.fade.show {
    display: block;
}

.modal-backdrop {
    background: rgba(0, 0, 0, 0.5);
}

.modal-dialog {
    max-width: 500px;
}

.modal-content {
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.modal-header,
.modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h5 {
    margin: 0;
}

.close {
    background: none;
    border: none;
    font-size: 1.5rem;
    line-height: 1;
    cursor: pointer;
}

.form-group {
    margin-bottom: 1rem;
}

.form-check {
    margin-top: 0.5rem;
}
</style>
