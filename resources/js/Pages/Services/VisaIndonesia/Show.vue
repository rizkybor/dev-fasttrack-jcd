<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { ref, computed, watch } from "vue";
import { useWhatsapp } from "@/Composables/useWhatsapp.js";
import { useI18n } from "vue-i18n";

const { t, locale } = useI18n();

// Tambah di script setup
const activeBiayaTahun = ref(0);

const props = defineProps({
    product: { type: Object, required: true },
    relatedProducts: { type: Array, default: () => [] },
});

const { buildWhatsappLink } = useWhatsapp("visa");

// Recursively resolve setiap field translatable {id,en,zh} sesuai locale aktif
const pick = (obj) => {
    if (obj === null || obj === undefined) return obj;
    if (Array.isArray(obj)) return obj.map(pick);
    if (typeof obj === "object") {
        const keys = Object.keys(obj);
        if (keys.length === 3 && keys.includes("id") && keys.includes("en") && keys.includes("zh")) {
            return obj[locale.value] ?? obj.id;
        }
        const result = {};
        for (const k in obj) result[k] = pick(obj[k]);
        return result;
    }
    return obj;
};

const localizedProduct = computed(() => pick(props.product));
const localizedRelatedProducts = computed(() => props.relatedProducts.map(pick));

const activeIndex = ref(0);
const currentItem = computed(() => localizedProduct.value.index_list[activeIndex.value]);

const openSectionId = ref(null);
const toggleSection = (id) => {
    openSectionId.value = openSectionId.value === id ? null : id;
};

watch(activeIndex, () => {
    openSectionId.value = null;
    activeBiayaTahun.value = 0;
});

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
                        <a href="/layanan" class="text-sm font-medium text-[#9e1f16] hover:underline">
                            {{
                                t(
                                    "services.visaIndonesiaDetail.breadcrumb.layanan",
                                )
                            }}
                        </a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/visa-indonesia" class="text-sm font-medium text-[#9e1f16] hover:underline">
                            {{
                                t(
                                    "services.visaIndonesiaDetail.breadcrumb.current",
                                )
                            }}
                        </a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#9e1f16]">{{ localizedProduct.name }}</span>
                    </div>
                </nav>
                <div class="flex items-center gap-5">
                    <div
                        class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white shadow-md">
                        <img src="/icons/ft-persons.svg" class="w-9 h-9" alt="" />
                    </div>
                    <h1
                        class="text-3xl font-extrabold leading-tight text-white sm:text-4xl lg:text-5xl max-w-[800px] line-clamp-2">
                        {{ localizedProduct.name }}
                    </h1>
                </div>
                <div>
                    <a href="/visa-indonesia"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{
                            t(
                                "services.visaIndonesiaDetail.back",
                            )
                        }}
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT -->
        <section class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- ===== FULL WIDTH: Penjelasan Umum ===== -->
                <div v-if="localizedProduct.penjelasan_umum?.length"
                    class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8 mb-5">
                    <div class="flex items-center gap-3 mb-5">
                        <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                        <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Penjelasan Umum</h2>
                    </div>
                    <div class="space-y-4">
                        <p v-for="(p, i) in localizedProduct.penjelasan_umum" :key="`pu-${i}`"
                            class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">{{ p }}</p>
                    </div>
                </div>

                <!-- ===== FULL WIDTH: Pilih Index Visa Kunjungan ===== -->
                <div class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8 mb-5">
                    <div class="flex items-center gap-3 mb-5">
                        <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                        <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Pilih Index Visa
                            Kunjungan</h2>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                        <button v-for="(item, i) in localizedProduct.index_list" :key="`idx-${i}`" @click="activeIndex = i"
                            class="text-left rounded-2xl p-5 transition-all flex flex-col"
                            :class="activeIndex === i
                                ? 'bg-primary text-white shadow-lg'
                                : 'border border-[#E8E8E6] bg-white text-[#1A1B18] hover:border-primary/40 hover:shadow-sm'">

                            <!-- Icon box -->
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl mb-4"
                                :class="activeIndex === i ? 'bg-white' : 'bg-[#F7F7F5]'">
                                <img src="/icons/ft-persons.svg" class="w-6 h-6"
                                    :class="activeIndex === i ? '' : 'opacity-70'"
                                    :style="activeIndex === i ? 'filter: invert(20%) sepia(60%) saturate(2000%) hue-rotate(340deg);' : ''"
                                    alt="" />
                            </div>

                            <!-- Title -->
                            <p class="text-[14px] font-bold leading-snug mb-2">
                                {{ item.kode }} {{ item.nama }}
                            </p>

                            <!-- Excerpt -->
                            <p class="text-[12px] leading-[1.6] mb-4 flex-1"
                                :class="activeIndex === i ? 'text-white/85' : 'text-[#686964]'">
                                {{ item.excerpt }}
                            </p>

                            <!-- Divider -->
                            <hr class="mb-3" :class="activeIndex === i ? 'border-white/25' : 'border-[#E8E8E6]'" />

                            <!-- Price -->
                            <p class="text-[11px] mb-0.5"
                                :class="activeIndex === i ? 'text-white/70' : 'text-[#686964]'">
                                Mulai dari
                            </p>
                            <p class="text-[18px] font-bold leading-tight"
                                :class="activeIndex === i ? 'text-white' : 'text-primary'">
                                {{ item.harga }}
                            </p>
                        </button>
                    </div>
                </div>

                <!-- ===== GRID 2 KOLOM: mulai dari Penjelasan Layanan ===== -->
                <div class="grid gap-8 lg:grid-cols-[1fr_300px] xl:grid-cols-[1fr_320px]">

                    <!-- ===== KIRI ===== -->
                    <div class="flex flex-col gap-5">

                        <!-- 3. Penjelasan Layanan -->
                        <div v-if="currentItem?.penjelasan_layanan?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Penjelasan
                                    Layanan</h2>
                            </div>
                            <div class="space-y-4">
                                <p v-for="(p, i) in currentItem.penjelasan_layanan" :key="`pl-${i}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">{{ p }}</p>
                            </div>
                        </div>

                        <!-- 4. Dokumen Yang Anda Dapatkan -->
                        <div v-if="currentItem?.dokumen_diperlukan?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Jenis Dokumen
                                    yang Akan Anda Dapatkan</h2>
                            </div>
                            <div class="space-y-5">
                                <div v-for="(grp, gi) in currentItem.dokumen_diperlukan" :key="`dg-${gi}`">
                                    <p class="text-[12px] font-bold text-[#1A1B18] mb-2">{{ grp.label }}</p>
                                    <ul class="space-y-1.5">
                                        <li v-for="(item, ii) in grp.items" :key="`dgi-${gi}-${ii}`"
                                            class="flex items-start gap-2 text-[13px] leading-[1.6] text-[#3D3D3A]">
                                            <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                            <span>{{ item }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Persyaratan Dokumen -->
                        <div v-if="currentItem?.persyaratan_dokumen?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Persyaratan
                                    Dokumen</h2>
                            </div>
                            <div class="space-y-6">
                                <div v-for="(group, gi) in currentItem.persyaratan_dokumen" :key="`pg-${gi}`">
                                    <p class="text-[13px] font-bold text-[#1A1B18] mb-3">{{ group.label }}</p>
                                    <ol class="space-y-2 pl-1">
                                        <li v-for="(item, ii) in group.items" :key="`pi-${gi}-${ii}`"
                                            class="flex gap-2 text-[13px] leading-[1.6] text-[#3D3D3A]">
                                            <span class="flex-shrink-0 font-medium">{{ ii + 1 }}.</span>
                                            <span>{{ item }}</span>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Rincian Biaya -->
                        <div v-if="currentItem?.rincian_biaya"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center gap-3">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Rincian Biaya
                                    </h2>
                                </div>
                                <!-- Tab tahun (opsional) -->
                                <div v-if="currentItem.rincian_biaya.tabs?.length"
                                    class="inline-flex rounded-lg border border-[#E8E8E6] overflow-hidden">
                                    <button v-for="(tab, ti) in currentItem.rincian_biaya.tabs" :key="`tahun-${ti}`"
                                        @click="activeBiayaTahun = ti"
                                        class="px-4 py-1.5 text-[12px] font-bold transition-colors" :class="activeBiayaTahun === ti
                                            ? 'bg-primary text-white'
                                            : 'bg-white text-[#686964] hover:bg-[#F7F7F5]'">
                                        {{ tab.label }}
                                    </button>
                                </div>
                            </div>

                            <!-- Data biaya: dari tab aktif atau langsung -->
                            <div class="flex flex-col sm:flex-row gap-4 items-stretch">
                                <div class="flex-1">
                                    <p v-if="(currentItem.rincian_biaya.tabs?.[activeBiayaTahun]?.label_biaya) ?? currentItem.rincian_biaya.label"
                                        class="text-[13px] font-bold text-[#1A1B18] mb-3 uppercase tracking-wide">
                                        {{ currentItem.rincian_biaya.tabs?.[activeBiayaTahun]?.label_biaya ??
                                            currentItem.rincian_biaya.label }}
                                    </p>
                                    <div v-for="(item, ri) in (currentItem.rincian_biaya.tabs?.[activeBiayaTahun]?.items ?? currentItem.rincian_biaya.items)"
                                        :key="`rb-${ri}`" class="flex items-center justify-between gap-4 py-2.5">
                                        <span class="text-[13px] leading-[1.5] text-[#3D3D3A]">{{ item.label }}</span>
                                        <span class="text-[14px] font-bold text-black whitespace-nowrap">{{ item.amount
                                        }}</span>
                                    </div>
                                    <hr class="border-t border-dashed border-[#D9DAD8] my-1" />
                                    <p v-if="currentItem.rincian_biaya.note" class="text-[11px] text-[#9A9A97] mt-3">
                                        {{ currentItem.rincian_biaya.note }}
                                    </p>
                                </div>

                                <div class="sm:w-[420px] flex-shrink-0 rounded-xl overflow-hidden"
                                    style="background-image: url('/images/card-arrow-item-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                                    <div class="flex items-center justify-between h-full px-5 py-4 gap-4">
                                        <div>
                                            <div class="text-[13px] text-white/80 mb-0.5">
                                                {{ currentItem.rincian_biaya.tabs?.[activeBiayaTahun]?.penanganan_label
                                                    ?? "Biaya Penanganan" }}
                                            </div>
                                            <div
                                                class="text-[22px] font-bold text-white leading-tight whitespace-nowrap">
                                                {{ currentItem.rincian_biaya.tabs?.[activeBiayaTahun]?.biaya_penanganan
                                                    ?? currentItem.rincian_biaya.biaya_penanganan }}
                                            </div>
                                        </div>
                                        <a :href="buildWhatsappLink(`${currentItem.kode} ${currentItem.nama}`)"
                                            target="_blank" rel="noopener noreferrer"
                                            class="flex items-center justify-center gap-1.5 rounded-lg bg-white px-4 py-2.5 text-[13px] font-semibold text-primary hover:bg-white/90 transition-colors whitespace-nowrap flex-shrink-0">
                                            Pesan Sekarang
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Dasar Hukum (accordion) -->
                        <div v-if="currentItem?.dasar_hukum?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <button @click="toggleSection('dasar-hukum')"
                                class="w-full flex items-center justify-between gap-3 text-left">
                                <div class="flex items-center gap-3">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Dasar Hukum
                                    </h2>
                                </div>
                                <svg class="h-5 w-5 flex-shrink-0 text-[#686964] transition-transform duration-200"
                                    :class="openSectionId === 'dasar-hukum' ? 'rotate-180' : ''" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <ul v-if="openSectionId === 'dasar-hukum'" class="mt-5 space-y-4">
                                <li v-for="(hukum, i) in currentItem.dasar_hukum" :key="`hukum-${i}`"
                                    class="flex items-start gap-4">
                                    <span
                                        class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-[#ddffe3]">
                                        <svg class="w-4 h-4 text-[#22A94D]" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
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

                        <!-- Price Card (reaktif ke index aktif) -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <div class="mb-3 inline-flex items-center gap-1.5 rounded-full bg-[#FFF0EF] px-3 py-1">
                                <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                <span class="text-[11px] font-semibold text-primary">Free Konsultasi</span>
                            </div>
                            <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mt-2 mb-3">
                                {{ currentItem?.kode }} {{ currentItem?.nama }}
                            </p>
                            <div class="text-[12px] text-[#686964] mb-1">
                                {{ currentItem?.rincian_biaya?.tabs?.[activeBiayaTahun]?.penanganan_label ?? "Biaya Penanganan" }}
                            </div>
                            <div class="text-[26px] font-bold leading-none text-primary mb-4">
                                {{ currentItem?.rincian_biaya?.tabs?.[activeBiayaTahun]?.biaya_penanganan ??
                                    currentItem?.rincian_biaya?.biaya_penanganan }}
                            </div>
                            <a :href="buildWhatsappLink(`${currentItem?.kode} ${currentItem?.nama}`)" target="_blank"
                                rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary py-2.5 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors mb-2">
                                Pesan Sekarang
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                            <a :href="buildWhatsappLink(`${currentItem?.kode} ${currentItem?.nama}`)" target="_blank"
                                rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg border border-[#E8E8E6] py-2.5 text-[13px] font-semibold text-[#3D3D3A] hover:bg-[#F7F7F5] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                Konsultasi Gratis via Whatsapp
                            </a>
                        </div>

                        <!-- VIP Line Banner -->
                        <div class="rounded-2xl px-5 py-6 text-center overflow-hidden relative"
                            style="background-image: url('/images/card-arrow-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <div class="relative mb-4">
                                <div class="inline-block w-full rounded-xl border border-white/60 px-4 py-2.5">
                                    <span
                                        class="text-[14px] font-extrabold uppercase tracking-widest text-white">FASTRACK
                                        – VIP LINE</span>
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
                            <div class="relative mt-3 text-[11px] text-white/60">* (S&amp;K BERLAKU)</div>
                        </div>

                        <!-- Index Visa Lainnya -->
                        <div v-if="localizedRelatedProducts.length" class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">Index Visa Lainnya</h3>
                            <div class="flex flex-col gap-3">
                                <a v-for="(related, index) in localizedRelatedProducts.slice(0, 3)" :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex items-center gap-3 rounded-xl border border-[#E8E8E6] bg-white p-3 hover:border-primary/30 hover:shadow-sm transition-all">
                                    <div
                                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-[#FFF0EF]">
                                        <img src="/icons/ft-persons.svg" class="w-5 h-5" alt="" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="text-[13px] font-semibold text-[#1A1B18] group-hover:text-primary transition-colors leading-snug line-clamp-2">
                                            {{ related.name }}
                                        </p>
                                        <p class="text-[11px] text-[#686964] mt-0.5">Mulai dari {{ related.price_label
                                            }}</p>
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
                <!-- ===== END GRID 2 KOLOM ===== -->

            </div>
        </section>

        <FooterCTA
            :title="t('services.visaIndonesiaDetail.footer.title')"
            :description="t('services.visaIndonesiaDetail.footer.desc')"
            :button-text="t('services.visaIndonesiaDetail.footer.cta')"
            :whatsapp-link="buildWhatsappLink('layanan yang tidak terdaftar')"
        />
    </MainLayout>
</template>