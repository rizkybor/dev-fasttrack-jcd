<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
    services: {
        type: Array,
        default: () => [],
    },
});

const whatsappNumber = "6282298604144";

const formatPrice = (price) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        maximumFractionDigits: 0,
    }).format(price);
};

const buildWhatsappLink = (serviceName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai layanan ${serviceName}.`;

    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

const goToService = (serviceSlug) => {
    window.location.href = `/layanan/${serviceSlug}`;
};

const trustPoints = [
    "Pilihan layanan legalitas dan perizinan untuk berbagai kebutuhan bisnis",
    "Alur layanan lebih jelas, efisien, dan nyaman diikuti",
    "Siap membantu dari tahap konsultasi awal sampai tindak lanjut dokumen",
];

const serviceCategories = [
    {
        title: "BISNIS & KORPORASI",
        path: "/",
        items: [
            {
                title: "Badan Usaha",
                description:
                    "Pendirian PT Perorangan, PT PMDN, PT PMA, CV, hingga Yayasan.",
                price: "Rp 750.000",
                packages: "8 Layanan",
                path: "/badan-usaha",
                image: "/images/layanan-card/layanan-bu.png",
            },
            {
                title: "Kantor Perwakilan",
                description:
                    "KPPA, KPPPA, dan perwakilan perusahaan asing di Indonesia.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/kantor-perwakilan",
                image: "/images/layanan-card/layanan-kantor-perwakilan.png",
            },
            {
                title: "Badan Hukum Luar Negeri",
                description:
                    "Registrasi badan hukum asing yang beroperasi di wilayah Indonesia.",
                price: "Rp 750.000",
                packages: "2 Layanan",
                path: "/badan-hukum-luar-negeri",
                image: "/images/layanan-card/layanan-badan-hukum-luar-negeri.png",
            },
            {
                title: "Online Single Submission",
                description:
                    "Pendaftaran NIB, perubahan data usaha, dan perizinan via OSS.",
                price: "Rp 750.000",
                packages: "2 Layanan",
                path: "/one-single-submission",
                image: "/images/layanan-card/layanan-one-single-submission.png",
            },
            {
                title: "Perizinan",
                description:
                    "Izin dasar, izin berusaha sektoral, dan perizinan berusaha penunjang.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/",
                image: "/images/layanan-card/layanan-perizinan.png",
            },
            {
                title: "Perizinan Lainnya",
                description:
                    "NPWP badan, SKD, Tanda Daftar Yayasan, dan Peraturan Perusahaan.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/",
                image: "/images/layanan-card/layanan-perizinan-lainnya.png",
            },
            {
                title: "Notaris Virtual",
                description:
                    "Akta pendirian, perubahan AD, RUPS, jual beli, hingga perjanjian kawin.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/",
                image: "/images/layanan-card/layanan-notaris-virtual.png",
            },
            {
                title: "Restrukturisasi Perseroan Terbatas",
                description:
                    "Akuisisi, merger, dan perubahan struktur perseroan secara legal.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/",
                image: "/images/layanan-card/layanan-restrukturisasi-perseroan-terbatas.png",
            },
            {
                title: "Penutupan Badan Usaha",
                description:
                    "Penutupan PT PMDN, PT PMA, CV, dan kantor perwakilan asing.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/",
                image: "/images/layanan-card/layanan-penutupan-badan-usaha.png",
            },
            {
                title: "Kewajiban Pelaporan Perusahaan",
                description:
                    "LKPM, SIINAS, wajib lapor ketenagakerjaan &  kesejahteraan.",
                price: "Rp 750.000",
                packages: "3 Layanan",
                path: "/kewajiban-pelaporan-perusahaan",
                image: "/images/layanan-card/layanan-kewajiban-pelaporan-perusahaan.png",
            },
            {
                title: "Sertifikasi Badan Usaha",
                description:
                    "Sertifikasi Kamar Dagang dan Industri (KADIN) untuk badan usaha.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/",
                image: "/images/layanan-card/layanan-sertifikasi-badan-usaha.png",
            },
            {
                title: "Retainer / Berlangganan",
                description:
                    "Layanan pendampingan hukum korporasi berkelanjutan.",
                price: "Rp 750.000",
                packages: "1 Layanan",
                path: "/retainer-berlangganan/1",
                image: "/images/layanan-card/layanan-retainer-berlangganan.png",
            },
            {
                title: "Virtual Office",
                description:
                    "Penutupan PT PMDN, PT PMA, CV, dan kantor perwakilan asing.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/",
                image: "/images/layanan-card/layanan-virtual-office.png",
            },
            {
                title: "Design & Digital Marketing",
                description:
                    "LKPM, SIINAS, wajib lapor ketenagakerjaan &  kesejahteraan.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/",
                image: "/images/layanan-card/layanan-design-digmart.png",
            },
        ],
    },
    {
        title: "HUKUM & KONTRAK",
        path: "/",
        items: [
            {
                title: "Penyusunan & Peninjauan Perjanjian",
                description:
                    "Drafting dan review kontrak kerja, investasi, JV, waralaba, dan lainnya.",
                price: "Rp 750.000",
                packages: "1 Layanan",
                path: "/penyusunan-peninjauan/1",
                image: "/images/dummy-card.png",
            },
            {
                title: "Legalisasi Kedutaan / Apostilled",
                description:
                    "Legalisasi dokumen untuk keperluan internasional dan kedutaan.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/legalisasi-kedutaan",
                image: "/images/dummy-card.png",
            },
            {
                title: "Penerjemah / Translator",
                description:
                    "Jasa penerjemah dokumen hukum dan bisnis tersumpah.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/perizinan-usaha",
                image: "/images/dummy-card.png",
            },
            {
                title: "Kekayaan Intelektual",
                description:
                    "Pendaftaran & perpanjangan merek, hak cipta, dan analisa merek.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/kekayaan-intelektual",
                image: "/images/dummy-card.png",
            },
            {
                title: "Uji Tuntas Hukum",
                description:
                    "Legal due diligence menyeluruh untuk transaksi dan investasi.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/perizinan-usaha",
                image: "/images/dummy-card.png",
            },
        ],
    },
    {
        title: "EXPATRIATE & KEIMIGRASIAN",
        path: "/",
        items: [
            {
                title: "Izin Tinggal Terbatas (ITAS)",
                description:
                    "ITAS kerja, investor, keluarga, pasangan, dan perpanjangan.",
                price: "Rp 3.500.000",
                packages: "4 Layanan",
                path: "/izin-tinggal-terbatas",
                image: "/images/dummy-card.png",
            },
            {
                title: "Izin Tinggal Tetap (ITAP)",
                description:
                    "Izin tinggal permanen bagi WNA yang memenuhi syarat di Indonesia.",
                price: "Rp 750.000",
                packages: "2 Layanan",
                path: "/izin-tinggal-tetap",
                image: "/images/layanan-card/layanan-itap.png",
            },
            {
                title: "Visa ke Indonesia",
                description:
                    "Visa kunjungan, kerja, investor, keluarga, lansia, hingga Golden Visa.",
                price: "Rp 3.500.000",
                packages: "6 Layanan",
                path: "/perizinan-usaha",
                image: "/images/dummy-card.png",
            },
            {
                title: "Visa ke Mancanegara",
                description:
                    "Pengurusan visa ke luar negeri untuk berbagai keperluan.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/perizinan-usaha",
                image: "/images/dummy-card.png",
            },
            {
                title: "Keimigrasian",
                description:
                    "Paspor Republik Indonesia dan layanan keimigrasian lainnya.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/perizinan-usaha",
                image: "/images/layanan-card/layanan-keimigrasian.png",
            },
            {
                title: "Naturalisasi",
                description:
                    "Alih kewarganegaraan (naturalisasi) bagi WNA menjadi WNI.",
                price: "Rp 750.000",
                packages: "6 Layanan",
                path: "/perizinan-usaha",
                image: "/images/dummy-card.png",
            },
        ],
    },
];
</script>

<template>
    <MainLayout>
        <!-- Hero Section - Services Page -->
        <section class="relative overflow-hidden bg-[#9e1f16]">
            <!-- Diagonal white chevron arrow-left - full height -->
            <svg
                class="absolute right-[0%] -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block"
                viewBox="0 0 50 100"
                preserveAspectRatio="none"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M40 0L0 50L40 100"
                    stroke="white"
                    stroke-width="18"
                    stroke-linecap="butt"
                    stroke-linejoin="miter"
                />
            </svg>

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
                                class="inline-flex items-center gap-2 rounded-md bg-white backdrop-blur-sm px-4 py-2"
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
                                <span class="text-sm font-medium text-[#9e1f16]"
                                    >Layanan</span
                                >
                            </div>
                        </nav>

                        <!-- Heading -->
                        <h1
                            class="text-xl font-extrabold leading-tight text-white sm:text-4xl lg:text-2xl xl:text-[2rem]"
                        >
                            Layanan Legalitas dan Perizinan Untuk Bisnis yang Siap Bertumbuh
                        </h1>

                        <!-- Description -->
                        <p
                            class="mt-6 max-w-xl text-base leading-relaxed text-white/80 sm:text-lg sm:leading-8"
                        >
                            FASTTRACK membantu pendirian PT, CV, virtual office, perizinan usaha, hingga kebutuhan legal perusahaan dengan alur yang rapi, transparan, dan nyaman diakses dari mana saja.
                        </p>

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
                                class="group inline-flex items-center gap-2.5 rounded-md border-2 border-white bg-transparent px-7 py-3.5 text-sm font-semibold text-white transition-all duration-300 hover:bg-white hover:text-[#9e1f16]"
                            >
                                Konsultasi via WhatsApp
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

                    <!-- Right Image -->
                    <div class="relative z-10 order-first lg:order-last">
                        <div
                            class="relative rounded-2xl border-8 border-gray-800/90 overflow-hidden shadow-2xl aspect-[3/2]"
                        >
                            <img
                                src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80&fm=webp"
                                alt="Layanan legalitas dan perizinan FastTrack"
                                class="h-full w-full object-cover"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- LAYANAN SECTION -->
        <section id="daftar-layanan" class="py-[52px]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex flex-col gap-8">
                    <!-- Category Groups -->
                    <div
                        v-for="(category, catIdx) in serviceCategories"
                        :key="catIdx"
                        class="flex flex-col gap-4"
                    >
                        <!-- Category Header -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <img
                                    src="/icons/ft-docs.svg"
                                    class="w-6 h-6"
                                    alt="docs categories"
                                />
                                <h3
                                    class="text-[18px] font-bold leading-[27px] text-[#1A1B18]"
                                >
                                    {{ category.title }}
                                </h3>
                            </div>
                        </div>

                        <!-- Service Cards Grid -->
                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
                        >
                            <a
                                v-for="(item, itemIdx) in category.items"
                                :key="itemIdx"
                                :href="item.path"
                                class="group flex flex-col rounded-xl bg-white shadow-[0_1px_4px_rgba(0,0,0,0.08)] overflow-hidden transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.12)]"
                            >
                                <!-- Card Image -->
                                <div
                                    class="relative aspect-video overflow-hidden"
                                >
                                    <img
                                        :src="item.image"
                                        :alt="item.title"
                                        class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                        loading="lazy"
                                    />
                                </div>

                                <!-- Card Body -->
                                <div class="flex flex-col flex-grow p-4">
                                    <!-- Title & Description -->
                                    <div
                                        class="flex flex-col gap-1.5 flex-grow"
                                    >
                                        <h4
                                            class="text-[16px] font-bold leading-[24px] text-[#1A1B18]"
                                        >
                                            {{ item.title }}
                                        </h4>
                                        <p
                                            class="text-[13px] leading-[20px] text-[#6B6B6B] line-clamp-3"
                                        >
                                            {{ item.description }}
                                        </p>
                                    </div>

                                    <!-- Divider -->
                                    <div class="my-3">
                                        <div
                                            class="h-px w-full bg-[#E0E0E0]"
                                        ></div>
                                    </div>

                                    <!-- Price & Packages -->
                                    <div
                                        class="flex items-start justify-between gap-3"
                                    >
                                        <!-- Kiri: Mulai dari + Price -->
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="text-[11px] font-medium leading-[16px] text-[#6B6B6B]"
                                                >Mulai dari</span
                                            >
                                            <span
                                                class="text-[20px] font-bold leading-[28px] text-primary"
                                                >{{ item.price }}</span
                                            >
                                        </div>
                                        <!-- Kanan: Packages badge -->
                                        <span
                                            class="inline-flex items-center rounded-md bg-[#F1F1F1] px-2 py-1 text-[11px] font-medium leading-[16px] text-[#6B6B6B] flex-shrink-0"
                                        >
                                            {{ item.packages }}
                                        </span>
                                    </div>

                                    <!-- CTA Button -->
                                    <div
                                        class="mt-3 flex items-center justify-center gap-2 rounded-lg border border-primary h-[40px] text-[13px] font-semibold text-primary transition-colors group-hover:bg-[#9e1f16] group-hover:text-white group-hover:border-[#9e1f16]"
                                    >
                                        Selengkapnya
                                        <svg
                                            class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2.5"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"
                                            />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Footer CTA Banner -->
                    <div
                        class="relative overflow-hidden rounded-2xl bg-[#9e1f16] px-6 py-12 sm:px-10 sm:py-14"
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
                                Tim kami siap membantu Anda menemukan solusi
                                yang tepat<br class="hidden sm:block" />
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
            </div>
        </section>
    </MainLayout>
</template>
