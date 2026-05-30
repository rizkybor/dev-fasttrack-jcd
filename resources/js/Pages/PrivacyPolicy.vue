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
                            Kebijakan Privasi
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
                    <!-- Intro -->
                    <div class="flex flex-col gap-2 mb-8 text-justify">
                        <p class="text-[12px] leading-[22px]">
                            Halaman ini mengatur mengenai Syarat dan Ketentuan
                            <b>("Syarat dan Ketentuan")</b> dimana anda
                            <b>(“Anda”)</b> menggunakan layanan www.<b
                                >Fasttrack.legal</b
                            >
                            <b>(“<b>Fasttrack.legal</b>”)</b>.
                        </p>
                        <p class="text-[12px] leading-[22px]">
                            Dengan menggunakan layanan
                            <b>Fasttrack.legal</b> Kamu dianggap telah membaca
                            dan setuju dengan Syarat & Ketentuan ini.
                        </p>
                    </div>

                    <!-- Divider -->
                    <div class="h-px w-full bg-[#E0E0E0] mb-8"></div>

                    <!-- Content Sections -->
                    <div class="flex flex-col gap-8 text-justify">
                        <!-- Section 1 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[12px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                1. Umum
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Kebijakan Privasi ini menjelaskan tentang
                                bagaimana kami mengumpulkan, menggunakan,
                                menampilkan serta memproses informasi milik Anda
                                terkait dengan layanan yang tersedia di
                                Fasttrack.legal (“Layanan”).
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Apabila Anda memiliki pertanyaan sehubungan
                                dengan Kebijakan Privasi ini, Anda dapat
                                menghubungi kami pada bagian Kontak Kami di
                                bagian bawah Kebijakan Privasi ini.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Kebijakan Privasi ini dapat diubah, modifikasi,
                                tambah, hapus atau koreksi (“Perubahan”) setiap
                                saat dan setiap perubahan itu berlaku sejak saat
                                Legalitas.org nyatakan berlaku atau pada waktu
                                lain yang ditetapkan oleh Legalitas.org.
                                Legalitas.org tidak memberikan pemberitahuan
                                apabila terjadi Perubahan Kebijakan Privasi dan
                                karenanya, Legalitas.org menganjurkan untuk
                                mengunjungi Layanan Legalitas.org secara berkala
                                agar dapat mengetahui adanya perubahan tersebut.
                            </p>
                        </div>

                        <!-- Section 2 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                2. Pengumpulan Informasi
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Informasi yang kami kumpulkan :
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Apabila Anda berlangganan blog dalam Layanan,
                                kami dapat menyimpan catatan mengenai email anda
                                tersebut.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Apabila Anda mengunjungi Layanan
                                Fasttrack.legal, maka kami secara otomatis akan
                                mengumpulkan informasi mengenai tentang
                                kunjungan Anda kepada website kami, termasuk
                                alamat IP, log files, tanggal, waktu dan durasi
                                kunjungan.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Apabila Anda melakukan pengecekan nama
                                perusahaan dan membuat simulasi draft Akta
                                Pendirian dalam Layanan Fasttrack.legal, kami
                                dapat menyimpan catatan mengenai seluruh
                                informasi yang Anda isi tersebut.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Kami menggunakan teknologi “cookie” dalam
                                Layanan. Cookie adalah kode berukuran kecil,
                                umumnya disimpan pada hard drive komputer
                                pengguna, yang memungkinkan situs web untuk
                                "mempersonalisasikan" dirinya bagi setiap
                                pengguna dengan mengingat informasi mengenai
                                kunjungan Anda ke situs kami.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Untuk memberikan mutu layanan terbaik, kami
                                dapat mengumpulkan informasi tambahan kepada
                                Anda melalui kontes, survey dan program-program
                                lainnya
                            </p>
                        </div>

                        <!-- Section 3 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                3. Penggunaan Informasi
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Kami menggunakan informasi yang Anda berikan
                                pada saat Anda berlangganan blog, hubungi kami,
                                pengecekan nama perusahaan dan mengisi simulasi
                                draft Akta Pendirian dalam Layanan. Informasi
                                tersebut digunakan untuk memberikan informasi
                                seputar informasi hukum terbaru, meningkatkan
                                mutu Layanan, dan untuk melakukan promosi kepada
                                Anda.
                            </p>
                        </div>

                        <!-- Section 4 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                4. Pengungkapan Informasi
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                <b>Fasttrack.legal</b> tidak akan menjual dan
                                menyewakan informasi Anda kepada pihak lainnya.
                            </p>
                        </div>

                        <!-- Section 5 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                5. Penyimpanan dan Keamanan Informasi
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Ketika Fasttrack.legal menerima informasi yang
                                Anda berikan dalam Layanan, informasi tersebut
                                akan Fasttrack.legal akan disimpan dalam Layanan
                                Fasttrack.legal untuk yang akan digunakan untuk
                                memenuhi tujuan penggunaan informasi.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Fasttrack.legal berupaya untuk menjaga informasi
                                dengan aman. Diantaranya dengan memberikan akses
                                Secure Server Layer (SSL) yang akan mengenkripsi
                                informasi yang ditampilkan dalam Layanan
                                Legalitas.org.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Untuk mencegah akses tanpa otorisasi,
                                Fasttrack.legal memberlakukan berbagai prosedur
                                fisik, elektronik dan organisasional yang wajar
                                untuk melindungi data pribadi dari penghancuran
                                yang melanggar hukum atau secara tak sengaja,
                                atau kehilangan, pengubahan secara tak sengaja,
                                atau penyingkapan maupun akses tanpa otorisasi.
                            </p>

                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                <b>Fasttrack.legal</b> mengikuti standar umum
                                teknologi untuk menjaga informasi yang diberikan
                                oleh Anda dalam Layanan Fasttrack.legal.
                                Bagaimanapun juga, tidak akan terdapat metode
                                transmisi di internet atau penyimpanan
                                elektronik yang memberikan jaminan 100% aman.
                                Karenanya, Fasttrack.legal tidak dapat menjamin
                                keamanan atas informasi secara mutlak.
                            </p>
                        </div>

                        <!-- Section 6 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                6. Perubahan/Penghapusan Informasi
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Anda sewaktu-waktu dapat melakukan perubahan
                                dan/atau penghapusan informasi.
                            </p>
                        </div>

                        <!-- Section 7 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                7. Tautan Lain
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Dalam Layanan Fasttrack.legal mungkin saja
                                terdapat tautan ke website lain di luar Layanan
                                Legalitas.org. Legalitas.org tidak bertanggung
                                jawab atas kejadian akibat tautan di website
                                lain tersebut.
                            </p>
                        </div>

                        <!-- Section 8 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                8. Lain-lain
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Versi asli dari Kebijakan Privasi ini adalah
                                dalam Bahasa Indonesia, dan dapat diterjemahkan
                                ke dalam bahasa lain. Versi terjemahan dibuat
                                untuk memberi kemudahan bagi pengguna asing, dan
                                tidak bisa dianggap sebagai terjemahan resmi.
                                Jika ditemukan adanya perbedaan antara versi
                                Bahasa Indonesia dan versi bahasa lainnya dari
                                Kebijakan Privasi ini, maka yang berlaku dan
                                mengikat adalah versi Bahasa Indonesia.
                            </p>
                        </div>

                        <!-- Section 9 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                9. Kontak Kami
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Apabila Anda memiliki pertanyaan terkait dengan
                                Syarat dan Ketentuan ini, hubungi kami di:
                                <a
                                    href="mailto:cs@<b>Fasttrack.legal</b>"
                                    class="text-primary hover:underline"
                                    >cs@<b>Fasttrack.legal</b></a
                                >
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
