<script setup>
import { computed, ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';

const promos = [
    {
        id: 1,
        title: 'Promo Pendirian PT Hemat 30%',
        badge: 'Terpopuler',
        category: 'Pendirian PT',
        description: 'Paket hemat pendirian PT lengkap dengan konsultasi awal, pengecekan nama, dan pendampingan dokumen.',
        price: 'Mulai Rp 3.250.000',
        ctaLink: 'https://wa.me/6281234567890?text=Halo%20FastTrack,%20saya%20ingin%20promo%20Pendirian%20PT%20Hemat%2030%25',
        images: [
            'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=1200&q=80&fm=webp',
        ],
    },
    {
        id: 2,
        title: 'Bundling PT + Virtual Office',
        badge: 'Bundling',
        category: 'Virtual Office',
        description: 'Solusi legalitas dan alamat bisnis dalam satu paket praktis untuk bisnis baru yang ingin tampil profesional.',
        price: 'Mulai Rp 4.900.000',
        ctaLink: 'https://wa.me/6281234567890?text=Halo%20FastTrack,%20saya%20ingin%20promo%20Bundling%20PT%20dan%20Virtual%20Office',
        images: [
            'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1200&q=80&fm=webp',
        ],
    },
    {
        id: 3,
        title: 'Diskon Pendirian CV Untuk UMKM',
        badge: 'UMKM',
        category: 'Pendirian CV',
        description: 'Pilihan ekonomis untuk pelaku usaha yang ingin memulai langkah legalitas dengan biaya lebih efisien.',
        price: 'Mulai Rp 2.100.000',
        ctaLink: 'https://wa.me/6281234567890?text=Halo%20FastTrack,%20saya%20ingin%20promo%20Pendirian%20CV%20untuk%20UMKM',
        images: [
            'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1200&q=80&fm=webp',
        ],
    },
    {
        id: 4,
        title: 'Promo Pendaftaran Merek',
        badge: 'Branding',
        category: 'HAKI',
        description: 'Lindungi identitas bisnis Anda dengan promo pendaftaran merek dan konsultasi kelas merek.',
        price: 'Mulai Rp 1.850.000',
        ctaLink: 'https://wa.me/6281234567890?text=Halo%20FastTrack,%20saya%20ingin%20promo%20Pendaftaran%20Merek',
        images: [
            'https://images.unsplash.com/photo-1559027615-cd4628902d4a?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1542744173-05336fcc7ad4?auto=format&fit=crop&w=1200&q=80&fm=webp',
        ],
    },
    {
        id: 5,
        title: 'Paket Perubahan Akta Cepat',
        badge: 'Cepat',
        category: 'Perubahan Akta',
        description: 'Pendampingan perubahan akta perusahaan dengan proses yang lebih rapi untuk kebutuhan bisnis aktif.',
        price: 'Mulai Rp 2.750.000',
        ctaLink: 'https://wa.me/6281234567890?text=Halo%20FastTrack,%20saya%20ingin%20promo%20Perubahan%20Akta%20Cepat',
        images: [
            'https://images.unsplash.com/photo-1521791055366-0d553872125f?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80&fm=webp',
        ],
    },
    {
        id: 6,
        title: 'Paket Perizinan OSS & NIB',
        badge: 'Legalitas',
        category: 'Perizinan Usaha',
        description: 'Ideal untuk bisnis yang ingin segera go-live dengan penerbitan NIB dan pendampingan sistem OSS.',
        price: 'Mulai Rp 1.650.000',
        ctaLink: 'https://wa.me/6281234567890?text=Halo%20FastTrack,%20saya%20ingin%20promo%20Perizinan%20OSS%20dan%20NIB',
        images: [
            'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1516321310764-8d5f1b2d2cdd?auto=format&fit=crop&w=1200&q=80&fm=webp',
        ],
    },
    {
        id: 7,
        title: 'Promo Konsultasi Hukum Perusahaan',
        badge: 'Legal',
        category: 'Izin Hukum',
        description: 'Cocok untuk perusahaan yang membutuhkan ulasan kontrak, mitigasi risiko, dan arahan legal awal.',
        price: 'Mulai Rp 950.000',
        ctaLink: 'https://wa.me/6281234567890?text=Halo%20FastTrack,%20saya%20ingin%20promo%20Konsultasi%20Hukum%20Perusahaan',
        images: [
            'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=1200&q=80&fm=webp',
        ],
    },
    {
        id: 8,
        title: 'Promo Launching Website Bisnis',
        badge: 'Digital',
        category: 'Digital Marketing',
        description: 'Paket pembuatan website bisnis modern untuk memperkuat kredibilitas brand Anda secara online.',
        price: 'Mulai Rp 4.500.000',
        ctaLink: 'https://wa.me/6281234567890?text=Halo%20FastTrack,%20saya%20ingin%20promo%20Launching%20Website%20Bisnis',
        images: [
            'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80&fm=webp',
        ],
    },
    {
        id: 9,
        title: 'Promo Virtual Office Premium',
        badge: 'Premium',
        category: 'Virtual Office',
        description: 'Alamat bisnis strategis dengan fasilitas dokumen pendukung dan layanan penerimaan surat.',
        price: 'Mulai Rp 2.300.000 / tahun',
        ctaLink: 'https://wa.me/6281234567890?text=Halo%20FastTrack,%20saya%20ingin%20promo%20Virtual%20Office%20Premium',
        images: [
            'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1497366412874-3415097a27e7?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1497215842964-222b430dc094?auto=format&fit=crop&w=1200&q=80&fm=webp',
        ],
    },
    {
        id: 10,
        title: 'Promo Laporan LKPM',
        badge: 'Compliance',
        category: 'Layanan Lainnya',
        description: 'Pendampingan pelaporan LKPM agar kewajiban pelaporan investasi perusahaan tetap aman dan tepat waktu.',
        price: 'Mulai Rp 1.200.000',
        ctaLink: 'https://wa.me/6281234567890?text=Halo%20FastTrack,%20saya%20ingin%20promo%20Laporan%20LKPM',
        images: [
            'https://images.unsplash.com/photo-1554224154-26032ffc0d07?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1554224155-1696413565d3?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80&fm=webp',
        ],
    },
    {
        id: 11,
        title: 'Promo Investor Asing',
        badge: 'Foreign Service',
        category: 'Invest In Asia',
        description: 'Pendampingan legal untuk investor asing yang ingin membangun perusahaan di Indonesia dengan proses lebih terarah.',
        price: 'Mulai Rp 8.500.000',
        ctaLink: 'https://wa.me/6281234567890?text=Halo%20FastTrack,%20saya%20ingin%20promo%20Investor%20Asing',
        images: [
            'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1515169067868-5387ec356754?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80&fm=webp',
        ],
    },
    {
        id: 12,
        title: 'Promo Pengurusan Izin Properti',
        badge: 'Properti',
        category: 'Izin Properti',
        description: 'Layanan legalitas properti untuk kebutuhan jual beli, pengembangan aset, dan validasi dokumen.',
        price: 'Mulai Rp 3.800.000',
        ctaLink: 'https://wa.me/6281234567890?text=Halo%20FastTrack,%20saya%20ingin%20promo%20Pengurusan%20Izin%20Properti',
        images: [
            'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1200&q=80&fm=webp',
            'https://images.unsplash.com/photo-1560185007-cde436f6a4d0?auto=format&fit=crop&w=1200&q=80&fm=webp',
        ],
    },
];

const itemsPerPage = 9;
const currentPage = ref(1);
const activeSlides = ref(
    promos.reduce((accumulator, promo) => {
        accumulator[promo.id] = 0;
        return accumulator;
    }, {})
);

const totalPages = computed(() => Math.ceil(promos.length / itemsPerPage));
const paginatedPromos = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    return promos.slice(start, start + itemsPerPage);
});

const visiblePages = computed(() => Array.from({ length: totalPages.value }, (_, index) => index + 1));

const setPage = (page) => {
    currentPage.value = page;
    if (typeof window !== 'undefined') {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

const previousSlide = (promoId, totalImages) => {
    activeSlides.value[promoId] = (activeSlides.value[promoId] - 1 + totalImages) % totalImages;
};

const nextSlide = (promoId, totalImages) => {
    activeSlides.value[promoId] = (activeSlides.value[promoId] + 1) % totalImages;
};

const setSlide = (promoId, slideIndex) => {
    activeSlides.value[promoId] = slideIndex;
};
</script>

<template>
    <MainLayout>
        <section class="bg-gradient-to-br from-secondary via-slate-800 to-slate-900 py-20 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Promo FastTrack</p>
                    <h1 class="mt-4 text-4xl font-extrabold leading-tight md:text-6xl">
                        Penawaran Legalitas Bisnis yang Lebih Hemat dan Strategis
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-slate-200">
                        Jelajahi promo pilihan FastTrack untuk pendirian perusahaan, virtual office, perizinan usaha, HAKI, hingga layanan legal lainnya. Semua penawaran dirancang agar tetap efisien, profesional, dan ramah SEO.
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-primary">Katalog Promo</p>
                        <h2 class="mt-3 text-3xl font-extrabold text-secondary">9 Promo Tampil Per Halaman</h2>
                    </div>
                    <p class="text-sm text-gray-500">
                        Menampilkan {{ paginatedPromos.length }} dari total {{ promos.length }} penawaran tersedia.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <article
                        v-for="promo in paginatedPromos"
                        :key="promo.id"
                        class="overflow-hidden rounded-[2rem] border border-gray-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div class="relative">
                            <img
                                :src="promo.images[activeSlides[promo.id]]"
                                :alt="promo.title"
                                class="h-64 w-full object-cover"
                                loading="lazy"
                            >

                            <div class="absolute inset-x-0 top-0 flex items-center justify-between p-4">
                                <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-secondary backdrop-blur">
                                    {{ promo.badge }}
                                </span>
                                <span class="rounded-full bg-primary px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-white">
                                    {{ promo.category }}
                                </span>
                            </div>

                            <div class="absolute inset-x-0 bottom-0 flex items-center justify-between p-4">
                                <button
                                    type="button"
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/85 text-secondary shadow transition hover:bg-white"
                                    @click="previousSlide(promo.id, promo.images.length)"
                                >
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>

                                <div class="flex gap-2">
                                    <button
                                        v-for="(image, index) in promo.images"
                                        :key="`${promo.id}-${index}`"
                                        type="button"
                                        class="h-2.5 rounded-full transition"
                                        :class="activeSlides[promo.id] === index ? 'w-6 bg-white' : 'w-2.5 bg-white/50'"
                                        @click="setSlide(promo.id, index)"
                                    >
                                        <span class="sr-only">Pilih gambar {{ index + 1 }}</span>
                                    </button>
                                </div>

                                <button
                                    type="button"
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/85 text-secondary shadow transition hover:bg-white"
                                    @click="nextSlide(promo.id, promo.images.length)"
                                >
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-2xl font-bold leading-tight text-secondary">
                                {{ promo.title }}
                            </h3>
                            <p class="mt-4 text-sm leading-7 text-gray-600">
                                {{ promo.description }}
                            </p>
                            <div class="mt-6 flex flex-col items-start gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-400">Harga Promo</p>
                                    <p class="mt-2 text-lg font-extrabold text-primary">{{ promo.price }}</p>
                                </div>
                                <a
                                    :href="promo.ctaLink"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex w-full items-center justify-center rounded-full bg-primary px-5 py-3 text-sm font-bold text-white transition hover:bg-pink-600 sm:w-auto"
                                >
                                    Ambil Promo
                                </a>
                            </div>
                        </div>
                    </article>
                </div>

                <nav v-if="totalPages > 1" class="mt-12 flex flex-wrap items-center justify-center gap-3" aria-label="Pagination Promo">
                    <button
                        type="button"
                        class="rounded-full border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-secondary transition hover:border-primary hover:text-primary disabled:cursor-not-allowed disabled:opacity-40"
                        :disabled="currentPage === 1"
                        @click="setPage(currentPage - 1)"
                    >
                        Sebelumnya
                    </button>

                    <button
                        v-for="pageNumber in visiblePages"
                        :key="pageNumber"
                        type="button"
                        class="h-11 w-11 rounded-full text-sm font-bold transition"
                        :class="currentPage === pageNumber ? 'bg-primary text-white shadow-lg' : 'border border-gray-200 bg-white text-secondary hover:border-primary hover:text-primary'"
                        @click="setPage(pageNumber)"
                    >
                        {{ pageNumber }}
                    </button>

                    <button
                        type="button"
                        class="rounded-full border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-secondary transition hover:border-primary hover:text-primary disabled:cursor-not-allowed disabled:opacity-40"
                        :disabled="currentPage === totalPages"
                        @click="setPage(currentPage + 1)"
                    >
                        Berikutnya
                    </button>
                </nav>
            </div>
        </section>
    </MainLayout>
</template>
