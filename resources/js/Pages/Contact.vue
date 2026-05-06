<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const jsonLd = {
  "@context": "https://schema.org",
  "@type": "LegalService",
  "name": "FastTrack Legalitas",
  "image": "https://fasttrack.test/logo.png",
  "url": "https://fasttrack.test",
  "telephone": "+6281234567890",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Jl. Sudirman Kav 1",
    "addressLocality": "Jakarta Selatan",
    "postalCode": "12190",
    "addressCountry": "ID"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": -6.225014,
    "longitude": 106.809715
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": [
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday"
    ],
    "opens": "09:00",
    "closes": "17:00"
  },
  "sameAs": [
    "https://facebook.com/fasttrack",
    "https://instagram.com/fasttrack"
  ]
};
</script>

<template>
    <MainLayout>
        <Head>
            <component :is="'script'" type="application/ld+json">
                {{ JSON.stringify(jsonLd) }}
            </component>
        </Head>
        
        <div class="bg-gray-50 py-12 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-secondary mb-4">Hubungi Kami</h1>
                <p class="text-gray-600 max-w-2xl mx-auto">Konsultasikan kebutuhan legalitas bisnis Anda dengan tim ahli kami. Kami siap membantu kapan saja.</p>
            </div>
        </div>

        <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-12">
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
                <div class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">Alamat Kantor</h3>
                            <p class="mt-1 text-gray-600">Gedung Sudirman Center, Lt 5<br>Jl. Sudirman Kav 1<br>Jakarta Selatan 12190</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">Email</h3>
                            <p class="mt-1 text-gray-600">halo@fasttrack.test</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">Telepon / WhatsApp</h3>
                            <p class="mt-1 text-gray-600">0812-3456-7890</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
