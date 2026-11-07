<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $settings['meta_title'] ?? 'Aire | Indoor Air Quality Solutions')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Central Reusable SEO & Social Meta Partial --}}
    @include('layouts.partial.seo')

    @if (trim($__env->yieldContent('canonical_url')))
        <link rel="canonical" href="@yield('canonical_url')">
    @endif
    <link rel="icon" href="{{ getImageUrl($settings['store_icon'] ?? theme_asset('img/favicon.png')) }}"
        type="image/png">

    {{-- Early Preload Stack (e.g. Hero LCP images) --}}
    @stack('head')

    <!-- Preconnect Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">

    <!-- Non-blocking Google Fonts (Inter + Playfair Display) -->
    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap">
    </noscript>

    <!-- Critical Layout & Base Styles (Zero FOUC for Above-the-fold) -->
    <style>
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Roboto'), local('Roboto-Regular'),
                url('https://fonts.gstatic.com/s/roboto/v48/KFO7CnqEu92Fr1ME7kSn66aGLdTylUAMa3yUBHMdazQ.woff2') format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        :root {
            --color-primary: #0095DA;
            --color-primary-hover: #047cc2;
            --color-dark: #0f172a;
            --color-bg: #f8fafc;
            --color-border: #e2e8f0;
            --primary-color: var(--color-primary);
            --fs-body: 14px;
        }

        *,
        ::after,
        ::before {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            -webkit-text-size-adjust: 100%;
            background-color: var(--color-bg, #f8fafc);
            color: var(--color-dark, #0f172a);
            overflow-x: clip;
        }

        .container,
        .container-fluid,
        .main-container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            max-width: 1280px;
        }

        .d-flex {
            display: flex !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        .justify-content-between {
            justify-content: space-between !important;
        }

        .site-header {
            position: sticky;
            top: 0;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            z-index: 1020;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .main-nav {
            display: flex;
            align-items: center;
            width: 100%;
            justify-content: space-between;
        }

        .main-nav .nav-link {
            color: #0f172a;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            position: relative;
        }

        .main-nav .nav-link.active {
            color: var(--color-primary, #0072B2);
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--color-primary, #0072B2) !important;
            border-color: var(--color-primary, #0072B2) !important;
            color: #ffffff !important;
        }

        .text-primary {
            color: var(--color-primary, #0072B2) !important;
        }

        .product-card__badge-pill[style*="#00c853"],
        .product-card__badge-pill[style*="#00C853"] {
            background-color: #0a7a3b !important;
        }

        .product-card__category,
        .home-product-card__category,
        .why-choose-stacked__subtitle,
        .home-lifestyle__subtitle,
        .testimonials-section__subtitle {
            color: #475569 !important;
        }

        .visually-hidden {
            position: absolute !important;
            width: 1px !important;
            height: 1px !important;
            padding: 0 !important;
            margin: -1px !important;
            overflow: hidden !important;
            clip: rect(0, 0, 0, 0) !important;
            white-space: nowrap !important;
            border: 0 !important;
        }

        .swiper-pagination-bullet {
            position: relative;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: 28px !important;
            height: 28px !important;
            min-width: 28px;
            min-height: 28px;
            background: transparent !important;
            border: none !important;
            border-radius: 50% !important;
            margin: 0 !important;
            padding: 0 !important;
            opacity: 1 !important;
            cursor: pointer;
            box-sizing: border-box !important;
        }

        .swiper-pagination-bullet::before {
            content: '';
            display: block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #cbd5e1;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .swiper-pagination-bullet-active::before {
            background-color: var(--primary-color, #0072B2);
        }
    </style>

    <!-- Core Bootstrap 5 & Vendor Styles -->
    <link rel="stylesheet" href="{{ theme_asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/swiper-bundle.min.css') }}">

    <!-- Theme Custom CSS -->
    {!! theme_css() !!}
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100 @yield('body_class')">
    @include('themes.default.layouts.header')

    @yield('content')

    @include('themes.default.layouts.footer')

    @guest('customer')
        @include('themes.default.partials.auth-modal')
    @endguest
    @include('themes.default.partials.search-modal')

    <!-- Core Scripts (Local & Deferred) -->
    <script src="{{ theme_asset('js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ theme_asset('js/swiper-bundle.min.js') }}" defer></script>
    <script src="{{ theme_asset('js/jquery.min.js') }}" defer></script>
    <!-- Theme Custom JS -->
    <script src="{{ theme_asset('js/main.js') }}" defer></script>
    <script src="{{ theme_asset('js/ui.js') }}" defer></script>
    <script src="{{ theme_asset('js/products.min.js') }}" defer></script>
    @stack('scripts')
</body>

</html>
