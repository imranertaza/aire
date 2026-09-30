<!DOCTYPE html>
<html lang="en">

<head>
<!-- 
  Developed by DNationSoft
  Website: https://www.dnationsoft.com
  Contact: +880 1924-329315
  All rights reserved.
-->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name', 'Laravel Vue App') }}</title>
    @include('layouts.partial.seo')
    {{-- google font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="icon" href="{{ getImageUrl($settings['store_icon']) }}" type="image/x-icon">
    @vite(['resources/web/assets/bootstrap-5.3.8-dist/css/bootstrap.min.css', 'resources/web/assets/css/style.css'])
    {{-- Page-specific styles --}}
    @stack('styles')
    <style>
        :root {
            --bs-pagination-border-radius: none !important;
        }


        .page-item:first-child .page-link {
            border-top-left-radius: 4px !important;
            border-bottom-left-radius: 4px !important;
        }

        .page-item:last-child .page-link {
            border-top-right-radius: 4px !important;
            border-bottom-right-radius: 4px !important;
        }



        .page-item {
            padding-left: 16px
        }

        .page-link {
            color: var(--common-color) !important;
            border: none !important;
            background-color: transparent !important;
            {{-- padding-left: 16px !important; --}} border-radius: 4px !important;
        }

        .active>.page-link,
        .page-link.active {
            background-color: var(--common-color) !important;
            border-color: var(--common-color) !important;
            color: #fff !important;
        }

        li.page-item.disabled {
            display: none;
        }
    </style>
</head>

<body>
    @include('layouts.partial.navbar')
    <main>
        @if (request()->route()->getName() != 'home')
            <!-- Breadcrumb Section Start -->
            <section class="breadcrumb position-relative">
                <img class="img-fluid" draggable="false" fetchpriority="high"
                    src="{{ getImageCacheUrl($settings['breadcrumb'], 1351, 300) }}" alt="">
                <h6 class="page-title title-one position-absolute text-capitalize">@yield('breadcrumb')</h6>
            </section>
        @endif
        <!-- Breadcrumb Section Start -->
        @yield('content')
    </main>
    @include('layouts.partial.footer')

    {{-- Global Bootstrap JS --}}
    @if (request()->route()->getName() == 'home')
        @vite('resources/web/assets/js/home.js')
    @endif
    @vite(['resources/web/assets/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js', 'resources/web/assets/js/main.js'])

    {{-- Page-specific scripts --}}
    @stack('scripts')
</body>

</html>
