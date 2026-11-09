@php
    $data = $section->data ?? [];
    $blocks = $data['blocks'] ?? [];
    $headerTitle = !empty($data['header_title']) ? $data['header_title'] : (!empty($data['title']) && $data['title'] !== $section->name ? $data['title'] : '');
    $badge = $data['badge'] ?? '';
    $subtitle = $data['subtitle'] ?? '';
    $headerAlign = $data['header_align'] ?? 'text-center';
    $rawTag = $data['header_title_tag'] ?? 'h2';
    $headerTag = in_array($rawTag, ['h1', 'h2', 'h3', 'h4']) ? $rawTag : 'h2';
    $headerColor = $data['header_title_color'] ?? '';
    $badgeStyle = $data['header_badge_style'] ?? 'text'; // 'pill', 'soft', 'outline', 'text'
    
    // Background options
    $isTransparent = !empty($data['is_transparent_bg']) || ($data['background_color'] ?? '') === 'transparent';
    $bg = $isTransparent ? 'transparent' : ($data['background_color'] ?? '');
    $bgImg = $data['background_image'] ?? '';
    $enableOverlay = !empty($data['enable_overlay']) && !empty($bgImg);
    $overlayColor = $data['overlay_color'] ?? '#000000';
    $overlayOpacity = $data['overlay_opacity'] ?? 0.5;
    
    // Container & Layout
    $containerType = $data['container_type'] ?? 'container';
    $minHeight = $data['min_height'] ?? '';
    $customClass = $data['custom_class'] ?? '';
    $sectionId = !empty($data['custom_id']) ? $data['custom_id'] : $section->name;
    
    // Padding logic (presets and custom pixel padding)
    $paddingMode = $data['padding_mode'] ?? 'preset';
    $paddingY = $data['padding_y'] ?? [];
    $customPadding = $data['custom_padding'] ?? [];
    
    $styles = [];
    $pyClass = '';
    
    if ($paddingMode === 'custom') {
        $ptD = !empty($customPadding['pt_desktop']) ? $customPadding['pt_desktop'] : '80px';
        $pbD = !empty($customPadding['pb_desktop']) ? $customPadding['pb_desktop'] : '80px';
        $ptM = !empty($customPadding['pt_mobile']) ? $customPadding['pt_mobile'] : '40px';
        $pbM = !empty($customPadding['pb_mobile']) ? $customPadding['pb_mobile'] : '40px';
        
        $styles[] = "--builder-pt-d: {$ptD};";
        $styles[] = "--builder-pb-d: {$pbD};";
        $styles[] = "--builder-pt-m: {$ptM};";
        $styles[] = "--builder-pb-m: {$pbM};";
        $pyClass = 'builder-custom-pad';
    } else {
        $mobilePy = is_array($paddingY) ? ($paddingY['mobile'] ?? 'py-4') : 'py-4';
        $desktopPy = is_array($paddingY) ? str_replace('py-', 'py-md-', $paddingY['desktop'] ?? 'py-5') : 'py-md-5';
        $pyClass = "{$mobilePy} {$desktopPy}";
    }

    if ($isTransparent) {
        $styles[] = "background-color: transparent;";
    } elseif ($bg) {
        $styles[] = "background-color: {$bg};";
    }
    if ($bgImg) {
        $imgUrl = getImageUrl($bgImg);
        $styles[] = "background-image: url('{$imgUrl}'); background-size: cover; background-position: center;";
    }
    if ($minHeight) {
        $styles[] = "min-height: {$minHeight};";
    }

    $sectionStyle = !empty($styles) ? 'style="' . implode(' ', $styles) . '"' : '';
@endphp

@once
<style>
    /* Extended spacing utilities for Bootstrap */
    .py-6 { padding-top: 5rem !important; padding-bottom: 5rem !important; }
    .py-7 { padding-top: 6.5rem !important; padding-bottom: 6.5rem !important; }
    .py-8 { padding-top: 8rem !important; padding-bottom: 8rem !important; }
    @media (min-width: 768px) {
        .py-md-6 { padding-top: 5rem !important; padding-bottom: 5rem !important; }
        .py-md-7 { padding-top: 6.5rem !important; padding-bottom: 6.5rem !important; }
        .py-md-8 { padding-top: 8rem !important; padding-bottom: 8rem !important; }
    }
    /* Dynamic pixel-perfect custom padding */
    .builder-custom-pad {
        padding-top: var(--builder-pt-m, 40px) !important;
        padding-bottom: var(--builder-pb-m, 40px) !important;
    }
    @media (min-width: 768px) {
        .builder-custom-pad {
            padding-top: var(--builder-pt-d, 80px) !important;
            padding-bottom: var(--builder-pb-d, 80px) !important;
        }
    }

    /* Native Scroll Entrance Animation Engine */
    [data-builder-anim] {
        opacity: 0;
        transition-property: opacity, transform;
        transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1);
        will-change: opacity, transform;
    }
    [data-builder-anim="fade-up"] { transform: translateY(32px); }
    [data-builder-anim="fade-down"] { transform: translateY(-32px); }
    [data-builder-anim="fade-left"] { transform: translateX(32px); }
    [data-builder-anim="fade-right"] { transform: translateX(-32px); }
    [data-builder-anim="zoom-in"] { transform: scale(0.92); }
    [data-builder-anim="flip-up"] { transform: perspective(1000px) rotateX(25deg); }

    [data-builder-anim].is-animated {
        opacity: 1 !important;
        transform: none !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!('IntersectionObserver' in window)) {
            document.querySelectorAll('[data-builder-anim]').forEach(function(el) { el.classList.add('is-animated'); });
            return;
        }
        var animObserver = new IntersectionObserver(function(entries, obs) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var el = entry.target;
                    var delay = parseInt(el.getAttribute('data-anim-delay') || '0', 10);
                    var duration = parseInt(el.getAttribute('data-anim-duration') || '600', 10);
                    el.style.transitionDuration = duration + 'ms';
                    el.style.transitionDelay = delay + 'ms';
                    el.classList.add('is-animated');
                    obs.unobserve(el);
                }
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('[data-builder-anim]').forEach(function(el) { animObserver.observe(el); });
    });
</script>
@endonce

<section id="{{ $sectionId }}" class="content-visibility-auto {{ $pyClass }} {{ $customClass }} position-relative overflow-hidden" {!! $sectionStyle !!}>
    {{-- Optional Background Overlay --}}
    @if ($enableOverlay)
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background-color: {{ $overlayColor }}; opacity: {{ $overlayOpacity }}; pointer-events: none; z-index: 1;"></div>
    @endif

    <div class="{{ $containerType }}" style="position: relative; z-index: 2;">
        {{-- Optional Dynamic Section Header --}}
        @if ($badge || $headerTitle || $subtitle)
            <div class="{{ $headerAlign }} mb-4 mb-md-5">
                @if ($badge)
                    @if ($badgeStyle === 'pill')
                        <div class="mb-2">
                            <span class="badge rounded-pill bg-primary text-uppercase px-3 py-1 font-weight-bold" style="letter-spacing: 1px; font-size: 0.75rem;">
                                {{ $badge }}
                            </span>
                        </div>
                    @elseif ($badgeStyle === 'soft')
                        <div class="mb-2">
                            <span class="badge bg-light text-primary border text-uppercase px-3 py-1 font-weight-bold" style="letter-spacing: 1px; font-size: 0.75rem;">
                                {{ $badge }}
                            </span>
                        </div>
                    @elseif ($badgeStyle === 'outline')
                        <div class="mb-2">
                            <span class="badge border border-primary text-primary text-uppercase px-3 py-1 font-weight-bold" style="letter-spacing: 1px; font-size: 0.75rem;">
                                {{ $badge }}
                            </span>
                        </div>
                    @else
                        <div class="text-uppercase text-primary small fw-bold mb-2" style="font-size: 0.75rem; letter-spacing: 1.5px;">
                            {{ $badge }}
                        </div>
                    @endif
                @endif

                @if ($headerTitle)
                    <{{ $headerTag }} class="fw-bold mb-2 title-2" style="letter-spacing: -0.5px; {{ $headerColor ? 'color: ' . $headerColor . ' !important;' : '' }}">
                        {{ $headerTitle }}
                    </{{ $headerTag }}>
                @endif

                @if ($subtitle)
                    <p class="text-secondary small {{ $headerAlign === 'text-center' ? 'mx-auto' : '' }}" style="max-width: 650px;">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        @endif

        {{-- Dynamic Block Renderers --}}
        @if (!empty($blocks))
            @foreach ($blocks as $block)
                @php $type = $block['type'] ?? ''; @endphp
                @if ($type && view()->exists("themes.default.components.blocks.{$type}"))
                    @include("themes.default.components.blocks.{$type}", ['block' => $block])
                @endif
            @endforeach
        @endif
    </div>
</section>
