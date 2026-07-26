<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { ref, computed } from "vue";
import { useI18n } from "vue-i18n";

import { useWhatsapp } from "@/Composables/useWhatsapp.js";
const { t, locale } = useI18n();

const props = defineProps({
    product: { type: Object, required: true },
    relatedProducts: { type: Array, default: () => [] },
});

const itemMeta = [
    { icon: "/icons/layanan/pembubaran.svg", path: "/penutupan-badan-usaha" },
    { icon: "/icons/layanan/pembubaran.svg", path: "/penutupan-badan-usaha" },
    { icon: "/icons/layanan/pembubaran.svg", path: "/penutupan-badan-usaha" },
];

const { buildWhatsappLink } = useWhatsapp("default");

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

    const targetIndex = props.index ?? (p.id ? p.id - 1 : 0);

    // Ambil meta berdasarkan index yang sudah aman
    const meta = itemMeta[targetIndex] || {};
    return {
        ...p,
        icon: meta.icon ?? "",
        path: meta.path ?? "",
        name: pick(p.name),
        excerpt: pick(p.excerpt),
        penjelasan_umum: pick(p.penjelasan_umum) ?? [],
        sections: pick(p.sections) ?? [],
        biaya_layanan_tabs: pick(p.biaya_layanan_tabs),
        biaya_layanan_single: pick(p.biaya_layanan_single),
        biaya_layanan_cards: pick(p.biaya_layanan_cards),
        dasar_hukum: pick(p.dasar_hukum) ?? [],
        faq: pick(p.faq) ?? [],
    };
});

const openSectionId = ref(null);
const toggleSection = (id) => {
    openSectionId.value = openSectionId.value === id ? null : id;
};

// Tab biaya layanan (untuk produk dengan PMDN/PMA)
const activeBiayaTab = ref(0);
const activeBiayaTabData = computed(
    () => localizedProduct.value?.biaya_layanan_tabs?.[activeBiayaTab.value] ?? {}
);
</script>

<template>
    <MainLayout>
        <!-- Hero -->
        <section class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px] bg-[#9e1f16]">
            <img src="/icons/left-arrow.svg"
                class="absolute right-0 -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block" alt="" />
            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]">
                <nav aria-label="Breadcrumb">
                    <div class="hidden sm:inline-flex items-center gap-2 rounded-md bg-white px-4 py-2">
                        <a href="/" class="text-[#9e1f16] hover:text-black transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
                            </svg>
                        </a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/layanan" class="text-sm font-medium text-[#9e1f16] hover:underline">{{ t("services.penutupanBadanUsahaDetail.breadcrumb.layanan") }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/penutupan-badan-usaha" class="text-sm font-medium text-[#9e1f16] hover:underline">{{ t("services.penutupanBadanUsahaDetail.breadcrumb.current") }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#9e1f16]">{{ localizedProduct.name }}</span>
                    </div>
                </nav>

                <!-- Center: Heading -->
                <div class="flex items-center gap-5">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-white shadow-md md:h-16 md:w-16 md:rounded-2xl">
                        <img
                            :src="localizedProduct.icon"
                            class="h-6 w-6 md:h-9 md:w-9"
                            style="
                                filter: brightness(0) saturate(100%) invert(14%)
                                    sepia(82%) saturate(4150%)
                                    hue-rotate(352deg) brightness(91%)
                                    contrast(93%);
                            "
                            alt=""
                        />
                    </div>
                    <h1 class="text-base font-extrabold leading-tight text-white sm:text-2xl lg:text-2xl max-w-[800px] line-clamp-2">
                        {{ localizedProduct.name }}
                    </h1>
                </div>

                <!-- Bottom: Back button -->
                <div>
                    <a href="/penutupan-badan-usaha" class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ t("services.penutupanBadanUsahaDetail.back") }}
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT -->
        <section class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[1fr_300px] xl:grid-cols-[1fr_320px] min-w-0">

                    <!-- ===== KIRI ===== -->
                    <div class="flex flex-col gap-5 min-w-0">

                        <!-- 1. Penjelasan Umum -->
                        <div v-if="localizedProduct.penjelasan_umum?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ t("services.penutupanBadanUsahaDetail.sections.penjelasan") }}</h2>
                            </div>
                            <div class="space-y-4">
                                <template v-for="(block, i) in localizedProduct.penjelasan_umum" :key="`pu-${i}`">
                                    <template v-if="typeof block === 'object'">
                                        <p v-if="block.type === 'title'"
                                            class="text-[14px] font-bold text-[#1A1B18] leading-snug pt-2">
                                            {{ block.text }}
                                        </p>
                                        <ul v-else-if="block.type === 'bullets'" class="space-y-1.5 pl-1">
                                            <li v-for="(item, bi) in block.items" :key="`bu-${bi}`"
                                                class="flex items-start gap-2 text-[14px] leading-[1.7] text-[#3D3D3A]">
                                                <span class="mt-[7px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                                <span>{{ item }}</span>
                                            </li>
                                        </ul>
                                    </template>
                                    <p v-else class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">{{ block }}</p>
                                </template>
                            </div>
                        </div>

                        <!-- 2. Sections dinamis -->
                        <template v-for="section in localizedProduct.sections" :key="section.id">

                            <!-- Type: list_check -->
                            <div v-if="section.type === 'list_check'"
                                class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                <div class="flex items-center gap-3 mb-5">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ section.title }}</h2>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div v-for="(item, i) in section.items" :key="`lc-${i}`"
                                        class="flex items-start gap-3 rounded-xl border border-[#E8E8E6] p-4">
                                        <img src="/icons/ft-done.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="" />
                                        <div>
                                            <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-1">{{ item.title }}</p>
                                            <p class="text-[12px] leading-[1.6] text-[#686964]">{{ item.desc }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Type: numbered_accordion -->
                            <div v-else-if="section.type === 'numbered_accordion'"
                                class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                <button @click="toggleSection(section.id)"
                                    class="w-full flex items-center justify-between gap-3 text-left">
                                    <div class="flex items-center gap-3">
                                        <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                        <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ section.title }}</h2>
                                    </div>
                                    <svg class="h-5 w-5 flex-shrink-0 text-[#686964] transition-transform duration-200"
                                        :class="openSectionId === section.id ? 'rotate-180' : ''"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div v-if="openSectionId === section.id" class="mt-5 space-y-4">
                                    <div v-for="(item, i) in section.items" :key="`na-${i}`" class="flex gap-4">
                                        <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary text-white text-[12px] font-bold mt-0.5">
                                            {{ i + 1 }}
                                        </span>
                                        <div class="flex-1">
                                            <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-1">{{ item.title }}</p>
                                            <p v-if="item.desc" class="text-[13px] leading-[1.6] text-[#3D3D3A] mb-2">{{ item.desc }}</p>
                                            <ul v-if="item.bullets?.length" class="space-y-1">
                                                <li v-for="(b, bi) in item.bullets" :key="`nab-${bi}`"
                                                    class="flex items-start gap-2 text-[12px] leading-[1.6] text-[#3D3D3A]">
                                                    <span class="mt-[6px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                                    <span>{{ b }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Type: numbered_list -->
                            <div v-else-if="section.type === 'numbered_list'"
                                class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                <div class="flex items-center gap-3 mb-5">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ section.title }}</h2>
                                </div>
                                <div class="space-y-5">
                                    <div v-for="(item, i) in section.items" :key="`nl-${i}`">
                                        <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-2">
                                            {{ i + 1 }}. {{ item.title }}
                                        </p>
                                        <p v-if="item.desc" class="text-[13px] leading-[1.6] text-[#3D3D3A] mb-2 pl-4">{{ item.desc }}</p>
                                        <ul v-if="item.bullets?.length" class="space-y-1 pl-4">
                                            <li v-for="(b, bi) in item.bullets" :key="`nlb-${bi}`"
                                                class="flex items-start gap-2 text-[12px] leading-[1.6] text-[#3D3D3A]">
                                                <span class="mt-[6px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                                <span>{{ b }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Type: numbered_bold -->
                            <div v-else-if="section.type === 'numbered_bold'"
                                class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                <div class="flex items-center gap-3 mb-5">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ section.title }}</h2>
                                </div>
                                <div class="space-y-5">
                                    <div v-for="(item, i) in section.items" :key="`nb-${i}`" class="flex gap-4">
                                        <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary text-white text-[12px] font-bold mt-0.5">
                                            {{ i + 1 }}
                                        </span>
                                        <div class="flex-1">
                                            <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-1">{{ item.title }}</p>
                                            <p v-if="item.desc" class="text-[13px] leading-[1.6] text-[#3D3D3A] mb-2">{{ item.desc }}</p>
                                            <ul v-if="item.bullets?.length" class="space-y-1">
                                                <li v-for="(b, bi) in item.bullets" :key="`nbb-${bi}`"
                                                    class="flex items-start gap-2 text-[12px] leading-[1.6] text-[#3D3D3A]">
                                                    <span class="mt-[6px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                                    <span>{{ b }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Type: grid_check -->
                            <div v-else-if="section.type === 'grid_check'"
                                class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                <div class="flex items-center gap-3 mb-5">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ section.title }}</h2>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                                    <div v-for="(item, i) in section.items" :key="`gc-${i}`" class="flex items-start gap-3">
                                        <img src="/icons/ft-done.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="" />
                                        <div>
                                            <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-1">{{ item.title }}</p>
                                            <p class="text-[12px] leading-[1.6] text-[#686964]">{{ item.desc }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </template>

                        <!-- 3. Biaya Layanan -->
<div class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
            <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ t("services.penutupanBadanUsahaDetail.sections.biaya_layanan") }}</h2>
        </div>
        <!-- Tab buttons (jika ada biaya_layanan_tabs) -->
        <div v-if="localizedProduct.biaya_layanan_tabs?.length"
            class="inline-flex rounded-lg border border-[#E8E8E6] overflow-hidden">
            <button
                v-for="(tab, ti) in localizedProduct.biaya_layanan_tabs"
                :key="`tab-${ti}`"
                @click="activeBiayaTab = ti"
                class="px-4 py-1.5 text-[12px] font-bold transition-colors"
                :class="activeBiayaTab === ti
                    ? 'bg-primary text-white'
                    : 'bg-white text-[#686964] hover:bg-[#F7F7F5]'">
                {{ tab.label }}
            </button>
        </div>
    </div>

    <!-- Mode: tabs (id 1 — PMDN/PMA) -->
    <template v-if="localizedProduct.biaya_layanan_tabs?.length">
        <div class="rounded-xl border border-[#E8E8E6] p-5">
            <p class="text-[13px] font-bold text-[#1A1B18] mb-1">{{ activeBiayaTabData.nama }}</p>
            <p class="text-[11px] text-[#686964] mb-0.5">{{ t("services.penutupanBadanUsahaDetail.plans.mulai_dari") }}</p>
            <p class="text-[24px] font-bold text-primary leading-tight mb-2">{{ activeBiayaTabData.harga }}</p>
            <div v-if="activeBiayaTabData.gratis_konsultasi" class="flex items-center gap-1.5 mb-4">
                <img src="/icons/ft-done.svg" class="h-4 w-4 flex-shrink-0" alt="" />
                <span class="text-[11px] text-[#3D3D3A]">{{ t("services.penutupanBadanUsahaDetail.plans.gratis_konsultasi") }}</span>
            </div>
            <hr class="border-[#E8E8E6] mb-4" />
            <div v-if="activeBiayaTabData.mendapatkan?.length" class="mb-4">
                <p class="text-[13px] font-bold text-[#1A1B18] mb-3">{{ t("services.penutupanBadanUsahaDetail.plans.mendapatkan") }}</p>
                <ul class="space-y-2.5">
                    <li v-for="(m, mi) in activeBiayaTabData.mendapatkan" :key="`m-${mi}`"
                        class="flex items-start gap-2">
                        <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                        <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{ m }}</span>
                    </li>
                </ul>
            </div>
            <div v-if="activeBiayaTabData.termasuk?.length" class="mb-5">
                <p class="text-[13px] font-bold text-[#1A1B18] mb-3">{{ t("services.penutupanBadanUsahaDetail.plans.termasuk") }}</p>
                <ul class="space-y-2">
                    <li v-for="(t, ti) in activeBiayaTabData.termasuk" :key="`t-${ti}`"
                        class="flex items-start gap-2">
                        <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                        <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{ t }}</span>
                    </li>
                </ul>
            </div>
            <a :href="buildWhatsappLink(activeBiayaTabData.nama)"
                target="_blank" rel="noopener noreferrer"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-3 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors">
                {{ t("services.penutupanBadanUsahaDetail.plans.pesan") }}
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </template>

    <!-- Mode: single card (id 2) -->
    <template v-else-if="localizedProduct.biaya_layanan_single">
        <div class="rounded-xl border border-[#E8E8E6] p-5">
            <p class="text-[13px] font-bold text-[#1A1B18] mb-1">{{ localizedProduct.biaya_layanan_single.nama }}</p>
            <p class="text-[11px] text-[#686964] mb-0.5">{{ t("services.penutupanBadanUsahaDetail.plans.mulai_dari") }}</p>
            <p class="text-[24px] font-bold text-primary leading-tight mb-2">{{ localizedProduct.biaya_layanan_single.harga }}</p>
            <div v-if="localizedProduct.biaya_layanan_single.gratis_konsultasi" class="flex items-center gap-1.5 mb-4">
                <img src="/icons/ft-done.svg" class="h-4 w-4 flex-shrink-0" alt="" />
                <span class="text-[11px] text-[#3D3D3A]">{{ t("services.penutupanBadanUsahaDetail.plans.gratis_konsultasi") }}</span>
            </div>
            <hr class="border-[#E8E8E6] mb-4" />
            <div v-if="localizedProduct.biaya_layanan_single.mendapatkan?.length" class="mb-4">
                <p class="text-[13px] font-bold text-[#1A1B18] mb-3">{{ t("services.penutupanBadanUsahaDetail.plans.mendapatkan") }}</p>
                <ul class="space-y-2.5">
                    <li v-for="(m, mi) in localizedProduct.biaya_layanan_single.mendapatkan" :key="`sm-${mi}`"
                        class="flex items-start gap-2">
                        <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                        <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{ m }}</span>
                    </li>
                </ul>
            </div>
            <div v-if="localizedProduct.biaya_layanan_single.termasuk?.length" class="mb-5">
                <p class="text-[13px] font-bold text-[#1A1B18] mb-3">{{ t("services.penutupanBadanUsahaDetail.plans.termasuk") }}</p>
                <ul class="space-y-2">
                    <li v-for="(t, ti) in localizedProduct.biaya_layanan_single.termasuk" :key="`st-${ti}`"
                        class="flex items-start gap-2">
                        <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                        <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{ t }}</span>
                    </li>
                </ul>
            </div>
            <a :href="buildWhatsappLink(localizedProduct.biaya_layanan_single.nama)"
                target="_blank" rel="noopener noreferrer"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-3 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors">
                {{ t("services.penutupanBadanUsahaDetail.plans.pesan") }}
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </template>

    <!-- Mode: 2 cards side by side (id 3) -->
    <template v-else-if="localizedProduct.biaya_layanan_cards?.length">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div v-for="(card, ci) in localizedProduct.biaya_layanan_cards" :key="`blc-${ci}`"
                class="rounded-xl border border-[#E8E8E6] p-5 flex flex-col">
                <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-1">{{ card.nama }}</p>
                <p class="text-[11px] text-[#686964] mb-0.5">{{ t("services.penutupanBadanUsahaDetail.plans.mulai_dari") }}</p>
                <p class="text-[22px] font-bold text-primary leading-tight mb-2">{{ card.harga }}</p>
                <div v-if="card.gratis_konsultasi" class="flex items-center gap-1.5 mb-4">
                    <img src="/icons/ft-done.svg" class="h-4 w-4 flex-shrink-0" alt="" />
                    <span class="text-[11px] text-[#3D3D3A]">{{ t("services.penutupanBadanUsahaDetail.plans.gratis_konsultasi") }}</span>
                </div>
                <hr class="border-[#E8E8E6] mb-4" />
                <div v-if="card.mendapatkan?.length" class="mb-4">
                    <p class="text-[12px] font-bold text-[#1A1B18] mb-2">{{ t("services.penutupanBadanUsahaDetail.plans.mendapatkan") }}</p>
                    <ul class="space-y-2">
                        <li v-for="(m, mi) in card.mendapatkan" :key="`m-${ci}-${mi}`"
                            class="flex items-start gap-2">
                            <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                            <span class="text-[12px] leading-[1.6] text-[#3D3D3A]">{{ m }}</span>
                        </li>
                    </ul>
                </div>
                <div v-if="card.termasuk?.length" class="mb-5">
                    <p class="text-[12px] font-bold text-[#1A1B18] mb-2">{{ t("services.penutupanBadanUsahaDetail.plans.termasuk") }}</p>
                    <ul class="space-y-2">
                        <li v-for="(t, ti) in card.termasuk" :key="`t-${ci}-${ti}`"
                            class="flex items-start gap-2">
                            <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                            <span class="text-[12px] leading-[1.6] text-[#3D3D3A]">{{ t }}</span>
                        </li>
                    </ul>
                </div>
                <div class="mt-auto pt-4">
                    <a :href="buildWhatsappLink(card.nama)"
                        target="_blank" rel="noopener noreferrer"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-3 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors">
                        {{ t("services.penutupanBadanUsahaDetail.plans.pesan") }}
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </template>
</div>

                        <!-- 4. Dasar Hukum (accordion) -->
                        <div v-if="localizedProduct.dasar_hukum?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <button @click="toggleSection('dasar-hukum')"
                                class="w-full flex items-center justify-between gap-3 text-left">
                                <div class="flex items-center gap-3">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ t("services.penutupanBadanUsahaDetail.sections.dasar_hukum") }}</h2>
                                </div>
                                <svg class="h-5 w-5 flex-shrink-0 text-[#686964] transition-transform duration-200"
                                    :class="openSectionId === 'dasar-hukum' ? 'rotate-180' : ''"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <ul v-if="openSectionId === 'dasar-hukum'" class="mt-5 space-y-4">
                                <li v-for="(hukum, i) in localizedProduct.dasar_hukum" :key="`hukum-${i}`"
                                    class="flex items-start gap-4">
                                    <span class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-[#ddffe3]">
                                        <img src="/icons/ft-save.svg" class="w-4 h-4" alt="" />
                                    </span>
                                    <span class="text-[13px] leading-[1.7] text-[#3D3D3A] text-justify">{{ hukum }}</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- ===== END KIRI ===== -->

                    <!-- ===== KANAN: Sidebar ===== -->
                    <div class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start min-w-0">

                        <!-- VIP Line Banner -->
                        <div class="rounded-2xl px-5 py-6 text-center overflow-hidden relative"
                            style="background-image: url('/images/card-arrow-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <div class="relative mb-4">
                                <div class="inline-block w-full rounded-xl border border-white/60 px-4 py-2.5">
                                    <span class="text-[14px] font-extrabold uppercase tracking-widest text-white">{{ t("services.penutupanBadanUsahaDetail.sidebar.vip_title") }}</span>
                                </div>
                            </div>
                            <p class="relative text-[14px] leading-[1.6] text-white/90 mb-5" v-html="t('services.penutupanBadanUsahaDetail.sidebar.vip_desc')"></p>
                            <a :href="buildWhatsappLink(localizedProduct.name)" target="_blank" rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{ t("services.penutupanBadanUsahaDetail.sidebar.vip_cta") }}
                            </a>
                            <div class="relative mt-3 text-[11px] text-white/60">{{ t("services.penutupanBadanUsahaDetail.sidebar.vip_note") }}</div>
                        </div>

                        <!-- Price Card -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <div class="mb-3 inline-flex items-center gap-1.5 rounded-full bg-[#FFF0EF] px-3 py-1">
                                <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                <span class="text-[11px] font-semibold text-primary truncate max-w-[160px]">{{ localizedProduct.name }}</span>
                            </div>
                            <div class="text-[12px] text-[#686964] mb-1 mt-2">{{ t("services.penutupanBadanUsahaDetail.sidebar.price_label") }}</div>
                            <div class="text-[32px] font-bold leading-none text-primary mb-1">{{ localizedProduct.price_label }}</div>
                            <div class="text-[11px] text-[#686964] mb-4">{{ t("services.penutupanBadanUsahaDetail.sidebar.price_note") }}</div>
                            <a :href="buildWhatsappLink(localizedProduct.name)" target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary py-2.5 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors mb-2">
                                {{ t("services.penutupanBadanUsahaDetail.plans.pesan") }}
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                            <a :href="buildWhatsappLink(localizedProduct.name)" target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg border border-[#E8E8E6] py-2.5 text-[13px] font-semibold text-[#3D3D3A] hover:bg-[#F7F7F5] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{ t("services.penutupanBadanUsahaDetail.sidebar.konsultasi_cta") }}
                            </a>
                        </div>

                        <!-- Layanan Terkait -->
                        <div v-if="relatedProducts.length" class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">{{ t("services.penutupanBadanUsahaDetail.sidebar.related_title") }}</h3>
                            <div class="flex flex-col gap-3">
                                <a v-for="(related, index) in relatedProducts.slice(0, 3)" :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex items-center gap-3 rounded-xl border border-[#E8E8E6] bg-white p-3 hover:border-primary/30 hover:shadow-sm transition-all">
                                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-[#FFF0EF]">
                                        <!-- <img src="/icons/ft-persons.svg" class="w-5 h-5" alt="" /> -->
                                         <img
                            :src="localizedProduct.icon"
                            class="w-9 h-9"
                            style="
                                filter: brightness(0) saturate(100%) invert(14%)
                                    sepia(82%) saturate(4150%)
                                    hue-rotate(352deg) brightness(91%)
                                    contrast(93%);
                            "
                            alt=""
                        />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[13px] font-semibold text-[#1A1B18] group-hover:text-primary transition-colors leading-snug line-clamp-2">
                                            {{ pick(related.name) }}
                                        </p>
                                        <p class="text-[11px] text-[#686964] mt-0.5">{{ t("services.penutupanBadanUsahaDetail.sidebar.related_from") }} {{ related.price_label }}</p>
                                    </div>
                                    <svg class="h-4 w-4 flex-shrink-0 text-[#686964] group-hover:text-primary transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </div>
                    <!-- ===== END KANAN ===== -->

                </div>
            </div>
        </section>

        <FooterCTA
            :title="t('services.penutupanBadanUsahaDetail.footer.title')"
            :description="t('services.penutupanBadanUsahaDetail.footer.desc')"
            :button-text="t('services.penutupanBadanUsahaDetail.footer.cta')"
            :whatsapp-link="buildWhatsappLink(localizedProduct.name)"
        />
    </MainLayout>
</template>