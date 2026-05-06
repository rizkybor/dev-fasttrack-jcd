<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
    services: Array
});

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
};
</script>

<template>
    <MainLayout>
        <div class="bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <h1 class="text-3xl md:text-4xl font-bold text-secondary mb-4">Layanan Legalitas & Perizinan</h1>
                    <p class="text-gray-600">Pilih layanan yang sesuai dengan kebutuhan bisnis Anda. Kami siap membantu proses dari awal hingga selesai.</p>
                </div>
            </div>
        </div>

        <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="service in services" :key="service.id" class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden flex flex-col">
                    <div class="p-6 flex-grow">
                        <h2 class="text-2xl font-bold text-secondary mb-2">{{ service.name }}</h2>
                        <p class="text-gray-600 line-clamp-3">{{ service.description }}</p>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div class="text-lg font-semibold text-primary mb-3">Mulai dari {{ formatPrice(service.price) }}</div>
                        <a :href="`/layanan/${service.slug}`" class="block w-full text-center bg-white border border-primary text-primary hover:bg-primary hover:text-white font-medium py-2 rounded transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
