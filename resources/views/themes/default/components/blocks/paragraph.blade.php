@php
    $s = $block['settings'] ?? [];
    $text = $s['text'] ?? '';
    
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

    $isLead = !empty($s['isLead']);
    $fontSizeClass = empty($s['fontSizeCustom']) ? ($isLead ? 'lead fs-5' : ($s['fontSize'] ?? 'fs-6')) : '';

    $styles = [];
    if (!empty($s['color'])) $styles[] = "color: {$s['color']} !important;";
    if (!empty($s['fontSizeCustom'])) $styles[] = "font-size: {$s['fontSizeCustom']} !important;";
    if (!empty($s['fontWeight'])) $styles[] = "font-weight: {$s['fontWeight']} !important;";
    if (!empty($s['lineHeight'])) $styles[] = "line-height: {$s['lineHeight']} !important;";
    if (!empty($s['textTransform'])) $styles[] = "text-transform: {$s['textTransform']} !important;";
    if (!empty($s['letterSpacing'])) $styles[] = "letter-spacing: {$s['letterSpacing']} !important;";
    if (!empty($s['maxWidth'])) $styles[] = "max-width: {$s['maxWidth']}; margin-left: auto; margin-right: auto;";
    $styleAttr = !empty($styles) ? 'style="' . implode(' ', $styles) . '"' : '';

    $mt = $s['marginTop'] ?? '';
    $mb = isset($s['marginBottom']) ? $s['marginBottom'] : 'mb-3';
    $customClass = $s['custom_class'] ?? '';
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
        <p class="{{ $fontSizeClass }} {{ empty($s['color']) ? 'text-secondary' : '' }} mb-0" {!! $styleAttr !!}>
            {!! nl2br(e($text)) !!}
        </p>
    </div>
@endif
