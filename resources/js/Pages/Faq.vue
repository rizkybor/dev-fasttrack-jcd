<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { useI18n } from 'vue-i18n';

const { t, tm } = useI18n();
</script>

<template>
    <MainLayout>
        <section class="bg-white py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-primary">{{ t('faq.tag') }}</p>
                    <h1 class="mt-4 text-4xl font-extrabold text-secondary md:text-5xl">{{ t('faq.title') }}</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        {{ t('faq.desc') }}
                    </p>
                </div>

                <div class="mt-12 space-y-4">
                    <div v-for="faq in tm('faq.list')" :key="faq.question" class="rounded-2xl border border-gray-100 bg-gray-50 p-6">
                        <h2 class="text-lg font-bold text-secondary">{{ faq.question }}</h2>
                        <p class="mt-3 text-sm leading-6 text-gray-600">{{ faq.answer }}</p>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
