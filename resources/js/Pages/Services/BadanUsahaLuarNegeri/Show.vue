<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { ref, computed } from "vue";
import { useI18n } from "vue-i18n";

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

// Semua konten utama ada di localizedProduct.baru — di-localize sesuai locale aktif
const localizedProduct = computed(() => {
    const p = props.product;
    if (!p) return p;

    const baru = p.baru ?? {};
    const paketHarga = baru.paket_harga ?? null;

    return {
        ...p,
        name: pick(p.name),
        tag: pick(p.tag),
        duration: pick(p.duration),
        excerpt: pick(p.excerpt),
        faq: pick(p.faq) ?? [],
        baru: {
            ...baru,
            penjelasan_umum: pick(baru.penjelasan_umum) ?? [],
            kriteria: pick(baru.kriteria) ?? [],
            persyaratan: pick(baru.persyaratan) ?? [],
            dasar_hukum: pick(baru.dasar_hukum) ?? [],
            paket_harga: paketHarga
                ? {
                      ...paketHarga,
                      nama_paket: pick(paketHarga.nama_paket),
                      bonus: pick(paketHarga.bonus),
                      dokumen_legalitas: pick(paketHarga.dokumen_legalitas) ?? [],
                      termasuk: pick(paketHarga.termasuk) ?? [],
                  }
                : null,
        },
    };
});

// Semua konten utama ada di localizedProduct.baru
const currentData = computed(() => localizedProduct.value?.baru ?? {});

// Persyaratan ada di localizedProduct.baru.persyaratan
const currentRequirements = computed(
    () => localizedProduct.value?.baru?.persyaratan ?? [],
);

// Dasar hukum ada di localizedProduct.baru.dasar_hukum
const currentDasarHukum = computed(
    () => localizedProduct.value?.baru?.dasar_hukum ?? [],
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
                        >
                            {{
                                t(
                                    "services.badanUsahaLuarNegeriDetail.breadcrumb.layanan",
                                )
                            }}
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
                            href="/badan-usaha-luar-negeri"
                            class="text-sm font-medium text-[#9e1f16] hover:underline"
                        >
                            {{
                                t(
                                    "services.badanUsahaLuarNegeriDetail.breadcrumb.current",
                                )
                            }}
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
                        <span class="text-sm font-medium text-[#9e1f16]">{{
                            localizedProduct.name
                        }}</span>
                    </div>
                </nav>

                <!-- Center: Heading -->
                <div class="flex items-center gap-5">
                    <div
                        class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white shadow-md"
                    >
                        <img
                            src="/icons/ft-persons.svg"
                            class="w-9 h-9"
                            alt=""
                        />
                    </div>
                    <h1
                        class="text-3xl font-extrabold leading-tight text-white sm:text-2xl lg:text-3xl max-w-[800px] line-clamp-2"
                    >
                        {{ localizedProduct.name }}
                    </h1>
                </div>

                <!-- Bottom: Back button -->
                <div>
                    <a
                        href="/badan-usaha-luar-negeri"
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
                        {{ t("services.badanUsahaLuarNegeriDetail.back") }}
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
                            v-if="currentData.penjelasan_umum?.length"
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
                                    {{
                                        t(
                                            "services.badanUsahaLuarNegeriDetail.sections.penjelasan",
                                        )
                                    }}
                                </h2>
                            </div>
                            <div class="space-y-4">
                                <p
                                    v-for="(paragraph, index) in currentData.penjelasan_umum"
                                    :key="`penjelasan-${index}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify"
                                >
                                    {{ paragraph }}
                                </p>
                            </div>
                        </div>

                        <!-- 2. Kriteria -->
                        <div
                            v-if="currentData.kriteria?.length"
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
                                    Kriteria
                                </h2>
                            </div>

                            <ol class="space-y-5">
                                <li
                                    v-for="(item, kIndex) in currentData.kriteria"
                                    :key="`kriteria-${kIndex}`"
                                >
                                    <div class="flex gap-2.5">
                                        <span
                                            class="flex-shrink-0 text-[13px] font-semibold text-[#1A1B18]"
                                        >
                                            {{ kIndex + 1 }}.
                                        </span>
                                        <span
                                            class="text-[13px] font-semibold leading-[1.6] text-[#1A1B18]"
                                        >
                                            {{ item.text }}
                                        </span>
                                    </div>

                                    <ul
                                        v-if="item.items?.length"
                                        class="mt-2 ml-6 space-y-1.5"
                                    >
                                        <li
                                            v-for="(point, iIndex) in item.items"
                                            :key="`kriteria-item-${kIndex}-${iIndex}`"
                                            class="flex gap-2 text-[13px] leading-[1.6] text-[#3D3D3A]"
                                        >
                                            <span class="flex-shrink-0">&bull;</span>
                                            <span>{{ point }}</span>
                                        </li>
                                    </ul>

                                    <div v-if="item.note" class="mt-3 ml-6">
                                        <p
                                            class="text-[13px] leading-[1.6] text-[#3D3D3A] mb-1.5"
                                        >
                                            {{ item.note.label }}
                                        </p>
                                        <ul class="space-y-1.5">
                                            <li
                                                v-for="(point, nIndex) in item.note.items"
                                                :key="`kriteria-note-${kIndex}-${nIndex}`"
                                                class="flex gap-2 text-[13px] leading-[1.6] text-[#3D3D3A]"
                                            >
                                                <span class="flex-shrink-0">&bull;</span>
                                                <span>{{ point }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ol>
                        </div>

                        <!-- 3. Paket & Harga -->
                        <div
                            v-if="currentData.paket_harga"
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
                                    {{
                                        t(
                                            "services.badanUsahaLuarNegeriDetail.sections.paket",
                                        )
                                    }}
                                </h2>
                            </div>

                            <div
                                class="rounded-2xl border border-[#E8E8E6] overflow-hidden"
                            >
                                <!-- Harga -->
                                <div class="p-5 sm:p-6">
                                    <p
                                        class="text-[13px] font-bold uppercase tracking-wide text-[#1A1B18]"
                                    >
                                        {{ currentData.paket_harga.nama_paket }}
                                    </p>
                                    <p class="text-[12px] text-[#686964] mt-3">
                                        {{
                                            t(
                                                "services.badanUsahaLuarNegeriDetail.plans.mulai_dari",
                                            )
                                        }}
                                    </p>
                                    <p
                                        class="text-[24px] font-bold text-primary leading-tight"
                                    >
                                        {{ currentData.paket_harga.harga }}
                                    </p>
                                    <div
                                        v-if="currentData.paket_harga.bonus"
                                        class="flex items-start gap-2 mt-3"
                                    >
                                        <img
                                            src="/icons/ft-done.svg"
                                            class="mt-0.5 h-3.5 w-3.5 flex-shrink-0"
                                            alt=""
                                        />
                                        <span
                                            class="text-[12px] leading-[1.5] text-[#686964]"
                                        >
                                            {{ currentData.paket_harga.bonus }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Rincian paket -->
                                <div
                                    class="border-t border-[#E8E8E6] p-5 sm:p-6 space-y-5"
                                >
                                    <div
                                        v-if="currentData.paket_harga.dokumen_legalitas?.length"
                                    >
                                        <p
                                            class="text-[13px] font-bold text-[#1A1B18] mb-3"
                                        >
                                            {{
                                                t(
                                                    "services.badanUsahaLuarNegeriDetail.plans.dokumen_legalitas",
                                                )
                                            }}
                                        </p>
                                        <ul class="space-y-2.5">
                                            <li
                                                v-for="(item, index) in currentData.paket_harga.dokumen_legalitas"
                                                :key="`legalitas-${index}`"
                                                class="flex items-start gap-2.5"
                                            >
                                                <img
                                                    src="/icons/ft-done.svg"
                                                    class="mt-0.5 h-4 w-4 flex-shrink-0"
                                                    alt="done"
                                                />
                                                <span
                                                    class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                    >{{ item }}</span
                                                >
                                            </li>
                                        </ul>
                                    </div>

                                    <div
                                        v-if="currentData.paket_harga.termasuk?.length"
                                    >
                                        <p
                                            class="text-[13px] font-bold text-[#1A1B18] mb-3"
                                        >
                                            {{
                                                t(
                                                    "services.badanUsahaLuarNegeriDetail.plans.termasuk",
                                                )
                                            }}
                                        </p>
                                        <ul class="space-y-2.5">
                                            <li
                                                v-for="(item, index) in currentData.paket_harga.termasuk"
                                                :key="`termasuk-${index}`"
                                                class="flex items-start gap-2.5"
                                            >
                                                <img
                                                    src="/icons/ft-done.svg"
                                                    class="mt-0.5 h-4 w-4 flex-shrink-0"
                                                    alt="done"
                                                />
                                                <span
                                                    class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                    >{{ item }}</span
                                                >
                                            </li>
                                        </ul>
                                    </div>
                                    <a
                                        :href="buildWhatsappLink(localizedProduct.name)"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="flex items-center justify-center gap-1.5 rounded-xl border border-primary px-4 py-3 text-[13px] font-semibold text-primary hover:bg-primary/5 transition-colors"
                                    >
                                        {{
                                            t(
                                                "services.badanUsahaLuarNegeriDetail.plans.pesan",
                                            )
                                        }}
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

                        <!-- 4. Dokumen dan Informasi yang Diperlukan (Accordion) -->
                        <div
                            v-if="currentRequirements.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white overflow-hidden"
                        >
                            <button
                                @click="docsOpen = !docsOpen"
                                class="w-full flex items-center justify-between p-6 sm:p-8 text-left"
                            >
                                <div class="flex items-center gap-3">
                                    <img
                                        src="/icons/ic-menu-arrow.svg"
                                        class="w-6 h-6"
                                        alt=""
                                    />
                                    <h2
                                        class="text-[15px] font-bold uppercase tracking-widest text-black"
                                    >
                                        {{
                                            t(
                                                "services.badanUsahaLuarNegeriDetail.sections.dokumen",
                                            )
                                        }}
                                    </h2>
                                </div>
                                <svg
                                    class="h-5 w-5 text-[#686964] flex-shrink-0 transition-transform duration-200"
                                    :class="docsOpen ? 'rotate-180' : ''"
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
                            </button>

                            <div
                                v-show="docsOpen"
                                class="px-6 sm:px-8 pb-6 sm:pb-8 border-t border-[#E8E8E6]"
                            >
                                <ol class="mt-5 space-y-4">
                                    <li
                                        v-for="(req, index) in currentRequirements"
                                        :key="`doc-${index}`"
                                        class="flex gap-4"
                                    >
                                        <!-- Nomor -->
                                        <span
                                            class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary text-white text-[12px] font-bold"
                                        >
                                            {{ index + 1 }}
                                        </span>

                                        <div class="pt-0.5 flex-1">
                                            <!-- Title -->
                                            <p
                                                class="text-[14px] font-semibold text-black leading-snug mb-1"
                                            >
                                                {{ req.title }}
                                            </p>
                                            <!-- Description -->
                                            <p
                                                v-if="req.description"
                                                class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                v-html="parseBold(req.description)"
                                            ></p>

                                            <!-- Notes: string biasa -->
                                            <ul
                                                v-if="req.notes && typeof req.notes[0] === 'string'"
                                                class="mt-1 space-y-0.5 list-disc list-inside"
                                            >
                                                <li
                                                    v-for="(note, nIndex) in req.notes"
                                                    :key="`note-${nIndex}`"
                                                    class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                >
                                                    {{ note }}
                                                </li>
                                            </ul>

                                            <!-- Notes: object { bold, detail } -->
                                            <ul
                                                v-if="req.notes && typeof req.notes[0] === 'object'"
                                                class="mt-1.5 space-y-2 list-disc list-inside"
                                            >
                                                <li
                                                    v-for="(note, nIndex) in req.notes"
                                                    :key="`note-obj-${nIndex}`"
                                                    class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                >
                                                    <span class="font-semibold text-black">{{ note.bold }}</span>
                                                    <p
                                                        v-if="note.detail"
                                                        class="ml-4 mt-0.5 text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                    >
                                                        {{ note.detail }}
                                                    </p>
                                                </li>
                                            </ul>

                                            <!-- Sections: { label, groups } -->
                                            <div
                                                v-if="req.sections"
                                                class="mt-1 space-y-3"
                                            >
                                                <div
                                                    v-for="(section, sIndex) in req.sections"
                                                    :key="`section-${sIndex}`"
                                                >
                                                    <p
                                                        class="text-[13px] font-semibold text-[#1A1B18] mb-1"
                                                    >
                                                        {{ section.label }}
                                                    </p>
                                                    <div class="space-y-1.5">
                                                        <div
                                                            v-for="(group, gIndex) in section.groups"
                                                            :key="`sg-${gIndex}`"
                                                        >
                                                            <p class="text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                                {{ group.label }}
                                                            </p>
                                                            <p
                                                                v-if="group.description"
                                                                class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                            >
                                                                {{ group.description }}
                                                            </p>
                                                            <ul
                                                                v-if="group.notes"
                                                                class="mt-0.5 space-y-0.5 list-disc list-inside"
                                                            >
                                                                <li
                                                                    v-for="(note, nIndex) in group.notes"
                                                                    :key="`gnote-${nIndex}`"
                                                                    class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                                >
                                                                    {{ note }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Groups langsung (tanpa sections) -->
                                            <div
                                                v-if="req.groups && !req.sections"
                                                class="mt-1 space-y-2"
                                            >
                                                <div
                                                    v-for="(group, gIndex) in req.groups"
                                                    :key="`group-${gIndex}`"
                                                >
                                                    <p class="text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                        {{ group.label }}
                                                    </p>
                                                    <p
                                                        v-if="group.description"
                                                        class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                    >
                                                        {{ group.description }}
                                                    </p>
                                                    <ul
                                                        v-if="group.items"
                                                        class="mt-0.5 space-y-0.5 list-disc list-inside"
                                                    >
                                                        <li
                                                            v-for="(item, iIndex) in group.items"
                                                            :key="`gitem-${gIndex}-${iIndex}`"
                                                            class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                        >
                                                            {{ item }}
                                                        </li>
                                                    </ul>
                                                    <ul
                                                        v-if="group.notes"
                                                        class="mt-0.5 space-y-0.5 list-disc list-inside"
                                                    >
                                                        <li
                                                            v-for="(note, nIndex) in group.notes"
                                                            :key="`gnote-${nIndex}`"
                                                            class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                        >
                                                            {{ note }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ol>
                            </div>
                        </div>

                        <!-- 5. Dasar Hukum (Accordion) -->
                        <div
                            v-if="currentDasarHukum.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white overflow-hidden"
                        >
                            <button
                                @click="dasarHukumOpen = !dasarHukumOpen"
                                class="w-full flex items-center justify-between p-6 sm:p-8 text-left"
                            >
                                <div class="flex items-center gap-3">
                                    <img
                                        src="/icons/ic-menu-arrow.svg"
                                        class="w-6 h-6"
                                        alt=""
                                    />
                                    <h2
                                        class="text-[15px] font-bold uppercase tracking-widest text-black"
                                    >
                                        {{
                                            t(
                                                "services.badanUsahaLuarNegeriDetail.sections.dasar_hukum",
                                            )
                                        }}
                                    </h2>
                                </div>
                                <svg
                                    class="h-5 w-5 text-[#686964] flex-shrink-0 transition-transform duration-200"
                                    :class="dasarHukumOpen ? 'rotate-180' : ''"
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
                            </button>

                            <div
                                v-show="dasarHukumOpen"
                                class="px-6 sm:px-8 pb-6 sm:pb-8 border-t border-[#E8E8E6]"
                            >
                                <ul class="mt-5 space-y-4">
                                    <li
                                        v-for="(hukum, hi) in currentDasarHukum"
                                        :key="`hukum-${hi}`"
                                        class="flex items-start gap-4"
                                    >
                                        <span
                                            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-[#ddffe3]"
                                        >
                                            <img
                                                src="/icons/ft-save.svg"
                                                class="w-4 h-4"
                                                alt=""
                                            />
                                        </span>
                                        <span
                                            class="text-[13px] leading-[1.7] text-[#3D3D3A] text-justify"
                                            >{{ hukum }}</span
                                        >
                                    </li>
                                </ul>
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
                                        {{
                                            t(
                                                "services.badanUsahaLuarNegeriDetail.sidebar.vip_title",
                                            )
                                        }}
                                    </span>
                                </div>
                            </div>

                            <p
                                class="relative text-[14px] leading-[1.6] text-white/90 mb-5"
                            >
                                {{
                                    t(
                                        "services.badanUsahaLuarNegeriDetail.sidebar.vip_desc",
                                    )
                                }}
                            </p>
                            <a
                                :href="buildWhatsappLink(localizedProduct.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20"
                            >
                                <img
                                    src="/icons/ft-wa.svg"
                                    class="mt-0.5 h-5 w-5 flex-shrink-0"
                                    alt="wa"
                                />
                                {{
                                    t(
                                        "services.badanUsahaLuarNegeriDetail.sidebar.vip_cta",
                                    )
                                }}
                            </a>

                            <div
                                class="relative mt-3 text-[11px] text-white/60"
                            >
                                {{
                                    t(
                                        "services.badanUsahaLuarNegeriDetail.sidebar.vip_note",
                                    )
                                }}
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
                                    localizedProduct.name
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
                                {{
                                    t(
                                        "services.badanUsahaLuarNegeriDetail.sidebar.price_label",
                                    )
                                }}
                            </div>
                            <div
                                class="text-[32px] font-bold leading-none text-primary mb-1"
                            >
                                {{ localizedProduct.price_label }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">
                                {{
                                    t(
                                        "services.badanUsahaLuarNegeriDetail.sidebar.price_note",
                                    )
                                }}
                            </div>
                            <a
                                :href="buildWhatsappLink(localizedProduct.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors"
                            >
                                <img
                                    src="/icons/ft-wa.svg"
                                    class="mt-0.5 h-6 w-6 flex-shrink-0"
                                    alt="wa"
                                />
                                {{
                                    t(
                                        "services.badanUsahaLuarNegeriDetail.sidebar.konsultasi_cta",
                                    )
                                }}
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

                        <!-- Layanan Terkait -->
                        <div
                            v-if="relatedProducts.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5"
                        >
                            <h3
                                class="text-[13px] font-bold text-[#1A1B18] mb-4"
                            >
                                {{
                                    t(
                                        "services.badanUsahaLuarNegeriDetail.sidebar.related_title",
                                    )
                                }}
                            </h3>
                            <div class="flex flex-col gap-3">
                                <a
                                    v-for="(related, index) in relatedProducts.slice(0, 3)"
                                    :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex flex-col gap-2 rounded-xl border border-[#E8E8E6] bg-white p-4 hover:border-primary/30 hover:shadow-sm transition-all"
                                >
                                    <div
                                        class="text-[14px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors"
                                    >
                                        {{ pick(related.name) }}
                                    </div>
                                    <p
                                        class="text-[12px] leading-[1.6] text-[#686964] line-clamp-3"
                                    >
                                        {{ pick(related.excerpt) ?? pick(related.description) }}
                                    </p>
                                    <hr class="border-[#E8E8E6]" />
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div
                                                class="text-[11px] text-[#686964] mb-0.5"
                                            >
                                                {{
                                                    t(
                                                        "services.badanUsahaLuarNegeriDetail.sidebar.related_from",
                                                    )
                                                }}
                                            </div>
                                            <div
                                                class="text-[18px] font-bold text-primary leading-none"
                                            >
                                                {{ related.price_label }}
                                            </div>
                                        </div>
                                        <span
                                            class="text-[11px] font-medium text-[#3D3D3A] border border-[#E8E8E6] rounded-md px-2 py-1"
                                        >
                                            {{
                                                related.baru?.paket_harga
                                                    ? 1
                                                    : 0
                                            }}
                                            {{
                                                t(
                                                    "services.badanUsahaLuarNegeriDetail.sidebar.related_packages",
                                                )
                                            }}
                                        </span>
                                    </div>
                                    <div
                                        class="mt-1 flex items-center justify-center gap-2 rounded-xl border border-primary py-2.5 text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors"
                                    >
                                        {{
                                            t(
                                                "services.badanUsahaLuarNegeriDetail.sidebar.related_cta",
                                            )
                                        }}
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
            :title="t('services.badanUsahaLuarNegeriDetail.footer.title')"
            :description="t('services.badanUsahaLuarNegeriDetail.footer.desc')"
            :button-text="t('services.badanUsahaLuarNegeriDetail.footer.cta')"
            :whatsapp-link="buildWhatsappLink('layanan yang tidak terdaftar')"
        />
    </MainLayout>
</template>