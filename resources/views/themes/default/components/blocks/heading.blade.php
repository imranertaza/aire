@php
    $s = $block['settings'] ?? [];
    $text = $s['text'] ?? '';
    $badge = $s['badge'] ?? '';
    $tag = in_array(strtolower($s['tag'] ?? 'h2'), ['h1', 'h2', 'h3', 'h4', 'h5', 'h6']) ? strtolower($s['tag']) : 'h2';
    
    // Responsive alignment
    $align = $s['align'] ?? 'text-start';
    if (is_array($align)) {
        $alignClass = ($align['mobile'] ?? 'text-center') . ' ' . str_replace('text-', 'text-md-', $align['desktop'] ?? 'text-start');
    } else {
        $alignClass = $align;
    }
    
    // Visibility
    $vis = $s['visibility'] ?? [];
    $visClass = '';
    if (!empty($vis['hideOnMobile'])) $visClass .= ' d-none d-md-block';
    if (!empty($vis['hideOnDesktop'])) $visClass .= ' d-lg-none';
    if (!empty($vis['hideOnTablet'])) $visClass .= ' d-md-none d-lg-block';

    // Font size preset
    $fontSizeClass = empty($s['fontSizeCustom']) ? ($s['fontSize'] ?? 'title-2') : '';
    if (is_array($fontSizeClass)) {
        $fontSizeClass = ($fontSizeClass['mobile'] ?? 'fs-18') . ' ' . ($fontSizeClass['desktop'] ?? 'title-2');
    }

    // Inline CSS styles
    $styles = [];
    if (!empty($s['color'])) $styles[] = "color: {$s['color']} !important;";
    if (!empty($s['fontSizeCustom'])) $styles[] = "font-size: {$s['fontSizeCustom']} !important;";
    if (!empty($s['fontWeight'])) $styles[] = "font-weight: {$s['fontWeight']} !important;";
    if (!empty($s['letterSpacing'])) $styles[] = "letter-spacing: {$s['letterSpacing']} !important;";
    if (!empty($s['lineHeight'])) $styles[] = "line-height: {$s['lineHeight']} !important;";
    if (!empty($s['textTransform'])) $styles[] = "text-transform: {$s['textTransform']} !important;";
    $styleAttr = !empty($styles) ? 'style="' . implode(' ', $styles) . '"' : '';

    $mt = $s['marginTop'] ?? '';
    $mb = isset($s['marginBottom']) ? $s['marginBottom'] : 'mb-3';
    $customClass = $s['custom_class'] ?? '';
    $hoverEffect = $s['hoverEffect'] ?? '';
    $customId = !empty($s['custom_id']) ? 'id="' . e($s['custom_id']) . '"' : '';

    $anim = !empty($s['scrollAnimation']) ? 'data-builder-anim="' . e($s['scrollAnimation']) . '" data-aos="' . e($s['scrollAnimation']) . '"' : '';
    if ($anim && !empty($s['animationDelay'])) {
        $anim .= ' data-anim-delay="' . intval($s['animationDelay']) . '" data-aos-delay="' . intval($s['animationDelay']) . '"';
    }
    if ($anim && !empty($s['animationDuration'])) {
        $anim .= ' data-anim-duration="' . intval($s['animationDuration']) . '" data-aos-duration="' . intval($s['animationDuration']) . '"';
    }
@endphp

@if ($text)
    <div {!! $customId !!} {!! $anim !!} class="{{ $alignClass }} {{ $visClass }} {{ $mt }} {{ $mb }} {{ $customClass }}">
        @if ($badge)
            <div class="mb-2">
                <span class="badge rounded-pill bg-light text-primary border text-uppercase px-2 py-1 fw-bold" style="letter-spacing: 1px; font-size: 0.72rem;">
                    {{ $badge }}
                </span>
            </div>
        @endif
        <{{ $tag }} class="fw-bold {{ $fontSizeClass }} {{ $hoverEffect }} mb-0" {!! $styleAttr !!}>
            {{ $text }}
        </{{ $tag }}>
    </div>
@endif
