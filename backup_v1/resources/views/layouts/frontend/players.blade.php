@extends('layouts.master')

@section('title', $page->page_title)
@section('breadcrumb', $page->breadcrumb)
@section('content')
    @yield('page-content')
    @php
        $pageTitle = 'Players';
        $players = \App\Models\Player::where('status', 1)->orderBy('created_at', 'desc')->paginate(12);
    @endphp
    <!-- Players section start -->
    <section class="py-100 container pt-0">
        <div class="gaming-news-slider position-relative">
            <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 g-4">
                @forelse ($players as $player)
                    <div>
                        <div class="latest-blog-card news-card card-smooth">
                            <div class="position-relative">
                                <!-- Player Image -->
                                <img src="{{ getImageCacheUrl($player->image, 262, 225) }}" class="card-img-top"
                                    alt="{{ $player->name }}">
                            </div>

                            <div class="card-body">
                                <!-- Player Name + Sport -->
                                <div class="content-text d-flex align-items-center gap-2 text-muted">
                                    <span><i class="fas fa-user"></i></span>
                                    <span>{{ $player->sport }}</span>
                                </div>

                                <hr class="mt-12">

                                <h5 class="title-four mb-12">
                                    <a href="{{ route('player.details', $player->slug) }}" class="">
                                        {{ truncateText($player->name, 38) }}
                                    </a>
                                </h5>

                                <!-- Position / Team / Age -->
                                <p class="content-text mb-3">
                                    @if ($player->position)
                                        <strong>Position:</strong> {{ $player->position }}<br>
                                    @endif
                                    @if ($player->team)
                                        <strong>Team:</strong> {{ $player->team }}<br>
                                    @endif
                                    @if ($player->age)
                                        <strong>Age:</strong> {{ $player->age }}
                                    @endif
                                </p>
                                <div class="">

                                    <a href="{{ route('player.details', $player->slug) }}"
                                        class="btn-primary btn-common">View
                                        Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No players found.</p>
                @endforelse
            </div>

            <div class="text-center mt-60">
                {{ $players->links() }}
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            .latest-blog-card {
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .latest-blog-card .card-body {
                flex-grow: 1;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }



            .published-date {
                padding: 8px 10px;
                gap: 8px;
                border-radius: 0 !important;
                color: var(--common-white);
                position: absolute;
                bottom: 20px;
                left: 20px;
            }

            .news-card .card-body {
                padding: 20px;
                border: 1px solid #EAEAEA;
                border-top: 0;
                background-color: var(--common-white);
            }
        </style>
    @endpush
    <!-- Players section End -->
@endsection
