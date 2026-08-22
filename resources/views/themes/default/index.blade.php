@extends('themes.default.layouts.master')

@section('title', 'Aire | Indoor Air Quality Solutions')
@section('meta_description', 'Aire Industries delivers cutting-edge indoor air quality solutions for residential, commercial, healthcare, and industrial environments. Breathe healthier with AIRE.')

@section('content')
<main class="container main-container">
    <h1 class="d-none">Aire Indoor Air Quality Solutions</h1>
    <div class="row g-0">

        <!-- Left Sidebar Navigation -->
        <aside class="col-lg-3 d-none d-lg-block border-right1px pe-lg-4">
            <nav class="sidebar-menu sticky-sidebar left" data-lenis-prevent>
                <a href="#residential" class="menu-item active">
                    <div class="icon-box"><i class="bi bi-house"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Residential</h2>
                        <small class="d-block mt-1">Homes, apartments, villas</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#commercial" class="menu-item">
                    <div class="icon-box"><i class="bi bi-building"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Commercial</h2>
                        <small class="d-block mt-1">Offices, retail, hotels</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#healthcare" class="menu-item">
                    <div class="icon-box"><i class="bi bi-heart-pulse"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Healthcare</h2>
                        <small class="d-block mt-1">Hospitals, clinics, labs</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#education" class="menu-item">
                    <div class="icon-box"><i class="bi bi-mortarboard"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Education</h2>
                        <small class="d-block mt-1">Schools, universities</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#transportation" class="menu-item">
                    <div class="icon-box"><i class="bi bi-train-front"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Transportation</h2>
                        <small class="d-block mt-1">Airports, metro, terminals</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#industrial" class="menu-item">
                    <div class="icon-box"><i class="bi bi-cone-striped"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Industrial</h2>
                        <small class="d-block mt-1">Factories, plants, warehouses</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#infrastructure" class="menu-item">
                    <div class="icon-box"><i class="bi bi-bank"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Infrastructure</h2>
                        <small class="d-block mt-1">Government, public buildings</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>
            </nav>
        </aside>

        <!-- Center Content Column -->
        <section class="col-lg-9 col-xl-6 center-feed px-lg-4">

            <!-- 1. Residential Solutions -->
            <div id="residential" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Residential Solutions</h2>
                <p class="section-subtitle mb-4 pb-2">Create a healthier, more comfortable home environment with
                    fresh, clean air that protects your family every day.</p>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Apartment Building">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-building"></i></div>
                                <h3 class="card-title fs-20">Apartments</h3>
                                <span class="badge-custom">RESIDENTIAL IAQ</span>
                                <p class="card-desc">Improve indoor air quality in high-rise and multi-unit residences.</p>
                                <a href="{{ route('products.index') }}" class="card-link fs-12 mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Apartment Interior">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-house"></i></div>
                                <h3 class="card-title fs-20">Villas</h3>
                                <span class="badge-custom">RESIDENTIAL IAQ</span>
                                <p class="card-desc">Comprehensive air purification systems for luxury homes and large estates.</p>
                                <a href="{{ route('products.index') }}" class="card-link fs-12 mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Commercial Solutions -->
            <div id="commercial" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Commercial Solutions</h2>
                <p class="section-subtitle mb-4 pb-2">Create healthy, productive and energy-efficient commercial
                    environments with advanced indoor air quality solutions.</p>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Modern Corporate Office">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-building"></i></div>
                                <h3 class="card-title fs-20">Offices</h3>
                                <span class="badge-custom">COMMERCIAL IAQ</span>
                                <p class="card-desc">Improve indoor air quality for better employee health and productivity.</p>
                                <a href="{{ route('products.index') }}" class="card-link fs-12 mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Retail Mall">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-shop"></i></div>
                                <h3 class="card-title fs-20">Retail Centers</h3>
                                <span class="badge-custom">COMMERCIAL IAQ</span>
                                <p class="card-desc">Provide a clean, inviting atmosphere for shoppers and retail staff.</p>
                                <a href="{{ route('products.index') }}" class="card-link fs-12 mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Healthcare Solutions -->
            <div id="healthcare" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Healthcare Solutions</h2>
                <p class="section-subtitle mb-4 pb-2">Meet strict clinical standards with absolute air purity to
                    protect vulnerable patients and medical staff.</p>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Hospital Hallway">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-hospital"></i></div>
                                <h3 class="card-title fs-20">Hospitals</h3>
                                <span class="badge-custom">CLINICAL IAQ</span>
                                <p class="card-desc">HEPA filtration and negative pressure solutions for critical care units.</p>
                                <a href="{{ route('products.index') }}" class="card-link fs-12 mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Medical Clinic">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-heart-pulse"></i></div>
                                <h3 class="card-title fs-20">Clinics</h3>
                                <span class="badge-custom">CLINICAL IAQ</span>
                                <p class="card-desc">Reduce airborne pathogens and cross-contamination in waiting areas.</p>
                                <a href="{{ route('products.index') }}" class="card-link fs-12 mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Education Solutions -->
            <div id="education" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Education Solutions</h2>
                <p class="section-subtitle mb-4 pb-2">Enhance learning environments with proper ventilation and air
                    purification for better cognitive performance.</p>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="School Classroom">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-book"></i></div>
                                <h3 class="card-title fs-20">Schools</h3>
                                <span class="badge-custom">EDUCATION IAQ</span>
                                <p class="card-desc">Keep classrooms fresh to reduce absentee rates and improve focus.</p>
                                <a href="{{ route('products.index') }}" class="card-link fs-12 mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="University Campus">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-mortarboard"></i></div>
                                <h3 class="card-title fs-20">Universities</h3>
                                <span class="badge-custom">EDUCATION IAQ</span>
                                <p class="card-desc">Scaleable air solutions for large lecture halls and campus dormitories.</p>
                                <a href="{{ route('products.index') }}" class="card-link fs-12 mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Transportation Solutions -->
            <div id="transportation" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Transportation Solutions</h2>
                <p class="section-subtitle mb-4 pb-2">Maintain healthy air quality and passenger comfort across
                    high-traffic transit hubs and infrastructure.</p>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Airport Terminal">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-airplane"></i></div>
                                <h3 class="card-title fs-20">Airports</h3>
                                <span class="badge-custom">TRANSIT IAQ</span>
                                <p class="card-desc">Ensure superior air filtration for large scale passenger terminals.</p>
                                <a href="{{ route('products.index') }}" class="card-link fs-12 mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Metro Station">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-train-front"></i></div>
                                <h3 class="card-title fs-20">Metro Stations</h3>
                                <span class="badge-custom">TRANSIT IAQ</span>
                                <p class="card-desc">Advanced ventilation systems for underground transit networks.</p>
                                <a href="{{ route('products.index') }}" class="card-link fs-12 mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. Industrial Solutions -->
            <div id="industrial" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Industrial Solutions</h2>
                <p class="section-subtitle mb-4 pb-2">Robust filtration systems designed to handle heavy particulate
                    loads and chemical fumes in demanding environments.</p>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Factory Floor">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-gear-wide-connected"></i></div>
                                <h3 class="card-title fs-20">Factories</h3>
                                <span class="badge-custom">INDUSTRIAL IAQ</span>
                                <p class="card-desc">Heavy-duty dust collection and exhaust ventilation systems.</p>
                                <a href="{{ route('products.index') }}" class="card-link mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Warehouse">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-box-seam"></i></div>
                                <h3 class="card-title fs-20">Warehouses</h3>
                                <span class="badge-custom">INDUSTRIAL IAQ</span>
                                <p class="card-desc">Maintain temperature and air quality across massive open spaces.</p>
                                <a href="{{ route('products.index') }}" class="card-link mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 7. Infrastructure Solutions -->
            <div id="infrastructure" class="content-section">
                <h2 class="section-title title-1">Infrastructure Solutions</h2>
                <p class="section-subtitle mb-4 pb-2">Future-proof air quality systems for public buildings and
                    critical government infrastructure.</p>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Government Building">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-bank"></i></div>
                                <h3 class="card-title fs-20">Govt. Buildings</h3>
                                <span class="badge-custom">PUBLIC SECTOR</span>
                                <p class="card-desc">Secure, efficient air systems for municipal and federal facilities.</p>
                                <a href="{{ route('products.index') }}" class="card-link mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Public Space">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-people"></i></div>
                                <h3 class="card-title fs-20">Public Spaces</h3>
                                <span class="badge-custom">PUBLIC SECTOR</span>
                                <p class="card-desc">Dynamic IAQ control for museums, libraries, and community centers.</p>
                                <a href="{{ route('products.index') }}" class="card-link mt-auto">VIEW DETAILS <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <!-- Right Sidebar Feature (Swiper Slider) -->
        <aside class="col-lg-12 col-xl-3 d-none d-xl-block border-left1px">
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
                                <h3 class="mb-2 title-2">The Future of Pure Living</h3>
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
                                <img src="{{ theme_asset('img/featured/1.png') }}" class="img-fluid w-100" alt="Modern interior">
                            </div>
                            <div class="featured-content pb-5">
                                <h3 class="mb-2 title-2">Smart Climate Control</h3>
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
                                <img src="{{ theme_asset('img/featured/1.png') }}" class="img-fluid w-100" alt="Office lobby">
                            </div>
                            <div class="featured-content pb-5">
                                <h3 class="mb-2 title-2">Enterprise Grade Purity</h3>
                                <p class="text-muted mb-2 lh-base">Deploy industrial-grade filtration disguised in
                                    beautiful architectural units designed specifically for modern corporate
                                    lobbies.</p>
                                <button class="btn btn-primary w-100 fw-bold shadow-sm featured-btn">GET
                                    A QUOTE</button>
                            </div>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <div class="swiper-pagination position-absolute bottom-2"></div>
                </div>
            </div>
        </aside>

    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize Swiper
        const swiper = new Swiper('.featured-swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });

        // Intersection Observer for scrollspy
        const sections = document.querySelectorAll('.content-section');
        const menuItems = document.querySelectorAll('.sidebar-menu .menu-item');

        const observerOptions = {
            root: null,
            rootMargin: '-20% 0px -80% 0px',
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    menuItems.forEach(item => item.classList.remove('active'));
                    const id = entry.target.getAttribute('id');
                    const activeLinks = document.querySelectorAll(`.sidebar-menu .menu-item[href="#${id}"]`);
                    activeLinks.forEach(link => {
                        link.classList.add('active');
                    });
                }
            });
        }, observerOptions);

        sections.forEach(section => observer.observe(section));
    });
</script>
@endpush
