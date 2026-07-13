@extends('layouts.master')

@section('title', 'Gallery Details')
@section('breadcrumb', 'Gallery Details')
@section('content')

    {{-- Event Gallery Details section start  --}}
    <section class="py-100 container">
        <div class="gaming-news-slider position-relative">
            <h2 class="header-one text-blue mb-60">{{ $gallery->name }}</h2>
            <div class="row row-cols-lg-3 row-cols-md-2 g-4">
                @forelse ($details as $item)
                    <div>
                        <div class="upcoming-event-card card-smooth">
                            <a href="{{ getImageUrl($item->image) }}" data-lightbox="event-gallery"
                                data-title="Upcoming Event 1">
                                <img src="{{ getImageCacheUrl($item->image, 400, 300) }}" class="card-img-top"
                                    alt="Upcoming Event 1">
                                <div class="img-overlay">
                                    <span class="overlay-text fs-1"><svg xmlns="http://www.w3.org/2000/svg" width="60"
                                            height="60" viewBox="0 0 30 30">
                                            <line x1="15" y1="5" x2="15" y2="25"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                            <line x1="5" y1="15" x2="25" y2="15"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div>
                        <h4 class="text-center">No Image Found</h4>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-60">
                {{ $details->links() }}
            </div>
        </div>
    </section>
    {{-- Event Gallery Details section End  --}}
    @push('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">

        <style>
            .upcoming-event-card img {
                height: 392px;
            }

            .upcoming-event-card {
                position: relative;
                overflow: hidden;
            }

            .upcoming-event-card img {
                transition: transform 0.5s ease;
            }

            /* zoom image on hover */
            .upcoming-event-card:hover img {
                transform: scale(1.1);
            }

            /* overlay setup */
            .upcoming-event-card .img-overlay {
                position: absolute;
                inset: 0;
                /* shorthand for top:0; right:0; bottom:0; left:0 */
                background: rgba(0, 0, 0, 0.5);
                /* semi-transparent black */
                display: flex;
                justify-content: center;
                align-items: center;
                opacity: 0;
                transition: opacity 0.4s ease;
            }

            .upcoming-event-card .overlay-text {
                color: #fff;
                font-size: 1.2rem;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            /* show overlay on hover */
            .upcoming-event-card:hover .img-overlay {
                opacity: 1;
            }


            .upcoming-event-card .overlay-text {
                transform: translateY(20px);
                opacity: 0;
                transition: all 0.4s ease;
            }

            .upcoming-event-card:hover .overlay-text {
                transform: translateY(0);
                opacity: 1;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

        <script>
            $(document).ready(function() {
                lightbox.option({
                    resizeDuration: 200,
                    wrapAround: true,
                    alwaysShowNavOnTouchDevices: true
                });
            });
        </script>
    @endpush
@endsection
