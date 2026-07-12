<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import { computed } from "vue";
import { useI18n } from "vue-i18n";

const { locale } = useI18n();

const props = defineProps({
    product: { type: Object, required: true },
    relatedProducts: { type: Array, default: () => [] },
});

const whatsappNumber = "6282298604144";

const buildWhatsappLink = (productName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${productName}.`;
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

// Helper: pick nilai berdasarkan locale, fallback ke 'id'
const pick = (field) => {
    if (field === null || field === undefined) return field;
    if (
        typeof field === "object" &&
        !Array.isArray(field) &&
        ("id" in field || "en" in field || "zh" in field)
    ) {
        return field[locale.value] ?? field.id ?? field;
    }
    return field;
};

const localizedProduct = computed(() => {
    const p = props.product;
    if (!p) return p;

    return {
        ...p,
        name: pick(p.name),
        excerpt: pick(p.excerpt),
        sections: pick(p.sections) ?? [],
        faq: pick(p.faq) ?? [],
    };
});

const product = localizedProduct;
</script>

<template>
    <MainLayout>
        <!-- Hero -->
        <section class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px] bg-[#9e1f16]">
            <img src="/icons/left-arrow.svg"
                class="absolute right-0 -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block" alt="" />
            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]">
                <nav aria-label="Breadcrumb">
                    <div class="hidden sm:inline-flex items-center gap-2 rounded-md bg-white px-4 py-2">
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
                        <a href="/naturalisasi" class="text-sm font-medium text-[#9e1f16] hover:underline">Naturalisasi</a>
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
                    <a href="/naturalisasi"
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
                <div class="grid gap-8 lg:grid-cols-[1fr_300px] xl:grid-cols-[1fr_320px] min-w-0">

                    <!-- ===== KIRI ===== -->
                    <div class="flex flex-col gap-5 min-w-0">

                        <template v-for="section in product.sections" :key="section.id">

                            <!-- Type: penjelasan -->
                            <div v-if="section.type === 'penjelasan'"
                                class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                <div class="flex items-center gap-3 mb-5">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ section.title }}</h2>
                                </div>
                                <div class="space-y-3">
                                    <template v-for="(block, bi) in section.content" :key="`blk-${bi}`">
                                        <p v-if="block.type === 'paragraph'"
                                            class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">
                                            {{ block.text }}
                                        </p>
                                        <p v-else-if="block.type === 'title'"
                                            class="text-[14px] font-bold text-[#1A1B18] leading-snug pt-2">
                                            {{ block.text }}
                                        </p>
                                        <ul v-else-if="block.type === 'bullets'" class="space-y-1.5 pl-1">
                                            <li v-for="(item, ii) in block.items" :key="`bul-${bi}-${ii}`"
                                                class="flex items-start gap-2 text-[14px] leading-[1.7] text-[#3D3D3A]">
                                                <span class="mt-[7px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                                <span>{{ item }}</span>
                                            </li>
                                        </ul>
                                    </template>
                                </div>
                            </div>

                            <!-- Type: numbered_detail -->
                            <div v-else-if="section.type === 'numbered_detail'"
                                class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                                <div class="flex items-center gap-3 mb-5">
                                    <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                    <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">{{ section.title }}</h2>
                                </div>

                                <!-- Intro paragraphs -->
                                <div v-if="section.intro_paragraphs?.length" class="space-y-4 mb-6">
                                    <p v-for="(p, pi) in section.intro_paragraphs" :key="`intro-${pi}`"
                                        class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify">{{ p }}</p>
                                </div>
                                <p v-else-if="section.intro"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify mb-6">{{ section.intro }}</p>

                                <ol class="space-y-5">
                                    <li v-for="(item, ni) in section.items" :key="`nd-${ni}`">
                                        <p class="text-[14px] text-[#1A1B18] leading-snug mb-1.5">
                                            <span class="font-normal">{{ ni + 1 }}.&nbsp;</span>
                                            <span class="font-bold">{{ item.title }}</span>
                                        </p>
                                        <p v-if="item.desc"
                                            class="text-[14px] leading-[1.7] text-[#3D3D3A] text-justify mb-2 pl-5">
                                            {{ item.desc }}
                                        </p>
                                        <ul v-if="item.bullets?.length" class="space-y-1 mb-2 pl-5">
                                            <li v-for="(b, bi) in item.bullets" :key="`ndb-${ni}-${bi}`"
                                                class="flex items-start gap-2 text-[14px] leading-[1.7] text-[#3D3D3A]">
                                                <span class="mt-[8px] h-1.5 w-1.5 flex-shrink-0 rounded-full bg-[#3D3D3A]"></span>
                                                <span>{{ b }}</span>
                                            </li>
                                        </ul>
                                        <p v-if="item.after_bullets"
                                            class="text-[14px] leading-[1.7] text-[#3D3D3A] text-justify pl-5">
                                            {{ item.after_bullets }}
                                        </p>
                                    </li>
                                </ol>
                            </div>

                        </template>

                        <!-- Biaya Layanan -->
                        <div class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8">
                            <div class="flex items-center gap-3 mb-5">
                                <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
                                <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">Biaya Layanan</h2>
                            </div>
                            <div
                                class="rounded-xl overflow-hidden"
                                style="background-image: url('/images/card-arrow-item-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                                <div class="flex items-center gap-4 px-5 py-5">
                                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-white">
                                        <img src="/icons/ft-persons.svg" class="w-6 h-6" alt="" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-[11px] text-white/70 uppercase tracking-wide mb-0.5">
                                            {{ product.name }}
                                        </div>
                                        <div class="text-[22px] font-bold text-white leading-tight">
                                            Hubungi Kami
                                        </div>
                                    </div>
                                    <a :href="buildWhatsappLink(product.name)"
                                        target="_blank" rel="noopener noreferrer"
                                        class="flex items-center gap-2 rounded-lg border border-white px-5 py-2.5 text-[13px] font-semibold text-white whitespace-nowrap hover:bg-white/10 transition-colors flex-shrink-0">
                                        Hubungi Kami
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- ===== END KIRI ===== -->

                    <!-- ===== KANAN: Sidebar ===== -->
                    <div class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start min-w-0">

                        <!-- VIP Line Banner -->
                        <div class="rounded-2xl px-5 py-6 text-center overflow-hidden relative"
                            style="background-image: url('/images/card-arrow-bg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <div class="relative mb-4">
                                <div class="inline-block w-full rounded-xl border border-white/60 px-4 py-2.5">
                                    <span class="text-[14px] font-extrabold uppercase tracking-widest text-white">FASTRACK – VIP LINE</span>
                                </div>
                            </div>
                            <p class="relative text-[14px] leading-[1.6] text-white/90 mb-5">
                                Draft Perjanjian Membuat Selesai<br />dalam 1 (Satu) Hari
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
                                <span class="text-[11px] font-semibold text-primary">Free Konsultasi</span>
                            </div>
                            <p class="text-[13px] font-bold text-[#1A1B18] leading-snug mb-3 mt-1">
                                {{ product.name }}
                            </p>
                            <div class="text-[12px] text-[#686964] mb-1">Start From</div>
                            <div class="text-[28px] font-bold leading-none text-primary mb-1">
                                {{ product.price_label }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">
                                *Harga final dikonfirmasi setelah konsultasi
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
                                            {{ pick(related.name) }}
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

        <FooterCTA
            title="Butuh Konsultasi Naturalisasi?"
            description="Tim kami siap membantu proses naturalisasi dan alih kewarganegaraan<br class='hidden sm:block' /> sesuai ketentuan hukum yang berlaku."
            :whatsapp-link="buildWhatsappLink(product.name)"
        />
    </MainLayout>
</template>