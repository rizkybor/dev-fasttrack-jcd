<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppHeader from '@/Components/AppHeader.vue';
import AppFooter from '@/Components/AppFooter.vue';

const page = usePage();
const seo = computed(() => page.props.seo || {});
const site = computed(() => page.props.site || {});
const currentUrl = computed(() => seo.value.canonical || site.value.current_url || page.props.ziggy?.location || '');
const pageTitle = computed(() => seo.value.title || 'Layanan Legalitas Bisnis | FastTrack');
const pageDescription = computed(() => seo.value.description || 'Legal Services - Partner Terbaik Perusahaan Anda');
const pageImage = computed(() => seo.value.image || site.value.default_image || '/fasttrack-og.svg');
const pageType = computed(() => seo.value.type || 'website');
const pageRobots = computed(() => seo.value.robots || 'index, follow, max-image-preview:large');
const siteName = computed(() => site.value.name || 'FastTrack');
const siteLocale = computed(() => site.value.locale || 'id_ID');
const pageSchemas = computed(() => Array.isArray(page.props.schemas) ? page.props.schemas : []);
const globalSchemas = computed(() => {
    const baseUrl = site.value.url || '';
    const image = site.value.default_image || pageImage.value;
    return [
        {
            '@context': 'https://schema.org',
            '@type': 'Organization',
            name: siteName.value,
            url: baseUrl,
            logo: image,
            image,
            email: 'cs@fasttrack.legal',
            telephone: '+622173885036',
            address: {
                '@type': 'PostalAddress',
                streetAddress: 'Grand Bintaro Blok A7, Jl. Raya Bintaro Permai, Pesanggrahan, Bintaro',
                addressLocality: 'Jakarta Selatan',
                postalCode: '12330',
                addressCountry: 'ID',
            },
            sameAs: [
                'https://facebook.com/fasttrack',
                'https://instagram.com/fasttrack',
                'https://youtube.com/fasttrack',
            ],
        },
        {
            '@context': 'https://schema.org',
            '@type': 'WebSite',
            name: siteName.value,
            url: baseUrl,
            inLanguage: 'id-ID',
        },
    ];
});
</script>

<template>
    <Head :title="pageTitle">
        <meta name="description" :content="pageDescription">
        <meta name="robots" :content="pageRobots">
        <meta name="author" :content="siteName">
        <link rel="canonical" :href="currentUrl">

        <meta property="og:type" :content="pageType">
        <meta property="og:site_name" :content="siteName">
        <meta property="og:locale" :content="siteLocale">
        <meta property="og:title" :content="pageTitle">
        <meta property="og:description" :content="pageDescription">
        <meta property="og:url" :content="currentUrl">
        <meta property="og:image" :content="pageImage">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" :content="pageTitle">
        <meta name="twitter:description" :content="pageDescription">
        <meta name="twitter:image" :content="pageImage">
        <meta property="og:image:alt" :content="pageTitle">

        <component
            :is="'script'"
            v-for="(schema, index) in globalSchemas"
            :key="`global-schema-${index}`"
            type="application/ld+json"
        >{{ JSON.stringify(schema) }}</component>

        <component
            :is="'script'"
            v-for="(schema, index) in pageSchemas"
            :key="`page-schema-${index}`"
            type="application/ld+json"
        >{{ JSON.stringify(schema) }}</component>
    </Head>

    <div class="min-h-screen bg-[#F9F9F9] text-[#1A1B18] font-sans flex flex-col">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:rounded focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-[#1A1B18] focus:shadow-lg">
            Lewati ke konten
        </a>

        <AppHeader />

        <main id="main-content" class="flex-grow">
            <slot />
        </main>

        <AppFooter />
    </div>
</template>
