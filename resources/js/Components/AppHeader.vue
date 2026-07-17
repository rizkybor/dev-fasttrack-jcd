<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import { useI18n } from "vue-i18n";
import { useLocale } from "@/Composables/useLocale";

const { t, tm } = useI18n();
const { languages, current, setLocale } = useLocale();
const langOpen = ref(false);

const servicesOpen = ref(false);
const informasiOpen = ref(false);
const mobileMenuOpen = ref(false);
const mobileServicesOpen = ref(false);
const mobileInformasiOpen = ref(false);

// Mobile accordion: which category / service is expanded
const mobileActiveCategory = ref(null);
const mobileActiveService = ref(null);

// Desktop mega-menu: which services have their sub layanan expanded (hidden by default)
const expandedServices = ref(new Set());
const serviceKey = (category, service) => `${category.title}::${service.title}`;
const toggleDesktopService = (key) => {
    if (expandedServices.value.has(key)) {
        expandedServices.value.delete(key);
    } else {
        expandedServices.value.add(key);
    }
};

const serviceCategories = computed(() => tm("services.megaMenu.categories"));
const serviceTools = computed(() => tm("services.megaMenu.tools"));

const informasiLinks = [
    { key: "kbli", path: "/panduan-kbli" },
    { key: "faq", path: "/faq" },
];

const closeAllMenus = () => {
    servicesOpen.value = false;
    informasiOpen.value = false;
    mobileMenuOpen.value = false;
    mobileServicesOpen.value = false;
    mobileInformasiOpen.value = false;
    mobileActiveCategory.value = null;
    mobileActiveService.value = null;
    expandedServices.value.clear();
};

const toggleServices = () => {
    servicesOpen.value = !servicesOpen.value;
    informasiOpen.value = false;
};

const toggleInformasi = () => {
    informasiOpen.value = !informasiOpen.value;
    servicesOpen.value = false;
};

const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
    if (!mobileMenuOpen.value) {
        mobileServicesOpen.value = false;
        mobileInformasiOpen.value = false;
        mobileActiveCategory.value = null;
        mobileActiveService.value = null;
    }
};

const toggleMobileCategory = (index) => {
    mobileActiveCategory.value = mobileActiveCategory.value === index ? null : index;
    mobileActiveService.value = null;
};

const toggleMobileService = (index) => {
    mobileActiveService.value = mobileActiveService.value === index ? null : index;
};

const handleOutsideClick = (e) => {
    if (!e.target.closest("header")) {
        servicesOpen.value = false;
        informasiOpen.value = false;
    }
};

onMounted(() => document.addEventListener("click", handleOutsideClick));
onUnmounted(() => document.removeEventListener("click", handleOutsideClick));
</script>

<template>
    <header class="sticky top-0 z-50 bg-[#FEFEFE]/95 backdrop-blur-md border-b border-[#D9DAD8] shadow-sm">
        <!-- Top bar: KERJASAMA -->
        <div class="hidden lg:flex items-center h-[48px] overflow-hidden">
            <div class="flex-shrink-0 h-full" style="
                    width: 62.2%;
                    clip-path: polygon(
                        0 0,
                        99% 0,
                        calc(100% - 50px) 100%,
                        0 100%
                    );
                ">
                <div class="w-full h-full bg-[#9e1f16]"></div>
            </div>
            <div class="flex items-center justify-between flex-1 h-full bg-[#42443D]"
                style="margin-left: -50px; padding: 7px 84px 9px 80px">
                <a href="/kerjasama" class="inline-flex items-center gap-1 h-8 group">
                    <span
                        class="text-[18px] font-bold leading-[21px] text-[#FEFEFE] transition-colors group-hover:text-[#FFB347]">
                        {{ t("common.nav.cooperation") }}
                    </span>
                    <span class="text-[18px] leading-none transition-transform group-hover:scale-125">🔥</span>
                </a>
                <div class="inline-flex items-center gap-2">
                    <a href="mailto:cs@fasttrack.legal" aria-label="Email FastTrack"
                        class="inline-flex items-center justify-center rounded bg-white text-[#9e1f16] hover:bg-[#9e1f16] hover:text-white transition-colors p-[6px]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/fasttrack.legal/" target="_blank" rel="noopener noreferrer"
                        aria-label="Instagram FastTrack"
                        class="inline-flex items-center justify-center rounded bg-white text-[#9e1f16] hover:bg-[#9e1f16] hover:text-white transition-colors p-[6px]">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427C2.013 15.1 2 14.76 2 12v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main nav row -->
        <div class="px-4 sm:px-6 lg:px-20">
            <div class="flex items-center justify-between h-16 lg:h-[60px]">
                <!-- Logo -->
                <a href="/" class="flex-shrink-0 flex items-center" aria-label="FastTrack Beranda">
                    <img src="/icons/logo-fasttrack.svg" alt="FastTrack Logo" class="h-13 w-auto object-contain" />
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden lg:flex items-center gap-1" aria-label="Navigasi Utama">
                    <!-- PENAWARAN KHUSUS -->
                    <a href="/#promo"
                        class="flex items-center gap-1 px-3 py-2.5 text-[14px] font-semibold text-[#1A1B18] hover:text-primary transition-colors whitespace-nowrap">
                        {{ t("common.nav.promo") }}
                        <img src="/icons/half-rounded.svg" class="w-4 h-4" alt="" />
                    </a>

                    <!-- LAYANAN dropdown -->
                    <div class="relative">
                        <button type="button"
                            class="flex items-center gap-1 px-3 py-2.5 text-[14px] font-semibold transition-colors whitespace-nowrap"
                            :class="servicesOpen
                                    ? 'text-primary'
                                    : 'text-[#1A1B18] hover:text-primary'
                                " @click="toggleServices" :aria-expanded="servicesOpen">
                            {{ t("common.nav.services") }}
                            <svg class="w-4 h-4 transition-transform duration-200" :class="servicesOpen
                                    ? 'rotate-180 text-primary'
                                    : ''
                                " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>

                    <!-- TENTANG KAMI -->
                    <a href="/#tentang-kami"
                        class="flex items-center px-3 py-2.5 text-[14px] font-semibold text-[#1A1B18] hover:text-primary transition-colors whitespace-nowrap">
                        {{ t("common.nav.about") }}
                    </a>

                    <!-- Artikel -->
                    <a href="/artikel"
                        class="flex items-center px-3 py-2.5 text-[14px] font-semibold text-[#1A1B18] hover:text-primary transition-colors whitespace-nowrap">
                        {{ t("common.nav.blog") }}
                    </a>

                    <!-- INFORMASI dropdown -->
                    <div class="relative">
                        <button type="button"
                            class="flex items-center gap-1 px-3 py-2.5 text-[14px] font-semibold transition-colors whitespace-nowrap"
                            :class="informasiOpen
                                    ? 'text-primary'
                                    : 'text-[#1A1B18] hover:text-primary'
                                " @click="toggleInformasi" :aria-expanded="informasiOpen">
                            {{ t("common.nav.info") }}
                            <svg class="w-4 h-4 transition-transform duration-200" :class="informasiOpen
                                    ? 'rotate-180 text-primary'
                                    : ''
                                " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <transition enter-active-class="transition duration-200 ease-out"
                            enter-from-class="opacity-0 scale-95 -translate-y-2"
                            enter-to-class="opacity-100 scale-100 translate-y-0"
                            leave-active-class="transition duration-150 ease-in"
                            leave-from-class="opacity-100 scale-100 translate-y-0"
                            leave-to-class="opacity-0 scale-95 -translate-y-2">
                            <div v-if="informasiOpen"
                                class="absolute right-0 top-full mt-1 w-48 rounded-xl border border-[#D9DAD8] bg-white p-1.5 shadow-xl origin-top">
                                <a v-for="link in informasiLinks" :key="link.path" :href="link.path"
                                    class="block rounded-lg px-4 py-2.5 text-sm font-semibold text-[#1A1B18] hover:bg-[#9e1f16]/5 hover:text-primary transition-colors"
                                    @click="closeAllMenus">
                                    {{ t(`common.nav.informasi.${link.key}`) }}
                                </a>
                            </div>
                        </transition>
                    </div>
                </nav>

                <!-- Right: Lang + CTA -->
                <div class="hidden lg:flex items-center gap-2">
                    <!-- Language Selector Desktop -->
                    <div class="relative">
                        <button type="button"
                            class="flex items-center gap-1.5 border border-[#D9DAD8] rounded-lg px-3 py-2 text-[14px] font-semibold text-[#1A1B18] hover:border-primary hover:text-primary transition-colors"
                            @click="langOpen = !langOpen" @blur="langOpen = false" :aria-expanded="langOpen">
                            <span class="text-base leading-none">{{
                                current.flag
                                }}</span>
                            <span>{{ current.code.toUpperCase() }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="langOpen ? 'rotate-180 text-primary' : ''
                                " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <transition enter-active-class="transition duration-200 ease-out"
                            enter-from-class="opacity-0 scale-95 -translate-y-2"
                            enter-to-class="opacity-100 scale-100 translate-y-0"
                            leave-active-class="transition duration-150 ease-in"
                            leave-from-class="opacity-100 scale-100 translate-y-0"
                            leave-to-class="opacity-0 scale-95 -translate-y-2">
                            <div v-if="langOpen"
                                class="absolute right-0 top-full mt-1.5 w-44 rounded-xl border border-[#D9DAD8] bg-white p-1.5 shadow-xl origin-top-right z-[60]">
                                <button v-for="lang in languages" :key="lang.code" type="button"
                                    class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2.5 text-sm font-semibold transition-colors"
                                    :class="current.code === lang.code
                                            ? 'bg-[#9e1f16]/8 text-primary'
                                            : 'text-[#1A1B18] hover:bg-[#9e1f16]/5 hover:text-primary'
                                        " @mousedown.prevent="
                                        setLocale(lang.code);
                                    langOpen = false;
                                    ">
                                    <span class="text-xl leading-none">{{
                                        lang.flag
                                        }}</span>
                                    <div class="flex flex-col items-start leading-none">
                                        <span class="font-bold">{{
                                            lang.code.toUpperCase()
                                            }}</span>
                                        <span class="text-xs text-[#42443D] mt-0.5 font-normal">
                                            {{ t(`common.lang.${lang.code}`) }}
                                        </span>
                                    </div>
                                    <svg v-if="current.code === lang.code" class="ml-auto h-4 w-4 text-primary"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </div>
                        </transition>
                    </div>

                    <!-- CTA Button -->
                    <a href="/minta-penawaran"
                        class="inline-flex items-center gap-2 bg-[#9e1f16] hover:bg-red-600 text-white font-semibold text-[16px] px-4 py-2 rounded-lg transition-colors shadow-sm whitespace-nowrap">
                        {{ t("common.nav.cta") }}
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button type="button"
                    class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-lg border border-[#D9DAD8] text-[#1A1B18] hover:border-primary hover:text-primary transition-colors focus:outline-none"
                    :aria-expanded="mobileMenuOpen" aria-controls="mobile-navigation" aria-label="Buka menu navigasi"
                    @click="toggleMobileMenu">
                    <svg v-if="!mobileMenuOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0 -translate-y-3"
            enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 -translate-y-3">
            <div v-if="mobileMenuOpen" id="mobile-navigation"
                class="lg:hidden fixed left-0 right-0 z-50 h-[calc(100vh-60px)] overflow-y-auto overscroll-contain border-t border-[#E5E5E0] bg-white shadow-xl"
                style="top: 60px">
                <nav class="px-3 pt-3 pb-5" aria-label="Mobile Navigation">
                    <p class="text-[10px] font-bold tracking-widest text-[#AAAAAA] uppercase px-2 pb-2">
                        {{ t("common.nav.menu") }}
                    </p>

                    <!-- PENAWARAN KHUSUS -->
                    <a href="/#promo"
                        class="flex items-center gap-3 px-3 py-3 rounded-xl text-[13.5px] font-semibold text-[#1A1B18] hover:bg-[#FEF0F0] hover:text-[#9e1f16] transition-colors"
                        @click="closeAllMenus">
                        <span
                            class="flex-shrink-0 w-8 h-8 rounded-lg bg-[#F5F5F3] flex items-center justify-center text-base">🏷️</span>
                        {{ t("common.nav.promo") }}
                        <span
                            class="ml-auto text-[10px] font-bold bg-[#9e1f16] text-white px-2 py-0.5 rounded-full tracking-wide">HOT</span>
                    </a>

                    <div class="h-1"></div>

                    <!-- LAYANAN accordion -->
                    <div class="rounded-xl border border-[#E5E5E0] overflow-hidden">
                        <button type="button"
                            class="flex w-full items-center gap-3 px-3 py-3 text-[13.5px] font-semibold transition-colors"
                            :class="mobileServicesOpen
                                    ? 'bg-[#FEF0F0] text-[#9e1f16]'
                                    : 'bg-[#FAFAF8] text-[#1A1B18]'
                                " :aria-expanded="mobileServicesOpen" @click="mobileServicesOpen = !mobileServicesOpen">
                            <span
                                class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center text-base transition-colors"
                                :class="mobileServicesOpen
                                        ? 'bg-[#FEF0F0]'
                                        : 'bg-[#F0F0EE]'
                                    ">🏢</span>
                            {{ t("common.nav.services") }}
                            <svg class="ml-auto h-[18px] w-[18px] transition-transform duration-200 flex-shrink-0"
                                :class="mobileServicesOpen
                                        ? 'rotate-180 text-[#9e1f16]'
                                        : 'text-[#999]'
                                    " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div v-if="mobileServicesOpen" class="border-t border-[#E5E5E0] bg-[#FAFAF8] p-1.5 space-y-0.5">
                            <!-- Level 1: Title -->
                            <div v-for="(category, cIdx) in serviceCategories" :key="`mobile-cat-${category.title}`">
                                <button type="button"
                                    class="flex w-full items-center gap-2 px-3 py-2.5 rounded-lg text-[12.5px] font-bold transition-colors text-left"
                                    :class="mobileActiveCategory === cIdx
                                            ? 'bg-white text-[#9e1f16]'
                                            : 'text-[#1A1B18] hover:bg-white/70'
                                        " :aria-expanded="mobileActiveCategory === cIdx"
                                    @click="toggleMobileCategory(cIdx)">
                                    {{ category.title }}
                                    <svg class="ml-auto h-3.5 w-3.5 transition-transform duration-200 flex-shrink-0"
                                        :class="mobileActiveCategory === cIdx
                                                ? 'rotate-180 text-[#9e1f16]'
                                                : 'text-[#999]'
                                            " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Level 2: Layanan -->
                                <div v-if="mobileActiveCategory === cIdx" class="pl-3 py-0.5 space-y-0.5">
                                    <div v-for="(service, sIdx) in category.services"
                                        :key="`mobile-svc-${service.title}`">
                                        <div class="flex items-stretch">
                                            <a :href="service.path"
                                                class="flex-1 px-3 py-2 rounded-lg text-[12px] font-semibold text-[#42443D] hover:bg-white hover:text-[#9e1f16] transition-colors"
                                                @click="closeAllMenus">{{ service.title }}</a>
                                            <button v-if="service.items && service.items.length" type="button"
                                                class="px-2.5 flex items-center justify-center text-[#999]"
                                                :aria-expanded="mobileActiveService === sIdx"
                                                @click="toggleMobileService(sIdx)">
                                                <svg class="h-3 w-3 transition-transform duration-200" :class="mobileActiveService === sIdx
                                                        ? 'rotate-180 text-[#9e1f16]'
                                                        : ''
                                                    " fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Level 3: Sub Layanan -->
                                        <div v-if="mobileActiveService === sIdx && service.items && service.items.length"
                                            class="pl-3 flex flex-col">
                                            <a v-for="item in service.items" :key="item.path" :href="item.path"
                                                class="px-3 py-1.5 rounded-lg text-[11.5px] text-[#42443D] hover:bg-white hover:text-[#9e1f16] transition-colors leading-snug"
                                                @click="closeAllMenus">{{ item.label }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="h-1"></div>

                    <!-- TENTANG KAMI -->
                    <a href="/#tentang-kami"
                        class="flex items-center gap-3 px-3 py-3 rounded-xl text-[13.5px] font-semibold text-[#1A1B18] hover:bg-[#FEF0F0] hover:text-[#9e1f16] transition-colors"
                        @click="closeAllMenus">
                        <span
                            class="flex-shrink-0 w-8 h-8 rounded-lg bg-[#F5F5F3] flex items-center justify-center text-base">ℹ️</span>
                        {{ t("common.nav.about") }}
                    </a>

                    <!-- BLOG -->
                    <a href="/artikel"
                        class="flex items-center gap-3 px-3 py-3 rounded-xl text-[13.5px] font-semibold text-[#1A1B18] hover:bg-[#FEF0F0] hover:text-[#9e1f16] transition-colors"
                        @click="closeAllMenus">
                        <span
                            class="flex-shrink-0 w-8 h-8 rounded-lg bg-[#F5F5F3] flex items-center justify-center text-base">📝</span>
                        {{ t("common.nav.blog") }}
                    </a>

                    <div class="h-1"></div>

                    <!-- INFORMASI accordion -->
                    <div class="rounded-xl border border-[#E5E5E0] overflow-hidden">
                        <button type="button"
                            class="flex w-full items-center gap-3 px-3 py-3 text-[13.5px] font-semibold transition-colors"
                            :class="mobileInformasiOpen
                                    ? 'bg-[#FEF0F0] text-[#9e1f16]'
                                    : 'bg-[#FAFAF8] text-[#1A1B18]'
                                " :aria-expanded="mobileInformasiOpen" @click="mobileInformasiOpen = !mobileInformasiOpen">
                            <span
                                class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center text-base transition-colors"
                                :class="mobileInformasiOpen
                                        ? 'bg-[#FEF0F0]'
                                        : 'bg-[#F0F0EE]'
                                    ">📚</span>
                            {{ t("common.nav.info") }}
                            <svg class="ml-auto h-[18px] w-[18px] transition-transform duration-200 flex-shrink-0"
                                :class="mobileInformasiOpen
                                        ? 'rotate-180 text-[#9e1f16]'
                                        : 'text-[#999]'
                                    " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div v-if="mobileInformasiOpen"
                            class="border-t border-[#E5E5E0] bg-[#FAFAF8] p-1.5 flex flex-col gap-1">
                            <a v-for="link in informasiLinks" :key="link.path" :href="link.path"
                                class="px-3 py-2.5 rounded-lg text-[13px] font-medium text-[#42443D] hover:bg-[#FEF0F0] hover:text-[#9e1f16] transition-colors"
                                @click="closeAllMenus">
                                {{ t(`common.nav.informasi.${link.key}`) }}
                            </a>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="my-3 h-px bg-[#F0F0EE]"></div>

                    <!-- Language Selector Mobile -->
                    <div class="grid grid-cols-3 gap-2 px-0.5">
                        <button v-for="lang in languages" :key="lang.code" type="button"
                            class="flex flex-col items-center justify-center gap-1 py-3 px-2 rounded-xl border text-center transition-all"
                            :class="current.code === lang.code
                                    ? 'border-[#9e1f16] bg-[#FEF0F0] text-[#9e1f16]'
                                    : 'border-[#E5E5E0] bg-[#FAFAF8] text-[#1A1B18] hover:border-[#9e1f16]/40 hover:bg-[#FEF0F0]/50'
                                " @click="setLocale(lang.code)">
                            <span class="text-2xl leading-none">{{
                                lang.flag
                                }}</span>
                            <span class="text-[12px] font-bold leading-none">{{
                                lang.code.toUpperCase()
                                }}</span>
                            <span class="text-[10px] font-medium leading-none" :class="current.code === lang.code
                                    ? 'text-[#9e1f16]/70'
                                    : 'text-[#999]'
                                ">
                                {{ t(`common.lang.${lang.code}`) }}
                            </span>
                        </button>
                    </div>

                    <!-- CTA Mobile -->
                    <a href="/minta-penawaran"
                        class="mt-3 flex items-center justify-center gap-2 rounded-xl bg-[#9e1f16] hover:bg-[#C8353A] px-5 py-4 text-[14px] font-bold text-white transition-colors tracking-wide"
                        @click="closeAllMenus">
                        {{ t("common.nav.cta") }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>

                    <!-- Copyright -->
                    <p class="mt-2 text-[9px] font-semibold leading-[21px] text-black text-center">
                        {{ t("common.footer.copyright") }}
                    </p>
                </nav>
            </div>
        </transition>

        <!-- Desktop Layanan Mega-menu -->
        <template v-if="servicesOpen">
            <div class="fixed inset-0 z-40 bg-black/40" style="top: 108px" @click="servicesOpen = false"></div>
            <div class="absolute left-0 right-0 z-50 border-t border-[#D9DAD8] bg-white shadow-2xl overflow-y-auto overscroll-contain"
                style="top: 100%; max-height: calc(100vh - 108px)">
                <div class="sticky top-0 left-0 right-0 z-10 w-full border-b border-[#D9DAD8] bg-white">
                    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-[#1A1B18]">
                                {{ t("common.nav.services") }}
                            </h2>
                            <p class="mt-0.5 text-sm text-[#42443D]">
                                {{ t("common.nav.servicesDesc") }}
                            </p>
                        </div>
                        <button type="button"
                            class="inline-flex items-center gap-2 rounded-lg border border-[#D9DAD8] px-4 py-2 text-sm font-semibold text-[#42443D] hover:border-primary hover:text-primary transition-colors"
                            @click="servicesOpen = false">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ t("common.nav.close") }}
                        </button>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto px-6 py-6">
                    <div class="grid grid-cols-3 lg:grid-cols-4 gap-3">
                        <div v-for="category in serviceCategories" :key="category.title"
                            class="rounded-xl border border-[#D9DAD8] bg-white p-3.5">
                            <div class="flex items-start gap-2.5">
                                <div
                                    class="relative flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg border border-[#D9DAD8] bg-[#F9F9F9] text-[#1A1B18]">
                                    <span class="absolute -right-1 -top-1 h-2.5 w-2.5 rounded-full bg-green-500"></span>
                                    <svg v-if="category.icon === 'building'" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M3 21h18M5 21V7l7-4v18M19 21V11h-4M9 9h1M9 13h1M9 17h1M13 9h1M13 13h1M13 17h1" />
                                    </svg>
                                    <svg v-else-if="category.icon === 'document'" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M7 3h7l5 5v13H7zM14 3v6h6M9 13h6M9 17h6" />
                                    </svg>
                                    <svg v-else-if="category.icon === 'pin'" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M12 21s-6-5.686-6-11a6 6 0 1112 0c0 5.314-6 11-6 11z" />
                                        <circle cx="12" cy="10" r="2.5" stroke-width="1.8" />
                                    </svg>
                                    <svg v-else-if="category.icon === 'document-check'" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M7 3h7l5 5v13H7zM14 3v6h6M9 13h4M14 17l1.5 1.5L19 15" />
                                    </svg>
                                    <svg v-else-if="category.icon === 'doc-stack'" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M8 7h10v13H8zM6 4h10M4 1h10" />
                                    </svg>
                                    <svg v-else-if="category.icon === 'globe'" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <circle cx="12" cy="12" r="9" stroke-width="1.8" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M3 12h18M12 3a15 15 0 010 18M12 3a15 15 0 000 18" />
                                    </svg>
                                    <svg v-else-if="category.icon === 'license'" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M7 3h10v18l-5-3-5 3zM9 8h6M9 12h4" />
                                    </svg>
                                    <svg v-else-if="category.icon === 'shield'" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M12 3l7 3v6c0 4.5-3 8-7 9-4-1-7-4.5-7-9V6l7-3z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M9 12l2 2 4-4" />
                                    </svg>
                                    <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z" />
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-sm font-bold text-[#1A1B18] leading-tight">
                                        {{ category.title }}
                                    </h3>
                                    <div class="mt-1.5 space-y-2">
                                        <div v-for="service in category.services" :key="service.title">
                                            <div class="-mx-1.5 flex items-center gap-1">
                                                <a :href="service.path"
                                                    class="block flex-1 rounded px-1.5 py-0.5 text-xs font-bold text-[#1A1B18] transition-colors hover:bg-[#9e1f16]/5 hover:text-primary"
                                                    @click="closeAllMenus">
                                                    {{ service.title }}
                                                </a>
                                                <button v-if="service.items && service.items.length" type="button"
                                                    class="flex-shrink-0 p-1 text-[#999] hover:text-primary transition-colors"
                                                    :aria-expanded="expandedServices.has(serviceKey(category, service))"
                                                    @click="toggleDesktopService(serviceKey(category, service))">
                                                    <svg class="h-3 w-3 transition-transform duration-200"
                                                        :class="expandedServices.has(serviceKey(category, service)) ? 'rotate-180' : ''"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <ul v-if="service.items && service.items.length && expandedServices.has(serviceKey(category, service))"
                                                class="mt-0.5 ml-1.5 space-y-0.5 border-l border-[#EFEFEF] pl-2">
                                                <li v-for="item in service.items" :key="item.path">
                                                    <a :href="item.path"
                                                        class="-mx-1.5 block rounded px-1.5 py-1 text-xs text-[#42443D] transition-colors hover:bg-[#9e1f16]/5 hover:text-primary"
                                                        @click="closeAllMenus">
                                                        {{ item.label }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tools section -->
                    <div class="mt-6 pt-6 border-t border-[#D9DAD8]">
                        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-[#1A1B18]">
                                    Tools
                                </h2>
                                <p class="mt-0.5 text-sm text-[#42443D]">
                                    {{ t("common.nav.toolsDesc") }}
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 lg:grid-cols-5 gap-3">
                            <a v-for="group in serviceTools" :key="group.title" :href="group.path"
                                class="group rounded-xl border border-[#D9DAD8] bg-white p-3.5 transition-all duration-200 hover:-translate-y-0.5 hover:border-primary/30 hover:shadow-md"
                                @click="closeAllMenus">
                                <div class="flex items-start gap-2.5">
                                    <img :src="group.icon" :alt="group.title" class="h-8 w-8" />
                                    <div>
                                        <h3
                                            class="text-sm font-bold text-[#1A1B18] group-hover:text-primary transition-colors leading-tight">
                                            {{ group.title }}
                                        </h3>
                                        <ul class="mt-1 space-y-0.5 text-xs text-[#42443D]">
                                            <li v-for="item in group.items" :key="item">
                                                {{ item }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </header>
</template>
