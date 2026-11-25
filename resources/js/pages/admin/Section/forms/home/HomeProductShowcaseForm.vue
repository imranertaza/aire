<template>
    <div class="home-product-showcase-form">
        <!-- Section Header Settings -->
        <div class="card card-warning card-outline mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-sliders-h mr-1 text-warning"></i> Section Header Settings
                </h3>
                <span :class="['home_customer_favorites', 'customer_favorites'].includes(form.key) ? 'badge badge-primary text-white' : (['home_new_arrival', 'new_arrival'].includes(form.key) ? 'badge badge-info text-white' : 'badge badge-warning text-dark')" class="px-2 py-1 font-weight-bold">
                    <i :class="['home_customer_favorites', 'customer_favorites'].includes(form.key) ? 'fas fa-heart mr-1' : (['home_new_arrival', 'new_arrival'].includes(form.key) ? 'fas fa-box-open mr-1' : 'fas fa-star mr-1')"></i>
                    {{ ['home_customer_favorites', 'customer_favorites'].includes(form.key) ? 'Customers Favorites Showcase' : (['home_new_arrival', 'new_arrival'].includes(form.key) ? 'New Arrivals Showcase' : 'Best Selling Showcase') }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="font-weight-600">Pill Badge Text</label>
                            <input v-model="form.badge" type="text" class="form-control"
                                placeholder="e.g. Product" />
                            <small class="form-text text-muted">Displays as the rounded badge tag above the title.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-600">Section Title <span class="text-danger">*</span></label>
                            <input v-model="form.title" type="text" class="form-control"
                                placeholder="e.g. Best Selling Product" required />
                            <small class="form-text text-muted">Primary headline for the section.</small>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="font-weight-600">Subtitle / Tagline</label>
                            <input v-model="form.subtitle" type="text" class="form-control"
                                placeholder="e.g. Discover the top‑selling models trusted by thousands of families..." />
                            <small class="form-text text-muted">Supporting description below the headline.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Selector & Ordering Manager -->
        <div class="card card-primary card-outline mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-shopping-bag mr-1 text-primary"></i> Showcase Products ({{ form.product_ids?.length || 0 }} Selected)
                </h3>
                <div class="card-tools d-flex gap-2 align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-primary mr-2" @click="selectTopProducts" :disabled="allProducts.length === 0">
                        <i class="fas fa-magic mr-1"></i> Pick First 4 Products
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" @click="clearSelectedProducts" :disabled="!form.product_ids || form.product_ids.length === 0">
                        <i class="fas fa-trash-alt mr-1"></i> Clear Selection
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Search & Multiselect Dropdown -->
                <div class="form-group mb-4">
                    <label class="font-weight-600">Search & Select Products from Catalog:</label>
                    <Multiselect
                        v-model="form.product_ids"
                        mode="tags"
                        :options="productSelectOptions"
                        :searchable="true"
                        :close-on-select="false"
                        placeholder="Type product name or model code to search and select..."
                        class="multiselect-custom"
                    />
                    <small class="form-text text-muted mt-2">
                        <i class="fas fa-info-circle mr-1 text-info"></i>
                        Search by product name or model code. Items will display on the homepage in the exact sequence shown below. If no products are selected, the latest 4 active products are used automatically.
                    </small>
                </div>

                <!-- Selected Products Card Grid / Reorder List -->
                <div v-if="selectedProductsList.length > 0">
                    <label class="font-weight-600 mb-2">Display Order & Selected Items Preview:</label>
                    <div class="row">
                        <div
                            v-for="(prod, index) in selectedProductsList"
                            :key="'sel-prod-' + prod.id"
                            class="col-xl-3 col-lg-4 col-md-6 mb-3"
                        >
                            <div class="card h-100 border shadow-sm product-preview-box position-relative">
                                <!-- Top Order Bar -->
                                <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center bg-light">
                                    <span class="badge badge-primary font-weight-bold">Position #{{ index + 1 }}</span>
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-default btn-xs"
                                            :disabled="index === 0"
                                            @click="moveSelectedProduct(index, -1)"
                                            title="Move left / earlier"
                                        >
                                            <i class="fas fa-arrow-left"></i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-default btn-xs"
                                            :disabled="index === selectedProductsList.length - 1"
                                            @click="moveSelectedProduct(index, 1)"
                                            title="Move right / later"
                                        >
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-xs"
                                            @click="removeSelectedProduct(index)"
                                            title="Remove from section"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Product Thumbnail & Details -->
                                <div class="card-body p-3 text-center d-flex flex-column justify-content-between">
                                    <div class="mb-2">
                                        <img
                                            :src="prod.main_image ? getImageUrl(prod.main_image) : '/themes/default/assets/img/Air-Purify.png'"
                                            :alt="prod.name"
                                            class="img-fluid rounded mx-auto"
                                            style="max-height: 120px; object-fit: contain;"
                                        />
                                    </div>
                                    <div>
                                        <h6 class="font-weight-bold text-dark text-truncate mb-1" :title="prod.name">
                                            {{ prod.name }}
                                        </h6>
                                        <div class="text-muted small mb-2" v-if="prod.model">
                                            <code>{{ prod.model }}</code>
                                        </div>
                                        <div class="font-weight-bold text-primary">
                                            ${{ Number(prod.price || 0).toLocaleString() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State Notice -->
                <div v-else class="alert alert-light border text-center py-4 my-2">
                    <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                    <h6 class="font-weight-bold text-dark">No specific products selected yet</h6>
                    <p class="text-muted mb-3">
                        When empty, the homepage automatically defaults to showing the <strong>4 latest active products</strong>. Search and select products above to curate the exact products shown.
                    </p>
                    <button type="button" class="btn btn-sm btn-primary" @click="selectTopProducts" :disabled="allProducts.length === 0">
                        <i class="fas fa-plus mr-1"></i> Preload First 4 Products Now
                    </button>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="card-footer bg-light px-4 py-3 d-flex justify-content-between align-items-center">
                <router-link :to="{ name: 'Section' }" class="btn btn-outline-secondary px-3">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Sections
                </router-link>
                <div class="d-flex align-items-center">
                    <button type="button" @click="$emit('save')" class="btn btn-primary px-4 shadow-sm" :disabled="saving">
                        <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving Changes...' : 'Save & Publish Products' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
import { getImageUrl } from '@/layouts/helpers/helpers';

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    saving: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['save']);

const allProducts = ref([]);
const loadingProducts = ref(false);

const loadProducts = async () => {
    try {
        loadingProducts.value = true;
        const res = await axios.get('/api/products/all-dropdown?all=1');
        allProducts.value = res.data.data || [];
    } catch (err) {
        console.error('Failed to load products dropdown', err);
    } finally {
        loadingProducts.value = false;
    }
};

const productSelectOptions = computed(() => {
    return allProducts.value.map((p) => ({
        value: p.id,
        label: p.model ? `${p.name} (${p.model})` : p.name,
        price: p.price,
        image: p.main_image,
    }));
});

const selectedProductsList = computed(() => {
    if (!props.form.product_ids || !Array.isArray(props.form.product_ids)) return [];
    return props.form.product_ids.map((id) => {
        const found = allProducts.value.find((p) => Number(p.id) === Number(id));
        return found || { id: Number(id), name: `Product #${id}`, model: "", price: 0, main_image: "" };
    });
});

const moveSelectedProduct = (index, delta) => {
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= props.form.product_ids.length) return;
    const item = props.form.product_ids.splice(index, 1)[0];
    props.form.product_ids.splice(newIndex, 0, item);
};

const removeSelectedProduct = (index) => {
    props.form.product_ids.splice(index, 1);
};

const selectTopProducts = () => {
    props.form.product_ids = allProducts.value.slice(0, 4).map((p) => Number(p.id));
};

const clearSelectedProducts = () => {
    props.form.product_ids = [];
};

onMounted(() => {
    loadProducts();
});
</script>
