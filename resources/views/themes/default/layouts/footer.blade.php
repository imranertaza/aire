<!-- Footer -->
<footer class="site-footer bg-footer-darker border-top border-secondary border-opacity-25">
    <div class="container main-container">
        <div class="row g-0">

            <!-- Left Column (col-lg-3): Brand, Tagline & Contact -->
            <div
                class="col-lg-3 pt-80 pb-4 px-4 pb-xl-5 border-end border-secondary border-opacity-25 bg-footer-darker d-flex flex-column justify-content-between text-end align-items-end">
                <div class="w-100 text-end">
                    <!-- Logo -->
                    <a href="{{ route('home') }}"
                        class="brand-logo text-decoration-none mb-4 d-flex align-items-center justify-content-end text-end ms-auto">
                        @if (!empty($settings['footer_logo']) && !str_contains($settings['footer_logo'], 'placehold.co'))
                            <img src="{{ getImageUrl($settings['footer_logo']) }}" alt="{{ $settings['brand_name'] ?? 'AIRE' }} logo"
                                class="img-fluid logo-footer-img">
                        @else
                            <img src="{{ theme_asset('img/aire-industries-logo-white.png') }}" alt="{{ $settings['brand_name'] ?? 'AIRE' }} logo"
                                class="img-fluid logo-footer-img">
                        @endif
                    </a>
                    <p class="fs-14 mb-4 lh-lg text-muted-50 text-end">
                        {{ $settings['footer_description'] ?? ($settings['footer_tagline'] ?? ($settings['footer_about'] ?? ($settings['site_description'] ?? 'Technological mastery in every breath. Leading the future of high-purity air environments for a healthier planet.'))) }}
                    </p>
                </div>

                <!-- Contact Section -->
                <div class="footer-contact-block mt-4 pt-2 w-100 text-end">
                    <h4 class="footer-heading-sm text-uppercase fw-bold text-white mb-3 text-lg-end">CONTACT</h4>
                    @if (!empty($settings['address']))
                        <div class="d-flex justify-content-end mb-3 fs-13 text-muted-50 text-end">
                            <div class="d-inline-flex align-items-start gap-2 text-end">
                                <i class="bi bi-geo-alt mt-1 fs-6"></i>
                                <span class="text-end">{!! nl2br(e($settings['address'])) !!}</span>
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-end mb-3 fs-13 text-muted-50 text-end">
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
            </div>

            <!-- Center Column (col-lg-6): Dynamic Links & Payment Logos -->
            <div
                class="col-lg-6 pt-80 pb-4 px-4 px-xl-4 pb-xl-5 border-end border-secondary border-opacity-25 bg-footer-black d-flex flex-column justify-content-between">
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
                    <div class="row g-4 mb-4">
                        @forelse ($footerMenus as $fMenu)
                            <div class="col-6 col-md-3">
                                <h4 class="footer-heading-sm text-uppercase fw-bold text-white mb-3">{{ $fMenu->name }}
                                </h4>
                                <ul class="footer-links list-unstyled mb-0">
                                    @foreach ($fMenu->menus as $mItem)
                                        <li class="mb-2">
                                            <a href="{{ $mItem->url ?? '#' }}">{{ $mItem->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @empty
                            <!-- Fallback Menu Columns -->
                            <div class="col-6 col-md-3">
                                <h4 class="footer-heading-sm text-uppercase fw-bold text-white mb-3">SOLUTIONS</h4>
                                <ul class="footer-links list-unstyled mb-0">
                                    <li class="mb-2"><a href="{{ route('solutions') }}">Residential</a></li>
                                    <li class="mb-2"><a href="{{ route('solutions') }}">Commercial</a></li>
                                    <li class="mb-2"><a href="{{ route('solutions') }}">Healthcare</a></li>
                                    <li class="mb-2"><a href="{{ route('solutions') }}">Infrastructure</a></li>
                                    <li class="mb-2"><a href="{{ route('solutions') }}">Industrial</a></li>
                                    <li><a href="{{ route('solutions') }}">Site Map</a></li>
                                </ul>
                            </div>
                            <div class="col-6 col-md-3">
                                <h4 class="footer-heading-sm text-uppercase fw-bold text-white mb-3">PRODUCTS</h4>
                                <ul class="footer-links list-unstyled mb-0">
                                    <li class="mb-2"><a href="{{ route('products.index') }}">Residential</a></li>
                                    <li class="mb-2"><a href="{{ route('products.index') }}">Commercial</a></li>
                                    <li class="mb-2"><a href="{{ route('products.index') }}">Healthcare</a></li>
                                    <li class="mb-2"><a href="{{ route('products.index') }}">Infrastructure</a></li>
                                    <li class="mb-2"><a href="{{ route('products.index') }}">Industrial</a></li>
                                    <li><a href="{{ route('products.index') }}">Site Map</a></li>
                                </ul>
                            </div>
                            <div class="col-6 col-md-3">
                                <h4 class="footer-heading-sm text-uppercase fw-bold text-white mb-3">COMPANY</h4>
                                <ul class="footer-links list-unstyled mb-0">
                                    <li class="mb-2"><a href="{{ route('about') }}">About Us</a></li>
                                    <li class="mb-2"><a href="{{ route('about') }}">Sustainability</a></li>
                                    <li class="mb-2"><a href="{{ route('about') }}">Careers</a></li>
                                    <li><a href="{{ route('about') }}">Global Locations</a></li>
                                </ul>
                            </div>
                            <div class="col-6 col-md-3">
                                <h4 class="footer-heading-sm text-uppercase fw-bold text-white mb-3">RESOURCES</h4>
                                <ul class="footer-links list-unstyled mb-0">
                                    <li class="mb-2"><a href="{{ route('solutions') }}">Technology</a></li>
                                    <li class="mb-2"><a href="{{ route('solutions') }}">Monitoring</a></li>
                                    <li><a href="{{ route('docs') }}">Documentation</a></li>
                                </ul>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Payment & Bank Badges -->
                <div class="payment-badges-wrap mb-4 mt-md-5">
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
                <div class="d-flex align-items-center gap-4 flex-wrap pt-3 text-muted-50 fs-13">
                    @if ($legalMenu && $legalMenu->menus->count() > 0)
                        @foreach ($legalMenu->menus as $lItem)
                            <a href="{{ $lItem->url ?? '#' }}"
                                class="footer-legal-link text-decoration-none">{{ $lItem->name }}</a>
                        @endforeach
                    @else
                    @endif
                    <span class="ms-md-auto">&copy; {{ date('Y') }}
                        {{ $settings['brand_name'] ?? 'AIRE Industries' }}. All rights reserved.</span>
                </div>
            </div>

            <!-- Right Column (col-lg-3): Newsletter, Social Icons & App Badges -->
            <div
                class="col-lg-3 pt-80 pb-4 px-3 px-xl-3 pb-xl-5 bg-footer-darker d-flex flex-column justify-content-between">
                <div>
                    <h4 class="footer-heading-sm text-uppercase fw-bold text-white mb-3">SUBSCRIBE TO OUR NEWSLETTER
                    </h4>
                    <p class="fs-13 lh-lg mb-4 text-muted-50">Stay updated with the latest in atmospheric technology and
                        exclusive insights.</p>

                    <!-- Newsletter Form -->
                    <form action="#" class="newsletter-form position-relative mb-4"
                        onsubmit="event.preventDefault();">
                        <input type="email"
                            class="form-control rounded-3 py-2-5 ps-3 pe-5 fs-14 newsletter-input-field"
                            placeholder="Email address" required>
                        <button type="submit"
                            class="btn text-white position-absolute top-50 end-0 translate-middle-y me-1 p-2 border-0 shadow-none"
                            aria-label="Subscribe">
                            <i class="bi bi-arrow-right fs-5 text-muted-50"></i>
                        </button>
                    </form>
                </div>

                <!-- Bottom Social Icons & App Badges -->
                <div class="mt-4 pt-2">
                    <!-- Dynamic Social Pill Buttons -->
                    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
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

                    <!-- App Badges (Google Play & App Store) -->
                    <div class="d-flex align-items-center">
                        <a href="#">
                            <img src="{{ theme_asset('img/play-store.png') }}" alt="Google Play">
                        </a>
                        <a href="#">
                            <img src="{{ theme_asset('img/apopel-store.png') }}" alt="App Store">
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>
