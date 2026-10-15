@extends('themes.default.layouts.master')

@php
    $pageTitle = !empty($page->meta_title) ? $page->meta_title : $page->page_title . ' | ' . config('app.name', 'Aire');
    $pageDesc = !empty($page->meta_description)
        ? $page->meta_description
        : (!empty($page->short_des)
            ? $page->short_des
            : \Illuminate\Support\Str::limit(strip_tags($page->page_description ?? ''), 160));
    $pageKeywords = $page->meta_keyword ?? '';
    $pageImg = !empty($page->f_image) ? getImageUrl($page->f_image) : theme_asset('img/og-share-banner.jpg');
    $canonicalUrl = route('page.show', $page->slug ?? 'page');
    $currentSlug = $page->slug ?? '';

    // Determine whether this page should use the Legal/Policy layout
    $legalSlugs = [
        'cookie-policy',
        'privacy-policy',
        'terms-of-service',
        'terms-and-conditions',
        'modern-slavery-statement',
        'modern-slavery',
        'data-protection',
        'export-compliance',
        'legal-notice',
        'terms-of-use',
        'sitemap',
    ];

    $template = strtolower($page->temp ?? 'default');
    $isLegal =
        $template === 'legal' ||
        $template === 'policy' ||
        in_array($currentSlug, $legalSlugs) ||
        \Illuminate\Support\Str::contains(strtolower($page->breadcrumb ?? ''), ['legal', 'policy', 'compliance']);
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDesc)
@if (!empty($pageKeywords))
    @section('meta_keywords', $pageKeywords)
@endif
@section('og_image', $pageImg)
@section('canonical_url', $canonicalUrl)

@section('content')
    @if ($isLegal)
        @include('themes.' . active_theme() . '.pages.templates.legal')
    @else
        @include('themes.' . active_theme() . '.pages.templates.default')
    @endif
@endsection
