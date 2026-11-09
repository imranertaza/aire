@php
    $s = $block['settings'] ?? [];
    $title = $s['title'] ?? '';
    $desc = $s['description'] ?? '';
    $accentType = $s['accentType'] ?? (!empty($s['number']) ? 'number' : (!empty($s['badge']) ? 'badge' : (!empty($s['icon']) ? 'icon' : 'none')));
    $number = $s['number'] ?? '';
    $badge = $s['badge'] ?? '';
    $icon = $s['icon'] ?? '';
    $preset = $s['cardStylePreset'] ?? (!empty($s['isGlass']) ? 'glass' : 'white');
    $pad = $s['padding'] ?? 'p-4';
    $rounded = $s['rounded'] ?? 'rounded-4';
    $shadow = $s['shadow'] ?? 'shadow-sm';
    $hoverEffect = $s['hoverEffect'] ?? '';
    $linkUrl = $s['link_url'] ?? '';
    $targetBlank = !empty($s['target_blank']) ? 'target="_blank" rel="noopener noreferrer"' : '';
    
    $vis = $s['visibility'] ?? [];
    $visClass = '';
    if (!empty($vis['hideOnMobile'])) $visClass .= ' d-none d-md-block';
    if (!empty($vis['hideOnDesktop'])) $visClass .= ' d-lg-none';
    if (!empty($vis['hideOnTablet'])) $visClass .= ' d-md-none d-lg-block';

    $isDarkOrGlass = in_array($preset, ['glass', 'dark']);
    
    // Determine card background and classes
    if ($preset === 'glass') {
        $cardClass = "box-glass-card {$rounded} {$pad}";
    } elseif ($preset === 'dark') {
        $cardClass = "bg-dark text-white border-0 {$rounded} {$pad} {$shadow}";
    } elseif ($preset === 'light') {
        $cardClass = "bg-light text-dark border {$rounded} {$pad}";
    } elseif ($preset === 'custom') {
        $cardClass = "{$rounded} {$pad} {$shadow}";
    } else {
        $cardClass = "bg-white border {$rounded} {$pad} {$shadow} text-dark";
    }

    $cardStyles = [];
    if ($preset === 'custom') {
        if (!empty($s['customBgColor'])) $cardStyles[] = "background-color: {$s['customBgColor']};";
        if (!empty($s['customBorderColor'])) $cardStyles[] = "border: 1px solid {$s['customBorderColor']};";
    }
    $styleAttr = !empty($cardStyles) ? 'style="' . implode(' ', $cardStyles) . '"' : '';

    $mt = $s['marginTop'] ?? '';
    $mb = isset($s['marginBottom']) ? $s['marginBottom'] : 'my-2';
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

<div {!! $customId !!} {!! $anim !!} class="{{ $visClass }} {{ $mt }} {{ $mb }} {{ $customClass }} h-100">
    @if ($linkUrl)
        <a href="{{ $linkUrl }}" {!! $targetBlank !!} class="text-decoration-none d-block h-100 text-inherit">
    @endif

    <div class="{{ $cardClass }} {{ $hoverEffect }} h-100 transition-all" {!! $styleAttr !!}>
        @if ($accentType === 'number' && $number)
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="box-card-num fw-bold {{ $isDarkOrGlass ? 'text-white' : 'text-primary' }}" style="font-size: 1.5rem;">
                    {{ $number }}
                </span>
            </div>
        @elseif ($accentType === 'badge' && $badge)
            <span class="badge bg-primary px-2 py-1 mb-2 font-weight-bold" style="font-size: 0.72rem;">{{ $badge }}</span>
        @elseif ($accentType === 'icon' && $icon)
            <div class="card-accent-icon-wrap rounded-circle d-inline-flex align-items-center justify-content-center mb-3 {{ $isDarkOrGlass ? 'bg-white text-dark' : 'bg-primary text-white' }}" style="width: 44px; height: 44px; font-size: 1.15rem;">
                <i class="{{ $icon }}"></i>
            </div>
        @endif
        
        @if ($title)
            <h3 class="box-card-title fw-bold mb-2 {{ $isDarkOrGlass ? 'text-white' : 'text-dark' }}" style="font-size: 1.1rem;">
                {{ $title }}
            </h3>
        @endif
        
        @if ($desc)
            <p class="box-card-desc mb-0 small {{ $isDarkOrGlass ? 'text-light opacity-90' : 'text-secondary' }}" style="line-height: 1.6;">
                {{ $desc }}
            </p>
        @endif
    </div>

    @if ($linkUrl)
        </a>
    @endif
</div>
