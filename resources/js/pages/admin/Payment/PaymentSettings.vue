<template>
    <DashboardHeader :title="paymentMethod?.name ? `Settings: ${paymentMethod.name}` : 'Payment Settings'" />
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
                                    <!-- Status Toggle -->
                                    <div class="col-sm-12 col-md-5">
                                        <div class="card shadow-sm h-100 border-0 bg-light">
                                            <div
                                                class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                                <h6 class="font-weight-bold text-secondary mb-4"><i
                                                        class="fas fa-power-off mr-2"></i>Payment Method Status</h6>
                                                <BootstrapSwitch :modelValue="formData.status === 1"
                                                    @update:modelValue="val => formData.status = val ? 1 : 0" />
                                                <small class="text-muted mt-4">Enable or disable this payment method for
                                                    the
                                                    checkout page.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="col-sm-12 col-md-7 mt-4 mt-md-0">
                                        <div class="card shadow-sm h-100 border-0 bg-light">
                                            <div class="card-body">
                                                <h6 class="font-weight-bold text-secondary mb-3"><i
                                                        class="fas fa-image mr-2"></i>Payment Method Logo</h6>
                                                <Vue3Dropzone v-model="fileUpload" v-model:previews="previews"
                                                    mode="edit" :allowSelectOnPreview="true" />
                                                <small class="text-muted mt-2 d-block text-center">Upload a new logo to
                                                    replace the existing
                                                    one.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dynamic Settings List -->
                                <h5 class="mb-3">Gateway Configurations</h5>
                                <p class="text-muted text-sm">Define API keys, secrets, or instructions required for
                                    this payment method.</p>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="width: 30%;">Configuration Key</th>
                                                <th style="width: 60%;">Value</th>
                                                <th style="width: 10%;" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(setting, index) in settingsList" :key="index">
                                                <td>
                                                    <input v-model="setting.key" type="text" class="form-control"
                                                        required placeholder="e.g., api_key" />
                                                </td>
                                                <td>
                                                    <textarea v-if="setting.key === 'instruction'"
                                                        v-model="setting.value" class="form-control" rows="3" required
                                                        placeholder="Enter instructions..."></textarea>
                                                    <input v-else v-model="setting.value" type="text"
                                                        class="form-control" required placeholder="Enter value..." />
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        @click="removeSetting(index)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr v-if="settingsList.length === 0">
                                                <td colspan="3" class="text-center text-muted">No configurations
                                                    defined. Click "Add Config" to create one.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <button type="button" class="btn btn-sm btn-success mt-2" @click="addSetting">
                                    <i class="fas fa-plus"></i> Add Config
                                </button>

                            </div>
                            <div class="card-footer mt-4">
                                <button type="submit" class="btn btn-primary" :disabled="submitting">
                                    <span v-if="submitting"><i class="fas fa-spinner fa-spin"></i> Saving...</span>
                                    <span v-else><i class="fas fa-save"></i> Save Settings</span>
                                </button>
                                <RouterLink :to="{ name: 'PaymentList' }" class="btn btn-secondary ml-2">
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
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import axios from 'axios';
import { onMounted, reactive, ref, inject } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useToast } from '@/composables/useToast';
import { getImageUrl } from '../../../layouts/helpers/helpers';

const toast = useToast();
const router = useRouter();
const route = useRoute();
const methodId = route.params.id;
const $swal = inject('$swal');

const loading = ref(true);
const submitting = ref(false);

const paymentMethod = ref(null);
const settingsList = ref([]);

const fileUpload = ref([]);
const previews = ref([]);

const formData = reactive({
    status: 0,
    settings: {}
});

const fetchSettings = async () => {
    try {
        const res = await axios.get(`/api/payment-methods/${methodId}/settings`);
        const data = res.data.data;

        paymentMethod.value = data;
        formData.status = data.status;

        // Convert JSON object settings to array of key-value pairs for the UI
        if (data.settings && typeof data.settings === 'object') {
            for (const [key, value] of Object.entries(data.settings)) {
                settingsList.value.push({
                    id: Date.now() + Math.random(),
                    key: key,
                    value: value
                });
            }
        }

        if (data.image) {
            previews.value = [getImageUrl(data.image)];
        }
    } catch (error) {
        toast.error('Failed to load settings.');
        router.push({ name: 'PaymentList' });
    } finally {
        loading.value = false;
    }
};

const submitSettings = async () => {
    submitting.value = true;

    // Convert array back to object
    const finalSettings = {};
    settingsList.value.forEach(s => {
        if (s.key.trim()) {
            finalSettings[s.key.trim()] = s.value;
        }
    });

    const payload = new FormData();
    if (!previews.value[0]) {
        payload.append('remove_image', 1);
    }
    payload.append('status', formData.status);
    payload.append('settings', JSON.stringify(finalSettings));

    if (fileUpload.value && fileUpload.value[0] && fileUpload.value[0].file) {
        payload.append('image', fileUpload.value[0].file);
    }

    try {
        await axios.post(`/api/payment-methods/${methodId}/settings`, payload, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        toast.success('Settings updated successfully!');
        router.push({ name: 'PaymentList' });
    } catch (error) {
        toast.validationError(error);
    } finally {
        submitting.value = false;
    }
};

const addSetting = () => {
    settingsList.value.push({ key: '', value: '' });
};

const removeSetting = (index) => {
    settingsList.value.splice(index, 1);
};

onMounted(() => {
    fetchSettings();
});
</script>
