import { toast } from "vue3-toastify";

/**
 * Composable for centralized toast notifications
 * @returns {{
 *   success: (msg: string) => any,
 *   error: (msg: string) => any,
 *   info: (msg: string) => any,
 *   warn: (msg: string) => any,
 *   validationError: (error: any) => void
 * }} Toast helper methods
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
         * @param {any} error
         */
        validationError: (error) => {
            // Laravel validation errors (422)
            if (
                error?.response?.status === 422 &&
                error.response?.data?.errors
            ) {
                /** @type {Record<string, string[]>} */
                const errors = error.response.data.errors;
                Object.values(errors).forEach((messages) => {
                    if (Array.isArray(messages)) {
                        messages.forEach((/** @type {string} */ msg) => toast.error(msg));
                    } else if (typeof messages === "string") {
                        toast.error(messages);
                    }
                });
            }
            // Custom message from backend
            else if (error?.response?.data?.message) {
                toast.error(error.response.data.message);
            }
            // Fallback error message
            else {
                toast.error(error?.message || "Something went wrong");
            }
        },
    };
}
