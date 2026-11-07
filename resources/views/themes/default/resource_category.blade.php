@extends('themes.default.layouts.master')

@php
    $catTitle = !empty($category->meta_title) ? $category->meta_title : ($category->name . ' | AIRE Resources & Technical Documentation');
    $catDescription = !empty($category->meta_description) ? $category->meta_description : (!empty($category->description) ? $category->description : ('Explore all official AIRE ' . $category->name . ' documents, catalogs, manuals and technical files.'));
    $catKeywords = !empty($category->meta_keywords) ? $category->meta_keywords : ('aire, ' . strtolower($category->name) . ', air purifier, hvac, clean air, resources, specifications');
@endphp

@section('title', $catTitle)
@section('meta_description', $catDescription)
@section('meta_keywords', $catKeywords)
@section('canonical_url', route('resources.category', $category->slug))
@section('meta_robots', !empty($search) ? 'noindex, follow' : 'index, follow')

@push('head')
    {{-- Schema.org CollectionPage & BreadcrumbList for Google Rich Snippets --}}
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => $category->name . ' Resources',
        'description' => $catDescription,
        'url' => route('resources.category', $category->slug),
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
                    'name' => 'Resources',
                    'item' => route('resources'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $category->name,
                    'item' => route('resources.category', $category->slug),
                ],
            ],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ theme_asset('css/product.css') }}">
    <style>
        /* Resources Page Custom Styling matching Aire Design System & resources.blade.php */

        .resources-page-title {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.8px;
            line-height: 1.15;
        }

        .resources-page-subtitle {
            font-size: 14.5px;
            color: #64748b;
            max-width: 820px;
            line-height: 1.6;
            margin-bottom: 0;
        }

        .resources-search-wrap {
            position: relative;
            width: 100%;
            max-width: 320px;
        }

        .resources-search-wrap .form-control {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            background-color: #ffffff;
            padding: 10px 38px 10px 38px;
            font-size: 13.5px;
            color: #0f172a;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            transition: all 0.2s ease;
        }

        .resources-search-wrap .form-control:focus {
            border-color: var(--color-primary, #0095DA);
            box-shadow: 0 0 0 3px rgba(0, 149, 218, 0.15);
            outline: none;
        }

        .resources-search-wrap .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
        }

        .resources-search-wrap .clear-search-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .resources-search-wrap .clear-search-btn:hover {
            color: #ef4444;
        }

        /* Section Container Box */
        .resource-section-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            padding: 28px;
            margin-bottom: 32px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
            transition: box-shadow 0.25s ease;
        }

        .resource-section-card:hover {
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.07);
        }

        .resource-section-badge-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: #eff6ff;
            color: var(--color-primary, #0095DA);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            border: 1px solid #dbeafe;
        }

        /* 1. Brochure Item Cards */
        .brochure-card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #ffffff;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .brochure-card:hover {
            transform: translateY(-5px);
            border-color: #cbd5e1;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
        }

        .brochure-preview-box {
            position: relative;
            height: 200px;
            background: #f1f5f9;
            padding: 0;
            overflow: hidden;
        }

        .brochure-preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.35s ease;
        }

        .brochure-card:hover .brochure-preview-img {
            transform: scale(1.04);
        }

        .brochure-float-badge,
        .resource-float-badge {
            position: absolute;
            top: 0;
            left: 18px;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #ffffff;
            color: var(--color-primary, #0095DA);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.12);
            border: 1px solid #e2e8f0;
            z-index: 10;
        }

        .brochure-preview-box .brochure-float-badge,
        .resource-thumb-box .resource-float-badge {
            top: auto;
            bottom: 0;
            transform: translateY(50%);
        }

        .brochure-card-body .brochure-float-badge,
        .resource-thumb-body .resource-float-badge {
            top: 0;
            bottom: auto;
            transform: translateY(-50%);
        }

        .bi-ruler::before {
            content: "\f51a";
        }

        .brochure-card-body {
            position: relative;
            z-index: 2;
            background: #ffffff;
            padding: 26px 20px 20px 20px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .brochure-card-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
            letter-spacing: -0.2px;
            line-height: 1.35;
        }

        .brochure-card-desc {
            font-size: 12.5px;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 16px;
            flex: 1;
        }

        .brochure-download-btn {
            color: var(--color-primary, #0095DA);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            background: transparent;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .brochure-download-btn:hover {
            color: var(--color-primary-hover, #047cc2);
            transform: translateX(2px);
        }

        /* 2. Video Cards */
        .video-card-item {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #ffffff;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            cursor: pointer;
        }

        .video-card-item:hover {
            transform: translateY(-5px);
            border-color: #cbd5e1;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
        }

        .video-thumb-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
            overflow: hidden;
            background-color: #0f172a;
        }

        .video-thumb-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .video-card-item:hover .video-thumb-wrap img {
            transform: scale(1.05);
        }

        .video-play-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.78);
            backdrop-filter: blur(4px);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
            z-index: 2;
        }

        .video-card-item:hover .video-play-center {
            background: var(--color-primary, #0095DA);
            transform: translate(-50%, -50%) scale(1.12);
            box-shadow: 0 6px 18px rgba(0, 149, 218, 0.45);
        }

        .video-bar-bottom {
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ffffff;
        }

        .video-mini-pill {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #eff6ff;
            color: var(--color-primary, #0095DA);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .video-card-item:hover .video-mini-pill {
            background: var(--color-primary, #0095DA);
            color: #ffffff;
        }

        .video-bar-title {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0;
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .video-bar-chevron {
            color: #94a3b8;
            font-size: 12px;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .video-card-item:hover .video-bar-chevron {
            transform: translateX(3px);
            color: var(--color-primary, #0095DA);
        }

        /* 3. Resource Thumbnail & Category Navigation Cards */
        .resource-thumb-card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #ffffff;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }

        .resource-thumb-card:hover {
            transform: translateY(-5px);
            border-color: #cbd5e1;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
            color: inherit;
        }

        .resource-thumb-box {
            position: relative;
            height: 175px;
            background: #f8fafc;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .resource-thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.35s ease;
        }

        .resource-thumb-card:hover .resource-thumb-img {
            transform: scale(1.05);
        }

        .resource-thumb-graphic {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f0f7ff 0%, #e0effe 100%);
            color: var(--color-primary, #0095DA);
            font-size: 50px;
            transition: transform 0.35s ease;
        }

        .resource-thumb-card:hover .resource-thumb-graphic,
        .brochure-card:hover .resource-thumb-graphic {
            transform: scale(1.08);
        }

        .resource-thumb-graphic.graphic-clean {
            background: #f8fafc;
            color: var(--color-primary, #0095DA);
        }

        .resource-thumb-body {
            position: relative;
            z-index: 2;
            background: #ffffff;
            padding: 24px 18px 18px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex: 1;
        }

        .resource-thumb-title {
            font-size: 14.5px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0;
            letter-spacing: -0.2px;
            line-height: 1.35;
            flex: 1;
        }

        .resource-thumb-card:hover .resource-thumb-title {
            color: var(--color-primary, #0095DA);
        }

        .resource-thumb-chevron {
            color: var(--color-primary, #0095DA);
            font-size: 14px;
            font-weight: 700;
            transition: transform 0.2s ease;
            flex-shrink: 0;
        }

        .resource-thumb-card:hover .resource-thumb-chevron {
            transform: translateX(4px);
        }

        /* Toast Popup */
        .resource-toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #0f172a;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .resource-toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 991.98px) {
            .resources-page-title {
                font-size: 22px;
            }

            .resource-section-card {
                padding: 18px;
                border-radius: 14px;
            }

            .resources-search-wrap {
                max-width: 100%;
                margin-top: 14px;
            }
        }
    </style>
@endpush

@section('content')

    <div class="container main-container">

        <div class="row g-0">

            <!-- Left Sticky Sidebar Navigation (Desktop) -->
            <aside class="col-lg-3 d-none d-lg-block border-right1px pe-lg-4">
                <nav class="sidebar-menu sticky-sidebar" id="resourcesSidebar" data-lenis-prevent>
                    <a href="{{ route('resources') }}" class="menu-item">
                        <div class="icon-box">
                            <i class="bi bi-collection"></i>
                        </div>
                        <div class="text-box d-flex align-items-center justify-content-between w-100">
                            <h2 class="mb-0">Resources</h2>
                            <span class="badge rounded-pill bg-primary-subtle text-primary fw-bold fs-10 px-2 py-1">All</span>
                        </div>
                        <i class="bi bi-chevron-right ms-auto chevron"></i>
                    </a>

                    @foreach ($allCategories as $cat)
                        <a href="{{ route('resources.category', $cat->slug) }}"
                            class="menu-item {{ $cat->id === $category->id ? 'active' : '' }}">
                            <div class="icon-box">
                                <i class="{{ $cat->icon ?: 'bi bi-folder2' }}"></i>
                            </div>
                            <div class="text-box">
                                <h2 class="mb-0">{{ $cat->name }}</h2>
                                @if (!empty($cat->short_desc))
                                    <small>{{ $cat->short_desc }}</small>
                                @endif
                            </div>
                            <i class="bi bi-chevron-right ms-auto chevron"></i>
                        </a>
                    @endforeach

                    <a href="{{ route('contact') }}" class="menu-item">
                        <div class="icon-box">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div class="text-box">
                            <h2 class="mb-0">Contact Support</h2>
                            <small>24/7 technical assistance</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto chevron"></i>
                    </a>
                </nav>
            </aside>

            <!-- Center Content Area -->
            <section class="col-lg-9 center-feed pb-5 px-lg-4">

                <!-- Breadcrumb Navigation -->
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-1 align-items-center" style="--bs-breadcrumb-divider: '›'; font-size: 13.5px;">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('resources') }}" class="text-decoration-none text-muted">Resources</a>
                        </li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">
                            {{ $category->name }}
                        </li>
                    </ol>
                </nav>

                <!-- Mobile Horizontal Category Scroll Bar -->
                <div class="d-lg-none mobile-category-scroll-wrapper" data-lenis-prevent>
                    <div class="mobile-category-scroll-track" data-lenis-prevent>
                        <a href="{{ route('resources') }}" class="mobile-cat-pill">
                            <span class="mobile-cat-pill__icon"><i class="bi bi-collection"></i></span>
                            <span>All</span>
                        </a>
                        @foreach ($allCategories as $cat)
                            <a href="{{ route('resources.category', $cat->slug) }}"
                                class="mobile-cat-pill {{ $cat->id === $category->id ? 'active' : '' }}">
                                <span class="mobile-cat-pill__icon"><i class="{{ $cat->icon ?: 'bi bi-folder2' }}"></i></span>
                                <span>{{ $cat->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Category Header Card -->
                <div class="resource-section-card mb-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 pb-3 border-bottom mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="resource-section-badge-icon">
                                <i class="{{ $category->icon ?: 'bi bi-folder2' }}"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <h1 class="resources-page-title mb-0">{{ $category->name }}</h1>
                                    <span class="badge bg-light text-primary border rounded-pill px-2 py-1 fs-11 fw-bold">
                                        {{ $resources->total() }} {{ $resources->total() === 1 ? 'Item' : 'Items' }}
                                    </span>
                                </div>
                                <p class="resources-page-subtitle">
                                    {{ $category->description ?: 'Browse, view and download technical documents, guides and specifications.' }}
                                </p>
                            </div>
                        </div>

                        <!-- In-Category Search Form -->
                        <form action="{{ route('resources.category', $category->slug) }}" method="GET" class="resources-search-wrap">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" name="search" value="{{ $search }}" class="form-control"
                                placeholder="{{ $category->search_placeholder ?: 'Search ' . $category->name . '...' }}"
                                aria-label="Search within this category">
                            @if (!empty($search))
                                <a href="{{ route('resources.category', $category->slug) }}" class="clear-search-btn" title="Clear Search">
                                    <i class="bi bi-x-circle-fill"></i>
                                </a>
                            @endif
                        </form>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-warning alert-dismissible fade show mb-4 rounded-3 shadow-sm border-0" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Search Active Indicator -->
                    @if (!empty($search))
                        <div class="alert alert-light border d-flex justify-content-between align-items-center py-2 px-3 mb-4">
                            <span class="fs-13 text-muted">
                                Search results for "<strong class="text-dark">{{ $search }}</strong>" in {{ $category->name }}:
                                <strong>{{ $resources->total() }}</strong> found
                            </span>
                            <a href="{{ route('resources.category', $category->slug) }}" class="text-decoration-none fs-12 fw-bold text-danger">
                                <i class="bi bi-x-circle me-1"></i> Clear Filter
                            </a>
                        </div>
                    @endif

                    <!-- Resources Grid -->
                    @if ($category->layout_type === 'video_card')
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                            @forelse ($resources as $item)
                                @include('themes.default.partials.resource_video_card', ['item' => $item])
                            @empty
                                <div class="col-12 py-5 text-center text-muted">
                                    <i class="bi bi-camera-video-off fs-1 d-block mb-2 text-secondary"></i>
                                    <h5 class="fw-bold text-dark">No videos found</h5>
                                    <p class="mb-3 fs-14">There are no video tutorials matching your criteria in this category.</p>
                                    @if (!empty($search))
                                        <a href="{{ route('resources.category', $category->slug) }}" class="btn btn-sm btn-primary">Clear Search</a>
                                    @else
                                        <a href="{{ route('resources') }}" class="btn btn-sm btn-outline-primary">Back to All Resources</a>
                                    @endif
                                </div>
                            @endforelse
                        </div>

                    @elseif ($category->layout_type === 'faq_card')
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                            @forelse ($resources as $item)
                                @include('themes.default.partials.resource_faq_card', ['item' => $item])
                            @empty
                                <div class="col-12 py-5 text-center text-muted">
                                    <i class="bi bi-question-circle fs-1 d-block mb-2 text-secondary"></i>
                                    <h5 class="fw-bold text-dark">No FAQs found</h5>
                                    <p class="mb-3 fs-14">There are no FAQ resources matching your criteria.</p>
                                    @if (!empty($search))
                                        <a href="{{ route('resources.category', $category->slug) }}" class="btn btn-sm btn-primary">Clear Search</a>
                                    @else
                                        <a href="{{ route('resources') }}" class="btn btn-sm btn-outline-primary">Back to All Resources</a>
                                    @endif
                                </div>
                            @endforelse
                        </div>

                    @else
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                            @forelse ($resources as $item)
                                @include('themes.default.partials.resource_brochure_card', ['item' => $item])
                            @empty
                                <div class="col-12 py-5 text-center text-muted">
                                    <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                                    <h5 class="fw-bold text-dark">No documents found</h5>
                                    <p class="mb-3 fs-14">There are no resources matching your criteria in this category.</p>
                                    @if (!empty($search))
                                        <a href="{{ route('resources.category', $category->slug) }}" class="btn btn-sm btn-primary">Clear Search</a>
                                    @else
                                        <a href="{{ route('resources') }}" class="btn btn-sm btn-outline-primary">Back to All Resources</a>
                                    @endif
                                </div>
                            @endforelse
                        </div>
                    @endif

                    <!-- Pagination -->
                    @if ($resources->hasPages())
                        <div class="d-flex justify-content-center mt-5">
                            {{ $resources->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>

                <!-- Back to All Resources & Help Banner -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('resources') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="bi bi-arrow-left me-1"></i> Back to All Resources Hub
                    </a>
                </div>


            </section>
        </div>
    </div>

    <!-- Video Modal -->
    <div class="modal fade" id="resourceVideoModal" tabindex="-1" aria-labelledby="videoModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 bg-dark rounded-4 overflow-hidden shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-white fs-15 fw-bold text-truncate pe-3" id="videoModalTitle">AIRE Video</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="ratio ratio-16x9 rounded-3 overflow-hidden bg-black position-relative">
                        <iframe id="videoIframe" class="w-100 h-100 border-0" src="" title="Video Player" allowfullscreen
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
                        <video id="videoPlayer" class="w-100 h-100 d-none" controls playsinline preload="auto">
                            Your browser does not support HTML5 video.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Download Notification Toast -->
    <div id="resourceToast" class="resource-toast" role="alert" aria-live="assertive" aria-atomic="true">
        <i class="bi bi-check-circle-fill text-success fs-16"></i>
        <span id="resourceToastMsg">Downloading document...</span>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Download Trigger & Toast Notification
            const toastElem = document.getElementById('resourceToast');
            const toastMsg = document.getElementById('resourceToastMsg');
            let toastTimeout;

            function showToast(message) {
                if (toastElem && toastMsg) {
                    toastMsg.textContent = message;
                    toastElem.classList.add('show');
                    clearTimeout(toastTimeout);
                    toastTimeout = setTimeout(() => {
                        toastElem.classList.remove('show');
                    }, 3000);
                }
            }

            document.querySelectorAll('.js-download-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const docName = this.getAttribute('data-doc') || 'document';
                    showToast('Preparing download for ' + docName + '...');
                });
            });

            // 2. Video Modal Handling (Supports Direct MP4/WebM Videos and YouTube/Vimeo Embeds)
            const videoModal = document.getElementById('resourceVideoModal');
            const videoIframe = document.getElementById('videoIframe');
            const videoPlayer = document.getElementById('videoPlayer');
            const videoModalTitle = document.getElementById('videoModalTitle');

            if (videoModal && (videoIframe || videoPlayer)) {
                document.addEventListener('click', function(e) {
                    const trigger = e.target.closest('.js-video-trigger');
                    if (!trigger) return;

                    const title = trigger.getAttribute('data-video-title') || 'AIRE Video';
                    const isDirect = trigger.getAttribute('data-is-direct') === '1';
                    const rawSrc = trigger.getAttribute('data-video-src') || '';
                    const embedUrl = trigger.getAttribute('data-embed-url') || '';

                    if (videoModalTitle) {
                        videoModalTitle.textContent = title;
                    }

                    if (isDirect && rawSrc) {
                        // Direct HTML5 Video File (MP4, WebM, etc.)
                        if (videoIframe) {
                            videoIframe.src = '';
                            videoIframe.classList.add('d-none');
                        }
                        if (videoPlayer) {
                            videoPlayer.classList.remove('d-none');
                            videoPlayer.src = rawSrc;
                            videoPlayer.currentTime = 0;
                            videoPlayer.play().catch(function() {
                                // Autoplay fallback
                            });
                        }
                    } else {
                        // External Video Embed (YouTube, Vimeo, etc.)
                        if (videoPlayer) {
                            videoPlayer.pause();
                            videoPlayer.src = '';
                            videoPlayer.classList.add('d-none');
                        }
                        if (videoIframe) {
                            videoIframe.classList.remove('d-none');
                            let playUrl = embedUrl || rawSrc;

                            // Fallback: Ensure YouTube URLs are converted to embed format
                            const ytMatch = playUrl.match(/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?|shorts)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/i);
                            if (ytMatch && !playUrl.includes('/embed/')) {
                                playUrl = 'https://www.youtube-nocookie.com/embed/' + ytMatch[1];
                            }

                            if (playUrl) {
                                const sep = playUrl.includes('?') ? '&' : '?';
                                playUrl += sep + 'autoplay=1&rel=0';
                            }
                            videoIframe.src = playUrl;
                        }
                    }

                    if (window.bootstrap && window.bootstrap.Modal) {
                        const bsModal = bootstrap.Modal.getOrCreateInstance(videoModal);
                        bsModal.show();
                    }
                });

                videoModal.addEventListener('hidden.bs.modal', function() {
                    if (videoIframe) {
                        videoIframe.src = '';
                        videoIframe.classList.add('d-none');
                    }
                    if (videoPlayer) {
                        videoPlayer.pause();
                        videoPlayer.src = '';
                        videoPlayer.classList.add('d-none');
                    }
                });
            }
        });
    </script>
@endpush
