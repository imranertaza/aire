<?php

require_once __DIR__ . '/ThemeHelper.php';

use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

if (! function_exists('getImageUrl')) {
    /**
     * Generate a secure and reliable URL for an image stored in public storage (Shared Hosting optimized).
     *
     * - Returns fallback image if path is empty or invalid.
     * - Returns original URL if it's already absolute (http/https).
     * - Supports on-demand resizing, WebP optimization, and responsive cropping via ImageService.
     * - Resolves directly through public/ and public/storage/ paths for cPanel / Shared Hosting compatibility.
     *
     * @param string|null $path    The relative path from storage or absolute URL
     * @param int|null    $width   Optional width
     * @param int|null    $height  Optional height
     * @param array       $options Options: ['fit' => bool, 'format' => 'webp', 'quality' => 85, 'optimize' => bool, 'raw' => bool]
     * @return string The full accessible image URL
     */
    function getImageUrl(?string $path, ?int $width = null, ?int $height = null, array $options = []): string
    {
        // 1. Empty fallback
        if (empty($path)) {
            if (class_exists(ImageService::class)) {
                return ImageService::getFallbackUrl();
            }
            if (file_exists(public_path('themes/default/assets/img/airpro_mask_fb2.png'))) {
                return asset('themes/default/assets/img/airpro_mask_fb2.png');
            }
            return asset('public/assets/images/default.png');
        }

        // 2. Absolute URL check
        if (preg_match('/^https?:\/\//i', $path)) {
            if (str_contains($path, 'placehold.co') || str_contains($path, 'placeholder')) {
                if (file_exists(public_path('themes/default/assets/img/airpro_mask_fb2.png'))) {
                    return asset('themes/default/assets/img/airpro_mask_fb2.png');
                }
                return asset('public/assets/images/default.png');
            }
            return $path;
        }

        // 3. Delegate to ImageService if resizing or optimization requested
        if (class_exists(ImageService::class) && ($width !== null || $height !== null || !empty($options['optimize']))) {
            try {
                if (!empty($options['fit']) && $width && $height) {
                    return ImageService::fit($path, $width, $height, $options);
                }

                if (!empty($options['optimize']) && !$width && !$height) {
                    return ImageService::optimize($path, $options);
                }

                if ($width !== null) {
                    return ImageService::resize($path, $width, $height, $options);
                }
            } catch (\Throwable $e) {
                // Graceful fallback to direct path resolution on failure
            }
        }

        // 4. Bypass check
        if (class_exists(ImageService::class) && ImageService::shouldBypass($path)) {
            return ImageService::getBypassUrl($path);
        }

        // 5. Shared Hosting Path Resolution
        $normalized = ltrim($path, '/');

        // Check direct public folder (e.g. themes/default/assets/img/...)
        if (file_exists(public_path($normalized))) {
            return asset($normalized);
        }

        // If path already starts with public/
        if (str_starts_with($normalized, 'public/')) {
            $sub = substr($normalized, 7);
            if (file_exists(public_path($sub))) {
                return asset($normalized);
            }
        }

        // Check if file exists in public storage disk
        if (Storage::disk('public')->exists($normalized)) {
            return asset("public/storage/{$normalized}");
        }

        // Check if path starts with storage/
        if (str_starts_with($normalized, 'storage/')) {
            $sub = substr($normalized, 8);
            if (Storage::disk('public')->exists($sub) || file_exists(public_path($normalized))) {
                return asset("public/{$normalized}");
            }
        }

        // Check if storage/app/public has the file
        if (file_exists(storage_path('app/public/' . $normalized))) {
            return asset("public/storage/{$normalized}");
        }

        // Fallback
        if (class_exists(ImageService::class)) {
            return ImageService::getFallbackUrl();
        }
        if (file_exists(public_path('themes/default/assets/img/airpro_mask_fb2.png'))) {
            return asset('themes/default/assets/img/airpro_mask_fb2.png');
        }

        return asset('public/assets/images/default.png');
    }
}

if (! function_exists('truncateText')) {
    /**
     * Truncate text to a given length with optional ellipsis.
     *
     * Strips HTML tags and truncates at the last space to avoid cutting words.
     *
     * @param string $text   The text to truncate
     * @param int    $length Maximum length before truncation (default: 100)
     * @param string $suffix Suffix to append when truncated (default: "...")
     * @return string Truncated text
     */
    function truncateText(string $text, int $length = 100, string $suffix = '...'): string
    {
        $text = strip_tags($text);

        if (mb_strlen($text) <= $length) {
            return $text;
        }

        $truncated = mb_substr($text, 0, $length);

        $lastSpace = mb_strrpos($truncated, ' ');
        if ($lastSpace !== false) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }

        return $truncated . $suffix;
    }
}

if (! function_exists('formatDate')) {
    /**
     * Format a given date/time into a human-readable string using Carbon.
     *
     * @param  string|\DateTimeInterface|null  $date   The date to format
     * @param  string                          $format Desired format (default: 'd M Y')
     * @return string Formatted date or empty string if invalid
     */
    function formatDate($date, string $format = 'd M Y'): string
    {
        if (empty($date)) {
            return '';
        }

        return Carbon::parse($date)->format($format);
    }
}

if (! function_exists('getImagePath')) {
    /**
     * Get the relative or absolute path for an image (Shared Hosting optimized).
     *
     * Used for generating cache/resized image URLs or direct public URLs on cPanel.
     *
     * @param string|null $path The stored path or external URL
     * @return string Relative path prefixed with /public/storage or direct public asset path
     */
    function getImagePath(?string $path): string
    {
        if (empty($path)) {
            if (file_exists(public_path('themes/default/assets/img/airpro_mask_fb2.png'))) {
                return '/themes/default/assets/img/airpro_mask_fb2.png';
            }
            return '/public/assets/images/default.png';
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $normalized = ltrim($path, '/');

        // Direct public folders (themes, assets, images, packages, build)
        if (
            str_starts_with($normalized, 'themes/') ||
            str_starts_with($normalized, 'assets/') ||
            str_starts_with($normalized, 'images/') ||
            str_starts_with($normalized, 'packages/') ||
            str_starts_with($normalized, 'build/') ||
            str_starts_with($normalized, 'public/')
        ) {
            return '/' . $normalized;
        }

        // Shared hosting storage prefix
        if (str_starts_with($normalized, 'storage/')) {
            return '/public/' . $normalized;
        }

        return '/public/storage/' . $normalized;
    }
}

if (! function_exists('getImageCacheUrl')) {
    /**
     * Generate a dynamic image resize/cache URL (Shared Hosting optimized).
     *
     * @param string|null $filePath Original image path from database
     * @param int         $width    Desired width in pixels (default: 200)
     * @param int         $height   Desired height in pixels (default: 200)
     * @param string      $format   Output format (default: 'webp')
     * @return string Full URL to the resized image
     */
    function getImageCacheUrl(?string $filePath, int $width = 200, int $height = 200, string $format = 'webp'): string
    {
        if (empty($filePath)) {
            if (class_exists(ImageService::class)) {
                return ImageService::getFallbackUrl();
            }
            return getImageUrl('');
        }

        // Attempt direct ImageService fit with static file caching
        if (class_exists(ImageService::class)) {
            try {
                return ImageService::fit($filePath, $width, $height, ['format' => $format]);
            } catch (\Throwable $e) {
                // Fallback to route-based resize if needed
            }
        }

        $baseUrl      = url('/');
        $relativePath = getImagePath($filePath);
        if (str_starts_with($relativePath, 'http://') || str_starts_with($relativePath, 'https://')) {
            return $relativePath;
        }

        return rtrim($baseUrl, '/') . "/image/{$width}/{$height}/{$format}/" . ltrim($relativePath, '/');
    }
}

if (! function_exists('getImageSrcset')) {
    /**
     * Generate a responsive srcset attribute string for an image (Shared Hosting optimized).
     *
     * @param string|null    $filePath Image path or URL
     * @param array          $widths   Target widths in pixels (default: [400, 700, 1000])
     * @param float|int|null $ratio    Height-to-width ratio (default: 1.0 for square crop)
     * @param string         $format   Output format ('webp' by default)
     * @return string Space-separated srcset candidate string
     */
    function getImageSrcset(?string $filePath, array $widths = [400, 700, 1000], $ratio = 1.0, string $format = 'webp'): string
    {
        if (empty($filePath)) {
            return '';
        }

        if (str_starts_with($filePath, 'http://') || str_starts_with($filePath, 'https://') || str_ends_with(strtolower($filePath), '.svg')) {
            return '';
        }

        $sources = [];
        foreach ($widths as $w) {
            $w = (int) $w;
            if ($w <= 0) continue;
            $h = $ratio !== null && $ratio > 0 ? (int) round($w * $ratio) : $w;
            $url = getImageCacheUrl($filePath, $w, $h, $format);
            $sources[] = "{$url} {$w}w";
        }

        return implode(', ', $sources);
    }
}

if (! function_exists('getLimitedText')) {
    /**
     * Convenience alias for truncateText.
     */
    function getLimitedText(?string $text, $char = 100): string
    {
        return truncateText($text ?? '', (int) $char, '...');
    }
}

if (! function_exists('isModuleEnabled')) {
    /**
     * Check if a system module is enabled by its key.
     *
     * @param string $moduleKey
     * @return bool
     */
    function isModuleEnabled(string $moduleKey): bool
    {
        static $enabledModules = null;
        if ($enabledModules === null) {
            try {
                $enabledModules = Cache::remember('system_enabled_modules', 60, function () {
                    return \App\Models\Module::where('status', 1)->pluck('module_key')->toArray();
                });
            } catch (\Throwable $e) {
                return false;
            }
        }
        return in_array($moduleKey, $enabledModules, true);
    }
}

if (! function_exists('is_module_enabled')) {
    function is_module_enabled(string $moduleKey): bool
    {
        return isModuleEnabled($moduleKey);
    }
}

if (! function_exists('getSection')) {
    /**
     * Retrieve a dynamic CMS section from database by name with 24-hour caching.
     *
     * @param string $name
     * @param array|null $default
     * @return array|null
     */
    function getSection(string $name, ?array $default = null): ?array
    {
        try {
            return Cache::remember("section_{$name}", 86400, function () use ($name, $default) {
                $section = \App\Models\Section::where('name', $name)->first();
                if (!$section) {
                    return $default;
                }
                return is_array($section->data) ? $section->data : json_decode($section->data, true);
            }) ?? $default;
        } catch (\Throwable $e) {
            return $default;
        }
    }
}

if (! function_exists('get_section')) {
    function get_section(string $name, ?array $default = null): ?array
    {
        return getSection($name, $default);
    }
}
