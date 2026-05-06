<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
</script>

<template>
    <MainLayout>
        <div class="bg-gray-50 py-12 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-secondary mb-4">Hubungi Kami</h1>
                <p class="text-gray-600 max-w-2xl mx-auto">Konsultasikan kebutuhan legalitas bisnis Anda dengan tim ahli kami. Kami siap membantu kapan saja.</p>
            </div>
        </div>

        <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 xl:grid-cols-[0.95fr_1.05fr] gap-12">
            <div>
                <h2 class="text-2xl font-bold mb-6">Formulir Konsultasi</h2>
                <form @submit.prevent class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                        <input type="tel" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Layanan yang Dibutuhkan</label>
                        <select class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                            <option value="">Pilih Layanan</option>
                            <option value="pt">Pendirian PT</option>
                            <option value="cv">Pendirian CV</option>
                            <option value="vo">Virtual Office</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                        <textarea rows="4" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary outline-none" required></textarea>
                    </div>
                    <button type="submit" class="bg-primary hover:bg-pink-600 text-white font-semibold py-3 px-6 rounded-lg transition w-full">
                        Kirim Pesan
                    </button>
                </form>
            </div>
            
            <div>
                <h2 class="text-2xl font-bold mb-6">Informasi Kontak</h2>
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-gray-900">Head Office</h3>
                                <p class="mt-2 text-gray-600 leading-7">Grand Bintaro Blok A7, Jl. Raya Bintaro Permai, Pesanggrahan, Bintaro, Jakarta Selatan - 12330</p>
                                <div class="mt-4 space-y-2 text-gray-600">
                                    <p><strong class="text-secondary">Telp.</strong> 021 73885036</p>
                                    <p><strong class="text-secondary">WhatsApp</strong> 0822 9860 4144</p>
                                    <p><strong class="text-secondary">Email</strong> cs@fasttrack.legal</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-900">Surabaya Office</h3>
                            <p class="mt-3 text-gray-600 leading-7">Jl. Taman Pondok Legi III, Blok Y No. 1A, Peplegi, Waru, Kab. Sidoarjo, Jawa Timur 61256</p>
                            <p class="mt-4 text-gray-600"><strong class="text-secondary">Tel.</strong> (62-31) 58285209</p>
                        </div>

                        <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-900">Bali Office</h3>
                            <p class="mt-3 text-gray-600 leading-7">Jl. By Pass Ngurah Rai No. 264, Sanur, Denpasar - Bali 80228</p>
                            <p class="mt-4 text-gray-600"><strong class="text-secondary">Tel.</strong> (62-361) 282105, 270067</p>
                            <p class="mt-2 text-gray-600"><strong class="text-secondary">Fax.</strong> (62-361) 270067</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
