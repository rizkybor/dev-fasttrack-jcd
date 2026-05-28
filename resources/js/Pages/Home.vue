<script setup>
import { ref, computed } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";

const ptName = ref("");
const isChecking = ref(false);
const checkResult = ref(null);

const checkPT = () => {
    if (!ptName.value) return;
    isChecking.value = true;
    checkResult.value = null;
    setTimeout(() => {
        isChecking.value = false;
        const isAvailable = Math.random() > 0.5;
        checkResult.value = {
            available: isAvailable,
            message: isAvailable
                ? `Nama PT "${ptName.value}" tersedia.`
                : `Nama PT "${ptName.value}" sudah digunakan.`,
        };
    }, 1500);
};

const marqueeRows = [
    { id: "r1", reverse: false },
    { id: "r2", reverse: true },
    { id: "r3", reverse: false },
];

const serviceSearch = ref("");

const serviceCategories = [
    {
        title: "PENDIRIAN BADAN USAHA",
        path: "/pendirian-perusahaan",
        items: [
            {
                title: "PT Perorangan",
                description:
                    "Perseroan Terbatas (PT) Perorangan adalah Badan Hukum yang didirikan oleh 1 (satu) seorang",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/pendirian-perusahaan",
                icon: "/icons/ft-person.svg",
            },
            {
                title: "PT. PMDN",
                description:
                    "Penanaman Modal Dalam Negeri (PMDN) adalah kegiatan menanam modal menggunakan Modal Dalam Negeri.",
                price: "Rp 3.250.000",
                packages: "5 Paket",
                path: "/pendirian-perusahaan",
                icon: "/icons/ft-persons.svg",
            },
            {
                title: "PT. PMA",
                description:
                    "Penanaman Modal Asing (PMA) adalah kegiatan investasi atau menanam modal oleh Penanam Modal Asing",
                price: "Rp 17.250.000",
                packages: "3 Paket",
                path: "/foreignservice",
                icon: "/icons/ft-person-check.svg",
            },
            {
                title: "Pendirian CV",
                description:
                    "CV merupakan bentuk persekutuan yang didirikan oleh dua orang atau lebih",
                price: "Rp 2.750.000",
                packages: "4 Paket",
                path: "/pendirian-perusahaan",
                icon: "/icons/ft-building.svg",
            },
        ],
    },
    {
        title: "ONLINE SINGLE SUBMISSION (OSS)",
        path: "/perizinan-usaha",
        items: [
            {
                title: "NIB – PERORANGAN",
                description:
                    "Pengurusan NIB resmi untuk pelaku usaha perseorangan melalui sistem OSS.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perizinan-usaha",
                icon: "/icons/ft-person.svg",
            },
            {
                title: "NIB – PT – UMK",
                description:
                    "Pengurusan NIB untuk Perseroan Terbatas berkategori Usaha Mikro dan Kecil.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perizinan-usaha",
                icon: "/icons/ft-person.svg",
            },
            {
                title: "NIB – PT – NON UMK",
                description:
                    "Pengurusan NIB untuk PT skala menengah, besar, PMDN, maupun PMA.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perizinan-usaha",
                icon: "/icons/ft-person.svg",
            },
            {
                title: "NIB – CV",
                description:
                    "Pengurusan NIB resmi untuk badan usaha berbentuk Commanditaire Vennootschap (CV).",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perizinan-usaha",
                icon: "/icons/ft-person.svg",
            },
        ],
    },
    {
        title: "NOTARIS VIRTUAL – AKTA PERUSAHAAN DAN PERORANGAN",
        path: "/perubahan-akta",
        items: [
            {
                title: "PT (PERSEROAN TERBATAS) MODAL DIBAWAH 1M :",
                description: "Perubahan Anggaran Dasar Perseroan Pasal 1–4",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perubahan-akta",
                icon: "/icons/ft-person.svg",
            },
            {
                title: "PT (PERSEROAN TERBATAS) MODAL DIBAWAH 1M :",
                description:
                    "Perubahan Anggaran Dasar Perseroan Selain Pasal 1–4",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perubahan-akta",
                icon: "/icons/ft-person.svg",
            },
            {
                title: "PT (PERSEROAN TERBATAS) MODAL DIATAS 1M :",
                description: "Perubahan Anggaran Dasar Perseroan Pasal 3",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perubahan-akta",
                icon: "/icons/ft-person.svg",
            },
            {
                title: "PT (PERSEROAN TERBATAS) MODAL DIATAS 1M :",
                description: "Perubahan Anggaran Dasar Perseroan Pasal 4",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perubahan-akta",
                icon: "/icons/ft-person.svg",
            },
        ],
    },
    {
        title: "IZIN TINGGAL TERBATAS",
        path: "/foreignservice",
        items: [
            {
                title: "IZIN TINGGAL TERBATAS DAN KERJA TENAGA KERJA ASING",
                description:
                    "Pengurusan ITAS dan izin kerja resmi untuk tenaga kerja asing di Indonesia.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                icon: "/icons/ft-person.svg",
            },
            {
                title: "IZIN TINGGAL TERBATAS KELUARGA TENAGA KERJA ASING",
                description:
                    "Pengurusan ITAS untuk anggota keluarga yang mengikuti tenaga kerja asing.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                icon: "/icons/ft-person.svg",
            },
            {
                title: "IZIN TINGGAL TERBATAS INVESTOR",
                description:
                    "Pengurusan ITAS untuk investor asing yang menanamkan modal di Indonesia.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                icon: "/icons/ft-person.svg",
            },
            {
                title: "IZIN TINGGAL TERBATAS PASANGAN (SPOUSE)",
                description:
                    "Pengurusan ITAS untuk pasangan sah dari pemegang izin tinggal terbatas.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                icon: "/icons/ft-person.svg",
            },
        ],
    },
    {
        title: "VISA KE INDONESIA",
        path: "/foreignservice",
        items: [
            {
                title: "Visa Bisnis",
                description:
                    "Pengurusan visa bisnis untuk kunjungan bisnis ke Indonesia.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                icon: "/icons/ft-person.svg",
            },
            {
                title: "Visa Kerja",
                description:
                    "Pengurusan visa kerja untuk tenaga kerja asing di Indonesia.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                icon: "/icons/ft-person.svg",
            },
            {
                title: "Visa Investor",
                description:
                    "Pengurusan visa investor untuk penanam modal asing.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                icon: "/icons/ft-person.svg",
            },
            {
                title: "Visa Keluarga",
                description:
                    "Pengurusan visa untuk anggota keluarga tenaga kerja asing.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                icon: "/icons/ft-person.svg",
            },
        ],
    },
];

const filteredCategories = computed(() => {
    if (!serviceSearch.value) return serviceCategories;
    const q = serviceSearch.value.toLowerCase();
    return serviceCategories
        .map((cat) => ({
            ...cat,
            items: cat.items.filter(
                (item) =>
                    item.title.toLowerCase().includes(q) ||
                    item.description.toLowerCase().includes(q) ||
                    item.icon,
            ),
        }))
        .filter((cat) => cat.items.length > 0);
});

const tools = [
    {
        title: "Cek Ketersediaan Nama PT",
        description:
            "Cek ketersediaan nama PT Anda sebelum mendaftar ke AHU Kemenkum RI.",
        cta: "Cek Nama PT",
        bg: "#D6F8E6",
        iconColor: "#22C55E",
        icon: "check-circle",
        path: "/cek-nama-pt",
    },
    {
        title: "Panduan KBLI 2025",
        description:
            "Temukan kode KBLI yang tepat untuk bidang usaha Anda berdasarkan data terbaru 2025.",
        cta: "Lihat Panduan",
        bg: "#FFF6D0",
        iconColor: "#EAB308",
        icon: "book",
        path: "/kbli",
    },
    {
        title: "Tabel Konversi KBLI 2020 x KBLI 2025",
        description: "Konversi kode KBLI lama ke format terbaru 2025.",
        cta: "Buka Tabel",
        bg: "#A8BDED",
        iconColor: "#3B82F6",
        icon: "clipboard",
        path: "/kbli",
    },
    {
        title: "Simulasi AKTA Pendirian",
        description:
            "Simulasikan dokumen akta pendirian Perseroan Terbatas sebelum proses resmi dimulai.",
        cta: "Mulai Simulasi",
        bg: "#FFD4AE",
        iconColor: "#F97316",
        icon: "file-edit",
        path: "/buat-akta",
    },
    {
        title: "Generator Nama",
        description:
            "Kesulitan menemukan nama Perusahaan untuk PT yang mau kamu buat?",
        cta: "Generate Sekarang",
        bg: "#CAF6FF",
        iconColor: "#06B6D4",
        icon: "wand",
        path: "/generate",
    },
];

const virtualOffices = [
    {
        name: "Centennial Tower",
        location: "Jakarta Selatan",
        kpp: "KPP Setia Budi",
        status: "TERSEDIA",
        image: "/images/vo-centennial.png",
    },
    {
        name: "Menara Kuningan",
        location: "Jakarta Selatan",
        kpp: "KPP Setia Budi",
        status: "TERSEDIA",
        image: "/images/vo-kuningan.png",
    },
    {
        name: "Sudirman Business District",
        location: "Jakarta Selatan",
        kpp: "KPP Tanah Abang",
        status: "TERSEDIA",
        image: "/images/vo-sudirman.png",
    },
    {
        name: "Pondok Indah Office",
        location: "Jakarta Selatan",
        kpp: "KPP Kebayoran Baru",
        status: "TERSEDIA",
        image: "/images/vo-pondokindah.png",
    },
];
</script>

<template>
    <MainLayout>
        <!-- ===== 1. HERO SECTION ===== -->
        <section
            class="relative min-h-[520px] lg:min-h-[580px] flex items-center overflow-hidden"
        >
            <div
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="background-image: url(&quot;/images/hero-bg.png&quot;)"
            ></div>
            <div class="absolute inset-0 bg-black/60"></div>

            <div
                class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-20 py-14 lg:py-[52px]"
            >
                <div class="max-w-2xl flex flex-col gap-7">
                    <div class="flex flex-col gap-7">
                        <div
                            class="inline-flex items-center gap-2 rounded-full border border-[#FEFEFE]/30 bg-white/10 backdrop-blur-sm px-4 py-2 w-max"
                        >
                            <span class="text-sm text-[#FEFEFE]"
                                >Dipercaya lebih dari 13.000 Pelaku Usaha</span
                            >
                        </div>

                        <div class="flex flex-col gap-4">
                            <h1
                                class="text-3xl sm:text-4xl lg:text-[44px] font-bold leading-tight text-[#F9F9F9]"
                            >
                                Partner Terbaik Anda Dalam Memulai Dan
                                Mengembangkan Perusahaan Anda
                            </h1>
                            <p
                                class="text-base lg:text-[16px] text-[#F9F9F9]/90 leading-relaxed"
                            >
                                Memberikan pelayanan yang professional, unggul,
                                praktis, efektif dan efisien
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a
                            href="/kontak"
                            class="inline-flex items-center gap-2 bg-[#E74247] hover:bg-red-600 text-white font-semibold text-base px-6 py-3 rounded-lg transition-colors shadow-md"
                        >
                            Hubungi Kami
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                />
                            </svg>
                        </a>
                        <a
                            href="/layanan"
                            class="inline-flex items-center gap-2 border border-[#F9F9F9] text-[#F9F9F9] hover:bg-white/10 font-semibold text-base px-6 py-3 rounded-lg transition-colors"
                        >
                            Jelajah Layanan
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 2. STATS DIVIDER ===== -->
        <section class="relative z-20 mb-5">
            <div class="max-w-3xl ml-auto px-4 -mt-12 lg:-mt-14">
                <div
                    class="bg-[#E74247] rounded-xl px-6 py-5 flex flex-wrap items-center justify-center gap-x-6 gap-y-4"
                >
                    <div class="flex items-center gap-4">
                        <div class="text-center">
                            <div
                                class="text-xl lg:text-2xl font-bold text-[#F9F9F9]"
                            >
                                10.000+
                            </div>
                            <div class="text-xs lg:text-sm text-[#F9F9F9]/80">
                                Klien bisnis dilayani
                            </div>
                        </div>
                        <div class="h-8 w-px bg-white/20 hidden sm:block"></div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-center">
                            <div
                                class="text-xl lg:text-2xl font-bold text-[#F9F9F9]"
                            >
                                20+ Tahun
                            </div>
                            <div class="text-xs lg:text-sm text-[#F9F9F9]/80">
                                Pengalaman
                            </div>
                        </div>
                        <div class="h-8 w-px bg-white/20 hidden sm:block"></div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-center">
                            <div
                                class="text-xl lg:text-2xl font-bold text-[#F9F9F9]"
                            >
                                10+
                            </div>
                            <div class="text-xs lg:text-sm text-[#F9F9F9]/80">
                                Virtual Office
                            </div>
                        </div>
                        <div class="h-8 w-px bg-white/20 hidden sm:block"></div>
                    </div>
                    <div class="text-center">
                        <div
                            class="text-xl lg:text-2xl font-bold text-[#F9F9F9]"
                        >
                            99.9%
                        </div>
                        <div class="text-xs lg:text-sm text-[#F9F9F9]/80">
                            Kepuasan Klien
                        </div>
                    </div>
                </div>

                <!-- Speech bubble tail (triangle) -->
            <svg
                class="absolute -bottom-[30px] right-[10%] z-10"
                width="35"
                height="32"
                viewBox="0 0 100 32"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                preserveAspectRatio="none"
            >
                <path d="M0 0H100L0 32Z" fill="#E74247"/>
            </svg>
            </div>
        </section>

        <!-- ===== 3. VIP LINE ===== -->
        <section class="py-8">
            <div class="bg-[#E74247]">
                <div
                    class="flex items-center justify-between px-4 sm:px-6 lg:px-[84px] h-[160px]"
                >
                    <div class="inline-flex items-end gap-2">
                        <div class="inline-flex flex-col items-start gap-2">
                            <div
                                class="inline-flex items-center justify-center rounded-lg bg-[#FEFEFE] px-4 py-2"
                            >
                                <span
                                    class="text-[28px] font-bold leading-[42px] text-primary"
                                    >FASTRACK - VIP LINE&nbsp;</span
                                >
                            </div>
                            <p
                                class="text-[24px] font-semibold leading-[36px] text-[#F9F9F9]"
                            >
                                PENDIRIAN BADAN USAHA SELESAI DALAM 1 HARI
                            </p>
                        </div>
                        <p
                            class="text-[14px] font-light leading-[21px] text-[#F9F9F9] underline italic"
                        >
                            * (S&K BERLAKU)
                        </p>
                    </div>

                    <svg
                        class="hidden lg:block flex-shrink-0"
                        width="250"
                        height="200"
                        viewBox="0 0 90 100"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M40 0L0 50L40 100"
                            stroke="#F9F9F9"
                            stroke-width="20"
                            stroke-linecap="butt"
                            stroke-linejoin="miter"
                        />
                    </svg>

                    <a
                        href="/konsultasi"
                        class="hidden lg:inline-flex items-center justify-center gap-2 rounded-lg border border-[#F9F9F9] bg-[#E74247] px-[23px] h-[52px] hover:bg-[#d13a3f] transition-colors"
                    >
                        <span
                            class="text-[16px] font-semibold leading-[24px] text-[#F9F9F9]"
                            >Konsultasi Sekarang</span
                        >
                        <svg
                            class="w-6 h-6 text-[#F9F9F9]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"
                            />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- ===== 4. SUB-SERVICE CARDS ===== -->
        <section id="layanan" class="py-[52px]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex flex-col gap-8">
                    <div
                        class="flex items-center justify-between border-b border-[#D9DAD8] pb-4"
                    >
                        <h2
                            class="text-[24px] font-bold leading-[36px] text-[#1A1B18]"
                        >
                            Pilih Layanan Sesuai Dengan Kebutuhan Anda
                        </h2>
                        <div
                            class="hidden sm:flex items-center border border-[#D9DAD8] rounded-lg shadow-sm bg-[#FEFEFE] w-[300px] h-[46px] overflow-hidden"
                        >
                            <div
                                class="flex items-center gap-2 flex-grow px-3 py-3"
                            >
                                <svg
                                    class="h-5 w-5 text-[#42443D] flex-shrink-0"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                                <input
                                    v-model="serviceSearch"
                                    type="text"
                                    placeholder="Cari Layanan..."
                                    class="w-full border-none bg-transparent p-0 text-[14px] text-[#42443D] placeholder-[#42443D] focus:ring-0 focus:outline-none"
                                />
                            </div>
                        </div>
                    </div>

                    <div
                        v-for="(category, catIdx) in filteredCategories"
                        :key="catIdx"
                        class="flex flex-col gap-4"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <img
                                    src="/icons/ft-docs.svg"
                                    class="w-6 h-6"
                                    alt=""
                                />
                                <h3
                                    class="text-[18px] font-bold leading-[27px] text-[#1A1B18]"
                                >
                                    {{ category.title }}
                                </h3>
                            </div>
                            <a
                                :href="category.path"
                                class="hidden sm:inline-flex items-center gap-2 rounded-lg px-4 py-3 text-[14px] font-semibold text-primary hover:bg-[#E74247]/5 transition-colors"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 4v16m8-8H4"
                                    />
                                </svg>
                                SELENGKAPNYA
                            </a>
                        </div>

                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
                        >
                            <a
                                v-for="(item, itemIdx) in category.items"
                                :key="itemIdx"
                                :href="item.path"
                                class="group flex flex-col rounded-[14px] border border-[#D9DAD8] bg-[#FEFEFE] p-[15px] backdrop-blur-[13px] transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:border-primary/30"
                            >
                                <div class="flex flex-col gap-4 flex-grow">
                                    <div
                                        class="flex h-[60px] w-[60px] items-center justify-center rounded-lg bg-[#FAD9DA]"
                                    >
                                        <img
                                            :src="item.icon"
                                            class="w-6 h-6"
                                            alt=""
                                        />
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <h4
                                            class="text-[16px] font-bold leading-[24px] text-[#1A1B18]"
                                        >
                                            {{ item.title }}
                                        </h4>
                                        <p
                                            class="text-[14px] leading-[21px] text-[#282925] min-h-[63px]"
                                        >
                                            {{ item.description }}
                                        </p>
                                    </div>
                                </div>

                                <div class="relative my-4">
                                    <div
                                        class="h-px w-full bg-[#686964] opacity-30"
                                    ></div>
                                </div>

                                <div
                                    class="flex items-start justify-between gap-2"
                                >
                                    <div class="flex flex-col gap-0.5">
                                        <span
                                            class="text-[12px] leading-[18px] text-[#1A1B18]"
                                            >Mulai dari</span
                                        >
                                        <span
                                            class="text-[24px] font-bold leading-[36px] text-primary"
                                            >{{ item.price }}</span
                                        >
                                    </div>
                                    <span
                                        class="inline-flex items-center border border-[#D9DAD8] rounded bg-[#F9F9F9] px-[7px] py-[3px] text-[12px] leading-[18px] text-[#1A1B18]"
                                        >{{ item.packages }}</span
                                    >
                                </div>

                                <div
                                    class="mt-4 flex items-center justify-center gap-2 rounded-lg border border-primary px-[15px] py-[11px] h-[44px] text-[14px] font-semibold text-primary group-hover:bg-[#E74247] group-hover:text-white transition-colors"
                                >
                                    Lihat Selengkapnya
                                    <svg
                                        class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"
                                        />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center justify-center">
                        <a
                            href="/layanan"
                            class="inline-flex items-center justify-center gap-2 border border-primary rounded-lg px-[15px] py-[11px] h-[44px] text-[14px] font-semibold text-primary hover:bg-[#E74247] hover:text-white transition-colors"
                        >
                            Lihat Semua Layanan
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 5. PROMO SECTION ===== -->
        <section class="bg-[#42443D] pt-[52px] pb-[120px]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex items-center justify-between">
                    <h2
                        class="text-[24px] font-bold leading-[36px] text-[#F9F9F9]"
                    >
                        Dapatkan Penawaran Menarik dari Kami!
                    </h2>
                    <a
                        href="/promo"
                        class="hidden sm:inline-flex items-center gap-2 border border-[#F9F9F9] rounded-lg px-[11px] py-[11px] h-[44px] text-[14px] font-semibold text-[#F9F9F9] hover:bg-white/10 transition-colors"
                    >
                        Lihat Semua Promo
                        <svg
                            class="w-6 h-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"
                            />
                        </svg>
                    </a>
                </div>

                <div
                    class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 bg-white/[0.01] rounded-b-2xl backdrop-blur-[13px]"
                >
                    <a
                        v-for="i in 4"
                        :key="i"
                        href="/promo"
                        class="group relative flex flex-col rounded-lg bg-[#FEFEFE] p-4 gap-4 hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5"
                    >
                        <div
                            class="relative flex flex-col items-center justify-end h-[80px] gap-2"
                        >
                            <span
                                class="absolute -top-4 left-1/2 -translate-x-1/2 inline-flex items-center justify-center rounded-b-lg bg-[#FED7DA] px-3 py-1 h-[26px] text-[10px] font-semibold leading-[18px] text-[#FB3748]"
                                >PROMO SPECIAL</span
                            >
                            <div class="flex flex-col items-center gap-1">
                                <h3
                                    class="text-[16px] font-bold leading-[24px] text-[#1A1B18]"
                                >
                                    HEMAT HINGGA 30%
                                </h3>
                                <p
                                    class="text-[14px] leading-[21px] text-[#1A1B18] text-center"
                                >
                                    Untuk pendirian PT + Virtual Office
                                </p>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-center rounded-lg border border-primary px-[15px] py-[11px] h-[44px] text-[14px] font-semibold text-primary group-hover:bg-[#E74247] group-hover:text-white transition-colors"
                        >
                            Dapatkan Promo
                        </div>
                    </a>
                </div>

                <a
                    href="/promo"
                    class="sm:hidden mt-6 inline-flex items-center gap-2 border border-[#F9F9F9] rounded-lg px-[11px] py-[11px] h-[44px] text-[14px] font-semibold text-[#F9F9F9] hover:bg-white/10 transition-colors w-full justify-center"
                >
                    Lihat Semua Promo
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"
                        />
                    </svg>
                </a>
            </div>
        </section>

        <!-- ===== 6. TENTANG KAMI ===== -->
        <section class="py-[52px] bg-[#F9F9F9]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
                <div class="flex flex-col gap-12">
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start"
                    >
                        <!-- Image -->
                        <div>
                            <img
                                src="/images/ft-img-tentang-kami.png"
                                alt="Tim FastTrack di kantor"
                                class="w-full h-[300px] md:h-[386px] rounded-2xl object-cover"
                                loading="lazy"
                            />
                        </div>

                        <!-- Text -->
                        <div class="flex flex-col justify-center">
                            <div class="flex flex-col gap-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-1 w-8 rounded-full bg-primary"
                                    ></div>
                                    <h2
                                        class="text-[28px] font-bold leading-[36px] text-[#1A1B18]"
                                    >
                                        Tentang Kami
                                    </h2>
                                </div>

                                <div class="space-y-3">
                                    <p
                                        class="text-[14px] leading-[22px] text-[#4A4B47] text-justify"
                                    >
                                        Fastrack.legal adalah perusahaan yang
                                        telah berdiri sejak 2001 yang bergerak
                                        di bidang layanan jasa perizinan usaha
                                        tidak terbatas antara lain Konsultasi
                                        Hukum Investasi &amp; Bisnis, Pendirian
                                        Perusahaan, Perizinan Perusahaan,
                                        Perubahan/Perluasan/Restrukturisasi,
                                        Pendaftaran HKI, Virtual Office,
                                        Sekretaris Perusahaan &amp; Layanan
                                        Dukungan Bisnis, Uji Tuntas Hukum, Izin
                                        Kerja &amp; Tinggal Tenaga Kerja Asing,
                                        Visa, Visa Lansia, Naturalisasi (Alih
                                        Kewarganegaraan), Perjanjian Kawin,
                                        Pendaftaran Perkawinan, Penyusunan
                                        Laporan Keuangan &amp; Laporan
                                        Perpajakan yang didasarkan dan mengacu
                                        pada undang-undang yang ditetapkan.
                                    </p>
                                    <p
                                        class="text-[14px] leading-[22px] text-[#4A4B47] text-justify"
                                    >
                                        Telah membantu lebih dari 13.000 klien
                                        dengan berbagai layanan kami.
                                        Fastrack.legal berupaya dan bertekad
                                        untuk menjadi gerbang utama kepada siapa
                                        pun yang ingin memulai bisnis dan
                                        membutuhkan layanan jasa perizinan dan
                                        hukum di Indonesia.
                                    </p>
                                </div>

                                <!-- Stats -->
                                <div class="flex items-center gap-5 pt-3">
                                    <div
                                        class="flex flex-col items-center gap-0.5 min-w-[100px]"
                                    >
                                        <span
                                            class="text-[26px] font-bold leading-tight text-primary"
                                            >20+</span
                                        >
                                        <span
                                            class="text-[12px] text-[#4A4B47] text-center"
                                            >Tahun Pengalaman</span
                                        >
                                    </div>
                                    <div class="h-12 w-px bg-[#D9DAD8]"></div>
                                    <div
                                        class="flex flex-col items-center gap-0.5 min-w-[100px]"
                                    >
                                        <span
                                            class="text-[26px] font-bold leading-tight text-primary"
                                            >10+</span
                                        >
                                        <span
                                            class="text-[12px] text-[#4A4B47] text-center"
                                            >Virtual Office</span
                                        >
                                    </div>
                                    <div class="h-12 w-px bg-[#D9DAD8]"></div>
                                    <div
                                        class="flex flex-col items-center gap-0.5 min-w-[110px]"
                                    >
                                        <span
                                            class="text-[26px] font-bold leading-tight text-primary"
                                            >10.000+</span
                                        >
                                        <span
                                            class="text-[12px] text-[#4A4B47] text-center"
                                            >Klien bisnis dilayani</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div
                            class="flex flex-col justify-center gap-1 border border-[#D9DAD8] rounded-xl bg-[#FEFEFE] px-[23px] py-[15px]"
                        >
                            <h3
                                class="text-[24px] font-bold leading-[36px] text-primary"
                            >
                                Filosofi
                            </h3>
                            <p
                                class="text-[14px] leading-[21px] text-[#1A1B18]"
                            >
                                "Memastikan bahwa penganggaran yang efektif dan
                                efisien akan mengoptimalkan layanan yang baik,
                                memberikan kepuasan kepada klien setia dan
                                mendapatkan klien baru."
                            </p>
                        </div>
                        <div
                            class="flex flex-col justify-center gap-1 border border-[#D9DAD8] rounded-xl bg-[#FEFEFE] px-[23px] py-[15px]"
                        >
                            <h3
                                class="text-[24px] font-bold leading-[36px] text-primary"
                            >
                                Visi &amp; Misi
                            </h3>
                            <p
                                class="text-[14px] leading-[21px] text-[#1A1B18]"
                            >
                                "Memberikan upaya terbaik untuk meningkatkan
                                integritas, kemandirian, dan mampu memberikan
                                layanan kepada klien kami dengan solusi yang
                                tidak diragukan."
                            </p>
                        </div>
                        <div
                            class="flex flex-col justify-center gap-1 border border-[#D9DAD8] rounded-xl bg-[#FEFEFE] px-[23px] py-[15px]"
                        >
                            <h3
                                class="text-[24px] font-bold leading-[36px] text-primary"
                            >
                                Komitmen
                            </h3>
                            <p
                                class="text-[14px] leading-[21px] text-[#1A1B18]"
                            >
                                "FASTTRACK selalu mempersiapkan dengan baik
                                dalam memberikan solusi terbaik untuk klien kami
                                dengan melakukan observasi secara mendalam."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 7. WHY CHOOSE US ===== -->
        <section class="py-[52px] bg-[#E74247]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
                <div class="flex flex-col items-center gap-8">
                    <div
                        class="flex flex-col items-center gap-2.5 text-center px-4 lg:px-[282px]"
                    >
                        <h2
                            class="text-[28px] font-bold leading-[42px] text-[#F9F9F9]"
                        >
                            Mengapa Memilih Fasttrack?
                        </h2>
                        <p
                            class="text-[16px] leading-[24px] text-[#F9F9F9] max-w-[708px]"
                        >
                            Profesional, Mudah, Cepat, Inovatif, Berkualitas,
                            Kompetitif, Ramah serta selalu memahami harapan
                            klien, dan berkomitmen untuk memberikan solusi
                            bisnis yang terbaik namun hemat.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-1 sm:grid-cols-3 gap-6 self-stretch bg-white/[0.01] rounded-b-2xl backdrop-blur-[13px]"
                    >
                        <div class="flex flex-col">
                            <div class="h-1.5 rounded-t-2xl bg-[#DD0417]"></div>
                            <div
                                class="flex flex-col gap-3 rounded-b-xl bg-[#FEFEFE] p-4 backdrop-blur-[13px]"
                            >
                                <span
                                    class="text-[28px] font-bold leading-[42px] text-primary"
                                    >10.000+</span
                                >
                                <div class="flex flex-col gap-2">
                                    <h3
                                        class="text-[18px] font-semibold leading-[27px] text-[#282925]"
                                    >
                                        Portofolio terbukti
                                    </h3>
                                    <p
                                        class="text-[14px] leading-[21px] text-[#42443D]"
                                    >
                                        Lebih dari 10.000 klien telah
                                        mempercayakan kebutuhan legalitas bisnis
                                        mereka kepada kami.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="h-1.5 rounded-t-2xl bg-[#DD0417]"></div>
                            <div
                                class="flex flex-col gap-3 rounded-b-xl bg-[#FEFEFE] p-4 backdrop-blur-[13px]"
                            >
                                <span
                                    class="text-[28px] font-bold leading-[42px] text-primary"
                                    >20 thn</span
                                >
                                <div class="flex flex-col gap-2">
                                    <h3
                                        class="text-[18px] font-semibold leading-[27px] text-[#282925]"
                                    >
                                        Berpengalaman
                                    </h3>
                                    <p
                                        class="text-[14px] leading-[21px] text-[#42443D]"
                                    >
                                        Pengalaman lebih dari 20 tahun
                                        menjadikan kami mitra hukum bisnis yang
                                        tepat dan terpercaya.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="h-1.5 rounded-t-2xl bg-[#DD0417]"></div>
                            <div
                                class="flex flex-col gap-3 rounded-b-xl bg-[#FEFEFE] p-4 backdrop-blur-[13px]"
                            >
                                <span
                                    class="text-[28px] font-bold leading-[42px] text-primary"
                                    >99,9%</span
                                >
                                <div class="flex flex-col gap-2">
                                    <h3
                                        class="text-[18px] font-semibold leading-[27px] text-[#282925]"
                                    >
                                        Tingkat kepuasan klien
                                    </h3>
                                    <p
                                        class="text-[14px] leading-[21px] text-[#42443D]"
                                    >
                                        98% klien kami puas dengan layanan dan
                                        kecepatan penyelesaian proses legalitas
                                        bisnis mereka.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-start self-stretch gap-6">
                        <div
                            class="flex items-center justify-center gap-2.5 self-stretch"
                        >
                            <div class="flex-grow h-px bg-[#D9DAD8]"></div>
                            <span
                                class="text-[24px] font-semibold leading-[36px] text-[#F9F9F9] whitespace-nowrap"
                                >Keunggulan layanan</span
                            >
                            <div class="flex-grow h-px bg-[#D9DAD8]"></div>
                        </div>

                        <div
                            class="flex flex-col sm:flex-row items-start self-stretch border border-[#D9DAD8] rounded-xl px-[15px] py-[17px] backdrop-blur-[13px]"
                        >
                            <div
                                class="flex flex-col items-center flex-grow gap-3 py-2"
                            >
                                <svg
                                    class="w-12 h-12 text-[#F9F9F9]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <h3
                                    class="text-[18px] font-semibold leading-[27px] text-[#FEFEFE]"
                                >
                                    Tepat waktu
                                </h3>
                                <p
                                    class="text-[14px] leading-[21px] text-[#F9F9F9] text-center max-w-[219px]"
                                >
                                    Penyelesaian sesuai komitmen, tanpa
                                    penundaan
                                </p>
                            </div>
                            <div
                                class="hidden sm:block w-px self-stretch bg-[#D9DAD8]"
                            ></div>
                            <div
                                class="flex flex-col items-center flex-grow gap-3 py-2"
                            >
                                <svg
                                    class="w-12 h-12 text-[#F9F9F9]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                    />
                                </svg>
                                <h3
                                    class="text-[18px] font-semibold leading-[27px] text-[#FEFEFE]"
                                >
                                    Tim profesional
                                </h3>
                                <p
                                    class="text-[14px] leading-[21px] text-[#F9F9F9] text-center max-w-[229px]"
                                >
                                    Konsultan tersertifikasi &amp;
                                    berkualifikasi multinasional
                                </p>
                            </div>
                            <div
                                class="hidden sm:block w-px self-stretch bg-[#D9DAD8]"
                            ></div>
                            <div
                                class="flex flex-col items-center flex-grow gap-3 py-2"
                            >
                                <svg
                                    class="w-12 h-12 text-[#F9F9F9]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                                    />
                                </svg>
                                <h3
                                    class="text-[18px] font-semibold leading-[27px] text-[#FEFEFE]"
                                >
                                    Harga kompetitif
                                </h3>
                                <p
                                    class="text-[14px] leading-[21px] text-[#F9F9F9] text-center max-w-[190px]"
                                >
                                    Transparan, bersahabat, tanpa biaya
                                    tersembunyi
                                </p>
                            </div>
                            <div
                                class="hidden sm:block w-px self-stretch bg-[#D9DAD8]"
                            ></div>
                            <div
                                class="flex flex-col items-center flex-grow gap-3 py-2"
                            >
                                <svg
                                    class="w-12 h-12 text-[#F9F9F9]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                                <h3
                                    class="text-[18px] font-semibold leading-[27px] text-[#FEFEFE]"
                                >
                                    Jangkauan Nasional
                                </h3>
                                <p
                                    class="text-[14px] leading-[21px] text-[#F9F9F9] text-center max-w-[210px]"
                                >
                                    Melayani klien dari seluruh wilayah
                                    Indonesia
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 8. TOOLS SECTION ===== -->
        <section class="pt-[52px] pb-0 bg-[#F9F9F9]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
                <div class="flex flex-col items-center gap-8 pb-10">
                    <h2
                        class="text-[28px] font-bold leading-[42px] text-[#1A1B18] text-center"
                    >
                        Peralatan dan Fitur Gratis untuk Kemudahan Bisnis Anda
                    </h2>

                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 self-stretch rounded-b-2xl"
                    >
                        <a
                            v-for="tool in tools"
                            :key="tool.title"
                            :href="tool.path"
                            class="group flex flex-col rounded-[14px] bg-[#FEFEFE] p-5 gap-3 border border-slate-100 hover:shadow-lg hover:shadow-primary/5 hover:-translate-y-0.5 hover:border-primary/20 transition-all duration-200"
                        >
                            <!-- Icon -->
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-lg p-2.5"
                                :style="{ backgroundColor: tool.bg }"
                            >
                                <svg
                                    v-if="tool.icon === 'check-circle'"
                                    class="h-5 w-5"
                                    :style="{ color: tool.iconColor }"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <svg
                                    v-else-if="tool.icon === 'book'"
                                    class="h-5 w-5"
                                    :style="{ color: tool.iconColor }"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                    />
                                </svg>
                                <svg
                                    v-else-if="tool.icon === 'clipboard'"
                                    class="h-5 w-5"
                                    :style="{ color: tool.iconColor }"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                                    />
                                </svg>
                                <svg
                                    v-else-if="tool.icon === 'file-edit'"
                                    class="h-5 w-5"
                                    :style="{ color: tool.iconColor }"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    />
                                </svg>
                                <svg
                                    v-else
                                    class="h-5 w-5"
                                    :style="{ color: tool.iconColor }"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                    />
                                </svg>
                            </div>

                            <!-- Text content -->
                            <div class="flex flex-col gap-1 flex-1">
                                <h3
                                    class="text-sm font-bold leading-snug text-[#1A1B18]"
                                >
                                    {{ tool.title }}
                                </h3>
                                <p
                                    class="text-sm leading-relaxed text-slate-500"
                                >
                                    {{ tool.description }}
                                </p>
                            </div>

                            <!-- CTA -->
                            <span
                                class="text-xs font-semibold text-primary mt-auto pt-1"
                            >
                                {{ tool.cta }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 9. VIRTUAL OFFICE ===== -->
        <section class="py-[52px] bg-[#42443D]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
                <div class="flex flex-col items-center gap-8">
                    <h2
                        class="text-[28px] font-bold leading-[42px] text-[#F9F9F9] text-center"
                    >
                        Alamat Bisnis Prestisius di Lokasi Strategis
                    </h2>

                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 self-stretch bg-white/[0.01] rounded-b-2xl backdrop-blur-[13px]"
                    >
                        <a
                            v-for="office in virtualOffices"
                            :key="office.name"
                            href="/virtual-office-jakarta"
                            class="group flex flex-col justify-between rounded-xl h-[300px] bg-cover bg-center bg-no-repeat backdrop-blur-[10px] overflow-hidden"
                            :style="{ backgroundImage: `url(${office.image})` }"
                        >
                            <div class="flex flex-col items-end p-4">
                                <span
                                    class="inline-flex items-center justify-center rounded-lg bg-[#32DE83] px-3 py-1 text-[12px] font-semibold leading-[18px] text-[#F9F9F9]"
                                    >{{ office.status }}</span
                                >
                            </div>
                            <div
                                class="flex flex-col gap-3 rounded-b-xl bg-white/[0.01] backdrop-blur-[13px] p-4"
                            >
                                <h3
                                    class="text-[16px] font-bold leading-[24px] text-[#F9F9F9]"
                                >
                                    {{ office.name }}
                                </h3>
                                <div class="flex items-center gap-2">
                                    <svg
                                        class="w-[18px] h-[18px] text-[#F9F9F9] flex-shrink-0"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                    <span
                                        class="text-[14px] leading-[21px] text-[#F9F9F9]"
                                        >{{ office.location }}</span
                                    >
                                </div>
                                <span
                                    class="inline-flex items-center justify-center self-start rounded-lg bg-[#A8BDED] px-2.5 py-1 text-[12px] leading-[18px] text-[#314777]"
                                    >{{ office.kpp }}</span
                                >
                            </div>
                        </a>
                    </div>

                    <a
                        href="/virtual-office-jakarta"
                        class="inline-flex items-center gap-2 rounded-lg py-3 text-[14px] font-semibold text-primary hover:underline"
                    >
                        Lihat Semua Lokasi
                        <svg
                            class="w-6 h-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"
                            />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- ===== 10. BLOG ARTIKEL ===== -->
        <section class="py-[52px] bg-[#F9F9F9]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
                <div class="flex flex-col gap-6">
                    <div class="flex items-center justify-between">
                        <h2
                            class="text-[28px] font-bold leading-[42px] text-[#1A1B18]"
                        >
                            Wawasan Hukum & Bisnis Terkini
                        </h2>
                        <a
                            href="/artikel"
                            class="inline-flex items-center gap-2 border border-[#E74247] text-[#E74247] hover:bg-[#E74247] hover:text-white font-semibold text-sm px-[11px] h-[44px] rounded-lg transition-colors"
                        >
                            Lihat Semua Artikel
                            <svg
                                class="w-6 h-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </a>
                    </div>

                    <div
                        class="flex flex-col gap-6 bg-[#ffffff03] backdrop-blur-[13px] rounded-b-2xl"
                    >
                        <div
                            class="flex flex-col gap-6 border border-[#D9DAD8] rounded-xl bg-[#FEFEFE] p-[23px]"
                        >
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col gap-1">
                                    <h3
                                        class="text-[24px] font-bold leading-[36px] text-[#1A1B18]"
                                    >
                                        RUPS TAHUNAN KINI WAJIB DI BUAT AKTA DAN
                                        DILAPORAKAN!
                                    </h3>
                                    <p
                                        class="text-[14px] leading-[21px] text-[#1A1B18]"
                                    >
                                        Semua yang perlu Anda ketahui tentang
                                        syarat, dokumen, biaya, dan proses
                                        mendirikan PT PMDN secara legal dan
                                        efisien...
                                    </p>
                                </div>
                                <div class="inline-flex items-center gap-1">
                                    <svg
                                        class="w-5 h-5 text-[#8E8F8B]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <span
                                        class="text-[12px] font-semibold leading-[18px] text-[#8E8F8B]"
                                        >12 Mei 2025</span
                                    >
                                </div>
                            </div>
                            <a
                                href="/artikel/1"
                                class="inline-flex items-center gap-2 text-[14px] font-semibold text-[#E74247] hover:underline w-max"
                            >
                                Baca Selengkapnya
                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </a>
                        </div>

                        <div
                            class="flex flex-col gap-6 border border-[#D9DAD8] rounded-xl bg-[#FEFEFE] p-[23px]"
                        >
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col gap-1">
                                    <h3
                                        class="text-[24px] font-bold leading-[36px] text-[#1A1B18]"
                                    >
                                        KEWAJIBAN MELAKUKAN PENDAFTARAN PENERIMA
                                        MANFAAT PERSEROAN
                                    </h3>
                                    <p
                                        class="text-[14px] leading-[21px] text-[#1A1B18]"
                                    >
                                        Semua yang perlu Anda ketahui tentang
                                        syarat, dokumen, biaya, dan proses
                                        mendirikan PT PMDN secara legal dan
                                        efisien...
                                    </p>
                                </div>
                                <div class="inline-flex items-center gap-1">
                                    <svg
                                        class="w-5 h-5 text-[#8E8F8B]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <span
                                        class="text-[12px] font-semibold leading-[18px] text-[#8E8F8B]"
                                        >12 Mei 2025</span
                                    >
                                </div>
                            </div>
                            <a
                                href="/artikel/2"
                                class="inline-flex items-center gap-2 text-[14px] font-semibold text-[#E74247] hover:underline w-max"
                            >
                                Baca Selengkapnya
                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 11. KLIEN & PARTNER ===== -->
        <section
            class="bg-[#42443D] py-10 sm:pt-[52px] sm:pb-10 overflow-hidden"
        >
            <div class="flex flex-col items-center gap-6 sm:gap-8">
                <h2
                    class="text-[24px] sm:text-[28px] font-bold leading-[42px] text-[#F9F9F9]"
                >
                    Klien Kami
                </h2>

                <div class="flex flex-col gap-4 sm:gap-5 md:gap-6 w-full">
                    <div
                        v-for="row in marqueeRows"
                        :key="row.id"
                        class="marquee-row"
                    >
                        <div class="marquee-fade-left"></div>
                        <div
                            :class="[
                                'marquee-track',
                                row.reverse
                                    ? 'animate-marquee-reverse'
                                    : 'animate-marquee',
                            ]"
                        >
                            <div class="marquee-set">
                                <div
                                    v-for="i in 8"
                                    :key="row.id + '-' + i"
                                    class="marquee-card"
                                >
                                    <img src="/images/DUMMY.png" alt="Klien" />
                                </div>
                            </div>
                            <div class="marquee-set" aria-hidden="true">
                                <div
                                    v-for="i in 8"
                                    :key="row.id + '-d' + i"
                                    class="marquee-card"
                                >
                                    <img src="/images/DUMMY.png" alt="Klien" />
                                </div>
                            </div>
                        </div>
                        <div class="marquee-fade-right"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 12. AFILIASI ===== -->
        <section class="bg-[#F9F9F9] pt-[52px] pb-0 overflow-hidden">
            <div class="flex flex-col items-center gap-8">
                <h2 class="text-[28px] font-bold leading-[42px] text-[#1A1B18]">
                    Afiliasi
                </h2>
                <div
                    class="flex items-center justify-center gap-12 w-full bg-[#ffffff03] backdrop-blur-[13px] rounded-b-2xl overflow-hidden px-[84px] pb-[52px]"
                >
                    <div
                        v-for="i in 4"
                        :key="i"
                        class="flex-shrink-0 w-[200px] rounded-xl bg-[#D9DAD8] p-2"
                    >
                        <div
                            class="w-[185px] h-[62px] flex items-center justify-center"
                        >
                            <span
                                class="text-base font-black text-[#1A1B18] uppercase"
                                >DUMMY</span
                            >
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== 13. KONTAK SECTION ===== -->
        <section class="py-[52px] bg-[#42443D] mb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Left: Form -->
                    <div
                        class="flex-1 flex flex-col justify-center bg-[#FEFEFE] rounded-xl p-6 gap-8 shadow-[0px_1px_2px_0px_#0000004d,0px_1px_3px_1px_#00000026]"
                    >
                        <h2
                            class="text-[24px] font-bold leading-[36px] text-[#1A1B18]"
                        >
                            Special Promo & Penawaran Menarik
                        </h2>
                        <form @submit.prevent class="flex flex-col gap-4">
                            <div class="flex flex-col gap-4">
                                <div
                                    class="flex items-center h-[44px] rounded-lg bg-white outline outline-1 outline-[#E9EAEB] overflow-hidden"
                                >
                                    <input
                                        type="text"
                                        placeholder="Nama Lengkap"
                                        class="flex-1 px-3 py-3 text-[14px] text-[#8E8F8B] bg-transparent outline-none placeholder-[#8E8F8B]"
                                        required
                                    />
                                </div>
                                <div
                                    class="flex items-center h-[44px] rounded-lg bg-white outline outline-1 outline-[#E9EAEB] overflow-hidden"
                                >
                                    <input
                                        type="email"
                                        placeholder="Alamat Email"
                                        class="flex-1 px-3 py-3 text-[14px] text-[#8E8F8B] bg-transparent outline-none placeholder-[#8E8F8B]"
                                        required
                                    />
                                </div>
                                <div
                                    class="flex items-center h-[44px] rounded-lg bg-white outline outline-1 outline-[#E9EAEB] overflow-hidden"
                                >
                                    <input
                                        type="tel"
                                        placeholder="Nomor Whatsapp"
                                        class="flex-1 px-3 py-3 text-[14px] text-[#8E8F8B] bg-transparent outline-none placeholder-[#8E8F8B]"
                                        required
                                    />
                                </div>
                                <div
                                    class="flex items-center h-[44px] rounded-lg bg-white outline outline-1 outline-[#E9EAEB] overflow-hidden"
                                >
                                    <input
                                        type="text"
                                        placeholder="Bidang Usaha"
                                        class="flex-1 px-3 py-3 text-[14px] text-[#8E8F8B] bg-transparent outline-none placeholder-[#8E8F8B]"
                                    />
                                </div>
                                <div
                                    class="relative rounded-lg bg-white outline outline-1 outline-[#E9EAEB] overflow-hidden"
                                >
                                    <textarea
                                        rows="5"
                                        placeholder="Pesan / Kebutuhan Layanan"
                                        class="w-full px-4 py-3 text-[14px] text-[#8E8F8B] bg-transparent outline-none placeholder-[#8E8F8B] resize-none"
                                        required
                                    ></textarea>
                                    <svg
                                        class="absolute right-3 bottom-3 w-2 h-2 text-[#8E8F8B]"
                                        viewBox="0 0 8 8"
                                        fill="currentColor"
                                    >
                                        <path
                                            d="M6 0L8 2V8H6V0ZM0 6L2 8H8V6H0Z"
                                        />
                                    </svg>
                                </div>
                            </div>
                            <div
                                class="flex items-center h-[53px] rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] px-3"
                            >
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-[14px] h-[14px] rounded-sm outline outline-1 outline-[#D9DAD8] bg-[#F9F9F9] shadow-sm"
                                    ></div>
                                    <span class="text-[12px] text-[#8E8F8B]"
                                        >I'm not a robot</span
                                    >
                                </div>
                                <div class="ml-auto flex flex-col items-center">
                                    <svg
                                        class="w-8 h-8 text-[#4A90D9]"
                                        viewBox="0 0 38 38"
                                        fill="none"
                                    >
                                        <path
                                            d="M19 4C10.716 4 4 10.716 4 19C4 27.284 10.716 34 19 34C27.284 34 34 27.284 34 19"
                                            stroke="currentColor"
                                            stroke-width="2.5"
                                            stroke-linecap="round"
                                        />
                                        <path
                                            d="M34 19C34 15.5 32.5 12.3 30 10"
                                            stroke="#E74247"
                                            stroke-width="2.5"
                                            stroke-linecap="round"
                                        />
                                    </svg>
                                    <span
                                        class="text-[8px] text-[#8E8F8B] leading-none"
                                        >reCAPTCHA</span
                                    >
                                    <span
                                        class="text-[6px] text-[#8E8F8B] leading-none"
                                        >Privacy - Terms</span
                                    >
                                </div>
                            </div>
                            <div class="flex flex-col gap-4">
                                <label
                                    class="inline-flex items-center gap-[9px]"
                                >
                                    <div
                                        class="w-[14px] h-[14px] flex-shrink-0 rounded-sm outline outline-1 outline-[#D9DAD8] bg-[#F9F9F9] shadow-sm"
                                    ></div>
                                    <span class="text-[12px] text-[#1A1B18]"
                                        >Saya telah membaca dan setuju
                                    </span>
                                    <span
                                        class="text-[12px] text-[#E74247] cursor-pointer"
                                        >Ketentuan Legal*</span
                                    >
                                </label>
                                <button
                                    type="submit"
                                    class="w-full h-[44px] flex items-center justify-center rounded-lg bg-[#E74247] hover:bg-red-600 transition-colors"
                                >
                                    <span
                                        class="text-[14px] font-semibold leading-[21px] text-[#F9F9F9]"
                                        >Submit</span
                                    >
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Contact info + Map -->
                    <div class="flex-1 flex flex-col gap-6">
                        <div
                            class="bg-[#FEFEFE] rounded-xl p-6 flex flex-col gap-6 shadow-[0px_1px_2px_0px_#0000004d,0px_1px_3px_1px_#00000026]"
                        >
                            <h3
                                class="text-[18px] font-bold leading-[27px] text-[#1A1B18]"
                            >
                                Hubungi Kami
                            </h3>
                            <div class="flex flex-col gap-4">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-full bg-[#FAD9DA] flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 text-[#E74247]"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                            />
                                        </svg>
                                    </div>
                                    <p
                                        class="text-[14px] leading-[21px] text-[#1A1B18]"
                                    >
                                        Grand Bintaro Blok A7, JI. Raya Bintaro
                                        Permai, Pesanggrahan, Bintaro, Jakarta
                                        Selatan - 12330
                                    </p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-full bg-[#FAD9DA] flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 text-[#E74247]"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                            />
                                        </svg>
                                    </div>
                                    <a
                                        href="tel:02173885036"
                                        class="text-[14px] leading-[21px] text-[#1A1B18] hover:text-[#E74247]"
                                        >0217 3885 036</a
                                    >
                                </div>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-full bg-[#FAD9DA] flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 text-[#E74247]"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"
                                            />
                                        </svg>
                                    </div>
                                    <a
                                        href="https://wa.me/6282298604144"
                                        class="text-[14px] leading-[21px] text-[#1A1B18] hover:text-[#E74247]"
                                        >0822 9860 4144</a
                                    >
                                </div>
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 rounded-full bg-[#FAD9DA] flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 text-[#E74247]"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                            />
                                        </svg>
                                    </div>
                                    <a
                                        href="mailto:cs@fasttrack.legal"
                                        class="text-[14px] leading-[21px] text-[#1A1B18] hover:text-[#E74247]"
                                        >cs@fasttrack.legal</a
                                    >
                                </div>
                            </div>
                        </div>

                        <div
                            class="relative flex-1 min-h-[280px] rounded-xl overflow-hidden shadow-[0px_1px_2px_0px_#0000004d,0px_1px_3px_1px_#00000026] flex items-center justify-center bg-[#00000066]"
                            style="
                                background-image: url(&quot;https://coresg-normal.trae.ai/api/ide/v1/text_to_image?prompt=google%20maps%20aerial%20view%20jakarta%20south%20indonesia%20city%20streets%20satellite%20realistic&image_size=landscape_4_3&quot;);
                                background-size: cover;
                                background-position: center;
                            "
                        >
                            <div class="absolute inset-0 bg-black/40"></div>
                            <div
                                class="relative z-10 flex flex-col items-center gap-1"
                            >
                                <div
                                    class="w-[60px] h-[60px] rounded-full bg-[#D9DAD8] flex items-center justify-center"
                                >
                                    <svg
                                        class="w-8 h-8 text-[#42443D]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                </div>
                                <p
                                    class="text-[16px] font-bold leading-[24px] text-[#FAFAFA]"
                                >
                                    HEAD OFFICE FASTTRACK
                                </p>
                            </div>
                            <a
                                href="https://maps.google.com/?q=Grand+Bintaro+Jakarta+Selatan"
                                target="_blank"
                                class="absolute top-[10px] left-[14px] z-10 inline-flex items-center gap-1 bg-[#F9F9F9] rounded-lg px-[10px] h-[29px]"
                            >
                                <svg
                                    class="w-4 h-4 text-[#0077FF]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                    />
                                </svg>
                                <span
                                    class="text-[14px] text-[#0077FF] leading-[21px]"
                                    >Open in Maps</span
                                >
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
