<script setup>
defineProps({
    title: { type: String, required: true },
    description: { type: String, required: true },
    buttonText: { type: String, default: "Chat Langsung via WhatsApp" },
    whatsappLink: { type: String, required: true },
});
</script>

<template>
    <section class="bg-[#F7F7F5] mb-12 sm:mb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-2xl bg-[#9e1f16] px-6 py-12 sm:px-10 sm:py-14">
                <img src="/icons/ft-docs.svg" alt=""
                    class="absolute right-6 top-6 h-16 w-16 opacity-20 sm:right-10 sm:top-8 sm:h-24 sm:w-24" />
                <div class="relative flex flex-col items-center text-center">
                    <h3 class="max-w-2xl text-[22px] font-bold leading-[32px] text-white sm:text-[28px] sm:leading-[38px]">
                        {{ title }}
                    </h3>
                    <p class="mt-4 max-w-lg text-[14px] leading-[22px] text-white/80 sm:text-[16px] sm:leading-[24px]">
                        {{ description }}
                    </p>
                    <a :href="whatsappLink"
                        target="_blank" rel="noopener noreferrer"
                        class="mt-8 inline-flex items-center gap-2.5 rounded-lg bg-[#25D366] px-6 py-3 text-[14px] font-semibold text-white shadow-lg shadow-[#25D366]/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#20BD5A] hover:shadow-xl hover:shadow-[#25D366]/40 sm:px-8 sm:py-3.5 sm:text-[15px]">
                        {{ buttonText }}
                        <img src="/icons/ft-wa.svg" alt="WhatsApp" class="h-5 w-5" />
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>