import { computed } from "vue";

/**
 * Truncate text to a maximum length and add suffix if needed
 */
export function truncateText(text = "", maxLength = 100, suffix = "...") {
    if (typeof text !== "string") return "";
    return text.length > maxLength ? text.slice(0, maxLength) + suffix : text;
}

/**
 * Generate a secure and reliable URL for an image stored in public storage.
 * Mirrors helper.php getImageUrl logic.
 *
 * - Returns a fallback default image if path is empty or invalid.
 * - Returns the original URL if it's already absolute (http/https), ignoring placeholders.
 * - Normalizes public and storage relative paths.
 *
 * @param {string|null} path The relative path from storage or absolute URL
 * @returns {string} The full accessible image URL
 */
export function getImageUrl(path) {
    const fallbackImage = "/themes/default/assets/img/airpro_mask_fb2.png";

    // Fallback if no path provided
    if (!path || typeof path !== "string" || path.trim() === "") {
        return fallbackImage;
    }

    const trimmedPath = path.trim();

    // If already an absolute URL
    if (/^https?:\/\//i.test(trimmedPath)) {
        if (trimmedPath.includes("placehold.co") || trimmedPath.includes("placeholder")) {
            return fallbackImage;
        }
        return trimmedPath;
    }

    // Normalize path
    const normalized = trimmedPath.replace(/^\/+/, "");

    // Check if path points directly to public asset folders or starts with storage/
    if (
        normalized.startsWith("themes/") ||
        normalized.startsWith("assets/") ||
        normalized.startsWith("images/") ||
        normalized.startsWith("packages/") ||
        normalized.startsWith("build/") ||
        normalized.startsWith("storage/")
    ) {
        return `/${normalized}`;
    }

    // Default to storage directory
    return `/public/storage/${normalized}`;
}

/**
 * Generate URL-friendly slug from title
 */
export const generateSlug = (title) => {
    return title
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, "") // remove special chars
        .replace(/\s+/g, "-") // spaces to dashes
        .replace(/-+/g, "-") // collapse multiple dashes
        .replace(/^-+|-+$/g, ""); // trim dashes from start/end
};

/**
 * Get the relative or absolute path for an image.
 * Mirrors helper.php getImagePath logic.
 *
 * @param {string|null} path The stored path or external URL
 * @returns {string} Relative path prefixed with /storage or full URL
 */
export const getImagePath = (path) => {
    if (!path || typeof path !== "string" || path.trim() === "") {
        return "/themes/default/assets/img/airpro_mask_fb2.png"; // fallback image
    }

    const trimmedPath = path.trim();

    // Check if path starts with http:// or https://
    if (/^https?:\/\//i.test(trimmedPath)) {
        return trimmedPath;
    }

    const normalized = trimmedPath.replace(/^\/+/, "");

    // If it points directly to public folders (themes, assets, images, packages, build) or already starts with storage/
    if (
        normalized.startsWith("themes/") ||
        normalized.startsWith("assets/") ||
        normalized.startsWith("images/") ||
        normalized.startsWith("packages/") ||
        normalized.startsWith("build/") ||
        normalized.startsWith("storage/")
    ) {
        return `/${normalized}`;
    }

    // Otherwise prepend /storage/
    return `/public/storage/${normalized}`;
};

/**
 * Generate a dynamic image resize/cache URL.
 * Mirrors helper.php getImageCacheUrl logic.
 *
 * Uses a custom route (e.g., /image/{width}/{height}/{format}/{path})
 * to serve resized/cached versions of images.
 *
 * @param {string|null} filePath Original image path from database
 * @param {number} width Desired width in pixels (default: 200)
 * @param {number} height Desired height in pixels (default: 200)
 * @param {string} format Output format (default: 'webp')
 * @returns {string} URL to the resized image
 */
export const getImageCacheUrl = (filePath, width = 200, height = 200, format = "webp") => {
    const baseUrl = (import.meta.env.VITE_APP_URL || "").replace(/\/+$/, "");
    const relativePath = getImagePath(filePath);

    // Return external URLs unchanged
    if (/^https?:\/\//i.test(relativePath)) {
        return relativePath;
    }

    const cleanPath = relativePath.replace(/^\/+/, "");

    // Build dynamic resize route
    return baseUrl
        ? `${baseUrl}/image/${width}/${height}/${format}/${cleanPath}`
        : `/image/${width}/${height}/${format}/${cleanPath}`;
};

/**
 * Format a date string to a readable format (e.g., 18-Jul-2026, 03:15 PM)
 * @param {string} dateString 
 * @param {boolean} includeTime - Whether to include time (defaults to false)
 */
export const formatDate = (dateString, includeTime = false) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return dateString;

    const datePart = date.toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    }).replace(/ /g, '-');

    if (!includeTime) {
        return datePart;
    }

    const timePart = date.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });

    return `${datePart}, ${timePart}`;
};
