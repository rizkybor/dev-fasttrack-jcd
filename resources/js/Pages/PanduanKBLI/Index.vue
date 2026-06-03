<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref, computed, onMounted } from "vue";

/**
 * Props: array of KBLI data dengan struktur hierarki:
 *
 * [
 *   {
 *     kategori: "A",
 *     nama: "PERTANIAN, KEHUTANAN, DAN PERIKANAN",
 *     description: "...",
 *     children: [                          // Golongan Pokok
 *       {
 *         nomor_kbli: "01",
 *         nama: "...",
 *         description: "...",
 *         type_kbli: "Golongan Pokok",
 *         children: [                      // Golongan
 *           {
 *             nomor_kbli: "011",
 *             nama: "...",
 *             description: "...",
 *             type_kbli: "Golongan",
 *             children: [                  // Subgolongan
 *               {
 *                 nomor_kbli: "0111",
 *                 nama: "...",
 *                 description: "...",
 *                 type_kbli: "Subgolongan",
 *                 children: [              // Kelompok
 *                   {
 *                     nomor_kbli: "01111",
 *                     nama: "...",
 *                     description: "...",
 *                     type_kbli: "Kelompok",
 *                     children: []
 *                   }
 *                 ]
 *               }
 *             ]
 *           }
 *         ]
 *       }
 *     ]
 *   }
 * ]
 */
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

// ─── Dummy data (dipakai jika props kosong) ───────────────────────────────────
const dummyData = [
    {
        kategori: "A",
        nama: "PERTANIAN, KEHUTANAN, DAN PERIKANAN",
        description: "Pemanenan, dan kegiatan pascapanen yang dilakukan sebagai satu rangkaian kegiatan.",
        children: [
            {
                nomor_kbli: "01",
                nama: "PERTANIAN TANAMAN, PETERNAKAN, PERBURUAN, DAN KEGIATAN JASA TERKAIT",
                description: "Golongan pokok ini mencakup dua kegiatan dasar yakni produksi tanaman dan hewan.",
                type_kbli: "Golongan Pokok",
                children: [
                    {
                        nomor_kbli: "011",
                        nama: "PERTANIAN TANAMAN SEMUSIM",
                        description: "Golongan ini mencakup kegiatan penanaman tanaman yang berlangsung tidak lebih dari dua musim panen.",
                        type_kbli: "Golongan",
                        children: [
                            {
                                nomor_kbli: "0111",
                                nama: "PERTANIAN SEREALIA (BUKAN PADI), ANEKA KACANG, DAN BIJI-BIJIAN",
                                description: "Subgolongan ini mencakup semua jenis pertanian tanaman serealia, aneka kacang, dan biji-bijian.",
                                type_kbli: "Subgolongan",
                                children: [
                                    {
                                        nomor_kbli: "01111",
                                        nama: "PERTANIAN JAGUNG",
                                        description: "Kelompok ini mencakup kegiatan pertanian jagung, termasuk di dalamnya kegiatan pengolahan lahan, penanaman, pemeliharaan, panen, dan pasca panen jagung untuk menghasilkan benih berupa biji. Kelompok ini tidak mencakup pertanian jagung manis, lihat kelompok 01133.",
                                        type_kbli: "Kelompok",
                                        children: [],
                                    },
                                    {
                                        nomor_kbli: "01112",
                                        nama: "PERTANIAN SEREALIA SELAIN PADI DAN JAGUNG",
                                        description: "Kelompok ini mencakup kegiatan pertanian serealia selain padi dan jagung, seperti gandum, sorgum/cantel, barli.",
                                        type_kbli: "Kelompok",
                                        children: [],
                                    },
                                    {
                                        nomor_kbli: "01113",
                                        nama: "PERTANIAN KEDELAI",
                                        description: "Kelompok ini mencakup kegiatan pertanian kedelai, termasuk di dalamnya kegiatan pengolahan lahan, penanaman, pemeliharaan.",
                                        type_kbli: "Kelompok",
                                        children: [],
                                    },
                                    {
                                        nomor_kbli: "01114",
                                        nama: "PERTANIAN KACANG TANAH",
                                        description: "Kelompok ini mencakup kegiatan pertanian kacang tanah, termasuk di dalamnya kegiatan pengolahan lahan.",
                                        type_kbli: "Kelompok",
                                        children: [],
                                    },
                                ],
                            },
                            {
                                nomor_kbli: "0112",
                                nama: "PERTANIAN PADI",
                                description: "Subgolongan ini mencakup pertanian padi, termasuk benih padi.",
                                type_kbli: "Subgolongan",
                                children: [
                                    {
                                        nomor_kbli: "01120",
                                        nama: "PERTANIAN PADI",
                                        description: "Kelompok ini mencakup kegiatan pertanian padi termasuk pengolahan lahan, penanaman, pemeliharaan, dan pemanenan.",
                                        type_kbli: "Kelompok",
                                        children: [],
                                    },
                                ],
                            },
                        ],
                    },
                    {
                        nomor_kbli: "012",
                        nama: "PERTANIAN TANAMAN HORTIKULTURA",
                        description: "Golongan ini mencakup kegiatan pertanian tanaman hortikultura.",
                        type_kbli: "Golongan",
                        children: [
                            {
                                nomor_kbli: "0121",
                                nama: "PERTANIAN ANEKA BUAH MENGANDUNG MINYAK",
                                description: "Subgolongan ini mencakup pertanian buah-buahan penghasil minyak.",
                                type_kbli: "Subgolongan",
                                children: [
                                    {
                                        nomor_kbli: "01211",
                                        nama: "PERTANIAN KELAPA SAWIT",
                                        description: "Kelompok ini mencakup kegiatan pertanian kelapa sawit.",
                                        type_kbli: "Kelompok",
                                        children: [],
                                    },
                                ],
                            },
                        ],
                    },
                ],
            },
            {
                nomor_kbli: "02",
                nama: "KEHUTANAN DAN PENEBANGAN KAYU",
                description: "Golongan pokok ini mencakup produksi kayu bundar dan hasil hutan lainnya.",
                type_kbli: "Golongan Pokok",
                children: [
                    {
                        nomor_kbli: "021",
                        nama: "KEHUTANAN",
                        description: "Golongan ini mencakup produksi kayu dan hasil hutan.",
                        type_kbli: "Golongan",
                        children: [
                            {
                                nomor_kbli: "0210",
                                nama: "KEHUTANAN",
                                description: "Subgolongan ini mencakup pengelolaan hutan dan pemanenan kayu.",
                                type_kbli: "Subgolongan",
                                children: [
                                    {
                                        nomor_kbli: "02100",
                                        nama: "KEHUTANAN",
                                        description: "Kelompok ini mencakup kegiatan usaha kehutanan dan penebangan kayu.",
                                        type_kbli: "Kelompok",
                                        children: [],
                                    },
                                ],
                            },
                        ],
                    },
                ],
            },
        ],
    },
    {
        kategori: "B",
        nama: "PERTAMBANGAN DAN PENGGALIAN",
        description: "Kategori ini mencakup kegiatan ekonomi/lapangan usaha di bidang pertambangan.",
        children: [
            {
                nomor_kbli: "05",
                nama: "PERTAMBANGAN BATUBARA DAN LIGNIT",
                description: "Golongan pokok ini mencakup pertambangan batubara dan lignit.",
                type_kbli: "Golongan Pokok",
                children: [
                    {
                        nomor_kbli: "051",
                        nama: "PERTAMBANGAN BATUBARA",
                        description: "Golongan ini mencakup pertambangan batubara.",
                        type_kbli: "Golongan",
                        children: [
                            {
                                nomor_kbli: "0510",
                                nama: "PERTAMBANGAN BATUBARA",
                                description: "Subgolongan ini mencakup pertambangan batubara.",
                                type_kbli: "Subgolongan",
                                children: [
                                    {
                                        nomor_kbli: "05100",
                                        nama: "PERTAMBANGAN BATUBARA",
                                        description: "Kelompok ini mencakup kegiatan pertambangan batubara.",
                                        type_kbli: "Kelompok",
                                        children: [],
                                    },
                                ],
                            },
                        ],
                    },
                ],
            },
        ],
    },
];

const fetchedData = ref([]);
const isLoading = ref(false);

onMounted(async () => {
    if (!props.kbliData.length) {
        isLoading.value = true;
        try {
            const res = await fetch('/data/kbli2025.json');
            if (res.ok) {
                fetchedData.value = await res.json();
            }
        } catch (e) {
            console.error('Gagal memuat data KBLI:', e);
        } finally {
            isLoading.value = false;
        }
    }
});

const data = computed(() => {
    if (props.kbliData.length) return props.kbliData;
    if (fetchedData.value.length) return fetchedData.value;
    return dummyData;
});

// ─── Search global ────────────────────────────────────────────────────────────
const globalSearch = ref("");

// ─── Navigasi hierarki (breadcrumb stack) ────────────────────────────────────
// Stack berisi objek { label, node }
// node = null  → tampilkan daftar Kategori
// node = { kategori, ... } → tampilkan children (Golongan Pokok)
// node = { nomor_kbli, type_kbli, ... } → tampilkan children-nya
const breadcrumbs = ref([]); // [{ label, node }]

// Node yang sedang aktif (null = root / daftar Kategori)
const activeNode = ref(null);

// Anak-anak yang sedang ditampilkan
const currentChildren = computed(() => {
    if (!activeNode.value) return data.value; // daftar Kategori
    return activeNode.value.children ?? [];
});

// Level saat ini
const currentLevel = computed(() => {
    if (!activeNode.value) return "Kategori";
    if ("kategori" in activeNode.value) return "Golongan Pokok";
    const map = {
        "Golongan Pokok": "Golongan",
        "Golongan": "Subgolongan",
        "Subgolongan": "Kelompok",
        "Kelompok": "Detail",
    };
    return map[activeNode.value.type_kbli] ?? "Detail";
});

const levelColors = {
    Kategori: { bg: "bg-[#FAD9DA]", text: "text-[#E63946]", border: "border-[#F5A8AE]" },
    "Golongan Pokok": { bg: "bg-[#FEF3C7]", text: "text-[#D97706]", border: "border-[#FDE68A]" },
    Golongan: { bg: "bg-[#D1FAE5]", text: "text-[#059669]", border: "border-[#A7F3D0]" },
    Subgolongan: { bg: "bg-[#DBEAFE]", text: "text-[#2563EB]", border: "border-[#BFDBFE]" },
    Kelompok: { bg: "bg-[#EDE9FE]", text: "text-[#7C3AED]", border: "border-[#DDD6FE]" },
};

const getLevelColor = (level) => levelColors[level] ?? levelColors["Kategori"];

// Drill-down: masuk ke node
const drillDown = (node) => {
    const hasChildren = node.children && node.children.length > 0;
    if (!hasChildren) return; // Kelompok leaf — tidak bisa masuk lebih dalam

    const label = node.kategori
        ? `${node.kategori} — ${node.nama}`
        : `${node.nomor_kbli} — ${node.nama}`;

    breadcrumbs.value.push({ label, node: activeNode.value });
    activeNode.value = node;
    globalSearch.value = "";
};

// Breadcrumb: kembali ke level tertentu
const goToBreadcrumb = (idx) => {
    // idx = -1 → root
    if (idx === -1) {
        breadcrumbs.value = [];
        activeNode.value = null;
    } else {
        const crumb = breadcrumbs.value[idx];
        breadcrumbs.value = breadcrumbs.value.slice(0, idx);
        activeNode.value = crumb.node;
    }
    globalSearch.value = "";
};

// ─── Filter + search pada currentChildren ────────────────────────────────────
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

// Helper: ambil kode tampil
const getKode = (node) => node.kategori ?? node.nomor_kbli ?? "";
const hasChildren = (node) => node.children && node.children.length > 0;

// Label level badge untuk setiap anak
const childLevel = computed(() => {
    if (!activeNode.value) return "Golongan Pokok"; // anak Kategori adalah Golongan Pokok
    const map = {
        "Golongan Pokok": "Golongan",
        "Golongan": "Subgolongan",
        "Subgolongan": "Kelompok",
    };
    if ("kategori" in activeNode.value) return "Golongan Pokok";
    return map[activeNode.value.type_kbli] ?? "Kelompok";
});
</script>

<template>
    <MainLayout>
        <!-- ── Hero ──────────────────────────────────────────────────────── -->
        <section class="relative overflow-hidden min-h-[280px] sm:min-h-[320px]">
            <div class="absolute inset-0">
                <img
                    src="/images/layanan-badan-usaha/ft-hero-badan-usaha.png"
                    alt="Hero background"
                    class="h-full w-full object-cover object-center"
                />
                <div class="absolute inset-0 bg-black/40"></div>
            </div>
            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14 flex flex-col justify-between h-full min-h-[280px] sm:min-h-[320px]">
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb">
                    <div class="inline-flex items-center gap-2 rounded-md bg-white px-4 py-2">
                        <a href="/" class="text-[#E63946] hover:text-black transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
                            </svg>
                        </a>
                        <svg class="h-3 w-3 text-[#E63946]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="/layanan" class="text-sm font-medium text-[#E63946] hover:underline">Layanan</a>
                        <svg class="h-3 w-3 text-[#E63946]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-sm font-medium text-[#E63946]">Panduan KBLI</span>
                    </div>
                </nav>

                <!-- Heading -->
                <div class="mt-auto pt-8">
                    <h1 class="text-2xl font-extrabold leading-tight text-white sm:text-3xl lg:text-4xl">
                        Panduan KBLI<br class="hidden sm:block" />
                        <span class="text-white/90">Klasifikasi Baku Lapangan Usaha Indonesia</span>
                    </h1>
                    <p class="mt-4 max-w-xl text-sm leading-relaxed text-white/80 sm:text-base sm:leading-7">
                        Jelajahi kode KBLI secara bertahap — mulai dari Kategori, Golongan Pokok, Golongan, Subgolongan, hingga Kelompok usaha yang sesuai.
                    </p>
                    <div class="mt-6">
                        <a href="/layanan" class="inline-flex items-center gap-2 text-sm font-medium text-white hover:text-white/70 transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── Main Content ──────────────────────────────────────────────── -->
        <section class="py-[52px]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col gap-6">

                <!-- ── Level Indicator + Breadcrumb Trail ──────────────── -->
                <div class="flex flex-col gap-3">
                    <!-- Level steps indicator -->
                    <div class="flex items-center gap-1 overflow-x-auto pb-1 flex-wrap">
                        <template v-for="(step, idx) in ['Kategori', 'Golongan Pokok', 'Golongan', 'Subgolongan', 'Kelompok']" :key="step">
                            <span
                                :class="[
                                    'flex-shrink-0 px-3 py-1 rounded-full text-[12px] font-semibold transition-all',
                                    currentLevel === step || (currentLevel === 'Golongan Pokok' && step === 'Golongan Pokok')
                                        ? getLevelColor(step).bg + ' ' + getLevelColor(step).text
                                        : breadcrumbs.length > idx
                                            ? 'bg-[#F3F4F6] text-[#6B7280] line-through'
                                            : 'bg-[#F9F9F9] text-[#9CA3AF]',
                                ]"
                            >{{ step }}</span>
                            <svg v-if="idx < 4" class="flex-shrink-0 h-3 w-3 text-[#D1D5DB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </template>
                    </div>

                    <!-- Breadcrumb navigation -->
                    <nav class="flex items-center gap-1 flex-wrap text-[13px]">
                        <button
                            @click="goToBreadcrumb(-1)"
                            class="flex items-center gap-1 text-[#E63946] hover:underline font-medium"
                        >
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
                            </svg>
                            Semua Kategori
                        </button>
                        <template v-for="(crumb, idx) in breadcrumbs" :key="idx">
                            <svg class="h-3 w-3 text-[#D1D5DB] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <button
                                @click="goToBreadcrumb(idx)"
                                class="text-[#E63946] hover:underline max-w-[200px] truncate"
                                :title="crumb.label"
                            >
                                {{ crumb.label }}
                            </button>
                        </template>
                        <template v-if="activeNode">
                            <svg class="h-3 w-3 text-[#D1D5DB] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="text-[#686964] max-w-[200px] truncate font-medium">
                                {{ activeNode.kategori ?? activeNode.nomor_kbli }} — {{ activeNode.nama }}
                            </span>
                        </template>
                    </nav>
                </div>

                <!-- ── Card Konten ─────────────────────────────────────── -->
                <div class="rounded-2xl border border-[#D9DAD8] bg-white shadow-sm overflow-hidden">

                    <!-- Header Card: info node aktif -->
                    <div
                        v-if="activeNode"
                        :class="['px-6 py-5 border-b border-[#D9DAD8]', getLevelColor(activeNode.type_kbli ?? 'Kategori').bg]"
                    >
                        <div class="flex items-start gap-3">
                            <span
                                :class="['flex-shrink-0 inline-flex items-center justify-center rounded-lg px-3 py-1 text-[13px] font-extrabold', getLevelColor(activeNode.type_kbli ?? 'Kategori').bg, getLevelColor(activeNode.type_kbli ?? 'Kategori').text]"
                            >
                                {{ getKode(activeNode) }}
                            </span>
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h2 class="text-[16px] font-bold text-[#1A1B18]">{{ activeNode.nama }}</h2>
                                    <span
                                        :class="['text-[11px] font-semibold px-2 py-0.5 rounded-full', getLevelColor(activeNode.type_kbli ?? 'Kategori').bg, getLevelColor(activeNode.type_kbli ?? 'Kategori').text]"
                                    >{{ activeNode.type_kbli ?? "Kategori" }}</span>
                                </div>
                                <p class="text-[13px] leading-[21px] text-[#686964] max-w-3xl">
                                    {{ activeNode.description ?? activeNode.deskripsi }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Search + judul level -->
                    <div class="px-6 py-4 border-b border-[#D9DAD8] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <span
                                :class="['inline-flex items-center px-3 py-1 rounded-full text-[12px] font-semibold', getLevelColor(childLevel).bg, getLevelColor(childLevel).text]"
                            >
                                {{ childLevel }}
                            </span>
                            <span class="text-[13px] text-[#686964]">
                                {{ filteredChildren.length }} item ditemukan
                            </span>
                        </div>
                        <div class="relative w-full sm:w-72">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[#9CA3AF]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input
                                v-model="globalSearch"
                                type="text"
                                placeholder="Cari kode atau nama kegiatan..."
                                class="w-full pl-9 pr-4 py-2 text-[13px] border border-[#D9DAD8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E63946]/30 focus:border-[#E63946] placeholder-[#9CA3AF]"
                            />
                        </div>
                    </div>

                    <!-- Loading state -->
                    <div v-if="isLoading" class="px-6 py-16 flex flex-col items-center gap-3">
                        <div class="w-8 h-8 border-2 border-[#E63946] border-t-transparent rounded-full animate-spin"></div>
                        <p class="text-[13px] text-[#686964]">Memuat data KBLI...</p>
                    </div>

                    <!-- Daftar Item -->
                    <div v-if="!isLoading" class="divide-y divide-[#F3F4F6]">
                        <div
                            v-for="(item, i) in filteredChildren"
                            :key="i"
                            :class="[
                                'flex items-start gap-4 px-6 py-4 transition-all group',
                                hasChildren(item) ? 'cursor-pointer hover:bg-[#FEF9F9]' : 'cursor-default',
                            ]"
                            @click="drillDown(item)"
                        >
                            <!-- Kode badge -->
                            <span
                                :class="[
                                    'flex-shrink-0 inline-flex items-center justify-center rounded-lg px-3 py-1.5 text-[13px] font-extrabold min-w-[60px] text-center',
                                    getLevelColor(childLevel).bg,
                                    getLevelColor(childLevel).text,
                                ]"
                            >
                                {{ getKode(item) }}
                            </span>

                            <!-- Info -->
                            <div class="flex-1 min-w-0 flex flex-col gap-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="text-[14px] font-bold text-[#1A1B18] leading-[21px]">{{ item.nama }}</h4>
                                    <span
                                        v-if="item.type_kbli"
                                        :class="['text-[11px] font-medium px-2 py-0.5 rounded-full border', getLevelColor(item.type_kbli).bg, getLevelColor(item.type_kbli).text, getLevelColor(item.type_kbli).border]"
                                    >{{ item.type_kbli }}</span>
                                </div>
                                <p class="text-[13px] leading-[20px] text-[#686964] line-clamp-2">
                                    {{ item.description ?? item.deskripsi }}
                                </p>
                                <div v-if="hasChildren(item)" class="flex items-center gap-1 mt-1">
                                    <span class="text-[12px] text-[#9CA3AF]">{{ item.children.length }} sub-item</span>
                                </div>
                            </div>

                            <!-- Arrow: hanya jika ada children -->
                            <div
                                v-if="hasChildren(item)"
                                class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-[#F9F9F9] group-hover:bg-[#FAD9DA] transition-colors mt-0.5"
                            >
                                <svg class="h-4 w-4 text-[#686964] group-hover:text-[#E63946] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>

                            <!-- Leaf badge -->
                            <div
                                v-else
                                class="flex-shrink-0 flex items-center"
                            >
                                <span class="text-[11px] text-[#9CA3AF] bg-[#F9F9F9] px-2 py-1 rounded-full">Kelompok</span>
                            </div>
                        </div>

                        <!-- Empty state -->
                        <div v-if="filteredChildren.length === 0" class="px-6 py-16 flex flex-col items-center gap-3 text-center">
                            <svg class="h-12 w-12 text-[#D1D5DB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-[14px] font-medium text-[#686964]">Tidak ada data ditemukan</p>
                            <p class="text-[13px] text-[#9CA3AF]">Coba gunakan kata kunci lain</p>
                        </div>
                    </div>
                </div>

                <!-- ── Footer CTA ──────────────────────────────────────── -->
                <div class="relative overflow-hidden rounded-2xl bg-[#E63946] px-6 py-12 sm:px-10 sm:py-14">
                    <img src="/icons/ft-docs.svg" alt="" class="absolute right-6 top-6 h-16 w-16 opacity-20 sm:right-10 sm:top-8 sm:h-24 sm:w-24" />
                    <div class="relative flex flex-col items-center text-center">
                        <h3 class="max-w-2xl text-[22px] font-bold leading-[32px] text-white sm:text-[28px] sm:leading-[38px]">
                            Tidak Menemukan KBLI yang Anda Cari?
                        </h3>
                        <p class="mt-4 max-w-lg text-[14px] leading-[22px] text-white/80 sm:text-[16px] sm:leading-[24px]">
                            Tim kami siap membantu Anda menemukan solusi yang tepat<br class="hidden sm:block" />
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