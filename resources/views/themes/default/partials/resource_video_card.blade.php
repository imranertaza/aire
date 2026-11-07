@php
    $isDirect = $item->isVideoFile();
    $embedUrl = $item->getVideoEmbedUrl();
    $videoSrc = $isDirect ? $item->getVideoSrc() : ($embedUrl ?: $item->getVideoSrc());
    $ytId = $item->getYouTubeId();
@endphp

<div class="col resource-card-col video-card-item-col" data-title="{{ $item->title }}"
    data-desc="{{ $item->description }}">
    <div class="video-card-item js-video-trigger"
        role="button"
        tabindex="0"
        data-bs-toggle="modal"
        data-bs-target="#resourceVideoModal"
        data-video-title="{{ $item->title }}"
        data-video-src="{{ $videoSrc }}"
        data-is-direct="{{ $isDirect ? '1' : '0' }}"
        data-embed-url="{{ $embedUrl }}">
        <div class="video-thumb-wrap">
            @if (!empty($item->thumbnail))
                <img src="{{ getImageCacheUrl($item->thumbnail, 600, 338) }}" alt="{{ $item->title }}" loading="lazy">
            @elseif ($ytId)
                <img src="https://img.youtube.com/vi/{{ $ytId }}/hqdefault.jpg" alt="{{ $item->title }}" loading="lazy">
            @elseif ($isDirect && $item->getVideoSrc())
                <video src="{{ $item->getVideoSrc() }}#t=0.5" preload="metadata" muted playsinline class="w-100 h-100" style="object-fit: cover; pointer-events: none;"></video>
            @else
                <img src="{{ getImageCacheUrl(null, 600, 338) }}" alt="{{ $item->title }}" loading="lazy">
            @endif
            <div class="video-play-center"><i class="bi bi-play-fill"></i></div>
        </div>
        <div class="video-bar-bottom">
            <div class="video-mini-pill"><i class="bi bi-play-fill"></i></div>
            <h4 class="video-bar-title">{{ $item->title }}</h4>
            <i class="bi bi-chevron-right video-bar-chevron ms-auto"></i>
        </div>
    </div>
</div>
