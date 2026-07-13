@extends('layouts.master')

@section('title', $page->page_title)
@section('breadcrumb', $page->breadcrumb)
@section('content')
@yield('page-content')
@php
$gallery = \App\Models\Gallery::where('status', 1)
->where('scope', 0)
->latest()
->paginate(12);
@endphp
{{-- Event Gallery section start  --}}
<section class="py-100 container">
    <div class="row row-cols-md-3 row-cols-xl-4 row-cols-sm-2 g-4">
        @forelse ($gallery as $item)
        <div>
            <a href="{{ route('gallery-details', $item->id) }}" class="">
                <div class="gaming-news-card running-event-card card-smooth">
                    <img src="{{ getImageCacheUrl($item->thumb, 262, 230) }}" class="card-img-top"
                        alt="{{ $item->alt_name }}">
                    <div class="card-body">
                        <h5 class="title-five min-h-38">
                            {{ truncateText($item->name, 40) }}
                        </h5>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">No Gallery Found</p>
        </div>
        @endforelse
    </div>
    <div class=" text-center mt-60">
        {{ $gallery->links() }}
    </div>
</section>
{{-- Event Gallery section End  --}}
@endsection
