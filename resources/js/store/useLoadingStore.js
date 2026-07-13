import { defineStore } from 'pinia'

/**
 * Pinia store for managing global loading state.
 *
 * Tracks whether an operation is in progress, displays a custom message,
 * and optionally shows progress percentage.
 */
export const useLoadingStore = defineStore('loading', {
  state: () => ({
    isLoading: false,  // true when loading/active
    message: null,     // optional loading message
    progress: 0        // progress value (0-100)
  }),
  actions: {
    /**
     * Start loading indicator
     * @param {string} message - Custom message to display (default: 'Processing...')
     */
    start(message = 'Processing...') {
      this.isLoading = true
      this.message = message
      this.progress = 0
    },
    /**
     * Update progress value
     * @param {number} value - Progress percentage (0-100)
     */
    setProgress(value) {
      this.progress = value
    },
    /**
     * Stop loading indicator and reset state
     */
    stop() {
      this.isLoading = false
      this.message = null
      this.progress = 0
    }
  }
})
