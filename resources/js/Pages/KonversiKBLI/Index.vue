<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref, computed, onMounted, watch } from "vue";

// ─── Data & Loading ──────────────────────────────────────────────────────────
const allData = ref([]);
const isLoading = ref(true);
const loadError = ref(false);

onMounted(async () => {
    try {
        const res = await fetch(
            "/data/tabel-konversi-kbli2020-x-kbli2025.json",
        );
        if (!res.ok) throw new Error("Gagal memuat data");
        allData.value = await res.json();
    } catch (e) {
        console.error(e);
        loadError.value = true;
    } finally {
        isLoading.value = false;
    }
});

// ─── Filter & Search ─────────────────────────────────────────────────────────
const searchQuery = ref("");
const filterKategori = ref("Semua");
const showDropdown = ref(false);

const kategoriOptions = computed(() => {
    const cats = [
        ...new Set(
            allData.value
                .map((r) => r.kbl_2020?.trim())
                .filter((v) => v && v.length === 1),
        ),
    ].sort();
    return ["Semua", ...cats];
});

const filteredData = computed(() => {
    let data = allData.value;

    if (filterKategori.value !== "Semua") {
        data = data.filter((r) => r.kbl_2020?.trim() === filterKategori.value);
    }

    const q = searchQuery.value.trim().toLowerCase();
    if (q) {
        data = data
            .filter((r) => /^\d{5}$/.test(r.kbl_2020?.trim() ?? ""))
            .filter(
                (r) =>
                    r.kbl_2020?.toLowerCase().includes(q) ||
                    r.judul_kbl_2020?.toLowerCase().includes(q) ||
                    r.kbl_2025?.toLowerCase().includes(q) ||
                    r.judul_kbl_2025?.toLowerCase().includes(q),
            );
    }

    return data;
});

watch([searchQuery, filterKategori], () => {
    currentPage.value = 1;
});

// ─── Pagination ───────────────────────────────────────────────────────────────
const currentPage = ref(1);
const perPage = ref(6);

const totalRows = computed(() => filteredData.value.length);
const totalPages = computed(() =>
    Math.max(1, Math.ceil(totalRows.value / perPage.value)),
);

const pagedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    return filteredData.value.slice(start, start + perPage.value);
});

const setPage = (p) => {
    if (p >= 1 && p <= totalPages.value) currentPage.value = p;
};

const pageNumbers = computed(() => {
    const total = totalPages.value;
    const cur = currentPage.value;
    const delta = 1;
    const pages = [];
    for (
        let i = Math.max(1, cur - delta);
        i <= Math.min(total, cur + delta);
        i++
    ) {
        pages.push(i);
    }
    return pages;
});

// ─── WhatsApp ────────────────────────────────────────────────────────────────
const whatsappNumber = "6282298604144";
const buildWhatsappLink = () => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai konversi KBLI 2020 ke KBLI 2025.`;
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

// Close dropdown on outside click
const dropdownRef = ref(null);
const handleOutsideClick = (e) => {
    if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
        showDropdown.value = false;
    }
};
onMounted(() => document.addEventListener("click", handleOutsideClick));
</script>

<template>
    <MainLayout>
        <!-- ── Hero ──────────────────────────────────────────────────────── -->
        <section class="relative overflow-hidden bg-[#9e1f16]">
            <img
                src="/icons/left-arrow.svg"
                class="absolute right-0 -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block"
                alt=""
            />

            <div
                class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20"
            >
                <div
                    class="grid items-center gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16"
                >
                    <!-- Left: Text content -->
                    <div class="relative z-10">
                        <!-- Breadcrumb -->
                        <nav class="mb-8" aria-label="Breadcrumb">
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
                                <span class="text-sm font-medium text-white"
                                    >Tabel Konversi</span
                                >
                            </div>
                        </nav>

                        <h1
                            class="text-3xl font-extrabold leading-tight text-white sm:text-2xl lg:text-3xl max-w-[800px] line-clamp-2"
                        >
                            Tabel Konversi KBLI 2020 × KBLI 2025
                        </h1>
                        <p
                            class="mt-5 text-[15px] leading-relaxed text-white/80 max-w-lg"
                        >
                            Alat bantu untuk memetakan perubahan kode
                            klasifikasi usaha dalam rangka pendaftaran ulang
                            atau pembaharuan data NIB pada sistem OSS terbaru.
                        </p>

                        <div class="mt-8">
                            <a
                                href="/files/tabel-konversi-2020-x-2025.pdf"
                                download
                                class="inline-flex items-center gap-2.5 rounded-lg border-2 border-white bg-transparent px-6 py-3 text-[14px] font-semibold text-white hover:bg-white hover:text-[#9e1f16] transition-all duration-200"
                            >
                                Download KBLI 2025
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
                            </a>
                        </div>
                    </div>

                    <!-- Right: Book image -->
                    <div class="hidden lg:flex items-end justify-center">
                        <img
                            src="/images/ft-kbli-tabel-konversi.png"
                            alt="Table Konversi KBLI 2020 x KBLI 2025"
                            class="h-auto max-h-[320px] w-auto object-contain drop-shadow-2xl"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- ── Main Content ──────────────────────────────────────────────── -->
        <section class="py-10 sm:py-[52px]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col gap-6 sm:gap-8">

                <!-- ── Card Tabel ─────────────────────────────────────────── -->
                <div
                    class="rounded-2xl border border-[#D9DAD8] bg-white p-4 sm:p-6 lg:p-8 shadow-sm"
                >
                    <!-- Header -->
                    <div class="flex items-start gap-2 mb-3 sm:mb-4">
                        <img
                            src="/icons/ft-docs.svg"
                            class="w-7 h-7 sm:w-8 sm:h-8 flex-shrink-0"
                            alt="docs categories"
                        />
                        <h2 class="text-[16px] sm:text-[18px] font-bold text-[#1A1B18]">
                            Tabel Konversi KBLI 2020 x KBLI 2025
                        </h2>
                    </div>

                    <p class="text-[13px] leading-[22px] text-[#686964] mb-5 sm:mb-6">
                        Seiring dengan disempurnakannya KBLI 2020 menjadi KBLI
                        2025 yang telah mengacu pada struktur ISIC Revisi 5,
                        diperlukan suatu panduan yang dapat menjembatani
                        peralihan penggunaan klasifikasi tersebut. Publikasi
                        Tabel Konversi KBLI 2020 ke KBLI 2025 ini disusun untuk
                        memberikan acuan dalam melakukan penyesuaian kode dan
                        klasifikasi lapangan usaha dari KBLI 2020 ke KBLI 2025,
                        baik untuk kepentingan statistik maupun administrasi.
                    </p>

                    <!-- Divider -->
                    <div class="h-px w-full bg-[#D9DAD8] mb-5 sm:mb-6"></div>

                    <!-- Search + Filter -->
                    <div class="flex flex-col sm:flex-row gap-3 mb-5 sm:mb-6">
                        <!-- Search -->
                        <div class="relative flex-1">
                            <svg
                                class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[#9CA3AF]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Cari kode atau uraian usaha..."
                                class="w-full pl-10 pr-4 py-2.5 text-[13px] border border-[#D9DAD8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9e1f16]/20 focus:border-[#9e1f16] placeholder-[#9CA3AF] bg-white"
                            />
                        </div>

                        <!-- Filter Dropdown -->
                        <div class="relative" ref="dropdownRef">
                            <button
                                @click="showDropdown = !showDropdown"
                                class="flex items-center gap-2 px-4 py-2.5 text-[13px] font-medium border border-[#D9DAD8] rounded-lg bg-white text-[#1A1B18] hover:bg-[#F9F9F9] transition-colors w-full sm:w-auto justify-between sm:justify-start sm:min-w-[110px]"
                            >
                                <span>{{ filterKategori }}</span>
                                <svg
                                    class="h-4 w-4 text-[#686964] ml-auto sm:ml-0"
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
                                v-if="showDropdown"
                                class="absolute left-0 sm:right-0 sm:left-auto top-full mt-1 z-20 bg-white border border-[#D9DAD8] rounded-xl shadow-lg py-1 w-full sm:min-w-[130px] max-h-60 overflow-y-auto"
                            >
                                <button
                                    v-for="opt in kategoriOptions"
                                    :key="opt"
                                    @click="
                                        filterKategori = opt;
                                        showDropdown = false;
                                    "
                                    :class="[
                                        'w-full text-left px-4 py-2 text-[13px] hover:bg-[#FEF9F9] transition-colors',
                                        filterKategori === opt
                                            ? 'text-[#9e1f16] font-semibold'
                                            : 'text-[#1A1B18]',
                                    ]"
                                >
                                    {{ opt }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Loading -->
                    <div
                        v-if="isLoading"
                        class="flex flex-col items-center justify-center py-16 gap-3"
                    >
                        <div
                            class="w-8 h-8 border-2 border-[#9e1f16] border-t-transparent rounded-full animate-spin"
                        ></div>
                        <p class="text-[13px] text-[#686964]">
                            Memuat data konversi KBLI...
                        </p>
                    </div>

                    <!-- Error -->
                    <div
                        v-else-if="loadError"
                        class="flex flex-col items-center justify-center py-16 gap-3"
                    >
                        <svg
                            class="h-10 w-10 text-[#F87171]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        <p class="text-[14px] font-medium text-[#686964]">
                            Gagal memuat data
                        </p>
                        <p class="text-[13px] text-[#9CA3AF]">
                            Periksa koneksi Anda dan coba lagi
                        </p>
                    </div>

                    <!-- Data -->
                    <template v-else>

                        <!-- ── MOBILE: Card list (< sm) ─────────────────── -->
                        <div class="flex flex-col gap-3 sm:hidden">
                            <template v-if="pagedData.length > 0">
                                <div
                                    v-for="(row, i) in pagedData"
                                    :key="i"
                                    class="rounded-xl border border-[#E5E7EB] bg-[#FAFAFA] p-4 flex flex-col gap-3"
                                >
                                    <!-- KBLI 2020 -->
                                    <div class="flex flex-col gap-1">
                                        <span class="text-[10px] font-semibold uppercase tracking-wider text-[#9CA3AF]">KBLI 2020</span>
                                        <div class="flex items-start gap-2">
                                            <span class="inline-flex items-center rounded-md bg-[#9e1f16]/10 px-2 py-0.5 text-[12px] font-bold text-[#9e1f16] flex-shrink-0">
                                                {{ row.kbl_2020?.trim() }}
                                            </span>
                                            <span class="text-[13px] text-[#282925] leading-[20px]">
                                                {{ row.judul_kbl_2020?.trim() }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Arrow divider -->
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-px bg-[#E5E7EB]"></div>
                                        <svg class="h-4 w-4 text-[#9CA3AF] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        <div class="flex-1 h-px bg-[#E5E7EB]"></div>
                                    </div>

                                    <!-- KBLI 2025 -->
                                    <div class="flex flex-col gap-1">
                                        <span class="text-[10px] font-semibold uppercase tracking-wider text-[#9CA3AF]">KBLI 2025</span>
                                        <div class="flex items-start gap-2">
                                            <span class="inline-flex items-center rounded-md bg-[#1d4ed8]/10 px-2 py-0.5 text-[12px] font-bold text-[#1d4ed8] flex-shrink-0">
                                                {{ row.kbl_2025?.trim() }}
                                            </span>
                                            <span class="text-[13px] text-[#282925] leading-[20px]">
                                                {{ row.judul_kbl_2025?.trim() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div
                                v-else
                                class="rounded-xl border border-[#E5E7EB] py-12 text-center text-[#9CA3AF] text-[13px]"
                            >
                                Tidak ada data yang sesuai dengan pencarian Anda.
                            </div>
                        </div>

                        <!-- ── DESKTOP: Table (sm ke atas) ──────────────── -->
                        <div class="hidden sm:block overflow-x-auto rounded-xl border border-[#D9DAD8]">
                            <table class="w-full text-[13px] table-fixed">
                                <colgroup>
                                    <col style="width: 120px" />
                                    <col />
                                    <col style="width: 120px" />
                                    <col />
                                </colgroup>
                                <thead>
                                    <tr class="bg-[#F3F4F6] border-b border-[#D9DAD8]">
                                        <th class="text-center px-5 py-3 font-semibold text-[#1A1B18]">
                                            KBLI 2020
                                        </th>
                                        <th class="text-left px-5 py-3 font-semibold text-[#1A1B18]">
                                            JUDUL KBLI 2020
                                        </th>
                                        <th class="text-center px-5 py-3 font-semibold text-[#1A1B18]">
                                            KBLI 2025
                                        </th>
                                        <th class="text-left px-5 py-3 font-semibold text-[#1A1B18]">
                                            JUDUL KBLI 2025
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(row, i) in pagedData"
                                        :key="i"
                                        class="border-b border-[#F3F4F6] last:border-b-0 hover:bg-[#FAFAFA] transition-colors"
                                    >
                                        <td class="text-center px-5 py-4 font-medium text-[#1A1B18]">
                                            {{ row.kbl_2020?.trim() }}
                                        </td>
                                        <td class="px-5 py-4 text-[#282925] break-words">
                                            {{ row.judul_kbl_2020?.trim() }}
                                        </td>
                                        <td class="text-center px-5 py-4 font-medium text-[#1A1B18]">
                                            {{ row.kbl_2025?.trim() }}
                                        </td>
                                        <td class="px-5 py-4 text-[#282925] break-words">
                                            {{ row.judul_kbl_2025?.trim() }}
                                        </td>
                                    </tr>
                                    <tr v-if="pagedData.length === 0">
                                        <td
                                            colspan="4"
                                            class="px-5 py-12 text-center text-[#9CA3AF] text-[13px]"
                                        >
                                            Tidak ada data yang sesuai dengan pencarian Anda.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- ── Pagination ───────────────────────────────── -->
                        <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between text-[13px]">

                            <!-- Total rows -->
                            <span class="text-[#686964] text-center sm:text-left">
                                {{ totalRows.toLocaleString("id-ID") }} Row
                            </span>

                            <!-- Page buttons -->
                            <div class="flex items-center justify-center gap-1">
                                <button @click="setPage(1)" :disabled="currentPage === 1" class="pag-btn">«</button>
                                <button @click="setPage(currentPage - 1)" :disabled="currentPage === 1" class="pag-btn">‹</button>
                                <button
                                    v-for="p in pageNumbers"
                                    :key="p"
                                    @click="setPage(p)"
                                    :class="['pag-btn', p === currentPage ? 'pag-btn--active' : '']"
                                >
                                    {{ p }}
                                </button>
                                <button @click="setPage(currentPage + 1)" :disabled="currentPage === totalPages" class="pag-btn">›</button>
                                <button @click="setPage(totalPages)" :disabled="currentPage === totalPages" class="pag-btn">»</button>
                            </div>

                            <!-- Rows per page -->
                            <div class="flex items-center justify-center sm:justify-end gap-2 text-[#686964]">
                                <span>Rows per page</span>
                                <select
                                    v-model="perPage"
                                    @change="currentPage = 1"
                                    class="appearance-none border border-[#D9DAD8] rounded-lg px-3 py-1.5 text-[12px] bg-white text-[#1A1B18] focus:outline-none focus:ring-2 focus:ring-[#9e1f16]/20 cursor-pointer"
                                >
                                    <option :value="10">10</option>
                                    <option :value="20">20</option>
                                    <option :value="50">50</option>
                                    <option :value="100">100</option>
                                </select>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- ── Footer CTA ──────────────────────────────────────────── -->
                <div
                    class="relative overflow-hidden rounded-2xl bg-[#9e1f16] px-6 py-10 sm:px-10 sm:py-14"
                >
                    <img
                        src="/icons/ft-docs.svg"
                        alt=""
                        class="absolute right-6 top-6 h-14 w-14 opacity-20 sm:right-10 sm:top-8 sm:h-24 sm:w-24"
                    />
                    <div class="relative flex flex-col items-center text-center">
                        <h3
                            class="max-w-2xl text-[20px] font-bold leading-[30px] text-white sm:text-[28px] sm:leading-[38px]"
                        >
                            Tidak Menemukan KBLI yang Anda Cari?
                        </h3>
                        <p
                            class="mt-3 sm:mt-4 max-w-lg text-[13px] leading-[21px] text-white/80 sm:text-[16px] sm:leading-[24px]"
                        >
                            Tim kami siap membantu Anda menemukan solusi yang tepat
                            untuk kebutuhan legalitas bisnis Anda.
                        </p>
                        <a
                            :href="buildWhatsappLink()"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-6 sm:mt-8 inline-flex items-center gap-2.5 rounded-lg bg-[#25D366] px-6 py-3 text-[14px] font-semibold text-white shadow-lg shadow-[#25D366]/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#20BD5A] sm:px-8 sm:py-3.5 sm:text-[15px]"
                        >
                            Chat Langsung via WhatsApp
                            <img src="/icons/ft-wa.svg" alt="WhatsApp" class="h-5 w-5" />
                        </a>
                    </div>
                </div>

            </div>
        </section>
    </MainLayout>
</template>

<style scoped>
.pag-btn {
    @apply flex items-center justify-center w-8 h-8 rounded-lg text-[13px] text-[#686964] border border-[#D9DAD8] bg-white hover:bg-[#F9F9F9] transition-colors disabled:opacity-40 disabled:cursor-not-allowed;
}
.pag-btn--active {
    @apply bg-[#9e1f16] text-white border-[#9e1f16] font-semibold hover:bg-[#9e1f16];
}
</style>
