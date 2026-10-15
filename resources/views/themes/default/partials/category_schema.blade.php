@php
    $catName = $category->category_name ?? ($category->name ?? 'Products');
    $catDesc = $category->description ?? ($settings['site_description'] ?? 'Explore high performance clean air solutions.');
    $catUrl = !empty($category->slug) ? route('category.show', $category->slug) : url()->current();
    $catImg = !empty($category->image) ? getImageUrl($category->image, null, null, ['raw' => true]) : theme_asset('img/og-share-banner.jpg');

    $collectionSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => $catName,
        'description' => strip_tags($catDesc),
        'url' => $catUrl,
        'image' => $catImg,
    ];

    $breadcrumbItems = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => route('home'),
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Products',
            'item' => route('products.index'),
        ],
    ];

    if (isset($category) && $category) {
        if (!empty($category->parent)) {
            $breadcrumbItems[] = [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $category->parent->category_name ?? $category->parent->name,
                'item' => route('category.show', $category->parent->slug ?? $category->parent->id),
            ];
            $breadcrumbItems[] = [
                '@type' => 'ListItem',
                'position' => 4,
                'name' => $catName,
                'item' => $catUrl,
            ];
        } else {
            $breadcrumbItems[] = [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $catName,
                'item' => $catUrl,
            ];
        }
    }

    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbItems,
    ];
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode($collectionSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush
