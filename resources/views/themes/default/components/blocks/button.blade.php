@php
    $s = $block['settings'] ?? [];
    $text = $s['text'] ?? 'Click Here';
    $url = $s['url'] ?? '#';
    $variant = $s['variant'] ?? 'btn-primary';
    $size = $s['size'] ?? 'btn-md';
    $rounded = $s['rounded'] ?? 'rounded-2';
    $shadow = $s['shadow'] ?? 'shadow-sm';
    $icon = $s['icon'] ?? '';
    $iconPos = $s['iconPos'] ?? 'right';
    $targetBlank = !empty($s['target_blank']) ? 'target="_blank" rel="noopener noreferrer"' : '';
    $fullWidthMobile = !empty($s['fullWidthMobile']) ? 'w-100 w-md-auto' : '';
    $hoverEffect = $s['hoverEffect'] ?? '';
    
    $align = $s['align'] ?? 'text-start';
    if (is_array($align)) {
        $alignClass = ($align['mobile'] ?? 'text-center') . ' ' . str_replace('text-', 'text-md-', $align['desktop'] ?? 'text-start');
    } else {
        $alignClass = $align;
    }

    $vis = $s['visibility'] ?? [];
    $visClass = '';
    if (!empty($vis['hideOnMobile'])) $visClass .= ' d-none d-md-block';
    if (!empty($vis['hideOnDesktop'])) $visClass .= ' d-lg-none';
    if (!empty($vis['hideOnTablet'])) $visClass .= ' d-md-none d-lg-block';

    $btnStyles = [];
    if (!empty($s['customBgColor'])) {
        $btnStyles[] = "background-color: {$s['customBgColor']} !important; border-color: {$s['customBgColor']} !important;";
    }
    if (!empty($s['customTextColor'])) {
        $btnStyles[] = "color: {$s['customTextColor']} !important;";
    }
    $styleAttr = !empty($btnStyles) ? 'style="' . implode(' ', $btnStyles) . '"' : '';

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
@endphp

@if ($text)
    <div {!! $customId !!} {!! $anim !!} class="{{ $alignClass }} {{ $visClass }} {{ $mt }} {{ $mb }} {{ $customClass }}">
        <a href="{{ $url }}" {!! $targetBlank !!} 
           class="btn {{ empty($s['customBgColor']) ? $variant : '' }} {{ $size }} {{ $rounded }} {{ $shadow }} {{ $fullWidthMobile }} {{ $hoverEffect }} px-4 py-2 fw-semibold d-inline-flex align-items-center justify-content-center"
           {!! $styleAttr !!}>
            @if ($icon && $iconPos === 'left')
                <i class="{{ $icon }} me-2 small"></i>
            @endif
            <span>{{ $text }}</span>
            @if ($icon && $iconPos === 'right')
                <i class="{{ $icon }} ms-2 small"></i>
            @endif
        </a>
    </div>
@endif
