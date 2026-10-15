@php
    $brandName = $settings['brand_name'] ?? config('app.name', 'AIRE');
    $siteUrl = url('/');
    $logoUrl = !empty($settings['store_logo'])
        ? getImageUrl($settings['store_logo'], null, null, ['raw' => true])
        : theme_asset('img/logo.png');
    $siteDesc =
        $settings['site_description'] ??
        ($settings['footer_description'] ??
            'Technological mastery in every breath. Leading the future of high-purity air environments.');

    $socialLinks = array_filter([
        $settings['facebook_url'] ?? null,
        $settings['twitter_url'] ?? null,
        $settings['linkedin_url'] ?? null,
        $settings['youtube_url'] ?? null,
        $settings['instagram_url'] ?? null,
    ]);

    $orgSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $brandName,
        'url' => $siteUrl,
        'logo' => [
            '@type' => 'ImageObject',
            'url' => $logoUrl,
        ],
        'description' => $siteDesc,
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'contactType' => 'customer service',
            'telephone' => $settings['contact_phone'] ?? ($settings['store_phone'] ?? '+1-800-AIRE-AIR'),
            'email' => $settings['contact_email'] ?? ($settings['store_email'] ?? 'support@aire.com'),
            'areaServed' => 'US',
            'availableLanguage' => ['English'],
        ],
    ];

    if (!empty($socialLinks)) {
        $orgSchema['sameAs'] = array_values($socialLinks);
    }

    $websiteSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => $brandName,
        'url' => $siteUrl,
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => [
                '@type' => 'EntryPoint',
                'urlTemplate' => route('products.filter') . '?q={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ];
@endphp

@push('head')
    <script type="application/ld+json">
{!! json_encode($orgSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
    <script type="application/ld+json">
{!! json_encode($websiteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush
