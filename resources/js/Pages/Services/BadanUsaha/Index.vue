<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
    service: {
        type: Object,
        required: true,
    },
    products: {
        type: Array,
        default: () => [],
    },
});

const whatsappNumber = "6282298604144";

const buildWhatsappLink = (productName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${productName}.`;

    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

const goToProduct = (detailPath) => {
    window.location.href = detailPath;
};

const serviceCategories = [
    {
        title: "PENDIRIAN BADAN USAHA",
        path: "/badan-usaha",
        items: [
            {
                id: "1",
                title: "PT Perorangan",
                description:
                    "Perseroan Terbatas (PT) Perorangan adalah Badan Hukum yang didirikan oleh 1 (satu) seorang",
                price: "Rp 750.000",
                packages: "3 Paket",
                path: "/badan-usaha",
                icon: "/icons/ft-person.svg",
            },
            {
                id: "2",
                title: "PT. PMDN",
                description:
                    "Penanaman Modal Dalam Negeri (PMDN) adalah kegiatan menanam modal menggunakan Modal Dalam Negeri",
                price: "Rp 3.250.000",
                packages: "5 Paket",
                path: "/badan-usaha",
                icon: "/icons/ft-persons.svg",
            },
            {
                id: "3",
                title: "PT. PMA",
                description:
                    "Penanaman Modal Asing (PMA) adalah kegiatan investasi atau menanam modal oleh Penanam Modal Asing",
                price: "Rp 17.250.000",
                packages: "3 Paket",
                path: "/foreignservice",
                icon: "/icons/ft-person-check.svg",
            },
            {
                id: "4",
                title: "Pendirian CV",
                description:
                    "CV merupakan bentuk persekutuan yang didirikan oleh dua orang atau lebih",
                price: "Rp 2.750.000",
                packages: "4 Paket",
                path: "/badan-usaha",
                icon: "/icons/ft-building.svg",
            },
            {
                id: "5",
                title: "Pendirian Yayasan",
                description:
                    "Yayasan merupakan badan hukum yang memiliki peranan penting dalam mendukung kegiatan sosial",
                price: "Rp 3.250.000",
                packages: "3 Paket",
                path: "/badan-usaha",
                icon: "/icons/ft-building.svg",
            },
            {
                id: "6",
                title: "Pendirian Koperasi",
                description:
                    "Koperasi merupakan badan usaha yang memiliki peran penting dalam meningkatkan kesejahteraan",
                price: "Rp 9.750.000",
                packages: "3 Paket",
                path: "/badan-usaha",
                icon: "/icons/ft-building.svg",
            },
            {
                id: "7",
                title: "Persekutuan Perdata",
                description:
                    "Persekutuan Perdata (Maatschap) merupakan suatu bentuk perjanjian yang dibuat oleh dua orang atau lebih",
                price: "Rp 2.750.000",
                packages: "3 Paket",
                path: "/badan-usaha",
                icon: "/icons/ft-building.svg",
            },
            {
                id: "8",
                title: "Persekutuan Firma",
                description:
                    "Persekutuan Firma merupakan bentuk persekutuan yang dijalankan lebih dari satu orang",
                price: "Rp 2.500.000",
                packages: "3 Paket",
                path: "/foreignservice",
                icon: "/icons/ft-building.svg",
            },
        ],
    },
];
</script>

<template>
    <MainLayout>
        <!-- Hero Section - Services Page (Full BG Image Style) -->
        <section
            class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]"
        >
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img
                    src="/images/layanan-badan-usaha/ft-hero-badan-usaha.png"
                    alt="Hero background"
                    class="h-full w-full object-cover object-center"
                />
                <!-- Dark overlay -->
                <div class="absolute inset-0 bg-black/35"></div>
            </div>

            <!-- Content -->
            <div
                class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]"
            >
                <!-- Top: Breadcrumb -->
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
                        <span class="text-sm font-medium text-[#E63946]"
                            >Badan Usaha</span
                        >
                    </div>
                </nav>

                <!-- Bottom: Heading + Description + Back button -->
                <div class="mt-auto pt-8">
                    <h1
                        class="text-2xl font-extrabold leading-tight text-white sm:text-3xl lg:text-4xl"
                    >
                        Layanan Legalitas dan Perizinan<br
                            class="hidden sm:block"
                        />
                        <span class="text-white/90"
                            >Untuk Bisnis yang Siap Bertumbuh</span
                        >
                    </h1>

                    <p
                        class="mt-4 max-w-xl text-sm leading-relaxed text-white/80 sm:text-base sm:leading-7"
                    >
                        <span class="font-semibold text-white">FASTTRACK</span>
                        membantu pendirian PT, CV, virtual office, perizinan
                        usaha, hingga kebutuhan legal perusahaan dengan alur
                        yang rapi, transparan, dan nyaman diakses dari mana
                        saja.
                    </p>

                    <!-- Back button -->
                    <div class="mt-6">
                        <a
                            href="/layanan"
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

        <!-- LAYANAN SECTION -->
        <section id="layanan" class="py-[52px]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex flex-col gap-8">
                    <div
                        v-for="(category, catIdx) in serviceCategories"
                        :key="catIdx"
                        class="flex flex-col gap-4"
                    >
                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
                        >
                            <a
                                v-for="(item, itemIdx) in category.items"
                                :key="itemIdx"
                                :href="`/badan-usaha/${item.id}`"
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
