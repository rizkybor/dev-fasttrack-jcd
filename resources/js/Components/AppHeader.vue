<script setup>
import { ref } from 'vue';

const servicesOpen = ref(false);
const informasiOpen = ref(false);
const mobileMenuOpen = ref(false);
const mobileServicesOpen = ref(false);
const mobileInformasiOpen = ref(false);

const serviceCategories = [
    { title: 'Pendirian Perusahaan', path: '/pendirian-perusahaan', icon: 'building', items: ['Pendirian PT', 'Pendirian CV'] },
    { title: 'Pembuatan dan Peninjauan Perjanjian', path: '/pembuatan-perjanjian', icon: 'document', items: ['Perjanjian Kerja', 'Perjanjian Investasi'] },
    { title: 'IZINTAX', path: '/perpajakan', isLogo: true, logoText: 'IZIN<span class="text-blue-600">TAX</span>', desc: 'Layanan perpajakan dan pembukuan' },
    { title: 'IZINHUKUM', path: '/hukum', isLogo: true, logoText: 'IZIN<span class="text-indigo-900">HU<span class="text-red-500">Q</span>UM</span>', desc: 'Solusi Hukum Profesional' },
    { title: 'Penutupan Perusahaan', path: '/penutupan-perusahaan', icon: 'building', items: ['Penutupan PT', 'Penutupan CV'] },
    { title: 'Pembuatan dan Perubahan Dokumen', path: '/perubahan-akta', icon: 'document-check', items: ['Perubahan Dokumen', 'Anggaran Dasar'] },
    { title: 'IZINHAKI', path: '/haki', isLogo: true, logoText: 'IZIN<span class="text-blue-500 border border-blue-500 px-1 ml-1 rounded">HAKI</span>', desc: 'Perlindungan Hak Kekayaan Intelektual' },
    { title: 'IZINPROPERTI', path: '/izin-properti', isLogo: true, logoText: 'IZIN<span class="text-red-700">PROPERTI</span>', desc: 'Legalitas tanah dan properti' },
    { title: 'Virtual Office', path: '/virtual-office-jakarta', icon: 'pin', items: ['Virtual Office Lite', 'Virtual Office Premium'] },
    { title: 'Digital Marketing', path: '/digital-marketing', icon: 'globe', items: ['Pembuatan Website', 'Pendaftaran Domain'] },
    { title: 'invest in asia', path: '/foreignservice', isLogo: true, logoText: '<span class="text-blue-900 lowercase font-serif">invest<span class="text-green-500">in</span>asia</span>', desc: 'Set up companies in Indonesia' },
    { title: 'IZIN PRIVILEGE', path: '/izin-privilege', isLogo: true, logoText: 'IZIN <span class="font-normal tracking-widest">PRIVILEGE</span>', desc: 'Benefit untuk klien layanan khusus' },
    { title: 'Perizinan Khusus', path: '/perizinan', icon: 'doc-stack', items: ['Perizinan Perusahaan', 'Perizinan Sektoral'] },
    { title: 'Perizinan Usaha', path: '/perizinan-usaha', icon: 'license', items: ['OSS', 'NIB'] },
    { title: 'Layanan Lainnya', path: '/layanan-lain', icon: 'grid', items: ['Penerjemah', 'Pelaporan LKPM'] },
];

const informasiLinks = [
    { label: 'Artikel', path: '/artikel' },
    { label: 'KBLI', path: '/kbli' },
    { label: 'FAQ', path: '/faq' },
];

const closeAllMenus = () => {
    servicesOpen.value = false;
    informasiOpen.value = false;
    mobileMenuOpen.value = false;
    mobileServicesOpen.value = false;
    mobileInformasiOpen.value = false;
};

const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
    if (!mobileMenuOpen.value) {
        mobileServicesOpen.value = false;
        mobileInformasiOpen.value = false;
    }
};
</script>

<template>
    <header
        class="sticky top-0 z-50 bg-[#FEFEFE]/95 backdrop-blur-md border-b border-[#D9DAD8] shadow-sm"
        @mouseleave="servicesOpen = false; informasiOpen = false"
    >
        <!-- Top bar: KERJASAMA badge (kiri) -->
        <div class="hidden lg:flex items-center justify-between bg-[#FEFEFE] border-b border-[#D9DAD8] px-20 py-1.5">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 bg-primary/10 text-primary text-xs font-bold px-3 py-1 rounded">
                    KERJASAMA 🔥
                </span>
            </div>
            <div class="flex items-center gap-4 text-xs text-[#42443D]">
                <span>cs@fasttrack.legal</span>
                <span>|</span>
                <span>0217 3885 036</span>
            </div>
        </div>

        <!-- Main nav row -->
        <div class="px-4 sm:px-6 lg:px-20">
            <div class="flex items-center justify-between h-16 lg:h-[60px]">
                <!-- Logo -->
                <a href="/" class="flex-shrink-0 flex items-center" aria-label="FastTrack Beranda">
                    <img src="/images/logo-fasttrack.png" alt="FastTrack Logo" class="h-8 w-auto object-contain">
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden lg:flex items-center gap-1" aria-label="Navigasi Utama">
                    <!-- PENAWARAN KHUSUS -->
                    <a
                        href="/promo"
                        class="flex items-center gap-1 px-3 py-2.5 text-[14px] font-semibold text-[#1A1B18] hover:text-primary transition-colors whitespace-nowrap"
                    >
                        PENAWARAN KHUSUS
                        <span class="text-[10px]">🌈</span>
                    </a>

                    <!-- LAYANAN dropdown -->
                    <div class="relative" @mouseenter="servicesOpen = true">
                        <button
                            type="button"
                            class="flex items-center gap-1 px-3 py-2.5 text-[14px] font-semibold transition-colors whitespace-nowrap"
                            :class="servicesOpen ? 'text-primary' : 'text-[#1A1B18] hover:text-primary'"
                            @click="servicesOpen = !servicesOpen"
                            :aria-expanded="servicesOpen"
                        >
                            LAYANAN
                            <svg class="w-4 h-4 transition-transform duration-200" :class="servicesOpen ? 'rotate-180 text-primary' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>

                    <!-- TENTANG KAMI -->
                    <a href="/tentang-kami" class="flex items-center px-3 py-2.5 text-[14px] font-semibold text-[#1A1B18] hover:text-primary transition-colors whitespace-nowrap">
                        TENTANG KAMI
                    </a>

                    <!-- BLOG -->
                    <a href="/artikel" class="flex items-center px-3 py-2.5 text-[14px] font-semibold text-[#1A1B18] hover:text-primary transition-colors whitespace-nowrap">
                        BLOG
                    </a>

                    <!-- INFORMASI dropdown -->
                    <div class="relative" @mouseenter="informasiOpen = true">
                        <button
                            type="button"
                            class="flex items-center gap-1 px-3 py-2.5 text-[14px] font-semibold transition-colors whitespace-nowrap"
                            :class="informasiOpen ? 'text-primary' : 'text-[#1A1B18] hover:text-primary'"
                            @click="informasiOpen = !informasiOpen"
                            :aria-expanded="informasiOpen"
                        >
                            INFORMASI
                            <svg class="w-4 h-4 transition-transform duration-200" :class="informasiOpen ? 'rotate-180 text-primary' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <transition
                            enter-active-class="transition duration-150 ease-out"
                            enter-from-class="opacity-0 -translate-y-1"
                            enter-to-class="opacity-100 translate-y-0"
                            leave-active-class="transition duration-100 ease-in"
                            leave-from-class="opacity-100 translate-y-0"
                            leave-to-class="opacity-0 -translate-y-1"
                        >
                            <div
                                v-if="informasiOpen"
                                class="absolute right-0 top-full mt-1 w-48 rounded-xl border border-[#D9DAD8] bg-white p-1.5 shadow-xl"
                            >
                                <a
                                    v-for="link in informasiLinks"
                                    :key="link.path"
                                    :href="link.path"
                                    class="block rounded-lg px-4 py-2.5 text-sm font-semibold text-[#1A1B18] hover:bg-primary/5 hover:text-primary transition-colors"
                                    @click="closeAllMenus"
                                >{{ link.label }}</a>
                            </div>
                        </transition>
                    </div>
                </nav>

                <!-- Right: Lang + CTA -->
                <div class="hidden lg:flex items-center gap-2">
                    <button
                        type="button"
                        class="flex items-center gap-1 border border-[#D9DAD8] rounded-lg px-3 py-2 text-[14px] font-semibold text-[#1A1B18] hover:border-primary hover:text-primary transition-colors"
                    >
                        ID
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <a
                        href="/kontak"
                        class="inline-flex items-center gap-2 bg-primary hover:bg-red-600 text-white font-semibold text-[16px] px-6 py-3 rounded-lg transition-colors shadow-sm whitespace-nowrap"
                    >
                        Minta Penawaran
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button
                    type="button"
                    class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-lg border border-[#D9DAD8] text-[#1A1B18] hover:border-primary hover:text-primary transition-colors focus:outline-none"
                    :aria-expanded="mobileMenuOpen"
                    aria-controls="mobile-navigation"
                    aria-label="Buka menu navigasi"
                    @click="toggleMobileMenu"
                >
                    <svg v-if="!mobileMenuOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 -translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-2"
        >
            <div
                v-if="mobileMenuOpen"
                id="mobile-navigation"
                class="lg:hidden max-h-[calc(100vh-4rem)] overflow-y-auto overscroll-contain border-t border-[#D9DAD8] bg-white shadow-lg"
            >
                <nav class="space-y-1 px-4 py-4 pb-6" aria-label="Mobile Navigation">
                    <a href="/promo" class="block rounded-xl px-4 py-3 text-sm font-semibold text-[#1A1B18] hover:bg-primary/5 hover:text-primary transition-colors" @click="closeAllMenus">
                        PENAWARAN KHUSUS 🌈
                    </a>

                    <div class="rounded-xl border border-[#D9DAD8]">
                        <button
                            type="button"
                            class="flex w-full items-center justify-between px-4 py-3 text-sm font-semibold text-[#1A1B18]"
                            :aria-expanded="mobileServicesOpen"
                            @click="mobileServicesOpen = !mobileServicesOpen"
                        >
                            <span>LAYANAN</span>
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobileServicesOpen ? 'rotate-180 text-primary' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div v-if="mobileServicesOpen" class="space-y-0.5 border-t border-[#D9DAD8] px-3 py-2">
                            <a
                                v-for="group in serviceCategories"
                                :key="`mobile-${group.title}`"
                                :href="group.path"
                                class="block rounded-lg px-3 py-2 text-sm text-[#42443D] hover:bg-primary/5 hover:text-primary transition-colors"
                                @click="closeAllMenus"
                            >{{ group.title }}</a>
                        </div>
                    </div>

                    <a href="/tentang-kami" class="block rounded-xl px-4 py-3 text-sm font-semibold text-[#1A1B18] hover:bg-primary/5 hover:text-primary transition-colors" @click="closeAllMenus">
                        TENTANG KAMI
                    </a>

                    <a href="/artikel" class="block rounded-xl px-4 py-3 text-sm font-semibold text-[#1A1B18] hover:bg-primary/5 hover:text-primary transition-colors" @click="closeAllMenus">
                        BLOG
                    </a>

                    <div class="rounded-xl border border-[#D9DAD8]">
                        <button
                            type="button"
                            class="flex w-full items-center justify-between px-4 py-3 text-sm font-semibold text-[#1A1B18]"
                            :aria-expanded="mobileInformasiOpen"
                            @click="mobileInformasiOpen = !mobileInformasiOpen"
                        >
                            <span>INFORMASI</span>
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobileInformasiOpen ? 'rotate-180 text-primary' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div v-if="mobileInformasiOpen" class="space-y-0.5 border-t border-[#D9DAD8] px-3 py-2">
                            <a
                                v-for="link in informasiLinks"
                                :key="link.path"
                                :href="link.path"
                                class="block rounded-lg px-3 py-2 text-sm text-[#42443D] hover:bg-primary/5 hover:text-primary transition-colors"
                                @click="closeAllMenus"
                            >{{ link.label }}</a>
                        </div>
                    </div>

                    <a href="/kontak" class="mt-2 block rounded-lg bg-primary px-5 py-3 text-center text-sm font-semibold text-white hover:bg-red-600 transition-colors" @click="closeAllMenus">
                        Minta Penawaran
                    </a>
                </nav>
            </div>
        </transition>

        <!-- Desktop Layanan Mega-menu -->
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
                class="hidden lg:block absolute left-0 right-0 top-full z-50 border-t border-[#D9DAD8] bg-white/98 backdrop-blur-sm shadow-2xl max-h-screen overflow-y-auto overscroll-contain"
                @mouseenter="servicesOpen = true"
            >
                <div class="sticky top-0 z-10 border-b border-[#D9DAD8] bg-white/95 backdrop-blur">
                    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-[#1A1B18]">Layanan Kami</h2>
                            <p class="mt-0.5 text-sm text-[#42443D]">Pilih layanan yang sesuai dengan kebutuhan bisnis Anda.</p>
                        </div>
                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-lg border border-[#D9DAD8] px-4 py-2 text-sm font-semibold text-[#42443D] hover:border-primary hover:text-primary transition-colors"
                            @click="servicesOpen = false"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tutup
                        </button>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto px-6 py-6">
                    <div class="grid grid-cols-3 lg:grid-cols-5 gap-3">
                        <a
                            v-for="group in serviceCategories"
                            :key="group.title"
                            :href="group.path"
                            class="group rounded-xl border border-[#D9DAD8] bg-white p-3.5 transition-all duration-200 hover:-translate-y-0.5 hover:border-primary/30 hover:shadow-md"
                            @click="closeAllMenus"
                        >
                            <template v-if="!group.isLogo">
                                <div class="flex items-start gap-2.5">
                                    <div class="relative flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] text-[#1A1B18] transition group-hover:border-primary/30 group-hover:bg-primary/5">
                                        <span class="absolute -right-1 -top-1 h-2.5 w-2.5 rounded-full bg-green-500"></span>
                                        <svg v-if="group.icon === 'building'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M5 21V7l7-4v18M19 21V11h-4M9 9h1M9 13h1M9 17h1M13 9h1M13 13h1M13 17h1" /></svg>
                                        <svg v-else-if="group.icon === 'document'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h7l5 5v13H7zM14 3v6h6M9 13h6M9 17h6" /></svg>
                                        <svg v-else-if="group.icon === 'pin'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 21s-6-5.686-6-11a6 6 0 1112 0c0 5.314-6 11-6 11z" /><circle cx="12" cy="10" r="2.5" stroke-width="1.8" /></svg>
                                        <svg v-else-if="group.icon === 'document-check'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h7l5 5v13H7zM14 3v6h6M9 13h4M14 17l1.5 1.5L19 15" /></svg>
                                        <svg v-else-if="group.icon === 'doc-stack'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h10v13H8zM6 4h10M4 1h10" /></svg>
                                        <svg v-else-if="group.icon === 'globe'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="9" stroke-width="1.8" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12h18M12 3a15 15 0 010 18M12 3a15 15 0 000 18" /></svg>
                                        <svg v-else-if="group.icon === 'license'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h10v18l-5-3-5 3zM9 8h6M9 12h4" /></svg>
                                        <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z" /></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-[#1A1B18] group-hover:text-primary transition-colors leading-tight">{{ group.title }}</h3>
                                        <ul class="mt-1 space-y-0.5 text-xs text-[#42443D]">
                                            <li v-for="item in group.items" :key="item">{{ item }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </template>
                            <template v-else>
                                <div class="h-full min-h-[60px] flex flex-col justify-center">
                                    <div class="text-lg font-bold mb-1" v-html="group.logoText"></div>
                                    <p class="text-xs text-[#42443D] leading-tight">{{ group.desc }}</p>
                                </div>
                            </template>
                        </a>
                    </div>
                    <div class="mt-4 pt-4 border-t border-[#D9DAD8] flex justify-center">
                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-600 transition-colors"
                            @click="servicesOpen = false"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            Tutup Menu
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </header>
</template>
