@extends('themes.default.layouts.master')

@section('title', 'My Wallet | Aire')

@section('content')
<main class="py-5 bg-light-subtle min-vh-100">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar Left Nav -->
            <div class="col-lg-3 d-print-none">
                @include('themes.default.customer.sidebar')
            </div>

            <!-- Wallet Content -->
            <div class="col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 fs-14 mb-4" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('message') ?? 'Wallet deposit request submitted successfully!' }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 fs-14 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4 mb-4">
                    <!-- Balance Card -->
                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #0066CC 0%, #004499 100%);">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="fs-13 text-uppercase tracking-wider opacity-75 fw-semibold">Current Wallet Balance</span>
                                <i class="bi bi-wallet2 fs-24"></i>
                            </div>
                            <h1 class="fw-extrabold mb-3 fs-36">${{ number_format($customer->balance ?? 0.00, 2) }}</h1>
                            <div class="d-flex align-items-center justify-content-between pt-3 border-top border-white border-opacity-25 fs-13">
                                <span>Account Holder: <strong>{{ $customer->firstname }} {{ $customer->lastname }}</strong></span>
                                <button type="button" class="btn btn-light btn-sm rounded-pill fw-bold text-primary px-3 fs-12 shadow-sm" data-bs-toggle="modal" data-bs-target="#addFundsModal">
                                    <i class="bi bi-plus-circle me-1"></i> Add Funds
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Reward Points & Stats -->
                    <div class="col-md-7">
                        <div class="row g-3 h-100">
                            <div class="col-sm-6">
                                <div class="card border-light-subtle shadow-sm rounded-4 p-4 bg-white h-100 d-flex flex-row align-items-center gap-3">
                                    <div class="bg-success-subtle text-success rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                                        <i class="bi bi-award fs-22"></i>
                                    </div>
                                    <div>
                                        <span class="text-secondary fs-12 text-uppercase fw-bold">Reward Points</span>
                                        <h3 class="fw-bold text-dark mb-0 fs-24 mt-1">{{ number_format($customer->point ?? 0) }} pts</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card border-light-subtle shadow-sm rounded-4 p-4 bg-white h-100 d-flex flex-row align-items-center gap-3">
                                    <div class="bg-primary-subtle text-primary rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                                        <i class="bi bi-arrow-down-left-circle fs-22"></i>
                                    </div>
                                    <div>
                                        <span class="text-secondary fs-12 text-uppercase fw-bold">Total Deposit Requests</span>
                                        <h3 class="fw-bold text-dark mb-0 fs-24 mt-1">{{ count($fundRequests) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deposit History Table -->
                <div class="card border-light-subtle shadow-sm rounded-4 bg-white p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h4 class="fw-bold text-dark mb-1 fs-18">Fund Deposit Requests</h4>
                            <p class="text-muted fs-13 mb-0">History of your wallet top-up requests and status</p>
                        </div>
                        <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fs-13 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#addFundsModal">
                            <i class="bi bi-plus-lg me-1"></i> New Fund Request
                        </button>
                    </div>

                    @if(count($fundRequests) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light fs-13 text-secondary fw-bold">
                                    <tr>
                                        <th>REF ID</th>
                                        <th>DATE</th>
                                        <th>PAYMENT METHOD</th>
                                        <th>AMOUNT</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-14">
                                    @foreach($fundRequests as $req)
                                        <tr>
                                            <td class="fw-bold text-primary">#FR-{{ $req->id }}</td>
                                            <td class="text-secondary">{{ $req->created_at ? $req->created_at->format('M d, Y H:i') : 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-light text-dark border fs-12 fw-semibold px-2.5 py-1">
                                                    {{ $req->paymentMethod->name ?? 'Online Payment' }}
                                                </span>
                                            </td>
                                            <td class="fw-bold text-dark">${{ number_format($req->amount, 2) }}</td>
                                            <td>
                                                @if(($req->status ?? 0) == 1)
                                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fs-12 fw-semibold">Approved</span>
                                                @elseif(($req->status ?? 0) == 2)
                                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1 fs-12 fw-semibold">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-1 fs-12 fw-semibold">Pending Review</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-5 text-center">
                            <i class="bi bi-wallet2 fs-1 text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-3 fs-14">No wallet deposit requests found.</p>
                            <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fs-14 fw-semibold" data-bs-toggle="modal" data-bs-target="#addFundsModal">
                                Add Funds Now
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Add Funds Modal -->
<div class="modal fade" id="addFundsModal" tabindex="-1" aria-labelledby="addFundsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold text-dark fs-16" id="addFundsModalLabel"><i class="bi bi-plus-circle text-primary me-2"></i>Add Funds to Wallet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('customer.wallet.add-funds') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fs-13 fw-semibold text-dark">Amount ($) *</label>
                        <input type="number" step="0.01" min="1" name="amount" class="form-control shadow-none fs-14 py-2" placeholder="e.g. 100.00" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-13 fw-semibold text-dark">Payment Method *</label>
                        <select name="payment_method_id" class="form-select shadow-none fs-14 py-2" required>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-13 fw-semibold text-dark">Notes / Reference (Optional)</label>
                        <textarea name="notes" class="form-control shadow-none fs-14" rows="2" placeholder="Transaction ref or payment notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3 bg-light-subtle rounded-bottom-4">
                    <button type="button" class="btn btn-outline-secondary rounded-2 fw-semibold fs-13 px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-2 fw-semibold fs-13 px-4">Submit Deposit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
