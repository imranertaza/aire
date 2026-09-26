<!-- Search Results Summary Banner (if searched) -->
@if (!empty($search))
    <div
        class="search-result-banner mb-3 p-3 bg-light rounded-3 border d-flex justify-content-between align-items-center">
        <div>
            <span class="text-muted small text-uppercase fw-semibold"
                style="font-size: 0.72rem; letter-spacing: 0.5px;">Search Results for</span>
            <h5 class="mb-0 text-dark fw-bold">"{{ $search }}"</h5>
            <span
                class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill mt-1">{{ $products->total() }}
                solutions found</span>
        </div>
        <a href="{{ route('products.filter') }}"
            class="d-flex btn btn-sm btn-outline-dark rounded-pill px-3 clear-search-btn">
            <i class="bi bi-x-circle me-1"></i> Clear
        </a>
    </div>
@endif
@php
    $isCategoryPage =
        request()->routeIs('category.*') ||
        request()->routeIs('category.detail') ||
        request()->routeIs('category.show') ||
        (isset($currentCategory) && !request()->routeIs('products.filter'));
    $hasAds = isset($adSliders) && $adSliders->count() > 0;
    $gridColsClass = $isCategoryPage
        ? ($hasAds
            ? 'row-cols-md-2 row-cols-xl-3'
            : 'row-cols-md-2 row-cols-lg-3 row-cols-xl-4')
        : ($hasAds
            ? 'row-cols-md-2'
            : 'row-cols-md-2 row-cols-xl-3');
@endphp
<!-- Hero Spotlight Box (Top Featured Product - Hidden when filtering) -->
@if (
    !request()->routeIs('products.filter') &&
        empty($isFiltered) &&
        empty($search) &&
        isset($topFeaturedProduct) &&
        $topFeaturedProduct)
    <div class="product-hero mt-3">
        <span
            class="product-hero__badge">{{ $topFeaturedProduct->categories->first()->category_name ?? 'Featured' }}</span>
        <h1 class="product-hero__title">
            {{ $topFeaturedProduct->name }}@if (!empty($topFeaturedProduct->model))
                . <span class="product-hero__title-light">{{ $topFeaturedProduct->model }}</span>
            @endif
        </h1>
        <p class="product-hero__description">
            {{ getLimitedText($topFeaturedProduct->description->description ?? '', 140) }}
        </p>
        <a href="{{ route('products.detail', $topFeaturedProduct->slug ?: $topFeaturedProduct->id) }}"
            class="product-hero__button">
            Buy Now @if ($topFeaturedProduct->price > 0)
                — ${{ number_format($topFeaturedProduct->price, 2) }}
            @endif
        </a>
        <div class="product-hero__image-wrapper">
            <a href="{{ route('products.detail', $topFeaturedProduct->slug ?: $topFeaturedProduct->id) }}">
                <img src="{{ $topFeaturedProduct->main_image ? getImageCacheUrl($topFeaturedProduct->main_image, 600, 600, 'webp') : theme_asset('img/Air-Purify.png') }}"
                    @if ($topFeaturedProduct->main_image)
                        srcset="{{ getImageSrcset($topFeaturedProduct->main_image, [360, 600, 900], 1.0) }}"
                        sizes="(max-width: 768px) 100vw, 600px"
                    @endif
                    alt="{{ $topFeaturedProduct->name }}" class="product-hero__image" loading="eager" decoding="async">
            </a>
        </div>
    </div>
@endif

<!-- Product Count Bar -->
<div class="d-flex justify-content-between align-items-center mb-3 pt-2">
    <span class="text-muted small fw-semibold">Showing <span class="text-dark fw-bold">{{ $products->total() }}</span>
        matching solution{{ $products->total() == 1 ? '' : 's' }}</span>
</div>

<!-- Product Grid -->
<div class="row row-cols-1 row-cols-sm-2 {{ $gridColsClass }} g-2 g-sm-3 product-grid">
    @forelse($products as $product)
        @php
            $firstCategory = $product->categories->first();
            $categoryName = $firstCategory?->category_name ?? 'Air Care';
            $categoryBgColor = $firstCategory?->bg_color ?: '#0066cc';
            $subtitle = $product->description?->description;
        @endphp
        <div class="col product-item" data-category="{{ strtolower($categoryName) }}">
            @include('themes.default.partials.product_card')
        </div>
    @empty
        <div class="col-12 w-100 py-5 text-center">
            <div class="p-4 bg-light rounded-4 border">
                <i class="bi bi-search fs-3 text-muted mb-2 d-block"></i>
                <h5 class="fw-bold text-dark mb-1">No products found</h5>
                <p class="text-muted small mb-0">Try adjusting your filters or search keywords.</p>
            </div>
        </div>
    @endforelse
</div>

<!-- Product Pagination -->
@if ($products->hasPages())
    <div class="product-pagination-wrapper mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
@endif
