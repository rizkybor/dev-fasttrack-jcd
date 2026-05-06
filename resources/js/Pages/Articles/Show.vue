<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
    article: {
        type: Object,
        required: true,
    },
    relatedArticles: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <MainLayout>
        <section class="bg-gray-50 border-b border-gray-200 py-12">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="text-sm mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex flex-wrap items-center gap-y-2 text-gray-500">
                        <li><a href="/" class="hover:text-primary">Beranda</a></li>
                        <li class="mx-2 text-gray-400">/</li>
                        <li><a href="/artikel" class="hover:text-primary">Artikel</a></li>
                        <li class="mx-2 text-gray-400">/</li>
                        <li class="text-gray-800">{{ article.title }}</li>
                    </ol>
                </nav>

                <span class="inline-flex rounded-full bg-primary/10 px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-primary">
                    {{ article.category }}
                </span>
                <h1 class="mt-5 text-3xl font-extrabold leading-tight text-secondary md:text-5xl">
                    {{ article.title }}
                </h1>
                <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-gray-500">
                    <span>{{ article.date }}</span>
                    <span>&middot;</span>
                    <span>{{ article.reading_time }}</span>
                </div>
                <p class="mt-6 max-w-3xl text-base leading-8 text-gray-600 md:text-lg">
                    {{ article.excerpt }}
                </p>
            </div>
        </section>

        <section class="bg-white py-12">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <img
                    :src="article.image"
                    :alt="article.title"
                    class="h-64 w-full rounded-[2rem] object-cover shadow-sm sm:h-80 lg:h-[460px]"
                >

                <div class="mt-10 grid gap-10 lg:grid-cols-[minmax(0,1fr)_280px]">
                    <article class="prose prose-gray max-w-none prose-headings:text-secondary prose-a:text-primary">
                        <p
                            v-for="(paragraph, index) in article.content"
                            :key="`${article.id}-${index}`"
                            class="mb-6 text-base leading-8 text-gray-700"
                        >
                            {{ paragraph }}
                        </p>
                    </article>

                    <aside class="rounded-3xl border border-gray-100 bg-gray-50 p-6 lg:sticky lg:top-24">
                        <h2 class="text-lg font-bold text-secondary">Butuh Bantuan Legalitas?</h2>
                        <p class="mt-3 text-sm leading-7 text-gray-600">
                            Tim FastTrack siap membantu kebutuhan legalitas bisnis Anda dengan proses yang lebih cepat dan profesional.
                        </p>
                        <a href="/kontak" class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-primary px-5 py-3 text-sm font-bold text-white transition hover:bg-pink-600">
                            Konsultasi Gratis
                        </a>
                    </aside>
                </div>
            </div>
        </section>

        <section v-if="relatedArticles.length" class="bg-gray-50 py-14">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-primary">Artikel Terkait</p>
                        <h2 class="mt-2 text-2xl font-extrabold text-secondary">Baca Juga Artikel Lainnya</h2>
                    </div>
                    <a href="/artikel" class="text-sm font-semibold text-primary hover:underline">Lihat Semua Artikel</a>
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <article
                        v-for="related in relatedArticles"
                        :key="related.id"
                        class="overflow-hidden rounded-[2rem] border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <img :src="related.image" :alt="related.title" class="h-48 w-full object-cover" loading="lazy">
                        <div class="p-6">
                            <div class="text-xs font-semibold uppercase tracking-[0.18em] text-primary">{{ related.category }}</div>
                            <a :href="`/artikel/${related.id}`" class="mt-3 block text-xl font-bold leading-tight text-secondary transition hover:text-primary">
                                {{ related.title }}
                            </a>
                            <p class="mt-3 text-sm leading-7 text-gray-600">{{ related.excerpt }}</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
