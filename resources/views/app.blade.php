<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#9e1f16">

        @php
            // Dirender langsung di Blade (bukan lewat Vue <Head>) supaya crawler share-link
            // media sosial (Facebook/WhatsApp/Twitter/LinkedIn) yang tidak menjalankan JS tetap
            // melihat meta tag yang benar — SSR Inertia tidak aktif di deployment ini (lihat
            // architecture.md), jadi konten yang dirender Vue client-side tidak pernah sampai
            // ke crawler tersebut kalau tidak ditaruh di sini.
            $__seo = $page['props']['seo'] ?? [];
            $__site = $page['props']['site'] ?? [];
            $__title = $__seo['title'] ?? 'Layanan Legalitas Bisnis | FastTrack';
            $__description = $__seo['description'] ?? 'FastTrack Legal Services adalah partner tepercaya untuk pendirian perusahaan, perizinan usaha, dan legalitas bisnis Anda di Indonesia — profesional, cepat, dan terpercaya.';
            $__defaultImage = $__site['default_image'] ?? url('/images/og/og-image.png');
            $__image = $__seo['image'] ?? $__defaultImage;
            $__isDefaultImage = $__image === $__defaultImage;
            $__canonical = $__seo['canonical'] ?? ($__site['current_url'] ?? url()->current());
            $__type = $__seo['type'] ?? 'website';
            $__robots = $__seo['robots'] ?? 'index, follow, max-image-preview:large';
            $__siteName = $__site['name'] ?? 'FastTrack';
            $__siteLocale = $__site['locale'] ?? 'id_ID';
        @endphp

        <title inertia>{{ $__title }}</title>
        <meta name="description" content="{{ $__description }}">
        <meta name="robots" content="{{ $__robots }}">
        <meta name="author" content="{{ $__siteName }}">
        <link rel="canonical" href="{{ $__canonical }}">

        <meta property="og:type" content="{{ $__type }}">
        <meta property="og:site_name" content="{{ $__siteName }}">
        <meta property="og:locale" content="{{ $__siteLocale }}">
        <meta property="og:title" content="{{ $__title }}">
        <meta property="og:description" content="{{ $__description }}">
        <meta property="og:url" content="{{ $__canonical }}">
        <meta property="og:image" content="{{ $__image }}">
        <meta property="og:image:secure_url" content="{{ $__image }}">
        <meta property="og:image:alt" content="{{ $__title }}">
        @if ($__isDefaultImage)
            <meta property="og:image:width" content="1200">
            <meta property="og:image:height" content="630">
            <meta property="og:image:type" content="image/png">
        @endif

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@fasttrack_legal">
        <meta name="twitter:title" content="{{ $__title }}">
        <meta name="twitter:description" content="{{ $__description }}">
        <meta name="twitter:image" content="{{ $__image }}">
        <meta name="twitter:image:alt" content="{{ $__title }}">

        <link rel="icon" type="image/svg+xml" href="/favicon.ico">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
