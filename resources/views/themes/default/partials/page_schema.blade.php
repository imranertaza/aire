@php
    $canonicalUrl = $canonicalUrl ?? (!empty($page->slug) ? route('page.show', $page->slug) : url()->current());
    $plainText = $plainText ?? strip_tags($page->page_description ?? '');
    $lastUpdatedIso = $lastUpdatedIso ?? ($page->updated_at ? $page->updated_at->toIso8601String() : now()->toIso8601String());
    $pageTitle = $pageTitle ?? ($page->page_title ?? config('app.name', 'Aire'));
    $shortDes = $shortDes ?? ($page->short_des ?? \Illuminate\Support\Str::limit($plainText, 160));
    $featuredImg = !empty($page->f_image) ? getImageUrl($page->f_image, null, null, ['raw' => true]) : theme_asset('img/og-share-banner.jpg');
    $categoryName = $categoryName ?? ($page->breadcrumb ?? 'Information');
    $logoUrl = !empty($settings['store_logo']) ? getImageUrl($settings['store_logo'], null, null, ['raw' => true]) : theme_asset('img/logo.png');

    $articleSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => $canonicalUrl,
        ],
        'headline' => $pageTitle,
        'description' => $shortDes,
        'image' => $featuredImg,
        'datePublished' => $page->created_at ? $page->created_at->toIso8601String() : $lastUpdatedIso,
        'dateModified' => $lastUpdatedIso,
        'publisher' => [
            '@type' => 'Organization',
            'name' => config('app.name', 'Aire'),
            'url' => url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $logoUrl,
            ],
        ],
    ];

    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => route('home'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $categoryName,
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $pageTitle,
                'item' => $canonicalUrl,
            ],
        ],
    ];
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush
