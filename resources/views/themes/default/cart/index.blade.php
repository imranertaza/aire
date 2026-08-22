@extends('themes.default.layouts.master')

@section('title', 'Shopping Cart | Aire')
@push('styles')
    <link href="{{ theme_asset('css/cart.css') }}" rel="stylesheet">
@endpush
@section('content')
    <!-- Main Content -->
    <main class="">
        <h1 class="d-none">Shopping Cart</h1>
        <div class="container main-container border-top border-light">
            <div class="row g-0">
                <div class="col-lg-3 border-right1px pt-4 pe-lg-4">

                    <!-- Breadcrumb -->
                    <div class="cart-breadcrumb text-muted fs-13 mb-4">
                        <a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a> &nbsp;&gt;&nbsp; <span
                            class="text-dark fw-bold">My Basket</span>
                    </div>
                </div>
                <!-- MAIN COLUMN: Breadcrumb, Basket, Saved for Later, Trust Features (col-lg-8) -->
                <div class="col-lg-6 pt-3 px-lg-4 center-feed">


                    <!-- Page Title -->
                    <h1 class="fw-bold text-dark mb-4 title-2">My Basket</h1>

                    <!-- Table Header -->
                    <div
                        class="cart-table-header d-none d-lg-flex justify-content-between align-items-center pb-2 mb-3 border-bottom text-muted fw-bold fs-12 tracking-wider">
                        <div class="cart-col-prod">PRODUCT</div>
                        <div class="cart-col-quantity text-center">QUANTITY</div>
                        <div class="cart-col-subtotal text-end">TOTAL</div>
                    </div>

                    <!-- Dynamic Cart Items -->
                    <div class="cart-items-wrapper">
                        @forelse($cart as $id => $item)
                            <!-- Cart Item -->
                            <div class="cart-item-block d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between border-bottom py-3"
                                data-product-id="{{ $item['id'] }}">
                                <div class="cart-col-prod d-flex align-items-center gap-3 w-100">
                                    <div class="cart-img-wrapper">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                            class="img-fluid cart-item-img">
                                    </div>
                                    <div>
                                        <span class="cart-product-title">{{ $item['name'] }}</span>
                                        <p class="cart-product-description">{{ $item['model'] ?? 'AIRE System' }}</p>
                                        <div class="cart-product-price">${{ number_format($item['price'], 2) }}</div>
                                    </div>
                                </div>
                                <div class="cart-col-quantity w-100 mt-3 mt-lg-0">
                                    <div
                                        class="qty-action-column d-flex flex-row flex-lg-column align-items-center justify-content-between justify-content-lg-center gap-1">
                                        <a href="#"
                                            class="save-for-later-link text-decoration-none btn-save-later mb-1"
                                            data-product-id="{{ $item['id'] }}">Save for later</a>
                                        <div
                                            class="qty-counter-box border d-inline-flex align-items-center bg-white px-2 py-2 border-slate-300">
                                            <button type="button"
                                                class="qty-btn-sub border-0 bg-transparent px-2 btn-update-qty"
                                                data-action="decrease" data-product-id="{{ $item['id'] }}">-</button>
                                            <input type="number" class="qty-val-input border-0 text-center qty-input-val"
                                                value="{{ $item['quantity'] }}" min="1"
                                                data-product-id="{{ $item['id'] }}" readonly>
                                            <button type="button"
                                                class="qty-btn-add border-0 bg-transparent text-dark px-2 btn-update-qty"
                                                data-action="increase" data-product-id="{{ $item['id'] }}">+</button>
                                        </div>
                                        <button type="button"
                                            class="remove-link border-0 bg-transparent p-0 btn-remove-cart mt-1"
                                            data-product-id="{{ $item['id'] }}">Remove</button>
                                    </div>
                                </div>
                                <div
                                    class="cart-col-subtotal w-100 mt-3 mt-lg-0 text-lg-end d-flex justify-content-between justify-content-lg-end align-items-center">
                                    <span class="d-lg-none fw-bold fs-14 text-muted">Total:</span>
                                    <span class="total-price-text fw-bold text-dark fs-16"
                                        id="subtotal-{{ $item['id'] }}">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="py-5 text-center">
                                <i class="bi bi-cart-x fs-1 text-muted mb-3 d-block"></i>
                                <p class="text-muted fs-16">Your cart is currently empty.</p>
                            </div>
                        @endforelse
                    </div>


                    <!-- Continue Shopping Button -->
                    <div class="pt-4 pb-5 mb-3 border-bottom">
                        <a href="{{ route('products.filter') }}"
                            class="continue-shopping-link text-dark fw-bold text-decoration-none d-inline-flex align-items-center gap-2 fs-14">
                            <i class="bi bi-arrow-left"></i> Continue Shopping
                        </a>
                    </div>

                    <!-- Saved For Later Section -->
                    <div class="saved-later-block py-4">
                        <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between mb-4">
                            <div class="fw-bold text-dark mb-0 fs-18">Saved for Later <span
                                    class="text-muted fw-normal fs-14">(<span
                                        id="saved-item-count">{{ count($savedForLater) }}</span> items)</span></div>
                        </div>

                        <div class="row g-3 mb-5" id="saved-items-container">
                            @forelse($savedForLater as $id => $item)
                                <!-- Saved Item -->
                                <div class="col-md-6 saved-item-wrapper" data-product-id="{{ $item['id'] }}">
                                    <div class="saved-card-row d-flex align-items-center">
                                        <div class="saved-card-img-box d-flex align-items-center justify-content-center">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                class="img-fluid saved-item-img">
                                        </div>
                                        <div class="saved-card-content flex-grow-1">
                                            <span class="saved-card-title">{{ $item['name'] }}</span>
                                            <p class="saved-card-sub">{{ $item['model'] ?? 'AIRE System' }}</p>
                                            <div class="saved-actions-row d-flex align-items-center">
                                                <button type="button" class="btn-move-basket btn-move-to-cart"
                                                    data-product-id="{{ $item['id'] }}">MOVE TO BASKET</button>
                                                <button type="button" class="remove-link btn-remove-saved"
                                                    data-product-id="{{ $item['id'] }}">REMOVE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 py-3 text-center">
                                    <p class="text-muted fs-14">No saved items.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Trust Features Grid Section -->
                    <div class="trust-features-block pt-4 border-top mb-5 mb-lg-0">
                        <div class="row g-4 text-center justify-content-center">
                            <div class="col-6 col-md-3 trust-item text-center">
                                <div class="trust-item-icon mb-2 text-secondary fs-2"><i class="bi bi-shield-check"></i>
                                </div>
                                <span class="fw-extrabold text-dark fs-12 text-uppercase tracking-wider mb-1">SECURE
                                    PAYMENTS</span>
                                <p class="text-muted fs-12 mb-0 lh-sm">100% secure and encrypted.</p>
                            </div>
                            <div class="col-6 col-md-3 trust-item text-center">
                                <div class="trust-item-icon mb-2 text-secondary fs-2"><i class="bi bi-box-seam"></i>
                                </div>
                                <span class="fw-extrabold text-dark fs-12 text-uppercase tracking-wider mb-1">FREE
                                    SHIPPING</span>
                                <p class="text-muted fs-12 mb-0 lh-sm">On all orders over $150.</p>
                            </div>
                            <div class="col-6 col-md-3 trust-item text-center">
                                <div class="trust-item-icon mb-2 text-secondary fs-2"><i class="bi bi-arrow-repeat"></i>
                                </div>
                                <span class="fw-extrabold text-dark fs-12 text-uppercase tracking-wider mb-1">30-DAY
                                    RETURNS</span>
                                <p class="text-muted fs-12 mb-0 lh-sm">Hassle-free returns.</p>
                            </div>
                            <div class="col-6 col-md-3 trust-item text-center">
                                <div class="trust-item-icon mb-2 text-secondary fs-2"><i class="bi bi-clock-history"></i>
                                </div>
                                <span class="fw-extrabold text-dark fs-12 text-uppercase tracking-wider mb-1">1 YEAR
                                    WARRANTY</span>
                                <p class="text-muted fs-12 mb-0 lh-sm">Full protection.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Order Summary (col-lg-4) -->
                <div class="col-lg-3 border-left1px pt-4 ps-lg-4">
                    <div
                        class="order-summary-block sticky-lg-top bg-white p-4 rounded-4 shadow-sm border border-slate-200">
                        <div class="fw-bold text-dark mb-4 fs-18">Order Summary</div>

                        @php
                            $subtotal = collect($cart)->sum(function ($item) {
                                return $item['price'] * $item['quantity'];
                            });
                            $itemCount = collect($cart)->sum('quantity');
                            $discount = $discount ?? 0.0;
                            $finalTotal = max(0, $subtotal - $discount);
                        @endphp
                        <div class="d-flex justify-content-between align-items-center mb-3 fs-14">
                            <span class="text-secondary">Subtotal (<span id="cart-item-count">{{ $itemCount }}</span>
                                items)</span>
                            <span class="fw-bold text-dark subtotal-summary">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 fs-14 cart-discount-row"
                            style="{{ $discount > 0 ? '' : 'display: none !important;' }}">
                            <span class="text-secondary">Discount</span>
                            <span class="fw-bold text-danger cart-discount-val">-${{ number_format($discount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 fs-14">
                            <span class="text-secondary">Shipping <i
                                    class="bi bi-info-circle text-muted ms-1 cursor-pointer"
                                    title="Free shipping on qualifying orders"></i></span>
                            <span class="fw-bold text-dark">Free</span>
                        </div>

                        <!-- Promo code section -->
                        <div class="border-top pt-4 mb-4" id="promoBanner">
                            @if (session()->has('applied_coupon'))
                                {{-- Applied coupon banner --}}
                                <div class="d-flex align-items-center justify-content-between gap-2 rounded-3 px-3 py-2"
                                    id="appliedCouponBanner"
                                    style="background: var(--color-primary-bg); border: 1.5px solid var(--color-primary-light);">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-tag-fill fs-15" style="color: var(--color-primary);"></i>
                                        <div>
                                            <span class="fw-bold fs-14"
                                                style="color: var(--color-primary);">{{ strtoupper(session('applied_coupon')->code) }}</span>
                                            <p class="mb-0 fs-12 text-muted">Coupon applied — saving $<span
                                                    class="coupon-saved-val">{{ number_format($discount, 2) }}</span></p>
                                        </div>
                                    </div>
                                    <button type="button" id="btnRemoveCoupon"
                                        class="btn btn-link p-0 fs-13 fw-semibold text-decoration-none"
                                        style="color: var(--color-primary-hover);">
                                        <i class="bi bi-x-circle me-1"></i>Remove
                                    </button>
                                </div>
                            @else
                                {{-- Promo code collapse input --}}
                                <div id="promoInputWrapper">
                                    <a class="text-decoration-none fw-semibold fs-14 text-dark d-flex justify-content-between align-items-center"
                                        data-bs-toggle="collapse" href="#promoCodeCollapse" role="button"
                                        aria-expanded="false" aria-controls="promoCodeCollapse">
                                        Do you have a promo code?
                                        <i class="bi bi-chevron-down text-muted"></i>
                                    </a>
                                    <div class="collapse mt-3" id="promoCodeCollapse">
                                        <div class="input-group">
                                            <input type="text" class="form-control fs-14 shadow-none"
                                                id="promoCodeInput" placeholder="Enter code">
                                            <button class="btn btn-dark fw-semibold fs-14 px-3" type="button"
                                                id="btnApplyPromo">Apply</button>
                                        </div>
                                        <div id="promoFeedback" class="mt-2 fs-13 fw-semibold"></div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top mb-4">
                            <span class="fw-bold fs-16">Estimated Total</span>
                            <span class="fw-bolder fs-24 total-summary">${{ number_format($finalTotal, 2) }}</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column gap-2 mb-3">
                            <a href="{{ route('checkout') }}"
                                class="btn btn-checkout w-100 py-3 rounded-3 fw-bold text-white fs-15 shadow-sm text-decoration-none text-center">Proceed
                                to Checkout</a>

                        </div>

                        <!-- Secure Packaging Box -->
                        <div class="secure-packaging-note rounded-3 p-3 d-flex align-items-start gap-3 mt-4">
                            <i class="bi bi-box-seam fs-5 text-secondary mt-1"></i>
                            <div>
                                <span class="fw-bold text-dark mb-1 fs-13">Secure Packaging</span>
                                <p class="text-muted fs-12 mb-0 lh-base">Your products are carefully packed to
                                    ensure
                                    safe delivery.</p>
                            </div>
                        </div>

                        <!-- 100% Guarantee -->
                        <div class="guarantee-text text-center text-muted fs-12 fw-semibold mt-4">
                            <i class="bi bi-check-circle-fill text-primary me-1"></i> 100% Secure Checkout
                            Guaranteed
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

@endsection
@push('scripts')
    <script src="{{ theme_asset('js/cart.js') }}" defer></script>
@endpush
