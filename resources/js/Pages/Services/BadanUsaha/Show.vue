<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref, computed } from "vue";

const docsOpen = ref(false);
const dasarHukumOpen = ref(false);

const plansByProduct = {
    1: {
        plans: [
            {
                name: "PT Perorangan Starter",
                popular: false,
                price: "Rp. 750.000,-",
                bonus_note: "GRATIS Konsultasi Persiapan dan Pasca Selesai",
                dokumen: [
                    { label: "Pengecekan Nama Perseroan", included: true },
                    { label: "Sertifikat Pendirian", included: true },
                    { label: "NPWP & SKT", included: true },
                    { label: "Pendaftaran OSS", included: true },
                    { label: "Nomor Induk Berusaha 20 KBLI*", included: false },
                    { label: "Sertifikat Standar/Izin*", included: false },
                    { label: "Virtual Office 1 (satu) Tahun", included: false },
                ],
                termasuk: [
                    {
                        label: "Fasttrack Document Delivery S...",
                        included: true,
                    },
                    {
                        label: "Fasttrack Digital Files Secure St...",
                        included: true,
                    },
                    { label: "Fasttrack Kit", included: true },
                ],
                bonus: [
                    { label: "Pembukaan Rekening Bank", included: false },
                    { label: "Logo Perusahaan", included: false },
                    { label: "Stempel Perusahaan", included: false },
                    { label: "Kartu Nama", included: false },
                ],
            },
            {
                name: "PT Perorangan Standart",
                popular: true,
                price: "Rp. 3.500.000,-",
                bonus_note: "GRATIS Konsultasi Persiapan dan Pasca Selesai",
                dokumen: [
                    { label: "Pengecekan Nama Perseroan", included: true },
                    { label: "Sertifikat Pendirian", included: true },
                    { label: "NPWP & SKT", included: true },
                    { label: "Pendaftaran OSS", included: true },
                    { label: "Nomor Induk Berusaha 20 KBLI*", included: false },
                    { label: "Sertifikat Standar/Izin*", included: false },
                    { label: "Virtual Office 1 (satu) Tahun", included: false },
                ],
                termasuk: [
                    {
                        label: "Fasttrack Document Delivery S...",
                        included: true,
                    },
                    {
                        label: "Fasttrack Digital Files Secure St...",
                        included: true,
                    },
                    { label: "Fasttrack Kit", included: true },
                ],
                bonus: [
                    { label: "Pembukaan Rekening Bank", included: false },
                    { label: "Logo Perusahaan", included: true },
                    { label: "Stempel Perusahaan", included: true },
                    { label: "Kartu Nama", included: false },
                ],
            },
            {
                name: "PT Perorangan Premium + VO",
                popular: false,
                price: "Rp. 6.000.000,-",
                bonus_note: "GRATIS Konsultasi Persiapan dan Pasca Selesai",
                dokumen: [
                    { label: "Pengecekan Nama Perseroan", included: true },
                    { label: "Sertifikat Pendirian", included: true },
                    { label: "NPWP & SKT", included: true },
                    { label: "Pendaftaran OSS", included: true },
                    { label: "Nomor Induk Berusaha 20 KBLI*", included: true },
                    { label: "Sertifikat Standar/Izin*", included: true },
                    { label: "Virtual Office 1 (satu) Tahun", included: true },
                ],
                termasuk: [
                    {
                        label: "Fasttrack Document Delivery S...",
                        included: true,
                    },
                    {
                        label: "Fasttrack Digital Files Secure St...",
                        included: true,
                    },
                    { label: "Fasttrack Kit", included: true },
                ],
                bonus: [
                    { label: "Pembukaan Rekening Bank", included: true },
                    { label: "Logo Perusahaan", included: true },
                    { label: "Stempel Perusahaan", included: true },
                    { label: "Kartu Nama", included: true },
                ],
            },
        ],
    },
};

const dasarHukumByProduct = {
    1: [
        "Undang-undang No. 6 Tahun 2023 Penetapan Peraturan Pemerintah Pengganti Undang-undang Nomor 2 Tahun 2022 Tentang Cipta Kerja menjadi Undang-Undang",
        "Peraturan Pemerintah (PP) Republik Indonesia No. 8 Tahun 2021:",
        "Peraturan Pemerintah (PP) Republik Indonesia No. 7 Tahun 2021 tentang Kemudahan, Pelindungan, dan Pemberdayaan Koperasi dan Usaha Mikro, Kecil, dan Menengah (UMKM):",
        "Peraturan Menteri Hukum Republik Indonesia Nomor 49 Tahun 2025 tentang Syarat dan Tata Cara Pendirian, Perubahan, dan Pembubaran Badan Hukum Perseroan Terbatas",
        "Peraturan Direktur Jenderal Pajak Nomor Per-7/PJ/2025 Tentang Petunjuk Pelaksanaan Administrasi Nomor Pokok Wajib Pajak, Pengusaha Kena Pajak, Objek Pajak Pajak Bumi Dan Bangunan Serta Perincian Jenis, Dokumen, Dan Saluran Untuk Pelaksanaan Hak Dan Pemenuhan Kewajiban Perpajakan",
    ],
};

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

const buildWhatsappLink = (productName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${productName}.`;
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

const currentPlans = computed(
    () => plansByProduct[props.product?.id]?.plans ?? [],
);
const currentDasarHukum = computed(
    () => dasarHukumByProduct[props.product?.id] ?? [],
);
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section
            class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px] bg-[#E63946]"
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
                            class="text-[#E63946] hover:text-black transition"
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
                            class="h-3 w-3 text-[#E63946]"
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
                            class="text-sm font-medium text-[#E63946] hover:underline"
                            >Layanan</a
                        >
                        <svg
                            class="h-3 w-3 text-[#E63946]"
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
                            href="/badan-usaha"
                            class="text-sm font-medium text-[#E63946] hover:underline"
                            >Badan Usaha</a
                        >
                        <svg
                            class="h-3 w-3 text-[#E63946]"
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
                        <span class="text-sm font-medium text-[#E63946]">{{
                            product.name
                        }}</span>
                    </div>
                </nav>

                <!-- Bottom: Heading + Back -->
                <div class="mt-auto pt-8">
                    <h1
                        class="text-2xl font-extrabold leading-tight text-white sm:text-3xl lg:text-4xl"
                    >
                        {{ product.name }}
                    </h1>
                    <p
                        class="mt-4 max-w-xl text-sm leading-relaxed text-white/80 sm:text-base sm:leading-7"
                    >
                        {{ product.description }}
                    </p>
                    <div class="mt-6">
                        <a
                            href="/badan-usaha"
                            class="inline-flex items-center gap-2 text-sm font-medium text-white hover:text-white/70 transition"
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
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section id="edukasi" class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="grid gap-8 lg:grid-cols-[1fr_340px] xl:grid-cols-[1fr_360px]"
                >
                    <!-- ===== KIRI: Konten Utama ===== -->
                    <div class="flex flex-col gap-6">
                        <!-- 1. Penjelasan Umum -->
                        <div
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <div class="flex items-center gap-3 mb-5">
                                <span
                                    class="flex h-7 w-7 items-center justify-center rounded-full bg-primary/10"
                                >
                                    <svg
                                        class="h-4 w-4 text-primary"
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
                                </span>
                                <h2
                                    class="text-[15px] font-bold uppercase tracking-widest text-primary"
                                >
                                    Penjelasan Umum
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

                        <!-- 2. Syarat dan Ketentuan -->
                        <div
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <div class="flex items-center gap-3 mb-5">
                                <span
                                    class="flex h-7 w-7 items-center justify-center rounded-full bg-primary/10"
                                >
                                    <svg
                                        class="h-4 w-4 text-primary"
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
                                </span>
                                <h2
                                    class="text-[15px] font-bold uppercase tracking-widest text-primary"
                                >
                                    Syarat dan Ketentuan
                                </h2>
                            </div>
                            <ol class="space-y-3">
                                <li
                                    v-for="(req, index) in product.requirements"
                                    :key="`req-${index}`"
                                    class="flex gap-3 text-[14px] leading-[1.7] text-[#3D3D3A]"
                                >
                                    <span
                                        class="mt-0.5 flex-shrink-0 text-[13px] font-semibold text-[#1A1B18]"
                                        >{{ index + 1 }}.</span
                                    >
                                    <span>{{ req }}</span>
                                </li>
                            </ol>
                        </div>

                        <!-- 3. Keuntungan & Manfaat -->
                        <div
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <div class="flex items-center gap-3 mb-6">
                                <span
                                    class="flex h-7 w-7 items-center justify-center rounded-full bg-primary/10"
                                >
                                    <svg
                                        class="h-4 w-4 text-primary"
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
                                </span>
                                <h2
                                    class="text-[15px] font-bold uppercase tracking-widest text-primary"
                                >
                                    Keuntungan &amp; Manfaat
                                </h2>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div
                                    v-for="(benefit, index) in product.benefits"
                                    :key="`benefit-${index}`"
                                    class="flex gap-3 rounded-xl border border-[#E8E8E6] p-4"
                                >
                                    <span
                                        class="mt-0.5 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-primary/10"
                                    >
                                        <svg
                                            class="h-3 w-3 text-primary"
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
                                    <p
                                        class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                    >
                                        {{ benefit }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Alur Proses -->
                        <div
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <div class="flex items-center gap-3 mb-8">
                                <span
                                    class="flex h-7 w-7 items-center justify-center rounded-full bg-primary/10"
                                >
                                    <svg
                                        class="h-4 w-4 text-primary"
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
                                </span>
                                <h2
                                    class="text-[15px] font-bold uppercase tracking-widest text-primary"
                                >
                                    Alur Proses
                                </h2>
                            </div>
                            <div
                                class="flex flex-col sm:flex-row gap-6 sm:gap-0"
                            >
                                <div
                                    v-for="(step, index) in product.process"
                                    :key="`step-${index}`"
                                    class="relative flex flex-col items-center text-center flex-1"
                                >
                                    <!-- Connector line -->
                                    <div
                                        v-if="
                                            index < product.process.length - 1
                                        "
                                        class="absolute top-[22px] left-[calc(50%+22px)] hidden sm:block h-px w-[calc(100%-44px)] bg-primary/20"
                                    ></div>
                                    <!-- Icon -->
                                    <div
                                        class="relative z-10 flex h-11 w-11 items-center justify-center rounded-full bg-[#FAD9DA] border-2 border-primary/20 mb-3"
                                    >
                                        <svg
                                            class="h-5 w-5 text-primary"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                            />
                                        </svg>
                                    </div>
                                    <p
                                        class="text-[12px] leading-[1.5] text-[#3D3D3A] px-2 max-w-[120px]"
                                    >
                                        {{ step }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Dokumen dan Informasi yang Diperlukan (Accordion) -->
                        <div
                            class="rounded-2xl border border-[#E8E8E6] bg-white overflow-hidden"
                        >
                            <button
                                @click="docsOpen = !docsOpen"
                                class="w-full flex items-center justify-between p-6 sm:p-8 text-left"
                            >
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-7 w-7 items-center justify-center rounded-full bg-primary/10"
                                    >
                                        <svg
                                            class="h-4 w-4 text-primary"
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
                                    </span>
                                    <h2
                                        class="text-[15px] font-bold uppercase tracking-widest text-primary"
                                    >
                                        Dokumen dan Informasi yang Diperlukan
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
                                        v-for="(
                                            req, index
                                        ) in product.requirements"
                                        :key="`doc-${index}`"
                                        class="flex gap-4"
                                    >
                                        <span
                                            class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary text-white text-[12px] font-bold"
                                        >
                                            {{ index + 1 }}
                                        </span>
                                        <span
                                            class="text-[14px] leading-[1.7] text-[#3D3D3A] pt-0.5"
                                            >{{ req }}</span
                                        >
                                    </li>
                                </ol>
                            </div>
                        </div>

                        <!-- 6. Paket & Harga -->
                        <div
                            v-if="currentPlans.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <div class="flex items-center gap-3 mb-6">
                                <span
                                    class="flex h-7 w-7 items-center justify-center rounded-full bg-primary/10"
                                >
                                    <svg
                                        class="h-4 w-4 text-primary"
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
                                </span>
                                <h2
                                    class="text-[15px] font-bold uppercase tracking-widest text-primary"
                                >
                                    Paket &amp; Harga
                                </h2>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div
                                    v-for="(plan, pi) in currentPlans"
                                    :key="`plan-${pi}`"
                                    class="relative flex flex-col rounded-xl border"
                                    :class="
                                        plan.popular
                                            ? 'border-primary shadow-md shadow-primary/10'
                                            : 'border-[#E8E8E6]'
                                    "
                                >
                                    <!-- Popular badge -->
                                    <div
                                        v-if="plan.popular"
                                        class="absolute -top-3.5 left-1/2 -translate-x-1/2"
                                    >
                                        <span
                                            class="inline-flex items-center rounded-full border border-primary bg-white px-3 py-0.5 text-[11px] font-semibold text-primary"
                                        >
                                            Paling Populer
                                        </span>
                                    </div>

                                    <div class="p-4 flex flex-col gap-3 flex-1">
                                        <!-- Plan name -->
                                        <div
                                            class="text-[12px] font-bold uppercase tracking-wide text-[#1A1B18]"
                                        >
                                            {{ plan.name }}
                                        </div>

                                        <!-- Price -->
                                        <div>
                                            <div
                                                class="text-[11px] text-[#686964]"
                                            >
                                                Mulai dari
                                            </div>
                                            <div
                                                class="text-[20px] font-bold leading-tight text-primary"
                                            >
                                                {{ plan.price }}
                                            </div>
                                        </div>

                                        <!-- Bonus note -->
                                        <div
                                            class="flex items-start gap-1.5 text-[11px] text-[#3D3D3A]"
                                        >
                                            <svg
                                                class="h-3.5 w-3.5 text-[#25D366] flex-shrink-0 mt-0.5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7"
                                                />
                                            </svg>
                                            {{ plan.bonus_note }}
                                        </div>

                                        <!-- Divider -->
                                        <div class="h-px bg-[#E8E8E6]"></div>

                                        <!-- Dokumen Legalitas -->
                                        <div>
                                            <div
                                                class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                            >
                                                Dokumen Legalitas
                                            </div>
                                            <ul class="space-y-1.5">
                                                <li
                                                    v-for="(
                                                        doc, di
                                                    ) in plan.dokumen"
                                                    :key="`doc-${di}`"
                                                    class="flex items-start gap-1.5"
                                                >
                                                    <svg
                                                        v-if="doc.included"
                                                        class="h-3.5 w-3.5 text-[#25D366] flex-shrink-0 mt-0.5"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        stroke-width="2.5"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M5 13l4 4L19 7"
                                                        />
                                                    </svg>
                                                    <svg
                                                        v-else
                                                        class="h-3.5 w-3.5 text-[#E63946] flex-shrink-0 mt-0.5"
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
                                                    <span
                                                        class="text-[11px] leading-[1.5] text-[#3D3D3A]"
                                                        >{{ doc.label }}</span
                                                    >
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Termasuk -->
                                        <div>
                                            <div
                                                class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                            >
                                                Termasuk
                                            </div>
                                            <ul class="space-y-1.5">
                                                <li
                                                    v-for="(
                                                        item, ti
                                                    ) in plan.termasuk"
                                                    :key="`termasuk-${ti}`"
                                                    class="flex items-start gap-1.5"
                                                >
                                                    <svg
                                                        v-if="item.included"
                                                        class="h-3.5 w-3.5 text-[#25D366] flex-shrink-0 mt-0.5"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        stroke-width="2.5"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M5 13l4 4L19 7"
                                                        />
                                                    </svg>
                                                    <svg
                                                        v-else
                                                        class="h-3.5 w-3.5 text-[#E63946] flex-shrink-0 mt-0.5"
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
                                                    <span
                                                        class="text-[11px] leading-[1.5] text-[#3D3D3A]"
                                                        >{{ item.label }}</span
                                                    >
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Bonus -->
                                        <div>
                                            <div
                                                class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                            >
                                                Bonus
                                            </div>
                                            <ul class="space-y-1.5">
                                                <li
                                                    v-for="(
                                                        bon, bi
                                                    ) in plan.bonus"
                                                    :key="`bonus-${bi}`"
                                                    class="flex items-start gap-1.5"
                                                >
                                                    <svg
                                                        v-if="bon.included"
                                                        class="h-3.5 w-3.5 text-[#25D366] flex-shrink-0 mt-0.5"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        stroke-width="2.5"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M5 13l4 4L19 7"
                                                        />
                                                    </svg>
                                                    <svg
                                                        v-else
                                                        class="h-3.5 w-3.5 text-[#E63946] flex-shrink-0 mt-0.5"
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
                                                    <span
                                                        class="text-[11px] leading-[1.5] text-[#3D3D3A]"
                                                        >{{ bon.label }}</span
                                                    >
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- CTA -->
                                    <div class="p-4 pt-0">
                                        <a
                                            :href="buildWhatsappLink(plan.name)"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex w-full items-center justify-center gap-2 rounded-lg py-2.5 text-[12px] font-semibold transition-colors"
                                            :class="
                                                plan.popular
                                                    ? 'bg-primary text-white hover:bg-primary/90'
                                                    : 'border border-primary text-primary hover:bg-primary hover:text-white'
                                            "
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
                            </div>
                        </div>

                        <!-- 7. Dasar Hukum (Accordion) -->
                        <div
                            v-if="currentDasarHukum.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white overflow-hidden"
                        >
                            <button
                                @click="dasarHukumOpen = !dasarHukumOpen"
                                class="w-full flex items-center justify-between p-6 sm:p-8 text-left"
                            >
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-7 w-7 items-center justify-center rounded-full bg-primary/10"
                                    >
                                        <svg
                                            class="h-4 w-4 text-primary"
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
                                    </span>
                                    <h2
                                        class="text-[15px] font-bold uppercase tracking-widest text-primary"
                                    >
                                        Dasar Hukum
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
                                        <!-- Download icon -->
                                        <span
                                            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg border border-[#E8E8E6] bg-[#F7F7F5]"
                                        >
                                            <svg
                                                class="h-4 w-4 text-primary"
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
                                            class="text-[13px] leading-[1.7] text-[#3D3D3A]"
                                            >{{ hukum }}</span
                                        >
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- ===== KANAN: Sidebar ===== -->
                    <div
                        class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start"
                    >
                        <!-- VIP Line Banner -->
                        <div
                            class="rounded-2xl bg-gradient-to-br from-[#E63946] to-[#c0202c] px-5 py-6 text-center overflow-hidden relative"
                        >
                            <!-- Subtle diagonal decoration -->
                            <div class="absolute inset-0 opacity-10">
                                <svg
                                    class="absolute right-0 top-0 h-full w-auto"
                                    viewBox="0 0 100 100"
                                    preserveAspectRatio="none"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M60 0L20 50L60 100"
                                        stroke="white"
                                        stroke-width="18"
                                        stroke-linecap="butt"
                                    />
                                    <path
                                        d="M85 0L45 50L85 100"
                                        stroke="white"
                                        stroke-width="18"
                                        stroke-linecap="butt"
                                    />
                                </svg>
                            </div>
                            <!-- Title with border -->
                            <div class="relative mb-4">
                                <div
                                    class="inline-block w-full rounded-xl border border-white/60 px-4 py-2.5"
                                >
                                    <span
                                        class="text-[14px] font-extrabold uppercase tracking-widest text-white"
                                        >FASTRACK – VIP LINE</span
                                    >
                                </div>
                            </div>
                            <!-- Subtitle -->
                            <p
                                class="relative text-[14px] leading-[1.6] text-white/90 mb-5"
                            >
                                Pendirian Badan Usaha Selesai dalam<br />1
                                (Satu) Hari
                            </p>
                            <!-- CTA Button -->
                            <a
                                :href="buildWhatsappLink(product.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20"
                            >
                                <svg
                                    class="h-4 w-4 flex-shrink-0"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M20 2H4C2.9 2 2 2.9 2 4v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"
                                    />
                                </svg>
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
                            <!-- Package label -->
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
                                <svg
                                    class="h-4 w-4"
                                    fill="currentColor"
                                    viewBox="0 0 448 512"
                                >
                                    <path
                                        d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-23.1-115-63.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"
                                    />
                                </svg>
                                Konsultasi Gratis via Whatsapp
                            </a>

                            <!-- Checklist Features -->
                            <ul class="mt-4 space-y-2">
                                <li
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <svg
                                        class="h-4 w-4 text-[#25D366] flex-shrink-0"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                    Konsultasi pertama gratis
                                </li>
                                <li
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <svg
                                        class="h-4 w-4 text-[#25D366] flex-shrink-0"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                    Harga transparan, tanpa biaya tersembunyi
                                </li>
                                <li
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <svg
                                        class="h-4 w-4 text-[#25D366] flex-shrink-0"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                    Tim berpengalaman 18+ tahun
                                </li>
                                <li
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <svg
                                        class="h-4 w-4 text-[#25D366] flex-shrink-0"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                    Update proses berkala via WhatsApp
                                </li>
                            </ul>
                        </div>

                        <!-- Layanan Terkait -->
                        <div
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
                                    class="group flex flex-col gap-2 rounded-xl border border-[#E8E8E6] p-4 hover:border-primary/30 hover:shadow-sm transition-all"
                                >
                                    <div
                                        class="text-[13px] font-semibold text-[#1A1B18] group-hover:text-primary transition-colors"
                                    >
                                        {{ related.name }}
                                    </div>
                                    <p
                                        class="text-[11px] leading-[1.6] text-[#686964] line-clamp-2"
                                    >
                                        {{ related.description }}
                                    </p>
                                    <div
                                        class="flex items-center justify-between mt-1"
                                    >
                                        <div>
                                            <div
                                                class="text-[10px] text-[#686964]"
                                            >
                                                Mulai dari
                                            </div>
                                            <div
                                                class="text-[15px] font-bold text-primary"
                                            >
                                                {{ related.price_label }}
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center gap-1 text-[11px] font-semibold text-primary"
                                    >
                                        Selengkapnya
                                        <svg
                                            class="h-3 w-3 group-hover:translate-x-0.5 transition-transform"
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
                    class="relative overflow-hidden rounded-2xl bg-[#E63946] px-6 py-12 sm:px-10 sm:py-14"
                >
                    <!-- Decorative icon -->
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
                            tepat<br class="hidden sm:block" />
                            untuk kebutuhan legalitas bisnis Anda.
                        </p>
                        <a
                            :href="
                                buildWhatsappLink(
                                    'layanan yang tidak terdaftar',
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
