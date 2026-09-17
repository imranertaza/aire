<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageService
{
    /**
     * Proportional resize maintaining aspect ratio without upscaling.
     *
     * @param string   $path    Source image path or URL
     * @param int      $width   Target width
     * @param int|null $height  Target height (optional, auto-calculated if null)
     * @param array    $options Additional options: quality, format, upsize
     * @return string           URL to cached image or original/fallback URL
     */
    public static function resize(string $path, int $width, ?int $height = null, array $options = []): string
    {
        return static::process($path, 'resize', [
            'width'   => $width,
            'height'  => $height,
            'quality' => $options['quality'] ?? config('imagecache.quality', 85),
            'format'  => $options['format'] ?? config('imagecache.format', 'webp'),
            'upsize'  => $options['upsize'] ?? false,
        ]);
    }

    /**
     * Smart crop and resize to exact dimensions.
     *
     * @param string $path    Source image path or URL
     * @param int    $width   Target width
     * @param int    $height  Target height
     * @param array  $options Additional options: quality, format, position
     * @return string         URL to cached image
     */
    public static function fit(string $path, int $width, int $height, array $options = []): string
    {
        return static::process($path, 'fit', [
            'width'    => $width,
            'height'   => $height,
            'quality'  => $options['quality'] ?? config('imagecache.quality', 85),
            'format'   => $options['format'] ?? config('imagecache.format', 'webp'),
            'position' => $options['position'] ?? 'center',
        ]);
    }

    /**
     * Convert to WebP and compress preserving original dimensions.
     * Ideal for large banners, lifestyle heroes, and sliders.
     *
     * @param string $path    Source image path
     * @param array  $options Additional options: quality, format
     * @return string         URL to cached image
     */
    public static function optimize(string $path, array $options = []): string
    {
        return static::process($path, 'optimize', [
            'quality' => $options['quality'] ?? config('imagecache.quality', 85),
            'format'  => $options['format'] ?? config('imagecache.format', 'webp'),
        ]);
    }

    /**
     * Convenience helper for 1:1 square thumbnails.
     *
     * @param string $path Source image path
     * @param int    $size Square dimension (width & height)
     * @return string      URL to cached thumbnail
     */
    public static function thumbnail(string $path, int $size = 150): string
    {
        return static::fit($path, $size, $size, ['quality' => 85]);
    }

    /**
     * Backward-compatible alias for existing calls.
     */
    public static function resizeAndCache(string $path, int $width, int $height, string $format = 'webp'): string
    {
        return static::resize($path, $width, $height, ['format' => $format]);
    }

    /**
     * Core processing engine with timestamp-aware hashing and two-tier caching.
     */
    protected static function process(string $path, string $operation, array $params): string
    {
        // 1. Check if path should bypass image manipulation (SVG, remote, non-image)
        if (static::shouldBypass($path)) {
            return static::getBypassUrl($path);
        }

        // 2. Resolve source file on disk
        $sourcePath = static::resolveSourcePath($path);
        if (!$sourcePath || !file_exists($sourcePath)) {
            return static::getFallbackUrl();
        }

        // 3. Check for vector SVG or unsupported file types that resolved
        $ext = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
        if (in_array($ext, ['svg', 'ico', 'pdf', 'gif'])) {
            return static::getBypassUrl($path);
        }

        // 4. Compute unique, timestamp-aware hash for auto-invalidation
        $mtime   = filemtime($sourcePath) ?: 0;
        $size    = filesize($sourcePath) ?: 0;
        $format  = $params['format'] ?? config('imagecache.format', 'webp');
        $quality = (int) ($params['quality'] ?? config('imagecache.quality', 85));
        $w       = $params['width'] ?? 0;
        $h       = $params['height'] ?? 0;

        // Ensure WebP format is supported by GD; if not, fallback to original extension
        if ($format === 'webp' && !function_exists('imagewebp')) {
            $format = ($ext === 'png') ? 'png' : 'jpg';
            $params['format'] = $format;
        }

        $hash           = md5("{$path}|{$mtime}|{$size}|{$operation}|{$w}x{$h}|{$format}|{$quality}");
        $cacheKey       = "img_cache_{$hash}";
        $cachedFileName = "{$hash}.{$format}";
        $cachedDir      = config('imagecache.cache_dir', public_path('cache'));
        $cachedPath     = $cachedDir . DIRECTORY_SEPARATOR . $cachedFileName;
        $url            = asset('cache/' . $cachedFileName);
        $lifetime       = config('imagecache.cache_lifetime', 2592000);

        // 5. Tier 2: Check Laravel Cache Key (0ms memory/redis check)
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // 6. Tier 1: Check Disk File
        if (file_exists($cachedPath) && filesize($cachedPath) > 0) {
            Cache::put($cacheKey, $url, now()->addSeconds($lifetime));
            return $url;
        }

        // 7. Process image via Intervention Image with safety boundaries
        try {
            if (!File::exists($cachedDir)) {
                File::makeDirectory($cachedDir, 0755, true);
            }

            // Cap dimensions to prevent DoS/memory exhaustion
            $maxWidth  = config('imagecache.max_width', 3840);
            $maxHeight = config('imagecache.max_height', 3840);
            if ($w > $maxWidth) $w = $maxWidth;
            if ($h > $maxHeight) $h = $maxHeight;

            $driver  = config('imagecache.driver', 'gd');
            $manager = new ImageManager(['driver' => $driver]);
            $image   = $manager->make($sourcePath);

            switch ($operation) {
                case 'fit':
                    $position = $params['position'] ?? 'center';
                    $image->fit($w, $h, function ($constraint) {
                        $constraint->upsize();
                    }, $position);
                    break;

                case 'resize':
                    $image->resize($w ?: null, $h ?: null, function ($constraint) use ($params) {
                        $constraint->aspectRatio();
                        if (!($params['upsize'] ?? false)) {
                            $constraint->upsize();
                        }
                    });
                    break;

                case 'optimize':
                default:
                    // Preserve original dimensions, purely optimize & convert format
                    break;
            }

            // Save processed image
            $image->save($cachedPath, $quality, $format);

            // Register in Laravel cache
            Cache::put($cacheKey, $url, now()->addSeconds($lifetime));

            return $url;
        } catch (\Throwable $e) {
            Log::warning("ImageService processing failed for [{$path}]: " . $e->getMessage());
            return static::getBypassUrl($path);
        }
    }

    /**
     * Check if path should bypass manipulation.
     */
    public static function shouldBypass(string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        // External remote URLs
        if (preg_match('/^https?:\/\//i', $path)) {
            return true;
        }

        // Non-raster image extensions or SVGs
        $ext = strtolower(pathinfo(parse_url($path, PHP_URL_PATH) ?? $path, PATHINFO_EXTENSION));
        if (in_array($ext, ['svg', 'ico', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip'])) {
            return true;
        }

        return false;
    }

    /**
     * Generate URL for bypassed assets.
     */
    public static function getBypassUrl(string $path): string
    {
        if (empty($path)) {
            return static::getFallbackUrl();
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            if (str_contains($path, 'placehold.co') || str_contains($path, 'placeholder')) {
                return static::getFallbackUrl();
            }
            return $path;
        }

        $normalized = ltrim($path, '/');
        if (file_exists(public_path($normalized))) {
            return asset($normalized);
        }

        if (str_starts_with($normalized, 'storage/')) {
            return asset($normalized);
        }

        if (Storage::disk('public')->exists($normalized) || file_exists(public_path('storage/' . $normalized))) {
            return asset('storage/' . $normalized);
        }

        return asset($normalized);
    }

    /**
     * Resolve the source path on the filesystem.
     */
    public static function resolveSourcePath(string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        $normalized = ltrim($path, '/');

        // 1. Direct public folder check
        if (file_exists(public_path($normalized))) {
            return public_path($normalized);
        }

        // 2. Starts with 'storage/'
        if (str_starts_with($normalized, 'storage/')) {
            $sub = substr($normalized, 8);
            if (file_exists(public_path('storage/' . $sub))) {
                return public_path('storage/' . $sub);
            }
            if (file_exists(storage_path('app/public/' . $sub))) {
                return storage_path('app/public/' . $sub);
            }
        }

        // 3. In public/storage/{normalized}
        if (file_exists(public_path('storage/' . $normalized))) {
            return public_path('storage/' . $normalized);
        }

        // 4. In storage/app/public/{normalized}
        if (file_exists(storage_path('app/public/' . $normalized))) {
            return storage_path('app/public/' . $normalized);
        }

        // 5. Check if it's already an absolute path
        if (file_exists($path)) {
            return $path;
        }

        return null;
    }

    /**
     * Get fallback placeholder URL.
     */
    public static function getFallbackUrl(): string
    {
        $fallback = config('imagecache.fallback', 'public/assets/images/default.png');
        if (file_exists(public_path($fallback))) {
            return asset($fallback);
        }
        return asset('public/assets/images/default.png');
    }

    /**
     * Clear cached images.
     *
     * @param string|null $path Optional path of specific image to clear
     * @return int              Number of deleted files
     */
    public static function clearCache(?string $path = null): int
    {
        $cachedDir = config('imagecache.cache_dir', public_path('cache'));
        if (!File::exists($cachedDir)) {
            return 0;
        }

        $deleted = 0;
        $files   = File::files($cachedDir);

        if ($path === null) {
            // Clear all cached images
            foreach ($files as $file) {
                if (File::delete($file->getPathname())) {
                    $deleted++;
                }
            }
            Cache::flush(); // Flush memory cache keys
            return $deleted;
        }

        // Target specific image
        $sourcePath = static::resolveSourcePath($path);
        if (!$sourcePath) {
            return 0;
        }

        // Search files related to path
        $pathPrefix = md5($path);
        foreach ($files as $file) {
            if (str_starts_with($file->getFilename(), $pathPrefix)) {
                if (File::delete($file->getPathname())) {
                    $deleted++;
                }
            }
        }

        return $deleted;
    }

    /**
     * Prune cached images older than given days.
     *
     * @param int $daysOld Minimum age in days
     * @return int         Number of deleted files
     */
    public static function pruneCache(int $daysOld = 30): int
    {
        $cachedDir = config('imagecache.cache_dir', public_path('cache'));
        if (!File::exists($cachedDir)) {
            return 0;
        }

        $threshold = now()->subDays($daysOld)->getTimestamp();
        $deleted   = 0;
        $files     = File::files($cachedDir);

        foreach ($files as $file) {
            if ($file->getMTime() < $threshold) {
                if (File::delete($file->getPathname())) {
                    $deleted++;
                }
            }
        }

        return $deleted;
    }
}
