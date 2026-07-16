<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import FooterCTA from '@/Components/FooterCTA.vue';
import { useI18n } from "vue-i18n";
import { useWhatsapp } from "@/Composables/useWhatsapp.js";

const { t } = useI18n();
const { buildWhatsappLink } = useWhatsapp("default");

defineProps({
    service: Object
});

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
};
</script>

<template>
    <MainLayout>
        <div class="bg-gray-50 py-12 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="text-sm mb-4" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex flex-wrap gap-y-2">
                        <li class="flex items-center">
                            <a href="/" class="text-gray-500 hover:text-primary">{{ t("services.layananDetail.breadcrumb.beranda") }}</a>
                            <span class="mx-2 text-gray-400">/</span>
                        </li>
                        <li class="flex items-center">
                            <a href="/layanan" class="text-gray-500 hover:text-primary">{{ t("services.layananDetail.breadcrumb.layanan") }}</a>
                            <span class="mx-2 text-gray-400">/</span>
                        </li>
                        <li class="flex items-center text-gray-800">
                            {{ service.name }}
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-secondary mb-4">{{ service.name }}</h1>
                <div class="text-2xl font-semibold text-primary">{{ t("services.layananDetail.price_prefix") }} {{ formatPrice(service.price) }}</div>
            </div>
        </div>

        <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold mb-4">{{ t("services.layananDetail.deskripsi_title") }}</h2>
                <div class="prose max-w-none text-gray-700">
                    <p>{{ service.description }}</p>
                    <p class="mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-xl shadow border border-gray-100 p-6 lg:sticky lg:top-24">
                    <h3 class="text-xl font-bold mb-4">{{ t("services.layananDetail.sidebar.title") }}</h3>
                    <p class="text-gray-600 mb-6">{{ t("services.layananDetail.sidebar.desc") }}</p>
                    <a href="/kontak" class="block w-full text-center bg-primary hover:bg-pink-600 text-white font-semibold py-3 rounded-lg transition mb-3">
                        {{ t("services.layananDetail.sidebar.konsultasi_cta") }}
                    </a>
                    <a :href="buildWhatsappLink(service.name)" target="_blank" rel="noopener noreferrer" class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-lg transition">
                        {{ t("services.layananDetail.sidebar.whatsapp_cta") }}
                    </a>
                </div>
            </div>
        </div>

        <FooterCTA
            :title="t('services.layananDetail.footer.title')"
            :description="t('services.layananDetail.footer.desc')"
            :button-text="t('services.layananDetail.footer.cta')"
            :whatsapp-link="buildWhatsappLink(service.name)"
        />
    </MainLayout>
</template>
