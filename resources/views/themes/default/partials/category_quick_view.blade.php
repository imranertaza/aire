@php
    $overlayId = 'quickViewSectionCat-' . $cat->id;
    $trackId = 'megamenuProductsTrack-cat-' . $cat->id;
    $prevBtnId = 'megamenuScrollPrev-cat-' . $cat->id;
    $nextBtnId = 'megamenuScrollNext-cat-' . $cat->id;
    $currencySymbol = '$';
    $childCategories = $cat->children ?? collect();
    $hasChildren = $childCategories->isNotEmpty();
@endphp

<div id="{{ $overlayId }}" class="megamenu-quickview-overlay category-showcase-quickview-overlay" role="dialog"
    aria-label="{{ $cat->category_name }} Quick View" aria-hidden="true" data-megamenu-id="{{ $overlayId }}">
    <div class="air-purifiers-quickview-card">

        <!-- Top Header Row -->
        <div class="quickview-header">
            <div>
                <h3 class="quickview-title">
                    {{ $cat->category_name }}
                    <span class="quickview-title-sep">|</span>
                    <span class="quickview-title-sub">Quick View</span>
                </h3>
                <p class="quickview-desc">
                    {{ $cat->description ?: $cat->category_name . ' provide clean, healthy and efficient indoor air solutions.' }}
                </p>
            </div>
            <button type="button" class="quickview-close-btn" aria-label="Close Quick View">
                <i class="bi bi-x-lg" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Category-Wise Grouped Carousel Track -->
        <div class="quickview-carousel-wrapper">
            <button type="button" class="quickview-scroll-btn prev" id="{{ $prevBtnId }}"
                aria-label="Scroll left">
                <i class="bi bi-chevron-left"></i>
            </button>

            <div class="quickview-groups-track" id="{{ $trackId }}">
                @if ($hasChildren)
                    @foreach ($childCategories as $cIndex => $childCat)
                        @php
                            $childProducts = $childCat->quick_products ?? ($childCat->products ?? collect());
                            $visibleProducts = $childProducts->take(4);
                            $cardCount = $visibleProducts->count();
                            $groupWidth = $cardCount > 0 ? $cardCount * 168 + ($cardCount - 1) * 12 : 220;
                            $pillStyle = match ($cIndex % 4) {
                                1 => 'active',
                                2 => 'green',
                                3 => 'red',
                                default => '',
                            };
                            $iconBgClass = match ($pillStyle) {
                                'green' => 'green',
                                'red' => 'red',
                                default => 'blue',
                            };
                            $defaultIcon = match ($cIndex % 4) {
                                0 => 'bi bi-person',
                                1 => 'bi bi-car-front',
                                2 => 'bi bi-house-door',
                                default => 'bi bi-grid',
                            };
                            $iconClass = $childCat->icon_class ?: $defaultIcon;
                            $catDetailUrl = route('category.show', $childCat->slug ?: $childCat->id);
                        @endphp
                        <div class="quickview-category-group"
                            style="width: {{ $groupWidth }}px; max-width: {{ $groupWidth }}px;">
                            <!-- Category Header Pill -->
                            <a href="{{ $catDetailUrl }}" class="quickview-group-pill {{ $pillStyle }}">
                                @if ($pillStyle === 'red')
                                    <div class="quickview-pill-text text-center w-100">
                                        <span
                                            class="quickview-pill-name red-badge-text">{{ $childCat->category_name }}</span>
                                    </div>
                                @else
                                    <div class="quickview-pill-icon-circle {{ $iconBgClass }}">
                                        <i class="{{ $iconClass }}"></i>
                                    </div>
                                    <div class="quickview-pill-text w-100">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="quickview-pill-name">{{ $childCat->category_name }}</span>
                                        </div>
                                        <span
                                            class="quickview-pill-desc">{{ $childCat->description ?: 'Explore ' . $childCat->category_name }}</span>
                                    </div>
                                @endif
                            </a>

                            <!-- Product Cards Row: up to 4 products per child category -->
                            <div class="quickview-group-cards">
                                @forelse ($visibleProducts as $product)
                                    @php
                                        $detailUrl = route('products.detail', $product->slug ?: $product->id);
                                        $displayImg = !empty($product->quickview_image)
                                            ? $product->quickview_image
                                            : $product->main_image;
                                        $imgUrl = !empty($displayImg)
                                            ? getImageCacheUrl($displayImg, 400, 400, 'webp')
                                            : theme_asset('img/Air-Purify.png');
                                        $brandName = $product->brand?->name ?? 'BROAD Fresh Air';
                                        $priceFormatted =
                                            $currencySymbol . number_format((float) ($product->price ?? 0), 2);
                                    @endphp
                                    <div class="quickview-product-card">
                                        <div class="quickview-product-img-box">
                                            <a href="{{ $detailUrl }}" tabindex="-1">
                                                <img src="{{ $imgUrl }}" alt="{{ $product->name }}"
                                                    loading="lazy">
                                            </a>
                                        </div>
                                        <span class="quickview-product-brand">{{ $brandName }}</span>
                                        <h4 class="quickview-product-name" title="{{ $product->name }}">
                                            <a href="{{ $detailUrl }}" class="text-decoration-none text-dark">
                                                {{ $product->name }}
                                            </a>
                                        </h4>
                                        <div class="quickview-product-price">{{ $priceFormatted }}</div>
                                        <a href="{{ $detailUrl }}" class="quickview-product-btn">View
                                            details</a>
                                    </div>
                                @empty
                                    <div
                                        class="quickview-product-card d-flex align-items-center justify-content-center text-muted p-4">
                                        <span class="fs-13">No products available</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Direct category products when there are no child subcategories --}}
                    @php
                        $catProducts = $cat->quick_products ?? ($cat->products ?? collect());
                        $visibleProducts = $catProducts->take(8);
                        $chunks = $visibleProducts->chunk(4);
                        if ($chunks->isEmpty()) {
                            $chunks = collect([collect()]);
                        }
                    @endphp
                    @foreach ($chunks as $chunkIndex => $chunkProds)
                        @php
                            $cardCount = $chunkProds->count();
                            $groupWidth = $cardCount > 0 ? $cardCount * 168 + ($cardCount - 1) * 12 : 220;
                            $catDetailUrl = route('category.show', $cat->slug ?: $cat->id);
                            $iconClass = $cat->icon_class ?: 'bi bi-grid';
                            $pillStyle = match ($chunkIndex % 4) {
                                1 => 'active',
                                2 => 'green',
                                3 => 'red',
                                default => '',
                            };
                            $iconBgClass = match ($pillStyle) {
                                'green' => 'green',
                                'red' => 'red',
                                default => 'blue',
                            };
                        @endphp
                        <div class="quickview-category-group"
                            style="width: {{ $groupWidth }}px; max-width: {{ $groupWidth }}px;">
                            <a href="{{ $catDetailUrl }}" class="quickview-group-pill {{ $pillStyle }}">
                                <div class="quickview-pill-icon-circle {{ $iconBgClass }}">
                                    <i class="{{ $iconClass }}"></i>
                                </div>
                                <div class="quickview-pill-text w-100">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="quickview-pill-name">{{ $cat->category_name }}</span>
                                    </div>
                                    <span
                                        class="quickview-pill-desc">{{ $cat->description ?: 'Explore ' . $cat->category_name }}</span>
                                </div>
                            </a>

                            <div class="quickview-group-cards">
                                @forelse ($chunkProds as $product)
                                    @php
                                        $detailUrl = route('products.detail', $product->slug ?: $product->id);
                                        $displayImg = !empty($product->quickview_image)
                                            ? $product->quickview_image
                                            : $product->main_image;
                                        $imgUrl = !empty($displayImg)
                                            ? getImageCacheUrl($displayImg, 400, 400, 'webp')
                                            : theme_asset('img/Air-Purify.png');
                                        $brandName = $product->brand?->name ?? 'BROAD Fresh Air';
                                        $priceFormatted =
                                            $currencySymbol . number_format((float) ($product->price ?? 0), 2);
                                    @endphp
                                    <div class="quickview-product-card">
                                        <div class="quickview-product-img-box">
                                            <a href="{{ $detailUrl }}" tabindex="-1">
                                                <img src="{{ $imgUrl }}" alt="{{ $product->name }}"
                                                    loading="lazy">
                                            </a>
                                        </div>
                                        <span class="quickview-product-brand">{{ $brandName }}</span>
                                        <h4 class="quickview-product-name" title="{{ $product->name }}">
                                            <a href="{{ $detailUrl }}" class="text-decoration-none text-dark">
                                                {{ $product->name }}
                                            </a>
                                        </h4>
                                        <div class="quickview-product-price">{{ $priceFormatted }}</div>
                                        <a href="{{ $detailUrl }}" class="quickview-product-btn">View
                                            details</a>
                                    </div>
                                @empty
                                    <div
                                        class="quickview-product-card d-flex align-items-center justify-content-center text-muted p-4">
                                        <span class="fs-13">No products available</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <button type="button" class="quickview-scroll-btn next" id="{{ $nextBtnId }}"
                aria-label="Scroll right">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>

        <!-- Bottom CTA Row -->
        <div class="quickview-footer">
            <div class="quickview-cta-wrap mt-0">
                <a href="{{ route('category.all', $cat->slug ?: $cat->id) }}" class="quickview-cta-btn">
                    View all {{ $cat->category_name }} &rarr;
                </a>
            </div>
        </div>

    </div>
</div>

