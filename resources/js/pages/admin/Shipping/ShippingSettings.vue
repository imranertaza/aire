<template>
    <DashboardHeader :title="shippingMethod?.name ? `Settings: ${shippingMethod.name}` : 'Shipping Settings'" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div v-if="loading" class="text-center my-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    <div v-else class="card card-primary card-outline">
                        <form @submit.prevent="submitSettings">
                            <div class="card-body">

                                <div class="row border-bottom mb-4 pb-4">
                                    <!-- Common Status Toggle -->
                                    <div class="col-sm-12 col-md-5">
                                        <div class="card shadow-sm h-100 border-0 bg-light">
                                            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                                <h6 class="font-weight-bold text-secondary mb-4"><i class="fas fa-power-off mr-2"></i>Shipping Method Status</h6>
                                                <BootstrapSwitch :modelValue="formData.status === 1"
                                                    @update:modelValue="val => formData.status = val ? 1 : 0" />
                                                <small class="text-muted mt-4">Enable or disable this shipping method for the
                                                    checkout page.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Generic Settings (e.g. Flat Rate, Zone Rate Method Type) -->
                                <div v-if="formData.settings && formData.settings.length > 0">
                                    <h5 class="mb-3">General Settings</h5>
                                    <div class="row">
                                        <div class="col-md-6" v-for="setting in formData.settings" :key="setting.id">
                                            <div class="form-group">
                                                <label>{{ setting.title }}</label>
                                                <!-- If it's a zone_rate_method, it might need a select dropdown, otherwise generic text -->
                                                <select v-if="setting.label === 'zone_rate_method'"
                                                    v-model="setting.value" class="form-control">
                                                    <option value="1">Weight</option>
                                                    <option value="2">Price</option>
                                                    <option value="3">Item</option>
                                                </select>
                                                <input v-else v-model="setting.value" type="text"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Weight Based Settings -->
                                <div v-if="shippingMethod.code === 'weight'" class="mt-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Weight Rates</h5>
                                        <button type="button" class="btn btn-sm btn-success" @click="addWeightRate">
                                            <i class="fas fa-plus"></i> Add Rate
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm align-middle">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Weight Label (e.g., Up to X kg)</th>
                                                    <th>Cost / Value</th>
                                                    <th style="width: 100px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(ws, index) in formData.weight_settings"
                                                    :key="ws.id || index">
                                                    <td>
                                                        <input v-model="ws.label" type="number" class="form-control"
                                                            required placeholder="Weight Limit" />
                                                    </td>
                                                    <td>
                                                        <input v-model="ws.value" type="number" step="0.01"
                                                            class="form-control" required placeholder="Cost" />
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            @click="removeWeightRate(index, ws)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr v-if="formData.weight_settings.length === 0">
                                                    <td colspan="3" class="text-center text-muted">No weight rates
                                                        defined. Click "Add Rate" to create one.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Zone Rate Settings -->
                                <div v-if="shippingMethod.code === 'zone_rate'" class="mt-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Geo Zone Rates</h5>
                                        <button type="button" class="btn btn-sm btn-success" @click="addZoneRate">
                                            <i class="fas fa-plus"></i> Add Zone Rate
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm align-middle">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th style="width: 40%">Geo Zone</th>
                                                    <th style="width: 30%">Up To Value (Weight/Price/Qty)</th>
                                                    <th style="width: 20%">Cost</th>
                                                    <th style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(zr, index) in formData.zone_rates" :key="zr.id || index">
                                                    <td>
                                                        <select v-model="zr.geo_zone_id" class="form-control" required>
                                                            <option value="" disabled>Select Geo Zone...</option>
                                                            <option v-for="zone in geoZones" :key="zone.id"
                                                                :value="zone.id">
                                                                {{ zone.geo_zone_name }}
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input v-model="zr.up_to_value" type="number" step="0.01"
                                                            class="form-control" required />
                                                    </td>
                                                    <td>
                                                        <input v-model="zr.cost" type="number" step="0.01"
                                                            class="form-control" required />
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            @click="removeZoneRate(index, zr)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr v-if="formData.zone_rates.length === 0">
                                                    <td colspan="4" class="text-center text-muted">No zone rates
                                                        defined. Click "Add Zone Rate" to create one.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" :disabled="submitting">
                                    <span v-if="submitting"><i class="fas fa-spinner fa-spin"></i> Saving...</span>
                                    <span v-else><i class="fas fa-save"></i> Save Settings</span>
                                </button>
                                <RouterLink :to="{ name: 'ShippingList' }" class="btn btn-secondary ml-2">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </RouterLink>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import BootstrapSwitch from '@/components/BootstrapSwitch.vue';
import axios from 'axios';
import { onMounted, reactive, ref, inject } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useToast } from '@/composables/useToast';

const toast = useToast();
const router = useRouter();
const route = useRoute();
const methodId = route.params.id;
const $swal = inject('$swal');

const loading = ref(true);
const submitting = ref(false);

const shippingMethod = ref(null);
const geoZones = ref([]);

const formData = reactive({
    status: 0,
    settings: [],
    weight_settings: [],
    zone_rates: []
});

const fetchSettings = async () => {
    try {
        const res = await axios.get(`/api/shipping-methods/${methodId}/settings`);
        const data = res.data.data;

        shippingMethod.value = data.shipping_method;
        formData.status = data.shipping_method.status;
        formData.settings = data.settings || [];

        if (data.shipping_method.code === 'weight') {
            formData.weight_settings = data.weight_settings || [];
        }

        if (data.shipping_method.code === 'zone_rate') {
            formData.zone_rates = data.zone_rates || [];
            geoZones.value = data.geo_zones || [];
        }

    } catch (error) {
        toast.error('Failed to load settings.');
        router.push({ name: 'ShippingList' });
    } finally {
        loading.value = false;
    }
};

const submitSettings = async () => {
    submitting.value = true;
    try {
        await axios.post(`/api/shipping-methods/${methodId}/settings`, formData);
        toast.success('Settings updated successfully!');
        router.push({ name: 'ShippingList' });
    } catch (error) {
        toast.validationError(error);
    } finally {
        submitting.value = false;
    }
};

// Weight Rate Handlers
const addWeightRate = () => {
    formData.weight_settings.push({ label: '', value: '' });
};

const removeWeightRate = async (index, ws) => {
    if (!ws.id) {
        formData.weight_settings.splice(index, 1);
        return;
    }

    const confirm = await $swal({
        title: 'Delete this weight rate?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
    });

    if (confirm.isConfirmed) {
        try {
            await axios.delete(`/api/shipping-methods/weight-rate/${ws.id}`);
            formData.weight_settings.splice(index, 1);
            toast.success('Weight rate deleted');
        } catch (e) {
            toast.error('Failed to delete weight rate');
        }
    }
};

// Zone Rate Handlers
const addZoneRate = () => {
    formData.zone_rates.push({ geo_zone_id: '', up_to_value: '', cost: '' });
};

const removeZoneRate = async (index, zr) => {
    if (!zr.id) {
        formData.zone_rates.splice(index, 1);
        return;
    }

    const confirm = await $swal({
        title: 'Delete this zone rate?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
    });

    if (confirm.isConfirmed) {
        try {
            await axios.delete(`/api/shipping-methods/zone-rate/${zr.id}`);
            formData.zone_rates.splice(index, 1);
            toast.success('Zone rate deleted');
        } catch (e) {
            toast.error('Failed to delete zone rate');
        }
    }
};

onMounted(() => {
    fetchSettings();
});
</script>
