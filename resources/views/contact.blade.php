@extends('layouts.master')

@section('title', $page->page_title)
@section('breadcrumb', $page->breadcrumb)
@section('meta_description', $page->meta_description)
@section('meta_keywords', $page->meta_keywords)
@section('meta_title', $page->meta_title)
@section('content')
    <!-- contact section start -->
    <section class="container py-100 contact-query-section">
        <div class="row g-md-5 align-items-start flex-column-reverse flex-lg-row">

            <!-- Contact Info -->
            <div class="col-lg-6">
                <h5 class="title-two mb-4 fade-in-observer">Address & Contact No</h5>

                <div class="contact-info-item d-flex gap-3 align-items-start mb-md-4">
                    <span class="floating">
                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" fill="white" />
                            <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="#00786E" />
                            <path
                                d="M18.9999 18.6048C18.475 18.6048 17.9716 18.3963 17.6004 18.0251C17.2293 17.654 17.0208 17.1506 17.0208 16.6257C17.0208 16.1007 17.2293 15.5973 17.6004 15.2262C17.9716 14.855 18.475 14.6465 18.9999 14.6465C19.5248 14.6465 20.0282 14.855 20.3994 15.2262C20.7706 15.5973 20.9791 16.1007 20.9791 16.6257C20.9791 16.8856 20.9279 17.1429 20.8284 17.383C20.729 17.6232 20.5832 17.8414 20.3994 18.0251C20.2156 18.2089 19.9974 18.3547 19.7573 18.4542C19.5172 18.5536 19.2598 18.6048 18.9999 18.6048ZM18.9999 11.084C17.5302 11.084 16.1206 11.6678 15.0814 12.7071C14.0421 13.7464 13.4583 15.1559 13.4583 16.6257C13.4583 20.7819 18.9999 26.9173 18.9999 26.9173C18.9999 26.9173 24.5416 20.7819 24.5416 16.6257C24.5416 15.1559 23.9577 13.7464 22.9185 12.7071C21.8792 11.6678 20.4697 11.084 18.9999 11.084Z"
                                fill="#00786E" />
                        </svg>
                    </span>
                    <p class="content-text mb-0">{{ $settings['address'] }}</p>
                </div>

                <div class="contact-info-item d-flex gap-3 align-items-center mb-md-4">
                    <span class="floating">
                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" fill="white" />
                            <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="#00786E" />
                            <path
                                d="M14.7408 18.0421C15.8808 20.2825 17.7175 22.1112 19.9579 23.2592L21.6996 21.5175C21.9133 21.3038 22.23 21.2325 22.5071 21.3275C23.3938 21.6204 24.3517 21.7788 25.3333 21.7788C25.7688 21.7788 26.125 22.135 26.125 22.5704V25.3333C26.125 25.7688 25.7688 26.125 25.3333 26.125C17.8996 26.125 11.875 20.1004 11.875 12.6667C11.875 12.2312 12.2312 11.875 12.6667 11.875H15.4375C15.8729 11.875 16.2292 12.2312 16.2292 12.6667C16.2292 13.6562 16.3875 14.6063 16.6804 15.4929C16.7675 15.77 16.7042 16.0788 16.4825 16.3004L14.7408 18.0421Z"
                                fill="#00786E" />
                        </svg>
                    </span>
                    <a href="tel:{{ $settings['phone'] }}" class="content-text mb-0">
                        {{ $settings['phone'] }} </a>
                </div>

                <div class="contact-info-item d-flex gap-3 align-items-center mb-md-4">
                    <span class="floating">
                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" fill="white" />
                            <rect x="0.5" y="0.5" width="37" height="37" rx="18.5" stroke="#00786E" />
                            <path
                                d="M25.3333 12.666H12.6666C11.7958 12.666 11.0912 13.3785 11.0912 14.2493L11.0833 23.7493C11.0833 24.6202 11.7958 25.3327 12.6666 25.3327H25.3333C26.2041 25.3327 26.9166 24.6202 26.9166 23.7493V14.2493C26.9166 13.3785 26.2041 12.666 25.3333 12.666ZM25.3333 15.8327L18.9999 19.791L12.6666 15.8327V14.2493L18.9999 18.2077L25.3333 14.2493V15.8327Z"
                                fill="#00786E" />
                        </svg>
                    </span>
                    <a href="mailto:{{ $settings['email'] }}" class="content-text mb-0">
                        {{ $settings['email'] }}
                    </a>
                </div>

                <div class="social-section pt-5 pb-md-0 pb-5">
                    <h6 class="title-two mb-4 fade-in-observer">Social Media</h6>
                    <div class="d-flex gap-3">
                        <a href="{{ $settings['fb_url'] }}" aria-label="Facebook" target="_blank" class="social-icon">
                            <svg width="31" height="30" viewBox="0 0 31 30" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.7361 16L19.1808 13.1044H16.4004V11.2253C16.4004 10.4331 16.7888 9.66094 18.0341 9.66094H19.2981V7.19563C19.2981 7.19563 18.151 7 17.0543 7C14.7646 7 13.268 8.38688 13.268 10.8975V13.1044H10.7228V16H13.268V23H16.4004V16H18.7361Z"
                                    fill="#00786E" />
                            </svg>
                        </a>
                        <a href="{{ $settings['twitter_url'] }}" aria-label="Twitter" target="_blank" class="social-icon">
                            <svg width="31" height="30" viewBox="0 0 31 30" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.0135 11.4059C13.0246 11.4059 11.4204 13.009 11.4204 14.9965C11.4204 16.984 13.0246 18.5871 15.0135 18.5871C17.0023 18.5871 18.6066 16.984 18.6066 14.9965C18.6066 13.009 17.0023 11.4059 15.0135 11.4059ZM15.0135 17.3309C13.7282 17.3309 12.6775 16.284 12.6775 14.9965C12.6775 13.709 13.7251 12.6621 15.0135 12.6621C16.3019 12.6621 17.3495 13.709 17.3495 14.9965C17.3495 16.284 16.2987 17.3309 15.0135 17.3309ZM19.5916 11.259C19.5916 11.7246 19.2164 12.0965 18.7535 12.0965C18.2876 12.0965 17.9155 11.7215 17.9155 11.259C17.9155 10.7965 18.2907 10.4215 18.7535 10.4215C19.2164 10.4215 19.5916 10.7965 19.5916 11.259ZM21.9714 12.109C21.9182 10.9871 21.6618 9.99336 20.8394 9.17461C20.02 8.35586 19.0256 8.09961 17.903 8.04336C16.7459 7.97773 13.2779 7.97773 12.1209 8.04336C11.0013 8.09648 10.0069 8.35273 9.18446 9.17148C8.36201 9.99023 8.10872 10.984 8.05243 12.1059C7.98676 13.2621 7.98676 16.7277 8.05243 17.884C8.10559 19.0059 8.36201 19.9996 9.18446 20.8184C10.0069 21.6371 10.9982 21.8934 12.1209 21.9496C13.2779 22.0152 16.7459 22.0152 17.903 21.9496C19.0256 21.8965 20.02 21.6402 20.8394 20.8184C21.6587 19.9996 21.9151 19.0059 21.9714 17.884C22.0371 16.7277 22.0371 13.2652 21.9714 12.109ZM20.4766 19.1246C20.2327 19.7371 19.7605 20.209 19.1444 20.4559C18.2219 20.8215 16.0329 20.7371 15.0135 20.7371C13.994 20.7371 11.8019 20.8184 10.8825 20.4559C10.2696 20.2121 9.79738 19.7402 9.55033 19.1246C9.18446 18.2027 9.26889 16.0152 9.26889 14.9965C9.26889 13.9777 9.18758 11.7871 9.55033 10.8684C9.79425 10.2559 10.2665 9.78398 10.8825 9.53711C11.805 9.17148 13.994 9.25586 15.0135 9.25586C16.0329 9.25586 18.2251 9.17461 19.1444 9.53711C19.7574 9.78086 20.2296 10.2527 20.4766 10.8684C20.8425 11.7902 20.7581 13.9777 20.7581 14.9965C20.7581 16.0152 20.8425 18.2059 20.4766 19.1246Z"
                                    fill="#00786E" />
                            </svg>
                        </a>
                        <a href="{{ $settings['instagram_url'] }}" aria-label="Instagram" target="_blank"
                            class="social-icon">
                            <svg width="31" height="30" viewBox="0 0 31 30" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21.3701 11.7405C21.3803 11.8826 21.3803 12.0248 21.3803 12.1669C21.3803 16.5019 18.0785 21.4969 12.0439 21.4969C10.1847 21.4969 8.45766 20.9588 7.00488 20.0248C7.26903 20.0552 7.52299 20.0654 7.7973 20.0654C9.33133 20.0654 10.7435 19.5476 11.8712 18.6644C10.4286 18.6339 9.2196 17.6898 8.80306 16.3903C9.00626 16.4207 9.20943 16.441 9.4228 16.441C9.71741 16.441 10.012 16.4004 10.2863 16.3294C8.78276 16.0248 7.65505 14.705 7.65505 13.1111V13.0705C8.09188 13.3141 8.59989 13.4664 9.13829 13.4867C8.25443 12.8979 7.67538 11.8928 7.67538 10.7557C7.67538 10.1466 7.83789 9.58823 8.12237 9.10092C9.7377 11.0908 12.1658 12.3902 14.8884 12.5324C14.8377 12.2887 14.8072 12.035 14.8072 11.7811C14.8072 9.97402 16.2701 8.50195 18.0886 8.50195C19.0334 8.50195 19.8868 8.89789 20.4862 9.53748C21.2278 9.39536 21.9389 9.12123 22.5689 8.74561C22.325 9.50705 21.8069 10.1466 21.1262 10.5527C21.7866 10.4817 22.4266 10.2989 23.0158 10.0451C22.5689 10.6948 22.0101 11.2735 21.3701 11.7405Z"
                                    fill="#00786E" />
                            </svg>
                        </a>
                        <a href="{{ $settings['linkedin_url'] }}" aria-label="LinkedIn" target="_blank" class="social-icon">
                            <svg width="31" height="30" viewBox="0 0 31 30" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.1415 20.9997H8.23702V11.6528H11.1415V20.9997ZM9.68771 10.3778C8.75895 10.3778 8.00562 9.60906 8.00562 8.68094C8.00562 8.23513 8.18284 7.80757 8.49829 7.49234C8.81374 7.1771 9.24159 7 9.68771 7C10.1338 7 10.5617 7.1771 10.8771 7.49234C11.1926 7.80757 11.3698 8.23513 11.3698 8.68094C11.3698 9.60906 10.6162 10.3778 9.68771 10.3778ZM22.0121 20.9997H19.1139V16.4497C19.1139 15.3653 19.092 13.9747 17.6038 13.9747C16.0937 13.9747 15.8623 15.1528 15.8623 16.3716V20.9997H12.9609V11.6528H15.7466V12.9278H15.7872C16.175 12.1934 17.1222 11.4184 18.5354 11.4184C21.4749 11.4184 22.0153 13.3528 22.0153 15.8653V20.9997H22.0121Z"
                                    fill="#00786E" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Query Form -->
            <div class="col-lg-6 mb-5 mb-md-0">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5 class="title-two mb-3 fade-in-observer">Query</h5>
                            <p class="content-text mb-0 fade-in-observer">If you have any query about us then you
                                can direct message from here.</p>
                        </div>
                        <form id="contactForm" method="POST" action="{{ route('contact.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" placeholder="Email (Required)" required>
                                @error('email')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                    name="subject" value="{{ old('subject') }}" placeholder="Subject" required>
                                @error('subject')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4"
                                    placeholder="Descriptions" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            @if (env('USE_RECAPTCHA') == 1)
                                <!-- Google reCAPTCHA -->
                                <div class="mb-3">
                                    {!! NoCaptcha::display() !!}
                                    {!! NoCaptcha::renderJs() !!}
                                    @error('g-recaptcha-response')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <button type="submit" class="btn w-100 py-3 btn-slide-fill">
                                <span>Send Message</span>
                            </button>
                        </form>

                        <div id="formMessage" class="mt-3"></div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Contact Section End -->
    @push('styles')
        {!! ToastMagic::styles() !!}
        <style>
            .contact-query-section .card {
                border: none;
                box-shadow:
                    0px 0px 0px 0px #00000012,
                    1px 15px 34px 0px #00000012,
                    4px 61px 61px 0px #0000000F,
                    10px 137px 83px 0px #0000000A,
                    17px 244px 98px 0px #00000003,
                    27px 381px 107px 0px #00000000;
            }

            .contact-query-section .card-body {
                padding: 42px 50px;

            }

            .contact-query-section .form-control {
                padding: 15px 21px;
            }

            @media screen and (max-width: 768px) {
                .contact-query-section .card-body {
                    padding: 30px 30px;
                }
            }




            /* Fade-in animation */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-30px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes fadeInRight {
                from {
                    opacity: 0;
                    transform: translateX(30px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes pulse {

                0%,
                100% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-10px);
                }
            }



            .contact-info-item {
                opacity: 0;
                animation: fadeInLeft 0.8s ease-out forwards;
                transition: all 0.3s ease;
                padding: 15px;
                border-radius: 10px;
            }

            .contact-info-item:nth-child(1) {
                animation-delay: 0.1s;
            }

            .contact-info-item:nth-child(2) {
                animation-delay: 0.2s;
            }

            .contact-info-item:nth-child(3) {
                animation-delay: 0.3s;
            }

            .contact-info-item:hover {
                background: #f8f9fa;
                transform: translateX(4px);
            }

            .contact-info-item svg {
                transition: all 0.3s ease;
            }

            .contact-info-item:hover svg {
                transform: scale(1.1) rotate(5deg);
            }

            /* Social media section */
            .contact-query-section .social-section {
                opacity: 0;
                animation: fadeInLeft 0.8s ease-out 0.4s forwards;
            }

            .contact-query-section .social-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                border: 2px solid #00786E;
                transition: all 0.4s ease;
                position: relative;
                overflow: hidden;
            }

            .contact-query-section .social-icon::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                border-radius: 50%;
                background: #00786E;
                transform: translate(-50%, -50%);
                transition: all 0.4s ease;
                z-index: 0;
            }

            .contact-query-section .social-icon:hover::before {
                width: 100%;
                height: 100%;
            }

            .contact-query-section .social-icon svg {
                position: relative;
                z-index: 1;
                transition: all 0.3s ease;
            }

            .contact-query-section .social-icon:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 120, 110, 0.3);
            }

            .contact-query-section .social-icon:hover svg path {
                fill: white;
            }



            .btn-slide-fill {
                position: relative;
                padding: 15px 50px;
                font-size: 16px;
                font-weight: 600;
                color: #00786E;
                background: white;
                border: 2px solid #00786E;
                border-radius: 6px !important;
                cursor: pointer;
                overflow: hidden;
                transition: color 0.6s ease;
                z-index: 1;
            }

            .btn-slide-fill::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 0;
                height: 100%;
                background: linear-gradient(135deg, #00786E 0%, #005a52 100%);
                transition: width 0.6s ease;
                z-index: -1;
            }

            .btn-slide-fill:hover::before {
                width: 100%;
            }

            .btn-slide-fill:hover {
                color: white;
                border-color: #00786E;
            }

            .btn-slide-fill span {
                position: relative;
                z-index: 2;
            }


            .btn-check:checked+.btn,
            .btn.active,
            .btn.show,
            .btn:first-child:active,
            :not(.btn-check)+.btn:active {
                color: #fff;
                background: linear-gradient(135deg, #00786E 0%, #005a52 100%);
                border-color: #00786E;
            }
        </style>
    @endpush
    @push('scripts')
        {!! ToastMagic::scripts() !!}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const form = document.getElementById("contactForm");

                form.addEventListener("submit", function(e) {
                    let valid = true;

                    // Clear previous errors
                    form.querySelectorAll(".invalid-feedback.js-error").forEach(el => el.remove());
                    form.querySelectorAll(".is-invalid").forEach(el => el.classList.remove("is-invalid"));

                    // Email validation
                    const email = form.querySelector("input[name='email']");
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!email.value.trim() || !emailRegex.test(email.value.trim())) {
                        valid = false;
                        showError(email, "Please enter a valid email address.");
                    }

                    // Subject validation
                    const subject = form.querySelector("input[name='subject']");
                    if (!subject.value.trim()) {
                        valid = false;
                        showError(subject, "Subject is required.");
                    } else if (subject.value.trim().length < 4) {
                        valid = false;
                        showError(subject, "Subject must be at least 4 characters long.");
                    } else if (subject.value.trim().length > 988) {
                        valid = false;
                        showError(subject, "Subject must be less than 988 characters long.");
                    }

                    // Description validation
                    const description = form.querySelector("textarea[name='description']");
                   else if (!description.value.trim()) {
                        valid = false;
                        showError(description, "Description is required.");
                    } else if (description.value.trim().length < 4) {
                        valid = false;
                        showError(description, "Description must be at least 4 characters long.");
                    }
                    // reCAPTCHA response value const
                    recaptchaResponse = document.querySelector("#g-recaptcha-response");
                    // Clear old error
                    const oldError = form.querySelector(".recaptcha-error");
                    if (oldError) oldError.remove();
                    if (!recaptchaResponse || !recaptchaResponse.value.trim()) {
                        e.preventDefault();
                        // Show inline error message
                        const error = document.createElement("div");
                        error.className = "text-danger recaptcha-error mt-2";
                        error.innerText = "Please complete the reCAPTCHA before submitting.";
                        form.querySelector(".mb-3").appendChild(error);
                    }

                    if (!valid) {
                        e.preventDefault();
                    }
                });

                function showError(field, message) {
                    field.classList.add("is-invalid");
                    const error = document.createElement("div");
                    error.className = "invalid-feedback js-error d-block";
                    error.innerText = message;
                    field.insertAdjacentElement("afterend", error);
                }
            });
        </script>
    @endpush

@endsection
