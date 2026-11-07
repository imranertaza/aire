<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Resource extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'metadata'    => 'array',
        'is_featured' => 'integer',
        'status'      => 'integer',
        'sort_order'  => 'integer',
    ];

    public const CACHE_KEY = 'storefront_resources_v1';

    protected static function booted(): void
    {
        static::saving(function ($resource) {
            if (empty($resource->slug) && !empty($resource->title)) {
                $resource->slug = \Illuminate\Support\Str::slug($resource->title);
            }
        });

        static::saved(function () {
            ResourceCategory::clearCache();
        });

        static::deleted(function () {
            ResourceCategory::clearCache();
        });
    }

    /**
     * Scope a query to only include active resources.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 1)->orderBy('sort_order', 'asc');
    }

    /**
     * Scope a query to only include featured resources.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', 1);
    }

    /**
     * Get the category that owns the resource.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ResourceCategory::class, 'resource_category_id');
    }

    /**
     * Get the associated product if any.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the associated product category if any.
     */
    /**
     * Get the associated product category if any.
     */
    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    /**
     * Determine if this resource is a direct video file (local or remote mp4/webm/mov/ogg/etc.).
     */
    public function isVideoFile(): bool
    {
        $videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'mkv', 'avi', 'm4v'];

        // 1. If file_path is present and has a video extension
        if (!empty($this->file_path)) {
            $path = parse_url($this->file_path, PHP_URL_PATH) ?? '';
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (in_array($ext, $videoExtensions)) {
                return true;
            }

            // If file_type is explicitly 'video' or in extensions
            if (!empty($this->file_type) && in_array(strtolower($this->file_type), array_merge($videoExtensions, ['video']))) {
                return true;
            }
        }

        // 2. If external_url is a direct video file
        if (!empty($this->external_url)) {
            $path = parse_url($this->external_url, PHP_URL_PATH) ?? '';
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (in_array($ext, $videoExtensions)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract YouTube 11-char Video ID if the external URL is a YouTube link.
     */
    public function getYouTubeId(): ?string
    {
        $url = $this->external_url;
        if (empty($url) && !empty($this->file_path) && filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            $url = $this->file_path;
        }

        if (empty($url)) {
            return null;
        }

        if (preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?|shorts)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Extract Vimeo video ID if external URL is a Vimeo link.
     */
    public function getVimeoId(): ?string
    {
        $url = $this->external_url;
        if (empty($url)) {
            return null;
        }

        if (preg_match('/(?:vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/[^\/]*\/videos\/|album\/(?:\d+\/)?video\/|video\/|))(\d+)/i', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Get the playable video URL (either direct file asset URL or external URL).
     */
    public function getVideoSrc(): ?string
    {
        // 1. If an uploaded video file exists, give it priority
        if (!empty($this->file_path) && $this->isVideoFile()) {
            if (!preg_match('/^https?:\/\//i', $this->file_path)) {
                return asset(ltrim($this->file_path, '/'));
            }
            return $this->file_path;
        }

        // 2. If external embed URL exists (YouTube / Vimeo)
        $embed = $this->getVideoEmbedUrl();
        if ($embed) {
            return $embed;
        }

        // 3. Fallback to external_url if provided
        if (!empty($this->external_url)) {
            return trim($this->external_url);
        }

        // 4. Fallback to file_path
        if (!empty($this->file_path)) {
            if (!preg_match('/^https?:\/\//i', $this->file_path)) {
                return asset(ltrim($this->file_path, '/'));
            }
            return $this->file_path;
        }

        return null;
    }

    /**
     * Get the iframe embed URL (for YouTube or Vimeo).
     * Returns null if it is a direct video file.
     */
    public function getVideoEmbedUrl(): ?string
    {
        $ytId = $this->getYouTubeId();
        if ($ytId) {
            return "https://www.youtube-nocookie.com/embed/{$ytId}";
        }

        $vimeoId = $this->getVimeoId();
        if ($vimeoId) {
            return "https://player.vimeo.com/video/{$vimeoId}";
        }

        if (!$this->isVideoFile() && !empty($this->external_url)) {
            return trim($this->external_url);
        }

        return null;
    }

    /**
     * Get the best thumbnail URL for video cards.
     */
    public function getVideoThumbnailUrl(): string
    {
        if (!empty($this->thumbnail)) {
            return getImageCacheUrl($this->thumbnail, 600, 338);
        }

        $ytId = $this->getYouTubeId();
        if ($ytId) {
            return "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg";
        }

        return getImageCacheUrl(null, 600, 338);
    }
}

