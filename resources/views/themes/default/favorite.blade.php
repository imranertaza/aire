@extends('themes.default.layouts.master')
@section('title', 'My Favorites | Aire')

@push('styles')
    <link href="{{ theme_asset('css/product-filter.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Main Container: 3 Column Layout like index.html -->
    <main class="container main-container product-filter-page__main">

        <div class="row g-0">

            <!-- Left Column: Filters Sidebar (col-lg-3) -->
            <aside class="col-12 col-lg-3 border-right1px pe-lg-4">

                <!-- Breadcrumb Navigation -->
                <nav class="breadcrumb-nav mb-3 py-3" aria-label="breadcrumb">
                    <a href="{{ route('products.filter') }}" class="breadcrumb-nav__link">Products</a>
                    <span class="breadcrumb-nav__separator">&gt;</span>
                    <span class="breadcrumb-nav__current">Favorite</span>
                </nav>

            </aside>

            <!-- Center Content Feed (col-lg-6) -->
            <div class="col-12 col-lg-6 px-lg-4 center-feed pt-2">

                <div class="d-flex align-items-center justify-content-between my-3">
                    <h2 class="title-2 mb-0">My Favorite Products</h2>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fs-13 fw-semibold">
                        {{ count($products) }} {{ \Illuminate\Support\Str::plural('Item', count($products)) }}
                    </span>
                </div>

                <!-- 2 Column Product Card Grid -->
                <div class="row row-cols-1 row-cols-md-2 g-3 product-grid mb-5">

                    @forelse ($products as $product)
                        @php
                            $inCart = isset(session('cart', [])[$product->id]);
                            $firstCat = $product->categories->first();
                            $catName = $firstCat?->category_name;
                            $catBg = $firstCat?->bg_color ?: '#00c853';
                        @endphp
                        <div class="col product-card-col" id="fav-item-{{ $product->id }}">
                            <div class="product-card position-relative h-100">
                                @if ($catName)
                                    <div class="product-card__badge-wrapper">
                                        <span class="product-card__badge-pill"
                                            style="background-color: {{ $catBg }};">
                                            {{ $catName }}
                                        </span>
                                    </div>
                                @endif
                                <!-- Quick Add to Cart button -->
                                <div class="product-card__labels position-absolute d-flex flex-column gap-2">
                                    <a href="javascript:void(0)" class="btn-add-to-cart {{ $inCart ? 'active' : '' }}"
                                        data-product-id="{{ $product->id }}" data-bs-toggle="tooltip"
                                        data-bs-placement="left" title="{{ $inCart ? 'In Cart' : 'Add to Cart' }}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17 18C17.5304 18 18.0391 18.2107 18.4142 18.5858C18.7893 18.9609 19 19.4696 19 20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22C16.4696 22 15.9609 21.7893 15.5858 21.4142C15.2107 21.0391 15 20.5304 15 20C15 18.89 15.89 18 17 18ZM1 2H4.27L5.21 4H20C20.2652 4 20.5196 4.10536 20.7071 4.29289C20.8946 4.48043 21 4.73478 21 5C21 5.17 20.95 5.34 20.88 5.5L17.3 11.97C16.96 12.58 16.3 13 15.55 13H8.1L7.2 14.63L7.17 14.75C7.17 14.8163 7.19634 14.8799 7.24322 14.9268C7.29011 14.9737 7.3537 15 7.42 15H19V17H7C6.46957 17 5.96086 16.7893 5.58579 16.4142C5.21071 16.0391 5 15.5304 5 15C5 14.65 5.09 14.32 5.24 14.04L6.6 11.59L3 4H1V2ZM7 18C7.53043 18 8.03914 18.2107 8.41421 18.5858C8.78929 18.9609 9 19.4696 9 20C9 20.5304 8.78929 21.0391 8.41421 21.4142C8.03914 21.7893 7.53043 22 7 22C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 20.5304 5 20.5304 5 20C5 18.89 5.89 18 7 18ZM16 11L18.78 6H6.14L8.5 11H16Z"
                                                fill="#0066CC" />
                                        </svg>
                                    </a>
                                    {{-- Compare Icon --}}
                                    <a href="javascript:void(0)" class="btn-add-to-compare"
                                        data-product-id="{{ $product->id }}" data-bs-toggle="tooltip"
                                        data-bs-placement="left" title="Add to Compare"
                                        style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:6px;border:1px solid #cbd5e1;background:#fff;color:#475569;transition:all .2s;">
                                        <i class="bi bi-bar-chart-steps" style="font-size:0.85rem;"></i>
                                    </a>
                                </div>

                                <!-- Product Image -->
                                <div class="product-card__image-wrapper">
                                    <a href="{{ route('products.detail', $product->slug ?: $product->id) }}">
                                        <img src="{{ getImageUrl($product->image) }}" alt="{{ $product->name }}"
                                            class="product-card__image">
                                    </a>
                                </div>

                                <!-- Product Title & Category -->
                                <h2 class="product-card__title">
                                    <a href="{{ route('products.detail', $product->slug ?: $product->id) }}"
                                        class="text-decoration-none text-dark">{{ $product->name }}</a>
                                </h2>
                                <div class="product-card__category text-uppercase">
                                    {{ $product->category->name ?? 'ENTERPRISE FILTRATION' }}</div>

                                <!-- Actions -->
                                <div class="product-card__actions justify-content-between">
                                    <a href="{{ route('products.detail', $product->slug ?: $product->id) }}"
                                        class="product-card__btn-buy text-decoration-none">Buy Now</a>
                                    <button type="button"
                                        class="product-card__btn-learn border-0 bg-transparent btn-remove-favorite"
                                        data-product-id="{{ $product->id }}">
                                        Remove
                                    </button>
                                </div>

                                <!-- Specs -->
                                <div class="product-card__specs">
                                    <div>
                                        <div class="product-card__spec-label">PRICE</div>
                                        <div class="product-card__spec-value">${{ number_format($product->price, 2) }}
                                        </div>
                                    </div>
                                    <div class="product-card__spec-item--align-end">
                                        <div class="product-card__spec-label">MODEL</div>
                                        <div class="product-card__spec-value">{{ $product->model ?? 'AIRE System' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center w-100">
                            <div class="p-5 bg-white border border-light-subtle rounded-4 shadow-sm">
                                <i class="bi bi-heartbreak fs-1 text-muted d-block mb-3"></i>
                                <h4 class="fw-bold text-dark fs-18">Your Wishlist is Empty</h4>
                                <p class="text-muted fs-14 mb-4">Explore our premium air purifiers and click the heart icon
                                    to save your favorite products.</p>
                                <a href="{{ route('products.filter') }}"
                                    class="btn btn-primary rounded-pill px-4 py-2 fs-14 fw-semibold">
                                    Explore Products
                                </a>
                            </div>
                        </div>
                    @endforelse

                </div>
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
    <script>
        window.addEventListener('load', function() {
            // Initialize Swiper for Right Sidebar Ads
            if (typeof Swiper !== 'undefined' && document.querySelector('.featured-swiper') && !document
                .querySelector('.featured-swiper').swiper) {
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

            if (typeof $ === 'undefined') return;

            const csrfToken = $('input[name="_token"]').val() || $('meta[name="csrf-token"]').attr('content');

            $('.btn-remove-favorite').on('click', function() {
                const productId = $(this).data('product-id');
                const $cardCol = $(`#fav-item-${productId}`);

                $.ajax({
                    url: '{{ route('favorite.toggle') }}',
                    method: 'POST',
                    data: {
                        _token: csrfToken,
                        product_id: productId
                    },
                    success: function(res) {
                        if (res.success) {
                            if (typeof window.updateHeaderBadges === 'function') {
                                window.updateHeaderBadges('favorite', res.favorites_count !==
                                    undefined ? res.favorites_count : res.count);
                            }
                            $cardCol.fadeOut(300, function() {
                                $(this).remove();
                                if ($('.product-card-col').length === 0) {
                                    location.reload();
                                }
                            });
                        }
                    }
                });
            });
        });
    @endpush
