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
                            Syarat & Ketentuan
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
                                1. Nama
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Syarat dan Ketentuan ini mengatur penggunaan
                                seluruh layanan dan fitur-fitur yang tersedia di
                                website Legalitas.org berikut segala informasi,
                                tulisan, gambar atau material lainnya yang di
                                upload, di download atau ditampilkan dalam
                                website <b>Fasttrack.legal</b> (secara
                                bersama-sama disebut sebagai <b>"Layanan"</b>).
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Layanan ini dimiliki, dioperasikan dan
                                diselenggarakan oleh PT Jakarta Bisnis Servis,
                                perseorangan terbatas yang didirikan berdasarkan
                                hukum Republik Indonesia yang telah memperoleh
                                izin dalam melakukan kegiatan usaha dan Layanan
                                <b>Fasttrack.legal</b> tersedia secara online
                                melalui website <b>Fasttrack.legal</b> atau
                                berbagai akses, media, perangkat dan platform
                                lainnya, baik yang sudah atau akan tersedia
                                dikemudian hari.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Dengan telah melakukan menggunakan Layanan
                                <b>Fasttrack.legal</b>, Anda dianggap:
                            </p>
                            <ol class="flex flex-col gap-1.5 pl-6">
                                <li
                                    class="text-[12px] leading-[22px] text-[#4A4B47] list-decimal"
                                >
                                    Memberikan persetujuan kepada
                                    <b>Fasttrack.legal</b> untuk menggunakan
                                    informasi yang diberikan untuk tujuan
                                    sebagaimana diatur dalam Syarat dan
                                    Ketentuan ini.
                                </li>
                                <li
                                    class="text-[12px] leading-[22px] text-[#4A4B47] list-decimal"
                                >
                                    Melepaskan hak untuk menggugat maupun
                                    menuntut atas segala pernyataan, kekeliruan,
                                    ketidaktepatan atau kekurangan dalam setiap
                                    konten yang dicantumkan dan disampaikan
                                    dalam situs Legalitas.org.
                                </li>
                            </ol>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Pemberian layanan dari
                                <b>Fasttrack.legal</b> atas hal-hal yang diatur
                                dalam bagian Layanan, akan diatur lebih lanjut
                                di dalam Perjanjian lebih rinci.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Apabila Anda memiliki pertanyaan sehubungan
                                dengan Syarat dan Ketentuan ini, Anda dapat
                                menghubungi kami pada bagian Kontak Kami di
                                bagian bawah Syarat dan Ketentuan ini.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Syarat dan Ketentuan ini dapat diubah,
                                modifikasi, tambah, hapus atau koreksi
                                <b>("Perubahan")</b> setiap saat dan setiap
                                perubahan itu berlaku sejak saat
                                <b>Fasttrack.legal</b> nyatakan berlaku atau
                                pada waktu lain yang ditetapkan oleh
                                <b>Fasttrack.legal</b>.
                                <b>Fasttrack.legal</b> tidak memberikan
                                pemberitahuan apabila terjadi Perubahan Syarat
                                dan Ketentuan dan karenanya,
                                <b>Fasttrack.legal</b> menganjurkan untuk
                                mengunjungi <b>Fasttrack.legal</b> secara
                                berkala agar dapat mengetahui adanya perubahan
                                tersebut.
                            </p>
                        </div>

                        <!-- Section 2 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                2. Berlangganan Blog atau Hubungi Kami
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Ketika Anda mengisikan email maupun Data Pribadi
                                lainnya untuk berlangganan blog atau menghubungi
                                kami, Anda bersedia untuk menerima email dari
                                <b>Fasttrack.legal</b> berupa informasi hukum
                                terbaru, promosi-promosi, serta hal-hal lain
                                yang dapat membantu Legalitas.org agar dapat
                                memberikan layanan terbaik.
                            </p>
                        </div>

                        <!-- Section 3 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                3. Pemberian Layanan Oleh <b>Fasttrack.legal</b>
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Seluruh informasi dan data yang disediakan pada
                                <b>Fasttrack.legal</b> adalah bersifat umum dan
                                disediakan untuk tujuan pendidikan dan
                                pengenalan hukum terhadap masyarakat. Dengan
                                demikian tidak dianggap sebagai suatu kebenaran
                                mutlak.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Pada dasarnya <b>Fasttrack.legal</b> tidak
                                menyediakan informasi yang bersifat rahasia.
                                <b>Fasttrack.legal</b>
                                dengan ini menjamin kerahasiaan untuk menjaga
                                informasi yang telah anda berikan, kecuali apa
                                yang akan digunakan dalam Layanan
                                <b>Fasttrack.legal</b>.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Pada layanan Cek Nama Perusahaan (PT/CV) akan
                                dilakukan re-konfirmasi pengecekan nama
                                bersumber dari website Kementrian Hukum Republik
                                Indonesia (Kemenkum RI), dan karenanya hasil
                                konfirmasi pengecekan nama yang kami berikan
                                tidak memberikan suatu jaminan atas tersedianya
                                atau tidak tersedianya keakuratan nama tersebut.
                                Untuk keakuratan nama akan menjadi valid apabila
                                nama tersebut telah di proses hingga penerbitan
                                Pengesahan/Sertifikat Pendirian Badan
                                Hukum/Usaha dari Kemenkum RI.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Pada layanan simulasi Akta Pendirian PT maupun
                                layanan simulasi Akta Pendirian CV akan
                                diberikan draft simulasi Akta Pendirian yang
                                sesuai dengan ketentuan yang berlaku. Hasil
                                simulasi tersebut bukanlah hasil akhir yang
                                bersifat final, sebaiknya dilakukan pembahasan
                                lebih lanjut oleh calon pendiri ketika memasuki
                                tahap penyusunan draft Akta Pendirian oleh
                                Notaris. Dan karenanya kami tidak dapat
                                dimintakan pertanggungjawaban atas penggunaan
                                hasil simulasi tersebut selain dari apa yang
                                menjadi tujuan layanan simulasi ini. Untuk
                                proses lebih lanjut dan hal-hal lain yang lebih
                                detail, disarankan menghubungi kantor Notaris
                                terdekat.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Akses Anda terhadap Layanan Legalitas.org tidak
                                selalu tersedia sewaktu-waktu, karena terhadap
                                Layanan dapat dilakukan perbaikan, perawatan,
                                penambahan konten baru, fasilitas atau layanan
                                lainnya. <b>Fasttrack.legal</b> akan memberikan
                                pemberitahuan apabila sewaktu-waktu terjadi
                                pembatasan akses.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                <b>Fasttrack.legal</b> tidak dapat menjamin
                                bahwa Layanan <b>Fasttrack.legal</b> akan bebas
                                dari gangguan, kerusakan atau memiliki masalah
                                server, bebas dari virus dan masalah lainnya.
                                Apabila terjadi gangguan dalam Layanan
                                <b>Fasttrack.legal</b>, Anda harus memberi tahu
                                kepada <b>Fasttrack.legal</b> dan Legalitas.org
                                akan melakukan perbaikan secepat mungkin.
                            </p>
                        </div>

                        <!-- Section 4 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                4. Pengungkapan / Disclaimer
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                <b>Fasttrack.legal</b> tidak dapat digugat
                                maupun dituntut atas segala pernyataan,
                                kekeliruan, ketidaktepatan atau kekurangan dalam
                                setiap konten yang dicantumkan dan disampaikan
                                melalui <b>Fasttrack.legal</b>.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                <b>Fasttrack.legal</b> berhak sepenuhnya
                                mengubah judul dan/atau isi pertanyaan tanpa
                                mengubah substansi dari hal-hal yang ditanyakan
                                kepada <b>Fasttrack.legal</b>.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Artikel-artikel maupun ketentuan hukum tertentu
                                yang termuat pada <b>Fasttrack.legal</b> mungkin
                                sudah tidak sesuai/tidak relevan dengan
                                peraturan perundang-undangan yang berlaku saat
                                ini.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Disarankan untuk mengecek kembali dasar hukum
                                yang digunakan dalam artikel-artikel
                                Legalitas.org untuk memastikan keberlakuan
                                peraturan perundang-undangan.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Untuk memastikan suatu kebenaran atas artikel,
                                anda dapat menghubungi seorang penasehat hukum
                                yang ahli di bidangnya.
                            </p>
                        </div>

                        <!-- Section 5 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                5. Iklan
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Dalam Layanan <b>Fasttrack.legal</b> terdapat
                                iklan yang dilakukan oleh pengguna sponsor pihak
                                ketiga <b>("Pengiklan")</b>.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                <b>Fasttrack.legal</b> berhak menghapus atau
                                mengubah atau mengganti atau menolak pemasangan
                                materi iklan oleh Pengiklan tanpa memberikan
                                alasan.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Pengiklan bertanggung jawab atas materi iklan
                                dalam Layanan <b>Fasttrack.legal</b>, dan
                                karenanya Pengiklan melepaskannya
                                <b>Fasttrack.legal</b> dari tanggung jawab atas
                                materi iklan yang dilakukan oleh Pengiklan.
                            </p>
                        </div>

                        <!-- Section 6 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                6. Pembayaran Fee
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Pemberian Layanan pada dasarnya adalah gratis.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Khusus untuk pemberian Layanan Services, akan
                                didasarkan pada perjanjian terpisah diluar dari
                                Syarat dan Ketentuan ini.
                            </p>
                        </div>

                        <!-- Section 7 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                7. Pelepasan Hak
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Anda setuju bahwa pada dasarnya Layanan
                                <b>Fasttrack.legal</b> adalah bertujuan untuk
                                pendidikan dan pengenalan hukum kepada
                                masyarakat, dan karenanya Anda dengan ini
                                melepaskannya <b>Fasttrack.legal</b>, karyawan
                                <b>Fasttrack.legal</b>, penulis artikel serta
                                pihak manapun yang bekerjasama dengan
                                Legalitas.org atas segala tanggung jawab
                                sehubungan dengan pemberian Layanan dalam
                                <b>Fasttrack.legal</b>.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Anda setuju bahwa Anda tidak akan melakukan
                                klaim, gugatan, maupun tuntutan kepada
                                <b>Fasttrack.legal</b>, karyawan
                                <b>Fasttrack.legal</b>, penulis artikel serta
                                pihak manapun yang bekerjasama dengan
                                <b>Fasttrack.legal</b>, baik untuk sekarang
                                maupun di kemudian hari.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Apabila terdapat artikel yang setidak-tidaknya
                                terdapat ketidaktepatan atas fakta dan/atau
                                penggunaan peraturan dan/atau penggunaan sumber
                                tulisan dan kejadian lainnya yang dapat
                                mengakibatkan pemberian Layanan menjadi
                                merugikan pihak lain, maka Anda dapat meminta
                                kepada <b>Fasttrack.legal</b> untuk tidak
                                menampilkan artikel dalam Layanan dengan
                                mengirimkan email keberatan yang ditujukan
                                kepada alamat email sebagaimana dimaksud dalam
                                Kontak Kami di bagian paling bawah Syarat dan
                                Ketentuan ini.
                            </p>
                        </div>

                        <!-- Section 8 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                8. Layanan Tersedia "As Is"
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Seluruh informasi, atau konten dalam bentuk
                                apapun yang tersedia pada website layanan ini
                                disediakan sebagaimana adanya dan sebagaimana
                                tersedia tanpa adanya jaminan apapun baik
                                tersirat maupun tersurat.
                            </p>
                        </div>

                        <!-- Section 9 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                9. Keamanan
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Dalam mengakses informasi Akun Anda dalam
                                Layanan <b>Fasttrack.legal</b>, Anda akan
                                menggunakan akses Secure Server Layer (SSL) yang
                                akan mengenkripsi informasi yang ditampilkan
                                dalam Layanan <b>Fasttrack.legal</b>.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                <b>Fasttrack.legal</b> tidak bisa menjamin
                                seberapa kuat atau efektifnya enkripsi ini dan
                                Legalitas.org tidak akan bertanggung jawab atas
                                masalah yang terjadi akibat pengaksesan tanpa
                                ijin dari informasi yang Anda sediakan.
                            </p>
                        </div>

                        <!-- Section 10 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                10. Hukum Yang Berlaku
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Hukum yang berlaku dalam Syarat dan Ketentuan
                                ini adalah Hukum Negara Republik Indonesia.
                            </p>
                        </div>

                        <!-- Section 11 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                11. Bahasa
                            </h2>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Versi asli dari Syarat dan Ketentuan ini adalah
                                dalam Bahasa Indonesia, dan dapat diterjemahkan
                                ke dalam bahasa lain. Versi terjemahan dibuat
                                untuk memberi kemudahan bagi pengguna asing, dan
                                tidak bisa dianggap sebagai terjemahan resmi.
                                Jika ditemukan adanya perbedaan antara versi
                                Bahasa Indonesia dan versi bahasa lainnya dari
                                syarat dan ketentuan ini, maka yang berlaku dan
                                mengikat adalah versi Bahasa Indonesia.
                            </p>
                            <p
                                class="text-[12px] leading-[22px] text-[#4A4B47]"
                            >
                                Setiap perselisihan dalam Layanan Legalitas.org
                                akan diselesaikan secara musyawarah mufakat dan
                                apabila tidak tercapai musyawarah mufakat, maka
                                akan diselesaikan di badan arbitrasi.
                            </p>
                        </div>

                        <!-- Section 12 -->
                        <div class="flex flex-col gap-3">
                            <h2
                                class="text-[16px] sm:text-[20px] font-bold leading-[28px] text-[#1A1B18]"
                            >
                                12. Kontak Kami
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
