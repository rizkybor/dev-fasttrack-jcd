<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref, computed } from "vue";

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

const whatsappNumber = "6282298604144";

const buildWhatsappLink = (productName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${productName}.`;
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

const currentDasarHukum = computed(() => props.product?.dasar_hukum ?? []);
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px] bg-[#9e1f16]">
            <div class="ml-5">
                <img src="/icons/left-arrow.svg"
                    class="absolute right-[0%] -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block" alt="" />
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
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/layanan" class="text-sm font-medium text-[#9e1f16] hover:underline">Layanan</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/kekayaan-intelektual" class="text-sm font-medium text-[#9e1f16] hover:underline">Kekayaan Intelektual</a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#9e1f16]">{{ product.name }}</span>
                    </div>
                </nav>

                <!-- Heading -->
                <div class="flex items-center gap-5">
                    <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white shadow-md">
                        <img src="/icons/ft-persons.svg" class="w-9 h-9" alt="" />
                    </div>
                    <h1 class="text-3xl font-extrabold leading-tight text-white sm:text-4xl lg:text-5xl max-w-[800px] line-clamp-2">
                        {{ product.name }}
                    </h1>
                </div>

                <!-- Back -->
                <div>
                    <a href="/kekayaan-intelektual"
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

                    <!-- ===== KIRI ===== -->
                    <div class="flex flex-col gap-6">

                        <!-- 1. Penjelasan Umum -->
                        <div v-if="product.content?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    Penjelasan Umum
                                </h2>
                            </div>
                            <div class="space-y-4">
                                <template v-for="(item, index) in product.content" :key="`content-${index}`">
                                    <p v-if="typeof item === 'string'"
                                        class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">
                                        {{ item }}
                                    </p>
                                    <p v-else-if="item.text"
                                        class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">
                                        <span class="font-semibold text-[#1A1B18]">{{ item.label }}: </span>
                                        <span>{{ item.text }}</span>
                                    </p>
                                    <div v-else-if="item.items?.length" class="space-y-2.5">
                                        <p class="text-[14px] leading-[1.8] font-semibold text-[#1A1B18]">{{ item.label }}:</p>
                                        <div v-for="(sub, si) in item.items" :key="`sub-${index}-${si}`"
                                            class="flex items-start gap-3 pl-0.5">
                                            <span class="flex-shrink-0 w-[6px] h-[6px] rounded-full bg-[#9e1f16] mt-[9px]"></span>
                                            <span v-if="typeof sub === 'string'" class="text-[14px] leading-[1.8] text-[#3D3D3A]">{{ sub }}</span>
                                            <span v-else class="text-[14px] leading-[1.8] text-[#3D3D3A]">
                                                <span class="font-semibold text-[#1A1B18]">{{ sub.label }}</span>
                                                <span v-if="sub.text"> {{ sub.text }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- 2. Manfaat (array of string) -->
                        <div v-if="product.benefits?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    Manfaat {{ product.name }}
                                </h2>
                            </div>
                            <ul class="space-y-3">
                                <li v-for="(benefit, index) in product.benefits" :key="`benefit-${index}`"
                                    class="flex items-start gap-2.5">
                                    <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-[#25D366]"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="12" r="10" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                                    </svg>
                                    <span class="text-[14px] leading-[1.7] text-[#3D3D3A]">{{ benefit }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- 3. Kriteria -->
                        <div v-if="product.criteria?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                    Kriteria {{ product.name }} yang Dapat Didaftarkan
                                </h2>
                            </div>
                            <ol class="space-y-3">
                                <li v-for="(item, index) in product.criteria" :key="`criteria-${index}`"
                                    class="flex items-start gap-3 text-[14px] leading-[1.7] text-[#3D3D3A]">
                                    <span class="flex-shrink-0 text-[13px] font-semibold text-[#1A1B18] mt-0.5">
                                        {{ index + 1 }}.
                                    </span>
                                    <span>{{ item }}</span>
                                </li>
                            </ol>
                        </div>

                        <!-- 4. Biaya Layanan -->
                        <div v-if="product.plans?.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5 sm:p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <img src="/icons/ic-menu-arrow.svg" class="w-5 h-5 sm:w-6 sm:h-6" alt="" />
                                <h2 class="text-[13px] sm:text-[15px] font-bold uppercase tracking-widest text-black">
                                    Biaya Layanan
                                </h2>
                            </div>

                            <div class="grid grid-cols-1 gap-4"
                                :class="[
                                    product.plans.length === 1 ? 'sm:grid-cols-1' :
                                    product.plans.length === 2 ? 'sm:grid-cols-2' :
                                    'sm:grid-cols-3'
                                ]">
                                <div v-for="(plan, pi) in product.plans" :key="`plan-${pi}`"
                                    class="rounded-xl bg-[#9e1f16] p-4 sm:p-5 flex flex-col gap-3">
                                    <!-- Nama Paket -->
                                    <div class="text-[13px] sm:text-[14px] font-bold text-white leading-tight">
                                        {{ plan.name }}
                                    </div>

                                    <!-- Harga + CTA -->
                                    <div class="flex items-end justify-between gap-3">
                                        <div>
                                            <div class="text-[11px] text-white/70">Mulai dari</div>
                                            <div class="text-[18px] sm:text-[20px] font-bold text-white leading-tight">
                                                {{ plan.price }}
                                            </div>
                                        </div>
                                        <a :href="buildWhatsappLink(plan.name)" target="_blank" rel="noopener noreferrer"
                                            class="flex-shrink-0 inline-flex items-center gap-1.5 rounded-lg bg-white px-4 py-2 text-[12px] font-semibold text-[#9e1f16] hover:bg-white/90 transition-colors">
                                            {{ plan.cta ?? 'Hubungi Kami' }}
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Blue Info Box -->
                            <div v-if="product.plans_info"
                                class="mt-4 rounded-xl bg-[#EFF6FF] border border-[#BFDBFE] px-4 py-3 flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-[#3B82F6] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-[12px] sm:text-[13px] leading-[1.6] text-[#1E40AF]">{{ product.plans_info }}</p>
                            </div>
                        </div>

                        <!-- 5. Dasar Hukum (Accordion) -->
                        <div v-if="currentDasarHukum.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white overflow-hidden">
                            <button @click="dasarHukumOpen = !dasarHukumOpen"
                                class="w-full flex items-center justify-between p-6 sm:p-8 text-left">
                                <div class="flex items-center gap-3">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                                        Dasar Hukum
                                    </h2>
                                </div>
                                <svg class="h-5 w-5 text-[#686964] flex-shrink-0 transition-transform duration-200"
                                    :class="dasarHukumOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div v-show="dasarHukumOpen" class="px-6 sm:px-8 pb-6 sm:pb-8 border-t border-[#E8E8E6]">
                                <ul class="mt-5 space-y-4">
                                    <li v-for="(hukum, hi) in currentDasarHukum" :key="`hukum-${hi}`"
                                        class="flex items-start gap-4">
                                        <span class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-[#ddffe3]">
                                            <img src="/icons/ft-save.svg" class="w-4 h-4" alt="" />
                                        </span>
                                        <span class="text-[13px] leading-[1.7] text-[#3D3D3A] text-justify">{{ hukum }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <!-- ===== KANAN: Sidebar ===== -->
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
                            <div class="mb-4 flex items-center justify-between rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] px-3 py-2.5">
                                <span class="text-[13px] text-[#1A1B18]">{{ product.name }}</span>
                                <svg class="h-4 w-4 text-[#686964]" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <div class="text-[12px] text-[#686964] mb-1">Estimasi total biaya</div>
                            <div class="text-[32px] font-bold leading-none text-primary mb-1">
                                {{ product.price_label }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">
                                *Harga final dikonfirmasi setelah konsultasi
                            </div>
                            <a :href="buildWhatsappLink(product.name)" target="_blank" rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors">
                                <img src="/icons/ft-wa.svg" class="mt-0.5 h-6 w-6 flex-shrink-0" alt="wa" />
                                Konsultasi Gratis via Whatsapp
                            </a>
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Konsultasi pertama gratis
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Harga transparan, tanpa biaya tersembunyi
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Tim berpengalaman 18+ tahun
                                </li>
                                <li class="flex items-center gap-2 text-[12px] text-[#3D3D3A]">
                                    <img src="/icons/ft-done.svg" class="mt-0.5 h-4 w-4 flex-shrink-0" alt="done" />
                                    Update proses berkala via WhatsApp
                                </li>
                            </ul>
                        </div>

                        <!-- Layanan Terkait -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-5">
                            <h3 class="text-[13px] font-bold text-[#1A1B18] mb-4">Layanan Terkait</h3>
                            <div class="flex flex-col gap-3">
                                <a v-for="(related, index) in relatedProducts.slice(0, 3)" :key="`related-${index}`"
                                    :href="related.detail_path"
                                    class="group flex flex-col gap-2 rounded-xl border border-[#E8E8E6] bg-white p-4 hover:border-primary/30 hover:shadow-sm transition-all">
                                    <div class="text-[14px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors">
                                        {{ related.name }}
                                    </div>
                                    <p class="text-[12px] leading-[1.6] text-[#686964] line-clamp-3">
                                        {{ related.excerpt ?? related.description }}
                                    </p>
                                    <hr class="border-[#E8E8E6]" />
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-[11px] text-[#686964] mb-0.5">Mulai dari</div>
                                            <div class="text-[18px] font-bold text-primary leading-none">
                                                {{ related.price_label }}
                                            </div>
                                        </div>
                                        <span class="text-[11px] font-medium text-[#3D3D3A] border border-[#E8E8E6] rounded-md px-2 py-1">
                                            {{ related.plans ? related.plans.length : 0 }} Paket
                                        </span>
                                    </div>
                                    <div class="mt-1 flex items-center justify-center gap-2 rounded-xl border border-primary py-2.5 text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors">
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

        <!-- Footer CTA Banner -->
        <section class="bg-[#F7F7F5] mb-12 sm:mb-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-2xl bg-[#9e1f16] px-6 py-12 sm:px-10 sm:py-14">
                    <img src="/icons/ft-docs.svg" alt=""
                        class="absolute right-6 top-6 h-16 w-16 opacity-20 sm:right-10 sm:top-8 sm:h-24 sm:w-24" />
                    <div class="relative flex flex-col items-center text-center">
                        <h3 class="max-w-2xl text-[22px] font-bold leading-[32px] text-white sm:text-[28px] sm:leading-[38px]">
                            Tidak Menemukan Layanan yang Anda Cari?
                        </h3>
                        <p class="mt-4 max-w-lg text-[14px] leading-[22px] text-white/80 sm:text-[16px] sm:leading-[24px]">
                            Tim kami siap membantu Anda menemukan solusi yang tepat<br class="hidden sm:block" />
                            untuk kebutuhan legalitas bisnis Anda.
                        </p>
                        <a :href="buildWhatsappLink('layanan yang tidak terdaftar')" target="_blank" rel="noopener noreferrer"
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