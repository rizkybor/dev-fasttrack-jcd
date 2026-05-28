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
            >
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
                            Kebijakan<br class="hidden sm:block" />
                            <span class="text-white/90">Privasi</span>
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
                    <!-- Title -->
                    <div class="flex flex-col gap-2 mb-8">
                        <h1
                            class="text-[24px] sm:text-[28px] font-bold leading-[36px] sm:leading-[42px] text-[#1A1B18]"
                        >
                            Kebijakan Cookie
                        </h1>
                        <p class="text-[14px] leading-[22px] text-[#6B6B6B]">
                            Terakhir diperbarui: 28 Mei 2026
                        </p>
                    </div>

                    <!-- Divider -->
                    <div class="h-px w-full bg-[#E0E0E0] mb-8"></div>

                    <!-- Content Sections -->
                    <div class="flex flex-col gap-8">
                        <!-- Section 1 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[18px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                Pengaturan Kebijakan Cookie
                            </h2>
                            <p
                                class="text-[14px] leading-[22px] text-[#4A4B47]"
                            >
                                Bagian ini mengatur mengenai kebijakan cookie
                                ("Kebijakan Cookie") yang berlaku bagi seluruh
                                pengguna layanan fasttrack.legal. Dengan
                                mengakses atau menggunakan layanan kami, Anda
                                menyetujui penggunaan cookie sesuai dengan
                                kebijakan ini. Jika Anda tidak setuju dengan
                                kebijakan cookie ini, silakan tidak melakukan
                                registrasi atau tidak menggunakan layanan
                                fasttrack.legal.
                            </p>
                        </div>

                        <!-- Section 2 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[18px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                Pengumpulan Informasi di dalam Cookie
                            </h2>
                            <p
                                class="text-[14px] leading-[22px] text-[#4A4B47]"
                            >
                                Cookie adalah berkas teks kecil yang ditempatkan
                                pada perangkat keras komputer atau perangkat
                                seluler Anda melalui browser saat Anda
                                mengunjungi situs web. Cookie memungkinkan kami
                                untuk menyimpan informasi tertentu yang
                                berkaitan dengan Anda dan perangkat Anda,
                                sehingga kami dapat memberikan layanan yang
                                lebih baik dan lebih personal.
                            </p>
                        </div>

                        <!-- Section 3 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[18px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                Informasi yang Kami Kumpulkan
                            </h2>
                            <p
                                class="text-[14px] leading-[22px] text-[#4A4B47]"
                            >
                                Ketika Anda menggunakan layanan kami, informasi
                                berikut dapat dikumpulkan melalui cookie dan
                                teknologi serupa:
                            </p>
                            <ul class="flex flex-col gap-2 pl-6">
                                <li
                                    class="text-[14px] leading-[22px] text-[#4A4B47] list-disc"
                                >
                                    <span class="font-medium text-[#1A1B18]"
                                        >Data Kontak:</span
                                    >
                                    Informasi yang Anda berikan saat menghubungi
                                    kami, termasuk nama, nomor telepon, dan
                                    alamat email.
                                </li>
                                <li
                                    class="text-[14px] leading-[22px] text-[#4A4B47] list-disc"
                                >
                                    <span class="font-medium text-[#1A1B18]"
                                        >Data Kunjungan:</span
                                    >
                                    Informasi tentang kunjungan Anda ke situs
                                    kami, termasuk alamat IP, berkas log,
                                    tanggal dan waktu kunjungan, serta durasi
                                    kunjungan.
                                </li>
                                <li
                                    class="text-[14px] leading-[22px] text-[#4A4B47] list-disc"
                                >
                                    <span class="font-medium text-[#1A1B18]"
                                        >Preferensi Pengguna:</span
                                    >
                                    Pengaturan bahasa, tema, dan preferensi
                                    lainnya yang disimpan untuk meningkatkan
                                    pengalaman pengguna.
                                </li>
                                <li
                                    class="text-[14px] leading-[22px] text-[#4A4B47] list-disc"
                                >
                                    <span class="font-medium text-[#1A1B18]"
                                        >Data Analitik:</span
                                    >
                                    Informasi tentang bagaimana Anda
                                    berinteraksi dengan halaman dan konten di
                                    situs kami untuk tujuan analitik dan
                                    peningkatan layanan.
                                </li>
                            </ul>
                        </div>

                        <!-- Section 4 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[18px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                Jenis Cookie yang Kami Gunakan
                            </h2>
                            <p
                                class="text-[14px] leading-[22px] text-[#4A4B47]"
                            >
                                Kami menggunakan beberapa jenis cookie untuk
                                menjalankan layanan kami, termasuk namun tidak
                                terbatas pada:
                            </p>

                            <!-- Cookie Types -->
                            <div class="flex flex-col gap-4 mt-2">
                                <div
                                    class="rounded-lg border border-[#E0E0E0] p-4"
                                >
                                    <h3
                                        class="text-[15px] font-semibold leading-[22px] text-[#1A1B18] mb-2"
                                    >
                                        Cookie Esensial
                                    </h3>
                                    <p
                                        class="text-[13px] leading-[20px] text-[#6B6B6B]"
                                    >
                                        Cookie yang diperlukan untuk operasional
                                        dasar situs web. Tanpa cookie ini, situs
                                        kami tidak dapat berfungsi dengan baik.
                                    </p>
                                </div>
                                <div
                                    class="rounded-lg border border-[#E0E0E0] p-4"
                                >
                                    <h3
                                        class="text-[15px] font-semibold leading-[22px] text-[#1A1B18] mb-2"
                                    >
                                        Cookie Analitik
                                    </h3>
                                    <p
                                        class="text-[13px] leading-[20px] text-[#6B6B6B]"
                                    >
                                        Cookie yang membantu kami memahami
                                        bagaimana pengunjung berinteraksi dengan
                                        situs web kami dengan mengumpulkan dan
                                        melaporkan informasi secara anonim.
                                    </p>
                                </div>
                                <div
                                    class="rounded-lg border border-[#E0E0E0] p-4"
                                >
                                    <h3
                                        class="text-[15px] font-semibold leading-[22px] text-[#1A1B18] mb-2"
                                    >
                                        Cookie Fungsional
                                    </h3>
                                    <p
                                        class="text-[13px] leading-[20px] text-[#6B6B6B]"
                                    >
                                        Cookie yang memungkinkan situs web untuk
                                        menyediakan fungsi yang lebih baik dan
                                        personalisasi seperti bahasa pilihan dan
                                        preferensi regional.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 5 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[18px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                Pengelolaan Cookie
                            </h2>
                            <p
                                class="text-[14px] leading-[22px] text-[#4A4B47]"
                            >
                                Anda dapat mengatur atau menghapus cookie
                                melalui pengaturan browser Anda. Sebagian besar
                                browser memungkinkan Anda untuk mengontrol
                                cookie melalui preferensi. Perlu diingat bahwa
                                menghapus atau memblokir cookie tertentu dapat
                                mempengaruhi fungsionalitas situs web kami.
                                Untuk informasi lebih lanjut tentang cara
                                mengelola cookie, silakan kunjungi halaman
                                bantuan browser yang Anda gunakan.
                            </p>
                        </div>

                        <!-- Section 6 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[18px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                Perubahan Kebijakan Cookie
                            </h2>
                            <p
                                class="text-[14px] leading-[22px] text-[#4A4B47]"
                            >
                                Kami berhak untuk memperbarui kebijakan cookie
                                ini sewaktu-waktu. Setiap perubahan akan
                                dipublikasikan di halaman ini dengan tanggal
                                pembaruan yang terbaru. Kami menyarankan Anda
                                untuk meninjau kebijakan ini secara berkala agar
                                selalu mengetahui informasi terbaru mengenai
                                penggunaan cookie di situs kami.
                            </p>
                        </div>

                        <!-- Section 7 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[18px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                Hubungi Kami
                            </h2>
                            <p
                                class="text-[14px] leading-[22px] text-[#4A4B47]"
                            >
                                Jika Anda memiliki pertanyaan mengenai kebijakan
                                cookie kami, silakan hubungi kami melalui:
                            </p>
                            <ul class="flex flex-col gap-1.5 pl-6">
                                <li
                                    class="text-[14px] leading-[22px] text-[#4A4B47] list-disc"
                                >
                                    Email: contact@fasttrack.legal
                                </li>
                                <li
                                    class="text-[14px] leading-[22px] text-[#4A4B47] list-disc"
                                >
                                    WhatsApp: (+62) 878 8279 2511
                                </li>
                                <li
                                    class="text-[14px] leading-[22px] text-[#4A4B47] list-disc"
                                >
                                    Alamat: Jl. Pd. Cabe Raya No.7, Pd. Cabe
                                    Udik, Kec. Pamulang, Kota Tangerang Selatan,
                                    Banten 15418
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
