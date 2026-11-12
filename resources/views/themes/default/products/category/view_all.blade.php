@extends('themes.default.layouts.master')

@php
    $catTitle = !empty($currentCategory->meta_title)
        ? $currentCategory->meta_title
        : ($currentCategory->category_name . ' | All Solutions - Aire');
    $catDescription = !empty($currentCategory->meta_description)
        ? $currentCategory->meta_description
        : (!empty($currentCategory->description)
            ? $currentCategory->description
            : ('Explore all official AIRE ' . $currentCategory->category_name . ' products, specifications, and engineered solutions.'));
    $catKeywords = !empty($currentCategory->meta_keywords)
        ? $currentCategory->meta_keywords
        : ('aire, ' . strtolower($currentCategory->category_name) . ', air purifier, hvac, clean air, fresh air system');
    $catImage = !empty($currentCategory->image) ? getImagePath($currentCategory->image) : null;
@endphp

@section('title', $catTitle)
@section('meta_description', $catDescription)
@if (!empty($catKeywords))
    @section('meta_keywords', $catKeywords)
@endif
@if (!empty($catImage))
    @section('og_image', $catImage)
@endif
@section('canonical_url', route('category.all', $currentCategory->slug ?: $currentCategory->id))
@section('meta_robots', !empty($search) ? 'noindex, follow' : 'index, follow')

@push('head')
    {{-- Schema.org CollectionPage & BreadcrumbList for Rich Snippets --}}
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => $currentCategory->category_name . ' - All Solutions',
        'description' => $catDescription,
        'url' => route('category.all', $currentCategory->slug ?: $currentCategory->id),
        'breadcrumb' => [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => route('home'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Products',
                    'item' => route('category.show', 'products'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $currentCategory->category_name,
                    'item' => route('category.all', $currentCategory->slug ?: $currentCategory->id),
                ],
            ],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@push('styles')
    <link rel="stylesheet"
        href="{{ theme_asset('css/product.css') }}?v={{ file_exists(public_path('themes/default/assets/css/product.min.css')) ? filemtime(public_path('themes/default/assets/css/product.min.css')) : time() }}">
    <style>
        .category-breadcrumb {
            font-size: 13px;
            font-weight: 500;
        }

        .category-breadcrumb .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 0;
        }

        .category-breadcrumb .breadcrumb-item a {
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .category-breadcrumb .breadcrumb-item a:hover {
            color: var(--color-primary, #0095DA);
        }

        .category-breadcrumb .breadcrumb-item.active {
            color: #0f172a;
            font-weight: 600;
        }

        .category-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            color: #94a3b8;
            padding-right: 0.5rem;
            padding-left: 0.5rem;
        }

        .category-viewall-header-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            padding: 22px 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04);
            transition: box-shadow 0.25s ease;
        }

        .category-badge-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: #eff6ff;
            color: var(--color-primary, #0095DA);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            border: 1px solid #dbeafe;
        }

        .category-page-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.3px;
            line-height: 1.25;
            white-space: nowrap;
        }

        @media (max-width: 575.98px) {
            .category-page-title {
                font-size: 18px;
                white-space: normal;
            }
        }

        .category-page-subtitle {
            font-size: 14px;
            color: #64748b;
            line-height: 1.55;
            margin-bottom: 0;
        }

        .category-search-wrap {
            position: relative;
            width: 100%;
            max-width: 280px;
        }

        @media (max-width: 767.98px) {
            .category-search-wrap {
                max-width: 100%;
            }
        }

        .category-search-wrap .form-control {
            border-radius: 20px;
            border: 1.5px solid #e2e8f0;
            background-color: #ffffff;
            padding: 8px 36px 8px 36px;
            font-size: 13.5px;
            color: #0f172a;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            transition: all 0.2s ease;
        }

        .category-search-wrap .form-control:focus {
            border-color: var(--color-primary, #0095DA);
            box-shadow: 0 0 0 3px rgba(0, 149, 218, 0.15);
            outline: none;
        }

        .category-search-wrap .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 13px;
            pointer-events: none;
        }

        .category-search-wrap .clear-search-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .category-search-wrap .clear-search-btn:hover {
            color: #ef4444;
        }

        .category-viewall-back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            padding: 7px 14px;
            border-radius: 20px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .category-viewall-back-link:hover {
            color: var(--color-primary, #0095DA);
            border-color: #cbd5e1;
            background-color: #f1f5f9;
        }

        .center-feed {
            padding-top: 20px;
        }

        .pagination-wrap .pagination {
            justify-content: center;
            gap: 4px;
        }
    </style>
@endpush

@section('content')
    @php
        $parentCat = $currentCategory->parent ?? null;
        $activeCategoryId = $currentCategory->id;
        $parentCategoryId = $parentCat?->id;

        // Dynamic Overview URL: returns to parent category overview page or main categories page
        $overviewUrl = $parentCat
            ? route('category.show', $parentCat->slug ?: $parentCat->id)
            : route('categories');

        // Build ancestor list for breadcrumbs avoiding duplicates
        $ancestors = collect();
        $curr = $currentCategory->parent;
        $seen = [$currentCategory->id];
        while ($curr && !in_array($curr->id, $seen)) {
            $seen[] = $curr->id;
            $ancestors->prepend($curr);
            $curr = $curr->parent;
        }
    @endphp

    {{-- Layout Pipeline Slot: Before Catalog Content (Top Promo Banner / Seasonal Showcase) --}}
    @renderPageSlot('category', 'before:catalog_content')

    <main class="container main-container">
        <h1 class="d-none">{{ $currentCategory->category_name }} - All Solutions</h1>

        <div class="row g-0">
            <!-- Left Sidebar Navigation -->
            <aside class="col-lg-3 d-none d-lg-block border-right1px pe-lg-4">
                <nav class="sidebar-menu sticky-sidebar" data-lenis-prevent>
                    <a href="{{ $overviewUrl }}" class="menu-item--special">
                        <span class="special-icon">
                            <img src="{{ theme_asset('img/products-icon.png') }}" width="24" height="24"
                                alt="Products" loading="lazy" decoding="async">
                        </span>
                        <span>{{ $parentCat ? $parentCat->category_name : 'All Categories' }}</span>
                        <i class="bi bi-chevron-right chevron"></i>
                    </a>
                    <hr class="sidebar-divider mb-3">

                    @foreach ($allCategories as $cat)
                        @php
                            $isCatActive = $cat->id === $activeCategoryId || $cat->id === $parentCategoryId;
                        @endphp
                        <a href="{{ route('category.all', $cat->slug ?: $cat->id) }}"
                            class="menu-item {{ $isCatActive ? 'active' : '' }}">
                            <div class="icon-box">
                                <x-category-icon :category="$cat" />
                            </div>
                            <div class="text-box">
                                <h2 class="mb-0">{{ $cat->category_name }}</h2>
                                <small
                                    class="d-block mt-1">{{ \Illuminate\Support\Str::limit($cat->description ?? 'VIEW PRODUCT', 50) }}</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto chevron"></i>
                        </a>
                    @endforeach

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
                </nav>
            </aside>

            <!-- Center Feed: Dedicated Category View-All -->
            <section class="col-lg-9 {{ $adSliders && $adSliders->count() > 0 ? 'col-xl-6' : 'col-xl-9' }} center-feed pb-5 px-lg-4">

                <!-- Breadcrumb Navigation -->
                <nav aria-label="breadcrumb" class="category-breadcrumb mb-3">
                    <ol class="breadcrumb mb-1 align-items-center" style="--bs-breadcrumb-divider: '›';">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        @if ($ancestors->isEmpty())
                            <li class="breadcrumb-item">
                                <a href="{{ route('categories') }}">Categories</a>
                            </li>
                        @else
                            @foreach ($ancestors as $anc)
                                <li class="breadcrumb-item">
                                    <a href="{{ route('category.show', $anc->slug ?: $anc->id) }}">
                                        {{ $anc->category_name }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{ $currentCategory->category_name }}</li>
                    </ol>
                </nav>

                <!-- Mobile Horizontal Category Scroll Bar -->
                <div class="d-lg-none mobile-category-scroll-wrapper" data-lenis-prevent>
                    <div class="mobile-category-scroll-track" data-lenis-prevent>
                        <a href="{{ $overviewUrl }}" class="mobile-cat-pill">
                            <span class="mobile-cat-pill__icon">
                                <img src="{{ theme_asset('img/products-icon.png') }}" width="15" height="15"
                                    alt="Products" loading="lazy" decoding="async">
                            </span>
                            <span>All</span>
                        </a>
                        @foreach ($allCategories as $cat)
                            @php
                                $isCatActive = $cat->id === $activeCategoryId || $cat->id === $parentCategoryId;
                            @endphp
                            <a href="{{ route('category.all', $cat->slug ?: $cat->id) }}"
                                class="mobile-cat-pill {{ $isCatActive ? 'active' : '' }}">
                                <span class="mobile-cat-pill__icon">
                                    <x-category-icon :category="$cat" />
                                </span>
                                <span>{{ $cat->category_name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Category Info Header Card -->
                <div class="category-viewall-header-card">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 pb-3 border-bottom mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="category-badge-icon">
                                <x-category-icon :category="$currentCategory" />
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <h1 class="category-page-title mb-0">{{ $currentCategory->category_name }}</h1>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2.5 py-1 fs-12 fw-bold">
                                        {{ $products->total() }} {{ \Illuminate\Support\Str::plural('Solution', $products->total()) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- In-Category Search Form & Back Link -->
                        <div class="d-flex align-items-center gap-2 w-100 w-md-auto flex-shrink-0">
                            <form action="{{ route('category.all', $currentCategory->slug ?: $currentCategory->id) }}" method="GET" class="category-search-wrap">
                                <i class="bi bi-search search-icon"></i>
                                <input type="text" name="search" value="{{ $search }}" class="form-control"
                                    placeholder="Search in {{ $currentCategory->category_name }}..."
                                    aria-label="Search within {{ $currentCategory->category_name }}">
                                @if (!empty($search))
                                    <a href="{{ route('category.all', $currentCategory->slug ?: $currentCategory->id) }}" class="clear-search-btn" title="Clear Search">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </a>
                                @endif
                            </form>
                            <a href="{{ $overviewUrl }}" class="category-viewall-back-link">
                                <i class="bi bi-arrow-left"></i> Overview
                            </a>
                        </div>
                    </div>

                    @if (!empty($currentCategory->description))
                        <p class="category-page-subtitle">
                            {{ $currentCategory->description }}
                        </p>
                    @endif

                    <!-- Search Active Notification Banner -->
                    @if (!empty($search))
                        <div class="alert alert-light border d-flex justify-content-between align-items-center py-2 px-3 mt-3 mb-0 rounded-3">
                            <span class="fs-13 text-muted">
                                Showing results for "<strong class="text-dark">{{ $search }}</strong>" in {{ $currentCategory->category_name }}:
                                <strong>{{ $products->total() }}</strong> found
                            </span>
                            <a href="{{ route('category.all', $currentCategory->slug ?: $currentCategory->id) }}" class="text-decoration-none fs-12 fw-bold text-danger">
                                <i class="bi bi-x-circle me-1"></i> Clear Filter
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Layout Pipeline Slot: After Category Info Header --}}
                @renderPageSlot('category', 'after:catalog_header')

                <!-- Products Showcase Grid: Option B (ductless_feature_card) -->
                <div class="row g-4 mb-4">
                    @forelse ($products as $product)
                        <div class="col-12 {{ !$loop->last ? 'border-bottom pb-4' : '' }}">
                            @include('themes.default.partials.ductless_feature_card', [
                                'product' => $product,
                            ])
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center">
                            <div class="p-5 bg-white rounded-4 border border-light-subtle shadow-sm">
                                <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                                <h4 class="fw-bold text-dark mb-2">No solutions found</h4>
                                <p class="text-muted small mb-3">
                                    @if (!empty($search))
                                        No products matched "{{ $search }}" in {{ $currentCategory->category_name }}.
                                    @else
                                        There are currently no products published in {{ $currentCategory->category_name }}.
                                    @endif
                                </p>
                                @if (!empty($search))
                                    <a href="{{ route('category.all', $currentCategory->slug ?: $currentCategory->id) }}"
                                        class="btn btn-sm btn-primary rounded-pill px-3">
                                        View all in {{ $currentCategory->category_name }}
                                    </a>
                                @else
                                    <a href="{{ $overviewUrl }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        Browse all {{ $parentCat ? $parentCat->category_name : 'categories' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="pagination-wrap my-4">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                @endif

                {{-- Layout Pipeline Slot: After Product Showcase Grid & Pagination --}}
                @renderPageSlot('category', 'after:product_grid')

            </section>

            @if ($adSliders && $adSliders->count() > 0)
                <!-- Right Sidebar Feature -->
                <aside class="col-lg-12 col-xl-3 d-none d-xl-block border-left1px">
                    @include('themes.default.partials.ad_slider')
                </aside>
            @endif
        </div>
    </main>

    {{-- Layout Pipeline Slot: Bottom of Catalog Page --}}
    @renderPageSlot('category', 'after:catalog_content')
@endsection
