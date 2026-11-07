@php
    $metadata = is_array($item->metadata) ? $item->metadata : [];
    $isLink = $item->file_type === 'link' || (!empty($item->external_url) && empty($item->file_path));
    $hasGraphic = !empty($metadata['graphic_icon']);
    $graphicIcon = $metadata['graphic_icon'] ?? '';

    $badgeIcon = $item->badge_icon;
    if (empty($badgeIcon)) {
        $badgeIcon = match ($item->file_type) {
            'zip', 'rar', '7z' => 'bi bi-file-earmark-zip',
            'doc', 'docx' => 'bi bi-file-earmark-word',
            'apk' => 'bi bi-android2',
            'link' => 'bi bi-link-45deg',
            default => $isLink ? 'bi bi-link-45deg' : 'bi bi-file-earmark-pdf',
        };
    }
    if ($badgeIcon === 'bi bi-ruler' || $badgeIcon === 'bi-ruler') {
        $badgeIcon = 'bi bi-rulers';
    }
@endphp

<div class="col resource-card-col brochure-card-item" data-title="{{ $item->title }}"
    data-desc="{{ $item->description }}">
    <div class="brochure-card">
        <div class="brochure-preview-box">
            @if (!empty($item->thumbnail))
                <img src="{{ getImageCacheUrl($item->thumbnail) }}" alt="{{ $item->title }}" class="brochure-preview-img"
                    loading="lazy">
            @elseif ($hasGraphic)
                <div class="resource-thumb-graphic">
                    <i class="{{ $graphicIcon }}"></i>
                </div>
            @else
                <div class="resource-thumb-graphic graphic-clean">
                    <i class="{{ $badgeIcon }}"></i>
                </div>
            @endif
        </div>
        <div class="brochure-card-body">
            <div class="brochure-float-badge" title="{{ $item->badge_text ?: 'Document' }}">
                <i class="{{ $badgeIcon }}"></i>
            </div>
            <h4 class="brochure-card-title">{{ $item->title }}</h4>
            <p class="brochure-card-desc">{{ $item->description }}</p>
            @if ($isLink)
                <a href="{{ $item->external_url }}" class="brochure-download-btn" target="_blank" rel="noopener">
                    Visit Link <i class="bi bi-arrow-right"></i>
                </a>
            @else
                <a href="{{ route('resources.download', $item->id) }}" class="brochure-download-btn js-download-btn"
                    data-doc="{{ $item->title }}">
                    Download <i class="bi bi-arrow-right"></i>
                </a>
            @endif
        </div>
    </div>
</div>
