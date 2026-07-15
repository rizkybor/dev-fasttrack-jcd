<script setup>
import { ref, computed, watch } from "vue";
import { Link, router } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";

/**
 * Halaman "Artikel" — Wawasan Hukum & Bisnis Terkini
 * Sesuai desain Figma: hero + search + list artikel + CTA banner
 *
 * Search & pagination didorong lewat URL (?search=&page=) dan diproses
 * server-side di routes/web.php — bukan slicing array di client — supaya
 * link tiap halaman bisa di-bookmark/dibagikan dan payload tidak memuat
 * seluruh artikel sekaligus saat datanya nanti berkembang banyak.
 */

const props = defineProps({
    articles: {
        type: Array,
        default: () => [],
    },
    pagination: {
        type: Object,
        default: () => ({ current_page: 1, last_page: 1, per_page: 5, total: 0 }),
    },
    filters: {
        type: Object,
        default: () => ({ search: "" }),
    },
});

/* ------------------------------------------------------------------ */
/* Search (debounced, memicu kunjungan Inertia baru ke /artikel)        */
/* ------------------------------------------------------------------ */

const searchQuery = ref(props.filters.search ?? "");
let searchDebounce = null;

const visitArtikel = (params, options = {}) => {
    router.get("/artikel", params, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        ...options,
    });
};

watch(searchQuery, (value) => {
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(() => {
        visitArtikel(value.trim() ? { search: value.trim() } : {});
    }, 350);
});

/* ------------------------------------------------------------------ */
/* Pagination (link ke ?page=N, mempertahankan search yang aktif)      */
/* ------------------------------------------------------------------ */

const pageHref = (page) => {
    const params = new URLSearchParams();
    if (props.filters.search) params.set("search", props.filters.search);
    if (page > 1) params.set("page", String(page));
    const query = params.toString();
    return query ? `/artikel?${query}` : "/artikel";
};

/* ------------------------------------------------------------------ */
/* WhatsApp CTA                                                        */
/* ------------------------------------------------------------------ */

const whatsappNumber = "6282298604144";

const whatsappLink = computed(() => {
    const message =
        "Halo FastTrack, saya ingin konsultasi mengenai kebutuhan legalitas bisnis saya.";
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
});
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-[#9e1f16]">
            <div class="ml-5">
                <img
                    src="/icons/left-arrow.svg"
                    class="absolute right-[0%] -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block"
                    alt=""
                />
            </div>

            <div
                class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-14 lg:py-16"
            >
                <div class="relative z-10 max-w-2xl">
                    <!-- Breadcrumb -->
                    <nav class="mb-6" aria-label="Breadcrumb">
                        <div
                            class="inline-flex items-center gap-2 rounded-full bg-white/20 backdrop-blur-sm px-4 py-2"
                        >
                            <a href="/" class="text-white/90 hover:text-white transition">
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"
                                    />
                                </svg>
                            </a>
                            <svg
                                class="h-3 w-3 text-white/60"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                            <span class="text-sm font-medium text-white">Artikel</span>
                        </div>
                    </nav>

                    <!-- Heading -->
                    <h1
                        class="text-3xl font-extrabold leading-tight text-white sm:text-2xl lg:text-3xl max-w-[800px] line-clamp-2"
                    >
                        Wawasan Hukum & Bisnis Terkini
                    </h1>
                    <p class="mt-3 text-sm sm:text-base text-white/85">
                        Artikel, panduan, dan informasi terbaru seputar hukum bisnis,
                        perizinan, dan regulasi di Indonesia — langsung dari tim
                        konsultan FastTrack Legal.
                    </p>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section class="py-[52px] bg-[#F9F9F9]">
            <div class="max-w-4xl mx-auto px-4 sm:px-6">
                <div
                    class="rounded-xl border border-[#D9DAD8] bg-white p-6 sm:p-8 flex flex-col gap-5"
                >
                    <!-- Search -->
                    <div class="relative">
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Cari artikel, kata kunci, atau kategori..."
                            class="w-full rounded-lg border border-[#D9DAD8] pl-4 pr-11 py-3 text-[13px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                        />
                        <svg
                            class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#7A7B78]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                    </div>

                    <!-- Article List -->
                    <div v-if="articles.length" class="flex flex-col gap-4">
                        <Link
                            v-for="article in articles"
                            :key="article.slug ?? article.id"
                            :href="`/artikel/${article.slug ?? article.id}`"
                            class="block rounded-lg border border-[#D9DAD8] p-5 transition hover:border-[#9e1f16]/40 hover:shadow-sm"
                        >
                            <h2
                                class="text-[14px] sm:text-[15px] font-bold uppercase leading-[20px] text-[#1A1B18]"
                            >
                                {{ article.title }}
                            </h2>
                            <p
                                class="mt-1.5 text-[12px] leading-[19px] text-[#7A7B78] line-clamp-2"
                            >
                                {{ article.excerpt }}
                            </p>

                            <div class="mt-4 flex items-center justify-between">
                                <span
                                    class="inline-flex items-center gap-1.5 text-[11px] text-[#7A7B78]"
                                >
                                    <svg
                                        class="h-3.5 w-3.5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    {{ article.date }}
                                </span>

                                <span
                                    class="inline-flex items-center gap-1.5 text-[12px] font-semibold text-[#9e1f16]"
                                >
                                    Baca Selengkapnya
                                    <svg
                                        class="h-3.5 w-3.5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"
                                        />
                                    </svg>
                                </span>
                            </div>
                        </Link>
                    </div>

                    <!-- Pagination -->
                    <div
                        v-if="pagination.last_page > 1"
                        class="flex items-center justify-center gap-2 pt-2"
                    >
                        <Link
                            :href="pageHref(pagination.current_page - 1)"
                            :class="[
                                'flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-[#D9DAD8] text-[#7A7B78] transition hover:border-[#9e1f16]/40 hover:text-[#9e1f16]',
                                pagination.current_page === 1 && 'pointer-events-none opacity-40',
                            ]"
                            aria-label="Halaman sebelumnya"
                            preserve-scroll
                        >
                            <svg
                                class="h-3.5 w-3.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 19l-7-7 7-7"
                                />
                            </svg>
                        </Link>

                        <Link
                            v-for="page in pagination.last_page"
                            :key="page"
                            :href="pageHref(page)"
                            :class="[
                                'flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-[12px] font-semibold transition',
                                page === pagination.current_page
                                    ? 'bg-[#9e1f16] text-white'
                                    : 'border border-[#D9DAD8] text-[#4A4B47] hover:border-[#9e1f16]/40 hover:text-[#9e1f16]',
                            ]"
                            preserve-scroll
                        >
                            {{ page }}
                        </Link>

                        <Link
                            :href="pageHref(pagination.current_page + 1)"
                            :class="[
                                'flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-[#D9DAD8] text-[#7A7B78] transition hover:border-[#9e1f16]/40 hover:text-[#9e1f16]',
                                pagination.current_page === pagination.last_page && 'pointer-events-none opacity-40',
                            ]"
                            aria-label="Halaman berikutnya"
                            preserve-scroll
                        >
                            <svg
                                class="h-3.5 w-3.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </Link>
                    </div>

                    <!-- Empty State -->
                    <div
                        v-if="!articles.length"
                        class="flex flex-col items-center justify-center gap-2 rounded-lg border border-dashed border-[#D9DAD8] px-6 py-16 text-center"
                    >
                        <p class="text-[13px] font-medium text-[#1A1B18]">
                            Artikel tidak ditemukan
                        </p>
                        <p class="text-[12px] text-[#7A7B78]">
                            Coba gunakan kata kunci lain.
                        </p>
                    </div>
                </div>

                <!-- CTA BANNER -->
                <FooterCTA
                    class="mt-6"
                    title="Butuh Penjelasan Lebih Spesifik?"
                    description="Tim kami siap membantu Anda menemukan solusi yang tepat untuk kebutuhan legalitas bisnis Anda."
                    button-text="Chat Langsung via Whatsapp"
                    :whatsapp-link="whatsappLink"
                />
            </div>
        </section>
    </MainLayout>
</template>
