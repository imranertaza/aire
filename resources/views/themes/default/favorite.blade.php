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
            <div class="col-12 col-lg-9 {{ $adSliders->count() > 0 ? 'col-xl-6' : 'col-xl-9' }} px-lg-4 center-feed pt-2">

                <div class="d-flex align-items-center justify-content-between my-3">
                    <h2 class="title-2 mb-0">My Favorite Products</h2>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fs-13 fw-semibold">
                        {{ count($products) }} {{ \Illuminate\Support\Str::plural('Item', count($products)) }}
                    </span>
                </div>

                <!-- 2/3 Column Product Card Grid -->
                <div
                    class="row row-cols-1 {{ $adSliders->count() > 0 ? 'row-cols-md-2' : 'row-cols-md-3' }} g-3 product-grid mb-5">

                    @forelse ($products as $product)
                        @php
                            $inCart = isset(session('cart', [])[$product->id]);
                            $firstCat = $product->categories->first();
                            $catName = $firstCat?->category_name;
                            $catBg = $firstCat?->bg_color ?: '#00c853';
                        @endphp
                        <div class="col product-card-col" id="fav-item-{{ $product->id }}">
                            @include('themes.default.partials.product_card', ['isFavoritePage' => true])
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
