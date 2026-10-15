@extends('themes.default.layouts.master')

@section('title', 'News & Editorial Hub | ' . config('app.name', 'Aire'))
@section('meta_description',
    'Discover official press releases, clean air innovations, environmental whitepapers, and
    corporate updates from AIRE Industries.')
@section('canonical_url', route('news.index'))
@section('og_type', 'website')
@section('og_image', theme_asset('img/og-share-banner.jpg'))

@push('styles')
    <link
        href="{{ theme_asset('css/news.css') }}?v={{ file_exists(public_path('themes/default/assets/css/news.css')) ? filemtime(public_path('themes/default/assets/css/news.css')) : time() }}"
        rel="stylesheet">
@endpush

@section('content')
    <main class="container main-container py-3">
        <!-- Unified Single Editorial Header Bar -->
        <div class="newsroom-header-bar mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pb-3 border-bottom">
                <div>
                    <nav class="news-breadcrumb-inline" aria-label="breadcrumb">
                        <ol class="news-breadcrumb mb-1">
                            <li><a href="{{ route('home') }}"><i class="bi bi-house-door me-1"></i>Home</a></li>
                            <li class="news-breadcrumb-separator"><i class="bi bi-chevron-right"></i></li>
                            <li class="news-breadcrumb-current" aria-current="page">Newsroom</li>
                        </ol>
                    </nav>
                    <h1 class="newsroom-page-title mb-0">Newsroom</h1>
                </div>

                <form action="{{ route('news.index') }}" method="GET" class="newsroom-search-box">
                    @if (!empty($selectedCategory))
                        <input type="hidden" name="category" value="{{ $selectedCategory }}">
                    @endif
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="q" value="{{ $searchQuery ?? '' }}"
                        placeholder="Search releases & insights..." class="search-input">
                </form>
            </div>

            <!-- Category Pills Filter Track -->
            <div class="newsroom-pills-bar pt-3">
                <div class="newsroom-pills-track">
                    <a href="{{ route('news.index') }}"
                        class="newsroom-pill {{ empty($selectedCategory) ? 'active' : '' }}">
                        <span>All Articles</span>
                    </a>
                    @if (isset($newsCategories) && $newsCategories->count() > 0)
                        @foreach ($newsCategories as $cat)
                            <a href="{{ route('news.index', ['category' => $cat->category_name]) }}"
                                class="newsroom-pill {{ $selectedCategory == $cat->category_name || $selectedCategory == $cat->id ? 'active' : '' }}">
                                <span>{{ $cat->category_name }}</span>
                                @if (isset($cat->news_count))
                                    <span class="newsroom-pill-count">({{ $cat->news_count }})</span>
                                @endif
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Featured Story Spotlight (Shown on page 1 when not filtering/searching) -->
        @if (empty($searchQuery) &&
                empty($selectedCategory) &&
                isset($featuredNews) &&
                $featuredNews->count() > 0 &&
                $newsList->currentPage() == 1)
            @php
                $leadStory = $featuredNews->first();
                $leadImg = !empty($leadStory->f_image)
                    ? getImageUrl($leadStory->f_image, 1200, 675)
                    : (!empty($leadStory->image)
                        ? getImageUrl($leadStory->image, 1200, 675)
                        : theme_asset('img/og-share-banner.jpg'));
                $leadCat = $leadStory->categories->first()->category_name ?? 'Featured';
                $leadDate = !empty($leadStory->publish_date)
                    ? \Carbon\Carbon::parse($leadStory->publish_date)->format('F d, Y')
                    : $leadStory->created_at->format('F d, Y');
                $leadText = strip_tags($leadStory->description ?? '');
                $leadWords = str_word_count($leadText);
                $leadReadTime = max(1, (int) ceil($leadWords / 200));
            @endphp
            <section class="newsroom-spotlight">
                <div class="newsroom-spotlight-inner">
                    <div class="newsroom-spotlight-media">
                        <img src="{{ $leadImg }}" alt="{{ $leadStory->news_title }}" class="newsroom-spotlight-img"
                            loading="eager">
                        <div class="newsroom-spotlight-media-overlay"></div>
                    </div>
                    <div class="newsroom-spotlight-content">
                        <div class="newsroom-spotlight-tag-row">
                            <span class="newsroom-lead-badge"><i class="bi bi-lightning-charge-fill me-1"></i>
                                {{ $leadCat }}</span>
                            <span class="newsroom-lead-date"><i class="bi bi-calendar3 me-1"></i> {{ $leadDate }}
                                &bull; {{ $leadReadTime }} min read</span>
                        </div>
                        <h2 class="newsroom-spotlight-title">
                            <a href="{{ route('news.show', $leadStory->slug) }}">
                                {{ $leadStory->news_title }}
                            </a>
                        </h2>
                        <p class="newsroom-spotlight-desc">
                            {{ \Illuminate\Support\Str::limit(strip_tags($leadStory->short_des ?: $leadStory->description), 180) }}
                        </p>
                        <a href="{{ route('news.show', $leadStory->slug) }}" class="newsroom-spotlight-link">
                            <span>Read Full Release</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </section>
        @endif

        <!-- Active Filter Indicator (Shown only when filtering or searching) -->
        @if (!empty($selectedCategory) || !empty($searchQuery))
            <div class="newsroom-section-header">
                <h3 class="newsroom-section-title">
                    @if (!empty($selectedCategory))
                        Category: <span class="text-primary">{{ $selectedCategory }}</span>
                    @elseif (!empty($searchQuery))
                        Search Results for: <span class="text-primary">"{{ $searchQuery }}"</span>
                    @endif
                </h3>
                <span class="newsroom-section-count">{{ $newsList->total() }} Articles</span>
            </div>
        @endif

        <!-- 3-Column Articles Grid -->
        @if ($newsList && $newsList->count() > 0)
            <div class="newsroom-grid">
                @foreach ($newsList as $item)
                    @php
                        $catName = $item->categories->first()->category_name ?? 'Press Release';
                        $cardImg = !empty($item->f_image)
                            ? getImageUrl($item->f_image, 600, 375)
                            : (!empty($item->image)
                                ? getImageUrl($item->image, 600, 375)
                                : theme_asset('img/og-share-banner.jpg'));
                        $pubDate = !empty($item->publish_date)
                            ? \Carbon\Carbon::parse($item->publish_date)->format('M d, Y')
                            : $item->created_at->format('M d, Y');
                        $contentStr = strip_tags($item->description ?? '');
                        $wordCount = str_word_count($contentStr);
                        $readTime = max(1, (int) ceil($wordCount / 200));
                        $authorName = $item->creator->name ?? 'AIRE Editorial';
                    @endphp
                    <article class="newsroom-card">
                        <a href="{{ route('news.show', $item->slug) }}" class="newsroom-card-img-wrap">
                            <img src="{{ $cardImg }}" alt="{{ $item->news_title }}" class="newsroom-card-img"
                                loading="lazy">
                            <span class="newsroom-card-badge">{{ $catName }}</span>
                        </a>
                        <div class="newsroom-card-body">
                            <div class="newsroom-card-meta">
                                <i class="bi bi-calendar3"></i>
                                <span>{{ $pubDate }}</span>
                                <span>&bull;</span>
                                <span>{{ $readTime }} min read</span>
                            </div>
                            <h4 class="newsroom-card-title">
                                <a href="{{ route('news.show', $item->slug) }}">{{ $item->news_title }}</a>
                            </h4>
                            <p class="newsroom-card-desc">
                                {{ \Illuminate\Support\Str::limit(strip_tags($item->short_des ?: $item->description), 115) }}
                            </p>
                            <div class="newsroom-card-footer">
                                <span class="newsroom-author-tag">{{ $authorName }}</span>
                                <a href="{{ route('news.show', $item->slug) }}" class="newsroom-read-btn">
                                    <span>Read</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="newsroom-pagination-wrap">
                {{ $newsList->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5 bg-white rounded-4 border my-4 shadow-sm">
                <div class="fs-1 text-muted mb-2"><i class="bi bi-newspaper"></i></div>
                <h4 class="fs-18 fw-bold text-dark">No Articles Found</h4>
                <p class="fs-14 text-muted mb-3">No releases match your selected criteria. Try browsing all categories.</p>
                <a href="{{ route('news.index') }}" class="btn btn-primary rounded-pill px-4 btn-sm">
                    View All Publications
                </a>
            </div>
        @endif

        <!-- Bottom Editorial CTA Banner -->
        <section class="newsroom-bottom-banner">
            <div class="newsroom-bottom-banner-text">
                <h3>Stay Connected with AIRE Media</h3>
                <p>Access official press materials, request executive interviews, or get updates on our international air
                    quality initiatives.</p>
            </div>
            <div class="newsroom-bottom-banner-actions">
                <a href="{{ route('contact') }}" class="newsroom-btn-primary">
                    <i class="bi bi-envelope me-1"></i> Contact Media Relations
                </a>
                <a href="{{ route('products.index') }}" class="newsroom-btn-outline">
                    Explore Technology Solutions <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </section>
    </main>
@endsection
