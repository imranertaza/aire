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
            max-height: 400px;
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
            padding: 10px 12px;
            font-size: 0.73rem;
            font-weight: 700;
            background: #ffffff;
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: 0.2px;
            color: var(--text-main);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: 46px;
        }

        .feature-check-box span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
            width: 100%;
        }

        .feature-check-box i {
            font-size: 1.05rem;
            color: #198754;
            font-weight: bold;
            flex-shrink: 0;
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

        /* Slidable Vertical Thumbnail Slider */
        .product-thumb-column {
            height: 100%;
            max-height: 100%;
            overflow-y: auto;
            scroll-behavior: smooth;
            -ms-overflow-style: none;
            scrollbar-width: none;
            padding-right: 2px;
        }

        .product-thumb-column::-webkit-scrollbar {
            display: none;
        }

        .thumb-nav-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid var(--border-light);
            background: #ffffff;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .thumb-nav-btn:hover {
            background: var(--primary-blue);
            color: #ffffff;
            border-color: var(--primary-blue);
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
    <!-- Sticky Header Bar (Reveals on Scroll down) -->
    <div class="sticky-product-header" id="stickyProductHeader">
        <div class="container sticky-bar-top pb-0">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ !empty($product->main_image) ? getImageUrl($product->main_image) : theme_asset('img/airpro_mask_fb2.png') }}"
                        alt="{{ $product->name ?? 'Airpro Mask FB2' }}" class="sticky-thumb">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark fs-6">{{ $product->name ?? 'Airpro Mask FB2' }}</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.75rem;">Next-Generation Active Wearable Air
                            Purifier</p>
                    </div>
                </div>
                <div class="text-primary text-center">
                    <a href="#productTopSection" class="up-down-link">
                        <img src="{{ theme_asset('img/products/up.png') }}" alt="arrow-up-down">
                    </a>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="fw-bold fs-4 text-dark me-2">${{ number_format($product->price ?? 249) }}</div>
                    <div class="input-group border border-secondary-subtle rounded" style="width: 110px; height: 44px">
                        <button class="btn btn-outline-secondary btn-sm border-0 sticky-minus-btn" type="button">-</button>
                        <input type="text"
                            class="form-control form-control-sm text-center bg-white text-dark border-0 fw-bold sticky-qty-input"
                            value="1" readonly>
                        <button class="btn btn-outline-secondary btn-sm border-0 sticky-plus-btn" type="button">+</button>
                    </div>
                    <button class="btn btn-primary btn-buy-now px-4 py-2" style="height: 44px;"
                        data-product-id="{{ $product->id }}">BUY NOW</button>
                </div>
            </div>
        </div>
        <!-- Embedded Sticky Tabs Bar -->
        <div class="container d-flex justify-content-between overflow-auto gap-4 text-nowrap">
            <a href="#overview" class="bottom-tab-link active">OVERVIEW</a>
            <a href="#specs" class="bottom-tab-link">SPECIFICATIONS</a>
            <a href="#features" class="bottom-tab-link">FEATURES</a>
            <a href="#tech" class="bottom-tab-link">TECHNOLOGY</a>
            <a href="#apps" class="bottom-tab-link">APPLICATIONS</a>
            <a href="#box" class="bottom-tab-link">IN THE BOX</a>
            <a href="#faq" class="bottom-tab-link">FAQ</a>
        </div>
    </div>

    <!-- Product Main Top Section -->
    <section class="container py-3" id="productTopSection">
        <!-- Breadcrumb -->
        <div class="cart-breadcrumb text-muted fs-13 mb-3">
            <a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a> &nbsp;&gt;&nbsp;
            <a href="{{ route('products.index') }}" class="text-decoration-none text-muted">Products</a> &nbsp;&gt;&nbsp;
            <span class="text-dark fw-bold">{{ strtoupper($product->name ?? 'AIRPRO MASK FB2') }}</span>
        </div>

        <div class="row g-5">
            <!-- Product Image Gallery (Dynamic Thumbnails + Main View) -->
            <div class="col-lg-6">
                @php
                    $galleryImages = [];
                    if (!empty($product->main_image)) {
                        $galleryImages[] = getImageUrl($product->main_image);
                    }
                    if (!empty($product->images) && count($product->images) > 0) {
                        foreach ($product->images as $imgObj) {
                            $imgPath = $imgObj->image ?? ($imgObj->image_path ?? '');
                            if ($imgPath) {
                                $fullUrl = getImageUrl($imgPath);
                                if (!in_array($fullUrl, $galleryImages)) {
                                    $galleryImages[] = $fullUrl;
                                }
                            }
                        }
                    }
                    if (empty($galleryImages)) {
                        $galleryImages = [
                            theme_asset('img/airpro_mask_fb2.png'),
                            theme_asset('img/aire_mini.png'),
                            theme_asset('img/Air-Purify.png'),
                        ];
                    }
                    $primaryImage = $galleryImages[0];
                @endphp
                <div class="d-flex gap-3 align-items-stretch" style="height: 400px;">
                    <div class="product-thumb-column d-flex flex-column gap-3 overflow-auto h-100" id="thumbScrollContainer"
                        style="max-width: 89px;">
                        @foreach ($galleryImages as $index => $imgUrl)
                            <img src="{{ $imgUrl }}" data-large="{{ $imgUrl }}"
                                class="img-fluid cursor-pointer thumb-img {{ $index === 0 ? 'active' : '' }}"
                                alt="{{ $product->name ?? 'Product Image' }} Thumbnail {{ $index + 1 }}">
                        @endforeach
                    </div>
                    <div
                        class="flex-1 main-image-wrapper p-4 text-center position-relative overflow-hidden cursor-crosshair h-100 d-flex align-items-center justify-content-center">
                        <div class="d-flex justify-content-between position-absolute top-0 start-0 w-100 p-3 z-1">
                            <span class="badge-render">NEW ARRIVAL</span>
                        </div>
                        <img src="{{ $primaryImage }}" id="mainProductImg" class="img-fluid"
                            style="max-height: 100%; object-fit: contain;" alt="{{ $product->name ?? 'Product Image' }}">
                        <div class="zoom-image-container d-none position-absolute top-0 start-0 w-100 h-100 bg-white"
                            id="zoomContainer"
                            style="background-repeat: no-repeat; background-size: 220% 220%; z-index: 5; pointer-events: none; opacity: 0; transition: opacity 0.2s ease;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Info & Actions -->
            <div class="col-lg-6">
                <div class="text-uppercase text-muted small fw-bold tracking-wider mb-1"
                    style="font-size: 0.7rem; letter-spacing: 1px;">PERSONAL AIR SYSTEMS</div>

                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h1 class="fw-bold mb-0 text-dark title-2">{{ $product->name ?? 'Airpro Mask FB2' }}</h1>
                    <h2 class="text-dark fw-bold mb-0 title-2">${{ number_format($product->price, 2) }}</h2>
                </div>

                <p class="text-muted small mb-3">Next-Generation Active Wearable Air Purifier</p>

                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="text-primary fs-6">★★★★★</div>
                    <span class="text-muted small fw-semibold">4.8 (123 Certified Reviews)</span>
                </div>

                <!-- Vertical Scroll Wrapper -->
                <div class="overflow-y-auto pe-2 mb-4 product-desc-scroll" data-lenis-prevent>
                    <p class="text-secondary small mb-4 product-desc-text">
                        {{ $product->description->description ?? 'Engineered for precision and protection. The AIRE Airpro Mask FB2 combines industrial-grade H13 HEPA filtration with intelligent airflow sensors to deliver laboratory-clean air in a sophisticated, ergonomic form factor.' }}
                    </p>

                    <!-- 2x2 Feature Check Cards -->
                    @if ($product->productAttributes && $product->productAttributes->count() > 0)
                        <div class="row g-2 mb-4">
                            @foreach ($product->productAttributes->take(4) as $attr)
                                @php
                                    $label = $attr->details ?? $attr->name;
                                    if (
                                        $attr->details &&
                                        \Illuminate\Support\Str::contains(strtolower($attr->name), ['cadr'])
                                    ) {
                                        $label = $attr->details . ' CADR';
                                    }
                                @endphp
                                <div class="col-6">
                                    <div class="feature-check-box" title="{{ $attr->name }}: {{ $attr->details }}">
                                        <i class="bi bi-check-lg"></i>
                                        <span>{{ strtoupper($label) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
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
                    @endif

                    @php
                        $groupedOptions = [];
                        if (!empty($product->productOptions) && count($product->productOptions) > 0) {
                            foreach ($product->productOptions as $pOpt) {
                                $optName = $pOpt->option->name ?? 'Option';
                                $groupedOptions[$optName]['type'] = $pOpt->option->type ?? 'radio';
                                $groupedOptions[$optName]['items'][] = $pOpt;
                            }
                        }
                    @endphp

                    @if (!empty($groupedOptions))
                        @foreach ($groupedOptions as $optionName => $optionData)
                            @php
                                $isColorOption = \Illuminate\Support\Str::contains(strtolower($optionName), [
                                    'color',
                                    'colour',
                                ]);
                                $isSizeOption = \Illuminate\Support\Str::contains(strtolower($optionName), ['size']);
                            @endphp

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label
                                        class="form-label small text-muted fw-bold mb-0 option-label-sm text-uppercase">SELECT
                                        {{ $optionName }}</label>
                                    @if ($isSizeOption)
                                        <a href="#"
                                            class="small text-decoration-underline text-muted fw-semibold size-guide-link">SIZE
                                            GUIDE</a>
                                    @endif
                                </div>

                                <div class="d-flex gap-2 flex-wrap align-items-center">
                                    @foreach ($optionData['items'] as $index => $po)
                                        @php
                                            $valName = $po->optionValue->name ?? '';
                                            $valId = $po->option_value_id;
                                            $firstChar = mb_substr($valName, 0, 1);
                                            $isHexColor = $firstChar === '#' && strlen($valName) === 7;
                                            $priceAdd =
                                                $po->price && floatval($po->price) > 0
                                                    ? ' (' .
                                                        ($po->price_prefix ?? '+') .
                                                        '$' .
                                                        number_format($po->price, 2) .
                                                        ')'
                                                    : '';
                                        @endphp

                                        @if ($isHexColor || $isColorOption)
                                            <div class="color-swatch {{ $index === 0 ? 'active' : '' }}"
                                                title="{{ $valName }}" data-color="{{ $valName }}"
                                                data-option-id="{{ $po->option_id }}"
                                                data-option-name="{{ $optionName }}"
                                                data-value-id="{{ $valId }}"
                                                style="background-color: {{ $isHexColor ? $valName : strtolower(str_replace(' ', '', $valName)) }};">
                                            </div>
                                        @else
                                            <button type="button" class="size-btn {{ $index === 0 ? 'active' : '' }}"
                                                data-option-id="{{ $po->option_id }}"
                                                data-option-name="{{ $optionName }}"
                                                data-value-id="{{ $valId }}">
                                                {{ $valName }}{{ $priceAdd }}
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                    @endif
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-6 text-center">
                <div class="d-flex justify-content-center flex-wrap gap-2 mb-1">
                    <a href="#overview" class="nav-pill-custom active">Overview</a>
                    <a href="#specs" class="nav-pill-custom">Specifications</a>
                    <a href="#features" class="nav-pill-custom">Features</a>
                    <a href="#tech" class="nav-pill-custom">Technology</a>
                    <a href="#apps" class="nav-pill-custom">Applications</a>
                    <a href="#box" class="nav-pill-custom">In The Box</a>
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
                            <button class="btn btn-outline-secondary border-0 px-4" type="button"
                                id="minusBtn">-</button>
                            <input type="text"
                                class="form-control text-center bg-white text-dark border-0 fw-bold py-3" id="qtyInput"
                                value="1" readonly>
                            <button class="btn btn-outline-secondary border-0 px-4" type="button"
                                id="plusBtn">+</button>
                        </div>
                    </div>
                    @php
                        $inCompare = in_array($product->id, session()->get('compare', []));
                        $inWishlist = in_array($product->id, session()->get('favorites', []));
                    @endphp
                    <div class="col-8 d-flex gap-2 flex-wrap align-items-center">
                        <button class="btn btn-outline-primary py-3 fw-bold btn-add-to-cart-detail flex-grow-1"
                            data-product-id="{{ $product->id }}">ADD TO CART</button>
                        <button class="btn btn-primary py-3 fw-bold btn-buy-now flex-grow-1"
                            data-product-id="{{ $product->id }}">BUY NOW</button>
                        <button
                            class="btn {{ $inCompare ? 'btn-primary text-white' : 'btn-outline-secondary' }} py-3 fw-semibold btn-add-to-compare"
                            data-product-id="{{ $product->id }}"
                            title="{{ $inCompare ? 'In Comparison List' : 'Add to Compare' }}" style="min-width: 48px;">
                            <i class="bi bi-bar-chart-steps"></i>
                        </button>
                        <button
                            class="btn {{ $inWishlist ? 'btn-danger text-white' : 'btn-outline-secondary' }} py-3 fw-semibold btn-toggle-favorite"
                            data-product-id="{{ $product->id }}"
                            title="{{ $inWishlist ? 'In Wishlist' : 'Add to Wishlist' }}" style="min-width: 48px;">
                            <i class="bi {{ $inWishlist ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sub-Nav Bar (Tabs) -->
    <div class="container-fluid bottom-tabs-bar" id="standardTabsBar">
        <div class="container d-flex justify-content-between overflow-auto gap-4 text-nowrap">
            <a href="#overview" class="bottom-tab-link active">OVERVIEW</a>
            <a href="#specs" class="bottom-tab-link">SPECIFICATIONS</a>
            <a href="#features" class="bottom-tab-link">FEATURES</a>
            <a href="#tech" class="bottom-tab-link">TECHNOLOGY</a>
            <a href="#apps" class="bottom-tab-link">APPLICATIONS</a>
            <a href="#box" class="bottom-tab-link">IN THE BOX</a>
            <a href="#faq" class="bottom-tab-link">FAQ</a>
        </div>
    </div>

    <!-- Section 1: Overview -->
    @php
        $overview = $product->overview;
        $desc = $product->description;
        $overviewTitle = $overview?->title ?: ($desc?->meta_title ?: $product->name . ' — Advanced Air Systems');
        $overviewText =
            $overview?->description ?:
            ($desc?->description ?:
            'Designed for the most demanding technical environments while remaining sophisticated enough for professional urban use, providing a seamless transition between critical technical spaces and everyday clean air environments.');
        $overviewImage = $overview?->image
            ? getImageUrl($overview->image)
            : ($desc?->description_image
                ? getImageUrl($desc->description_image)
                : ($product->main_image
                    ? getImageUrl($product->main_image)
                    : theme_asset('img/products/AIRE Airpro Mask FB2 Technical Visualization.png')));

        // Dynamic attribute lookups
        $cadrAttr =
            $product->productAttributes->firstWhere('name', 'CADR Rating')?->details ??
            ($product->productAttributes->firstWhere('name', 'CADR')?->details ?? null);
        $filterAttr =
            $product->productAttributes->firstWhere('name', 'Filter Grade')?->details ??
            ($product->productAttributes->firstWhere('name', 'Filter')?->details ?? null);
        $firstCategory = $product->categories->first();

        // Feature 1
        $feat1Icon = $overview?->feature1_icon ?: ($desc?->feature1_icon ?: 'bi bi-shield-check');
        $feat1Title = $overview?->feature1_title ?: ($desc?->feature1_title ?: 'CRITICAL ENVIRONMENTS');
        $feat1Desc =
            $overview?->feature1_desc ?:
            ($desc?->feature1_desc ?:
            ($cadrAttr
                ? 'Certified Output: ' . $cadrAttr . '. Engineered for high-purity air delivery.'
                : 'Engineered for cleanrooms, laboratories, and precision fabrication facilities.'));

        // Feature 2
        $feat2Icon = $overview?->feature2_icon ?: ($desc?->feature2_icon ?: 'bi bi-buildings');
        $feat2Title = $overview?->feature2_title ?: ($desc?->feature2_title ?: 'URBAN RESILIENCE');
        $feat2Desc =
            $overview?->feature2_desc ?:
            ($desc?->feature2_desc ?:
            ($filterAttr
                ? 'Filter Grade: ' . $filterAttr . '. High efficiency protection against particulate matter.'
                : 'Protection against high-density metropolitan particulate and allergens.'));
    @endphp

    <section id="overview" class="container py-5 my-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="text-uppercase text-muted small fw-bold mb-2"
                    style="font-size: 0.7rem; letter-spacing: 1.5px;">Overview</div>
                <h2 class="fw-bold mb-4 text-dark title-2" style="letter-spacing: -0.5px;">
                    {{ $overviewTitle }}
                </h2>
                <div class="text-secondary small mb-4 lh-lg" style="font-size: 0.875rem;">
                    {!! nl2br(e($overviewText)) !!}
                </div>

                <!-- Feature Card 1 -->
                <div class="overview-feature-card p-3 mb-3 d-flex align-items-start gap-3">
                    <div class="fs-4 text-dark mt-1">
                        <i class="{{ $feat1Icon }}"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1 text-dark" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                            {{ strtoupper($feat1Title) }}
                        </h3>
                        <p class="text-muted small mb-0" style="font-size: 0.8rem; line-height: 1.5;">
                            {{ $feat1Desc }}
                        </p>
                    </div>
                </div>

                <!-- Feature Card 2 -->
                <div class="overview-feature-card p-3 d-flex align-items-start gap-3">
                    <div class="fs-4 text-dark mt-1">
                        <i class="{{ $feat2Icon }}"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1 text-dark" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                            {{ strtoupper($feat2Title) }}
                        </h3>
                        <p class="text-muted small mb-0" style="font-size: 0.8rem; line-height: 1.5;">
                            {{ $feat2Desc }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side Image Banner with Parallax -->
            <div class="col-lg-6">
                <div class="position-relative rounded-4 overflow-hidden shadow-sm parallax-window"
                    style="background-color: #0b1329; border: 1px solid var(--border-light); min-height: 420px;">
                    <div class="parallax-slider" data-parallax-speed="6"
                        style="background-image: url('{{ $overviewImage }}'); background-size: cover; background-repeat: no-repeat; background-position: center;">
                    </div>
                    <div class="parallax-overlay"
                        style="background: radial-gradient(circle, rgba(37,99,235,0.15) 0%, rgba(11,19,41,0) 70%);">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Technical Specifications -->
    @php
        $desc = $product->description;
        $hasSpecs =
            $desc &&
            ($desc->specs_badge ||
                $desc->specs_title ||
                $desc->specs_description ||
                $desc->specs_image ||
                $desc->spec1_value ||
                $desc->spec1_badge ||
                $desc->spec1_desc ||
                $desc->spec2_value ||
                $desc->spec2_badge ||
                $desc->spec2_desc ||
                $desc->spec3_value ||
                $desc->spec3_badge ||
                $desc->spec3_desc ||
                $desc->spec4_value ||
                $desc->spec4_badge ||
                $desc->spec4_desc);
    @endphp

    @if ($hasSpecs)
        <section id="specs" class="section-alt py-5 position-relative overflow-hidden">
            <div class="container py-4 text-center position-relative z-2">
                @if ($desc->specs_badge || $desc->specs_title || $desc->specs_description)
                    <div class="text-center mb-5">
                        @if ($desc->specs_badge)
                            <div class="text-uppercase text-muted small fw-bold mb-2"
                                style="font-size: 0.7rem; letter-spacing: 1.5px;">
                                {{ $desc->specs_badge }}
                            </div>
                        @endif
                        @if ($desc->specs_title)
                            <h2 class="fw-bold mb-2 text-dark title-2" style="letter-spacing: -0.5px;">
                                {{ $desc->specs_title }}
                            </h2>
                        @endif
                        @if ($desc->specs_description)
                            <p class="text-secondary small mb-0" style="max-width: 650px; margin: 0 auto;">
                                {{ $desc->specs_description }}
                            </p>
                        @endif
                    </div>
                @endif

                <!-- Exploded Technical View Banner with Universal Parallax Background -->
                @php
                    $specsBgImage = $desc->specs_image ? getImageUrl($desc->specs_image) : null;
                @endphp
                @if ($specsBgImage)
                    <div class="w-100 mb-5 position-relative overflow-hidden rounded-4 border bg-dark shadow-lg parallax-window"
                        style="min-height: 440px;">
                        <div class="parallax-slider" data-parallax-speed="8"
                            style="background-image: url('{{ $specsBgImage }}'); background-size: cover;">
                        </div>
                        <div class="parallax-overlay"
                            style="background: radial-gradient(circle, rgba(13, 110, 253, 0.05) 0%, rgba(11, 19, 41, 0.4) 100%);">
                        </div>
                    </div>
                @endif

                <!-- Stats Grid (Up to 4 Columns) -->
                @php
                    $hasStat1 = $desc->spec1_value || $desc->spec1_badge || $desc->spec1_desc;
                    $hasStat2 = $desc->spec2_value || $desc->spec2_badge || $desc->spec2_desc;
                    $hasStat3 = $desc->spec3_value || $desc->spec3_badge || $desc->spec3_desc;
                    $hasStat4 = $desc->spec4_value || $desc->spec4_badge || $desc->spec4_desc;
                    $statCount = ($hasStat1 ? 1 : 0) + ($hasStat2 ? 1 : 0) + ($hasStat3 ? 1 : 0) + ($hasStat4 ? 1 : 0);
                    $statColClass = match ($statCount) {
                        1 => 'col-12',
                        2 => 'col-md-6',
                        3 => 'col-md-4',
                        default => 'col-md-3 col-sm-6',
                    };
                @endphp

                @if ($statCount > 0)
                    <div class="row g-4 text-start">
                        @if ($hasStat1)
                            <div class="{{ $statColClass }}">
                                <div
                                    class="p-4 bg-white rounded-4 border shadow-sm h-100 d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        @if ($desc->spec1_icon)
                                            <i class="{{ $desc->spec1_icon }} fs-4 text-dark"></i>
                                        @endif
                                        @if ($desc->spec1_badge)
                                            <span class="text-uppercase text-muted fw-bold"
                                                style="font-size: 0.65rem; letter-spacing: 1px;">{{ $desc->spec1_badge }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($desc->spec1_value)
                                            <h3 class="fw-bold text-dark mb-1" style="font-size: 2.2rem;">
                                                {{ $desc->spec1_value }}
                                                @if ($desc->spec1_unit)
                                                    <span class="fs-5 fw-normal text-muted">{{ $desc->spec1_unit }}</span>
                                                @endif
                                            </h3>
                                        @endif
                                        @if ($desc->spec1_desc)
                                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">
                                                {{ $desc->spec1_desc }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($hasStat2)
                            <div class="{{ $statColClass }}">
                                <div
                                    class="p-4 bg-white rounded-4 border shadow-sm h-100 d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        @if ($desc->spec2_icon)
                                            <i class="{{ $desc->spec2_icon }} fs-4 text-dark"></i>
                                        @endif
                                        @if ($desc->spec2_badge)
                                            <span class="text-uppercase text-muted fw-bold"
                                                style="font-size: 0.65rem; letter-spacing: 1px;">{{ $desc->spec2_badge }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($desc->spec2_value)
                                            <h3 class="fw-bold text-dark mb-1" style="font-size: 2.2rem;">
                                                {{ $desc->spec2_value }}
                                                @if ($desc->spec2_unit)
                                                    <span class="fs-5 fw-normal text-muted">{{ $desc->spec2_unit }}</span>
                                                @endif
                                            </h3>
                                        @endif
                                        @if ($desc->spec2_desc)
                                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">
                                                {{ $desc->spec2_desc }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($hasStat3)
                            <div class="{{ $statColClass }}">
                                <div
                                    class="p-4 bg-white rounded-4 border shadow-sm h-100 d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        @if ($desc->spec3_icon)
                                            <i class="{{ $desc->spec3_icon }} fs-4 text-dark"></i>
                                        @endif
                                        @if ($desc->spec3_badge)
                                            <span class="text-uppercase text-muted fw-bold"
                                                style="font-size: 0.65rem; letter-spacing: 1px;">{{ $desc->spec3_badge }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($desc->spec3_value)
                                            <h3 class="fw-bold text-dark mb-1" style="font-size: 2.2rem;">
                                                {{ $desc->spec3_value }}
                                                @if ($desc->spec3_unit)
                                                    <span class="fs-5 fw-normal text-muted">{{ $desc->spec3_unit }}</span>
                                                @endif
                                            </h3>
                                        @endif
                                        @if ($desc->spec3_desc)
                                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">
                                                {{ $desc->spec3_desc }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($hasStat4)
                            <div class="{{ $statColClass }}">
                                <div
                                    class="p-4 bg-white rounded-4 border shadow-sm h-100 d-flex flex-column justify-content-between">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        @if ($desc->spec4_icon)
                                            <i class="{{ $desc->spec4_icon }} fs-4 text-dark"></i>
                                        @endif
                                        @if ($desc->spec4_badge)
                                            <span class="text-uppercase text-muted fw-bold"
                                                style="font-size: 0.65rem; letter-spacing: 1px;">{{ $desc->spec4_badge }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($desc->spec4_value)
                                            <h3 class="fw-bold text-dark mb-1" style="font-size: 2.2rem;">
                                                {{ $desc->spec4_value }}
                                                @if ($desc->spec4_unit)
                                                    <span class="fs-5 fw-normal text-muted">{{ $desc->spec4_unit }}</span>
                                                @endif
                                            </h3>
                                        @endif
                                        @if ($desc->spec4_desc)
                                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">
                                                {{ $desc->spec4_desc }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Section 3: Features -->
    @php
        $desc = $product->description;
        $hasFeatures =
            $desc &&
            ($desc->features_badge ||
                $desc->features_title ||
                $desc->features_description ||
                $desc->features_image ||
                $desc->feature1_title ||
                $desc->feature1_desc ||
                $desc->feature2_title ||
                $desc->feature2_desc ||
                $desc->feature3_title ||
                $desc->feature3_desc);
    @endphp

    @if ($hasFeatures)
        <section id="features" class="container py-5 my-4 position-relative">
            @if ($desc->features_badge || $desc->features_title || $desc->features_description)
                <div class="text-center mb-5">
                    @if ($desc->features_badge)
                        <div class="text-uppercase text-muted small fw-bold mb-2"
                            style="font-size: 0.7rem; letter-spacing: 1.5px;">
                            {{ $desc->features_badge }}
                        </div>
                    @endif
                    @if ($desc->features_title)
                        <h2 class="fw-bold mb-2 text-dark title-2" style="letter-spacing: -0.5px;">
                            {{ $desc->features_title }}
                        </h2>
                    @endif
                    @if ($desc->features_description)
                        <p class="text-secondary small" style="max-width: 600px; margin: 0 auto;">
                            {{ $desc->features_description }}
                        </p>
                    @endif
                </div>
            @endif

            <!-- Banner with Universal Parallax Background & 3 Glassmorphism Cards Overlay -->
            @php
                $featImg = $desc->features_image;
                $featBgImage = $featImg ? getImageUrl($featImg) : null;

                $hasCard1 = $desc->feature1_title || $desc->feature1_desc;
                $hasCard2 = $desc->feature2_title || $desc->feature2_desc;
                $hasCard3 = $desc->feature3_title || $desc->feature3_desc;
                $cardCount = ($hasCard1 ? 1 : 0) + ($hasCard2 ? 1 : 0) + ($hasCard3 ? 1 : 0);
                $cardColClass = $cardCount === 1 ? 'col-lg-12' : ($cardCount === 2 ? 'col-lg-6' : 'col-lg-4');
            @endphp

            @if ($featBgImage || $cardCount > 0)
                <div class="precision-banner container parallax-window">
                    @if ($featBgImage)
                        <div class="parallax-slider" data-parallax-speed="8"
                            style="background-image: url('{{ $featBgImage }}');"></div>
                        <div class="parallax-overlay"
                            style="background: linear-gradient(180deg, rgba(11, 19, 41, 0.2) 0%, rgba(11, 19, 41, 0.9) 100%);">
                        </div>
                    @endif
                    @if ($cardCount > 0)
                        <div class="row g-4 w-100 pb-2 parallax-content">
                            @if ($hasCard1)
                                <div class="{{ $cardColClass }}">
                                    <div class="precision-card-item h-100">
                                        @if ($desc->feature1_icon)
                                            <div class="precision-icon-box">
                                                <i class="{{ $desc->feature1_icon }}"></i>
                                            </div>
                                        @endif
                                        @if ($desc->feature1_title)
                                            <h3 class="fw-bold mb-2 text-white" style="font-size: 1.05rem;">
                                                {{ $desc->feature1_title }}
                                            </h3>
                                        @endif
                                        @if ($desc->feature1_desc)
                                            <p class="text-light opacity-75 small mb-0"
                                                style="font-size: 0.8rem; line-height: 1.6;">
                                                {{ $desc->feature1_desc }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if ($hasCard2)
                                <div class="{{ $cardColClass }}">
                                    <div class="precision-card-item h-100">
                                        @if ($desc->feature2_icon)
                                            <div class="precision-icon-box">
                                                <i class="{{ $desc->feature2_icon }}"></i>
                                            </div>
                                        @endif
                                        @if ($desc->feature2_title)
                                            <h3 class="fw-bold mb-2 text-white" style="font-size: 1.05rem;">
                                                {{ $desc->feature2_title }}
                                            </h3>
                                        @endif
                                        @if ($desc->feature2_desc)
                                            <p class="text-light opacity-75 small mb-0"
                                                style="font-size: 0.8rem; line-height: 1.6;">
                                                {{ $desc->feature2_desc }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if ($hasCard3)
                                <div class="{{ $cardColClass }}">
                                    <div class="precision-card-item h-100">
                                        @if ($desc->feature3_icon)
                                            <div class="precision-icon-box">
                                                <i class="{{ $desc->feature3_icon }}"></i>
                                            </div>
                                        @endif
                                        @if ($desc->feature3_title)
                                            <h3 class="fw-bold mb-2 text-white" style="font-size: 1.05rem;">
                                                {{ $desc->feature3_title }}
                                            </h3>
                                        @endif
                                        @if ($desc->feature3_desc)
                                            <p class="text-light opacity-75 small mb-0"
                                                style="font-size: 0.8rem; line-height: 1.6;">
                                                {{ $desc->feature3_desc }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </section>
    @endif

    <!-- Section 4: Technology -->
    @php
        $desc = $product->description;
        $hasTech =
            $desc &&
            ($desc->technology_badge ||
                $desc->technology_title ||
                $desc->technology_description ||
                $desc->technology_image ||
                $desc->technology_card_title ||
                $desc->technology_card_description ||
                $desc->tech_feature1_title ||
                $desc->tech_feature1_desc ||
                $desc->tech_feature2_title ||
                $desc->tech_feature2_desc ||
                $desc->tech_feature3_title ||
                $desc->tech_feature3_desc);
    @endphp

    @if ($hasTech)
        <section id="tech" class="container py-5 my-4 position-relative">
            @if ($desc->technology_badge || $desc->technology_title || $desc->technology_description)
                <div class="text-center mb-5">
                    @if ($desc->technology_badge)
                        <div class="text-uppercase text-muted small fw-bold mb-2"
                            style="font-size: 0.7rem; letter-spacing: 1.5px;">
                            {{ $desc->technology_badge }}
                        </div>
                    @endif
                    @if ($desc->technology_title)
                        <h2 class="fw-bold mb-2 text-dark title-2" style="letter-spacing: -0.5px;">
                            {{ $desc->technology_title }}
                        </h2>
                    @endif
                    @if ($desc->technology_description)
                        <p class="text-secondary small" style="max-width: 650px; margin: 0 auto;">
                            {{ $desc->technology_description }}
                        </p>
                    @endif
                </div>
            @endif

            <!-- Banner with Universal Parallax Background & Glassmorphism Overlay Card -->
            @php
                $techImg = $desc->technology_image;
                $techBgImage = $techImg ? getImageUrl($techImg) : null;
                $hasCard = $desc->technology_card_title || $desc->technology_card_description;
            @endphp

            @if ($techBgImage || $hasCard)
                <div class="physics-banner mb-5 parallax-window">
                    @if ($techBgImage)
                        <div class="parallax-slider" data-parallax-speed="8"
                            style="background-image: url('{{ $techBgImage }}');"></div>
                        <div class="parallax-overlay"
                            style="background: linear-gradient(180deg, rgba(13, 27, 42, 0.3) 0%, rgba(13, 27, 42, 0.85) 100%);">
                        </div>
                    @endif
                    @if ($hasCard)
                        <div class="position-relative z-1 parallax-content" style="max-width: 420px;">
                            <div
                                style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 16px; padding: 24px; color: #fff;">
                                @if ($desc->technology_card_title)
                                    <h3 class="fw-bold mb-2" style="font-size: 0.9rem; letter-spacing: 0.5px;">
                                        {{ $desc->technology_card_title }}
                                    </h3>
                                @endif
                                @if ($desc->technology_card_description)
                                    <p class="text-light opacity-90 small mb-0"
                                        style="font-size: 0.8rem; line-height: 1.6;">
                                        {{ $desc->technology_card_description }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- 3-Column Numbered Features Grid -->
            @php
                $hasF1 = $desc->tech_feature1_title || $desc->tech_feature1_desc;
                $hasF2 = $desc->tech_feature2_title || $desc->tech_feature2_desc;
                $hasF3 = $desc->tech_feature3_title || $desc->tech_feature3_desc;
                $featCount = ($hasF1 ? 1 : 0) + ($hasF2 ? 1 : 0) + ($hasF3 ? 1 : 0);
                $colClass = $featCount === 1 ? 'col-lg-12' : ($featCount === 2 ? 'col-lg-6' : 'col-lg-4');
            @endphp

            @if ($featCount > 0)
                <div class="row g-4">
                    @if ($hasF1)
                        <div class="{{ $colClass }}">
                            <div class="p-4 bg-white rounded-4 border shadow-sm h-100">
                                <h2 class="text-dark fw-bold mb-3" style="font-size: 1.75rem;">01</h2>
                                @if ($desc->tech_feature1_title)
                                    <div class="text-uppercase text-muted fw-bold mb-2"
                                        style="font-size: 0.7rem; letter-spacing: 1px;">
                                        {{ $desc->tech_feature1_title }}
                                    </div>
                                @endif
                                @if ($desc->tech_feature1_desc)
                                    <p class="text-secondary small mb-0" style="line-height: 1.6;">
                                        {{ $desc->tech_feature1_desc }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if ($hasF2)
                        <div class="{{ $colClass }}">
                            <div class="p-4 bg-white rounded-4 border shadow-sm h-100">
                                <h2 class="text-dark fw-bold mb-3" style="font-size: 1.75rem;">02</h2>
                                @if ($desc->tech_feature2_title)
                                    <div class="text-uppercase text-muted fw-bold mb-2"
                                        style="font-size: 0.7rem; letter-spacing: 1px;">
                                        {{ $desc->tech_feature2_title }}
                                    </div>
                                @endif
                                @if ($desc->tech_feature2_desc)
                                    <p class="text-secondary small mb-0" style="line-height: 1.6;">
                                        {{ $desc->tech_feature2_desc }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if ($hasF3)
                        <div class="{{ $colClass }}">
                            <div class="p-4 bg-white rounded-4 border shadow-sm h-100">
                                <h2 class="text-dark fw-bold mb-3" style="font-size: 1.75rem;">03</h2>
                                @if ($desc->tech_feature3_title)
                                    <div class="text-uppercase text-muted fw-bold mb-2"
                                        style="font-size: 0.7rem; letter-spacing: 1px;">
                                        {{ $desc->tech_feature3_title }}
                                    </div>
                                @endif
                                @if ($desc->tech_feature3_desc)
                                    <p class="text-secondary small mb-0" style="line-height: 1.6;">
                                        {{ $desc->tech_feature3_desc }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </section>
    @endif

    <!-- Section 5: Applications -->
    @if ($product->applications && $product->applications->count() > 0)
        <section id="apps" class="container py-5 my-4">
            @if ($desc?->applications_title || $desc?->applications_description)
                <div class="text-center mb-5">
                    <div class="text-uppercase text-muted small fw-bold mb-2"
                        style="font-size: 0.7rem; letter-spacing: 1.5px;">
                        APPLICATIONS</div>
                    @if ($desc?->applications_title)
                        <h2 class="fw-bold mb-2 text-dark title-2" style="letter-spacing: -0.5px;">
                            {{ $desc->applications_title }}
                        </h2>
                    @endif
                    @if ($desc?->applications_description)
                        <p class="text-secondary small" style="max-width: 650px; margin: 0 auto;">
                            {{ $desc->applications_description }}
                        </p>
                    @endif
                </div>
            @endif

            <div class="row g-4">
                @foreach ($product->applications as $index => $appItem)
                    @php
                        $gridCol =
                            $appItem->grid_width ?:
                            ($index === 0
                                ? 'col-lg-8'
                                : ($index === 1
                                    ? 'col-lg-4'
                                    : 'col-12'));
                        $appImg = $appItem->bg_image ?: $appItem->image;
                        $bgImage = $appImg ? getImageUrl($appImg) : null;
                    @endphp
                    <div class="{{ $gridCol }}">
                        <div class="app-card parallax-window"
                            style="min-height: {{ $gridCol === 'col-12' ? '300px' : '280px' }};">
                            <div class="parallax-slider" data-parallax-speed="6"
                                style="background-image: url('{{ $bgImage }}');"></div>
                            <div class="parallax-overlay"
                                style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.8) 100%);">
                            </div>
                            <div class="app-card-content">
                                @if (!empty($appItem->badge))
                                    <div class="badge bg-primary rounded-pill px-3 py-2 mb-2 text-uppercase fw-bold"
                                        style="font-size: 0.65rem; letter-spacing: 1px;">{{ $appItem->badge }}</div>
                                @endif
                                <h3 class="fw-bold mb-2 text-white {{ $gridCol === 'col-12' ? 'title-2' : '' }}">
                                    {{ $appItem->title }}</h3>
                                @if (!empty($appItem->description))
                                    <p class="text-light opacity-90 small mb-0"
                                        style="font-size: {{ $gridCol === 'col-12' ? '0.9rem' : '0.85rem' }}; max-width: {{ $gridCol === 'col-12' ? '500px' : '100%' }};">
                                        {{ $appItem->description }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Section 6: Related Products -->
    @if (!empty($relatedProducts) && $relatedProducts->count() > 0)
        <section id="box" class="py-5 bg-white">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <div class="text-uppercase text-muted small fw-bold mb-2"
                        style="font-size: 0.7rem; letter-spacing: 1.5px;">IN THE BOX</div>
                    <h2 class="fw-bold text-dark title-2">Related Products</h2>
                </div>

                <!-- 6 Item Grid -->
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3">
                    @foreach ($relatedProducts as $relProduct)
                        <div class="col">
                            <a href="{{ route('products.detail', $relProduct->slug ?: $relProduct->id) }}"
                                class="text-decoration-none">
                                <div class="box-item-card h-100 d-flex flex-column">
                                    <div class="box-item-img-box flex-grow-1">
                                        <img src="{{ $relProduct->main_image ? getImageUrl($relProduct->main_image) : theme_asset('img/airpro_mask_fb2.png') }}"
                                            alt="{{ $relProduct->name }}" class="img-fluid box-item-img">
                                    </div>
                                    <h3 class="fw-bold mb-1 text-dark text-truncate" style="font-size: 0.8rem;"
                                        title="{{ $relProduct->name }}">
                                        {{ strtoupper($relProduct->name) }}
                                    </h3>
                                    <span class="text-primary small fw-bold" style="font-size: 0.75rem;">
                                        ${{ number_format($relProduct->price, 2) }}
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Downloads Section Placeholder -->
    <div id="downloads" class="d-none"></div>

    <!-- Section 7: FAQ -->
    @if ($product->faqs && $product->faqs->count() > 0)
        <section id="faq" class="container my-4">
            <div class="container">
                <div class="text-center mb-5">
                    <div class="text-uppercase text-muted small fw-bold mb-2"
                        style="font-size: 0.7rem; letter-spacing: 1.5px;">SUPPORT</div>
                    <h2 class="fw-bold text-dark title-2">Frequently Asked Questions</h2>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="accordion custom-accordion" id="faqAccordion">
                            @foreach ($product->faqs as $index => $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFaq{{ $faq->id ?? $index }}">
                                        <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faqCollapse{{ $faq->id ?? $index }}"
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                            aria-controls="faqCollapse{{ $faq->id ?? $index }}">
                                            {{ $faq->question }}
                                        </button>
                                    </h2>
                                    <div id="faqCollapse{{ $faq->id ?? $index }}"
                                        class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            {!! nl2br(e($faq->answer)) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).ready(function() {
                // Quantity Increment / Decrement logic
                $('#plusBtn, .sticky-plus-btn').on('click', function() {
                    let currentVal = parseInt($('#qtyInput').val());
                    let newVal = currentVal + 1;
                    $('#qtyInput, .sticky-qty-input').val(newVal);
                });

                $('#minusBtn, .sticky-minus-btn').on('click', function() {
                    let currentVal = parseInt($('#qtyInput').val());
                    if (currentVal > 1) {
                        let newVal = currentVal - 1;
                        $('#qtyInput, .sticky-qty-input').val(newVal);
                    }
                });

                // Dynamic Thumbnail switching logic with smooth fade effect
                $(document).on('click', '.thumb-img', function() {
                    $('.thumb-img').removeClass('active');
                    $(this).addClass('active');
                    let largeImageSrc = $(this).attr('data-large');
                    $('#mainProductImg').fadeOut(120, function() {
                        $(this).attr('src', largeImageSrc).fadeIn(120);
                    });
                });

                // Slidable Vertical Thumbnail Navigation (Up/Down Buttons)
                $('#thumbNavUp').on('click', function() {
                    const container = document.getElementById('thumbScrollContainer');
                    if (container) {
                        container.scrollBy({
                            top: -110,
                            behavior: 'smooth'
                        });
                    }
                });

                $('#thumbNavDown').on('click', function() {
                    const container = document.getElementById('thumbScrollContainer');
                    if (container) {
                        container.scrollBy({
                            top: 110,
                            behavior: 'smooth'
                        });
                    }
                });

                // Image Hover Zoom Effect (cCart Reference Feature)
                const $mainWrapper = $('.main-image-wrapper');
                const $zoomBox = $('#zoomContainer');

                $mainWrapper.on('mouseenter', function() {
                    const currentSrc = $('#mainProductImg').attr('src');
                    $zoomBox.css('background-image', 'url("' + currentSrc + '")').removeClass(
                        'd-none').css('opacity', 1);
                }).on('mouseleave', function() {
                    $zoomBox.addClass('d-none').css('opacity', 0);
                }).on('mousemove', function(e) {
                    const offset = $(this).offset();
                    const width = $(this).width();
                    const height = $(this).height();
                    const mouseX = e.pageX - offset.left;
                    const mouseY = e.pageY - offset.top;

                    const posX = (mouseX / width) * 100;
                    const posY = (mouseY / height) * 100;

                    $zoomBox.css('background-position', posX + '% ' + posY + '%');
                });

                // Color Swatch Selection (scoped to option group)
                $(document).on('click', '.color-swatch', function() {
                    // Only deactivate swatches within the same option group
                    $(this).closest('.d-flex.gap-2').find('.color-swatch').removeClass('active');
                    $(this).addClass('active');
                });

                // Size / Generic Option Button Selection (scoped to option group)
                $(document).on('click', '.size-btn', function() {
                    // Only deactivate buttons within the same option group
                    $(this).closest('.d-flex.gap-2').find('.size-btn').removeClass('active');
                    $(this).addClass('active');
                });

                // Sticky Header & Active Nav Scroll logic
                const stickyHeader = $('#stickyProductHeader');
                const productTop = $('#productTopSection');

                $(window).on('scroll', function() {
                    let scrollTop = $(this).scrollTop();
                    let productBottom = productTop.offset().top + productTop.outerHeight() - 100;

                    if (scrollTop > productBottom) {
                        stickyHeader.addClass('is-sticky');
                    } else {
                        stickyHeader.removeClass('is-sticky');
                    }

                    // Scrollspy active section tab sync
                    const sections = $('section[id], div[id]');
                    sections.each(function() {
                        let top = $(this).offset().top - 120;
                        let bottom = top + $(this).outerHeight();
                        let id = $(this).attr('id');

                        if (scrollTop >= top && scrollTop <= bottom) {
                            $('.bottom-tab-link, .nav-pill-custom').removeClass('active');
                            $(`.bottom-tab-link[href="#${id}"], .nav-pill-custom[href="#${id}"]`)
                                .addClass('active');
                        }
                    });
                });

                // Smooth Scroll to Section when clicking tabs or pills
                $('.bottom-tab-link, .nav-pill-custom').on('click', function(e) {
                    let targetHref = $(this).attr('href');
                    if (targetHref.startsWith('#')) {
                        e.preventDefault();
                        let targetSection = $(targetHref);
                        if (targetSection.length) {
                            $('html, body').animate({
                                scrollTop: targetSection.offset().top - 100
                            }, 400);
                        }
                    }
                });

                // Scroll to Top button click
                $('#scrollTopBtn').on('click', function() {
                    $('html, body').animate({
                        scrollTop: 0
                    }, 400);
                });

                // Universal Parallax Plugin Engine
                function initUniversalParallax() {
                    const sliders = [];
                    const $sliders = $('.parallax-slider');

                    if (!$sliders.length) return;

                    $sliders.each(function() {
                        const el = this;
                        const speed = parseFloat(el.getAttribute('data-parallax-speed')) || 6;
                        const container = el.closest('.parallax-window') || el.parentElement;

                        sliders.push({
                            el: el,
                            speed: speed,
                            container: container,
                            currentY: 0,
                            targetY: 0
                        });
                    });

                    let windowHeight = $(window).height();

                    $(window).on('resize', function() {
                        windowHeight = $(window).height();
                    });

                    function render() {
                        sliders.forEach(item => {
                            if (!item.container) return;
                            const rect = item.container.getBoundingClientRect();

                            if (rect.top < windowHeight && rect.bottom > 0) {
                                const centerOffset = (rect.top + rect.height / 2) - (windowHeight /
                                    2);
                                item.targetY = -(centerOffset / item.speed);
                            }

                            item.currentY += (item.targetY - item.currentY) * 0.12;
                            item.el.style.transform =
                                `translate3d(0, ${item.currentY.toFixed(1)}px, 0)`;
                        });

                        requestAnimationFrame(render);
                    }

                    render();
                }

                initUniversalParallax();
            });
        });
    </script>
@endpush
