<template>
    <DashboardHeader title="Create Coupon" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create Coupon</h3>
                    </div>

                    <form @submit.prevent="submitCoupon">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coupon Name</label>
                                        <input v-model="form.name" type="text" class="form-control" placeholder="name" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Coupon Code</label>
                                        <input v-model="form.code" type="text" class="form-control" placeholder="Code" required />
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Discount On</label>
                                        <select v-model="form.discount_on" class="form-control">
                                            <option value="1">Product</option>
                                            <option value="2">Shipping</option>
                                        </select>
                                    </div>

                                    <!-- Shipping Methods Checkboxes -->
                                    <div class="form-group" v-show="form.discount_on == 2">
                                        <label>Shipping Method</label>
                                        <div class="form-group form-check" v-for="method in shippingMethods" :key="method.id">
                                            <input type="checkbox" v-model="form.shipping_methods" class="form-check-input" :id="'check_' + method.id" :value="method.id">
                                            <label class="form-check-label" :for="'check_' + method.id">{{ method.name }}</label>
                                        </div>
                                    </div>

                                    <!-- Categories & Products Multiselects (Only for Product discount) -->
                                    <template v-if="form.discount_on == 1">
                                        <div class="form-group">
                                            <label>Applicable Categories</label>
                                            <Multiselect
                                                v-model="form.categories"
                                                :options="categoriesOptions"
                                                mode="tags"
                                                :close-on-select="false"
                                                placeholder="Select Categories"
                                                :searchable="true"
                                                class="multiselect-custom"
                                            />
                                        </div>

                                        <div class="form-group">
                                            <label>Applicable Products</label>
                                            <Multiselect
                                                v-model="form.products"
                                                :options="productsOptions"
                                                mode="tags"
                                                :close-on-select="false"
                                                placeholder="Select Products"
                                                :searchable="true"
                                                class="multiselect-custom"
                                            />
                                        </div>
                                    </template>

                                    <div class="form-group">
                                        <label>Discount Type</label>
                                        <select v-model="form.discount_type" class="form-control">
                                            <option value="1">Percentage</option>
                                            <option value="2">Flat</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Discount</label>
                                        <input v-model="form.discount" type="text" class="form-control" placeholder="Discount" required />
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                        <RouterLink :to="{ name: 'Coupons' }" class="btn btn-danger ml-2">
                                            Back
                                        </RouterLink>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Total Useable</label>
                                        <input v-model="form.total_useable" type="text" class="form-control" placeholder="Total Useable" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Subscribed User</label>
                                        <select v-model="form.for_subscribed_user" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Registered User</label>
                                        <select v-model="form.for_registered_user" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input v-model="form.date_start" type="date" class="form-control" required />
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input v-model="form.date_end" type="date" class="form-control" required />
                                    </div>

                                    <div class="form-group mt-3">
                                        <label>Status</label>
                                        <select v-model="form.status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
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
import DashboardHeader from '@/components/DashboardHeader.vue';
import axios from 'axios';
import { onMounted, reactive, ref, computed } from 'vue';
import { useToast } from '@/composables/useToast';
import { useRouter } from 'vue-router';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';

const toast = useToast();
const router = useRouter();

const categories = ref([]);
const products = ref([]);
const shippingMethods = ref([]);

const form = reactive({
    name: '',
    code: '',
    discount_type: '1',
    discount_on: '1',
    discount: '',
    for_subscribed_user: '0',
    for_registered_user: '0',
    total_useable: '',
    date_start: '',
    date_end: '',
    status: '1',
    categories: [],
    products: [],
    shipping_methods: []
});

onMounted(() => {
    fetchRelations();
});

const fetchRelations = async () => {
    try {
        const catRes = await axios.get('/api/product-categories/all');
        categories.value = catRes.data.data;
        
        const prodRes = await axios.get('/api/products/all-dropdown');
        products.value = prodRes.data.data;

        const shipRes = await axios.get('/api/shipping-methods/all');
        shippingMethods.value = shipRes.data.data;
    } catch (error) {
        toast.error('Failed to load related data.');
    }
};

const getCategoryPath = (cat, allCats) => {
    const path = [];
    let current = cat;
    while (current) {
        path.unshift(current.category_name);
        if (current.parent_id) {
            current = allCats.find(c => c.id === current.parent_id);
        } else {
            current = null;
        }
    }
    return path.join(' > ');
};

const categoriesOptions = computed(() => {
    return categories.value.map(cat => ({
        value: cat.id,
        label: getCategoryPath(cat, categories.value)
    }));
});

const productsOptions = computed(() => {
    return products.value.map(p => ({
        value: p.id,
        label: p.name + (p.model ? ` (${p.model})` : '')
    }));
});

const submitCoupon = async () => {
    try {
        await axios.post('/api/coupons', form);
        toast.success('Coupon created successfully!');
        router.push({ name: 'Coupons' });
    } catch (error) {
        toast.validationError(error);
    }
};
</script>

<style>
/* Style override for vueform multiselect to match Bootstrap card form controls */
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
