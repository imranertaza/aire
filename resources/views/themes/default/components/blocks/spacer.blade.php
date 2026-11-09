@php
    $s = $block['settings'] ?? [];
    $height = $s['height'] ?? '30px';
    $isDivider = !empty($s['isDivider']);
    $dividerStyle = $s['dividerStyle'] ?? 'solid';
    
    $vis = $s['visibility'] ?? [];
    $visClass = '';
    if (!empty($vis['hideOnMobile'])) $visClass .= ' d-none d-md-block';
    if (!empty($vis['hideOnDesktop'])) $visClass .= ' d-lg-none';
    if (!empty($vis['hideOnTablet'])) $visClass .= ' d-md-none d-lg-block';

    $mt = $s['marginTop'] ?? '';
    $mb = isset($s['marginBottom']) ? $s['marginBottom'] : '';
    $customClass = $s['custom_class'] ?? '';
    $customId = !empty($s['custom_id']) ? 'id="' . e($s['custom_id']) . '"' : '';
@endphp

<div {!! $customId !!} class="{{ $visClass }} {{ $mt }} {{ $mb }} {{ $customClass }}">
    @if ($isDivider)
        <hr class="my-4" style="border-top-style: {{ $dividerStyle }}; border-top-width: 1px; border-top-color: rgba(0,0,0,0.12);">
    @else
        <div style="height: {{ $height }};"></div>
    @endif
</div>
