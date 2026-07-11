<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref, computed } from "vue";
import { useI18n } from "vue-i18n";
import FooterCTA from "@/Components/FooterCTA.vue";
import { useWhatsapp } from "@/Composables/useWhatsapp.js";
const { buildWhatsappLink } = useWhatsapp("default");

const { t, locale } = useI18n();

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
        tag: pick(p.tag),
        duration: pick(p.duration),
        description: pick(p.description),
        excerpt: pick(p.excerpt),
        content: pick(p.content) ?? [],
        term_condition: pick(p.term_condition) ?? [],
        benefits: pick(p.benefits) ?? [],
        requirements: pick(p.requirements) ?? [],
        process: pick(p.process) ?? [],
        plans_alert: pick(p.plans_alert) ?? [],
        dasar_hukum: pick(p.dasar_hukum) ?? [],
        plans: (p.plans ?? []).map((plan) => ({
            ...plan,
            name: pick(plan.name),
            bonus_note: pick(plan.bonus_note),
            dokumen: (plan.dokumen ?? []).map((d) => ({
                ...d,
                label: pick(d.label),
            })),
            termasuk: (plan.termasuk ?? []).map((item) => ({
                ...item,
                label: pick(item.label),
            })),
            bonus: (plan.bonus ?? []).map((b) => ({
                ...b,
                label: pick(b.label),
            })),
        })),
    };
});

const currentPlans = computed(() => localizedProduct.value?.plans ?? []);
const currentDasarHukum = computed(
    () => localizedProduct.value?.dasar_hukum ?? [],
);

const sidebarFeatures = computed(() => {
    const data = {
        id: [
            "Konsultasi pertama gratis",
            "Harga transparan, tanpa biaya tersembunyi",
            "Tim berpengalaman 18+ tahun",
            "Update proses berkala via WhatsApp",
        ],
        en: [
            "First consultation free",
            "Transparent pricing, no hidden fees",
            "Team with 18+ years of experience",
            "Regular process updates via WhatsApp",
        ],
        zh: [
            "首次咨询免费",
            "价格透明，无隐藏费用",
            "18年以上经验团队",
            "通过 WhatsApp 定期更新进度",
        ],
    };
    return data[locale.value] ?? data.id;
});

const expandedDocs = ref({});
const toggleDoc = (key) => {
    expandedDocs.value[key] = !expandedDocs.value[key];
};
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
                        >
                            {{
                                t(
                                    "services.badanUsahaDetail.breadcrumb.layanan",
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
                            href="/badan-usaha"
                            class="text-sm font-medium text-[#9e1f16] hover:underline"
                        >
                            {{
                                t(
                                    "services.badanUsahaDetail.breadcrumb.current",
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
                        <span class="text-sm font-medium text-[#9e1f16]">{{
                            localizedProduct.name
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
                        class="text-3xl font-extrabold leading-tight text-white sm:text-2xl lg:text-3xl max-w-[800px] line-clamp-2"
                    >
                        {{ localizedProduct.name }}
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
                        {{ t("services.badanUsahaDetail.back") }}
                    </a>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section id="edukasi" class="bg-[#F7F7F5] py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="grid gap-8 lg:grid-cols-[1fr_280px] xl:grid-cols-[1fr_300px]"
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
                                    {{
                                        t(
                                            "services.badanUsahaDetail.sections.penjelasan",
                                        )
                                    }}
                                </h2>
                            </div>
                            <div class="space-y-4">
                                <p
                                    v-for="(
                                        paragraph, index
                                    ) in localizedProduct.content"
                                    :key="`content-${index}`"
                                    class="text-[14px] leading-[1.8] text-[#3D3D3A]"
                                >
                                    {{ paragraph }}
                                </p>
                            </div>
                        </div>

                        <!-- 2. Syarat dan Ketentuan -->
                        <div
                            v-if="localizedProduct.term_condition.length"
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
                                            "services.badanUsahaDetail.sections.syarat",
                                        )
                                    }}
                                </h2>
                            </div>
                            <ol class="space-y-4">
                                <li
                                    v-for="(
                                        req, index
                                    ) in localizedProduct.term_condition"
                                    :key="`req-${index}`"
                                    class="flex gap-3 text-[14px] leading-[1.7] text-[#3D3D3A]"
                                >
                                    <span
                                        class="mt-0.5 flex-shrink-0 text-[13px] font-semibold text-[#1A1B18]"
                                    >
                                        {{ index + 1 }}.
                                    </span>
                                    <div>
                                        <p
                                            v-if="req.title"
                                            class="text-[14px] font-semibold text-[#1A1B18] mb-0.5"
                                        >
                                            {{ req.title }}
                                        </p>
                                        <p
                                            class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                        >
                                            {{ req.description ?? req }}
                                        </p>
                                        <ul
                                            v-if="req.notes"
                                            class="mt-1 space-y-0.5 list-disc list-inside"
                                        >
                                            <li
                                                v-for="(
                                                    note, nIndex
                                                ) in req.notes"
                                                :key="`note-${nIndex}`"
                                                class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                            >
                                                {{ note }}
                                            </li>
                                        </ul>
                                        <template v-if="req.notes_extra">
                                            <p
                                                class="text-[13px] leading-[1.6] text-[#3D3D3A] mt-2"
                                            >
                                                {{ req.notes_extra.label }}
                                            </p>
                                            <ul
                                                class="mt-1 space-y-0.5 list-disc list-inside"
                                            >
                                                <li
                                                    v-for="(item, iIndex) in req
                                                        .notes_extra.items"
                                                    :key="`extra-${iIndex}`"
                                                    class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                >
                                                    {{ item }}
                                                </li>
                                            </ul>
                                        </template>
                                        <template v-if="req.notes_extra_plus">
                                            <p
                                                class="text-[13px] leading-[1.6] text-[#3D3D3A] mt-2"
                                            >
                                                {{ req.notes_extra_plus.label }}
                                            </p>
                                            <ul
                                                class="mt-1 space-y-0.5 list-disc list-inside"
                                            >
                                                <li
                                                    v-for="(item, iIndex) in req
                                                        .notes_extra_plus.items"
                                                    :key="`extra-${iIndex}`"
                                                    class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                >
                                                    {{ item }}
                                                </li>
                                            </ul>
                                        </template>
                                    </div>
                                </li>
                            </ol>
                        </div>

                        <!-- 3. Keuntungan & Manfaat -->
                        <div
                            v-if="localizedProduct.benefits.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <div class="flex items-center gap-3 mb-6">
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
                                            "services.badanUsahaDetail.sections.keuntungan",
                                        )
                                    }}
                                </h2>
                            </div>
                            <div
                                :class="
                                    localizedProduct.benefits.length < 4
                                        ? 'flex flex-col gap-4'
                                        : 'grid grid-cols-1 sm:grid-cols-2 gap-4'
                                "
                            >
                                <div
                                    v-for="(
                                        benefit, index
                                    ) in localizedProduct.benefits"
                                    :key="`benefit-${index}`"
                                    class="flex gap-3 rounded-xl border border-[#E8E8E6] p-4"
                                >
                                    <img
                                        src="/icons/ft-done.svg"
                                        class="mt-0.5 h-5 w-5 flex-shrink-0"
                                        alt="done"
                                    />
                                    <div class="flex-1">
                                        <p
                                            class="text-[13px] font-semibold text-black leading-snug mb-1"
                                        >
                                            {{ benefit.title }}
                                        </p>
                                        <p
                                            v-if="benefit.description"
                                            class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                            :class="
                                                localizedProduct.benefits
                                                    .length >= 4
                                                    ? 'text-justify'
                                                    : ''
                                            "
                                        >
                                            {{ benefit.description }}
                                        </p>
                                        <ul
                                            v-if="
                                                benefit.notes &&
                                                localizedProduct.benefits
                                                    .length < 4
                                            "
                                            class="mt-1 space-y-0.5 list-disc list-inside"
                                        >
                                            <li
                                                v-for="(
                                                    note, nIndex
                                                ) in benefit.notes"
                                                :key="`bnote-${nIndex}`"
                                                class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                            >
                                                {{ note }}
                                            </li>
                                        </ul>
                                        <p
                                            v-if="
                                                benefit.footer &&
                                                localizedProduct.benefits
                                                    .length < 4
                                            "
                                            class="mt-1.5 text-[13px] leading-[1.6] text-[#3D3D3A]"
                                        >
                                            {{ benefit.footer }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Alur Proses -->
                        <div
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <div class="flex items-center gap-3 mb-8">
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
                                            "services.badanUsahaDetail.sections.alur",
                                        )
                                    }}
                                </h2>
                            </div>
                            <div
                                class="flex flex-col sm:flex-row gap-6 sm:gap-0"
                            >
                                <div
                                    v-for="(
                                        step, index
                                    ) in localizedProduct.process"
                                    :key="`step-${index}`"
                                    class="relative flex flex-col items-center text-center flex-1"
                                >
                                    <div
                                        v-if="
                                            index <
                                            localizedProduct.process.length - 1
                                        "
                                        class="absolute top-[22px] left-[calc(50%+22px)] hidden sm:block h-px w-[calc(100%-44px)] bg-[#E8E8E6]"
                                    ></div>
                                    <div
                                        class="relative z-10 flex h-11 w-11 items-center justify-center rounded-full bg-primary mb-3"
                                    >
                                        <img
                                            src="/icons/ft-docs-white.svg"
                                            class="mt-0.5 h-5 w-5 flex-shrink-0"
                                            alt="docs-white"
                                        />
                                    </div>
                                    <p
                                        class="text-[13px] font-semibold text-black leading-snug mb-1 px-2"
                                    >
                                        {{ step.title }}
                                    </p>
                                    <p
                                        class="text-[12px] leading-[1.5] text-black px-2 max-w-[140px]"
                                    >
                                        {{ step.description }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Dokumen dan Informasi yang Diperlukan (Accordion) -->
                        <div
                            class="rounded-2xl border border-[#E8E8E6] bg-white overflow-hidden"
                        >
                            <button
                                @click="docsOpen = !docsOpen"
                                class="w-full flex items-center justify-between p-6 sm:p-8 text-left"
                            >
                                <div class="flex items-center gap-3">
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
                                                "services.badanUsahaDetail.sections.dokumen",
                                            )
                                        }}
                                    </h2>
                                </div>
                                <svg
                                    class="h-5 w-5 text-[#686964] flex-shrink-0 transition-transform duration-200"
                                    :class="docsOpen ? 'rotate-180' : ''"
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
                            </button>
                            <div
                                v-show="docsOpen"
                                class="px-6 sm:px-8 pb-6 sm:pb-8 border-t border-[#E8E8E6]"
                            >
                                <ol class="mt-5 space-y-4">
                                    <li
                                        v-for="(
                                            req, index
                                        ) in localizedProduct.requirements"
                                        :key="`doc-${index}`"
                                        class="flex gap-4"
                                    >
                                        <span
                                            class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-primary text-white text-[12px] font-bold"
                                        >
                                            {{ index + 1 }}
                                        </span>
                                        <div class="pt-0.5 flex-1">
                                            <p
                                                class="text-[14px] font-semibold text-black leading-snug mb-1"
                                            >
                                                {{ req.title }}
                                            </p>
                                            <p
                                                v-if="req.description"
                                                class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                v-html="
                                                    parseBold(req.description)
                                                "
                                            ></p>
                                            <ul
                                                v-if="
                                                    req.notes &&
                                                    typeof req.notes[0] ===
                                                        'string'
                                                "
                                                class="mt-1 space-y-0.5 list-disc list-inside"
                                            >
                                                <li
                                                    v-for="(
                                                        note, nIndex
                                                    ) in req.notes"
                                                    :key="`note-${nIndex}`"
                                                    class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                >
                                                    {{ note }}
                                                </li>
                                            </ul>
                                            <ul
                                                v-if="
                                                    req.notes &&
                                                    typeof req.notes[0] ===
                                                        'object'
                                                "
                                                class="mt-1.5 space-y-2 list-disc list-inside"
                                            >
                                                <li
                                                    v-for="(
                                                        note, nIndex
                                                    ) in req.notes"
                                                    :key="`note-obj-${nIndex}`"
                                                    class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                >
                                                    <span
                                                        class="font-semibold text-black"
                                                        >{{ note.bold }}</span
                                                    >
                                                    <p
                                                        v-if="note.detail"
                                                        class="ml-4 mt-0.5 text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                    >
                                                        {{ note.detail }}
                                                    </p>
                                                </li>
                                            </ul>
                                            <div
                                                v-if="req.sections"
                                                class="mt-1 space-y-3"
                                            >
                                                <div
                                                    v-for="(
                                                        section, sIndex
                                                    ) in req.sections"
                                                    :key="`section-${sIndex}`"
                                                >
                                                    <p
                                                        class="text-[13px] font-semibold text-[#1A1B18] mb-1"
                                                    >
                                                        {{ section.label }}
                                                    </p>
                                                    <div class="space-y-1.5">
                                                        <div
                                                            v-for="(
                                                                group, gIndex
                                                            ) in section.groups"
                                                            :key="`sg-${gIndex}`"
                                                        >
                                                            <p
                                                                class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                            >
                                                                {{
                                                                    group.label
                                                                }}
                                                            </p>
                                                            <p
                                                                v-if="
                                                                    group.description
                                                                "
                                                                class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                            >
                                                                {{
                                                                    group.description
                                                                }}
                                                            </p>
                                                            <ul
                                                                v-if="
                                                                    group.notes
                                                                "
                                                                class="mt-0.5 space-y-0.5 list-disc list-inside"
                                                            >
                                                                <li
                                                                    v-for="(
                                                                        note,
                                                                        nIndex
                                                                    ) in group.notes"
                                                                    :key="`gnote-${nIndex}`"
                                                                    class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                                >
                                                                    {{ note }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                v-if="
                                                    req.groups && !req.sections
                                                "
                                                class="mt-1 space-y-2"
                                            >
                                                <div
                                                    v-for="(
                                                        group, gIndex
                                                    ) in req.groups"
                                                    :key="`group-${gIndex}`"
                                                >
                                                    <p
                                                        class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                    >
                                                        {{ group.label }}
                                                    </p>
                                                    <p
                                                        v-if="group.description"
                                                        class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                    >
                                                        {{ group.description }}
                                                    </p>
                                                    <ul
                                                        v-if="group.notes"
                                                        class="mt-0.5 space-y-0.5 list-disc list-inside"
                                                    >
                                                        <li
                                                            v-for="(
                                                                note, nIndex
                                                            ) in group.notes"
                                                            :key="`gnote-${nIndex}`"
                                                            class="text-[13px] leading-[1.6] text-[#3D3D3A]"
                                                        >
                                                            {{ note }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ol>
                            </div>
                        </div>

                        <!-- 6. Paket & Harga -->
                        <div
                            v-if="currentPlans.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        >
                            <div class="flex items-center gap-3 mb-6">
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
                                            "services.badanUsahaDetail.sections.paket",
                                        )
                                    }}
                                </h2>
                            </div>

                            <!-- Layout <= 3 paket -->
                            <div
                                v-if="currentPlans.length <= 3"
                                class="grid grid-cols-1 sm:grid-cols-3 gap-4"
                            >
                                <div
                                    v-for="(plan, pi) in currentPlans"
                                    :key="`plan-${pi}`"
                                    class="relative flex flex-col rounded-xl border"
                                    :class="
                                        plan.popular
                                            ? 'border-primary shadow-md shadow-primary/10'
                                            : 'border-[#E8E8E6]'
                                    "
                                >
                                    <template v-if="plan.popular">
                                        <div
                                            class="absolute -top-3.5 left-1/2 -translate-x-1/2"
                                        >
                                            <span
                                                class="inline-flex items-center rounded-full border border-primary bg-white px-3 py-0.5 text-[11px] font-semibold text-primary"
                                            >
                                                {{
                                                    t(
                                                        "services.badanUsahaDetail.plans.paling_populer",
                                                    )
                                                }}
                                            </span>
                                        </div>
                                    </template>
                                    <div class="p-4 flex flex-col gap-3 flex-1">
                                        <div
                                            class="text-[12px] font-bold uppercase tracking-wide text-[#1A1B18]"
                                        >
                                            {{ plan.name }}
                                        </div>
                                        <div>
                                            <div
                                                class="text-[11px] text-[#686964]"
                                            >
                                                {{
                                                    t(
                                                        "services.badanUsahaDetail.plans.mulai_dari",
                                                    )
                                                }}
                                            </div>
                                            <div
                                                class="text-[20px] font-bold leading-tight text-primary"
                                            >
                                                {{ plan.price }}
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-start gap-1.5 text-[11px] text-[#3D3D3A]"
                                        >
                                            <svg
                                                class="h-3.5 w-3.5 text-[#25D366] flex-shrink-0 mt-0.5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7"
                                                />
                                            </svg>
                                            {{ plan.bonus_note }}
                                        </div>
                                        <div class="h-px bg-[#E8E8E6]"></div>
                                        <div>
                                            <div
                                                class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                            >
                                                {{
                                                    t(
                                                        "services.badanUsahaDetail.plans.dokumen_legalitas",
                                                    )
                                                }}
                                            </div>
                                            <ul class="space-y-1.5">
                                                <li
                                                    v-for="(
                                                        doc, di
                                                    ) in plan.dokumen"
                                                    :key="`doc-${di}`"
                                                    class="flex items-start gap-1.5"
                                                >
                                                    <img
                                                        v-if="doc.included"
                                                        src="/icons/ft-done.svg"
                                                        class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                        alt="done"
                                                    />
                                                    <img
                                                        v-else
                                                        src="/icons/ft-wrong.svg"
                                                        class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                        alt="wrong"
                                                    />
                                                    <span
                                                        class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                        :class="
                                                            expandedDocs[
                                                                `${pi}-${di}`
                                                            ]
                                                                ? ''
                                                                : 'truncate'
                                                        "
                                                        @click="
                                                            toggleDoc(
                                                                `${pi}-${di}`,
                                                            )
                                                        "
                                                        >{{ doc.label }}</span
                                                    >
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <div
                                                class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                            >
                                                {{
                                                    t(
                                                        "services.badanUsahaDetail.plans.termasuk",
                                                    )
                                                }}
                                            </div>
                                            <ul class="space-y-1.5">
                                                <li
                                                    v-for="(
                                                        item, ti
                                                    ) in plan.termasuk"
                                                    :key="`termasuk-${ti}`"
                                                    class="flex items-start gap-1.5"
                                                >
                                                    <img
                                                        v-if="item.included"
                                                        src="/icons/ft-done.svg"
                                                        class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                        alt="done"
                                                    />
                                                    <img
                                                        v-else
                                                        src="/icons/ft-wrong.svg"
                                                        class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                        alt="wrong"
                                                    />
                                                    <span
                                                        class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                        :class="
                                                            expandedDocs[
                                                                `termasuk-${pi}-${ti}`
                                                            ]
                                                                ? ''
                                                                : 'truncate'
                                                        "
                                                        @click="
                                                            toggleDoc(
                                                                `termasuk-${pi}-${ti}`,
                                                            )
                                                        "
                                                        >{{ item.label }}</span
                                                    >
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <div
                                                class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                            >
                                                {{
                                                    t(
                                                        "services.badanUsahaDetail.plans.bonus",
                                                    )
                                                }}
                                            </div>
                                            <ul class="space-y-1.5">
                                                <li
                                                    v-for="(
                                                        bon, bi
                                                    ) in plan.bonus"
                                                    :key="`bonus-${bi}`"
                                                    class="flex items-start gap-1.5"
                                                >
                                                    <img
                                                        v-if="bon.included"
                                                        src="/icons/ft-done.svg"
                                                        class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                        alt="done"
                                                    />
                                                    <img
                                                        v-else
                                                        src="/icons/ft-wrong.svg"
                                                        class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                        alt="wrong"
                                                    />
                                                    <span
                                                        class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                        :class="
                                                            expandedDocs[
                                                                `bonus-${pi}-${bi}`
                                                            ]
                                                                ? ''
                                                                : 'truncate'
                                                        "
                                                        @click="
                                                            toggleDoc(
                                                                `bonus-${pi}-${bi}`,
                                                            )
                                                        "
                                                        >{{ bon.label }}</span
                                                    >
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="p-4 pt-0">
                                        <a
                                            :href="buildWhatsappLink(plan.name)"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex w-full items-center justify-center gap-2 rounded-lg py-2.5 text-[12px] font-semibold transition-colors"
                                            :class="
                                                plan.popular
                                                    ? 'bg-primary text-white hover:bg-primary/90'
                                                    : 'border border-primary text-primary hover:bg-primary hover:text-white'
                                            "
                                        >
                                            {{
                                                t(
                                                    "services.badanUsahaDetail.plans.pesan",
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
                            </div>

                            <!-- Layout <= 4 paket -->
                            <template v-else-if="currentPlans.length <= 4">
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4"
                                >
                                    <div
                                        v-for="(plan, pi) in currentPlans.slice(
                                            0,
                                            3,
                                        )"
                                        :key="`plan-${pi}`"
                                        class="relative flex flex-col rounded-xl border"
                                        :class="
                                            plan.popular
                                                ? 'border-primary shadow-md shadow-primary/10'
                                                : 'border-[#E8E8E6]'
                                        "
                                    >
                                        <template v-if="plan.popular">
                                            <div
                                                class="absolute -top-3.5 left-1/2 -translate-x-1/2"
                                            >
                                                <span
                                                    class="inline-flex items-center rounded-full border border-primary bg-white px-3 py-0.5 text-[11px] font-semibold text-primary"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.paling_populer",
                                                        )
                                                    }}
                                                </span>
                                            </div>
                                        </template>
                                        <div
                                            class="p-4 flex flex-col gap-3 flex-1"
                                        >
                                            <div
                                                class="text-[12px] font-bold uppercase tracking-wide text-[#1A1B18]"
                                            >
                                                {{ plan.name }}
                                            </div>
                                            <div>
                                                <div
                                                    class="text-[11px] text-[#686964]"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.mulai_dari",
                                                        )
                                                    }}
                                                </div>
                                                <div
                                                    class="text-[20px] font-bold leading-tight text-primary"
                                                >
                                                    {{ plan.price }}
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-start gap-1.5 text-[11px] text-[#3D3D3A]"
                                            >
                                                <svg
                                                    class="h-3.5 w-3.5 text-[#25D366] flex-shrink-0 mt-0.5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2.5"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7"
                                                    />
                                                </svg>
                                                {{ plan.bonus_note }}
                                            </div>
                                            <div
                                                class="h-px bg-[#E8E8E6]"
                                            ></div>
                                            <div>
                                                <div
                                                    class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.dokumen_legalitas",
                                                        )
                                                    }}
                                                </div>
                                                <ul class="space-y-1.5">
                                                    <li
                                                        v-for="(
                                                            doc, di
                                                        ) in plan.dokumen"
                                                        :key="`doc-${di}`"
                                                        class="flex items-start gap-1.5"
                                                    >
                                                        <img
                                                            v-if="doc.included"
                                                            src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="done"
                                                        />
                                                        <img
                                                            v-else
                                                            src="/icons/ft-wrong.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="wrong"
                                                        />
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                            :class="
                                                                expandedDocs[
                                                                    `${pi}-${di}`
                                                                ]
                                                                    ? ''
                                                                    : 'truncate'
                                                            "
                                                            @click="
                                                                toggleDoc(
                                                                    `${pi}-${di}`,
                                                                )
                                                            "
                                                            >{{
                                                                doc.label
                                                            }}</span
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                            <div>
                                                <div
                                                    class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.termasuk",
                                                        )
                                                    }}
                                                </div>
                                                <ul class="space-y-1.5">
                                                    <li
                                                        v-for="(
                                                            item, ti
                                                        ) in plan.termasuk"
                                                        :key="`termasuk-${ti}`"
                                                        class="flex items-start gap-1.5"
                                                    >
                                                        <img
                                                            v-if="item.included"
                                                            src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="done"
                                                        />
                                                        <img
                                                            v-else
                                                            src="/icons/ft-wrong.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="wrong"
                                                        />
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                            :class="
                                                                expandedDocs[
                                                                    `termasuk-${pi}-${ti}`
                                                                ]
                                                                    ? ''
                                                                    : 'truncate'
                                                            "
                                                            @click="
                                                                toggleDoc(
                                                                    `termasuk-${pi}-${ti}`,
                                                                )
                                                            "
                                                            >{{
                                                                item.label
                                                            }}</span
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                            <div>
                                                <div
                                                    class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.bonus",
                                                        )
                                                    }}
                                                </div>
                                                <ul class="space-y-1.5">
                                                    <li
                                                        v-for="(
                                                            bon, bi
                                                        ) in plan.bonus"
                                                        :key="`bonus-${bi}`"
                                                        class="flex items-start gap-1.5"
                                                    >
                                                        <img
                                                            v-if="bon.included"
                                                            src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="done"
                                                        />
                                                        <img
                                                            v-else
                                                            src="/icons/ft-wrong.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="wrong"
                                                        />
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                            :class="
                                                                expandedDocs[
                                                                    `bonus-${pi}-${bi}`
                                                                ]
                                                                    ? ''
                                                                    : 'truncate'
                                                            "
                                                            @click="
                                                                toggleDoc(
                                                                    `bonus-${pi}-${bi}`,
                                                                )
                                                            "
                                                            >{{
                                                                bon.label
                                                            }}</span
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="p-4 pt-0">
                                            <a
                                                :href="
                                                    buildWhatsappLink(plan.name)
                                                "
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="flex w-full items-center justify-center gap-2 rounded-lg py-2.5 text-[12px] font-semibold transition-colors"
                                                :class="
                                                    plan.popular
                                                        ? 'bg-primary text-white hover:bg-primary/90'
                                                        : 'border border-primary text-primary hover:bg-primary hover:text-white'
                                                "
                                            >
                                                {{
                                                    t(
                                                        "services.badanUsahaDetail.plans.pesan",
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
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div
                                        v-for="(plan, pi) in currentPlans.slice(
                                            3,
                                        )"
                                        :key="`plan-extra-${pi}`"
                                        class="relative flex flex-col rounded-xl border"
                                        :class="
                                            plan.popular
                                                ? 'border-primary shadow-md shadow-primary/10'
                                                : 'border-[#E8E8E6]'
                                        "
                                    >
                                        <template v-if="plan.popular">
                                            <div
                                                class="absolute -top-3.5 left-1/2 -translate-x-1/2"
                                            >
                                                <span
                                                    class="inline-flex items-center rounded-full border border-primary bg-white px-3 py-0.5 text-[11px] font-semibold text-primary"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.paling_populer",
                                                        )
                                                    }}
                                                </span>
                                            </div>
                                        </template>
                                        <div
                                            class="p-4 flex flex-col gap-3 flex-1"
                                        >
                                            <div
                                                class="text-[12px] font-bold uppercase tracking-wide text-[#1A1B18]"
                                            >
                                                {{ plan.name }}
                                            </div>
                                            <div>
                                                <div
                                                    class="text-[11px] text-[#686964]"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.mulai_dari",
                                                        )
                                                    }}
                                                </div>
                                                <div
                                                    class="text-[20px] font-bold leading-tight text-primary"
                                                >
                                                    {{ plan.price }}
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-start gap-1.5 text-[11px] text-[#3D3D3A]"
                                            >
                                                <svg
                                                    class="h-3.5 w-3.5 text-[#25D366] flex-shrink-0 mt-0.5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2.5"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7"
                                                    />
                                                </svg>
                                                {{ plan.bonus_note }}
                                            </div>
                                            <div
                                                class="h-px bg-[#E8E8E6]"
                                            ></div>
                                            <div>
                                                <div
                                                    class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.dokumen_legalitas",
                                                        )
                                                    }}
                                                </div>
                                                <ul class="space-y-1.5">
                                                    <li
                                                        v-for="(
                                                            doc, di
                                                        ) in plan.dokumen"
                                                        :key="`doc-${di}`"
                                                        class="flex items-start gap-1.5"
                                                    >
                                                        <img
                                                            v-if="doc.included"
                                                            src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="done"
                                                        />
                                                        <img
                                                            v-else
                                                            src="/icons/ft-wrong.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="wrong"
                                                        />
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                            :class="
                                                                expandedDocs[
                                                                    `extra-${pi}-${di}`
                                                                ]
                                                                    ? ''
                                                                    : 'truncate'
                                                            "
                                                            @click="
                                                                toggleDoc(
                                                                    `extra-${pi}-${di}`,
                                                                )
                                                            "
                                                            >{{
                                                                doc.label
                                                            }}</span
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                            <div>
                                                <div
                                                    class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.termasuk",
                                                        )
                                                    }}
                                                </div>
                                                <ul class="space-y-1.5">
                                                    <li
                                                        v-for="(
                                                            item, ti
                                                        ) in plan.termasuk"
                                                        :key="`termasuk-${ti}`"
                                                        class="flex items-start gap-1.5"
                                                    >
                                                        <img
                                                            v-if="item.included"
                                                            src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="done"
                                                        />
                                                        <img
                                                            v-else
                                                            src="/icons/ft-wrong.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="wrong"
                                                        />
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                            :class="
                                                                expandedDocs[
                                                                    `extra-termasuk-${pi}-${ti}`
                                                                ]
                                                                    ? ''
                                                                    : 'truncate'
                                                            "
                                                            @click="
                                                                toggleDoc(
                                                                    `extra-termasuk-${pi}-${ti}`,
                                                                )
                                                            "
                                                            >{{
                                                                item.label
                                                            }}</span
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                            <div>
                                                <div
                                                    class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.bonus",
                                                        )
                                                    }}
                                                </div>
                                                <ul class="space-y-1.5">
                                                    <li
                                                        v-for="(
                                                            bon, bi
                                                        ) in plan.bonus"
                                                        :key="`bonus-${bi}`"
                                                        class="flex items-start gap-1.5"
                                                    >
                                                        <img
                                                            v-if="bon.included"
                                                            src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="done"
                                                        />
                                                        <img
                                                            v-else
                                                            src="/icons/ft-wrong.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="wrong"
                                                        />
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                            :class="
                                                                expandedDocs[
                                                                    `extra-bonus-${pi}-${bi}`
                                                                ]
                                                                    ? ''
                                                                    : 'truncate'
                                                            "
                                                            @click="
                                                                toggleDoc(
                                                                    `extra-bonus-${pi}-${bi}`,
                                                                )
                                                            "
                                                            >{{
                                                                bon.label
                                                            }}</span
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="p-4 pt-0">
                                            <a
                                                :href="
                                                    buildWhatsappLink(plan.name)
                                                "
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="flex w-full items-center justify-center gap-2 rounded-lg py-2.5 text-[12px] font-semibold transition-colors"
                                                :class="
                                                    plan.popular
                                                        ? 'bg-primary text-white hover:bg-primary/90'
                                                        : 'border border-primary text-primary hover:bg-primary hover:text-white'
                                                "
                                            >
                                                {{
                                                    t(
                                                        "services.badanUsahaDetail.plans.pesan",
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
                                </div>
                            </template>

                            <!-- Layout > 4 paket -->
                            <template v-else>
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4"
                                >
                                    <div
                                        v-for="(plan, pi) in currentPlans.slice(
                                            0,
                                            3,
                                        )"
                                        :key="`plan-${pi}`"
                                        class="relative flex flex-col rounded-xl border"
                                        :class="
                                            plan.popular
                                                ? 'border-primary shadow-md shadow-primary/10'
                                                : 'border-[#E8E8E6]'
                                        "
                                    >
                                        <template v-if="plan.popular">
                                            <div
                                                class="absolute -top-3.5 left-1/2 -translate-x-1/2"
                                            >
                                                <span
                                                    class="inline-flex items-center rounded-full border border-primary bg-white px-3 py-0.5 text-[11px] font-semibold text-primary"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.paling_populer",
                                                        )
                                                    }}
                                                </span>
                                            </div>
                                        </template>
                                        <div
                                            class="p-4 flex flex-col gap-3 flex-1"
                                        >
                                            <div
                                                class="text-[12px] font-bold uppercase tracking-wide text-[#1A1B18]"
                                            >
                                                {{ plan.name }}
                                            </div>
                                            <div>
                                                <div
                                                    class="text-[11px] text-[#686964]"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.mulai_dari",
                                                        )
                                                    }}
                                                </div>
                                                <div
                                                    class="text-[20px] font-bold leading-tight text-primary"
                                                >
                                                    {{ plan.price }}
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-start gap-1.5 text-[11px] text-[#3D3D3A]"
                                            >
                                                <svg
                                                    class="h-3.5 w-3.5 text-[#25D366] flex-shrink-0 mt-0.5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2.5"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7"
                                                    />
                                                </svg>
                                                {{ plan.bonus_note }}
                                            </div>
                                            <div
                                                class="h-px bg-[#E8E8E6]"
                                            ></div>
                                            <div>
                                                <div
                                                    class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.dokumen_legalitas",
                                                        )
                                                    }}
                                                </div>
                                                <ul class="space-y-1.5">
                                                    <li
                                                        v-for="(
                                                            doc, di
                                                        ) in plan.dokumen"
                                                        :key="`doc-${di}`"
                                                        class="flex items-start gap-1.5"
                                                    >
                                                        <img
                                                            v-if="doc.included"
                                                            src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="done"
                                                        />
                                                        <img
                                                            v-else
                                                            src="/icons/ft-wrong.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="wrong"
                                                        />
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                            :class="
                                                                expandedDocs[
                                                                    `${pi}-${di}`
                                                                ]
                                                                    ? ''
                                                                    : 'truncate'
                                                            "
                                                            @click="
                                                                toggleDoc(
                                                                    `${pi}-${di}`,
                                                                )
                                                            "
                                                            >{{
                                                                doc.label
                                                            }}</span
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                            <div>
                                                <div
                                                    class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.termasuk",
                                                        )
                                                    }}
                                                </div>
                                                <ul class="space-y-1.5">
                                                    <li
                                                        v-for="(
                                                            item, ti
                                                        ) in plan.termasuk"
                                                        :key="`termasuk-${ti}`"
                                                        class="flex items-start gap-1.5"
                                                    >
                                                        <img
                                                            v-if="item.included"
                                                            src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="done"
                                                        />
                                                        <img
                                                            v-else
                                                            src="/icons/ft-wrong.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="wrong"
                                                        />
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                            :class="
                                                                expandedDocs[
                                                                    `termasuk-${pi}-${ti}`
                                                                ]
                                                                    ? ''
                                                                    : 'truncate'
                                                            "
                                                            @click="
                                                                toggleDoc(
                                                                    `termasuk-${pi}-${ti}`,
                                                                )
                                                            "
                                                            >{{
                                                                item.label
                                                            }}</span
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                            <div>
                                                <div
                                                    class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.bonus",
                                                        )
                                                    }}
                                                </div>
                                                <ul class="space-y-1.5">
                                                    <li
                                                        v-for="(
                                                            bon, bi
                                                        ) in plan.bonus"
                                                        :key="`bonus-${bi}`"
                                                        class="flex items-start gap-1.5"
                                                    >
                                                        <img
                                                            v-if="bon.included"
                                                            src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="done"
                                                        />
                                                        <img
                                                            v-else
                                                            src="/icons/ft-wrong.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="wrong"
                                                        />
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                            :class="
                                                                expandedDocs[
                                                                    `bonus-${pi}-${bi}`
                                                                ]
                                                                    ? ''
                                                                    : 'truncate'
                                                            "
                                                            @click="
                                                                toggleDoc(
                                                                    `bonus-${pi}-${bi}`,
                                                                )
                                                            "
                                                            >{{
                                                                bon.label
                                                            }}</span
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="p-4 pt-0">
                                            <a
                                                :href="
                                                    buildWhatsappLink(plan.name)
                                                "
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="flex w-full items-center justify-center gap-2 rounded-lg py-2.5 text-[12px] font-semibold transition-colors"
                                                :class="
                                                    plan.popular
                                                        ? 'bg-primary text-white hover:bg-primary/90'
                                                        : 'border border-primary text-primary hover:bg-primary hover:text-white'
                                                "
                                            >
                                                {{
                                                    t(
                                                        "services.badanUsahaDetail.plans.pesan",
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
                                </div>
                                <div
                                    class="grid grid-cols-1 gap-4"
                                    :class="
                                        currentPlans.slice(3).length === 1
                                            ? 'sm:grid-cols-1 sm:w-1/3 sm:mx-auto'
                                            : 'sm:grid-cols-2'
                                    "
                                >
                                    <div
                                        v-for="(plan, pi) in currentPlans.slice(
                                            3,
                                        )"
                                        :key="`plan-extra-${pi}`"
                                        class="relative flex flex-col rounded-xl border"
                                        :class="
                                            plan.popular
                                                ? 'border-primary shadow-md shadow-primary/10'
                                                : 'border-[#E8E8E6]'
                                        "
                                    >
                                        <template v-if="plan.popular">
                                            <div
                                                class="absolute -top-3.5 left-1/2 -translate-x-1/2"
                                            >
                                                <span
                                                    class="inline-flex items-center rounded-full border border-primary bg-white px-3 py-0.5 text-[11px] font-semibold text-primary"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.paling_populer",
                                                        )
                                                    }}
                                                </span>
                                            </div>
                                        </template>
                                        <div
                                            class="p-4 flex flex-col gap-3 flex-1"
                                        >
                                            <div
                                                class="text-[12px] font-bold uppercase tracking-wide text-[#1A1B18]"
                                            >
                                                {{ plan.name }}
                                            </div>
                                            <div>
                                                <div
                                                    class="text-[11px] text-[#686964]"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.mulai_dari",
                                                        )
                                                    }}
                                                </div>
                                                <div
                                                    class="text-[20px] font-bold leading-tight text-primary"
                                                >
                                                    {{ plan.price }}
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-start gap-1.5 text-[11px] text-[#3D3D3A]"
                                            >
                                                <svg
                                                    class="h-3.5 w-3.5 text-[#25D366] flex-shrink-0 mt-0.5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2.5"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7"
                                                    />
                                                </svg>
                                                {{ plan.bonus_note }}
                                            </div>
                                            <div
                                                class="h-px bg-[#E8E8E6]"
                                            ></div>
                                            <div>
                                                <div
                                                    class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.dokumen_legalitas",
                                                        )
                                                    }}
                                                </div>
                                                <ul class="space-y-1.5">
                                                    <li
                                                        v-for="(
                                                            doc, di
                                                        ) in plan.dokumen"
                                                        :key="`doc-${di}`"
                                                        class="flex items-start gap-1.5"
                                                    >
                                                        <img
                                                            v-if="doc.included"
                                                            src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="done"
                                                        />
                                                        <img
                                                            v-else
                                                            src="/icons/ft-wrong.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="wrong"
                                                        />
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                            :class="
                                                                expandedDocs[
                                                                    `extra-${pi}-${di}`
                                                                ]
                                                                    ? ''
                                                                    : 'truncate'
                                                            "
                                                            @click="
                                                                toggleDoc(
                                                                    `extra-${pi}-${di}`,
                                                                )
                                                            "
                                                            >{{
                                                                doc.label
                                                            }}</span
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                            <div>
                                                <div
                                                    class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.termasuk",
                                                        )
                                                    }}
                                                </div>
                                                <ul class="space-y-1.5">
                                                    <li
                                                        v-for="(
                                                            item, ti
                                                        ) in plan.termasuk"
                                                        :key="`termasuk-${ti}`"
                                                        class="flex items-start gap-1.5"
                                                    >
                                                        <img
                                                            v-if="item.included"
                                                            src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="done"
                                                        />
                                                        <img
                                                            v-else
                                                            src="/icons/ft-wrong.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="wrong"
                                                        />
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                            :class="
                                                                expandedDocs[
                                                                    `extra-termasuk-${pi}-${ti}`
                                                                ]
                                                                    ? ''
                                                                    : 'truncate'
                                                            "
                                                            @click="
                                                                toggleDoc(
                                                                    `extra-termasuk-${pi}-${ti}`,
                                                                )
                                                            "
                                                            >{{
                                                                item.label
                                                            }}</span
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                            <div>
                                                <div
                                                    class="text-[11px] font-semibold text-[#1A1B18] mb-2"
                                                >
                                                    {{
                                                        t(
                                                            "services.badanUsahaDetail.plans.bonus",
                                                        )
                                                    }}
                                                </div>
                                                <ul class="space-y-1.5">
                                                    <li
                                                        v-for="(
                                                            bon, bi
                                                        ) in plan.bonus"
                                                        :key="`bonus-${bi}`"
                                                        class="flex items-start gap-1.5"
                                                    >
                                                        <img
                                                            v-if="bon.included"
                                                            src="/icons/ft-done.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="done"
                                                        />
                                                        <img
                                                            v-else
                                                            src="/icons/ft-wrong.svg"
                                                            class="mt-0.5 h-3 w-3 flex-shrink-0"
                                                            alt="wrong"
                                                        />
                                                        <span
                                                            class="text-[11px] leading-[1.5] text-[#3D3D3A] cursor-pointer"
                                                            :class="
                                                                expandedDocs[
                                                                    `extra-bonus-${pi}-${bi}`
                                                                ]
                                                                    ? ''
                                                                    : 'truncate'
                                                            "
                                                            @click="
                                                                toggleDoc(
                                                                    `extra-bonus-${pi}-${bi}`,
                                                                )
                                                            "
                                                            >{{
                                                                bon.label
                                                            }}</span
                                                        >
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="p-4 pt-0">
                                            <a
                                                :href="
                                                    buildWhatsappLink(plan.name)
                                                "
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="flex w-full items-center justify-center gap-2 rounded-lg py-2.5 text-[12px] font-semibold transition-colors"
                                                :class="
                                                    plan.popular
                                                        ? 'bg-primary text-white hover:bg-primary/90'
                                                        : 'border border-primary text-primary hover:bg-primary hover:text-white'
                                                "
                                            >
                                                {{
                                                    t(
                                                        "services.badanUsahaDetail.plans.pesan",
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
                                </div>
                            </template>

                            <!-- Alert Info -->
                            <div
                                v-if="localizedProduct.plans_alert.length"
                                class="mt-4 space-y-2"
                            >
                                <div
                                    v-for="(
                                        alert, ai
                                    ) in localizedProduct.plans_alert"
                                    :key="`alert-${ai}`"
                                    class="flex items-center gap-2.5 rounded-2xl bg-[#D6F0FA] px-4 py-3.5"
                                >
                                    <svg
                                        class="h-4 w-4 text-[#5BB8D4] flex-shrink-0"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <circle cx="12" cy="12" r="10" />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 8v4m0 4h.01"
                                        />
                                    </svg>
                                    <span class="text-[13px] text-[#5BB8D4]">{{
                                        alert
                                    }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Dasar Hukum (Accordion) -->
                        <div
                            v-if="currentDasarHukum.length"
                            class="rounded-2xl border border-[#E8E8E6] bg-white overflow-hidden"
                        >
                            <button
                                @click="dasarHukumOpen = !dasarHukumOpen"
                                class="w-full flex items-center justify-between p-6 sm:p-8 text-left"
                            >
                                <div class="flex items-center gap-3">
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
                                                "services.badanUsahaDetail.sections.dasar_hukum",
                                            )
                                        }}
                                    </h2>
                                </div>
                                <svg
                                    class="h-5 w-5 text-[#686964] flex-shrink-0 transition-transform duration-200"
                                    :class="dasarHukumOpen ? 'rotate-180' : ''"
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
                            </button>
                            <div
                                v-show="dasarHukumOpen"
                                class="px-6 sm:px-8 pb-6 sm:pb-8 border-t border-[#E8E8E6]"
                            >
                                <ul class="mt-5 space-y-4">
                                    <li
                                        v-for="(hukum, hi) in currentDasarHukum"
                                        :key="`hukum-${hi}`"
                                        class="flex items-start gap-4"
                                    >
                                        <span
                                            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-[#ddffe3]"
                                        >
                                            <img
                                                src="/icons/ft-save.svg"
                                                class="w-4 h-4"
                                                alt=""
                                            />
                                        </span>
                                        <span
                                            class="text-[13px] leading-[1.7] text-[#3D3D3A] text-justify"
                                            >{{ hukum }}</span
                                        >
                                    </li>
                                </ul>
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
                                        {{
                                            t(
                                                "services.badanUsahaDetail.sidebar.vip_title",
                                            )
                                        }}
                                    </span>
                                </div>
                            </div>
                            <p
                                class="relative text-[14px] leading-[1.6] text-white/90 mb-5"
                            >
                                {{
                                    t(
                                        "services.badanUsahaDetail.sidebar.vip_desc",
                                    )
                                }}
                            </p>
                            <a
                                :href="buildWhatsappLink(localizedProduct.name)"
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
                                        "services.badanUsahaDetail.sidebar.vip_cta",
                                    )
                                }}
                            </a>
                            <div
                                class="relative mt-3 text-[11px] text-white/60"
                            >
                                {{
                                    t(
                                        "services.badanUsahaDetail.sidebar.vip_note",
                                    )
                                }}
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
                                    localizedProduct.name
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
                                {{
                                    t(
                                        "services.badanUsahaDetail.sidebar.price_label",
                                    )
                                }}
                            </div>
                            <div
                                class="text-[32px] font-bold leading-none text-primary mb-1"
                            >
                                {{ localizedProduct.price_label }}
                            </div>
                            <div class="text-[11px] text-[#686964] mb-4">
                                {{
                                    t(
                                        "services.badanUsahaDetail.sidebar.price_note",
                                    )
                                }}
                            </div>
                            <a
                                :href="buildWhatsappLink(localizedProduct.name)"
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
                                        "services.badanUsahaDetail.sidebar.konsultasi_cta",
                                    )
                                }}
                            </a>
                            <ul class="mt-4 space-y-2">
                                <li
                                    v-for="(feat, fi) in sidebarFeatures"
                                    :key="`feat-${fi}`"
                                    class="flex items-center gap-2 text-[12px] text-[#3D3D3A]"
                                >
                                    <img
                                        src="/icons/ft-done.svg"
                                        class="mt-0.5 h-4 w-4 flex-shrink-0"
                                        alt="done"
                                    />
                                    {{ feat }}
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
                                {{
                                    t(
                                        "service.badanUsahaDetail.sidebar.related_title",
                                    )
                                }}
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
                                    <div
                                        class="text-[14px] font-bold text-[#1A1B18] group-hover:text-primary transition-colors"
                                    >
                                        {{ related.name }}
                                    </div>
                                    <p
                                        class="text-[12px] leading-[1.6] text-[#686964] line-clamp-3"
                                    >
                                        {{
                                            related.excerpt ??
                                            related.description
                                        }}
                                    </p>
                                    <hr class="border-[#E8E8E6]" />
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div>
                                            <div
                                                class="text-[11px] text-[#686964] mb-0.5"
                                            >
                                                {{
                                                    t(
                                                        "services.badanUsahaDetail.sidebar.related_from",
                                                    )
                                                }}
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
                                            {{
                                                t(
                                                    "services.badanUsahaDetail.sidebar.related_packages",
                                                )
                                            }}
                                        </span>
                                    </div>
                                    <div
                                        class="mt-1 flex items-center justify-center gap-2 rounded-xl border border-primary py-2.5 text-[13px] font-semibold text-primary group-hover:bg-primary/5 transition-colors"
                                    >
                                        {{
                                            t(
                                                "services.badanUsahaDetail.sidebar.related_cta",
                                            )
                                        }}
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

        <FooterCTA
            :title="t('services.badanUsahaDetail.footer.title')"
            :description="t('services.badanUsahaDetail.footer.desc')"
            :button-text="t('services.badanUsahaDetail.footer.cta')"
            :whatsapp-link="buildWhatsappLink(localizedProduct.name)"
        />
    </MainLayout>
</template>
