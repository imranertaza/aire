@extends('layouts.master')

@section('title', $page->page_title)
@section('breadcrumb', $page->breadcrumb)
@section('content')
    @yield('page-content')
    <!-- News & Updates section start -->
    @php
        $news = \App\Models\News::getSpotlightNews();
    @endphp

    <section class="py-100 container">
        <div class="gaming-news-slider position-relative">
            <div class="row row-cols-lg-3 row-cols-sm-2 g-4">
                @forelse ($news as $item)
                    <div>
                        <div class="latest-blog-card news-card card-smooth">
                            <div class="position-relative">
                                <img src="{{ getImageCacheUrl($item->f_image, 358, 226) }}" class="card-img-top"
                                    alt="news image">
                                <div class="content-text d-inline-flex align-items-center bg-primary published-date">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1.125 16.3125C1.125 17.2441 1.88086 18 2.8125 18H15.1875C16.1191 18 16.875 17.2441 16.875 16.3125V6.75H1.125V16.3125ZM12.375 9.42188C12.375 9.18984 12.5648 9 12.7969 9H14.2031C14.4352 9 14.625 9.18984 14.625 9.42188V10.8281C14.625 11.0602 14.4352 11.25 14.2031 11.25H12.7969C12.5648 11.25 12.375 11.0602 12.375 10.8281V9.42188ZM12.375 13.9219C12.375 13.6898 12.5648 13.5 12.7969 13.5H14.2031C14.4352 13.5 14.625 13.6898 14.625 13.9219V15.3281C14.625 15.5602 14.4352 15.75 14.2031 15.75H12.7969C12.5648 15.75 12.375 15.5602 12.375 15.3281V13.9219ZM7.875 9.42188C7.875 9.18984 8.06484 9 8.29688 9H9.70312C9.93516 9 10.125 9.18984 10.125 9.42188V10.8281C10.125 11.0602 9.93516 11.25 9.70312 11.25H8.29688C8.06484 11.25 7.875 11.0602 7.875 10.8281V9.42188ZM7.875 13.9219C7.875 13.6898 8.06484 13.5 8.29688 13.5H9.70312C9.93516 13.5 10.125 13.6898 10.125 13.9219V15.3281C10.125 15.5602 9.93516 15.75 9.70312 15.75H8.29688C8.06484 15.75 7.875 15.5602 7.875 15.3281V13.9219ZM3.375 9.42188C3.375 9.18984 3.56484 9 3.79688 9H5.20312C5.43516 9 5.625 9.18984 5.625 9.42188V10.8281C5.625 11.0602 5.43516 11.25 5.20312 11.25H3.79688C3.56484 11.25 3.375 11.0602 3.375 10.8281V9.42188ZM3.375 13.9219C3.375 13.6898 3.56484 13.5 3.79688 13.5H5.20312C5.43516 13.5 5.625 13.6898 5.625 13.9219V15.3281C5.625 15.5602 5.43516 15.75 5.20312 15.75H3.79688C3.56484 15.75 3.375 15.5602 3.375 15.3281V13.9219ZM15.1875 2.25H13.5V0.5625C13.5 0.253125 13.2469 0 12.9375 0H11.8125C11.5031 0 11.25 0.253125 11.25 0.5625V2.25H6.75V0.5625C6.75 0.253125 6.49687 0 6.1875 0H5.0625C4.75312 0 4.5 0.253125 4.5 0.5625V2.25H2.8125C1.88086 2.25 1.125 3.00586 1.125 3.9375V5.625H16.875V3.9375C16.875 3.00586 16.1191 2.25 15.1875 2.25Z"
                                            fill="white" />
                                    </svg>
                                    <span> {{ formatDate($item->publish_date) }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="content-text d-flex align-items-center gap-2 text-muted"><span><svg
                                            width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 9C11.4855 9 13.5 6.98555 13.5 4.5C13.5 2.01445 11.4855 0 9 0C6.51445 0 4.5 2.01445 4.5 4.5C4.5 6.98555 6.51445 9 9 9ZM12.15 10.125H11.5629C10.7824 10.4836 9.91406 10.6875 9 10.6875C8.08594 10.6875 7.22109 10.4836 6.43711 10.125H5.85C3.24141 10.125 1.125 12.2414 1.125 14.85V16.3125C1.125 17.2441 1.88086 18 2.8125 18H15.1875C16.1191 18 16.875 17.2441 16.875 16.3125V14.85C16.875 12.2414 14.7586 10.125 12.15 10.125Z"
                                                fill="#00786E" />
                                        </svg>
                                    </span>
                                    <span>
                                        Admin
                                    </span>
                                </div>

                                <hr class="mt-12">
                                <h5 class="title-four mb-12">
                                    <a href="{{ route('news-and-updates-details', $item->slug) }}   "
                                        class="">{{ truncateText($item->news_title, 38) }}</a>
                                </h5>
                                <p class="content-text mb-3">{{ truncateText($item->short_des, 35) }}
                                </p>
                                <a href="{{ route('news-and-updates-details', $item->slug) }}"
                                    class="btn-primary btn-common">View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>
            <div class=" text-center mt-60">
                {{ $news->links() }}
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
