@extends('themes.default.layouts.master')

@section('title', 'Checkout | Aire')
@push('styles')
    <link href="{{ theme_asset('css/checkout.css') }}" rel="stylesheet">
@endpush
@section('content')
    <main class="">
        <h1 class="d-none">Checkout</h1>
        <div class="container main-container border-top border-light">
            <div class="row g-0">

                <!-- LEFT COLUMN: Order Summary & Breadcrumb Sidebar -->
                <div class="col-lg-3 border-right1px pe-lg-4">
                    <div class="summary-sidebar sticky-lg-top" style="top: 100px;">

                        <!-- Breadcrumb -->
                        <div class="cart-breadcrumb text-muted fs-13 mb-4">
                            <a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a> &nbsp;&gt;&nbsp;
                            <span class="text-dark fw-bold">Checkout</span>
                        </div>

                        <!-- Order Summary Card Header -->
                        <div class="d-flex justify-content-between align-items-baseline mb-4">
                            <h2 class="fs-20 fw-bold text-dark m-0">Order Summary</h2>
                            <a href="{{ route('cart') }}" class="text-decoration-underline fs-14 fw-medium text-dark">Edit
                                Cart</a>
                        </div>

                        @php
                            $subtotal = collect($cart)->sum(function ($item) {
                                return $item['price'] * $item['quantity'];
                            });
                        @endphp

                        <!-- Product Items List -->
                        <div class="checkout-items-list">
                            @foreach ($cart as $id => $item)
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="border rounded-3 p-2 d-flex align-items-center justify-content-center bg-white"
                                        style="width: 80px; height: 80px; border-color: #e5e7eb !important;">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-fluid"
                                            style="max-height: 60px; object-fit: contain;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fs-15 fw-semibold text-dark mb-1 d-block text-truncate"
                                            style="max-width: 150px;">{{ $item['name'] }}</span>
                                        <p class="fs-13 text-muted mb-1">{{ $item['model'] ?? 'AIRE System' }}</p>
                                        <div class="d-flex justify-content-between align-items-center fs-14">
                                            <span class="text-muted">Qty: {{ $item['quantity'] }}</span>
                                            <span
                                                class="fw-semibold text-dark">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr class="my-4" style="border-color: #e5e7eb; opacity: 1;">

                        <!-- Totals Breakdown -->
                        <div class="d-flex justify-content-between align-items-center mb-3 fs-15">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-medium text-dark">$<span
                                    class="checkout-subtotal-val">{{ number_format($subtotal, 2) }}</span></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 fs-15">
                            <span class="text-muted">Shipping</span>
                            <span class="fw-semibold text-dark"><span class="checkout-shipping-val">Free</span></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 fs-15 checkout-discount-row"
                            style="display: {{ $discount > 0 ? 'flex' : 'none' }} !important;">
                            <span class="text-muted">Discount</span>
                            <span class="fw-semibold text-danger">-$<span
                                    class="checkout-discount-val">{{ number_format($discount, 2) }}</span></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 fs-15">
                            <span class="text-muted">Tax</span>
                            <span class="text-dark">—</span>
                        </div>

                        <hr class="my-4" style="border-color: #e5e5e5; opacity: 1;">

                        <!-- Final Total -->
                        <div class="d-flex justify-content-between align-items-center fs-16 mb-4">
                            <span class="fw-medium text-dark">Total</span>
                            <span class="fs-18 fw-bold text-dark">$<span
                                    class="checkout-total-val">{{ number_format($subtotal - $discount, 2) }}</span></span>
                        </div>

                        <!-- Live Ship To Summary Box (Reference Feature) -->
                        <div class="ship-to-card bg-light p-3 rounded-3 border mb-4">
                            <div
                                class="d-flex align-items-center gap-2 fw-bold fs-13 text-dark mb-2 text-uppercase letter-spacing-1">
                                <i class="bi bi-truck text-primary fs-15"></i> Ship To Summary
                            </div>
                            <div class="fs-13 lh-sm">
                                <p class="fw-semibold text-dark mb-2 fs-14" id="liveShipName">
                                    {{ $customer ? $customer->firstname . ' ' . $customer->lastname : 'First & Last Name' }}
                                </p>
                                <table class="table table-borderless table-sm mb-0 fs-13 text-muted">
                                    <tr>
                                        <td width="80" class="ps-0 py-1 text-dark fw-medium">Country:</td>
                                        <td class="py-1" id="liveShipCountry">—</td>
                                    </tr>
                                    <tr>
                                        <td width="80" class="ps-0 py-1 text-dark fw-medium">District:</td>
                                        <td class="py-1" id="liveShipDistrict">—</td>
                                    </tr>
                                    <tr>
                                        <td width="80" class="ps-0 py-1 text-dark fw-medium">Address 1:</td>
                                        <td class="py-1" id="liveShipAddr1">{{ $customer ? $customer->address : '—' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="80" class="ps-0 py-1 text-dark fw-medium">Address 2:</td>
                                        <td class="py-1" id="liveShipAddr2">—</td>
                                    </tr>
                                    <tr>
                                        <td width="80" class="ps-0 py-1 text-dark fw-medium">Contact:</td>
                                        <td class="py-1" id="liveShipPhone">{{ $customer ? $customer->phone : '—' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Promo code section -->
                        <div class="border-top pt-4" id="promoBanner">
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
                                            <p class="mb-0 fs-12 text-muted">Coupon applied — saving
                                                ${{ number_format($discount, 2) }}</p>
                                        </div>
                                    </div>
                                    <button type="button" id="btnRemoveCoupon"
                                        class="btn btn-link p-0 fs-13 fw-semibold text-decoration-none"
                                        style="color: var(--color-primary-hover);">
                                        <i class="bi bi-x-circle me-1"></i>Remove
                                    </button>
                                </div>
                            @else
                                {{-- Promo code input form --}}
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

                    </div>
                </div>

                <!-- MAIN COLUMN: Forms -->
                <div class="col-lg-6 px-lg-4 center-feed">

                    <!-- Checkout Progress Stepper -->
                    <div class="checkout-stepper d-flex align-items-center justify-content-between my-3 mb-5">
                        <!-- Step 1: Cart -->
                        <div class="text-center position-relative">
                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center mx-auto mb-2 fw-bold"
                                style="width: 38px; height: 38px; background-color: #2563eb;">1</div>
                            <span class="fs-13 fw-semibold text-dark">Cart</span>
                        </div>

                        <!-- Connecting Line 1-2 -->
                        <div class="flex-grow-1 mx-3" style="height: 2px; background-color: #2563eb; margin-top: -5%;">
                        </div>

                        <!-- Step 2: Checkout -->
                        <div class="text-center position-relative">
                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center mx-auto mb-2 fw-bold"
                                style="width: 38px; height: 38px; background-color: #2563eb;">2</div>
                            <span class="fs-13 fw-semibold text-dark">Checkout</span>
                        </div>

                        <!-- Connecting Line 2-3 -->
                        <div class="flex-grow-1 mx-3" style="height: 2px; background-color: #e5e7eb; margin-top: -5%;">
                        </div>

                        <!-- Step 3: Confirmation -->
                        <div class="text-center position-relative">
                            <div class="rounded-circle text-secondary d-flex align-items-center justify-content-center mx-auto mb-2 fw-bold"
                                style="width: 38px; height: 38px; background-color: #e5e7eb;">3</div>
                            <span class="fs-13 fw-semibold text-muted">Confirmation</span>
                        </div>
                    </div>

                    <form action="{{ route('checkout.post') }}" method="POST" id="checkout-form">
                        @csrf

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger py-2 px-3 mb-4 rounded-3 fs-13">
                                <ul class="mb-0 list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="bi bi-exclamation-circle-fill me-1"></i> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- 1. Contact Information -->
                        <div class="d-flex align-items-center gap-2 mb-3 mt-3">
                            <span class="step-badge">1</span>
                            <h2 class="title-2 mb-0">Contact Information</h2>
                        </div>

                        <div class="checkout-card mb-5 bg-white rounded-3 p-4 border">
                            <div class="mb-3">
                                <label for="emailInput" class="form-label fs-13 fw-semibold text-dark mb-1">Email Address
                                    *</label>
                                <input type="email" id="emailInput" name="email"
                                    class="form-control p-3 fs-14 border rounded-3" placeholder="john.doe@example.com"
                                    value="{{ old('email', $customer ? $customer->email : '') }}" required>
                            </div>

                            @if (!\Illuminate\Support\Facades\Auth::guard('customer')->check())
                                {{-- Guest Account Creation Checkbox (Reference Feature) --}}
                                <div class="form-check mt-3">
                                    <input type="checkbox" id="createNewAccount" name="new_acc_create" value="1"
                                        class="form-check-input custom-check-input">
                                    <label for="createNewAccount" class="form-check-label fs-14 text-dark ms-1">
                                        Check Mark the box to create an account
                                    </label>
                                </div>
                                <div class="row g-3 mt-1" id="accountPasswordFields" style="display: none;">
                                    <div class="col-md-6">
                                        <label for="accPassword"
                                            class="form-label fs-13 fw-semibold text-dark mb-1">Password *</label>
                                        <input type="password" id="accPassword" name="password"
                                            class="form-control p-3 fs-14 border rounded-3" placeholder="Password"
                                            autocomplete="new-password">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="accConfirmPassword"
                                            class="form-label fs-13 fw-semibold text-dark mb-1">Confirm Password *</label>
                                        <input type="password" id="accConfirmPassword" name="confirm_password"
                                            class="form-control p-3 fs-14 border rounded-3" placeholder="Confirm Password"
                                            autocomplete="new-password">
                                    </div>
                                </div>
                            @endif

                            <div class="form-check mt-3">
                                <input type="checkbox" id="newsCheckbox" class="form-check-input custom-check-input">
                                <label for="newsCheckbox" class="form-check-label fs-14 text-dark ms-1">
                                    Keep me updated on news and exclusive offers
                                </label>
                            </div>
                        </div>

                        <!-- 2. Billing & Shipping Address -->
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="step-badge">2</span>
                            <h2 class="title-2 mb-0">Billing & Address Information</h2>
                        </div>
                        <div class="checkout-card mb-4 bg-white rounded-3 p-4 border">
                            <div class="row g-3">
                                <!-- First Name & Last Name -->
                                <div class="col-md-6">
                                    <label for="fname1" class="form-label fs-13 fw-semibold text-dark mb-1">First Name
                                        *</label>
                                    <input type="text" id="fname1" name="payment_firstname"
                                        class="form-control p-3 fs-14 border rounded-3 ship-live-trigger"
                                        placeholder="First Name"
                                        value="{{ old('payment_firstname', $customer ? $customer->firstname : '') }}"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="lname1" class="form-label fs-13 fw-semibold text-dark mb-1">Last Name
                                        *</label>
                                    <input type="text" id="lname1" name="payment_lastname"
                                        class="form-control p-3 fs-14 border rounded-3 ship-live-trigger"
                                        placeholder="Last Name"
                                        value="{{ old('payment_lastname', $customer ? $customer->lastname : '') }}"
                                        required>
                                </div>

                                <!-- Phone Number -->
                                <div class="col-md-12">
                                    <label for="phone" class="form-label fs-13 fw-semibold text-dark mb-1">Phone Number
                                        *</label>
                                    <input type="text" id="phone" name="phone"
                                        class="form-control p-3 fs-14 border rounded-3 ship-live-trigger"
                                        placeholder="+1 (888) 123-4567"
                                        value="{{ old('phone', $customer ? $customer->phone : '') }}" required>
                                </div>

                                <!-- Country & District (Reference Feature) -->
                                <div class="col-md-6">
                                    <label for="countryName1" class="form-label fs-13 fw-semibold text-dark mb-1">Country
                                        *</label>
                                    <select id="countryName1" name="payment_country_id"
                                        class="form-select p-3 fs-14 border rounded-3 ship-live-trigger" required>
                                        <option value="">Please select country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('payment_country_id', 18) == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="stateView" class="form-label fs-13 fw-semibold text-dark mb-1">District
                                        *</label>
                                    <select id="stateView" name="payment_city"
                                        class="form-select p-3 fs-14 border rounded-3 ship-live-trigger" required>
                                        <option value="">Please select district</option>
                                    </select>
                                </div>

                                <!-- Postcode -->
                                <div class="col-md-12">
                                    <label for="zip" class="form-label fs-13 fw-semibold text-dark mb-1">Postcode /
                                        Zip *</label>
                                    <input type="text" id="zip" name="zip"
                                        class="form-control p-3 fs-14 border rounded-3 ship-live-trigger"
                                        placeholder="78701" value="{{ old('zip') }}" required>
                                </div>

                                <!-- Address Line 1 & Line 2 -->
                                <div class="col-md-12">
                                    <label for="addr1" class="form-label fs-13 fw-semibold text-dark mb-1">Address Line
                                        1 *</label>
                                    <input type="text" id="addr1" name="address_1"
                                        class="form-control p-3 fs-14 border rounded-3 ship-live-trigger"
                                        placeholder="123 Air Purifier Way"
                                        value="{{ old('address_1', $customer ? $customer->address : '') }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="addr2" class="form-label fs-13 fw-semibold text-dark mb-1">Address Line
                                        2 (Optional)</label>
                                    <input type="text" id="addr2" name="address_2"
                                        class="form-control p-3 fs-14 border rounded-3 ship-live-trigger"
                                        placeholder="Apartment, suite, unit etc." value="{{ old('address_2') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Separate Shipping Address Checkbox (Reference Feature) -->
                        <div class="form-check mb-4 ms-1">
                            <input type="checkbox" id="shippingElseCheckbox" name="shipping_else" value="1"
                                class="form-check-input custom-check-input">
                            <label for="shippingElseCheckbox" class="form-check-label fs-14 fw-semibold text-dark ms-1">
                                Product shipping address elsewhere?
                            </label>
                        </div>

                        <!-- Separate Shipping Address Fields -->
                        <div id="differentShippingAddressBlock" style="display: none;"
                            class="checkout-card mb-5 bg-white rounded-3 p-4 border">
                            <h5 class="fs-16 fw-bold text-dark mb-3">Shipping Address</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="shipFname" class="form-label fs-13 fw-semibold text-dark mb-1">First Name
                                        *</label>
                                    <input type="text" id="shipFname" name="shipping_firstname"
                                        class="form-control p-3 fs-14 border rounded-3 ship-live-trigger"
                                        placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <label for="shipLname" class="form-label fs-13 fw-semibold text-dark mb-1">Last Name
                                        *</label>
                                    <input type="text" id="shipLname" name="shipping_lastname"
                                        class="form-control p-3 fs-14 border rounded-3 ship-live-trigger"
                                        placeholder="Last Name">
                                </div>
                                <div class="col-md-12">
                                    <label for="shipPhone" class="form-label fs-13 fw-semibold text-dark mb-1">Phone
                                        Number *</label>
                                    <input type="text" id="shipPhone" name="shipping_phone"
                                        class="form-control p-3 fs-14 border rounded-3 ship-live-trigger"
                                        placeholder="Phone Number">
                                </div>
                                <div class="col-md-6">
                                    <label for="sh_countryName"
                                        class="form-label fs-13 fw-semibold text-dark mb-1">Country *</label>
                                    <select id="sh_countryName" name="shipping_country_id"
                                        class="form-select p-3 fs-14 border rounded-3 ship-live-trigger">
                                        <option value="">Please select country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ $country->id == 18 ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="sh_stateView" class="form-label fs-13 fw-semibold text-dark mb-1">District
                                        *</label>
                                    <select id="sh_stateView" name="shipping_city"
                                        class="form-select p-3 fs-14 border rounded-3 ship-live-trigger">
                                        <option value="">Please select district</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="shipZip" class="form-label fs-13 fw-semibold text-dark mb-1">Postcode /
                                        Zip *</label>
                                    <input type="text" id="shipZip" name="shipping_postcode"
                                        class="form-control p-3 fs-14 border rounded-3 ship-live-trigger"
                                        placeholder="Zip Code">
                                </div>
                                <div class="col-md-12">
                                    <label for="shipAddr1" class="form-label fs-13 fw-semibold text-dark mb-1">Address
                                        Line 1 *</label>
                                    <input type="text" id="shipAddr1" name="shipping_address_1"
                                        class="form-control p-3 fs-14 border rounded-3 ship-live-trigger"
                                        placeholder="Address Line 1">
                                </div>
                                <div class="col-md-12">
                                    <label for="shipAddr2" class="form-label fs-13 fw-semibold text-dark mb-1">Address
                                        Line 2 (Optional)</label>
                                    <input type="text" id="shipAddr2" name="shipping_address_2"
                                        class="form-control p-3 fs-14 border rounded-3 ship-live-trigger"
                                        placeholder="Address Line 2">
                                </div>
                            </div>
                        </div>

                        <!-- 3. Shipping Method -->
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="step-badge">3</span>
                            <h2 class="title-2 mb-0">Shipping Method</h2>
                        </div>
                        <div class="checkout-card mb-5 bg-white rounded-3 overflow-hidden border">
                            @foreach ($shippingMethods as $index => $method)
                                <label
                                    class="shipping-method-option d-flex align-items-center justify-content-between border-bottom cursor-pointer m-0 {{ $index === count($shippingMethods) - 1 ? 'border-bottom-0' : '' }}">
                                    <span class="d-flex align-items-center gap-3">
                                        <input type="radio" name="shippingMethod" value="{{ $method->code }}"
                                            data-cost="{{ $method->cost }}" {{ $index === 0 ? 'checked' : '' }}
                                            class="d-none custom-radio-input">
                                        <span class="custom-radio-circle">
                                            <span class="radio-inner-dot"></span>
                                        </span>
                                        <span class="d-block">
                                            <span
                                                class="d-block fs-15 fw-semibold text-dark mb-1">{{ $method->name }}</span>
                                            <span class="d-block fs-13 text-muted">{{ $method->description }}</span>
                                        </span>
                                    </span>
                                    <span class="fs-15 fw-semibold text-dark shipping-cost-label"
                                        data-code="{{ $method->code }}">
                                        {{ $method->cost > 0 ? '$' . number_format($method->cost, 2) : 'Free' }}
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <!-- 4. Payment Method -->
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="step-badge">4</span>
                            <h2 class="title-2 mb-0">Payment Method</h2>
                        </div>
                        <div class="checkout-card mb-5 bg-white rounded-3 p-4 border">
                            <input type="hidden" name="payment_method" id="selectedPaymentMethod"
                                value="{{ $paymentMethods->first()?->name ?? 'Credit Card' }}">

                            @if ($paymentMethods->isEmpty())
                                {{-- Fallback if no payment methods in DB --}}
                                <div class="row g-2 mb-4">
                                    <div class="col-4">
                                        <button type="button"
                                            class="btn payment-opt-btn active d-flex align-items-center justify-content-center gap-2 w-100"
                                            data-value="Credit Card" data-requires-card="1">
                                            <i class="bi bi-credit-card"></i> Credit Card
                                        </button>
                                    </div>
                                </div>
                            @else
                                {{-- Dynamic Payment Method Tabs --}}
                                @php $colClass = $paymentMethods->count() <= 2 ? 'col-6' : ($paymentMethods->count() >= 4 ? 'col-3' : 'col-4'); @endphp
                                <div class="row g-2 mb-4">
                                    @foreach ($paymentMethods as $index => $method)
                                        @php
                                            $isCard = str_contains(strtolower($method->code ?? $method->name), 'card');
                                            $icon = match (strtolower($method->code ?? '')) {
                                                'cod', 'cash_on_delivery' => 'bi-cash-coin',
                                                'bank', 'bank_transfer' => 'bi-bank',
                                                'paypal' => 'bi-paypal',
                                                default => 'bi-credit-card',
                                            };
                                        @endphp
                                        <div class="{{ $colClass }}">
                                            <button type="button"
                                                class="btn payment-opt-btn d-flex align-items-center justify-content-center gap-2 w-100 {{ $index === 0 ? 'active' : '' }}"
                                                data-value="{{ $method->name }}"
                                                data-requires-card="{{ $isCard ? '1' : '0' }}">
                                                @if ($method->image)
                                                    <img src="{{ getImageUrl($method->image) }}"
                                                        alt="{{ $method->name }}"
                                                        style="max-width: 100%; max-height: 24px; object-fit: contain;">
                                                @else
                                                    <i class="bi {{ $icon }}"></i>
                                                    <span
                                                        class="text-truncate fs-13 fw-semibold">{{ $method->name }}</span>
                                                @endif
                                            </button>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Payment instructions / info panels --}}
                                @foreach ($paymentMethods as $index => $method)
                                    @php
                                        $isCard = str_contains(strtolower($method->code ?? $method->name), 'card');
                                        $instruction = $method->settings['instruction'] ?? null;
                                    @endphp
                                    @if (!$isCard && $instruction)
                                        <div class="payment-info-panel rounded-3 p-3 mb-3 fs-14 text-muted border"
                                            id="info-{{ \Illuminate\Support\Str::slug($method->name) }}"
                                            style="display: {{ $index === 0 ? 'block' : 'none' }}; background: var(--color-bg-alt);">
                                            <i class="bi bi-info-circle me-2" style="color: var(--color-primary);"></i>
                                            {!! $instruction !!}
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            {{-- Credit Card Form Fields (shown only when card-type method selected) --}}
                            @php
                                $firstIsCard = $paymentMethods->isNotEmpty()
                                    ? str_contains(
                                        strtolower($paymentMethods->first()->code ?? $paymentMethods->first()->name),
                                        'card',
                                    )
                                    : true;
                            @endphp
                            <div class="row g-3" id="ccFormFields" style="{{ $firstIsCard ? '' : 'display:none;' }}">
                                <div class="col-12">
                                    <label for="ccName" class="form-label fs-13 fw-semibold text-dark mb-1">Card Name
                                        *</label>
                                    <input type="text" id="ccName" name="card_name"
                                        class="form-control p-3 fs-14 border rounded-3" placeholder="Cardholder Name">
                                </div>
                                <div class="col-12">
                                    <label for="ccNum" class="form-label fs-13 fw-semibold text-dark mb-1">Card Number
                                        *</label>
                                    <div class="position-relative">
                                        <input type="text" id="ccNum" name="card_number"
                                            class="form-control p-3 pe-5 fs-14 border rounded-3"
                                            placeholder="1234  5678  9012  3456">
                                        <i class="bi bi-lock input-lock-icon"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="ccExp" class="form-label fs-13 fw-semibold text-dark mb-1">Expiration
                                        Date *</label>
                                    <input type="text" id="ccExp" name="card_expiration"
                                        class="form-control p-3 fs-14 border rounded-3" placeholder="MM / YY">
                                </div>
                                <div class="col-6">
                                    <label for="ccCvv" class="form-label fs-13 fw-semibold text-dark mb-1">CVV
                                        *</label>
                                    <input type="text" id="ccCvv" name="card_cvc"
                                        class="form-control p-3 fs-14 border rounded-3" placeholder="123">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center text-lg-start mb-5">
                            <button type="submit"
                                class="btn btn-primary p-3 px-5 rounded-2 fw-semibold w-100 fs-16 text-white border-0">
                                Complete Purchase — $<span
                                    class="checkout-total-btn-val">{{ number_format($subtotal, 2) }}</span> <i
                                    class="bi bi-arrow-right ms-2"></i>
                            </button>
                            <p class="text-center text-muted mt-3" style="font-size: 13px;">By placing your
                                order, you agree to our Terms of Service and Privacy Policy.</p>
                        </div>
                    </form>
                </div>

                <!-- RIGHT COLUMN: Guarantees & Support Sidebar -->
                <div class="col-lg-3 border-left1px ps-lg-4">
                    <div class="right-sidebar sticky-lg-top" style="top: 100px;">

                        <!-- Trust Feature 1: Secure Checkout -->
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="rounded-3 p-2 d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 44px; height: 44px; background-color: #eff6ff; color: #2563eb;">
                                <i class="bi bi-shield-check fs-5"></i>
                            </div>
                            <div>
                                <span class="fs-15 fw-semibold text-dark mb-1">Secure Checkout</span>
                                <p class="fs-13 text-muted mb-0 lh-sm">Your payment information is encrypted and safe.</p>
                            </div>
                        </div>

                        <!-- Trust Feature 2: 30-Day Returns -->
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="rounded-3 p-2 d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 44px; height: 44px; background-color: #eff6ff; color: #2563eb;">
                                <i class="bi bi-arrow-counterclockwise fs-5"></i>
                            </div>
                            <div>
                                <span class="fs-15 fw-semibold text-dark mb-1">30-Day Returns</span>
                                <p class="fs-13 text-muted mb-0 lh-sm">Not satisfied? Return within 30 days for a full
                                    refund.</p>
                            </div>
                        </div>

                        <!-- Trust Feature 3: 1 Year Warranty -->
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="rounded-3 p-2 d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 44px; height: 44px; background-color: #eff6ff; color: #2563eb;">
                                <i class="bi bi-award fs-5"></i>
                            </div>
                            <div>
                                <span class="fs-15 fw-semibold text-dark mb-1">1 Year Warranty</span>
                                <p class="fs-13 text-muted mb-0 lh-sm">High-performance coverage you can trust.</p>
                            </div>
                        </div>

                        <hr class="my-4" style="border-color: #e5e7eb; opacity: 1;">

                        <!-- Support Section -->
                        <div class="help-section pt-2">
                            <div class="fs-18 fw-bold text-dark mb-2">Need Help?</div>
                            <p class="fs-13 text-muted mb-4 lh-sm">Our support team is here to assist you with your order.
                            </p>

                            <div class="d-flex align-items-center gap-3 mb-3 fs-14">
                                <i class="bi bi-envelope text-dark"></i>
                                <a href="mailto:support@aireindustries.com"
                                    class="text-dark text-decoration-none fw-medium">support@aireindustries.com</a>
                            </div>

                            <div class="d-flex align-items-center gap-3 fs-14">
                                <i class="bi bi-telephone text-dark"></i>
                                <a href="tel:+18881234567" class="text-dark text-decoration-none fw-medium">+1 (888)
                                    123-4567</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script src="{{ theme_asset('js/checkout.js') }}" defer></script>
@endpush
