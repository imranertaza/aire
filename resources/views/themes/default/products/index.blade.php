@extends('themes.default.layouts.master')

@section('title', 'Aire | Products')

@push('styles')
<link rel="stylesheet" href="{{ theme_asset('css/product.css') }}">
@endpush

@section('content')
<main class="container main-container">
    <h1 class="d-none">Your Main Page Title</h1>
    <div class="row g-0">
        <!-- Left Sidebar Navigation -->
        <aside class="col-lg-3 d-none d-lg-block border-right1px pe-lg-4">
            <nav class="sidebar-menu sticky-sidebar" data-lenis-prevent>
                <a href="#fresh-air" class="menu-item active">
                    <div class="icon-box"><i class="bi bi-wind"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Fresh Air Systems</h2>
                        <small class="d-block mt-1">Bring 100% fresh air with energy recovery.</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#purifiers" class="menu-item">
                    <div class="icon-box"><i class="bi bi-funnel"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Air Purifiers</h2>
                        <small class="d-block mt-1">Advanced purification for cleaner, healthier indoor air.</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#monitoring" class="menu-item">
                    <div class="icon-box"><i class="bi bi-broadcast"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Monitoring & Sensors</h2>
                        <small class="d-block mt-1">Real-time air quality monitoring and insights.</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#accessories" class="menu-item">
                    <div class="icon-box"><i class="bi bi-sliders"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Accessories & Parts</h2>
                        <small class="d-block mt-1">Filters, modules and components for optimal performance.</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#smart" class="menu-item">
                    <div class="icon-box"><i class="bi bi-gear"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Smart Controls</h2>
                        <small class="d-block mt-1">Intelligent control for smarter air management.</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>
            </nav>
        </aside>

        <!-- Center Content Column -->
        <section class="col-lg-9 col-xl-6 center-feed pb-5 px-lg-4">

            <!-- 1. Fresh Air Systems -->
            <div id="fresh-air" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Fresh Air Systems</h2>
                <p class="section-subtitle mt-3 mb-4 pb-2 text-muted fs-16 lh-base">
                    Bring 100% fresh outdoor air into any building with energy-efficient heat recovery. From
                    residential wall units to industrial-scale ventilation solutions.
                </p>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Home Fresh Air Systems">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <h3 class="card-title mb-4 fs-24">Home Fresh Air Systems</h3>
                                <ul class="list-unstyled mb-4 card-spec-list">
                                    <li>Wall Mounted Units</li>
                                    <li>Ceiling Units</li>
                                    <li>Heat Recovery Units</li>
                                    <li>Whole Home Solutions</li>
                                </ul>
                                <a href="{{ route('products.detail', 1) }}" class="card-link fs-12 mt-auto">EXPLORE SOLUTIONS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Commercial Fresh Air Systems">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <h3 class="card-title mb-4 fs-24">Commercial Fresh Air Systems</h3>
                                <ul class="list-unstyled mb-4 card-spec-list">
                                    <li>ERV / HRV Systems</li>
                                    <li>Ducted Systems</li>
                                    <li>High Airflow Units</li>
                                    <li>Energy Recovery Units</li>
                                </ul>
                                <a href="{{ route('products.landing') }}" class="card-link fs-12 mt-auto">EXPLORE SOLUTIONS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Industrial Fresh Air Systems">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <h3 class="card-title mb-4 fs-24">Industrial Fresh Air Systems</h3>
                                <ul class="list-unstyled mb-4 card-spec-list">
                                    <li>Large Capacity Units</li>
                                    <li>Heat Recovery Systems</li>
                                    <li>Custom Air Handling Solutions</li>
                                    <li>Outdoor Installation</li>
                                </ul>
                                <a href="#" class="card-link fs-12 mt-auto">EXPLORE SOLUTIONS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Air Purifiers -->
            <div id="purifiers" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Air Purifiers</h2>
                <p class="section-subtitle mt-3 mb-4 pb-2 text-muted fs-16 lh-base">
                    Advanced multi-stage filtration for cleaner, healthier indoor air — from compact home units to
                    medical-grade systems for critical healthcare environments.
                </p>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Air Purifiers for Home">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <h3 class="card-title mb-4 fs-24">Air Purifiers for Home</h3>
                                <ul class="list-unstyled mb-4 card-spec-list">
                                    <li>Tower Purifiers</li>
                                    <li>Desktop Purifiers</li>
                                    <li>Smart Purifiers</li>
                                    <li>Portable Purifiers</li>
                                </ul>
                                <a href="#" class="card-link fs-12 mt-auto">EXPLORE SOLUTIONS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Air Purifiers for Commercial">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <h3 class="card-title mb-4 fs-24">Air Purifiers for Commercial</h3>
                                <ul class="list-unstyled mb-4 card-spec-list">
                                    <li>Large Room Purifiers</li>
                                    <li>Office Purifiers</li>
                                    <li>Ceiling Mounted Purifiers</li>
                                    <li>Multi-Room Solutions</li>
                                </ul>
                                <a href="#" class="card-link fs-12 mt-auto">EXPLORE SOLUTIONS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Air Purifiers for Healthcare">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <h3 class="card-title mb-4 fs-24">Air Purifiers for Healthcare</h3>
                                <ul class="list-unstyled mb-4 card-spec-list">
                                    <li>Hospital Grade Purifiers</li>
                                    <li>HEPA Purifiers</li>
                                    <li>Surgical Room Purifiers</li>
                                    <li>Infection Control Solutions</li>
                                </ul>
                                <a href="#" class="card-link fs-12 mt-auto">EXPLORE SOLUTIONS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Monitoring & Sensors -->
            <div id="monitoring" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Monitoring &amp; Sensors
                </h2>
                <p class="section-subtitle mt-3 mb-4 pb-2 text-muted fs-16 lh-base">
                    Real-time air quality monitoring with precision sensors and intelligent dashboards that provide
                    actionable insights for healthier indoor environments.
                </p>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Indoor Air Quality Sensors">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <h3 class="card-title mb-4 fs-24">Indoor Air Quality Sensors</h3>
                                <ul class="list-unstyled mb-4 card-spec-list">
                                    <li>CO2 Monitors</li>
                                    <li>PM2.5 / PM10 Sensors</li>
                                    <li>VOC Detectors</li>
                                    <li>Temperature &amp; Humidity</li>
                                </ul>
                                <a href="#" class="card-link fs-12 mt-auto">EXPLORE SENSORS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="AIRE Dashboard Platform">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <h3 class="card-title mb-4 fs-24">AIRE Dashboard Platform</h3>
                                <ul class="list-unstyled mb-4 card-spec-list">
                                    <li>Real-time Visualisation</li>
                                    <li>Historical Trend Analysis</li>
                                    <li>Alert &amp; Notification System</li>
                                    <li>Multi-Site Management</li>
                                </ul>
                                <a href="#" class="card-link fs-12 mt-auto">EXPLORE PLATFORM <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Accessories & Parts -->
            <div id="accessories" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Accessories &amp; Parts
                </h2>
                <p class="section-subtitle mt-3 mb-4 pb-2 text-muted fs-16 lh-base">
                    Genuine AIRE filters, replacement modules, and precision components engineered for optimal
                    system performance and longevity.
                </p>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Replacement Filters">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <h3 class="card-title mb-4 fs-24">Replacement Filters</h3>
                                <ul class="list-unstyled mb-4 card-spec-list">
                                    <li>HEPA H13 Filters</li>
                                    <li>Activated Carbon Filters</li>
                                    <li>Pre-Filter Panels</li>
                                    <li>Combined Filter Kits</li>
                                </ul>
                                <a href="#" class="card-link fs-12 mt-auto">SHOP FILTERS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Spare Parts & Modules">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <h3 class="card-title mb-4 fs-24">Spare Parts &amp; Modules</h3>
                                <ul class="list-unstyled mb-4 card-spec-list">
                                    <li>Fan &amp; Motor Assemblies</li>
                                    <li>UV-C Lamp Replacements</li>
                                    <li>Ionization Modules</li>
                                    <li>Control Boards</li>
                                </ul>
                                <a href="#" class="card-link fs-12 mt-auto">SHOP PARTS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Smart Controls -->
            <div id="smart" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Smart Controls</h2>
                <p class="section-subtitle mt-3 mb-4 pb-2 text-muted fs-16 lh-base">
                    Intelligent automation and IoT-connected controls that let you manage air quality across every
                    space from a single interface.
                </p>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="AIRE Smart App">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <h3 class="card-title mb-4 fs-24">AIRE Smart App</h3>
                                <ul class="list-unstyled mb-4 card-spec-list">
                                    <li>iOS &amp; Android Control</li>
                                    <li>Remote Scheduling</li>
                                    <li>Air Quality Alerts</li>
                                    <li>Energy Usage Reports</li>
                                </ul>
                                <a href="#" class="card-link fs-12 mt-auto">LEARN MORE <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Building Automation Integration">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <h3 class="card-title mb-4 fs-24">Building Automation Integration</h3>
                                <ul class="list-unstyled mb-4 card-spec-list">
                                    <li>BACnet / Modbus Support</li>
                                    <li>KNX Integration</li>
                                    <li>API &amp; Webhook Access</li>
                                    <li>Custom Automation Rules</li>
                                </ul>
                                <a href="#" class="card-link fs-12 mt-auto">LEARN MORE <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Right Sidebar Feature -->
        <aside class="col-lg-12 col-xl-3 d-none d-xl-block border-left1px">
            <!-- Swiper Slider Implementation -->
            <div class="featured-card sticky-sidebar bg-white border border-light-subtle shadow-sm rounded-4 ms-3"
                data-lenis-prevent>
                <div class="swiper featured-swiper">
                    <div class="swiper-wrapper">
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="featured-img position-relative">
                                <span
                                    class="badge bg-dark position-absolute top-0 start-0 m-3 rounded-0 px-3 py-2 text-uppercase text-white border-0 featured-badge">Featured
                                    Solution</span>
                                <img src="{{ theme_asset('img/featured/1.png') }}" class="img-fluid w-100"
                                    alt="Woman relaxing at home">
                            </div>
                            <div class="featured-content pb-5">
                                <h3 class="mb-2">The Future of Pure Living</h3>
                                <p class="text-muted mb-2 lh-base">Experience the pinnacle of air technology
                                    seamlessly integrated into your architectural vision. The AIRE Pro series</p>
                                <button class="btn btn-primary w-100 fw-bold shadow-sm featured-btn">VIEW
                                    PRODUCTS</button>
                            </div>
                        </div>
                        <!-- Slide 2 -->
                        <div class="swiper-slide">
                            <div class="featured-img position-relative">
                                <span
                                    class="badge bg-dark position-absolute top-0 start-0 m-3 rounded-0 px-3 py-2 text-uppercase text-white border-0 featured-badge">New
                                    Arrival</span>
                                <img src="{{ theme_asset('img/featured/2.png') }}" class="img-fluid w-100" alt="Modern interior">
                            </div>
                            <div class="featured-content pb-5">
                                <h3 class="mb-2">Smart Climate Control</h3>
                                <p class="text-muted mb-2 lh-base">Control your entire home's air quality directly
                                    from your smartphone with our new AIRE IoT integration. Pure air, instantly.</p>
                                <button class="btn btn-primary w-100 fw-bold shadow-sm featured-btn">LEARN
                                    MORE</button>
                            </div>
                        </div>
                        <!-- Slide 3 -->
                        <div class="swiper-slide">
                            <div class="featured-img position-relative">
                                <span
                                    class="badge bg-dark position-absolute top-0 start-0 m-3 rounded-0 px-3 py-2 text-uppercase text-white border-0 featured-badge">Commercial</span>
                                <img src="{{ theme_asset('img/featured/3.png') }}" class="img-fluid w-100" alt="Office lobby">
                            </div>
                            <div class="featured-content pb-5">
                                <h3 class="mb-2">Enterprise Grade Purity</h3>
                                <p class="text-muted mb-2 lh-base">Deploy industrial-grade filtration disguised in
                                    beautiful architectural units designed specifically for modern corporate
                                    lobbies.</p>
                                <button class="btn btn-primary w-100 fw-bold shadow-sm featured-btn">GET
                                    A QUOTE</button>
                            </div>
                        </div>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination position-absolute bottom-2"></div>
                </div>
            </div>
        </aside>

    </div>
</main>
@endsection