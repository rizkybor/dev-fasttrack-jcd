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

const { buildWhatsappLink } = useWhatsapp("imigrasi");

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
        tabs: pick(p.tabs),
        penjelasan_umum: pick(p.penjelasan_umum),
        dokumen_persyaratan: pick(p.dokumen_persyaratan),
        biaya_layanan: pick(p.biaya_layanan),
        biaya_layanan_tabs: pick(p.biaya_layanan_tabs),
        faq: pick(p.faq) ?? [],
    };
});

const product = localizedProduct;

// Tab jenis pengajuan (opsional)
const activeTab = ref(0);
const hasTabs = computed(() => !!product.value?.tabs?.length);
const currentTab = computed(() =>
    hasTabs.value ? product.value.tabs[activeTab.value] : null
);

// Data yang ditampilkan: dari tab aktif atau langsung dari product
const currentPenjelasan = computed(() =>
    currentTab.value ? currentTab.value.penjelasan_umum : product.value.penjelasan_umum
);
const currentDokumen = computed(() =>
    currentTab.value ? currentTab.value.dokumen_persyaratan : product.value.dokumen_persyaratan
);
const currentBiaya = computed(() =>
    currentTab.value ? currentTab.value.biaya_layanan : product.value.biaya_layanan
);
const currentSidebarPrice = computed(() =>
    currentTab.value
        ? { label: currentTab.value.sidebar_label, harga: currentTab.value.sidebar_harga }
        : { label: product.value.name, harga: product.value.price_label }
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
                        <a href="/layanan" class="text-sm font-medium text-[#9e1f16] hover:underline">{{ t('services.keimigrasianWniWnaDetail.breadcrumb.layanan') }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/keimigrasian-wni-wna" class="text-sm font-medium text-[#9e1f16] hover:underline">{{ t('services.keimigrasianWniWnaDetail.breadcrumb.current') }}</a>
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
                    <a href="/keimigrasian-wni-wna"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ t('services.keimigrasianWniWnaDetail.back') }}
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

                        <!-- 1. Tab Jenis Pengajuan (opsional) -->
                        <div v-if="hasTabs"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ t('services.keimigrasianWniWnaDetail.sections.tab_title') }}</h2>
                            </div>
                            <div class="inline-flex rounded-lg border border-[#E8E8E6] overflow-hidden">
                                <button
                                    v-for="(tab, ti) in product.tabs"
                                    :key="`tab-${ti}`"
                                    @click="activeTab = ti"
                                    class="px-5 py-2 text-[13px] font-bold transition-colors"
                                    :class="activeTab === ti
                                        ? 'bg-primary text-white'
                                        : 'bg-white text-[#686964] hover:bg-[#F7F7F5]'">
                                    {{ tab.label }}
                                </button>
                            </div>
                        </div>

                        <!-- 2. Penjelasan Umum -->
                        <div v-if="currentPenjelasan?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ t('services.keimigrasianWniWnaDetail.sections.penjelasan') }}</h2>
                            </div>
                            <div class="space-y-4">
                                <p v-for="(p, i) in currentPenjelasan" :key="`pu-${i}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">{{ p }}</p>
                            </div>
                        </div>

                        <!-- 3. Dokumen Persyaratan -->
                        <div v-if="currentDokumen?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ t('services.keimigrasianWniWnaDetail.sections.dokumen_persyaratan') }}</h2>
                            </div>
                            <div class="space-y-5">
                                <div v-for="(group, gi) in currentDokumen" :key="`dg-${gi}`"
                                    class="flex gap-4">
                                    <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary text-white text-[12px] font-bold mt-0.5">
                                        {{ gi + 1 }}
                                    </span>
                                    <div class="flex-1">
                                        <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-2">{{ group.label }}</p>
                                        <!-- Sub-groups (A., B., dst) -->
                                        <template v-if="group.sub_groups?.length">
                                            <div v-for="(sub, si) in group.sub_groups" :key="`sg-${gi}-${si}`" class="mb-3">
                                                <p v-if="sub.label" class="text-[13px] font-semibold text-[#1A1B18] mb-1.5">
                                                    {{ sub.label }}
                                                </p>
                                                <ol class="space-y-1">
                                                    <li v-for="(item, ii) in sub.items" :key="`sgi-${gi}-${si}-${ii}`"
                                                        class="text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                        {{ ii + 1 }}. {{ item }}
                                                    </li>
                                                </ol>
                                            </div>
                                        </template>
                                        <!-- Items langsung (tanpa sub-group) -->
                                        <ol v-else-if="group.items?.length" class="space-y-1">
                                            <li v-for="(item, ii) in group.items" :key="`gi-${gi}-${ii}`"
                                                class="text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                {{ ii + 1 }}. {{ item }}
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Biaya Layanan -->
                        <div v-if="currentBiaya"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ t('services.keimigrasianWniWnaDetail.sections.biaya_layanan') }}</h2>
                            </div>
                            <div class="rounded-xl border border-[#E8E8E6] p-5">
                                <div class="flex items-start justify-between gap-2 mb-1">
                                    <p class="text-[13px] font-bold text-[#1A1B18] min-w-0 flex-1">{{ currentBiaya.nama }}</p>
                                    <span v-if="currentBiaya.harga_note"
                                        class="text-[11px] text-[#686964] text-right flex-shrink-0 max-w-[45%]">
                                        {{ currentBiaya.harga_note }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-[#686964] mb-0.5">{{ t('services.keimigrasianWniWnaDetail.plans.mulai_dari') }}</p>
                                <p class="text-[26px] font-bold text-primary leading-tight mb-2">{{ currentBiaya.harga }}</p>
                                <div v-if="currentBiaya.gratis_konsultasi" class="flex items-center gap-1.5 mb-4">
                                    <img src="/icons/ft-done.svg" class="h-4 w-4 flex-shrink-0" alt="" />
                                    <span class="text-[11px] text-[#3D3D3A]">{{ t('services.keimigrasianWniWnaDetail.plans.gratis_konsultasi') }}</span>
                                </div>
                                <hr class="border-[#E8E8E6] mb-4" />
                                <div v-if="currentBiaya.mendapatkan?.length" class="mb-4">
                                    <p class="text-[13px] font-bold text-[#1A1B18] mb-3">{{ t('services.keimigrasianWniWnaDetail.plans.mendapatkan') }}</p>
                                    <ul class="space-y-2">
                                        <li v-for="(m, mi) in currentBiaya.mendapatkan" :key="`bm-${mi}`"
                                            class="flex items-start gap-2">
                                            <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                            <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{ m }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="currentBiaya.termasuk?.length" class="mb-5">
                                    <p class="text-[13px] font-bold text-[#1A1B18] mb-3">{{ t('services.keimigrasianWniWnaDetail.plans.termasuk') }}</p>
                                    <ul class="space-y-2">
                                        <li v-for="(t, ti) in currentBiaya.termasuk" :key="`bt-${ti}`"
                                            class="flex items-start gap-2">
                                            <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                            <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{ t }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <a :href="buildWhatsappLink(currentBiaya.nama)"
                                    target="_blank" rel="noopener noreferrer"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-3 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors">
                                    {{ t('services.keimigrasianWniWnaDetail.plans.pesan') }}
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
                                    <span class="text-[14px] font-extrabold uppercase tracking-widest text-white">{{ t('services.keimigrasianWniWnaDetail.sidebar.vip_title') }}</span>
                                </div>
                            </div>
                            <p class="relative text-[14px] leading-[1.6] text-white/90 mb-5">
                                {{ t('services.keimigrasianWniWnaDetail.sidebar.vip_desc') }}
                            </p>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{ t('services.keimigrasianWniWnaDetail.sidebar.vip_cta') }}
                            </a>
                            <div class="relative mt-3 text-[11px] text-white/60">{{ t('services.keimigrasianWniWnaDetail.sidebar.vip_note') }}</div>
                        </div>

                        <!-- Price Card (reaktif ke tab aktif) -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <div class="mb-3 inline-flex items-center gap-1.5 rounded-full bg-[#FFF0EF] px-3 py-1">
                                <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                <span class="text-[11px] font-semibold text-primary">{{ t('services.keimigrasianWniWnaDetail.sidebar.free_konsultasi_badge') }}</span>
                            </div>
                            <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-3">
                                {{ currentSidebarPrice.label }}
                            </p>
                            <div class="text-[12px] text-[#686964] mb-1">{{ t('services.keimigrasianWniWnaDetail.sidebar.biaya_penanganan') }}</div>
                            <div class="text-[28px] font-bold leading-none text-primary mb-4">
                                {{ currentSidebarPrice.harga }}
                            </div>
                            <a :href="buildWhatsappLink(currentSidebarPrice.label)" target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg border border-[#E8E8E6] py-2.5 text-[13px] font-semibold text-[#3D3D3A] hover:bg-[#F7F7F5] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{ t('services.keimigrasianWniWnaDetail.sidebar.konsultasi_cta') }}
                            </a>
                        </div>

                        <!-- Layanan Terkait -->
                        <div v-if="relatedProducts.length" class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">{{ t('services.keimigrasianWniWnaDetail.sidebar.related_title') }}</h3>
                            <div class="flex flex-col gap-4">
                                <a v-for="(related, index) in relatedProducts.slice(0, 3)" :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex flex-col gap-2 rounded-xl border border-[#E8E8E6] bg-white p-4 hover:border-primary/30 hover:shadow-sm transition-all">
                                    <p class="text-[13px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors leading-snug">
                                        {{ pick(related.name) }}
                                    </p>
                                    <p class="text-[12px] leading-[1.5] text-[#686964] line-clamp-3">
                                        {{ pick(related.excerpt) }}
                                    </p>
                                    <div class="flex items-center justify-between mt-1">
                                        <div>
                                            <div class="text-[11px] text-[#686964]">{{ t('services.keimigrasianWniWnaDetail.sidebar.related_from') }}</div>
                                            <div class="text-[16px] font-bold text-primary leading-tight">
                                                {{ related.price_label }}
                                            </div>
                                        </div>
                                        <span v-if="related.paket_count"
                                            class="text-[11px] text-[#686964] border border-[#E8E8E6] rounded px-2 py-0.5">
                                            {{ related.paket_count }} {{ t('services.keimigrasianWniWnaDetail.sidebar.related_packages') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-center gap-2 rounded-xl border border-primary py-2 text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors">
                                        {{ t('services.keimigrasianWniWnaDetail.sidebar.related_cta') }}
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
            :title="t('services.keimigrasianWniWnaDetail.footer.title')"
            :description="t('services.keimigrasianWniWnaDetail.footer.desc')"
            :button-text="t('services.keimigrasianWniWnaDetail.footer.cta')"
            :whatsapp-link="buildWhatsappLink(product.name)"
        />
    </MainLayout>
</template>