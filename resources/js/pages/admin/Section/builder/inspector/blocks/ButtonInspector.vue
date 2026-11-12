<template>
  <div class="button-inspector">
    <!-- CONTENT TAB -->
    <div v-if="activeTab === 'content'">
      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Button Label</label>
        <input
          v-model="settings.text"
          type="text"
          class="form-control form-control-sm"
          placeholder="e.g. Explore Technology"
        />
      </div>

      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Destination Link URL</label>
        <input
          v-model="settings.url"
          type="text"
          class="form-control form-control-sm"
          placeholder="/shop, https://..., or #features"
        />
      </div>

      <div class="custom-control custom-checkbox mb-3">
        <input
          type="checkbox"
          v-model="settings.target_blank"
          class="custom-control-input"
          :id="'btnTargetBlankCheck_' + block.id"
        />
        <label class="custom-control-label small" :for="'btnTargetBlankCheck_' + block.id">
          Open link in new tab (target="_blank")
        </label>
      </div>

      <!-- Button Icon Selector -->
      <div class="form-group mb-2">
        <label class="small font-weight-bold text-dark">Button Icon</label>
        <div class="input-group input-group-sm">
          <select v-model="settings.icon" class="form-control form-control-sm">
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
          <div class="input-group-append" v-if="settings.icon">
            <span class="input-group-text bg-light"><i :class="settings.icon"></i></span>
          </div>
        </div>
      </div>

      <div class="form-group mb-2" v-if="settings.icon">
        <label class="small font-weight-bold text-dark">Icon Position</label>
        <div class="btn-group btn-group-sm w-100">
          <button
            type="button"
            class="btn"
            :class="(settings.iconPos || 'right') === 'left' ? 'btn-primary' : 'btn-outline-secondary'"
            @click="settings.iconPos = 'left'"
          >
            Left Side
          </button>
          <button
            type="button"
            class="btn"
            :class="(settings.iconPos || 'right') === 'right' ? 'btn-primary' : 'btn-outline-secondary'"
            @click="settings.iconPos = 'right'"
          >
            Right Side
          </button>
        </div>
      </div>

      <!-- Scope Alignment -->
      <AlignmentControl :settings="settings" :scope-mode="scopeMode" />
    </div>

    <!-- STYLE TAB -->
    <div v-else-if="activeTab === 'style'">
      <div class="card border rounded-3 p-3 mb-3 bg-light">
        <h6 class="small font-weight-bold text-dark mb-2">
          <i class="fas fa-palette mr-1 text-primary"></i> Button Appearance
        </h6>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Size</label>
          <select v-model="settings.size" class="form-control form-control-sm">
            <option value="btn-sm">Small Button (btn-sm)</option>
            <option value="btn-md">Medium Button (Standard)</option>
            <option value="btn-lg">Large Button (btn-lg)</option>
          </select>
        </div>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Style Variant</label>
          <select v-model="settings.variant" class="form-control form-control-sm">
            <option value="btn-primary">Primary Solid</option>
            <option value="btn-outline-primary">Primary Outline</option>
            <option value="btn-dark">Dark Solid</option>
            <option value="btn-outline-dark">Dark Outline</option>
            <option value="btn-light border">Light Solid</option>
            <option value="btn-success">Success Solid</option>
          </select>
        </div>

        <!-- Custom Color Overrides -->
        <ColorPickerControl
          label="Custom Background (Override)"
          v-model="settings.customBgColor"
          placeholder="e.g. #0095DA"
        />

        <ColorPickerControl
          label="Custom Text Color"
          v-model="settings.customTextColor"
          placeholder="e.g. #ffffff"
        />

        <div class="row">
          <div class="col-6">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-dark">Shape</label>
              <select v-model="settings.rounded" class="form-control form-control-sm">
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
              <select v-model="settings.shadow" class="form-control form-control-sm">
                <option value="">None</option>
                <option value="shadow-sm">Soft</option>
                <option value="shadow">Medium</option>
                <option value="shadow-lg">Floating</option>
              </select>
            </div>
          </div>
        </div>

        <div class="custom-control custom-checkbox mb-0">
          <input
            type="checkbox"
            v-model="settings.fullWidthMobile"
            class="custom-control-input"
            :id="'btnFullWidthMobileCheck_' + block.id"
          />
          <label class="custom-control-label small" :for="'btnFullWidthMobileCheck_' + block.id">
            Full Width on Mobile (100% block)
          </label>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import AlignmentControl from '../common/AlignmentControl.vue';
import ColorPickerControl from '../common/ColorPickerControl.vue';

defineProps({
  block: {
    type: Object,
    required: true
  },
  settings: {
    type: Object,
    required: true
  },
  activeTab: {
    type: String,
    default: 'content'
  },
  scopeMode: {
    type: String,
    default: 'desktop'
  }
});
</script>
