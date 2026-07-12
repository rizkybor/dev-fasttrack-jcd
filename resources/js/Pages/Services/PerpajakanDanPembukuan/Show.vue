<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { ref, computed } from "vue";
import { useI18n } from "vue-i18n";

const { t, locale } = useI18n();

const props = defineProps({
    product: { type: Object, required: true },
    relatedProducts: { type: Array, default: () => [] },
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
        excerpt: pick(p.excerpt),
        penjelasan_umum: pick(p.penjelasan_umum) ?? [],
        sections: pick(p.sections) ?? [],
        biaya_layanan_cards: pick(p.biaya_layanan_cards),
        biaya_layanan_single: pick(p.biaya_layanan_single),
        faq: pick(p.faq) ?? [],
    };
});

const product = localizedProduct;

const openSectionId = ref(null);
const toggleSection = (id) => {
    openSectionId.value = openSectionId.value === id ? null : id;
};
</script>

<template>
    <MainLayout>
        <!-- Hero -->
        <section class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px] bg-[#9e1f16]">
            <img src="/icons/left-arrow.svg"
                class="absolute right-0 -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block" alt="" />
            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]">
                <nav aria-label="Breadcrumb">
                    <div class="inline-flex items-center gap-2 sm:rounded-md sm:bg-white sm:px-4 sm:py-2">
                        <a href="/" class="text-[#9e1f16] hover:text-black transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
                            </svg>
                        </a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/layanan" class="text-sm font-medium text-[#9e1f16] hover:underline">{{
                            t(
                                "services.perpajakanDanPembukuanDetail.breadcrumb.layanan",
                            )
                        }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/perpajakan-dan-pembukuan" class="text-sm font-medium text-[#9e1f16] hover:underline">{{
                            t(
                                "services.perpajakanDanPembukuanDetail.breadcrumb.current",
                            )
                        }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#9e1f16]">{{ product.name }}</span>
                    </div>
                </nav>
                <div class="flex items-center gap-5">
                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white shadow-md">
                        <img src="/icons/ft-persons.svg" class="w-9 h-9" alt="" />
                    </div>
                    <h1 class="text-3xl font-extrabold leading-tight text-white sm:text-4xl lg:text-5xl max-w-[800px] line-clamp-2">
                        {{ product.name }}
                    </h1>
                </div>
                <div>
                    <a href="/perpajakan-dan-pembukuan"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ t("services.perpajakanDanPembukuanDetail.back") }}
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
                        <div v-if="product.penjelasan_umum?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{
                                    t(
                                        "services.perpajakanDanPembukuanDetail.sections.penjelasan",
                                    )
                                }}</h2>
                            </div>
                            <div class="space-y-3">
                                <template v-for="(block, i) in product.penjelasan_umum" :key="`pu-${i}`">
                                    <template v-if="typeof block === 'object'">
                                        <p v-if="block.type === 'title'"
                                            class="text-[14px] font-bold text-[#1A1B18] leading-snug pt-1">
                                            {{ block.text }}
                                        </p>
                                        <ul v-else-if="block.type === 'bullets'" class="space-y-1.5 pl-1">
                                            <li v-for="(item, bi) in block.items" :key="`bul-${i}-${bi}`"
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
                        <template v-for="section in product.sections" :key="section.id">

                            <!-- Type: grid_check_desc (2 col grid dengan icon centang + title + desc) -->
                            <div v-if="section.type === 'grid_check_desc'"
                                class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                <div class="flex items-center gap-3 mb-5">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ section.title }}</h2>
                                </div>
                                <p v-if="section.intro" class="text-[14px] leading-[1.8] text-[#3D3D3A] mb-5">{{ section.intro }}</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div v-for="(item, i) in section.items" :key="`gcd-${i}`"
                                        class="flex items-start gap-3">
                                        <img src="/icons/ft-done.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="" />
                                        <div>
                                            <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-1">{{ item.title }}</p>
                                            <p v-if="item.desc" class="text-[12px] leading-[1.6] text-[#686964]">{{ item.desc }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Type: numbered_detail (numbered list dengan sub-bullets) -->
                            <div v-else-if="section.type === 'numbered_detail'"
                                class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                <div class="flex items-center gap-3 mb-5">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ section.title }}</h2>
                                </div>
                                <p v-if="section.intro" class="text-[14px] leading-[1.8] text-[#3D3D3A] mb-5">{{ section.intro }}</p>
                                <ol class="space-y-4">
                                    <li v-for="(item, ni) in section.items" :key="`nd-${ni}`">
                                        <p class="text-[14px] text-[#1A1B18] leading-snug mb-1.5">
                                            <span class="font-normal">{{ ni + 1 }}.&nbsp;</span>
                                            <span class="font-bold">{{ item.title }}</span>
                                        </p>
                                        <p v-if="item.desc" class="text-[14px] leading-[1.7] text-[#3D3D3A] mb-2 pl-5">{{ item.desc }}</p>
                                        <ul v-if="item.bullets?.length" class="space-y-1 pl-5">
                                            <li v-for="(b, bi) in item.bullets" :key="`ndb-${ni}-${bi}`"
                                                class="flex items-start gap-2 text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                <span class="mt-[6px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                                <span>{{ b }}</span>
                                            </li>
                                        </ul>
                                    </li>
                                </ol>
                            </div>

                            <!-- Type: numbered_accordion (collapsible numbered list) -->
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
                                    <div v-for="(item, ni) in section.items" :key="`na-${ni}`" class="flex gap-4">
                                        <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary text-white text-[12px] font-bold mt-0.5">
                                            {{ ni + 1 }}
                                        </span>
                                        <div class="flex-1">
                                            <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-1">{{ item.title }}</p>
                                            <p v-if="item.desc" class="text-[13px] leading-[1.6] text-[#3D3D3A] mb-2">{{ item.desc }}</p>
                                            <ul v-if="item.bullets?.length" class="space-y-1">
                                                <li v-for="(b, bi) in item.bullets" :key="`nab-${ni}-${bi}`"
                                                    class="flex items-start gap-2 text-[12px] leading-[1.6] text-[#3D3D3A]">
                                                    <span class="mt-[6px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                                    <span>{{ b }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </template>

                        <!-- 3. Biaya Layanan -->
                        <div v-if="product.biaya_layanan_cards?.length || product.biaya_layanan_single"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Biaya Layanan</h2>
                            </div>

                            <!-- Grid cards (2x2) -->
                            <div v-if="product.biaya_layanan_cards?.length"
                                class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div v-for="(card, ci) in product.biaya_layanan_cards" :key="`card-${ci}`"
                                    class="rounded-xl border border-[#E8E8E6] p-5 flex flex-col">
                                    <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-1">{{ card.nama }}</p>
                                    <p class="text-[11px] text-[#686964] mb-0.5">{{
                                        t(
                                            "services.perpajakanDanPembukuanDetail.plans.mulai_dari",
                                        )
                                    }}</p>
                                    <p class="text-[22px] font-bold text-primary leading-tight mb-2">{{ card.harga }}</p>
                                    <div v-if="card.gratis_konsultasi" class="flex items-center gap-1.5 mb-4">
                                        <img src="/icons/ft-done.svg" class="h-4 w-4 flex-shrink-0" alt="" />
                                        <span class="text-[11px] text-[#3D3D3A]">GRATIS Konsultasi Persiapan dan Pasca Selesai</span>
                                    </div>
                                    <div v-if="card.mendapatkan?.length" class="mb-4">
                                        <p class="text-[12px] font-bold text-[#1A1B18] mb-2">Mendapatkan</p>
                                        <ul class="space-y-1.5">
                                            <li v-for="(m, mi) in card.mendapatkan" :key="`cm-${ci}-${mi}`"
                                                class="flex items-start gap-2">
                                                <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                                <span class="text-[12px] leading-[1.6] text-[#3D3D3A]">{{ m }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div v-if="card.termasuk?.length" class="mb-5">
                                        <p class="text-[12px] font-bold text-[#1A1B18] mb-2">{{
                                            t(
                                                "services.perpajakanDanPembukuanDetail.plans.termasuk",
                                            )
                                        }}</p>
                                        <ul class="space-y-1.5">
                                            <li v-for="(item, ti) in card.termasuk" :key="`ct-${ci}-${ti}`"
                                                class="flex items-start gap-2">
                                                <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                                <span class="text-[12px] leading-[1.6] text-[#3D3D3A]">{{ item }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mt-auto pt-2">
                                        <a :href="buildWhatsappLink(card.nama)"
                                            target="_blank" rel="noopener noreferrer"
                                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-3 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors">
                                            {{
                                                t(
                                                    "services.perpajakanDanPembukuanDetail.plans.pesan",
                                                )
                                            }}
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Single card -->
                            <div v-else-if="product.biaya_layanan_single"
                                class="rounded-xl border border-[#E8E8E6] p-5">
                                <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-1">
                                    {{ product.biaya_layanan_single.nama }}
                                </p>
                                <p class="text-[11px] text-[#686964] mb-0.5">{{
                                    t(
                                        "services.perpajakanDanPembukuanDetail.plans.mulai_dari",
                                    )
                                }}</p>
                                <p class="text-[24px] font-bold text-primary leading-tight mb-2">
                                    {{ product.biaya_layanan_single.harga }}
                                </p>
                                <div v-if="product.biaya_layanan_single.gratis_konsultasi"
                                    class="flex items-center gap-1.5 mb-4">
                                    <img src="/icons/ft-done.svg" class="h-4 w-4 flex-shrink-0" alt="" />
                                    <span class="text-[11px] text-[#3D3D3A]">GRATIS Konsultasi Persiapan dan Pasca Selesai</span>
                                </div>
                                <hr class="border-[#E8E8E6] mb-4" />
                                <div v-if="product.biaya_layanan_single.mendapatkan?.length" class="mb-4">
                                    <p class="text-[13px] font-bold text-[#1A1B18] mb-3">Mendapatkan</p>
                                    <ul class="space-y-2">
                                        <li v-for="(m, mi) in product.biaya_layanan_single.mendapatkan" :key="`sm-${mi}`"
                                            class="flex items-start gap-2">
                                            <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                            <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{ m }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="product.biaya_layanan_single.termasuk?.length" class="mb-5">
                                    <p class="text-[13px] font-bold text-[#1A1B18] mb-3">{{
                                        t(
                                            "services.perpajakanDanPembukuanDetail.plans.termasuk",
                                        )
                                    }}</p>
                                    <ul class="space-y-2">
                                        <li v-for="(item, ti) in product.biaya_layanan_single.termasuk" :key="`st-${ti}`"
                                            class="flex items-start gap-2">
                                            <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                            <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{ item }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <a :href="buildWhatsappLink(product.biaya_layanan_single.nama)"
                                    target="_blank" rel="noopener noreferrer"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-3 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors">
                                    {{
                                        t(
                                            "services.perpajakanDanPembukuanDetail.plans.pesan",
                                        )
                                    }}
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            </div>
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
                                    <span class="text-[14px] font-extrabold uppercase tracking-widest text-white">{{
                                        t(
                                            "services.perpajakanDanPembukuanDetail.sidebar.vip_title",
                                        )
                                    }}</span>
                                </div>
                            </div>
                            <p class="relative text-[14px] leading-[1.6] text-white/90 mb-5">
                                {{
                                    t(
                                        "services.perpajakanDanPembukuanDetail.sidebar.vip_desc",
                                    )
                                }}
                            </p>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{
                                    t(
                                        "services.perpajakanDanPembukuanDetail.sidebar.vip_cta",
                                    )
                                }}
                            </a>
                            <div class="relative mt-3 text-[11px] text-white/60">{{
                                t(
                                    "services.perpajakanDanPembukuanDetail.sidebar.vip_note",
                                )
                            }}</div>
                        </div>

                        <!-- Price Card dengan dropdown -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <!-- Dropdown nama produk -->
                            <div class="mb-4 flex items-center justify-between rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] px-3 py-2.5">
                                <span class="text-[12px] text-[#1A1B18] truncate font-medium uppercase">
                                    {{ product.name }}
                                </span>
                                <svg class="h-4 w-4 flex-shrink-0 text-[#686964]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <div class="text-[12px] text-[#686964] mb-1">{{
                                t(
                                    "services.perpajakanDanPembukuanDetail.plans.mulai_dari",
                                )
                            }}</div>
                            <div class="text-[28px] font-bold leading-none text-primary mb-4">
                                {{ product.price_label }}
                            </div>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors mb-4">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{
                                    t(
                                        "services.perpajakanDanPembukuanDetail.sidebar.konsultasi_cta",
                                    )
                                }}
                            </a>
                            <!-- Keunggulan checklist -->
                            <ul class="space-y-2">
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="h-4 w-4 flex-shrink-0" alt="" />
                                    Konsultasi pertama gratis
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="h-4 w-4 flex-shrink-0" alt="" />
                                    Harga transparan, tanpa biaya tersembunyi
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="h-4 w-4 flex-shrink-0" alt="" />
                                    Tim berpengalaman 18+ tahun
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="h-4 w-4 flex-shrink-0" alt="" />
                                    Update proses berkala via WhatsApp
                                </li>
                            </ul>
                        </div>

                        <!-- Layanan Terkait -->
                        <div v-if="relatedProducts.length" class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">{{
                                t(
                                    "services.perpajakanDanPembukuanDetail.sidebar.related_title",
                                )
                            }}</h3>
                            <div class="flex flex-col gap-3">
                                <a v-for="(related, index) in relatedProducts.slice(0, 3)" :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex flex-col gap-2 rounded-xl border border-[#E8E8E6] bg-white p-4 hover:border-primary/30 hover:shadow-sm transition-all">
                                    <p class="text-[13px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors leading-snug">
                                        {{ pick(related.name) }}
                                    </p>
                                    <p class="text-[12px] leading-[1.5] text-[#686964] line-clamp-2">
                                        {{ pick(related.excerpt) }}
                                    </p>
                                    <div class="flex items-center justify-between mt-1">
                                        <div>
                                            <div class="text-[11px] text-[#686964]">{{
                                                t(
                                                    "services.perpajakanDanPembukuanDetail.sidebar.related_from",
                                                )
                                            }}</div>
                                            <div class="text-[16px] font-bold text-primary leading-tight">
                                                {{ related.price_label }}
                                            </div>
                                        </div>
                                        <span v-if="related.paket_count"
                                            class="text-[11px] text-[#686964] border border-[#E8E8E6] rounded px-2 py-0.5">
                                            {{ related.paket_count }}
                                            {{
                                                t(
                                                    "services.perpajakanDanPembukuanDetail.sidebar.related_packages",
                                                )
                                            }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-center gap-2 rounded-xl border border-primary py-2 text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors">
                                        {{
                                            t(
                                                "services.perpajakanDanPembukuanDetail.sidebar.related_cta",
                                            )
                                        }}
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                    <!-- ===== END KANAN ===== -->

                </div>
            </div>
        </section>

        <FooterCTA
            title="Kelola Keuangan Perusahaan dengan Lebih Baik Bersama Fasttrack"
            description="Pembukuan yang rapi dan laporan keuangan yang akurat merupakan investasi penting bagi keberlangsungan dan pertumbuhan perusahaan. Dengan dukungan sistem administrasi keuangan yang baik, perusahaan dapat mengambil keputusan yang lebih tepat, menjaga kepatuhan, dan membangun fondasi bisnis yang lebih kuat."
            button-text="Chat Langsung via Whatsapp"
            :whatsapp-link="buildWhatsappLink(product.name)"
        />
    </MainLayout>
</template>