<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { ref, computed } from "vue";
import { useI18n } from "vue-i18n";

import { useWhatsapp } from "@/Composables/useWhatsapp.js";
const { t, locale } = useI18n();

const docsOpen = ref(false);
const dasarHukumOpen = ref(false);

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
    { icon: "/icons/layanan/laporan-kegiatan-penanaman-modal.svg", path: "/kewajiban-pelaporan-perusahaan" },
    { icon: "/icons/layanan/SIINAS.svg", path: "/kewajiban-pelaporan-perusahaan" },
    { icon: "/icons/layanan/wajib-lapor.svg", path: "/kewajiban-pelaporan-perusahaan" },
    { icon: "/icons/layanan/wajib-lapor.svg", path: "/kewajiban-pelaporan-perusahaan" },
];

const parseBold = (text) => {
    if (!text) return "";
    return text.replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>");
};

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
        audience: pick(p.audience),
        content: pick(p.content) ?? [],
        term_condition: pick(p.term_condition) ?? [],
        benefits: pick(p.benefits) ?? [],
        scope_of_service: pick(p.scope_of_service) ?? [],
        requirements: pick(p.requirements) ?? [],
        process: pick(p.process) ?? [],
        faq: pick(p.faq) ?? [],
        plans: pick(p.plans) ?? [],
        plans_info: pick(p.plans_info),
        plans_alert: pick(p.plans_alert) ?? [],
        dasar_hukum: pick(p.dasar_hukum) ?? [],
        footer_cta: pick(p.footer_cta),
    };
});

const product = localizedProduct;

const remainingPlans = computed(() => (product.value?.plans ?? []).slice(3));

const remainingGridClass = computed(() => {
    const count = remainingPlans.value.length;
    if (count === 0) return '';
    if (count === 1) return 'sm:max-w-[33.333%] sm:mx-auto';
    if (count === 2) return 'sm:grid-cols-2 sm:max-w-[66.666%] sm:mx-auto';
    return 'sm:grid-cols-3';
});

const currentDasarHukum = computed(() => product.value?.dasar_hukum ?? []);

const expandedDocs = ref({});
const toggleDoc = (key) => {
    expandedDocs.value[key] = !expandedDocs.value[key];
};

// Footer CTA dinamis
const defaultFooterCta = computed(() => pick({
    id: {
        title: "Butuh Konsultasi Soal Kewajiban Pelaporan Perusahaan?",
        subtitle: "Tim Fasttrack siap membantu Anda memenuhi kewajiban pelaporan perusahaan dengan cepat dan tepat.",
        button_text: "Chat Langsung via WhatsApp",
        wa_message: "layanan yang tidak terdaftar",
    },
    en: {
        title: "Need Consultation on Corporate Reporting Obligations?",
        subtitle: "The Fasttrack team is ready to help you fulfill your corporate reporting obligations quickly and accurately.",
        button_text: "Chat Directly via WhatsApp",
        wa_message: "an unlisted service",
    },
    zh: {
        title: "需要企业申报义务方面的咨询吗？",
        subtitle: "Fasttrack团队随时准备协助您快速且准确地履行企业申报义务。",
        button_text: "直接通过WhatsApp聊天",
        wa_message: "未列出的服务",
    },
}));
const footerCta = computed(() => product.value?.footer_cta ?? defaultFooterCta.value);
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px] bg-[#9e1f16]">
            <div class="ml-5">
                <img src="/icons/left-arrow.svg"
                    class="absolute right-[0%] -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block" alt="" />
            </div>

            <div
                class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]">
                <!-- Breadcrumb -->
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
                            t(
                                "services.kewajibanPelaporanUsahaDetail.breadcrumb.layanan",
                            )
                        }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/kewajiban-pelaporan-perusahaan"
                            class="text-sm font-medium text-[#9e1f16] hover:underline">{{
                                t(
                                    "services.kewajibanPelaporanUsahaDetail.breadcrumb.current",
                                )
                            }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#9e1f16]">{{ product.name }}</span>
                    </div>
                </nav>

                <!-- Center: Heading -->
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
                        {{ product.name }}
                    </h1>
                </div>

                <!-- Bottom: Back button -->
                <div>
                    <a href="/kewajiban-pelaporan-perusahaan"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ t("services.kewajibanPelaporanUsahaDetail.back") }}
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section id="edukasi" class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[1fr_280px] xl:grid-cols-[1fr_300px] min-w-0">
                    <!-- ===== KIRI: Konten Utama ===== -->
                    <div class="flex flex-col gap-6 min-w-0">

                        <!-- 1. Penjelasan Umum -->
                        <div v-if="product.content?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{
                                        t(
                                            "services.kewajibanPelaporanUsahaDetail.sections.penjelasan",
                                        )
                                    }}
                                </h2>
                            </div>
                            <div class="space-y-4">
                                <template v-for="(item, index) in product.content" :key="`content-${index}`">
                                    <p v-if="typeof item === 'string'"
                                        class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">
                                        {{ item }}
                                    </p>
                                    <p v-else-if="item.text"
                                        class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">
                                        <span class="font-semibold text-[#1A1B18]">{{ item.label }}: </span>
                                        <span>{{ item.text }}</span>
                                    </p>
                                    <div v-else-if="item.items?.length" class="space-y-2.5">
                                        <p class="text-[14px] leading-[1.8] font-semibold text-[#1A1B18]">
                                            {{ item.label }}:
                                        </p>
                                        <div v-for="(sub, si) in item.items" :key="`sub-${index}-${si}`"
                                            class="flex items-start gap-3 pl-0.5">
                                            <span
                                                class="flex-shrink-0 w-[6px] h-[6px] rounded-full bg-[#9e1f16] mt-[9px]"></span>
                                            <span v-if="typeof sub === 'string'"
                                                class="text-[14px] leading-[1.8] text-[#3D3D3A]">{{ sub }}</span>
                                            <span v-else class="text-[14px] leading-[1.8] text-[#3D3D3A]">
                                                <span class="font-semibold text-[#1A1B18]">{{ sub.label }}</span><span
                                                    v-if="sub.text"> {{ sub.text }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- 2. Syarat dan Ketentuan -->
                        <div v-if="product.term_condition?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{
                                        t(
                                            "services.kewajibanPelaporanUsahaDetail.sections.syarat",
                                        )
                                    }}
                                </h2>
                            </div>
                            <ol class="space-y-4">
                                <li v-for="(req, index) in product.term_condition" :key="`req-${index}`"
                                    class="flex gap-3 text-[14px] leading-[1.7] text-[#3D3D3A]">
                                    <span class="mt-0.5 flex-shrink-0 text-[13px] font-semibold text-[#1A1B18]">
                                        {{ index + 1 }}.
                                    </span>
                                    <div>
                                        <p v-if="req.title" class="text-[14px] font-semibold text-[#1A1B18] mb-0.5">
                                            {{ req.title }}
                                        </p>
                                        <p class="text-[13px] leading-[1.6] text-[#3D3D3A]">
                                            {{ req.description ?? req }}
                                        </p>
                                        <ul v-if="req.notes" class="mt-1 space-y-0.5 list-disc list-inside">
                                            <li v-for="(note, nIndex) in req.notes" :key="`note-${nIndex}`"
                                                class="text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                {{ note }}
                                            </li>
                                        </ul>
                                        <template v-if="req.notes_extra">
                                            <p class="text-[13px] leading-[1.6] text-[#3D3D3A] mt-2">
                                                {{ req.notes_extra.label }}
                                            </p>
                                            <ul class="mt-1 space-y-0.5 list-disc list-inside">
                                                <li v-for="(item, iIndex) in req.notes_extra.items"
                                                    :key="`extra-${iIndex}`"
                                                    class="text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                    {{ item }}
                                                </li>
                                            </ul>
                                        </template>
                                        <template v-if="req.notes_extra_plus">
                                            <p class="text-[13px] leading-[1.6] text-[#3D3D3A] mt-2">
                                                {{ req.notes_extra_plus.label }}
                                            </p>
                                            <ul class="mt-1 space-y-0.5 list-disc list-inside">
                                                <li v-for="(item, iIndex) in req.notes_extra_plus.items"
                                                    :key="`extra-plus-${iIndex}`"
                                                    class="text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                    {{ item }}
                                                </li>
                                            </ul>
                                        </template>
                                    </div>
                                </li>
                            </ol>
                        </div>

                        <!-- 3. Keuntungan & Manfaat -->
                        <div v-if="product.benefits?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ t("services.kewajibanPelaporanUsahaDetail.sections.keuntungan") }}
                                </h2>
                            </div>
                            <div :class="product.benefits.length < 4
                                ? 'flex flex-col gap-4'
                                : 'grid grid-cols-1 sm:grid-cols-2 gap-4'">
                                <div v-for="(benefit, index) in product.benefits" :key="`benefit-${index}`"
                                    class="flex gap-3 rounded-xl border border-[#E8E8E6] p-4">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="done" />
                                    <div class="flex-1">
                                        <p class="text-[13px] font-semibold text-black leading-snug mb-1">
                                            {{ benefit.title }}
                                        </p>
                                        <p v-if="benefit.description" class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                            :class="product.benefits.length >= 4 ? 'text-justify' : ''">
                                            {{ benefit.description }}
                                        </p>
                                        <ul v-if="benefit.notes && product.benefits.length < 4"
                                            class="mt-1 space-y-0.5 list-disc list-inside">
                                            <li v-for="(note, nIndex) in benefit.notes" :key="`bnote-${nIndex}`"
                                                class="text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                {{ note }}
                                            </li>
                                        </ul>
                                        <p v-if="benefit.footer && product.benefits.length < 4"
                                            class="mt-1.5 text-[13px] leading-[1.6] text-[#3D3D3A]">
                                            {{ benefit.footer }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Ruang Lingkup Layanan Kami -->
                        <div v-if="product.scope_of_service?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                <h2 class="text-[13px] sm:text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ t("services.kewajibanPelaporanUsahaDetail.sections.ruang_lingkup") }}
                                </h2>
                            </div>
                            <div class="space-y-5">
                                <div v-for="(service, index) in product.scope_of_service" :key="`service-${index}`"
                                    class="flex items-start gap-3 sm:gap-4 min-w-0">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 sm:h-5 sm:w-5 flex-shrink-0"
                                        alt="done" />
                                    <div class="min-w-0">
                                        <p
                                            class="text-[13px] sm:text-[14px] font-semibold text-[#1A1B18] leading-[1.5] mb-0.5 break-words">
                                            {{ service.title }}
                                        </p>
                                        <p class="text-[12px] sm:text-[13px] leading-[1.7] text-[#686964] break-words">
                                            {{ service.description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Paket & Harga -->
                        <div v-if="product.plans?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5 sm:p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                <h2 class="text-[13px] sm:text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{
                                        t(
                                            "services.kewajibanPelaporanUsahaDetail.sections.paket",
                                        )
                                    }}
                                </h2>
                            </div>

                            <!-- Baris 1: 3 paket pertama -->
                            <div class="grid grid-cols-1 gap-4" :class="[
                                product.plans.slice(0, 3).length === 1 ? 'sm:grid-cols-1' :
                                    product.plans.slice(0, 3).length === 2 ? 'sm:grid-cols-2' :
                                        'sm:grid-cols-3',
                                product.plans.length > 3 ? 'mb-4' : ''
                            ]">
                                <div v-for="(plan, pi) in product.plans.slice(0, 3)" :key="`plan-${pi}`"
                                    class="relative flex flex-col rounded-xl border border-[#E8E8E6]">

                                    <!-- Card Body -->
                                    <div class="flex flex-col flex-1">
                                        <!-- TOP: Nama + Harga + Bonus -->
                                        <div class="p-4 sm:p-5 flex flex-col gap-3">
                                            <!-- Nama Paket -->
                                            <div
                                                class="text-[12px] sm:text-[13px] font-bold uppercase tracking-wide text-[#1A1B18] leading-tight min-h-[2.5rem]">
                                                {{ plan.name }}
                                            </div>

                                            <!-- Harga -->
                                            <div>
                                                <div class="text-[11px] text-[#686964]">{{
                                                    t(
                                                        "services.kewajibanPelaporanUsahaDetail.plans.mulai_dari",
                                                    )
                                                }}</div>
                                                <div
                                                    class="text-[16px] sm:text-[18px] font-bold leading-tight text-primary">
                                                    {{ plan.price }}
                                                </div>
                                            </div>

                                            <!-- Bonus Note -->
                                            <div v-if="plan.bonus_note"
                                                class="flex items-start gap-1.5 text-[11px] text-[#3D3D3A]">
                                                <svg class="h-3.5 w-3.5 text-[#25D366] flex-shrink-0 mt-0.5"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span>{{ plan.bonus_note }}</span>
                                            </div>
                                        </div>

                                        <!-- DIVIDER -->
                                        <div class="h-px bg-[#E8E8E6]"></div>

                                        <!-- BOTTOM: Sections -->
                                        <div class="p-4 sm:p-5 flex flex-col gap-3 flex-1">
                                            <div v-for="(section, si) in plan.sections" :key="`sec-${pi}-${si}`"
                                                :class="si > 0 ? 'mt-2 space-y-2' : 'space-y-2'">
                                                <div class="text-[11px] font-semibold text-[#1A1B18]">{{ section.label
                                                    }}</div>
                                                <ul class="space-y-1.5">
                                                    <li v-for="(item, ii) in section.items"
                                                        :key="`item-${pi}-${si}-${ii}`"
                                                        class="flex items-start gap-2 min-w-0">
                                                        <svg v-if="item.included"
                                                            class="mt-0.5 h-3.5 w-3.5 flex-shrink-0 text-[#25D366]"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2.5">
                                                            <circle cx="12" cy="12" r="10" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12l2 2 4-4" />
                                                        </svg>
                                                        <svg v-else
                                                            class="mt-0.5 h-3.5 w-3.5 flex-shrink-0 text-[#D1D5DB]"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2.5">
                                                            <circle cx="12" cy="12" r="10" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 9l-6 6M9 9l6 6" />
                                                        </svg>
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] break-words">{{
                                                                item.label
                                                            }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CTA -->
                                    <div class="p-4 sm:p-5 pt-0">
                                        <a :href="buildWhatsappLink(plan.name)" target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex w-full items-center justify-center gap-2 rounded-lg py-2.5 text-[12px] font-semibold transition-colors border border-primary text-primary hover:bg-primary hover:text-white">
                                            {{
                                                t(
                                                    "services.kewajibanPelaporanUsahaDetail.plans.pesan",
                                                )
                                            }}
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Baris 2: sisa paket (> 3) -->
                            <div v-if="product.plans.length > 3" class="grid grid-cols-1 gap-4"
                                :class="remainingGridClass">
                                <div v-for="(plan, pi) in remainingPlans" :key="`plan-extra-${pi}`"
                                    class="relative flex flex-col rounded-xl border border-[#E8E8E6]">

                                    <div class="flex flex-col flex-1">
                                        <!-- TOP: Nama + Harga + Bonus -->
                                        <div class="p-4 sm:p-5 flex flex-col gap-3">
                                            <div
                                                class="text-[12px] sm:text-[13px] font-bold uppercase tracking-wide text-[#1A1B18] leading-tight min-h-[2.5rem]">
                                                {{ plan.name }}
                                            </div>
                                            <div>
                                                <div class="text-[11px] text-[#686964]">{{
                                                    t(
                                                        "services.kewajibanPelaporanUsahaDetail.plans.mulai_dari",
                                                    )
                                                }}</div>
                                                <div
                                                    class="text-[16px] sm:text-[18px] font-bold leading-tight text-primary">
                                                    {{ plan.price }}
                                                </div>
                                            </div>
                                            <div v-if="plan.bonus_note"
                                                class="flex items-start gap-1.5 text-[11px] text-[#3D3D3A]">
                                                <svg class="h-3.5 w-3.5 text-[#25D366] flex-shrink-0 mt-0.5"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span>{{ plan.bonus_note }}</span>
                                            </div>
                                        </div>

                                        <!-- DIVIDER -->
                                        <div class="h-px bg-[#E8E8E6]"></div>

                                        <!-- BOTTOM: Sections -->
                                        <div class="p-4 sm:p-5 flex flex-col gap-3 flex-1">
                                            <div v-for="(section, si) in plan.sections" :key="`sec-extra-${pi}-${si}`"
                                                :class="si > 0 ? 'mt-2 space-y-2' : 'space-y-2'">
                                                <div class="text-[11px] font-semibold text-[#1A1B18]">{{ section.label
                                                }}</div>
                                                <ul class="space-y-1.5">
                                                    <li v-for="(item, ii) in section.items"
                                                        :key="`item-extra-${pi}-${si}-${ii}`"
                                                        class="flex items-start gap-2 min-w-0">
                                                        <svg v-if="item.included"
                                                            class="mt-0.5 h-3.5 w-3.5 flex-shrink-0 text-[#25D366]"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2.5">
                                                            <circle cx="12" cy="12" r="10" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12l2 2 4-4" />
                                                        </svg>
                                                        <svg v-else
                                                            class="mt-0.5 h-3.5 w-3.5 flex-shrink-0 text-[#D1D5DB]"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2.5">
                                                            <circle cx="12" cy="12" r="10" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 9l-6 6M9 9l6 6" />
                                                        </svg>
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] break-words">{{
                                                                item.label
                                                            }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-4 sm:p-5 pt-0">
                                        <a :href="buildWhatsappLink(plan.name)" target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex w-full items-center justify-center gap-2 rounded-lg py-2.5 text-[12px] font-semibold transition-colors border border-primary text-primary hover:bg-primary hover:text-white">
                                            {{
                                                t(
                                                    "services.kewajibanPelaporanUsahaDetail.plans.pesan",
                                                )
                                            }}
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Blue Info Box -->
                            <div v-if="product.plans_info"
                                class="mt-5 rounded-xl bg-[#EFF6FF] border border-[#BFDBFE] px-4 py-3 flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-[#3B82F6] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-[12px] sm:text-[13px] leading-[1.6] text-[#1E40AF]">{{
                                    product.plans_info }}</p>
                            </div>
                        </div>

                        <!-- 6. Dasar Hukum (Accordion) -->
                        <div v-if="currentDasarHukum.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white overflow-hidden">
                            <button @click="dasarHukumOpen = !dasarHukumOpen"
                                class="w-full flex items-center justify-between p-6 sm:p-8 text-left">
                                <div class="flex items-center gap-3">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                        {{
                                            t(
                                                "services.kewajibanPelaporanUsahaDetail.sections.dasar_hukum",
                                            )
                                        }}
                                    </h2>
                                </div>
                                <svg class="h-5 w-5 text-[#686964] flex-shrink-0 transition-transform duration-200"
                                    :class="dasarHukumOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div v-show="dasarHukumOpen" class="px-6 sm:px-8 pb-6 sm:pb-8 border-t border-[#E8E8E6]">
                                <ul class="mt-5 space-y-4">
                                    <li v-for="(hukum, hi) in currentDasarHukum" :key="`hukum-${hi}`"
                                        class="flex items-start gap-4">
                                        <span
                                            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-[#ddffe3]">
                                            <img src="/icons/ft-save.svg" class="w-4 h-4" alt="" />
                                        </span>
                                        <span class="text-[13px] leading-[1.7] text-[#3D3D3A] text-justify">{{ hukum
                                        }}</span>
                                    </li>
                                </ul>
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
                                    <span class="text-[14px] font-extrabold uppercase tracking-widest text-white">
                                        {{
                                            t(
                                                "services.kewajibanPelaporanUsahaDetail.sidebar.vip_title",
                                            )
                                        }}
                                    </span>
                                </div>
                            </div>
                            <p class="relative text-[14px] leading-[1.6] text-white/90 mb-5">
                                {{
                                    t(
                                        "services.kewajibanPelaporanUsahaDetail.sidebar.vip_desc",
                                    )
                                }}
                            </p>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{
                                    t(
                                        "services.kewajibanPelaporanUsahaDetail.sidebar.vip_cta",
                                    )
                                }}
                            </a>
                            <div class="relative mt-3 text-[11px] text-white/60">{{
                                t(
                                    "services.kewajibanPelaporanUsahaDetail.sidebar.vip_note",
                                )
                            }}</div>
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
                            <div class="text-[12px] text-[#686964] mb-1">{{
                                t(
                                    "services.kewajibanPelaporanUsahaDetail.sidebar.price_label",
                                )
                            }}</div>
                            <div class="text-[32px] font-bold leading-none text-primary mb-1">
                                {{ product.price_label }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">
                                {{
                                    t(
                                        "services.kewajibanPelaporanUsahaDetail.sidebar.price_note",
                                    )
                                }}
                            </div>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-6 w-6 flex-shrink-0" alt="wa" />
                                {{
                                    t(
                                        "services.kewajibanPelaporanUsahaDetail.sidebar.konsultasi_cta",
                                    )
                                }}
                            </a>
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    {{ t("services.kewajibanPelaporanUsahaDetail.sidebar.benefit_1") }}
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    {{ t("services.kewajibanPelaporanUsahaDetail.sidebar.benefit_2") }}
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    {{ t("services.kewajibanPelaporanUsahaDetail.sidebar.benefit_3") }}
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    {{ t("services.kewajibanPelaporanUsahaDetail.sidebar.benefit_4") }}
                                </li>
                            </ul>
                        </div>

                        <!-- Layanan Terkait -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">{{ t("services.kewajibanPelaporanUsahaDetail.sidebar.related_title") }}</h3>
                            <div class="flex flex-col gap-3">
                                <a v-for="(related, index) in relatedProducts.slice(0, 3)" :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex flex-col gap-2 rounded-xl border border-[#E8E8E6] bg-white p-4 hover:border-primary/30 hover:shadow-sm transition-all">
                                    <div
                                        class="text-[14px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors">
                                        {{ pick(related.name) }}
                                    </div>
                                    <p class="text-[12px] leading-[1.6] text-[#686964] line-clamp-3">
                                        {{ pick(related.excerpt) ?? pick(related.description) }}
                                    </p>
                                    <hr class="border-[#E8E8E6]" />
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-[11px] text-[#686964] mb-0.5">{{ t("services.kewajibanPelaporanUsahaDetail.sidebar.related_from") }}</div>
                                            <div class="text-[18px] font-bold text-primary leading-none">
                                                {{ related.price_label }}
                                            </div>
                                        </div>
                                        <span
                                            class="text-[11px] font-medium text-[#3D3D3A] border border-[#E8E8E6] rounded-md px-2 py-1">
                                            {{ related.plans ? related.plans.length : 0 }} {{ t("services.kewajibanPelaporanUsahaDetail.sidebar.related_packages") }}
                                        </span>
                                    </div>
                                    <div
                                        class="mt-1 flex items-center justify-center gap-2 rounded-xl border border-primary py-2.5 text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors">
                                        {{ t("services.kewajibanPelaporanUsahaDetail.sidebar.related_cta") }}
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
            :whatsapp-link="buildWhatsappLink(footerCta.wa_message)"
        />
    </MainLayout>
</template>