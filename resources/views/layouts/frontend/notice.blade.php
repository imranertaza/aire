@extends('layouts.master')

@section('title', $page->page_title)
@section('breadcrumb', $page->breadcrumb)
@section('content')
    @yield('page-content')
    {{-- Notice Board section start --}}
    <section class="container py-100">
        {{-- <h2 class="title-two pb-3 border-bottom border-black">Notice Board</h2> --}}
        @php
            $notice = \App\Models\Notice::where('type', 0)->where('status', 1)->latest()->paginate(10);
        @endphp
        <div class="notice-board">

            @forelse ($notice as $item)
                <div
                    class="single-notice d-flex flex-column flex-md-row gap-3 gap-md-0 align-items-center justify-content-between py-50 border-bottom">
                    <div class="d-flex align-items-center gap-3">

                        <span><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 21H14C14 22.1 13.1 23 12 23C10.9 23 10 22.1 10 21ZM21 19V20H3V19L5 17V11C5 7.9 7 5.2 10 4.3V4C10 2.9 10.9 2 12 2C13.1 2 14 2.9 14 4V4.3C17 5.2 19 7.9 19 11V17L21 19ZM17 11C17 8.2 14.8 6 12 6C9.2 6 7 8.2 7 11V18H17V11Z"
                                    fill="#333333" />
                            </svg>
                        </span>
                        <div class="">
                            <p class="content-text m-0">{{ $item->title }}</p>
                            <p class="content-text text-muted m-0">{{ $item->created_at->format('d M') }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        @if ($item->file)
                            <a href="{{ getImageUrl($item->file) }}" download="{{ $item->title }}" target="_blank"
                                class="d-flex align-items-center gap-3">
                                <p class="my-0 content-text">Download</p>
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
                <div
                    class="single-notice d-flex flex-column flex-md-row gap-3 gap-md-0 align-items-center justify-content-between py-50 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <span><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 21H14C14 22.1 13.1 23 12 23C10.9 23 10 22.1 10 21ZM21 19V20H3V19L5 17V11C5 7.9 7 5.2 10 4.3V4C10 2.9 10.9 2 12 2C13.1 2 14 2.9 14 4V4.3C17 5.2 19 7.9 19 11V17L21 19ZM17 11C17 8.2 14.8 6 12 6C9.2 6 7 8.2 7 11V18H17V11Z"
                                    fill="#333333" />
                            </svg>
                        </span>
                        <div class="">
                            <p class="content-text m-0">No notice available</p>
                        </div>
                    </div>
            @endforelse
        </div>
        <div class="text-center mt-60">
            {{ $notice->links() }}
        </div>
    </section>
    {{-- Notice Board section End  --}}
@endsection
