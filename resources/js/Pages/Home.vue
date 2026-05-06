<script setup>
import { ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';

// Keep the PT checker logic just in case, though the image hero has it as a small search bar or button.
// The image shows "Cek Nama PT" as a small search bar right below the hero.
const ptName = ref('');
const isChecking = ref(false);
const checkResult = ref(null);

const checkPT = () => {
    if (!ptName.value) return;
    isChecking.value = true;
    checkResult.value = null;
    setTimeout(() => {
        isChecking.value = false;
        const isAvailable = Math.random() > 0.5;
        checkResult.value = {
            available: isAvailable,
            message: isAvailable 
                ? `Nama PT "${ptName.value}" tersedia.`
                : `Nama PT "${ptName.value}" sudah digunakan.`
        };
    }, 1500);
};
</script>

<template>
    <MainLayout>
        <!-- 1. Hero Section -->
        <section class="relative bg-gradient-to-r from-secondary to-gray-800 pt-20 pb-24 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center">
                <div class="w-full md:w-1/2 text-white md:pr-10">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                        Mulai Usaha dengan Benar
                    </h1>
                    <p class="text-lg text-gray-300 mb-8 max-w-lg">
                        Wujudkan impian bisnis Anda! FASTTRACK siap membantu Anda mengurus legalitas usaha dengan cepat, transparan, dan terpercaya di seluruh Indonesia.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="/kontak" class="bg-primary hover:bg-pink-600 text-white font-bold py-3 px-8 rounded-full transition shadow-lg">
                            Konsultasi Gratis &rarr;
                        </a>
                        <a href="#layanan" class="bg-transparent border border-white text-white hover:bg-white hover:text-secondary font-bold py-3 px-8 rounded-full transition">
                            Lihat Layanan
                        </a>
                    </div>
                </div>
                <div class="w-full md:w-1/2 mt-10 md:mt-0 flex justify-center md:justify-end">
                    <!-- Placeholder for person image -->
                    <img src="https://placehold.co/500x500/1F2937/FFFFFF?text=Hero+Image" alt="Hero" class="rounded-lg shadow-2xl max-w-full h-auto object-cover border-4 border-gray-700">
                </div>
            </div>
            
            <!-- PT Checker Bar (Floating below hero) -->
            <!-- <div class="absolute bottom-0 left-0 w-full transform translate-y-1/2 flex justify-center px-4">
                <div class="bg-white rounded-full shadow-xl border border-gray-200 p-2 flex items-center max-w-3xl w-full">
                    <form @submit.prevent="checkPT" class="flex w-full items-center">
                        <div class="px-4 text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input v-model="ptName" type="text" placeholder="Cek Ketersediaan Nama PT Anda..." class="flex-grow border-none focus:ring-0 text-gray-700 placeholder-gray-400 py-2">
                        <button type="submit" class="bg-primary text-white font-bold py-2 px-6 rounded-full hover:bg-pink-600 transition" :disabled="isChecking">
                            {{ isChecking ? 'Mengecek...' : 'Cek Sekarang' }}
                        </button>
                    </form>
                </div>
            </div> -->
        </section>

        <!-- Result Checker Placeholder -->
        <!-- <div v-if="checkResult" class="max-w-3xl mx-auto mt-12 px-4">
            <div :class="checkResult.available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="p-4 rounded-lg text-center font-semibold">
                {{ checkResult.message }}
            </div>
        </div> -->

        <!-- 2. Services Section -->
        <section id="layanan" class="pt-24 pb-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-10">
                    <h2 class="text-3xl font-bold text-secondary">Pilih layanan sesuai dengan kebutuhan Anda</h2>
                    <a href="/layanan" class="hidden md:inline-block text-primary font-semibold hover:underline">Lihat Semua Layanan &rarr;</a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Service Card 1 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col">
                        <img src="https://placehold.co/400x250/F3F4F6/1F2937?text=Pendirian+PT" class="w-full h-40 object-cover" alt="PT">
                        <div class="p-5 flex-grow flex flex-col">
                            <span class="inline-block bg-pink-100 text-primary text-xs font-bold px-2 py-1 rounded mb-3 w-max">POPULER</span>
                            <h3 class="font-bold text-lg mb-2">Pendirian PT</h3>
                            <p class="text-gray-600 text-sm mb-4 flex-grow">Proses cepat, dokumen lengkap, harga transparan untuk perusahaan Anda.</p>
                            <div class="border-t border-gray-100 pt-4 mt-auto">
                                <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                                <p class="font-bold text-primary mb-3">Rp 3.500.000</p>
                                <a href="/layanan/pendirian-pt" class="block w-full text-center border border-primary text-primary hover:bg-primary hover:text-white py-2 rounded font-semibold text-sm transition">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Service Card 2 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col">
                        <img src="https://placehold.co/400x250/F3F4F6/1F2937?text=Virtual+Office" class="w-full h-40 object-cover" alt="VO">
                        <div class="p-5 flex-grow flex flex-col">
                            <span class="inline-block bg-pink-100 text-primary text-xs font-bold px-2 py-1 rounded mb-3 w-max">TERLARIS</span>
                            <h3 class="font-bold text-lg mb-2">Virtual Office</h3>
                            <p class="text-gray-600 text-sm mb-4 flex-grow">Alamat bisnis prestisius di lokasi strategis Jakarta.</p>
                            <div class="border-t border-gray-100 pt-4 mt-auto">
                                <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                                <p class="font-bold text-primary mb-3">Rp 2.000.000 / thn</p>
                                <a href="/layanan/virtual-office" class="block w-full text-center border border-primary text-primary hover:bg-primary hover:text-white py-2 rounded font-semibold text-sm transition">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Service Card 3 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col">
                        <img src="https://placehold.co/400x250/F3F4F6/1F2937?text=Pendirian+CV" class="w-full h-40 object-cover" alt="CV">
                        <div class="p-5 flex-grow flex flex-col">
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs font-bold px-2 py-1 rounded mb-3 w-max">UMKM</span>
                            <h3 class="font-bold text-lg mb-2">Pendirian CV</h3>
                            <p class="text-gray-600 text-sm mb-4 flex-grow">Solusi legalitas untuk badan usaha menengah ke bawah dengan biaya hemat.</p>
                            <div class="border-t border-gray-100 pt-4 mt-auto">
                                <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                                <p class="font-bold text-primary mb-3">Rp 2.500.000</p>
                                <a href="/layanan/pendirian-cv" class="block w-full text-center border border-primary text-primary hover:bg-primary hover:text-white py-2 rounded font-semibold text-sm transition">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Service Card 4 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col">
                        <img src="https://placehold.co/400x250/F3F4F6/1F2937?text=Perizinan" class="w-full h-40 object-cover" alt="Izin">
                        <div class="p-5 flex-grow flex flex-col">
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs font-bold px-2 py-1 rounded mb-3 w-max">KHUSUS</span>
                            <h3 class="font-bold text-lg mb-2">Izin Usaha Tambahan</h3>
                            <p class="text-gray-600 text-sm mb-4 flex-grow">Pengurusan izin khusus untuk berbagai sektor bisnis sesuai regulasi terbaru.</p>
                            <div class="border-t border-gray-100 pt-4 mt-auto">
                                <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                                <p class="font-bold text-primary mb-3">Hubungi Kami</p>
                                <a href="/kontak" class="block w-full text-center border border-primary text-primary hover:bg-primary hover:text-white py-2 rounded font-semibold text-sm transition">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Promos Section -->
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-8">
                    <h2 class="text-2xl font-bold text-secondary">Dapatkan Penawaran Menarik dari Kami!</h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div v-for="i in 4" :key="i" class="bg-gray-800 rounded-lg p-4 text-white hover:bg-secondary transition cursor-pointer">
                        <div class="text-xs text-primary font-bold mb-1">PROMO SPESIAL</div>
                        <h3 class="font-bold text-lg mb-1">HEMAT HINGGA 30%</h3>
                        <p class="text-xs text-gray-300">Untuk pendirian PT + Virtual Office bulan ini.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. About Section -->
        <section class="py-16 bg-gray-50 border-y border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center gap-12">
                    <div class="w-full md:w-1/2">
                        <img src="https://placehold.co/600x400/E5E7EB/1F2937?text=Kantor+Kami" alt="About" class="rounded-xl shadow-lg w-full">
                    </div>
                    <div class="w-full md:w-1/2">
                        <h2 class="text-3xl font-bold mb-6 text-secondary">Tentang FASTTRACK</h2>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            FASTTRACK adalah perusahaan konsultan legalitas yang berpengalaman membantu ribuan pengusaha di Indonesia. Kami memberikan solusi tepat, cepat, dan sesuai hukum untuk pendirian perusahaan, perizinan, hingga penyediaan alamat bisnis (Virtual Office).
                        </p>
                        <p class="text-gray-600 mb-8 leading-relaxed">
                            Dedikasi kami adalah menjadi partner pertumbuhan bisnis Anda dengan proses yang 100% transparan dan bisa dilacak secara real-time.
                        </p>
                        
                        <div class="grid grid-cols-3 gap-4 border-t border-gray-200 pt-8">
                            <div class="text-center">
                                <div class="text-3xl font-extrabold text-primary mb-1">12+</div>
                                <div class="text-sm text-gray-500 font-medium">Tahun Pengalaman</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-extrabold text-primary mb-1">40+</div>
                                <div class="text-sm text-gray-500 font-medium">Lokasi Virtual Office</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-extrabold text-primary mb-1">10.000+</div>
                                <div class="text-sm text-gray-500 font-medium">Klien Puas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. Transparansi Section -->
        <section class="py-20 bg-secondary text-white overflow-hidden relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center relative z-10">
                <div class="w-full md:w-1/2 mb-10 md:mb-0 md:pr-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Transparansi Pelaksanaan Layanan Real-time</h2>
                    <p class="text-gray-300 mb-8 text-lg">
                        Lacak setiap proses perizinan Anda langsung dari smartphone. Kami menyediakan dashboard khusus untuk memastikan Anda selalu mendapatkan update terkini tanpa harus bertanya.
                    </p>
                    <a href="/kontak" class="bg-primary hover:bg-pink-600 text-white font-bold py-3 px-8 rounded-full transition inline-block">
                        Mulai Sekarang
                    </a>
                </div>
                <div class="w-full md:w-1/2 flex justify-center">
                    <img src="https://placehold.co/300x600/1F2937/FFFFFF?text=App+Mockup" alt="App Mockup" class="rounded-3xl shadow-2xl border-8 border-gray-800 transform rotate-2 hover:rotate-0 transition duration-500">
                </div>
            </div>
        </section>

        <!-- 6. Features Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-secondary">Fitur FASTTRACK</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div v-for="i in 4" :key="i" class="text-center">
                        <div class="w-16 h-16 mx-auto bg-pink-50 rounded-full flex items-center justify-center mb-4 text-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Proses Cepat & Tepat</h3>
                        <p class="text-gray-500 text-sm">Tim ahli kami memproses dokumen Anda sesuai SLA yang dijanjikan.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. Blog Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-8">
                    <h2 class="text-3xl font-bold text-secondary">BLOG</h2>
                    <a href="/artikel" class="text-primary font-semibold hover:underline">Lihat Semua &rarr;</a>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Post -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col md:flex-row">
                        <img src="https://placehold.co/400x300/E5E7EB/1F2937?text=Blog+Image" class="w-full md:w-1/2 h-48 md:h-auto object-cover" alt="Blog">
                        <div class="p-6 flex flex-col justify-center w-full md:w-1/2">
                            <div class="text-xs text-gray-500 mb-2">12 Mei 2024</div>
                            <h3 class="text-xl font-bold mb-3 hover:text-primary cursor-pointer transition">Panduan Lengkap Mendirikan PT Tahun 2024</h3>
                            <p class="text-gray-600 text-sm mb-4">Mendirikan Perseroan Terbatas kini semakin mudah dengan adanya sistem OSS. Pelajari langkah-langkahnya.</p>
                            <a href="#" class="text-primary font-semibold text-sm hover:underline mt-auto">Baca Selengkapnya &rarr;</a>
                        </div>
                    </div>
                    
                    <!-- Sidebar List -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h4 class="font-bold text-lg mb-4 border-b border-gray-100 pb-2">Artikel Terbaru</h4>
                        <ul class="space-y-4">
                            <li v-for="i in 4" :key="i" class="flex flex-col">
                                <a href="#" class="font-semibold hover:text-primary transition text-sm mb-1">Perbedaan PT dan CV: Mana yang Cocok Untuk Bisnis Anda?</a>
                                <span class="text-xs text-gray-500">10 Mei 2024</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- 8. Form & Map Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-secondary">Spesial Promo & Penawaran Menarik</h2>
                    <p class="text-gray-600 mt-2">Tinggalkan kontak Anda, tim kami akan segera menghubungi.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
                    <!-- Form -->
                    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
                        <form @submit.prevent class="space-y-4">
                            <div>
                                <input type="text" placeholder="Nama Lengkap" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                            </div>
                            <div>
                                <input type="email" placeholder="Alamat Email" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                            </div>
                            <div>
                                <input type="tel" placeholder="Nomor WhatsApp" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none" required>
                            </div>
                            <div>
                                <textarea rows="3" placeholder="Pesan / Kebutuhan Layanan" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none" required></textarea>
                            </div>
                            <button type="submit" class="w-full bg-primary hover:bg-pink-600 text-white font-bold py-4 rounded-lg transition shadow-md">
                                Dapatkan Penawaran
                            </button>
                        </form>
                    </div>
                    
                    <!-- Map -->
                    <div class="h-full min-h-[400px] rounded-xl overflow-hidden shadow-lg border border-gray-100">
                        <!-- Placeholder Map -->
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center relative">
                            <img src="https://placehold.co/800x600/E5E7EB/A3A8B8?text=Map+Location" class="absolute inset-0 w-full h-full object-cover opacity-50" alt="Map">
                            <div class="relative z-10 bg-white p-4 rounded-lg shadow-md text-center">
                                <h4 class="font-bold text-secondary">Head Office FASTTRACK</h4>
                                <p class="text-sm text-gray-500 mt-1">Sudirman, Jakarta Selatan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </MainLayout>
</template>
