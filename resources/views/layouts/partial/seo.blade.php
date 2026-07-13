<meta name="title" content="@yield('title', $settings['meta_title'] ?? config('app.name'))">
<meta name="description" content="@yield('meta_description', $settings['meta_description'] ?? '')">
<meta name="keywords" content="@yield('meta_keywords', $settings['meta_keyword'] ?? '')">

<meta name="author" content="{{ $settings['meta_author'] ?? '' }}">
<meta name="news_keywords" content="@yield('meta_keywords', $settings['meta_news_keywords'] ?? '')">

<!-- Open Graph -->
<meta property="og:type" content="{{ $settings['og_type'] ?? 'website' }}">
<meta property="og:title" content="@yield('og_title', $settings['og_title'] ?? '')">
<meta property="og:description" content="{{ $settings['og_description'] ?? '' }}">
<meta property="og:image" content="@yield('og_image', getImageUrl($settings['og_image']) ?? '')">
<meta property="og:image:width" content="{{ $settings['og_image_width'] ?? '' }}">
<meta property="og:image:height" content="{{ $settings['og_image_height'] ?? '' }}">
<meta property="og:url" content="{{ url()->current() }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="{{ $settings['twitter_card'] ?? 'summary' }}">
<meta name="twitter:title" content="{{ $settings['twitter_title'] ?? '' }}">
<meta name="twitter:description" content="{{ $settings['twitter_description'] ?? '' }}">
<meta name="twitter:image" content="{{ getImageUrl($settings['twitter_image'] ?? '') }}">
<meta name="twitter:domain" content="{{ $settings['twitter_domain'] ?? request()->getHost() }}">

<!-- Brand -->
<meta name="brand_name" content="{{ $settings['brand_name'] ?? '' }}">
