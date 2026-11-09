@php
    $s = $block['settings'] ?? $block;
    $source = $s['source'] ?? ($block['source'] ?? 'latest');
    $categoryId = !empty($s['category_id']) ? (int) $s['category_id'] : (!empty($block['category_id']) ? (int) $block['category_id'] : null);
    $limit = (int) ($s['limit'] ?? ($block['limit'] ?? 4));
    $limit = ($limit > 0 && $limit <= 24) ? $limit : 4;
    $columnsDesktop = $s['columns_desktop'] ?? ($block['columns_desktop'] ?? 'col-lg-3');
    $columnsMobile = $s['columns_mobile'] ?? ($block['columns_mobile'] ?? 'col-6');
    
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

    // Query active products based on block source configuration
    $productsQuery = \App\Models\Product::withCatalogRelations()->active();
    if ($source === 'featured') {
        $productsQuery->where('featured', 1);
    } elseif ($source === 'category' && $categoryId) {
        $productsQuery->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('product_categories.id', $categoryId);
        });
    } else {
        $productsQuery->latest();
    }
    $products = $productsQuery->take($limit)->get();
@endphp

<div {!! $customIdAttr !!} class="builder-block-products {{ $hideClassStr }} {{ $customClass }}" {!! $styleAttr !!}>
    @if ($products->isNotEmpty())
        <div class="row g-3 g-md-4">
            @foreach ($products as $product)
                <div class="{{ $columnsMobile }} col-md-6 {{ $columnsDesktop }} d-flex">
                    <div class="w-100">
                        @include('themes.default.partials.product_card', ['product' => $product])
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-4 text-muted bg-light rounded-4 border">
            <i class="fas fa-box-open fa-2x mb-2 text-secondary opacity-50"></i>
            <p class="small mb-0">No active products found matching the criteria.</p>
        </div>
    @endif
</div>
