@php
    $currentSlug = $page->slug ?? '';
    $canonicalUrl = $canonicalUrl ?? route('page.show', $page->slug ?? 'page');
    $plainText = strip_tags($page->page_description ?? '');
    $wordCount = str_word_count($plainText);
    $readTimeMinutes = max(1, (int) ceil($wordCount / 200));
    $lastUpdatedIso = $page->updated_at ? $page->updated_at->toIso8601String() : now()->toIso8601String();
    $lastUpdatedFormatted = $page->updated_at ? $page->updated_at->format('F Y') : now()->format('F Y');

    // Extract menu items from $sidebarMenu or $legalPages
    $menuItems = collect();
    $menuTitle = 'Legal & Policies';

    $targetMenu = $sidebarMenu ?? ($legalPages ?? null);
    if ($targetMenu) {
        if ($targetMenu instanceof \App\Models\Menu) {
            $menuItems = $targetMenu->menus ?? collect();
            $menuTitle = $targetMenu->name ?: 'Legal & Policies';
        } elseif ($targetMenu instanceof \Illuminate\Support\Collection || is_array($targetMenu)) {
            $menuItems = collect($targetMenu);
        }

        if ($menuItems instanceof \Illuminate\Support\Collection && $menuItems->isNotEmpty()) {
            $menuItems = $menuItems->sortBy([
                ['order', 'asc'],
                ['id', 'asc'],
            ])->values();
        }
    }

    // Fallback menu list if database menu records are empty
    $fallbackLegalItems = [
        ['slug' => 'cookie-policy', 'page_title' => 'Cookie Policy', 'icon' => 'bi-shield-check'],
        ['slug' => 'privacy-policy', 'page_title' => 'Privacy Policy', 'icon' => 'bi-lock'],
        ['slug' => 'terms-of-service', 'page_title' => 'Terms of Service', 'icon' => 'bi-file-earmark-text'],
        ['slug' => 'modern-slavery-statement', 'page_title' => 'Modern Slavery Statement', 'icon' => 'bi-globe2'],
        ['slug' => 'data-protection', 'page_title' => 'Data Protection & GDPR', 'icon' => 'bi-shield-lock'],
        ['slug' => 'export-compliance', 'page_title' => 'Export Compliance', 'icon' => 'bi-check2-circle'],
        ['slug' => 'legal-notice', 'page_title' => 'Legal Notice', 'icon' => 'bi-info-circle'],
        ['slug' => 'terms-of-use', 'page_title' => 'Website Terms of Use', 'icon' => 'bi-journal-text'],
        ['slug' => 'sitemap', 'page_title' => 'Sitemap & Index', 'icon' => 'bi-diagram-3'],
    ];
@endphp

@include('themes.default.partials.page_schema', [
    'page' => $page,
    'canonicalUrl' => $canonicalUrl,
    'plainText' => $plainText,
    'lastUpdatedIso' => $lastUpdatedIso,
    'categoryName' => $page->breadcrumb ?? 'Legal & Compliance',
])

@pushOnce('styles')
    <link href="{{ theme_asset('css/legal.css') }}" rel="stylesheet">
@endpushOnce

@pushOnce('scripts')
    <script src="{{ theme_asset('js/legal.js') }}"></script>
@endpushOnce

<!-- =========================================================================
| Legal / Policy Atmospheric Hero Banner (FOOTER-2.png Design)
| ========================================================================= -->
<section class="legal-hero">
    <div class="container main-container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <div class="legal-hero-badge">
                    <i class="bi bi-shield-check"></i>
                    <span>CLEANER AIR &bull; BRIGHTER SPACES &bull; A HEALTHIER TOMORROW</span>
                </div>
                <h1 class="legal-hero-title">{{ $page->page_title }}</h1>
                <p class="legal-hero-lead">
                    @if (!empty($page->short_des))
                        {{ $page->short_des }}
                    @else
                        We believe in complete transparency and clarity. Review our policies, data management practices,
                        and legal commitments governing your experience with AIRE.
                    @endif
                </p>
            </div>
            <div class="col-lg-3 text-lg-end mt-4 mt-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                    style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);">
                    <i class="bi bi-patch-check-fill text-info fs-5"></i>
                    <div class="text-start">
                        <small class="d-block text-white-50 fs-11 text-uppercase fw-bold"
                            style="letter-spacing: 0.5px;">Document Status</small>
                        <span
                            class="text-white fw-bold fs-13">{{ $page->status ?? 1 ? 'Active & Verified' : 'Draft / Inactive' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================================
| Breadcrumbs & Action Toolbar Strip
| ========================================================================= -->
<section class="legal-toolbar-bar">
    <div class="container main-container">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb legal-breadcrumb align-items-center mb-0" style="--bs-breadcrumb-divider: '›';">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i> Home
                        </a>
                    </li>
                    @if (!empty($page->breadcrumb))
                        <li class="breadcrumb-item">
                            <span class="text-muted">{{ $page->breadcrumb }}</span>
                        </li>
                    @else
                        <li class="breadcrumb-item">
                            <span class="text-muted">Legal &amp; Compliance</span>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $page->page_title }}</li>
                </ol>
            </nav>

            <div class="d-flex align-items-center gap-3 flex-wrap">
                <span class="text-muted fs-13 d-flex align-items-center gap-1">
                    <i class="bi bi-clock-history"></i> Last updated:
                    <time datetime="{{ $lastUpdatedIso }}"
                        class="fw-semibold text-dark">{{ $lastUpdatedFormatted }}</time>
                </span>
                <span
                    class="badge bg-light text-secondary border px-2 py-1 fs-12 fw-normal d-inline-flex align-items-center gap-1">
                    <i class="bi bi-book"></i> ~{{ $readTimeMinutes }} min read
                </span>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" id="legalPrintBtn" class="legal-action-btn" title="Print this document">
                        <i class="bi bi-printer"></i> Print Page
                    </button>
                    <button type="button" id="legalPdfBtn" class="legal-action-btn primary" title="Save as PDF">
                        <i class="bi bi-file-earmark-pdf"></i> Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================================
| Main Content & Navigation Layout
| ========================================================================= -->
<main class="container main-container legal-layout-wrap">
    <div class="row g-4 g-lg-5">

        <!-- Left Column: Legal Navigation & Support Sidebar -->
        <aside class="col-lg-3 col-xl-3">
            <div class="legal-sidebar-sticky" data-lenis-prevent>

                <!-- Legal Navigation Box (Dynamic POLICIES & LEGAL Menu) -->
                <nav class="legal-nav-box" aria-label="Legal Navigation">
                    <div class="legal-nav-header">
                        <i class="bi bi-shield-lock"></i> {{ $menuTitle }}
                    </div>
                    <ul class="legal-menu-list">
                        @if ($menuItems->isNotEmpty())
                            @foreach ($menuItems as $mItem)
                                @php
                                    $itemSlug = '';
                                    $itemUrl = '#';
                                    $itemTitle = $mItem->name ?? '';

                                    if (is_object($mItem)) {
                                        if (isset($mItem->link_type) && $mItem->link_type === 'page' && $mItem->page) {
                                            $itemSlug = $mItem->page->slug;
                                            $itemUrl = route('page.show', $mItem->page->slug);
                                            if (empty($itemTitle)) {
                                                $itemTitle = $mItem->page->page_title;
                                            }
                                        } elseif (!empty($mItem->url) && $mItem->url !== '#') {
                                            $itemUrl = $mItem->url;
                                            $parsedPath = parse_url($mItem->url, PHP_URL_PATH) ?? '';
                                            $itemSlug = trim(str_replace(['/page/', '/pages/'], '', $parsedPath), '/');
                                        } elseif (!empty($mItem->page_id) && isset($mItem->page) && $mItem->page) {
                                            $itemSlug = $mItem->page->slug;
                                            $itemUrl = route('page.show', $itemSlug);
                                        } elseif (!empty($mItem->slug)) {
                                            $itemSlug = $mItem->slug;
                                            $itemUrl = route('page.show', $mItem->slug);
                                        }
                                    } elseif (is_array($mItem)) {
                                        $itemSlug = $mItem['slug'] ?? '';
                                        $itemTitle = $mItem['name'] ?? ($mItem['page_title'] ?? '');
                                        $itemUrl = !empty($mItem['slug'])
                                            ? route('page.show', $mItem['slug'])
                                            : $mItem['url'] ?? '#';
                                    }

                                    $isActive =
                                        $itemSlug === $currentSlug ||
                                        (!empty($mItem->page_id) && !empty($page->id) && $mItem->page_id == $page->id);
                                    $rawIcon = is_object($mItem) ? ($mItem->icon ?? null) : ($mItem['icon'] ?? null);
                                    $icon = !empty($rawIcon) ? $rawIcon : 'bi-file-earmark-text';
                                @endphp
                                <li>
                                    <a href="{{ $itemUrl }}"
                                        class="legal-menu-item {{ $isActive ? 'active' : '' }}">
                                        <i class="bi {{ $icon }} menu-icon"></i>
                                        <span>{{ $itemTitle }}</span>
                                        <i class="bi bi-chevron-right chevron"></i>
                                    </a>
                                </li>
                            @endforeach
                        @else
                            @foreach ($fallbackLegalItems as $item)
                                @php
                                    $isActive = $item['slug'] === $currentSlug;
                                    $icon = $item['icon'] ?? 'bi-file-earmark-text';
                                @endphp
                                <li>
                                    <a href="{{ route('page.show', $item['slug']) }}"
                                        class="legal-menu-item {{ $isActive ? 'active' : '' }}">
                                        <i class="bi {{ $icon }} menu-icon"></i>
                                        <span>{{ $item['page_title'] }}</span>
                                        <i class="bi bi-chevron-right chevron"></i>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </nav>

                <!-- Support & Assistance Card -->
                <div class="legal-support-card">
                    <div class="legal-support-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h5>Need help?</h5>
                    <p>Have questions regarding our policies, terms, or data privacy rights? Our compliance team is here
                        to assist.</p>
                    <a href="{{ route('contact') }}" class="legal-support-btn">
                        <i class="bi bi-envelope-fill"></i> Contact Us
                    </a>
                </div>

            </div>
        </aside>

        <!-- Right Column: Policy Accordion & CMS Content -->
        <div class="col-lg-9 col-xl-9">
            <article class="legal-content-card">

                <!-- Featured Image (if uploaded) -->
                @if (!empty($page->f_image))
                    <div class="mb-4 rounded-4 overflow-hidden position-relative shadow-sm"
                        style="max-height: 400px; background-color: #f1f5f9;">
                        <img src="{{ getImageUrl($page->f_image) }}" alt="{{ $page->page_title }}"
                            class="img-fluid w-100 h-100 object-fit-cover" width="1200" height="400"
                            decoding="async" fetchpriority="high">
                    </div>
                @endif

                <!-- In Summary Box -->
                @if (!empty($page->short_des))
                    <div class="legal-summary-box">
                        <h4><i class="bi bi-info-circle-fill text-primary"></i> In Summary</h4>
                        <p>{{ $page->short_des }}</p>
                    </div>
                @endif

                <!-- CMS Dynamic HTML Content -->
                @if (!empty($page->page_description) && trim(strip_tags($page->page_description)) !== '')
                    <div class="aire-page-prose mb-5">
                        {!! $page->page_description !!}
                    </div>
                @endif

                <!-- Footer / Share & Export Bar -->
                <hr class="my-5 border-secondary border-opacity-10">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                    @include('themes.default.partials.share_buttons', [
                        'shareUrl' => $canonicalUrl,
                        'shareTitle' => $page->page_title,
                        'shareLabel' => 'Share Policy:',
                    ])

                    <div class="text-muted fs-13">
                        <i class="bi bi-shield-lock me-1"></i> ISO 9001 &amp; GDPR Compliant Documentation
                    </div>
                </div>

            </article>
        </div>

    </div>
</main>
