<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";

/**
 * Halaman "Article Detail" — artikel FastTrack Legal
 * Sesuai desain Figma: hero + info penulis + konten terstruktur + CTA banner
 *
 * Struktur `article.content` (array, urutan sesuai tampilan):
 *   { type: 'heading',   text: '...' }
 *   { type: 'paragraph', text: '...' }
 *   { type: 'bullets',   items: ['...', '...'] }
 *   { type: 'numbered',  items: ['...', '...'] }
 *   { type: 'image',     src: '/images/...', alt: '...', caption?: '...' }
 */

const props = defineProps({
    article: {
        type: Object,
        required: true,
        default: () => ({
            title: "",
            date: "",
            read_time: "",
            author: {
                name: "",
                role: "",
            },
            content: [],
        }),
    },
});

const authorInitials = computed(() => {
    const name = props.article.author?.name ?? "";
    return name
        .split(" ")
        .map((word) => word.charAt(0))
        .join("")
        .slice(0, 2)
        .toUpperCase();
});

/* ------------------------------------------------------------------ */
/* WhatsApp CTA                                                        */
/* ------------------------------------------------------------------ */

const whatsappNumber = "6282298604144";

const whatsappLink = computed(() => {
    const message =
        "Halo FastTrack, saya ingin konsultasi mengenai kebutuhan legalitas bisnis saya.";
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
});

/* ------------------------------------------------------------------ */
/* Lightbox — klik gambar artikel untuk memperbesar                    */
/* ------------------------------------------------------------------ */

const lightboxImage = ref(null);

const openLightbox = (src, alt = "") => {
    if (!src) return;
    lightboxImage.value = { src, alt };
};

const closeLightbox = () => {
    lightboxImage.value = null;
};

const handleEscape = (e) => {
    if (e.key === "Escape") closeLightbox();
};

onMounted(() => document.addEventListener("keydown", handleEscape));
onUnmounted(() => document.removeEventListener("keydown", handleEscape));
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-[#9e1f16]">
            <div class="ml-5">
                <img
                    src="/icons/left-arrow.svg"
                    class="absolute right-[0%] -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block"
                    alt=""
                />
            </div>

            <div
                class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-14 lg:py-16"
            >
                <div class="relative z-10 max-w-3xl">
                    <!-- Breadcrumb -->
                    <nav class="mb-6" aria-label="Breadcrumb">
                        <div
                            class="inline-flex items-center gap-2 rounded-full bg-white/20 backdrop-blur-sm px-4 py-2"
                        >
                            <a href="/" class="text-white/90 hover:text-white transition">
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
                            <a
                                href="/artikel"
                                class="text-sm font-medium text-white/90 hover:text-white transition"
                                >Artikel</a
                            >
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
                            <span class="text-sm font-medium text-white">Detail</span>
                        </div>
                    </nav>

                    <!-- Heading -->
                    <h1
                        class="text-2xl font-extrabold leading-tight text-white sm:text-3xl lg:text-4xl"
                    >
                        {{ article.title }}
                    </h1>

                    <!-- Back button -->
                    <div class="mt-8">
                        <a
                            href="/artikel"
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
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section class="py-[52px] bg-[#F9F9F9]">
            <div class="max-w-4xl mx-auto px-4 sm:px-6">
                <article
                    class="rounded-xl border border-[#D9DAD8] bg-white p-6 sm:p-8"
                >
                    <!-- Author & Meta -->
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#F1D9D7] text-[12px] font-bold text-[#9e1f16]"
                            >
                                {{ authorInitials }}
                            </span>
                            <div>
                                <p class="text-[12px] font-semibold text-[#1A1B18]">
                                    {{ article.author?.name }}
                                </p>
                                <p class="text-[11px] text-[#7A7B78]">
                                    {{ article.author?.role }}
                                </p>
                            </div>
                        </div>

                        <span
                            class="inline-flex items-center gap-1.5 text-[11px] text-[#7A7B78]"
                        >
                            <svg
                                class="h-3.5 w-3.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>
                            {{ article.date }}
                        </span>

                        <span
                            class="inline-flex items-center gap-1.5 text-[11px] text-[#7A7B78]"
                        >
                            <svg
                                class="h-3.5 w-3.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            {{ article.read_time }}
                        </span>
                    </div>

                    <div class="h-px w-full bg-[#E0E0E0] my-6"></div>

                    <!-- Featured Image -->
                    <img
                        v-if="article.image"
                        :src="article.image"
                        :alt="article.title"
                        class="mb-6 w-full max-w-xs mx-auto rounded-lg object-cover cursor-zoom-in transition hover:opacity-90"
                        @click="openLightbox(article.image, article.title)"
                    />

                    <!-- Article Body -->
                    <div class="flex flex-col gap-4">
                        <template v-for="(block, index) in article.content" :key="index">
                            <h2
                                v-if="block.type === 'heading'"
                                class="text-[15px] sm:text-[16px] font-bold text-[#1A1B18] mt-2"
                            >
                                {{ block.text }}
                            </h2>

                            <p
                                v-else-if="block.type === 'paragraph'"
                                class="text-[13px] leading-[24px] text-[#4A4B47] text-justify"
                            >
                                {{ block.text }}
                            </p>

                            <ul
                                v-else-if="block.type === 'bullets'"
                                class="list-disc pl-5 flex flex-col gap-1.5 marker:text-[#9e1f16]"
                            >
                                <li
                                    v-for="(item, i) in block.items"
                                    :key="i"
                                    class="text-[13px] leading-[22px] text-[#4A4B47]"
                                >
                                    {{ item }}
                                </li>
                            </ul>

                            <ol
                                v-else-if="block.type === 'numbered'"
                                class="list-decimal pl-5 flex flex-col gap-1.5 marker:text-[#9e1f16] marker:font-semibold"
                            >
                                <li
                                    v-for="(item, i) in block.items"
                                    :key="i"
                                    class="text-[13px] leading-[22px] text-[#4A4B47]"
                                >
                                    {{ item }}
                                </li>
                            </ol>

                            <figure
                                v-else-if="block.type === 'image'"
                                class="my-2"
                            >
                                <img
                                    :src="block.src"
                                    :alt="block.alt ?? ''"
                                    class="w-full max-w-xs mx-auto rounded-lg object-cover cursor-zoom-in transition hover:opacity-90"
                                    loading="lazy"
                                    @click="openLightbox(block.src, block.alt)"
                                />
                                <figcaption
                                    v-if="block.caption"
                                    class="mt-2 text-center text-[12px] text-[#7A7B78]"
                                >
                                    {{ block.caption }}
                                </figcaption>
                            </figure>
                        </template>
                    </div>
                </article>

                <!-- CTA BANNER -->
                <FooterCTA
                    class="mt-6"
                    title="Butuh Penjelasan Lebih Spesifik?"
                    description="Tim kami siap membantu Anda menemukan solusi yang tepat untuk kebutuhan legalitas bisnis Anda."
                    button-text="Chat Langsung via Whatsapp"
                    :whatsapp-link="whatsappLink"
                />
            </div>
        </section>

        <!-- Lightbox -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="lightboxImage"
                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 p-4 sm:p-8"
                @click="closeLightbox"
            >
                <button
                    type="button"
                    class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20"
                    aria-label="Tutup"
                    @click="closeLightbox"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <img
                    :src="lightboxImage.src"
                    :alt="lightboxImage.alt"
                    class="max-h-[85vh] max-w-full cursor-zoom-out rounded-lg object-contain"
                    @click.stop="closeLightbox"
                />
            </div>
        </Transition>
    </MainLayout>
</template>
