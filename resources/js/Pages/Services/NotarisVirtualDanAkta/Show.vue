<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref, computed } from "vue";

const props = defineProps({
    product: { type: Object, required: true },
    relatedProducts: { type: Array, default: () => [] },
});

const whatsappNumber = "6282298604144";

const buildWhatsappLink = (productName, paketNama = "") => {
    const suffix = paketNama ? ` - ${paketNama}` : "";
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${productName}${suffix}.`;
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

const selectedPaketId = ref(props.product?.paket?.[0]?.id ?? null);
const selectedPaket = computed(
    () => props.product?.paket?.find((p) => p.id === selectedPaketId.value) ?? props.product?.paket?.[0] ?? null
);
const hasPaket = computed(() => !!props.product?.paket?.length);

// Accordion untuk penjelasan_layanan_items
const openItemId = ref(null);
const toggleItem = (id) => {
    openItemId.value = openItemId.value === id ? null : id;
};
</script>

<template>
    <MainLayout>
        <!-- Hero -->
        <section class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px] bg-[#9e1f16]">
            <img src="/icons/left-arrow.svg"
                class="absolute right-0 -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block" alt="" />
            <div
                class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]">
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
                        <a href="/notaris-virtual-dan-akta"
                            class="text-sm font-medium text-[#9e1f16] hover:underline">Notaris Terintegrasi Digital</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#9e1f16]">{{ product.name }}</span>
                    </div>
                </nav>
                <div class="flex items-center gap-5">
                    <div
                        class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white shadow-md">
                        <img src="/icons/ft-persons.svg" class="w-9 h-9" alt="" />
                    </div>
                    <h1
                        class="text-3xl font-extrabold leading-tight text-white sm:text-4xl lg:text-5xl max-w-[800px] line-clamp-2">
                        {{ product.name }}
                    </h1>
                </div>
                <div>
                    <a href="/notaris-virtual-dan-akta"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-white/70 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT -->
        <section class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- 1. Penjelasan Umum (full width) -->
                <div v-if="product.penjelasan_umum?.length"
                    class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8 mb-5">
                    <div class="flex items-center gap-3 mb-5">
                        <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                        <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Penjelasan Umum</h2>
                    </div>
                    <div class="space-y-4">
                        <p v-for="(p, i) in product.penjelasan_umum" :key="`pu-${i}`"
                            class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">{{ p }}</p>
                    </div>
                </div>

                <!-- 2. Pilih Jenis Layanan (full width) -->
                <div v-if="hasPaket" class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8 mb-5">
                    <div class="flex items-center gap-3 mb-5">
                        <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                        <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Pilih Jenis Layanan</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        <button v-for="paket in product.paket" :key="paket.id"
                            @click="() => { selectedPaketId = paket.id; openItemId = null; }"
                            class="flex flex-col items-start rounded-xl border p-4 text-left transition-all" :class="selectedPaketId === paket.id
                                ? 'border-primary bg-primary text-white shadow-md'
                                : 'border-[#E8E8E6] bg-white hover:border-primary/40 hover:shadow-sm'">
                            <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg"
                                :class="selectedPaketId === paket.id ? 'bg-white/20' : 'bg-[#FFF0EF]'">
                                <img src="/icons/ft-persons.svg" class="w-5 h-5" alt="" />
                            </div>
                            <p class="text-[13px] font-bold leading-snug mb-3"
                                :class="selectedPaketId === paket.id ? 'text-white' : 'text-[#1A1B18]'">
                                {{ paket.nama }}
                            </p>
                            <p class="text-[11px] leading-[1.5] mb-4 flex-1"
                                :class="selectedPaketId === paket.id ? 'text-white/80' : 'text-[#686964]'">
                                {{ paket.deskripsi }}
                            </p>
                            <p class="text-[10px]"
                                :class="selectedPaketId === paket.id ? 'text-white/70' : 'text-[#686964]'">Mulai dari
                            </p>
                            <p class="text-[16px] font-bold leading-tight"
                                :class="selectedPaketId === paket.id ? 'text-white' : 'text-primary'">
                                {{ paket.harga }}
                            </p>
                        </button>
                    </div>
                </div>

                <!-- Grid: KIRI + KANAN -->
                <div class="grid gap-8 lg:grid-cols-[1fr_280px] xl:grid-cols-[1fr_300px]">

                    <!-- ===== KIRI ===== -->
                    <div class="flex flex-col gap-5">
                        <template v-if="selectedPaket">

                            <!-- 3. Penjelasan Layanan -->
                            <div v-if="selectedPaket.penjelasan_layanan?.length"
                                class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                <div class="flex items-center gap-3 mb-5">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Penjelasan
                                        Layanan</h2>
                                </div>
                                <div class="space-y-4 mb-6">
                                    <p v-for="(p, i) in selectedPaket.penjelasan_layanan" :key="`pl-${i}`"
                                        class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">{{ p }}</p>
                                </div>

                                <!-- Mode accordion (semua paket KECUALI perubahan-data-perseroan) -->
                                <template
                                    v-if="selectedPaket.id !== 'rapat-umum-pemegang-saham-tahunan' && selectedPaket.penjelasan_layanan_items?.length">
                                    <div class="flex flex-col divide-y divide-[#F0F0EE]">
                                        <div v-for="item in selectedPaket.penjelasan_layanan_items" :key="item.id">
                                            <button @click="toggleItem(item.id)"
                                                class="w-full flex items-center justify-between gap-3 py-4 text-left group">
                                                <div class="flex items-center gap-3">
                                                    <img src="/icons/ft-docs.svg" class="w-5 h-5 flex-shrink-0"
                                                        alt="" />
                                                    <span
                                                        class="text-[13px] font-semibold text-[#1A1B18] uppercase tracking-wide group-hover:text-primary transition-colors">
                                                        {{ item.label }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-1.5 flex-shrink-0">
                                                    <span class="text-[12px] font-medium text-primary">
                                                        {{ openItemId === item.id ? 'Tutup' : 'Selengkapnya' }}
                                                    </span>
                                                    <svg class="h-4 w-4 text-primary transition-transform duration-200"
                                                        :class="openItemId === item.id ? 'rotate-90' : ''" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </div>
                                            </button>

                                            <div v-if="openItemId === item.id" class="pb-6">
                                                <!-- Penjelasan Detail -->
                                                <div v-if="item.penjelasan_detail?.length"
                                                    class="rounded-xl border border-[#E8E8E6] bg-[#F7F7F5] p-5 mb-4">
                                                    <div class="flex items-center gap-2 mb-4">
                                                        <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5" alt="" />
                                                        <h3
                                                            class="text-[13px] font-bold uppercase tracking-widest text-black">
                                                            Penjelasan Detail</h3>
                                                    </div>
                                                    <div class="space-y-2">
                                                        <p v-for="(p, i) in item.penjelasan_detail" :key="`pd-${i}`"
                                                            class="text-[13px] leading-[1.8] text-[#3D3D3A] text-justify"
                                                            :class="{ 'pl-4': p.match(/^\d+\./) || p.startsWith('•') }">
                                                            {{ p }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Paket & Harga -->
                                                <div v-if="item.paket_harga"
                                                    class="rounded-xl border border-[#E8E8E6] bg-[#F7F7F5] p-5 mb-4">
                                                    <div class="flex items-center gap-2 mb-4">
                                                        <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5" alt="" />
                                                        <h3
                                                            class="text-[13px] font-bold uppercase tracking-widest text-black">
                                                            Paket & Harga</h3>
                                                    </div>
                                                    <div class="rounded-xl border border-[#E8E8E6] bg-white p-4">
                                                        <div class="flex items-start justify-between gap-2 mb-1">
                                                            <p class="text-[13px] font-bold text-[#1A1B18]">{{
                                                                item.paket_harga.nama }}</p>
                                                            <span v-if="item.paket_harga.modal_note"
                                                                class="text-[10px] text-[#686964] whitespace-nowrap flex-shrink-0">
                                                                {{ item.paket_harga.modal_note }}
                                                            </span>
                                                        </div>
                                                        <p class="text-[11px] text-[#686964] mb-0.5">Mulai dari</p>
                                                        <p
                                                            class="text-[24px] font-bold text-primary leading-tight mb-2">
                                                            {{ item.paket_harga.harga }}</p>
                                                        <div v-if="item.paket_harga.gratis_konsultasi"
                                                            class="flex items-center gap-1.5 mb-4">
                                                            <img src="/icons/ft-done.svg" class="h-4 w-4 flex-shrink-0"
                                                                alt="" />
                                                            <span class="text-[11px] text-[#3D3D3A]">GRATIS Konsultasi
                                                                Pra dan Pasca Seleksi</span>
                                                        </div>
                                                        <hr class="border-[#E8E8E6] mb-4" />
                                                        <div v-if="item.paket_harga.dokumen_legalitas?.length"
                                                            class="mb-4">
                                                            <p class="text-[12px] font-bold text-[#1A1B18] mb-2.5">
                                                                Dokumen Legalitas</p>
                                                            <ul class="space-y-2">
                                                                <li v-for="(dok, di) in item.paket_harga.dokumen_legalitas"
                                                                    :key="`dok-${di}`" class="flex items-start gap-2">
                                                                    <img src="/icons/ft-done.svg"
                                                                        class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                                                    <span
                                                                        class="text-[12px] leading-[1.6] text-[#3D3D3A]">{{
                                                                        dok }}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div v-if="item.paket_harga.termasuk?.length" class="mb-5">
                                                            <p class="text-[12px] font-bold text-[#1A1B18] mb-2.5">
                                                                Termasuk</p>
                                                            <ul class="space-y-2">
                                                                <li v-for="(tmsk, ti) in item.paket_harga.termasuk"
                                                                    :key="`tmsk-${ti}`" class="flex items-start gap-2">
                                                                    <img src="/icons/ft-done.svg"
                                                                        class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                                                    <span
                                                                        class="text-[12px] leading-[1.6] text-[#3D3D3A]">{{
                                                                        tmsk }}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <a :href="buildWhatsappLink(product.name, item.paket_harga.nama)"
                                                            target="_blank" rel="noopener noreferrer"
                                                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-3 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors">
                                                            Pesan Sekarang
                                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Dokumen Diperlukan -->
                                                <div v-if="item.dokumen_diperlukan?.length"
                                                    class="rounded-xl border border-[#E8E8E6] bg-[#F7F7F5] p-5">
                                                    <div class="flex items-center gap-2 mb-4">
                                                        <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5" alt="" />
                                                        <h3
                                                            class="text-[13px] font-bold uppercase tracking-widest text-black">
                                                            Dokumen dan Informasi yang Diperlukan</h3>
                                                    </div>
                                                    <div class="space-y-4">
                                                        <div v-for="dok in item.dokumen_diperlukan"
                                                            :key="`ddp-${dok.nomor}`" class="flex gap-4">
                                                            <span
                                                                class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary text-white text-[12px] font-bold mt-0.5">
                                                                {{ dok.nomor }}
                                                            </span>
                                                            <div>
                                                                <p
                                                                    class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-2">
                                                                    {{ dok.judul }}</p>
                                                                <ul v-if="dok.items?.length" class="space-y-1.5">
                                                                    <li v-for="(point, pi) in dok.items"
                                                                        :key="`ddp-point-${pi}`"
                                                                        class="flex items-start gap-2 text-[12px] leading-[1.6] text-[#3D3D3A]">
                                                                        <span
                                                                            class="mt-[7px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                                                        <span>{{ point }}</span>
                                                                    </li>
                                                                </ul>
                                                                <p v-if="dok.desc"
                                                                    class="text-[12px] leading-[1.7] text-[#3D3D3A] mt-1">
                                                                    {{ dok.desc }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- Mode flat/non-accordion (khusus perubahan-data-perseroan) -->
                                <template
                                    v-else-if="selectedPaket.id === 'rapat-umum-pemegang-saham-tahunan' && selectedPaket.penjelasan_layanan_items?.length">
                                    <div v-for="item in selectedPaket.penjelasan_layanan_items" :key="item.id"
                                        class="mb-8 last:mb-0">

                                        <!-- Paket & Harga -->
                                        <div v-if="item.paket_harga" class="mb-5">
                                            <div class="flex items-center gap-2 mb-4">
                                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                                <h3 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                                    Paket & Harga</h3>
                                            </div>
                                            <div class="rounded-xl border border-[#E8E8E6] p-5">
                                                <div class="flex items-start justify-between gap-2 mb-1">
                                                    <p class="text-[13px] font-bold text-[#1A1B18]">{{
                                                        item.paket_harga.nama }}</p>
                                                    <span v-if="item.paket_harga.modal_note"
                                                        class="text-[10px] text-[#686964] whitespace-nowrap flex-shrink-0">
                                                        {{ item.paket_harga.modal_note }}
                                                    </span>
                                                </div>
                                                <p class="text-[11px] text-[#686964] mb-0.5">Mulai dari</p>
                                                <p class="text-[24px] font-bold text-primary leading-tight mb-2">{{
                                                    item.paket_harga.harga }}</p>
                                                <div v-if="item.paket_harga.gratis_konsultasi"
                                                    class="flex items-center gap-1.5 mb-4">
                                                    <img src="/icons/ft-done.svg" class="h-4 w-4 flex-shrink-0"
                                                        alt="" />
                                                    <span class="text-[11px] text-[#3D3D3A]">GRATIS Konsultasi Pra dan
                                                        Pasca Seleksi</span>
                                                </div>
                                                <hr class="border-[#E8E8E6] mb-4" />
                                                <div v-if="item.paket_harga.dokumen_legalitas?.length" class="mb-4">
                                                    <p class="text-[13px] font-bold text-[#1A1B18] mb-2.5">Dokumen
                                                        Legalitas</p>
                                                    <ul class="space-y-2">
                                                        <li v-for="(dok, di) in item.paket_harga.dokumen_legalitas"
                                                            :key="`fdok-${di}`" class="flex items-start gap-2">
                                                            <img src="/icons/ft-done.svg"
                                                                class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                                            <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{
                                                                dok }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div v-if="item.paket_harga.termasuk?.length" class="mb-5">
                                                    <p class="text-[13px] font-bold text-[#1A1B18] mb-2.5">Termasuk</p>
                                                    <ul class="space-y-2">
                                                        <li v-for="(tmsk, ti) in item.paket_harga.termasuk"
                                                            :key="`ftmsk-${ti}`" class="flex items-start gap-2">
                                                            <img src="/icons/ft-done.svg"
                                                                class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                                            <span class="text-[13px] leading-[1.6] text-[#3D3D3A]">{{
                                                                tmsk }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a :href="buildWhatsappLink(product.name, item.paket_harga.nama)"
                                                    target="_blank" rel="noopener noreferrer"
                                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-3 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors">
                                                    Pesan Sekarang
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Dokumen dan Informasi Diperlukan -->
                                        <div v-if="item.dokumen_diperlukan?.length">
                                            <div class="flex items-center gap-2 mb-4">
                                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                                <h3 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                                    Dokumen dan Informasi yang Diperlukan</h3>
                                            </div>
                                            <div class="space-y-5">
                                                <div v-for="dok in item.dokumen_diperlukan" :key="`fddp-${dok.nomor}`"
                                                    class="flex gap-4">
                                                    <span
                                                        class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary text-white text-[12px] font-bold mt-0.5">
                                                        {{ dok.nomor }}
                                                    </span>
                                                    <div class="flex-1">
                                                        <p
                                                            class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-2">
                                                            {{ dok.judul }}</p>
                                                        <ul v-if="dok.items?.length" class="space-y-1.5 mb-2">
                                                            <li v-for="(point, pi) in dok.items"
                                                                :key="`fddp-point-${pi}`"
                                                                class="flex items-start gap-2 text-[13px] leading-[1.6] text-[#3D3D3A]">
                                                                <span
                                                                    class="mt-[7px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                                                <span>{{ point }}</span>
                                                            </li>
                                                        </ul>
                                                        <p v-if="dok.desc"
                                                            class="text-[13px] leading-[1.7] text-[#3D3D3A]">{{ dok.desc
                                                            }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- 4. Dasar Hukum -->
                            <div v-if="selectedPaket.dasar_hukum?.length"
                                class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                <div class="flex items-center gap-3 mb-5">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Dasar Hukum
                                    </h2>
                                </div>
                                <ul class="space-y-4">
                                    <li v-for="(hukum, i) in selectedPaket.dasar_hukum" :key="`hukum-${i}`"
                                        class="flex items-start gap-4">
                                        <span
                                            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-[#ddffe3]">
                                            <img src="/icons/ft-save.svg" class="w-4 h-4" alt="" />
                                        </span>
                                        <span class="text-[13px] leading-[1.7] text-[#3D3D3A] text-justify">{{ hukum
                                        }}</span>
                                    </li>
                                </ul>
                            </div>

                        </template>
                    </div>

                    <!-- ===== KANAN: Sidebar ===== -->
                    <div class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start">

                        <!-- Price Card -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <div class="mb-3 inline-flex items-center gap-1.5 rounded-full bg-[#FFF0EF] px-3 py-1">
                                <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                <span class="text-[11px] font-semibold text-primary truncate max-w-[160px]">
                                    {{ selectedPaket?.nama ?? product.name }}
                                </span>
                            </div>
                            <div class="text-[12px] text-[#686964] mb-1 mt-2">Start From</div>
                            <div class="text-[32px] font-bold leading-none text-primary mb-1">
                                {{ selectedPaket?.harga ?? product.price_label }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">*Harga final dikonfirmasi setelah konsultasi
                            </div>
                            <a :href="buildWhatsappLink(product.name, selectedPaket?.nama ?? '')" target="_blank"
                                rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary py-2.5 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors mb-2">
                                Pesan Sekarang
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                            <a :href="buildWhatsappLink(product.name, selectedPaket?.nama ?? '')" target="_blank"
                                rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg border border-[#E8E8E6] py-2.5 text-[13px] font-semibold text-[#3D3D3A] hover:bg-[#F7F7F5] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                Konsultasi Gratis via Whatsapp
                            </a>
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                    Konsultasi pertama gratis
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                    Harga transparan, tanpa biaya tersembunyi
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                    Tim berpengalaman 18+ tahun
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                    Update proses berkala via WhatsApp
                                </li>
                            </ul>
                        </div>

                        <!-- VIP Line Banner -->
                        <div class="rounded-2xl px-5 py-6 text-center overflow-hidden relative"
                            style="background-image: url('/images/card-arrow-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <div class="relative mb-4">
                                <div class="inline-block w-full rounded-xl border border-white/60 px-4 py-2.5">
                                    <span
                                        class="text-[14px] font-extrabold uppercase tracking-widest text-white">FASTTRACK
                                        – VIP
                                        LINE</span>
                                </div>
                            </div>
                            <p class="relative text-[14px] leading-[1.6] text-white/90 mb-5">
                                Pendirian Badan Usaha Selesai dalam<br />1 (Satu) Hari
                            </p>
                            <a :href="buildWhatsappLink(product.name, selectedPaket?.nama ?? '')" target="_blank"
                                rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                Pesan Layanan Sekarang
                            </a>
                            <div class="relative mt-3 text-[11px] text-white/60">* (S&amp;K BERLAKU)</div>
                        </div>

                        <!-- Layanan Akta Notaris Lainnya (paket lain) -->
                        <div v-if="product.paket?.length > 1" class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">Layanan Akta Notaris Lainnya</h3>
                            <div class="flex flex-col gap-2">
                                <button v-for="paket in product.paket.filter(p => p.id !== selectedPaketId)"
                                    :key="`other-${paket.id}`"
                                    @click="() => { selectedPaketId = paket.id; openItemId = null; }"
                                    class="group flex items-center justify-between rounded-xl border border-[#E8E8E6] bg-white px-4 py-3 text-left hover:border-primary/30 hover:shadow-sm transition-all">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-[#FFF0EF]">
                                            <img src="/icons/ft-persons.svg" class="w-4 h-4" alt="" />
                                        </div>
                                        <div>
                                            <p
                                                class="text-[12px] font-semibold text-[#1A1B18] group-hover:text-primary transition-colors leading-snug">
                                                {{ paket.nama }}
                                            </p>
                                            <p class="text-[11px] font-bold text-primary">Mulai dari {{ paket.harga }}
                                            </p>
                                        </div>
                                    </div>
                                    <svg class="h-4 w-4 flex-shrink-0 text-[#686964] group-hover:text-primary transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Layanan Terkait -->
                        <div v-if="relatedProducts.length" class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">Layanan Terkait</h3>
                            <div class="flex flex-col gap-3">
                                <a v-for="(related, index) in relatedProducts.slice(0, 3)" :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex flex-col gap-2 rounded-xl border border-[#E8E8E6] bg-white p-4 hover:border-primary/30 hover:shadow-sm transition-all">
                                    <div
                                        class="text-[14px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors">
                                        {{ related.name }}
                                    </div>
                                    <p class="text-[12px] leading-[1.6] text-[#686964] line-clamp-3">
                                        {{ related.excerpt ?? related.description }}
                                    </p>
                                    <hr class="border-[#E8E8E6]" />
                                    <div>
                                        <div class="text-[11px] text-[#686964] mb-0.5">Mulai dari</div>
                                        <div class="text-[18px] font-bold text-primary leading-none">{{
                                            related.price_label }}</div>
                                    </div>
                                    <div
                                        class="mt-1 flex items-center justify-center gap-2 rounded-xl border border-primary py-2.5 text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors">
                                        Selengkapnya
                                        <svg class="h-4 w-4 group-hover:translate-x-0.5 transition-transform"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Footer CTA -->
        <section class="bg-[#F7F7F5] mb-12 sm:mb-16">
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
                        <a :href="buildWhatsappLink('layanan akta notaris')" target="_blank" rel="noopener noreferrer"
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