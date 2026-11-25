@php
    $currentSlug = $page->slug ?? '';
    $canonicalUrl = $canonicalUrl ?? route('page.show', $page->slug ?? 'page');
    $plainText = strip_tags($page->page_description ?? '');
    $wordCount = str_word_count($plainText);
    $readTimeMinutes = max(1, (int) ceil($wordCount / 200));
    $lastUpdatedIso =
        !empty($page->updated_at) && is_object($page->updated_at)
            ? $page->updated_at->toIso8601String()
            : now()->toIso8601String();
    $lastUpdatedFormatted =
        !empty($page->updated_at) && is_object($page->updated_at)
            ? $page->updated_at->format('F Y')
            : now()->format('F Y');

    // Extract menu items from $sidebarMenu or $legalPages
    $menuItems = collect();
    $menuTitle = 'GET IN TOUCH';

    $targetMenu = $sidebarMenu ?? ($legalPages ?? null);
    if (!$targetMenu) {
        $targetMenu = \Illuminate\Support\Facades\Cache::remember('default_contact_menu_v1', 86400, function () {
            return \App\Models\Menu::query()
                ->where(function ($q) {
                    $q->where('name', 'LIKE', '%GET IN TOUCH%')->orWhere('name', 'LIKE', '%CONTACT%');
                })
                ->where('enabled', 1)
                ->with([
                    'menus' => function ($q) {
                        $q->where('enabled', 1)
                            ->whereNull('parent_id')
                            ->with('page')
                            ->orderBy('order', 'asc')
                            ->orderBy('id', 'asc');
                    },
                ])
                ->first();
        });
    }

    if ($targetMenu) {
        if ($targetMenu instanceof \App\Models\Menu) {
            $menuItems = $targetMenu->menus ?? collect();
            $menuTitle = $targetMenu->name ?: 'GET IN TOUCH';
        } elseif ($targetMenu instanceof \Illuminate\Support\Collection || is_array($targetMenu)) {
            $menuItems = collect($targetMenu);
        }

        if ($menuItems instanceof \Illuminate\Support\Collection && $menuItems->isNotEmpty()) {
            $menuItems = $menuItems->sortBy([['order', 'asc'], ['id', 'asc']])->values();
        }
    }

    $settings = array_merge(\App\Models\Setting::allCached() ?? [], $settings ?? []);
@endphp

@include('themes.default.partials.page_schema', [
    'page' => $page,
    'canonicalUrl' => $canonicalUrl,
    'plainText' => $plainText,
    'lastUpdatedIso' => $lastUpdatedIso,
    'categoryName' => $page->breadcrumb ?? 'Contact Us',
])

@pushOnce('styles')
    <link href="{{ theme_asset('css/contact.css') }}" rel="stylesheet">
    <link href="{{ theme_asset('css/legal.css') }}" rel="stylesheet">
    <style>
        .contact-template-wrap {
            background-color: #f8fafc;
            min-height: 100vh;
        }

        .contact-form-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 38px 40px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        }

        .contact-form-title {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .contact-direct-card {
            background: linear-gradient(145deg, #07131d 0%, #0a1e2b 60%, #0d283c 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 34px 36px;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
        }

        .contact-direct-card::after {
            content: '';
            position: absolute;
            bottom: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 149, 218, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .contact-topic-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.02);
            transition: all 0.25s ease;
            height: 100%;
        }

        .contact-topic-box:hover {
            border-color: #0095da;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 149, 218, 0.08);
        }

        .contact-topic-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #eff6ff;
            color: #0095da;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            margin-bottom: 14px;
        }

        .legal-support-card {
            background: linear-gradient(135deg, #07131d 0%, #0a1e2b 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 28px 24px;
            color: #ffffff;
            box-shadow: 0 4px 16px rgba(10, 31, 45, 0.18);
        }

        .legal-support-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(0, 149, 218, 0.2);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: #38bdf8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 16px;
        }

        .legal-support-card h5 {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .legal-support-card p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .legal-nav-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
            margin-bottom: 1.5rem;
        }

        .legal-nav-header {
            padding: 16px 20px;
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.8px;
            color: #334155;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .legal-menu-list {
            list-style: none;
            padding: 6px 0;
            margin: 0;
        }

        .legal-menu-item {
            display: flex;
            align-items: center;
            padding: 11px 20px;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
        }

        .legal-menu-item:hover {
            background: #f8fafc;
            color: #0095da;
        }

        .legal-menu-item.active {
            background: rgba(0, 149, 218, 0.08);
            color: #0095da;
            font-weight: 700;
        }

        .legal-menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #0095da;
            border-radius: 0 4px 4px 0;
        }

        .legal-menu-item .menu-icon {
            font-size: 16px;
            margin-right: 12px;
            color: #94a3b8;
            width: 20px;
            text-align: center;
            transition: color 0.2s ease;
        }

        .legal-menu-item.active .menu-icon,
        .legal-menu-item:hover .menu-icon {
            color: #0095da;
        }

        .legal-menu-item .chevron {
            margin-left: auto;
            font-size: 12px;
            color: #cbd5e1;
        }

        .legal-menu-item.active .chevron,
        .legal-menu-item:hover .chevron {
            color: #0095da;
        }
    </style>
@endpushOnce

<!-- =========================================================================
| Legal / Policy Atmospheric Hero Banner (Matching legal.blade.php)
| ========================================================================= -->
<section class="legal-hero">
    <div class="container main-container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <div class="legal-hero-badge">
                    <i class="bi bi-shield-check"></i>
                    <span>{{ !empty($page->breadcrumb) ? strtoupper($page->breadcrumb) . ' • AIRE' : 'CLEANER AIR • BRIGHTER SPACES • A HEALTHIER TOMORROW' }}</span>
                </div>
                <h1 class="legal-hero-title">{{ $page->page_title }}</h1>
                <p class="legal-hero-lead">
                    @if (!empty($page->short_des))
                        {{ $page->short_des }}
                    @else
                        Have questions regarding our air purification systems, commercial cleanroom solutions, or
                        warranty support? Our air engineering specialists are ready to assist.
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
| Breadcrumbs & Action Toolbar Strip (Matching legal.blade.php)
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
                            <span class="text-muted">Contact</span>
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
| Main Content: Contact Page Layout (Matching Provided Design Mockup)
| ========================================================================= -->
<section class="contact-template-wrap py-5">
    <div class="container main-container">
        <div class="row g-4 g-lg-5 align-items-start">

            <!-- =========================================================
            | Left Column: Navigation Menu & Need Help Card
            | ========================================================= -->
            <aside class="col-lg-3 col-xl-3">
                <div class="legal-sidebar-sticky" data-lenis-prevent>

                    <!-- Navigation Box (GET IN TOUCH) -->
                    @if ($menuItems->isNotEmpty())
                        <nav class="legal-nav-box" aria-label="Contact Navigation">
                            <div class="legal-nav-header">
                                <i class="bi bi-shield-check text-primary"></i>
                                <span>{{ $menuTitle }}</span>
                            </div>
                            <ul class="legal-menu-list">
                                @foreach ($menuItems as $mItem)
                                    @php
                                        $itemSlug = '';
                                        $itemUrl = '#';
                                        $itemTitle = $mItem->name ?? '';

                                        if (is_object($mItem)) {
                                            if (
                                                isset($mItem->link_type) &&
                                                $mItem->link_type === 'page' &&
                                                $mItem->page
                                            ) {
                                                $itemSlug = $mItem->page->slug ?? '';
                                                $itemUrl = !empty($itemSlug) ? route('page.show', $itemSlug) : '#';
                                                if (empty($itemTitle)) {
                                                    $itemTitle = $mItem->page->page_title ?? '';
                                                }
                                            } elseif (!empty($mItem->url) && $mItem->url !== '#') {
                                                $itemUrl = $mItem->url;
                                                $parsedPath = parse_url($mItem->url, PHP_URL_PATH) ?? '';
                                                $itemSlug = trim(
                                                    str_replace(['/page/', '/pages/'], '', $parsedPath),
                                                    '/',
                                                );
                                            } elseif (!empty($mItem->page_id) && isset($mItem->page) && $mItem->page) {
                                                $itemSlug = $mItem->page->slug ?? '';
                                                $itemUrl = !empty($itemSlug) ? route('page.show', $itemSlug) : '#';
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
                                            (!empty($itemSlug) && $itemSlug === $currentSlug) ||
                                            (!empty($mItem->page_id) &&
                                                !empty($page->id) &&
                                                $mItem->page_id == $page->id);
                                        $rawIcon = is_object($mItem) ? $mItem->icon ?? null : $mItem['icon'] ?? null;
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
                            </ul>
                        </nav>
                    @endif

                    <!-- Need Help? Card (Dark Card matching screenshot) -->
                    <div class="legal-support-card">
                        <div class="legal-support-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h5>Need help?</h5>
                        <p>Have questions regarding our air purification devices, installation, or warranty claims? Our
                            compliance team is here to assist.</p>
                        <a href="{{ route('contact') }}"
                            class="btn btn-light w-100 rounded-pill fw-bold text-dark fs-13 py-2 d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
                            <i class="bi bi-envelope"></i>
                            <span>Contact Us</span>
                        </a>
                    </div>

                </div>
            </aside>

            <!-- =========================================================
            | Right Column: Form, Direct Channels, Topics & Footer
            | ========================================================= -->
            <div class="col-lg-9 col-xl-9">

                <!-- 1. Send Us a Message Card -->
                <div class="contact-form-card mb-4">
                    <h2 class="contact-form-title mb-1">Send Us a Message</h2>
                    <p class="text-muted fs-14 mb-4">Fill out the inquiry form below and our air specialists will reply
                        within 24 hours.</p>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4" role="alert">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                <span class="fs-14 fw-medium">{{ session('success') }}</span>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (isset($errors) && $errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 p-3 mb-4" role="alert">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                                <span class="fs-14 fw-medium">Please review the highlighted fields below.</span>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <form id="contactForm" method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="row g-3">

                            <!-- Full Name -->
                            <div class="col-md-6">
                                <div class="contact-field-group mb-0">
                                    <label for="name" class="contact-field-label">Full Name <span
                                            class="text-danger">*</span></label>
                                    <div class="contact-input-wrap">
                                        <input type="text"
                                            class="contact-form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}"
                                            placeholder="e.g. John Doe" required>
                                        <i class="bi bi-person contact-input-icon"></i>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="col-md-6">
                                <div class="contact-field-group mb-0">
                                    <label for="email" class="contact-field-label">Email Address <span
                                            class="text-danger">*</span></label>
                                    <div class="contact-input-wrap">
                                        <input type="email"
                                            class="contact-form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}"
                                            placeholder="john@example.com" required>
                                        <i class="bi bi-envelope contact-input-icon"></i>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6">
                                <div class="contact-field-group mb-0">
                                    <label for="phone" class="contact-field-label">Phone Number</label>
                                    <div class="contact-input-wrap">
                                        <input type="tel"
                                            class="contact-form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone') }}"
                                            placeholder="+880 1700-000000">
                                        <i class="bi bi-telephone contact-input-icon"></i>
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback d-block fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Subject -->
                            <div class="col-md-6">
                                <div class="contact-field-group mb-0">
                                    <label for="subject" class="contact-field-label">Subject</label>
                                    <div class="contact-input-wrap">
                                        <input type="text"
                                            class="contact-form-control @error('subject') is-invalid @enderror"
                                            id="subject" name="subject" value="{{ old('subject') }}"
                                            placeholder="e.g. Product Inquiry / Consultation">
                                        <i class="bi bi-chat-left-text contact-input-icon"></i>
                                    </div>
                                    @error('subject')
                                        <div class="invalid-feedback d-block fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Your Message -->
                            <div class="col-12">
                                <div class="contact-field-group mb-0">
                                    <label for="message" class="contact-field-label">Your Message <span
                                            class="text-danger">*</span></label>
                                    <div class="contact-input-wrap">
                                        <textarea class="contact-form-control @error('message') is-invalid @enderror" id="message" name="message"
                                            rows="4" placeholder="How can our clean air team help you?" required>{{ old('message') }}</textarea>
                                        <i class="bi bi-pencil-square contact-input-icon"></i>
                                    </div>
                                    @error('message')
                                        <div class="invalid-feedback d-block fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Honeypot -->
                            <input type="text" name="b_extra_field" style="display:none !important;"
                                tabindex="-1" autocomplete="off">
                            <input type="hidden" name="g-recaptcha-response" id="contactRecaptchaResponse">

                            <!-- Submit Button (Full Width Pill Button matching screenshot) -->
                            <div class="col-12 mt-3">
                                <button type="submit" id="btnContactSubmit"
                                    class="contact-submit-btn w-100 py-3 rounded-pill fs-15 fw-bold">
                                    <i class="bi bi-send-fill me-2"></i>
                                    <span>Send Message</span>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- 2. Direct Channels (Dark Navy Card matching screenshot) -->
                <div class="contact-direct-card mb-4">
                    <!-- Top Row -->
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 pb-4 border-bottom border-white border-opacity-15 mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="contact-badge-pill">
                                <i class="bi bi-geo-alt-fill"></i> GET IN TOUCH
                            </span>
                            <span class="fs-18 fw-bold text-white ms-2">Direct Channels</span>
                        </div>
                        <div class="text-white-50 fs-13">
                            Reach our global headquarters or regional support desks directly.
                        </div>
                    </div>

                    <!-- 2x2 Grid Information -->
                    <div class="row g-4 mb-4">
                        <!-- Global Headquarters -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="contact-icon-circle">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div>
                                    <span class="contact-item-label">GLOBAL HEADQUARTERS</span>
                                    <div class="contact-item-val fs-13 text-white">
                                        {{ $settings['address'] ?? 'Innovation Drive, Suite 100 Silicon Valley, CA 94025' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Telephone Support -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="contact-icon-circle">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div>
                                    <span class="contact-item-label">TELEPHONE SUPPORT</span>
                                    <a href="tel:{{ $settings['phone'] ?? '+88080000000' }}"
                                        class="contact-item-val fs-14 text-white">
                                        {{ $settings['phone'] ?? '+880 80000000' }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Email Inquiries -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="contact-icon-circle">
                                    <i class="bi bi-envelope-fill"></i>
                                </div>
                                <div>
                                    <span class="contact-item-label">EMAIL INQUIRIES</span>
                                    <a href="mailto:{{ $settings['email'] ?? 'info@aireindustries.com' }}"
                                        class="contact-item-val fs-14 text-white">
                                        {{ $settings['email'] ?? 'info@aireindustries.com' }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Operating Hours -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="contact-icon-circle">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div>
                                    <span class="contact-item-label">OPERATING HOURS</span>
                                    <div class="contact-item-val fs-13 text-white">
                                        Mon &ndash; Sat: 9:00 AM &ndash; 7:00 PM (GMT+6)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Social Links -->
                    <div
                        class="pt-3 border-top border-white border-opacity-15 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                        <span class="text-white-50 fs-11 text-uppercase fw-bold" style="letter-spacing: 0.8px;">
                            FOLLOW OUR COMMUNITY
                        </span>
                        <div class="d-flex gap-2">
                            <a href="{{ $settings['fb_url'] ?? '#' }}" target="_blank" rel="noopener noreferrer"
                                class="contact-social-btn" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="{{ $settings['twitter_url'] ?? '#' }}" target="_blank"
                                rel="noopener noreferrer" class="contact-social-btn" title="X (Twitter)">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="{{ $settings['instagram_url'] ?? '#' }}" target="_blank"
                                rel="noopener noreferrer" class="contact-social-btn" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="{{ $settings['linkedin_url'] ?? '#' }}" target="_blank"
                                rel="noopener noreferrer" class="contact-social-btn" title="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3. Two Topic Cards (Commercial IAQ & Warranty Service side by side) -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="contact-topic-box">
                            <div class="contact-topic-icon">
                                <i class="bi bi-building-gear"></i>
                            </div>
                            <h4 class="fs-16 fw-bold text-dark mb-2">Commercial IAQ</h4>
                            <p class="fs-13 text-muted mb-0">Custom facility audits and certified cleanroom airflow
                                engineering for industrial spaces.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-topic-box">
                            <div class="contact-topic-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h4 class="fs-16 fw-bold text-dark mb-2">Warranty &amp; Service</h4>
                            <p class="fs-13 text-muted mb-0">Original replacement filters, sensor calibrations, and
                                registered hardware warranty claims.</p>
                        </div>
                    </div>
                </div>

                <!-- 4. Footer Bar: Share Policy & ISO Compliance Badge -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center pt-3 gap-3">
                    @include('themes.default.partials.share_buttons', [
                        'shareUrl' => $canonicalUrl,
                        'shareTitle' => $page->page_title,
                        'shareLabel' => 'Share Policy:',
                    ])

                    <div class="text-muted fs-13 d-flex align-items-center gap-1">
                        <i class="bi bi-shield-check text-primary"></i>
                        <span>ISO 9001 &amp; GDPR Compliant Documentation</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

@pushOnce('scripts')
    <script src="{{ theme_asset('js/legal.js') }}"></script>
@endpushOnce

@push('scripts')
    @if (config('services.use_recaptcha') && config('services.sitekey'))
        <style>
            .grecaptcha-badge {
                visibility: hidden !important;
            }
        </style>
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.sitekey') }}" async defer></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('contactForm');
                if (!form) return;

                form.addEventListener('submit', function(e) {
                    const siteKey = "{{ config('services.sitekey') }}";
                    const recaptchaInput = document.getElementById('contactRecaptchaResponse');

                    if (typeof grecaptcha !== 'undefined' && siteKey && recaptchaInput && !recaptchaInput
                        .value) {
                        e.preventDefault();
                        const submitBtn = document.getElementById('btnContactSubmit');
                        if (submitBtn) submitBtn.disabled = true;

                        grecaptcha.ready(function() {
                            grecaptcha.execute(siteKey, {
                                action: 'contact_submit'
                            }).then(function(token) {
                                recaptchaInput.value = token;
                                form.submit();
                            }).catch(function(err) {
                                console.warn('reCAPTCHA error:', err);
                                form.submit();
                            });
                        });
                    }
                });
            });
        </script>
    @endif
@endpush
