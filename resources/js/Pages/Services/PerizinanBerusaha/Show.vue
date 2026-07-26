<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { ref, computed, watch } from "vue";
import { useWhatsapp } from "@/Composables/useWhatsapp.js";
import { useI18n } from "vue-i18n";

const { t, locale } = useI18n();

const props = defineProps({
    product: { type: Object, required: true },
    relatedProducts: { type: Array, default: () => [] },
    relatedTitle: { type: String, default: "Layanan Lainnya" },
});

// Icon & path tidak perlu ditranslasi, tetap di sini
const itemMeta = [
    { icon: "/icons/layanan/kesesuaian-kegiatan-pemanfaatan-ruang.png", path: "/perizinan-berusaha" },
    { icon: "/icons/layanan/perizinan-berusaha-sertifikat-izin.png", path: "/perizinan-berusaha" },
    { icon: "/icons/layanan/perizinan-berusaha-menunjang-kegiatan.png", path: "/perizinan-berusaha" },
];

const { buildWhatsappLink } = useWhatsapp("visa");

// Recursively resolve setiap field translatable {id,en,zh} sesuai locale aktif
const pick = (obj) => {
    if (obj === null || obj === undefined) return obj;
    if (Array.isArray(obj)) return obj.map(pick);
    if (typeof obj === "object") {
        const keys = Object.keys(obj);
        if (
            keys.length === 3 &&
            keys.includes("id") &&
            keys.includes("en") &&
            keys.includes("zh")
        ) {
            return obj[locale.value] ?? obj.id;
        }
        const result = {};
        for (const k in obj) result[k] = pick(obj[k]);
        return result;
    }
    return obj;
};

const localizedProduct = computed(() => pick(props.product));
const localizedRelatedProducts = computed(() =>
    props.relatedProducts.map(pick),
);

const activeIndex = ref(0);
// Dasar Hukum & Dokumen Informasi bisa terbuka bersamaan, jadi disimpan
// sebagai object per-id, bukan satu ref tunggal.
const openSections = ref({ "dasar-hukum": true, "dokumen-informasi": true });
const activeBiayaTahun = ref(0);

const currentItem = computed(
    () => localizedProduct.value.jenis_layanan?.[activeIndex.value] ?? null,
);

// Kalau jenis_layanan cuma 3 (atau kurang), tampilkan kartu lebih besar & full-width
// (3 kolom), bukan grid rapat 4 kolom yang dipakai saat item-nya banyak.
const isLargeJenisLayananCard = computed(
    () => (localizedProduct.value.jenis_layanan?.length ?? 0) <= 3,
);
const jenisLayananGridClass = computed(() =>
    isLargeJenisLayananCard.value
        ? "grid-cols-1 sm:grid-cols-2 lg:grid-cols-3"
        : "grid-cols-2 sm:grid-cols-3 lg:grid-cols-4",
);

// Kalau produk TIDAK punya jenis_layanan (mis. "Perizinan Berusaha"),
// semua section di bawah ini pakai data langsung dari level product.
const activeContent = computed(
    () => currentItem.value ?? localizedProduct.value,
);

// nama/kode item aktif dipakai untuk sidebar & link WA
const activeNama = computed(
    () => currentItem.value?.nama ?? localizedProduct.value.name,
);
const activeKode = computed(() => currentItem.value?.kode ?? "");

const toggleSection = (id) => {
    openSections.value[id] = !openSections.value[id];
};

watch(activeIndex, () => {
    openSections.value = { "dasar-hukum": true, "dokumen-informasi": true };
    activeBiayaTahun.value = 0;
});

const rincianBiaya = computed(() => {
    const rincian = activeContent.value?.rincian_biaya;
    if (!rincian) return null;

    if (rincian.tabs?.length) {
        return {
            label:
                rincian.tabs[activeBiayaTahun.value]?.penanganan_label ??
                "Biaya Penanganan",
            harga:
                rincian.tabs[activeBiayaTahun.value]?.biaya_penanganan ??
                "Hubungi Kami",
            tabs: rincian.tabs,
        };
    }

    return {
        label: rincian.label ?? "Biaya Penanganan",
        harga: rincian.biaya_penanganan ?? "Hubungi Kami",
        tabs: null,
    };
});

// "Paket & Harga" - kartu paket yang lebih lengkap (harga, dokumen legalitas, termasuk).
// Kalau item punya `paket_harga`, section ini dipakai MENGGANTIKAN bar "Biaya Layanan" biasa.
const paketHarga = computed(() => activeContent.value?.paket_harga ?? null);

// "Sektor Perizinan" - list angka 2 kolom (mis. produk Perizinan Berusaha)
const sektorPerizinan = computed(
    () => activeContent.value?.sektor_perizinan ?? [],
);

// "Mengapa Menggunakan Layanan Kami" - checklist 2 kolom
const mengapaKami = computed(() => activeContent.value?.mengapa_kami ?? []);

// "Dokumen dan Informasi yang Diperlukan" - accordion bernomor
const dokumenDibutuhkan = computed(
    () => activeContent.value?.dokumen_dibutuhkan ?? [],
);
</script>

<template>
    <MainLayout>
        <!-- Hero -->
        <section
            class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px] bg-[#9e1f16]"
        >
            <img
                src="/icons/left-arrow.svg"
                class="absolute right-0 -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block"
                alt=""
            />
            <div
                class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]"
            >
                <nav aria-label="Breadcrumb">
                    <div
                        class="hidden sm:inline-flex items-center gap-2 rounded-md bg-white px-4 py-2"
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
                                    "services.perizinanBerusahaDetail.breadcrumb.layanan",
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
                            href="/perizinan-berusaha"
                            class="text-sm font-medium text-[#9e1f16] hover:underline"
                        >
                            {{
                                t(
                                    "services.perizinanBerusahaDetail.breadcrumb.current",
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
                            :src="localizedProduct.icon"
                            class="w-9 h-9"
                            style="
                                filter: brightness(0) saturate(100%) invert(14%)
                                    sepia(82%) saturate(4150%)
                                    hue-rotate(352deg) brightness(91%)
                                    contrast(93%);
                            "
                            alt=""
                        />
                    </div>
                    <h1
                        class="text-3xl font-extrabold leading-tight text-white sm:text-4xl lg:text-5xl max-w-[800px] line-clamp-2"
                    >
                        {{ localizedProduct.name }}
                    </h1>
                </div>
                <div>
                    <a
                        href="/perizinan-berusaha"
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
                        {{ t("services.perizinanBerusahaDetail.back") }}
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT -->
        <section class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- ===== FULL WIDTH: Penjelasan Umum ===== -->
                <div
                    v-if="localizedProduct.penjelasan_umum?.length"
                    class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8 mb-5"
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
                                    "services.perizinanBerusahaDetail.sections.penjelasan",
                                )
                            }}
                        </h2>
                    </div>
                    <div class="space-y-4">
                        <p
                            v-for="(p, i) in localizedProduct.penjelasan_umum"
                            :key="`pu-${i}`"
                            class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify"
                        >
                            {{ p }}
                        </p>
                    </div>
                </div>

                <!-- ===== FULL WIDTH: Pilih Jenis Layanan (hanya tampil jika produk punya jenis_layanan) ===== -->
                <div
                    v-if="localizedProduct.jenis_layanan?.length"
                    class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8 mb-5"
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
                                    "services.perizinanBerusahaDetail.sections.jenis_layanan",
                                )
                            }}
                        </h2>
                    </div>
                    <div class="grid gap-4" :class="jenisLayananGridClass">
                        <button
                            v-for="(item, i) in localizedProduct.jenis_layanan"
                            :key="`idx-${i}`"
                            @click="activeIndex = i"
                            class="text-left rounded-2xl transition-all flex flex-col"
                            :class="[
                                isLargeJenisLayananCard ? 'p-6 sm:p-7' : 'p-5',
                                activeIndex === i
                                    ? 'bg-primary text-white shadow-lg'
                                    : 'border border-[#E8E8E6] bg-white text-[#1A1B18] hover:border-primary/40 hover:shadow-sm',
                            ]"
                        >
                            <!-- <div
                                class="flex items-center justify-center rounded-xl mb-4"
                                :class="[
                                    isLargeJenisLayananCard
                                        ? 'h-14 w-14'
                                        : 'h-12 w-12',
                                    activeIndex === i
                                        ? 'bg-white'
                                        : 'bg-[#F7F7F5]',
                                ]"
                            >
                                <img
                                    src="/icons/ft-persons.svg"
                                    :class="[
                                        isLargeJenisLayananCard
                                            ? 'w-7 h-7'
                                            : 'w-6 h-6',
                                        activeIndex === i ? '' : 'opacity-70',
                                    ]"
                                    :style="
                                        activeIndex === i
                                            ? 'filter: invert(20%) sepia(60%) saturate(2000%) hue-rotate(340deg);'
                                            : ''
                                    "
                                    alt=""
                                />
                            </div> -->

                            <p
                                class="font-bold leading-snug mb-2"
                                :class="
                                    isLargeJenisLayananCard
                                        ? 'text-[16px]'
                                        : 'text-[13px] font-semibold'
                                "
                            >
                                {{ item.nama }}
                            </p>

                            <p
                                class="leading-[1.6] mb-4 flex-1"
                                :class="[
                                    isLargeJenisLayananCard
                                        ? 'text-[13px] sm:text-[14px]'
                                        : 'text-[12px]',
                                    activeIndex === i
                                        ? 'text-white/85'
                                        : 'text-[#686964]',
                                ]"
                            >
                                {{ item.excerpt }}
                            </p>

                            <hr
                                class="mb-3"
                                :class="
                                    activeIndex === i
                                        ? 'border-white/25'
                                        : 'border-[#E8E8E6]'
                                "
                            />

                            <p
                                class="mb-0.5"
                                :class="[
                                    isLargeJenisLayananCard
                                        ? 'text-[13px]'
                                        : 'text-[11px]',
                                    activeIndex === i
                                        ? 'text-white/70'
                                        : 'text-[#686964]',
                                ]"
                            >
                                Mulai dari
                            </p>
                            <p
                                class="font-bold leading-tight"
                                :class="[
                                    isLargeJenisLayananCard
                                        ? 'text-[24px] sm:text-[26px]'
                                        : 'text-[18px]',
                                    activeIndex === i
                                        ? 'text-white'
                                        : 'text-primary',
                                ]"
                            >
                                {{ item.harga }}
                            </p>
                        </button>
                    </div>
                </div>

                <!-- ===== GRID 2 KOLOM: mulai dari Penjelasan Layanan ===== -->
                <div
                    class="grid gap-8 lg:grid-cols-[1fr_300px] xl:grid-cols-[1fr_320px] min-w-0"
                >
                    <!-- ===== KIRI ===== -->
                    <div class="flex flex-col gap-5 min-w-0">
                        <!-- Penjelasan Layanan (currentItem, atau fallback ke product jika tanpa jenis_layanan) -->
                        <div
                            v-if="activeContent?.penjelasan_layanan?.length"
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
                                            "services.perizinanBerusahaDetail.sections.penjelasan_layanan",
                                        )
                                    }}
                                </h2>
                            </div>
                            <div class="space-y-4">
                                <p
                                    v-for="(
                                        p, i
                                    ) in activeContent.penjelasan_layanan"
                                    :key="`pl-${i}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify"
                                >
                                    {{ p }}
                                </p>
                            </div>

                            <div
                                v-if="activeContent.sub_layanan?.length"
                                class="mt-6 space-y-5"
                            >
                                <div
                                    v-for="(
                                        sub, si
                                    ) in activeContent.sub_layanan"
                                    :key="`sub-${si}`"
                                >
                                    <p
                                        class="text-[13px] font-bold text-[#1A1B18] mb-1.5"
                                    >
                                        {{ sub.label }}
                                    </p>
                                    <p
                                        class="text-[13px] leading-[1.7] text-[#3D3D3A] text-justify mb-2"
                                    >
                                        {{ sub.desc }}
                                    </p>
                                    <ol
                                        v-if="sub.steps?.length"
                                        class="ml-5 list-decimal space-y-1"
                                    >
                                        <li
                                            v-for="(step, sti) in sub.steps"
                                            :key="`step-${si}-${sti}`"
                                            class="text-[13px] leading-[1.7] text-[#3D3D3A]"
                                        >
                                            {{ step }}
                                        </li>
                                    </ol>
                                </div>
                            </div>

                            <div
                                v-if="activeContent.penjelasan_penutup?.length"
                                class="mt-6 space-y-3"
                            >
                                <p
                                    v-for="(
                                        p, i
                                    ) in activeContent.penjelasan_penutup"
                                    :key="`pp-${i}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify"
                                >
                                    {{ p }}
                                </p>
                            </div>
                        </div>

                        <!-- Sektor Perizinan (list angka 2 kolom, khusus produk seperti Perizinan Berusaha) -->
                        <div
                            v-if="sektorPerizinan.length"
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
                                            "services.perizinanBerusahaDetail.sections.sektor_izin",
                                        )
                                    }}
                                </h2>
                            </div>
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 sm:grid-rows-6 sm:grid-flow-col gap-x-8 gap-y-4"
                            >
                                <div
                                    v-for="(sektor, i) in sektorPerizinan"
                                    :key="`sektor-${i}`"
                                    class="flex items-center gap-4"
                                >
                                    <span
                                        class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-primary text-white text-[13px] font-bold"
                                    >
                                        {{ i + 1 }}
                                    </span>
                                    <span
                                        class="text-[13px] font-semibold text-[#1A1B18]"
                                        >{{ sektor }}</span
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Paket & Harga (kartu lengkap: harga, dokumen legalitas, termasuk) -->
                        <div
                            v-if="paketHarga"
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
                                            "services.perizinanBerusahaDetail.sections.paket",
                                        )
                                    }}
                                </h2>
                            </div>

                            <div class="rounded-xl border border-[#E8E8E6] p-5">
                                <p
                                    class="text-[13px] font-bold uppercase text-[#1A1B18] mb-3"
                                >
                                    {{ activeNama }}
                                </p>

                                <p class="text-[12px] text-[#686964] mb-1">
                                    Mulai dari
                                </p>
                                <p
                                    class="text-[24px] font-bold text-primary leading-tight mb-3"
                                >
                                    {{ paketHarga.harga }}
                                </p>

                                <div
                                    v-if="paketHarga.benefit"
                                    class="flex items-center gap-2 mb-5"
                                >
                                    <svg
                                        class="w-4 h-4 flex-shrink-0 text-[#22A94D]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="3"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                    <span
                                        class="text-[13px] font-medium text-[#1A1B18]"
                                        >{{ paketHarga.benefit }}</span
                                    >
                                </div>

                                <div
                                    v-if="paketHarga.dokumen_legalitas?.length"
                                    class="mb-5"
                                >
                                    <p
                                        class="text-[13px] font-bold text-[#1A1B18] mb-2"
                                    >
                                        {{
                                        t(
                                            "services.perizinanBerusahaDetail.sections.dokumen_legalitas",
                                        )
                                    }}
                                    </p>
                                    <div class="space-y-1.5">
                                        <div
                                            v-for="(
                                                dok, i
                                            ) in paketHarga.dokumen_legalitas"
                                            :key="`dok-legal-${i}`"
                                            class="flex items-center gap-2"
                                        >
                                            <svg
                                                class="w-4 h-4 flex-shrink-0 text-[#22A94D]"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="3"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7"
                                                />
                                            </svg>
                                            <span
                                                class="text-[13px] text-[#3D3D3A]"
                                                >{{ dok }}</span
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div
                                    v-if="paketHarga.termasuk?.length"
                                    class="mb-5"
                                >
                                    <p
                                        class="text-[13px] font-bold text-[#1A1B18] mb-2"
                                    >
                                        Termasuk
                                    </p>
                                    <div class="space-y-1.5">
                                        <div
                                            v-for="(
                                                item, i
                                            ) in paketHarga.termasuk"
                                            :key="`termasuk-${i}`"
                                            class="flex items-center gap-2"
                                        >
                                            <svg
                                                class="w-4 h-4 flex-shrink-0 text-[#22A94D]"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="3"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7"
                                                />
                                            </svg>
                                            <span
                                                class="text-[13px] text-[#3D3D3A]"
                                                >{{ item }}</span
                                            >
                                        </div>
                                    </div>
                                </div>

                                <a
                                    :href="
                                        buildWhatsappLink(
                                            `${activeKode} ${activeNama}`.trim(),
                                        )
                                    "
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary py-2.5 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors"
                                >
                                    Pesan Sekarang
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

                        <!-- Biaya Layanan (bar sederhana, hanya tampil jika produk TIDAK punya paket_harga) -->
                        <div
                            v-else-if="rincianBiaya"
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
                                            "services.perizinanBerusahaDetail.sections.biaya_layanan",
                                        )
                                    }}
                                </h2>
                            </div>

                            <div
                                v-if="rincianBiaya.tabs?.length"
                                class="flex flex-wrap gap-2 mb-4"
                            >
                                <button
                                    v-for="(tab, ti) in rincianBiaya.tabs"
                                    :key="`tab-${ti}`"
                                    @click="activeBiayaTahun = ti"
                                    class="rounded-lg px-3 py-1.5 text-[12px] font-semibold transition-colors"
                                    :class="
                                        activeBiayaTahun === ti
                                            ? 'bg-primary text-white'
                                            : 'border border-[#E8E8E6] text-[#686964] hover:border-primary/40'
                                    "
                                >
                                    {{ tab.tahun ?? `Tahun ${ti + 1}` }}
                                </button>
                            </div>

                            <div
                                class="flex items-center justify-between rounded-xl px-5 py-4"
                                style="
                                    background-image: url(&quot;/images/card-arrow-item-bg.png&quot;);
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                "
                            >
                                <div class="flex items-center gap-4 min-w-0">
                                    <div
                                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-white/20"
                                    >
                                        <img
                                            :src="localizedProduct.icon"
                                            class="w-5 h-5"
                                            alt=""
                                        />
                                    </div>
                                    <div class="min-w-0">
                                        <p
                                            class="text-[12px] text-white/80 truncate"
                                        >
                                            {{ activeNama }}
                                        </p>
                                        <p
                                            class="text-[20px] font-bold text-white leading-tight"
                                        >
                                            {{ rincianBiaya.harga }}
                                        </p>
                                    </div>
                                </div>
                                <a
                                    :href="
                                        buildWhatsappLink(
                                            localizedProduct.name,
                                            activeNama,
                                        )
                                    "
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex items-center gap-1.5 rounded-lg bg-white px-4 py-2 text-[12px] font-semibold text-primary whitespace-nowrap hover:bg-white/90 transition-colors"
                                >
                                    Hubungi Kami
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

                        <!-- Mengapa Menggunakan Layanan Kami (checklist 2 kolom) -->
                        <div
                            v-if="mengapaKami.length"
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
                                            "services.perizinanBerusahaDetail.sections.layanan_kami",
                                        )
                                    }}
                                </h2>
                            </div>
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 sm:grid-rows-3 sm:grid-flow-col gap-x-8 gap-y-4"
                            >
                                <div
                                    v-for="(poin, i) in mengapaKami"
                                    :key="`mengapa-${i}`"
                                    class="flex items-start gap-3"
                                >
                                    <span
                                        class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-[#ddffe3] mt-0.5"
                                    >
                                        <svg
                                            class="w-3.5 h-3.5 text-[#22A94D]"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="3"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>
                                    </span>
                                    <span
                                        class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                        >{{ poin }}</span
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Dokumen dan Informasi yang Diperlukan (accordion bernomor) -->
                        <div
                            v-if="dokumenDibutuhkan.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <button
                                @click="toggleSection('dokumen-informasi')"
                                class="w-full flex items-center justify-between gap-3 text-left"
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
                                            "services.perizinanBerusahaDetail.sections.dokumen_diperlukan",
                                        )
                                    }}
                                    </h2>
                                </div>
                                <svg
                                    class="h-5 w-5 flex-shrink-0 text-[#686964] transition-transform duration-200"
                                    :class="
                                        openSections['dokumen-informasi']
                                            ? 'rotate-180'
                                            : ''
                                    "
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
                            <ul
                                v-if="openSections['dokumen-informasi']"
                                class="mt-5 space-y-4"
                            >
                                <li
                                    v-for="(dok, i) in dokumenDibutuhkan"
                                    :key="`dok-${i}`"
                                    class="flex items-start gap-4"
                                >
                                    <span
                                        class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-primary text-white text-[13px] font-bold"
                                    >
                                        {{ i + 1 }}
                                    </span>
                                    <div>
                                        <p
                                            class="text-[13px] font-semibold leading-[1.7] text-[#1A1B18]"
                                        >
                                            {{ dok.text }}
                                        </p>
                                        <p
                                            v-if="dok.desc"
                                            class="text-[13px] leading-[1.7] text-[#686964] mt-1"
                                        >
                                            {{ dok.desc }}
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Dasar Hukum (accordion, default terbuka) -->
                        <div
                            v-if="activeContent?.dasar_hukum?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <button
                                @click="toggleSection('dasar-hukum')"
                                class="w-full flex items-center justify-between gap-3 text-left"
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
                                                "services.perizinanBerusahaDetail.sections.dasar_hukum",
                                            )
                                        }}
                                    </h2>
                                </div>
                                <svg
                                    class="h-5 w-5 flex-shrink-0 text-[#686964] transition-transform duration-200"
                                    :class="
                                        openSections['dasar-hukum']
                                            ? 'rotate-180'
                                            : ''
                                    "
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
                            <ul
                                v-if="openSections['dasar-hukum']"
                                class="mt-5 space-y-4"
                            >
                                <li
                                    v-for="(
                                        hukum, i
                                    ) in activeContent.dasar_hukum"
                                    :key="`hukum-${i}`"
                                    class="flex items-start gap-4"
                                >
                                    <span
                                        class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-[#ddffe3]"
                                    >
                                        <svg
                                            class="w-4 h-4 text-[#22A94D]"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                            />
                                        </svg>
                                    </span>
                                    <span
                                        class="text-[13px] leading-[1.7] text-[#3D3D3A] text-justify"
                                        >{{ hukum }}</span
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- ===== END KIRI ===== -->

                    <!-- ===== KANAN: Sidebar ===== -->
                    <div
                        class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start min-w-0"
                    >
                        <!-- Price Card (fallback ke product jika tanpa jenis_layanan) -->
                        <div
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5"
                        >
                            <div
                                class="mb-3 inline-flex items-center gap-1.5 rounded-full bg-[#FFF0EF] px-3 py-1"
                            >
                                <span
                                    class="h-1.5 w-1.5 rounded-full bg-primary"
                                ></span>
                                <span
                                    class="text-[11px] font-semibold text-primary"
                                    >Free Konsultasi</span
                                >
                            </div>
                            <p
                                class="text-[13px] font-bold text-[#1A1B18] leading-snug mt-2 mb-3"
                            >
                                {{ activeNama }}
                            </p>
                            <div class="text-[12px] text-[#686964] mb-1">
                                {{ rincianBiaya?.label ?? "Biaya Penanganan" }}
                            </div>
                            <div
                                class="text-[26px] font-bold leading-none text-primary mb-4"
                            >
                                {{ rincianBiaya?.harga ?? "Hubungi Kami" }}
                            </div>
                            <a
                                :href="
                                    buildWhatsappLink(
                                        `${activeKode} ${activeNama}`.trim(),
                                    )
                                "
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary py-2.5 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors mb-2"
                            >
                                Pesan Sekarang
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
                            <a
                                :href="
                                    buildWhatsappLink(
                                        `${activeKode} ${activeNama}`.trim(),
                                    )
                                "
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg border border-[#E8E8E6] py-2.5 text-[13px] font-semibold text-[#3D3D3A] hover:bg-[#F7F7F5] transition-colors"
                            >
                                <img
                                    src="/icons/ft-wa.svg"
                                    class="mt-0.5 h-5 w-5 flex-shrink-0"
                                    alt="wa"
                                />
                                Konsultasi Gratis via Whatsapp
                            </a>
                        </div>

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
                                        FASTRACK – VIP LINE
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
                                Pesan Layanan Sekarang
                            </a>
                            <div
                                class="relative mt-3 text-[11px] text-white/60"
                            >
                                * (S&amp;K BERLAKU)
                            </div>
                        </div>

                        <!-- Layanan lainnya -->
                        <div
                            v-if="localizedRelatedProducts.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5"
                        >
                            <h3
                                class="text-[13px] font-bold text-[#1A1B18] mb-4"
                            >
                                {{ relatedTitle }}
                            </h3>
                            <div class="flex flex-col gap-3">
                                <a
                                    v-for="(
                                        related, index
                                    ) in localizedRelatedProducts.slice(0, 3)"
                                    :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex items-center gap-3 rounded-xl border border-[#E8E8E6] bg-white p-3 hover:border-primary/30 hover:shadow-sm transition-all"
                                >
                                    <div
                                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-[#FFF0EF]"
                                    >
                                        <img
                                            src="/icons/ft-persons.svg"
                                            class="w-5 h-5"
                                            alt=""
                                        />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="text-[13px] font-semibold text-[#1A1B18] group-hover:text-primary transition-colors leading-snug line-clamp-2"
                                        >
                                            {{ pick(related.name) }}
                                        </p>
                                        <p
                                            class="text-[11px] text-[#686964] mt-0.5"
                                        >
                                            Mulai dari {{ related.price_label }}
                                        </p>
                                    </div>
                                    <svg
                                        class="h-4 w-4 flex-shrink-0 text-[#686964] group-hover:text-primary transition-colors"
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
            :title="t('services.perizinanBerusahaDetail.footer.title')"
            :description="t('services.perizinanBerusahaDetail.footer.desc')"
            :button-text="t('services.perizinanBerusahaDetail.footer.cta')"
            :whatsapp-link="buildWhatsappLink('layanan yang tidak terdaftar')"
        />
    </MainLayout>
</template>
