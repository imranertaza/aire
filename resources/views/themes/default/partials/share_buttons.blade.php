@php
    $shareUrl = $shareUrl ?? ($page->slug ? route('page.show', $page->slug) : url()->current());
    $shareTitle = $shareTitle ?? ($page->page_title ?? config('app.name', 'Aire'));
    $shareLabel = $shareLabel ?? 'Share:';
    $btnClass = $btnClass ?? 'btn btn-sm btn-outline-secondary rounded-circle share-btn shadow-none';
@endphp

<div class="d-flex align-items-center gap-2 flex-wrap">
    @if (!empty($shareLabel))
        <span class="fw-semibold text-secondary fs-13"><i class="bi bi-share me-1"></i> {{ $shareLabel }}</span>
    @endif
    <button type="button" class="{{ $btnClass }}"
        onclick="if(navigator.share){navigator.share({title:{{ json_encode($shareTitle) }},url:{{ json_encode($shareUrl) }}}).catch(function(){});}else{navigator.clipboard.writeText({{ json_encode($shareUrl) }});if(window.AireToast){window.AireToast.success('Page link copied to clipboard!');}else{alert('Link copied to clipboard!');}}"
        title="Share">
        <i class="bi bi-share"></i>
    </button>
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}"
        target="_blank" rel="noopener noreferrer"
        class="{{ $btnClass }}" title="Share on Facebook">
        <i class="bi bi-facebook"></i>
    </a>
    <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}"
        target="_blank" rel="noopener noreferrer"
        class="{{ $btnClass }}"
        title="Share on X (Twitter)">
        <i class="bi bi-twitter-x"></i>
    </a>
    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($shareUrl) }}"
        target="_blank" rel="noopener noreferrer"
        class="{{ $btnClass }}"
        title="Share on LinkedIn">
        <i class="bi bi-linkedin"></i>
    </a>
    <button type="button" class="{{ $btnClass }}"
        onclick="navigator.clipboard.writeText({{ json_encode($shareUrl) }}); if(window.AireToast) { window.AireToast.success('Page link copied to clipboard!'); } else { alert('Link copied to clipboard!'); }"
        title="Copy Link">
        <i class="bi bi-link-45deg"></i>
    </button>
</div>
