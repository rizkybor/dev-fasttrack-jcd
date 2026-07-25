<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { ref, computed } from "vue";
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

const { buildWhatsappLink: waLink } = useWhatsapp("virtual_office");
const buildWhatsappLink = (productName, packageName) => {
    return waLink(packageName ? `${productName} - ${packageName}` : productName);
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
        detail: pick(p.detail),
        faq: pick(p.faq) ?? [],
    };
});

const product = localizedProduct;

const detail = computed(() => product.value?.detail ?? {});
const paketReguler = computed(() => detail.value.paket_reguler ?? {});

// ===== Pilihan paket pada sidebar & tabel perbandingan =====
const selectedPackageIndex = ref(0);

const selectedPackageName = computed(
    () => paketReguler.value.columns?.[selectedPackageIndex.value] ?? "",
);
const selectedPackagePrice = computed(
    () =>
        paketReguler.value.harga?.[selectedPackageIndex.value] ??
        product.value.price_label,
);
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
                            t("services.virtualOfficeDetail.breadcrumb.layanan")
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
                        class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white shadow-md">
                        <img src="/icons/ft-persons.svg" class="w-9 h-9" alt="" />
                    </div>
                    <h1
                        class="text-3xl font-extrabold leading-tight text-white sm:text-4xl lg:text-5xl max-w-[800px] line-clamp-2">
                        {{ localizedProduct.name }}
                    </h1>
                </div>
                <div>
                    <a href="/layanan"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ t("services.virtualOfficeDetail.back") }}
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section id="edukasi" class="bg-[#F7F7F5] py-8 sm:py-12 lg:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="grid w-full min-w-0 gap-4 sm:gap-6 lg:grid-cols-[1fr_280px] lg:gap-8 xl:grid-cols-[1fr_300px]"
                >
                    <!-- ===== KIRI: Konten Utama ===== -->
                    <div class="flex min-w-0 flex-col gap-4 sm:gap-6">
                        <!-- 1. Intro -->
                        <div
                            class="rounded-xl border border-[#E8E8E6] bg-white p-4 sm:rounded-2xl sm:p-6 md:p-8"
                        >
                            <div class="flex items-center gap-2.5 sm:gap-3 mb-4 sm:mb-5">
                                <img
                                    src="/icons/ic-menu-arrow.svg"
                                    class="h-5 w-5 flex-shrink-0 sm:h-6 sm:w-6"
                                    alt=""
                                />
                                <h2
                                    class="text-xs font-bold uppercase leading-snug tracking-wide text-black sm:text-[15px] sm:tracking-widest"
                                >
                                    {{ detail.intro?.heading }}
                                </h2>
                            </div>
                            <div class="space-y-3 sm:space-y-4">
                                <p
                                    v-for="(paragraph, index) in detail.intro
                                        ?.paragraphs"
                                    :key="`intro-${index}`"
                                    class="text-[13px] leading-[1.7] text-[#3D3D3A] text-justify sm:text-[14px] sm:leading-[1.8]"
                                >
                                    {{ paragraph }}
                                </p>
                            </div>
                        </div>

                        <!-- 2. Promo Banner -->
                        <div
                            v-if="detail.promo"
                            class="relative overflow-hidden rounded-xl bg-[#9e1f16] px-4 py-5 flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-between sm:rounded-2xl sm:px-8 sm:py-6"
                        >
                            <div>
                                <p class="text-[11px] text-white/70 sm:text-[12px]">
                                    {{ detail.promo.label }}
                                </p>
                                <p
                                    class="text-[17px] font-extrabold text-white sm:text-[20px] lg:text-[24px]"
                                >
                                    {{ detail.promo.highlight }}
                                </p>
                            </div>
                            <div
                                class="inline-flex items-center rounded-lg bg-white px-3.5 py-2 text-[12px] font-bold text-[#9e1f16] sm:whitespace-nowrap sm:px-4 sm:py-2.5 sm:text-[14px]"
                            >
                                {{ detail.promo.badge }}
                            </div>
                        </div>

                        <!-- 3. Keunggulan -->
                        <div
                            v-if="detail.keunggulan?.length"
                            class="rounded-xl border border-[#E8E8E6] bg-white p-4 sm:rounded-2xl sm:p-6 md:p-8"
                        >
                            <div class="flex items-center gap-2.5 sm:gap-3 mb-4 sm:mb-5">
                                <img
                                    src="/icons/ic-menu-arrow.svg"
                                    class="h-5 w-5 flex-shrink-0 sm:h-6 sm:w-6"
                                    alt=""
                                />
                                <h2
                                    class="text-xs font-bold uppercase leading-snug tracking-wide text-black sm:text-[15px] sm:tracking-widest"
                                >
                                    {{ t("services.virtualOfficeDetail.sections.keunggulan_heading") }}
                                </h2>
                            </div>
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4">
                                <div
                                    v-for="(item, index) in detail.keunggulan"
                                    :key="`keunggulan-${index}`"
                                    class="rounded-xl border border-[#E8E8E6] p-3.5 sm:p-4"
                                >
                                    <div class="flex items-start gap-2.5 mb-2">
                                        <img
                                            src="/icons/ft-done.svg"
                                            class="mt-0.5 h-4 w-4 flex-shrink-0"
                                            alt="done"
                                        />
                                        <p
                                            class="text-[13px] font-bold text-[#1A1B18]"
                                        >
                                            {{ item.title }}
                                        </p>
                                    </div>
                                    <p
                                        class="text-[12px] leading-[1.6] text-[#686964] text-justify sm:leading-[1.7]"
                                    >
                                        {{ item.desc }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Paket Reguler -->
                        <div
                            v-if="paketReguler.columns?.length"
                            class="rounded-xl border border-[#E8E8E6] bg-white p-4 sm:rounded-2xl sm:p-6 md:p-8"
                        >
                            <div class="flex items-center gap-2.5 sm:gap-3 mb-4 sm:mb-5">
                                <img
                                    src="/icons/ic-menu-arrow.svg"
                                    class="h-5 w-5 flex-shrink-0 sm:h-6 sm:w-6"
                                    alt=""
                                />
                                <h2
                                    class="text-xs font-bold uppercase leading-snug tracking-wide text-black sm:text-[15px] sm:tracking-widest"
                                >
                                    {{ paketReguler.heading }}
                                </h2>
                            </div>

                            <!-- Scrollable table wrapper (contained, no negative-margin bleed) -->
                            <div
                                class="w-full max-w-full overflow-x-auto overscroll-x-contain pb-1 [-webkit-overflow-scrolling:touch] [scrollbar-width:thin]"
                            >
                                <table
                                    class="w-max min-w-full table-fixed border-collapse text-[12px] sm:text-[13px]"
                                >
                                    <colgroup>
                                        <col class="w-[92px] sm:w-[150px]" />
                                        <col
                                            v-for="(
                                                col, cIndex
                                            ) in paketReguler.columns"
                                            :key="`colgroup-${cIndex}`"
                                            class="w-[78px] sm:w-[110px]"
                                        />
                                    </colgroup>
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-left font-semibold text-[#686964] p-2 border-b border-[#E8E8E6] break-words sm:p-3"
                                                >
                                                    {{ paketReguler.jenis_label }}
                                                </th>
                                                <th
                                                    v-for="(
                                                        col, cIndex
                                                    ) in paketReguler.columns"
                                                    :key="`col-${cIndex}`"
                                                    class="cursor-pointer p-2 border-b break-words text-center text-[10.5px] font-bold uppercase leading-tight tracking-normal transition-colors sm:p-3 sm:text-[12px] sm:tracking-wide"
                                                    :class="
                                                        selectedPackageIndex ===
                                                        cIndex
                                                            ? 'bg-[#9e1f16] text-white border-[#9e1f16]'
                                                            : 'text-[#1A1B18] border-[#E8E8E6] hover:bg-[#F9F9F9]'
                                                    "
                                                    @click="
                                                        selectedPackageIndex =
                                                            cIndex
                                                    "
                                                >
                                                    {{ col }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(row, rIndex) in paketReguler.rows"
                                                :key="`row-${rIndex}`"
                                            >
                                                <td
                                                    class="p-2 border-b border-[#E8E8E6] text-[#3D3D3A] break-words sm:p-3"
                                                >
                                                    {{ row.label }}
                                                </td>
                                                <td
                                                    v-for="(
                                                        val, cIndex
                                                    ) in row.values"
                                                    :key="`val-${rIndex}-${cIndex}`"
                                                    class="p-2 border-b text-center border-[#E8E8E6] sm:p-3"
                                                    :class="
                                                        selectedPackageIndex ===
                                                        cIndex
                                                            ? 'bg-[#FBEAE8]'
                                                            : ''
                                                    "
                                                >
                                                    <img
                                                        v-if="val === true"
                                                        src="/icons/ft-done.svg"
                                                        class="inline-block h-3.5 w-3.5 sm:h-4 sm:w-4"
                                                        alt="ya"
                                                    />
                                                    <span
                                                        v-else-if="val === false"
                                                        class="text-[#B7B8B4]"
                                                        >-</span
                                                    >
                                                    <span
                                                        v-else
                                                        class="text-[#3D3D3A] break-words"
                                                        >{{ val }}</span
                                                    >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    class="p-2 font-bold text-[#1A1B18] break-words sm:p-3"
                                                >
                                                    {{ paketReguler.harga_label }}
                                                </td>
                                                <td
                                                    v-for="(
                                                        harga, hIndex
                                                    ) in paketReguler.harga"
                                                    :key="`harga-${hIndex}`"
                                                    class="p-2 text-center font-bold text-[#9e1f16] break-words sm:p-3"
                                                    :class="
                                                        selectedPackageIndex ===
                                                        hIndex
                                                            ? 'bg-[#FBEAE8]'
                                                            : ''
                                                    "
                                                >
                                                    {{ harga }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <p class="mt-2 text-[10px] text-[#B7B8B4] sm:hidden">
                                {{ t("services.virtualOfficeDetail.table.swipe_hint") }}
                            </p>

                            <div
                                class="mt-4 flex flex-col gap-3 rounded-xl bg-[#E9F9EE] px-4 py-3.5 sm:mt-5 sm:flex-row sm:items-center sm:justify-between sm:px-5 sm:py-4"
                            >
                                <div>
                                    <p class="text-[11px] text-[#686964]">
                                        {{ paketReguler.selected_label }}
                                    </p>
                                    <p
                                        class="text-[13px] font-bold text-[#1A1B18] sm:text-[14px]"
                                    >
                                        {{ selectedPackageName }}
                                        <span class="text-[#9e1f16]"
                                            >{{ selectedPackagePrice
                                            }}{{ paketReguler.per_tahun }}</span
                                        >
                                    </p>
                                </div>
                                <a
                                    :href="
                                        buildWhatsappLink(
                                            product.name,
                                            selectedPackageName,
                                        )
                                    "
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] px-4 py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors sm:inline-flex sm:w-auto sm:whitespace-nowrap"
                                >
                                    <img
                                        src="/icons/ft-wa.svg"
                                        class="h-4 w-4"
                                        alt="wa"
                                    />
                                    {{ t("services.virtualOfficeDetail.table.konsultasi_cta") }}
                                </a>
                            </div>
                        </div>

                        <!-- 5. Galeri Foto -->
                        <div
                            v-if="detail.gallery?.items?.length"
                            class="rounded-xl border border-[#E8E8E6] bg-white p-4 sm:rounded-2xl sm:p-6 md:p-8"
                        >
                            <div class="flex items-center gap-2.5 sm:gap-3 mb-4 sm:mb-5">
                                <img
                                    src="/icons/ic-menu-arrow.svg"
                                    class="h-5 w-5 flex-shrink-0 sm:h-6 sm:w-6"
                                    alt=""
                                />
                                <h2
                                    class="text-xs font-bold uppercase leading-snug tracking-wide text-black sm:text-[15px] sm:tracking-widest"
                                >
                                    {{ detail.gallery.heading }}
                                </h2>
                            </div>
                            <div
                                class="grid grid-cols-2 gap-2.5 sm:grid-cols-4 sm:gap-3"
                            >
                                <div
                                    v-for="(loc, index) in detail.gallery
                                        .items"
                                    :key="`loc-${index}`"
                                    class="relative overflow-hidden rounded-lg aspect-[3/4] sm:rounded-xl"
                                >
                                    <img
                                        :src="loc.image"
                                        :alt="loc.location"
                                        class="absolute inset-0 h-full w-full object-cover"
                                    />
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"
                                    ></div>
                                    <span
                                        v-if="loc.available"
                                        class="absolute top-1.5 right-1.5 rounded-full bg-[#25D366] px-1.5 py-0.5 text-[9px] font-semibold text-white sm:top-2 sm:right-2 sm:text-[10px]"
                                    >
                                        {{ detail.gallery.available_badge }}
                                    </span>
                                    <div class="absolute bottom-1.5 left-1.5 right-1.5 sm:bottom-2 sm:left-2 sm:right-2">
                                        <p
                                            class="text-[12px] font-bold text-white sm:text-[13px]"
                                        >
                                            {{ t("services.virtualOfficeDetail.gallery.lokasi_prefix") }} {{ loc.location }}
                                        </p>
                                        <span
                                            class="mt-1 inline-block rounded bg-white/20 px-1.5 py-0.5 text-[9px] text-white backdrop-blur-sm sm:text-[10px]"
                                        >
                                            {{ loc.kpp }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== KANAN: Sidebar ===== -->
                    <div
                        class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start min-w-0"
                    >
                        <!-- VIP Line Banner -->
                        <div
                            class="rounded-2xl px-5 py-6 text-center overflow-hidden relative"
                            style="
                                background-image: url(&quot;/images/card-arrow-bg.png&quot;);
                                background-size: cover;
                                background-position: center;
                                background-repeat: no-repeat;
                            "
                        >
                            <div class="relative mb-3 sm:mb-4">
                                <div
                                    class="inline-block w-full rounded-xl border border-white/60 px-3 py-2 sm:px-4 sm:py-2.5"
                                >
                                    <span
                                        class="text-[12px] font-extrabold uppercase tracking-wide text-white sm:text-[14px] sm:tracking-widest"
                                    >
                                        {{ detail.sidebar?.vip_title }}
                                    </span>
                                </div>
                            </div>

                            <p
                                class="relative text-[13px] leading-[1.55] text-white/90 mb-4 sm:text-[14px] sm:leading-[1.6] sm:mb-5"
                            >
                                {{ detail.sidebar?.vip_desc }}
                            </p>
                            <a
                                :href="
                                    buildWhatsappLink(
                                        product.name,
                                        selectedPackageName,
                                    )
                                "
                                target="_blank"
                                rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-2.5 text-[12.5px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20 sm:py-3 sm:text-[13px]"
                            >
                                <img
                                    src="/icons/ft-wa.svg"
                                    class="mt-0.5 h-4.5 w-4.5 flex-shrink-0 sm:h-5 sm:w-5"
                                    alt="wa"
                                />
                                {{ detail.sidebar?.vip_cta }}
                            </a>

                            <div
                                class="relative mt-2.5 text-[10px] text-white/60 sm:mt-3 sm:text-[11px]"
                            >
                                {{ detail.sidebar?.vip_note }}
                            </div>
                        </div>

                        <!-- Price Card -->
                        <div
                            class="rounded-xl border border-[#E8E8E6] bg-white p-4 sm:rounded-2xl sm:p-5"
                        >
                            <label
                                class="mb-3 flex items-center justify-between rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] px-3 py-2.5 sm:mb-4"
                            >
                                <select
                                    v-model="selectedPackageIndex"
                                    class="w-full appearance-none bg-transparent text-[13px] text-[#1A1B18] focus:outline-none"
                                >
                                    <option
                                        v-for="(
                                            col, cIndex
                                        ) in paketReguler.columns"
                                        :key="`opt-${cIndex}`"
                                        :value="cIndex"
                                    >
                                        {{ col }}
                                    </option>
                                </select>
                                <svg
                                    class="h-4 w-4 text-[#686964] flex-shrink-0"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </label>
                            <div class="text-[11px] text-[#686964] mb-1 sm:text-[12px]">
                                {{ detail.sidebar?.starting_from }}
                            </div>
                            <div
                                class="text-[26px] font-bold leading-tight text-primary mb-1 break-words sm:text-[32px] sm:leading-none"
                            >
                                {{ selectedPackagePrice
                                }}{{ paketReguler.per_tahun }}
                            </div>
                            <div class="text-[10px] text-[#686964] mb-3 sm:text-[11px] sm:mb-4">
                                {{ t("services.virtualOfficeDetail.sidebar.price_note") }}
                            </div>
                            <a
                                :href="
                                    buildWhatsappLink(
                                        product.name,
                                        selectedPackageName,
                                    )
                                "
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors"
                            >
                                <img
                                    src="/icons/ft-wa.svg"
                                    class="mt-0.5 h-5 w-5 flex-shrink-0 sm:h-6 sm:w-6"
                                    alt="wa"
                                />
                                {{ detail.sidebar?.consult_cta }}
                            </a>
                            <ul class="mt-3 space-y-2 sm:mt-4">
                                <li
                                    v-for="(
                                        item, index
                                    ) in detail.sidebar?.checklist"
                                    :key="`check-${index}`"
                                    class="flex items-start gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <img
                                        src="/icons/ft-done.svg"
                                        class="mt-0.5 h-4 w-4 flex-shrink-0"
                                        alt="done"
                                    />
                                    <span>{{ item }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Layanan Terkait -->
                        <div
                            v-if="relatedProducts.length"
                            class="rounded-xl border border-[#E8E8E6] bg-white p-4 sm:rounded-2xl sm:p-5"
                        >
                            <h3
                                class="text-[13px] font-bold text-[#1A1B18] mb-3 sm:mb-4"
                            >
                                {{ t("services.virtualOfficeDetail.sidebar.related_title") }}
                            </h3>
                            <div class="flex flex-col gap-3">
                                <a
                                    v-for="(
                                        related, index
                                    ) in relatedProducts.slice(0, 3)"
                                    :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex flex-col gap-2 rounded-xl border border-[#E8E8E6] bg-white p-3.5 hover:border-primary/30 hover:shadow-sm transition-all sm:p-4"
                                >
                                    <div
                                        class="text-[13px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors sm:text-[14px]"
                                    >
                                        {{ pick(related.name) }}
                                    </div>
                                    <p
                                        class="text-[12px] leading-[1.6] text-[#686964] line-clamp-3"
                                    >
                                        {{
                                            pick(related.excerpt) ?? pick(related.description)
                                        }}
                                    </p>
                                    <hr class="border-[#E8E8E6]" />
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div>
                                            <div
                                                class="text-[11px] text-[#686964] mb-0.5"
                                            >
                                                {{ t("services.virtualOfficeDetail.sidebar.related_from") }}
                                            </div>
                                            <div
                                                class="text-[16px] font-bold text-primary leading-none sm:text-[18px]"
                                            >
                                                {{ related.price_label }}
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-1 flex items-center justify-center gap-2 rounded-xl border border-primary py-2.5 text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors"
                                    >
                                        {{ t("services.virtualOfficeDetail.sidebar.related_cta") }}
                                        <svg
                                            class="h-4 w-4 group-hover:translate-x-0.5 transition-transform"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2.5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 5l7 7-7 7"
                                            />
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
            :title="t('services.virtualOfficeDetail.footer.title')"
            :description="t('services.virtualOfficeDetail.footer.desc')"
            :button-text="t('services.virtualOfficeDetail.footer.cta')"
            :whatsapp-link="buildWhatsappLink(t('services.virtualOfficeDetail.footer.wa_subject'), '')"
        />
    </MainLayout>
</template>