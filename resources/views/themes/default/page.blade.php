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


    $template = strtolower(trim($page->temp ?? 'default'));
    $templateNormalized = str_replace(['_', ' '], '-', $template);
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDesc)
@if (!empty($pageKeywords))
    @section('meta_keywords', $pageKeywords)
@endif
@section('og_image', $pageImg)
@section('canonical_url', $canonicalUrl)

@section('content')
    @if (!empty($templateNormalized) && $templateNormalized !== 'default' && view()->exists('themes.' . active_theme() . '.pages.templates.' . $templateNormalized))
        @include('themes.' . active_theme() . '.pages.templates.' . $templateNormalized)
    @else
        @include('themes.' . active_theme() . '.pages.templates.default')
    @endif
@endsection
