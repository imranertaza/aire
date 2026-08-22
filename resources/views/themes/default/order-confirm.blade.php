@extends('themes.default.layouts.master')

@section('title', 'Order Confirmed | Aire')
@push('styles')
<link href="{{ theme_asset('css/order-confirm.css') }}" rel="stylesheet">
@endpush
@section('content')
<!-- Main Content: 3-Column Layout -->
<main class="">
    <div class="container main-container border-top border-light">
        <div class="row g-0">

            <!-- LEFT COLUMN: Order Summary Card (col-lg-3) -->
            <div class="col-lg-3 border-right1px pt-4 pe-lg-4">

                <!-- Breadcrumb -->
                <div class="breadcrumb-container pb-3 mb-4 border-bottom border-light-subtle">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 fs-14 fw-medium">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"
                                    class="text-muted text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">Order
                                Confirmation</li>
                        </ol>
                    </nav>
                </div>

                <div class="confirm-summary-card">
                    <h2 class="confirm-summary-title">Order Summary</h2>

                    <!-- Product Items List -->
                    <div class="confirm-product-list">
                        @if($order && $order->items)
                            @foreach($order->items as $item)
                                <div class="confirm-product-row">
                                    <img src="{{ $item->product->images->first()->image_url ?? theme_asset('img/Air-Purify.png') }}" alt="{{ $item->product->name ?? 'AIRE Pro S1' }}"
                                        class="confirm-product-thumb" style="object-fit: contain;">
                                    <div>
                                        <h3 class="confirm-product-name">{{ $item->product->name ?? 'AIRE Pro' }}</h3>
                                        <p class="confirm-product-sub">{{ $item->product->model ?? 'Technical System' }}</p>
                                        <span class="confirm-qty-pill">Qty: {{ $item->quantity }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="confirm-product-row">
                                <img src="{{ theme_asset('img/Air-Purify.png') }}" alt="AIRE Pro S1"
                                    class="confirm-product-thumb">
                                <div>
                                    <h3 class="confirm-product-name">AIRE Pro S1</h3>
                                    <p class="confirm-product-sub">Technical Air Purifier</p>
                                    <span class="confirm-qty-pill">Qty: 1</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="confirm-summary-divider-light"></div>

                    <!-- Breakdown Totals -->
                    <div class="confirm-row-item">
                        <span>Subtotal</span>
                        <span class="confirm-row-val">${{ number_format($order ? $order->total : 1299.00, 2) }}</span>
                    </div>
                    <div class="confirm-row-item">
                        <span>Shipping</span>
                        <span class="confirm-row-val">
                            @if($order && $order->shipping_charge > 0)
                                ${{ number_format($order->shipping_charge, 2) }}
                            @else
                                Free
                            @endif
                        </span>
                    </div>
                    <div class="confirm-row-item">
                        <span>Estimated Tax</span>
                        <span class="confirm-row-val">—</span>
                    </div>

                    <div class="confirm-summary-divider-dark"></div>

                    <!-- Grand Total -->
                    <div class="confirm-row-item total">
                        <span>Total</span>
                        <span class="confirm-row-val">${{ number_format($order ? $order->final_amount : 1299.00, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- CENTER COLUMN: Order Confirmation Hero & Details (col-lg-6) -->
            <div class="col-lg-6 pt-4 px-lg-4">

                <!-- Hero Success Card -->
                <div class="confirm-hero-card">
                    <div class="confirm-hero-icon-outer">
                        <div class="confirm-hero-icon-inner">
                            <i class="bi bi-check-lg"></i>
                        </div>
                    </div>
                    <h1 class="confirm-hero-title">Thank you! Your order has been placed.</h1>
                    <p class="confirm-hero-desc">We've received your order and it's being processed.<br>A
                        confirmation email has been sent to <strong>{{ $order ? $order->email : 'john.doe@example.com' }}</strong>.</p>
                    <div class="confirm-order-pill">
                        <span class="confirm-order-pill-label">ORDER NUMBER</span> AIRE-{{ $order ? $order->created_at->format('Y') : '2026' }}-{{ $order ? $order->invoice_no : '1234' }}
                    </div>
                </div>

                <!-- What Happens Next Timeline -->
                <div class="confirm-card-box">
                    <h2 class="confirm-card-title">What happens next?</h2>

                    <div class="confirm-timeline">
                        <div class="confirm-timeline-progress"></div>

                        <!-- Step 1: Confirmed -->
                        <div class="confirm-timeline-step completed">
                            <div class="confirm-timeline-icon">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <span class="confirm-timeline-label">Confirmed</span>
                            <span class="confirm-timeline-sub">{{ $order ? $order->created_at->format('M d, Y') : 'Today' }}</span>
                        </div>

                        <!-- Step 2: Processing -->
                        <div class="confirm-timeline-step active">
                            <div class="confirm-timeline-icon">
                                <i class="bi bi-gear"></i>
                            </div>
                            <span class="confirm-timeline-label">Processing</span>
                            <span class="confirm-timeline-sub">In Progress</span>
                        </div>

                        <!-- Step 3: Shipping -->
                        <div class="confirm-timeline-step">
                            <div class="confirm-timeline-icon">
                                <i class="bi bi-truck"></i>
                            </div>
                            <span class="confirm-timeline-label">Shipping</span>
                            <span class="confirm-timeline-sub">Pending</span>
                        </div>

                        <!-- Step 4: Delivered -->
                        <div class="confirm-timeline-step">
                            <div class="confirm-timeline-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <span class="confirm-timeline-label">Delivered</span>
                            <span class="confirm-timeline-sub">Pending</span>
                        </div>
                    </div>
                </div>

                <!-- Order Details Box -->
                <div class="confirm-card-box">
                    <h2 class="confirm-card-title">
                        <i class="bi bi-receipt"></i> Order Details
                    </h2>

                    <div class="confirm-detail-row">
                        <span class="confirm-detail-label">ORDER DATE</span>
                        <span class="confirm-detail-val">{{ $order ? $order->created_at->format('M d, Y') : 'Today' }}</span>
                    </div>
                    <div class="confirm-detail-row">
                        <span class="confirm-detail-label">PAYMENT METHOD</span>
                        <span class="confirm-detail-val">
                            <i class="bi bi-credit-card me-1"></i> {{ $order ? $order->payment_method : 'Credit Card' }}
                        </span>
                    </div>
                    <div class="confirm-detail-row">
                        <span class="confirm-detail-label">STATUS</span>
                        <span class="confirm-paid-badge">{{ $order ? strtoupper($order->payment_status) : 'PENDING' }}</span>
                    </div>
                </div>

                <!-- Shipping Address Box -->
                <div class="confirm-card-box">
                    <h2 class="confirm-card-title">
                        <i class="bi bi-truck"></i> Shipping Address
                    </h2>

                    <div class="confirm-address-name">{{ $order ? ($order->shipping_firstname . ' ' . $order->shipping_lastname) : 'Johnathan Doe' }}</div>
                    <p class="confirm-address-text">
                        {{ $order ? $order->shipping_address_1 : '123 Purifier Way' }}<br>
                        @if($order && $order->shipping_address_2)
                            {{ $order->shipping_address_2 }}<br>
                        @endif
                        {{ $order ? $order->shipping_city : 'San Francisco' }}, {{ $order ? $order->shipping_postcode : '94105' }}<br>
                        {{ $order ? $order->shipping_country : 'United States' }}
                    </p>
                    <div class="confirm-address-divider"></div>
                    <div class="confirm-address-phone">{{ $order ? $order->shipping_phone : '(555) 0123-4567' }}</div>
                </div>

                <!-- Questions About Your Order Box -->
                <div class="confirm-questions-card">
                    <div>
                        <h3 class="confirm-questions-title">Questions about your order?</h3>
                        <p class="confirm-questions-desc">Our support team is standing by to assist with
                            installation, tracking, or modifications.</p>
                    </div>
                    <div class="confirm-questions-actions">
                        <a href="{{ route('contact') }}" class="btn-contact-support">
                            <i class="bi bi-headset"></i> Contact Support
                        </a>
                        <a href="mailto:support@aireindustries.com" class="btn-email-us">
                            <i class="bi bi-envelope"></i> Email Us
                        </a>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Estimated Delivery Card (col-lg-3) -->
            <div class="col-lg-3 border-left1px pt-4 ps-lg-4">
                <div class="confirm-delivery-card">
                    <div class="confirm-delivery-header">
                        <i class="bi bi-clock confirm-delivery-icon"></i>
                        <h3 class="confirm-delivery-title">Estimated Delivery</h3>
                    </div>
                    <div class="confirm-delivery-date">
                        {{ $order ? $order->created_at->addDays(3)->format('M d') : 'In 3 days' }} – 
                        {{ $order ? $order->created_at->addDays(5)->format('M d, Y') : 'In 5 days' }}
                    </div>
                    <p class="confirm-delivery-text">You will receive a tracking link via email as soon as your
                        order ships.</p>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection