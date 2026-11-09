<template>
  <div class="block-inspector bg-white h-100 d-flex flex-column" :class="{ 'border-left shadow-sm': !hideHeader }">
    <!-- Inspector Header -->
    <div v-if="!hideHeader" class="inspector-header px-3 py-3 border-bottom d-flex align-items-center justify-content-between bg-light">
      <div class="d-flex align-items-center">
        <span class="badge badge-primary text-uppercase font-weight-bold px-2 py-1 mr-2" style="font-size: 0.7rem;">
          {{ selectedBlock?.type || 'Block' }}
        </span>
        <h6 class="mb-0 font-weight-bold text-dark" style="font-size: 0.9rem;">Block Settings</h6>
      </div>
      <button type="button" class="btn btn-sm btn-light border-0 text-muted p-1" @click="$emit('close')">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Inspector Navigation Tabs (Content, Style, Advanced) -->
    <div class="inspector-tabs px-2 pt-2 bg-light border-bottom">
      <ul class="nav nav-pills nav-fill inspector-pills">
        <li class="nav-item">
          <a
            class="nav-link font-weight-bold py-1 px-2"
            :class="{ active: activeTab === 'content' }"
            href="#"
            @click.prevent="activeTab = 'content'"
          >
            <i class="fas fa-pen mr-1"></i> Content
          </a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link font-weight-bold py-1 px-2"
            :class="{ active: activeTab === 'style' }"
            href="#"
            @click.prevent="activeTab = 'style'"
          >
            <i class="fas fa-paint-brush mr-1"></i> Style
          </a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link font-weight-bold py-1 px-2"
            :class="{ active: activeTab === 'advanced' }"
            href="#"
            @click.prevent="activeTab = 'advanced'"
          >
            <i class="fas fa-cog mr-1"></i> Advanced
          </a>
        </li>
      </ul>
    </div>

    <!-- Inspector Body -->
    <div class="inspector-body p-3 flex-grow-1 overflow-auto" v-if="selectedBlock">
      
      <!-- ==================================================================== -->
      <!-- TAB 1: CONTENT TAB                                                   -->
      <!-- ==================================================================== -->
      <div v-show="activeTab === 'content'">
        <!-- Device Scope Toggle (Desktop vs Mobile Settings) -->
        <div class="mb-3 p-2 bg-light rounded-3 d-flex align-items-center justify-content-between border">
          <span class="small font-weight-bold text-muted">Preview Scope:</span>
          <div class="btn-group btn-group-sm">
            <button
              type="button"
              class="btn"
              :class="scopeMode === 'desktop' ? 'btn-primary' : 'btn-outline-secondary'"
              @click="scopeMode = 'desktop'"
            >
              <i class="fas fa-desktop mr-1"></i> Desktop
            </button>
            <button
              type="button"
              class="btn"
              :class="scopeMode === 'mobile' ? 'btn-primary' : 'btn-outline-secondary'"
              @click="scopeMode = 'mobile'"
            >
              <i class="fas fa-mobile-alt mr-1"></i> Mobile
            </button>
          </div>
        </div>

        <!-- 1. HEADING CONTENT -->
        <div v-if="selectedBlock.type === 'heading'">
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Eyebrow / Badge (Optional)</label>
            <input v-model="s.badge" type="text" class="form-control form-control-sm" placeholder="e.g. INNOVATION or FEATURES" />
            <small class="text-muted" style="font-size: 0.7rem;">Small text pill displayed directly above the heading.</small>
          </div>

          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Heading Text</label>
            <textarea v-model="s.text" class="form-control form-control-sm" rows="3" placeholder="Enter heading text..."></textarea>
          </div>

          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">HTML Tag</label>
            <select v-model="s.tag" class="form-control form-control-sm">
              <option value="h1">H1 — Main Page Hero Title</option>
              <option value="h2">H2 — Standard Section Title</option>
              <option value="h3">H3 — Sub-Section Title</option>
              <option value="h4">H4 — Card or Subsection Header</option>
              <option value="h5">H5 — Small Header</option>
              <option value="h6">H6 — Tiny Header</option>
            </select>
          </div>

          <!-- Scope-specific alignment -->
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark d-flex justify-content-between">
              <span>Alignment ({{ scopeMode }})</span>
              <span class="badge badge-secondary">{{ scopeMode }}</span>
            </label>
            <div class="btn-group w-100 btn-group-sm">
              <button
                type="button"
                class="btn"
                :class="getAlign() === 'text-start' ? 'btn-primary' : 'btn-outline-secondary'"
                @click="setAlign('text-start')"
              >
                <i class="fas fa-align-left"></i>
              </button>
              <button
                type="button"
                class="btn"
                :class="getAlign() === 'text-center' ? 'btn-primary' : 'btn-outline-secondary'"
                @click="setAlign('text-center')"
              >
                <i class="fas fa-align-center"></i>
              </button>
              <button
                type="button"
                class="btn"
                :class="getAlign() === 'text-end' ? 'btn-primary' : 'btn-outline-secondary'"
                @click="setAlign('text-end')"
              >
                <i class="fas fa-align-right"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- 2. PARAGRAPH CONTENT -->
        <div v-else-if="selectedBlock.type === 'paragraph'">
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Paragraph Text</label>
            <textarea v-model="s.text" class="form-control form-control-sm" rows="5" placeholder="Enter paragraph content..."></textarea>
          </div>

          <div class="custom-control custom-switch mb-3">
            <input type="checkbox" v-model="s.isLead" class="custom-control-input" id="leadParaSwitch" />
            <label class="custom-control-label small font-weight-bold" for="leadParaSwitch">
              Lead Paragraph Style (Slightly larger, prominent text)
            </label>
          </div>

          <!-- Scope-specific alignment -->
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark d-flex justify-content-between">
              <span>Alignment ({{ scopeMode }})</span>
              <span class="badge badge-secondary">{{ scopeMode }}</span>
            </label>
            <div class="btn-group w-100 btn-group-sm">
              <button
                type="button"
                class="btn"
                :class="getAlign() === 'text-start' ? 'btn-primary' : 'btn-outline-secondary'"
                @click="setAlign('text-start')"
              >
                <i class="fas fa-align-left"></i>
              </button>
              <button
                type="button"
                class="btn"
                :class="getAlign() === 'text-center' ? 'btn-primary' : 'btn-outline-secondary'"
                @click="setAlign('text-center')"
              >
                <i class="fas fa-align-center"></i>
              </button>
              <button
                type="button"
                class="btn"
                :class="getAlign() === 'text-end' ? 'btn-primary' : 'btn-outline-secondary'"
                @click="setAlign('text-end')"
              >
                <i class="fas fa-align-right"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- 3. IMAGE CONTENT -->
        <div v-else-if="selectedBlock.type === 'image'">
          <!-- Image Preview Card -->
          <div v-if="s.url" class="mb-3 p-2 bg-light border rounded-3 text-center position-relative">
            <img
              :src="getImageUrl(s.url)"
              class="img-fluid rounded mb-2 shadow-2xs"
              style="max-height: 120px; object-fit: contain;"
            />
            <div class="d-flex justify-content-center">
              <button
                type="button"
                class="btn btn-xs btn-outline-primary font-weight-bold mr-1"
                @click="showMediaModal = true"
              >
                <i class="fas fa-sync-alt mr-1"></i> Change Image
              </button>
              <button
                type="button"
                class="btn btn-xs btn-outline-danger"
                @click="s.url = ''"
              >
                <i class="fas fa-trash-alt mr-1"></i> Remove
              </button>
            </div>
          </div>

          <!-- Open Media Library & Upload Modal -->
          <div class="form-group mb-3">
            <button
              type="button"
              class="btn btn-sm btn-primary btn-block shadow-sm font-weight-bold py-2"
              @click="showMediaModal = true"
            >
              <i class="fas fa-photo-video mr-1"></i> Select from Storage / Upload
            </button>
          </div>

          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Image URL or Storage Path</label>
            <input v-model="s.url" type="text" class="form-control form-control-sm" placeholder="storage/uploads/... or themes/..." />
          </div>

          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark d-flex align-items-center justify-content-between mb-1">
              <span>
                <i class="fas fa-tag text-muted mr-1"></i> Alt Name / Alt Text
              </span>
              <span class="badge badge-light border text-muted font-weight-normal px-2 py-0" style="font-size: 0.65rem;">
                Optional
              </span>
            </label>
            <input
              v-model="s.alt"
              type="text"
              class="form-control form-control-sm"
              placeholder="e.g. Hero banner image, product preview..."
            />
            <small class="form-text text-muted" style="font-size: 0.72rem;">
              <i class="fas fa-info-circle mr-1"></i> Optional: Alternative text for accessibility (screen readers) and SEO.
            </small>
          </div>

          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Caption (Optional)</label>
            <input v-model="s.caption" type="text" class="form-control form-control-sm" placeholder="Displayed under the image" />
          </div>

          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Clickable Link URL (Optional)</label>
            <input v-model="s.link_url" type="text" class="form-control form-control-sm" placeholder="e.g. /products/air-mask" />
          </div>

          <div class="custom-control custom-checkbox mb-2" v-if="s.link_url">
            <input type="checkbox" v-model="s.target_blank" class="custom-control-input" id="imgTargetBlankCheck" />
            <label class="custom-control-label small" for="imgTargetBlankCheck">Open link in new window</label>
          </div>
        </div>

        <!-- 4. BUTTON CONTENT -->
        <div v-else-if="selectedBlock.type === 'button'">
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Button Label</label>
            <input v-model="s.text" type="text" class="form-control form-control-sm" placeholder="e.g. Explore Technology" />
          </div>

          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Destination Link URL</label>
            <input v-model="s.url" type="text" class="form-control form-control-sm" placeholder="/shop, https://..., or #features" />
          </div>

          <div class="custom-control custom-checkbox mb-3">
            <input type="checkbox" v-model="s.target_blank" class="custom-control-input" id="btnTargetBlankCheck" />
            <label class="custom-control-label small" for="btnTargetBlankCheck">Open link in new tab (target="_blank")</label>
          </div>

          <!-- Button Icon Selector -->
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Button Icon</label>
            <div class="input-group input-group-sm">
              <select v-model="s.icon" class="form-control form-control-sm">
                <option value="">None (Text Only)</option>
                <option value="fas fa-arrow-right">Arrow Right (→)</option>
                <option value="fas fa-shopping-bag">Shopping Bag</option>
                <option value="fas fa-shopping-cart">Cart</option>
                <option value="fas fa-play">Play Video</option>
                <option value="fas fa-phone-alt">Phone / Contact</option>
                <option value="fas fa-download">Download</option>
                <option value="fas fa-shield-alt">Shield / Warranty</option>
                <option value="fas fa-check">Checkmark</option>
                <option value="fas fa-envelope">Email</option>
              </select>
              <div class="input-group-append" v-if="s.icon">
                <span class="input-group-text bg-light"><i :class="s.icon"></i></span>
              </div>
            </div>
          </div>

          <div class="form-group mb-2" v-if="s.icon">
            <label class="small font-weight-bold text-dark">Icon Position</label>
            <div class="btn-group btn-group-sm w-100">
              <button
                type="button"
                class="btn"
                :class="(s.iconPos || 'right') === 'left' ? 'btn-primary' : 'btn-outline-secondary'"
                @click="s.iconPos = 'left'"
              >
                Left Side
              </button>
              <button
                type="button"
                class="btn"
                :class="(s.iconPos || 'right') === 'right' ? 'btn-primary' : 'btn-outline-secondary'"
                @click="s.iconPos = 'right'"
              >
                Right Side
              </button>
            </div>
          </div>

          <!-- Scope Alignment -->
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark d-flex justify-content-between">
              <span>Alignment ({{ scopeMode }})</span>
              <span class="badge badge-secondary">{{ scopeMode }}</span>
            </label>
            <div class="btn-group w-100 btn-group-sm">
              <button
                type="button"
                class="btn"
                :class="getAlign() === 'text-start' ? 'btn-primary' : 'btn-outline-secondary'"
                @click="setAlign('text-start')"
              >
                <i class="fas fa-align-left"></i>
              </button>
              <button
                type="button"
                class="btn"
                :class="getAlign() === 'text-center' ? 'btn-primary' : 'btn-outline-secondary'"
                @click="setAlign('text-center')"
              >
                <i class="fas fa-align-center"></i>
              </button>
              <button
                type="button"
                class="btn"
                :class="getAlign() === 'text-end' ? 'btn-primary' : 'btn-outline-secondary'"
                @click="setAlign('text-end')"
              >
                <i class="fas fa-align-right"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- 5. CARD CONTENT -->
        <div v-else-if="selectedBlock.type === 'card'">
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Card Title</label>
            <input v-model="s.title" type="text" class="form-control form-control-sm" placeholder="Card Title" />
          </div>

          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Card Description</label>
            <textarea v-model="s.description" class="form-control form-control-sm" rows="3" placeholder="Card text..."></textarea>
          </div>

          <!-- Accent Type: None, Number, Badge, Icon -->
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Card Accent Type</label>
            <select v-model="s.accentType" class="form-control form-control-sm">
              <option value="none">None</option>
              <option value="number">Numeric Step (e.g. 01)</option>
              <option value="badge">Badge Pill (e.g. PRO / NEW)</option>
              <option value="icon">FontAwesome Icon</option>
            </select>
          </div>

          <div class="form-group mb-2" v-if="s.accentType === 'number'">
            <label class="small font-weight-bold text-dark">Step Number</label>
            <input v-model="s.number" type="text" class="form-control form-control-sm" placeholder="01" />
          </div>

          <div class="form-group mb-2" v-else-if="s.accentType === 'badge'">
            <label class="small font-weight-bold text-dark">Badge Label</label>
            <input v-model="s.badge" type="text" class="form-control form-control-sm" placeholder="FEATURED" />
          </div>

          <div class="form-group mb-2" v-else-if="s.accentType === 'icon'">
            <label class="small font-weight-bold text-dark">Icon Class</label>
            <div class="input-group input-group-sm">
              <select v-model="s.icon" class="form-control form-control-sm">
                <option value="fas fa-shield-alt">Shield / Security</option>
                <option value="fas fa-leaf">Eco / Pure</option>
                <option value="fas fa-bolt">High Performance</option>
                <option value="fas fa-wind">Airflow</option>
                <option value="fas fa-heart">Health</option>
                <option value="fas fa-star">Premium</option>
                <option value="fas fa-certificate">Official Certification</option>
                <option value="fas fa-cog">Settings / Custom</option>
              </select>
              <div class="input-group-append">
                <span class="input-group-text bg-light"><i :class="s.icon || 'fas fa-shield-alt'"></i></span>
              </div>
            </div>
          </div>

          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Clickable Card Link (Optional)</label>
            <input v-model="s.link_url" type="text" class="form-control form-control-sm" placeholder="e.g. /products or /about" />
            <small class="text-muted" style="font-size: 0.7rem;">Turns the entire card into an interactive link.</small>
          </div>
        </div>

        <!-- 6. CONTAINER (COLUMNS) CONTENT -->
        <div v-else-if="selectedBlock.type === 'container'">
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <label class="small font-weight-bold text-dark mb-0">Total Columns</label>
              <div class="btn-group btn-group-sm shadow-2xs">
                <button
                  type="button"
                  class="btn btn-outline-secondary px-2"
                  :disabled="containerColsCount <= 1"
                  @click="removeContainerColumn"
                  title="Remove column"
                >
                  <i class="fas fa-minus"></i>
                </button>
                <span class="btn btn-white disabled font-weight-bold px-3 text-dark">
                  {{ containerColsCount }} Columns
                </span>
                <button
                  type="button"
                  class="btn btn-outline-primary px-2"
                  :disabled="containerColsCount >= 6"
                  @click="addContainerColumn"
                  title="Add column (up to 6)"
                >
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>

            <div class="form-group mb-0">
              <label class="small font-weight-bold text-dark">Column Layout Preset</label>
              <select v-model="containerLayout" class="form-control form-control-sm">
                <option value="col-lg-12">1 Column (100% full width)</option>
                <option value="col-lg-6">2 Columns (50% / 50% split)</option>
                <option value="custom_1_2">2 Columns (1/3 Left + 2/3 Right)</option>
                <option value="custom_2_1">2 Columns (2/3 Left + 1/3 Right)</option>
                <option value="custom_1_3">2 Columns (1/4 Left + 3/4 Right)</option>
                <option value="custom_3_1">2 Columns (3/4 Left + 1/4 Right)</option>
                <option value="col-lg-4">3 Columns (33% / 33% / 33%)</option>
                <option value="col-lg-3">4 Columns (25% / 25% / 25% / 25%)</option>
                <option value="col-lg">5 Columns (Equal 5 Columns)</option>
                <option value="col-lg-2">6 Columns (16.6% × 6 Columns)</option>
              </select>
            </div>
          </div>

          <!-- Mobile Stack Order Override -->
          <div class="form-group p-2 bg-light rounded-3 border mb-2">
            <label class="small font-weight-bold text-dark d-flex align-items-center mb-1">
              <i class="fas fa-mobile-alt mr-1 text-primary"></i> Mobile Stack Order
            </label>
            <select v-model="s.stackOrderMobile" class="form-control form-control-sm">
              <option value="default">Default (Col 1 on top, Col 2 on bottom)</option>
              <option value="reverse">Reverse (Col 2 on top, Col 1 on bottom)</option>
            </select>
            <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Ideal when placing image on right on desktop, but want image on top on mobile.</small>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="form-group mb-2">
                <label class="small font-weight-bold text-dark">Gap</label>
                <select v-model="containerGap" class="form-control form-control-sm">
                  <option value="g-2">Compact (8px)</option>
                  <option value="g-3">Standard (16px)</option>
                  <option value="g-4">Large (24px)</option>
                  <option value="g-5">Extra Large (48px)</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group mb-2">
                <label class="small font-weight-bold text-dark">Vertical Align</label>
                <select v-model="s.verticalAlign" class="form-control form-control-sm">
                  <option value="align-items-center">Middle</option>
                  <option value="align-items-start">Top</option>
                  <option value="align-items-end">Bottom</option>
                  <option value="align-items-stretch">Stretch</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- 7. SPACER CONTENT -->
        <div v-else-if="selectedBlock.type === 'spacer'">
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Height</label>
            <select v-model="s.height" class="form-control form-control-sm">
              <option value="16px">Tiny (16px)</option>
              <option value="32px">Small (32px)</option>
              <option value="48px">Medium (48px)</option>
              <option value="72px">Large (72px)</option>
              <option value="100px">Extra Large (100px)</option>
            </select>
          </div>

          <div class="custom-control custom-switch mb-2">
            <input type="checkbox" v-model="s.isDivider" class="custom-control-input" id="spacerIsDividerSwitch" />
            <label class="custom-control-label small font-weight-bold" for="spacerIsDividerSwitch">Horizontal Divider Line</label>
          </div>

          <div class="form-group mb-2" v-if="s.isDivider">
            <label class="small font-weight-bold text-dark">Divider Style</label>
            <select v-model="s.dividerStyle" class="form-control form-control-sm">
              <option value="solid">Solid Line</option>
              <option value="dashed">Dashed Line</option>
              <option value="dotted">Dotted Line</option>
            </select>
          </div>
        </div>

        <!-- 8. DYNAMIC PRODUCTS CONTENT -->
        <div v-else-if="selectedBlock.type === 'products'">
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-database mr-1 text-primary"></i> Data Source
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Product Source</label>
              <select v-model="s.source" class="form-control form-control-sm">
                <option value="latest">Latest Published Products</option>
                <option value="featured">Featured Products (Star/Highlight)</option>
                <option value="category">Specific Category</option>
              </select>
            </div>

            <!-- Category selector if source === 'category' -->
            <div class="form-group mb-2" v-if="s.source === 'category'">
              <label class="small font-weight-bold text-dark">Select Category</label>
              <select v-model="s.category_id" class="form-control form-control-sm">
                <option :value="null">-- Select a Category --</option>
                <option v-for="cat in productCategories" :key="cat.id" :value="cat.id">
                  {{ cat.category_name }}
                </option>
              </select>
            </div>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Items Limit</label>
              <select v-model.number="s.limit" class="form-control form-control-sm">
                <option :value="2">2 Products</option>
                <option :value="3">3 Products</option>
                <option :value="4">4 Products (Standard)</option>
                <option :value="6">6 Products (2 Rows)</option>
                <option :value="8">8 Products (Double Row)</option>
                <option :value="12">12 Products</option>
              </select>
            </div>
          </div>

          <!-- Grid Columns Layout -->
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-th-large mr-1 text-primary"></i> Grid Columns
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Desktop Columns</label>
              <select v-model="s.columns_desktop" class="form-control form-control-sm">
                <option value="col-lg-3">4 Columns (col-lg-3)</option>
                <option value="col-lg-4">3 Columns (col-lg-4)</option>
                <option value="col-lg-6">2 Columns (col-lg-6)</option>
              </select>
            </div>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Mobile Columns</label>
              <select v-model="s.columns_mobile" class="form-control form-control-sm">
                <option value="col-6">2 Columns Side-by-Side (col-6)</option>
                <option value="col-12">1 Column Full Width (col-12)</option>
              </select>
            </div>
          </div>

          <!-- Card Elements Toggles -->
          <div class="card border rounded-3 p-3 mb-2 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-sliders-h mr-1 text-primary"></i> Card Elements
            </h6>

            <div class="custom-control custom-switch mb-2">
              <input type="checkbox" v-model="s.show_badge" class="custom-control-input" id="prodShowBadgeSwitch" />
              <label class="custom-control-label small font-weight-bold" for="prodShowBadgeSwitch">Show Promotional Badges</label>
            </div>

            <div class="custom-control custom-switch mb-2">
              <input type="checkbox" v-model="s.show_price" class="custom-control-input" id="prodShowPriceSwitch" />
              <label class="custom-control-label small font-weight-bold" for="prodShowPriceSwitch">Show Price & Special Offers</label>
            </div>

            <div class="custom-control custom-switch mb-0">
              <input type="checkbox" v-model="s.show_action_buttons" class="custom-control-input" id="prodShowActionSwitch" />
              <label class="custom-control-label small font-weight-bold" for="prodShowActionSwitch">Show Add to Cart Button</label>
            </div>
          </div>
        </div>

        <!-- 9. FAQ ACCORDION CONTENT -->
        <div v-else-if="selectedBlock.type === 'accordion'">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <span class="small font-weight-bold text-dark">FAQ Items ({{ (s.items || []).length }})</span>
            <button type="button" class="btn btn-xs btn-primary font-weight-bold shadow-2xs" @click="addAccordionItem">
              <i class="fas fa-plus mr-1"></i> Add Question
            </button>
          </div>

          <div v-if="!s.items || !s.items.length" class="text-center py-3 text-muted bg-light rounded border mb-3">
            <small>No questions yet. Click "Add Question" above.</small>
          </div>

          <div v-else class="accordion-items-list mb-3">
            <div
              v-for="(item, idx) in s.items"
              :key="item.id || idx"
              class="card border rounded-3 p-2 mb-2 bg-light shadow-2xs"
            >
              <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="badge badge-secondary" style="font-size: 0.65rem;">#{{ idx + 1 }}</span>
                <div class="btn-group btn-group-xs">
                  <button type="button" class="btn btn-xs text-muted p-1" :disabled="idx === 0" @click="moveAccordionItem(idx, -1)" title="Move Up">
                    <i class="fas fa-chevron-up"></i>
                  </button>
                  <button type="button" class="btn btn-xs text-muted p-1" :disabled="idx === s.items.length - 1" @click="moveAccordionItem(idx, 1)" title="Move Down">
                    <i class="fas fa-chevron-down"></i>
                  </button>
                  <button type="button" class="btn btn-xs text-danger p-1 ml-1" @click="deleteAccordionItem(idx)" title="Remove Question">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </div>
              </div>

              <div class="form-group mb-1">
                <input
                  v-model="item.title"
                  type="text"
                  class="form-control form-control-sm font-weight-bold"
                  placeholder="Question title..."
                />
              </div>

              <div class="form-group mb-0">
                <textarea
                  v-model="item.content"
                  class="form-control form-control-sm"
                  rows="2"
                  placeholder="Answer text / details..."
                ></textarea>
              </div>
            </div>
          </div>

          <!-- Accordion Options -->
          <div class="card border rounded-3 p-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-cog mr-1 text-primary"></i> Accordion Behavior
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Visual Style</label>
              <select v-model="s.style" class="form-control form-control-sm">
                <option value="separated">Separated Cards (Modern Floating)</option>
                <option value="bordered">Bordered Box (Classic Panel)</option>
                <option value="flush">Flush Minimal (Borderless)</option>
              </select>
            </div>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Indicator Icon</label>
              <select v-model="s.icon_type" class="form-control form-control-sm">
                <option value="chevron">Chevron Arrow</option>
                <option value="plus_minus">Plus / Minus (+ / −)</option>
              </select>
            </div>

            <div class="custom-control custom-switch mb-2">
              <input type="checkbox" v-model="s.first_open" class="custom-control-input" id="accFirstOpenSwitch" />
              <label class="custom-control-label small font-weight-bold" for="accFirstOpenSwitch">Open 1st Item by Default</label>
            </div>

            <div class="custom-control custom-switch mb-0">
              <input type="checkbox" v-model="s.allow_multiple" class="custom-control-input" id="accMultipleSwitch" />
              <label class="custom-control-label small font-weight-bold" for="accMultipleSwitch">Allow Multiple Open at Once</label>
            </div>
          </div>
        </div>

        <!-- 10. DYNAMIC NEWS / EDITORIAL CONTENT -->
        <div v-else-if="selectedBlock.type === 'news'">
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-newspaper mr-1 text-primary"></i> News / Articles Source
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Articles Limit</label>
              <select v-model.number="s.limit" class="form-control form-control-sm">
                <option :value="3">3 Articles (Standard 1 Row)</option>
                <option :value="4">4 Articles</option>
                <option :value="6">6 Articles (2 Rows)</option>
                <option :value="9">9 Articles (3 Rows)</option>
              </select>
            </div>
          </div>

          <div class="card border rounded-3 p-3 mb-2 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-th-large mr-1 text-primary"></i> Grid Columns
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Desktop Columns</label>
              <select v-model="s.columns_desktop" class="form-control form-control-sm">
                <option value="col-lg-4">3 Columns (col-lg-4)</option>
                <option value="col-lg-3">4 Columns (col-lg-3)</option>
                <option value="col-lg-6">2 Columns (col-lg-6)</option>
              </select>
            </div>

            <div class="form-group mb-0">
              <label class="small font-weight-bold text-dark">Mobile Columns</label>
              <select v-model="s.columns_mobile" class="form-control form-control-sm">
                <option value="col-12">1 Column Full Width (col-12)</option>
                <option value="col-6">2 Columns (col-6)</option>
              </select>
            </div>
          </div>
        </div>

        <!-- 11. DYNAMIC CATEGORIES GRID -->
        <div v-else-if="selectedBlock.type === 'categories'">
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-th-large mr-1 text-primary"></i> Categories Source
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Categories Limit</label>
              <select v-model.number="s.limit" class="form-control form-control-sm">
                <option :value="4">4 Categories</option>
                <option :value="6">6 Categories (Standard)</option>
                <option :value="8">8 Categories</option>
                <option :value="12">12 Categories</option>
              </select>
            </div>

            <div class="custom-control custom-switch mb-0">
              <input type="checkbox" v-model="s.show_count" class="custom-control-input" id="catShowCountSwitch" />
              <label class="custom-control-label small font-weight-bold" for="catShowCountSwitch">Show Product Count Badge</label>
            </div>
          </div>

          <div class="card border rounded-3 p-3 mb-2 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-columns mr-1 text-primary"></i> Grid Columns
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Desktop Columns</label>
              <select v-model="s.columns_desktop" class="form-control form-control-sm">
                <option value="col-lg-2">6 Columns (col-lg-2)</option>
                <option value="col-lg-3">4 Columns (col-lg-3)</option>
                <option value="col-lg-4">3 Columns (col-lg-4)</option>
              </select>
            </div>

            <div class="form-group mb-0">
              <label class="small font-weight-bold text-dark">Mobile Columns</label>
              <select v-model="s.columns_mobile" class="form-control form-control-sm">
                <option value="col-6">2 Columns (col-6)</option>
                <option value="col-4">3 Columns (col-4)</option>
                <option value="col-12">1 Column (col-12)</option>
              </select>
            </div>
          </div>
        </div>

        <!-- 12. DYNAMIC BRAND PARTNERS -->
        <div v-else-if="selectedBlock.type === 'brands'">
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-certificate mr-1 text-primary"></i> Brand Showcase
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Brand Limit</label>
              <select v-model.number="s.limit" class="form-control form-control-sm">
                <option :value="4">4 Brands</option>
                <option :value="6">6 Brands (Standard)</option>
                <option :value="8">8 Brands</option>
                <option :value="12">12 Brands</option>
              </select>
            </div>

            <div class="custom-control custom-switch mb-2">
              <input type="checkbox" v-model="s.grayscale" class="custom-control-input" id="brandGrayscaleSwitch" />
              <label class="custom-control-label small font-weight-bold" for="brandGrayscaleSwitch">Monochrome with Hover Color</label>
            </div>

            <div class="custom-control custom-switch mb-0">
              <input type="checkbox" v-model="s.boxed" class="custom-control-input" id="brandBoxedSwitch" />
              <label class="custom-control-label small font-weight-bold" for="brandBoxedSwitch">White Card Container Box</label>
            </div>
          </div>

          <div class="card border rounded-3 p-3 mb-2 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-columns mr-1 text-primary"></i> Grid Columns
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Desktop Columns</label>
              <select v-model="s.columns_desktop" class="form-control form-control-sm">
                <option value="col-lg-2">6 Columns (col-lg-2)</option>
                <option value="col-lg-3">4 Columns (col-lg-3)</option>
                <option value="col-lg-4">3 Columns (col-lg-4)</option>
              </select>
            </div>

            <div class="form-group mb-0">
              <label class="small font-weight-bold text-dark">Mobile Columns</label>
              <select v-model="s.columns_mobile" class="form-control form-control-sm">
                <option value="col-4">3 Columns (col-4)</option>
                <option value="col-6">2 Columns (col-6)</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- ==================================================================== -->
      <!-- TAB 2: STYLE & TYPOGRAPHY TAB                                        -->
      <!-- ==================================================================== -->
      <div v-show="activeTab === 'style'">
        
        <!-- TYPOGRAPHY SETTINGS (For Heading & Paragraph) -->
        <div v-if="['heading', 'paragraph'].includes(selectedBlock.type)">
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-font mr-1 text-primary"></i> Typography
            </h6>

            <!-- Font Size Preset -->
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Font Size Preset</label>
              <select v-model="s.fontSize" class="form-control form-control-sm">
                <option value="display-3 font-weight-bold">Display 3 (Extra Large Hero)</option>
                <option value="display-4 font-weight-bold">Display 4 (Large Hero)</option>
                <option value="title-2">Title 2 (Standard Section Header)</option>
                <option value="h2">H2 (2rem / 32px)</option>
                <option value="h3">H3 (1.75rem / 28px)</option>
                <option value="h4">H4 (1.5rem / 24px)</option>
                <option value="fs-18">Medium (18px)</option>
                <option value="lead">Lead (1.25rem)</option>
                <option value="small">Small Body (14px)</option>
              </select>
            </div>

            <!-- Custom Font Size Input -->
            <div class="form-group mb-2">
              <label class="small text-muted mb-1">Custom Font Size (e.g. 42px or 2.2rem)</label>
              <input v-model="s.fontSizeCustom" type="text" class="form-control form-control-sm" placeholder="Leave empty for preset" />
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Weight</label>
                  <select v-model="s.fontWeight" class="form-control form-control-sm">
                    <option value="">Default</option>
                    <option value="300">Light (300)</option>
                    <option value="400">Regular (400)</option>
                    <option value="500">Medium (500)</option>
                    <option value="600">Semi-Bold (600)</option>
                    <option value="700">Bold (700)</option>
                    <option value="800">Extra Bold (800)</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Transform</label>
                  <select v-model="s.textTransform" class="form-control form-control-sm">
                    <option value="">None</option>
                    <option value="uppercase">UPPERCASE</option>
                    <option value="capitalize">Capitalize</option>
                    <option value="lowercase">lowercase</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Letter Spacing</label>
                  <select v-model="s.letterSpacing" class="form-control form-control-sm">
                    <option value="">Default</option>
                    <option value="-1px">Tight (-1px)</option>
                    <option value="-0.5px">Semi-Tight (-0.5px)</option>
                    <option value="0">Normal (0)</option>
                    <option value="1px">Wide (1px)</option>
                    <option value="2px">Extra Wide (2px)</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Line Height</label>
                  <select v-model="s.lineHeight" class="form-control form-control-sm">
                    <option value="">Default</option>
                    <option value="1.1">Tight (1.1)</option>
                    <option value="1.3">Snug (1.3)</option>
                    <option value="1.5">Normal (1.5)</option>
                    <option value="1.8">Relaxed (1.8)</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Text Color -->
            <div class="form-group mb-0">
              <label class="small font-weight-bold text-dark">Text Color</label>
              <div class="input-group input-group-sm mb-1">
                <input v-model="s.color" type="color" class="form-control form-control-color p-0 border-0" style="max-width: 40px;" />
                <input v-model="s.color" type="text" class="form-control form-control-sm" placeholder="#0d1b2a or rgb(...)" />
              </div>
              <div class="d-flex align-items-center color-swatches-row">
                <button
                  v-for="color in brandSwatches"
                  :key="color"
                  type="button"
                  class="color-swatch-dot border"
                  :style="{ backgroundColor: color }"
                  :title="color"
                  @click="s.color = color"
                ></button>
              </div>
            </div>
          </div>
        </div>

        <!-- IMAGE STYLING -->
        <div v-if="selectedBlock.type === 'image'">
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-shapes mr-1 text-primary"></i> Dimensions & Ratio
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Max Width</label>
              <select v-model="s.maxWidth" class="form-control form-control-sm">
                <option value="100%">100% Full Column</option>
                <option value="85%">85% Column Width</option>
                <option value="70%">70% Column Width</option>
                <option value="50%">50% Column Width</option>
                <option value="420px">Medium Fixed (420px)</option>
                <option value="300px">Compact Fixed (300px)</option>
              </select>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Aspect Ratio</label>
                  <select v-model="s.aspectRatio" class="form-control form-control-sm">
                    <option value="auto">Auto (Natural)</option>
                    <option value="1/1">1:1 Square</option>
                    <option value="16/9">16:9 Widescreen</option>
                    <option value="4/3">4:3 Classic</option>
                    <option value="3/2">3:2 Standard</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Object Fit</label>
                  <select v-model="s.objectFit" class="form-control form-control-sm">
                    <option value="cover">Cover (Crop)</option>
                    <option value="contain">Contain (Fit)</option>
                    <option value="fill">Fill</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Border Radius</label>
                  <select v-model="s.rounded" class="form-control form-control-sm">
                    <option value="rounded-0">Square (0)</option>
                    <option value="rounded-2">Subtle (6px)</option>
                    <option value="rounded-3">Rounded (12px)</option>
                    <option value="rounded-4">Soft (16px)</option>
                    <option value="rounded-circle">Circle</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Shadow</label>
                  <select v-model="s.shadow" class="form-control form-control-sm">
                    <option value="">None</option>
                    <option value="shadow-sm">Small</option>
                    <option value="shadow">Medium</option>
                    <option value="shadow-lg">Large</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- BUTTON STYLING -->
        <div v-if="selectedBlock.type === 'button'">
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-palette mr-1 text-primary"></i> Button Appearance
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Size</label>
              <select v-model="s.size" class="form-control form-control-sm">
                <option value="btn-sm">Small Button (btn-sm)</option>
                <option value="btn-md">Medium Button (Standard)</option>
                <option value="btn-lg">Large Button (btn-lg)</option>
              </select>
            </div>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Style Variant</label>
              <select v-model="s.variant" class="form-control form-control-sm">
                <option value="btn-primary">Primary Solid</option>
                <option value="btn-outline-primary">Primary Outline</option>
                <option value="btn-dark">Dark Solid</option>
                <option value="btn-outline-dark">Dark Outline</option>
                <option value="btn-light border">Light Solid</option>
                <option value="btn-success">Success Solid</option>
              </select>
            </div>

            <!-- Custom Color Overrides -->
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Custom Background (Override)</label>
              <div class="input-group input-group-sm mb-1">
                <input v-model="s.customBgColor" type="color" class="form-control form-control-color p-0 border-0" style="max-width: 40px;" />
                <input v-model="s.customBgColor" type="text" class="form-control form-control-sm" placeholder="e.g. #0095DA" />
              </div>
              <div class="d-flex align-items-center color-swatches-row">
                <button
                  v-for="color in brandSwatches"
                  :key="color"
                  type="button"
                  class="color-swatch-dot border"
                  :style="{ backgroundColor: color }"
                  :title="color"
                  @click="s.customBgColor = color"
                ></button>
              </div>
            </div>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Custom Text Color</label>
              <div class="input-group input-group-sm mb-1">
                <input v-model="s.customTextColor" type="color" class="form-control form-control-color p-0 border-0" style="max-width: 40px;" />
                <input v-model="s.customTextColor" type="text" class="form-control form-control-sm" placeholder="e.g. #ffffff" />
              </div>
              <div class="d-flex align-items-center color-swatches-row">
                <button
                  v-for="color in brandSwatches"
                  :key="color"
                  type="button"
                  class="color-swatch-dot border"
                  :style="{ backgroundColor: color }"
                  :title="color"
                  @click="s.customTextColor = color"
                ></button>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Shape</label>
                  <select v-model="s.rounded" class="form-control form-control-sm">
                    <option value="rounded-0">Square</option>
                    <option value="rounded-2">Subtle (6px)</option>
                    <option value="rounded-3">Rounded (12px)</option>
                    <option value="rounded-pill">Full Pill</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Shadow</label>
                  <select v-model="s.shadow" class="form-control form-control-sm">
                    <option value="">None</option>
                    <option value="shadow-sm">Soft</option>
                    <option value="shadow">Medium</option>
                    <option value="shadow-lg">Floating</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="custom-control custom-checkbox mb-0">
              <input type="checkbox" v-model="s.fullWidthMobile" class="custom-control-input" id="btnFullWidthMobileCheck" />
              <label class="custom-control-label small" for="btnFullWidthMobileCheck">Full Width on Mobile (100% block)</label>
            </div>
          </div>
        </div>

        <!-- CARD STYLING -->
        <div v-if="selectedBlock.type === 'card'">
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-layer-group mr-1 text-primary"></i> Card Styling & Theme
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Theme Preset</label>
              <select v-model="s.cardStylePreset" class="form-control form-control-sm">
                <option value="white">Clean White (Standard)</option>
                <option value="glass">Frosted Glassmorphism</option>
                <option value="dark">Modern Dark</option>
                <option value="light">Soft Light Gray</option>
                <option value="custom">Custom Color Palette</option>
              </select>
            </div>

            <!-- Custom Background & Border Color when custom preset chosen -->
            <div v-if="s.cardStylePreset === 'custom'">
              <div class="form-group mb-2">
                <label class="small font-weight-bold text-dark">Card Background</label>
                <div class="input-group input-group-sm mb-1">
                  <input v-model="s.customBgColor" type="color" class="form-control form-control-color p-0 border-0" style="max-width: 40px;" />
                  <input v-model="s.customBgColor" type="text" class="form-control form-control-sm" placeholder="#ffffff" />
                </div>
                <div class="d-flex align-items-center color-swatches-row">
                  <button
                    v-for="color in brandSwatches"
                    :key="color"
                    type="button"
                    class="color-swatch-dot border"
                    :style="{ backgroundColor: color }"
                    :title="color"
                    @click="s.customBgColor = color"
                  ></button>
                </div>
              </div>

              <div class="form-group mb-2">
                <label class="small font-weight-bold text-dark">Card Border Color</label>
                <div class="input-group input-group-sm mb-1">
                  <input v-model="s.customBorderColor" type="color" class="form-control form-control-color p-0 border-0" style="max-width: 40px;" />
                  <input v-model="s.customBorderColor" type="text" class="form-control form-control-sm" placeholder="#e2e8f0" />
                </div>
                <div class="d-flex align-items-center color-swatches-row">
                  <button
                    v-for="color in brandSwatches"
                    :key="color"
                    type="button"
                    class="color-swatch-dot border"
                    :style="{ backgroundColor: color }"
                    :title="color"
                    @click="s.customBorderColor = color"
                  ></button>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Padding</label>
                  <select v-model="s.padding" class="form-control form-control-sm">
                    <option value="p-3">Compact (p-3)</option>
                    <option value="p-4">Standard (p-4)</option>
                    <option value="p-5">Spacious (p-5)</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Corner Radius</label>
                  <select v-model="s.rounded" class="form-control form-control-sm">
                    <option value="rounded-2">Subtle (6px)</option>
                    <option value="rounded-3">Rounded (12px)</option>
                    <option value="rounded-4">Soft (16px)</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group mb-0">
              <label class="small font-weight-bold text-dark">Shadow</label>
              <select v-model="s.shadow" class="form-control form-control-sm">
                <option value="">None</option>
                <option value="shadow-sm">Soft Shadow</option>
                <option value="shadow">Medium Shadow</option>
                <option value="shadow-lg">Elevated Shadow</option>
              </select>
            </div>
          </div>
        </div>

        <!-- CONTAINER STYLING -->
        <div v-if="selectedBlock.type === 'container'">
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-brush mr-1 text-primary"></i> Wrapper Styling
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Background Color</label>
              <div class="input-group input-group-sm mb-1">
                <input v-model="s.bgColor" type="color" class="form-control form-control-color p-0 border-0" style="max-width: 40px;" />
                <input v-model="s.bgColor" type="text" class="form-control form-control-sm" placeholder="transparent or #f8fafc" />
              </div>
              <div class="d-flex align-items-center color-swatches-row">
                <button
                  v-for="color in brandSwatches"
                  :key="color"
                  type="button"
                  class="color-swatch-dot border"
                  :style="{ backgroundColor: color }"
                  :title="color"
                  @click="s.bgColor = color"
                ></button>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Internal Padding</label>
                  <select v-model="s.padding" class="form-control form-control-sm">
                    <option value="">None</option>
                    <option value="p-2">Small (p-2)</option>
                    <option value="p-3">Medium (p-3)</option>
                    <option value="p-4">Large (p-4)</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Corner Radius</label>
                  <select v-model="s.rounded" class="form-control form-control-sm">
                    <option value="">None</option>
                    <option value="rounded-3">Rounded (12px)</option>
                    <option value="rounded-4">Soft (16px)</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 7. BRAND SHOWCASE STYLING -->
        <div v-if="selectedBlock.type === 'brands'">
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-certificate mr-1 text-primary"></i> Brand Card Appearance
            </h6>

            <!-- Boxed Card vs Minimal -->
            <div class="custom-control custom-switch mb-3">
              <input type="checkbox" v-model="s.boxed" class="custom-control-input" id="styleBrandBoxedSwitch" />
              <label class="custom-control-label small font-weight-bold" for="styleBrandBoxedSwitch">Boxed Card Container</label>
            </div>

            <!-- Card Background Color (when boxed) -->
            <div v-if="s.boxed !== false" class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Card Background</label>
              <div class="input-group input-group-sm mb-1">
                <input v-model="s.card_bg" type="color" class="form-control form-control-color p-0 border-0" style="max-width: 40px;" />
                <input v-model="s.card_bg" type="text" class="form-control form-control-sm" placeholder="#ffffff" />
              </div>
              <div class="d-flex align-items-center color-swatches-row">
                <button
                  v-for="color in brandSwatches"
                  :key="color"
                  type="button"
                  class="color-swatch-dot border"
                  :style="{ backgroundColor: color }"
                  :title="color"
                  @click="s.card_bg = color"
                ></button>
              </div>
            </div>

            <!-- Card Border Color -->
            <div v-if="s.boxed !== false" class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Border Color</label>
              <div class="input-group input-group-sm mb-1">
                <input v-model="s.card_border_color" type="color" class="form-control form-control-color p-0 border-0" style="max-width: 40px;" />
                <input v-model="s.card_border_color" type="text" class="form-control form-control-sm" placeholder="#e2e8f0" />
              </div>
              <div class="d-flex align-items-center color-swatches-row">
                <button
                  v-for="color in brandSwatches"
                  :key="color"
                  type="button"
                  class="color-swatch-dot border"
                  :style="{ backgroundColor: color }"
                  :title="color"
                  @click="s.card_border_color = color"
                ></button>
              </div>
            </div>

            <div v-if="s.boxed !== false" class="row">
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Corner Radius</label>
                  <select v-model="s.card_rounded" class="form-control form-control-sm">
                    <option value="rounded-0">Square (0)</option>
                    <option value="rounded-2">Subtle (6px)</option>
                    <option value="rounded-3">Rounded (12px)</option>
                    <option value="rounded-4">Soft (16px)</option>
                    <option value="rounded-pill">Pill</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Shadow</label>
                  <select v-model="s.card_shadow" class="form-control form-control-sm">
                    <option value="">None</option>
                    <option value="shadow-sm">Soft (sm)</option>
                    <option value="shadow">Medium</option>
                    <option value="shadow-lg">Floating (lg)</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Card Height</label>
                  <select v-model="s.card_height" class="form-control form-control-sm">
                    <option value="72px">Compact (72px)</option>
                    <option value="90px">Standard (90px)</option>
                    <option value="110px">Spacious (110px)</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Logo Max Height</label>
                  <select v-model="s.logo_height" class="form-control form-control-sm">
                    <option value="40px">Small (40px)</option>
                    <option value="55px">Standard (55px)</option>
                    <option value="70px">Large (70px)</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Logo Effects -->
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-magic mr-1 text-primary"></i> Logo Effects & Hover
            </h6>

            <div class="custom-control custom-switch mb-2">
              <input type="checkbox" v-model="s.grayscale" class="custom-control-input" id="styleBrandGrayscaleSwitch" />
              <label class="custom-control-label small font-weight-bold" for="styleBrandGrayscaleSwitch">Monochrome with Hover Color</label>
            </div>

            <div v-if="s.grayscale !== false" class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Inactive Logo Opacity</label>
              <select v-model="s.opacity" class="form-control form-control-sm">
                <option value="0.5">50% Subtle</option>
                <option value="0.65">65% Standard</option>
                <option value="0.8">80% Prominent</option>
                <option value="1">100% Full</option>
              </select>
            </div>

            <div class="form-group mb-0">
              <label class="small font-weight-bold text-dark">Hover Interaction</label>
              <select v-model="s.hover_effect" class="form-control form-control-sm">
                <option value="lift">Lift Up & Primary Border</option>
                <option value="zoom">Zoom Scale (1.04x)</option>
                <option value="border">Border Highlight Only</option>
                <option value="none">None</option>
              </select>
            </div>
          </div>
        </div>

        <!-- 8. CATEGORIES STYLING -->
        <div v-if="selectedBlock.type === 'categories'">
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-th-large mr-1 text-primary"></i> Categories Card Appearance
            </h6>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Card Background</label>
              <div class="input-group input-group-sm mb-1">
                <input v-model="s.card_bg" type="color" class="form-control form-control-color p-0 border-0" style="max-width: 40px;" />
                <input v-model="s.card_bg" type="text" class="form-control form-control-sm" placeholder="#ffffff or inherit" />
              </div>
              <div class="d-flex align-items-center color-swatches-row">
                <button
                  v-for="color in brandSwatches"
                  :key="color"
                  type="button"
                  class="color-swatch-dot border"
                  :style="{ backgroundColor: color }"
                  :title="color"
                  @click="s.card_bg = color"
                ></button>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Corner Radius</label>
                  <select v-model="s.card_rounded" class="form-control form-control-sm">
                    <option value="rounded-2">Subtle (6px)</option>
                    <option value="rounded-3">Rounded (12px)</option>
                    <option value="rounded-4">Soft (16px)</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Shadow</label>
                  <select v-model="s.card_shadow" class="form-control form-control-sm">
                    <option value="">None</option>
                    <option value="shadow-sm">Soft (sm)</option>
                    <option value="shadow">Medium</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 9. PRODUCTS STYLING -->
        <div v-if="selectedBlock.type === 'products'">
          <div class="card border rounded-3 p-3 mb-3 bg-light">
            <h6 class="small font-weight-bold text-dark mb-2">
              <i class="fas fa-box-open mr-1 text-primary"></i> Product Grid Appearance
            </h6>

            <div class="row">
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Card Shadow</label>
                  <select v-model="s.card_shadow" class="form-control form-control-sm">
                    <option value="">None</option>
                    <option value="shadow-sm">Soft (sm)</option>
                    <option value="shadow">Medium</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group mb-2">
                  <label class="small font-weight-bold text-dark">Hover Effect</label>
                  <select v-model="s.hover_effect" class="form-control form-control-sm">
                    <option value="lift">Hover Lift Up</option>
                    <option value="none">None</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ==================================================================== -->
      <!-- TAB 3: ADVANCED TAB (SPACING, VISIBILITY, CUSTOM CSS)                 -->
      <!-- ==================================================================== -->
      <div v-show="activeTab === 'advanced'">
        
        <!-- BLOCK SPACING (MARGINS) -->
        <div class="card border rounded-3 p-3 mb-3 bg-light">
          <h6 class="small font-weight-bold text-dark mb-2">
            <i class="fas fa-arrows-alt-v mr-1 text-primary"></i> Margin & Spacing
          </h6>

          <div class="row">
            <div class="col-6">
              <div class="form-group mb-2">
                <label class="small font-weight-bold text-dark">Margin Top</label>
                <select v-model="s.marginTop" class="form-control form-control-sm">
                  <option value="">None (0)</option>
                  <option value="mt-1">Tiny (mt-1)</option>
                  <option value="mt-2">Small (mt-2)</option>
                  <option value="mt-3">Standard (mt-3)</option>
                  <option value="mt-4">Large (mt-4)</option>
                  <option value="mt-5">Extra Large (mt-5)</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group mb-2">
                <label class="small font-weight-bold text-dark">Margin Bottom</label>
                <select v-model="s.marginBottom" class="form-control form-control-sm">
                  <option value="">Default</option>
                  <option value="mb-0">Zero (mb-0)</option>
                  <option value="mb-1">Tiny (mb-1)</option>
                  <option value="mb-2">Small (mb-2)</option>
                  <option value="mb-3">Standard (mb-3)</option>
                  <option value="mb-4">Large (mb-4)</option>
                  <option value="mb-5">Extra Large (mb-5)</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- HOVER & INTERACTION EFFECTS -->
        <div class="card border rounded-3 p-3 mb-3 bg-light">
          <h6 class="small font-weight-bold text-dark mb-2">
            <i class="fas fa-magic mr-1 text-primary"></i> Hover & Animation Effects
          </h6>

          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Hover Animation</label>
            <select v-model="s.hoverEffect" class="form-control form-control-sm">
              <option value="">None</option>
              <option value="hover-lift">Hover Lift (Floats up subtly)</option>
              <option value="hover-zoom">Hover Zoom (Slight expansion)</option>
              <option value="hover-glow">Hover Glow (Soft drop shadow)</option>
            </select>
          </div>

          <!-- Scroll Entrance Animation -->
          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Scroll Entrance Animation</label>
            <select v-model="s.scrollAnimation" class="form-control form-control-sm">
              <option value="">None (Static)</option>
              <option value="fade-up">Fade Up (↑)</option>
              <option value="fade-down">Fade Down (↓)</option>
              <option value="fade-left">Fade Left (←)</option>
              <option value="fade-right">Fade Right (→)</option>
              <option value="zoom-in">Zoom In</option>
              <option value="flip-up">Flip Up</option>
            </select>
          </div>

          <div class="row" v-if="s.scrollAnimation">
            <div class="col-6">
              <div class="form-group mb-0">
                <label class="small font-weight-bold text-dark">Delay</label>
                <select v-model="s.animationDelay" class="form-control form-control-sm">
                  <option :value="0">0ms (Instant)</option>
                  <option :value="100">100ms</option>
                  <option :value="200">200ms</option>
                  <option :value="300">300ms</option>
                  <option :value="500">500ms</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group mb-0">
                <label class="small font-weight-bold text-dark">Duration</label>
                <select v-model="s.animationDuration" class="form-control form-control-sm">
                  <option :value="300">Fast (0.3s)</option>
                  <option :value="600">Standard (0.6s)</option>
                  <option :value="1000">Slow (1.0s)</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- DEVICE VISIBILITY (Available on all blocks) -->
        <div class="card border rounded-3 p-3 mb-3 bg-light">
          <h6 class="small font-weight-bold text-dark mb-2">
            <i class="fas fa-eye mr-1 text-primary"></i> Responsive Visibility
          </h6>

          <div class="custom-control custom-checkbox mb-2">
            <input
              type="checkbox"
              v-model="vis.hideOnMobile"
              class="custom-control-input"
              :id="'hideMobileCheck_' + selectedBlock.id"
            />
            <label class="custom-control-label small text-muted" :for="'hideMobileCheck_' + selectedBlock.id">
              Hide on Mobile (&lt; 768px)
            </label>
          </div>

          <div class="custom-control custom-checkbox mb-2">
            <input
              type="checkbox"
              v-model="vis.hideOnTablet"
              class="custom-control-input"
              :id="'hideTabletCheck_' + selectedBlock.id"
            />
            <label class="custom-control-label small text-muted" :for="'hideTabletCheck_' + selectedBlock.id">
              Hide on Tablet (768px – 991px)
            </label>
          </div>

          <div class="custom-control custom-checkbox">
            <input
              type="checkbox"
              v-model="vis.hideOnDesktop"
              class="custom-control-input"
              :id="'hideDesktopCheck_' + selectedBlock.id"
            />
            <label class="custom-control-label small text-muted" :for="'hideDesktopCheck_' + selectedBlock.id">
              Hide on Desktop (&gt;= 992px)
            </label>
          </div>
        </div>

        <!-- CUSTOM CSS & DEVELOPER ATTRIBUTES -->
        <div class="card border rounded-3 p-3 bg-light">
          <h6 class="small font-weight-bold text-dark mb-2">
            <i class="fas fa-code mr-1 text-primary"></i> Developer Attributes
          </h6>

          <div class="form-group mb-2">
            <label class="small font-weight-bold text-dark">Custom HTML ID</label>
            <input v-model="s.custom_id" type="text" class="form-control form-control-sm" placeholder="e.g. hero-main-heading" />
            <small class="text-muted" style="font-size: 0.7rem;">For CSS targeting or anchor scroll navigation.</small>
          </div>

          <div class="form-group mb-0">
            <label class="small font-weight-bold text-dark">Extra CSS Classes</label>
            <input v-model="s.custom_class" type="text" class="form-control form-control-sm" placeholder="e.g. text-gradient shadow-2xs" />
          </div>
        </div>
      </div>

    </div>

    <!-- Empty state when no block is selected -->
    <div v-else class="p-4 text-center text-muted my-auto">
      <i class="fas fa-mouse-pointer fa-2x mb-2 text-primary opacity-50"></i>
      <p class="small mb-0 font-weight-bold">Select any block on the canvas to configure its settings.</p>
    </div>

    <!-- Media Library Modal Integration -->
    <MediaLibraryModal
      :show="showMediaModal"
      :current-value="s.url || ''"
      @close="showMediaModal = false"
      @select="onMediaSelect"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { getImageUrl } from '@/layouts/helpers/helpers';
import MediaLibraryModal from './MediaLibraryModal.vue';

const props = defineProps({
  selectedBlock: {
    type: Object,
    default: null
  },
  hideHeader: {
    type: Boolean,
    default: false
  }
});

defineEmits(['close']);

const activeTab = ref('content');
const scopeMode = ref('desktop');
const showMediaModal = ref(false);
const productCategories = ref([]);

const brandSwatches = [
  '#0095DA',
  '#0D1B2A',
  '#1E293B',
  '#64748B',
  '#10B981',
  '#EF4444',
  '#F59E0B',
  '#F8FAFC',
  '#FFFFFF'
];

async function loadProductCategories() {
  try {
    const { data } = await axios.get('/api/product-categories/all');
    productCategories.value = data.data || [];
  } catch (err) {
    console.error('Failed to load product categories', err);
  }
}

onMounted(() => {
  loadProductCategories();
});

function addAccordionItem() {
  if (!s.value.items) s.value.items = [];
  const nextIdx = s.value.items.length + 1;
  s.value.items.push({
    id: 'item_' + Date.now(),
    title: `Question #${nextIdx}`,
    content: 'Answer content details for this question.'
  });
}

function deleteAccordionItem(index) {
  if (!s.value.items) return;
  s.value.items.splice(index, 1);
}

function moveAccordionItem(index, direction) {
  if (!s.value.items) return;
  const newIndex = index + direction;
  if (newIndex < 0 || newIndex >= s.value.items.length) return;
  const item = s.value.items.splice(index, 1)[0];
  s.value.items.splice(newIndex, 0, item);
}

function onMediaSelect(file) {
  s.value.url = file.path ? (file.path.startsWith('storage/') ? file.path : 'storage/' + file.path) : file.url;
  if (!s.value.alt && file.name) {
    const cleanName = file.name.replace(/\.[^/.]+$/, '').replace(/[-_]/g, ' ');
    s.value.alt = cleanName;
  }
}

const s = computed(() => {
  if (!props.selectedBlock) return {};
  if (!props.selectedBlock.settings) {
    props.selectedBlock.settings = {};
  }
  return props.selectedBlock.settings;
});

const vis = computed(() => {
  if (!s.value.visibility) {
    s.value.visibility = { hideOnMobile: false, hideOnTablet: false, hideOnDesktop: false };
  }
  return s.value.visibility;
});

// Scope-aware alignment helper
function getAlign() {
  if (!s.value.align) {
    s.value.align = { desktop: 'text-start', mobile: 'text-center' };
  }
  if (typeof s.value.align === 'string') {
    return s.value.align;
  }
  return s.value.align[scopeMode.value] || 'text-start';
}

function setAlign(val) {
  if (typeof s.value.align !== 'object' || s.value.align === null) {
    s.value.align = { desktop: s.value.align || 'text-start', mobile: 'text-center' };
  }
  s.value.align[scopeMode.value] = val;
}

// Container columns and layout helper
const containerColsCount = computed(() => {
  return Array.isArray(props.selectedBlock?.columns) ? props.selectedBlock.columns.length : 2;
});

function addContainerColumn() {
  if (!props.selectedBlock) return;
  if (!Array.isArray(props.selectedBlock.columns)) {
    props.selectedBlock.columns = [[], []];
  }
  if (props.selectedBlock.columns.length < 6) {
    props.selectedBlock.columns.push([]);
    syncContainerColumns(props.selectedBlock.columns.length);
  }
}

function removeContainerColumn() {
  if (!props.selectedBlock) return;
  if (Array.isArray(props.selectedBlock.columns) && props.selectedBlock.columns.length > 1) {
    props.selectedBlock.columns.pop();
    syncContainerColumns(props.selectedBlock.columns.length);
  }
}

function syncContainerColumns(count) {
  let desktop = 'col-lg-6';
  if (count === 1) desktop = 'col-lg-12';
  else if (count === 2) desktop = 'col-lg-6';
  else if (count === 3) desktop = 'col-lg-4';
  else if (count === 4) desktop = 'col-lg-3';
  else if (count === 5) desktop = 'col-lg';
  else if (count === 6) desktop = 'col-lg-2';

  if (!s.value.layout) s.value.layout = {};
  s.value.layout.desktop = desktop;
  s.value.layout.tablet = count >= 4 ? 'col-md-4' : 'col-md-6';
  s.value.layout.mobile = count >= 4 ? 'col-6' : 'col-12';
  s.value.columnsCount = count;
  s.value.columnClasses = [];
}

const containerLayout = computed({
  get() {
    if (Array.isArray(s.value.columnClasses) && s.value.columnClasses.length === 2) {
      const c = s.value.columnClasses;
      if (c[0] === 'col-lg-4' && c[1] === 'col-lg-8') return 'custom_1_2';
      if (c[0] === 'col-lg-8' && c[1] === 'col-lg-4') return 'custom_2_1';
      if (c[0] === 'col-lg-3' && c[1] === 'col-lg-9') return 'custom_1_3';
      if (c[0] === 'col-lg-9' && c[1] === 'col-lg-3') return 'custom_3_1';
    }
    if (!s.value.layout) {
      s.value.layout = { desktop: 'col-lg-6', tablet: 'col-md-6', mobile: 'col-12' };
    }
    return typeof s.value.layout === 'object' ? s.value.layout.desktop : s.value.layout;
  },
  set(val) {
    if (!props.selectedBlock) return;
    if (typeof s.value.layout !== 'object' || s.value.layout === null) {
      s.value.layout = { desktop: 'col-lg-6', tablet: 'col-md-6', mobile: 'col-12' };
    }

    if (!Array.isArray(props.selectedBlock.columns)) {
      props.selectedBlock.columns = [[], []];
    }

    if (val === 'custom_1_2') {
      s.value.columnClasses = ['col-lg-4', 'col-lg-8'];
      ensureColumnCount(2);
      s.value.layout.desktop = 'col-lg-6';
    } else if (val === 'custom_2_1') {
      s.value.columnClasses = ['col-lg-8', 'col-lg-4'];
      ensureColumnCount(2);
      s.value.layout.desktop = 'col-lg-6';
    } else if (val === 'custom_1_3') {
      s.value.columnClasses = ['col-lg-3', 'col-lg-9'];
      ensureColumnCount(2);
      s.value.layout.desktop = 'col-lg-6';
    } else if (val === 'custom_3_1') {
      s.value.columnClasses = ['col-lg-9', 'col-lg-3'];
      ensureColumnCount(2);
      s.value.layout.desktop = 'col-lg-6';
    } else {
      s.value.columnClasses = [];
      s.value.layout.desktop = val;
      if (val === 'col-lg-12') ensureColumnCount(1);
      else if (val === 'col-lg-6') ensureColumnCount(2);
      else if (val === 'col-lg-4') ensureColumnCount(3);
      else if (val === 'col-lg-3') ensureColumnCount(4);
      else if (val === 'col-lg') ensureColumnCount(5);
      else if (val === 'col-lg-2') ensureColumnCount(6);
    }
  }
});

function ensureColumnCount(target) {
  if (!props.selectedBlock) return;
  if (!Array.isArray(props.selectedBlock.columns)) props.selectedBlock.columns = [];
  while (props.selectedBlock.columns.length < target) {
    props.selectedBlock.columns.push([]);
  }
  while (props.selectedBlock.columns.length > target) {
    props.selectedBlock.columns.pop();
  }
  s.value.columnsCount = target;
}

const containerGap = computed({
  get() {
    if (!s.value.gap) {
      s.value.gap = { desktop: 'g-4', mobile: 'g-3' };
    }
    return typeof s.value.gap === 'object' ? s.value.gap.desktop : s.value.gap;
  },
  set(val) {
    if (typeof s.value.gap !== 'object' || s.value.gap === null) {
      s.value.gap = { desktop: 'g-4', mobile: 'g-3' };
    }
    s.value.gap.desktop = val;
  }
});
</script>

<style scoped>
.block-inspector {
  width: 340px;
  min-width: 340px;
}
.form-control-color {
  height: 31px;
}
.gap-1 { gap: 0.25rem !important; }
.gap-2 { gap: 0.5rem !important; }
.gap-3 { gap: 1rem !important; }
.rounded-4 { border-radius: 16px !important; }
.rounded-3 { border-radius: 12px !important; }
.rounded-2 { border-radius: 8px !important; }
.row.g-2 { margin-right: -6px; margin-left: -6px; }
.row.g-2 > [class*="col"] { padding-right: 6px; padding-left: 6px; }

/* Inspector Tab Pills */
.inspector-pills .nav-link {
  color: #64748b;
  font-size: 12px;
  border-radius: 6px;
  transition: all 0.2s ease;
}
.inspector-pills .nav-link:hover {
  color: #0095DA;
  background: #f1f5f9;
}
.inspector-pills .nav-link.active {
  background: #0095DA !important;
  color: #ffffff !important;
  box-shadow: 0 2px 4px rgba(0, 149, 218, 0.25);
}

.color-swatches-row {
  display: flex;
  flex-wrap: wrap;
  gap: 4px;
}
.color-swatch-dot {
  width: 18px;
  height: 18px;
  border-radius: 4px;
  padding: 0;
  cursor: pointer;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.color-swatch-dot:hover {
  transform: scale(1.25);
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
  z-index: 2;
}

.inspector-body::-webkit-scrollbar {
  width: 5px;
}
.inspector-body::-webkit-scrollbar-track {
  background: #f8fafc;
}
.inspector-body::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}
.inspector-body::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>
