@extends('themes.default.layouts.master')

@php
    $productDesc = $product->description;
    $seoTitle = !empty($productDesc?->meta_title)
        ? $productDesc->meta_title
        : ($product->name ?? 'Product Details') . ' | AIRE';

    $seoDescription = !empty($productDesc?->meta_description)
        ? $productDesc->meta_description
        : (!empty($productDesc?->description)
            ? \Illuminate\Support\Str::limit(strip_tags($productDesc->description), 160)
            : 'Explore ' . ($product->name ?? 'AIRE product') . ' - advanced clean air solutions and technology.');

    $seoKeywords = $productDesc?->meta_keyword ?? '';

    $rawImg = !empty($product->main_image) ? $product->main_image : (!empty($product->image) ? $product->image : '');
    $productImg = !empty($rawImg) ? getImagePath($rawImg) : theme_asset('img/logo.png');
    $productImgUrl = str_starts_with($productImg, 'http') ? $productImg : url($productImg);

    $canonicalUrl = route('products.detail', $product->slug ?? $product->id);
    $brandName = $product->brand?->name ?? 'AIRE';
    $sku = $product->product_code ?? ($product->model ?? 'AIRE-' . $product->id);
    $currentPrice =
        (float) ($product->special && $product->special->price > 0 ? $product->special->price : $product->price ?? 0);
    $inStock = ($product->quantity ?? 0) > 0;
    $currency = 'USD';
    $primaryCat = $product->categories->first();
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDescription)
@if (!empty($seoKeywords))
    @section('meta_keywords', $seoKeywords)
@endif
@section('og_image', $productImgUrl)
@section('og_type', 'product')
@section('canonical_url', $canonicalUrl)

@push('head')
    <!-- Search Engine Directives & Core Web Vitals Optimization -->
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="preload" as="image" href="{{ $productImgUrl }}" fetchpriority="high">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $productImgUrl }}">

    <!-- Open Graph Product Extensions -->
    <meta property="product:price:amount" content="{{ number_format($currentPrice, 2, '.', '') }}">
    <meta property="product:price:currency" content="{{ $currency }}">
    <meta property="product:availability" content="{{ $inStock ? 'in stock' : 'out of stock' }}">
    <meta property="product:brand" content="{{ $brandName }}">

    <!-- Schema.org Product Structured Data (Google Shopping & Search) -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org/",
        "@type": "Product",
        "name": {!! json_encode($product->name ?? '') !!},
        "image": [
            {!! json_encode($productImgUrl) !!}
        ],
        "description": {!! json_encode($seoDescription) !!},
        "sku": {!! json_encode($sku) !!},
        "mpn": {!! json_encode($product->model ?? $sku) !!},
        "brand": {
            "@type": "Brand",
            "name": {!! json_encode($brandName) !!}
        },
        "offers": {
            "@type": "Offer",
            "url": {!! json_encode($canonicalUrl) !!},
            "priceCurrency": {!! json_encode($currency) !!},
            "price": "{{ number_format($currentPrice, 2, '.', '') }}",
            "priceValidUntil": "{{ date('Y-12-31', strtotime('+1 year')) }}",
            "itemCondition": "https://schema.org/NewCondition",
            "availability": "{{ $inStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
            "seller": {
                "@type": "Organization",
                "name": "AIRE"
            }
        }
        @if(!empty($product->average_feedback) && $product->average_feedback > 0)
        ,"aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "{{ $product->average_feedback }}",
            "reviewCount": "5"
        }
        @endif
    }
    </script>

    <!-- Schema.org BreadcrumbList Structured Data -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": "{{ route('home') }}"
            }
            @if ($primaryCat && $primaryCat->parent)
            ,{
                "@type": "ListItem",
                "position": 2,
                "name": {!! json_encode($primaryCat->parent->category_name) !!},
                "item": "{{ route('category.show', $primaryCat->parent->slug ?? $primaryCat->parent->id) }}"
            }
            ,{
                "@type": "ListItem",
                "position": 3,
                "name": {!! json_encode($primaryCat->category_name) !!},
                "item": "{{ route('category.show', $primaryCat->slug ?? $primaryCat->id) }}"
            }
            ,{
                "@type": "ListItem",
                "position": 4,
                "name": {!! json_encode($product->name ?? '') !!},
                "item": "{{ $canonicalUrl }}"
            }
            @elseif ($primaryCat)
            ,{
                "@type": "ListItem",
                "position": 2,
                "name": {!! json_encode($primaryCat->category_name) !!},
                "item": "{{ route('category.show', $primaryCat->slug ?? $primaryCat->id) }}"
            }
            ,{
                "@type": "ListItem",
                "position": 3,
                "name": {!! json_encode($product->name ?? '') !!},
                "item": "{{ $canonicalUrl }}"
            }
            @else
            ,{
                "@type": "ListItem",
                "position": 2,
                "name": "Products",
                "item": "{{ route('products.index') }}"
            }
            ,{
                "@type": "ListItem",
                "position": 3,
                "name": {!! json_encode($product->name ?? '') !!},
                "item": "{{ $canonicalUrl }}"
            }
            @endif
        ]
    }
    </script>

    @if (!empty($product->faqs) && $product->faqs->count() > 0)
        <!-- Schema.org FAQPage Structured Data (Rich Expandable Questions in Google SERP) -->
        <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            @foreach ($product->faqs as $fIndex => $faq)
            {
                "@type": "Question",
                "name": {!! json_encode($faq->question ?? '') !!},
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": {!! json_encode($faq->answer ?? '') !!}
                }
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ]
    }
    </script>
    @endif
@endpush

@push('styles')
    <style>
        :root {
            --primary-blue: var(--color-primary, #1d4ed8);
            --primary-hover: var(--color-primary-hover, #1e40af);
            --accent-blue: var(--color-primary-light, #2563eb);
            --text-main: var(--color-dark, #0f172a);
            --text-muted: var(--color-muted, #64748b);
            --border-light: var(--color-border, #e2e8f0);
            --bg-light-alt: var(--color-bg, #f8fafc);
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
            /* object-fit: contain; */
            background: #f8fafc;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            padding: 4px;
        }

        .sticky-price {
            font-size: 1.5rem;
            line-height: 1.2;
        }

        .sticky-buy-btn {
            height: 44px;
            white-space: nowrap;
            font-weight: 600;
        }

        .sticky-product-title {
            max-width: 260px;
        }

        .sticky-product-header .overflow-auto {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sticky-product-header .overflow-auto::-webkit-scrollbar {
            display: none;
        }

        @media (max-width: 767.98px) {
            .sticky-bar-top {
                padding: 8px 0;
            }

            .sticky-thumb {
                width: 44px;
                height: 44px;
                border-radius: 6px;
                padding: 2px;
            }

            .sticky-product-title {
                max-width: 140px;
                font-size: 0.875rem !important;
            }

            .sticky-price {
                font-size: 1.15rem;
            }

            .sticky-buy-btn {
                height: 38px;
                padding: 6px 14px !important;
                font-size: 0.85rem;
                border-radius: 6px;
            }
        }

        @media (max-width: 380px) {
            .sticky-product-title {
                max-width: 100px;
                font-size: 0.8rem !important;
            }

            .sticky-price {
                font-size: 1rem;
            }

            .sticky-buy-btn {
                height: 36px;
                padding: 5px 10px !important;
                font-size: 0.8rem;
            }
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

        /* Product Gallery Layout */
        .product-gallery-wrapper {
            height: 400px;
            width: 100%;
        }

        /* Image Gallery Thumbnails */
        .product-thumb-column {
            width: 89px;
            max-width: 89px;
            height: 100%;
            max-height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
            scroll-behavior: smooth;
            -ms-overflow-style: none;
            scrollbar-width: none;
            padding-right: 2px;
            cursor: grab;
            user-select: none;
            -webkit-user-select: none;
            touch-action: pan-x pan-y;
        }

        .product-thumb-column.is-dragging {
            cursor: grabbing !important;
            scroll-behavior: auto !important;
        }

        .product-thumb-column.is-dragging * {
            cursor: grabbing !important;
            user-select: none !important;
            pointer-events: none;
        }

        .product-thumb-column::-webkit-scrollbar {
            display: none;
        }

        .thumb-img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            background-color: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 0;
            opacity: 0.85;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            flex-shrink: 0;
            display: block;
            -webkit-user-drag: none;
            -khtml-user-drag: none;
            -moz-user-drag: none;
            -o-user-drag: none;
            user-drag: none;
            user-select: none;
            -webkit-user-select: none;
        }

        .thumb-img:hover {
            opacity: 1;
            border-color: #94a3b8;
            transform: translateY(-1px);
        }

        .thumb-img.active {
            opacity: 1;
            border-color: var(--color-primary, #1d4ed8) !important;
            box-shadow: 0 0 0 2px var(--color-primary-shadow, rgba(29, 78, 216, 0.25));
        }

        /* Main Image Box */
        .main-image-wrapper {
            background-color: #ffffff;
            border: 1px solid var(--border-light);
            position: relative;
            border-radius: 16px;
            height: 100%;
            max-height: 400px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 0 !important;
        }

        .main-image-wrapper #mainProductImg {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Mobile Gallery: Main Image on Top, Thumbnails at Bottom Horizontal */
        @media (max-width: 767.98px) {
            .product-gallery-wrapper {
                height: auto !important;
                flex-direction: column-reverse !important;
                gap: 12px !important;
            }

            .main-image-wrapper {
                height: clamp(280px, 75vw, 380px) !important;
                max-height: none !important;
                border-radius: 14px;
            }

            .product-thumb-column {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                max-height: none !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                overflow-x: auto !important;
                overflow-y: hidden !important;
                padding: 4px 2px !important;
                gap: 10px !important;
                -webkit-overflow-scrolling: touch;
            }

            .thumb-img {
                width: 72px !important;
                height: 72px !important;
                min-width: 72px !important;
                border-radius: 12px !important;
            }
        }

        @media (max-width: 380px) {
            .thumb-img {
                width: 64px !important;
                height: 64px !important;
                min-width: 64px !important;
            }
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
            border-radius: 6px;
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
            border-color: var(--color-primary, #1d4ed8) !important;
            box-shadow: 0 0 0 3px var(--color-primary-shadow, rgba(29, 78, 216, 0.25)) !important;
        }

        /* Thumbnail Navigation Buttons */

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
            border-radius: 6px;
            transition: all 0.2s;
        }

        .size-btn.active,
        .size-btn:hover {
            border-color: var(--primary-blue);
            color: var(--primary-blue);
            background: var(--color-primary-bg, #eff6ff);
        }

        /* Nav Pills Navigation */
        .nav-pill-custom {
            background-color: var(--color-primary-bg, #eff6ff);
            color: var(--color-primary, #1d4ed8);
            border: none;
            font-weight: 500;
            font-size: 12px;
            padding: 6px 8px;
            border-radius: 20px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .nav-pill-custom.active,
        .nav-pill-custom:hover {
            background-color: var(--color-primary, #1d4ed8);
            color: #ffffff;
        }

        /* Buy Button */
        .btn-buy-now {
            background: var(--color-primary, #1d4ed8);
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 16px 12px;
            border-radius: 6px;
            color: #ffffff;
            transition: all 0.2s;
        }

        .btn-buy-now:hover {
            background: var(--color-primary-hover, #1e40af);
            box-shadow: 0 4px 12px var(--color-primary-shadow, rgba(29, 78, 216, 0.3));
            color: #ffffff;
        }

        /* Main Product Purchase Actions Styling */
        .product-purchase-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .product-qty-box {
            width: 120px;
            height: 48px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            overflow: hidden;
            background: #ffffff;
        }

        .product-qty-box .qty-btn {
            width: 38px;
            height: 100%;
            border: none;
            background: transparent;
            color: var(--text-main);
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            cursor: pointer;
            padding: 0;
        }

        .product-qty-box .qty-btn:hover {
            background: #f1f5f9;
        }

        .product-qty-box .qty-input {
            flex: 1;
            width: 100%;
            height: 100%;
            border: none;
            text-align: center;
            font-weight: 700;
            color: var(--text-main);
            background: #ffffff;
            padding: 0;
        }

        .btn-action-cart {
            height: 48px;
            padding: 0 18px;
            border-radius: 8px;
            font-weight: 600;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 1 1 140px;
        }

        .btn-action-buy {
            height: 48px !important;
            padding: 0 18px !important;
            border-radius: 8px;
            font-weight: 600;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 1 1 140px;
        }

        .btn-action-icon {
            width: 48px;
            height: 48px;
            padding: 0 !important;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        @media (max-width: 575.98px) {
            .product-qty-box {
                width: 110px;
                height: 44px;
            }

            .btn-action-cart {
                height: 44px;
                flex: 1 0 calc(100% - 120px);
                font-size: 0.9rem;
            }

            .btn-action-buy {
                height: 44px !important;
                flex: 1 0 calc(100% - 108px);
                font-size: 0.9rem;
            }

            .btn-action-icon {
                width: 44px;
                height: 44px;
            }

            .nav-pill-custom {
                font-size: 11px;
                padding: 6px 8px;
            }
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

        /* Product Tabs Horizontal Scroll Track (Desktop & Mobile) */
        .product-tabs-track,
        .bottom-tabs-bar .overflow-auto,
        .sticky-product-header .overflow-auto {
            cursor: grab;
            user-select: none;
            -webkit-user-select: none;
            scrollbar-width: none;
            -ms-overflow-style: none;
            -webkit-overflow-scrolling: touch;
            touch-action: pan-y pinch-zoom;
        }

        .product-tabs-track::-webkit-scrollbar,
        .bottom-tabs-bar .overflow-auto::-webkit-scrollbar,
        .sticky-product-header .overflow-auto::-webkit-scrollbar {
            display: none;
        }

        .product-tabs-track.is-dragging,
        .bottom-tabs-bar .overflow-auto.is-dragging,
        .sticky-product-header .overflow-auto.is-dragging {
            cursor: grabbing !important;
            scroll-behavior: auto !important;
        }

        .product-tabs-track.is-dragging *,
        .bottom-tabs-bar .overflow-auto.is-dragging *,
        .sticky-product-header .overflow-auto.is-dragging * {
            cursor: grabbing !important;
            user-select: none !important;
            pointer-events: none !important;
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
            flex-shrink: 0;
            white-space: nowrap;
            -webkit-user-drag: none;
            user-drag: none;
            user-select: none;
            -webkit-user-select: none;
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
            border-radius: 24px;
            overflow: hidden;
            background-color: #0b1329;
            min-height: 520px;
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
            padding: 16px;
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            transition: all 0.2s ease;
            overflow: hidden;
            width: 100%;
        }

        .box-item-card:hover .box-item-img-box {
            border-color: #cbd5e1;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            transform: translateY(-3px);
        }

        .box-item-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .box-item-card .box-item-title,
        .box-item-card h3 {
            font-size: clamp(0.725rem, 0.65rem + 0.35vw, 0.9rem) !important;
            font-weight: 700;
            line-height: 1.25;
            color: var(--text-main, #0f172a);
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: 2.5em;
            word-break: break-word;
        }

        .box-item-card .box-item-price {
            font-size: clamp(0.725rem, 0.65rem + 0.25vw, 0.825rem);
            font-weight: 700;
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
            max-height: 260px;
        }
    </style>
@endpush

@section('content')
    @php
        $desc = $product->description;
        $hasSpecs =
            (bool) ($desc &&
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
                    $desc->spec4_desc));
        $hasFeatures =
            (bool) ($desc &&
                ($desc->features_badge ||
                    $desc->features_title ||
                    $desc->features_description ||
                    $desc->features_image ||
                    $desc->feature1_title ||
                    $desc->feature1_desc ||
                    $desc->feature2_title ||
                    $desc->feature2_desc ||
                    $desc->feature3_title ||
                    $desc->feature3_desc));
        $hasTech =
            (bool) ($desc &&
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
                    $desc->tech_feature3_desc));
        $hasApps = (bool) ($product->applications && $product->applications->count() > 0);
        $hasBox = (bool) (!empty($relatedProducts) && $relatedProducts->count() > 0);
        $hasFaq = (bool) ($product->faqs && $product->faqs->count() > 0);
    @endphp
    <!-- Sticky Header Bar (Reveals on Scroll down) -->
    <div class="sticky-product-header" id="stickyProductHeader" data-lenis-prevent>
        <div class="container sticky-bar-top pb-0">
            <div class="d-flex align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2 gap-sm-3 min-w-0">
                    <img src="{{ !empty($product->main_image) ? getImageUrl($product->main_image) : theme_asset('img/airpro_mask_fb2.png') }}"
                        alt="{{ $product->name ?? 'Airpro Mask FB2' }}" class="sticky-thumb flex-shrink-0">
                    <div class="min-w-0">
                        <h6
                            class="fw-bold mb-0 text-dark fs-6 text-truncate sticky-product-title d-flex align-items-center gap-1">
                            <span class="text-truncate">{{ $product->name ?? 'Airpro Mask FB2' }}</span>
                            @if ($product->freeDelivery)
                                <span
                                    class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0 fw-semibold flex-shrink-0"
                                    style="font-size: 0.65rem;">
                                    <i class="bi bi-truck"></i> Free Delivery
                                </span>
                            @endif
                        </h6>
                        <p class="text-muted small mb-0 d-none d-md-block text-truncate" style="font-size: 0.75rem;">
                            Next-Generation Active Wearable Air
                            Purifier</p>
                    </div>
                </div>
                <div class="text-primary text-center d-none d-lg-block">
                    <a href="#productTopSection" class="up-down-link">
                        <img src="{{ theme_asset('img/products/up.png') }}" alt="arrow-up-down">
                    </a>
                </div>
                <div class="d-flex align-items-center gap-2 gap-sm-3 flex-shrink-0">
                    <div class="fw-bold text-dark sticky-price me-1 me-sm-2 text-nowrap" id="stickyProductPrice">
                        @if ($product->special_price)
                            <span
                                class="text-muted text-decoration-line-through me-1 fs-6 fw-normal sticky-original-price">${{ number_format((float) $product->price, 2) }}</span>
                            <span class="sticky-active-price">${{ number_format((float) $product->special_price, 2) }}</span>
                        @else
                            <span class="sticky-active-price">${{ number_format((float) ($product->price ?? 249), 2) }}</span>
                        @endif
                    </div>
                    <div class="input-group border border-secondary-subtle rounded d-none d-md-flex sticky-qty-group"
                        style="width: 110px; height: 44px">
                        <button class="btn btn-outline-secondary btn-sm border-0 sticky-minus-btn" type="button">-</button>
                        <input type="text"
                            class="form-control form-control-sm text-center bg-white text-dark border-0 fw-bold sticky-qty-input"
                            value="1" readonly>
                        <button class="btn btn-outline-secondary btn-sm border-0 sticky-plus-btn" type="button">+</button>
                    </div>
                    <button class="btn btn-primary btn-buy-now sticky-buy-btn px-3 px-sm-4 py-2"
                        data-product-id="{{ $product->id }}">Buy Now</button>
                </div>
            </div>
        </div>
        <!-- Embedded Sticky Tabs Bar -->
        <div class="container d-flex justify-content-between overflow-auto gap-4 text-nowrap product-tabs-track"
            data-lenis-prevent>
            <a href="#overview" class="bottom-tab-link active">OVERVIEW</a>
            @if ($hasSpecs)
                <a href="#specs" class="bottom-tab-link">SPECIFICATIONS</a>
            @endif
            @if ($hasFeatures)
                <a href="#features" class="bottom-tab-link">FEATURES</a>
            @endif
            @if ($hasTech)
                <a href="#tech" class="bottom-tab-link">TECHNOLOGY</a>
            @endif
            @if ($hasApps)
                <a href="#apps" class="bottom-tab-link">APPLICATIONS</a>
            @endif
            @if ($hasBox)
                <a href="#box" class="bottom-tab-link">IN THE BOX</a>
            @endif
            @if ($hasFaq)
                <a href="#faq" class="bottom-tab-link">FAQ</a>
            @endif
        </div>
    </div>

    <!-- Product Main Top Section -->
    <section class="container py-3" id="productTopSection">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="cart-breadcrumb text-muted fs-13 mb-3">
            <ol class="list-unstyled d-flex flex-wrap align-items-center gap-1 mb-0 p-0" style="list-style: none;">
                <li><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="text-muted px-1">&gt;</li>
                @if ($primaryCat)
                    @if ($primaryCat->parent)
                        <li><a href="{{ route('category.show', $primaryCat->parent->slug ?? $primaryCat->parent->id) }}"
                                class="text-decoration-none text-muted">{{ $primaryCat->parent->category_name }}</a></li>
                        <li class="text-muted px-1">&gt;</li>
                    @endif
                    <li><a href="{{ route('category.show', $primaryCat->slug ?? $primaryCat->id) }}"
                            class="text-decoration-none text-muted">{{ $primaryCat->category_name }}</a></li>
                    <li class="text-muted px-1">&gt;</li>
                @else
                    <li><a href="{{ route('products.index') }}" class="text-decoration-none text-muted">Products</a></li>
                    <li class="text-muted px-1">&gt;</li>
                @endif
                <li class="text-dark fw-bold" aria-current="page">{{ strtoupper($product->name ?? 'PRODUCT DETAILS') }}
                </li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Product Image Gallery (Dynamic Thumbnails + Main View) -->
            <div class="col-lg-6">
                @php
                    $rawGallery = [];
                    if (!empty($product->main_image)) {
                        $rawGallery[] = $product->main_image;
                    }
                    if (!empty($product->images) && count($product->images) > 0) {
                        foreach ($product->images as $imgObj) {
                            $imgPath = $imgObj->image ?? ($imgObj->image_path ?? '');
                            if ($imgPath && !in_array($imgPath, $rawGallery)) {
                                $rawGallery[] = $imgPath;
                            }
                        }
                    }
                    $fallbackImages = [
                        'themes/default/assets/img/airpro_mask_fb2.png',
                        'themes/default/assets/img/aire_mini.png',
                        'themes/default/assets/img/AIRE-Pro-S1-Hero.png',
                        'themes/default/assets/img/photograph.png',
                    ];

                    $needed = 4 - count($rawGallery);
                    for ($i = 0; $i < $needed; $i++) {
                        $rawGallery[] = $fallbackImages[$i];
                    }

                    $galleryItems = array_map(function ($path) {
                        return [
                            'thumb' => getImageCacheUrl($path, 160, 160, 'webp'),
                            'large' => getImageCacheUrl($path, 900, 900, 'webp'),
                            'srcset' => getImageSrcset($path, [400, 700, 1000, 1400], 1.0),
                        ];
                    }, $rawGallery);

                    $primaryImage = $galleryItems[0];
                @endphp
                <div
                    class="product-gallery-wrapper d-flex flex-column-reverse flex-md-row gap-2 gap-md-3 align-items-stretch">
                    <div class="product-thumb-column d-flex flex-row flex-md-column gap-2 gap-md-3 overflow-auto"
                        id="thumbScrollContainer" data-lenis-prevent>
                        @foreach ($galleryItems as $index => $item)
                            <img src="{{ $item['thumb'] }}" data-large="{{ $item['large'] }}"
                                data-srcset="{{ $item['srcset'] }}"
                                class="img-fluid cursor-pointer thumb-img {{ $index === 0 ? 'active' : '' }}"
                                draggable="false"
                                alt="{{ $product->name ?? 'Product Image' }} Thumbnail {{ $index + 1 }}">
                        @endforeach
                    </div>
                    <div
                        class="flex-1 main-image-wrapper p-0 text-center position-relative overflow-hidden cursor-crosshair d-flex align-items-center justify-content-center">
                        <div class="d-flex justify-content-between position-absolute top-0 start-0 w-100 p-3 z-1">
                            <span class="badge-render">NEW ARRIVAL</span>
                            @if ($product->freeDelivery)
                                <span
                                    class="badge-render border-success-subtle text-success bg-white fw-bold d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-truck text-success"></i> FREE DELIVERY
                                </span>
                            @endif
                        </div>
                        <img src="{{ $primaryImage['large'] }}"
                            @if (!empty($primaryImage['srcset'])) srcset="{{ $primaryImage['srcset'] }}" @endif
                            sizes="(max-width: 576px) 100vw, (max-width: 992px) 50vw, 650px" fetchpriority="high"
                            id="mainProductImg" class="img-fluid w-100 h-100" style="object-fit: cover;"
                            alt="{{ $product->name ?? 'Product Image' }}">
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
                    <div class="text-end" id="mainProductPriceContainer"
                        data-base-price="{{ (float) ($product->special_price !== null ? $product->special_price : $product->price) }}"
                        data-original-price="{{ (float) $product->price }}"
                        data-has-special="{{ $product->special_price !== null ? '1' : '0' }}">
                        @if ($product->special_price)
                            <span
                                class="text-muted text-decoration-line-through fs-5 d-block main-original-price">${{ number_format((float) $product->price, 2) }}</span>
                            <h2 class="text-dark fw-bold mb-0 title-2 main-active-price">
                                ${{ number_format((float) $product->special_price, 2) }}</h2>
                        @else
                            <h2 class="text-dark fw-bold mb-0 title-2 main-active-price">${{ number_format((float) $product->price, 2) }}
                            </h2>
                        @endif
                    </div>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <p class="text-muted small mb-0">{{ $product->brand->name ?? '' }} {{ $product->model ? '|' : '' }}
                        {{ $product->model ?? '' }} </p>
                    @if ($product->freeDelivery)
                        <span
                            class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 fs-12 fw-semibold d-inline-flex align-items-center gap-1">
                            <i class="bi bi-truck"></i> Free Delivery
                        </span>
                    @endif
                </div>

                {{-- <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="text-primary fs-6">★★★★★</div>
                    <span class="text-muted small fw-semibold">4.8 (123 Certified Reviews)</span>
                </div> --}}

                <!-- Vertical Scroll Wrapper -->
                <div class="overflow-y-auto pe-2 product-desc-scroll" data-lenis-prevent>
                    <p class="text-secondary small mb-4 product-desc-text">
                        {{ $product->description->description ?? 'Engineered for precision and protection. The AIRE Airpro Mask FB2 combines industrial-grade H13 HEPA filtration with intelligent airflow sensors to deliver laboratory-clean air in a sophisticated, ergonomic form factor.' }}
                    </p>

                    <!-- 2x2 Feature Check Cards -->
                    @if ($product->productAttributes && $product->productAttributes->count() > 0)
                        <div class="row g-2 mb-3">
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
                                            $poPrice = (float) ($po->price ?? 0);
                                            $poPrefix = in_array($po->price_prefix, ['+', '-']) ? $po->price_prefix : '+';
                                            $priceAdd =
                                                $poPrice > 0
                                                    ? ' (' .
                                                        $poPrefix .
                                                        '$' .
                                                        number_format($poPrice, 2) .
                                                        ')'
                                                    : '';
                                        @endphp

                                        @if ($isHexColor || $isColorOption)
                                            <div class="color-swatch {{ $index === 0 ? 'active' : '' }}"
                                                title="{{ $valName }}{{ $priceAdd }}" data-color="{{ $valName }}"
                                                data-option-id="{{ $po->option_id }}"
                                                data-option-name="{{ $optionName }}"
                                                data-value-id="{{ $valId }}"
                                                data-price="{{ $poPrice }}"
                                                data-price-prefix="{{ $poPrefix }}"
                                                style="background-color: {{ $isHexColor ? $valName : strtolower(str_replace(' ', '', $valName)) }};">
                                            </div>
                                        @else
                                            <button type="button" class="size-btn {{ $index === 0 ? 'active' : '' }}"
                                                data-option-id="{{ $po->option_id }}"
                                                data-option-name="{{ $optionName }}"
                                                data-value-id="{{ $valId }}"
                                                data-price="{{ $poPrice }}"
                                                data-price-prefix="{{ $poPrefix }}">
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

        <div class="row g-3 align-items-center">
            <div class="col-12 col-md-6 text-center order-1 order-md-1 mb-2 mb-md-0 pt-4">
                <div class="d-flex justify-content-center flex-wrap gap-2 mb-1">
                    <a href="#overview" class="nav-pill-custom active">Overview</a>
                    <a href="#specs" class="nav-pill-custom">Specifications</a>
                    <a href="#features" class="nav-pill-custom">Features</a>
                    <a href="#tech" class="nav-pill-custom">Technology</a>
                    <a href="#apps" class="nav-pill-custom">Applications</a>
                    <a href="#box" class="nav-pill-custom">In The Box</a>
                    <a href="#faq" class="nav-pill-custom">FAQ</a>
                </div>
                <div class="text-primary mt-2 d-none d-md-block">
                    <a href="#overview" class="up-down-link">
                        <img src="{{ theme_asset('img/products/down.png') }}" alt="arrow-up-down">
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6 order-2 order-md-2">
                <!-- Quantity & Buy Button -->
                <div class="product-purchase-group">
                    <div class="product-qty-box">
                        <button class="qty-btn" type="button" id="minusBtn" aria-label="Decrease quantity">-</button>
                        <input type="text" class="qty-input" id="qtyInput" value="1" readonly
                            aria-label="Quantity">
                        <button class="qty-btn" type="button" id="plusBtn" aria-label="Increase quantity">+</button>
                    </div>
                    @php
                        $inCompare = in_array($product->id, session()->get('compare', []));
                        $inWishlist = in_array($product->id, session()->get('favorites', []));
                    @endphp
                    <button class="btn btn-outline-primary fw-semibold btn-add-to-cart-detail btn-action-cart"
                        data-product-id="{{ $product->id }}">Add To Cart</button>
                    <button class="btn btn-primary fw-semibold btn-buy-now btn-action-buy"
                        data-product-id="{{ $product->id }}">Buy Now</button>
                    <button
                        class="btn {{ $inCompare ? 'btn-primary text-white' : 'btn-outline-secondary' }} fw-semibold btn-add-to-compare btn-action-icon"
                        data-product-id="{{ $product->id }}"
                        title="{{ $inCompare ? 'In Comparison List' : 'Add to Compare' }}">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2 5C2 6.3 2.84 7.4 4 7.82V17.5C4 18.163 4.26339 18.7989 4.73223 19.2678C5.20107 19.7366 5.83696 20 6.5 20H10V22L14 19L10 16V18H6.5C6.22 18 6 17.78 6 17.5V7.82C7.16 7.41 8 6.31 8 5C8 3.35 6.65 2 5 2C3.35 2 2 3.35 2 5ZM5 4C5.55 4 6 4.45 6 5C6 5.55 5.55 6 5 6C4.45 6 4 5.55 4 5C4 4.45 4.45 4 5 4ZM20 16.18V6.5C20 5.83696 19.7366 5.20107 19.2678 4.73223C18.7989 4.26339 18.163 4 17.5 4H14V2L10 5L14 8V6H17.5C17.78 6 18 6.22 18 6.5V16.18C16.84 16.59 16 17.69 16 19C16 20.65 17.35 22 19 22C20.65 22 22 20.65 22 19C22 17.7 21.16 16.6 20 16.18ZM19 20C18.45 20 18 19.55 18 19C18 18.45 18.45 18 19 18C19.55 18 20 18.45 20 19C20 19.55 19.55 20 19 20Z"
                                fill="currentColor" />
                        </svg>
                    </button>
                    <button
                        class="btn {{ $inWishlist ? 'btn-danger text-white' : 'btn-outline-secondary' }} fw-semibold btn-toggle-favorite btn-action-icon"
                        data-product-id="{{ $product->id }}"
                        title="{{ $inWishlist ? 'In Wishlist' : 'Add to Wishlist' }}">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 21L10.55 19.7C8.86667 18.1833 7.475 16.875 6.375 15.775C5.275 14.675 4.4 13.6873 3.75 12.812C3.1 11.9367 2.646 11.1327 2.388 10.4C2.13 9.66733 2.00067 8.91733 2 8.15C2 6.58333 2.525 5.275 3.575 4.225C4.625 3.175 5.93333 2.65 7.5 2.65C8.36667 2.65 9.19167 2.83333 9.975 3.2C10.7583 3.56667 11.4333 4.08333 12 4.75C12.5667 4.08333 13.2417 3.56667 14.025 3.2C14.8083 2.83333 15.6333 2.65 16.5 2.65C18.0667 2.65 19.375 3.175 20.425 4.225C21.475 5.275 22 6.58333 22 8.15C22 8.91667 21.871 9.66667 21.613 10.4C21.355 11.1333 20.9007 11.9373 20.25 12.812C19.5993 13.6867 18.7243 14.6743 17.625 15.775C16.5257 16.8757 15.134 18.184 13.45 19.7L12 21ZM12 18.3C13.6 16.8667 14.9167 15.6377 15.95 14.613C16.9833 13.5883 17.8 12.6967 18.4 11.938C19 11.1793 19.4167 10.504 19.65 9.912C19.8833 9.32 20 8.73267 20 8.15C20 7.15 19.6667 6.31667 19 5.65C18.3333 4.98333 17.5 4.65 16.5 4.65C15.7167 4.65 14.9917 4.87067 14.325 5.312C13.6583 5.75333 13.2 6.316 12.95 7H11.05C10.8 6.31667 10.3417 5.75433 9.675 5.313C9.00833 4.87167 8.28333 4.65067 7.5 4.65C6.5 4.65 5.66667 4.98333 5 5.65C4.33333 6.31667 4 7.15 4 8.15C4 8.73333 4.11667 9.321 4.35 9.913C4.58333 10.505 5 11.18 5.6 11.938C6.2 12.696 7.01667 13.5877 8.05 14.613C9.08333 15.6383 10.4 16.8673 12 18.3Z"
                                fill="currentColor" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Sub-Nav Bar (Tabs) -->
    <div class="container-fluid bottom-tabs-bar" id="standardTabsBar" data-lenis-prevent>
        <div class="container d-flex justify-content-between overflow-auto gap-4 text-nowrap product-tabs-track"
            data-lenis-prevent>
            <a href="#overview" class="bottom-tab-link active">OVERVIEW</a>
            @if ($hasSpecs)
                <a href="#specs" class="bottom-tab-link">SPECIFICATIONS</a>
            @endif
            @if ($hasFeatures)
                <a href="#features" class="bottom-tab-link">FEATURES</a>
            @endif
            @if ($hasTech)
                <a href="#tech" class="bottom-tab-link">TECHNOLOGY</a>
            @endif
            @if ($hasApps)
                <a href="#apps" class="bottom-tab-link">APPLICATIONS</a>
            @endif
            @if ($hasBox)
                <a href="#box" class="bottom-tab-link">IN THE BOX</a>
            @endif
            @if ($hasFaq)
                <a href="#faq" class="bottom-tab-link">FAQ</a>
            @endif
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
            : theme_asset('img/products/AIRE Airpro Mask FB2 Technical Visualization.png');

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
        <div class="row align-items-center g-md-5">
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
                    $specsBgImage = $desc->specs_image
                        ? getImageUrl($desc->specs_image)
                        : theme_asset('img/products/SPECIFICATIONS.png');
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
                                                    <span
                                                        class="fs-5 fw-normal text-muted">{{ $desc->spec4_unit }}</span>
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
                $featBgImage = $featImg ? getImageUrl($featImg) : theme_asset('img/products/features.png');

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
                $techBgImage = $techImg ? getImageUrl($techImg) : theme_asset('img/airpro_mask_fb2.png');
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
                        $defaultAppImages = [
                            theme_asset('img/products/R&D Laboratories1.png'),
                            theme_asset('img/products/Precision Manufacturing.png'),
                            theme_asset('img/products/Urban Mobility.png'),
                        ];
                        $fallbackImg = $defaultAppImages[$index % 3];
                        $bgImage = $appImg ? getImageUrl($appImg) : $fallbackImg;
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
                                    <h3 class="fw-bold mb-1 text-dark box-item-title" title="{{ $relProduct->name }}">
                                        {{ strtoupper($relProduct->name) }}
                                    </h3>
                                    <span class="text-primary small fw-bold box-item-price">
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
                    <div class="col-md-9">
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

                // Dynamic Thumbnail switching function (smooth cross-fade & zoom sync)
                function switchProductImage(imgEl) {
                    if (!imgEl) return;
                    const $thumb = $(imgEl);
                    if ($thumb.hasClass('active')) return;

                    $('.thumb-img').removeClass('active');
                    $thumb.addClass('active');

                    const largeImageSrc = $thumb.attr('data-large') || $thumb.attr('src');
                    const largeImageSrcset = $thumb.attr('data-srcset');
                    if (!largeImageSrc) return;

                    const $mainImg = $('#mainProductImg');
                    $mainImg.stop(true, false).fadeTo(80, 0.25, function() {
                        if (largeImageSrcset) {
                            $mainImg.attr('srcset', largeImageSrcset);
                        } else {
                            $mainImg.removeAttr('srcset');
                        }
                        $mainImg.attr('src', largeImageSrc).fadeTo(140, 1);
                    });

                    // Synchronize desktop zoom box
                    $('#zoomContainer').css('background-image', 'url("' + largeImageSrc + '")');

                    // Smooth scroll thumbnail inside column without moving the entire window
                    const container = document.getElementById('thumbScrollContainer');
                    if (container) {
                        if (container.scrollHeight > container.clientHeight) {
                            const targetTop = imgEl.offsetTop - (container.clientHeight / 2) + (imgEl
                                .clientHeight / 2);
                            container.scrollTo({
                                top: Math.max(0, targetTop),
                                behavior: 'smooth'
                            });
                        } else if (container.scrollWidth > container.clientWidth) {
                            const targetLeft = imgEl.offsetLeft - (container.clientWidth / 2) + (imgEl
                                .clientWidth / 2);
                            container.scrollTo({
                                left: Math.max(0, targetLeft),
                                behavior: 'smooth'
                            });
                        }
                    }
                }

                // Click listener for thumbnails (desktop & mobile)
                $(document).on('click', '.thumb-img', function(e) {
                    e.preventDefault();
                    switchProductImage(this);
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

                // Draggable / Drag-to-Scroll Thumbnail Column (Mouse & Touch with momentum)
                (function initThumbDragScroll() {
                    const container = document.getElementById('thumbScrollContainer');
                    if (!container) return;

                    let isDown = false;
                    let startX = 0;
                    let startY = 0;
                    let scrollLeft = 0;
                    let scrollTop = 0;
                    let hasDragged = false;
                    let velX = 0;
                    let velY = 0;
                    let lastX = 0;
                    let lastY = 0;
                    let lastTime = 0;
                    let momentumRaf = null;
                    let targetThumb = null;

                    // Prevent default ghost image dragging
                    container.addEventListener('dragstart', function(e) {
                        e.preventDefault();
                    });

                    container.addEventListener('pointerdown', function(e) {
                        if (e.pointerType === 'mouse' && e.button !== 0) return;

                        isDown = true;
                        hasDragged = false;
                        startX = e.pageX;
                        startY = e.pageY;
                        scrollLeft = container.scrollLeft;
                        scrollTop = container.scrollTop;
                        lastX = e.pageX;
                        lastY = e.pageY;
                        lastTime = performance.now();
                        velX = 0;
                        velY = 0;
                        targetThumb = e.target ? e.target.closest('.thumb-img') : null;

                        if (momentumRaf) {
                            cancelAnimationFrame(momentumRaf);
                            momentumRaf = null;
                        }
                        // Note: Pointer capture is deferred until actual movement > 7px so desktop clicks dispatch cleanly to .thumb-img
                    });

                    container.addEventListener('pointermove', function(e) {
                        if (!isDown) return;

                        const x = e.pageX;
                        const y = e.pageY;
                        const walkX = x - startX;
                        const walkY = y - startY;

                        // Threshold to distinguish deliberate drag from a simple click
                        if (!hasDragged && (Math.abs(walkX) > 7 || Math.abs(walkY) > 7)) {
                            hasDragged = true;
                            container.classList.add('is-dragging');
                            container.style.scrollBehavior = 'auto';

                            // Only capture pointer when dragging begins
                            try {
                                container.setPointerCapture(e.pointerId);
                            } catch (err) {}
                        }

                        if (hasDragged) {
                            const now = performance.now();
                            const dt = now - lastTime;
                            if (dt > 0) {
                                velX = (x - lastX) / dt;
                                velY = (y - lastY) / dt;
                            }
                            lastX = x;
                            lastY = y;
                            lastTime = now;

                            container.scrollLeft = scrollLeft - walkX;
                            container.scrollTop = scrollTop - walkY;
                        }
                    });

                    function endDrag(e) {
                        if (!isDown) return;
                        isDown = false;

                        if (e && e.pointerId) {
                            try {
                                container.releasePointerCapture(e.pointerId);
                            } catch (err) {}
                        }

                        if (hasDragged) {
                            // Intercept and prevent the click event triggered by this drag release
                            const captureClick = function(clickEv) {
                                clickEv.preventDefault();
                                clickEv.stopPropagation();
                                clickEv.stopImmediatePropagation();
                                window.removeEventListener('click', captureClick, true);
                            };
                            window.addEventListener('click', captureClick, true);
                            setTimeout(function() {
                                window.removeEventListener('click', captureClick, true);
                            }, 150);

                            // Smooth momentum inertia
                            let momentumX = velX * 16;
                            let momentumY = velY * 16;
                            const friction = 0.92;

                            function stepMomentum() {
                                if (Math.abs(momentumX) > 0.4 || Math.abs(momentumY) > 0.4) {
                                    container.scrollLeft -= momentumX;
                                    container.scrollTop -= momentumY;
                                    momentumX *= friction;
                                    momentumY *= friction;
                                    momentumRaf = requestAnimationFrame(stepMomentum);
                                } else {
                                    container.classList.remove('is-dragging');
                                    container.style.scrollBehavior = '';
                                    momentumRaf = null;
                                }
                            }
                            momentumRaf = requestAnimationFrame(stepMomentum);
                        } else {
                            container.classList.remove('is-dragging');
                            container.style.scrollBehavior = '';

                            // If released without dragging, switch image immediately on desktop/touch
                            if (targetThumb) {
                                switchProductImage(targetThumb);
                            }
                        }
                    }

                    container.addEventListener('pointerup', endDrag);
                    container.addEventListener('pointercancel', endDrag);

                    // Mouse wheel support for horizontal scroll mode on mobile view
                    container.addEventListener('wheel', function(e) {
                        if (container.scrollWidth > container.clientWidth && container
                            .clientHeight >= container.scrollHeight) {
                            const delta = e.deltaY || e.deltaX;
                            if (delta !== 0) {
                                container.scrollLeft += delta * 0.8;
                                e.preventDefault();
                                e.stopPropagation();
                            }
                        }
                    }, {
                        passive: false
                    });
                })();

                // Draggable / Drag-to-Scroll Product Tabs Track (Mobile & Desktop)
                (function initTabsDragScroll() {
                    const tracks = document.querySelectorAll('.product-tabs-track');
                    if (!tracks.length) return;

                    tracks.forEach(function(track) {
                        let isDown = false;
                        let startX = 0;
                        let startY = 0;
                        let scrollLeft = 0;
                        let hasDragged = false;
                        let velX = 0;
                        let lastX = 0;
                        let lastTime = 0;
                        let momentumRaf = null;

                        // Prevent native browser ghost dragging
                        track.addEventListener('dragstart', function(e) {
                            e.preventDefault();
                        });

                        track.addEventListener('pointerdown', function(e) {
                            if (e.pointerType === 'mouse' && e.button !== 0) return;

                            // Stop propagation so parent or document listeners do not conflict
                            e.stopPropagation();

                            isDown = true;
                            hasDragged = false;
                            startX = e.pageX;
                            startY = e.pageY;
                            scrollLeft = track.scrollLeft;
                            lastX = e.pageX;
                            lastTime = performance.now();
                            velX = 0;

                            if (momentumRaf) {
                                cancelAnimationFrame(momentumRaf);
                                momentumRaf = null;
                            }

                            track.style.scrollBehavior = 'auto';
                        });

                        track.addEventListener('pointermove', function(e) {
                            if (!isDown) return;

                            const x = e.pageX;
                            const y = e.pageY;
                            const walkX = x - startX;
                            const walkY = y - startY;

                            // If user is scrolling vertically before dragging horizontally, release pointer
                            if (!hasDragged && Math.abs(walkY) > 8 && Math.abs(walkY) >
                                Math.abs(walkX)) {
                                isDown = false;
                                try {
                                    track.releasePointerCapture(e.pointerId);
                                } catch (err) {}
                                return;
                            }

                            // Defer pointer capture until deliberate drag movement > 7px so clicks dispatch cleanly
                            if (!hasDragged && Math.abs(walkX) > 7) {
                                hasDragged = true;
                                track.classList.add('is-dragging');
                                try {
                                    track.setPointerCapture(e.pointerId);
                                } catch (err) {}
                            }

                            if (hasDragged) {
                                const now = performance.now();
                                const dt = now - lastTime;
                                if (dt > 0) {
                                    velX = (x - lastX) / dt;
                                }
                                lastX = x;
                                lastTime = now;

                                track.scrollLeft = scrollLeft - walkX;
                            }
                        });

                        function endDrag(e) {
                            if (!isDown) return;
                            isDown = false;

                            if (e && e.pointerId) {
                                try {
                                    track.releasePointerCapture(e.pointerId);
                                } catch (err) {}
                            }

                            if (hasDragged) {
                                // Intercept and block click on tab links so drag doesn't jump the page
                                const captureClick = function(clickEv) {
                                    clickEv.preventDefault();
                                    clickEv.stopPropagation();
                                    clickEv.stopImmediatePropagation();
                                    window.removeEventListener('click', captureClick, true);
                                };
                                window.addEventListener('click', captureClick, true);
                                setTimeout(function() {
                                    window.removeEventListener('click', captureClick,
                                        true);
                                }, 150);

                                // Inertia momentum deceleration
                                let momentumX = velX * 16;
                                const friction = 0.92;

                                function stepMomentum() {
                                    if (Math.abs(momentumX) > 0.4) {
                                        track.scrollLeft -= momentumX;
                                        momentumX *= friction;
                                        momentumRaf = requestAnimationFrame(stepMomentum);
                                    } else {
                                        track.classList.remove('is-dragging');
                                        track.style.scrollBehavior = '';
                                        momentumRaf = null;
                                    }
                                }
                                momentumRaf = requestAnimationFrame(stepMomentum);
                            } else {
                                track.classList.remove('is-dragging');
                                track.style.scrollBehavior = '';
                            }
                        }

                        track.addEventListener('pointerup', endDrag);
                        track.addEventListener('pointercancel', endDrag);

                        // Convert mouse wheel to horizontal scroll inside tabs track
                        track.addEventListener('wheel', function(e) {
                            if (track.scrollWidth > track.clientWidth) {
                                const delta = e.deltaY || e.deltaX;
                                if (delta !== 0) {
                                    track.scrollLeft += delta * 0.8;
                                    e.preventDefault();
                                    e.stopPropagation();
                                }
                            }
                        }, {
                            passive: false
                        });
                    });
                })();

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

                // Real-time Dynamic Price Calculation with Options
                function updateProductPriceWithOptions() {
                    const $container = $('#mainProductPriceContainer');
                    if (!$container.length) return;

                    const basePrice = parseFloat($container.attr('data-base-price')) || 0;
                    const originalBasePrice = parseFloat($container.attr('data-original-price')) || 0;
                    const hasSpecial = $container.attr('data-has-special') === '1';

                    let totalOptionDiff = 0;

                    // Sum price modifiers from all currently active option selectors
                    $('.color-swatch.active, .size-btn.active').each(function() {
                        const price = parseFloat($(this).attr('data-price')) || 0;
                        const prefix = $(this).attr('data-price-prefix') || '+';
                        if (prefix === '-') {
                            totalOptionDiff -= price;
                        } else {
                            totalOptionDiff += price;
                        }
                    });

                    const newActivePrice = Math.max(0, basePrice + totalOptionDiff);
                    const newOriginalPrice = Math.max(0, originalBasePrice + totalOptionDiff);

                    const formattedActive = '$' + newActivePrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    const formattedOriginal = '$' + newOriginalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                    // Update main product price elements
                    $('.main-active-price').text(formattedActive);
                    if (hasSpecial) {
                        $('.main-original-price').text(formattedOriginal);
                    }

                    // Update sticky header price elements
                    $('.sticky-active-price').text(formattedActive);
                    if (hasSpecial) {
                        $('.sticky-original-price').text(formattedOriginal);
                    }
                }

                // Color Swatch Selection (scoped to option group)
                $(document).on('click', '.color-swatch', function() {
                    // Only deactivate swatches within the same option group
                    $(this).closest('.d-flex.gap-2').find('.color-swatch').removeClass('active');
                    $(this).addClass('active');
                    updateProductPriceWithOptions();
                });

                // Size / Generic Option Button Selection (scoped to option group)
                $(document).on('click', '.size-btn', function() {
                    // Only deactivate buttons within the same option group
                    $(this).closest('.d-flex.gap-2').find('.size-btn').removeClass('active');
                    $(this).addClass('active');
                    updateProductPriceWithOptions();
                });

                // Initial calculation on page load
                updateProductPriceWithOptions();

                // Sticky Header & Active Nav Scroll logic
                const stickyHeader = $('#stickyProductHeader');
                const productTop = $('#productTopSection');
                const $tabLinks = $('.bottom-tab-link, .nav-pill-custom');

                // Collect unique section IDs from hash links that actually exist in the DOM
                const targetSectionIds = [];
                $tabLinks.each(function() {
                    const href = $(this).attr('href');
                    if (href && href.startsWith('#') && href.length > 1) {
                        const id = href.substring(1);
                        if (targetSectionIds.indexOf(id) === -1 && document.getElementById(id)) {
                            targetSectionIds.push(id);
                        }
                    }
                });

                function getTargetSections() {
                    return targetSectionIds
                        .map(id => document.getElementById(id))
                        .filter(el => el && el.offsetHeight > 0)
                        .sort((a, b) => a.offsetTop - b.offsetTop);
                }

                let lastActiveId = null;
                let isClickScrolling = false;
                let clickScrollTimer = null;

                function setActiveTab(id) {
                    if (!id || id === lastActiveId) return;
                    lastActiveId = id;

                    $tabLinks.removeClass('active');
                    const $matched = $tabLinks.filter(`[href="#${id}"]`);
                    $matched.addClass('active');

                    // Scroll active tab into view in mobile tabs track
                    $matched.each(function() {
                        const parentTrack = this.closest('.product-tabs-track');
                        if (parentTrack && !parentTrack.classList.contains('is-dragging')) {
                            const trackRect = parentTrack.getBoundingClientRect();
                            const tabRect = this.getBoundingClientRect();
                            if (tabRect.left < trackRect.left || tabRect.right > trackRect.right) {
                                this.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'nearest',
                                    inline: 'center'
                                });
                            }
                        }
                    });
                }

                function updateScrollSpy() {
                    const scrollTop = $(window).scrollTop();
                    const productBottom = productTop.offset().top + productTop.outerHeight() - 100;

                    // Sticky header visibility toggle
                    if (scrollTop > productBottom) {
                        stickyHeader.addClass('is-sticky');
                    } else {
                        stickyHeader.removeClass('is-sticky');
                    }

                    if (isClickScrolling) return;

                    const sections = getTargetSections();
                    if (!sections.length) return;

                    const windowHeight = window.innerHeight || $(window).height();
                    const docHeight = $(document).height();

                    // If user is near the very bottom of the page, activate the last section
                    if (scrollTop + windowHeight >= docHeight - 30) {
                        setActiveTab(sections[sections.length - 1].id);
                        return;
                    }

                    // Trigger when section appears 10% on the screen from the bottom (i.e. 90% from top of viewport)
                    const triggerThreshold = windowHeight * 0.90;
                    let activeId = null;

                    for (let i = 0; i < sections.length; i++) {
                        const sec = sections[i];
                        const rect = sec.getBoundingClientRect();

                        // Section becomes active as soon as it appears 10% on the screen from bottom
                        if (rect.top <= triggerThreshold) {
                            activeId = sec.id;
                        }
                    }

                    // Default to first section when above all trigger thresholds
                    if (!activeId && sections.length > 0) {
                        activeId = sections[0].id;
                    }

                    if (activeId) {
                        setActiveTab(activeId);
                    }
                }

                $(window).on('scroll resize', updateScrollSpy);

                if (window.lenisInstance && typeof window.lenisInstance.on === 'function') {
                    window.lenisInstance.on('scroll', updateScrollSpy);
                }

                // Initial sync on page load
                updateScrollSpy();

                // Smooth Scroll to Section when clicking tabs or pills
                $(document).on('click', '.bottom-tab-link, .nav-pill-custom', function(e) {
                    let targetHref = $(this).attr('href');
                    if (targetHref && targetHref.startsWith('#')) {
                        e.preventDefault();
                        let targetSection = $(targetHref);
                        if (targetSection.length) {
                            const targetId = targetHref.substring(1);
                            isClickScrolling = true;
                            clearTimeout(clickScrollTimer);
                            clickScrollTimer = setTimeout(function() {
                                isClickScrolling = false;
                            }, 850);

                            setActiveTab(targetId);

                            if (window.lenisInstance && typeof window.lenisInstance.scrollTo ===
                                'function') {
                                window.lenisInstance.scrollTo(targetSection[0], {
                                    offset: -100,
                                    duration: 0.8
                                });
                            } else {
                                $('html, body').stop().animate({
                                    scrollTop: targetSection.offset().top - 100
                                }, 400);
                            }

                            if (this.scrollIntoView) {
                                this.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'nearest',
                                    inline: 'center'
                                });
                            }
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
