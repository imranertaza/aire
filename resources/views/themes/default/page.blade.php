@extends('themes.default.layouts.master')

@php
    $pageTitle = !empty($page->meta_title) ? $page->meta_title : ($page->page_title . ' | ' . config('app.name', 'Aire'));
    $pageDesc = !empty($page->meta_description)
        ? $page->meta_description
        : (!empty($page->short_des) ? $page->short_des : \Illuminate\Support\Str::limit(strip_tags($page->page_description ?? ''), 160));
    $pageKeywords = $page->meta_keyword ?? '';
    $pageImg = !empty($page->f_image) ? getImageUrl($page->f_image) : theme_asset('img/og-share-banner.jpg');
    $canonicalUrl = route('page.show', $page->slug ?? 'page');
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDesc)
@if(!empty($pageKeywords))
    @section('meta_keywords', $pageKeywords)
@endif
@section('og_image', $pageImg)
@section('canonical_url', $canonicalUrl)

@section('content')
<!-- =========================================================================
| Page Hero & Breadcrumb Banner
| ========================================================================= -->
<section class="page-hero-banner position-relative overflow-hidden py-5" style="background: linear-gradient(135deg, #071916 0%, #0c332e 50%, #00786E 100%); color: #ffffff;">
    <div class="position-absolute top-0 end-0 w-50 h-100 opacity-10 pointer-events-none" style="background: radial-gradient(circle at 70% 30%, #48cfad 0%, transparent 60%);"></div>
    
    <div class="container main-container position-relative z-1 py-3 py-md-4">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0 align-items-center" style="--bs-breadcrumb-divider: '›';">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-white-50 text-decoration-none hover-white fs-14">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>
                @if(!empty($page->breadcrumb))
                    <li class="breadcrumb-item text-white-50 fs-14">{{ $page->breadcrumb }}</li>
                @endif
                <li class="breadcrumb-item active text-white fw-semibold fs-14" aria-current="page">{{ $page->page_title }}</li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-9">
                <span class="badge bg-white bg-opacity-15 text-white px-3 py-2 rounded-pill mb-3 fw-medium fs-13 d-inline-flex align-items-center">
                    <i class="bi bi-file-earmark-text me-2"></i> {{ $page->breadcrumb ?? 'Information Page' }}
                </span>
                <h1 class="display-5 fw-bold text-white mb-3">{{ $page->page_title }}</h1>
                @if(!empty($page->short_des))
                    <p class="lead text-white-50 mb-0 fs-18" style="max-width: 820px; line-height: 1.6;">
                        {{ $page->short_des }}
                    </p>
                @endif
            </div>
            <div class="col-lg-3 text-lg-end mt-3 mt-lg-0">
                <span class="badge bg-dark bg-opacity-40 text-white-50 px-3 py-2 rounded-pill fs-12">
                    <i class="bi bi-shield-check text-success me-1"></i> Verified IAQ Content
                </span>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================================
| Main Dynamic Content & Sidebar
| ========================================================================= -->
<main class="container main-container py-5">
    <div class="row g-4 g-lg-5">
        
        <!-- Left: Page Body & Media -->
        <div class="col-lg-8">
            <article class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                
                <!-- Featured Image (if available) -->
                @if(!empty($page->f_image))
                    <div class="page-featured-media mb-4 rounded-4 overflow-hidden position-relative shadow-sm">
                        <img src="{{ getImageUrl($page->f_image) }}" 
                             alt="{{ $page->page_title }}" 
                             class="img-fluid w-100 object-fit-cover" 
                             style="max-height: 420px; min-height: 240px;" 
                             loading="lazy">
                    </div>
                @endif

                <!-- Dynamic HTML Rich Body Content -->
                <div class="aire-page-prose text-dark">
                    @if(!empty($page->page_description))
                        {!! $page->page_description !!}
                    @else
                        <div class="alert alert-light border rounded-3 p-4 text-center text-muted">
                            <i class="bi bi-info-circle fs-3 d-block mb-2 text-primary"></i>
                            <p class="mb-0">Page content is being updated by our editorial team. Please check back soon.</p>
                        </div>
                    @endif
                </div>

                <!-- Footer / Share Toolbar -->
                <hr class="my-5 border-secondary border-opacity-10">
                
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-semibold text-secondary fs-14"><i class="bi bi-share me-1"></i> Share this page:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($canonicalUrl) }}" 
                           target="_blank" rel="noopener noreferrer"
                           class="btn btn-sm btn-outline-secondary rounded-circle share-btn" 
                           title="Share on Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode($canonicalUrl) }}&text={{ urlencode($page->page_title) }}" 
                           target="_blank" rel="noopener noreferrer"
                           class="btn btn-sm btn-outline-secondary rounded-circle share-btn" 
                           title="Share on X (Twitter)">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($canonicalUrl) }}" 
                           target="_blank" rel="noopener noreferrer"
                           class="btn btn-sm btn-outline-secondary rounded-circle share-btn" 
                           title="Share on LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <button type="button" 
                                class="btn btn-sm btn-outline-secondary rounded-circle share-btn" 
                                onclick="navigator.clipboard.writeText('{{ $canonicalUrl }}'); if(window.AireToast) { window.AireToast.success('Page link copied to clipboard!'); } else { alert('Link copied to clipboard!'); }" 
                                title="Copy Link">
                            <i class="bi bi-link-45deg"></i>
                        </button>
                    </div>

                    <div class="text-muted fs-13">
                        <i class="bi bi-clock-history me-1"></i> Last updated: {{ $page->updated_at ? $page->updated_at->format('M d, Y') : now()->format('M d, Y') }}
                    </div>
                </div>

            </article>
        </div>

        <!-- Right: Modern Sidebar Navigation & Support Widgets -->
        <aside class="col-lg-4">
            <div class="d-flex flex-column gap-4 sticky-top" style="top: 100px; z-index: 10;">
                
                <!-- Quick Pages Navigation -->
                @if(isset($otherPages) && $otherPages->isNotEmpty())
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="rounded-3 bg-primary bg-opacity-10 p-2 text-primary d-inline-flex">
                                <i class="bi bi-collection fs-5"></i>
                            </div>
                            <h5 class="fw-bold mb-0 fs-16 text-dark">Related Information</h5>
                        </div>
                        
                        <div class="list-group list-group-flush border-0">
                            @foreach($otherPages as $item)
                                <a href="{{ route('page.show', $item->slug) }}" 
                                   class="list-group-item list-group-item-action px-0 py-2 border-0 d-flex align-items-center justify-content-between text-secondary hover-primary transition-all {{ $item->slug === $page->slug ? 'fw-bold text-primary active-link' : '' }}">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-chevron-right fs-12 {{ $item->slug === $page->slug ? 'text-primary' : 'text-muted' }}"></i>
                                        {{ $item->page_title }}
                                    </span>
                                    @if(!empty($item->breadcrumb))
                                        <span class="badge bg-light text-muted fs-11 fw-normal">{{ $item->breadcrumb }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Consultation & Support Box -->
                <div class="card border-0 shadow-sm rounded-4 p-4 text-white overflow-hidden position-relative" 
                     style="background: linear-gradient(135deg, #09201c 0%, #00786E 100%);">
                    <div class="position-relative z-1">
                        <span class="badge bg-white bg-opacity-20 text-white px-3 py-1 rounded-pill fs-12 mb-3 fw-medium">
                            <i class="bi bi-headset me-1"></i> Direct Assistance
                        </span>
                        <h5 class="fw-bold mb-2">Need Expert Clean Air Advice?</h5>
                        <p class="text-white-50 fs-14 mb-4">
                            Our team of HVAC & certified air filtration engineers is available to help design your residential or commercial IAQ setup.
                        </p>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('contact') }}" class="btn btn-light fw-bold text-dark rounded-pill py-2 shadow-sm">
                                <i class="bi bi-envelope-fill me-1 text-primary"></i> Contact Specialist
                            </a>
                            <a href="{{ route('solutions') }}" class="btn btn-outline-light rounded-pill py-2">
                                <i class="bi bi-grid-fill me-1"></i> Explore Solutions
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Trust Badges Widget -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h6 class="fw-bold text-dark fs-14 text-uppercase mb-3" style="letter-spacing: 0.5px;">The Aire Commitment</h6>
                    <div class="d-flex flex-column gap-3 fs-14 text-secondary">
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-patch-check-fill text-success fs-5"></i>
                            <div>
                                <strong class="d-block text-dark">Medical-Grade HEPA</strong>
                                <span class="fs-13 text-muted">99.97% particulate capture efficiency down to 0.1 microns.</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-truck text-primary fs-5"></i>
                            <div>
                                <strong class="d-block text-dark">Fast Nationwide Delivery</strong>
                                <span class="fs-13 text-muted">Direct insured doorstep shipping for all units and filter kits.</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-shield-lock-fill text-info fs-5"></i>
                            <div>
                                <strong class="d-block text-dark">Official Warranty</strong>
                                <span class="fs-13 text-muted">Full manufacturer replacement and maintenance coverage.</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </aside>

    </div>
</main>

@push('styles')
<style>
/* =========================================================================
| Aire Dynamic Page Typography & Prose Styles
| ========================================================================= */
.aire-page-prose {
    font-size: 1.05rem;
    line-height: 1.8;
    color: #2b303a;
}

.aire-page-prose h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-top: 2.25rem;
    margin-bottom: 1rem;
    color: #0f172a;
    letter-spacing: -0.02em;
}

.aire-page-prose h3 {
    font-size: 1.35rem;
    font-weight: 600;
    margin-top: 1.75rem;
    margin-bottom: 0.75rem;
    color: #1e293b;
}

.aire-page-prose h4, 
.aire-page-prose h5, 
.aire-page-prose h6 {
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
    color: #334155;
}

.aire-page-prose p {
    margin-bottom: 1.35rem;
}

.aire-page-prose ul, 
.aire-page-prose ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}

.aire-page-prose li {
    margin-bottom: 0.5rem;
}

.aire-page-prose blockquote {
    border-left: 4px solid #00786E;
    padding: 1rem 1.5rem;
    margin: 1.75rem 0;
    background: #f8fafc;
    border-radius: 0 0.75rem 0.75rem 0;
    font-style: italic;
    color: #475569;
}

.aire-page-prose table {
    width: 100%;
    margin-bottom: 1.5rem;
    border-collapse: collapse;
}

.aire-page-prose table th,
.aire-page-prose table td {
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
}

.aire-page-prose table th {
    background-color: #f1f5f9;
    font-weight: 600;
}

.aire-page-prose img {
    max-width: 100% !important;
    height: auto !important;
    border-radius: 0.75rem;
    margin: 1.5rem 0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.hover-white:hover {
    color: #ffffff !important;
}

.hover-primary:hover {
    color: #00786E !important;
    transform: translateX(4px);
}

.share-btn {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.share-btn:hover {
    background-color: #00786E;
    border-color: #00786E;
    color: #ffffff;
    transform: translateY(-2px);
}

.active-link {
    background-color: #f0fdf9 !important;
    padding-left: 0.75rem !important;
    border-radius: 0.5rem;
}
</style>
@endpush
@endsection
