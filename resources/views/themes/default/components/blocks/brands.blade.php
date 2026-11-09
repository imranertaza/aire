@php
    $s = $block['settings'] ?? $block;
    $limit = (int) ($s['limit'] ?? ($block['limit'] ?? 6));
    $limit = ($limit > 0 && $limit <= 24) ? $limit : 6;
    $columnsDesktop = $s['columns_desktop'] ?? ($block['columns_desktop'] ?? 'col-lg-2');
    $columnsMobile = $s['columns_mobile'] ?? ($block['columns_mobile'] ?? 'col-4');
    $grayscale = !isset($s['grayscale']) || !empty($s['grayscale']);
    $boxed = !isset($s['boxed']) || !empty($s['boxed']);

    // Style settings
    $cardBg = !empty($s['card_bg']) ? $s['card_bg'] : '#ffffff';
    $cardBorderColor = !empty($s['card_border_color']) ? $s['card_border_color'] : '';
    $cardRounded = $s['card_rounded'] ?? 'rounded-4';
    $cardShadow = $s['card_shadow'] ?? 'shadow-sm';
    $cardHeight = $s['card_height'] ?? '90px';
    $logoHeight = $s['logo_height'] ?? '55px';
    $hoverEffect = $s['hover_effect'] ?? 'lift';
    $opacity = !empty($s['opacity']) ? $s['opacity'] : '0.65';

    // Visibility
    $vis = $s['visibility'] ?? ($block['visibility'] ?? []);
    $hideClasses = [];
    if (!empty($vis['hideOnMobile']) || !empty($s['hideMobile'])) $hideClasses[] = 'd-none d-md-block';
    if (!empty($vis['hideOnTablet']) || !empty($s['hideTablet'])) $hideClasses[] = 'd-md-none d-lg-block';
    if (!empty($vis['hideOnDesktop']) || !empty($s['hideDesktop'])) $hideClasses[] = 'd-lg-none';
    $hideClassStr = implode(' ', $hideClasses);

    // Margins
    $styles = [];
    $mt = $s['marginTop'] ?? ($block['marginTop'] ?? '');
    $mb = $s['marginBottom'] ?? ($block['marginBottom'] ?? '');
    if ($mt) $styles[] = "margin-top: {$mt};";
    if ($mb) $styles[] = "margin-bottom: {$mb};";
    $styleAttr = !empty($styles) ? 'style="' . implode(' ', $styles) . '"' : '';

    $customClass = $s['custom_class'] ?? ($block['customClass'] ?? '');
    $customId = $s['custom_id'] ?? ($block['customId'] ?? '');
    $customIdAttr = !empty($customId) ? 'id="' . e($customId) . '"' : '';

    // Query active brands
    $brands = \App\Models\Brand::where('status', 1)
        ->orderBy('sort_order', 'asc')
        ->orderBy('id', 'asc')
        ->take($limit)
        ->get();
@endphp

<div {!! $customIdAttr !!} class="builder-block-brands {{ $hideClassStr }} {{ $customClass }}" {!! $styleAttr !!}>
    @if ($brands->isNotEmpty())
        <div class="row g-3 g-md-4 align-items-center justify-content-center">
            @foreach ($brands as $brand)
                @php
                    $brandImg = !empty($brand->image) ? getImageUrl($brand->image, 240, 120) : null;
                    $brandUrl = url('/products?brand=' . $brand->id);
                @endphp
                <div class="{{ $columnsMobile }} col-md-3 {{ $columnsDesktop }} text-center">
                    <a href="{{ $brandUrl }}" title="{{ e($brand->name) }}" class="d-flex align-items-center justify-content-center p-3 text-decoration-none transition-all {{ $boxed ? "border {$cardRounded} {$cardShadow}" : '' }}" style="{{ $boxed ? "background-color: {$cardBg};" : '' }} {{ $cardBorderColor ? "border-color: {$cardBorderColor} !important;" : '' }} height: {{ $cardHeight }}; transition: all 0.25s ease;" onmouseover="this.style.transform='{{ $hoverEffect === 'lift' ? 'translateY(-4px)' : ($hoverEffect === 'zoom' ? 'scale(1.04)' : 'none') }}'; this.style.borderColor='var(--bs-primary, #0d6efd)';" onmouseout="this.style.transform='none'; this.style.borderColor='{{ $cardBorderColor ? $cardBorderColor : '' }}';">
                        @if ($brandImg)
                            <img src="{{ $brandImg }}" alt="{{ e($brand->name) }}" class="img-fluid object-fit-contain w-100 h-100 {{ $grayscale ? 'grayscale-hover' : '' }}" style="{{ $grayscale ? "filter: grayscale(100%); opacity: {$opacity}; transition: filter 0.3s ease, opacity 0.3s ease;" : '' }} max-height: {{ $logoHeight }};" onmouseover="this.style.filter='none'; this.style.opacity='1';" onmouseout="{{ $grayscale ? "this.style.filter='grayscale(100%)'; this.style.opacity='{$opacity}';" : '' }}" loading="lazy">
                        @else
                            <span class="font-weight-bold text-muted small text-truncate px-2">{{ $brand->name }}</span>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5 text-muted bg-light rounded-4 border">
            <i class="fas fa-certificate fa-2x mb-2 text-secondary opacity-50"></i>
            <p class="small mb-0">No active brands found.</p>
        </div>
    @endif
</div>

