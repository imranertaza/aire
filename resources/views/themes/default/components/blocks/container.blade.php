@php
    $s = $block['settings'] ?? [];
    $cols = $block['columns'] ?? [];
    $colCount = count($cols);
    $layout = $s['layout'] ?? [];
    
    // Responsive columns class
    $desktopCol = is_array($layout) ? ($layout['desktop'] ?? '') : '';
    if (!$desktopCol) {
        if ($colCount === 1) $desktopCol = 'col-lg-12';
        elseif ($colCount === 2) $desktopCol = 'col-lg-6';
        elseif ($colCount === 3) $desktopCol = 'col-lg-4';
        elseif ($colCount === 4) $desktopCol = 'col-lg-3';
        elseif ($colCount === 5) $desktopCol = 'col-lg';
        elseif ($colCount === 6) $desktopCol = 'col-lg-2';
        else $desktopCol = 'col-lg';
    }

    $tabletCol = is_array($layout) ? ($layout['tablet'] ?? '') : '';
    if (!$tabletCol) {
        $tabletCol = ($colCount >= 4) ? 'col-md-4' : 'col-md-6';
    }

    $mobileCol = is_array($layout) ? ($layout['mobile'] ?? '') : '';
    if (!$mobileCol) {
        $mobileCol = ($colCount >= 4) ? 'col-6' : 'col-12';
    }

    $colClass = "{$mobileCol} {$tabletCol} {$desktopCol}";
    $customColClasses = $s['columnClasses'] ?? [];

    // Responsive gap
    $gap = $s['gap'] ?? [];
    $mobileGap = is_array($gap) ? ($gap['mobile'] ?? 'g-3') : 'g-3';
    $desktopGap = is_array($gap) ? str_replace('g-', 'g-md-', $gap['desktop'] ?? 'g-4') : 'g-md-4';
    $gapClass = "{$mobileGap} {$desktopGap}";

    // Responsive stack order: normal vs reverse on mobile
    $stackOrderMobile = $s['stackOrderMobile'] ?? 'default';
    $rowFlexClass = ($stackOrderMobile === 'reverse') ? 'flex-column-reverse flex-md-row' : '';

    $vAlign = $s['verticalAlign'] ?? 'align-items-center';

    // Visibility
    $vis = $s['visibility'] ?? [];
    $visClass = '';
    if (!empty($vis['hideOnMobile'])) $visClass .= ' d-none d-md-flex';
    if (!empty($vis['hideOnDesktop'])) $visClass .= ' d-lg-none';
    if (!empty($vis['hideOnTablet'])) $visClass .= ' d-md-none d-lg-flex';

    // Wrapper background and padding
    $bgColor = $s['bgColor'] ?? '';
    $wrapPad = $s['padding'] ?? '';
    $wrapRounded = $s['rounded'] ?? '';
    $wrapStyles = $bgColor ? "background-color: {$bgColor};" : '';

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

@if ($colCount > 0)
    <div {!! $customId !!} {!! $anim !!} class="{{ $wrapPad }} {{ $wrapRounded }} {{ $mt }} {{ $mb }} {{ $customClass }}" {!! $wrapStyles ? 'style="' . $wrapStyles . '"' : '' !!}>
        <div class="row {{ $gapClass }} {{ $vAlign }} {{ $rowFlexClass }} {{ $visClass }}">
            @foreach ($cols as $colIdx => $colBlocks)
                @php
                    $thisColClass = !empty($customColClasses[$colIdx]) ? $customColClasses[$colIdx] : $colClass;
                @endphp
                <div class="{{ $thisColClass }}">
                    @if (is_array($colBlocks))
                        @foreach ($colBlocks as $childBlock)
                            @php $childType = $childBlock['type'] ?? ''; @endphp
                            @if ($childType && view()->exists("themes.default.components.blocks.{$childType}"))
                                @include("themes.default.components.blocks.{$childType}", ['block' => $childBlock])
                            @endif
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif
