<script setup>
import { ref, computed, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
import MainLayout from "@/Layouts/MainLayout.vue";

/**
 * Halaman "Minta Penawaran" — Penawaran Fasttrack
 * Sesuai desain Figma: hero + pilih layanan (kategori > layanan > detail)
 * + ringkasan biaya + form pemohon.
 */

const { t, tm } = useI18n();

/* ------------------------------------------------------------------ */
/* Locale-driven data                                                  */
/* ------------------------------------------------------------------ */

const kategoriOptions = computed(() => tm("mintaPenawaran.kategori_options"));
const layananByKategori = computed(() => tm("mintaPenawaran.layanan_by_kategori"));
const detailByLayanan = computed(() => tm("mintaPenawaran.detail_by_layanan"));

/* ------------------------------------------------------------------ */
/* Selection state                                                     */
/* ------------------------------------------------------------------ */

const selectedKategori = ref("");
const selectedLayanan = ref("");
const selectedDetail = ref("");

const layananOptions = computed(() => {
    return layananByKategori.value[selectedKategori.value] ?? [];
});

const detailOptions = computed(() => {
    return detailByLayanan.value[selectedLayanan.value] ?? [];
});

// Reset pilihan turunan ketika pilihan induk berubah
watch(selectedKategori, () => {
    selectedLayanan.value = "";
    selectedDetail.value = "";
});
watch(selectedLayanan, () => {
    selectedDetail.value = "";
});

const selectedDetailData = computed(() => {
    return detailOptions.value.find((d) => d.value === selectedDetail.value) ?? null;
});

const selectedLayananLabel = computed(() => {
    return layananOptions.value.find((l) => l.value === selectedLayanan.value)?.label ?? "";
});

/* ------------------------------------------------------------------ */
/* Biaya layanan                                                       */
/* ------------------------------------------------------------------ */

const biayaLayanan = computed(() => selectedDetailData.value?.harga ?? 0);
const ppn = computed(() => Math.round(biayaLayanan.value * 0.11));
const subtotal = computed(() => biayaLayanan.value + ppn.value);

const formatRupiah = (value) => {
    return "Rp " + Number(value ?? 0).toLocaleString("id-ID");
};

/* ------------------------------------------------------------------ */
/* Form pemohon                                                        */
/* ------------------------------------------------------------------ */

const form = useForm({
    kategori: "",
    layanan: "",
    detail_layanan: "",
    nama: "",
    perusahaan: "",
    no_whatsapp: "",
    email: "",
    captcha_verified: false,
});

const isFormValid = computed(() => {
    return (
        selectedDetail.value !== "" &&
        form.nama &&
        form.no_whatsapp &&
        form.email &&
        form.captcha_verified
    );
});

const submit = () => {
    form.kategori = selectedKategori.value;
    form.layanan = selectedLayanan.value;
    form.detail_layanan = selectedDetail.value;

    form.post(route("minta-penawaran.store"), {
        preserveScroll: true,
    });
};

/* ------------------------------------------------------------------ */
/* WhatsApp CTA                                                        */
/* ------------------------------------------------------------------ */

const whatsappNumber = "6282298604144";

const whatsappLink = computed(() => {
    const message =
        "Halo FastTrack, saya ingin konsultasi mengenai kebutuhan legalitas bisnis saya.";
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
});
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-[#9e1f16]">
            <div class="ml-5">
                <img
                    src="/icons/left-arrow.svg"
                    class="absolute right-[0%] -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block"
                    alt=""
                />
            </div>

            <div
                class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-14 lg:py-16"
            >
                <div class="relative z-10 max-w-2xl">
                    <!-- Breadcrumb -->
                    <nav class="mb-6" aria-label="Breadcrumb">
                        <div
                            class="inline-flex items-center gap-2 rounded-full bg-white/20 backdrop-blur-sm px-4 py-2"
                        >
                            <a href="/" class="text-white/90 hover:text-white transition">
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
                                class="h-3 w-3 text-white/60"
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
                            <span class="text-sm font-medium text-white"
                                >{{ t("mintaPenawaran.hero.breadcrumb") }}</span
                            >
                        </div>
                    </nav>

                    <!-- Heading -->
                    <h1
                        class="text-3xl font-extrabold leading-tight text-white sm:text-4xl lg:text-5xl"
                    >
                        {{ t("mintaPenawaran.hero.title") }}
                    </h1>
                    <p class="mt-3 text-sm sm:text-base text-white/85">
                        {{ t("mintaPenawaran.hero.desc") }}
                    </p>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section class="py-[52px] bg-[#F9F9F9]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="grid gap-6 lg:grid-cols-[1fr_360px] items-start">
                    <!-- MAIN COLUMN -->
                    <div class="flex flex-col gap-6">
                        <!-- Pilih Layanan Card -->
                        <div
                            class="rounded-xl border border-[#D9DAD8] bg-white p-6 sm:p-8"
                        >
                            <a
                                href="/layanan"
                                class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#9e1f16] hover:text-[#7f1912] transition mb-5"
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
                                {{ t("mintaPenawaran.pilih_layanan.link") }}
                            </a>

                            <div class="grid gap-4 sm:grid-cols-3">
                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-[12px] font-medium text-[#1A1B18]"
                                    >
                                        {{ t("mintaPenawaran.pilih_layanan.kategori_label") }}
                                    </label>
                                    <div class="relative">
                                        <select
                                            v-model="selectedKategori"
                                            class="w-full appearance-none rounded-lg border border-[#D9DAD8] px-3 py-2.5 pr-9 text-[12px] text-[#1A1B18] focus:border-[#9e1f16] focus:outline-none"
                                        >
                                            <option value="" disabled>
                                                {{ t("mintaPenawaran.pilih_layanan.kategori_placeholder") }}
                                            </option>
                                            <option
                                                v-for="opt in kategoriOptions"
                                                :key="opt.value"
                                                :value="opt.value"
                                            >
                                                {{ opt.label }}
                                            </option>
                                        </select>
                                        <svg
                                            class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#7A7B78]"
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
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-[12px] font-medium text-[#1A1B18]"
                                    >
                                        {{ t("mintaPenawaran.pilih_layanan.layanan_label") }}
                                    </label>
                                    <div class="relative">
                                        <select
                                            v-model="selectedLayanan"
                                            :disabled="!selectedKategori"
                                            class="w-full appearance-none rounded-lg border border-[#D9DAD8] px-3 py-2.5 pr-9 text-[12px] text-[#1A1B18] focus:border-[#9e1f16] focus:outline-none disabled:bg-[#F5F5F4] disabled:text-[#B0B1AE]"
                                        >
                                            <option value="" disabled>
                                                {{ t("mintaPenawaran.pilih_layanan.layanan_placeholder") }}
                                            </option>
                                            <option
                                                v-for="opt in layananOptions"
                                                :key="opt.value"
                                                :value="opt.value"
                                            >
                                                {{ opt.label }}
                                            </option>
                                        </select>
                                        <svg
                                            class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#7A7B78]"
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
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-[12px] font-medium text-[#1A1B18]"
                                    >
                                        {{ t("mintaPenawaran.pilih_layanan.detail_label") }}
                                    </label>
                                    <div class="relative">
                                        <select
                                            v-model="selectedDetail"
                                            :disabled="!selectedLayanan"
                                            class="w-full appearance-none rounded-lg border border-[#D9DAD8] px-3 py-2.5 pr-9 text-[12px] text-[#1A1B18] focus:border-[#9e1f16] focus:outline-none disabled:bg-[#F5F5F4] disabled:text-[#B0B1AE]"
                                        >
                                            <option value="" disabled>
                                                {{ t("mintaPenawaran.pilih_layanan.detail_placeholder") }}
                                            </option>
                                            <option
                                                v-for="opt in detailOptions"
                                                :key="opt.value"
                                                :value="opt.value"
                                            >
                                                {{ opt.label }}
                                            </option>
                                        </select>
                                        <svg
                                            class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#7A7B78]"
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
                                </div>
                            </div>

                            <!-- Selected Service Preview -->
                            <div
                                v-if="selectedDetailData"
                                class="relative mt-6 overflow-hidden rounded-xl bg-[#9e1f16] px-6 py-10 text-center"
                            >
                                <img
                                    src="/icons/left-arrow.svg"
                                    class="absolute -right-6 -top-6 h-32 w-auto opacity-10 pointer-events-none"
                                    alt=""
                                />
                                <p
                                    class="text-[15px] font-bold uppercase tracking-wide text-white"
                                >
                                    {{ selectedDetailData.label }}
                                </p>
                                <p class="mt-4 text-[11px] text-white/70">{{ t("mintaPenawaran.pilih_layanan.starting_from") }}</p>
                                <p class="text-xl font-extrabold text-white">
                                    {{ formatRupiah(selectedDetailData.harga) }}
                                </p>
                            </div>

                            <!-- Empty state -->
                            <div
                                v-else
                                class="mt-6 flex flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-[#D9DAD8] px-6 py-12 text-center"
                            >
                                <p class="text-[12px] text-[#7A7B78]">
                                    {{ t("mintaPenawaran.pilih_layanan.empty_state") }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- SIDEBAR -->
                    <aside class="lg:sticky lg:top-24 flex flex-col gap-4">
                        <form
                            @submit.prevent="submit"
                            class="rounded-xl border border-[#D9DAD8] bg-white p-5 flex flex-col gap-5"
                        >
                            <!-- Biaya Layanan -->
                            <div class="flex flex-col gap-3">
                                <h3
                                    class="text-[13px] font-bold uppercase tracking-wide text-[#1A1B18]"
                                >
                                    {{ t("mintaPenawaran.biaya.title") }}
                                </h3>

                                <div v-if="selectedDetailData" class="flex flex-col gap-2">
                                    <p
                                        class="text-[11px] font-semibold uppercase text-[#7A7B78]"
                                    >
                                        {{ selectedLayananLabel }}
                                    </p>

                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] text-[#4A4B47]"
                                            >{{ t("mintaPenawaran.biaya.biaya_label") }}</span
                                        >
                                        <span class="text-[11px] font-medium text-[#1A1B18]">
                                            {{ formatRupiah(biayaLayanan) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] text-[#4A4B47]"
                                            >{{ t("mintaPenawaran.biaya.ppn_label") }}</span
                                        >
                                        <span class="text-[11px] font-medium text-[#1A1B18]">
                                            {{ formatRupiah(ppn) }}
                                        </span>
                                    </div>

                                    <div class="h-px w-full bg-[#E0E0E0] my-1"></div>

                                    <div class="flex items-center justify-between">
                                        <span class="text-[12px] font-semibold text-[#1A1B18]"
                                            >{{ t("mintaPenawaran.biaya.subtotal_label") }}</span
                                        >
                                        <span class="text-[13px] font-bold text-[#9e1f16]">
                                            {{ formatRupiah(subtotal) }}
                                        </span>
                                    </div>

                                    <p class="text-[10px] leading-[15px] text-[#B0B1AE] mt-1">
                                        {{ t("mintaPenawaran.biaya.note") }}
                                    </p>
                                </div>

                                <p v-else class="text-[11px] text-[#B0B1AE]">
                                    {{ t("mintaPenawaran.biaya.empty") }}
                                </p>
                            </div>

                            <div class="h-px w-full bg-[#E0E0E0]"></div>

                            <!-- Pemohon -->
                            <div class="flex flex-col gap-3">
                                <h3
                                    class="text-[13px] font-bold uppercase tracking-wide text-[#1A1B18]"
                                >
                                    {{ t("mintaPenawaran.pemohon.title") }}
                                </h3>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[11px] font-medium text-[#1A1B18]"
                                        >{{ t("mintaPenawaran.pemohon.nama_label") }}</label
                                    >
                                    <input
                                        v-model="form.nama"
                                        type="text"
                                        :placeholder="t('mintaPenawaran.pemohon.nama_placeholder')"
                                        class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                    />
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[11px] font-medium text-[#1A1B18]"
                                        >{{ t("mintaPenawaran.pemohon.perusahaan_label") }}</label
                                    >
                                    <input
                                        v-model="form.perusahaan"
                                        type="text"
                                        :placeholder="t('mintaPenawaran.pemohon.perusahaan_placeholder')"
                                        class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                    />
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[11px] font-medium text-[#1A1B18]"
                                        >{{ t("mintaPenawaran.pemohon.whatsapp_label") }}</label
                                    >
                                    <input
                                        v-model="form.no_whatsapp"
                                        type="text"
                                        :placeholder="t('mintaPenawaran.pemohon.whatsapp_placeholder')"
                                        class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                    />
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[11px] font-medium text-[#1A1B18]"
                                        >{{ t("mintaPenawaran.pemohon.email_label") }}</label
                                    >
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        :placeholder="t('mintaPenawaran.pemohon.email_placeholder')"
                                        class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                    />
                                </div>
                            </div>

                            <!-- Captcha (placeholder) -->
                            <label
                                class="flex items-center justify-between gap-2 rounded-lg border border-[#D9DAD8] px-3 py-2.5 cursor-pointer"
                            >
                                <span class="flex items-center gap-2">
                                    <input
                                        v-model="form.captcha_verified"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-[#D9DAD8] text-[#9e1f16] focus:ring-[#9e1f16]"
                                    />
                                    <span class="text-[11px] text-[#1A1B18]"
                                        >{{ t("mintaPenawaran.captcha_label") }}</span
                                    >
                                </span>
                                <span
                                    class="text-[8px] leading-tight text-[#B0B1AE] text-right"
                                >
                                    reCAPTCHA<br />Privacy - Terms
                                </span>
                            </label>

                            <!-- Submit -->
                            <button
                                type="submit"
                                :disabled="!isFormValid || form.processing"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#9e1f16] px-6 py-3 text-[13px] font-semibold text-white transition hover:bg-[#7f1912] disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                {{ t("mintaPenawaran.submit_cta") }}
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
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                                    />
                                </svg>
                            </button>
                        </form>

                        <!-- Info Box -->
                        <div
                            class="flex items-start gap-2.5 rounded-lg bg-[#E7F3FB] border border-[#C7E4F5] px-4 py-3.5"
                        >
                            <svg
                                class="h-4 w-4 shrink-0 mt-0.5 text-[#2E90D6]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <p class="text-[11px] leading-[17px] text-[#2E6A96]">
                                {{ t("mintaPenawaran.info_box") }}
                            </p>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <!-- CTA BANNER -->
        <section class="pb-[52px] bg-[#F9F9F9]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div
                    class="relative overflow-hidden rounded-xl bg-[#9e1f16] px-6 py-12 sm:py-14 text-center"
                >
                    <svg
                        class="pointer-events-none absolute right-6 top-1/2 hidden h-24 w-24 -translate-y-1/2 text-white/10 sm:block"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>

                    <h2 class="text-xl sm:text-2xl font-extrabold text-white">
                        {{ t("mintaPenawaran.cta.title") }}
                    </h2>
                    <p class="mt-2 text-[13px] text-white/80 max-w-md mx-auto">
                        {{ t("mintaPenawaran.cta.desc") }}
                    </p>

                    <a
                        :href="whatsappLink"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-6 inline-flex items-center gap-2 rounded-lg bg-[#25D366] px-6 py-3 text-[13px] font-semibold text-white transition hover:bg-[#1fb955]"
                    >
                        {{ t("mintaPenawaran.cta.whatsapp") }}
                        <svg
                            class="h-4 w-4"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.87.51 3.61 1.4 5.11L2 22l5.13-1.5a9.87 9.87 0 004.91 1.3h.01c5.46 0 9.9-4.45 9.9-9.91S17.5 2 12.04 2zm5.79 14.05c-.24.68-1.42 1.3-1.96 1.38-.5.08-1.14.11-1.84-.12-.42-.14-.97-.31-1.66-.61-2.93-1.27-4.84-4.22-4.99-4.42-.15-.2-1.19-1.58-1.19-3.02 0-1.44.75-2.15 1.02-2.44.27-.29.58-.36.78-.36.19 0 .39 0 .56.01.18.01.42-.07.65.5.24.58.82 2.01.89 2.16.07.15.12.32.02.51-.09.2-.14.32-.28.5-.14.17-.29.38-.42.51-.14.14-.29.29-.12.57.17.29.75 1.24 1.62 2.01 1.11.99 2.05 1.3 2.34 1.45.29.14.46.12.63-.07.17-.2.72-.84.92-1.13.19-.29.38-.24.64-.14.26.09 1.66.78 1.94.92.29.14.48.21.55.33.07.12.07.68-.17 1.36z"
                            />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    </MainLayout>
</template>