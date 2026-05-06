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
        <section class="relative overflow-hidden bg-gradient-to-br from-secondary via-slate-800 to-slate-900 pt-16 pb-20 sm:pt-20 sm:pb-24 lg:min-h-[52vh] lg:py-16">
            <div class="absolute inset-0 opacity-15">
                <div class="absolute -left-20 top-10 h-44 w-44 rounded-full bg-primary blur-3xl"></div>
                <div class="absolute bottom-0 right-0 h-56 w-56 rounded-full bg-fuchsia-500/20 blur-3xl"></div>
            </div>

            <div class="relative z-10 mx-auto grid max-w-7xl items-center gap-10 px-4 sm:px-6 lg:min-h-[44vh] lg:grid-cols-[1.05fr_0.95fr] lg:gap-12 lg:px-8">
                <div class="text-white">
                    <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-primary backdrop-blur">
                        FastTrack Legalitas Bisnis
                    </div>

                    <h1 class="mt-6 max-w-3xl text-4xl font-extrabold leading-tight sm:text-5xl lg:max-w-2xl lg:text-5xl">
                        Bangun Bisnis Lebih Cepat dengan Legalitas yang Tepat
                    </h1>
                    <p class="mt-5 max-w-2xl text-base leading-7 text-slate-200 sm:text-lg lg:max-w-xl">
                        FASTTRACK membantu pendirian PT, CV, virtual office, perizinan usaha, hingga kebutuhan legal perusahaan dengan alur yang rapi, transparan, dan nyaman diakses dari mana saja.
                    </p>

                    <div class="mt-7 flex flex-col gap-4 sm:flex-row sm:flex-wrap">
                        <a href="/kontak" class="inline-flex items-center justify-center rounded-full bg-primary px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary/30 transition hover:bg-pink-600">
                            Konsultasi Gratis
                        </a>
                        <a href="#layanan" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-8 py-3.5 text-sm font-bold text-white transition hover:bg-white hover:text-secondary">
                            Jelajahi Layanan
                        </a>
                    </div>

                    <div class="mt-8 flex flex-col gap-3 text-sm text-slate-300 sm:flex-row sm:flex-wrap sm:items-center sm:gap-6">
                        <div class="flex items-center gap-3">
                            <span class="h-2.5 w-2.5 rounded-full bg-primary"></span>
                            <span><strong class="font-bold text-white">10.000+</strong> klien bisnis dilayani</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="h-2.5 w-2.5 rounded-full bg-primary"></span>
                            <span><strong class="font-bold text-white">40+</strong> jangkauan kota layanan</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="h-2.5 w-2.5 rounded-full bg-primary"></span>
                            <span><strong class="font-bold text-white">12+</strong> tahun pengalaman tim</span>
                        </div>
                    </div>
                </div>

                <div class="relative flex justify-center lg:justify-end">
                    <div class="relative w-full max-w-xl overflow-hidden rounded-[2rem] border border-white/10 bg-white/10 p-3 shadow-2xl backdrop-blur lg:max-w-[500px]">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1200&q=80&fm=webp" alt="Tim FastTrack sedang berdiskusi tentang legalitas bisnis" class="h-[320px] w-full rounded-[1.5rem] object-cover sm:h-[380px] lg:h-[430px]">
                        <div class="absolute inset-x-5 bottom-5 rounded-[1.5rem] border border-white/10 bg-slate-950/78 p-4 text-white backdrop-blur sm:inset-x-8 sm:bottom-8 sm:p-5">
                            <div class="text-xs font-semibold uppercase tracking-[0.22em] text-primary">Mengapa FastTrack</div>
                            <div class="mt-2 text-lg font-bold leading-snug">Pendampingan legal yang jelas, cepat, dan profesional.</div>
                            <div class="mt-3 text-sm text-slate-300">
                                Setiap proses dibangun agar mudah dipahami klien sejak konsultasi awal hingga dokumen selesai.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="-mt-8 sm:-mt-10 relative z-20 px-4">
            <div class="mx-auto max-w-4xl rounded-[1.75rem] border border-gray-100 bg-white p-4 shadow-2xl sm:p-5">
                <form @submit.prevent="checkPT" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="flex items-center gap-3 rounded-2xl border border-gray-200 px-4 py-3 sm:flex-1">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input v-model="ptName" type="text" placeholder="Cek ketersediaan nama PT Anda..." class="w-full border-none p-0 text-sm text-gray-700 placeholder-gray-400 focus:ring-0 sm:text-base">
                    </div>
                    <button type="submit" class="inline-flex justify-center rounded-full bg-primary px-6 py-3 text-sm font-bold text-white transition hover:bg-pink-600 disabled:cursor-not-allowed disabled:opacity-70" :disabled="isChecking || !ptName">
                        {{ isChecking ? 'Mengecek...' : 'Cek Nama PT' }}
                    </button>
                </form>

                <div v-if="checkResult" class="mt-4 rounded-2xl px-4 py-3 text-sm font-semibold" :class="checkResult.available ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'">
                    {{ checkResult.message }}
                </div>
            </div>
        </section>

        <!-- 2. Services Section -->
        <section id="layanan" class="pt-20 pb-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <h2 class="text-3xl font-bold text-secondary">Pilih layanan sesuai dengan kebutuhan Anda</h2>
                    <a href="/layanan" class="inline-block text-primary font-semibold hover:underline">Lihat Semua Layanan &rarr;</a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Service Card 1 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col">
                        <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=900&q=80&fm=webp" class="w-full h-40 object-cover" alt="Layanan pendirian PT FastTrack">
                        <div class="p-5 flex-grow flex flex-col">
                            <span class="inline-block bg-pink-100 text-primary text-xs font-bold px-2 py-1 rounded mb-3 w-max">POPULER</span>
                            <h3 class="font-bold text-lg mb-2">Pendirian PT</h3>
                            <p class="text-gray-600 text-sm mb-4 flex-grow">Proses cepat, dokumen lengkap, harga transparan untuk perusahaan Anda.</p>
                            <div class="border-t border-gray-100 pt-4 mt-auto">
                                <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                                <p class="font-bold text-primary mb-3">Rp 3.500.000</p>
                                <a href="/pendirian-perusahaan" class="block w-full text-center border border-primary text-primary hover:bg-primary hover:text-white py-2 rounded font-semibold text-sm transition">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Service Card 2 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col">
                        <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=900&q=80&fm=webp" class="w-full h-40 object-cover" alt="Layanan virtual office FastTrack">
                        <div class="p-5 flex-grow flex flex-col">
                            <span class="inline-block bg-pink-100 text-primary text-xs font-bold px-2 py-1 rounded mb-3 w-max">TERLARIS</span>
                            <h3 class="font-bold text-lg mb-2">Virtual Office</h3>
                            <p class="text-gray-600 text-sm mb-4 flex-grow">Alamat bisnis prestisius di lokasi strategis Jakarta.</p>
                            <div class="border-t border-gray-100 pt-4 mt-auto">
                                <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                                <p class="font-bold text-primary mb-3">Rp 2.000.000 / thn</p>
                                <a href="/virtual-office-jakarta" class="block w-full text-center border border-primary text-primary hover:bg-primary hover:text-white py-2 rounded font-semibold text-sm transition">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Service Card 3 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col">
                        <img src="https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=900&q=80&fm=webp" class="w-full h-40 object-cover" alt="Layanan pendirian CV FastTrack">
                        <div class="p-5 flex-grow flex flex-col">
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs font-bold px-2 py-1 rounded mb-3 w-max">UMKM</span>
                            <h3 class="font-bold text-lg mb-2">Pendirian CV</h3>
                            <p class="text-gray-600 text-sm mb-4 flex-grow">Solusi legalitas untuk badan usaha menengah ke bawah dengan biaya hemat.</p>
                            <div class="border-t border-gray-100 pt-4 mt-auto">
                                <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                                <p class="font-bold text-primary mb-3">Rp 2.500.000</p>
                                <a href="/pendirian-perusahaan" class="block w-full text-center border border-primary text-primary hover:bg-primary hover:text-white py-2 rounded font-semibold text-sm transition">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Service Card 4 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=900&q=80&fm=webp" class="w-full h-40 object-cover" alt="Layanan perizinan usaha FastTrack">
                        <div class="p-5 flex-grow flex flex-col">
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs font-bold px-2 py-1 rounded mb-3 w-max">KHUSUS</span>
                            <h3 class="font-bold text-lg mb-2">Izin Usaha Tambahan</h3>
                            <p class="text-gray-600 text-sm mb-4 flex-grow">Pengurusan izin khusus untuk berbagai sektor bisnis sesuai regulasi terbaru.</p>
                            <div class="border-t border-gray-100 pt-4 mt-auto">
                                <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                                <p class="font-bold text-primary mb-3">Hubungi Kami</p>
                                <a href="/perizinan" class="block w-full text-center border border-primary text-primary hover:bg-primary hover:text-white py-2 rounded font-semibold text-sm transition">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Promos Section -->
        <section id="promo" class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <h2 class="text-2xl font-bold text-secondary">Dapatkan Penawaran Menarik dari Kami!</h2>
                    <a href="/promo" class="text-primary font-semibold hover:underline">Lihat Semua Promo &rarr;</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="/promo" v-for="i in 4" :key="i" class="block bg-gray-800 rounded-lg p-4 text-white hover:bg-secondary transition">
                        <div class="text-xs text-primary font-bold mb-1">PROMO SPESIAL</div>
                        <h3 class="font-bold text-lg mb-1">HEMAT HINGGA 30%</h3>
                        <p class="text-xs text-gray-300">Untuk pendirian PT + Virtual Office bulan ini.</p>
                    </a>
                </div>
            </div>
        </section>

        <!-- 4. About Section -->
        <section id="tentang" class="py-16 bg-gray-50 border-y border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center gap-12">
                    <div class="w-full md:w-1/2">
                        <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1200&q=80&fm=webp" alt="Kantor FastTrack untuk konsultasi legalitas bisnis" class="rounded-xl shadow-lg w-full">
                    </div>
                    <div class="w-full md:w-1/2">
                        <h2 class="text-3xl font-bold mb-6 text-secondary">Tentang FASTTRACK</h2>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            FASTTRACK adalah perusahaan konsultan legalitas yang berpengalaman membantu ribuan pengusaha di Indonesia. Kami memberikan solusi tepat, cepat, dan sesuai hukum untuk pendirian perusahaan, perizinan, hingga penyediaan alamat bisnis (Virtual Office).
                        </p>
                        <p class="text-gray-600 mb-8 leading-relaxed">
                            Dedikasi kami adalah menjadi partner pertumbuhan bisnis Anda dengan proses yang 100% transparan dan bisa dilacak secara real-time.
                        </p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-t border-gray-200 pt-8">
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
                    <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&w=800&q=80&fm=webp" alt="Dashboard pelacakan layanan FastTrack di perangkat mobile" class="w-full max-w-xs rounded-3xl shadow-2xl border-8 border-gray-800 transform rotate-2 hover:rotate-0 transition duration-500">
                </div>
            </div>
        </section>

        <!-- 6. Features Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-secondary">Fitur FASTTRACK</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8">
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

        <!-- 7. Artikel Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-8">
                    <h2 class="text-3xl font-bold text-secondary">ARTIKEL</h2>
                    <a href="/artikel" class="text-primary font-semibold hover:underline">Lihat Semua &rarr;</a>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Post -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col md:flex-row">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=900&q=80&fm=webp" class="w-full md:w-1/2 h-48 md:h-auto object-cover" alt="Artikel panduan mendirikan PT">
                        <div class="p-6 flex flex-col justify-center w-full md:w-1/2">
                            <div class="text-xs text-gray-500 mb-2">12 Mei 2024</div>
                            <a href="/artikel/1" class="text-xl font-bold mb-3 hover:text-primary transition">Panduan Lengkap Mendirikan PT Tahun 2024</a>
                            <p class="text-gray-600 text-sm mb-4">Mendirikan Perseroan Terbatas kini semakin mudah dengan adanya sistem OSS. Pelajari langkah-langkahnya.</p>
                            <a href="/artikel/1" class="text-primary font-semibold text-sm hover:underline mt-auto">Baca Selengkapnya &rarr;</a>
                        </div>
                    </div>
                    
                    <!-- Sidebar List -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h4 class="font-bold text-lg mb-4 border-b border-gray-100 pb-2">Artikel Terbaru</h4>
                        <ul class="space-y-4">
                            <li v-for="i in 4" :key="i" class="flex flex-col">
                                <a :href="`/artikel/${i + 1}`" class="font-semibold hover:text-primary transition text-sm mb-1">Perbedaan PT dan CV: Mana yang Cocok Untuk Bisnis Anda?</a>
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
                            <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=1200&q=80&fm=webp" class="absolute inset-0 w-full h-full object-cover opacity-50" alt="Lokasi kantor FastTrack di Jakarta Selatan">
                            <div class="relative z-10 bg-white p-4 rounded-lg shadow-md text-center">
                                <h4 class="font-bold text-secondary">Head Office FASTTRACK</h4>
                                <p class="text-sm text-gray-500 mt-1">Grand Bintaro, Jakarta Selatan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </MainLayout>
</template>
