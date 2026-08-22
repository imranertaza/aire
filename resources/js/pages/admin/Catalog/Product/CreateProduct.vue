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
                                <a class="nav-link" id="tab-overview" data-toggle="pill" href="#custom-tabs-overview"
                                    role="tab" aria-controls="custom-tabs-overview" aria-selected="false">Overview</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-specifications" data-toggle="pill" href="#custom-tabs-specifications"
                                    role="tab" aria-controls="custom-tabs-specifications" aria-selected="false">Specifications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-features" data-toggle="pill" href="#custom-tabs-features"
                                    role="tab" aria-controls="custom-tabs-features" aria-selected="false">Features</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-technology" data-toggle="pill" href="#custom-tabs-technology"
                                    role="tab" aria-controls="custom-tabs-technology" aria-selected="false">Technology</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-applications" data-toggle="pill" href="#custom-tabs-applications"
                                    role="tab" aria-controls="custom-tabs-applications" aria-selected="false">Applications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-faqs" data-toggle="pill" href="#custom-tabs-faqs"
                                    role="tab" aria-controls="custom-tabs-faqs" aria-selected="false">FAQs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-images" data-toggle="pill" href="#custom-tabs-images"
                                    role="tab" aria-controls="custom-tabs-images" aria-selected="false">Images</a>
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
                                                    <Vue3Dropzone v-model="overviewImageFile" :allowSelectOnPreview="true" />
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
                                                    <Vue3Dropzone v-model="specsImageFile" :allowSelectOnPreview="true" />
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
                                                    <Vue3Dropzone v-model="featuresImageFile" :allowSelectOnPreview="true" />
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
                                    <div v-if="!form.applications || form.applications.length === 0" class="alert alert-light border text-center py-4">
                                        <i class="fas fa-layer-group fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">No application environments added yet. Click "Add Application" above to configure use-case cards.</p>
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
                                                        <input type="text" class="form-control" v-model="appItem.title" placeholder="e.g. R&D Laboratories" />
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" rows="2" v-model="appItem.description" placeholder="Application description..."></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="appItem.badge" placeholder="e.g. OPTIMIZED FOR DAILY COMMUTE" />
                                                    </td>
                                                    <td>
                                                        <div style="min-width: 150px;">
                                                            <Vue3Dropzone v-model="appItem.bg_image_file" :allowSelectOnPreview="true" />
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
                                                        <input type="number" min="0" class="form-control" v-model.number="appItem.sort_order" />
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm" @click="removeApplication(index)" title="Remove Application">
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
                                                    <Vue3Dropzone v-model="technologyImageFile" :allowSelectOnPreview="true" />
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
                                    <div v-if="!form.faqs || form.faqs.length === 0" class="alert alert-light border text-center py-4">
                                        <i class="fas fa-question-circle fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">No FAQs added for this product yet. Click "Add FAQ" above to add one.</p>
                                    </div>
                                    <div v-else class="table-responsive">
                                        <table class="table table-bordered table-striped align-middle">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 5%;">#</th>
                                                    <th style="width: 35%;">Question <span class="text-danger">*</span></th>
                                                    <th style="width: 45%;">Answer <span class="text-danger">*</span></th>
                                                    <th style="width: 10%;">Sort Order</th>
                                                    <th style="width: 5%;" class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(faq, index) in form.faqs" :key="index">
                                                    <td class="text-center font-weight-bold">{{ index + 1 }}</td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="faq.question" placeholder="e.g. How long do filters last?" />
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" rows="2" v-model="faq.answer" placeholder="Enter detailed answer..."></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0" class="form-control" v-model.number="faq.sort_order" />
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm" @click="removeFaq(index)" title="Remove FAQ">
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
                                            <Vue3Dropzone v-model="mainImageFile" :allowSelectOnPreview="true" />
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <label>Multiple Gallery Images</label>
                                            <Vue3Dropzone v-model="galleryImageFiles" :multiple="true"
                                                :allowSelectOnPreview="true" selectFileStrategy="merge" />
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
import { generateSlug } from '@/layouts/helpers/helpers';
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

    // Overview Section Fields (Section 1)
    overview_title: '',
    overview_description: '',
    overview_feature1_icon: 'bi bi-shield-check',
    overview_feature1_title: '',
    overview_feature1_desc: '',
    overview_feature2_icon: 'bi bi-buildings',
    overview_feature2_title: '',
    overview_feature2_desc: '',

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
const overviewImageFile = ref(null);
const specsImageFile = ref(null);
const featuresImageFile = ref(null);
const technologyImageFile = ref(null);

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
        } else if (['faqs', 'applications'].includes(key)) {
            // Handled separately below
        } else {
            if (form.value[key] !== null && form.value[key] !== '') {
                formData.append(key, form.value[key]);
            }
        }
    });

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

    if (docPdfFile.value && docPdfFile.value[0]) formData.append('documentation_pdf', docPdfFile.value[0].file);
    if (safetyPdfFile.value && safetyPdfFile.value[0]) formData.append('safety_pdf', safetyPdfFile.value[0].file);
    if (instPdfFile.value && instPdfFile.value[0]) formData.append('instructions_pdf', instPdfFile.value[0].file);
    if (descImageFile.value && descImageFile.value[0]) formData.append('description_image', descImageFile.value[0].file);
    if (overviewImageFile.value && overviewImageFile.value[0]) formData.append('overview_image', overviewImageFile.value[0].file);
    if (specsImageFile.value && specsImageFile.value[0]) formData.append('specs_image', specsImageFile.value[0].file);
    if (featuresImageFile.value && featuresImageFile.value[0]) formData.append('features_image', featuresImageFile.value[0].file);
    if (technologyImageFile.value && technologyImageFile.value[0]) formData.append('technology_image', technologyImageFile.value[0].file);

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
