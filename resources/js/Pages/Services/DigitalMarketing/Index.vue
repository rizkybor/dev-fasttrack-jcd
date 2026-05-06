<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
    service: Object
});
</script>

<template>
    <MainLayout>
        <Head>
            <title>{{ service.title }} - FastTrack</title>
            <meta name="description" :content="service.description">
        </Head>

        <!-- Dynamic Hero Section -->
        <section class="py-12 md:py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    
                    <!-- Left Content -->
                    <div class="w-full lg:w-1/2">
                        <!-- Breadcrumb -->
                        <nav class="text-sm font-medium text-gray-500 mb-6" aria-label="Breadcrumb">
                            <a href="/" class="hover:text-gray-800 transition">Beranda</a> 
                            <span class="mx-1">&raquo;</span> 
                            <a href="/layanan" class="hover:text-gray-800 transition">Layanan</a> 
                            <span class="mx-1">&raquo;</span> 
                            <span class="text-gray-800">{{ service.title }}</span>
                        </nav>

                        <!-- Heading -->
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6 tracking-tight">
                            {{ service.title }}
                        </h1>

                        <!-- Description -->
                        <p class="text-lg text-gray-700 mb-10 max-w-lg leading-relaxed">
                            {{ service.description }}
                        </p>

                        <!-- Buttons -->
                        <div class="flex flex-col gap-4 sm:flex-row sm:flex-wrap">
                            <a href="#detail" class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-900 text-gray-900 bg-white hover:bg-gray-50 font-bold rounded-full transition shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M7 7h10v10"></path></svg>
                                Lihat Selengkapnya
                            </a>
                            <a href="/kontak" class="inline-flex items-center justify-center px-6 py-3 bg-[#1E7E34] hover:bg-[#155d27] text-white font-bold rounded-full transition shadow-sm border-2 border-[#1E7E34]">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M7 7h10v10"></path></svg>
                                Hubungi Kami
                            </a>
                        </div>
                    </div>

                    <!-- Right Image -->
                    <div class="w-full lg:w-1/2">
                        <img 
                            src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                            :alt="service.title" 
                            class="w-full h-auto object-cover rounded-[2rem] shadow-xl"
                        >
                    </div>

                </div>
            </div>
        </section>

        <!-- Placeholder for next sections specific to this service -->
        <section id="detail" class="py-16 bg-gray-50 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Informasi Lebih Lanjut tentang {{ service.title }}</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Bagian ini akan disesuaikan dengan konten detail spesifik untuk layanan {{ service.title }}. Tim konsultan kami siap membantu seluruh prosesnya dengan transparan dan profesional.
                </p>
            </div>
        </section>
    </MainLayout>
</template>
