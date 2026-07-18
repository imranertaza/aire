import { computed } from "vue";

/**
 * Truncate text to a maximum length and add suffix if needed
 */
export function truncateText(text = "", maxLength = 100, suffix = "...") {
    if (typeof text !== "string") return "";
    return text.length > maxLength ? text.slice(0, maxLength) + suffix : text;
}

/**
 * Build correct image URL (external or local storage)
 */
export function getImageUrl(path) {
    if (!path) {
        return "/assets/images/default.svg"; // fallback image
    }

    return path.startsWith("http://") || path.startsWith("https://") ?
        path : `/storage/${path.replace(/^\/+/, "")}`;
    // path : `/public/storage/${path.replace(/^\/+/, "")}`;
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

const getImagePath = (path) => {
    if (!path) {
        return '/assets/images/default.svg'; // fallback image
    }

    // Check if path starts with http:// or https://
    if (path.startsWith('http://') || path.startsWith('https://')) {
        return path;
    }

    // Otherwise prepend /storage/
    return '/storage/' + path.replace(/^\/+/, '');
}

/**
 * Get cached/resized image URL via image endpoint
 */
export const getImageCacheUrl = (filePath, width = 200, height = 200, format = "webp") => {
    const baseUrl =
        import.meta.env.VITE_APP_URL;
    const relativePath = getImagePath(filePath);

    // Return external URLs unchanged
    if (relativePath.startsWith("http://") || relativePath.startsWith("https://")) {
        return relativePath;
    }

    // Local image - use cache endpoint
    return `${baseUrl}/image/${width}/${height}/${format}/${relativePath.replace(/^\/+/, "")}`;
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
