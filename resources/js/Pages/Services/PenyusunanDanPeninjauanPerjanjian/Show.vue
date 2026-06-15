<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref, computed } from "vue";

const docsOpen = ref(false);
const dasarHukumOpen = ref(false);

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

const parseBold = (text) => {
    if (!text) return "";
    return text.replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>");
};

const whatsappNumber = "6282298604144";

const buildWhatsappLink = (productName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${productName}.`;
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

const currentPlans = computed(() => props.product?.plans ?? []);
const currentDasarHukum = computed(() => props.product?.dasar_hukum ?? []);

// Toggle truncate per doc item
const expandedDocs = ref({});
const toggleDoc = (key) => {
    expandedDocs.value[key] = !expandedDocs.value[key];
};

// Jenis Perjanjian / Kontrak - search & filter
const contractSearchQuery = ref("");

const contractCategories = computed(
    () => props.product?.contract_categories ?? [],
);

const filteredContractCategories = computed(() => {
    const query = contractSearchQuery.value.trim().toLowerCase();

    if (!query) return contractCategories.value;

    return contractCategories.value
        .map((category) => ({
            ...category,
            items: category.items.filter((item) =>
                item.name.toLowerCase().includes(query),
            ),
        }))
        .filter((category) => category.items.length > 0);
});
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section
            class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px] bg-[#9e1f16]"
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
                        <a
                            href="/layanan"
                            class="text-sm font-medium text-[#9e1f16] hover:underline"
                            >Layanan</a
                        >
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
                        <span class="text-sm font-medium text-[#9e1f16]">{{
                            product.name
                        }}</span>
                    </div>
                </nav>

                <!-- Center: Heading -->
                <div class="flex items-center gap-5">
                    <div
                        class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white shadow-md"
                    >
                        <img
                            src="/icons/ft-persons.svg"
                            class="w-9 h-9"
                            alt=""
                        />
                    </div>
                    <h1
                        class="font-extrabold leading-tight text-white sm:text-2xl lg:text-4xl max-w-[800px] line-clamp-2"
                    >
                        {{ product.name }}
                    </h1>
                </div>

                <!-- Bottom: Back button -->
                <div>
                    <a
                        href="/badan-usaha"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition"
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
                                <img
                                    src="/icons/ic-menu-arrow.svg"
                                    class="w-6 h-6"
                                    alt=""
                                />
                                <h2
                                    class="text-[15px] font-bold uppercase tracking-widest text-black"
                                >
                                    Informasi Umum
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

                        <!-- JENIS PERJANJIAN / KONTRAK -->
                        <div
                            v-if="contractCategories.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-4 sm:p-6 lg:p-8"
                        >
                            <!-- Header: title + search -->
                            <div
                                class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-5 sm:mb-6"
                            >
                                <div class="flex items-center gap-2.5 sm:gap-3">
                                    <img
                                        src="/icons/ic-menu-arrow.svg"
                                        class="w-5 h-5 sm:w-6 sm:h-6"
                                        alt=""
                                    />
                                    <h2
                                        class="text-[13px] sm:text-[15px] font-bold uppercase tracking-widest text-black"
                                    >
                                        Jenis Perjanjian / Kontrak
                                    </h2>
                                </div>

                                <div class="relative w-full sm:w-72">
                                    <input
                                        v-model="contractSearchQuery"
                                        type="text"
                                        placeholder="Cari jenis perjanjian / kontrak"
                                        class="w-full rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] px-4 py-2.5 pr-10 text-[12px] sm:text-[13px] text-[#1A1B18] placeholder:text-[#9C9D99] focus:outline-none focus:ring-1 focus:ring-primary"
                                    />
                                    <svg
                                        class="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[#9C9D99]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <circle cx="11" cy="11" r="7" />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M21 21l-4.35-4.35"
                                        />
                                    </svg>
                                </div>
                            </div>

                            <!-- Categories -->
                            <div class="flex flex-col gap-5 sm:gap-6">
                                <div
                                    v-for="(
                                        category, ci
                                    ) in filteredContractCategories"
                                    :key="`contract-cat-${ci}`"
                                >
                                    <div
                                        class="flex items-center justify-between mb-2.5 sm:mb-3"
                                    >
                                        <h3
                                            class="text-[12px] sm:text-[13px] font-bold text-[#1A1B18]"
                                        >
                                            {{ category.name }}
                                        </h3>
                                        <span
                                            class="text-[10px] sm:text-[11px] text-[#9C9D99]"
                                        >
                                            {{ category.items.length }} Layanan
                                        </span>
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        <a
                                            v-for="(item, ii) in category.items"
                                            :key="`contract-item-${ci}-${ii}`"
                                            :href="buildWhatsappLink(item.name)"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="group flex flex-col gap-1.5 sm:flex-row sm:items-center sm:justify-between sm:gap-3 rounded-lg border border-[#E8E8E6] px-3 sm:px-4 py-2.5 sm:py-3 hover:border-primary/30 hover:bg-[#FCF4F4] transition-colors"
                                        >
                                            <div
                                                class="flex items-center gap-2.5 sm:gap-3 min-w-0"
                                            >
                                                <span
                                                    class="flex h-7 w-7 sm:h-8 sm:w-8 flex-shrink-0 items-center justify-center rounded-lg bg-[#FAD9DA]"
                                                >
                                                    <img
                                                        src="/icons/ft-docs.svg"
                                                        class="h-4 w-4 sm:h-[18px] sm:w-[18px]"
                                                        alt=""
                                                    />
                                                </span>
                                                <span
                                                    class="text-[12px] sm:text-[13px] text-[#1A1B18] line-clamp-2 sm:truncate"
                                                >
                                                    {{ item.name }}
                                                </span>
                                            </div>

                                            <span
                                                class="flex items-center gap-1.5 text-[11px] sm:text-[12px] font-semibold text-primary whitespace-nowrap flex-shrink-0 self-end sm:self-auto pl-[38px] sm:pl-0"
                                            >
                                                Hubungi Kami
                                                <svg
                                                    class="h-3.5 w-3.5 group-hover:translate-x-0.5 transition-transform"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2.5"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M14 5l7 7m0 0l-7 7m7-7H3"
                                                    />
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>

                                <p
                                    v-if="
                                        filteredContractCategories.length === 0
                                    "
                                    class="text-[12px] sm:text-[13px] text-[#686964] text-center py-8"
                                >
                                    Tidak ada jenis perjanjian yang sesuai
                                    dengan pencarian Anda.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- ===== KANAN: Sidebar ===== -->
                    <div
                        class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start"
                    >
                        <!-- VIP Line Banner -->
                        <div
                            class="rounded-2xl px-5 py-6 text-center overflow-hidden relative"
                            style="
                                background-image: url(&quot;/images/card-arrow-bg.png&quot;);
                                background-size: cover;
                                background-position: center;
                                background-repeat: no-repeat;
                            "
                        >
                            <div class="relative mb-4">
                                <div
                                    class="inline-block w-full rounded-xl border border-white/60 px-4 py-2.5"
                                >
                                    <span
                                        class="text-[14px] font-extrabold uppercase tracking-widest text-white"
                                    >
                                        FASTRACK – VIP LINE
                                    </span>
                                </div>
                            </div>

                            <p
                                class="relative text-[14px] leading-[1.6] text-white/90 mb-5"
                            >
                                Pendirian Badan Usaha Selesai dalam<br />1
                                (Satu) Hari
                            </p>
                            <a
                                :href="buildWhatsappLink(product.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20"
                            >
                                <img
                                    src="/icons/ft-wa.svg"
                                    class="mt-0.5 h-5 w-5 flex-shrink-0"
                                    alt="wa"
                                />
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
                                <img
                                    src="/icons/ft-wa.svg"
                                    class="mt-0.5 h-6 w-6 flex-shrink-0"
                                    alt="wa"
                                />
                                Konsultasi Gratis via Whatsapp
                            </a>
                            <ul class="mt-4 space-y-2">
                                <li
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <img
                                        src="/icons/ft-done.svg"
                                        class="mt-0.5 h-4 w-4 flex-shrink-0"
                                        alt="done"
                                    />
                                    Konsultasi pertama gratis
                                </li>
                                <li
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <img
                                        src="/icons/ft-done.svg"
                                        class="mt-0.5 h-4 w-4 flex-shrink-0"
                                        alt="done"
                                    />
                                    Harga transparan, tanpa biaya tersembunyi
                                </li>
                                <li
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <img
                                        src="/icons/ft-done.svg"
                                        class="mt-0.5 h-4 w-4 flex-shrink-0"
                                        alt="done"
                                    />
                                    Tim berpengalaman 18+ tahun
                                </li>
                                <li
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <img
                                        src="/icons/ft-done.svg"
                                        class="mt-0.5 h-4 w-4 flex-shrink-0"
                                        alt="done"
                                    />
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
                                    class="group flex flex-col gap-2 rounded-xl border border-[#E8E8E6] bg-white p-4 hover:border-primary/30 hover:shadow-sm transition-all"
                                >
                                    <!-- Name -->
                                    <div
                                        class="text-[14px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors"
                                    >
                                        {{ related.name }}
                                    </div>

                                    <!-- Description -->
                                    <p
                                        class="text-[12px] leading-[1.6] text-[#686964] line-clamp-3"
                                    >
                                        {{
                                            related.excerpt ??
                                            related.description
                                        }}
                                    </p>

                                    <hr class="border-[#E8E8E6]" />

                                    <!-- Price row -->
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div>
                                            <div
                                                class="text-[11px] text-[#686964] mb-0.5"
                                            >
                                                Mulai dari
                                            </div>
                                            <div
                                                class="text-[18px] font-bold text-primary leading-none"
                                            >
                                                {{ related.price_label }}
                                            </div>
                                        </div>
                                        <span
                                            class="text-[11px] font-medium text-[#3D3D3A] border border-[#E8E8E6] rounded-md px-2 py-1"
                                        >
                                            {{
                                                related.plans
                                                    ? related.plans.length
                                                    : 0
                                            }}
                                            Paket
                                        </span>
                                    </div>

                                    <!-- CTA Button -->
                                    <div
                                        class="mt-1 flex items-center justify-center gap-2 rounded-xl border border-primary py-2.5 text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors"
                                    >
                                        Selengkapnya
                                        <svg
                                            class="h-4 w-4 group-hover:translate-x-0.5 transition-transform"
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
                    class="relative overflow-hidden rounded-2xl bg-[#9e1f16] px-6 py-12 sm:px-10 sm:py-14"
                >
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
