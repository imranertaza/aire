<template>
    <DashboardHeader title="Update Product">
        <div class="d-flex justify-content-end align-items-center">
            <button @click="submitForm" class="btn btn-primary" :disabled="loading">
                <i class="fas fa-save"></i> Update Product
            </button>
            <router-link :to="{ name: 'Products' }" class="btn btn-secondary ml-2">
                <i class="fas fa-times"></i> Cancel
            </router-link>
        </div>
    </DashboardHeader>

    <section v-if="!initialLoading">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="product-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-general" data-toggle="pill"
                                    href="#custom-tabs-general" role="tab" aria-controls="custom-tabs-general"
                                    aria-selected="true">General</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-data" data-toggle="pill" href="#custom-tabs-data" role="tab"
                                    aria-controls="custom-tabs-data" aria-selected="false">Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-links" data-toggle="pill" href="#custom-tabs-links"
                                    role="tab" aria-controls="custom-tabs-links" aria-selected="false">Links</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-options" data-toggle="pill" href="#custom-tabs-options"
                                    role="tab" aria-controls="custom-tabs-options" aria-selected="false">Options</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-filter-options" data-toggle="pill" href="#custom-tabs-filter-options"
                                    role="tab" aria-controls="custom-tabs-filter-options" aria-selected="false">Filter Options</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-attributes" data-toggle="pill"
                                    href="#custom-tabs-attributes" role="tab" aria-controls="custom-tabs-attributes"
                                    aria-selected="false">Attributes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-specials" data-toggle="pill" href="#custom-tabs-specials"
                                    role="tab" aria-controls="custom-tabs-specials" aria-selected="false">Specials</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-others" data-toggle="pill" href="#custom-tabs-others"
                                    role="tab" aria-controls="custom-tabs-others" aria-selected="false">Others</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-overview" data-toggle="pill"
                                    href="#custom-tabs-overview" role="tab" aria-controls="custom-tabs-overview"
                                    aria-selected="false">Overview</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-specifications" data-toggle="pill"
                                    href="#custom-tabs-specifications" role="tab" aria-controls="custom-tabs-specifications"
                                    aria-selected="false">Specifications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-features" data-toggle="pill"
                                    href="#custom-tabs-features" role="tab" aria-controls="custom-tabs-features"
                                    aria-selected="false">Features</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-technology" data-toggle="pill"
                                    href="#custom-tabs-technology" role="tab" aria-controls="custom-tabs-technology"
                                    aria-selected="false">Technology</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-applications" data-toggle="pill"
                                    href="#custom-tabs-applications" role="tab" aria-controls="custom-tabs-applications"
                                    aria-selected="false">Applications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-faqs" data-toggle="pill" href="#custom-tabs-faqs" role="tab"
                                    aria-controls="custom-tabs-faqs" aria-selected="false">FAQs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-images" data-toggle="pill" href="#custom-tabs-images"
                                    role="tab" aria-controls="custom-tabs-images" aria-selected="false">Images</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-landing" data-toggle="pill" href="#custom-tabs-landing"
                                    role="tab" aria-controls="custom-tabs-landing" aria-selected="false">
                                    <i class="fas fa-rocket text-primary mr-1"></i> Landing Page
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <form @submit.prevent="submitForm" id="productForm">
                            <div class="tab-content" id="product-tabs-content">

                                <!-- General Tab -->
                                <div class="tab-pane fade show active" id="custom-tabs-general" role="tabpanel"
                                    aria-labelledby="tab-general">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Product Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" v-model="form.name"
                                                @input="form.slug = generateSlug(form.name)" required />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Slug <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" v-model="form.slug" required />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Description</label>
                                            <RichTextEditor v-model="form.description" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Tags</label>
                                            <input type="text" class="form-control" v-model="form.tag"
                                                placeholder="Separate tags with commas" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Meta Title</label>
                                            <input type="text" class="form-control" v-model="form.meta_title" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Meta Description</label>
                                            <textarea class="form-control" rows="3"
                                                v-model="form.meta_description"></textarea>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Meta Keywords</label>
                                            <input type="text" class="form-control" v-model="form.meta_keyword" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Data Tab -->
                                <div class="tab-pane fade" id="custom-tabs-data" role="tabpanel"
                                    aria-labelledby="tab-data">
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
                                            <input min="0" type="number" step="0.01" class="form-control"
                                                v-model="form.price" required />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Quantity <span class="text-danger">*</span></label>
                                            <input min="0" type="number" class="form-control" v-model="form.quantity"
                                                required />
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Weight</label>
                                            <input min="0" type="number" step="0.0001" class="form-control"
                                                v-model="form.weight" />
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Length</label>
                                            <input min="0" type="number" step="0.0001" class="form-control"
                                                v-model="form.length" />
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Width</label>
                                            <input min="0" type="number" step="0.0001" class="form-control"
                                                v-model="form.width" />
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>Height</label>
                                            <input min="0" type="number" step="0.0001" class="form-control"
                                                v-model="form.height" />
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Date Available</label>
                                            <input type="date" class="form-control" v-model="form.date_available" />
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Sort Order</label>
                                            <input min="0" type="number" class="form-control"
                                                v-model="form.sort_order" />
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
                                <div class="tab-pane fade" id="custom-tabs-links" role="tabpanel"
                                    aria-labelledby="tab-links">
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
                                                <option v-for="b in brands" :key="b.id" :value="b.id">{{ b.name }}
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Multiple Categories Dropdown -->
                                        <div class="col-md-6 form-group">
                                            <label>Category <span class="text-danger">*</span></label>
                                            <Multiselect v-model="form.category_ids" :options="categoriesOptions"
                                                mode="tags" placeholder="Select Category" searchable
                                                class="multiselect-custom" />
                                        </div>

                                        <!-- Related Products -->
                                        <div class="col-md-6 form-group">
                                            <label>Related Product</label>
                                            <Multiselect v-model="form.related_ids" :options="productsOptions"
                                                mode="tags" placeholder="Select Related Product" searchable
                                                class="multiselect-custom" />
                                        </div>

                                        <!-- Bought Together Products -->
                                        <div class="col-md-6 form-group">
                                            <label>Bought Together Products</label>
                                            <Multiselect v-model="form.bought_together_ids" :options="productsOptions"
                                                mode="tags" placeholder="Select Bought Together Products" searchable
                                                class="multiselect-custom" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Options Tab -->
                                <div class="tab-pane fade" id="custom-tabs-options" role="tabpanel"
                                    aria-labelledby="tab-options">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>Add Option</label>
                                            <select class="form-control" v-model="selectedOptionToAdd"
                                                @change="addOptionRow">
                                                <option value="">-- Select Option to Add --</option>
                                                <option v-for="opt in availableOptions" :key="opt.id" :value="opt">{{
                                                    opt.name }}</option>
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
                                                        <select class="form-control" v-model="prodOpt.option_value_id"
                                                            required>
                                                            <option value="">-- Select Value --</option>
                                                            <option v-for="val in prodOpt.available_values"
                                                                :key="val.id" :value="val.id">{{ val.name }}</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input min="0" type="number" class="form-control"
                                                            v-model="prodOpt.quantity" required />
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
                                                        <input min="0" type="number" step="0.01" class="form-control"
                                                            v-model="prodOpt.price" />
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            @click="removeOptionRow(index)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div v-else class="alert alert-info">No options added yet.</div>
                                </div>

                                <!-- Filter Options Tab -->
                                <div class="tab-pane fade" id="custom-tabs-filter-options" role="tabpanel"
                                    aria-labelledby="tab-filter-options">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>Add Filter Option</label>
                                            <select class="form-control" v-model="selectedFilterOptionToAdd"
                                                @change="addFilterOptionRow">
                                                <option value="">-- Select Filter Option to Add --</option>
                                                <option v-for="opt in availableFilterOptions" :key="opt.id" :value="opt">{{
                                                    opt.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="table-responsive" v-if="form.filter_options.length > 0">
                                        <table class="table table-bordered">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Filter Option</th>
                                                    <th>Filter Option Value</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(fOpt, index) in form.filter_options" :key="index">
                                                    <td>{{ fOpt.filter_option_name }}</td>
                                                    <td>
                                                        <select class="form-control" v-model="fOpt.filter_option_value_id"
                                                            required>
                                                            <option value="">-- Select Value --</option>
                                                            <option v-for="val in fOpt.available_values"
                                                                :key="val.id" :value="val.id">{{ val.name }}</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            @click="removeFilterOptionRow(index)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div v-else class="alert alert-info">No filter options added yet.</div>
                                </div>

                                <!-- Attributes Tab -->
                                <div class="tab-pane fade" id="custom-tabs-attributes" role="tabpanel"
                                    aria-labelledby="tab-attributes">
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
                                                        <select class="form-control" v-model="attr.attribute_group_id"
                                                            required>
                                                            <option value="">-- Select Group --</option>
                                                            <option v-for="g in attributeGroups" :key="g.id"
                                                                :value="g.id">{{ g.name }}</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="attr.name"
                                                            required />
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" v-model="attr.details"
                                                            rows="2"></textarea>
                                                    </td>
                                                    <td>
                                                        <input min="0" type="number" class="form-control"
                                                            v-model="attr.sort_order" />
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            @click="removeAttributeRow(index)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                            @click="addAttributeRow">
                                                            <i class="fas fa-plus"></i> Add
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <!-- Specials Tab -->
                                <div class="tab-pane fade" id="custom-tabs-specials" role="tabpanel"
                                    aria-labelledby="tab-specials">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>Special Price</label>
                                            <input min="0" type="number" step="0.01" class="form-control"
                                                v-model="form.special_price" placeholder="Special Price" />
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
                                <div class="tab-pane fade" id="custom-tabs-others" role="tabpanel"
                                    aria-labelledby="tab-others">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Video Embedded Code</label>
                                            <input type="text" class="form-control" v-model="form.video"
                                                placeholder="Video code" />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Documentation Pdf</label>
                                            <Vue3Dropzone v-model="docPdfFile" v-model:previews="docPdfPreviews"
                                                mode="edit" :allowSelectOnPreview="true"
                                                @previewRemoved="() => handleFileRemoved('documentation_pdf')" />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Safety Pdf</label>
                                            <Vue3Dropzone v-model="safetyPdfFile" v-model:previews="safetyPdfPreviews"
                                                mode="edit" :allowSelectOnPreview="true"
                                                @previewRemoved="() => handleFileRemoved('safety_pdf')" />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Instructions Pdf</label>
                                            <Vue3Dropzone v-model="instPdfFile" v-model:previews="instPdfPreviews"
                                                mode="edit" :allowSelectOnPreview="true"
                                                @previewRemoved="() => handleFileRemoved('instructions_pdf')" />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Description Image</label>
                                            <Vue3Dropzone v-model="descImageFile" v-model:previews="descImagePreviews"
                                                mode="edit" :allowSelectOnPreview="true"
                                                @previewRemoved="() => handleFileRemoved('description_image')" />
                                            <small class="text-muted d-block mt-1">Recommended: 800 × 600px or 1200 × 800px</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Overview Tab (Section 1) -->
                                <div class="tab-pane fade" id="custom-tabs-overview" role="tabpanel"
                                    aria-labelledby="tab-overview">
                                    <div class="card card-outline card-primary mb-3">
                                        <div class="card-header py-2">
                                            <h6 class="card-title font-weight-bold mb-0">Overview Banner & Narrative (Section 1)</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label>Overview Title</label>
                                                    <input type="text" class="form-control" v-model="form.overview_title"
                                                        placeholder="e.g. Versatility Without Compromise" />
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label>Overview Narrative / Description</label>
                                                    <textarea class="form-control" rows="3" v-model="form.overview_description"
                                                        placeholder="Detailed narrative description for the overview section..."></textarea>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label>Overview Banner / Parallax Image</label>
                                                    <Vue3Dropzone v-model="overviewImageFile"
                                                        v-model:previews="overviewImagePreviews"
                                                        mode="edit" :allowSelectOnPreview="true"
                                                        @previewRemoved="() => handleFileRemoved('overview_image')" />
                                                    <small class="text-muted d-block mt-1">Recommended: 800 × 600px or 1000 × 700px (Landscape ~4:3)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-outline card-secondary mb-3">
                                        <div class="card-header py-2">
                                            <h6 class="card-title font-weight-bold mb-0">Overview Feature Cards (Section 1)</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Feature Card 1 -->
                                                <div class="col-md-6 border-right pr-md-4">
                                                    <h6 class="font-weight-bold text-primary mb-3"><i class="bi bi-shield-check mr-1"></i> Feature Card 01</h6>
                                                    <div class="form-group">
                                                        <label>Card 1 Icon (Bootstrap Icon Class)</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i :class="form.overview_feature1_icon || 'bi bi-shield-check'"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" v-model="form.overview_feature1_icon" placeholder="bi bi-shield-check" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Card 1 Title</label>
                                                        <input type="text" class="form-control" v-model="form.overview_feature1_title" placeholder="e.g. CRITICAL ENVIRONMENTS" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Card 1 Description</label>
                                                        <textarea class="form-control" rows="3" v-model="form.overview_feature1_desc" placeholder="e.g. Engineered for cleanrooms, laboratories, and precision fabrication facilities."></textarea>
                                                    </div>
                                                </div>

                                                <!-- Feature Card 2 -->
                                                <div class="col-md-6 pl-md-4">
                                                    <h6 class="font-weight-bold text-primary mb-3"><i class="bi bi-buildings mr-1"></i> Feature Card 02</h6>
                                                    <div class="form-group">
                                                        <label>Card 2 Icon (Bootstrap Icon Class)</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i :class="form.overview_feature2_icon || 'bi bi-buildings'"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" v-model="form.overview_feature2_icon" placeholder="bi bi-buildings" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Card 2 Title</label>
                                                        <input type="text" class="form-control" v-model="form.overview_feature2_title" placeholder="e.g. URBAN RESILIENCE" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Card 2 Description</label>
                                                        <textarea class="form-control" rows="3" v-model="form.overview_feature2_desc" placeholder="e.g. Protection against high-density metropolitan particulate and allergens."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Specifications Tab (Section 2) -->
                                <div class="tab-pane fade" id="custom-tabs-specifications" role="tabpanel"
                                    aria-labelledby="tab-specifications">
                                    <div class="card card-outline card-primary mb-3">
                                        <div class="card-header py-2">
                                            <h6 class="card-title font-weight-bold mb-0">Header & Exploded Technical Banner (Section 2)</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label>Badge / Tag</label>
                                                    <input type="text" class="form-control" v-model="form.specs_badge"
                                                        placeholder="e.g. SPECIFICATIONS" />
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <label>Main Title</label>
                                                    <input type="text" class="form-control" v-model="form.specs_title"
                                                        placeholder="e.g. Technical Specifications" />
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label>Main Description</label>
                                                    <textarea class="form-control" rows="2" v-model="form.specs_description"
                                                        placeholder="Laboratory-validated performance metrics..."></textarea>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label>Exploded View Parallax Background Image</label>
                                                    <Vue3Dropzone v-model="specsImageFile"
                                                        v-model:previews="specsImagePreviews"
                                                        mode="edit" :allowSelectOnPreview="true"
                                                        @previewRemoved="() => handleFileRemoved('specs_image')" />
                                                    <small class="text-muted d-block mt-1">Recommended: 1200 × 600px or 1024 × 686px (Technical diagram / exploded view)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-outline card-secondary mb-3">
                                        <div class="card-header py-2">
                                            <h6 class="card-title font-weight-bold mb-0">4-Column Stats Grid (Section 2)</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Stat 1 -->
                                                <div class="col-md-3 border-right">
                                                    <h6 class="font-weight-bold text-primary mb-2">Stat 01</h6>
                                                    <div class="form-group">
                                                        <label>Icon Class</label>
                                                        <input type="text" class="form-control" v-model="form.spec1_icon" placeholder="bi bi-shield-check" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Badge / Top Label</label>
                                                        <input type="text" class="form-control" v-model="form.spec1_badge" placeholder="e.g. FILTRATION" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Value</label>
                                                        <input type="text" class="form-control" v-model="form.spec1_value" placeholder="e.g. 99.97%" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Unit Suffix</label>
                                                        <input type="text" class="form-control" v-model="form.spec1_unit" placeholder="e.g. %" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bottom Description</label>
                                                        <input type="text" class="form-control" v-model="form.spec1_desc" placeholder="e.g. @ 0.3MM EFFICIENCY" />
                                                    </div>
                                                </div>

                                                <!-- Stat 2 -->
                                                <div class="col-md-3 border-right">
                                                    <h6 class="font-weight-bold text-primary mb-2">Stat 02</h6>
                                                    <div class="form-group">
                                                        <label>Icon Class</label>
                                                        <input type="text" class="form-control" v-model="form.spec2_icon" placeholder="bi bi-wind" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Badge / Top Label</label>
                                                        <input type="text" class="form-control" v-model="form.spec2_badge" placeholder="e.g. VELOCITY" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Value</label>
                                                        <input type="text" class="form-control" v-model="form.spec2_value" placeholder="e.g. 4.2" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Unit Suffix</label>
                                                        <input type="text" class="form-control" v-model="form.spec2_unit" placeholder="e.g. L/sec" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bottom Description</label>
                                                        <input type="text" class="form-control" v-model="form.spec2_desc" placeholder="e.g. MAX AIRFLOW RATE" />
                                                    </div>
                                                </div>

                                                <!-- Stat 3 -->
                                                <div class="col-md-3 border-right">
                                                    <h6 class="font-weight-bold text-primary mb-2">Stat 03</h6>
                                                    <div class="form-group">
                                                        <label>Icon Class</label>
                                                        <input type="text" class="form-control" v-model="form.spec3_icon" placeholder="bi bi-battery-charging" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Badge / Top Label</label>
                                                        <input type="text" class="form-control" v-model="form.spec3_badge" placeholder="e.g. ENDURANCE" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Value</label>
                                                        <input type="text" class="form-control" v-model="form.spec3_value" placeholder="e.g. 12" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Unit Suffix</label>
                                                        <input type="text" class="form-control" v-model="form.spec3_unit" placeholder="e.g. Hours" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bottom Description</label>
                                                        <input type="text" class="form-control" v-model="form.spec3_desc" placeholder="e.g. CONTINUOUS OPERATION" />
                                                    </div>
                                                </div>

                                                <!-- Stat 4 -->
                                                <div class="col-md-3">
                                                    <h6 class="font-weight-bold text-primary mb-2">Stat 04</h6>
                                                    <div class="form-group">
                                                        <label>Icon Class</label>
                                                        <input type="text" class="form-control" v-model="form.spec4_icon" placeholder="bi bi-box-seam" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Badge / Top Label</label>
                                                        <input type="text" class="form-control" v-model="form.spec4_badge" placeholder="e.g. MASS" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Value</label>
                                                        <input type="text" class="form-control" v-model="form.spec4_value" placeholder="e.g. 185" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Unit Suffix</label>
                                                        <input type="text" class="form-control" v-model="form.spec4_unit" placeholder="e.g. Grams" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bottom Description</label>
                                                        <input type="text" class="form-control" v-model="form.spec4_desc" placeholder="e.g. TOTAL SYSTEM WEIGHT" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Features Tab (Section 3) -->
                                <div class="tab-pane fade" id="custom-tabs-features" role="tabpanel"
                                    aria-labelledby="tab-features">
                                    <div class="card card-outline card-primary mb-3">
                                        <div class="card-header py-2">
                                            <h6 class="card-title font-weight-bold mb-0">Header & Parallax Banner (Section 3)</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label>Badge / Tag</label>
                                                    <input type="text" class="form-control" v-model="form.features_badge"
                                                        placeholder="e.g. FEATURES" />
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <label>Main Title</label>
                                                    <input type="text" class="form-control" v-model="form.features_title"
                                                        placeholder="e.g. Precision Engineered Details" />
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label>Main Description</label>
                                                    <textarea class="form-control" rows="2" v-model="form.features_description"
                                                        placeholder="The product is a masterclass in industrial design..."></textarea>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label>Features Parallax Background Image</label>
                                                    <Vue3Dropzone v-model="featuresImageFile"
                                                        v-model:previews="featuresImagePreviews"
                                                        mode="edit" :allowSelectOnPreview="true"
                                                        @previewRemoved="() => handleFileRemoved('features_image')" />
                                                    <small class="text-muted d-block mt-1">Recommended: 1400 × 600px or 1200 × 500px (Panoramic wide banner)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-outline card-secondary mb-3">
                                        <div class="card-header py-2">
                                            <h6 class="card-title font-weight-bold mb-0">3-Column Glassmorphism Feature Cards</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 border-right">
                                                    <h6 class="font-weight-bold text-primary mb-2">Card 01</h6>
                                                    <div class="form-group">
                                                        <label>Icon Class (e.g. bi bi-shield-lock)</label>
                                                        <input type="text" class="form-control" v-model="form.feature1_icon"
                                                            placeholder="bi bi-shield-lock" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" class="form-control" v-model="form.feature1_title"
                                                            placeholder="e.g. Medical-Grade Facial Seal" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control" rows="3" v-model="form.feature1_desc"
                                                            placeholder="Hypoallergenic LSR silicone ensures..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 border-right">
                                                    <h6 class="font-weight-bold text-primary mb-2">Card 02</h6>
                                                    <div class="form-group">
                                                        <label>Icon Class (e.g. bi bi-lightbulb)</label>
                                                        <input type="text" class="form-control" v-model="form.feature2_icon"
                                                            placeholder="bi bi-lightbulb" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" class="form-control" v-model="form.feature2_title"
                                                            placeholder="e.g. Active Feedback Ring" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control" rows="3" v-model="form.feature2_desc"
                                                            placeholder="Integrated LED halo provides..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6 class="font-weight-bold text-primary mb-2">Card 03</h6>
                                                    <div class="form-group">
                                                        <label>Icon Class (e.g. bi bi-funnel)</label>
                                                        <input type="text" class="form-control" v-model="form.feature3_icon"
                                                            placeholder="bi bi-funnel" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" class="form-control" v-model="form.feature3_title"
                                                            placeholder="e.g. Advanced HEPA Filtration" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control" rows="3" v-model="form.feature3_desc"
                                                            placeholder="Dual H13 Industrial filters capture..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Applications Tab -->
                                <div class="tab-pane fade" id="custom-tabs-applications" role="tabpanel"
                                    aria-labelledby="tab-applications">
                                    <div class="card card-outline card-info mb-3">
                                        <div class="card-header py-2">
                                            <h6 class="card-title font-weight-bold mb-0">Applications Section Header</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label>Section Title</label>
                                                    <input type="text" class="form-control" v-model="form.applications_title"
                                                        placeholder="e.g. Industrial Excellence, Personal Comfort" />
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label>Section Description</label>
                                                    <textarea class="form-control" rows="2" v-model="form.applications_description"
                                                        placeholder="Engineered to exceed safety standards in the most demanding environments..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Application Cards Grid</h5>
                                        <button type="button" class="btn btn-primary btn-sm" @click="addApplication">
                                            <i class="fas fa-plus mr-1"></i> Add Application
                                        </button>
                                    </div>
                                    <div v-if="!form.applications || form.applications.length === 0"
                                        class="alert alert-light border text-center py-4">
                                        <i class="fas fa-layer-group fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">No application environments added yet. Click "Add
                                            Application" above to configure use-case cards.</p>
                                    </div>
                                    <div v-else class="table-responsive">
                                        <table class="table table-bordered table-striped align-middle">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 4%;">#</th>
                                                    <th style="width: 18%;">Title <span class="text-danger">*</span></th>
                                                    <th style="width: 20%;">Description</th>
                                                    <th style="width: 12%;">Badge / Tag</th>
                                                    <th style="width: 22%; min-width: 170px;">Background Image</th>
                                                    <th style="width: 12%;">Layout Width</th>
                                                    <th style="width: 7%;">Sort Order</th>
                                                    <th style="width: 5%;" class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(appItem, index) in form.applications" :key="index">
                                                    <td class="text-center font-weight-bold">{{ index + 1 }}</td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="appItem.title"
                                                            placeholder="e.g. R&D Laboratories" />
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" rows="2"
                                                            v-model="appItem.description"
                                                            placeholder="Application description..."></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="appItem.badge"
                                                            placeholder="e.g. OPTIMIZED FOR DAILY COMMUTE" />
                                                    </td>
                                                    <td>
                                                        <div style="min-width: 150px;">
                                                            <Vue3Dropzone v-model="appItem.bg_image_file"
                                                                v-model:previews="appItem.bg_image_previews"
                                                                mode="edit" :allowSelectOnPreview="true"
                                                                @previewRemoved="() => { appItem.bg_image = ''; appItem.image = ''; }" />
                                                            <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Recommended: 800 × 400px or 1200 × 500px</small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" v-model="appItem.grid_width">
                                                            <option value="col-lg-8">2/3 Width (col-lg-8)</option>
                                                            <option value="col-lg-4">1/3 Width (col-lg-4)</option>
                                                            <option value="col-12">Full Width (col-12)</option>
                                                            <option value="col-lg-6">Half Width (col-lg-6)</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0" class="form-control"
                                                            v-model.number="appItem.sort_order" />
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            @click="removeApplication(index)"
                                                            title="Remove Application">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Technology Tab -->
                                <div class="tab-pane fade" id="custom-tabs-technology" role="tabpanel"
                                    aria-labelledby="tab-technology">
                                    <div class="card card-outline card-primary mb-3">
                                        <div class="card-header py-2">
                                            <h6 class="card-title font-weight-bold mb-0">Header & Parallax Banner</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label>Badge / Tag</label>
                                                    <input type="text" class="form-control" v-model="form.technology_badge"
                                                        placeholder="e.g. TECHNOLOGY" />
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <label>Main Title</label>
                                                    <input type="text" class="form-control" v-model="form.technology_title"
                                                        placeholder="e.g. The Physics of Pure Air" />
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label>Main Description</label>
                                                    <textarea class="form-control" rows="2" v-model="form.technology_description"
                                                        placeholder="Beyond simple filtration..."></textarea>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label>Technology Parallax Background Image</label>
                                                    <Vue3Dropzone v-model="technologyImageFile"
                                                        v-model:previews="technologyImagePreviews"
                                                        mode="edit" :allowSelectOnPreview="true"
                                                        @previewRemoved="() => handleFileRemoved('technology_image')" />
                                                    <small class="text-muted d-block mt-1">Recommended: 1400 × 700px or 1200 × 600px (Wide landscape banner)</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Parallax Glassmorphism Card Title</label>
                                                        <input type="text" class="form-control" v-model="form.technology_card_title"
                                                            placeholder="e.g. ACTIVE POSITIVE PRESSURE" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Parallax Glassmorphism Card Description</label>
                                                        <textarea class="form-control" rows="2" v-model="form.technology_card_description"
                                                            placeholder="Smart sensors detect inhalation resistance..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-outline card-secondary mb-3">
                                        <div class="card-header py-2">
                                            <h6 class="card-title font-weight-bold mb-0">3-Column Numbered Features Grid</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 border-right">
                                                    <h6 class="font-weight-bold text-primary mb-2">01 Feature</h6>
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" class="form-control" v-model="form.tech_feature1_title"
                                                            placeholder="e.g. TURBULENT FLOW CONTROL" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control" rows="2" v-model="form.tech_feature1_desc"
                                                            placeholder="Internal ducting is modeled using..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 border-right">
                                                    <h6 class="font-weight-bold text-primary mb-2">02 Feature</h6>
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" class="form-control" v-model="form.tech_feature2_title"
                                                            placeholder="e.g. PARTICULATE SENSING" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control" rows="2" v-model="form.tech_feature2_desc"
                                                            placeholder="Integrated laser-based sensors scan..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6 class="font-weight-bold text-primary mb-2">03 Feature</h6>
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" class="form-control" v-model="form.tech_feature3_title"
                                                            placeholder="e.g. BIO-MECHANICAL FIT" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control" rows="2" v-model="form.tech_feature3_desc"
                                                            placeholder="The structural chassis is crafted from..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQs Tab -->
                                <div class="tab-pane fade" id="custom-tabs-faqs" role="tabpanel"
                                    aria-labelledby="tab-faqs">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Product Frequently Asked Questions</h5>
                                        <button type="button" class="btn btn-primary btn-sm" @click="addFaq">
                                            <i class="fas fa-plus mr-1"></i> Add FAQ
                                        </button>
                                    </div>
                                    <div v-if="!form.faqs || form.faqs.length === 0"
                                        class="alert alert-light border text-center py-4">
                                        <i class="fas fa-question-circle fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">No FAQs added for this product yet. Click "Add FAQ"
                                            above to add one.</p>
                                    </div>
                                    <div v-else class="table-responsive">
                                        <table class="table table-bordered table-striped align-middle">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 5%;">#</th>
                                                    <th style="width: 35%;">Question <span class="text-danger">*</span>
                                                    </th>
                                                    <th style="width: 45%;">Answer <span class="text-danger">*</span>
                                                    </th>
                                                    <th style="width: 10%;">Sort Order</th>
                                                    <th style="width: 5%;" class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(faq, index) in form.faqs" :key="index">
                                                    <td class="text-center font-weight-bold">{{ index + 1 }}</td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="faq.question"
                                                            placeholder="e.g. How long do filters last?" />
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" rows="2" v-model="faq.answer"
                                                            placeholder="Enter detailed answer..."></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0" class="form-control"
                                                            v-model.number="faq.sort_order" />
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            @click="removeFaq(index)" title="Remove FAQ">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Images Tab -->
                                <div class="tab-pane fade" id="custom-tabs-images" role="tabpanel"
                                    aria-labelledby="tab-images">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>Default Main Image</label>
                                            <Vue3Dropzone v-model="mainImageFile" v-model:previews="mainImagePreviews"
                                                mode="edit" :allowSelectOnPreview="true" />
                                            <small class="text-muted d-block mt-1">Recommended: 800 × 800px or 1000 × 1000px (1:1 Square, clean/transparent background for interactive zoom)</small>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <label>Multiple Gallery Images</label>
                                            <Vue3Dropzone v-model="galleryImageFiles" v-model:previews="galleryPreviews"
                                                mode="edit" :multiple="true" :allowSelectOnPreview="true"
                                                selectFileStrategy="merge" @previewRemoved="handlePreviewRemoved" />
                                            <small class="text-muted d-block mt-1">Recommended: 800 × 800px or 1000 × 1000px (1:1 Square, matching main image)</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Landing Page Tab -->
                                <div class="tab-pane fade" id="custom-tabs-landing" role="tabpanel"
                                    aria-labelledby="tab-landing">
                                    <!-- Enable Toggle Header -->
                                    <div class="card mb-4 border-primary">
                                        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                            <div>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="toggleLanding"
                                                        v-model="form.landing_enabled">
                                                    <label class="custom-control-label font-weight-bold fs-5 text-dark" for="toggleLanding">
                                                        Enable Dedicated Landing Page
                                                    </label>
                                                </div>
                                                <small class="text-muted d-block mt-1">
                                                    When enabled, a high-converting, animated showcase page is activated at
                                                    <code>/product-landing/{{ form.slug || productId }}</code>.
                                                    The Bottom CTA automatically synchronizes with the Hero section.
                                                </small>
                                            </div>
                                            <div v-if="form.landing_enabled" class="d-flex align-items-center">
                                                <a :href="`/product-landing/${form.slug || productId}`" target="_blank"
                                                    class="btn btn-outline-primary btn-sm px-3 py-2 font-weight-bold">
                                                    <i class="fas fa-external-link-alt mr-1"></i> View Live Landing Page
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-show="form.landing_enabled">
                                        <!-- 1. HERO SECTION -->
                                        <div class="card card-outline card-secondary mb-4">
                                            <div class="card-header bg-light">
                                                <h5 class="card-title font-weight-bold mb-0">
                                                    <i class="fas fa-flag-checkered text-primary mr-2"></i> 1. Hero Section (Reused by Bottom CTA)
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label>Model Tag / Badge</label>
                                                        <input type="text" class="form-control" v-model="form.landing_hero_tag"
                                                            placeholder="e.g. AIRE Pro S1" />
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <label>Hero Title / Main Heading</label>
                                                        <input type="text" class="form-control" v-model="form.landing_hero_title"
                                                            placeholder="e.g. Atmospheric Mastery." />
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Hero Subtitle / Description</label>
                                                        <textarea class="form-control" rows="3" v-model="form.landing_hero_description"
                                                            placeholder="Experience revolutionary synthesis technology designed to purify every molecule..."></textarea>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Action Button Text</label>
                                                        <input type="text" class="form-control" v-model="form.landing_hero_button_text"
                                                            placeholder="e.g. More Details -" />
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Action Button URL</label>
                                                        <input type="text" class="form-control" v-model="form.landing_hero_button_url"
                                                            placeholder="e.g. /products/... or leave blank for default" />
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Hero & Bottom CTA Image</label>
                                                        <Vue3Dropzone v-model="landingHeroImageFile" v-model:previews="landingHeroPreviews"
                                                            mode="edit" :allowSelectOnPreview="true"
                                                            @previewRemoved="() => handleFileRemoved('landing_hero_image')" />
                                                        <small class="text-muted d-block mt-1">Recommended: PNG with transparent background (1000 × 1000px)</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 2. SCIENCE OF SYNTHESIS SECTION -->
                                        <div class="card card-outline card-secondary mb-4">
                                            <div class="card-header bg-light">
                                                <h5 class="card-title font-weight-bold mb-0">
                                                    <i class="fas fa-atom text-info mr-2"></i> 2. Science of Synthesis Section
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label>Section Tag</label>
                                                        <input type="text" class="form-control" v-model="form.landing_science_tag"
                                                            placeholder="e.g. SCIENCE OF SYNTHESIS" />
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <label>Section Title (Line breaks supported)</label>
                                                        <textarea rows="2" class="form-control" v-model="form.landing_science_title"
                                                            placeholder="e.g. Extraordinary&#10;from within."></textarea>
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Section Description</label>
                                                        <textarea class="form-control" rows="3" v-model="form.landing_science_description"
                                                            placeholder="Every layer is engineered for peak performance..."></textarea>
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label>Stat 1 Value</label>
                                                        <input type="text" class="form-control" v-model="form.landing_science_stat1_value"
                                                            placeholder="e.g. 99.99%" />
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label>Stat 1 Label</label>
                                                        <input type="text" class="form-control" v-model="form.landing_science_stat1_label"
                                                            placeholder="e.g. PARTICLE REMOVAL" />
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label>Stat 2 Value</label>
                                                        <input type="text" class="form-control" v-model="form.landing_science_stat2_value"
                                                            placeholder="e.g. UV-C" />
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label>Stat 2 Label</label>
                                                        <input type="text" class="form-control" v-model="form.landing_science_stat2_label"
                                                            placeholder="e.g. STERILIZATION" />
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Science Card Internal Image</label>
                                                        <Vue3Dropzone v-model="landingScienceImageFile" v-model:previews="landingSciencePreviews"
                                                            mode="edit" :allowSelectOnPreview="true"
                                                            @previewRemoved="() => handleFileRemoved('landing_science_image')" />
                                                    </div>
                                                </div>

                                                <!-- Science Feature Highlights -->
                                                <div class="mt-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <label class="font-weight-bold mb-0">Feature Highlights List</label>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" @click="addScienceFeature">
                                                            <i class="fas fa-plus mr-1"></i> Add Highlight
                                                        </button>
                                                    </div>
                                                    <div v-for="(feat, fIdx) in form.landing_science_features" :key="fIdx"
                                                        class="border rounded p-3 mb-2 bg-light">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-4 form-group mb-md-0">
                                                                <input type="text" class="form-control" v-model="feat.title"
                                                                    placeholder="Highlight Title" />
                                                            </div>
                                                            <div class="col-md-7 form-group mb-md-0">
                                                                <input type="text" class="form-control" v-model="feat.desc"
                                                                    placeholder="Highlight Description" />
                                                            </div>
                                                            <div class="col-md-1 text-center">
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    @click="removeScienceFeature(fIdx)">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 3. LIFESTYLE INTEGRATION SECTION -->
                                        <div class="card card-outline card-secondary mb-4">
                                            <div class="card-header bg-light">
                                                <h5 class="card-title font-weight-bold mb-0">
                                                    <i class="fas fa-couch text-success mr-2"></i> 3. Lifestyle Integration Section
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label>Section Tag</label>
                                                        <input type="text" class="form-control" v-model="form.landing_lifestyle_tag"
                                                            placeholder="e.g. LIFESTYLE" />
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <label>Section Title (Line breaks supported)</label>
                                                        <textarea rows="2" class="form-control" v-model="form.landing_lifestyle_title"
                                                            placeholder="e.g. Seamless&#10;Integration."></textarea>
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control" rows="3" v-model="form.landing_lifestyle_description"
                                                            placeholder="Designed for your life, not just your air..."></textarea>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Button Text</label>
                                                        <input type="text" class="form-control" v-model="form.landing_lifestyle_button_text"
                                                            placeholder="e.g. More Details &rarr;" />
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Button URL</label>
                                                        <input type="text" class="form-control" v-model="form.landing_lifestyle_button_url"
                                                            placeholder="e.g. /category/... or #" />
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Lifestyle Wide Background Image</label>
                                                        <Vue3Dropzone v-model="landingLifestyleImageFile" v-model:previews="landingLifestylePreviews"
                                                            mode="edit" :allowSelectOnPreview="true"
                                                            @previewRemoved="() => handleFileRemoved('landing_lifestyle_image')" />
                                                        <small class="text-muted d-block mt-1">Recommended: Wide Banner (1920 × 900px)</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 4. MEDICAL-GRADE PRECISION FILTER SECTION -->
                                        <div class="card card-outline card-secondary mb-4">
                                            <div class="card-header bg-light">
                                                <h5 class="card-title font-weight-bold mb-0">
                                                    <i class="fas fa-shield-virus text-warning mr-2"></i> 4. Medical-Grade Precision Filter Tech Section
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label>Section Heading</label>
                                                        <input type="text" class="form-control" v-model="form.landing_filter_tech_title"
                                                            placeholder="e.g. Medical-grade Precision." />
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Badge Overlay Text</label>
                                                        <input type="text" class="form-control" v-model="form.landing_filter_tech_badge_text"
                                                            placeholder="e.g. Advanced micro-fiber weaving..." />
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Section Subtitle / Description</label>
                                                        <textarea class="form-control" rows="2" v-model="form.landing_filter_tech_description"
                                                            placeholder="HEPA H13 Filter Technology. From microscopic particles..."></textarea>
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Macro Filter Image</label>
                                                        <Vue3Dropzone v-model="landingFilterImageFile" v-model:previews="landingFilterPreviews"
                                                            mode="edit" :allowSelectOnPreview="true"
                                                            @previewRemoved="() => handleFileRemoved('landing_filter_tech_image')" />
                                                        <small class="text-muted d-block mt-1">Recommended: 1400 × 600px</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 5. PRECISION ENGINEERING SPECS SECTION -->
                                        <div class="card card-outline card-secondary mb-4">
                                            <div class="card-header bg-light">
                                                <h5 class="card-title font-weight-bold mb-0">
                                                    <i class="fas fa-sliders-h text-danger mr-2"></i> 5. Precision Engineering Specs Section
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label>Section Heading</label>
                                                        <input type="text" class="form-control" v-model="form.landing_specs_title"
                                                            placeholder="e.g. Precision Engineering." />
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Section Subtitle</label>
                                                        <input type="text" class="form-control" v-model="form.landing_specs_subtitle"
                                                            placeholder="e.g. The definitive standard for air purification." />
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>More Details Link Text</label>
                                                        <input type="text" class="form-control" v-model="form.landing_specs_button_text"
                                                            placeholder="e.g. More Details &rarr;" />
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>More Details Link URL</label>
                                                        <input type="text" class="form-control" v-model="form.landing_specs_button_url"
                                                            placeholder="e.g. /products/... or #" />
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label>Default Exploded 3D Image</label>
                                                        <Vue3Dropzone v-model="landingSpecsImageFile" v-model:previews="landingSpecsPreviews"
                                                            mode="edit" :allowSelectOnPreview="true"
                                                            @previewRemoved="() => handleFileRemoved('landing_specs_image')" />
                                                        <small class="text-muted d-block mt-1">Recommended: 600 × 600px square image</small>
                                                    </div>
                                                </div>

                                                <!-- Interactive Spec Groups Builder -->
                                                <div class="mt-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="font-weight-bold mb-0">Interactive Spec Groups (Scroll Image Swapper)</h6>
                                                        <button type="button" class="btn btn-sm btn-primary" @click="addSpecGroup">
                                                            <i class="fas fa-plus mr-1"></i> Add Spec Group
                                                        </button>
                                                    </div>

                                                    <div v-for="(group, gIdx) in form.landing_specs_groups" :key="gIdx"
                                                        class="border rounded p-3 mb-4 bg-white shadow-sm">
                                                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                                            <h6 class="font-weight-bold text-dark mb-0">
                                                                Group #{{ gIdx + 1 }}: {{ group.title || 'Untitled Group' }}
                                                            </h6>
                                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                                @click="removeSpecGroup(gIdx)">
                                                                <i class="fas fa-trash-alt mr-1"></i> Remove Group
                                                            </button>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-3 form-group">
                                                                <label>Group Tag</label>
                                                                <input type="text" class="form-control" v-model="group.tag"
                                                                    placeholder="e.g. 01 / FILTRATION" />
                                                            </div>
                                                            <div class="col-md-4 form-group">
                                                                <label>Group Title</label>
                                                                <input type="text" class="form-control" v-model="group.title"
                                                                    placeholder="e.g. Multi-Stage Synthesis" />
                                                            </div>
                                                            <div class="col-md-5 form-group">
                                                                <label>Dynamic Scroll Image URL</label>
                                                                <input type="text" class="form-control" v-model="group.image"
                                                                    placeholder="URL or image path for 3D swap on scroll" />
                                                            </div>
                                                        </div>

                                                        <!-- Spec Key-Value Table -->
                                                        <label class="font-weight-bold mt-2">Specification Rows:</label>
                                                        <table class="table table-sm table-bordered">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th style="width: 45%;">Specification Label</th>
                                                                    <th style="width: 45%;">Value</th>
                                                                    <th style="width: 10%; text-align: center;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(item, rIdx) in group.items" :key="rIdx">
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm"
                                                                            v-model="item.label" placeholder="e.g. CADR (Smoke)" />
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm"
                                                                            v-model="item.value" placeholder="e.g. 580 m³/h" />
                                                                    </td>
                                                                    <td class="text-center align-middle">
                                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                                            @click="removeSpecRow(gIdx, rIdx)">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="3" class="text-right">
                                                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                                                            @click="addSpecRow(gIdx)">
                                                                            <i class="fas fa-plus mr-1"></i> Add Spec Row
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
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
    <div v-else class="text-center mt-5">
        <i class="fas fa-spinner fa-spin fa-3x"></i>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import RichTextEditor from '@/components/RichTextEditor.vue';
import { useRouter, useRoute } from 'vue-router';
import { useToast } from '@/composables/useToast';
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
import { getImageCacheUrl, generateSlug } from '../../../../layouts/helpers/helpers';

const router = useRouter();
const route = useRoute();
const toast = useToast();
const loading = ref(false);
const initialLoading = ref(true);

const productId = route.params.id;

const brands = ref([]);
const categories = ref([]);
const attributeGroups = ref([]);
const availableOptions = ref([]);
const availableFilterOptions = ref([]);
const allProducts = ref([]);

const selectedOptionToAdd = ref("");
const selectedFilterOptionToAdd = ref("");

const form = ref({
    name: '',
    slug: '',
    model: '',
    product_code: '',
    brand_id: '',
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
    filter_options: [],
    attributes: [],
    faqs: [],
    applications: [],

    specs_badge: '',
    specs_title: '',
    specs_description: '',
    spec1_icon: 'bi bi-shield-check',
    spec1_badge: 'FILTRATION',
    spec1_value: '',
    spec1_unit: '',
    spec1_desc: '',
    spec2_icon: 'bi bi-wind',
    spec2_badge: 'VELOCITY',
    spec2_value: '',
    spec2_unit: '',
    spec2_desc: '',
    spec3_icon: 'bi bi-battery-charging',
    spec3_badge: 'ENDURANCE',
    spec3_value: '',
    spec3_unit: '',
    spec3_desc: '',
    spec4_icon: 'bi bi-box-seam',
    spec4_badge: 'MASS',
    spec4_value: '',
    spec4_unit: '',
    spec4_desc: '',

    features_badge: '',
    features_title: '',
    features_description: '',
    feature1_icon: 'bi bi-shield-lock',
    feature1_title: '',
    feature1_desc: '',
    feature2_icon: 'bi bi-lightbulb',
    feature2_title: '',
    feature2_desc: '',
    feature3_icon: 'bi bi-funnel',
    feature3_title: '',
    feature3_desc: '',

    applications_title: '',
    applications_description: '',

    technology_badge: '',
    technology_title: '',
    technology_description: '',
    technology_card_title: '',
    technology_card_description: '',
    tech_feature1_title: '',
    tech_feature1_desc: '',
    tech_feature2_title: '',
    tech_feature2_desc: '',
    tech_feature3_title: '',
    tech_feature3_desc: '',

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
    bought_together_ids: [],

    // Landing Page Fields
    landing_enabled: false,
    landing_hero_tag: '',
    landing_hero_title: '',
    landing_hero_description: '',
    landing_hero_button_text: 'More Details -',
    landing_hero_button_url: '',
    landing_hero_image: '',

    landing_science_tag: 'SCIENCE OF SYNTHESIS',
    landing_science_title: 'Extraordinary\nfrom within.',
    landing_science_description: '',
    landing_science_stat1_value: '99.99%',
    landing_science_stat1_label: 'PARTICLE REMOVAL',
    landing_science_stat2_value: 'UV-C',
    landing_science_stat2_label: 'STERILIZATION',
    landing_science_image: '',
    landing_science_features: [
        { title: 'Result-Oriented Approach', desc: 'We focus on real business results, not just design. Our solutions are made to convert visitors into customers.' },
        { title: 'Affordable & Transparent Pricing', desc: 'High-quality service at a budget-friendly price. No hidden costs, no confusion.' },
        { title: 'Custom Solutions', desc: 'Every business is different. We design and develop according to your exact needs and goals.' }
    ],

    landing_lifestyle_tag: 'LIFESTYLE',
    landing_lifestyle_title: 'Seamless\nIntegration.',
    landing_lifestyle_description: 'Designed for your life, not just your air. AIRE Pro S1 harmonizes with modern architectural spaces, becoming an invisible guardian of your wellbeing.',
    landing_lifestyle_button_text: 'More Details →',
    landing_lifestyle_button_url: '',
    landing_lifestyle_image: '',

    landing_filter_tech_title: 'Medical-grade Precision.',
    landing_filter_tech_description: 'HEPA H13 Filter Technology. From microscopic particles to bacteria—nothing escapes our signature filtration system.',
    landing_filter_tech_badge_text: 'Advanced micro-fiber weaving that elevates atmospheric purity to unprecedented heights.',
    landing_filter_tech_image: '',

    landing_specs_title: 'Precision Engineering.',
    landing_specs_subtitle: 'The definitive standard for air purification.',
    landing_specs_button_text: 'More Details →',
    landing_specs_button_url: '',
    landing_specs_image: '',
    landing_specs_groups: [
        {
            tag: '01 / FILTRATION',
            title: 'Multi-Stage Synthesis',
            image: 'https://picsum.photos/500/500?random=1',
            items: [
                { label: 'Primary Pre-filter', value: 'Large debris / Pets' },
                { label: 'HEPA H13 Medical-grade', value: '99.97% of 0.3μm' },
                { label: 'Activated Carbon', value: 'VOCs & Odors' },
                { label: 'UV-C Sterilization', value: 'Viral Neutralization' }
            ]
        },
        {
            tag: '02 / PERFORMANCE',
            title: 'Atmospheric Throughput',
            image: 'https://picsum.photos/500/500?random=2',
            items: [
                { label: 'CADR (Smoke)', value: '580 m³/h' },
                { label: 'Room Coverage', value: 'Up to 1200 sq. ft.' },
                { label: 'Power Efficiency', value: '65W Max / 4W Sleep' }
            ]
        },
        {
            tag: '03 / SENSORS',
            title: 'Cognitive Awareness',
            image: 'https://picsum.photos/500/500?random=3',
            items: [
                { label: 'Laser Particle Sensor', value: 'PM2.5 / PM10' },
                { label: 'Electrochemical Sensor', value: 'Formaldehyde (HCHO)' },
                { label: 'Ambient Light Sensor', value: 'Auto Night-Mode' }
            ]
        },
        {
            tag: '04 / CONNECTIVITY',
            title: 'Unified Ecosystem',
            image: 'https://picsum.photos/500/500?random=4',
            items: [
                { label: 'Wireless', value: 'Wi-Fi 6 & Bluetooth 5.2' },
                { label: 'Smart Home', value: 'HomeKit, Alexa, Google' },
                { label: 'AIRE App', value: 'Full Remote Control' }
            ]
        }
    ]
});

const mainImageFile = ref(null);
const mainImagePreviews = ref([]);
const galleryImageFiles = ref([]);
const galleryPreviews = ref([]);
const existingGalleryImages = ref([]);
const deletedGalleryImages = ref([]);

const docPdfFile = ref(null);
const docPdfPreviews = ref([]);
const safetyPdfFile = ref(null);
const safetyPdfPreviews = ref([]);
const instPdfFile = ref(null);
const instPdfPreviews = ref([]);
const descImageFile = ref(null);
const descImagePreviews = ref([]);
const overviewImageFile = ref(null);
const overviewImagePreviews = ref([]);
const specsImageFile = ref(null);
const specsImagePreviews = ref([]);
const featuresImageFile = ref(null);
const featuresImagePreviews = ref([]);
const technologyImageFile = ref(null);
const technologyImagePreviews = ref([]);

const landingHeroImageFile = ref(null);
const landingHeroPreviews = ref([]);
const landingScienceImageFile = ref(null);
const landingSciencePreviews = ref([]);
const landingLifestyleImageFile = ref(null);
const landingLifestylePreviews = ref([]);
const landingFilterImageFile = ref(null);
const landingFilterPreviews = ref([]);
const landingSpecsImageFile = ref(null);
const landingSpecsPreviews = ref([]);

const deletedFiles = ref([]);

onMounted(async () => {
    try {
        const [resBrands, resCats, resAttrGroups, resOpts, resFilterOpts, resProducts, resProd] = await Promise.all([
            axios.get('/api/brands/all'),
            axios.get('/api/product-categories/all'),
            axios.get('/api/product-attribute-groups/all'),
            axios.get('/api/options/all'),
            axios.get('/api/filter-options/all'),
            axios.get('/api/products/all-dropdown'),
            axios.get(`/api/products/${productId}`)
        ]);
        brands.value = resBrands.data.data;
        categories.value = resCats.data.data;
        attributeGroups.value = resAttrGroups.data.data;
        availableOptions.value = resOpts.data.data;
        availableFilterOptions.value = resFilterOpts.data.data;
        allProducts.value = resProducts.data.data;

        const p = resProd.data.data;

        const categoryIds = p.categories ? p.categories.map(c => c.id) : [];
        const relatedIds = p.related_products ? p.related_products.map(r => r.id) : [];
        const boughtTogetherIds = p.bought_together ? p.bought_together.map(bt => bt.id) : [];
        const special = p.specials && p.specials.length > 0 ? p.specials[0] : null;
        const descInfo = p.description || {};

        form.value = {
            name: p.name,
            slug: p.slug || generateSlug(p.name || ''),
            model: p.model,
            product_code: p.product_code || '',
            brand_id: p.brand_id || '',
            price: p.price,
            quantity: p.quantity,
            weight: p.weight || 0,
            length: p.length || 0,
            width: p.width || 0,
            height: p.height || 0,
            status: p.status,
            featured: p.featured,
            sort_order: p.sort_order || 0,
            date_available: p.date_available ? p.date_available.substring(0, 10) : '',

            specs_badge: descInfo.specs_badge || '',
            specs_title: descInfo.specs_title || '',
            specs_description: descInfo.specs_description || '',
            spec1_icon: descInfo.spec1_icon || 'bi bi-shield-check',
            spec1_badge: descInfo.spec1_badge || 'FILTRATION',
            spec1_value: descInfo.spec1_value || '',
            spec1_unit: descInfo.spec1_unit || '',
            spec1_desc: descInfo.spec1_desc || '',
            spec2_icon: descInfo.spec2_icon || 'bi bi-wind',
            spec2_badge: descInfo.spec2_badge || 'VELOCITY',
            spec2_value: descInfo.spec2_value || '',
            spec2_unit: descInfo.spec2_unit || '',
            spec2_desc: descInfo.spec2_desc || '',
            spec3_icon: descInfo.spec3_icon || 'bi bi-battery-charging',
            spec3_badge: descInfo.spec3_badge || 'ENDURANCE',
            spec3_value: descInfo.spec3_value || '',
            spec3_unit: descInfo.spec3_unit || '',
            spec3_desc: descInfo.spec3_desc || '',
            spec4_icon: descInfo.spec4_icon || 'bi bi-box-seam',
            spec4_badge: descInfo.spec4_badge || 'MASS',
            spec4_value: descInfo.spec4_value || '',
            spec4_unit: descInfo.spec4_unit || '',
            spec4_desc: descInfo.spec4_desc || '',

            features_badge: descInfo.features_badge || '',
            features_title: descInfo.features_title || '',
            features_description: descInfo.features_description || '',
            feature1_icon: descInfo.feature1_icon || 'bi bi-shield-lock',
            feature1_title: descInfo.feature1_title || '',
            feature1_desc: descInfo.feature1_desc || '',
            feature2_icon: descInfo.feature2_icon || 'bi bi-lightbulb',
            feature2_title: descInfo.feature2_title || '',
            feature2_desc: descInfo.feature2_desc || '',
            feature3_icon: descInfo.feature3_icon || 'bi bi-funnel',
            feature3_title: descInfo.feature3_title || '',
            feature3_desc: descInfo.feature3_desc || '',

            applications_title: descInfo.applications_title || '',
            applications_description: descInfo.applications_description || '',

            technology_badge: descInfo.technology_badge || '',
            technology_title: descInfo.technology_title || '',
            technology_description: descInfo.technology_description || '',
            technology_card_title: descInfo.technology_card_title || '',
            technology_card_description: descInfo.technology_card_description || '',
            tech_feature1_title: descInfo.tech_feature1_title || '',
            tech_feature1_desc: descInfo.tech_feature1_desc || '',
            tech_feature2_title: descInfo.tech_feature2_title || '',
            tech_feature2_desc: descInfo.tech_feature2_desc || '',
            tech_feature3_title: descInfo.tech_feature3_title || '',
            tech_feature3_desc: descInfo.tech_feature3_desc || '',

            // Overview Section Fields (Section 1)
            overview_title: (p.overview && p.overview.title) || '',
            overview_description: (p.overview && p.overview.description) || '',
            overview_feature1_icon: (p.overview && p.overview.feature1_icon) || 'bi bi-shield-check',
            overview_feature1_title: (p.overview && p.overview.feature1_title) || '',
            overview_feature1_desc: (p.overview && p.overview.feature1_desc) || '',
            overview_feature2_icon: (p.overview && p.overview.feature2_icon) || 'bi bi-buildings',
            overview_feature2_title: (p.overview && p.overview.feature2_title) || '',
            overview_feature2_desc: (p.overview && p.overview.feature2_desc) || '',

            description: descInfo.description || '',
            tag: descInfo.tag || '',
            meta_title: descInfo.meta_title || '',
            meta_description: descInfo.meta_description || '',
            meta_keyword: descInfo.meta_keyword || '',
            video: descInfo.video || '',

            special_price: special ? special.special_price : '',
            special_start_date: special ? (special.start_date ? special.start_date.substring(0, 10) : '') : '',
            special_end_date: special ? (special.end_date ? special.end_date.substring(0, 10) : '') : '',

            product_free_delivery: p.free_delivery ? 1 : 0,
            category_ids: categoryIds,
            related_ids: relatedIds,
            bought_together_ids: boughtTogetherIds,

            options: (p.product_options || p.productOptions || p.options || []).map(opt => {
                const optId = opt.option_id ? Number(opt.option_id) : (opt.option ? Number(opt.option.id) : null);
                const optValId = (opt.option_value_id !== undefined && opt.option_value_id !== null && opt.option_value_id !== '')
                    ? Number(opt.option_value_id)
                    : (opt.option_value ? Number(opt.option_value.id) : '');
                const optGroup = availableOptions.value.find(o => Number(o.id) === optId);
                return {
                    option_id: optId,
                    option_name: opt.option ? opt.option.name : (optGroup ? optGroup.name : ''),
                    option_value_id: optValId,
                    quantity: opt.quantity,
                    subtract: opt.subtract,
                    price_prefix: opt.price_prefix,
                    price: opt.price,
                    available_values: optGroup ? (optGroup.option_values || optGroup.optionValues || []) : []
                };
            }),
            filter_options: (p.product_filter_options || p.productFilterOptions || p.filter_options || []).map(fOpt => {
                const fOptId = fOpt.filter_option_id ? Number(fOpt.filter_option_id) : (fOpt.filter_option ? Number(fOpt.filter_option.id) : null);
                const fValId = (fOpt.filter_option_value_id !== undefined && fOpt.filter_option_value_id !== null && fOpt.filter_option_value_id !== '')
                    ? Number(fOpt.filter_option_value_id)
                    : (fOpt.filter_option_value ? Number(fOpt.filter_option_value.id) : '');
                const fOptGroup = availableFilterOptions.value.find(o => Number(o.id) === fOptId);
                const availableVals = fOptGroup 
                    ? (fOptGroup.option_values || fOptGroup.optionValues || []) 
                    : (fOpt.filter_option?.option_values || fOpt.filter_option?.optionValues || []);
                return {
                    filter_option_id: fOptId,
                    filter_option_name: fOptGroup ? fOptGroup.name : (fOpt.filter_option ? fOpt.filter_option.name : ''),
                    filter_option_value_id: fValId,
                    available_values: availableVals
                };
            }),
            attributes: (p.product_attributes || p.productAttributes || p.attributes || []).map(attr => ({
                attribute_group_id: attr.attribute_group_id,
                name: attr.name,
                details: attr.details || '',
                sort_order: attr.sort_order ?? 0
            })),
            faqs: (p.faqs || []).map(faq => ({
                question: faq.question || '',
                answer: faq.answer || '',
                sort_order: faq.sort_order ?? 0
            })),
            applications: (p.applications || []).map(app => {
                const imgPath = app.bg_image || app.image;
                let previews = [];
                if (imgPath) {
                    if (imgPath.startsWith('http') || imgPath.startsWith('themes/') || imgPath.startsWith('assets/')) {
                        previews = [imgPath.startsWith('http') ? imgPath : `/${imgPath}`];
                    } else {
                        previews = [getImageCacheUrl(imgPath, 120, 120, 'webp')];
                    }
                }
                return {
                    id: app.id,
                    title: app.title || '',
                    description: app.description || '',
                    badge: app.badge || '',
                    bg_image: imgPath || '',
                    image: imgPath || '',
                    bg_image_file: null,
                    bg_image_previews: previews,
                    grid_width: app.grid_width || 'col-lg-4',
                    sort_order: app.sort_order ?? 0
                };
            })
        };

        if (descInfo.description_image) {
            descImagePreviews.value = [getImageCacheUrl(descInfo.description_image, 120, 120, 'webp')];
        }
        if (p.overview && p.overview.image) {
            overviewImagePreviews.value = [
                p.overview.image.startsWith('http') || p.overview.image.startsWith('themes/') || p.overview.image.startsWith('assets/')
                    ? (p.overview.image.startsWith('http') ? p.overview.image : `/${p.overview.image}`)
                    : getImageCacheUrl(p.overview.image, 120, 120, 'webp')
            ];
        }
        if (descInfo.specs_image) {
            specsImagePreviews.value = [
                descInfo.specs_image.startsWith('http') || descInfo.specs_image.startsWith('themes/') || descInfo.specs_image.startsWith('assets/')
                    ? (descInfo.specs_image.startsWith('http') ? descInfo.specs_image : `/${descInfo.specs_image}`)
                    : getImageCacheUrl(descInfo.specs_image, 120, 120, 'webp')
            ];
        }
        if (descInfo.features_image) {
            featuresImagePreviews.value = [
                descInfo.features_image.startsWith('http') || descInfo.features_image.startsWith('themes/') || descInfo.features_image.startsWith('assets/')
                    ? (descInfo.features_image.startsWith('http') ? descInfo.features_image : `/${descInfo.features_image}`)
                    : getImageCacheUrl(descInfo.features_image, 120, 120, 'webp')
            ];
        }
        if (descInfo.technology_image) {
            technologyImagePreviews.value = [
                descInfo.technology_image.startsWith('http') || descInfo.technology_image.startsWith('themes/') || descInfo.technology_image.startsWith('assets/')
                    ? (descInfo.technology_image.startsWith('http') ? descInfo.technology_image : `/${descInfo.technology_image}`)
                    : getImageCacheUrl(descInfo.technology_image, 120, 120, 'webp')
            ];
        }

        if (p.main_image) {
            mainImagePreviews.value = [getImageCacheUrl(p.main_image, 120, 120, 'webp')];
        }

        if (p.images && p.images.length > 0) {
            existingGalleryImages.value = p.images;
            galleryPreviews.value = p.images.map(img => getImageCacheUrl(img.image, 120, 120, 'webp'));
        }

        if (descInfo.documentation_pdf) {
            docPdfPreviews.value = [getImageCacheUrl(descInfo.documentation_pdf, 60, 60, 'webp')];
        }
        if (descInfo.safety_pdf) {
            safetyPdfPreviews.value = [getImageCacheUrl(descInfo.safety_pdf, 60, 60, 'webp')];
        }
        if (descInfo.instructions_pdf) {
            instPdfPreviews.value = [getImageCacheUrl(descInfo.instructions_pdf, 60, 60, 'webp')];
        }

        // Product Landing Data
        if (p.product_landing) {
            const pl = p.product_landing;
            form.value.landing_enabled = pl.status == 1;
            form.value.landing_hero_tag = pl.hero_tag || p.model || '';
            form.value.landing_hero_title = pl.hero_title || p.name || '';
            form.value.landing_hero_description = pl.hero_description || (p.description ? p.description.description : '');
            form.value.landing_hero_button_text = pl.hero_button_text || 'More Details -';
            form.value.landing_hero_button_url = pl.hero_button_url || '';
            form.value.landing_hero_image = pl.hero_image || '';

            form.value.landing_science_tag = pl.science_tag || 'SCIENCE OF SYNTHESIS';
            form.value.landing_science_title = pl.science_title || 'Extraordinary\nfrom within.';
            form.value.landing_science_description = pl.science_description || '';
            form.value.landing_science_stat1_value = pl.science_stat1_value || '99.99%';
            form.value.landing_science_stat1_label = pl.science_stat1_label || 'PARTICLE REMOVAL';
            form.value.landing_science_stat2_value = pl.science_stat2_value || 'UV-C';
            form.value.landing_science_stat2_label = pl.science_stat2_label || 'STERILIZATION';
            form.value.landing_science_image = pl.science_image || '';
            if (pl.science_features && Array.isArray(pl.science_features)) {
                form.value.landing_science_features = pl.science_features;
            }

            form.value.landing_lifestyle_tag = pl.lifestyle_tag || 'LIFESTYLE';
            form.value.landing_lifestyle_title = pl.lifestyle_title || 'Seamless\nIntegration.';
            form.value.landing_lifestyle_description = pl.lifestyle_description || '';
            form.value.landing_lifestyle_button_text = pl.lifestyle_button_text || 'More Details →';
            form.value.landing_lifestyle_button_url = pl.lifestyle_button_url || '';
            form.value.landing_lifestyle_image = pl.lifestyle_image || '';

            form.value.landing_filter_tech_title = pl.filter_tech_title || 'Medical-grade Precision.';
            form.value.landing_filter_tech_description = pl.filter_tech_description || '';
            form.value.landing_filter_tech_badge_text = pl.filter_tech_badge_text || '';
            form.value.landing_filter_tech_image = pl.filter_tech_image || '';

            form.value.landing_specs_title = pl.specs_title || 'Precision Engineering.';
            form.value.landing_specs_subtitle = pl.specs_subtitle || '';
            form.value.landing_specs_button_text = pl.specs_button_text || 'More Details →';
            form.value.landing_specs_button_url = pl.specs_button_url || '';
            form.value.landing_specs_image = pl.specs_image || '';
            if (pl.specs_groups && Array.isArray(pl.specs_groups)) {
                form.value.landing_specs_groups = pl.specs_groups;
            }

            if (pl.hero_image) {
                landingHeroPreviews.value = [pl.hero_image.startsWith('http') ? pl.hero_image : getImageCacheUrl(pl.hero_image, 120, 120, 'webp')];
            }
            if (pl.science_image) {
                landingSciencePreviews.value = [pl.science_image.startsWith('http') ? pl.science_image : getImageCacheUrl(pl.science_image, 120, 120, 'webp')];
            }
            if (pl.lifestyle_image) {
                landingLifestylePreviews.value = [pl.lifestyle_image.startsWith('http') ? pl.lifestyle_image : getImageCacheUrl(pl.lifestyle_image, 120, 120, 'webp')];
            }
            if (pl.filter_tech_image) {
                landingFilterPreviews.value = [pl.filter_tech_image.startsWith('http') ? pl.filter_tech_image : getImageCacheUrl(pl.filter_tech_image, 120, 120, 'webp')];
            }
            if (pl.specs_image) {
                landingSpecsPreviews.value = [pl.specs_image.startsWith('http') ? pl.specs_image : getImageCacheUrl(pl.specs_image, 120, 120, 'webp')];
            }
        } else {
            form.value.landing_enabled = false;
            form.value.landing_hero_tag = p.model || 'AIRE Pro S1';
            form.value.landing_hero_title = p.name || 'Atmospheric Mastery.';
            form.value.landing_hero_description = p.description ? p.description.description : '';
        }

    } catch (error) {
        toast.error("Failed to load product details.");
        console.error(error);
    } finally {
        initialLoading.value = false;
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

const handlePreviewRemoved = (preview) => {
    const urlPath = new URL(preview.src, window.location.origin).pathname;
    const cleanPath = urlPath.replace(/^\/storage\//, '');
    const found = existingGalleryImages.value.find(img => img.image === cleanPath);
    if (found) {
        deletedGalleryImages.value.push(found.id);
    }
};

const handleFileRemoved = (fieldName) => {
    deletedFiles.value.push(fieldName);
    if (form.value && form.value[fieldName] !== undefined) {
        form.value[fieldName] = '';
    }
};

const addOptionRow = () => {
    if (!selectedOptionToAdd.value) return;

    const opt = selectedOptionToAdd.value;
    form.value.options.push({
        option_id: Number(opt.id),
        option_name: opt.name,
        option_value_id: '',
        quantity: 0,
        subtract: 1,
        price_prefix: '+',
        price: 0,
        available_values: opt.option_values || opt.optionValues || []
    });

    selectedOptionToAdd.value = "";
};

const removeOptionRow = (index) => {
    form.value.options.splice(index, 1);
};

const addFilterOptionRow = () => {
    if (!selectedFilterOptionToAdd.value) return;

    const opt = selectedFilterOptionToAdd.value;
    form.value.filter_options.push({
        filter_option_id: Number(opt.id),
        filter_option_name: opt.name,
        filter_option_value_id: '',
        available_values: opt.option_values || opt.optionValues || []
    });

    selectedFilterOptionToAdd.value = "";
};

const removeFilterOptionRow = (index) => {
    form.value.filter_options.splice(index, 1);
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

const addApplication = () => {
    if (!form.value.applications) form.value.applications = [];
    const len = form.value.applications.length;
    form.value.applications.push({
        title: '',
        description: '',
        badge: '',
        bg_image: '',
        image: '',
        bg_image_file: null,
        bg_image_previews: [],
        grid_width: len === 0 ? 'col-lg-8' : (len === 1 ? 'col-lg-4' : 'col-12'),
        sort_order: len
    });
};

const removeApplication = (index) => {
    form.value.applications.splice(index, 1);
};

const addFaq = () => {
    if (!form.value.faqs) form.value.faqs = [];
    form.value.faqs.push({
        question: '',
        answer: '',
        sort_order: form.value.faqs.length
    });
};

const removeFaq = (index) => {
    form.value.faqs.splice(index, 1);
};

// Landing Page Helpers
const addScienceFeature = () => {
    if (!form.value.landing_science_features) form.value.landing_science_features = [];
    form.value.landing_science_features.push({ title: '', desc: '' });
};

const removeScienceFeature = (index) => {
    form.value.landing_science_features.splice(index, 1);
};

const addSpecGroup = () => {
    if (!form.value.landing_specs_groups) form.value.landing_specs_groups = [];
    const num = String(form.value.landing_specs_groups.length + 1).padStart(2, '0');
    form.value.landing_specs_groups.push({
        tag: `${num} / SPEC`,
        title: 'New Specification Group',
        image: 'https://picsum.photos/500/500',
        items: [{ label: '', value: '' }]
    });
};

const removeSpecGroup = (index) => {
    form.value.landing_specs_groups.splice(index, 1);
};

const addSpecRow = (groupIndex) => {
    if (!form.value.landing_specs_groups[groupIndex].items) {
        form.value.landing_specs_groups[groupIndex].items = [];
    }
    form.value.landing_specs_groups[groupIndex].items.push({ label: '', value: '' });
};

const removeSpecRow = (groupIndex, rowIndex) => {
    form.value.landing_specs_groups[groupIndex].items.splice(rowIndex, 1);
};

const submitForm = async () => {
    if (!form.value.name) {
        toast.error("Please enter a product name.");
        return;
    }

    if (!form.value.model) {
        toast.error("Please enter a product model.");
        return;
    }

    if (form.value.price === "" || form.value.price === null) {
        toast.error("Please enter a price.");
        return;
    }

    if (form.value.quantity === "" || form.value.quantity === null) {
        toast.error("Please enter quantity.");
        return;
    }

    if (form.value.category_ids.length === 0) {
        toast.error("Please select at least one category.");
        return;
    }

    loading.value = true;

    const formData = new FormData();
    Object.keys(form.value).forEach(key => {
        if (key.startsWith('landing_')) {
            // Handled separately below
        } else if (['options', 'filter_options', 'attributes', 'category_ids', 'related_ids', 'bought_together_ids'].includes(key)) {
            formData.append(key, JSON.stringify(form.value[key]));
        } else if (['faqs', 'applications'].includes(key)) {
            // Handled separately below
        } else {
            if (form.value[key] !== null && form.value[key] !== '') {
                formData.append(key, form.value[key]);
            }
        }
    });

    // Landing Page Form Submission
    formData.append('landing_enabled', form.value.landing_enabled ? 1 : 0);
    if (form.value.landing_enabled) {
        formData.append('landing_hero_tag', form.value.landing_hero_tag || '');
        formData.append('landing_hero_title', form.value.landing_hero_title || '');
        formData.append('landing_hero_description', form.value.landing_hero_description || '');
        formData.append('landing_hero_button_text', form.value.landing_hero_button_text || '');
        formData.append('landing_hero_button_url', form.value.landing_hero_button_url || '');
        if (form.value.landing_hero_image) formData.append('landing_hero_image', form.value.landing_hero_image);

        formData.append('landing_science_tag', form.value.landing_science_tag || '');
        formData.append('landing_science_title', form.value.landing_science_title || '');
        formData.append('landing_science_description', form.value.landing_science_description || '');
        formData.append('landing_science_stat1_value', form.value.landing_science_stat1_value || '');
        formData.append('landing_science_stat1_label', form.value.landing_science_stat1_label || '');
        formData.append('landing_science_stat2_value', form.value.landing_science_stat2_value || '');
        formData.append('landing_science_stat2_label', form.value.landing_science_stat2_label || '');
        if (form.value.landing_science_image) formData.append('landing_science_image', form.value.landing_science_image);
        formData.append('landing_science_features', JSON.stringify(form.value.landing_science_features || []));

        formData.append('landing_lifestyle_tag', form.value.landing_lifestyle_tag || '');
        formData.append('landing_lifestyle_title', form.value.landing_lifestyle_title || '');
        formData.append('landing_lifestyle_description', form.value.landing_lifestyle_description || '');
        formData.append('landing_lifestyle_button_text', form.value.landing_lifestyle_button_text || '');
        formData.append('landing_lifestyle_button_url', form.value.landing_lifestyle_button_url || '');
        if (form.value.landing_lifestyle_image) formData.append('landing_lifestyle_image', form.value.landing_lifestyle_image);

        formData.append('landing_filter_tech_title', form.value.landing_filter_tech_title || '');
        formData.append('landing_filter_tech_description', form.value.landing_filter_tech_description || '');
        formData.append('landing_filter_tech_badge_text', form.value.landing_filter_tech_badge_text || '');
        if (form.value.landing_filter_tech_image) formData.append('landing_filter_tech_image', form.value.landing_filter_tech_image);

        formData.append('landing_specs_title', form.value.landing_specs_title || '');
        formData.append('landing_specs_subtitle', form.value.landing_specs_subtitle || '');
        formData.append('landing_specs_button_text', form.value.landing_specs_button_text || '');
        formData.append('landing_specs_button_url', form.value.landing_specs_button_url || '');
        if (form.value.landing_specs_image) formData.append('landing_specs_image', form.value.landing_specs_image);
        formData.append('landing_specs_groups', JSON.stringify(form.value.landing_specs_groups || []));

        if (landingHeroImageFile.value && landingHeroImageFile.value[0]) formData.append('landing_hero_image_file', landingHeroImageFile.value[0].file);
        if (landingScienceImageFile.value && landingScienceImageFile.value[0]) formData.append('landing_science_image_file', landingScienceImageFile.value[0].file);
        if (landingLifestyleImageFile.value && landingLifestyleImageFile.value[0]) formData.append('landing_lifestyle_image_file', landingLifestyleImageFile.value[0].file);
        if (landingFilterImageFile.value && landingFilterImageFile.value[0]) formData.append('landing_filter_tech_image_file', landingFilterImageFile.value[0].file);
        if (landingSpecsImageFile.value && landingSpecsImageFile.value[0]) formData.append('landing_specs_image_file', landingSpecsImageFile.value[0].file);
    }

    if (form.value.applications && form.value.applications.length > 0) {
        form.value.applications.forEach((appItem, index) => {
            formData.append(`applications[${index}][title]`, appItem.title || '');
            formData.append(`applications[${index}][description]`, appItem.description || '');
            formData.append(`applications[${index}][badge]`, appItem.badge || '');
            formData.append(`applications[${index}][grid_width]`, appItem.grid_width || 'col-lg-4');
            formData.append(`applications[${index}][sort_order]`, appItem.sort_order || index);
            if (appItem.bg_image_file && appItem.bg_image_file[0]) {
                formData.append(`applications[${index}][bg_image_file]`, appItem.bg_image_file[0].file);
            }
            if (appItem.bg_image && typeof appItem.bg_image === 'string') {
                formData.append(`applications[${index}][bg_image]`, appItem.bg_image);
            }
        });
    }

    if (form.value.faqs && form.value.faqs.length > 0) {
        form.value.faqs.forEach((faq, index) => {
            formData.append(`faqs[${index}][question]`, faq.question || '');
            formData.append(`faqs[${index}][answer]`, faq.answer || '');
            formData.append(`faqs[${index}][sort_order]`, faq.sort_order || index);
        });
    }

    if (mainImageFile.value && mainImageFile.value[0]) {
        formData.append('main_image', mainImageFile.value[0].file);
    }

    if (galleryImageFiles.value && galleryImageFiles.value.length > 0) {
        galleryImageFiles.value.forEach((item, index) => {
            formData.append(`gallery_images[${index}]`, item.file);
        });
    }

    deletedGalleryImages.value.forEach((imgId, index) => {
        formData.append(`deleted_images[${index}]`, imgId);
    });

    deletedFiles.value.forEach((field, index) => {
        formData.append(`deleted_files[${index}]`, field);
    });

    if (docPdfFile.value && docPdfFile.value[0]) formData.append('documentation_pdf', docPdfFile.value[0].file);
    if (safetyPdfFile.value && safetyPdfFile.value[0]) formData.append('safety_pdf', safetyPdfFile.value[0].file);
    if (instPdfFile.value && instPdfFile.value[0]) formData.append('instructions_pdf', instPdfFile.value[0].file);
    if (descImageFile.value && descImageFile.value[0]) formData.append('description_image', descImageFile.value[0].file);
    if (overviewImageFile.value && overviewImageFile.value[0]) formData.append('overview_image', overviewImageFile.value[0].file);
    if (specsImageFile.value && specsImageFile.value[0]) formData.append('specs_image', specsImageFile.value[0].file);
    if (featuresImageFile.value && featuresImageFile.value[0]) formData.append('features_image', featuresImageFile.value[0].file);
    if (technologyImageFile.value && technologyImageFile.value[0]) formData.append('technology_image', technologyImageFile.value[0].file);

    try {
        await axios.post(`/api/products/${productId}`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        toast.success("Product updated successfully!");
        router.push({ name: 'Products' });
    } catch (error) {
        toast.validationError(error);
        loading.value = false;
    }
};

const updateProduct = submitForm;
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

.img-details {
    display: none;
}
</style>
