@extends('themes.default.layouts.master')

@section('body_class', 'product-filter-page')

@push('styles')
    <!-- BEM Product Filter Page CSS -->
    <link href="{{ theme_asset('css/product-filter.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php
        $isAllProducts = true;
    @endphp
    <!-- Mobile Offcanvas Filter Drawer -->
    <div class="offcanvas offcanvas-start mobile-filter-drawer" tabindex="-1" id="mobileFilterDrawer" role="dialog"
        aria-labelledby="mobileFilterDrawerLabel" aria-modal="true">
        <div class="offcanvas-header border-bottom py-3 px-3 px-sm-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-funnel text-primary fs-18"></i>
                <h5 class="offcanvas-title fw-bold text-dark mb-0 fs-16" id="mobileFilterDrawerLabel">Filter Products</h5>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('products.filter') }}"
                    class="btn btn-sm btn-light border text-muted fs-11 fw-bold px-2.5 py-1 rounded-pill text-decoration-none">
                    RESET ALL
                </a>
                <button type="button" class="btn-close ms-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <div class="offcanvas-body p-3 p-sm-4" data-lenis-prevent>
            <div class="filter-sidebar filter-sidebar--mobile" id="mobileFilterSidebarContainer">
                @include('themes.default.products.partials.filter_sidebar', [
                    'formId' => 'mobileFilterForm',
                    'showHeader' => false,
                ])
            </div>
        </div>
        <div class="offcanvas-footer border-top p-3 bg-white position-sticky bottom-0">
            <button type="button" class="btn btn-primary w-100 py-2.5 rounded-pill fw-bold text-white shadow-sm"
                data-bs-dismiss="offcanvas">
                Apply & View {{ $products->total() }} Products
            </button>
        </div>
    </div>

    <!-- Main Container: 3 Column Layout like index.html -->
    <main class="container main-container product-filter-page__main">

        <div class="row g-0">

            <!-- Left Column: Filters Sidebar (col-lg-3, hidden on mobile/tablet < 992px) -->
            <aside class="col-12 col-lg-3 d-none d-lg-block border-right1px pe-lg-4">

                <!-- Breadcrumb Navigation (Outside of scrollable filter sidebar) -->
                <nav class="breadcrumb-nav mb-3 py-3" aria-label="breadcrumb">
                    <a href="{{ route('categories') }}" class="breadcrumb-nav__link">Products</a>
                    <span class="breadcrumb-nav__separator">&gt;</span>
                    <span class="breadcrumb-nav__current">{{ $currentCategory->category_name ?? 'All Solutions' }}</span>
                </nav>
                <div class="filter-sidebar sticky-sidebar left" data-lenis-prevent id="filterSidebarContainer">
                    @include('themes.default.products.partials.filter_sidebar')
                </div>
            </aside>

            <!-- Center Content Feed (col-lg-9 or col-xl-6) -->
            <div
                class="col-12 col-lg-9 {{ $adSliders->count() > 0 ? 'col-xl-6' : 'col-xl-9' }} px-2 px-sm-3 px-lg-4 center-feed pt-2">

                <!-- Mobile Breadcrumb & Filter Bar (Visible only on < 992px screens) -->
                <div class="d-lg-none mb-3">
                    <nav class="breadcrumb-nav mb-2 py-2" aria-label="breadcrumb">
                        <a href="{{ route('categories') }}" class="breadcrumb-nav__link">Products</a>
                        <span class="breadcrumb-nav__separator">&gt;</span>
                        <span
                            class="breadcrumb-nav__current">{{ $currentCategory->category_name ?? 'All Solutions' }}</span>
                    </nav>

                    @php
                        $activeFilterCount = 0;
                        if (
                            request()->filled('category') &&
                            request('category') !== 'any' &&
                            request('category') !== 'all'
                        ) {
                            $activeFilterCount += is_array(request('category')) ? count(request('category')) : 1;
                        }
                        foreach ($dynamicFilterSections ?? [] as $sec) {
                            if (!empty($sec['has_checked'])) {
                                $activeFilterCount++;
                            }
                        }
                    @endphp

                    <!-- Mobile Filter Trigger -->
                    <div class="mobile-filter-bar">
                        <button type="button"
                            class="mobile-filter-bar__btn d-flex align-items-center justify-content-between w-100 px-3 py-2.5 bg-white border rounded-3 shadow-xs"
                            data-bs-toggle="offcanvas" data-bs-target="#mobileFilterDrawer">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-funnel text-primary fs-15"></i>
                                <span class="fw-semibold text-dark fs-13">Filter Products</span>
                                @if ($activeFilterCount > 0)
                                    <span
                                        class="badge bg-primary text-white rounded-pill px-2 py-0.5 fs-11">{{ $activeFilterCount }}</span>
                                @endif
                            </div>
                            <span class="text-muted fs-12 d-flex align-items-center gap-1">
                                {{ $products->total() }} items <i class="bi bi-chevron-right fs-11 text-muted"></i>
                            </span>
                        </button>
                    </div>
                </div>

                <!-- AJAX Product Grid Container -->
                <div id="productGridContainer" class="position-relative">
                    @include('themes.default.products.partials.product_grid')
                </div>


                <!-- Section: Tested & Trusted by -->
                <section class="trusted-section mt-5">
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

                <!-- Section: Purity in Practice (Client Testimonials) -->
                @php
                    $testimonialsSection = getSection('client_testimonials') ?? getSection('testimonials');
                    $testimonialTitle = $testimonialsSection['title'] ?? 'Purity in Practice';
                    $testimonialSubtitle = $testimonialsSection['subtitle'] ?? 'CLIENT TESTIMONIALS';
                    $testimonialsList =
                        $testimonialsSection['items'] ??
                        ($testimonialsSection['testimonials'] ?? [
                            [
                                'name' => 'Sarah Jenkins',
                                'role' => 'INTERIOR ARCHITECT',
                                'avatar' =>
                                    'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=120&q=80',
                                'rating' => 5,
                                'quote' =>
                                    "The AIRE Pro S1 is not just an air purifier; it's a piece of architectural art that has transformed our living environment.",
                            ],
                            [
                                'name' => 'Marcus Chen',
                                'role' => 'SENIOR FACILITY MANAGER',
                                'avatar' =>
                                    'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=120&q=80',
                                'rating' => 5,
                                'quote' =>
                                    'Unmatched technical precision. The IAQ data reporting is exactly what our facility management team needed for ESG compliance.',
                            ],
                            [
                                'name' => 'Dr. Elena Rostova',
                                'role' => 'CLINICAL ALLERGIST',
                                'avatar' =>
                                    'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=120&q=80',
                                'rating' => 5,
                                'quote' =>
                                    'The multi-stage filtration system drastically reduced particulate matter in our high-traffic clinic rooms. Absolutely vital for our patients.',
                            ],
                            [
                                'name' => 'David Sterling',
                                'role' => 'SUSTAINABILITY DIRECTOR',
                                'avatar' =>
                                    'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80',
                                'rating' => 5,
                                'quote' =>
                                    'Combining whisper-quiet acoustics with verifiable CADR performance has made AIRE our go-to partner for premium commercial builds.',
                            ],
                        ]);
                @endphp

                @if (!empty($testimonialsList) && count($testimonialsList) > 0)
                    <section class="testimonials-section">
                        <h2 class="testimonials-section__title">{{ $testimonialTitle }}</h2>
                        @if (!empty($testimonialSubtitle))
                            <span class="testimonials-section__subtitle">{{ strtoupper($testimonialSubtitle) }}</span>
                        @endif

                        <!-- Swiper Container -->
                        <div class="swiper testimonials-slider">
                            <div class="swiper-wrapper">
                                @foreach ($testimonialsList as $testimonial)
                                    @php
                                        $rating = (int) ($testimonial['rating'] ?? ($testimonial['stars'] ?? 5));
                                        $avatar = $testimonial['avatar'] ?? ($testimonial['image'] ?? '');
                                        $avatarUrl = $avatar
                                            ? (\Illuminate\Support\Str::startsWith($avatar, ['http://', 'https://'])
                                                ? $avatar
                                                : getImageUrl($avatar))
                                            : 'https://ui-avatars.com/api/?name=' .
                                                urlencode($testimonial['name'] ?? 'Client') .
                                                '&background=2563eb&color=fff';
                                    @endphp
                                    <div class="swiper-slide testimonial-card">
                                        <div>
                                            <div class="testimonial-card__stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= $rating ? '-fill' : '' }}"></i>
                                                @endfor
                                            </div>
                                            <blockquote class="testimonial-card__quote">
                                                "{!! nl2br(e($testimonial['quote'] ?? ($testimonial['content'] ?? ($testimonial['text'] ?? '')))) !!}"
                                            </blockquote>
                                        </div>
                                        <div class="testimonial-card__author">
                                            <img src="{{ $avatarUrl }}" alt="{{ $testimonial['name'] ?? 'Client' }}"
                                                class="testimonial-card__avatar" loading="lazy">
                                            <div class="testimonial-card__author-info">
                                                <h3 class="testimonial-card__author-name">{{ $testimonial['name'] ?? '' }}
                                                </h3>
                                                @if (!empty($testimonial['role'] ?? ($testimonial['designation'] ?? '')))
                                                    <span
                                                        class="testimonial-card__author-role">{{ strtoupper($testimonial['role'] ?? ($testimonial['designation'] ?? '')) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Optional Pagination Dots -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </section>
                @endif

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

            @if ($adSliders->count() > 0)
                <!-- Right Sidebar Feature -->
                <aside class="col-lg-12 col-xl-3 d-none d-xl-block border-left1px">
                    <!-- Swiper Slider Implementation -->

                    @include('themes.default.partials.ad_slider')
                </aside>
            @endif
        </div>
    </main>
@endsection

@push('scripts')
    <!-- GSAP & ScrollTrigger -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js" defer></script>
    <!-- Standard Full-Page Filter Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function initFilterNavigation() {
                if (typeof jQuery === 'undefined' || typeof $ === 'undefined') {
                    setTimeout(initFilterNavigation, 50);
                    return;
                }

                // 1. Accordion collapse/expand toggle on filter group header
                $(document).on('click', '.filter-group__header', function() {
                    $(this).closest('.filter-group').toggleClass('collapsed');
                });

                // 2. On change of any filter input (desktop or mobile form)
                $(document).on('change',
                    '#desktopFilterForm input, #desktopFilterForm select, #mobileFilterForm input, #mobileFilterForm select',
                    function() {
                        const $thisForm = $(this).closest('form');
                        const $currentGroup = $(this).closest('.filter-group');

                        // Reset all downstream (subsequent / lower index) filter groups
                        if ($currentGroup.length) {
                            const groupIndex = $currentGroup.parent().find('.filter-group').index(
                                $currentGroup);

                            $thisForm.find('.filter-group').each(function(idx) {
                                if (idx > groupIndex) {
                                    $(this).find('input[type="checkbox"]').prop('checked', false);
                                    $(this).find('input[type="radio"]').prop('checked', false);
                                    $(this).find('input[type="radio"][value="any"]').prop('checked',
                                        true);
                                    $(this).find('select').prop('selectedIndex', 0);
                                }
                            });
                        }

                        // Build clean query string and perform standard full-page GET navigation
                        const formArray = $thisForm.serializeArray();
                        const cleanParams = new URLSearchParams();

                        formArray.forEach(function(item) {
                            const val = item.value ? item.value.trim() : '';
                            if (val !== '' && val !== 'any' && val !== 'all') {
                                if (item.name.endsWith('[]')) {
                                    cleanParams.append(item.name, val);
                                } else {
                                    cleanParams.set(item.name, val);
                                }
                            }
                        });

                        const baseUrl = $thisForm.attr('action') || "{{ route('products.filter') }}";
                        const targetUrl = cleanParams.toString() ? (baseUrl + '?' + cleanParams.toString()) :
                            baseUrl;

                        window.location.href = targetUrl;
                    });

                // 3. Testimonials Swiper Carousel Initialization
                function initTestimonialsSwiper() {
                    const sliderContainer = document.querySelector('.testimonials-slider');
                    if (!sliderContainer || typeof Swiper === 'undefined') return;

                    if (sliderContainer.swiper) {
                        sliderContainer.swiper.update();
                        return;
                    }

                    const slideCount = sliderContainer.querySelectorAll('.swiper-slide').length;
                    if (slideCount === 0) return;

                    new Swiper(sliderContainer, {
                        slidesPerView: 1,
                        spaceBetween: 24,
                        loop: slideCount > 2,
                        autoplay: slideCount > 1 ? {
                            delay: 5000,
                            disableOnInteraction: false,
                            pauseOnMouseEnter: true,
                        } : false,
                        pagination: {
                            el: sliderContainer.querySelector('.swiper-pagination') || '.swiper-pagination',
                            clickable: true,
                        },
                        breakpoints: {
                            768: {
                                slidesPerView: slideCount >= 2 ? 2 : 1,
                                spaceBetween: 24,
                            },
                            1200: {
                                slidesPerView: slideCount >= 2 ? 2 : 1,
                                spaceBetween: 30,
                            }
                        }
                    });
                }

                initTestimonialsSwiper();

                // 4. ScrollTrigger initialization for full-page load
                if (typeof ScrollTrigger !== 'undefined') {
                    if (typeof window.initWhyChooseScrollTrigger === 'function') {
                        window.initWhyChooseScrollTrigger();
                    }
                    if (typeof window.initLivingHeroScrollTrigger === 'function') {
                        window.initLivingHeroScrollTrigger();
                    }
                    ScrollTrigger.refresh(true);
                }
            }

            initFilterNavigation();
        });
    </script>
@endpush
