@extends('themes.default.layouts.master')

@section('title', 'Invoice #' . ($order->invoice_no ?: $order->id) . ' | ' . ($settings['brand_name'] ?? 'Aire'))

@section('content')
    <main class="py-5 bg-light-subtle">
        <div class="container">
            <div class="row g-4">

                {{-- Dashboard Sidebar (Hidden on Print) --}}
                <div class="col-lg-3 d-print-none">
                    @include('themes.default.customer.sidebar')
                </div>

                {{-- Main Invoice Card --}}
                <div class="col-lg-9">
                    <div class="card border-light-subtle shadow-sm rounded-4 bg-white invoice-printable-card">
                        <div class="card-body p-4 p-md-5">

                            {{-- Master Table for Multi-Page Print Support (Repeats thead Header Banner on every printed page) --}}
                            <table class="invoice-master-table">
                                <thead>
                                    <tr>
                                        <th class="p-0 border-0 fw-normal text-start">
                                            {{-- Header Banner: Brand Info & Payment Status (Repeats on every printed page) --}}
                                            <div
                                                class="d-flex justify-content-between align-items-start pb-4 border-bottom mb-4 flex-wrap gap-3">
                                                <div>
                                                    <div class="fw-extrabold fs-24 tracking-tight mb-2">
                                                        @if (!empty($settings['store_logo']))
                                                            <img src="{{ getImageUrl($settings['store_logo']) }}"
                                                                width="140"
                                                                alt="{{ $settings['brand_name'] ?? 'Aire Logo' }}"
                                                                style="max-height: 50px; object-fit: contain;">
                                                        @else
                                                            <span
                                                                class="fs-22 fw-bold text-dark">{{ $settings['brand_name'] ?? 'Aire' }}</span>
                                                        @endif
                                                    </div>
                                                    @if (!empty($settings['address']))
                                                        <p class="text-muted fs-13 mb-1 mt-1">
                                                            <i class="bi bi-geo-alt me-1 text-primary"></i>
                                                            {{ $settings['address'] }}
                                                        </p>
                                                    @endif
                                                    @if (!empty($settings['phone']) || !empty($settings['email']))
                                                        <div class="d-flex flex-wrap gap-3 text-muted fs-13 mt-1">
                                                            @if (!empty($settings['phone']))
                                                                <span><i class="bi bi-telephone me-1 text-primary"></i>
                                                                    {{ $settings['phone'] }}</span>
                                                            @endif
                                                            @if (!empty($settings['email']))
                                                                <span><i class="bi bi-envelope me-1 text-primary"></i>
                                                                    {{ $settings['email'] }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="text-md-end">
                                                    @php
                                                        $paymentStatusRaw = strtolower(
                                                            $order->payment_status ?? 'pending',
                                                        );
                                                        $isPaid =
                                                            in_array($paymentStatusRaw, ['paid', 'completed']) ||
                                                            $order->status == 2;
                                                        $isFailed = in_array($paymentStatusRaw, [
                                                            'failed',
                                                            'cancelled',
                                                            'canceled',
                                                        ]);

                                                        if ($isPaid) {
                                                            $badgeClass = 'bg-success text-white';
                                                            $badgeIcon = 'bi-check-circle-fill';
                                                            $badgeText = 'PAID';
                                                        } elseif ($isFailed) {
                                                            $badgeClass = 'bg-danger text-white';
                                                            $badgeIcon = 'bi-x-circle-fill';
                                                            $badgeText = strtoupper($order->payment_status ?? 'FAILED');
                                                        } else {
                                                            $badgeClass = 'bg-warning text-dark';
                                                            $badgeIcon = 'bi-clock-fill';
                                                            $badgeText = 'UNPAID';
                                                        }
                                                    @endphp

                                                    <span
                                                        class="badge fs-13 fw-bold px-3 py-2 rounded-pill {{ $badgeClass }}">
                                                        <i class="bi {{ $badgeIcon }} me-1"></i>
                                                        {{ $badgeText }}
                                                    </span>

                                                    @if (!empty($order->payment_method))
                                                        <div class="fs-12 text-muted mt-2 fw-medium">
                                                            <span class="text-uppercase text-secondary">Method:</span>
                                                            {{ $order->payment_method }}
                                                        </div>
                                                    @endif

                                                    @if (!empty($order->PM_transaction_id ?? $order->payment_transection_code))
                                                        <div class="fs-11 text-muted mt-1">
                                                            <span class="text-uppercase">Txn:</span>
                                                            {{ $order->PM_transaction_id ?? $order->payment_transection_code }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-0 border-0">
                                            {{-- Order Metadata Box --}}
                                            <div class="p-4 rounded-3 mb-4 invoice-avoid-break"
                                                style="background: var(--color-primary-bg, #f4f9fd); border: 1px solid var(--color-primary-light, #e0effa);">
                                                <div class="row g-3 fs-14">
                                                    <div class="col-sm-3 col-6">
                                                        <span
                                                            class="text-muted fs-12 text-uppercase fw-semibold d-block">Invoice
                                                            Number</span>
                                                        <span
                                                            class="fw-bold text-dark fs-16">#{{ $order->invoice_no ?: $order->id }}</span>
                                                    </div>
                                                    <div class="col-sm-3 col-6">
                                                        <span
                                                            class="text-muted fs-12 text-uppercase fw-semibold d-block">Order
                                                            ID</span>
                                                        <span class="fw-bold text-dark fs-16">#{{ $order->id }}</span>
                                                    </div>
                                                    <div class="col-sm-3 col-6">
                                                        <span
                                                            class="text-muted fs-12 text-uppercase fw-semibold d-block">Issued
                                                            Date</span>
                                                        <span class="fw-semibold text-dark">
                                                            {{ $order->created_at ? $order->created_at->format('d M, Y') : 'N/A' }}
                                                        </span>
                                                    </div>
                                                    <div class="col-sm-3 col-6">
                                                        <span
                                                            class="text-muted fs-12 text-uppercase fw-semibold d-block">Order
                                                            Status</span>
                                                        @php
                                                            $orderStatusName =
                                                                $order->orderStatus->name ??
                                                                ($order->status_name ?? 'Processing');
                                                            $statusLower = strtolower($orderStatusName);
                                                            $statusBadgeStyle =
                                                                'background: var(--color-primary, #0d6efd); color: #fff;';
                                                            if (
                                                                str_contains($statusLower, 'complete') ||
                                                                str_contains($statusLower, 'delivered')
                                                            ) {
                                                                $statusBadgeStyle = 'background: #198754; color: #fff;';
                                                            } elseif (
                                                                str_contains($statusLower, 'cancel') ||
                                                                str_contains($statusLower, 'fail') ||
                                                                str_contains($statusLower, 'denied')
                                                            ) {
                                                                $statusBadgeStyle = 'background: #dc3545; color: #fff;';
                                                            } elseif (
                                                                str_contains($statusLower, 'pending') ||
                                                                str_contains($statusLower, 'process')
                                                            ) {
                                                                $statusBadgeStyle =
                                                                    'background: #ffc107; color: #212529;';
                                                            }
                                                        @endphp
                                                        <span class="badge rounded-pill fs-12 fw-semibold px-2 py-1"
                                                            style="{{ $statusBadgeStyle }}">
                                                            {{ $orderStatusName }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Billed To & Shipped To --}}
                                            <div class="row g-4 mb-4 invoice-avoid-break">
                                                <!-- Bill To -->
                                                <div class="col-md-6">
                                                    <div class="p-3 bg-light rounded-3 border h-100">
                                                        <h6
                                                            class="fs-13 fw-bold text-uppercase text-muted mb-2 letter-spacing-1">
                                                            <i class="bi bi-receipt me-1 text-primary"></i> Billed To
                                                        </h6>
                                                        <p class="fw-bold fs-15 text-dark mb-1">
                                                            {{ $order->payment_firstname }} {{ $order->payment_lastname }}
                                                        </p>
                                                        @if (!empty($order->payment_phone ?? $order->telephone))
                                                            <p class="text-muted fs-13 mb-1">
                                                                <i class="bi bi-telephone me-1"></i>
                                                                {{ $order->payment_phone ?? $order->telephone }}
                                                            </p>
                                                        @endif
                                                        @if (!empty($order->payment_email ?? $order->email))
                                                            <p class="text-muted fs-13 mb-1">
                                                                <i class="bi bi-envelope me-1"></i>
                                                                {{ $order->payment_email ?? $order->email }}
                                                            </p>
                                                        @endif
                                                        <p class="text-muted fs-13 mb-0">
                                                            <i class="bi bi-house-door me-1"></i>
                                                            {{ $order->payment_address_1 }}{{ $order->payment_address_2 ? ', ' . $order->payment_address_2 : '' }}
                                                            @if (!empty($order->payment_city))
                                                                , {{ $order->payment_city }}
                                                            @endif
                                                            {{ !empty($order->payment_postcode) ? ' ' . $order->payment_postcode : '' }}
                                                            @if (!empty($order->payment_country))
                                                                , {{ $order->payment_country }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Ship To -->
                                                <div class="col-md-6">
                                                    <div class="p-3 bg-light rounded-3 border h-100">
                                                        <h6
                                                            class="fs-13 fw-bold text-uppercase text-muted mb-2 letter-spacing-1">
                                                            <i class="bi bi-truck me-1 text-primary"></i> Shipped To
                                                        </h6>
                                                        <p class="fw-bold fs-15 text-dark mb-1">
                                                            {{ $order->shipping_firstname ?: $order->payment_firstname }}
                                                            {{ $order->shipping_lastname ?: $order->payment_lastname }}
                                                        </p>
                                                        @if (!empty($order->shipping_phone ?? ($order->payment_phone ?? $order->telephone)))
                                                            <p class="text-muted fs-13 mb-1">
                                                                <i class="bi bi-telephone me-1"></i>
                                                                {{ $order->shipping_phone ?? ($order->payment_phone ?? $order->telephone) }}
                                                            </p>
                                                        @endif
                                                        @if (!empty($order->shipping_method))
                                                            <p class="text-muted fs-13 mb-1">
                                                                <i class="bi bi-box-seam me-1"></i> Method:
                                                                {{ $order->shipping_method }}
                                                            </p>
                                                        @endif
                                                        <p class="text-muted fs-13 mb-0">
                                                            <i class="bi bi-geo-alt me-1"></i>
                                                            @php
                                                                $shipAddr1 =
                                                                    $order->shipping_address_1 ?:
                                                                    $order->payment_address_1;
                                                                $shipAddr2 =
                                                                    $order->shipping_address_2 ?:
                                                                    $order->payment_address_2;
                                                                $shipCity =
                                                                    $order->shipping_city ?: $order->payment_city;
                                                                $shipZip =
                                                                    $order->shipping_postcode ?:
                                                                    $order->payment_postcode;
                                                                $shipCountry =
                                                                    $order->shipping_country ?: $order->payment_country;
                                                            @endphp
                                                            {{ $shipAddr1 }}{{ $shipAddr2 ? ', ' . $shipAddr2 : '' }}
                                                            @if (!empty($shipCity))
                                                                , {{ $shipCity }}
                                                            @endif
                                                            {{ !empty($shipZip) ? ' ' . $shipZip : '' }}
                                                            @if (!empty($shipCountry))
                                                                , {{ $shipCountry }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Order Items Table --}}
                                            <div class="table-responsive mb-4">
                                                <table class="table align-middle border-top mb-0 invoice-items-table">
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
                                                                        @php
                                                                            $itemImage =
                                                                                $item->product->main_image ??
                                                                                ($item->product->image ??
                                                                                    ($item->product &&
                                                                                    $item->product->images
                                                                                        ? $item->product->images->first()
                                                                                            ?->image
                                                                                        : null));
                                                                        @endphp
                                                                        @if (!empty($itemImage))
                                                                            <div class="border rounded-2 p-1 bg-white d-flex align-items-center justify-content-center flex-shrink-0"
                                                                                style="width: 55px; height: 55px;">
                                                                                <img src="{{ getImageUrl($itemImage) }}"
                                                                                    alt="{{ $item->product->name ?? ($item->name ?? 'Product') }}"
                                                                                    class="img-fluid rounded-1"
                                                                                    style="max-height: 45px; object-fit: contain;">
                                                                            </div>
                                                                        @endif
                                                                        <div>
                                                                            <span
                                                                                class="fw-semibold text-dark d-block mb-0">
                                                                                {{ $item->product->name ?? ($item->name ?? 'Product #' . $item->product_id) }}
                                                                            </span>
                                                                            @if (!empty($item->product->model ?? $item->model))
                                                                                <small class="text-muted fs-12 d-block">
                                                                                    Model:
                                                                                    {{ $item->product->model ?? $item->model }}
                                                                                </small>
                                                                            @endif
                                                                            @if ($item->options && $item->options->count() > 0)
                                                                                <div class="d-flex flex-wrap gap-1 mt-1">
                                                                                    @foreach ($item->options as $opt)
                                                                                        <span
                                                                                            class="badge bg-secondary-subtle text-secondary fs-11 fw-normal border">
                                                                                            {{ ucfirst($opt->name) }}:
                                                                                            {{ $opt->value }}
                                                                                        </span>
                                                                                    @endforeach
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="py-3 text-center text-muted">
                                                                    ${{ number_format($item->price, 2) }}
                                                                </td>
                                                                <td class="py-3 text-center text-dark fw-medium">
                                                                    {{ $item->quantity }}</td>
                                                                <td class="py-3 text-end pe-3 fw-bold text-dark">
                                                                    ${{ number_format($item->final_price ?? ($item->total_price ?? $item->price * $item->quantity), 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{-- Totals Summary Breakdown & Order Notes --}}
                                            <div class="row g-4 mb-4 align-items-start invoice-avoid-break">
                                                {{-- Left Column: Order Notes / Comments --}}
                                                <div class="col-md-7">
                                                    @if (!empty($order->comment))
                                                        <div class="p-3 bg-light rounded-3 border">
                                                            <h6
                                                                class="fs-13 fw-bold text-uppercase text-muted mb-2 letter-spacing-1">
                                                                <i class="bi bi-chat-left-text me-1 text-primary"></i> Order
                                                                Notes
                                                            </h6>
                                                            <p class="fs-13 text-secondary mb-0">
                                                                {{ $order->comment }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Right Column: Cost Breakdown --}}
                                                <div class="col-md-5 {{ empty($order->comment) ? 'ms-auto' : '' }}">
                                                    <div class="bg-light p-3 rounded-3 border">
                                                        <div class="d-flex justify-content-between fs-14 mb-2">
                                                            <span class="text-muted">Sub Total:</span>
                                                            <span
                                                                class="fw-semibold text-dark">${{ number_format($order->total, 2) }}</span>
                                                        </div>

                                                        @if (($order->discount ?? 0) > 0)
                                                            <div
                                                                class="d-flex justify-content-between fs-14 mb-2 text-danger">
                                                                <span>Discount:</span>
                                                                <span
                                                                    class="fw-semibold">-${{ number_format($order->discount, 2) }}</span>
                                                            </div>
                                                        @endif

                                                        <div class="d-flex justify-content-between fs-14 mb-2">
                                                            <span class="text-muted">Shipping Charge:</span>
                                                            <span class="fw-semibold text-dark">
                                                                @if (($order->shipping_charge ?? 0) > 0)
                                                                    ${{ number_format($order->shipping_charge, 2) }}
                                                                @else
                                                                    <span class="text-success fw-bold">Free</span>
                                                                @endif
                                                            </span>
                                                        </div>

                                                        @if (($order->vat ?? 0) > 0)
                                                            <div class="d-flex justify-content-between fs-14 mb-2">
                                                                <span class="text-muted">VAT / Tax:</span>
                                                                <span
                                                                    class="fw-semibold text-dark">${{ number_format($order->vat, 2) }}</span>
                                                            </div>
                                                        @endif

                                                        <hr class="my-2">
                                                        <div class="d-flex justify-content-between fs-16 fw-bold">
                                                            <span class="text-dark">Total Amount:</span>
                                                            <span
                                                                style="color: var(--color-primary, #0d6efd);">${{ number_format($order->final_amount, 2) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Invoice Footer Note --}}
                                            <div class="border-top pt-4 text-center text-muted fs-13 invoice-avoid-break">
                                                <p class="mb-1 fw-semibold text-dark">Thank you for shopping with
                                                    {{ $settings['brand_name'] ?? 'Aire' }}!</p>
                                                <p class="mb-0 fs-12">
                                                    If you have any questions regarding this invoice, please contact us at
                                                    <strong>{{ $settings['email'] ?? 'support@aire.com' }}</strong>
                                                    @if (!empty($settings['phone']))
                                                        or call
                                                        <strong>{{ $settings['phone'] }}</strong>
                                                    @endif.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            {{-- Actions Bar (Hidden on Print) --}}
                            <div
                                class="d-flex justify-content-between align-items-center pt-4 border-top mt-4 flex-wrap gap-2 d-print-none">
                                <a href="{{ route('customer.orders') }}"
                                    class="btn btn-outline-secondary rounded-2 fs-14 fw-semibold px-4 py-2">
                                    <i class="bi bi-arrow-left me-1"></i> Back to Orders
                                </a>
                                <button onclick="window.print()"
                                    class="btn btn-dark rounded-2 fs-14 fw-semibold px-4 py-2">
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
        /* Screen master table styles */
        .invoice-master-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            background: transparent;
            margin: 0;
            padding: 0;
        }

        .invoice-master-table>thead>tr>th,
        .invoice-master-table>tbody>tr>td {
            padding: 0;
            border: none;
            background: transparent;
            font-weight: normal;
            text-align: inherit;
            vertical-align: top;
        }

        @media print {
            @page {
                size: auto;
                margin: 10mm 15mm 10mm 15mm;
            }

            .d-print-none,
            header,
            footer,
            nav {
                display: none !important;
            }

            /* Reset all outer wrapper margins and paddings so Page 1 and Page 2 header gaps match exactly */
            html,
            body {
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
                color: #000000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            main,
            main.py-5,
            .container,
            .row,
            .row.g-4,
            .col-lg-9,
            .card,
            .card.invoice-printable-card,
            .card-body,
            .card-body.p-4,
            .card-body.p-md-5 {
                margin: 0 !important;
                margin-top: 0 !important;
                margin-bottom: 0 !important;
                padding: 0 !important;
                padding-top: 0 !important;
                padding-bottom: 0 !important;
                border: none !important;
                box-shadow: none !important;
                background: transparent !important;
                max-width: 100% !important;
                width: 100% !important;
                flex: 0 0 100% !important;
                overflow: visible !important;
                height: auto !important;
            }

            .badge {
                border: 1px solid #ccc !important;
            }

            /* Master table: identical spacing on Page 1 and repeating page thead */
            .invoice-master-table {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                border-collapse: collapse !important;
                border: none !important;
            }

            .invoice-master-table>thead {
                display: table-header-group !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .invoice-master-table>thead>tr,
            .invoice-master-table>thead>tr>th {
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                vertical-align: top !important;
            }

            .invoice-master-table>tbody {
                display: table-row-group !important;
            }

            .invoice-master-table>tbody>tr,
            .invoice-master-table>tbody>tr>td {
                page-break-inside: auto !important;
                break-inside: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
            }

            /* Responsive container must not scroll in print */
            .table-responsive {
                overflow: visible !important;
                display: block !important;
            }

            .invoice-items-table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            .invoice-items-table thead {
                display: table-header-group !important;
            }

            .invoice-items-table tr {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            /* Keep logical sections together */
            .invoice-avoid-break {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }
    </style>
@endpush
