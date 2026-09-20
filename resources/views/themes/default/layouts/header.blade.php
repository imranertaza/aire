@php
    $cartCount = (int) collect(session()->get('cart', []))->sum('quantity');
    $favCount = (int) count(session()->get('favorites', []));
    $compareCount = (int) count(session()->get('compare', []));
@endphp
<script>
    window.updateHeaderBadges = function(type, count) {
        count = parseInt(count) || 0;
        let badge;
        if (type === 'cart') {
            badge = document.querySelector('.cart-count-badge');
        } else if (type === 'favorite' || type === 'favorites' || type === 'wishlist') {
            badge = document.querySelector('.favorite-count-badge');
        } else if (type === 'compare') {
            badge = document.querySelector('.compare-count-badge');
        }
        if (badge) {
            badge.textContent = count;
            if (count > 0) {
                badge.classList.remove('d-none');
                badge.style.setProperty('display', 'inline-flex', 'important');
            } else {
                badge.classList.add('d-none');
                badge.style.setProperty('display', 'none', 'important');
            }
        }
    };
</script>
<!-- Header -->
<header class="site-header bg-white py-md-3">
    <div class="container main-container">
        <div class="row g-lg-5 align-items-center">
            <!-- Col 1: Logo -->
            <div class="col-12 col-lg-3 d-flex align-items-center justify-content-between py-2 py-lg-0">
                <a href="{{ route('home') }}" class="brand-logo d-flex align-items-center text-decoration-none text-dark">
                    @if (!empty($settings['store_logo']) && !str_contains($settings['store_logo'], 'placehold.co'))
                        <img src="{{ getImageUrl($settings['store_logo']) }}" height="28"
                            alt="{{ $settings['brand_name'] ?? 'AIRE' }} logo" class="img-fluid logo-header-img"
                            style="max-height: 36px;">
                    @else
                        <img src="{{ theme_asset('img/logo.png') }}" height="28"
                            alt="{{ $settings['brand_name'] ?? 'AIRE' }} logo" class="img-fluid logo-header-img">
                    @endif
                </a>
                <!-- Mobile Menu Toggle -->
                <button class="btn border-0 shadow-none d-lg-none p-1 text-dark" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                    <i class="bi bi-list fs-32"></i>
                </button>
            </div>

            <!-- Col 2: Main Nav -->
            <div class="col-lg-9 col-xl-6 d-none d-lg-block px-md-0">
                @php
                    $mainHeaderMenu = \App\Models\Menu::where(function ($q) {
                        $q->where('position', 'header')->orWhere('position', 'Header')->orWhere('name', 'Main Header');
                    })
                        ->where('enabled', 1)
                        ->with([
                            'menus' => function ($q) {
                                $q->where('enabled', 1)->orderBy('order', 'asc');
                            },
                        ])
                        ->first();
                @endphp

                <nav class="main-nav d-flex align-items-center gap-1">
                    @if ($mainHeaderMenu && $mainHeaderMenu->menus->count() > 0)
                        @foreach ($mainHeaderMenu->menus as $navItem)
                            @php
                                $itemUrl = $navItem->url ?? '#';
                                $isActive =
                                    request()->is(trim($itemUrl, '/')) ||
                                    request()->url() === url($itemUrl) ||
                                    request()->route('slug') === strtolower($navItem->name) ||
                                    (request()->routeIs('categories') && strtolower($navItem->name) === 'products') ||
                                    (request()->routeIs('docs') && strtolower($navItem->name) === 'resources') ||
                                    (request()->routeIs('about') && strtolower($navItem->name) === 'about');
                            @endphp
                            <a href="{{ $itemUrl }}" class="nav-link {{ $isActive ? 'active' : '' }}">
                                {{ $navItem->name }}
                            </a>
                        @endforeach
                    @else
                        <a href="{{ route('category.show', 'solutions') }}"
                            class="nav-link {{ request()->route('slug') === 'solutions' ? 'active' : '' }}">Solutions</a>

                        <a href="{{ route('category.show', 'products') }}"
                            class="nav-link {{ request()->routeIs('categories') || request()->route('slug') === 'products' ? 'active' : '' }}">Products</a>

                        <a href="{{ route('category.show', 'industries') }}"
                            class="nav-link {{ request()->route('slug') === 'industries' ? 'active' : '' }}">Industries</a>
                        <a href="{{ route('category.show', 'technologies') }}"
                            class="nav-link {{ request()->route('slug') === 'technologies' ? 'active' : '' }}">Technologies</a>

                        <a href="{{ route('docs') }}"
                            class="nav-link {{ request()->routeIs('docs') || request()->route('slug') === 'resources' ? 'active' : '' }}">Resources</a>

                        <a href="{{ route('about') }}"
                            class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                    @endif
                </nav>
            </div>

            <!-- Col 3: Actions & Auth -->
            <div class="col-6 col-lg-3 d-none d-xl-block">
                <div class="d-flex align-items-center justify-content-end gap-3 position-relative">
                    <div class="header-actions-default d-flex align-items-center justify-content-between gap-2 w-100">
                        <div class="d-flex align-items-center gap-2 ms-3">
                            <a href="{{ route('cart') }}" class="text-dark text-decoration-none position-relative"
                                aria-label="Cart">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17 18C17.5304 18 18.0391 18.2107 18.4142 18.5858C18.7893 18.9609 19 19.4696 19 20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22C16.4696 22 15.9609 21.7893 15.5858 21.4142C15.2107 21.0391 15 20.5304 15 20C15 18.89 15.89 18 17 18ZM1 2H4.27L5.21 4H20C20.2652 4 20.5196 4.10536 20.7071 4.29289C20.8946 4.48043 21 4.73478 21 5C21 5.17 20.95 5.34 20.88 5.5L17.3 11.97C16.96 12.58 16.3 13 15.55 13H8.1L7.2 14.63L7.17 14.75C7.17 14.8163 7.19634 14.8799 7.24322 14.9268C7.29011 14.9737 7.3537 15 7.42 15H19V17H7C6.46957 17 5.96086 16.7893 5.58579 16.4142C5.21071 16.0391 5 15.5304 5 15C5 14.65 5.09 14.32 5.24 14.04L6.6 11.59L3 4H1V2ZM7 18C7.53043 18 8.03914 18.2107 8.41421 18.5858C8.78929 18.9609 9 19.4696 9 20C9 20.5304 8.78929 21.0391 8.41421 21.4142C8.03914 21.7893 7.53043 22 7 22C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20C5 18.89 5.89 18 7 18ZM16 11L18.78 6H6.14L8.5 11H16Z"
                                        fill="#7E7E7E" />
                                </svg>
                                <span class="header-count-badge cart-count-badge {{ $cartCount > 0 ? '' : 'd-none' }}"
                                    style="{{ $cartCount > 0 ? 'display: inline-flex !important;' : 'display: none !important;' }}">
                                    {{ $cartCount }}
                                </span>
                            </a>
                            <a href="{{ route('favorite') }}" class="text-dark text-decoration-none position-relative"
                                aria-label="Favorites">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 21L10.55 19.7C8.86667 18.1833 7.475 16.875 6.375 15.775C5.275 14.675 4.4 13.6873 3.75 12.812C3.1 11.9367 2.646 11.1327 2.388 10.4C2.13 9.66733 2.00067 8.91733 2 8.15C2 6.58333 2.525 5.275 3.575 4.225C4.625 3.175 5.93333 2.65 7.5 2.65C8.36667 2.65 9.19167 2.83333 9.975 3.2C10.7583 3.56667 11.4333 4.08333 12 4.75C12.5667 4.08333 13.2417 3.56667 14.025 3.2C14.8083 2.83333 15.6333 2.65 16.5 2.65C18.0667 2.65 19.375 3.175 20.425 4.225C21.475 5.275 22 6.58333 22 8.15C22 8.91667 21.871 9.66667 21.613 10.4C21.355 11.1333 20.9007 11.9373 20.25 12.812C19.5993 13.6867 18.7243 14.6743 17.625 15.775C16.5257 16.8757 15.134 18.184 13.45 19.7L12 21ZM12 18.3C13.6 16.8667 14.9167 15.6377 15.95 14.613C16.9833 13.5883 17.8 12.6967 18.4 11.938C19 11.1793 19.4167 10.504 19.65 9.912C19.8833 9.32 20 8.73267 20 8.15C20 7.15 19.6667 6.31667 19 5.65C18.3333 4.98333 17.5 4.65 16.5 4.65C15.7167 4.65 14.9917 4.87067 14.325 5.312C13.6583 5.75333 13.2 6.316 12.95 7H11.05C10.8 6.31667 10.3417 5.75433 9.675 5.313C9.00833 4.87167 8.28333 4.65067 7.5 4.65C6.5 4.65 5.66667 4.98333 5 5.65C4.33333 6.31667 4 7.15 4 8.15C4 8.73333 4.11667 9.321 4.35 9.913C4.58333 10.505 5 11.18 5.6 11.938C6.2 12.696 7.01667 13.5877 8.05 14.613C9.08333 15.6383 10.4 16.8673 12 18.3Z"
                                        fill="#7E7E7E" />
                                </svg>
                                <span
                                    class="header-count-badge favorite-count-badge {{ $favCount > 0 ? '' : 'd-none' }}"
                                    style="{{ $favCount > 0 ? 'display: inline-flex !important;' : 'display: none !important;' }}">
                                    {{ $favCount }}
                                </span>
                            </a>
                            <a href="{{ route('compare') }}" class="text-dark text-decoration-none position-relative"
                                aria-label="Compare">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2 5C2 6.3 2.84 7.4 4 7.82V17.5C4 18.163 4.26339 18.7989 4.73223 19.2678C5.20107 19.7366 5.83696 20 6.5 20H10V22L14 19L10 16V18H6.5C6.22 18 6 17.78 6 17.5V7.82C7.16 7.41 8 6.31 8 5C8 3.35 6.65 2 5 2C3.35 2 2 3.35 2 5ZM5 4C5.55 4 6 4.45 6 5C6 5.55 5.55 6 5 6C4.45 6 4 5.55 4 5C4 4.45 4.45 4 5 4ZM20 16.18V6.5C20 5.83696 19.7366 5.20107 19.2678 4.73223C18.7989 4.26339 18.163 4 17.5 4H14V2L10 5L14 8V6H17.5C17.78 6 18 6.22 18 6.5V16.18C16.84 16.59 16 17.69 16 19C16 20.65 17.35 22 19 22C20.65 22 22 20.65 22 19C22 17.7 21.16 16.6 20 16.18ZM19 20C18.45 20 18 19.55 18 19C18 18.45 18.45 18 19 18C19.55 18 20 18.45 20 19C20 19.55 19.55 20 19 20Z"
                                        fill="#7E7E7E" />
                                </svg>

                                <span
                                    class="header-count-badge compare-count-badge {{ $compareCount > 0 ? '' : 'd-none' }}"
                                    style="{{ $compareCount > 0 ? 'display: inline-flex !important;' : 'display: none !important;' }}">
                                    {{ $compareCount }}
                                </span>
                            </a>
                            <!-- Search trigger -->
                            <a href="#" class="text-dark text-decoration-none" aria-label="Search"
                                data-search-toggle>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.031 16.617L22.314 20.899L20.899 22.314L16.617 18.031C15.0237 19.3082 13.042 20.0029 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20.0029 13.042 19.3082 15.0237 18.031 16.617ZM16.025 15.875C17.2938 14.5697 18.0025 12.8204 18 11C18 7.133 14.867 4 11 4C7.133 4 4 7.133 4 11C4 14.867 7.133 18 11 18C12.8204 18.0025 14.5697 17.2938 15.875 16.025L16.025 15.875Z"
                                        fill="#64748B" />
                                </svg>
                            </a>
                        </div>
                        <div class="ms-md-2 d-flex align-items-center gap-3">
                            @if (\Illuminate\Support\Facades\Auth::guard('customer')->check())
                                <div class="dropdown">
                                    <a href="#"
                                        class="d-flex align-items-center text-decoration-none dropdown-toggle-nocaret"
                                        id="userMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if (session()->get('customer_pic'))
                                            <img src="{{ getImageUrl(session()->get('customer_pic')) }}"
                                                class="rounded-circle border" alt="User"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle border bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-14"
                                                style="width: 40px; height: 40px; background: linear-gradient(135deg, #0066CC 0%, #0055BB 100%) !important;">
                                                {{ strtoupper(substr(session()->get('customer_name'), 0, 1)) }}
                                            </div>
                                        @endif
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border border-light-subtle rounded-3 py-2 mt-2"
                                        aria-labelledby="userMenuDropdown"
                                        style="min-width: 200px; box-shadow: 0 10px 30px rgba(0,0,0,0.075) !important;">
                                        <li class="px-3 py-2 border-bottom border-light-subtle mb-1">
                                            <div class="fw-bold text-dark fs-14">{{ session()->get('customer_name') }}
                                            </div>
                                            <div class="text-muted fs-12">{{ session()->get('customer_email') }}</div>
                                        </li>
                                        <li><a class="dropdown-item fs-13 py-2"
                                                href="{{ route('customer.dashboard') }}"><i
                                                    class="bi bi-speedometer2 me-2 text-secondary"></i> My
                                                Dashboard</a>
                                        </li>
                                        <li><a class="dropdown-item fs-13 py-2" href="{{ route('customer.orders') }}"><i
                                                    class="bi bi-box-seam me-2 text-secondary"></i> My Orders</a></li>
                                        <li><a class="dropdown-item fs-13 py-2" href="{{ route('favorite') }}"><i
                                                    class="bi bi-heart me-2 text-secondary"></i> My Wishlist</a></li>
                                        <li><a class="dropdown-item fs-13 py-2" href="{{ route('cart') }}"><i
                                                    class="bi bi-cart me-2 text-secondary"></i> My Basket</a></li>
                                        <li>
                                            <hr class="dropdown-divider border-light-subtle my-1">
                                        </li>
                                        <li class="px-2">
                                            <form action="{{ route('logout') }}" method="POST" class="mb-0">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm w-100 rounded-2 fw-semibold fs-12 text-white">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('signup') }}"
                                    class="text-primary text-decoration-none fw-semibold fs-14 btn-open-auth-modal"
                                    data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="signup">Sign
                                    Up</a>
                                <a href="{{ route('signin') }}"
                                    class="btn btn-primary rounded-2 px-3 py-2 fw-semibold fs-14 text-white btn-open-auth-modal"
                                    data-bs-toggle="modal" data-bs-target="#authModal"
                                    data-auth-tab="signin">Login</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Offcanvas Menu -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" role="dialog"
    aria-labelledby="mobileMenuLabel" aria-modal="true">
    <div class="offcanvas-header border-bottom">
        <a href="{{ route('home') }}" class="brand-logo d-flex align-items-center text-decoration-none">
            @if (!empty($settings['store_logo']) && !str_contains($settings['store_logo'], 'placehold.co'))
                <img src="{{ getImageUrl($settings['store_logo']) }}"
                    alt="{{ $settings['brand_name'] ?? 'AIRE' }} logo" class="logo-header-img"
                    style="max-height: 32px;">
            @else
                <img src="{{ theme_asset('img/logo.png') }}" alt="{{ $settings['brand_name'] ?? 'AIRE' }} logo"
                    class="logo-header-img">
            @endif
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between" data-lenis-prevent>
        <div>
            <p class="text-uppercase fw-bold text-muted mb-3 fs-12">Main Menu</p>
            <nav class="mobile-nav mb-4">
                @php
                    $currentRouteName = request()->route() ? request()->route()->getName() : '';
                    $currentSlug = request()->route('slug');
                    $currentPath = '/' . trim(request()->path(), '/');

                    // Determine single mutually-exclusive active nav key
                    $activeKey = '';
                    if (request()->routeIs('compare')) {
                        $activeKey = 'compare';
                    } elseif (request()->routeIs('cart')) {
                        $activeKey = 'cart';
                    } elseif (request()->routeIs('about')) {
                        $activeKey = 'about';
                    } elseif (request()->routeIs('contact')) {
                        $activeKey = 'contact';
                    } elseif (request()->routeIs('docs') || $currentSlug === 'resources') {
                        $activeKey = 'resources';
                    } elseif (request()->routeIs('solutions') || $currentSlug === 'solutions') {
                        $activeKey = 'solutions';
                    } elseif ($currentSlug === 'industries') {
                        $activeKey = 'industries';
                    } elseif ($currentSlug === 'technologies') {
                        $activeKey = 'technologies';
                    } elseif (
                        request()->routeIs('categories') ||
                        (request()->routeIs('category.show') && $currentSlug === 'products')
                    ) {
                        $activeKey = 'products';
                    } elseif (request()->routeIs('products.filter') || request()->routeIs('products.*')) {
                        $activeKey = 'shop';
                    } elseif (request()->routeIs('home') || $currentPath === '/') {
                        $activeKey = 'home';
                    } elseif (!empty($currentSlug)) {
                        $activeKey = strtolower($currentSlug);
                    }
                @endphp

                @if (isset($mainHeaderMenu) && $mainHeaderMenu && $mainHeaderMenu->menus->count() > 0)
                    @php
                        $matchedActive = false;
                    @endphp
                    @foreach ($mainHeaderMenu->menus as $navItem)
                        @php
                            $itemUrl = $navItem->url ?? '#';
                            $navName = strtolower(trim($navItem->name));
                            $isActive = false;

                            if (!$matchedActive) {
                                if (
                                    $activeKey &&
                                    ($navName === $activeKey ||
                                        ($activeKey === 'home' && in_array($navName, ['home', 'industries'])) ||
                                        ($activeKey === 'industries' && in_array($navName, ['industries', 'home'])) ||
                                        ($activeKey === 'products' &&
                                            in_array($navName, ['products', 'categories', 'shop'])) ||
                                        ($activeKey === 'resources' && in_array($navName, ['resources', 'docs'])))
                                ) {
                                    $isActive = true;
                                    $matchedActive = true;
                                } elseif (
                                    $itemUrl !== '#' &&
                                    !empty($itemUrl) &&
                                    (request()->url() === url($itemUrl) ||
                                        (request()->path() !== '/' && request()->is(trim($itemUrl, '/'))))
                                ) {
                                    $isActive = true;
                                    $matchedActive = true;
                                }
                            }
                        @endphp
                        <a href="{{ $itemUrl }}" class="mobile-nav-link {{ $isActive ? 'active' : '' }}">
                            <span class="mobile-nav-link__text">{{ $navItem->name }}</span>
                        </a>
                    @endforeach
                @else
                    <a href="{{ route('category.show', 'solutions') }}"
                        class="mobile-nav-link {{ $activeKey === 'solutions' ? 'active' : '' }}">
                        <span class="mobile-nav-link__text">Solutions</span>
                    </a>
                    <a href="{{ route('categories') }}"
                        class="mobile-nav-link {{ $activeKey === 'products' ? 'active' : '' }}">
                        <span class="mobile-nav-link__text">Products</span>
                    </a>
                    <a href="{{ route('category.show', 'industries') }}"
                        class="mobile-nav-link {{ in_array($activeKey, ['industries', 'home']) ? 'active' : '' }}">
                        <span class="mobile-nav-link__text">Industries</span>
                    </a>
                    <a href="{{ route('compare') }}"
                        class="mobile-nav-link {{ $activeKey === 'compare' ? 'active' : '' }}">
                        <span class="mobile-nav-link__text">Compare</span>
                    </a>
                    <a href="{{ route('about') }}"
                        class="mobile-nav-link {{ $activeKey === 'about' ? 'active' : '' }}">
                        <span class="mobile-nav-link__text">About</span>
                    </a>
                    <a href="{{ route('contact') }}"
                        class="mobile-nav-link {{ $activeKey === 'contact' ? 'active' : '' }}">
                        <span class="mobile-nav-link__text">Contact</span>
                    </a>
                @endif
            </nav>

            <!-- Product Discovery Tools -->
            <p class="text-uppercase fw-bold text-muted mb-2 fs-12">Product Discovery</p>
            <div class="d-flex flex-column gap-2 mb-4">
                <a href="{{ route('products.filter') }}"
                    class="mobile-nav-special {{ request()->routeIs('products.filter') ? 'active' : '' }}">
                    <span class="special-icon">
                        <img src="{{ theme_asset('img/products-icon.png') }}" alt="">
                    </span>
                    <span class="mobile-special-pill__text">All products</span>
                    <i class="bi bi-chevron-right chevron"></i>
                </a>
                <a href="{{ route('products.filter-step') }}"
                    class="mobile-nav-special {{ request()->routeIs('products.filter-step') ? 'active' : '' }}">
                    <span class="special-icon">
                        <svg width="18" height="16" viewBox="0 0 17 15" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M2.77726 1.02777e-06C2.78897 1.02777e-06 2.80072 1.02777e-06 2.81251 1.02777e-06H13.3478C13.8479 -2.14722e-05 14.2756 -4.39603e-05 14.6174 0.043066C14.9798 0.0887935 15.3302 0.191469 15.6179 0.461431C15.9107 0.736156 16.0271 1.07892 16.0781 1.43554C16.1251 1.76313 16.1251 2.17048 16.125 2.63519V3.21759C16.125 3.58397 16.125 3.90071 16.0977 4.16483C16.0682 4.44905 16.0039 4.7157 15.8494 4.9717C15.6961 5.22578 15.4896 5.4102 15.2516 5.57553C15.0274 5.73128 14.7409 5.89253 14.404 6.0822L12.1972 7.32443C11.6948 7.60725 11.5199 7.7091 11.4032 7.81043C11.135 8.0433 10.9814 8.3016 10.9092 8.6253C10.8784 8.76368 10.875 8.9379 10.875 9.46718V11.5163C10.8751 12.1922 10.8751 12.7661 10.8056 13.2072C10.7315 13.6763 10.5599 14.1262 10.1099 14.4077C9.67005 14.6828 9.18563 14.6575 8.71485 14.5457C8.26148 14.438 7.70273 14.2196 7.0323 13.9574L6.96713 13.932C6.6531 13.8092 6.37808 13.7018 6.16039 13.5893C5.92643 13.4685 5.70915 13.3182 5.54291 13.0843C5.37481 12.8477 5.30741 12.594 5.27736 12.3347C5.24996 12.0983 5.24998 11.8145 5.25 11.498V9.46718C5.25 8.9379 5.24666 8.76368 5.21582 8.6253C5.14365 8.3016 4.99007 8.0433 4.72188 7.81043C4.60511 7.7091 4.43019 7.60725 3.92786 7.32443L1.72103 6.0822C1.38412 5.89253 1.09765 5.73128 0.873437 5.57553C0.635432 5.4102 0.428934 5.22578 0.275604 4.9717C0.121112 4.7157 0.0567841 4.44905 0.0273391 4.16483C-2.84482e-05 3.90071 -1.34696e-05 3.58397 1.53039e-06 3.21759L9.04058e-06 2.6735C9.04058e-06 2.66068 1.53039e-06 2.64791 1.53039e-06 2.63518C-2.84696e-05 2.17047 -6.596e-05 1.76313 0.046884 1.43554C0.0979815 1.07892 0.214322 0.736156 0.507137 0.461431C0.794874 0.191469 1.14521 0.0887935 1.50768 0.043066C1.84944 -4.39603e-05 2.27705 -2.14722e-05 2.77726 1.02777e-06ZM1.64847 1.15922C1.39823 1.19079 1.31865 1.24268 1.27688 1.28187C1.24019 1.31629 1.19178 1.37689 1.16051 1.59512C1.12636 1.83341 1.12501 2.15901 1.12501 2.6735V3.19086C1.12501 3.59152 1.1257 3.84959 1.14635 4.04891C1.16558 4.23454 1.1986 4.3238 1.23881 4.39043C1.28018 4.45899 1.34888 4.536 1.51526 4.65157C1.69055 4.77333 1.93002 4.90881 2.29495 5.11424L4.47972 6.3441C4.50018 6.35565 4.52033 6.36698 4.54018 6.37815C4.9592 6.61388 5.24459 6.77445 5.4594 6.9609C5.90292 7.34595 6.18748 7.81365 6.31385 8.3805C6.37527 8.65598 6.37517 8.96483 6.37502 9.40088C6.37502 9.42263 6.375 9.44475 6.375 9.46718V11.4693C6.375 11.8235 6.37588 12.0413 6.39488 12.2052C6.41207 12.3535 6.43914 12.4034 6.45998 12.4327C6.48269 12.4646 6.52768 12.5129 6.6765 12.5897C6.8358 12.672 7.05533 12.7586 7.4019 12.894C8.12265 13.1758 8.60745 13.3639 8.9748 13.4511C9.33375 13.5364 9.45203 13.4922 9.51323 13.4539C9.56423 13.422 9.64298 13.3573 9.69428 13.032C9.74835 12.689 9.75 12.2051 9.75 11.4693V9.46718C9.75 9.44475 9.75 9.42263 9.75 9.40088C9.74985 8.96483 9.7497 8.65598 9.81113 8.3805C9.9375 7.81365 10.2221 7.34595 10.6656 6.9609C10.8804 6.77445 11.1658 6.61388 11.5848 6.37815C11.6047 6.36698 11.6249 6.35565 11.6453 6.3441L13.8301 5.11424C14.195 4.90881 14.4345 4.77333 14.6098 4.65157C14.7761 4.536 14.8448 4.45899 14.8862 4.39043C14.9264 4.3238 14.9594 4.23454 14.9786 4.04891C14.9993 3.84959 15 3.59152 15 3.19086V2.6735C15 2.15901 14.9987 1.83341 14.9645 1.59512C14.9333 1.37689 14.8848 1.31629 14.8481 1.28187C14.8064 1.24268 14.7268 1.19079 14.4766 1.15922C14.2136 1.12606 13.8578 1.125 13.3125 1.125H2.81251C2.26723 1.125 1.91141 1.12606 1.64847 1.15922Z"
                                fill="#231F20" />
                        </svg>
                    </span>
                    <span>Find Your Solutions</span>
                    <i class="bi bi-chevron-right chevron"></i>
                </a>
            </div>
        </div>

        <!-- Mobile Auth Actions -->
        <div class="pt-3 border-top mt-auto">
            @if (\Illuminate\Support\Facades\Auth::guard('customer')->check())
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-13"
                        style="width: 36px; height: 36px;">
                        {{ strtoupper(substr(session()->get('customer_name'), 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-bold fs-14 text-dark">{{ session()->get('customer_name') }}</div>
                        <div class="text-muted fs-12">{{ session()->get('customer_email') }}</div>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ route('customer.dashboard') }}"
                        class="btn btn-outline-dark btn-sm rounded-2 py-2 fw-semibold">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                    <a href="{{ route('customer.orders') }}"
                        class="btn btn-outline-dark btn-sm rounded-2 py-2 fw-semibold">
                        <i class="bi bi-box-seam me-1"></i> My Orders
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="mb-0">
                        @csrf
                        <button type="submit"
                            class="btn btn-danger btn-sm w-100 rounded-2 py-2 fw-semibold text-white">Logout</button>
                    </form>
                </div>
            @else
                <div class="d-grid gap-2">
                    <button type="button"
                        class="btn btn-primary rounded-2 py-2 fw-semibold text-white btn-open-auth-modal"
                        data-bs-dismiss="offcanvas" data-bs-toggle="modal" data-bs-target="#authModal"
                        data-auth-tab="signin">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                    </button>
                    <button type="button"
                        class="btn btn-outline-primary rounded-2 py-2 fw-semibold btn-open-auth-modal"
                        data-bs-dismiss="offcanvas" data-bs-toggle="modal" data-bs-target="#authModal"
                        data-auth-tab="signup">
                        <i class="bi bi-person-plus me-1"></i> Create Account
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Mobile Bottom Floating Action Bar -->
<div class="mobile-bottom-dock d-xl-none" role="navigation" aria-label="Mobile Bottom Navigation">
    <div class="mobile-dock-inner">
        <!-- Cart -->
        <a href="{{ route('cart') }}" class="mobile-dock-item {{ request()->routeIs('cart') ? 'active' : '' }}"
            aria-label="Cart">
            <div class="mobile-dock-icon position-relative">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M17 18C17.5304 18 18.0391 18.2107 18.4142 18.5858C18.7893 18.9609 19 19.4696 19 20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22C16.4696 22 15.9609 21.7893 15.5858 21.4142C15.2107 21.0391 15 20.5304 15 20C15 18.89 15.89 18 17 18ZM1 2H4.27L5.21 4H20C20.2652 4 20.5196 4.10536 20.7071 4.29289C20.8946 4.48043 21 4.73478 21 5C21 5.17 20.95 5.34 20.88 5.5L17.3 11.97C16.96 12.58 16.3 13 15.55 13H8.1L7.2 14.63L7.17 14.75C7.17 14.8163 7.19634 14.8799 7.24322 14.9268C7.29011 14.9737 7.3537 15 7.42 15H19V17H7C6.46957 17 5.96086 16.7893 5.58579 16.4142C5.21071 16.0391 5 15.5304 5 15C5 14.65 5.09 14.32 5.24 14.04L6.6 11.59L3 4H1V2ZM7 18C7.53043 18 8.03914 18.2107 8.41421 18.5858C8.78929 18.9609 9 19.4696 9 20C9 20.5304 8.78929 21.0391 8.41421 21.4142C8.03914 21.7893 7.53043 22 7 22C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20C5 18.89 5.89 18 7 18ZM16 11L18.78 6H6.14L8.5 11H16Z"
                        fill="currentColor" />
                </svg>
                <span class="header-count-badge cart-count-badge {{ $cartCount > 0 ? '' : 'd-none' }}"
                    style="{{ $cartCount > 0 ? 'display: inline-flex !important;' : 'display: none !important;' }}">
                    {{ $cartCount }}
                </span>
            </div>
            <span class="mobile-dock-label">Cart</span>
        </a>

        <!-- Wishlist -->
        <a href="{{ route('favorite') }}"
            class="mobile-dock-item {{ request()->routeIs('favorite') ? 'active' : '' }}" aria-label="Favorites">
            <div class="mobile-dock-icon position-relative">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 21L10.55 19.7C8.86667 18.1833 7.475 16.875 6.375 15.775C5.275 14.675 4.4 13.6873 3.75 12.812C3.1 11.9367 2.646 11.1327 2.388 10.4C2.13 9.66733 2.00067 8.91733 2 8.15C2 6.58333 2.525 5.275 3.575 4.225C4.625 3.175 5.93333 2.65 7.5 2.65C8.36667 2.65 9.19167 2.83333 9.975 3.2C10.7583 3.56667 11.4333 4.08333 12 4.75C12.5667 4.08333 13.2417 3.56667 14.025 3.2C14.8083 2.83333 15.6333 2.65 16.5 2.65C18.0667 2.65 19.375 3.175 20.425 4.225C21.475 5.275 22 6.58333 22 8.15C22 8.91667 21.871 9.66667 21.613 10.4C21.355 11.1333 20.9007 11.9373 20.25 12.812C19.5993 13.6867 18.7243 14.6743 17.625 15.775C16.5257 16.8757 15.134 18.184 13.45 19.7L12 21ZM12 18.3C13.6 16.8667 14.9167 15.6377 15.95 14.613C16.9833 13.5883 17.8 12.6967 18.4 11.938C19 11.1793 19.4167 10.504 19.65 9.912C19.8833 9.32 20 8.73267 20 8.15C20 7.15 19.6667 6.31667 19 5.65C18.3333 4.98333 17.5 4.65 16.5 4.65C15.7167 4.65 14.9917 4.87067 14.325 5.312C13.6583 5.75333 13.2 6.316 12.95 7H11.05C10.8 6.31667 10.3417 5.75433 9.675 5.313C9.00833 4.87167 8.28333 4.65067 7.5 4.65C6.5 4.65 5.66667 4.98333 5 5.65C4.33333 6.31667 4 7.15 4 8.15C4 8.73333 4.11667 9.321 4.35 9.913C4.58333 10.505 5 11.18 5.6 11.938C6.2 12.696 7.01667 13.5877 8.05 14.613C9.08333 15.6383 10.4 16.8673 12 18.3Z"
                        fill="currentColor" />
                </svg>
                <span class="header-count-badge favorite-count-badge {{ $favCount > 0 ? '' : 'd-none' }}"
                    style="{{ $favCount > 0 ? 'display: inline-flex !important;' : 'display: none !important;' }}">
                    {{ $favCount }}
                </span>
            </div>
            <span class="mobile-dock-label">Wishlist</span>
        </a>

        <!-- Compare -->
        <a href="{{ route('compare') }}"
            class="mobile-dock-item {{ request()->routeIs('compare') ? 'active' : '' }}" aria-label="Compare">
            <div class="mobile-dock-icon position-relative">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2 5C2 6.3 2.84 7.4 4 7.82V17.5C4 18.163 4.26339 18.7989 4.73223 19.2678C5.20107 19.7366 5.83696 20 6.5 20H10V22L14 19L10 16V18H6.5C6.22 18 6 17.78 6 17.5V7.82C7.16 7.41 8 6.31 8 5C8 3.35 6.65 2 5 2C3.35 2 2 3.35 2 5ZM5 4C5.55 4 6 4.45 6 5C6 5.55 5.55 6 5 6C4.45 6 4 5.55 4 5C4 4.45 4.45 4 5 4ZM20 16.18V6.5C20 5.83696 19.7366 5.20107 19.2678 4.73223C18.7989 4.26339 18.163 4 17.5 4H14V2L10 5L14 8V6H17.5C17.78 6 18 6.22 18 6.5V16.18C16.84 16.59 16 17.69 16 19C16 20.65 17.35 22 19 22C20.65 22 22 20.65 22 19C22 17.7 21.16 16.6 20 16.18ZM19 20C18.45 20 18 19.55 18 19C18 18.45 18.45 18 19 18C19.55 18 20 18.45 20 19C20 19.55 19.55 20 19 20Z"
                        fill="currentColor" />
                </svg>
                <span class="header-count-badge compare-count-badge {{ $compareCount > 0 ? '' : 'd-none' }}"
                    style="{{ $compareCount > 0 ? 'display: inline-flex !important;' : 'display: none !important;' }}">
                    {{ $compareCount }}
                </span>
            </div>
            <span class="mobile-dock-label">Compare</span>
        </a>

        <!-- Search trigger -->
        <a href="javascript:void(0);" class="mobile-dock-item" aria-label="Search" data-search-toggle>
            <div class="mobile-dock-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M18.031 16.617L22.314 20.899L20.899 22.314L16.617 18.031C15.0237 19.3082 13.042 20.0029 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20.0029 13.042 19.3082 15.0237 18.031 16.617ZM16.025 15.875C17.2938 14.5697 18.0025 12.8204 18 11C18 7.133 14.867 4 11 4C7.133 4 4 7.133 4 11C4 14.867 7.133 18 11 18C12.8204 18.0025 14.5697 17.2938 15.875 16.025L16.025 15.875Z"
                        fill="currentColor" />
                </svg>
            </div>
            <span class="mobile-dock-label">Search</span>
        </a>
    </div>
</div>
