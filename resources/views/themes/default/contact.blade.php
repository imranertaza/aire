@extends('themes.default.layouts.master')

@php
    $pageTitle = !empty($page->meta_title)
        ? $page->meta_title
        : (!empty($page->page_title) ? $page->page_title . ' | ' . config('app.name', 'Aire') : 'Contact Us | ' . config('app.name', 'Aire'));
    $pageDesc = !empty($page->meta_description)
        ? $page->meta_description
        : (!empty($page->short_des)
            ? $page->short_des
            : 'Get in touch with AIRE Industries — clean air engineering specialists, customer support, and commercial IAQ consultation.');
    $pageKeywords = $page->meta_keyword ?? ($page->meta_keywords ?? '');
    $pageImg = !empty($page->f_image) ? getImageUrl($page->f_image) : theme_asset('img/og-share-banner.jpg');
    $canonicalUrl = route('contact');
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDesc)
@if (!empty($pageKeywords))
    @section('meta_keywords', $pageKeywords)
@endif
@section('og_image', $pageImg)
@section('canonical_url', $canonicalUrl)

@section('content')
    @include('themes.default.pages.templates.contact')
@endsection
