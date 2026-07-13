@extends('layouts.master')

@section('title', $category->category_name)
@section('breadcrumb', $category->breadcrumb)
@section('content')
    {{-- Event Gallery section start  --}}
    <!-- News & Updates section start -->
    <section class="py-100 container">
        <div class="mb-4">
            <h2 class="title-two pb-3 border-bottom border-black">{{ $category->category_name }}</h2>
            @if ($category->image)
                <div class="pt-3">
                    <img class="img-fluid w-100" src="{{ getImageCacheUrl($category->image, 1140, 586) }}" alt="">
                </div>
            @endif
            @if ($category->description)
                <div class="text-dark-emphasis pt-3">
                    {!! $category->description !!}
                </div>
            @endif
        </div>
        <div class="row  row-cols-xl-4 row-cols-md-3 row-cols-sm-2 g-4 pt-4">
            @foreach ($posts as $post)
                <div class="">
                    <a href="{{ route('sports-details', $post->slug) }}" class="">
                        <div class="gaming-news-card running-event-card card-smooth">
                            <img src="{{ getImageCacheUrl($post->f_image, 262, 230) }}" class="card-img-top" alt="news image">
                            <div class="card-body">
                                <h5 class="title-five">
                                    {{ truncateText($post->post_title, 48) }}
                                </h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-60">
            {{ $posts->links() }}
        </div>
    </section>
    <!-- News & Updates contact section End -->
    {{-- Event Gallery section End  --}}
    @push('styles')
        <style>
        h5.title-five {
    min-height: 38.45px;
}
            .page-description img {
                max-width: 100% !important;
                height: auto !important;
            }
        </style>
    @endpush
@endsection
