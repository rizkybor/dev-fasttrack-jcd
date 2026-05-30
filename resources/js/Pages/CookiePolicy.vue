<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
    services: {
        type: Array,
        default: () => [],
    },
});

const whatsappNumber = "6282298604144";

const buildWhatsappLink = (serviceName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai layanan ${serviceName}.`;

    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};
</script>

<template>
    <MainLayout>
        <!-- Hero Section - Services Page -->
        <section class="relative overflow-hidden bg-[#E63946]">
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
                <div
                    class="grid items-center gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16"
                >
                    <!-- Left Content -->
                    <div class="relative z-10">
                        <!-- Breadcrumb -->
                        <nav class="mb-8" aria-label="Breadcrumb">
                            <div
                                class="inline-flex items-center gap-2 rounded-full bg-white/20 backdrop-blur-sm px-4 py-2"
                            >
                                <a
                                    href="/"
                                    class="text-white/90 hover:text-white transition"
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
                                    >Layanan</span
                                >
                            </div>
                        </nav>

                        <!-- Heading -->
                        <h1
                            class="text-3xl font-extrabold leading-tight text-white sm:text-4xl lg:text-5xl xl:text-[3.5rem]"
                        >
                            Kebijakan Cookie
                        </h1>

                        <!-- CTA Button -->
                        <div class="mt-10">
                            <a
                                :href="
                                    buildWhatsappLink(
                                        'kebutuhan legalitas bisnis',
                                    )
                                "
                                target="_blank"
                                rel="noopener noreferrer"
                                class="group inline-flex items-center gap-2.5 rounded-full border-2 border-white bg-transparent px-7 py-3.5 text-sm font-semibold text-white transition-all duration-300 hover:bg-white hover:text-[#E63946]"
                            >
                                Kembali
                                <svg
                                    class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
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
        </section>

        <!-- CONTENT SECTION -->
        <section class="py-[52px] bg-[#F9F9F9]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div
                    class="rounded-xl border border-[#D9DAD8] bg-white p-6 sm:p-8 lg:p-10"
                >
                    <div class="flex flex-col gap-8 text-justify">
                        <!-- Pembuka -->
                        <div class="flex flex-col gap-3">
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Bagian ini mengatur mengenai kebijakan cookie
                                <b>("Kebijakan Cookie")</b> dimana Anda
                                <b>("Anda")</b> menggunakan layanan
                                fasttrack.legal. Jika Anda tidak setuju atas
                                Kebijakan Cookie ini, silahkan tidak melakukan
                                registrasi atau tidak menggunakan layanan
                                fasttrack.legal.
                            </p>
                        </div>

                        <!-- Pengumpulan Informasi -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[14px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                Pengumpulan Informasi di dalam Cookie
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Informasi yang kami kumpulkan:
                            </p>
                            <ul class="flex flex-col gap-2 pl-6">
                                <li
                                    class="text-[12px] leading-[22px] text-[#4A4B47] list-disc"
                                >
                                    Apabila Anda menghubungi Kami, Kami dapat
                                    menyimpan catatan mengenai data, nomor
                                    handphone dan email Anda tersebut.
                                </li>
                                <li
                                    class="text-[12px] leading-[22px] text-[#4A4B47] list-disc"
                                >
                                    Apabila Anda mengunjungi Layanan
                                    fasttrack.legal, maka kami secara otomatis
                                    akan mengumpulkan informasi mengenai tentang
                                    kunjungan Anda kepada website kami, termasuk
                                    alamat IP, log files, tanggal, waktu dan
                                    durasi kunjungan.
                                </li>
                                <li
                                    class="text-[12px] leading-[22px] text-[#4A4B47] list-disc"
                                >
                                    Kami menggunakan teknologi "cookie" dalam
                                    Layanan. Cookie adalah kode berukuran kecil,
                                    umumnya disimpan pada hard drive komputer
                                    pengguna, yang memungkinkan situs web untuk
                                    "mempersonalisasikan" dirinya bagi setiap
                                    pengguna dengan mengingat informasi mengenai
                                    kunjungan Anda ke situs kami.
                                </li>
                                <li
                                    class="text-[12px] leading-[22px] text-[#4A4B47] list-disc"
                                >
                                    Untuk memberikan mutu layanan terbaik, kami
                                    dapat mengumpulkan informasi tambahan kepada
                                    Anda melalui kontes, survey dan
                                    program-program lainnya.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
