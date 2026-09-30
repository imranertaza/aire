@extends('themes.default.layouts.master')

@section('title', 'Aire | Contact Us')
@section('meta_description', 'Get in touch with Aire — expert indoor air quality solutions, customer support, and project consultation.')

@section('content')
<main class="container main-container py-5">
    <div class="row g-4 align-items-stretch">
        <!-- Contact Information & Details -->
        <div class="col-lg-5">
            <div class="h-100 p-4 p-md-5 rounded-4" style="background: linear-gradient(135deg, #0f2b27 0%, #00786E 100%); color: #ffffff;">
                <span class="badge bg-white bg-opacity-20 text-white px-3 py-2 rounded-pill mb-3 fw-medium">
                    <i class="bi bi-geo-alt-fill me-1"></i> Get In Touch
                </span>
                <h2 class="display-6 fw-bold mb-3">Let's start a conversation</h2>
                <p class="text-white-50 mb-5">
                    Have questions regarding our air purification systems, commercial solutions, or warranty support? Our air engineering specialists are ready to assist.
                </p>

                <div class="d-flex flex-column gap-4">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-white bg-opacity-10" style="width: 48px; height: 48px; min-width: 48px;">
                            <i class="bi bi-geo-alt fs-5 text-white"></i>
                        </div>
                        <div>
                            <small class="text-white-50 d-block text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Location</small>
                            <span class="fs-6">{{ $settings['address'] ?? 'Aire HQ, Dhaka, Bangladesh' }}</span>
                        </div>
                    </div>

                    <div class="d-flex gap-3 align-items-center">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-white bg-opacity-10" style="width: 48px; height: 48px; min-width: 48px;">
                            <i class="bi bi-telephone fs-5 text-white"></i>
                        </div>
                        <div>
                            <small class="text-white-50 d-block text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Phone Support</small>
                            <a href="tel:{{ $settings['phone'] ?? '+8801700000000' }}" class="text-white text-decoration-none fs-6">
                                {{ $settings['phone'] ?? '+880 1700-000000' }}
                            </a>
                        </div>
                    </div>

                    <div class="d-flex gap-3 align-items-center">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-white bg-opacity-10" style="width: 48px; height: 48px; min-width: 48px;">
                            <i class="bi bi-envelope fs-5 text-white"></i>
                        </div>
                        <div>
                            <small class="text-white-50 d-block text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Email Inquiries</small>
                            <a href="mailto:{{ $settings['email'] ?? 'info@aire.test' }}" class="text-white text-decoration-none fs-6">
                                {{ $settings['email'] ?? 'info@aire.test' }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="pt-5 mt-4 border-top border-white border-opacity-10">
                    <small class="text-white-50 d-block mb-3 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Follow Us</small>
                    <div class="d-flex gap-2">
                        @if(!empty($settings['fb_url']))
                            <a href="{{ $settings['fb_url'] }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-facebook"></i></a>
                        @endif
                        @if(!empty($settings['twitter_url']))
                            <a href="{{ $settings['twitter_url'] }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-twitter-x"></i></a>
                        @endif
                        @if(!empty($settings['instagram_url']))
                            <a href="{{ $settings['instagram_url'] }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-instagram"></i></a>
                        @endif
                        @if(!empty($settings['linkedin_url']))
                            <a href="{{ $settings['linkedin_url'] }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-linkedin"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="h-100 p-4 p-md-5 bg-white rounded-4 border shadow-sm d-flex flex-column justify-content-between">
                <div>
                    <h3 class="fw-bold mb-2 text-dark">Send Us a Message</h3>
                    <p class="text-muted mb-4">Fill out the form below and our team will get back to you within 24 hours.</p>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form id="contactForm" method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label small fw-semibold text-secondary">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg fs-6 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label small fw-semibold text-secondary">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-lg fs-6 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label small fw-semibold text-secondary">Phone Number</label>
                                <input type="tel" class="form-control form-control-lg fs-6 @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+880 1700-000000">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="subject" class="form-label small fw-semibold text-secondary">Subject</label>
                                <input type="text" class="form-control form-control-lg fs-6 @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" placeholder="Inquiry about Product">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="message" class="form-label small fw-semibold text-secondary">Your Message <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-lg fs-6 @error('message') is-invalid @enderror" id="message" name="message" rows="5" placeholder="How can we help you?" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" name="g-recaptcha-response" id="contactRecaptchaResponse">

                            <div class="col-12 mt-4">
                                <button type="submit" id="btnContactSubmit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-semibold shadow-sm w-100 w-md-auto" style="background-color: #00786E; border-color: #00786E;">
                                    <i class="bi bi-send-fill me-2"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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

                if (typeof grecaptcha !== 'undefined' && siteKey && recaptchaInput && !recaptchaInput.value) {
                    e.preventDefault();
                    const submitBtn = document.getElementById('btnContactSubmit');
                    if (submitBtn) submitBtn.disabled = true;

                    grecaptcha.ready(function() {
                        grecaptcha.execute(siteKey, { action: 'contact_submit' }).then(function(token) {
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
