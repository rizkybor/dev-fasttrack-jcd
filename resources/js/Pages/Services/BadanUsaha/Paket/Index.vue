<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
    packages: {
        type: Array,
        default: () => [],
    },
});

const whatsappNumber = '6282298604144';

const buildWhatsappLink = (topic) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${topic}.`;

    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

const goToPackage = (slug) => {
    window.location.href = `/badan-usaha/paket/${slug}`;
};
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
                            <a href="/badan-usaha" class="transition hover:text-secondary">Pendirian Perusahaan</a>
                            <span class="mx-2 text-gray-300">/</span>
                            <span class="text-secondary">Paket</span>
                        </nav>

                        <span class="inline-flex rounded-full border border-primary/15 bg-primary/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-primary">
                            Paket Pendirian PT
                        </span>
                        <h1 class="mt-6 max-w-3xl text-4xl font-extrabold leading-tight text-secondary sm:text-5xl lg:text-[3.5rem]">
                            Pilih Jenis Paket PT yang Paling Sesuai dengan Model Bisnis Anda
                        </h1>
                        <p class="mt-5 max-w-2xl text-base leading-8 text-gray-600 sm:text-lg">
                            Halaman ini membantu Anda memilih jalur pendirian PT yang lebih tepat, baik untuk kebutuhan bisnis dengan lebih dari satu pemegang saham maupun untuk usaha yang dijalankan sendiri.
                        </p>

                        <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap">
                            <a
                                href="#pilihan-paket"
                                class="inline-flex items-center justify-center rounded-full bg-primary px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary/20 transition hover:bg-pink-600"
                            >
                                Lihat Pilihan Paket
                            </a>
                            <a
                                :href="buildWhatsappLink('paket pendirian PT')"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center justify-center rounded-full border border-gray-300 bg-white px-7 py-3.5 text-sm font-bold text-secondary transition hover:border-secondary hover:bg-gray-50"
                            >
                                Konsultasi via WhatsApp
                            </a>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="overflow-hidden rounded-[2rem] border border-gray-100 bg-white p-3 shadow-xl">
                            <img
                                src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=1200&q=80&fm=webp"
                                alt="Pilihan paket pendirian PT FastTrack"
                                class="h-[280px] w-full rounded-[1.5rem] object-cover sm:h-[360px] lg:h-[430px]"
                            >
                            <div class="absolute inset-x-5 bottom-5 rounded-[1.5rem] border border-white/80 bg-white/95 p-5 shadow-lg backdrop-blur sm:inset-x-8 sm:bottom-8">
                                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-primary">FastTrack Guidance</div>
                                <div class="mt-2 text-xl font-bold leading-snug text-secondary">
                                    Mulai dari struktur yang tepat agar proses legalitas lebih efisien sejak awal.
                                </div>
                                <div class="mt-3 text-sm leading-7 text-gray-600">
                                    Anda bisa membandingkan dua jenis paket PT yang paling sering dipilih sebelum masuk ke konsultasi dan pengurusan dokumen.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="pilihan-paket" class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 max-w-3xl">
                    <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Pilihan Paket</span>
                    <h2 class="mt-3 text-3xl font-bold text-secondary sm:text-4xl">
                        Dua opsi paket yang dirancang untuk kebutuhan usaha yang berbeda
                    </h2>
                    <p class="mt-4 text-base leading-7 text-gray-600">
                        Klik card untuk melihat edukasi, manfaat, dokumen, dan alur proses dari masing-masing jenis paket secara lebih detail.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <article
                        v-for="item in packages"
                        :key="item.slug"
                        class="group flex h-full cursor-pointer flex-col overflow-hidden rounded-[1.9rem] border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-primary/20 hover:shadow-xl focus-within:ring-2 focus-within:ring-primary/20"
                        role="link"
                        tabindex="0"
                        :aria-label="`Buka detail ${item.name}`"
                        @click="goToPackage(item.slug)"
                        @keydown.enter="goToPackage(item.slug)"
                        @keydown.space.prevent="goToPackage(item.slug)"
                    >
                        <div class="relative overflow-hidden">
                            <img
                                :src="item.image"
                                :alt="item.name"
                                class="h-64 w-full object-cover transition duration-500 group-hover:scale-105"
                                loading="lazy"
                            >
                            <div class="absolute left-4 top-4 inline-flex rounded-full bg-white/95 px-3 py-1 text-xs font-bold text-primary shadow-sm">
                                {{ item.tag }}
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-7">
                            <div class="flex flex-1 flex-col">
                                <div class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-400">Mulai dari</div>
                                <div class="mt-1 text-2xl font-extrabold text-primary">{{ item.price_label }}</div>
                                <h3 class="mt-4 text-3xl font-bold leading-tight text-secondary">{{ item.name }}</h3>
                                <p class="mt-4 text-sm leading-7 text-gray-600">{{ item.description }}</p>
                            </div>

                            <div class="mt-6 flex flex-col gap-3 border-t border-gray-100 pt-5 sm:flex-row">
                                <span class="inline-flex items-center rounded-full bg-primary/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-primary">
                                    {{ item.duration }}
                                </span>
                                <a
                                    :href="buildWhatsappLink(item.name)"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center rounded-full border border-primary px-5 py-2.5 text-sm font-bold text-primary transition hover:bg-primary hover:text-white"
                                    @click.stop
                                >
                                    Konsultasi Paket
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
