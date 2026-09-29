import axios from "axios";
import { inject } from "vue";
import { useToast } from "./useToast";

/**
 * Reusable composable for SweetAlert2 delete confirmation with automatic API call & error handling.
 * Follows DRY principles to eliminate repetitive delete boilerplate across all admin components.
 */
export function useConfirmDelete() {
    const toast = useToast();
    const $swal = inject("$swal");

    /**
     * Confirm and execute item deletion.
     *
     * @param {Object} options
     * @param {string} options.url - The API endpoint URL (e.g., '/api/color-families/1')
     * @param {string} [options.title] - Name or title of the item to display in dialog
     * @param {Function|null} [options.onSuccess] - Callback executed upon successful deletion
     * @param {string} [options.successMessage] - Custom success toast message
     * @returns {Promise<boolean>} True if deleted, false if cancelled or failed
     */
    const confirmDelete = async ({
        url,
        title = "this item",
        onSuccess = null,
        successMessage = "Item deleted successfully!"
    }) => {
        if (!$swal) {
            // Fallback to native confirmation if Swal is not injected
            if (!window.confirm(`Are you sure you want to delete "${title}"?`)) {
                return false;
            }
        } else {
            const result = await $swal({
                title: `Delete "${title}"?`,
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete",
                cancelButtonText: "Cancel",
                reverseButtons: true,
                focusCancel: true
            });

            if (!result.isConfirmed) {
                toast.info("Deletion cancelled.");
                return false;
            }
        }

        try {
            await axios.delete(url);
            toast.success(successMessage);
            if (typeof onSuccess === "function") {
                onSuccess();
            }
            return true;
        } catch (error) {
            toast.validationError(error);
            return false;
        }
    };

    return {
        confirmDelete
    };
}
