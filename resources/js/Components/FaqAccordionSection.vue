<script setup>
import { ref, computed, watch } from "vue";

const props = defineProps({
    faq: {
        type: Array,
        default: () => [],
    },
    title: {
        type: String,
        default: "FAQ",
    },
    visibleLimit: {
        type: Number,
        default: 5,
    },
});

const openIndex = ref(null);
const showAll = ref(false);

const toggle = (index) => {
    openIndex.value = openIndex.value === index ? null : index;
};

const hasMore = computed(() => props.faq.length > props.visibleLimit);
const visibleFaq = computed(() =>
    showAll.value ? props.faq : props.faq.slice(0, props.visibleLimit),
);

// Kalau data faq berganti (mis. pindah halaman produk), reset ke kondisi awal
watch(
    () => props.faq,
    () => {
        showAll.value = false;
        openIndex.value = null;
    },
);
</script>

<template>
    <div
        v-if="faq.length"
        class="rounded-2xl border border-[#E8E8E6] bg-white overflow-hidden"
    >
        <div class="flex items-center gap-3 p-6 sm:p-8 pb-0">
            <img src="/icons/ic-menu-arrow.svg" class="w-6 h-6" alt="" />
            <h2 class="text-[15px] font-bold uppercase tracking-widest text-black">
                {{ title }}
            </h2>
        </div>

        <div class="divide-y divide-[#E8E8E6] mt-4">
            <div v-for="(item, index) in visibleFaq" :key="`faq-${index}`">
                <button
                    @click="toggle(index)"
                    class="w-full flex items-center justify-between gap-4 px-6 sm:px-8 py-5 text-left"
                >
                    <span class="text-sm font-bold text-[#1A1B18]">{{
                        item.question
                    }}</span>
                    <svg
                        class="h-5 w-5 text-[#686964] flex-shrink-0 transition-transform duration-200"
                        :class="openIndex === index ? 'rotate-180' : ''"
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
                    v-show="openIndex === index"
                    class="px-6 sm:px-8 pb-6 text-[13px] leading-[1.7] text-[#3D3D3A] text-justify whitespace-pre-line"
                >
                    {{ item.answer }}
                </div>
            </div>
        </div>

        <div v-if="hasMore" class="border-t border-[#E8E8E6] p-6 sm:p-8 pt-5">
            <button
                @click="showAll = !showAll"
                class="w-full sm:w-auto mx-auto flex items-center justify-center gap-2 rounded-lg border border-primary px-5 py-2.5 text-[13px] font-semibold text-primary hover:bg-primary hover:text-white transition-colors"
            >
                {{ showAll ? "Tampilkan Lebih Sedikit" : "Lihat Lainnya" }}
                <svg
                    class="h-4 w-4 transition-transform duration-200"
                    :class="showAll ? 'rotate-180' : ''"
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
        </div>
    </div>
</template>
