@php
    $s = $block['settings'] ?? $block;
    $limit = (int) ($s['limit'] ?? ($block['limit'] ?? 6));
    $limit = ($limit > 0 && $limit <= 24) ? $limit : 6;
    $columnsDesktop = $s['columns_desktop'] ?? ($block['columns_desktop'] ?? 'col-lg-2');
    $columnsMobile = $s['columns_mobile'] ?? ($block['columns_mobile'] ?? 'col-6');
    $showCount = !isset($s['show_count']) || !empty($s['show_count']);
    $styleVariant = $s['style_variant'] ?? 'card'; // 'card' or 'pill' or 'circle'
    $cardRounded = $s['card_rounded'] ?? 'rounded-4';
    $cardShadow = $s['card_shadow'] ?? 'shadow-sm';

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

    // Query active parent/top categories
    $query = \App\Models\ProductCategory::where('status', 1)
        ->whereNull('parent_id')
        ->withCount(['products' => function($q) {
            $q->where('status', 1);
        }])
        ->orderBy('sort_order', 'asc')
        ->orderBy('id', 'asc');

    $categories = $query->take($limit)->get();
@endphp

<div {!! $customIdAttr !!} class="builder-block-categories {{ $hideClassStr }} {{ $customClass }}" {!! $styleAttr !!}>
    @if ($categories->isNotEmpty())
        <div class="row g-3 g-md-4">
            @foreach ($categories as $cat)
                @php
                    $catUrl = !empty($cat->slug) ? route('category.show', $cat->slug) : '#';
                    $catImg = !empty($cat->image) ? getImageUrl($cat->image, 300, 300) : theme_asset('img/placeholder-category.png');
                    $bgColor = !empty($s['card_bg']) ? $s['card_bg'] : (!empty($cat->bg_color) ? $cat->bg_color : '#f8fafc');
                @endphp
                <div class="{{ $columnsMobile }} col-md-4 {{ $columnsDesktop }} d-flex">
                    <a href="{{ $catUrl }}" class="card border-0 {{ $cardRounded }} p-3 text-center text-decoration-none w-100 {{ $cardShadow }} transition-all text-dark" style="background-color: {{ $bgColor }}; transition: transform 0.25s ease, box-shadow 0.25s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px -10px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">
                        <div class="d-flex align-items-center justify-content-center mx-auto mb-3 rounded-circle overflow-hidden bg-white shadow-sm" style="width: 76px; height: 76px;">
                            @if (!empty($cat->image))
                                <img src="{{ $catImg }}" alt="{{ e($cat->category_name) }}" class="w-100 h-100 object-fit-contain p-2" loading="lazy">
                            @elseif (!empty($cat->icon_class))
                                <i class="{{ $cat->icon_class }} fa-2x text-primary"></i>
                            @else
                                <i class="fas fa-th-large fa-2x text-primary"></i>
                            @endif
                        </div>
                        <h6 class="font-weight-bold mb-1 text-truncate w-100" style="font-size: 0.95rem;">
                            {{ $cat->category_name }}
                        </h6>
                        @if ($showCount)
                            <span class="small text-muted" style="font-size: 0.78rem;">
                                {{ $cat->products_count ?? 0 }} {{ \Illuminate\Support\Str::plural('Product', $cat->products_count ?? 0) }}
                            </span>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5 text-muted bg-light rounded-4 border">
            <i class="fas fa-layer-group fa-2x mb-2 text-secondary opacity-50"></i>
            <p class="small mb-0">No active categories found.</p>
        </div>
    @endif
</div>

