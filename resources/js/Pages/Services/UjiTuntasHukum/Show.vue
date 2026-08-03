<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { computed } from "vue";
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

const itemMeta = [
    { icon: "/icons/layanan/uji-tuntas-hukum.svg", path: "/uji-tuntas-hukum" },
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
        tag: pick(p.tag),
        duration: pick(p.duration),
        description: pick(p.description),
        excerpt: pick(p.excerpt),
        content: pick(p.content) ?? [],
        mengapa_penting: pick(p.mengapa_penting),
        ruang_lingkup: pick(p.ruang_lingkup),
        direkomendasikan_bagi: pick(p.direkomendasikan_bagi),
        keunggulan: pick(p.keunggulan),
        banner_cta: pick(p.banner_cta),
        faq: pick(p.faq) ?? [],
    };
});

const product = localizedProduct;

const mengapaPenting = computed(() => product.value?.mengapa_penting ?? null);
const ruangLingkup = computed(() => product.value?.ruang_lingkup ?? null);
const direkomendasikan = computed(() => product.value?.direkomendasikan_bagi ?? null);
const keunggulan = computed(() => product.value?.keunggulan ?? null);
const bannerCta = computed(() => product.value?.banner_cta ?? null);
</script>

<template>
    <MainLayout>
         <!-- Hero -->
        <section class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px] bg-[#9e1f16]">
            <img src="/icons/left-arrow.svg"
                class="absolute right-0 -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block" alt="" />
            <div
                class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]">
                <nav aria-label="Breadcrumb">
                    <div class="hidden sm:inline-flex items-center gap-2 rounded-md bg-white px-4 py-2">
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
                        <a href="/layanan" class="text-sm font-medium text-[#9e1f16] hover:underline">{{
                            t("services.ujiTuntasHukumDetail.breadcrumb.layanan")
                        }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#9e1f16]">{{ localizedProduct.name }}</span>
                    </div>
                </nav>
                <div class="flex items-center gap-5">
                    <div
                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-white shadow-md md:h-16 md:w-16 md:rounded-2xl">
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
                    <h1
                        class="text-base font-extrabold leading-tight text-white sm:text-2xl lg:text-2xl max-w-[800px] line-clamp-2">
                        {{ localizedProduct.name }}
                    </h1>
                </div>
                <div>
                    <a href="/layanan"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ t("services.ujiTuntasHukumDetail.back") }}
                    </a>
                </div>
            </div>
        </section>

        <!-- ===== CONTENT ===== -->
        <section class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[1fr_280px] xl:grid-cols-[1fr_300px] min-w-0">

                    <!-- KIRI -->
                    <div class="flex flex-col gap-6 min-w-0">

                        <!-- 1. Informasi Umum -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ t("services.ujiTuntasHukumDetail.sections.informasi") }}</h2>
                            </div>
                            <div class="space-y-4">
                                <p v-for="(p, i) in product.content" :key="`content-${i}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A]">{{ p }}</p>
                            </div>
                        </div>

                        <!-- 2. Mengapa Penting -->
                        <div v-if="mengapaPenting" class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ mengapaPenting.title }}
                                </h2>
                            </div>
                            <p class="text-[14px] leading-[1.8] text-[#3D3D3A] mb-4">
                                {{ mengapaPenting.intro }}
                            </p>
                            <ul class="space-y-2.5 mb-4">
                                <li v-for="(item, i) in mengapaPenting.items" :key="`penting-${i}`"
                                    class="flex items-start gap-2.5 text-[13px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="w-4 h-4 mt-0.5 flex-shrink-0" alt="" />
                                    {{ item }}
                                </li>
                            </ul>
                            <p class="text-[13px] leading-[1.8] text-[#686964]">
                                {{ mengapaPenting.closing }}
                            </p>
                        </div>

                        <!-- 3. Ruang Lingkup -->
                        <div v-if="ruangLingkup" class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ ruangLingkup.title }}
                                </h2>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                                <div v-for="(cat, ci) in ruangLingkup.categories" :key="`cat-${ci}`">
                                    <h3 class="text-[13px] font-bold text-[#1A1B18] mb-2">
                                        {{ cat.name }}
                                    </h3>
                                    <ul class="space-y-1">
                                        <li v-for="(item, ii) in cat.items" :key="`catitem-${ci}-${ii}`"
                                            class="flex items-start gap-2 text-[12px] text-[#3D3D3A] leading-[1.6]">
                                            <span
                                                class="mt-[5px] w-1.5 h-1.5 rounded-full bg-[#9e1f16] flex-shrink-0"></span>
                                            {{ item }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Direkomendasikan Bagi -->
                        <div v-if="direkomendasikan" class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ direkomendasikan.title }}
                                </h2>
                            </div>
                            <div class="flex flex-col gap-4">
                                <div v-for="(item, i) in direkomendasikan.items" :key="`direk-${i}`"
                                    class="flex items-start gap-4">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-[#9e1f16] flex items-center justify-center">
                                        <span class="text-[12px] font-bold text-white">{{ item.number }}</span>
                                    </div>
                                    <div>
                                        <div class="text-[13px] font-bold text-[#1A1B18] mb-0.5">{{ item.title }}</div>
                                        <div class="text-[13px] text-[#686964] leading-[1.6]">{{ item.description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Keunggulan -->
                        <div v-if="keunggulan" class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ keunggulan.title }}
                                </h2>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div v-for="(item, i) in keunggulan.items" :key="`unggulan-${i}`"
                                    class="flex items-start gap-3">
                                    <img src="/icons/ft-done.svg" class="w-4 h-4 mt-0.5 flex-shrink-0" alt="" />
                                    <div>
                                        <div class="text-[13px] font-bold text-[#1A1B18] mb-0.5">{{ item.title }}</div>
                                        <div class="text-[12px] text-[#686964] leading-[1.6]">{{ item.description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Banner CTA Merah -->
                        <div v-if="bannerCta"
                            class="rounded-xl px-4 py-4 sm:px-5 sm:py-5 flex flex-col sm:flex-row sm:flex-nowrap items-stretch sm:items-center justify-between gap-3 sm:gap-4"
                            style="background-image: url('/images/card-arrow-item-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <div class="flex items-center gap-3 sm:gap-4 min-w-0 flex-1">
                                <span
                                    class="flex h-10 w-10 sm:h-12 sm:w-12 flex-shrink-0 items-center justify-center rounded-xl bg-white">
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
                                {{ t("services.ujiTuntasHukumDetail.hubungi_kami") }}
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
                                        {{ t("services.ujiTuntasHukumDetail.sidebar.vip_title") }}
                                    </span>
                                </div>
                            </div>
                            <p class="relative text-[14px] leading-[1.6] text-white/90 mb-5"
                                v-html="t('services.ujiTuntasHukumDetail.sidebar.vip_desc')"></p>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{ t("services.ujiTuntasHukumDetail.sidebar.vip_cta") }}
                            </a>
                            <div class="relative mt-3 text-[11px] text-white/60">{{ t("services.ujiTuntasHukumDetail.sidebar.vip_note") }}</div>
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
                            <div class="text-[12px] text-[#686964] mb-1">{{ t("services.ujiTuntasHukumDetail.sidebar.price_label") }}</div>
                            <div class="text-[32px] font-bold leading-none text-primary mb-1">
                                {{ product.price_label }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">{{ t("services.ujiTuntasHukumDetail.sidebar.price_note") }}
                            </div>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-6 w-6 flex-shrink-0" alt="wa" />
                                {{ t("services.ujiTuntasHukumDetail.sidebar.konsultasi_cta") }}
                            </a>
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    {{ t("services.ujiTuntasHukumDetail.sidebar.benefit_1") }}
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    {{ t("services.ujiTuntasHukumDetail.sidebar.benefit_2") }}
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    {{ t("services.ujiTuntasHukumDetail.sidebar.benefit_3") }}
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    {{ t("services.ujiTuntasHukumDetail.sidebar.benefit_4") }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END KANAN -->

                </div>
            </div>
        </section>

        <FooterCTA
            :title="t('services.ujiTuntasHukumDetail.footer.title')"
            :description="t('services.ujiTuntasHukumDetail.footer.desc')"
            :button-text="t('services.ujiTuntasHukumDetail.footer.cta')"
            :whatsapp-link="buildWhatsappLink(t('services.ujiTuntasHukumDetail.footer.wa_subject'))"
        />
    </MainLayout>
</template>