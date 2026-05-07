<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    service: {
        type: Object,
        required: true,
    },
    products: {
        type: Array,
        default: () => [],
    },
});

const whatsappNumber = '6282298604144';

const buildWhatsappLink = (productName) => {
    const message = `Halo FastTrack, saya ingin konsultasi mengenai ${productName}.`;

    return `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
};

const goToProduct = (detailPath) => {
    window.location.href = detailPath;
};

const processSteps = [
    {
        title: 'Konsultasi Kebutuhan',
        description: 'Kami bantu memetakan bentuk badan usaha yang paling relevan dengan model bisnis Anda.',
    },
    {
        title: 'Persiapan Dokumen',
        description: 'Tim FastTrack menyiapkan checklist, verifikasi data, dan memastikan proses lebih rapi sejak awal.',
    },
    {
        title: 'Pendampingan Sampai Siap',
        description: 'Proses berjalan lebih terarah hingga dokumen utama siap digunakan untuk kebutuhan operasional.',
    },
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
                        <a href="/layanan" class="transition hover:text-secondary">Layanan</a>
                        <span class="mx-2 text-gray-300">/</span>
                        <span class="text-secondary">{{ service.title }}</span>
                    </nav>

                    <span class="inline-flex rounded-full border border-primary/15 bg-primary/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-primary">
                        Product Pendirian
                    </span>
                    <h1 class="mt-6 max-w-3xl text-4xl font-extrabold leading-tight text-secondary sm:text-5xl lg:text-[3.5rem]">
                        Pendirian Usaha yang Lebih Rapi, Jelas, dan Siap Bertumbuh
                    </h1>
                    <p class="mt-5 max-w-2xl text-base leading-8 text-gray-600 sm:text-lg">
                        FastTrack membantu Anda memilih produk pendirian yang paling sesuai dengan kebutuhan bisnis, sehingga proses legalitas terasa lebih sederhana, terarah, dan nyaman diikuti sejak awal.
                    </p>

                    <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:flex-wrap">
                        <a
                            href="#product-pendirian"
                            class="inline-flex items-center justify-center rounded-full bg-primary px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-primary/20 transition hover:bg-pink-600"
                        >
                            Lihat Product
                        </a>
                        <a
                            :href="buildWhatsappLink('layanan pendirian perusahaan')"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center rounded-full border border-gray-300 bg-white px-7 py-3.5 text-sm font-bold text-secondary transition hover:border-secondary hover:bg-gray-50"
                        >
                            Konsultasi via WhatsApp
                        </a>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-gray-200 bg-white px-5 py-5 shadow-sm">
                            <div class="text-2xl font-extrabold text-secondary">8 Produk</div>
                            <div class="mt-1 text-sm leading-6 text-gray-500">Pilihan badan usaha dan organisasi</div>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-white px-5 py-5 shadow-sm">
                            <div class="text-2xl font-extrabold text-secondary">Efisien</div>
                            <div class="mt-1 text-sm leading-6 text-gray-500">Alur proses dirancang lebih terstruktur</div>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-white px-5 py-5 shadow-sm">
                            <div class="text-2xl font-extrabold text-secondary">Profesional</div>
                            <div class="mt-1 text-sm leading-6 text-gray-500">Siap mendukung kebutuhan bisnis yang berkembang</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="overflow-hidden rounded-[2rem] border border-gray-100 bg-white p-3 shadow-xl">
                        <img
                            src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=1200&q=80&fm=webp"
                            :alt="service.title"
                            class="h-[280px] w-full rounded-[1.5rem] object-cover sm:h-[360px] lg:h-[440px]"
                        >
                        <div class="absolute inset-x-5 bottom-5 rounded-[1.5rem] border border-white/80 bg-white/95 p-5 shadow-lg backdrop-blur sm:inset-x-8 sm:bottom-8">
                            <div class="text-xs font-semibold uppercase tracking-[0.22em] text-primary">FastTrack Insight</div>
                            <div class="mt-2 text-xl font-bold leading-snug text-secondary">
                                Tentukan bentuk badan usaha dengan arahan yang lebih terukur.
                            </div>
                            <div class="mt-3 text-sm leading-7 text-gray-600">
                                Cocok untuk founder, owner bisnis, dan organisasi yang ingin memulai dengan dasar legal yang lebih tepat dan siap dipakai untuk operasional.
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </section>

        <section id="product-pendirian" class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Product Pendirian</span>
                        <h2 class="mt-3 text-3xl font-bold text-secondary sm:text-4xl">
                            Pilih produk pendirian yang sesuai dengan tahap pertumbuhan bisnis Anda
                        </h2>
                        <p class="mt-4 text-base leading-7 text-gray-600">
                            Setiap card dirancang agar user cepat memahami jenis badan usaha, estimasi harga awal, dan langkah konsultasi berikutnya.
                        </p>
                    </div>
                    <a
                        :href="buildWhatsappLink('produk pendirian perusahaan')"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center rounded-full border border-primary px-6 py-3 text-sm font-bold text-primary transition hover:bg-primary hover:text-white"
                    >
                        Diskusi Kebutuhan Anda
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
                    <article
                        v-for="product in products"
                        :key="product.id"
                        class="group flex h-full cursor-pointer flex-col overflow-hidden rounded-[1.75rem] border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-primary/20 hover:shadow-xl focus-within:ring-2 focus-within:ring-primary/20"
                        role="link"
                        tabindex="0"
                        :aria-label="`Buka detail ${product.name}`"
                        @click="goToProduct(product.detail_path)"
                        @keydown.enter="goToProduct(product.detail_path)"
                        @keydown.space.prevent="goToProduct(product.detail_path)"
                    >
                        <div class="relative overflow-hidden">
                            <img
                                :src="product.image"
                                :alt="product.name"
                                class="h-56 w-full object-cover transition duration-500 group-hover:scale-105"
                                loading="lazy"
                            >
                            <div class="absolute left-4 top-4 inline-flex rounded-full bg-white/95 px-3 py-1 text-xs font-bold text-primary shadow-sm">
                                {{ product.tag }}
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex flex-1 flex-col">
                                <div class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-400">
                                    Mulai dari
                                </div>
                                <div class="mt-1 text-2xl font-extrabold text-primary">
                                    {{ product.price_label }}
                                </div>
                                <h3 class="mt-4 min-h-[4.75rem] text-2xl font-bold leading-tight text-secondary">
                                    {{ product.name }}
                                </h3>
                                <p class="mt-3 min-h-[10rem] text-sm leading-7 text-gray-600">
                                    {{ product.description }}
                                </p>
                            </div>

                            <div class="mt-6 border-t border-gray-100 pt-5">
                                <a
                                    :href="buildWhatsappLink(product.name)"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-primary px-4 py-3 text-sm font-bold text-white shadow-md shadow-primary/20 transition duration-200 hover:-translate-y-0.5 hover:bg-pink-600 hover:shadow-lg hover:shadow-primary/30"
                                    @click.stop
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.143-3.429C3.417 15.243 3 13.666 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    Teks Custom
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-gray-50 py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 max-w-3xl">
                    <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Alur Layanan</span>
                    <h2 class="mt-3 text-3xl font-bold text-secondary sm:text-4xl">
                        Proses dibuat sederhana agar user tetap nyaman dari awal sampai dokumen siap
                    </h2>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    <div
                        v-for="(step, index) in processSteps"
                        :key="step.title"
                        class="rounded-[1.75rem] border border-gray-100 bg-white p-6 shadow-sm"
                    >
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-lg font-bold text-white">
                            {{ index + 1 }}
                        </div>
                        <h3 class="mt-5 text-xl font-bold text-secondary">{{ step.title }}</h3>
                        <p class="mt-3 text-sm leading-7 text-gray-600">{{ step.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="detail" class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid items-start gap-10 lg:grid-cols-[0.95fr_1.05fr]">
                    <div class="rounded-[2rem] bg-secondary p-8 text-white shadow-xl">
                        <span class="text-sm font-semibold uppercase tracking-[0.25em] text-primary">Kenapa FastTrack</span>
                        <h2 class="mt-4 text-3xl font-bold">Pendampingan legal yang tetap edukatif dan mudah diikuti</h2>
                        <p class="mt-4 text-base leading-8 text-slate-200">
                            Kami tidak hanya menyiapkan dokumen, tetapi juga membantu user memahami pilihan badan usaha agar keputusan yang diambil lebih tepat untuk kebutuhan bisnis jangka pendek maupun jangka panjang.
                        </p>
                        <a
                            :href="buildWhatsappLink('pendirian perusahaan')"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-8 inline-flex rounded-full bg-primary px-6 py-3 font-bold text-white transition hover:bg-pink-600"
                        >
                            Konsultasi Sekarang
                        </a>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div
                            v-for="product in products.slice(0, 4)"
                            :key="`mini-${product.id}`"
                            class="rounded-[1.5rem] border border-gray-100 bg-gray-50 p-5"
                        >
                            <h3 class="text-lg font-bold text-secondary">{{ product.name }}</h3>
                            <p class="mt-2 text-sm font-semibold text-primary">Mulai dari {{ product.price_label }}</p>
                            <p class="mt-3 text-sm leading-7 text-gray-600">{{ product.excerpt }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
