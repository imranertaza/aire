@extends('layouts.master')

@section('title', $page->page_title)
@section('breadcrumb', $page->breadcrumb)
@section('content')
    @yield('page-content')
    <!-- Blogs section start -->
    <section class="py-100 container">
        @php
            $blogs = \App\Models\Blog::where('status', '1')->latest()->paginate(12);
        @endphp
        <div class="d-flex justify-content-between mb-60">
            {{-- <h2 class="title-two">Our Latest Blog</h2> --}}
        </div>
        <div class="gaming-news-slider position-relative">
            <div class="row row-cols-md-3 g-4 justify-content-center justify-content-md-start">
                @forelse ($blogs as $item)
                    <div>
                        <div class="gaming-news-card latest-blog-card card-smooth">
                            <img src="{{ getImageCacheUrl($item->f_image, 357, 225) }}" class="card-img-top" alt="news image">
                            <div class="card-body">
                                <p class="content-text d-flex align-items-center"><svg width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M17 5.49844L12.9965 5.49845V4.50195C12.9965 4.2257 12.7727 4.00195 12.4965 4.00195C12.2203 4.00195 11.9965 4.2257 11.9965 4.50195V5.4982H7.9965V4.50195C7.9965 4.2257 7.77275 4.00195 7.4965 4.00195C7.22025 4.00195 6.9965 4.2257 6.9965 4.50195V5.4982H3C2.44775 5.4982 2 5.94595 2 6.4982V18.9982C2 19.5504 2.44775 19.9982 3 19.9982H17C17.5522 19.9982 18 19.5504 18 18.9982V6.4982C18 5.94619 17.5522 5.49844 17 5.49844ZM17 18.9982H3V6.4982H6.9965V7.00195C6.9965 7.27819 7.22025 7.50195 7.4965 7.50195C7.77275 7.50195 7.9965 7.27819 7.9965 7.00195V6.49845H11.9965V7.0022C11.9965 7.27845 12.2203 7.5022 12.4965 7.5022C12.7727 7.5022 12.9965 7.27845 12.9965 7.0022V6.49845H17V18.9982ZM13.5 11.9984H14.5C14.776 11.9984 15 11.7744 15 11.4984V10.4984C15 10.2224 14.776 9.99844 14.5 9.99844H13.5C13.224 9.99844 13 10.2224 13 10.4984V11.4984C13 11.7744 13.224 11.9984 13.5 11.9984ZM13.5 15.9982H14.5C14.776 15.9982 15 15.7744 15 15.4982V14.4982C15 14.2222 14.776 13.9982 14.5 13.9982H13.5C13.224 13.9982 13 14.2222 13 14.4982V15.4982C13 15.7747 13.224 15.9982 13.5 15.9982ZM10.5 13.9982H9.5C9.224 13.9982 9 14.2222 9 14.4982V15.4982C9 15.7744 9.224 15.9982 9.5 15.9982H10.5C10.776 15.9982 11 15.7744 11 15.4982V14.4982C11 14.2224 10.776 13.9982 10.5 13.9982ZM10.5 9.99844H9.5C9.224 9.99844 9 10.2224 9 10.4984V11.4984C9 11.7744 9.224 11.9984 9.5 11.9984H10.5C10.776 11.9984 11 11.7744 11 11.4984V10.4984C11 10.2222 10.776 9.99844 10.5 9.99844ZM6.5 9.99844H5.5C5.224 9.99844 5 10.2224 5 10.4984V11.4984C5 11.7744 5.224 11.9984 5.5 11.9984H6.5C6.776 11.9984 7 11.7744 7 11.4984V10.4984C7 10.2222 6.776 9.99844 6.5 9.99844ZM6.5 13.9982H5.5C5.224 13.9982 5 14.2222 5 14.4982V15.4982C5 15.7744 5.224 15.9982 5.5 15.9982H6.5C6.776 15.9982 7 15.7744 7 15.4982V14.4982C7 14.2224 6.776 13.9982 6.5 13.9982Z"
                                            fill="black" />
                                    </svg>
                                    {{ formatDate($item->publish_date) }}
                                </p>
                                <h5 class="title-four mb-3">
                                    <a href="" class="">{{ truncateText($item->title, 40) }}</a>
                                </h5>
                                <a href="{{ route('blogs-details', $item->slug) }}" class="btn-primary btn-common">View
                                    Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>
            <div class=" text-center mt-60">
                {{ $blogs->links() }}
            </div>
        </div>
    </section>
    @push('styles')
        <style>
            .published-date {
                padding: 8px 10px;
                gap: 8px;
                border-radius: 0 !important;
                color: var(--common-white);
                position: absolute;
                bottom: 20px;
                left: 20px;
            }

            @media screen and (max-width: 768px) {
                .contact-query-section .card {
                    padding: 22px 30px;
                }
            }

            .news-card .card-body {
                padding: 20px;
                border: 1px solid #EAEAEA;
                border-top: 0;
                background-color: var(--common-white);
            }
        </style>
    @endpush
    <!-- News & Updates contact section End -->
@endsection
