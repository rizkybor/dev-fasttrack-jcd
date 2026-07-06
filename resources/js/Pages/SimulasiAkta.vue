<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref, computed, watch, nextTick } from "vue";
import { useAktaPDF } from "@/Composables/useAktaPdf.js";

const { generateAktaPDF } = useAktaPDF();

const whatsappNumber = "6282298604144";
const buildWhatsappLink = () => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai Simulasi Akta Pendirian.`;
    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

// ===== 1. Nama Perseroan =====
const namaPerseroan = ref("");

// ===== 2. Tempat & Kedudukan =====
const kotaKedudukan = ref("");
const provinsi = ref("");
const alamatLengkap = ref("");

const daftarKota = [
    "Jakarta Selatan", "Jakarta Pusat", "Jakarta Barat", "Jakarta Timur", "Jakarta Utara",
    "Surabaya", "Bandung", "Medan", "Semarang", "Makassar", "Yogyakarta", "Bali",
    "Tangerang", "Bekasi", "Depok", "Bogor", "Palembang", "Balikpapan",
];

// ===== 3. Bidang Usaha =====
const searchKBLI = ref("");
const selectedKBLI = ref([]);
const daftarKBLI = ref([]);
const isLoadingKBLI = ref(true);

const flattenKBLI = (nodes) => {
    const result = [];
    for (const node of nodes) {
        const kode = String(node.nomor_kbli ?? "").trim();
        if (kode.length === 5 && /^\d{5}$/.test(kode)) {
            result.push({
                kode,
                kegiatan: node.nama ?? "",
                deskripsi: node.description ?? "",
            });
        }
        if (node.children?.length) {
            result.push(...flattenKBLI(node.children));
        }
    }
    return result;
};

fetch("/data/kbli2025.json")
    .then((res) => res.json())
    .then((data) => {
        const nodes = Array.isArray(data) ? data : [data];
        daftarKBLI.value = flattenKBLI(nodes);
    })
    .catch(() => console.error("Gagal memuat data KBLI"))
    .finally(() => { isLoadingKBLI.value = false; });

const currentPage = ref(1);
const perPage = 10;

const filteredKBLI = computed(() => {
    if (!searchKBLI.value) return daftarKBLI.value;
    const q = searchKBLI.value.toLowerCase();
    return daftarKBLI.value.filter((k) =>
        k.kode.includes(q) ||
        k.kegiatan.toLowerCase().includes(q) ||
        k.deskripsi.toLowerCase().includes(q)
    );
});

const totalPages = computed(() => Math.ceil(filteredKBLI.value.length / perPage));

const paginatedKBLI = computed(() => {
    const start = (currentPage.value - 1) * perPage;
    return filteredKBLI.value.slice(start, start + perPage);
});

watch(searchKBLI, () => { currentPage.value = 1; });

const pageNumbers = computed(() => {
    const total = totalPages.value;
    const current = currentPage.value;
    const pages = [];
    if (total <= 7) {
        for (let i = 1; i <= total; i++) pages.push(i);
    } else {
        pages.push(1);
        if (current > 3) pages.push("...");
        for (let i = Math.max(2, current - 1); i <= Math.min(total - 1, current + 1); i++) {
            pages.push(i);
        }
        if (current < total - 2) pages.push("...");
        pages.push(total);
    }
    return pages;
});

const isKBLISelected = (kode) => selectedKBLI.value.some((k) => k.kode === kode);
const toggleKBLI = (item) => {
    if (isKBLISelected(item.kode)) {
        selectedKBLI.value = selectedKBLI.value.filter((k) => k.kode !== item.kode);
    } else {
        selectedKBLI.value.push(item);
    }
};

// ===== 4. Struktur Permodalan =====
const modalDasar = ref("");
const modalDitempatkan = ref("");
const modalDisetor = ref("");
const sahamPerPendiri = ref("WNI");
const sahamBiasa = ref("Ya - Hanya Saham Biasa");
const parseNum = (val) => parseInt(String(val).replace(/\D/g, "")) || 0;
const formatRupiah = (val) => {
    const num = parseNum(val);
    return num ? num.toLocaleString("id-ID") : "";
};

// ===== 5. Pemegang Saham =====
const pemegangSaham = ref([
    { id: 1, nama: "", kepemilikan: "", domisili: "WNI", direksi: false, komisaris: false }
]);
const tambahPemegangSaham = () => {
    pemegangSaham.value.push({
        id: Date.now(), nama: "", kepemilikan: "", domisili: "WNI", direksi: false, komisaris: false
    });
};
const hapusPemegangSaham = (id) => {
    if (pemegangSaham.value.length > 1)
        pemegangSaham.value = pemegangSaham.value.filter((p) => p.id !== id);
};

// ===== 6. Direksi =====
const direksi = ref([{ id: 1, jabatan: "", nama: "" }]);
const tambahDireksi = () => {
    direksi.value.push({ id: Date.now(), jabatan: "", nama: "" });
};
const hapusDireksi = (id) => {
    if (direksi.value.length > 1)
        direksi.value = direksi.value.filter((d) => d.id !== id);
};

// ===== 7. Dewan Komisaris =====
const komisaris = ref([{ id: 1, jabatan: "", nama: "" }]);
const tambahKomisaris = () => {
    komisaris.value.push({ id: Date.now(), jabatan: "", nama: "" });
};
const hapusKomisaris = (id) => {
    if (komisaris.value.length > 1)
        komisaris.value = komisaris.value.filter((k) => k.id !== id);
};

// ===== PDF Preview =====
const pdfBlobUrl = ref(null);
const pdfFilename = ref("");
const showPdfPreview = ref(false);

const closePdfPreview = () => {
    showPdfPreview.value = false;
    if (pdfBlobUrl.value) {
        URL.revokeObjectURL(pdfBlobUrl.value);
        pdfBlobUrl.value = null;
    }
};

const downloadPdf = () => {
    if (!pdfBlobUrl.value) return;
    const a = document.createElement("a");
    a.href = pdfBlobUrl.value;
    a.download = pdfFilename.value;
    a.click();
};

// ===== Validasi =====
const errors = ref({});

const validate = () => {
    const e = {};

    // 1. Nama Perseroan
    if (!namaPerseroan.value.trim()) {
        e.namaPerseroan = "Nama perseroan wajib diisi.";
    } else if (namaPerseroan.value.trim().split(/\s+/).length < 3) {
        e.namaPerseroan = "Nama perseroan minimal terdiri dari 3 suku kata.";
    }

    // 2. Kedudukan
    if (!kotaKedudukan.value) e.kotaKedudukan = "Kota kedudukan wajib dipilih.";
    if (!provinsi.value.trim()) e.provinsi = "Provinsi wajib diisi.";

    // 3. Bidang Usaha
    if (!selectedKBLI.value.length) e.selectedKBLI = "Pilih minimal 1 bidang usaha.";

    // 4. Modal
    const mD = parseNum(modalDasar.value);
    const mT = parseNum(modalDitempatkan.value);
    const mS = parseNum(modalDisetor.value);
    if (!mD) e.modalDasar = "Modal dasar wajib diisi.";
    if (!mT) e.modalDitempatkan = "Modal ditempatkan wajib diisi.";
    else if (mT > mD) e.modalDitempatkan = "Modal ditempatkan tidak boleh melebihi modal dasar.";
    else if (mT < mD * 0.25) e.modalDitempatkan = "Modal ditempatkan minimal 25% dari modal dasar.";
    if (!mS) e.modalDisetor = "Modal disetor wajib diisi.";
    else if (mS > mT) e.modalDisetor = "Modal disetor tidak boleh melebihi modal ditempatkan.";

    // 5. Pemegang Saham
    const psErrors = [];
    let totalPct = 0;
    pemegangSaham.value.forEach((ps, idx) => {
        const pe = {};
        if (!ps.nama.trim()) pe.nama = "Nama wajib diisi.";
        if (!ps.kepemilikan) pe.kepemilikan = "Persentase wajib diisi.";
        else if (parseFloat(ps.kepemilikan) <= 0) pe.kepemilikan = "Persentase harus lebih dari 0.";
        totalPct += parseFloat(ps.kepemilikan) || 0;
        psErrors[idx] = pe;
    });
    if (psErrors.some((pe) => Object.keys(pe).length)) e.pemegangSaham = psErrors;
    if (Math.round(totalPct) !== 100)
        e.totalPct = `Total kepemilikan harus 100%. Saat ini: ${totalPct.toFixed(1)}%.`;

    // 6. Direksi
    const dErrors = [];
    direksi.value.forEach((d, idx) => {
        const de = {};
        if (!d.jabatan) de.jabatan = "Jabatan wajib dipilih.";
        if (!d.nama.trim()) de.nama = "Nama wajib diisi.";
        dErrors[idx] = de;
    });
    if (dErrors.some((de) => Object.keys(de).length)) e.direksi = dErrors;

    // 7. Komisaris
    const kErrors = [];
    komisaris.value.forEach((k, idx) => {
        const ke = {};
        if (!k.jabatan) ke.jabatan = "Jabatan wajib dipilih.";
        if (!k.nama.trim()) ke.nama = "Nama wajib diisi.";
        kErrors[idx] = ke;
    });
    if (kErrors.some((ke) => Object.keys(ke).length)) e.komisaris = kErrors;

    errors.value = e;
    return Object.keys(e).length === 0;
};

// Clear error saat field diubah
watch(namaPerseroan, () => { delete errors.value.namaPerseroan; });
watch(kotaKedudukan, () => { delete errors.value.kotaKedudukan; });
watch(provinsi, () => { delete errors.value.provinsi; });
watch(selectedKBLI, () => { delete errors.value.selectedKBLI; }, { deep: true });
watch(modalDasar, () => { delete errors.value.modalDasar; });
watch(modalDitempatkan, () => { delete errors.value.modalDitempatkan; });
watch(modalDisetor, () => { delete errors.value.modalDisetor; });
watch(pemegangSaham, () => { delete errors.value.totalPct; }, { deep: true });

// ===== Submit =====
const handleSimulasi = () => {
    if (!validate()) {
        nextTick(() => {
            const el = document.querySelector(".field-error");
            if (el) el.scrollIntoView({ behavior: "smooth", block: "center" });
        });
        return;
    }

    const result = generateAktaPDF({
        namaPerseroan: namaPerseroan.value,
        kotaKedudukan: kotaKedudukan.value,
        provinsi: provinsi.value,
        alamatLengkap: alamatLengkap.value,
        selectedKBLI: selectedKBLI.value,
        modalDasar: modalDasar.value,
        modalDitempatkan: modalDitempatkan.value,
        modalDisetor: modalDisetor.value,
        sahamPerPendiri: sahamPerPendiri.value,
        pemegangSaham: pemegangSaham.value,
        direksi: direksi.value,
        komisaris: komisaris.value,
    });

    if (result?.blobUrl) {
        pdfBlobUrl.value = result.blobUrl;
        pdfFilename.value = result.filename;
        showPdfPreview.value = true;
    }
};

// Helper icon error
const errorIconPath = "M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z";
</script>

<template>
    <MainLayout>
        <!-- Hero -->
        <section class="relative overflow-hidden bg-[#9e1f16] py-10 sm:py-12">
            <img src="/icons/left-arrow.svg"
                class="absolute right-0 top-0 h-full w-auto opacity-30 pointer-events-none hidden lg:block" alt="" />
            <div class="relative z-10 mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <nav class="mb-3">
                    <div class="inline-flex items-center gap-2 rounded-md bg-white px-3 py-1.5">
                        <a href="/" class="text-[#9e1f16]">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
                            </svg>
                        </a>
                        <svg class="h-3 w-3 text-[#9e1f16]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-[12px] font-medium text-[#9e1f16]">Simulasi Akta Pendirian</span>
                    </div>
                </nav>
                <h1 class="text-[28px] font-extrabold text-white leading-tight">Simulasi Akta Pendirian</h1>
                <p class="mt-2 text-[14px] text-white/80">
                    Simulasikan dokumen akta pendirian perusahaan Anda melalui proses yang mudah dilakukan.
                </p>
            </div>
        </section>

        <!-- FORM -->
        <section class="bg-[#F7F7F5] py-10 sm:py-14">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-5">

                    <!-- ===== 1. Nama Perseroan ===== -->
                    <div class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        :class="errors.namaPerseroan ? 'border-red-200' : ''">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full text-white text-[13px] font-bold"
                                :class="errors.namaPerseroan ? 'bg-red-400' : 'bg-primary'">1</span>
                            <h2 class="text-[15px] font-bold text-black">Nama Perseroan</h2>
                            <span class="text-red-500 text-[13px]">*</span>
                        </div>
                        <p class="text-[12px] text-[#686964] mb-5 pl-10">Masukan nama PT yang akan didirikan</p>
                        <div>
                            <label class="block text-[13px] font-semibold text-[#1A1B18] mb-1.5">
                                Nama Perseroan <span class="text-red-500">*</span>
                            </label>
                            <input v-model="namaPerseroan" type="text"
                                placeholder="Contoh: Fasttrack Bisnis Indonesia"
                                class="w-full rounded-lg border px-3.5 py-2.5 text-[13px] text-[#1A1B18] placeholder-[#B0B0AE] focus:outline-none focus:ring-1 transition"
                                :class="errors.namaPerseroan
                                    ? 'border-red-400 focus:border-red-400 focus:ring-red-300 bg-red-50'
                                    : 'border-[#D9DAD8] focus:border-primary focus:ring-primary bg-white'" />
                            <p v-if="errors.namaPerseroan"
                                class="field-error mt-1.5 flex items-center gap-1 text-[11px] text-red-500">
                                <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                                </svg>
                                {{ errors.namaPerseroan }}
                            </p>
                            <p v-else class="text-[11px] text-[#686964] mt-1.5">
                                Nama perseroan minimal terdiri dari 3 suku kata. Contoh: Fasttrack Bisnis Indonesia
                            </p>
                        </div>
                    </div>

                    <!-- ===== 2. Tempat & Kedudukan ===== -->
                    <div class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        :class="errors.kotaKedudukan || errors.provinsi ? 'border-red-200' : ''">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full text-white text-[13px] font-bold"
                                :class="errors.kotaKedudukan || errors.provinsi ? 'bg-red-400' : 'bg-primary'">2</span>
                            <h2 class="text-[15px] font-bold text-black">Tempat & Kedudukan</h2>
                            <span class="text-red-500 text-[13px]">*</span>
                        </div>
                        <p class="text-[12px] text-[#686964] mb-5 pl-10">Masukan kota/kabupaten tempat usaha didirikan</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-[13px] font-semibold text-[#1A1B18] mb-1.5">
                                    Kota Kedudukan <span class="text-red-500">*</span>
                                </label>
                                <select v-model="kotaKedudukan"
                                    class="w-full rounded-lg border px-3.5 py-2.5 text-[13px] text-[#1A1B18] focus:outline-none focus:ring-1 transition"
                                    :class="errors.kotaKedudukan
                                        ? 'border-red-400 focus:border-red-400 focus:ring-red-300 bg-red-50'
                                        : 'border-[#D9DAD8] focus:border-primary focus:ring-primary bg-white'">
                                    <option value="">Pilih Kota/Kabupaten</option>
                                    <option v-for="kota in daftarKota" :key="kota" :value="kota">{{ kota }}</option>
                                </select>
                                <p v-if="errors.kotaKedudukan"
                                    class="field-error mt-1.5 flex items-center gap-1 text-[11px] text-red-500">
                                    <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                                    </svg>
                                    {{ errors.kotaKedudukan }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-[13px] font-semibold text-[#1A1B18] mb-1.5">
                                    Provinsi <span class="text-red-500">*</span>
                                </label>
                                <input v-model="provinsi" type="text" placeholder="Contoh: DKI Jakarta"
                                    class="w-full rounded-lg border px-3.5 py-2.5 text-[13px] text-[#1A1B18] placeholder-[#B0B0AE] focus:outline-none focus:ring-1 transition"
                                    :class="errors.provinsi
                                        ? 'border-red-400 focus:border-red-400 focus:ring-red-300 bg-red-50'
                                        : 'border-[#D9DAD8] focus:border-primary focus:ring-primary bg-white'" />
                                <p v-if="errors.provinsi"
                                    class="field-error mt-1.5 flex items-center gap-1 text-[11px] text-red-500">
                                    <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                                    </svg>
                                    {{ errors.provinsi }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-[#1A1B18] mb-1.5">Alamat Lengkap</label>
                            <textarea v-model="alamatLengkap" rows="3"
                                placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos"
                                class="w-full rounded-lg border border-[#D9DAD8] bg-white px-3.5 py-2.5 text-[13px] text-[#1A1B18] placeholder-[#B0B0AE] focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary transition resize-none"></textarea>
                        </div>
                    </div>

                    <!-- ===== 3. Bidang Usaha ===== -->
                    <div class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        :class="errors.selectedKBLI ? 'border-red-200' : ''">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full text-white text-[13px] font-bold"
                                :class="errors.selectedKBLI ? 'bg-red-400' : 'bg-primary'">3</span>
                            <h2 class="text-[15px] font-bold text-black">Bidang Usaha</h2>
                            <span class="text-red-500 text-[13px]">*</span>
                        </div>
                        <p class="text-[12px] text-[#686964] mb-4 pl-10">Pilih bidang usaha yang akan dijalankan perseroan</p>

                        <!-- Selected tags -->
                        <div v-if="selectedKBLI.length" class="flex flex-wrap gap-2 mb-4">
                            <span v-for="k in selectedKBLI" :key="k.kode"
                                class="inline-flex items-center gap-1.5 rounded-full bg-primary/10 px-3 py-1 text-[12px] font-semibold text-primary">
                                {{ k.kode }} – {{ k.kegiatan }}
                                <button @click="toggleKBLI(k)" class="hover:text-primary/60 transition-colors">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </span>
                        </div>

                        <!-- Error KBLI -->
                        <div v-if="errors.selectedKBLI"
                            class="field-error mb-3 flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-3 py-2.5">
                            <svg class="h-4 w-4 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                            </svg>
                            <span class="text-[12px] text-red-600 font-medium">{{ errors.selectedKBLI }}</span>
                        </div>

                        <!-- Search -->
                        <div class="relative mb-3">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[#B0B0AE]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input v-model="searchKBLI" type="text"
                                placeholder="Cari kode atau nama bidang usaha KBLI..."
                                class="w-full rounded-lg border border-[#D9DAD8] bg-white pl-9 pr-3.5 py-2.5 text-[13px] text-[#1A1B18] placeholder-[#B0B0AE] focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary transition" />
                        </div>

                        <!-- Info -->
                        <p class="text-[11px] text-[#686964] mb-3">
                            <template v-if="isLoadingKBLI">Memuat data KBLI...</template>
                            <template v-else-if="searchKBLI">
                                {{ filteredKBLI.length.toLocaleString("id-ID") }} hasil untuk "{{ searchKBLI }}"
                            </template>
                            <template v-else>
                                {{ daftarKBLI.length.toLocaleString("id-ID") }} kode KBLI 5 digit tersedia. Ketik untuk mencari.
                            </template>
                        </p>

                        <!-- Table -->
                        <div class="rounded-xl border border-[#E8E8E6] overflow-hidden">
                            <div v-if="isLoadingKBLI" class="py-10 text-center text-[13px] text-[#686964]">
                                <svg class="mx-auto mb-2 h-6 w-6 animate-spin text-primary" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Memuat data KBLI 2025...
                            </div>
                            <table v-else class="w-full text-[12px]">
                                <thead class="bg-[#F7F7F5] border-b border-[#E8E8E6]">
                                    <tr>
                                        <th class="text-left px-4 py-3 font-bold text-[#1A1B18] w-20">Kode</th>
                                        <th class="text-left px-4 py-3 font-bold text-[#1A1B18] w-44">Kegiatan</th>
                                        <th class="text-left px-4 py-3 font-bold text-[#1A1B18]">Deskripsi</th>
                                        <th class="text-center px-4 py-3 font-bold text-[#1A1B18] w-20">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#F0F0EE]">
                                    <tr v-for="item in paginatedKBLI" :key="item.kode"
                                        class="hover:bg-[#FAFAFA] transition-colors">
                                        <td class="px-4 py-3 font-bold text-primary whitespace-nowrap">{{ item.kode }}</td>
                                        <td class="px-4 py-3 font-semibold text-[#1A1B18] leading-snug">{{ item.kegiatan }}</td>
                                        <td class="px-4 py-3 text-[#686964] leading-relaxed">
                                            <span class="line-clamp-2">{{ item.deskripsi || "-" }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <button @click="toggleKBLI(item)"
                                                class="rounded-lg px-3 py-1.5 text-[11px] font-bold transition-colors whitespace-nowrap"
                                                :class="isKBLISelected(item.kode)
                                                    ? 'bg-primary/10 text-primary'
                                                    : 'bg-[#F7F7F5] text-[#686964] hover:bg-primary/10 hover:text-primary'">
                                                {{ isKBLISelected(item.kode) ? "✓ Dipilih" : "Pilih" }}
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="!paginatedKBLI.length">
                                        <td colspan="4" class="px-4 py-8 text-center text-[#686964]">
                                            <svg class="mx-auto mb-2 h-8 w-8 text-[#D9DAD8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                            Tidak ada hasil untuk "<strong>{{ searchKBLI }}</strong>"
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div v-if="!isLoadingKBLI && totalPages > 1"
                            class="mt-3 flex items-center justify-between gap-4">
                            <p class="text-[11px] text-[#686964] whitespace-nowrap">
                                Hal. {{ currentPage }} / {{ totalPages.toLocaleString("id-ID") }}
                                &nbsp;·&nbsp;
                                {{ ((currentPage - 1) * perPage + 1).toLocaleString("id-ID") }}–{{ Math.min(currentPage * perPage, filteredKBLI.length).toLocaleString("id-ID") }}
                                dari {{ filteredKBLI.length.toLocaleString("id-ID") }}
                            </p>
                            <div class="flex items-center gap-1">
                                <button @click="currentPage--" :disabled="currentPage === 1"
                                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#E8E8E6] text-[#686964] transition-colors disabled:opacity-30 disabled:cursor-not-allowed hover:border-primary hover:text-primary">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <template v-for="page in pageNumbers" :key="`page-${page}`">
                                    <span v-if="page === '...'"
                                        class="flex h-8 w-8 items-center justify-center text-[12px] text-[#686964]">…</span>
                                    <button v-else @click="currentPage = page"
                                        class="flex h-8 w-8 items-center justify-center rounded-lg border text-[12px] font-semibold transition-colors"
                                        :class="currentPage === page
                                            ? 'border-primary bg-primary text-white'
                                            : 'border-[#E8E8E6] text-[#686964] hover:border-primary hover:text-primary'">
                                        {{ page }}
                                    </button>
                                </template>
                                <button @click="currentPage++" :disabled="currentPage === totalPages"
                                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#E8E8E6] text-[#686964] transition-colors disabled:opacity-30 disabled:cursor-not-allowed hover:border-primary hover:text-primary">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- ===== 4. Struktur Permodalan ===== -->
                    <div class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        :class="errors.modalDasar || errors.modalDitempatkan || errors.modalDisetor ? 'border-red-200' : ''">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full text-white text-[13px] font-bold"
                                :class="errors.modalDasar || errors.modalDitempatkan || errors.modalDisetor ? 'bg-red-400' : 'bg-primary'">4</span>
                            <h2 class="text-[15px] font-bold text-black">Struktur Permodalan</h2>
                            <span class="text-red-500 text-[13px]">*</span>
                        </div>
                        <p class="text-[12px] text-[#686964] mb-5 pl-10">Tentukan modal dasar, ditempatkan dan disetor</p>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                            <!-- Modal Dasar -->
                            <div>
                                <label class="block text-[13px] font-semibold text-[#1A1B18] mb-1.5">
                                    Modal Dasar <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] text-[#686964]">Rp</span>
                                    <input v-model="modalDasar" type="text"
                                        placeholder="50.000.000"
                                        class="w-full rounded-lg border pl-8 pr-3.5 py-2.5 text-[13px] focus:outline-none focus:ring-1 transition"
                                        :class="errors.modalDasar
                                            ? 'border-red-400 focus:border-red-400 focus:ring-red-300 bg-red-50'
                                            : 'border-[#D9DAD8] focus:border-primary focus:ring-primary bg-white'" />
                                </div>
                                <p v-if="errors.modalDasar"
                                    class="field-error mt-1.5 flex items-center gap-1 text-[11px] text-red-500">
                                    <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                                    </svg>
                                    {{ errors.modalDasar }}
                                </p>
                            </div>

                            <!-- Modal Ditempatkan -->
                            <div>
                                <label class="block text-[13px] font-semibold text-[#1A1B18] mb-1.5">
                                    Modal Ditempatkan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] text-[#686964]">Rp</span>
                                    <input v-model="modalDitempatkan" type="text"
                                        placeholder="12.500.000"
                                        class="w-full rounded-lg border pl-8 pr-3.5 py-2.5 text-[13px] focus:outline-none focus:ring-1 transition"
                                        :class="errors.modalDitempatkan
                                            ? 'border-red-400 focus:border-red-400 focus:ring-red-300 bg-red-50'
                                            : 'border-[#D9DAD8] focus:border-primary focus:ring-primary bg-white'" />
                                </div>
                                <p v-if="errors.modalDitempatkan"
                                    class="field-error mt-1.5 flex items-center gap-1 text-[11px] text-red-500">
                                    <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                                    </svg>
                                    {{ errors.modalDitempatkan }}
                                </p>
                            </div>

                            <!-- Modal Disetor -->
                            <div>
                                <label class="block text-[13px] font-semibold text-[#1A1B18] mb-1.5">
                                    Modal Disetor <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[13px] text-[#686964]">Rp</span>
                                    <input v-model="modalDisetor" type="text"
                                        placeholder="12.500.000"
                                        class="w-full rounded-lg border pl-8 pr-3.5 py-2.5 text-[13px] focus:outline-none focus:ring-1 transition"
                                        :class="errors.modalDisetor
                                            ? 'border-red-400 focus:border-red-400 focus:ring-red-300 bg-red-50'
                                            : 'border-[#D9DAD8] focus:border-primary focus:ring-primary bg-white'" />
                                </div>
                                <p v-if="errors.modalDisetor"
                                    class="field-error mt-1.5 flex items-center gap-1 text-[11px] text-red-500">
                                    <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                                    </svg>
                                    {{ errors.modalDisetor }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[13px] font-semibold text-[#1A1B18] mb-2">Saham per Pendiri</label>
                                <div class="flex gap-4">
                                    <label v-for="opt in ['WNI', 'WNA', 'Campuran']" :key="opt"
                                        class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" v-model="sahamPerPendiri" :value="opt" class="accent-primary" />
                                        <span class="text-[13px] text-[#1A1B18]">{{ opt }}</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[13px] font-semibold text-[#1A1B18] mb-2">Jenis Saham</label>
                                <div class="flex flex-col gap-2">
                                    <label v-for="opt in ['Ya - Hanya Saham Biasa', 'Ya - Ada Saham Preferen']" :key="opt"
                                        class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" v-model="sahamBiasa" :value="opt" class="accent-primary" />
                                        <span class="text-[13px] text-[#1A1B18]">{{ opt }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Info modal -->
                        <div v-if="parseNum(modalDasar) && parseNum(modalDitempatkan)"
                            class="mt-4 rounded-lg bg-blue-50 border border-blue-200 px-4 py-3">
                            <p class="text-[12px] text-blue-700">
                                Modal ditempatkan:
                                <strong>{{ ((parseNum(modalDitempatkan) / parseNum(modalDasar)) * 100).toFixed(1) }}%</strong>
                                dari modal dasar
                                <span v-if="parseNum(modalDitempatkan) / parseNum(modalDasar) >= 0.25"
                                    class="text-green-600 font-semibold"> ✓ Memenuhi syarat</span>
                                <span v-else class="text-red-500 font-semibold"> ✗ Minimal 25%</span>
                            </p>
                        </div>
                    </div>

                    <!-- ===== 5. Pemegang Saham ===== -->
                    <div class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        :class="errors.pemegangSaham || errors.totalPct ? 'border-red-200' : ''">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full text-white text-[13px] font-bold"
                                :class="errors.pemegangSaham || errors.totalPct ? 'bg-red-400' : 'bg-primary'">5</span>
                            <h2 class="text-[15px] font-bold text-black">Pemegang Saham</h2>
                            <span class="text-red-500 text-[13px]">*</span>
                        </div>
                        <p class="text-[12px] text-[#686964] mb-5 pl-10">Tentukan susunan pemegang saham</p>

                        <!-- Error total -->
                        <div v-if="errors.totalPct"
                            class="field-error mb-4 flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-3 py-2.5">
                            <svg class="h-4 w-4 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                            </svg>
                            <span class="text-[12px] text-red-600 font-medium">{{ errors.totalPct }}</span>
                        </div>

                        <div class="flex flex-col gap-4">
                            <div v-for="(ps, idx) in pemegangSaham" :key="ps.id"
                                class="rounded-xl border p-4 transition-colors"
                                :class="errors.pemegangSaham?.[idx] && Object.keys(errors.pemegangSaham[idx]).length
                                    ? 'border-red-200 bg-red-50/30'
                                    : 'border-[#E8E8E6]'">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[13px] font-bold text-[#1A1B18]">Pemegang Saham {{ idx + 1 }}</span>
                                    <button v-if="pemegangSaham.length > 1" @click="hapusPemegangSaham(ps.id)"
                                        class="text-[12px] font-semibold text-red-400 hover:text-red-500 transition">Hapus</button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="block text-[12px] font-semibold text-[#1A1B18] mb-1">
                                            Nama <span class="text-red-500">*</span>
                                        </label>
                                        <input v-model="ps.nama" type="text" placeholder="Nama lengkap"
                                            class="w-full rounded-lg border px-3 py-2 text-[13px] focus:outline-none focus:ring-1 transition"
                                            :class="errors.pemegangSaham?.[idx]?.nama
                                                ? 'border-red-400 focus:border-red-400 focus:ring-red-300 bg-red-50'
                                                : 'border-[#D9DAD8] focus:border-primary focus:ring-primary bg-white'" />
                                        <p v-if="errors.pemegangSaham?.[idx]?.nama"
                                            class="field-error mt-1 flex items-center gap-1 text-[11px] text-red-500">
                                            <svg class="h-3 w-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                                            </svg>
                                            {{ errors.pemegangSaham[idx].nama }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-[12px] font-semibold text-[#1A1B18] mb-1">
                                            Kepemilikan <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input v-model="ps.kepemilikan" type="number" min="0" max="100" placeholder="0"
                                                class="w-full rounded-lg border px-3 py-2 pr-8 text-[13px] focus:outline-none focus:ring-1 transition"
                                                :class="errors.pemegangSaham?.[idx]?.kepemilikan
                                                    ? 'border-red-400 focus:border-red-400 focus:ring-red-300 bg-red-50'
                                                    : 'border-[#D9DAD8] focus:border-primary focus:ring-primary bg-white'" />
                                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[13px] text-[#686964]">%</span>
                                        </div>
                                        <p v-if="errors.pemegangSaham?.[idx]?.kepemilikan"
                                            class="field-error mt-1 flex items-center gap-1 text-[11px] text-red-500">
                                            <svg class="h-3 w-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                                            </svg>
                                            {{ errors.pemegangSaham[idx].kepemilikan }}
                                        </p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[12px] font-semibold text-[#1A1B18] mb-1">Domisili</label>
                                        <div class="flex gap-4">
                                            <label v-for="opt in ['WNI', 'WNA']" :key="opt"
                                                class="flex items-center gap-1.5 cursor-pointer">
                                                <input type="radio" v-model="ps.domisili" :value="opt" class="accent-primary" />
                                                <span class="text-[12px] text-[#1A1B18]">{{ opt }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[12px] font-semibold text-[#1A1B18] mb-1">Juga Menjabat Sebagai</label>
                                        <div class="flex gap-4">
                                            <label class="flex items-center gap-1.5 cursor-pointer">
                                                <input type="checkbox" v-model="ps.direksi" class="accent-primary rounded" />
                                                <span class="text-[12px] text-[#1A1B18]">Direksi</span>
                                            </label>
                                            <label class="flex items-center gap-1.5 cursor-pointer">
                                                <input type="checkbox" v-model="ps.komisaris" class="accent-primary rounded" />
                                                <span class="text-[12px] text-[#1A1B18]">Komisaris</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total persentase indicator -->
                        <div class="mt-3 flex items-center justify-between text-[12px]">
                            <span class="text-[#686964]">Total kepemilikan:</span>
                            <span class="font-bold"
                                :class="Math.round(pemegangSaham.reduce((s, p) => s + (parseFloat(p.kepemilikan) || 0), 0)) === 100
                                    ? 'text-green-600' : 'text-red-500'">
                                {{ pemegangSaham.reduce((s, p) => s + (parseFloat(p.kepemilikan) || 0), 0).toFixed(1) }}%
                                {{ Math.round(pemegangSaham.reduce((s, p) => s + (parseFloat(p.kepemilikan) || 0), 0)) === 100 ? "✓" : "(harus 100%)" }}
                            </span>
                        </div>

                        <button @click="tambahPemegangSaham"
                            class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl border border-dashed border-primary py-3 text-[13px] font-semibold text-primary hover:bg-primary/5 transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Pemegang Saham
                        </button>
                    </div>

                    <!-- ===== 6. Direksi ===== -->
                    <div class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        :class="errors.direksi ? 'border-red-200' : ''">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full text-white text-[13px] font-bold"
                                :class="errors.direksi ? 'bg-red-400' : 'bg-primary'">6</span>
                            <h2 class="text-[15px] font-bold text-black">Direksi/Direktur</h2>
                            <span class="text-red-500 text-[13px]">*</span>
                        </div>
                        <p class="text-[12px] text-[#686964] mb-5 pl-10">Tentukan susunan direksi perusahaan</p>

                        <div class="flex flex-col gap-3">
                            <div v-for="(d, idx) in direksi" :key="d.id"
                                class="rounded-xl border p-4 transition-colors"
                                :class="errors.direksi?.[idx] && Object.keys(errors.direksi[idx]).length
                                    ? 'border-red-200 bg-red-50/30'
                                    : 'border-[#E8E8E6]'">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[13px] font-bold text-[#1A1B18]">Direktur {{ idx + 1 }}</span>
                                    <button v-if="direksi.length > 1" @click="hapusDireksi(d.id)"
                                        class="text-[12px] font-semibold text-red-400 hover:text-red-500 transition">Hapus</button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[12px] font-semibold text-[#1A1B18] mb-1">
                                            Jabatan <span class="text-red-500">*</span>
                                        </label>
                                        <select v-model="d.jabatan"
                                            class="w-full rounded-lg border px-3 py-2 text-[13px] focus:outline-none focus:ring-1 transition"
                                            :class="errors.direksi?.[idx]?.jabatan
                                                ? 'border-red-400 focus:border-red-400 focus:ring-red-300 bg-red-50'
                                                : 'border-[#D9DAD8] focus:border-primary focus:ring-primary bg-white'">
                                            <option value="">Pilih Jabatan</option>
                                            <option>Direktur Utama</option>
                                            <option>Direktur</option>
                                        </select>
                                        <p v-if="errors.direksi?.[idx]?.jabatan"
                                            class="field-error mt-1 flex items-center gap-1 text-[11px] text-red-500">
                                            <svg class="h-3 w-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                                            </svg>
                                            {{ errors.direksi[idx].jabatan }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-[12px] font-semibold text-[#1A1B18] mb-1">
                                            Nama Direktur <span class="text-red-500">*</span>
                                        </label>
                                        <input v-model="d.nama" type="text" placeholder="Nama lengkap"
                                            class="w-full rounded-lg border px-3 py-2 text-[13px] focus:outline-none focus:ring-1 transition"
                                            :class="errors.direksi?.[idx]?.nama
                                                ? 'border-red-400 focus:border-red-400 focus:ring-red-300 bg-red-50'
                                                : 'border-[#D9DAD8] focus:border-primary focus:ring-primary bg-white'" />
                                        <p v-if="errors.direksi?.[idx]?.nama"
                                            class="field-error mt-1 flex items-center gap-1 text-[11px] text-red-500">
                                            <svg class="h-3 w-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                                            </svg>
                                            {{ errors.direksi[idx].nama }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button @click="tambahDireksi"
                            class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl border border-dashed border-primary py-3 text-[13px] font-semibold text-primary hover:bg-primary/5 transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Direksi
                        </button>
                    </div>

                    <!-- ===== 7. Dewan Komisaris ===== -->
                    <div class="rounded-2xl border border-[#E8E8E6] bg-white p-6 sm:p-8"
                        :class="errors.komisaris ? 'border-red-200' : ''">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full text-white text-[13px] font-bold"
                                :class="errors.komisaris ? 'bg-red-400' : 'bg-primary'">7</span>
                            <h2 class="text-[15px] font-bold text-black">Dewan Komisaris</h2>
                            <span class="text-red-500 text-[13px]">*</span>
                        </div>
                        <p class="text-[12px] text-[#686964] mb-5 pl-10">Tentukan susunan dewan komisaris perusahaan</p>

                        <div class="flex flex-col gap-3">
                            <div v-for="(k, idx) in komisaris" :key="k.id"
                                class="rounded-xl border p-4 transition-colors"
                                :class="errors.komisaris?.[idx] && Object.keys(errors.komisaris[idx]).length
                                    ? 'border-red-200 bg-red-50/30'
                                    : 'border-[#E8E8E6]'">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[13px] font-bold text-[#1A1B18]">Komisaris {{ idx + 1 }}</span>
                                    <button v-if="komisaris.length > 1" @click="hapusKomisaris(k.id)"
                                        class="text-[12px] font-semibold text-red-400 hover:text-red-500 transition">Hapus</button>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[12px] font-semibold text-[#1A1B18] mb-1">
                                            Jabatan <span class="text-red-500">*</span>
                                        </label>
                                        <select v-model="k.jabatan"
                                            class="w-full rounded-lg border px-3 py-2 text-[13px] focus:outline-none focus:ring-1 transition"
                                            :class="errors.komisaris?.[idx]?.jabatan
                                                ? 'border-red-400 focus:border-red-400 focus:ring-red-300 bg-red-50'
                                                : 'border-[#D9DAD8] focus:border-primary focus:ring-primary bg-white'">
                                            <option value="">Pilih Jabatan</option>
                                            <option>Komisaris Utama</option>
                                            <option>Komisaris</option>
                                        </select>
                                        <p v-if="errors.komisaris?.[idx]?.jabatan"
                                            class="field-error mt-1 flex items-center gap-1 text-[11px] text-red-500">
                                            <svg class="h-3 w-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                                            </svg>
                                            {{ errors.komisaris[idx].jabatan }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-[12px] font-semibold text-[#1A1B18] mb-1">
                                            Nama Komisaris <span class="text-red-500">*</span>
                                        </label>
                                        <input v-model="k.nama" type="text" placeholder="Nama lengkap"
                                            class="w-full rounded-lg border px-3 py-2 text-[13px] focus:outline-none focus:ring-1 transition"
                                            :class="errors.komisaris?.[idx]?.nama
                                                ? 'border-red-400 focus:border-red-400 focus:ring-red-300 bg-red-50'
                                                : 'border-[#D9DAD8] focus:border-primary focus:ring-primary bg-white'" />
                                        <p v-if="errors.komisaris?.[idx]?.nama"
                                            class="field-error mt-1 flex items-center gap-1 text-[11px] text-red-500">
                                            <svg class="h-3 w-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                                            </svg>
                                            {{ errors.komisaris[idx].nama }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button @click="tambahKomisaris"
                            class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl border border-dashed border-primary py-3 text-[13px] font-semibold text-primary hover:bg-primary/5 transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Komisaris
                        </button>
                    </div>

                    <!-- ===== Submit ===== -->
                    <div>
                        <!-- Summary error -->
                        <div v-if="Object.keys(errors).length"
                            class="mb-4 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                            <svg class="h-5 w-5 flex-shrink-0 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" :d="errorIconPath" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="text-[13px] font-bold text-red-600 mb-1">Terdapat {{ Object.keys(errors).length }} kesalahan yang perlu diperbaiki:</p>
                                <ul class="space-y-0.5">
                                    <li v-if="errors.namaPerseroan" class="text-[12px] text-red-500">• {{ errors.namaPerseroan }}</li>
                                    <li v-if="errors.kotaKedudukan" class="text-[12px] text-red-500">• {{ errors.kotaKedudukan }}</li>
                                    <li v-if="errors.provinsi" class="text-[12px] text-red-500">• {{ errors.provinsi }}</li>
                                    <li v-if="errors.selectedKBLI" class="text-[12px] text-red-500">• {{ errors.selectedKBLI }}</li>
                                    <li v-if="errors.modalDasar" class="text-[12px] text-red-500">• {{ errors.modalDasar }}</li>
                                    <li v-if="errors.modalDitempatkan" class="text-[12px] text-red-500">• {{ errors.modalDitempatkan }}</li>
                                    <li v-if="errors.modalDisetor" class="text-[12px] text-red-500">• {{ errors.modalDisetor }}</li>
                                    <li v-if="errors.totalPct" class="text-[12px] text-red-500">• {{ errors.totalPct }}</li>
                                    <li v-if="errors.pemegangSaham" class="text-[12px] text-red-500">• Data pemegang saham belum lengkap.</li>
                                    <li v-if="errors.direksi" class="text-[12px] text-red-500">• Data direksi belum lengkap.</li>
                                    <li v-if="errors.komisaris" class="text-[12px] text-red-500">• Data komisaris belum lengkap.</li>
                                </ul>
                            </div>
                        </div>

                        <button @click="handleSimulasi"
                            class="flex w-full items-center justify-center gap-2 rounded-xl py-4 text-[15px] font-bold text-white transition-all shadow-lg"
                            :class="Object.keys(errors).length
                                ? 'bg-red-400 shadow-red-200 cursor-not-allowed'
                                : 'bg-primary hover:bg-primary/90 shadow-primary/20'">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Simulasikan & Lihat PDF
                        </button>
                    </div>

                </div>
            </div>
        </section>

        <!-- Footer CTA -->
        <section class="bg-[#F7F7F5] mb-12">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-2xl bg-[#9e1f16] px-6 py-10 sm:px-10">
                    <div class="relative flex flex-col items-center text-center">
                        <h3 class="text-[20px] font-bold text-white sm:text-[24px]">
                            Butuh Penjelasan Lebih Spesifik?
                        </h3>
                        <p class="mt-3 text-[13px] leading-[1.6] text-white/80 max-w-md">
                            Tim kami siap membantu Anda melalui proses pendirian perusahaan dengan panduan yang tepat.
                        </p>
                        <a :href="buildWhatsappLink()" target="_blank" rel="noopener noreferrer"
                            class="mt-6 inline-flex items-center gap-2.5 rounded-lg bg-[#25D366] px-6 py-3 text-[14px] font-semibold text-white shadow-lg hover:-translate-y-0.5 hover:bg-[#20BD5A] transition-all">
                            Chat Langsung via WhatsApp
                            <img src="/icons/ft-wa.svg" alt="wa" class="h-5 w-5" />
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== Modal PDF Preview ===== -->
        <Teleport to="body">
            <div v-if="showPdfPreview"
                class="fixed inset-0 z-50 flex flex-col bg-black/70 backdrop-blur-sm">

                <!-- Header -->
                <div class="flex items-center justify-between bg-white px-5 py-3 shadow-md flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div>
                            <p class="text-[14px] font-bold text-[#1A1B18]">Simulasi Akta Pendirian</p>
                            <p class="text-[11px] text-[#686964]">{{ pdfFilename }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="downloadPdf"
                            class="flex items-center gap-1.5 rounded-lg bg-primary px-4 py-2 text-[13px] font-semibold text-white hover:bg-primary/90 transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Unduh PDF
                        </button>
                        <button @click="closePdfPreview"
                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#E8E8E6] text-[#686964] hover:bg-[#F7F7F5] transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- PDF Viewer -->
                <div class="flex-1 overflow-hidden p-4">
                    <iframe
                        :src="pdfBlobUrl"
                        class="w-full h-full rounded-xl bg-white shadow-2xl"
                        type="application/pdf"
                        :title="pdfFilename"
                    />
                </div>

                <!-- Footer modal -->
                <div class="flex items-center justify-center gap-4 bg-white px-5 py-3 shadow-[0_-1px_0_0_#E8E8E6] flex-shrink-0">
                    <p class="text-[12px] text-[#686964]">
                        Dokumen ini adalah simulasi dan bukan merupakan akta notaris yang sah.
                    </p>
                    <a :href="buildWhatsappLink()" target="_blank" rel="noopener noreferrer"
                        class="flex items-center gap-1.5 rounded-lg bg-[#25D366] px-4 py-2 text-[12px] font-semibold text-white hover:bg-[#20BD5A] transition-colors whitespace-nowrap">
                        <img src="/icons/ft-wa.svg" class="h-4 w-4" alt="wa" />
                        Konsultasi dengan Notaris
                    </a>
                </div>
            </div>
        </Teleport>

    </MainLayout>
</template>