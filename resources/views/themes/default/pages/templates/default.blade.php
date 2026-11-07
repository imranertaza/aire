@php
    $canonicalUrl = $canonicalUrl ?? route('page.show', $page->slug ?? 'page');
    $plainText = strip_tags($page->page_description ?? '');
    $wordCount = str_word_count($plainText);
    $readTimeMinutes = max(1, (int) ceil($wordCount / 200));
    $lastUpdatedIso = $page->updated_at ? $page->updated_at->toIso8601String() : now()->toIso8601String();
    $lastUpdatedFormatted = $page->updated_at ? $page->updated_at->format('F Y') : now()->format('F Y');
    $otherPages =
        isset($otherPages) && $otherPages->isNotEmpty()
            ? $otherPages
            : \App\Models\Page::where('status', 1)
                ->where('id', '!=', $page->id ?? 0)
                ->take(6)
                ->get();
@endphp

@include('themes.default.partials.page_schema', [
    'page' => $page,
    'canonicalUrl' => $canonicalUrl,
    'plainText' => $plainText,
    'lastUpdatedIso' => $lastUpdatedIso,
    'categoryName' => $page->breadcrumb ?? 'Information Page',
])

@pushOnce('styles')
    <link href="{{ theme_asset('css/legal.css') }}" rel="stylesheet">
@endpushOnce

<!-- =========================================================================
| Standard Editorial CMS Page Hero Banner
| ========================================================================= -->
<section class="legal-hero">
    <div class="container main-container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <div class="legal-hero-badge">
                    <i class="bi bi-file-earmark-richtext"></i>
                    <span>{{ !empty($page->breadcrumb) ? strtoupper($page->breadcrumb) . ' • AIRE' : 'EDITORIAL &bull; AIRE PUBLICATIONS' }}</span>
                </div>
                <h1 class="legal-hero-title">{{ $page->page_title }}</h1>
                <p class="legal-hero-lead">
                    @if (!empty($page->short_des))
                        {{ $page->short_des }}
                    @else
                        Discover comprehensive documentation, architectural overviews, and detailed resources by AIRE Industries.
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
                            class="text-white fw-bold fs-13">{{ $page->status ?? 1 ? 'Verified IAQ Content' : 'Draft / Inactive' }}</span>
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
            </div>
        </div>
    </div>
</section>

<!-- =========================================================================
| Main Content & Sidebar Layout
| ========================================================================= -->
<main class="container main-container legal-layout-wrap">
    <div class="row g-4 g-lg-5">

        <!-- Left Column: Page Body & Media -->
        <div class="col-lg-8 col-xl-8">
            <article class="legal-content-card">

                <!-- Featured Image (if uploaded) -->
                @if (!empty($page->f_image))
                    <div class="mb-4 rounded-4 overflow-hidden position-relative shadow-sm"
                        style="max-height: 420px; background-color: #f1f5f9;">
                        <img src="{{ getImageUrl($page->f_image) }}" alt="{{ $page->page_title }}"
                            class="img-fluid w-100 h-100 object-fit-cover" width="1200" height="420"
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
                @else
                    <div class="alert alert-light border rounded-3 p-4 text-center text-muted mb-5">
                        <i class="bi bi-info-circle fs-3 d-block mb-2 text-primary"></i>
                        <p class="mb-0">Page content is being updated by our editorial team. Please check back soon.</p>
                    </div>
                @endif

                <!-- Footer / Share & Export Bar -->
                <hr class="my-5 border-secondary border-opacity-10">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                    @include('themes.default.partials.share_buttons', [
                        'shareUrl' => $canonicalUrl,
                        'shareTitle' => $page->page_title,
                        'shareLabel' => 'Share Page:',
                    ])

                    <div class="text-muted fs-13">
                        <i class="bi bi-shield-check me-1"></i> Official AIRE Industries Publication
                    </div>
                </div>

            </article>
        </div>

        <!-- Right Column: Contextual Navigation & Support Widgets -->
        <aside class="col-lg-4 col-xl-4">
            <div class="legal-sidebar-sticky" data-lenis-prevent>

                @if (isset($otherPages) && $otherPages->isNotEmpty())
                    <!-- Related Pages Navigation Box -->
                    <nav class="legal-nav-box" aria-label="Related Pages Navigation">
                        <div class="legal-nav-header">
                            <i class="bi bi-collection"></i> Related Resources
                        </div>
                        <ul class="legal-menu-list">
                            @foreach ($otherPages as $item)
                                @php
                                    $isActive = $item->slug === ($page->slug ?? '');
                                @endphp
                                <li>
                                    <a href="{{ route('page.show', $item->slug) }}"
                                        class="legal-menu-item {{ $isActive ? 'active' : '' }}">
                                        <i class="bi bi-file-earmark-text menu-icon"></i>
                                        <span>{{ $item->page_title }}</span>
                                        <i class="bi bi-chevron-right chevron"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                @endif

                <!-- Direct Support Card -->
                <div class="legal-support-card mb-4">
                    <div class="legal-support-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h5>Need Expert Assistance?</h5>
                    <p>Have questions about clean room air purification, smart building HVAC integration, or custom installations?</p>
                    <a href="{{ route('contact') }}" class="legal-support-btn">
                        <i class="bi bi-envelope-fill"></i> Speak With a Specialist
                    </a>
                </div>

                <!-- AIRE Quality Promise Card -->
                <div class="card border border-light-subtle rounded-4 p-4 bg-white shadow-sm">
                    <h6 class="fw-bold text-dark fs-13 text-uppercase mb-3" style="letter-spacing: 0.8px;">The AIRE Quality Promise</h6>
                    <div class="d-flex flex-column gap-3 fs-13 text-secondary">
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-patch-check-fill text-success fs-5 mt-1"></i>
                            <div>
                                <strong class="d-block text-dark fw-semibold">Medical-Grade Standard</strong>
                                <span class="text-muted fs-12">99.97% particulate capture efficiency down to 0.1 microns.</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-shield-lock-fill text-primary fs-5 mt-1"></i>
                            <div>
                                <strong class="d-block text-dark fw-semibold">Verified IAQ Performance</strong>
                                <span class="text-muted fs-12">Certified lab tested and continuous sensor calibration.</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-award-fill text-warning fs-5 mt-1"></i>
                            <div>
                                <strong class="d-block text-dark fw-semibold">Full Manufacturer Coverage</strong>
                                <span class="text-muted fs-12">Complete warranty protection and direct engineering support.</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </aside>

    </div>
</main>
