@php
    $isModel = $item instanceof \App\Models\Product;
    if ($isModel) {
        $product = $item;
    } else {
        // Fallback for mock array item
        $product = (object) [
            'id' => $item['id'] ?? null,
            'name' => $item['name'] ?? '',
            'slug' => $item['slug'] ?? ($item['id'] ?? ''),
            'price' => $item['price'] ?? 0,
            'special_price' => $item['special_price'] ?? null,
            'quantity' => 10,
            'main_image' => $item['image'] ?? null,
            'categories' => collect([
                (object) [
                    'category_name' => $item['badge'] ?? ($item['category'] ?? 'Home'),
                    'bg_color' => '#1e1b4b',
                ]
            ]),
            'description' => (object) [
                'description' => $item['category'] ?? 'ENTERPRISE FILTRATION',
            ],
        ];
    }
    $firstCat = $product->categories ? $product->categories->first() : null;
    $catName = $isModel ? ($firstCat?->category_name ?? 'Home') : ($item['badge'] ?? 'Home');
    $catBg = $isModel ? ($firstCat?->bg_color ?: '#1e1b4b') : '#1e1b4b';
    $sub = $isModel ? ($product->description?->description ?: ($firstCat?->category_name ?: 'ENTERPRISE FILTRATION')) : ($item['category'] ?? 'ENTERPRISE FILTRATION');
@endphp

@include('themes.default.partials.product_card', [
    'product' => $product,
    'showCategoryBadge' => true,
    'categoryName' => $catName,
    'categoryBgColor' => $catBg,
    'subtitle' => $sub,
])
