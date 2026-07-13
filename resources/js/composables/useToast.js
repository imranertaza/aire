import { toast } from "vue3-toastify";

/**
 * Composable for centralized toast notifications
 * @returns {object} Toast helper methods
 */
export function useToast() {
    return {
        /**
         * Show success toast
         */
        success: (msg) => toast.success(msg),

        /**
         * Show error toast
         */
        error: (msg) => toast.error(msg),

        /**
         * Show info toast
         */
        info: (msg) => toast.info(msg),

        /**
         * Show warning toast
         */
        warn: (msg) => toast.warn(msg),

        /**
         * Handle validation/form errors (422) and generic API errors
         */
        validationError: (error) => {
            // Custom message from backend
            if (error.response?.data?.message) {
                toast.error(error.response.data.message);
            }
            // Laravel validation errors (422)
            else if (
                error?.response?.status === 422 &&
                error.response?.data?.errors
            ) {
                const errors = error.response.data.errors;
                Object.values(errors).forEach((messages) => {
                    messages.forEach((msg) => toast.error(msg));
                });
            }
            // Fallback error message
            else {
                toast.error(error?.message || "Something went wrong");
            }
        },
    };
}
