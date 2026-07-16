<template>
    <DashboardHeader title="Create Product">
        <div class="d-flex justify-content-end align-items-center">
            <button @click="submitForm" class="btn btn-primary" :disabled="loading">
                <i class="fas fa-save"></i> Save Product
            </button>
            <router-link :to="{ name: 'Products' }" class="btn btn-secondary ml-2">
                <i class="fas fa-times"></i> Cancel
            </router-link>
        </div>
    </DashboardHeader>

    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="product-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-general" data-toggle="pill" href="#custom-tabs-general" role="tab" aria-controls="custom-tabs-general" aria-selected="true">General</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-data" data-toggle="pill" href="#custom-tabs-data" role="tab" aria-controls="custom-tabs-data" aria-selected="false">Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-links" data-toggle="pill" href="#custom-tabs-links" role="tab" aria-controls="custom-tabs-links" aria-selected="false">Links</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-options" data-toggle="pill" href="#custom-tabs-options" role="tab" aria-controls="custom-tabs-options" aria-selected="false">Options</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-attributes" data-toggle="pill" href="#custom-tabs-attributes" role="tab" aria-controls="custom-tabs-attributes" aria-selected="false">Attributes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-specials" data-toggle="pill" href="#custom-tabs-specials" role="tab" aria-controls="custom-tabs-specials" aria-selected="false">Specials</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-others" data-toggle="pill" href="#custom-tabs-others" role="tab" aria-controls="custom-tabs-others" aria-selected="false">Others</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-images" data-toggle="pill" href="#custom-tabs-images" role="tab" aria-controls="custom-tabs-images" aria-selected="false">Images</a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body">
                        <form @submit.prevent="submitForm" id="productForm">
                            <div class="tab-content" id="product-tabs-content">
                                
                                <!-- General Tab -->
                                <div class="tab-pane fade show active" id="custom-tabs-general" role="tabpanel" aria-labelledby="tab-general">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Product Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" v-model="form.name" required />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Description</label>
                                            <RichTextEditor v-model="form.description" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Tags</label>
                                            <input type="text" class="form-control" v-model="form.tag" placeholder="Separate tags with commas" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Meta Title</label>
                                            <input type="text" class="form-control" v-model="form.meta_title" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Meta Description</label>
                                            <textarea class="form-control" rows="3" v-model="form.meta_description"></textarea>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Meta Keywords</label>
                                            <input type="text" class="form-control" v-model="form.meta_keyword" />
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Data Tab -->
                                <div class="tab-pane fade" id="custom-tabs-data" role="tabpanel" aria-labelledby="tab-data">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Model <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" v-model="form.model" required />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Product Code / SKU</label>
                                            <input type="text" class="form-control" v-model="form.product_code" />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Price <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control" v-model="form.price" required />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Quantity <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" v-model="form.quantity" required />
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Weight</label>
                                            <input type="number" step="0.0001" class="form-control" v-model="form.weight" />
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Length</label>
                                            <input type="number" step="0.0001" class="form-control" v-model="form.length" />
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Width</label>
                                            <input type="number" step="0.0001" class="form-control" v-model="form.width" />
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Height</label>
                                            <input type="number" step="0.0001" class="form-control" v-model="form.height" />
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Date Available</label>
                                            <input type="date" class="form-control" v-model="form.date_available" />
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Sort Order</label>
                                            <input type="number" class="form-control" v-model="form.sort_order" />
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Status</label>
                                            <select class="form-control" v-model="form.status">
                                                <option :value="1">Active</option>
                                                <option :value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Links Tab -->
                                <div class="tab-pane fade" id="custom-tabs-links" role="tabpanel" aria-labelledby="tab-links">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Product Featured</label>
                                            <select class="form-control" v-model="form.featured">
                                                <option :value="1">Yes</option>
                                                <option :value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Free Delivery</label>
                                            <select class="form-control" v-model="form.product_free_delivery">
                                                <option :value="1">Yes</option>
                                                <option :value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Brand</label>
                                            <select class="form-control" v-model="form.brand_id">
                                                <option value="">-- Select Brand --</option>
                                                <option v-for="b in brands" :key="b.id" :value="b.id">{{ b.name }}</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Multiple Categories Dropdown -->
                                        <div class="col-md-6 form-group">
                                            <label>Category <span class="text-danger">*</span></label>
                                            <Multiselect 
                                                v-model="form.category_ids" 
                                                :options="categoriesOptions" 
                                                mode="tags" 
                                                placeholder="Select Category" 
                                                searchable 
                                                class="multiselect-custom"
                                            />
                                        </div>

                                        <!-- Related Products -->
                                        <div class="col-md-6 form-group">
                                            <label>Related Product</label>
                                            <Multiselect 
                                                v-model="form.related_ids" 
                                                :options="productsOptions" 
                                                mode="tags" 
                                                placeholder="Select Related Product" 
                                                searchable 
                                                class="multiselect-custom"
                                            />
                                        </div>

                                        <!-- Bought Together Products -->
                                        <div class="col-md-6 form-group">
                                            <label>Bought Together Products</label>
                                            <Multiselect 
                                                v-model="form.bought_together_ids" 
                                                :options="productsOptions" 
                                                mode="tags" 
                                                placeholder="Select Bought Together Products" 
                                                searchable 
                                                class="multiselect-custom"
                                            />
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Options Tab -->
                                <div class="tab-pane fade" id="custom-tabs-options" role="tabpanel" aria-labelledby="tab-options">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>Add Option</label>
                                            <select class="form-control" v-model="selectedOptionToAdd" @change="addOptionRow">
                                                <option value="">-- Select Option to Add --</option>
                                                <option v-for="opt in availableOptions" :key="opt.id" :value="opt">{{ opt.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="table-responsive" v-if="form.options.length > 0">
                                        <table class="table table-bordered">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Option</th>
                                                    <th>Option Value</th>
                                                    <th>Quantity</th>
                                                    <th>Subtract</th>
                                                    <th>Price Prefix</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(prodOpt, index) in form.options" :key="index">
                                                    <td>{{ prodOpt.option_name }}</td>
                                                    <td>
                                                        <select class="form-control" v-model="prodOpt.option_value_id" required>
                                                            <option value="">-- Select Value --</option>
                                                            <option v-for="val in prodOpt.available_values" :key="val.id" :value="val.id">{{ val.name }}</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="prodOpt.quantity" required />
                                                    </td>
                                                    <td>
                                                        <select class="form-control" v-model="prodOpt.subtract">
                                                            <option :value="1">Yes</option>
                                                            <option :value="0">No</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" v-model="prodOpt.price_prefix">
                                                            <option value="+">+</option>
                                                            <option value="-">-</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control" v-model="prodOpt.price" />
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger" @click="removeOptionRow(index)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div v-else class="alert alert-info">No options added yet.</div>
                                </div>
                                
                                <!-- Attributes Tab -->
                                <div class="tab-pane fade" id="custom-tabs-attributes" role="tabpanel" aria-labelledby="tab-attributes">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Attribute Group</th>
                                                    <th>Attribute Name</th>
                                                    <th>Details / Text</th>
                                                    <th>Sort Order</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(attr, index) in form.attributes" :key="index">
                                                    <td>
                                                        <select class="form-control" v-model="attr.attribute_group_id" required>
                                                            <option value="">-- Select Group --</option>
                                                            <option v-for="g in attributeGroups" :key="g.id" :value="g.id">{{ g.name }}</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="attr.name" required />
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" v-model="attr.details" rows="2"></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="attr.sort_order" />
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger" @click="removeAttributeRow(index)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-primary" @click="addAttributeRow">
                                                            <i class="fas fa-plus"></i> Add
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <!-- Specials Tab -->
                                <div class="tab-pane fade" id="custom-tabs-specials" role="tabpanel" aria-labelledby="tab-specials">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>Special Price</label>
                                            <input type="number" step="0.01" class="form-control" v-model="form.special_price" placeholder="Special Price" />
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Start Date</label>
                                            <input type="date" class="form-control" v-model="form.special_start_date" />
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>End Date</label>
                                            <input type="date" class="form-control" v-model="form.special_end_date" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Others Tab -->
                                <div class="tab-pane fade" id="custom-tabs-others" role="tabpanel" aria-labelledby="tab-others">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Video Embedded Code</label>
                                            <input type="text" class="form-control" v-model="form.video" placeholder="Video code" />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Documentation Pdf</label>
                                            <Vue3Dropzone v-model="docPdfFile" :allowSelectOnPreview="true" />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Safety Pdf</label>
                                            <Vue3Dropzone v-model="safetyPdfFile" :allowSelectOnPreview="true" />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Instructions Pdf</label>
                                            <Vue3Dropzone v-model="instPdfFile" :allowSelectOnPreview="true" />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Description Image</label>
                                            <Vue3Dropzone v-model="descImageFile" :allowSelectOnPreview="true" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Images Tab -->
                                <div class="tab-pane fade" id="custom-tabs-images" role="tabpanel" aria-labelledby="tab-images">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>Default Main Image</label>
                                            <Vue3Dropzone v-model="mainImageFile" :allowSelectOnPreview="true" />
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <label>Multiple Gallery Images</label>
                                            <Vue3Dropzone v-model="galleryImageFiles" :multiple="true" :allowSelectOnPreview="true" selectFileStrategy="merge" />
                                        </div>
                                    </div>
                                </div>
                                
                             </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import RichTextEditor from '@/components/RichTextEditor.vue';
import { useRouter } from 'vue-router';
import { useToast } from '@/composables/useToast';
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';

const router = useRouter();
const toast = useToast();
const loading = ref(false);

const brands = ref([]);
const categories = ref([]);
const attributeGroups = ref([]);
const availableOptions = ref([]);
const allProducts = ref([]);

const selectedOptionToAdd = ref("");

const form = ref({
    name: '',
    model: '',
    product_code: '',
    brand_id: '',
    product_category_id: '',
    price: '',
    quantity: '',
    weight: 0,
    length: 0,
    width: 0,
    height: 0,
    status: 1,
    featured: 0,
    sort_order: 0,
    date_available: '',
    options: [],
    attributes: [],

    description: '',
    tag: '',
    meta_title: '',
    meta_description: '',
    meta_keyword: '',
    video: '',
    special_price: '',
    special_start_date: '',
    special_end_date: '',
    product_free_delivery: 0,
    category_ids: [],
    related_ids: [],
    bought_together_ids: []
});

const mainImageFile = ref(null);
const galleryImageFiles = ref([]);

const docPdfFile = ref(null);
const safetyPdfFile = ref(null);
const instPdfFile = ref(null);
const descImageFile = ref(null);

onMounted(async () => {
    try {
        const [resBrands, resCats, resAttrGroups, resOpts, resProducts] = await Promise.all([
            axios.get('/api/brands/all'),
            axios.get('/api/product-categories/all'),
            axios.get('/api/product-attribute-groups/all'),
            axios.get('/api/options/all'),
            axios.get('/api/products/all-dropdown')
        ]);
        brands.value = resBrands.data.data;
        categories.value = resCats.data.data;
        attributeGroups.value = resAttrGroups.data.data;
        availableOptions.value = resOpts.data.data;
        allProducts.value = resProducts.data.data;
    } catch (error) {
        toast.error("Failed to load dependencies.");
        console.error(error);
    }
});

// Helper function to build Category Path (Women > Jewelry > Necklaces & Chokers)
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
    return allProducts.value.map(p => ({
        value: p.id,
        label: `${p.name} (${p.model})`
    }));
});

const addOptionRow = () => {
    if (!selectedOptionToAdd.value) return;
    
    form.value.options.push({
        option_id: selectedOptionToAdd.value.id,
        option_name: selectedOptionToAdd.value.name,
        option_value_id: '',
        quantity: 0,
        subtract: 1,
        price_prefix: '+',
        price: 0,
        available_values: selectedOptionToAdd.value.option_values || []
    });
    
    selectedOptionToAdd.value = "";
};

const removeOptionRow = (index) => {
    form.value.options.splice(index, 1);
};

const addAttributeRow = () => {
    form.value.attributes.push({
        attribute_group_id: '',
        name: '',
        details: '',
        sort_order: 0
    });
};

const removeAttributeRow = (index) => {
    form.value.attributes.splice(index, 1);
};

const submitForm = async () => {
    if (!form.value.name || !form.value.model || form.value.price === '' || form.value.quantity === '') {
        toast.error("Please fill in all required fields.");
        return;
    }

    if (form.value.category_ids.length === 0) {
        toast.error("Please select at least one category.");
        return;
    }

    loading.value = true;
    
    const formData = new FormData();
    Object.keys(form.value).forEach(key => {
        if (['options', 'attributes', 'category_ids', 'related_ids', 'bought_together_ids'].includes(key)) {
            formData.append(key, JSON.stringify(form.value[key]));
        } else {
            if (form.value[key] !== null && form.value[key] !== '') {
                formData.append(key, form.value[key]);
            }
        }
    });

    if (form.value.category_ids.length > 0) {
        formData.append('product_category_id', form.value.category_ids[0]);
    }

    if (mainImageFile.value && mainImageFile.value[0]) {
        formData.append('main_image', mainImageFile.value[0].file);
    }

    if (galleryImageFiles.value && galleryImageFiles.value.length > 0) {
        galleryImageFiles.value.forEach((item, index) => {
            formData.append(`gallery_images[${index}]`, item.file);
        });
    }

    if (docPdfFile.value && docPdfFile.value[0]) formData.append('documentation_pdf', docPdfFile.value[0].file);
    if (safetyPdfFile.value && safetyPdfFile.value[0]) formData.append('safety_pdf', safetyPdfFile.value[0].file);
    if (instPdfFile.value && instPdfFile.value[0]) formData.append('instructions_pdf', instPdfFile.value[0].file);
    if (descImageFile.value && descImageFile.value[0]) formData.append('description_image', descImageFile.value[0].file);

    form.value.options.forEach((opt, index) => {
        formData.append(`options[${index}][option_id]`, opt.option_id);
        formData.append(`options[${index}][option_value_id]`, opt.option_value_id);
        formData.append(`options[${index}][quantity]`, opt.quantity);
        formData.append(`options[${index}][subtract]`, opt.subtract);
        formData.append(`options[${index}][price_prefix]`, opt.price_prefix);
        formData.append(`options[${index}][price]`, opt.price || 0);
    });

    form.value.attributes.forEach((attr, index) => {
        formData.append(`attributes[${index}][attribute_group_id]`, attr.attribute_group_id);
        formData.append(`attributes[${index}][name]`, attr.name);
        formData.append(`attributes[${index}][details]`, attr.details || '');
        formData.append(`attributes[${index}][sort_order]`, attr.sort_order || 0);
    });

    try {
        await axios.post('/api/products', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        toast.success("Product created successfully!");
        router.push({ name: 'Products' });
    } catch (error) {
        toast.validationError(error);
        loading.value = false;
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
