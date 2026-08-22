@extends('themes.default.layouts.master')

@section('title', ($product->name ?? 'Product Details') . ' | AIRE')

@push('styles')
<style>
    :root {
        --primary-blue: #0d6efd;
        --primary-hover: #0b5ed7;
        --accent-blue: #2563eb;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --border-light: #e2e8f0;
        --bg-light-alt: #f8fafc;
    }

    body {
        background-color: #ffffff !important;
        color: var(--text-main);
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        scroll-behavior: smooth;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    /* Top Header Navigation */
    .navbar-custom {
        border-bottom: 1px solid var(--border-light);
        padding: 16px 32px;
        background: #ffffff;
        position: relative;
        z-index: 1020;
    }

    .brand-logo {
        font-weight: 800;
        font-size: 1.5rem;
        letter-spacing: -0.5px;
        color: #0F172A;
        text-decoration: none;
    }

    .brand-logo .dot {
        color: var(--primary-blue);
    }

    .nav-link-custom {
        color: #475569;
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.2s;
    }

    .nav-link-custom:hover,
    .nav-link-custom.active {
        color: var(--primary-blue);
    }

    .btn-signup {
        background: transparent;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 6px 18px;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .btn-signup:hover {
        border-color: #94a3b8;
        background: #f8fafc;
    }

    .btn-login {
        background: var(--primary-blue);
        border: none;
        color: #fff;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 6px 20px;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);
        transition: all 0.2s;
    }

    .btn-login:hover {
        background: var(--primary-hover);
        color: #fff;
    }

    /* Sticky Header Bar (Shown on Scroll) */
    .sticky-product-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 10400;
        background: #ffffff;
        border-bottom: 1px solid var(--border-light);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transform: translateY(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: none;
    }

    .sticky-product-header.is-sticky {
        display: block;
        transform: translateY(0);
    }

    .sticky-bar-top {
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .sticky-thumb {
        width: 60px;
        height: 60px;
        object-fit: contain;
        background: #f8fafc;
        border: 1px solid var(--border-light);
        border-radius: 8px;
        padding: 4px;
    }

    .btn-scroll-top {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 1px solid var(--border-light);
        background: #ffffff;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-scroll-top:hover {
        background: var(--primary-blue);
        color: #ffffff;
        border-color: var(--primary-blue);
    }

    /* Breadcrumb styling */
    .breadcrumb-custom {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 500;
    }

    .breadcrumb-custom span {
        color: var(--text-main);
        font-weight: 700;
    }

    /* Image Gallery Thumbnails */
    .thumb-img {
        opacity: 0.6;
        transition: all 0.2s ease;
        background-color: #f8fafc;
        border-radius: 10px;
        border: 1px solid var(--border-light);
        padding: 6px;
        width: 100%;
        aspect-ratio: 1;
        object-fit: contain;
    }

    .thumb-img.active,
    .thumb-img:hover {
        opacity: 1;
        border-color: var(--primary-blue) !important;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.2);
    }

    /* Main Image Box */
    .main-image-wrapper {
        background-color: #ffffff;
        border: 1px solid var(--border-light);
        position: relative;
        border-radius: 16px;
        max-height: 412px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .badge-render {
        background: #ffffff;
        color: var(--text-main);
        border: 1px solid #cbd5e1;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 20px;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }

    /* Feature Check Cards (2x2 Grid) */
    .feature-check-box {
        border: 1px solid var(--border-light);
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 0.8rem;
        font-weight: 700;
        background: #ffffff;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: 0.3px;
        color: var(--text-main);
    }

    .feature-check-box i {
        font-size: 1.1rem;
        color: var(--text-main);
        font-weight: bold;
    }

    /* Color Swatches */
    .color-swatch {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .color-swatch-black {
        background-color: #0f172a !important;
    }

    .color-swatch-grey {
        background-color: #475569 !important;
    }

    .color-swatch-light {
        background-color: #e2e8f0 !important;
        border: 1px solid #cbd5e1 !important;
    }

    .color-swatch.active {
        border-color: var(--primary-blue, #2563eb) !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.25) !important;
    }

    /* Size Buttons */
    .size-btn {
        border: 1px solid #cbd5e1;
        background: #fff;
        color: var(--text-main);
        font-weight: 600;
        padding: 8px 22px;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .size-btn.active,
    .size-btn:hover {
        border-color: var(--primary-blue);
        color: var(--primary-blue);
        background: #f0f6ff;
    }

    /* Nav Pills Navigation */
    .nav-pill-custom {
        background-color: #eef2ff;
        color: #3b82f6;
        border: none;
        font-weight: 600;
        font-size: 12px;
        padding: 8px 10px;
        border-radius: 20px;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }

    .nav-pill-custom.active,
    .nav-pill-custom:hover {
        background-color: #2563eb;
        color: #ffffff;
    }

    /* Buy Button */
    .btn-buy-now {
        background: #2563eb;
        border: none;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 16px 12px;
        border-radius: 8px;
        color: #ffffff;
        transition: all 0.2s;
    }

    .btn-buy-now:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        color: #ffffff;
    }

    /* Sub-Nav Bar (Tabs) */
    .bottom-tabs-bar {
        border-top: 1px solid var(--border-light);
        border-bottom: 1px solid var(--border-light);
        padding: 0;
        background: #ffffff;
        position: sticky;
        top: 0;
        z-index: 1030;
    }

    .sticky-product-header.is-sticky .bottom-tabs-bar {
        position: static;
        border-top: none;
    }

    .bottom-tab-link {
        color: #64748b;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 12px 0;
        transition: all 0.2s;
        position: relative;
        display: inline-block;
    }

    .bottom-tab-link:hover,
    .bottom-tab-link.active {
        color: var(--primary-blue);
    }

    .bottom-tab-link.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: var(--primary-blue);
    }

    /* Overview Feature Cards */
    .overview-feature-card {
        border: 1px solid var(--border-light);
        border-radius: 12px;
        background: #ffffff;
        transition: all 0.2s ease;
    }

    .overview-feature-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    /* Section Backgrounds */
    .section-alt {
        background-color: #f8fafc;
        /* border-top: 1px solid var(--border-light); */
        /* border-bottom: 1px solid var(--border-light); */
    }

    /* Universal Parallax Plugin Styling */
    .parallax-window {
        position: relative;
        overflow: hidden;
        clip-path: inset(0);
    }

    .parallax-slider {
        position: absolute;
        top: -12%;
        left: 0;
        width: 100%;
        height: 124%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        will-change: transform;
        z-index: 0;
        pointer-events: none;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
    }

    .parallax-overlay {
        position: absolute;
        inset: 0;
        z-index: 1;
        pointer-events: none;
    }

    .parallax-content {
        position: relative;
        z-index: 2;
    }

    /* Precision Engineered Details Banner */
    .precision-banner {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        background-color: #0b1329;
        color: #ffffff;
        min-height: 520px;
        display: flex;
        align-items: flex-end;
        padding: 30px;
    }

    .precision-card-item {
        position: relative;
        z-index: 2;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        padding: 24px;
        text-align: left;
        transition: all 0.3s ease;
    }

    .precision-card-item:hover {
        background: rgba(255, 255, 255, 0.18);
        border-color: rgba(255, 255, 255, 0.4);
    }

    .precision-icon-box {
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        font-size: 1.2rem;
        color: #ffffff;
    }

    /* Technology Physics Banner */
    .physics-banner {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        background-color: #0d1b2a;
        min-height: 480px;
        display: flex;
        align-items: flex-end;
        padding: 35px;
    }

    .hud-line-label {
        position: absolute;
        background: rgba(13, 27, 42, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 4px;
        letter-spacing: 1px;
    }

    /* Universal Parallax Window & Slider System */
    .parallax-window {
        position: relative;
        overflow: hidden !important;
    }

    .parallax-slider {
        position: absolute;
        top: -20%;
        left: 0;
        width: 100%;
        height: 140%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        will-change: transform;
        z-index: 0;
    }

    .parallax-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
        pointer-events: none;
    }

    .parallax-content {
        position: relative;
        z-index: 2;
    }

    /* Applications Cards */
    .app-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden !important;
        min-height: 260px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 24px;
        color: #ffffff;
        border: 1px solid var(--border-light);
    }

    .app-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.8) 100%);
        z-index: 1;
    }

    .app-card-content {
        position: relative;
        z-index: 2;
    }

    /* Accessories / Box Contents Card Grid */
    .box-item-card {
        text-align: center;
        transition: all 0.2s ease;
    }

    .box-item-img-box {
        background: #ffffff;
        border: 1px solid var(--border-light);
        border-radius: 18px;
        padding: 24px;
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        transition: all 0.2s ease;
    }

    .box-item-card:hover .box-item-img-box {
        border-color: #cbd5e1;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        transform: translateY(-3px);
    }

    .box-item-img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    /* FAQ Accordion Styling */
    .custom-accordion .accordion-item {
        border: 1px solid var(--border-light);
        border-radius: 12px !important;
        margin-bottom: 12px;
        overflow: hidden;
        background: #ffffff;
    }

    .custom-accordion .accordion-button {
        background-color: #ffffff;
        color: var(--text-main);
        font-weight: 700;
        font-size: 0.95rem;
        padding: 18px 24px;
        box-shadow: none !important;
    }

    .custom-accordion .accordion-button:not(.collapsed) {
        color: var(--primary-blue);
        background-color: #ffffff;
    }

    .custom-accordion .accordion-body {
        color: var(--text-muted);
        font-size: 0.875rem;
        line-height: 1.6;
        padding: 0 24px 20px 24px;
    }

    /* Footer */
    .footer-main {
        background-color: #090d16;
        color: #94a3b8;
        font-size: 0.85rem;
        padding-top: 60px;
        padding-bottom: 30px;
    }

    .footer-title {
        color: #ffffff;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        margin-bottom: 20px;
    }

    .footer-link {
        color: #94a3b8;
        text-decoration: none;
        transition: color 0.2s;
    }

    .footer-link:hover {
        color: #ffffff;
    }

    .newsletter-input {
        background: #1e293b;
        border: 1px solid #334155;
        color: #ffffff;
        padding: 10px 16px;
        font-size: 0.85rem;
        border-radius: 6px 0 0 6px;
    }

    .newsletter-input:focus {
        background: #1e293b;
        color: #ffffff;
        border-color: var(--primary-blue);
        box-shadow: none;
    }

    .newsletter-btn {
        background: #334155;
        border: 1px solid #334155;
        color: #ffffff;
        padding: 0 16px;
        border-radius: 0 6px 6px 0;
        transition: all 0.2s;
    }

    .newsletter-btn:hover {
        background: var(--primary-blue);
        border-color: var(--primary-blue);
        color: #ffffff;
    }

    .up-down-link {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 33px;
        height: 33px;
        border-radius: 50%;
        color: var(--primary-blue);
        background-color: #CEDDFF;
        margin: 0 auto;
    }

    .product-desc-scroll {
        height: 260px;
    }
</style>
@endpush

@section('content')
<!-- Top Sticky Bar for Product Name, Price, and Buy Button -->
<div class="container-fluid top-sticky-bar" id="productStickyBar">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <span class="product-title-sticky fw-bold text-white">{{ $product->name }}</span>
            <span class="product-price-sticky fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <button type="button" class="btn btn-outline-light rounded-pill px-3 py-1 btn-sm fw-semibold"
                onclick="window.history.back()">Back</button>
            <button type="button" class="btn btn-primary rounded-pill px-4 py-1 btn-sm fw-semibold"
                onclick="document.getElementById('buyNowBtn')?.click()">Buy Now</button>
        </div>
    </div>
    <!-- Embedded Sticky Tabs Bar -->
    <div class="container d-flex justify-content-between overflow-auto gap-4 text-nowrap">
        <a href="#overview" class="bottom-tab-link active">OVERVIEW</a>
        @if (!empty($product->productAttributes) && $product->productAttributes->count() > 0)
        <a href="#specs" class="bottom-tab-link">SPECIFICATIONS</a>
        @endif
        @if (!empty($product->features) && $product->features->count() > 0)
        <a href="#features" class="bottom-tab-link">FEATURES</a>
        @endif
        @if (!empty($product->technologies) && $product->technologies->count() > 0)
        <a href="#tech" class="bottom-tab-link">TECHNOLOGY</a>
        @endif
        @if (!empty($product->applications) && $product->applications->count() > 0)
        <a href="#apps" class="bottom-tab-link">APPLICATIONS</a>
        @endif
        @if (!empty($product->boxContents) && $product->boxContents->count() > 0)
        <a href="#box" class="bottom-tab-link">IN THE BOX</a>
        @endif
        @if (!empty($product->faqs) && $product->faqs->count() > 0)
        <a href="#faq" class="bottom-tab-link">FAQ</a>
        @endif
    </div>
</div>

<!-- Main Product Top Section -->
<section class="container py-4 product-top-section" id="productTopSection">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"
                    class="text-secondary text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/products') }}"
                    class="text-secondary text-decoration-none">Products</a></li>
            @if ($product->categories && $product->categories->count() > 0)
            <li class="breadcrumb-item"><a href="{{ url('/category/' . $product->categories->first()->id) }}"
                    class="text-secondary text-decoration-none">{{ $product->categories->first()->name }}</a></li>
            @endif
            <li class="breadcrumb-item active text-dark" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4 g-lg-5">
        <!-- Product Gallery Carousel / Preview Column -->
        <div class="col-lg-6">
            <div class="d-flex flex-column-reverse flex-md-row gap-3">
                <!-- Vertical Thumbnails -->
                @if ($product->images && $product->images->count() > 1)
                <div class="d-flex flex-row flex-md-column gap-2 overflow-auto thumb-list-wrapper"
                    style="max-height: 480px; scrollbar-width: none;">
                    @foreach ($product->images as $imgIdx => $img)
                    <div class="thumb-preview {{ $imgIdx === 0 ? 'active' : '' }}"
                        onclick="changeMainImage('{{ getImageUrl($img->image) }}', this)">
                        <img src="{{ getImageUrl($img->image) }}" alt="{{ $product->name }}" class="img-fluid">
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Main Preview Box with Dynamic Badges -->
                <div
                    class="main-preview-box flex-grow-1 position-relative text-center d-flex align-items-center justify-content-center">
                    <div class="d-flex justify-content-between position-absolute top-0 start-0 w-100 p-3 z-1">
                        <span class="badge-render">AUTHENTIC AIRE</span>
                        <span class="badge-render"><i class="bi bi-shield-check me-1"></i> VERIFIED SYSTEM</span>
                    </div>
                    <img src="{{ !empty($product->main_image) && !str_contains($product->main_image, 'placehold.co') ? getImageUrl($product->main_image) : theme_asset('img/products/product_overview.png') }}"
                        id="mainProductImg" class="img-fluid mt-3" style="max-height: 380px; object-fit: contain;"
                        alt="{{ $product->name }}">
                </div>
            </div>
        </div>

        <!-- Product Info & Actions Column -->
        <div class="col-lg-6">
            <div class="text-uppercase text-muted small fw-bold tracking-wider mb-1"
                style="font-size: 0.7rem; letter-spacing: 1px;">
                {{ $product->categories && $product->categories->count() > 0 ? strtoupper($product->categories->first()->name) : 'AIR PURIFICATION SYSTEM' }}
            </div>

            <div class="d-flex justify-content-between align-items-start mb-2">
                <h1 class="fw-bold mb-0 text-dark title-2">{{ $product->name }}</h1>
                <h2 class="text-dark fw-bold mb-0 title-2">${{ number_format($product->price, 2) }}</h2>
            </div>

            <p class="text-muted small mb-3">
                {{ $product->brand->name ?? 'Next-Generation Active Wearable Air Purifier' }}
            </p>

            <div class="d-flex align-items-center gap-2 mb-3">
                <div class="text-primary fs-6">★★★★★</div>
                <span class="text-muted small fw-semibold">4.9 (128 Certified Reviews)</span>
            </div>

            <!-- Vertical Scroll Wrapper -->
            <div class="overflow-y-auto pe-2 mb-4 product-desc-scroll" data-lenis-prevent style="max-height: 280px;">
                <p class="text-secondary small mb-4 product-desc-text">
                    {{ $product->description->summary ?? ($product->description->description ?? 'Engineered for precision and protection. Combines industrial-grade HEPA filtration with intelligent airflow sensors to deliver laboratory-clean air.') }}
                </p>

                <!-- 2x2 Feature Check Cards -->
                <div class="row g-2 mb-4">
                    <div class="col-6">
                        <div class="feature-check-box">
                            <i class="bi bi-check-lg"></i>
                            <span>DUAL HEPA H13</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-check-box">
                            <i class="bi bi-check-lg"></i>
                            <span>AIRFLOW SENSORS</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-check-box">
                            <i class="bi bi-check-lg"></i>
                            <span>SILICONE SEAL</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-check-box">
                            <i class="bi bi-check-lg"></i>
                            <span>12H BATTERY</span>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Product Options (Color / Size / Grouped) -->
                @if (!empty($groupedOptions))
                @foreach ($groupedOptions as $optionName => $optionValues)
                <div class="mb-4">
                    <label class="form-label small text-muted fw-bold mb-2 option-label-sm">SELECT
                        {{ strtoupper($optionName) }}</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($optionValues as $ovIdx => $ov)
                        <button type="button"
                            class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1 option-select-btn {{ $ovIdx === 0 ? 'active' : '' }}">
                            {{ $ov['name'] }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Interactive Nav Pills & Actions Row -->
    <div class="row mt-2">
        <div class="col-6 text-center">
            <div class="d-flex justify-content-center flex-wrap gap-2 mb-1">
                <a href="#overview" class="nav-pill-custom active">Overview</a>
                @if (!empty($product->productAttributes) && $product->productAttributes->count() > 0)
                <a href="#specs" class="nav-pill-custom">Specifications</a>
                @endif
                @if (!empty($product->features) && $product->features->count() > 0)
                <a href="#features" class="nav-pill-custom">Features</a>
                @endif
                @if (!empty($product->technologies) && $product->technologies->count() > 0)
                <a href="#tech" class="nav-pill-custom">Technology</a>
                @endif
                @if (!empty($product->applications) && $product->applications->count() > 0)
                <a href="#apps" class="nav-pill-custom">Applications</a>
                @endif
                @if (!empty($product->boxContents) && $product->boxContents->count() > 0)
                <a href="#box" class="nav-pill-custom">In The Box</a>
                @endif
                @if (!empty($product->faqs) && $product->faqs->count() > 0)
                <a href="#faq" class="nav-pill-custom">FAQ</a>
                @endif
            </div>
            <div class="text-primary mt-2">
                <a href="#overview" class="up-down-link">
                    <img src="{{ theme_asset('img/products/down.png') }}" alt="arrow-up-down">
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Quantity & Buy Button -->
            <div class="row">
                <div class="col-4">
                    <div class="input-group border border-secondary-subtle rounded">
                        <button class="btn btn-outline-secondary border-0 px-4" type="button" id="minusBtn"
                            onclick="decrementQty()">-</button>
                        <input type="text"
                            class="form-control text-center bg-white text-dark border-0 fw-bold py-3" id="qtyInput"
                            value="1" readonly>
                        <button class="btn btn-outline-secondary border-0 px-4" type="button" id="plusBtn"
                            onclick="incrementQty()">+</button>
                    </div>
                </div>
                <div class="col-8">
                    <button class="btn btn-primary w-100 py-3 fw-bold btn-buy-now" id="buyNowBtn"
                        onclick="buyNow({{ $product->id }})">BUY NOW</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sub-Nav Bar (Tabs) -->
<div class="container-fluid bottom-tabs-bar" id="standardTabsBar">
    <div class="container d-flex justify-content-between overflow-auto gap-4 text-nowrap">
        <a href="#overview" class="bottom-tab-link active">OVERVIEW</a>
        @if (!empty($product->productAttributes) && $product->productAttributes->count() > 0)
        <a href="#specs" class="bottom-tab-link">SPECIFICATIONS</a>
        @endif
        @if (!empty($product->features) && $product->features->count() > 0)
        <a href="#features" class="bottom-tab-link">FEATURES</a>
        @endif
        @if (!empty($product->technologies) && $product->technologies->count() > 0)
        <a href="#tech" class="bottom-tab-link">TECHNOLOGY</a>
        @endif
        @if (!empty($product->applications) && $product->applications->count() > 0)
        <a href="#apps" class="bottom-tab-link">APPLICATIONS</a>
        @endif
        @if (!empty($product->boxContents) && $product->boxContents->count() > 0)
        <a href="#box" class="bottom-tab-link">IN THE BOX</a>
        @endif
        @if (!empty($product->faqs) && $product->faqs->count() > 0)
        <a href="#faq" class="bottom-tab-link">FAQ</a>
        @endif
    </div>
</div>

<!-- Section 1: Overview -->
<section id="overview" class="container py-5 my-4">
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <div class="text-uppercase text-muted small fw-bold mb-2"
                style="font-size: 0.7rem; letter-spacing: 1.5px;">OVERVIEW</div>
            <h2 class="fw-bold mb-4 text-dark title-2" style="letter-spacing: -0.5px;">
                {{ $product->name ?? 'Versatility Without Compromise' }}
            </h2>
            <p class="text-secondary small mb-4" style="line-height: 1.7; font-size: 0.875rem;">
                {{ $product->description->description ?? 'The ' . ($product->name ?? 'AIRE System') . ' represents a paradigm shift in air engineering. Designed for the most demanding technical environments while remaining sophisticated enough for professional urban use, it provides a seamless transition between critical laboratory work and high-density metropolitan mobility.' }}
            </p>
            <p class="text-secondary small mb-5" style="line-height: 1.7; font-size: 0.875rem;">
                {{ $product->description->summary ?? 'Engineered with ultra-pure filtration media and active airflow delivery, every component works synchronously to shield your respiratory zone without impedance or thermal accumulation.' }}
            </p>
            <div class="row g-4 pt-2">
                @if (!empty($product->productAttributes) && $product->productAttributes->count() >= 4)
                @foreach ($product->productAttributes->take(4) as $attr)
                <div class="col-6">
                    <div class="border-start border-2 border-primary ps-3">
                        <h3 class="fw-bold text-dark mb-1 fs-18">{{ $attr->details }}</h3>
                        <span class="text-muted small fs-12">{{ $attr->name }}</span>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-6">
                    <div class="border-start border-2 border-primary ps-3">
                        <h3 class="fw-bold text-dark mb-1 fs-18">99.97%</h3>
                        <span class="text-muted small fs-12">HEPA H13 Efficiency</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border-start border-2 border-primary ps-3">
                        <h3 class="fw-bold text-dark mb-1 fs-18">&lt; 24dB</h3>
                        <span class="text-muted small fs-12">Whisper Quiet</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border-start border-2 border-primary ps-3">
                        <h3 class="fw-bold text-dark mb-1 fs-18">IoT Cloud</h3>
                        <span class="text-muted small fs-12">Smart Mobile App</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border-start border-2 border-primary ps-3">
                        <h3 class="fw-bold text-dark mb-1 fs-18">12 Months</h3>
                        <span class="text-muted small fs-12">Filter Lifespan</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="col-lg-6">
            <div class="overview-img-box text-center">
                <img src="{{ !empty($product->main_image) && !str_contains($product->main_image, 'placehold.co') ? getImageUrl($product->main_image) : theme_asset('img/products/product_overview.png') }}"
                    alt="{{ $product->name }}" class="img-fluid rounded-4 shadow-sm"
                    style="max-height: 520px; object-fit: contain;">
            </div>
        </div>
    </div>
</section>

<!-- Section 2: Technical Specifications -->
@if (!empty($product->productAttributes) && $product->productAttributes->count() > 0)
<section id="specs" class="section-alt py-5 position-relative overflow-hidden"
    style="scroll-margin-top: 80px;">
    <div class="container py-4 text-center position-relative z-2">
        <div class="text-uppercase text-muted small fw-bold mb-2"
            style="font-size: 0.7rem; letter-spacing: 1.5px;">
            SPECIFICATIONS</div>
        <h2 class="fw-bold mb-2 text-dark title-2" style="letter-spacing: -0.5px;">Technical Specifications</h2>
        <p class="text-secondary small mb-5">Laboratory-validated performance metrics and component architecture
            for
            {{ $product->name ?? 'AIRE System' }}.
        </p>

        <!-- Exploded Technical View Banner with Universal Parallax Background -->
        <div class="w-100 mb-5 position-relative overflow-hidden rounded-4 border bg-dark shadow-lg parallax-window"
            style="min-height: 380px;">
            <div class="parallax-slider" data-parallax-speed="8"
                style="background-image: url('{{ !empty($product->main_image) && !str_contains($product->main_image, 'placehold.co') ? getImageUrl($product->main_image) : theme_asset('img/products/specs.png') }}');">
            </div>
            <div class="parallax-overlay"
                style="background: linear-gradient(180deg, rgba(13, 27, 42, 0.4) 0%, rgba(13, 27, 42, 0.9) 100%);">
            </div>
            <div
                class="position-relative z-1 p-5 d-flex flex-column justify-content-end h-100 text-start parallax-content">
                <span class="badge bg-primary px-3 py-2 mb-2 text-uppercase fw-bold fs-11"
                    style="width: fit-content;">ARCHITECTURE</span>
                <h3 class="fw-bold text-white mb-2 fs-22">Advanced Multi-Stage Engineering</h3>
                <p class="text-light opacity-75 small mb-0" style="max-width: 600px;">Precision-calibrated airflow
                    chambers and filtration matrix engineered for zero untreated bypass air.</p>
            </div>
        </div>

        <!-- 4-Card Spec Highlights Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5 text-start">
            @foreach ($product->productAttributes->take(4) as $idx => $attr)
            <div class="col">
                <div
                    class="p-4 bg-white rounded-4 border shadow-sm h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h3 class="text-dark fw-bold mb-3" style="font-size: 1.5rem;">0{{ $idx + 1 }}
                        </h3>
                        <div class="text-uppercase text-muted fw-bold mb-2"
                            style="font-size: 0.7rem; letter-spacing: 1px;">{{ $attr->name }}</div>
                    </div>
                    <h4 class="fw-bold text-dark fs-18 mb-0">{{ $attr->details }}</h4>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Full Spec Sheet Table -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden text-start">
            <div
                class="card-header bg-dark text-white py-3 px-4 d-flex align-items-center justify-content-between">
                <span class="fw-bold fs-14 text-uppercase tracking-wider"><i class="bi bi-cpu me-2"></i>Complete
                    Technical Spec Sheet</span>
                <span class="badge bg-primary px-3 py-2 fs-12">Verified AIRE Specs</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <tbody>
                            @foreach ($product->productAttributes as $idx => $attr)
                            <tr class="{{ $idx % 2 === 0 ? 'bg-light' : 'bg-white' }}">
                                <td class="fw-bold text-dark px-4 py-3 border-end" style="width: 35%;">
                                    <i
                                        class="bi bi-check-circle-fill text-primary me-2"></i>{{ $attr->name }}
                                </td>
                                <td class="text-secondary px-4 py-3 fw-semibold">
                                    {{ $attr->details }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Section 3: Features -->
@if (!empty($product->features) && $product->features->count() > 0)
<section id="features" class="container py-5 my-4 position-relative" style="scroll-margin-top: 80px;">
    <div class="text-center mb-5">
        <div class="text-uppercase text-muted small fw-bold mb-2"
            style="font-size: 0.7rem; letter-spacing: 1.5px;">
            FEATURES</div>
        <h2 class="fw-bold mb-2 text-dark title-2" style="letter-spacing: -0.5px;">Precision Engineered Details
        </h2>
        <p class="text-secondary small" style="max-width: 600px; margin: 0 auto;">The
            {{ $product->name ?? 'AIRE System' }} is a masterclass in
            industrial design, where every component is optimized for performance, durability, and user comfort.
        </p>
    </div>

    <!-- Banner with Universal Parallax Background & 3 Glassmorphism Cards Overlay -->
    <div class="precision-banner container parallax-window mb-4">
        <div class="parallax-slider" data-parallax-speed="8"
            style="background-image: url('{{ !empty($product->main_image) && !str_contains($product->main_image, 'placehold.co') ? getImageUrl($product->main_image) : theme_asset('img/products/features.png') }}');">
        </div>
        <div class="parallax-overlay"
            style="background: linear-gradient(180deg, rgba(11, 19, 41, 0.2) 0%, rgba(11, 19, 41, 0.9) 100%);">
        </div>
        <div class="row g-4 w-100 pb-2 parallax-content">
            @foreach ($product->features as $fItem)
            <div class="col-lg-4">
                <div class="precision-card-item h-100">
                    <div class="precision-icon-box mb-3">
                        <i class="{{ $fItem->icon ?: 'bi bi-shield-check' }}"></i>
                    </div>
                    <h3 class="fw-bold mb-2 text-white" style="font-size: 1.05rem;">{{ $fItem->title }}</h3>
                    <p class="text-light opacity-75 small mb-0" style="font-size: 0.8rem; line-height: 1.6;">
                        {{ $fItem->description }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Section 4: Technology -->
@if (!empty($product->technologies) && $product->technologies->count() > 0)
<section id="tech" class="container py-5 my-4 position-relative" style="scroll-margin-top: 80px;">
    @php $mainTech = $product->technologies->first(); @endphp
    <div class="text-center mb-5">
        <div class="text-uppercase text-muted small fw-bold mb-2"
            style="font-size: 0.7rem; letter-spacing: 1.5px;">
            TECHNOLOGY</div>
        <h2 class="fw-bold mb-2 text-dark title-2" style="letter-spacing: -0.5px;">
            {{ $mainTech->title ?? 'The Physics of Pure Air' }}
        </h2>
        <p class="text-secondary small" style="max-width: 650px; margin: 0 auto;">
            {{ $mainTech->description ?? 'Beyond simple filtration, AIRE utilizes fluid dynamics and active sensor arrays to maintain a stable positive-pressure environment.' }}
        </p>
    </div>

    <!-- Banner with Universal Parallax Background & Glassmorphism Overlay Card -->
    <div class="physics-banner mb-5 parallax-window">
        <div class="parallax-slider" data-parallax-speed="8"
            style="background-image: url('{{ !empty($mainTech->image) && !str_contains($mainTech->image, 'placehold.co') ? (str_starts_with($mainTech->image, 'upload/') ? getImageUrl($mainTech->image) : theme_asset($mainTech->image)) : theme_asset('img/airpro_mask_fb2.png') }}');">
        </div>
        <div class="parallax-overlay"
            style="background: linear-gradient(180deg, rgba(13, 27, 42, 0.3) 0%, rgba(13, 27, 42, 0.85) 100%);">
        </div>
        <div class="position-relative z-1 parallax-content" style="max-width: 420px;">
            <div
                style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 16px; padding: 24px; color: #fff;">
                <h3 class="fw-bold mb-2" style="font-size: 0.9rem; letter-spacing: 0.5px;">
                    {{ strtoupper($mainTech->subtitle ?? 'ACTIVE POSITIVE PRESSURE') }}
                </h3>
                <p class="text-light opacity-90 small mb-0" style="font-size: 0.8rem; line-height: 1.6;">
                    {{ $mainTech->description }}
                </p>
            </div>
        </div>
    </div>

    <!-- 3-Column Numbered Features Grid -->
    <div class="row g-4">
        @foreach ($product->technologies as $tIdx => $tItem)
        <div class="col-lg-4">
            <div class="p-4 bg-white rounded-4 border shadow-sm h-100">
                <h2 class="text-dark fw-bold mb-3" style="font-size: 1.75rem;">0{{ $tIdx + 1 }}</h2>
                <div class="text-uppercase text-muted fw-bold mb-2"
                    style="font-size: 0.7rem; letter-spacing: 1px;">
                    {{ strtoupper($tItem->subtitle ?: $tItem->title) }}
                </div>
                <p class="text-secondary small mb-0" style="line-height: 1.6;">{{ $tItem->description }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- Section 5: Applications -->
@if (!empty($product->applications) && $product->applications->count() > 0)
<section id="apps" class="container py-5 my-4" style="scroll-margin-top: 80px;">
    <div class="text-center mb-5">
        <div class="text-uppercase text-muted small fw-bold mb-2"
            style="font-size: 0.7rem; letter-spacing: 1.5px;">
            APPLICATIONS</div>
        <h2 class="fw-bold mb-2 text-dark title-2" style="letter-spacing: -0.5px;">Industrial Excellence, Personal
            Comfort</h2>
        <p class="text-secondary small" style="max-width: 650px; margin: 0 auto;">The
            {{ $product->name ?? 'AIRE System' }} is designed to exceed safety standards in the most demanding
            environments, from high-tech labs to urban commutes.
        </p>
    </div>

    <div class="row g-4">
        @foreach ($product->applications as $aIdx => $aItem)
        <div class="{{ $aIdx % 3 === 2 ? 'col-12' : ($aIdx % 3 === 0 ? 'col-lg-8' : 'col-lg-4') }}">
            <div class="app-card parallax-window"
                style="min-height: {{ $aIdx % 3 === 2 ? '300px' : '280px' }};">
                <div class="parallax-slider" data-parallax-speed="6"
                    style="background-image: url('{{ !empty($aItem->image) ? (str_starts_with($aItem->image, 'upload/') ? getImageUrl($aItem->image) : theme_asset($aItem->image)) : ($aIdx === 0 ? theme_asset('img/products/R&D Laboratories1.png') : ($aIdx === 1 ? theme_asset('img/products/Precision Manufacturing.png') : theme_asset('img/products/Urban Mobility.png'))) }}');">
                </div>
                <div class="parallax-overlay"
                    style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.8) 100%);">
                </div>
                <div class="app-card-content p-4">
                    @if ($aItem->tag)
                    <div class="badge bg-primary rounded-pill px-3 py-2 mb-2 text-uppercase fw-bold"
                        style="font-size: 0.65rem; letter-spacing: 1px;">{{ $aItem->tag }}</div>
                    @endif
                    <h3 class="fw-bold mb-2 text-white {{ $aIdx % 3 === 2 ? 'title-2' : '' }}">
                        {{ $aItem->title }}
                    </h3>
                    <p class="text-light opacity-90 small mb-0"
                        style="font-size: {{ $aIdx % 3 === 2 ? '0.9rem' : '0.85rem' }}; max-width: 500px;">
                        {{ $aItem->description }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- Section 6: In The Box -->
@if (!empty($product->boxContents) && $product->boxContents->count() > 0)
<section id="box" class="py-5 bg-white" style="scroll-margin-top: 80px;">
    <div class="container py-4">
        <div class="text-center mb-5">
            <div class="text-uppercase text-muted small fw-bold mb-2"
                style="font-size: 0.7rem; letter-spacing: 1.5px;">IN THE BOX</div>
            <h2 class="fw-bold text-dark title-2">Box Contents & Accessories</h2>
        </div>

        <!-- Dynamic Box Contents Grid -->
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3">
            @foreach ($product->boxContents as $boxItem)
            <div class="col">
                <div class="box-item-card">
                    <div class="box-item-img-box">
                        <img src="{{ !empty($boxItem->image) ? (str_starts_with($boxItem->image, 'upload/') ? getImageUrl($boxItem->image) : theme_asset($boxItem->image)) : (!empty($product->main_image) && !str_contains($product->main_image, 'placehold.co') ? getImageUrl($product->main_image) : theme_asset('img/airpro_mask_fb2.png')) }}"
                            alt="{{ $boxItem->item_name }}" class="img-fluid box-item-img">
                    </div>
                    <h3 class="fw-bold mb-1 text-dark" style="font-size: 0.8rem;">
                        {{ strtoupper($boxItem->item_name) }}
                    </h3>
                    <span class="text-muted small fw-bold" style="font-size: 0.7rem;">QTY:
                        {{ $boxItem->quantity }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Section 7: FAQ -->
@if (!empty($product->faqs) && $product->faqs->count() > 0)
<section id="faq" class="container my-5" style="scroll-margin-top: 80px;">
    <div class="container">
        <div class="text-center mb-5">
            <div class="text-uppercase text-muted small fw-bold mb-2"
                style="font-size: 0.7rem; letter-spacing: 1.5px;">SUPPORT</div>
            <h2 class="fw-bold text-dark title-2">Frequently Asked Questions</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="accordion custom-accordion" id="faqAccordion">
                    @foreach ($product->faqs as $fIdx => $faqItem)
                    <div class="accordion-item mb-3 border rounded-3 overflow-hidden">
                        <h2 class="accordion-header">
                            <button
                                class="accordion-button {{ $fIdx !== 0 ? 'collapsed' : '' }} fw-bold text-dark"
                                type="button" data-bs-toggle="collapse"
                                data-bs-target="#faqItem{{ $faqItem->id }}">
                                {{ $faqItem->question }}
                            </button>
                        </h2>
                        <div id="faqItem{{ $faqItem->id }}"
                            class="accordion-collapse collapse {{ $fIdx === 0 ? 'show' : '' }}"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary small">
                                {{ $faqItem->answer }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
    function changeMainImage(url, el) {
        const mainImg = document.getElementById('mainProductImg');
        if (mainImg) {
            mainImg.src = url;
        }
        document.querySelectorAll('.thumb-preview').forEach(t => t.classList.remove('active'));
        if (el) {
            el.classList.add('active');
        }
    }

    function incrementQty() {
        const el = document.getElementById('qtyInput');
        if (el) {
            el.value = parseInt(el.value || '1', 10) + 1;
        }
    }

    function decrementQty() {
        const el = document.getElementById('qtyInput');
        if (el && parseInt(el.value || '1', 10) > 1) {
            el.value = parseInt(el.value || '1', 10) - 1;
        }
    }

    function buyNow(productId) {
        const qty = document.getElementById('qtyInput')?.value || 1;
        window.location.href = "{{ url('/checkout') }}?product_id=" + productId + "&quantity=" + qty;
    }

    // Sticky Bar Scroll and ScrollSpy
    document.addEventListener('DOMContentLoaded', () => {
        const stickyBar = document.getElementById('productStickyBar');
        const topSection = document.getElementById('productTopSection');

        window.addEventListener('scroll', () => {
            if (topSection && stickyBar) {
                const topBottom = topSection.getBoundingClientRect().bottom;
                if (topBottom < 100) {
                    stickyBar.classList.add('show-sticky');
                } else {
                    stickyBar.classList.remove('show-sticky');
                }
            }
        });

        // Smooth Scroll for Navigation Tab Links
        const navTabLinks = document.querySelectorAll('.bottom-tab-link, .nav-pill-custom');
        navTabLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const targetId = link.getAttribute('href');
                if (targetId && targetId.startsWith('#')) {
                    const targetEl = document.querySelector(targetId);
                    if (targetEl) {
                        e.preventDefault();
                        targetEl.scrollIntoView({
                            behavior: 'smooth'
                        });
                        navTabLinks.forEach(l => l.classList.remove('active'));
                        document.querySelectorAll(`a[href="${targetId}"]`).forEach(l => l
                            .classList.add('active'));
                    }
                }
            });
        });
    });
</script>
@endpush