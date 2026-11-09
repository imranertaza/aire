@php
    $s = $block['settings'] ?? $block;
    $limit = (int) ($s['limit'] ?? ($block['limit'] ?? 3));
    $limit = ($limit > 0 && $limit <= 12) ? $limit : 3;
    $columnsDesktop = $s['columns_desktop'] ?? ($block['columns_desktop'] ?? 'col-lg-4');
    $columnsMobile = $s['columns_mobile'] ?? ($block['columns_mobile'] ?? 'col-12');
    $categoryId = !empty($s['category_id']) ? (int) $s['category_id'] : null;

    // Visibility
    $vis = $s['visibility'] ?? ($block['visibility'] ?? []);
    $hideClasses = [];
    if (!empty($vis['hideOnMobile']) || !empty($s['hideMobile'])) $hideClasses[] = 'd-none d-md-block';
    if (!empty($vis['hideOnTablet']) || !empty($s['hideTablet'])) $hideClasses[] = 'd-md-none d-lg-block';
    if (!empty($vis['hideOnDesktop']) || !empty($s['hideDesktop'])) $hideClasses[] = 'd-lg-none';
    $hideClassStr = implode(' ', $hideClasses);

    // Margins
    $styles = [];
    $mt = $s['marginTop'] ?? ($block['marginTop'] ?? '');
    $mb = $s['marginBottom'] ?? ($block['marginBottom'] ?? '');
    if ($mt) $styles[] = "margin-top: {$mt};";
    if ($mb) $styles[] = "margin-bottom: {$mb};";
    $styleAttr = !empty($styles) ? 'style="' . implode(' ', $styles) . '"' : '';

    $customClass = $s['custom_class'] ?? ($block['customClass'] ?? '');
    $customId = $s['custom_id'] ?? ($block['customId'] ?? '');
    $customIdAttr = !empty($customId) ? 'id="' . e($customId) . '"' : '';

    // Query published news
    $query = \App\Models\News::with(['categories', 'creator'])->published();
    if ($categoryId) {
        $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('news_categories.id', $categoryId);
        });
    }
    $newsItems = $query->latest('id')->take($limit)->get();
@endphp

<div {!! $customIdAttr !!} class="builder-block-news {{ $hideClassStr }} {{ $customClass }}" {!! $styleAttr !!}>
    @if ($newsItems->isNotEmpty())
        <div class="row g-4">
            @foreach ($newsItems as $news)
                @php
                    $catName = $news->categories->first()->category_name ?? 'Editorial';
                    $imgUrl = !empty($news->f_image)
                        ? getImageUrl($news->f_image, 600, 380)
                        : (!empty($news->image)
                            ? getImageUrl($news->image, 600, 380)
                            : theme_asset('img/og-share-banner.jpg'));
                    $pubDate = !empty($news->publish_date)
                        ? \Carbon\Carbon::parse($news->publish_date)->format('M d, Y')
                        : ($news->created_at ? $news->created_at->format('M d, Y') : 'Recent');
                    $author = $news->creator->name ?? 'AIRE Team';
                    $title = $news->news_title ?: ($news->title ?? 'Untitled Article');
                    $excerpt = \Illuminate\Support\Str::limit(strip_tags($news->short_des ?: ($news->description ?? '')), 110);
                    $url = !empty($news->slug) ? route('news.show', $news->slug) : '#';
                @endphp
                <div class="{{ $columnsMobile }} col-md-6 {{ $columnsDesktop }} d-flex">
                    <article class="card h-100 border-0 rounded-4 shadow-sm overflow-hidden d-flex flex-column w-100 transition-hover" style="transition: transform 0.25s ease, box-shadow 0.25s ease;">
                        <a href="{{ $url }}" class="d-block position-relative overflow-hidden" style="aspect-ratio: 16/10; background: #f1f5f9;">
                            <img src="{{ $imgUrl }}" alt="{{ e($title) }}" class="w-100 h-100 object-fit-cover" loading="lazy" style="transition: transform 0.35s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <span class="position-absolute top-0 start-0 m-3 badge rounded-pill bg-white text-primary px-3 py-2 shadow-sm font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                {{ $catName }}
                            </span>
                        </a>
                        <div class="card-body p-4 d-flex flex-column flex-grow-1">
                            <div class="d-flex align-items-center gap-2 text-muted small mb-2" style="font-size: 0.8rem;">
                                <i class="bi bi-calendar3"></i>
                                <span>{{ $pubDate }}</span>
                                <span>&bull;</span>
                                <span>{{ $author }}</span>
                            </div>
                            <h5 class="card-title font-weight-bold mb-2" style="font-size: 1.1rem; line-height: 1.4;">
                                <a href="{{ $url }}" class="text-dark text-decoration-none hover-primary">
                                    {{ $title }}
                                </a>
                            </h5>
                            <p class="card-text text-muted small flex-grow-1 mb-3" style="line-height: 1.6;">
                                {{ $excerpt }}
                            </p>
                            <div class="pt-2 border-top d-flex align-items-center justify-content-between mt-auto">
                                <a href="{{ $url }}" class="btn btn-sm btn-link p-0 text-primary text-decoration-none font-weight-semibold d-inline-flex align-items-center gap-1">
                                    <span>Read Article</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5 text-muted bg-light rounded-4 border">
            <i class="fas fa-newspaper fa-2x mb-2 text-secondary opacity-50"></i>
            <p class="small mb-0">No published news articles found.</p>
        </div>
    @endif
</div>

