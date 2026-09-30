@extends('layouts.master')
@section('title', 'Pages List')
@section('content')
<div class="container">
    <h5 class="mb-4 text-primary">Pages List</h5>

    <div class="row">
        @foreach ($pages as $page)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-capitalize">{{ $page->page_title }}</h5>
                        <p class="card-text text-muted">{{ $page->short_des }}</p>
                        <div class="mt-auto">
                            <a href="{{ route('page.details', $page->slug) }}" class="btn btn-outline-primary btn-sm">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
