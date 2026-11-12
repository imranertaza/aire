<template>
  <div class="accordion-inspector">
    <!-- CONTENT TAB -->
    <div v-if="activeTab === 'content'">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <span class="small font-weight-bold text-dark">FAQ Items ({{ (settings.items || []).length }})</span>
        <button type="button" class="btn btn-xs btn-primary font-weight-bold shadow-2xs" @click="addAccordionItem">
          <i class="fas fa-plus mr-1"></i> Add Question
        </button>
      </div>

      <div v-if="!settings.items || !settings.items.length" class="text-center py-3 text-muted bg-light rounded border mb-3">
        <small>No questions yet. Click "Add Question" above.</small>
      </div>

      <div v-else class="accordion-items-list mb-3">
        <div
          v-for="(item, idx) in settings.items"
          :key="item.id || idx"
          class="card border rounded-3 p-2 mb-2 bg-light shadow-2xs"
        >
          <div class="d-flex align-items-center justify-content-between mb-1">
            <span class="badge badge-secondary" style="font-size: 0.65rem;">#{{ idx + 1 }}</span>
            <div class="btn-group btn-group-xs">
              <button
                type="button"
                class="btn btn-xs text-muted p-1"
                :disabled="idx === 0"
                @click="moveAccordionItem(idx, -1)"
                title="Move Up"
              >
                <i class="fas fa-chevron-up"></i>
              </button>
              <button
                type="button"
                class="btn btn-xs text-muted p-1"
                :disabled="idx === settings.items.length - 1"
                @click="moveAccordionItem(idx, 1)"
                title="Move Down"
              >
                <i class="fas fa-chevron-down"></i>
              </button>
              <button
                type="button"
                class="btn btn-xs text-danger p-1 ml-1"
                @click="deleteAccordionItem(idx)"
                title="Remove Question"
              >
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
          <select v-model="settings.style" class="form-control form-control-sm">
            <option value="separated">Separated Cards (Modern Floating)</option>
            <option value="bordered">Bordered Box (Classic Panel)</option>
            <option value="flush">Flush Minimal (Borderless)</option>
          </select>
        </div>

        <div class="form-group mb-2">
          <label class="small font-weight-bold text-dark">Indicator Icon</label>
          <select v-model="settings.icon_type" class="form-control form-control-sm">
            <option value="chevron">Chevron Arrow</option>
            <option value="plus_minus">Plus / Minus (+ / −)</option>
          </select>
        </div>

        <div class="custom-control custom-switch mb-2">
          <input
            type="checkbox"
            v-model="settings.first_open"
            class="custom-control-input"
            :id="'accFirstOpenSwitch_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'accFirstOpenSwitch_' + block.id">
            Open 1st Item by Default
          </label>
        </div>

        <div class="custom-control custom-switch mb-0">
          <input
            type="checkbox"
            v-model="settings.allow_multiple"
            class="custom-control-input"
            :id="'accMultipleSwitch_' + block.id"
          />
          <label class="custom-control-label small font-weight-bold" :for="'accMultipleSwitch_' + block.id">
            Allow Multiple Open at Once
          </label>
        </div>
      </div>
    </div>

    <!-- STYLE TAB -->
    <div v-else-if="activeTab === 'style'">
      <div class="alert alert-light border small text-muted text-center py-3">
        <i class="fas fa-info-circle mr-1 text-primary"></i>
        Accordion visual layout and behavior styles are configured under Content.
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
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
  }
});

function addAccordionItem() {
  if (!props.settings.items) props.settings.items = [];
  const nextIdx = props.settings.items.length + 1;
  props.settings.items.push({
    id: 'item_' + Date.now(),
    title: `Question #${nextIdx}`,
    content: 'Answer content details for this question.'
  });
}

function deleteAccordionItem(index) {
  if (!props.settings.items) return;
  props.settings.items.splice(index, 1);
}

function moveAccordionItem(index, direction) {
  if (!props.settings.items) return;
  const newIndex = index + direction;
  if (newIndex < 0 || newIndex >= props.settings.items.length) return;
  const item = props.settings.items.splice(index, 1)[0];
  props.settings.items.splice(newIndex, 0, item);
}
</script>

