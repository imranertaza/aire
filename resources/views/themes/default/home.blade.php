@extends('themes.default.layouts.master')

@section('body_class', 'product-filter-page')

@push('styles')
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Google Fonts Playfair Display -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <!-- BEM Product Filter Page CSS -->
    <link href="{{ theme_asset('css/product-filter.css') }}" rel="stylesheet">
    <link href="{{ theme_asset('css/home.css') }}?v={{ filemtime(public_path('themes/default/assets/css/home.css')) }}"
        rel="stylesheet">
@endpush

@section('content')

    <main class="container main-container product-filter-page__main">
        <!-- Hero Slider Section matching Home.png -->
        <div class="">
            <section class="home-hero-section">
                <div class="swiper home-hero-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($heroSlides as $slide)
                            @php
                                $rawImage = is_object($slide) ? $slide->image ?? '' : $slide['image'] ?? '';
                                $slideImage =
                                    str_starts_with($rawImage, 'http') ||
                                    str_starts_with($rawImage, 'themes/') ||
                                    str_starts_with($rawImage, '/themes/')
                                        ? $rawImage
                                        : getImageUrl($rawImage);

                                $slideTitle = is_object($slide) ? $slide->title ?? '' : $slide['title'] ?? '';
                                $slideSubtitle = is_object($slide)
                                    ? ($slide->subtitle ?:
                                    $slide->description ?? '')
                                    : $slide['subtitle'] ?? '';
                                $slideBtnText = is_object($slide)
                                    ? ($slide->button_text ?:
                                    'Shop Now')
                                    : $slide['btn_text'] ?? 'Shop Now';
                                $slideBtnUrl = is_object($slide)
                                    ? ($slide->link ?:
                                    route('products.filter'))
                                    : $slide['btn_url'] ?? route('products.filter');
                            @endphp
                            <div class="swiper-slide home-hero-slide" style="background-image: url('{{ $slideImage }}');">
                                <div class="home-hero-slide__overlay"></div>
                                <div class="home-hero-slide__content">
                                    <h1 class="home-hero-slide__title">{{ $slideTitle }}</h1>
                                    @if (!empty($slideSubtitle))
                                        <p class="home-hero-slide__subtitle">{{ $slideSubtitle }}</p>
                                    @endif
                                    @if (!empty($slideBtnText))
                                        <div class="home-hero-slide__action">
                                            <a href="{{ $slideBtnUrl }}"
                                                class="btn home-hero-slide__btn">{{ $slideBtnText }}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Swiper Pagination (3 demo slides dots) -->
                    <div class="swiper-pagination home-hero-swiper-pagination"></div>
                </div>
            </section>
        </div>
        <!-- Section 2: Benefits (Pure Air, Healthy Living) matching Home.png -->
        @php
            $benefitsSection = getSection('home_benefits') ?? (getSection('benefits') ?? []);
            $benefitBadge = $benefitsSection['badge'] ?? 'BENEFITS';
            $benefitTitle = $benefitsSection['title'] ?? 'Pure Air, Healthy Living';
            $benefitSubtitle =
                $benefitsSection['subtitle'] ??
                'Get authentic products, fast delivery, and trusted local service — only from us.';
            $benefitCards = !empty($benefitsSection['cards'])
                ? $benefitsSection['cards']
                : [
                    [
                        'title' => 'Authentic Products',
                        'description' => '100% genuine guaranteed with official manufacturer warranty',
                    ],
                    [
                        'title' => 'Warranty Coverage',
                        'description' => 'Comprehensive protection and technical maintenance plan',
                    ],
                    [
                        'title' => 'Fast Delivery',
                        'description' => 'Swift nationwide door-to-door shipping service available',
                    ],
                    [
                        'title' => 'Trusted Service',
                        'description' => 'Dedicated local experts for support, setup, and advice',
                    ],
                    [
                        'title' => 'Easy Replacement',
                        'description' => 'Hassle-free filter and parts replacement availability',
                    ],
                    [
                        'title' => 'Multiple Choices',
                        'description' => 'Wide range of models and features to suit lifestyles',
                    ],
                ];

            $benefitsBannerImage = getImageUrl(
                $benefitsSection['image'] ?? 'themes/default/assets/img/benifits-bg.png',
            );
        @endphp

        <section class="home-benefits-section py-4 my-3">
            <div class="">
                <!-- Header matching Home.png -->
                <div class="home-benefits__header">
                    <span class="home-benefits__badge">{{ $benefitBadge }}</span>
                    <h2 class="home-benefits__title">{{ $benefitTitle }}</h2>
                    <p class="home-benefits__subtitle">{{ $benefitSubtitle }}</p>
                </div>

                <!-- Visual Banner Box with 6 Benefit Cards -->
                <div class="home-benefits__banner">
                    <!-- Parallax Background Image (Dynamic) -->
                    <div class="home-benefits__banner-bg">
                        <img src="{{ $benefitsBannerImage }}" alt="{{ $benefitTitle }}" class="home-benefits__bg-img">
                    </div>
                    <div class="home-benefits__overlay"></div>
                    <div class="home-benefits__grid">
                        @foreach ($benefitCards as $card)
                            <div class="home-benefit-card">
                                <h3 class="home-benefit-card__title">{{ $card['title'] }}</h3>
                                <p class="home-benefit-card__desc">{{ $card['description'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 3: Best Selling Product matching Home.png -->
        @php
            $bestSellingSection = getSection('home_best_selling') ?? (getSection('best_selling') ?? []);
            $bestSellingBadge = $bestSellingSection['badge'] ?? 'Product';
            $bestSellingTitle = $bestSellingSection['title'] ?? 'Best Selling Product';
            $bestSellingSubtitle =
                $bestSellingSection['subtitle'] ??
                'Discover the top‑selling models trusted by thousands of families for cleaner, healthier air.';
            $bestSellingProductIds = $bestSellingSection['product_ids'] ?? [];

            $bestSellingProducts = \Illuminate\Support\Facades\Cache::remember('home_best_selling_products', 3600, function () use ($bestSellingProductIds) {
                $prods = collect();
                if (!empty($bestSellingProductIds) && is_array($bestSellingProductIds)) {
                    $orderedProducts = \App\Models\Product::with(['categories', 'images'])
                        ->whereIn('id', $bestSellingProductIds)
                        ->where('status', 1)
                        ->get()
                        ->keyBy('id');

                    $prods = collect($bestSellingProductIds)
                        ->map(fn($id) => $orderedProducts->get($id))
                        ->filter()
                        ->values();
                }

                // Fallback: If no products were selected or found, fetch latest active products
                if ($prods->isEmpty()) {
                    $prods = \App\Models\Product::with(['categories', 'images'])
                        ->where('status', 1)
                        ->latest('id')
                        ->take(4)
                        ->get();
                }

                return $prods;
            });

            // Fallback: If database has no products at all, preserve original mock cards
            if ($bestSellingProducts->isEmpty()) {
                $bestSellingProducts = collect([
                    [
                        'id' => 5,
                        'badge' => 'Home',
                        'image' => theme_asset('img/Air-Purify.png'),
                        'name' => 'AIRE Pro S1 (Snow)',
                        'category' => 'ENTERPRISE FILTRATION',
                        'price' => 550,
                        'url' => route('products.index'),
                    ],
                    [
                        'id' => 6,
                        'badge' => 'Home',
                        'image' => theme_asset('img/Air-Purify.png'),
                        'name' => 'AIRE Pro S1 (Snow)',
                        'category' => 'ENTERPRISE FILTRATION',
                        'price' => 550,
                        'url' => route('products.index'),
                    ],
                    [
                        'id' => 7,
                        'badge' => 'Home',
                        'image' => theme_asset('img/Air-Purify.png'),
                        'name' => 'AIRE Pro S1 (Snow)',
                        'category' => 'ENTERPRISE FILTRATION',
                        'price' => 550,
                        'url' => route('products.index'),
                    ],
                    [
                        'id' => 8,
                        'badge' => 'Home',
                        'image' => theme_asset('img/Air-Purify.png'),
                        'name' => 'AIRE Pro S1 (Snow)',
                        'category' => 'ENTERPRISE FILTRATION',
                        'price' => 550,
                        'url' => route('products.index'),
                    ],
                ]);
            }
        @endphp

        <section class="home-best-selling-section py-4 my-3">
            <div class="">
                <!-- Header matching Home.png -->
                <div class="home-best-selling__header text-center mb-4">
                    <span class="home-best-selling__badge">{{ $bestSellingBadge }}</span>
                    <h2 class="home-best-selling__title">{{ $bestSellingTitle }}</h2>
                    <p class="home-best-selling__subtitle">{{ $bestSellingSubtitle }}</p>
                </div>

                <!-- Outer Rounded Grey Box matching Home.png -->
                <div class="home-best-selling__box">
                    <div class="home-best-selling__grid">
                        @foreach ($bestSellingProducts as $item)
                            @include('themes.default.partials.home_product_card', ['item' => $item])
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        @php
            $lifestyleSection = getSection('home_lifestyle') ?? (getSection('lifestyle') ?? []);
            $lifestyleBadge = $lifestyleSection['badge'] ?? 'LIFESTYLE';
            $lifestyleTitle = $lifestyleSection['title'] ?? 'Seamless Living, Cleaner Air';
            $lifestyleSubtitle =
                $lifestyleSection['subtitle'] ??
                'From bedrooms to offices, our purifiers blend effortlessly into every space while keeping your air fresh and healthy.';
            $lifestyleItems = !empty($lifestyleSection['items'])
                ? $lifestyleSection['items']
                : [
                    [
                        'title' => 'Bedroom Serenity',
                        'description' =>
                            'Sleep peacefully with cleaner air by your side. Wake up refreshed every morning with purified air.',
                        'image' => 'home/lifestyle/s1.png',
                    ],
                    [
                        'title' => 'Living Room Comfort',
                        'description' =>
                            'Enjoy family moments in a healthier environment. Keep your living space fresh and welcoming.',
                        'image' => 'home/lifestyle/s2.png',
                    ],
                    [
                        'title' => 'Office Focus',
                        'description' =>
                            'Boost productivity with fresh, purified air at work. Stay sharp and energized throughout the day.',
                        'image' => 'home/lifestyle/s3.png',
                    ],
                    [
                        'title' => "Kids' Room Safety",
                        'description' =>
                            'Protect your children from dust, pollen, and allergens. Ensure safe, clean air to breathe.',
                        'image' => 'home/lifestyle/s4.png',
                    ],
                ];
        @endphp

        <section class="home-lifestyle-section" id="homeLifestyleSection">
            <div class="">
                <!-- Section Header -->
                <div class="home-lifestyle__header">
                    <span class="home-lifestyle__badge">{{ $lifestyleBadge }}</span>
                    <h2 class="home-lifestyle__title">{{ $lifestyleTitle }}</h2>
                    <p class="home-lifestyle__subtitle">{{ $lifestyleSubtitle }}</p>
                </div>

                <!-- Lifestyle Rows -->
                <div class="home-lifestyle__list">
                    @foreach ($lifestyleItems as $item)
                        @if ($loop->index % 2 == 0)
                            <!-- Even Row: Text Left, Image Right -->
                            <div class="row align-items-center home-lifestyle__row">
                                <div class="col-lg-4 col-md-5 home-lifestyle__col-text">
                                    <div class="home-lifestyle__content">
                                        <h3 class="home-lifestyle__item-title">{{ $item['title'] ?? '' }}</h3>
                                        <p class="home-lifestyle__item-desc">{{ $item['description'] ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-7 home-lifestyle__col-img">
                                    <div class="home-lifestyle__img-box">
                                        <img src="{{ getImageCacheUrl($item['image'] ?? '', 856, 385, 'webp') }}"
                                            srcset="{{ getImageSrcset($item['image'] ?? '', [400, 600, 856, 1200], 385 / 856) }}"
                                            sizes="(max-width: 768px) 100vw, 856px"
                                            alt="{{ $item['title'] ?? 'Lifestyle' }}" width="856" height="385"
                                            class="home-lifestyle__img" loading="lazy" decoding="async">
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Odd Row: Image Left, Text Right -->
                            <div class="row align-items-center home-lifestyle__row">
                                <div class="col-lg-8 col-md-7 order-2 order-md-1 home-lifestyle__col-img">
                                    <div class="home-lifestyle__img-box">
                                        <img src="{{ getImageCacheUrl($item['image'] ?? '', 856, 385, 'webp') }}"
                                            srcset="{{ getImageSrcset($item['image'] ?? '', [400, 600, 856, 1200], 385 / 856) }}"
                                            sizes="(max-width: 768px) 100vw, 856px"
                                            alt="{{ $item['title'] ?? 'Lifestyle' }}" width="856" height="385"
                                            class="home-lifestyle__img" loading="lazy" decoding="async">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-5 order-1 order-md-2 home-lifestyle__col-text ps-md-4 ps-lg-5">
                                    <div class="home-lifestyle__content">
                                        <h3 class="home-lifestyle__item-title">{{ $item['title'] ?? '' }}</h3>
                                        <p class="home-lifestyle__item-desc">{{ $item['description'] ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Section: New Arrival / Freshly Launched Models matching Home.png -->
        @php
            $newArrivalSection = getSection('home_new_arrival') ?? (getSection('new_arrival') ?? []);
            $newArrivalBadge = $newArrivalSection['badge'] ?? 'New arrival';
            $newArrivalTitle = $newArrivalSection['title'] ?? 'Freshly Launched Models';
            $newArrivalSubtitle =
                $newArrivalSection['subtitle'] ??
                'Explore the latest purifiers designed with advanced technology for modern living.';
            $newArrivalProductIds = $newArrivalSection['product_ids'] ?? [];

            $newArrivalProducts = \Illuminate\Support\Facades\Cache::remember('home_new_arrival_products', 3600, function () use ($newArrivalProductIds) {
                $prods = collect();
                if (!empty($newArrivalProductIds) && is_array($newArrivalProductIds)) {
                    $orderedNewProducts = \App\Models\Product::with(['categories', 'images'])
                        ->whereIn('id', $newArrivalProductIds)
                        ->where('status', 1)
                        ->get()
                        ->keyBy('id');

                    $prods = collect($newArrivalProductIds)
                        ->map(fn($id) => $orderedNewProducts->get($id))
                        ->filter()
                        ->values();
                }

                // Fallback: If no products were selected or found, fetch latest active products
                if ($prods->isEmpty()) {
                    $prods = \App\Models\Product::with(['categories', 'images'])
                        ->where('status', 1)
                        ->latest('id')
                        ->take(3)
                        ->get();
                }

                return $prods;
            });

            // Fallback: If database has no products at all, preserve original mock cards
            if ($newArrivalProducts->isEmpty()) {
                $newArrivalProducts = collect([
                    [
                        'id' => 5,
                        'badge' => 'Home',
                        'image' => theme_asset('img/Air-Purify.png'),
                        'name' => 'AIRE Pro S1 (Snow)',
                        'category' => 'ENTERPRISE FILTRATION',
                        'price' => 550,
                        'url' => route('products.index'),
                    ],
                    [
                        'id' => 6,
                        'badge' => 'Home',
                        'image' => theme_asset('img/Air-Purify.png'),
                        'name' => 'AIRE Pro S1 (Snow)',
                        'category' => 'ENTERPRISE FILTRATION',
                        'price' => 550,
                        'url' => route('products.index'),
                    ],
                    [
                        'id' => 7,
                        'badge' => 'Home',
                        'image' => theme_asset('img/Air-Purify.png'),
                        'name' => 'AIRE Pro S1 (Snow)',
                        'category' => 'ENTERPRISE FILTRATION',
                        'price' => 550,
                        'url' => route('products.index'),
                    ],
                ]);
            }
        @endphp

        <section class="home-best-selling-section py-4 my-3">
            <div class="">
                <!-- Header matching Home.png -->
                <div class="home-best-selling__header text-center mb-4">
                    <span class="home-best-selling__badge">{{ $newArrivalBadge }}</span>
                    <h2 class="home-best-selling__title">{{ $newArrivalTitle }}</h2>
                    <p class="home-best-selling__subtitle">{{ $newArrivalSubtitle }}</p>
                </div>

                <!-- Outer Rounded Grey Box matching Home.png -->
                <div class="home-best-selling__box">
                    <div class="home-best-selling__grid">
                        @foreach ($newArrivalProducts as $item)
                            @include('themes.default.partials.home_product_card', ['item' => $item])
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- Center Content Feed (col-lg-6) -->
        <!-- Section: Why Choose AIRE? (GSAP ScrollTrigger Pinned Deck Animation) -->
        @php
            $whyChooseSection = getSection('why_choose_aire');
            $cardsList = $whyChooseSection['cards'] ?? [];
        @endphp

        @if (!empty($whyChooseSection))
            <section class="why-choose-stacked-wrapper my-5" id="whyChooseStackedWrapper">
                <div class="stacked-cards-sticky-pin">
                    <div class="why-choose-stacked__header">
                        <h2 class="why-choose-stacked__title home-lifestyle__title">
                            {{ $whyChooseSection['title'] ?? 'Why Choose AIRE?' }}</h2>
                        @if (!empty($whyChooseSection['subtitle']))
                            <span
                                class="why-choose-stacked__subtitle home-lifestyle__subtitle">{{ $whyChooseSection['subtitle'] }}</span>
                        @endif
                    </div>

                    <div class="stacked-cards-container">
                        @foreach ($cardsList as $index => $card)
                            @php
                                $layerIndex = $index + 1;
                                $cardClass = $card['card_class'] ?? 'card-layer-' . $layerIndex;
                                $isDark = ($card['theme'] ?? '') === 'dark' || $index === 0;
                                $titleColor = $isDark ? 'text-white' : 'text-dark';
                                $dots = !empty($card['dots'])
                                    ? $card['dots']
                                    : str_repeat('&bull;', $layerIndex <= 3 ? 3 : 4);
                            @endphp
                            <!-- Layer {{ $layerIndex }} -->
                            <div class="stacked-card {{ $cardClass }}">
                                <div class="card-left-header">
                                    <div class="why-dots mb-2">{!! $dots !!}</div>
                                    <h3 class="tab-title {{ $titleColor }}">{!! $card['title'] ?? '' !!}</h3>
                                </div>
                                <div class="card-right-body">
                                    <p class="mb-0">{!! $card['description'] ?? ($card['content'] ?? '') !!}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Section: Customers Favorites matching Home.png -->
        @php
            $customerFavoritesSection =
                getSection('home_customer_favorites') ?? (getSection('customer_favorites') ?? []);
            $customerFavoritesBadge = $customerFavoritesSection['badge'] ?? 'Customers Favorites';
            $customerFavoritesTitle = $customerFavoritesSection['title'] ?? 'Loved by Our Community';
            $customerFavoritesSubtitle =
                $customerFavoritesSection['subtitle'] ??
                'Discover the purifiers most chosen by families who value clean, healthy air.';
            $customerFavoritesProductIds = $customerFavoritesSection['product_ids'] ?? [];

            $customerFavoritesProducts = \Illuminate\Support\Facades\Cache::remember('home_customer_fav_products', 3600, function () use ($customerFavoritesProductIds) {
                $prods = collect();
                if (!empty($customerFavoritesProductIds) && is_array($customerFavoritesProductIds)) {
                    $orderedFavProducts = \App\Models\Product::with(['categories', 'images'])
                        ->whereIn('id', $customerFavoritesProductIds)
                        ->where('status', 1)
                        ->get()
                        ->keyBy('id');

                    $prods = collect($customerFavoritesProductIds)
                        ->map(fn($id) => $orderedFavProducts->get($id))
                        ->filter()
                        ->values();
                }

                // Fallback: If no products were selected or found, fetch latest active products
                if ($prods->isEmpty()) {
                    $prods = \App\Models\Product::with(['categories', 'images'])
                        ->where('status', 1)
                        ->skip(3)
                        ->take(3)
                        ->get();
                }

                return $prods;
            });

            // Fallback: If database has no products at all, preserve original mock cards
            if ($customerFavoritesProducts->isEmpty()) {
                $customerFavoritesProducts = collect([
                    [
                        'id' => 8,
                        'badge' => 'Home',
                        'image' => theme_asset('img/Air-Purify.png'),
                        'name' => 'AIRE Pro S1 (Snow)',
                        'category' => 'ENTERPRISE FILTRATION',
                        'price' => 550,
                        'url' => route('products.index'),
                    ],
                    [
                        'id' => 9,
                        'badge' => 'Home',
                        'image' => theme_asset('img/Air-Purify.png'),
                        'name' => 'AIRE Pro S1 (Snow)',
                        'category' => 'ENTERPRISE FILTRATION',
                        'price' => 550,
                        'url' => route('products.index'),
                    ],
                ]);
            }
        @endphp

        <section class="home-best-selling-section py-4 my-3">
            <div class="">
                <!-- Header matching Home.png -->
                <div class="home-best-selling__header text-center mb-4">
                    <span class="home-best-selling__badge">{{ $customerFavoritesBadge }}</span>
                    <h2 class="home-best-selling__title">{{ $customerFavoritesTitle }}</h2>
                    <p class="home-best-selling__subtitle">{{ $customerFavoritesSubtitle }}</p>
                </div>

                <!-- Outer Rounded Grey Box matching Home.png -->
                <div class="home-best-selling__box">
                    <div class="home-best-selling__grid">
                        @foreach ($customerFavoritesProducts as $item)
                            @include('themes.default.partials.home_product_card', ['item' => $item])
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Technical Visualization & Video Banner matching Home.png -->
        @php
            $videoSection = getSection('home_video') ?? (getSection('video') ?? []);
            $videoTitle = !empty($videoSection['title'])
                ? $videoSection['title']
                : 'AIRE Pro S1 — Engineering Architecture & Air Purification';
            $videoPoster = getImageUrl(
                !empty($videoSection['image']) ? $videoSection['image'] : 'home/video_thumb.png',
            );
            $videoUrl = !empty($videoSection['video_file'])
                ? getImageUrl($videoSection['video_file'])
                : (!empty($videoSection['video_url'])
                    ? (preg_match('/^https?:\/\//i', $videoSection['video_url'])
                        ? $videoSection['video_url']
                        : getImageUrl($videoSection['video_url']))
                    : getImageUrl('home/home-video.mp4'));
        @endphp

        <section class="home-video-section mb-4 mb-lg-5" id="homeVideoSection">
            <div class="">
                <div class="home-video__box is-paused" id="homeVideoBox" role="region"
                    aria-label="{{ $videoTitle }}">
                    <!-- HTML5 Inline Video Player -->
                    <video id="homeMainVideo" class="home-video__player" poster="{{ $videoPoster }}"
                        preload="metadata" playsinline>
                        <source src="{{ $videoUrl }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                    <!-- Initial Exploded View Poster (hides once video starts) -->
                    <div class="home-video__poster" id="homeVideoPoster">
                        <img src="{{ $videoPoster }}" alt="{{ $videoTitle }}" class="home-video__img"
                            loading="lazy">
                    </div>

                    <!-- Glowing Play Button Overlay (always visible on pause, ended, or initial state) -->
                    <div class="home-video__play-overlay" id="homeVideoPlayOverlay">
                        <div class="home-video__play-pulse" id="homeVideoPlayPulse"></div>
                        <button class="home-video__play-btn" type="button" id="homeVideoPlayBtn"
                            aria-label="Play or Pause Video">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: The Future of Pure Living Hero (Bottom Featured Product) -->
        @php
            $livingHeroSection = getSection('home_living_hero') ?? (getSection('living_hero') ?? []);
            $livingHeroEnabled = isset($livingHeroSection['enabled']) ? (bool) $livingHeroSection['enabled'] : true;

            $livingProductId = $livingHeroSection['product_id'] ?? null;
            $livingProduct = \Illuminate\Support\Facades\Cache::remember('home_living_hero_product', 3600, function () use ($livingProductId, $bottomFeaturedProduct) {
                $prod = null;
                if (!empty($livingProductId)) {
                    $prod = \App\Models\Product::with(['description', 'categories', 'images'])->find($livingProductId);
                }
                if (!$prod && isset($bottomFeaturedProduct) && $bottomFeaturedProduct) {
                    $prod = $bottomFeaturedProduct;
                }
                return $prod;
            });

            $rawBg = $livingHeroSection['image'] ?? null;
            if ($rawBg) {
                $livingBgImage =
                    str_starts_with($rawBg, 'themes/') || str_starts_with($rawBg, 'http')
                        ? asset($rawBg)
                        : getImageUrl($rawBg);
            } else {
                $livingBgImage = file_exists(public_path('themes/default/assets/img/background-without-product.png'))
                    ? theme_asset('img/background-without-product.png')
                    : getImageUrl('home/bg-of-home.png');
            }

            $livingTitle = !empty($livingHeroSection['title'])
                ? $livingHeroSection['title']
                : $livingProduct->name ?? 'The Future of Pure Living';

            $livingDescription = !empty($livingHeroSection['description'])
                ? $livingHeroSection['description']
                : (!empty($livingHeroSection['subtitle'])
                    ? $livingHeroSection['subtitle']
                    : getLimitedText($livingProduct->description->description ?? '', 160));

            $livingBtnText = !empty($livingHeroSection['button_text']) ? $livingHeroSection['button_text'] : 'Buy Now';
        @endphp

        @if ($livingHeroEnabled && $livingProduct)
            <section class="living-hero" id="living-hero-section">
                <div class="living-hero__image-bg" id="living-hero-img-box">
                    <img src="{{ $livingBgImage }}" alt="Modern Living Room" class="living-hero__bg-img">
                    <!-- Animated product image that flies down from living room scene to above Buy Now button on scroll -->
                    <img src="{{ getImageCacheUrl($livingProduct->main_image, 450, 450, 'webp') }}"
                        srcset="{{ getImageSrcset($livingProduct->main_image, [280, 450, 700], 1.0) }}"
                        sizes="(max-width: 576px) 260px, (max-width: 992px) 360px, 450px"
                        alt="{{ $livingProduct->name }}"
                        class="living-hero__animated-product" id="living-hero-animated-product">
                </div>

                <h2 class="living-hero__title">{{ $livingTitle }}</h2>
                <p class="living-hero__description">
                    {{ $livingDescription }}
                </p>

                <!-- Landing target container above Buy Now button matching mockup -->
                <div class="living-hero__product-target" id="living-hero-product-target">
                    <div class="living-hero__product-placeholder"></div>
                </div>

                <div class="mt-2">
                    <a href="{{ route('products.detail', $livingProduct->slug ?: $livingProduct->id) }}"
                        class="living-hero__button">{{ $livingBtnText }} —
                        ${{ number_format($livingProduct->price, 2) }}</a>
                </div>
            </section>
        @endif

        <!-- Section 7: FAQ -->
        @php
            $faqSection = getSection('home_faq') ?? getSection('faq');
            $faqBadge = $faqSection['badge'] ?? 'SUPPORT';
            $faqTitle = $faqSection['title'] ?? 'Frequently Asked Questions';
            $faqSubtitle = $faqSection['subtitle'] ?? '';
            $faqItems =
                !empty($faqSection['items']) && is_array($faqSection['items'])
                    ? $faqSection['items']
                    : [
                        [
                            'question' => 'How long do the HEPA H13 filters last?',
                            'answer' =>
                                'Under normal conditions, filters should be replaced every 120-150 hours of active use. The integrated sensor will notify you via the LED ring and app when replacement is required.',
                        ],
                        [
                            'question' => 'Is the Airpro Mask FB2 suitable for high-intensity exercise?',
                            'answer' =>
                                'Yes. The active pressure balance system dynamically adjusts airflow to match your breathing rate, preventing CO2 buildup and keeping the interior cool during physical exertion.',
                        ],
                        [
                            'question' => 'How do I sanitize the mask?',
                            'answer' =>
                                'The medical-grade silicone seal is detachable and can be cleaned with warm soapy water or alcohol-based wipes. Ensure the electronic chassis is removed before cleaning.',
                        ],
                        [
                            'question' => 'Does the mask support Bluetooth connectivity?',
                            'answer' =>
                                'Yes, it connects to the AIRE app via Bluetooth 5.2 for real-time air quality monitoring, filter healthtracking, and firmware updates.',
                        ],
                        [
                            'question' => 'What is the battery life of the active sensors?',
                            'answer' =>
                                'The internal battery provides up to 12 hours of continuous operation on a single charge. It supports fast charging via USB-C, reaching 80% in just 45 minutes.',
                        ],
                    ];
        @endphp
        <section id="faq" class="my-4">
            <div class="">
                <div class="text-center mb-5">
                    @if (!empty($faqBadge))
                        <div class="text-uppercase text-muted small fw-bold mb-2"
                            style="font-size: 0.7rem; letter-spacing: 1.5px;">{{ $faqBadge }}</div>
                    @endif
                    <h2 class="fw-bold text-dark title-2">{{ $faqTitle }}</h2>
                    @if (!empty($faqSubtitle))
                        <p class="text-muted mt-2">{{ $faqSubtitle }}</p>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-9 px-md-0 ">
                        <div class="accordion custom-accordion" id="faqAccordion">
                            @foreach ($faqItems as $idx => $item)
                                @php
                                    $collapseId = 'faq' . ($idx + 1);
                                    $isFirst = $loop->first;
                                @endphp
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $isFirst ? '' : 'collapsed' }}" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                            aria-expanded="{{ $isFirst ? 'true' : 'false' }}"
                                            aria-controls="{{ $collapseId }}">
                                            {{ $item['question'] ?? '' }}
                                        </button>
                                    </h2>
                                    <div id="{{ $collapseId }}"
                                        class="accordion-collapse collapse {{ $isFirst ? 'show' : '' }}"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            {!! nl2br(e($item['answer'] ?? '')) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- <div class="col-md-3"></div> --}}
                </div>

            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <!-- Home Hero Swiper Slider Init -->
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            function initHomeHeroSwiper() {
                if (typeof Swiper === 'undefined') {
                    setTimeout(initHomeHeroSwiper, 50);
                    return;
                }
                const heroSliderEl = document.querySelector('.home-hero-swiper');
                if (heroSliderEl) {
                    new Swiper(heroSliderEl, {
                        loop: true,
                        speed: 800,
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        },
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                            pauseOnMouseEnter: true
                        },
                        pagination: {
                            el: '.home-hero-swiper-pagination',
                            clickable: true
                        },
                        keyboard: {
                            enabled: true,
                            onlyInViewport: true
                        }
                    });
                }
            }
            initHomeHeroSwiper();

            // Inline Video Player Handler with Pause/Play Button Toggle
            const videoBox = document.getElementById('homeVideoBox');
            const mainVideo = document.getElementById('homeMainVideo');
            const playBtn = document.getElementById('homeVideoPlayBtn');

            if (videoBox && mainVideo) {
                function togglePlay(e) {
                    if (e) e.stopPropagation();
                    if (mainVideo.paused || mainVideo.ended) {
                        mainVideo.play().catch(function(err) {
                            console.log('Playback error:', err);
                        });
                    } else {
                        mainVideo.pause();
                    }
                }

                // Sync video state to show/hide play button
                mainVideo.addEventListener('play', function() {
                    videoBox.classList.add('is-playing');
                    videoBox.classList.add('has-started');
                    videoBox.classList.remove('is-paused');
                    mainVideo.controls = true;
                });

                mainVideo.addEventListener('pause', function() {
                    videoBox.classList.remove('is-playing');
                    videoBox.classList.add('is-paused');
                });

                mainVideo.addEventListener('ended', function() {
                    videoBox.classList.remove('is-playing');
                    videoBox.classList.add('is-paused');
                });

                if (playBtn) {
                    playBtn.addEventListener('click', togglePlay);
                }

                // Clicking on video box toggles play/pause
                videoBox.addEventListener('click', function(e) {
                    // If clicking directly on controls bar, allow native control
                    if (e.target === mainVideo && !mainVideo.paused) {
                        mainVideo.pause();
                    } else if (mainVideo.paused) {
                        togglePlay(e);
                    }
                });
            }

        });
    </script>
    <!-- Custom Product Filter JS -->
    <script src="{{ theme_asset('js/product-filter.js') }}" defer></script>
    <script src="{{ theme_asset('js/home.js') }}" defer></script>
@endpush
