@extends('themes.default.layouts.master')

@section('title', 'Resources | Brochures, Catalogs & Technical Documentation - Aire')
@section('meta_description',
    'Explore AIRE product brochures, engineering catalogs, user manuals, installation guides,
    video tutorials and technical documentation for clean air systems.')
@section('meta_keywords',
    'aire resources, air purifier brochure, hvac catalog, installation guides, user manuals,
    technical documents')

    @push('styles')
        <link rel="stylesheet" href="{{ theme_asset('css/product.css') }}">
        <style>
            /* Resources Page Custom Styling matching Aire Design System */

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
                max-width: 780px;
                line-height: 1.6;
                margin-bottom: 8px;
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
                padding: 10px 14px 10px 38px;
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

            .resource-section-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                padding-bottom: 22px;
                border-bottom: 1px solid #f1f5f9;
                margin-bottom: 24px;
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

            .resource-section-title {
                font-size: 20px;
                font-weight: 700;
                color: #0f172a;
                margin-bottom: 2px;
                letter-spacing: -0.3px;
            }

            .resource-section-desc {
                font-size: 13.5px;
                color: #64748b;
                margin-bottom: 0;
            }

            .resource-filter-input-wrap {
                position: relative;
                width: 220px;
            }

            .resource-filter-input {
                border-radius: 8px;
                border: 1px solid #e2e8f0;
                padding: 7px 32px 7px 12px;
                font-size: 12.5px;
                width: 100%;
                background-color: #ffffff;
                transition: border-color 0.2s ease;
            }

            .resource-filter-input:focus {
                border-color: var(--color-primary, #0095DA);
                outline: none;
            }

            .resource-filter-input-wrap .filter-search-icon {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
                font-size: 12px;
                pointer-events: none;
            }

            .resource-view-all-link {
                color: var(--color-primary, #0095DA);
                font-size: 13.5px;
                font-weight: 600;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                transition: transform 0.2s ease, color 0.2s ease;
                white-space: nowrap;
            }

            .resource-view-all-link:hover {
                color: var(--color-primary-hover, #047cc2);
                transform: translateX(3px);
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

            /* Header Controls Row */
            .resource-header-controls {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .center-feed {
                padding-top: 10px;

            }

            /* Toast feedback */
            .resource-toast {
                position: fixed;
                bottom: 24px;
                right: 24px;
                z-index: 10600;
                background: #0f172a;
                color: #ffffff;
                padding: 12px 20px;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 13.5px;
                font-weight: 500;
                opacity: 0;
                transform: translateY(20px);
                transition: all 0.25s ease;
                pointer-events: none;
            }

            .resource-toast.show {
                opacity: 1;
                transform: translateY(0);
                pointer-events: auto;
            }

            @media (max-width: 768px) {
                .resources-page-title {
                    font-size: 24px;
                }

                .resource-section-card {
                    padding: 18px;
                    border-radius: 14px;
                }

                .resources-search-wrap {
                    max-width: 100%;
                    margin-top: 14px;
                }

                .resource-header-controls {
                    width: 100%;
                    justify-content: space-between;
                }

                .resource-filter-input-wrap {
                    width: 100%;
                    max-width: calc(100% - 90px);
                }
            }
        </style>
    @endpush

@section('content')

    <div class="container main-container">
        @renderPageSlot('resources', 'before:resource_content')
        <div class="row g-0">

            <!-- Left Sticky Sidebar Navigation (Desktop) matching category/index.blade.php -->
            <aside class="col-lg-3 d-none d-lg-block border-right1px pe-lg-4">
                <nav class="sidebar-menu sticky-sidebar" id="resourcesSidebar" data-lenis-prevent>
                    <a href="#cat-all" class="menu-item active" data-target="cat-all">
                        <div class="icon-box">
                            <i class="bi bi-collection"></i>
                        </div>
                        <div class="text-box d-flex align-items-center justify-content-between w-100">
                            <h2 class="mb-0">Resources</h2>
                            <span
                                class="badge rounded-pill bg-primary-subtle text-primary fw-bold fs-10 px-2 py-1">All</span>
                        </div>
                        <i class="bi bi-chevron-right ms-auto chevron"></i>
                    </a>

                    @foreach ($resourceCategories as $cat)
                        <a href="#cat-{{ $cat->slug }}" class="menu-item" data-target="cat-{{ $cat->slug }}">
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
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb mb-1 align-items-center" style="--bs-breadcrumb-divider: '›'; font-size: 13.5px;">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a>
                        </li>
                        <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Resources</li>
                    </ol>
                </nav>
                <!-- Mobile Horizontal Category Scroll Bar matching category/index.blade.php -->
                <div class="d-lg-none mobile-category-scroll-wrapper" data-lenis-prevent>
                    <div class="mobile-category-scroll-track" data-lenis-prevent>
                        <a href="#cat-all" class="mobile-cat-pill active">
                            <span class="mobile-cat-pill__icon"><i class="bi bi-collection"></i></span>
                            <span>All Resources</span>
                        </a>
                        @foreach ($resourceCategories as $cat)
                            <a href="#cat-{{ $cat->slug }}" class="mobile-cat-pill">
                                <span class="mobile-cat-pill__icon"><i
                                        class="{{ $cat->icon ?: 'bi bi-folder2' }}"></i></span>
                                <span>{{ $cat->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div id="cat-all"></div>
                <!-- Top Header: Title, Description & Search Bar -->
                <div class="mb-3">
                    <div>
                        <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                            <h1 class="resources-page-title mb-0">Resources</h1>
                            <div class="resources-search-wrap flex-shrink-0">
                                <i class="bi bi-search search-icon"></i>
                                <input type="text" id="globalResourceSearch" class="form-control"
                                    placeholder="Search resources..." aria-label="Search resources">
                            </div>
                        </div>

                        <p class="resources-page-subtitle">
                            All the information you need — product documents, technical resources, installation guides,
                            case studies and more — to help you design, specify, install and maintain cleaner, healthier
                            spaces.
                        </p>
                    </div>
                </div>

                @renderPageSlot('resources', 'before:catalog')

                @if (session('error'))
                    <div class="alert alert-warning alert-dismissible fade show mb-4 rounded-3 shadow-sm border-0" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Dynamic Resource Categories Loop -->
                @foreach ($resourceCategories as $cat)
                    <div id="cat-{{ $cat->slug }}" class="resource-section-card content-section"
                        data-section-name="{{ $cat->slug }}">
                        <div class="resource-section-header">
                            <div class="d-flex align-items-center gap-3">
                                <div class="resource-section-badge-icon">
                                    <i class="{{ $cat->icon ?: 'bi bi-folder2' }}"></i>
                                </div>
                                <div>
                                    <h3 class="resource-section-title">{{ $cat->name }}</h3>
                                    <p class="resource-section-desc">{{ $cat->description }}</p>
                                </div>
                            </div>
                            <div class="resource-header-controls">
                                <div class="resource-filter-input-wrap">
                                    <input type="text" class="resource-filter-input section-search"
                                        data-target="resource-card-col"
                                        placeholder="{{ $cat->search_placeholder ?: 'Search with model No/ Name' }}">
                                    <i class="bi bi-search filter-search-icon"></i>
                                </div>
                                <a href="{{ route('resources.category', $cat->slug) }}" class="resource-view-all-link">View All <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>

                        {{-- Layout 1: Video Modal Cards --}}
                        @if ($cat->layout_type === 'video_card')
                            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                                @forelse ($cat->activeResources as $item)
                                    @include('themes.default.partials.resource_video_card', [
                                        'item' => $item,
                                    ])
                                @empty
                                    <div class="col-12 py-4 text-center text-muted">
                                        <p class="mb-0">No videos found in this section.</p>
                                    </div>
                                @endforelse
                            </div>

                        {{-- Layout 2: FAQ Cards --}}
                        @elseif ($cat->layout_type === 'faq_card')
                            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                                @forelse ($cat->activeResources as $item)
                                    @include('themes.default.partials.resource_faq_card', [
                                        'item' => $item,
                                    ])
                                @empty
                                    <div class="col-12 py-4 text-center text-muted">
                                        <p class="mb-0">No FAQs found in this section.</p>
                                    </div>
                                @endforelse
                            </div>

                        {{-- Layout 3: All other resources use Brochure Card Design --}}
                        @else
                            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                                @forelse ($cat->activeResources as $item)
                                    @include('themes.default.partials.resource_brochure_card', [
                                        'item' => $item,
                                    ])
                                @empty
                                    <div class="col-12 py-4 text-center text-muted">
                                        <p class="mb-0">No documents found in this section.</p>
                                    </div>
                                @endforelse
                            </div>
                        @endif

                    </div>
                @endforeach
            </section>
            @renderPageSlot('resources', 'after:catalog')
        </div>
        @renderPageSlot('resources', 'after:resource_content')
    </div>

    <!-- Video Modal Player -->
    <div class="modal fade" id="resourceVideoModal" tabindex="-1" aria-labelledby="videoModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden bg-dark">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-white fs-16 fw-bold text-truncate pe-3" id="videoModalTitle">Video Title</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="ratio ratio-16x9 rounded-3 overflow-hidden bg-black position-relative">
                        <iframe id="videoIframe" class="w-100 h-100 border-0" src="" title="Video Player"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                        <video id="videoPlayer" class="w-100 h-100 d-none" controls playsinline preload="auto">
                            Your browser does not support HTML5 video.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Download Feedback Toast -->
    <div id="resourceToast" class="resource-toast">
        <i class="bi bi-check-circle-fill text-success fs-5"></i>
        <span id="resourceToastMsg">Preparing your download...</span>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Sidebar and Mobile Navigation Smooth Scroll & Active State
            const sidebarLinks = document.querySelectorAll('#resourcesSidebar .menu-item');
            const mobilePills = document.querySelectorAll('.mobile-category-scroll-track .mobile-cat-pill');
            const sections = document.querySelectorAll('.content-section');

            function setActiveLink(targetId) {
                sidebarLinks.forEach(link => {
                    if (link.getAttribute('href') === '#' + targetId || link.getAttribute('data-target') ===
                        targetId) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });

                mobilePills.forEach(pill => {
                    if (pill.getAttribute('href') === '#' + targetId) {
                        pill.classList.add('active');
                    } else {
                        pill.classList.remove('active');
                    }
                });
            }

            [...sidebarLinks, ...mobilePills].forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href && href.startsWith('#')) {
                        e.preventDefault();
                        const targetElem = document.querySelector(href);
                        if (targetElem) {
                            const headerOffset = 100;
                            const elementPosition = targetElem.getBoundingClientRect().top;
                            const offsetPosition = elementPosition + window.pageYOffset -
                                headerOffset;

                            window.scrollTo({
                                top: offsetPosition,
                                behavior: 'smooth'
                            });

                            setActiveLink(href.replace('#', ''));
                        }
                    }
                });
            });

            // 2. ScrollSpy highlight
            window.addEventListener('scroll', function() {
                let currentSectionId = '';
                const scrollPos = window.pageYOffset + 140;

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                        currentSectionId = section.getAttribute('id');
                    }
                });

                if (currentSectionId) {
                    setActiveLink(currentSectionId);
                }
            }, {
                passive: true
            });

            // 3. Global & Section Live Search Filtering
            const globalSearch = document.getElementById('globalResourceSearch');
            const allResourceCards = document.querySelectorAll('.resource-card-col');

            function filterCard(card, query) {
                const title = (card.getAttribute('data-title') || '').toLowerCase();
                const desc = (card.getAttribute('data-desc') || '').toLowerCase();
                card.style.display = (!query || title.includes(query) || desc.includes(query)) ? '' : 'none';
            }

            if (globalSearch) {
                globalSearch.addEventListener('input', function() {
                    const query = this.value.trim().toLowerCase();
                    allResourceCards.forEach(card => filterCard(card, query));
                });
            }

            // Section Specific Search Inputs
            document.querySelectorAll('.section-search').forEach(input => {
                input.addEventListener('input', function() {
                    const targetClass = this.getAttribute('data-target');
                    const query = this.value.trim().toLowerCase();
                    const parentSection = this.closest('.resource-section-card');

                    if (parentSection && targetClass) {
                        parentSection.querySelectorAll('.' + targetClass).forEach(card =>
                            filterCard(card, query));
                    }
                });
            });

            // 4. Download Trigger & Toast Notification
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

            // 5. Video Modal Handling (Supports Direct MP4/WebM Videos and YouTube/Vimeo Embeds)
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
