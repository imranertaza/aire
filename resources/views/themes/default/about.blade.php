@extends('themes.default.layouts.master')

@section('title', 'Aire | About Us')
@section('meta_description', 'Learn about AIRE Industries — our mission, team, and commitment to delivering healthier indoor air environments through cutting-edge technology.')

@push('styles')
<link href="{{ theme_asset('css/about.css') }}" rel="stylesheet">
@endpush

@section('content')
<main class="container main-container">
    <h1 class="d-none">About AIRE Industries</h1>
    <div class="row g-0">

        <!-- Left Sidebar Navigation -->
        <aside class="col-lg-3 d-none d-lg-block border-right1px pe-lg-4">
            <nav class="sidebar-menu sticky-sidebar" data-lenis-prevent>
                <a href="#story" class="menu-item active">
                    <div class="icon-box"><i class="bi bi-house"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Our Story</h2>
                        <small class="d-block mt-1">ESTABLISHED 2005</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>
                <a href="#mission" class="menu-item">
                    <div class="icon-box"><i class="bi bi-bullseye"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Mission &amp; Vision</h2>
                        <small class="d-block mt-1">OUR PURPOSE AND VALUES</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>
                <a href="#leadership" class="menu-item">
                    <div class="icon-box"><i class="bi bi-people"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Leadership</h2>
                        <small class="d-block mt-1">THE TEAM DRIVING INNOVATION</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>
                <a href="#innovation" class="menu-item">
                    <div class="icon-box"><i class="bi bi-lightbulb"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Innovation &amp; Patents</h2>
                        <small class="d-block mt-1">PIONEERING TECHNOLOGIES</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>
                <a href="#quality" class="menu-item">
                    <div class="icon-box"><i class="bi bi-patch-check"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Quality &amp; Certifications</h2>
                        <small class="d-block mt-1">GLOBALLY RECOGNIZED STANDARDS</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>
                <a href="#careers" class="menu-item">
                    <div class="icon-box"><i class="bi bi-briefcase"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Careers</h2>
                        <small class="d-block mt-1">JOIN OUR GLOBAL TEAM</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>
                <a href="#news" class="menu-item">
                    <div class="icon-box"><i class="bi bi-newspaper"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">News &amp; Media</h2>
                        <small class="d-block mt-1">LATEST UPDATES AND PRESS</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>
                <a href="#global" class="menu-item">
                    <div class="icon-box"><i class="bi bi-globe"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Global Presence</h2>
                        <small class="d-block mt-1">SERVING CUSTOMERS WORLDWIDE</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>
            </nav>
        </aside>

        <!-- Center Content Column -->
        <div class="col-lg-9 col-xl-6 center-feed px-lg-4 pb-5">

            <!-- Our Story -->
            <div id="story" class="content-section mb-5 pb-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="section-heading-bar"></div>
                    <h2 class="section-title title-2 fw-bold mb-0 about-section-title">Our Story</h2>
                </div>

                <p class="mb-4 about-body-text">
                    Founded in 2005, AIRE Industries began with a simple but profound mission: to master the science
                    of the air we breathe. What started as a specialized engineering lab focused on high-efficiency
                    particulate filtration has evolved into a global powerhouse in atmospheric technology.
                </p>
                <p class="mb-5 about-body-text">
                    Today, our systems are integrated into the world's most advanced architectural projects, from
                    hyper-tall residential towers to critical medical facilities. We don't just filter air; we
                    engineer purity, ensuring that every indoor environment promotes peak human performance and
                    long-term health.
                </p>

                <!-- Stats Grid -->
                <div class="row g-3 mb-5 pb-5">
                    <div class="col-6 col-md-3">
                        <div class="text-center rounded-4 p-4 d-flex flex-column justify-content-center about-stat-card">
                            <h3 class="fw-bold mb-1 about-stat-num">2005</h3>
                            <p class="mb-0 text-uppercase about-meta-label">ESTABLISHED</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center rounded-4 p-4 d-flex flex-column justify-content-center about-stat-card">
                            <h3 class="fw-bold mb-1 about-stat-num">100+</h3>
                            <p class="mb-0 text-uppercase about-meta-label">COUNTRIES SERVED</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center rounded-4 p-4 d-flex flex-column justify-content-center about-stat-card">
                            <h3 class="fw-bold mb-1 about-stat-num">200+</h3>
                            <p class="mb-0 text-uppercase about-meta-label">PATENTS GRANTED</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center rounded-4 p-4 d-flex flex-column justify-content-center about-stat-card">
                            <h3 class="fw-bold mb-1 about-stat-num">1M+</h3>
                            <p class="mb-0 text-uppercase about-meta-label">HEALTHY SPACES</p>
                        </div>
                    </div>
                </div>

                <!-- Milestones -->
                <h2 class="text-center text-uppercase fw-bold mb-5 pb-2 about-milestones-heading">OUR MILESTONES</h2>

                <div class="row g-5 mb-5 text-center">
                    <div class="col-md-6">
                        <div
                            class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 border milestone-icon">
                            <i class="bi bi-rocket-takeoff fs-4 text-dark"></i>
                        </div>
                        <h2 class="fw-bold mb-2 about-dark">2005</h2>
                        <p class="text-uppercase mb-3 about-meta-label" style="color: #94a3b8;">FOUNDATION</p>
                        <p class="text-muted fs-14 px-4">AIRE Industries is founded in a state-of-the-art lab.</p>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 border milestone-icon">
                            <i class="bi bi-bar-chart-line fs-4 text-dark"></i>
                        </div>
                        <h2 class="fw-bold mb-2 about-dark">2008</h2>
                        <p class="text-uppercase mb-3 about-meta-label" style="color: #94a3b8;">INNOVATION</p>
                        <p class="text-muted fs-14 px-4">Launches first commercial IAQ monitoring suite.</p>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 border milestone-icon">
                            <i class="bi bi-globe fs-4 text-dark"></i>
                        </div>
                        <h2 class="fw-bold mb-2 about-dark">2013</h2>
                        <p class="text-uppercase mb-3 about-meta-label" style="color: #94a3b8;">EXPANSION</p>
                        <p class="text-muted fs-14 px-4">Expands to European and Asian markets.</p>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 border milestone-icon">
                            <i class="bi bi-patch-check fs-4 text-dark"></i>
                        </div>
                        <h2 class="fw-bold mb-2 about-dark">2015</h2>
                        <p class="text-uppercase mb-3 about-meta-label" style="color: #94a3b8;">MILESTONE</p>
                        <p class="text-muted fs-14 px-4">Grants 100th patent for plasma ionization.</p>
                    </div>
                </div>

                <div class="text-center mb-5 pb-5 mt-2">
                    <div
                        class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 shadow milestone-icon--dark">
                        <i class="bi bi-stars fs-4 text-white"></i>
                    </div>
                    <h2 class="fw-bold mb-2 about-dark">Today</h2>
                    <p class="text-uppercase mb-3 about-meta-label" style="color: #94a3b8;">LEADERSHIP</p>
                    <p class="text-muted fs-14 px-4">Leading the global standard in<br>pure atmosphere.</p>
                </div>

                <!-- Call to Action -->
                <div class="rounded-4 p-5 text-center mt-4 about-cta-section">
                    <h3 class="fw-bold mb-3 about-dark">Want to learn more about Aire?</h3>
                    <p class="mb-4 about-cta-text">
                        Discover how our engineering solutions can transform your environment and elevate the
                        standard of living.
                    </p>
                    <a href="{{ route('contact') }}"
                        class="text-dark fw-bold text-decoration-none d-inline-block border-bottom border-dark pb-1 mt-2 about-cta-link">GET
                        IN TOUCH <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>

        </div>

        <!-- Right Sidebar Feature -->
        <aside class="col-lg-12 col-xl-3 border-left1px d-none d-xl-block ps-xl-4">
            @php
                $sidebarAds = $aboutAds ?? \App\Models\Slider::where('enabled', 1)
                    ->where(function ($q) {
                        $q->where('key', 'about_us')
                          ->orWhere('key', 'like', '%about_us%');
                    })
                    ->orderBy('order', 'asc')
                    ->get();
            @endphp
            @if ($sidebarAds->count() > 0)
                <div class="featured-card sticky-sidebar bg-white border border-light-subtle shadow-sm rounded-4 ms-3"
                    data-lenis-prevent>
                    <div class="swiper featured-swiper">
                        <div class="swiper-wrapper">
                            @forelse ($sidebarAds as $index => $ad)
                                <div class="swiper-slide">
                                    <div class="featured-img position-relative">
                                        <span
                                            class="badge bg-dark position-absolute top-0 start-0 m-3 rounded-0 px-3 py-2 text-uppercase text-white border-0 featured-badge">
                                            {{ $ad->subtitle ?: ($ad->badge ?: ($index === 0 ? 'Featured Solution' : ($index === 1 ? 'New Arrival' : 'Commercial'))) }}
                                        </span>
                                        <img src="{{ !empty($ad->image) ? getImageUrl($ad->image) : theme_asset('img/featured/' . (($index % 3) + 1) . '.png') }}"
                                            class="img-fluid w-100" alt="{{ $ad->title ?? 'Featured Ad' }}">
                                    </div>
                                    <div class="featured-content pb-5">
                                        <h3 class="mb-2">{{ $ad->title }}</h3>
                                        <p class="text-muted mb-2 lh-base">{{ $ad->description }}</p>
                                        <a href="{{ $ad->link ?: route('products.index') }}"
                                            class="btn btn-primary w-100 fw-bold shadow-sm featured-btn text-decoration-none d-inline-block text-center">
                                            {{ $ad->button_text ?? ($index === 0 ? 'VIEW PRODUCTS' : ($index === 1 ? 'LEARN MORE' : 'FIND MORE PRODUCTS')) }}
                                        </a>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination position-absolute bottom-2"></div>
                    </div>
                </div>
            @endif
        </aside>

    </div>
</main>
@endsection

@push('scripts')
<script src="{{ theme_asset('js/about.js') }}" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof Swiper !== 'undefined' && document.querySelector('.featured-swiper')) {
            new Swiper('.featured-swiper', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.featured-swiper .swiper-pagination',
                    clickable: true,
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                }
            });
        }
    });
</script>
@endpush