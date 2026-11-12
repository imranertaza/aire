@php
    $s = $block['settings'] ?? [];
    $rawUrl = trim($s['url'] ?? '');
    $source = $s['source'] ?? 'youtube';
    $aspectRatio = $s['aspectRatio'] ?? '16:9';
    $autoplay = !empty($s['autoplay']);
    $loop = !empty($s['loop']);
    $controls = !isset($s['controls']) || !empty($s['controls']);
    $muted = !empty($s['muted']) || $autoplay; // Autoplay requires muted in modern browsers
    $poster = !empty($s['poster']) ? getImageUrl($s['poster']) : '';
    $caption = $s['caption'] ?? '';

    $maxWidth = $s['maxWidth'] ?? '100%';
    $align = $s['align'] ?? 'text-center';
    $rounded = $s['rounded'] ?? 'rounded-3';
    $shadow = $s['shadow'] ?? '';

    $mt = $s['marginTop'] ?? '';
    $mb = isset($s['marginBottom']) ? $s['marginBottom'] : 'my-3';
    $customClass = $s['custom_class'] ?? '';
    $customId = !empty($s['custom_id']) ? 'id="' . e($s['custom_id']) . '"' : '';

    $vis = $s['visibility'] ?? [];
    $visClass = '';
    if (!empty($vis['hideOnMobile'])) $visClass .= ' d-none d-md-block';
    if (!empty($vis['hideOnDesktop'])) $visClass .= ' d-lg-none';
    if (!empty($vis['hideOnTablet'])) $visClass .= ' d-md-none d-lg-block';

    $anim = !empty($s['scrollAnimation']) ? 'data-builder-anim="' . e($s['scrollAnimation']) . '" data-aos="' . e($s['scrollAnimation']) . '"' : '';
    if ($anim && !empty($s['animationDelay'])) {
        $anim .= ' data-anim-delay="' . intval($s['animationDelay']) . '" data-aos-delay="' . intval($s['animationDelay']) . '"';
    }
    if ($anim && !empty($s['animationDuration'])) {
        $anim .= ' data-anim-duration="' . intval($s['animationDuration']) . '" data-aos-duration="' . intval($s['animationDuration']) . '"';
    }

    // Auto-detect source if URL matches patterns
    if (str_contains($rawUrl, 'youtube.com') || str_contains($rawUrl, 'youtu.be') || preg_match('/^[\w-]{11}$/', $rawUrl)) {
        $source = 'youtube';
    } elseif (str_contains($rawUrl, 'vimeo.com')) {
        $source = 'vimeo';
    } elseif (preg_match('/\.(mp4|webm|ogg|mov)($|\?)/i', $rawUrl) || str_contains($rawUrl, 'storage/')) {
        $source = 'html5';
    }

    // Process YouTube
    $ytId = null;
    $vimeoId = null;
    $embedUrl = '';

    if ($source === 'youtube' && !empty($rawUrl)) {
        if (preg_match('/(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:.*[?&]v=|(?:v|e(?:mbed)?|shorts)\/))([\w-]{11})/i', $rawUrl, $matches)) {
            $ytId = $matches[1];
        } elseif (preg_match('/^[\w-]{11}$/', $rawUrl)) {
            $ytId = $rawUrl;
        }

        if ($ytId) {
            $params = [
                'rel' => '0',
                'enablejsapi' => '1',
            ];
            if ($autoplay) {
                $params['autoplay'] = '1';
                $params['mute'] = '1';
                $params['playsinline'] = '1';
            }
            if ($loop) {
                $params['loop'] = '1';
                $params['playlist'] = $ytId;
            }
            if (!$controls) {
                $params['controls'] = '0';
            }
            $embedUrl = 'https://www.youtube-nocookie.com/embed/' . $ytId . '?' . http_build_query($params);
        }
    }

    // Process Vimeo
    if ($source === 'vimeo' && !empty($rawUrl)) {
        if (preg_match('/(?:vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+))/i', $rawUrl, $matches)) {
            $vimeoId = $matches[1];
        } elseif (is_numeric($rawUrl)) {
            $vimeoId = $rawUrl;
        }

        if ($vimeoId) {
            $params = [
                'dnt' => '1',
            ];
            if ($autoplay) {
                $params['autoplay'] = '1';
                $params['muted'] = '1';
                $params['playsinline'] = '1';
            }
            if ($loop) {
                $params['loop'] = '1';
            }
            if (!$controls) {
                $params['controls'] = '0';
            }
            $embedUrl = 'https://player.vimeo.com/video/' . $vimeoId . '?' . http_build_query($params);
        }
    }

    // Direct HTML5 Video File
    $html5VideoSrc = '';
    if ($source === 'html5' && !empty($rawUrl)) {
        $html5VideoSrc = getVideoUrl($rawUrl);
    }

    // Ratio classes / style
    $ratioClass = 'ratio-16x9';
    $customRatioStyle = '';
    if ($aspectRatio === '4:3') {
        $ratioClass = 'ratio-4x3';
    } elseif ($aspectRatio === '1:1') {
        $ratioClass = 'ratio-1x1';
    } elseif ($aspectRatio === '21:9') {
        $ratioClass = 'ratio-21x9';
    } elseif ($aspectRatio && $aspectRatio !== '16:9' && $aspectRatio !== 'auto') {
        $ratioClass = '';
        $customRatioStyle = "aspect-ratio: {$aspectRatio};";
    }
@endphp

@if ($embedUrl || $html5VideoSrc)
    <div {!! $customId !!} {!! $anim !!} class="block-render-video {{ $align }} {{ $visClass }} {{ $mt }} {{ $mb }} {{ $customClass }}">
        <div class="position-relative d-inline-block w-100" style="max-width: {{ $maxWidth }};">
            
            @if ($embedUrl)
                {{-- YouTube or Vimeo Responsive Iframe --}}
                <div class="ratio {{ $ratioClass }} {{ $rounded }} {{ $shadow }} overflow-hidden" {!! $customRatioStyle ? 'style="' . $customRatioStyle . '"' : '' !!}>
                    <iframe src="{{ $embedUrl }}"
                            title="{{ $caption ?: 'Video player' }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen
                            loading="lazy"></iframe>
                </div>
            @elseif ($html5VideoSrc)
                {{-- HTML5 MP4 / WebM Direct Video Player --}}
                <div class="ratio {{ $ratioClass }} {{ $rounded }} {{ $shadow }} overflow-hidden" {!! $customRatioStyle ? 'style="' . $customRatioStyle . '"' : '' !!}>
                    <video class="w-100 h-100 object-fit-cover"
                           @if ($controls) controls @endif
                           @if ($autoplay) autoplay @endif
                           @if ($loop) loop @endif
                           @if ($muted) muted @endif
                           playsinline
                           @if ($poster) poster="{{ $poster }}" @endif
                           preload="metadata">
                        <source src="{{ $html5VideoSrc }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            @endif

            @if (!empty($caption))
                <figcaption class="small text-muted mt-2 text-center">{{ $caption }}</figcaption>
            @endif
        </div>
    </div>
@endif
