@php
    $s = $block['settings'] ?? [];
    $url = $s['url'] ?? '';
    $alt = $s['alt'] ?? '';
    $rounded = $s['rounded'] ?? 'rounded-3';
    $shadow = $s['shadow'] ?? '';
    $fullWidth = !empty($s['fullWidth']);
    $align = $s['align'] ?? 'text-center';
    $maxWidth = $s['maxWidth'] ?? '100%';
    $aspectRatio = (!empty($s['aspectRatio']) && $s['aspectRatio'] !== 'auto') ? $s['aspectRatio'] : '';
    $objectFit = $s['objectFit'] ?? 'cover';
    $linkUrl = $s['link_url'] ?? '';
    $targetBlank = !empty($s['target_blank']) ? 'target="_blank" rel="noopener noreferrer"' : '';
    $hoverEffect = $s['hoverEffect'] ?? '';
    
    $vis = $s['visibility'] ?? [];
    $visClass = '';
    if (!empty($vis['hideOnMobile'])) $visClass .= ' d-none d-md-block';
    if (!empty($vis['hideOnDesktop'])) $visClass .= ' d-lg-none';
    if (!empty($vis['hideOnTablet'])) $visClass .= ' d-md-none d-lg-block';

    $imgSrc = $url ? getImageUrl($url) : '';
    
    $imgStyles = ["max-width: {$maxWidth};", "object-fit: {$objectFit};", "max-height: 540px;"];
    if ($aspectRatio) {
        $imgStyles[] = "aspect-ratio: {$aspectRatio};";
    }
    $styleAttr = 'style="' . implode(' ', $imgStyles) . '"';

    $mt = $s['marginTop'] ?? '';
    $mb = isset($s['marginBottom']) ? $s['marginBottom'] : 'my-3';
    $customClass = $s['custom_class'] ?? '';
    $customId = !empty($s['custom_id']) ? 'id="' . e($s['custom_id']) . '"' : '';

    $anim = !empty($s['scrollAnimation']) ? 'data-builder-anim="' . e($s['scrollAnimation']) . '" data-aos="' . e($s['scrollAnimation']) . '"' : '';
    if ($anim && !empty($s['animationDelay'])) {
        $anim .= ' data-anim-delay="' . intval($s['animationDelay']) . '" data-aos-delay="' . intval($s['animationDelay']) . '"';
    }
    if ($anim && !empty($s['animationDuration'])) {
        $anim .= ' data-anim-duration="' . intval($s['animationDuration']) . '" data-aos-duration="' . intval($s['animationDuration']) . '"';
    }

    $isMediaVideo = (!empty($s['mediaType']) && $s['mediaType'] === 'video') ||
        (empty($s['mediaType']) && !empty($url) && (
            str_contains($url, 'youtube.com') ||
            str_contains($url, 'youtu.be') ||
            str_contains($url, 'vimeo.com') ||
            preg_match('/\.(mp4|webm|ogg|mov)($|\?)/i', $url)
        ));
@endphp

@if ($isMediaVideo)
    @include('themes.default.components.blocks.video', ['block' => $block])
@elseif ($imgSrc)
    <div {!! $customId !!} {!! $anim !!} class="{{ $align }} {{ $visClass }} {{ $mt }} {{ $mb }} {{ $customClass }}">
        <div class="position-relative d-inline-block {{ $fullWidth ? 'w-100' : '' }} {{ $hoverEffect }}" style="max-width: {{ $maxWidth }};">
            @if ($linkUrl)
                <a href="{{ $linkUrl }}" {!! $targetBlank !!} class="d-inline-block text-decoration-none {{ $fullWidth ? 'w-100' : '' }}">
            @endif

            <img src="{{ $imgSrc }}" 
                 alt="{{ $alt }}" 
                 class="img-fluid {{ $rounded }} {{ $shadow }} {{ $fullWidth ? 'w-100' : '' }}" 
                 {!! $styleAttr !!}
                 loading="lazy">

            @if ($linkUrl)
                </a>
            @endif

            @if (!empty($s['caption']))
                <figcaption class="small text-muted mt-2 text-center">{{ $s['caption'] }}</figcaption>
            @endif
        </div>
    </div>
@endif
