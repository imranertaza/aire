@php
    $seoTitle = trim($__env->yieldContent('title')) ?: ($settings['meta_title'] ?? config('app.name', 'Aire'));
    $seoDescription = trim($__env->yieldContent('meta_description')) ?: ($settings['meta_description'] ?? 'Aire delivers cutting-edge indoor air quality solutions for residential, commercial, healthcare, and industrial environments.');
    $seoKeywords = trim($__env->yieldContent('meta_keywords')) ?: ($settings['meta_keyword'] ?? '');
    $seoOgTitle = trim($__env->yieldContent('og_title')) ?: $seoTitle;
    $seoOgType = trim($__env->yieldContent('og_type')) ?: ($settings['og_type'] ?? 'website');
    $seoCanonicalUrl = trim($__env->yieldContent('canonical_url')) ?: url()->current();
    $seoOgImage = trim($__env->yieldContent('og_image')) ?: (!empty($settings['og_image']) ? getImageUrl($settings['og_image']) : theme_asset('img/og-share-banner.jpg'));
    $seoOgImageWidth = trim($__env->yieldContent('og_image_width')) ?: ($settings['og_image_width'] ?? '1200');
    $seoOgImageHeight = trim($__env->yieldContent('og_image_height')) ?: ($settings['og_image_height'] ?? '630');
    $seoOgImageAlt = trim($__env->yieldContent('og_image_alt')) ?: $seoTitle;
    $seoTwitterCard = trim($__env->yieldContent('twitter_card')) ?: ($settings['twitter_card'] ?? 'summary_large_image');
    $seoTwitterImage = !empty($settings['twitter_image']) ? getImageUrl($settings['twitter_image']) : $seoOgImage;
@endphp

<meta name="title" content="{{ $seoTitle }}">
<meta name="description" content="{{ $seoDescription }}">
@if (!empty($seoKeywords))
<meta name="keywords" content="{{ $seoKeywords }}">
@endif
<meta name="author" content="{{ $settings['meta_author'] ?? ($settings['store_name'] ?? config('app.name', 'Aire')) }}">
@if (!empty($settings['meta_news_keywords']))
<meta name="news_keywords" content="{{ $settings['meta_news_keywords'] }}">
@endif

<!-- Open Graph / Facebook / LinkedIn / Discord -->
<meta property="og:site_name" content="{{ $settings['store_name'] ?? ($settings['meta_title'] ?? config('app.name', 'Aire')) }}">
<meta property="og:type" content="{{ $seoOgType }}">
<meta property="og:title" content="{{ $seoOgTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:url" content="{{ $seoCanonicalUrl }}">
<meta property="og:image" content="{{ $seoOgImage }}">
<meta property="og:image:secure_url" content="{{ $seoOgImage }}">
<meta property="og:image:width" content="{{ $seoOgImageWidth }}">
<meta property="og:image:height" content="{{ $seoOgImageHeight }}">
<meta property="og:image:alt" content="{{ $seoOgImageAlt }}">
<meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">

<!-- Twitter / X Cards -->
<meta name="twitter:card" content="{{ $seoTwitterCard }}">
<meta name="twitter:site" content="{{ $settings['twitter_handle'] ?? '@AireIAQ' }}">
<meta name="twitter:creator" content="{{ $settings['twitter_handle'] ?? '@AireIAQ' }}">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoTwitterImage }}">
<meta name="twitter:image:alt" content="{{ $seoOgImageAlt }}">
<meta name="twitter:domain" content="{{ $settings['twitter_domain'] ?? request()->getHost() }}">

<!-- Webmaster & Site Verification -->
@if (!empty($settings['google_site_verification']))
<meta name="google-site-verification" content="{{ $settings['google_site_verification'] }}">
@endif

<!-- Brand -->
<meta name="brand_name" content="{{ $settings['brand_name'] ?? ($settings['store_name'] ?? config('app.name', 'Aire')) }}">

<!-- Google Analytics (GA4 / GTM) -->
@if (!empty($settings['google_analytics_id']))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_analytics_id'] }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ $settings['google_analytics_id'] }}');
</script>
@endif
