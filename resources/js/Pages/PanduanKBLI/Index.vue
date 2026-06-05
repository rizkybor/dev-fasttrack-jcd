<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref, computed, onMounted } from "vue";

const props = defineProps({
    kbliData: {
        type: Array,
        default: () => [],
    },
});

const whatsappNumber = "6282298604144";
const buildWhatsappLink = () => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai KBLI yang saya cari.`;
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

const fetchedData = ref([]);
const isLoading = ref(false);

onMounted(async () => {
    if (!props.kbliData.length) {
        isLoading.value = true;
        try {
            const res = await fetch("/data/kbli2025.json");
            if (res.ok) {
                fetchedData.value = await res.json();
            }
        } catch (e) {
            console.error("Gagal memuat data KBLI:", e);
        } finally {
            isLoading.value = false;
        }
    }
});

const data = computed(() => {
    if (props.kbliData.length) return props.kbliData;
    if (fetchedData.value.length) return fetchedData.value;
    return [];
});

// ─── Search ───────────────────────────────────────────────────────────────────
const globalSearch = ref("");

// ─── Navigation stack ────────────────────────────────────────────────────────
// Stack of { node } — each entry is a node we drilled into
const navigationStack = ref([]); // array of nodes (ancestors)
const activeNode = ref(null);

const currentChildren = computed(() => {
    if (!activeNode.value) return data.value;
    return activeNode.value.children ?? [];
});

const filteredChildren = computed(() => {
    const q = globalSearch.value.trim().toLowerCase();
    if (!q) return currentChildren.value;
    return currentChildren.value.filter((c) => {
        const kode = (c.kategori ?? c.nomor_kbli ?? "").toLowerCase();
        const nama = (c.nama ?? "").toLowerCase();
        const desc = (c.description ?? c.deskripsi ?? "").toLowerCase();
        return kode.includes(q) || nama.includes(q) || desc.includes(q);
    });
});

// Ancestors list for "SEBELUMNYA" section (all ancestors in order)
const ancestors = computed(() => navigationStack.value);

const drillDown = (node) => {
    if (activeNode.value) {
        navigationStack.value.push(activeNode.value);
    }
    activeNode.value = node;
    globalSearch.value = "";
};

const goBack = () => {
    if (navigationStack.value.length > 0) {
        activeNode.value = navigationStack.value.pop();
    } else {
        activeNode.value = null;
    }
    globalSearch.value = "";
};

const goToRoot = () => {
    navigationStack.value = [];
    activeNode.value = null;
    globalSearch.value = "";
};

const goToAncestor = (idx) => {
    // idx is index in navigationStack
    const target = navigationStack.value[idx];
    navigationStack.value = navigationStack.value.slice(0, idx);
    activeNode.value = target;
    globalSearch.value = "";
};

const getKode = (node) => node.kategori ?? node.nomor_kbli ?? "";
const hasChildren = (node) => node.children && node.children.length > 0;
const getDesc = (node) => node.description ?? node.deskripsi ?? "";

// Whether current view is root (Kategori list)
const isRoot = computed(() => !activeNode.value);

// Is the current active node a leaf (Kelompok)
const isLeaf = computed(
    () => activeNode.value && !hasChildren(activeNode.value),
);
</script>

<template>
    <MainLayout>
         <!-- ── Hero ──────────────────────────────────────────────────────── -->
        <section class="relative overflow-hidden bg-[#9e1f16]">
            <!-- Decorative arrow shape (right side, matches site pattern) -->
            <img
                src="/icons/left-arrow.svg"
                class="absolute right-0 -top-[15%] h-[130%] w-auto pointer-events-none hidden lg:block"
                alt=""
            />

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
                <div class="grid items-center gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16">

                    <!-- ── Left: Text content ─────────────────────────────── -->
                    <div class="relative z-10">
                        <!-- Breadcrumb -->
                        <nav class="mb-8" aria-label="Breadcrumb">
                            <div class="inline-flex items-center gap-2 rounded-full bg-white/20 backdrop-blur-sm px-4 py-2">
                                <a href="/" class="text-white/90 hover:text-white transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
                                    </svg>
                                </a>
                                <svg class="h-3 w-3 text-white/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                <span class="text-sm font-medium text-white">Panduan KBLI</span>
                            </div>
                        </nav>

                        <!-- Heading -->
                        <h1 class="text-2xl font-extrabold leading-tight text-white sm:text-4xl lg:text-4xl">
                            Klasifikasi Buku Lapangan Usaha<br />Indonesia (KBLI) 2025
                        </h1>
                        <p class="mt-5 text-[15px] leading-relaxed text-white/80 max-w-lg">
                            Temukan kode KBLI yang tepat untuk bidang usaha Anda berdasarkan data terbaru.
                        </p>

                        <!-- Download button -->
                        <div class="mt-8">
                            <a
                                href="/files/panduan-kbli.pdf"
                                download
                                class="inline-flex items-center gap-2.5 rounded-lg border-2 border-white bg-transparent px-6 py-3 text-[14px] font-semibold text-white hover:bg-white hover:text-[#9e1f16] transition-all duration-200"
                            >
                                Download KBLI 2025
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- ── Right: Book image ──────────────────────────────── -->
                    <div class="hidden lg:flex items-end justify-center">
                        <img
                            src="/images/ft-kbli.png"
                            alt="Buku KBLI 2025"
                            class="h-auto max-h-[320px] w-auto object-contain drop-shadow-2xl"
                        />
                    </div>

                </div>
            </div>
        </section>

        <!-- ── Main Content ──────────────────────────────────────────────── -->
        <section class="py-[52px]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col gap-6">
                <!-- ── Main Card ──────────────────────────────────────────── -->
                <div
                    class="rounded-2xl border border-[#E5E7EB] bg-white shadow-sm overflow-hidden"
                >
                    <!-- ── Card Header ────────────────────────────────────── -->
                    <div
                        class="flex items-center gap-3 px-6 py-4 border-b border-[#E5E7EB]"
                    >
                        <img
                            src="/icons/ft-docs.svg"
                            alt=""
                            class="h-8 w-8 text-[#9e1f16]"
                            onerror="
                                this.style.display = 'none';
                                this.nextElementSibling.style.display = 'block';
                            "
                        />
                        <span class="text-[15px] font-bold text-[#1A1B18]">
                            {{ isRoot ? "KBLI 2025" : "Detail KBLI 2025" }}
                        </span>
                    </div>

                    <!-- ── Search Bar ──────────────────────────────────────── -->
                    <div class="px-6 py-4 border-b border-[#E5E7EB]">
                        <div class="flex items-center gap-3">
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
                                    v-model="globalSearch"
                                    type="text"
                                    placeholder="Cari Kode KBLI atau Nama Kegiatan"
                                    class="w-full pl-10 pr-4 py-2.5 text-[13px] border border-[#E5E7EB] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9e1f16]/20 focus:border-[#9e1f16] placeholder-[#9CA3AF] bg-white"
                                />
                            </div>
                            <!-- Filter dropdown placeholder -->
                            <!-- <button
                                class="flex items-center gap-1.5 px-4 py-2.5 text-[13px] font-medium text-[#374151] border border-[#E5E7EB] rounded-lg bg-white hover:bg-[#F9FAFB] transition whitespace-nowrap"
                            >
                                Semua
                                <svg
                                    class="h-3.5 w-3.5 text-[#9CA3AF]"
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
                            </button> -->
                        </div>
                    </div>

                    <!-- ── Loading ─────────────────────────────────────────── -->
                    <div
                        v-if="isLoading"
                        class="px-6 py-16 flex flex-col items-center gap-3"
                    >
                        <div
                            class="w-7 h-7 border-2 border-[#9e1f16] border-t-transparent rounded-full animate-spin"
                        ></div>
                        <p class="text-[13px] text-[#686964]">
                            Memuat data KBLI...
                        </p>
                    </div>

                    <!-- ── Content ─────────────────────────────────────────── -->
                    <div v-if="!isLoading">
                        <!-- ═══════ ROOT: Daftar Kategori ═══════════════════ -->
                        <template v-if="isRoot">
                            <!-- Description block -->
                            <div class="px-6 py-5 border-b border-[#F3F4F6]">
                                <p
                                    class="text-[13px] leading-[22px] text-[#374151]"
                                >
                                    Untuk mempermudah Anda sebagai pelaku usaha
                                    menentukan kategori Bidang Usaha yang akan
                                    dikembangkan di Indonesia, pemerintah
                                    melalui Badan Pusat Statistik (BPS) menyusun
                                    Klasifikasi Baku Lapangan Usaha Indonesia
                                    (KBLI) sebagai panduan penentuan jenis
                                    kegiatan usaha/bisnis. Acuan ini sesuai
                                    dengan Peraturan BPS Nomor 7 Tahun 2025
                                    tentang Klasifikasi Baku Lapangan Usaha
                                    Indonesia.
                                </p>
                                <p
                                    class="mt-3 text-[13px] leading-[22px] text-[#374151]"
                                >
                                    KBLI adalah pengklasifikasian
                                    aktivitas/kegiatan ekonomi Indonesia yang
                                    menghasilkan produk/output, baik berupa
                                    barang maupun jasa, berdasarkan lapangan
                                    usaha untuk memberikan keseragaman konsep,
                                    definisi, dan klasifikasi lapangan usaha
                                    dalam perkembangan dan pergeseran kegiatan
                                    ekonomi di Indonesia.
                                </p>
                            </div>

                            <!-- Kategori list -->
                            <div class="divide-y divide-[#F3F4F6]">
                                <div
                                    v-for="(item, i) in filteredChildren"
                                    :key="i"
                                    :class="[
                                        'flex items-center gap-4 px-6 py-4 transition-all group',
                                        hasChildren(item)
                                            ? 'cursor-pointer hover:bg-[#FEF9F9]'
                                            : 'cursor-default',
                                    ]"
                                    @click="drillDown(item)"
                                >
                                    <!-- Kode badge -->
                                    <span
                                        class="flex-shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-lg text-[13px] font-extrabold bg-[#F3F4F6] text-[#374151] group-hover:bg-[#FAD9DA] group-hover:text-[#9e1f16] transition-colors"
                                    >
                                        {{ getKode(item) }}
                                    </span>

                                    <!-- Nama -->
                                    <span
                                        class="flex-1 text-[14px] font-medium text-[#1A1B18] group-hover:text-[#9e1f16] transition-colors"
                                    >
                                        {{ item.nama }}
                                    </span>
                                </div>

                                <!-- Empty state -->
                                <div
                                    v-if="filteredChildren.length === 0"
                                    class="px-6 py-16 flex flex-col items-center gap-3 text-center"
                                >
                                    <svg
                                        class="h-10 w-10 text-[#D1D5DB]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                    <p
                                        class="text-[14px] font-medium text-[#686964]"
                                    >
                                        Tidak ada data ditemukan
                                    </p>
                                    <p class="text-[13px] text-[#9CA3AF]">
                                        Coba gunakan kata kunci lain
                                    </p>
                                </div>
                            </div>
                        </template>

                        <!-- ═══════ DETAIL: Active Node ═════════════════════ -->
                        <template v-if="!isRoot && activeNode">
                            <!-- ── Header Node ─────────────────────────── -->
                            <div
                                class="flex items-center gap-0 border-b border-[#E5E7EB]"
                            >
                                <div
                                    class="flex items-center justify-center bg-[#9e1f16] px-5 py-5 min-w-[72px]"
                                >
                                    <span
                                        class="text-[15px] font-extrabold text-white text-center"
                                        >{{ getKode(activeNode) }}</span
                                    >
                                </div>
                                <div class="flex-1 px-5 py-4">
                                    <h2
                                        class="text-[15px] font-bold text-[#1A1B18] leading-[22px]"
                                    >
                                        {{ activeNode.nama }}
                                    </h2>
                                </div>
                            </div>

                            <!-- ── URAIAN ──────────────────────────────── -->
                            <div class="px-6 py-5 border-b border-[#F3F4F6]">
                                <h3
                                    class="text-[11px] font-bold text-[#9CA3AF] uppercase tracking-widest mb-2"
                                >
                                    Uraian
                                </h3>
                                <p
                                    class="text-[13px] leading-[22px] text-[#374151]"
                                >
                                    {{ getDesc(activeNode) }}
                                </p>
                            </div>

                            <!-- ── SEBELUMNYA ──────────────────────────── -->
                            <div
                                v-if="ancestors.length > 0"
                                :class="[
                                    'px-6 py-5',
                                    !isLeaf
                                        ? 'border-b border-[#F3F4F6]'
                                        : 'px-6 py-5',
                                ]"
                            >
                                <h3
                                    class="text-[11px] font-bold text-[#9CA3AF] uppercase tracking-widest mb-3"
                                >
                                    Sebelumnya
                                </h3>
                                <div class="flex flex-col gap-2">
                                    <div
                                        v-for="(anc, idx) in ancestors"
                                        :key="idx"
                                        class="flex items-center gap-3 px-4 py-3 rounded-xl border border-[#E5E7EB] bg-white hover:border-[#9e1f16]/30 hover:bg-[#FEF9F9] cursor-pointer transition-all group"
                                        @click="goToAncestor(idx)"
                                    >
                                        <span
                                            class="flex-shrink-0 inline-flex items-center justify-center rounded-lg px-2.5 py-1 text-[12px] font-extrabold min-w-[40px] text-center bg-[#F3F4F6] text-[#374151] group-hover:bg-[#FAD9DA] group-hover:text-[#9e1f16] transition-colors"
                                        >
                                            {{ getKode(anc) }}
                                        </span>
                                        <span
                                            class="flex-1 text-[13px] font-medium text-[#374151] group-hover:text-[#9e1f16] transition-colors truncate"
                                        >
                                            {{ anc.nama }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- ── TURUNAN ─────────────────────────────── -->
                            <div v-if="!isLeaf" class="px-6 py-5">
                                <h3
                                    class="text-[11px] font-bold text-[#9CA3AF] uppercase tracking-widest mb-3"
                                >
                                    Turunan
                                </h3>
                                <div class="flex flex-col gap-2">
                                    <div
                                        v-for="(item, i) in filteredChildren"
                                        :key="i"
                                        class="flex items-center gap-3 px-4 py-3 rounded-xl border border-[#E5E7EB] transition-all group cursor-pointer hover:border-[#9e1f16]/30 hover:bg-[#FEF9F9]"
                                        @click="drillDown(item)"
                                    >
                                        <span
                                            class="flex-shrink-0 inline-flex items-center justify-center rounded-lg px-2.5 py-1 text-[12px] font-extrabold min-w-[48px] text-center bg-[#F3F4F6] text-[#374151] group-hover:bg-[#FAD9DA] group-hover:text-[#9e1f16] transition-colors"
                                        >
                                            {{ getKode(item) }}
                                        </span>
                                        <span
                                            class="flex-1 text-[13px] font-medium text-[#374151] group-hover:text-[#9e1f16] transition-colors"
                                        >
                                            {{ item.nama }}
                                        </span>
                                    </div>

                                    <!-- Empty state -->
                                    <div
                                        v-if="filteredChildren.length === 0"
                                        class="py-12 flex flex-col items-center gap-3 text-center"
                                    >
                                        <svg
                                            class="h-10 w-10 text-[#D1D5DB]"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                        <p class="text-[13px] text-[#686964]">
                                            Tidak ada data ditemukan
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- ── Tombol Kembali ──────────────────────── -->
                            <div class="px-6 pb-6">
                                <button
                                    @click="goBack"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg border border-[#9e1f16] text-[#9e1f16] text-[13px] font-semibold hover:bg-[#FEF9F9] transition-all"
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
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18"
                                        />
                                    </svg>
                                    Kembali ya
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- ── Footer CTA ──────────────────────────────────────────── -->
                <div
                    class="relative overflow-hidden rounded-2xl bg-[#9e1f16] px-6 py-12 sm:px-10 sm:py-14"
                >
                    <img
                        src="/icons/ft-docs.svg"
                        alt=""
                        class="absolute right-6 top-6 h-16 w-16 opacity-20 sm:right-10 sm:top-8 sm:h-24 sm:w-24"
                    />
                    <div
                        class="relative flex flex-col items-center text-center"
                    >
                        <h3
                            class="max-w-2xl text-[22px] font-bold leading-[32px] text-white sm:text-[28px] sm:leading-[38px]"
                        >
                            Tidak Menemukan KBLI yang Anda Cari?
                        </h3>
                        <p
                            class="mt-4 max-w-lg text-[14px] leading-[22px] text-white/80 sm:text-[16px] sm:leading-[24px]"
                        >
                            Tim kami siap membantu Anda menemukan solusi yang
                            tepat<br class="hidden sm:block" />
                            untuk kebutuhan legalitas bisnis Anda.
                        </p>
                        <a
                            :href="buildWhatsappLink()"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-8 inline-flex items-center gap-2.5 rounded-lg bg-[#25D366] px-6 py-3 text-[14px] font-semibold text-white shadow-lg shadow-[#25D366]/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#20BD5A] sm:px-8 sm:py-3.5 sm:text-[15px]"
                        >
                            Chat Langsung via WhatsApp
                            <img
                                src="/icons/ft-wa.svg"
                                alt="WhatsApp"
                                class="h-5 w-5"
                            />
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
