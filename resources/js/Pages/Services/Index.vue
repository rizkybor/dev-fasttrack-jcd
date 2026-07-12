<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { computed } from "vue";
import { useI18n } from "vue-i18n";

const { t, tm } = useI18n();

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

// Meta non-translatable (harga, path, gambar) per kategori.
// Urutannya harus sinkron dengan services.layanan.categories di file i18n (id/en/zh).
const categoryMeta = [
    // BISNIS & KORPORASI
    [
        { price: "Rp 750.000", path: "/badan-usaha", image: "/images/layanan-card/layanan-bu.png" },
        { price: "Rp 750.000", path: "/kantor-perwakilan", image: "/images/layanan-card/layanan-kantor-perwakilan.png" },
        { price: "Rp 750.000", path: "/badan-usaha-luar-negeri", image: "/images/layanan-card/layanan-badan-usaha-luar-negeri.png" },
        { price: "Rp 750.000", path: "/one-single-submission", image: "/images/layanan-card/layanan-one-single-submission.png" },
        { price: "Rp 750.000", path: "/perizinan-berusaha", image: "/images/layanan-card/layanan-perizinan.png" },
        { price: "Rp 750.000", path: "/perizinan-lainnya", image: "/images/layanan-card/layanan-perizinan-lainnya.png" },
        { price: "Rp 750.000", path: "/notaris-virtual-dan-akta", image: "/images/layanan-card/layanan-notaris-virtual.png" },
        { price: "Rp 750.000", path: "/restrukturisasi-perseroan-terbatas", image: "/images/layanan-card/layanan-restrukturisasi-perseroan-terbatas.png" },
        { price: "Rp 750.000", path: "/penutupan-badan-usaha", image: "/images/layanan-card/layanan-penutupan-badan-usaha.png" },
        { price: "Rp 750.000", path: "/kewajiban-pelaporan-perusahaan", image: "/images/layanan-card/layanan-kewajiban-pelaporan-perusahaan.png" },
        { price: "Rp 750.000", path: "/sertifikasi-badan-usaha/1", image: "/images/layanan-card/layanan-sertifikasi-badan-usaha.png" },
        { price: "Rp 750.000", path: "/retainer-berlangganan/1", image: "/images/layanan-card/layanan-retainer-berlangganan.png" },
        { price: "Rp 750.000", path: "/virtual-office", image: "/images/layanan-card/layanan-virtual-office.png" },
        { price: "Rp 750.000", path: "/digital-marketing", image: "/images/layanan-card/layanan-design-digmart.png" },
        { price: "Rp 750.000", path: "/perpajakan-dan-pembukuan", image: "/images/layanan-card/layanan-design-digmart.png" },
    ],
    // HUKUM & KONTRAK
    [
        { price: "Rp 750.000", path: "/penyusunan-peninjauan/1", image: "/images/dummy-card.png" },
        { price: "Rp 750.000", path: "/legalisasi-kedutaan", image: "/images/dummy-card.png" },
        { price: "Rp 750.000", path: "/penerjemah/1", image: "/images/dummy-card.png" },
        { price: "Rp 750.000", path: "/kekayaan-intelektual", image: "/images/dummy-card.png" },
        { price: "Rp 750.000", path: "/uji-tuntas-hukum/1", image: "/images/dummy-card.png" },
    ],
    // EXPATRIATE & KEIMIGRASIAN
    [
        { price: "Rp 3.500.000", path: "/izin-tinggal-terbatas", image: "/images/dummy-card.png" },
        { price: "Rp 750.000", path: "/izin-tinggal-tetap", image: "/images/layanan-card/layanan-itap.png" },
        { price: "Rp 3.500.000", path: "/visa-indonesia", image: "/images/dummy-card.png" },
        { price: "Rp 750.000", path: "/visa-mancanegara", image: "/images/dummy-card.png" },
        { price: "Rp 750.000", path: "/keimigrasian-wni-wna", image: "/images/layanan-card/layanan-keimigrasian.png" },
        { price: "Rp 750.000", path: "/naturalisasi/1", image: "/images/dummy-card.png" },
    ],
];

// Gabungkan konten locale (title, description, packages) + meta (price, path, image)
const serviceCategories = computed(() =>
    tm("services.layanan.categories").map((category, catIdx) => ({
        title: category.title,
        items: category.items.map((item, itemIdx) => ({
            ...item,
            ...(categoryMeta[catIdx]?.[itemIdx] ?? {}),
        })),
    })),
);
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
                                    >{{ t("services.layanan.hero.breadcrumb") }}</span
                                >
                            </div>
                        </nav>

                        <!-- Heading -->
                        <h1
                            class="text-xl font-extrabold leading-tight text-white sm:text-4xl lg:text-2xl xl:text-[2rem]"
                        >
                            {{ t("services.layanan.hero.title") }}
                        </h1>

                        <!-- Description -->
                        <p
                            class="mt-6 max-w-xl text-base leading-relaxed text-white/80 sm:text-lg sm:leading-8"
                        >
                            {{ t("services.layanan.hero.description") }}
                        </p>

                        <!-- CTA Button -->
                        <div class="mt-10">
                            <a
                                :href="
                                    buildWhatsappLink(
                                        t('services.layanan.hero.waMessage'),
                                    )
                                "
                                target="_blank"
                                rel="noopener noreferrer"
                                class="group inline-flex items-center gap-2.5 rounded-md border-2 border-white bg-transparent px-7 py-3.5 text-sm font-semibold text-white transition-all duration-300 hover:bg-white hover:text-[#9e1f16]"
                            >
                                {{ t("services.layanan.hero.ctaButton") }}
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
                                                >{{ t("services.layanan.ui.from") }}</span
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
                                        {{ t("services.layanan.ui.more") }}
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

                    <FooterCTA
                        bare
                        :title="t('services.layanan.footerCta.title')"
                        :description="t('services.layanan.footerCta.description')"
                        :button-text="t('services.layanan.footerCta.whatsapp')"
                        :whatsapp-link="buildWhatsappLink(t('services.layanan.footerCta.waMessage'))"
                    />
                </div>
            </div>
        </section>
    </MainLayout>
</template>
