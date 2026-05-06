<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    services: {
        type: Array,
        default: () => [],
    },
});

const whatsappNumber = '6282298604144';

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(price);
};

const buildWhatsappLink = (serviceName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai layanan ${serviceName}.`;

    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

const goToService = (serviceSlug) => {
    window.location.href = `/layanan/${serviceSlug}`;
};

const trustPoints = [
    'Pilihan layanan legalitas dan perizinan untuk berbagai kebutuhan bisnis',
    'Alur layanan lebih jelas, efisien, dan nyaman diikuti',
    'Siap membantu dari tahap konsultasi awal sampai tindak lanjut dokumen',
];
</script>

<template>
    <MainLayout>
        <section class="relative overflow-hidden border-b border-gray-100 bg-gradient-to-b from-rose-50/70 via-white to-white py-16 sm:py-20">
            <div class="absolute inset-x-0 top-0 h-64 bg-[radial-gradient(circle_at_top,rgba(255,45,85,0.10),transparent_45%)]"></div>
            <div class="absolute right-0 top-10 h-48 w-48 rounded-full bg-primary/10 blur-3xl"></div>
            <div class="absolute left-0 bottom-0 h-40 w-40 rounded-full bg-slate-200/80 blur-3xl"></div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid items-center gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:gap-14">
                    <div>
                        <nav class="mb-6 text-sm font-medium text-gray-500" aria-label="Breadcrumb">
                            <a href="/" class="transition hover:text-secondary">Beranda</a>
                            <span class="mx-2 text-gray-300">/</span>
                            <span class="text-secondary">Layanan</span>
                        </nav>

                        <span class="inline-flex rounded-full border border-primary/15 bg-primary/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-primary">
                            Daftar Layanan
                        </span>
                        <h1 class="mt-6 max-w-3xl text-4xl font-extrabold leading-tight text-secondary sm:text-5xl lg:text-[3.5rem]">
                            Layanan Legalitas dan Perizinan untuk Bisnis yang Siap Bertumbuh
                        </h1>
                        <p class="mt-5 max-w-2xl text-base leading-8 text-gray-600 sm:text-lg">
                            Pilih layanan yang paling sesuai dengan kebutuhan perusahaan Anda. FastTrack membantu proses legalitas, perizinan, dan kebutuhan pendukung bisnis dengan alur yang lebih rapi dan profesional.
                        </p>

                        <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap">
                            <a
                                href="#daftar-layanan"
                                class="inline-flex items-center justify-center rounded-full bg-primary px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary/20 transition hover:bg-pink-600"
                            >
                                Lihat Semua Layanan
                            </a>
                            <a
                                :href="buildWhatsappLink('kebutuhan legalitas bisnis')"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center justify-center rounded-full border border-gray-300 bg-white px-7 py-3.5 text-sm font-bold text-secondary transition hover:border-secondary hover:bg-gray-50"
                            >
                                Konsultasi via WhatsApp
                            </a>
                        </div>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl border border-gray-200 bg-white px-5 py-5 shadow-sm">
                                <div class="text-2xl font-extrabold text-secondary">{{ services.length }}+</div>
                                <div class="mt-1 text-sm leading-6 text-gray-500">Kategori layanan aktif</div>
                            </div>
                            <div class="rounded-2xl border border-gray-200 bg-white px-5 py-5 shadow-sm">
                                <div class="text-2xl font-extrabold text-secondary">Efisien</div>
                                <div class="mt-1 text-sm leading-6 text-gray-500">Proses dirancang lebih terstruktur</div>
                            </div>
                            <div class="rounded-2xl border border-gray-200 bg-white px-5 py-5 shadow-sm">
                                <div class="text-2xl font-extrabold text-secondary">Profesional</div>
                                <div class="mt-1 text-sm leading-6 text-gray-500">Siap mendukung bisnis yang berkembang</div>
                            </div>
                        </div>

                        <div class="mt-8 space-y-3">
                            <div
                                v-for="point in trustPoints"
                                :key="point"
                                class="flex items-start gap-3 text-sm leading-7 text-gray-600"
                            >
                                <span class="mt-1 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <span>{{ point }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="overflow-hidden rounded-[2rem] border border-gray-100 bg-white p-3 shadow-xl">
                            <img
                                src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80&fm=webp"
                                alt="Layanan legalitas dan perizinan FastTrack"
                                class="h-[280px] w-full rounded-[1.5rem] object-cover sm:h-[360px] lg:h-[440px]"
                            >
                            <div class="absolute inset-x-5 bottom-5 rounded-[1.5rem] border border-white/80 bg-white/95 p-5 shadow-lg backdrop-blur sm:inset-x-8 sm:bottom-8">
                                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-primary">FastTrack Services</div>
                                <div class="mt-2 text-xl font-bold leading-snug text-secondary">
                                    Temukan layanan yang paling relevan untuk kebutuhan bisnis Anda.
                                </div>
                                <div class="mt-3 text-sm leading-7 text-gray-600">
                                    Mulai dari pendirian badan usaha, perizinan, hingga dokumen pendukung perusahaan dengan pengalaman layanan yang lebih jelas dan nyaman.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="daftar-layanan" class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Semua Layanan</span>
                        <h2 class="mt-3 text-3xl font-bold text-secondary sm:text-4xl">
                            Pilih layanan sesuai tahap dan kebutuhan pertumbuhan bisnis Anda
                        </h2>
                        <p class="mt-4 text-base leading-7 text-gray-600">
                            Setiap card layanan dirancang agar mudah dipahami, lebih rapi secara visual, dan nyaman dijelajahi dari desktop maupun mobile.
                        </p>
                    </div>
                    <a
                        :href="buildWhatsappLink('layanan legalitas dan perizinan')"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center rounded-full border border-primary px-6 py-3 text-sm font-bold text-primary transition hover:bg-primary hover:text-white"
                    >
                        Diskusi Kebutuhan Anda
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
                    <article
                        v-for="service in services"
                        :key="service.id"
                        class="group flex h-full cursor-pointer flex-col overflow-hidden rounded-[1.75rem] border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-primary/20 hover:shadow-xl focus-within:ring-2 focus-within:ring-primary/20"
                        role="link"
                        tabindex="0"
                        :aria-label="`Buka detail ${service.name}`"
                        @click="goToService(service.slug)"
                        @keydown.enter="goToService(service.slug)"
                        @keydown.space.prevent="goToService(service.slug)"
                    >
                        <div class="relative overflow-hidden">
                            <img
                                src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1200&q=80&fm=webp"
                                :alt="service.name"
                                class="h-56 w-full object-cover transition duration-500 group-hover:scale-105"
                                loading="lazy"
                            >
                            <div class="absolute left-4 top-4 inline-flex rounded-full bg-white/95 px-3 py-1 text-xs font-bold text-primary shadow-sm">
                                FastTrack
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex flex-1 flex-col">
                                <div class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-400">
                                    Mulai dari
                                </div>
                                <div class="mt-1 text-2xl font-extrabold text-primary">
                                    {{ formatPrice(service.price) }}
                                </div>
                                <h3 class="mt-4 min-h-[4.75rem] text-2xl font-bold leading-tight text-secondary">
                                    {{ service.name }}
                                </h3>
                                <p class="mt-3 min-h-[10rem] text-sm leading-7 text-gray-600">
                                    {{ service.description }}
                                </p>
                            </div>

                            <div class="mt-6 border-t border-gray-100 pt-5">
                                <a
                                    :href="buildWhatsappLink(service.name)"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-primary px-4 py-3 text-sm font-bold text-white shadow-md shadow-primary/20 transition duration-200 hover:-translate-y-0.5 hover:bg-pink-600 hover:shadow-lg hover:shadow-primary/30"
                                    @click.stop
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.143-3.429C3.417 15.243 3 13.666 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    Konsultasi Layanan
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
