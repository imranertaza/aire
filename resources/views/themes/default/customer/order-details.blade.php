@extends('themes.default.layouts.master')

@section('title', 'Order #' . $order->id . ' Details | Aire')

@section('content')
<main class="py-5 bg-light-subtle min-vh-100">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar Left Nav -->
            <div class="col-lg-3 d-print-none">
                @include('themes.default.customer.sidebar')
            </div>

            <!-- Details Content -->
            <div class="col-lg-9">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <a href="{{ route('customer.orders') }}" class="text-decoration-none text-secondary fs-13 fw-semibold mb-1 d-inline-block">
                            <i class="bi bi-arrow-left me-1"></i> Back to Orders
                        </a>
                        <h3 class="fw-bold text-dark mb-0 fs-22">Order #{{ $order->id }}</h3>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('customer.invoice', $order->id) }}" target="_blank" class="btn btn-outline-primary rounded-2 px-3 py-2 fs-13 fw-semibold">
                            <i class="bi bi-printer me-1"></i> Print Invoice
                        </a>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-8">
                        <!-- Items Card -->
                        <div class="card border-light-subtle shadow-sm rounded-4 bg-white p-4 mb-4">
                            <h5 class="fw-bold text-dark mb-3 fs-16 border-bottom pb-3">Itemized Order Summary</h5>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light fs-12 text-secondary text-uppercase fw-bold">
                                        <tr>
                                            <th>Product</th>
                                            <th>Unit Price</th>
                                            <th>Qty</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-14">
                                        @foreach($orderItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="{{ getImageUrl($item->product->main_image ?? $item->product->image ?? '') }}" alt="{{ $item->name }}" class="rounded-3 border p-1" style="width: 54px; height: 54px; object-fit: cover;">
                                                        <div>
                                                            <h6 class="fw-bold mb-0 fs-14 text-dark">{{ $item->name }}</h6>
                                                            <span class="text-muted fs-12">Model: {{ $item->model ?? 'Standard' }}</span>
                                                            @if($item->options && $item->options->count() > 0)
                                                                <div class="mt-1">
                                                                    @foreach($item->options as $opt)
                                                                        <span class="badge bg-secondary-subtle text-secondary fs-11 me-1">
                                                                            {{ ucfirst($opt->name) }}: {{ $opt->value }}
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fw-medium">${{ number_format($item->price, 2) }}</td>
                                                <td class="fw-bold">{{ $item->quantity }}</td>
                                                <td class="fw-bold text-end">${{ number_format($item->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Order Status Timeline -->
                        <div class="card border-light-subtle shadow-sm rounded-4 bg-white p-4">
                            <h5 class="fw-bold text-dark mb-3 fs-16 border-bottom pb-3">Fulfillment & Status</h5>
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fs-13 fw-semibold">
                                    Status: {{ $order->status_name ?? 'Processing' }}
                                </span>
                                <span class="text-secondary fs-13">Placed on {{ $order->created_at ? $order->created_at->format('F d, Y 	 h:i A') : '' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-light-subtle shadow-sm rounded-4 bg-white p-4 mb-4">
                            <h5 class="fw-bold text-dark mb-3 fs-16 border-bottom pb-3">Payment Breakdown</h5>
                            <div class="d-flex justify-content-between py-2 border-bottom fs-14 text-secondary">
                                <span>Subtotal</span>
                                <span class="fw-semibold text-dark">${{ number_format($order->subtotal ?? $order->total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom fs-14 text-secondary">
                                <span>Shipping Cost</span>
                                <span class="fw-semibold text-dark">${{ number_format($order->shipping_charge ?? 0, 2) }}</span>
                            </div>
                            @if(($order->discount ?? 0) > 0)
                                <div class="d-flex justify-content-between py-2 border-bottom fs-14 text-danger">
                                    <span>Discount</span>
                                    <span class="fw-semibold">-${{ number_format($order->discount, 2) }}</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-between pt-3 fs-16 font-extrabold text-dark">
                                <span>Total Paid</span>
                                <span class="text-primary">${{ number_format($order->final_amount, 2) }}</span>
                            </div>
                        </div>

                        <!-- Shipping Address Card -->
                        <div class="card border-light-subtle shadow-sm rounded-4 bg-white p-4">
                            <h5 class="fw-bold text-dark mb-3 fs-16 border-bottom pb-3"><i class="bi bi-geo-alt text-primary me-2"></i>Shipping Address</h5>
                            <p class="fw-bold mb-1 text-dark fs-14">{{ $order->shipping_firstname }} {{ $order->shipping_lastname }}</p>
                            <p class="text-secondary fs-13 mb-1">{{ $order->shipping_address_1 }}</p>
                            @if($order->shipping_address_2) <p class="text-secondary fs-13 mb-1">{{ $order->shipping_address_2 }}</p> @endif
                            <p class="text-secondary fs-13 mb-1">{{ $order->shipping_city }}{{ $order->shipping_postcode ? ', ' . $order->shipping_postcode : '' }}</p>
                            @if($order->shipping_country) <p class="text-secondary fs-13 mb-1">{{ $order->shipping_country }}</p> @endif
                            <p class="text-secondary fs-13 mb-0"><i class="bi bi-telephone me-1"></i>{{ $order->shipping_phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
