@extends('themes.default.layouts.master')

@section('title', 'Aire | Precision Selection - Find Your Perfect Air Solution')

@push('styles')
    <!-- Google Fonts Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- BEM Product Filter Page CSS -->
    <link href="{{ theme_asset('css/product-filter.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Main Content: 3-Column Layout -->
    <main class="">
        <div class="container main-container border-top border-light">
            <div class="row g-0">

                <!-- LEFT COLUMN: Breadcrumb, Step Tracker & Protocol Analysis (col-lg-3) -->
                <div class="col-lg-3 border-right1px pt-4 pe-lg-4">
                    <div class="protocol-sidebar sticky-sidebar left" data-lenis-prevent>
                        <!-- Breadcrumb -->
                        <div class="cart-breadcrumb text-muted fs-13 mb-4">
                            <a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a> &nbsp;&gt;&nbsp;
                            <span class="text-dark fw-bold">Filter</span>
                        </div>

                        <!-- Step Tracker Sidebar (Populated dynamically by jQuery) -->
                        <div class="step-tracker"></div>

                        <!-- Protocol Analysis Progress Box -->
                        <div class="protocol-analysis mt-4">
                            <div class="protocol-analysis-label">
                                <span>ANALYSIS</span>
                                <span class="protocol-analysis-pct">11%</span>
                            </div>
                            <div class="protocol-progress-bar">
                                <div class="protocol-progress-fill" style="width: 11%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CENTER COLUMN: Precision Selection Sequential Wizard (col-lg-6) -->
                <div class="col-lg-6 protocol-center-panel pt-4 px-lg-4">
                    <!-- Header Title Row -->
                    <div class="mb-4">
                        <h1 class="title-2 mb-2">Precision Selection.</h1>
                        <p class="fs-14 text-muted mb-0">Architect your custom AIRE technical specification through our
                            sequential protocol.</p>
                    </div>

                    <!-- Progress Header Bar -->
                    <div class="step-progress-track">
                        <div class="step-progress-track-fill" style="width: 11%;"></div>
                    </div>
                    <div class="step-meta-row">
                        <span class="step-header-tag" id="wizardStepTag">PROTOCOL INIT</span>
                        <span class="step-header-count" id="wizardStepCount">STEP 1 / 9</span>
                    </div>

                    <!-- Dynamic Steps Container (Rendered by jQuery) -->
                    <div id="wizardStepsContainer"></div>

                    <!-- Matched Products Section (Rendered dynamically only when protocol steps complete) -->
                    <section id="other-matched-products"></section>
                </div>

                <!-- RIGHT COLUMN: Featured Solution Promo Card (col-lg-3) -->
                <aside class="col-lg-3 border-left1px ps-lg-4">
                    <!-- Swiper Slider Implementation -->

                    @if ($adSliders->count() > 0)
                        <div class="featured-card sticky-sidebar bg-white border border-light-subtle shadow-sm rounded-4 ms-3"
                            data-lenis-prevent>
                            <div class="swiper featured-swiper">
                                <div class="swiper-wrapper">
                                    @forelse ($adSliders as $index => $ad)
                                        <div class="swiper-slide">
                                            <div class="featured-img position-relative">
                                                <span
                                                    class="badge bg-dark position-absolute top-0 start-0 m-3 rounded-0 px-3 py-2 text-uppercase text-white border-0 featured-badge">
                                                    {{ $ad->subtitle ?: ($ad->badge ?: ($index === 0 ? 'Featured Solution' : ($index === 1 ? 'New Arrival' : 'Commercial'))) }}
                                                </span>
                                                <img src="{{ !empty($ad->image) ? getImageUrl($ad->image) : theme_asset('img/featured/' . (($index % 3) + 1) . '.png') }}"
                                                    class="img-fluid w-100" alt="{{ $ad->title ?? 'Featured Ad' }}">
                                            </div>
                                            <div class="featured-content pb-5">
                                                <h3 class="mb-2">{{ $ad->title }}</h3>
                                                <p class="text-muted mb-2 lh-base">{{ $ad->description }}</p>
                                                <a href="{{ $ad->link ?: route('products.filter') }}"
                                                    class="btn btn-primary w-100 fw-bold shadow-sm featured-btn text-decoration-none d-inline-block text-center">
                                                    {{ $ad->button_text ?? ($index === 0 ? 'VIEW PRODUCTS' : ($index === 1 ? 'LEARN MORE' : 'GET A QUOTE')) }}
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                                <!-- Add Pagination -->
                                <div class="swiper-pagination position-absolute bottom-2"></div>
                            </div>
                        </div>
                    @endif
                </aside>

            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        window.DYNAMIC_STEPS_DATA = @json($stepsData);
        window.FILTER_QUERY_URL = "{{ route('api.filter-step.query') }}";
        window.CATALOG_URL = "{{ route('products.filter') }}";
        window.CSRF_TOKEN = "{{ csrf_token() }}";
        window.INITIAL_PAGINATION = {
            currentPage: 1,
            lastPage: 1,
            hasMore: false
        };
    </script>
    <!-- Custom Product Filter JS -->
    <script src="{{ theme_asset('js/product-filter.js') }}" defer></script>
@endpush
