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

    <!-- Preconnect Fonts & CDNs -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

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
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Non-blocking Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    </noscript>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- Theme Custom CSS (Auto-switches to individual files with auto-reload in local mode, and minified bundle in production) -->
    {!! theme_css() !!}
    @stack('styles')
    @stack('head')
</head>

<body class="d-flex flex-column min-vh-100 @yield('body_class')">
    @include('themes.default.layouts.header')

    @yield('content')

    @include('themes.default.layouts.footer')

    @guest('customer')
        @include('themes.default.partials.auth-modal')
    @endguest
    @include('themes.default.partials.search-modal')

    <!-- Core Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js" defer></script>
    <!-- Theme Custom JS -->
    <script src="{{ theme_asset('js/main.js') }}" defer></script>
    <script src="{{ theme_asset('js/ui.js') }}" defer></script>
    <script src="{{ theme_asset('js/products.js') }}" defer></script>
    @stack('scripts')
</body>

</html>
