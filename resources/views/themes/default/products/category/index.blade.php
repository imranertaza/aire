@extends('themes.default.layouts.master')

@php
    $catModel = $categories instanceof \Illuminate\Database\Eloquent\Model ? $categories : null;
    $seoTitle = $catModel
        ? (!empty($catModel->meta_title)
            ? $catModel->meta_title
            : $catModel->category_name . ' | Aire')
        : 'Aire | Products';
    $seoDesc = $catModel
        ? (!empty($catModel->meta_description)
            ? $catModel->meta_description
            : $catModel->description ?? '')
        : '';
    $seoKeyword = $catModel ? $catModel->meta_keyword ?? '' : '';
    $seoImage = $catModel && !empty($catModel->image) ? getImagePath($catModel->image) : null;
@endphp

@section('title', $seoTitle)
@if (!empty($seoDesc))
    @section('meta_description', $seoDesc)
@endif
@if (!empty($seoKeyword))
    @section('meta_keywords', $seoKeyword)
@endif
@if (!empty($seoImage))
    @section('og_image', $seoImage)
@endif

@php
    $displayCategories =
        $categories instanceof \Illuminate\Database\Eloquent\Model
            ? ($categories->children && $categories->children->isNotEmpty()
                ? $categories->children
                : collect([$categories]))
            : $categories ?? ($allCategories ?? collect());

    $firstCat = $displayCategories->first();
    $firstProduct = null;
    if ($firstCat) {
        $catProds = $firstCat->products;
        if ($catProds->isEmpty() && $firstCat->children && $firstCat->children->isNotEmpty()) {
            $catProds = $firstCat->children->pluck('products')->flatten();
        }
        $firstProduct = $catProds->first();
    }
    $firstHeroBg = null;
    if ($firstProduct) {
        $firstShowcase = $firstProduct->showcase ?? null;
        $rawHeroBg = !empty($firstShowcase->hero_bg_image)
            ? $firstShowcase->hero_bg_image
            : (file_exists(public_path('assets/images/cart-bg.png'))
                ? asset('assets/images/cart-bg.png')
                : 'themes/default/assets/img/cart-bg.png');
        $firstHeroBg = getImageUrl($rawHeroBg);
    } else {
        $firstHeroBg = getImageUrl('themes/default/assets/img/cart-bg.png');
    }
@endphp

@push('head')
    <link rel="preload" as="style"
        href="{{ theme_asset('css/product.min.css') }}?v={{ file_exists(public_path('themes/default/assets/css/product.min.css')) ? filemtime(public_path('themes/default/assets/css/product.min.css')) : time() }}">
    @if (!empty($firstHeroBg))
        <link rel="preload" as="image" href="{{ $firstHeroBg }}" fetchpriority="high">
    @endif
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

        .g-3 {
            --bs-gutter-x: 1rem
        }

        .g-3 {
            --bs-gutter-y: 1rem
        }

        .g-4 {
            --bs-gutter-x: 1.5rem
        }

        .g-4 {
            --bs-gutter-y: 1.5rem
        }

        @media (min-width:768px) {
            .col-md-6 {
                flex: 0 0 auto;
                width: 50%
            }
        }

        @media (min-width:992px) {
            .col-lg-3 {
                flex: 0 0 auto;
                width: 25%
            }

            .col-lg-5 {
                flex: 0 0 auto;
                width: 41.66666667%
            }

            .col-lg-7 {
                flex: 0 0 auto;
                width: 58.33333333%
            }

            .col-lg-9 {
                flex: 0 0 auto;
                width: 75%
            }

            .g-lg-4 {
                --bs-gutter-x: 1.5rem
            }

            .g-lg-4 {
                --bs-gutter-y: 1.5rem
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

        .align-items-end {
            align-items: flex-end !important
        }

        .align-items-center {
            align-items: center !important
        }

        .m-3 {
            margin: 1rem !important
        }

        .mt-0 {
            margin-top: 0 !important
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

        .mb-5 {
            margin-bottom: 3rem !important
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

        .p-0 {
            padding: 0 !important
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

        .pe-4 {
            padding-right: 1.5rem !important
        }

        .pb-2 {
            padding-bottom: .5rem !important
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

        .text-reset {
            --bs-text-opacity: 1;
            color: inherit !important
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

            .pe-lg-0 {
                padding-right: 0 !important
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

        .bi-arrow-repeat::before {
            content: "\f130"
        }

        .bi-arrow-right::before {
            content: "\f138"
        }

        .bi-arrows-fullscreen::before {
            content: "\f14d"
        }

        .bi-box-arrow-in-right::before {
            content: "\f1be"
        }

        .bi-brightness-high::before {
            content: "\f1d2"
        }

        .bi-chevron-right::before {
            content: "\f285"
        }

        .bi-clipboard-check::before {
            content: "\f28b"
        }

        .bi-cpu::before {
            content: "\f2d6"
        }

        .bi-diagram-3::before {
            content: "\f2ee"
        }

        .bi-droplet-half::before {
            content: "\f30c"
        }

        .bi-eye-slash::before {
            content: "\f340"
        }

        .bi-file-earmark-medical::before {
            content: "\f373"
        }

        .bi-file-earmark-text::before {
            content: "\f38b"
        }

        .bi-grid-3x3::before {
            content: "\f3fa"
        }

        .bi-house-door::before {
            content: "\f423"
        }

        .bi-layout-sidebar::before {
            content: "\f45f"
        }

        .bi-lightbulb::before {
            content: "\f46b"
        }

        .bi-lightning-charge::before {
            content: "\f46d"
        }

        .bi-list::before {
            content: "\f479"
        }

        .bi-palette::before {
            content: "\f4b1"
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

        .bi-square::before {
            content: "\f584"
        }

        .bi-telephone::before {
            content: "\f5c1"
        }

        .bi-x-circle-fill::before {
            content: "\f622"
        }

        .bi-check-lg::before {
            content: "\f633"
        }

        .bi-x-lg::before {
            content: "\f659"
        }

        .bi-send::before {
            content: "\f6c0"
        }

        .bi-virus::before {
            content: "\f827"
        }

        .bi-building-exclamation::before {
            content: "\f86b"
        }

        .bi-buildings::before {
            content: "\f87d"
        }

        .bi-crosshair::before {
            content: "\f769"
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

            .offcanvas {
                width: min(85vw, 340px) !important
            }

            .row.g-4 {
                --bs-gutter-x: 1rem;
                --bs-gutter-y: 1rem
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

            .row.g-4>.col-md-6 {
                width: 100% !important
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

        .ductless-showcase-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 14px;
            border: 1px solid #eef2f6;
            box-shadow: 0 16px 36px -12px rgba(15, 23, 42, 0.08), 0 1px 3px rgba(15, 23, 42, 0.03);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            font-family: inherit;
            overflow: hidden;
            display: flex;
            flex-direction: row;
            align-items: stretch;
            gap: 16px;
            box-sizing: border-box
        }

        .ductless-showcase-card:hover {
            box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.12), 0 4px 12px rgba(15, 23, 42, 0.05)
        }

        .ductless-showcase-card__hero {
            position: relative;
            flex: 1 1 50%;
            max-width: 50%;
            min-width: 0;
            background-color: #f1f4f8;
            background-size: cover;
            background-position: center right;
            background-repeat: no-repeat;
            border-radius: 22px;
            padding: 16px 18px 20px 18px;
            min-height: 430px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            margin: 0;
            box-sizing: border-box
        }

        .ductless-hero-link {
            position: absolute;
            inset: 0;
            z-index: 1;
            display: block;
            text-decoration: none !important
        }

        .ductless-showcase-card__badges {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 15px;
            z-index: 2;
            max-width: calc(100% - 48px)
        }

        .ductless-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            line-height: 1;
            text-decoration: none
        }

        .ductless-badge i {
            font-size: 13px;
            line-height: 1
        }

        .ductless-badge--residential {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            color: #c2410c
        }

        .ductless-badge--fresh-air {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #15803d
        }

        .ductless-showcase-card__actions {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 10
        }

        .ductless-action-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            text-decoration: none !important
        }

        .ductless-action-btn svg path {
            fill: var(--color-primary, #0095da)
        }

        .ductless-action-btn.btn-toggle-favorite svg path {
            fill: #dc3545
        }

        .ductless-showcase-card__header {
            margin-bottom: 12px;
            z-index: 2
        }

        .ductless-showcase-card__title {
            font-size: 24px;
            font-weight: 800;
            line-height: 30px;
            letter-spacing: -0.035em;
            color: #090d16;
            margin: 0
        }

        .ductless-showcase-card__subtitle {
            font-size: 12px;
            font-weight: 400;
            line-height: 16px;
            color: #64748B;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
            max-width: 100%
        }

        .ductless-showcase-card__pills {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 4px;
            z-index: 2;
            width: max-content;
            max-width: 100%
        }

        .ductless-pill {
            display: inline-flex;
            width: 100%;
            align-items: center;
            gap: 9px;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 8px;
            padding: 6px 10px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.85);
            font-size: 11px;
            font-weight: 700;
            color: #1e293b;
            white-space: nowrap;
            box-sizing: border-box
        }

        .ductless-pill__icon {
            color: #475569;
            flex-shrink: 0
        }

        .ductless-pill__dual-text {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
            text-align: left
        }

        .ductless-pill__dual-main {
            font-size: 11px;
            font-weight: 700;
            color: #1e293b
        }

        .ductless-pill__dual-sub {
            font-size: 10px;
            font-weight: 500;
            color: #64748b
        }

        .ductless-quickview-btn {
            position: absolute;
            bottom: 13px;
            right: 20px;
            background: #202938;
            color: #ffffff !important;
            border-radius: 9999px;
            padding: 5px 14px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none !important;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.25);
            z-index: 10
        }

        .ductless-showcase-card__body {
            background: #ffffff;
            flex: 1 1 50%;
            max-width: 50%;
            min-width: 0;
            padding: 2px 4px 4px 4px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box
        }

        .ductless-diagram-box {
            background: #f4f9fd;
            border: 1.5px solid #dbeafe;
            border-radius: 18px;
            padding: 16px 18px 14px 18px;
            margin-top: 0;
            margin-bottom: 6px;
            display: flex;
            flex-direction: column
        }

        .ductless-diagram-box__meta {
            width: 100%
        }

        .ductless-diagram-box__brand {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.06em;
            color: #647489;
            text-transform: uppercase;
            display: block
        }

        .ductless-diagram-box__model {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            margin: 3px 0 2px 0;
            line-height: 1.25;
            word-break: break-word
        }

        .ductless-diagram-box__system {
            font-size: 12px;
            font-weight: 500;
            color: #64748b;
            margin: 0;
            line-height: 1.3
        }

        .ductless-diagram-box__illustration {
            margin-top: 10px;
            display: block;
            width: 100%
        }

        .ductless-diagram-box__illustration a,
        .ductless-diagram-link {
            display: block;
            width: 100%;
            text-decoration: none !important
        }

        .ductless-diagram-img {
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
            display: block;
            border-radius: 12px
        }

        .ductless-specs-bar {
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 10px 4px;
            margin: 4px 0 8px 0;
            text-align: center;
            border: none
        }

        .ductless-spec-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            flex: 1
        }

        .ductless-spec-item__value {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13.5px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1
        }

        .ductless-spec-item__value svg {
            color: #334155;
            height: 13px !important;
            width: 13px !important
        }

        .ductless-spec-item__label {
            font-size: 11px;
            color: #64748b;
            font-weight: 500
        }

        .ductless-specs-bar__divider {
            display: none
        }

        .ductless-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding-top: 2px
        }

        .ductless-buy-btn {
            background: var(--color-primary, #0095da);
            background: linear-gradient(135deg, var(--color-primary, #0095da) 0%, var(--color-primary-hover, #0876a8) 100%);
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 700;
            border-radius: 9999px;
            padding: 10px 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none !important;
            box-shadow: 0 6px 18px var(--color-primary-shadow, rgba(0, 149, 218, 0.35));
            border: none;
            max-width: 230px !important;
            width: 100% !important
        }

        .ductless-price-wrap {
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end
        }

        .ductless-price {
            font-size: 16px;
            font-weight: 800;
            color: #0F172A;
            letter-spacing: -0.02em;
            line-height: 1
        }

        .ductless-learn-more {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: 11px;
            font-weight: 700;
            color: var(--color-primary, #0095da) !important;
            text-decoration: none !important;
            margin-top: 4px
        }

        @media (max-width:991.98px) {
            .ductless-showcase-card {
                flex-direction: column !important;
                border-radius: 24px;
                padding: 0 !important;
                gap: 0 !important
            }

            .ductless-showcase-card__hero {
                flex: none !important;
                max-width: 100% !important;
                width: 100% !important;
                min-height: 350px;
                padding: 14px 16px;
                border-radius: 24px;
                background-position: right 8% center;
                margin: 0 !important
            }

            .ductless-showcase-card__body {
                flex: none !important;
                max-width: 100% !important;
                width: 100% !important;
                padding: 14px 16px 20px 16px;
                display: block !important
            }

            .ductless-showcase-card__badges {
                max-width: calc(100% - 46px);
                margin-bottom: 12px;
                gap: 6px
            }

            .ductless-badge {
                padding: 5px 12px;
                font-size: 10.5px
            }

            .ductless-showcase-card__actions {
                top: 14px;
                right: 14px;
                gap: 8px
            }

            .ductless-action-btn {
                width: 34px;
                height: 34px
            }

            .ductless-showcase-card__header {
                margin-bottom: 10px
            }

            .ductless-showcase-card__title {
                font-size: 21px;
                line-height: 26px
            }

            .ductless-showcase-card__subtitle {
                font-size: 12px;
                max-width: 75%
            }

            .ductless-showcase-card__pills {
                gap: 4px;
                max-width: 75%
            }

            .ductless-pill {
                padding: 5px 9px;
                font-size: 10.5px
            }

            .ductless-showcase-card__body {
                padding: 14px 16px 20px 16px
            }

            .ductless-diagram-box {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 10px 12px;
                gap: 10px;
                margin-bottom: 10px
            }

            .ductless-diagram-box__meta {
                flex: 1 1 auto !important;
                min-width: 0 !important;
                width: auto !important
            }

            .ductless-diagram-box__illustration {
                flex-shrink: 0 !important;
                width: auto !important;
                max-width: 130px !important;
                margin-top: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: flex-end !important
            }

            .ductless-diagram-box__illustration a,
            .ductless-diagram-link {
                display: inline-block !important;
                width: auto !important
            }

            .ductless-diagram-img {
                max-height: 70px !important;
                max-width: 130px !important;
                width: auto !important;
                height: auto !important;
                object-fit: contain !important;
                display: block !important
            }

            .ductless-specs-bar__divider {
                display: block !important;
                width: 1px !important;
                height: 24px !important;
                background: #e2e8f0 !important;
                flex-shrink: 0 !important
            }

            .ductless-specs-bar {
                padding: 8px 2px;
                margin-bottom: 14px
            }

            .ductless-card-footer {
                gap: 12px
            }

            .ductless-buy-btn {
                max-width: none !important;
                width: auto !important;
                flex: 1 1 auto;
                padding: 9px 18px;
                font-size: 13.5px;
                min-height: 40px
            }

            .ductless-price-wrap {
                min-width: max-content
            }
        }

        @media (max-width:575.98px) {
            .ductless-showcase-card {
                border-radius: 20px
            }

            .ductless-showcase-card__hero {
                min-height: 330px;
                padding: 12px 14px;
                border-radius: 20px;
                background-position: right 5% center
            }

            .ductless-showcase-card__badges {
                gap: 6px;
                margin-bottom: 10px;
                max-width: calc(100% - 42px)
            }

            .ductless-badge {
                padding: 4px 10px;
                font-size: 10px;
                gap: 4px
            }

            .ductless-badge i {
                font-size: 11px
            }

            .ductless-showcase-card__actions {
                top: 12px;
                right: 12px;
                gap: 8px
            }

            .ductless-action-btn {
                width: 32px;
                height: 32px
            }

            .ductless-action-btn svg {
                width: 14px;
                height: 14px
            }

            .ductless-showcase-card__header {
                margin-bottom: 10px
            }

            .ductless-showcase-card__title {
                font-size: 19px;
                line-height: 24px
            }

            .ductless-showcase-card__subtitle {
                font-size: 11.5px;
                line-height: 15px;
                max-width: 72%
            }

            .ductless-showcase-card__pills {
                gap: 3.5px;
                max-width: 72%
            }

            .ductless-pill {
                padding: 4px 8px;
                font-size: 10px;
                gap: 6px;
                border-radius: 6px
            }

            .ductless-pill__icon {
                width: 10px;
                height: 10px
            }

            .ductless-pill__dual-main {
                font-size: 10px
            }

            .ductless-pill__dual-sub {
                font-size: 9px
            }

            .ductless-quickview-btn {
                bottom: 10px;
                right: 12px;
                padding: 4px 10px;
                font-size: 10px;
                gap: 4px
            }

            .ductless-showcase-card__body {
                padding: 12px 14px 16px 14px
            }

            .ductless-diagram-box {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 9px 10px;
                gap: 8px;
                margin-bottom: 8px;
                border-radius: 12px
            }

            .ductless-diagram-box__meta {
                flex: 1 1 auto !important;
                min-width: 0 !important;
                width: auto !important
            }

            .ductless-diagram-box__brand {
                font-size: 9px
            }

            .ductless-diagram-box__model {
                font-size: clamp(10.5px, 0.65rem + 0.6vw, 12.5px);
                line-height: 1.25
            }

            .ductless-diagram-box__system {
                font-size: 9.5px
            }

            .ductless-diagram-box__illustration {
                flex-shrink: 0 !important;
                width: auto !important;
                max-width: 115px !important;
                margin-top: 0 !important;
                text-align: right !important;
                display: flex !important;
                align-items: center !important;
                justify-content: flex-end !important
            }

            .ductless-diagram-box__illustration a,
            .ductless-diagram-link {
                display: inline-block !important;
                width: auto !important
            }

            .ductless-diagram-img {
                max-height: 60px !important;
                max-width: 110px !important;
                width: auto !important;
                height: auto !important;
                object-fit: contain !important;
                border-radius: 8px !important;
                display: block !important
            }

            .ductless-specs-bar {
                padding: 7px 0;
                margin-bottom: 12px;
                border-top: 1px solid #f1f5f9;
                border-bottom: 1px solid #f1f5f9
            }

            .ductless-spec-item__value {
                font-size: 11px;
                gap: 3px
            }

            .ductless-spec-item__value svg {
                height: 8.5px !important;
                width: 8.5px !important
            }

            .ductless-spec-item__label {
                font-size: 9px
            }

            .ductless-specs-bar__divider {
                display: block !important;
                height: 20px !important;
                width: 1px !important;
                background: #e2e8f0 !important;
                flex-shrink: 0 !important
            }

            .ductless-card-footer {
                gap: 10px
            }

            .ductless-buy-btn {
                max-width: none !important;
                width: auto !important;
                flex: 1 1 auto;
                padding: 8px 14px;
                font-size: 13px;
                min-height: 38px;
                gap: 6px
            }

            .ductless-price-wrap {
                min-width: max-content
            }

            .ductless-price {
                font-size: 16px
            }

            .ductless-learn-more {
                font-size: 10.5px;
                margin-top: 2px
            }
        }

        @media (max-width:375.98px) {
            .ductless-showcase-card__hero {
                min-height: 310px;
                padding: 10px 10px
            }

            .ductless-showcase-card__title {
                font-size: 17px;
                line-height: 22px
            }

            .ductless-showcase-card__subtitle {
                font-size: 11px;
                max-width: 70%
            }

            .ductless-showcase-card__pills {
                max-width: 72%
            }

            .ductless-pill {
                padding: 3px 6px;
                font-size: 9.5px;
                gap: 4px
            }

            .ductless-diagram-box {
                padding: 7px 8px;
                gap: 6px
            }

            .ductless-diagram-img {
                max-height: 50px;
                max-width: 85px
            }

            .ductless-showcase-card__body {
                padding: 10px 10px 14px 10px
            }

            .ductless-buy-btn {
                padding: 7px 10px;
                font-size: 12px;
                min-height: 34px
            }

            .ductless-buy-btn svg {
                width: 14px;
                height: 14px
            }

            .ductless-price {
                font-size: 15px
            }

            .ductless-learn-more {
                font-size: 9.5px
            }
        }

        .ductless-modal .modal-dialog {
            max-width: 980px;
            margin: 1.75rem auto;
            width: auto
        }

        .ductless-modal__content {
            border-radius: 20px;
            padding: 28px 30px;
            border: none;
            background: #ffffff;
            box-shadow: 0 30px 60px -15px rgba(15, 23, 42, 0.18), 0 0 1px 1px rgba(15, 23, 42, 0.04);
            position: relative;
            max-height: calc(100dvh - 3rem);
            display: flex;
            flex-direction: column;
            overflow: hidden
        }

        .ductless-modal .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            padding: 0 !important
        }

        .ductless-modal__close-btn {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 13px;
            z-index: 20;
            padding: 0
        }

        .ductless-modal__image-wrapper {
            background-color: #f1f4f8;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 14px;
            min-height: 360px;
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .ductless-modal__info {
            padding-left: 4px
        }

        .ductless-modal__brand {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.06em;
            color: #94a3b8;
            text-transform: uppercase;
            display: block
        }

        .ductless-modal__series-badge {
            background: #ebf5ff;
            color: #0284c7;
            border: 1px solid #bfdbfe;
            font-size: 11px;
            font-weight: 700;
            border-radius: 9999px;
            padding: 4px 14px;
            line-height: 1
        }

        .ductless-modal__title {
            font-size: 24px;
            font-weight: 800;
            color: #090d16;
            line-height: 1.2;
            margin: 8px 0 6px;
            letter-spacing: -0.03em
        }

        .ductless-modal__subtitle {
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
            line-height: 1.35;
            margin-bottom: 10px
        }

        .ductless-modal__desc {
            font-size: 12px;
            font-weight: 400;
            color: #64748b;
            line-height: 1.55;
            margin-bottom: 16px
        }

        .ductless-modal__specs-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 16px;
            text-align: center;
            background: #f8fafc;
            border-radius: 10px;
            padding: 10px 0
        }

        .ductless-modal__spec-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4px 8px;
            border-right: 1px solid #e2e8f0;
            gap: 3px;
            min-width: 0
        }

        .ductless-modal__spec-col:last-child {
            border-right: none
        }

        .ductless-modal__spec-single-text {
            font-size: 10px;
            font-weight: 600;
            color: #64748B;
            line-height: 1.3
        }

        .ductless-modal__spec-label {
            font-size: 10px;
            color: #64748b;
            font-weight: 400;
            line-height: 1.2;
            display: block
        }

        .ductless-modal__spec-value {
            font-size: 13.5px;
            font-weight: 800;
            color: #0F172A;
            line-height: 1.2
        }

        .ductless-modal__matched-section {
            margin-top: 8px
        }

        .ductless-modal__matched-title {
            font-size: 12px;
            font-weight: 700;
            color: #090d16;
            line-height: 16px
        }

        .ductless-modal__matched-sub {
            font-size: 10.5px;
            color: #94A3B8
        }

        .ductless-modal__pill-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 8px
        }

        .ductless-modal__pill {
            background: #fbfcfe;
            border: 1px solid #e2e8f0;
            border-radius: 9999px;
            padding: 5px 10px 5px 12px;
            font-size: 11.5px;
            font-weight: 600;
            color: #1e293b;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.02)
        }

        .ductless-modal__pill i:first-child {
            color: #475569;
            font-size: 12px
        }

        .ductless-modal__pill i:last-child {
            color: #fff;
            font-size: 12px
        }

        .ductless-modal__check {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #1d3f66;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            line-height: 1
        }

        .ductless-modal__footer {
            border-top: 1px solid #f1f5f9;
            padding: 16px 0 0 0;
            margin-top: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px
        }

        .ductless-modal__health-tags {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px 14px
        }

        .ductless-modal__health-tag {
            font-size: 11px;
            font-weight: 600;
            color: #475569;
            display: inline-flex;
            align-items: center;
            gap: 5px
        }

        .ductless-modal__health-tag i {
            color: #64748b;
            font-size: 12px
        }

        .ductless-modal__cta-wrap {
            display: flex;
            align-items: center;
            gap: 10px
        }

        .ductless-modal__btn-view {
            background: #20426b;
            color: #ffffff !important;
            border-radius: 9999px;
            padding: 10px 18px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            white-space: nowrap
        }

        .ductless-modal__btn-compare {
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            color: #334155 !important;
            border-radius: 9999px;
            padding: 9px 22px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap
        }

        @media (max-width:991.98px) {
            .ductless-modal .modal-dialog {
                margin: 1rem auto;
                max-width: 94vw
            }

            .ductless-modal__content {
                padding: 22px 20px;
                border-radius: 18px;
                max-height: calc(100dvh - 2rem)
            }

            .ductless-modal__image-wrapper {
                min-height: 220px;
                max-height: 260px
            }

            .ductless-modal__info {
                padding-left: 0
            }

            .ductless-modal__title {
                font-size: 20px
            }

            .ductless-modal__footer {
                flex-direction: column;
                align-items: stretch;
                gap: 14px
            }

            .ductless-modal__cta-wrap {
                width: 100%;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px
            }

            .ductless-modal__btn-view,
            .ductless-modal__btn-compare {
                width: 100%;
                text-align: center
            }
        }

        @media (max-width:575.98px) {
            .ductless-modal .modal-dialog {
                margin: 0.5rem auto;
                max-width: calc(100vw - 16px)
            }

            .ductless-modal__content {
                padding: 16px 14px 14px;
                border-radius: 16px;
                max-height: calc(100dvh - 16px)
            }

            .ductless-modal__close-btn {
                top: 10px;
                right: 10px;
                width: 30px;
                height: 30px;
                font-size: 12px
            }

            .ductless-modal__image-wrapper {
                min-height: 180px;
                max-height: 200px;
                border-radius: 10px
            }

            .ductless-modal__brand {
                font-size: 10px
            }

            .ductless-modal__series-badge {
                font-size: 10px;
                padding: 3px 10px
            }

            .ductless-modal__title {
                font-size: 17px;
                margin: 6px 0 3px
            }

            .ductless-modal__subtitle {
                font-size: 12px;
                margin-bottom: 6px
            }

            .ductless-modal__desc {
                font-size: 11.5px;
                margin-bottom: 12px;
                line-height: 1.45
            }

            .ductless-modal__specs-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
                padding: 8px;
                margin-bottom: 12px
            }

            .ductless-modal__spec-col {
                border-right: none;
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 6px 4px
            }

            .ductless-modal__spec-label {
                font-size: 9.5px
            }

            .ductless-modal__spec-value {
                font-size: 12.5px
            }

            .ductless-modal__matched-title {
                font-size: 11px
            }

            .ductless-modal__matched-sub {
                font-size: 9.5px
            }

            .ductless-modal__pill-wrap {
                gap: 5px
            }

            .ductless-modal__pill {
                font-size: 10.5px;
                padding: 4px 8px;
                gap: 4px
            }

            .ductless-modal__check {
                width: 14px;
                height: 14px;
                font-size: 9px
            }

            .ductless-modal__health-tags {
                gap: 6px 10px
            }

            .ductless-modal__health-tag {
                font-size: 10px
            }

            .ductless-modal__footer {
                padding-top: 12px;
                margin-top: 12px
            }

            .ductless-modal__cta-wrap {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
                width: 100%
            }

            .ductless-modal__btn-view,
            .ductless-modal__btn-compare {
                padding: 8px 10px;
                font-size: 11.5px
            }
        }
    </style>
@endpush

@push('styles')
    <link rel="stylesheet"
        href="{{ theme_asset('css/product.min.css') }}?v={{ file_exists(public_path('themes/default/assets/css/product.min.css')) ? filemtime(public_path('themes/default/assets/css/product.min.css')) : time() }}">
@endpush

@section('content')
    @php
        $isProducts = request()->route('slug') === 'products';
    @endphp
    <main class="container main-container">
        <h1 class="d-none">Your Main Page Title</h1>
        <div class="row g-0">
            <!-- Left Sidebar Navigation -->
            <aside class="col-lg-3 d-none d-lg-block border-right1px pe-lg-4">
                <nav class="sidebar-menu sticky-sidebar" data-lenis-prevent>
                    @if ($isProducts)
                        <a href="{{ route('products.filter') }}" class="menu-item--special">
                            <span class="special-icon">
                                <img src="{{ theme_asset('img/products-icon.png') }}" width="24" height="24"
                                    alt="Products" loading="lazy" decoding="async">
                            </span>
                            <span>All product</span>
                            <i class="bi bi-chevron-right chevron"></i>
                        </a>
                        <hr class="sidebar-divider mb-3">
                    @endif

                    @foreach ($displayCategories as $cat)
                        <a href="#cat-{{ $cat->id }}" class="menu-item {{ $loop->first ? 'active' : '' }}">
                            <div class="icon-box">
                                <x-category-icon :category="$cat" />
                            </div>
                            <div class="text-box">
                                <h2 class="mb-0">{{ $cat->category_name }}</h2>
                                <small
                                    class="d-block mt-1">{{ \Illuminate\Support\Str::limit($cat->description ?? 'VIEW PRODUCT', 50) }}</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto chevron"></i>
                        </a>
                    @endforeach

                    @if ($isProducts)
                        <hr class="sidebar-divider mt-3">
                        <a href="{{ route('products.filter-step') }}" class="menu-item--special">
                            <span class="special-icon">
                                <svg width="17" height="15" viewBox="0 0 17 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2.77726 1.02777e-06C2.78897 1.02777e-06 2.80072 1.02777e-06 2.81251 1.02777e-06H13.3478C13.8479 -2.14722e-05 14.2756 -4.39603e-05 14.6174 0.043066C14.9798 0.0887935 15.3302 0.191469 15.6179 0.461431C15.9107 0.736156 16.0271 1.07892 16.0781 1.43554C16.1251 1.76313 16.1251 2.17048 16.125 2.63519V3.21759C16.125 3.58397 16.125 3.90071 16.0977 4.16483C16.0682 4.44905 16.0039 4.7157 15.8494 4.9717C15.6961 5.22578 15.4896 5.4102 15.2516 5.57553C15.0274 5.73128 14.7409 5.89253 14.404 6.0822L12.1972 7.32443C11.6948 7.60725 11.5199 7.7091 11.4032 7.81043C11.135 8.0433 10.9814 8.3016 10.9092 8.6253C10.8784 8.76368 10.875 8.9379 10.875 9.46718V11.5163C10.8751 12.1922 10.8751 12.7661 10.8056 13.2072C10.7315 13.6763 10.5599 14.1262 10.1099 14.4077C9.67005 14.6828 9.18563 14.6575 8.71485 14.5457C8.26148 14.438 7.70273 14.2196 7.0323 13.9574L6.96713 13.932C6.6531 13.8092 6.37808 13.7018 6.16039 13.5893C5.92643 13.4685 5.70915 13.3182 5.54291 13.0843C5.37481 12.8477 5.30741 12.594 5.27736 12.3347C5.24996 12.0983 5.24998 11.8145 5.25 11.498V9.46718C5.25 8.9379 5.24666 8.76368 5.21582 8.6253C5.14365 8.3016 4.99007 8.0433 4.72188 7.81043C4.60511 7.7091 4.43019 7.60725 3.92786 7.32443L1.72103 6.0822C1.38412 5.89253 1.09765 5.73128 0.873437 5.57553C0.635432 5.4102 0.428934 5.22578 0.275604 4.9717C0.121112 4.7157 0.0567841 4.44905 0.0273391 4.16483C-2.84482e-05 3.90071 -1.34696e-05 3.58397 1.53039e-06 3.21759L9.04058e-06 2.6735C9.04058e-06 2.66068 1.53039e-06 2.64791 1.53039e-06 2.63518C-2.84696e-05 2.17047 -6.596e-05 1.76313 0.046884 1.43554C0.0979815 1.07892 0.214322 0.736156 0.507137 0.461431C0.794874 0.191469 1.14521 0.0887935 1.50768 0.043066C1.84944 -4.39603e-05 2.27705 -2.14722e-05 2.77726 1.02777e-06ZM1.64847 1.15922C1.39823 1.19079 1.31865 1.24268 1.27688 1.28187C1.24019 1.31629 1.19178 1.37689 1.16051 1.59512C1.12636 1.83341 1.12501 2.15901 1.12501 2.6735V3.19086C1.12501 3.59152 1.1257 3.84959 1.14635 4.04891C1.16558 4.23454 1.1986 4.3238 1.23881 4.39043C1.28018 4.45899 1.34888 4.536 1.51526 4.65157C1.69055 4.77333 1.93002 4.90881 2.29495 5.11424L4.47972 6.3441C4.50018 6.35565 4.52033 6.36698 4.54018 6.37815C4.9592 6.61388 5.24459 6.77445 5.4594 6.9609C5.90292 7.34595 6.18748 7.81365 6.31385 8.3805C6.37527 8.65598 6.37517 8.96483 6.37502 9.40088C6.37502 9.42263 6.375 9.44475 6.375 9.46718V11.4693C6.375 11.8235 6.37588 12.0413 6.39488 12.2052C6.41207 12.3535 6.43914 12.4034 6.45998 12.4327C6.48269 12.4646 6.52768 12.5129 6.6765 12.5897C6.8358 12.672 7.05533 12.7586 7.4019 12.894C8.12265 13.1758 8.60745 13.3639 8.9748 13.4511C9.33375 13.5364 9.45203 13.4922 9.51323 13.4539C9.56423 13.422 9.64298 13.3573 9.69428 13.032C9.74835 12.689 9.75 12.2051 9.75 11.4693V9.46718C9.75 9.44475 9.75 9.42263 9.75 9.40088C9.74985 8.96483 9.7497 8.65598 9.81113 8.3805C9.9375 7.81365 10.2221 7.34595 10.6656 6.9609C10.8804 6.77445 11.1658 6.61388 11.5848 6.37815C11.6047 6.36698 11.6249 6.35565 11.6453 6.3441L13.8301 5.11424C14.195 4.90881 14.4345 4.77333 14.6098 4.65157C14.7761 4.536 14.8448 4.45899 14.8862 4.39043C14.9264 4.3238 14.9594 4.23454 14.9786 4.04891C14.9993 3.84959 15 3.59152 15 3.19086V2.6735C15 2.15901 14.9987 1.83341 14.9645 1.59512C14.9333 1.37689 14.8848 1.31629 14.8481 1.28187C14.8064 1.24268 14.7268 1.19079 14.4766 1.15922C14.2136 1.12606 13.8578 1.125 13.3125 1.125H2.81251C2.26723 1.125 1.91141 1.12606 1.64847 1.15922Z"
                                        fill="#231F20" />
                                </svg>

                            </span>
                            <span>Find Your Solutions</span>
                            <i class="bi bi-chevron-right chevron"></i>
                        </a>
                    @endif
                </nav>
            </aside>

            <section class="col-lg-9 {{ $adSliders->count() > 0 ? 'col-xl-6' : 'col-xl-9' }} center-feed pb-5 px-lg-4">

                <!-- Mobile Horizontal Category Scroll Bar (Visible on mobile/tablet screens) -->
                <div class="d-lg-none mobile-category-scroll-wrapper" data-lenis-prevent>
                    <div class="mobile-category-scroll-track" data-lenis-prevent>
                        @if ($isProducts)
                            <a href="{{ route('products.filter') }}"
                                class="mobile-cat-pill mobile-cat-pill--special {{ request()->routeIs('products.filter') ? 'active' : '' }}">
                                <span class="mobile-cat-pill__icon">
                                    <img src="{{ theme_asset('img/products-icon.png') }}" width="15" height="15"
                                        alt="Products" loading="lazy" decoding="async">
                                </span>
                                <span>All Products</span>
                            </a>
                            <a href="{{ route('products.filter-step') }}"
                                class="mobile-cat-pill mobile-cat-pill--special {{ request()->routeIs('products.filter-step') ? 'active' : '' }}">
                                <span class="mobile-cat-pill__icon">
                                    <svg width="15" height="14" viewBox="0 0 17 15" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.77726 1.02777e-06C2.78897 1.02777e-06 2.80072 1.02777e-06 2.81251 1.02777e-06H13.3478C13.8479 -2.14722e-05 14.2756 -4.39603e-05 14.6174 0.043066C14.9798 0.0887935 15.3302 0.191469 15.6179 0.461431C15.9107 0.736156 16.0271 1.07892 16.0781 1.43554C16.1251 1.76313 16.1251 2.17048 16.125 2.63519V3.21759C16.125 3.58397 16.125 3.90071 16.0977 4.16483C16.0682 4.44905 16.0039 4.7157 15.8494 4.9717C15.6961 5.22578 15.4896 5.4102 15.2516 5.57553C15.0274 5.73128 14.7409 5.89253 14.404 6.0822L12.1972 7.32443C11.6948 7.60725 11.5199 7.7091 11.4032 7.81043C11.135 8.0433 10.9814 8.3016 10.9092 8.6253C10.8784 8.76368 10.875 8.9379 10.875 9.46718V11.5163C10.8751 12.1922 10.8751 12.7661 10.8056 13.2072C10.7315 13.6763 10.5599 14.1262 10.1099 14.4077C9.67005 14.6828 9.18563 14.6575 8.71485 14.5457C8.26148 14.438 7.70273 14.2196 7.0323 13.9574L6.96713 13.932C6.6531 13.8092 6.37808 13.7018 6.16039 13.5893C5.92643 13.4685 5.70915 13.3182 5.54291 13.0843C5.37481 12.8477 5.30741 12.594 5.27736 12.3347C5.24996 12.0983 5.24998 11.8145 5.25 11.498V9.46718C5.25 8.9379 5.24666 8.76368 5.21582 8.6253C5.14365 8.3016 4.99007 8.0433 4.72188 7.81043C4.60511 7.7091 4.43019 7.60725 3.92786 7.32443L1.72103 6.0822C1.38412 5.89253 1.09765 5.73128 0.873437 5.57553C0.635432 5.4102 0.428934 5.22578 0.275604 4.9717C0.121112 4.7157 0.0567841 4.44905 0.0273391 4.16483C-2.84482e-05 3.90071 -1.34696e-05 3.58397 1.53039e-06 3.21759L9.04058e-06 2.6735C9.04058e-06 2.66068 1.53039e-06 2.64791 1.53039e-06 2.63518C-2.84696e-05 2.17047 -6.596e-05 1.76313 0.046884 1.43554C0.0979815 1.07892 0.214322 0.736156 0.507137 0.461431C0.794874 0.191469 1.14521 0.0887935 1.50768 0.043066C1.84944 -4.39603e-05 2.27705 -2.14722e-05 2.77726 1.02777e-06ZM1.64847 1.15922C1.39823 1.19079 1.31865 1.24268 1.27688 1.28187C1.24019 1.31629 1.19178 1.37689 1.16051 1.59512C1.12636 1.83341 1.12501 2.15901 1.12501 2.6735V3.19086C1.12501 3.59152 1.1257 3.84959 1.14635 4.04891C1.16558 4.23454 1.1986 4.3238 1.23881 4.39043C1.28018 4.45899 1.34888 4.536 1.51526 4.65157C1.69055 4.77333 1.93002 4.90881 2.29495 5.11424L4.47972 6.3441C4.50018 6.35565 4.52033 6.36698 4.54018 6.37815C4.9592 6.61388 5.24459 6.77445 5.4594 6.9609C5.90292 7.34595 6.18748 7.81365 6.31385 8.3805C6.37527 8.65598 6.37517 8.96483 6.37502 9.40088C6.37502 9.42263 6.375 9.44475 6.375 9.46718V11.4693C6.375 11.8235 6.37588 12.0413 6.39488 12.2052C6.41207 12.3535 6.43914 12.4034 6.45998 12.4327C6.48269 12.4646 6.52768 12.5129 6.6765 12.5897C6.8358 12.672 7.05533 12.7586 7.4019 12.894C8.12265 13.1758 8.60745 13.3639 8.9748 13.4511C9.33375 13.5364 9.45203 13.4922 9.51323 13.4539C9.56423 13.422 9.64298 13.3573 9.69428 13.032C9.74835 12.689 9.75 12.2051 9.75 11.4693V9.46718C9.75 9.44475 9.75 9.42263 9.75 9.40088C9.74985 8.96483 9.7497 8.65598 9.81113 8.3805C9.9375 7.81365 10.2221 7.34595 10.6656 6.9609C10.8804 6.77445 11.1658 6.61388 11.5848 6.37815C11.6047 6.36698 11.6249 6.35565 11.6453 6.3441L13.8301 5.11424C14.195 4.90881 14.4345 4.77333 14.6098 4.65157C14.7761 4.536 14.8448 4.45899 14.8862 4.39043C14.9264 4.3238 14.9594 4.23454 14.9786 4.04891C14.9993 3.84959 15 3.59152 15 3.19086V2.6735C15 2.15901 14.9987 1.83341 14.9645 1.59512C14.9333 1.37689 14.8848 1.31629 14.8481 1.28187C14.8064 1.24268 14.7268 1.19079 14.4766 1.15922C14.2136 1.12606 13.8578 1.125 13.3125 1.125H2.81251C2.26723 1.125 1.91141 1.12606 1.64847 1.15922Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <span>Find Solutions</span>
                            </a>
                        @endif

                        @foreach ($displayCategories as $cat)
                            <a href="#cat-{{ $cat->id }}" class="mobile-cat-pill {{ $loop->first ? 'active' : '' }}">
                                <span class="mobile-cat-pill__icon">
                                    <x-category-icon :category="$cat" />
                                </span>
                                <span>{{ $cat->category_name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Dynamic Category Showcase Sections (Loop through categories and their products) -->
                @foreach ($displayCategories as $cat)
                    <div id="cat-{{ $cat->id }}" class="category-showcase-section content-section mb-5 pb-2">

                        {{-- 2-Column Product Showcase Grid for this Category --}}
                        <div class="row g-4">
                            @php
                                $categoryProducts = $cat->products;
                                if ($categoryProducts->isEmpty() && $cat->children && $cat->children->isNotEmpty()) {
                                    $categoryProducts = $cat->children->pluck('products')->flatten();
                                }
                                $categoryProducts = $categoryProducts->take(4);
                            @endphp

                            @forelse ($categoryProducts as $product)
                                <div class="col-12">
                                    @include('themes.default.partials.ductless_feature_card', [
                                        'product' => $product,
                                    ])
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-light border text-muted py-3 px-4 rounded-3">
                                        <i class="bi bi-info-circle me-2"></i> No products available in
                                        {{ $cat->category_name }}.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </section>

            @if ($adSliders->count() > 0)
                <!-- Right Sidebar Feature -->
                <aside class="col-lg-12 col-xl-3 d-none d-xl-block border-left1px">
                    <!-- Swiper Slider Implementation -->

                    @include('themes.default.partials.ad_slider')
                </aside>
            @endif
        </div>
    </main>
@endsection
