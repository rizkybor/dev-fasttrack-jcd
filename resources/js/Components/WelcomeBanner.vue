<script setup>
import { onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useWhatsapp } from "@/Composables/useWhatsapp.js";

const STORAGE_KEY = "welcome_banner_seen";

const page = usePage();

const isVisible = ref(false);

const { buildWhatsappLink } = useWhatsapp("default");

const whatsappLink = buildWhatsappLink("Konsultasi Layanan FastTrack");

const closeBanner = () => {
    isVisible.value = false;
};

onMounted(() => {
    // Diatur dari server: config/welcome-banner.php (enabled + rentang tanggal aktif)
    if (!page.props.welcomeBanner?.active) return;
    if (sessionStorage.getItem(STORAGE_KEY)) return;

    isVisible.value = true;
    sessionStorage.setItem(STORAGE_KEY, "1");
});
</script>

<template>
    <Transition
        enter-active-class="transition-opacity duration-500 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-500 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="isVisible"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-8"
        >
            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/70"></div>

            <!-- Banner Card -->
            <div class="relative z-[5] w-fit max-w-full sm:max-w-2xl">
                <!-- Close Button -->
                <button
                    type="button"
                    @click="closeBanner"
                    aria-label="Tutup banner"
                    class="absolute -right-3 -top-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-white text-[#1A1B18] shadow-lg transition-colors hover:bg-white/90"
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
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>

                <!-- Clickable Banner Image -->
                <a
                    :href="whatsappLink"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="block overflow-hidden rounded-2xl shadow-2xl"
                >
                    <img
                        src="/images/welcome/welcome-banner.jpeg"
                        alt="Welcome to FastTrack"
                        class="block max-h-[85vh] w-auto max-w-full object-contain"
                    />
                </a>
            </div>
        </div>
    </Transition>
</template>
