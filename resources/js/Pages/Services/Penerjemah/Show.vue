<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { ref, computed, watch } from "vue";
import { useI18n } from "vue-i18n";

const { locale } = useI18n();

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

const whatsappNumber = "6282298604144";

const buildWhatsappLink = (productName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${productName}.`;
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

// Helper: pick nilai berdasarkan locale, fallback ke 'id'
const pick = (field) => {
    if (field === null || field === undefined) return field;
    if (
        typeof field === "object" &&
        !Array.isArray(field) &&
        ("id" in field || "en" in field || "zh" in field)
    ) {
        return field[locale.value] ?? field.id ?? field;
    }
    return field;
};

const localizedProduct = computed(() => {
    const p = props.product;
    if (!p) return p;

    return {
        ...p,
        name: pick(p.name),
        tag: pick(p.tag),
        duration: pick(p.duration),
        description: pick(p.description),
        excerpt: pick(p.excerpt),
        content: pick(p.content) ?? [],
        bahasa_wilayah: pick(p.bahasa_wilayah),
        keunggulan: pick(p.keunggulan),
        banner_cta: pick(p.banner_cta),
        faq: pick(p.faq) ?? [],
    };
});

const product = localizedProduct;

// Bahasa & Wilayah search + pagination
const bahasaSearch = ref("");
const bahasaPage = ref(1);
const bahasaRowsPerPage = ref(10);

const bahasaItems = computed(() => product.value?.bahasa_wilayah?.items ?? []);

const filteredBahasa = computed(() => {
    const q = bahasaSearch.value.trim().toLowerCase();
    if (!q) return bahasaItems.value;
    return bahasaItems.value.filter((item) =>
        item.negara_title.toLowerCase().includes(q)
    );
});

const totalBahasaPages = computed(() =>
    Math.max(1, Math.ceil(filteredBahasa.value.length / (bahasaRowsPerPage.value * 2)))
);

const paginatedBahasa = computed(() => {
    const itemsPerPage = bahasaRowsPerPage.value * 2;
    const start = (bahasaPage.value - 1) * itemsPerPage;
    return filteredBahasa.value.slice(start, start + itemsPerPage);
});

const bahasaDisplayCount = computed(() => paginatedBahasa.value.length);

// Desktop: 2-column rows
const bahasaRows = computed(() => {
    const items = paginatedBahasa.value;
    const rows = [];
    for (let i = 0; i < items.length; i += 2) {
        const row = items.slice(i, i + 2);
        while (row.length < 2) row.push(null);
        rows.push(row);
    }
    return rows;
});

// Mobile: 1-column rows
const bahasaMobileRows = computed(() => paginatedBahasa.value);

// Reset page saat search berubah
watch(bahasaSearch, () => { bahasaPage.value = 1; });

const keunggulan = computed(() => product.value?.keunggulan ?? null);
const bannerCta = computed(() => product.value?.banner_cta ?? null);
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]">
            <div class="absolute inset-0">
                <img src="/images/layanan-hero/ft-hero-penterjemah.png" class="h-full w-full object-cover object-center"
                    alt="" />
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"></div>
            </div>

            <div
                class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]">
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb">
                    <div class="inline-flex items-center gap-2 sm:rounded-md sm:bg-white sm:px-4 sm:py-2">
                        <a href="/" class="text-[#9e1f16] hover:text-black transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
                            </svg>
                        </a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/layanan" class="text-sm font-medium text-[#9e1f16] hover:underline">Layanan</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#9e1f16]">{{ product.name }}</span>
                    </div>
                </nav>

                <!-- Heading -->
                <div class="flex flex-col gap-3 max-w-2xl">
                    <h1 class="font-extrabold leading-tight text-white text-2xl sm:text-3xl lg:text-4xl">
                        {{ product.name }}
                    </h1>
                    <p class="text-sm sm:text-base text-white/85 leading-relaxed">
                        {{ product.description }}
                    </p>
                </div>

                <!-- Back -->
                <div>
                    <a href="/layanan"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[1fr_280px] xl:grid-cols-[1fr_300px] min-w-0">

                    <!-- KIRI -->
                    <div class="flex flex-col gap-6 min-w-0">

                        <!-- 1. Informasi Umum -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Informasi</h2>
                            </div>
                            <div class="space-y-4">
                                <p v-for="(paragraph, index) in product.content" :key="`content-${index}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A]">
                                    {{ paragraph }}
                                </p>
                            </div>
                        </div>

                        <!-- 2. Bahasa & Wilayah -->
                        <div v-if="product.bahasa_wilayah"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5 sm:p-8">
                            <div class="flex items-center gap-3 mb-2">
                                <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                <h2 class="text-[13px] sm:text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ product.bahasa_wilayah.title }}
                                </h2>
                            </div>
                            <p v-if="product.bahasa_wilayah.subtitle"
                                class="text-[12px] sm:text-[13px] leading-[1.7] text-[#686964] mb-5 sm:mb-6 break-words">
                                {{ product.bahasa_wilayah.subtitle }}
                            </p>

                            <!-- Search desktop -->
                            <div class="relative mb-4 hidden sm:block">
                                <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-[#A8A8A4] pointer-events-none"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input v-model="bahasaSearch" type="text"
                                    placeholder="Cari bahasa... mis. Jepang, Arab, Jerman"
                                    class="w-full border border-[#D9DAD8] rounded-lg pl-8 pr-3 py-2 text-[11px] sm:text-[12px] text-[#3D3D3A] placeholder-[#A8A8A4] focus:outline-none focus:border-[#9e1f16]/40 transition-colors bg-white" />
                            </div>

                            <!-- ===== DESKTOP: 2-column table ===== -->
                            <div class="hidden sm:block">
                                <div class="border border-[#D9DAD8] rounded-lg overflow-hidden">
                                    <!-- Header -->
                                    <div class="grid grid-cols-2 bg-[#F5F5F3]">
                                        <div
                                            class="px-4 py-2.5 text-[11px] font-semibold text-[#686964] uppercase tracking-wider border-r border-[#D9DAD8]">
                                            Bahasa / Wilayah</div>
                                        <div
                                            class="px-4 py-2.5 text-[11px] font-semibold text-[#686964] uppercase tracking-wider">
                                            Bahasa / Wilayah</div>
                                    </div>
                                    <!-- Body -->
                                    <template v-if="bahasaRows.length">
                                        <div v-for="(row, ri) in bahasaRows" :key="`brow-d-${ri}`"
                                            class="grid grid-cols-2"
                                            :class="ri < bahasaRows.length - 1 ? 'border-b border-[#E8E8E6]' : ''">
                                            <template v-for="(item, ci) in row" :key="`bcell-d-${ri}-${ci}`">
                                                <div v-if="item"
                                                    class="flex items-center gap-2.5 px-4 py-2.5 min-w-0 hover:bg-[#FAFAF8] transition-colors"
                                                    :class="ci === 0 ? 'border-r border-[#E8E8E6]' : ''">
                                                    <img :src="item.img_flag" :alt="item.negara_title"
                                                        class="w-6 h-[15px] object-cover rounded-[2px] flex-shrink-0 shadow-sm"
                                                        loading="lazy" />
                                                    <span class="text-[12px] leading-[1.4] text-[#3D3D3A] truncate">{{
                                                        item.negara_title }}</span>
                                                </div>
                                                <div v-else class="px-4 py-2.5"
                                                    :class="ci === 0 ? 'border-r border-[#E8E8E6]' : ''"></div>
                                            </template>
                                        </div>
                                    </template>
                                    <!-- Empty state -->
                                    <div v-else class="px-4 py-12 text-center">
                                        <svg class="mx-auto mb-3 w-10 h-10 text-[#D9DAD8]" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <p class="text-[13px] text-[#686964]">Tidak ada bahasa yang cocok dengan "<span
                                                class="font-semibold text-[#3D3D3A]">{{ bahasaSearch }}</span>"</p>
                                    </div>
                                </div>

                                <!-- Pagination Bar Desktop -->
                                <div class="flex items-center justify-between mt-4 min-w-0 gap-3">
                                    <span class="text-[11px] sm:text-[12px] text-[#686964] flex-shrink-0 tabular-nums">
                                        {{ bahasaDisplayCount }} Row
                                    </span>
                                    <div class="flex items-center gap-1.5 flex-shrink-0">
                                        <button @click="bahasaPage = Math.max(1, bahasaPage - 1)"
                                            :disabled="bahasaPage <= 1"
                                            class="flex items-center justify-center w-7 h-7 rounded border border-[#D9DAD8] bg-white hover:bg-[#F5F5F3] disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-white transition-colors">
                                            <svg class="w-3.5 h-3.5 text-[#3D3D3A]" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <span
                                            class="text-[11px] sm:text-[12px] text-[#3D3D3A] whitespace-nowrap px-1.5 tabular-nums">
                                            Page {{ bahasaPage }} of {{ totalBahasaPages }}
                                        </span>
                                        <button @click="bahasaPage = Math.min(totalBahasaPages, bahasaPage + 1)"
                                            :disabled="bahasaPage >= totalBahasaPages"
                                            class="flex items-center justify-center w-7 h-7 rounded border border-[#D9DAD8] bg-white hover:bg-[#F5F5F3] disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-white transition-colors">
                                            <svg class="w-3.5 h-3.5 text-[#3D3D3A]" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-1.5 flex-shrink-0">
                                        <span class="text-[11px] sm:text-[12px] text-[#686964] whitespace-nowrap">Rows
                                            per page</span>
                                        <select v-model.number="bahasaRowsPerPage"
                                            class="border border-[#D9DAD8] rounded px-2 py-1 text-[11px] sm:text-[12px] text-[#3D3D3A] bg-white focus:outline-none focus:border-[#9e1f16]/40 cursor-pointer appearance-none pr-5"
                                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%23686694%22%3E%3Cpath fill-rule=%22evenodd%22 d=%22M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z%22 clip-rule=%22evenodd%22 /%3E%3C/svg%3E'); background-position: right 4px center; background-repeat: no-repeat; background-size: 14px;">
                                            <option :value="5">5</option>
                                            <option :value="10">10</option>
                                            <option :value="15">15</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ===== MOBILE ===== -->
                            <div class="sm:hidden">
                                <!-- Search mobile -->
                                <div class="relative mb-4">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#A8A8A4] pointer-events-none"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <input v-model="bahasaSearch" type="text" placeholder="Cari bahasa..."
                                        class="w-full border border-[#D9DAD8] rounded-lg pl-9 pr-3 py-2.5 text-[13px] text-[#3D3D3A] placeholder-[#A8A8A4] focus:outline-none focus:border-[#9e1f16]/40 transition-colors bg-white" />
                                </div>

                                <!-- Table mobile -->
                                <div v-if="bahasaMobileRows.length"
                                    class="border border-[#D9DAD8] rounded-lg overflow-hidden">
                                    <div
                                        class="bg-[#F5F5F3] px-3 py-2 text-[10px] font-semibold text-[#686964] uppercase tracking-wider border-b border-[#D9DAD8]">
                                        Bahasa / Wilayah
                                    </div>
                                    <div v-for="(item, i) in bahasaMobileRows" :key="`bm-${i}`"
                                        class="flex items-center gap-2.5 px-3 py-2.5"
                                        :class="i < bahasaMobileRows.length - 1 ? 'border-b border-[#E8E8E6]' : ''">
                                        <img :src="item.img_flag" :alt="item.negara_title"
                                            class="w-5 h-[13px] object-cover rounded-[2px] flex-shrink-0 shadow-sm"
                                            loading="lazy" />
                                        <span class="text-[12px] text-[#3D3D3A]">{{ item.negara_title }}</span>
                                    </div>
                                </div>
                                <!-- Empty state mobile -->
                                <div v-else class="border border-[#D9DAD8] rounded-lg px-4 py-10 text-center">
                                    <svg class="mx-auto mb-2 w-8 h-8 text-[#D9DAD8]" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <p class="text-[12px] text-[#686964]">Tidak ada bahasa ditemukan</p>
                                </div>

                                <!-- Pagination mobile -->
                                <div class="flex items-center justify-between mt-3 min-w-0 gap-2">
                                    <span class="text-[10px] text-[#686964] flex-shrink-0 tabular-nums">
                                        {{ bahasaDisplayCount }} Bahasa
                                    </span>
                                    <div class="flex items-center gap-1.5 flex-shrink-0">
                                        <button @click="bahasaPage = Math.max(1, bahasaPage - 1)"
                                            :disabled="bahasaPage <= 1"
                                            class="flex items-center justify-center w-6 h-6 rounded border border-[#D9DAD8] bg-white disabled:opacity-30 disabled:cursor-not-allowed">
                                            <svg class="w-3 h-3 text-[#3D3D3A]" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <span class="text-[10px] text-[#3D3D3A] tabular-nums">{{ bahasaPage }}/{{
                                            totalBahasaPages }}</span>
                                        <button @click="bahasaPage = Math.min(totalBahasaPages, bahasaPage + 1)"
                                            :disabled="bahasaPage >= totalBahasaPages"
                                            class="flex items-center justify-center w-6 h-6 rounded border border-[#D9DAD8] bg-white disabled:opacity-30 disabled:cursor-not-allowed">
                                            <svg class="w-3 h-3 text-[#3D3D3A]" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <span class="text-[10px] text-[#686964]">Per hal.</span>
                                        <select v-model.number="bahasaRowsPerPage"
                                            class="border border-[#D9DAD8] rounded px-1.5 py-1 text-[10px] text-[#3D3D3A] bg-white focus:outline-none appearance-none pr-3"
                                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%23686694%22%3E%3Cpath fill-rule=%22evenodd%22 d=%22M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z%22 clip-rule=%22evenodd%22 /%3E%3C/svg%3E'); background-position: right 2px center; background-repeat: no-repeat; background-size: 10px;">
                                            <option :value="5">5</option>
                                            <option :value="10">10</option>
                                            <option :value="15">15</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Mengapa Memilih FastTrack -->
                        <div v-if="keunggulan" class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    Mengapa Memilih FastTrack?
                                </h2>
                            </div>

                            <!-- Checklist 2 kolom -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2 mb-6">
                                <ul class="space-y-2">
                                    <li v-for="(item, i) in keunggulan.items_left" :key="`left-${i}`"
                                        class="flex items-start gap-2 text-[13px] text-[#3D3D3A]">
                                        <img src="/icons/ft-done.svg" class="w-4 h-4 mt-0.5 flex-shrink-0" alt="" />
                                        {{ item }}
                                    </li>
                                </ul>
                                <ul class="space-y-2">
                                    <li v-for="(item, i) in keunggulan.items_right" :key="`right-${i}`"
                                        class="flex items-start gap-2 text-[13px] text-[#3D3D3A]">
                                        <img src="/icons/ft-done.svg" class="w-4 h-4 mt-0.5 flex-shrink-0" alt="" />
                                        {{ item }}
                                    </li>
                                </ul>
                            </div>

                            <!-- Deskripsi -->
                            <div class="space-y-3">
                                <p v-for="(p, i) in keunggulan.description" :key="`desc-${i}`"
                                    class="text-[13px] leading-[1.8] text-[#3D3D3A]">
                                    {{ p }}
                                </p>
                            </div>
                        </div>

                        <!-- 4. Banner CTA Merah -->
                        <div v-if="bannerCta"
                            class="rounded-xl px-4 py-4 sm:px-5 sm:py-5 flex flex-col sm:flex-row sm:flex-nowrap items-stretch sm:items-center justify-between gap-3 sm:gap-4"
                            style="background-image: url('/images/card-arrow-item-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <div class="flex items-center gap-3 sm:gap-4 min-w-0 flex-1">
                                <span
                                    class="flex h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 items-center justify-center rounded-xl bg-white">
                                    <img src="/icons/ft-persons.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                </span>
                                <div class="min-w-0">
                                    <div class="text-[11px] sm:text-[12px] text-white/80 break-words">
                                        {{ product.name }}
                                    </div>
                                    <div
                                        class="text-[12px] sm:text-[15px] font-bold text-white leading-tight break-words">
                                        {{ bannerCta.text }}
                                    </div>
                                </div>
                            </div>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="flex-shrink-0 flex items-center justify-center gap-1.5 rounded-lg bg-white px-3 py-2 sm:px-4 sm:py-2.5 text-[11px] sm:text-[13px] font-semibold text-primary whitespace-nowrap hover:bg-white/90 transition-colors">
                                Hubungi Kami
                                <svg class="h-3 w-3 sm:h-3.5 sm:w-3.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>

                    </div>
                    <!-- END KIRI -->

                    <!-- KANAN: Sidebar -->
                    <div class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start min-w-0">
                        <!-- VIP Line Banner -->
                        <div class="rounded-2xl px-5 py-6 text-center overflow-hidden relative"
                            style="background-image: url('/images/card-arrow-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <div class="relative mb-4">
                                <div class="inline-block w-full rounded-xl border border-white/60 px-4 py-2.5">
                                    <span class="text-[14px] font-extrabold uppercase tracking-widest text-white">
                                        FASTTRACK – VIP LINE
                                    </span>
                                </div>
                            </div>
                            <p class="relative text-[14px] leading-[1.6] text-white/90 mb-5">
                                Pendirian Badan Usaha Selesai dalam<br />1 (Satu) Hari
                            </p>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                Pesan Layanan Sekarang
                            </a>
                            <div class="relative mt-3 text-[11px] text-white/60">* (S&K BERLAKU)</div>
                        </div>

                        <!-- Price Card -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <div
                                class="mb-4 flex items-center justify-between rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] px-3 py-2.5">
                                <span class="text-[13px] text-[#1A1B18]">{{ product.name }}</span>
                                <svg class="h-4 w-4 text-[#686964]" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <div class="text-[12px] text-[#686964] mb-1">Harga</div>
                            <div class="text-[32px] font-bold leading-none text-primary mb-1">
                                {{ product.price_label }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">*Harga final dikonfirmasi setelah konsultasi
                            </div>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-6 w-6 flex-shrink-0" alt="wa" />
                                Konsultasi Gratis via Whatsapp
                            </a>
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Soft fee Awal Terjamin
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Mudah Me-Trust Terjemahan
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Gratis Revisi
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END KANAN -->

                </div>
            </div>
        </section>

        <!-- Mobile Sticky Bottom Bar -->
        <div
            class="fixed bottom-0 left-0 right-0 z-50 lg:hidden bg-white border-t border-[#E8E8E6] px-4 py-3 flex items-center justify-between gap-3 shadow-lg">
            <div class="flex flex-col min-w-0">
                <span class="text-[10px] text-[#686964] uppercase tracking-wide font-semibold truncate">
                    {{ product.name }}
                </span>
                <span class="text-[18px] font-bold text-primary leading-tight">
                    {{ product.price_label }}
                </span>
            </div>
            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                class="flex-shrink-0 inline-flex items-center gap-2 rounded-lg bg-[#25D366] px-4 py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors">
                <img src="/icons/ft-wa.svg" class="h-5 w-5" alt="wa" />
                Hubungi Kami
            </a>
        </div>

        <div class="pb-16 lg:pb-0">
            <FooterCTA
                title="Tidak Menemukan Layanan yang Anda Cari?"
                description="Tim kami siap membantu Anda menemukan solusi yang tepat<br class='hidden sm:block' /> untuk kebutuhan legalitas bisnis Anda."
                :whatsapp-link="buildWhatsappLink('layanan yang tidak terdaftar')"
            />
        </div>
    </MainLayout>
</template>