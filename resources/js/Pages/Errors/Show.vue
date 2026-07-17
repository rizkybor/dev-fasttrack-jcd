<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
import MainLayout from "@/Layouts/MainLayout.vue";
import { waLink } from "@/Composables/useWhatsapp";

const props = defineProps({
    status: {
        type: Number,
        default: 404,
    },
});

const { t, te } = useI18n();

const errorKey = computed(() =>
    te(`errors.${props.status}.title`) ? props.status : 404,
);

const whatsappLink = computed(() =>
    waLink(t(`errors.${errorKey.value}.title`), {
        greeting: `Halo FastTrack, saya mengalami kendala mengakses website (kode ${props.status}). Mohon bantuannya.`,
    }),
);

const quickLinks = computed(() => [
    { label: t("errors.popular_links.layanan"), href: "/layanan" },
    { label: t("errors.popular_links.minta_penawaran"), href: "/minta-penawaran" },
    { label: t("errors.popular_links.artikel"), href: "/artikel" },
    { label: t("errors.popular_links.faq"), href: "/faq" },
]);
</script>

<template>
    <MainLayout>
        <section class="relative overflow-hidden bg-[#F9F9F9] py-16 sm:py-24">
            <img
                src="/icons/left-arrow.svg"
                class="absolute -right-10 -top-10 h-72 w-auto opacity-[0.04] pointer-events-none hidden sm:block"
                alt=""
            />
            <img
                src="/icons/left-arrow.svg"
                class="absolute -left-16 bottom-0 h-64 w-auto opacity-[0.04] pointer-events-none hidden sm:block rotate-180"
                alt=""
            />

            <div class="relative mx-auto max-w-2xl px-4 sm:px-6 text-center">
                <p
                    class="text-[72px] sm:text-[96px] font-extrabold leading-none tracking-tight text-[#9e1f16]"
                >
                    {{ status }}
                </p>

                <h1
                    class="mt-4 text-2xl sm:text-3xl font-extrabold text-[#1A1B18]"
                >
                    {{ t(`errors.${errorKey}.title`) }}
                </h1>
                <p class="mt-3 text-sm sm:text-base leading-relaxed text-[#7A7B78]">
                    {{ t(`errors.${errorKey}.desc`) }}
                </p>

                <p class="mt-2 text-[11px] uppercase tracking-wide text-[#B0B1AE]">
                    {{ t("errors.code_label") }}: {{ status }}
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <Link
                        href="/"
                        class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-[#9e1f16] px-6 py-3 text-[13px] font-semibold text-white transition hover:bg-[#7f1912]"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"
                            />
                        </svg>
                        {{ t("errors.home_cta") }}
                    </Link>
                    <Link
                        href="/layanan"
                        class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg border border-[#D9DAD8] bg-white px-6 py-3 text-[13px] font-semibold text-[#1A1B18] transition hover:border-[#9e1f16]/40 hover:text-[#9e1f16]"
                    >
                        {{ t("errors.services_cta") }}
                    </Link>
                </div>

                <!-- Quick links -->
                <div class="mt-10">
                    <p class="text-[12px] font-medium text-[#7A7B78]">
                        {{ t("errors.popular_title") }}
                    </p>
                    <div class="mt-3 flex flex-wrap items-center justify-center gap-2">
                        <Link
                            v-for="link in quickLinks"
                            :key="link.href"
                            :href="link.href"
                            class="rounded-full border border-[#D9DAD8] bg-white px-4 py-1.5 text-[12px] font-medium text-[#4A4B47] transition hover:border-[#9e1f16]/40 hover:text-[#9e1f16]"
                        >
                            {{ link.label }}
                        </Link>
                    </div>
                </div>

                <!-- WhatsApp fallback -->
                <div class="mt-10 flex flex-col items-center gap-2">
                    <p class="text-[12px] text-[#B0B1AE]">
                        {{ t("errors.whatsapp_note") }}
                    </p>
                    <a
                        :href="whatsappLink"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#1E9E5A] hover:text-[#167A45] transition"
                    >
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12c0 1.85.5 3.58 1.36 5.07L2 22l5.06-1.33A9.94 9.94 0 0012 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm0 18c-1.6 0-3.1-.43-4.4-1.18l-.31-.18-3.08.81.82-3-.2-.32A7.94 7.94 0 014 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z"
                            />
                        </svg>
                        {{ t("errors.whatsapp_cta") }}
                    </a>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
