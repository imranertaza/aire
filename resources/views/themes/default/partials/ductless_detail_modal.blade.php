@php
    $showcase = $product->showcase ?? null;
    $desc = $product->description ?? null;
    $targetModalId = $modalId ?? 'quickViewModal-' . ($product->id ?? 'default');

    $brandName = $showcase->diagram_brand ?? ($product->brand->name ?? 'BROAD');
    $seriesBadge = $showcase->series_badge ?? 'AIRPRO HEPA Series';
    $title = !empty($showcase->title) ? $showcase->title : $desc->name ?? ($product->name ?? 'AirPro Fresh FE6');
    $subtitle =
        $showcase->modal_subtitle ?? ($showcase->subtitle ?? 'Single Room Ductless Wall–Mounted Fresh Air Ventilator');
    $description = !empty($desc->description)
        ? strip_tags($desc->description)
        : 'Brings in 100% outdoor air, filters with HEPA, and recovers heat to provide clean, healthy and comfortable indoor air for bedrooms, living rooms and small spaces.';

    $heroBgImage = !empty($showcase->hero_bg_image)
        ? getImageUrl($showcase->hero_bg_image)
        : (file_exists(public_path('assets/images/cart-bg.png'))
            ? asset('assets/images/cart-bg.png')
            : theme_asset('img/cart-bg.png'));

    $productUrl = !empty($product->slug)
        ? route('products.detail', $product->slug)
        : (!empty($product->id)
            ? route('products.detail', $product->id)
            : route('products.index'));

    static $cachedCompare = null;
    if ($cachedCompare === null) {
        $cachedCompare = session()->get('compare_products', session()->get('compare', []));
    }
    $inCompare = isset($product->id) && in_array($product->id, $cachedCompare);
@endphp

<!-- Quick View / Product Detail Modal -->
<div class="modal fade ductless-modal" id="{{ $targetModalId }}" tabindex="-1" aria-labelledby="{{ $targetModalId }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ductless-modal__dialog">
        <div class="modal-content ductless-modal__content">
            {{-- Close Button --}}
            <button type="button" class="ductless-modal__close-btn" data-bs-dismiss="modal" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>

            {{-- Main Modal Body --}}
            <div class="modal-body p-0">
                {{-- Top Section: 2 Columns (Image + Info) --}}
                <div class="row g-3 g-lg-4 align-items-stretch">
                    {{-- Left Column: Product Image Showcase --}}
                    <div class="col-12 col-lg-5 d-flex flex-column">
                        <div class="ductless-modal__image-wrapper flex-grow-1"
                            style="background-image: url('{{ $heroBgImage }}');">
                            {{-- Product canvas matching mockup --}}
                        </div>
                    </div>

                    {{-- Right Column: Product Details & Specs --}}
                    <div class="col-12 col-lg-7">
                        <div class="ductless-modal__info pe-lg-4">
                            {{-- Header Row: Brand & Series Badge --}}
                            <div class="d-flex align-items-center justify-content-between mb-2 mt-0 pe-5">
                                <span class="ductless-modal__brand">{{ $brandName }}</span>
                                <span class="ductless-modal__series-badge">{{ $seriesBadge }}</span>
                            </div>

                            {{-- Title & Subtitle --}}
                            <h2 class="ductless-modal__title" id="{{ $targetModalId }}Label">{{ $product->name }}</h2>
                            <h3 class="ductless-modal__subtitle">{{ $subtitle }}</h3>

                            {{-- Description --}}
                            <p class="ductless-modal__desc">
                                {{ $description }}
                            </p>

                            {{-- 4-Column Spec Highlights Box --}}
                            <div class="ductless-modal__specs-grid">
                                @if (!empty($showcase->spec_highlights) && is_array($showcase->spec_highlights))
                                    @foreach ($showcase->spec_highlights as $spec)
                                        <div class="ductless-modal__spec-col">
                                            @if (!empty($spec['icon_svg']))
                                                {!! $spec['icon_svg'] !!}
                                            @else
                                                <i class="bi {{ $spec['icon'] ?? 'bi-gear' }}"
                                                    style="font-size: 20px; color: #334155;"></i>
                                            @endif

                                            @if (!empty($spec['value']))
                                                <span class="ductless-modal__spec-label">{!! $spec['label'] ?? '' !!}</span>
                                                <span class="ductless-modal__spec-value">{{ $spec['value'] }}</span>
                                            @else
                                                <span
                                                    class="ductless-modal__spec-single-text">{{ $spec['label'] ?? '' }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Default 4 Specs --}}
                                    {{-- Spec 1: PM2.5 Filtration --}}
                                    <div class="ductless-modal__spec-col">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14 5L21 12M21 12L14 19M21 12H3" stroke="#334155"
                                                stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span class="ductless-modal__spec-single-text">PM2.5 Filtration</span>
                                    </div>

                                    {{-- Spec 2: Heat Recovery Efficiency --}}
                                    <div class="ductless-modal__spec-col">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4 4.00001V9.00001H4.582M19.938 11C19.4832 7.38614 16.6448 4.53557 13.033 4.06515C9.4211 3.59473 5.94733 5.62321 4.582 9.00001M4.582 9.00001H9M20 20V15H19.419M19.419 15C18.0518 18.3747 14.5788 20.4011 10.9681 19.9309C7.35742 19.4607 4.5193 16.6123 4.062 13M19.419 15H15"
                                                stroke="#334155" stroke-width="1.6" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="ductless-modal__spec-label">Heat Recovery<br>Efficiency</span>
                                        <span class="ductless-modal__spec-value">60%</span>
                                    </div>

                                    {{-- Spec 3: Power Consumption --}}
                                    <div class="ductless-modal__spec-col">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13 10V3L4 14H11V21L20 10H13V10" stroke="#334155"
                                                stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span class="ductless-modal__spec-label">Power<br>Consumption</span>
                                        <span class="ductless-modal__spec-value">7 – 31 W</span>
                                    </div>

                                    {{-- Spec 4: Colour --}}
                                    <div class="ductless-modal__spec-col">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3 12C3 16.9672 7.03276 21 12 21C16.9672 21 21 16.9672 21 12C21 7.03276 16.9672 3 12 3C7.03276 3 3 7.03276 3 12V12"
                                                stroke="#334155" stroke-width="1.6" />
                                            <path
                                                d="M7 8.5C7 9.32787 7.67213 10 8.5 10C9.32787 10 10 9.32787 10 8.5C10 7.67213 9.32787 7 8.5 7C7.67213 7 7 7.67213 7 8.5V8.5"
                                                stroke="#334155" />
                                            <path
                                                d="M14 8.5C14 9.32787 14.6721 10 15.5 10C16.3279 10 17 9.32787 17 8.5C17 7.67213 16.3279 7 15.5 7C14.6721 7 14 7.67213 14 8.5V8.5"
                                                stroke="#334155" />
                                            <path
                                                d="M10.5 15.5C10.5 16.3279 11.1721 17 12 17C12.8279 17 13.5 16.3279 13.5 15.5C13.5 14.6721 12.8279 14 12 14C11.1721 14 10.5 14.6721 10.5 15.5V15.5"
                                                stroke="#334155" />
                                        </svg>
                                        <span class="ductless-modal__spec-label">Colour</span>
                                        <span class="ductless-modal__spec-value">White</span>
                                    </div>
                                @endif
                            </div>

                            {{-- "Matched to your needs" Section --}}
                            <div class="ductless-modal__matched-section">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="ductless-modal__matched-title">Matched to your needs</span>
                                    <span class="ductless-modal__matched-sub">Based on your selected filters</span>
                                </div>

                                <div class="ductless-modal__pill-wrap">
                                    @if (!empty($showcase->matched_features) && is_array($showcase->matched_features))
                                        @foreach ($showcase->matched_features as $item)
                                            <div class="ductless-modal__pill">
                                                <i class="bi {{ $item['icon'] ?? 'bi-check2' }}"></i>
                                                <span>{{ $item['text'] ?? $item }}</span>
                                                <span class="ductless-modal__check"><i
                                                        class="bi bi-check-lg"></i></span>
                                            </div>
                                        @endforeach
                                    @else
                                        {{-- Default 7 Checklist Items --}}
                                        <div class="ductless-modal__pill">
                                            <i class="bi bi-house"></i>
                                            <span>Residential</span>
                                            <span class="ductless-modal__check"><i class="bi bi-check-lg"></i></span>
                                        </div>

                                        <div class="ductless-modal__pill">
                                            <i class="bi bi-arrows-angle-expand"></i>
                                            <span>200 – 500 sq ft</span>
                                            <span class="ductless-modal__check"><i class="bi bi-check-lg"></i></span>
                                        </div>

                                        <div class="ductless-modal__pill">
                                            <i class="bi bi-arrow-right"></i>
                                            <span>Fresh Air &amp; Ventilation</span>
                                            <span class="ductless-modal__check"><i class="bi bi-check-lg"></i></span>
                                        </div>

                                        <div class="ductless-modal__pill">
                                            <i class="bi bi-layout-sidebar"></i>
                                            <span>Single Room</span>
                                            <span class="ductless-modal__check"><i class="bi bi-check-lg"></i></span>
                                        </div>

                                        <div class="ductless-modal__pill">
                                            <i class="bi bi-square"></i>
                                            <span>Wall Mounted</span>
                                            <span class="ductless-modal__check"><i class="bi bi-check-lg"></i></span>
                                        </div>

                                        <div class="ductless-modal__pill">
                                            <i class="bi bi-arrow-repeat"></i>
                                            <span>Heat Recovery</span>
                                            <span class="ductless-modal__check"><i class="bi bi-check-lg"></i></span>
                                        </div>

                                        <div class="ductless-modal__pill">
                                            <i class="bi bi-shield-check"></i>
                                            <span>HEPA / PM2.5 Filtration</span>
                                            <span class="ductless-modal__check"><i class="bi bi-check-lg"></i></span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bottom Footer Row: Health Highlights & CTA Buttons --}}
                <div class="ductless-modal__footer">
                    {{-- Left: Health Concern Tags --}}
                    <div class="ductless-modal__health-tags">
                        @if (!empty($showcase->health_tags) && is_array($showcase->health_tags))
                            @foreach ($showcase->health_tags as $htag)
                                <span class="ductless-modal__health-tag">
                                    <i class="bi {{ $htag['icon'] ?? 'bi-check-circle' }}"></i>
                                    {{ $htag['text'] ?? $htag }}
                                </span>
                            @endforeach
                        @else
                            <span class="ductless-modal__health-tag">
                                <i class="bi bi-arrow-right"></i> Allergies &amp; Dust
                            </span>
                            <span class="ductless-modal__health-tag">
                                <i class="bi bi-file-earmark-medical"></i> Asthma
                            </span>
                            <span class="ductless-modal__health-tag">
                                <i class="bi bi-house-door"></i> Mold &amp; Fog Window
                            </span>
                            <span class="ductless-modal__health-tag">
                                <i class="bi bi-grid-3x3"></i> Pets &amp; Odor
                            </span>
                            <span class="ductless-modal__health-tag">
                                <i class="bi bi-arrow-right"></i> Smoke &amp; Wildfire
                            </span>
                            <span class="ductless-modal__health-tag">
                                <i class="bi bi-diagram-3"></i> VOCs
                            </span>
                        @endif
                    </div>

                    {{-- Right: CTA Buttons --}}
                    <div class="ductless-modal__cta-wrap">
                        <a href="{{ $productUrl }}" class="ductless-modal__btn-view">
                            View Product
                        </a>
                        <button type="button"
                            class="ductless-modal__btn-compare btn-add-to-compare {{ $inCompare ? 'active' : '' }}"
                            data-product-id="{{ $product->id ?? '' }}"
                            title="{{ $inCompare ? 'In Compare' : 'Compare' }}">
                            {{ $inCompare ? 'In Compare' : 'Compare' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
