<script setup>
import { ref, computed, watch } from "vue";

const props = defineProps({
    modelValue: { type: Boolean, default: false },
    prefillName: { type: String, default: "" },
});

const emit = defineEmits(["update:modelValue"]);
const close = () => emit("update:modelValue", false);

const namaPT = ref(props.prefillName);
const namaLengkap = ref("");
const email = ref("");
const telepon = ref("");

// track apakah field sudah pernah disentuh
const touchedEmail = ref(false);
const touchedTelepon = ref(false);

watch(
    () => props.prefillName,
    (val) => {
        namaPT.value = val;
    },
);

const namaPTError = computed(() => {
    if (!namaPT.value.trim()) return "";
    const words = namaPT.value.trim().split(/\s+/).filter(Boolean);
    const latinOnly = /^[a-zA-Z\s]+$/.test(namaPT.value.trim());
    if (!latinOnly) return "Gunakan huruf Latin saja, tanpa angka atau simbol";
    if (words.length < 3)
        return `Minimal 3 kata (saat ini ${words.length} kata)`;
    return "";
});

const emailError = computed(() => {
    if (!touchedEmail.value || !email.value.trim()) return "";
    const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim());
    if (!valid) return "Format email tidak valid, contoh: nama@email.com";
    return "";
});

const teleponError = computed(() => {
    if (!touchedTelepon.value || !telepon.value.trim()) return "";
    const digits = telepon.value.replace(/[\s\-]/g, "");
    const valid = /^(\+62|62|0)[0-9]{8,13}$/.test(digits);
    if (!valid)
        return "Format tidak valid, contoh: 08123456789 atau +6281234567890";
    return "";
});

const isValid = computed(() => {
    const words = namaPT.value.trim().split(/\s+/).filter(Boolean);
    const latinOnly = /^[a-zA-Z\s]+$/.test(namaPT.value.trim());
    const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim());
    const digits = telepon.value.replace(/[\s\-]/g, "");
    const teleponOk = /^(\+62|62|0)[0-9]{8,13}$/.test(digits);
    return (
        words.length >= 3 &&
        latinOnly &&
        namaLengkap.value.trim() !== "" &&
        emailOk &&
        teleponOk
    );
});

const waNumber = "6281234567890";

const submit = () => {
    if (!isValid.value) return;
    const msg = encodeURIComponent(
        `Halo FastTrack, saya ingin mengecek ketersediaan nama PT berikut:\n\nNama PT: ${namaPT.value}\nNama Lengkap: ${namaLengkap.value}\nEmail: ${email.value}\nNo. Telepon: ${telepon.value}`,
    );
    window.open(`https://wa.me/${waNumber}?text=${msg}`, "_blank");
};
</script>

<template>
    <transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0"
        enter-to-class="opacity-100" leave-active-class="transition duration-150 ease-in" leave-from-class="opacity-100"
        leave-to-class="opacity-0">
        <div v-if="modelValue"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            @click.self="close">
            <transition enter-active-class="transition duration-250 ease-out"
                enter-from-class="opacity-0 scale-95 translate-y-2" enter-to-class="opacity-100 scale-100 translate-y-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 scale-100 translate-y-0"
                leave-to-class="opacity-0 scale-95 translate-y-2">
                <div v-if="modelValue"
                    class="relative w-full max-w-[540px] bg-white rounded-2xl shadow-2xl overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-start gap-3 px-6 pt-6 pb-5">
                        
                            <img src="/icons/ic-tools-sedianamapt.svg" alt="Generator Nama" class="w-10 h-10" />
                        <div class="flex-1 min-w-0">
                            <h2 class="text-[16px] font-bold leading-snug text-[#1A1B18]">
                                Cek Ketersediaan Nama PT
                            </h2>
                            <p class="mt-0.5 text-[13px] text-[#42443D] leading-relaxed">
                                Cek ketersediaan nama PT Anda sebelum mendaftar
                                ke AHU Kemenkum RI.
                            </p>
                        </div>
                        <button type="button"
                            class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg text-[#9e1f16] hover:bg-[#FEF0F0] transition-colors"
                            @click="close" aria-label="Tutup">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="h-px bg-[#E5E5E0] mx-6"></div>

                    <!-- Body -->
                    <div class="px-6 py-5 space-y-3">
                        <!-- Nama PT -->
                        <div>
                            <label class="block text-[13px] font-semibold text-[#1A1B18] mb-1.5">
                                Masukkan Nama PT
                            </label>
                            <input v-model="namaPT" type="text" placeholder="Contoh: Maju Bersama Digital"
                                class="w-full h-11 px-4 rounded-xl border text-[14px] text-[#1A1B18] placeholder-[#AAAAAA] outline-none transition-all"
                                :class="namaPTError
                                        ? 'border-[#9e1f16] bg-[#FEF8F8] focus:ring-2 focus:ring-[#9e1f16]/10'
                                        : 'border-[#D9DAD8] bg-white focus:border-[#22C55E] focus:ring-2 focus:ring-[#22C55E]/10'
                                    " />
                            <p v-if="namaPTError" class="mt-1.5 text-[12px] text-[#9e1f16]">
                                {{ namaPTError }}
                            </p>
                            <p v-else class="mt-1.5 text-[12px] text-[#42443D]">
                                Minimal 3 kata, huruf Latin, tanpa angka atau
                                simbol
                            </p>
                        </div>

                        <!-- Nama Lengkap -->
                        <input v-model="namaLengkap" type="text" placeholder="Nama Lengkap*"
                            class="w-full h-11 px-4 rounded-xl border border-[#D9DAD8] bg-white text-[14px] text-[#1A1B18] placeholder-[#AAAAAA] outline-none focus:border-[#22C55E] focus:ring-2 focus:ring-[#22C55E]/10 transition-all" />

                        <!-- Email -->
                        <div>
                            <input v-model="email" type="email" placeholder="Alamat Email*"
                                class="w-full h-11 px-4 rounded-xl border text-[14px] text-[#1A1B18] placeholder-[#AAAAAA] outline-none transition-all"
                                :class="emailError
                                        ? 'border-[#9e1f16] bg-[#FEF8F8] focus:ring-2 focus:ring-[#9e1f16]/10'
                                        : 'border-[#D9DAD8] bg-white focus:border-[#22C55E] focus:ring-2 focus:ring-[#22C55E]/10'
                                    " @blur="touchedEmail = true" />
                            <p v-if="emailError" class="mt-1.5 text-[12px] text-[#9e1f16]">
                                {{ emailError }}
                            </p>
                            <p v-else class="mt-1.5 text-[12px] text-[#42443D]">
                                Contoh: nama@email.com
                            </p>
                        </div>

                        <!-- Telepon -->
                        <div>
                            <input v-model="telepon" type="tel" placeholder="Nomor Telepon / Whatsapp*"
                                class="w-full h-11 px-4 rounded-xl border text-[14px] text-[#1A1B18] placeholder-[#AAAAAA] outline-none transition-all"
                                :class="teleponError
                                        ? 'border-[#9e1f16] bg-[#FEF8F8] focus:ring-2 focus:ring-[#9e1f16]/10'
                                        : 'border-[#D9DAD8] bg-white focus:border-[#22C55E] focus:ring-2 focus:ring-[#22C55E]/10'
                                    " @blur="touchedTelepon = true" />
                            <p v-if="teleponError" class="mt-1.5 text-[12px] text-[#9e1f16]">
                                {{ teleponError }}
                            </p>
                            <p v-else class="mt-1.5 text-[12px] text-[#42443D]">
                                Contoh: 08123456789 atau +6281234567890
                            </p>
                        </div>
                    </div>

                    <div class="h-px bg-[#E5E5E0] mx-6"></div>

                    <!-- Footer CTA -->
                    <div class="px-6 py-4">
                        <button type="button"
                            class="w-full h-12 rounded-xl font-semibold text-[14px] flex items-center justify-center gap-2 transition-all"
                            :class="isValid
                                    ? 'bg-[#22C55E] hover:bg-[#16A34A] text-white shadow-sm hover:shadow-md active:scale-[0.98]'
                                    : 'bg-[#E5E5E0] text-[#AAAAAA] cursor-not-allowed'
                                " :disabled="!isValid" @click="submit">
                            Konsultasikan Nama ini via Whatsapp
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>
