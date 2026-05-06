<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const seo = computed(() => page.props.seo || {});
</script>

<template>
    <Head>
        <title>{{ seo.title || 'Layanan Legalitas Bisnis' }}</title>
        <meta name="description" :content="seo.description || 'Platform layanan legalitas pendirian PT/CV.'">
    </Head>

    <div class="min-h-screen bg-white text-secondary font-sans flex flex-col">
        <!-- Header -->
        <header class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-3xl font-extrabold text-secondary tracking-tight">
                            FAST<span class="text-primary">TRACK</span>
                        </a>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <nav class="hidden md:flex space-x-8 items-center">
                        <a href="/" class="text-sm font-semibold text-gray-700 hover:text-primary transition uppercase tracking-wide">Home</a>
                        <a href="/layanan" class="text-sm font-semibold text-gray-700 hover:text-primary transition uppercase tracking-wide">Layanan</a>
                        <a href="#" class="text-sm font-semibold text-gray-700 hover:text-primary transition uppercase tracking-wide">Harga</a>
                        <a href="/artikel" class="text-sm font-semibold text-gray-700 hover:text-primary transition uppercase tracking-wide">Blog</a>
                        <a href="/kontak" class="text-sm font-semibold text-gray-700 hover:text-primary transition uppercase tracking-wide">Kontak</a>
                    </nav>

                    <!-- CTA Button -->
                    <div class="hidden md:flex items-center">
                        <a href="/kontak" class="bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white font-bold py-2 px-6 rounded-full transition duration-300 shadow-sm">
                            Konsultasi Gratis
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button class="text-gray-600 hover:text-primary focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-secondary text-gray-300 py-16 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Trust Badge / Logo Row -->
                <div class="mb-12 pb-8 border-b border-gray-700 flex flex-col md:flex-row items-center justify-between">
                    <div class="flex items-center space-x-2 mb-4 md:mb-0">
                        <span class="text-3xl font-extrabold text-white tracking-tight">FAST<span class="text-primary">TRACK</span></span>
                    </div>
                    <div class="flex items-center space-x-2 bg-gray-800 px-4 py-2 rounded-lg">
                        <span class="text-sm font-semibold text-white">EXCELLENT REVIEWS</span>
                        <div class="flex text-primary">
                            <svg v-for="i in 5" :key="i" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Footer Columns -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                    <!-- Column 1 -->
                    <div>
                        <h4 class="text-white text-lg font-bold mb-6">Tentang Kami</h4>
                        <div class="space-y-4 text-sm">
                            <p class="flex items-start">
                                <svg class="w-5 h-5 mr-3 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Gedung Sudirman Center, Lt 5<br>Jl. Sudirman Kav 1<br>Jakarta Selatan 12190
                            </p>
                            <p class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                0812-3456-7890
                            </p>
                            <p class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                halo@fasttrack.test
                            </p>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div>
                        <h4 class="text-white text-lg font-bold mb-6">Layanan</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a href="/layanan/pendirian-pt" class="hover:text-primary transition flex items-center"><span class="mr-2">&rsaquo;</span> Pendirian PT</a></li>
                            <li><a href="/layanan/pendirian-cv" class="hover:text-primary transition flex items-center"><span class="mr-2">&rsaquo;</span> Pendirian CV</a></li>
                            <li><a href="/layanan/virtual-office" class="hover:text-primary transition flex items-center"><span class="mr-2">&rsaquo;</span> Virtual Office</a></li>
                            <li><a href="#" class="hover:text-primary transition flex items-center"><span class="mr-2">&rsaquo;</span> Perizinan Khusus</a></li>
                            <li><a href="#" class="hover:text-primary transition flex items-center"><span class="mr-2">&rsaquo;</span> Pendaftaran Merek</a></li>
                        </ul>
                    </div>

                    <!-- Column 3 -->
                    <div>
                        <h4 class="text-white text-lg font-bold mb-6">Informasi</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a href="/artikel" class="hover:text-primary transition flex items-center"><span class="mr-2">&rsaquo;</span> Blog & Edukasi</a></li>
                            <li><a href="#" class="hover:text-primary transition flex items-center"><span class="mr-2">&rsaquo;</span> FAQ</a></li>
                            <li><a href="#" class="hover:text-primary transition flex items-center"><span class="mr-2">&rsaquo;</span> Syarat & Ketentuan</a></li>
                            <li><a href="#" class="hover:text-primary transition flex items-center"><span class="mr-2">&rsaquo;</span> Kebijakan Privasi</a></li>
                            <li><a href="#" class="hover:text-primary transition flex items-center"><span class="mr-2">&rsaquo;</span> Karier</a></li>
                        </ul>
                    </div>

                    <!-- Column 4 -->
                    <div>
                        <h4 class="text-white text-lg font-bold mb-6">Sertifikasi & Legalitas</h4>
                        <p class="text-sm mb-4">Kami adalah perusahaan konsultan legalitas berbadan hukum resmi yang terdaftar dan diawasi oleh kementerian terkait.</p>
                        <div class="flex space-x-4">
                            <!-- Mock badges -->
                            <div class="w-12 h-12 bg-white rounded flex items-center justify-center text-xs font-bold text-gray-800">ISO</div>
                            <div class="w-12 h-12 bg-white rounded flex items-center justify-center text-xs font-bold text-gray-800">KEMEN</div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-500 mb-4 md:mb-0">
                        &copy; 2024 FASTTRACK. All Rights Reserved.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-500 hover:text-white transition">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/></svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-white transition">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/></svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-white transition">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
