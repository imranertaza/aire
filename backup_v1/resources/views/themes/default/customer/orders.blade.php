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
                        <!-- Header -->
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                            <div>
                                <h4 class="fw-bold text-dark mb-1 fs-18">
                                    <i class="bi bi-box-seam text-primary me-2"></i>My Orders
                                </h4>
                                <p class="text-muted fs-13 mb-0">Track, filter, and view invoices for all your purchases</p>
                            </div>
                            <div class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fs-13 fw-semibold">
                                Total: {{ $orders->total() }}
                                {{ \Illuminate\Support\Str::plural('Order', $orders->total()) }}
                            </div>
                        </div>

                        <!-- Search, Filter & Sort Controls -->
                        <div class="bg-light-subtle rounded-3 p-3 mb-4 border border-light-subtle">
                            <form action="{{ route('customer.orders') }}" method="GET" id="ordersFilterForm">
                                <div class="row g-2 align-items-center">
                                    <!-- Search Input -->
                                    <div class="col-12 col-md-4">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-white border-end-0 text-muted">
                                                <i class="bi bi-search"></i>
                                            </span>
                                            <input type="text" name="search"
                                                value="{{ $filters['search'] ?? '' }}"
                                                class="form-control form-control-sm border-start-0 shadow-none ps-0"
                                                placeholder="Order #, product, or city...">
                                            @if (! empty($filters['search']))
                                                <a href="{{ route('customer.orders', array_merge(request()->except('search'), ['page' => 1])) }}"
                                                    class="input-group-text bg-white text-muted text-decoration-none"
                                                    title="Clear search">
                                                    <i class="bi bi-x-circle"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Status Filter -->
                                    <div class="col-6 col-sm-4 col-md-2">
                                        <select name="status" class="form-select form-select-sm shadow-none"
                                            onchange="document.getElementById('ordersFilterForm').submit()">
                                            <option value="all">All Statuses</option>
                                            @foreach ($orderStatuses as $status)
                                                <option value="{{ $status->id }}"
                                                    {{ (string) ($filters['status'] ?? '') === (string) $status->id ? 'selected' : '' }}>
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Date Filter -->
                                    <div class="col-6 col-sm-4 col-md-2">
                                        <select name="date" class="form-select form-select-sm shadow-none"
                                            onchange="document.getElementById('ordersFilterForm').submit()">
                                            <option value="all">All Dates</option>
                                            <option value="today" {{ ($filters['date'] ?? '') === 'today' ? 'selected' : '' }}>Today</option>
                                            <option value="last_7_days" {{ ($filters['date'] ?? '') === 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                                            <option value="last_30_days" {{ ($filters['date'] ?? '') === 'last_30_days' ? 'selected' : '' }}>Last 30 Days</option>
                                            <option value="last_6_months" {{ ($filters['date'] ?? '') === 'last_6_months' ? 'selected' : '' }}>Last 6 Months</option>
                                            <option value="this_year" {{ ($filters['date'] ?? '') === 'this_year' ? 'selected' : '' }}>This Year</option>
                                        </select>
                                    </div>

                                    <!-- Sort By -->
                                    <div class="col-8 col-sm-4 col-md-3">
                                        <select name="sort" class="form-select form-select-sm shadow-none"
                                            onchange="document.getElementById('ordersFilterForm').submit()">
                                            <option value="latest" {{ ($filters['sort'] ?? '') === 'latest' ? 'selected' : '' }}>Newest First</option>
                                            <option value="oldest" {{ ($filters['sort'] ?? '') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                            <option value="total_high" {{ ($filters['sort'] ?? '') === 'total_high' ? 'selected' : '' }}>Amount: High to Low</option>
                                            <option value="total_low" {{ ($filters['sort'] ?? '') === 'total_low' ? 'selected' : '' }}>Amount: Low to High</option>
                                        </select>
                                    </div>

                                    <!-- Filter Submit / Reset Buttons -->
                                    <div class="col-4 col-sm-12 col-md-1 d-flex gap-1 justify-content-end">
                                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold" title="Apply Filter">
                                            <i class="bi bi-filter"></i>
                                        </button>
                                        @if (! empty($filters['search']) || (! empty($filters['status']) && $filters['status'] !== 'all') || (! empty($filters['date']) && $filters['date'] !== 'all') || (($filters['sort'] ?? 'latest') !== 'latest'))
                                            <a href="{{ route('customer.orders') }}"
                                                class="btn btn-outline-secondary btn-sm px-2 fw-semibold"
                                                title="Reset all filters">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Orders List Table -->
                        @if ($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light fs-13 text-secondary fw-bold">
                                        <tr>
                                            <th>ORDER ID</th>
                                            <th>DATE</th>
                                            <th>ITEMS</th>
                                            <th>SHIPPING ADDRESS</th>
                                            <th>TOTAL</th>
                                            <th>STATUS</th>
                                            <th class="text-end">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-14">
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td class="fw-bold text-primary font-monospace fs-13">{{ $order->order_number }}</td>
                                                <td class="text-secondary fs-13">
                                                    {{ $order->created_at ? $order->created_at->format('M d, Y') : 'N/A' }}
                                                    <div class="fs-11 text-muted">{{ $order->created_at ? $order->created_at->format('h:i A') : '' }}</div>
                                                </td>
                                                <td class="fs-13 text-secondary">
                                                    @php
                                                        $itemCount = $order->items->sum('quantity') ?: $order->items->count();
                                                    @endphp
                                                    <span class="badge bg-light text-dark border rounded-pill px-2 py-1">
                                                        {{ $itemCount }} {{ \Illuminate\Support\Str::plural('item', $itemCount) }}
                                                    </span>
                                                </td>
                                                <td class="fs-13 text-secondary">
                                                    <div class="fw-semibold text-dark">
                                                        {{ $order->shipping_firstname }} {{ $order->shipping_lastname }}
                                                    </div>
                                                    <div class="text-truncate" style="max-width: 220px;" title="{{ $order->shipping_address_1 }}, {{ $order->shipping_city }}">
                                                        {{ $order->shipping_address_1 }}{{ $order->shipping_address_2 ? ', ' . $order->shipping_address_2 : '' }},
                                                        {{ $order->shipping_city }} {{ $order->shipping_postcode }}
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-dark fs-15">${{ number_format($order->total, 2) }}</td>
                                                <td>
                                                    @php
                                                        $statusLower = strtolower($order->status_name ?? '');
                                                        $badgeClass = match(true) {
                                                            str_contains($statusLower, 'complete') || str_contains($statusLower, 'delivered') => 'bg-success-subtle text-success border border-success-subtle',
                                                            str_contains($statusLower, 'cancel') || str_contains($statusLower, 'fail') || str_contains($statusLower, 'refund') => 'bg-danger-subtle text-danger border border-danger-subtle',
                                                            str_contains($statusLower, 'ship') || str_contains($statusLower, 'transit') => 'bg-info-subtle text-info-emphasis border border-info-subtle',
                                                            str_contains($statusLower, 'pending') => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
                                                            default => 'bg-primary-subtle text-primary border border-primary-subtle',
                                                        };
                                                    @endphp
                                                    <span class="badge rounded-pill fs-12 px-3 py-1 fw-semibold {{ $badgeClass }}">
                                                        {{ $order->status_name ?? 'Processing' }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex gap-1 justify-content-end">
                                                        <a href="{{ route('customer.orders.detail', $order->id) }}"
                                                            class="btn btn-outline-primary btn-sm rounded-pill fs-12 fw-semibold px-3">
                                                            View
                                                        </a>
                                                        <a href="{{ route('customer.invoice', $order->id) }}"
                                                            target="_blank"
                                                            class="btn btn-light btn-sm rounded-pill fs-12 fw-semibold px-3 border">
                                                            Invoice
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div class="fs-13 text-muted">
                                    Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders
                                </div>
                                <div>
                                    {{ $orders->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @else
                            <div class="py-5 text-center">
                                @if (! empty($filters['search']) || (! empty($filters['status']) && $filters['status'] !== 'all') || (! empty($filters['date']) && $filters['date'] !== 'all'))
                                    <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                                    <h5 class="fw-bold text-dark fs-16">No Matching Orders Found</h5>
                                    <p class="text-muted fs-14 mb-4">No orders match your active search or filter criteria.</p>
                                    <a href="{{ route('customer.orders') }}"
                                        class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold fs-14">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Clear Filters
                                    </a>
                                @else
                                    <i class="bi bi-bag-x fs-1 text-muted mb-3 d-block"></i>
                                    <h5 class="fw-bold text-dark fs-16">No Orders Placed Yet</h5>
                                    <p class="text-muted fs-14 mb-4">You haven't placed any orders with us yet.</p>
                                    <a href="{{ route('products.filter') }}"
                                        class="btn btn-primary rounded-pill px-4 py-2 fw-semibold text-white fs-14">
                                        Explore Products
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
