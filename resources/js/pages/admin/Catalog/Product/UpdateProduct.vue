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
                                <a class="nav-link" id="tab-images" data-toggle="pill" href="#custom-tabs-images"
                                    role="tab" aria-controls="custom-tabs-images" aria-selected="false">Images</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-links" data-toggle="pill" href="#custom-tabs-links"
                                    role="tab" aria-controls="custom-tabs-links" aria-selected="false">Links</a>
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
                                <a class="nav-link" id="tab-filter-options" data-toggle="pill" href="#custom-tabs-filter-options"
                                    role="tab" aria-controls="custom-tabs-filter-options" aria-selected="false">Filter Options</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-options" data-toggle="pill" href="#custom-tabs-options"
                                    role="tab" aria-controls="custom-tabs-options" aria-selected="false">Options</a>
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
                            <!-- <li class="nav-item">
                                <a class="nav-link" id="tab-others" data-toggle="pill" href="#custom-tabs-others"
                                    role="tab" aria-controls="custom-tabs-others" aria-selected="false">Others</a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" id="tab-faqs" data-toggle="pill" href="#custom-tabs-faqs" role="tab"
                                    aria-controls="custom-tabs-faqs" aria-selected="false">FAQs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-landing" data-toggle="pill" href="#custom-tabs-landing"
                                    role="tab" aria-controls="custom-tabs-landing" aria-selected="false">
                                    <i class="fas fa-rocket text-primary mr-1"></i> Landing Page
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-showcase" data-toggle="pill" href="#custom-tabs-showcase"
                                    role="tab" aria-controls="custom-tabs-showcase" aria-selected="false">
                                    <i class="fas fa-layer-group text-success mr-1"></i> Showcase Card
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <form @submit.prevent="submitForm" id="productForm" novalidate>
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
                                             <textarea class="form-control" v-model="form.description" ></textarea>
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

                                <!-- Images Tab (Tab 3 in sequence) -->
                                <div class="tab-pane fade" id="custom-tabs-images" role="tabpanel"
                                    aria-labelledby="tab-images">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>Default Main Image <span class="text-danger">*</span></label>
                                            <Vue3Dropzone :key="`main-dropzone-${dropzoneKey}`" v-model="mainImageFile" v-model:previews="mainImagePreviews"
                                                mode="edit" :allowSelectOnPreview="true" :maxFileSize="10"
                                                @previewRemoved="() => handleFileRemoved('main_image')" />
                                            <small class="text-muted d-block mt-1">Recommended: 800 × 800px or 1000 × 1000px (1:1 Square, clean/transparent background for interactive zoom)</small>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <label>Multiple Gallery Images</label>
                                            <Vue3Dropzone :key="`gallery-dropzone-${dropzoneKey}`" v-model="galleryImageFiles" v-model:previews="galleryPreviews"
                                                mode="edit" :multiple="true" :allowSelectOnPreview="true" :maxFileSize="10"
                                                selectFileStrategy="merge" @previewRemoved="handlePreviewRemoved" />
                                            <small class="text-muted d-block mt-1">Recommended: 800 × 800px or 1000 × 1000px (1:1 Square, matching main image)</small>
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
                                                    class="btn btn-outline-primary btn-sm px-3 py-2 font-weight-bold text-nowrap">
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
                                                                <label>Dynamic Scroll Image</label>
                                                                <Vue3Dropzone v-model="group.image_file"
                                                                    v-model:previews="group.image_previews"
                                                                    mode="edit" :allowSelectOnPreview="true"
                                                                    @previewRemoved="() => { group.image = ''; }" />
                                                                <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Recommended: 500 × 500px transparent PNG / WebP for 3D swap</small>
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

                                <!-- Showcase Card Tab with 12-Col Live Preview at Top -->
                                <div class="tab-pane fade" id="custom-tabs-showcase" role="tabpanel"
                                    aria-labelledby="tab-showcase">
                                    
                                    <div class="alert alert-info py-2 px-3 mb-3 d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle mr-2 fa-lg"></i>
                                            <span>Configure custom header text, badges, imagery, specs, and detailed modal features with <strong>Real-Time Live Preview</strong>.</span>
                                        </div>
                                        <div class="d-flex align-items-center mt-2 mt-md-0">
                                            <button type="button" class="btn btn-sm font-weight-bold"
                                                :class="showLivePreview ? 'btn-outline-secondary bg-white' : 'btn-success text-white shadow-sm'"
                                                @click="showLivePreview = !showLivePreview">
                                                <i class="fas" :class="showLivePreview ? 'fa-eye-slash mr-1' : 'fa-eye mr-1'"></i>
                                                {{ showLivePreview ? 'Hide Live Preview' : 'Show Live Preview' }}
                                            </button>
                                        </div>
                                    </div>

                                    <!-- 12-Column Real-Time Live Preview at Top (Collapsible) -->
                                    <div v-show="showLivePreview" class="row mb-4">
                                        <div class="col-12">
                                            <div class="card card-outline card-primary shadow-sm mb-0">
                                                <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center py-2 px-3">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-desktop text-primary mr-2"></i>
                                                        <span class="font-weight-bold text-dark">Real-Time Live Preview (12-Col Full Width)</span>
                                                    </div>
                                                    <div class="d-flex align-items-center mt-2 mt-md-0">
                                                        <div class="btn-group btn-group-sm mr-2" role="group">
                                                            <button type="button" class="btn"
                                                                :class="previewDevice === 'desktop' ? 'btn-dark' : 'btn-outline-secondary'"
                                                                @click="previewDevice = 'desktop'" title="Preview Desktop (2-Column Showcase Card)">
                                                                <i class="fas fa-desktop mr-1"></i> Desktop
                                                            </button>
                                                            <button type="button" class="btn"
                                                                :class="previewDevice === 'mobile' ? 'btn-dark' : 'btn-outline-secondary'"
                                                                @click="previewDevice = 'mobile'" title="Preview Mobile (Stacked Card)">
                                                                <i class="fas fa-mobile-alt mr-1"></i> Mobile
                                                            </button>
                                                        </div>
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <button type="button" class="btn"
                                                                :class="previewMode === 'card' ? 'btn-primary' : 'btn-outline-secondary'"
                                                                @click="previewMode = 'card'">
                                                                <i class="fas fa-id-card mr-1"></i> Card Only
                                                            </button>
                                                            <button type="button" class="btn"
                                                                :class="previewMode === 'modal' ? 'btn-primary' : 'btn-outline-secondary'"
                                                                @click="previewMode = 'modal'">
                                                                <i class="fas fa-window-maximize mr-1"></i> Modal Only
                                                            </button>
                                                            <button type="button" class="btn"
                                                                :class="previewMode === 'both' ? 'btn-primary' : 'btn-outline-secondary'"
                                                                @click="previewMode = 'both'">
                                                                <i class="fas fa-columns mr-1"></i> Side-by-Side (Both)
                                                            </button>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary ml-2"
                                                            @click="showLivePreview = false" title="Hide Preview">
                                                            <i class="fas fa-chevron-up"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="card-body bg-light p-3 p-md-4">
                                                    <!-- 1. Card Only View -->
                                                    <div v-if="previewMode === 'card'" class="d-flex justify-content-center py-2">
                                                        <div :style="{ width: '100%', maxWidth: previewDevice === 'mobile' ? '440px' : '920px' }">
                                                            <div class="ductless-showcase-card" :class="{ 'ductless-preview--mobile': previewDevice === 'mobile' }">
                                                                <!-- Top Hero Section -->
                                                                <div class="ductless-showcase-card__hero"
                                                                    :style="{ backgroundImage: `url('${previewHeroBgImage}')` }">
                                                                    <!-- Badges -->
                                                                    <div class="ductless-showcase-card__badges">
                                                                        <span class="ductless-badge ductless-badge--residential">
                                                                            <i class="bi bi-house"></i>
                                                                            <span>{{ form.showcase_badge_residential || 'Residential' }}</span>
                                                                        </span>
                                                                        <span class="ductless-badge ductless-badge--fresh-air">
                                                                            <i class="bi bi-wind"></i>
                                                                            <span>{{ form.showcase_badge_fresh_air || 'Small Fresh Air' }}</span>
                                                                        </span>
                                                                    </div>

                                                                    <!-- Actions -->
                                                                    <div class="ductless-showcase-card__actions">
                                                                        <button type="button" class="ductless-action-btn" title="Add to Cart">
                                                                            <i class="bi bi-cart3"></i>
                                                                        </button>
                                                                        <button type="button" class="ductless-action-btn" title="Compare">
                                                                            <i class="bi bi-arrow-left-right"></i>
                                                                        </button>
                                                                        <button type="button" class="ductless-action-btn" title="Add to Wishlist">
                                                                            <i class="bi bi-heart"></i>
                                                                        </button>
                                                                    </div>

                                                                    <!-- Title & Subtitle -->
                                                                    <div class="ductless-showcase-card__header">
                                                                        <h2 class="ductless-showcase-card__title">
                                                                            {{ form.showcase_title || form.name || 'Single Room Ductless' }}
                                                                        </h2>
                                                                        <p class="ductless-showcase-card__subtitle" :title="form.showcase_subtitle">
                                                                            {{ form.showcase_subtitle || 'Compact & powerful fresh air solution' }}
                                                                        </p>
                                                                    </div>

                                                                    <!-- Feature Pills -->
                                                                    <div class="ductless-showcase-card__pills">
                                                                        <template v-if="form.showcase_feature_pills && form.showcase_feature_pills.length > 0">
                                                                            <div v-for="(pill, pIdx) in form.showcase_feature_pills" :key="pIdx"
                                                                                class="ductless-pill" :class="{ 'ductless-pill--dual': pill.subtext }">
                                                                                <i class="ductless-pill__icon" :class="pill.icon || 'bi bi-check-circle'"></i>
                                                                                <div v-if="pill.subtext" class="ductless-pill__dual-text">
                                                                                    <span class="ductless-pill__dual-main">{{ pill.text }}</span>
                                                                                    <span class="ductless-pill__dual-sub">{{ pill.subtext }}</span>
                                                                                </div>
                                                                                <span v-else class="ductless-pill__text">{{ pill.text }}</span>
                                                                            </div>
                                                                        </template>
                                                                        <template v-else>
                                                                            <div class="ductless-pill"><i class="bi bi-arrows-fullscreen ductless-pill__icon"></i><span class="ductless-pill__text">200–500 sq ft</span></div>
                                                                            <div class="ductless-pill"><i class="bi bi-arrow-repeat ductless-pill__icon"></i><span class="ductless-pill__text">Heat Recovery 70%</span></div>
                                                                            <div class="ductless-pill"><i class="bi bi-shield-check ductless-pill__icon"></i><span class="ductless-pill__text">PM 2.5 99%</span></div>
                                                                            <div class="ductless-pill ductless-pill--dual"><i class="bi bi-wind ductless-pill__icon"></i><div class="ductless-pill__dual-text"><span class="ductless-pill__dual-main">100% Fresh Air</span><span class="ductless-pill__dual-sub">No Recycled Air</span></div></div>
                                                                        </template>
                                                                    </div>

                                                                    <!-- Quick View Button -->
                                                                    <button type="button" class="ductless-quickview-btn border-0" @click="previewMode = 'modal'" title="Click to preview Modal">
                                                                        <i class="bi bi-eye"></i>
                                                                        <span>Quick View</span>
                                                                        <i class="bi bi-chevron-right"></i>
                                                                    </button>
                                                                </div>

                                                                <!-- Bottom Body -->
                                                                <div class="ductless-showcase-card__body">
                                                                    <div class="ductless-diagram-box">
                                                                        <div class="ductless-diagram-box__meta">
                                                                            <span class="ductless-diagram-box__brand">{{ form.showcase_diagram_brand || 'BROAD' }}</span>
                                                                            <h3 class="ductless-diagram-box__model">{{ form.name || form.showcase_diagram_model || 'Product Name' }}</h3>
                                                                            <p class="ductless-diagram-box__system" :title="form.description || form.showcase_diagram_system">
                                                                                {{ form.description || form.showcase_diagram_system || 'Compact Fresh Air System' }}
                                                                            </p>
                                                                        </div>
                                                                        <div class="ductless-diagram-box__illustration">
                                                                            <img :src="previewDiagramImage" alt="Diagram" class="ductless-diagram-img" />
                                                                        </div>
                                                                    </div>

                                                                    <!-- Specs Bar -->
                                                                    <div class="ductless-specs-bar">
                                                                        <div class="ductless-spec-item">
                                                                            <div class="ductless-spec-item__value">
                                                                                <i class="bi bi-box"></i>
                                                                                <span>{{ form.showcase_airflow || '100 m³/h' }}</span>
                                                                            </div>
                                                                            <span class="ductless-spec-item__label">Airflow</span>
                                                                        </div>
                                                                        <div class="ductless-specs-bar__divider"></div>
                                                                        <div class="ductless-spec-item">
                                                                            <div class="ductless-spec-item__value">
                                                                                <i class="bi bi-lightning-charge"></i>
                                                                                <span>{{ form.showcase_power || '25 W' }}</span>
                                                                            </div>
                                                                            <span class="ductless-spec-item__label">Power</span>
                                                                        </div>
                                                                        <div class="ductless-specs-bar__divider"></div>
                                                                        <div class="ductless-spec-item">
                                                                            <div class="ductless-spec-item__value">
                                                                                <i class="bi bi-house-door"></i>
                                                                                <span>{{ form.showcase_coverage_area || '30–50 m²' }}</span>
                                                                            </div>
                                                                            <span class="ductless-spec-item__label">Apartment</span>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Footer -->
                                                                    <div class="ductless-card-footer">
                                                                        <button type="button" class="ductless-buy-btn">
                                                                            <span>Buy</span>
                                                                            <i class="bi bi-arrow-right"></i>
                                                                        </button>
                                                                        <div class="ductless-price-wrap">
                                                                            <div class="ductless-price">${{ form.price || '0.00' }}</div>
                                                                            <span class="ductless-learn-more">
                                                                                <span>Learn more</span>
                                                                                <i class="bi bi-chevron-right"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- 2. Modal Only View -->
                                                    <div v-if="previewMode === 'modal'" class="py-2">
                                                        <div class="ductless-modal__content rounded shadow-sm border p-4">
                                                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                                                <span class="badge badge-primary"><i class="fas fa-window-maximize mr-1"></i> Quick View Modal Preview</span>
                                                                <button type="button" class="btn btn-xs btn-outline-secondary" @click="previewMode = 'card'">
                                                                    <i class="fas fa-times mr-1"></i> Back to Card View
                                                                </button>
                                                            </div>
                                                            <div class="row g-4 align-items-center">
                                                                <div class="col-lg-5">
                                                                    <div class="ductless-modal__image-wrapper rounded"
                                                                        :style="{ backgroundImage: `url('${previewHeroBgImage}')` }"></div>
                                                                </div>
                                                                <div class="col-lg-7">
                                                                    <div class="ductless-modal__info">
                                                                        <div class="d-flex align-items-center justify-content-between mb-1 mt-1">
                                                                            <span class="ductless-modal__brand">{{ form.showcase_diagram_brand || 'AIRE' }}</span>
                                                                            <span class="ductless-modal__series-badge">{{ form.showcase_series_badge || 'PRO S1 SERIES' }}</span>
                                                                        </div>
                                                                        <h2 class="ductless-modal__title">{{ form.name || 'Product Name' }}</h2>
                                                                        <h3 class="ductless-modal__subtitle">{{ form.showcase_modal_subtitle || form.showcase_subtitle || 'Single Room Ductless Fresh Air Ventilator' }}</h3>
                                                                        <p class="ductless-modal__desc">{{ form.description || 'Brings in 100% outdoor air, filters with HEPA, and recovers heat to provide clean indoor air.' }}</p>

                                                                        <!-- 4-Column Specs Grid -->
                                                                        <div class="ductless-modal__specs-grid">
                                                                            <template v-if="form.showcase_spec_highlights && form.showcase_spec_highlights.length > 0">
                                                                                <div v-for="(spec, sIdx) in form.showcase_spec_highlights" :key="sIdx" class="ductless-modal__spec-col">
                                                                                    <i :class="spec.icon || 'bi bi-gear'" style="font-size: 16px; color: #334155;"></i>
                                                                                    <span class="ductless-modal__spec-label">{{ spec.label }}</span>
                                                                                    <span class="ductless-modal__spec-value">{{ spec.value }}</span>
                                                                                </div>
                                                                            </template>
                                                                            <template v-else>
                                                                                <div class="ductless-modal__spec-col"><i class="bi bi-wind" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Airflow</span><span class="ductless-modal__spec-value">100 m³/h</span></div>
                                                                                <div class="ductless-modal__spec-col"><i class="bi bi-lightning-charge" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Power</span><span class="ductless-modal__spec-value">25 W</span></div>
                                                                                <div class="ductless-modal__spec-col"><i class="bi bi-soundwave" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Noise</span><span class="ductless-modal__spec-value">&lt; 28 dB</span></div>
                                                                                <div class="ductless-modal__spec-col"><i class="bi bi-arrows-fullscreen" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Area</span><span class="ductless-modal__spec-value">30–50 m²</span></div>
                                                                            </template>
                                                                        </div>

                                                                        <!-- Matched Checklist -->
                                                                        <div class="ductless-modal__matched-section">
                                                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                                                <span class="ductless-modal__matched-title">Matched to your needs</span>
                                                                                <span class="ductless-modal__matched-sub">Based on filters</span>
                                                                            </div>
                                                                            <div class="ductless-modal__pill-wrap" style="grid-template-columns: repeat(3, 1fr);">
                                                                                <template v-if="form.showcase_matched_features && form.showcase_matched_features.length > 0">
                                                                                    <div v-for="(feat, fIdx) in form.showcase_matched_features" :key="fIdx" class="ductless-modal__pill text-truncate">
                                                                                        <i :class="feat.icon || 'bi bi-check2'"></i>
                                                                                        <span class="text-truncate">{{ feat.text }}</span>
                                                                                        <span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span>
                                                                                    </div>
                                                                                </template>
                                                                                <template v-else>
                                                                                    <div class="ductless-modal__pill"><i class="bi bi-house"></i><span>Residential</span><span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span></div>
                                                                                    <div class="ductless-modal__pill"><i class="bi bi-wind"></i><span>Fresh Air</span><span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span></div>
                                                                                    <div class="ductless-modal__pill"><i class="bi bi-shield-check"></i><span>HEPA PM2.5</span><span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span></div>
                                                                                </template>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Footer Row -->
                                                            <div class="ductless-modal__footer mt-3 pt-3">
                                                                <div class="ductless-modal__health-tags">
                                                                    <template v-if="form.showcase_health_tags && form.showcase_health_tags.length > 0">
                                                                        <span v-for="(htag, hIdx) in form.showcase_health_tags" :key="hIdx" class="ductless-modal__health-tag">
                                                                            <i :class="htag.icon || 'bi bi-check-circle'"></i> {{ htag.text }}
                                                                        </span>
                                                                    </template>
                                                                    <template v-else>
                                                                        <span class="ductless-modal__health-tag"><i class="bi bi-shield-check"></i> PM2.5: 99.9%</span>
                                                                        <span class="ductless-modal__health-tag"><i class="bi bi-heart-pulse"></i> HCHO: 65 m³/h</span>
                                                                    </template>
                                                                </div>
                                                                <div class="ductless-modal__cta-wrap">
                                                                    <button type="button" class="ductless-modal__btn-view">View Product</button>
                                                                    <button type="button" class="ductless-modal__btn-compare">Compare</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- 3. Side-by-Side (Both Card & Modal) View -->
                                                    <div v-if="previewMode === 'both'" class="py-2">
                                                        <div class="row g-4 align-items-start">
                                                            <!-- Card (Left) -->
                                                            <div class="col-lg-5 mb-4 mb-lg-0">
                                                                <div class="text-muted small font-weight-bold mb-2">
                                                                    <i class="fas fa-id-card mr-1"></i> Showcase Card
                                                                </div>
                                                                <div class="ductless-showcase-card" :class="{ 'ductless-preview--mobile': previewDevice === 'mobile' }">
                                                                    <!-- Top Hero Section -->
                                                                    <div class="ductless-showcase-card__hero"
                                                                        :style="{ backgroundImage: `url('${previewHeroBgImage}')` }">
                                                                        <!-- Badges -->
                                                                        <div class="ductless-showcase-card__badges">
                                                                            <span class="ductless-badge ductless-badge--residential">
                                                                                <i class="bi bi-house"></i>
                                                                                <span>{{ form.showcase_badge_residential || 'Residential' }}</span>
                                                                            </span>
                                                                            <span class="ductless-badge ductless-badge--fresh-air">
                                                                                <i class="bi bi-wind"></i>
                                                                                <span>{{ form.showcase_badge_fresh_air || 'Small Fresh Air' }}</span>
                                                                            </span>
                                                                        </div>

                                                                        <!-- Actions -->
                                                                        <div class="ductless-showcase-card__actions">
                                                                            <button type="button" class="ductless-action-btn" title="Add to Cart">
                                                                            <i class="bi bi-cart3"></i>
                                                                        </button>
                                                                        <button type="button" class="ductless-action-btn" title="Compare">
                                                                            <i class="bi bi-arrow-left-right"></i>
                                                                        </button>
                                                                        <button type="button" class="ductless-action-btn" title="Add to Wishlist">
                                                                            <i class="bi bi-heart"></i>
                                                                        </button>
                                                                    </div>

                                                                    <!-- Title & Subtitle -->
                                                                    <div class="ductless-showcase-card__header">
                                                                        <h2 class="ductless-showcase-card__title">
                                                                            {{ form.showcase_title || form.name || 'Single Room Ductless' }}
                                                                        </h2>
                                                                        <p class="ductless-showcase-card__subtitle" :title="form.showcase_subtitle">
                                                                            {{ form.showcase_subtitle || 'Compact & powerful fresh air solution' }}
                                                                        </p>
                                                                    </div>

                                                                    <!-- Feature Pills -->
                                                                    <div class="ductless-showcase-card__pills">
                                                                        <template v-if="form.showcase_feature_pills && form.showcase_feature_pills.length > 0">
                                                                            <div v-for="(pill, pIdx) in form.showcase_feature_pills" :key="pIdx"
                                                                                class="ductless-pill" :class="{ 'ductless-pill--dual': pill.subtext }">
                                                                                <i class="ductless-pill__icon" :class="pill.icon || 'bi bi-check-circle'"></i>
                                                                                <div v-if="pill.subtext" class="ductless-pill__dual-text">
                                                                                    <span class="ductless-pill__dual-main">{{ pill.text }}</span>
                                                                                    <span class="ductless-pill__dual-sub">{{ pill.subtext }}</span>
                                                                                </div>
                                                                                <span v-else class="ductless-pill__text">{{ pill.text }}</span>
                                                                            </div>
                                                                        </template>
                                                                        <template v-else>
                                                                            <div class="ductless-pill"><i class="bi bi-arrows-fullscreen ductless-pill__icon"></i><span class="ductless-pill__text">200–500 sq ft</span></div>
                                                                            <div class="ductless-pill"><i class="bi bi-arrow-repeat ductless-pill__icon"></i><span class="ductless-pill__text">Heat Recovery 70%</span></div>
                                                                            <div class="ductless-pill"><i class="bi bi-shield-check ductless-pill__icon"></i><span class="ductless-pill__text">PM 2.5 99%</span></div>
                                                                            <div class="ductless-pill ductless-pill--dual"><i class="bi bi-wind ductless-pill__icon"></i><div class="ductless-pill__dual-text"><span class="ductless-pill__dual-main">100% Fresh Air</span><span class="ductless-pill__dual-sub">No Recycled Air</span></div></div>
                                                                        </template>
                                                                    </div>

                                                                    <!-- Quick View Button -->
                                                                    <button type="button" class="ductless-quickview-btn border-0" @click="previewMode = 'modal'" title="Click to preview Modal">
                                                                        <i class="bi bi-eye"></i>
                                                                        <span>Quick View</span>
                                                                        <i class="bi bi-chevron-right"></i>
                                                                    </button>
                                                                </div>

                                                                <!-- Bottom Body -->
                                                                <div class="ductless-showcase-card__body">
                                                                    <div class="ductless-diagram-box">
                                                                        <div class="ductless-diagram-box__meta">
                                                                            <span class="ductless-diagram-box__brand">{{ form.showcase_diagram_brand || 'BROAD' }}</span>
                                                                            <h3 class="ductless-diagram-box__model">{{ form.name || form.showcase_diagram_model || 'Product Name' }}</h3>
                                                                            <p class="ductless-diagram-box__system" :title="form.description || form.showcase_diagram_system">
                                                                                {{ form.description || form.showcase_diagram_system || 'Compact Fresh Air System' }}
                                                                            </p>
                                                                        </div>
                                                                        <div class="ductless-diagram-box__illustration">
                                                                            <img :src="previewDiagramImage" alt="Diagram" class="ductless-diagram-img" />
                                                                        </div>
                                                                    </div>

                                                                    <!-- Specs Bar -->
                                                                    <div class="ductless-specs-bar">
                                                                        <div class="ductless-spec-item">
                                                                            <div class="ductless-spec-item__value">
                                                                                <i class="bi bi-box"></i>
                                                                                <span>{{ form.showcase_airflow || '100 m³/h' }}</span>
                                                                            </div>
                                                                            <span class="ductless-spec-item__label">Airflow</span>
                                                                        </div>
                                                                        <div class="ductless-specs-bar__divider"></div>
                                                                        <div class="ductless-spec-item">
                                                                            <div class="ductless-spec-item__value">
                                                                                <i class="bi bi-lightning-charge"></i>
                                                                                <span>{{ form.showcase_power || '25 W' }}</span>
                                                                            </div>
                                                                            <span class="ductless-spec-item__label">Power</span>
                                                                        </div>
                                                                        <div class="ductless-specs-bar__divider"></div>
                                                                        <div class="ductless-spec-item">
                                                                            <div class="ductless-spec-item__value">
                                                                                <i class="bi bi-house-door"></i>
                                                                                <span>{{ form.showcase_coverage_area || '30–50 m²' }}</span>
                                                                            </div>
                                                                            <span class="ductless-spec-item__label">Apartment</span>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Footer -->
                                                                    <div class="ductless-card-footer">
                                                                        <button type="button" class="ductless-buy-btn">
                                                                            <span>Buy</span>
                                                                            <i class="bi bi-arrow-right"></i>
                                                                        </button>
                                                                        <div class="ductless-price-wrap">
                                                                            <div class="ductless-price">${{ form.price || '0.00' }}</div>
                                                                            <span class="ductless-learn-more">
                                                                                <span>Learn more</span>
                                                                                <i class="bi bi-chevron-right"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Modal (Right) -->
                                                        <div class="col-lg-7">
                                                            <div class="text-muted small font-weight-bold mb-2">
                                                                <i class="fas fa-window-maximize mr-1"></i> Quick View Modal
                                                            </div>
                                                            <div class="ductless-modal__content rounded shadow-sm border p-3">
                                                                <div class="row g-3">
                                                                    <div class="col-md-5">
                                                                        <div class="ductless-modal__image-wrapper rounded"
                                                                            :style="{ backgroundImage: `url('${previewHeroBgImage}')` }"></div>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <div class="ductless-modal__info">
                                                                            <div class="d-flex align-items-center justify-content-between mb-1 mt-1">
                                                                                <span class="ductless-modal__brand">{{ form.showcase_diagram_brand || 'AIRE' }}</span>
                                                                                <span class="ductless-modal__series-badge">{{ form.showcase_series_badge || 'PRO S1 SERIES' }}</span>
                                                                            </div>
                                                                            <h2 class="ductless-modal__title">{{ form.name || 'Product Name' }}</h2>
                                                                            <h3 class="ductless-modal__subtitle">{{ form.showcase_modal_subtitle || form.showcase_subtitle || 'Single Room Ductless Fresh Air Ventilator' }}</h3>
                                                                            <p class="ductless-modal__desc">{{ form.description || 'Brings in 100% outdoor air, filters with HEPA, and recovers heat to provide clean indoor air.' }}</p>

                                                                            <!-- 4-Column Specs Grid -->
                                                                            <div class="ductless-modal__specs-grid">
                                                                                <template v-if="form.showcase_spec_highlights && form.showcase_spec_highlights.length > 0">
                                                                                    <div v-for="(spec, sIdx) in form.showcase_spec_highlights" :key="sIdx" class="ductless-modal__spec-col">
                                                                                        <i :class="spec.icon || 'bi bi-gear'" style="font-size: 16px; color: #334155;"></i>
                                                                                        <span class="ductless-modal__spec-label">{{ spec.label }}</span>
                                                                                        <span class="ductless-modal__spec-value">{{ spec.value }}</span>
                                                                                    </div>
                                                                                </template>
                                                                                <template v-else>
                                                                                    <div class="ductless-modal__spec-col"><i class="bi bi-wind" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Airflow</span><span class="ductless-modal__spec-value">100 m³/h</span></div>
                                                                                    <div class="ductless-modal__spec-col"><i class="bi bi-lightning-charge" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Power</span><span class="ductless-modal__spec-value">25 W</span></div>
                                                                                    <div class="ductless-modal__spec-col"><i class="bi bi-soundwave" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Noise</span><span class="ductless-modal__spec-value">&lt; 28 dB</span></div>
                                                                                    <div class="ductless-modal__spec-col"><i class="bi bi-arrows-fullscreen" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Area</span><span class="ductless-modal__spec-value">30–50 m²</span></div>
                                                                                </template>
                                                                            </div>

                                                                            <!-- Matched Checklist -->
                                                                            <div class="ductless-modal__matched-section">
                                                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                                                    <span class="ductless-modal__matched-title">Matched to your needs</span>
                                                                                    <span class="ductless-modal__matched-sub">Based on filters</span>
                                                                                </div>
                                                                                <div class="ductless-modal__pill-wrap" style="grid-template-columns: repeat(2, 1fr);">
                                                                                    <template v-if="form.showcase_matched_features && form.showcase_matched_features.length > 0">
                                                                                        <div v-for="(feat, fIdx) in form.showcase_matched_features" :key="fIdx" class="ductless-modal__pill text-truncate">
                                                                                            <i :class="feat.icon || 'bi bi-check2'"></i>
                                                                                            <span class="text-truncate">{{ feat.text }}</span>
                                                                                            <span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span>
                                                                                        </div>
                                                                                    </template>
                                                                                    <template v-else>
                                                                                        <div class="ductless-modal__pill"><i class="bi bi-house"></i><span>Residential</span><span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span></div>
                                                                                        <div class="ductless-modal__pill"><i class="bi bi-wind"></i><span>Fresh Air</span><span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span></div>
                                                                                    </template>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Footer Row -->
                                                                <div class="ductless-modal__footer mt-3 pt-3">
                                                                    <div class="ductless-modal__health-tags">
                                                                        <template v-if="form.showcase_health_tags && form.showcase_health_tags.length > 0">
                                                                            <span v-for="(htag, hIdx) in form.showcase_health_tags" :key="hIdx" class="ductless-modal__health-tag">
                                                                                <i :class="htag.icon || 'bi bi-check-circle'"></i> {{ htag.text }}
                                                                            </span>
                                                                        </template>
                                                                        <template v-else>
                                                                            <span class="ductless-modal__health-tag"><i class="bi bi-shield-check"></i> PM2.5: 99.9%</span>
                                                                            <span class="ductless-modal__health-tag"><i class="bi bi-heart-pulse"></i> HCHO: 65 m³/h</span>
                                                                        </template>
                                                                    </div>
                                                                    <div class="ductless-modal__cta-wrap">
                                                                        <button type="button" class="ductless-modal__btn-view">View Product</button>
                                                                        <button type="button" class="ductless-modal__btn-compare">Compare</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <!-- 12-Column Form Sections Below Preview -->
                                    <div class="row">
                                        <div class="col-12">

                                            <!-- 1. Header & Badges -->
                                            <div class="card card-outline card-secondary mb-4 shadow-sm">
                                                <div class="card-header bg-light">
                                                    <h3 class="card-title font-weight-bold text-dark mb-0">
                                                        <i class="fas fa-heading mr-1 text-primary"></i> 1. Card Header & Badges
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="font-weight-bold">Card Title</label>
                                                            <input type="text" class="form-control" v-model="form.showcase_title"
                                                                placeholder="e.g. Single Room Ductless" />
                                                            <small class="text-muted">Appears as the main title on the showcase card header.</small>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="font-weight-bold">Card Subtitle (Max 36-60 chars)</label>
                                                            <input type="text" class="form-control" v-model="form.showcase_subtitle"
                                                                placeholder="e.g. Compact and powerful room purifiers" />
                                                            <small class="text-muted">Short one-line description displayed right below the card title.</small>
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <label class="font-weight-bold text-primary"><i class="fas fa-window-maximize mr-1"></i> Quick View Modal Subtitle</label>
                                                            <input type="text" class="form-control" v-model="form.showcase_modal_subtitle"
                                                                placeholder="e.g. Single Room Ductless Fresh Air Ventilator" />
                                                            <small class="text-muted">Displayed directly under the product name inside the Quick View Modal popup.</small>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label>Series Badge</label>
                                                            <input type="text" class="form-control" v-model="form.showcase_series_badge"
                                                                placeholder="e.g. PRO S1 SERIES" />
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label>Badge 1 (Primary Category/Tag)</label>
                                                            <input type="text" class="form-control" v-model="form.showcase_badge_residential"
                                                                placeholder="e.g. Residential" />
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label>Badge 2 (Secondary Category/Tag)</label>
                                                            <input type="text" class="form-control" v-model="form.showcase_badge_fresh_air"
                                                                placeholder="e.g. Small Fresh Air" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 2. Hero Background & Diagram Cutout Images -->
                                            <div class="card card-outline card-secondary mb-4 shadow-sm">
                                                <div class="card-header bg-light">
                                                    <h3 class="card-title font-weight-bold text-dark mb-0">
                                                        <i class="fas fa-images mr-1 text-success"></i> 2. Showcase Images & Cutouts
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="font-weight-bold">Hero Background Image</label>
                                                            <Vue3Dropzone v-model="showcaseHeroImageFile" v-model:previews="showcaseHeroPreviews"
                                                                mode="edit" :allowSelectOnPreview="true"
                                                                @previewRemoved="() => handleFileRemoved('showcase_hero_bg_image')" />
                                                            <small class="text-muted d-block mt-1">Recommended: 1200 × 800px landscape image for the showcase background banner.</small>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="font-weight-bold">Diagram / Cutaway Product Image</label>
                                                            <Vue3Dropzone v-model="showcaseDiagramImageFile" v-model:previews="showcaseDiagramPreviews"
                                                                mode="edit" :allowSelectOnPreview="true"
                                                                @previewRemoved="() => handleFileRemoved('showcase_diagram_image')" />
                                                            <small class="text-muted d-block mt-1">Recommended: Transparent PNG or cutout (approx 600 × 500px) showing internal/front view.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 3. Diagram Product Meta & Bottom Specs -->
                                            <div class="card card-outline card-secondary mb-4 shadow-sm">
                                                <div class="card-header bg-light">
                                                    <h3 class="card-title font-weight-bold text-dark mb-0">
                                                        <i class="fas fa-sliders-h mr-1 text-info"></i> 3. Diagram Box Info & Quick Specs
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4 form-group">
                                                            <label class="font-weight-bold">Diagram Brand</label>
                                                            <input type="text" class="form-control" v-model="form.showcase_diagram_brand"
                                                                placeholder="e.g. AIRE" />
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label class="font-weight-bold">Diagram Model</label>
                                                            <input type="text" class="form-control" v-model="form.showcase_diagram_model"
                                                                placeholder="e.g. AP-S100" />
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label class="font-weight-bold">Diagram System (1-line description)</label>
                                                            <input type="text" class="form-control" v-model="form.showcase_diagram_system"
                                                                placeholder="e.g. Wall-Mounted Fresh Air System" />
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label>Airflow Volume</label>
                                                            <input type="text" class="form-control" v-model="form.showcase_airflow"
                                                                placeholder="e.g. 100 m³/h" />
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label>Power Consumption</label>
                                                            <input type="text" class="form-control" v-model="form.showcase_power"
                                                                placeholder="e.g. 25 W" />
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label>Coverage Area</label>
                                                            <input type="text" class="form-control" v-model="form.showcase_coverage_area"
                                                                placeholder="e.g. 30–50 m²" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 4. Floating Feature Pills -->
                                            <div class="card card-outline card-secondary mb-4 shadow-sm">
                                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                    <h3 class="card-title font-weight-bold text-dark mb-0">
                                                        <i class="fas fa-tags mr-1 text-warning"></i> 4. Floating Feature Pills (Over Image)
                                                    </h3>
                                                    <button type="button" class="btn btn-sm btn-primary" @click="addShowcasePill">
                                                        <i class="fas fa-plus mr-1"></i> Add Pill
                                                    </button>
                                                </div>
                                                <div class="card-body p-0">
                                                    <table class="table table-sm table-hover mb-0">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th style="width: 25%;">Icon (Bootstrap Icons)</th>
                                                                <th style="width: 35%;">Title / Label</th>
                                                                <th style="width: 35%;">Subtext</th>
                                                                <th style="width: 5%; text-align: center;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(pill, pIdx) in form.showcase_feature_pills" :key="pIdx">
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i :class="pill.icon || 'bi bi-check-circle'"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" v-model="pill.icon" placeholder="e.g. bi bi-wind" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control form-control-sm" v-model="pill.text" placeholder="e.g. 100 m³/h Airflow" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control form-control-sm" v-model="pill.subtext" placeholder="e.g. Continuous fresh air" />
                                                                </td>
                                                                <td class="text-center align-middle">
                                                                    <button type="button" class="btn btn-sm btn-outline-danger" @click="removeShowcasePill(pIdx)">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr v-if="!form.showcase_feature_pills || form.showcase_feature_pills.length === 0">
                                                                <td colspan="4" class="text-center text-muted py-3">No feature pills added. Click "+ Add Pill" to create one.</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- 5. Detail Modal Spec Highlights (4 items) -->
                                            <div class="card card-outline card-secondary mb-4 shadow-sm">
                                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                    <h3 class="card-title font-weight-bold text-dark mb-0">
                                                        <i class="fas fa-th-large mr-1 text-primary"></i> 5. Detail Modal - Spec Highlight Cards
                                                    </h3>
                                                    <button type="button" class="btn btn-sm btn-primary" @click="addShowcaseSpecHighlight">
                                                        <i class="fas fa-plus mr-1"></i> Add Highlight Card
                                                    </button>
                                                </div>
                                                <div class="card-body p-0">
                                                    <table class="table table-sm table-hover mb-0">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th style="width: 25%;">Icon (Bootstrap Icons)</th>
                                                                <th style="width: 35%;">Label</th>
                                                                <th style="width: 35%;">Value</th>
                                                                <th style="width: 5%; text-align: center;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(spec, sIdx) in form.showcase_spec_highlights" :key="sIdx">
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i :class="spec.icon || 'bi bi-lightning-charge'"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" v-model="spec.icon" placeholder="e.g. bi bi-wind" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control form-control-sm" v-model="spec.label" placeholder="e.g. Airflow Volume" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control form-control-sm" v-model="spec.value" placeholder="e.g. 100 m³/h" />
                                                                </td>
                                                                <td class="text-center align-middle">
                                                                    <button type="button" class="btn btn-sm btn-outline-danger" @click="removeShowcaseSpecHighlight(sIdx)">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr v-if="!form.showcase_spec_highlights || form.showcase_spec_highlights.length === 0">
                                                                <td colspan="4" class="text-center text-muted py-3">No spec highlights added. Click "+ Add Highlight Card" to create one.</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- 6. Detail Modal Key Features & Technology Checklist -->
                                            <div class="card card-outline card-secondary mb-4 shadow-sm">
                                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                    <h3 class="card-title font-weight-bold text-dark mb-0">
                                                        <i class="fas fa-check-double mr-1 text-success"></i> 6. Detail Modal - Key Features Checklist
                                                    </h3>
                                                    <button type="button" class="btn btn-sm btn-primary" @click="addShowcaseMatchedFeature">
                                                        <i class="fas fa-plus mr-1"></i> Add Feature
                                                    </button>
                                                </div>
                                                <div class="card-body p-0">
                                                    <table class="table table-sm table-hover mb-0">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th style="width: 25%;">Icon</th>
                                                                <th style="width: 70%;">Feature Description</th>
                                                                <th style="width: 5%; text-align: center;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(feat, fIdx) in form.showcase_matched_features" :key="fIdx">
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i :class="feat.icon || 'bi bi-check2-circle'"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" v-model="feat.icon" placeholder="e.g. bi bi-check2-circle" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control form-control-sm" v-model="feat.text" placeholder="e.g. Medical-Grade H13 HEPA + Active Carbon Multi-Stage Filtration" />
                                                                </td>
                                                                <td class="text-center align-middle">
                                                                    <button type="button" class="btn btn-sm btn-outline-danger" @click="removeShowcaseMatchedFeature(fIdx)">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr v-if="!form.showcase_matched_features || form.showcase_matched_features.length === 0">
                                                                <td colspan="3" class="text-center text-muted py-3">No features added. Click "+ Add Feature" to create one.</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- 7. Detail Modal Health & Certification Badges -->
                                            <div class="card card-outline card-secondary mb-4 shadow-sm">
                                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                    <h3 class="card-title font-weight-bold text-dark mb-0">
                                                        <i class="fas fa-shield-alt mr-1 text-danger"></i> 7. Detail Modal - Health & Safety Certifications
                                                    </h3>
                                                    <button type="button" class="btn btn-sm btn-primary" @click="addShowcaseHealthTag">
                                                        <i class="fas fa-plus mr-1"></i> Add Health / Cert Tag
                                                    </button>
                                                </div>
                                                <div class="card-body p-0">
                                                    <table class="table table-sm table-hover mb-0">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th style="width: 25%;">Icon</th>
                                                                <th style="width: 70%;">Tag / Certification Text</th>
                                                                <th style="width: 5%; text-align: center;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(tag, tIdx) in form.showcase_health_tags" :key="tIdx">
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i :class="tag.icon || 'bi bi-shield-fill-check'"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" v-model="tag.icon" placeholder="e.g. bi bi-shield-fill-check" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control form-control-sm" v-model="tag.text" placeholder="e.g. PM2.5 Removal: 99.9%" />
                                                                </td>
                                                                <td class="text-center align-middle">
                                                                    <button type="button" class="btn btn-sm btn-outline-danger" @click="removeShowcaseHealthTag(tIdx)">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr v-if="!form.showcase_health_tags || form.showcase_health_tags.length === 0">
                                                                <td colspan="3" class="text-center text-muted py-3">No certification tags added. Click "+ Add Health / Cert Tag" to create one.</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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
import { getImageCacheUrl, getImagePath, generateSlug } from '../../../../layouts/helpers/helpers';

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
            image_file: null,
            image_previews: ['https://picsum.photos/500/500?random=1'],
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
            image_file: null,
            image_previews: ['https://picsum.photos/500/500?random=2'],
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
            image_file: null,
            image_previews: ['https://picsum.photos/500/500?random=3'],
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
            image_file: null,
            image_previews: ['https://picsum.photos/500/500?random=4'],
            items: [
                { label: 'Wireless', value: 'Wi-Fi 6 & Bluetooth 5.2' },
                { label: 'Smart Home', value: 'HomeKit, Alexa, Google' },
                { label: 'AIRE App', value: 'Full Remote Control' }
            ]
        }
    ],

    // Showcase Card Fields
    showcase_title: '',
    showcase_subtitle: '',
    showcase_modal_subtitle: '',
    showcase_series_badge: 'PRO S1 SERIES',
    showcase_badge_residential: 'Residential',
    showcase_badge_fresh_air: 'Small Fresh Air',
    showcase_hero_bg_image: '',
    showcase_diagram_image: '',
    showcase_diagram_brand: 'AIRE',
    showcase_diagram_model: '',
    showcase_diagram_system: '',
    showcase_airflow: '100 m³/h',
    showcase_power: '25 W',
    showcase_coverage_area: '30–50 m²',
    showcase_feature_pills: [],
    showcase_spec_highlights: [],
    showcase_matched_features: [],
    showcase_health_tags: []
});

const mainImageFile = ref(null);
const mainImagePreviews = ref([]);
const galleryImageFiles = ref([]);
const galleryPreviews = ref([]);
const existingGalleryImages = ref([]);
const deletedGalleryImages = ref([]);
const dropzoneKey = ref(0);

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

const showcaseHeroImageFile = ref(null);
const showcaseHeroPreviews = ref([]);
const showcaseDiagramImageFile = ref(null);
const showcaseDiagramPreviews = ref([]);


const previewMode = ref('card');
const previewDevice = ref('desktop');
const showLivePreview = ref(true);

const previewHeroBgImage = computed(() => {
    if (showcaseHeroImageFile.value && showcaseHeroImageFile.value[0]?.file) {
        try { return URL.createObjectURL(showcaseHeroImageFile.value[0].file); } catch (e) { /* fallback */ }
    }
    if (form.value.showcase_hero_bg_image) {
        return getImagePath(form.value.showcase_hero_bg_image);
    }
    if (showcaseHeroPreviews.value && showcaseHeroPreviews.value.length > 0) {
        const prev = showcaseHeroPreviews.value[0];
        return prev ? prev.replace(/^\/image\/\d+\/\d+\/[^/]+\//, '/storage/') : prev;
    }
    return '/themes/default/assets/img/cart-bg.png';
});

const previewDiagramImage = computed(() => {
    if (showcaseDiagramImageFile.value && showcaseDiagramImageFile.value[0]?.file) {
        try { return URL.createObjectURL(showcaseDiagramImageFile.value[0].file); } catch (e) { /* fallback */ }
    }
    if (showcaseDiagramPreviews.value && showcaseDiagramPreviews.value.length > 0) {
        const prev = showcaseDiagramPreviews.value[0];
        return prev ? prev.replace('/image/120/120/', '/image/280/280/') : prev;
    }
    if (form.value.showcase_diagram_image) {
        const img = form.value.showcase_diagram_image;
        return img.startsWith('http') || img.startsWith('themes/') || img.startsWith('assets/')
            ? (img.startsWith('http') ? img : `/${img}`)
            : getImageCacheUrl(img, 280, 280, 'webp');
    }
    return '/themes/default/assets/img/diagram.png';
});

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
                form.value.landing_specs_groups = pl.specs_groups.map(g => {
                    const img = g.image || '';
                    let previews = [];
                    if (img) {
                        previews = [img.startsWith('http') || img.startsWith('themes/') || img.startsWith('assets/') ? (img.startsWith('http') ? img : `/${img}`) : getImageCacheUrl(img, 120, 120, 'webp')];
                    }
                    return {
                        tag: g.tag || '',
                        title: g.title || '',
                        image: img,
                        image_file: null,
                        image_previews: previews,
                        items: g.items || []
                    };
                });
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

        // Product Showcase Data
        if (p.showcase) {
            const sc = p.showcase;
            const primaryCat = p.categories && p.categories[0] ? p.categories[0] : null;
            form.value.showcase_title = sc.title || (primaryCat ? primaryCat.name : (p.name || 'Single Room Ductless'));
            form.value.showcase_subtitle = sc.subtitle || 'Compact & powerful fresh air solution';
            form.value.showcase_modal_subtitle = sc.modal_subtitle || 'Single Room Ductless Fresh Air Ventilator';
            form.value.showcase_series_badge = sc.series_badge || 'AIRPRO HEPA Series';
            form.value.showcase_badge_residential = sc.badge_residential || 'Residential';
            form.value.showcase_badge_fresh_air = sc.badge_fresh_air || 'Small Fresh Air';
            form.value.showcase_diagram_brand = sc.diagram_brand || (p.brand ? p.brand.name : 'BROAD');
            form.value.showcase_diagram_model = sc.diagram_model || p.model || (p.description ? p.description.name : 'FF100 AirPro Fresh');
            form.value.showcase_diagram_system = sc.diagram_system || (p.description && p.description.description ? p.description.description : 'Compact Fresh Air System');
            form.value.showcase_airflow = sc.airflow || '260 m³/h';
            form.value.showcase_power = sc.power || '30–120 W';
            form.value.showcase_coverage_area = sc.coverage_area || '20–50 m²';
            form.value.showcase_hero_bg_image = sc.hero_bg_image || '';
            form.value.showcase_diagram_image = sc.diagram_image || '';
            form.value.showcase_feature_pills = Array.isArray(sc.feature_pills) && sc.feature_pills.length > 0 ? sc.feature_pills : [
                { icon: 'bi bi-arrows-fullscreen', text: '200–500 sq ft', subtext: '' },
                { icon: 'bi bi-arrow-repeat', text: 'Heat Recovery 70%', subtext: '' },
                { icon: 'bi bi-shield-check', text: 'PM 2.5 99%', subtext: '' },
                { icon: 'bi bi-arrow-right', text: '100% Fresh Air', subtext: 'No Recycled Air' },
                { icon: 'bi bi-crosshair', text: 'Infection Control', subtext: '' },
                { icon: 'bi bi-file-earmark-medical', text: 'Asthma', subtext: '' },
                { icon: 'bi bi-brightness-high', text: 'Allergies & Dust', subtext: '' }
            ];
            form.value.showcase_spec_highlights = Array.isArray(sc.spec_highlights) && sc.spec_highlights.length > 0 ? sc.spec_highlights : [
                { icon: 'bi bi-arrow-right', label: 'PM2.5 Filtration', value: '' },
                { icon: 'bi bi-arrow-repeat', label: 'Heat Recovery Efficiency', value: '60%' },
                { icon: 'bi bi-lightning-charge', label: 'Power Consumption', value: '7 – 31 W' },
                { icon: 'bi bi-palette', label: 'Colour', value: 'White' }
            ];
            form.value.showcase_matched_features = Array.isArray(sc.matched_features) && sc.matched_features.length > 0 ? sc.matched_features : [
                { icon: 'bi bi-house-door', text: 'Residential' },
                { icon: 'bi bi-arrows-fullscreen', text: '200 – 500 sq ft' },
                { icon: 'bi bi-arrow-right', text: 'Fresh Air & Ventilation' },
                { icon: 'bi bi-layout-sidebar', text: 'Single Room' },
                { icon: 'bi bi-square', text: 'Wall Mounted' },
                { icon: 'bi bi-arrow-repeat', text: 'Heat Recovery' },
                { icon: 'bi bi-shield-check', text: 'HEPA / PM2.5 Filtration' }
            ];
            form.value.showcase_health_tags = Array.isArray(sc.health_tags) && sc.health_tags.length > 0 ? sc.health_tags : [
                { icon: 'bi bi-arrow-right', text: 'Allergies & Dust' },
                { icon: 'bi bi-file-earmark-medical', text: 'Asthma' },
                { icon: 'bi bi-house-door', text: 'Mold & Fog Window' },
                { icon: 'bi bi-grid-3x3', text: 'Pets & Odor' },
                { icon: 'bi bi-arrow-right', text: 'Smoke & Wildfire' },
                { icon: 'bi bi-diagram-3', text: 'VOCs' }
            ];

            if (sc.hero_bg_image) {
                showcaseHeroPreviews.value = [getImagePath(sc.hero_bg_image)];
            }
            if (sc.diagram_image) {
                showcaseDiagramPreviews.value = [
                    sc.diagram_image.startsWith('http') || sc.diagram_image.startsWith('themes/') || sc.diagram_image.startsWith('assets/')
                        ? (sc.diagram_image.startsWith('http') ? sc.diagram_image : `/${sc.diagram_image}`)
                        : getImageCacheUrl(sc.diagram_image, 380, 380, 'webp')
                ];
            }
        } else {
            form.value.showcase_title = p.categories && p.categories[0] ? p.categories[0].name : (p.name || 'Single Room Ductless');
            form.value.showcase_subtitle = 'Compact & powerful fresh air solution';
            form.value.showcase_modal_subtitle = 'Single Room Ductless Fresh Air Ventilator';
            form.value.showcase_series_badge = 'AIRPRO HEPA Series';
            form.value.showcase_badge_residential = 'Residential';
            form.value.showcase_badge_fresh_air = 'Small Fresh Air';
            form.value.showcase_diagram_brand = p.brand ? p.brand.name : 'BROAD';
            form.value.showcase_diagram_model = p.model || 'FF100 AirPro Fresh';
            form.value.showcase_diagram_system = 'Compact Fresh Air System';
            form.value.showcase_airflow = '260 m³/h';
            form.value.showcase_power = '30–120 W';
            form.value.showcase_coverage_area = '20–50 m²';
            form.value.showcase_feature_pills = [
                { icon: 'bi bi-arrows-fullscreen', text: '200–500 sq ft', subtext: '' },
                { icon: 'bi bi-arrow-repeat', text: 'Heat Recovery 70%', subtext: '' },
                { icon: 'bi bi-shield-check', text: 'PM 2.5 99%', subtext: '' },
                { icon: 'bi bi-arrow-right', text: '100% Fresh Air', subtext: 'No Recycled Air' },
                { icon: 'bi bi-crosshair', text: 'Infection Control', subtext: '' },
                { icon: 'bi bi-file-earmark-medical', text: 'Asthma', subtext: '' },
                { icon: 'bi bi-brightness-high', text: 'Allergies & Dust', subtext: '' }
            ];
            form.value.showcase_spec_highlights = [
                { icon: 'bi bi-arrow-right', label: 'PM2.5 Filtration', value: '' },
                { icon: 'bi bi-arrow-repeat', label: 'Heat Recovery Efficiency', value: '60%' },
                { icon: 'bi bi-lightning-charge', label: 'Power Consumption', value: '7 – 31 W' },
                { icon: 'bi bi-palette', label: 'Colour', value: 'White' }
            ];
            form.value.showcase_matched_features = [
                { icon: 'bi bi-house-door', text: 'Residential' },
                { icon: 'bi bi-arrows-fullscreen', text: '200 – 500 sq ft' },
                { icon: 'bi bi-arrow-right', text: 'Fresh Air & Ventilation' },
                { icon: 'bi bi-layout-sidebar', text: 'Single Room' },
                { icon: 'bi bi-square', text: 'Wall Mounted' },
                { icon: 'bi bi-arrow-repeat', text: 'Heat Recovery' },
                { icon: 'bi bi-shield-check', text: 'HEPA / PM2.5 Filtration' }
            ];
            form.value.showcase_health_tags = [
                { icon: 'bi bi-arrow-right', text: 'Allergies & Dust' },
                { icon: 'bi bi-file-earmark-medical', text: 'Asthma' },
                { icon: 'bi bi-house-door', text: 'Mold & Fog Window' },
                { icon: 'bi bi-grid-3x3', text: 'Pets & Odor' },
                { icon: 'bi bi-arrow-right', text: 'Smoke & Wildfire' },
                { icon: 'bi bi-diagram-3', text: 'VOCs' }
            ];
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
    if (!preview) return;
    const rawSrc = preview.src || (typeof preview === 'string' ? preview : '');
    const cleanSrc = decodeURIComponent(rawSrc.split('?')[0]);

    let foundIndex = existingGalleryImages.value.findIndex(img => {
        if (!img || !img.image) return false;
        const imgPath = img.image.replace(/^\/+/, '').replace(/^storage\//, '');
        return imgPath && cleanSrc.includes(imgPath);
    });

    // Fallback: If not matched by path string, try matching by preview.id ('preview-0')
    if (foundIndex === -1 && preview.id && typeof preview.id === 'string' && preview.id.startsWith('preview-')) {
        const idx = parseInt(preview.id.replace('preview-', ''), 10);
        if (!isNaN(idx) && idx >= 0 && idx < existingGalleryImages.value.length) {
            foundIndex = idx;
        }
    }

    if (foundIndex !== -1) {
        const removed = existingGalleryImages.value[foundIndex];
        if (removed && removed.id && !deletedGalleryImages.value.includes(removed.id)) {
            deletedGalleryImages.value.push(removed.id);
        }
        existingGalleryImages.value.splice(foundIndex, 1);
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
        image: '',
        image_file: null,
        image_previews: [],
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

// Showcase Helpers
const addShowcasePill = () => {
    if (!form.value.showcase_feature_pills) form.value.showcase_feature_pills = [];
    form.value.showcase_feature_pills.push({ icon: 'bi bi-wind', text: '', subtext: '' });
};

const removeShowcasePill = (index) => {
    form.value.showcase_feature_pills.splice(index, 1);
};

const addShowcaseSpecHighlight = () => {
    if (!form.value.showcase_spec_highlights) form.value.showcase_spec_highlights = [];
    form.value.showcase_spec_highlights.push({ icon: 'bi bi-lightning-charge', label: '', value: '' });
};

const removeShowcaseSpecHighlight = (index) => {
    form.value.showcase_spec_highlights.splice(index, 1);
};

const addShowcaseMatchedFeature = () => {
    if (!form.value.showcase_matched_features) form.value.showcase_matched_features = [];
    form.value.showcase_matched_features.push({ icon: 'bi bi-check2-circle', text: '' });
};

const removeShowcaseMatchedFeature = (index) => {
    form.value.showcase_matched_features.splice(index, 1);
};

const addShowcaseHealthTag = () => {
    if (!form.value.showcase_health_tags) form.value.showcase_health_tags = [];
    form.value.showcase_health_tags.push({ icon: 'bi bi-shield-fill-check', text: '' });
};

const removeShowcaseHealthTag = (index) => {
    form.value.showcase_health_tags.splice(index, 1);
};

// Programmatic tab switcher to show tab with validation error
const switchToTab = (tabId) => {
    const tabEl = document.getElementById(tabId);
    if (tabEl) {
        if (window.$ && typeof window.$(tabEl).tab === 'function') {
            window.$(tabEl).tab('show');
        } else {
            tabEl.click();
        }
        tabEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
};

const submitForm = async () => {
    // 1. General Tab Validation
    if (!form.value.name || !form.value.name.trim()) {
        switchToTab('tab-general');
        toast.error("Please enter a Product Name in the General tab.");
        return;
    }

    if (!form.value.slug || !form.value.slug.trim()) {
        switchToTab('tab-general');
        toast.error("Please enter a Product Slug in the General tab.");
        return;
    }

    // 2. Data Tab Validation
    if (!form.value.model || !form.value.model.trim()) {
        switchToTab('tab-data');
        toast.error("Please enter a Product Model in the Data tab.");
        return;
    }

    if (form.value.price === "" || form.value.price === null || Number(form.value.price) < 0) {
        switchToTab('tab-data');
        toast.error("Please enter a valid Price in the Data tab.");
        return;
    }

    if (form.value.quantity === "" || form.value.quantity === null || Number(form.value.quantity) < 0) {
        switchToTab('tab-data');
        toast.error("Please enter a valid Quantity in the Data tab.");
        return;
    }

    // 3. Images Tab Validation (Main image must be present either as existing preview or newly uploaded file)
    const hasUploadedMainImage = !!(
        mainImageFile.value?.[0]?.file ||
        mainImageFile.value?.[0] instanceof File ||
        mainImageFile.value?.file instanceof File ||
        mainImageFile.value instanceof File
    );
    const hasExistingMainImage = Array.isArray(mainImagePreviews.value) && mainImagePreviews.value.length > 0 && !!mainImagePreviews.value[0];
    if (!hasExistingMainImage && !hasUploadedMainImage) {
        switchToTab('tab-images');
        toast.error("Please upload the Default Main Image in the Images tab.");
        return;
    }

    // 4. Links Tab Validation (At least one Category is mandatory)
    if (!form.value.category_ids || form.value.category_ids.length === 0) {
        switchToTab('tab-links');
        toast.error("Please select at least one Category in the Links tab.");
        return;
    }

    // 5. Options Validation (if rows were added)
    if (form.value.options && form.value.options.length > 0) {
        const invalidOpt = form.value.options.find(opt => !opt.option_value_id || opt.quantity === '' || opt.quantity === null);
        if (invalidOpt) {
            switchToTab('tab-options');
            toast.error("Please select an Option Value and enter Quantity for all added options.");
            return;
        }
    }

    // 6. FAQs Validation (if rows were added)
    if (form.value.faqs && form.value.faqs.length > 0) {
        const invalidFaq = form.value.faqs.find(faq => !faq.question?.trim() || !faq.answer?.trim());
        if (invalidFaq) {
            switchToTab('tab-faqs');
            toast.error("Please fill in both Question and Answer for all added FAQs.");
            return;
        }
    }

    loading.value = true;

    const formData = new FormData();
    Object.keys(form.value).forEach(key => {
        if (key.startsWith('landing_') || key.startsWith('showcase_')) {
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
        if (form.value.landing_specs_groups && form.value.landing_specs_groups.length > 0) {
            const cleanedGroups = form.value.landing_specs_groups.map((group, gIdx) => {
                if (group.image_file && group.image_file[0]) {
                    formData.append(`landing_specs_group_images[${gIdx}]`, group.image_file[0].file);
                }
                return {
                    tag: group.tag || '',
                    title: group.title || '',
                    image: group.image || '',
                    items: group.items || []
                };
            });
            formData.append('landing_specs_groups', JSON.stringify(cleanedGroups));
        } else {
            formData.append('landing_specs_groups', '[]');
        }

        if (landingHeroImageFile.value && landingHeroImageFile.value[0]) formData.append('landing_hero_image_file', landingHeroImageFile.value[0].file);
        if (landingScienceImageFile.value && landingScienceImageFile.value[0]) formData.append('landing_science_image_file', landingScienceImageFile.value[0].file);
        if (landingLifestyleImageFile.value && landingLifestyleImageFile.value[0]) formData.append('landing_lifestyle_image_file', landingLifestyleImageFile.value[0].file);
        if (landingFilterImageFile.value && landingFilterImageFile.value[0]) formData.append('landing_filter_tech_image_file', landingFilterImageFile.value[0].file);
        if (landingSpecsImageFile.value && landingSpecsImageFile.value[0]) formData.append('landing_specs_image_file', landingSpecsImageFile.value[0].file);
    }

    // Showcase Card Form Submission
    formData.append('showcase_title', form.value.showcase_title || '');
    formData.append('showcase_subtitle', form.value.showcase_subtitle || '');
    formData.append('showcase_modal_subtitle', form.value.showcase_modal_subtitle || '');
    formData.append('showcase_series_badge', form.value.showcase_series_badge || '');
    formData.append('showcase_badge_residential', form.value.showcase_badge_residential || '');
    formData.append('showcase_badge_fresh_air', form.value.showcase_badge_fresh_air || '');
    formData.append('showcase_diagram_brand', form.value.showcase_diagram_brand || '');
    formData.append('showcase_diagram_model', form.value.showcase_diagram_model || '');
    formData.append('showcase_diagram_system', form.value.showcase_diagram_system || '');
    formData.append('showcase_airflow', form.value.showcase_airflow || '');
    formData.append('showcase_power', form.value.showcase_power || '');
    formData.append('showcase_coverage_area', form.value.showcase_coverage_area || '');

    if (form.value.showcase_hero_bg_image) {
        formData.append('showcase_hero_bg_image', form.value.showcase_hero_bg_image);
    }
    if (form.value.showcase_diagram_image) {
        formData.append('showcase_diagram_image', form.value.showcase_diagram_image);
    }

    formData.append('showcase_feature_pills', JSON.stringify(form.value.showcase_feature_pills || []));
    formData.append('showcase_spec_highlights', JSON.stringify(form.value.showcase_spec_highlights || []));
    formData.append('showcase_matched_features', JSON.stringify(form.value.showcase_matched_features || []));
    formData.append('showcase_health_tags', JSON.stringify(form.value.showcase_health_tags || []));

    if (showcaseHeroImageFile.value && showcaseHeroImageFile.value[0]) {
        formData.append('showcase_hero_bg_image_file', showcaseHeroImageFile.value[0].file);
    }
    if (showcaseDiagramImageFile.value && showcaseDiagramImageFile.value[0]) {
        formData.append('showcase_diagram_image_file', showcaseDiagramImageFile.value[0].file);
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

    let mainFileToUpload = null;
    if (mainImageFile.value) {
        if (Array.isArray(mainImageFile.value) && mainImageFile.value.length > 0) {
            const firstItem = mainImageFile.value[0];
            mainFileToUpload = firstItem?.file instanceof File
                ? firstItem.file
                : (firstItem instanceof File ? firstItem : null);
        } else if (mainImageFile.value?.file instanceof File) {
            mainFileToUpload = mainImageFile.value.file;
        } else if (mainImageFile.value instanceof File) {
            mainFileToUpload = mainImageFile.value;
        }
    }

    if (mainFileToUpload) {
        formData.append('main_image', mainFileToUpload);
        deletedFiles.value = deletedFiles.value.filter(f => f !== 'main_image');
    }

    if (galleryImageFiles.value && galleryImageFiles.value.length > 0) {
        let gIdx = 0;
        galleryImageFiles.value.forEach((item) => {
            const rawFile = (item instanceof File) ? item : (item?.file instanceof File ? item.file : null);
            if (rawFile) {
                formData.append(`gallery_images[${gIdx}]`, rawFile);
                gIdx++;
            }
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
        const response = await axios.post(`/api/products/${productId}`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        toast.success("Product updated successfully!");

        // Reset temporary file inputs and sync updated image previews
        // Reset temporary file inputs first so internal dropzone buffers clear
        mainImageFile.value = null;
        galleryImageFiles.value = [];
        showcaseHeroImageFile.value = null;
        showcaseDiagramImageFile.value = null;
        deletedGalleryImages.value = [];
        deletedFiles.value = [];

        // Sync updated image previews with cache-busting timestamp
        const updated = response.data?.data;
        if (updated) {
            const cacheBuster = `?t=${Date.now()}`;
            if (updated.main_image) {
                mainImagePreviews.value = [getImageCacheUrl(updated.main_image, 120, 120, 'webp') + cacheBuster];
            } else {
                mainImagePreviews.value = [];
            }
            if (updated.images && updated.images.length > 0) {
                existingGalleryImages.value = updated.images;
                galleryPreviews.value = updated.images.map(img => getImageCacheUrl(img.image, 120, 120, 'webp') + cacheBuster);
            } else {
                existingGalleryImages.value = [];
                galleryPreviews.value = [];
            }
            if (updated.showcase) {
                if (updated.showcase.hero_bg_image) {
                    showcaseHeroPreviews.value = [getImagePath(updated.showcase.hero_bg_image) + cacheBuster];
                }
                if (updated.showcase.diagram_image) {
                    const rawDiagram = updated.showcase.diagram_image;
                    const diagramUrl = rawDiagram.startsWith('http') || rawDiagram.startsWith('themes/') || rawDiagram.startsWith('assets/')
                        ? (rawDiagram.startsWith('http') ? rawDiagram : `/${rawDiagram}`)
                        : getImageCacheUrl(rawDiagram, 380, 380, 'webp');
                    showcaseDiagramPreviews.value = [diagramUrl + cacheBuster];
                }
            }
            dropzoneKey.value++;
        }
    } catch (error) {
        toast.validationError(error);
    } finally {
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

.showcase-preview-card-wrap {
    max-width: 920px;
    width: 100%;
    margin: 0 auto;
}

.showcase-preview-modal-wrap {
    width: 100%;
}

/* Ductless Card Styling */
.ductless-showcase-card {
    background: #ffffff;
    border-radius: 28px;
    padding: 14px;
    border: 1px solid #eef2f6;
    box-shadow: 0 16px 36px -12px rgba(15, 23, 42, 0.08), 0 1px 3px rgba(15, 23, 42, 0.03);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
    font-family: inherit;
    overflow: hidden;
    display: flex;
    flex-direction: row;
    align-items: stretch;
    gap: 16px;
    box-sizing: border-box;
}

.ductless-showcase-card:hover {
    box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.12), 0 4px 12px rgba(15, 23, 42, 0.05);
}

.ductless-showcase-card__hero {
    position: relative;
    flex: 1 1 50%;
    max-width: 50%;
    min-width: 0;
    background-color: #f1f4f8;
    background-size: cover;
    background-position: center right;
    background-repeat: no-repeat;
    border-radius: 22px;
    padding: 16px 18px 20px 18px;
    min-height: 430px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow: hidden;
    margin: 0;
    box-sizing: border-box;
}

.ductless-showcase-card__badges {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 12px;
    z-index: 2;
    max-width: calc(100% - 50px);
}

.ductless-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 600;
    line-height: 1;
    text-decoration: none;
}

.ductless-badge i {
    font-size: 12px;
    line-height: 1;
}

.ductless-badge--residential {
    background: #fff7ed;
    border: 1px solid #fed7aa;
    color: #c2410c;
}

.ductless-badge--fresh-air {
    background: #dcfce7;
    border: 1px solid #bbf7d0;
    color: #15803d;
}

.ductless-showcase-card__actions {
    position: absolute;
    top: 16px;
    right: 16px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    z-index: 10;
}

.ductless-action-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #ffffff;
    border: 1px solid rgba(226, 232, 240, 0.85);
    box-shadow: 0 4px 10px rgba(15, 23, 42, 0.06);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 0;
    color: #475569;
    font-size: 13px;
    text-decoration: none !important;
}

.ductless-action-btn:hover {
    transform: scale(1.08);
    background-color: #0095da !important;
    border-color: #0095da !important;
    color: #ffffff !important;
    box-shadow: 0 6px 16px rgba(0, 149, 218, 0.25);
}

.ductless-action-btn.active,
.ductless-action-btn.btn-primary {
    background: #0095da !important;
    color: #ffffff !important;
    border-color: #0095da !important;
    box-shadow: 0 4px 14px rgba(0, 149, 218, 0.35) !important;
}

.ductless-action-btn.active i,
.ductless-action-btn.btn-primary i {
    color: #ffffff !important;
}

.ductless-showcase-card__header {
    margin-bottom: 12px;
    z-index: 2;
}

.ductless-showcase-card__title {
    font-size: 24px;
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -0.035em;
    color: #090d16;
    margin: 0;
    max-width: 190px;
    word-break: break-word;
}

.ductless-showcase-card__subtitle {
    font-size: 12px;
    font-weight: 400;
    line-height: 1.35;
    color: #64748B;
    margin: 4px 0 0 0;
    max-width: 180px;
    word-break: break-word;
}

.ductless-showcase-card__pills {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 4px;
    z-index: 2;
    width: max-content;
    max-width: 58%;
}

.ductless-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.96);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border-radius: 8px;
    padding: 5px 9px;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.9);
    font-size: 11px;
    font-weight: 700;
    color: #1e293b;
    white-space: nowrap;
    box-sizing: border-box;
    transition: background 0.15s ease, transform 0.15s ease;
}

.ductless-pill:hover {
    background: #ffffff;
    transform: translateX(2px);
}

.ductless-pill__icon {
    color: #475569;
    flex-shrink: 0;
    font-size: 12px;
}

.ductless-pill__dual-text {
    display: flex;
    flex-direction: column;
    line-height: 1.15;
    text-align: left;
}

.ductless-pill__dual-main {
    font-size: 11px;
    font-weight: 700;
    color: #1e293b;
}

.ductless-pill__dual-sub {
    font-size: 9.5px;
    font-weight: 500;
    color: #64748b;
}

.ductless-quickview-btn {
    position: absolute;
    bottom: 16px;
    right: 28px;
    background: #202938;
    color: #ffffff !important;
    border: 0 !important;
    outline: none !important;
    cursor: pointer;
    border-radius: 9999px;
    padding: 7px 18px;
    font-size: 11.5px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    text-decoration: none !important;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.25);
    z-index: 10;
    transition: all 0.2s ease;
}

.ductless-quickview-btn:hover {
    background: #0f172a;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(15, 23, 42, 0.35);
}

.ductless-showcase-card__body {
    background: #ffffff;
    flex: 1 1 50%;
    max-width: 50%;
    min-width: 0;
    padding: 2px 4px 4px 4px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-sizing: border-box;
}

.ductless-diagram-box {
    background: #f4f9fd;
    border: 1.5px solid #dbeafe;
    border-radius: 18px;
    padding: 16px 18px 14px 18px;
    margin-top: 0;
    margin-bottom: 6px;
    display: flex;
    flex-direction: column;
}

.ductless-diagram-box__meta {
    width: 100%;
}

.ductless-diagram-box__brand {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 0.06em;
    color: #647489;
    text-transform: uppercase;
    display: block;
}

.ductless-diagram-box__model {
    font-size: 16px;
    font-weight: 800;
    color: #0f172a;
    margin: 3px 0 2px 0;
    line-height: 1.25;
    word-break: break-word;
}

.ductless-diagram-box__system {
    font-size: 12px;
    font-weight: 500;
    color: #64748b;
    margin: 0;
    line-height: 1.3;
}

.ductless-diagram-box__illustration {
    margin-top: 10px;
    display: block;
    width: 100%;
}

.ductless-diagram-img {
    width: 100% !important;
    max-width: 100% !important;
    height: auto !important;
    display: block;
    border-radius: 12px;
}

.ductless-specs-bar {
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 10px 4px;
    margin: 4px 0 8px 0;
    text-align: center;
    border: none;
}

.ductless-spec-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    flex: 1;
}

.ductless-spec-item__value {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13.5px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
}

.ductless-spec-item__value i {
    color: #334155;
    font-size: 13px;
}

.ductless-spec-item__label {
    font-size: 11px;
    color: #64748b;
    font-weight: 500;
}

.ductless-specs-bar__divider {
    display: none;
}

.ductless-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 4px 6px 4px 6px;
}

.ductless-buy-btn {
    background: linear-gradient(135deg, #0070f3 0%, #0056c6 100%);
    color: #ffffff !important;
    font-size: 15px;
    font-weight: 700;
    border-radius: 9999px;
    padding: 11px 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none !important;
    box-shadow: 0 6px 18px rgba(0, 112, 243, 0.35);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    cursor: pointer;
    min-width: 140px;
}

.ductless-buy-btn:hover {
    background: linear-gradient(135deg, #0056c6 0%, #0044a0 100%);
    box-shadow: 0 8px 24px rgba(0, 112, 243, 0.45);
    transform: translateY(-2px);
    color: #ffffff !important;
}

.ductless-price-wrap {
    text-align: right;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.ductless-price {
    font-size: 20px;
    font-weight: 800;
    color: #0F172A;
    letter-spacing: -0.02em;
    line-height: 1;
}

.ductless-learn-more {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11.5px;
    font-weight: 700;
    color: #0070f3 !important;
    text-decoration: none !important;
    margin-top: 4px;
}

/* ==========================================================================
   Mobile & Responsive Showcase Card (Matches cart.png Mockup)
   Applied either on screen width <= 860px or when previewDevice === 'mobile'
   ========================================================================== */
.ductless-preview--mobile.ductless-showcase-card,
.ductless-preview--mobile .ductless-showcase-card {
    flex-direction: column !important;
    border-radius: 24px !important;
    padding: 0 !important;
    gap: 0 !important;
}

.ductless-preview--mobile .ductless-showcase-card__hero {
    flex: none !important;
    max-width: 100% !important;
    width: 100% !important;
    min-height: 380px !important;
    border-radius: 24px !important;
    padding: 14px 16px !important;
    background-position: right 6% center !important;
    margin: 0 !important;
    justify-content: flex-start !important;
}

.ductless-preview--mobile .ductless-showcase-card__body {
    flex: none !important;
    max-width: 100% !important;
    width: 100% !important;
    padding: 14px 16px 20px 16px !important;
    display: block !important;
}

.ductless-preview--mobile .ductless-showcase-card__title {
    font-size: 21px !important;
    line-height: 26px !important;
    max-width: 260px !important;
}

.ductless-preview--mobile .ductless-showcase-card__subtitle {
    font-size: 11.5px !important;
    line-height: 16px !important;
    max-width: 240px !important;
}

.ductless-preview--mobile .ductless-showcase-card__pills {
    max-width: 100% !important;
}

.ductless-preview--mobile .ductless-diagram-box {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 12px !important;
    padding: 10px 12px !important;
    border-radius: 16px !important;
    margin-top: 0 !important;
    margin-bottom: 12px !important;
}

.ductless-preview--mobile .ductless-diagram-box__meta {
    flex: 1 1 auto !important;
    min-width: 0 !important;
    width: auto !important;
}

.ductless-preview--mobile .ductless-diagram-box__brand {
    font-size: 10px !important;
    font-weight: 700 !important;
    color: #94a3b8 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.06em !important;
    display: block !important;
}

.ductless-preview--mobile .ductless-diagram-box__model {
    font-size: clamp(11.5px, 0.7rem + 0.5vw, 14px) !important;
    font-weight: 700 !important;
    color: #0f172a !important;
    margin: 2px 0 2px 0 !important;
    line-height: 1.25 !important;
    word-break: break-word !important;
}

.ductless-preview--mobile .ductless-diagram-box__system {
    font-size: 10px !important;
    font-weight: 500 !important;
    color: #64748b !important;
    margin: 0 !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    display: block !important;
}

.ductless-preview--mobile .ductless-diagram-box__illustration {
    flex-shrink: 0 !important;
    width: auto !important;
    max-width: 130px !important;
    margin-top: 0 !important;
    text-align: right !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
}

.ductless-preview--mobile .ductless-diagram-img {
    width: auto !important;
    height: auto !important;
    max-width: 125px !important;
    max-height: 68px !important;
    object-fit: contain !important;
    border-radius: 8px !important;
    display: block !important;
}

.ductless-preview--mobile .ductless-specs-bar {
    display: flex !important;
    align-items: center !important;
    justify-content: space-around !important;
    padding: 9px 4px !important;
    border-top: 1px solid #f1f5f9 !important;
    border-bottom: 1px solid #f1f5f9 !important;
    margin-top: 0 !important;
    margin-bottom: 16px !important;
    text-align: center !important;
}

.ductless-preview--mobile .ductless-specs-bar__divider {
    display: block !important;
    width: 1px !important;
    height: 24px !important;
    background: #e2e8f0 !important;
    flex-shrink: 0 !important;
}

.ductless-preview--mobile .ductless-spec-item {
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    gap: 3px !important;
}

.ductless-preview--mobile .ductless-spec-item__value {
    font-size: 12px !important;
    font-weight: 800 !important;
    color: #0f172a !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 4px !important;
    line-height: 1 !important;
}

.ductless-preview--mobile .ductless-spec-item__value i {
    font-size: 10px !important;
}

.ductless-preview--mobile .ductless-spec-item__label {
    font-size: 10px !important;
    color: #94a3b8 !important;
    font-weight: 500 !important;
}

.ductless-preview--mobile .ductless-card-footer {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 12px !important;
    padding: 0 !important;
}

.ductless-preview--mobile .ductless-buy-btn {
    flex: 1 1 auto !important;
    max-width: none !important;
    width: auto !important;
    padding: 9px 20px !important;
    font-size: 13.5px !important;
    min-height: 40px !important;
    border-radius: 9999px !important;
    min-width: auto !important;
}

.ductless-preview--mobile .ductless-price-wrap {
    text-align: right !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: flex-end !important;
    min-width: max-content !important;
}

.ductless-preview--mobile .ductless-price {
    font-size: 17px !important;
    font-weight: 800 !important;
    color: #0f172a !important;
    letter-spacing: -0.02em !important;
    line-height: 1 !important;
}

.ductless-preview--mobile .ductless-learn-more {
    font-size: 11px !important;
    font-weight: 700 !important;
    color: #0070f3 !important;
    margin-top: 3px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 3px !important;
}

@media (max-width: 860px) {
    .ductless-showcase-card {
        flex-direction: column !important;
        border-radius: 24px !important;
        padding: 0 !important;
        gap: 0 !important;
    }

    .ductless-showcase-card__hero {
        flex: none !important;
        max-width: 100% !important;
        width: 100% !important;
        min-height: 380px !important;
        border-radius: 24px !important;
        padding: 14px 16px !important;
        background-position: right 6% center !important;
        margin: 0 !important;
        justify-content: flex-start !important;
    }

    .ductless-showcase-card__body {
        flex: none !important;
        max-width: 100% !important;
        width: 100% !important;
        padding: 14px 16px 20px 16px !important;
        display: block !important;
    }

    .ductless-showcase-card__title {
        font-size: 21px !important;
        line-height: 26px !important;
        max-width: 260px !important;
    }

    .ductless-showcase-card__subtitle {
        font-size: 11.5px !important;
        line-height: 16px !important;
        max-width: 240px !important;
    }

    .ductless-showcase-card__pills {
        max-width: 100% !important;
    }

    .ductless-diagram-box {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 12px !important;
        padding: 10px 12px !important;
        border-radius: 16px !important;
        margin-top: 0 !important;
        margin-bottom: 12px !important;
    }

    .ductless-diagram-box__meta {
        flex: 1 1 auto !important;
        min-width: 0 !important;
        width: auto !important;
    }

    .ductless-diagram-box__brand {
        font-size: 10px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.06em !important;
        display: block !important;
    }

    .ductless-diagram-box__model {
        font-size: clamp(11.5px, 0.7rem + 0.5vw, 14px) !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        margin: 2px 0 2px 0 !important;
        line-height: 1.25 !important;
        word-break: break-word !important;
    }

    .ductless-diagram-box__system {
        font-size: 10px !important;
        font-weight: 500 !important;
        color: #64748b !important;
        margin: 0 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        display: block !important;
    }

    .ductless-diagram-box__illustration {
        flex-shrink: 0 !important;
        width: auto !important;
        max-width: 130px !important;
        margin-top: 0 !important;
        text-align: right !important;
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
    }

    .ductless-diagram-img {
        width: auto !important;
        height: auto !important;
        /* max-width: 125px !important; */
        /* max-height: 68px !important; */
        object-fit: contain !important;
        border-radius: 8px !important;
        display: block !important;
    }

    .ductless-specs-bar {
        display: flex !important;
        align-items: center !important;
        justify-content: space-around !important;
        padding: 9px 4px !important;
        border-top: 1px solid #f1f5f9 !important;
        border-bottom: 1px solid #f1f5f9 !important;
        margin-top: 0 !important;
        margin-bottom: 16px !important;
        text-align: center !important;
    }

    .ductless-specs-bar__divider {
        display: block !important;
        width: 1px !important;
        height: 24px !important;
        background: #e2e8f0 !important;
        flex-shrink: 0 !important;
    }

    .ductless-spec-item {
        flex: 1 !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        gap: 3px !important;
    }

    .ductless-spec-item__value {
        font-size: 12px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 4px !important;
        line-height: 1 !important;
    }

    .ductless-spec-item__value i {
        font-size: 10px !important;
    }

    .ductless-spec-item__label {
        font-size: 10px !important;
        color: #94a3b8 !important;
        font-weight: 500 !important;
    }

    .ductless-card-footer {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 12px !important;
        padding: 0 !important;
    }

    .ductless-buy-btn {
        flex: 1 1 auto !important;
        max-width: none !important;
        width: auto !important;
        padding: 9px 20px !important;
        font-size: 13.5px !important;
        min-height: 40px !important;
        border-radius: 9999px !important;
        min-width: auto !important;
    }

    .ductless-price-wrap {
        text-align: right !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-end !important;
        min-width: max-content !important;
    }

    .ductless-price {
        font-size: 17px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        letter-spacing: -0.02em !important;
        line-height: 1 !important;
    }

    .ductless-learn-more {
        font-size: 11px !important;
        font-weight: 700 !important;
        color: #0070f3 !important;
        margin-top: 3px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 3px !important;
    }
}

/* Ductless Quick View Modal Styling inside Admin */
.ductless-modal__content {
    background: #ffffff;
    box-shadow: 0 15px 35px -10px rgba(15, 23, 42, 0.12);
    position: relative;
}

.ductless-modal__image-wrapper {
    background-color: #f1f4f8;
    background-size: cover;
    background-position: 75% center;
    background-repeat: no-repeat;
    min-height: 280px;
    height: 100%;
    width: 100%;
}

.ductless-modal__info {
    padding-left: 4px;
}

.ductless-modal__brand {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 0.06em;
    color: #94a3b8;
    text-transform: uppercase;
}

.ductless-modal__series-badge {
    background: #ebf5ff;
    color: #0284c7;
    border: 1px solid #bfdbfe;
    font-size: 10px;
    font-weight: 700;
    border-radius: 9999px;
    padding: 3px 10px;
    line-height: 1;
}

.ductless-modal__title {
    font-size: 18px;
    font-weight: 800;
    color: #090d16;
    line-height: 1.2;
    margin: 6px 0 2px 0;
}

.ductless-modal__subtitle {
    font-size: 12px;
    font-weight: 600;
    color: #334155;
    line-height: 1.35;
    margin-bottom: 8px;
}

.ductless-modal__desc {
    font-size: 11px;
    font-weight: 400;
    color: #64748b;
    line-height: 1.45;
    margin-bottom: 12px;
}

.ductless-modal__specs-grid {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid #e5e7eb;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 12px;
    padding: 6px 0;
    text-align: center;
}

.ductless-modal__spec-col {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    gap: 2px;
    border-right: 1px solid #e2e8f0;
}

.ductless-modal__spec-col:last-child {
    border-right: none;
}

.ductless-modal__spec-label {
    font-size: 9.5px;
    color: #64748b;
    font-weight: 500;
}

.ductless-modal__spec-value {
    font-size: 12px;
    font-weight: 800;
    color: #0F172A;
}

.ductless-modal__matched-section {
    margin-top: 6px;
}

.ductless-modal__matched-title {
    font-size: 11px;
    font-weight: 700;
    color: #090d16;
}

.ductless-modal__matched-sub {
    font-size: 9.5px;
    color: #94A3B8;
}

.ductless-modal__pill-wrap {
    display: grid;
    gap: 6px;
    margin-top: 6px;
}

.ductless-modal__pill {
    background: #fbfcfe;
    border: 1px solid #e2e8f0;
    border-radius: 9999px;
    padding: 4px 8px 4px 10px;
    font-size: 10.5px;
    font-weight: 600;
    color: #1e293b;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.ductless-modal__check {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #1d3f66;
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
}

.ductless-modal__footer {
    border-top: 1px solid #f1f5f9;
    padding-top: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}

.ductless-modal__health-tags {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}

.ductless-modal__health-tag {
    font-size: 10px;
    font-weight: 600;
    color: #475569;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.ductless-modal__cta-wrap {
    display: flex;
    align-items: center;
    gap: 6px;
}

.ductless-modal__btn-view {
    background: #20426b;
    color: #ffffff !important;
    border-radius: 9999px;
    padding: 6px 14px;
    font-size: 11px;
    font-weight: 700;
    border: none;
}

.ductless-modal__btn-compare {
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    color: #334155 !important;
    border-radius: 9999px;
    padding: 5px 14px;
    font-size: 11px;
    font-weight: 600;
}
</style>
