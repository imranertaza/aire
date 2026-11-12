@php
    $s = $block['settings'] ?? $block;
    $source = $s['source'] ?? ($block['source'] ?? 'latest');
    $categoryId = !empty($s['category_id'])
        ? (int) $s['category_id']
        : (!empty($block['category_id'])
            ? (int) $block['category_id']
            : null);
    $limit = (int) ($s['limit'] ?? ($block['limit'] ?? 4));
    $limit = $limit > 0 && $limit <= 24 ? $limit : 4;
    $columnsDesktop = $s['columns_desktop'] ?? ($block['columns_desktop'] ?? 'col-lg-3');
    $columnsMobile = $s['columns_mobile'] ?? ($block['columns_mobile'] ?? 'col-6');

    // Visibility
    $vis = $s['visibility'] ?? ($block['visibility'] ?? []);
    $hideClasses = [];
    if (!empty($vis['hideOnMobile']) || !empty($s['hideMobile'])) {
        $hideClasses[] = 'd-none d-md-block';
    }
    if (!empty($vis['hideOnTablet']) || !empty($s['hideTablet'])) {
        $hideClasses[] = 'd-md-none d-lg-block';
    }
    if (!empty($vis['hideOnDesktop']) || !empty($s['hideDesktop'])) {
        $hideClasses[] = 'd-lg-none';
    }
    $hideClassStr = implode(' ', $hideClasses);

    // Margins
    $styles = [];
    $mt = $s['marginTop'] ?? ($block['marginTop'] ?? '');
    $mb = $s['marginBottom'] ?? ($block['marginBottom'] ?? '');
    if ($mt) {
        $styles[] = "margin-top: {$mt};";
    }
    if ($mb) {
        $styles[] = "margin-bottom: {$mb};";
    }
    $styleAttr = !empty($styles) ? 'style="' . implode(' ', $styles) . '"' : '';

    $customClass = $s['custom_class'] ?? ($block['customClass'] ?? '');
    $customId = $s['custom_id'] ?? ($block['customId'] ?? '');
    $customIdAttr = !empty($customId) ? 'id="' . e($customId) . '"' : '';

    // Query active products based on block source configuration
    $productsQuery = \App\Models\Product::withCatalogRelations()->active();
    if ($source === 'featured') {
        $productsQuery->where('featured', 1);
    } elseif ($source === 'category' && $categoryId) {
        $productsQuery->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('product_categories.id', $categoryId);
        });
    } else {
        $productsQuery->latest();
    }
    $products = $productsQuery->take($limit)->get();

@endphp
@once
    <style>
        .builder-block-products .product-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            padding: 16px;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .builder-block-products .product-card:hover {
            transform: translateY(-4px);
            border-color: #e2e8f0;
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
        }

        .builder-block-products .product-card__badge-wrapper {
            position: absolute;
            top: 18px;
            left: 18px;
            z-index: 10;
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .builder-block-products .product-card__badge-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 10px;
            border-radius: 9999px;
            color: #ffffff !important;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        }

        .builder-block-products .product-card__labels.position-absolute {
            position: absolute;
            top: 18px;
            right: -60px;
            opacity: 0;
            visibility: hidden;
            transition: right 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease, visibility 0.25s;
            z-index: 90;
        }

        .builder-block-products .product-card:hover .product-card__labels.position-absolute {
            right: 18px !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .builder-block-products .product-card__labels button {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid var(--color-primary, #0095DA);
            background: #ffffff;
            padding: 0;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease;
        }

        .builder-block-products .product-card__labels button:hover,
        .builder-block-products .product-card__labels button.active {
            background: var(--color-primary, #0095DA);
        }

        .builder-block-products .product-card__labels button:hover svg path,
        .builder-block-products .product-card__labels button.active svg path {
            fill: #ffffff;
        }

        .builder-block-products .product-card__labels button.btn-toggle-favorite.active {
            background: #dc3545;
            border-color: #dc3545;
        }

        .builder-block-products .product-card__image-wrapper {
            width: 100%;
            height: 220px;
            display: block;
            overflow: hidden;
            border-radius: 14px;
            margin-bottom: 1rem;
            position: relative;
            background-color: #f8fafc;
        }

        .builder-block-products .product-card__image-wrapper a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .builder-block-products .product-card__image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            transition: transform 0.35s ease;
        }

        .builder-block-products .product-card:hover .product-card__image {
            transform: scale(1.05);
        }

        .builder-block-products .product-card__title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.01em;
            margin-bottom: 4px;
            line-height: 1.3;
            min-height: 42px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .builder-block-products .product-card__title a {
            color: #0f172a;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .builder-block-products .product-card__title a:hover {
            color: var(--color-primary, #0095DA);
        }

        .builder-block-products .product-card__category {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
            line-height: 1.35;
            min-height: 30px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .builder-block-products .product-card__actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
            margin-bottom: 0.25rem;
            padding-top: 8px;
        }

        .builder-block-products .product-card__price {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
        }

        .builder-block-products .product-card__price.pre {
            text-decoration: line-through;
            font-size: 11.5px;
            font-weight: 500;
            color: #94a3b8;
            margin-bottom: 2px;
        }

        .builder-block-products .product-card__btn-buy {
            background: var(--color-primary, #0095DA);
            color: #ffffff !important;
            font-size: 12px;
            font-weight: 700;
            padding: 8px 22px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .builder-block-products .product-card__btn-buy:hover {
            background: var(--color-primary-hover, #047cc2);
            transform: translateY(-1px);
        }

        .builder-block-products .product-card__btn-learn {
            color: var(--color-primary, #0095DA);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .builder-block-products .product-card__btn-learn:hover {
            color: var(--color-primary-hover, #047cc2);
            text-decoration: underline;
        }

        @media (max-width: 767.98px) {
            .builder-block-products .product-card__labels.position-absolute {
                right: 12px !important;
                opacity: 1 !important;
                visibility: visible !important;
            }
        }

        @media (max-width: 575.98px) {
            .builder-block-products .product-card {
                padding: 12px;
                border-radius: 16px;
            }

            .builder-block-products .product-card__image-wrapper {
                height: 150px;
                margin-bottom: 0.75rem;
                border-radius: 10px;
            }

            .builder-block-products .product-card__title {
                font-size: 13.5px;
                min-height: 36px;
            }

            .builder-block-products .product-card__category {
                font-size: 10px;
                min-height: 24px;
                margin-bottom: 0.75rem;
            }

            .builder-block-products .product-card__btn-buy {
                padding: 6px 14px;
                font-size: 11px;
            }

            .builder-block-products .product-card__price {
                font-size: 13.5px;
            }
        }
    </style>
@endonce


<div {!! $customIdAttr !!} class="builder-block-products {{ $hideClassStr }} {{ $customClass }}"
    {!! $styleAttr !!}>
    @if ($products->isNotEmpty())
        <div class="row g-3 g-md-4">
            @foreach ($products as $product)
                <div class="{{ $columnsMobile }} col-md-6 {{ $columnsDesktop }} d-flex">
                    <div class="w-100 h-100">
                        @include('themes.default.partials.product_card', [
                            'product' => $product,
                            'subtitle' =>
                                $product->description?->description ?:
                                ($product->categories?->first()?->category_name ?:
                                'ENTERPRISE FILTRATION'),
                            'showCategoryBadge' => true,
                            'categoryName' => $product->categories?->first()?->category_name ?? 'Home',
                            'categoryBgColor' => $product->categories?->first()?->bg_color ?: '#1e1b4b',
                        ])
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-4 text-muted bg-light rounded-4 border">
            <i class="fas fa-box-open fa-2x mb-2 text-secondary opacity-50"></i>
            <p class="small mb-0">No active products found matching the criteria.</p>
        </div>
    @endif
</div>
