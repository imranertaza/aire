@php
    $productDesc = $product->description ?? null;
    $brandName = $product->brand?->name ?? ($settings['brand_name'] ?? 'AIRE');
    $sku = $product->product_code ?? ($product->model ?? 'AIRE-' . $product->id);
    $currentPrice = (float) ($product->special && $product->special->price > 0 ? $product->special->price : ($product->price ?? 0));
    $inStock = ($product->quantity ?? 0) > 0;
    $currency = 'USD';
    $productImgUrl = getImageUrl($product->main_image ?: ($product->image ?: null), null, null, ['raw' => true]);
    $canonicalUrl = route('products.detail', $product->slug ?? $product->id);
    $primaryCat = $product->categories->first() ?? null;

    $productSchema = [
        '@context' => 'https://schema.org/',
        '@type' => 'Product',
        'name' => $product->name ?? '',
        'image' => [$productImgUrl],
        'description' => !empty($productDesc?->meta_description)
            ? $productDesc->meta_description
            : (!empty($productDesc?->description)
                ? \Illuminate\Support\Str::limit(strip_tags($productDesc->description), 200)
                : 'Explore ' . ($product->name ?? 'AIRE product') . ' - advanced clean air solutions and technology.'),
        'sku' => $sku,
        'mpn' => $product->model ?? $sku,
        'brand' => [
            '@type' => 'Brand',
            'name' => $brandName,
        ],
        'offers' => [
            '@type' => 'Offer',
            'url' => $canonicalUrl,
            'priceCurrency' => $currency,
            'price' => number_format($currentPrice, 2, '.', ''),
            'priceValidUntil' => date('Y-12-31', strtotime('+1 year')),
            'itemCondition' => 'https://schema.org/NewCondition',
            'availability' => $inStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'seller' => [
                '@type' => 'Organization',
                'name' => $brandName,
            ],
        ],
    ];

    if (!empty($product->average_feedback) && $product->average_feedback > 0) {
        $productSchema['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => (string) $product->average_feedback,
            'reviewCount' => (string) max(1, $product->reviews_count ?? 1),
        ];
    }

    $breadcrumbItems = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => route('home'),
        ],
    ];

    $pos = 2;
    if ($primaryCat) {
        if ($primaryCat->parent) {
            $breadcrumbItems[] = [
                '@type' => 'ListItem',
                'position' => $pos++,
                'name' => $primaryCat->parent->category_name,
                'item' => route('category.show', $primaryCat->parent->slug ?? $primaryCat->parent->id),
            ];
        }
        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => $pos++,
            'name' => $primaryCat->category_name,
            'item' => route('category.show', $primaryCat->slug ?? $primaryCat->id),
        ];
    }

    $breadcrumbItems[] = [
        '@type' => 'ListItem',
        'position' => $pos,
        'name' => $product->name ?? '',
        'item' => $canonicalUrl,
    ];

    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbItems,
    ];

    $faqSchema = null;
    if (!empty($product->faqs) && $product->faqs->count() > 0) {
        $faqEntities = [];
        foreach ($product->faqs as $faq) {
            $faqEntities[] = [
                '@type' => 'Question',
                'name' => $faq->question ?? '',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq->answer ?? '',
                ],
            ];
        }
        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqEntities,
        ];
    }
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode($productSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@if ($faqSchema)
<script type="application/ld+json">
{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endif
@endpush
