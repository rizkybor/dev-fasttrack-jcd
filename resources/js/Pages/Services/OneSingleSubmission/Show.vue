<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { ref, computed } from "vue";
import { useI18n } from "vue-i18n";

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

const whatsappNumber = "6282298604144";

const buildWhatsappLink = (productName, paketNama) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${productName} - ${paketNama}.`;
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

const localizePaket = (p) => {
    if (!p) return p;

    const result = {
        ...p,
        nama: pick(p.nama),
        deskripsi: pick(p.deskripsi),
        penjelasan_layanan: pick(p.penjelasan_layanan) ?? [],
        dasar_hukum: pick(p.dasar_hukum) ?? [],
    };

    if (p.penjelasan_layanan_items) {
        result.penjelasan_layanan_items = pick(p.penjelasan_layanan_items) ?? [];
    }

    if (p.dokumen_legalitas) {
        result.dokumen_legalitas = {
            ...p.dokumen_legalitas,
            dokumen: pick(p.dokumen_legalitas.dokumen) ?? [],
            termasuk: pick(p.dokumen_legalitas.termasuk) ?? [],
        };
        if (p.dokumen_legalitas.dokumen_sub) {
            result.dokumen_legalitas.dokumen_sub = pick(p.dokumen_legalitas.dokumen_sub) ?? [];
        }
    }

    if (p.biaya_layanan) {
        result.biaya_layanan = {
            ...p.biaya_layanan,
            nama: pick(p.biaya_layanan.nama),
        };
    }

    if (p.paket_layanan) {
        result.paket_layanan = p.paket_layanan.map((item) => ({
            ...item,
            nama: pick(item.nama),
            dokumen_legalitas: item.dokumen_legalitas
                ? {
                      ...item.dokumen_legalitas,
                      dokumen: pick(item.dokumen_legalitas.dokumen) ?? [],
                      termasuk: pick(item.dokumen_legalitas.termasuk) ?? [],
                      ...(item.dokumen_legalitas.dokumen_sub
                          ? { dokumen_sub: pick(item.dokumen_legalitas.dokumen_sub) ?? [] }
                          : {}),
                  }
                : item.dokumen_legalitas,
        }));
    }

    return result;
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
        penjelasan_umum: pick(p.penjelasan_umum) ?? [],
        penjelasan_umum_bullets: pick(p.penjelasan_umum_bullets) ?? [],
        penjelasan_umum_bullets_2: pick(p.penjelasan_umum_bullets_2) ?? [],
        dasar_hukum: pick(p.dasar_hukum) ?? [],
        faq: pick(p.faq) ?? [],
        paket: (p.paket ?? []).map(localizePaket),
    };
});

// Paket aktif — default ke paket pertama (id paket adalah string struktural, tidak diterjemahkan)
const selectedPaketId = ref(props.product?.paket?.[0]?.id ?? null);

const selectedPaket = computed(
    () =>
        localizedProduct.value?.paket?.find((p) => p.id === selectedPaketId.value) ??
        localizedProduct.value?.paket?.[0] ??
        null,
);

const hasPaket = computed(() => !!localizedProduct.value?.paket?.length);

// id 1 = Pendaftaran NIB, id 2 = Perubahan/Pemutakhiran NIB — dibandingkan lewat id numerik
// (bukan nama produk) agar tidak bergantung pada locale aktif.
const isPendaftaranNib = computed(() => props.product?.id === 1);

const pilihPaketHeading = computed(() => {
    const data = {
        id: isPendaftaranNib.value
            ? "Pilih Paket Pendaftaran NIB"
            : "Pilih Paket Perubahan/Pemutakhiran NIB",
        en: isPendaftaranNib.value
            ? "Choose an NIB Registration Package"
            : "Choose an NIB Amendment/Update Package",
        zh: isPendaftaranNib.value
            ? "选择NIB注册套餐"
            : "选择NIB变更/更新套餐",
    };
    return data[locale.value] ?? data.id;
});

const dokumenSectionLabel = computed(() => {
    const data = {
        id: isPendaftaranNib.value
            ? "Dokumen"
            : "Pelaku Usaha dapat melakukan perubahan Data Usaha diantaranya adalah :",
        en: isPendaftaranNib.value
            ? "Documents"
            : "Business Actors can make the following Business Data changes:",
        zh: isPendaftaranNib.value
            ? "文件"
            : "经营者可进行以下业务数据变更：",
    };
    return data[locale.value] ?? data.id;
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
                                "services.oneSingleSubmissionDetail.breadcrumb.layanan",
                            )
                        }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/one-single-submission" class="text-sm font-medium text-[#9e1f16] hover:underline">{{
                            t(
                                "services.oneSingleSubmissionDetail.breadcrumb.current",
                            )
                        }}</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#9e1f16]">{{
                            localizedProduct.name
                            }}</span>
                    </div>
                </nav>

                <!-- Heading -->
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

                <!-- Back -->
                <div>
                    <a href="/one-single-submission"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ t("services.oneSingleSubmissionDetail.back") }}
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section id="edukasi" class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- 1. Penjelasan Umum -->
                <div v-if="localizedProduct.penjelasan_umum?.length"
                    class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8 mb-5">
                    <div class="flex items-center gap-3 mb-5">
                        <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                        <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                            {{
                                t(
                                    "services.oneSingleSubmissionDetail.sections.penjelasan",
                                )
                            }}
                        </h2>
                    </div>
                    <div class="space-y-4 text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">
                        <p>{{ localizedProduct.penjelasan_umum[0] }}</p>

                        <template v-if="localizedProduct.penjelasan_umum[1]">
                            <p>{{ localizedProduct.penjelasan_umum[1] }}</p>
                            <ul v-if="localizedProduct.penjelasan_umum_bullets?.length"
                                class="list-disc list-inside space-y-1 pl-1">
                                <li v-for="(
b, i
                                    ) in localizedProduct.penjelasan_umum_bullets" :key="`b1-${i}`">
                                    {{ b }}
                                </li>
                            </ul>
                        </template>

                        <template v-if="localizedProduct.penjelasan_umum[2]">
                            <p>{{ localizedProduct.penjelasan_umum[2] }}</p>
                            <ul v-if="localizedProduct.penjelasan_umum_bullets_2?.length"
                                class="list-disc list-inside space-y-1 pl-1">
                                <li v-for="(
b, i
                                    ) in localizedProduct.penjelasan_umum_bullets_2" :key="`b2-${i}`">
                                    {{ b }}
                                </li>
                            </ul>
                        </template>

                        <p v-if="localizedProduct.penjelasan_umum[3]">
                            {{ localizedProduct.penjelasan_umum[3] }}
                        </p>
                    </div>
                </div>

                <!-- 2. Pilih Paket -->
                <div v-if="hasPaket" class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8 mb-5">
                    <div class="flex items-center gap-3 mb-5">
                        <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                        <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                            {{ pilihPaketHeading }}
                        </h2>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <button v-for="paket in localizedProduct.paket" :key="paket.id" @click="selectedPaketId = paket.id"
                            class="flex flex-col items-start rounded-xl border p-4 text-left transition-all" :class="selectedPaketId === paket.id
                                    ? 'border-primary bg-primary text-white shadow-md'
                                    : 'border-[#E8E8E6] bg-white hover:border-primary/40 hover:shadow-sm'
                                ">
                            <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg" :class="selectedPaketId === paket.id
                                    ? 'bg-white/20'
                                    : 'bg-[#FFF0EF]'
                                ">
                                <img src="/icons/ft-persons.svg" class="w-5 h-5" alt="" />
                            </div>
                            <p class="text-[13px] font-bold leading-snug mb-3" :class="selectedPaketId === paket.id
                                    ? 'text-white'
                                    : 'text-[#1A1B18]'
                                ">
                                {{ paket.nama }}
                            </p>
                            <p class="text-[11px] leading-[1.5] mb-4" :class="selectedPaketId === paket.id
                                    ? 'text-white/80'
                                    : 'text-[#686964]'
                                ">
                                {{ paket.deskripsi }}
                            </p>
                            <p class="text-[10px]" :class="selectedPaketId === paket.id
                                    ? 'text-white/70'
                                    : 'text-[#686964]'
                                ">
                                {{
                                    t(
                                        "services.oneSingleSubmissionDetail.plans.mulai_dari",
                                    )
                                }}
                            </p>
                            <p class="text-[16px] font-bold leading-tight" :class="selectedPaketId === paket.id
                                    ? 'text-white'
                                    : 'text-primary'
                                ">
                                {{ paket.harga }}
                            </p>
                        </button>
                    </div>
                </div>

                <div class="grid gap-8 lg:grid-cols-[1fr_280px] xl:grid-cols-[1fr_300px] min-w-0">
                    <!-- ===== KIRI ===== -->
                    <div class="flex flex-col gap-6 min-w-0">
                        <!-- Konten dinamis per paket -->
                        <template v-if="selectedPaket">
                            <!-- 3. Penjelasan Layanan -->
<div
    v-if="selectedPaket?.penjelasan_layanan?.length"
    class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
>
    <div class="flex items-center gap-3 mb-5">
        <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
        <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
            Penjelasan Layanan
        </h2>
    </div>

    <!-- Default: paragraf biasa -->
    <template v-if="selectedPaket.id !== '4'">
        <div class="space-y-4">
            <p
                v-for="(p, i) in selectedPaket.penjelasan_layanan"
                :key="`pl-${i}`"
                class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify"
            >
                {{ p }}
            </p>
        </div>
    </template>

    <!-- Paket id '4': intro + numbered list -->
    <template v-else>
        <p
            v-for="(p, i) in selectedPaket.penjelasan_layanan"
            :key="`pl-intro-${i}`"
            class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify mb-6"
        >
            {{ p }}
        </p>

        <ol
            v-if="selectedPaket.penjelasan_layanan_items?.length"
            class="space-y-4"
        >
            <li
                v-for="(item, i) in selectedPaket.penjelasan_layanan_items"
                :key="`pl-item-${i}`"
                class="flex gap-4"
            >
                <span
                    class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary text-white text-[12px] font-bold"
                >
                    {{ i + 1 }}
                </span>
                <div class="pt-0.5">
                    <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-1">
                        {{ item.title }}
                    </p>
                    <p class="text-[13px] leading-[1.6] text-[#3D3D3A]">
                        {{ item.desc }}
                    </p>
                </div>
            </li>
        </ol>
    </template>
</div>

                            <!-- 4. Dokumen Legalitas yang Anda Dapatkan -->
                            <div v-if="selectedPaket.dokumen_legalitas"
                                class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                <div class="flex items-center gap-3 mb-5">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                        Dokumen Legalitas yang Anda Dapatkan
                                    </h2>
                                </div>

                                <!-- Dokumen -->
                                <div v-if="
                                    selectedPaket.dokumen_legalitas.dokumen
                                        ?.length
                                " class="mb-5">
                                    <p class="text-[13px] font-bold text-[#1A1B18] mb-3">
                                        {{ dokumenSectionLabel }}
                                    </p>
                                    <ul class="space-y-2.5">
                                        <li v-for="(item, i) in selectedPaket
                                            .dokumen_legalitas.dokumen" :key="`dok-${i}`"
                                            class="flex items-start gap-2.5">
                                            <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0"
                                                alt="done" />
                                            <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{ item }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Termasuk -->
                                <div v-if="
                                    selectedPaket.dokumen_legalitas.termasuk
                                        ?.length
                                ">
                                    <p class="text-[13px] font-bold text-[#1A1B18] mb-3">
                                        {{
                                            t(
                                                "services.oneSingleSubmissionDetail.plans.termasuk",
                                            )
                                        }}
                                    </p>
                                    <ul class="space-y-2.5">
                                        <li v-for="(item, i) in selectedPaket
                                            .dokumen_legalitas.termasuk" :key="`tmsk-${i}`"
                                            class="flex items-start gap-2.5">
                                            <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0"
                                                alt="done" />
                                            <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{ item }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- 5. Biaya Layanan / Paket Layanan -->
                            <div v-if="selectedPaket">

                                <!-- Jika id == '2': tampilkan grid Paket Layanan -->
                                <div v-if="selectedPaket.id === '2'"
                                    class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                    <div class="flex items-center gap-3 mb-5">
                                        <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                        <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                            Paket Layanan
                                        </h2>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div v-for="(item, idx) in selectedPaket.paket_layanan"
                                            :key="`paket-card-${idx}`"
                                            class="flex flex-col rounded-2xl border border-[#E8E8E6] p-5">
                                            <p
                                                class="text-[14px] font-semibold text-[#1A1B18] leading-snug mb-3 whitespace-pre-line">
                                                {{ item.nama }}
                                            </p>
                                            <p class="text-[11px] text-[#686964]">{{
                                                t(
                                                    "services.oneSingleSubmissionDetail.plans.mulai_dari",
                                                )
                                            }}</p>
                                            <p class="text-[24px] font-bold text-primary leading-tight mb-5">
                                                {{ item.harga }}
                                            </p>

                                            <hr class="border-[#E8E8E6] mb-5" />

                                            <!-- Dokumen -->
                                            <div v-if="item.dokumen_legalitas?.dokumen?.length" class="mb-4">
                                                <p class="text-[13px] font-bold text-[#1A1B18] mb-3">Dokumen</p>
                                                <ul class="space-y-2">
                                                    <li v-for="(dok, di) in item.dokumen_legalitas.dokumen"
                                                        :key="`dok-${idx}-${di}`" class="flex items-start gap-2">
                                                        <img src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                                        <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{ dok
                                                            }}</span>
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- Dokumen Sub (nested bullet) -->
                                            <div v-if="item.dokumen_legalitas?.dokumen_sub?.length"
                                                class="mb-4 space-y-3">
                                                <div v-for="(sub, si) in item.dokumen_legalitas.dokumen_sub"
                                                    :key="`sub-${idx}-${si}`">
                                                    <div class="flex items-start gap-2 mb-1.5">
                                                        <img src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                                        <span
                                                            class="text-[13px] font-semibold leading-[1.6] text-[#3D3D3A]">{{
                                                            sub.label }}</span>
                                                    </div>
                                                    <ul v-if="sub.items?.length" class="ml-6 space-y-1">
                                                        <li v-for="(point, pi) in sub.items"
                                                            :key="`point-${idx}-${si}-${pi}`"
                                                            class="flex items-start gap-1.5 text-[12px] leading-[1.6] text-[#3D3D3A]">
                                                            <span
                                                                class="flex-shrink-0 mt-[7px] h-1 w-1 rounded-full bg-[#3D3D3A] inline-block"></span>
                                                            <span>{{ point }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- Termasuk -->
                                            <div v-if="item.dokumen_legalitas?.termasuk?.length" class="mb-5">
                                                <p class="text-[13px] font-bold text-[#1A1B18] mb-3">{{
                                                    t(
                                                        "services.oneSingleSubmissionDetail.plans.termasuk",
                                                    )
                                                }}</p>
                                                <ul class="space-y-2">
                                                    <li v-for="(tmsk, ti) in item.dokumen_legalitas.termasuk"
                                                        :key="`tmsk-${idx}-${ti}`" class="flex items-start gap-2">
                                                        <img src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                                        <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{ tmsk
                                                            }}</span>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="flex-1"></div>

                                            <a :href="buildWhatsappLink(localizedProduct.name, item.nama)" target="_blank"
                                                rel="noopener noreferrer"
                                                class="mt-4 flex items-center justify-center gap-2 rounded-xl border border-primary px-4 py-3 text-[13px] font-semibold text-primary hover:bg-primary/5 transition-colors">
                                                {{
                                                    t(
                                                        "services.oneSingleSubmissionDetail.plans.pesan",
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

                                <!-- Jika id selain '2': tampilkan Biaya Layanan seperti sebelumnya -->
                                <div v-else-if="selectedPaket.biaya_layanan"
                                    class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                    <div class="flex items-center gap-3 mb-5">
                                        <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                        <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                            Biaya Layanan
                                        </h2>
                                    </div>

                                    <div class="flex flex-col sm:flex-row sm:flex-nowrap items-stretch sm:items-center justify-between gap-3 sm:gap-4 rounded-xl px-4 py-4 sm:px-5 sm:py-5"
                                        style="background-image: url('/images/card-arrow-item-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                                        <div class="flex items-center gap-4 min-w-0">
                                            <div
                                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-white/20">
                                                <img src="/icons/ft-persons.svg" class="w-5 h-5" alt="" />
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-[12px] text-white/80 truncate">{{ selectedPaket.biaya_layanan.nama
                                                    }}</p>
                                                <p class="text-[20px] font-bold text-white leading-tight">
                                                    {{ selectedPaket.biaya_layanan.harga }}
                                                </p>
                                            </div>
                                        </div>
                                        <a :href="buildWhatsappLink(localizedProduct.name, selectedPaket.nama)" target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex-shrink-0 flex items-center justify-center gap-1.5 rounded-lg bg-white px-4 py-2 text-[12px] font-semibold text-primary whitespace-nowrap hover:bg-white/90 transition-colors">
                                            {{
                                                t(
                                                    "services.oneSingleSubmissionDetail.plans.pesan",
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

                            <!-- 6. Dasar Hukum -->
                            <div v-if="selectedPaket.dasar_hukum?.length"
                                class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                <div class="flex items-center gap-3 mb-5">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                        {{
                                            t(
                                                "services.oneSingleSubmissionDetail.sections.dasar_hukum",
                                            )
                                        }}
                                    </h2>
                                </div>
                                <ul class="space-y-4">
                                    <li v-for="(
hukum, i
                                        ) in selectedPaket.dasar_hukum" :key="`hukum-${i}`"
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
                        </template>
                    </div>

                    <!-- ===== KANAN: Sidebar ===== -->
                    <div class="flex flex-col gap-4 min-w-0 lg:sticky lg:top-32 lg:self-start">
                        <!-- Price Card (reaktif ke paket aktif) -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <div class="mb-3 inline-flex items-center gap-1.5 rounded-full bg-[#FFF0EF] px-3 py-1">
                                <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                <span class="text-[11px] font-semibold text-primary">
                                    {{ selectedPaket?.nama ?? localizedProduct.name }}
                                </span>
                            </div>
                            <div class="text-[12px] text-[#686964] mb-1 mt-2">
                                {{
                                    t(
                                        "services.oneSingleSubmissionDetail.sidebar.price_label",
                                    )
                                }}
                            </div>
                            <div class="text-[32px] font-bold leading-none text-primary mb-1">
                                {{
                                    selectedPaket?.harga ?? localizedProduct.price_label
                                }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">
                                {{
                                    t(
                                        "services.oneSingleSubmissionDetail.sidebar.price_note",
                                    )
                                }}
                            </div>
                            <a :href="buildWhatsappLink(
                                localizedProduct.name,
                                selectedPaket?.nama ?? '',
                            )
                                " target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary py-2.5 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors mb-2">
                                Pesan Sekarang
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                            <a :href="buildWhatsappLink(
                                localizedProduct.name,
                                selectedPaket?.nama ?? '',
                            )
                                " target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg border border-[#E8E8E6] py-2.5 text-[13px] font-semibold text-[#3D3D3A] hover:bg-[#F7F7F5] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{
                                    t(
                                        "services.oneSingleSubmissionDetail.sidebar.konsultasi_cta",
                                    )
                                }}
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

                        <!-- VIP Line Banner -->
                        <div class="rounded-2xl px-5 py-6 text-center overflow-hidden relative" style="
                                background-image: url(&quot;/images/card-arrow-bg.png&quot;);
                                background-size: cover;
                                background-position: center;
                                background-repeat: no-repeat;
                            ">
                            <div class="relative mb-4">
                                <div class="inline-block w-full rounded-xl border border-white/60 px-4 py-2.5">
                                    <span class="text-[14px] font-extrabold uppercase tracking-widest text-white">
                                        {{
                                            t(
                                                "services.oneSingleSubmissionDetail.sidebar.vip_title",
                                            )
                                        }}
                                    </span>
                                </div>
                            </div>
                            <p class="relative text-[14px] leading-[1.6] text-white/90 mb-5">
                                {{
                                    t(
                                        "services.oneSingleSubmissionDetail.sidebar.vip_desc",
                                    )
                                }}
                            </p>
                            <a :href="buildWhatsappLink(
                                localizedProduct.name,
                                selectedPaket?.nama ?? '',
                            )
                                " target="_blank" rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                {{
                                    t(
                                        "services.oneSingleSubmissionDetail.sidebar.vip_cta",
                                    )
                                }}
                            </a>
                            <div class="relative mt-3 text-[11px] text-white/60">
                                {{
                                    t(
                                        "services.oneSingleSubmissionDetail.sidebar.vip_note",
                                    )
                                }}
                            </div>
                        </div>

                        <!-- Paket NIB Lainnya -->
                        <div v-if="localizedProduct.paket?.length > 1" class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">
                                Paket {{ localizedProduct.name }} Lainnya
                            </h3>
                            <div class="flex flex-col gap-2">
                                <button v-for="paket in localizedProduct.paket.filter(
                                    (p) => p.id !== selectedPaketId,
                                )" :key="`other-${paket.id}`" @click="selectedPaketId = paket.id"
                                    class="group flex items-center justify-between rounded-xl border border-[#E8E8E6] bg-white px-4 py-3 text-left hover:border-primary/30 hover:shadow-sm transition-all">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-[#FFF0EF]">
                                            <img src="/icons/ft-persons.svg" class="w-4 h-4" alt="" />
                                        </div>
                                        <div>
                                            <p
                                                class="text-[13px] font-semibold text-[#1A1B18] group-hover:text-primary transition-colors">
                                                {{ paket.nama }}
                                            </p>
                                            <p class="text-[12px] font-bold text-primary">
                                                {{ paket.harga }}
                                            </p>
                                        </div>
                                    </div>
                                    <svg class="h-4 w-4 text-[#686964] group-hover:text-primary transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Layanan Terkait -->
                        <div v-if="relatedProducts.length" class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">
                                {{
                                    t(
                                        "services.oneSingleSubmissionDetail.sidebar.related_title",
                                    )
                                }}
                            </h3>
                            <div class="flex flex-col gap-3">
                                <a v-for="(
related, index
                                    ) in relatedProducts.slice(0, 3)" :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex flex-col gap-2 rounded-xl border border-[#E8E8E6] bg-white p-4 hover:border-primary/30 hover:shadow-sm transition-all">
                                    <div
                                        class="text-[14px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors">
                                        {{ pick(related.name) }}
                                    </div>
                                    <p class="text-[12px] leading-[1.6] text-[#686964] line-clamp-3">
                                        {{
                                            pick(related.excerpt) ?? pick(related.description)
                                        }}
                                    </p>
                                    <hr class="border-[#E8E8E6]" />
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-[11px] text-[#686964] mb-0.5">
                                                {{
                                                    t(
                                                        "services.oneSingleSubmissionDetail.sidebar.related_from",
                                                    )
                                                }}
                                            </div>
                                            <div class="text-[18px] font-bold text-primary leading-none">
                                                {{ related.price_label }}
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-1 flex items-center justify-center gap-2 rounded-xl border border-primary py-2.5 text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors">
                                        {{
                                            t(
                                                "services.oneSingleSubmissionDetail.sidebar.related_cta",
                                            )
                                        }}
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
            :title="t('services.oneSingleSubmissionDetail.footer.title')"
            :description="t('services.oneSingleSubmissionDetail.footer.desc')"
            :button-text="t('services.oneSingleSubmissionDetail.footer.cta')"
            :whatsapp-link="buildWhatsappLink('layanan yang tidak terdaftar', '')"
        />
    </MainLayout>
</template>
