@extends('themes.default.layouts.master')

@php
    $pageTitle = !empty($news->meta_title)
        ? $news->meta_title
        : $news->news_title . ' | News & Media | ' . config('app.name', 'Aire');
    $pageDesc = !empty($news->meta_description)
        ? $news->meta_description
        : (!empty($news->short_des)
            ? $news->short_des
            : \Illuminate\Support\Str::limit(strip_tags($news->description ?? ''), 160));
    $pageKeywords = $news->meta_keyword ?? '';
    $newsImg = !empty($news->f_image)
        ? getImageUrl($news->f_image)
        : (!empty($news->image)
            ? getImageUrl($news->image)
            : theme_asset('img/og-share-banner.jpg'));
    $canonicalUrl = route('news.show', $news->slug ?? $news->id);
    $primaryCategory = $news->categories->first();
    $pubDateObj = !empty($news->publish_date) ? \Carbon\Carbon::parse($news->publish_date) : $news->created_at;
    $pubDateFormatted = $pubDateObj ? $pubDateObj->format('F d, Y') : 'Recent';
    $wordCount = str_word_count(strip_tags($news->description ?? ''));
    $readMinutes = max(1, ceil($wordCount / 200));
@endphp

@section('title', $pageTitle)
@section('meta_description', $pageDesc)
@section('meta_keywords', $pageKeywords)
@section('og_image', $newsImg)
@section('canonical_url', $canonicalUrl)

@push('styles')
    <link
        href="{{ theme_asset('css/news.css') }}?v={{ file_exists(public_path('themes/default/assets/css/news.css')) ? filemtime(public_path('themes/default/assets/css/news.css')) : time() }}"
        rel="stylesheet">
    <link
        href="{{ theme_asset('css/about.css') }}?v={{ file_exists(public_path('themes/default/assets/css/about.css')) ? filemtime(public_path('themes/default/assets/css/about.css')) : time() }}"
        rel="stylesheet">
@endpush

@section('content')
    <main class="container main-container py-3">
        <!-- Breadcrumb -->
        <nav class="news-breadcrumb-wrap" aria-label="breadcrumb">
            <ol class="news-breadcrumb">
                <li><a href="{{ route('home') }}"><i class="bi bi-house-door me-1"></i>Home</a></li>
                <li class="news-breadcrumb-separator"><i class="bi bi-chevron-right"></i></li>
                <li><a href="{{ route('about') }}#news">News &amp; Media</a></li>
                @if ($primaryCategory)
                    <li class="news-breadcrumb-separator"><i class="bi bi-chevron-right"></i></li>
                    <li><span>{{ $primaryCategory->category_name }}</span></li>
                @endif
                <li class="news-breadcrumb-separator"><i class="bi bi-chevron-right"></i></li>
                <li class="news-breadcrumb-current" aria-current="page">{{ $news->news_title }}</li>
            </ol>
        </nav>

        <div class="row g-4 g-xl-5">
            <!-- Main Article Content Column -->
            <article class="col-lg-8">
                <!-- Article Header -->
                <header class="news-article-header">
                    <div class="news-header-badge-row">
                        @if ($primaryCategory)
                            <span class="news-category-badge">
                                <i class="bi bi-tag-fill"></i> {{ $primaryCategory->category_name }}
                            </span>
                        @else
                            <span class="news-category-badge">
                                <i class="bi bi-newspaper"></i> Press Release
                            </span>
                        @endif
                    </div>

                    <h1 class="news-title">{{ $news->news_title }}</h1>

                    @if (!empty($news->short_des))
                        <p class="news-lead-text">{{ $news->short_des }}</p>
                    @endif

                    <!-- Meta Bar with Reading Info & Share Buttons -->
                    <div class="news-meta-bar">
                        <div class="news-meta-left">
                            <span class="news-meta-item">
                                <i class="bi bi-calendar3"></i>
                                <time
                                    datetime="{{ $pubDateObj ? $pubDateObj->toIso8601String() : '' }}">{{ $pubDateFormatted }}</time>
                            </span>
                            <span class="news-meta-item">
                                <i class="bi bi-clock"></i>
                                <span>{{ $readMinutes }} min read</span>
                            </span>
                            <span class="news-meta-item">
                                <i class="bi bi-shield-check"></i>
                                <span>Official AIRE Release</span>
                            </span>
                        </div>

                        <!-- Quick Social Share -->
                        <div class="news-share-wrap">
                            <span class="news-share-label">Share:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($canonicalUrl) }}"
                                target="_blank" rel="noopener noreferrer" class="news-share-btn" title="Share on Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($canonicalUrl) }}&text={{ urlencode($news->news_title) }}"
                                target="_blank" rel="noopener noreferrer" class="news-share-btn"
                                title="Share on X (Twitter)">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($canonicalUrl) }}"
                                target="_blank" rel="noopener noreferrer" class="news-share-btn" title="Share on LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($news->news_title . ' ' . $canonicalUrl) }}"
                                target="_blank" rel="noopener noreferrer" class="news-share-btn" title="Share on WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            <button type="button" class="news-share-btn btn-copy-link" title="Copy Link"
                                onclick="copyNewsLink(this, '{{ $canonicalUrl }}')">
                                <i class="bi bi-link-45deg fs-6"></i>
                            </button>
                        </div>
                    </div>
                </header>

                <!-- Featured Banner Image -->
                @if (!empty($news->f_image) || !empty($news->image))
                    <div class="news-featured-banner">
                        <img src="{{ !empty($news->f_image) ? getImageCacheUrl($news->f_image, 1000, 520, 'webp') : getImageUrl($news->image) }}"
                            alt="{{ $news->alt_name ?: $news->news_title }}" class="news-featured-img">
                        @if (!empty($news->alt_name))
                            <div class="news-banner-caption">
                                <i class="bi bi-camera me-1"></i> {{ $news->alt_name }}
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Main HTML Content -->
                <div class="news-article-content">
                    @if (!empty($news->description))
                        {!! $news->description !!}
                    @else
                        <p>{{ $news->short_des }}</p>
                    @endif
                </div>

                <!-- Tags & Footer Actions -->
                <div class="news-footer-tags-wrap">
                    <div class="news-tags-list">
                        @if ($news->categories && $news->categories->count() > 0)
                            @foreach ($news->categories as $cat)
                                <a href="{{ route('about') }}#news" class="news-tag-pill">
                                    #{{ $cat->category_name }}
                                </a>
                            @endforeach
                        @else
                            <span class="news-tag-pill">#ClimateInnovation</span>
                            <span class="news-tag-pill">#CleanAir</span>
                            <span class="news-tag-pill">#AIREGlobal</span>
                        @endif
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('about') }}#news" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            <i class="bi bi-arrow-left me-1"></i> All News &amp; Media
                        </a>
                    </div>
                </div>
            </article>

            <!-- Right Sticky Sidebar -->
            <aside class="col-lg-4">
                <div class="sticky-sidebar">
                    <!-- Press & Media Contact Box -->
                    <div class="news-sidebar-card">
                        <h3 class="news-sidebar-title">
                            <i class="bi bi-megaphone"></i> Media Relations
                        </h3>
                        <p class="fs-13 text-muted mb-3">
                            Are you a journalist or industry analyst? Contact the AIRE Corporate Communications team for
                            interview requests and official press assets.
                        </p>
                        <a href="{{ route('contact') }}" class="btn btn-primary w-100 rounded-3 py-2 fs-13 fw-semibold">
                            <i class="bi bi-envelope me-1"></i> Media Inquiry
                        </a>
                    </div>

                    <!-- News Categories Widget -->
                    @if (isset($newsCategories) && $newsCategories->count() > 0)
                        <div class="news-sidebar-card">
                            <h3 class="news-sidebar-title">
                                <i class="bi bi-folder2-open"></i> Categories
                            </h3>
                            <nav class="news-cat-nav">
                                @foreach ($newsCategories as $cat)
                                    <a href="{{ route('about') }}#news"
                                        class="news-cat-item {{ $primaryCategory && $primaryCategory->id === $cat->id ? 'active' : '' }}">
                                        <span>{{ $cat->category_name }}</span>
                                        <span class="news-cat-count">{{ $cat->news_count ?? 0 }}</span>
                                    </a>
                                @endforeach
                            </nav>
                        </div>
                    @endif

                    <!-- Recent / Trending Stories Widget -->
                    @if (isset($relatedNews) && $relatedNews->count() > 0)
                        <div class="news-sidebar-card">
                            <h3 class="news-sidebar-title">
                                <i class="bi bi-fire"></i> Recent Stories
                            </h3>
                            <div class="news-mini-list">
                                @foreach ($relatedNews as $rel)
                                    @php
                                        $relDate = !empty($rel->publish_date)
                                            ? \Carbon\Carbon::parse($rel->publish_date)->format('M d, Y')
                                            : $rel->created_at->format('M d, Y');
                                        $relImg = !empty($rel->f_image)
                                            ? getImageCacheUrl($rel->f_image, 140, 100, 'webp')
                                            : null;
                                    @endphp
                                    <a href="{{ route('news.show', $rel->slug) }}" class="news-mini-item">
                                        <div class="news-mini-thumb">
                                            @if ($relImg)
                                                <img src="{{ $relImg }}" alt="{{ $rel->news_title }}"
                                                    loading="lazy">
                                            @else
                                                <div
                                                    class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-primary">
                                                    <i class="bi bi-newspaper"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="news-mini-info">
                                            <h4 class="news-mini-title">{{ $rel->news_title }}</h4>
                                            <span class="news-mini-date"><i
                                                    class="bi bi-calendar3 me-1"></i>{{ $relDate }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Quick Solutions Promo -->
                    <div class="news-sidebar-card bg-light border-0"
                        style="background: linear-gradient(135deg, #f0f7ff 0%, #e0f2fe 100%) !important;">
                        <div class="d-flex align-items-center gap-2 text-primary fw-bold fs-12 text-uppercase mb-2">
                            <i class="bi bi-wind"></i> AIRE Technology
                        </div>
                        <h4 class="fs-15 fw-bold text-dark mb-2">Pure Air. Engineered for Tomorrow.</h4>
                        <p class="fs-13 text-muted mb-3">Discover how our energy-efficient ductless systems deliver
                            precision temperature control and ultra-clean air.</p>
                        <a href="{{ route('products.index') }}"
                            class="btn btn-outline-primary w-100 rounded-3 py-2 fs-13 fw-semibold">
                            Explore Systems <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </aside>
        </div>

        <!-- More Stories Section (Bottom Grid) -->
        @if (isset($relatedNews) && $relatedNews->count() > 0)
            <section class="news-related-section">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h2 class="news-related-title">More from AIRE News &amp; Media</h2>
                        <p class="news-related-subtitle">Read other recent articles, research papers, and corporate
                            announcements.</p>
                    </div>
                    <a href="{{ route('about') }}#news"
                        class="btn btn-outline-primary btn-sm rounded-pill px-3 d-none d-md-inline-flex align-items-center">
                        View All <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="about-news-grid">
                    @foreach ($relatedNews as $item)
                        @php
                            $catName = $item->categories->first()->category_name ?? 'Press Release';
                            $cardImg = !empty($item->f_image)
                                ? getImageCacheUrl($item->f_image, 400, 250, 'webp')
                                : (!empty($item->image)
                                    ? getImageUrl($item->image)
                                    : null);
                            $pubDate = !empty($item->publish_date)
                                ? \Carbon\Carbon::parse($item->publish_date)->format('M d, Y')
                                : $item->created_at->format('M d, Y');
                        @endphp
                        <article class="about-news-card">
                            <a href="{{ route('news.show', $item->slug) }}" class="about-news-img-wrap">
                                @if ($cardImg)
                                    <img src="{{ $cardImg }}" alt="{{ $item->news_title }}" class="about-news-img"
                                        loading="lazy">
                                @else
                                    <div class="about-news-img-placeholder">
                                        <i class="bi bi-newspaper"></i>
                                    </div>
                                @endif
                                <span class="about-news-badge">{{ $catName }}</span>
                            </a>
                            <div class="about-news-body">
                                <div class="about-news-meta">
                                    <i class="bi bi-calendar3"></i>
                                    <span>{{ $pubDate }}</span>
                                </div>
                                <h4 class="about-news-title">
                                    <a href="{{ route('news.show', $item->slug) }}">{{ $item->news_title }}</a>
                                </h4>
                                <p class="about-news-desc">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->short_des ?: $item->description), 110) }}
                                </p>
                                <div class="about-news-footer">
                                    <a href="{{ route('news.show', $item->slug) }}" class="about-hero-link">
                                        Read Details <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </main>
@endsection

@push('scripts')
    <script>
        function copyNewsLink(btn, url) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(function() {
                    showCopyFeedback(btn);
                }).catch(function() {
                    fallbackCopy(btn, url);
                });
            } else {
                fallbackCopy(btn, url);
            }
        }

        function fallbackCopy(btn, url) {
            var input = document.createElement('textarea');
            input.value = url;
            document.body.appendChild(input);
            input.select();
            try {
                document.execCommand('copy');
                showCopyFeedback(btn);
            } catch (err) {
                console.error('Copy failed:', err);
            }
            document.body.removeChild(input);
        }

        function showCopyFeedback(btn) {
            var originalHtml = btn.innerHTML;
            btn.classList.add('copied');
            btn.innerHTML = '<i class="bi bi-check2 fs-6"></i>';
            setTimeout(function() {
                btn.classList.remove('copied');
                btn.innerHTML = originalHtml;
            }, 2000);
        }
    </script>

    <!-- Structured Data (NewsArticle Schema for Google Search) -->
    <script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $news->news_title,
    'image' => [$newsImg],
    'datePublished' => $pubDateObj ? $pubDateObj->toIso8601String() : date('c'),
    'dateModified' => $news->updated_at ? $news->updated_at->toIso8601String() : ($pubDateObj ? $pubDateObj->toIso8601String() : date('c')),
    'description' => $pageDesc,
    'author' => [
        '@type' => 'Organization',
        'name' => 'AIRE Corporate Communications',
        'url' => route('home'),
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => config('app.name', 'Aire'),
        'logo' => [
            '@type' => 'ImageObject',
            'url' => theme_asset('img/logo-dark.png'),
        ],
    ],
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => $canonicalUrl,
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush
