@extends('themes.default.layouts.master')

@section('title', 'My Dashboard | Aire')

@section('content')
<main class="py-5 bg-light-subtle min-vh-100">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar Left Nav -->
            <div class="col-lg-3 d-print-none">
                @include('themes.default.customer.sidebar')
            </div>

            <!-- Dashboard Main Content -->
            <div class="col-lg-9">
                <!-- Welcome Banner -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-white" style="background: linear-gradient(135deg, #0066CC 0%, #0044AA 100%);">
                    <div class="row align-items-center py-2">
                        <div class="col-md-8">
                            <h3 class="fw-bold mb-2">Welcome Back, {{ $customer->firstname }}!</h3>
                            <p class="mb-0 opacity-85 fs-14">From your customer dashboard you can easily check and track your recent orders, manage your shipping and billing addresses, and edit your password and profile details.</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('customer.profile') }}" class="btn btn-light rounded-pill px-4 fw-semibold text-primary fs-13">Edit Profile</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders Block -->
                <div class="card border-light-subtle shadow-sm rounded-4 bg-white p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h4 class="fw-bold text-dark mb-0 fs-18">Recent Order History</h4>
                        <a href="{{ route('customer.orders') }}" class="text-primary text-decoration-none fs-13 fw-semibold">
                            View All Orders &rarr;
                        </a>
                    </div>

                    @if(count($orders) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light fs-13 text-secondary fw-bold">
                                    <tr>
                                        <th>ORDER ID</th>
                                        <th>DATE</th>
                                        <th>TOTAL</th>
                                        <th>STATUS</th>
                                        <th class="text-end">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-14">
                                    @foreach($orders->take(5) as $order)
                                        <tr>
                                            <td class="fw-bold text-primary">#{{ $order->id }}</td>
                                            <td class="text-secondary fs-13">{{ $order->created_at ? $order->created_at->format('M d, Y') : 'N/A' }}</td>
                                            <td class="fw-semibold">${{ number_format($order->total, 2) }}</td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary rounded-pill fs-12 px-2.5 py-1">
                                                    {{ $order->status_name ?? 'Processing' }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('customer.orders.detail', $order->id) }}" class="btn btn-outline-primary btn-sm rounded-pill fs-12 fw-semibold px-3">Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-5 text-center">
                            <i class="bi bi-bag-x fs-1 text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-0 fs-14">You have not placed any orders yet.</p>
                            <a href="{{ route('products.filter') }}" class="btn btn-primary rounded-pill px-4 py-2 mt-3 fw-semibold text-white fs-14">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
