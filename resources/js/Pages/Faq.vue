<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

const faqs = [
    {
        question: 'Berapa lama proses pendirian PT?',
        answer: 'Estimasi waktu bervariasi tergantung kelengkapan dokumen, namun umumnya proses dasar dapat dimulai dalam beberapa hari kerja.',
    },
    {
        question: 'Apakah FastTrack membantu memilih KBLI?',
        answer: 'Ya, kami membantu mencocokkan aktivitas bisnis Anda dengan KBLI yang paling relevan untuk kebutuhan OSS dan legalitas.',
    },
    {
        question: 'Apakah layanan konsultasi tersedia secara online?',
        answer: 'Tersedia. Anda dapat menghubungi tim kami melalui form konsultasi atau WhatsApp untuk diskusi awal.',
    },
];
</script>

<template>
    <MainLayout>
        <section class="bg-white py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-primary">Tips Bisnis</p>
                    <h1 class="mt-4 text-4xl font-extrabold text-secondary md:text-5xl">FAQ</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Jawaban singkat untuk pertanyaan yang paling sering ditanyakan terkait legalitas bisnis dan layanan FastTrack.
                    </p>
                </div>

                <div class="mt-12 space-y-4">
                    <div v-for="faq in faqs" :key="faq.question" class="rounded-2xl border border-gray-100 bg-gray-50 p-6">
                        <h2 class="text-lg font-bold text-secondary">{{ faq.question }}</h2>
                        <p class="mt-3 text-sm leading-6 text-gray-600">{{ faq.answer }}</p>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
