<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    relatedProducts: {
        type: Array,
        default: () => [],
    },
});

const whatsappNumber = '6282298604144';

const buildWhatsappLink = (productName) => {
    const message = `Halo FastTrack, saya ingin konsultasi lebih lanjut mengenai ${productName}.`;

    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};
</script>

<template>
    <MainLayout>
        <section class="bg-gray-50 py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <nav class="mb-6 text-sm font-medium text-gray-500" aria-label="Breadcrumb">
                    <a href="/" class="transition hover:text-secondary">Beranda</a>
                    <span class="mx-2">/</span>
                    <a href="/pendirian-perusahaan" class="transition hover:text-secondary">Pendirian Perusahaan</a>
                    <span class="mx-2">/</span>
                    <span class="text-secondary">{{ product.name }}</span>
                </nav>

                <div class="grid items-start gap-10 lg:grid-cols-[1.1fr_0.9fr]">
                    <div>
                        <span class="inline-flex rounded-full bg-primary/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-primary">
                            Detail Product by ID #{{ product.id }}
                        </span>
                        <h1 class="mt-5 text-4xl font-extrabold leading-tight text-secondary sm:text-5xl">
                            {{ product.name }}
                        </h1>
                        <p class="mt-5 max-w-3xl text-base leading-8 text-gray-600 sm:text-lg">
                            {{ product.description }}
                        </p>

                        <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap">
                            <a
                                :href="buildWhatsappLink(product.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center justify-center rounded-full bg-[#1E7E34] px-7 py-3.5 text-sm font-bold text-white transition hover:bg-[#155d27]"
                            >
                                Konsultasi via WhatsApp
                            </a>
                            <a
                                href="#edukasi"
                                class="inline-flex items-center justify-center rounded-full border border-secondary px-7 py-3.5 text-sm font-bold text-secondary transition hover:bg-secondary hover:text-white"
                            >
                                Pelajari Detail
                            </a>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl border border-gray-200 bg-white px-4 py-4 shadow-sm">
                                <div class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Mulai Dari</div>
                                <div class="mt-2 text-xl font-extrabold text-primary">{{ product.price_label }}</div>
                            </div>
                            <div class="rounded-2xl border border-gray-200 bg-white px-4 py-4 shadow-sm">
                                <div class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Estimasi</div>
                                <div class="mt-2 text-sm font-bold text-secondary">{{ product.duration }}</div>
                            </div>
                            <div class="rounded-2xl border border-gray-200 bg-white px-4 py-4 shadow-sm">
                                <div class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Kategori</div>
                                <div class="mt-2 text-sm font-bold text-secondary">{{ product.tag }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:sticky lg:top-28">
                        <div class="overflow-hidden rounded-[2rem] border border-gray-100 bg-white shadow-xl">
                            <img
                                :src="product.image"
                                :alt="product.name"
                                class="h-[280px] w-full object-cover sm:h-[360px]"
                            >
                            <div class="p-6">
                                <div class="inline-flex rounded-full bg-primary/10 px-3 py-1 text-xs font-bold text-primary">
                                    {{ product.tag }}
                                </div>
                                <div class="mt-4 text-2xl font-extrabold text-secondary">{{ product.name }}</div>
                                <div class="mt-2 text-sm leading-7 text-gray-600">{{ product.excerpt }}</div>

                                <div class="mt-6 rounded-2xl bg-gray-50 p-4">
                                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Audience</div>
                                    <p class="mt-2 text-sm leading-7 text-gray-600">{{ product.audience }}</p>
                                </div>

                                <a
                                    :href="buildWhatsappLink(product.name)"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-primary px-5 py-3 text-sm font-bold text-white transition hover:bg-pink-600"
                                >
                                    Minta Penawaran Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="edukasi" class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-[1fr_0.92fr]">
                    <div>
                        <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Edukasi Product</span>
                        <h2 class="mt-3 text-3xl font-bold text-secondary sm:text-4xl">
                            Memahami {{ product.name }} sebelum memulai proses legalitas
                        </h2>

                        <div class="mt-8 space-y-6">
                            <p
                                v-for="(paragraph, index) in product.content"
                                :key="`${product.id}-content-${index}`"
                                class="text-base leading-8 text-gray-600"
                            >
                                {{ paragraph }}
                            </p>
                        </div>

                        <div class="mt-10 rounded-[2rem] bg-secondary p-8 text-white">
                            <div class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Cocok Untuk</div>
                            <p class="mt-4 text-base leading-8 text-slate-200">
                                {{ product.audience }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-[1.75rem] border border-gray-100 bg-gray-50 p-6">
                            <h3 class="text-2xl font-bold text-secondary">Manfaat Utama</h3>
                            <ul class="mt-5 space-y-4">
                                <li
                                    v-for="benefit in product.benefits"
                                    :key="benefit"
                                    class="flex items-start gap-3 text-sm leading-7 text-gray-600"
                                >
                                    <span class="mt-1 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span>{{ benefit }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="rounded-[1.75rem] border border-gray-100 bg-white p-6 shadow-sm">
                            <h3 class="text-2xl font-bold text-secondary">Persiapan Dokumen</h3>
                            <ul class="mt-5 space-y-4">
                                <li
                                    v-for="requirement in product.requirements"
                                    :key="requirement"
                                    class="flex items-start gap-3 text-sm leading-7 text-gray-600"
                                >
                                    <span class="mt-2 h-2.5 w-2.5 flex-shrink-0 rounded-full bg-primary"></span>
                                    <span>{{ requirement }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-gray-50 py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Tahapan Proses</span>
                    <h2 class="mt-3 text-3xl font-bold text-secondary sm:text-4xl">
                        Alur pendampingan {{ product.name }} dibuat mudah diikuti
                    </h2>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    <div
                        v-for="(step, index) in product.process"
                        :key="step"
                        class="rounded-[1.75rem] border border-gray-100 bg-white p-6 shadow-sm"
                    >
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-secondary text-lg font-bold text-white">
                            {{ index + 1 }}
                        </div>
                        <p class="mt-5 text-sm leading-7 text-gray-600">{{ step }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-[0.95fr_1.05fr]">
                    <div class="rounded-[2rem] bg-gradient-to-br from-secondary via-slate-800 to-slate-900 p-8 text-white shadow-2xl">
                        <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">CTA Konsultasi</span>
                        <h2 class="mt-4 text-3xl font-bold">Butuh arahan memilih product yang paling tepat?</h2>
                        <p class="mt-4 text-base leading-8 text-slate-200">
                            Diskusikan model bisnis Anda bersama tim FastTrack agar pilihan badan usaha lebih selaras dengan kebutuhan operasional, kerja sama bisnis, dan target pertumbuhan.
                        </p>
                        <a
                            :href="buildWhatsappLink(product.name)"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-8 inline-flex rounded-full bg-primary px-6 py-3 font-bold text-white transition hover:bg-pink-600"
                        >
                            Hubungi FastTrack
                        </a>
                    </div>

                    <div class="rounded-[2rem] border border-gray-100 bg-gray-50 p-8">
                        <h2 class="text-3xl font-bold text-secondary">FAQ Singkat</h2>
                        <div class="mt-6 space-y-5">
                            <div
                                v-for="faq in product.faq"
                                :key="faq.question"
                                class="rounded-[1.5rem] border border-gray-100 bg-white p-5"
                            >
                                <h3 class="text-lg font-bold text-secondary">{{ faq.question }}</h3>
                                <p class="mt-3 text-sm leading-7 text-gray-600">{{ faq.answer }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-gray-50 py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Product Lainnya</span>
                        <h2 class="mt-3 text-3xl font-bold text-secondary">Lihat product pendirian lainnya</h2>
                    </div>
                    <a href="/pendirian-perusahaan" class="text-sm font-bold text-primary transition hover:underline">
                        Kembali ke semua product
                    </a>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <article
                        v-for="item in relatedProducts"
                        :key="item.id"
                        class="overflow-hidden rounded-[1.75rem] border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <img
                            :src="item.image"
                            :alt="item.name"
                            class="h-52 w-full object-cover"
                            loading="lazy"
                        >
                        <div class="p-6">
                            <div class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-400">Mulai dari</div>
                            <div class="mt-1 text-xl font-extrabold text-primary">{{ item.price_label }}</div>
                            <h3 class="mt-4 text-2xl font-bold text-secondary">{{ item.name }}</h3>
                            <p class="mt-3 text-sm leading-7 text-gray-600">{{ item.excerpt }}</p>
                            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                <a
                                    :href="`/pendirian-perusahaan/${item.id}`"
                                    class="inline-flex items-center justify-center rounded-full border border-secondary px-4 py-3 text-sm font-bold text-secondary transition hover:bg-secondary hover:text-white"
                                >
                                    Lihat Detail
                                </a>
                                <a
                                    :href="buildWhatsappLink(item.name)"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center rounded-full bg-[#1E7E34] px-4 py-3 text-sm font-bold text-white transition hover:bg-[#155d27]"
                                >
                                    WhatsApp
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
