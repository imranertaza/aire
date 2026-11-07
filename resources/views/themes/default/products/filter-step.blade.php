@extends('themes.default.layouts.master')

@section('title', 'Aire | Guided Product Finder - Find Your Perfect Air Solution')

@push('styles')
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
    </noscript>

    <!-- Product Filter & Cards CSS -->
    <link rel="stylesheet" href="{{ theme_asset('css/product-filter.css') }}">

    <style>
        /* Exact 1:1 Guided Product Finder Styling matching mockups */
        .guided-finder-page {
            background-color: #ffffff;
            min-height: 85vh;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: #1e293b;
        }

        /* 2-Column Layout */
        .guided-finder-sidebar {
            border-right: 1px solid #f1f5f9;
            padding-top: 28px;
            padding-bottom: 50px;
            padding-right: 28px;
        }
        .guided-finder-main {
            padding-top: 28px;
            padding-bottom: 50px;
            padding-left: 36px;
        }
        @media (max-width: 991px) {
            .guided-finder-sidebar {
                border-right: none;
                border-bottom: 1px solid #f1f5f9;
                padding-right: 12px;
                padding-bottom: 24px;
            }
            .guided-finder-main {
                padding-left: 12px;
                padding-top: 24px;
            }
        }

        /* Sidebar Breadcrumb */
        .sidebar-breadcrumb {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }
        .sidebar-breadcrumb a {
            color: #64748b;
            text-decoration: none;
        }
        .sidebar-breadcrumb a:hover {
            color: #0088cc;
        }
        .sidebar-breadcrumb span {
            color: #1e293b;
            font-weight: 600;
        }

        /* Sidebar Stepper */
        .sidebar-section-title {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: #475569;
            text-transform: uppercase;
            margin-bottom: 22px;
        }
        .sidebar-step-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .sidebar-step-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            cursor: pointer;
            text-decoration: none;
            user-select: none;
            transition: opacity 0.15s ease;
        }
        .sidebar-step-circle {
            width: 26px;
            height: 26px;
            min-width: 26px;
            border-radius: 50%;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        /* Active & Completed Circles */
        .sidebar-step-item.active .sidebar-step-circle,
        .sidebar-step-item.completed .sidebar-step-circle {
            background-color: #0088cc;
            color: #ffffff;
            border: none;
        }
        /* Upcoming Circles */
        .sidebar-step-item.upcoming .sidebar-step-circle {
            background-color: #ffffff;
            border: 1.5px solid #cbd5e1;
            color: #94a3b8;
        }

        .sidebar-step-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 26px;
        }
        .sidebar-step-name {
            font-size: 11.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            line-height: 1.25;
            transition: color 0.15s ease;
        }
        .sidebar-step-item.active .sidebar-step-name,
        .sidebar-step-item.completed .sidebar-step-name {
            color: #0f172a;
        }
        .sidebar-step-item.upcoming .sidebar-step-name {
            color: #94a3b8;
            font-weight: 700;
        }

        .sidebar-step-status {
            font-size: 9.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 2px;
        }
        .sidebar-step-status.current {
            color: #0088cc;
        }
        .sidebar-step-status.completed {
            color: #64748b;
            font-weight: 700;
        }

        /* Sidebar Match Progress Box */
        .sidebar-match-progress {
            margin-top: 32px;
            padding-top: 22px;
            border-top: 1px solid #f1f5f9;
        }
        .sidebar-progress-label {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: #475569;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .sidebar-progress-track {
            height: 6px;
            background: #e2e8f0;
            border-radius: 999px;
            overflow: hidden;
        }
        .sidebar-progress-fill {
            background: #0088cc;
            height: 100%;
            border-radius: 999px;
            transition: width 0.3s ease;
        }
        .sidebar-progress-counter {
            color: #0088cc;
            font-size: 11.5px;
            font-weight: 800;
            margin-top: 8px;
            letter-spacing: 0.03em;
        }

        /* Main Content Header */
        .finder-title {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }
        .finder-subtitle {
            font-size: 14.5px;
            color: #64748b;
            margin-bottom: 24px;
        }

        /* Top Progress Bar across Main Content */
        .finder-top-progress-track {
            height: 6px;
            background: #e8eef3;
            border-radius: 999px;
            overflow: hidden;
            margin-bottom: 18px;
        }
        .finder-top-progress-fill {
            background: #0088cc;
            height: 100%;
            border-radius: 999px;
            transition: width 0.3s ease;
        }

        /* Meta Tag Row */
        .finder-meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        /* Step Heading */
        .finder-step-heading {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.01em;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Option Cards Grid (3 Columns) */
        .finder-options-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 22px;
        }
        @media (max-width: 991px) {
            .finder-options-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 575px) {
            .finder-options-grid {
                grid-template-columns: 1fr;
            }
        }

        .finder-option-card {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 13px 18px;
            cursor: pointer;
            min-height: 50px;
            user-select: none;
            transition: all 0.15s ease-in-out;
        }
        .finder-option-card:hover:not(.disabled) {
            border-color: #cbd5e1;
            background: #f8fafc;
        }
        .finder-option-card.selected {
            background-color: #e0f2fe !important;
            border-color: #0088cc !important;
            box-shadow: none;
        }

        /* Radio Indicator Circle */
        .finder-radio-circle {
            width: 18px;
            height: 18px;
            min-width: 18px;
            border-radius: 50%;
            background-color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
        }
        .finder-option-card.selected .finder-radio-circle {
            background-color: #0088cc;
        }
        .finder-radio-check-icon {
            display: none;
        }
        .finder-option-card.selected .finder-radio-check-icon {
            display: block;
        }

        /* Card Label */
        .finder-option-label {
            font-size: 13.5px;
            font-weight: 500;
            color: #334155;
            line-height: 1.35;
        }
        .finder-option-card.selected .finder-option-label {
            color: #0088cc;
            font-weight: 600;
        }
        .finder-option-card input {
            display: none !important;
        }

        /* Grid-aligned Action Buttons */
        .finder-btn-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-top: 20px;
            margin-bottom: 24px;
        }
        @media (max-width: 991px) {
            .finder-btn-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        .btn-finder-prev {
            grid-column: 1;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #1e293b;
            font-weight: 700;
            font-size: 12.5px;
            letter-spacing: 0.05em;
            padding: 13px;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            text-transform: uppercase;
            transition: all 0.15s ease;
        }
        .btn-finder-prev:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }
        .btn-finder-next {
            grid-column: 2 / span 2;
            background: #0088cc;
            border: none;
            color: #ffffff;
            font-weight: 700;
            font-size: 12.5px;
            letter-spacing: 0.05em;
            padding: 13px;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            text-transform: uppercase;
            transition: all 0.15s ease;
        }
        .btn-finder-next:hover {
            background: #0077b6;
        }
        .btn-finder-next.full-width {
            grid-column: 1 / span 3;
        }
        @media (max-width: 991px) {
            .btn-finder-next {
                grid-column: 2;
            }
            .btn-finder-next.full-width {
                grid-column: 1 / span 2;
            }
        }

        /* Answer So Far Box (Steps 1 to 7) */
        .answer-so-far-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 18px 24px;
            margin-bottom: 24px;
        }
        .answer-so-far-tag {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: #0088cc;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .answer-so-far-title {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .answer-so-far-desc {
            font-size: 12.5px;
            line-height: 1.55;
            color: #475569;
            margin-bottom: 0;
        }

        /* Target Product Box (Steps 8 to 10) */
        .target-product-box {
            background: #f8fbfa;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 18px 24px;
            margin-bottom: 24px;
        }
        .target-product-tag {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: #16a34a;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .target-product-title {
            font-size: 17px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .target-product-desc {
            font-size: 12.5px;
            line-height: 1.55;
            color: #475569;
            margin-bottom: 0;
        }

        /* Footnote */
        .finder-footnote {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            color: #94a3b8;
            text-transform: uppercase;
            margin-top: 36px;
            margin-bottom: 40px;
        }

        /* Matched Products & Other Matching Products Styling */
        .other-matched-products-wrapper {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #f1f5f9;
        }
        .other-matched-products-wrapper .title-2 {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }
        .product-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            padding: 16px;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
            border-color: #e2e8f0;
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
        }
        .product-card__badge-wrapper {
            position: absolute;
            top: 18px;
            left: 18px;
            z-index: 10;
        }
        .product-card__badge-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 10px;
            border-radius: 9999px;
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        }
        .product-card__badge-pill--low-stock {
            background-color: #ef4444 !important;
            margin-left: 4px;
        }
        .product-card__labels.position-absolute {
            position: absolute;
            top: 18px;
            right: -60px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 90;
        }
        .product-card:hover .product-card__labels.position-absolute {
            right: 18px !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        .product-card__labels button {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid #0088cc;
            background: #ffffff;
            padding: 0;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease;
        }
        .product-card__labels button svg path {
            fill: #0088cc;
            transition: fill 0.2s ease;
        }
        .product-card__labels button:hover,
        .product-card__labels button.active {
            background: #0088cc;
        }
        .product-card__labels button:hover svg path,
        .product-card__labels button.active svg path {
            fill: #ffffff;
        }
        .product-card__image-wrapper {
            width: 100%;
            height: 220px;
            display: block;
            overflow: hidden;
            border-radius: 14px;
            margin-bottom: 1rem;
            position: relative;
            background-color: #f8fafc;
        }
        .product-card__image-wrapper a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }
        .product-card__image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            transition: transform 0.35s ease;
        }
        .product-card:hover .product-card__image {
            transform: scale(1.05);
        }
        .product-card__title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.01em;
            margin-bottom: 4px;
            line-height: 1.3;
            min-height: 42px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-card__title a {
            color: #0f172a;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .product-card__title a:hover {
            color: #0088cc;
        }
        .product-card__category {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
            line-height: 1.35;
            min-height: 30px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-card__actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
            margin-bottom: 0.25rem;
            padding-top: 8px;
        }
        .product-card__price {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
        }
        .product-card__price.pre {
            text-decoration: line-through;
            font-size: 11.5px;
            font-weight: 500;
            color: #94a3b8;
            margin-bottom: 2px;
        }
        .product-card__btn-buy {
            background: #0088cc;
            color: #ffffff !important;
            font-size: 12px;
            font-weight: 700;
            padding: 8px 22px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        .product-card__btn-buy:hover {
            background: #0077b6;
            transform: translateY(-1px);
        }
        .product-card__btn-learn {
            color: #0088cc;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .product-card__btn-learn:hover {
            color: #0077b6;
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')
    <!-- Main Content: Clean 2-Column Responsive Layout matching mockups -->
    <main class="guided-finder-page">
        <div class="container">
            <div class="row g-0">

                <!-- LEFT COLUMN: Sidebar (col-lg-3) -->
                <aside class="col-lg-3 col-xl-3 guided-finder-sidebar">
                    <!-- Breadcrumb -->
                    <div class="sidebar-breadcrumb">
                        <a href="{{ route('home') }}">Home</a> &nbsp;&gt;&nbsp; <span>Product Finder</span>
                    </div>

                    <!-- Sidebar Section Title -->
                    <div class="sidebar-section-title">YOUR SELECTION JOURNEY</div>

                    <!-- Step Tracker List (Populated dynamically by jQuery and SSR fallback) -->
                    <div class="sidebar-step-list" id="sidebarStepList">
                        <div class="sidebar-step-item active" data-step="1">
                            <div class="sidebar-step-circle">01</div>
                            <div class="sidebar-step-info">
                                <div class="sidebar-step-name">APPLICATION</div>
                                <div class="sidebar-step-status current">CURRENT STEP</div>
                            </div>
                        </div>
                        <div class="sidebar-step-item upcoming" data-step="2">
                            <div class="sidebar-step-circle">02</div>
                            <div class="sidebar-step-info">
                                <div class="sidebar-step-name">PRODUCT FAMILY</div>
                            </div>
                        </div>
                        <div class="sidebar-step-item upcoming" data-step="3">
                            <div class="sidebar-step-circle">03</div>
                            <div class="sidebar-step-info">
                                <div class="sidebar-step-name">SPACE SIZE</div>
                            </div>
                        </div>
                        <div class="sidebar-step-item upcoming" data-step="4">
                            <div class="sidebar-step-circle">04</div>
                            <div class="sidebar-step-info">
                                <div class="sidebar-step-name">AIRFLOW</div>
                            </div>
                        </div>
                        <div class="sidebar-step-item upcoming" data-step="5">
                            <div class="sidebar-step-circle">05</div>
                            <div class="sidebar-step-info">
                                <div class="sidebar-step-name">AIR QUALITY NEEDS</div>
                            </div>
                        </div>
                        <div class="sidebar-step-item upcoming" data-step="6">
                            <div class="sidebar-step-circle">06</div>
                            <div class="sidebar-step-info">
                                <div class="sidebar-step-name">REQUIREMENTS</div>
                            </div>
                        </div>
                        <div class="sidebar-step-item upcoming" data-step="7">
                            <div class="sidebar-step-circle">07</div>
                            <div class="sidebar-step-info">
                                <div class="sidebar-step-name">BUDGET</div>
                            </div>
                        </div>
                        <div class="sidebar-step-item upcoming" data-step="8">
                            <div class="sidebar-step-circle">08</div>
                            <div class="sidebar-step-info">
                                <div class="sidebar-step-name">MATCHED SOLUTIONS</div>
                            </div>
                        </div>
                        <div class="sidebar-step-item upcoming" data-step="9">
                            <div class="sidebar-step-circle">09</div>
                            <div class="sidebar-step-info">
                                <div class="sidebar-step-name">PRODUCT RESULT</div>
                            </div>
                        </div>
                        <div class="sidebar-step-item upcoming" data-step="10">
                            <div class="sidebar-step-circle">10</div>
                            <div class="sidebar-step-info">
                                <div class="sidebar-step-name">MATCH SUMMARY</div>
                            </div>
                        </div>
                    </div>

                    <!-- Match Progress Box -->
                    <div class="sidebar-match-progress">
                        <div class="sidebar-progress-label">MATCH PROGRESS</div>
                        <div class="sidebar-progress-track">
                            <div class="sidebar-progress-fill" style="width: 10%;"></div>
                        </div>
                        <div class="sidebar-progress-counter" id="sidebarProgressCounter">STEP 1 OF 10</div>
                    </div>
                </aside>

                <!-- RIGHT COLUMN: Guided Product Finder Main Panel (col-lg-9) -->
                <div class="col-lg-9 col-xl-9 guided-finder-main">
                    <!-- Title Block -->
                    <h1 class="finder-title">Guided Product Finder</h1>
                    <p class="finder-subtitle">Find the right AIRE solution for your space, needs and preferences.</p>

                    <!-- Top Full-Width Progress Track -->
                    <div class="finder-top-progress-track">
                        <div class="finder-top-progress-fill" id="topProgressFill" style="width: 10%;"></div>
                    </div>

                    <!-- Dynamic Steps Container (Populated by jQuery and SSR initial Step 1) -->
                    <div id="wizardStepsContainer">
                        <div class="finder-meta-row">
                            <span>APPLICATION / ENVIRONMENT</span>
                            <span>STEP 1 / 10</span>
                        </div>
                        <h2 class="finder-step-heading">
                            <span>01</span> &nbsp;<span>WHERE WILL YOU USE IT?</span>
                        </h2>
                        <div class="finder-options-grid">
                            <div class="finder-option-card" data-step="1" data-val="car_vehicle" data-label="Car / Vehicle" data-explanation="Selected: Car / Vehicle. Routes to compact in-car or automotive air purification." data-type="radio">
                                <input type="radio" name="step_1" value="car_vehicle" tabindex="-1">
                                <div class="finder-radio-circle">
                                    <svg class="finder-radio-check-icon" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="finder-option-label">Car / Vehicle</span>
                            </div>
                            <div class="finder-option-card" data-step="1" data-val="personal_protection" data-label="Personal Protection" data-explanation="Selected: Personal Protection. Wearable and personal air filtering devices." data-type="radio">
                                <input type="radio" name="step_1" value="personal_protection" tabindex="-1">
                                <div class="finder-radio-circle">
                                    <svg class="finder-radio-check-icon" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="finder-option-label">Personal Protection</span>
                            </div>
                            <div class="finder-option-card" data-step="1" data-val="small_enclosed_space" data-label="Small Enclosed Space" data-explanation="Selected: Small Enclosed Space. Compact units tailored for tight cabins, closets, or small booths." data-type="radio">
                                <input type="radio" name="step_1" value="small_enclosed_space" tabindex="-1">
                                <div class="finder-radio-circle">
                                    <svg class="finder-radio-check-icon" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="finder-option-label">Small Enclosed Space</span>
                            </div>
                            <div class="finder-option-card selected" data-step="1" data-val="single_room" data-label="Single Room" data-explanation="Selected: Single Room. This routes the user to room-scale air solutions rather than vehicle, wearable or large-building systems." data-type="radio">
                                <input type="radio" name="step_1" value="single_room" checked tabindex="-1">
                                <div class="finder-radio-circle">
                                    <svg class="finder-radio-check-icon" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="finder-option-label">Single Room</span>
                            </div>
                            <div class="finder-option-card" data-step="1" data-val="bedroom" data-label="Bedroom" data-explanation="Selected: Bedroom. Prioritizes whisper-quiet, night-mode certified units." data-type="radio">
                                <input type="radio" name="step_1" value="bedroom" tabindex="-1">
                                <div class="finder-radio-circle">
                                    <svg class="finder-radio-check-icon" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="finder-option-label">Bedroom</span>
                            </div>
                            <div class="finder-option-card" data-step="1" data-val="living_room" data-label="Living Room" data-explanation="Selected: Living Room. Medium-to-high capacity air cleaning and ventilation." data-type="radio">
                                <input type="radio" name="step_1" value="living_room" tabindex="-1">
                                <div class="finder-radio-circle">
                                    <svg class="finder-radio-check-icon" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="finder-option-label">Living Room</span>
                            </div>
                            <div class="finder-option-card" data-step="1" data-val="home_apartment" data-label="Home / Apartment" data-explanation="Selected: Home / Apartment. Full residential or whole-apartment fresh air solutions." data-type="radio">
                                <input type="radio" name="step_1" value="home_apartment" tabindex="-1">
                                <div class="finder-radio-circle">
                                    <svg class="finder-radio-check-icon" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="finder-option-label">Home / Apartment</span>
                            </div>
                            <div class="finder-option-card" data-step="1" data-val="office" data-label="Office" data-explanation="Selected: Office. Low-noise commercial air filtration for productivity." data-type="radio">
                                <input type="radio" name="step_1" value="office" tabindex="-1">
                                <div class="finder-radio-circle">
                                    <svg class="finder-radio-check-icon" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="finder-option-label">Office</span>
                            </div>
                            <div class="finder-option-card" data-step="1" data-val="hospital_healthcare" data-label="Hospital / Healthcare" data-explanation="Selected: Hospital / Healthcare. Medical-grade pathogen and virus neutralization." data-type="radio">
                                <input type="radio" name="step_1" value="hospital_healthcare" tabindex="-1">
                                <div class="finder-radio-circle">
                                    <svg class="finder-radio-check-icon" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="finder-option-label">Hospital / Healthcare</span>
                            </div>
                            <div class="finder-option-card" data-step="1" data-val="school_classroom" data-label="School / Classroom" data-explanation="Selected: School / Classroom. High air exchange rate for crowded learning spaces." data-type="radio">
                                <input type="radio" name="step_1" value="school_classroom" tabindex="-1">
                                <div class="finder-radio-circle">
                                    <svg class="finder-radio-check-icon" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="finder-option-label">School / Classroom</span>
                            </div>
                            <div class="finder-option-card" data-step="1" data-val="commercial_building" data-label="Commercial Building" data-explanation="Selected: Commercial Building. Centralized high-capacity air treatment systems." data-type="radio">
                                <input type="radio" name="step_1" value="commercial_building" tabindex="-1">
                                <div class="finder-radio-circle">
                                    <svg class="finder-radio-check-icon" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="finder-option-label">Commercial Building</span>
                            </div>
                            <div class="finder-option-card" data-step="1" data-val="industrial_facility" data-label="Industrial Facility" data-explanation="Selected: Industrial Facility. Heavy-duty particulate and chemical exhaust filtration." data-type="radio">
                                <input type="radio" name="step_1" value="industrial_facility" tabindex="-1">
                                <div class="finder-radio-circle">
                                    <svg class="finder-radio-check-icon" width="10" height="8" viewBox="0 0 10 8" fill="none"><path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="finder-option-label">Industrial Facility</span>
                            </div>
                        </div>
                        <div class="finder-btn-grid">
                            <button type="button" class="btn-finder-next full-width" id="btnNextStep">NEXT &rarr;</button>
                        </div>
                        <div id="answerSoFarWrapper">
                            <div class="answer-so-far-box">
                                <div class="answer-so-far-tag">ANSWER SO FAR</div>
                                <div class="answer-so-far-title">Single Room</div>
                                <div class="answer-so-far-desc">Selected: Single Room. This routes the user to room-scale air solutions rather than vehicle, wearable or large-building systems.</div>
                            </div>
                        </div>
                        <div class="finder-footnote">FILLED EXAMPLE &mdash; FE6 JOURNEY &mdash; STEP 01</div>
                    </div>

                    <!-- Matched Products Section (Rendered dynamically when protocol steps complete) -->
                    <section id="other-matched-products"></section>
                </div>

            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        window.DYNAMIC_STEPS_DATA = @json($stepsData);
        window.FILTER_QUERY_URL = "{{ route('api.filter-step.query') }}";
        window.CATALOG_URL = "{{ route('products.filter') }}";
        window.CSRF_TOKEN = "{{ csrf_token() }}";
        window.INITIAL_PAGINATION = {
            currentPage: 1,
            lastPage: 1,
            hasMore: false
        };
    </script>
    <!-- GSAP & ScrollTrigger -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js" defer></script>
    <!-- Custom Product Filter JS -->
    <script src="{{ theme_asset('js/product-filter.js') }}" defer></script>
@endpush
