@extends('themes.default.layouts.master')

@section('title', 'Account Ledger | Aire')

@section('content')
<main class="py-5 bg-light-subtle min-vh-100">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar Left Nav -->
            <div class="col-lg-3 d-print-none">
                @include('themes.default.customer.sidebar')
            </div>

            <!-- Ledger Content -->
            <div class="col-lg-9">
                <div class="card border-light-subtle shadow-sm rounded-4 bg-white p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h4 class="fw-bold text-dark mb-1 fs-18"><i class="bi bi-journal-text text-primary me-2"></i>Account Ledger</h4>
                            <p class="text-muted fs-13 mb-0">Detailed transaction statement and debit/credit history</p>
                        </div>
                        <div class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fs-13 fw-semibold">
                            Balance: ${{ number_format($customer->balance ?? 0.00, 2) }}
                        </div>
                    </div>

                    @if(count($ledgers) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light fs-13 text-secondary fw-bold">
                                    <tr>
                                        <th>DATE</th>
                                        <th>PARTICULARS / NARRATION</th>
                                        <th>REF / ORDER ID</th>
                                        <th>TYPE</th>
                                        <th>AMOUNT</th>
                                        <th>REST BALANCE</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-14">
                                    @foreach($ledgers as $item)
                                        <tr>
                                            <td class="text-secondary fs-13">{{ $item->created_at ? $item->created_at->format('M d, Y H:i') : 'N/A' }}</td>
                                            <td class="fw-medium text-dark">{{ $item->particulars }}</td>
                                            <td>
                                                @if($item->order_id)
                                                    <a href="{{ route('customer.orders.detail', $item->order_id) }}" class="text-primary text-decoration-none fw-semibold">
                                                        #{{ $item->order_id }}
                                                    </a>
                                                @elif($item->fund_request_id)
                                                    <span class="text-secondary">Fund Req #{{ $item->fund_request_id }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->transaction_type == 'Dr.')
                                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1 fs-12">Debit</span>
                                                @else
                                                    <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 fs-12">Credit</span>
                                                @endif
                                            </td>
                                            <td class="fw-semibold {{ $item->transaction_type == 'Dr.' ? 'text-danger' : 'text-success' }}">
                                                {{ $item->transaction_type == 'Dr.' ? '-' : '+' }}${{ number_format($item->amount, 2) }}
                                            </td>
                                            <td class="fw-bold text-dark">${{ number_format($item->rest_balance ?? 0.00, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $ledgers->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="py-5 text-center">
                            <i class="bi bi-journal-x fs-1 text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-0 fs-14">No ledger transaction history found for your account.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
