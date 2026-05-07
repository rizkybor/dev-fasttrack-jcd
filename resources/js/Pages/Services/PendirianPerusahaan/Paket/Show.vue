<script setup>
import { computed } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    package: {
        type: Object,
        required: true,
    },
    relatedPackages: {
        type: Array,
        default: () => [],
    },
});

const whatsappNumber = '6282298604144';

const buildWhatsappLink = (packageName) => {
    const message = `Halo FastTrack, saya ingin konsultasi lebih lanjut mengenai ${packageName}.`;

    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

const isPersekutuanModal = computed(() => props.package.slug === 'persekutuan-modal');
const isPerorangan = computed(() => props.package.slug === 'perorangan');

const iconClasses = {
    shield: 'M12 2l7 4v6c0 5-3.5 9.74-7 10-3.5-.26-7-5-7-10V6l7-4z',
    office: 'M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M9 13h.01M9 17h.01M15 9h.01M15 13h.01M15 17h.01',
    document: 'M9 12h6M9 16h6M9 8h6M7 3h8l4 4v14H7V3z',
    growth: 'M3 17l6-6 4 4 7-7M14 8h6v6',
};

const modalHighlights = [
    'Cocok untuk bisnis dengan lebih dari satu pemegang saham',
    'Lebih siap untuk kerja sama korporasi dan ekspansi',
    'Bisa dikombinasikan dengan Virtual Office yang lebih representatif',
];

const peroranganHighlights = [
    'Dirancang untuk owner tunggal yang ingin naik kelas',
    'Lebih sederhana untuk UMKM dan bisnis jasa modern',
    'Tetap profesional tanpa struktur perusahaan yang terlalu kompleks',
];
</script>

<template>
    <MainLayout>
        <section
            v-if="isPersekutuanModal"
            class="relative overflow-hidden bg-secondary py-14 text-white sm:py-16 lg:py-20"
        >
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,45,85,0.16),transparent_26%),radial-gradient(circle_at_bottom_left,rgba(255,255,255,0.08),transparent_22%)]"></div>
            <div class="absolute inset-y-0 right-0 hidden w-1/2 lg:block">
                <div class="h-full w-full bg-[url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1400&q=80&fm=webp')] bg-cover bg-center opacity-20 lg:bg-fixed"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <nav class="mb-8 text-sm font-medium text-slate-300" aria-label="Breadcrumb">
                    <a href="/" class="transition hover:text-white">Beranda</a>
                    <span class="mx-2">/</span>
                    <a href="/pendirian-perusahaan" class="transition hover:text-white">Pendirian Perusahaan</a>
                    <span class="mx-2">/</span>
                    <a href="/pendirian-perusahaan/paket" class="transition hover:text-white">Paket</a>
                    <span class="mx-2">/</span>
                    <span class="text-white">{{ package.short_name }}</span>
                </nav>

                <div class="grid items-center gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:gap-14">
                    <div>
                        <span class="inline-flex rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-primary">
                            Paket Premium
                        </span>
                        <h1 class="mt-6 max-w-4xl text-4xl font-extrabold leading-tight sm:text-5xl lg:text-[3.8rem]">
                            {{ package.name }}
                        </h1>
                        <p class="mt-6 max-w-3xl text-base leading-8 text-slate-300 sm:text-lg">
                            Tampilan halaman ini dirancang lebih premium dan tegas untuk menggambarkan kebutuhan bisnis multi-founder, multi-pemegang saham, dan perusahaan yang sedang mempersiapkan skala pertumbuhan yang lebih besar.
                        </p>

                        <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap">
                            <a
                                :href="buildWhatsappLink(package.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center justify-center rounded-full bg-primary px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary/20 transition hover:bg-pink-600"
                            >
                                Konsultasi via WhatsApp
                            </a>
                            <a
                                href="#edukasi"
                                class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-7 py-3.5 text-sm font-bold text-white transition hover:bg-white/10"
                            >
                                Pelajari Detail
                            </a>
                        </div>

                       
                    </div>

                    
                </div>
            </div>
        </section>

        <section
            v-else
            class="relative overflow-hidden bg-gradient-to-b from-rose-50 via-white to-white py-14 sm:py-16 lg:py-20"
        >
            <div class="absolute inset-x-0 top-0 h-64 bg-[radial-gradient(circle_at_top,rgba(255,45,85,0.12),transparent_45%)]"></div>
            <div class="absolute right-0 top-10 h-56 w-56 rounded-full bg-primary/10 blur-3xl"></div>
            <div class="absolute left-0 bottom-0 h-44 w-44 rounded-full bg-slate-200/70 blur-3xl"></div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <nav class="mb-8 text-sm font-medium text-gray-500" aria-label="Breadcrumb">
                    <a href="/" class="transition hover:text-secondary">Beranda</a>
                    <span class="mx-2">/</span>
                    <a href="/pendirian-perusahaan" class="transition hover:text-secondary">Pendirian Perusahaan</a>
                    <span class="mx-2">/</span>
                    <a href="/pendirian-perusahaan/paket" class="transition hover:text-secondary">Paket</a>
                    <span class="mx-2">/</span>
                    <span class="text-secondary">{{ package.short_name }}</span>
                </nav>

                <div class="grid items-center gap-10 lg:grid-cols-[1fr_0.92fr] lg:gap-14">
                    <div>
                        <span class="inline-flex rounded-full border border-primary/15 bg-primary/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-primary">
                            Solusi Untuk Owner Tunggal
                        </span>
                        <h1 class="mt-6 max-w-4xl text-4xl font-extrabold leading-tight text-secondary sm:text-5xl lg:text-[3.6rem]">
                            {{ package.name }} dengan Tampilan Lebih Clean, Ringkas, dan Mudah Dipahami
                        </h1>
                        <p class="mt-6 max-w-3xl text-base leading-8 text-gray-600 sm:text-lg">
                            Halaman ini dibuat lebih ringan dan modern agar owner bisnis tunggal bisa memahami manfaat, struktur paket, dan persyaratan PT Perorangan dengan cepat tanpa terasa rumit.
                        </p>

                        <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap">
                            <a
                                :href="buildWhatsappLink(package.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center justify-center rounded-full bg-primary px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary/20 transition hover:bg-pink-600"
                            >
                                Konsultasi via WhatsApp
                            </a>
                            <a
                                href="#edukasi"
                                class="inline-flex items-center justify-center rounded-full border border-gray-300 bg-white px-7 py-3.5 text-sm font-bold text-secondary transition hover:border-secondary hover:bg-gray-50"
                            >
                                Pelajari Detail
                            </a>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <div class="rounded-[1.5rem] border border-gray-200 bg-white px-5 py-5 shadow-sm">
                                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-gray-400">Mulai Dari</div>
                                <div class="mt-2 text-2xl font-extrabold text-primary">{{ package.price_label }}</div>
                            </div>
                            <div class="rounded-[1.5rem] border border-gray-200 bg-white px-5 py-5 shadow-sm">
                                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-gray-400">Estimasi</div>
                                <div class="mt-2 text-sm font-bold text-secondary">{{ package.duration }}</div>
                            </div>
                            <div class="rounded-[1.5rem] border border-gray-200 bg-white px-5 py-5 shadow-sm">
                                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-gray-400">Fokus</div>
                                <div class="mt-2 text-sm font-bold text-secondary">UMKM &amp; Solo Founder</div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute -right-4 top-8 hidden h-48 w-48 rounded-full bg-primary/10 blur-3xl lg:block"></div>
                        <div class="overflow-hidden rounded-[2rem] border border-gray-100 bg-white p-3 shadow-xl">
                            <img
                                :src="package.image"
                                :alt="package.name"
                                class="h-[320px] w-full rounded-[1.5rem] object-cover sm:h-[420px] lg:h-[500px]"
                            >
                            <div class="absolute inset-x-8 bottom-8 rounded-[1.5rem] border border-white/80 bg-white/95 p-6 shadow-lg backdrop-blur">
                                <div class="inline-flex rounded-full bg-primary/10 px-3 py-1 text-xs font-bold uppercase tracking-[0.2em] text-primary">
                                    {{ package.tag }}
                                </div>
                                <div class="mt-4 text-2xl font-extrabold leading-snug text-secondary">{{ package.name }}</div>
                                <div class="mt-3 space-y-3">
                                    <div
                                        v-for="highlight in peroranganHighlights"
                                        :key="highlight"
                                        class="flex items-start gap-3 text-sm leading-7 text-gray-600"
                                    >
                                        <span class="mt-1 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                        <span>{{ highlight }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section
            id="edukasi"
            :class="isPersekutuanModal ? 'bg-white py-20 sm:py-24' : 'bg-white py-16 sm:py-20'"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div :class="isPersekutuanModal ? 'grid gap-12 lg:grid-cols-[1.05fr_0.95fr]' : 'grid gap-12 lg:grid-cols-[1fr_0.92fr]'">
                    <div>
                        <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Edukasi Paket</span>
                        <h2 class="mt-3 text-3xl font-bold text-secondary sm:text-4xl">
                            Memahami {{ package.name }} sebelum memulai proses legalitas
                        </h2>

                        <div class="mt-8 space-y-6">
                            <p
                                v-for="(paragraph, index) in package.content"
                                :key="`${package.slug}-content-${index}`"
                                class="text-base leading-8 text-gray-600"
                            >
                                {{ paragraph }}
                            </p>
                        </div>

                        <div :class="isPersekutuanModal ? 'mt-10 rounded-[2rem] bg-gradient-to-br from-secondary via-slate-800 to-slate-950 p-8 text-white shadow-xl' : 'mt-10 rounded-[2rem] bg-secondary p-8 text-white'">
                            <div class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Cocok Untuk</div>
                            <p class="mt-4 text-base leading-8 text-slate-200">
                                {{ package.audience }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div :class="isPersekutuanModal ? 'rounded-[1.75rem] border border-gray-100 bg-gray-50 p-7 shadow-sm' : 'rounded-[1.75rem] border border-gray-100 bg-gray-50 p-6'">
                            <h3 class="text-2xl font-bold text-secondary">Manfaat Utama</h3>
                            <ul class="mt-5 space-y-4">
                                <li
                                    v-for="benefit in package.benefits"
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

                        <div :class="isPersekutuanModal ? 'rounded-[1.75rem] border border-gray-100 bg-white p-7 shadow-sm' : 'rounded-[1.75rem] border border-gray-100 bg-white p-6 shadow-sm'">
                            <h3 class="text-2xl font-bold text-secondary">Persiapan Dokumen</h3>
                            <ul class="mt-5 space-y-4">
                                <li
                                    v-for="requirement in package.requirements"
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

        <section v-if="isPersekutuanModal" class="relative overflow-hidden bg-gray-50 py-16 sm:py-20">
            <div class="absolute inset-y-0 right-0 hidden w-1/3 bg-[url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=80&fm=webp')] bg-cover bg-center opacity-10 lg:block lg:bg-fixed"></div>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 max-w-3xl">
                    <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Insight Pengusaha</span>
                    <h2 class="mt-3 text-3xl font-bold text-secondary sm:text-4xl">
                        Mengapa Pengusaha Harus Memiliki PT &amp; Virtual Office?
                    </h2>
                    <p class="mt-4 text-base leading-7 text-gray-600">
                        Kombinasi badan hukum PT dan alamat usaha yang representatif membantu bisnis terlihat lebih siap, lebih kredibel, dan lebih nyaman ketika mulai berkembang.
                    </p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <article
                        v-for="item in package.why_cards"
                        :key="item.title"
                        class="rounded-[1.75rem] border border-gray-100 bg-white p-7 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    :d="iconClasses[item.icon]"
                                />
                            </svg>
                        </div>
                        <h3 class="mt-5 text-2xl font-bold text-secondary">{{ item.title }}</h3>
                        <p class="mt-3 text-sm leading-7 text-gray-600">{{ item.description }}</p>
                    </article>
                </div>
            </div>
        </section>

        <section v-if="isPersekutuanModal" class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Pilihan Paket</span>
                        <h2 class="mt-3 text-3xl font-bold text-secondary sm:text-4xl">
                            Paket Pendirian Persekutuan Modal
                        </h2>
                        <p class="mt-4 text-base leading-7 text-gray-600">
                            Pilihan paket berikut membantu Anda menyesuaikan kebutuhan legalitas PT dengan kebutuhan operasional, brand, perpajakan, maupun alamat usaha.
                        </p>
                    </div>
                    <a
                        :href="buildWhatsappLink(package.name)"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center rounded-full border border-primary px-6 py-3 text-sm font-bold text-primary transition hover:bg-primary hover:text-white"
                    >
                        Konsultasi Struktur Paket
                    </a>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <article
                        v-for="plan in package.plans"
                        :key="plan.name"
                        class="group relative flex h-full flex-col overflow-hidden rounded-[1.85rem] border border-gray-100 bg-white shadow-[0_10px_30px_rgba(15,23,42,0.06)] transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="absolute inset-0 bg-cover bg-center opacity-[0.06] transition duration-300 group-hover:scale-105 group-hover:opacity-[0.08]"
                            :style="{ backgroundImage: `url(${package.image})` }"
                        ></div>
                        <div class="absolute inset-0 bg-gradient-to-b from-white/92 via-white/95 to-white"></div>
                        <div class="h-1.5 w-full bg-gradient-to-r from-primary via-pink-400 to-secondary"></div>
                        <div class="relative z-10 flex h-full flex-col p-6">
                            <div class="inline-flex self-start rounded-full bg-primary/10 px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-primary">
                                {{ plan.highlight }}
                            </div>
                            <h3 class="mt-4 text-2xl font-bold leading-tight text-secondary">{{ plan.name }}</h3>
                            <p class="mt-3 text-sm leading-7 text-gray-600">{{ plan.subtitle }}</p>

                            <div class="mt-5 rounded-[1.5rem] bg-gray-50 p-5">
                                <div v-if="plan.promo_price" class="text-sm font-semibold uppercase tracking-[0.18em] text-primary">
                                    {{ plan.promo_price }}
                                </div>
                                <div :class="plan.promo_price ? 'mt-2 text-sm font-medium text-gray-400 line-through' : 'text-sm font-semibold uppercase tracking-[0.18em] text-gray-400'">
                                    {{ plan.price }}
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-gray-400">Yang Didapatkan</div>
                                <div class="mt-3 space-y-3">
                                    <div
                                        v-for="item in plan.includes"
                                        :key="item"
                                        class="flex items-start gap-3 text-sm leading-7 text-gray-600"
                                    >
                                        <span class="mt-1 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                        <span>{{ item }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="my-4 rounded-[1.35rem] border border-primary/10 bg-primary/5 p-4 text-sm leading-7 text-gray-600">
                                <span class="font-bold text-secondary">Catatan:</span> {{ plan.note }}
                            </div>

                            <a
                                :href="buildWhatsappLink(plan.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="mt-auto inline-flex items-center justify-center rounded-full bg-secondary px-5 py-3 text-sm font-bold text-white transition hover:bg-primary"
                            >
                                Konsultasi via WhatsApp
                            </a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section v-if="isPerorangan" class="bg-gradient-to-b from-white to-rose-50/40 py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-[1fr_0.92fr] lg:items-start">
                    <div>
                        <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Pengenalan</span>
                        <h2 class="mt-3 text-3xl font-bold text-secondary sm:text-4xl">
                            Apa itu PT Perorangan?
                        </h2>
                        <div class="mt-6 space-y-5">
                            <p
                                v-for="(paragraph, index) in package.about"
                                :key="`about-${index}`"
                                class="text-base leading-8 text-gray-600"
                            >
                                {{ paragraph }}
                            </p>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-gray-100 bg-white p-8 shadow-sm">
                        <div class="text-sm font-semibold uppercase tracking-[0.22em] text-primary">Nilai Utama</div>
                        <div class="mt-6 space-y-5">
                            <div
                                v-for="benefit in package.benefits"
                                :key="benefit"
                                class="flex items-start gap-3 text-sm leading-7 text-gray-600"
                            >
                                <span class="mt-1 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <span>{{ benefit }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="isPerorangan" class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 max-w-3xl">
                    <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Pilihan Paket</span>
                    <h2 class="mt-3 text-3xl font-bold text-secondary sm:text-4xl">
                        PAKET PENDIRIAN PT PERORANGAN
                    </h2>
                    <p class="mt-4 text-base leading-7 text-gray-600">
                        Dirancang untuk owner bisnis yang ingin memiliki badan hukum lebih formal dengan pilihan paket yang bisa disesuaikan dengan kebutuhan awal usaha.
                    </p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <article
                        v-for="plan in package.plans"
                        :key="plan.name"
                        class="group relative flex h-full flex-col overflow-hidden rounded-[2rem] border border-rose-100/70 bg-white shadow-[0_10px_30px_rgba(15,23,42,0.05)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_40px_rgba(15,23,42,0.08)]"
                    >
                        <div
                            class="absolute inset-0 bg-cover bg-center transition duration-500 group-hover:scale-105"
                            :style="{ backgroundImage: `url(${package.image})` }"
                        ></div>
                        <div class="absolute inset-0 bg-gradient-to-br from-white/90 via-white/82 to-rose-50/92"></div>
                        <div class="absolute inset-0 bg-secondary/[0.18]"></div>

                        <div class="relative z-10 flex h-full flex-col p-6">
                            <div class="inline-flex self-start rounded-full bg-white/92 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] text-primary shadow-sm backdrop-blur">
                                {{ plan.highlight }}
                            </div>

                            <div class="mt-5 rounded-[1.5rem] border border-white/60 bg-white/70 p-5 shadow-[0_8px_22px_rgba(15,23,42,0.05)] backdrop-blur-sm">
                                <div class="inline-flex rounded-full bg-secondary/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-white shadow-sm">
                                    Solo Package
                                </div>
                                <h3 class="mt-3 text-[1.7rem] font-bold leading-tight text-secondary">
                                    {{ plan.name }}
                                </h3>
                                <p class="mt-3 text-sm leading-7 text-gray-600">{{ plan.subtitle }}</p>
                                <div class="mt-2 text-[11px] font-semibold uppercase tracking-[0.2em] text-gray-400">Harga</div>
                                <div v-if="plan.promo_price" class="mt-3 inline-flex rounded-full bg-primary/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] text-primary">
                                    {{ plan.promo_price }}
                                </div>
                                <div class="mt-3 text-lg font-bold text-secondary">
                                    {{ plan.price }}
                                </div>
                            </div>

                          

                            <div class="mt-5 rounded-[1.5rem] border border-white/60 bg-white/70 p-5 shadow-[0_8px_22px_rgba(15,23,42,0.05)] backdrop-blur-sm">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-gray-400">Yang Didapatkan</div>
                                <div class="mt-3 space-y-3">
                                    <div
                                        v-for="item in plan.includes"
                                        :key="item"
                                        class="flex items-start gap-3 rounded-[1rem] bg-white/90 px-4 py-3 text-sm leading-7 text-gray-600 shadow-[0_6px_16px_rgba(15,23,42,0.03)]"
                                    >
                                        <span class="mt-1 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                        <span>{{ item }}</span>
                                    </div>
                                </div>

                                <div class="mt-2 text-sm leading-7 text-gray-600">
                                    <span class="font-bold text-secondary">Catatan:</span> {{ plan.note }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <a
                                    :href="buildWhatsappLink(plan.name)"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex min-h-[3.5rem] w-full items-center justify-center rounded-full bg-primary px-5 py-3 text-center text-sm font-bold leading-none text-white shadow-md shadow-primary/20 transition duration-200 hover:-translate-y-0.5 hover:bg-pink-600 hover:shadow-lg hover:shadow-primary/30"
                                >
                                    Konsultasi via WhatsApp
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section v-if="isPerorangan" class="bg-gray-50 py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 max-w-3xl">
                    <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Perbandingan</span>
                    <h2 class="mt-3 text-3xl font-bold text-secondary sm:text-4xl">
                        Perbedaan PT Perorangan dengan PT Biasa
                    </h2>
                </div>

                <div class="overflow-hidden rounded-[2rem] border border-gray-100 bg-white shadow-sm">
                    <div class="hidden grid-cols-[0.9fr_1fr_1fr] bg-secondary px-8 py-5 text-sm font-bold text-white md:grid">
                        <div>Aspek</div>
                        <div>PT Perorangan</div>
                        <div>PT Biasa</div>
                    </div>
                    <div
                        v-for="item in package.differences"
                        :key="item.aspect"
                        class="grid gap-4 border-t border-gray-100 px-6 py-6 md:grid-cols-[0.9fr_1fr_1fr] md:gap-6 md:px-8"
                    >
                        <div class="text-base font-bold text-secondary">{{ item.aspect }}</div>
                        <div class="rounded-2xl bg-primary/5 px-4 py-4 text-sm leading-7 text-gray-700 md:bg-transparent md:px-0 md:py-0">
                            {{ item.perorangan }}
                        </div>
                        <div class="rounded-2xl bg-gray-50 px-4 py-4 text-sm leading-7 text-gray-700 md:bg-transparent md:px-0 md:py-0">
                            {{ item.biasa }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="isPerorangan" class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-2">
                    <div class="rounded-[2rem] border border-gray-100 bg-gray-50 p-8">
                        <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Kecocokan Usaha</span>
                        <h2 class="mt-3 text-3xl font-bold text-secondary">
                            Usaha yang dapat menggunakan PT Perorangan
                        </h2>
                        <div class="mt-6 grid gap-4">
                            <div
                                v-for="business in package.business_types"
                                :key="business"
                                class="rounded-[1.25rem] border border-white bg-white px-5 py-4 text-sm leading-7 text-gray-600 shadow-sm"
                            >
                                {{ business }}
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-gray-100 bg-secondary p-8 text-white shadow-xl">
                        <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Checklist Dasar</span>
                        <h2 class="mt-3 text-3xl font-bold">
                            Syarat Mendirikan PT Perorangan
                        </h2>
                        <div class="mt-6 space-y-4">
                            <div
                                v-for="requirement in package.requirements_detail"
                                :key="requirement"
                                class="flex items-start gap-3 rounded-[1.25rem] border border-white/10 bg-white/5 px-5 py-4 text-sm leading-7 text-slate-100"
                            >
                                <span class="mt-1 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-primary/20 text-primary">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <span>{{ requirement }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section :class="isPersekutuanModal ? 'bg-slate-950 py-16 text-white sm:py-20' : 'bg-gray-50 py-16 sm:py-20'">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Tahapan Proses</span>
                    <h2 :class="isPersekutuanModal ? 'mt-3 text-3xl font-bold text-white sm:text-4xl' : 'mt-3 text-3xl font-bold text-secondary sm:text-4xl'">
                        Alur pendampingan {{ package.name }} dibuat mudah diikuti
                    </h2>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    <div
                        v-for="(step, index) in package.process"
                        :key="step"
                        :class="isPersekutuanModal ? 'rounded-[1.75rem] border border-white/10 bg-white/5 p-6 shadow-sm backdrop-blur' : 'rounded-[1.75rem] border border-gray-100 bg-white p-6 shadow-sm'"
                    >
                        <div :class="isPersekutuanModal ? 'inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-lg font-bold text-white' : 'inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-secondary text-lg font-bold text-white'">
                            {{ index + 1 }}
                        </div>
                        <p :class="isPersekutuanModal ? 'mt-5 text-sm leading-7 text-slate-200' : 'mt-5 text-sm leading-7 text-gray-600'">{{ step }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section :class="isPersekutuanModal ? 'bg-white py-16 sm:py-20' : 'bg-white py-16 sm:py-20'">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-[0.95fr_1.05fr]">
                    <div :class="isPersekutuanModal ? 'rounded-[2rem] bg-gradient-to-br from-secondary via-slate-800 to-slate-950 p-8 text-white shadow-2xl' : 'rounded-[2rem] border border-gray-100 bg-gradient-to-br from-rose-50 via-white to-white p-8 text-secondary shadow-xl'">
                        <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">CTA Konsultasi</span>
                        <h2 class="mt-4 text-3xl font-bold">Butuh arahan memilih paket yang paling tepat?</h2>
                        <p :class="isPersekutuanModal ? 'mt-4 text-base leading-8 text-slate-200' : 'mt-4 text-base leading-8 text-gray-600'">
                            Diskusikan kondisi bisnis Anda bersama tim FastTrack agar pilihan paket pendirian PT lebih sesuai dengan struktur usaha, kebutuhan operasional, dan target pertumbuhan.
                        </p>
                        <a
                            :href="buildWhatsappLink(package.name)"
                            target="_blank"
                            rel="noopener noreferrer"
                            :class="isPersekutuanModal ? 'mt-8 inline-flex rounded-full bg-primary px-6 py-3 font-bold text-white transition hover:bg-pink-600' : 'mt-8 inline-flex rounded-full bg-primary px-6 py-3 font-bold text-white transition hover:bg-pink-600'"
                        >
                            Hubungi FastTrack
                        </a>
                    </div>

                    <div :class="isPersekutuanModal ? 'rounded-[2rem] border border-gray-100 bg-gray-50 p-8' : 'rounded-[2rem] border border-gray-100 bg-white p-8 shadow-sm'">
                        <h2 class="text-3xl font-bold text-secondary">FAQ Singkat</h2>
                        <div class="mt-6 space-y-5">
                            <div
                                v-for="faq in package.faq"
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

        <section v-if="relatedPackages.length" class="bg-gray-50 py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Paket Lainnya</span>
                        <h2 class="mt-3 text-3xl font-bold text-secondary">Bandingkan dengan paket lainnya</h2>
                    </div>
                    <a href="/pendirian-perusahaan/paket" class="text-sm font-bold text-primary transition hover:underline">
                        Kembali ke semua paket
                    </a>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <article
                        v-for="item in relatedPackages"
                        :key="item.slug"
                        class="overflow-hidden rounded-[1.75rem] border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <img
                            :src="item.image"
                            :alt="item.name"
                            class="h-56 w-full object-cover"
                            loading="lazy"
                        >
                        <div class="p-6">
                            <div class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-400">Mulai dari</div>
                            <div class="mt-1 text-xl font-extrabold text-primary">{{ item.price_label }}</div>
                            <h3 class="mt-4 text-2xl font-bold text-secondary">{{ item.name }}</h3>
                            <p class="mt-3 text-sm leading-7 text-gray-600">{{ item.excerpt }}</p>
                            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                <a
                                    :href="`/pendirian-perusahaan/paket/${item.slug}`"
                                    class="inline-flex items-center justify-center rounded-full border border-secondary px-4 py-3 text-sm font-bold text-secondary transition hover:bg-secondary hover:text-white"
                                >
                                    Lihat Detail
                                </a>
                                <a
                                    :href="buildWhatsappLink(item.name)"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center rounded-full bg-primary px-4 py-3 text-sm font-bold text-white transition hover:bg-pink-600"
                                >
                                    Konsultasi
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
