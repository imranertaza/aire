<template>
    <div class="update-section-page">
        <DashboardHeader :title="'Update Section: ' + (form.key || 'Section')">
            <div class="d-flex justify-content-end align-items-center">
                <button type="button" @click="updateSections" class="btn btn-primary" :disabled="saving">
                    <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save Section' }}
                </button>
                <router-link :to="{ name: 'Section' }" class="btn btn-secondary ml-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </router-link>
            </div>
        </DashboardHeader>

        <section class="content">
            <div class="container-fluid">
                <!-- ==================================================== -->
                <!-- SPECIAL MODE: Category Showcase & Solutions Grid     -->
                <!-- ==================================================== -->
                <div v-if="form.key === 'home_category_grid'">
                    <!-- Top Action / CTA Bar Settings -->
                    <div class="card card-primary card-outline shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h3 class="card-title font-weight-bold text-dark">
                                <i class="fas fa-bullhorn text-primary mr-2"></i> Section Action Buttons (Top & Bottom CTA)
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-600">Button Label Text</label>
                                        <input v-model="form.action_text" type="text" class="form-control"
                                            placeholder="e.g. Find Your Solutions" />
                                        <small class="text-muted">Displays on the top and bottom lightbulb pill button.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-600">Target Link URL</label>
                                        <input v-model="form.action_url" type="text" class="form-control"
                                            placeholder="e.g. /category/products or custom link" />
                                        <small class="text-muted">Destination page when user clicks the CTA button.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Row: 4 Bento Category Cards -->
                    <div class="card card-outline card-info shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h3 class="card-title font-weight-bold text-dark">
                                <i class="fas fa-th-large text-info mr-2"></i> Top Row: 4 Bento Category Cards
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-info px-2 py-1">50% Left / 50% Right Cluster</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Card 1: Fresh Air Unit (Left Large Tile) -->
                                <div class="col-lg-6 mb-4">
                                    <div class="card h-100 border bg-light">
                                        <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-wind text-primary mr-1"></i> Slot 1: Left Large Card (Fresh Air)</span>
                                            <span class="badge badge-primary">50% Width</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="small font-weight-bold">Link to Product Category</label>
                                                <Multiselect
                                                    v-model="form.fresh_air_category_id"
                                                    :options="categorySelectOptions"
                                                    :searchable="true"
                                                    placeholder="-- Choose Category (Auto-fills Title & URL) --"
                                                    class="multiselect-custom"
                                                    @select="() => onCategorySelect('fresh_air')"
                                                    @clear="() => onCategoryClear('fresh_air')"
                                                />
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="small font-weight-bold">Badge Title <span class="text-danger">*</span></label>
                                                        <input v-model="form.fresh_air_title" type="text" class="form-control form-control-sm" placeholder="Fresh Air Unit" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="small font-weight-bold">Target Link URL</label>
                                                        <input v-model="form.fresh_air_url" type="text" class="form-control form-control-sm" placeholder="/category/..." />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Card Background Image</label>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="border rounded p-1 bg-white" style="width: 80px; height: 60px; overflow: hidden; flex-shrink: 0;">
                                                        <img :src="gridPreviews.fresh_air_image || getImageUrl(form.fresh_air_image)" class="w-100 h-100" style="object-fit: cover;" alt="Preview" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <input type="file" accept="image/*" class="form-control-file form-control-sm" @change="(e) => onGridFileChange(e, 'fresh_air_image')" />
                                                        <small class="text-muted d-block mt-1">Recommended: 4:3 ratio</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 2: Air Pro Mask (Middle Top Tile) -->
                                <div class="col-lg-6 mb-4">
                                    <div class="card h-100 border bg-light">
                                        <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-head-side-mask text-info mr-1"></i> Slot 2: Middle Top Card (Masks)</span>
                                            <span class="badge badge-light border">25% Width</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="small font-weight-bold">Link to Product Category</label>
                                                <Multiselect
                                                    v-model="form.mask_category_id"
                                                    :options="categorySelectOptions"
                                                    :searchable="true"
                                                    placeholder="-- Choose Category --"
                                                    class="multiselect-custom"
                                                    @select="() => onCategorySelect('mask')"
                                                    @clear="() => onCategoryClear('mask')"
                                                />
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="small font-weight-bold">Badge Title <span class="text-danger">*</span></label>
                                                        <input v-model="form.mask_title" type="text" class="form-control form-control-sm" placeholder="Air Pro Mask" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="small font-weight-bold">Target Link URL</label>
                                                        <input v-model="form.mask_url" type="text" class="form-control form-control-sm" placeholder="/category/..." />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Card Background Image</label>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="border rounded p-1 bg-white" style="width: 80px; height: 60px; overflow: hidden; flex-shrink: 0;">
                                                        <img :src="gridPreviews.mask_image || getImageUrl(form.mask_image)" class="w-100 h-100" style="object-fit: cover;" alt="Preview" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <input type="file" accept="image/*" class="form-control-file form-control-sm" @change="(e) => onGridFileChange(e, 'mask_image')" />
                                                        <small class="text-muted d-block mt-1">Recommended: 1:1 or 4:3 ratio</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 3: Accessories (Middle Bottom Tile) -->
                                <div class="col-lg-6 mb-4">
                                    <div class="card h-100 border bg-light">
                                        <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-tools text-warning mr-1"></i> Slot 3: Middle Bottom Card (Accessories)</span>
                                            <span class="badge badge-light border">25% Width</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="small font-weight-bold">Link to Product Category</label>
                                                <Multiselect
                                                    v-model="form.accessories_category_id"
                                                    :options="categorySelectOptions"
                                                    :searchable="true"
                                                    placeholder="-- Choose Category --"
                                                    class="multiselect-custom"
                                                    @select="() => onCategorySelect('accessories')"
                                                    @clear="() => onCategoryClear('accessories')"
                                                />
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="small font-weight-bold">Badge Title <span class="text-danger">*</span></label>
                                                        <input v-model="form.accessories_title" type="text" class="form-control form-control-sm" placeholder="Accessories" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="small font-weight-bold">Target Link URL</label>
                                                        <input v-model="form.accessories_url" type="text" class="form-control form-control-sm" placeholder="/category/..." />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Card Background Image</label>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="border rounded p-1 bg-white" style="width: 80px; height: 60px; overflow: hidden; flex-shrink: 0;">
                                                        <img :src="gridPreviews.accessories_image || getImageUrl(form.accessories_image)" class="w-100 h-100" style="object-fit: cover;" alt="Preview" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <input type="file" accept="image/*" class="form-control-file form-control-sm" @change="(e) => onGridFileChange(e, 'accessories_image')" />
                                                        <small class="text-muted d-block mt-1">Recommended: 1:1 or 4:3 ratio</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 4: Air Purifiers (Right Tall Tile) -->
                                <div class="col-lg-6 mb-4">
                                    <div class="card h-100 border bg-light">
                                        <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-fan text-success mr-1"></i> Slot 4: Right Tall Card (Purifiers)</span>
                                            <span class="badge badge-success">25% Width Full Height</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="small font-weight-bold">Link to Product Category</label>
                                                <Multiselect
                                                    v-model="form.purifier_category_id"
                                                    :options="categorySelectOptions"
                                                    :searchable="true"
                                                    placeholder="-- Choose Category --"
                                                    class="multiselect-custom"
                                                    @select="() => onCategorySelect('purifier')"
                                                    @clear="() => onCategoryClear('purifier')"
                                                />
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="small font-weight-bold">Badge Title <span class="text-danger">*</span></label>
                                                        <input v-model="form.purifier_title" type="text" class="form-control form-control-sm" placeholder="Air Purifiers" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="small font-weight-bold">Target Link URL</label>
                                                        <input v-model="form.purifier_url" type="text" class="form-control form-control-sm" placeholder="/category/..." />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Card Background Image</label>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="border rounded p-1 bg-white" style="width: 80px; height: 60px; overflow: hidden; flex-shrink: 0;">
                                                        <img :src="gridPreviews.purifier_image || getImageUrl(form.purifier_image)" class="w-100 h-100" style="object-fit: cover;" alt="Preview" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <input type="file" accept="image/*" class="form-control-file form-control-sm" @change="(e) => onGridFileChange(e, 'purifier_image')" />
                                                        <small class="text-muted d-block mt-1">Recommended: 3:4 portrait ratio (e.g. 800x1067)</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Row: 2 Solutions Banners (50% / 50%) -->
                    <div class="card card-outline card-purple shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h3 class="card-title font-weight-bold text-dark">
                                <i class="fas fa-layer-group text-purple mr-2"></i> Bottom Row: 2 Solutions Banners (50% / 50%)
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-purple px-2 py-1">Full Width Half-Half</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Banner 5: Solutions for Home -->
                                <div class="col-lg-6 mb-4">
                                    <div class="card h-100 border bg-light">
                                        <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-home text-primary mr-1"></i> Slot 5: Solutions for Home</span>
                                            <span class="badge badge-primary">50% Width Banner</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="small font-weight-bold">Link to Product Category</label>
                                                <Multiselect
                                                    v-model="form.home_solutions_category_id"
                                                    :options="categorySelectOptions"
                                                    :searchable="true"
                                                    placeholder="-- Choose Category --"
                                                    class="multiselect-custom"
                                                    @select="() => onCategorySelect('home_solutions')"
                                                    @clear="() => onCategoryClear('home_solutions')"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <label class="small font-weight-bold">Banner Headline <span class="text-danger">*</span></label>
                                                <input v-model="form.home_solutions_title" type="text" class="form-control form-control-sm" placeholder="Solutions for Home" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small font-weight-bold">Subtitle / Description</label>
                                                <input v-model="form.home_solutions_sub" type="text" class="form-control form-control-sm" placeholder="Ventilation and Filtration Solution" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small font-weight-bold">Target Link URL</label>
                                                <input v-model="form.home_solutions_url" type="text" class="form-control form-control-sm" placeholder="/category/..." />
                                            </div>
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Banner Background Image</label>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="border rounded p-1 bg-white" style="width: 100px; height: 60px; overflow: hidden; flex-shrink: 0;">
                                                        <img :src="gridPreviews.home_solutions_image || getImageUrl(form.home_solutions_image)" class="w-100 h-100" style="object-fit: cover;" alt="Preview" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <input type="file" accept="image/*" class="form-control-file form-control-sm" @change="(e) => onGridFileChange(e, 'home_solutions_image')" />
                                                        <small class="text-muted d-block mt-1">Recommended: 16:9 landscape ratio (e.g. 1400x780)</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Banner 6: Solutions for Business -->
                                <div class="col-lg-6 mb-4">
                                    <div class="card h-100 border bg-light">
                                        <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-building text-info mr-1"></i> Slot 6: Solutions for Business</span>
                                            <span class="badge badge-info">50% Width Banner</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="small font-weight-bold">Link to Product Category</label>
                                                <Multiselect
                                                    v-model="form.biz_solutions_category_id"
                                                    :options="categorySelectOptions"
                                                    :searchable="true"
                                                    placeholder="-- Choose Category --"
                                                    class="multiselect-custom"
                                                    @select="() => onCategorySelect('biz_solutions')"
                                                    @clear="() => onCategoryClear('biz_solutions')"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <label class="small font-weight-bold">Banner Headline <span class="text-danger">*</span></label>
                                                <input v-model="form.biz_solutions_title" type="text" class="form-control form-control-sm" placeholder="Solutions for Business" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small font-weight-bold">Subtitle / Description</label>
                                                <input v-model="form.biz_solutions_sub" type="text" class="form-control form-control-sm" placeholder="Air Disinfection & Air Monitoring" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small font-weight-bold">Target Link URL</label>
                                                <input v-model="form.biz_solutions_url" type="text" class="form-control form-control-sm" placeholder="/category/..." />
                                            </div>
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Banner Background Image</label>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="border rounded p-1 bg-white" style="width: 100px; height: 60px; overflow: hidden; flex-shrink: 0;">
                                                        <img :src="gridPreviews.biz_solutions_image || getImageUrl(form.biz_solutions_image)" class="w-100 h-100" style="object-fit: cover;" alt="Preview" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <input type="file" accept="image/*" class="form-control-file form-control-sm" @change="(e) => onGridFileChange(e, 'biz_solutions_image')" />
                                                        <small class="text-muted d-block mt-1">Recommended: 16:9 landscape ratio (e.g. 1400x780)</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Bar -->
                    <div class="d-flex justify-content-end align-items-center mb-5">
                        <router-link :to="{ name: 'Section' }" class="btn btn-secondary mr-2">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </router-link>
                        <button type="button" @click="updateSections" class="btn btn-primary" :disabled="saving">
                            <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save & Update Category Grid' }}
                        </button>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- SPECIAL MODE: Why Choose AIRE (Stacked Cards)        -->
                <!-- ==================================================== -->
                <div v-else-if="form.key === 'why_choose_aire'">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-sliders-h mr-1"></i> Section Settings
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Section Title <span class="text-danger">*</span></label>
                                        <input v-model="form.title" type="text" class="form-control"
                                            placeholder="e.g. Why Choose AIRE?" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subtitle / Tagline</label>
                                        <input v-model="form.subtitle" type="text" class="form-control"
                                            placeholder="e.g. THE AIRE STANDARD" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cards Deck Manager -->
                    <div class="card card-purple card-outline">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">
                                <i class="fas fa-layer-group mr-1"></i> Stacked Solution Cards ({{ form.cards.length }})
                            </h3>
                            <div class="card-tools ml-auto">
                                <button type="button" class="btn btn-sm btn-success" @click="addCard">
                                    <i class="fas fa-plus mr-1"></i> Add New Card
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3" v-for="(card, index) in form.cards" :key="index">
                                    <div class="card card-outline"
                                        :class="card.theme === 'dark' ? 'card-dark' : 'card-primary'">
                                        <div class="card-header py-2">
                                            <h3 class="card-title font-weight-bold" style="font-size: 0.95rem;">
                                                <span class="badge"
                                                    :class="card.theme === 'dark' ? 'badge-dark' : 'badge-primary'">Layer {{
                                                        index + 1 }}</span>
                                                <span class="ml-2">{{ card.dots || '•••' }} {{ (card.title ? card.title.replace(/<[^>]*>/g, ' ') : '') || 'Untitled Card' }}</span>
                                            </h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" :disabled="index === 0"
                                                    @click="moveCard(index, -1)" title="Move Up">
                                                    <i class="fas fa-arrow-up"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool"
                                                    :disabled="index === form.cards.length - 1" @click="moveCard(index, 1)"
                                                    title="Move Down">
                                                    <i class="fas fa-arrow-down"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool text-danger"
                                                    :disabled="form.cards.length <= 1" @click="removeCard(index)"
                                                    title="Remove Card">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body py-3">
                                            <div class="form-group mb-2">
                                                <label class="small font-weight-bold">Card Title <span class="text-danger">*</span> <small
                                                        class="text-muted">(Supports &lt;br&gt; for line
                                                        break)</small></label>
                                                <input v-model="card.title" type="text" class="form-control form-control-sm"
                                                    placeholder="e.g. Medical-Grade<br>Precision" required />
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group mb-2">
                                                        <label class="small font-weight-bold">Header Dots</label>
                                                        <input v-model="card.dots" type="text"
                                                            class="form-control form-control-sm" placeholder="e.g. •••" />
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group mb-2">
                                                        <label class="small font-weight-bold">Card Theme</label>
                                                        <select v-model="card.theme" class="custom-select custom-select-sm">
                                                            <option value="dark">Dark (Black background)</option>
                                                            <option value="light">Light (White background)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Description <span class="text-danger">*</span></label>
                                                <textarea v-model="card.description" rows="3"
                                                    class="form-control form-control-sm"
                                                    placeholder="Write card description here..." required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-success" @click="addCard">
                                <i class="fas fa-plus mr-1"></i> Add Another Card
                            </button>
                            <div>
                                <button type="button" @click="updateSections" class="btn btn-primary" :disabled="saving">
                                    <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save & Update Section' }}
                                </button>
                                <router-link :to="{ name: 'Section' }" class="btn btn-secondary ml-2">
                                    Cancel
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- SPECIAL MODE: Home Lifestyle (Alternating Rows)      -->
                <!-- ==================================================== -->
                <div v-else-if="form.key === 'home_lifestyle' || form.key === 'lifestyle'">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-couch mr-1"></i> Lifestyle Showcase Section Settings
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Section Badge / Tagline <span class="text-danger">*</span></label>
                                        <input v-model="form.badge" type="text" class="form-control"
                                            placeholder="e.g. LIFESTYLE" required />
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Section Title <span class="text-danger">*</span></label>
                                        <input v-model="form.title" type="text" class="form-control"
                                            placeholder="e.g. Seamless Living, Cleaner Air" required />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Section Subtitle <span class="text-danger">*</span></label>
                                        <textarea v-model="form.subtitle" class="form-control" rows="2"
                                            placeholder="Write section subtitle here..." required></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Lifestyle Items Repeater -->
                            <h4 class="mt-4 mb-3 font-weight-bold text-dark border-bottom pb-2">
                                <i class="fas fa-th-list mr-1 text-primary"></i> Lifestyle Showcase Items ({{ form.items?.length || 0 }})
                            </h4>

                            <div v-for="(item, index) in form.items" :key="index" class="card mb-3 border shadow-sm">
                                <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold text-dark">
                                        <i class="fas fa-layer-group text-primary mr-1"></i> Item #{{ index + 1 }}
                                        <small class="badge badge-secondary ml-2 font-weight-normal">
                                            {{ index % 2 === 0 ? 'Layout: Text Left, Image Right' : 'Layout: Image Left, Text Right' }}
                                        </small>
                                    </span>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool btn-xs" :disabled="index === 0"
                                            @click="moveLifestyleItem(index, -1)" title="Move Up">
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool btn-xs"
                                            :disabled="index === form.items.length - 1"
                                            @click="moveLifestyleItem(index, 1)" title="Move Down">
                                            <i class="fas fa-arrow-down"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool btn-xs text-danger"
                                            :disabled="form.items.length <= 1" @click="removeLifestyleItem(index)"
                                            title="Remove Item">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body py-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label class="small font-weight-bold">Item Title <span class="text-danger">*</span></label>
                                                <input v-model="item.title" type="text" class="form-control"
                                                    placeholder="e.g. Bedroom Serenity" required />
                                            </div>
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Item Description <span class="text-danger">*</span></label>
                                                <textarea v-model="item.description" rows="3" class="form-control"
                                                    placeholder="Write description..." required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Item Image <span class="text-danger">*</span></label>
                                                <Vue3Dropzone v-model="item.dropzoneFile" v-model:previews="item.previews"
                                                    mode="edit" :allowSelectOnPreview="true" :maxFiles="1" />
                                                <div class="mt-1 small text-muted">
                                                    Recommended: <strong>856 × 385px</strong> or <strong>1200 × 540px</strong> (Wide Landscape ~2.2:1)
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-success mt-2" @click="addLifestyleItem">
                                <i class="fas fa-plus mr-1"></i> Add Another Lifestyle Item
                            </button>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <div>
                                <span class="text-muted small">Items automatically alternate image and text alignment on the homepage.</span>
                            </div>
                            <div>
                                <button type="button" @click="updateSections" class="btn btn-primary" :disabled="saving">
                                    <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save & Update Lifestyle' }}
                                </button>
                                <router-link :to="{ name: 'Section' }" class="btn btn-secondary ml-2">
                                    Cancel
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- SPECIAL MODE: Home Benefits (Parallax Banner + Cards)-->
                <!-- ==================================================== -->
                <div v-else-if="form.key === 'home_benefits' || form.key === 'benefits'">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-layer-group mr-1"></i> Benefits Parallax Section Settings
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Section Badge / Tagline <span class="text-danger">*</span></label>
                                        <input v-model="form.badge" type="text" class="form-control"
                                            placeholder="e.g. BENEFITS" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Section Title <span class="text-danger">*</span></label>
                                        <input v-model="form.title" type="text" class="form-control"
                                            placeholder="e.g. Pure Air, Healthy Living" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Section Subtitle <span class="text-danger">*</span></label>
                                        <textarea v-model="form.subtitle" class="form-control" rows="3"
                                            placeholder="e.g. Get authentic products, fast delivery, and trusted local service — only from us."
                                            required></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Parallax Background Banner Image <span class="text-danger">*</span></label>
                                        <Vue3Dropzone v-model="fileUpload" v-model:previews="previews" mode="edit"
                                            :allowSelectOnPreview="true" :maxFiles="1" />
                                        <div class="mt-2 p-2 bg-light border rounded small">
                                            <i class="fas fa-info-circle text-primary mr-1"></i>
                                            Recommended: <strong>1920 × 800px</strong> or <strong>1400 × 700px</strong> (Panoramic landscape banner)
                                        </div>
                                        <div v-if="previews && previews.length && previews[0]" class="mt-2">
                                            <img :src="previews[0]" class="img-thumbnail" style="max-height: 100px;" />
                                        </div>
                                        <div v-else-if="form.image" class="mt-2 d-flex align-items-center">
                                            <img :src="getImageUrl(form.image)" class="img-thumbnail mr-2" style="max-height: 60px;" />
                                            <small class="text-muted font-monospace">{{ form.image }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Benefit Cards Repeater -->
                            <h4 class="mt-4 mb-3 font-weight-bold text-dark border-bottom pb-2">
                                <i class="fas fa-th-large mr-1 text-primary"></i> Benefit Cards ({{ form.cards?.length || 0 }})
                            </h4>

                            <div class="row">
                                <div v-for="(card, index) in form.cards" :key="index" class="col-md-4 mb-3">
                                    <div class="card h-100 shadow-sm border">
                                        <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                            <span class="font-weight-bold text-primary small">Card #{{ index + 1 }}</span>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool btn-xs" :disabled="index === 0"
                                                    @click="moveCard(index, -1)" title="Move Left / Up">
                                                    <i class="fas fa-arrow-left"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool btn-xs"
                                                    :disabled="index === form.cards.length - 1"
                                                    @click="moveCard(index, 1)" title="Move Right / Down">
                                                    <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body py-2">
                                            <div class="form-group mb-2">
                                                <label class="small font-weight-bold">Title <span class="text-danger">*</span></label>
                                                <input v-model="card.title" type="text" class="form-control form-control-sm"
                                                    placeholder="e.g. Authentic Products" required />
                                            </div>
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Description <span class="text-danger">*</span></label>
                                                <textarea v-model="card.description" rows="2" class="form-control form-control-sm"
                                                    placeholder="Card description..." required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <div>
                                <span class="text-muted small">All changes take effect immediately on the homepage.</span>
                            </div>
                            <div>
                                <button type="button" @click="updateSections" class="btn btn-primary" :disabled="saving">
                                    <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save & Update Benefits' }}
                                </button>
                                <router-link :to="{ name: 'Section' }" class="btn btn-secondary ml-2">
                                    Cancel
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- SPECIAL MODE: Trust Badges                           -->
                <!-- ==================================================== -->
                            <!-- ==================================================== -->
            <!-- SPECIAL MODE: FAQ Accordion (home_faq)               -->
            <!-- ==================================================== -->
            <div v-else-if="form.key === 'home_faq' || form.key === 'faq'">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-question-circle mr-1"></i> FAQ Section Settings
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Section Badge</label>
                                    <input v-model="form.badge" type="text" class="form-control"
                                        placeholder="e.g. SUPPORT" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Section Title <span class="text-danger">*</span></label>
                                    <input v-model="form.title" type="text" class="form-control"
                                        placeholder="e.g. Frequently Asked Questions" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Subtitle / Supporting Text</label>
                                    <input v-model="form.subtitle" type="text" class="form-control"
                                        placeholder="Optional supporting tagline" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Items Repeater -->
                <div class="card card-info card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-list-ol mr-1"></i> Questions & Answers ({{ form.items?.length || 0 }})
                        </h3>
                        <div class="card-tools ml-auto">
                            <button type="button" class="btn btn-sm btn-success" @click="addFaqItem">
                                <i class="fas fa-plus mr-1"></i> Add New Question
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="!form.items || form.items.length === 0" class="alert alert-light text-center py-4">
                            <i class="fas fa-question-circle fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-2">No FAQ items defined yet.</p>
                            <button type="button" class="btn btn-sm btn-primary" @click="addFaqItem">
                                <i class="fas fa-plus mr-1"></i> Add Your First FAQ
                            </button>
                        </div>

                        <div v-for="(item, index) in form.items" :key="'faq-' + index"
                            class="card card-light mb-3 border">
                            <div class="card-header d-flex justify-content-between align-items-center py-2 bg-light">
                                <div class="font-weight-bold">
                                    <span class="badge badge-secondary mr-2">Q{{ index + 1 }}</span>
                                    {{ item.question ? (item.question.length > 70 ? item.question.substring(0, 70) + '...' : item.question) : 'Untitled Question' }}
                                </div>
                                <div class="card-tools ml-auto">
                                    <button type="button" class="btn btn-tool btn-xs" :disabled="index === 0"
                                        @click="moveFaqItem(index, -1)" title="Move Up">
                                        <i class="fas fa-arrow-up"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool btn-xs"
                                        :disabled="index === form.items.length - 1"
                                        @click="moveFaqItem(index, 1)" title="Move Down">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool btn-xs text-danger"
                                        :disabled="form.items.length <= 1" @click="removeFaqItem(index)"
                                        title="Remove Question">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="font-weight-bold">Question <span class="text-danger">*</span></label>
                                    <input v-model="item.question" type="text" class="form-control"
                                        placeholder="e.g. How long do the filters last?" required />
                                </div>
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold">Answer <span class="text-danger">*</span></label>
                                    <textarea v-model="item.answer" class="form-control" rows="3"
                                        placeholder="Enter the detailed answer..." required></textarea>
                                </div>
                            </div>
                        </div>

                        <div v-if="form.items && form.items.length > 0" class="text-center mt-3">
                            <button type="button" class="btn btn-outline-success" @click="addFaqItem">
                                <i class="fas fa-plus mr-1"></i> Add Another Question
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else-if="form.key === 'trust_badges'">
                    <div class="card card-info card-outline">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">
                                <i class="fas fa-shield-alt mr-1"></i> Trust Badges ({{ form.badges.length }})
                            </h3>
                            <div class="card-tools ml-auto">
                                <button type="button" class="btn btn-sm btn-success" @click="addBadge">
                                    <i class="fas fa-plus mr-1"></i> Add New Badge
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3" v-for="(badge, index) in form.badges" :key="index">
                                    <div class="card card-outline card-info">
                                        <div class="card-header py-2">
                                            <h3 class="card-title font-weight-bold" style="font-size: 0.95rem;">
                                                <i :class="badge.icon" class="mr-1"></i>
                                                <span class="ml-1">{{ badge.title || 'Untitled Badge' }}</span>
                                            </h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" :disabled="index === 0"
                                                    @click="moveBadge(index, -1)" title="Move Up">
                                                    <i class="fas fa-arrow-up"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool"
                                                    :disabled="index === form.badges.length - 1"
                                                    @click="moveBadge(index, 1)" title="Move Down">
                                                    <i class="fas fa-arrow-down"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool text-danger"
                                                    :disabled="form.badges.length <= 1" @click="removeBadge(index)"
                                                    title="Remove Badge">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body py-3">
                                            <div class="form-group mb-2">
                                                <label class="small font-weight-bold">Badge Title <span class="text-danger">*</span></label>
                                                <input v-model="badge.title" type="text"
                                                    class="form-control form-control-sm" placeholder="e.g. SECURE PAYMENTS"
                                                    required />
                                            </div>

                                            <div class="form-group mb-2">
                                                <label class="small font-weight-bold">Icon Class <span class="text-danger">*</span> <small
                                                        class="text-muted">(Bootstrap Icons)</small></label>
                                                <input v-model="badge.icon" type="text" class="form-control form-control-sm"
                                                    placeholder="e.g. bi-shield-check" required />
                                                <small class="d-block mt-1"><a href="https://icons.getbootstrap.com/"
                                                        target="_blank">Browse Icons</a></small>
                                            </div>

                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Description <span class="text-danger">*</span></label>
                                                <textarea v-model="badge.description" rows="2"
                                                    class="form-control form-control-sm"
                                                    placeholder="Write badge description here..." required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-success" @click="addBadge">
                                <i class="fas fa-plus mr-1"></i> Add Another Badge
                            </button>
                            <div>
                                <button type="button" @click="updateSections" class="btn btn-primary" :disabled="saving">
                                    <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save & Update Badges' }}
                                </button>
                                <router-link :to="{ name: 'Section' }" class="btn btn-secondary ml-2">
                                    Cancel
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- ==================================================== -->
            <!-- SPECIAL MODE: Home Video Banner (home_video)          -->
            <!-- ==================================================== -->
            <div v-else-if="form.key === 'home_video' || form.key === 'video'" class="video-editor-wrapper">
                <div class="card video-master-card border-0 shadow-sm">
                    <!-- Premium Header -->
                    <div class="card-header video-editor-header py-3 px-4 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="video-header-badge mr-3">
                                <i class="fas fa-film"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 font-weight-bold text-dark">Homepage Video Banner</h4>
                                <p class="text-muted small mb-0">Manage headline, video media stream, local uploads, and poster artwork</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-pill badge-light-danger border text-danger mr-3 px-3 py-2 font-weight-bold d-none d-md-inline-flex align-items-center">
                                <i class="fas fa-circle mr-1 small text-danger pulse-dot"></i> Live on Storefront
                            </span>
                            <button type="button" @click="updateSections" class="btn btn-primary px-4 shadow-sm font-weight-bold" :disabled="saving">
                                <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving Changes...' : 'Save Video Section' }}
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Left Column: Controls (7 Cols) -->
                            <div class="col-xl-7 col-lg-6 col-md-12">
                                <!-- Card 1: Headline -->
                                <div class="card setting-card mb-4 border shadow-none">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="setting-step-num mr-2">1</div>
                                            <label class="font-weight-bold text-dark mb-0">Headline & Section Title <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-right-0 text-muted">
                                                    <i class="fas fa-heading"></i>
                                                </span>
                                            </div>
                                            <input v-model="form.title" type="text" class="form-control border-left-0 pl-0 font-weight-500"
                                                placeholder="e.g. AIRE Pro S1 — Engineering Architecture & Air Purification" required />
                                        </div>
                                        <small class="form-text text-muted mt-1">This title is displayed on the homepage right above the video frame.</small>
                                    </div>
                                </div>

                                <!-- Card 2: Video Source Switcher -->
                                <div class="card setting-card mb-4 border shadow-none">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="setting-step-num mr-2">2</div>
                                                <label class="font-weight-bold text-dark mb-0">Video Media Source <span class="text-danger">*</span></label>
                                            </div>
                                            <!-- Pill Tab Switcher -->
                                            <div class="video-tab-switcher p-1 bg-light rounded-pill border d-inline-flex">
                                                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 font-weight-bold transition-all"
                                                    :class="videoSourceMode === 'url' ? 'btn-white shadow-sm text-primary' : 'text-muted border-0 bg-transparent'"
                                                    @click="videoSourceMode = 'url'">
                                                    <i class="fas fa-link mr-1"></i> Direct URL / Path
                                                </button>
                                                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 font-weight-bold transition-all"
                                                    :class="videoSourceMode === 'upload' ? 'btn-white shadow-sm text-primary' : 'text-muted border-0 bg-transparent'"
                                                    @click="videoSourceMode = 'upload'">
                                                    <i class="fas fa-cloud-upload-alt mr-1"></i> Upload Video File
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Sub-view A: URL / Path Input -->
                                        <div v-show="videoSourceMode === 'url'" class="source-panel p-3 rounded bg-light border">
                                            <label class="small font-weight-bold text-muted mb-2 text-uppercase">Relative Storage Path or External Link</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white border-right-0 text-muted">
                                                        <i class="fas fa-globe"></i>
                                                    </span>
                                                </div>
                                                <input v-model="form.video_url" type="text" class="form-control border-left-0 pl-0 font-monospace"
                                                    placeholder="storage/home/home-video.mp4 or https://cdn.example.com/video.mp4" />
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary" title="Reset to default local path"
                                                        @click="form.video_url = 'storage/home/home-video.mp4'">
                                                        <i class="fas fa-undo mr-1"></i> Default
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Enter a storage path (e.g. <code>storage/home/home-video.mp4</code>) or direct HTTPS URL.</small>
                                                <span class="badge badge-light border text-muted">Direct Stream</span>
                                            </div>
                                        </div>

                                        <!-- Sub-view B: File Drag & Drop Upload Zone -->
                                        <div v-show="videoSourceMode === 'upload'" class="source-panel">
                                            <!-- Hidden native file input -->
                                            <input type="file" ref="videoFileInput" accept="video/mp4,video/webm,video/ogg,video/quicktime"
                                                @change="handleVideoFileChange" class="d-none" />

                                            <!-- Custom Drop Area -->
                                            <div class="video-drop-area text-center p-4 rounded"
                                                :class="{ 'is-dragging': isDraggingVideo, 'has-file': selectedVideoFile }"
                                                @dragover.prevent="isDraggingVideo = true"
                                                @dragleave.prevent="isDraggingVideo = false"
                                                @drop.prevent="handleVideoDrop"
                                                @click="triggerVideoBrowse">
                                                
                                                <!-- When a new file is chosen -->
                                                <div v-if="selectedVideoFile" class="file-chosen-box">
                                                    <div class="video-icon-circle bg-success-light text-success mx-auto mb-2">
                                                        <i class="fas fa-check-circle fa-2x"></i>
                                                    </div>
                                                    <h6 class="font-weight-bold text-dark mb-1">{{ selectedVideoFile.name }}</h6>
                                                    <p class="text-muted small mb-2">
                                                        File size: <strong>{{ (selectedVideoFile.size / (1024 * 1024)).toFixed(2) }} MB</strong> • Ready to upload on save
                                                    </p>
                                                    <div class="d-inline-flex gap-2">
                                                        <button type="button" class="btn btn-xs btn-outline-primary mr-2" @click.stop="triggerVideoBrowse">
                                                            <i class="fas fa-sync-alt mr-1"></i> Choose Different Video
                                                        </button>
                                                        <button type="button" class="btn btn-xs btn-outline-danger" @click.stop="cancelVideoFile">
                                                            <i class="fas fa-times mr-1"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- When no file is selected yet -->
                                                <div v-else>
                                                    <div class="video-icon-circle bg-primary-light text-primary mx-auto mb-2">
                                                        <i class="fas fa-cloud-upload-alt fa-2x"></i>
                                                    </div>
                                                    <h6 class="font-weight-bold text-dark mb-1">Drag and drop video here, or <span class="text-primary cursor-pointer text-underline">Browse</span></h6>
                                                    <p class="text-muted small mb-2">Upload an optimized MP4, WebM, or MOV video file (up to 100MB)</p>
                                                    <div class="d-flex justify-content-center flex-wrap">
                                                        <span class="badge badge-light border text-muted px-2 py-1 mr-1">MP4</span>
                                                        <span class="badge badge-light border text-muted px-2 py-1 mr-1">WEBM</span>
                                                        <span class="badge badge-light border text-muted px-2 py-1 mr-1">MOV</span>
                                                        <span class="badge badge-light border text-muted px-2 py-1">Max 100 MB</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Server file notice if existing -->
                                            <div v-if="form.video_file && !selectedVideoFile" class="mt-2 p-2 px-3 bg-white border rounded d-flex justify-content-between align-items-center">
                                                <div class="text-truncate mr-2 small">
                                                    <i class="fas fa-server text-info mr-2"></i>
                                                    <span class="text-muted">Current file on server:</span>
                                                    <code class="ml-1 text-dark">{{ form.video_file }}</code>
                                                </div>
                                                <button type="button" class="btn btn-xs btn-outline-danger" @click="removeServerVideo" title="Remove server video file">
                                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 3: Poster Image Upload -->
                                <div class="card setting-card border shadow-none">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center">
                                                <div class="setting-step-num mr-2">3</div>
                                                <label class="font-weight-bold text-dark mb-0">Video Poster / Cover Artwork <span class="text-danger">*</span></label>
                                            </div>
                                            <span class="badge badge-light border text-muted small">
                                                <i class="fas fa-vector-square mr-1"></i> 1920 × 1080px or 1280 × 720px (16:9 Widescreen)
                                            </span>
                                        </div>
                                        
                                        <div class="poster-dropzone-wrapper border rounded p-3 bg-light">
                                            <Vue3Dropzone v-model="fileUpload" v-model:previews="previews" mode="edit"
                                                :maxFileSize="10" accept="image/png,image/jpeg,image/webp,image/svg+xml" />
                                            <div v-if="previews && previews.length && previews[0]" class="mt-3 p-2 bg-white rounded border d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <img :src="previews[0]" class="rounded shadow-sm mr-3" style="width: 54px; height: 54px; object-fit: cover; border: 1px solid #dee2e6;" />
                                                    <div>
                                                        <div class="font-weight-bold small text-dark">Active Poster Thumbnail</div>
                                                        <div class="text-muted text-xs">Shown before user clicks play</div>
                                                    </div>
                                                </div>
                                                <span class="badge badge-success px-2 py-1 small">
                                                    <i class="fas fa-check mr-1"></i> Loaded
                                                </span>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted mt-2">
                                            <i class="fas fa-info-circle text-primary mr-1"></i>
                                            Optimized high-resolution artwork prevents video black screens before playback begins.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Luxury Cinematic Live Monitor (5 Cols) -->
                            <div class="col-xl-5 col-lg-6 col-md-12 mt-4 mt-lg-0">
                                <div class="cinema-monitor-container sticky-top" style="top: 20px;">
                                    <div class="cinema-device shadow-lg">
                                        <!-- Top Monitor Header Bar -->
                                        <div class="cinema-header d-flex justify-content-between align-items-center px-3 py-2">
                                            <div class="cinema-dots d-flex align-items-center">
                                                <span class="dot red mr-1"></span>
                                                <span class="dot yellow mr-1"></span>
                                                <span class="dot green"></span>
                                            </div>
                                            <div class="cinema-title font-weight-bold text-xs text-uppercase tracking-wider">
                                                <i class="fas fa-desktop mr-1 text-muted"></i> Live Monitor Preview
                                            </div>
                                            <div class="cinema-status d-flex align-items-center">
                                                <span class="recording-pulse mr-1"></span>
                                                <span class="text-xs font-weight-bold text-success">READY</span>
                                            </div>
                                        </div>

                                        <!-- 16:9 Screen Container -->
                                        <div class="cinema-screen position-relative">
                                            <video controls
                                                :poster="previewPosterUrl"
                                                :src="previewVideoUrl"
                                                class="w-100 h-100 d-block cinema-video">
                                                Your browser does not support HTML5 video.
                                            </video>

                                            <!-- Live Title Overlay inside Screen -->
                                            <div class="cinema-title-overlay">
                                                <span class="badge badge-dark bg-black-alpha border border-white-10 text-white font-weight-normal px-2 py-1">
                                                    <i class="fas fa-eye mr-1 text-primary"></i> {{ form.title || 'Untitled Section' }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Diagnostic Stats Strip -->
                                        <div class="cinema-footer p-3 bg-dark-slate text-white-50">
                                            <div class="row text-center text-xs">
                                                <div class="col-4 border-right border-secondary">
                                                    <div class="text-muted text-uppercase mb-1">Source</div>
                                                    <div class="text-white font-weight-bold text-truncate" :title="activeSourceLabel">
                                                        {{ activeSourceLabel }}
                                                    </div>
                                                </div>
                                                <div class="col-4 border-right border-secondary">
                                                    <div class="text-muted text-uppercase mb-1">Cover Poster</div>
                                                    <div class="text-white font-weight-bold text-truncate">
                                                        {{ previews && previews[0] ? 'Custom' : 'Default' }}
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="text-muted text-uppercase mb-1">Ratio</div>
                                                    <div class="text-white font-weight-bold">16 : 9 Cinema</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Help Info Box below monitor -->
                                    <div class="card bg-light border-0 shadow-none mt-3 p-3 text-muted small rounded-lg">
                                        <div class="d-flex">
                                            <i class="fas fa-lightbulb text-warning fa-lg mr-2 mt-1"></i>
                                            <div>
                                                <strong>Design Tip:</strong> On the storefront, the video features custom sound/mute and play/pause controls, autoplay with intersection observer, and smooth zoom overlay on hover.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Action Bar -->
                    <div class="card-footer bg-light px-4 py-3 d-flex justify-content-between align-items-center">
                        <router-link :to="{ name: 'Section' }" class="btn btn-outline-secondary px-3">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Sections
                        </router-link>
                        <div class="d-flex align-items-center">
                            <span v-if="saving" class="text-muted small mr-3">
                                <i class="fas fa-spinner fa-spin mr-1"></i> Updating section...
                            </span>
                            <button type="button" @click="updateSections" class="btn btn-primary px-4 shadow-sm" :disabled="saving">
                                <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving Changes...' : 'Save & Publish Video' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

                <!-- ==================================================== -->
                <!-- SPECIAL MODE: Best Selling Products (home_best_selling) -->
                <!-- ==================================================== -->
                <div v-else-if="['home_best_selling', 'best_selling', 'home_new_arrival', 'new_arrival', 'home_customer_favorites', 'customer_favorites'].includes(form.key)">
                    <!-- Section Header Settings -->
                    <div class="card card-warning card-outline mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-sliders-h mr-1 text-warning"></i> Section Header Settings
                            </h3>
                            <span :class="['home_customer_favorites', 'customer_favorites'].includes(form.key) ? 'badge badge-primary text-white' : (['home_new_arrival', 'new_arrival'].includes(form.key) ? 'badge badge-info text-white' : 'badge badge-warning text-dark')" class="px-2 py-1 font-weight-bold">
                                <i :class="['home_customer_favorites', 'customer_favorites'].includes(form.key) ? 'fas fa-heart mr-1' : (['home_new_arrival', 'new_arrival'].includes(form.key) ? 'fas fa-box-open mr-1' : 'fas fa-star mr-1')"></i> {{ ['home_customer_favorites', 'customer_favorites'].includes(form.key) ? 'Customers Favorites Showcase' : (['home_new_arrival', 'new_arrival'].includes(form.key) ? 'New Arrivals Showcase' : 'Best Selling Showcase') }}
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
                    <div class="card card-primary card-outline mb-4">
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
                                <button type="button" @click="updateSections" class="btn btn-primary px-4 shadow-sm" :disabled="saving">
                                    <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving Changes...' : 'Save & Publish Products' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- SPECIAL MODE: Living Hero (home_living_hero)         -->
                <!-- ==================================================== -->
                <div v-else-if="['home_living_hero', 'living_hero'].includes(form.key)" class="living-hero-editor-wrapper">
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
                                <button type="button" @click="updateSections" class="btn btn-primary px-4 shadow-sm font-weight-bold" :disabled="saving">
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

                                            <Vue3Dropzone v-model="fileUpload" v-model:previews="previews" mode="edit"
                                                :allowSelectOnPreview="true" :maxFiles="1" />
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
                                <button type="button" @click="updateSections" class="btn btn-primary px-4 shadow-sm" :disabled="saving">
                                    <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving Changes...' : 'Save & Publish Living Hero' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- ABOUT PAGE: about_hero                               -->
                <!-- ==================================================== -->
                <div v-else-if="form.key === 'about_hero'">
                    <div class="card card-primary card-outline shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-heading mr-1"></i> About Page Top Header
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Subheading Badge <span class="text-danger">*</span></label>
                                        <input v-model="form.badge" type="text" class="form-control" placeholder="e.g. OUR STORY" required />
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Main Heading Title <span class="text-danger">*</span></label>
                                        <input v-model="form.title" type="text" class="form-control" placeholder="e.g. A Cleaner Tomorrow Starts Here" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold">Lead Paragraph / Subtitle <span class="text-danger">*</span></label>
                                        <textarea v-model="form.subtitle" rows="3" class="form-control" placeholder="Enter introductory lead text..." required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- ABOUT PAGE: about_story (Journey, Milestones, Impact) -->
                <!-- ==================================================== -->
                <div v-else-if="form.key === 'about_story'">
                    <!-- Section Meta Header -->
                    <div class="card card-info card-outline shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-clock mr-1"></i> Section 1: Our Story Header
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Section #</label>
                                        <input v-model="form.number" type="number" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Accordion Title <span class="text-danger">*</span></label>
                                        <input v-model="form.title" type="text" class="form-control" placeholder="e.g. Our Journey" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Accordion Subtitle</label>
                                        <input v-model="form.subtitle" type="text" class="form-control" placeholder="Brief subtitle..." />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Journey Hero Banner Card -->
                    <div class="card card-primary card-outline shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-image mr-1"></i> Journey Hero Card
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Hero Card Title <span class="text-danger">*</span></label>
                                        <input v-model="form.hero_title" type="text" class="form-control" placeholder="e.g. Our Journey" />
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Hero Description</label>
                                        <textarea v-model="form.hero_desc" rows="4" class="form-control" placeholder="Describe the company journey..."></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Button Text</label>
                                                <input v-model="form.button_text" type="text" class="form-control form-control-sm" placeholder="e.g. Explore Our History" />
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Button Target Link</label>
                                                <input v-model="form.button_link" type="text" class="form-control form-control-sm" placeholder="e.g. #milestones" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Banner Image Path / URL</label>
                                        <input v-model="form.hero_image" type="text" class="form-control font-monospace" placeholder="themes/default/assets/img/about/mountains.jpg" />
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold">Image Badge Overlay Text <small class="text-muted">(Supports line breaks)</small></label>
                                        <textarea v-model="form.hero_badge" rows="3" class="form-control" placeholder="CLEANER AIR&#10;BRIGHTER SPACES&#10;A HEALTHIER TOMORROW"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Milestones Timeline Manager -->
                    <div class="card card-purple card-outline shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-history mr-1"></i> Historical Milestones Timeline ({{ form.milestones?.length || 0 }})
                            </h3>
                            <div class="card-tools ml-auto">
                                <button type="button" class="btn btn-sm btn-success" @click="addMilestone">
                                    <i class="fas fa-plus mr-1"></i> Add Milestone
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div v-for="(m, index) in form.milestones" :key="'milestone-' + index" class="card border mb-3">
                                <div class="card-header py-2 bg-light d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold text-primary">
                                        <i class="fas fa-flag mr-1"></i> Milestone #{{ index + 1 }} &mdash; <strong>{{ m.year || 'Year' }}</strong>: {{ m.title || 'Untitled' }}
                                    </span>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" :disabled="index === 0" @click="moveMilestone(index, -1)" title="Move Up">
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" :disabled="index === form.milestones.length - 1" @click="moveMilestone(index, 1)" title="Move Down">
                                            <i class="fas fa-arrow-down"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool text-danger" :disabled="form.milestones.length <= 1" @click="removeMilestone(index)" title="Remove">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body py-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group mb-2">
                                                <label class="small font-weight-bold">Year / Era <span class="text-danger">*</span></label>
                                                <input v-model="m.year" type="text" class="form-control form-control-sm" placeholder="e.g. 1988 or Today" required />
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group mb-2">
                                                <label class="small font-weight-bold">Milestone Title <span class="text-danger">*</span></label>
                                                <input v-model="m.title" type="text" class="form-control form-control-sm" placeholder="e.g. The Beginning" required />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-1">
                                                <label class="small font-weight-bold">Description <span class="text-danger">*</span></label>
                                                <textarea v-model="m.desc" rows="2" class="form-control form-control-sm" placeholder="Describe the milestone event..." required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Impact & Statistics -->
                    <div class="card card-success card-outline shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-chart-line mr-1"></i> Impact Banner & Worldwide Statistics
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Impact Title</label>
                                        <input v-model="form.impact_title" type="text" class="form-control" placeholder="e.g. A Healthier World Through Cleaner Air" />
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Impact Description</label>
                                        <textarea v-model="form.impact_desc" rows="3" class="form-control" placeholder="Describe global impact..."></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Impact Image</label>
                                        <input v-model="form.impact_image" type="text" class="form-control font-monospace" placeholder="themes/default/assets/img/apartments.jpg" />
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Impact Badge Overlay</label>
                                        <textarea v-model="form.impact_badge" rows="2" class="form-control" placeholder="CLEANER AIR&#10;BRIGHTER SPACES&#10;A HEALTHIER TOMORROW"></textarea>
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="font-weight-bold mb-0">Impact Stat Cards ({{ form.stats?.length || 0 }})</label>
                                <button type="button" class="btn btn-xs btn-outline-success" @click="addStat">
                                    <i class="fas fa-plus mr-1"></i> Add Stat Card
                                </button>
                            </div>
                            <div class="row">
                                <div v-for="(st, idx) in form.stats" :key="'stat-' + idx" class="col-md-6 mb-3">
                                    <div class="card border p-3 h-100 bg-light">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge badge-success">Stat #{{ idx + 1 }}</span>
                                            <button type="button" class="btn btn-xs btn-link text-danger p-0" :disabled="form.stats.length <= 1" @click="removeStat(idx)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="small font-weight-bold">Icon Class</label>
                                                <input v-model="st.icon" type="text" class="form-control form-control-sm font-monospace" placeholder="bi bi-globe" />
                                            </div>
                                            <div class="col-8">
                                                <label class="small font-weight-bold">Stat Title</label>
                                                <input v-model="st.title" type="text" class="form-control form-control-sm" placeholder="e.g. 100+ Countries" />
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label class="small font-weight-bold">Description</label>
                                                <textarea v-model="st.desc" rows="2" class="form-control form-control-sm" placeholder="Stat description..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold">Section Quote</label>
                                        <input v-model="form.quote" type="text" class="form-control" placeholder="e.g. Real change happens when cleaner air becomes a right for everyone..." />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold">Quote Brand Subtext</label>
                                        <input v-model="form.quote_brand" type="text" class="form-control" placeholder="CLEANER AIR | BRIGHTER SPACES" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- ABOUT PAGE: about_mission_vision                     -->
                <!-- ==================================================== -->
                <div v-else-if="form.key === 'about_mission_vision'">
                    <div class="card card-success card-outline shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-bullseye mr-1"></i> Section 2: Mission & Vision Settings
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Section #</label>
                                        <input v-model="form.number" type="number" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Title <span class="text-danger">*</span></label>
                                        <input v-model="form.title" type="text" class="form-control" placeholder="e.g. Mission & Vision" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Subtitle</label>
                                        <input v-model="form.subtitle" type="text" class="form-control" placeholder="e.g. Our purpose, values and commitment..." />
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-compass text-primary mr-1"></i> Purpose Banner</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Purpose Title</label>
                                        <input v-model="form.purpose_title" type="text" class="form-control" placeholder="e.g. Our Purpose" />
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Purpose Description</label>
                                        <textarea v-model="form.purpose_desc" rows="3" class="form-control" placeholder="Describe the core purpose..."></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Purpose Image</label>
                                        <input v-model="form.purpose_image" type="text" class="form-control font-monospace" placeholder="themes/default/assets/img/about/earth_purpose.jpg" />
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Purpose Badge Overlay</label>
                                        <textarea v-model="form.purpose_badge" rows="2" class="form-control" placeholder="CLEANER AIR&#10;BRIGHTER SPACES&#10;A HEALTHIER TOMORROW"></textarea>
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-columns text-info mr-1"></i> Mission & Vision Pillars</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="card p-3 border">
                                        <label class="font-weight-bold text-primary">Mission Title</label>
                                        <input v-model="form.mission_title" type="text" class="form-control mb-2" placeholder="e.g. Our Mission" />
                                        <label class="font-weight-bold">Mission Statement</label>
                                        <textarea v-model="form.mission_desc" rows="3" class="form-control" placeholder="Mission details..."></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card p-3 border">
                                        <label class="font-weight-bold text-info">Vision Title</label>
                                        <input v-model="form.vision_title" type="text" class="form-control mb-2" placeholder="e.g. Our Vision" />
                                        <label class="font-weight-bold">Vision Statement</label>
                                        <textarea v-model="form.vision_desc" rows="3" class="form-control" placeholder="Vision details..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="font-weight-bold text-dark mb-0"><i class="fas fa-heart text-danger mr-1"></i> Core Values ({{ form.values?.length || 0 }})</h5>
                                <button type="button" class="btn btn-xs btn-outline-success" @click="addValue">
                                    <i class="fas fa-plus mr-1"></i> Add Core Value
                                </button>
                            </div>
                            <div class="row">
                                <div v-for="(val, idx) in form.values" :key="'val-' + idx" class="col-md-6 mb-3">
                                    <div class="card border p-3 h-100 bg-light">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge badge-success">Value #{{ idx + 1 }}</span>
                                            <button type="button" class="btn btn-xs btn-link text-danger p-0" :disabled="form.values.length <= 1" @click="removeValue(idx)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="small font-weight-bold">Icon Class</label>
                                                <input v-model="val.icon" type="text" class="form-control form-control-sm font-monospace" placeholder="bi bi-heart" />
                                            </div>
                                            <div class="col-8">
                                                <label class="small font-weight-bold">Value Title</label>
                                                <input v-model="val.title" type="text" class="form-control form-control-sm" placeholder="e.g. People First" />
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label class="small font-weight-bold">Description</label>
                                                <textarea v-model="val.desc" rows="2" class="form-control form-control-sm" placeholder="Value explanation..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold">Section Quote</label>
                                        <input v-model="form.quote" type="text" class="form-control" placeholder="e.g. Clean air empowers people, strengthens communities..." />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold">Quote Brand Subtext</label>
                                        <input v-model="form.quote_brand" type="text" class="form-control" placeholder="CLEANER AIR | BRIGHTER SPACES" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- ABOUT PAGE: about_leadership                         -->
                <!-- ==================================================== -->
                <div v-else-if="form.key === 'about_leadership'">
                    <div class="card card-teal card-outline shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-users mr-1"></i> Section 3: Leadership Team Settings
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Section #</label>
                                        <input v-model="form.number" type="number" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Title <span class="text-danger">*</span></label>
                                        <input v-model="form.title" type="text" class="form-control" placeholder="e.g. Leadership" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Subtitle</label>
                                        <input v-model="form.subtitle" type="text" class="form-control" placeholder="e.g. Meet the people driving innovation..." />
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-id-badge text-teal mr-1"></i> Leadership Banner Showcase</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Banner Badge</label>
                                        <input v-model="form.banner_badge" type="text" class="form-control" placeholder="e.g. OUR LEADERSHIP" />
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Banner Title</label>
                                        <input v-model="form.banner_title" type="text" class="form-control" placeholder="e.g. People with Purpose" />
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Banner Description</label>
                                        <textarea v-model="form.banner_desc" rows="3" class="form-control" placeholder="Describe the leadership commitment..."></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Banner Image Path</label>
                                        <input v-model="form.banner_image" type="text" class="form-control font-monospace" placeholder="themes/default/assets/img/about/leadership.jpg" />
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Banner Badge Overlay</label>
                                        <textarea v-model="form.banner_badge_text" rows="2" class="form-control" placeholder="CLEANER AIR&#10;BRIGHTER SPACES&#10;A HEALTHIER TOMORROW"></textarea>
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Team Grid Heading</label>
                                        <input v-model="form.team_heading" type="text" class="form-control" placeholder="e.g. Meet Our Leadership Team" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Team Grid Subtitle</label>
                                        <input v-model="form.team_subheading" type="text" class="form-control" placeholder="A diverse group of visionaries..." />
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="font-weight-bold text-dark mb-0"><i class="fas fa-user-tie text-primary mr-1"></i> Executive Members ({{ form.members?.length || 0 }})</h5>
                                <button type="button" class="btn btn-sm btn-success" @click="addMember">
                                    <i class="fas fa-plus mr-1"></i> Add Member
                                </button>
                            </div>

                            <div class="row">
                                <div v-for="(mem, idx) in form.members" :key="'member-' + idx" class="col-md-6 mb-3">
                                    <div class="card border shadow-none h-100">
                                        <div class="card-header py-2 bg-light d-flex justify-content-between align-items-center">
                                            <span class="font-weight-bold text-dark">
                                                <i class="fas fa-user mr-1 text-teal"></i> {{ mem.name || 'Member Name' }} &mdash; <small class="text-muted">{{ mem.role || 'Role' }}</small>
                                            </span>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" :disabled="idx === 0" @click="moveMember(idx, -1)" title="Move Up">
                                                    <i class="fas fa-arrow-up"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool" :disabled="idx === form.members.length - 1" @click="moveMember(idx, 1)" title="Move Down">
                                                    <i class="fas fa-arrow-down"></i>
                                                </button>
                                                <button type="button" class="btn btn-tool text-danger" :disabled="form.members.length <= 1" @click="removeMember(idx)" title="Remove">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body py-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group mb-2">
                                                        <label class="small font-weight-bold">Full Name <span class="text-danger">*</span></label>
                                                        <input v-model="mem.name" type="text" class="form-control form-control-sm" placeholder="e.g. Dr. James Liu" required />
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group mb-2">
                                                        <label class="small font-weight-bold">Designation / Role <span class="text-danger">*</span></label>
                                                        <input v-model="mem.role" type="text" class="form-control form-control-sm" placeholder="e.g. Chief Executive Officer" required />
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group mb-2">
                                                        <label class="small font-weight-bold">Short Bio <span class="text-danger">*</span></label>
                                                        <textarea v-model="mem.bio" rows="2" class="form-control form-control-sm" placeholder="Short biographical sentence..." required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group mb-0">
                                                        <label class="small font-weight-bold">Photo URL / Path <small class="text-muted">(Leave blank for icon placeholder)</small></label>
                                                        <input v-model="mem.image" type="text" class="form-control form-control-sm font-monospace" placeholder="themes/default/assets/img/team/member1.jpg" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold">Section Quote</label>
                                        <input v-model="form.quote" type="text" class="form-control" placeholder="e.g. Great things happen when passionate people work together..." />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold">Quote Brand Subtext</label>
                                        <input v-model="form.quote_brand" type="text" class="form-control" placeholder="CLEANER AIR | BRIGHTER SPACES" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- ABOUT PAGE: about_innovation / quality / global      -->
                <!-- ==================================================== -->
                <div v-else-if="['about_innovation', 'about_quality', 'about_global'].includes(form.key)">
                    <div class="card card-primary card-outline shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-layer-group mr-1"></i> {{ form.title || form.key }} Settings
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Section #</label>
                                        <input v-model="form.number" type="number" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Title <span class="text-danger">*</span></label>
                                        <input v-model="form.title" type="text" class="form-control" placeholder="Section Title" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Subtitle</label>
                                        <input v-model="form.subtitle" type="text" class="form-control" placeholder="Section Subtitle" />
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="font-weight-bold text-dark mb-0"><i class="fas fa-th-list text-primary mr-1"></i> Feature Cards ({{ form.items?.length || 0 }})</h5>
                                <button type="button" class="btn btn-sm btn-success" @click="addGenericItem">
                                    <i class="fas fa-plus mr-1"></i> Add Card
                                </button>
                            </div>

                            <div class="row">
                                <div v-for="(item, idx) in form.items" :key="'item-' + idx" class="col-md-6 mb-3">
                                    <div class="card border p-3 h-100 bg-light">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge badge-primary">Card #{{ idx + 1 }}</span>
                                            <button type="button" class="btn btn-xs btn-link text-danger p-0" :disabled="form.items.length <= 1" @click="removeGenericItem(idx)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="small font-weight-bold">Icon Class</label>
                                                <input v-model="item.icon" type="text" class="form-control form-control-sm font-monospace" placeholder="bi bi-award" />
                                            </div>
                                            <div class="col-8">
                                                <label class="small font-weight-bold">Card Title <span class="text-danger">*</span></label>
                                                <input v-model="item.title" type="text" class="form-control form-control-sm" placeholder="e.g. ISO 9001 & 14001" required />
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label class="small font-weight-bold">Description <span class="text-danger">*</span></label>
                                                <textarea v-model="item.desc" rows="2" class="form-control form-control-sm" placeholder="Card description..." required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- ABOUT PAGE: about_careers                            -->
                <!-- ==================================================== -->
                <div v-else-if="form.key === 'about_careers'">
                    <div class="card card-purple card-outline shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-briefcase mr-1"></i> Careers Section Settings
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Section #</label>
                                        <input v-model="form.number" type="number" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Accordion Title <span class="text-danger">*</span></label>
                                        <input v-model="form.title" type="text" class="form-control" placeholder="e.g. Careers" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Accordion Subtitle</label>
                                        <input v-model="form.subtitle" type="text" class="form-control" placeholder="e.g. Join our team and help shape a healthier world." />
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Card Title <span class="text-danger">*</span></label>
                                        <input v-model="form.card_title" type="text" class="form-control" placeholder="e.g. Build the Future of Clean Air" required />
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Card Description <span class="text-danger">*</span></label>
                                        <textarea v-model="form.card_desc" rows="3" class="form-control" placeholder="Describe the career opportunity..." required></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label class="font-weight-bold">Button Text</label>
                                                <input v-model="form.button_text" type="text" class="form-control" placeholder="e.g. View Open Positions" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label class="font-weight-bold">Button Target Link</label>
                                                <input v-model="form.button_link" type="text" class="form-control" placeholder="e.g. /contact-us" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- ABOUT PAGE: about_news                               -->
                <!-- ==================================================== -->
                <div v-else-if="form.key === 'about_news'">
                    <div class="card card-danger card-outline shadow-sm mb-4">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">
                                <i class="fas fa-newspaper mr-1"></i> News & Media Section Settings
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Section #</label>
                                        <input v-model="form.number" type="number" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Accordion Title <span class="text-danger">*</span></label>
                                        <input v-model="form.title" type="text" class="form-control" placeholder="e.g. News & Media" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Accordion Subtitle</label>
                                        <input v-model="form.subtitle" type="text" class="form-control" placeholder="e.g. Latest news, press releases and media coverage." />
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Media Center Banner Title</label>
                                        <input v-model="form.banner_title" type="text" class="form-control" placeholder="e.g. Official Press & Media Center" />
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Media Center Banner Description</label>
                                        <textarea v-model="form.banner_desc" rows="2" class="form-control" placeholder="Stay informed with our latest announcements..."></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label class="font-weight-bold">Button Text</label>
                                                <input v-model="form.button_text" type="text" class="form-control" placeholder="e.g. Media Inquiries" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label class="font-weight-bold">Button Target Link</label>
                                                <input v-model="form.button_link" type="text" class="form-control" placeholder="e.g. /contact-us" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Footer Bar for About Page Sections -->
                <div v-if="form.key && form.key.startsWith('about_')" class="card bg-white border shadow-sm p-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <router-link :to="{ name: 'AboutSections' }" class="btn btn-outline-secondary px-3">
                            <i class="fas fa-arrow-left mr-1"></i> Back to About Sections
                        </router-link>
                        <div class="d-flex align-items-center">
                            <button type="button" @click="updateSections" class="btn btn-primary px-4 shadow-sm font-weight-bold" :disabled="saving">
                                <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving Changes...' : 'Save & Publish Section' }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- STANDARD MODE: Other General Sections                -->
                <!-- ==================================================== -->
                <div v-else>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit mr-1"></i> General Section Content
                            </h3>
                        </div>
                        <form @submit.prevent="updateSections">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Section Title <span class="text-danger">*</span></label>
                                            <input v-model="form.title" type="text" class="form-control"
                                                placeholder="Enter section title..." required />
                                        </div>

                                        <div class="form-group">
                                            <label>Section Content</label>
                                            <RichTextEditor v-model="form.content"
                                                placeholder="Write section details here..." class="editor" />
                                        </div>

                                        <div v-if="form.key == 'about_mission_vision'" class="form-group">
                                            <label>Home Page Content</label>
                                            <RichTextEditor v-model="form.home_content"
                                                placeholder="Write home page variant content here..." class="editor" />
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Upload Image</label>
                                            <Vue3Dropzone v-model="fileUpload" v-model:previews="previews" mode="edit"
                                                :allowSelectOnPreview="true" />
                                            <small v-if="form.key == 'history_history'"
                                                class="form-text text-muted">Recommended: 520 × 705px (Portrait)</small>
                                            <small v-else class="form-text text-muted">Recommended: 600 × 400px or 800 × 500px (Landscape)</small>
                                            <div v-if="previews && previews.length && previews[0]" class="mt-2">
                                                <img :src="previews[0]" class="img-thumbnail" style="max-height: 100px;" />
                                            </div>
                                            <div v-else-if="form.image" class="mt-2 d-flex align-items-center">
                                                <img :src="getImageUrl(form.image)" class="img-thumbnail mr-2" style="max-height: 60px;" />
                                                <small class="text-muted font-monospace">{{ form.image }}</small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select v-model="form.status" class="custom-select" required>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>

                                        <div class="mt-4 pt-2">
                                            <button type="submit" class="btn btn-primary btn-block" :disabled="saving">
                                                <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Update Section' }}
                                            </button>
                                            <router-link :to="{ name: 'Section' }" class="btn btn-secondary btn-block mt-2">
                                                Cancel
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import axios from "axios";
import { computed, onMounted, reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";

import DashboardHeader from "@/components/DashboardHeader.vue";
import { useToast } from "@/composables/useToast";
import { getImageCacheUrl, getImageUrl } from "@/layouts/helpers/helpers";
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import "@jaxtheprime/vue3-dropzone/dist/style.css";
import RichTextEditor from "@/components/RichTextEditor.vue";
import Multiselect from "@vueform/multiselect";
import "@vueform/multiselect/themes/default.css";

const props = defineProps({
    id: {
        type: [String, Number],
        default: null,
    },
});

const toast = useToast();
const route = useRoute();
const router = useRouter();
const saving = ref(false);

// Reactive form state
const form = reactive({
    id: null,
    title: "",
    badge: "BENEFITS",
    subtitle: "",
    key: "",
    content: "",
    home_content: "",
    number: null,
    hero_title: "",
    hero_desc: "",
    hero_image: "",
    hero_badge: "",
    milestones: [],
    impact_title: "",
    impact_desc: "",
    impact_image: "",
    impact_badge: "",
    stats: [],
    purpose_title: "",
    purpose_desc: "",
    purpose_image: "",
    purpose_badge: "",
    mission_title: "",
    mission_desc: "",
    vision_title: "",
    vision_desc: "",
    values: [],
    banner_badge: "",
    banner_title: "",
    banner_desc: "",
    banner_image: "",
    banner_badge_text: "",
    team_heading: "",
    team_subheading: "",
    members: [],
    card_title: "",
    card_desc: "",
    quote: "",
    quote_brand: "",
    items: [],
    cards: [],
    badges: [],
    product_ids: [],
    product_id: null,
    button_text: "Buy Now",
    button_link: "",
    enabled: 1,
    description: "",
    file: "",
    image: "",
    video_url: "",
    video_file: "",
    // Category Showcase Grid
    action_text: "Find Your Solutions",
    action_url: "/category/products",

    fresh_air_category_id: null,
    fresh_air_title: "Fresh Air Unit",
    fresh_air_url: "/category/fresh-air-systems",
    fresh_air_image: "",

    mask_category_id: null,
    mask_title: "Air Pro Mask",
    mask_url: "/category/smart-wearable-masks",
    mask_image: "",

    accessories_category_id: null,
    accessories_title: "Accessories",
    accessories_url: "/category/accessories-parts",
    accessories_image: "",

    purifier_category_id: null,
    purifier_title: "Air Purifiers",
    purifier_url: "/category/air-purifiers",
    purifier_image: "",

    home_solutions_category_id: null,
    home_solutions_title: "Solutions for Home",
    home_solutions_sub: "Ventilation and Filtration Solution",
    home_solutions_url: "/category/home-fresh-air-systems",
    home_solutions_image: "",

    biz_solutions_category_id: null,
    biz_solutions_title: "Solutions for Business",
    biz_solutions_sub: "Air Disinfection & Air Monitoring",
    biz_solutions_url: "/category/commercial-fresh-air-systems",
    biz_solutions_image: "",

    status: "1",
    createdBy: 1,
    updatedBy: null,
});

// Category Showcase Grid specific state & helpers
const allCategories = ref([]);
const loadingCategories = ref(false);

const loadCategories = async () => {
    try {
        loadingCategories.value = true;
        const res = await axios.get("/api/product-categories/all");
        allCategories.value = res.data.data || [];
    } catch (err) {
        console.error("Failed to load categories dropdown", err);
    } finally {
        loadingCategories.value = false;
    }
};

const categorySelectOptions = computed(() => {
    return allCategories.value.map((c) => ({
        value: c.id,
        label: c.category_name,
        slug: c.slug,
        image: c.image,
    }));
});

const onCategorySelect = (slotPrefix) => {
    const catId = form[`${slotPrefix}_category_id`];
    if (!catId) return;
    const cat = allCategories.value.find((c) => Number(c.id) === Number(catId));
    if (cat) {
        if (!form[`${slotPrefix}_title`] || form[`${slotPrefix}_title`] === 'Untitled') {
            form[`${slotPrefix}_title`] = cat.category_name;
        }
        form[`${slotPrefix}_url`] = `/category/${cat.slug}`;
    }
};

const onCategoryClear = (slotPrefix) => {
    form[`${slotPrefix}_category_id`] = null;
};

const gridFiles = reactive({
    fresh_air_image_file: null,
    mask_image_file: null,
    accessories_image_file: null,
    purifier_image_file: null,
    home_solutions_image_file: null,
    biz_solutions_image_file: null,
});

const gridPreviews = reactive({
    fresh_air_image: '',
    mask_image: '',
    accessories_image: '',
    purifier_image: '',
    home_solutions_image: '',
    biz_solutions_image: '',
});

const onGridFileChange = (e, key) => {
    const file = e.target.files?.[0];
    if (file) {
        gridFiles[`${key}_file`] = file;
        gridPreviews[key] = URL.createObjectURL(file);
    }
};

// Best Selling Products specific state & helpers
const allProducts = ref([]);
const loadingProducts = ref(false);

const loadProducts = async () => {
    try {
        loadingProducts.value = true;
        const res = await axios.get("/api/products/all-dropdown?all=1");
        allProducts.value = res.data.data || [];
    } catch (err) {
        console.error("Failed to load products dropdown", err);
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
    if (!form.product_ids || !Array.isArray(form.product_ids)) return [];
    return form.product_ids.map((id) => {
        const found = allProducts.value.find((p) => Number(p.id) === Number(id));
        return found || { id: Number(id), name: `Product #${id}`, model: "", price: 0, main_image: "" };
    });
});

const moveSelectedProduct = (index, delta) => {
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= form.product_ids.length) return;
    const item = form.product_ids.splice(index, 1)[0];
    form.product_ids.splice(newIndex, 0, item);
};

const removeSelectedProduct = (index) => {
    form.product_ids.splice(index, 1);
};

const selectTopProducts = () => {
    form.product_ids = allProducts.value.slice(0, 4).map((p) => Number(p.id));
};

const clearSelectedProducts = () => {
    form.product_ids = [];
};

// Living Hero specific state & helpers
const selectedLivingProduct = computed(() => {
    if (!form.product_id) {
        return allProducts.value[0] || null;
    }
    return allProducts.value.find((p) => Number(p.id) === Number(form.product_id)) || null;
});

const selectFirstLivingProduct = () => {
    if (allProducts.value.length > 0) {
        form.product_id = Number(allProducts.value[0].id);
    }
};

const clearLivingProduct = () => {
    form.product_id = null;
};

const resetLivingBgToDefault = () => {
    form.image = 'themes/default/assets/img/background-without-product.png';
    previews.value = ['/themes/default/assets/img/background-without-product.png'];
    fileUpload.value = [];
    toast.info('Reset living room background to default.');
};

// File upload handling
const fileUpload = ref([]);
const previews = ref([]);

const isPdf = (filename) => /\.pdf$/i.test(filename);
// Video file upload and preview handling
const selectedVideoFile = ref(null);
const videoFileInput = ref(null);

const handleVideoFileChange = (e) => {
    const file = e.target.files?.[0];
    if (file) {
        selectedVideoFile.value = file;
    }
};


// Video Banner specific state & helpers
const videoSourceMode = ref('url');
const isDraggingVideo = ref(false);
const removeVideoFlag = ref(false);

const triggerVideoBrowse = () => {
    videoFileInput.value?.click();
};

const handleVideoDrop = (e) => {
    isDraggingVideo.value = false;
    const file = e.dataTransfer?.files?.[0];
    if (file && /\.(mp4|webm|ogg|mov)$/i.test(file.name)) {
        selectedVideoFile.value = file;
        removeVideoFlag.value = false;
    } else if (file) {
        toast.error('Please drop a valid video file (.mp4, .webm, .ogg, .mov)');
    }
};

const removeServerVideo = () => {
    form.video_file = '';
    removeVideoFlag.value = true;
};

const activeSourceLabel = computed(() => {
    if (selectedVideoFile.value) {
        return 'Local ' + selectedVideoFile.value.name;
    }
    if (form.video_file) {
        return 'Server Video';
    }
    if (form.video_url) {
        return form.video_url.startsWith('http') ? 'External Stream' : 'Local Path';
    }
    return 'Default MP4';
});

const cancelVideoFile = () => {
    selectedVideoFile.value = null;
    if (videoFileInput.value) {
        videoFileInput.value.value = "";
    }
};

const previewPosterUrl = computed(() => {
    if (previews.value && previews.value[0]) {
        return previews.value[0];
    }
    if (form.image) {
        return getImageUrl(form.image);
    }
    return getImageUrl('home/video_thumb.png');
});

const previewVideoUrl = computed(() => {
    if (selectedVideoFile.value) {
        return URL.createObjectURL(selectedVideoFile.value);
    }
    if (form.video_file) {
        const v = form.video_file;
        return v.startsWith('http') ? v : (v.startsWith('/storage') ? v : '/storage/' + v.replace(/^\//, ''));
    }
    if (form.video_url) {
        const u = form.video_url;
        if (u.startsWith('http')) return u;
        return u.startsWith('/') ? u : '/' + u;
    }
    return '/storage/home/home-video.mp4';
});


// Add Card for stacked cards mode (why_choose_aire)
const addCard = () => {
    const nextLayer = form.cards.length + 1;
    form.cards.push({
        dots: "•••",
        title: "New Feature",
        description: "Describe this key solution benefit here.",
        theme: "light",
        card_class: `card-layer-${nextLayer}`
    });
};


// Remove Card (shared for why_choose_aire & home_benefits)
const removeCard = (index) => {
    if (form.cards.length > 1) {
        form.cards.splice(index, 1);
        form.cards.forEach((c, idx) => {
            if (c.card_class) {
                c.card_class = `card-layer-${idx + 1}`;
            }
        });
    }
};

// Move Card Up / Down / Left / Right (shared)
const moveCard = (index, delta) => {
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= form.cards.length) return;
    const item = form.cards.splice(index, 1)[0];
    form.cards.splice(newIndex, 0, item);
    form.cards.forEach((c, idx) => {
        if (c.card_class) {
            c.card_class = `card-layer-${idx + 1}`;
        }
    });
};

// Add Lifestyle Item
const addLifestyleItem = () => {
    form.items.push({
        title: "New Lifestyle Space",
        description: "Describe this space...",
        image: "",
        dropzoneFile: null,
        previews: []
    });
};

// Remove Lifestyle Item
const removeLifestyleItem = (index) => {
    if (form.items.length > 1) {
        form.items.splice(index, 1);
    }
};

// Move Lifestyle Item Up / Down
const moveLifestyleItem = (index, delta) => {
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= form.items.length) return;
    const item = form.items.splice(index, 1)[0];
    form.items.splice(newIndex, 0, item);
};

// Add Badge for trust_badges mode
const addBadge = () => {
    form.badges.push({
        icon: "bi-shield-check",
        title: "New Badge",
        description: "Describe this badge.",
    });
};


// Add FAQ Item
const addFaqItem = () => {
    if (!form.items) form.items = [];
    form.items.push({
        question: "",
        answer: "",
    });
};

// Remove FAQ Item
const removeFaqItem = (index) => {
    if (form.items.length > 1) {
        form.items.splice(index, 1);
    }
};

// Move FAQ Item Up / Down
const moveFaqItem = (index, delta) => {
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= form.items.length) return;
    const item = form.items.splice(index, 1)[0];
    form.items.splice(newIndex, 0, item);
};

// Remove Badge
const removeBadge = (index) => {
    if (form.badges.length > 1) {
        form.badges.splice(index, 1);
    }
};

// Move Badge Up / Down
const moveBadge = (index, delta) => {
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= form.badges.length) return;
    const item = form.badges.splice(index, 1)[0];
    form.badges.splice(newIndex, 0, item);
};

// ====================================================
// About Page Helper Methods
// ====================================================
const addMilestone = () => {
    if (!form.milestones) form.milestones = [];
    form.milestones.push({
        year: "",
        title: "",
        desc: ""
    });
};

const removeMilestone = (index) => {
    if (form.milestones && form.milestones.length > 1) {
        form.milestones.splice(index, 1);
    }
};

const moveMilestone = (index, delta) => {
    if (!form.milestones) return;
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= form.milestones.length) return;
    const item = form.milestones.splice(index, 1)[0];
    form.milestones.splice(newIndex, 0, item);
};

const addStat = () => {
    if (!form.stats) form.stats = [];
    form.stats.push({
        icon: "bi bi-graph-up",
        title: "",
        desc: ""
    });
};

const removeStat = (index) => {
    if (form.stats && form.stats.length > 1) {
        form.stats.splice(index, 1);
    }
};

const addValue = () => {
    if (!form.values) form.values = [];
    form.values.push({
        icon: "bi bi-check-circle",
        title: "",
        desc: ""
    });
};

const removeValue = (index) => {
    if (form.values && form.values.length > 1) {
        form.values.splice(index, 1);
    }
};

const addMember = () => {
    if (!form.members) form.members = [];
    form.members.push({
        name: "",
        role: "",
        bio: "",
        image: ""
    });
};

const removeMember = (index) => {
    if (form.members && form.members.length > 1) {
        form.members.splice(index, 1);
    }
};

const moveMember = (index, delta) => {
    if (!form.members) return;
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= form.members.length) return;
    const item = form.members.splice(index, 1)[0];
    form.members.splice(newIndex, 0, item);
};

const addGenericItem = () => {
    if (!form.items) form.items = [];
    form.items.push({
        icon: "bi bi-star",
        title: "",
        desc: ""
    });
};

const removeGenericItem = (index) => {
    if (form.items && form.items.length > 1) {
        form.items.splice(index, 1);
    }
};

// Fetch existing section data
const fetchSections = async () => {
    try {
        const sectionId = props.id || route.params.id;
        const res = await axios.get(`/api/sections/${sectionId}`);
        const sectionData = res.data.data;

        if (sectionData.name === 'client_testimonials') {
            router.replace({ name: 'TestimonialsSection' });
            return;
        }

        let d = sectionData.data;
        if (typeof d === 'string') {
            try { d = JSON.parse(d); } catch (e) { }
        }

        form.id = sectionData.id;
        form.key = sectionData.name;
        form.title = d.title || "";
        form.badge = d.badge || (sectionData.name === 'home_lifestyle' || sectionData.name === 'lifestyle' ? 'LIFESTYLE' : 'BENEFITS');
        form.subtitle = d.subtitle || "";
        form.content = d.content || "";
        form.home_content = d.home_content || "";
        form.number = d.number !== undefined ? d.number : null;

        if (['home_video', 'video'].includes(form.key)) {
            form.title = d.title || "AIRE Pro S1 — Engineering Architecture & Air Purification";
            form.video_url = d.video_url || "storage/home/home-video.mp4";
            form.video_file = d.video_file || "";
            form.image = d.image || "home/video_thumb.png";
            videoSourceMode.value = form.video_file ? "upload" : "url";
            if (form.image) {
                previews.value = [getImageUrl(form.image)];
            }
        }

        if (['home_best_selling', 'best_selling', 'home_new_arrival', 'new_arrival', 'home_customer_favorites', 'customer_favorites'].includes(form.key)) {
            const isFav = ['home_customer_favorites', 'customer_favorites'].includes(form.key);
            const isNew = ['home_new_arrival', 'new_arrival'].includes(form.key);

            form.badge = d.badge || (isFav ? 'Customers Favorites' : (isNew ? 'New arrival' : 'Product'));
            form.title = d.title || (isFav ? 'Loved by Our Community' : (isNew ? 'Freshly Launched Models' : 'Best Selling Product'));
            form.subtitle = d.subtitle || (isFav ? 'Discover the purifiers most chosen by families who value clean, healthy air.' : (isNew ? 'Explore the latest purifiers designed with advanced technology for modern living.' : 'Discover the top‑selling models trusted by thousands of families for cleaner, healthier air.'));

            let pIds = d.product_ids;
            if (typeof pIds === 'string') {
                try { pIds = JSON.parse(pIds); } catch (e) { pIds = []; }
            }
            form.product_ids = Array.isArray(pIds) ? pIds.map(Number).filter(n => !isNaN(n) && n > 0) : [];
        }

        if (['home_living_hero', 'living_hero'].includes(form.key)) {
            form.badge = d.badge || "INNOVATION";
            form.title = d.title || "The Future of Pure Living";
            form.subtitle = d.subtitle || d.description || "";
            form.description = d.description || d.subtitle || "";
            form.button_text = d.button_text || "Buy Now";
            form.product_id = d.product_id ? Number(d.product_id) : null;
            form.image = d.image || "themes/default/assets/img/background-without-product.png";
            form.enabled = d.enabled !== undefined ? Number(d.enabled) : 1;
            if (form.image) {
                previews.value = [getImageUrl(form.image)];
            }
        }

        if (['home_faq', 'faq'].includes(form.key)) {
            form.badge = d.badge || "SUPPORT";
            form.title = d.title || "Frequently Asked Questions";
            form.subtitle = d.subtitle || "";
            form.items = Array.isArray(d.items) ? d.items.map(it => ({
                question: it.question || "",
                answer: it.answer || "",
            })) : [];
        }

        if (form.key === 'home_category_grid') {
            form.action_text = d.action_text || "Find Your Solutions";
            form.action_url = d.action_url || "/category/products";

            form.fresh_air_category_id = d.fresh_air_category_id ? Number(d.fresh_air_category_id) : null;
            form.fresh_air_title = d.fresh_air_title || "Fresh Air Unit";
            form.fresh_air_url = d.fresh_air_url || "/category/fresh-air-systems";
            form.fresh_air_image = d.fresh_air_image || "themes/default/assets/img/home/fresh-air-unit.webp";

            form.mask_category_id = d.mask_category_id ? Number(d.mask_category_id) : null;
            form.mask_title = d.mask_title || "Air Pro Mask";
            form.mask_url = d.mask_url || "/category/smart-wearable-masks";
            form.mask_image = d.mask_image || "themes/default/assets/img/home/air-pro-mask.webp";

            form.accessories_category_id = d.accessories_category_id ? Number(d.accessories_category_id) : null;
            form.accessories_title = d.accessories_title || "Accessories";
            form.accessories_url = d.accessories_url || "/category/accessories-parts";
            form.accessories_image = d.accessories_image || "themes/default/assets/img/home/accessories.webp";

            form.purifier_category_id = d.purifier_category_id ? Number(d.purifier_category_id) : null;
            form.purifier_title = d.purifier_title || "Air Purifiers";
            form.purifier_url = d.purifier_url || "/category/air-purifiers";
            form.purifier_image = d.purifier_image || "themes/default/assets/img/home/air-purifiers.webp";

            form.home_solutions_category_id = d.home_solutions_category_id ? Number(d.home_solutions_category_id) : null;
            form.home_solutions_title = d.home_solutions_title || "Solutions for Home";
            form.home_solutions_sub = d.home_solutions_sub || "Ventilation and Filtration Solution";
            form.home_solutions_url = d.home_solutions_url || "/category/home-fresh-air-systems";
            form.home_solutions_image = d.home_solutions_image || "themes/default/assets/img/home/solutions-home.webp";

            form.biz_solutions_category_id = d.biz_solutions_category_id ? Number(d.biz_solutions_category_id) : null;
            form.biz_solutions_title = d.biz_solutions_title || "Solutions for Business";
            form.biz_solutions_sub = d.biz_solutions_sub || "Air Disinfection & Air Monitoring";
            form.biz_solutions_url = d.biz_solutions_url || "/category/commercial-fresh-air-systems";
            form.biz_solutions_image = d.biz_solutions_image || "themes/default/assets/img/home/solutions-business.webp";
        }

        // About Sections Specific Parsing
        if (form.key === 'about_hero') {
            form.badge = d.badge || "OUR STORY";
            form.title = d.title || "A Cleaner Tomorrow Starts Here";
            form.subtitle = d.subtitle || "";
        }

        if (form.key === 'about_story') {
            form.hero_title = d.hero_title || "";
            form.hero_desc = d.hero_desc || "";
            form.hero_image = d.hero_image || "";
            form.hero_badge = d.hero_badge || "";
            form.button_text = d.button_text || "";
            form.button_link = d.button_link || "";
            form.milestones = Array.isArray(d.milestones) ? d.milestones.map(m => ({
                year: m.year || "",
                title: m.title || "",
                desc: m.desc || ""
            })) : [];
            form.impact_title = d.impact_title || "";
            form.impact_desc = d.impact_desc || "";
            form.impact_image = d.impact_image || "";
            form.impact_badge = d.impact_badge || "";
            form.stats = Array.isArray(d.stats) ? d.stats.map(s => ({
                icon: s.icon || "bi bi-globe",
                title: s.title || "",
                desc: s.desc || ""
            })) : [];
            form.quote = d.quote || "";
            form.quote_brand = d.quote_brand || "";
        }

        if (form.key === 'about_mission_vision') {
            form.purpose_title = d.purpose_title || "";
            form.purpose_desc = d.purpose_desc || "";
            form.purpose_image = d.purpose_image || "";
            form.purpose_badge = d.purpose_badge || "";
            form.mission_title = d.mission_title || "";
            form.mission_desc = d.mission_desc || "";
            form.vision_title = d.vision_title || "";
            form.vision_desc = d.vision_desc || "";
            form.values = Array.isArray(d.values) ? d.values.map(v => ({
                icon: v.icon || "bi bi-heart",
                title: v.title || "",
                desc: v.desc || ""
            })) : [];
            form.quote = d.quote || "";
            form.quote_brand = d.quote_brand || "";
        }

        if (form.key === 'about_leadership') {
            form.banner_badge = d.banner_badge || "";
            form.banner_title = d.banner_title || "";
            form.banner_desc = d.banner_desc || "";
            form.banner_image = d.banner_image || "";
            form.banner_badge_text = d.banner_badge_text || "";
            form.team_heading = d.team_heading || "";
            form.team_subheading = d.team_subheading || "";
            form.members = Array.isArray(d.members) ? d.members.map(m => ({
                name: m.name || "",
                role: m.role || "",
                bio: m.bio || "",
                image: m.image || ""
            })) : [];
            form.quote = d.quote || "";
            form.quote_brand = d.quote_brand || "";
        }

        if (['about_innovation', 'about_quality', 'about_global'].includes(form.key)) {
            form.items = Array.isArray(d.items) ? d.items.map(it => ({
                icon: it.icon || "bi bi-star",
                title: it.title || "",
                desc: it.desc || ""
            })) : [];
        }

        if (form.key === 'about_careers') {
            form.card_title = d.card_title || "";
            form.card_desc = d.card_desc || "";
            form.button_text = d.button_text || "";
            form.button_link = d.button_link || "";
        }

        if (form.key === 'about_news') {
            form.banner_title = d.banner_title || "";
            form.banner_desc = d.banner_desc || "";
            form.button_text = d.button_text || "";
            form.button_link = d.button_link || "";
        }

        if (!['home_faq', 'faq', 'about_innovation', 'about_quality', 'about_global'].includes(form.key)) {
            form.items = Array.isArray(d.items) ? d.items.map(it => ({
                title: it.title || "",
                description: it.description || "",
                question: it.question || "",
                answer: it.answer || "",
                image: it.image || "",
                dropzoneFile: null,
                previews: it.image ? [getImageUrl(it.image)] : []
            })) : form.items || [];
        }

        form.cards = Array.isArray(d.cards) ? d.cards.map((c, idx) => ({
            theme: c.theme || "light",
            dots: c.dots || "•••",
            title: c.title || "",
            description: c.description || c.content || "",
            content: c.description || c.content || "",
            card_class: c.card_class || `card-layer-${idx + 1}`
        })) : [];
        form.badges = Array.isArray(d.badges) ? d.badges.map(b => ({
            icon: b.icon || "bi-shield-check",
            title: b.title || "",
            description: b.description || ""
        })) : [];
        form.image = d.image || "";
        form.status = sectionData.status !== undefined ? String(sectionData.status) : (d.status !== undefined ? String(d.status) : "1");

        if (form.image && !form.key.startsWith('about_')) {
            previews.value = [getImageUrl(form.image)];
        }
    } catch (err) {
        console.error("Failed to load section data", err);
        toast.error("Failed to load section data");
    }
};

// Submit updated section
const updateSections = async () => {
    // Client-side required field validations
    if (form.key === "home_category_grid") {
        if (!form.fresh_air_title?.trim() || !form.mask_title?.trim() || !form.accessories_title?.trim() || !form.purifier_title?.trim()) {
            toast.error("Please provide titles for all 4 Category cards.");
            return;
        }
        if (!form.home_solutions_title?.trim() || !form.biz_solutions_title?.trim()) {
            toast.error("Please provide headlines for both Solutions banners.");
            return;
        }
    } else if (form.key === "why_choose_aire") {
        if (!form.title?.trim()) {
            toast.error("Section Title is required.");
            return;
        }
        for (let i = 0; i < form.cards.length; i++) {
            if (!form.cards[i].title?.trim()) {
                toast.error(`Card #${i + 1} Title is required.`);
                return;
            }
            if (!form.cards[i].description?.trim()) {
                toast.error(`Card #${i + 1} Description is required.`);
                return;
            }
        }
    } else if (["home_lifestyle", "lifestyle"].includes(form.key)) {
        if (!form.title?.trim()) {
            toast.error("Section Title is required.");
            return;
        }
        if (!form.badge?.trim()) {
            toast.error("Section Badge is required.");
            return;
        }
        if (!form.subtitle?.trim()) {
            toast.error("Section Subtitle is required.");
            return;
        }
        for (let i = 0; i < form.items.length; i++) {
            if (!form.items[i].title?.trim()) {
                toast.error(`Item #${i + 1} Title is required.`);
                return;
            }
            if (!form.items[i].description?.trim()) {
                toast.error(`Item #${i + 1} Description is required.`);
                return;
            }
        }
    } else if (["home_benefits", "benefits"].includes(form.key)) {
        if (!form.title?.trim()) {
            toast.error("Section Title is required.");
            return;
        }
        if (!form.badge?.trim()) {
            toast.error("Section Badge is required.");
            return;
        }
        if (!form.subtitle?.trim()) {
            toast.error("Section Subtitle is required.");
            return;
        }
        for (let i = 0; i < form.cards.length; i++) {
            if (!form.cards[i].title?.trim()) {
                toast.error(`Benefit Card #${i + 1} Title is required.`);
                return;
            }
            if (!form.cards[i].description?.trim()) {
                toast.error(`Benefit Card #${i + 1} Description is required.`);
                return;
            }
        }
    } else if (form.key === "trust_badges") {
        for (let i = 0; i < form.badges.length; i++) {
            if (!form.badges[i].title?.trim() || !form.badges[i].icon?.trim() || !form.badges[i].description?.trim()) {
                toast.error(`Badge #${i + 1} Title, Icon Class, and Description are required.`);
                return;
            }
        }
    } else if (form.key === "home_video" || form.key === "video") {
        if (!form.title?.trim()) {
            toast.error("Headline & Section Title is required.");
            return;
        }
    } else if (['home_best_selling', 'best_selling', 'home_new_arrival', 'new_arrival', 'home_customer_favorites', 'customer_favorites'].includes(form.key)) {
        if (!form.title?.trim()) {
            toast.error("Section Title is required.");
            return;
        }
    } else if (!['home_living_hero', 'living_hero'].includes(form.key)) {
        if (!form.title?.trim()) {
            toast.error("Section Title is required.");
            return;
        }
    }

    saving.value = true;
    let data = {};

    if (form.key === "home_category_grid") {
        data = {
            action_text: form.action_text || "Find Your Solutions",
            action_url: form.action_url || "/category/products",

            fresh_air_category_id: form.fresh_air_category_id || null,
            fresh_air_title: form.fresh_air_title || "Fresh Air Unit",
            fresh_air_url: form.fresh_air_url || "/category/fresh-air-systems",
            fresh_air_image: form.fresh_air_image || "themes/default/assets/img/home/fresh-air-unit.webp",

            mask_category_id: form.mask_category_id || null,
            mask_title: form.mask_title || "Air Pro Mask",
            mask_url: form.mask_url || "/category/smart-wearable-masks",
            mask_image: form.mask_image || "themes/default/assets/img/home/air-pro-mask.webp",

            accessories_category_id: form.accessories_category_id || null,
            accessories_title: form.accessories_title || "Accessories",
            accessories_url: form.accessories_url || "/category/accessories-parts",
            accessories_image: form.accessories_image || "themes/default/assets/img/home/accessories.webp",

            purifier_category_id: form.purifier_category_id || null,
            purifier_title: form.purifier_title || "Air Purifiers",
            purifier_url: form.purifier_url || "/category/air-purifiers",
            purifier_image: form.purifier_image || "themes/default/assets/img/home/air-purifiers.webp",

            home_solutions_category_id: form.home_solutions_category_id || null,
            home_solutions_title: form.home_solutions_title || "Solutions for Home",
            home_solutions_sub: form.home_solutions_sub || "Ventilation and Filtration Solution",
            home_solutions_url: form.home_solutions_url || "/category/home-fresh-air-systems",
            home_solutions_image: form.home_solutions_image || "themes/default/assets/img/home/solutions-home.webp",

            biz_solutions_category_id: form.biz_solutions_category_id || null,
            biz_solutions_title: form.biz_solutions_title || "Solutions for Business",
            biz_solutions_sub: form.biz_solutions_sub || "Air Disinfection & Air Monitoring",
            biz_solutions_url: form.biz_solutions_url || "/category/commercial-fresh-air-systems",
            biz_solutions_image: form.biz_solutions_image || "themes/default/assets/img/home/solutions-business.webp",
        };
    } else if (form.key === "why_choose_aire") {
        data = {
            title: form.title,
            subtitle: form.subtitle,
            cards: form.cards.map(c => ({
                theme: c.theme || "light",
                dots: c.dots || "•••",
                title: c.title || "",
                description: c.description || "",
                content: c.description || "",
                card_class: c.card_class || ""
            }))
        };
    } else if (form.key === "trust_badges") {
        data = {
            badges: form.badges.map(b => ({
                icon: b.icon || "bi-shield-check",
                title: b.title || "",
                description: b.description || ""
            }))
        };
    } else if (form.key === "home_video" || form.key === "video") {
        data = {
            title: form.title || "AIRE Pro S1 — Engineering Architecture & Air Purification",
            image: form.image || "home/video_thumb.png",
            video_url: form.video_url || "storage/home/home-video.mp4",
            video_file: form.video_file || ""
        };
    } else if (form.key === "home_faq" || form.key === "faq") {
        data = {
            badge: form.badge || "SUPPORT",
            title: form.title || "Frequently Asked Questions",
            subtitle: form.subtitle || "",
            items: form.items.map(it => ({
                question: it.question || "",
                answer: it.answer || ""
            }))
        };
    } else if (form.key === "home_lifestyle" || form.key === "lifestyle") {
        data = {
            badge: form.badge || "LIFESTYLE",
            title: form.title,
            subtitle: form.subtitle,
            items: form.items.map(it => ({
                title: it.title || "",
                description: it.description || "",
                image: it.image || ""
            }))
        };
    } else if (form.key === "home_benefits" || form.key === "benefits") {
        data = {
            badge: form.badge || "BENEFITS",
            title: form.title,
            subtitle: form.subtitle,
            image: form.image || "themes/default/assets/img/benifits-bg.png",
            cards: form.cards.map(c => ({
                title: c.title || "",
                description: c.description || ""
            }))
        };
    } else if (['home_best_selling', 'best_selling', 'home_new_arrival', 'new_arrival', 'home_customer_favorites', 'customer_favorites'].includes(form.key)) {
        const isFav = ['home_customer_favorites', 'customer_favorites'].includes(form.key);
        const isNew = ['home_new_arrival', 'new_arrival'].includes(form.key);

        data = {
            badge: form.badge || (isFav ? 'Customers Favorites' : (isNew ? 'New arrival' : 'Product')),
            title: form.title || (isFav ? 'Loved by Our Community' : (isNew ? 'Freshly Launched Models' : 'Best Selling Product')),
            subtitle: form.subtitle || "",
            product_ids: Array.isArray(form.product_ids) ? form.product_ids.map(Number).filter(n => !isNaN(n) && n > 0) : [],
        };
    } else if (['home_living_hero', 'living_hero'].includes(form.key)) {
        data = {
            enabled: form.enabled !== undefined ? Number(form.enabled) : 1,
            badge: form.badge || "INNOVATION",
            title: form.title || "",
            subtitle: form.description || form.subtitle || "",
            description: form.description || form.subtitle || "",
            button_text: form.button_text || "Buy Now",
            product_id: form.product_id ? Number(form.product_id) : null,
            image: form.image || "themes/default/assets/img/background-without-product.png",
        };
    } else if (form.key === "about_hero") {
        data = {
            badge: form.badge,
            title: form.title,
            subtitle: form.subtitle
        };
    } else if (form.key === "about_story") {
        data = {
            number: form.number,
            title: form.title,
            subtitle: form.subtitle,
            hero_title: form.hero_title,
            hero_desc: form.hero_desc,
            hero_image: form.hero_image,
            hero_badge: form.hero_badge,
            button_text: form.button_text,
            button_link: form.button_link,
            milestones: form.milestones.map(m => ({
                year: m.year || "",
                title: m.title || "",
                desc: m.desc || ""
            })),
            impact_title: form.impact_title,
            impact_desc: form.impact_desc,
            impact_image: form.impact_image,
            impact_badge: form.impact_badge,
            stats: form.stats.map(s => ({
                icon: s.icon || "",
                title: s.title || "",
                desc: s.desc || ""
            })),
            quote: form.quote,
            quote_brand: form.quote_brand
        };
    } else if (form.key === "about_mission_vision") {
        data = {
            number: form.number,
            title: form.title,
            subtitle: form.subtitle,
            purpose_title: form.purpose_title,
            purpose_desc: form.purpose_desc,
            purpose_image: form.purpose_image,
            purpose_badge: form.purpose_badge,
            mission_title: form.mission_title,
            mission_desc: form.mission_desc,
            vision_title: form.vision_title,
            vision_desc: form.vision_desc,
            values: form.values.map(v => ({
                icon: v.icon || "",
                title: v.title || "",
                desc: v.desc || ""
            })),
            quote: form.quote,
            quote_brand: form.quote_brand
        };
    } else if (form.key === "about_leadership") {
        data = {
            number: form.number,
            title: form.title,
            subtitle: form.subtitle,
            banner_badge: form.banner_badge,
            banner_title: form.banner_title,
            banner_desc: form.banner_desc,
            banner_image: form.banner_image,
            banner_badge_text: form.banner_badge_text,
            team_heading: form.team_heading,
            team_subheading: form.team_subheading,
            members: form.members.map(m => ({
                name: m.name || "",
                role: m.role || "",
                bio: m.bio || "",
                image: m.image || ""
            })),
            quote: form.quote,
            quote_brand: form.quote_brand
        };
    } else if (['about_innovation', 'about_quality', 'about_global'].includes(form.key)) {
        data = {
            number: form.number,
            title: form.title,
            subtitle: form.subtitle,
            items: form.items.map(it => ({
                icon: it.icon || "",
                title: it.title || "",
                desc: it.desc || ""
            }))
        };
    } else if (form.key === "about_careers") {
        data = {
            number: form.number,
            title: form.title,
            subtitle: form.subtitle,
            card_title: form.card_title,
            card_desc: form.card_desc,
            button_text: form.button_text,
            button_link: form.button_link
        };
    } else if (form.key === "about_news") {
        data = {
            number: form.number,
            title: form.title,
            subtitle: form.subtitle,
            banner_title: form.banner_title,
            banner_desc: form.banner_desc,
            button_text: form.button_text,
            button_link: form.button_link
        };
    } else {
        data = {
            title: form.title,
            content: form.content,
            home_content: form.home_content || null,
            image: form.image || null,
            status: form.status,
        };
    }

    const payload = new FormData();
    const specialKeys = [
        "home_category_grid", "why_choose_aire", "trust_badges", "home_benefits", "benefits",
        "home_lifestyle", "lifestyle", "home_faq", "faq", "home_video", "video",
        "home_best_selling", "best_selling", "home_new_arrival", "new_arrival",
        "home_customer_favorites", "customer_favorites", "home_living_hero", "living_hero",
        "about_hero", "about_story", "about_mission_vision", "about_leadership",
        "about_innovation", "about_quality", "about_careers", "about_news", "about_global"
    ];
    if (!previews.value[0] && !specialKeys.includes(form.key)) {
        payload.append('remove_image', 1);
    }
    payload.append("data", JSON.stringify(data));

    if (form.key === "home_category_grid") {
        Object.keys(gridFiles).forEach(k => {
            if (gridFiles[k]) {
                payload.append(k, gridFiles[k]);
            }
        });
    }

    if (["home_lifestyle", "lifestyle"].includes(form.key) && form.items) {
        form.items.forEach((it, idx) => {
            const itemFile = it.dropzoneFile?.[0]?.file || (it.dropzoneFile?.[0] instanceof File ? it.dropzoneFile[0] : null);
            if (itemFile) {
                payload.append(`item_image_${idx}`, itemFile);
            }
        });
    }

    const mainFile = fileUpload.value?.[0]?.file || (fileUpload.value?.[0] instanceof File ? fileUpload.value[0] : null);
    if (mainFile) {
        payload.append("image", mainFile);
    }
    if (selectedVideoFile.value) {
        payload.append("video_file", selectedVideoFile.value);
    }
    if (removeVideoFlag.value) {
        payload.append("remove_video", 1);
    }

    try {
        await axios.post(`/api/sections/${form.id}?_method=PUT`, payload, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        toast.success("Section updated successfully");
        if (form.key.startsWith('about_')) {
            router.push({ name: "AboutSections" });
        } else if (window.history.state?.back || window.history.length > 1) {
            router.back();
        } else {
            router.push({
                name: "Section",
            });
        }
    } catch (err) {
        toast.validationError(err);
    } finally {
        saving.value = false;
    }
};

onMounted(async () => {
    loadProducts();
    loadCategories();
    await fetchSections();
});
</script>

<style scoped>
.product-preview-box {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-radius: 10px;
    overflow: hidden;
}
.product-preview-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08) !important;
}
.card-purple.card-outline {
    border-top: 3px solid #6f42c1;
}

.card-dark.card-outline {
    border-top: 3px solid #343a40;
}

/* Video Banner Visual Editor Enhancements */
.video-master-card {
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    background: #ffffff;
}

.video-editor-header {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #e2e8f0;
}

.video-header-badge {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 1.15rem;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
}

.setting-card {
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
    background: #ffffff;
}

.setting-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
}

.setting-step-num {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    background: #0f172a;
    color: #ffffff;
    font-size: 0.75rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-white {
    background-color: #ffffff;
    border-color: #ffffff;
}

.video-drop-area {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.25s ease;
}

.video-drop-area:hover,
.video-drop-area.is-dragging {
    border-color: #3b82f6;
    background: #eff6ff;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
}

.video-drop-area.has-file {
    border-color: #10b981;
    background: #f0fdf4;
}

.video-icon-circle {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-primary-light {
    background: #dbeafe;
    color: #2563eb;
}

.bg-success-light {
    background: #d1fae5;
    color: #059669;
}

.badge-light-danger {
    background-color: #fee2e2;
    color: #b91c1c;
}

.pulse-dot {
    animation: pulse-red 1.5s infinite;
}

@keyframes pulse-red {
    0% { transform: scale(0.95); opacity: 0.6; }
    50% { transform: scale(1.3); opacity: 1; }
    100% { transform: scale(0.95); opacity: 0.6; }
}

/* Cinema Monitor Device Preview */
.cinema-device {
    background: #0f172a;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #1e293b;
    box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.45), 0 0 0 1px rgba(255, 255, 255, 0.05);
}

.cinema-header {
    background: #1e293b;
    color: #94a3b8;
    border-bottom: 1px solid #334155;
}

.cinema-dots .dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
}

.cinema-dots .dot.red { background: #ef4444; }
.cinema-dots .dot.yellow { background: #f59e0b; }
.cinema-dots .dot.green { background: #10b981; }

.recording-pulse {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10b981;
    display: inline-block;
    animation: pulse-green 1.5s infinite;
}

@keyframes pulse-green {
    0% { transform: scale(0.95); opacity: 0.6; }
    50% { transform: scale(1.3); opacity: 1; }
    100% { transform: scale(0.95); opacity: 0.6; }
}

.cinema-screen {
    background: #000000;
    aspect-ratio: 16 / 9;
    max-height: 290px;
    overflow: hidden;
}

.cinema-video {
    object-fit: contain;
    width: 100%;
    height: 100%;
}

.cinema-title-overlay {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 5;
    pointer-events: none;
    max-width: 90%;
}

.bg-black-alpha {
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
}

.border-white-10 {
    border-color: rgba(255, 255, 255, 0.15) !important;
}

.cinema-footer {
    background: #1e293b;
    border-top: 1px solid #334155;
}

.bg-dark-slate {
    background-color: #1e293b;
}

.text-xs {
    font-size: 0.75rem;
}

.tracking-wider {
    letter-spacing: 0.05em;
}

/* Living Hero Visual Editor Enhancements */
.living-header-badge {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 1.15rem;
    box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
}

.badge-light-teal {
    background-color: #ccfbf1;
    color: #0f766e;
}

.mockup-living-room {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

</style>