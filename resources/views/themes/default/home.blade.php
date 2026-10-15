@extends('themes.default.layouts.master')

@section('body_class', 'product-filter-page')

@push('styles')
    <!-- Critical Hero Section CSS (Instant First Paint with 0 FOUC) -->
    <style>
        .home-hero-section {
            position: relative;
            width: 100%;
            margin-top: 27px
        }

        .home-hero-swiper {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.1)
        }

        .home-hero-slide {
            position: relative;
            width: 100%;
            height: 520px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            text-align: center;
            padding-bottom: 56px;
            overflow: hidden
        }

        .home-hero-swiper:not(.swiper-initialized) .home-hero-slide:not(:first-child) {
            display: none;
        }

        .home-hero-slide__bg-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            z-index: 0;
            pointer-events: none;
            content-visibility: visible;
        }

        .home-hero-slide__overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(5, 15, 35, 0) 0%, rgba(5, 15, 35, 0.08) 25%, rgba(3, 12, 30, 0.55) 60%, rgba(2, 9, 23, 0.92) 85%, #020816 100%);
            z-index: 1;
            pointer-events: none
        }

        .home-hero-slide__content {
            position: relative;
            z-index: 2;
            max-width: 720px;
            margin: 0 auto;
            padding: 0 24px
        }

        .home-hero-slide__title {
            color: #ffffff;
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 10px
        }

        .home-hero-slide__subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            font-weight: 400;
            margin-bottom: 24px;
            line-height: 1.55
        }

        .home-hero-slide__action {
            margin-bottom: 10px
        }

        .home-hero-slide__btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--color-primary, #0072B2);
            border: 1px solid var(--color-primary, #0072B2);
            color: #ffffff !important;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 11px 32px;
            border-radius: 8px;
            text-decoration: none
        }

        @media(max-width:991.98px) {
            .home-hero-slide {
                height: 440px;
                padding-bottom: 48px
            }

            .home-hero-slide__title {
                font-size: 2rem
            }
        }

        @media(max-width:575.98px) {
            .home-hero-swiper {
                border-radius: 14px
            }

            .home-hero-slide {
                height: 380px;
                padding-bottom: 40px
            }

            .home-hero-slide__title {
                font-size: 1.6rem
            }

            .home-hero-slide__subtitle {
                font-size: 0.875rem
            }

            .home-hero-slide__btn {
                padding: 8px 24px;
                font-size: 0.85rem
            }
        }

        /* Swiper Hero Pagination Touch Target (>= 28x28px for WCAG 2.2 SC 2.5.8) */
        .home-hero-swiper-pagination {
            position: absolute;
            bottom: 24px !important;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            z-index: 5
        }

        .home-hero-swiper-pagination .swiper-pagination-bullet {
            position: relative;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: 28px !important;
            height: 28px !important;
            min-width: 28px;
            min-height: 28px;
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            border-radius: 50% !important;
            opacity: 1 !important;
            cursor: pointer;
            box-sizing: border-box !important
        }

        .home-hero-swiper-pagination .swiper-pagination-bullet::before {
            content: '';
            display: block;
            width: 7px;
            height: 7px;
            background-color: #ffffff;
            opacity: 0.4;
            border-radius: 50%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none
        }

        .home-hero-swiper-pagination .swiper-pagination-bullet:hover::before {
            opacity: 0.8;
            transform: scale(1.2)
        }

        .home-hero-swiper-pagination .swiper-pagination-bullet-active::before {
            opacity: 1;
            background-color: #ffffff;
            transform: scale(1.35)
        }

        @media(max-width:575.98px) {
            .home-hero-swiper-pagination {
                bottom: 14px !important
            }
        }

        /* Mobile Lightweight Lifestyle Row Entrance Transition (0 Main-Thread Blocking) */
        @media(max-width:991.98px) {
            .home-lifestyle__row {
                opacity: 0.15;
                transform: translateY(18px);
                transition: opacity 0.5s cubic-bezier(0.16, 1, 0.3, 1), transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
                will-change: opacity, transform;
            }
            .home-lifestyle__row.is-revealed {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- Home Page CSS (Preloaded & Non-blocking) -->
    <link rel="preload" as="style" href="{{ theme_asset('css/home.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/home.min.css') }}" media="print" onload="this.media='all'">
    <noscript>
        <link href="{{ theme_asset('css/home.min.css') }}" rel="stylesheet">
    </noscript>


    <!-- Product Filter CSS for filter components -->
    <link rel="preload" as="style" href="{{ theme_asset('css/product-filter.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/product-filter.min.css') }}" media="print" onload="this.media='all'">
    <noscript>
        <link href="{{ theme_asset('css/product-filter.min.css') }}" rel="stylesheet">
    </noscript>
@endpush

@include('themes.default.partials.home_schema')

@push('head')
    @php
        $firstHeroSlide = $heroSlides->first() ?? null;
        $firstSlideRaw = is_object($firstHeroSlide) ? $firstHeroSlide->image ?? '' : $firstHeroSlide['image'] ?? '';
        $firstSlideUrl = !empty($firstSlideRaw) ? getImageCacheUrl($firstSlideRaw, 1280, 520, 'webp') : null;
        $firstSlideSrcset = !empty($firstSlideRaw) ? getImageSrcset($firstSlideRaw, [480, 800, 1280], 0.406, 'webp') : null;
    @endphp
    @if ($firstSlideUrl)
        <link rel="preload" as="image" href="{{ $firstSlideUrl }}"
            @if ($firstSlideSrcset) imagesrcset="{{ $firstSlideSrcset }}" imagesizes="(max-width: 576px) 100vw, (max-width: 992px) 100vw, 1280px" @endif
            fetchpriority="high">
    @endif
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
                                $slideImage = getImageUrl($rawImage);

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
                                $cleanSlideTitle = trim(strip_tags($slideTitle));
                                $slideBtnAriaLabel =
                                    $slideBtnText .
                                    ($cleanSlideTitle ? ' - ' . $cleanSlideTitle : ' - Slide ' . $loop->iteration);

                                $slideImage = !empty($rawImage) ? getImageCacheUrl($rawImage, 1280, 520, 'webp') : getImageUrl($rawImage);
                                $slideSrcset = !empty($rawImage) ? getImageSrcset($rawImage, [480, 800, 1280], 0.406, 'webp') : '';
                            @endphp
                            <div class="swiper-slide home-hero-slide @if ($loop->first) swiper-slide-active @endif">
                                <img src="{{ $slideImage }}"
                                    @if ($slideSrcset) srcset="{{ $slideSrcset }}" sizes="(max-width: 576px) 100vw, (max-width: 992px) 100vw, 1280px" @endif
                                    alt="{{ $slideTitle }}" class="home-hero-slide__bg-img"
                                    width="1280" height="520"
                                    @if ($loop->first) fetchpriority="high" loading="eager" decoding="async" @else loading="lazy" decoding="async" @endif>
                                <div class="home-hero-slide__overlay"></div>
                                <div class="home-hero-slide__content">
                                    <h1 class="home-hero-slide__title">{{ $slideTitle }}</h1>
                                    @if (!empty($slideSubtitle))
                                        <p class="home-hero-slide__subtitle">{{ $slideSubtitle }}</p>
                                    @endif
                                    @if (!empty($slideBtnText))
                                        <div class="home-hero-slide__action">
                                            <a href="{{ $slideBtnUrl }}" class="btn home-hero-slide__btn"
                                                aria-label="{{ $slideBtnAriaLabel }}">{{ $slideBtnText }}<span
                                                    class="visually-hidden"> -
                                                    {{ $cleanSlideTitle ?: 'Slide ' . $loop->iteration }}</span></a>
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

            $benefitsRawImage = $benefitsSection['image'] ?? 'themes/default/assets/img/benifits-bg.png';
            $benefitsBannerImage = getImageCacheUrl($benefitsRawImage, 1200, 400, 'webp');
            $benefitsSrcset = getImageSrcset($benefitsRawImage, [600, 900, 1200], 0.333, 'webp');
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
                        <img src="{{ $benefitsBannerImage }}"
                            @if ($benefitsSrcset) srcset="{{ $benefitsSrcset }}" sizes="(max-width: 768px) 100vw, 1200px" @endif
                            alt="{{ $benefitTitle }}" class="home-benefits__bg-img"
                            width="1200" height="400" loading="lazy" decoding="async">
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

            // Products resolved and batched from StorefrontController
            $bestSellingProducts = $bestSellingProducts ?? collect();

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

            // Products resolved and batched from StorefrontController
            $newArrivalProducts = $newArrivalProducts ?? collect();

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

            // Products resolved and batched from StorefrontController
            $customerFavoritesProducts = $customerFavoritesProducts ?? collect();

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
                        preload="none" playsinline>
                        <source src="{{ $videoUrl }}" type="video/mp4">
                        <track kind="captions" label="English" srclang="en" src="data:text/vtt,WEBVTT%0A%0A" default>
                        Your browser does not support the video tag.
                    </video>

                    <!-- Initial Exploded View Poster (hides once video starts) -->
                    <div class="home-video__poster" id="homeVideoPoster">
                        <img src="{{ $videoPoster }}" alt="{{ $videoTitle }}" class="home-video__img"
                            width="1200" height="600" loading="lazy" decoding="async">
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

            // Living hero product resolved and batched from StorefrontController
            $livingProduct = $livingProduct ?? ($bottomFeaturedProduct ?? null);

            $rawBg = $livingHeroSection['image'] ?? null;
            $livingBgImage = $rawBg
                ? getImageUrl($rawBg)
                : (file_exists(public_path('themes/default/assets/img/background-without-product.png'))
                    ? theme_asset('img/background-without-product.png')
                    : getImageUrl('home/bg-of-home.png'));

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
                    <img src="{{ $livingBgImage }}" alt="Modern Living Room" class="living-hero__bg-img" width="1200"
                        height="600" loading="lazy" decoding="async">
                    <!-- Animated product image that flies down from living room scene to above Buy Now button on scroll -->
                    <img src="{{ getImageCacheUrl($livingProduct->main_image, 450, 450, 'webp') }}"
                        srcset="{{ getImageSrcset($livingProduct->main_image, [280, 450, 700], 1.0) }}"
                        sizes="(max-width: 576px) 260px, (max-width: 992px) 360px, 450px"
                        alt="{{ $livingProduct->name }}" width="450" height="450"
                        class="living-hero__animated-product" id="living-hero-animated-product" loading="lazy"
                        decoding="async">
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
                                    <h3 class="accordion-header">
                                        <button class="accordion-button {{ $isFirst ? '' : 'collapsed' }}" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                            aria-expanded="{{ $isFirst ? 'true' : 'false' }}"
                                            aria-controls="{{ $collapseId }}">
                                            {{ $item['question'] ?? '' }}
                                        </button>
                                    </h3>
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
    <!-- AIRE Home Page Controller (Lightweight mobile-first & dynamic desktop engine) -->
    <script src="{{ theme_asset('js/home.js') }}" defer></script>
@endpush
