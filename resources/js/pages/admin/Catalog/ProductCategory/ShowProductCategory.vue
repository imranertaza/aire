<template>
    <DashboardHeader title="Product Category Details">
        <button class="btn btn-secondary" @click="goBack">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </DashboardHeader>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <!-- Category Image -->
                    <div class="card card-purple card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img v-if="category?.image" class="profile-user-img img-fluid"
                                    :src="getImageUrl(category.image)" alt="Category picture">
                                <span v-else class="text-muted"><i class="fas fa-folder fa-4x mb-3 text-secondary"></i><br/>No Image Available</span>
                            </div>

                            <h3 class="profile-username text-center mt-3">{{ category?.category_name }}</h3>
                            <p class="text-muted text-center" v-if="category?.alt_name">{{ category?.alt_name }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Icon</b>
                                    <span class="float-right">
                                        <i v-if="category?.icon" :class="category.icon" class="text-purple"></i>
                                        <span v-else class="text-muted">N/A</span>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Status</b>
                                    <span class="float-right badge"
                                        :class="category?.status == 1 ? 'badge-success' : 'badge-secondary'">
                                        {{ category?.status == 1 ? 'Active' : 'Inactive' }}
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Sort Order</b>
                                    <span class="float-right">{{ category?.sort_order }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Header Menu</b>
                                    <span class="float-right">
                                        <i class="fas" :class="category?.header_menu == 1 ? 'fa-check text-success' : 'fa-times text-danger'"></i>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Side Menu</b>
                                    <span class="float-right">
                                        <i class="fas" :class="category?.side_menu == 1 ? 'fa-check text-success' : 'fa-times text-danger'"></i>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <!-- Category Info -->
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">Detailed Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <h6 class="mb-0 font-weight-bold">Parent Category</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <span v-if="category?.parent">{{ category.parent.category_name }}</span>
                                    <span v-else class="text-muted">None (Top Level)</span>
                                </div>
                            </div>
                            <hr>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <h6 class="mb-0 font-weight-bold">Description</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    {{ category?.description || 'N/A' }}
                                </div>
                            </div>
                            <hr>

                            <h5 class="mt-4 mb-3 text-purple"><i class="fas fa-search"></i> SEO Details</h5>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <h6 class="mb-0 font-weight-bold">Meta Title</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    {{ category?.meta_title || 'N/A' }}
                                </div>
                            </div>
                            <hr>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <h6 class="mb-0 font-weight-bold">Meta Description</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    {{ category?.meta_description || 'N/A' }}
                                </div>
                            </div>
                            <hr>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <h6 class="mb-0 font-weight-bold">Meta Keywords</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    {{ category?.meta_keyword || 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import { getImageUrl } from '@/layouts/helpers/helpers';
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useNavigation } from '@/composables/useNavigation';

const route = useRoute();
const category = ref(null);
const { goBack } = useNavigation();

onMounted(async () => {
    try {
        const response = await axios.get(`/api/product-categories/${route.params.id}`);
        category.value = response.data.data;
    } catch (error) {
        console.error('Error fetching category:', error);
    }
});

defineProps({
    id: {
        type: [String, Number],
    }
});
</script>
