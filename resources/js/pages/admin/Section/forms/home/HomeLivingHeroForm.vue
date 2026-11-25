<template>
    <div class="home-living-hero-form living-hero-editor-wrapper">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header py-3 px-4 bg-white border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <div class="living-header-badge mr-3">
                        <i class="fas fa-wind"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 font-weight-bold text-dark">Living Hero — Featured Product Showcase</h4>
                        <p class="text-muted small mb-0">Manage headline, featured product selection, flying scroll animation, room background, and Buy Now CTA</p>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" @click="$emit('save')" class="btn btn-primary px-4 shadow-sm font-weight-bold" :disabled="saving">
                        <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving Changes...' : 'Save Living Hero' }}
                    </button>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row">
                    <!-- Left Column: Section Settings & Product Selection (7 cols) -->
                    <div class="col-xl-7 col-lg-6 col-md-12">
                        <!-- 1. Section Visibility & Badge -->
                        <div class="card setting-card mb-4 border shadow-none">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="setting-step-num mr-2">1</div>
                                    <label class="font-weight-bold text-dark mb-0">Module Status & Pill Badge</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-0">
                                            <label class="small font-weight-bold text-muted">Section Visibility <span class="text-danger">*</span></label>
                                            <select v-model="form.enabled" class="custom-select font-weight-bold" required>
                                                <option :value="1">Visible on Storefront (Enabled)</option>
                                                <option :value="0">Hidden from Storefront (Disabled)</option>
                                            </select>
                                            <small class="text-muted mt-1 d-block">Toggle whether this hero section is displayed.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-0">
                                            <label class="small font-weight-bold text-muted">Badge / Pill Tagline</label>
                                            <input v-model="form.badge" type="text" class="form-control"
                                                placeholder="e.g. INNOVATION" />
                                            <small class="text-muted mt-1 d-block">Displays as the category badge tag.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Headline & Marketing Description -->
                        <div class="card setting-card mb-4 border shadow-none">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="setting-step-num mr-2">2</div>
                                    <label class="font-weight-bold text-dark mb-0">Headline & Description Copy</label>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="small font-weight-bold text-muted">Section Title / Headline</label>
                                    <input v-model="form.title" type="text" class="form-control font-weight-500"
                                        placeholder="e.g. The Future of Pure Living" />
                                    <small class="text-muted mt-1 d-block">
                                        <i class="fas fa-info-circle mr-1 text-info"></i>
                                        Leave blank to automatically use the selected product's name.
                                    </small>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold text-muted">Marketing Description</label>
                                    <textarea v-model="form.description" rows="3" class="form-control"
                                        placeholder="e.g. Engineered for complete atmospheric transformation. Seamlessly integrates into modern living spaces with intelligent active air purification."></textarea>
                                    <small class="text-muted mt-1 d-block">
                                        <i class="fas fa-info-circle mr-1 text-info"></i>
                                        Leave blank to automatically use the product's catalog description.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Featured Product Selection -->
                        <div class="card setting-card mb-4 border shadow-none">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                    <div class="d-flex align-items-center">
                                        <div class="setting-step-num mr-2">3</div>
                                        <label class="font-weight-bold text-dark mb-0">Featured Product Selection</label>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary btn-xs" @click="selectFirstLivingProduct" :disabled="allProducts.length === 0">
                                            <i class="fas fa-magic mr-1"></i> Pick First Product
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-xs" @click="clearLivingProduct" :disabled="!form.product_id">
                                            <i class="fas fa-undo mr-1"></i> Use Storefront Default
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="small font-weight-bold text-muted">Search & Select Product:</label>
                                    <Multiselect
                                        v-model="form.product_id"
                                        :options="productSelectOptions"
                                        :searchable="true"
                                        placeholder="Type to search product from catalog..."
                                        class="multiselect-custom"
                                    />
                                    <small class="text-muted mt-1 d-block">
                                        The selected product supplies the animated cutout image, live price, and direct product detail URL. If none is picked, the latest active product is automatically featured.
                                    </small>
                                </div>

                                <!-- Live Product Preview Box -->
                                <div v-if="selectedLivingProduct" class="card bg-light border p-3 rounded-lg mb-0">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-white rounded p-2 border shadow-sm mr-3 text-center" style="width: 72px; height: 72px; flex-shrink: 0;">
                                            <img
                                                v-if="selectedLivingProduct.main_image"
                                                :src="getImageUrl(selectedLivingProduct.main_image)"
                                                alt="Product"
                                                style="max-width: 100%; max-height: 100%; object-fit: contain;"
                                            />
                                            <i v-else class="fas fa-box text-muted fa-2x mt-2"></i>
                                        </div>
                                        <div class="flex-grow-1 min-width-0">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="font-weight-bold text-dark text-truncate mr-2">
                                                    {{ selectedLivingProduct.name }}
                                                </div>
                                                <span class="badge badge-success px-2 py-1">
                                                    ${{ Number(selectedLivingProduct.price || 0).toFixed(2) }}
                                                </span>
                                            </div>
                                            <div class="small text-muted mb-1">
                                                <span>ID: #{{ selectedLivingProduct.id }}</span>
                                                <span v-if="selectedLivingProduct.model" class="ml-2">Model: <code>{{ selectedLivingProduct.model }}</code></span>
                                            </div>
                                            <div class="small text-primary">
                                                <i class="fas fa-check-circle mr-1"></i> Animated image source: <code>{{ selectedLivingProduct.main_image || 'No image' }}</code>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. CTA Button Text -->
                        <div class="card setting-card mb-4 border shadow-none">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="setting-step-num mr-2">4</div>
                                    <label class="font-weight-bold text-dark mb-0">Call-to-Action Button</label>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold text-muted">Button Label <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input v-model="form.button_text" type="text" class="form-control font-weight-500"
                                            placeholder="e.g. Buy Now" />
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-light text-muted font-weight-bold">
                                                — ${{ selectedLivingProduct ? Number(selectedLivingProduct.price || 0).toFixed(2) : '0.00' }}
                                            </span>
                                        </div>
                                    </div>
                                    <small class="text-muted mt-1 d-block">The button label dynamically appends the product price on storefront.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Room Background Image & Interactive Preview (5 cols) -->
                    <div class="col-xl-5 col-lg-6 col-md-12">
                        <!-- Living Room Background Image Upload -->
                        <div class="card setting-card mb-4 border shadow-none">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                    <div class="d-flex align-items-center">
                                        <div class="setting-step-num mr-2">5</div>
                                        <label class="font-weight-bold text-dark mb-0">Living Room Background <span class="text-danger">*</span></label>
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary btn-xs" @click="resetLivingBgToDefault" title="Reset to default scene">
                                        <i class="fas fa-undo mr-1"></i> Reset Default Scene
                                    </button>
                                </div>

                                <Vue3Dropzone :model-value="fileUpload" @update:model-value="$emit('update:fileUpload', $event)"
                                    :previews="previews" @update:previews="$emit('update:previews', $event)"
                                    mode="edit" :allowSelectOnPreview="true" :maxFiles="1" />
                                <div class="mt-2 small text-muted">
                                    <i class="fas fa-info-circle mr-1 text-info"></i>
                                    Recommended: <strong>1920 × 900px</strong> or <strong>1600 × 750px</strong> (Wide Landscape ~2.1:1 ratio).
                                    Use a high-resolution living room scene <em>without</em> an air purifier so the selected product can animate over it seamlessly.
                                </div>
                            </div>
                        </div>

                        <!-- Live Storefront Interactive Preview -->
                        <div class="card setting-card border shadow-none bg-dark text-white overflow-hidden">
                            <div class="card-header bg-dark border-secondary py-2 px-3 d-flex justify-content-between align-items-center">
                                <span class="small font-weight-bold text-uppercase text-white-50">
                                    <i class="fas fa-eye mr-1 text-warning"></i> Storefront Layout Preview
                                </span>
                                <span class="badge badge-light-teal px-2 py-1 font-weight-bold">
                                    GSAP ScrollTrigger Active
                                </span>
                            </div>
                            <div class="card-body p-3 text-center position-relative">
                                <!-- Living Room Mockup Box -->
                                <div class="mockup-living-room position-relative rounded overflow-hidden mb-3 border border-secondary" style="height: 200px; background: #1a1a1a;">
                                    <img
                                        :src="(previews && previews[0]) || (form.image ? getImageUrl(form.image) : '/themes/default/assets/img/background-without-product.png')"
                                        alt="Living Room Preview"
                                        style="width: 100%; height: 100%; object-fit: cover;"
                                    />
                                    <!-- Animated Product Overlay Preview -->
                                    <div class="mockup-product-overlay position-absolute" style="bottom: 12px; left: 50%; transform: translateX(-50%); width: 80px; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.5));">
                                        <img
                                            v-if="selectedLivingProduct && selectedLivingProduct.main_image"
                                            :src="getImageUrl(selectedLivingProduct.main_image)"
                                            alt="Purifier Overlay"
                                            style="max-width: 100%; height: auto;"
                                        />
                                    </div>
                                </div>

                                <h5 class="font-weight-bold text-white mb-2">
                                    {{ form.title || (selectedLivingProduct?.name) || 'The Future of Pure Living' }}
                                </h5>
                                <p class="text-white-50 small mb-3 px-2 line-clamp-2" style="font-size: 0.8rem; line-height: 1.4;">
                                    {{ form.description || 'Engineered for complete atmospheric transformation. Seamlessly integrates into modern living spaces with intelligent active air purification.' }}
                                </p>

                                <div class="btn btn-outline-light btn-sm rounded-pill px-4 font-weight-bold disabled" style="pointer-events: none; opacity: 0.95;">
                                    {{ form.button_text || 'Buy Now' }} — ${{ selectedLivingProduct ? Number(selectedLivingProduct.price || 0).toFixed(2) : '0.00' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="card-footer bg-light px-4 py-3 d-flex justify-content-between align-items-center">
                <router-link :to="{ name: 'Section' }" class="btn btn-outline-secondary px-3">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Sections
                </router-link>
                <div class="d-flex align-items-center">
                    <button type="button" @click="$emit('save')" class="btn btn-primary px-4 shadow-sm font-weight-bold" :disabled="saving">
                        <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving Changes...' : 'Save & Publish Living Hero' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
import { useToast } from '@/composables/useToast';
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
    fileUpload: {
        type: Array,
        default: () => [],
    },
    previews: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(['save', 'update:fileUpload', 'update:previews']);
const toast = useToast();

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

const selectedLivingProduct = computed(() => {
    if (!props.form.product_id) {
        return allProducts.value[0] || null;
    }
    return allProducts.value.find((p) => Number(p.id) === Number(props.form.product_id)) || null;
});

const selectFirstLivingProduct = () => {
    if (allProducts.value.length > 0) {
        props.form.product_id = Number(allProducts.value[0].id);
    }
};

const clearLivingProduct = () => {
    props.form.product_id = null;
};

const resetLivingBgToDefault = () => {
    props.form.image = 'themes/default/assets/img/background-without-product.png';
    emit('update:previews', ['/themes/default/assets/img/background-without-product.png']);
    emit('update:fileUpload', []);
    toast.info('Reset living room background to default.');
};

onMounted(() => {
    loadProducts();
});
</script>
