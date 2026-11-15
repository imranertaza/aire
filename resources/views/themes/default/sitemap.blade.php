@extends('themes.default.layouts.master')

@php
    $brandName = $settings['brand_name'] ?? 'AIRE';
    $productsCategory = $categories->firstWhere('slug', 'products') ?? $categories->first();
    $solutionsCategory = $categories->firstWhere('slug', 'solutions');
    $industriesCategory = $categories->firstWhere('slug', 'industries');
    $technologiesCategory = $categories->firstWhere('slug', 'technologies');
    $monitoringCategory = $categories->firstWhere('slug', 'monitoring');
@endphp

@section('title', 'Site Map | ' . $brandName)
@section('meta_description', 'Explore an organized directory of all ' . $brandName . ' products, engineering solutions, technical resources, customer support, and corporate links.')

@push('styles')
<style>
    /* ==========================================================================
       Official Apple-Style Site Map Layout & Typography
       ========================================================================== */
    :root {
        --apple-bg: #ffffff;
        --apple-text-primary: #1d1d1f;
        --apple-text-secondary: #515154;
        --apple-text-muted: #86868b;
        --apple-border: #e5e7eb;
        --apple-border-dark: #d2d2d7;
        --apple-blue: var(--color-primary, #0095DA);
        --apple-blue-hover: #0077b6;
    }

    body {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .sitemap-wrapper {
        background-color: var(--apple-bg);
        color: var(--apple-text-primary);
        font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "SF Pro Icons", "Helvetica Neue", Helvetica, Arial, sans-serif;
        padding-bottom: 90px;
    }

    .sitemap-container {
        max-width: 1040px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Breadcrumbs */
    .sitemap-breadcrumb {
        font-size: 12px;
        font-weight: 400;
        padding: 12px 0;
        color: var(--apple-text-muted);
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 20px;
    }

    .sitemap-breadcrumb a {
        color: var(--apple-text-muted);
        text-decoration: none;
        transition: color 0.15s ease;
    }

    .sitemap-breadcrumb a:hover {
        color: var(--apple-text-primary);
    }

    .sitemap-breadcrumb .separator {
        margin: 0 8px;
        color: #d2d2d7;
    }

    .sitemap-breadcrumb .current {
        color: var(--apple-text-primary);
        font-weight: 500;
    }

    /* Page Header */
    .sitemap-header {
        margin-bottom: 22px;
    }

    .sitemap-title {
        font-size: 24px;
        font-weight: 600;
        letter-spacing: -0.015em;
        color: var(--apple-text-primary);
        margin: 0;
        line-height: 1.25;
    }

    /* Major Directory Sections */
    .sitemap-section {
        margin-bottom: 48px;
    }

    .sitemap-section-head {
        border-bottom: 1px solid var(--apple-border-dark);
        padding-bottom: 8px;
        margin-bottom: 22px;
        display: flex;
        align-items: baseline;
        justify-content: space-between;
    }

    /* Sleek, refined section title like Apple */
    .sitemap-section-title {
        font-size: 16px;
        font-weight: 600;
        letter-spacing: -0.01em;
        color: var(--apple-text-primary);
        margin: 0;
    }

    .sitemap-section-tag {
        font-size: 12px;
        color: var(--apple-text-muted);
        font-weight: 400;
    }

    /* Multi-Column Apple Grid */
    .sitemap-columns-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 32px 28px;
    }

    .sitemap-col {
        display: flex;
        flex-direction: column;
        break-inside: avoid;
    }

    /* Column Headings */
    .sitemap-col-title {
        font-size: 13.5px;
        font-weight: 600;
        letter-spacing: -0.01em;
        color: var(--apple-text-primary);
        margin: 0 0 10px 0;
        line-height: 1.35;
    }

    .sitemap-col-title a {
        color: var(--apple-text-primary);
        text-decoration: none;
        transition: color 0.15s ease;
    }

    .sitemap-col-title a:hover {
        color: var(--apple-blue);
    }

    /* Link Lists */
    .sitemap-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sitemap-list li {
        margin-bottom: 7px;
        line-height: 1.5;
    }

    .sitemap-link {
        font-size: 13px;
        color: var(--apple-text-secondary);
        text-decoration: none;
        display: inline-block;
        transition: color 0.15s ease;
    }

    .sitemap-link:hover {
        color: var(--apple-blue);
        text-decoration: underline;
    }

    .sitemap-link.strong {
        font-weight: 600;
        color: var(--apple-text-primary);
    }

    .sitemap-col-footer {
        margin-top: 8px;
        padding-top: 6px;
    }

    .sitemap-explore-btn {
        font-size: 12px;
        font-weight: 500;
        color: var(--apple-blue);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: gap 0.15s ease, color 0.15s ease;
    }

    .sitemap-explore-btn:hover {
        color: var(--apple-blue-hover);
        gap: 7px;
        text-decoration: underline;
    }

    /* Floating Scroll to Top */
    .sitemap-scroll-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid var(--apple-border-dark);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 1040;
        color: var(--apple-text-primary);
        font-size: 15px;
        transition: all 0.2s ease;
    }

    .sitemap-scroll-top:hover {
        background: var(--apple-text-primary);
        color: #ffffff;
        border-color: var(--apple-text-primary);
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .sitemap-columns-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 28px 22px;
        }
    }

    @media (max-width: 767.98px) {
        .sitemap-columns-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 24px 18px;
        }
    }

    @media (max-width: 575.98px) {
        .sitemap-columns-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .sitemap-title {
            font-size: 21px;
        }
        .sitemap-section-title {
            font-size: 15px;
        }
    }
</style>
@endpush

@section('content')
<div class="sitemap-wrapper">
    <div class="sitemap-container">

        <!-- Breadcrumb -->
        <nav class="sitemap-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="separator">/</span>
            <span class="current">Site Map</span>
        </nav>

        <!-- Page Header: Just page name like Apple -->
        <div class="sitemap-header">
            <h1 class="sitemap-title">Site Map</h1>
        </div>

        <!-- =========================================================================
             SECTION 1: PRODUCTS & HARDWARE (Shop and Learn)
             ========================================================================= -->
        @if ($productsCategory)
            <section id="section-products" class="sitemap-section">
                <div class="sitemap-section-head">
                    <h2 class="sitemap-section-title">Products & Hardware</h2>
                    <span class="sitemap-section-tag">Shop and Learn</span>
                </div>

                <div class="sitemap-columns-grid">
                    @foreach ($productsCategory->children as $prodCat)
                        <div class="sitemap-col">
                            <h3 class="sitemap-col-title">
                                <a href="{{ route('category.show', $prodCat->slug ?: $prodCat->id) }}">
                                    {{ $prodCat->category_name }}
                                </a>
                            </h3>

                            @if ($prodCat->children && $prodCat->children->isNotEmpty())
                                <ul class="sitemap-list">
                                    @foreach ($prodCat->children as $subCat)
                                        <li>
                                            <a href="{{ route('category.show', $subCat->slug ?: $subCat->id) }}" class="sitemap-link">
                                                {{ $subCat->category_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @elseif ($prodCat->products && $prodCat->products->isNotEmpty())
                                <ul class="sitemap-list">
                                    @foreach ($prodCat->products->take(6) as $pItem)
                                        <li>
                                            <a href="{{ route('products.detail', $pItem->slug ?: $pItem->id) }}" class="sitemap-link">
                                                {{ $pItem->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <div class="sitemap-col-footer">
                                <a href="{{ route('category.all', $prodCat->slug ?: $prodCat->id) }}" class="sitemap-explore-btn">
                                    All {{ $prodCat->category_name }} &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach

                    <!-- Product Selectors & Tools Column -->
                    <div class="sitemap-col">
                        <h3 class="sitemap-col-title">Product Tools</h3>
                        <ul class="sitemap-list">
                            <li>
                                <a href="{{ route('products.index') }}" class="sitemap-link strong">
                                    All Products Catalog
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('categories') }}" class="sitemap-link">
                                    Category Showcase Grid
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('products.filter-step') }}" class="sitemap-link">
                                    Solution Finder Wizard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('products.finder') }}" class="sitemap-link">
                                    Interactive Product Selector
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('compare') }}" class="sitemap-link">
                                    Compare Product Specs
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('favorite') }}" class="sitemap-link">
                                    Saved & Favorite Items
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        @endif

        <!-- =========================================================================
             SECTION 2: SOLUTIONS & APPLICATIONS
             ========================================================================= -->
        @if ($solutionsCategory && $solutionsCategory->children->isNotEmpty())
            <section id="section-solutions" class="sitemap-section">
                <div class="sitemap-section-head">
                    <h2 class="sitemap-section-title">Solutions & Applications</h2>
                    <span class="sitemap-section-tag">Targeted Environments</span>
                </div>

                <div class="sitemap-columns-grid">
                    @foreach ($solutionsCategory->children as $solCat)
                        <div class="sitemap-col">
                            <h3 class="sitemap-col-title">
                                <a href="{{ route('category.show', $solCat->slug ?: $solCat->id) }}">
                                    {{ $solCat->category_name }}
                                </a>
                            </h3>

                            @if ($solCat->children && $solCat->children->isNotEmpty())
                                <ul class="sitemap-list">
                                    @foreach ($solCat->children as $subSol)
                                        <li>
                                            <a href="{{ route('category.show', $subSol->slug ?: $subSol->id) }}" class="sitemap-link">
                                                {{ $subSol->category_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @elseif ($solCat->products && $solCat->products->isNotEmpty())
                                <ul class="sitemap-list">
                                    @foreach ($solCat->products->take(5) as $sp)
                                        <li>
                                            <a href="{{ route('products.detail', $sp->slug ?: $sp->id) }}" class="sitemap-link">
                                                {{ $sp->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <div class="sitemap-col-footer">
                                <a href="{{ route('category.show', $solCat->slug ?: $solCat->id) }}" class="sitemap-explore-btn">
                                    Learn more &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- =========================================================================
             SECTION 3: INDUSTRIES SERVED
             ========================================================================= -->
        @if ($industriesCategory && $industriesCategory->children->isNotEmpty())
            <section id="section-industries" class="sitemap-section">
                <div class="sitemap-section-head">
                    <h2 class="sitemap-section-title">Industries Served</h2>
                    <span class="sitemap-section-tag">Sector Solutions</span>
                </div>

                <div class="sitemap-columns-grid">
                    @foreach ($industriesCategory->children as $indCat)
                        <div class="sitemap-col">
                            <h3 class="sitemap-col-title">
                                <a href="{{ route('category.show', $indCat->slug ?: $indCat->id) }}">
                                    {{ $indCat->category_name }}
                                </a>
                            </h3>

                            @if ($indCat->children && $indCat->children->isNotEmpty())
                                <ul class="sitemap-list">
                                    @foreach ($indCat->children as $subInd)
                                        <li>
                                            <a href="{{ route('category.show', $subInd->slug ?: $subInd->id) }}" class="sitemap-link">
                                                {{ $subInd->category_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @elseif ($indCat->products && $indCat->products->isNotEmpty())
                                <ul class="sitemap-list">
                                    @foreach ($indCat->products->take(4) as $ip)
                                        <li>
                                            <a href="{{ route('products.detail', $ip->slug ?: $ip->id) }}" class="sitemap-link">
                                                {{ $ip->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <div class="sitemap-col-footer">
                                <a href="{{ route('category.show', $indCat->slug ?: $indCat->id) }}" class="sitemap-explore-btn">
                                    View sector details &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- =========================================================================
             SECTION 4: TECHNOLOGIES & INNOVATION
             ========================================================================= -->
        @if ($technologiesCategory && $technologiesCategory->children->isNotEmpty())
            <section id="section-technologies" class="sitemap-section">
                <div class="sitemap-section-head">
                    <h2 class="sitemap-section-title">Technologies & Innovation</h2>
                    <span class="sitemap-section-tag">Engineering Core</span>
                </div>

                <div class="sitemap-columns-grid">
                    @foreach ($technologiesCategory->children as $techCat)
                        <div class="sitemap-col">
                            <h3 class="sitemap-col-title">
                                <a href="{{ route('category.show', $techCat->slug ?: $techCat->id) }}">
                                    {{ $techCat->category_name }}
                                </a>
                            </h3>

                            @if ($techCat->children && $techCat->children->isNotEmpty())
                                <ul class="sitemap-list">
                                    @foreach ($techCat->children as $subTech)
                                        <li>
                                            <a href="{{ route('category.show', $subTech->slug ?: $subTech->id) }}" class="sitemap-link">
                                                {{ $subTech->category_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @elseif ($techCat->products && $techCat->products->isNotEmpty())
                                <ul class="sitemap-list">
                                    @foreach ($techCat->products->take(4) as $tp)
                                        <li>
                                            <a href="{{ route('products.detail', $tp->slug ?: $tp->id) }}" class="sitemap-link">
                                                {{ $tp->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <div class="sitemap-col-footer">
                                <a href="{{ route('category.show', $techCat->slug ?: $techCat->id) }}" class="sitemap-explore-btn">
                                    Explore technology &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- =========================================================================
             SECTION 5: RESOURCES & DOCUMENTATION (Explore & Research)
             ========================================================================= -->
        <section id="section-resources" class="sitemap-section">
            <div class="sitemap-section-head">
                <h2 class="sitemap-section-title">Resources & Documentation</h2>
                <span class="sitemap-section-tag">Engineering & Media</span>
            </div>

            <div class="sitemap-columns-grid">
                <!-- Resource Center Categories -->
                <div class="sitemap-col">
                    <h3 class="sitemap-col-title">
                        <a href="{{ route('resources') }}">Resource Hub</a>
                    </h3>
                    <ul class="sitemap-list">
                        <li>
                            <a href="{{ route('resources') }}" class="sitemap-link strong">
                                All Resources Overview
                            </a>
                        </li>
                        @foreach ($resourceCategories as $resCat)
                            <li>
                                <a href="{{ route('resources.category', $resCat->slug) }}" class="sitemap-link">
                                    {{ $resCat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- News & Media -->
                <div class="sitemap-col">
                    <h3 class="sitemap-col-title">
                        <a href="{{ route('news.index') }}">News & Press</a>
                    </h3>
                    <ul class="sitemap-list">
                        <li>
                            <a href="{{ route('news.index') }}" class="sitemap-link strong">
                                Corporate News & Press
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('news-and-updates') }}" class="sitemap-link">
                                Product & Engineering Updates
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('newsletter.unsubscribe', 'manage') }}" class="sitemap-link">
                                Newsletter Management
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Technical Literature -->
                <div class="sitemap-col">
                    <h3 class="sitemap-col-title">Technical Literature</h3>
                    <ul class="sitemap-list">
                        <li>
                            <a href="{{ route('resources') }}" class="sitemap-link">
                                Product Catalogs & Brochures
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('resources') }}" class="sitemap-link">
                                Installation & Operation Manuals
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('resources') }}" class="sitemap-link">
                                Filter Maintenance Specs
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('resources') }}" class="sitemap-link">
                                Air Filtration Certifications
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Multimedia & Guides -->
                <div class="sitemap-col">
                    <h3 class="sitemap-col-title">Multimedia & Guides</h3>
                    <ul class="sitemap-list">
                        <li>
                            <a href="{{ route('resources') }}" class="sitemap-link">
                                Video Walkthroughs
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('resources') }}" class="sitemap-link">
                                FAQs & Knowledge Base
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products.filter-step') }}" class="sitemap-link">
                                Indoor Air Quality Assessment
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- =========================================================================
             SECTION 6: CUSTOMER SERVICES & SUPPORT
             ========================================================================= -->
        <section id="section-services" class="sitemap-section">
            <div class="sitemap-section-head">
                <h2 class="sitemap-section-title">Customer Services & Support</h2>
                <span class="sitemap-section-tag">Assistance</span>
            </div>

            <div class="sitemap-columns-grid">
                <!-- Customer Care -->
                <div class="sitemap-col">
                    <h3 class="sitemap-col-title">
                        <a href="{{ route('contact') }}">Customer Care</a>
                    </h3>
                    <ul class="sitemap-list">
                        <li>
                            <a href="{{ route('contact') }}" class="sitemap-link strong">
                                Contact Customer Support
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="sitemap-link">
                                Technical Consultation
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="sitemap-link">
                                Sales & Quotation Requests
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('resources') }}" class="sitemap-link">
                                Help Topics & FAQs
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Project Consultation -->
                <div class="sitemap-col">
                    <h3 class="sitemap-col-title">Project Consultation</h3>
                    <ul class="sitemap-list">
                        <li>
                            <a href="{{ route('products.filter-step') }}" class="sitemap-link">
                                Residential Air Quality Plan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products.filter-step') }}" class="sitemap-link">
                                Commercial Building Engineering
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products.filter-step') }}" class="sitemap-link">
                                Healthcare Cleanroom Standards
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('compare') }}" class="sitemap-link">
                                System Model Comparisons
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Online Tools -->
                <div class="sitemap-col">
                    <h3 class="sitemap-col-title">Online Tools</h3>
                    <ul class="sitemap-list">
                        <li>
                            <a href="{{ route('products.finder') }}" class="sitemap-link">
                                Interactive Product Selector
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products.filter-step') }}" class="sitemap-link">
                                Step-by-Step Solution Wizard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('compare') }}" class="sitemap-link">
                                Side-by-Side Comparison
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.orders') }}" class="sitemap-link">
                                Order Status & Tracking
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- =========================================================================
             SECTION 7: CUSTOMER ACCOUNT & STORE
             ========================================================================= -->
        <section id="section-account" class="sitemap-section">
            <div class="sitemap-section-head">
                <h2 class="sitemap-section-title">Customer Account & Orders</h2>
                <span class="sitemap-section-tag">Account</span>
            </div>

            <div class="sitemap-columns-grid">
                <!-- Account Access -->
                <div class="sitemap-col">
                    <h3 class="sitemap-col-title">Account Access</h3>
                    <ul class="sitemap-list">
                        <li>
                            <a href="{{ route('signin') }}" class="sitemap-link">
                                Sign In
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('signup') }}" class="sitemap-link">
                                Create an Account
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('password.request') }}" class="sitemap-link">
                                Password Recovery
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Customer Portal -->
                <div class="sitemap-col">
                    <h3 class="sitemap-col-title">Customer Dashboard</h3>
                    <ul class="sitemap-list">
                        <li>
                            <a href="{{ route('customer.dashboard') }}" class="sitemap-link">
                                Dashboard Overview
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.orders') }}" class="sitemap-link">
                                My Orders & History
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.profile') }}" class="sitemap-link">
                                Profile & Addresses
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.wallet') }}" class="sitemap-link">
                                Digital Wallet
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.points') }}" class="sitemap-link">
                                Reward Points
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Storefront -->
                <div class="sitemap-col">
                    <h3 class="sitemap-col-title">Store & Orders</h3>
                    <ul class="sitemap-list">
                        <li>
                            <a href="{{ route('cart') }}" class="sitemap-link">
                                Shopping Cart
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('checkout') }}" class="sitemap-link">
                                Secure Checkout
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('favorite') }}" class="sitemap-link">
                                Saved Wishlist
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- =========================================================================
             SECTION 8: COMPANY & ABOUT AIRE
             ========================================================================= -->
        <section id="section-company" class="sitemap-section">
            <div class="sitemap-section-head">
                <h2 class="sitemap-section-title">Company & About {{ $brandName }}</h2>
                <span class="sitemap-section-tag">About</span>
            </div>

            <div class="sitemap-columns-grid">
                <!-- Corporate Profile -->
                <div class="sitemap-col">
                    <h3 class="sitemap-col-title">
                        <a href="{{ route('about') }}">About {{ $brandName }}</a>
                    </h3>
                    <ul class="sitemap-list">
                        <li>
                            <a href="{{ route('about') }}" class="sitemap-link strong">
                                Corporate Overview
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}#mission" class="sitemap-link">
                                Mission & Zero-Emission Vision
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}#technology" class="sitemap-link">
                                Technology & Patents
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}#leadership" class="sitemap-link">
                                Executive Leadership
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="sitemap-link">
                                Headquarters & Global Contacts
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Dynamic CMS Pages -->
                @if ($cmsPages->isNotEmpty())
                    <div class="sitemap-col">
                        <h3 class="sitemap-col-title">Information & Policies</h3>
                        <ul class="sitemap-list">
                            @foreach ($cmsPages as $page)
                                <li>
                                    <a href="{{ route('page.show', $page->slug) }}" class="sitemap-link">
                                        {{ $page->page_title ?? $page->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </section>

        <!-- =========================================================================
             SECTION 9: LEGAL, PRIVACY & SITE INDEXES
             ========================================================================= -->
        <section id="section-legal" class="sitemap-section">
            <div class="sitemap-section-head">
                <h2 class="sitemap-section-title">Legal, Privacy & Compliance</h2>
                <span class="sitemap-section-tag">Policies</span>
            </div>

            <div class="sitemap-columns-grid">
                <!-- Legal Terms -->
                <div class="sitemap-col">
                    <h3 class="sitemap-col-title">Legal Terms</h3>
                    <ul class="sitemap-list">
                        <li>
                            <a href="{{ route('page.show', 'privacy-policy') }}" class="sitemap-link">
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('page.show', 'terms-of-service') }}" class="sitemap-link">
                                Terms of Service
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('page.show', 'cookie-policy') }}" class="sitemap-link">
                                Cookie Policy
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('page.show', 'data-protection') }}" class="sitemap-link">
                                Data Protection & Security
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Site Indexes -->
                <div class="sitemap-col">
                    <h3 class="sitemap-col-title">Site Indexes</h3>
                    <ul class="sitemap-list">
                        <li>
                            <a href="{{ route('sitemap.html') }}" class="sitemap-link strong">
                                HTML Site Map (Current Page)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('sitemap') }}" target="_blank" class="sitemap-link">
                                XML Sitemap (Search Engines)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('robots') }}" target="_blank" class="sitemap-link">
                                Robots.txt File
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

    </div>
</div>

<!-- Floating Scroll to Top Button -->
<button type="button" id="sitemapScrollTop" class="sitemap-scroll-top" title="Scroll to top" aria-label="Scroll to top">
    <i class="bi bi-arrow-up"></i>
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scrollTopBtn = document.getElementById('sitemapScrollTop');

        window.addEventListener('scroll', function() {
            if (scrollTopBtn) {
                if (window.scrollY > 400) {
                    scrollTopBtn.style.display = 'flex';
                } else {
                    scrollTopBtn.style.display = 'none';
                }
            }
        });

        if (scrollTopBtn) {
            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
</script>
@endsection
