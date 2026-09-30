@extends('themes.default.layouts.auth')

@section('title', 'Aire | Reset Password')

@section('content')
    <!-- Header Section -->
    <header class="auth-card-header">
        <a href="{{ route('home') }}" class="d-inline-block text-decoration-none">
            <img src="{{ theme_asset('img/logo.png') }}" alt="AIRE Logo" class="auth-logo">
        </a>
        <h1 class="auth-title">Create New Password</h1>
        <p class="auth-subtitle">Ensure your new password contains at least 6 characters for optimal security.</p>
    </header>

    <!-- Reset Password Form -->
    <form action="{{ route('password.update') }}" method="POST" class="auth-form">
        @csrf

        <!-- Hidden Token -->
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Status Message -->
        @if (session('status'))
            <div class="alert alert-success py-2 px-3 mb-3 rounded-3 fs-13 d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill text-success flex-shrink-0"></i>
                <div>{{ session('status') }}</div>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger py-2 px-3 mb-3 rounded-3 fs-13">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle-fill me-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Email Field -->
        <div class="auth-field-group">
            <label for="resetEmail" class="auth-label">EMAIL ADDRESS</label>
            <div class="auth-input-wrap">
                <input type="email" id="resetEmail" name="email" class="auth-input" placeholder="name@architecture.com"
                    value="{{ $email ?? old('email') }}" required autocomplete="email">
                <span class="auth-input-icon">@</span>
            </div>
        </div>

        <!-- New Password Field -->
        <div class="auth-field-group">
            <label for="resetPassword" class="auth-label">NEW PASSWORD</label>
            <div class="auth-input-wrap">
                <input type="password" id="resetPassword" name="password" class="auth-input" placeholder="••••••••" required
                    autocomplete="new-password" minlength="6">
                <button type="button" class="auth-input-icon" onclick="togglePasswordVisibility('resetPassword', this)"
                    aria-label="Toggle Password Visibility">
                    <i class="bi bi-eye-slash"></i>
                </button>
            </div>
        </div>

        <!-- Confirm Password Field -->
        <div class="auth-field-group">
            <label for="resetPasswordConfirmation" class="auth-label">CONFIRM NEW PASSWORD</label>
            <div class="auth-input-wrap">
                <input type="password" id="resetPasswordConfirmation" name="password_confirmation" class="auth-input"
                    placeholder="••••••••" required autocomplete="new-password" minlength="6">
                <button type="button" class="auth-input-icon"
                    onclick="togglePasswordVisibility('resetPasswordConfirmation', this)"
                    aria-label="Toggle Password Visibility">
                    <i class="bi bi-eye-slash"></i>
                </button>
            </div>
        </div>

        <!-- Action Button -->
        <button type="submit" class="btn-auth-submit">
            Reset Password <i class="bi bi-shield-check ms-1"></i>
        </button>
    </form>

    <!-- Card Footer Link -->
    <footer class="auth-card-footer mt-4">
        <p class="auth-footer-text mb-0">
            Back to <a href="{{ route('home', ['auth' => 'signin']) }}" class="auth-footer-link">Sign In</a>
        </p>
    </footer>
@endsection
