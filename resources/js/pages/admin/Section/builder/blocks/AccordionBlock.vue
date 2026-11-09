<template>
  <div
    :id="s.customId || undefined"
    class="block-render-accordion"
    :class="[
      s.customClass,
      {
        'd-none d-md-block': s.hideMobile,
        'd-md-none d-lg-block': s.hideTablet,
        'd-lg-none': s.hideDesktop
      }
    ]"
    :style="wrapperStyles"
  >
    <div
      class="builder-accordion"
      :class="[
        s.style === 'bordered' ? 'accordion-bordered border rounded-3 overflow-hidden bg-white' : (s.style === 'flush' ? 'accordion-flush' : 'accordion-separated')
      ]"
    >
      <div
        v-for="(item, idx) in itemsList"
        :key="item.id || idx"
        class="accordion-item"
        :class="{
          'border-0 shadow-2xs rounded-3 mb-2 overflow-hidden bg-white': s.style !== 'bordered' && s.style !== 'flush',
          'border-top-0': s.style === 'bordered' && idx === 0
        }"
      >
        <!-- Item Header Button -->
        <div
          class="accordion-header p-3 d-flex align-items-center justify-content-between cursor-pointer user-select-none"
          :class="{
            'bg-light text-primary': isItemOpen(idx),
            'bg-white text-dark': !isItemOpen(idx)
          }"
          @click="toggleItem(idx)"
        >
          <span class="font-weight-bold" style="font-size: 0.95rem;">
            {{ item.title || ('Question #' + (idx + 1)) }}
          </span>

          <span class="accordion-toggle-icon ml-2 text-secondary">
            <template v-if="s.icon_type === 'plus_minus'">
              <span class="font-weight-bold" style="font-size: 1.1rem; line-height: 1;">
                {{ isItemOpen(idx) ? '−' : '+' }}
              </span>
            </template>
            <template v-else>
              <i
                class="fas fa-chevron-down transition-transform"
                :class="{ 'rotate-180 text-primary': isItemOpen(idx) }"
              ></i>
            </template>
          </span>
        </div>

        <!-- Item Collapse Body -->
        <div
          v-show="isItemOpen(idx)"
          class="accordion-body p-3 bg-white text-secondary small border-top"
          style="line-height: 1.6;"
        >
          {{ item.content || 'Detailed answer content goes here. You can customize this question and answer in the right-side inspector panel.' }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';

const props = defineProps({
  block: {
    type: Object,
    required: true
  }
});

const s = computed(() => props.block.settings || props.block);

const itemsList = computed(() => {
  if (Array.isArray(s.value.items) && s.value.items.length) {
    return s.value.items;
  }
  return [
    { id: '1', title: 'How often do filters need to be replaced?', content: 'Filters typically should be replaced every 6 to 12 months depending on ambient air quality and daily operating hours.' },
    { id: '2', title: 'What is the recommended coverage area?', content: 'Our standard unit purifies up to 800 sq ft within 30 minutes with high efficiency particulate retention.' },
    { id: '3', title: 'Is warranty coverage included with purchase?', content: 'Yes, all units include a 2-year full manufacturer warranty with 24/7 dedicated customer care.' }
  ];
});

const openIndexes = ref(new Set([0]));

// Watch first_open prop
watch(() => s.value.first_open, (val) => {
  if (val === false) {
    openIndexes.value.clear();
  } else if (!openIndexes.value.size) {
    openIndexes.value.add(0);
  }
}, { immediate: true });

function isItemOpen(idx) {
  return openIndexes.value.has(idx);
}

function toggleItem(idx) {
  if (openIndexes.value.has(idx)) {
    openIndexes.value.delete(idx);
  } else {
    if (!s.value.allow_multiple) {
      openIndexes.value.clear();
    }
    openIndexes.value.add(idx);
  }
}

const wrapperStyles = computed(() => {
  const styles = {};
  if (s.value.marginTop) styles.marginTop = s.value.marginTop;
  if (s.value.marginBottom) styles.marginBottom = s.value.marginBottom;
  return styles;
});
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
.rotate-180 {
  transform: rotate(180deg);
}
.transition-transform {
  transition: transform 0.2s ease;
}
.shadow-2xs {
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}
.accordion-separated .accordion-item {
  border: 1px solid #e2e8f0;
}
</style>
