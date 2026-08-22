@extends('themes.default.layouts.master')

@section('title', 'Aire | AIRE Pro S1 - Product Landing')

@push('styles')
<!-- Google Fonts Playfair Display -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
<!-- BEM Product Detail Page CSS -->
<link href="{{ theme_asset('css/product-detail.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Secondary Sticky Sub-Header Bar -->
<div class="sub-header-bar py-3">
    <div
        class="container-fluid main-container d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-3 gap-lg-5">
            <div class="sub-header-breadcrumb">
                <a href="products.html">Products</a> &gt; <span class="text-dark fw-medium">Air Purify</span>
            </div>

            <div class="d-none d-lg-flex align-items-center gap-3">
                <img src="{{theme_asset('img/Air-Purify.png')}}" alt="Airpro Mask FB2" class="sub-header-thumb">
                <div>
                    <h5 class="mb-0 fw-bold sub-header-title">Airpro Mask FB2</h5>
                    <div class="text-muted sub-header-subtitle">Next-Generation Active Wearable Air Purifier</div>
                </div>
                <a href="#" class="btn btn-dark ms-3 sub-header-details-btn">More Details</a>
            </div>
        </div>

        <div class="d-flex align-items-center gap-4">
            <div class="fw-bold fs-5">$249</div>

            <div class="d-flex align-items-center justify-content-between border px-3 bg-white sub-header-qty-box"
                style="height: 44px;">
                <button type="button"
                    class="btn p-0 border-0 text-dark text-decoration-none fw-medium qty-btn-minus"
                    aria-label="Decrease quantity">-</button>
                <span class="fw-medium sub-header-qty-num qty-val px-3">1</span>
                <button type="button" class="btn p-0 border-0 text-dark text-decoration-none fw-medium qty-btn-plus"
                    aria-label="Increase quantity">+</button>
            </div>

            <a href="checkout.html"
                class="btn btn-primary text-uppercase sub-header-buy-btn d-flex align-items-center justify-content-center"
                style="height: 44px;">BUY NOW</a>
        </div>
    </div>
</div>

<main>
    <!-- Product Hero Section -->
    <section class="product-hero-section">
        <div class="container-fluid main-container">
            <span class="hero-model-tag">AIRE Pro S1</span>
            <h1 class="hero-display-title section-heading">Atmospheric Mastery.</h1>
            <p class="hero-display-desc">Experience revolutionary synthesis technology designed to purify every single
                molecule of your environment.</p>

            <div class="hero-action-links">
                <a href="#" class="hero-action-link">More Details -</a>
            </div>

            <div class="hero-img-box">
                <img src="{{theme_asset('img/Air-Purify.png')}}" alt="AIRE Pro S1">
            </div>
        </div>
    </section>

    <!-- Science of Synthesis Section -->
    <section class="science-section">
        <div class="container-fluid main-container">
            <div class="row align-items-center g-5">
                <div class="col-lg-4">
                    <span class="science-tag">SCIENCE OF SYNTHESIS</span>
                    <h2 class="science-title section-heading">Extraordinary<br><span class="italic-light">from
                            within.</span></h2>
                    <p class="science-desc">Every layer of the AIRE Pro S1 is engineered for peak performance. Its
                        advanced silicon architecture and turbo-fan technology ensure the fastest air purification cycle
                        in its class.</p>

                    <div class="row g-4">
                        <div class="col-6">
                            <div class="stat-box-num">99.99%</div>
                            <div class="stat-box-label">PARTICLE REMOVAL</div>
                        </div>
                        <div class="col-6">
                            <div class="stat-box-num">UV-C</div>
                            <div class="stat-box-label">STERILIZATION</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="science-card-img-box h-100 py-5">
                        <img src="{{theme_asset('img/Air-Purify.png')}}" alt="Inside AIRE Pro S1">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="d-flex flex-column gap-5 py-4 ps-lg-4">
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-check-circle-fill fs-5 mt-1 feature-check-icon"></i>
                            <div>
                                <h3 class="fw-bold mb-2 fs-6 text-dark">Result-Oriented Approach</h3>
                                <p class="text-muted mb-0 feature-check-text">We focus on real
                                    business results, not just design. Our solutions are made to convert visitors into
                                    customers.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-check-circle-fill fs-5 mt-1 feature-check-icon"></i>
                            <div>
                                <h3 class="fw-bold mb-2 fs-6 text-dark">Affordable &amp; Transparent Pricing</h3>
                                <p class="text-muted mb-0 feature-check-text">High-quality
                                    service at a budget-friendly price. No hidden costs, no confusion.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-check-circle-fill fs-5 mt-1 feature-check-icon"></i>
                            <div>
                                <h3 class="fw-bold mb-2 fs-6 text-dark">Custom Solutions</h3>
                                <p class="text-muted mb-0 feature-check-text">Every business is
                                    different. We design and develop according to your exact needs and goals.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lifestyle Integration Section -->
    <section class="lifestyle-section" id="lifestyle-section">
        <div class="lifestyle-banner-box">
            <img src="{{theme_asset('img/lyfestyle.png')}}" alt="Bedroom Lifestyle" class="bg-lifestyle-img">
            <div class="container-fluid main-container h-100 d-flex align-items-center">
                <div class="lifestyle-content-card">
                    <span class="lifestyle-tag">LIFESTYLE</span>
                    <h2 class="lifestyle-title section-heading">Seamless<br>Integration.</h2>
                    <p class="lifestyle-desc">Designed for your life, not just your air. AIRE Pro S1 harmonizes with
                        modern architectural spaces, becoming an invisible guardian of your wellbeing.</p>
                    <a href="#" class="lifestyle-link">More Details &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Medical-Grade Precision Filter Tech Section -->
    <section class="medical-filter-section">
        <div class="container-fluid main-container">
            <h2 class="section-main-heading section-heading">Medical-grade Precision.</h2>
            <p class="section-main-sub">HEPA H13 Filter Technology. From microscopic particles to bacteria—nothing
                escapes our signature filtration system.</p>

            <div class="filter-tech-img-box">
                <img src="{{theme_asset('img/HEPA-H13-Macro.png')}}" alt="HEPA H13 Filter">
                <div class="filter-tech-overlay-badge">
                    Advanced micro-fiber weaving that elevates atmospheric purity to unprecedented heights.
                </div>
            </div>
        </div>
    </section>

    <!-- Precision Engineering Specs Section -->
    <section class="specs-section">
        <div class="container-fluid main-container">
            <h2 class="specs-heading section-heading">Precision Engineering.</h2>
            <p class="specs-sub">The definitive standard for air purification.</p>

            <div class="row g-5 align-items-start">
                <div class="col-lg-5 specs-sticky-col">
                    <div class="specs-exploded-box">
                        <img id="specs-dynamic-image" class="img-fluid" src="https://picsum.photos/500/500?random=1"
                            alt="Exploded 3D View">
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" class="specs-more-link">More Details &rarr;</a>
                    </div>
                </div>

                <div class="col-lg-7">

                    <!-- Spec 01 -->
                    <div class="spec-group-block" data-image="https://picsum.photos/500/500?random=1">
                        <span class="spec-group-tag">01 / FILTRATION</span>
                        <h3 class="spec-group-title">Multi-Stage Synthesis</h3>
                        <table class="spec-table">
                            <tr>
                                <td class="label-td">Primary Pre-filter</td>
                                <td class="value-td">Large debris / Pets</td>
                            </tr>
                            <tr>
                                <td class="label-td">HEPA H13 Medical-grade</td>
                                <td class="value-td">99.97% of 0.3&mu;m</td>
                            </tr>
                            <tr>
                                <td class="label-td">Activated Carbon</td>
                                <td class="value-td">VOCs & Odors</td>
                            </tr>
                            <tr>
                                <td class="label-td">UV-C Sterilization</td>
                                <td class="value-td">Viral Neutralization</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Spec 02 -->
                    <div class="spec-group-block" data-image="https://picsum.photos/500/500?random=2">
                        <span class="spec-group-tag">02 / PERFORMANCE</span>
                        <h3 class="spec-group-title">Atmospheric Throughput</h3>
                        <table class="spec-table">
                            <tr>
                                <td class="label-td">CADR (Smoke)</td>
                                <td class="value-td">580 m&sup3;/h</td>
                            </tr>
                            <tr>
                                <td class="label-td">Room Coverage</td>
                                <td class="value-td">Up to 1200 sq. ft.</td>
                            </tr>
                            <tr>
                                <td class="label-td">Power Efficiency</td>
                                <td class="value-td">65W Max / 4W Sleep</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Spec 03 -->
                    <div class="spec-group-block" data-image="https://picsum.photos/500/500?random=3">
                        <span class="spec-group-tag">03 / SENSORS</span>
                        <h3 class="spec-group-title">Cognitive Awareness</h3>
                        <table class="spec-table">
                            <tr>
                                <td class="label-td">Laser Particle Sensor</td>
                                <td class="value-td">PM2.5 / PM10</td>
                            </tr>
                            <tr>
                                <td class="label-td">Electrochemical Sensor</td>
                                <td class="value-td">Formaldehyde (HCHO)</td>
                            </tr>
                            <tr>
                                <td class="label-td">Ambient Light Sensor</td>
                                <td class="value-td">Auto Night-Mode</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Spec 04 -->
                    <div class="spec-group-block" data-image="https://picsum.photos/500/500?random=4">
                        <span class="spec-group-tag">04 / CONNECTIVITY</span>
                        <h3 class="spec-group-title">Unified Ecosystem</h3>
                        <table class="spec-table">
                            <tr>
                                <td class="label-td">Wireless</td>
                                <td class="value-td">Wi-Fi 6 & Bluetooth 5.2</td>
                            </tr>
                            <tr>
                                <td class="label-td">Smart Home</td>
                                <td class="value-td">HomeKit, Alexa, Google</td>
                            </tr>
                            <tr>
                                <td class="label-td">AIRE App</td>
                                <td class="value-td">Full Remote Control</td>
                            </tr>
                        </table>
                    </div>

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
                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="related-products-card">
                            <div>
                                <h3 class="related-card-title">Bring the Future of Purity Home.</h3>
                                <p class="related-card-desc">Experience medical-grade air purification designed for the
                                    world's most demanding architectural spaces.</p>
                                <div class="related-img-holder">
                                    <img src="{{theme_asset('img/Air-Purify.png')}}" alt="AIRE Pro Premium Edition">
                                </div>
                            </div>

                            <div class="related-card-footer">
                                <div>
                                    <div class="related-tag-text">PREMIUM EDITION</div>
                                    <div class="related-price-text">$1,299</div>
                                </div>
                                <a href="checkout.html" class="btn-blue-pill">Buy Now</a>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="related-products-card">
                            <div>
                                <h3 class="related-card-title">Bring the Future of Purity Home.</h3>
                                <p class="related-card-desc">Experience medical-grade air purification designed for the
                                    world's most demanding architectural spaces.</p>
                                <div class="related-img-holder">
                                    <img src="{{theme_asset('img/Air-Purify.png')}}" alt="AIRE Pro Special Edition">
                                </div>
                            </div>

                            <div class="related-card-footer">
                                <div>
                                    <div class="related-tag-text">PREMIUM EDITION</div>
                                    <div class="related-price-text">$1,299</div>
                                </div>
                                <a href="checkout.html" class="btn-blue-pill">Buy Now</a>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <div class="related-products-card">
                            <div>
                                <h3 class="related-card-title">AIRE Pro S1 - Space Grey</h3>
                                <p class="related-card-desc">Technical Mastery. Redefined. Experience the pinnacle of
                                    atmospheric engineering in a charcoal finish.</p>
                                <div class="related-img-holder">
                                    <img src="{{theme_asset('img/Air-Purify.png')}}" alt="AIRE Pro Space Grey">
                                </div>
                            </div>

                            <div class="related-card-footer">
                                <div>
                                    <div class="related-tag-text">SPECIAL EDITION</div>
                                    <div class="related-price-text">$1,499</div>
                                </div>
                                <a href="checkout.html" class="btn-blue-pill">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Swiper Pagination -->
                <div class="swiper-pagination related-swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Bottom CTA Section -->
    <section class="bottom-cta-section text-center">
        <div class="container-fluid main-container">
            <span class="hero-model-tag mb-3 d-block bottom-cta-tag">AIRE Pro S1</span>
            <h2 class="hero-display-title mb-3 section-heading bottom-cta-title">Atmospheric Mastery.</h2>
            <p class="hero-display-desc mx-auto mb-4 bottom-cta-desc">Experience revolutionary
                synthesis technology designed to purify every single molecule of your environment.</p>

            <div class="mb-4">
                <a href="#" class="hero-action-link fw-bold">More Details -</a>
            </div>

            <div class="mb-4">
                <a href="checkout.html" class="btn btn-primary text-capitalize bottom-cta-btn">Buy
                    Now</a>
            </div>

            <div class="mt-4 mx-auto bottom-cta-img-holder">
                <img src="{{theme_asset('img/AIRE-Pro-S1-Hero.png')}}" alt="AIRE Pro S1" class="img-fluid">
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
<script src="{{ theme_asset('js/product-detail.js') }}" defer></script>
@endpush