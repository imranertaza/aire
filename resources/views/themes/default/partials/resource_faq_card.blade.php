@php
    $metadata = is_array($item->metadata) ? $item->metadata : [];
    $hasFile = !empty($item->file_path);
    $isLink = !empty($item->external_url);
    $hasGraphic = !empty($metadata['graphic_icon']);
    $graphicIcon = $metadata['graphic_icon'] ?? ($item->badge_icon ?: 'bi bi-question-circle');
    $badgeIcon = $item->badge_icon ?: ($hasFile ? 'bi bi-download' : ($isLink ? 'bi bi-link-45deg' : 'bi bi-question-circle'));
    if ($badgeIcon === 'bi bi-ruler' || $badgeIcon === 'bi-ruler') {
        $badgeIcon = 'bi bi-rulers';
    }
    $targetHref = $hasFile ? route('resources.download', $item->id) : ($isLink ? $item->external_url : '#');
@endphp

<div class="col resource-card-col" data-title="{{ $item->title }}" data-desc="{{ $item->description }}">
    <a href="{{ $targetHref }}" class="resource-thumb-card {{ $hasFile ? 'js-download-btn' : '' }}"
        data-doc="{{ $item->title }}" @if($isLink && !$hasFile) target="_blank" rel="noopener" @endif>
        <div class="resource-thumb-box">
            @if ($hasGraphic || empty($item->thumbnail))
                <div class="resource-thumb-graphic">
                    <i class="{{ $graphicIcon }}"></i>
                </div>
            @else
                <img src="{{ getImageCacheUrl($item->thumbnail) }}" alt="{{ $item->title }}"
                    class="resource-thumb-img">
            @endif
        </div>
        <div class="resource-thumb-body">
            <div class="resource-float-badge">
                <i class="{{ $badgeIcon }}"></i>
            </div>
            <h4 class="resource-thumb-title">{{ $item->title }}</h4>
            <i class="bi bi-chevron-right resource-thumb-chevron"></i>
        </div>
    </a>
</div>
