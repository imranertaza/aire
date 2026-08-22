@extends('themes.default.layouts.master')

@section('title', '404 - Page Not Found | AIRE Precision Solutions')

@push('styles')
<style>
    .error-page-wrapper {
        position: relative;
        overflow: hidden;
        background: radial-gradient(circle at 50% 20%, rgba(0, 102, 204, 0.04) 0%, rgba(248, 250, 252, 0.6) 70%, #ffffff 100%);
        min-height: calc(100vh - 160px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5rem 1.5rem;
    }

    /* Ambient Air Flow Halo */
    .error-ambient-halo {
        position: absolute;
        width: 550px;
        height: 550px;
        background: radial-gradient(circle, rgba(0, 102, 204, 0.12) 0%, rgba(0, 200, 83, 0.06) 50%, transparent 70%);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        filter: blur(50px);
        pointer-events: none;
        z-index: 0;
        animation: pulseAmbient 6s ease-in-out infinite alternate;
    }

    @keyframes pulseAmbient {
        0% { transform: translate(-50%, -50%) scale(0.95); opacity: 0.7; }
        100% { transform: translate(-50%, -50%) scale(1.15); opacity: 1; }
    }

    .error-card {
        position: relative;
        z-index: 1;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 24px;
        box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.07), 0 0 1px 1px rgba(255, 255, 255, 0.9) inset;
        max-width: 780px;
        width: 100%;
        padding: 3.5rem 2.5rem;
        text-align: center;
    }

    .error-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #0066cc;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 50px;
        margin-bottom: 1.75rem;
    }

    .error-badge-pulse {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #0066cc;
        box-shadow: 0 0 0 0 rgba(0, 102, 204, 0.6);
        animation: badgePulse 2s infinite;
    }

    @keyframes badgePulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(0, 102, 204, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(0, 102, 204, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(0, 102, 204, 0); }
    }

    .error-code {
        font-size: clamp(5.5rem, 12vw, 8.5rem);
        font-weight: 800;
        line-height: 1;
        letter-spacing: -3px;
        background: linear-gradient(135deg, #0f172a 0%, #0066cc 60%, #00c853 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
        user-select: none;
    }

    .error-title {
        font-size: clamp(1.4rem, 3vw, 2rem);
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.85rem;
        letter-spacing: -0.5px;
    }

    .error-desc {
        font-size: 1.05rem;
        color: #64748b;
        max-width: 540px;
        margin: 0 auto 2rem;
        line-height: 1.6;
    }

    /* Search bar inside 404 */
    .error-search-box {
        max-width: 480px;
        margin: 0 auto 2.25rem;
    }

    .error-search-input-group {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 50px;
        padding: 4px 6px 4px 18px;
        transition: all 0.25s ease;
    }

    .error-search-input-group:focus-within {
        border-color: #0066cc;
        box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.12);
        background: #ffffff;
    }

    .error-search-input-group input {
        border: none;
        background: transparent;
        outline: none;
        width: 100%;
        font-size: 0.95rem;
        color: #1e293b;
    }

    .error-search-input-group input::placeholder {
        color: #94a3b8;
    }

    .error-search-btn {
        border: none;
        background: #0066cc;
        color: #ffffff;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background-color 0.2s;
    }

    .error-search-btn:hover {
        background: #0052a3;
    }

    /* Action Buttons */
    .error-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        margin-bottom: 2.5rem;
    }

    .btn-aire-primary {
        background-color: #0066cc;
        color: #ffffff;
        font-size: 0.9rem;
        font-weight: 600;
        padding: 0.75rem 1.6rem;
        border-radius: 50px;
        border: 1px solid #0066cc;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-aire-primary:hover {
        background-color: #004d99;
        border-color: #004d99;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0, 102, 204, 0.25);
    }

    .btn-aire-outline {
        background-color: transparent;
        color: #0f172a;
        font-size: 0.9rem;
        font-weight: 600;
        padding: 0.75rem 1.6rem;
        border-radius: 50px;
        border: 1px solid #cbd5e1;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-aire-outline:hover {
        background-color: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a;
        transform: translateY(-1px);
    }

    /* Quick Shortcuts Grid */
    .error-quick-links {
        border-top: 1px solid #f1f5f9;
        padding-top: 2rem;
    }

    .error-quick-links-title {
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 1.25rem;
    }

    .quick-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #334155;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 6px 14px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
        margin: 4px;
    }

    .quick-pill:hover {
        background: #ffffff;
        border-color: #0066cc;
        color: #0066cc;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 102, 204, 0.08);
    }
</style>
@endpush

@section('content')
<main class="error-page-wrapper">
    <!-- Ambient Halo Background -->
    <div class="error-ambient-halo"></div>

    <div class="error-card">
        <!-- Status Header Badge -->
        <div class="error-badge">
            <span class="error-badge-pulse"></span>
            ATMOSPHERIC CALIBRATION // 404
        </div>

        <!-- Big 404 Gradient Number -->
        <div class="error-code">404</div>

        <!-- Heading & Message -->
        <h1 class="error-title">Lost in the Air Current</h1>
        <p class="error-desc">
            The page, product, or specification you are looking for has drifted out of reach or has been moved to new coordinates.
        </p>

        <!-- Search Form -->
        <form action="{{ route('products.filter') }}" method="GET" class="error-search-box">
            <div class="error-search-input-group">
                <input type="text" name="search" placeholder="Search clean air solutions, models, filters..." autocomplete="off">
                <button type="submit" class="error-search-btn" title="Search">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <!-- Primary Action Navigation -->
        <div class="error-actions">
            <a href="{{ route('home') }}" class="btn-aire-primary">
                <i class="bi bi-house-door-fill"></i>
                Return Home
            </a>
            <a href="{{ route('products.filter') }}" class="btn-aire-outline">
                <i class="bi bi-grid-fill"></i>
                Explore Catalog
            </a>
            <a href="{{ route('products.filter-step') }}" class="btn-aire-outline">
                <i class="bi bi-sliders"></i>
                Precision Wizard
            </a>
        </div>

        <!-- Quick Links / Popular Destinations -->
        <div class="error-quick-links">
            <div class="error-quick-links-title">Quick Portals</div>
            <div>
                <a href="{{ route('solutions') }}" class="quick-pill">
                    <i class="bi bi-shield-check text-primary"></i> Enterprise Solutions
                </a>
                <a href="{{ route('products.filter') }}?industry=residential" class="quick-pill">
                    <i class="bi bi-house text-success"></i> Residential Air
                </a>
                <a href="{{ route('products.filter') }}?industry=commercial" class="quick-pill">
                    <i class="bi bi-building text-info"></i> Commercial Systems
                </a>
                <a href="{{ route('contact') }}" class="quick-pill">
                    <i class="bi bi-headset text-warning"></i> Support & Inquiry
                </a>
            </div>
        </div>
    </div>
</main>
@endsection
