@extends('themes.default.layouts.master')

@section('title', 'Invoice #' . ($order->invoice_no ?? $order->id) . ' | Aire')

@section('content')
    <main class="py-5 bg-light-subtle">
        <div class="container">
            <div class="row g-4">

                {{-- Dashboard Sidebar --}}

                <div class="col-lg-3 d-print-none">
                    @include('themes.default.customer.sidebar')
                </div>
                {{-- Main Invoice Card --}}
                <div class="col-lg-9">
                    <div class="card border-light-subtle shadow-sm rounded-4 bg-white">
                        <div class="card-body p-4 p-md-5">

                            {{-- Header Banner (Matching cCart) --}}
                            <div
                                class="d-flex justify-content-between align-items-start pb-4 border-bottom mb-4 flex-wrap gap-3">
                                <div>
                                    <div class="fw-extrabold fs-24 tracking-tight" style="color: var(--color-primary);">
                                        <i class="bi bi-wind me-2"></i>AIRE INDUSTRIES
                                    </div>
                                    <p class="text-muted fs-13 mb-0 mt-1">
                                        <i class="bi bi-geo-alt me-1"></i> Headquarters Office: 123 Air Purifier Way,
                                        Austin, TX 78701
                                    </p>
                                </div>
                                <div class="text-md-end">
                                    <span
                                        class="badge fs-13 fw-bold px-3 py-2 rounded-pill {{ $order->payment_status === 'Paid' || $order->status == 2 ? 'bg-success text-white' : 'bg-warning text-dark' }}">
                                        <i
                                            class="bi {{ $order->payment_status === 'Paid' || $order->status == 2 ? 'bi-check-circle-fill' : 'bi-clock-fill' }} me-1"></i>
                                        {{ $order->payment_status === 'Paid' || $order->status == 2 ? 'PAID' : 'UNPAID' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Order Metadata Box --}}
                            <div class="p-4 rounded-3 mb-4"
                                style="background: var(--color-primary-bg); border: 1px solid var(--color-primary-light);">
                                <div class="row g-3 fs-14">
                                    <div class="col-sm-4">
                                        <span class="text-muted fs-12 text-uppercase fw-semibold d-block">Invoice
                                            Number</span>
                                        <span class="fw-bold text-dark fs-16">#{{ $order->invoice_no ?? $order->id }}</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="text-muted fs-12 text-uppercase fw-semibold d-block">Issued Date</span>
                                        <span
                                            class="fw-semibold text-dark">{{ $order->created_at->format('d M, Y') }}</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="text-muted fs-12 text-uppercase fw-semibold d-block">Order
                                            Status</span>
                                        <span class="badge rounded-pill fs-12 fw-semibold"
                                            style="background: var(--color-primary); color: #fff;">
                                            {{ $order->status == 1 ? 'Processing' : ($order->status == 2 ? 'Complete' : ($order->status == 3 ? 'Cancelled' : 'Pending')) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Billed To & Shipped To (Matching cCart Reference) --}}
                            <div class="row g-4 mb-4">
                                <!-- Bill To -->
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3 border h-100">
                                        <h6 class="fs-13 fw-bold text-uppercase text-muted mb-2 letter-spacing-1">
                                            <i class="bi bi-receipt me-1 text-primary"></i> Billed To
                                        </h6>
                                        <p class="fw-bold fs-15 text-dark mb-1">
                                            {{ $order->payment_firstname }} {{ $order->payment_lastname }}
                                        </p>
                                        <p class="text-muted fs-13 mb-1"><i class="bi bi-telephone me-1"></i>
                                            {{ $order->payment_phone ?? $order->telephone }}</p>
                                        <p class="text-muted fs-13 mb-1"><i class="bi bi-envelope me-1"></i>
                                            {{ $order->payment_email ?? $order->email }}</p>
                                        <p class="text-muted fs-13 mb-0">
                                            <i class="bi bi-house-door me-1"></i>
                                            {{ $order->payment_address_1 }}{{ $order->payment_address_2 ? ', ' . $order->payment_address_2 : '' }},
                                            {{ $order->payment_city }}, {{ $order->payment_country }}
                                            {{ $order->payment_postcode }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Ship To -->
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3 border h-100">
                                        <h6 class="fs-13 fw-bold text-uppercase text-muted mb-2 letter-spacing-1">
                                            <i class="bi bi-truck me-1 text-primary"></i> Shipped To
                                        </h6>
                                        <p class="fw-bold fs-15 text-dark mb-1">
                                            {{ $order->shipping_firstname }} {{ $order->shipping_lastname }}
                                        </p>
                                        <p class="text-muted fs-13 mb-1"><i class="bi bi-telephone me-1"></i>
                                            {{ $order->shipping_phone ?? $order->telephone }}</p>
                                        <p class="text-muted fs-13 mb-1"><i class="bi bi-box-seam me-1"></i> Method:
                                            {{ $order->shipping_method }}</p>
                                        <p class="text-muted fs-13 mb-0">
                                            <i class="bi bi-geo-alt me-1"></i>
                                            {{ $order->shipping_address_1 }}{{ $order->shipping_address_2 ? ', ' . $order->shipping_address_2 : '' }},
                                            {{ $order->shipping_city }}, {{ $order->shipping_country }}
                                            {{ $order->shipping_postcode }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Order Items Table (Matching cCart Layout with Product Image) --}}
                            <div class="table-responsive mb-4">
                                <table class="table align-middle border-top">
                                    <thead class="table-light fs-12 text-uppercase text-muted fw-semibold">
                                        <tr>
                                            <th class="py-3 ps-3">Product Name</th>
                                            <th class="py-3 text-center">Unit Price</th>
                                            <th class="py-3 text-center">Qty</th>
                                            <th class="py-3 text-end pe-3">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderItems as $item)
                                            <tr class="fs-14">
                                                <td class="py-3 ps-3">
                                                    <div class="d-flex align-items-center gap-3">
                                                        @if (isset($item->product->image))
                                                            <div class="border rounded-2 p-1 bg-white d-flex align-items-center justify-content-center flex-shrink-0"
                                                                style="width: 55px; height: 55px;">
                                                                <img src="{{ getImageUrl($item->product->image) }}"
                                                                    alt="{{ $item->product->name }}" class="img-fluid"
                                                                    style="max-height: 45px; object-fit: contain;">
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <span
                                                                class="fw-semibold text-dark d-block mb-0">{{ $item->product->name ?? 'Product #' . $item->product_id }}</span>
                                                            @if (isset($item->product->model))
                                                                <small class="text-muted fs-12">Model:
                                                                    {{ $item->product->model }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3 text-center text-muted">
                                                    ${{ number_format($item->price, 2) }}</td>
                                                <td class="py-3 text-center text-dark fw-medium">{{ $item->quantity }}</td>
                                                <td class="py-3 text-end pe-3 fw-bold text-dark">
                                                    ${{ number_format($item->total_price ?? $item->price * $item->quantity, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Totals Summary Breakdown (Matching cCart) --}}
                            <div class="row justify-content-end mb-4">
                                <div class="col-md-5">
                                    <div class="bg-light p-3 rounded-3 border">
                                        <div class="d-flex justify-content-between fs-14 mb-2">
                                            <span class="text-muted">Sub Total:</span>
                                            <span
                                                class="fw-semibold text-dark">${{ number_format($order->total, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between fs-14 mb-2">
                                            <span class="text-muted">Discount:</span>
                                            <span
                                                class="fw-semibold text-danger">-${{ number_format($order->discount, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between fs-14 mb-2">
                                            <span class="text-muted">Shipping Charge:</span>
                                            <span
                                                class="fw-semibold text-dark">${{ number_format($order->shipping_charge, 2) }}</span>
                                        </div>
                                        <hr class="my-2">
                                        <div class="d-flex justify-content-between fs-16 fw-bold">
                                            <span class="text-dark">Total Amount:</span>
                                            <span
                                                style="color: var(--color-primary);">${{ number_format($order->final_amount, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions Bar --}}
                            <div
                                class="d-flex justify-content-between align-items-center pt-3 border-top flex-wrap gap-2 d-print-none">
                                <a href="{{ route('customer.orders') }}"
                                    class="btn btn-outline-secondary rounded-2 fs-14 fw-semibold px-4 py-2">
                                    <i class="bi bi-arrow-left me-1"></i> Back to Orders
                                </a>
                                <button onclick="window.print()" class="btn btn-dark rounded-2 fs-14 fw-semibold px-4 py-2">
                                    <i class="bi bi-printer me-2"></i> Print Invoice
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection

@push('styles')
    <style>
        @media print {

            .d-print-none,
            header,
            footer,
            nav {
                display: none !important;
            }

            body {
                background: white !important;
            }

            main {
                padding: 0 !important;
            }

            .col-lg-9 {
                width: 100% !important;
                max-width: 100% !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
@endpush
