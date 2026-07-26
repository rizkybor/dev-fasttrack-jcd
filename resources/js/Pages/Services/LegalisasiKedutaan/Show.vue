<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { ref, computed, watch } from "vue";
import { useI18n } from "vue-i18n";

import { useWhatsapp } from "@/Composables/useWhatsapp.js";
const { t, locale } = useI18n();

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

const { buildWhatsappLink: waLink } = useWhatsapp("default");
const buildWhatsappLink = (productName, jenis) => {
    const jenisLabel = jenis === "perpanjangan" ? "Perpanjangan" : "Baru";
    return waLink(`${productName} (${jenisLabel})`);
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
        excerpt: pick(p.excerpt),
        baru: pick(p.baru),
        perpanjangan: pick(p.perpanjangan),
        faq: pick(p.faq) ?? [],
        footer_cta: pick(p.footer_cta),
    };
});

const product = localizedProduct;

const jenisPengajuan = ref("baru");
const hasToggle = computed(() => !!product.value?.perpanjangan);
const currentData = computed(() => product.value?.[jenisPengajuan.value] ?? {});

// Deteksi format negara: grouped (object) vs flat (string)
const isNegaraGrouped = computed(() => {
    const items = currentData.value.negara_kawasan;
    if (!items?.length) return false;
    return typeof items[0] === "object" && Array.isArray(items[0].negara);
});

// Breadcrumb dinamis
const categoryPath = computed(() => product.value?.category_path ?? "/legalisasi-kedutaan");
const categoryName = computed(() => product.value?.category_name ?? pick({
    id: "Legalisasi Kedutaan / Apostilled",
    en: "Embassy Legalization / Apostilled",
    zh: "使馆认证/海牙认证",
}));

// Footer CTA dinamis
const defaultFooterCta = computed(() => pick({
    id: {
        title: "Butuh Konsultasi Soal Legalisasi Dokumen?",
        subtitle: "Tim Fasttrack siap membantu Anda menyelesaikan proses legalisasi dokumen dengan cepat dan tepat.",
        button_text: "Chat Langsung via WhatsApp",
        wa_message: "layanan yang tidak terdaftar",
    },
    en: {
        title: "Need Consultation on Document Legalization?",
        subtitle: "The Fasttrack team is ready to help you complete the document legalization process quickly and accurately.",
        button_text: "Chat Directly via WhatsApp",
        wa_message: "an unlisted service",
    },
    zh: {
        title: "需要文件认证方面的咨询吗？",
        subtitle: "Fasttrack团队随时准备协助您快速且准确地完成文件认证流程。",
        button_text: "直接通过WhatsApp聊天",
        wa_message: "未列出的服务",
    },
}));
const footerCta = computed(() => product.value?.footer_cta ?? defaultFooterCta.value);

// ===== NEGARA ANGGOTA: Pagination & Search =====
const negaraSearch = ref("");
const negaraPage = ref(1);
const negaraRowsPerPage = ref(10);

const negaraItemsPerPage = computed(() => negaraRowsPerPage.value * 3);

const filteredNegara = computed(() => {
    const data = currentData.value.negara_anggota ?? [];
    if (!negaraSearch.value.trim()) return data;
    const q = negaraSearch.value.toLowerCase().trim();
    return data.filter(n => n.negara_title.toLowerCase().includes(q));
});

const totalNegaraPages = computed(() => {
    return Math.max(1, Math.ceil(filteredNegara.value.length / negaraItemsPerPage.value));
});

const paginatedNegara = computed(() => {
    const start = (negaraPage.value - 1) * negaraItemsPerPage.value;
    return filteredNegara.value.slice(start, start + negaraItemsPerPage.value);
});

const negaraDisplayCount = computed(() => paginatedNegara.value.length);

// Desktop: chunk into rows of 3
const negaraRows = computed(() => {
    const items = paginatedNegara.value;
    const rows = [];
    for (let i = 0; i < items.length; i += 3) {
        const row = items.slice(i, i + 3);
        while (row.length < 3) row.push(null);
        rows.push(row);
    }
    return rows;
});

// Mobile: chunk into rows of 2
const negaraMobileRows = computed(() => {
    const items = paginatedNegara.value;
    const rows = [];
    for (let i = 0; i < items.length; i += 2) {
        const row = items.slice(i, i + 2);
        while (row.length < 2) row.push(null);
        rows.push(row);
    }
    return rows;
});

watch(negaraSearch, () => { negaraPage.value = 1; });
watch(negaraRowsPerPage, () => { negaraPage.value = 1; });
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section class="relative overflow-hidden min-h-[240px] sm:min-h-[320px] lg:min-h-[360px] bg-[#9e1f16]">
            <img src="/icons/left-arrow.svg"
                class="absolute right-0 -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block" alt="" />
            <div
                class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[240px] sm:min-h-[320px] lg:min-h-[360px] min-w-0">
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb">
                    <div class="hidden sm:inline-flex items-center gap-2 rounded-md bg-white px-4 py-2">
                        <a href="/" class="text-[#9e1f16] hover:text-black transition flex-shrink-0">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
                            </svg>
                        </a>
                        <svg class="h-3 w-3 text-[#9e1f16] flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/layanan"
                            class="text-xs sm:text-sm font-medium text-[#9e1f16] hover:underline whitespace-nowrap flex-shrink-0">{{
                                t("services.legalisasiKedutaanDetail.breadcrumb.layanan")
                            }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16] flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a :href="categoryPath"
                            class="text-xs sm:text-sm font-medium text-[#9e1f16] hover:underline whitespace-nowrap flex-shrink-0">{{
                                categoryName }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16] flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-xs sm:text-sm font-medium text-[#9e1f16] truncate">{{ product.name }}</span>
                    </div>
                </nav>

                <div class="flex items-center gap-5">
                    <div
                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-white shadow-md md:h-16 md:w-16 md:rounded-2xl">
                        <img :src="product.icon ?? '/icons/ft-persons.svg'" class="h-6 w-6 md:h-9 md:w-9" alt="" />
                    </div>
                    <h1
                        class="text-base font-extrabold leading-tight text-white sm:text-2xl lg:text-2xl max-w-[800px] line-clamp-2">
                        {{ product.name }}
                    </h1>
                </div>

                <div>
                    <a :href="categoryPath"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ t("services.legalisasiKedutaanDetail.back") }}
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section id="edukasi" class="bg-[#F7F7F5] py-8 sm:py-12 lg:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-6 lg:gap-8 lg:grid-cols-[1fr_280px] xl:grid-cols-[1fr_300px] min-w-0">

                    <!-- ===== KIRI: Konten Utama ===== -->
                    <div class="flex flex-col gap-4 sm:gap-6 min-w-0">

                        <!-- 0. Toggle Jenis Pengajuan -->
                        <div v-if="hasToggle" class="rounded-2xl border border-[#E8E8E6] bg-white p-5 sm:p-8">
                            <div class="flex items-center gap-3 mb-4 sm:mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                <h2 class="text-[13px] sm:text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ t("services.legalisasiKedutaanDetail.sections.toggle_title") }}
                                </h2>
                            </div>
                            <div class="inline-flex rounded-full border border-[#E8E8E6] p-1 bg-[#F7F7F5]">
                                <button @click="jenisPengajuan = 'baru'"
                                    class="px-4 sm:px-5 py-2 rounded-full text-[12px] sm:text-[13px] font-semibold transition-colors"
                                    :class="jenisPengajuan === 'baru' ? 'bg-primary text-white' : 'text-[#686964] hover:text-black'">{{ t("services.legalisasiKedutaanDetail.toggle.baru") }}</button>
                                <button @click="jenisPengajuan = 'perpanjangan'"
                                    class="px-4 sm:px-5 py-2 rounded-full text-[12px] sm:text-[13px] font-semibold transition-colors"
                                    :class="jenisPengajuan === 'perpanjangan' ? 'bg-primary text-white' : 'text-[#686964] hover:text-black'">{{ t("services.legalisasiKedutaanDetail.toggle.perpanjangan") }}</button>
                            </div>
                        </div>

                        <!-- 1. Penjelasan Umum -->
                        <div v-if="currentData.penjelasan_umum?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5 sm:p-8">
                            <div class="flex items-center gap-3 mb-4 sm:mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                <h2 class="text-[13px] sm:text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ t("services.legalisasiKedutaanDetail.sections.penjelasan") }}
                                </h2>
                            </div>
                            <div class="space-y-3 sm:space-y-4">
                                <p v-for="(paragraph, index) in currentData.penjelasan_umum"
                                    :key="`penjelasan-${index}`"
                                    class="text-[13px] sm:text-[14px] leading-[1.8] text-[#3D3D3A] text-justify break-words">
                                    {{ paragraph }}</p>
                            </div>
                        </div>

                        <!-- 2. Kapan Diperlukan? -->
                        <div v-if="currentData.kapan_diperlukan?.title"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5 sm:p-8">
                            <div class="flex items-center gap-3 mb-2">
                                <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                <h2 class="text-[13px] sm:text-[15px] font-bold text-black">
                                    {{ currentData.kapan_diperlukan.title }}
                                </h2>
                            </div>
                            <p class="text-[12px] sm:text-[13px] text-[#686964] mb-4 sm:mb-5">
                                {{ currentData.kapan_diperlukan.subtitle }}
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2.5 sm:gap-x-8 sm:gap-y-3">
                                <div v-for="(item, i) in currentData.kapan_diperlukan.items" :key="`kapan-${i}`"
                                    class="flex items-start gap-2.5 min-w-0">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    <span
                                        class="text-[12px] sm:text-[13px] leading-[1.6] text-[#3D3D3A] break-words min-w-0">{{
                                            item }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Dokumen yang Dapat Dilegalisasi -->
                        <div v-if="currentData.dokumen_dapat_dilegalisasi?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5 sm:p-8">
                            <div class="flex items-center gap-3 mb-2">
                                <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                <h2 class="text-[13px] sm:text-[15px] font-bold text-black">
                                    {{ t("services.legalisasiKedutaanDetail.sections.dokumen_dilegalisasi") }}
                                </h2>
                            </div>
                            <p class="text-[12px] sm:text-[13px] text-[#686964] mb-4 sm:mb-5">
                                {{ currentData.dokumen_dapat_dilegalisasi_subtitle ?? t("services.legalisasiKedutaanDetail.sections.dokumen_dilegalisasi_subtitle_default") }}
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3">
                                <div v-for="(doc, i) in currentData.dokumen_dapat_dilegalisasi" :key="`dokleg-${i}`"
                                    class="flex items-center gap-3 rounded-xl border border-[#E8E8E6] px-3 py-2.5 sm:px-4 sm:py-3 min-w-0">
                                    <span
                                        class="flex h-7 w-7 sm:h-8 sm:w-8 flex-shrink-0 items-center justify-center rounded-lg bg-[#FEF3F2]">
                                        <img src="/icons/ft-docs.svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4" alt="" />
                                    </span>
                                    <span
                                        class="text-[12px] sm:text-[13px] leading-[1.5] text-[#3D3D3A] break-words min-w-0">{{
                                            doc }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Negara (FLEXIBLE: grouped kawasan OR flat list) -->
                        <div v-if="currentData.negara_kawasan?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5 sm:p-8">
                            <div class="flex items-center gap-3 mb-3">
                                <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                <h2 class="text-[13px] sm:text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ currentData.negara_title ?? t("services.legalisasiKedutaanDetail.sections.negara_title_default") }}
                                </h2>
                            </div>
                            <p v-if="currentData.negara_kawasan_subtitle"
                                class="text-[13px] sm:text-[14px] leading-[1.7] text-[#3D3D3A] mb-5 sm:mb-6 break-words">
                                {{ currentData.negara_kawasan_subtitle }}
                            </p>

                            <!-- FORMAT GROUPED (Legalisasi Kedutaan) -->
                            <template v-if="isNegaraGrouped">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-4">
                                    <div v-for="(kawasan, ki) in currentData.negara_kawasan" :key="`kawasan-${ki}`"
                                        class="rounded-2xl border border-[#E8E8E6] p-4 sm:p-5 min-w-0">
                                        <div class="flex items-center gap-2.5 mb-3 sm:mb-4">
                                            <span
                                                class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center text-base sm:text-[18px]">🌐</span>
                                            <span class="text-[13px] sm:text-[15px] font-bold text-[#1A1B18]">{{
                                                kawasan.label }}</span>
                                        </div>
                                        <div class="flex flex-wrap gap-1.5 sm:gap-2">
                                            <span v-for="(negara, ni) in kawasan.negara" :key="`negara-${ki}-${ni}`"
                                                class="rounded-full bg-[#F5F5F3] px-3 py-1.5 sm:px-4 sm:py-2 text-[11px] sm:text-[12px] text-[#3D3D3A]">{{
                                                    negara }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="currentData.negara_catatan?.length"
                                    class="rounded-2xl bg-[#FFF5F5] border border-[#FECACA] px-4 py-3 sm:px-5 sm:py-4">
                                    <div class="flex flex-col gap-2 sm:gap-2.5">
                                        <div v-for="(note, ni) in currentData.negara_catatan" :key="`note-${ni}`"
                                            class="flex items-start gap-2 sm:gap-3 min-w-0">
                                            <span v-if="ni === 0" class="flex-shrink-0 mt-0.5">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-[#9e1f16]"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                                                    <line x1="12" y1="9" x2="12" y2="13" />
                                                    <line x1="12" y1="17" x2="12.01" y2="17" />
                                                </svg>
                                            </span>
                                            <span v-else class="flex-shrink-0 w-3.5 sm:w-4"></span>
                                            <span
                                                class="flex-shrink-0 text-[11px] sm:text-[13px] font-semibold text-[#9e1f16] min-w-[24px] sm:min-w-[28px]">
                                                {{ note.split(' ')[0] }}
                                            </span>
                                            <span
                                                class="text-[11px] sm:text-[13px] leading-[1.6] text-[#9e1f16] min-w-0 break-words">
                                                {{ note.split(' ').slice(1).join(' ') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- FORMAT FLAT (Apostille) -->
                            <template v-else>
                                <div class="flex flex-wrap gap-1.5 sm:gap-2 mb-4">
                                    <span v-for="(negara, ni) in currentData.negara_kawasan" :key="`negara-flat-${ni}`"
                                        class="rounded-full bg-[#F5F5F3] px-3 py-1.5 sm:px-4 sm:py-2 text-[11px] sm:text-[12px] text-[#3D3D3A]">{{
                                            negara }}</span>
                                </div>
                                <div v-if="currentData.negara_catatan?.length"
                                    class="rounded-2xl bg-[#FFF5F5] border border-[#FECACA] px-4 py-3 sm:px-5 sm:py-4">
                                    <div class="flex flex-col gap-2 sm:gap-2.5">
                                        <div v-for="(note, ni) in currentData.negara_catatan" :key="`note-flat-${ni}`"
                                            class="flex items-start gap-2 sm:gap-3 min-w-0">
                                            <span v-if="ni === 0" class="flex-shrink-0 mt-0.5">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-[#9e1f16]"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                                                    <line x1="12" y1="9" x2="12" y2="13" />
                                                    <line x1="12" y1="17" x2="12.01" y2="17" />
                                                </svg>
                                            </span>
                                            <span v-else class="flex-shrink-0 w-3.5 sm:w-4"></span>
                                            <span
                                                class="flex-shrink-0 text-[11px] sm:text-[13px] font-semibold text-[#9e1f16] min-w-[24px] sm:min-w-[28px]">
                                                {{ note.split(' ')[0] }}
                                            </span>
                                            <span
                                                class="text-[11px] sm:text-[13px] leading-[1.6] text-[#9e1f16] min-w-0 break-words">
                                                {{ note.split(' ').slice(1).join(' ') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- ============================================ -->
                        <!-- 4b. NEGARA ANGGOTA: Table + Pagination + Search -->
                        <!-- ============================================ -->
                        <div v-if="currentData.negara_anggota?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5 sm:p-8">
                            <div class="flex items-center gap-3 mb-2">
                                <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                <h2 class="text-[13px] sm:text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ currentData.negara_anggota_title ?? t("services.legalisasiKedutaanDetail.sections.negara_anggota_title_default") }}
                                </h2>
                            </div>
                            <p v-if="currentData.negara_anggota_subtitle"
                                class="text-[12px] sm:text-[13px] leading-[1.7] text-[#686964] mb-5 sm:mb-6 break-words">
                                {{ currentData.negara_anggota_subtitle }}
                            </p>

                            <!-- Search (full width, di atas tabel) -->
                            <div class="relative mb-4 hidden sm:block">
                                <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-[#A8A8A4] pointer-events-none"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input v-model="negaraSearch" type="text" :placeholder="t('services.legalisasiKedutaanDetail.table.search_placeholder')"
                                    class="w-full border border-[#D9DAD8] rounded-lg pl-8 pr-3 py-2 text-[11px] sm:text-[12px] text-[#3D3D3A] placeholder-[#A8A8A4] focus:outline-none focus:border-[#9e1f16]/40 transition-colors bg-white" />
                            </div>

                            <!-- ===== DESKTOP: 3-column table ===== -->
                            <div class="hidden sm:block">
                                <div class="border border-[#D9DAD8] rounded-lg overflow-hidden">
                                    <!-- Table Header -->
                                    <div class="grid grid-cols-3 bg-[#F5F5F3]">
                                        <div
                                            class="px-4 py-2.5 text-[11px] font-semibold text-[#686964] uppercase tracking-wider border-r border-[#D9DAD8]">
                                            {{ t("services.legalisasiKedutaanDetail.table.column_negara") }}</div>
                                        <div
                                            class="px-4 py-2.5 text-[11px] font-semibold text-[#686964] uppercase tracking-wider border-r border-[#D9DAD8]">
                                            {{ t("services.legalisasiKedutaanDetail.table.column_negara") }}</div>
                                        <div
                                            class="px-4 py-2.5 text-[11px] font-semibold text-[#686964] uppercase tracking-wider">
                                            {{ t("services.legalisasiKedutaanDetail.table.column_negara") }}</div>
                                    </div>
                                    <!-- Table Body -->
                                    <template v-if="negaraRows.length">
                                        <div v-for="(row, ri) in negaraRows" :key="`nrow-d-${ri}`"
                                            class="grid grid-cols-3"
                                            :class="ri < negaraRows.length - 1 ? 'border-b border-[#E8E8E6]' : ''">
                                            <template v-for="(country, ci) in row" :key="`ncell-d-${ri}-${ci}`">
                                                <div v-if="country"
                                                    class="flex items-center gap-2.5 px-4 py-2.5 min-w-0 hover:bg-[#FAFAF8] transition-colors"
                                                    :class="ci < 2 ? 'border-r border-[#E8E8E6]' : ''">
                                                    <img :src="country.img_flag" :alt="country.negara_title"
                                                        class="w-6 h-[15px] object-cover rounded-[2px] flex-shrink-0 shadow-sm"
                                                        loading="lazy" />
                                                    <span class="text-[12px] leading-[1.4] text-[#3D3D3A] truncate">{{
                                                        country.negara_title }}</span>
                                                </div>
                                                <div v-else class="px-4 py-2.5"
                                                    :class="ci < 2 ? 'border-r border-[#E8E8E6]' : ''"></div>
                                            </template>
                                        </div>
                                    </template>
                                    <!-- Empty State -->
                                    <div v-else class="px-4 py-12 text-center">
                                        <svg class="mx-auto mb-3 w-10 h-10 text-[#D9DAD8]" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <p class="text-[13px] text-[#686964]">{{ t("services.legalisasiKedutaanDetail.table.empty_search") }} "<span
                                                class="font-semibold text-[#3D3D3A]">{{ negaraSearch }}</span>"</p>
                                    </div>
                                </div>

                                <!-- Pagination Bar -->
                                <div class="flex items-center justify-between mt-4 min-w-0 gap-3">
                                    <!-- Left: Row count -->
                                    <span class="text-[11px] sm:text-[12px] text-[#686964] flex-shrink-0 tabular-nums">
                                        {{ t("services.legalisasiKedutaanDetail.table.row_count", { count: negaraDisplayCount }) }}
                                    </span>

                                    <!-- Center: Page navigation -->
                                    <div class="flex items-center gap-1.5 flex-shrink-0">
                                        <button @click="negaraPage = Math.max(1, negaraPage - 1)"
                                            :disabled="negaraPage <= 1"
                                            class="flex items-center justify-center w-7 h-7 rounded border border-[#D9DAD8] bg-white hover:bg-[#F5F5F3] disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-white transition-colors">
                                            <svg class="w-3.5 h-3.5 text-[#3D3D3A]" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <span
                                            class="text-[11px] sm:text-[12px] text-[#3D3D3A] whitespace-nowrap px-1.5 tabular-nums">
                                            {{ t("services.legalisasiKedutaanDetail.table.page_info", { page: negaraPage, total: totalNegaraPages }) }}
                                        </span>
                                        <button @click="negaraPage = Math.min(totalNegaraPages, negaraPage + 1)"
                                            :disabled="negaraPage >= totalNegaraPages"
                                            class="flex items-center justify-center w-7 h-7 rounded border border-[#D9DAD8] bg-white hover:bg-[#F5F5F3] disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-white transition-colors">
                                            <svg class="w-3.5 h-3.5 text-[#3D3D3A]" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Right: Rows per page -->
                                    <div class="flex items-center gap-1.5 flex-shrink-0">
                                        <span class="text-[11px] sm:text-[12px] text-[#686964] whitespace-nowrap">{{ t("services.legalisasiKedutaanDetail.table.rows_per_page") }}</span>
                                        <select v-model.number="negaraRowsPerPage"
                                            class="border border-[#D9DAD8] rounded px-2 py-1 text-[11px] sm:text-[12px] text-[#3D3D3A] bg-white focus:outline-none focus:border-[#9e1f16]/40 cursor-pointer appearance-none pr-5"
                                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%23686694%22%3E%3Cpath fill-rule=%22evenodd%22 d=%22M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z%22 clip-rule=%22evenodd%22 /%3E%3C/svg%3E'); background-position: right 4px center; background-repeat: no-repeat; background-size: 14px;">
                                            <option :value="10">10</option>
                                            <option :value="15">15</option>
                                            <option :value="20">20</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ===== MOBILE: 2-column compact table ===== -->
                            <div class="sm:hidden">
                                <!-- Search -->
                                <div class="relative mb-4">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#A8A8A4] pointer-events-none"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <input v-model="negaraSearch" type="text" :placeholder="t('services.legalisasiKedutaanDetail.table.search_placeholder')"
                                        class="w-full border border-[#D9DAD8] rounded-lg pl-9 pr-3 py-2.5 text-[13px] text-[#3D3D3A] placeholder-[#A8A8A4] focus:outline-none focus:border-[#9e1f16]/40 transition-colors bg-white" />
                                </div>

                                <!-- Table -->
                                <div v-if="negaraMobileRows.length"
                                    class="border border-[#D9DAD8] rounded-lg overflow-hidden">
                                    <!-- Header -->
                                    <div class="grid grid-cols-2 bg-[#F5F5F3]">
                                        <div
                                            class="px-3 py-2 text-[10px] font-semibold text-[#686964] uppercase tracking-wider border-r border-[#D9DAD8]">
                                            {{ t("services.legalisasiKedutaanDetail.table.column_negara") }}</div>
                                        <div
                                            class="px-3 py-2 text-[10px] font-semibold text-[#686964] uppercase tracking-wider">
                                            {{ t("services.legalisasiKedutaanDetail.table.column_negara") }}</div>
                                    </div>
                                    <!-- Rows -->
                                    <div v-for="(row, ri) in negaraMobileRows" :key="`nmrow-m-${ri}`"
                                        class="grid grid-cols-2"
                                        :class="ri < negaraMobileRows.length - 1 ? 'border-b border-[#E8E8E6]' : ''">
                                        <template v-for="(country, ci) in row" :key="`nmcell-m-${ri}-${ci}`">
                                            <div v-if="country" class="flex items-center gap-2 px-3 py-2.5 min-w-0"
                                                :class="ci === 0 ? 'border-r border-[#E8E8E6]' : ''">
                                                <img :src="country.img_flag" :alt="country.negara_title"
                                                    class="w-5 h-[13px] object-cover rounded-[2px] flex-shrink-0 shadow-sm"
                                                    loading="lazy" />
                                                <span class="text-[11px] leading-[1.4] text-[#3D3D3A] truncate">{{
                                                    country.negara_title }}</span>
                                            </div>
                                            <div v-else class="px-3 py-2.5"
                                                :class="ci === 0 ? 'border-r border-[#E8E8E6]' : ''"></div>
                                        </template>
                                    </div>
                                </div>
                                <!-- Empty State Mobile -->
                                <div v-else class="border border-[#D9DAD8] rounded-lg px-4 py-10 text-center">
                                    <svg class="mx-auto mb-2 w-8 h-8 text-[#D9DAD8]" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <p class="text-[12px] text-[#686964]">{{ t("services.legalisasiKedutaanDetail.table.empty_mobile") }}</p>
                                </div>

                                <!-- Mobile Pagination -->
                                <div class="flex items-center justify-between mt-3 min-w-0 gap-2">
                                    <span class="text-[10px] text-[#686964] flex-shrink-0 tabular-nums">
                                        {{ t("services.legalisasiKedutaanDetail.table.negara_count", { count: negaraDisplayCount }) }}
                                    </span>
                                    <div class="flex items-center gap-1.5 flex-shrink-0">
                                        <button @click="negaraPage = Math.max(1, negaraPage - 1)"
                                            :disabled="negaraPage <= 1"
                                            class="flex items-center justify-center w-6 h-6 rounded border border-[#D9DAD8] bg-white disabled:opacity-30 disabled:cursor-not-allowed">
                                            <svg class="w-3 h-3 text-[#3D3D3A]" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <span class="text-[10px] text-[#3D3D3A] tabular-nums">{{ negaraPage }}/{{
                                            totalNegaraPages }}</span>
                                        <button @click="negaraPage = Math.min(totalNegaraPages, negaraPage + 1)"
                                            :disabled="negaraPage >= totalNegaraPages"
                                            class="flex items-center justify-center w-6 h-6 rounded border border-[#D9DAD8] bg-white disabled:opacity-30 disabled:cursor-not-allowed">
                                            <svg class="w-3 h-3 text-[#3D3D3A]" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <span class="text-[10px] text-[#686964]">{{ t("services.legalisasiKedutaanDetail.table.per_page_mobile") }}</span>
                                        <select v-model.number="negaraRowsPerPage"
                                            class="border border-[#D9DAD8] rounded px-1.5 py-1 text-[10px] text-[#3D3D3A] bg-white focus:outline-none appearance-none pr-3"
                                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%23686694%22%3E%3Cpath fill-rule=%22evenodd%22 d=%22M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z%22 clip-rule=%22evenodd%22 /%3E%3C/svg%3E'); background-position: right 2px center; background-repeat: no-repeat; background-size: 10px;">
                                            <option :value="10">10</option>
                                            <option :value="15">15</option>
                                            <option :value="20">20</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ===== END 4b. NEGARA ANGGOTA ===== -->

                        <!-- 5. Tahapan -->
                        <div v-if="currentData.tahapan?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5 sm:p-8">
                            <div class="flex items-center gap-3 mb-6 sm:mb-8">
                                <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                <h2 class="text-[13px] sm:text-[15px] font-bold text-black">
                                    {{ currentData.tahapan_title ?? t("services.legalisasiKedutaanDetail.sections.tahapan_title_default") }}
                                </h2>
                            </div>

                            <div class="hidden sm:flex">
                                <div v-for="(step, si) in currentData.tahapan" :key="`step-${si}`"
                                    class="flex flex-col items-center flex-1 relative min-w-0">
                                    <div v-if="si > 0"
                                        class="absolute top-[28px] right-[calc(50%+28px)] left-0 h-[1px] bg-[#E8E8E6] z-0">
                                    </div>
                                    <div v-if="si < currentData.tahapan.length - 1"
                                        class="absolute top-[28px] left-[calc(50%+28px)] right-0 h-[1px] bg-[#E8E8E6] z-0">
                                    </div>
                                    <div class="flex flex-col items-center gap-3 relative z-10 px-2">
                                        <span
                                            class="flex h-14 w-14 items-center justify-center rounded-full bg-[#9e1f16] shadow-md shadow-[#9e1f16]/30">
                                            <img src="/icons/ft-docs.svg" class="w-7 h-7 brightness-0 invert" alt="" />
                                        </span>
                                        <p
                                            class="text-[12px] sm:text-[13px] leading-[1.6] text-[#3D3D3A] text-center max-w-[110px] break-words">
                                            {{ step }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-0 sm:hidden">
                                <div v-for="(step, si) in currentData.tahapan" :key="`step-m-${si}`"
                                    class="flex items-start gap-4 relative min-w-0"
                                    :class="si < currentData.tahapan.length - 1 ? 'pb-6' : ''">
                                    <div v-if="si < currentData.tahapan.length - 1"
                                        class="absolute left-[22px] top-[44px] bottom-0 w-[1px] bg-[#E8E8E6] z-0"></div>
                                    <span
                                        class="relative z-10 flex-shrink-0 flex h-11 w-11 items-center justify-center rounded-full bg-[#9e1f16] shadow-md shadow-[#9e1f16]/30">
                                        <img src="/icons/ft-docs.svg" class="w-5 h-5 brightness-0 invert" alt="" />
                                    </span>
                                    <p class="text-[13px] leading-[1.6] text-[#3D3D3A] pt-1.5 break-words min-w-0">
                                        {{ step }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Mengapa Menggunakan Layanan Kami? -->
                        <div v-if="currentData.mengapa_kami?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5 sm:p-8">
                            <div class="flex items-center gap-3 mb-4 sm:mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                <h2 class="text-[13px] sm:text-[15px] font-bold text-black">
                                    {{ t("services.legalisasiKedutaanDetail.sections.mengapa_kami") }}
                                </h2>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2.5 sm:gap-x-8 sm:gap-y-3">
                                <div v-for="(item, i) in currentData.mengapa_kami" :key="`mengapa-${i}`"
                                    class="flex items-start gap-2.5 min-w-0">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    <span
                                        class="text-[12px] sm:text-[13px] leading-[1.6] text-[#3D3D3A] break-words min-w-0">{{
                                            item }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Biaya Layanan -->
                        <div v-if="currentData.rincian_biaya"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5 sm:p-8">
                            <div class="flex items-center gap-3 mb-4 sm:mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                <h2 class="text-[13px] sm:text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ t("services.legalisasiKedutaanDetail.sections.biaya_layanan") }}
                                </h2>
                            </div>

                            <div v-if="currentData.rincian_biaya.items?.length"
                                class="flex flex-col lg:flex-row lg:items-center gap-4 mb-4">
                                <div class="flex-1 space-y-3 min-w-0">
                                    <div v-for="(item, index) in currentData.rincian_biaya.items"
                                        :key="`biaya-${index}`" class="flex items-start justify-between gap-4 min-w-0">
                                        <span
                                            class="text-[12px] sm:text-[13px] leading-[1.5] text-[#3D3D3A] break-words min-w-0">{{
                                                item.label
                                            }}</span>
                                        <span
                                            class="text-[12px] sm:text-[13px] font-semibold text-black whitespace-nowrap flex-shrink-0">{{
                                                item.amount }}</span>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="rounded-xl px-4 py-4 sm:px-5 sm:py-5 flex flex-col sm:flex-row sm:flex-nowrap items-stretch sm:items-center justify-between gap-3 sm:gap-4"
                                style="background-image: url('/images/card-arrow-item-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                                <div class="flex items-center gap-3 sm:gap-4 min-w-0 flex-1">
                                    <span
                                        class="flex h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 items-center justify-center rounded-xl bg-white">
                                        <img src="/icons/ft-persons.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                    </span>
                                    <div class="min-w-0">
                                        <div v-if="currentData.rincian_biaya.items?.length"
                                            class="text-[10px] sm:text-[11px] text-white/80 break-words">
                                            {{ currentData.rincian_biaya.total_label }}
                                        </div>
                                        <div
                                            class="text-[15px] sm:text-[18px] font-bold text-white leading-tight break-words">
                                            {{ currentData.rincian_biaya.items?.length ?
                                                currentData.rincian_biaya.total_amount : product.name
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <a :href="buildWhatsappLink(product.name, jenisPengajuan)" target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex-shrink-0 flex items-center justify-center gap-1.5 rounded-lg bg-white px-3 py-2 sm:px-4 sm:py-2.5 text-[11px] sm:text-[13px] font-semibold text-primary whitespace-nowrap hover:bg-white/90 transition-colors">
                                    {{ t("services.legalisasiKedutaanDetail.plans.hubungi_kami") }}
                                    <svg class="h-3 w-3 sm:h-3.5 sm:w-3.5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- ===== KANAN: Sidebar ===== -->
                    <div class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start min-w-0">

                        <!-- VIP Line Banner -->
                        <div class="rounded-2xl px-5 py-6 text-center overflow-hidden relative"
                            style="background-image: url('/images/card-arrow-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <div class="relative mb-4">
                                <div class="inline-block w-full rounded-xl border border-white/60 px-4 py-2.5">
                                    <span
                                        class="text-[13px] sm:text-[14px] font-extrabold uppercase tracking-widest text-white">
                                        {{ t("services.legalisasiKedutaanDetail.sidebar.vip_title") }}
                                    </span>
                                </div>
                            </div>
                            <p class="relative text-[13px] sm:text-[14px] leading-[1.6] text-white/90 mb-5"
                                v-html="t('services.legalisasiKedutaanDetail.sidebar.vip_desc')"></p>
                            <a :href="buildWhatsappLink(product.name, jenisPengajuan)" target="_blank"
                                rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{ t("services.legalisasiKedutaanDetail.sidebar.vip_cta") }}
                            </a>
                            <div class="relative mt-3 text-[11px] text-white/60">{{ t("services.legalisasiKedutaanDetail.sidebar.vip_note") }}</div>
                        </div>

                        <!-- Price Card -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <div
                                class="mb-4 flex items-center justify-between rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] px-3 py-2.5 min-w-0">
                                <span class="text-[12px] sm:text-[13px] text-[#1A1B18] truncate mr-2 min-w-0">{{
                                    product.name }}</span>
                                <svg class="h-4 w-4 flex-shrink-0 text-[#686964]" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <div class="text-[11px] sm:text-[12px] text-[#686964] mb-1">{{ t("services.legalisasiKedutaanDetail.sidebar.price_label") }}</div>
                            <div
                                class="text-[26px] sm:text-[32px] font-bold leading-none text-primary mb-1 break-words">
                                {{ currentData.rincian_biaya?.total_amount ?? product.price_label }}
                            </div>
                            <div class="text-[10px] sm:text-[11px] text-[#686964] mb-4">{{ t("services.legalisasiKedutaanDetail.sidebar.price_note") }}</div>
                            <a :href="buildWhatsappLink(product.name, jenisPengajuan)" target="_blank"
                                rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{ t("services.legalisasiKedutaanDetail.sidebar.konsultasi_cta") }}
                            </a>
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    {{ t("services.legalisasiKedutaanDetail.sidebar.benefit_1") }}
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    {{ t("services.legalisasiKedutaanDetail.sidebar.benefit_2") }}
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    {{ t("services.legalisasiKedutaanDetail.sidebar.benefit_3") }}
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    {{ t("services.legalisasiKedutaanDetail.sidebar.benefit_4") }}
                                </li>
                            </ul>
                        </div>

                        <!-- Layanan Terkait -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">{{ t("services.legalisasiKedutaanDetail.sidebar.related_title") }}</h3>
                            <div class="flex flex-col gap-3">
                                <a v-for="(related, index) in relatedProducts.slice(0, 3)" :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex flex-col gap-2 rounded-xl border border-[#E8E8E6] bg-white p-4 hover:border-primary/30 hover:shadow-sm transition-all min-w-0">
                                    <div
                                        class="text-[13px] sm:text-[14px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors break-words">
                                        {{ pick(related.name) }}
                                    </div>
                                    <p
                                        class="text-[11px] sm:text-[12px] leading-[1.6] text-[#686964] line-clamp-3 break-words">
                                        {{ pick(related.excerpt) ?? pick(related.description) }}
                                    </p>
                                    <hr class="border-[#E8E8E6]" />
                                    <div class="flex items-center justify-between min-w-0">
                                        <div class="min-w-0">
                                            <div class="text-[10px] sm:text-[11px] text-[#686964] mb-0.5">{{ t("services.legalisasiKedutaanDetail.sidebar.related_from") }}
                                            </div>
                                            <div
                                                class="text-[16px] sm:text-[18px] font-bold text-primary leading-none truncate">
                                                {{
                                                    related.price_label }}</div>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-1 flex items-center justify-center gap-2 rounded-xl border border-primary py-2.5 text-[12px] sm:text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors">
                                        {{ t("services.legalisasiKedutaanDetail.sidebar.related_cta") }}
                                        <svg class="h-4 w-4 group-hover:translate-x-0.5 transition-transform"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <FooterCTA
            :title="footerCta.title"
            :description="footerCta.subtitle"
            :button-text="footerCta.button_text"
            :whatsapp-link="buildWhatsappLink(footerCta.wa_message, jenisPengajuan)"
        />
    </MainLayout>
</template>