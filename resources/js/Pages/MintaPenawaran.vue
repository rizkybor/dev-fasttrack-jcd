<script setup>
import { ref, computed, watch, onUnmounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
import MainLayout from "@/Layouts/MainLayout.vue";
import FooterCTA from "@/Components/FooterCTA.vue";
import InputError from "@/Components/InputError.vue";
import { waLink } from "@/Composables/useWhatsapp";

/**
 * Halaman "Minta Penawaran" — Penawaran Fasttrack
 * Sesuai desain Figma: hero + pilih layanan (kategori > layanan > detail)
 * + ringkasan biaya + form pemohon.
 */

const { t, tm } = useI18n();

/* ------------------------------------------------------------------ */
/* Locale-driven data                                                  */
/* ------------------------------------------------------------------ */

const kategoriOptions = computed(() => tm("mintaPenawaran.kategori_options"));
const layananByKategori = computed(() =>
    tm("mintaPenawaran.layanan_by_kategori"),
);
const detailByLayanan = computed(() => tm("mintaPenawaran.detail_by_layanan"));

/* ------------------------------------------------------------------ */
/* Selection state                                                     */
/* ------------------------------------------------------------------ */

const selectedKategori = ref("");
const selectedLayanan = ref("");
const selectedDetail = ref("");

const layananOptions = computed(() => {
    return layananByKategori.value[selectedKategori.value] ?? [];
});

const detailOptions = computed(() => {
    return detailByLayanan.value[selectedLayanan.value] ?? [];
});

// Reset pilihan turunan ketika pilihan induk berubah
watch(selectedKategori, () => {
    selectedLayanan.value = "";
    selectedDetail.value = "";
});
watch(selectedLayanan, () => {
    selectedDetail.value = "";
});

const selectedDetailData = computed(() => {
    return (
        detailOptions.value.find((d) => d.value === selectedDetail.value) ??
        null
    );
});

const selectedKategoriLabel = computed(() => {
    return (
        kategoriOptions.value.find((k) => k.value === selectedKategori.value)
            ?.label ?? ""
    );
});

const selectedLayananLabel = computed(() => {
    return (
        layananOptions.value.find((l) => l.value === selectedLayanan.value)
            ?.label ?? ""
    );
});

/* ------------------------------------------------------------------ */
/* Biaya layanan                                                       */
/* ------------------------------------------------------------------ */

// harga null = "Hubungi Kami" (belum ada harga pasti untuk layanan ini)
const hargaTersedia = computed(
    () => selectedDetailData.value && selectedDetailData.value.harga !== null,
);
const biayaLayanan = computed(() => selectedDetailData.value?.harga ?? 0);
const ppn = computed(() => Math.round(biayaLayanan.value * 0.11));
const subtotal = computed(() => biayaLayanan.value + ppn.value);

const formatRupiah = (value) => {
    return "Rp " + Number(value ?? 0).toLocaleString("id-ID");
};

/* ------------------------------------------------------------------ */
/* Form pemohon                                                        */
/* ------------------------------------------------------------------ */

const form = useForm({
    kategori: "",
    layanan: "",
    detail_layanan: "",
    kategori_label: "",
    layanan_label: "",
    detail_label: "",
    harga_label: "",
    nama: "",
    perusahaan: "",
    no_whatsapp: "",
    email: "",
    website: "", // honeypot anti-spam — harus selalu kosong, diisi otomatis oleh bot
});

const contactHoneypotId = `mp-hp-${Math.random().toString(36).slice(2)}`;
const submitSuccess = ref(false);
let submitSuccessTimer = null;

const closeSuccessModal = () => {
    clearTimeout(submitSuccessTimer);
    submitSuccess.value = false;
};

const openSuccessModal = () => {
    submitSuccess.value = true;
    clearTimeout(submitSuccessTimer);
    submitSuccessTimer = setTimeout(closeSuccessModal, 5000);
};

onUnmounted(() => clearTimeout(submitSuccessTimer));

const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const WHATSAPP_PATTERN = /^[0-9]{10,13}$/;

const isFormValid = computed(() => {
    return (
        selectedDetail.value !== "" &&
        form.nama &&
        form.no_whatsapp &&
        form.email
    );
});

const validateForm = () => {
    form.clearErrors();
    let valid = true;

    if (!selectedDetail.value) {
        form.setError(
            "detail_layanan",
            t("mintaPenawaran.errors.kategori_required"),
        );
        valid = false;
    }

    if (!form.nama.trim()) {
        form.setError("nama", t("mintaPenawaran.errors.nama_required"));
        valid = false;
    }

    if (!form.email.trim()) {
        form.setError("email", t("mintaPenawaran.errors.email_required"));
        valid = false;
    } else if (!EMAIL_PATTERN.test(form.email.trim())) {
        form.setError("email", t("mintaPenawaran.errors.email_invalid"));
        valid = false;
    }

    if (!form.no_whatsapp.trim()) {
        form.setError(
            "no_whatsapp",
            t("mintaPenawaran.errors.whatsapp_required"),
        );
        valid = false;
    } else if (
        !WHATSAPP_PATTERN.test(form.no_whatsapp.trim().replace(/[\s\-]/g, ""))
    ) {
        form.setError(
            "no_whatsapp",
            t("mintaPenawaran.errors.whatsapp_invalid"),
        );
        valid = false;
    }

    return valid;
};

const submit = () => {
    closeSuccessModal();

    form.kategori = selectedKategori.value;
    form.layanan = selectedLayanan.value;
    form.detail_layanan = selectedDetail.value;
    form.kategori_label = selectedKategoriLabel.value;
    form.layanan_label = selectedLayananLabel.value;
    form.detail_label = selectedDetailData.value?.label ?? "";
    form.harga_label = hargaTersedia.value
        ? formatRupiah(biayaLayanan.value)
        : t("mintaPenawaran.biaya.hubungi_kami");

    if (!validateForm()) return;

    // Normalisasi nomor WhatsApp (hapus spasi/tanda hubung) agar konsisten
    // dengan validasi digit 10-13 di server.
    form.no_whatsapp = form.no_whatsapp.trim().replace(/[\s\-]/g, "");

    form.post(route("minta-penawaran.store"), {
        preserveScroll: true,
        onSuccess: () => {
            openSuccessModal();
            form.reset(
                "nama",
                "perusahaan",
                "no_whatsapp",
                "email",
                "website",
            );
        },
    });
};

/* ------------------------------------------------------------------ */
/* WhatsApp CTA                                                        */
/* ------------------------------------------------------------------ */

const whatsappLink = computed(() => waLink(t("mintaPenawaran.cta.title")));
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
                <div class="relative z-10 max-w-2xl">
                    <!-- Breadcrumb -->
                    <nav class="mb-6" aria-label="Breadcrumb">
                        <div
                            class="inline-flex items-center gap-2 rounded-full bg-white/20 backdrop-blur-sm px-4 py-2"
                        >
                            <a
                                href="/"
                                class="text-white/90 hover:text-white transition"
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
                            <span class="text-sm font-medium text-white">{{
                                t("mintaPenawaran.hero.breadcrumb")
                            }}</span>
                        </div>
                    </nav>

                    <!-- Heading -->
                    <h1
                        class="text-3xl font-extrabold leading-tight text-white sm:text-4xl lg:text-5xl"
                    >
                        {{ t("mintaPenawaran.hero.title") }}
                    </h1>
                    <p class="mt-3 text-sm sm:text-base text-white/85">
                        {{ t("mintaPenawaran.hero.desc") }}
                    </p>
                </div>
            </div>
        </section>

        <!-- CONTENT SECTION -->
        <section class="py-[52px] bg-[#F9F9F9]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="grid gap-6 lg:grid-cols-[1fr_360px] items-start">
                    <!-- MAIN COLUMN -->
                    <div class="flex flex-col gap-6">
                        <!-- Pilih Layanan Card -->
                        <div
                            class="rounded-xl border border-[#D9DAD8] bg-white p-6 sm:p-8"
                        >
                            <a
                                href="/layanan"
                                class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#9e1f16] hover:text-[#7f1912] transition mb-5"
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
                                {{ t("mintaPenawaran.pilih_layanan.link") }}
                            </a>

                            <div class="grid gap-4 sm:grid-cols-3">
                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-[12px] font-medium text-[#1A1B18]"
                                    >
                                        {{
                                            t(
                                                "mintaPenawaran.pilih_layanan.kategori_label",
                                            )
                                        }}
                                    </label>
                                    <div class="relative">
                                        <select
                                            v-model="selectedKategori"
                                            class="w-full appearance-none rounded-lg border border-[#D9DAD8] px-3 py-2.5 pr-9 text-[12px] text-[#1A1B18] focus:border-[#9e1f16] focus:outline-none"
                                        >
                                            <option value="" disabled>
                                                {{
                                                    t(
                                                        "mintaPenawaran.pilih_layanan.kategori_placeholder",
                                                    )
                                                }}
                                            </option>
                                            <option
                                                v-for="opt in kategoriOptions"
                                                :key="opt.value"
                                                :value="opt.value"
                                            >
                                                {{ opt.label }}
                                            </option>
                                        </select>
                                        <svg
                                            class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#7A7B78]"
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
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-[12px] font-medium text-[#1A1B18]"
                                    >
                                        {{
                                            t(
                                                "mintaPenawaran.pilih_layanan.layanan_label",
                                            )
                                        }}
                                    </label>
                                    <div class="relative">
                                        <select
                                            v-model="selectedLayanan"
                                            :disabled="!selectedKategori"
                                            class="w-full appearance-none rounded-lg border border-[#D9DAD8] px-3 py-2.5 pr-9 text-[12px] text-[#1A1B18] focus:border-[#9e1f16] focus:outline-none disabled:bg-[#F5F5F4] disabled:text-[#B0B1AE]"
                                        >
                                            <option value="" disabled>
                                                {{
                                                    t(
                                                        "mintaPenawaran.pilih_layanan.layanan_placeholder",
                                                    )
                                                }}
                                            </option>
                                            <option
                                                v-for="opt in layananOptions"
                                                :key="opt.value"
                                                :value="opt.value"
                                            >
                                                {{ opt.label }}
                                            </option>
                                        </select>
                                        <svg
                                            class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#7A7B78]"
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
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-[12px] font-medium text-[#1A1B18]"
                                    >
                                        {{
                                            t(
                                                "mintaPenawaran.pilih_layanan.detail_label",
                                            )
                                        }}
                                    </label>
                                    <div class="relative">
                                        <select
                                            v-model="selectedDetail"
                                            :disabled="!selectedLayanan"
                                            class="w-full appearance-none rounded-lg border border-[#D9DAD8] px-3 py-2.5 pr-9 text-[12px] text-[#1A1B18] focus:border-[#9e1f16] focus:outline-none disabled:bg-[#F5F5F4] disabled:text-[#B0B1AE]"
                                        >
                                            <option value="" disabled>
                                                {{
                                                    t(
                                                        "mintaPenawaran.pilih_layanan.detail_placeholder",
                                                    )
                                                }}
                                            </option>
                                            <option
                                                v-for="opt in detailOptions"
                                                :key="opt.value"
                                                :value="opt.value"
                                            >
                                                {{ opt.label }}
                                            </option>
                                        </select>
                                        <svg
                                            class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#7A7B78]"
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
                                </div>
                            </div>

                            <!-- Selected Service Preview -->
                            <div
                                v-if="selectedDetailData"
                                class="relative mt-6 overflow-hidden rounded-xl bg-[#9e1f16] px-6 py-10 text-left"
                                style="background-image: url('/images/minta-penawaran.svg'); background-size: cover; background-position: center; background-repeat: no-repeat;"
                            >
                                <p
                                    class="text-[15px] font-bold uppercase tracking-wide text-white"
                                >
                                    {{ selectedDetailData.label }}
                                </p>
                                <template v-if="hargaTersedia">
                                    <p class="mt-4 text-[11px] text-white/70">
                                        {{
                                            t(
                                                "mintaPenawaran.pilih_layanan.starting_from",
                                            )
                                        }}
                                    </p>
                                    <p class="text-3xl font-extrabold text-white">
                                        {{ formatRupiah(selectedDetailData.harga) }}
                                    </p>
                                </template>
                                <p v-else class="mt-4 text-3xl font-extrabold text-white">
                                    {{ t("mintaPenawaran.biaya.hubungi_kami") }}
                                </p>
                            </div>

                            <!-- Empty state -->
                            <div
                                v-else
                                class="mt-6 flex flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-[#D9DAD8] px-6 py-12 text-center"
                            >
                                <p class="text-[12px] text-[#7A7B78]">
                                    {{
                                        t(
                                            "mintaPenawaran.pilih_layanan.empty_state",
                                        )
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- SIDEBAR -->
                    <aside class="lg:sticky lg:top-24 flex flex-col gap-4">
                        <form
                            @submit.prevent="submit"
                            class="rounded-xl border border-[#D9DAD8] bg-white p-5 flex flex-col gap-5"
                        >
                            <!-- Biaya Layanan -->
                            <div class="flex flex-col gap-3">
                                <h3
                                    class="text-[13px] font-bold uppercase tracking-wide text-[#1A1B18]"
                                >
                                    {{ t("mintaPenawaran.biaya.title") }}
                                </h3>

                                <div
                                    v-if="selectedDetailData && hargaTersedia"
                                    class="flex flex-col gap-2"
                                >
                                    <p
                                        class="text-[11px] font-semibold uppercase text-[#7A7B78]"
                                    >
                                        {{ selectedLayananLabel }}
                                    </p>

                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <span
                                            class="text-[11px] text-[#4A4B47]"
                                            >{{
                                                t(
                                                    "mintaPenawaran.biaya.biaya_label",
                                                )
                                            }}</span
                                        >
                                        <span
                                            class="text-[11px] font-medium text-[#1A1B18]"
                                        >
                                            {{ formatRupiah(biayaLayanan) }}
                                        </span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <span
                                            class="text-[11px] text-[#4A4B47]"
                                            >{{
                                                t(
                                                    "mintaPenawaran.biaya.ppn_label",
                                                )
                                            }}</span
                                        >
                                        <span
                                            class="text-[11px] font-medium text-[#1A1B18]"
                                        >
                                            {{ formatRupiah(ppn) }}
                                        </span>
                                    </div>

                                    <div
                                        class="h-px w-full bg-[#E0E0E0] my-1"
                                    ></div>

                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <span
                                            class="text-[12px] font-semibold text-[#1A1B18]"
                                            >{{
                                                t(
                                                    "mintaPenawaran.biaya.subtotal_label",
                                                )
                                            }}</span
                                        >
                                        <span
                                            class="text-[13px] font-bold text-[#9e1f16]"
                                        >
                                            {{ formatRupiah(subtotal) }}
                                        </span>
                                    </div>

                                    <p
                                        class="text-[10px] leading-[15px] text-[#B0B1AE] mt-1"
                                    >
                                        {{ t("mintaPenawaran.biaya.note") }}
                                    </p>
                                </div>

                                <div
                                    v-else-if="selectedDetailData"
                                    class="flex flex-col gap-1"
                                >
                                    <p
                                        class="text-[11px] font-semibold uppercase text-[#7A7B78]"
                                    >
                                        {{ selectedLayananLabel }}
                                    </p>
                                    <p class="text-[13px] font-bold text-[#9e1f16]">
                                        {{ t("mintaPenawaran.biaya.hubungi_kami") }}
                                    </p>
                                </div>

                                <p v-else class="text-[11px] text-[#B0B1AE]">
                                    {{ t("mintaPenawaran.biaya.empty") }}
                                </p>
                            </div>

                            <div class="h-px w-full bg-[#E0E0E0]"></div>

                            <!-- Pemohon -->
                            <div class="flex flex-col gap-3">
                                <h3
                                    class="text-[13px] font-bold uppercase tracking-wide text-[#1A1B18]"
                                >
                                    {{ t("mintaPenawaran.pemohon.title") }}
                                </h3>

                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-[11px] font-medium text-[#1A1B18]"
                                        >{{
                                            t(
                                                "mintaPenawaran.pemohon.nama_label",
                                            )
                                        }}</label
                                    >
                                    <input
                                        v-model="form.nama"
                                        type="text"
                                        :placeholder="
                                            t(
                                                'mintaPenawaran.pemohon.nama_placeholder',
                                            )
                                        "
                                        class="w-full rounded-lg border px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        :class="form.errors.nama ? 'border-red-400' : 'border-[#D9DAD8]'"
                                    />
                                    <InputError :message="form.errors.nama" />
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-[11px] font-medium text-[#1A1B18]"
                                        >{{
                                            t(
                                                "mintaPenawaran.pemohon.perusahaan_label",
                                            )
                                        }}</label
                                    >
                                    <input
                                        v-model="form.perusahaan"
                                        type="text"
                                        :placeholder="
                                            t(
                                                'mintaPenawaran.pemohon.perusahaan_placeholder',
                                            )
                                        "
                                        class="w-full rounded-lg border border-[#D9DAD8] px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                    />
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-[11px] font-medium text-[#1A1B18]"
                                        >{{
                                            t(
                                                "mintaPenawaran.pemohon.whatsapp_label",
                                            )
                                        }}</label
                                    >
                                    <input
                                        v-model="form.no_whatsapp"
                                        type="text"
                                        :placeholder="
                                            t(
                                                'mintaPenawaran.pemohon.whatsapp_placeholder',
                                            )
                                        "
                                        class="w-full rounded-lg border px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        :class="form.errors.no_whatsapp ? 'border-red-400' : 'border-[#D9DAD8]'"
                                    />
                                    <InputError :message="form.errors.no_whatsapp" />
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label
                                        class="text-[11px] font-medium text-[#1A1B18]"
                                        >{{
                                            t(
                                                "mintaPenawaran.pemohon.email_label",
                                            )
                                        }}</label
                                    >
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        :placeholder="
                                            t(
                                                'mintaPenawaran.pemohon.email_placeholder',
                                            )
                                        "
                                        class="w-full rounded-lg border px-3 py-2.5 text-[12px] placeholder:text-[#B0B1AE] focus:border-[#9e1f16] focus:outline-none"
                                        :class="form.errors.email ? 'border-red-400' : 'border-[#D9DAD8]'"
                                    />
                                    <InputError :message="form.errors.email" />
                                </div>

                                <InputError
                                    v-if="form.errors.detail_layanan"
                                    :message="form.errors.detail_layanan"
                                />
                            </div>

                            <!-- Honeypot anti-spam: invisible untuk manusia, sering otomatis diisi oleh bot. -->
                            <div
                                class="absolute left-[-9999px] top-auto w-px h-px overflow-hidden"
                                aria-hidden="true"
                            >
                                <label :for="contactHoneypotId">Website</label>
                                <input
                                    :id="contactHoneypotId"
                                    v-model="form.website"
                                    type="text"
                                    tabindex="-1"
                                    autocomplete="off"
                                />
                            </div>

                            <!-- Submit -->
                            <button
                                type="submit"
                                :disabled="!isFormValid || form.processing"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#9e1f16] px-6 py-3 text-[13px] font-semibold text-white transition hover:bg-[#7f1912] disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                {{
                                    form.processing
                                        ? t("mintaPenawaran.submitting")
                                        : t("mintaPenawaran.submit_cta")
                                }}
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
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                                    />
                                </svg>
                            </button>
                        </form>

                        <!-- Info Box -->
                        <div
                            class="flex items-start gap-2.5 rounded-lg bg-[#E7F3FB] border border-[#C7E4F5] px-4 py-3.5"
                        >
                            <svg
                                class="h-4 w-4 shrink-0 mt-0.5 text-[#2E90D6]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <p
                                class="text-[11px] leading-[17px] text-[#2E6A96]"
                            >
                                {{ t("mintaPenawaran.info_box") }}
                            </p>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <FooterCTA
            :title="t('mintaPenawaran.cta.title')"
            :description="t('mintaPenawaran.cta.desc')"
            :button-text="t('mintaPenawaran.cta.whatsapp')"
            :whatsapp-link="whatsappLink"
        />
    </MainLayout>

    <!-- Modal sukses submit — auto-close setelah beberapa detik -->
    <transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="submitSuccess"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            @click.self="closeSuccessModal"
        >
            <transition
                enter-active-class="transition duration-250 ease-out"
                enter-from-class="opacity-0 scale-95 translate-y-2"
                enter-to-class="opacity-100 scale-100 translate-y-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 scale-100 translate-y-0"
                leave-to-class="opacity-0 scale-95 translate-y-2"
                appear
            >
                <div
                    class="relative w-full max-w-[420px] bg-white rounded-2xl shadow-2xl overflow-hidden p-6 sm:p-8 text-center"
                >
                    <button
                        type="button"
                        @click="closeSuccessModal"
                        class="absolute right-4 top-4 flex h-8 w-8 items-center justify-center rounded-lg text-[#7A7B78] hover:bg-[#F5F5F4] hover:text-[#1A1B18] transition-colors"
                        :aria-label="t('mintaPenawaran.close')"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-50">
                        <svg class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <h3 class="mt-4 text-[16px] font-bold text-[#1A1B18]">
                        {{ t("mintaPenawaran.submit_success_title") }}
                    </h3>
                    <p class="mt-2 text-[13px] leading-relaxed text-[#42443D]">
                        {{ t("mintaPenawaran.submit_success") }}
                    </p>

                    <button
                        type="button"
                        @click="closeSuccessModal"
                        class="mt-6 w-full rounded-lg bg-[#9e1f16] px-6 py-2.5 text-[13px] font-semibold text-white transition hover:bg-[#7f1912]"
                    >
                        {{ t("mintaPenawaran.close") }}
                    </button>
                </div>
            </transition>
        </div>
    </transition>
</template>
