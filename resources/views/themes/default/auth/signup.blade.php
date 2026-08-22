@extends('themes.default.layouts.auth')

@section('title', 'Aire | Systems Authentication - Sign Up')

@section('content')
<!-- Header Section -->
<header class="auth-card-header">
    <a href="{{ route('home') }}" class="d-inline-block text-decoration-none">
        <img src="{{ theme_asset('img/logo.png') }}" alt="AIRE Logo" class="auth-logo">
    </a>
    <h1 class="auth-title mb-4">Systems Authentication</h1>
</header>

<!-- Sign Up Form -->
<form action="{{ route('signup.post') }}" method="POST" class="auth-form">
    @csrf

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger py-2 px-3 mb-3 rounded-3 fs-13">
            <ul class="mb-0 list-unstyled">
                @foreach($errors->all() as $error)
                    <li><i class="bi bi-exclamation-circle-fill me-1"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Name Field -->
    <div class="auth-field-group">
        <label for="signupName" class="auth-label">NAME</label>
        <div class="auth-input-wrap">
            <input type="text" id="signupName" name="name" class="auth-input" placeholder="syed irfan" value="{{ old('name') }}" required>
        </div>
    </div>

    <!-- Email Field -->
    <div class="auth-field-group">
        <label for="signupEmail" class="auth-label">EMAIL</label>
        <div class="auth-input-wrap">
            <input type="email" id="signupEmail" name="email" class="auth-input" placeholder="name@architecture.com" value="{{ old('email') }}" required>
            <span class="auth-input-icon">@</span>
        </div>
    </div>

    <!-- Password Field -->
    <div class="auth-field-group">
        <div class="auth-field-header">
            <label for="signupPassword" class="auth-label mb-0">PASSWORD</label>
            <a href="#" class="auth-forgot-link">Forgot Key?</a>
        </div>
        <div class="auth-input-wrap">
            <input type="password" id="signupPassword" name="password" class="auth-input" placeholder="••••••••" required>
            <button type="button" class="auth-input-icon"
                onclick="togglePasswordVisibility('signupPassword', this)"
                aria-label="Toggle Password Visibility">
                <i class="bi bi-eye-slash"></i>
            </button>
        </div>
    </div>

    <!-- Action Button -->
    <button type="submit" class="btn-auth-submit">
        Signup <i class="bi bi-arrow-right"></i>
    </button>
</form>

<!-- Card Footer Link -->
<footer class="auth-card-footer mt-4">
    <p class="auth-footer-text mb-0">
        Already have an account? <a href="{{ route('signin') }}" class="auth-footer-link">Sign In</a>
    </p>
</footer>
@endsection
