<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
    product: { type: Object, required: true },
    relatedProducts: { type: Array, default: () => [] },
});

const whatsappNumber = "6282298604144";

const buildWhatsappLink = (productName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${productName}.`;
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};
</script>

<template>
    <MainLayout>
        <!-- Hero -->
        <section class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px] bg-[#9e1f16]">
            <img src="/icons/left-arrow.svg"
                class="absolute right-0 -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block" alt="" />
            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]">
                <nav aria-label="Breadcrumb">
                    <div class="inline-flex items-center gap-2 rounded-md bg-white px-4 py-2">
                        <a href="/" class="text-[#9e1f16] hover:text-black transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
                            </svg>
                        </a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/layanan" class="text-sm font-medium text-[#9e1f16] hover:underline">Layanan</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/sertifikasi-badan-usaha" class="text-sm font-medium text-[#9e1f16] hover:underline">Sertifikasi Badan Usaha</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#9e1f16]">{{ product.name }}</span>
                    </div>
                </nav>
                <div class="flex items-center gap-5">
                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white shadow-md">
                        <img src="/icons/ft-persons.svg" class="w-9 h-9" alt="" />
                    </div>
                    <h1 class="text-3xl font-extrabold leading-tight text-white sm:text-4xl lg:text-5xl max-w-[800px] line-clamp-2">
                        {{ product.name }}
                    </h1>
                </div>
                <div>
                    <a href="/sertifikasi-badan-usaha"
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
                <div class="grid gap-8 lg:grid-cols-[1fr_300px] xl:grid-cols-[1fr_320px]">

                    <!-- ===== KIRI ===== -->
                    <div class="flex flex-col gap-5">

                        <!-- 1. Penjelasan Umum / Kamar Dagang -->
                        <div v-if="product.penjelasan_umum?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    {{ product.penjelasan_title ?? 'Penjelasan Umum' }}
                                </h2>
                            </div>
                            <div class="space-y-4">
                                <template v-for="(block, i) in product.penjelasan_umum" :key="`pu-${i}`">
                                    <template v-if="typeof block === 'object'">
                                        <p v-if="block.type === 'title'"
                                            class="text-[14px] font-bold text-[#1A1B18] leading-snug pt-2">
                                            {{ block.text }}
                                        </p>
                                        <ul v-else-if="block.type === 'bullets'" class="space-y-1.5 pl-1">
                                            <li v-for="(item, bi) in block.items" :key="`bu-${bi}`"
                                                class="flex items-start gap-2 text-[14px] leading-[1.7] text-[#3D3D3A]">
                                                <span class="mt-[7px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                                <span>{{ item }}</span>
                                            </li>
                                        </ul>
                                    </template>
                                    <p v-else class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">{{ block }}</p>
                                </template>
                            </div>
                        </div>

                        <!-- 2. Biaya Layanan -->
                        <div v-if="product.biaya_layanan_cards?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Biaya Layanan</h2>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div v-for="(card, ci) in product.biaya_layanan_cards" :key="`card-${ci}`"
                                    class="rounded-xl border border-[#E8E8E6] p-5 flex flex-col">

                                    <!-- Nama & Harga -->
                                    <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-1">{{ card.nama }}</p>
                                    <p class="text-[11px] text-[#686964] mb-0.5">Mulai dari</p>
                                    <p class="text-[22px] font-bold text-primary leading-tight mb-2">{{ card.harga }}</p>
                                    <div v-if="card.gratis_konsultasi" class="flex items-center gap-1.5 mb-4">
                                        <img src="/icons/ft-done.svg" class="h-4 w-4 flex-shrink-0" alt="" />
                                        <span class="text-[11px] text-[#3D3D3A]">GRATIS Konsultasi Pra dan Pasca Seleksi</span>
                                    </div>

                                    <hr class="border-[#E8E8E6] mb-4" />

                                    <!-- Mendapatkan -->
                                    <div v-if="card.mendapatkan?.length" class="mb-4">
                                        <p class="text-[12px] font-bold text-[#1A1B18] mb-2.5">Mendapatkan</p>
                                        <ul class="space-y-2">
                                            <li v-for="(m, mi) in card.mendapatkan" :key="`m-${ci}-${mi}`"
                                                class="flex items-start gap-2">
                                                <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                                <span class="text-[12px] leading-[1.6] text-[#3D3D3A]">{{ m }}</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Syarat -->
                                    <div v-if="card.syarat?.length" class="mb-4">
                                        <p class="text-[12px] font-bold text-[#1A1B18] mb-2.5">Syarat</p>
                                        <div class="space-y-3">
                                            <div v-for="(s, si) in card.syarat" :key="`s-${ci}-${si}`">
                                                <p v-if="s.label"
                                                    class="text-[12px] font-semibold text-[#1A1B18] mb-1.5">
                                                    {{ s.label }}
                                                </p>
                                                <ul v-if="s.items?.length" class="space-y-1">
                                                    <li v-for="(item, ii) in s.items" :key="`si-${ci}-${si}-${ii}`"
                                                        class="flex items-start gap-2 text-[12px] leading-[1.6] text-[#3D3D3A]">
                                                        <span class="mt-[6px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                                        <span>{{ item }}</span>
                                                    </li>
                                                </ul>
                                                <!-- item plain text tanpa sub-label -->
                                                <p v-else-if="s.text"
                                                    class="text-[12px] leading-[1.6] text-[#3D3D3A]">
                                                    {{ s.text }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Termasuk -->
                                    <div v-if="card.termasuk?.length" class="mb-5">
                                        <p class="text-[12px] font-bold text-[#1A1B18] mb-2.5">Termasuk</p>
                                        <ul class="space-y-2">
                                            <li v-for="(t, ti) in card.termasuk" :key="`t-${ci}-${ti}`"
                                                class="flex items-start gap-2">
                                                <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="" />
                                                <span class="text-[12px] leading-[1.6] text-[#3D3D3A]">{{ t }}</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Tombol -->
                                    <div class="mt-auto pt-2">
                                        <a :href="buildWhatsappLink(card.nama)"
                                            target="_blank" rel="noopener noreferrer"
                                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-primary py-3 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors">
                                            Pesan Sekarang
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- ===== END KIRI ===== -->

                    <!-- ===== KANAN: Sidebar ===== -->
                    <div class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start">

                        <!-- VIP Line Banner -->
                        <div class="rounded-2xl px-5 py-6 text-center overflow-hidden relative"
                            style="background-image: url('/images/card-arrow-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <div class="relative mb-4">
                                <div class="inline-block w-full rounded-xl border border-white/60 px-4 py-2.5">
                                    <span class="text-[14px] font-extrabold uppercase tracking-widest text-white">FASTRACK – VIP LINE</span>
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
                            <div class="relative mt-3 text-[11px] text-white/60">* (S&amp;K BERLAKU)</div>
                        </div>

                        <!-- Price Card -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <div class="mb-3 inline-flex items-center gap-1.5 rounded-full bg-[#FFF0EF] px-3 py-1">
                                <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                <span class="text-[11px] font-semibold text-primary truncate max-w-[180px]">
                                    {{ product.name }}
                                </span>
                            </div>
                            <div class="text-[12px] text-[#686964] mb-1 mt-2">Start From</div>
                            <div class="text-[28px] font-bold leading-none text-primary mb-4">
                                {{ product.price_label }}
                            </div>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg border border-[#E8E8E6] py-2.5 text-[13px] font-semibold text-[#3D3D3A] hover:bg-[#F7F7F5] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-5 w-5 flex-shrink-0" alt="wa" />
                                Konsultasi Gratis via Whatsapp
                            </a>
                        </div>

                        <!-- Layanan Terkait -->
                        <div v-if="relatedProducts.length" class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">Layanan Terkait</h3>
                            <div class="flex flex-col gap-3">
                                <a v-for="(related, index) in relatedProducts.slice(0, 3)" :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex items-center gap-3 rounded-xl border border-[#E8E8E6] bg-white p-3 hover:border-primary/30 hover:shadow-sm transition-all">
                                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-[#FFF0EF]">
                                        <img src="/icons/ft-persons.svg" class="w-5 h-5" alt="" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[13px] font-semibold text-[#1A1B18] group-hover:text-primary transition-colors leading-snug line-clamp-2">
                                            {{ related.name }}
                                        </p>
                                        <p class="text-[11px] text-[#686964] mt-0.5">Mulai dari {{ related.price_label }}</p>
                                    </div>
                                    <svg class="h-4 w-4 flex-shrink-0 text-[#686964] group-hover:text-primary transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </div>
                    <!-- ===== END KANAN ===== -->

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
                        <h3 class="max-w-2xl text-[22px] font-bold leading-[32px] text-white sm:text-[28px] sm:leading-[38px]">
                            Butuh Konsultasi Sertifikasi Badan Usaha?
                        </h3>
                        <p class="mt-4 max-w-lg text-[14px] leading-[22px] text-white/80 sm:text-[16px] sm:leading-[24px]">
                            Tim kami siap membantu memilih jenis sertifikasi yang tepat<br class="hidden sm:block" />
                            dan mendampingi seluruh prosesnya.
                        </p>
                        <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
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