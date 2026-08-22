@extends('layouts.master')

@section('title', 'Home')
@section('content')

    {{-- Banner section start --}}
    <section class="banner">
        <div class="swiper mySwiperBg">
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    @if ($slide->enabled)
                        <div class="swiper-slide justify-content-start">
                            <img draggable="false" class="" fetchpriority="high"
                                src="{{ getImageCacheUrl($slide->image, 1400, 617, 'webp') }}" alt="{{ $slide->title }}">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="banner-content container z-3">
            <div class="swiper mySwiper d-flex">
                <div class="swiper-wrapper w-75 banner-main-content-area">
                    @foreach ($slides as $slide)
                        @if ($slide->enabled)
                            <div class="swiper-slide">
                                <div class="slider-content">
                                    <h1 class="title-three">{{ $slide->title }}</h1>
                                    @if (!empty($slide->link))
                                        <a href="{{ $slide->link }}" aria-label="{{ $slide->title }}"
                                            class="read-more mt-16 btn-1 slower">Read More <span
                                                class="visually-hidden">{{ $slide->title }}</span></a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div
                    class="position-fixed w-25 z-3 h-100 pagination-button-area d-flex flex-column justify-content-center align-items-center">
                    <div class="d-flex gap-2 mb-md-2">
                        <div class="custom-swiper-button-prev swiper-button-prev">
                            <svg width="36" height="35" viewBox="0 0 36 35" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="-0.5" y="0.5" width="35" height="34" rx="17"
                                    transform="matrix(-1 0 0 1 35 0)" stroke="white" />
                                <path
                                    d="M21.548 12.0802L20.487 11.0202L14.708 16.7972C14.6149 16.8898 14.5409 16.9999 14.4905 17.1211C14.44 17.2424 14.4141 17.3724 14.4141 17.5037C14.4141 17.6351 14.44 17.7651 14.4905 17.8863C14.5409 18.0076 14.6149 18.1177 14.708 18.2102L20.487 23.9902L21.547 22.9302L16.123 17.5052L21.548 12.0802Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <div class="custom-swiper-button-next swiper-button-next">
                            <svg width="36" height="35" viewBox="0 0 36 35" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="0.5" y="0.5" width="35" height="34" rx="17" stroke="white" />
                                <path
                                    d="M14.452 12.0802L15.513 11.0202L21.292 16.7972C21.3851 16.8898 21.4591 16.9999 21.5095 17.1211C21.56 17.2424 21.5859 17.3724 21.5859 17.5037C21.5859 17.6351 21.56 17.7651 21.5095 17.8863C21.4591 18.0076 21.3851 18.1177 21.292 18.2102L15.513 23.9902L14.453 22.9302L19.877 17.5052L14.452 12.0802Z"
                                    fill="white" />
                            </svg>
                        </div>
                    </div>
                    <div class="swiper-pagination custom-swiper-pagination mt-0"></div>

                </div>
            </div>
        </div>
    </section>
    {{-- Banner section end --}}

    {{-- Categories Section Start --}}
    <section class="category-section py-100 bg-white">
        <div class="container">
            <div class="d-flex justify-content-between mb-30">
                <h2 class="title-two">Shop by Category</h2>
            </div>

            <div class="row g-4">
                @foreach ($productCategories as $category)
                    <div class="col-md-3 col-sm-6 text-center">
                        <div class="category-card p-4 border rounded shadow-sm hover-fill-horizontal h-100">
                            <!-- Dynamic Icon Rendering Start -->
                            <div class="icon-wrapper mb-3 d-flex align-items-center justify-content-center"
                                style="font-size: 40px; color: var(--common-color); height: 60px;">
                                @if (strpos($category->icon_class, '<svg') !== false)
                                    {!! $category->icon_class !!}
                                @elseif($category->icon_class)
                                    <i class="{{ $category->icon_class }}"></i>
                                @elseif($category->icon)
                                    {!! $category->icon->code !!}
                                @else
                                    <i class="fa fa-box"></i>
                                @endif
                            </div>
                            <!-- Dynamic Icon Rendering End -->

                            <h5 class="title-four m-0">{{ $category->category_name }}</h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- Categories Section End --}}

    {{-- Top News Section Start --}}
    <section class="top-news-section py-100 bg-custom-gray">
        <div class="container">
            <div class="d-flex justify-content-between mb-30">
                <h2 class="title-two">Top News</h2>
                <a href="{{ route('news-and-updates') }}" class="btn-1 btn-common btn  text-white btn-primary slower">View
                    all</a>
            </div>
            <div class="row px-md-0 row-cols-xl-2 justify-content-center justify-content-between g-4">
                <div class="">
                    @php
                        $firstTopNews = $topNews->first();
                    @endphp
                    <div class="top-news-card highlight card-smooth">
                        <img src="{{ getImageCacheUrl($firstTopNews->f_image, 548, 340, 'webp') }}" alt=""
                            class="card-img-top" alt="news image">
                        <a href="{{ route('news-and-updates-details', $firstTopNews->slug) }}" class="">
                            <div class="card-body">
                                <h5 class="title-four mb-2 p-0">
                                    {{ $firstTopNews->news_title }}
                                </h5>
                                <p class="content-text-sm">
                                    {{ truncateText($firstTopNews->short_des, 120) }}
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="">
                    <div class="row px-md-0 row-cols-sm-2 justify-content-start g-4">
                        @foreach ($topNews as $key => $news)
                            @if ($key == 0)
                                @continue
                            @endif
                            <div class="">
                                <div class="top-news-card hover-fill-horizontal">
                                    <img src="{{ getImageCacheUrl($news->f_image, 262, 145) }}" class="card-img-top"
                                        alt="news image">
                                    <a href="{{ route('news-and-updates-details', $news->slug) }}" class="">
                                        <div class="card-body">
                                            <h5 class="title-four p-0">
                                                {{ truncateText($news->news_title, 40) }}
                                            </h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Top News Section End --}}
    {{-- Game News Section Start  --}}
    @if (0)
        <section class="bg-primary py-100">
            <div class="container">
                <div class="d-flex justify-content-between mb-30">
                    <h2 class="title-two text-white">Game News</h2>
                    <a href="{{ route('news-and-updates') }}"
                        class="btn-common btn btn-default text-primary bg-white  btn-1 slower border-0">View
                        all</a>
                </div>
                <div class="gaming-news-slider position-relative">
                    <div class="swiper myGamingSwiper">
                        <div class="swiper-wrapper mb-5">
                            @foreach ($gamesNews as $news)
                                <div class="swiper-slide">
                                    <a href="{{ route('news-and-updates-details', $news->slug) }}">
                                        <div class="gaming-news-card card-smooth hover-fill-horizontal fill-white-muted">
                                            <img src="{{ getImageCacheUrl($news->f_image, 362, 320) }}"
                                                class="card-img-top" alt="news image">
                                            <div class="card-body">
                                                <h5 class="title-four min-h-38">
                                                    {{ truncateText($news->news_title, 45) }}
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="right-0">
                            <div class="d-flex gap-2 mb-md-2 justify-content-end">
                                <div class="custom-swiper-button-gaming-prev swiper-button-prev">
                                    <svg width="36" height="35" viewBox="0 0 36 35" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="-0.5" y="0.5" width="35" height="34" rx="17"
                                            transform="matrix(-1 0 0 1 35 0)" fill="white" />
                                        <rect x="-0.5" y="0.5" width="35" height="34" rx="17"
                                            transform="matrix(-1 0 0 1 35 0)" stroke="white" />
                                        <path
                                            d="M21.548 12.0802L20.487 11.0202L14.708 16.7972C14.6149 16.8898 14.5409 16.9999 14.4905 17.1211C14.44 17.2424 14.4141 17.3724 14.4141 17.5037C14.4141 17.6351 14.44 17.7651 14.4905 17.8863C14.5409 18.0076 14.6149 18.1177 14.708 18.2102L20.487 23.9902L21.547 22.9302L16.123 17.5052L21.548 12.0802Z"
                                            fill="#00786E" />
                                    </svg>

                                </div>
                                <div class="custom-swiper-button-gaming-next swiper-button-next">
                                    <svg width="36" height="35" viewBox="0 0 36 35" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="0.5" width="35" height="34" rx="17"
                                            fill="white" />
                                        <rect x="0.5" y="0.5" width="35" height="34" rx="17"
                                            stroke="white" />
                                        <path
                                            d="M14.452 12.0802L15.513 11.0202L21.292 16.7972C21.3851 16.8898 21.4591 16.9999 21.5095 17.1211C21.56 17.2424 21.5859 17.3724 21.5859 17.5037C21.5859 17.6351 21.56 17.7651 21.5095 17.8863C21.4591 18.0076 21.3851 18.1177 21.292 18.2102L15.513 23.9902L14.453 22.9302L19.877 17.5052L14.452 12.0802Z"
                                            fill="#00786E" />
                                    </svg>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{-- Game News Section End --}}

    {{-- Running Event Section Start --}}
    <section class="py-100 bg-white-muted">
        <div class="container">
            <div class="d-flex justify-content-between mb-30">
                <h2 class="title-two">Events</h2>
                <a href="{{ route('running-events') }}" class="btn-common btn btn-primary  btn-1 slower">View all</a>
            </div>
            <div class="gaming-news-slider position-relative">
                <div class="swiper myRunningEventSwiper">
                    <div class="swiper-wrapper mb-5">

                        @forelse ($runningEvent as $item)
                            <div class="swiper-slide">
                                <a href="{{ route('event-details', $item->slug) }}">
                                    <div class="gaming-news-card running-event-card card-smooth ">
                                        <img src="{{ getImageCacheUrl($item->featured_image, 262, 230) }}"
                                            class="card-img-top" alt="news image">
                                        <div class="card-body">
                                            <h5 class="title-four min-h-38">
                                                {{ truncateText($item->title, 40) }}
                                            </h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                    <div class="right-0">
                        <div class="d-flex gap-2 mb-md-2 justify-content-end">
                            <div class="custom-swiper-button-running-prev swiper-button-prev">
                                <svg width="36" height="35" viewBox="0 0 36 35" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="-0.5" y="0.5" width="35" height="34" rx="17"
                                        transform="matrix(-1 0 0 1 35 0)" stroke="#00786E" />
                                    <path
                                        d="M21.548 12.0802L20.487 11.0202L14.708 16.7972C14.6149 16.8898 14.5409 16.9999 14.4905 17.1211C14.44 17.2424 14.4141 17.3724 14.4141 17.5037C14.4141 17.6351 14.44 17.7651 14.4905 17.8863C14.5409 18.0076 14.6149 18.1177 14.708 18.2102L20.487 23.9902L21.547 22.9302L16.123 17.5052L21.548 12.0802Z"
                                        fill="#00786E" />
                                </svg>
                            </div>
                            <div class="custom-swiper-button-running-next swiper-button-next">
                                <svg width="36" height="35" viewBox="0 0 36 35" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="0.5" width="35" height="34" rx="17"
                                        stroke="#00786E" />
                                    <path
                                        d="M14.452 12.0802L15.513 11.0202L21.292 16.7972C21.3851 16.8898 21.4591 16.9999 21.5095 17.1211C21.56 17.2424 21.5859 17.3724 21.5859 17.5037C21.5859 17.6351 21.56 17.7651 21.5095 17.8863C21.4591 18.0076 21.3851 18.1177 21.292 18.2102L15.513 23.9902L14.453 22.9302L19.877 17.5052L14.452 12.0802Z"
                                        fill="#00786E" />
                                </svg>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Running Event Section End --}}
    {{-- Upcoming Event Section Start --}}
    @if (0)
        <section class="bg-primary py-100">
            <div class="container">
                <div class="d-flex justify-content-between mb-30">
                    <h2 class="title-two text-white">Upcoming Event</h2>
                    <a href="{{ route('upcoming-events') }}"
                        class="btn-common btn btn-default text-primary bg-white  btn-1 slower border-0">View
                        all</a>
                </div>
                <div class="gaming-news-slider position-relative">
                    <div class="swiper myUpcomingEventSwiper">
                        <div class="swiper-wrapper mb-5">
                            @forelse ($upcomingEvent as $item)
                                <div class="swiper-slide ">
                                    <div class="upcoming-event-card card-smooth">
                                        <a href="{{ route('event-details', $item->slug) }}"
                                            aria-label="Upcoming Event 1">
                                            <img src="{{ getImageCacheUrl($item->featured_image, 252, 515) }}"
                                                class="card-img-top img-thumbnail" alt="{{ $item->title }}">
                                        </a>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                        <div class="right-0">
                            <div class="d-flex gap-2 mb-md-2 justify-content-end">
                                <div class="custom-swiper-button-upcoming-prev swiper-button-prev">
                                    <svg width="36" height="35" viewBox="0 0 36 35" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="-0.5" y="0.5" width="35" height="34" rx="17"
                                            transform="matrix(-1 0 0 1 35 0)" fill="white" />
                                        <rect x="-0.5" y="0.5" width="35" height="34" rx="17"
                                            transform="matrix(-1 0 0 1 35 0)" stroke="white" />
                                        <path
                                            d="M21.548 12.0802L20.487 11.0202L14.708 16.7972C14.6149 16.8898 14.5409 16.9999 14.4905 17.1211C14.44 17.2424 14.4141 17.3724 14.4141 17.5037C14.4141 17.6351 14.44 17.7651 14.4905 17.8863C14.5409 18.0076 14.6149 18.1177 14.708 18.2102L20.487 23.9902L21.547 22.9302L16.123 17.5052L21.548 12.0802Z"
                                            fill="#00786E" />
                                    </svg>

                                </div>
                                <div class="custom-swiper-button-upcoming-next swiper-button-next">
                                    <svg width="36" height="35" viewBox="0 0 36 35" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="0.5" width="35" height="34" rx="17"
                                            fill="white" />
                                        <rect x="0.5" y="0.5" width="35" height="34" rx="17"
                                            stroke="white" />
                                        <path
                                            d="M14.452 12.0802L15.513 11.0202L21.292 16.7972C21.3851 16.8898 21.4591 16.9999 21.5095 17.1211C21.56 17.2424 21.5859 17.3724 21.5859 17.5037C21.5859 17.6351 21.56 17.7651 21.5095 17.8863C21.4591 18.0076 21.3851 18.1177 21.292 18.2102L15.513 23.9902L14.453 22.9302L19.877 17.5052L14.452 12.0802Z"
                                            fill="#00786E" />
                                    </svg>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Upcoming Event Section End --}}
    {{-- Our mission and vision section start --}}
    @if (0)
        <section class="py-100 bg-white-muted">
            <div class="container">
                <div class="row row-cols-md-2 align-items-center">
                    <div class="text-center mb-md-0 mb-4">
                        <img class="img-fluid rounded-2"
                            src="{{ getImageCacheUrl($about_mission_vision->data['image'], 476, 375) }}"
                            alt="Mission and Vision">
                    </div>
                    <div class="">
                        <h3 class="title-two mb-3">{{ $about_mission_vision->data['title'] }}</h3>
                        {!! $about_mission_vision->data['home_content'] !!}
                        <a href="{{ route('page.details', 'about-us') }}"
                            class="btn-primary btn-common btn-1 slower">Read
                            More</a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Our mission and vision section End --}}
    {{-- Our Latest Blog Section Start --}}
    <section class="bg-custom-gray py-100 ">
        <div class="container">
            <div class="d-flex justify-content-between mb-30">
                <h2 class="title-two">Our Latest Blog</h2>
                <a href="{{ route('blogs') }}" class="btn-common btn btn-primary btn-1 slower">View all</a>
            </div>
            <div class="gaming-news-slider position-relative">
                <div class="swiper myLatestBlogSwiper">
                    <div class="swiper-wrapper mb-5">
                        @forelse ($blogs as $blog)
                            <div class="swiper-slide">
                                <div class="gaming-news-card latest-blog-card card-smooth">
                                    <img src="{{ getImageCacheUrl($blog->f_image, 357, 225) }}" class="card-img-top"
                                        alt="news image">
                                    <div class="card-body">
                                        <p class="content-text d-flex align-items-center"><svg width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17 5.49844L12.9965 5.49845V4.50195C12.9965 4.2257 12.7727 4.00195 12.4965 4.00195C12.2203 4.00195 11.9965 4.2257 11.9965 4.50195V5.4982H7.9965V4.50195C7.9965 4.2257 7.77275 4.00195 7.4965 4.00195C7.22025 4.00195 6.9965 4.2257 6.9965 4.50195V5.4982H3C2.44775 5.4982 2 5.94595 2 6.4982V18.9982C2 19.5504 2.44775 19.9982 3 19.9982H17C17.5522 19.9982 18 19.5504 18 18.9982V6.4982C18 5.94619 17.5522 5.49844 17 5.49844ZM17 18.9982H3V6.4982H6.9965V7.00195C6.9965 7.27819 7.22025 7.50195 7.4965 7.50195C7.77275 7.50195 7.9965 7.27819 7.9965 7.00195V6.49845H11.9965V7.0022C11.9965 7.27845 12.2203 7.5022 12.4965 7.5022C12.7727 7.5022 12.9965 7.27845 12.9965 7.0022V6.49845H17V18.9982ZM13.5 11.9984H14.5C14.776 11.9984 15 11.7744 15 11.4984V10.4984C15 10.2224 14.776 9.99844 14.5 9.99844H13.5C13.224 9.99844 13 10.2224 13 10.4984V11.4984C13 11.7744 13.224 11.9984 13.5 11.9984ZM13.5 15.9982H14.5C14.776 15.9982 15 15.7744 15 15.4982V14.4982C15 14.2222 14.776 13.9982 14.5 13.9982H13.5C13.224 13.9982 13 14.2222 13 14.4982V15.4982C13 15.7747 13.224 15.9982 13.5 15.9982ZM10.5 13.9982H9.5C9.224 13.9982 9 14.2222 9 14.4982V15.4982C9 15.7744 9.224 15.9982 9.5 15.9982H10.5C10.776 15.9982 11 15.7744 11 15.4982V14.4982C11 14.2224 10.776 13.9982 10.5 13.9982ZM10.5 9.99844H9.5C9.224 9.99844 9 10.2224 9 10.4984V11.4984C9 11.7744 9.224 11.9984 9.5 11.9984H10.5C10.776 11.9984 11 11.7744 11 11.4984V10.4984C11 10.2222 10.776 9.99844 10.5 9.99844ZM6.5 9.99844H5.5C5.224 9.99844 5 10.2224 5 10.4984V11.4984C5 11.7744 5.224 11.9984 5.5 11.9984H6.5C6.776 11.9984 7 11.7744 7 11.4984V10.4984C7 10.2222 6.776 9.99844 6.5 9.99844ZM6.5 13.9982H5.5C5.224 13.9982 5 14.2222 5 14.4982V15.4982C5 15.7744 5.224 15.9982 5.5 15.9982H6.5C6.776 15.9982 7 15.7744 7 15.4982V14.4982C7 14.2224 6.776 13.9982 6.5 13.9982Z"
                                                    fill="black" />
                                            </svg>
                                            {{ formatDate($blog->publish_date) }}
                                        </p>
                                        <h5 class="title-four mb-3 blog-title">
                                            <a href="{{ route('blogs-details', $blog->slug) }}"
                                                class="">{{ truncateText($blog->title, 78) }}</a>
                                        </h5>
                                        <a href="{{ route('blogs-details', $blog->slug) }}"
                                            class="btn-primary btn-common">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse

                    </div>
                    <div class="right-0">
                        <div class="d-flex gap-2 mb-md-2 justify-content-end">
                            <div class="custom-swiper-button-latest-prev swiper-button-prev">
                                <svg width="36" height="35" viewBox="0 0 36 35" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="-0.5" y="0.5" width="35" height="34" rx="17"
                                        transform="matrix(-1 0 0 1 35 0)" stroke="#00786E" />
                                    <path
                                        d="M21.548 12.0802L20.487 11.0202L14.708 16.7972C14.6149 16.8898 14.5409 16.9999 14.4905 17.1211C14.44 17.2424 14.4141 17.3724 14.4141 17.5037C14.4141 17.6351 14.44 17.7651 14.4905 17.8863C14.5409 18.0076 14.6149 18.1177 14.708 18.2102L20.487 23.9902L21.547 22.9302L16.123 17.5052L21.548 12.0802Z"
                                        fill="#00786E" />
                                </svg>
                            </div>
                            <div class="custom-swiper-button-latest-next swiper-button-next">
                                <svg width="36" height="35" viewBox="0 0 36 35" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="0.5" width="35" height="34" rx="17"
                                        stroke="#00786E" />
                                    <path
                                        d="M14.452 12.0802L15.513 11.0202L21.292 16.7972C21.3851 16.8898 21.4591 16.9999 21.5095 17.1211C21.56 17.2424 21.5859 17.3724 21.5859 17.5037C21.5859 17.6351 21.56 17.7651 21.5095 17.8863C21.4591 18.0076 21.3851 18.1177 21.292 18.2102L15.513 23.9902L14.453 22.9302L19.877 17.5052L14.452 12.0802Z"
                                        fill="#00786E" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <button aria-label="Back to top" id="backToTop" class="back-to-top">
        ↑
    </button>
    @push('styles')
        <style>
            .blog-title {
                height: 42.2px;
                overflow: hidden;
            }

            /* Back To top */
            .back-to-top {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 999;
                background-color: var(--common-color);
                border: 2px solid #fff;
                /* brand red */
                color: #fff;
                border-radius: 50%;
                width: 48px;
                height: 48px;
                font-size: 20px;
                cursor: pointer;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                transition: opacity 0.3s ease, transform 0.3s ease;
                opacity: 0;
                pointer-events: none;
            }

            .back-to-top.show {
                opacity: 1;
                pointer-events: auto;
                border: 1px solid #fff;

            }

            .back-to-top:hover {
                background-color: var(--common-color);
            }

            .icon-wrapper svg {
                width: 48px;
                height: 48px;
                fill: var(--common-color);
            }
        </style>
    @endpush
    @push('scripts')
        <script module>
            document.addEventListener("DOMContentLoaded", () => {
                const backToTop = document.getElementById("backToTop");

                // Show button when scrolling down
                window.addEventListener("scroll", () => {
                    if (window.scrollY > 300) {
                        backToTop.classList.add("show");
                    } else {
                        backToTop.classList.remove("show");
                    }
                });

                // Smooth scroll to top
                backToTop.addEventListener("click", () => {
                    window.scrollTo({
                        top: 0,
                        behavior: "smooth", // 👈 this makes it smooth
                    });
                });
            });
        </script>
    @endpush
    {{-- Our Latest Blog Section End --}}
@endsection
