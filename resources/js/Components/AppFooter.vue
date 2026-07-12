<script setup>
import { computed } from "vue";
import { useI18n } from "vue-i18n";
import { usePage } from "@inertiajs/vue3";

const { t, tm } = useI18n();

const popularLinks = computed(() => tm("common.footer.popularLinks.links"));

const page = usePage();
const site = computed(() => page.props.site || {});
const siteTagline = computed(
    () =>
        site.value.tagline ||
        "Partner Tepercaya untuk Pendirian Perusahaan, Perizinan, dan Legalitas Bisnis Anda di Indonesia",
);

const offices = [
    { key: "head", phone: "0822 9860 4144", email: "cs@fasttrack.legal" },
    { key: "bali", phone: "0822 9860 4144", email: "cs@fasttrack.legal" },
    { key: "surabaya", phone: "0822 9860 4144", email: "cs@fasttrack.legal" },
    { key: "indramayu", phone: "0822 9860 4144", email: "cs@fasttrack.legal" },
];

const navLinks = [
    { key: "home", href: "/" },
    { key: "services", href: "/layanan" },
    { key: "ptSetup", href: "/badan-usaha" },
    { key: "cvSetup", href: "/badan-usaha" },
    { key: "visa", href: "/foreignservice" },
    { key: "virtualOffice", href: "/virtual-office-jakarta" },
    { key: "tools", href: "/panduan-kbli" },
    { key: "blog", href: "/artikel" },
    { key: "info", href: "/faq" },
];

const legalLinks = [
    { key: "terms", href: "/syarat-ketentuan" },
    { key: "privacy", href: "/kebijakan-privasi" },
    { key: "cookie", href: "/kebijakan-cookie" },
];
</script>

<template>
    <footer class="bg-[#42443D] text-[#F9F9F9] py-14 px-4 sm:px-6 lg:px-20" aria-label="Footer FastTrack">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row items-start gap-6 w-full overflow-hidden">
                <!-- Left column -->
                <div class="flex flex-col flex-shrink-0 gap-6 min-w-0">
                    <!-- Logo -->
                    <a href="/" aria-label="FastTrack Beranda">
                        <img src="/icons/logo-fasttrack-white.svg" alt="FastTrack Logo"
                            class="h-8 w-auto object-contain" />
                    </a>

                    <!-- Phone + Email -->
                    <div class="flex flex-col gap-4">
                        <a href="tel:02173885036"
                            class="flex items-start gap-2 text-[14px] text-[#F9F9F9] hover:text-primary transition-colors">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="leading-[21px]">0217 3885 036</span>
                        </a>
                        <a href="mailto:cs@fasttrack.legal"
                            class="flex items-start gap-2 text-[14px] text-[#F9F9F9] hover:text-primary transition-colors">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="leading-[21px]">cs@fasttrack.legal</span>
                        </a>
                    </div>

                    <!-- Social Media -->
                    <div class="grid grid-cols-4 gap-2 w-fit">
                        <a href="https://www.instagram.com/fasttrack.legal/" target="_blank" rel="noopener noreferrer"
                            aria-label="Instagram FastTrack"
                            class="inline-flex items-center justify-center rounded bg-white text-[#9e1f16] hover:bg-primary hover:text-white transition-colors p-2">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427C2.013 15.1 2 14.76 2 12v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" />
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/profile.php?id=61580157707276" target="_blank"
                            rel="noopener noreferrer" aria-label="Facebook FastTrack"
                            class="inline-flex items-center justify-center rounded bg-white text-[#9e1f16] hover:bg-primary hover:text-white transition-colors p-2">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://x.com/fasttrack_legal" target="_blank" rel="noopener noreferrer"
                            aria-label="X (Twitter) FastTrack"
                            class="inline-flex items-center justify-center rounded bg-white text-[#9e1f16] hover:bg-primary hover:text-white transition-colors p-2">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.253 5.622 5.91-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                        <a href="https://www.youtube.com/@FASTTRACKLEGALSERVICE" target="_blank"
                            rel="noopener noreferrer" aria-label="YouTube FastTrack"
                            class="inline-flex items-center justify-center rounded bg-white text-[#9e1f16] hover:bg-primary hover:text-white transition-colors p-2">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 01-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 01-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 011.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418zM15.194 12 10 15V9l5.194 3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://www.threads.com/@fasttrack.legal" target="_blank" rel="noopener noreferrer"
                            aria-label="Threads FastTrack"
                            class="inline-flex items-center justify-center rounded bg-white text-[#9e1f16] hover:bg-primary hover:text-white transition-colors p-2">
                            <img src="/icons/ic-threads.svg" alt="Threads" class="h-6 w-6"
                                style="filter: invert(17%) sepia(87%) saturate(3025%) hue-rotate(345deg) brightness(85%) contrast(100%);" />
                        </a>
                        <a href="https://www.tiktok.com/@fasttracklegal" target="_blank" rel="noopener noreferrer"
                            aria-label="TikTok FastTrack"
                            class="inline-flex items-center justify-center rounded bg-white text-[#9e1f16] hover:bg-primary hover:text-white transition-colors p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.02 1.58 4.23.95 1.2 2.27 2.04 3.75 2.41v3.92c-1.33-.14-2.61-.63-3.69-1.42-.87-.65-1.57-1.49-2.06-2.47v7.5c0 1.63-.44 3.23-1.28 4.62s-2.07 2.47-3.53 3.1c-1.47.63-3.09.83-4.66.56-1.57-.26-3.02-1.02-4.16-2.18-1.15-1.15-1.9-2.61-2.16-4.19-.26-1.57-.05-3.19.6-4.65s1.73-2.66 3.13-3.48c1.4-.82 2.99-1.23 4.61-1.19v4.03c-.8-.06-1.6.14-2.29.57-.69.43-1.21 1.08-1.49 1.84s-.27 1.61.02 2.34c.29.74.83 1.35 1.53 1.74.69.39 1.49.49 2.26.29.77-.2 1.44-.67 1.91-1.33.47-.66.69-1.46.63-2.27V0h.02z" />
                            </svg>
                        </a>
                        <a href="#" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn FastTrack"
                            class="inline-flex items-center justify-center rounded bg-white text-[#9e1f16] hover:bg-primary hover:text-white transition-colors p-2">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                    </div>

                    <!-- Legal links -->
                    <div class="inline-flex flex-col gap-2">
                        <a v-for="link in legalLinks" :key="link.key" :href="link.href"
                            class="text-[14px] font-semibold leading-[21px] text-[#F9F9F9] hover:text-primary transition-colors">
                            {{ t(`common.footer.legal.${link.key}`) }}
                        </a>
                    </div>
                </div>

                <!-- Right columns -->
                <div class="flex flex-col sm:flex-row flex-wrap lg:flex-nowrap flex-1 gap-6 min-w-0 overflow-hidden">
                    <!-- Navigasi -->
                    <div class="flex flex-col flex-shrink-0 gap-6 min-w-0">
                        <h3 class="text-[16px] font-semibold leading-[24px] text-[#F9F9F9]">
                            {{ t("common.footer.nav.title") }}
                        </h3>
                        <div class="flex flex-col gap-2">
                            <a v-for="link in navLinks" :key="link.key" :href="link.href"
                                class="text-[14px] font-semibold leading-[21px] text-[#F9F9F9] hover:text-primary transition-colors whitespace-nowrap">
                                {{ t(`common.footer.nav.${link.key}`) }}
                            </a>
                        </div>
                    </div>

                    <!-- Office columns — loop -->
                    <div v-for="office in offices" :key="office.key" class="flex flex-col flex-1 gap-6 min-w-0">
                        <h3 class="text-[16px] font-semibold leading-[24px] text-[#F9F9F9]">
                            {{ t(`common.footer.offices.${office.key}.title`) }}
                        </h3>
                        <div class="flex flex-col gap-3">
                            <p class="text-[14px] leading-[21px] text-[#F9F9F9]">
                                {{
                                    t(
                                        `common.footer.offices.${office.key}.address`,
                                    )
                                }}
                            </p>
                            <div class="flex flex-col gap-2">
                                <a :href="`https://wa.me/6282298604144`"
                                    class="flex items-start gap-2 text-[14px] leading-[21px] text-[#F9F9F9] hover:text-primary transition-colors">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 8.25c0-2.485-2.099-4.5-4.688-4.5H7.688C5.099 3.75 3 5.765 3 8.25v8.25c0 1.5.826 2.814 2.062 3.438v1.562l2.625-1.313c.525.125 1.075.188 1.625.188h7.5c2.589 0 4.688-2.015 4.688-4.5v-7.5z" />
                                    </svg>
                                    {{ office.phone }}
                                </a>
                                <a :href="`mailto:${office.email}`"
                                    class="flex items-center gap-2 text-[14px] leading-[21px] text-[#F9F9F9] hover:text-primary transition-colors">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ office.email }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 h-px bg-[#8A8D7F66]"></div>

            <div class="mt-6">
                <p class="text-[14px] font-semibold leading-[21px] text-[#F9F9F9]">
                    {{ t("common.footer.popularLinks.title") }}
                </p>
                <nav
                    class="mt-3 flex flex-wrap gap-x-2 gap-y-2 text-[13px] leading-[20px]"
                    aria-label="Popular links"
                >
                    <template
                        v-for="(link, index) in popularLinks"
                        :key="link.href"
                    >
                        <a
                            :href="link.href"
                            class="text-[#C7C8C2] hover:text-primary transition-colors whitespace-nowrap"
                        >
                            {{ link.label }}
                        </a>
                        <span
                            v-if="index < popularLinks.length - 1"
                            class="text-[#8A8D7F66]"
                            aria-hidden="true"
                            >|</span
                        >
                    </template>
                </nav>
            </div>

            <p class="mt-6 text-[14px] font-semibold leading-[21px] text-[#F9F9F9] text-center">
                {{ t("common.footer.copyright") }}
            </p>
        </div>
    </footer>
</template>
