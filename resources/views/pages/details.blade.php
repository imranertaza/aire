@extends('layouts.frontend.' . $page->temp)
@section('page-content')
    <!-- About section start  -->
    <section class="container py-100 @if ($page->temp != 'default' && $page->temp != 'about' && $page->temp != 'history') pb-0 @endif">
        <h2 class="title-two pb-3 border-bottom border-black">{{ $page->page_title }}</h2>
        @if ($page->f_image)
            <div class="pt-3">
                <img class="img-fluid" src="{{ getImageCacheUrl($page->f_image, 1140, 375) }}" alt="">
            </div>
        @endif
        @if ($page->page_description)
            <div class="text-dark-emphasis pt-3 page-description">
                {!! $page->page_description !!}
            </div>
        @endif
    </section>
    <!-- About section End  -->
    @push('styles')
        <style>
            .page-description img {
                max-width: 100% !important;
                height: auto !important;
            }
        </style>
    @endpush
@endsection
