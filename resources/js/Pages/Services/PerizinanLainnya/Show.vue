<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { computed } from "vue";
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

    const fs = p.fungsi_strategis;
    const syarat = p.syarat ?? {};
    const pp = p.peraturan_perusahaan;
    const rb = p.rincian_biaya;

    return {
        ...p,
        name: pick(p.name),
        tag: pick(p.tag),
        excerpt: pick(p.excerpt),
        penjelasan_umum: pick(p.penjelasan_umum) ?? [],
        fungsi_strategis: fs
            ? {
                  ...fs,
                  title: pick(fs.title),
                  desc: pick(fs.desc),
                  items: pick(fs.items) ?? [],
                  note: pick(fs.note),
              }
            : fs,
        dokumen_didapat: pick(p.dokumen_didapat) ?? [],
        syarat: syarat.sections
            ? {
                  ...syarat,
                  sections: syarat.sections.map((section) => ({
                      ...section,
                      label: pick(section.label),
                      groups: (section.groups ?? []).map((group) => ({
                          ...group,
                          notes: pick(group.notes) ?? [],
                      })),
                  })),
              }
            : syarat,
        peraturan_perusahaan: pp
            ? {
                  ...pp,
                  intro: pick(pp.intro),
                  items: pick(pp.items) ?? [],
              }
            : pp,
        rincian_biaya: rb
            ? {
                  ...rb,
                  items: pick(rb.items) ?? [],
                  total_label: pick(rb.total_label),
              }
            : rb,
        dasar_hukum: pick(p.dasar_hukum) ?? [],
        faq: pick(p.faq) ?? [],
    };
});
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
                    <div class="inline-flex items-center gap-2 rounded-md bg-white px-4 py-2">
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
                        <a href="/layanan" class="text-sm font-medium text-[#9e1f16] hover:underline">{{ t("services.perizinanLainnyaDetail.breadcrumb.layanan") }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/perizinan-lainnya"
                            class="text-sm font-medium text-[#9e1f16] hover:underline">{{ t("services.perizinanLainnyaDetail.breadcrumb.current") }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#9e1f16]">{{ localizedProduct.name }}</span>
                    </div>
                </nav>

                <!-- Center: Heading -->
                <div class="flex items-center gap-5">
                    <div
                        class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white shadow-md">
                        <img src="/icons/ft-persons.svg" class="w-9 h-9" alt="" />
                    </div>
                    <h1
                        class="text-3xl font-extrabold leading-tight text-white sm:text-2xl lg:text-3xl max-w-[800px] line-clamp-2">
                        {{ localizedProduct.name }}
                    </h1>
                </div>

                <!-- Bottom: Back button -->
                <div>
                    <a href="/perizinan-lainnya"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ t("services.perizinanLainnyaDetail.back") }}
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section id="edukasi" class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[1fr_280px] xl:grid-cols-[1fr_300px]">

                    <!-- ===== KIRI: Konten Utama ===== -->
                    <div class="flex flex-col gap-6">

                        <!-- 1. Penjelasan Umum -->
                        <div v-if="localizedProduct.penjelasan_umum?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ t("services.perizinanLainnyaDetail.sections.penjelasan") }}
                                </h2>
                            </div>
                            <div class="space-y-4">
                                <p v-for="(paragraph, index) in localizedProduct.penjelasan_umum" :key="`penjelasan-${index}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">
                                    {{ paragraph }}
                                </p>
                            </div>
                        </div>

                        <!-- 2. Fungsi Strategis (opsional) -->
                        <div v-if="localizedProduct.fungsi_strategis"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ localizedProduct.fungsi_strategis.title }}
                                </h2>
                            </div>
                            <p v-if="localizedProduct.fungsi_strategis.desc"
                                class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">
                                {{ localizedProduct.fungsi_strategis.desc }}
                            </p>
                            <ul class="space-y-2 mb-4">
                                <li v-for="(item, index) in localizedProduct.fungsi_strategis.items" :key="`fungsi-${index}`"
                                    class="flex items-start gap-2 text-[14px] leading-[1.7] text-[#3D3D3A]">
                                    <span class="mt-[6px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                    <span>{{ item }}</span>
                                </li>
                            </ul>
                            <p v-if="localizedProduct.fungsi_strategis.note"
                                class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">
                                {{ localizedProduct.fungsi_strategis.note }}
                            </p>
                        </div>

                        <!-- 3. Dokumen yang Didapat -->
                        <div v-if="localizedProduct.dokumen_didapat?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    Dokumen yang Akan di Dapatkan
                                </h2>
                            </div>
                            <ul class="space-y-3">
                                <li v-for="(doc, index) in localizedProduct.dokumen_didapat" :key="`dok-${index}`"
                                    class="flex items-start gap-2.5">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{ doc }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- 4. Syarat -->
                        <div v-if="localizedProduct.syarat?.sections?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ t("services.perizinanLainnyaDetail.sections.syarat") }}
                                </h2>
                            </div>
                            <div class="space-y-6">
                                <div v-for="(section, sIndex) in localizedProduct.syarat.sections"
                                    :key="`syarat-section-${sIndex}`">
                                    <p class="text-[13px] font-bold text-[#1A1B18] mb-3">
                                        {{ section.label }}
                                    </p>
                                    <div v-for="(group, gIndex) in section.groups"
                                        :key="`syarat-group-${sIndex}-${gIndex}`" class="mb-4 last:mb-0">
                                        <p v-if="group.label" class="text-[13px] font-semibold text-[#3D3D3A] mb-2">
                                            {{ group.label }}
                                        </p>
                                        <ol class="space-y-2.5 pl-1">
                                            <li v-for="(note, nIndex) in group.notes"
                                                :key="`syarat-note-${sIndex}-${gIndex}-${nIndex}`"
                                                class="flex gap-2.5 text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                <span class="flex-shrink-0 font-semibold text-[#1A1B18]">
                                                    {{ nIndex + 1 }}.
                                                </span>
                                                <span>{{ note }}</span>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Peraturan Perusahaan (opsional) -->
                        <div v-if="localizedProduct.peraturan_perusahaan?.items?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    Peraturan Perusahaan
                                </h2>
                            </div>

                            <!-- Intro -->
                            <p v-if="localizedProduct.peraturan_perusahaan.intro"
                                class="text-[13px] font-bold text-[#1A1B18] mb-4">
                                {{ localizedProduct.peraturan_perusahaan.intro }}
                            </p>

                            <!-- Items -->
                            <div class="space-y-5">
                                <div v-for="(item, index) in localizedProduct.peraturan_perusahaan.items" :key="`pp-${index}`">
                                    <!-- Title row dengan icon centang hijau -->
                                    <div class="flex items-center gap-3 mb-2">
                                        <img src="/icons/ft-done.svg" class="h-5 w-5 flex-shrink-0" alt="done" />
                                        <span class="text-[14px] font-semibold text-[#1A1B18]">
                                            {{ item.title }}
                                        </span>
                                    </div>

                                    <!-- Sub-bullets -->
                                    <ul v-if="item.bullets?.length" class="ml-8 space-y-1">
                                        <li v-for="(bullet, bIndex) in item.bullets"
                                            :key="`pp-bullet-${index}-${bIndex}`"
                                            class="flex items-start gap-2 text-[13px] leading-[1.7] text-[#3D3D3A]">
                                            <span
                                                class="mt-[7px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                            <span>{{ bullet }}</span>
                                        </li>
                                    </ul>

                                    <!-- Note/paragraf -->
                                    <p v-if="item.note" class="ml-8 text-[13px] leading-[1.7] text-[#3D3D3A]">
                                        {{ item.note }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Biaya Layanan -->
                        <div v-if="localizedProduct.rincian_biaya"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    Biaya Layanan
                                </h2>
                            </div>

                            <!-- Card merah full-width -->
                            <div class="rounded-xl overflow-hidden"
                                style="background-image: url('/images/card-arrow-item-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                                <div class="flex items-center gap-4 px-5 py-5">
                                    <div
                                        class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-white">
                                        <img src="/icons/ft-persons.svg" class="w-5 h-5" alt="" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-[12px] text-white/70 mb-0.5">
                                            {{ localizedProduct.rincian_biaya.total_label }}
                                        </div>
                                        <div class="text-[16px] font-semibold text-white leading-tight truncate">
                                            {{ localizedProduct.rincian_biaya.total_amount }}
                                        </div>
                                    </div>
                                    <a :href="buildWhatsappLink(localizedProduct.name)" target="_blank" rel="noopener noreferrer"
                                        class="flex items-center gap-1.5 rounded-lg bg-white px-4 py-2.5 text-[13px] font-semibold text-primary whitespace-nowrap hover:bg-white/90 transition-colors flex-shrink-0">
                                        {{ t("services.perizinanLainnyaDetail.plans.pesan") }}
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Rincian item biaya -->
                            <div v-if="localizedProduct.rincian_biaya.items?.length" class="mt-5 space-y-3">
                                <div v-for="(item, index) in localizedProduct.rincian_biaya.items" :key="`biaya-${index}`"
                                    class="flex items-center justify-between gap-4 border-b border-[#F0F0EE] pb-3 last:border-0 last:pb-0">
                                    <span class="text-[13px] leading-[1.5] text-[#3D3D3A]">{{ item.label }}</span>
                                    <span class="text-[13px] font-semibold text-black whitespace-nowrap">{{ item.amount
                                        }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Dasar Hukum -->
                        <div v-if="localizedProduct.dasar_hukum?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    Dasar Hukum
                                </h2>
                            </div>
                            <ul class="space-y-4">
                                <li v-for="(hukum, index) in localizedProduct.dasar_hukum" :key="`hukum-${index}`"
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
                    <!-- ===== END KIRI ===== -->

                    <!-- ===== KANAN: Sidebar ===== -->
                    <div class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start">

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
                            <a :href="buildWhatsappLink(localizedProduct.name)" target="_blank" rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                Pesan Layanan Sekarang
                            </a>
                            <div class="relative mt-3 text-[11px] text-white/60">
                                * (S&amp;K BERLAKU)
                            </div>
                        </div>

                        <!-- Price Card -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <div
                                class="mb-4 flex items-center justify-between rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] px-3 py-2.5">
                                <span class="text-[13px] text-[#1A1B18] truncate">{{ localizedProduct.name }}</span>
                                <svg class="h-4 w-4 flex-shrink-0 text-[#686964]" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <div class="text-[12px] text-[#686964] mb-1">Estimasi total biaya</div>
                            <div class="text-[32px] font-bold leading-none text-primary mb-1">
                                {{ localizedProduct.rincian_biaya?.total_amount ?? localizedProduct.price_label }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">
                                *Harga final dikonfirmasi setelah konsultasi
                            </div>
                            <a :href="buildWhatsappLink(localizedProduct.name)" target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-6 w-6 flex-shrink-0" alt="wa" />
                                Konsultasi Gratis via Whatsapp
                            </a>
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Konsultasi pertama gratis
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Harga transparan, tanpa biaya tersembunyi
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Tim berpengalaman 18+ tahun
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Update proses berkala via WhatsApp
                                </li>
                            </ul>
                        </div>

                        <!-- Layanan Terkait -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">Layanan Terkait</h3>
                            <div class="flex flex-col gap-3">
                                <a v-for="(related, index) in relatedProducts.slice(0, 3)" :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex flex-col gap-2 rounded-xl border border-[#E8E8E6] bg-white p-4 hover:border-primary/30 hover:shadow-sm transition-all">
                                    <div
                                        class="text-[14px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors">
                                        {{ related.name }}
                                    </div>
                                    <p class="text-[12px] leading-[1.6] text-[#686964] line-clamp-3">
                                        {{ related.excerpt ?? related.description }}
                                    </p>
                                    <hr class="border-[#E8E8E6]" />
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-[11px] text-[#686964] mb-0.5">Mulai dari</div>
                                            <div class="text-[18px] font-bold text-primary leading-none">
                                                {{ related.price_label }}
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-1 flex items-center justify-center gap-2 rounded-xl border border-primary py-2.5 text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors">
                                        Selengkapnya
                                        <svg class="h-4 w-4 group-hover:translate-x-0.5 transition-transform"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
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

        <!-- Footer CTA Banner -->
        <section id="footer" class="bg-[#F7F7F5] mb-12 sm:mb-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-2xl bg-[#9e1f16] px-6 py-12 sm:px-10 sm:py-14">
                    <img src="/icons/ft-docs.svg" alt=""
                        class="absolute right-6 top-6 h-16 w-16 opacity-20 sm:right-10 sm:top-8 sm:h-24 sm:w-24" />
                    <div class="relative flex flex-col items-center text-center">
                        <h3
                            class="max-w-2xl text-[22px] font-bold leading-[32px] text-white sm:text-[28px] sm:leading-[38px]">
                            Butuh Konsultasi Soal Izin Tinggal Orang Asing?
                        </h3>
                        <p
                            class="mt-4 max-w-lg text-[14px] leading-[22px] text-white/80 sm:text-[16px] sm:leading-[24px]">
                            Tim Fasttrack siap membantu memilih kategori ITAS yang<br class="hidden sm:block" />
                            tepat dan mendampingi seluruh prosesnya.
                        </p>
                        <a :href="buildWhatsappLink('Izin Tinggal Terbatas')" target="_blank" rel="noopener noreferrer"
                            class="mt-8 inline-flex items-center gap-2.5 rounded-lg bg-[#25D366] px-6 py-3 text-[14px] font-semibold text-white shadow-lg shadow-[#25D366]/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#20BD5A] hover:shadow-xl hover:shadow-[#25D366]/40 sm:px-8 sm:py-3.5 sm:text-[15px]">
                            Chat Langsung via WhatsApp
                            <img src="/icons/ft-wa.svg" alt="WhatsApp" class="h-5 w-5" />
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>