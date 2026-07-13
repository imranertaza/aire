@extends('layouts.master')

@section('title', $page->page_title)
@section('breadcrumb', $page->breadcrumb)
@section('content')
    @yield('page-content')
    @php
        $pageTitle = 'History';
        $history = App\Models\Section::where('name', 'history_history')->first();
    @endphp
    <!-- History Start  -->
    <section class="bg-primary py-100 mission">
        <div class="container">
            <div class="row row-cols-md-2 align-items-center gx-xl-5">
                <div class="">
                    <div class="pe-md-3">
                        <div class="d-inline-flex flex-column gap-2">
                            <h2 class="title-two d-inline-block text-white">{{ $history->data['title'] }}</h2>
                            <div class="custom-underline mt-0 mb-3 w-100 bg-white"></div>
                        </div>
                        {!! $history->data['content'] !!}
                    </div>
                </div>
                <div class="">
                    <div class="ps-md-3">
                        <img src="{{ getImageCacheUrl($history->data['image'], 520, 507) }}" class="img-fluid w-100"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- History End  -->

@endsection
