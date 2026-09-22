@extends('themes.default.layouts.master')

@php
    $landingHeroTag =
        $landing?->hero_tag ?: ($product?->model ?: $product?->categories?->first()?->category_name ?? 'AIRE Pro S1');
    $landingHeroTitle = $landing?->hero_title ?: $product?->name ?? 'Atmospheric Mastery.';
    $landingHeroDesc =
        $landing?->hero_description ?:
        ($product?->description?->description
            ? getLimitedText($product->description->description, 200)
            : 'Experience revolutionary synthesis technology designed to purify every single molecule of your environment.');
    $landingHeroBtnText = $landing?->hero_button_text ?: 'More Details -';
    $landingHeroBtnUrl =
        $landing?->hero_button_url ?: ($product ? route('products.detail', $product->slug ?: $product->id) : '#');
    $landingHeroImage = $landing?->hero_image
        ? getImageUrl($landing->hero_image)
        : ($product?->main_image
            ? getImageUrl($product->main_image)
            : theme_asset('img/Air-Purify.png'));
    $productBuyNowUrl = $product ? route('products.detail', $product->slug ?: $product->id) : 'javascript:void(0);';

    $scienceFeatures = $landing?->science_features ?? [
        [
            'title' => 'Result-Oriented Approach',
            'desc' =>
                'We focus on real business results, not just design. Our solutions are made to convert visitors into customers.',
        ],
        [
            'title' => 'Affordable & Transparent Pricing',
            'desc' => 'High-quality service at a budget-friendly price. No hidden costs, no confusion.',
        ],
        [
            'title' => 'Custom Solutions',
            'desc' => 'Every business is different. We design and develop according to your exact needs and goals.',
        ],
    ];

    $specGroups = $landing?->specs_groups ?? [
        [
            'tag' => '01 / FILTRATION',
            'title' => 'Multi-Stage Synthesis',
            'image' => 'https://picsum.photos/500/500?random=1',
            'items' => [
                ['label' => 'Primary Pre-filter', 'value' => 'Large debris / Pets'],
                ['label' => 'HEPA H13 Medical-grade', 'value' => '99.97% of 0.3&mu;m'],
                ['label' => 'Activated Carbon', 'value' => 'VOCs & Odors'],
                ['label' => 'UV-C Sterilization', 'value' => 'Viral Neutralization'],
            ],
        ],
        [
            'tag' => '02 / PERFORMANCE',
            'title' => 'Atmospheric Throughput',
            'image' => 'https://picsum.photos/500/500?random=2',
            'items' => [
                ['label' => 'CADR (Smoke)', 'value' => '580 m&sup3;/h'],
                ['label' => 'Room Coverage', 'value' => 'Up to 1200 sq. ft.'],
                ['label' => 'Power Efficiency', 'value' => '65W Max / 4W Sleep'],
            ],
        ],
        [
            'tag' => '03 / SENSORS',
            'title' => 'Cognitive Awareness',
            'image' => 'https://picsum.photos/500/500?random=3',
            'items' => [
                ['label' => 'Laser Particle Sensor', 'value' => 'PM2.5 / PM10'],
                ['label' => 'Electrochemical Sensor', 'value' => 'Formaldehyde (HCHO)'],
                ['label' => 'Ambient Light Sensor', 'value' => 'Auto Night-Mode'],
            ],
        ],
        [
            'tag' => '04 / CONNECTIVITY',
            'title' => 'Unified Ecosystem',
            'image' => 'https://picsum.photos/500/500?random=4',
            'items' => [
                ['label' => 'Wireless', 'value' => 'Wi-Fi 6 & Bluetooth 5.2'],
                ['label' => 'Smart Home', 'value' => 'HomeKit, Alexa, Google'],
                ['label' => 'AIRE App', 'value' => 'Full Remote Control'],
            ],
        ],
    ];
@endphp

@section('title', 'Aire | ' . $landingHeroTitle . ' - Product Landing')

@push('styles')
    <!-- BEM Product Detail Page CSS -->
    <link href="{{ theme_asset('css/product-landing.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Top Breadcrumb Bar -->
    <div class="landing-breadcrumb-bar py-3 border-bottom bg-white">
        <div class="container-fluid main-container">
            <div class="sub-header-breadcrumb">
                <a href="{{ route('products.index') }}">Products</a>
                <span class="mx-1 text-muted">&gt;</span>
                <span
                    class="text-dark fw-medium">{{ $product?->categories?->first()?->category_name ?? 'Air Purify' }}</span>
            </div>
        </div>
    </div>

    <!-- Secondary Sticky Sub-Header Bar -->
    <div class="sub-header-bar py-2">
        <div
            class="container-fluid main-container d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-3 gap-lg-5">
                <div class="d-flex align-items-center gap-3">
                    <div class="sub-header-thumb-box">
                        <img src="{{ $landingHeroImage }}" alt="{{ $landingHeroTitle }}" class="sub-header-thumb">
                    </div>
                    <div class="sub-header-info">
                        <h4 class="sub-header-title">{{ $landingHeroTitle }}</h4>
                        <div class="sub-header-subtitle">
                            {{ getLimitedText($landingHeroDesc, 100) }}
                        </div>
                        <a href="{{ route('products.detail', $product->slug ?: $product->id) }}"
                            class="sub-header-details-btn">More Details</a>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-4">
                <div class="fw-bold fs-5">
                    @if ($product?->special_price)
                        <span
                            class="text-muted text-decoration-line-through me-1 fs-6 fw-normal">${{ number_format((float) $product->price, 2) }}</span>
                        <span>${{ number_format((float) $product->special_price, 2) }}</span>
                    @else
                        ${{ $product?->price ? number_format((float) $product->price, 2) : '249.00' }}
                    @endif
                </div>

                <div class="d-flex align-items-center justify-content-between border px-3 bg-white sub-header-qty-box"
                    style="height: 44px;">
                    <button type="button" class="btn p-0 border-0 text-dark text-decoration-none fw-medium qty-btn-minus"
                        aria-label="Decrease quantity">-</button>
                    <span class="fw-medium sub-header-qty-num qty-val px-3">1</span>
                    <button type="button" class="btn p-0 border-0 text-dark text-decoration-none fw-medium qty-btn-plus"
                        aria-label="Increase quantity">+</button>
                </div>

                <a href="{{ $productBuyNowUrl }}"
                    class="btn btn-primary text-uppercase sub-header-buy-btn d-flex align-items-center justify-content-center btn-buy-now"
                    data-product-id="{{ $product?->id }}" style="height: 44px;">BUY NOW</a>
            </div>
        </div>
    </div>

    <main>
        <!-- Product Hero Section -->
        <section class="product-hero-section">
            <div class="container-fluid main-container">
                <span class="hero-model-tag">{{ $landingHeroTag }}</span>
                <h1 class="hero-display-title section-heading">{{ $landingHeroTitle }}</h1>
                <p class="hero-display-desc">
                    {{ $landingHeroDesc }}
                </p>

                <div class="hero-action-links">
                    <a href="{{ route('products.detail', $product->slug) }}" class="hero-action-link">Read more</a>
                </div>

                <div class="hero-img-box">
                    <img src="{{ $landingHeroImage }}" alt="{{ $landingHeroTitle }}">
                </div>
            </div>
        </section>

        <!-- Science of Synthesis Section -->
        <section class="science-section">
            <div class="container-fluid main-container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-4">
                        <span class="science-tag">{{ $landing?->science_tag ?: 'SCIENCE OF SYNTHESIS' }}</span>
                        <h2 class="science-title section-heading">
                            {!! $landing?->science_title
                                ? nl2br(e($landing->science_title))
                                : 'Extraordinary<br><span class="italic-light">from within.</span>' !!}
                        </h2>
                        <p class="science-desc">
                            {{ $landing?->science_description ?: 'Every layer of the AIRE Pro S1 is engineered for peak performance. Its advanced silicon architecture and turbo-fan technology ensure the fastest air purification cycle in its class.' }}
                        </p>

                        <div class="row g-4">
                            <div class="col-6">
                                <div class="stat-box-num">{{ $landing?->science_stat1_value ?: '99.99%' }}</div>
                                <div class="stat-box-label">{{ $landing?->science_stat1_label ?: 'PARTICLE REMOVAL' }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-box-num">{{ $landing?->science_stat2_value ?: 'UV-C' }}</div>
                                <div class="stat-box-label">{{ $landing?->science_stat2_label ?: 'STERILIZATION' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="science-card-img-box h-100 py-5">
                            <img src="{{ $landing?->science_image ? getImageUrl($landing->science_image) : theme_asset('img/Air-Purify.png') }}"
                                alt="{{ $landingHeroTitle }}">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="d-flex flex-column gap-5 py-4 ps-lg-4">
                            @foreach ($scienceFeatures as $feat)
                                <div class="d-flex align-items-start gap-3">
                                    <i class="bi bi-check-circle-fill fs-5 mt-1 feature-check-icon"></i>
                                    <div>
                                        <h3 class="fw-bold mb-2 fs-6 text-dark">{{ $feat['title'] ?? '' }}</h3>
                                        <p class="text-muted mb-0 feature-check-text">{{ $feat['desc'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Lifestyle Integration Section -->
        <section class="lifestyle-section" id="lifestyle-section">
            <div class="lifestyle-banner-box">
                <img src="{{ $landing?->lifestyle_image ? getImageUrl($landing->lifestyle_image) : theme_asset('img/lyfestyle.png') }}"
                    alt="{{ $landing?->lifestyle_tag ?: 'Lifestyle' }}" class="bg-lifestyle-img">
                <div class="container-fluid main-container h-100 d-flex align-items-center">
                    <div class="lifestyle-content-card">
                        <span class="lifestyle-tag">{{ $landing?->lifestyle_tag ?: 'LIFESTYLE' }}</span>
                        <h2 class="lifestyle-title section-heading">
                            {!! $landing?->lifestyle_title ? nl2br(e($landing->lifestyle_title)) : 'Seamless<br>Integration.' !!}
                        </h2>
                        <p class="lifestyle-desc">
                            {{ $landing?->lifestyle_description ?: 'Designed for your life, not just your air. AIRE Pro S1 harmonizes with modern architectural spaces, becoming an invisible guardian of your wellbeing.' }}
                        </p>
                        <a href="{{ $landing?->lifestyle_button_url ?: '#' }}" class="lifestyle-link">
                            {!! $landing?->lifestyle_button_text ?: 'More Details &rarr;' !!}
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Medical-Grade Precision Filter Tech Section -->
        <section class="medical-filter-section">
            <div class="container-fluid main-container">
                <h2 class="section-main-heading section-heading">
                    {{ $landing?->filter_tech_title ?: 'Medical-grade Precision.' }}
                </h2>
                <p class="section-main-sub">
                    {{ $landing?->filter_tech_description ?: 'HEPA H13 Filter Technology. From microscopic particles to bacteria—nothing escapes our signature filtration system.' }}
                </p>

                <div class="filter-tech-img-box">
                    <img src="{{ $landing?->filter_tech_image ? getImageUrl($landing->filter_tech_image) : theme_asset('img/HEPA-H13-Macro.png') }}"
                        alt="{{ $landing?->filter_tech_title ?: 'HEPA H13 Filter' }}">
                    <div class="filter-tech-overlay-badge">
                        {{ $landing?->filter_tech_badge_text ?: 'Advanced micro-fiber weaving that elevates atmospheric purity to unprecedented heights.' }}
                    </div>
                </div>
            </div>
        </section>

        <!-- Precision Engineering Specs Section -->
        <section class="specs-section">
            <div class="container-fluid main-container">
                <h2 class="specs-heading section-heading">
                    {{ $landing?->specs_title ?: 'Precision Engineering.' }}
                </h2>
                <p class="specs-sub">
                    {{ $landing?->specs_subtitle ?: 'The definitive standard for air purification.' }}
                </p>

                <div class="row g-5 align-items-start">
                    <div class="col-lg-5 specs-sticky-col">
                        <div class="specs-exploded-box">
                            <img id="specs-dynamic-image" class="img-fluid"
                                src="{{ $landing?->specs_image ? getImageUrl($landing->specs_image) : $specGroups[0]['image'] ?? 'https://picsum.photos/500/500?random=1' }}"
                                alt="Exploded 3D View">
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ $landing?->specs_button_url ?: '#' }}" class="specs-more-link">
                                {!! $landing?->specs_button_text ?: 'More Details &rarr;' !!}
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        @foreach ($specGroups as $g)
                            @php
                                $imgSrc = !empty($g['image'])
                                    ? (str_starts_with($g['image'], 'http')
                                        ? $g['image']
                                        : getImageUrl($g['image']))
                                    : 'https://picsum.photos/500/500';
                            @endphp
                            <div class="spec-group-block" data-image="{{ $imgSrc }}">
                                <span class="spec-group-tag">{{ $g['tag'] ?? '' }}</span>
                                <h3 class="spec-group-title">{{ $g['title'] ?? '' }}</h3>
                                <table class="spec-table">
                                    @if (!empty($g['items']))
                                        @foreach ($g['items'] as $item)
                                            <tr>
                                                <td class="label-td">{{ $item['label'] ?? '' }}</td>
                                                <td class="value-td">{!! $item['value'] ?? '' !!}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Products Section -->
        <section class="related-products-section">
            <div class="container-fluid main-container">
                <h2 class="section-main-heading section-heading mb-5">Related Products</h2>

                <div class="swiper related-products-swiper">
                    <div class="swiper-wrapper">
                        @if (isset($relatedProducts) && $relatedProducts->count() > 0)
                            @foreach ($relatedProducts as $rel)
                                <div class="swiper-slide">
                                    <div class="related-products-card">
                                        <div>
                                            <h3 class="related-card-title">{{ $rel->name }}</h3>
                                            <p class="related-card-desc">
                                                {{ getLimitedText($rel->description?->description ?? 'Experience medical-grade air purification designed for the world\'s most demanding architectural spaces.', 100) }}
                                            </p>
                                            <div class="related-img-holder">
                                                <img src="{{ $rel->main_image ? getImageUrl($rel->main_image) : theme_asset('img/Air-Purify.png') }}"
                                                    alt="{{ $rel->name }}">
                                            </div>
                                        </div>

                                        <div class="related-card-footer">
                                            <div>
                                                <div class="related-tag-text">
                                                    {{ strtoupper($rel->categories->first()?->category_name ?? 'PREMIUM EDITION') }}
                                                </div>
                                                <div class="related-price-text">${{ number_format($rel->price ?? 0, 0) }}
                                                </div>
                                            </div>
                                            <a href="{{ route('products.landing', $rel->slug ?: $rel->id) }}"
                                                class="btn-blue-pill">Buy Now</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Default Fallback Slide 1 -->
                            <div class="swiper-slide">
                                <div class="related-products-card">
                                    <div>
                                        <h3 class="related-card-title">Bring the Future of Purity Home.</h3>
                                        <p class="related-card-desc">Experience medical-grade air purification designed for
                                            the
                                            world's most demanding architectural spaces.</p>
                                        <div class="related-img-holder">
                                            <img src="{{ theme_asset('img/Air-Purify.png') }}"
                                                alt="AIRE Pro Premium Edition">
                                        </div>
                                    </div>

                                    <div class="related-card-footer">
                                        <div>
                                            <div class="related-tag-text">PREMIUM EDITION</div>
                                            <div class="related-price-text">$1,299</div>
                                        </div>
                                        <a href="{{ route('products.filter') }}" class="btn-blue-pill">Buy Now</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Swiper Pagination -->
                    <div class="swiper-pagination related-swiper-pagination"></div>
                </div>
            </div>
        </section>

        <!-- Bottom CTA Section (Reuses Hero Fields) -->
        <section class="bottom-cta-section text-center">
            <div class="container-fluid main-container">
                <span class="hero-model-tag mb-3 d-block bottom-cta-tag">{{ $landingHeroTag }}</span>
                <h2 class="hero-display-title mb-3 section-heading bottom-cta-title">{{ $landingHeroTitle }}</h2>
                <p class="hero-display-desc mx-auto mb-4 bottom-cta-desc">{{ $landingHeroDesc }}</p>

                <div class="mb-4">
                    <a href="{{ $landingHeroBtnUrl }}" class="hero-action-link fw-bold">{{ $landingHeroBtnText }}</a>
                </div>

                <div class="mb-4">
                    <a href="{{ $productBuyNowUrl }}" class="btn btn-primary text-capitalize bottom-cta-btn">Buy Now</a>
                </div>

                <div class="mt-4 mx-auto bottom-cta-img-holder">
                    <img src="{{ $landingHeroImage }}" alt="{{ $landingHeroTitle }}" class="img-fluid">
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

    <!-- Custom Product Detail Landing Page JS -->
    <script src="{{ theme_asset('js/product-landing.js') }}" defer></script>
@endpush
