import { ref } from 'vue';
import axios from 'axios';

/**
 * Composable for handling paginated data from an API
 * @param {string} apiEndpoint - Base API URL (e.g., '/api/posts')
 * @param {number} perPage - Number of items per page (default: 10)
 * @returns {object} Pagination state and fetch method
 */
export function usePagination(apiEndpoint, perPage = 10) {
  // List of items for the current page
  const data = ref([]);

  // Full pagination meta (links, total, current_page, etc.)
  const pagination = ref({});

  // Current active page number
  const currentPage = ref(1);

  // Loading state during fetch
  const isLoading = ref(false);

  /**
   * Fetch a specific page of data
   * @param {number} page - Page number to load (defaults to 1)
   */
  const fetchPage = async (page = 1) => {
    isLoading.value = true;
    try {
      const res = await axios.get(`${apiEndpoint}?page=${page}&per_page=${perPage}`);
      data.value = res.data.data;              // Array of current page items
      pagination.value = res.data;              // Full pagination object
      currentPage.value = res.data.current_page;
    } catch (err) {
      console.error('Pagination fetch failed:', err);
    } finally {
      isLoading.value = false;
    }
  };

  return {
    data,
    pagination,
    currentPage,
    isLoading,
    fetchPage
  };
}
