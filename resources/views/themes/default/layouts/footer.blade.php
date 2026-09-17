<!-- Footer -->
<footer class="site-footer bg-footer-darker border-top border-secondary border-opacity-25">
    <div class="container main-container pb-5 pb-md-0">
        <div class="row g-0">

            <!-- Left Column (col-lg-3): Brand, Tagline & Contact -->
            <div
                class="col-lg-3 pt-4 pb-4 px-4 pb-xl-4 border-end border-secondary border-opacity-25 bg-footer-darker d-flex flex-column justify-content-between text-end align-items-end">
                <div class="w-100 text-end">
                    <!-- Logo -->
                    <a href="{{ route('home') }}"
                        class="brand-logo text-decoration-none mb-4 d-flex align-items-center justify-content-end text-end ms-auto">
                        @if (!empty($settings['footer_logo']) && !str_contains($settings['footer_logo'], 'placehold.co'))
                            <img src="{{ getImageUrl($settings['footer_logo']) }}"
                                alt="{{ $settings['brand_name'] ?? 'AIRE' }} logo" class="img-fluid logo-footer-img">
                        @else
                            <img src="{{ theme_asset('img/aire-industries-logo-white.png') }}"
                                alt="{{ $settings['brand_name'] ?? 'AIRE' }} logo" class="img-fluid logo-footer-img">
                        @endif
                    </a>
                    <p class="fs-14 lh-lg text-muted-50 text-end mb-0">
                        {{ $settings['footer_description'] ?? ($settings['footer_tagline'] ?? ($settings['footer_about'] ?? ($settings['site_description'] ?? 'Technological mastery in every breath. Leading the future of high-purity air environments for a healthier planet.'))) }}
                    </p>
                </div>
                <div class="my-4">
                    <!-- Newsletter Form -->
                    <div class="mb-3">
                        <label for="newsletterEmailInput"
                            class="footer-heading-sm text-uppercase fw-bold text-white mb-2">SUBSCRIBE TO OUR
                            NEWSLETTER</label>
                        <form id="footerNewsletterForm" action="{{ route('newsletter.subscribe') }}" method="POST"
                            class="newsletter-form position-relative">
                            <div style="display:none !important; position:absolute; left:-9999px;"><input type="text"
                                    name="b_extra_field" tabindex="-1" autocomplete="off"></div>
                            @csrf
                            <input type="email" name="email" id="newsletterEmailInput"
                                class="form-control rounded-3 py-2-5 ps-3 pe-5 fs-14 newsletter-input-field"
                                placeholder="Email address" required autocomplete="email">
                            <button type="submit" id="btnNewsletterSubmit"
                                class="btn text-white position-absolute top-50 end-0 translate-middle-y me-1 p-2 border-0 shadow-none d-flex align-items-center justify-content-center"
                                aria-label="Subscribe">
                                <i class="bi bi-arrow-right fs-5 text-muted-50 btn-icon-normal"></i>
                                <span class="spinner-border spinner-border-sm text-light d-none btn-spinner"
                                    role="status" aria-hidden="true"></span>
                            </button>
                        </form>
                    </div>
                    <div id="newsletterFeedback" class="fs-13 mb-3 fw-medium" style="display: none;"></div>
                    <!-- Dynamic Social Pill Buttons -->
                    <div class="d-flex  align-items-center gap-2 justify-content-md-end">
                        @if (!empty($settings['linkedin_url']))
                            <a href="{{ $settings['linkedin_url'] }}" target="_blank" class="footer-social-pill"
                                aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        @else
                            <a href="#" class="footer-social-pill" aria-label="LinkedIn"><i
                                    class="bi bi-linkedin"></i></a>
                        @endif

                        @if (!empty($settings['youtube_url']))
                            <a href="{{ $settings['youtube_url'] }}" target="_blank" class="footer-social-pill"
                                aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        @else
                            <a href="#" class="footer-social-pill" aria-label="YouTube"><i
                                    class="bi bi-youtube"></i></a>
                        @endif

                        @if (!empty($settings['twitter_url']))
                            <a href="{{ $settings['twitter_url'] }}" target="_blank" class="footer-social-pill"
                                aria-label="X / Twitter"><i class="bi bi-twitter-x"></i></a>
                        @else
                            <a href="#" class="footer-social-pill" aria-label="X / Twitter"><i
                                    class="bi bi-twitter-x"></i></a>
                        @endif

                        @if (!empty($settings['instagram_url']))
                            <a href="{{ $settings['instagram_url'] }}" target="_blank" class="footer-social-pill"
                                aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        @else
                            <a href="#" class="footer-social-pill" aria-label="Instagram"><i
                                    class="bi bi-instagram"></i></a>
                        @endif

                        @if (!empty($settings['fb_url']))
                            <a href="{{ $settings['fb_url'] }}" target="_blank" class="footer-social-pill"
                                aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        @else
                            <a href="#" class="footer-social-pill" aria-label="Facebook"><i
                                    class="bi bi-facebook"></i></a>
                        @endif
                    </div>
                </div>
                <!-- Contact Section -->
                <div class="footer-contact-block w-100 text-end">
                    <h4 class="footer-heading-sm text-uppercase fw-bold text-white text-lg-end">CONTACT</h4>
                    @if (!empty($settings['address']))
                        <div class="d-flex justify-content-end mb-2 fs-13 text-muted-50 text-end">
                            <div class="d-inline-flex align-items-start gap-2 text-end">
                                <i class="bi bi-geo-alt mt-1 fs-6"></i>
                                <span class="text-end">{!! nl2br(e($settings['address'])) !!}</span>
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-end mb-2 fs-13 text-muted-50 text-end">
                            <div class="d-inline-flex align-items-start gap-2 text-end">
                                <i class="bi bi-geo-alt mt-1 fs-6"></i>
                                <span class="text-end">Innovation Drive, Suite 100<br>Silicon Valley, CA 94025</span>
                            </div>
                        </div>
                    @endif

                    @if (!empty($settings['email']))
                        <div class="d-flex justify-content-end mb-2 fs-13 text-muted-50 text-end">
                            <a href="mailto:{{ $settings['email'] }}"
                                class="d-inline-flex align-items-center gap-2 text-muted-50 text-decoration-none text-end">
                                <i class="bi bi-envelope fs-6"></i>
                                <span class="text-end">{{ $settings['email'] }}</span>
                            </a>
                        </div>
                    @endif

                    @if (!empty($settings['phone']))
                        <div class="d-flex justify-content-end fs-13 text-muted-50 text-end">
                            <a href="tel:{{ $settings['phone'] }}"
                                class="d-inline-flex align-items-center gap-2 text-muted-50 text-decoration-none text-end">
                                <i class="bi bi-telephone fs-6"></i>
                                <span class="text-end">{{ $settings['phone'] }}</span>
                            </a>
                        </div>
                    @endif
                </div>

                @php
                    $showAppLinks =
                        !isset($settings['show_app_download_links']) ||
                        $settings['show_app_download_links'] == '1' ||
                        $settings['show_app_download_links'] === true;
                    $googlePlayUrl = $settings['google_play_url'] ?? ($settings['play_store_url'] ?? '#');
                    $appStoreUrl = $settings['app_store_url'] ?? ($settings['apple_store_url'] ?? '#');
                    $googlePlayImg = !empty($settings['google_play_image'])
                        ? getImageUrl($settings['google_play_image'])
                        : (!empty($settings['play_store_image'])
                            ? getImageUrl($settings['play_store_image'])
                            : theme_asset('img/play-store.png'));
                    $appStoreImg = !empty($settings['app_store_image'])
                        ? getImageUrl($settings['app_store_image'])
                        : (!empty($settings['apple_store_image'])
                            ? getImageUrl($settings['apple_store_image'])
                            : theme_asset('img/apopel-store.png'));
                @endphp
            </div>

            <!-- Center Column (col-lg-6): Dynamic Links & Payment Logos -->
            <div
                class="col-lg-9 pt-4 pb-4 px-4 px-xl-4 gap-4 pb-xl-4 bg-footer-black d-flex flex-column justify-content-between">
                <div>
                    @php
                        $footerMenus = \App\Models\Menu::where(function ($q) {
                            $q->where('position', 'footer')->orWhere('position', 'Footer');
                        })
                            ->where('enabled', 1)
                            ->with([
                                'menus' => function ($q) {
                                    $q->where('enabled', 1)->orderBy('order', 'asc');
                                },
                            ])
                            ->get();
                    @endphp

                    <!-- Dynamic Nav Link Columns Grid -->
                    <div class="row g-4 row-cols-2 row-cols-sm-3 row-cols-lg-5">
                        @forelse ($footerMenus as $fMenu)
                            <div class="">
                                <h4 class="footer-heading-sm text-uppercase fw-bold text-white mb-3">
                                    {{ $fMenu->name }}
                                </h4>
                                <ul class="footer-links list-unstyled mb-0">
                                    @foreach ($fMenu->menus as $mItem)
                                        <li class="{{ $loop->last ? 'mb-0' : 'mb-2' }}">
                                            <a href="{{ $mItem->url ?? '#' }}">{{ $mItem->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>

                <!-- Payment & Bank Badges -->
                <div class="payment-badges-wrap">
                    <img src="{{ theme_asset('img/paymentWeSupport.png') }}" alt="Payment methods we support"
                        class="img-fluid">
                </div>

                @php
                    $legalMenu = \App\Models\Menu::where(function ($q) {
                        $q->where('position', 'footer_bottom')
                            ->orWhere('position', 'Footer Bottom')
                            ->orWhere('name', 'Footer Legal')
                            ->orWhere('name', 'Legal');
                    })
                        ->where('enabled', 1)
                        ->with([
                            'menus' => function ($q) {
                                $q->where('enabled', 1)->orderBy('order', 'asc');
                            },
                        ])
                        ->first();
                @endphp

                <!-- Footer Legal Links & Copyright -->
                <div
                    class="d-flex align-items-center justify-content-between gap-md-4 gap-1 flex-wrap text-muted-50 fs-13">
                    @if ($legalMenu && $legalMenu->menus->count() > 0)
                        <div class="d-flex align-items-center gap-4 flex-wrap text-muted-50 fs-13">
                            @foreach ($legalMenu->menus as $lItem)
                                <a href="{{ $lItem->url ?? '#' }}"
                                    class="footer-legal-link text-decoration-none">{{ $lItem->name }}</a>
                            @endforeach
                        </div>
                    @else
                    @endif
                    @if ($showAppLinks)
                        <div class="d-flex align-items-center gap-2 app-link-container">
                            @if (!empty($googlePlayUrl) && $googlePlayUrl !== '#')
                                <a href="{{ $googlePlayUrl }}" target="_blank" rel="noopener noreferrer"
                                    aria-label="Google Play">
                                    <img src="{{ $googlePlayImg }}" alt="Google Play">
                                </a>
                            @else
                                <a href="{{ $googlePlayUrl ?: '#' }}" aria-label="Google Play">
                                    <img src="{{ $googlePlayImg }}" alt="Google Play">
                                </a>
                            @endif

                            @if (!empty($appStoreUrl) && $appStoreUrl !== '#')
                                <a href="{{ $appStoreUrl }}" target="_blank" rel="noopener noreferrer"
                                    aria-label="App Store">
                                    <img src="{{ $appStoreImg }}" alt="App Store">
                                </a>
                            @else
                                <a href="{{ $appStoreUrl ?: '#' }}" aria-label="App Store">
                                    <img src="{{ $appStoreImg }}" alt="App Store">
                                </a>
                            @endif
                        </div>
                    @endif
                    <div class="d-flex align-items-center gap-4 flex-wrap text-muted-50 fs-13">
                        <span class="ms-md-auto">&copy; {{ date('Y') }}
                            {{ $settings['brand_name'] ?? 'AIRE Industries' }}. All rights reserved.</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('footerNewsletterForm');
            if (!form) return;

            const emailInput = document.getElementById('newsletterEmailInput');
            const submitBtn = document.getElementById('btnNewsletterSubmit');
            const iconNormal = submitBtn ? submitBtn.querySelector('.btn-icon-normal') : null;
            const spinner = submitBtn ? submitBtn.querySelector('.btn-spinner') : null;
            const feedback = document.getElementById('newsletterFeedback');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const email = (emailInput.value || '').trim();
                if (!email) return;

                // UI: Loading State
                if (submitBtn) submitBtn.disabled = true;
                if (iconNormal) iconNormal.classList.add('d-none');
                if (spinner) spinner.classList.remove('d-none');
                if (feedback) {
                    feedback.style.display = 'none';
                    feedback.className = 'fs-13 mb-3 fw-medium';
                }

                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                    form.querySelector('input[name="_token"]')?.value;

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            email: email
                        })
                    })
                    .then(res => res.json().then(data => ({
                        status: res.status,
                        body: data
                    })))
                    .then(({
                        status,
                        body
                    }) => {
                        if (status >= 200 && status < 300 && body.success) {
                            if (feedback) {
                                feedback.textContent = body.message || 'Thank you for subscribing!';
                                feedback.classList.add('text-success');
                                feedback.style.display = 'block';
                            }
                            emailInput.value = '';
                            if (typeof window.showNewsletterToast === 'function') {
                                window.showNewsletterToast(body.message || 'Thank you for subscribing!',
                                    true);
                            }
                        } else {
                            if (feedback) {
                                feedback.textContent = body.message ||
                                    'Could not subscribe. Please try again.';
                                feedback.classList.add('text-danger');
                                feedback.style.display = 'block';
                            }
                            if (typeof window.showNewsletterToast === 'function') {
                                window.showNewsletterToast(body.message || 'Could not subscribe.',
                                    false);
                            }
                        }
                    })
                    .catch(err => {
                        if (feedback) {
                            feedback.textContent = 'A network error occurred. Please try again later.';
                            feedback.classList.add('text-danger');
                            feedback.style.display = 'block';
                        }
                    })
                    .finally(() => {
                        if (submitBtn) submitBtn.disabled = false;
                        if (iconNormal) iconNormal.classList.remove('d-none');
                        if (spinner) spinner.classList.add('d-none');
                    });
            });
        });
    </script>
@endpush
