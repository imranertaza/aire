@php
    $currentRoute = \Illuminate\Support\Facades\Route::currentRouteName();
@endphp

<div class="bg-white border-bottom shadow-sm mb-4">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between py-2 overflow-auto text-nowrap gap-2"
            data-lenis-prevent>
            <div class="d-flex gap-2">
                <a href="{{ route('customer.dashboard') }}"
                    class="btn btn-sm rounded-pill px-3 py-2 fw-semibold fs-13 {{ $currentRoute == 'customer.dashboard' ? 'btn-primary text-white shadow-sm' : 'btn-light text-secondary border-0' }}">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
                <a href="{{ route('customer.orders') }}"
                    class="btn btn-sm rounded-pill px-3 py-2 fw-semibold fs-13 {{ str_contains($currentRoute, 'customer.orders') ? 'btn-primary text-white shadow-sm' : 'btn-light text-secondary border-0' }}">
                    <i class="bi bi-box-seam me-1"></i> My Orders
                </a>
                <a href="{{ route('customer.profile') }}"
                    class="btn btn-sm rounded-pill px-3 py-2 fw-semibold fs-13 {{ $currentRoute == 'customer.profile' ? 'btn-primary text-white shadow-sm' : 'btn-light text-secondary border-0' }}">
                    <i class="bi bi-person me-1"></i> Profile
                </a>
                <a href="{{ route('favorite') }}"
                    class="btn btn-sm rounded-pill px-3 py-2 fw-semibold fs-13 {{ $currentRoute == 'favorite' ? 'btn-primary text-white shadow-sm' : 'btn-light text-secondary border-0' }}">
                    <i class="bi bi-heart me-1"></i> My Wishlist
                </a>
                <a href="{{ route('customer.wallet') }}"
                    class="btn btn-sm rounded-pill px-3 py-2 fw-semibold fs-13 {{ $currentRoute == 'customer.wallet' ? 'btn-primary text-white shadow-sm' : 'btn-light text-secondary border-0' }}">
                    <i class="bi bi-wallet2 me-1"></i> Wallet
                </a>
                <a href="{{ route('customer.ledger') }}"
                    class="btn btn-sm rounded-pill px-3 py-2 fw-semibold fs-13 {{ $currentRoute == 'customer.ledger' ? 'btn-primary text-white shadow-sm' : 'btn-light text-secondary border-0' }}">
                    <i class="bi bi-journal-text me-1"></i> Ledger
                </a>
                <a href="{{ route('customer.points') }}"
                    class="btn btn-sm rounded-pill px-3 py-2 fw-semibold fs-13 {{ $currentRoute == 'customer.points' ? 'btn-primary text-white shadow-sm' : 'btn-light text-secondary border-0' }}">
                    <i class="bi bi-award me-1"></i> Points
                </a>
            </div>
            <div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit"
                        class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1.5 fw-semibold fs-13">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
