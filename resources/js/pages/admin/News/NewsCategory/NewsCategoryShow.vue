<template>
    <DashboardHeader title=" News Category Details" :back="true" @back="goBack()" />

    <section class="mt-3">
        <div class="card">
            <div class="card-body" v-if="category">
                <h4 class="mb-3">{{ category.category_name }}</h4>

                <dl class="row">
                    <dt class="col-sm-3">Parent</dt>
                    <dd class="col-sm-9">{{ category.parent ? category.parent.category_name : '-' }}</dd>

                    <dt class="col-sm-3">Description</dt>
                    <dd class="col-sm-9">{{ category.description || '-' }}</dd>

                    <dt class="col-sm-3">Meta Title</dt>
                    <dd class="col-sm-9">{{ category.meta_title || '-' }}</dd>

                    <dt class="col-sm-3">Meta Description</dt>
                    <dd class="col-sm-9">{{ category.meta_description || '-' }}</dd>

                    <dt class="col-sm-3">Meta Keyword</dt>
                    <dd class="col-sm-9">{{ category.meta_keyword || '-' }}</dd>

                    <dt class="col-sm-3">Image</dt>
                    <dd class="col-sm-9">
                        <img v-if="category.image" :src="getImageUrl(category.image)" alt="Category Image" height="80"
                            class="rounded" />
                        <span v-else>-</span>
                    </dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9">
                        <span :class="category.status == 1 ? 'badge bg-success' : 'badge bg-danger'">
                            {{ category.status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </dd>

                    <dt class="col-sm-3">Sort Order</dt>
                    <dd class="col-sm-9">{{ category.sort_order }}</dd>
                </dl>

                <router-link :to="{ name: 'NewsCategoryIndex' }" class="btn btn-secondary mt-3">Back to
                    List</router-link>
                <router-link v-if="authStore.hasPermission('edit-categories')"
                    :to="{ name: 'UpdateNewsCategory', params: { id: category?.id } }"
                    class="ml-2 btn btn-primary mt-3 ms-2">
                    Edit
                </router-link>
            </div>

            <div v-else class="alert alert-info">Loading category details...</div>
        </div>
    </section>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div v-if="category?.children.length === 0" class="alert alert-info">
                    No Subcategories found.
                </div>

                <div v-else>
                    <h4 class="mt-3 mb-1">Subcategories List</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Parent</th>
                                    <th>Description</th>
                                    <th v-if="authStore.hasPermission('edit-news-categories')">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(cat, index) in category?.children" :key="cat.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ truncateText(cat.category_name, 25) }}</td>
                                    <td class="align-middle">
                                        {{ cat.parent ? cat.parent.category_name : '-' }}
                                    </td>
                                    <td class="align-middle">{{ truncateText(cat.description, 50) }}</td>

                                    <!-- Status dropdown -->
                                    <td v-if="authStore.hasPermission('edit-news-categories')" class="align-middle">
                                        <select v-model="cat.status" @change="updateStatus(cat)" class="custom-select"
                                            :class="cat.status == 1 ? 'bg-success text-white' : 'bg-transparent text-dark'">
                                            <option :value="1">Active</option>
                                            <option :value="0">Inactive</option>
                                        </select>
                                    </td>

                                    <!-- Actions -->
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <button v-if="authStore.hasPermission('view-categories')"
                                                @click="fetchCategory(cat.id)" class="btn btn-sm btn-dark">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <router-link v-if="authStore.hasPermission('edit-categories')"
                                                :to="{ name: 'UpdateCategory', params: { id: cat.id } }"
                                                class="ml-2 btn btn-sm btn-dark">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>

                                            <button v-if="authStore.hasPermission('delete-categories')"
                                                class="ml-2 btn btn-sm btn-danger" @click="confirmDelete(cat)">
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
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import { useToast } from '@/composables/useToast';
import { getImageUrl, truncateText } from '@/layouts/helpers/helpers';
import { useAuthStore } from '@/store/auth';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useNavigation } from '@/composables/useNavigation';
const { goBack } = useNavigation();
// Toast notifications
const toast = useToast();

// Current route (to access category ID from params)
const route = useRoute();

// Single news category data
const category = ref(null);

// Auth store (if needed for user/role checks)
const authStore = useAuthStore();

/**
 * Fetch the news category details by ID
 * @param {number|string} id - Category ID (defaults to route.params.id)
 */
const fetchCategory = async (id = route.params.id) => {
    try {
        const res = await axios.get(`/api/news-categories/${id}`);
        category.value = res.data.data;
    } catch (error) {
        toast.error('Failed to load category details');
        console.error(error);
    }
};

// Optional props (kept for flexibility, ID primarily from route)
defineProps({
    id: {
        type: [Number, String],
        required: false
    }
});

// Load category on component mount
onMounted(() => {
    fetchCategory();
});
</script>
