<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aire | Indoor Air Quality Solutions')</title>
    <meta name="description" content="@yield('meta_description', 'Aire Industries delivers cutting-edge indoor air quality solutions for residential, commercial, healthcare, and industrial environments.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'Aire | Indoor Air Quality Solutions')">
    <meta property="og:description" content="@yield('meta_description', 'Cutting-edge indoor air quality solutions for residential, commercial, healthcare, and industrial environments.')">
    <meta property="og:image" content="{{ theme_asset('img/logo.png') }}">
    <meta property="og:type" content="website">
    <link rel="icon" href="{{ theme_asset('img/favicon.png') }}" type="image/png">

    <!-- Preconnect Fonts & CDNs -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- Theme Custom CSS -->
    <link href="{{ theme_asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ theme_asset('css/layout.css') }}" rel="stylesheet">
    <link href="{{ theme_asset('css/components.css') }}" rel="stylesheet">
    <link href="{{ theme_asset('css/responsive.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100 @yield('body_class')">

    @include('themes.default.layouts.header')

    @yield('content')

    @include('themes.default.layouts.footer')

    <!-- Core Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js" defer></script>
    <!-- Theme Custom JS -->
    <script src="{{ theme_asset('js/main.js') }}" defer></script>
    <script src="{{ theme_asset('js/ui.js') }}" defer></script>
    <script src="{{ theme_asset('js/products.js') }}" defer></script>
    @stack('scripts')
</body>

</html>
