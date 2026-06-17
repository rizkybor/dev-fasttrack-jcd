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

// ─── Global Flat Search (dropdown autocomplete) ───────────────────────────────
const searchQuery    = ref("");
const showDropdown   = ref(false);
const searchInputRef = ref(null);

const flattenNodes = (nodes, ancestors = []) => {
    const result = [];
    for (const node of nodes) {
        result.push({ node, ancestors: [...ancestors] });
        if (node.children?.length) {
            result.push(...flattenNodes(node.children, [...ancestors, node]));
        }
    }
    return result;
};

const allNodes = computed(() => flattenNodes(data.value));

const getKode     = (node) => node.kategori ?? node.nomor_kbli ?? "";
const hasChildren = (node) => node.children && node.children.length > 0;
const getDesc     = (node) => node.description ?? node.deskripsi ?? "";

// Memotong bagian "tidak mencakup ..." dari deskripsi supaya kata kunci yang
// hanya muncul di teks pengecualian (cross-reference ke kode lain) tidak
// membuat node tersebut salah dianggap relevan saat dicari.
const stripExclusions = (desc) => {
    if (!desc) return "";
    const idx = desc.search(/tidak mencakup/i);
    return idx === -1 ? desc : desc.slice(0, idx);
};

// Node dianggap "placeholder" / sisa data rusak dari parsing PDF (misal nama
// hanya "[0220]" atau "16", deskripsi kosong) — node ini sebaiknya tidak
// muncul sebagai hasil pencarian karena tidak informatif buat pengguna.
const isPlaceholderNode = (node) => {
    const nama = (node.nama ?? "").trim();
    const desc = (node.description ?? node.deskripsi ?? "").trim();
    if (/^\[\d+\]$/.test(nama)) return true;
    if (!nama || /^\d+$/.test(nama)) return true;
    if (!desc && hasChildren(node)) return true;
    return false;
};

const searchResults = computed(() => {
    const q = searchQuery.value.trim().toLowerCase();
    if (!q || q.length < 2) return [];

    const scored = [];

    for (const { node, ancestors: ancs } of allNodes.value) {
        const kode = getKode(node);
        // Hanya tampilkan node dengan kode KBLI (2–5 digit angka) atau kategori (1 huruf)
        if (!/^\d{2,5}$/.test(kode)) continue;
        if (isPlaceholderNode(node)) continue;

        const kodeLower = kode.toLowerCase();
        const nama = (node.nama ?? "").toLowerCase();
        const descFull = (node.description ?? node.deskripsi ?? "").toLowerCase();
        const descRelevant = stripExclusions(descFull);

        let score = 0;
        if (kodeLower === q) score = 100;
        else if (kodeLower.startsWith(q)) score = 90;
        else if (nama.startsWith(q)) score = 80;
        else if (nama.includes(q)) score = 60;
        else if (descRelevant.includes(q)) score = 30;
        // Kata yang hanya ditemukan di bagian "tidak mencakup" tetap diberi skor
        // rendah (bukan dibuang total) agar pencarian istilah jarang masih terbantu,
        // tapi akan selalu kalah ranking dari match yang lebih relevan.
        else if (descFull.includes(q)) score = 5;

        if (score > 0) scored.push({ node, ancestors: ancs, score });
    }

    return scored
        .sort((a, b) => b.score - a.score)
        .slice(0, 8);
});

const onSearchInput = () => {
    showDropdown.value = searchQuery.value.trim().length >= 2;
};

const selectResult = ({ node, ancestors }) => {
    navigationStack.value = [];
    activeNode.value = null;

    for (const anc of ancestors) {
        if (activeNode.value) navigationStack.value.push(activeNode.value);
        activeNode.value = anc;
    }
    if (activeNode.value) navigationStack.value.push(activeNode.value);
    activeNode.value = node;

    searchQuery.value  = "";
    showDropdown.value = false;
    globalSearch.value = "";
};

const clearSearch = () => {
    searchQuery.value  = "";
    showDropdown.value = false;
};

const onClickOutside = () => {
    showDropdown.value = false;
};

// ─── Click outside directive ──────────────────────────────────────────────────
const vClickOutside = {
    mounted(el, binding) {
        el._clickOutside = (e) => {
            if (!el.contains(e.target)) binding.value(e);
        };
        document.addEventListener("mousedown", el._clickOutside);
    },
    unmounted(el) {
        document.removeEventListener("mousedown", el._clickOutside);
    },
};

// ─── Navigation stack ─────────────────────────────────────────────────────────
const navigationStack = ref([]);
const activeNode      = ref(null);

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
    const target = navigationStack.value[idx];
    navigationStack.value = navigationStack.value.slice(0, idx);
    activeNode.value = target;
    globalSearch.value = "";
};

const isRoot = computed(() => !activeNode.value);
const isLeaf = computed(() => activeNode.value && !hasChildren(activeNode.value));
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
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
                <div class="grid items-center gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16">
                    <!-- Left: Text content -->
                    <div class="relative z-10">
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
                        <h1 class="text-2xl font-extrabold leading-tight text-white sm:text-4xl lg:text-4xl">
                            Klasifikasi Buku Lapangan Usaha<br />Indonesia (KBLI) 2025
                        </h1>
                        <p class="mt-5 text-[15px] leading-relaxed text-white/80 max-w-lg">
                            Temukan kode KBLI yang tepat untuk bidang usaha Anda berdasarkan data terbaru.
                        </p>
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
                    <!-- Right: Book image -->
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
                <div class="rounded-2xl border border-[#E5E7EB] bg-white shadow-sm overflow-hidden">

                    <!-- ── Card Header ────────────────────────────────────── -->
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-[#E5E7EB]">
                        <img
                            src="/icons/ft-docs.svg"
                            alt=""
                            class="h-8 w-8 text-[#9e1f16]"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                        />
                        <span class="text-[15px] font-bold text-[#1A1B18]">
                            {{ isRoot ? "KBLI 2025" : "Detail KBLI 2025" }}
                        </span>
                    </div>

                    <!-- ── Search Bar ─────────────────────────────────────── -->
                    <div class="px-6 py-4 border-b border-[#E5E7EB]">
                        <div class="relative" v-click-outside="onClickOutside">
                            <!-- Search icon -->
                            <svg
                                class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[#9CA3AF] pointer-events-none z-10"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>

                            <!-- Input -->
                            <input
                                ref="searchInputRef"
                                v-model="searchQuery"
                                type="text"
                                placeholder="Cari Kode KBLI atau Nama Kegiatan"
                                class="w-full pl-10 pr-10 py-2.5 text-[13px] border border-[#E5E7EB] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#9e1f16]/20 focus:border-[#9e1f16] placeholder-[#9CA3AF] bg-white transition-all"
                                @input="onSearchInput"
                                @focus="onSearchInput"
                            />

                            <!-- Clear button -->
                            <button
                                v-if="searchQuery"
                                type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#9CA3AF] hover:text-[#374151] transition-colors"
                                @click="clearSearch"
                            >
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- ── Dropdown Results ────────────────────────── -->
                            <transition
                                enter-active-class="transition duration-150 ease-out"
                                enter-from-class="opacity-0 translate-y-1"
                                enter-to-class="opacity-100 translate-y-0"
                                leave-active-class="transition duration-100 ease-in"
                                leave-from-class="opacity-100 translate-y-0"
                                leave-to-class="opacity-0 translate-y-1"
                            >
                                <div
                                    v-if="showDropdown"
                                    class="absolute left-0 right-0 top-[calc(100%+6px)] z-50 bg-white border border-[#E5E7EB] rounded-xl shadow-lg overflow-hidden"
                                >
                                    <!-- Count -->
                                    <div class="px-4 py-2.5 border-b border-[#F3F4F6] bg-[#FAFAFA]">
                                        <span class="text-[12px] text-[#9CA3AF]">
                                            {{
                                                searchResults.length > 0
                                                    ? `${searchResults.length} hasil ditemukan`
                                                    : "Tidak ada hasil ditemukan"
                                            }}
                                        </span>
                                    </div>

                                    <!-- Results -->
                                    <div class="max-h-[320px] overflow-y-auto overscroll-contain divide-y divide-[#F9FAFB]">
                                        <button
                                            v-for="({ node, ancestors: ancs }, i) in searchResults"
                                            :key="i"
                                            type="button"
                                            class="w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-[#FEF9F9] transition-colors group"
                                            @click="selectResult({ node, ancestors: ancs })"
                                        >
                                            <!-- Icon -->
                                            <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-[#F3F4F6] group-hover:bg-[#FAD9DA] transition-colors">
                                                <svg
                                                    class="w-4 h-4 text-[#9CA3AF] group-hover:text-[#9e1f16] transition-colors"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"
                                                >
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </span>

                                            <!-- Text -->
                                            <div class="flex-1 min-w-0">
                                                <p class="text-[13px] font-semibold text-[#1A1B18] group-hover:text-[#9e1f16] transition-colors">
                                                    {{ getKode(node) }} - {{ node.nama }}
                                                </p>
                                                <p v-if="ancs.length" class="mt-0.5 text-[11px] text-[#9CA3AF] truncate">
                                                    {{ ancs.map((a) => a.nama).join(" › ") }}
                                                </p>
                                            </div>
                                        </button>

                                        <!-- Empty state -->
                                        <div
                                            v-if="searchResults.length === 0"
                                            class="px-4 py-8 flex flex-col items-center gap-2 text-center"
                                        >
                                            <svg class="h-8 w-8 text-[#D1D5DB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-[13px] text-[#686964]">Tidak ada hasil ditemukan</p>
                                            <p class="text-[12px] text-[#9CA3AF]">Coba gunakan kata kunci lain</p>
                                        </div>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </div>

                    <!-- ── Loading ─────────────────────────────────────────── -->
                    <div v-if="isLoading" class="px-6 py-16 flex flex-col items-center gap-3">
                        <div class="w-7 h-7 border-2 border-[#9e1f16] border-t-transparent rounded-full animate-spin"></div>
                        <p class="text-[13px] text-[#686964]">Memuat data KBLI...</p>
                    </div>

                    <!-- ── Content ─────────────────────────────────────────── -->
                    <div v-if="!isLoading">

                        <!-- ═══════ ROOT: Daftar Kategori ══════════════════ -->
                        <template v-if="isRoot">
                            <div class="px-6 py-5 border-b border-[#F3F4F6]">
                                <p class="text-[13px] leading-[22px] text-[#374151]">
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
                                <p class="mt-3 text-[13px] leading-[22px] text-[#374151]">
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

                            <div class="divide-y divide-[#F3F4F6]">
                                <div
                                    v-for="(item, i) in filteredChildren"
                                    :key="i"
                                    :class="[
                                        'flex items-center gap-4 px-6 py-4 transition-all group',
                                        hasChildren(item) ? 'cursor-pointer hover:bg-[#FEF9F9]' : 'cursor-default',
                                    ]"
                                    @click="drillDown(item)"
                                >
                                    <span class="flex-shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-lg text-[13px] font-extrabold bg-[#F3F4F6] text-[#374151] group-hover:bg-[#FAD9DA] group-hover:text-[#9e1f16] transition-colors">
                                        {{ getKode(item) }}
                                    </span>
                                    <span class="flex-1 text-[14px] font-medium text-[#1A1B18] group-hover:text-[#9e1f16] transition-colors">
                                        {{ item.nama }}
                                    </span>
                                </div>

                                <div v-if="filteredChildren.length === 0" class="px-6 py-16 flex flex-col items-center gap-3 text-center">
                                    <svg class="h-10 w-10 text-[#D1D5DB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-[14px] font-medium text-[#686964]">Tidak ada data ditemukan</p>
                                    <p class="text-[13px] text-[#9CA3AF]">Coba gunakan kata kunci lain</p>
                                </div>
                            </div>
                        </template>

                        <!-- ═══════ DETAIL: Active Node ════════════════════ -->
                        <template v-if="!isRoot && activeNode">
                            <!-- Header Node -->
                            <div class="flex items-center gap-0 border-b border-[#E5E7EB]">
                                <div class="flex items-center justify-center bg-[#9e1f16] px-5 py-5 min-w-[72px]">
                                    <span class="text-[15px] font-extrabold text-white text-center">
                                        {{ getKode(activeNode) }}
                                    </span>
                                </div>
                                <div class="flex-1 px-5 py-4">
                                    <h2 class="text-[15px] font-bold text-[#1A1B18] leading-[22px]">
                                        {{ activeNode.nama }}
                                    </h2>
                                </div>
                            </div>

                            <!-- Uraian -->
                            <div class="px-6 py-5 border-b border-[#F3F4F6]">
                                <h3 class="text-[11px] font-bold text-[#9CA3AF] uppercase tracking-widest mb-2">Uraian</h3>
                                <p class="text-[13px] leading-[22px] text-[#374151]">{{ getDesc(activeNode) }}</p>
                            </div>

                            <!-- Sebelumnya -->
                            <div
                                v-if="ancestors.length > 0"
                                :class="['px-6 py-5', !isLeaf ? 'border-b border-[#F3F4F6]' : '']"
                            >
                                <h3 class="text-[11px] font-bold text-[#9CA3AF] uppercase tracking-widest mb-3">Sebelumnya</h3>
                                <div class="flex flex-col gap-2">
                                    <div
                                        v-for="(anc, idx) in ancestors"
                                        :key="idx"
                                        class="flex items-center gap-3 px-4 py-3 rounded-xl border border-[#E5E7EB] bg-white hover:border-[#9e1f16]/30 hover:bg-[#FEF9F9] cursor-pointer transition-all group"
                                        @click="goToAncestor(idx)"
                                    >
                                        <span class="flex-shrink-0 inline-flex items-center justify-center rounded-lg px-2.5 py-1 text-[12px] font-extrabold min-w-[40px] text-center bg-[#F3F4F6] text-[#374151] group-hover:bg-[#FAD9DA] group-hover:text-[#9e1f16] transition-colors">
                                            {{ getKode(anc) }}
                                        </span>
                                        <span class="flex-1 text-[13px] font-medium text-[#374151] group-hover:text-[#9e1f16] transition-colors truncate">
                                            {{ anc.nama }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Turunan -->
                            <div v-if="!isLeaf" class="px-6 py-5">
                                <h3 class="text-[11px] font-bold text-[#9CA3AF] uppercase tracking-widest mb-3">Turunan</h3>
                                <div class="flex flex-col gap-2">
                                    <div
                                        v-for="(item, i) in filteredChildren"
                                        :key="i"
                                        class="flex items-center gap-3 px-4 py-3 rounded-xl border border-[#E5E7EB] transition-all group cursor-pointer hover:border-[#9e1f16]/30 hover:bg-[#FEF9F9]"
                                        @click="drillDown(item)"
                                    >
                                        <span class="flex-shrink-0 inline-flex items-center justify-center rounded-lg px-2.5 py-1 text-[12px] font-extrabold min-w-[48px] text-center bg-[#F3F4F6] text-[#374151] group-hover:bg-[#FAD9DA] group-hover:text-[#9e1f16] transition-colors">
                                            {{ getKode(item) }}
                                        </span>
                                        <span class="flex-1 text-[13px] font-medium text-[#374151] group-hover:text-[#9e1f16] transition-colors">
                                            {{ item.nama }}
                                        </span>
                                    </div>

                                    <div v-if="filteredChildren.length === 0" class="py-12 flex flex-col items-center gap-3 text-center">
                                        <svg class="h-10 w-10 text-[#D1D5DB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-[13px] text-[#686964]">Tidak ada data ditemukan</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Kembali -->
                            <div class="px-6 pb-6">
                                <button
                                    @click="goBack"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg border border-[#9e1f16] text-[#9e1f16] text-[13px] font-semibold hover:bg-[#FEF9F9] transition-all"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Kembali
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- ── Footer CTA ──────────────────────────────────────────── -->
                <div class="relative overflow-hidden rounded-2xl bg-[#9e1f16] px-6 py-12 sm:px-10 sm:py-14">
                    <img
                        src="/icons/ft-docs.svg"
                        alt=""
                        class="absolute right-6 top-6 h-16 w-16 opacity-20 sm:right-10 sm:top-8 sm:h-24 sm:w-24"
                    />
                    <div class="relative flex flex-col items-center text-center">
                        <h3 class="max-w-2xl text-[22px] font-bold leading-[32px] text-white sm:text-[28px] sm:leading-[38px]">
                            Tidak Menemukan KBLI yang Anda Cari?
                        </h3>
                        <p class="mt-4 max-w-lg text-[14px] leading-[22px] text-white/80 sm:text-[16px] sm:leading-[24px]">
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
                            <img src="/icons/ft-wa.svg" alt="WhatsApp" class="h-5 w-5" />
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