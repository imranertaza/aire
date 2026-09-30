@extends('layouts.master')

@section('title', $page->page_title)
@section('breadcrumb', $page->breadcrumb)
@section('content')
    @yield('page-content')
    {{-- Match Fixtures section start  --}}
    <section class="container py-100">
        {{-- <h2 class="title-two pb-3 border-bottom border-black">Match Fixtures</h2> --}}
        @php

            $matchFixtures = \App\Models\Notice::where('type', 1)->where('status', 1)->latest()->paginate(10);

        @endphp
        <div class="notice-board">
            @forelse ($matchFixtures as $fixture)
                <div
                    class="single-notice d-flex flex-column flex-md-row gap-3 gap-md-0 align-items-center justify-content-between py-50 border-bottom">
                    <div class="">
                        <p class="content-text m-0">{{ $fixture->title }}</p>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        @if ($fixture->file)
                            <a href="{{ getImageUrl($fixture->file) }}" download="{{ $fixture->title }}" target="_blank"
                                class="d-flex align-items-center gap-3">
                                <span><svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8 12L3 7L4.4 5.55L7 8.15V0H9V8.15L11.6 5.55L13 7L8 12ZM2 16C1.45 16 0.979333 15.8043 0.588 15.413C0.196666 15.0217 0.000666667 14.5507 0 14V11H2V14H14V11H16V14C16 14.55 15.8043 15.021 15.413 15.413C15.0217 15.805 14.5507 16.0007 14 16H2Z"
                                            fill="#333333" />
                                    </svg>
                                </span>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <p class="content-text m-0">No fixtures available.</p>
            @endforelse
        </div>
        <div class=" text-center mt-60">
            {{ $matchFixtures->links() }}
        </div>
    </section>
    {{-- Match Fixtures section End  --}}
@endsection
