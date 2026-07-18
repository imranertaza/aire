<template>
    <DashboardHeader title="Manage Offers">
        <div class="d-flex justify-content-end align-items-center">
            <select v-model="perPage" @change="onPerPageChange" class="custom-select mr-2" style="width: auto;">
                <option :value="10">10 per page</option>
                <option :value="25">25 per page</option>
                <option :value="50">50 per page</option>
                <option :value="100">100 per page</option>
            </select>
            <select v-model="typeFilter" @change="onTypeChange" class="custom-select mr-2" style="width: auto;">
                <option value="">All Types</option>
                <option value="general_offer">General Offers</option>
                <option value="zone_based_offer">Zone Based Offers</option>
            </select>
            <SearchBox @search="onSearch" class="mr-2" />
            <router-link v-if="authStore.hasPermission('create-offers')" :to="{ name: 'CreateOffer' }"
                class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Offer
            </router-link>
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div v-if="offers?.data?.length === 0" class="alert alert-info">No offers found.</div>
                        <div v-else class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr class="align-middle">
                                        <th style="width: 10px">#</th>
                                        <th>Banner</th>
                                        <th>Name</th>
                                        <th>Key</th>
                                        <th>Offer Type</th>
                                        <th>Offer On</th>
                                        <th>Discount</th>
                                        <th>Start Date</th>
                                        <th>Expire Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(offer, index) in offers?.data" :key="offer.id">
                                        <td class="align-middle">{{ index + 1 }}</td>
                                        <td class="align-middle">
                                            <img v-if="offer.banner"
                                                :src="`/storage/uploads/offers/${offer.id}/${offer.banner}`"
                                                style="width:50px;height:50px;object-fit:cover;border-radius:4px;" />
                                            <span v-else class="badge badge-secondary">No Image</span>
                                        </td>
                                        <td class="align-middle">{{ offer.name }}</td>
                                        <td class="align-middle">
                                            <span class="badge badge-info">{{ offer.key }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge"
                                                :class="offer.offer_type == 1 ? 'badge-primary' : 'badge-warning'">
                                                {{ offer.offer_type == 1 ? 'Distinct' : 'Indistinct' }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-info">
                                                {{ offer.offer_on == 1 ? 'Product' : (offer.offer_on == 2 ? 'Amount' :
                                                'Unknown') }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <span v-if="offer.key === 'zone_based_offer'" class="badge badge-secondary">
                                                Zone Based (Multiple)
                                            </span>
                                            <span v-else-if="offer.discounts && offer.discounts.length > 0">
                                                {{ offer.discounts[0].discount_amount }}
                                                {{ offer.discounts[0].discount_calculate_on == 1 ? '%' : ' Flat' }}
                                            </span>
                                            <span v-else class="text-muted">—</span>
                                        </td>
                                        <td class="align-middle">{{ formatDate(offer.start_date, true) }}</td>
                                        <td class="align-middle">{{ formatDate(offer.expire_date, true) }}</td>
                                        <td class="align-middle">
                                            <div class="d-flex" style="gap:4px">
                                                <router-link v-if="authStore.hasPermission('edit-offers')"
                                                    :to="{ name: 'UpdateOffer', params: { id: offer.id } }"
                                                    class="btn btn-sm btn-outline-info text-nowrap">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </router-link>
                                                <button v-if="authStore.hasPermission('delete-offers')"
                                                    class="btn btn-sm btn-outline-danger text-nowrap"
                                                    @click="confirmDelete(offer)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-3" v-if="offers?.data?.length > 0">
                            <Pagination :pData="offers" @page-change="fetchPage" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import { inject, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Pagination from '@/components/Paginations/Pagination.vue';
import { useToast } from '@/composables/useToast';
import { useAuthStore } from '@/store/auth';
import SearchBox from '@/components/SearchBox.vue';
import { formatDate } from '@/layouts/helpers/helpers';

const router = useRouter();
const route = useRoute();
const offers = ref([]);
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject('$swal');
const currentSearchTerm = ref('');
const perPage = ref(10);
const typeFilter = ref('');

const fetchPage = async (page = 1) => {
    try {
        const res = await axios.get(`/api/offers?page=${page}&search=${currentSearchTerm.value}&per_page=${perPage.value}&type=${typeFilter.value}`);
        offers.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error('Failed to load offers.');
    }
};

const onSearch = (term) => {
    currentSearchTerm.value = term;
    fetchPage();
};

const onPerPageChange = () => {
    fetchPage(1);
};

const onTypeChange = () => {
    fetchPage(1);
};

onMounted(() => {
    fetchPage();
    if (route.query.toast) {
        toast.success(route.query.toast);
        setTimeout(() => {
            const q = { ...route.query };
            delete q.toast;
            router.replace({ query: q });
        }, 2000);
    }
});

const confirmDelete = async (offer) => {
    const result = await $swal({
        title: `Delete "${offer.name}"?`,
        text: 'This will permanently delete the offer, its discount, and all product targets.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/offers/${offer.id}`);
            toast.success('Offer deleted successfully!');
            fetchPage();
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info('Deletion cancelled.');
    }
};
</script>
