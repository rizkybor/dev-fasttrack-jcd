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
                image: "/images/dummy-card.png",
            },
            {
                title: "PT. PMDN",
                description:
                    "Penanaman Modal Dalam Negeri (PMDN) adalah kegiatan menanam modal menggunakan Modal Dalam Negeri.",
                price: "Rp 3.250.000",
                packages: "5 Paket",
                path: "/pendirian-perusahaan",
                image: "/images/dummy-card.png",
            },
            {
                title: "PT. PMA",
                description:
                    "Penanaman Modal Asing (PMA) adalah kegiatan investasi atau menanam modal oleh Penanam Modal Asing",
                price: "Rp 17.250.000",
                packages: "3 Paket",
                path: "/foreignservice",
                image: "/images/dummy-card.png",
            },
            {
                title: "Pendirian CV",
                description:
                    "CV merupakan bentuk persekutuan yang didirikan oleh dua orang atau lebih",
                price: "Rp 2.750.000",
                packages: "4 Paket",
                path: "/pendirian-perusahaan",
                image: "/images/dummy-card.png",
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
                image: "/images/dummy-card.png",
            },
            {
                title: "NIB – PT – UMK",
                description:
                    "Pengurusan NIB untuk Perseroan Terbatas berkategori Usaha Mikro dan Kecil.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perizinan-usaha",
                image: "/images/dummy-card.png",
            },
            {
                title: "NIB – PT – NON UMK",
                description:
                    "Pengurusan NIB untuk PT skala menengah, besar, PMDN, maupun PMA.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perizinan-usaha",
                image: "/images/dummy-card.png",
            },
            {
                title: "NIB – CV",
                description:
                    "Pengurusan NIB resmi untuk badan usaha berbentuk Commanditaire Vennootschap (CV).",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perizinan-usaha",
                image: "/images/dummy-card.png",
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
                image: "/images/dummy-card.png",
            },
            {
                title: "PT (PERSEROAN TERBATAS) MODAL DIBAWAH 1M :",
                description:
                    "Perubahan Anggaran Dasar Perseroan Selain Pasal 1–4",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perubahan-akta",
                image: "/images/dummy-card.png",
            },
            {
                title: "PT (PERSEROAN TERBATAS) MODAL DIATAS 1M :",
                description: "Perubahan Anggaran Dasar Perseroan Pasal 3",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perubahan-akta",
                image: "/images/dummy-card.png",
            },
            {
                title: "PT (PERSEROAN TERBATAS) MODAL DIATAS 1M :",
                description: "Perubahan Anggaran Dasar Perseroan Pasal 4",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/perubahan-akta",
                image: "/images/dummy-card.png",
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
                image: "/images/dummy-card.png",
            },
            {
                title: "IZIN TINGGAL TERBATAS KELUARGA TENAGA KERJA ASING",
                description:
                    "Pengurusan ITAS untuk anggota keluarga yang mengikuti tenaga kerja asing.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                image: "/images/dummy-card.png",
            },
            {
                title: "IZIN TINGGAL TERBATAS INVESTOR",
                description:
                    "Pengurusan ITAS untuk investor asing yang menanamkan modal di Indonesia.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                image: "/images/dummy-card.png",
            },
            {
                title: "IZIN TINGGAL TERBATAS PASANGAN (SPOUSE)",
                description:
                    "Pengurusan ITAS untuk pasangan sah dari pemegang izin tinggal terbatas.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                image: "/images/dummy-card.png",
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
                image: "/images/dummy-card.png",
            },
            {
                title: "Visa Kerja",
                description:
                    "Pengurusan visa kerja untuk tenaga kerja asing di Indonesia.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                image: "/images/dummy-card.png",
            },
            {
                title: "Visa Investor",
                description:
                    "Pengurusan visa investor untuk penanam modal asing.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                image: "/images/dummy-card.png",
            },
            {
                title: "Visa Keluarga",
                description:
                    "Pengurusan visa untuk anggota keluarga tenaga kerja asing.",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/foreignservice",
                image: "/images/dummy-card.png",
            },
        ],
    },
];
</script>

<template>
    <MainLayout>
        <!-- Hero Section - Services Page -->
        <section class="relative overflow-hidden bg-[#E63946]">
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
                            Layanan Legalitas dan Perizinan<br
                                class="hidden sm:block"
                            />
                            <span class="text-white/90"
                                >Untuk Bisnis yang Siap Bertumbuh</span
                            >
                        </h1>

                        <!-- Description -->
                        <p
                            class="mt-6 max-w-xl text-base leading-relaxed text-white/80 sm:text-lg sm:leading-8"
                        >
                            <span class="font-semibold text-white"
                                >FASTTRACK</span
                            >
                            membantu pendirian PT, CV, virtual office, perizinan
                            usaha, hingga kebutuhan legal perusahaan dengan alur
                            yang rapi, transparan, dan nyaman diakses dari mana
                            saja.
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
                                class="group inline-flex items-center gap-2.5 rounded-full border-2 border-white bg-transparent px-7 py-3.5 text-sm font-semibold text-white transition-all duration-300 hover:bg-white hover:text-[#E63946]"
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
                            class="relative rounded-2xl border-4 border-gray-800/90 overflow-hidden shadow-2xl aspect-[3/2]"
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
                                    alt=""
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
                                        class="flex items-end justify-between gap-3"
                                    >
                                        <div class="flex flex-col gap-0.5">
                                            <span
                                                class="text-[11px] font-medium leading-[16px] text-[#6B6B6B]"
                                                >Mulai dari</span
                                            >
                                            <span
                                                class="text-[20px] font-bold leading-[28px] text-primary"
                                                >{{ item.price }}</span
                                            >
                                        </div>
                                        <span
                                            class="inline-flex items-center rounded-md bg-[#F1F1F1] px-2 py-1 text-[11px] font-medium leading-[16px] text-[#6B6B6B]"
                                        >
                                            {{ item.packages }}
                                        </span>
                                    </div>

                                    <!-- CTA Button -->
                                    <div
                                        class="mt-3 flex items-center justify-center gap-2 rounded-lg border border-primary h-[40px] text-[13px] font-semibold text-primary transition-colors group-hover:bg-[#E74247] group-hover:text-white group-hover:border-[#E74247]"
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
                                <!-- WhatsApp Icon -->
                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                >
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"
                                    />
                                </svg>
                                Chat Langsung via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
