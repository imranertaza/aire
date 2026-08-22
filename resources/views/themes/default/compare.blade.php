@extends('themes.default.layouts.master')

@section('title', 'Compare Products | Aire')

@push('styles')
    <link rel="stylesheet" href="{{ theme_asset('css/compare.css') }}">
    <style>
        .btn-add-product-dashed {
            width: 100%;
            border: 2px dashed #cbd5e1;
            background: transparent;
            color: #475569;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-add-product-dashed:hover {
            border-color: #0f172a;
            color: #0f172a;
            background: #f8fafc;
        }
    </style>
@endpush

@section('content')
    @php
        $count = $comparedProducts->count();
        $colNum = $count > 0 ? (int) floor(12 / min(max($count, 1), 3)) : 12;
        $colClass = 'col-' . $colNum;

        // Extract unique attribute names across compared products
        $allAttributeNames = collect();
        foreach ($comparedProducts as $p) {
            if ($p->productAttributes) {
                foreach ($p->productAttributes as $attr) {
                    if (!empty($attr->name)) {
                        $allAttributeNames->push($attr->name);
                    }
                }
            }
        }
        $allAttributeNames = $allAttributeNames->unique()->values();

        if ($allAttributeNames->isEmpty()) {
            $allAttributeNames = collect(['CADR Rating', 'Filter Grade', 'Coverage Area', 'Weight', 'Dimensions']);
        }
    @endphp

    <!-- Main Content -->
    <main class="">
        <h1 class="d-none">Compare</h1>
        <div class="container main-container border-top border-light">

            <!-- Unified 3-Column Layout with Full Height Sticky Right Sidebar -->
            <div class="row g-0">

                <!-- LEFT COLUMN: Breadcrumb, Products To Compare & Spec Labels (col-lg-3) -->
                <aside class="col-lg-3 border-right1px pt-4 pe-lg-4">

                    <!-- Breadcrumb -->
                    <div class="breadcrumb-container pb-3 mb-4 border-bottom border-light-subtle">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 fs-14 fw-medium">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"
                                        class="text-muted text-decoration-none">Home</a></li>
                                <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">Compare</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Products To Compare Box -->
                    <div class="sidebar-compare-card mb-4">
                        <h2 class="sidebar-compare-title">PRODUCTS TO COMPARE</h2>

                        @forelse($comparedProducts as $p)
                            <!-- Item -->
                            <div class="sidebar-compare-item" id="sidebar-item-{{ $p->id }}">
                                <div class="sidebar-compare-thumb">
                                    <img src="{{ getImageUrl($p->main_image) }}" alt="{{ $p->name }}"
                                        class="img-fluid">
                                </div>
                                <div class="sidebar-compare-info">
                                    <p class="sidebar-compare-name">{{ $p->name }}</p>
                                    <a href="javascript:void(0);" class="sidebar-compare-remove btn-remove-compare"
                                        data-product-id="{{ $p->id }}">Remove</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small p-2">No products added for comparison.</p>
                        @endforelse

                        <!-- Add Product Dashed Button -->
                        <button type="button" class="btn-add-product-dashed mt-2" data-bs-toggle="modal"
                            data-bs-target="#addCompareModal">
                            + Add Another Product
                        </button>
                    </div>

                    <!-- Feature Specification Labels -->
                    @if ($comparedProducts->isNotEmpty())
                        <div class="compare-spec-labels-sidebar">
                            <!-- Section 1: Specifications -->
                            <div class="spec-section-hdr border-top-0">TECHNICAL SPECIFICATIONS</div>
                            @foreach ($allAttributeNames as $attrName)
                                <div class="spec-label-row">{{ $attrName }}</div>
                            @endforeach

                            <!-- Section 2: Pricing & Stock -->
                            <div class="spec-section-hdr">PRICING &amp; AVAILABILITY</div>
                            <div class="spec-label-row">Unit Price</div>
                            <div class="spec-label-row">Stock Status</div>
                        </div>
                    @endif

                </aside>

                <!-- CENTER COLUMN: Title, Product Cards, Spec Matrix & Banners (col-lg-6) -->
                <section class="col-lg-6 pt-3 px-lg-4 center-feed pb-5">

                    <!-- Title & Clear All Row -->
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div>
                            <h1 class="title-2 mb-1">Compare Products</h1>
                            <p class="fs-14 text-muted mb-0">Compare up to 3 AIRE systems side by side to find the perfect
                                fit for your environment.</p>
                        </div>
                        <button type="button" class="btn-clear-all" id="btn-clear-all-compare">
                            <i class="bi bi-trash"></i> Clear All
                        </button>
                    </div>

                    <!-- Top Product Cards Container -->
                    <div class="checkout-card mb-4 bg-white overflow-hidden border">
                        <div class="row g-0 align-items-stretch">
                            @forelse($comparedProducts as $p)
                                <!-- Product Card -->
                                <div
                                    class="{{ $colClass }} p-3 border-end position-relative d-flex flex-column justify-content-between compare-top-card">
                                    <button type="button" class="prod-close-btn btn-remove-compare"
                                        data-product-id="{{ $p->id }}" aria-label="Remove">&times;</button>
                                    <div class="d-flex flex-column">
                                        <div class="compare-prod-img-box">
                                            <img src="{{ getImageUrl($p->main_image) }}" alt="{{ $p->name }}"
                                                class="compare-prod-img">
                                        </div>
                                        <h2 class="compare-prod-title" title="{{ $p->name }}">{{ $p->name }}
                                        </h2>
                                        <p class="compare-prod-tag"
                                            title="{{ $p->model ?? ($p->categories->first()->category_name ?? 'Air Purifier') }}">
                                            {{ $p->model ?? ($p->categories->first()->category_name ?? 'Air Purifier') }}
                                        </p>
                                        <div class="compare-prod-rating">
                                            <span class="fw-bold text-dark">4.9</span> <i
                                                class="bi bi-star-fill compare-star-icon"></i> <span
                                                class="text-muted">({{ $p->quantity > 0 ? 'In Stock' : 'Out of Stock' }})</span>
                                        </div>
                                        <div class="compare-prod-price">${{ number_format($p->price, 2) }}</div>
                                    </div>
                                    <div class="mt-auto pt-2">
                                        <button type="button"
                                            class="btn btn-primary w-100 rounded-3 py-2 fs-14 fw-semibold d-flex align-items-center justify-content-center gap-2 btn-compare-buy"
                                            data-product-id="{{ $p->id }}">
                                            <i class="bi bi-cart2"></i> Buy Now
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 p-4 text-center text-muted">
                                    <p class="mb-0">No products selected for comparison yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Specification Matrix Table & Banners Section -->
                    @if ($comparedProducts->isNotEmpty())
                        <!-- Spec Matrix Values Card -->
                        <div class="checkout-card mb-4 bg-white overflow-hidden border">
                            <div class="spec-matrix-values">
                                <!-- Header Spacer -->
                                <div class="spec-val-header-spacer"></div>

                                @foreach ($allAttributeNames as $attrName)
                                    <div class="row g-0 spec-val-row">
                                        @foreach ($comparedProducts as $p)
                                            @php
                                                $attrObj = $p->productAttributes
                                                    ? $p->productAttributes->firstWhere('name', $attrName)
                                                    : null;
                                                $val = $attrObj?->details;
                                            @endphp
                                            <div class="{{ $colClass }} text-center fs-14 text-dark border-end px-2">
                                                @if ($val)
                                                    {{ $val }}
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach

                                <!-- Pricing Section Header Spacer -->
                                <div class="spec-val-header-spacer"></div>

                                <div class="row g-0 spec-val-row">
                                    @foreach ($comparedProducts as $p)
                                        <div class="{{ $colClass }} text-center fs-14 fw-bold text-dark border-end">
                                            ${{ number_format($p->price, 2) }}
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row g-0 spec-val-row">
                                    @foreach ($comparedProducts as $p)
                                        <div class="{{ $colClass }} text-center fs-14 border-end">
                                            @if ($p->quantity > 0)
                                                <span
                                                    class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-12">In
                                                    Stock</span>
                                            @else
                                                <span
                                                    class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-12">Out
                                                    of Stock</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        <!-- Expert Advice Banner -->
                        <div class="expert-advice-banner">
                            <div class="d-flex align-items-center gap-3">
                                <div class="expert-icon-circle">
                                    <i class="bi bi-question-circle"></i>
                                </div>
                                <div>
                                    <h4 class="fs-16 fw-bold text-dark mb-1">Not sure which one to choose?</h4>
                                    <p class="fs-13 text-muted mb-0">Our experts can help you find the perfect fit for your
                                        environment.</p>
                                </div>
                            </div>
                            <a href="{{ route('contact') }}" class="btn-advice-action text-decoration-none">
                                Contact Support
                            </a>
                        </div>

                        <!-- Trust Badges 2x3 Grid -->
                        <div class="row g-4 my-4 center-feed">
                            <div class="col-6 trust-feature-item">
                                <i class="bi bi-shield-check trust-feature-icon"></i>
                                <h4 class="trust-feature-title">SECURE PAYMENTS</h4>
                                <p class="trust-feature-desc">100% secure and encrypted payments.</p>
                            </div>
                            <div class="col-6 trust-feature-item">
                                <i class="bi bi-box-seam trust-feature-icon"></i>
                                <h4 class="trust-feature-title">FREE SHIPPING</h4>
                                <p class="trust-feature-desc">On all orders over $150.</p>
                            </div>
                            <div class="col-6 trust-feature-item">
                                <i class="bi bi-arrow-repeat trust-feature-icon"></i>
                                <h4 class="trust-feature-title">30-DAY RETURNS</h4>
                                <p class="trust-feature-desc">Hassle-free returns within 30 days.</p>
                            </div>
                            <div class="col-6 trust-feature-item">
                                <i class="bi bi-award trust-feature-icon"></i>
                                <h4 class="trust-feature-title">1 YEAR WARRANTY</h4>
                                <p class="trust-feature-desc">Full protection and quality assurance.</p>
                            </div>
                            <div class="col-6 trust-feature-item">
                                <i class="bi bi-headset trust-feature-icon"></i>
                                <h4 class="trust-feature-title">DEDICATED SUPPORT</h4>
                                <p class="trust-feature-desc">Expert assistance whenever you need it.</p>
                            </div>
                        </div>
                    @endif

                </section>

                <!-- RIGHT COLUMN: Sticky Featured Solution Promo Card (col-lg-3) -->
                <aside class="col-lg-3 border-left1px pt-3 ps-lg-4 d-none d-lg-block">
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

        </div>
    </main>

    <!-- Add Product to Compare Modal -->
    <div class="modal fade" id="addCompareModal" tabindex="-1" aria-labelledby="addCompareModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="addCompareModalLabel">Add Product to Compare</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" id="compare-search-input" class="form-control border-start-0 ps-0"
                            placeholder="Search products by name or model...">
                    </div>
                    <div id="compare-search-results" class="list-group list-group-flush max-vh-50 overflow-y-auto">
                        <p class="text-muted small text-center py-3">Type above to search products...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            // Dynamic Search & Select in Add Product Modal
            const searchInput = document.getElementById('compare-search-input');
            const searchResults = document.getElementById('compare-search-results');

            if (searchInput && searchResults) {
                let timer = null;
                searchInput.addEventListener('input', function() {
                    clearTimeout(timer);
                    const query = this.value.trim();
                    if (query.length < 1) {
                        searchResults.innerHTML =
                            '<p class="text-muted small text-center py-3">Type above to search products...</p>';
                        return;
                    }

                    timer = setTimeout(() => {
                        fetch(
                                `{{ route('product.dropdown') }}?search=${encodeURIComponent(query)}`
                            )
                            .then(res => {
                                if (!res.ok) throw new Error('Search failed');
                                return res.json();
                            })
                            .then(data => {
                                const products = data.data || [];
                                if (products.length === 0) {
                                    searchResults.innerHTML =
                                        '<p class="text-muted small text-center py-3">No matching products found.</p>';
                                    return;
                                }

                                let html = '';
                                products.forEach(p => {
                                    html += `
                            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 select-modal-prod" data-id="${p.id}">
                                <div>
                                    <div class="fw-bold text-dark fs-14">${p.name}</div>
                                    <small class="text-muted">${p.model || ''}</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">+ Add</span>
                            </button>
                        `;
                                });
                                searchResults.innerHTML = html;

                                document.querySelectorAll('.select-modal-prod').forEach(
                                    itemBtn => {
                                        itemBtn.addEventListener('click', function() {
                                            const pId = this.getAttribute(
                                                'data-id');
                                            const csrfToken = document
                                                .querySelector(
                                                    'meta[name="csrf-token"]')
                                                ?.getAttribute('content') || '';

                                            fetch("{{ route('compare.add') }}", {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': csrfToken,
                                                        'Accept': 'application/json'
                                                    },
                                                    body: JSON.stringify({
                                                        product_id: pId
                                                    })
                                                })
                                                .then(r => r.json())
                                                .then(resData => {
                                                    if (resData.success) {
                                                        const modalEl = document
                                                            .getElementById(
                                                                'addCompareModal'
                                                            );
                                                        const modalInstance =
                                                            bootstrap.Modal
                                                            .getInstance(
                                                                modalEl);
                                                        if (modalInstance)
                                                            modalInstance
                                                            .hide();
                                                        window.location
                                                            .reload();
                                                    } else {
                                                        alert(resData.message ||
                                                            'Could not add product to comparison.'
                                                        );
                                                    }
                                                })
                                                .catch(err => {
                                                    console.error(
                                                        'Compare add error:',
                                                        err);
                                                    window.location.reload();
                                                });
                                        });
                                    });
                            })
                            .catch(err => console.error(err));
                    }, 250);
                });
            }
        });
    </script>
@endpush
