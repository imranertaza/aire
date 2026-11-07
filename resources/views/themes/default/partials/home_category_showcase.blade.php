<!-- Section: Category Showcase & Solutions Grid (matching Mockup) -->
@php
    $catGrid = getSection('home_category_grid') ?? [];

    $resolveUrl = function (?string $path, string $fallback) {
        $p = trim($path ?? '');
        if ($p === '') {
            $p = $fallback;
        }
        if (str_starts_with($p, 'http://') || str_starts_with($p, 'https://')) {
            return $p;
        }
        if (str_starts_with($p, 'storage/')) {
            return asset($p);
        }
        if (str_starts_with($p, 'themes/')) {
            return asset($p);
        }
        return theme_asset($p);
    };

    $resolveTargetUrl = function (?string $url, string $fallbackRoute) {
        $u = trim($url ?? '');
        if ($u === '') {
            return route($fallbackRoute);
        }
        if (str_starts_with($u, 'http://') || str_starts_with($u, 'https://') || str_starts_with($u, '/') || str_starts_with($u, '#')) {
            return $u;
        }
        return url($u);
    };

    $actionText = $catGrid['action_text'] ?? 'Find Your Solutions';
    $actionUrl = $resolveTargetUrl($catGrid['action_url'] ?? null, 'products.finder');

    $freshAirTitle = $catGrid['fresh_air_title'] ?? 'Fresh Air Unit';
    $freshAirUrl = !empty($catGrid['fresh_air_url']) ? $resolveTargetUrl($catGrid['fresh_air_url'], 'home') : route('category.show', 'fresh-air-systems');
    $freshAirImg = $resolveUrl($catGrid['fresh_air_image'] ?? null, 'img/home/fresh-air-unit.webp');

    $maskTitle = $catGrid['mask_title'] ?? 'Air Pro Mask';
    $maskUrl = !empty($catGrid['mask_url']) ? $resolveTargetUrl($catGrid['mask_url'], 'home') : route('category.show', 'smart-wearable-masks');
    $maskImg = $resolveUrl($catGrid['mask_image'] ?? null, 'img/home/air-pro-mask.webp');

    $accTitle = $catGrid['accessories_title'] ?? 'Accessories';
    $accUrl = !empty($catGrid['accessories_url']) ? $resolveTargetUrl($catGrid['accessories_url'], 'home') : route('category.show', 'accessories-parts');
    $accImg = $resolveUrl($catGrid['accessories_image'] ?? null, 'img/home/accessories.webp');

    $purifierTitle = $catGrid['purifier_title'] ?? 'Air Purifiers';
    $purifierUrl = !empty($catGrid['purifier_url']) ? $resolveTargetUrl($catGrid['purifier_url'], 'home') : route('category.show', 'air-purifiers');
    $purifierImg = $resolveUrl($catGrid['purifier_image'] ?? null, 'img/home/air-purifiers.webp');

    $homeSolTitle = $catGrid['home_solutions_title'] ?? 'Solutions for Home';
    $homeSolSub = $catGrid['home_solutions_sub'] ?? 'Ventilation and Filtration Solution';
    $homeSolUrl = !empty($catGrid['home_solutions_url']) ? $resolveTargetUrl($catGrid['home_solutions_url'], 'home') : route('category.show', 'home-fresh-air-systems');
    $homeSolImg = $resolveUrl($catGrid['home_solutions_image'] ?? null, 'img/home/solutions-home.webp');

    $bizSolTitle = $catGrid['biz_solutions_title'] ?? 'Solutions for Business';
    $bizSolSub = $catGrid['biz_solutions_sub'] ?? 'Air Disinfection & Air Monitoring';
    $bizSolUrl = !empty($catGrid['biz_solutions_url']) ? $resolveTargetUrl($catGrid['biz_solutions_url'], 'home') : route('category.show', 'commercial-fresh-air-systems');
    $bizSolImg = $resolveUrl($catGrid['biz_solutions_image'] ?? null, 'img/home/solutions-business.webp');
@endphp

<section class="home-category-showcase-section py-4 my-2" aria-label="Product Categories and Solutions">
    <div class="home-showcase-inner-container">
        <!-- Top Action Button -->
        <div class="home-showcase-action-wrapper text-center mb-5">
            <a href="{{ $actionUrl }}" class="home-showcase-btn" aria-label="{{ $actionText }}">
                <svg class="home-showcase-btn__icon" viewBox="0 0 24 24" width="16" height="16" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18h6"></path>
                    <path d="M10 22h4"></path>
                    <path
                        d="M12 2a7 7 0 0 0-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 0 0-7-7z">
                    </path>
                </svg>
                <span>{{ $actionText }}</span>
            </a>
        </div>

        <!-- Master Showcase Container (Guaranteed 50/50 Half-Half Layout) -->
        <div class="home-showcase-master-grid">
            <!-- Top Row: Left 50% & Right 50% -->
            <div class="home-showcase-top-row">
                <!-- 1. Fresh Air Unit (Left Large 50% Tile) -->
                <a href="{{ $freshAirUrl }}" class="bento-card bento-card--fresh-air"
                    aria-label="{{ $freshAirTitle }}">
                    <picture>
                        @if(str_ends_with(strtolower($freshAirImg), '.webp'))
                            <source srcset="{{ $freshAirImg }}" type="image/webp">
                            <img src="{{ str_replace('.webp', '.jpg', $freshAirImg) }}"
                                alt="{{ $freshAirTitle }}" class="bento-card__bg" loading="lazy">
                        @else
                            <img src="{{ $freshAirImg }}"
                                alt="{{ $freshAirTitle }}" class="bento-card__bg" loading="lazy">
                        @endif
                    </picture>
                    <div class="bento-card__pill bento-card__pill--center">
                        <span>{{ $freshAirTitle }}</span>
                    </div>
                </a>

                <!-- Right 50% Bento Cluster -->
                <div class="home-showcase-subgrid">
                    <!-- 2. Air Pro Mask (Middle Top Tile) -->
                    <a href="{{ $maskUrl }}" class="bento-card bento-card--mask"
                        aria-label="{{ $maskTitle }}">
                        <picture>
                            @if(str_ends_with(strtolower($maskImg), '.webp'))
                                <source srcset="{{ $maskImg }}" type="image/webp">
                                <img src="{{ str_replace('.webp', '.jpg', $maskImg) }}"
                                    alt="{{ $maskTitle }}" class="bento-card__bg" loading="lazy">
                            @else
                                <img src="{{ $maskImg }}"
                                    alt="{{ $maskTitle }}" class="bento-card__bg" loading="lazy">
                            @endif
                        </picture>
                        <div class="bento-card__pill bento-card__pill--center">
                            <span>{{ $maskTitle }}</span>
                        </div>
                    </a>

                    <!-- 3. Accessories (Middle Bottom Tile) -->
                    <a href="{{ $accUrl }}" class="bento-card bento-card--accessories"
                        aria-label="{{ $accTitle }}">
                        <picture>
                            @if(str_ends_with(strtolower($accImg), '.webp'))
                                <source srcset="{{ $accImg }}" type="image/webp">
                                <img src="{{ str_replace('.webp', '.jpg', $accImg) }}"
                                    alt="{{ $accTitle }}" class="bento-card__bg" loading="lazy">
                            @else
                                <img src="{{ $accImg }}"
                                    alt="{{ $accTitle }}" class="bento-card__bg" loading="lazy">
                            @endif
                        </picture>
                        <div class="bento-card__pill bento-card__pill--center">
                            <span>{{ $accTitle }}</span>
                        </div>
                    </a>

                    <!-- 4. Air Purifiers (Right Tall Tile) -->
                    <a href="{{ $purifierUrl }}" class="bento-card bento-card--purifiers"
                        aria-label="{{ $purifierTitle }}">
                        <picture>
                            @if(str_ends_with(strtolower($purifierImg), '.webp'))
                                <source srcset="{{ $purifierImg }}" type="image/webp">
                                <img src="{{ str_replace('.webp', '.jpg', $purifierImg) }}"
                                    alt="{{ $purifierTitle }}" class="bento-card__bg" loading="lazy">
                            @else
                                <img src="{{ $purifierImg }}"
                                    alt="{{ $purifierTitle }}" class="bento-card__bg" loading="lazy">
                            @endif
                        </picture>
                        <div class="bento-card__pill bento-card__pill--center">
                            <span>{{ $purifierTitle }}</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Bottom Row: Exactly 50% / 50% Half-Half Filling Full Width -->
            <div class="home-showcase-bottom-row">
                <!-- 5. Solutions for Home (50% Width) -->
                <a href="{{ $homeSolUrl }}" class="solution-banner-card solution-banner-card--home"
                    aria-label="{{ $homeSolTitle }}">
                    <picture>
                        @if(str_ends_with(strtolower($homeSolImg), '.webp'))
                            <source srcset="{{ $homeSolImg }}" type="image/webp">
                            <img src="{{ str_replace('.webp', '.jpg', $homeSolImg) }}"
                                alt="{{ $homeSolTitle }}" class="solution-banner-card__bg" loading="lazy">
                        @else
                            <img src="{{ $homeSolImg }}"
                                alt="{{ $homeSolTitle }}" class="solution-banner-card__bg" loading="lazy">
                        @endif
                    </picture>
                    <div class="solution-banner-card__overlay"></div>
                    <div class="solution-banner-card__content">
                        <h3 class="solution-banner-card__title">{{ $homeSolTitle }}</h3>
                        <p class="solution-banner-card__subtitle">{{ $homeSolSub }}</p>
                    </div>
                </a>

                <!-- 6. Solutions for Business (50% Width) -->
                <a href="{{ $bizSolUrl }}" class="solution-banner-card solution-banner-card--business"
                    aria-label="{{ $bizSolTitle }}">
                    <picture>
                        @if(str_ends_with(strtolower($bizSolImg), '.webp'))
                            <source srcset="{{ $bizSolImg }}" type="image/webp">
                            <img src="{{ str_replace('.webp', '.jpg', $bizSolImg) }}"
                                alt="{{ $bizSolTitle }}" class="solution-banner-card__bg" loading="lazy">
                        @else
                            <img src="{{ $bizSolImg }}"
                                alt="{{ $bizSolTitle }}" class="solution-banner-card__bg" loading="lazy">
                        @endif
                    </picture>
                    <div class="solution-banner-card__overlay"></div>
                    <div class="solution-banner-card__content">
                        <h3 class="solution-banner-card__title">{{ $bizSolTitle }}</h3>
                        <p class="solution-banner-card__subtitle">{{ $bizSolSub }}</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Bottom Action Button -->
        <div class="home-showcase-action-wrapper text-center mt-5">
            <a href="{{ $actionUrl }}" class="home-showcase-btn" aria-label="{{ $actionText }}">
                <svg class="home-showcase-btn__icon" viewBox="0 0 24 24" width="16" height="16" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18h6"></path>
                    <path d="M10 22h4"></path>
                    <path
                        d="M12 2a7 7 0 0 0-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 0 0-7-7z">
                    </path>
                </svg>
                <span>{{ $actionText }}</span>
            </a>
        </div>
    </div>
</section>
