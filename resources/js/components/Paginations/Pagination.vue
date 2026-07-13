<template>
  <div v-if="pData?.last_page > 1" class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
    <!-- Showing info -->
    <div>
      <small>
        Showing {{ pData.from }} to {{ pData.to }} of {{ pData.total }} results
      </small>
    </div>

    <!-- Pagination links -->
    <nav aria-label="Page navigation" v-if="pData.links?.length">
      <ul class="pagination pagination-sm mb-0">
        <li
          v-for="(link, index) in pData.links"
          :key="index"
          class="page-item"
          :class="{ active: link.active, disabled: !link.url }"
        >
          <a
            class="page-link"
            href="#"
                v-html="index === 0 ? '&laquo;' : (index === pData.links.length - 1 ? '&raquo;' : link.label)"
            @click.prevent="handleClick(link)"
          ></a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
/**
 * Props:
 * pData: Pagination data object (typically from Laravel's LengthAwarePaginator)
 *        Expected structure: { current_page, data, links: [{ url, label, active }, ...], ... }
 */
const props = defineProps({
  pData: {
    type: Object,
    required: true
  }
})

// Emit custom event when user clicks a pagination link
const emit = defineEmits(['page-change'])

/**
 * Handle pagination link click
 * Extracts page number from the link URL and emits it to parent
 * Skips if link is null (disabled) or already active
 */
const handleClick = (link) => {
  if (!link.url || link.active) return

  // Create full URL to safely parse query params (link.url is relative, e.g. "?page=3")
  const url = new URL(link.url, window.location.origin)
  const page = url.searchParams.get('page')

  if (page) {
    emit('page-change', Number(page))
  }
}
</script>
