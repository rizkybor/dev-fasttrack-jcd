<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
</script>

<template>
    <MainLayout>
        <div class="bg-gray-50 py-12 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-secondary mb-4">Artikel & Edukasi Hukum Bisnis</h1>
                <p class="text-gray-600 max-w-2xl mx-auto">Dapatkan informasi terbaru seputar legalitas, perpajakan, dan regulasi bisnis di Indonesia.</p>
            </div>
        </div>

        <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Mock Articles -->
                <div v-for="i in 6" :key="i" class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                    <div class="h-48 bg-gray-200"></div>
                    <div class="p-6">
                        <div class="text-sm text-primary font-medium mb-2">Legalitas</div>
                        <h2 class="text-xl font-bold text-secondary mb-2 hover:text-primary cursor-pointer transition">Panduan Lengkap Mendirikan PT Tahun 2024</h2>
                        <p class="text-gray-600 line-clamp-3 mb-4">Mendirikan Perseroan Terbatas kini semakin mudah dengan adanya sistem OSS. Berikut adalah langkah-langkah yang perlu Anda perhatikan.</p>
                        <div class="text-sm text-gray-500">12 Mei 2024 &middot; 5 menit baca</div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
