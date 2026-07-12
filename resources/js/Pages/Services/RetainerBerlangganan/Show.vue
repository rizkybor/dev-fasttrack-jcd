<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { ref, computed } from "vue";
import { useI18n } from "vue-i18n";

const { locale } = useI18n();

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

const parseBold = (text) => {
    if (!text) return "";
    return text.replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>");
};

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
        tag: pick(p.tag),
        duration: pick(p.duration),
        description: pick(p.description),
        excerpt: pick(p.excerpt),
        audience: pick(p.audience),
        content: pick(p.content) ?? [],
        faq: pick(p.faq) ?? [],
        contract_categories: pick(p.contract_categories) ?? [],
        regular_packages: pick(p.regular_packages),
        corporate_secretary: pick(p.corporate_secretary),
    };
});

const product = localizedProduct;

const currentPlans = computed(() => product.value?.plans ?? []);
const currentDasarHukum = computed(() => product.value?.dasar_hukum ?? []);

// Toggle truncate per doc item
const expandedDocs = ref({});
const toggleDoc = (key) => {
    expandedDocs.value[key] = !expandedDocs.value[key];
};

// Jenis Perjanjian / Kontrak - search & filter
const contractSearchQuery = ref("");

const contractCategories = computed(
    () => product.value?.contract_categories ?? [],
);

const filteredContractCategories = computed(() => {
    const query = contractSearchQuery.value.trim().toLowerCase();

    if (!query) return contractCategories.value;

    return contractCategories.value
        .map((category) => ({
            ...category,
            items: category.items.filter((item) =>
                item.name.toLowerCase().includes(query),
            ),
        }))
        .filter((category) => category.items.length > 0);
});

// Paket Regular - scale selector
const regularPackages = computed(() => product.value?.regular_packages ?? null);

const selectedScale = ref(
    regularPackages.value?.default_scale ??
        regularPackages.value?.scales?.[0]?.key ??
        null,
);

const selectedScaleData = computed(
    () =>
        regularPackages.value?.scales?.find(
            (s) => s.key === selectedScale.value,
        ) ?? null,
);

const selectScale = (key) => {
    selectedScale.value = key;
};

// Berlangganan Corporate Secretary - PMDN/PMA toggle
const corporateSecretary = computed(
    () => product.value?.corporate_secretary ?? null,
);
const corporateType = ref("pmdn");

const currentCorporatePackages = computed(
    () => corporateSecretary.value?.[corporateType.value] ?? [],
);
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section
            class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]"
        >
            <!-- Background image + overlay -->
            <div class="absolute inset-0">
                <img
                    src="/images/layanan-hero/ft-hero-retainer-berlangganan.png"
                    class="h-full w-full object-cover object-center"
                    alt=""
                />
                <div
                    class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"
                ></div>
            </div>

            <div
                class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]"
            >
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb">
                    <div
                        class="inline-flex items-center gap-2 sm:rounded-md sm:bg-white sm:px-4 sm:py-2"
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

                <!-- Center: Heading + description -->
                <div class="flex flex-col gap-3 max-w-2xl">
                    <h1
                        class="font-extrabold leading-tight text-white text-2xl sm:text-3xl lg:text-4xl"
                    >
                        {{ product.name }}
                    </h1>
                    <p
                        class="text-sm sm:text-base text-white/85 leading-relaxed"
                    >
                        {{ product.description }}
                    </p>
                </div>

                <!-- Bottom: Back button -->
                <div>
                    <a
                        href="/layanan"
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
                    class="grid gap-8 lg:grid-cols-[1fr_280px] xl:grid-cols-[1fr_300px] min-w-0"
                >
                    <!-- ===== KIRI: Konten Utama ===== -->
                    <div class="flex flex-col gap-6 min-w-0">
                        <!-- 1. Penjelasan Umum -->
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
                                    Informasi Umum
                                </h2>
                            </div>
                            <div class="space-y-4">
                                <p
                                    v-for="(
                                        paragraph, index
                                    ) in product.content"
                                    :key="`content-${index}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A]"
                                >
                                    {{ paragraph }}
                                </p>
                            </div>
                        </div>

                        <!-- PAKET REGULAR -->
                        <div
                            v-if="regularPackages"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-4 sm:p-6 lg:p-8"
                        >
                            <div
                                class="flex items-center gap-2.5 sm:gap-3 mb-2 sm:mb-6"
                            >
                                <img
                                    src="/icons/ic-menu-arrow.svg"
                                    class="w-5 h-5 sm:w-6 sm:h-6"
                                    alt=""
                                />
                                <h2
                                    class="text-[13px] sm:text-[15px] font-bold uppercase tracking-widest text-black"
                                >
                                    Paket Regular
                                </h2>
                            </div>

                            <!-- DESKTOP TABLE VIEW  -->
                            <div
                                class="hidden sm:block overflow-x-auto -mx-4 sm:mx-0 px-4 sm:px-0 rounded-lg"
                            >
                                <table
                                    class="w-full min-w-[380px] sm:min-w-[440px] border-separate border-spacing-0 text-[8px] sm:text-[10px]"
                                >
                                    <thead>
                                        <tr>
                                            <th
                                                class="sticky left-0 z-20 text-left font-semibold text-[#1A1B18] px-1 sm:px-1.5 py-4 sm:py-5 border-b-2 border-r border-[#E8E8E6] bg-[#F9F9F9] whitespace-nowrap"
                                            >
                                                Jenis Layanan (per bulan)
                                            </th>
                                            <th
                                                v-for="scale in regularPackages.scales"
                                                :key="`scale-head-${scale.key}`"
                                                @click="selectScale(scale.key)"
                                                class="cursor-pointer text-center font-bold px-1 sm:px-1.5 py-4 sm:py-5 border-b-2 whitespace-nowrap transition-colors"
                                                :class="
                                                    selectedScale === scale.key
                                                        ? 'bg-primary text-white rounded-t-lg border-primary'
                                                        : 'bg-white text-[#1A1B18] border-[#E8E8E6] hover:bg-[#F9F9F9]'
                                                "
                                            >
                                                {{ scale.label }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(
                                                row, ri
                                            ) in regularPackages.rows"
                                            :key="`row-${ri}`"
                                        >
                                            <td
                                                class="sticky left-0 z-10 text-left text-[#1A1B18] font-medium px-1 sm:px-1.5 py-4 sm:py-5 border-b border-r border-[#E8E8E6] bg-white whitespace-nowrap"
                                            >
                                                {{ row.label }}
                                            </td>
                                            <td
                                                v-for="scale in regularPackages.scales"
                                                :key="`cell-${ri}-${scale.key}`"
                                                class="text-center px-1 sm:px-1.5 py-4 sm:py-5 border-b border-[#E8E8E6] whitespace-nowrap transition-colors"
                                                :class="[
                                                    selectedScale === scale.key
                                                        ? 'bg-[#F5D4D4]'
                                                        : 'bg-white',
                                                    ri ===
                                                        regularPackages.rows
                                                            .length -
                                                            1 &&
                                                    selectedScale === scale.key
                                                        ? 'rounded-b-lg'
                                                        : '',
                                                    ri === regularPackages.rows.length - 1
                                                        ? 'text-primary font-bold'
                                                        : selectedScale ===
                                                            scale.key
                                                          ? 'text-primary'
                                                          : 'text-[#3D3D3A]',
                                                ]"
                                            >
                                                {{ row.values[scale.key] }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- MOBILE TABLE VIEW  -->
                            <div class="sm:hidden flex flex-col gap-3">
                                <div
                                    v-for="scale in regularPackages.scales"
                                    :key="`card-${scale.key}`"
                                    @click="selectScale(scale.key)"
                                    class="rounded-xl border-2 p-4 transition-colors"
                                    :class="
                                        selectedScale === scale.key
                                            ? 'border-primary bg-[#FCEEEE]'
                                            : 'border-[#E8E8E6] bg-white'
                                    "
                                >
                                    <!-- Card header: scale name + radio indicator -->
                                    <div
                                        class="flex items-center justify-between mb-3"
                                    >
                                        <span
                                            class="text-[14px] font-bold text-[#1A1B18]"
                                        >
                                            {{ scale.label }}
                                        </span>
                                        <span
                                            class="w-4 h-4 rounded-full border-2 flex items-center justify-center shrink-0"
                                            :class="
                                                selectedScale === scale.key
                                                    ? 'border-primary'
                                                    : 'border-[#D6D6D3]'
                                            "
                                        >
                                            <span
                                                v-if="
                                                    selectedScale === scale.key
                                                "
                                                class="w-2 h-2 rounded-full bg-primary"
                                            ></span>
                                        </span>
                                    </div>

                                    <!-- Card rows -->
                                    <div class="divide-y divide-[#EFEFED]">
                                        <div
                                            v-for="(
                                                row, ri
                                            ) in regularPackages.rows"
                                            :key="`mcell-${scale.key}-${ri}`"
                                            class="flex items-center justify-between gap-3 py-2"
                                            :class="
                                                ri === regularPackages.rows.length - 1
                                                    ? 'pt-3'
                                                    : ''
                                            "
                                        >
                                            <span
                                                class="text-[11px]"
                                                :class="
                                                    ri === regularPackages.rows.length - 1
                                                        ? 'font-semibold text-[#1A1B18] text-[12px]'
                                                        : 'text-[#686964]'
                                                "
                                            >
                                                {{ row.label }}
                                            </span>
                                            <span
                                                class="text-right"
                                                :class="
                                                    ri === regularPackages.rows.length - 1
                                                        ? 'text-primary font-bold text-[14px]'
                                                        : 'text-[#3D3D3A] font-medium text-[11px]'
                                                "
                                            >
                                                {{ row.values[scale.key] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                v-if="selectedScaleData"
                                class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 rounded-xl bg-[#E7F7EE] px-4 sm:px-5 py-4"
                            >
                                <div>
                                    <div
                                        class="text-[11px] sm:text-[12px] text-[#686964]"
                                    >
                                        Skala terpilih
                                    </div>
                                    <div
                                        class="text-[14px] sm:text-[15px] font-bold text-[#1A1B18]"
                                    >
                                        {{ selectedScaleData.label }}
                                        <span class="text-primary">{{
                                            selectedScaleData.price_label
                                        }}</span>
                                    </div>
                                </div>
                                <a
                                    :href="
                                        buildWhatsappLink(
                                            `${product.name} - ${selectedScaleData.label}`,
                                        )
                                    "
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-[#25D366] px-5 py-2.5 text-[12px] sm:text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors whitespace-nowrap"
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

                        <!-- BERLANGGANAN CORPORATE SECRETARY -->
                        <div
                            v-if="corporateSecretary"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-4 sm:p-6 lg:p-8"
                        >
                            <div
                                class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-5 sm:mb-6"
                            >
                                <div class="flex items-center gap-2.5 sm:gap-3">
                                    <img
                                        src="/icons/ic-menu-arrow.svg"
                                        class="w-5 h-5 sm:w-6 sm:h-6"
                                        alt=""
                                    />
                                    <h2
                                        class="text-[13px] sm:text-[15px] font-bold uppercase tracking-widest text-black"
                                    >
                                        Berlangganan Corporate Secretary
                                    </h2>
                                </div>

                                <div
                                    class="flex w-full sm:w-auto rounded-full border border-[#E8E8E6] p-1"
                                >
                                    <button
                                        @click="corporateType = 'pmdn'"
                                        class="flex-1 sm:flex-initial rounded-full px-4 py-1.5 text-[12px] font-semibold transition-colors"
                                        :class="
                                            corporateType === 'pmdn'
                                                ? 'bg-primary text-white'
                                                : 'text-[#686964]'
                                        "
                                    >
                                        PMDN
                                    </button>
                                    <button
                                        @click="corporateType = 'pma'"
                                        class="flex-1 sm:flex-initial rounded-full px-4 py-1.5 text-[12px] font-semibold transition-colors"
                                        :class="
                                            corporateType === 'pma'
                                                ? 'bg-primary text-white'
                                                : 'text-[#686964]'
                                        "
                                    >
                                        PMA
                                    </button>
                                </div>
                            </div>

                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-stretch"
                            >
                                <div
                                    v-for="(
                                        pkg, pi
                                    ) in currentCorporatePackages"
                                    :key="`corp-${corporateType}-${pi}`"
                                    class="relative flex h-full flex-col rounded-xl border p-4 sm:p-5"
                                    :class="
                                        pkg.popular
                                            ? 'border-primary shadow-md shadow-primary/10'
                                            : 'border-[#E8E8E6]'
                                    "
                                >
                                    <div
                                        v-if="pkg.popular"
                                        class="absolute -top-3.5 left-1/2 -translate-x-1/2"
                                    >
                                        <span
                                            class="inline-flex items-center rounded-full border border-primary bg-white px-3 py-0.5 text-[11px] font-semibold text-primary whitespace-nowrap"
                                        >
                                            Paling Populer
                                        </span>
                                    </div>

                                    <div
                                        class="text-[12px] sm:text-[13px] font-bold uppercase tracking-wide text-[#1A1B18] mb-3"
                                        :class="pkg.popular ? 'mt-1' : ''"
                                    >
                                        {{ pkg.name }}
                                    </div>

                                    <div class="mb-4">
                                        <div class="text-[11px] text-[#686964]">
                                            Mulai dari
                                        </div>
                                        <div
                                            class="text-[20px] sm:text-[24px] font-bold leading-tight text-primary"
                                        >
                                            {{ pkg.price }}
                                        </div>
                                    </div>

                                    <ul class="flex flex-col gap-2 mb-4">
                                        <li
                                            v-for="(
                                                feature, fi
                                            ) in pkg.features"
                                            :key="`feature-${pi}-${fi}`"
                                            class="flex items-start gap-2 text-[12px] sm:text-[13px] text-[#3D3D3A]"
                                        >
                                            <img
                                                src="/icons/ft-done.svg"
                                                class="mt-0.5 h-4 w-4 flex-shrink-0"
                                                alt="done"
                                            />
                                            <span>
                                                {{ feature.text }}
                                                <span
                                                    v-if="feature.bold"
                                                    class="font-semibold text-[#1A1B18]"
                                                    >{{ feature.bold }}</span
                                                >
                                            </span>
                                        </li>
                                    </ul>

                                    <div
                                        v-if="pkg.note"
                                        class="flex items-start gap-2 text-[11px] sm:text-[12px] text-[#686964] mb-4"
                                    >
                                        <svg
                                            class="h-4 w-4 flex-shrink-0 mt-0.5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <circle cx="12" cy="12" r="10" />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 16v-4m0-4h.01"
                                            />
                                        </svg>
                                        <span>
                                            {{ pkg.note.label }}
                                            <span
                                                class="font-semibold text-[#1A1B18]"
                                                >{{ pkg.note.bold }}</span
                                            >
                                        </span>
                                    </div>

                                    <a
                                        :href="
                                            buildWhatsappLink(
                                                `${product.name} - ${pkg.name}`,
                                            )
                                        "
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="mt-auto flex items-center justify-center gap-2 rounded-lg py-2.5 text-[12px] sm:text-[13px] font-semibold transition-colors"
                                        :class="
                                            pkg.popular
                                                ? 'bg-primary text-white hover:bg-primary/90'
                                                : 'border border-primary text-primary hover:bg-primary hover:text-white'
                                        "
                                    >
                                        Berlangganan Sekarang
                                        <svg
                                            class="h-3.5 w-3.5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2.5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"
                                            />
                                        </svg>
                                    </a>
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
                            <div class="relative mb-4">
                                <div
                                    class="inline-block w-full rounded-xl border border-white/60 px-4 py-2.5"
                                >
                                    <span
                                        class="text-[14px] font-extrabold uppercase tracking-widest text-white"
                                    >
                                        FASTTRACK – VIP LINE
                                    </span>
                                </div>
                            </div>

                            <p
                                class="relative text-[14px] leading-[1.6] text-white/90 mb-5"
                            >
                                Pendirian Badan Usaha Selesai dalam<br />1
                                (Satu) Hari
                            </p>
                            <a
                                :href="buildWhatsappLink(product.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20"
                            >
                                <img
                                    src="/icons/ft-wa.svg"
                                    class="mt-0.5 h-5 w-5 flex-shrink-0"
                                    alt="wa"
                                />
                                Pesan Layanan Sekarang
                            </a>

                            <div
                                class="relative mt-3 text-[11px] text-white/60"
                            >
                                * (S&amp;K BERLAKU)
                            </div>
                        </div>

                        <!-- Price Card -->
                        <div
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5"
                        >
                            <div
                                class="mb-4 flex items-center justify-between rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] px-3 py-2.5"
                            >
                                <span class="text-[13px] text-[#1A1B18]">{{
                                    product.name
                                }}</span>
                                <svg
                                    class="h-4 w-4 text-[#686964]"
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
                            </div>
                            <div class="text-[12px] text-[#686964] mb-1">
                                Estimasi total biaya
                            </div>
                            <div
                                class="text-[32px] font-bold leading-none text-primary mb-1"
                            >
                                {{ product.price_label }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">
                                *Harga final dikonfirmasi setelah konsultasi
                            </div>
                            <a
                                :href="buildWhatsappLink(product.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors"
                            >
                                <img
                                    src="/icons/ft-wa.svg"
                                    class="mt-0.5 h-6 w-6 flex-shrink-0"
                                    alt="wa"
                                />
                                Konsultasi Gratis via Whatsapp
                            </a>
                            <ul class="mt-4 space-y-2">
                                <li
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <img
                                        src="/icons/ft-done.svg"
                                        class="mt-0.5 h-4 w-4 flex-shrink-0"
                                        alt="done"
                                    />
                                    Konsultasi pertama gratis
                                </li>
                                <li
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <img
                                        src="/icons/ft-done.svg"
                                        class="mt-0.5 h-4 w-4 flex-shrink-0"
                                        alt="done"
                                    />
                                    Harga transparan, tanpa biaya tersembunyi
                                </li>
                                <li
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <img
                                        src="/icons/ft-done.svg"
                                        class="mt-0.5 h-4 w-4 flex-shrink-0"
                                        alt="done"
                                    />
                                    Tim berpengalaman 18+ tahun
                                </li>
                                <li
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <img
                                        src="/icons/ft-done.svg"
                                        class="mt-0.5 h-4 w-4 flex-shrink-0"
                                        alt="done"
                                    />
                                    Update proses berkala via WhatsApp
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <FooterCTA
            title="Tidak Menemukan Layanan yang Anda Cari?"
            description="Tim kami siap membantu Anda menemukan solusi yang tepat<br class='hidden sm:block' /> untuk kebutuhan legalitas bisnis Anda."
            :whatsapp-link="buildWhatsappLink('layanan yang tidak terdaftar')"
        />
    </MainLayout>
</template>
