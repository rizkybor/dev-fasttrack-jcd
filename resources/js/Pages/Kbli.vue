<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
</script>

<template>
    <MainLayout>
        <section class="bg-white py-20">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-primary">Tips Bisnis</p>
                    <h1 class="mt-4 text-4xl font-extrabold text-secondary md:text-5xl">Panduan KBLI</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Pelajari klasifikasi baku lapangan usaha Indonesia untuk menentukan kategori usaha yang tepat sebelum mengurus legalitas bisnis Anda.
                    </p>
                </div>

                <div class="mt-12 grid gap-6 md:grid-cols-3">
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-6">
                        <h2 class="text-lg font-bold text-secondary">Fungsi KBLI</h2>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Menentukan bidang usaha utama dan pendukung yang akan dicantumkan dalam legalitas perusahaan.</p>
                    </div>
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-6">
                        <h2 class="text-lg font-bold text-secondary">Dampak ke OSS</h2>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Kode KBLI akan memengaruhi proses penerbitan NIB, izin usaha, dan persyaratan tambahan lain.</p>
                    </div>
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-6">
                        <h2 class="text-lg font-bold text-secondary">Konsultasi Tepat</h2>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Tim FastTrack dapat membantu memilih KBLI yang paling sesuai agar bisnis Anda lebih aman secara legal.</p>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
