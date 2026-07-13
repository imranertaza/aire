@extends('layouts.master')

@section('title', 'Upcoming Events')
@section('breadcrumb', 'Upcoming Events')
@section('content')
    <!-- Upcoming Event section start -->
    <section class="py-100 container">
        <div class="row row-cols-md-3 row-cols-sm-2 row-cols-xl-4 g-4">
            @forelse ($events as $event)
                <div class="">
                    <div class="upcoming-event-card card-smooth">
                        <a href="{{ route('event-details', $event->slug) }}" aria-label="{{ $event->title }}">
                            <img src="{{ getImageCacheUrl($event->featured_image, 254, 517) }}"
                                class="card-img-top img-thumbnail" alt="{{ $event->title }}">
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">No events found.</p>
                </div>
            @endforelse

        </div>
        <div class=" text-center mt-60">
            {{ $events->links() }}
        </div>
    </section>
    <!-- Running Event contact section End -->
    @push('styles')
        <style>
            .card-img-top {
                border: none;
            }
        </style>
    @endpush
@endsection
