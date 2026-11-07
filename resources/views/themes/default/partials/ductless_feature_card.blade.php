@php
    $showcase = $product->showcase ?? null;
    $desc = $product->description ?? null;

    // Dynamic fields with safe fallbacks
    $productName = $desc->name ?? ($product->name ?? ($product->model ?? 'FF100 AirPro Fresh'));
    $cardTitle = !empty($showcase->title) ? $showcase->title : 'Single Room Ductless';
    $cardSubtitle = !empty($showcase->subtitle) ? $showcase->subtitle : 'Compact & powerful fresh air solution';

    // Badges & Category Name (from product categories or showcase override)
    $prodCategories = $product->categories ?? collect();
    $primaryCategory = $prodCategories->first();
    $parentCategory = $primaryCategory?->parent ?? null;

    $cat1Obj = null;
    $cat2Obj = null;

    if ($parentCategory) {
        $cat1Obj = $parentCategory;
        $cat2Obj = $primaryCategory;
        $badgeResidential =
            !empty($showcase->badge_residential) && $showcase->badge_residential !== 'Residential'
                ? $showcase->badge_residential
                : $parentCategory->category_name;

        $badgeFreshAir =
            !empty($showcase->badge_fresh_air) && $showcase->badge_fresh_air !== 'Small Fresh Air'
                ? $showcase->badge_fresh_air
                : $primaryCategory->category_name;
    } elseif ($prodCategories->count() >= 2) {
        $cat1Obj = $prodCategories[0];
        $cat2Obj = $prodCategories[1];
        $badgeResidential =
            !empty($showcase->badge_residential) && $showcase->badge_residential !== 'Residential'
                ? $showcase->badge_residential
                : $prodCategories[0]->category_name;

        $badgeFreshAir =
            !empty($showcase->badge_fresh_air) && $showcase->badge_fresh_air !== 'Small Fresh Air'
                ? $showcase->badge_fresh_air
                : $prodCategories[1]->category_name;
    } else {
        $cat1Obj = $primaryCategory;
        $badgeResidential = $showcase->badge_residential ?? ($primaryCategory?->category_name ?? 'Residential');
        $badgeFreshAir = $showcase->badge_fresh_air ?? 'Small Fresh Air';
    }

    // Images optimized via getImageUrl helper with theme_asset/asset fallback
    $heroBgImage = !empty($showcase->hero_bg_image)
        ? getImageUrl($showcase->hero_bg_image)
        : (file_exists(public_path('assets/images/cart-bg.png'))
            ? asset('assets/images/cart-bg.png')
            : theme_asset('img/cart-bg.png'));

    $diagramImage = !empty($showcase->diagram_image)
        ? getImageUrl($showcase->diagram_image)
        : (file_exists(public_path('assets/images/diagram.png'))
            ? asset('assets/images/diagram.png')
            : theme_asset('img/diagram.png'));

    // Diagram Box
    $diagramBrand = $showcase->diagram_brand ?? ($product->brand->name ?? 'BROAD');
    $diagramModel = !empty($showcase->diagram_model) ? $showcase->diagram_model : $productName;
    $productShortDesc = !empty($showcase->diagram_system)
        ? $showcase->diagram_system
        : (!empty($desc->description) && strlen(trim(strip_tags($desc->description))) <= 50
            ? trim(strip_tags($desc->description))
            : 'Compact Fresh Air System');
    $diagramSystem = $productShortDesc;

    // Specs Bar
    $airflow = $showcase->airflow ?? '260 m³/h';
    $power = $showcase->power ?? '30–120 W';
    $coverageArea = $showcase->coverage_area ?? '20–50 m²';

    // Price & Links
    $price = (float) ($product->price ?? 0);
    $specialPrice =
        $product->special_price ?? (!empty($product->special) ? (float) $product->special->special_price : null);
    $hasSpecial = $specialPrice !== null && $specialPrice < $price;
    $detailUrl = !empty($product->slug)
        ? route('products.detail', $product->slug)
        : (!empty($product->id)
            ? route('products.detail', $product->id)
            : route('products.index'));
    $targetUrl = !empty($product->productLanding)
        ? route('products.landing', $product->slug ?: $product->id)
        : $detailUrl;
    $productUrl = $detailUrl;
    $modalTargetId = 'quickViewModal-' . ($product->id ?? 'default');

    // Cart, Compare, Favorites Status
    static $cachedCart = null,
        $cachedCompare = null,
        $cachedFavorites = null;
    if ($cachedCart === null) {
        $cachedCart = session('cart', []);
        $cachedCompare = session()->get('compare_products', session()->get('compare', []));
        $cachedFavorites = app(\App\Services\Product\WishlistService::class)->getWishlistIds();
    }
    $inCart = isset($cachedCart[$product->id]);
    $inCompare = in_array($product->id, $cachedCompare);
    $isFav = in_array($product->id, $cachedFavorites);
@endphp

<div class="ductless-showcase-card">
    {{-- Top Hero Section --}}
    <div class="ductless-showcase-card__hero" style="background-image: url('{{ $heroBgImage }}');">
        {{-- Clickable Full Hero Overlay Link to Landing/Detail Page --}}
        <a href="{{ $targetUrl }}" class="ductless-hero-link" aria-label="{{ $cardTitle }}"></a>

        {{-- Top Badges --}}
        <div class="ductless-showcase-card__badges">
            <span class="ductless-badge ductless-badge--residential">
                @if ($cat1Obj)
                    <x-category-icon :category="$cat1Obj" fallback="bi bi-house" />
                @else
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                @endif
                <span>{{ $badgeResidential }}</span>
            </span>
            <span class="ductless-badge ductless-badge--fresh-air">
                @if ($cat2Obj)
                    <x-category-icon :category="$cat2Obj" fallback="bi bi-wind" />
                @else
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z" />
                    </svg>
                @endif
                <span>{{ $badgeFreshAir }}</span>
            </span>
        </div>

        {{-- Floating Top-Right Action Buttons --}}
        <div class="ductless-showcase-card__actions">
            {{-- Add to Cart button --}}
            <button type="button" class="ductless-action-btn btn-add-to-cart {{ $inCart ? 'active' : '' }}"
                data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" data-bs-placement="left"
                title="{{ $inCart ? 'In Cart' : 'Add to Cart' }}" aria-label="Add to Cart">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M17 18C17.5304 18 18.0391 18.2107 18.4142 18.5858C18.7893 18.9609 19 19.4696 19 20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22C16.4696 22 15.9609 21.7893 15.5858 21.4142C15.2107 21.0391 15 20.5304 15 20C15 18.89 15.89 18 17 18ZM1 2H4.27L5.21 4H20C20.2652 4 20.5196 4.10536 20.7071 4.29289C20.8946 4.48043 21 4.73478 21 5C21 5.17 20.95 5.34 20.88 5.5L17.3 11.97C16.96 12.58 16.3 13 15.55 13H8.1L7.2 14.63L7.17 14.75C7.17 14.8163 7.19634 14.8799 7.24322 14.9268C7.29011 14.9737 7.3537 15 7.42 15H19V17H7C6.46957 17 5.96086 16.7893 5.58579 16.4142C5.21071 16.0391 5 15.5304 5 15C5 14.65 5.09 14.32 5.24 14.04L6.6 11.59L3 4H1V2ZM7 18C7.53043 18 8.03914 18.2107 8.41421 18.5858C8.78929 18.9609 9 19.4696 9 20C9 20.5304 8.78929 21.0391 8.41421 21.4142C8.03914 21.7893 7.53043 22 7 22C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20C5 18.89 5.89 18 7 18ZM16 11L18.78 6H6.14L8.5 11H16Z"
                        fill="#0066CC" />
                </svg>
            </button>

            {{-- Add to Compare button --}}
            <button type="button" class="ductless-action-btn btn-add-to-compare {{ $inCompare ? 'active' : '' }}"
                data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" data-bs-placement="left"
                title="{{ $inCompare ? 'In Compare' : 'Compare this solution' }}" aria-label="Compare">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2 5C2 6.3 2.84 7.4 4 7.82V17.5C4 18.163 4.26339 18.7989 4.73223 19.2678C5.20107 19.7366 5.83696 20 6.5 20H10V22L14 19L10 16V18H6.5C6.22 18 6 17.78 6 17.5V7.82C7.16 7.41 8 6.31 8 5C8 3.35 6.65 2 5 2C3.35 2 2 3.35 2 5ZM5 4C5.55 4 6 4.45 6 5C6 5.55 5.55 6 5 6C4.45 6 4 5.55 4 5C4 4.45 4.45 4 5 4ZM20 16.18V6.5C20 5.83696 19.7366 5.20107 19.2678 4.73223C18.7989 4.26339 18.163 4 17.5 4H14V2L10 5L14 8V6H17.5C17.78 6 18 6.22 18 6.5V16.18C16.84 16.59 16 17.69 16 19C16 20.65 17.35 22 19 22C20.65 22 22 20.65 22 19C22 17.7 21.16 16.6 20 16.18ZM19 20C18.45 20 18 19.55 18 19C18 18.45 18.45 18 19 18C19.55 18 20 18.45 20 19C20 19.55 19.55 20 19 20Z"
                        fill="#0066CC" />
                </svg>
            </button>

            {{-- Add to Wishlist / Favorite button --}}
            <button type="button" class="ductless-action-btn btn-toggle-favorite {{ $isFav ? 'active' : '' }}"
                data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" data-bs-placement="left"
                title="{{ $isFav ? 'Remove from favorites' : 'Add to Wishlist' }}" aria-label="Add to Wishlist">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 20.9999L10.55 19.6999C8.86667 18.1832 7.475 16.8749 6.375 15.7749C5.275 14.6749 4.4 13.6872 3.75 12.8119C3.1 11.9366 2.646 11.1326 2.388 10.3999C2.13 9.66724 2.00067 8.91724 2 8.1499C2 6.58324 2.525 5.2749 3.575 4.2249C4.625 3.1749 5.93333 2.6499 7.5 2.6499C8.36667 2.6499 9.19167 2.83324 9.975 3.1999C10.7583 3.56657 11.4333 4.08324 12 4.7499C12.5667 4.08324 13.2417 3.56657 14.025 3.1999C14.8083 2.83324 15.6333 2.6499 16.5 2.6499C18.0667 2.6499 19.375 3.1749 20.425 4.2249C21.475 5.2749 22 6.58324 22 8.1499C22 8.91657 21.871 9.66657 21.613 10.3999C21.355 11.1332 20.9007 11.9372 20.25 12.8119C19.5993 13.6866 18.7243 14.6742 17.625 15.7749C16.5257 16.8756 15.134 18.1839 13.45 19.6999L12 20.9999ZM12 18.2999C13.6 16.8666 14.9167 15.6376 15.95 14.6129C16.9833 13.5882 17.8 12.6966 18.4 11.9379C19 11.1792 19.4167 10.5039 19.65 9.9119C19.8833 9.3199 20 8.73257 20 8.1499C20 7.1499 19.6667 6.31657 19 5.6499C18.3333 4.98324 17.5 4.6499 16.5 4.6499C15.7167 4.6499 14.9917 4.87057 14.325 5.3119C13.6583 5.75324 13.2 6.3159 12.95 6.9999H11.05C10.8 6.31657 10.3417 5.75424 9.675 5.3129C9.00833 4.87157 8.28333 4.65057 7.5 4.6499C6.5 4.6499 5.66667 4.98324 5 5.6499C4.33333 6.31657 4 7.1499 4 8.1499C4 8.73324 4.11667 9.3209 4.35 9.9129C4.58333 10.5049 5 11.1799 5.6 11.9379C6.2 12.6959 7.01667 13.5876 8.05 14.6129C9.08333 15.6382 10.4 16.8672 12 18.2999Z"
                        fill="#dc3545" />
                </svg>
            </button>
        </div>

        {{-- Title & Subtitle --}}
        <div class="ductless-showcase-card__header position-relative" style="z-index: 2;">
            <h2 class="ductless-showcase-card__title">
                <a href="{{ $targetUrl }}" class="text-decoration-none text-reset">
                    {{ $cardTitle }}
                </a>
            </h2>
            <p class="ductless-showcase-card__subtitle" title="{{ $cardSubtitle }}">
                {{ $cardSubtitle }}
            </p>
        </div>

        {{-- Feature Pills Column --}}
        <div class="ductless-showcase-card__pills position-relative" style="z-index: 2;">
            @if (!empty($showcase->feature_pills) && is_array($showcase->feature_pills))
                @foreach ($showcase->feature_pills as $pill)
                    <div class="ductless-pill {{ !empty($pill['subtext']) ? 'ductless-pill--dual' : '' }}">
                        <i class="bi {{ $pill['icon'] ?? 'bi-check-circle' }} ductless-pill__icon"></i>
                        @if (!empty($pill['subtext']))
                            <div class="ductless-pill__dual-text">
                                <span class="ductless-pill__dual-main">{{ $pill['text'] ?? '' }}</span>
                                <span class="ductless-pill__dual-sub">{{ $pill['subtext'] }}</span>
                            </div>
                        @else
                            <span class="ductless-pill__text">{{ $pill['text'] ?? '' }}</span>
                        @endif
                    </div>
                @endforeach
            @else
                {{-- Default Feature Pills --}}
                {{-- 1. Square Footage --}}
                <div class="ductless-pill">
                    <svg class="ductless-pill__icon" width="11" height="11" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 3 21 3 21 9" />
                        <polyline points="9 21 3 21 3 15" />
                        <line x1="21" y1="3" x2="14" y2="10" />
                        <line x1="3" y1="21" x2="10" y2="14" />
                    </svg>
                    <span class="ductless-pill__text">200–500 sq ft</span>
                </div>

                {{-- 2. Heat Recovery --}}
                <div class="ductless-pill">
                    <svg class="ductless-pill__icon" width="11" height="11" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67" />
                    </svg>
                    <span class="ductless-pill__text">Heat Recovery 70%</span>
                </div>

                {{-- 3. PM 2.5 99% --}}
                <div class="ductless-pill">
                    <svg class="ductless-pill__icon" width="11" height="11" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        <path d="m9 12 2 2 4-4" />
                    </svg>
                    <span class="ductless-pill__text">PM 2.5 99%</span>
                </div>

                {{-- 4. 100% Fresh Air / No Recycled Air --}}
                <div class="ductless-pill ductless-pill--dual">
                    <svg class="ductless-pill__icon" width="11" height="11" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
                    </svg>
                    <div class="ductless-pill__dual-text">
                        <span class="ductless-pill__dual-main">100% Fresh Air</span>
                        <span class="ductless-pill__dual-sub">No Recycled Air</span>
                    </div>
                </div>

                {{-- 5. Infection Control --}}
                <div class="ductless-pill">
                    <svg class="ductless-pill__icon" width="11" height="11" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="22" y1="12" x2="18" y2="12" />
                        <line x1="6" y1="12" x2="2" y2="12" />
                        <line x1="12" y1="6" x2="12" y2="2" />
                        <line x1="12" y1="22" x2="12" y2="18" />
                    </svg>
                    <span class="ductless-pill__text">Infection Control</span>
                </div>

                {{-- 6. Asthma --}}
                <div class="ductless-pill">
                    <svg class="ductless-pill__icon" width="11" height="11" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="12" y1="18" x2="12" y2="12" />
                        <line x1="9" y1="15" x2="15" y2="15" />
                    </svg>
                    <span class="ductless-pill__text">Asthma</span>
                </div>

                {{-- 7. Allergies & Dust --}}
                <div class="ductless-pill">
                    <svg class="ductless-pill__icon" width="11" height="11" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83" />
                    </svg>
                    <span class="ductless-pill__text">Allergies &amp; Dust</span>
                </div>
            @endif
        </div>

        {{-- Quick View Floating Button --}}
        <button type="button" class="ductless-quickview-btn border-0" data-bs-toggle="modal"
            data-bs-target="#{{ $modalTargetId }}">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                <circle cx="12" cy="12" r="3" />
            </svg>
            <span>Quick View</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
        </button>
    </div>

    {{-- Bottom Body Section --}}
    <div class="ductless-showcase-card__body">
        {{-- Middle Ventilation Diagram Box --}}
        <div class="ductless-diagram-box">
            <div class="ductless-diagram-box__meta">
                <span class="ductless-diagram-box__brand">{{ $diagramBrand }}</span>
                <h3 class="ductless-diagram-box__model">
                    <a href="{{ $detailUrl }}" class="text-decoration-none text-reset">
                        {{ $productName }}
                    </a>
                </h3>
                <p class="ductless-diagram-box__system" title="{{ $diagramSystem }}">
                    {{ \Illuminate\Support\Str::limit($diagramSystem, 55) }}</p>
            </div>

            <div class="ductless-diagram-box__illustration">
                <a href="{{ $detailUrl }}" class="ductless-diagram-link text-decoration-none">
                    <img src="{{ $diagramImage }}" alt="{{ $diagramModel }}" class="ductless-diagram-img"
                        width="343" height="184" loading="lazy" decoding="async">
                </a>
            </div>
        </div>

        {{-- Bottom Specs Highlight Bar --}}
        <div class="ductless-specs-bar">
            {{-- Spec 1: Airflow --}}
            <div class="ductless-spec-item">
                <div class="ductless-spec-item__value">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m21 16-9 5-9-5V8l9-5 9 5v8Z" />
                        <path d="M3.27 6.96 12 12.01l8.73-5.05" />
                        <path d="M12 22.08V12" />
                    </svg>
                    <span>{!! $airflow !!}</span>
                </div>
                <span class="ductless-spec-item__label">Airflow</span>
            </div>

            <div class="ductless-specs-bar__divider"></div>

            {{-- Spec 2: Power --}}
            <div class="ductless-spec-item">
                <div class="ductless-spec-item__value">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                    </svg>
                    <span>{!! $power !!}</span>
                </div>
                <span class="ductless-spec-item__label">Power</span>
            </div>

            <div class="ductless-specs-bar__divider"></div>

            {{-- Spec 3: Apartment Area --}}
            <div class="ductless-spec-item">
                <div class="ductless-spec-item__value">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    <span>{!! $coverageArea !!}</span>
                </div>
                <span class="ductless-spec-item__label">Apartment</span>
            </div>
        </div>

        {{-- Bottom Action & Price Bar --}}
        <div class="ductless-card-footer">
            <a href="{{ $detailUrl }}" aria-label="Buy {{ $product->name }}" class="ductless-buy-btn">
                <span>Buy</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <polyline points="12 5 19 12 12 19" />
                </svg>
            </a>

            <div class="ductless-price-wrap">
                <div class="d-flex flex-column align-items-end">
                    @if ($hasSpecial)
                        <span class="text-muted text-decoration-line-through"
                            style="font-size: 11px; opacity: 0.8; line-height: 1;">${{ number_format($price, 2) }}</span>
                        <div class="ductless-price text-danger">${{ number_format($specialPrice, 2) }}</div>
                    @else
                        <div class="ductless-price">${{ number_format($price, 2) }}</div>
                    @endif
                </div>
                <a href="{{ $detailUrl }}#overview" class="ductless-learn-more"
                    aria-label="Learn more about {{ $product->name }}">
                    <span>Learn more</span>
                    <span class="visually-hidden"> about {{ $product->name }}</span>
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Dynamic Quick View Detail Modal for this product --}}
@include('themes.' . active_theme() . '.partials.ductless_detail_modal', [
    'product' => $product ?? null,
    'modalId' => $modalTargetId,
])
