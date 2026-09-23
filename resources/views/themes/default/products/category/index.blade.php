@extends('themes.default.layouts.master')

@php
    $catModel = $categories instanceof \Illuminate\Database\Eloquent\Model ? $categories : null;
    $seoTitle = $catModel
        ? (!empty($catModel->meta_title)
            ? $catModel->meta_title
            : $catModel->category_name . ' | Aire')
        : 'Aire | Products';
    $seoDesc = $catModel
        ? (!empty($catModel->meta_description)
            ? $catModel->meta_description
            : $catModel->description ?? '')
        : '';
    $seoKeyword = $catModel ? $catModel->meta_keyword ?? '' : '';
    $seoImage = $catModel && !empty($catModel->image) ? getImagePath($catModel->image) : null;
@endphp

@section('title', $seoTitle)
@if (!empty($seoDesc))
    @section('meta_description', $seoDesc)
@endif
@if (!empty($seoKeyword))
    @section('meta_keywords', $seoKeyword)
@endif
@if (!empty($seoImage))
    @section('og_image', $seoImage)
@endif

@push('styles')
    <link rel="stylesheet" href="{{ theme_asset('css/product.css') }}">
@endpush

@section('content')
    @php
        $displayCategories =
            $categories instanceof \Illuminate\Database\Eloquent\Model
                ? ($categories->children && $categories->children->isNotEmpty()
                    ? $categories->children
                    : collect([$categories]))
                : $categories ?? ($allCategories ?? collect());
    @endphp
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
                        <a href="{{ route('products.filter') }}" class="menu-item--special">
                            <span class="special-icon">
                                <img src="{{ theme_asset('img/products-icon.png') }}" alt="">
                            </span>
                            <span>All product</span>
                            <i class="bi bi-chevron-right chevron"></i>
                        </a>
                        <hr class="sidebar-divider mb-3">
                    @endif

                    @foreach ($displayCategories as $cat)
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
                                    class="d-block mt-1">{{ \Illuminate\Support\Str::limit($cat->description ?? 'VIEW PRODUCT', 50) }}</small>
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

            <section class="col-lg-9 {{ $adSliders->count() > 0 ? 'col-xl-6' : 'col-xl-9' }} center-feed pb-5 px-lg-4">

                <!-- Mobile Horizontal Category Scroll Bar (Visible on mobile/tablet screens) -->
                <div class="d-lg-none mobile-category-scroll-wrapper" data-lenis-prevent>
                    <div class="mobile-category-scroll-track" data-lenis-prevent>
                        @if ($isProducts)
                            <a href="{{ route('products.filter') }}"
                                class="mobile-cat-pill mobile-cat-pill--special {{ request()->routeIs('products.filter') ? 'active' : '' }}">
                                <span class="mobile-cat-pill__icon">
                                    <img src="{{ theme_asset('img/products-icon.png') }}" alt="">
                                </span>
                                <span>All Products</span>
                            </a>
                            <a href="{{ route('products.filter-step') }}"
                                class="mobile-cat-pill mobile-cat-pill--special {{ request()->routeIs('products.filter-step') ? 'active' : '' }}">
                                <span class="mobile-cat-pill__icon">
                                    <svg width="15" height="14" viewBox="0 0 17 15" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.77726 1.02777e-06C2.78897 1.02777e-06 2.80072 1.02777e-06 2.81251 1.02777e-06H13.3478C13.8479 -2.14722e-05 14.2756 -4.39603e-05 14.6174 0.043066C14.9798 0.0887935 15.3302 0.191469 15.6179 0.461431C15.9107 0.736156 16.0271 1.07892 16.0781 1.43554C16.1251 1.76313 16.1251 2.17048 16.125 2.63519V3.21759C16.125 3.58397 16.125 3.90071 16.0977 4.16483C16.0682 4.44905 16.0039 4.7157 15.8494 4.9717C15.6961 5.22578 15.4896 5.4102 15.2516 5.57553C15.0274 5.73128 14.7409 5.89253 14.404 6.0822L12.1972 7.32443C11.6948 7.60725 11.5199 7.7091 11.4032 7.81043C11.135 8.0433 10.9814 8.3016 10.9092 8.6253C10.8784 8.76368 10.875 8.9379 10.875 9.46718V11.5163C10.8751 12.1922 10.8751 12.7661 10.8056 13.2072C10.7315 13.6763 10.5599 14.1262 10.1099 14.4077C9.67005 14.6828 9.18563 14.6575 8.71485 14.5457C8.26148 14.438 7.70273 14.2196 7.0323 13.9574L6.96713 13.932C6.6531 13.8092 6.37808 13.7018 6.16039 13.5893C5.92643 13.4685 5.70915 13.3182 5.54291 13.0843C5.37481 12.8477 5.30741 12.594 5.27736 12.3347C5.24996 12.0983 5.24998 11.8145 5.25 11.498V9.46718C5.25 8.9379 5.24666 8.76368 5.21582 8.6253C5.14365 8.3016 4.99007 8.0433 4.72188 7.81043C4.60511 7.7091 4.43019 7.60725 3.92786 7.32443L1.72103 6.0822C1.38412 5.89253 1.09765 5.73128 0.873437 5.57553C0.635432 5.4102 0.428934 5.22578 0.275604 4.9717C0.121112 4.7157 0.0567841 4.44905 0.0273391 4.16483C-2.84482e-05 3.90071 -1.34696e-05 3.58397 1.53039e-06 3.21759L9.04058e-06 2.6735C9.04058e-06 2.66068 1.53039e-06 2.64791 1.53039e-06 2.63518C-2.84696e-05 2.17047 -6.596e-05 1.76313 0.046884 1.43554C0.0979815 1.07892 0.214322 0.736156 0.507137 0.461431C0.794874 0.191469 1.14521 0.0887935 1.50768 0.043066C1.84944 -4.39603e-05 2.27705 -2.14722e-05 2.77726 1.02777e-06ZM1.64847 1.15922C1.39823 1.19079 1.31865 1.24268 1.27688 1.28187C1.24019 1.31629 1.19178 1.37689 1.16051 1.59512C1.12636 1.83341 1.12501 2.15901 1.12501 2.6735V3.19086C1.12501 3.59152 1.1257 3.84959 1.14635 4.04891C1.16558 4.23454 1.1986 4.3238 1.23881 4.39043C1.28018 4.45899 1.34888 4.536 1.51526 4.65157C1.69055 4.77333 1.93002 4.90881 2.29495 5.11424L4.47972 6.3441C4.50018 6.35565 4.52033 6.36698 4.54018 6.37815C4.9592 6.61388 5.24459 6.77445 5.4594 6.9609C5.90292 7.34595 6.18748 7.81365 6.31385 8.3805C6.37527 8.65598 6.37517 8.96483 6.37502 9.40088C6.37502 9.42263 6.375 9.44475 6.375 9.46718V11.4693C6.375 11.8235 6.37588 12.0413 6.39488 12.2052C6.41207 12.3535 6.43914 12.4034 6.45998 12.4327C6.48269 12.4646 6.52768 12.5129 6.6765 12.5897C6.8358 12.672 7.05533 12.7586 7.4019 12.894C8.12265 13.1758 8.60745 13.3639 8.9748 13.4511C9.33375 13.5364 9.45203 13.4922 9.51323 13.4539C9.56423 13.422 9.64298 13.3573 9.69428 13.032C9.74835 12.689 9.75 12.2051 9.75 11.4693V9.46718C9.75 9.44475 9.75 9.42263 9.75 9.40088C9.74985 8.96483 9.7497 8.65598 9.81113 8.3805C9.9375 7.81365 10.2221 7.34595 10.6656 6.9609C10.8804 6.77445 11.1658 6.61388 11.5848 6.37815C11.6047 6.36698 11.6249 6.35565 11.6453 6.3441L13.8301 5.11424C14.195 4.90881 14.4345 4.77333 14.6098 4.65157C14.7761 4.536 14.8448 4.45899 14.8862 4.39043C14.9264 4.3238 14.9594 4.23454 14.9786 4.04891C14.9993 3.84959 15 3.59152 15 3.19086V2.6735C15 2.15901 14.9987 1.83341 14.9645 1.59512C14.9333 1.37689 14.8848 1.31629 14.8481 1.28187C14.8064 1.24268 14.7268 1.19079 14.4766 1.15922C14.2136 1.12606 13.8578 1.125 13.3125 1.125H2.81251C2.26723 1.125 1.91141 1.12606 1.64847 1.15922Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <span>Find Solutions</span>
                            </a>
                        @endif

                        @foreach ($displayCategories as $cat)
                            <a href="#cat-{{ $cat->id }}" class="mobile-cat-pill {{ $loop->first ? 'active' : '' }}">
                                <span class="mobile-cat-pill__icon">
                                    @if (strpos($cat->icon_class, '<svg') !== false)
                                        {!! $cat->icon_class !!}
                                    @elseif($cat->icon_class)
                                        <i class="{{ $cat->icon_class }}"></i>
                                    @elseif($cat->icon)
                                        {!! $cat->icon->code !!}
                                    @else
                                        <i class="bi bi-box"></i>
                                    @endif
                                </span>
                                <span>{{ $cat->category_name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>



                @foreach ($displayCategories as $cat)
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
                        @if (
                            !empty($catFeatures) &&
                                is_array($catFeatures) &&
                                count($catFeatures) > 0 &&
                                (isset($cat->show_features_on_category_page) ? $cat->show_features_on_category_page : true) &&
                                ($settings['show_category_features_globally'] ?? 1))
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
                                <div class="{{ $adSliders->count() > 0 ? 'col-md-6' : 'col-md-4' }}">

                                    <div class="solution-card">
                                        <img class="card-img-bg"
                                            src="{{ $sub->image ? getImageCacheUrl($sub->image, 110, 410, 'webp') : theme_asset('img/apartments.jpg') }}"
                                            alt="{{ $sub->category_name }}" loading="lazy">
                                        <div class="card-gradient-overlay"></div>
                                        <div class="card-content">
                                            <div class="card-icon-wrapper">
                                                @if (strpos($sub->icon_class, '<svg') !== false)
                                                    {!! $sub->icon_class !!}
                                                @elseif($sub->icon_class)
                                                    <i class="{{ $sub->icon_class }}"></i>
                                                @elseif($sub->icon)
                                                    {!! $sub->icon->code !!}
                                                @else
                                                    <i class="bi bi-box"></i>
                                                @endif
                                            </div>
                                            <h3 class="card-title fs-20">{{ $sub->category_name }}</h3>
                                            <span class="badge-custom">{{ strtoupper($cat->category_name) }}</span>
                                            <p class="card-desc">{{ getLimitedText($sub->description) }}</p>
                                            <a href="{{ route('category.detail', $sub->slug ?: ($sub->id ?: 'all')) }}"
                                                class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                                    class="bi bi-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </section>

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
