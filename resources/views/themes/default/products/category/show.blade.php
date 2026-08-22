@extends('themes.default.layouts.master')

@section('title', 'Aire | ' . ($category->category_name ?? 'Category'))

@push('styles')
    <link rel="stylesheet" href="{{ theme_asset('css/product.css') }}">
@endpush

@section('content')
    <main class="container main-container">
        <h1 class="d-none">{{ $category->category_name ?? 'Category' }}</h1>
        <div class="row g-0">
            <!-- Left Sidebar Navigation -->
            <aside class="col-lg-3 d-none d-lg-block border-right1px pe-lg-4">
                <nav class="sidebar-menu sticky-sidebar" data-lenis-prevent>
                    @foreach ($categories as $cat)
                        <a href="{{ route('category.show', $cat->slug ?? $cat->id) }}"
                            class="menu-item {{ isset($category) && $category->id == $cat->id ? 'active' : '' }}">
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
                </nav>
            </aside>

            <!-- Center Feed: Active Category & Subcategories -->
            <section class="col-lg-9 col-xl-6 center-feed pb-5 px-lg-4">
                <div class="content-section mb-5 pb-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h2 class="section-title title-1 mb-0">{{ $category->category_name }}</h2>
                        <a href="{{ route('categories') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="bi bi-arrow-left me-1"></i> All Categories
                        </a>
                    </div>
                    <p class="section-subtitle mt-3 mb-4 pb-2 text-muted fs-16 lh-base">
                        {{ $category->description ?? 'Explore our complete range of specialized solutions and high-performance equipment.' }}
                    </p>

                    <!-- Subcategories Grid -->
                    @if ($category->children && $category->children->count() > 0)
                        <div class="row g-4">
                            @foreach ($category->children as $sub)
                                <div class="col-md-6">
                                    <div class="solution-card">
                                        <img class="card-img-bg"
                                            src="{{ $sub->image ? getImagePath($sub->image) : theme_asset('img/apartments.jpg') }}"
                                            alt="{{ $sub->category_name }}">
                                        <div class="card-gradient-overlay"></div>
                                        <div class="card-content">
                                            <h3 class="card-title mb-4 fs-24">{{ $sub->category_name }}</h3>
                                            <p class="card-spec-list">{{ getLimitedText($sub->description) }}</p>
                                            <a href="{{ route('category.show', $sub->slug ?? $sub->id) }}"
                                                class="card-link fs-12 mt-auto">
                                                EXPLORE SOLUTIONS <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- No Subcategories Notice / Direct Products Redirect -->
                        <div class="p-5 text-center bg-light rounded-4 border border-light-subtle">
                            <i class="bi bi-grid-3x3-gap text-primary display-4 mb-3 d-block"></i>
                            <h4 class="fw-bold mb-2">Browse All Products in {{ $category->category_name }}</h4>
                            <p class="text-muted small mb-4">View technical specifications, products, and available models
                                for {{ $category->category_name }}.</p>
                            <a href="{{ route('products.filter', $category->id) }}"
                                class="btn btn-primary rounded-pill px-4 fw-bold">
                                View Products <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Right Sidebar Feature -->
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
                                        alt="Featured">
                                </div>
                                <div class="featured-content pb-5">
                                    <h3 class="mb-2">The Future of Pure Living</h3>
                                    <p class="text-muted mb-2 lh-base">Experience the pinnacle of air technology seamlessly
                                        integrated into your architectural vision.</p>
                                    <a href="{{ route('categories') }}"
                                        class="btn btn-primary w-100 fw-bold shadow-sm featured-btn">VIEW PRODUCTS</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination position-absolute bottom-2"></div>
                    </div>
                </div>
            </aside>
        </div>
    </main>
@endsection
