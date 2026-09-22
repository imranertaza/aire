<?php

require_once __DIR__ . '/ThemeHelper.php';

use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

if (! function_exists('getImageUrl')) {
    /**
     * Retrieve public URL for an image, with optional on-demand resizing,
     * smart cropping (fit), WebP conversion, and caching.
     *
     * @param string|null $path    Original image path or URL
     * @param int|null    $width   Optional width
     * @param int|null    $height  Optional height
     * @param array       $options Options: ['fit' => bool, 'format' => 'webp', 'quality' => 85, 'optimize' => bool]
     * @return string
     */
    function getImageUrl(?string $path, ?int $width = null, ?int $height = null, array $options = []): string
    {
        // 1. Empty fallback
        if (empty($path)) {
            return ImageService::getFallbackUrl();
        }

        // 2. If dimensions or optimization requested, delegate to ImageService
        if ($width !== null || $height !== null || !empty($options['optimize'])) {
            if (!empty($options['fit']) && $width && $height) {
                return ImageService::fit($path, $width, $height, $options);
            }

            if (!empty($options['optimize']) && !$width && !$height) {
                return ImageService::optimize($path, $options);
            }

            if ($width !== null) {
                return ImageService::resize($path, $width, $height, $options);
            }
        }

        // 3. Direct fast bypass check for remote URLs and SVGs
        if (ImageService::shouldBypass($path)) {
            return ImageService::getBypassUrl($path);
        }

        // 4. Auto-optimize local bitmaps to WebP with two-tier caching (unless explicitly raw)
        if (config('imagecache.auto_optimize', true) && empty($options['raw'])) {
            return ImageService::optimize($path, $options);
        }

        // 5. Default resolution (100% backward-compatible fallback)
        $normalized = ltrim($path, '/');

        if (file_exists(public_path($normalized))) {
            return asset($normalized);
        }

        if (str_starts_with($normalized, 'storage/')) {
            $sub = substr($normalized, 8);
            if (Storage::disk('public')->exists($sub) || file_exists(public_path($normalized))) {
                return asset($normalized);
            }
        }

        if (Storage::disk('public')->exists($normalized) || file_exists(public_path('storage/' . $normalized))) {
            return asset("storage/{$normalized}");
        }

        // Fallback
        return ImageService::getFallbackUrl();
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
     * Get the relative or absolute path for an image.
     *
     * Used primarily for generating cache/resized image URLs.
     *
     * @param string|null $path The stored path or external URL
     * @return string Relative path prefixed with /storage or full URL
     */
    function getImagePath(?string $path): string
    {
        if (empty($path)) {
            return '/themes/default/assets/img/airpro_mask_fb2.png';
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $normalized = ltrim($path, '/');

        if (
            str_starts_with($normalized, 'themes/') ||
            str_starts_with($normalized, 'assets/') ||
            str_starts_with($normalized, 'images/') ||
            str_starts_with($normalized, 'packages/') ||
            str_starts_with($normalized, 'build/') ||
            str_starts_with($normalized, 'storage/')
        ) {
            return '/' . $normalized;
        }

        return '/storage/' . $normalized;
    }
}

if (! function_exists('getImageCacheUrl')) {
    /**
     * Generate a dynamic image resize/cache URL.
     *
     * Uses a custom route (e.g., /image/{width}/{height}/{format}/{path})
     * to serve resized/cached versions of images.
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
            return ImageService::getFallbackUrl();
        }

        // Generate and return direct static cached file URL with zero PHP routing overhead
        return ImageService::fit($filePath, $width, $height, ['format' => $format]);
    }
}

if (! function_exists('getImageSrcset')) {
    /**
     * Generate a responsive srcset attribute string for an image.
     *
     * Produces high-performance WebP images at each target width with zero PHP routing overhead.
     *
     * @param string|null    $filePath Image path or URL
     * @param array          $widths   Target widths in pixels (default: [400, 700, 1000])
     * @param float|int|null $ratio    Height-to-width ratio (default: 1.0 for square crop; or custom float like 0.5625 for 16:9)
     * @param string         $format   Output format ('webp' by default)
     * @return string Space-separated srcset candidate string
     */
    function getImageSrcset(?string $filePath, array $widths = [400, 700, 1000], $ratio = 1.0, string $format = 'webp'): string
    {
        if (empty($filePath)) {
            return '';
        }

        // External URLs or vector SVGs do not need multiple pixel density candidates
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

function getLimitedText(?string $text, $char = 100): string
{
    $text = strip_tags($text);

    if (mb_strlen($text) <= $char) {
        return $text;
    }

    $truncated = mb_substr($text, 0, $char);

    $lastSpace = mb_strrpos($truncated, ' ');
    if ($lastSpace !== false) {
        $truncated = mb_substr($truncated, 0, $lastSpace);
    }

    return $truncated . '...';
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
                $enabledModules = \Illuminate\Support\Facades\Cache::remember('system_enabled_modules', 60, function () {
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
     * Retrieve a dynamic CMS section from database by name with caching.
     *
     * @param string $name
     * @param array|null $default
     * @return array|null
     */
    function getSection(string $name, ?array $default = null): ?array
    {
        try {
            return \Illuminate\Support\Facades\Cache::remember("section_{$name}", 86400, function () use ($name, $default) {
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
