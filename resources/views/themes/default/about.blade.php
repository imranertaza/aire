@extends('themes.default.layouts.master')

@section('title', 'Aire | About Us - Driving the Future of Clean Indoor Air')
@section('meta_description',
    'Learn about AIRE Industries — our mission, leadership, global patents, and commitment to
    delivering pure, healthy indoor environments through state-of-the-art air purification.')
@section('canonical_url', route('about'))
@section('og_type', 'website')
@section('og_image', theme_asset('img/about/earth_purpose.jpg'))

@push('styles')
    <link href="{{ theme_asset('css/about.css') }}" rel="stylesheet">
@endpush

@php
    $sidebarAds =
        $aboutAds ??
        \Illuminate\Support\Facades\Cache::remember('about_us_sidebar_ads_v1', 86400, function () {
            return \App\Models\Slider::where('enabled', 1)
                ->where(function ($q) {
                    $q->where('key', 'about_us')->orWhere('key', 'like', '%about_us%');
                })
                ->orderBy('order', 'asc')
                ->get();
        });
    $hasAds = $sidebarAds && $sidebarAds->count() > 0;

    $sections = $aboutSections ?? app(\App\Services\Storefront\StorefrontService::class)->getAboutSections();
    $heroSec = $sections['hero'] ?? getSection('about_hero', []);
    $storySec = $sections['story'] ?? getSection('about_story', []);
    $storyHeroImg = !empty($storySec['hero_image'])
        ? getImageUrl($storySec['hero_image'])
        : theme_asset('img/about/mountains.jpg');
    $mvSec = $sections['mission_vision'] ?? getSection('about_mission_vision', []);
    $leadSec = $sections['leadership'] ?? getSection('about_leadership', []);
    $innovSec = $sections['innovation'] ?? getSection('about_innovation', []);
    $qualSec = $sections['quality'] ?? getSection('about_quality', []);
    $careerSec = $sections['careers'] ?? getSection('about_careers', []);
    $newsSec = $sections['news'] ?? getSection('about_news', []);
    $globalSec = $sections['global'] ?? getSection('about_global', []);

    $aboutCanonical = route('about');
    $aboutOgImg = !empty($mvSec['purpose_image'])
        ? getImageUrl($mvSec['purpose_image'], null, null, ['raw' => true])
        : theme_asset('img/about/earth_purpose.jpg');
    $aboutLogo = !empty($settings['store_logo'])
        ? getImageUrl($settings['store_logo'], null, null, ['raw' => true])
        : theme_asset('img/logo.png');

    $aboutPageSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'AboutPage',
        '@id' => $aboutCanonical . '#webpage',
        'url' => $aboutCanonical,
        'name' => 'About AIRE Industries',
        'headline' => $heroSec['title'] ?? 'A Cleaner Tomorrow Starts Here',
        'description' =>
            'Learn about AIRE Industries — our mission, leadership, global patents, and commitment to delivering pure, healthy indoor environments through state-of-the-art air purification.',
        'image' => $aboutOgImg,
        'mainEntity' => [
            '@type' => 'Organization',
            'name' => config('app.name', 'Aire'),
            'url' => url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $aboutLogo,
            ],
            'description' =>
                'Global leader in advanced air purification systems, energy recovery ventilation, and pristine indoor air quality solutions.',
        ],
    ];

    $aboutBreadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => route('home'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'About Us',
                'item' => $aboutCanonical,
            ],
        ],
    ];
@endphp

@push('head')
    <link rel="preload" as="image" href="{{ $storyHeroImg }}" fetchpriority="high">
    <!-- Critical Above-the-Fold CSS for About Page (Zero FOUC & Restructure Flicker) -->
    <style>
        @charset "UTF-8";

        :root {
            --bs-blue: #0d6efd;
            --bs-indigo: #6610f2;
            --bs-purple: #6f42c1;
            --bs-pink: #d63384;
            --bs-red: #dc3545;
            --bs-orange: #fd7e14;
            --bs-yellow: #ffc107;
            --bs-green: #198754;
            --bs-teal: #20c997;
            --bs-cyan: #0dcaf0;
            --bs-black: #000;
            --bs-white: #fff;
            --bs-gray: #6c757d;
            --bs-gray-dark: #343a40;
            --bs-gray-100: #f8f9fa;
            --bs-gray-200: #e9ecef;
            --bs-gray-300: #dee2e6;
            --bs-gray-400: #ced4da;
            --bs-gray-500: #adb5bd;
            --bs-gray-600: #6c757d;
            --bs-gray-700: #495057;
            --bs-gray-800: #343a40;
            --bs-gray-900: #212529;
            --bs-primary: #0d6efd;
            --bs-secondary: #6c757d;
            --bs-success: #198754;
            --bs-info: #0dcaf0;
            --bs-warning: #ffc107;
            --bs-danger: #dc3545;
            --bs-light: #f8f9fa;
            --bs-dark: #212529;
            --bs-primary-rgb: 13, 110, 253;
            --bs-secondary-rgb: 108, 117, 125;
            --bs-success-rgb: 25, 135, 84;
            --bs-info-rgb: 13, 202, 240;
            --bs-warning-rgb: 255, 193, 7;
            --bs-danger-rgb: 220, 53, 69;
            --bs-light-rgb: 248, 249, 250;
            --bs-dark-rgb: 33, 37, 41;
            --bs-primary-text-emphasis: #052c65;
            --bs-secondary-text-emphasis: #2b2f32;
            --bs-success-text-emphasis: #0a3622;
            --bs-info-text-emphasis: #055160;
            --bs-warning-text-emphasis: #664d03;
            --bs-danger-text-emphasis: #58151c;
            --bs-light-text-emphasis: #495057;
            --bs-dark-text-emphasis: #495057;
            --bs-primary-bg-subtle: #cfe2ff;
            --bs-secondary-bg-subtle: #e2e3e5;
            --bs-success-bg-subtle: #d1e7dd;
            --bs-info-bg-subtle: #cff4fc;
            --bs-warning-bg-subtle: #fff3cd;
            --bs-danger-bg-subtle: #f8d7da;
            --bs-light-bg-subtle: #fcfcfd;
            --bs-dark-bg-subtle: #ced4da;
            --bs-primary-border-subtle: #9ec5fe;
            --bs-secondary-border-subtle: #c4c8cb;
            --bs-success-border-subtle: #a3cfbb;
            --bs-info-border-subtle: #9eeaf9;
            --bs-warning-border-subtle: #ffe69c;
            --bs-danger-border-subtle: #f1aeb5;
            --bs-light-border-subtle: #e9ecef;
            --bs-dark-border-subtle: #adb5bd;
            --bs-white-rgb: 255, 255, 255;
            --bs-black-rgb: 0, 0, 0;
            --bs-font-sans-serif: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            --bs-font-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            --bs-gradient: linear-gradient(180deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
            --bs-body-font-family: var(--bs-font-sans-serif);
            --bs-body-font-size: 1rem;
            --bs-body-font-weight: 400;
            --bs-body-line-height: 1.5;
            --bs-body-color: #212529;
            --bs-body-color-rgb: 33, 37, 41;
            --bs-body-bg: #fff;
            --bs-body-bg-rgb: 255, 255, 255;
            --bs-emphasis-color: #000;
            --bs-emphasis-color-rgb: 0, 0, 0;
            --bs-secondary-color: rgba(33, 37, 41, 0.75);
            --bs-secondary-color-rgb: 33, 37, 41;
            --bs-secondary-bg: #e9ecef;
            --bs-secondary-bg-rgb: 233, 236, 239;
            --bs-tertiary-color: rgba(33, 37, 41, 0.5);
            --bs-tertiary-color-rgb: 33, 37, 41;
            --bs-tertiary-bg: #f8f9fa;
            --bs-tertiary-bg-rgb: 248, 249, 250;
            --bs-heading-color: inherit;
            --bs-link-color: #0d6efd;
            --bs-link-color-rgb: 13, 110, 253;
            --bs-link-decoration: underline;
            --bs-link-hover-color: #0a58ca;
            --bs-link-hover-color-rgb: 10, 88, 202;
            --bs-code-color: #d63384;
            --bs-highlight-bg: #fff3cd;
            --bs-border-width: 1px;
            --bs-border-style: solid;
            --bs-border-color: #dee2e6;
            --bs-border-color-translucent: rgba(0, 0, 0, 0.175);
            --bs-border-radius: 0.375rem;
            --bs-border-radius-sm: 0.25rem;
            --bs-border-radius-lg: 0.5rem;
            --bs-border-radius-xl: 1rem;
            --bs-border-radius-xxl: 2rem;
            --bs-border-radius-2xl: var(--bs-border-radius-xxl);
            --bs-border-radius-pill: 50rem;
            --bs-box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            --bs-box-shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --bs-box-shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            --bs-box-shadow-inset: inset 0 1px 2px rgba(0, 0, 0, 0.075);
            --bs-focus-ring-width: 0.25rem;
            --bs-focus-ring-opacity: 0.25;
            --bs-focus-ring-color: rgba(13, 110, 253, 0.25);
            --bs-form-valid-color: #198754;
            --bs-form-valid-border-color: #198754;
            --bs-form-invalid-color: #dc3545;
            --bs-form-invalid-border-color: #dc3545
        }

        *,
        ::after,
        ::before {
            box-sizing: border-box
        }

        @media (prefers-reduced-motion:no-preference) {
            :root {
                scroll-behavior: smooth
            }
        }

        body {
            margin: 0;
            font-family: var(--bs-body-font-family);
            font-size: var(--bs-body-font-size);
            font-weight: var(--bs-body-font-weight);
            line-height: var(--bs-body-line-height);
            color: var(--bs-body-color);
            text-align: var(--bs-body-text-align);
            background-color: var(--bs-body-bg);
            -webkit-text-size-adjust: 100%
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            margin-top: 0;
            margin-bottom: .5rem;
            font-weight: 500;
            line-height: 1.2;
            color: var(--bs-heading-color)
        }

        h1 {
            font-size: calc(1.375rem + 1.5vw)
        }

        @media (min-width:1200px) {
            h1 {
                font-size: 2.5rem
            }
        }

        h2 {
            font-size: calc(1.325rem + .9vw)
        }

        @media (min-width:1200px) {
            h2 {
                font-size: 2rem
            }
        }

        h3 {
            font-size: calc(1.3rem + .6vw)
        }

        @media (min-width:1200px) {
            h3 {
                font-size: 1.75rem
            }
        }

        h4 {
            font-size: calc(1.275rem + .3vw)
        }

        @media (min-width:1200px) {
            h4 {
                font-size: 1.5rem
            }
        }

        h5 {
            font-size: 1.25rem
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem
        }

        ul {
            padding-left: 2rem
        }

        ul {
            margin-top: 0;
            margin-bottom: 1rem
        }

        small {
            font-size: .875em
        }

        a {
            color: rgba(var(--bs-link-color-rgb), var(--bs-link-opacity, 1));
            text-decoration: underline
        }

        kbd {
            font-family: var(--bs-font-monospace);
            font-size: 1em
        }

        kbd {
            padding: .1875rem .375rem;
            font-size: .875em;
            color: var(--bs-body-bg);
            background-color: var(--bs-body-color);
            border-radius: .25rem
        }

        img,
        svg {
            vertical-align: middle
        }

        label {
            display: inline-block
        }

        button {
            border-radius: 0
        }

        button,
        input {
            margin: 0;
            font-family: inherit;
            font-size: inherit;
            line-height: inherit
        }

        button {
            text-transform: none
        }

        [type=button],
        [type=submit],
        button {
            -webkit-appearance: button
        }

        ::-moz-focus-inner {
            padding: 0;
            border-style: none
        }

        ::-webkit-datetime-edit-day-field,
        ::-webkit-datetime-edit-fields-wrapper,
        ::-webkit-datetime-edit-hour-field,
        ::-webkit-datetime-edit-minute,
        ::-webkit-datetime-edit-month-field,
        ::-webkit-datetime-edit-text,
        ::-webkit-datetime-edit-year-field {
            padding: 0
        }

        ::-webkit-inner-spin-button {
            height: auto
        }

        [type=search] {
            outline-offset: -2px;
            -webkit-appearance: textfield
        }

        ::-webkit-search-decoration {
            -webkit-appearance: none
        }

        ::-webkit-color-swatch-wrapper {
            padding: 0
        }

        ::-webkit-file-upload-button {
            font: inherit;
            -webkit-appearance: button
        }

        ::file-selector-button {
            font: inherit;
            -webkit-appearance: button
        }

        .img-fluid {
            max-width: 100%;
            height: auto
        }

        .container {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            width: 100%;
            padding-right: calc(var(--bs-gutter-x) * .5);
            padding-left: calc(var(--bs-gutter-x) * .5);
            margin-right: auto;
            margin-left: auto
        }

        @media (min-width:576px) {
            .container {
                max-width: 540px
            }
        }

        @media (min-width:768px) {
            .container {
                max-width: 720px
            }
        }

        @media (min-width:992px) {
            .container {
                max-width: 960px
            }
        }

        @media (min-width:1200px) {
            .container {
                max-width: 1140px
            }
        }

        @media (min-width:1400px) {
            .container {
                max-width: 1320px
            }
        }

        :root {
            --bs-breakpoint-xs: 0;
            --bs-breakpoint-sm: 576px;
            --bs-breakpoint-md: 768px;
            --bs-breakpoint-lg: 992px;
            --bs-breakpoint-xl: 1200px;
            --bs-breakpoint-xxl: 1400px
        }

        .row {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(-1 * var(--bs-gutter-y));
            margin-right: calc(-.5 * var(--bs-gutter-x));
            margin-left: calc(-.5 * var(--bs-gutter-x))
        }

        .row>* {
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            padding-right: calc(var(--bs-gutter-x) * .5);
            padding-left: calc(var(--bs-gutter-x) * .5);
            margin-top: var(--bs-gutter-y)
        }

        .col-6 {
            flex: 0 0 auto;
            width: 50%
        }

        .col-12 {
            flex: 0 0 auto;
            width: 100%
        }

        .g-0 {
            --bs-gutter-x: 0
        }

        .g-0 {
            --bs-gutter-y: 0
        }

        @media (min-width:768px) {
            .col-md-5 {
                flex: 0 0 auto;
                width: 41.66666667%
            }

            .col-md-7 {
                flex: 0 0 auto;
                width: 58.33333333%
            }
        }

        @media (min-width:992px) {
            .col-lg-3 {
                flex: 0 0 auto;
                width: 25%
            }

            .col-lg-9 {
                flex: 0 0 auto;
                width: 75%
            }

            .g-lg-5 {
                --bs-gutter-x: 3rem
            }

            .g-lg-5 {
                --bs-gutter-y: 3rem
            }
        }

        @media (min-width:1200px) {
            .col-xl-6 {
                flex: 0 0 auto;
                width: 50%
            }

            .col-xl-9 {
                flex: 0 0 auto;
                width: 75%
            }
        }

        .form-control {
            display: block;
            width: 100%;
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--bs-body-color);
            background-color: var(--bs-body-bg);
            background-clip: padding-box;
            border: var(--bs-border-width) solid var(--bs-border-color);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: var(--bs-border-radius)
        }

        .form-control::-webkit-date-and-time-value {
            min-width: 85px;
            height: 1.5em;
            margin: 0
        }

        .form-control::-webkit-datetime-edit {
            display: block;
            padding: 0
        }

        .form-control::-moz-placeholder {
            color: var(--bs-secondary-color);
            opacity: 1
        }

        .form-control::-webkit-file-upload-button {
            padding: .375rem .75rem;
            margin: -.375rem -.75rem;
            -webkit-margin-end: .75rem;
            margin-inline-end: .75rem;
            color: var(--bs-body-color);
            background-color: var(--bs-tertiary-bg);
            border-color: inherit;
            border-style: solid;
            border-width: 0;
            border-inline-end-width: var(--bs-border-width);
            border-radius: 0
        }

        .form-check {
            display: block;
            min-height: 1.5rem;
            padding-left: 1.5em;
            margin-bottom: .125rem
        }

        .form-check .form-check-input {
            float: left;
            margin-left: -1.5em
        }

        .form-check-input {
            --bs-form-check-bg: var(--bs-body-bg);
            width: 1em;
            height: 1em;
            margin-top: .25em;
            vertical-align: top;
            background-color: var(--bs-form-check-bg);
            background-image: var(--bs-form-check-bg-image);
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            border: var(--bs-border-width) solid var(--bs-border-color);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            print-color-adjust: exact
        }

        .form-check-input[type=checkbox] {
            border-radius: .25em
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: .25rem;
            font-size: .875em;
            color: var(--bs-form-invalid-color)
        }

        .btn {
            --bs-btn-padding-x: 0.75rem;
            --bs-btn-padding-y: 0.375rem;
            --bs-btn-font-family: ;
            --bs-btn-font-size: 1rem;
            --bs-btn-font-weight: 400;
            --bs-btn-line-height: 1.5;
            --bs-btn-color: var(--bs-body-color);
            --bs-btn-bg: transparent;
            --bs-btn-border-width: var(--bs-border-width);
            --bs-btn-border-color: transparent;
            --bs-btn-border-radius: var(--bs-border-radius);
            --bs-btn-hover-border-color: transparent;
            --bs-btn-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075);
            --bs-btn-disabled-opacity: 0.65;
            --bs-btn-focus-box-shadow: 0 0 0 0.25rem rgba(var(--bs-btn-focus-shadow-rgb), .5);
            display: inline-block;
            padding: var(--bs-btn-padding-y) var(--bs-btn-padding-x);
            font-family: var(--bs-btn-font-family);
            font-size: var(--bs-btn-font-size);
            font-weight: var(--bs-btn-font-weight);
            line-height: var(--bs-btn-line-height);
            color: var(--bs-btn-color);
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            border: var(--bs-btn-border-width) solid var(--bs-btn-border-color);
            border-radius: var(--bs-btn-border-radius);
            background-color: var(--bs-btn-bg)
        }

        .btn-primary {
            --bs-btn-color: #fff;
            --bs-btn-bg: #0d6efd;
            --bs-btn-border-color: #0d6efd;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #0b5ed7;
            --bs-btn-hover-border-color: #0a58ca;
            --bs-btn-focus-shadow-rgb: 49, 132, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #0a58ca;
            --bs-btn-active-border-color: #0a53be;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: #0d6efd;
            --bs-btn-disabled-border-color: #0d6efd
        }

        .btn-dark {
            --bs-btn-color: #fff;
            --bs-btn-bg: #212529;
            --bs-btn-border-color: #212529;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #424649;
            --bs-btn-hover-border-color: #373b3e;
            --bs-btn-focus-shadow-rgb: 66, 70, 73;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #4d5154;
            --bs-btn-active-border-color: #373b3e;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: #212529;
            --bs-btn-disabled-border-color: #212529
        }

        .btn-outline-primary {
            --bs-btn-color: #0d6efd;
            --bs-btn-border-color: #0d6efd;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #0d6efd;
            --bs-btn-hover-border-color: #0d6efd;
            --bs-btn-focus-shadow-rgb: 13, 110, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #0d6efd;
            --bs-btn-active-border-color: #0d6efd;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #0d6efd;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #0d6efd;
            --bs-gradient: none
        }

        .fade:not(.show) {
            opacity: 0
        }

        .nav {
            --bs-nav-link-padding-x: 1rem;
            --bs-nav-link-padding-y: 0.5rem;
            --bs-nav-link-font-weight: ;
            --bs-nav-link-color: var(--bs-link-color);
            --bs-nav-link-hover-color: var(--bs-link-hover-color);
            --bs-nav-link-disabled-color: var(--bs-secondary-color);
            display: flex;
            flex-wrap: wrap;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none
        }

        .nav-link {
            display: block;
            padding: var(--bs-nav-link-padding-y) var(--bs-nav-link-padding-x);
            font-size: var(--bs-nav-link-font-size);
            font-weight: var(--bs-nav-link-font-weight);
            color: var(--bs-nav-link-color);
            text-decoration: none;
            background: 0 0;
            border: 0
        }

        .nav-pills {
            --bs-nav-pills-border-radius: var(--bs-border-radius);
            --bs-nav-pills-link-active-color: #fff;
            --bs-nav-pills-link-active-bg: #0d6efd
        }

        .nav-pills .nav-link {
            border-radius: var(--bs-nav-pills-border-radius)
        }

        .nav-pills .nav-link.active {
            color: var(--bs-nav-pills-link-active-color);
            background-color: var(--bs-nav-pills-link-active-bg)
        }

        .nav-fill .nav-item {
            flex: 1 1 auto;
            text-align: center
        }

        .nav-fill .nav-item .nav-link {
            width: 100%
        }

        .tab-content>.tab-pane {
            display: none
        }

        .tab-content>.active {
            display: block
        }

        .alert {
            --bs-alert-bg: transparent;
            --bs-alert-padding-x: 1rem;
            --bs-alert-padding-y: 1rem;
            --bs-alert-margin-bottom: 1rem;
            --bs-alert-color: inherit;
            --bs-alert-border-color: transparent;
            --bs-alert-border: var(--bs-border-width) solid var(--bs-alert-border-color);
            --bs-alert-border-radius: var(--bs-border-radius);
            --bs-alert-link-color: inherit;
            position: relative;
            padding: var(--bs-alert-padding-y) var(--bs-alert-padding-x);
            margin-bottom: var(--bs-alert-margin-bottom);
            color: var(--bs-alert-color);
            background-color: var(--bs-alert-bg);
            border: var(--bs-alert-border);
            border-radius: var(--bs-alert-border-radius)
        }

        .alert-danger {
            --bs-alert-color: var(--bs-danger-text-emphasis);
            --bs-alert-bg: var(--bs-danger-bg-subtle);
            --bs-alert-border-color: var(--bs-danger-border-subtle);
            --bs-alert-link-color: var(--bs-danger-text-emphasis)
        }

        .btn-close {
            --bs-btn-close-color: #000;
            --bs-btn-close-bg: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e");
            --bs-btn-close-opacity: 0.5;
            --bs-btn-close-hover-opacity: 0.75;
            --bs-btn-close-focus-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            --bs-btn-close-focus-opacity: 1;
            --bs-btn-close-disabled-opacity: 0.25;
            --bs-btn-close-white-filter: invert(1) grayscale(100%) brightness(200%);
            box-sizing: content-box;
            width: 1em;
            height: 1em;
            padding: .25em .25em;
            color: var(--bs-btn-close-color);
            background: transparent var(--bs-btn-close-bg) center/1em auto no-repeat;
            border: 0;
            border-radius: .375rem;
            opacity: var(--bs-btn-close-opacity)
        }

        .modal {
            --bs-modal-zindex: 1055;
            --bs-modal-width: 500px;
            --bs-modal-padding: 1rem;
            --bs-modal-margin: 0.5rem;
            --bs-modal-color: ;
            --bs-modal-bg: var(--bs-body-bg);
            --bs-modal-border-color: var(--bs-border-color-translucent);
            --bs-modal-border-width: var(--bs-border-width);
            --bs-modal-border-radius: var(--bs-border-radius-lg);
            --bs-modal-box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --bs-modal-inner-border-radius: calc(var(--bs-border-radius-lg) - (var(--bs-border-width)));
            --bs-modal-header-padding-x: 1rem;
            --bs-modal-header-padding-y: 1rem;
            --bs-modal-header-padding: 1rem 1rem;
            --bs-modal-header-border-color: var(--bs-border-color);
            --bs-modal-header-border-width: var(--bs-border-width);
            --bs-modal-title-line-height: 1.5;
            --bs-modal-footer-gap: 0.5rem;
            --bs-modal-footer-bg: ;
            --bs-modal-footer-border-color: var(--bs-border-color);
            --bs-modal-footer-border-width: var(--bs-border-width);
            position: fixed;
            top: 0;
            left: 0;
            z-index: var(--bs-modal-zindex);
            display: none;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            overflow-y: auto;
            outline: 0
        }

        .modal-dialog {
            position: relative;
            width: auto;
            margin: var(--bs-modal-margin)
        }

        .modal.fade .modal-dialog {
            transform: translate(0, -50px)
        }

        .modal-dialog-scrollable {
            height: calc(100% - var(--bs-modal-margin) * 2)
        }

        .modal-dialog-scrollable .modal-content {
            max-height: 100%;
            overflow: hidden
        }

        .modal-dialog-scrollable .modal-body {
            overflow-y: auto
        }

        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - var(--bs-modal-margin) * 2)
        }

        .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            color: var(--bs-modal-color);
            background-color: var(--bs-modal-bg);
            background-clip: padding-box;
            border: var(--bs-modal-border-width) solid var(--bs-modal-border-color);
            border-radius: var(--bs-modal-border-radius);
            outline: 0
        }

        .modal-body {
            position: relative;
            flex: 1 1 auto;
            padding: var(--bs-modal-padding)
        }

        @media (min-width:576px) {
            .modal {
                --bs-modal-margin: 1.75rem;
                --bs-modal-box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15)
            }

            .modal-dialog {
                max-width: var(--bs-modal-width);
                margin-right: auto;
                margin-left: auto
            }
        }

        .spinner-border {
            display: inline-block;
            width: var(--bs-spinner-width);
            height: var(--bs-spinner-height);
            vertical-align: var(--bs-spinner-vertical-align);
            border-radius: 50%;
            animation: var(--bs-spinner-animation-speed) linear infinite var(--bs-spinner-animation-name)
        }

        .spinner-border {
            --bs-spinner-width: 2rem;
            --bs-spinner-height: 2rem;
            --bs-spinner-vertical-align: -0.125em;
            --bs-spinner-border-width: 0.25em;
            --bs-spinner-animation-speed: 0.75s;
            --bs-spinner-animation-name: spinner-border;
            border: var(--bs-spinner-border-width) solid currentcolor;
            border-right-color: transparent
        }

        .spinner-border-sm {
            --bs-spinner-width: 1rem;
            --bs-spinner-height: 1rem;
            --bs-spinner-border-width: 0.2em
        }

        @media (prefers-reduced-motion:reduce) {
            .spinner-border {
                --bs-spinner-animation-speed: 1.5s
            }
        }

        .offcanvas {
            --bs-offcanvas-zindex: 1045;
            --bs-offcanvas-width: 400px;
            --bs-offcanvas-height: 30vh;
            --bs-offcanvas-padding-x: 1rem;
            --bs-offcanvas-padding-y: 1rem;
            --bs-offcanvas-color: var(--bs-body-color);
            --bs-offcanvas-bg: var(--bs-body-bg);
            --bs-offcanvas-border-width: var(--bs-border-width);
            --bs-offcanvas-border-color: var(--bs-border-color-translucent);
            --bs-offcanvas-box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --bs-offcanvas-title-line-height: 1.5
        }

        .offcanvas {
            position: fixed;
            bottom: 0;
            z-index: var(--bs-offcanvas-zindex);
            display: flex;
            flex-direction: column;
            max-width: 100%;
            color: var(--bs-offcanvas-color);
            visibility: hidden;
            background-color: var(--bs-offcanvas-bg);
            background-clip: padding-box;
            outline: 0
        }

        .offcanvas.offcanvas-start {
            top: 0;
            left: 0;
            width: var(--bs-offcanvas-width);
            border-right: var(--bs-offcanvas-border-width) solid var(--bs-offcanvas-border-color);
            transform: translateX(-100%)
        }

        .offcanvas-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: var(--bs-offcanvas-padding-y) var(--bs-offcanvas-padding-x)
        }

        .offcanvas-header .btn-close {
            padding: calc(var(--bs-offcanvas-padding-y) * .5) calc(var(--bs-offcanvas-padding-x) * .5);
            margin-top: calc(-.5 * var(--bs-offcanvas-padding-y));
            margin-right: calc(-.5 * var(--bs-offcanvas-padding-x));
            margin-bottom: calc(-.5 * var(--bs-offcanvas-padding-y))
        }

        .offcanvas-body {
            flex-grow: 1;
            padding: var(--bs-offcanvas-padding-y) var(--bs-offcanvas-padding-x);
            overflow-y: auto
        }

        .d-inline-block {
            display: inline-block !important
        }

        .d-block {
            display: block !important
        }

        .d-grid {
            display: grid !important
        }

        .d-flex {
            display: flex !important
        }

        .d-none {
            display: none !important
        }

        .shadow-none {
            box-shadow: none !important
        }

        .position-relative {
            position: relative !important
        }

        .position-absolute {
            position: absolute !important
        }

        .top-0 {
            top: 0 !important
        }

        .top-50 {
            top: 50% !important
        }

        .end-0 {
            right: 0 !important
        }

        .translate-middle-y {
            transform: translateY(-50%) !important
        }

        .border {
            border: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color) !important
        }

        .border-0 {
            border: 0 !important
        }

        .border-top {
            border-top: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color) !important
        }

        .border-bottom {
            border-bottom: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color) !important
        }

        .border-light-subtle {
            border-color: var(--bs-light-border-subtle) !important
        }

        .w-100 {
            width: 100% !important
        }

        .min-vh-100 {
            min-height: 100vh !important
        }

        .flex-column {
            flex-direction: column !important
        }

        .justify-content-end {
            justify-content: flex-end !important
        }

        .justify-content-center {
            justify-content: center !important
        }

        .justify-content-between {
            justify-content: space-between !important
        }

        .align-items-center {
            align-items: center !important
        }

        .m-3 {
            margin: 1rem !important
        }

        .mt-1 {
            margin-top: .25rem !important
        }

        .mt-3 {
            margin-top: 1rem !important
        }

        .mt-4 {
            margin-top: 1.5rem !important
        }

        .mt-auto {
            margin-top: auto !important
        }

        .me-1 {
            margin-right: .25rem !important
        }

        .me-2 {
            margin-right: .5rem !important
        }

        .me-3 {
            margin-right: 1rem !important
        }

        .mb-0 {
            margin-bottom: 0 !important
        }

        .mb-1 {
            margin-bottom: .25rem !important
        }

        .mb-2 {
            margin-bottom: .5rem !important
        }

        .mb-3 {
            margin-bottom: 1rem !important
        }

        .mb-4 {
            margin-bottom: 1.5rem !important
        }

        .ms-1 {
            margin-left: .25rem !important
        }

        .ms-3 {
            margin-left: 1rem !important
        }

        .ms-auto {
            margin-left: auto !important
        }

        .p-1 {
            padding: .25rem !important
        }

        .p-4 {
            padding: 1.5rem !important
        }

        .px-3 {
            padding-right: 1rem !important;
            padding-left: 1rem !important
        }

        .py-2 {
            padding-top: .5rem !important;
            padding-bottom: .5rem !important
        }

        .pt-3 {
            padding-top: 1rem !important
        }

        .pb-5 {
            padding-bottom: 3rem !important
        }

        .gap-1 {
            gap: .25rem !important
        }

        .gap-2 {
            gap: .5rem !important
        }

        .gap-3 {
            gap: 1rem !important
        }

        .fw-medium {
            font-weight: 500 !important
        }

        .fw-semibold {
            font-weight: 600 !important
        }

        .fw-bold {
            font-weight: 700 !important
        }

        .text-center {
            text-align: center !important
        }

        .text-decoration-none {
            text-decoration: none !important
        }

        .text-decoration-underline {
            text-decoration: underline !important
        }

        .text-uppercase {
            text-transform: uppercase !important
        }

        .text-primary {
            --bs-text-opacity: 1;
            color: rgba(var(--bs-primary-rgb), var(--bs-text-opacity)) !important
        }

        .text-secondary {
            --bs-text-opacity: 1;
            color: rgba(var(--bs-secondary-rgb), var(--bs-text-opacity)) !important
        }

        .text-light {
            --bs-text-opacity: 1;
            color: rgba(var(--bs-light-rgb), var(--bs-text-opacity)) !important
        }

        .text-dark {
            --bs-text-opacity: 1;
            color: rgba(var(--bs-dark-rgb), var(--bs-text-opacity)) !important
        }

        .text-white {
            --bs-text-opacity: 1;
            color: rgba(var(--bs-white-rgb), var(--bs-text-opacity)) !important
        }

        .text-muted {
            --bs-text-opacity: 1;
            color: var(--bs-secondary-color) !important
        }

        .bg-light {
            --bs-bg-opacity: 1;
            background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important
        }

        .bg-white {
            --bs-bg-opacity: 1;
            background-color: rgba(var(--bs-white-rgb), var(--bs-bg-opacity)) !important
        }

        .rounded-2 {
            border-radius: var(--bs-border-radius) !important
        }

        .rounded-3 {
            border-radius: var(--bs-border-radius-lg) !important
        }

        .rounded-pill {
            border-radius: var(--bs-border-radius-pill) !important
        }

        @media (min-width:768px) {
            .d-md-inline-flex {
                display: inline-flex !important
            }

            .ms-md-2 {
                margin-left: .5rem !important
            }

            .p-md-5 {
                padding: 3rem !important
            }

            .px-md-0 {
                padding-right: 0 !important;
                padding-left: 0 !important
            }

            .py-md-3 {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important
            }
        }

        @media (min-width:992px) {
            .d-lg-block {
                display: block !important
            }

            .d-lg-none {
                display: none !important
            }

            .px-lg-4 {
                padding-right: 1.5rem !important;
                padding-left: 1.5rem !important
            }

            .py-lg-0 {
                padding-top: 0 !important;
                padding-bottom: 0 !important
            }

            .pe-lg-4 {
                padding-right: 1.5rem !important
            }
        }

        @media (min-width:1200px) {
            .d-xl-block {
                display: block !important
            }

            .d-xl-none {
                display: none !important
            }
        }

        @font-face {
            font-display: block;
            font-family: "bootstrap-icons";
            src: url("./fonts/bootstrap-icons.woff2?dd67030699838ea613ee6dbda90effa6") format("woff2"), url("./fonts/bootstrap-icons.woff?dd67030699838ea613ee6dbda90effa6") format("woff")
        }

        .bi::before,
        [class*=" bi-"]::before {
            display: inline-block;
            font-family: bootstrap-icons !important;
            font-style: normal;
            font-weight: normal !important;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            vertical-align: -.125em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .bi-arrow-right::before {
            content: "\f138"
        }

        .bi-box-arrow-in-right::before {
            content: "\f1be"
        }

        .bi-briefcase::before {
            content: "\f1cc"
        }

        .bi-bullseye::before {
            content: "\f1de"
        }

        .bi-chevron-down::before {
            content: "\f282"
        }

        .bi-chevron-right::before {
            content: "\f285"
        }

        .bi-clock-history::before {
            content: "\f292"
        }

        .bi-droplet-half::before {
            content: "\f30c"
        }

        .bi-eye-slash::before {
            content: "\f340"
        }

        .bi-file-earmark-text::before {
            content: "\f38b"
        }

        .bi-globe::before {
            content: "\f3ee"
        }

        .bi-lightbulb::before {
            content: "\f46b"
        }

        .bi-list::before {
            content: "\f479"
        }

        .bi-megaphone::before {
            content: "\f484"
        }

        .bi-patch-check::before {
            content: "\f4b6"
        }

        .bi-people::before {
            content: "\f4d0"
        }

        .bi-person-plus::before {
            content: "\f4dd"
        }

        .bi-person::before {
            content: "\f4e1"
        }

        .bi-search::before {
            content: "\f52a"
        }

        .bi-shield-check::before {
            content: "\f52f"
        }

        .bi-telephone::before {
            content: "\f5c1"
        }

        .bi-x-circle-fill::before {
            content: "\f622"
        }

        .bi-x-lg::before {
            content: "\f659"
        }

        .bi-send::before {
            content: "\f6c0"
        }

        .bi-buildings::before {
            content: "\f87d"
        }

        :root {
            --swiper-theme-color: #007aff
        }

        :host {
            position: relative;
            display: block;
            margin-left: auto;
            margin-right: auto;
            z-index: 1
        }

        :root {
            --swiper-navigation-size: 44px
        }

        :root {
            --color-primary: #0095DA;
            --color-primary-hover: #0876a8;
            --color-primary-light: #2563eb;
            --color-primary-bg: #eff6ff;
            --color-primary-icon: #dbeafe;
            --color-primary-muted: #60a5fa;
            --color-dark: #0f172a;
            --color-dark-alt: #1e293b;
            --color-dark-mid: #334155;
            --color-muted: #64748b;
            --color-muted-mid: #94a3b8;
            --color-muted-light: #cbd5e1;
            --color-white: #ffffff;
            --color-bg: #f8fafc;
            --color-bg-alt: #f1f5f9;
            --color-bg-input: #232934;
            --color-border: #e2e8f0;
            --color-footer-bg: #0b0b0b;
            --color-footer-dark: #0f0f0f;
            --color-footer-darker: #1c212a;
            --color-footer-card: #151515;
            --color-footer-icon-bg: #262626;
            --color-footer-hr: #333333;
            --color-footer-text: #a3a3a3;
            --color-footer-subtitle: #737373;
            --color-footer-input: #222934;
            --color-white-60: rgba(255, 255, 255, 0.60);
            --color-white-50: rgba(255, 255, 255, 0.50);
            --color-white-20: rgba(255, 255, 255, 0.20);
            --color-white-15: rgba(255, 255, 255, 0.15);
            --color-white-12: rgba(255, 255, 255, 0.12);
            --color-white-10: rgba(255, 255, 255, 0.10);
            --color-white-08: rgba(255, 255, 255, 0.08);
            --color-white-05: rgba(255, 255, 255, 0.05);
            --color-white-03: rgba(255, 255, 255, 0.03);
            --color-dark-shadow-sm: rgba(15, 23, 42, 0.04);
            --color-dark-shadow: rgba(15, 23, 42, 0.08);
            --color-dark-shadow-md: rgba(15, 23, 42, 0.12);
            --color-primary-shadow: rgba(29, 78, 216, 0.20);
            --color-primary-shadow-md: rgba(29, 78, 216, 0.30);
            --color-primary-glow: rgba(37, 99, 235, 0.40);
            --primary-color: var(--color-primary);
            --primary-hover: var(--color-primary-hover);
            --primary-blue: var(--color-primary);
            --primary-hover-blue: var(--color-primary-hover);
            --accent-blue: var(--color-primary-light);
            --bg-color: var(--color-bg);
            --text-dark: var(--color-dark);
            --text-muted: var(--color-muted);
            --border-color: var(--color-border);
            --active-bg: var(--color-primary-bg);
            --fs-h1: 24px;
            --fs-h2: 20px;
            --fs-h3: 18px;
            --fs-body: 14px;
            --fs-sm: 12px;
            --fs-xs: 10px
        }

        html {
            scroll-behavior: auto !important
        }

        [data-lenis-prevent] {
            overscroll-behavior: contain !important;
            touch-action: pan-y
        }

        html,
        body {
            overflow-x: clip;
            max-width: 100%
        }

        body {
            font-family: 'Inter', sans-serif !important;
            font-size: var(--fs-body);
            line-height: 1.6;
            background-color: var(--color-bg);
            color: var(--color-dark)
        }

        h1 {
            font-size: var(--fs-h1);
            font-weight: 700;
            line-height: 1.25;
            letter-spacing: -0.3px
        }

        h2 {
            font-size: var(--fs-h2);
            font-weight: 700;
            line-height: 1.30;
            letter-spacing: -0.2px
        }

        h3 {
            font-size: var(--fs-h3);
            font-weight: 600;
            line-height: 1.35
        }

        h4 {
            font-size: var(--fs-body);
            font-weight: 600;
            line-height: 1.40
        }

        h5 {
            font-size: var(--fs-body);
            font-weight: 600
        }

        p {
            font-size: var(--fs-body);
            line-height: 1.6
        }

        small {
            font-size: var(--fs-sm)
        }

        .fs-20 {
            font-size: 20px
        }

        .fs-14 {
            font-size: 14px
        }

        .fs-13 {
            font-size: 13px
        }

        .fs-12 {
            font-size: 12px
        }

        .fs-32 {
            font-size: 24px
        }

        .offcanvas {
            z-index: 1045
        }

        .header-count-badge,
        .cart-count-badge,
        .favorite-count-badge,
        .compare-count-badge {
            position: absolute;
            top: -4px;
            right: -6px;
            width: 18px;
            height: 18px;
            min-width: 18px;
            min-height: 18px;
            max-width: 18px;
            max-height: 18px;
            border-radius: 50% !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px !important;
            font-weight: 700 !important;
            line-height: 1 !important;
            padding: 0 !important;
            text-align: center;
            color: #ffffff !important;
            border: 1.5px solid #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            transform: none !important;
            z-index: 10;
            box-sizing: border-box
        }

        .header-count-badge.d-none,
        .cart-count-badge.d-none,
        .favorite-count-badge.d-none,
        .compare-count-badge.d-none {
            display: none !important
        }

        .cart-count-badge {
            background-color: var(--color-primary-light, #2563eb) !important
        }

        .favorite-count-badge,
        .compare-count-badge {
            background-color: #ef4444 !important
        }

        .btn-primary {
            background-color: var(--color-primary) !important;
            border-color: var(--color-primary) !important;
            color: #ffffff !important
        }

        .btn-outline-primary {
            color: var(--color-primary) !important;
            border-color: var(--color-primary) !important
        }

        .text-primary {
            color: var(--color-primary) !important
        }

        .main-container {
            max-width: 1280px !important;
            margin-left: auto !important;
            margin-right: auto !important
        }

        .container {
            max-width: 1280px !important;
            margin-left: auto;
            margin-right: auto
        }

        .sticky-sidebar {
            position: -webkit-sticky;
            position: sticky;
            top: 100px;
            z-index: 90;
            max-height: calc(100vh - 120px);
            overflow-y: auto !important;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px
        }

        ::-webkit-scrollbar-track {
            background: transparent
        }

        ::-webkit-scrollbar-thumb {
            background: var(--color-muted-light);
            border-radius: 4px
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--color-muted-mid)
        }

        * {
            scrollbar-width: thin;
            scrollbar-color: var(--color-muted-light) transparent
        }

        .border-right1px {
            border-right: 1px solid var(--color-border) !important;
            padding-bottom: 120px
        }

        @media (max-width:991.98px) {
            .border-right1px {
                border-right: none !important;
                padding-bottom: 0
            }
        }

        .center-feed {
            padding: 30px;
            padding-bottom: 120px;
            overflow: visible
        }

        .content-section {
            padding-top: 10px
        }

        .header-count-badge,
        .cart-count-badge,
        .favorite-count-badge,
        .compare-count-badge {
            position: absolute;
            top: -4px;
            right: -6px;
            width: 18px;
            height: 18px;
            min-width: 18px;
            min-height: 18px;
            max-width: 20px;
            max-height: 20px;
            border-radius: 50% !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px !important;
            font-weight: 600 !important;
            line-height: 1 !important;
            padding: 0 !important;
            text-align: center;
            color: #ffffff !important;
            border: 1.5px solid #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            transform: none !important;
            z-index: 10;
            box-sizing: border-box
        }

        .header-count-badge.d-none,
        .cart-count-badge.d-none,
        .favorite-count-badge.d-none,
        .compare-count-badge.d-none {
            display: none !important
        }

        .cart-count-badge {
            background-color: var(--color-primary, #2563eb) !important
        }

        .favorite-count-badge,
        .compare-count-badge {
            background-color: #ef4444 !important
        }

        header.site-header {
            border-bottom: 1px solid var(--border-color);
            z-index: 1020
        }

        .site-header {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            border-bottom: 1px solid var(--border-color);
            z-index: 1020
        }

        .site-header .row {
            --bs-gutter-x: 0 !important
        }

        .brand-logo {
            letter-spacing: -1px
        }

        .main-nav {
            width: 100%;
            justify-content: space-between
        }

        .main-nav .nav-link {
            color: var(--text-dark);
            font-weight: 500;
            font-size: 14px;
            position: relative
        }

        .main-nav .nav-link:first-child {
            padding-left: 0 !important
        }

        .main-nav .nav-link:last-child {
            padding-right: 0 !important
        }

        .main-nav .nav-link.active {
            color: var(--primary-color);
            line-height: 20px !important
        }

        .main-nav .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -9px;
            left: 0;
            height: 3px;
            width: 100%;
            background-color: var(--primary-color);
            border-radius: 3px 3px 0 0
        }

        .mobile-nav {
            display: flex;
            flex-direction: column;
            gap: 4px
        }

        .mobile-nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14.5px;
            font-weight: 500;
            color: #334155;
            text-decoration: none;
            position: relative;
            border-left: 3px solid transparent
        }

        .mobile-nav-link.active {
            color: var(--color-primary) !important;
            background-color: var(--color-primary-bg) !important;
            font-weight: 700 !important;
            border-left: 3px solid var(--color-primary) !important;
            padding-left: 14px !important
        }

        .mobile-nav-link__text {
            flex: 1
        }

        .mobile-nav-link.active::after {
            content: '';
            display: inline-block;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: var(--color-primary);
            box-shadow: 0 0 8px var(--color-primary-glow);
            flex-shrink: 0;
            margin-left: auto
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 6px
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--text-dark)
        }

        .menu-item.active {
            background-color: var(--active-bg);
            color: var(--primary-color)
        }

        .menu-item .icon-box {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background-color: #f1f5f9;
            display: flex;
            padding: 10px;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--text-muted);
            flex-shrink: 0
        }

        .menu-item .icon-box i {
            font-size: 15px
        }

        .menu-item.active .icon-box {
            background-color: var(--color-primary-icon);
            color: var(--color-primary)
        }

        .menu-item .text-box h2 {
            font-weight: 600;
            font-size: 14px;
            letter-spacing: -0.2px
        }

        .menu-item .text-box small {
            color: var(--text-muted);
            font-size: 10px;
            display: block
        }

        .menu-item.active .text-box small {
            color: var(--color-primary-muted)
        }

        .menu-item .chevron {
            color: #cbd5e1;
            font-size: 12px
        }

        .menu-item.active .chevron {
            color: var(--primary-color)
        }

        .mobile-category-scroll-wrapper {
            position: sticky;
            top: 0px;
            z-index: 1010;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            margin: -10px -12px 18px -12px;
            padding: 10px 12px 6px 12px;
            border-bottom: 1px solid #f1f5f9;
            touch-action: pan-x
        }

        .mobile-category-scroll-track {
            display: flex;
            align-items: center;
            gap: 8px;
            overflow-x: auto !important;
            overflow-y: hidden !important;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            touch-action: pan-x !important;
            overscroll-behavior-x: contain
        }

        .mobile-category-scroll-track::-webkit-scrollbar {
            display: none
        }

        .mobile-cat-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            text-decoration: none;
            color: #475569;
            font-size: 12px;
            font-weight: 500;
            flex-shrink: 0;
            line-height: 1;
            touch-action: pan-x
        }

        .mobile-cat-pill.active {
            background: var(--color-primary);
            border-color: var(--color-primary);
            color: #ffffff !important;
            box-shadow: 0 3px 10px var(--color-primary-shadow)
        }

        .mobile-cat-pill.active .mobile-cat-pill__icon,
        .mobile-cat-pill.active .mobile-cat-pill__icon i {
            color: #ffffff !important;
            fill: #ffffff !important
        }

        .mobile-cat-pill__icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #64748b;
            line-height: 1
        }

        .mobile-special-pill__text {
            flex: 1;
            font-size: 13px;
            line-height: 1.25;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis
        }

        @media (max-width:480px) {
            .mobile-special-pill__text {
                font-size: 12px
            }
        }

        .mobile-nav-special {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            border-radius: 6px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600
        }

        .mobile-nav-special .special-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            margin-right: 10px;
            flex-shrink: 0
        }

        .mobile-nav-special .special-icon svg,
        .mobile-nav-special .special-icon img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain
        }

        .mobile-nav-special .chevron {
            font-size: 12px;
            color: #94a3b8;
            margin-left: auto
        }

        .site-footer .col-lg-3:first-child div,
        .site-footer .col-lg-3:first-child span {
            text-align: right !important
        }

        .logo-header-img {
            max-height: 28px
        }

        .aire-search-backdrop {
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 10550;
            opacity: 0
        }

        .aire-search-modal {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(-12px) scale(0.98);
            width: 860px;
            max-width: 94vw;
            z-index: 10560;
            opacity: 0
        }

        .aire-search-modal-container {
            display: flex;
            flex-direction: column;
            gap: 12px
        }

        .aire-search-bar {
            display: flex;
            align-items: center;
            background: #ffffff;
            border-radius: 14px;
            padding: 5px;
            box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.15), 0 0 0 1px rgba(226, 232, 240, 0.9);
            overflow: hidden;
            width: 100%;
            box-sizing: border-box
        }

        .aire-search-input-wrap {
            flex: 1;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 10px 0 12px
        }

        .aire-search-icon-input {
            color: #94a3b8;
            font-size: 17px;
            flex-shrink: 0
        }

        .aire-search-input {
            flex: 1;
            min-width: 0;
            width: 100%;
            border: none;
            outline: none;
            font-size: 15.5px;
            font-weight: 500;
            color: #0f172a;
            background: transparent;
            height: 42px;
            font-family: var(--font-sans, 'Inter', sans-serif)
        }

        .aire-search-input::-webkit-search-cancel-button,
        .aire-search-input::-webkit-search-decoration,
        .aire-search-input::-webkit-search-results-button,
        .aire-search-input::-webkit-search-results-decoration {
            -webkit-appearance: none;
            appearance: none;
            display: none
        }

        .aire-search-clear {
            background: transparent;
            border: none;
            color: #94a3b8;
            font-size: 16px;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0
        }

        .aire-search-submit {
            background: var(--color-primary, #0066cc);
            border: none;
            color: #ffffff;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 16px
        }

        .aire-search-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.25), 0 0 0 1px rgba(226, 232, 240, 0.85);
            padding: 24px 26px 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 100px)
        }

        .aire-search-header {
            margin-bottom: 18px;
            flex-shrink: 0
        }

        .aire-search-heading {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.25;
            margin: 0 0 4px 0;
            letter-spacing: -0.3px
        }

        .aire-search-subheading {
            font-size: 13.5px;
            color: #64748b;
            margin: 0;
            font-weight: 400
        }

        .aire-search-kbd-hint {
            font-size: 12px;
            color: #94a3b8
        }

        .aire-search-kbd-hint kbd {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            padding: 2px 7px;
            font-size: 11px;
            font-weight: 600;
            color: #475569;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05)
        }

        .aire-search-close-btn {
            background: transparent;
            border: none;
            color: #64748b;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px
        }

        .aire-popular-section {
            padding-top: 2px;
            margin-bottom: 20px
        }

        .aire-popular-title {
            font-size: 13.5px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 12px 0
        }

        .aire-popular-chips-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 8px
        }

        .aire-search-chip {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            padding: 6px 14px;
            font-size: 12.5px;
            font-weight: 500;
            color: #334155;
            display: inline-flex;
            align-items: center;
            gap: 6px
        }

        .aire-not-sure-box {
            background: linear-gradient(135deg, #f0f7ff 0%, #e8f4ff 100%);
            border: 1px solid #c7e2fe;
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px
        }

        .aire-not-sure-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #ffffff;
            color: var(--color-primary, #0066cc);
            border: 1px solid #bae6fd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 102, 204, 0.12)
        }

        .aire-not-sure-title {
            font-size: 13.5px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px
        }

        .aire-not-sure-desc {
            font-size: 12.5px;
            color: #475569;
            line-height: 1.45
        }

        .aire-btn-try-example {
            background: transparent;
            border: none;
            color: var(--color-primary, #0066cc);
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 8px
        }

        .aire-search-guidance {
            overflow-y: auto;
            overflow-x: hidden;
            max-height: calc(100vh - 210px);
            padding-right: 2px
        }

        .aire-search-results {
            max-height: calc(100vh - 210px);
            overflow-y: auto;
            overflow-x: hidden;
            padding-top: 4px;
            padding-right: 6px
        }

        .aire-search-results::-webkit-scrollbar,
        .aire-search-guidance::-webkit-scrollbar {
            width: 6px
        }

        .aire-search-results::-webkit-scrollbar-track,
        .aire-search-guidance::-webkit-scrollbar-track {
            background: transparent
        }

        .aire-search-results::-webkit-scrollbar-thumb,
        .aire-search-guidance::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px
        }

        @media (max-width:768px) {
            .aire-search-modal {
                top: 12px;
                width: 100%;
                max-width: calc(100vw - 20px)
            }

            .aire-search-bar {
                padding: 4px;
                border-radius: 12px
            }

            .aire-search-input-wrap {
                padding: 0 8px 0 10px;
                gap: 6px
            }

            .aire-search-input {
                font-size: 16px;
                height: 38px
            }

            .aire-search-submit {
                width: 38px;
                height: 38px;
                border-radius: 9px;
                font-size: 15px
            }

            .aire-search-card {
                padding: 18px 16px 16px;
                border-radius: 16px;
                max-height: calc(100dvh - 80px)
            }

            .aire-search-header {
                margin-bottom: 14px
            }

            .aire-search-heading {
                font-size: 17px
            }

            .aire-search-subheading {
                font-size: 12px
            }

            .aire-popular-section {
                padding-top: 0;
                margin-bottom: 14px
            }

            .aire-not-sure-box {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                padding: 12px 14px
            }

            .aire-btn-try-example {
                align-self: flex-end
            }

            .aire-search-results {
                max-height: calc(100dvh - 170px)
            }
        }

        @media (max-width:576px) {
            .aire-search-modal {
                top: 8px;
                max-width: calc(100vw - 16px)
            }

            .aire-search-bar {
                padding: 3px;
                border-radius: 11px
            }

            .aire-search-input-wrap {
                padding: 0 6px 0 8px;
                gap: 6px
            }

            .aire-search-input {
                font-size: 16px;
                height: 36px
            }

            .aire-search-submit {
                width: 36px;
                height: 36px;
                border-radius: 8px;
                font-size: 14px
            }

            .aire-search-card {
                padding: 14px 12px 12px;
                border-radius: 14px;
                max-height: calc(100dvh - 72px)
            }

            .aire-search-heading {
                font-size: 15.5px;
                line-height: 1.25
            }

            .aire-search-subheading {
                font-size: 11px;
                line-height: 1.35
            }

            .aire-search-close-btn {
                width: 30px;
                height: 30px;
                font-size: 13px
            }

            .aire-popular-section {
                padding-top: 10px;
                margin-bottom: 10px
            }

            .aire-popular-title {
                font-size: 12px;
                margin-bottom: 8px
            }

            .aire-popular-chips-wrap {
                gap: 6px
            }

            .aire-search-chip {
                padding: 4px 10px;
                font-size: 11px
            }

            .aire-not-sure-box {
                padding: 10px 10px;
                border-radius: 11px;
                gap: 8px
            }

            .aire-not-sure-icon {
                width: 28px;
                height: 28px;
                font-size: 13px
            }

            .aire-not-sure-title {
                font-size: 12px
            }

            .aire-not-sure-desc {
                font-size: 10.5px;
                line-height: 1.35
            }

            .aire-btn-try-example {
                font-size: 11px;
                padding: 2px 4px
            }

            .aire-search-results {
                max-height: calc(100dvh - 150px);
                padding-right: 2px
            }
        }

        html {
            scrollbar-gutter: stable
        }

        .modal {
            padding-right: 0px !important
        }

        .modal.auth-modal {
            z-index: 10555 !important
        }

        .auth-modal {
            z-index: 10555 !important
        }

        .auth-modal .modal-dialog {
            max-width: 460px;
            margin: 1.75rem auto;
            position: relative;
            z-index: 10556 !important
        }

        .auth-modal-content {
            border-radius: 24px !important;
            background: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25), 0 0 0 1px rgba(226, 232, 240, 0.8) !important;
            overflow: hidden;
            max-height: calc(100vh - 3.5rem);
            display: flex;
            flex-direction: column
        }

        .auth-modal .modal-body {
            overflow-y: auto !important;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent
        }

        .auth-modal .modal-body::-webkit-scrollbar {
            width: 6px
        }

        .auth-modal .modal-body::-webkit-scrollbar-track {
            background: transparent;
            border-radius: 10px
        }

        .auth-modal .modal-body::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px
        }

        .auth-modal-close {
            z-index: 10;
            opacity: 0.6
        }

        .auth-modal-title {
            letter-spacing: -0.02em
        }

        .auth-tabs-wrapper {
            max-width: 320px;
            margin-left: auto;
            margin-right: auto
        }

        .auth-nav-pills {
            background-color: #f1f5f9 !important;
            border-color: #e2e8f0 !important
        }

        .auth-tab-pill {
            color: #64748b !important
        }

        .auth-tab-pill.active {
            background-color: #0f172a !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15) !important
        }

        .auth-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #334155;
            display: block;
            margin-bottom: 0.35rem
        }

        .auth-modal-input {
            border-radius: 12px !important;
            border: 1.5px solid #e2e8f0 !important;
            padding: 0.7rem 1rem !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            color: #0f172a !important;
            background-color: #f8fafc !important
        }

        .btn-auth-modal-submit {
            background-color: #0f172a !important;
            border-color: #0f172a !important;
            border-radius: 12px !important;
            height: 48px
        }

        .auth-password-toggle {
            font-size: 15px
        }

        @media (max-width:1199px) {
            .center-feed {
                padding: 24px 20px;
                padding-bottom: 80px
            }
        }

        @media (max-width:991px) {
            .main-container {
                padding-left: 1rem;
                padding-right: 1rem
            }

            .center-feed {
                box-shadow: none;
                padding: 20px 16px;
                padding-bottom: 60px;
                border-radius: 0
            }

            .border-right1px {
                border-right: none !important;
                padding-bottom: 0
            }

            .sticky-sidebar {
                position: static !important;
                max-height: none !important;
                overflow-y: visible !important;
                margin-bottom: 20px
            }

            .site-footer .col-lg-3:first-child div,
            .site-footer .col-lg-3:first-child span {
                text-align: left !important
            }

            .col-6.col-lg-3.d-none.d-xl-block {
                display: none !important
            }
        }

        @media (max-width:767px) {
            .site-header {
                padding-top: 0.5rem !important;
                padding-bottom: 0.5rem !important
            }

            .main-container {
                padding-left: 0.75rem;
                padding-right: 0.75rem
            }

            .center-feed {
                padding: 16px 12px;
                padding-bottom: 48px
            }

            h1 {
                font-size: clamp(1.6rem, 5vw, 2.5rem) !important
            }

            h2 {
                font-size: clamp(1.3rem, 4.5vw, 2rem) !important
            }

            h3 {
                font-size: clamp(1.15rem, 4vw, 1.5rem) !important
            }

            h4 {
                font-size: clamp(1rem, 3.5vw, 1.25rem) !important
            }

            .offcanvas {
                width: min(85vw, 340px) !important
            }

            .content-section {
                padding-top: 0;
                margin-bottom: 2rem !important;
                padding-bottom: 1.5rem !important
            }

            .d-flex.align-items-center a img {
                max-width: 110px;
                height: auto
            }
        }

        @media (max-width:575px) {
            .main-container {
                padding-left: 0.5rem;
                padding-right: 0.5rem
            }

            .center-feed {
                padding: 12px 8px;
                padding-bottom: 48px
            }

            .menu-item .text-box small {
                display: none
            }

            .offcanvas .d-flex.gap-2 a {
                font-size: 13px;
                padding-top: 0.4rem;
                padding-bottom: 0.4rem
            }
        }

        .mobile-bottom-dock {
            position: fixed;
            bottom: calc(14px + env(safe-area-inset-bottom, 0px));
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 28px);
            max-width: 380px;
            z-index: 1040
        }

        .mobile-dock-inner {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.95);
            border-radius: 6px;
            padding: 6px 10px;
            display: flex;
            align-items: center;
            justify-content: space-around;
            box-shadow: 0 12px 32px -4px rgba(15, 23, 42, 0.16), 0 4px 12px rgba(0, 0, 0, 0.06)
        }

        .mobile-dock-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            text-decoration: none;
            color: #64748b;
            padding: 6px 12px;
            border-radius: 20px;
            min-width: 58px;
            position: relative
        }

        .mobile-dock-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            color: inherit
        }

        .mobile-dock-label {
            font-size: 11px;
            font-weight: 600;
            line-height: 1;
            letter-spacing: -0.2px;
            color: inherit
        }

        .mobile-dock-icon .header-count-badge {
            position: absolute;
            top: -6px;
            right: -10px;
            min-width: 17px;
            height: 17px;
            font-size: 10px;
            font-weight: 700;
            line-height: 1;
            border-radius: 50%;
            background-color: var(--color-primary, #0066cc);
            color: #fff;
            padding: 0 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 102, 204, 0.35)
        }

        .content-section {
            scroll-margin-top: 90px;
            padding-top: 6px;
            margin-bottom: 2.5rem
        }

        .about-page-header {
            margin-bottom: 1.75rem;
            padding-top: 2px
        }

        .badge-subheading {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.2px;
            color: var(--color-primary, #0095da);
            margin-bottom: 4px
        }

        .page-main-heading {
            font-size: var(--fs-h1, 24px);
            font-weight: 700;
            color: var(--color-dark, #0f172a);
            letter-spacing: -0.3px;
            line-height: 1.3;
            margin-bottom: 8px
        }

        .page-lead-text {
            font-size: 13.5px;
            color: var(--color-muted, #64748b);
            line-height: 1.6;
            max-width: 680px;
            margin-bottom: 0
        }

        .about-accordion-item {
            background: #ffffff;
            border: 1px solid var(--color-border, #e2e8f0);
            border-radius: 14px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03)
        }

        .about-accordion-header {
            display: flex;
            align-items: center;
            padding: 14px 18px;
            background: #ffffff;
            border-bottom: 1px solid transparent
        }

        .about-accordion-item.is-open .about-accordion-header {
            background: #f8fafc;
            border-bottom-color: #f1f5f9
        }

        .about-num-badge {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--color-primary-bg, #eff6ff);
            color: var(--color-primary, #0095da);
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 14px;
            flex-shrink: 0
        }

        .about-accordion-item.is-open .about-num-badge {
            background: var(--color-primary, #0095da);
            color: #ffffff
        }

        .about-accordion-title-wrap {
            flex-grow: 1
        }

        .about-accordion-title {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--color-dark, #0f172a);
            letter-spacing: -0.2px;
            margin-bottom: 2px
        }

        .about-accordion-subtitle {
            font-size: 11.5px;
            color: var(--color-muted, #64748b);
            margin-bottom: 0
        }

        .about-accordion-toggle-icon {
            font-size: 12px;
            color: var(--color-muted-mid, #94a3b8)
        }

        .about-accordion-item.is-open .about-accordion-toggle-icon {
            transform: rotate(180deg);
            color: var(--color-primary, #0095da)
        }

        .about-accordion-body-wrapper {
            display: grid;
            grid-template-rows: 0fr
        }

        .about-accordion-item.is-open .about-accordion-body-wrapper {
            grid-template-rows: 1fr
        }

        .about-accordion-body {
            overflow: hidden;
            padding: 0 18px
        }

        .about-accordion-item.is-open .about-accordion-body {
            padding: 18px
        }

        .about-hero-card {
            border-radius: 12px;
            overflow: hidden;
            background: #f8fafc;
            border: 1px solid var(--color-border, #e2e8f0);
            margin-bottom: 18px
        }

        .about-hero-banner-img {
            height: 100%;
            min-height: 190px;
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: flex-end;
            padding: 14px
        }

        .about-banner-badge-overlay {
            position: relative;
            z-index: 2;
            background: rgba(15, 23, 42, 0.82);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 6px 10px;
            border-radius: 6px;
            color: #ffffff;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.2px;
            line-height: 1.4;
            text-transform: uppercase
        }

        .about-hero-content {
            padding: 18px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center
        }

        .about-hero-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--color-dark, #0f172a);
            letter-spacing: -0.2px;
            line-height: 1.35;
            margin-bottom: 6px
        }

        .about-hero-desc {
            font-size: 12.5px;
            line-height: 1.6;
            color: var(--color-dark-mid, #334155);
            margin-bottom: 12px
        }

        .about-hero-link {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--color-primary, #0095da);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px
        }

        .about-timeline-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 6px;
            margin-bottom: 18px
        }

        .about-timeline-item {
            display: flex;
            align-items: flex-start;
            padding: 10px 14px;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid #f1f5f9
        }

        .about-timeline-year {
            font-size: 13px;
            font-weight: 700;
            color: var(--color-dark, #0f172a);
            width: 68px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 6px
        }

        .about-timeline-year::after {
            content: "";
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--color-primary, #0095da)
        }

        .about-timeline-content {
            flex-grow: 1
        }

        .about-timeline-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--color-dark, #0f172a);
            margin-bottom: 2px
        }

        .about-timeline-desc {
            font-size: 11.5px;
            color: var(--color-muted, #64748b);
            line-height: 1.5;
            margin-bottom: 0
        }

        @media (max-width:991px) {
            .page-main-heading {
                font-size: 21px
            }

            .about-hero-banner-img {
                min-height: 170px
            }
        }
    </style>
    <script type="application/ld+json">
{!! json_encode($aboutPageSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
    <script type="application/ld+json">
{!! json_encode($aboutBreadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
    <main class="container main-container">
        <h1 class="d-none">About AIRE Industries</h1>
        <div class="row g-0">

            <!-- Left Sidebar Navigation -->
            <aside class="col-lg-3 d-none d-lg-block border-right1px pe-lg-4">
                <nav class="sidebar-menu sticky-sidebar" data-lenis-prevent>
                    <a href="#story" class="menu-item active">
                        <div class="icon-box"><i class="bi bi-clock-history"></i></div>
                        <div class="text-box">
                            <h2 class="mb-0">{{ $storySec['title'] ?? 'Our Story' }}</h2>
                            <small
                                class="d-block mt-1">{{ $storySec['subtitle'] ?? 'Our journey to cleaner, healthier indoor air.' }}</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto chevron"></i>
                    </a>
                    <a href="#mission" class="menu-item">
                        <div class="icon-box"><i class="bi bi-bullseye"></i></div>
                        <div class="text-box">
                            <h2 class="mb-0">{{ $mvSec['title'] ?? 'Mission & Vision' }}</h2>
                            <small
                                class="d-block mt-1">{{ $mvSec['subtitle'] ?? 'Our purpose, values and commitment to a better future.' }}</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto chevron"></i>
                    </a>
                    <a href="#leadership" class="menu-item">
                        <div class="icon-box"><i class="bi bi-people"></i></div>
                        <div class="text-box">
                            <h2 class="mb-0">{{ $leadSec['title'] ?? 'Leadership' }}</h2>
                            <small
                                class="d-block mt-1">{{ $leadSec['subtitle'] ?? 'Meet the people driving innovation and impact.' }}</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto chevron"></i>
                    </a>
                    <a href="#innovation" class="menu-item">
                        <div class="icon-box"><i class="bi bi-shield-check"></i></div>
                        <div class="text-box">
                            <h2 class="mb-0">{{ $innovSec['title'] ?? 'Innovation & Patents' }}</h2>
                            <small
                                class="d-block mt-1">{{ $innovSec['subtitle'] ?? 'Pioneering technologies protected worldwide.' }}</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto chevron"></i>
                    </a>
                    <a href="#quality" class="menu-item">
                        <div class="icon-box"><i class="bi bi-patch-check"></i></div>
                        <div class="text-box">
                            <h2 class="mb-0">{{ $qualSec['title'] ?? 'Quality & Certifications' }}</h2>
                            <small
                                class="d-block mt-1">{{ $qualSec['subtitle'] ?? 'Globally certified for safety, quality and performance.' }}</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto chevron"></i>
                    </a>
                    <a href="#careers" class="menu-item">
                        <div class="icon-box"><i class="bi bi-briefcase"></i></div>
                        <div class="text-box">
                            <h2 class="mb-0">{{ $careerSec['title'] ?? 'Careers' }}</h2>
                            <small
                                class="d-block mt-1">{{ $careerSec['subtitle'] ?? 'Join our team and help shape a healthier world.' }}</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto chevron"></i>
                    </a>
                    <a href="#news" class="menu-item">
                        <div class="icon-box"><i class="bi bi-megaphone"></i></div>
                        <div class="text-box">
                            <h2 class="mb-0">{{ $newsSec['title'] ?? 'News & Media' }}</h2>
                            <small
                                class="d-block mt-1">{{ $newsSec['subtitle'] ?? 'Latest news, press releases and media coverage.' }}</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto chevron"></i>
                    </a>
                    <a href="#global" class="menu-item">
                        <div class="icon-box"><i class="bi bi-globe"></i></div>
                        <div class="text-box">
                            <h2 class="mb-0">{{ $globalSec['title'] ?? 'Global Presence' }}</h2>
                            <small
                                class="d-block mt-1">{{ $globalSec['subtitle'] ?? 'Serving customers in over 100 countries.' }}</small>
                        </div>
                        <i class="bi bi-chevron-right ms-auto chevron"></i>
                    </a>
                </nav>
            </aside>

            <!-- Center Content Column -->
            <div class="{{ $hasAds ? 'col-lg-9 col-xl-6' : 'col-lg-9 col-xl-9' }} center-feed px-lg-4 pb-5">

                <!-- Mobile Horizontal Category Scroll Bar (Visible on mobile/tablet screens) -->
                <div class="d-lg-none mobile-category-scroll-wrapper" data-lenis-prevent>
                    <div class="mobile-category-scroll-track" data-lenis-prevent>
                        <a href="#story" class="mobile-cat-pill active">
                            <span class="mobile-cat-pill__icon"><i class="bi bi-clock-history"></i></span>
                            <span>{{ $storySec['title'] ?? 'Our Story' }}</span>
                        </a>
                        <a href="#mission" class="mobile-cat-pill">
                            <span class="mobile-cat-pill__icon"><i class="bi bi-bullseye"></i></span>
                            <span>{{ $mvSec['title'] ?? 'Mission & Vision' }}</span>
                        </a>
                        <a href="#leadership" class="mobile-cat-pill">
                            <span class="mobile-cat-pill__icon"><i class="bi bi-people"></i></span>
                            <span>{{ $leadSec['title'] ?? 'Leadership' }}</span>
                        </a>
                        <a href="#innovation" class="mobile-cat-pill">
                            <span class="mobile-cat-pill__icon"><i class="bi bi-shield-check"></i></span>
                            <span>{{ $innovSec['title'] ?? 'Innovation' }}</span>
                        </a>
                        <a href="#quality" class="mobile-cat-pill">
                            <span class="mobile-cat-pill__icon"><i class="bi bi-patch-check"></i></span>
                            <span>{{ $qualSec['title'] ?? 'Quality' }}</span>
                        </a>
                        <a href="#careers" class="mobile-cat-pill">
                            <span class="mobile-cat-pill__icon"><i class="bi bi-briefcase"></i></span>
                            <span>{{ $careerSec['title'] ?? 'Careers' }}</span>
                        </a>
                        <a href="#news" class="mobile-cat-pill">
                            <span class="mobile-cat-pill__icon"><i class="bi bi-megaphone"></i></span>
                            <span>{{ $newsSec['title'] ?? 'News' }}</span>
                        </a>
                        <a href="#global" class="mobile-cat-pill">
                            <span class="mobile-cat-pill__icon"><i class="bi bi-globe"></i></span>
                            <span>{{ $globalSec['title'] ?? 'Global Presence' }}</span>
                        </a>
                    </div>
                </div>

                <!-- Page Header Title -->
                <div class="about-page-header">
                    <span class="badge-subheading text-uppercase">{{ $heroSec['badge'] ?? 'OUR STORY' }}</span>
                    <h1 class="page-main-heading">{{ $heroSec['title'] ?? 'A Cleaner Tomorrow Starts Here' }}</h1>
                    <p class="page-lead-text">
                        {{ $heroSec['subtitle'] ?? 'From a simple idea to a global mission, our journey has always been about one thing — cleaner air for healthier, happier lives.' }}
                    </p>
                </div>

                @renderPageSlot('about', 'before:story')
                <!-- ================= 1. OUR STORY ================= -->
                <div id="story" class="about-accordion-item content-section is-open">
                    <div class="about-accordion-header" onclick="toggleAboutAccordion('story')">
                        <div class="about-num-badge">{{ $storySec['number'] ?? 1 }}</div>
                        <div class="about-accordion-title-wrap">
                            <h3 class="about-accordion-title">{{ $storySec['title'] ?? 'Our Journey' }}</h3>
                            <p class="about-accordion-subtitle">
                                {{ $storySec['subtitle'] ?? 'Discover the key milestones that have shaped AIRE into a global leader in clean air solutions.' }}
                            </p>
                        </div>
                        <i class="bi bi-chevron-down about-accordion-toggle-icon"></i>
                    </div>
                    <div class="about-accordion-body-wrapper">
                        <div class="about-accordion-body">
                            <!-- Hero Split Card -->
                            <div class="about-hero-card">
                                <div class="row g-0">
                                    <div class="col-md-5">
                                        @php
                                            $storyHeroImg = !empty($storySec['hero_image'])
                                                ? getImageUrl($storySec['hero_image'])
                                                : theme_asset('img/about/mountains.jpg');
                                        @endphp
                                        <div class="about-hero-banner-img">
                                            <img src="{{ $storyHeroImg }}"
                                                alt="{{ $storySec['hero_title'] ?? 'Our Journey' }}"
                                                class="about-hero-img-element" fetchpriority="high" decoding="async"
                                                width="500" height="280">
                                            <div class="about-banner-badge-overlay">
                                                {!! nl2br(e($storySec['hero_badge'] ?? "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW")) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="about-hero-content">
                                            <h4 class="about-hero-title">{{ $storySec['hero_title'] ?? 'Our Journey' }}
                                            </h4>
                                            <p class="about-hero-desc">
                                                {{ $storySec['hero_desc'] ?? 'Since our founding, AIRE has been at the forefront of clean air innovation. What began as a vision to improve indoor air quality has grown into a global movement, trusted in homes, businesses and public spaces worldwide.' }}
                                            </p>
                                            <a href="{{ $storySec['button_link'] ?? '#milestones' }}"
                                                class="about-hero-link">
                                                {{ $storySec['button_text'] ?? 'Explore Our History' }} <i
                                                    class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline List -->
                            @php
                                $milestones = $storySec['milestones'] ?? [
                                    [
                                        'year' => '1988',
                                        'title' => 'The Beginning',
                                        'desc' =>
                                            'AIRE was founded with a vision to develop advanced air purification technologies for healthier indoor environments.',
                                    ],
                                    [
                                        'year' => '1995',
                                        'title' => 'Research & Development',
                                        'desc' =>
                                            'We established our first R&D centre, focusing on innovative air treatment technologies and energy-efficient solutions.',
                                    ],
                                    [
                                        'year' => '2005',
                                        'title' => 'Expanding Globally',
                                        'desc' =>
                                            'We expanded our product portfolio and entered international markets across Europe and Asia.',
                                    ],
                                    [
                                        'year' => '2015',
                                        'title' => 'A Broader Impact',
                                        'desc' =>
                                            'We introduced commercial and industrial solutions, addressing air quality challenges across multiple industries, from residential to large-scale commercial projects.',
                                    ],
                                    [
                                        'year' => '2020',
                                        'title' => 'Building Healthier Communities',
                                        'desc' =>
                                            'Our technologies are trusted in over 100 countries, improving the lives of millions through cleaner, safer air.',
                                    ],
                                    [
                                        'year' => 'Today',
                                        'title' => 'A Cleaner, Brighter Tomorrow',
                                        'desc' =>
                                            'We continue to innovate for a healthier planet, with a commitment to sustainability and a future where everyone can breathe better, everywhere.',
                                    ],
                                ];
                            @endphp
                            <div class="about-timeline-list" id="milestones">
                                @foreach ($milestones as $m)
                                    <div class="about-timeline-item">
                                        <span class="about-timeline-year">{{ $m['year'] ?? '' }}</span>
                                        <div class="about-timeline-content">
                                            <h5 class="about-timeline-title">{{ $m['title'] ?? '' }}</h5>
                                            <p class="about-timeline-desc">{{ $m['desc'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Impact Section inside Story -->
                            <div class="pt-3">
                                <div class="about-hero-card">
                                    <div class="row g-0">
                                        <div class="col-md-5">
                                            @php
                                                $impactImg = !empty($storySec['impact_image'])
                                                    ? getImageUrl($storySec['impact_image'])
                                                    : theme_asset('img/apartments.jpg');
                                            @endphp
                                            <div class="about-hero-banner-img">
                                                <img src="{{ $impactImg }}"
                                                    alt="{{ $storySec['impact_title'] ?? 'A Healthier World Through Cleaner Air' }}"
                                                    class="about-hero-img-element" loading="lazy" decoding="async"
                                                    width="500" height="280">
                                                <div class="about-banner-badge-overlay">
                                                    {!! nl2br(e($storySec['impact_badge'] ?? "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW")) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="about-hero-content">
                                                <h4 class="about-hero-title">
                                                    {{ $storySec['impact_title'] ?? 'A Healthier World Through Cleaner Air' }}
                                                </h4>
                                                <p class="about-hero-desc">
                                                    {{ $storySec['impact_desc'] ?? 'Our solutions are creating measurable change — improving health, enhancing productivity and building more sustainable communities across the globe.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $storyStats = $storySec['stats'] ?? [
                                        [
                                            'icon' => 'bi bi-globe',
                                            'title' => '100+ Countries',
                                            'desc' => 'Our solutions are trusted in over 100 countries worldwide.',
                                        ],
                                        [
                                            'icon' => 'bi bi-house-door',
                                            'title' => 'Millions Healthier Homes',
                                            'desc' => 'Cleaner, safer indoor air for families around the world.',
                                        ],
                                        [
                                            'icon' => 'bi bi-buildings',
                                            'title' => 'Thousands Businesses',
                                            'desc' =>
                                                'From offices to factories, we help organisations create healthier workplaces.',
                                        ],
                                        [
                                            'icon' => 'bi bi-tree',
                                            'title' => 'A Cleaner Tomorrow',
                                            'desc' => 'Reducing emissions and supporting a more sustainable planet.',
                                        ],
                                    ];
                                @endphp
                                <div class="about-feature-grid">
                                    @foreach ($storyStats as $st)
                                        <div class="about-mini-card">
                                            <div class="about-mini-card-icon"><i
                                                    class="{{ $st['icon'] ?? 'bi bi-globe' }}"></i></div>
                                            <h5 class="about-mini-card-title">{{ $st['title'] ?? '' }}</h5>
                                            <p class="about-mini-card-desc">{{ $st['desc'] ?? '' }}</p>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="about-quote-box">
                                    <p class="about-quote-text">
                                        &ldquo;{{ $storySec['quote'] ?? 'Real change happens when cleaner air becomes a right for everyone, not a privilege for a few.' }}&rdquo;
                                    </p>
                                    <div class="about-quote-brand">
                                        {!! nl2br(e($storySec['quote_brand'] ?? "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW")) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @renderPageSlot('about', 'after:story')

                <!-- ================= 2. MISSION & VISION ================= -->
                <div id="mission" class="about-accordion-item content-section is-open">
                    <div class="about-accordion-header" onclick="toggleAboutAccordion('mission')">
                        <div class="about-num-badge">{{ $mvSec['number'] ?? 2 }}</div>
                        <div class="about-accordion-title-wrap">
                            <h3 class="about-accordion-title">{{ $mvSec['title'] ?? 'Mission & Vision' }}</h3>
                            <p class="about-accordion-subtitle">
                                {{ $mvSec['subtitle'] ?? 'Our purpose, values and commitment to a better future.' }}</p>
                        </div>
                        <i class="bi bi-chevron-down about-accordion-toggle-icon"></i>
                    </div>
                    <div class="about-accordion-body-wrapper">
                        <div class="about-accordion-body">
                            <!-- Purpose Banner Card -->
                            <div class="about-hero-card">
                                <div class="row g-0">
                                    <div class="col-md-5">
                                        @php
                                            $purposeImg = !empty($mvSec['purpose_image'])
                                                ? getImageUrl($mvSec['purpose_image'])
                                                : theme_asset('img/about/earth_purpose.jpg');
                                        @endphp
                                        <div class="about-hero-banner-img">
                                            <img src="{{ $purposeImg }}"
                                                alt="{{ $mvSec['purpose_title'] ?? 'Our Purpose' }}"
                                                class="about-hero-img-element" loading="lazy" decoding="async"
                                                width="500" height="280">
                                            <div class="about-banner-badge-overlay">
                                                {!! nl2br(e($mvSec['purpose_badge'] ?? "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW")) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="about-hero-content">
                                            <h4 class="about-hero-title">{{ $mvSec['purpose_title'] ?? 'Our Purpose' }}
                                            </h4>
                                            <p class="about-hero-desc">
                                                {{ $mvSec['purpose_desc'] ?? 'We believe clean air is a fundamental right for everyone. Our mission and vision guide everything we do — from the technologies we develop to the communities we serve.' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2 Big Pillars -->
                            <div class="about-mission-grid">
                                <div class="about-mission-box">
                                    <div class="about-mission-icon-wrap"><i class="bi bi-bullseye"></i></div>
                                    <h4 class="about-mission-title">{{ $mvSec['mission_title'] ?? 'Our Mission' }}</h4>
                                    <p class="about-mission-desc">
                                        {{ $mvSec['mission_desc'] ?? 'To develop and deliver innovative, reliable and energy-efficient air solutions that create healthier indoor environments for people everywhere.' }}
                                    </p>
                                </div>
                                <div class="about-mission-box">
                                    <div class="about-mission-icon-wrap" style="background: #0ea5e9;"><i
                                            class="bi bi-eye"></i></div>
                                    <h4 class="about-mission-title">{{ $mvSec['vision_title'] ?? 'Our Vision' }}</h4>
                                    <p class="about-mission-desc">
                                        {{ $mvSec['vision_desc'] ?? 'A world where everyone, everywhere can breathe clean, safe and healthy air — today and for future generations.' }}
                                    </p>
                                </div>
                            </div>

                            <!-- 4 Core Values -->
                            @php
                                $values = $mvSec['values'] ?? [
                                    [
                                        'icon' => 'bi bi-heart',
                                        'title' => 'People First',
                                        'desc' => 'We put the health and wellbeing of people at the heart of our work.',
                                    ],
                                    [
                                        'icon' => 'bi bi-lightbulb',
                                        'title' => 'Innovation Always',
                                        'desc' => 'We continuously push the boundaries of clean air technology.',
                                    ],
                                    [
                                        'icon' => 'bi bi-globe-americas',
                                        'title' => 'A Healthier Planet',
                                        'desc' => 'We are committed to a more sustainable and resilient future.',
                                    ],
                                    [
                                        'icon' => 'bi bi-people-fill',
                                        'title' => 'Stronger Together',
                                        'desc' =>
                                            'We collaborate with partners and communities to create lasting impact.',
                                    ],
                                ];
                            @endphp
                            <div class="about-feature-grid">
                                @foreach ($values as $v)
                                    <div class="about-mini-card">
                                        <div class="about-mini-card-icon"><i
                                                class="{{ $v['icon'] ?? 'bi bi-heart' }}"></i></div>
                                        <h5 class="about-mini-card-title">{{ $v['title'] ?? '' }}</h5>
                                        <p class="about-mini-card-desc">{{ $v['desc'] ?? '' }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Quote Banner -->
                            <div class="about-quote-box">
                                <p class="about-quote-text">
                                    &ldquo;{{ $mvSec['quote'] ?? 'Clean air empowers people, strengthens communities and builds a brighter tomorrow.' }}&rdquo;
                                </p>
                                <div class="about-quote-brand">
                                    {!! nl2br(e($mvSec['quote_brand'] ?? "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW")) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @renderPageSlot('about', 'after:mission')

                <!-- ================= 3. LEADERSHIP ================= -->
                <div id="leadership" class="about-accordion-item content-section is-open">
                    <div class="about-accordion-header" onclick="toggleAboutAccordion('leadership')">
                        <div class="about-num-badge">{{ $leadSec['number'] ?? 3 }}</div>
                        <div class="about-accordion-title-wrap">
                            <h3 class="about-accordion-title">{{ $leadSec['title'] ?? 'Leadership' }}</h3>
                            <p class="about-accordion-subtitle">
                                {{ $leadSec['subtitle'] ?? 'Meet the people driving innovation and impact.' }}</p>
                        </div>
                        <i class="bi bi-chevron-down about-accordion-toggle-icon"></i>
                    </div>
                    <div class="about-accordion-body-wrapper">
                        <div class="about-accordion-body">
                            <!-- Purpose Banner Card -->
                            <div class="about-hero-card">
                                <div class="row g-0">
                                    <div class="col-md-5">
                                        @php
                                            $leadBannerImg = !empty($leadSec['banner_image'])
                                                ? getImageUrl($leadSec['banner_image'])
                                                : theme_asset('img/about/leadership.jpg');
                                        @endphp
                                        <div class="about-hero-banner-img">
                                            <img src="{{ $leadBannerImg }}"
                                                alt="{{ $leadSec['banner_title'] ?? 'People with Purpose' }}"
                                                class="about-hero-img-element" loading="lazy" decoding="async"
                                                width="500" height="280">
                                            <div class="about-banner-badge-overlay">
                                                {!! nl2br(e($leadSec['banner_badge_text'] ?? "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW")) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="about-hero-content">
                                            <span
                                                class="badge-subheading text-uppercase">{{ $leadSec['banner_badge'] ?? 'OUR LEADERSHIP' }}</span>
                                            <h4 class="about-hero-title">
                                                {{ $leadSec['banner_title'] ?? 'People with Purpose' }}</h4>
                                            <p class="about-hero-desc">
                                                {{ $leadSec['banner_desc'] ?? 'Our leadership team brings together decades of experience, a passion for cleaner air and a shared commitment to creating healthier spaces for everyone, everywhere.' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <h4 class="about-hero-title mb-1">
                                        {{ $leadSec['team_heading'] ?? 'Meet Our Leadership Team' }}</h4>
                                    <p class="about-accordion-subtitle">
                                        {{ $leadSec['team_subheading'] ?? 'A diverse group of visionaries, innovators and changemakers working together to build a cleaner, healthier future.' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Leadership Team Grid -->
                            @php
                                $members = $leadSec['members'] ?? [
                                    [
                                        'name' => 'Dr. James Liu',
                                        'role' => 'Chief Executive Officer',
                                        'bio' => "Leading AIRE's global vision for cleaner air and healthier lives.",
                                        'image' => '',
                                    ],
                                    [
                                        'name' => 'Sarah Mitchell',
                                        'role' => 'Chief Technology Officer',
                                        'bio' => 'Driving innovation in air purification and sustainable technologies.',
                                        'image' => '',
                                    ],
                                    [
                                        'name' => 'Kenji Tanaka',
                                        'role' => 'Chief Operations Officer',
                                        'bio' =>
                                            'Scaling solutions globally with operational excellence and partnerships.',
                                        'image' => '',
                                    ],
                                    [
                                        'name' => 'Elena Rodriguez',
                                        'role' => 'Chief Sustainability Officer',
                                        'bio' =>
                                            'Championing a healthier planet through people, partnerships and purpose.',
                                        'image' => '',
                                    ],
                                ];
                            @endphp
                            <div class="about-team-grid">
                                @foreach ($members as $mem)
                                    <div class="about-team-card">
                                        <div class="about-team-avatar-wrap">
                                            @if (!empty($mem['image']))
                                                <img src="{{ getImageUrl($mem['image']) }}"
                                                    alt="{{ $mem['name'] ?? '' }}" class="about-team-avatar-img"
                                                    loading="lazy" />
                                            @else
                                                <div class="about-team-avatar-placeholder"><i class="bi bi-person"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="about-team-info">
                                            <h5 class="about-team-name">{{ $mem['name'] ?? '' }}</h5>
                                            <div class="about-team-role">{{ $mem['role'] ?? '' }}</div>
                                            <p class="about-team-bio">{{ $mem['bio'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Quote Banner -->
                            <div class="about-quote-box quote-blue">
                                <p class="about-quote-text">
                                    &ldquo;{{ $leadSec['quote'] ?? 'Great things happen when passionate people work together for a cleaner, healthier world.' }}&rdquo;
                                </p>
                                <div class="about-quote-brand">
                                    {!! nl2br(e($leadSec['quote_brand'] ?? "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW")) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @renderPageSlot('about', 'after:leadership')

                <!-- ================= 4. INNOVATION & PATENTS ================= -->
                <div id="innovation" class="about-accordion-item content-section is-open">
                    <div class="about-accordion-header" onclick="toggleAboutAccordion('innovation')">
                        <div class="about-num-badge">{{ $innovSec['number'] ?? 4 }}</div>
                        <div class="about-accordion-title-wrap">
                            <h3 class="about-accordion-title">{{ $innovSec['title'] ?? 'Innovation & Patents' }}</h3>
                            <p class="about-accordion-subtitle">
                                {{ $innovSec['subtitle'] ?? 'Pioneering technologies protected worldwide.' }}</p>
                        </div>
                        <i class="bi bi-chevron-down about-accordion-toggle-icon"></i>
                    </div>
                    <div class="about-accordion-body-wrapper">
                        <div class="about-accordion-body">
                            @php
                                $innovItems = $innovSec['items'] ?? [
                                    [
                                        'icon' => 'bi bi-patch-check',
                                        'title' => '200+ Global Patents',
                                        'desc' =>
                                            'Proprietary innovations in ionization, filtration, and acoustic airflow design.',
                                    ],
                                    [
                                        'icon' => 'bi bi-sliders',
                                        'title' => 'Smart Air Calibration',
                                        'desc' =>
                                            'AI-powered sensors that dynamically adjust filtration based on environmental metrics.',
                                    ],
                                ];
                            @endphp
                            <div class="about-feature-grid">
                                @foreach ($innovItems as $item)
                                    <div class="about-mini-card">
                                        <div class="about-mini-card-icon"><i
                                                class="{{ $item['icon'] ?? 'bi bi-patch-check' }}"></i></div>
                                        <h5 class="about-mini-card-title">{{ $item['title'] ?? '' }}</h5>
                                        <p class="about-mini-card-desc">{{ $item['desc'] ?? '' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @renderPageSlot('about', 'after:innovation')

                <!-- ================= 5. QUALITY & CERTIFICATIONS ================= -->
                <div id="quality" class="about-accordion-item content-section is-open">
                    <div class="about-accordion-header" onclick="toggleAboutAccordion('quality')">
                        <div class="about-num-badge">{{ $qualSec['number'] ?? 5 }}</div>
                        <div class="about-accordion-title-wrap">
                            <h3 class="about-accordion-title">{{ $qualSec['title'] ?? 'Quality & Certifications' }}</h3>
                            <p class="about-accordion-subtitle">
                                {{ $qualSec['subtitle'] ?? 'Globally certified for safety, quality and performance.' }}</p>
                        </div>
                        <i class="bi bi-chevron-down about-accordion-toggle-icon"></i>
                    </div>
                    <div class="about-accordion-body-wrapper">
                        <div class="about-accordion-body">
                            @php
                                $qualItems = $qualSec['items'] ?? [
                                    [
                                        'icon' => 'bi bi-award',
                                        'title' => 'ISO 9001 & 14001',
                                        'desc' =>
                                            'Rigorous international standards for manufacturing and environmental stewardship.',
                                    ],
                                    [
                                        'icon' => 'bi bi-shield-lock',
                                        'title' => 'AHAM CADR Certified',
                                        'desc' => 'Independently lab tested and verified Clean Air Delivery Rates.',
                                    ],
                                ];
                            @endphp
                            <div class="about-feature-grid">
                                @foreach ($qualItems as $item)
                                    <div class="about-mini-card">
                                        <div class="about-mini-card-icon"><i
                                                class="{{ $item['icon'] ?? 'bi bi-award' }}"></i></div>
                                        <h5 class="about-mini-card-title">{{ $item['title'] ?? '' }}</h5>
                                        <p class="about-mini-card-desc">{{ $item['desc'] ?? '' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @renderPageSlot('about', 'after:quality')

                <!-- ================= 6. CAREERS ================= -->
                <div id="careers" class="about-accordion-item content-section is-open">
                    <div class="about-accordion-header" onclick="toggleAboutAccordion('careers')">
                        <div class="about-num-badge">{{ $careerSec['number'] ?? 6 }}</div>
                        <div class="about-accordion-title-wrap">
                            <h3 class="about-accordion-title">{{ $careerSec['title'] ?? 'Careers' }}</h3>
                            <p class="about-accordion-subtitle">
                                {{ $careerSec['subtitle'] ?? 'Join our team and help shape a healthier world.' }}</p>
                        </div>
                        <i class="bi bi-chevron-down about-accordion-toggle-icon"></i>
                    </div>
                    <div class="about-accordion-body-wrapper">
                        <div class="about-accordion-body">
                            <div class="about-mini-card mb-3">
                                <h5 class="about-mini-card-title mb-2">
                                    {{ $careerSec['card_title'] ?? 'Build the Future of Clean Air' }}</h5>
                                <p class="about-mini-card-desc mb-3">
                                    {{ $careerSec['card_desc'] ?? 'We are always looking for passionate engineers, designers, scientists, and problem-solvers to join our global family.' }}
                                </p>
                                <a href="{{ $careerSec['button_link'] ?? route('contact') }}" class="about-hero-link">
                                    {{ $careerSec['button_text'] ?? 'View Open Positions' }} <i
                                        class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @renderPageSlot('about', 'after:careers')

                <!-- ================= 7. NEWS & MEDIA ================= -->
                <div id="news" class="about-accordion-item content-section is-open">
                    <div class="about-accordion-header" onclick="toggleAboutAccordion('news')">
                        <div class="about-num-badge">{{ $newsSec['number'] ?? 7 }}</div>
                        <div class="about-accordion-title-wrap">
                            <h3 class="about-accordion-title">{{ $newsSec['title'] ?? 'News & Media' }}</h3>
                            <p class="about-accordion-subtitle">
                                {{ $newsSec['subtitle'] ?? 'Latest news, press releases and media coverage.' }}</p>
                        </div>
                        <i class="bi bi-chevron-down about-accordion-toggle-icon"></i>
                    </div>
                    <div class="about-accordion-body-wrapper">
                        <div class="about-accordion-body">
                            <!-- Press & Resources Highlight Bar -->
                            <div
                                class="about-mini-card mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                                <div>
                                    <h5 class="about-mini-card-title mb-1">
                                        {{ $newsSec['banner_title'] ?? 'Official Press & Media Center' }}</h5>
                                    <p class="about-mini-card-desc mb-0">
                                        {{ $newsSec['banner_desc'] ?? 'Stay informed with our latest announcements, product innovations, and global milestones.' }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ $newsSec['button_link'] ?? route('contact') }}" class="about-hero-link">
                                        {{ $newsSec['button_text'] ?? 'Media Inquiries' }} <i
                                            class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                            @php
                                $newsList =
                                    isset($latestNews) && $latestNews->isNotEmpty()
                                        ? $latestNews
                                        : \App\Models\News::query()
                                            ->published()
                                            ->with(['categories'])
                                            ->latest('publish_date')
                                            ->take(6)
                                            ->get();
                            @endphp

                            @if ($newsList && $newsList->count() > 0)
                                <div class="about-news-grid">
                                    @foreach ($newsList as $item)
                                        @php
                                            $catName = $item->categories->first()->category_name ?? 'Press Release';
                                            $newsImg = !empty($item->f_image)
                                                ? getImageUrl($item->f_image, 400, 250)
                                                : (!empty($item->image)
                                                    ? getImageUrl($item->image, 400, 250)
                                                    : null);
                                            $pubDate = !empty($item->publish_date)
                                                ? \Carbon\Carbon::parse($item->publish_date)->format('M d, Y')
                                                : $item->created_at->format('M d, Y');
                                            $newsLink = \Illuminate\Support\Facades\Route::has(
                                                'news-and-updates-details',
                                            )
                                                ? route('news-and-updates-details', $item->slug)
                                                : (\Illuminate\Support\Facades\Route::has('news.show')
                                                    ? route('news.show', $item->slug)
                                                    : '#');
                                        @endphp
                                        <article class="about-news-card">
                                            <a href="{{ $newsLink }}" class="about-news-img-wrap">
                                                @if ($newsImg)
                                                    <img src="{{ $newsImg }}" alt="{{ $item->news_title }}"
                                                        class="about-news-img" loading="lazy">
                                                @else
                                                    <div class="about-news-img-placeholder">
                                                        <i class="bi bi-newspaper"></i>
                                                    </div>
                                                @endif
                                                <span class="about-news-badge">{{ $catName }}</span>
                                            </a>
                                            <div class="about-news-body">
                                                <div class="about-news-meta">
                                                    <i class="bi bi-calendar3"></i>
                                                    <span>{{ $pubDate }}</span>
                                                </div>
                                                <h4 class="about-news-title">
                                                    <a href="{{ $newsLink }}">{{ $item->news_title }}</a>
                                                </h4>
                                                <p class="about-news-desc">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->short_des ?: $item->description), 110) }}
                                                </p>
                                                <div class="about-news-footer">
                                                    <a href="{{ $newsLink }}" class="about-hero-link">
                                                        Read Details <i class="bi bi-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            @else
                                <div class="about-news-grid">
                                    <article class="about-news-card">
                                        <a href="{{ route('products.index') }}" class="about-news-img-wrap">
                                            <div class="about-news-img-placeholder">
                                                <i class="bi bi-cpu"></i>
                                            </div>
                                            <span class="about-news-badge">Innovation</span>
                                        </a>
                                        <div class="about-news-body">
                                            <div class="about-news-meta">
                                                <i class="bi bi-calendar3"></i>
                                                <span>Oct 2026</span>
                                            </div>
                                            <h4 class="about-news-title">
                                                <a href="{{ route('products.index') }}">AIRE Introduces Next-Gen
                                                    Ultra-Inverter
                                                    Climate Systems</a>
                                            </h4>
                                            <p class="about-news-desc">
                                                Revolutionary multi-zone HVAC technology achieving up to 28 SEER2 efficiency
                                                with AI-driven thermal sensors.
                                            </p>
                                            <div class="about-news-footer">
                                                <a href="{{ route('products.index') }}" class="about-hero-link">
                                                    Explore Solutions <i class="bi bi-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </article>

                                    <article class="about-news-card">
                                        <a href="{{ route('about') }}#global" class="about-news-img-wrap">
                                            <div class="about-news-img-placeholder">
                                                <i class="bi bi-globe-americas"></i>
                                            </div>
                                            <span class="about-news-badge">Expansion</span>
                                        </a>
                                        <div class="about-news-body">
                                            <div class="about-news-meta">
                                                <i class="bi bi-calendar3"></i>
                                                <span>Sep 2026</span>
                                            </div>
                                            <h4 class="about-news-title">
                                                <a href="{{ route('about') }}#global">AIRE Global Logistics Hub Network
                                                    Expands Worldwide</a>
                                            </h4>
                                            <p class="about-news-desc">
                                                Enhancing rapid regional fulfillment, technical parts support, and customer
                                                care across more than 100 countries.
                                            </p>
                                            <div class="about-news-footer">
                                                <a href="{{ route('about') }}#global" class="about-hero-link">
                                                    Global Presence <i class="bi bi-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </article>

                                    <article class="about-news-card">
                                        <a href="{{ route('resources') }}" class="about-news-img-wrap">
                                            <div class="about-news-img-placeholder">
                                                <i class="bi bi-shield-check"></i>
                                            </div>
                                            <span class="about-news-badge">Sustainability</span>
                                        </a>
                                        <div class="about-news-body">
                                            <div class="about-news-meta">
                                                <i class="bi bi-calendar3"></i>
                                                <span>Aug 2026</span>
                                            </div>
                                            <h4 class="about-news-title">
                                                <a href="{{ route('resources') }}">2026 Clean Air Standards &amp;
                                                    Eco-Efficiency Benchmark</a>
                                            </h4>
                                            <p class="about-news-desc">
                                                Our newest commercial and residential product lines receive premier
                                                international green energy certifications.
                                            </p>
                                            <div class="about-news-footer">
                                                <a href="{{ route('resources') }}" class="about-hero-link">
                                                    Read Technical Docs <i class="bi bi-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @renderPageSlot('about', 'after:news')

                <!-- ================= 8. GLOBAL PRESENCE ================= -->
                <div id="global" class="about-accordion-item content-section is-open">
                    <div class="about-accordion-header" onclick="toggleAboutAccordion('global')">
                        <div class="about-num-badge">{{ $globalSec['number'] ?? 8 }}</div>
                        <div class="about-accordion-title-wrap">
                            <h3 class="about-accordion-title">{{ $globalSec['title'] ?? 'Global Presence' }}</h3>
                            <p class="about-accordion-subtitle">
                                {{ $globalSec['subtitle'] ?? 'Serving customers in over 100 countries.' }}</p>
                        </div>
                        <i class="bi bi-chevron-down about-accordion-toggle-icon"></i>
                    </div>
                    <div class="about-accordion-body-wrapper">
                        <div class="about-accordion-body">
                            @php
                                $globalItems = $globalSec['items'] ?? [
                                    [
                                        'icon' => 'bi bi-geo-alt',
                                        'title' => 'Global Offices',
                                        'desc' =>
                                            'Regional hubs in North America, Europe, Asia Pacific, and the Middle East.',
                                    ],
                                    [
                                        'icon' => 'bi bi-truck',
                                        'title' => 'Worldwide Distribution',
                                        'desc' =>
                                            'Direct fulfillment and certified maintenance partners across 100+ nations.',
                                    ],
                                ];
                            @endphp
                            <div class="about-feature-grid">
                                @foreach ($globalItems as $item)
                                    <div class="about-mini-card">
                                        <div class="about-mini-card-icon"><i
                                                class="{{ $item['icon'] ?? 'bi bi-geo-alt' }}"></i></div>
                                        <h5 class="about-mini-card-title">{{ $item['title'] ?? '' }}</h5>
                                        <p class="about-mini-card-desc">{{ $item['desc'] ?? '' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @renderPageSlot('about', 'after:global')

            </div>

            @if ($hasAds)
                <!-- Right Sidebar Feature -->
                <aside class="col-lg-12 col-xl-3 border-left1px d-none d-xl-block">
                    <div class="featured-card sticky-sidebar bg-white border border-light-subtle shadow-sm rounded-4 ms-3"
                        data-lenis-prevent>
                        <div class="swiper featured-swiper">
                            <div class="swiper-wrapper">
                                @forelse ($sidebarAds as $index => $ad)
                                    <div class="swiper-slide">
                                        <div class="featured-img position-relative">
                                            <span
                                                class="badge bg-dark position-absolute top-0 start-0 m-3 rounded-0 px-3 py-2 text-uppercase text-white border-0 featured-badge">
                                                {{ $ad->subtitle ?: ($ad->badge ?: ($index === 0 ? 'Featured Solution' : ($index === 1 ? 'New Arrival' : 'Commercial'))) }}
                                            </span>
                                            <img src="{{ !empty($ad->image) ? getImageUrl($ad->image) : theme_asset('img/featured/' . (($index % 3) + 1) . '.png') }}"
                                                class="img-fluid w-100" alt="{{ $ad->title ?? 'Featured Ad' }}"
                                                loading="lazy" decoding="async" width="341" height="512">
                                        </div>
                                        <div class="featured-content pb-5">
                                            <h3 class="mb-2">{{ $ad->title }}</h3>
                                            <p class="text-muted mb-2 lh-base">{{ $ad->description }}</p>
                                            <a href="{{ $ad->link ?: route('products.index') }}"
                                                class="btn btn-primary w-100 fw-bold shadow-sm featured-btn text-decoration-none d-inline-block text-center"
                                                aria-label="{{ ($ad->button_text ?? ($index === 0 ? 'VIEW PRODUCTS' : ($index === 1 ? 'LEARN MORE' : 'FIND MORE PRODUCTS'))) . (!empty($ad->title) ? ' - ' . $ad->title : '') }}">
                                                {{ $ad->button_text ?? ($index === 0 ? 'VIEW PRODUCTS' : ($index === 1 ? 'LEARN MORE' : 'FIND MORE PRODUCTS')) }}
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination position-absolute bottom-2"></div>
                        </div>
                    </div>
                </aside>
            @endif

        </div>
    </main>
@endsection

@push('scripts')
    <script src="{{ theme_asset('js/about.js') }}" defer></script>
    <script>
        function toggleAboutAccordion(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.toggle('is-open');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof Swiper !== 'undefined' && document.querySelector('.featured-swiper')) {
                new Swiper('.featured-swiper', {
                    loop: true,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.featured-swiper .swiper-pagination',
                        clickable: true,
                    },
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    }
                });
            }
        });
    </script>
@endpush
