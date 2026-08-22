@extends('themes.default.layouts.master')

@section('title', 'Aire | Products')

@push('styles')
    <link rel="stylesheet" href="{{ theme_asset('css/product.css') }}">
@endpush

@section('content')
    @php
        $isProducts = request()->route('slug') === 'products';
    @endphp
    <main class="container main-container">
        <h1 class="d-none">Your Main Page Title</h1>
        <div class="row g-0">
            <!-- Left Sidebar Navigation -->
            <aside class="col-lg-3 d-none d-lg-block border-right1px pe-lg-4">
                <nav class="sidebar-menu sticky-sidebar" data-lenis-prevent>
                    @if ($isProducts)
                        <a href="{{ route('products.filter') . '?all=1' }}" class="menu-item--special">
                            <span class="special-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect width="24" height="24" fill="url(#pattern0_4093_438)" />
                                    <defs>
                                        <pattern id="pattern0_4093_438" patternContentUnits="objectBoundingBox"
                                            width="1" height="1">
                                            <use xlink:href="#image0_4093_438" transform="scale(0.00195312)" />
                                        </pattern>
                                        <image id="image0_4093_438" width="512" height="512" preserveAspectRatio="none"
                                            xlink:href="data:image/png;base64,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" />
                                    </defs>
                                </svg>

                            </span>
                            <span>All products</span>
                            <i class="bi bi-chevron-right chevron"></i>
                        </a>
                        <hr class="sidebar-divider mb-3">
                    @endif

                    @foreach ($categories->children as $cat)
                        <a href="#cat-{{ $cat->id }}" class="menu-item {{ $loop->first ? 'active' : '' }}">
                            <div class="icon-box">
                                @if (strpos($cat->icon_class, '<svg') !== false)
                                    {!! $cat->icon_class !!}
                                @elseif($cat->icon_class)
                                    <i class="{{ $cat->icon_class }}"></i>
                                @elseif($cat->icon)
                                    {!! $cat->icon->code !!}
                                @else
                                    <i class="bi bi-box"></i>
                                @endif
                            </div>
                            <div class="text-box">
                                <h2 class="mb-0">{{ $cat->category_name }}</h2>
                                <small
                                    class="d-block mt-1">{{ \Illuminate\Support\Str::limit($cat->description ?? 'Explore solutions', 50) }}</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto chevron"></i>
                        </a>
                    @endforeach

                    @if ($isProducts)
                        <hr class="sidebar-divider mt-3">
                        <a href="{{ route('products.filter-step') }}" class="menu-item--special">
                            <span class="special-icon">
                                <svg width="17" height="15" viewBox="0 0 17 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2.77726 1.02777e-06C2.78897 1.02777e-06 2.80072 1.02777e-06 2.81251 1.02777e-06H13.3478C13.8479 -2.14722e-05 14.2756 -4.39603e-05 14.6174 0.043066C14.9798 0.0887935 15.3302 0.191469 15.6179 0.461431C15.9107 0.736156 16.0271 1.07892 16.0781 1.43554C16.1251 1.76313 16.1251 2.17048 16.125 2.63519V3.21759C16.125 3.58397 16.125 3.90071 16.0977 4.16483C16.0682 4.44905 16.0039 4.7157 15.8494 4.9717C15.6961 5.22578 15.4896 5.4102 15.2516 5.57553C15.0274 5.73128 14.7409 5.89253 14.404 6.0822L12.1972 7.32443C11.6948 7.60725 11.5199 7.7091 11.4032 7.81043C11.135 8.0433 10.9814 8.3016 10.9092 8.6253C10.8784 8.76368 10.875 8.9379 10.875 9.46718V11.5163C10.8751 12.1922 10.8751 12.7661 10.8056 13.2072C10.7315 13.6763 10.5599 14.1262 10.1099 14.4077C9.67005 14.6828 9.18563 14.6575 8.71485 14.5457C8.26148 14.438 7.70273 14.2196 7.0323 13.9574L6.96713 13.932C6.6531 13.8092 6.37808 13.7018 6.16039 13.5893C5.92643 13.4685 5.70915 13.3182 5.54291 13.0843C5.37481 12.8477 5.30741 12.594 5.27736 12.3347C5.24996 12.0983 5.24998 11.8145 5.25 11.498V9.46718C5.25 8.9379 5.24666 8.76368 5.21582 8.6253C5.14365 8.3016 4.99007 8.0433 4.72188 7.81043C4.60511 7.7091 4.43019 7.60725 3.92786 7.32443L1.72103 6.0822C1.38412 5.89253 1.09765 5.73128 0.873437 5.57553C0.635432 5.4102 0.428934 5.22578 0.275604 4.9717C0.121112 4.7157 0.0567841 4.44905 0.0273391 4.16483C-2.84482e-05 3.90071 -1.34696e-05 3.58397 1.53039e-06 3.21759L9.04058e-06 2.6735C9.04058e-06 2.66068 1.53039e-06 2.64791 1.53039e-06 2.63518C-2.84696e-05 2.17047 -6.596e-05 1.76313 0.046884 1.43554C0.0979815 1.07892 0.214322 0.736156 0.507137 0.461431C0.794874 0.191469 1.14521 0.0887935 1.50768 0.043066C1.84944 -4.39603e-05 2.27705 -2.14722e-05 2.77726 1.02777e-06ZM1.64847 1.15922C1.39823 1.19079 1.31865 1.24268 1.27688 1.28187C1.24019 1.31629 1.19178 1.37689 1.16051 1.59512C1.12636 1.83341 1.12501 2.15901 1.12501 2.6735V3.19086C1.12501 3.59152 1.1257 3.84959 1.14635 4.04891C1.16558 4.23454 1.1986 4.3238 1.23881 4.39043C1.28018 4.45899 1.34888 4.536 1.51526 4.65157C1.69055 4.77333 1.93002 4.90881 2.29495 5.11424L4.47972 6.3441C4.50018 6.35565 4.52033 6.36698 4.54018 6.37815C4.9592 6.61388 5.24459 6.77445 5.4594 6.9609C5.90292 7.34595 6.18748 7.81365 6.31385 8.3805C6.37527 8.65598 6.37517 8.96483 6.37502 9.40088C6.37502 9.42263 6.375 9.44475 6.375 9.46718V11.4693C6.375 11.8235 6.37588 12.0413 6.39488 12.2052C6.41207 12.3535 6.43914 12.4034 6.45998 12.4327C6.48269 12.4646 6.52768 12.5129 6.6765 12.5897C6.8358 12.672 7.05533 12.7586 7.4019 12.894C8.12265 13.1758 8.60745 13.3639 8.9748 13.4511C9.33375 13.5364 9.45203 13.4922 9.51323 13.4539C9.56423 13.422 9.64298 13.3573 9.69428 13.032C9.74835 12.689 9.75 12.2051 9.75 11.4693V9.46718C9.75 9.44475 9.75 9.42263 9.75 9.40088C9.74985 8.96483 9.7497 8.65598 9.81113 8.3805C9.9375 7.81365 10.2221 7.34595 10.6656 6.9609C10.8804 6.77445 11.1658 6.61388 11.5848 6.37815C11.6047 6.36698 11.6249 6.35565 11.6453 6.3441L13.8301 5.11424C14.195 4.90881 14.4345 4.77333 14.6098 4.65157C14.7761 4.536 14.8448 4.45899 14.8862 4.39043C14.9264 4.3238 14.9594 4.23454 14.9786 4.04891C14.9993 3.84959 15 3.59152 15 3.19086V2.6735C15 2.15901 14.9987 1.83341 14.9645 1.59512C14.9333 1.37689 14.8848 1.31629 14.8481 1.28187C14.8064 1.24268 14.7268 1.19079 14.4766 1.15922C14.2136 1.12606 13.8578 1.125 13.3125 1.125H2.81251C2.26723 1.125 1.91141 1.12606 1.64847 1.15922Z"
                                        fill="#231F20" />
                                </svg>

                            </span>
                            <span>Find Your Solutions</span>
                            <i class="bi bi-chevron-right chevron"></i>
                        </a>
                    @endif
                </nav>
            </aside>

            <section class="col-lg-9 col-xl-6 center-feed pb-5 px-lg-4">

                @foreach ($categories->children as $cat)
                    <!-- Category Section: {{ $cat->category_name }} -->
                    <div id="cat-{{ $cat->id }}" class="content-section mb-5 pb-4">
                        <h2 class="section-title title-1">{{ $cat->category_name }}</h2>
                        <p class="section-subtitle mt-3 mb-4 pb-2 text-muted fs-16 lh-base">
                            {{ $cat->description }}
                        </p>
                        @php
                            $catSlug = strtolower($cat->slug ?? \Illuminate\Support\Str::slug($cat->category_name));

                            // 1. Check if category has custom features saved from database / backend admin
                            $catFeatures = $cat->features;

                        @endphp

                        <!-- Feature Icons -->
                        @if (!empty($catFeatures) && is_array($catFeatures) && count($catFeatures) > 0)
                            <div class="row g-4 mb-5 mt-2">
                                @foreach ($catFeatures as $feat)
                                    <div class="col-6 col-md-3">
                                        <div class="feature-icon-item">
                                            <div class="feature-icon-wrapper">
                                                <i class="bi {{ $feat['icon'] ?? 'bi-box' }}"></i>
                                            </div>
                                            <h3>{{ $feat['title'] ?? '' }}</h3>
                                            <p>{{ $feat['desc'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <!-- Subcategories Grid -->
                        <div class="row g-4">
                            @foreach ($cat->children as $sub)
                                <div class="col-md-6">
                                    {{--  --}}
                                    <div class="solution-card">
                                        <img class="card-img-bg"
                                            src="{{ $sub->image ? getImagePath($sub->image) : theme_asset('img/apartments.jpg') }}"
                                            alt="{{ $sub->category_name }}">
                                        <div class="card-gradient-overlay"></div>
                                        <div class="card-content">
                                            <h3 class="card-title mb-4 fs-24">{{ $sub->category_name }}</h3>
                                            <p class="card-spec-list">{{ getLimitedText($sub->description) }}</p>
                                            <a href="{{ route('products.filter', $sub->slug ?? $sub->id) }}"
                                                class="card-link fs-12 mt-auto">EXPLORE
                                                SOLUTIONS <i class="bi bi-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </section>

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
