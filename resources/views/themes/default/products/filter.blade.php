@extends('themes.default.layouts.master')

@section('body_class', 'product-filter-page')

@push('styles')
    <!-- Google Fonts Playfair Display -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <!-- BEM Product Filter Page CSS -->
    <link href="{{ theme_asset('css/product-filter.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php
        $isAllProducts = request()->has('all');
    @endphp
    <!-- Mobile Offcanvas Menu (Filter Drawer) -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileFilterDrawer" role="dialog"
        aria-labelledby="mobileFilterDrawerLabel" aria-modal="true">
        <div class="offcanvas-header border-bottom">
            <a href="{{ route('home') }}" class="brand-logo d-flex align-items-center text-decoration-none">
                <img src="{{ theme_asset('img/logo.png') }}" alt="AIRE logo" class="logo-header-img">
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" data-lenis-prevent>
            <p class="text-uppercase fw-bold text-muted mb-3 fs-12">Main Menu</p>
            <nav class="d-flex flex-column gap-2 mb-4 py-2">
                <a href="{{ route('solutions') }}" class="text-dark text-decoration-none fw-medium py-1">Solutions</a>
                <a href="{{ route('categories') }}" class="text-dark text-decoration-none fw-medium py-1">Products</a>
                <a href="{{ route('home') }}" class="text-primary text-decoration-none fw-bold py-1">Industries</a>
                <a href="{{ route('compare') }}" class="text-dark text-decoration-none fw-medium py-1">Compare</a>
                <a href="{{ route('products.filter') }}" class="text-dark text-decoration-none fw-medium py-1">Shop</a>
                <a href="{{ route('about') }}" class="text-dark text-decoration-none fw-medium py-1">About</a>
                <a href="{{ route('cart') }}" class="text-dark text-decoration-none fw-medium py-1">Cart</a>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('signup') }}" class="btn btn-outline-primary w-50 rounded-pill py-2 fw-semibold">Sign
                        Up</a>
                    <a href="{{ route('signin') }}" class="btn btn-primary w-50 rounded-pill py-2 fw-semibold">Login</a>
                </div>
            </nav>

            <hr class="my-4">

            <p class="text-uppercase fw-bold text-muted mb-3 fs-12">Filter Specifications</p>
            <div class="filter-sidebar filter-sidebar--mobile">
                <div class="filter-sidebar__header">
                    <h2 class="filter-sidebar__title">FILTERS</h2>
                    <button type="button" class="filter-sidebar__reset-btn">RESET ALL</button>
                </div>

                <a href="{{ route('products.filter') }}"
                    class="filter-sidebar__subtitle filter-sidebar__subtitle--link">All
                    Products</a>

                <!-- 1. INDUSTRIES -->
                <div class="filter-group collapsed">
                    <div class="filter-group__header">
                        <h3 class="filter-group__title">1 INDUSTRIES</h3>
                        <i class="bi bi-chevron-down filter-group__icon"></i>
                    </div>
                    <div class="filter-group__content">
                        <label class="filter-option">
                            <input type="radio" name="occupancy" value="residential" class="filter-option__input" checked>
                            <span class="filter-option__text">Residential</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="occupancy" value="commercial" class="filter-option__input">
                            <span class="filter-option__text">Commercial</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="occupancy" value="healthcare" class="filter-option__input">
                            <span class="filter-option__text">Healthcare</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="occupancy" value="education" class="filter-option__input">
                            <span class="filter-option__text">Education</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="occupancy" value="transportation" class="filter-option__input">
                            <span class="filter-option__text">Transportation</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="occupancy" value="industrial" class="filter-option__input">
                            <span class="filter-option__text">Industrial</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="occupancy" value="infrastructure" class="filter-option__input">
                            <span class="filter-option__text">Infrastructure</span>
                        </label>
                    </div>
                </div>

                <!-- 2. SPACE TYPE -->
                <div class="filter-group collapsed">
                    <div class="filter-group__header">
                        <h3 class="filter-group__title">2 SPACE TYPE</h3>
                        <i class="bi bi-chevron-down filter-group__icon"></i>
                    </div>
                    <div class="filter-group__content">
                        <label class="filter-option">
                            <input type="checkbox" value="living_room" class="filter-option__input" checked>
                            <span class="filter-option__text">Living Room</span>
                        </label>
                        <label class="filter-option">
                            <input type="checkbox" value="bedroom" class="filter-option__input" checked>
                            <span class="filter-option__text">Bedroom</span>
                        </label>
                        <label class="filter-option">
                            <input type="checkbox" value="kitchen" class="filter-option__input" checked>
                            <span class="filter-option__text">Kitchen</span>
                        </label>
                        <label class="filter-option">
                            <input type="checkbox" value="office" class="filter-option__input">
                            <span class="filter-option__text">Office</span>
                        </label>
                        <label class="filter-option">
                            <input type="checkbox" value="lab" class="filter-option__input">
                            <span class="filter-option__text">Laboratory</span>
                        </label>
                        <label class="filter-option">
                            <input type="checkbox" value="classroom" class="filter-option__input">
                            <span class="filter-option__text">Classroom</span>
                        </label>
                    </div>
                </div>

                <!-- 3. COVERAGE AREA -->
                <div class="filter-group collapsed">
                    <div class="filter-group__header">
                        <h3 class="filter-group__title">3 COVERAGE AREA</h3>
                        <i class="bi bi-chevron-down filter-group__icon"></i>
                    </div>
                    <div class="filter-group__content">
                        <label class="filter-option">
                            <input type="radio" name="coverage_mobile" value="small" class="filter-option__input"
                                checked>
                            <span class="filter-option__text">Small (&lt; 30 m²)</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="coverage_mobile" value="medium" class="filter-option__input">
                            <span class="filter-option__text">Medium (30-60 m²)</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="coverage_mobile" value="large" class="filter-option__input">
                            <span class="filter-option__text">Large (60-120 m²)</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="coverage_mobile" value="commercial"
                                class="filter-option__input">
                            <span class="filter-option__text">Commercial (&gt; 120 m²)</span>
                        </label>
                    </div>
                </div>

                <!-- 4. AIR FLOW RATE -->
                <div class="filter-group collapsed">
                    <div class="filter-group__header">
                        <h3 class="filter-group__title">4 AIR FLOW RATE</h3>
                        <i class="bi bi-chevron-down filter-group__icon"></i>
                    </div>
                    <div class="filter-group__content">
                        <label class="filter-option">
                            <input type="radio" name="airflow_mobile" value="low" class="filter-option__input"
                                checked>
                            <span class="filter-option__text">Low (&lt; 200 m³/h)</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="airflow_mobile" value="mid" class="filter-option__input">
                            <span class="filter-option__text">Medium (200-500 m³/h)</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="airflow_mobile" value="high" class="filter-option__input">
                            <span class="filter-option__text">High (500-1000 m³/h)</span>
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="airflow_mobile" value="ultra" class="filter-option__input">
                            <span class="filter-option__text">Ultra (&gt; 1000 m³/h)</span>
                        </label>
                    </div>
                </div>

                <!-- 5. SPECIFIC NEEDS -->
                <div class="filter-group collapsed">
                    <div class="filter-group__header">
                        <h3 class="filter-group__title">5 SPECIFIC NEEDS</h3>
                        <i class="bi bi-chevron-down filter-group__icon"></i>
                    </div>
                    <div class="filter-group__content">
                        <label class="filter-option">
                            <input type="checkbox" value="allergies" class="filter-option__input" checked>
                            <span class="filter-option__text">Allergies</span>
                        </label>
                        <label class="filter-option">
                            <input type="checkbox" value="asthma" class="filter-option__input" checked>
                            <span class="filter-option__text">Asthma</span>
                        </label>
                        <label class="filter-option">
                            <input type="checkbox" value="family" class="filter-option__input" checked>
                            <span class="filter-option__text">Family Health</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <!-- Main Container: 3 Column Layout like index.html -->
    <main class="container main-container product-filter-page__main">


        <div class="row g-0">

            <!-- Left Column: Filters Sidebar (col-lg-3) -->
            <aside class="col-12 col-lg-3 border-right1px pe-lg-4">

                <!-- Breadcrumb Navigation (Outside of scrollable filter sidebar) -->
                <nav class="breadcrumb-nav mb-3 py-3" aria-label="breadcrumb">
                    <a href="products.html" class="breadcrumb-nav__link">Products</a>
                    <span class="breadcrumb-nav__separator">&gt;</span>
                    <span class="breadcrumb-nav__current">Air Purify</span>
                </nav>
                <div class="filter-sidebar sticky-sidebar left" data-lenis-prevent>
                    <!-- Filter Header -->
                    <div class="filter-sidebar__header">
                        <h2 class="filter-sidebar__title">FILTERS</h2>
                        <a href="{{ route('products.filter') }}"
                            class="filter-sidebar__reset-btn text-decoration-none">RESET ALL</a>
                    </div>

                    <a href="{{ route('products.filter') . '?all=1' }}"
                        class="filter-sidebar__subtitle filter-sidebar__subtitle--link">All
                        Products</a>

                    <!-- 1. INDUSTRIES -->
                    <div class="filter-group collapsed">
                        <div class="filter-group__header">
                            <h3 class="filter-group__title">1 INDUSTRIES</h3>
                            <i class="bi bi-chevron-down filter-group__icon"></i>
                        </div>
                        <div class="filter-group__content">
                            <label class="filter-option">
                                <input type="radio" name="industry" value="residential" class="filter-option__input"
                                    checked>
                                <span class="filter-option__text">Residential</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="industry" value="commercial" class="filter-option__input">
                                <span class="filter-option__text">Commercial</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="industry" value="healthcare" class="filter-option__input">
                                <span class="filter-option__text">Healthcare</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="industry" value="education" class="filter-option__input">
                                <span class="filter-option__text">Education</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="industry" value="transportation"
                                    class="filter-option__input">
                                <span class="filter-option__text">Transportation</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="industry" value="industrial" class="filter-option__input">
                                <span class="filter-option__text">Industrial</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="industry" value="infrastructure"
                                    class="filter-option__input">
                                <span class="filter-option__text">Infrastructure</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="industry" value="hvac" class="filter-option__input">
                                <span class="filter-option__text">HVAC</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="industry" value="monitoring" class="filter-option__input">
                                <span class="filter-option__text">Monitoring</span>
                            </label>
                        </div>
                    </div>

                    <!-- 2. BUILDING TYPE -->
                    <div class="filter-group collapsed">
                        <div class="filter-group__header">
                            <h3 class="filter-group__title">2 BUILDING TYPE</h3>
                            <i class="bi bi-chevron-down filter-group__icon"></i>
                        </div>
                        <div class="filter-group__content">
                            <label class="filter-option">
                                <input type="radio" name="building_type" value="apartment"
                                    class="filter-option__input">
                                <span class="filter-option__text">Apartment</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="building_type" value="house" class="filter-option__input">
                                <span class="filter-option__text">House</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="building_type" value="villa" class="filter-option__input">
                                <span class="filter-option__text">Villa</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="building_type" value="office" class="filter-option__input">
                                <span class="filter-option__text">Office</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="building_type" value="shopping_mall"
                                    class="filter-option__input">
                                <span class="filter-option__text">Shopping Mall</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="building_type" value="hospital"
                                    class="filter-option__input">
                                <span class="filter-option__text">Hospital</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="building_type" value="school" class="filter-option__input">
                                <span class="filter-option__text">School</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="building_type" value="car" class="filter-option__input">
                                <span class="filter-option__text">Car</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="building_type" value="factory" class="filter-option__input">
                                <span class="filter-option__text">Factory</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="building_type" value="warehouse"
                                    class="filter-option__input">
                                <span class="filter-option__text">Warehouse</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="building_type" value="airport" class="filter-option__input">
                                <span class="filter-option__text">Airport</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="building_type" value="public_building"
                                    class="filter-option__input">
                                <span class="filter-option__text">Public Building</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="building_type" value="any" class="filter-option__input"
                                    checked>
                                <span class="filter-option__text">Any</span>
                            </label>
                        </div>
                    </div>

                    <!-- 3. ROOM / AREA TYPE -->
                    <div class="filter-group collapsed">
                        <div class="filter-group__header">
                            <h3 class="filter-group__title">3 ROOM / AREA TYPE</h3>
                            <i class="bi bi-chevron-down filter-group__icon"></i>
                        </div>
                        <div class="filter-group__content">
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="bedroom" class="filter-option__input">
                                <span class="filter-option__text">Bedroom</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="whole_apartment"
                                    class="filter-option__input">
                                <span class="filter-option__text">Whole Apartment</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="whole_house" class="filter-option__input">
                                <span class="filter-option__text">Whole House</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="villa" class="filter-option__input">
                                <span class="filter-option__text">Villa</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="meeting_room"
                                    class="filter-option__input">
                                <span class="filter-option__text">Meeting Room</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="office_floor"
                                    class="filter-option__input">
                                <span class="filter-option__text">Office Floor</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="public_area" class="filter-option__input">
                                <span class="filter-option__text">Public Area</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="ward" class="filter-option__input">
                                <span class="filter-option__text">Ward</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="classroom" class="filter-option__input">
                                <span class="filter-option__text">Classroom</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="vehicle" class="filter-option__input">
                                <span class="filter-option__text">Vehicle</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="production_area"
                                    class="filter-option__input">
                                <span class="filter-option__text">Production Area</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="warehouse" class="filter-option__input">
                                <span class="filter-option__text">Warehouse</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="terminal" class="filter-option__input">
                                <span class="filter-option__text">Terminal</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="lobby" class="filter-option__input">
                                <span class="filter-option__text">Lobby</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="room_type" value="any" class="filter-option__input"
                                    checked>
                                <span class="filter-option__text">Any</span>
                            </label>
                        </div>
                    </div>

                    <!-- 4. AREA RANGE (M²) -->
                    <div class="filter-group collapsed">
                        <div class="filter-group__header">
                            <h3 class="filter-group__title">4 AREA RANGE (M²)</h3>
                            <i class="bi bi-chevron-down filter-group__icon"></i>
                        </div>
                        <div class="filter-group__content">
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="10-20" class="filter-option__input">
                                <span class="filter-option__text">10-20</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="20-50" class="filter-option__input">
                                <span class="filter-option__text">20-50</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="50-80" class="filter-option__input">
                                <span class="filter-option__text">50-80</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="80-120" class="filter-option__input">
                                <span class="filter-option__text">80-120</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="120-200" class="filter-option__input">
                                <span class="filter-option__text">120-200</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="200-300" class="filter-option__input">
                                <span class="filter-option__text">200-300</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="300-500" class="filter-option__input">
                                <span class="filter-option__text">300-500</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="500-1000" class="filter-option__input">
                                <span class="filter-option__text">500-1000</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="1000-2000" class="filter-option__input">
                                <span class="filter-option__text">1000-2000</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="2000-4000" class="filter-option__input">
                                <span class="filter-option__text">2000-4000</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="4000-10000" class="filter-option__input">
                                <span class="filter-option__text">4000-10000</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="10000-20000"
                                    class="filter-option__input">
                                <span class="filter-option__text">10000-20000</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="20000+" class="filter-option__input">
                                <span class="filter-option__text">20000+</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="area_range" value="any" class="filter-option__input"
                                    checked>
                                <span class="filter-option__text">Any</span>
                            </label>
                        </div>
                    </div>

                    <!-- 5. OCCUPANCY -->
                    <div class="filter-group collapsed">
                        <div class="filter-group__header">
                            <h3 class="filter-group__title">5 OCCUPANCY</h3>
                            <i class="bi bi-chevron-down filter-group__icon"></i>
                        </div>
                        <div class="filter-group__content">
                            <label class="filter-option">
                                <input type="radio" name="occupancy" value="1" class="filter-option__input">
                                <span class="filter-option__text">1</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="occupancy" value="1-2" class="filter-option__input">
                                <span class="filter-option__text">1-2</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="occupancy" value="3-5" class="filter-option__input">
                                <span class="filter-option__text">3-5</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="occupancy" value="5-10" class="filter-option__input">
                                <span class="filter-option__text">5-10</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="occupancy" value="10-50" class="filter-option__input">
                                <span class="filter-option__text">10-50</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="occupancy" value="50-100" class="filter-option__input">
                                <span class="filter-option__text">50-100</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="occupancy" value="100+" class="filter-option__input">
                                <span class="filter-option__text">100+</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="occupancy" value="1000+" class="filter-option__input">
                                <span class="filter-option__text">1000+</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="occupancy" value="any" class="filter-option__input"
                                    checked>
                                <span class="filter-option__text">Any</span>
                            </label>
                        </div>
                    </div>

                    <!-- 6. HEALTH CONCERN -->
                    <div class="filter-group collapsed">
                        <div class="filter-group__header">
                            <h3 class="filter-group__title">6 HEALTH CONCERN</h3>
                            <i class="bi bi-chevron-down filter-group__icon"></i>
                        </div>
                        <div class="filter-group__content">
                            <label class="filter-option">
                                <input type="checkbox" value="allergies" class="filter-option__input" checked>
                                <span class="filter-option__text">Allergies</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="asthma" class="filter-option__input" checked>
                                <span class="filter-option__text">Asthma</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="family_health" class="filter-option__input" checked>
                                <span class="filter-option__text">Family Health</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="luxury_wellness" class="filter-option__input">
                                <span class="filter-option__text">Luxury Wellness</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="productivity" class="filter-option__input">
                                <span class="filter-option__text">Productivity</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="employee_wellness" class="filter-option__input">
                                <span class="filter-option__text">Employee Wellness</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="public_health" class="filter-option__input">
                                <span class="filter-option__text">Public Health</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="virus_protection" class="filter-option__input">
                                <span class="filter-option__text">Virus Protection</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="respiratory_safety" class="filter-option__input">
                                <span class="filter-option__text">Respiratory Safety</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="childrens_health" class="filter-option__input">
                                <span class="filter-option__text">Children's Health</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="driver_health" class="filter-option__input">
                                <span class="filter-option__text">Driver Health</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="worker_safety" class="filter-option__input">
                                <span class="filter-option__text">Worker Safety</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="compliance" class="filter-option__input">
                                <span class="filter-option__text">Compliance</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="mega_facility" class="filter-option__input">
                                <span class="filter-option__text">Mega Facility</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="general_iaq" class="filter-option__input">
                                <span class="filter-option__text">General IAQ</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="iaq_awareness" class="filter-option__input">
                                <span class="filter-option__text">IAQ Awareness</span>
                            </label>
                        </div>
                    </div>

                    <!-- 7. PROBLEM -->
                    <div class="filter-group collapsed">
                        <div class="filter-group__header">
                            <h3 class="filter-group__title">7 PROBLEM</h3>
                            <i class="bi bi-chevron-down filter-group__icon"></i>
                        </div>
                        <div class="filter-group__content">
                            <label class="filter-option">
                                <input type="checkbox" value="pm25" class="filter-option__input" checked>
                                <span class="filter-option__text">PM2.5</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="high_co2" class="filter-option__input" checked>
                                <span class="filter-option__text">High CO2</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="iaq" class="filter-option__input" checked>
                                <span class="filter-option__text">IAQ</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="mold" class="filter-option__input">
                                <span class="filter-option__text">Mold, Poor Ventilation</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="pm25_co2" class="filter-option__input">
                                <span class="filter-option__text">PM2.5 + CO2</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="poor_air" class="filter-option__input">
                                <span class="filter-option__text">Poor Air Quality</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="smoke_odor" class="filter-option__input">
                                <span class="filter-option__text">Smoke & Odor</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="virus_bacteria" class="filter-option__input">
                                <span class="filter-option__text">Virus & Bacteria</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="airborne" class="filter-option__input">
                                <span class="filter-option__text">Airborne Particles</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="dust_vocs" class="filter-option__input">
                                <span class="filter-option__text">Dust & VOCs</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="large_building_vent" class="filter-option__input">
                                <span class="filter-option__text">Large Building Ventilation</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="large_space_iaq" class="filter-option__input">
                                <span class="filter-option__text">Large Space Air Quality</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="hvac_treatment" class="filter-option__input">
                                <span class="filter-option__text">HVAC Treatment</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="pm25_monitoring" class="filter-option__input">
                                <span class="filter-option__text">PM2.5 Monitoring</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="any" class="filter-option__input">
                                <span class="filter-option__text">Any</span>
                            </label>
                        </div>
                    </div>

                    <!-- 8. SOLUTION NEEDED -->
                    <div class="filter-group collapsed">
                        <div class="filter-group__header">
                            <h3 class="filter-group__title">8 SOLUTION NEEDED</h3>
                            <i class="bi bi-chevron-down filter-group__icon"></i>
                        </div>
                        <div class="filter-group__content">
                            <label class="filter-option">
                                <input type="checkbox" value="air_purification" class="filter-option__input" checked>
                                <span class="filter-option__text">Air Purification</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="fresh_air" class="filter-option__input" checked>
                                <span class="filter-option__text">Fresh Air + Heat Recovery</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="ventilation_monitoring" class="filter-option__input"
                                    checked>
                                <span class="filter-option__text">Ventilation + Monitoring</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="whole_house" class="filter-option__input">
                                <span class="filter-option__text">Whole House Ventilation</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="air_quality_mgmt" class="filter-option__input">
                                <span class="filter-option__text">Air Quality Management</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="personal_protection" class="filter-option__input">
                                <span class="filter-option__text">Personal Protection</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="vehicle_air" class="filter-option__input">
                                <span class="filter-option__text">Vehicle Air Quality</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="co2_monitoring" class="filter-option__input">
                                <span class="filter-option__text">CO2 Monitoring</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="central_ventilation" class="filter-option__input">
                                <span class="filter-option__text">Central Ventilation</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="purification_hvac" class="filter-option__input">
                                <span class="filter-option__text">Purification + HVAC</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="hvac_treatment" class="filter-option__input">
                                <span class="filter-option__text">HVAC Treatment</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="monitoring" class="filter-option__input">
                                <span class="filter-option__text">Monitoring</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox" value="any" class="filter-option__input">
                                <span class="filter-option__text">Any</span>
                            </label>
                        </div>
                    </div>

                    <!-- 9. BUDGET RANGE -->
                    <div class="filter-group collapsed">
                        <div class="filter-group__header">
                            <h3 class="filter-group__title">9 BUDGET RANGE</h3>
                            <i class="bi bi-chevron-down filter-group__icon"></i>
                        </div>
                        <div class="filter-group__content">
                            <label class="filter-option">
                                <input type="radio" name="budget" value="entry" class="filter-option__input"
                                    checked>
                                <span class="filter-option__text">Entry</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="budget" value="medium" class="filter-option__input">
                                <span class="filter-option__text">Medium</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="budget" value="commercial" class="filter-option__input">
                                <span class="filter-option__text">Commercial</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="budget" value="premium" class="filter-option__input">
                                <span class="filter-option__text">Premium</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="budget" value="industrial" class="filter-option__input">
                                <span class="filter-option__text">Industrial</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="budget" value="enterprise" class="filter-option__input">
                                <span class="filter-option__text">Enterprise</span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="budget" value="any" class="filter-option__input">
                                <span class="filter-option__text">Any</span>
                            </label>
                        </div>
                    </div>

                </div>
            </aside>

            <!-- Center Content Feed (col-lg-6) -->
            <div class="col-12 col-lg-6 px-lg-4 center-feed pt-2">


                <!-- Mobile Filter Trigger -->
                <div class="mobile-filter-bar">
                    <button type="button" class="mobile-filter-bar__btn" data-bs-toggle="offcanvas"
                        data-bs-target="#mobileFilterDrawer">
                        <i class="bi bi-funnel"></i> Filter Products <span class="filter-active-count"></span>
                    </button>
                </div>

                <!-- Active Search Query Banner -->
                @if (!empty($search))
                    <div
                        class="d-flex align-items-center justify-content-between p-3 my-3 bg-white rounded-3 border shadow-sm">
                        <div>
                            <span class="text-muted fs-11 text-uppercase fw-bold letter-spacing-1">Search Results
                                for</span>
                            <h5 class="mb-0 text-dark fw-bold">"{{ $search }}"</h5>
                            <span
                                class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill mt-1">{{ $products->total() }}
                                solutions found</span>
                        </div>
                        <a href="{{ route('products.filter') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                            <i class="bi bi-x-circle me-1"></i> Clear
                        </a>
                    </div>
                @endif

                <!-- Hero Spotlight Box (Top Featured Product) -->
                @if (empty($search) && !$isAllProducts && isset($topFeaturedProduct) && $topFeaturedProduct)
                    <div class="product-hero mt-3">
                        <span
                            class="product-hero__badge">{{ $topFeaturedProduct->categories->first()->category_name ?? 'Featured' }}</span>
                        <h1 class="product-hero__title">{{ $topFeaturedProduct->name }}. <span
                                class="product-hero__title-light">{{ $topFeaturedProduct->model }}</span></h1>
                        <p class="product-hero__description">
                            {{ getLimitedText($topFeaturedProduct->description->description ?? '', 130) }}</p>
                        <a href="{{ route('products.detail', $topFeaturedProduct->slug ?: $topFeaturedProduct->id) }}"
                            class="product-hero__button">Buy Now — ${{ number_format($topFeaturedProduct->price, 2) }}</a>
                        <div class="product-hero__image-wrapper">
                            <img src="{{ getImageUrl($topFeaturedProduct->main_image) }}"
                                alt="{{ $topFeaturedProduct->name }}" class="product-hero__image">
                        </div>
                    </div>
                @endif

                <!-- 2 Column Product Card Grid (Matching Image) -->
                <div class="row row-cols-1 row-cols-md-2 g-3 product-grid">
                    @forelse($products as $product)
                        @php
                            $cadr =
                                $product->productAttributes->firstWhere('name', 'CADR Rating')?->details ??
                                ($product->productAttributes->firstWhere('name', 'CADR')?->details ?? '');
                            $filterGrade =
                                $product->productAttributes->firstWhere('name', 'Filter Grade')?->details ??
                                ($product->productAttributes->firstWhere('name', 'Filter')?->details ?? '');
                            $firstCategory = $product->categories->first();
                            $subCategory = $product->categories->skip(1)->first();
                            $categoryName = $firstCategory?->category_name;
                            $categoryBgColor = $firstCategory?->bg_color ?: '#00c853';
                            $subtitle = $product->description?->tag ?? '';
                        @endphp
                        <!-- Product Card -->
                        <div class="col product-item" data-category="{{ strtolower($categoryName ?? 'purifier') }}">
                            <div class="product-card position-relative">
                                @if (!empty($search) || ($isAllProducts && $categoryName))
                                    <div class="product-card__badge-wrapper">
                                        <span class="product-card__badge-pill"
                                            style="background-color: {{ $categoryBgColor }};">
                                            {{ $categoryName }}
                                        </span>
                                    </div>
                                @endif

                                <div class="product-card__labels position-absolute d-flex flex-column gap-2">
                                    @php
                                        $inCart = isset(session()->get('cart', [])[$product->id]);
                                    @endphp
                                    <a href="#" class="btn-add-to-cart {{ $inCart ? 'active' : '' }}"
                                        data-product-id="{{ $product->id }}" data-bs-toggle="tooltip"
                                        data-bs-placement="left" title="{{ $inCart ? 'In cart' : 'Add to cart' }}">

                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17 18C17.5304 18 18.0391 18.2107 18.4142 18.5858C18.7893 18.9609 19 19.4696 19 20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22C16.4696 22 15.9609 21.7893 15.5858 21.4142C15.2107 21.0391 15 20.5304 15 20C15 18.89 15.89 18 17 18ZM1 2H4.27L5.21 4H20C20.2652 4 20.5196 4.10536 20.7071 4.29289C20.8946 4.48043 21 4.73478 21 5C21 5.17 20.95 5.34 20.88 5.5L17.3 11.97C16.96 12.58 16.3 13 15.55 13H8.1L7.2 14.63L7.17 14.75C7.17 14.8163 7.19634 14.8799 7.24322 14.9268C7.29011 14.9737 7.3537 15 7.42 15H19V17H7C6.46957 17 5.96086 16.7893 5.58579 16.4142C5.21071 16.0391 5 15.5304 5 15C5 14.65 5.09 14.32 5.24 14.04L6.6 11.59L3 4H1V2ZM7 18C7.53043 18 8.03914 18.2107 8.41421 18.5858C8.78929 18.9609 9 19.4696 9 20C9 20.5304 8.78929 21.0391 8.41421 21.4142C8.03914 21.7893 7.53043 22 7 22C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20C5 18.89 5.89 18 7 18ZM16 11L18.78 6H6.14L8.5 11H16Z"
                                                fill="#0066CC" />
                                        </svg>
                                    </a>
                                    @php
                                        $isFav = in_array($product->id, session()->get('favorites', []));
                                    @endphp
                                    <a href="#" class="btn-toggle-favorite {{ $isFav ? 'active' : '' }}"
                                        data-product-id="{{ $product->id }}" data-bs-toggle="tooltip"
                                        data-bs-placement="left"
                                        title="{{ $isFav ? 'Remove from favorites' : 'Add to favorite' }}">
                                        <svg width="16" height="16" viewBox="0 0 24 24"
                                            fill="{{ $isFav ? '#dc3545' : 'none' }}" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 20.9999L10.55 19.6999C8.86667 18.1832 7.475 16.8749 6.375 15.7749C5.275 14.6749 4.4 13.6872 3.75 12.8119C3.1 11.9366 2.646 11.1326 2.388 10.3999C2.13 9.66724 2.00067 8.91724 2 8.1499C2 6.58324 2.525 5.2749 3.575 4.2249C4.625 3.1749 5.93333 2.6499 7.5 2.6499C8.36667 2.6499 9.19167 2.83324 9.975 3.1999C10.7583 3.56657 11.4333 4.08324 12 4.7499C12.5667 4.08324 13.2417 3.56657 14.025 3.1999C14.8083 2.83324 15.6333 2.6499 16.5 2.6499C18.0667 2.6499 19.375 3.1749 20.425 4.2249C21.475 5.2749 22 6.58324 22 8.1499C22 8.91657 21.871 9.66657 21.613 10.3999C21.355 11.1332 20.9007 11.9372 20.25 12.8119C19.5993 13.6866 18.7243 14.6742 17.625 15.7749C16.5257 16.8756 15.134 18.1839 13.45 19.6999L12 20.9999ZM12 18.2999C13.6 16.8666 14.9167 15.6376 15.95 14.6129C16.9833 13.5882 17.8 12.6966 18.4 11.9379C19 11.1792 19.4167 10.5039 19.65 9.9119C19.8833 9.3199 20 8.73257 20 8.1499C20 7.1499 19.6667 6.31657 19 5.6499C18.3333 4.98324 17.5 4.6499 16.5 4.6499C15.7167 4.6499 14.9917 4.87057 14.325 5.3119C13.6583 5.75324 13.2 6.3159 12.95 6.9999H11.05C10.8 6.31657 10.3417 5.75424 9.675 5.3129C9.00833 4.87157 8.28333 4.65057 7.5 4.6499C6.5 4.6499 5.66667 4.98324 5 5.6499C4.33333 6.31657 4 7.1499 4 8.1499C4 8.73324 4.11667 9.3209 4.35 9.9129C4.58333 10.5049 5 11.1799 5.6 11.9379C6.2 12.6959 7.01667 13.5876 8.05 14.6129C9.08333 15.6382 10.4 16.8672 12 18.2999Z"
                                                fill="{{ $isFav ? '#dc3545' : '#0066CC' }}" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="product-card__image-wrapper">
                                    <a href="{{ route('products.detail', $product->slug ?: $product->id) }}">
                                        <img src="{{ $product->main_image ? getImageUrl($product->main_image) : theme_asset('img/Air-Purify.png') }}"
                                            alt="{{ $product->name }}" class="product-card__image">
                                    </a>
                                </div>
                                <h3 class="product-card__title">
                                    <a href="{{ route('products.detail', $product->slug ?: $product->id) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <div class="product-card__category">
                                    {{ strtoupper($subtitle) }}
                                </div>
                                <div class="product-card__actions">
                                    <a href="#" class="product-card__btn-buy btn-buy-now"
                                        data-product-id="{{ $product->id }}">Buy</a>
                                    <a href="{{ route('products.detail', $product->slug ?: $product->id) }}"
                                        class="product-card__btn-learn">Learn more</a>
                                </div>
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
                            </div>
                        </div>
                    @empty
                        <div class="col-12 w-100 py-5 text-center">
                            <p class="text-muted">No products found matching the criteria.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Product Pagination -->
                @if ($products->hasPages())
                    <div class="product-pagination-wrapper">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                @endif

                <!-- Section: Why Choose AIRE? (GSAP ScrollTrigger Pinned Deck Animation) -->
                <section class="why-choose-stacked-wrapper my-5" id="whyChooseStackedWrapper">
                    <div class="stacked-cards-sticky-pin">
                        <div class="why-choose-stacked__header">
                            <h2 class="why-choose-stacked__title">Why Choose AIRE?</h2>
                            <span class="why-choose-stacked__subtitle">THE AIRE STANDARD</span>
                        </div>

                        <div class="stacked-cards-container">
                            <!-- Layer 1 -->
                            <div class="stacked-card card-layer-1">
                                <div class="card-left-header">
                                    <div class="why-dots mb-2">&bull;&bull;&bull;</div>
                                    <h3 class="tab-title text-white">Medical-Grade<br>Precision</h3>
                                </div>
                                <div class="card-right-body">
                                    <p class="mb-0">Advanced HEPA-14 filtration systems delivering 99.97% particle
                                        removal down to 0.1 microns. Engineered for sterile environments.</p>
                                </div>
                            </div>

                            <!-- Layer 2 -->
                            <div class="stacked-card card-layer-2">
                                <div class="card-left-header">
                                    <div class="why-dots mb-2">&bull;&bull;</div>
                                    <h3 class="tab-title text-dark">Architectural<br>Integration</h3>
                                </div>
                                <div class="card-right-body">
                                    <p class="mb-0">Minimalist hardware designed to blend into luxury interiors.
                                        Precision acoustic dampening ensures ultra-silent whisper operation.</p>
                                </div>
                            </div>

                            <!-- Layer 3 -->
                            <div class="stacked-card card-layer-3">
                                <div class="card-left-header">
                                    <div class="why-dots mb-2">&bull;&bull;&bull;</div>
                                    <h3 class="tab-title text-dark">Smart<br>Ecosystem</h3>
                                </div>
                                <div class="card-right-body">
                                    <p class="mb-0">Real-time IAQ monitoring and automated climate control. AI-driven
                                        particle counters adjust airflow dynamically without manual intervention.</p>
                                </div>
                            </div>

                            <!-- Layer 4 -->
                            <div class="stacked-card card-layer-4">
                                <div class="card-left-header">
                                    <div class="why-dots mb-2">&bull;&bull;&bull;&bull;</div>
                                    <h3 class="tab-title text-dark">Uncompromised<br>Design.</h3>
                                </div>
                                <div class="card-right-body">
                                    <p class="mb-0">This is the space where engineering meets art. We redefine the types
                                        of environments you inhabit, highlighting the invisible benefits of pure air.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section: Tested & Trusted by -->
                <section class="trusted-section">
                    <h2 class="trusted-section__title">Tested & Trusted by</h2>
                    <div class="trusted-section__grid">
                        <div class="trusted-card">
                            <div class="trusted-card__icon-wrapper">
                                <i class="bi bi-star trusted-card__icon"></i>
                            </div>
                            <h3 class="trusted-card__name">NATURA</h3>
                            <p class="trusted-card__description">Approved by Public Health Assurance 2035</p>
                        </div>
                        <div class="trusted-card">
                            <div class="trusted-card__icon-wrapper">
                                <i class="bi bi-shield-check trusted-card__icon"></i>
                            </div>
                            <h3 class="trusted-card__name">GT</h3>
                            <p class="trusted-card__description">Approved by Institute of Health and Safety 2035</p>
                        </div>
                    </div>
                </section>

                <!-- Banner: Middle Featured Product -->
                @if (!$isAllProducts && isset($middleFeaturedProduct) && $middleFeaturedProduct)
                    <section class="amazon-banner">
                        <div class="amazon-banner__top-bar"></div>
                        <img src="{{ getImageUrl($middleFeaturedProduct->main_image) }}"
                            alt="{{ $middleFeaturedProduct->name }}" class="amazon-banner__background-image">
                        <div class="amazon-banner__overlay">
                            <h2 class="amazon-banner__title">{{ $middleFeaturedProduct->name }}</h2>
                            <div class="amazon-banner__subtitle">
                                {{ strtoupper($middleFeaturedProduct->model ?? 'RECOMMENDED FEATURED SOLUTION') }}</div>
                            <div class="amazon-banner__stars">
                                <i class="bi bi-star-fill amazon-banner__star-icon"></i>
                                <i class="bi bi-star-fill amazon-banner__star-icon"></i>
                                <i class="bi bi-star-fill amazon-banner__star-icon"></i>
                                <i class="bi bi-star-fill amazon-banner__star-icon"></i>
                                <i class="bi bi-star-fill amazon-banner__star-icon"></i>
                            </div>
                            <a href="{{ route('products.detail', $middleFeaturedProduct->slug ?: $middleFeaturedProduct->id) }}"
                                class="amazon-banner__button">EXPLORE PRODUCT —
                                ${{ number_format($middleFeaturedProduct->price, 2) }}</a>
                        </div>
                    </section>
                @endif

                <!-- Section: Purity in Practice -->
                <section class="testimonials-section">
                    <h2 class="testimonials-section__title">Purity in Practice</h2>
                    <span class="testimonials-section__subtitle">CLIENT TESTIMONIALS</span>

                    <!-- Swiper Container -->
                    <div class="swiper testimonials-slider">
                        <div class="swiper-wrapper testimonials-section__grid">

                            <!-- Slide 1 -->
                            <div class="swiper-slide testimonial-card">
                                <div>
                                    <div class="testimonial-card__stars">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <blockquote class="testimonial-card__quote">
                                        "The AIRE Pro S1 is not just an air purifier; it's a piece of architectural art
                                        that
                                        has transformed our living environment."
                                    </blockquote>
                                </div>
                                <div class="testimonial-card__author">
                                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=120&q=80"
                                        alt="Sarah Jenkins" class="testimonial-card__avatar">
                                    <div class="testimonial-card__author-info">
                                        <h3 class="testimonial-card__author-name">Sarah Jenkins</h3>
                                        <span class="testimonial-card__author-role">INTERIOR ARCHITECT</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 2 -->
                            <div class="swiper-slide testimonial-card">
                                <div>
                                    <div class="testimonial-card__stars">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <blockquote class="testimonial-card__quote">
                                        "Unmatched technical precision. The IAQ data reporting is exactly what our
                                        facility
                                        management team needed for ESG compliance."
                                    </blockquote>
                                </div>
                                <div class="testimonial-card__author">
                                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=120&q=80"
                                        alt="Marcus Chen" class="testimonial-card__avatar">
                                    <div class="testimonial-card__author-info">
                                        <h3 class="testimonial-card__author-name">Marcus Chen</h3>
                                        <span class="testimonial-card__author-role">SENIOR FACILITY MANAGER</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Slide 2 -->
                            <div class="swiper-slide testimonial-card">
                                <div>
                                    <div class="testimonial-card__stars">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <blockquote class="testimonial-card__quote">
                                        "Unmatched technical precision. The IAQ data reporting is exactly what our
                                        facility
                                        management team needed for ESG compliance."
                                    </blockquote>
                                </div>
                                <div class="testimonial-card__author">
                                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=120&q=80"
                                        alt="Marcus Chen" class="testimonial-card__avatar">
                                    <div class="testimonial-card__author-info">
                                        <h3 class="testimonial-card__author-name">Marcus Chen</h3>
                                        <span class="testimonial-card__author-role">SENIOR FACILITY MANAGER</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Slide 2 -->
                            <div class="swiper-slide testimonial-card">
                                <div>
                                    <div class="testimonial-card__stars">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <blockquote class="testimonial-card__quote">
                                        "Unmatched technical precision. The IAQ data reporting is exactly what our
                                        facility
                                        management team needed for ESG compliance."
                                    </blockquote>
                                </div>
                                <div class="testimonial-card__author">
                                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=120&q=80"
                                        alt="Marcus Chen" class="testimonial-card__avatar">
                                    <div class="testimonial-card__author-info">
                                        <h3 class="testimonial-card__author-name">Marcus Chen</h3>
                                        <span class="testimonial-card__author-role">SENIOR FACILITY MANAGER</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Add more .swiper-slide items here if needed -->

                        </div>

                        <!-- Optional Pagination Dots -->
                        <div class="swiper-pagination"></div>
                    </div>
                </section>

                <!-- Section: The Future of Pure Living Hero (Bottom Featured Product) -->
                @if (!$isAllProducts && isset($bottomFeaturedProduct) && $bottomFeaturedProduct)
                    <section class="living-hero" id="living-hero-section">
                        <div class="living-hero__image-bg" id="living-hero-img-box">
                            <img src="{{ theme_asset('img/background-without-product.png') }}" alt="Modern Living Room"
                                class="living-hero__bg-img">
                            <!-- Animated product image that flies down from living room scene to above Buy Now button on scroll -->
                            <img src="{{ getImageUrl($bottomFeaturedProduct->main_image) }}"
                                alt="{{ $bottomFeaturedProduct->name }}" class="living-hero__animated-product"
                                id="living-hero-animated-product">
                        </div>

                        <h2 class="living-hero__title">{{ $bottomFeaturedProduct->name }}</h2>
                        <p class="living-hero__description">
                            {{ getLimitedText($bottomFeaturedProduct->description->description ?? '', 160) }}
                        </p>

                        <!-- Landing target container above Buy Now button matching mockup -->
                        <div class="living-hero__product-target" id="living-hero-product-target">
                            <div class="living-hero__product-placeholder"></div>
                        </div>

                        <div class="mt-2">
                            <a href="{{ route('products.detail', $bottomFeaturedProduct->slug ?: $bottomFeaturedProduct->id) }}"
                                class="living-hero__button">Buy Now —
                                ${{ number_format($bottomFeaturedProduct->price, 2) }}</a>
                        </div>
                    </section>
                @endif

            </div>

            <!-- Right Sidebar Feature -->
            <aside class="col-lg-12 col-xl-3 d-none d-xl-block border-left1px">
                <!-- Swiper Slider Implementation -->

                @if ($adSliders->count() > 0)

                    <div class="featured-card sticky-sidebar bg-white border border-light-subtle shadow-sm rounded-4 ms-3"
                        data-lenis-prevent>
                        <div class="swiper featured-swiper">
                            <div class="swiper-wrapper">
                                @forelse ($adSliders as $index => $ad)
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
                                            <a href="{{ $ad->link ?: route('products.filter') }}"
                                                class="btn btn-primary w-100 fw-bold shadow-sm featured-btn text-decoration-none d-inline-block text-center">
                                                {{ $ad->button_text ?? ($index === 0 ? 'VIEW PRODUCTS' : ($index === 1 ? 'LEARN MORE' : 'GET A QUOTE')) }}
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
    <!-- GSAP & ScrollTrigger -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <!-- Custom Product Filter JS -->
    <script src="{{ theme_asset('js/product-filter.js') }}" defer></script>
@endpush
