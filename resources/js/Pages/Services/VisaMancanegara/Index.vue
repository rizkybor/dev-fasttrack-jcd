<script setup>
import { computed } from "vue";
import { useI18n } from "vue-i18n";
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";

import { useWhatsapp } from "@/Composables/useWhatsapp.js";
const { t, tm } = useI18n();

const props = defineProps({
    service: { type: Object, required: true },
    products: { type: Array, default: () => [] },
});

const itemMeta = [
    { icon: "/icons/layanan/visa.svg", path: "/visaMancanegara" },
    // tambah sesuai jumlah item di locale
];

const DEFAULT_ICON = "/icons/layanan/visa.svg";
const DEFAULT_PATH = "/visaMancanegara";

const serviceList = computed(() => {
    const list = tm("services.visaMancanegara.list");
    if (!Array.isArray(list)) return [];
    return list.map((item, i) => ({
        ...item,
        icon: itemMeta[i]?.icon ?? DEFAULT_ICON,
        path: itemMeta[i]?.path ?? DEFAULT_PATH,
    }));
});

const { buildWhatsappLink } = useWhatsapp("default");
</script>

<template>
    <MainLayout>
        <!-- Hero Section -->
        <section
            class="relative overflow-hidden min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]"
        >
            <div class="absolute inset-0">
                <img
                    src="/images/layanan-hero/ft-hero-visa-mancanegara.png"
                    alt="Hero background"
                    class="h-full w-full object-cover object-center"
                />
                <div class="absolute inset-0 bg-black/35"></div>
            </div>

            <div
                class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px] lg:min-h-[360px]"
            >
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb">
                    <div
                        class="hidden sm:inline-flex items-center gap-2 rounded-md bg-white px-4 py-2"
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
                        >
                            {{
                                t("services.visaMancanegara.hero.breadcrumb.layanan")
                            }}
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
                        <span class="text-sm font-medium text-[#9e1f16]">
                            {{
                                t("services.visaMancanegara.hero.breadcrumb.current")
                            }}
                        </span>
                    </div>
                </nav>

                <!-- Heading + Desc + Back -->
                <div class="mt-auto pt-8">
                    <h1
                        class="text-2xl font-extrabold leading-tight text-white sm:text-3xl lg:text-4xl"
                    >
                        {{ t("services.visaMancanegara.hero.title")
                        }}<br class="hidden sm:block" />
                        <span class="text-white/90">{{
                            t("services.visaMancanegara.hero.titleSub")
                        }}</span>
                    </h1>
                    <p
                        class="mt-4 max-w-xl text-sm leading-relaxed text-white/80 sm:text-base sm:leading-7"
                    >
                        {{ t("services.visaMancanegara.hero.desc") }}
                    </p>
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
                            {{ t("services.visaMancanegara.hero.back") }}
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- LAYANAN SECTION -->
        <section id="layanan" class="py-[52px]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex flex-col gap-8">
                    <!-- Service Cards -->
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
                    >
                        <a
                            v-for="(item, idx) in serviceList"
                            :key="idx"
                            :href="`/visa-mancanegara/${item.id}`"
                            class="group flex flex-col rounded-[14px] border border-[#D9DAD8] bg-[#FEFEFE] p-[15px] backdrop-blur-[13px] transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:border-primary/30"
                        >
                            <div class="flex flex-col gap-4 flex-grow">
                                <div
                                    class="flex h-[60px] w-[60px] items-center justify-center rounded-lg bg-[#9e1f16]"
                                >
                                    <img
                                        :src="item.icon"
                                        class="w-6 h-6"
                                        alt=""
                                    />
                                </div>
                                <div class="flex flex-col gap-1">
                                    <!-- Title: clamp 2 baris, font lebih kecil -->
                                    <h4
                                        class="text-[14px] font-bold leading-[20px] text-[#1A1B18] line-clamp-2 min-h-[40px]"
                                    >
                                        {{ item.title }}
                                    </h4>

                                    <!-- Description: clamp 4 baris, height fix -->
                                    <p
                                        class="text-[13px] leading-[19px] text-[#282925] line-clamp-4 min-h-[76px]"
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

                            <div class="flex items-start justify-between gap-2">
                                <div class="flex flex-col gap-0.5">
                                    <span
                                        class="text-[11px] leading-[18px] text-[#1A1B18]"
                                    >
                                        {{
                                            t("services.visaMancanegara.items.from")
                                        }}
                                    </span>
                                    <span
                                        class="text-[20px] font-bold leading-[28px] text-primary"
                                    >
                                        {{ item.price }}
                                    </span>
                                </div>
                                <span
                                    v-if="item.packages != ''"
                                    class="inline-flex items-center border border-[#D9DAD8] rounded bg-[#F9F9F9] px-[7px] py-[3px] text-[11px] leading-[18px] text-[#1A1B18] whitespace-nowrap"
                                >
                                    {{ item.packages }}
                                </span>
                            </div>

                            <div
                                class="mt-4 flex items-center justify-center gap-2 rounded-lg border border-primary px-[15px] py-[11px] h-[44px] text-[13px] font-semibold text-primary group-hover:bg-[#9e1f16] group-hover:text-white transition-colors whitespace-nowrap"
                            >
                                {{ t("services.visaMancanegara.items.cta") }}
                                <svg
                                    class="w-4 h-4 group-hover:translate-x-1 transition-transform flex-shrink-0"
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

                    <FooterCTA
                        :title="t('services.visaMancanegara.cta.title')"
                        :description="t('services.visaMancanegara.cta.desc')"
                        :button-text="t('services.visaMancanegara.cta.whatsapp')"
                        :whatsapp-link="buildWhatsappLink(t('services.visaMancanegara.hero.breadcrumb.current'))"
                    />
                </div>
            </div>
        </section>
    </MainLayout>
</template>