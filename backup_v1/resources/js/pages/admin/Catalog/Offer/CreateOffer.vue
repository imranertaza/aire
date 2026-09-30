<template>
    <DashboardHeader title="Create Offer" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab-basic">Basic Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab-targets">Offer Targets</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab-discount">Discount Settings</a>
                                </li>
                            </ul>
                        </div>

                        <form @submit.prevent="submitOffer" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="tab-content">

                                    <!-- Tab: Basic Info -->
                                    <div class="tab-pane active" id="tab-basic">
                                        <div class="row">
                                            <!-- Left Column -->
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Offer Name <span class="text-danger">*</span></label>
                                                    <input v-model="form.name" @input="autoSlug" type="text"
                                                        class="form-control" placeholder="e.g. Buy 1 Get 20% Off"
                                                        required />
                                                </div>
                                                <div class="form-group">
                                                    <label>Slug <span class="text-danger">*</span></label>
                                                    <input v-model="form.slug" type="text" class="form-control"
                                                        placeholder="auto-generated" required />
                                                </div>
                                                <div class="form-group">
                                                    <label>Alt Name</label>
                                                    <input v-model="form.alt_name" type="text" class="form-control"
                                                        placeholder="Alternate display name" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Description <span class="text-danger">*</span></label>
                                                    <textarea v-model="form.description" class="form-control" rows="4"
                                                        placeholder="Describe this offer..." required></textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Start Date <span class="text-danger">*</span></label>
                                                            <input v-model="form.start_date" type="datetime-local"
                                                                class="form-control" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Expire Date <span class="text-danger">*</span></label>
                                                            <input v-model="form.expire_date" type="datetime-local"
                                                                class="form-control" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Column -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Offer Key</label>
                                                    <select v-model="form.key" class="form-control">
                                                        <option value="general_offer">General Offer</option>
                                                        <option value="zone_based_offer">Zone Based Offer</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Offer Type <span class="text-danger">*</span></label>
                                                    <select v-model="form.offer_type" class="form-control">
                                                        <option value="1">Distinct (one offer at a time)</option>
                                                        <option value="2">Indistinct (can stack with other offers)</option>
                                                    </select>
                                                    <small class="text-muted">Distinct: customer can only use one offer
                                                        on the same item. Indistinct: offers can be combined.</small>
                                                </div>
                                                <div class="form-group">
                                                    <label>Banner Image</label>
                                                    <Vue3Dropzone v-model="bannerFiles" :multiple="false"
                                                        :maxFileSize="4" />
                                                    <small class="text-muted">Max File Size: 4MB (Image only)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab: Offer Targets -->
                                    <div class="tab-pane" id="tab-targets">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Offer On</label>
                                                    <select v-model="form.offer_on" class="form-control">
                                                        <option value="1">Product</option>
                                                        <option value="2">Amount</option>
                                                    </select>
                                                </div>
                                                <div class="form-group" v-if="form.offer_on == 2">
                                                    <label>Minimum Amount</label>
                                                    <input min="0" v-model="form.on_amount" type="number" step="0.01"
                                                        class="form-control" placeholder="0.00" />
                                                </div>
                                                <div class="form-group" v-if="form.offer_on == 1">
                                                    <label>Minimum Quantity</label>
                                                    <input min="0" v-model="form.qty" type="number" class="form-control"
                                                        placeholder="e.g. 1" />
                                                </div>

                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="allProducts" v-model="form.all_products" />
                                                        <label class="custom-control-label" for="allProducts">
                                                            Apply to All Products
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" v-if="!form.all_products">
                                                <div class="form-group">
                                                    <label>Specific Products</label>
                                                    <Multiselect v-model="form.products" :options="productsOptions"
                                                        mode="tags" :close-on-select="false"
                                                        placeholder="Select products" :searchable="true"
                                                        class="multiselect-custom" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Product Categories</label>
                                                    <Multiselect v-model="form.categories" :options="categoriesOptions"
                                                        mode="tags" :close-on-select="false"
                                                        placeholder="Select categories" :searchable="true"
                                                        class="multiselect-custom" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Brands</label>
                                                    <Multiselect v-model="form.brands" :options="brandsOptions"
                                                        mode="tags" :close-on-select="false" placeholder="Select brands"
                                                        :searchable="true" class="multiselect-custom" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab: Discount Settings -->
                                    <div class="tab-pane" id="tab-discount">
                                        <div class="row">
                                            <!-- General Offer Discount -->
                                            <div class="col-md-6" v-if="form.key === 'general_offer'">
                                                <div class="form-group">
                                                    <label>Discount On</label>
                                                    <select v-model="form.discount_on" class="form-control">
                                                        <option value="1">Product (per item)</option>
                                                        <option value="2">Product Amount (cart subtotal)</option>
                                                        <option value="3">Shipping Amount</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Discount Calculate On</label>
                                                    <select v-model="form.discount_calculate_on" class="form-control">
                                                        <option value="1">Percentage (%)</option>
                                                        <option value="2">Fixed Amount</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Discount Amount / Percentage <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input min="0" v-model="form.discount_amount" type="number" step="0.01"
                                                            class="form-control" placeholder="0.00" :required="form.key === 'general_offer'" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                {{ form.discount_calculate_on == 1 ? '%' : 'Flat' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Zone Based Offer Discounts -->
                                            <div class="col-md-12" v-if="form.key === 'zone_based_offer'">
                                                <div class="form-group" style="width: 50%;">
                                                    <label>Discount On</label>
                                                    <select v-model="form.discount_on" class="form-control">
                                                        <option value="1">Product (per item)</option>
                                                        <option value="2">Product Amount (cart subtotal)</option>
                                                        <option value="3">Shipping Amount</option>
                                                    </select>
                                                </div>
                                                
                                                <h5 class="mt-4 mb-3 border-bottom pb-2">Geographic Zones Discounts</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm align-middle">
                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th style="width: 30%;">Zone Name</th>
                                                                <th style="width: 40%;">Discount Amount</th>
                                                                <th style="width: 30%;">Discount Type</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="zone in geoZones" :key="zone.id">
                                                                <td class="font-weight-bold">{{ zone.geo_zone_name }}</td>
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <input min="0" v-model="zoneDiscounts[zone.id].discount_amount" 
                                                                               type="number" step="0.01" class="form-control" placeholder="0.00" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <select v-model="zoneDiscounts[zone.id].discount_calculate_on" class="form-control form-control-sm">
                                                                        <option value="1">Percentage (%)</option>
                                                                        <option value="2">Fixed Amount</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr v-if="geoZones.length === 0">
                                                                <td colspan="3" class="text-center text-muted">No active geographic zones found.</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <small class="form-text text-muted">Leave the amount empty or 0 to not offer a discount in that zone.</small>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" :disabled="submitting">
                                    <span v-if="submitting"><i class="fas fa-spinner fa-spin"></i> Saving...</span>
                                    <span v-else><i class="fas fa-save"></i> Create Offer</span>
                                </button>
                                <RouterLink :to="{ name: 'Offers' }" class="btn btn-secondary ml-2">
                                    <i class="fas fa-arrow-left"></i> Back
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
import axios from 'axios';
import { computed, onMounted, reactive, ref } from 'vue';
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import { useRouter } from 'vue-router';
import { useToast } from '@/composables/useToast';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
const toast = useToast();
const router = useRouter();
const submitting = ref(false);
const bannerFiles = ref([]);

const categories = ref([]);
const products = ref([]);
const brands = ref([]);
const geoZones = ref([]);
const shippingMethod = ref(null);
const zoneDiscounts = reactive({});

const form = reactive({
    name: '',
    slug: '',
    alt_name: '',
    key: 'general_offer',
    description: '',
    offer_type: '1',
    offer_on: '1',
    qty: '',
    on_amount: '',
    discount_on: '2',
    start_date: '',
    expire_date: '',
    discount_calculate_on: '1',
    discount_amount: '',
    products: [],
    categories: [],
    brands: [],
    all_products: false,
});

const autoSlug = () => {
    form.slug = form.name.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-');
};



const fetchRelations = async () => {
    try {
        const [catRes, prodRes, brandRes, zoneRes] = await Promise.all([
            axios.get('/api/product-categories/all'),
            axios.get('/api/products/all-dropdown'),
            axios.get('/api/brands/all'),
            axios.get('/api/offers/zone-data'),
        ]);
        categories.value = catRes.data.data;
        products.value = prodRes.data.data;
        brands.value = brandRes.data.data;
        geoZones.value = zoneRes.data.data.geoZones;
        shippingMethod.value = zoneRes.data.data.shippingMethod;

        // Initialize zoneDiscounts tracking object
        geoZones.value.forEach(zone => {
            zoneDiscounts[zone.id] = {
                discount_amount: '',
                discount_calculate_on: '1'
            };
        });
    } catch (error) {
        toast.error('Failed to load related data.');
    }
};

onMounted(fetchRelations);

const getCategoryPath = (cat, allCats) => {
    const path = [];
    let current = cat;
    while (current) {
        path.unshift(current.category_name);
        current = current.parent_id ? allCats.find(c => c.id === current.parent_id) : null;
    }
    return path.join(' > ');
};

const categoriesOptions = computed(() =>
    categories.value.map(cat => ({ value: cat.id, label: getCategoryPath(cat, categories.value) }))
);
const productsOptions = computed(() =>
    products.value.map(p => ({ value: p.id, label: p.name + (p.model ? ` (${p.model})` : '') }))
);
const brandsOptions = computed(() =>
    brands.value.map(b => ({ value: b.id, label: b.name }))
);

const submitOffer = async () => {
    submitting.value = true;
    try {
        const payload = new FormData();
        Object.entries(form).forEach(([key, value]) => {
            if (Array.isArray(value)) {
                value.forEach(v => payload.append(`${key}[]`, v));
            } else if (typeof value === 'boolean') {
                payload.append(key, value ? '1' : '0');
            } else if (value !== null && value !== '') {
                payload.append(key, value);
            }
        });
        if (bannerFiles.value.length > 0) {
            payload.append('banner', bannerFiles.value[0]);
        }

        if (form.key === 'zone_based_offer') {
            let index = 0;
            geoZones.value.forEach(zone => {
                const amount = zoneDiscounts[zone.id].discount_amount;
                if (amount !== '' && amount !== null && Number(amount) > 0) {
                    payload.append(`zone_discounts[${index}][geo_zone_id]`, zone.id);
                    payload.append(`zone_discounts[${index}][discount_calculate_on]`, zoneDiscounts[zone.id].discount_calculate_on);
                    payload.append(`zone_discounts[${index}][discount_amount]`, amount);
                    if (shippingMethod.value) {
                        payload.append(`zone_discounts[${index}][shipping_method_id]`, shippingMethod.value.id);
                    }
                    index++;
                }
            });
        }

        await axios.post('/api/offers', payload, { headers: { 'Content-Type': 'multipart/form-data' } });
        toast.success('Offer created successfully!');
        router.push({ name: 'Offers', query: { toast: 'Offer created successfully!' } });
    } catch (error) {
        toast.validationError(error);
    } finally {
        submitting.value = false;
    }
};
</script>

<style>
.multiselect-custom {
    --ms-border-color: #ced4da;
    --ms-border-width: 1px;
    --ms-radius: 4px;
    --ms-bg: #ffffff;
    --ms-tag-bg: #f1f2f6;
    --ms-tag-color: #2f3542;
    --ms-tag-radius: 4px;
}

.multiselect-custom .multiselect-tags-search {
    background-color: transparent !important;
}
</style>
