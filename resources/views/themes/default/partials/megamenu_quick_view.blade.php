@pushOnce('styles')
    <link rel="stylesheet"
        href="{{ theme_asset('css/megamenu.css') }}?v={{ @filemtime(public_path('themes/default/assets/css/megamenu.css')) ?: time() }}">
@endpushOnce

@php
    $quickViewNavItems = collect($mainHeaderMenu?->menus ?? [])->filter(function ($item) {
        return !empty($item->has_quick_view) && !empty($item->productCategory);
    });
    $categoriesMap = $headerMegaMenuCategories ?? collect();
    $currencySymbol = '$';
@endphp

<!-- =========================================================================
| Dynamic Quick View MegaMenus: Specific Menu Items (has_quick_view = 1)
| ========================================================================= -->
@foreach ($quickViewNavItems as $navItem)
    @php
        $parentCat = $navItem->productCategory;
        $childCategories = $parentCat->children ?? collect();
        $overlayId = 'quickViewMenu-' . $navItem->id;
        $trackId = 'megamenuProductsTrack-' . $navItem->id;
        $prevBtnId = 'megamenuScrollPrev-' . $navItem->id;
        $nextBtnId = 'megamenuScrollNext-' . $navItem->id;
    @endphp
    <div id="{{ $overlayId }}" class="megamenu-quickview-overlay" role="dialog"
        aria-label="{{ $navItem->name }} Quick View" aria-hidden="true" data-megamenu-id="{{ $overlayId }}">
        <div class="container main-container position-relative">
            <div class="air-purifiers-quickview-card">

                <!-- Top Header Row -->
                <div class="quickview-header">
                    <div>
                        <h2 class="quickview-title">
                            {{ $navItem->name }}
                            <span class="quickview-title-sep">|</span>
                            <span class="quickview-title-sub">Quick View</span>
                        </h2>
                        <p class="quickview-desc">
                            {{ $parentCat->description ?: $parentCat->category_name . ' provide clean, healthy and efficient indoor air solutions.' }}
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
                        @forelse ($childCategories as $cIndex => $childCat)
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
                                $catDetailUrl = route('category.show', $childCat->slug);
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

                                <!-- Product Cards Row: exactly 4 products per child category -->
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
                        @empty
                            <div class="p-4 text-muted fs-14">
                                No subcategories found for {{ $parentCat->category_name }}.
                            </div>
                        @endforelse
                    </div>

                    <button type="button" class="quickview-scroll-btn next" id="{{ $nextBtnId }}"
                        aria-label="Scroll right">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>

                <!-- Bottom CTA Row -->
                <div class="quickview-footer">
                    <div class="quickview-cta-wrap mt-0">
                        <a href="{{ route('category.show', $parentCat->slug) }}" class="quickview-cta-btn">
                            View all {{ $navItem->name }} &rarr;
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endforeach

<!-- =========================================================================
| Fallback Quick View MegaMenus: Only when no custom menu items configured
| ========================================================================= -->
@if ($quickViewNavItems->isEmpty())
    @foreach ($categoriesMap as $catSlug => $parentCat)
        @php
            $childCategories = $parentCat->children ?? collect();
            if ($childCategories->isEmpty()) {
                continue;
            }

            $overlayId = 'quickViewCategory-' . $catSlug;
            $trackId = 'megamenuCategoryTrack-' . $catSlug;
            $prevBtnId = 'megamenuCategoryPrev-' . $catSlug;
            $nextBtnId = 'megamenuCategoryNext-' . $catSlug;
        @endphp
        <div id="{{ $overlayId }}" class="megamenu-quickview-overlay" role="dialog"
            aria-label="{{ $parentCat->category_name }} Quick View" aria-hidden="true"
            data-megamenu-id="{{ $overlayId }}"
            @if ($catSlug === 'products') data-megamenu-alias="airPurifiersMegaMenu" @endif>
            <div class="container main-container position-relative">
                <div class="air-purifiers-quickview-card">

                    <!-- Top Header Row -->
                    <div class="quickview-header">
                        <div>
                            <h2 class="quickview-title">
                                {{ $parentCat->category_name }}
                                <span class="quickview-title-sep">|</span>
                                <span class="quickview-title-sub">Quick View</span>
                            </h2>
                            <p class="quickview-desc">
                                {{ $parentCat->description ?: $parentCat->category_name . ' provide clean, healthy and efficient solutions for homes, offices and commercial spaces.' }}
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
                                    $catDetailUrl = route('category.show', $childCat->slug);
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
                                                    <span
                                                        class="quickview-pill-name">{{ $childCat->category_name }}</span>
                                                </div>
                                                <span
                                                    class="quickview-pill-desc">{{ $childCat->description ?: 'Explore ' . $childCat->category_name }}</span>
                                            </div>
                                        @endif
                                    </a>

                                    <!-- Product Cards Row: exactly 4 products per child category -->
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
                                                    <a href="{{ $detailUrl }}"
                                                        class="text-decoration-none text-dark">
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
                        </div>

                        <button type="button" class="quickview-scroll-btn next" id="{{ $nextBtnId }}"
                            aria-label="Scroll right">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>

                    <!-- Bottom CTA Row -->
                    <div class="quickview-footer">
                        <div class="quickview-cta-wrap mt-0">
                            <a href="{{ route('category.show', $parentCat->slug) }}" class="quickview-cta-btn">
                                View all {{ $parentCat->category_name }} &rarr;
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const overlays = document.querySelectorAll('.megamenu-quickview-overlay');
        if (!overlays.length) return;

        let activeOverlay = null;
        let hideTimer = null;
        let isManuallyClosed = false;

        function openOverlay(overlay, trigger) {
            if (isManuallyClosed && activeOverlay === overlay) return;
            clearTimeout(hideTimer);

            // If another overlay is open, close it instantly
            if (activeOverlay && activeOverlay !== overlay) {
                closeOverlay(activeOverlay, true);
            }

            activeOverlay = overlay;
            isManuallyClosed = false;
            overlay.classList.add('is-active');
            overlay.setAttribute('aria-hidden', 'false');
            if (trigger) {
                trigger.setAttribute('aria-expanded', 'true');
            }
        }

        function scheduleClose(delay = 180) {
            clearTimeout(hideTimer);
            hideTimer = setTimeout(function() {
                if (activeOverlay) {
                    closeOverlay(activeOverlay);
                }
            }, delay);
        }

        function closeOverlay(overlay, instant = false) {
            if (!overlay) return;
            clearTimeout(hideTimer);
            overlay.classList.remove('is-active');
            overlay.setAttribute('aria-hidden', 'true');
            const targetId = overlay.id;
            const triggers = document.querySelectorAll('[data-megamenu-target="' + targetId + '"]');
            triggers.forEach(t => t.setAttribute('aria-expanded', 'false'));
            if (activeOverlay === overlay) {
                activeOverlay = null;
            }
        }

        // Attach listeners to all triggers
        const allTriggers = document.querySelectorAll('[data-megamenu-target]');
        allTriggers.forEach(trigger => {
            const targetId = trigger.getAttribute('data-megamenu-target');
            const targetOverlay = document.getElementById(targetId) ||
                document.querySelector('[data-megamenu-alias="' + targetId + '"]') ||
                document.querySelector('[data-megamenu-id="' + targetId + '"]');
            if (!targetOverlay) return;

            trigger.addEventListener('mouseenter', function() {
                isManuallyClosed = false;
                openOverlay(targetOverlay, trigger);
            });
            trigger.addEventListener('mouseleave', function() {
                scheduleClose(200);
            });
            trigger.addEventListener('focus', function() {
                isManuallyClosed = false;
                openOverlay(targetOverlay, trigger);
            });
            trigger.addEventListener('blur', function() {
                scheduleClose(200);
            });
        });

        // Hover handling for each overlay so moving cursor into it keeps it open
        overlays.forEach(overlay => {
            overlay.addEventListener('mouseenter', function() {
                clearTimeout(hideTimer);
                activeOverlay = overlay;
            });
            overlay.addEventListener('mouseleave', function() {
                isManuallyClosed = false;
                scheduleClose(180);
            });

            // Close button inside overlay
            const closeBtn = overlay.querySelector('.quickview-close-btn');
            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    isManuallyClosed = true;
                    closeOverlay(overlay, true);
                });
            }

            // Carousel scroll buttons
            const carouselWrapper = overlay.querySelector('.quickview-carousel-wrapper');
            if (carouselWrapper) {
                const track = carouselWrapper.querySelector('.quickview-groups-track');
                const prevBtn = carouselWrapper.querySelector('.quickview-scroll-btn.prev');
                const nextBtn = carouselWrapper.querySelector('.quickview-scroll-btn.next');

                if (track && prevBtn) {
                    prevBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        track.scrollBy({
                            left: -380,
                            behavior: 'smooth'
                        });
                    });
                }
                if (track && nextBtn) {
                    nextBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        track.scrollBy({
                            left: 380,
                            behavior: 'smooth'
                        });
                    });
                }
            }
        });

        // Escape key closes open overlay
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && activeOverlay) {
                isManuallyClosed = true;
                closeOverlay(activeOverlay, true);
            }
        });

        // Outside click closes open overlay
        document.addEventListener('click', function(e) {
            if (activeOverlay && !activeOverlay.contains(e.target)) {
                let isTriggerClick = false;
                allTriggers.forEach(t => {
                    if (t.contains(e.target)) isTriggerClick = true;
                });
                if (!isTriggerClick) {
                    closeOverlay(activeOverlay, true);
                }
            }
        });
    });
</script>
