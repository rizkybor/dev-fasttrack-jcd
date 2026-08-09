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

// Icon tidak perlu ditranslasi, sama untuk semua item
const itemIcon = "/icons/layanan/visa.svg";

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

    return {
        ...p,
        name: pick(p.name),
        excerpt: pick(p.excerpt),
        tabs: pick(p.tabs),
        penjelasan_umum: pick(p.penjelasan_umum),
        dokumen_didapat: pick(p.dokumen_didapat),
        persyaratan_dokumen: pick(p.persyaratan_dokumen),
        rincian_biaya: pick(p.rincian_biaya),
        faq: pick(p.faq) ?? [],
    };
});

const product = localizedProduct;

const activeTab = ref(0);
const hasTabs = computed(() => !!product.value?.tabs?.length);
const currentTab = computed(() =>
    hasTabs.value ? product.value.tabs[activeTab.value] : null
);

const currentPenjelasan = computed(() =>
    currentTab.value ? currentTab.value.penjelasan_umum : product.value.penjelasan_umum
);
const currentDokumenDidapat = computed(() =>
    currentTab.value ? currentTab.value.dokumen_didapat : product.value.dokumen_didapat
);
const currentPersyaratan = computed(() =>
    currentTab.value ? currentTab.value.persyaratan_dokumen : product.value.persyaratan_dokumen
);
const currentRincianBiaya = computed(() =>
    currentTab.value ? currentTab.value.rincian_biaya : product.value.rincian_biaya
);
const currentSidebar = computed(() =>
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
                        <a href="/layanan" class="text-sm font-medium text-[#9e1f16] hover:underline">
                            {{
                                t(
                                    "services.visaMancanegaraDetail.breadcrumb.layanan",
                                )
                            }}
                        </a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/visa-mancanegara" class="text-sm font-medium text-[#9e1f16] hover:underline">
                            {{
                                t(
                                    "services.visaMancanegaraDetail.breadcrumb.current",
                                )
                            }}
                        </a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#9e1f16]">{{ product.name }}</span>
                    </div>
                </nav>
                <div class="flex items-center gap-5">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-white shadow-md md:h-16 md:w-16 md:rounded-2xl">
                        <img
                            :src="itemIcon"
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
                        {{ product.name }}
                    </h1>
                </div>
                <div>
                    <a href="/visa-mancanegara"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{
                            t(
                                "services.visaMancanegaraDetail.back",
                            )
                        }}
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

                        <!-- 1. Tab Jenis Visa (opsional) -->
                        <div v-if="hasTabs" class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Pilih Jenis Visa</h2>
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
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{
                                        t(
                                            "services.visaMancanegaraDetail.sections.penjelasan",
                                        )
                                    }}
                                </h2>
                            </div>
                            <div class="space-y-4">
                                <p v-for="(p, i) in currentPenjelasan" :key="`pu-${i}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">{{ p }}</p>
                            </div>
                        </div>

                        <!-- 3. Dokumen Yang Anda Dapatkan -->
                        <div v-if="currentDokumenDidapat"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Dokumen Yang Anda Dapatkan</h2>
                            </div>
                            <div class="rounded-xl border border-[#E8E8E6] p-5">
                                <div class="flex items-center gap-3 mb-4">
                                    <img src="/icons/ft-done.svg" class="h-6 w-6 flex-shrink-0" alt="" />
                                    <p class="text-[13px] font-bold text-[#1A1B18] uppercase tracking-wide">
                                        {{ currentDokumenDidapat.nama }}
                                    </p>
                                </div>
                                <div v-if="currentDokumenDidapat.termasuk?.length">
                                    <p class="text-[12px] font-bold text-[#1A1B18] mb-2">
                                        {{
                                            t(
                                                "services.visaMancanegaraDetail.plans.termasuk",
                                            )
                                        }}
                                    </p>
                                    <ul class="space-y-1.5">
                                        <li v-for="(t, ti) in currentDokumenDidapat.termasuk" :key="`dt-${ti}`"
                                            class="flex items-start gap-2 text-[13px] leading-[1.6] text-[#3D3D3A]">
                                            <span class="mt-[6px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                            <span>{{ t }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Persyaratan Dokumen -->
                        <div v-if="currentPersyaratan?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Persyaratan Dokumen</h2>
                            </div>
                            <div class="space-y-6">
                                <div v-for="(group, gi) in currentPersyaratan" :key="`pg-${gi}`">
                                    <p class="text-[13px] font-bold text-[#1A1B18] mb-3">{{ group.label }}</p>
                                    <ol class="space-y-2.5 pl-1">
                                        <li v-for="(item, ii) in group.items" :key="`pi-${gi}-${ii}`">
                                            <!-- String biasa -->
                                            <template v-if="typeof item === 'string'">
                                                <div class="flex gap-2 text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                    <span class="flex-shrink-0 font-medium">{{ ii + 1 }}.</span>
                                                    <span>{{ item }}</span>
                                                </div>
                                            </template>
                                            <!-- Object dengan sub_items dan/atau numbered_items -->
                                            <template v-else>
                                                <div v-if="item.text" class="flex gap-2 text-[13px] leading-[1.6] text-[#3D3D3A] mb-1.5">
                                                    <span class="flex-shrink-0 font-medium">{{ ii + 1 }}.</span>
                                                    <span>{{ item.text }}</span>
                                                </div>
                                                <!-- Sub bullets -->
                                                <ul v-if="item.sub_items?.length" class="space-y-1 pl-6 mb-2">
                                                    <li v-for="(sub, si) in item.sub_items" :key="`sub-${gi}-${ii}-${si}`"
                                                        class="flex items-start gap-2 text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                        <span class="mt-[6px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                                        <span>{{ sub }}</span>
                                                    </li>
                                                </ul>
                                                <!-- Numbered sub-items -->
                                                <ol v-if="item.numbered_items?.length" class="space-y-1 pl-6">
                                                    <li v-for="(ni, nii) in item.numbered_items" :key="`ni-${gi}-${ii}-${nii}`"
                                                        class="flex gap-2 text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                        <span class="flex-shrink-0 font-medium">{{ nii + 1 }}.</span>
                                                        <span>{{ ni }}</span>
                                                    </li>
                                                </ol>
                                            </template>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Rincian Biaya -->
                        <div v-if="currentRincianBiaya"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Rincian Biaya</h2>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4 items-stretch">
                                <!-- Tabel rincian kiri -->
                                <div class="flex-1">
                                    <div v-for="(item, ri) in currentRincianBiaya.items" :key="`rb-${ri}`"
                                        class="flex items-start justify-between gap-4 py-3 border-b border-[#F0F0EE] last:border-0">
                                        <span class="text-[13px] leading-[1.5] text-[#3D3D3A]">{{ item.label }}</span>
                                        <span class="text-[13px] font-semibold text-black whitespace-nowrap">{{ item.amount }}</span>
                                    </div>
                                </div>

                                <!-- Card merah kanan -->
                                <div
                                    class="sm:w-[320px] flex-shrink-0 rounded-xl overflow-hidden"
                                    style="background-image: url('/images/card-arrow-item-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                                    <div class="flex flex-col justify-between h-full p-5 gap-4 min-h-[100px]">
                                        <div>
                                            <div class="text-[11px] text-white/70 mb-0.5">Biaya Penanganan</div>
                                            <div class="text-[22px] font-bold text-white leading-tight">
                                                {{ currentRincianBiaya.biaya_penanganan }}
                                            </div>
                                        </div>
                                        <a :href="buildWhatsappLink(currentSidebar.label)"
                                            target="_blank" rel="noopener noreferrer"
                                            class="flex items-center justify-center gap-1.5 rounded-lg border border-white px-4 py-2.5 text-[13px] font-semibold text-white hover:bg-white/10 transition-colors">
                                            {{
                                                t(
                                                    "services.visaMancanegaraDetail.plans.pesan",
                                                )
                                            }}
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
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
                                    <span class="text-[14px] font-extrabold uppercase tracking-widest text-white">
                                        {{
                                            t(
                                                "services.visaMancanegaraDetail.sidebar.vip_title",
                                            )
                                        }}
                                    </span>
                                </div>
                            </div>
                            <p class="relative text-[14px] leading-[1.6] text-white/90 mb-5">
                                {{
                                    t(
                                        "services.visaMancanegaraDetail.sidebar.vip_desc",
                                    )
                                }}
                            </p>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{
                                    t(
                                        "services.visaMancanegaraDetail.sidebar.vip_cta",
                                    )
                                }}
                            </a>
                            <div class="relative mt-3 text-[11px] text-white/60">
                                {{
                                    t(
                                        "services.visaMancanegaraDetail.sidebar.vip_note",
                                    )
                                }}
                            </div>
                        </div>

                        <!-- Price Card (reaktif ke tab) -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <div class="mb-3 inline-flex items-center gap-1.5 rounded-full bg-[#FFF0EF] px-3 py-1">
                                <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                <span class="text-[11px] font-semibold text-primary">Free Konsultasi</span>
                            </div>
                            <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mt-2 mb-3">
                                {{ currentSidebar.label }}
                            </p>
                            <div class="text-[12px] text-[#686964] mb-1">Biaya Penanganan</div>
                            <div class="text-[26px] font-bold leading-none text-primary mb-4">
                                {{ currentSidebar.harga }}
                            </div>
                            <a :href="buildWhatsappLink(currentSidebar.label)" target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{
                                    t(
                                        "services.visaMancanegaraDetail.sidebar.konsultasi_cta",
                                    )
                                }}
                            </a>
                        </div>

                        <!-- Layanan Terkait -->
                        <div v-if="relatedProducts.length" class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">
                                {{
                                    t(
                                        "services.visaMancanegaraDetail.sidebar.related_title",
                                    )
                                }}
                            </h3>
                            <div class="flex flex-col gap-4">
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
                                            <div class="text-[11px] text-[#686964]">
                                                {{
                                                    t(
                                                        "services.visaMancanegaraDetail.sidebar.related_from",
                                                    )
                                                }}
                                            </div>
                                            <div class="text-[16px] font-bold text-primary leading-tight">
                                                {{ related.price_label }}
                                            </div>
                                        </div>
                                        <span v-if="related.paket_count"
                                            class="text-[11px] text-[#686964] border border-[#E8E8E6] rounded px-2 py-0.5">
                                            {{ related.paket_count }}
                                            {{
                                                t(
                                                    "services.visaMancanegaraDetail.sidebar.related_packages",
                                                )
                                            }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-center gap-2 rounded-xl border border-primary py-2 text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors">
                                        {{
                                            t(
                                                "services.visaMancanegaraDetail.sidebar.related_cta",
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
            :title="t('services.visaMancanegaraDetail.footer.title')"
            :description="t('services.visaMancanegaraDetail.footer.desc')"
            :button-text="t('services.visaMancanegaraDetail.footer.cta')"
            :whatsapp-link="buildWhatsappLink(product.name)"
        />
    </MainLayout>
</template>