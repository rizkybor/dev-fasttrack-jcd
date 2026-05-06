<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
    articles: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <MainLayout>
        <div class="bg-gray-50 py-12 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-secondary mb-4">Artikel & Edukasi Hukum Bisnis</h1>
                <p class="text-gray-600 max-w-2xl mx-auto">Dapatkan informasi terbaru seputar legalitas, perpajakan, dan regulasi bisnis di Indonesia.</p>
            </div>
        </div>

        <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <article v-for="article in articles" :key="article.id" class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden flex flex-col">
                    <img :src="article.image" :alt="article.title" class="h-48 w-full object-cover" loading="lazy">
                    <div class="p-6">
                        <div class="text-sm text-primary font-medium mb-2">{{ article.category }}</div>
                        <a :href="`/artikel/${article.id}`" class="block text-xl font-bold text-secondary mb-2 hover:text-primary transition">
                            {{ article.title }}
                        </a>
                        <p class="text-gray-600 line-clamp-3 mb-4">{{ article.excerpt }}</p>
                        <div class="text-sm text-gray-500">{{ article.date }} &middot; {{ article.reading_time }}</div>
                        <a :href="`/artikel/${article.id}`" class="mt-4 inline-flex text-sm font-semibold text-primary hover:underline">
                            Baca Artikel &rarr;
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </MainLayout>
</template>
