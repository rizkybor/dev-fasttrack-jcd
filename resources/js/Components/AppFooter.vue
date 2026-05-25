<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const site = computed(() => page.props.site || {});
const siteTagline = computed(() => site.value.tagline || 'Legal Services - Partner Terbaik Perusahaan Anda');
</script>

<template>
    <footer class="bg-[#42443D] text-[#F9F9F9]" aria-label="Footer FastTrack">
        <!-- Top bar: logo + kontak + legal links -->
        <div class="border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20 py-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <!-- Logo + sosmed -->
                <div class="flex flex-col gap-4">
                    <a href="/" aria-label="FastTrack Beranda">
                        <img src="/images/logo-fasttrack.png" alt="FastTrack Logo" class="h-8 w-auto object-contain brightness-0 invert">
                    </a>
                    <div class="flex items-center gap-3">
                        <a href="https://instagram.com/fasttrack" target="_blank" rel="noopener noreferrer" aria-label="Instagram FastTrack" class="flex h-8 w-8 items-center justify-center rounded-full border border-white/20 text-[#F9F9F9] hover:bg-primary hover:border-primary transition-colors">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427C2.013 15.1 2 14.76 2 12v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" /></svg>
                        </a>
                        <a href="https://facebook.com/fasttrack" target="_blank" rel="noopener noreferrer" aria-label="Facebook FastTrack" class="flex h-8 w-8 items-center justify-center rounded-full border border-white/20 text-[#F9F9F9] hover:bg-primary hover:border-primary transition-colors">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="https://x.com/fasttrack" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter) FastTrack" class="flex h-8 w-8 items-center justify-center rounded-full border border-white/20 text-[#F9F9F9] hover:bg-primary hover:border-primary transition-colors">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.253 5.622 5.91-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z" /></svg>
                        </a>
                        <a href="https://youtube.com/fasttrack" target="_blank" rel="noopener noreferrer" aria-label="YouTube FastTrack" class="flex h-8 w-8 items-center justify-center rounded-full border border-white/20 text-[#F9F9F9] hover:bg-primary hover:border-primary transition-colors">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 01-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 01-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 011.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418zM15.194 12 10 15V9l5.194 3z" clip-rule="evenodd" /></svg>
                        </a>
                    </div>
                </div>

                <!-- Kontak singkat -->
                <div class="flex flex-col sm:flex-row gap-4 text-sm">
                    <a href="tel:0217388503" class="flex items-center gap-2 text-[#F9F9F9]/80 hover:text-[#F9F9F9] transition-colors">
                        <svg class="h-4 w-4 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        0217 3885 036
                    </a>
                    <a href="mailto:cs@fasttrack.legal" class="flex items-center gap-2 text-[#F9F9F9]/80 hover:text-[#F9F9F9] transition-colors">
                        <svg class="h-4 w-4 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        cs@fasttrack.legal
                    </a>
                </div>

                <!-- Legal links -->
                <div class="flex flex-wrap gap-4 text-sm">
                    <a href="/syarat-ketentuan" class="font-semibold text-[#F9F9F9] hover:text-primary transition-colors">Syarat &amp; Ketentuan</a>
                    <a href="/kebijakan-privasi" class="font-semibold text-[#F9F9F9] hover:text-primary transition-colors">Kebijakan Privasi</a>
                    <a href="/kebijakan-cookie" class="font-semibold text-[#F9F9F9] hover:text-primary transition-colors">Kebijakan Cookie</a>
                </div>
            </div>
        </div>

        <!-- Main footer columns -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20 py-10">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
                <!-- Navigasi -->
                <div class="col-span-2 md:col-span-1">
                    <h3 class="text-[16px] font-semibold text-[#F9F9F9] mb-4">Navigasi:</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="/" class="text-[#F9F9F9]/75 hover:text-[#F9F9F9] font-semibold transition-colors">Beranda</a></li>
                        <li><a href="/layanan" class="text-[#F9F9F9]/75 hover:text-[#F9F9F9] font-semibold transition-colors">Layanan</a></li>
                        <li><a href="/pendirian-perusahaan" class="text-[#F9F9F9]/75 hover:text-[#F9F9F9] font-semibold transition-colors">Pendirian PT</a></li>
                        <li><a href="/pendirian-perusahaan" class="text-[#F9F9F9]/75 hover:text-[#F9F9F9] font-semibold transition-colors">Pendirian CV</a></li>
                        <li><a href="/foreignservice" class="text-[#F9F9F9]/75 hover:text-[#F9F9F9] font-semibold transition-colors">Visa</a></li>
                        <li><a href="/virtual-office-jakarta" class="text-[#F9F9F9]/75 hover:text-[#F9F9F9] font-semibold transition-colors">Virtual Office</a></li>
                        <li><a href="/kbli" class="text-[#F9F9F9]/75 hover:text-[#F9F9F9] font-semibold transition-colors">Peralatan dan Fitur</a></li>
                        <li><a href="/artikel" class="text-[#F9F9F9]/75 hover:text-[#F9F9F9] font-semibold transition-colors">Blog</a></li>
                        <li><a href="/faq" class="text-[#F9F9F9]/75 hover:text-[#F9F9F9] font-semibold transition-colors">Informasi</a></li>
                    </ul>
                </div>

                <!-- Head Office -->
                <div>
                    <h3 class="text-[14px] font-semibold text-[#F9F9F9] mb-4">Head Office:</h3>
                    <p class="text-sm text-[#F9F9F9]/75 leading-relaxed mb-3">
                        Grand Bintaro Blok A7, Jl. Raya Bintaro Permai, Pesanggrahan, Bintaro, Jakarta Selatan - 12330
                    </p>
                    <div class="space-y-2 text-sm">
                        <a href="https://wa.me/6282298604144" class="flex items-center gap-2 text-[#F9F9F9]/75 hover:text-[#F9F9F9] transition-colors">
                            <svg class="h-3.5 w-3.5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 8.25c0-2.485-2.099-4.5-4.688-4.5H7.688C5.099 3.75 3 5.765 3 8.25v8.25c0 1.5.826 2.814 2.062 3.438v1.562l2.625-1.313c.525.125 1.075.188 1.625.188h7.5c2.589 0 4.688-2.015 4.688-4.5v-7.5z" /></svg>
                            0822 9860 4144
                        </a>
                        <a href="mailto:cs@fasttrack.legal" class="flex items-center gap-2 text-[#F9F9F9]/75 hover:text-[#F9F9F9] transition-colors">
                            <svg class="h-3.5 w-3.5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            cs@fasttrack.legal
                        </a>
                    </div>
                </div>

                <!-- Bali Office -->
                <div>
                    <h3 class="text-[16px] font-semibold text-[#F9F9F9] mb-4">Bali Office:</h3>
                    <p class="text-sm text-[#F9F9F9]/75 leading-relaxed mb-3">
                        Jl. By Pass Ngurah Rai No. 264, Sanur, Denpasar - Bali 80228
                    </p>
                    <div class="space-y-2 text-sm">
                        <a href="https://wa.me/6282298604144" class="flex items-center gap-2 text-[#F9F9F9]/75 hover:text-[#F9F9F9] transition-colors">
                            <svg class="h-3.5 w-3.5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 8.25c0-2.485-2.099-4.5-4.688-4.5H7.688C5.099 3.75 3 5.765 3 8.25v8.25c0 1.5.826 2.814 2.062 3.438v1.562l2.625-1.313c.525.125 1.075.188 1.625.188h7.5c2.589 0 4.688-2.015 4.688-4.5v-7.5z" /></svg>
                            0822 9860 4144
                        </a>
                        <a href="mailto:cs@fasttrack.legal" class="flex items-center gap-2 text-[#F9F9F9]/75 hover:text-[#F9F9F9] transition-colors">
                            <svg class="h-3.5 w-3.5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            cs@fasttrack.legal
                        </a>
                    </div>
                </div>

                <!-- Surabaya Office -->
                <div>
                    <h3 class="text-[16px] font-semibold text-[#F9F9F9] mb-4">Surabaya Office:</h3>
                    <p class="text-sm text-[#F9F9F9]/75 leading-relaxed mb-3">
                        Jl. Taman Pondok Legi III, Blok Y No. 1A, Peplegi, Waru, Kab. Sidoarjo, Jawa Timur 61256
                    </p>
                    <div class="space-y-2 text-sm">
                        <a href="https://wa.me/6282298604144" class="flex items-center gap-2 text-[#F9F9F9]/75 hover:text-[#F9F9F9] transition-colors">
                            <svg class="h-3.5 w-3.5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 8.25c0-2.485-2.099-4.5-4.688-4.5H7.688C5.099 3.75 3 5.765 3 8.25v8.25c0 1.5.826 2.814 2.062 3.438v1.562l2.625-1.313c.525.125 1.075.188 1.625.188h7.5c2.589 0 4.688-2.015 4.688-4.5v-7.5z" /></svg>
                            0822 9860 4144
                        </a>
                        <a href="mailto:cs@fasttrack.legal" class="flex items-center gap-2 text-[#F9F9F9]/75 hover:text-[#F9F9F9] transition-colors">
                            <svg class="h-3.5 w-3.5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            cs@fasttrack.legal
                        </a>
                    </div>
                </div>

                <!-- Indramayu Office -->
                <div>
                    <h3 class="text-[16px] font-semibold text-[#F9F9F9] mb-4">Indramayu Office:</h3>
                    <p class="text-sm text-[#F9F9F9]/75 leading-relaxed mb-3">
                        Jl. Taman Pondok Legi III, Blok Y No. 1A, Peplegi, Waru, Kab. Sidoarjo, Jawa Timur 61256
                    </p>
                    <div class="space-y-2 text-sm">
                        <a href="https://wa.me/6282298604144" class="flex items-center gap-2 text-[#F9F9F9]/75 hover:text-[#F9F9F9] transition-colors">
                            <svg class="h-3.5 w-3.5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 8.25c0-2.485-2.099-4.5-4.688-4.5H7.688C5.099 3.75 3 5.765 3 8.25v8.25c0 1.5.826 2.814 2.062 3.438v1.562l2.625-1.313c.525.125 1.075.188 1.625.188h7.5c2.589 0 4.688-2.015 4.688-4.5v-7.5z" /></svg>
                            0822 9860 4144
                        </a>
                        <a href="mailto:cs@fasttrack.legal" class="flex items-center gap-2 text-[#F9F9F9]/75 hover:text-[#F9F9F9] transition-colors">
                            <svg class="h-3.5 w-3.5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            cs@fasttrack.legal
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-sm text-[#F9F9F9]/60">
                    &copy; {{ new Date().getFullYear() }} FastTrack. Hak Cipta Dilindungi.
                </p>
                <p class="text-xs text-[#F9F9F9]/40">
                    {{ siteTagline }}
                </p>
            </div>
        </div>
    </footer>
</template>
