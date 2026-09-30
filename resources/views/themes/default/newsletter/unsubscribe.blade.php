@extends('themes.default.layouts.master')

@section('title', 'Unsubscribe from Newsletter | ' . config('app.name', 'Aire'))

@push('styles')
<style>
    .unsubscribe-page-wrapper {
        position: relative;
        min-height: 65vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem 1.5rem;
        background: radial-gradient(circle at 50% 20%, rgba(0, 102, 204, 0.03) 0%, rgba(248, 250, 252, 0.8) 70%, #ffffff 100%);
    }

    .unsubscribe-card {
        max-width: 580px;
        width: 100%;
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        padding: 2.5rem 2rem;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .unsubscribe-icon-box {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        font-size: 2rem;
    }

    .unsubscribe-icon-success {
        background-color: #f0fdf4;
        color: #16a34a;
        border: 2px solid #bbf7d0;
    }

    .unsubscribe-icon-error {
        background-color: #fef2f2;
        color: #dc2626;
        border: 2px solid #fecaca;
    }

    .unsubscribe-email-pill {
        display: inline-block;
        background: #f1f5f9;
        color: #334155;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.35rem 1rem;
        border-radius: 50px;
        margin-bottom: 1.25rem;
        border: 1px solid #e2e8f0;
    }

    .unsubscribe-divider {
        height: 1px;
        background-color: #f1f5f9;
        margin: 1.75rem 0;
    }
</style>
@endpush

@section('content')
<div class="unsubscribe-page-wrapper">
    <div class="unsubscribe-card">
        @if(session('success_message'))
            <div class="alert alert-success d-flex align-items-center gap-2 text-start rounded-3 py-2 px-3 mb-4 fs-14">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>{{ session('success_message') }}</div>
            </div>
        @elseif(session('error_message'))
            <div class="alert alert-danger d-flex align-items-center gap-2 text-start rounded-3 py-2 px-3 mb-4 fs-14">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>{{ session('error_message') }}</div>
            </div>
        @endif

        @if(!empty($result['success']))
            <div class="unsubscribe-icon-box unsubscribe-icon-success">
                <i class="bi bi-envelope-check"></i>
            </div>

            <h2 class="fs-22 fw-bold text-dark mb-2">You are Unsubscribed</h2>
            
            @if(!empty($result['email']))
                <div class="unsubscribe-email-pill">
                    {{ $result['email'] }}
                </div>
            @endif

            <p class="text-muted fs-14 mb-3">
                {{ $result['message'] }} You will no longer receive promotional updates and marketing emails from us.
            </p>

            <p class="text-muted fs-12 mb-0">
                <i class="bi bi-info-circle me-1"></i>
                Important transactional emails regarding your orders and account security will still be delivered.
            </p>

            <div class="unsubscribe-divider"></div>

            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center gap-2">
                <form action="{{ route('newsletter.resubscribe', ['token' => $token]) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark fw-semibold fs-14 px-4 py-2 rounded-3">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Unsubscribed by mistake? Re-subscribe
                    </button>
                </form>

                <a href="{{ route('home') }}" class="btn btn-dark fw-semibold fs-14 px-4 py-2 rounded-3 text-white text-decoration-none">
                    Return to Store
                </a>
            </div>
        @else
            <div class="unsubscribe-icon-box unsubscribe-icon-error">
                <i class="bi bi-exclamation-octagon"></i>
            </div>

            <h2 class="fs-22 fw-bold text-dark mb-2">Invalid or Expired Link</h2>
            
            <p class="text-muted fs-14 mb-4">
                {{ $result['message'] ?? 'We could not process this unsubscribe request. You may have already unsubscribed, or the link has expired.' }}
            </p>

            <div class="unsubscribe-divider"></div>

            <a href="{{ route('home') }}" class="btn btn-dark fw-semibold fs-14 px-4 py-2 rounded-3 text-white text-decoration-none">
                <i class="bi bi-house me-1"></i> Go to Homepage
            </a>
        @endif
    </div>
</div>
@endsection
