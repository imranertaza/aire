@extends('themes.default.layouts.master')

@section('title', !empty($currentCategory->meta_title) ? $currentCategory->meta_title : ($currentCategory ?
    $currentCategory->category_name . ' | Aire' : 'Aire | Products'))
@section('meta_description', !empty($currentCategory->meta_description) ? $currentCategory->meta_description :
    $currentCategory->description ?? 'Aire Industries delivers cutting-edge indoor air quality solutions.')
    @if (!empty($currentCategory->meta_keyword))
        @section('meta_keywords', $currentCategory->meta_keyword)
    @endif
    @if (!empty($currentCategory->image))
        @section('og_image', getImagePath($currentCategory->image))
    @endif

    @section('body_class', 'product-filter-page')

    @push('styles')
        <!-- BEM Product Filter Page CSS -->
        <link href="{{ theme_asset('css/product-filter.css') }}" rel="stylesheet">
    @endpush

@section('content')
    <!-- Main Container: 3 Column Layout like index.html -->
    <main class="container main-container product-filter-page__main">


        <div class="row g-0">

            <!-- Center Content Feed (col-lg-6) -->
            <div class="col-12 col-lg-12 {{ $adSliders->count() > 0 ? 'col-xl-9' : 'col-xl-12' }} px-lg-4 center-feed pt-2">

                <!-- Breadcrumb Navigation (Outside of scrollable filter sidebar) -->
                <nav class="breadcrumb-nav mb-3 py-3" aria-label="breadcrumb">
                    <a href="{{ route('categories') }}" class="breadcrumb-nav__link">Products</a>
                    <span class="breadcrumb-nav__separator">&gt;</span>
                    <span class="breadcrumb-nav__current">{{ $currentCategory->category_name ?? 'All Solutions' }}</span>
                </nav>

                <!-- AJAX Product Grid Container -->
                <div id="productGridContainer" class="position-relative">
                    @include('themes.default.products.partials.product_grid')
                </div>

                <!-- Section: Why Choose AIRE? (GSAP ScrollTrigger Pinned Deck Animation) -->
                @php
                    $whyChooseSection = getSection('why_choose_aire');
                    $cardsList = $whyChooseSection['cards'] ?? [];
                @endphp

                @if (!empty($whyChooseSection))
                    <section class="why-choose-stacked-wrapper my-5" id="whyChooseStackedWrapper">
                        <div class="stacked-cards-sticky-pin">
                            <div class="why-choose-stacked__header">
                                <h2 class="why-choose-stacked__title">
                                    {{ $whyChooseSection['title'] ?? 'Why Choose AIRE?' }}</h2>
                                @if (!empty($whyChooseSection['subtitle']))
                                    <span class="why-choose-stacked__subtitle">{{ $whyChooseSection['subtitle'] }}</span>
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
                @if (isset($middleFeaturedProduct) && $middleFeaturedProduct)
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
                            <div class="swiper-wrapper testimonials-section__grid">
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
                @if (isset($bottomFeaturedProduct) && $bottomFeaturedProduct)
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
    <!-- Custom Product Filter JS -->
    <script src="{{ theme_asset('js/product-filter.js') }}" defer></script>

    <!-- Live AJAX Sidebar & Category Filter -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function initAjaxFilter() {
                if (typeof jQuery === 'undefined' || typeof $ === 'undefined') {
                    setTimeout(initAjaxFilter, 50);
                    return;
                }

                let filterAjaxRequest = null;
                let filterDebounce = null;

                // Extract only non-empty, non-'any' form parameters
                function getCleanSerializedData($form) {
                    if (!$form || !$form.length) return '';
                    const formArray = $form.serializeArray();
                    const cleanParams = new URLSearchParams();

                    formArray.forEach(function(item) {
                        const val = item.value ? item.value.trim() : '';
                        if (val !== '' && val !== 'any' && val !== 'all') {
                            cleanParams.append(item.name, val);
                        }
                    });

                    return cleanParams.toString();
                }

                function applyLiveFilters(pageUrl, activeForm) {
                    clearTimeout(filterDebounce);
                    filterDebounce = setTimeout(function() {
                        const $container = $('#productGridContainer');
                        if (!$container.length) return;

                        let $form = activeForm && activeForm.length ? activeForm : $('#desktopFilterForm');
                        if (!$form.length || !$form.is(':visible')) {
                            if ($('#mobileFilterForm').length && $('#mobileFilterForm').is(':visible')) {
                                $form = $('#mobileFilterForm');
                            } else if ($('#desktopFilterForm').length) {
                                $form = $('#desktopFilterForm');
                            }
                        }

                        let serializedData = getCleanSerializedData($form);
                        let baseUrl = "{{ route('products.filter') }}";
                        let targetUrl = pageUrl || (serializedData ? (baseUrl + '?' + serializedData) :
                            baseUrl);

                        // Add loading effect
                        $container.css({
                            opacity: '0.45',
                            transition: 'opacity 0.2s ease',
                            pointerEvents: 'none'
                        });

                        if (filterAjaxRequest) {
                            filterAjaxRequest.abort();
                        }

                        filterAjaxRequest = $.ajax({
                            url: targetUrl,
                            type: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            success: function(res) {
                                $container.css({
                                    opacity: '1',
                                    pointerEvents: 'auto'
                                });
                                if (res && res.status && res.html !== undefined) {
                                    $container.html(res.html);

                                    // Update dynamic filter sidebar options
                                    if (res.sidebar_html && $('#filterSidebarContainer')
                                        .length) {
                                        const openGroupTitles = [];
                                        $('#desktopFilterForm .filter-group:not(.collapsed)')
                                            .each(function() {
                                                const title = $(this).find(
                                                        '.filter-group__title').text()
                                                    .trim();
                                                if (title) openGroupTitles.push(title);
                                            });

                                        $('#filterSidebarContainer').html(res.sidebar_html);

                                        $('#desktopFilterForm .filter-group').each(function() {
                                            const title = $(this).find(
                                                    '.filter-group__title').text()
                                                .trim();
                                            const hasChecked = $(this).find(
                                                'input:checked').length > 0;
                                            if (openGroupTitles.includes(title) ||
                                                hasChecked) {
                                                $(this).removeClass('collapsed');
                                            } else {
                                                $(this).addClass('collapsed');
                                            }
                                        });
                                    }

                                    // Update browser URL without reload with clean query params
                                    const newUrl = res.url || targetUrl;
                                    if (newUrl) {
                                        window.history.pushState({
                                            path: newUrl
                                        }, '', newUrl);
                                    }

                                    // Reinitialize bootstrap tooltips
                                    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                                        const tooltipTriggerList = [].slice.call(document
                                            .querySelectorAll('[data-bs-toggle="tooltip"]'));
                                        tooltipTriggerList.map(function(tooltipTriggerEl) {
                                            return new bootstrap.Tooltip(
                                                tooltipTriggerEl);
                                        });
                                    }

                                    // Recalculate and refresh GSAP ScrollTrigger after DOM changes
                                    if (typeof ScrollTrigger !== 'undefined') {
                                        setTimeout(function() {
                                            if (typeof window
                                                .initWhyChooseScrollTrigger ===
                                                'function') {
                                                window.initWhyChooseScrollTrigger();
                                            }
                                            if (typeof window
                                                .initLivingHeroScrollTrigger ===
                                                'function') {
                                                window.initLivingHeroScrollTrigger();
                                            }
                                            ScrollTrigger.refresh(true);
                                        }, 120);

                                        // Refresh when newly inserted product images finish loading
                                        $container.find('img').on('load', function() {
                                            ScrollTrigger.refresh();
                                        });
                                    }
                                }
                            },
                            error: function(xhr) {
                                if (xhr.statusText !== 'abort') {
                                    $container.css({
                                        opacity: '1',
                                        pointerEvents: 'auto'
                                    });
                                }
                            }
                        });
                    }, 150);
                }

                // 1. Live Filter on change for any input in desktop or mobile form
                $(document).on('change',
                    '#desktopFilterForm input, #desktopFilterForm select, #mobileFilterForm input, #mobileFilterForm select',
                    function() {
                        const $thisForm = $(this).closest('form');
                        const name = $(this).attr('name');
                        const val = $(this).val();
                        const type = $(this).attr('type');

                        // Sync to other form (mobile <-> desktop)
                        if (type === 'checkbox') {
                            const checked = $(this).is(':checked');
                            $(`input[name="${name}"][value="${val}"]`).prop('checked', checked);
                        } else if (type === 'radio') {
                            $(`input[name="${name}"][value="${val}"]`).prop('checked', true);
                        }

                        applyLiveFilters(null, $thisForm);
                    });

                // 2. Intercept pagination links for AJAX page switching
                $(document).on('click', '#productGridContainer .pagination a', function(e) {
                    e.preventDefault();
                    const pageUrl = $(this).attr('href');
                    if (pageUrl) {
                        applyLiveFilters(pageUrl);
                        $('html, body').animate({
                            scrollTop: $('#productGridContainer').offset().top - 100
                        }, 300);
                    }
                });

                // 3. Clear search / reset filters via AJAX
                $(document).on('click', '.filter-sidebar__reset-btn, .clear-search-btn', function(e) {
                    e.preventDefault();
                    if ($('#desktopFilterForm').length) {
                        $('#desktopFilterForm')[0].reset();
                        $('#desktopFilterForm input[type="radio"][value="any"]').prop('checked', true);
                        $('#desktopFilterForm input[type="checkbox"]').prop('checked', false);
                    }
                    if ($('#mobileFilterForm').length) {
                        $('#mobileFilterForm')[0].reset();
                        $('#mobileFilterForm input[type="radio"][value="any"]').prop('checked', true);
                        $('#mobileFilterForm input[type="checkbox"]').prop('checked', false);
                    }
                    applyLiveFilters("{{ route('products.filter') }}");
                });

                // 4. Handle browser back / forward buttons (popstate)
                window.addEventListener('popstate', function() {
                    applyLiveFilters(window.location.href);
                });

                // 5. Handle page show & live filter restore
                window.addEventListener('pageshow', function() {
                    if (typeof ScrollTrigger !== 'undefined') {
                        ScrollTrigger.refresh(true);
                    }
                });
            }

            initAjaxFilter();
        });
    </script>
@endpush
