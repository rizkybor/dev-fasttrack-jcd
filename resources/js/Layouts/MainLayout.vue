<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const seo = computed(() => page.props.seo || {});
const servicesOpen = ref(false);
const tipsOpen = ref(false);

const serviceCategories = [
    {
        title: 'Pendirian Perusahaan',
        path: '/pendirian-perusahaan',
        icon: 'building',
        items: ['Pendirian PT', 'Pendirian CV']
    },
    {
        title: 'Pembuatan dan Peninjauan Perjanjian',
        path: '/pembuatan-perjanjian',
        icon: 'document',
        items: ['Perjanjian Kerja', 'Perjanjian Investasi']
    },
    {
        title: 'IZINTAX',
        path: '/perpajakan',
        isLogo: true,
        logoText: 'IZIN<span class="text-blue-600">TAX</span>',
        desc: 'Layanan perpajakan dan pembukuan'
    },
    {
        title: 'IZINHUKUM',
        path: '/hukum',
        isLogo: true,
        logoText: 'IZIN<span class="text-indigo-900">HU<span class="text-red-500">Q</span>UM</span>',
        desc: 'Solusi Hukum Profesional dengan Biaya yang Transparan'
    },
    {
        title: 'Penutupan Perusahaan',
        path: '/penutupan-perusahaan',
        icon: 'building',
        items: ['Penutupan PT', 'Penutupan CV']
    },
    {
        title: 'Pembuatan dan Perubahan Dokumen Perusahaan',
        path: '/perubahan-akta',
        icon: 'document-check',
        items: ['Perubahan Dokumen', 'Anggaran Dasar', 'Perubahan Data Perseroan']
    },
    {
        title: 'IZINHAKI',
        path: '/haki',
        isLogo: true,
        logoText: 'IZIN<span class="text-blue-500 border border-blue-500 px-1 ml-1 rounded">HAKI</span>',
        desc: 'Layanan perlindungan Hak Kekayaan Intelektual'
    },
    {
        title: 'IZINPROPERTI',
        path: '/izin-properti',
        isLogo: true,
        logoText: 'IZIN<span class="text-red-700">PROPERTI</span>',
        desc: 'Solusi untuk mengurus seluruh kebutuhan legalitas seputar tanah dan properti'
    },
    {
        title: 'Virtual Office',
        path: '/virtual-office-jakarta',
        icon: 'pin',
        items: ['Virtual Office Lite', 'Virtual Office Premium']
    },
    {
        title: 'Digital Marketing',
        path: '/digital-marketing',
        icon: 'globe',
        items: ['Pembuatan Website', 'Pendaftaran Domain']
    },
    {
        title: 'invest in asia',
        path: '/foreignservice',
        isLogo: true,
        logoText: '<span class="text-blue-900 lowercase font-serif">invest<span class="text-green-500">in</span>asia</span>',
        desc: 'Professional services to set up companies and to own business permits in Indonesia'
    },
    {
        title: 'IZIN PRIVILEGE',
        path: '/izin-privilege',
        isLogo: true,
        logoText: 'IZIN <span class="font-normal tracking-widest">PRIVILEGE</span>',
        desc: 'Benefit untuk Klien yang menggunakan layanan khusus.'
    },
    {
        title: 'Perizinan Khusus',
        path: '/perizinan',
        icon: 'doc-stack',
        items: ['Perizinan Perusahaan', 'Perizinan Khusus/Sektoral']
    },
    {
        title: 'Perizinan Usaha',
        path: '/perizinan-usaha',
        icon: 'license',
        items: ['OSS', 'NIB']
    },
    {
        title: 'Layanan Lainnya',
        path: '/layanan-lain',
        icon: 'grid',
        items: ['Penerjemah', 'Pelaporan LKPM']
    }
];

const toolGroups = [
    {
        title: 'Pengecekan Merek',
        icon: 'search',
    },
    {
        title: 'Pengecekan Nama PT',
        icon: 'refresh',
    },
    {
        title: 'KBLI',
        icon: 'kbli',
    },
    {
        title: 'Kalkulator Pajak Properti',
        icon: 'calculator',
    },
];
</script>

<template>
    <Head>
        <title>{{ seo.title || 'Layanan Legalitas Bisnis' }}</title>
        <meta name="description" :content="seo.description || 'Platform layanan legalitas pendirian PT/CV.'">
    </Head>

    <div class="min-h-screen bg-white text-secondary font-sans flex flex-col">
        <!-- Header -->
        <header
            class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm"
            @mouseleave="servicesOpen = false; tipsOpen = false"
        >
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
                        <a href="/#promo" class="text-sm font-semibold text-gray-700 hover:text-primary transition uppercase tracking-wide">Promo</a>
                        <div class="relative" @mouseenter="servicesOpen = true">
                            <button
                                type="button"
                                class="inline-flex items-center gap-1 text-sm font-semibold uppercase tracking-wide transition"
                                :class="servicesOpen ? 'text-primary' : 'text-gray-700 hover:text-primary'"
                                @click="servicesOpen = !servicesOpen"
                            >
                                <span>Layanan</span>
                                <svg
                                    class="h-4 w-4 transition-transform duration-200"
                                    :class="servicesOpen ? 'rotate-180' : ''"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                        <a href="/#tentang" class="text-sm font-semibold text-gray-700 hover:text-primary transition uppercase tracking-wide">Tentang Kami</a>
                        <div class="relative" @mouseenter="tipsOpen = true">
                            <button
                                type="button"
                                class="inline-flex items-center gap-1 text-sm font-semibold uppercase tracking-wide transition"
                                :class="tipsOpen ? 'text-primary' : 'text-gray-700 hover:text-primary'"
                                @click="tipsOpen = !tipsOpen"
                            >
                                <span>Tips Bisnis</span>
                                <svg
                                    class="h-4 w-4 transition-transform duration-200"
                                    :class="tipsOpen ? 'rotate-180' : ''"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <transition
                                enter-active-class="transition duration-150 ease-out"
                                enter-from-class="opacity-0 -translate-y-2"
                                enter-to-class="opacity-100 translate-y-0"
                                leave-active-class="transition duration-100 ease-in"
                                leave-from-class="opacity-100 translate-y-0"
                                leave-to-class="opacity-0 -translate-y-2"
                            >
                                <div
                                    v-if="tipsOpen"
                                    class="absolute right-0 top-full mt-4 w-56 rounded-2xl border border-gray-100 bg-white p-2 shadow-2xl"
                                >
                                    <a href="/artikel" class="block rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 transition hover:bg-primary/5 hover:text-primary">
                                        Blog
                                    </a>
                                    <a href="/kbli" class="block rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 transition hover:bg-primary/5 hover:text-primary">
                                        KBLI
                                    </a>
                                    <a href="/faq" class="block rounded-xl px-4 py-3 text-sm font-semibold text-gray-700 transition hover:bg-primary/5 hover:text-primary">
                                        FAQ
                                    </a>
                                </div>
                            </transition>
                        </div>
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

            <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0 -translate-y-2"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-2"
            >
                <div
                    v-if="servicesOpen"
                    class="hidden md:block absolute left-0 right-0 top-full border-t border-gray-100 bg-white shadow-2xl overflow-hidden z-50"
                    @mouseenter="servicesOpen = true"
                >
                    <div class="max-w-7xl mx-auto px-6 py-6 max-h-[85vh] overflow-y-auto">
                        <div class="text-center mb-5">
                            <h3 class="text-2xl font-bold text-secondary">Layanan Kami</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <a
                                v-for="group in serviceCategories"
                                :key="group.title"
                                :href="group.path"
                                class="group rounded-2xl border border-gray-100 bg-white p-4 transition duration-200 hover:-translate-y-1 hover:border-primary/30 hover:shadow-lg"
                            >
                                <template v-if="!group.isLogo">
                                    <div class="flex items-start gap-3">
                                        <div class="relative flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-gray-50 text-secondary transition group-hover:border-primary/40 group-hover:bg-primary/5">
                                            <span class="absolute -right-1 -top-1 h-3 w-3 rounded-full bg-green-500"></span>

                                            <svg v-if="group.icon === 'building'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M5 21V7l7-4v18M19 21V11h-4M9 9h1M9 13h1M9 17h1M13 9h1M13 13h1M13 17h1" />
                                            </svg>
                                            <svg v-else-if="group.icon === 'document'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h7l5 5v13H7z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v6h6M9 13h6M9 17h6" />
                                            </svg>
                                            <svg v-else-if="group.icon === 'pin'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 21s-6-5.686-6-11a6 6 0 1112 0c0 5.314-6 11-6 11z" />
                                                <circle cx="12" cy="10" r="2.5" stroke-width="1.8" />
                                            </svg>
                                            <svg v-else-if="group.icon === 'document-check'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h7l5 5v13H7z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v6h6M9 13h4M9 17h3M14 17l1.5 1.5L19 15" />
                                            </svg>
                                            <svg v-else-if="group.icon === 'doc-stack'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h10v13H8z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 4h10M4 1h10" />
                                            </svg>
                                            <svg v-else-if="group.icon === 'globe'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <circle cx="12" cy="12" r="9" stroke-width="1.8" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12h18M12 3a15 15 0 010 18M12 3a15 15 0 000 18" />
                                            </svg>
                                            <svg v-else-if="group.icon === 'license'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h10v18l-5-3-5 3z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 8h6M9 12h4" />
                                            </svg>
                                            <svg v-else class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z" />
                                            </svg>
                                        </div>

                                        <div>
                                            <h4 class="text-base font-bold text-secondary transition group-hover:text-primary">
                                                {{ group.title }}
                                            </h4>
                                            <ul class="mt-2 space-y-1 text-xs text-gray-600">
                                                <li v-for="item in group.items" :key="item">
                                                    {{ item }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="flex flex-col justify-center h-full">
                                        <div class="text-xl font-bold mb-1" v-html="group.logoText"></div>
                                        <p class="text-xs text-gray-500 leading-tight">{{ group.desc }}</p>
                                    </div>
                                </template>
                            </a>
                        </div>

                        <div class="mt-6 border-t border-gray-100 pt-5">
                            <div class="text-center mb-4">
                                <h4 class="text-xl font-bold text-secondary">Tools</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <a
                                    v-for="tool in toolGroups"
                                    :key="tool.title"
                                    href="/"
                                    class="group flex items-center gap-3 rounded-2xl border border-gray-100 bg-white p-3 transition duration-200 hover:-translate-y-1 hover:border-primary/30 hover:shadow-lg"
                                >
                                    <div class="relative flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-gray-50 text-secondary transition group-hover:border-primary/40 group-hover:bg-primary/5">
                                        <span class="absolute -left-1 bottom-1 h-2.5 w-2.5 rounded-full bg-green-500"></span>

                                        <svg v-if="tool.icon === 'search'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 4a7 7 0 105.293 11.586L20 19.293" />
                                        </svg>
                                        <svg v-else-if="tool.icon === 'refresh'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 12a8 8 0 11-2.343-5.657M20 4v6h-6" />
                                        </svg>
                                        <svg v-else-if="tool.icon === 'kbli'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h10v18H7z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 8h6M9 12h6M9 16h4" />
                                        </svg>
                                        <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 3h6M5 7h14v14H5zM8 11h2M14 11h2M8 15h2M14 15h2" />
                                        </svg>
                                    </div>

                                    <div class="text-sm font-semibold text-secondary transition group-hover:text-primary">
                                        {{ tool.title }}
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
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
