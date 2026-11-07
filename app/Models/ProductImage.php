<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $guarded = ['id'];

    public function isVideo(): bool
    {
        if (in_array($this->file_type, ['video', 'youtube', 'vimeo'])) {
            return true;
        }

        $extension = strtolower(pathinfo($this->image ?? '', PATHINFO_EXTENSION));
        return in_array($extension, ['mp4', 'webm', 'mov', 'ogg', 'mkv']);
    }

    public function isYouTube(): bool
    {
        return $this->file_type === 'youtube'
            || str_contains($this->image ?? '', 'youtube.com')
            || str_contains($this->image ?? '', 'youtu.be');
    }

    public function isVimeo(): bool
    {
        return $this->file_type === 'vimeo'
            || str_contains($this->image ?? '', 'vimeo.com');
    }

    public function getYouTubeId(): ?string
    {
        if (!$this->isYouTube()) {
            return null;
        }
        preg_match('#(?:youtu\.be/|youtube\.com/(?:embed/|v/|watch\?v=|shorts/|&v=))([\w-]{11})#i', $this->image ?? '', $matches);
        return $matches[1] ?? null;
    }

    public function getVimeoId(): ?string
    {
        if (!$this->isVimeo()) {
            return null;
        }
        preg_match('#vimeo\.com/(?:video/)?([0-9]+)#i', $this->image ?? '', $matches);
        return $matches[1] ?? null;
    }

    public function getThumbnailUrl(): string
    {
        if ($this->isYouTube() && ($ytId = $this->getYouTubeId())) {
            return "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg";
        }
        if ($this->isVimeo() && ($vmId = $this->getVimeoId())) {
            return "https://vumbnail.com/{$vmId}.jpg";
        }
        if ($this->isVideo()) {
            return asset('themes/default/assets/img/photograph.webp');
        }
        return getImageUrl($this->image);
    }

    public function getEmbedUrl(): string
    {
        if ($this->isYouTube() && ($ytId = $this->getYouTubeId())) {
            return "https://www.youtube-nocookie.com/embed/{$ytId}?autoplay=1";
        }
        if ($this->isVimeo() && ($vmId = $this->getVimeoId())) {
            return "https://player.vimeo.com/video/{$vmId}?autoplay=1";
        }
        return $this->image ?? '';
    }
}
