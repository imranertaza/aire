@extends('themes.default.layouts.master')

@section('title', 'Aire | Contact Us')
@section('meta_description',
    'Get in touch with AIRE Industries — clean air engineering specialists, customer support,
    and commercial IAQ consultation.')

    @push('styles')
        <link href="{{ theme_asset('css/contact.css') }}" rel="stylesheet">
    @endpush

@section('content')
    <!-- =========================================================================
        | Atmospheric Hero Banner (Matching AIRE Theme)
        | ========================================================================= -->
    <section class="contact-hero">
        <div class="container main-container position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="contact-hero-badge">
                        <i class="bi bi-headset"></i>
                        <span>CLEANER AIR &bull; BRIGHTER SPACES &bull; DEDICATED SUPPORT</span>
                    </div>
                    <h1 class="contact-hero-title">Let's Start a Conversation</h1>
                    <p class="contact-hero-lead">
                        Have questions regarding our air purification systems, commercial cleanroom solutions, or warranty
                        support? Our air engineering specialists are ready to assist.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                        style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);">
                        <i class="bi bi-patch-check-fill text-info fs-5"></i>
                        <div class="text-start">
                            <small class="d-block text-white-50 fs-11 text-uppercase fw-bold"
                                style="letter-spacing: 0.5px;">Direct Response</small>
                            <span class="text-white fw-bold fs-13">24-Hour Reply Guaranteed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
        | Breadcrumbs & Quick Toolbar
        | ========================================================================= -->
    <section class="contact-toolbar-bar">
        <div class="container main-container">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb contact-breadcrumb align-items-center mb-0" style="--bs-breadcrumb-divider: '›';">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                <i class="bi bi-house-door me-1"></i> Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ol>
                </nav>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <a href="tel:{{ $settings['phone'] ?? '+8801700000000' }}"
                        class="text-secondary text-decoration-none fs-13 d-flex align-items-center gap-1">
                        <i class="bi bi-telephone-outbound text-primary"></i>
                        <span>{{ $settings['phone'] ?? '+880 1700-000000' }}</span>
                    </a>
                    <span class="text-muted d-none d-sm-inline">|</span>
                    <a href="mailto:{{ $settings['email'] ?? 'info@aire.test' }}"
                        class="text-secondary text-decoration-none fs-13 d-flex align-items-center gap-1">
                        <i class="bi bi-envelope-at text-primary"></i>
                        <span>{{ $settings['email'] ?? 'info@aire.test' }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
        | Main Content: Contact Details & Interactive Inquiry Form
        | ========================================================================= -->
    <main class="container main-container py-5">
        <div class="row g-4 g-lg-5 align-items-stretch">

            <!-- Left Column: Information & Topic Cards -->
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-4 h-100 justify-content-between">

                    <!-- Primary Info Card -->
                    <div class="contact-info-card">
                        <div class="mb-4">
                            <span class="contact-badge-pill mb-2">
                                <i class="bi bi-geo-alt-fill me-1"></i> Get In Touch
                            </span>
                            <h3 class="fw-bold text-white mb-2 fs-22">Direct Channels</h3>
                            <p class="text-white-50 fs-13 mb-0">Reach our global headquarters or local support desks
                                directly.</p>
                        </div>

                        <div class="contact-item-row">
                            <div class="contact-icon-circle">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <span class="contact-item-label">Global Headquarters</span>
                                <div class="contact-item-val">{{ $settings['address'] ?? 'Aire HQ, Dhaka, Bangladesh' }}
                                </div>
                            </div>
                        </div>

                        <div class="contact-item-row">
                            <div class="contact-icon-circle">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div>
                                <span class="contact-item-label">Telephone Support</span>
                                <a href="tel:{{ $settings['phone'] ?? '+8801700000000' }}" class="contact-item-val">
                                    {{ $settings['phone'] ?? '+880 1700-000000' }}
                                </a>
                            </div>
                        </div>

                        <div class="contact-item-row">
                            <div class="contact-icon-circle">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <span class="contact-item-label">Email Inquiries</span>
                                <a href="mailto:{{ $settings['email'] ?? 'info@aire.test' }}" class="contact-item-val">
                                    {{ $settings['email'] ?? 'info@aire.test' }}
                                </a>
                            </div>
                        </div>

                        <div class="contact-item-row mb-4">
                            <div class="contact-icon-circle">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div>
                                <span class="contact-item-label">Operating Hours</span>
                                <div class="contact-item-val fs-13">Mon &ndash; Sat: 9:00 AM &ndash; 7:00 PM (GMT+6)</div>
                            </div>
                        </div>

                        <!-- Social Channels -->
                        <div class="pt-4 border-top border-white border-opacity-15">
                            <span class="d-block text-white-50 fs-12 text-uppercase fw-bold mb-3"
                                style="letter-spacing: 0.8px;">Follow Our Community</span>
                            <div class="d-flex gap-2">
                                @if (!empty($settings['fb_url']))
                                    <a href="{{ $settings['fb_url'] }}" target="_blank" rel="noopener noreferrer"
                                        class="contact-social-btn" title="Facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                @endif
                                @if (!empty($settings['twitter_url']))
                                    <a href="{{ $settings['twitter_url'] }}" target="_blank" rel="noopener noreferrer"
                                        class="contact-social-btn" title="X (Twitter)">
                                        <i class="bi bi-twitter-x"></i>
                                    </a>
                                @endif
                                @if (!empty($settings['instagram_url']))
                                    <a href="{{ $settings['instagram_url'] }}" target="_blank" rel="noopener noreferrer"
                                        class="contact-social-btn" title="Instagram">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                @endif
                                @if (!empty($settings['linkedin_url']))
                                    <a href="{{ $settings['linkedin_url'] }}" target="_blank" rel="noopener noreferrer"
                                        class="contact-social-btn" title="LinkedIn">
                                        <i class="bi bi-linkedin"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick Help Topic Boxes -->
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="contact-topic-box">
                                <div class="contact-topic-icon">
                                    <i class="bi bi-building-gear"></i>
                                </div>
                                <h5 class="fs-14 fw-bold text-dark mb-1">Commercial IAQ</h5>
                                <p class="fs-12 text-muted mb-0">Custom facility audits and cleanroom airflow engineering.
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="contact-topic-box">
                                <div class="contact-topic-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <h5 class="fs-14 fw-bold text-dark mb-1">Warranty &amp; Service</h5>
                                <p class="fs-12 text-muted mb-0">Original replacement filters and registered hardware
                                    claims.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Column: Message Form -->
            <div class="col-lg-7">
                <div class="contact-form-card h-100">
                    <h3 class="contact-form-title">Send Us a Message</h3>
                    <p class="contact-form-subtitle">Fill out the inquiry form below and our air specialists will reply
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

                    @if ($errors->any())
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
                                <div class="contact-field-group">
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
                                <div class="contact-field-group">
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
                                <div class="contact-field-group">
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
                                <div class="contact-field-group">
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

                            <!-- Message -->
                            <div class="col-12">
                                <div class="contact-field-group">
                                    <label for="message" class="contact-field-label">Your Message <span
                                            class="text-danger">*</span></label>
                                    <div class="contact-input-wrap">
                                        <textarea class="contact-form-control @error('message') is-invalid @enderror" id="message" name="message"
                                            rows="5" placeholder="How can our clean air team help you?" required>{{ old('message') }}</textarea>
                                        <i class="bi bi-pencil-square contact-input-icon"></i>
                                    </div>
                                    @error('message')
                                        <div class="invalid-feedback d-block fs-12">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" name="g-recaptcha-response" id="contactRecaptchaResponse">

                            <!-- Submit Button -->
                            <div class="col-12 mt-3">
                                <button type="submit" id="btnContactSubmit" class="contact-submit-btn w-100 w-sm-auto">
                                    <i class="bi bi-send-fill"></i>
                                    <span>Send Message</span>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

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
