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
