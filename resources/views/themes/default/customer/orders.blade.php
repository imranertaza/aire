@extends('themes.default.layouts.master')

@section('title', 'My Orders | Aire')

@section('content')
<main class="py-5 bg-light-subtle min-vh-100">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar Left Nav -->
            <div class="col-lg-3 d-print-none">
                @include('themes.default.customer.sidebar')
            </div>

            <!-- Orders Content -->
            <div class="col-lg-9">
                <div class="card border-light-subtle shadow-sm rounded-4 bg-white p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h4 class="fw-bold text-dark mb-1 fs-18"><i class="bi bi-box-seam text-primary me-2"></i>My Orders</h4>
                            <p class="text-muted fs-13 mb-0">Track, manage, and view invoices for all your purchases</p>
                        </div>
                        <div class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fs-13 fw-semibold">
                            Total: {{ $orders->total() }} {{ \Illuminate\Support\Str::plural('Order', $orders->total()) }}
                        </div>
                    </div>

                    @if(count($orders) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light fs-13 text-secondary fw-bold">
                                    <tr>
                                        <th>ORDER ID</th>
                                        <th>DATE</th>
                                        <th>SHIPPING ADDRESS</th>
                                        <th>TOTAL</th>
                                        <th>STATUS</th>
                                        <th class="text-end">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-14">
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="fw-bold text-primary">#{{ $order->id }}</td>
                                            <td class="text-secondary fs-13">{{ $order->created_at ? $order->created_at->format('M d, Y') : 'N/A' }}</td>
                                            <td class="fs-13 text-secondary">
                                                <div class="fw-semibold text-dark">{{ $order->shipping_firstname }} {{ $order->shipping_lastname }}</div>
                                                <div class="text-truncate" style="max-width: 250px;">
                                                    {{ $order->shipping_address_1 }}{{ $order->shipping_address_2 ? ', ' . $order->shipping_address_2 : '' }}, 
                                                    {{ $order->shipping_city }} {{ $order->shipping_postcode }}
                                                </div>
                                            </td>
                                            <td class="fw-bold text-dark">${{ number_format($order->total, 2) }}</td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary rounded-pill fs-12 px-3 py-1">
                                                    {{ $order->status_name ?? 'Processing' }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex gap-1 justify-content-end">
                                                    <a href="{{ route('customer.orders.detail', $order->id) }}" class="btn btn-outline-primary btn-sm rounded-pill fs-12 fw-semibold px-3">
                                                        View
                                                    </a>
                                                    <a href="{{ route('customer.invoice', $order->id) }}" target="_blank" class="btn btn-light btn-sm rounded-pill fs-12 fw-semibold px-3 border">
                                                        Invoice
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="py-5 text-center">
                            <i class="bi bi-bag-x fs-1 text-muted mb-3 d-block"></i>
                            <h5 class="fw-bold text-dark fs-16">No Orders Placed Yet</h5>
                            <p class="text-muted fs-14 mb-4">You haven't placed any orders with us yet.</p>
                            <a href="{{ route('products.filter') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold text-white fs-14">
                                Explore Products
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
