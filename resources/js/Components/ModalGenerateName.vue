<script setup>
import { ref, computed } from "vue";

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["update:modelValue", "check-name"]);

const close = () => emit("update:modelValue", false);

const keyword = ref("");
const selectedBidang = ref("");
const isLoading = ref(false);
const results = ref([]);
const hasGenerated = ref(false);

const bidangOptions = [
    "IT Services",
    "Perdagangan Umum",
    "Konstruksi",
    "Properti",
    "Manufaktur",
    "Konsultan",
    "Kesehatan",
    "Pendidikan",
    "Kuliner & F&B",
    "Logistik",
    "Keuangan",
    "Media & Kreatif",
];

const canGenerate = computed(
    () => keyword.value.trim() && selectedBidang.value,
);

const mockNames = (kw, bidang) => {
    const prefixes = [
        "Cahaya",
        "Maju",
        "Prima",
        "Karya",
        "Sentosa",
        "Nusa",
        "Bumi",
        "Cipta",
        "Artha",
        "Mulia",
    ];
    const suffixes = [
        "Mandiri",
        "Sejahtera",
        "Abadi",
        "Jaya",
        "Utama",
        "Persada",
        "Nusantara",
        "Indonesia",
        "Pratama",
        "Solusi",
    ];
    const generated = [];
    const used = new Set();
    while (generated.length < 5) {
        const p = prefixes[Math.floor(Math.random() * prefixes.length)];
        const s = suffixes[Math.floor(Math.random() * suffixes.length)];
        const name = `PT ${p} ${kw.charAt(0).toUpperCase() + kw.slice(1)} ${s}`;
        if (!used.has(name)) {
            used.add(name);
            generated.push(name);
        }
    }
    return generated;
};

const generate = async () => {
    if (!canGenerate.value || isLoading.value) return;
    isLoading.value = true;
    results.value = [];
    await new Promise((r) => setTimeout(r, 1400));
    results.value = mockNames(keyword.value.trim(), selectedBidang.value);
    hasGenerated.value = true;
    isLoading.value = false;
};

const reset = () => {
    results.value = [];
    hasGenerated.value = false;
};
</script>

<template>
    <transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="modelValue"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            @click.self="close"
        >
            <transition
                enter-active-class="transition duration-250 ease-out"
                enter-from-class="opacity-0 scale-95 translate-y-2"
                enter-to-class="opacity-100 scale-100 translate-y-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 scale-100 translate-y-0"
                leave-to-class="opacity-0 scale-95 translate-y-2"
            >
                <div
                    v-if="modelValue"
                    class="relative w-full max-w-[520px] bg-white rounded-2xl shadow-2xl overflow-hidden"
                >
                    <!-- Header -->
                    <div class="flex items-start gap-3 px-6 pt-6 pb-5">
                        <div
                            class="flex-shrink-0 w-11 h-11 rounded-xl bg-[#EAF4FF] flex items-center justify-center"
                        >
                            <svg
                                class="w-6 h-6 text-[#1A73E8]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h2
                                class="text-[16px] font-bold leading-snug text-[#1A1B18]"
                            >
                                Generator Nama
                            </h2>
                            <p
                                class="mt-0.5 text-[13px] text-[#42443D] leading-relaxed"
                            >
                                Kesulitan menemukan nama Perusahaan untuk PT
                                yang mau kamu buat?, yuk coba fitur Generator
                                Nama kami :
                            </p>
                        </div>
                        <button
                            type="button"
                            class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg text-[#9e1f16] hover:bg-[#FEF0F0] transition-colors"
                            @click="close"
                            aria-label="Tutup"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>

                    <div class="h-px bg-[#E5E5E0] mx-6"></div>

                    <!-- Body -->
                    <div
                        class="px-6 py-5 space-y-3 max-h-[100vh] overflow-y-auto overscroll-contain"
                    >
                        <!-- Kata kunci -->
                        <div>
                            <label
                                class="block text-[13px] font-semibold text-[#1A1B18] mb-1.5"
                            >
                                Masukkan 1 Kata Kunci
                            </label>
                            <input
                                v-model="keyword"
                                type="text"
                                placeholder="Contoh: Teknologi"
                                class="w-full h-11 px-4 rounded-xl border border-[#D9DAD8] bg-white text-[14px] text-[#1A1B18] placeholder-[#AAAAAA] outline-none focus:border-[#9e1f16] focus:ring-2 focus:ring-[#9e1f16]/10 transition-all"
                                @keydown.enter="generate"
                            />
                        </div>

                        <!-- Bidang Usaha -->
                        <div class="relative">
                            <select
                                v-model="selectedBidang"
                                class="w-full h-11 px-4 pr-10 rounded-xl border border-[#D9DAD8] bg-white text-[14px] outline-none focus:border-[#9e1f16] focus:ring-2 focus:ring-[#9e1f16]/10 transition-all appearance-none cursor-pointer"
                                :class="
                                    selectedBidang
                                        ? 'text-[#1A1B18]'
                                        : 'text-[#AAAAAA]'
                                "
                            >
                                <option value="" disabled>Bidang Usaha</option>
                                <option
                                    v-for="opt in bidangOptions"
                                    :key="opt"
                                    :value="opt"
                                >
                                    {{ opt }}
                                </option>
                            </select>
                            <div
                                class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[#42443D]"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </div>
                        </div>

                        <!-- Generate button -->
                        <button
                            type="button"
                            class="w-full h-12 rounded-xl font-semibold text-[14px] flex items-center justify-center gap-2 transition-all"
                            :class="
                                canGenerate && !isLoading
                                    ? 'bg-[#9e1f16] hover:bg-[#C8353A] text-white shadow-sm hover:shadow-md active:scale-[0.98]'
                                    : 'bg-[#E5E5E0] text-[#AAAAAA] cursor-not-allowed'
                            "
                            :disabled="!canGenerate || isLoading"
                            @click="generate"
                        >
                            <template v-if="isLoading">
                                <svg
                                    class="w-4 h-4 animate-spin"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    />
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8v8H4z"
                                    />
                                </svg>
                                Sedang Generate...
                            </template>
                            <template v-else>
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 3l14 9-14 9V3z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19 3v4M21 5h-4M19 17v4M21 19h-4"
                                    />
                                </svg>
                                Generate Nama PT
                            </template>
                        </button>

                        <!-- Hasil -->
                        <transition
                            enter-active-class="transition duration-300 ease-out"
                            enter-from-class="opacity-0 translate-y-2"
                            enter-to-class="opacity-100 translate-y-0"
                        >
                            <div
                                v-if="hasGenerated && results.length"
                                class="pt-1"
                            >
                                <div
                                    class="flex items-center justify-between mb-2"
                                >
                                    <span
                                        class="text-[13px] font-semibold text-[#1A1B18]"
                                        >Hasil Rekomendasi</span
                                    >
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-1.5 text-[12.5px] font-semibold text-[#42443D] border border-[#D9DAD8] px-3 py-1.5 rounded-lg hover:border-[#9e1f16] hover:text-[#9e1f16] transition-colors"
                                        @click="generate"
                                    >
                                        <svg
                                            class="w-3.5 h-3.5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2.5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                            />
                                        </svg>
                                        Ulangi
                                    </button>
                                </div>

                                <!-- List hasil dengan scroll -->
                                <div
                                    class="max-h-[250px] overflow-y-auto overscroll-contain space-y-2 pr-1 scrollbar-thin scrollbar-thumb-[#D9DAD8] scrollbar-track-transparent [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:rounded-full [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-[#D9DAD8] hover:[&::-webkit-scrollbar-thumb]:bg-[#AAAAAA]"
                                >
                                    <div
                                        v-for="(name, i) in results"
                                        :key="name"
                                        class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl border border-[#E5E5E0] bg-[#FAFAF8] hover:border-[#9e1f16]/30 hover:bg-[#FEF0F0]/40 transition-all group"
                                        :style="`animation-delay: ${i * 60}ms`"
                                    >
                                        <span
                                            class="text-[13.5px] font-medium text-[#1A1B18]"
                                            >{{ name }}</span
                                        >
                                        <button
                                            type="button"
                                            class="flex-shrink-0 inline-flex items-center gap-1.5 text-[12px] font-semibold text-[#9e1f16] border border-[#9e1f16]/40 px-3 py-1.5 rounded-lg hover:bg-[#9e1f16] hover:text-white transition-all whitespace-nowrap"
                                            @click="emit('check-name', name)"
                                        >
                                            <svg
                                                class="w-3.5 h-3.5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <circle cx="11" cy="11" r="8" />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M21 21l-4.35-4.35"
                                                />
                                            </svg>
                                            Cek Ketersediaan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </transition>

                        <!-- Disclaimer -->
                        <div
                            class="flex gap-2.5 p-3.5 rounded-xl bg-[#EAF4FF] border border-[#B3D4F5]"
                        >
                            <svg
                                class="flex-shrink-0 w-4 h-4 text-[#1A73E8] mt-0.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="12" cy="12" r="10" />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 16v-4M12 8h.01"
                                />
                            </svg>
                            <p
                                class="text-[12px] text-[#1A73E8] leading-relaxed"
                            >
                                Nama PT yang dihasilkan bukan merupakan
                                kepastian bahwa nama yang muncul masih tersedia
                                dan dapat digunakan, wajib dilakukan
                                re-konfirmasi pengecekan nama bersumber dari
                                website Kementrian Hukum Republik Indonesia
                                (Kemenkum RI) melalui sistem administrasi badan
                                hukum (AHU). Anda dapat melakukan pengecekan
                                ketersediaan nama melalui
                                <button
                                    type="button"
                                    class="font-semibold underline underline-offset-2"
                                    @click="emit('check-name', '')"
                                >
                                    Tools Cek Ketersedian Nama PT
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>
