<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref, computed } from "vue";

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

const whatsappNumber = "6282298604144";

const buildWhatsappLink = (productName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${productName}.`;
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

// Bahasa & Wilayah search
const bahasaSearch = ref("");

const bahasaItems = computed(() => props.product?.bahasa_wilayah?.items ?? []);

const filteredBahasa = computed(() => {
    const q = bahasaSearch.value.trim().toLowerCase();
    if (!q) return bahasaItems.value;
    return bahasaItems.value.filter((item) =>
        item.name.toLowerCase().includes(q)
    );
});

// Desktop: 2-column rows
const bahasaRows = computed(() => {
    const items = filteredBahasa.value;
    const rows = [];
    for (let i = 0; i < items.length; i += 2) {
        const row = items.slice(i, i + 2);
        while (row.length < 2) row.push(null);
        rows.push(row);
    }
    return rows;
});

const keunggulan = computed(() => props.product?.keunggulan ?? null);
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]">
            <div class="absolute inset-0">
                <img src="/images/layanan-hero/ft-hero-penterjemah.png" class="h-full w-full object-cover object-center"
                    alt="" />
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"></div>
            </div>

            <div
                class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]">
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb">
                    <div class="inline-flex items-center gap-2 rounded-md bg-white px-4 py-2">
                        <a href="/" class="text-[#9e1f16] hover:text-black transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
                            </svg>
                        </a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/layanan" class="text-sm font-medium text-[#9e1f16] hover:underline">Layanan</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#9e1f16]">{{ product.name }}</span>
                    </div>
                </nav>

                <!-- Heading -->
                <div class="flex flex-col gap-3 max-w-2xl">
                    <h1 class="font-extrabold leading-tight text-white text-2xl sm:text-3xl lg:text-4xl">
                        {{ product.name }}
                    </h1>
                    <p class="text-sm sm:text-base text-white/85 leading-relaxed">
                        {{ product.description }}
                    </p>
                </div>

                <!-- Back -->
                <div>
                    <a href="/layanan"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[1fr_340px] xl:grid-cols-[1fr_360px]">

                    <!-- KIRI -->
                    <div class="flex flex-col gap-6">

                        <!-- 1. Informasi Umum -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Informasi</h2>
                            </div>
                            <div class="space-y-4">
                                <p v-for="(paragraph, index) in product.content" :key="`content-${index}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A]">
                                    {{ paragraph }}
                                </p>
                            </div>
                        </div>

                        <!-- 2. Bahasa & Wilayah -->
                        <div v-if="product.bahasa_wilayah"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-2">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ product.bahasa_wilayah.title }}
                                </h2>
                            </div>
                            <p class="text-[13px] text-[#686964] mb-5 leading-[1.7]">
                                {{ product.bahasa_wilayah.subtitle }}
                            </p>

                            <!-- Search -->
                            <div class="relative mb-5">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#A8A8A4] pointer-events-none"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input v-model="bahasaSearch" type="text"
                                    placeholder="Cari bahasa... mis. Jepan, Arab, Jerman"
                                    class="w-full border border-[#D9DAD8] rounded-lg pl-9 pr-3 py-2.5 text-[13px] text-[#3D3D3A] placeholder-[#A8A8A4] focus:outline-none focus:border-[#9e1f16]/40 transition-colors bg-white" />
                            </div>

                            <!-- Grid 2 kolom -->
                            <div v-if="bahasaRows.length" class="border border-[#D9DAD8] rounded-lg overflow-hidden">
                                <div v-for="(row, ri) in bahasaRows" :key="`brow-${ri}`" class="grid grid-cols-2"
                                    :class="ri < bahasaRows.length - 1 ? 'border-b border-[#E8E8E6]' : ''">
                                    <template v-for="(item, ci) in row" :key="`bcell-${ri}-${ci}`">
                                        <div v-if="item"
                                            class="flex items-center gap-3 px-4 py-3 hover:bg-[#FAFAF8] transition-colors"
                                            :class="ci === 0 ? 'border-r border-[#E8E8E6]' : ''">
                                            <img :src="item.img_flag" :alt="item.name"
                                                class="w-7 h-[18px] object-cover rounded-[2px] flex-shrink-0 shadow-sm"
                                                loading="lazy" />
                                            <span class="text-[13px] text-[#3D3D3A]">{{ item.name }}</span>
                                        </div>
                                        <div v-else class="px-4 py-3"
                                            :class="ci === 0 ? 'border-r border-[#E8E8E6]' : ''"></div>
                                    </template>
                                </div>
                            </div>

                            <!-- Empty state -->
                            <div v-else class="border border-[#D9DAD8] rounded-lg px-4 py-10 text-center">
                                <svg class="mx-auto mb-2 w-8 h-8 text-[#D9DAD8]" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <p class="text-[13px] text-[#686964]">Bahasa tidak ditemukan</p>
                            </div>
                        </div>

                        <!-- 3. Mengapa Memilih FastTrack -->
                        <div v-if="keunggulan" class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    Mengapa Memilih FastTrack?
                                </h2>
                            </div>

                            <!-- Checklist 2 kolom -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2 mb-6">
                                <ul class="space-y-2">
                                    <li v-for="(item, i) in keunggulan.items_left" :key="`left-${i}`"
                                        class="flex items-start gap-2 text-[13px] text-[#3D3D3A]">
                                        <img src="/icons/ft-done.svg" class="w-4 h-4 mt-0.5 flex-shrink-0" alt="" />
                                        {{ item }}
                                    </li>
                                </ul>
                                <ul class="space-y-2">
                                    <li v-for="(item, i) in keunggulan.items_right" :key="`right-${i}`"
                                        class="flex items-start gap-2 text-[13px] text-[#3D3D3A]">
                                        <img src="/icons/ft-done.svg" class="w-4 h-4 mt-0.5 flex-shrink-0" alt="" />
                                        {{ item }}
                                    </li>
                                </ul>
                            </div>

                            <!-- Deskripsi -->
                            <div class="space-y-3">
                                <p v-for="(p, i) in keunggulan.description" :key="`desc-${i}`"
                                    class="text-[13px] leading-[1.8] text-[#3D3D3A]">
                                    {{ p }}
                                </p>
                            </div>
                        </div>

                        <!-- 4. Banner Harga -->
                        <div v-if="product" class="rounded-2xl overflow-hidden relative"
                            style="background-color: #9e1f16; background-image: url('/images/card-arrow-bg.png'); background-size: cover; background-position: center right; background-repeat: no-repeat;">
                            <div class="flex items-center justify-between px-5 py-4 sm:px-6 sm:py-5 gap-4">
                                <!-- Kiri: Icon + Teks -->
                                <div class="flex items-center gap-4">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-white/15 flex items-center justify-center">
                                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span
                                            class="text-[10px] sm:text-[11px] font-bold uppercase tracking-widest text-white/80 truncate">
                                            {{ product.name }}
                                        </span>
                                        <span class="text-[22px] sm:text-[28px] font-bold text-white leading-tight">
                                            Hanya {{ product.price_label }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Kanan: Tombol -->
                                <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                    class="flex-shrink-0 inline-flex items-center gap-2 rounded-xl bg-white px-4 sm:px-5 py-2.5 sm:py-3 text-[12px] sm:text-[13px] font-semibold text-[#9e1f16] hover:bg-white/90 transition-colors whitespace-nowrap">
                                    Hubungi Kami
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </div>
                    <!-- END KIRI -->

                    <!-- KANAN: Sidebar -->
                    <div class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start">
                        <!-- VIP Line Banner -->
                        <div class="rounded-2xl px-5 py-6 text-center overflow-hidden relative"
                            style="background-image: url('/images/card-arrow-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <div class="relative mb-4">
                                <div class="inline-block w-full rounded-xl border border-white/60 px-4 py-2.5">
                                    <span class="text-[14px] font-extrabold uppercase tracking-widest text-white">
                                        FASTRACK – VIP LINE
                                    </span>
                                </div>
                            </div>
                            <p class="relative text-[14px] leading-[1.6] text-white/90 mb-5">
                                Pendirian Badan Usaha Selesai dalam<br />1 (Satu) Hari
                            </p>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                Pesan Layanan Sekarang
                            </a>
                            <div class="relative mt-3 text-[11px] text-white/60">* (S&K BERLAKU)</div>
                        </div>

                        <!-- Price Card -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <div
                                class="mb-4 flex items-center justify-between rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] px-3 py-2.5">
                                <span class="text-[13px] text-[#1A1B18]">{{ product.name }}</span>
                                <svg class="h-4 w-4 text-[#686964]" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <div class="text-[12px] text-[#686964] mb-1">Harga</div>
                            <div class="text-[32px] font-bold leading-none text-primary mb-1">
                                {{ product.price_label }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">*Harga final dikonfirmasi setelah konsultasi
                            </div>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-6 w-6 flex-shrink-0" alt="wa" />
                                Konsultasi Gratis via Whatsapp
                            </a>
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Soft fee Awal Terjamin
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Mudah Me-Trust Terjemahan
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Gratis Revisi
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END KANAN -->

                </div>
            </div>
        </section>

        <!-- Mobile Sticky Bottom Bar -->
        <div
            class="fixed bottom-0 left-0 right-0 z-50 lg:hidden bg-white border-t border-[#E8E8E6] px-4 py-3 flex items-center justify-between gap-3 shadow-lg">
            <div class="flex flex-col min-w-0">
                <span class="text-[10px] text-[#686964] uppercase tracking-wide font-semibold truncate">
                    {{ product.name }}
                </span>
                <span class="text-[18px] font-bold text-primary leading-tight">
                    {{ product.price_label }}
                </span>
            </div>
            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                class="flex-shrink-0 inline-flex items-center gap-2 rounded-lg bg-[#25D366] px-4 py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors">
                <img src="/icons/ft-wa.svg" class="h-5 w-5" alt="wa" />
                Hubungi Kami
            </a>
        </div>

        <!-- Footer CTA Banner -->
        <section class="bg-[#F7F7F5] mb-12 sm:mb-16 pb-16 lg:pb-0">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-2xl bg-[#9e1f16] px-6 py-12 sm:px-10 sm:py-14">
                    <img src="/icons/ft-docs.svg" alt=""
                        class="absolute right-6 top-6 h-16 w-16 opacity-20 sm:right-10 sm:top-8 sm:h-24 sm:w-24" />
                    <div class="relative flex flex-col items-center text-center">
                        <h3
                            class="max-w-2xl text-[22px] font-bold leading-[32px] text-white sm:text-[28px] sm:leading-[38px]">
                            Tidak Menemukan Layanan yang Anda Cari?
                        </h3>
                        <p
                            class="mt-4 max-w-lg text-[14px] leading-[22px] text-white/80 sm:text-[16px] sm:leading-[24px]">
                            Tim kami siap membantu Anda menemukan solusi yang tepat<br class="hidden sm:block" />
                            untuk kebutuhan legalitas bisnis Anda.
                        </p>
                        <a :href="buildWhatsappLink('layanan yang tidak terdaftar')" target="_blank"
                            rel="noopener noreferrer"
                            class="mt-8 inline-flex items-center gap-2.5 rounded-lg bg-[#25D366] px-6 py-3 text-[14px] font-semibold text-white shadow-lg shadow-[#25D366]/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#20BD5A] hover:shadow-xl hover:shadow-[#25D366]/40 sm:px-8 sm:py-3.5 sm:text-[15px]">
                            Chat Langsung via WhatsApp
                            <img src="/icons/ft-wa.svg" alt="WhatsApp" class="h-5 w-5" />
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>