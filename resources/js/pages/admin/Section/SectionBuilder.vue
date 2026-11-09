<template>
  <div class="section-builder-page d-flex flex-column bg-light rounded-4 border">
    <!-- 1. Top Builder Navigation & Actions Bar (Collapsible Single Header) -->
    <header
      class="builder-top-bar bg-white border-bottom shadow-2xs d-flex flex-wrap align-items-center px-3 py-1"
      :class="{ 'topbar-collapsed': isTopbarCollapsed, 'justify-content-between': isTopbarCollapsed }"
      style="z-index: 1040;"
    >
      <!-- ======================================================== -->
      <!-- STATE A: COLLAPSED (Slim 38px Focused Workspace Mode)    -->
      <!-- ======================================================== -->
      <template v-if="isTopbarCollapsed">
        <div class="d-flex align-items-center">
          <router-link
            :to="{ name: 'Section' }"
            class="btn btn-xs btn-light border mr-2 p-1"
            title="Back to Sections List"
          >
            <i class="fas fa-arrow-left"></i>
          </router-link>

          <span class="font-weight-bold text-dark small mr-2" style="font-size: 0.85rem;">
            {{ form.title || 'Untitled Section' }}
          </span>

          <code class="small text-muted bg-light border px-2 py-0 rounded d-none d-md-inline" style="font-size: 0.72rem;">
            {{ form.name || 'new_section' }}
          </code>
        </div>

        <div class="d-flex align-items-center">
          <!-- Device Switcher (Flat buttons) -->
          <button
            type="button"
            class="btn btn-xs mr-1"
            :class="deviceMode === 'desktop' ? 'btn-primary' : 'btn-light border'"
            @click="deviceMode = 'desktop'"
            title="Desktop View"
          >
            <i class="fas fa-desktop"></i>
          </button>
          <button
            type="button"
            class="btn btn-xs mr-1"
            :class="deviceMode === 'tablet' ? 'btn-primary' : 'btn-light border'"
            @click="deviceMode = 'tablet'"
            title="Tablet View"
          >
            <i class="fas fa-tablet-alt"></i>
          </button>
          <button
            type="button"
            class="btn btn-xs mr-3"
            :class="deviceMode === 'mobile' ? 'btn-primary' : 'btn-light border'"
            @click="deviceMode = 'mobile'"
            title="Mobile View"
          >
            <i class="fas fa-mobile-alt"></i>
          </button>

          <!-- Add Block (Just Icon) -->
          <button
            type="button"
            class="btn btn-xs btn-primary mr-1"
            @click="openInserter(null)"
            title="Add Block"
          >
            <i class="fas fa-plus"></i>
          </button>

          <!-- Save Section (Just Icon) -->
          <button
            type="button"
            class="btn btn-xs btn-success mr-2"
            @click="saveSection"
            :disabled="saving"
            title="Save Section (Ctrl+S)"
          >
            <i class="fas fa-save"></i>
          </button>

          <!-- Expand Toolbar Button -->
          <button
            type="button"
            class="btn btn-xs btn-light border text-muted"
            @click="toggleTopbar"
            title="Expand Full Toolbar (Ctrl+B)"
          >
            <i class="fas fa-chevron-down"></i>
          </button>
        </div>
      </template>

      <!-- ======================================================== -->
      <!-- STATE B: EXPANDED (Full Standard Toolbar)                -->
      <!-- ======================================================== -->
      <template v-else>
        <!-- Back & Section Identity -->
        <router-link
          :to="{ name: 'Section' }"
          class="btn btn-sm btn-light border text-dark"
          title="Back to Sections List"
        >
          <i class="fas fa-arrow-left"></i>
        </router-link>

        <input
          v-model="form.title"
          type="text"
          class="form-control form-control-sm font-weight-bold text-dark border-0 bg-light px-2 section-title-input"
          placeholder="Section Title"
          style="width: 170px; height: 32px; font-size: 0.88rem;"
          title="Click to rename section"
        />
        <code class="small text-muted bg-light border px-2 py-1 rounded d-none d-xxl-inline-block">{{ form.name || 'new_section' }}</code>

        <!-- Device buttons -->
        <button
          type="button"
          class="btn btn-sm"
          :class="deviceMode === 'desktop' ? 'btn-primary' : 'btn-light border'"
          @click="deviceMode = 'desktop'"
          title="Desktop View (1200px)"
        >
          <i class="fas fa-desktop"></i>
        </button>
        <button
          type="button"
          class="btn btn-sm"
          :class="deviceMode === 'tablet' ? 'btn-primary' : 'btn-light border'"
          @click="deviceMode = 'tablet'"
          title="Tablet View (768px)"
        >
          <i class="fas fa-tablet-alt"></i>
        </button>
        <button
          type="button"
          class="btn btn-sm"
          :class="deviceMode === 'mobile' ? 'btn-primary' : 'btn-light border'"
          @click="deviceMode = 'mobile'"
          title="Mobile View (375px)"
        >
          <i class="fas fa-mobile-alt"></i>
        </button>

        <!-- History -->
        <button
          type="button"
          class="btn btn-sm btn-light border"
          :class="{ 'opacity-50': !canUndo }"
          :disabled="!canUndo"
          @click="undo"
          title="Undo (Ctrl+Z)"
        >
          <i class="fas fa-undo"></i>
        </button>
        <button
          type="button"
          class="btn btn-sm btn-light border"
          :class="{ 'opacity-50': !canRedo }"
          :disabled="!canRedo"
          @click="redo"
          title="Redo (Ctrl+Y or Ctrl+Shift+Z)"
        >
          <i class="fas fa-redo"></i>
        </button>

        <!-- Preview & Storefront -->
        <button
          type="button"
          class="btn btn-sm"
          :class="isPreviewMode ? 'btn-warning font-weight-bold' : 'btn-light border'"
          @click="isPreviewMode = !isPreviewMode"
          :title="isPreviewMode ? 'Return to Edit mode' : 'Preview without handles'"
        >
          <i :class="isPreviewMode ? 'fas fa-edit mr-1' : 'fas fa-eye mr-1'"></i>
          {{ isPreviewMode ? 'Edit' : 'Preview' }}
        </button>
        <button
          type="button"
          class="btn btn-sm btn-light border text-primary font-weight-bold"
          @click="showStorefrontPreview = true"
          title="Open Realistic Storefront Live Simulation"
        >
          <i class="fas fa-external-link-alt mr-1"></i> Storefront
        </button>

        <!-- Toggle Layers Navigator Button -->
        <button
          type="button"
          class="btn btn-sm border font-weight-bold"
          style="height: 32px;"
          :class="showLayersDrawer ? 'btn-primary' : 'btn-light text-dark'"
          @click="toggleLayersDrawer"
          title="Toggle Layers Tree"
        >
          <i class="fas fa-sitemap mr-1"></i> Layers
          <span v-if="form.blocks && form.blocks.length" class="badge badge-light border ml-1 text-primary" style="font-size: 0.65rem;">
            {{ form.blocks.length }}
          </span>
        </button>

        <!-- Templates Button -->
        <button
          type="button"
          class="btn btn-sm btn-light border font-weight-bold text-dark"
          style="height: 32px;"
          @click="showTemplateModal = true"
          title="Browse Section Templates"
        >
          <i class="fas fa-layer-group text-primary mr-1"></i> Templates
        </button>

        <!-- Section Config Gear Icon -->
        <button
          type="button"
          class="btn btn-sm btn-light border text-dark"
          style="height: 32px; width: 32px; padding: 0;"
          @click="showGlobalSettingsModal = true"
          title="Section Background, Padding & Spacing Config"
        >
          <i class="fas fa-cog"></i>
        </button>

        <!-- Shortcuts Keyboard Icon -->
        <button
          type="button"
          class="btn btn-sm btn-light border text-dark"
          style="height: 32px; width: 32px; padding: 0;"
          @click="showShortcutsModal = true"
          title="Keyboard Shortcuts (?)"
        >
          <i class="fas fa-keyboard"></i>
        </button>

        <!-- Export Section JSON Button -->
        <button
          type="button"
          class="btn btn-sm btn-light border text-dark"
          style="height: 32px; width: 32px; padding: 0;"
          @click="exportSectionJson"
          title="Export Section to JSON File"
        >
          <i class="fas fa-file-export text-secondary"></i>
        </button>

        <!-- Import Section JSON Button (Hidden input) -->
        <input
          ref="importFileInput"
          type="file"
          accept=".json,application/json"
          class="d-none"
          @change="handleImportJsonFile"
        />
        <button
          type="button"
          class="btn btn-sm btn-light border text-dark"
          style="height: 32px; width: 32px; padding: 0;"
          @click="triggerImportJson"
          title="Import Section from JSON File"
        >
          <i class="fas fa-file-import text-secondary"></i>
        </button>

        <!-- Add Block (JUST ICON) -->
        <button
          type="button"
          class="btn btn-sm btn-primary"
          style="height: 32px; width: 34px; padding: 0;"
          @click="openInserter(null)"
          title="Add Block to Section"
        >
          <i class="fas fa-plus"></i>
        </button>

        <!-- Save Section (JUST ICON) -->
        <button
          type="button"
          class="btn btn-sm btn-success"
          style="height: 32px; width: 34px; padding: 0;"
          @click="saveSection"
          :disabled="saving"
          title="Save Section (Ctrl+S)"
        >
          <i class="fas fa-save"></i>
        </button>

        <!-- Collapse Top Bar Toggle -->
        <button
          type="button"
          class="btn btn-sm btn-light border text-muted"
          style="height: 32px; width: 30px; padding: 0;"
          @click="toggleTopbar"
          title="Collapse Toolbar (Ctrl+B)"
        >
          <i class="fas fa-chevron-up"></i>
        </button>
      </template>
    </header>

    <!-- 2. Main Builder Workspace Layout -->
    <div class="builder-workspace d-flex flex-grow-1 overflow-hidden position-relative">
      <!-- Floating Panel 1: Document Layers (Photoshop Floating Style) -->
      <transition name="fade-scale">
        <div
          v-if="showLayersDrawer"
          id="floating-panel-layers"
          class="floating-builder-panel floating-layers-panel shadow-lg border rounded-3 overflow-hidden"
          :class="{ 'panel-minimized': isLayersMinimized }"
          :style="{
            top: `${layersPos.y}px`,
            left: `${layersPos.x}px`,
            zIndex: layersZIndex
          }"
          @mousedown="bringToFront('layers')"
        >
          <!-- Floating Window Header (Drag Handle) -->
          <div
            class="floating-panel-header px-3 py-2 bg-dark text-white d-flex align-items-center justify-content-between"
            @mousedown="startDragPanel($event, 'layers')"
            @dblclick="isLayersMinimized = !isLayersMinimized"
            title="Drag to reposition • Double-click to minimize"
          >
            <div class="d-flex align-items-center text-truncate mr-2 user-select-none">
              <i class="fas fa-grip-vertical text-muted mr-2 drag-indicator"></i>
              <i class="fas fa-sitemap text-info mr-2"></i>
              <strong class="small font-weight-bold">Layers</strong>
              <span v-if="form.blocks && form.blocks.length" class="badge badge-secondary ml-2 font-weight-normal" style="font-size: 0.65rem;">
                {{ form.blocks.length }}
              </span>
            </div>
            <div class="d-flex align-items-center">
              <button
                type="button"
                class="btn btn-xs btn-outline-light border-0 text-white-50 p-1 mr-1 window-ctrl-btn"
                @click.stop="isLayersMinimized = !isLayersMinimized"
                :title="isLayersMinimized ? 'Expand Window' : 'Minimize Window'"
              >
                <i :class="isLayersMinimized ? 'fas fa-chevron-down' : 'fas fa-minus'" style="font-size: 0.7rem;"></i>
              </button>
              <button
                type="button"
                class="btn btn-xs btn-outline-light border-0 text-white-50 p-1 window-ctrl-btn"
                @click.stop="showLayersDrawer = false"
                title="Close Layers Panel"
              >
                <i class="fas fa-times" style="font-size: 0.75rem;"></i>
              </button>
            </div>
          </div>

          <!-- Floating Window Body -->
          <div v-show="!isLayersMinimized" class="floating-panel-body flex-grow-1 overflow-hidden d-flex flex-column">
            <DocumentTreeNavigator
              :blocks="form.blocks"
              :selected-id="selectedBlockId"
              :hide-header="true"
              @select="selectBlock"
              @close="showLayersDrawer = false"
              @duplicate="duplicateBlockById"
              @delete="deleteBlockById"
              @add-to-col="openInserterForColumn"
              @delete-sub="deleteSubBlock"
              @reorder="recordSnapshot"
            />
          </div>
        </div>
      </transition>

      <!-- Center Canvas Area -->
      <div
        class="builder-canvas-viewport flex-grow-1 bg-canvas d-flex justify-content-center"
        :class="{ 'viewport-device-mode': deviceMode !== 'desktop' }"
      >
        <div
          class="canvas-frame transition-all shadow-sm rounded-4 position-relative overflow-hidden"
          :class="[canvasFrameClass, { 'canvas-transparent-bg': form.is_transparent_bg }]"
          :style="sectionWrapperStyles"
        >
          <!-- Optional Section Background Overlay Preview -->
          <div
            v-if="form.enable_overlay && form.background_image"
            class="position-absolute"
            :style="{
              inset: 0,
              backgroundColor: form.overlay_color || '#000000',
              opacity: form.overlay_opacity || 0.5,
              pointerEvents: 'none',
              zIndex: 1
            }"
          ></div>

          <!-- Device Mockup Header for Mobile / Tablet -->
          <div v-if="deviceMode !== 'desktop'" class="device-bezel-header bg-dark text-white text-center py-1 small px-3 d-flex justify-content-between align-items-center" style="position: relative; z-index: 10;">
            <span class="small opacity-75 font-weight-bold">
              <i :class="deviceMode === 'mobile' ? 'fas fa-mobile-alt' : 'fas fa-tablet-alt'"></i>
              {{ deviceMode.toUpperCase() }} VIEW
            </span>
            <span class="badge badge-light px-2">{{ deviceMode === 'mobile' ? '375px' : '768px' }}</span>
          </div>

          <!-- Section Global Header Display (Optional) -->
          <div
            v-if="form.badge || form.header_title || form.subtitle"
            class="pt-4 px-4 pb-2 position-relative"
            :class="form.header_align || 'text-center'"
            style="z-index: 2;"
          >
            <!-- Badge -->
            <div v-if="form.badge" class="mb-2">
              <span
                v-if="form.header_badge_style === 'pill'"
                class="badge badge-primary rounded-pill px-3 py-1 font-weight-bold"
                style="letter-spacing: 1px; font-size: 0.75rem;"
              >
                {{ form.badge }}
              </span>
              <span
                v-else-if="form.header_badge_style === 'soft'"
                class="badge badge-light border text-primary px-3 py-1 font-weight-bold"
                style="letter-spacing: 1px; font-size: 0.75rem;"
              >
                {{ form.badge }}
              </span>
              <span
                v-else-if="form.header_badge_style === 'outline'"
                class="badge border border-primary text-primary px-3 py-1 font-weight-bold"
                style="letter-spacing: 1px; font-size: 0.75rem;"
              >
                {{ form.badge }}
              </span>
              <span
                v-else
                class="text-uppercase text-primary small font-weight-bold"
                style="letter-spacing: 1.5px; font-size: 0.75rem;"
              >
                {{ form.badge }}
              </span>
            </div>

            <!-- Title -->
            <component
              :is="form.header_title_tag || 'h2'"
              v-if="form.header_title"
              class="font-weight-bold mb-2 title-2"
              :style="{
                letterSpacing: '-0.5px',
                color: form.header_title_color || 'inherit'
              }"
            >
              {{ form.header_title }}
            </component>

            <!-- Subtitle -->
            <p
              v-if="form.subtitle"
              class="text-secondary small mb-0"
              :class="{ 'mx-auto': (form.header_align || 'text-center') === 'text-center' }"
              style="max-width: 650px;"
            >
              {{ form.subtitle }}
            </p>
          </div>

          <!-- Draggable Block List -->
          <div class="p-4 position-relative" style="z-index: 2;">
            <!-- Top In-Canvas Inserter (Before First Block) -->
            <div v-if="!isPreviewMode && form.blocks && form.blocks.length > 0" class="canvas-add-between-line mb-3">
              <button
                type="button"
                class="btn btn-xs btn-primary rounded-circle shadow-sm add-between-btn"
                @click="openInserterAtIndex(0)"
                title="Insert block at top"
              >
                <i class="fas fa-plus"></i>
              </button>
            </div>

            <draggable
              v-model="form.blocks"
              item-key="id"
              handle=".drag-main-handle"
              :animation="200"
              ghost-class="ghost-main-block"
              class="blocks-main-canvas"
            >
              <template #item="{ element: block, index }">
                <div class="block-wrapper-with-divider position-relative">
                  <div
                    class="builder-block-card position-relative mb-2 rounded-3"
                    :class="{
                      'block-selected': selectedBlockId === block.id && !isPreviewMode,
                      'block-preview': isPreviewMode
                    }"
                    @click.stop="selectBlock(block)"
                    @contextmenu.prevent.stop="openContextMenu($event, block, index)"
                  >
                    <!-- Floating Action Toolbar (Visible on Hover in Edit Mode) -->
                    <div v-if="!isPreviewMode" class="block-floating-tools d-flex align-items-center bg-dark text-white rounded-pill px-2 py-1 shadow-sm">
                      <i class="fas fa-grip-vertical drag-main-handle mr-2 text-white-50" style="cursor: grab;" title="Drag to reorder"></i>
                      <span class="badge badge-primary text-uppercase mr-2 font-weight-bold" style="font-size: 0.65rem;">
                        {{ block.type }}
                      </span>
                      <button type="button" class="btn btn-xs text-white p-1" @click.stop="moveBlock(index, -1)" :disabled="index === 0" title="Move Up">
                        <i class="fas fa-chevron-up"></i>
                      </button>
                      <button type="button" class="btn btn-xs text-white p-1" @click.stop="moveBlock(index, 1)" :disabled="index === form.blocks.length - 1" title="Move Down">
                        <i class="fas fa-chevron-down"></i>
                      </button>
                      <button type="button" class="btn btn-xs text-white p-1 ml-1" @click.stop="duplicateBlock(index)" title="Duplicate Block (Ctrl+D)">
                        <i class="fas fa-copy"></i>
                      </button>
                      <button type="button" class="btn btn-xs text-white p-1 ml-1" @click.stop="copyBlockStyles(block)" title="Copy Styles">
                        <i class="fas fa-paint-roller"></i>
                      </button>
                      <button type="button" class="btn btn-xs text-danger p-1 ml-1" @click.stop="deleteBlock(index)" title="Delete Block">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </div>

                    <!-- Actual Block Component Rendering -->
                    <div class="block-content-wrap p-2">
                      <component
                        :is="resolveBlockComponent(block.type)"
                        :block="block"
                        :device-mode="deviceMode"
                        :is-preview-mode="isPreviewMode"
                        :selected-id="selectedBlockId"
                        @add-to-col="openInserterForColumn"
                        @select-sub-block="selectBlock"
                        @update="recordSnapshot"
                      />
                    </div>
                  </div>

                  <!-- Hover In-Canvas Quick Add Inserter Between Blocks -->
                  <div v-if="!isPreviewMode" class="canvas-add-between-line my-3">
                    <button
                      type="button"
                      class="btn btn-xs btn-primary rounded-circle shadow-sm add-between-btn"
                      @click="openInserterAtIndex(index + 1)"
                      title="Insert block here"
                    >
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
              </template>
            </draggable>

            <!-- Empty Canvas Call to Action -->
            <div v-if="!form.blocks || form.blocks.length === 0" class="text-center py-5 border-2 border-dashed rounded-4 bg-light my-4">
              <i class="fas fa-cubes fa-3x mb-3 text-primary opacity-50"></i>
              <h5 class="font-weight-bold text-dark">Your Section is Empty</h5>
              <p class="text-muted small mb-3">Add headings, multi-column layouts, images, and feature cards, or start from a pre-designed template.</p>
              <div class="d-flex flex-wrap gap-1 align-items-center justify-content-center">
                <button type="button" class="btn btn-primary font-weight-bold shadow-sm px-4 mr-2" @click="showTemplateModal = true">
                  <i class="fas fa-layer-group mr-1"></i> Browse Pre-built Templates
                </button>
                <button type="button" class="btn btn-outline-secondary font-weight-bold shadow-sm px-4" @click="openInserter(null)">
                  <i class="fas fa-plus mr-1"></i> Add Custom Block
                </button>
              </div>
            </div>

            <!-- In-Canvas Quick Add Button at the bottom -->
            <div v-if="form.blocks && form.blocks.length > 0 && !isPreviewMode" class="text-center my-3">
              <button
                type="button"
                class="btn btn-sm btn-outline-primary rounded-pill px-3 font-weight-bold shadow-2xs"
                @click="openInserter(null)"
              >
                <i class="fas fa-plus mr-1"></i> Insert Next Block
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Floating Panel 2: Block Inspector (Photoshop Floating Style) -->
      <transition name="fade-scale">
        <div
          v-if="selectedBlock && showInspector"
          id="floating-panel-inspector"
          class="floating-builder-panel floating-inspector-panel shadow-lg border rounded-3 overflow-hidden"
          :class="{ 'panel-minimized': isInspectorMinimized }"
          :style="{
            top: `${inspectorPos.y}px`,
            left: inspectorPos.x !== null ? `${inspectorPos.x}px` : 'auto',
            right: inspectorPos.x === null ? '20px' : 'auto',
            zIndex: inspectorZIndex
          }"
          @mousedown="bringToFront('inspector')"
        >
          <!-- Floating Window Header (Drag Handle) -->
          <div
            class="floating-panel-header px-3 py-2 bg-dark text-white d-flex align-items-center justify-content-between"
            @mousedown="startDragPanel($event, 'inspector')"
            @dblclick="isInspectorMinimized = !isInspectorMinimized"
            title="Drag to reposition • Double-click to minimize"
          >
            <div class="d-flex align-items-center text-truncate mr-2 user-select-none">
              <i class="fas fa-grip-vertical text-muted mr-2 drag-indicator"></i>
              <span class="badge badge-primary text-uppercase font-weight-bold px-1 py-0 mr-2" style="font-size: 0.65rem;">
                {{ selectedBlock?.type || 'Block' }}
              </span>
              <strong class="small font-weight-bold">Block Settings</strong>
            </div>
            <div class="d-flex align-items-center">
              <button
                type="button"
                class="btn btn-xs btn-outline-light border-0 text-white-50 p-1 mr-1 window-ctrl-btn"
                @click.stop="isInspectorMinimized = !isInspectorMinimized"
                :title="isInspectorMinimized ? 'Expand Window' : 'Minimize Window'"
              >
                <i :class="isInspectorMinimized ? 'fas fa-chevron-down' : 'fas fa-minus'" style="font-size: 0.7rem;"></i>
              </button>
              <button
                type="button"
                class="btn btn-xs btn-outline-light border-0 text-white-50 p-1 window-ctrl-btn"
                @click.stop="selectedBlockId = null"
                title="Close Block Settings (Esc)"
              >
                <i class="fas fa-times" style="font-size: 0.75rem;"></i>
              </button>
            </div>
          </div>

          <!-- Floating Window Body -->
          <div v-show="!isInspectorMinimized" class="floating-panel-body flex-grow-1 overflow-hidden d-flex flex-column">
            <BlockInspector
              :selected-block="selectedBlock"
              :hide-header="true"
              @close="selectedBlockId = null"
            />
          </div>
        </div>
      </transition>
    </div>

    <!-- 3. Block Inserter Modal -->
    <BlockInserterModal
      :show="showInserterModal"
      @close="showInserterModal = false"
      @select="handleBlockSelect"
    />

    <!-- 4. Global Section Settings Modal -->
    <div v-if="showGlobalSettingsModal" class="modal fade show d-block" tabindex="-1" style="background: rgba(15, 23, 42, 0.65); z-index: 1060;">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
          <div class="modal-header bg-white px-4 py-3 border-bottom d-flex align-items-center justify-content-between">
            <h5 class="modal-title font-weight-bold mb-0 text-dark">
              <i class="fas fa-sliders-h mr-2 text-primary"></i> Section Configuration
            </h5>
            <button type="button" class="close text-muted" @click="showGlobalSettingsModal = false">
              <span>&times;</span>
            </button>
          </div>

          <!-- Configuration Tabs Navigation -->
          <div class="bg-white px-4 pt-2 border-bottom">
            <ul class="nav nav-tabs border-0 config-modal-tabs">
              <li class="nav-item">
                <a
                  class="nav-link font-weight-bold"
                  :class="{ active: activeConfigTab === 'header' }"
                  href="#"
                  @click.prevent="activeConfigTab = 'header'"
                >
                  <i class="fas fa-heading mr-1"></i> Header & Text
                </a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link font-weight-bold"
                  :class="{ active: activeConfigTab === 'background' }"
                  href="#"
                  @click.prevent="activeConfigTab = 'background'"
                >
                  <i class="fas fa-palette mr-1"></i> Background & Overlay
                </a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link font-weight-bold"
                  :class="{ active: activeConfigTab === 'spacing' }"
                  href="#"
                  @click.prevent="activeConfigTab = 'spacing'"
                >
                  <i class="fas fa-arrows-alt-v mr-1"></i> Spacing & Padding
                </a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link font-weight-bold"
                  :class="{ active: activeConfigTab === 'advanced' }"
                  href="#"
                  @click.prevent="activeConfigTab = 'advanced'"
                >
                  <i class="fas fa-cog mr-1"></i> Layout & Advanced
                </a>
              </li>
            </ul>
          </div>

          <div class="modal-body p-4 bg-light" style="max-height: calc(85vh - 160px); overflow-y: auto;">
            <!-- TAB 1: HEADER & CONTENT -->
            <div v-show="activeConfigTab === 'header'">
              <div class="card border-0 shadow-2xs rounded-3 p-3 mb-3 bg-white">
                <h6 class="font-weight-bold text-dark mb-3"><i class="fas fa-heading mr-1 text-primary"></i> Main Section Heading</h6>
                
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <label class="small font-weight-bold text-dark">Header Title</label>
                      <input v-model="form.header_title" type="text" class="form-control form-control-sm" placeholder="e.g. Revolutionary Clean Air" />
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="small font-weight-bold text-dark">HTML Tag</label>
                      <select v-model="form.header_title_tag" class="form-control form-control-sm">
                        <option value="h1">H1 (Hero Page Main)</option>
                        <option value="h2">H2 (Standard Section)</option>
                        <option value="h3">H3 (Sub Section)</option>
                        <option value="h4">H4 (Small)</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="small font-weight-bold text-dark">Header Title Color (Optional)</label>
                  <div class="input-group input-group-sm" style="max-width: 280px;">
                    <input v-model="form.header_title_color" type="color" class="form-control form-control-color p-0 border-0" style="max-width: 40px;" />
                    <input v-model="form.header_title_color" type="text" class="form-control form-control-sm" placeholder="#ffffff or leave blank" />
                    <div class="input-group-append">
                      <button type="button" class="btn btn-outline-secondary" @click="form.header_title_color = '#ffffff'">White</button>
                      <button type="button" class="btn btn-outline-secondary" @click="form.header_title_color = '#1e293b'">Dark</button>
                    </div>
                  </div>
                  <small class="text-muted">Use white (#ffffff) if section has a dark background.</small>
                </div>

                <div class="form-group mb-0">
                  <label class="small font-weight-bold text-dark">Header Subtitle / Description</label>
                  <textarea v-model="form.subtitle" class="form-control form-control-sm" rows="2" placeholder="Brief supporting description under the heading..."></textarea>
                </div>
              </div>

              <div class="card border-0 shadow-2xs rounded-3 p-3 bg-white">
                <h6 class="font-weight-bold text-dark mb-3"><i class="fas fa-tag mr-1 text-primary"></i> Badge & Alignment</h6>

                <div class="row">
                  <div class="col-md-7">
                    <div class="form-group">
                      <label class="small font-weight-bold text-dark">Header Badge Text</label>
                      <input v-model="form.badge" type="text" class="form-control form-control-sm" placeholder="e.g. TECHNOLOGY or INNOVATION" />
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <label class="small font-weight-bold text-dark">Badge Style</label>
                      <select v-model="form.header_badge_style" class="form-control form-control-sm">
                        <option value="text">Text Only (Uppercase Kicker)</option>
                        <option value="pill">Rounded Pill (Solid Primary)</option>
                        <option value="soft">Soft Tint (Light Box)</option>
                        <option value="outline">Outline Border</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group mb-0">
                  <label class="small font-weight-bold text-dark">Header Text Alignment</label>
                  <div class="btn-group btn-group-sm w-100">
                    <button
                      type="button"
                      class="btn"
                      :class="(form.header_align || 'text-center') === 'text-start' ? 'btn-primary' : 'btn-outline-secondary'"
                      @click="form.header_align = 'text-start'"
                    >
                      <i class="fas fa-align-left mr-1"></i> Left Aligned
                    </button>
                    <button
                      type="button"
                      class="btn"
                      :class="(form.header_align || 'text-center') === 'text-center' ? 'btn-primary' : 'btn-outline-secondary'"
                      @click="form.header_align = 'text-center'"
                    >
                      <i class="fas fa-align-center mr-1"></i> Center Aligned
                    </button>
                    <button
                      type="button"
                      class="btn"
                      :class="(form.header_align || 'text-center') === 'text-end' ? 'btn-primary' : 'btn-outline-secondary'"
                      @click="form.header_align = 'text-end'"
                    >
                      <i class="fas fa-align-right mr-1"></i> Right Aligned
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- TAB 2: BACKGROUND & OVERLAY -->
            <div v-show="activeConfigTab === 'background'">
              <div class="card border-0 shadow-2xs rounded-3 p-3 mb-3 bg-white">
                <h6 class="font-weight-bold text-dark mb-3"><i class="fas fa-fill-drip mr-1 text-primary"></i> Background Color & Transparency</h6>

                <div class="form-group mb-2">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small font-weight-bold text-dark">Color Mode:</span>
                    <div class="custom-control custom-switch">
                      <input
                        type="checkbox"
                        v-model="form.is_transparent_bg"
                        class="custom-control-input"
                        id="transparentBgSwitch"
                        @change="onTransparentToggle"
                      />
                      <label class="custom-control-label small font-weight-bold text-primary" for="transparentBgSwitch" style="cursor: pointer;">
                        Transparent Background
                      </label>
                    </div>
                  </div>

                  <div v-if="!form.is_transparent_bg" class="input-group input-group-sm">
                    <input v-model="form.background_color" type="color" class="form-control form-control-color p-0 border-0" style="max-width: 40px;" />
                    <input v-model="form.background_color" type="text" class="form-control form-control-sm" placeholder="#ffffff" />
                    <div class="input-group-append">
                      <button type="button" class="btn btn-outline-secondary" @click="form.background_color = '#ffffff'">White</button>
                      <button type="button" class="btn btn-outline-secondary" @click="form.background_color = '#f8fafc'">Slate</button>
                      <button type="button" class="btn btn-outline-secondary" @click="form.background_color = '#0d1b2a'; form.header_title_color = '#ffffff'">Navy</button>
                      <button type="button" class="btn btn-outline-secondary" @click="form.background_color = '#111827'; form.header_title_color = '#ffffff'">Dark</button>
                    </div>
                  </div>
                  <div v-else class="p-3 border rounded bg-light text-muted small d-flex align-items-center">
                    <i class="fas fa-check-circle text-success mr-2 fa-lg"></i>
                    <div>
                      <span class="font-weight-bold text-dark d-block">Transparent Background Active</span>
                      This section will blend seamlessly with whatever background color or image is on the page.
                    </div>
                  </div>
                </div>
              </div>

              <div class="card border-0 shadow-2xs rounded-3 p-3 bg-white">
                <h6 class="font-weight-bold text-dark mb-3"><i class="fas fa-image mr-1 text-primary"></i> Background Image & Overlay</h6>

                <div class="form-group">
                  <label class="small font-weight-bold text-dark">Background Image URL</label>
                  
                  <div v-if="form.background_image" class="mb-2 p-2 bg-light border rounded text-center position-relative shadow-2xs">
                    <img :src="getImageUrl(form.background_image)" style="max-height: 100px; object-fit: cover; width: 100%;" class="rounded mb-2" />
                    <button type="button" class="btn btn-xs btn-outline-danger" @click="form.background_image = ''">
                      <i class="fas fa-times mr-1"></i> Remove Image
                    </button>
                  </div>

                  <div class="input-group input-group-sm mb-1">
                    <input
                      v-model="form.background_image"
                      type="text"
                      class="form-control form-control-sm"
                      placeholder="storage/uploads/... or themes/default/assets/img/..."
                    />
                    <div class="input-group-append">
                      <button type="button" class="btn btn-outline-primary font-weight-bold" @click="showBgMediaModal = true">
                        <i class="fas fa-photo-video mr-1"></i> Media Library
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Background Overlay for Photographic Backgrounds -->
                <div v-if="form.background_image" class="p-3 bg-light rounded border mt-3">
                  <div class="custom-control custom-switch mb-2">
                    <input type="checkbox" v-model="form.enable_overlay" class="custom-control-input" id="enableOverlaySwitch" />
                    <label class="custom-control-label small font-weight-bold text-dark" for="enableOverlaySwitch">
                      Enable Background Dark/Color Tint Overlay
                    </label>
                  </div>

                  <div v-if="form.enable_overlay" class="row mt-2">
                    <div class="col-md-6">
                      <label class="small text-muted mb-1">Overlay Color</label>
                      <div class="input-group input-group-sm">
                        <input v-model="form.overlay_color" type="color" class="form-control form-control-color p-0 border-0" style="max-width: 40px;" />
                        <input v-model="form.overlay_color" type="text" class="form-control form-control-sm" placeholder="#000000" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="small text-muted mb-1">Opacity: {{ Math.round((form.overlay_opacity || 0.5) * 100) }}%</label>
                      <input
                        type="range"
                        v-model.number="form.overlay_opacity"
                        min="0.05"
                        max="0.95"
                        step="0.05"
                        class="form-control-range"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- TAB 3: SPACING & PADDING -->
            <div v-show="activeConfigTab === 'spacing'">
              <div class="card border-0 shadow-2xs rounded-3 p-3 mb-3 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-arrows-alt-v mr-1 text-primary"></i> Vertical Padding Mode</h6>
                  <div class="btn-group btn-group-sm">
                    <button
                      type="button"
                      class="btn font-weight-bold"
                      :class="form.padding_mode !== 'custom' ? 'btn-primary' : 'btn-light border'"
                      @click="form.padding_mode = 'preset'"
                    >
                      Preset Utility
                    </button>
                    <button
                      type="button"
                      class="btn font-weight-bold"
                      :class="form.padding_mode === 'custom' ? 'btn-primary' : 'btn-light border'"
                      @click="form.padding_mode = 'custom'"
                    >
                      Custom Pixels (px)
                    </button>
                  </div>
                </div>

                <!-- 1. PRESET MODE -->
                <div v-if="form.padding_mode !== 'custom'">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="small font-weight-bold text-dark">Desktop Padding</label>
                        <select v-model="form.padding_y.desktop" class="form-control form-control-sm">
                          <option value="py-0">None (0px)</option>
                          <option value="py-2">Extra Small (~16px / py-2)</option>
                          <option value="py-3">Small (~24px / py-3)</option>
                          <option value="py-4">Medium (~48px / py-4)</option>
                          <option value="py-5">Large (~64px / py-5)</option>
                          <option value="py-6">Extra Large (~80px / py-6)</option>
                          <option value="py-7">Spacious Hero (~100px / py-7)</option>
                          <option value="py-8">Massive (~128px / py-8)</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="small font-weight-bold text-dark">Mobile Padding</label>
                        <select v-model="form.padding_y.mobile" class="form-control form-control-sm">
                          <option value="py-0">None (0px)</option>
                          <option value="py-2">Compact (~16px / py-2)</option>
                          <option value="py-3">Normal (~24px / py-3)</option>
                          <option value="py-4">Medium (~36px / py-4)</option>
                          <option value="py-5">Large (~48px / py-5)</option>
                          <option value="py-6">Extra Large (~64px / py-6)</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <small class="text-muted d-block">
                    <i class="fas fa-info-circle mr-1"></i> Presets apply standard responsive classes (e.g. <code>{{ form.padding_y.mobile }} {{ form.padding_y.desktop.replace('py-', 'py-md-') }}</code>).
                  </small>
                </div>

                <!-- 2. CUSTOM PIXEL MODE -->
                <div v-else>
                  <div class="p-3 bg-light rounded border mb-3">
                    <h6 class="small font-weight-bold text-dark mb-2"><i class="fas fa-desktop mr-1 text-primary"></i> Desktop Padding (Exact px / rem)</h6>
                    <div class="row">
                      <div class="col-6">
                        <label class="small text-muted mb-1">Padding Top</label>
                        <input
                          v-model="form.custom_padding.pt_desktop"
                          type="text"
                          class="form-control form-control-sm"
                          placeholder="e.g. 100px"
                        />
                      </div>
                      <div class="col-6">
                        <label class="small text-muted mb-1">Padding Bottom</label>
                        <input
                          v-model="form.custom_padding.pb_desktop"
                          type="text"
                          class="form-control form-control-sm"
                          placeholder="e.g. 80px"
                        />
                      </div>
                    </div>
                  </div>

                  <div class="p-3 bg-light rounded border">
                    <h6 class="small font-weight-bold text-dark mb-2"><i class="fas fa-mobile-alt mr-1 text-primary"></i> Mobile Padding (Exact px / rem)</h6>
                    <div class="row">
                      <div class="col-6">
                        <label class="small text-muted mb-1">Padding Top</label>
                        <input
                          v-model="form.custom_padding.pt_mobile"
                          type="text"
                          class="form-control form-control-sm"
                          placeholder="e.g. 40px"
                        />
                      </div>
                      <div class="col-6">
                        <label class="small text-muted mb-1">Padding Bottom</label>
                        <input
                          v-model="form.custom_padding.pb_mobile"
                          type="text"
                          class="form-control form-control-sm"
                          placeholder="e.g. 30px"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- TAB 4: LAYOUT & ADVANCED -->
            <div v-show="activeConfigTab === 'advanced'">
              <div class="card border-0 shadow-2xs rounded-3 p-3 mb-3 bg-white">
                <h6 class="font-weight-bold text-dark mb-3"><i class="fas fa-columns mr-1 text-primary"></i> Width & Height Constraints</h6>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="small font-weight-bold text-dark">Container Width</label>
                      <select v-model="form.container_type" class="form-control form-control-sm">
                        <option value="container">Standard Container (1200px)</option>
                        <option value="container-fluid">Full Width Fluid (container-fluid)</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="small font-weight-bold text-dark">Minimum Height</label>
                      <select v-model="form.min_height" class="form-control form-control-sm">
                        <option value="">Auto (Fit Content)</option>
                        <option value="400px">Compact (400px)</option>
                        <option value="500px">Medium (500px)</option>
                        <option value="600px">Large (600px)</option>
                        <option value="750px">Extra Large (750px)</option>
                        <option value="100vh">Full Viewport Hero (100vh)</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card border-0 shadow-2xs rounded-3 p-3 bg-white">
                <h6 class="font-weight-bold text-dark mb-3"><i class="fas fa-code mr-1 text-primary"></i> Custom Attributes & Developer Options</h6>

                <div class="form-group">
                  <label class="small font-weight-bold text-dark">Section Identifier (Name Key)</label>
                  <input v-model="form.name" type="text" class="form-control form-control-sm" placeholder="e.g. home_technology_showcase" />
                  <small class="text-muted">Used in Laravel Blade templates: <code>@renderSection('{{ form.name }}')</code></small>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="small font-weight-bold text-dark">Custom HTML ID</label>
                      <input v-model="form.custom_id" type="text" class="form-control form-control-sm" placeholder="e.g. features-anchor" />
                      <small class="text-muted">For in-page smooth scroll navigation.</small>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="small font-weight-bold text-dark">Extra CSS Classes</label>
                      <input v-model="form.custom_class" type="text" class="form-control form-control-sm" placeholder="e.g. border-top shadow-sm" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer bg-white px-4 py-3 border-top d-flex align-items-center justify-content-between">
            <span class="small text-muted">All changes apply instantly to the live visual canvas preview.</span>
            <button type="button" class="btn btn-primary btn-sm px-4 font-weight-bold shadow-sm" @click="showGlobalSettingsModal = false">
              <i class="fas fa-check mr-1"></i> Apply & Close
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- 5. Background Media Library Modal -->
    <MediaLibraryModal
      :show="showBgMediaModal"
      :current-value="form.background_image"
      @close="showBgMediaModal = false"
      @select="onBgMediaSelect"
    />

    <!-- 6. Pre-built Section Template Library Modal -->
    <TemplateLibraryModal
      :show="showTemplateModal"
      @close="showTemplateModal = false"
      @select="handleTemplateSelect"
    />

    <!-- 7. Keyboard Shortcuts Help Modal -->
    <div v-if="showShortcutsModal" class="modal fade show d-block" tabindex="-1" style="background: rgba(15, 23, 42, 0.65); z-index: 1070;" @click.self="showShortcutsModal = false">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
          <div class="modal-header bg-white px-4 py-3 border-bottom d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
              <i class="fas fa-keyboard text-primary mr-2" style="font-size: 1.25rem;"></i>
              <h5 class="modal-title font-weight-bold mb-0 text-dark">Keyboard Shortcuts</h5>
            </div>
            <button type="button" class="close text-muted" @click="showShortcutsModal = false" style="outline: none;">
              <span>&times;</span>
            </button>
          </div>

          <div class="modal-body p-3 bg-light">
            <div class="list-group list-group-flush rounded-3 border bg-white overflow-hidden shadow-2xs">
              <div class="list-group-item d-flex align-items-center justify-content-between py-2 px-3">
                <span class="text-dark font-weight-bold small">Undo Last Action</span>
                <div>
                  <kbd class="bg-dark text-white px-2 py-1 rounded small">Ctrl</kbd> + <kbd class="bg-dark text-white px-2 py-1 rounded small">Z</kbd>
                </div>
              </div>

              <div class="list-group-item d-flex align-items-center justify-content-between py-2 px-3">
                <span class="text-dark font-weight-bold small">Redo Action</span>
                <div>
                  <kbd class="bg-dark text-white px-2 py-1 rounded small">Ctrl</kbd> + <kbd class="bg-dark text-white px-2 py-1 rounded small">Y</kbd>
                  <span class="text-muted mx-1">or</span>
                  <kbd class="bg-dark text-white px-2 py-1 rounded small">Ctrl</kbd> + <kbd class="bg-dark text-white px-2 py-1 rounded small">Shift</kbd> + <kbd class="bg-dark text-white px-2 py-1 rounded small">Z</kbd>
                </div>
              </div>

              <div class="list-group-item d-flex align-items-center justify-content-between py-2 px-3">
                <span class="text-dark font-weight-bold small">Save Section</span>
                <div>
                  <kbd class="bg-dark text-white px-2 py-1 rounded small">Ctrl</kbd> + <kbd class="bg-dark text-white px-2 py-1 rounded small">S</kbd>
                </div>
              </div>

              <div class="list-group-item d-flex align-items-center justify-content-between py-2 px-3">
                <span class="text-dark font-weight-bold small">Duplicate Selected Block</span>
                <div>
                  <kbd class="bg-dark text-white px-2 py-1 rounded small">Ctrl</kbd> + <kbd class="bg-dark text-white px-2 py-1 rounded small">D</kbd>
                </div>
              </div>

              <div class="list-group-item d-flex align-items-center justify-content-between py-2 px-3">
                <span class="text-dark font-weight-bold small">Delete Selected Block</span>
                <div>
                  <kbd class="bg-dark text-white px-2 py-1 rounded small">Delete</kbd>
                  <span class="text-muted mx-1">or</span>
                  <kbd class="bg-dark text-white px-2 py-1 rounded small">Backspace</kbd>
                </div>
              </div>

              <div class="list-group-item d-flex align-items-center justify-content-between py-2 px-3">
                <span class="text-dark font-weight-bold small">Deselect / Close Modals</span>
                <div>
                  <kbd class="bg-dark text-white px-2 py-1 rounded small">Esc</kbd>
                </div>
              </div>

              <div class="list-group-item d-flex align-items-center justify-content-between py-2 px-3">
                <span class="text-dark font-weight-bold small">Collapse / Expand Top Bar</span>
                <div>
                  <kbd class="bg-dark text-white px-2 py-1 rounded small">Ctrl</kbd> + <kbd class="bg-dark text-white px-2 py-1 rounded small">B</kbd>
                </div>
              </div>

              <div class="list-group-item d-flex align-items-center justify-content-between py-2 px-3">
                <span class="text-dark font-weight-bold small">Show Keyboard Shortcuts</span>
                <div>
                  <kbd class="bg-dark text-white px-2 py-1 rounded small">?</kbd>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer bg-white px-4 py-2 border-top text-right">
            <button type="button" class="btn btn-sm btn-primary px-4 font-weight-bold shadow-sm" @click="showShortcutsModal = false">
              Got It
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- 5. Save as Custom Template Modal -->
    <div v-if="showSaveTemplateModal" class="modal fade show d-block" tabindex="-1" style="background: rgba(15, 23, 42, 0.65); z-index: 1060;">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
          <div class="modal-header bg-white px-4 py-3 border-bottom d-flex align-items-center justify-content-between">
            <h5 class="modal-title font-weight-bold mb-0 text-dark">
              <i class="fas fa-bookmark text-primary mr-2"></i> Save Layout as Template
            </h5>
            <button type="button" class="close text-muted" @click="showSaveTemplateModal = false">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body p-4 bg-light">
            <div class="form-group mb-3">
              <label class="small font-weight-bold text-dark mb-1">Template Name <span class="text-danger">*</span></label>
              <input
                v-model="saveTemplateForm.name"
                type="text"
                class="form-control"
                placeholder="e.g. Modern Dual Column Showcase"
                required
              />
            </div>
            <div class="form-group mb-0">
              <label class="small font-weight-bold text-dark mb-1">Brief Description</label>
              <textarea
                v-model="saveTemplateForm.description"
                rows="3"
                class="form-control"
                placeholder="Describe this section layout for future reuse..."
              ></textarea>
            </div>
            <div class="alert alert-info mt-3 py-2 px-3 small mb-0 border-0">
              <i class="fas fa-info-circle mr-1"></i> This layout will be saved under <strong>"My Templates"</strong> in your template library for one-click re-use across sections.
            </div>
          </div>
          <div class="modal-footer bg-white px-4 py-2 border-top d-flex justify-content-between">
            <button type="button" class="btn btn-sm btn-light border px-3" @click="showSaveTemplateModal = false">
              Cancel
            </button>
            <button type="button" class="btn btn-sm btn-primary px-4 font-weight-bold shadow-sm" @click="saveAsCustomTemplate">
              <i class="fas fa-save mr-1"></i> Save to My Templates
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- 6. Storefront Full-Screen Live Simulation Modal -->
    <div v-if="showStorefrontPreview" class="modal fade show d-block" tabindex="-1" style="background: rgba(15, 23, 42, 0.85); z-index: 1070;">
      <div class="modal-dialog modal-fullscreen m-0" style="width: 100vw; max-width: 100vw; height: 100vh;">
        <div class="modal-content h-100 rounded-0 border-0 bg-white d-flex flex-column">
          <!-- Simulation Header -->
          <div class="bg-dark text-white px-4 py-2 d-flex align-items-center justify-content-between shadow-sm" style="min-height: 50px;">
            <div class="d-flex align-items-center">
              <span class="badge badge-primary text-uppercase mr-2 font-weight-bold" style="letter-spacing: 0.5px;">Live Simulation</span>
              <span class="font-weight-bold">{{ form.title || 'Section Preview' }}</span>
            </div>
            <div class="d-flex align-items-center">
              <span class="small text-white-50 mr-3 d-none d-md-inline">
                <i class="fas fa-info-circle mr-1"></i> Realistic theme container simulation
              </span>
              <button type="button" class="btn btn-sm btn-outline-light px-3 font-weight-bold" @click="showStorefrontPreview = false">
                <i class="fas fa-times mr-1"></i> Close Preview
              </button>
            </div>
          </div>

          <!-- Storefront Body Frame -->
          <div class="preview-storefront-body flex-grow-1 overflow-auto bg-light p-0">
            <!-- Simulated Store Header -->
            <div class="bg-white border-bottom py-3 px-4 shadow-2xs d-flex align-items-center justify-content-between" style="opacity: 0.85;">
              <div class="font-weight-bold text-dark"><i class="fas fa-wind text-primary mr-2"></i> AIRE Storefront Simulation</div>
              <div class="small text-muted font-italic">Rendering position of this section on site</div>
            </div>

            <!-- The Rendered Section -->
            <section
              :id="form.custom_id || undefined"
              class="position-relative overflow-hidden"
              :class="[form.custom_class, { 'bg-transparent': form.is_transparent_bg }]"
              :style="sectionWrapperStyles"
            >
              <!-- Optional Background Overlay -->
              <div
                v-if="form.enable_overlay && form.background_image"
                class="position-absolute"
                :style="{
                  inset: 0,
                  backgroundColor: form.overlay_color || '#000000',
                  opacity: form.overlay_opacity || 0.5,
                  pointerEvents: 'none',
                  zIndex: 1
                }"
              ></div>

              <div
                :class="form.container_type === 'container-fluid' ? 'container-fluid px-lg-5' : (form.container_type === 'none' ? 'w-100 px-0' : 'container')"
                style="position: relative; z-index: 2;"
              >
                <!-- Section Header -->
                <div
                  v-if="form.badge || form.header_title || form.subtitle"
                  class="pt-5 pb-3"
                  :class="form.header_align || 'text-center'"
                >
                  <div v-if="form.badge" class="mb-2">
                    <span class="badge badge-light border text-primary px-3 py-1 font-weight-bold" style="letter-spacing: 1px; font-size: 0.75rem;">
                      {{ form.badge }}
                    </span>
                  </div>
                  <component
                    :is="form.header_title_tag || 'h2'"
                    v-if="form.header_title"
                    class="font-weight-bold mb-2 title-2"
                    :style="{ letterSpacing: '-0.5px', color: form.header_title_color || 'inherit' }"
                  >
                    {{ form.header_title }}
                  </component>
                  <p
                    v-if="form.subtitle"
                    class="text-secondary small mb-0"
                    :class="{ 'mx-auto': (form.header_align || 'text-center') === 'text-center' }"
                    style="max-width: 650px;"
                  >
                    {{ form.subtitle }}
                  </p>
                </div>

                <!-- Blocks List in Preview -->
                <div class="rendered-storefront-blocks py-4">
                  <div
                    v-for="block in form.blocks"
                    :key="block.id"
                    class="mb-3"
                  >
                    <component
                      :is="resolveBlockComponent(block.type)"
                      :block="block"
                      device-mode="desktop"
                      :is-preview-mode="true"
                    />
                  </div>
                </div>
              </div>
            </section>

            <!-- Simulated Footer -->
            <div class="bg-dark text-white-50 text-center py-4 small mt-5 border-top">
              &copy; {{ new Date().getFullYear() }} AIRE Storefront Simulation.
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 8. Right-Click Canvas Context Menu with Click-Outside Backdrop -->
    <div
      v-if="contextMenu.show"
      class="builder-context-backdrop"
      @click="closeContextMenu"
      @contextmenu.prevent="closeContextMenu"
    ></div>

    <transition name="fade-scale">
      <div
        v-if="contextMenu.show"
        class="builder-context-menu py-1 shadow-lg border rounded-3 bg-white"
        :style="{
          top: `${contextMenu.y}px`,
          left: `${contextMenu.x}px`,
          zIndex: 1080
        }"
        @click.stop
      >
        <div class="px-3 py-1 border-bottom bg-light d-flex align-items-center justify-content-between">
          <span class="badge badge-primary text-uppercase" style="font-size: 0.65rem;">
            {{ contextMenu.block?.type || 'Block' }}
          </span>
          <span class="small text-muted font-weight-bold" style="font-size: 0.72rem;">Actions</span>
        </div>

        <button
          type="button"
          class="dropdown-item d-flex align-items-center justify-content-between py-2 px-3 small"
          @click="duplicateContextMenuBlock"
        >
          <span><i class="fas fa-copy text-primary mr-2"></i> Duplicate</span>
          <kbd class="text-muted bg-light border px-1" style="font-size: 0.65rem;">Ctrl+D</kbd>
        </button>

        <button
          type="button"
          class="dropdown-item d-flex align-items-center justify-content-between py-2 px-3 small"
          @click="copyBlockStyles(contextMenu.block)"
        >
          <span><i class="fas fa-paint-roller text-info mr-2"></i> Copy Style</span>
        </button>

        <button
          type="button"
          class="dropdown-item d-flex align-items-center justify-content-between py-2 px-3 small"
          :class="{ 'disabled text-muted': !copiedStyles || copiedStyles.type !== contextMenu.block?.type }"
          :disabled="!copiedStyles || copiedStyles.type !== contextMenu.block?.type"
          @click="pasteBlockStyles(contextMenu.block)"
        >
          <span><i class="fas fa-paste text-success mr-2"></i> Paste Style</span>
          <span v-if="copiedStyles && copiedStyles.type === contextMenu.block?.type" class="badge badge-success px-1" style="font-size: 0.6rem;">Ready</span>
        </button>

        <div class="dropdown-divider my-1"></div>

        <button
          type="button"
          class="dropdown-item d-flex align-items-center justify-content-between py-2 px-3 small"
          :disabled="contextMenu.index === 0"
          @click="moveContextMenuBlock(-1)"
        >
          <span><i class="fas fa-arrow-up text-secondary mr-2"></i> Move Up</span>
        </button>

        <button
          type="button"
          class="dropdown-item d-flex align-items-center justify-content-between py-2 px-3 small"
          :disabled="contextMenu.index === form.blocks.length - 1"
          @click="moveContextMenuBlock(1)"
        >
          <span><i class="fas fa-arrow-down text-secondary mr-2"></i> Move Down</span>
        </button>

        <div class="dropdown-divider my-1"></div>

        <button
          type="button"
          class="dropdown-item d-flex align-items-center justify-content-between py-2 px-3 small text-danger"
          @click="deleteContextMenuBlock"
        >
          <span><i class="fas fa-trash-alt mr-2"></i> Delete</span>
          <kbd class="text-danger bg-light border px-1" style="font-size: 0.65rem;">Del</kbd>
        </button>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, reactive, computed, watch, onMounted, onBeforeUnmount } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import draggable from 'vuedraggable';
import axios from 'axios';
import { useToast } from '@/composables/useToast';

import BlockInserterModal from './builder/BlockInserterModal.vue';
import BlockInspector from './builder/BlockInspector.vue';
import MediaLibraryModal from './builder/MediaLibraryModal.vue';
import TemplateLibraryModal from './builder/TemplateLibraryModal.vue';
import DocumentTreeNavigator from './builder/DocumentTreeNavigator.vue';
import { getImageUrl } from '@/layouts/helpers/helpers';

import HeadingBlock from './builder/blocks/HeadingBlock.vue';
import ParagraphBlock from './builder/blocks/ParagraphBlock.vue';
import ImageBlock from './builder/blocks/ImageBlock.vue';
import ContainerBlock from './builder/blocks/ContainerBlock.vue';
import CardBlock from './builder/blocks/CardBlock.vue';
import ButtonBlock from './builder/blocks/ButtonBlock.vue';
import SpacerBlock from './builder/blocks/SpacerBlock.vue';
import ProductBlock from './builder/blocks/ProductBlock.vue';
import AccordionBlock from './builder/blocks/AccordionBlock.vue';
import NewsBlock from './builder/blocks/NewsBlock.vue';
import CategoryGridBlock from './builder/blocks/CategoryGridBlock.vue';
import BrandBlock from './builder/blocks/BrandBlock.vue';

const route = useRoute();
const router = useRouter();
const toast = useToast();

const deviceMode = ref('desktop');
const isPreviewMode = ref(false);
const showInspector = ref(true);
const showInserterModal = ref(false);
const showGlobalSettingsModal = ref(false);
const showBgMediaModal = ref(false);
const showTemplateModal = ref(false);
const showShortcutsModal = ref(false);
const showLayersDrawer = ref(false);
const showStorefrontPreview = ref(false);
const showSaveTemplateModal = ref(false);
const isTopbarCollapsed = ref(false);
const saving = ref(false);
const activeConfigTab = ref('header');

function toggleTopbar() {
  isTopbarCollapsed.value = !isTopbarCollapsed.value;
  try {
    localStorage.setItem('aire_builder_topbar_collapsed', isTopbarCollapsed.value ? '1' : '0');
  } catch (e) {}
}

const selectedBlockId = ref(null);
const targetColumnContext = ref(null); // when adding block inside a specific column
const targetInsertIndex = ref(null); // when adding block between blocks in canvas

const saveTemplateForm = reactive({
  name: '',
  description: '',
  category: 'My Templates'
});

const form = reactive({
  id: null,
  name: '',
  title: 'Custom Section',
  header_title: '',
  badge: '',
  subtitle: '',
  header_align: 'text-center',
  header_title_tag: 'h2',
  header_title_color: '',
  header_badge_style: 'text',
  is_transparent_bg: false,
  background_color: '#ffffff',
  background_image: '',
  enable_overlay: false,
  overlay_color: '#000000',
  overlay_opacity: 0.5,
  container_type: 'container',
  min_height: '',
  custom_id: '',
  custom_class: '',
  padding_mode: 'preset',
  padding_y: {
    desktop: 'py-5',
    mobile: 'py-3'
  },
  custom_padding: {
    pt_desktop: '80px',
    pb_desktop: '80px',
    pt_mobile: '40px',
    pb_mobile: '40px'
  },
  blocks: []
});

function onTransparentToggle() {
  if (form.is_transparent_bg) {
    form.background_color = 'transparent';
  } else if (!form.background_color || form.background_color === 'transparent') {
    form.background_color = '#ffffff';
  }
}

// ============================================================================
// Undo / Redo History System
// ============================================================================
const undoStack = ref([]);
const redoStack = ref([]);
const isTravelling = ref(false);
const maxHistory = 40;
let historyTimeout = null;
let lastSnapshot = '';

const canUndo = computed(() => undoStack.value.length > 0);
const canRedo = computed(() => redoStack.value.length > 0);

function getSnapshot() {
  return JSON.stringify({
    blocks: form.blocks,
    title: form.title,
    header_title: form.header_title,
    header_title_tag: form.header_title_tag,
    header_title_color: form.header_title_color,
    badge: form.badge,
    header_badge_style: form.header_badge_style,
    subtitle: form.subtitle,
    header_align: form.header_align,
    background_color: form.background_color,
    background_image: form.background_image,
    is_transparent_bg: form.is_transparent_bg,
    enable_overlay: form.enable_overlay,
    overlay_color: form.overlay_color,
    overlay_opacity: form.overlay_opacity,
    container_type: form.container_type,
    min_height: form.min_height,
    padding_mode: form.padding_mode,
    padding_y: form.padding_y,
    custom_padding: form.custom_padding,
    custom_id: form.custom_id,
    custom_class: form.custom_class
  });
}

function recordSnapshot() {
  if (isTravelling.value) return;
  const current = getSnapshot();
  if (current === lastSnapshot) return;

  if (lastSnapshot) {
    undoStack.value.push(lastSnapshot);
    if (undoStack.value.length > maxHistory) {
      undoStack.value.shift();
    }
  }
  redoStack.value = [];
  lastSnapshot = current;
}

function scheduleSnapshot() {
  if (isTravelling.value) return;
  if (historyTimeout) clearTimeout(historyTimeout);
  historyTimeout = setTimeout(() => {
    recordSnapshot();
  }, 400);
}

function applySnapshot(state) {
  if (!state) return;
  form.blocks = state.blocks || [];
  if (state.title !== undefined) form.title = state.title;
  if (state.header_title !== undefined) form.header_title = state.header_title;
  if (state.header_title_tag !== undefined) form.header_title_tag = state.header_title_tag;
  if (state.header_title_color !== undefined) form.header_title_color = state.header_title_color;
  if (state.badge !== undefined) form.badge = state.badge;
  if (state.header_badge_style !== undefined) form.header_badge_style = state.header_badge_style;
  if (state.subtitle !== undefined) form.subtitle = state.subtitle;
  if (state.header_align !== undefined) form.header_align = state.header_align;
  if (state.background_color !== undefined) form.background_color = state.background_color;
  if (state.background_image !== undefined) form.background_image = state.background_image;
  if (state.is_transparent_bg !== undefined) form.is_transparent_bg = state.is_transparent_bg;
  if (state.enable_overlay !== undefined) form.enable_overlay = state.enable_overlay;
  if (state.overlay_color !== undefined) form.overlay_color = state.overlay_color;
  if (state.overlay_opacity !== undefined) form.overlay_opacity = state.overlay_opacity;
  if (state.container_type !== undefined) form.container_type = state.container_type;
  if (state.min_height !== undefined) form.min_height = state.min_height;
  if (state.padding_mode !== undefined) form.padding_mode = state.padding_mode;
  if (state.padding_y !== undefined) Object.assign(form.padding_y, state.padding_y);
  if (state.custom_padding !== undefined) Object.assign(form.custom_padding, state.custom_padding);
  if (state.custom_id !== undefined) form.custom_id = state.custom_id;
  if (state.custom_class !== undefined) form.custom_class = state.custom_class;
}

function undo() {
  if (!canUndo.value) return;
  const prevSnapshotStr = undoStack.value.pop();
  if (!prevSnapshotStr) return;

  isTravelling.value = true;
  redoStack.value.push(getSnapshot());

  try {
    const state = JSON.parse(prevSnapshotStr);
    applySnapshot(state);
    lastSnapshot = getSnapshot();
  } catch (err) {
    console.error('Failed to apply undo state', err);
  }

  if (selectedBlockId.value && !findBlockById(form.blocks, selectedBlockId.value)) {
    selectedBlockId.value = null;
  }

  setTimeout(() => {
    isTravelling.value = false;
  }, 60);

  toast.info('Action Undone');
}

function redo() {
  if (!canRedo.value) return;
  const nextSnapshotStr = redoStack.value.pop();
  if (!nextSnapshotStr) return;

  isTravelling.value = true;
  undoStack.value.push(getSnapshot());

  try {
    const state = JSON.parse(nextSnapshotStr);
    applySnapshot(state);
    lastSnapshot = getSnapshot();
  } catch (err) {
    console.error('Failed to apply redo state', err);
  }

  if (selectedBlockId.value && !findBlockById(form.blocks, selectedBlockId.value)) {
    selectedBlockId.value = null;
  }

  setTimeout(() => {
    isTravelling.value = false;
  }, 60);

  toast.info('Action Redone');
}

function onBgMediaSelect(file) {
  form.background_image = file.path ? (file.path.startsWith('storage/') ? file.path : 'storage/' + file.path) : file.url;
}

function handleTemplateSelect({ template, mode }) {
  if (!template) return;
  recordSnapshot();
  const newBlocks = typeof template.generateBlocks === 'function' ? template.generateBlocks() : [];

  if (mode === 'replace') {
    if (template.sectionDefaults) {
      if (template.sectionDefaults.title && (!form.title || form.title === 'Custom Section')) {
        form.title = template.sectionDefaults.title;
      }
      if (template.sectionDefaults.header_title !== undefined) form.header_title = template.sectionDefaults.header_title;
      if (template.sectionDefaults.header_title_tag) form.header_title_tag = template.sectionDefaults.header_title_tag;
      if (template.sectionDefaults.badge !== undefined) form.badge = template.sectionDefaults.badge;
      if (template.sectionDefaults.header_badge_style) form.header_badge_style = template.sectionDefaults.header_badge_style;
      if (template.sectionDefaults.subtitle !== undefined) form.subtitle = template.sectionDefaults.subtitle;
      if (template.sectionDefaults.header_align) form.header_align = template.sectionDefaults.header_align;
      if (template.sectionDefaults.bg_color) form.background_color = template.sectionDefaults.bg_color;
      if (template.sectionDefaults.padding_mode) form.padding_mode = template.sectionDefaults.padding_mode;
      if (template.sectionDefaults.padding_y) Object.assign(form.padding_y, template.sectionDefaults.padding_y);
      if (template.sectionDefaults.custom_padding) Object.assign(form.custom_padding, template.sectionDefaults.custom_padding);
      if (template.sectionDefaults.min_height !== undefined) form.min_height = template.sectionDefaults.min_height;
    }
    form.blocks = newBlocks;
    selectedBlockId.value = null;
    recordSnapshot();
    toast.success(`Template "${template.name}" applied successfully!`);
  } else {
    // Append mode
    if (!form.blocks) form.blocks = [];
    form.blocks.push(...newBlocks);
    recordSnapshot();
    toast.success(`Blocks from "${template.name}" appended to canvas!`);
  }
}

// Watch form deeply to record continuous changes
watch(form, () => {
  scheduleSnapshot();
}, { deep: true });

const canvasFrameClass = computed(() => {
  if (deviceMode.value === 'mobile') {
    return 'frame-mobile';
  }
  if (deviceMode.value === 'tablet') {
    return 'frame-tablet';
  }
  return 'frame-desktop';
});

const sectionWrapperStyles = computed(() => {
  const isTransparent = form.is_transparent_bg || form.background_color === 'transparent';
  const styles = {
    backgroundColor: isTransparent ? 'transparent' : (form.background_color || '#ffffff')
  };
  if (form.background_image) {
    const imgUrl = getImageUrl(form.background_image);
    styles.backgroundImage = `url('${imgUrl}')`;
    styles.backgroundSize = 'cover';
    styles.backgroundPosition = 'center';
  }
  if (form.min_height) {
    styles.minHeight = form.min_height;
  }
  if (form.padding_mode === 'custom' && form.custom_padding) {
    if (deviceMode.value === 'mobile') {
      styles.paddingTop = form.custom_padding.pt_mobile || '40px';
      styles.paddingBottom = form.custom_padding.pb_mobile || '40px';
    } else {
      styles.paddingTop = form.custom_padding.pt_desktop || '80px';
      styles.paddingBottom = form.custom_padding.pb_desktop || '80px';
    }
  }
  return styles;
});

// Recursively find block by ID in the tree
function findBlockById(blocks, id) {
  for (const b of blocks) {
    if (b.id === id) return b;
    if (b.columns) {
      for (const col of b.columns) {
        const found = findBlockById(col, id);
        if (found) return found;
      }
    }
  }
  return null;
}

const selectedBlock = computed(() => {
  if (!selectedBlockId.value) return null;
  return findBlockById(form.blocks, selectedBlockId.value);
});

// ==========================================================================
// Floating Panels & Draggable Window State (Photoshop Style)
// ==========================================================================
const layersPos = reactive({ x: 20, y: 20 });
const isLayersMinimized = ref(false);
const layersZIndex = ref(1030);

const inspectorPos = reactive({ x: null, y: 20 });
const isInspectorMinimized = ref(false);
const inspectorZIndex = ref(1031);

let activeZIndex = 1035;
function bringToFront(panel) {
  activeZIndex += 1;
  if (panel === 'layers') {
    layersZIndex.value = activeZIndex;
  } else if (panel === 'inspector') {
    inspectorZIndex.value = activeZIndex;
  }
}

function startDragPanel(e, panelName) {
  if (e.button !== 0) return;
  if (e.target.closest('button, a, input, select, textarea')) return;

  bringToFront(panelName);

  const pos = panelName === 'layers' ? layersPos : inspectorPos;
  const panelEl = document.getElementById(`floating-panel-${panelName}`);
  const workspaceEl = panelEl ? panelEl.closest('.builder-workspace') : null;
  const workspaceRect = workspaceEl
    ? workspaceEl.getBoundingClientRect()
    : { left: 0, top: 0, width: window.innerWidth, height: window.innerHeight };

  // Calculate actual pixel position if initially right-aligned
  if (panelName === 'inspector' && pos.x === null && panelEl) {
    const elRect = panelEl.getBoundingClientRect();
    pos.x = elRect.left - workspaceRect.left;
    pos.y = elRect.top - workspaceRect.top;
  }

  const startMouseX = e.clientX;
  const startMouseY = e.clientY;
  const startPosX = pos.x ?? 20;
  const startPosY = pos.y ?? 20;

  const panelWidth = panelEl ? panelEl.offsetWidth : 320;

  function onMouseMove(moveEvent) {
    moveEvent.preventDefault();
    const dx = moveEvent.clientX - startMouseX;
    const dy = moveEvent.clientY - startMouseY;

    let newX = startPosX + dx;
    let newY = startPosY + dy;

    // Boundaries: inside workspace container
    const maxBoundX = Math.max(0, workspaceRect.width - panelWidth);
    const maxBoundY = Math.max(0, workspaceRect.height - 40);

    newX = Math.min(Math.max(0, newX), maxBoundX);
    newY = Math.min(Math.max(0, newY), maxBoundY);

    pos.x = newX;
    pos.y = newY;
  }

  function onMouseUp() {
    window.removeEventListener('mousemove', onMouseMove);
    window.removeEventListener('mouseup', onMouseUp);
    document.body.style.userSelect = '';
    document.body.style.cursor = '';
  }

  document.body.style.userSelect = 'none';
  document.body.style.cursor = 'grabbing';
  window.addEventListener('mousemove', onMouseMove);
  window.addEventListener('mouseup', onMouseUp);
}

function selectBlock(block) {
  selectedBlockId.value = block.id;
  showInspector.value = true;
  isInspectorMinimized.value = false;
  bringToFront('inspector');
}

function toggleLayersDrawer() {
  showLayersDrawer.value = !showLayersDrawer.value;
  if (showLayersDrawer.value) {
    isLayersMinimized.value = false;
    bringToFront('layers');
  }
}

function resolveBlockComponent(type) {
  switch (type) {
    case 'heading': return HeadingBlock;
    case 'paragraph': return ParagraphBlock;
    case 'image': return ImageBlock;
    case 'container': return ContainerBlock;
    case 'card': return CardBlock;
    case 'button': return ButtonBlock;
    case 'spacer': return SpacerBlock;
    case 'products': return ProductBlock;
    case 'accordion': return AccordionBlock;
    case 'news': return NewsBlock;
    case 'categories': return CategoryGridBlock;
    case 'brands': return BrandBlock;
    default: return ParagraphBlock;
  }
}

function openInserter(colContext = null) {
  targetColumnContext.value = colContext;
  targetInsertIndex.value = null;
  showInserterModal.value = true;
}

function openInserterAtIndex(index) {
  targetInsertIndex.value = index;
  targetColumnContext.value = null;
  showInserterModal.value = true;
}

function openInserterForColumn(ctx) {
  openInserter(ctx);
}

function handleBlockSelect({ type, columnsCount, extra }) {
  recordSnapshot();
  const newBlock = createBlockInstance(type, columnsCount, extra);
  if (targetColumnContext.value) {
    const { block, colIdx } = targetColumnContext.value;
    if (!block.columns[colIdx]) block.columns[colIdx] = [];
    block.columns[colIdx].push(newBlock);
  } else if (targetInsertIndex.value !== null && targetInsertIndex.value >= 0) {
    form.blocks.splice(targetInsertIndex.value, 0, newBlock);
  } else {
    form.blocks.push(newBlock);
  }
  selectedBlockId.value = newBlock.id;
  targetColumnContext.value = null;
  targetInsertIndex.value = null;
  recordSnapshot();
}

function duplicateBlockById(blockId) {
  recordSnapshot();
  const ctx = findBlockContext(form.blocks, blockId);
  if (!ctx) return;
  const clone = JSON.parse(JSON.stringify(ctx.block));
  clone.id = 'blk_' + Date.now() + Math.random().toString(36).substr(2, 4);
  if (clone.columns) {
    clone.columns = clone.columns.map(col => col.map(cb => ({
      ...cb,
      id: 'blk_' + Date.now() + Math.random().toString(36).substr(2, 4)
    })));
  }
  ctx.list.splice(ctx.index + 1, 0, clone);
  selectedBlockId.value = clone.id;
  recordSnapshot();
  toast.success('Block duplicated from layers');
}

function deleteBlockById(blockId) {
  if (confirm('Delete this block?')) {
    recordSnapshot();
    const ctx = findBlockContext(form.blocks, blockId);
    if (!ctx) return;
    ctx.list.splice(ctx.index, 1);
    if (selectedBlockId.value === blockId) {
      selectedBlockId.value = null;
    }
    recordSnapshot();
    toast.info('Block deleted from layers');
  }
}

function deleteSubBlock({ col, sIdx }) {
  if (confirm('Delete this sub-block?')) {
    recordSnapshot();
    col.splice(sIdx, 1);
    recordSnapshot();
    toast.info('Sub-block deleted');
  }
}

function openSaveTemplateModal() {
  saveTemplateForm.name = form.title ? `${form.title} Template` : 'My Custom Template';
  saveTemplateForm.description = form.subtitle || 'Reusable custom section layout';
  showSaveTemplateModal.value = true;
}

function saveAsCustomTemplate() {
  if (!saveTemplateForm.name.trim()) {
    toast.error('Please enter a template name');
    return;
  }
  try {
    const existingRaw = localStorage.getItem('aire_custom_templates');
    const existing = existingRaw ? JSON.parse(existingRaw) : [];

    const newTemplate = {
      id: 'custom_' + Date.now(),
      name: saveTemplateForm.name.trim(),
      description: saveTemplateForm.description.trim(),
      category: 'My Templates',
      icon: 'fas fa-bookmark',
      badge: 'Custom',
      isCustom: true,
      sectionDefaults: {
        title: form.title,
        header_title: form.header_title,
        header_title_tag: form.header_title_tag,
        badge: form.badge,
        header_badge_style: form.header_badge_style,
        subtitle: form.subtitle,
        header_align: form.header_align,
        bg_color: form.background_color,
        padding_mode: form.padding_mode,
        padding_y: { ...form.padding_y },
        custom_padding: { ...form.custom_padding },
        min_height: form.min_height
      },
      blocks: JSON.parse(JSON.stringify(form.blocks))
    };

    existing.unshift(newTemplate);
    localStorage.setItem('aire_custom_templates', JSON.stringify(existing));
    showSaveTemplateModal.value = false;
    toast.success(`Template "${newTemplate.name}" saved to My Templates!`);
  } catch (e) {
    toast.error('Failed to save template to local storage.');
  }
}

function createBlockInstance(type, columnsCount = null, extra = {}) {
  const id = 'blk_' + Date.now() + Math.random().toString(36).substr(2, 4);
  const block = { id, type, settings: {} };

  switch (type) {
    case 'heading':
      block.settings = {
        text: 'Engineered for Complete Atmospheric Purity',
        tag: 'h2',
        color: '#0d1b2a',
        align: { desktop: 'text-start', mobile: 'text-center' },
        fontSize: 'title-2',
        visibility: { hideOnMobile: false, hideOnDesktop: false }
      };
      break;
    case 'paragraph':
      block.settings = {
        text: 'Combining multi-stage active HEPA filtration with intelligent ambient monitoring for pure, healthy air.',
        color: '#64748b',
        maxWidth: '100%',
        align: { desktop: 'text-start', mobile: 'text-center' },
        visibility: { hideOnMobile: false, hideOnDesktop: false }
      };
      break;
    case 'image':
      block.settings = {
        url: 'themes/default/assets/img/photograph.webp',
        alt: 'Product Showcase',
        caption: '',
        rounded: 'rounded-4',
        shadow: 'shadow-sm',
        fullWidth: true,
        align: 'text-center',
        visibility: { hideOnMobile: false, hideOnDesktop: false }
      };
      break;
    case 'container':
      const cCount = columnsCount || 2;
      block.columns = Array.from({ length: cCount }, () => []);
      let desktopCol = 'col-lg-6';
      if (cCount === 1) desktopCol = 'col-lg-12';
      else if (cCount === 2) desktopCol = 'col-lg-6';
      else if (cCount === 3) desktopCol = 'col-lg-4';
      else if (cCount === 4) desktopCol = 'col-lg-3';
      else if (cCount === 5) desktopCol = 'col-lg';
      else if (cCount === 6) desktopCol = 'col-lg-2';

      block.settings = {
        columnsCount: cCount,
        layout: {
          desktop: desktopCol,
          tablet: cCount >= 4 ? 'col-md-4' : 'col-md-6',
          mobile: cCount >= 4 ? 'col-6' : 'col-12'
        },
        columnClasses: extra.customCols || [],
        stackOrderMobile: 'default',
        gap: { desktop: 'g-4', mobile: 'g-3' },
        verticalAlign: 'align-items-center',
        visibility: { hideOnMobile: false, hideOnDesktop: false }
      };
      break;
    case 'card':
      block.settings = {
        title: 'Active Sensor Array',
        description: 'Continuously measures airborne pollutants and VOCs in real time.',
        number: '01',
        badge: '',
        isGlass: !!extra.isGlass,
        visibility: { hideOnMobile: false, hideOnDesktop: false }
      };
      break;
    case 'button':
      block.settings = {
        text: 'Explore Innovations',
        url: '/category/products',
        variant: 'btn-primary',
        size: 'btn-md',
        rounded: 'rounded-2',
        align: { desktop: 'text-start', mobile: 'text-center' },
        visibility: { hideOnMobile: false, hideOnDesktop: false }
      };
      break;
    case 'spacer':
      block.settings = {
        height: '32px',
        isDivider: false,
        visibility: { hideOnMobile: false, hideOnDesktop: false }
      };
      break;
    case 'products':
      block.settings = {
        source: 'latest',
        category_id: null,
        limit: 4,
        columns_desktop: 'col-lg-3',
        columns_mobile: 'col-6',
        show_badge: true,
        show_price: true,
        show_action_buttons: true,
        visibility: { hideOnMobile: false, hideOnDesktop: false }
      };
      break;
    case 'accordion':
      block.settings = {
        style: 'separated',
        icon_type: 'chevron',
        first_open: true,
        allow_multiple: false,
        items: [
          {
            id: 'item_1',
            title: 'How often do filters need to be replaced?',
            content: 'Filters typically should be replaced every 6 to 12 months depending on ambient air quality and daily operating hours.'
          },
          {
            id: 'item_2',
            title: 'What is the recommended room coverage area?',
            content: 'Our standard unit purifies up to 800 sq ft within 30 minutes with high efficiency particulate retention.'
          },
          {
            id: 'item_3',
            title: 'Is warranty coverage included with my purchase?',
            content: 'Yes, all units include a 2-year full manufacturer warranty with 24/7 dedicated customer care.'
          }
        ],
        visibility: { hideOnMobile: false, hideOnDesktop: false }
      };
      break;
    case 'news':
      block.settings = {
        limit: 3,
        columns_desktop: 'col-lg-4',
        columns_mobile: 'col-12',
        category_id: null,
        visibility: { hideOnMobile: false, hideOnDesktop: false }
      };
      break;
    case 'categories':
      block.settings = {
        limit: 6,
        columns_desktop: 'col-lg-2',
        columns_mobile: 'col-6',
        show_count: true,
        visibility: { hideOnMobile: false, hideOnDesktop: false }
      };
      break;
    case 'brands':
      block.settings = {
        limit: 6,
        columns_desktop: 'col-lg-2',
        columns_mobile: 'col-4',
        grayscale: true,
        boxed: true,
        visibility: { hideOnMobile: false, hideOnDesktop: false }
      };
      break;
  }

  return block;
}

function findBlockContext(blocks, id, parent = null) {
  for (let i = 0; i < blocks.length; i++) {
    const b = blocks[i];
    if (b.id === id) {
      return { list: blocks, index: i, block: b, parent };
    }
    if (b.columns) {
      for (let c = 0; c < b.columns.length; c++) {
        const found = findBlockContext(b.columns[c], id, b);
        if (found) return found;
      }
    }
  }
  return null;
}

function duplicateSelectedBlock() {
  if (!selectedBlockId.value) return;
  recordSnapshot();
  const ctx = findBlockContext(form.blocks, selectedBlockId.value);
  if (!ctx) return;
  const clone = JSON.parse(JSON.stringify(ctx.block));
  clone.id = 'blk_' + Date.now() + Math.random().toString(36).substr(2, 4);
  if (clone.columns) {
    clone.columns = clone.columns.map(col => col.map(cb => ({
      ...cb,
      id: 'blk_' + Date.now() + Math.random().toString(36).substr(2, 4)
    })));
  }
  ctx.list.splice(ctx.index + 1, 0, clone);
  selectedBlockId.value = clone.id;
  recordSnapshot();
  toast.success('Block duplicated');
}

function deleteSelectedBlock() {
  if (!selectedBlockId.value) return;
  recordSnapshot();
  const ctx = findBlockContext(form.blocks, selectedBlockId.value);
  if (!ctx) return;
  ctx.list.splice(ctx.index, 1);
  selectedBlockId.value = null;
  recordSnapshot();
  toast.info('Block deleted');
}

function moveBlock(index, delta) {
  const newIndex = index + delta;
  if (newIndex < 0 || newIndex >= form.blocks.length) return;
  recordSnapshot();
  const item = form.blocks.splice(index, 1)[0];
  form.blocks.splice(newIndex, 0, item);
  recordSnapshot();
}

function duplicateBlock(index) {
  recordSnapshot();
  const clone = JSON.parse(JSON.stringify(form.blocks[index]));
  clone.id = 'blk_' + Date.now() + Math.random().toString(36).substr(2, 4);
  if (clone.columns) {
    clone.columns = clone.columns.map(col => col.map(cb => ({
      ...cb,
      id: 'blk_' + Date.now() + Math.random().toString(36).substr(2, 4)
    })));
  }
  form.blocks.splice(index + 1, 0, clone);
  selectedBlockId.value = clone.id;
  recordSnapshot();
}

function deleteBlock(index) {
  if (confirm('Delete this block?')) {
    recordSnapshot();
    form.blocks.splice(index, 1);
    selectedBlockId.value = null;
    recordSnapshot();
  }
}

// ==========================================================================
// Right-Click Context Menu & Block Style Copy/Paste
// ==========================================================================
const importFileInput = ref(null);
const copiedStyles = ref(null);

const contextMenu = reactive({
  show: false,
  x: 0,
  y: 0,
  block: null,
  index: null
});

function openContextMenu(e, block, index) {
  if (isPreviewMode.value) return;
  selectBlock(block);

  const menuWidth = 205;
  const menuHeight = 230;
  let posX = e.clientX;
  let posY = e.clientY;

  if (posX + menuWidth > window.innerWidth) {
    posX = window.innerWidth - menuWidth - 10;
  }
  if (posY + menuHeight > window.innerHeight) {
    posY = window.innerHeight - menuHeight - 10;
  }

  contextMenu.x = posX;
  contextMenu.y = posY;
  contextMenu.block = block;
  contextMenu.index = index;
  contextMenu.show = true;
}

function closeContextMenu() {
  contextMenu.show = false;
}

function onGlobalPointerDown(e) {
  if (contextMenu.show && !e.target.closest('.builder-context-menu')) {
    closeContextMenu();
  }
}

function duplicateContextMenuBlock() {
  if (contextMenu.index !== null) {
    duplicateBlock(contextMenu.index);
  }
  closeContextMenu();
}

function deleteContextMenuBlock() {
  if (contextMenu.index !== null) {
    deleteBlock(contextMenu.index);
  }
  closeContextMenu();
}

function moveContextMenuBlock(delta) {
  if (contextMenu.index !== null) {
    moveBlock(contextMenu.index, delta);
    contextMenu.index += delta;
  }
  closeContextMenu();
}

function copyBlockStyles(block) {
  if (!block || !block.settings) return;
  const s = JSON.parse(JSON.stringify(block.settings));
  delete s.text;
  delete s.url;
  delete s.badge;
  delete s.title;
  delete s.caption;
  delete s.custom_id;

  copiedStyles.value = {
    type: block.type,
    styles: s
  };
  closeContextMenu();
  toast.success(`Copied ${block.type} styles!`);
}

function pasteBlockStyles(targetBlock) {
  if (!targetBlock || !copiedStyles.value) return;
  if (copiedStyles.value.type !== targetBlock.type) {
    toast.warning(`Cannot paste ${copiedStyles.value.type} styles onto ${targetBlock.type}`);
    return;
  }
  recordSnapshot();
  targetBlock.settings = {
    ...targetBlock.settings,
    ...JSON.parse(JSON.stringify(copiedStyles.value.styles))
  };
  recordSnapshot();
  closeContextMenu();
  toast.success(`Pasted styles onto ${targetBlock.type}!`);
}

// ==========================================================================
// Export & Import Section JSON
// ==========================================================================
function exportSectionJson() {
  try {
    const exportData = {
      aire_section_version: '2.0',
      exported_at: new Date().toISOString(),
      section: {
        title: form.title,
        name: form.name,
        type: form.type,
        group: form.group,
        background_color: form.background_color,
        background_image: form.background_image,
        is_transparent_bg: form.is_transparent_bg,
        min_height: form.min_height,
        padding_mode: form.padding_mode,
        custom_padding: form.custom_padding,
        container_width: form.container_width,
        badge: form.badge,
        header_title: form.header_title,
        header_title_tag: form.header_title_tag,
        header_title_color: form.header_title_color,
        header_badge_style: form.header_badge_style,
        subtitle: form.subtitle,
        subtitle_color: form.subtitle_color,
        header_align: form.header_align,
        enable_overlay: form.enable_overlay,
        overlay_color: form.overlay_color,
        overlay_opacity: form.overlay_opacity,
        blocks: JSON.parse(JSON.stringify(form.blocks))
      }
    };

    const jsonString = JSON.stringify(exportData, null, 2);
    const blob = new Blob([jsonString], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `${form.name || 'section'}-export.json`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    toast.success('Section exported successfully!');
  } catch (err) {
    console.error('Export failed', err);
    toast.error('Failed to export section');
  }
}

function triggerImportJson() {
  if (importFileInput.value) {
    importFileInput.value.click();
  }
}

function handleImportJsonFile(e) {
  const file = e.target.files && e.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = (event) => {
    try {
      const parsed = JSON.parse(event.target.result);
      const sec = parsed.section || parsed;

      if (!sec || !Array.isArray(sec.blocks)) {
        toast.error('Invalid section JSON file. Missing blocks array.');
        return;
      }

      recordSnapshot();
      if (sec.title) form.title = sec.title;
      if (sec.background_color !== undefined) form.background_color = sec.background_color;
      if (sec.background_image !== undefined) form.background_image = sec.background_image;
      if (sec.is_transparent_bg !== undefined) form.is_transparent_bg = sec.is_transparent_bg;
      if (sec.min_height !== undefined) form.min_height = sec.min_height;
      if (sec.padding_mode !== undefined) form.padding_mode = sec.padding_mode;
      if (sec.custom_padding !== undefined) form.custom_padding = sec.custom_padding;
      if (sec.container_width !== undefined) form.container_width = sec.container_width;
      if (sec.badge !== undefined) form.badge = sec.badge;
      if (sec.header_title !== undefined) form.header_title = sec.header_title;
      if (sec.subtitle !== undefined) form.subtitle = sec.subtitle;

      form.blocks = sec.blocks;
      recordSnapshot();
      toast.success('Section layout imported successfully!');
    } catch (err) {
      console.error('Import failed', err);
      toast.error('Failed to parse JSON file');
    } finally {
      e.target.value = '';
    }
  };
  reader.readAsText(file);
}

// Fetch Section Data
async function loadSection() {
  isTravelling.value = true;
  const id = route.params.id;
  if (!id) {
    form.name = 'custom_section_' + Date.now().toString().slice(-6);
    lastSnapshot = getSnapshot();
    undoStack.value = [];
    redoStack.value = [];
    isTravelling.value = false;
    return;
  }

  try {
    const res = await axios.get(`/api/sections/${id}`);
    const sec = res.data.data;
    form.id = sec.id;
    form.name = sec.name;

    let d = sec.data;
    if (typeof d === 'string') {
      try { d = JSON.parse(d); } catch (e) { }
    }
    d = d || {};

    form.title = d.title || sec.name;
    form.header_title = d.header_title || '';
    form.badge = d.badge || '';
    form.subtitle = d.subtitle || '';
    form.header_align = d.header_align || 'text-center';
    form.header_title_tag = d.header_title_tag || 'h2';
    form.header_title_color = d.header_title_color || '';
    form.header_badge_style = d.header_badge_style || 'text';
    form.is_transparent_bg = !!d.is_transparent_bg || d.background_color === 'transparent';
    form.background_color = d.background_color || '#ffffff';
    form.background_image = d.background_image || '';
    form.enable_overlay = !!d.enable_overlay;
    form.overlay_color = d.overlay_color || '#000000';
    form.overlay_opacity = d.overlay_opacity ?? 0.5;
    form.container_type = d.container_type || 'container';
    form.min_height = d.min_height || '';
    form.custom_id = d.custom_id || '';
    form.custom_class = d.custom_class || '';
    form.padding_mode = d.padding_mode || 'preset';
    if (d.padding_y) {
      form.padding_y = d.padding_y;
    }
    if (d.custom_padding) {
      form.custom_padding = {
        pt_desktop: d.custom_padding.pt_desktop || '80px',
        pb_desktop: d.custom_padding.pb_desktop || '80px',
        pt_mobile: d.custom_padding.pt_mobile || '40px',
        pb_mobile: d.custom_padding.pb_mobile || '40px'
      };
    }
    form.blocks = d.blocks || [];

    // Initialize clean baseline snapshot
    lastSnapshot = getSnapshot();
    undoStack.value = [];
    redoStack.value = [];
  } catch (err) {
    console.error(err);
    toast.error('Failed to load section data');
  } finally {
    setTimeout(() => {
      isTravelling.value = false;
    }, 100);
  }
}

// Save Section Data to API
async function saveSection() {
  saving.value = true;
  try {
    const payload = {
      name: form.name,
      data: {
        title: form.title,
        header_title: form.header_title,
        badge: form.badge,
        subtitle: form.subtitle,
        header_align: form.header_align || 'text-center',
        header_title_tag: form.header_title_tag || 'h2',
        header_title_color: form.header_title_color || '',
        header_badge_style: form.header_badge_style || 'text',
        is_transparent_bg: !!form.is_transparent_bg,
        background_color: form.is_transparent_bg ? 'transparent' : (form.background_color || '#ffffff'),
        background_image: form.background_image,
        enable_overlay: !!form.enable_overlay,
        overlay_color: form.overlay_color || '#000000',
        overlay_opacity: form.overlay_opacity ?? 0.5,
        container_type: form.container_type || 'container',
        min_height: form.min_height || '',
        custom_id: form.custom_id || '',
        custom_class: form.custom_class || '',
        padding_mode: form.padding_mode || 'preset',
        padding_y: form.padding_y,
        custom_padding: form.custom_padding,
        blocks: form.blocks
      }
    };

    let res;
    if (form.id) {
      res = await axios.put(`/api/sections/${form.id}`, payload);
    } else {
      res = await axios.post('/api/sections', payload);
      if (res.data?.data?.id) {
        form.id = res.data.data.id;
        router.replace({ name: 'EditSectionBuilder', params: { id: form.id } });
      }
    }
    toast.success('Section saved successfully!');
  } catch (err) {
    console.error(err);
    toast.error('Error saving section. Please check requirements.');
  } finally {
    saving.value = false;
  }
}

// Keyboard shortcuts listener
function handleKeyDown(e) {
  const isMac = typeof navigator !== 'undefined' && /Mac|iPod|iPhone|iPad/.test(navigator.platform);
  const modifier = isMac ? e.metaKey : e.ctrlKey;
  const activeEl = document.activeElement;
  const isInputActive = activeEl && (
    activeEl.tagName === 'INPUT' ||
    activeEl.tagName === 'TEXTAREA' ||
    activeEl.isContentEditable ||
    activeEl.classList?.contains('form-control')
  );

  // 1. Save Section: Ctrl+S / Cmd+S
  if (modifier && (e.key === 's' || e.key === 'S')) {
    e.preventDefault();
    saveSection();
    return;
  }

  // 2. Undo / Redo: Ctrl+Z / Ctrl+Y / Ctrl+Shift+Z
  if (modifier && (e.key === 'z' || e.key === 'Z')) {
    if (e.shiftKey) {
      e.preventDefault();
      redo();
    } else {
      if (!isInputActive) {
        e.preventDefault();
        undo();
      }
    }
    return;
  }

  if (modifier && (e.key === 'y' || e.key === 'Y')) {
    e.preventDefault();
    redo();
    return;
  }

  // 3. Duplicate: Ctrl+D / Cmd+D
  if (modifier && (e.key === 'd' || e.key === 'D')) {
    if (selectedBlockId.value) {
      e.preventDefault();
      duplicateSelectedBlock();
    }
    return;
  }

  // 4. Delete: Delete / Backspace (when not in an input field)
  if ((e.key === 'Delete' || e.key === 'Backspace') && !isInputActive) {
    if (selectedBlockId.value) {
      e.preventDefault();
      deleteSelectedBlock();
    }
    return;
  }

  // 5. Escape: Close modals, context menu, or deselect
  if (e.key === 'Escape') {
    if (contextMenu.show) {
      closeContextMenu();
      return;
    }
    if (showShortcutsModal.value) {
      showShortcutsModal.value = false;
    } else if (showTemplateModal.value) {
      showTemplateModal.value = false;
    } else if (showGlobalSettingsModal.value) {
      showGlobalSettingsModal.value = false;
    } else if (showInserterModal.value) {
      showInserterModal.value = false;
    } else if (showBgMediaModal.value) {
      showBgMediaModal.value = false;
    } else if (selectedBlockId.value) {
      selectedBlockId.value = null;
    }
    return;
  }

  // 6. Toggle Topbar Collapse: Ctrl+B / Cmd+B
  if (modifier && (e.key === 'b' || e.key === 'B')) {
    if (!isInputActive) {
      e.preventDefault();
      toggleTopbar();
      toast.info(isTopbarCollapsed.value ? 'Top bar collapsed (Full Canvas)' : 'Top bar expanded');
      return;
    }
  }

  // 7. Help: ?
  if (e.key === '?' && !isInputActive) {
    e.preventDefault();
    showShortcutsModal.value = !showShortcutsModal.value;
  }
}

let hadSidebarCollapse = false;

onMounted(() => {
  // Collapse main admin sidebar by default on builder page for full-screen workspace
  hadSidebarCollapse = document.body.classList.contains('sidebar-collapse');
  document.body.classList.add('sidebar-collapse');

  loadSection();
  window.addEventListener('keydown', handleKeyDown);
  window.addEventListener('click', closeContextMenu);
  window.addEventListener('pointerdown', onGlobalPointerDown, true);
  try {
    if (localStorage.getItem('aire_builder_topbar_collapsed') === '1') {
      isTopbarCollapsed.value = true;
    }
  } catch (e) {}
});

onBeforeUnmount(() => {
  window.removeEventListener('keydown', handleKeyDown);
  window.removeEventListener('click', closeContextMenu);
  window.removeEventListener('pointerdown', onGlobalPointerDown, true);
  // Restore sidebar state when leaving builder
  if (!hadSidebarCollapse) {
    document.body.classList.remove('sidebar-collapse');
  }
});
</script>

<style scoped>
/* ==========================================================================
   Bootstrap 4 Compatibility Layer for AdminLTE
   ========================================================================== */
.gap-1 { gap: 0.25rem !important; }
.gap-2 { gap: 0.5rem !important; }
.gap-3 { gap: 1rem !important; }
.gap-4 { gap: 1.5rem !important; }
.rounded-4 { border-radius: 16px !important; }
.rounded-3 { border-radius: 12px !important; }
.rounded-2 { border-radius: 8px !important; }
.text-start { text-align: left !important; }
.text-end { text-align: right !important; }
.shadow-2xs { box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important; }

/* Grid Gutter fallbacks for BS4 */
.row.g-2 { margin-right: -6px; margin-left: -6px; }
.row.g-2 > [class*="col"] { padding-right: 6px; padding-left: 6px; }
.row.g-3 { margin-right: -10px; margin-left: -10px; }
.row.g-3 > [class*="col"] { padding-right: 10px; padding-left: 10px; }
.row.g-4 { margin-right: -15px; margin-left: -15px; }
.row.g-4 > [class*="col"] { padding-right: 15px; padding-left: 15px; }

/* ==========================================================================
   Section Builder Layout & Scrollbar Management
   ========================================================================== */
.section-builder-page {
  height: calc(100vh - 76px);
  min-height: 600px;
  display: flex;
  flex-direction: column;
  position: relative;
  background: #f8fafc;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
}

/* ==========================================================================
   Builder Top Bar Styling (Clean, Compact, No Scrollbar)
   ========================================================================== */
.builder-top-bar {
  min-height: 52px !important;
  height: auto !important;
  background-color: #ffffff;
  padding: 6px 16px !important;
  display: flex !important;
  align-items: center !important;
  flex-wrap: wrap !important;
  gap: 8px;
  box-sizing: border-box;
  overflow: visible !important;
  transition: all 0.25s ease;
}

.builder-top-bar .btn,
.builder-top-bar a.btn {
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  white-space: nowrap !important;
  line-height: 1 !important;
  font-size: 13px;
  flex-shrink: 0;
  border-radius: 8px;
}

.builder-top-bar .btn-group {
  display: inline-flex !important;
  align-items: center !important;
  flex-shrink: 0;
}

.builder-top-bar .section-title-input {
  font-size: 0.88rem;
  border-radius: 6px;
  transition: background-color 0.15s ease, box-shadow 0.15s ease;
}

.builder-top-bar .section-title-input:focus {
  background-color: #ffffff !important;
  box-shadow: 0 0 0 2px rgba(0, 149, 218, 0.2) !important;
}

.builder-top-bar .section-title-input {
  width: 190px !important;
  height: 32px !important;
  font-size: 13px !important;
}

.builder-top-bar .section-name-badge {
  max-width: 150px !important;
  overflow: hidden !important;
  text-overflow: ellipsis !important;
  white-space: nowrap !important;
}

/* ==========================================================================
   Configuration Modal Tabs & Extended Spacing Utilities
   ========================================================================== */
.config-modal-tabs .nav-link {
  color: #64748b;
  border: none;
  border-bottom: 2px solid transparent;
  padding: 8px 16px;
  font-size: 13px;
  transition: all 0.2s ease;
}

.config-modal-tabs .nav-link:hover {
  color: #0095DA;
  border-bottom-color: #cbd5e1;
}

.config-modal-tabs .nav-link.active {
  color: #0095DA !important;
  background: transparent !important;
  border-bottom: 2px solid #0095DA !important;
}

/* Extended Spacing utilities for Admin preview canvas */
.py-6 { padding-top: 5rem !important; padding-bottom: 5rem !important; }
.py-7 { padding-top: 6.5rem !important; padding-bottom: 6.5rem !important; }
.py-8 { padding-top: 8rem !important; padding-bottom: 8rem !important; }

.builder-workspace {
  flex: 1 1 0%;
  min-height: 0;
  height: 100%;
  display: flex;
  overflow: hidden;
  position: relative;
}

.bg-canvas {
  background-color: #f1f5f9;
}

/* Outer Viewport (Desktop Scroll & Canvas Container) */
.builder-canvas-viewport {
  flex: 1 1 0%;
  min-height: 0;
  height: 100%;
  overflow-y: auto;
  overflow-x: hidden;
  padding: 24px 20px 80px 20px;
  display: flex;
  justify-content: center;
  align-items: flex-start;
}

/* In Tablet & Mobile mode, disable outer viewport scroll so ONLY the device screen scrolls */
.builder-canvas-viewport.viewport-device-mode {
  overflow: hidden !important;
  padding: 16px !important;
  align-items: center !important;
}

/* Canvas Frame Base */
.canvas-frame {
  background: #ffffff;
  min-height: 480px;
  margin-bottom: 50px;
  position: relative;
  transition: width 0.25s ease, max-height 0.25s ease;
  box-sizing: border-box;
}

.canvas-frame.canvas-transparent-bg {
  background-color: transparent !important;
  background-image:
    linear-gradient(45deg, #e2e8f0 25%, transparent 25%),
    linear-gradient(-45deg, #e2e8f0 25%, transparent 25%),
    linear-gradient(45deg, transparent 75%, #e2e8f0 75%),
    linear-gradient(-45deg, transparent 75%, #e2e8f0 75%) !important;
  background-size: 16px 16px !important;
  background-position: 0 0, 0 8px, 8px -8px, -8px 0px !important;
}

/* Desktop Preview Frame */
.frame-desktop {
  width: 100% !important;
  max-width: 1140px !important;
  height: auto !important;
  border: none !important;
  border-radius: 12px !important;
  overflow: visible !important;
}

/* Tablet Preview Mockup (768px) */
.frame-tablet {
  width: 768px !important;
  max-width: 100% !important;
  border: 10px solid #1e293b !important;
  border-radius: 28px !important;
  box-shadow: 0 20px 60px rgba(15, 23, 42, 0.25) !important;
  height: calc(100vh - 160px) !important;
  max-height: 820px !important;
  overflow-y: auto !important; /* Internal Tablet Screen Scrollbar */
  overflow-x: hidden !important;
  margin-bottom: 0 !important;
}

/* Mobile Preview Mockup (375px) */
.frame-mobile {
  width: 380px !important;
  max-width: 100% !important;
  border: 10px solid #1e293b !important;
  border-radius: 36px !important;
  box-shadow: 0 20px 60px rgba(15, 23, 42, 0.3) !important;
  height: calc(100vh - 160px) !important;
  max-height: 760px !important;
  overflow-y: auto !important; /* Internal Phone Screen Scrollbar */
  overflow-x: hidden !important;
  margin-bottom: 0 !important;
}

/* Clean, Sleek & Modern Scrollbars */
.builder-canvas-viewport::-webkit-scrollbar,
.frame-mobile::-webkit-scrollbar,
.frame-tablet::-webkit-scrollbar,
.nested-column-canvas::-webkit-scrollbar {
  width: 7px !important;
  height: 7px !important;
}

.builder-canvas-viewport::-webkit-scrollbar-track,
.frame-mobile::-webkit-scrollbar-track,
.frame-tablet::-webkit-scrollbar-track {
  background: transparent !important;
}

.builder-canvas-viewport::-webkit-scrollbar-thumb,
.frame-mobile::-webkit-scrollbar-thumb,
.frame-tablet::-webkit-scrollbar-thumb {
  background: #cbd5e1 !important;
  border-radius: 4px !important;
}

.builder-canvas-viewport::-webkit-scrollbar-thumb:hover,
.frame-mobile::-webkit-scrollbar-thumb:hover,
.frame-tablet::-webkit-scrollbar-thumb:hover {
  background: #94a3b8 !important;
}

/* Firefox Scrollbars */
.builder-canvas-viewport,
.frame-mobile,
.frame-tablet {
  scrollbar-width: thin;
  scrollbar-color: #cbd5e1 transparent;
}

.device-bezel-header {
  border-bottom: 2px solid rgba(255, 255, 255, 0.1);
  position: sticky;
  top: 0;
  z-index: 20;
}

.builder-block-card {
  border: 1px dashed transparent;
  transition: all 0.2s ease;
}

.builder-block-card:hover {
  border-color: #cbd5e1;
}

.block-selected {
  border: 2px solid #0095DA !important;
  box-shadow: 0 0 0 3px rgba(0, 149, 218, 0.15);
}

.block-floating-tools {
  position: absolute;
  top: -14px;
  right: 12px;
  z-index: 10;
  opacity: 0;
  transition: opacity 0.2s ease;
}

.builder-block-card:hover .block-floating-tools,
.block-selected .block-floating-tools {
  opacity: 1;
}

.ghost-main-block {
  opacity: 0.35;
  border: 2px dashed #0095DA !important;
  background: #e0f2fe;
}

/* ==========================================================================
   Photoshop-Style Floating & Draggable Panels
   ========================================================================== */
.floating-builder-panel {
  position: absolute;
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  box-shadow: 0 16px 48px rgba(15, 23, 42, 0.22), 0 0 0 1px rgba(0, 0, 0, 0.08) !important;
  user-select: auto;
  transition: box-shadow 0.2s ease;
}

.floating-builder-panel:hover {
  box-shadow: 0 20px 52px rgba(15, 23, 42, 0.28), 0 0 0 1px rgba(0, 149, 218, 0.3) !important;
}

.floating-layers-panel {
  width: 300px;
  max-width: 90vw;
  height: 560px;
  max-height: calc(100% - 32px);
}

.floating-inspector-panel {
  width: 360px;
  max-width: 95vw;
  height: 640px;
  max-height: calc(100% - 32px);
}

.floating-builder-panel.panel-minimized {
  height: auto !important;
  max-height: 40px !important;
  box-shadow: 0 6px 20px rgba(15, 23, 42, 0.16), 0 0 0 1px rgba(0, 0, 0, 0.08) !important;
}

.floating-panel-header {
  height: 38px;
  min-height: 38px;
  background: #1e293b !important;
  cursor: grab;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.floating-panel-header:active {
  cursor: grabbing;
}

.floating-panel-header .drag-indicator {
  opacity: 0.5;
  cursor: grab;
}

.floating-panel-header .window-ctrl-btn {
  border-radius: 4px;
  width: 22px;
  height: 22px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: all 0.15s ease;
}

.floating-panel-header .window-ctrl-btn:hover {
  background-color: rgba(255, 255, 255, 0.2) !important;
  color: #ffffff !important;
}

.floating-panel-body {
  background: #ffffff;
  min-height: 0;
  height: calc(100% - 38px);
}

/* Smooth Fade & Scale Transition for Floating Panels */
.fade-scale-enter-active,
.fade-scale-leave-active {
  transition: opacity 0.2s cubic-bezier(0.16, 1, 0.3, 1), transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.fade-scale-enter-from,
.fade-scale-leave-to {
  opacity: 0;
  transform: scale(0.96);
}

/* In-Canvas Hover Add Between Strip */
.canvas-add-between-line {
  position: relative;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0.12;
  transition: opacity 0.2s ease;
}

.canvas-add-between-line::before {
  content: '';
  position: absolute;
  left: 3%;
  right: 3%;
  top: 50%;
  height: 2px;
  background-color: #0095da;
  transform: translateY(-50%);
  border-radius: 1px;
}

.canvas-add-between-line:hover {
  opacity: 1;
}

.canvas-add-between-line .add-between-btn {
  width: 22px;
  height: 22px;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.65rem;
  z-index: 2;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.canvas-add-between-line:hover .add-between-btn {
  transform: scale(1.15);
  box-shadow: 0 2px 8px rgba(0, 149, 218, 0.4) !important;
}

.border-dashed {
  border: 2px dashed #cbd5e1 !important;
}

/* ==========================================================================
   Topbar Collapsible Transitions & Styling
   ========================================================================== */
.builder-top-bar.topbar-collapsed {
  height: 38px !important;
  min-height: 38px !important;
  padding: 0 16px !important;
  background-color: #f8fafc !important;
  border-bottom: 1px solid #e2e8f0 !important;
  flex-wrap: nowrap !important;
  gap: 0;
}

/* ==========================================================================
   Right-Click Context Menu
   ========================================================================== */
.builder-context-backdrop {
  position: fixed;
  inset: 0;
  z-index: 1075;
  background: transparent;
}

.builder-context-menu {
  position: fixed;
  width: 205px;
  background: #ffffff;
  border-radius: 10px;
  box-shadow: 0 16px 36px rgba(15, 23, 42, 0.2), 0 0 0 1px rgba(0, 0, 0, 0.08) !important;
  user-select: none;
  z-index: 1080 !important;
}

.builder-context-menu .dropdown-item {
  cursor: pointer;
  transition: background-color 0.15s ease, color 0.15s ease;
  font-size: 0.82rem;
  border-radius: 6px;
  margin: 0 4px;
  width: calc(100% - 8px);
}

.builder-context-menu .dropdown-item:hover:not(:disabled) {
  background-color: #f1f5f9;
}

.builder-context-menu .dropdown-item.text-danger:hover:not(:disabled) {
  background-color: #fee2e2;
  color: #dc2626 !important;
}
</style>
