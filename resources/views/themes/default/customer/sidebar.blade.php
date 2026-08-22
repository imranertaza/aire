@php
    $currentRoute = \Illuminate\Support\Facades\Route::currentRouteName();
    $sidebarCustomer = \Illuminate\Support\Facades\Auth::guard('customer')->user();
@endphp

@if ($sidebarCustomer)
    <div class="card border-light-subtle shadow-sm rounded-4 p-3 bg-white d-print-none mb-4">
        <!-- Quick Profile Summary -->
        <div class="text-center pb-3 border-bottom mb-3">
            <div class="mb-2 d-flex justify-content-center">
                @if ($sidebarCustomer->pic)
                    <img src="{{ getImageUrl($sidebarCustomer->pic) }}" class="rounded-circle border border-primary p-0.5"
                        alt="{{ $sidebarCustomer->firstname }}" style="width: 70px; height: 70px; object-fit: cover;">
                @else
                    <div class="rounded-circle border border-primary d-flex align-items-center justify-content-center fw-bold text-white fs-4"
                        style="width: 70px; height: 70px; background: linear-gradient(135deg, #0066CC 0%, #0055BB 100%) !important;">
                        {{ strtoupper(substr($sidebarCustomer->firstname, 0, 1)) }}
                    </div>
                @endif
            </div>
            <h6 class="fw-bold text-dark mb-0 fs-15">{{ $sidebarCustomer->firstname }} {{ $sidebarCustomer->lastname }}
            </h6>
            <span class="text-muted fs-12 d-block text-truncate"
                style="max-width: 100%;">{{ $sidebarCustomer->email }}</span>
        </div>

        <!-- Navigation Links -->
        <nav class="nav flex-column gap-1">
            <a class="nav-link rounded-3 px-3 py-2 fs-14 fw-semibold {{ $currentRoute == 'customer.dashboard' ? 'active' : 'text-dark' }}"
                href="{{ route('customer.dashboard') }}"
                @if ($currentRoute == 'customer.dashboard') style="background: var(--color-primary-bg); color: var(--color-primary);" @endif>
                <i class="bi bi-speedometer2 me-2" style="color: var(--color-primary);"></i> Dashboard
            </a>
            <a class="nav-link rounded-3 px-3 py-2 fs-14 fw-semibold {{ str_contains($currentRoute, 'customer.orders') || $currentRoute == 'customer.invoice' ? 'active' : 'text-dark' }}"
                href="{{ route('customer.orders') }}"
                @if (str_contains($currentRoute, 'customer.orders') || $currentRoute == 'customer.invoice') style="background: var(--color-primary-bg); color: var(--color-primary);" @endif>
                <i class="bi bi-box-seam me-2" style="color: var(--color-primary);"></i> My Orders
            </a>
            <a class="nav-link rounded-3 px-3 py-2 fs-14 fw-semibold {{ $currentRoute == 'customer.profile' ? 'active' : 'text-dark' }}"
                href="{{ route('customer.profile') }}"
                @if ($currentRoute == 'customer.profile') style="background: var(--color-primary-bg); color: var(--color-primary);" @endif>
                <i class="bi bi-person me-2" style="color: var(--color-primary);"></i> Profile
            </a>


            <a class="nav-link rounded-3 px-3 py-2 fs-14 fw-semibold {{ $currentRoute == 'customer.ledger' ? 'active' : 'text-dark' }}"
                href="{{ route('customer.ledger') }}"
                @if ($currentRoute == 'customer.ledger') style="background: var(--color-primary-bg); color: var(--color-primary);" @endif>
                <i class="bi bi-journal-text me-2" style="color: var(--color-primary);"></i> Ledger
            </a>

            <hr class="my-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="nav-link rounded-3 px-3 py-2 fs-14 fw-semibold text-danger border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </nav>
    </div>
@endif
