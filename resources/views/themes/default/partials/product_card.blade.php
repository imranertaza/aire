<div class="product-card position-relative h-100">
    @php
        $firstCategory = $product->categories ? $product->categories->first() : null;
        $categoryName = $categoryName ?? ($firstCategory?->category_name ?? 'Home');
        $categoryBgColor = $categoryBgColor ?? ($firstCategory?->bg_color ?: '#1e1b4b');
        $subtitle =
            $subtitle ??
            ($product->description?->description ?? ($firstCategory?->category_name ?? 'ENTERPRISE FILTRATION'));
        $showCategoryBadge = isset($showCategoryBadge)
            ? $showCategoryBadge
            : !empty($isFiltered) ||
                !empty($search) ||
                request()->hasAny([
                    'industry',
                    'building_type',
                    'room_type',
                    'area_range',
                    'occupancy',
                    'health_concern',
                    'problem',
                    'solution_needed',
                    'budget',
                ]);
    @endphp
    @if (
        $showCategoryBadge ||
            ($product->quantity <= 5 && $product->quantity > 0) ||
            (isset($isFavoritePage) && $isFavoritePage && isset($catName)))
        <div class="product-card__badge-wrapper">
            @if ($showCategoryBadge || (isset($isFavoritePage) && $isFavoritePage && isset($catName)))
                <span class="product-card__badge-pill"
                    style="background-color: {{ isset($isFavoritePage) ? $catBg : $categoryBgColor }} !important; color: #ffffff !important;">
                    {{ isset($isFavoritePage) ? $catName : $categoryName }}
                </span>
            @endif
            @if ($product->quantity <= 5 && $product->quantity > 0)
                <span class="product-card__badge-pill product-card__badge-pill--low-stock">Low Stock</span>
            @endif
        </div>
    @endif
    @php
        $inCart = isset(session('cart', [])[$product->id]);
        $inCompare = in_array($product->id, session()->get('compare_products', []));
        $isFav = in_array($product->id, session()->get('favorites', []));
    @endphp
    <div class="product-card__labels position-absolute d-flex flex-column gap-2">
        {{-- Add to Cart button --}}
        <a href="javascript:void(0);" class="btn-add-to-cart {{ $inCart ? 'active' : '' }}"
            data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" data-bs-placement="left"
            title="{{ $inCart ? 'In Cart' : 'Add to Cart' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M17 18C17.5304 18 18.0391 18.2107 18.4142 18.5858C18.7893 18.9609 19 19.4696 19 20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22C16.4696 22 15.9609 21.7893 15.5858 21.4142C15.2107 21.0391 15 20.5304 15 20C15 18.89 15.89 18 17 18ZM1 2H4.27L5.21 4H20C20.2652 4 20.5196 4.10536 20.7071 4.29289C20.8946 4.48043 21 4.73478 21 5C21 5.17 20.95 5.34 20.88 5.5L17.3 11.97C16.96 12.58 16.3 13 15.55 13H8.1L7.2 14.63L7.17 14.75C7.17 14.8163 7.19634 14.8799 7.24322 14.9268C7.29011 14.9737 7.3537 15 7.42 15H19V17H7C6.46957 17 5.96086 16.7893 5.58579 16.4142C5.21071 16.0391 5 15.5304 5 15C5 14.65 5.09 14.32 5.24 14.04L6.6 11.59L3 4H1V2ZM7 18C7.53043 18 8.03914 18.2107 8.41421 18.5858C8.78929 18.9609 9 19.4696 9 20C9 20.5304 8.78929 21.0391 8.41421 21.4142C8.03914 21.7893 7.53043 22 7 22C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20C5 18.89 5.89 18 7 18ZM16 11L18.78 6H6.14L8.5 11H16Z"
                    fill="#0066CC" />
            </svg>
        </a>
        {{-- Add to Compare button --}}
        <a href="javascript:void(0);" class="btn-add-to-compare {{ $inCompare ? 'active' : '' }}"
            data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" data-bs-placement="left"
            title="{{ $inCompare ? 'In Compare' : 'Compare this solution' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M2 5C2 6.3 2.84 7.4 4 7.82V17.5C4 18.163 4.26339 18.7989 4.73223 19.2678C5.20107 19.7366 5.83696 20 6.5 20H10V22L14 19L10 16V18H6.5C6.22 18 6 17.78 6 17.5V7.82C7.16 7.41 8 6.31 8 5C8 3.35 6.65 2 5 2C3.35 2 2 3.35 2 5ZM5 4C5.55 4 6 4.45 6 5C6 5.55 5.55 6 5 6C4.45 6 4 5.55 4 5C4 4.45 4.45 4 5 4ZM20 16.18V6.5C20 5.83696 19.7366 5.20107 19.2678 4.73223C18.7989 4.26339 18.163 4 17.5 4H14V2L10 5L14 8V6H17.5C17.78 6 18 6.22 18 6.5V16.18C16.84 16.59 16 17.69 16 19C16 20.65 17.35 22 19 22C20.65 22 22 20.65 22 19C22 17.7 21.16 16.6 20 16.18ZM19 20C18.45 20 18 19.55 18 19C18 18.45 18.45 18 19 18C19.55 18 20 18.45 20 19C20 19.55 19.55 20 19 20Z"
                    fill="#0066CC" />
            </svg>
        </a>
        @if (empty($isFavoritePage))
            {{-- Favorite toggle button --}}
            <a href="javascript:void(0);" class="btn-toggle-favorite {{ $isFav ? 'active' : '' }}"
                data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" data-bs-placement="left"
                title="{{ $isFav ? 'Remove from favorites' : 'Add to favorite' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="{{ $isFav ? '#dc3545' : 'none' }}"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 20.9999L10.55 19.6999C8.86667 18.1832 7.475 16.8749 6.375 15.7749C5.275 14.6749 4.4 13.6872 3.75 12.8119C3.1 11.9366 2.646 11.1326 2.388 10.3999C2.13 9.66724 2.00067 8.91724 2 8.1499C2 6.58324 2.525 5.2749 3.575 4.2249C4.625 3.1749 5.93333 2.6499 7.5 2.6499C8.36667 2.6499 9.19167 2.83324 9.975 3.1999C10.7583 3.56657 11.4333 4.08324 12 4.7499C12.5667 4.08324 13.2417 3.56657 14.025 3.1999C14.8083 2.83324 15.6333 2.6499 16.5 2.6499C18.0667 2.6499 19.375 3.1749 20.425 4.2249C21.475 5.2749 22 6.58324 22 8.1499C22 8.91657 21.871 9.66657 21.613 10.3999C21.355 11.1332 20.9007 11.9372 20.25 12.8119C19.5993 13.6866 18.7243 14.6742 17.625 15.7749C16.5257 16.8756 15.134 18.1839 13.45 19.6999L12 20.9999ZM12 18.2999C13.6 16.8666 14.9167 15.6376 15.95 14.6129C16.9833 13.5882 17.8 12.6966 18.4 11.9379C19 11.1792 19.4167 10.5039 19.65 9.9119C19.8833 9.3199 20 8.73257 20 8.1499C20 7.1499 19.6667 6.31657 19 5.6499C18.3333 4.98324 17.5 4.6499 16.5 4.6499C15.7167 4.6499 14.9917 4.87057 14.325 5.3119C13.6583 5.75324 13.2 6.3159 12.95 6.9999H11.05C10.8 6.31657 10.3417 5.75424 9.675 5.3129C9.00833 4.87157 8.28333 4.65057 7.5 4.6499C6.5 4.6499 5.66667 4.98324 5 5.6499C4.33333 6.31657 4 7.1499 4 8.1499C4 8.73324 4.11667 9.3209 4.35 9.9129C4.58333 10.5049 5 11.1799 5.6 11.9379C6.2 12.6959 7.01667 13.5876 8.05 14.6129C9.08333 15.6382 10.4 16.8672 12 18.2999Z"
                        fill="{{ $isFav ? '#dc3545' : '#0066CC' }}" />
                </svg>
            </a>
        @endif
    </div>
    <div class="product-card__image-wrapper">
        <a href="{{ route('products.detail', $product->slug ?: $product->id) }}">
            <img src="{{ $product->main_image ? getImageCacheUrl($product->main_image, 400, 400, 'webp') : theme_asset('img/Air-Purify.png') }}"
                alt="{{ $product->name }}" class="product-card__image" loading="lazy" decoding="async">
        </a>
    </div>
    <h3 class="product-card__title">
        <a href="{{ route('products.detail', $product->slug ?: $product->id) }}">
            {{ $product->name }}
        </a>
    </h3>
    <div class="product-card__category">
        {{ strtoupper(isset($isFavoritePage) ? $product->category->name ?? 'ENTERPRISE FILTRATION' : $subtitle) }}
    </div>
    <div class="product-card__actions">
        <div class="d-flex gap-2 align-items-center">

            <a href="javascript:void(0);" class="product-card__btn-buy btn-buy-now"
                data-product-id="{{ $product->id }}">Buy</a>
            <div class="d-flex flex-column gap-0">
                @php
                    $specialPrice = $product->special_price ?? ($product->special ? $product->special->special_price : null);
                @endphp
                @if (isset($specialPrice) && $specialPrice !== null && $specialPrice < $product->price)
                    <span class="product-card__price pre">${{ number_format((float) $product->price, 2) }}</span>
                    <span class="product-card__price">${{ number_format((float) $specialPrice, 2) }}</span>
                @else
                    <span class="product-card__price">${{ number_format((float) $product->price, 2) }}</span>
                @endif
            </div>
        </div>


        @if (isset($isFavoritePage) && $isFavoritePage)
            <button type="button" class="product-card__btn-learn border-0 bg-transparent btn-remove-favorite"
                data-product-id="{{ $product->id }}">
                Remove
            </button>
        @else
            <a href="{{ $product->productLanding ? route('products.landing', $product->slug ?: $product->id) : route('products.detail', $product->slug ?: $product->id) }}"
                class="product-card__btn-learn">Learn more</a>
        @endif
    </div>
    @if (0)
        <div class="product-card__specs">
            <div>
                <div class="product-card__spec-label">CADR RATING</div>
                <div class="product-card__spec-value">{{ $cadr }}</div>
            </div>
            <div class="product-card__spec-item--align-end">
                <div class="product-card__spec-label">FILTER GRADE</div>
                <div class="product-card__spec-value">{{ $filterGrade }}</div>
            </div>
        </div>
    @endif
</div>
