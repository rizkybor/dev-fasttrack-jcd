<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
import MainLayout from "@/Layouts/MainLayout.vue";

/**
 * Halaman "Kerjasama" — Program Client Get Client
 * Sesuai desain Figma: hero + kartu program + form pendaftaran mitra referral
 */

const { t, tm } = useI18n();

/* ------------------------------------------------------------------ */
/* Locale-driven data                                                  */
/* ------------------------------------------------------------------ */

const steps = computed(() => tm("kerjasama.program.steps"));
const jenisPesertaOptions = computed(() => tm("kerjasama.form.jenis_peserta_options"));
const skemaInsentifOptions = computed(() => tm("kerjasama.form.skema_insentif_options"));
const komisiHighlights = computed(() => tm("kerjasama.sidebar.highlights"));
const pernyataanList = computed(() => tm("kerjasama.form.pernyataan_list"));

/* ------------------------------------------------------------------ */
/* Form state                                                          */
/* ------------------------------------------------------------------ */

const form = useForm({
    // 1. Data Peserta
    nama_lengkap: "",
    nama_pic: "",
    jenis_peserta: "",
    jenis_peserta_lainnya: "",
    bidang_usaha: "",
    nomor_identitas: "",

    // 2. Kontak Peserta
    no_whatsapp: "",
    email: "",
    alamat_domisili: "",
    media_sosial: "",

    // 3. Informasi Rekening
    nama_bank: "",
    nomor_rekening: "",
    atas_nama: "",

    // 4. Data Referensi Klien
    nama_klien: "",
    nama_pic_klien: "",
    nomor_kontak_klien: "",
    email_klien: "",
    layanan_dibutuhkan: [t("kerjasama.form.section4.default_layanan")],
    keterangan_tambahan: "",

    // 5. Skema Insentif
    skema_insentif: "komisi_tunai",

    // 6. Persetujuan
    setuju_pernyataan: false,
});

const layananInput = ref("");

const addLayanan = () => {
    const value = layananInput.value.trim();
    if (!value) return;
    if (!form.layanan_dibutuhkan.includes(value)) {
        form.layanan_dibutuhkan.push(value);
    }
    layananInput.value = "";
};

const removeLayanan = (index) => {
    form.layanan_dibutuhkan.splice(index, 1);
};

const isLainnya = computed(() => form.jenis_peserta === "lainnya");

const submitted = ref(false);

const submit = () => {
    form.post(route("kerjasama.store"), {
        preserveScroll: true,
        onSuccess: () => {
            submitted.value = true;
            form.reset();
        },
    });
};
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-[#9e1f16]">
            <img
                src="/images/kerjasama-hero.jpg"
                class="absolute inset-0 h-full w-full object-cover opacity-30"
                alt=""
            />
            <div class="ml-5">
                <img
                    src="/icons/left-arrow.svg"
                    class="absolute right-[0%] -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block"
                    alt=""
                />
            </div>

            <div
                class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-24"
            >
                <div class="relative z-10 max-w-2xl">
                    <!-- Breadcrumb -->
                    <nav class="mb-8" aria-label="Breadcrumb">
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
                            <span class="text-sm font-medium text-white">{{ t("kerjasama.hero.breadcrumb") }}</span>
                        </div>
                    </nav>

                    <!-- Heading -->
                    <h1
                        class="text-3xl font-extrabold leading-tight text-white sm:text-4xl lg:text-5xl"
                    >
                        {{ t("kerjasama.hero.title") }}
                    </h1>
                    <p class="mt-3 text-sm sm:text-base text-white/85">
                        {{ t("kerjasama.hero.desc") }}
                    </p>

                    <!-- Back button -->
                    <div class="mt-10">
                        <a
                            href="/"
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
                            {{ t("kerjasama.hero.back") }}
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section class="py-[52px] bg-[#F9F9F9]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="grid gap-6 lg:grid-cols-[1fr_320px] items-start">
                    <!-- MAIN COLUMN -->
                    <div class="flex flex-col gap-6">
                        <!-- Program Info Card -->
                        <div
                            class="rounded-xl border border-[#D9DAD8] bg-white p-6 sm:p-8"
                        >
                            <h2
                                class="text-lg sm:text-xl font-bold text-[#1A1B18] mb-2"
                            >
                                {{ t("kerjasama.program.title") }}
                            </h2>
                            <p class="text-[12px] leading-[22px] text-[#4A4B47] mb-6">
                                {{ t("kerjasama.program.desc") }}
                            </p>

                            <div class="flex flex-col gap-4">
                                <div
                                    v-for="step in steps"
                                    :key="step.number"
                                    class="flex items-start gap-3"
                                >
                                    <span
                                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#9e1f16] text-[11px] font-bold text-white"
                                    >
                                        {{ step.number }}
                                    </span>
                                    <div>
                                        <p
                                            class="text-[13px] font-semibold leading-[20px] text-[#1A1B18]"
                                        >
                                            {{ step.title }}
                                        </p>
                                        <p
                                            v-if="step.description"
                                            class="text-[12px] leading-[20px] text-[#7A7B78]"
                                        >
                                            {{ step.description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Success Banner -->
                        <div
                            v-if="submitted"
                            class="flex items-start gap-3 rounded-xl border border-[#B7E4C7] bg-[#EAF9F0] p-5"
                        >
                            <svg
                                class="mt-0.5 h-5 w-5 flex-shrink-0 text-[#1E9E5A]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <div>
                                <p class="text-[14px] font-semibold text-[#0F6B37]">
                                    Pendaftaran Berhasil Dikirim
                                </p>
                                <p class="mt-1 text-[13px] leading-[20px] text-[#1A1B18]">
                                    Terima kasih telah mendaftar sebagai mitra referral. Tim kami akan segera menghubungi Anda.
                                </p>
                            </div>
                        </div>

                        <!-- FORM CARD -->
                        <form
                            @submit.prevent="submit"
                            class="rounded-xl border border-[#D9DAD8] bg-white p-6 sm:p-8 flex flex-col gap-8"
                        >
                            <!-- 1. Data Peserta -->
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#9e1f16] text-[11px] font-bold text-white"
                                        >1</span
                                    >
                                    <div>
                                        <h3
                                            class="text-[15px] font-bold text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section1.title") }}
                                        </h3>
                                        <p class="text-[11px] text-[#7A7B78]">
                                            {{ t("kerjasama.form.section1.desc") }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2 pl-9">
                                    <div class="flex flex-col gap-1.5">
                                        <label
                                            class="text-[12px] font-medium text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section1.nama_lengkap_label") }}
                                            <span class="text-[#9e1f16]">*</span>
                                        </label>
                                        <input
                                            v-model="form.nama_lengkap"
                                            type="text"
                                            :placeholder="t('kerjasama.form.section1.nama_lengkap_placeholder')"
                                            class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        />
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label
                                            class="text-[12px] font-medium text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section1.nama_pic_label") }}
                                        </label>
                                        <input
                                            v-model="form.nama_pic"
                                            type="text"
                                            :placeholder="t('kerjasama.form.section1.nama_pic_placeholder')"
                                            class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        />
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2 pl-9">
                                    <label
                                        class="text-[12px] font-medium text-[#1A1B18]"
                                    >
                                        {{ t("kerjasama.form.section1.jenis_peserta_label") }}
                                        <span class="text-[#9e1f16]">*</span>
                                    </label>
                                    <div class="grid grid-cols-3 gap-2 sm:max-w-md">
                                        <button
                                            v-for="option in jenisPesertaOptions"
                                            :key="option.value"
                                            type="button"
                                            @click="form.jenis_peserta = option.value"
                                            :class="[
                                                'flex items-center gap-2 rounded-lg border px-3 py-2 text-[11px] font-medium transition',
                                                form.jenis_peserta === option.value
                                                    ? 'border-[#9e1f16] bg-[#FCEEED] text-[#9e1f16]'
                                                    : 'border-[#D9DAD8] text-[#4A4B47] hover:border-[#9e1f16]/40',
                                            ]"
                                        >
                                            <span
                                                :class="[
                                                    'flex h-3.5 w-3.5 shrink-0 items-center justify-center rounded-full border',
                                                    form.jenis_peserta === option.value
                                                        ? 'border-[#9e1f16] bg-[#9e1f16]'
                                                        : 'border-[#D9DAD8]',
                                                ]"
                                            >
                                                <svg
                                                    v-if="form.jenis_peserta === option.value"
                                                    class="h-2 w-2 text-white"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M16.7 5.3a1 1 0 010 1.4l-7.4 7.4a1 1 0 01-1.4 0L3.3 9.5a1 1 0 111.4-1.4l3.6 3.6 6.7-6.7a1 1 0 011.4 0z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </span>
                                            {{ option.label }}
                                        </button>
                                    </div>

                                    <input
                                        v-if="isLainnya"
                                        v-model="form.jenis_peserta_lainnya"
                                        type="text"
                                        :placeholder="t('kerjasama.form.section1.jenis_peserta_lainnya_placeholder')"
                                        class="mt-1 w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none sm:max-w-md"
                                    />
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2 pl-9">
                                    <div class="flex flex-col gap-1.5">
                                        <label
                                            class="text-[12px] font-medium text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section1.bidang_usaha_label") }}
                                            <span class="text-[#9e1f16]">*</span>
                                        </label>
                                        <input
                                            v-model="form.bidang_usaha"
                                            type="text"
                                            :placeholder="t('kerjasama.form.section1.bidang_usaha_placeholder')"
                                            class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        />
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label
                                            class="text-[12px] font-medium text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section1.nomor_identitas_label") }}
                                        </label>
                                        <input
                                            v-model="form.nomor_identitas"
                                            type="text"
                                            :placeholder="t('kerjasama.form.section1.nomor_identitas_placeholder')"
                                            class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="h-px w-full bg-[#E0E0E0]"></div>

                            <!-- 2. Kontak Peserta -->
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#9e1f16] text-[11px] font-bold text-white"
                                        >2</span
                                    >
                                    <h3 class="text-[15px] font-bold text-[#1A1B18]">
                                        {{ t("kerjasama.form.section2.title") }}
                                    </h3>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2 pl-9">
                                    <div class="flex flex-col gap-1.5">
                                        <label
                                            class="text-[12px] font-medium text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section2.no_whatsapp_label") }}
                                            <span class="text-[#9e1f16]">*</span>
                                        </label>
                                        <input
                                            v-model="form.no_whatsapp"
                                            type="text"
                                            :placeholder="t('kerjasama.form.section2.no_whatsapp_placeholder')"
                                            class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        />
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label
                                            class="text-[12px] font-medium text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section2.email_label") }}
                                            <span class="text-[#9e1f16]">*</span>
                                        </label>
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            :placeholder="t('kerjasama.form.section2.email_placeholder')"
                                            class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        />
                                    </div>
                                </div>

                                <div class="flex flex-col gap-1.5 pl-9">
                                    <label
                                        class="text-[12px] font-medium text-[#1A1B18]"
                                    >
                                        {{ t("kerjasama.form.section2.alamat_label") }}
                                        <span class="text-[#9e1f16]">*</span>
                                    </label>
                                    <textarea
                                        v-model="form.alamat_domisili"
                                        rows="2"
                                        :placeholder="t('kerjasama.form.section2.alamat_placeholder')"
                                        class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none resize-none"
                                    ></textarea>
                                </div>

                                <div class="flex flex-col gap-1.5 pl-9">
                                    <label
                                        class="text-[12px] font-medium text-[#1A1B18]"
                                    >
                                        {{ t("kerjasama.form.section2.media_sosial_label") }}
                                    </label>
                                    <input
                                        v-model="form.media_sosial"
                                        type="text"
                                        :placeholder="t('kerjasama.form.section2.media_sosial_placeholder')"
                                        class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                    />
                                </div>
                            </div>

                            <div class="h-px w-full bg-[#E0E0E0]"></div>

                            <!-- 3. Informasi Rekening -->
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#9e1f16] text-[11px] font-bold text-white"
                                        >3</span
                                    >
                                    <div>
                                        <h3
                                            class="text-[15px] font-bold text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section3.title") }}
                                        </h3>
                                        <p class="text-[11px] text-[#7A7B78]">
                                            {{ t("kerjasama.form.section3.desc") }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2 pl-9">
                                    <div class="flex flex-col gap-1.5">
                                        <label
                                            class="text-[12px] font-medium text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section3.nama_bank_label") }}
                                            <span class="text-[#9e1f16]">*</span>
                                        </label>
                                        <input
                                            v-model="form.nama_bank"
                                            type="text"
                                            :placeholder="t('kerjasama.form.section3.nama_bank_placeholder')"
                                            class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        />
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label
                                            class="text-[12px] font-medium text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section3.nomor_rekening_label") }}
                                            <span class="text-[#9e1f16]">*</span>
                                        </label>
                                        <input
                                            v-model="form.nomor_rekening"
                                            type="text"
                                            :placeholder="t('kerjasama.form.section3.nomor_rekening_placeholder')"
                                            class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        />
                                    </div>
                                </div>

                                <div class="flex flex-col gap-1.5 pl-9 sm:max-w-[calc(50%-0.5rem)]">
                                    <label
                                        class="text-[12px] font-medium text-[#1A1B18]"
                                    >
                                        {{ t("kerjasama.form.section3.atas_nama_label") }}
                                        <span class="text-[#9e1f16]">*</span>
                                    </label>
                                    <input
                                        v-model="form.atas_nama"
                                        type="text"
                                        :placeholder="t('kerjasama.form.section3.atas_nama_placeholder')"
                                        class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                    />
                                </div>
                            </div>

                            <div class="h-px w-full bg-[#E0E0E0]"></div>

                            <!-- 4. Data Referensi Klien -->
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#9e1f16] text-[11px] font-bold text-white"
                                        >4</span
                                    >
                                    <div>
                                        <h3
                                            class="text-[15px] font-bold text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section4.title") }}
                                        </h3>
                                        <p class="text-[11px] text-[#7A7B78]">
                                            {{ t("kerjasama.form.section4.desc") }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2 pl-9">
                                    <div class="flex flex-col gap-1.5">
                                        <label
                                            class="text-[12px] font-medium text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section4.nama_klien_label") }}
                                            <span class="text-[#9e1f16]">*</span>
                                        </label>
                                        <input
                                            v-model="form.nama_klien"
                                            type="text"
                                            :placeholder="t('kerjasama.form.section4.nama_klien_placeholder')"
                                            class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        />
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label
                                            class="text-[12px] font-medium text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section4.nama_pic_klien_label") }}
                                            <span class="text-[#9e1f16]">*</span>
                                        </label>
                                        <input
                                            v-model="form.nama_pic_klien"
                                            type="text"
                                            :placeholder="t('kerjasama.form.section4.nama_pic_klien_placeholder')"
                                            class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        />
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label
                                            class="text-[12px] font-medium text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section4.nomor_kontak_klien_label") }}
                                            <span class="text-[#9e1f16]">*</span>
                                        </label>
                                        <input
                                            v-model="form.nomor_kontak_klien"
                                            type="text"
                                            :placeholder="t('kerjasama.form.section4.nomor_kontak_klien_placeholder')"
                                            class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        />
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label
                                            class="text-[12px] font-medium text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section4.email_klien_label") }}
                                        </label>
                                        <input
                                            v-model="form.email_klien"
                                            type="email"
                                            :placeholder="t('kerjasama.form.section4.email_klien_placeholder')"
                                            class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        />
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2 pl-9">
                                    <label
                                        class="text-[12px] font-medium text-[#1A1B18]"
                                    >
                                        {{ t("kerjasama.form.section4.layanan_label") }}
                                    </label>
                                    <div class="flex gap-2">
                                        <input
                                            v-model="layananInput"
                                            type="text"
                                            :placeholder="t('kerjasama.form.section4.layanan_placeholder')"
                                            class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                            @keydown.enter.prevent="addLayanan"
                                        />
                                        <button
                                            type="button"
                                            @click="addLayanan"
                                            class="flex shrink-0 items-center gap-1 rounded-lg bg-[#1A1B18] px-4 py-2.5 text-[12px] font-medium text-white hover:bg-black transition"
                                        >
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
                                                    d="M12 4.5v15m7.5-7.5h-15"
                                                />
                                            </svg>
                                            {{ t("kerjasama.form.section4.layanan_add") }}
                                        </button>
                                    </div>

                                    <div
                                        v-if="form.layanan_dibutuhkan.length"
                                        class="mt-1 flex flex-wrap gap-2"
                                    >
                                        <span
                                            v-for="(layanan, index) in form.layanan_dibutuhkan"
                                            :key="index"
                                            class="inline-flex items-center gap-1.5 rounded-full bg-[#F1F1EF] px-3 py-1.5 text-[11px] font-medium text-[#1A1B18]"
                                        >
                                            {{ layanan }}
                                            <button
                                                type="button"
                                                @click="removeLayanan(index)"
                                                class="text-[#7A7B78] hover:text-[#9e1f16]"
                                            >
                                                <svg
                                                    class="h-3 w-3"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2.5"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-1.5 pl-9">
                                    <label
                                        class="text-[12px] font-medium text-[#1A1B18]"
                                    >
                                        {{ t("kerjasama.form.section4.keterangan_label") }}
                                    </label>
                                    <textarea
                                        v-model="form.keterangan_tambahan"
                                        rows="3"
                                        :placeholder="t('kerjasama.form.section4.keterangan_placeholder')"
                                        class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none resize-none"
                                    ></textarea>
                                </div>
                            </div>

                            <div class="h-px w-full bg-[#E0E0E0]"></div>

                            <!-- 5. Skema Insentif -->
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#9e1f16] text-[11px] font-bold text-white"
                                        >5</span
                                    >
                                    <div>
                                        <h3
                                            class="text-[15px] font-bold text-[#1A1B18]"
                                        >
                                            {{ t("kerjasama.form.section5.title") }}
                                        </h3>
                                        <p class="text-[11px] text-[#7A7B78]">
                                            {{ t("kerjasama.form.section5.desc") }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid gap-3 sm:grid-cols-2 pl-9">
                                    <button
                                        v-for="option in skemaInsentifOptions"
                                        :key="option.value"
                                        type="button"
                                        @click="form.skema_insentif = option.value"
                                        :class="[
                                            'flex items-start gap-2.5 rounded-lg border p-3.5 text-left transition',
                                            form.skema_insentif === option.value
                                                ? 'border-[#9e1f16] bg-[#FCEEED]'
                                                : 'border-[#D9DAD8] hover:border-[#9e1f16]/40',
                                        ]"
                                    >
                                        <span
                                            :class="[
                                                'mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full border',
                                                form.skema_insentif === option.value
                                                    ? 'border-[#9e1f16] bg-[#9e1f16]'
                                                    : 'border-[#D9DAD8]',
                                            ]"
                                        >
                                            <span
                                                v-if="form.skema_insentif === option.value"
                                                class="h-1.5 w-1.5 rounded-full bg-white"
                                            ></span>
                                        </span>
                                        <span>
                                            <span
                                                class="block text-[12px] font-semibold text-[#1A1B18]"
                                            >
                                                {{ option.title }}
                                            </span>
                                            <span
                                                class="block text-[11px] leading-[16px] text-[#7A7B78] mt-0.5"
                                            >
                                                {{ option.description }}
                                            </span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <div class="h-px w-full bg-[#E0E0E0]"></div>

                            <!-- 6. Pernyataan dan Persetujuan -->
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#9e1f16] text-[11px] font-bold text-white"
                                        >6</span
                                    >
                                    <h3 class="text-[15px] font-bold text-[#1A1B18]">
                                        {{ t("kerjasama.form.section6.title") }}
                                    </h3>
                                </div>

                                <ol
                                    class="list-decimal pl-9 marker:text-[#4A4B47] flex flex-col gap-1.5"
                                >
                                    <li
                                        v-for="(item, index) in pernyataanList"
                                        :key="index"
                                        class="text-[12px] leading-[20px] text-[#4A4B47]"
                                    >
                                        {{ item }}
                                    </li>
                                </ol>

                                <label
                                    class="ml-9 flex items-start gap-2.5 cursor-pointer"
                                >
                                    <input
                                        v-model="form.setuju_pernyataan"
                                        type="checkbox"
                                        class="mt-0.5 h-4 w-4 rounded border-[#D9DAD8] text-[#9e1f16] focus:ring-[#9e1f16]"
                                    />
                                    <span class="text-[12px] leading-[18px] text-[#1A1B18]">
                                        {{ t("kerjasama.form.setuju_label") }}
                                    </span>
                                </label>
                            </div>

                            <!-- Submit -->
                            <div
                                class="flex flex-col items-end gap-3 border-t border-[#E0E0E0] pt-6"
                            >
                                <button
                                    type="submit"
                                    :disabled="!form.setuju_pernyataan || form.processing"
                                    class="inline-flex items-center gap-2 rounded-lg bg-[#9e1f16] px-6 py-3 text-[13px] font-semibold text-white transition hover:bg-[#7f1912] disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    {{ t("kerjasama.form.submit_cta") }}
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
                                <p class="text-[11px] text-[#7A7B78] text-right">
                                    {{ t("kerjasama.form.submit_note") }}
                                </p>
                            </div>
                        </form>
                    </div>

                    <!-- SIDEBAR -->
                    <aside class="lg:sticky lg:top-24">
                        <div class="rounded-xl bg-[#9e1f16] p-6 text-white">
                            <h3 class="text-[15px] font-bold mb-2">
                                {{ t("kerjasama.sidebar.title") }}
                            </h3>
                            <p class="text-[11px] leading-[18px] text-white/85 mb-5">
                                {{ t("kerjasama.sidebar.desc") }}
                            </p>

                            <div class="flex flex-col gap-4">
                                <div
                                    v-for="(item, index) in komisiHighlights"
                                    :key="index"
                                    class="flex items-start gap-2.5"
                                >
                                    <span
                                        class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-white"
                                    >
                                        <svg
                                            class="h-2.5 w-2.5 text-[#9e1f16]"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M16.7 5.3a1 1 0 010 1.4l-7.4 7.4a1 1 0 01-1.4 0L3.3 9.5a1 1 0 111.4-1.4l3.6 3.6 6.7-6.7a1 1 0 011.4 0z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-[12px] font-semibold">
                                            {{ item.title }}
                                        </p>
                                        <p
                                            class="text-[11px] leading-[16px] text-white/80"
                                        >
                                            {{ item.description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </MainLayout>
</template>