<template>
    <DashboardHeader title="Update Geo Zone" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div v-if="isLoading" class="text-center p-4 w-100">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                
                <div v-else class="card card-purple w-100">
                    <div class="card-header">
                        <h3 class="card-title">Update Geo Zone</h3>
                    </div>
                    
                    <form @submit.prevent="submitForm">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Geo Zone Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" v-model="formData.geo_zone_name"
                                                    :class="{ 'is-invalid': errors.geo_zone_name }" required placeholder="Enter name">
                                                <div class="invalid-feedback" v-if="errors.geo_zone_name">{{ errors.geo_zone_name[0] }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input type="text" class="form-control" v-model="formData.geo_zone_description"
                                                    :class="{ 'is-invalid': errors.geo_zone_description }" placeholder="Enter description">
                                                <div class="invalid-feedback" v-if="errors.geo_zone_description">{{ errors.geo_zone_description[0] }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Zone Details Table -->
                                    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                                        <h5>Countries and Zones</h5>
                                        <button type="button" class="btn btn-sm btn-primary" @click="addDetailRow">
                                            <i class="fas fa-plus"></i> Add Country / Zone
                                        </button>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Country</th>
                                                    <th>Zone</th>
                                                    <th style="width: 100px;" class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-if="formData.details.length === 0">
                                                    <td colspan="3" class="text-center text-muted">No zones added yet. Click 'Add Country / Zone' to get started.</td>
                                                </tr>
                                                <tr v-for="(detail, index) in formData.details" :key="index">
                                                    <td>
                                                        <select class="form-control" v-model="detail.country_id" 
                                                            @change="onCountryChange(detail.country_id)" required
                                                            :class="{ 'is-invalid': errors[`details.${index}.country_id`] }">
                                                            <option value="" disabled>Select Country</option>
                                                            <option v-for="country in countries" :key="country.id" :value="country.id">
                                                                {{ country.name }}
                                                            </option>
                                                        </select>
                                                        <div class="invalid-feedback" v-if="errors[`details.${index}.country_id`]">
                                                            {{ errors[`details.${index}.country_id`][0] }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" v-model="detail.zone_id" required
                                                            :class="{ 'is-invalid': errors[`details.${index}.zone_id`] }"
                                                            :disabled="!detail.country_id">
                                                            <option :value="0">All Zones</option>
                                                            <option v-for="zone in (zonesByCountry[detail.country_id] || [])" :key="zone.id" :value="zone.id">
                                                                {{ zone.name }}
                                                            </option>
                                                        </select>
                                                        <div class="invalid-feedback" v-if="errors[`details.${index}.zone_id`]">
                                                            {{ errors[`details.${index}.zone_id`][0] }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button type="button" class="btn btn-sm btn-outline-danger" @click="removeDetailRow(index, detail.id)" title="Remove">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-4 border-left">
                                    <div class="form-group">
                                        <label>Sort Order</label>
                                        <input min="0" type="number" class="form-control" v-model="formData.sort_order"
                                            :class="{ 'is-invalid': errors.sort_order }">
                                        <div class="invalid-feedback" v-if="errors.sort_order">{{ errors.sort_order[0] }}</div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Status</label>
                                        <div class="mt-1">
                                            <BootstrapSwitch 
                                                :modelValue="formData.status === 1"
                                                @update:modelValue="val => formData.status = val ? 1 : 0"
                                            />
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-success btn-block" :disabled="isSubmitting">
                                            <span v-if="isSubmitting" class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                                            Update
                                        </button>
                                        <RouterLink :to="{ name: 'GeoZones' }" class="btn btn-secondary btn-block mt-2">
                                            Cancel
                                        </RouterLink>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, inject } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useToast } from '@/composables/useToast';
import axios from 'axios';
import BootstrapSwitch from '@/components/BootstrapSwitch.vue';
import DashboardHeader from '@/components/DashboardHeader.vue';

const router = useRouter();
const route = useRoute();
const toast = useToast();
const $swal = inject('$swal');
const id = route.params.id;

const formData = ref({
    geo_zone_name: '',
    geo_zone_description: '',
    sort_order: 0,
    status: 1,
    details: []
});

const isSubmitting = ref(false);
const isLoading = ref(true);
const errors = ref({});

const countries = ref([]);
const zonesByCountry = ref({});

const fetchCountries = async () => {
    try {
        const response = await axios.get('/api/geo-zones/countries');
        countries.value = response.data.data;
    } catch (error) {
        toast.error('Failed to load countries');
    }
};

const fetchZones = async (countryId) => {
    if (!countryId || zonesByCountry.value[countryId]) return;
    try {
        const response = await axios.get(`/api/geo-zones/countries/${countryId}/zones`);
        zonesByCountry.value[countryId] = response.data.data;
    } catch (error) {
        toast.error('Failed to load zones');
    }
};

const fetchGeoZone = async () => {
    try {
        const response = await axios.get(`/api/geo-zones/${id}`);
        const data = response.data.data;
        formData.value = {
            geo_zone_name: data.geo_zone_name,
            geo_zone_description: data.geo_zone_description || '',
            sort_order: data.sort_order,
            status: data.status,
            details: data.details || []
        };
        
        // Pre-fetch zones for existing countries
        for (const detail of formData.value.details) {
            if (detail.country_id) {
                await fetchZones(detail.country_id);
            }
        }
    } catch (error) {
        toast.error('Failed to load geo zone');
        router.push({ name: 'GeoZones' });
    } finally {
        isLoading.value = false;
    }
};

const addDetailRow = () => {
    formData.value.details.push({
        id: null,
        country_id: '',
        zone_id: 0
    });
};

const removeDetailRow = async (index, detailId) => {
    if (detailId) {
        const result = await $swal({
            title: 'Remove this detail row?',
            text: 'This will permanently delete the country/zone mapping immediately.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        });

        if (result.isConfirmed) {
            try {
                await axios.delete(`/api/geo-zones/details/${detailId}`);
                toast.success('Detail removed');
                formData.value.details.splice(index, 1);
            } catch (error) {
                toast.error('Failed to remove detail');
            }
        }
    } else {
        formData.value.details.splice(index, 1);
    }
};

const onCountryChange = (countryId) => {
    if (countryId) {
        fetchZones(countryId);
    }
};

const submitForm = async () => {
    isSubmitting.value = true;
    errors.value = {};

    try {
        await axios.put(`/api/geo-zones/${id}`, formData.value);
        toast.success('Geo Zone updated successfully!');
        router.push({ name: 'GeoZones' });
    } catch (error) {
        if (error.response?.status === 422) {
            if (error.response.data.errors) {
                errors.value = error.response.data.errors;
            } else {
                toast.validationError(error);
            }
        } else {
            toast.error('An error occurred while saving the geo zone');
        }
    } finally {
        isSubmitting.value = false;
    }
};

onMounted(async () => {
    await fetchCountries();
    await fetchGeoZone();
});
</script>
