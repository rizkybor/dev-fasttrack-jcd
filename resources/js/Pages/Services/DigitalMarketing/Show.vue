<script setup>
import { ref, computed } from "vue";
import { useI18n } from "vue-i18n";
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";

const { t, locale } = useI18n();

const props = defineProps({
    service: { type: [Object, Array], required: true },
});

const whatsappNumber = "6282298604144";

const buildWhatsappLink = (serviceName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${serviceName}.`;
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

const localizedService = computed(() => {
    const raw = Array.isArray(props.service) ? props.service[0] : props.service;
    if (!raw) return null;

    const content = pick(raw.content) ?? {};

    return {
        ...raw,
        name: pick(raw.name),
        excerpt: pick(raw.excerpt),
        penjelasan_umum: content.penjelasan_umum ?? [],
        sub_services: (raw.sub_services || []).map((sub) => {
            const detail = pick(sub.detail) ?? {};
            return {
                ...sub,
                name: pick(sub.name),
                excerpt: pick(sub.excerpt),
                penjelasan_layanan: detail.penjelasan_layanan ?? [],
                meliputi: detail.meliputi ?? [],
                output: detail.output ?? [],
            };
        }),
    };
});

const service = localizedService;

// ===== Pilih Jenis Layanan =====
const rawFirstService = Array.isArray(props.service)
    ? props.service[0]
    : props.service;
const selectedSubId = ref(rawFirstService?.sub_services?.[0]?.id ?? null);

const currentSub = computed(
    () =>
        service.value?.sub_services?.find(
            (s) => s.id === selectedSubId.value,
        ) ?? service.value?.sub_services?.[0],
);

const otherSubServices = computed(() =>
    (service.value?.sub_services ?? []).filter(
        (s) => s.id !== currentSub.value?.id,
    ),
);
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
                        class="inline-flex items-center gap-2 sm:rounded-md sm:bg-white sm:px-4 sm:py-2"
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
                                t(
                                    "services.digitalMarketingDetail.breadcrumb.layanan",
                                )
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
                        <a
                            href="/digital-marketing"
                            class="text-sm font-medium text-[#9e1f16] hover:underline"
                        >
                            {{
                                t(
                                    "services.digitalMarketingDetail.breadcrumb.parent",
                                )
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
                        <span
                            v-if="service"
                            class="text-sm font-medium text-[#9e1f16]"
                        >
                            {{ service.name }}
                        </span>
                    </div>
                </nav>

                <!-- Center: Heading -->
                <div v-if="service" class="flex items-center gap-5">
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
                        class="text-3xl font-extrabold leading-tight text-white sm:text-2xl lg:text-3xl max-w-[800px] line-clamp-2"
                    >
                        {{ service.name }}
                    </h1>
                </div>

                <!-- Bottom: Back button -->
                <div>
                    <a
                        href="/digital-marketing"
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
                        {{ t("services.digitalMarketingDetail.back") }}
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section id="edukasi" class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
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
                            {{
                                t(
                                    "services.digitalMarketingDetail.sections.penjelasan_umum",
                                )
                            }}
                        </h2>
                    </div>
                    <div class="space-y-4">
                        <p
                            v-for="(
                                paragraph, index
                            ) in service.penjelasan_umum"
                            :key="`penjelasan-umum-${index}`"
                            class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify"
                        >
                            {{ paragraph }}
                        </p>
                    </div>
                </div>

                <!-- 2. Pilih Jenis Layanan -->
                <div
                    class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8 mt-8"
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
                            {{
                                t(
                                    "services.digitalMarketingDetail.sections.pilih_jenis",
                                )
                            }}
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <button
                            v-for="sub in service.sub_services"
                            :key="sub.id"
                            type="button"
                            @click="selectedSubId = sub.id"
                            class="flex flex-col rounded-[14px] border p-[15px] text-left transition-all duration-200"
                            :class="
                                currentSub?.id === sub.id
                                    ? 'bg-[#9e1f16] border-[#9e1f16]'
                                    : 'bg-[#FEFEFE] border-[#D9DAD8] hover:border-primary/30'
                            "
                        >
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-lg mb-4"
                                :class="
                                    currentSub?.id === sub.id
                                        ? 'bg-white/15'
                                        : 'bg-[#9e1f16]'
                                "
                            >
                                <img
                                    src="/icons/ft-persons-w.svg"
                                    class="w-5 h-5"
                                    alt=""
                                />
                            </div>
                            <h4
                                class="text-[14px] font-bold leading-[20px] mb-1 line-clamp-2"
                                :class="
                                    currentSub?.id === sub.id
                                        ? 'text-white'
                                        : 'text-[#1A1B18]'
                                "
                            >
                                {{ sub.name }}
                            </h4>
                            <p
                                class="text-[12px] leading-[18px] line-clamp-3 mb-4"
                                :class="
                                    currentSub?.id === sub.id
                                        ? 'text-white/80'
                                        : 'text-[#282925]'
                                "
                            >
                                {{ sub.excerpt }}
                            </p>
                            <div class="mt-auto">
                                <span
                                    class="block text-[11px] mb-0.5"
                                    :class="
                                        currentSub?.id === sub.id
                                            ? 'text-white/70'
                                            : 'text-[#1A1B18]'
                                    "
                                >
                                    {{
                                        t(
                                            "services.digitalMarketingDetail.items.from",
                                        )
                                    }}
                                </span>
                                <span
                                    class="text-[16px] font-bold"
                                    :class="
                                        currentSub?.id === sub.id
                                            ? 'text-white'
                                            : 'text-primary'
                                    "
                                >
                                    {{ sub.price_label }}
                                </span>
                            </div>
                        </button>
                    </div>
                </div>

                <div
                    v-if="service"
                    class="mt-8 grid gap-8 lg:grid-cols-[1fr_280px] xl:grid-cols-[1fr_300px] min-w-0"
                >
                    <!-- ===== KIRI: Konten Utama ===== -->
                    <div class="flex flex-col gap-6 min-w-0">
                        <!-- 3. Penjelasan Layanan -->
                        <div
                            v-if="currentSub"
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
                                    {{
                                        t(
                                            "services.digitalMarketingDetail.sections.penjelasan_layanan",
                                        )
                                    }}
                                </h2>
                            </div>
                            <div class="space-y-4">
                                <p
                                    v-for="(
                                        paragraph, index
                                    ) in currentSub.penjelasan_layanan"
                                    :key="`penjelasan-layanan-${index}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A] text-justify"
                                >
                                    {{ paragraph }}
                                </p>
                            </div>
                        </div>

                        <!-- 4. Layanan X Meliputi -->
                        <div
                            v-if="currentSub?.meliputi?.length"
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
                                    {{
                                        t(
                                            "services.digitalMarketingDetail.sections.meliputi",
                                            { name: currentSub?.name ?? "" },
                                        )
                                    }}
                                </h2>
                            </div>
                            <ol class="columns-1 sm:columns-2 gap-x-8">
                                <li
                                    v-for="(item, index) in currentSub.meliputi"
                                    :key="`meliputi-${index}`"
                                    class="flex items-start gap-2.5 mb-3 break-inside-avoid"
                                >
                                    <span
                                        class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-[#9e1f16] text-[12px] font-bold text-white"
                                    >
                                        {{ index + 1 }}
                                    </span>
                                    <span
                                        class="text-[13px] leading-[1.6] text-[#3D3D3A] pt-0.5"
                                    >
                                        {{ item }}
                                    </span>
                                </li>
                            </ol>
                        </div>

                        <!-- 5. Jenis Output yang akan Diterima -->
                        <div
                            v-if="currentSub?.output?.length"
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
                                    {{
                                        t(
                                            "services.digitalMarketingDetail.sections.output",
                                        )
                                    }}
                                </h2>
                            </div>
                            <ul class="space-y-3">
                                <li
                                    v-for="(item, index) in currentSub.output"
                                    :key="`output-${index}`"
                                    class="flex items-start gap-2.5"
                                >
                                    <img
                                        src="/icons/ft-done.svg"
                                        class="mt-0.5 h-4 w-4 flex-shrink-0"
                                        alt="done"
                                    />
                                    <span
                                        class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                    >
                                        {{ item }}
                                    </span>
                                </li>
                            </ul>
                        </div>

                        <!-- 6. Biaya Layanan -->
                        <div
                            v-if="currentSub"
                            class="rounded-2xl overflow-hidden bg-[#9e1f16] p-6 sm:p-8 flex items-center justify-between gap-4"
                        >
                            <div class="flex items-center gap-3">
                                <span
                                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-white/15"
                                >
                                    <img
                                        src="/icons/ft-persons-w.svg"
                                        class="w-5 h-5"
                                        alt=""
                                    />
                                </span>
                                <span
                                    class="text-[14px] font-semibold text-white"
                                >
                                    {{ currentSub.name }}
                                </span>
                            </div>
                            <a
                                :href="buildWhatsappLink(currentSub.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center gap-1.5 rounded-lg bg-white px-4 py-2.5 text-[13px] font-semibold text-primary whitespace-nowrap hover:bg-white/90 transition-colors"
                            >
                                {{
                                    t(
                                        "services.digitalMarketingDetail.cta_button",
                                    )
                                }}
                                <svg
                                    class="h-3.5 w-3.5"
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

                    <!-- ===== KANAN: Sidebar ===== -->
                    <div
                        class="flex flex-col gap-4 lg:sticky lg:top-32 lg:self-start min-w-0"
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
                                        {{
                                            t(
                                                "services.digitalMarketingDetail.sidebar.vip_title",
                                            )
                                        }}
                                    </span>
                                </div>
                            </div>

                            <p
                                class="relative text-[14px] leading-[1.6] text-white/90 mb-5"
                                v-html="
                                    t(
                                        'services.digitalMarketingDetail.sidebar.vip_desc',
                                    )
                                "
                            ></p>
                            <a
                                :href="
                                    buildWhatsappLink(
                                        currentSub?.name ?? service.name,
                                    )
                                "
                                target="_blank"
                                rel="noopener noreferrer"
                                class="relative flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] py-3 text-[13px] font-bold text-white hover:bg-[#20BD5A] transition-colors shadow-lg shadow-black/20"
                            >
                                <img
                                    src="/icons/ft-wa.svg"
                                    class="mt-0.5 h-5 w-5 flex-shrink-0"
                                    alt="wa"
                                />
                                {{
                                    t(
                                        "services.digitalMarketingDetail.sidebar.vip_cta",
                                    )
                                }}
                            </a>

                            <div
                                class="relative mt-3 text-[11px] text-white/60"
                            >
                                {{
                                    t(
                                        "services.digitalMarketingDetail.sidebar.vip_note",
                                    )
                                }}
                            </div>
                        </div>

                        <!-- Price Card -->
                        <div
                            v-if="currentSub"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5"
                        >
                            <div
                                class="mb-4 flex items-center justify-between rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] px-3 py-2.5"
                            >
                                <span class="text-[13px] text-[#1A1B18]">
                                    {{ currentSub.name }}
                                </span>
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
                                {{
                                    t(
                                        "services.digitalMarketingDetail.sidebar.price_label",
                                    )
                                }}
                            </div>
                            <div
                                class="text-[32px] font-bold leading-none text-primary mb-1"
                            >
                                {{ currentSub.price_label }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">
                                {{
                                    t(
                                        "services.digitalMarketingDetail.sidebar.price_note",
                                    )
                                }}
                            </div>
                            <a
                                :href="buildWhatsappLink(currentSub.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-[#25D366] py-2.5 text-[13px] font-semibold text-white hover:bg-[#20BD5A] transition-colors"
                            >
                                <img
                                    src="/icons/ft-wa.svg"
                                    class="mt-0.5 h-6 w-6 flex-shrink-0"
                                    alt="wa"
                                />
                                {{
                                    t(
                                        "services.digitalMarketingDetail.sidebar.konsultasi_cta",
                                    )
                                }}
                            </a>
                        </div>

                        <!-- Layanan Design Lainnya -->
                        <div
                            v-if="otherSubServices.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-5"
                        >
                            <h3
                                class="text-[13px] font-bold text-[#1A1B18] mb-4"
                            >
                                {{
                                    t(
                                        "services.digitalMarketingDetail.sidebar.related_title",
                                    )
                                }}
                            </h3>
                            <div class="flex flex-col gap-3">
                                <button
                                    v-for="sub in otherSubServices"
                                    :key="sub.id"
                                    type="button"
                                    @click="selectedSubId = sub.id"
                                    class="group flex flex-col gap-1 rounded-xl border border-[#E8E8E6] bg-white p-4 text-left hover:border-primary/30 hover:shadow-sm transition-all"
                                >
                                    <div
                                        class="text-[13px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors"
                                    >
                                        {{ sub.name }}
                                    </div>
                                    <div
                                        class="text-[11px] text-[#686964] mb-1"
                                    >
                                        {{
                                            t(
                                                "services.digitalMarketingDetail.sidebar.related_from",
                                            )
                                        }}
                                        <span
                                            class="font-semibold text-primary"
                                        >
                                            {{ sub.price_label }}
                                        </span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <FooterCTA
            :title="t('services.digitalMarketingDetail.footer.title')"
            :description="t('services.digitalMarketingDetail.footer.desc')"
            :button-text="t('services.digitalMarketingDetail.footer.cta')"
            :whatsapp-link="buildWhatsappLink(currentSub?.name ?? service.name)"
        />
    </MainLayout>
</template>
