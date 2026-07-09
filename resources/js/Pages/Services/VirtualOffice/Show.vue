<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref, computed } from "vue";
import { useI18n } from "vue-i18n";

const { locale } = useI18n();

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

const buildWhatsappLink = (productName, packageName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${productName} (${packageName}).`;
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
        <!-- Hero Section -->
        <section
            class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px] bg-[#9e1f16]"
        >
            <div class="ml-5">
                <img
                    src="/icons/left-arrow.svg"
                    class="absolute right-[0%] -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block"
                    alt=""
                />
            </div>

            <div
                class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]"
            >
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb">
                    <div
                        class="inline-flex items-center gap-2 rounded-md bg-white px-4 py-2"
                    >
                        <a
                            href="/"
                            class="text-[#9e1f16] hover:text-black transition"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"
                                />
                            </svg>
                        </a>
                        <svg
                            class="h-3 w-3 text-[#9e1f16]"
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
                        <a
                            href="/layanan"
                            class="text-sm font-medium text-[#9e1f16] hover:underline"
                            >Layanan</a
                        >
                        <svg
                            class="h-3 w-3 text-[#9e1f16]"
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
                        <span class="text-sm font-medium text-[#9e1f16]">{{
                            product.name
                        }}</span>
                    </div>
                </nav>

                <!-- Center: Heading -->
                <div class="flex items-center gap-5">
                    <div
                        class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white shadow-md"
                    >
                        <img
                            src="/icons/ft-building.svg"
                            class="w-9 h-9"
                            alt=""
                        />
                    </div>
                    <div>
                        <h1
                            class="text-3xl font-extrabold leading-tight text-white sm:text-2xl lg:text-3xl max-w-[800px] line-clamp-2"
                        >
                            {{ product.name }}
                        </h1>
                        <p
                            class="mt-2 max-w-2xl text-sm leading-relaxed text-white/80 hidden sm:block"
                        >
                            {{ product.excerpt }}
                        </p>
                    </div>
                </div>

                <!-- Bottom: Back button -->
                <div>
                    <a
                        href="/virtual-office"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section id="edukasi" class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="grid gap-8 lg:grid-cols-[1fr_280px] xl:grid-cols-[1fr_300px]"
                >
                    <!-- ===== KIRI: Konten Utama ===== -->
                    <div class="flex flex-col gap-6">
                        <!-- 1. Intro -->
                        <div
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <div class="flex items-center gap-3 mb-5">
                                <img
                                    src="/icons/ic-menu-arrow.svg"
                                    class="w-6 h-6"
                                    alt=""
                                />
                                <h2
                                    class="text-[15px] font-bold uppercase tracking-widest text-black"
                                >
                                    {{ detail.intro?.heading }}
                                </h2>
                            </div>
                            <div class="space-y-4">
                                <p
                                    v-for="(paragraph, index) in detail.intro
                                        ?.paragraphs"
                                    :key="`intro-${index}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify"
                                >
                                    {{ paragraph }}
                                </p>
                            </div>
                        </div>

                        <!-- 2. Promo Banner -->
                        <div
                            v-if="detail.promo"
                            class="relative overflow-hidden rounded-2xl bg-[#9e1f16] px-6 py-6 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
                        >
                            <div>
                                <p class="text-[12px] text-white/70">
                                    {{ detail.promo.label }}
                                </p>
                                <p
                                    class="text-[20px] sm:text-[24px] font-extrabold text-white"
                                >
                                    {{ detail.promo.highlight }}
                                </p>
                            </div>
                            <div
                                class="inline-flex items-center rounded-lg bg-white px-4 py-2.5 text-[14px] font-bold text-[#9e1f16] whitespace-nowrap self-start sm:self-auto"
                            >
                                {{ detail.promo.badge }}
                            </div>
                        </div>

                        <!-- 3. Keunggulan -->
                        <div
                            v-if="detail.keunggulan?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <div class="flex items-center gap-3 mb-5">
                                <img
                                    src="/icons/ic-menu-arrow.svg"
                                    class="w-6 h-6"
                                    alt=""
                                />
                                <h2
                                    class="text-[15px] font-bold uppercase tracking-widest text-black"
                                >
                                    Keunggulan Virtual Office Fasttrack
                                </h2>
                            </div>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div
                                    v-for="(item, index) in detail.keunggulan"
                                    :key="`keunggulan-${index}`"
                                    class="rounded-xl border border-[#E8E8E6] p-4"
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
                                        class="text-[12px] leading-[1.7] text-[#686964] text-justify"
                                    >
                                        {{ item.desc }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Paket Reguler -->
                        <div
                            v-if="paketReguler.columns?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <div class="flex items-center gap-3 mb-5">
                                <img
                                    src="/icons/ic-menu-arrow.svg"
                                    class="w-6 h-6"
                                    alt=""
                                />
                                <h2
                                    class="text-[15px] font-bold uppercase tracking-widest text-black"
                                >
                                    {{ paketReguler.heading }}
                                </h2>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse text-[13px]">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-left font-semibold text-[#686964] p-3 border-b border-[#E8E8E6] whitespace-nowrap"
                                            >
                                                {{ paketReguler.jenis_label }}
                                            </th>
                                            <th
                                                v-for="(
                                                    col, cIndex
                                                ) in paketReguler.columns"
                                                :key="`col-${cIndex}`"
                                                class="cursor-pointer p-3 border-b whitespace-nowrap text-center font-bold uppercase tracking-wide transition-colors"
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
                                                class="p-3 border-b border-[#E8E8E6] text-[#3D3D3A]"
                                            >
                                                {{ row.label }}
                                            </td>
                                            <td
                                                v-for="(
                                                    val, cIndex
                                                ) in row.values"
                                                :key="`val-${rIndex}-${cIndex}`"
                                                class="p-3 border-b text-center border-[#E8E8E6]"
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
                                                    class="inline-block h-4 w-4"
                                                    alt="ya"
                                                />
                                                <span
                                                    v-else-if="val === false"
                                                    class="text-[#B7B8B4]"
                                                    >-</span
                                                >
                                                <span
                                                    v-else
                                                    class="text-[#3D3D3A] whitespace-nowrap"
                                                    >{{ val }}</span
                                                >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="p-3 font-bold text-[#1A1B18]"
                                            >
                                                {{ paketReguler.harga_label }}
                                            </td>
                                            <td
                                                v-for="(
                                                    harga, hIndex
                                                ) in paketReguler.harga"
                                                :key="`harga-${hIndex}`"
                                                class="p-3 text-center font-bold text-[#9e1f16] whitespace-nowrap"
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

                            <div
                                class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 rounded-xl bg-[#E9F9EE] px-5 py-4"
                            >
                                <div>
                                    <p class="text-[11px] text-[#686964]">
                                        {{ paketReguler.selected_label }}
                                    </p>
                                    <p
                                        class="text-[14px] font-bold text-[#1A1B18]"
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
                                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#25D366] px-4 py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors whitespace-nowrap"
                                >
                                    <img
                                        src="/icons/ft-wa.svg"
                                        class="h-4 w-4"
                                        alt="wa"
                                    />
                                    Konsultasi via Whatsapp
                                </a>
                            </div>
                        </div>

                        <!-- 5. Galeri Foto -->
                        <div
                            v-if="detail.gallery?.items?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <div class="flex items-center gap-3 mb-5">
                                <img
                                    src="/icons/ic-menu-arrow.svg"
                                    class="w-6 h-6"
                                    alt=""
                                />
                                <h2
                                    class="text-[15px] font-bold uppercase tracking-widest text-black"
                                >
                                    {{ detail.gallery.heading }}
                                </h2>
                            </div>
                            <div
                                class="grid grid-cols-2 sm:grid-cols-4 gap-3"
                            >
                                <div
                                    v-for="(loc, index) in detail.gallery
                                        .items"
                                    :key="`loc-${index}`"
                                    class="relative overflow-hidden rounded-xl aspect-[3/4]"
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
                                        class="absolute top-2 right-2 rounded-full bg-[#25D366] px-2 py-0.5 text-[10px] font-semibold text-white"
                                    >
                                        {{ detail.gallery.available_badge }}
                                    </span>
                                    <div class="absolute bottom-2 left-2 right-2">
                                        <p
                                            class="text-[13px] font-bold text-white"
                                        >
                                            Lokasi {{ loc.location }}
                                        </p>
                                        <span
                                            class="mt-1 inline-block rounded bg-white/20 px-1.5 py-0.5 text-[10px] text-white backdrop-blur-sm"
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
                        class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start"
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
                            <div class="relative mb-4">
                                <div
                                    class="inline-block w-full rounded-xl border border-white/60 px-4 py-2.5"
                                >
                                    <span
                                        class="text-[14px] font-extrabold uppercase tracking-widest text-white"
                                    >
                                        {{ detail.sidebar?.vip_title }}
                                    </span>
                                </div>
                            </div>

                            <p
                                class="relative text-[14px] leading-[1.6] text-white/90 mb-5"
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
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20"
                            >
                                <img
                                    src="/icons/ft-wa.svg"
                                    class="mt-0.5 h-5 w-5 flex-shrink-0"
                                    alt="wa"
                                />
                                {{ detail.sidebar?.vip_cta }}
                            </a>

                            <div
                                class="relative mt-3 text-[11px] text-white/60"
                            >
                                {{ detail.sidebar?.vip_note }}
                            </div>
                        </div>

                        <!-- Price Card -->
                        <div
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5"
                        >
                            <label
                                class="mb-4 flex items-center justify-between rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] px-3 py-2.5"
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
                            <div class="text-[12px] text-[#686964] mb-1">
                                {{ detail.sidebar?.starting_from }}
                            </div>
                            <div
                                class="text-[32px] font-bold leading-none text-primary mb-1"
                            >
                                {{ selectedPackagePrice
                                }}{{ paketReguler.per_tahun }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">
                                *Harga final dikonfirmasi setelah konsultasi
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
                                    class="mt-0.5 h-6 w-6 flex-shrink-0"
                                    alt="wa"
                                />
                                {{ detail.sidebar?.consult_cta }}
                            </a>
                            <ul class="mt-4 space-y-2">
                                <li
                                    v-for="(
                                        item, index
                                    ) in detail.sidebar?.checklist"
                                    :key="`check-${index}`"
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <img
                                        src="/icons/ft-done.svg"
                                        class="mt-0.5 h-4 w-4 flex-shrink-0"
                                        alt="done"
                                    />
                                    {{ item }}
                                </li>
                            </ul>
                        </div>

                        <!-- Layanan Terkait -->
                        <div
                            v-if="relatedProducts.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5"
                        >
                            <h3
                                class="text-[13px] font-bold text-[#1A1B18] mb-4"
                            >
                                Layanan Terkait
                            </h3>
                            <div class="flex flex-col gap-3">
                                <a
                                    v-for="(
                                        related, index
                                    ) in relatedProducts.slice(0, 3)"
                                    :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex flex-col gap-2 rounded-xl border border-[#E8E8E6] bg-white p-4 hover:border-primary/30 hover:shadow-sm transition-all"
                                >
                                    <div
                                        class="text-[14px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors"
                                    >
                                        {{ related.name }}
                                    </div>
                                    <p
                                        class="text-[12px] leading-[1.6] text-[#686964] line-clamp-3"
                                    >
                                        {{
                                            related.excerpt ??
                                            related.description
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
                                                Mulai dari
                                            </div>
                                            <div
                                                class="text-[18px] font-bold text-primary leading-none"
                                            >
                                                {{ related.price_label }}
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-1 flex items-center justify-center gap-2 rounded-xl border border-primary py-2.5 text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors"
                                    >
                                        Selengkapnya
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

        <!-- Footer CTA Banner -->
        <section id="footer" class="bg-[#F7F7F5] mb-12 sm:mb-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="relative overflow-hidden rounded-2xl bg-[#9e1f16] px-6 py-12 sm:px-10 sm:py-14"
                >
                    <img
                        src="/icons/ft-docs.svg"
                        alt=""
                        class="absolute right-6 top-6 h-16 w-16 opacity-20 sm:right-10 sm:top-8 sm:h-24 sm:w-24"
                    />
                    <div
                        class="relative flex flex-col items-center text-center"
                    >
                        <h3
                            class="max-w-2xl text-[22px] font-bold leading-[32px] text-white sm:text-[28px] sm:leading-[38px]"
                        >
                            Tidak Menemukan Layanan yang Anda Cari?
                        </h3>
                        <p
                            class="mt-4 max-w-lg text-[14px] leading-[22px] text-white/80 sm:text-[16px] sm:leading-[24px]"
                        >
                            Tim kami siap membantu Anda menemukan solusi yang
                            tepat untuk kebutuhan legalitas bisnis Anda.
                        </p>
                        <a
                            :href="
                                buildWhatsappLink(
                                    'layanan yang tidak terdaftar',
                                    '',
                                )
                            "
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-8 inline-flex items-center gap-2.5 rounded-lg bg-[#25D366] px-6 py-3 text-[14px] font-semibold text-white shadow-lg shadow-[#25D366]/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#20BD5A] hover:shadow-xl hover:shadow-[#25D366]/40 sm:px-8 sm:py-3.5 sm:text-[15px]"
                        >
                            Chat Langsung via WhatsApp
                            <img
                                src="/icons/ft-wa.svg"
                                alt="WhatsApp"
                                class="h-5 w-5"
                            />
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
